<?php

namespace App\Models;

use CodeIgniter\Model;

class RepetitiveappointmentModel extends Model
{
    protected $table            = 'repetitiveappointments';
    protected $primaryKey       = 'idrepetitiveappointment ';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\RepetitiveappointmentEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idcompany', 'day_of_week_appointment', 'morning_open_time', 'morning_close_time',
                                   'afternoon_open_time', 'afternoon_close_time','company_agenda_code','isadonationday'];

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

 public function getRepetitiveAppointmentByCompany($companyId)
    {
        return $this->select('*')
                    ->where('idcompany', $companyId)
                    ->orderBy('FIELD(day_of_week_appointment, "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato", "Domenica")')
                    ->findAll();
    }

}
