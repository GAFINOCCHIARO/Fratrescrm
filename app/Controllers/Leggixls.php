<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Comunimodel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\Files\File;
use CodeIgniter\Database\QueryBuilder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Leggixls extends BaseController
{
    public function index()
    {
       
        $file = '../writable/uploads/it.xls';

            $data = $this->readFile($file);
          // print_r($data);
          $this->insertData($data);
    
        echo"saaaaaaaaaaaaaaaaaaaaaaaaaa";
    }

     private function readFile($file)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getActiveSheet();

        $data = [];
        for ($i = 1; $i <= $worksheet->getHighestRow(); $i++) {
            $data[] = [
               
             'nome_comune'    =>   $worksheet->getCellByColumnAndRow(1, $i)->getValue(),
             'cap'            =>   $worksheet->getCellByColumnAndRow(2, $i)->getValue(),
             'sigla_provincia'=>   $worksheet->getCellByColumnAndRow(3, $i)->getValue(),
            'citta'           =>   $worksheet->getCellByColumnAndRow(4, $i)->getValue(),
            'regione'         =>   $worksheet->getCellByColumnAndRow(5, $i)->getValue(),
            'attivo'          =>   $worksheet->getCellByColumnAndRow(6, $i)->getValue(),
            ];
            
        }
       return $data;
    }

    private function insertData(array $data)
    {
        
        $comune= new ComuniModel();

        foreach ($data as $row) {
            print_r($row);
            echo  '<br>';
           $comune->save($row);
             echo  '<br>';
        
        }

    
      //  print_r($data);
    }
}
    
