<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,
             'surname',
             'address',
             'City_of_residence',
             'Province_of_residence',
             'state_of_residence',
             'zip_code',
             'phone_number',
             'Tax_code',
             'date_of_birth',
             'birth_status',
             'County_of_birth',
             'birth_place',
             'zip_codebirth',
             'document_type',
             'document_number',
             'user_type',
             'avatar',
             'unique_code',
             'authorized',
             'first_name' ,
             'id_association',
             'group_type',
             'rh_factor',
             'phenotype',
             'kell',
             'gender',
             
        ];
    }
}