<?php

namespace App\Libraries;
use App\Models\AppointmentModel as appointmentModel ;
use App\Models\CompanyModels as ModelCompany;
use App\Models\Emailtext;
use App\Config\EmailMessagge;

class EmailManager
{
    protected $emailModel;

    public function __construct()
    {
        $this->emailModel = new Emailtext();
    }
    private function changeplaceholder($bodymessage, $idassociation, $iduser, $idappointment)
    {
       
        $user = auth()->user();
        $user = auth()->getProvider();
        $user = $user->findById($iduser); //oggetto cliente o donatore
        if ($user->id_association === $idassociation) {  // se utente della stessa compagnia
            $company = $this->getcompanyobj($user->id_association);
            $replayto = $company->company_email;
            $to = $user->email;
            $from = $company->company_email;
            $companyName = $company->company_name;
            $oggetto = $bodymessage['subject'];
            $companyName = $company->company_name;
            $text = $bodymessage['body'];
            $luogo=trim($company->company_name) . ' ' . $company->company_address . ' ' . $company->company_city;
        } else { //altrimeti crea nuovo oggetto della compagni di appartenenza
            $exsamcompany = $this->getcompanyobj($idassociation); ///compagnida che esegue il test
            $company = $this->getcompanyobj($user->id_association); //compagnida cdi appartenenza
            $replayto = $exsamcompany->company_email;
            $to = $user->email;
            $from = $company->company_email;
            $companyName = $company->company_name;
            $oggetto = $bodymessage['subject'];
            $companyName = $company->company_name;
            $text = $bodymessage['body'];
             $luogo=trim($exsamcompany->company_name) . ' ' . $exsamcompany->company_address . ' ' . $exsamcompany->company_city;
        }
         if (is_numeric($idappointment) && $idappointment > 0) {
             $appointments= new appointmentModel();
              $appointmentDetail= $appointments->getappointmentobj($idappointment);
             }
        $emailData = [
            '{nome}' => $user->first_name,
            '{Cognome}' => $user->surname,
            '{nomeassociazione}' => trim($company->company_name),
            '{indirizzoassociazione}' => $company->company_address,
            '{cittaassociazione}' => $company->company_city,
            '{mailassoc}' => $company->company_email,
            '{telefonoassociazione}' => $company->company_phone,
            '{linksitoassociazione}' => $company->company_site_url,
            '{luogo_appuntamento}' => $luogo, 
            '{sitoreferti}' => base_url() . 'login',
            '{data_appuntamento}'=>isset($appointmentDetail) ?$appointmentDetail->appointmentdate:null,
            '{ora_appuntamento}'=> isset($appointmentDetail) ?$appointmentDetail->appointmentHour:null,
        ];
        $this->send(str_replace(array_keys($emailData), $emailData, $text), $oggetto, $replayto, $from, $to, $companyName);
    }
    public function getMessage($type, $idassociation, $iduser, $idappointment = 0)
    {
        // Controlla se esiste un messaggio personalizzato
        $customMessage = $this->emailModel->getCustomMessage($type, $idassociation);

        if ($customMessage) {
            $this->changeplaceholder($customMessage, $idassociation, $iduser,$idappointment);
        }

        // Se non esiste un messaggio personalizzato, utilizza il messaggio di default
        $this->changeplaceholder(EmailMessagge::getMessage($type), $idassociation, $iduser, $idappointment);
    }

    private function send($template, $oggetto, $replayto, $from, $to, $companyName)
    {


        $emailConfig = new \Config\Email();

        $email = \Config\Services::email();

        // Usa l'indirizzo configurato nel file e imposta il nome dell'azienda
        $email->setFrom($emailConfig->fromEmail, 'info');
        $email->setTo($to);
        $email->setCC($from);
        $email->setSubject($oggetto);
        $email->setMessage($template);
        $email->setReplyTo($replayto, $companyName);
        $email->send();
    }

    private function getcompanyobj($id)
    {
        $company = new ModelCompany();
        $companydata = $company->find($id);
        return ($companydata);
    }
}
