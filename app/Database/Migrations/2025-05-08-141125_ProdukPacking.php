<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukPacking extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'produk_mentah_id' => [
                'type' => 'INT',
                'constrint' => 11,
            ],
            'produk_gudang_id' => [
                'type' => 'INT',
                'constrint' => 11,
            ],
            'stok' => [
                'type' => 'INT',
                'constrint' => 11,
            ],
            'satuan_stok' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('produk_mentah_id', 'produk_gudang', 'id', 'CASCADE', 'CASCADE', 'fk_produk_packing_produk_mentah');
        $this->forge->addForeignKey('produk_gudang_id', 'produk_gudang', 'id', 'CASCADE', 'CASCADE', 'fk_produk_packing_produk_gudang');
        $this->forge->createTable('produk_packing');
    }

    public function down()
    {
        $this->forge->dropTable('produk_packing');
    }
}
