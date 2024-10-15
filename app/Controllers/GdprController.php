<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\models\GdprModel;
use CodeIgniter\I18n\Time;
class GdprController extends BaseController
{
    public function index()
    {
      $now = Time::now()->toLocalizedString('yyyy-MM-dd_HH-mm-ss');
      $user=auth()->user();
      $consenso="Con la presente dichiarazione, Io ".$user->username." ".$user->surname." confermo di aver fornito il mio consenso al trattamento dei dati personali da parte dell'Associazione di donazione sangue per le seguenti finalità:
Fornire i risultati delle analisi della donazione di sangue I dati personali che verranno raccolti sono:
Nome e cognome del donatore
Codice fiscale del donatore
Data di nascita del donatore
Dati relativi alla donazione di sangue, come ad esempio la data della donazione, il tipo di sangue donato e i risultati delle analisi
Il consenso fornito è valido per un periodo di tempo illimitato.
L'utente può revocare il consenso in qualsiasi momento, contattando l'Associazione di donazione sangue all'indirizzo [indirizzo email] o al numero [numero di telefono].
L'Associazione di donazione sangue si impegna a trattare i dati personali degli utenti in modo sicuro e conforme alla legge.
L'Associazione di donazione sangue si riserva il diritto di modificare la presente dichiarazione di consenso in qualsiasi momento.;
Data: '.$now'";
echo'************************************************';
echo'<br>';
if (!is_string($consenso)) {
    echo 'Il contenuto del file non è una stringa.';
}else{
    echo"è una stringa".'<br>';
}
helper("filesystem");
 $path='./assets/consensogdpr/';
 if(!is_dir($path))
        {
            mkdir($path,0777,TRUE);
        }

$nomefile=$path.$user->id.'_'.$user->Tax_code.'_'.$user->username.'_'.$user->surname.$now.'.txt';
echo $consenso;
echo'<br>';
echo $nomefile;
if (!write_file($nomefile, $consenso)){
    echo'<br>';
 echo"errore";
}else{
   
    $registrogdpr= new GdprModel();
    $data=[
         'iduser'       => $user->id,
        'data_consenso' =>$now,
        'filename'     => $nomefile
    ];
    $registrogdpr->save($data);
    return redirect()->redirect("/Homeuser");
    }
}
}
