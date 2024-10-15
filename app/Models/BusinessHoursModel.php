<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\App;

class BusinessHoursModel extends Model
{
    protected $table            = 'business_hours';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\BusinessHoursEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'company_id',
        'day_of_week',
        'open_time1',
        'close_time1',
        'open_time2',
        'close_time2'
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

    public function getBusinessHoursByCompany($companyId)
    {
        return $this->select('business_hours.*, company.company_name')
            ->join('company', 'business_hours.company_id = company.id_company')
            ->where('business_hours.company_id', $companyId)
            ->orderBy('FIELD(business_hours.day_of_week, "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato", "Domenica")')
            ->findAll();
    }
    public function isBusinesHoursComplete($companyId)
    {
        $companyData = $this->select('*')
            ->where('company_id', $companyId);
        $daysOfWeek = ['lunedì', 'martedì', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica'];
        // Controlla se ci sono valori non null per gli orari di apertura e chiusura
        foreach ($daysOfWeek as $day) {
            if (!is_null($companyData->open_time1) || !is_null($companyData->close_time1)) {
                return true; // Registrazione completata
            }
            if (!is_null($companyData->open_time2) || !is_null($companyData->close_time2)) {
                return true; // Registrazione completata
            }
        }

        return false; // Registrazione non completata
    
    }
}
