<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUploadFieldsToExamResults extends Migration
{
    public function up()
    {
        $this->forge->addColumn('exam_results', [
            'upload_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'notedoctor' // assuming 'notedoctor' is the last field
            ],
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'upload_date'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('exam_results', 'upload_date');
        $this->forge->dropColumn('exam_results', 'file_name');
    }
}
