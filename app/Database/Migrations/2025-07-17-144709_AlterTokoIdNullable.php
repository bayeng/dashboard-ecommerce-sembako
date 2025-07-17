<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTokoIdNullable extends Migration
{
    public function up()
    {
        $fields = [
            'toko_id' => [
                'name' => 'toko_id',
                'type' => 'INT',
                'null' => true, // ubah agar bisa NULL
            ],
        ];

        $this->forge->modifyColumn('pesanan_produk', $fields);
    }

    public function down()
    {
        $fields = [
            'toko_id' => [
                'name' => 'toko_id',
                'type' => 'INT',
                'null' => false, // rollback ke NOT NULL
            ],
        ];

        $this->forge->modifyColumn('pesanan_produk', $fields);
    }
}
