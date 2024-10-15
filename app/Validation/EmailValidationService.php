<?php
namespace App\Validation;
use App\Models\UserModel;
class EmailValidationService
{
   
  
    
    public function isUniqueEmail(string $id, string $mail,array $oldmail)
    {
      // var_dump($mail);
       //var_dump($oldmail) ;
        if ($oldmail == $mail) {
            return true;
        }else{
            $userModel = new UserModel();
            $existingUserCount = $userModel->where('id !=', $id)
                                            ->where('secret', $mail)
                                            ->countAllResults();
            return $existingUserCount === 0;
            }
            
    }

      
}
