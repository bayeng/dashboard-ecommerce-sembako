<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PesananProduk extends Migration
{
    public function up()
    {
        $this->forge->addField([
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
            'produk_toko_id' => [
                'type' => 'INT',
            ],
            'pesanan_id' => [
                'type' => 'INT',
            ],
            'toko_id' => [
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
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('produk_toko_id', 'produk_toko', 'id', 'CASCADE', 'CASCADE', 'fk_pesanan_produk_produk_toko');
            $this->forge->addForeignKey('pesanan_id', 'pesanan', 'id', 'CASCADE', 'CASCADE', 'fk_pesanan_produk_pesanan');
            $this->forge->addForeignKey('toko_id', 'toko', 'id', 'CASCADE', 'CASCADE', 'fk_pesanan_produk_toko');
            $this->forge->createTable('pesanan_produk');
    }

    public function down()
    {
        $this->forge->dropTable('pesanan_produk');
    }
}
