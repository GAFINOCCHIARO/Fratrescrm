<?php

namespace App\Models;

use CodeIgniter\Model;

class EventCalendarModel extends Model
{
    protected $table = 'event_calendar';
    protected $primaryKey = 'id_eventcalendar';
    protected $useAutoIncrement = true;
    protected $returnType = \App\Entities\EventCalendarEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['idcompany', 'day_event', 'start_time', 'end_time', 'place_event','company_agenda_code',
                                'dsangue', 'dpiastrine', 'dplasma'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getEventlist($companyId, $agendacode)
    {
        return $this->select('*')
                    ->where('idcompany ', $companyId)
                    // ->where('company_agenda_code',$agendacode)
                    ->findAll();
    }
}
