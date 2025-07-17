<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPesananProdukAddHargaSatuanColumn extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pesanan_produk', [
            'harga_satuan' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pesanan_produk', 'harga_satuan');
    }
}
