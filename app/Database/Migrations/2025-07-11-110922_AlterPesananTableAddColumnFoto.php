<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPesananTableAddColumnFoto extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pesanan', [
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pesanan', 'foto');
    }
}
