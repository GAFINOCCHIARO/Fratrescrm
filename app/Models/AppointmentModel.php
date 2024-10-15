<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table            = 'appointment';
    protected $primaryKey       = 'id_appointment';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\AppointmentEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_association',
        'id_user',
        'appointmentdate',
        'exsamtype',
        'stateofappointment',
        'appointmentHour',
        'userNote',
        'agendacode'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAppointmentsByDateToWork($date, $companyId)
    {
        return $this->select('*')
            ->where('id_association', $companyId)
            ->where('appointmentdate', $date)
            ->where('stateofappointment',0)
            ->where('stateofappointment',1)
            ->findAll();
    }
    public function getAppointmentsBycomopany($idcompany, $agendacode)
    {
        return $this->select('*')
            ->where('id_association', $idcompany)
            ->orWhere('agendacode', $agendacode)
            ->findAll();
    }
    // Metodo per ottenere appuntamenti con join su user e company
    public function getPendingAppointmentsWithDetails($associationId, $agendaCode)
    {  

         return $this->select('appointment.*, company.*, users.*')
                    ->join('company', 'company.id_company = appointment.id_association', 'inner')
                    ->join('users', 'appointment.id_user = users.id', 'inner')
                    ->where('appointment.id_association', $associationId)
                    ->where('stateofappointment',0)
                    ->orWhere('appointment.agendacode', $agendaCode)
                    ->findAll();
    }
     public function getConfirmedAppointmentsWithDetails($associationId, $agendaCode)
    {  

         return $this->select('appointment.*, company.*, users.*')
                    ->join('company', 'company.id_company = appointment.id_association', 'inner')
                    ->join('users', 'appointment.id_user = users.id', 'inner')
                    ->where('appointment.id_association', $associationId)
                    ->where('stateofappointment',1)
                    ->orWhere('appointment.agendacode', $agendaCode)
                    ->findAll();
    }
     public function getConfirmedAppointmentsBydate($associationId, $agendaCode,$Day)
    {  

         return $this->select('appointment.*, company.*, users.*')
                    ->join('company', 'company.id_company = appointment.id_association', 'inner')
                    ->join('users', 'appointment.id_user = users.id', 'inner')
                    ->where('appointment.id_association', $associationId)
                    ->where('stateofappointment',1)
                    ->orWhere('appointment.agendacode', $agendaCode)
                    ->where('appointmentdate',$Day)
                    ->findAll();
    }
     public function getAppointmentsById($associationId, $agendaCode,$id)
    {  

         return $this->select('appointment.*, company.*, users.*')
                    ->join('company', 'company.id_company = appointment.id_association', 'inner')
                    ->join('users', 'appointment.id_user = users.id', 'inner')
                    ->where('appointment.id_association', $associationId)
                    ->orWhere('appointment.agendacode', $agendaCode)
                     ->where('appointment.id_appointment ',$id)
                    ->findAll();
    }
     public function getappointmentobj($id)
    {
    
        
        return  $this->select('*')
                     ->where('id_appointment ',$id)
                     ->first();
    }

    public function getAppointmentsByDate($date, $companyId)
    {
        return $this->select('*')
            ->where('id_association', $companyId)
            ->where('appointmentdate', $date)
            
            ->findAll();
    }
}
