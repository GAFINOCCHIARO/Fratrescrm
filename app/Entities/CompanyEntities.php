<?php

namespace App\Entities;
use App\Trait\StringCaseConverter;
use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;
class CompanyEntities extends Entity
{
    use StringCaseConverter;
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
    protected $attributes=[
         'company_name', 'company_group', 'company_address', 
         'company_city', 'company_vat', 'president_name', 
         'registration_date','subscription_expires', 
    ];

    public function getRegistration_date()
    {
        return $this->formatItDateTime($this->attributes['registration_date']);
    }

     public function getSubscription_expires()
    {
        return $this->formatItDateTime($this->attributes['subscription_expires']);
    }

    public function getCompanyname()
    {
        return $this->getString($this->attributes['company_name']);
    }

     public function getCompanygroup()
    {
        return $this->getString($this->attributes['company_group']);
    }

      public function getCompanyaddress()
    {
        return $this->getString($this->attributes['company_address']);
    }

      public function getCompanycity()
    {
        return $this->getString($this->attributes['company_city']);
    }

      public function getPresidentname()
    {
        return $this->getString($this->attributes['president_name']);
    }



    public function day()
    {
       return $myTime = Time::today();
    }
    public function subscription_expires()
    {
        return ($this->day()->addMonths(1));
    }

}
