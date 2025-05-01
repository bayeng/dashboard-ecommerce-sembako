<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukTransfer extends Migration
{
    public function up()
    {
        $this->forge->addField(([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'jumlah' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'harga' => [
                'type' => 'FLOAT',
                'constraint' => 11,
            ],
            'produk_gudang_id' => [
                'type' => 'INT',
            ],
            'produk_toko_id' => [
                'type' => 'INT',
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
            ]));
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('produk_gudang_id', 'produk_gudang', 'id', 'CASCADE', 'CASCADE', 'fk_produk_transfer_produk_gudang');
        $this->forge->addForeignKey('produk_toko_id', 'produk_toko', 'id', 'CASCADE', 'CASCADE', 'fk_produk_transfer_produk_toko');
        $this->forge->createTable('produk_transfer');
    }

    public function down()
    {
        $this->forge->dropTable('produk_transfer');
    }
}
