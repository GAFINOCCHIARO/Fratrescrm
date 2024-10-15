<?php

namespace App\Controllers;

use App\Models\BusinessHoursModel as hoursmodel;
use App\Models\CompanyModels as companymodel;
use App\Models\RepetitiveappointmentModel as RepAppoint;
use App\Models\AppointmentModel as AppointmentModel;
use App\Models\EventCalendarModel as eventcalendar;
use App\Entities\AppointmentEntity as appointmententity;
use App\Libraries\EmailManager;
use PharIo\Manifest\Type;

class Appointments extends BaseController
{

    public function ManageCalendar()
    {
        $user = auth()->user();
        $company = new companymodel();
        $companydata = $company->find($user->id_association);
        $WorkingHours = new hoursmodel();
        $dataWorkingHours = $WorkingHours->getBusinessHoursByCompany($user->id_association);
        $RepAppoints = new RepAppoint();
        $dataRepititiveAppointment = $RepAppoints->getRepetitiveAppointmentByCompany($user->id_association);
        $event = new eventcalendar();
        $eventlist = $event->getEventlist($user->id_association, $company->agenda_code);
        //   var_dump($dataRepititiveAppointment);

        return view('Adminview\appointmentsview', [
            'companydata' => $companydata,
            'dataWorkingHours' => $dataWorkingHours,
            'repetitiveappoint' => $dataRepititiveAppointment,
            'eventlist' => $eventlist,
        ]);
    }

    public function insertRepetitiveDays()
    {
        $user = auth()->user();
        $request = service('request');
        $companydata = $this->getcompanyobj($user->id_association);
        helper(['form', 'url']);
        if ($this->request->isAJAX() && $this->request->is('post')) {
            $token = csrf_hash();
            $postData = $request->getPost();
            $request = service('request');
            helper(['form', 'url']);
            if (isset($postData['data'])) {
                $RepAppoints = new RepAppoint();
                $RepAppoints->where('idcompany', $user->id_association)
                    ->delete();
                foreach ($postData['data'] as $day => $times) {
                    $Data = [
                        'idcompany' => $user->id_association,
                        'day_of_week_appointment' => $day,
                        'morning_open_time' =>   !empty($times['open_time1']) ? $times['open_time1'] : null,
                        'morning_close_time' =>  !empty($times['close_time1']) ? $times['close_time1'] : null,
                        'afternoon_open_time' => !empty($times['open_time2']) ? $times['open_time2'] : null,
                        'afternoon_close_time' => !empty($times['close_time2']) ? $times['close_time2'] : null,
                        'company_agenda_code' => ($times['visibility'] === true || $times['visibility'] === 'true' || $times['visibility'] == 1) ? $companydata->agenda_code : 0,
                        'isadonationday' => true,
                    ];

                    $RepAppoints->save($Data);
                }

                $risposta = [
                    'msg' => 'ok',
                    'token' => $token,
                    'status' => lang('Auth.satusok'),
                ];
            } else {
                $risposta = [
                    'msg' => 'no data to insert',
                    'token' => $token,
                    'status' => lang('Auth.statuserror'),
                ];
            }

            return $this->response->setJSON($risposta);
        }
    }
    public function addevent()
    {
        $user = auth()->user();
        $company = new companymodel();
        $companydata = $company->find($user->id_association);
        $request = service('request');
        helper(['form', 'url']);
        if ($this->request->isAJAX() && $this->request->is('post')) {
            $token = csrf_hash();
            $postData = $request->getPost();
            $request = service('request');
            $newevent = new eventcalendar();
            $data = [
                'idcompany' => $companydata->id_company,
                'day_event' => $postData['eventdata'],
                'start_time' => $postData['timestart'],
                'end_time' => $postData['timeend'],
                'place_event' => $postData['placeevent'],
                'company_agenda_code' => null,
            ];
            $newevent->save($data);
            $risposta = [
                'record' => $data,
                'token' => $token,
            ];
            header('Content-Type: application/json');

            return $this->response->setJSON($risposta);
        }
    }
    private function calculateAvailableSlots($appointments, $examDuration, $timeRange)
    {
        $user = auth()->user();
        $companydata = $this->checkidcompany($user->id_association);
        list($startTimeString, $endTimeString) = explode('/', $timeRange);
        $startTime = new \DateTime($startTimeString); // Ora di inizio lavoro
        $endTime = new \DateTime($endTimeString); // Ora di fine lavoro

        // Inizializza la disponibilità delle fasce orarie
        $availableSlots = [];
        while ($startTime < $endTime) {
            $availableSlots[$startTime->format('H:i')] = $companydata->number_armchairs; // posti disponibili per ogni fascia
            $startTime->modify("+$examDuration minutes");
        }

        // Itera su tutte le prenotazioni esistenti e riduce i posti disponibili
        foreach ($appointments as $appointment) {
            $appointmentTime = new \DateTime($appointment->appointmentHour);
            $appointmentEnd = (clone $appointmentTime)->modify("+{$examDuration} minutes");

            while ($appointmentTime < $appointmentEnd) {
                $slot = $appointmentTime->format('H:i');
                if (isset($availableSlots[$slot])) {
                    $availableSlots[$slot]--;
                    if ($availableSlots[$slot] <= 0) {
                        unset($availableSlots[$slot]);
                    }
                }
                $appointmentTime->modify("+ $examDuration minutes");
            }
        }

        // Ritorna solo gli slot orari che hanno ancora disponibilità
        //dd(array_keys($availableSlots));
        return array_keys($availableSlots);
    }
    private function checkidcompany($iduserassociation){
        $company= $this->getcompanyobj($iduserassociation);
        if ($company->agendacoderefer =!null) {
            $id=explode('-', $company->agendacoderefer);
            return $id[0];
        }else{
            return $iduserassociation;
        }
    }
    public function check($date, $examType, $timeRange,$type=0)
    {

        // Modello per gestire gli appuntamenti
        $appointmentModel = new AppointmentModel();

        // Recupera la durata dell'esame 
        $examDuration = $this->getExamDuration($examType);

        // Recupera le prenotazioni esistenti per la data selezionata
        $user = auth()->user();
        // verifico se il tipo di donazione è ordinaria (valore
        // 0) e quindi può essere fatta solo da associazioni autorizzate
        if ($type==0) {
            $Idassociation = $this->checkidcompany($user->id_association); //se vale 0 cerco l'associazione di riferimento
        }else{ 
              $Idassociation =$user->id_association; // se non vale 0 allora  è una donazone in 
                                                    //autoemoteca l'id dell'associazione è quella dell'utente
        }
        
        $appointments = $appointmentModel->getAppointmentsByDateToWork($date, $Idassociation);//calcoliamo i posti e gli slot

        // Calcola le fasce orarie disponibili
        $availableSlots = $this->calculateAvailableSlots($appointments, $examDuration, $timeRange);

        // Restituisci la risposta come JSON
        return $availableSlots;
    }
    private function getExamDuration($examType)
    {
        $durations = [
            'dplasma' => 60,
            'dpiastrine' => 0,
            'dsangue' => 10,
        ];

        return $durations[$examType] ?? 60;
        /*
        $companydata = $this->getcompanyobj();
        return $companydata->$examType;
        */
    }
    public function saveanewappointment($day, $examType, $timeexsam, $note)
    {
        $user = auth()->user();
        $companydata = $this->getcompanyobj($user->id_association);
       
        $new = [
            'id_association' => $user->id_association,
            'id_user' => $user->id,
            'appointmentdate' => $day,
            'exsamtype' => $examType,
            'stateofappointment' => 0,
            'appointmentHour' => $timeexsam,
            'userNote' => $note,
            'agendacode' => $companydata->agendacoderefer,
        ];
        $appointmententity = new appointmententity();
        $appointmententity->fill($new);
        $savenewapponintment = new AppointmentModel();
        if ($savenewapponintment->save($appointmententity)) {
            return true;
        } else {
            return false;
        };
    }
    public function delevent()
    {
        $token = csrf_hash();
        $appointmentModel = new eventcalendar();
        $user = auth()->user();
        $id = $this->request->getPost('id');
        $del = $appointmentModel->where('id_eventcalendar ', $id)
            ->where('idcompany ', $user->id_association)
            ->delete();
        if ($del) {
           $response=[
            'id'=>$id,
            'token'=>$token,
            'msg'=>'ok',
           ];
        }else{
            $response=[
            'id'=>$id,
            'token'=>$token,
            'msg'=>'fail',
           ];
        }
        return $this->response->setJSON($response);
    }
    private function getcompanyobj($id)
    {
        $company = new companymodel();
        $companydata = $company->find($id);
        return ($companydata);
    }
    public function appointmentdettail()
    {
       $user = auth()->user();
       $token = csrf_hash(); 
       $appointment =new AppointmentModel();
        $id = $this->request->getPost('id');
         $companydata = $this->getcompanyobj($user->id_association);
        $appointmentdettail= $appointment->getAppointmentsById($user->id_association,$companydata->agenda_code,$id);
       if ($appointmentdettail){
        $risposta = [
                'msg' => 'ok',
                'token' => $token,
                'appointmentdettail' => $appointmentdettail,
            ];
        
            return $this->response->setJSON($risposta);
       }else{
        $risposta = [
                'msg' => 'fail',
                'token' => $token,
                'error' => lang('Auth.noresult'),
            ];
        
            return $this->response->setJSON($risposta);
       }
        
    }
    public function appointmentconfirm()
    {
        $users= auth()->user();
        $token= csrf_hash();
        $id=$this->request->getPost('id');
        $iduser=$this->request->getPost('iduser');
        $appointment = new AppointmentModel();
        $confirm= $appointment->where('id_appointment ',$id)
                            ->set('stateofappointment',1)
                            ->update();
        if ($confirm) {
            $response=[
                'msg'=>'ok',
                'token'=>$token
            ];
            $emailManager = new EmailManager();
            $emailManager->getMessage('exsamconfirm',$users->id_association,$iduser,$id);
            
        } else{
            $response=[
                'msg'=>'fail',
                'token'=> $token,
                'er'=> lang('Auth.noupdate'),          
            ];
            
        }

        return $this->response->setJSON($response);
    }
}

