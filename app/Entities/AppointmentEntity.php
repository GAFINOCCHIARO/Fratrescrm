<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Trait\StringCaseConverter;

class AppointmentEntity extends Entity
{
    use StringCaseConverter;
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
    protected $attributes = [
        'appointmentdate',
        'exsamtype',
        'stateofappointment',
        'appointmentHour',
        'userNote',
        'agendacode'
    ];

    public function getAppointmentdate()
    {
        return $this->formatItDateTime($this->attributes['appointmentdate']);
    }

    public function getStateOfAppointment(): string
    {
        switch ($this->attributes['stateofappointment']) {
            case 0:
                return 'Pending';
            case 1:
                return 'Confirmed';
            case 2:
                return 'worked';
            case 90:
                return 'Cancelled by association';
            case 80:
                return 'Candelled By user';
            default:
                return 'Unknown'; // Stato non riconosciuto
        }
    }


    // Usa il mutator per formattare automaticamente la nota dell'utente
    public function getUserNote()
    {
        return $this->getString($this->attributes['userNote']);
    }
}
