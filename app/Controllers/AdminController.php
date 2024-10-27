<?php

namespace App\Controllers;

use App\Entities\ExamEntity as exam;
use App\Libraries\EmailManager;
use App\Models\CompanyModels as ModelCompany;
use App\Models\ExamsModel as exammodel;
use App\Models\AppointmentModel;
use App\Models\BusinessHoursModel;
use App\Models\FileDownloadModel;
use App\Models\UserModel;
use App\Trait\StringCaseConverter;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Entities\User;
use setasign\Fpdi\Fpdi;

class AdminController extends BaseController
{
    use StringCaseConverter;
   
    private function addHeader(Fpdi $pdf, $company)
    {
        $pdf->SetY(10);
        $pdf->SetFont('helvetica', 'B', 12);

        $headerText = "Report by: {$company->company_name}\n";
        $headerText .= "Address: {$company->company_address}\n";
        $headerText .= "City: {$company->company_city}\n";
        $headerText .= "Phone: {$company->company_phone}\n";
        $headerText .= "Email: {$company->company_email}\n";
        $headerText .= "VAT: {$company->company_vat}\n";

        $pdf->MultiCell(0, 10, $headerText, 0, 'C');
    }

    private function addFooter(Fpdi $pdf, $company, $user)
    {
        $pdf->SetY(-15);
        $pdf->SetFont('helvetica', 'I', 8);
        $footerText = "Company: {$company->company_name}, Address: {$company->company_address}, City: {$company->company_city}, Phone: {$company->company_phone}, Email: {$company->company_email}\n";
        $footerText .= "User: {$user->name} {$user->surname}";
        $pdf->Cell(0, 10, $footerText, 0, 0, 'C');
    }

    private function userislooked($donation_iduser)
    {
        $model = new exammodel();

        //  data attuale
        $currentDate = date('Y-m-d');
        //  query
        $results = $model->where('donation_iduser', $donation_iduser)
            ->where('unlockdate >', $currentDate)
            ->findAll();

        // Restituisci true se esistono risultati, altrimenti false
        if (!empty($results)) {
            return true;
        } else {
            return false;
        }
    }

    private function UserCanDonate($iduser, $typeOfDonation)
    {
        $waitingPeriods = [
            'sangue_sangue' => 90,
            'sangue_plasma' => 30,
            'sangue_piastrine' => 30,
            'plasma_plasma' => 14,
            'plasma_sangue' => 14,
            'plasma_piastrine' => 14,
            'piastrine_sangue' => 14,
            'piastrine_plasma' => 14,
            'piastrine_piastrine' => 14,
        ];

        $examResultModel = new exammodel();

        $currentDate = Time::now();

        $recentExams = $examResultModel
            ->where('donation_iduser', $iduser)
            ->orderBy('donation_date', 'DESC')
            ->findAll();

        if (empty($recentExams)) {
            return true; // Se non ci sono esami precedenti, il donatore può donare
        }

        // Funzione per calcolare la data limite
        $calculateLimitDate = function ($donationDate, $additionalDays) {
            $date = Time::parse($donationDate);

            return $date->addDays($additionalDays);
        };

        $canDonate = true;

        foreach ($recentExams as $exam) {
            $donationDate = $exam->donation_date;
            $lastDonationType = $exam->exam_type;
            if ($typeOfDonation == 'sangue') {
                if ($lastDonationType == 'sangue' && $currentDate->isBefore($calculateLimitDate($donationDate, $waitingPeriods['sangue_sangue']))) {
                    $canDonate = false;
                }
                if ($lastDonationType == 'plasma' && $currentDate->isBefore($calculateLimitDate($donationDate, $waitingPeriods['sangue_plasma']))) {
                    $canDonate = false;
                }
                if ($lastDonationType == 'piastrine' && $currentDate->isBefore($calculateLimitDate($donationDate, $waitingPeriods['sangue_piastrine']))) {
                    $canDonate = false;
                }
            }
            if ($typeOfDonation == 'plasma') {
                if ($lastDonationType == 'sangue' && $currentDate->isBefore($calculateLimitDate($donationDate, $waitingPeriods['plasma_plasma']))) {
                    $canDonate = false;
                }
                if ($lastDonationType == 'plasma' && $currentDate->isBefore($calculateLimitDate($donationDate, $waitingPeriods['plasma_sangue']))) {
                    $canDonate = false;
                }
                if ($lastDonationType == 'piastrine' && $currentDate->isBefore($calculateLimitDate($donationDate, $waitingPeriods['plasma_piastrine']))) {
                    $canDonate = false;
                }
            }
            if ($typeOfDonation == 'piastrine') {
                if ($lastDonationType == 'sangue' && $currentDate->isBefore($calculateLimitDate($donationDate, $waitingPeriods['piastrine_sangue']))) {
                    $canDonate = false;
                }
                if ($lastDonationType == 'plasma' && $currentDate->isBefore($calculateLimitDate($donationDate, $waitingPeriods['piastrine_plasma']))) {
                    $canDonate = false;
                }
                if ($lastDonationType == 'piastrine' && $currentDate->isBefore($calculateLimitDate($donationDate, $waitingPeriods['piastrine_piastrine']))) {
                    $canDonate = false;
                }
            }
        }

        return $canDonate;
    }

    private function Savepermision($NewUserPermision, $id, $newgroup)
    {
        $user = auth()->user();
        $user->id = $id;
        // Usa lo spread operator per passare i permessi come parametri individuali
        $user->syncGroups($newgroup);
        /*
        if ($newgroup == 'user') {
            $user->syncPermissions();
        } else {*/
        $user->syncPermissions(...$NewUserPermision);
        // }
    }
    private function getUser($id): User
    {
        $adminuser = auth()->user();
        $users = new UserModel();
        $user = $users->where('id', $id)
            ->where('id_association', $adminuser->id_association)
            ->first();
        return $user;
    }

    protected function getValidationRules(): array
    {
        return setting('Validation.changePassword') ?? [
            'password' => [
                'label' => 'Auth.password',
                'rules' => 'required|strong_password',
            ],
            'password_confirm' => [
                'label' => 'Auth.passwordConfirm',
                'rules' => 'required|matches[password]',
            ],
        ];
    }

    private function returnuser(int $id, int $typeSearch = 1, $taxcode = '')
    {
        $users = new UserModel();
        if ($typeSearch == 1) {
            $user_to_edit = $users->select('*')
                ->where('id', $id)
                ->findAll();
        }
        if ($typeSearch == 2) {
            $user_to_edit = $users->select('*')
                ->where('unique_code', $id)
                ->findAll();
        }
        if ($typeSearch == 3) {
            $user_to_edit = $users->select('Tax_code')
                ->where('id', $id)
                ->first();

            return $user_to_edit->Tax_code; // Restituisce tax code  dell'utente trovato
        }
        if ($typeSearch == 4) {
            $user_to_edit = $users->select('id')
                ->where('Tax_code', $taxcode)
                ->first();

            return $user_to_edit->id; // Restituisce tax code  dell'utente trovato
        }
        $user = [];
        if ($user_to_edit) {
            foreach ($user_to_edit as $user_edit) {
                $user = [
                    'id' => $this->GetString($user_edit->id),
                    'first_name' => $this->GetString($user_edit->first_name),
                    'surname' => $this->getString($user_edit->surname),
                    'address' => $this->GetString($user_edit->address),
                    'City_of_residence' => $this->GetString($user_edit->City_of_residence),
                    'Province_of_residence' => $this->GetString($user_edit->Province_of_residence),
                    'zip_code' => $this->GetString($user_edit->zip_code),
                    'phone_number' => $this->GetString($user_edit->phone_number),
                    'user_type' => $this->GetString($user_edit->user_type),
                    'birth_place' => $user_edit->birth_place,
                    'zip_codebirth' => $user_edit->zip_codebirth,
                    'birth_status' => $this->GetString($user_edit->birth_status),
                    'date_of_birth' => $user_edit->date_of_birth,
                    'document_type' => $user_edit->document_type,
                    'document_number' => $user_edit->document_number,
                    'state_of_residence' => $this->GetString($user_edit->state_of_residence),
                    'County_of_birth' => $this->GetString($user_edit->County_of_birth),
                    'email' => $user_edit->email,
                    'Tax_code' => $user_edit->Tax_code,
                    'avatar' => $user_edit->avatar,
                    'unique_code' => $user_edit->unique_code,
                    'rh_factor' => $user_edit->rh_factor,
                    'phenotype' => $user_edit->phenotype,
                    'kell' => $user_edit->kell,
                    'group_type' => $user_edit->group_type,
                    'isuserfind' => true,
                    'plasmaisok' => ($this->userislooked($user_edit->id) == true) ? 'red' : (($this->UserCanDonate($user_edit->id, 'plasma') == true) ? lang('Auth.idoneo') : lang('Auth.nidoneo')),
                    'sangueisok' => ($this->userislooked($user_edit->id) == true) ? 'red' : (($this->UserCanDonate($user_edit->id, 'sangue') == true) ? lang('Auth.idoneo') : lang('Auth.nidoneo')),
                    'piastrineisok' => ($this->userislooked($user_edit->id) == true) ? 'red' : (($this->UserCanDonate($user_edit->id, 'piastrine') == true) ? lang('Auth.idoneo') : lang('Auth.nidoneo')),
                    'erromsg' => lang('Auth.nouserfound'),
                    'gender' => $user_edit->gender,
                ];
            }
        } else {
            $user = [
                'id' => '0',
                'first_name' => ' ',
                'surname' => ' ',
                'address' => ' ',
                'City_of_residence' => ' ',
                'Province_of_residence' => ' ',
                'zip_code' => ' ',
                'phone_number' => ' ',
                'user_type' => ' ',
                'birth_place' => ' ',
                'zip_codebirth' => ' ',
                'birth_status' => ' ',
                'date_of_birth' => ' ',
                'document_type' => ' ',
                'document_number' => ' ',
                'state_of_residence' => ' ',
                'County_of_birth' => ' ',
                'email' => ' ',
                'Tax_code' => ' ',
                'avatar' => ' ',
                'unique_code' => ' ',
                'isuserfind' => false,
                'plasmaisok' => '',
                'sangueisok' => '',
                'piastrineisok' => '',
                'erromsg' => lang('Auth.nouserfound'),
                'gender' => '',
            ];
        }

        return $user;
    }

    public function index()
    {
        $user = auth()->user();
        $companyModel = new ModelCompany();
        $businesHours  = new BusinessHoursModel();
        $company = $companyModel->find($user->id_association);
        $businesWorkHoursiscomplete= $businesHours->isBusinesHoursComplete($user->id_association);
        $isCompanyDatailComplete= $companyModel->check_registration_state($user->id_association);
       // echo $businesWorkHoursiscomplete.'<br>'. $isCompanyDatailComplete . '<br>';
        $token = csrf_hash();
        $directory = './assets/avatar/';
        $files = array_diff(scandir($directory), ['.', '..']);
        // search for users to confirm
        $users = new UserModel();
        $pending_users = $users->select('id,first_name,surname,address,City_of_residence,Province_of_residence,zip_code,phone_number,avatar,user_type')
            ->where('authorized', 0)
            ->where('id_association', $user->id_association)
            ->orderBy('id')
            ->findAll();
        $directoryreport = $this->GetWritepath(false);
        if (!is_dir($directoryreport)) {
            mkdir($directoryreport, 0777, true);
        }
        $ReportFiles = array_diff(scandir($directoryreport), ['.', '..']);
        $fileList = [];
        foreach ($ReportFiles as $file) {
            // Estrai il timestamp e il nome originale del file
            $parts = explode('_', $file, 3);
            if (count($parts) == 3) {
                $idexsam = $parts[0];
                $timestamp = $parts[1];
                $originalFilename = $parts[2];
                $fileList[] = [
                    'display_name' => $originalFilename,
                    'filename' => $file, // mantengo  il nome completo con timestamp per il download
                    'timestamp' => $timestamp,
                    'idexsam' => $idexsam,
                ];
            }
        }
        $list_pending_user = [];
        if ($pending_users) {
            foreach ($pending_users as $user_pendig) {
                $list_pending_user[] = [
                    'id' => $this->GetString($user_pendig->id),
                    'first_name' => $this->GetString($user_pendig->first_name),
                    'surname' => $this->getString($user_pendig->surname),
                    'address' => $this->GetString($user_pendig->address),
                    'City_of_residence' => $this->GetString($user_pendig->City_of_residence),
                    'Province_of_residence' => $this->GetString($user_pendig->Province_of_residence),
                    'zip_code' => $this->GetString($user_pendig->zip_code),
                    'phone_number' => $this->GetString($user_pendig->phone_number),
                    'user_type' => $this->GetString($user_pendig->user_type),
                    'avatar' => $user_pendig->avatar,
                ];
            }
        }

        $allusers = $users->select('id,first_name,surname,address,City_of_residence,Province_of_residence,
                                    zip_code,phone_number,avatar,user_type,authorized,group_type,rh_factor,phenotype,kell')
            ->where('id_association', $user->id_association)
            ->findAll();
        $list_all_user = [];
        if ($allusers) {
            foreach ($allusers as $single_user) {
                $list_all_user[] = [
                    'id' => $this->GetString($single_user->id),
                    'first_name' => $this->GetString($single_user->first_name),
                    'surname' => $this->getString($single_user->surname),
                    'address' => $this->GetString($single_user->address),
                    'City_of_residence' => $this->GetString($single_user->City_of_residence),
                    'Province_of_residence' => $this->GetString($single_user->Province_of_residence),
                    'zip_code' => $this->GetString($single_user->zip_code),
                    'phone_number' => $this->GetString($single_user->phone_number),
                    'user_type' => $this->GetString($single_user->user_type),
                    'avatar' => $single_user->avatar,
                    'stato' => ($single_user->authorized == 0) ? 'Da Attivare' : 'Attivato',
                    'group_type' => $single_user->group_type,
                    'rh_factor' => ($single_user->rh_factor === '+') ? lang('Auth.positivo') : lang('Auth.negativo'),
                    'phenotype' => $single_user->phenotype,
                    'kell' => $single_user->kell,
                    'plasmaisok' => ($this->userislooked($single_user->id) == true) ? 'red' : (($this->UserCanDonate($single_user->id, 'plasma') == true) ? lang('Auth.idoneo') : lang('Auth.nidoneo')),

                    'sangueisok' => ($this->userislooked($single_user->id) == true) ? 'red' : (($this->UserCanDonate($single_user->id, 'sangue') == true) ? lang('Auth.idoneo') : lang('Auth.nidoneo')),

                    'piastrineisok' => ($this->userislooked($single_user->id) == true) ? 'red' : (($this->UserCanDonate($single_user->id, 'piastrine') == true) ? lang('Auth.idoneo') : lang('Auth.nidoneo')),
                ];
            }
        }
         $currentDate = Time::now();
        $Appointment = new AppointmentModel();
        $allAppointmentpendig = $Appointment->getPendingAppointmentsWithDetails($user->id_association,$company->agenda_code);
        $confirmedAppointment=$Appointment->getAppointmentsByDate($user->id_association,$company->agenda_code,$currentDate);
        $data['list'] = [
            'registration'=> (!$businesWorkHoursiscomplete && !$isCompanyDatailComplete) ? lang('Auth.noregisrationcomplete') :"",
            'pathavatar' => $files,
            'avatar' => $user->avatar,
            'autorizzato' => $user->authorized,
            'pending' => $list_pending_user,
            'alluser' => $list_all_user,
            'showappointment'=>(empty($allAppointmentpendig))? lang('Auth.noappointment'):lang('Auth.yesappointment'),
            'appointmentpending' => $allAppointmentpendig,
            'showconfirmedappointment'=>(empty($confirmedAppointment))? lang('Auth.noappointmentconfirm'):lang('Auth.yesappointmentconfirm'),
            'todayappointment' =>$confirmedAppointment,
            'listfile' => $fileList,
            'showreport' => (empty($fileList)) ? lang('Auth.noreport') : lang('Auth.yesreport'),
        ];
       
        echo view('header');
        return view('Adminview\Admin_dashboard', $data);
    }

    public function showUpdateLevelView()
    {
        $token = csrf_hash();
        $authGroups = config('AuthGroups');
        $permissions = $authGroups->permissions;
        $availablegroups = $authGroups->Appgroups;
        $request = service('request');
        $postData = $request->getPost();

        $data = [
            'permissions' => $permissions,
            'availablegroups' => $availablegroups,
            'user' => $this->getUser($postData['id']),
            'token' => $token,
        ];

        return view('Adminview/AutUserLevelView', $data);
    }

    public function SaveLevelandGroup()
    {
        $request = service('request');
        $postData = $request->getPost();
        $arraypermissions = isset($postData['permissions']) && is_array($postData['permissions']) ? $postData['permissions'] : [];
        $newgroup = $postData['userType'];
        $id = $postData['id'];
        $token = csrf_hash();
        if ($newgroup == 'user') {
            $arraypermissions = [];
        }
        $this->Savepermision($arraypermissions, $id, $newgroup);
        $data = [
            'token' => $token,
            'newgroup' => $newgroup,
        ];

        return $this->response->setJSON($data);
    }

    public function noPermission()
    {
        return view('errors/no_permission');
    }

    public function Activateuser()
    {
        $request = service('request');
        $postData = $request->getPost();
        $token = csrf_hash();
        $rules = [
            'id' => 'required|integer',
        ];
        $error = [
            'id' => lang('idnonvalido'),
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
            $useradmin = auth()->user();
            $user = auth()->user();
            $user->id = $postData['id'];
            $user->authorized = 1;
            $user->user_type = 'donatore';
            $modeluser = new UserModel();
            $modeluser->save($user);
            $risposta = [
                'msg' => 'ok',
                'token' => $token,
                'id' => $postData['id'],
            ];
            //  $this->SendEmail($to, $subject,$from,$name,$message);
            header('Content-Type: application/json');

            return $this->response->setJSON($risposta);
        }
    }

    public function UpdateAvatarimage()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = [];

        // Read new token and assign in $response['token']
        $response['token'] = csrf_hash();
        $data = [];

        if (isset($postData['avatar'])) {
            $avatar = $postData['avatar'];
            $user = auth()->user();
            $user->avatar = $avatar;
            $model = new UserModel();
            $model->save($user);
            $data[] = [
                'newavatar' => $avatar,
            ];
        }
        $response['data'] = $data;

        return $this->response->setJSON($response);
    }

    public function NewUserView()
    {
        $user = auth()->user();
        $data = [
            'association' => $user->id_association,
        ];

        return view('Adminview/NewUser', $data);
    }

    public function EditUser()
    {
        helper('array');
        $request = service('request');
        $postData = $request->getPost();
        $typeSearch = dot_array_search('typesearch', $postData) ?? 1;
        $token = csrf_hash();
        $rules = [
            'id' => 'required|integer',
        ];
        $error = [
            'id' => lang('Auth.idnonvalido'),
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
            $dati['useredit'] =
                [
                    'user' => $this->returnuser($postData['id'], $typeSearch),
                    'token' => $token,
                    'exsam' => $this->EditUserexsam($postData['id'], 1),
                ];


            switch ($typeSearch) {
                case 1:
                    return view('Adminview\Admin_edituser', $dati);
                    break;
                case 2:
                    header('Content-Type: application/json');

                    return $this->response->setJSON($dati);
                    break;
                default:
                    // Codice da eseguire se $typeSearch non corrisponde a nessun caso precedente
                    break;
            }
        }
    }

    public function EditUserexsam(int $id = 0, int $typeresult = 0)
    {
        $request = service('request');
        $postData = $request->getPost();
        $token = csrf_hash();
        $rules = [
            'id' => 'required|integer',
        ];
        $error = [
            'id' => lang('Auth.idnonvalido'),
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
            $id = ($id == 0) ? $id = $postData['id'] : $id = $id;
            $exsam = new exammodel();
            $examList = $exsam->select('*')
                ->join('file_downloads', 'file_downloads.exam_result_id = exam_results.id_examresults', 'left')
                ->where('exam_results.donation_iduser', $id)
                ->findAll();

            if ($examList) {
                foreach ($examList as $exsam_edit) {
                    $exams[] = [
                        'id' => $this->GetString($exsam_edit->id_examresults),
                        'donation_result' => $this->GetString($exsam_edit->donation_result),
                        'exam_type' => $this->getString($exsam_edit->exam_type),
                        'donation_date' => $this->formatItDateTime($exsam_edit->donation_date),
                        'day_stop' => $exsam_edit->day_stop,
                        'stop_notice' => $this->GetString($exsam_edit->stop_notice),
                        'notedoctor' => $this->GetString($exsam_edit->notedoctor),
                        'upload_date' => $this->formatItDateTime($exsam_edit->upload_date),
                        'download_date' => $this->formatItDateTime($exsam_edit->download_date),
                        'unlokdate' => (Time::parse($exsam_edit->unlockdate)->isAfter(Time::now())) ? $this->formatItDateTime($exsam_edit->unlockdate) : '',
                    ];
                }
            } else {
                $exams[] = [
                    'id' => '',
                    'donation_result' => '',
                    'exam_type' => '',
                    'donation_date' => '',
                    'day_stop' => '',
                    'day_stop' => '',
                    'zip_code' => '',
                    'stop_notice' => '',
                    'notedoctor' => '',
                    'upload_date' => '',
                    'download_date' => '',
                    'unlokdate' => '',
                ];
            }
        }
        $dati['listexsam'] =
            [
                'listall' => $exams,
                'token' => $token,
            ];
        if ($typeresult == 0) {
            return view('Adminview\exsamtable', $dati);
        }

        if ($typeresult == 1) {
            return $dati;
        }
    }

    public function SaveNewUser()
    {
        $request = service('request');
        helper(['form', 'url']);
        if ($this->request->isAJAX() && $this->request->is('post')) {
            $token = csrf_hash();

            $postData = $request->getPost();
            $id = $postData['id'];
            $useradmin = auth()->user();
            $user = auth()->user();
            $rules = [
                'id' => 'required|integer',
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
                'gender' => [
                    'label' => 'Auth.gender',
                    'rules' => [
                        'required',
                        'in_list[M,F]',
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
                        'is_unique[auth_identities.secret,auth_identities.user_id,{id}]',
                    ],
                ],
                'rh_factor' => [
                    'rules' => [
                        'rh_factorValidation[rh_factor]',
                    ],
                ],
                'phenotype' => [
                    'rules' => [
                        'phenotypeValidation[phenotype]',
                    ],
                ],
                'kell' => [
                    'rules' => [
                        'kellValidation[kell]',
                    ],
                ],
                'group_type' => [
                    'rules' => [
                        'group_typeValidation[group_type]',
                    ],
                ],
            ];
            $error = [
                'id' => [
                    'integer' => lang('Auth.idnonvalido'),
                    'required' => lang('Auth.richiesto'),
                ],
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
                'gender' => [
                    'required' => lang('Auth.genderRequired'),
                    'in_list' => lang('Auth.genderInlist'),
                ],
                'document_number' => [
                    'required' => lang('Auth.donrequired'),
                    'max_length' => lang('Auth.dondmax_length'),
                    'min_length' => lang('Authdonomin_length'),
                    'regex_match' => lang('Auth.donreregex_match'),
                ],
                'avatar' => [
                    'required' => lang('Auth.avtrichiesto'),
                ],
                'oldmail' => [
                    'required' => lang('Auth.olmrichiesto'),
                ],
                'email' => [
                    'required' => lang('Auth.emlrequired'),
                    'max_length' => lang('Auth.emldmax_length'),
                    'valid_email' => lang('Auth.emlvalid'),
                    'is_unique' => lang('Auth.emlunique'),
                ],
                'rh_factor' => [
                    'regex_match' => lang('Auth.rh_factor_regex_match'),
                ],
                'phenotype' => [
                    'regex_match' => lang('Auth.phenotype_regex_match'),
                ],
                'kell' => [
                    'regex_match' => lang('Auth.kell_regex_match'),
                ],
                'group_type' => [
                    'regex_match' => lang('Auth.group_type_regex_match'),
                ],
            ];

            if (!$this->validate($rules, $error)) {
                $data = $this->validator->getErrors();
                foreach ($data as $error) {
                    $er[] = $error;
                }
                $user->id = $postData['id'];
                $risposta = [
                    'msg' => 'fail',
                    'listerror' => $er,
                    'token' => $token,
                    'aer' => $data,
                ];
                header('Content-Type: application/json');

                return $this->response->setJSON($risposta);
            } else {
                $newuser = [
                    'username' => null,
                    'email' => $postData['email'],
                    'password' => $postData['Tax_code'],
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
                    'avatar' => $postData['avatar'],
                    'unique_code' => 0,
                    'authorized' => 0,
                    'first_name' => $postData['first_name'],
                    'id_association' => $postData['id'],
                    'group_type' => $postData['group_type'],
                    'rh_factor' => $postData['rh_factor'],
                    'phenotype' => $postData['phenotype'],
                    'kell' => $postData['kell'],
                    'gender' => $postData['gender'],
                ];
                $user = new user($newuser);
                $users = auth()->getProvider();
                $users->save($user);
                $user = $users->findById($users->getInsertID());
                $user->addGroup('user');
                $user->addPermission('user.change_password', 'user.homeaccess');
                $user->forcePasswordReset();
                $emailManager = new EmailManager();
                $emailManager->getMessage('welcome', $user->id_association, $user->id);
                $risposta=[
                    'msg' => 'success',
                    'token' => $token,
                ];
                return $this->response->setJSON($risposta);
            }
        }
    }

    public function AdimnUpdateUser()
    {
        $request = service('request');
        helper(['form', 'url']);
        if ($this->request->isAJAX() && $this->request->is('post')) {
            $token = csrf_hash();

            $postData = $request->getPost();
            $id = $postData['id'];
            $useradmin = auth()->user();
            $user = auth()->user();
            $rules = [
                'id' => 'required|integer',
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
                'gender' => [
                    'label' => 'Auth.gender',
                    'rules' => [
                        'required',
                        'in_list[M,F]',
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
                'oldmail' => [
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
                        'is_unique[auth_identities.secret,auth_identities.user_id,{id}]',
                    ],
                ],
                'rh_factor' => [
                    'rules' => [
                        'rh_factorValidation[rh_factor]',
                    ],
                ],
                'phenotype' => [
                    'rules' => [
                        'phenotypeValidation[phenotype]',
                    ],
                ],
                'kell' => [
                    'rules' => [
                        'kellValidation[kell]',
                    ],
                ],
                'group_type' => [
                    'rules' => [
                        'group_typeValidation[group_type]',
                    ],
                ],
            ];
            $error = [
                'id' => [
                    'integer' => lang('Auth.idnonvalido'),
                    'required' => lang('Auth.richiesto'),
                ],
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
                'gender' => [
                    'required' => lang('Auth.genderRequired'),
                    'in_list' => lang('Auth.genderInlist'),
                ],
                'document_number' => [
                    'required' => lang('Auth.donrequired'),
                    'max_length' => lang('Auth.dondmax_length'),
                    'min_length' => lang('Authdonomin_length'),
                    'regex_match' => lang('Auth.donreregex_match'),
                ],
                'avatar' => [
                    'required' => lang('Auth.avtrichiesto'),
                ],
                'oldmail' => [
                    'required' => lang('Auth.olmrichiesto'),
                ],
                'email' => [
                    'required' => lang('Auth.emlrequired'),
                    'max_length' => lang('Auth.emldmax_length'),
                    'valid_email' => lang('Auth.emlvalid'),
                    'is_unique' => lang('Auth.emlunique'),
                ],
                'rh_factor' => [
                    'regex_match' => lang('Auth.rh_factor_regex_match'),
                ],
                'phenotype' => [
                    'regex_match' => lang('Auth.phenotype_regex_match'),
                ],
                'kell' => [
                    'regex_match' => lang('Auth.kell_regex_match'),
                ],
                'group_type' => [
                    'regex_match' => lang('Auth.group_type_regex_match'),
                ],
            ];

            if (!$this->validate($rules, $error)) {
                //  var_dump($error);

                $data = $this->validator->getErrors();
                // var_dump($data);

                foreach ($data as $error) {
                    $er[] = $error;
                }
                $user->id = $postData['id'];
                $risposta = [
                    'msg' => 'fail',
                    'listerror' => $er,
                    'token' => $token,
                    'aer' => $data,
                ];
                header('Content-Type: application/json');

                return $this->response->setJSON($risposta);
            } else {
                $user->id = $postData['id'];
                $user->avatar = $postData['avatar'];
                $user->first_name = $postData['first_name'];
                $user->surname = $postData['surname'];
                $user->birth_place = $postData['birth_place'];
                $user->County_of_birth = $postData['County_of_birth'];
                $user->zip_codebirth = $postData['zip_codebirth'];
                $user->birth_status = $postData['birth_status'];
                $user->date_of_birth = $postData['date_of_birth'];
                $user->document_type = $postData['document_type'];
                $user->document_number = $postData['document_number'];
                $user->Tax_code = $postData['Tax_code'];
                $user->City_of_residence = $postData['city_of_residence'];
                $user->Province_of_residence = $postData['Province_of_residence'];
                $user->zip_code = $postData['zip_code'];
                $user->state_of_residence = $postData['state_of_residence'];
                $user->address = $postData['address'];
                $user->email = $postData['email'];
                $user->phone_number = $postData['phone_number'];
                $user->rh_factor = $postData['rh_factor'];
                $user->phenotype = $postData['phenotype'];
                $user->kell = $postData['kell'];
                $user->group_type = $postData['group_type'];
                $modeluser = new UserModel();
                $modeluser->save($user);
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

    public function UpdateUserUniqueCode()
    {
        $request = service('request');
        helper(['form', 'url']);
        //  if ($this->request->isAJAX() && $this->request->$request->is('post')) {
        $token = csrf_hash();
        $postData = $request->getPost();
        $id = $postData['id'];
        $useradmin = auth()->user();
        $user = auth()->user();
        $rules = [
            'id' => 'required|integer',
            'uniquecode' => [
                'label' => 'Auth.uniquecode',
                'rules' => [
                    'required',
                    'max_length[6]',
                    'min_length[6]',
                    'integer',
                ],
            ],
        ];
        $error = [
            'id' => [
                'integer' => lang('Auth.idnonvalido'),
                'required' => lang('Auth.richiesto'),
            ],
            'uniquecode' => [
                'required' => lang('Auth.unrequired'),
                'max_length' => lang('Auth.uniquecode_length'),
                'min_length' => lang('Auth.uniquecode_length'),
                'integer' => lang('Auth.uniquecodeinvalid'),
            ],
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
                'aer' => $data,
            ];
            header('Content-Type: application/json');

            return $this->response->setJSON($risposta);
        } else {
            $user->id = $postData['id'];
            $user->unique_code = $postData['uniquecode'];
            $modeluser = new UserModel();
            $modeluser->save($user);
            $risposta = [
                'msg' => 'ok',
                'token' => $token,
            ];
            //  $this->SendEmail($to, $subject,$from,$name,$message);
            $path = WRITEPATH . '/referti/' . $postData['taxcode'];
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            header('Content-Type: application/json');

            return $this->response->setJSON($risposta);
        }
        // }
    }

    public function UserDelete()
    {
        $request = service('request');
        $token = csrf_hash();
        $rules = [
            'id' => 'required|integer',
        ];
        $error = [
            'id' => lang('idnonvalido'),
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
            $postData = $request->getPost();
            $user = auth()->user();
            $user = auth()->getProvider();
            $user->delete($postData['id'], true);

            return redirect()->redirect('/AdminHome');
        }
    }

    public function GetWritepath(bool $doctor = true): string
    {
        $user = auth()->user();
        if ($doctor) {
            return WRITEPATH . '/referti/dottore/' . $user->id_association . '/';
        } else {
            return WRITEPATH . '/referti/' . $user->Tax_code . '/';
        }
    }

    private function GetEditpath()
    {
        $user = auth()->user();

        return 'assets/referti/dottore/' . $user->id_association . '/' . $user->id . '/';
    }

    public function Uploadfiles()
    {
        $request = service('request');
        $token = csrf_hash();
        helper(['form', 'url']);

        $path = $this->GetWritepath();
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $files = $this->request->getFileMultiple('files');
        $error = [];
        $errorflag = false;
        foreach ($files as $file) {
            $errorverify = false;
            if ($file->isValid() && !$file->hasMoved()) {
                if ($file->getSizeByUnit('kb') > 350) {
                    $errorverify = true;
                    $errorflag = true;
                    $error[] = [
                        'list' => $file->getName() . lang('Auth.moresize'),
                    ];
                }
                if (!in_array($file->getMimeType(), ['application/pdf'])) {
                    $errorverify = true;
                    $errorflag = true;
                    $error[] = [
                        'list' => 'File' . $file->getName() . lang('Auth.mimitype'),
                    ];
                } else {
                    // Get file name and extension
                    if ($errorverify == false) {
                        $name = $file->getName();
                        $file->move($path, $name);
                    }
                }
            }
        }
        $risposta = [
            'msg' => $errorflag,
            'listerror' => $error,
            'token' => $token,
        ];
        header('Content-Type: application/json');

        return $this->response->setJSON($risposta);
    }

    public function ManageReports()
    {
        $request = service('request');
        $token = csrf_hash();
        $directory = $this->GetWritepath();
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        $files = array_diff(scandir($directory), ['.', '..']);
        $Direcotorycontents = [
            'listfile' => $files,
        ];
        $dati['reports'] =
            [
                'token' => $token,
                'filecontenuti' => $Direcotorycontents,
            ];


        return view('Adminview\Manage_reports', $dati);
    }

    public function EditReport()
    {
        $request = service('request');
        $postData = $request->getPost();
        // cartella writepath
        $directory = $this->GetWritepath();
        $pdfFile = $directory . $postData['file'];
        // cartella pubic con creazione catlella e copia file
        $editpath = FCPATH . $this->GetEditpath();
        if (!is_dir($editpath)) {
            mkdir($editpath, 0777, true);
        }
        $editablepath = $editpath . $postData['file'];
        copy($pdfFile, $editablepath);

        $data = [
            'pdf' => base_url() . $this->GetEditpath() . $postData['file'],
            'filename' => $postData['file'],
        ];

        return view('Adminview\show_report', $data);
    }

    public function moveFile()
    {
        $request = service('request');
        $postData = $request->getPost();
        $token = csrf_hash();
        $user = auth()->user();
        $oldFilePath = $this->GetEditpath() . $postData['oldfilename'];
        $time = new Time();
        // Ottieni il timestamp corrente
        $timestamp = $time->getTimestamp();
        $filename = $timestamp . '_' . (!empty($postData['newfile']) ? $postData['newfile'] : $postData['oldfilename']);
        $tempdirectory = $this->GetWritepath() . $postData['oldfilename'];
        $rules = [
            'dresult' => [
                'rules' => [
                    'in_list[ok,ko]',
                    'max_length[2]',
                    'min_length[2]',
                ],
            ],
            'danationtype' => [
                'rules' => [
                    'in_list[piastrine,plasma,sangue]',
                    'max_length[9]',
                    'min_length[6]',
                ],
            ],
            'donationdate' => [
                'rules' => [
                    'valid_date',
                    'required',
                ],
            ],
            'daystop' => [
                'rules' => [
                    'integer',
                    'required',
                ],
            ],
            'notestop' => [
                'rules' => [
                    'regex_match[/\A([a-zA-Z0-9\. \p{L}\p{M}]*|)\z/u]',
                    'max_length[50]',
                ],
            ],
            'noteinpdf' => [
                'rules' => [
                    'regex_match[/\A([a-zA-Z0-9\. \p{L}\p{M}]*|)\z/u]',
                ],
            ],
        ];
        $error = [
            'dresult' => [
                'in_list' => lang('Auth.dresultInlist'),
                'max_length' => lang('Auth.dresultMaxlength'),
                'min_length' => lang('Auth.dresultMinlenght'),
            ],
            'danationtype' => [
                'in_list' => lang('Auth.danationtypeInlist'),
                'max_length' => lang('Auth.danationtypeMaxlength'),
                'min_length' => lang('Auth.danationtypeMinlength'),
            ],
            'donationdate' => [
                'valid_date' => lang('Auth.donation_dateValiddate'),
                'required' => lang('Auth.donation_dateRequired'),
            ],
            'daystop' => [
                'integer' => lang('Auth.day_stopInteger'),
                'required' => lang('Auth.day_stopRequired'),
            ],
            'notestop' => [
                'regex_match' => lang('Auth.stop_noticeString'),
                'required' => lang('Auth.stop_noticeRequired'),
                'max_length' => lang('Auth.stop_noticeMaxlength'),
                'min_length' => lang('Auth.stop_noticeMinlength'),
            ],
            'noteinpdf' => [
                'regex_match' => lang('Auth.notedoctorAlpha_space'),
            ],
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
                'aer' => $data,
            ];
            header('Content-Type: application/json');

            return $this->response->setJSON($risposta);
        } else {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($oldFilePath);
            for ($pageNumber = 1; $pageNumber <= $pageCount; ++$pageNumber) {
                $templateId = $pdf->importPage($pageNumber);
                $pdf->AddPage();
                $pdf->useTemplate($templateId);
            }
            if (!empty($postData['noteinpdf'])) {
                $pdf->AddPage();
                $companyModel = new ModelCompany();
                $company = $companyModel->find($user->id_association);
                $this->addHeader($pdf, $company);
                // Contenuto della nuova pagina
                $content = $postData['noteinpdf'];
                $pdf->SetFont('helvetica', '', 12);
                $pdf->SetTextColor(0, 0, 0);
                $pageHeight = 600 - 20; // Altezza della pagina meno i margini
                $lineHeight = 10; // Altezza della riga in mm
                $currentPositionY = $pdf->GetY();
                $lines = explode("\n", $content);
                // Gestione del contenuto su più pagine
                $currentPositionY = $pdf->GetY();
                $lines = explode("\n", $content);
                foreach ($lines as $line) {
                    $pdf->SetFont('helvetica', '', 12);
                    $currentPositionY = $pdf->GetY();
                    if (($currentPositionY + $lineHeight) > ($pageHeight - 10)) {
                        $pdf->AddPage();
                        $currentPositionY = 10; // Riposiziona sotto l'header della nuova pagina
                    }
                    $pdf->SetY($currentPositionY);
                    $pdf->MultiCell(0, $lineHeight, $line, 0, 'L');
                    $currentPositionY += $lineHeight;
                }
            }
            // salva i risultati delle analisi
            $examdata = [
                'donation_result' => $postData['dresult'],
                'exam_type' => $postData['danationtype'],
                'donation_date' => $postData['donationdate'],
                'day_stop' => $postData['daystop'],
                'unlockdate' => Time::now()->addDays($postData['daystop']),
                'stop_notice' => $postData['notestop'],
                'donation_iduser' => $this->returnuser(0, 4, $postData['taxcodefound']),
                'notedoctor' => $postData['noteinpdf'],
                'upload_date' => $time->today(),
                'file_name' => $filename,
            ];
            $examEntity = new exam();
            $examEntity->fill($examdata);
            $modelexam = new exammodel();
            $modelexam->save($examEntity);
            $id = $modelexam->getInsertID();
            // Salva il PDF aggiornato

            // Invia l'email di conferma memorizza nel db
            $newFilePath = WRITEPATH . '/referti/' . $postData['taxcodefound'] . '/' . $id . '_' . $filename . '.pdf'; // determiniamo il nome e il percorso del file
            $pdf->Output($newFilePath, 'F');
            // 'Eliminiamo I file
            unlink(FCPATH . $oldFilePath);
            unlink($tempdirectory);
            // invia la mail
            $emailManager = new EmailManager();
            $emailManager->getMessage('New_exsam', $user->id_association, $id);
          
            $risposta = [
                'msg' => 'ok',
                'token' => $token,
            ];
            header('Content-Type: application/json');

            return $this->response->setJSON($risposta);
        }
    }

    public function DownloadReportAdmimarea()
    {
        $filename = $this->request->getPost('filename');
        $timestamp = $this->request->getPost('timestamp');
        $idexsam = $this->request->getPost('idexsam');
        $user = auth()->user();
        $filePath = $this->GetWritepath(false) . $user->tax_code . '/' . $filename;
        // Verifica se il file esiste
        if (file_exists($filePath)) {
            $data = [
                'exam_result_id' => $idexsam,
                'download_date' => date('Y-m-d H:i:s'),
                'user_id' => $user->id,
            ];
            $download = new FileDownloadModel();
            $download->save($data);

            return $this->response->download($filePath, null);
        } else {
            echo 'Il file non esiste.';
        }
    }

    public function DelExsam()
    {
        $request = service('request');
        if ($this->request->isAJAX() && $this->request->is('post')) {
            $token = csrf_hash();
            $postData = $request->getPost();
            $id = $postData['idexam'];
            $Exsamrow = new exammodel();
            $rowexsam = $Exsamrow->find($id);
            $namefile = $id . '_' . $rowexsam->file_name;
            $path = $this->GetWritepath(false) . $namefile . '.pdf';

            if (file_exists($path)) {
                unlink($path);
                $Exsamrow->delete($id);
                $type = 'ok';
            } else {
                $Exsamrow->delete($id);
                $type = 'ko';
            }
            $data = [
                'token' => $token,
                'file' => $type,
                'path' => $path,
            ];
            header('Content-Type: application/json');

            return $this->response->setJSON($data);
        }
    }

    public function sendmsg()
    {
        $request = service('request');
        if ($this->request->isAJAX() && $this->request->is('post')) {
            $token = csrf_hash();
            $postData = $request->getPost();
            $id = $postData['id'];
            $type = $postData['type'];
            $user = auth()->user();
            $users = auth()->getProvider();
            $user = $users->findById($id);

            /*
            $Exsamrow = new exammodel();
            $rowexsam = $Exsamrow->find($id);
            $namefile = $id . '_' . $rowexsam->file_name;
            $path = $this->GetWritepath(false) . $namefile . '.pdf';
            if (file_exists($path)) {
                unlink($path);
                $Exsamrow->delete($id);
                $type = 'ok';
            } else {
                $Exsamrow->delete($id);
                $type = 'ko';
            }
            $data = [
                'token' => $token,
                'file' => $type,
                'path' => $path,
            ];
            header('Content-Type: application/json');
            return $this->response->setJSON($data);*/
        }
        $emailManager = new EmailManager();
        $emailManager->getMessage($type, $user->id_association, $id);
        $data = [
            'token' => $token,
        ];
        header('Content-Type: application/json');

        return $this->response->setJSON($data);
    }

    public function UpdatePassword()
    {
        $token = csrf_hash();
        if (!$this->validate($this->getValidationRules())) {
            $data = $this->validator->getErrors();
            foreach ($data as $error) {
                $er[] = $error;
            }
            $risposta = [
                'msg' => 'fail',
                'token' => $token,
                'error' => $er,
            ];
            header('Content-Type: application/json');

            return $this->response->setJSON($risposta);
        }

        $result = auth()->check([
            'email' => auth()->user()->email,
            'password' => $this->request->getPost('old_password'),
        ]);

        if (!$result->isOK()) {
            $risposta = [
                'msg' => 'fail',
                'token' => $token,
                'error' => lang('Auth.oldPasswordWrong'),
            ];
        } else {
            // Success!

            $users = auth()->getProvider();

            $user = auth()->user()->fill([
                'password' => $this->request->getPost('password'),
            ]);

            $users->save($user);
            $risposta = [
                'msg' => 'fail',
                'token' => $token,
                'error' => lang('Auth.newpasswordsuccess'),
            ];
        }
        header('Content-Type: application/json');

        return $this->response->setJSON($risposta);
    }

    public function SaveNewpassword()
    {
        if (!$this->validate($this->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $result = auth()->check([
            'email' => auth()->user()->email,
            'password' => $this->request->getPost('old_password'),
        ]);

        if (!$result->isOK()) {
            return redirect()->to('ForceResetPassword')->withInput()->with('error', 'Auth.oldPasswordWrong');
        }

        // Success!

        $users = auth()->getProvider();

        $user = auth()->user()->fill([
            'password' => $this->request->getPost('password'),
        ]);

        $users->save($user);

        // Remove force password reset flag
        auth()->user()->undoForcePasswordReset();

        // logout user and print login via new password
        auth()->logout();

        return redirect()->to('logout')->with('message', lang('Auth.changePasswordSuccess'));
    }

    public function restpsw()
    {
        echo view('header');

        return view('Adminview/resetpasswordview');
    }

    public function Newpassword()
    {
        return view('Adminview/newpasswordview');
    }

}
