<?php

namespace App\Controllers;

use App\Entities\BusinessHoursEntity as hoursentity;
use App\Entities\CompanyEntities as companyentities;
use App\Models\BusinessHoursModel as hoursmodel;
use App\Models\CompanyModels as companymodel;
use App\Models\PrivacypoliciesModel as privacymodel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\I18n\Time;

class CompanyController extends BaseController
{
    private function validateHours($postData)
    {
        $validationRules = [];

        foreach ($postData['data'] as $day => $times) {
            $validationRules["data.$day.open_time1"] = 'permit_empty|regex_match[/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/]';
            $validationRules["data.$day.close_time1"] = 'permit_empty|regex_match[/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/]';
            $validationRules["data.$day.open_time2"] = 'permit_empty|regex_match[/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/]';
            $validationRules["data.$day.close_time2"] = 'permit_empty|regex_match[/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/]';
        }
        return $this->validate($validationRules);
    }
    private function getCompanyInputValidateactionupdate()
    {
        $user = auth()->user();
        $rules = [
            'company_name' => [
                'rules' => [
                    'required',
                    'max_length[50]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\.& ]+\z/]',
                ],
            ],
            'group_name' => [
                'rules' => [
                    'required',
                    'max_length[50]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\.& ]+\z/]',
                ],
            ],
            'company_address' => [
                'rules' => [
                    'required',
                    'max_length[50]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'company_city' => [
                'rules' => [
                    'required',
                    'max_length[30]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'company_phone' => [
                'rules' => [
                    'required',
                    'max_length[16]',
                    'min_length[9]',
                    'regex_match[/^[0-9]+$/]',
                ],
            ],
            'company_vat' => [
                'rules' => [
                    'required',
                ],
            ],
            'companyemail' => [
                'rules' => [
                    'required',
                    'max_length[254]',
                    'valid_email',
                    'is_unique[company.company_email,company.id_company,' . $user->id_association . ']',
                ],
            ],
            'president_name' => [
                'rules' => [
                    'required',
                    'max_length[50]',
                    'min_length[5]',
                ],
            ],
            'siteurl' => [
                'rules' => [
                    'permit_empty',
                    'valid_url'
                ],
            ],
            'number_armchairs' => [
                'rules' => [
                    'required',
                    'integer',
                    'greater_than_equal_to[0]',

                ],
            ],
        ];

        $errors = [
            'company_name' => [
                'required' => lang('Auth.companynamerequired'),
                'max_length' => lang('Auth.companymax_length'),
                'min_length' => lang('Auth.companynmin_length'),
                'regex_match' => lang('Auth.companyregex_match'),
            ],
            'group_name' => [
                'required' => lang('Auth.companygroup_required'),
                'max_length' => lang('Auth.companygroup_max_length'),
                'min_length' => lang('Authcompanygroup_nmin_length'),
                'regex_match' => lang('Auth.companygroup_regex_match'),
            ],
            'company_address' => [
                'required' => lang('Auth.addressCompany_required'),
                'max_length' => lang('Auth.addressCompany_max_length'),
                'min_length' => lang('Auth.addressCompany_min_length'),
                'regex_match' => lang('Auth.addressCompany_regex_match'),
            ],
            'company_city' => [
                'required' => lang('Auth.companyCity_required'),
                'max_length' => lang('Auth.ccompanyCity_max_length'),
                'min_length' => lang('Auth.companyCity_min_length'),
                'regex_match' => lang('Auth.companyCity_regex_match'),
            ],
            'company_phone' => [
                'required' => lang('Auth.companyPhone_required'),
                'max_length' => lang('Auth.companyPhone_dmax_length'),
                'min_length' => lang('Auth.companyPhone_min_length'),
                'regex_match' => lang('Auth.companyPhone_reregex_match'),
            ],
            'company_vat' => [
                'required' => lang('Auth.companyVat_richiesto'),
            ],
            'companyemail' => [
                'required' => lang('Auth.companyEmail_required'),
                'max_length' => lang('Auth.companyEmail_max_length'),
                'valid_email' => lang('Auth.companyEmail_valid'),
                'is_unique' => lang('Auth.companyEmail_unique'),
            ],
            'president_name' => [
                'required' => lang('Auth.presidentRequired'),
                'max_length[50]' => lang('Auth.presidentMax_length'),
                'min_length[5]' => lang('Auth.presidentMin_length'),
            ],
            'siteurl' => [
                'valid_url' => lang('Auth.validUrl'),
            ],
            'number_armchairs' => [
                'required' => lang('Auth.armchairsrequired'),
                'integer' => lang('Auth.armchairsinteger'),
                'greater_than_equal_to' => lang('Auth.armchairseqaulto')
            ],
            'open_time1' => [
                'regex_match' => lang('Auth.opentimeregex_match'),
            ],
            'open_time2' => [
                'regex_match' => lang('Auth.opentimeregex_match'),
            ],
            'close_time1' => [
                'regex_match' => lang('Auth.opentimeregex_match'),
            ],
            'close_time2' => [
                'regex_match' => lang('Auth.opentimeregex_match'),
            ],

        ];
        return ['rules' => $rules, 'errors' => $errors];
    }
    private function getCompanyInputValidate()
    {
        $rules = [
            'company_name' => [
                'rules' => [
                    'required',
                    'max_length[50]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\.& ]+\z/]',
                ],
            ],
            'group_name' => [
                'rules' => [
                    'required',
                    'max_length[50]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\.& ]+\z/]',
                ],
            ],
            'company_address' => [
                'rules' => [
                    'required',
                    'max_length[50]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'company_city' => [
                'rules' => [
                    'required',
                    'max_length[30]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'company_phone' => [
                'rules' => [
                    'required',
                    'max_length[16]',
                    'min_length[9]',
                    'regex_match[/^[0-9]+$/]',
                ],
            ],
            'company_vat' => [
                'rules' => [
                    'required',
                ],
            ],
            'companyemail' => [
                'rules' => [
                    'required',
                    'max_length[254]',
                    'valid_email',
                    'is_unique[company.company_email,]',
                ],
            ],
            'siteurl' => [
                'rules' => [
                    'permit_empty',
                    'valid_url'
                ],
            ],
            'number_armchairs' => [
                'rules' => [
                    'required',
                    'integer',
                    'greater_than_equal_to[0]',

                ],
            ]
        ];

        $errors = [
            'company_name' => [
                'required' => lang('Auth.companynamerequired'),
                'max_length' => lang('Auth.companymax_length'),
                'min_length' => lang('Auth.companynmin_length'),
                'regex_match' => lang('Auth.companyregex_match'),
            ],
            'group_name' => [
                'required' => lang('Auth.companygroup_required'),
                'max_length' => lang('Auth.companygroup_max_length'),
                'min_length' => lang('Authcompanygroup_nmin_length'),
                'regex_match' => lang('Auth.companygroup_regex_match'),
            ],
            'company_address' => [
                'required' => lang('Auth.addressCompany_required'),
                'max_length' => lang('Auth.addressCompany_max_length'),
                'min_length' => lang('Auth.addressCompany_min_length'),
                'regex_match' => lang('Auth.addressCompany_regex_match'),
            ],
            'company_city' => [
                'required' => lang('Auth.companyCity_required'),
                'max_length' => lang('Auth.ccompanyCity_max_length'),
                'min_length' => lang('Auth.companyCity_min_length'),
                'regex_match' => lang('Auth.companyCity_regex_match'),
            ],
            'company_phone' => [
                'required' => lang('Auth.companyPhone_required'),
                'max_length' => lang('Auth.companyPhone_dmax_length'),
                'min_length' => lang('Auth.companyPhone_min_length'),
                'regex_match' => lang('Auth.companyPhone_reregex_match'),
            ],
            'company_vat' => [
                'required' => lang('Auth.companyVat_richiesto'),
            ],
            'companyemail' => [
                'required' => lang('Auth.companyEmail_required'),
                'max_length' => lang('Auth.companyEmail_max_length'),
                'valid_email' => lang('Auth.companyEmail_valid'),
                'is_unique' => lang('Auth.companyEmail_unique'),
            ],
            'siteurl' => [
                'valid_url' => lang('Auth.validUrl'),
            ],
            'number_armchairs' => [
                'required' => lang('Auth.armchairsrequired'),
                'integer' => lang('Auth.armchairsinteger'),
                'greater_than_equal_to' => lang('Auth.armchairseqaulto')
            ],
        ];
        return ['rules' => $rules, 'errors' => $errors];
    }
    private function getUserInputValidation()
    {
        $rules = [
            'first_name' => [
                'label' => 'Auth.first_name',
                'rules' => [
                    'required',
                    'max_length[30]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'surname' => [
                'label' => 'Auth.surname',
                'rules' => [
                    'required',
                    'max_length[30]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'address' => [
                'label' => 'Auth.address',
                'rules' => [
                    'required',
                    'max_length[50]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'city_of_residence' => [
                'label' => 'Auth.City_of_residence',
                'rules' => [
                    'required',
                    'max_length[30]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'Province_of_residence' => [
                'label' => 'Auth.Province_of_residence',
                'rules' => [
                    'required',
                    'max_length[2]',
                    'min_length[2]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'state_of_residence' => [
                'label' => 'Auth.state_of_residence',
                'rules' => [
                    'required',
                    'max_length[30]',
                    'min_length[2]',
                    'regex_match[/\A[a-zA-Z0-9\.]+\z/ ]',
                ],
            ],
            'zip_code' => [
                'label' => 'Auth.zip_code',
                'rules' => [
                    'required',
                    'max_length[6]',
                    'min_length[5]',
                    'regex_match[/^[0-9]+$/]',
                ],
            ],
            'phone_number' => [
                'label' => 'Auth.phone_number',
                'rules' => [
                    'required',
                    'max_length[16]',
                    'min_length[9]',
                    'regex_match[/^[0-9]+$/]',
                ],
            ],
            'Tax_code' => [
                'label' => 'Auth.Tax_code',
                'rules' => [
                    'required',
                ],
            ],
            'date_of_birth' => [
                'label' => 'Auth.date_of_birth',
                'rules' => [
                    'required',
                ],
            ],
            'birth_status' => [
                'label' => 'Auth.birth_status',
                'rules' => [
                    'required',
                    'max_length[30]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\.]+\z/]',
                ],
            ],
            'birth_place' => [
                'label' => 'Auth.birth_place',
                'rules' => [
                    'required',
                    'max_length[30]',
                    'min_length[3]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'County_of_birth' => [
                'label' => 'Auth.birth_place',
                'rules' => [
                    'required',
                    'max_length[2]',
                    'min_length[2]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'zip_codebirth' => [
                'label' => 'Auth.zip_codebirth',
                'rules' => [
                    'required',
                    'max_length[6]',
                    'min_length[5]',
                    'regex_match[/^[0-9]+$/]',
                ],
            ],
            'document_type' => [
                'label' => 'Auth.document_type',
                'rules' => [
                    'required',
                    'in_list[Carta identità,Patente,Passaporto]',
                ],
            ],
            'document_number' => [
                'label' => 'Auth.document_number',
                'rules' => [
                    'required',
                    'max_length[10]',
                    'min_length[9]',
                    'regex_match[/\A[a-zA-Z0-9\. ]+\z/]',
                ],
            ],
            'avatar' => [
                'rules' => [
                    'required',
                ],
            ],
            'email' => [
                'label' => 'Auth.email',
                'rules' => [
                    'required',
                    'max_length[254]',
                    'valid_email',
                    'is_unique[auth_identities.secret]',
                ],
            ],
            'gender' => [
                'rules' => [
                    'required',
                    'in_list[M,F]',
                ],
            ],
        ];
        $errors = [
            'first_name' => [
                'required' => lang('Auth.fnrequired'),
                'max_length' => lang('Auth.fnmax_length'),
                'min_length' => lang('Auth.fnmin_length'),
                'regex_match' => lang('Auth.fnregex_match'),
            ],
            'surname' => [
                'required' => lang('Auth.surequired'),
                'max_length' => lang('Auth.sumax_length'),
                'min_length' => lang('Auth.sumin_length'),
                'regex_match' => lang('Auth.suregex_match'),
            ],
            'address' => [
                'required' => lang('Auth.addrequired'),
                'max_length' => lang('Auth.addmax_length'),
                'min_length' => lang('Auth.addmin_length'),
                'regex_match' => lang('Auth.addregex_match'),
            ],
            'city_of_residence' => [
                'required' => lang('Auth.crerequired'),
                'max_length' => lang('Auth.credmax_length'),
                'min_length' => lang('Auth.cremin_length'),
                'regex_match' => lang('Auth.creregex_match'),
            ],
            'Province_of_residence' => [
                'required' => lang('Auth.prrrequired'),
                'max_length' => lang('Auth.prrdmax_length'),
                'min_length' => lang('Auth.prrmin_length'),
                'regex_match' => lang('Auth.prrreregex_match'),
            ],
            'state_of_residence' => [
                'required' => lang('Auth.strrequired'),
                'max_length' => lang('Auth.strdmax_length'),
                'min_length' => lang('Auth.strmin_length'),
                'regex_match' => lang('Auth.strreregex_match'),
            ],
            'zip_code' => [
                'required' => lang('Auth.ziprequired'),
                'max_length' => lang('Auth.zipdmax_length'),
                'min_length' => lang('Auth.zipmin_length'),
                'regex_match' => lang('Auth.zipreregex_match'),
            ],
            'phone_number' => [
                'required' => lang('Auth.phorequired'),
                'max_length' => lang('Auth.phodmax_length'),
                'min_length' => lang('Auth.phomin_length'),
                'regex_match' => lang('Auth.phoreregex_match'),
            ],
            'Tax_code' => [
                'required' => lang('Auth.taxrichiesto'),
            ],
            'date_of_birth' => [
                'required' => lang('Auth.bithrichiesto'),
            ],
            'birth_status' => [
                'required' => lang('Auth.bthrequired'),
                'max_length' => lang('Auth.bthdmax_length'),
                'min_length' => lang('Auth.bthmin_length'),
                'regex_match' => lang('Auth.bthreregex_match'),
            ],
            'birth_place' => [
                'required' => lang('Auth.bplrequired'),
                'max_length' => lang('Auth.bpldmax_length'),
                'min_length' => lang('Auth.bplmin_length'),
                'regex_match' => lang('Auth.bplreregex_match'),
            ],
            'zip_codebirth' => [
                'required' => lang('Auth.zplrequired'),
                'max_length' => lang('Auth.zpldmax_length'),
                'min_length' => lang('Auth.zplmin_length'),
                'regex_match' => lang('Auth.zplreregex_match'),
            ],
            'document_type' => [
                'required' => lang('Auth.dotrequired'),
                'in_list' => lang('Auth.dotinlist'),
            ],
            'document_number' => [
                'required' => lang('Auth.donrequired'),
                'max_length' => lang('Auth.dondmax_length'),
                'min_length' => lang('Auth.donomin_length'),
                'regex_match' => lang('Auth.donreregex_match'),
            ],
            'avatar' => [
                'required' => lang('Auth.avtrichiesto'),
            ],
            'email' => [
                'required' => lang('Auth.emlrequired'),
                'max_length' => lang('Auth.emldmax_length'),
                'valid_email' => lang('Auth.emlvalid'),
                'is_unique' => lang('Auth.emlunique'),
            ],
            'County_of_birth' => [
                'required' => lang('Auth.prrrequired'),
                'max_length' => lang('Auth.prbdmax_length'),
                'min_length' => lang('Auth.prbmin_length'),
                'regex_match' => lang('Auth.prbreregex_match'),
            ],
            'gender' => [
                'required' => lang('Auth.genderRequired'),
                'in_list' => lang('Auth.genderInlist'),
            ],
        ];
        return ['rules' => $rules, 'errors' => $errors];
    }
    private function randomString($id)
    {
        $char = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        $maxlenght = 15 - strlen((string)$id);
        $random_string = '';
        for ($i = 0; $i < $maxlenght; $i++) {
            $random_string .= $char[rand(0, $maxlenght - 1)];
        }
        return $random_string;
    }
    private function getprivacyversion($idassociation)
    {
        $privacy = new privacymodel();
        $privacyversion = $privacy->selectMax('version')
            ->where('company_id', $idassociation)
            ->get()
            ->getFirstRow();

        if (!$privacyversion || !$privacyversion->version) {
            return 1; // La versione predefinita se non trovata
        }

        //   valore della versione
        return $privacyversion->version;
    }
    public function InsertCompany()
    {
        $data = [];
        helper(['form', 'url']);
        $request = service('request');
        $postData = $request->getPost();
        if ($this->request->getPost()) {
            $uservalidation = $this->getUserInputValidation();
            $validation = $this->getCompanyInputValidate();
            $companyRules = $validation['rules'];
            $companyError = $validation['errors'];
            $uservalidation = $this->getUserInputValidation();
            $userRules =  $uservalidation['rules'];
            $UserErrors = $uservalidation['errors'];
            $validationRules = array_merge($companyRules, $userRules);
            $validationErrors = array_merge($companyError, $UserErrors);
            if (!$this->validate($validationRules, $validationErrors)) {
                $data['validation'] = $this->validator;
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            } else {
                $companyEntity = new companyentities();
                $company = new companymodel();
                $datacompany = [
                    'company_name' => $postData['company_name'],
                    'company_group' => $postData['group_name'],
                    'company_address' => $postData['company_address'],
                    'company_city' => $postData['company_city'],
                    'company_phone' => $postData['company_phone'],
                    'company_vat' => $postData['company_vat'],
                    'company_email' => $postData['companyemail'],
                    'company_site_url' => null,
                    'president_name' => null,
                    'number_armchairs' => null,
                    'agenda_code' => null,
                    'registration_date' => $companyEntity->day(),
                    'subscription_expires' => $companyEntity->subscription_expires(),
                    'number_renewals' => 0,
                    'dplasma' => null,
                    'dpiastrine' => null,
                    'dsangue' => null,
                    'agendacoderefer' => null,
                ];
                $companyEntity->fill($datacompany);
                $company->save($companyEntity);
                $lastid = $company->getInsertID();
                $modelhours = new hoursmodel();
                $week = ['Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato', 'Domenica'];
                foreach ($week as $day) {
                    $hours = new hoursentity();
                    $datahourswork = [
                        'company_id' => $lastid,
                        'day_of_week' => $day,
                        'open_time1' => null,
                        'close_time1' => null,
                        'open_time2' => null,
                        'close_time2' => null,
                    ];
                    $hours->fill($datahourswork);
                    $modelhours->save($hours);
                }
                $newuser = [
                    'username' => null,
                    'email' => $postData['email'],
                    'password' => $postData['passwordInput'],
                    'surname' => $postData['surname'],
                    'address' => $postData['address'],
                    'City_of_residence' => $postData['city_of_residence'],
                    'Province_of_residence' => $postData['Province_of_residence'],
                    'state_of_residence' => $postData['state_of_residence'],
                    'zip_code' => $postData['zip_code'],
                    'phone_number' => $postData['phone_number'],
                    'Tax_code' => $postData['Tax_code'],
                    'date_of_birth' => $postData['date_of_birth'],
                    'birth_status' => $postData['birth_status'],
                    'County_of_birth' => $postData['County_of_birth'],
                    'birth_place' => $postData['birth_place'],
                    'zip_codebirth' => $postData['zip_codebirth'],
                    'document_type' => $postData['document_type'],
                    'document_number' => $postData['document_number'],
                    'user_type' => 'donatore',
                    'avatar' => '/assets/avatar/avatar_default.jpg',
                    'unique_code' => 0,
                    'authorized' => 1,
                    'first_name' => $postData['first_name'],
                    'id_association' => $lastid,
                    'gender' => $postData['gender'],
                    'salt' => bin2hex(random_bytes(16)),

                ];
                $user = new user($newuser);
                $users = auth()->getProvider();
                $users->save($user);
                $user = $users->findById($users->getInsertID());
                $user->addGroup('superadmin');
                return redirect()->to('login');
            }
        }
    }

    public function editCompanyprofile()
    {
        $user = auth()->user();
        $company = new companymodel();
        $companydata = $company->find($user->id_association);
        $WorkingHours = new hoursmodel();
        $dataWorkingHours = $WorkingHours->getBusinessHoursByCompany($user->id_association);

        return view('Adminview\edit_company', [
            'companydata' => $companydata,
            'dataWorkingHours' => $dataWorkingHours,
        ]);
    }

    public function NewCompanyviews()
    {
        $data = [];

        return view('registration\new_company', $data);
    }
    public function GetAllpolicy()
    {
        $Privacy = new privacymodel();
        $user = auth()->user();
        $Allprivacy = $Privacy->where('company_id ', $user->id_association)
            ->findAll();
        return view('Adminview\ListCompanyPolicy', ['allprivacy' => $Allprivacy]);
    }
    public function InsertPrivacyPolicy()
    {
        return view('Adminview\newpolicy');
    }

    public function UpdateCompanydata()
    {
        $user = auth()->user();
        $request = service('request');
        helper(['form', 'url']);
        if ($this->request->isAJAX() && $this->request->is('post')) {
            $token = csrf_hash();
            $postData = $request->getPost();
            $request = service('request');
            $agendacode = $postData['agenda_code'];
            if (empty($agendacode)) {
                $agendacode = $user->id_association . '_' . $this->randomString($user->id_association);
            }
            helper(['form', 'url']);
            if ($this->request->isAJAX() && $this->request->is('post')) {
                $token = csrf_hash();
                $postData = $request->getPost();
                $validation = $this->getCompanyInputValidateactionupdate();
                $rules = $validation['rules'];
                $errors = $validation['errors'];
                if (!$this->validate($rules, $errors)) {
                    $data = $this->validator->getErrors();
                    foreach ($data as $error) {
                        $er[] = $error;
                    }
                    $risposta = [
                        'msg' => 'fail',
                        'listerror' => $er,
                        'token' => $token,
                        'aer' => $data,
                    ];
                    header('Content-Type: application/json');

                    return $this->response->setJSON($risposta);
                } else {
                    $company = new companymodel();
                    $datacompany = [
                        'company_name' => $postData['company_name'],
                        'company_group' => $postData['group_name'],
                        'company_address' => $postData['company_address'],
                        'company_city' => $postData['company_city'],
                        'company_phone' => $postData['company_phone'],
                        'company_vat' => $postData['company_vat'],
                        'company_email' => $postData['companyemail'],
                        'company_site_url' => $postData['siteurl'] ?? null,
                        'president_name' => $postData['president_name'] ?? null,
                        'number_armchairs' => $postData['number_armchairs'],
                        'agenda_code' => $agendacode,
                        'dplasma'    => ($postData['dplasma'] == true) ? 1 : 0,
                        'dpiastrine' => ($postData['dpiastrine'] == true) ? 1 : 0,
                        'dsangue'    => ($postData['dsangue'] == true) ? 1 : 0,
                        'agendacoderefer' => $postData['agendacoderefer'] ?? null,
                    ];

                    try {
                        $company->update($user->id_association, $datacompany);
                    } catch (\Exception $e) {
                        log_message('error', $e->getMessage());
                    }

                    $modelHours = new hoursmodel();
                    foreach ($postData['data'] as $day => $times) {
                        $updateData = [
                            'open_time1' => !empty($times['open_time1']) ? $times['open_time1'] : null,
                            'close_time1' => !empty($times['close_time1']) ? $times['close_time1'] : null,
                            'open_time2' => !empty($times['open_time2']) ? $times['open_time2'] : null,
                            'close_time2' => !empty($times['close_time2']) ? $times['close_time2'] : null,
                        ];
                        // Esegue l'aggiornamento basato sul giorno della settimana e sull'ID della compagnia
                        $modelHours->where('day_of_week', $day)
                            ->where('company_id', $user->id_association)
                            ->set($updateData)
                            ->update();
                    }

                    $risposta = [
                        'msg' => 'ok',
                        'token' => $token,
                        'status' => lang('Auth.satusok'),
                        'agendacode' => $agendacode,
                    ];
                    header('Content-Type: application/json');

                    return $this->response->setJSON($risposta);
                }
            }
        }
    }

    public function Saveprivacypolicy()
    {
        $request = service('request');
        $postData = $request->getPost();
        $token = csrf_hash();
        $rules = [
            'privacytext' => 'required',
        ];
        $error = [
            'privacytext' => lang('idnonvalido'),
        ];
        if (!$this->validate($rules, $error)) {
            $data = $this->validator->getErrors();
            foreach ($data as $error) {
                $er[] = $error;
            }
            $risposta = [
                'msg' => 'fail',
                'listerror' => $er,
                'token' => $token,
            ];
            header('Content-Type: application/json');

            return $this->response->setJSON($risposta);
        } else {
            $user = auth()->user();
            $privacypolicy = $postData['privacytext'];
            $modelprvacy = new privacymodel();
            $privacydata = [
                'company_id' => $user->id_association,
                'version' => $this->getprivacyversion($user->id_association),
                'policy_text' => $privacypolicy,
                'created_at' => Time::today(),
                'is_active' => 0,
                'is_draft' => 1,

            ];
            $modelprvacy->save($privacydata);
            $risposta = [
                'msg' => 'ok',
                'token' => $token,
                
            ];
            //  $this->SendEmail($to, $subject,$from,$name,$message);
            header('Content-Type: application/json');

            return $this->response->setJSON($risposta);
        }
    }
}
