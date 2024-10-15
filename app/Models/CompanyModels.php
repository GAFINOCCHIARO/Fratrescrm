<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModels extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'company';
    protected $primaryKey       = 'id_company';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\CompanyEntities::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_company',       'company_name', 'company_group', 'company_address', 'company_city', 
        'company_phone',     'company_vat', 'company_email', 'company_site_url','president_name', 
        'number_armchairs', 'agenda_code', 'registration_date', 'subscription_expires', 'number_renewals',
        'dplasma','dpiastrine','dsangue','agendacoderefer'
        ];
    
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

    public function check_registration_state($id){
       $check= $this->select('president_name, number_armchairs')
             ->where('id_company ',$id)
             ->first();
    if (($check->president_name==null)&&($check->number_armchairs==null)){
      return false ;     
    }else{
        return true ; 
      }
    }
}
