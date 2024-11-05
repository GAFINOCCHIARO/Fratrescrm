<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;
use Config\Encryption;
class UserModel extends ShieldUserModel
{
   
    // protected $returnType = 'App\Entities\UserEntity'; // Uso la mia entità personalizzata
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
            'first_name',
            'id_association',
            'group_type',
            'rh_factor',
            'phenotype',
            'kell',
            'gender',
            'salt',
        ];

    }

    protected function encryptData($data)
    {
        $encryption= service('encrypter');
        return bin2hex($encryption->encrypt($data));
    }

    protected function decryptData($data)
    {
        $encryption = service('encrypter');
        return $encryption->decrypt(hex2bin($data));
    }

    public function save($data): bool
    {
        // Cifra i dati
        $fieldsToEncrypt = [
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
            'first_name',
            'rh_factor',
            'phenotype',
            'kell',
            'gender'
        ];

        foreach ($fieldsToEncrypt as $field) {
            if (isset($data->$field)&& !is_null($data->$field)) {
                $data->$field = $this->encryptData($data->$field);
            }
        }

        return parent::save($data);
    }

    public function find($id = null)
    {
        $user = parent::find($id);

        // Decifra i dati
        if ($user) {
            $fieldsToEncrypt = [
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
                'first_name',
                'rh_factor',
                'phenotype',
                'kell',
                'gender'
            ];

            foreach ($fieldsToEncrypt as $field) {
                if (isset($user->$field)) {
                    $user->$field = $this->decryptData($user->$field);
                }
            }
        }

        return $user;
    }
    public function findAll(int $limit = null, int $offset = 0)
    {
        $users = parent::findAll($limit, $offset);

        // Decifra i dati per ogni utente
        $fieldsToEncrypt = [
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
            'first_name',
            'rh_factor',
            'phenotype',
            'kell',
            'gender'
        ];

        foreach ($users as &$user) {
            foreach ($fieldsToEncrypt as $field) {
                if (isset($user->$field)) {
                    $user->$field = $this->decryptData($user->$field);
                }
            }
        }

        return $users;
    }
    public function first()
    {
        $user=parent::first();
        if ($user){
            $fieldsToEncrypt = [
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
                'first_name',
                'rh_factor',
                'phenotype',
                'kell',
                'gender'
            ];

            foreach ($fieldsToEncrypt as $field) {
                if (isset($user->$field)) {
                    $user->$field = $this->decryptData($user->$field);
                }
            }
        }

        return $user;
    }

}
