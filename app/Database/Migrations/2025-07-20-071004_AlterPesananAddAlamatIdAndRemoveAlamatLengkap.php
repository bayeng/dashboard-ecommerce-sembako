<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPesananAddAlamatIdAndRemoveAlamatLengkap extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pesanan', [
            'alamat_id' => [
                'type' => 'int',
                'unsigned' => true,
                'null' => true,
            ],
        ]);
        $this->forge->dropColumn('pesanan', [
            'alamat_pengiriman',
            'lat',
            'lng'
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pesanan', 'alamat_id');
        $this->forge->addColumn('pesanan', [
            'alamat_pengiriman' => [
                'type' => 'text',
                'null' => true,
            ],
            'lat' => [
                'type' => 'float',
                'null' => true,
            ],
            'lng' => [
                'type' => 'float',
                'null' => true,
            ],
        ]);
    }
}
