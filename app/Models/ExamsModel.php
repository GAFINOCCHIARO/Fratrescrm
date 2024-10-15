<?php

namespace App\Models;

use CodeIgniter\Model;

class ExamsModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'exam_results';
    protected $primaryKey = 'id_examresults ';
    protected $useAutoIncrement = true;
    protected $returnType = \App\Entities\ExamEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_examresults', 'donation_result', 'exam_type', 'donation_date', 'day_stop',
                                 'unlockdate','stop_notice', 'donation_iduser', 'notedoctor','upload_date','file_name',
                               ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}
