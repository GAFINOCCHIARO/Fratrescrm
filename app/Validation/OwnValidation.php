<?php

namespace App\Validation;

class OwnValidation
{
    public function rh_factorValidation(string $str, string $fields, array $data): bool
    {
        if ($data['rh_factor'] == '') {
            return true;
        } else {
            // Assuming rh_factor should be "+" or "-"
            $regex = '/^[\+\-]$/';

            return preg_match($regex, $data['rh_factor']) ? true : false;
        }
    }

    public function phenotypeValidation(string $str, string $fields, array $data): bool
    {
        if ($data['phenotype'] == '') {
            return true;
        } else {
            $regex = '/^(?:(CC|Cc|cc)(DD|Dd|dd)(EE|Ee|ee)?'
                   .'|(CC|Cc|cc)(EE|Ee|ee)(DD|Dd|dd)?'
                   .'|(DD|Dd|dd)(CC|Cc|cc)(EE|Ee|ee)?'
                   .'|(DD|Dd|dd)(EE|Ee|ee)(CC|Cc|cc)?'
                   .'|(EE|Ee|ee)(CC|Cc|cc)(DD|Dd|dd)?'
                   .'|(EE|Ee|ee)(DD|Dd|dd)(CC|Cc|cc)?)$/';

            return preg_match($regex, $data['phenotype']) ? true : false;
        }
    }

    public function kellValidation(string $str, string $fields, array $data): bool
    {
        if ($data['kell'] == '') {
            return true;
        } else {
            $regex = '/^(KK|Kk|kK|kk)$/';

            return preg_match($regex, $data['kell']) ? true : false;
        }
    }

    public function group_typeValidation(string $str, string $fields, array $data): bool
    {
        if ($data['group_type'] == '') {
            return true;
        } else {
            $regex = '/^(A|B|AB|O)(\+|-)?$/';

            return preg_match($regex, $data['group_type']) ? true : false;
        }
    }
}
