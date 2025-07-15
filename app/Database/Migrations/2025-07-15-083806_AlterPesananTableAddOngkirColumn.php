<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPesananTableAddOngkirColumn extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pesanan', [
            'ongkir' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pesanan', 'ongkir');
    }
}
