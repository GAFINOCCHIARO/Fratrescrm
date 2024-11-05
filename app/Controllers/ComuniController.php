<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComuniModel;
class ComuniController extends BaseController
{
    public function index()
    {
        //
    }
    public function getComuni()
    {
        $request = service('request');
         $postData = $request->getPost();

         $response = array();
        $token = csrf_hash();
         $data = array();

         if(isset($postData['search'])){
               $search = $postData['search'];
               $comuni = new ComuniModel();
               $comunilist = $comuni->select('id_comuni ,nome_comune,cap,sigla_provincia,citta,regione,nazione')
                           ->like('nome_comune',$search)
                           ->orderBy('nome_comune')
                           ->findAll(10);
               foreach($comunilist as $comuni){
                     $data[] = array(
                           "value" => $comuni['nome_comune'].' '.$comuni['sigla_provincia'].' '.$comuni['cap'].' '.$comuni['regione'].' '.$comuni['nazione'],
                           "nome_comune" => $comuni['nome_comune'],
                           "cap"         => $comuni['cap'],
                           "citta"       => $comuni['sigla_provincia'],
                           "regione"     => $comuni['regione'],
                           "nazione"     => $comuni['nazione'],
                     );
               }
         }

         $response= [
               'result'=>$data,
               'token'=>$token,
         ];
        // var_dump($response);
         return $this->response->setJSON($response);

     }
    
}
