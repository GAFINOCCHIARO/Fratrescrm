<?php
namespace App\Trait;
use CodeIgniter\I18n\Time;

trait StringCaseConverter
{
 public function GetString(?string $str,$encoding = "UTF-8", $lower_str_end = true):string
 {
  if ($str !== null && strlen($str) > 0) 
  {
    $str = mb_convert_case($str, MB_CASE_TITLE, $encoding);
  }
   return $str ?? '';
 }
 public function formatItDateTime($datetime)
    {
      if (empty($datetime)){
        return null;
      }else{
        return Time::parse($datetime)->toLocalizedString('dd-MM-yyyy');
      }
    }
}