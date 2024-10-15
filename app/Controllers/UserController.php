<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BusinessHoursModel as hoursmodel;
use App\Models\CompanyModels as companymodel;
use App\Models\RepetitiveappointmentModel as RepAppoint;
use App\Models\EventCalendarModel as eventcalendar;
use App\Controllers\Appointments as checkappoint;
use CodeIgniter\Validation\StrictRules\Rules;
use CodeIgniter\I18n\Time;
use DateTime;
use DateInterval;
use DatePeriod;

class UserController extends BaseController
{
    public function index()
    {
        $user = auth()->user();
        if (auth()->user()->requiresPasswordReset()) {
            return redirect()->to('ForceResetPassword');
        }
        // file report

        $directory = WRITEPATH . '/referti/' . $user->Tax_code . '/';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $ReportFiles = array_diff(scandir($directory), ['.', '..']);
        $fileList = [];


        foreach ($ReportFiles as $file) {
            // Estrai il timestamp e il nome originale del file
            $parts = explode('_', $file, 3);
            if (count($parts) == 3) {
                $idexsam = $parts[0];
                $timestamp = $parts[1];
                $originalFilename = $parts[2];
                $fileList[] = [
                    'display_name' => $originalFilename,
                    'filename' => $file, // Manteniamo il nome completo con timestamp per il download
                    'timestamp' => $timestamp,
                    'idexsam' => $idexsam,
                ];
            }
        }

        // file avatar
        $directoryavatar = './assets/avatar/';
        $files = array_diff(scandir($directoryavatar), ['.', '..']);
        $data['list'] = [
            'pathavatar' => $files,
            'avatar' => $user->avatar,
            'autorizzato' => $user->authorized,
            'listfile' => $fileList,
            'showreport' => (empty($fileList)) ? 'Nessun report presente ' : 'Elenco report disponibili',
        ];

        echo view('header');

        return view('user\UserHomepage', $data);
    }

    public function UpdateAvatarimage()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = [];

        // Read new token and assign in $response['token']
        $response['token'] = csrf_hash();
        $data = [];

        if (isset($postData['avatar'])) {
            $avatar = $postData['avatar'];
            $user = auth()->user();
            $user->avatar = $avatar;
            $model = new UserModel();
            $model->save($user);
            $data[] = [
                'newavatar' => $avatar,
            ];
        }
        $response['data'] = $data;

        return $this->response->setJSON($response);
    }
    public function  Userappointment()
    {
        $token = csrf_hash();
        $listappoint = new RepAppoint();
        $company = new companymodel;
        $user = auth()->user();
        $companydata = $company->find($user->id_association);
        $appointements = $listappoint->select('repetitiveappointments.*,')
            ->where('repetitiveappointments.idcompany', $user->id_association)
            ->orWhere('repetitiveappointments.company_agenda_code', $companydata->agenda_code)
            ->findAll();
        $currentDate = new DateTime();
        $endDate = (clone $currentDate)->add(new DateInterval('P30D'));
        $scheduledDays = [];
        $period = new DatePeriod($currentDate, new DateInterval('P1D'), $endDate);

        foreach ($period as $date) {
            $dayOfWeek = $this->translateDayOfWeek($date->format('l'));

            foreach ($appointements as $appointment) {
                if ($appointment->day_of_week_appointment === $dayOfWeek) {
                    //   oggetto stdClass per ogni giorno pianificato
                    $scheduledDay = new \stdClass();
                    $scheduledDay->date = $date->format('d-m-Y');
                    $scheduledDay->day = $dayOfWeek;
                    $scheduledDay->morning_open_time = $appointment->morning_open_time ?? null;
                    $scheduledDay->morning_close_time = $appointment->morning_close_time ?? null;
                    $scheduledDay->afternoon_open_time = $appointment->afternoon_open_time ?? null;
                    $scheduledDay->afternoon_close_time = $appointment->afternoon_close_time ?? null;
                    $scheduledDay->place = $companydata->company_name . ' ' .
                        $companydata->company_address . ' ' .
                        $companydata->company_city . ' ';
                    $scheduledDay->idcompany = $appointment->idcompany;
                    $scheduledDay->type = 'cyclical';
                    // Aggiungi l'oggetto all'array
                    $scheduledDays[] = $scheduledDay;
                }
            }
        }

        return view('user\calendarview', [
            'appuntamenti' => $scheduledDays,
        ]);
    }

    private function translateDayOfWeek($day)
    {
        $days = [
            'Monday' => 'Lunedì',
            'Tuesday' => 'Martedì',
            'Wednesday' => 'Mercoledì',
            'Thursday' => 'Giovedì',
            'Friday' => 'Venerdì',
            'Saturday' => 'Sabato',
            'Sunday' => 'Domenica',
        ];

        return $days[$day] ?? null;
    }
    public function checkAvailability()
    {
        $token = csrf_hash();
        $date = $this->request->getPost('date');
        $examType = $this->request->getPost('exam_type');
        $timeRange = $this->request->getPost('timeRange');
        //  per gestire gli appuntamenti
        $appoint = new checkappoint();
        $availableSlots = $appoint->check($date, $examType, $timeRange);
        $response = [
            'time' => $availableSlots,
            'token' => $token,
        ];

        // Restituisce la risposta come JSON
        return $this->response->setJSON($response);
    }
    public function slot_time()
    {
        $token = csrf_hash();
        $validation = \Config\Services::validation();
        $day = $this->request->getPost('day');

        $validation->setRules([
            'day' => 'required|in_list[Lunedì,Martedì,Mercoledì,Giovedì,Venerdì,Sabato,Domenica]'
        ]);

        if (!$this->validate($validation->getRules())) {
            return $this->response->setJSON(['error' => 'Input non valido.']);
        }

        $listappoint = new RepAppoint();
        $company = new companymodel;
        $user = auth()->user();
        $companydata = $company->find($user->id_association);

        $dayhours = $listappoint->select('*')
            ->where('day_of_week_appointment', $day)
            ->groupStart()
            ->where('repetitiveappointments.idcompany', $user->id_association)
            ->orWhere('repetitiveappointments.company_agenda_code', $companydata->agenda_code)
            ->groupEnd()
            ->findAll();

        if (empty($dayhours)) {
            return $this->response->setJSON(['error' => 'Nessun appuntamento trovato per il giorno selezionato.']);
        }

        $firstAppointment = $dayhours[0];

        $timeslot = [
            'mattina' => ($firstAppointment->getMorningOpenTime() && $firstAppointment->getMorningCloseTime())
                ?  $firstAppointment->getMorningOpenTime() . '/' . $firstAppointment->getMorningCloseTime()
                : '',

            'pomeriggio' => ($firstAppointment->getAfternoonOpenTime() && $firstAppointment->getAfternoonCloseTime())
                ? $firstAppointment->getAfternoonOpenTime() . '/' . $firstAppointment->getAfternoonCloseTime()
                : '',
        ];

        $examType = [
            'dplasma' => $companydata->dplasma,
            'dpiastrine' => $companydata->dpiastrine,
            'dsangue' => $companydata->dsangue,

        ];
        $translatedExams = [];
        foreach ($examType as $key => $value) {
            $lang_key = "Auth." . $key; // Creiamo la chiave dinamica per la traduzione
            $translatedExams[$key] = [
                'value' => $value,
                'label' => lang($lang_key) // richiedo la traduzione 
            ];
        }
        $response = [
            'timeslots' => $timeslot,
            'exams' => $translatedExams,
            'token' => $token,
        ];

        return $this->response->setJSON($response);
    }
    public function saveappointment()
    {
        $token = csrf_hash();
        $rules = [
            'day' => [
                'rules' => [
                    'required',
                ],
            ],
            'exam_type' => [
                'rules' => [
                    'in_list[dpiastrine,dplasma,dsangue]',
                ],
            ],
            'timeexsam' => [
                'rules' => [
                    'required',

                ],
            ],
            'note' => [
                'rules' => [
                    'required',
                    'max_length[200]',
                    'min_length[20]',

                ],
            ],

        ];
        $error = [
            'day' => [
                'required' =>  lang('Auth.daterequired'),
                'valid_date' => lang('Auth.datenotvalid')
            ],
            'exam_type' => [
                'in_list' => lang('Auth.dresultInlist'),
            ],
            'timeexsam' => [
                'required' => lang('timeexsamrequired')
            ],
            'note' => [
                'required' => lang('Auth.noterequired'),
                'max_length' => lang('Auth.notemaxlength'),
                'min_length[' => lang('Auth.notemin_length'),
            ],

        ];
        if (!$this->validate($rules, $error)) {
            $data = $this->validator->getErrors();
            foreach ($data as $error) {
                $er[] = $error;
            }
            $risposta = [
                'msg' => 'fail',
                'listerror' => $er,
                'token' => $token,
                'aer' => $data,
            ];
            header('Content-Type: application/json');

            return $this->response->setJSON($risposta);
        } else {
            $appoint = new checkappoint();

            $day = $this->request->getPost('day');
            $examType = $this->request->getPost('exam_type');
            $timeexsam = $this->request->getPost('timeexsam');
            $note = $this->request->getPost('note');
            $date = DateTime::createFromFormat('d-m-Y', $day);
            $formattedDate = $date->format('Y-m-d');
            $timeParts = explode(':', $timeexsam); // Dividi la stringa in ore e minuti

            //   ci sono almeno ore e minuti?
            if (count($timeParts) >= 2) {
                $hours = (int)$timeParts[0];  // Estrai le ore
                $minutes = (int)$timeParts[1]; // Estrai i minuti
                $seconds = 0; //  aggiungere manualmente i secondi come 0

                //  oggetto DateTime usando createFromTime
                $time = Time::createFromTime($hours, $minutes, $seconds);


                $formattedTime = $time->toTimeString();
            }
            $save =  $appoint->saveanewappointment($formattedDate, $examType, $formattedTime, $note);
            if ($save) {
                $response = [
                    'token' => $token,
                    'msg' => 200,
                    'okmsg'=> lang('Auth.okmsg'),
                ];
                return $this->response->setJSON($response);
            }
        }
    }
}
