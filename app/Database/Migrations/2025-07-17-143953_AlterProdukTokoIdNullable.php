<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterProdukTokoIdNullable extends Migration
{
    public function up()
    {
        $fields = [
            'produk_toko_id' => [
                'name' => 'produk_toko_id',
                'type' => 'INT',
                'null' => true, // ini yang membuat kolomnya nullable
            ],
        ];

        $this->forge->modifyColumn('pesanan_produk', $fields);
    }

    public function down()
    {
        $fields = [
            'produk_toko_id' => [
                'name' => 'produk_toko_id',
                'type' => 'INT',
                'null' => false, // rollback ke not nullable
            ],
        ];

        $this->forge->modifyColumn('pesanan_produk', $fields);
    }
}
