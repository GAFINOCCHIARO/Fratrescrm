<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ConsentMethodModel as Consentmodel;
use App\Models\PrivacypoliciesModel as Privacymodel;

class PrivacyController extends BaseController
{
    public function privacyaccept()
    {
        $user = auth()->user();
        $token = csrf_hash();
        $request = service('request');
        $idpolicy = $request->getPost('id');
        $consentmodel = new Consentmodel();
        $dataupdate = [
            'consent_status' => 'accepted',
            'consent_method' => 'click',
            'consent_date' => date('Y-m-d H:i:s'),
            'user_ip' => $request->getIPAddress(),
        ];
        $exist=$consentmodel->where('policy_id', $idpolicy)
            ->where('user_id', $user->id)
            ->where('company_id', $user->id_association)
            ->where('consent_date <', date('Y-m-d H:i:s'))
            ->first();

        if (!$exist) 
        {
            $datatoinsert = [
                'user_id'
                => $user->id,
                'policy_id'
                => $idpolicy,
                'company_id'
                => $user->id_association,
                'consent_date'
                => date('Y-m-d H:i:s'),
                'consent_status'
                => 'accepted',
                'consent_method'
                => 'click',
                'user_ip'
                => $request->getIPAddress(),
            ];
            $consentmodel->save($datatoinsert);
        } else {
            $consentmodel->where('user_id', $user->id)
                ->where('company_id', $user->id_association)
                ->where('consent_status', 'pending')
                ->where('policy_id', $idpolicy)
                ->set($dataupdate)
                ->update();
        }
        $res = [
            'msg' => 'ok',
            'token' => $token,
        ];

        return $this->response->setJSON($res);
    }
    public function privacypolicypopup()
    {
        $user = auth()->user();
        $Privacymodel = new Privacymodel();
        $policy = $Privacymodel->where('company_id', $user->id_association)
            ->where('is_active', 1)
            ->first();


        echo view('user\policypop', [
            'text' => $policy->policy_text,
            'id'  => $policy->id,
        ]);
    }
    public function privacycheck()
    {
        $user = auth()->user();
        $privacyPolicyModel = new Privacymodel();
        $query = $privacyPolicyModel->db->query("
                                                 SELECT pp.id AS policy_id, upc.id AS consent_id
                                                 FROM privacy_policies AS pp
                                                 LEFT JOIN user_privacy_consents AS upc ON pp.id = upc.policy_id 
                                                 AND upc.user_id = ?
                                                 AND upc.consent_status = 'accepted'
                                                 AND upc.consent_date >= pp.effective_date
                                                WHERE pp.is_active = 1
                                                 LIMIT 1", [$user->id]);
        $result = $query->getRow();
        if (!($result && $result->consent_id)) {
            $this->privacypolicypopup();
        }
    }
    public function GetCompanyactivepolicy($idassociation)
    {
        $privacyPolicyModel = new Privacymodel();
        $policy = $privacyPolicyModel->where('company_id', $idassociation)
            ->where('is_active', 1)
            ->first();
        return $policy;
    }
    public function Savenewconsent($iduser, $idassociation)
    {
        $request = service('request');
        $consentmodel = new Consentmodel();
        $policyactive = $this->GetCompanyactivepolicy($idassociation);
        $datatoinsert = [
            'user_id'
            => $iduser,
            'policy_id'
            => $policyactive->id,
            'company_id'
            => $idassociation,
            'consent_date'
            => date('Y-m-d H:i:s'),
            'consent_status'
            => 'pending',
            'consent_method'
            => 'in_office',
            'user_ip'
            => $request->getIPAddress(),
        ];
        $consentmodel->save($datatoinsert);
    }
}
