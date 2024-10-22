<?php
/*
namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;
use Config\Services;

class UserEntity extends ShieldUser
{
    // I campi che devono essere criptati
    protected $encryptedFields = [
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
        'gender',
    ];

    protected function encrypt($value)
    {
        $encrypter = Services::encrypter();
        return base64_encode($encrypter->encrypt($value));
    }

    protected function decrypt($value)
    {
        $encrypter = Services::encrypter();
        return $encrypter->decrypt(base64_decode($value));
    }

    // Getter e setter per 'surname'
    public function setSurname(string $value)
    {
        $this->attributes['surname'] = $this->encrypt($value);
        return $this;
    }

    public function getSurname()
    {
        return $this->decrypt($this->attributes['surname']);
    }

    // Getter e setter per 'address'
    public function setAddress(string $value)
    {
        $this->attributes['address'] = $this->encrypt($value);
        return $this;
    }

    public function getAddress()
    {
        return $this->decrypt($this->attributes['address']);
    }

    // Getter e setter per 'City_of_residence'
    public function setCityOfResidence(string $value)
    {
        $this->attributes['City_of_residence'] = $this->encrypt($value);
        return $this;
    }

    public function getCityOfResidence()
    {
        return $this->decrypt($this->attributes['City_of_residence']);
    }

    // Getter e setter per 'Province_of_residence'
    public function setProvinceOfResidence(string $value)
    {
        $this->attributes['Province_of_residence'] = $this->encrypt($value);
        return $this;
    }

    public function getProvinceOfResidence()
    {
        return $this->decrypt($this->attributes['Province_of_residence']);
    }

    // Getter e setter per 'state_of_residence'
    public function setStateOfResidence(string $value)
    {
        $this->attributes['state_of_residence'] = $this->encrypt($value);
        return $this;
    }

    public function getStateOfResidence()
    {
        return $this->decrypt($this->attributes['state_of_residence']);
    }

    // Getter e setter per 'zip_code'
    public function setZipCode(string $value)
    {
        $this->attributes['zip_code'] = $this->encrypt($value);
        return $this;
    }

    public function getZipCode()
    {
        return $this->decrypt($this->attributes['zip_code']);
    }

    // Getter e setter per 'phone_number'
    public function setPhoneNumber(string $value)
    {
        $this->attributes['phone_number'] = $this->encrypt($value);
        return $this;
    }

    public function getPhoneNumber()
    {
        return $this->decrypt($this->attributes['phone_number']);
    }

    // Getter e setter per 'Tax_code'
    public function setTaxCode(string $value)
    {
        $this->attributes['Tax_code'] = $this->encrypt($value);
        return $this;
    }

    public function getTaxCode()
    {
        return $this->decrypt($this->attributes['Tax_code']);
    }

    // Getter e setter per 'date_of_birth'
    public function setDateOfBirth(string $value)
    {
        $this->attributes['date_of_birth'] = $this->encrypt($value);
        return $this;
    }

    public function getDateOfBirth()
    {
        return $this->decrypt($this->attributes['date_of_birth']);
    }

    // Getter e setter per 'birth_status'
    public function setBirthStatus(string $value)
    {
        $this->attributes['birth_status'] = $this->encrypt($value);
        return $this;
    }

    public function getBirthStatus()
    {
        return $this->decrypt($this->attributes['birth_status']);
    }

    // Getter e setter per 'County_of_birth'
    public function setCountyOfBirth(string $value)
    {
        $this->attributes['County_of_birth'] = $this->encrypt($value);
        return $this;
    }

    public function getCountyOfBirth()
    {
        return $this->decrypt($this->attributes['County_of_birth']);
    }

    // Getter e setter per 'birth_place'
    public function setBirthPlace(string $value)
    {
        $this->attributes['birth_place'] = $this->encrypt($value);
        return $this;
    }

    public function getBirthPlace()
    {
        return $this->decrypt($this->attributes['birth_place']);
    }

    // Getter e setter per 'zip_codebirth'
    public function setZipCodeBirth(string $value)
    {
        $this->attributes['zip_codebirth'] = $this->encrypt($value);
        return $this;
    }

    public function getZipCodeBirth()
    {
        return $this->decrypt($this->attributes['zip_codebirth']);
    }

    // Getter e setter per 'document_type'
    public function setDocumentType(string $value)
    {
        $this->attributes['document_type'] = $this->encrypt($value);
        return $this;
    }

    public function getDocumentType()
    {
        return $this->decrypt($this->attributes['document_type']);
    }

    // Getter e setter per 'document_number'
    public function setDocumentNumber(string $value)
    {
        $this->attributes['document_number'] = $this->encrypt($value);
        return $this;
    }

    public function getDocumentNumber()
    {
        return $this->decrypt($this->attributes['document_number']);
    }

    // Getter e setter per 'gender'
    public function setGender(string $value)
    {
        $this->attributes['gender'] = $this->encrypt($value);
        return $this;
    }

    public function getGender()
    {
        return $this->decrypt($this->attributes['gender']);
    }
        
}
*/
