<?php
// app/Traits/EmailTrait.php

namespace App\Trait;
trait EmailTrait
{
    public function sendEmail($to, $subject,$from,$name, $message)
    {
        $email = \Config\Services::email();

        $email->setTo($to);
        $email->setFrom($from, $name);
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) {
            return true;
        } else {
            return false;
        }
    }
}
