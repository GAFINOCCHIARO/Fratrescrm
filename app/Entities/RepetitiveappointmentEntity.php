<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RepetitiveappointmentEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
    public function getMorningOpenTime(): ?string
    {
        return $this->attributes['morning_open_time'] ?? null;
    }

    /**
     * Metodo getter per morning_close_time
     *
     * @return string|null
     */
    public function getMorningCloseTime(): ?string
    {
        return $this->attributes['morning_close_time'] ?? null;
    }
    public function getAfternoonOpenTime(): ?string
    {
        return $this->attributes['afternoon_open_time'] ?? null;
    }

    /**
     * Metodo getter per morning_close_time
     *
     * @return string|null
     */
    public function getAfternoonCloseTime(): ?string
    {
        return $this->attributes['afternoon_close_time'] ?? null;
    }
}
