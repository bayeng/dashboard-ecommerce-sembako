<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPesananTableAddCatatanKurir extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pesanan', [
            'catatan_kurir' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pesanan', 'catatan_kurir');
    }
}
