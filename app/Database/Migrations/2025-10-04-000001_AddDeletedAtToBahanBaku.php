<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToBahanBaku extends Migration
{
    public function up()
    {
        $fields = [
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ];

        $this->forge->addColumn('bahan_baku', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('bahan_baku', 'deleted_at');
    }
}
