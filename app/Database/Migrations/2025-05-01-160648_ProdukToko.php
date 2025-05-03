<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukToko extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kode' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'harga' => [
                'type' => 'FLOAT',
                'constraint' => 11,
                'null' => true,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 350,
                'null' => true,
            ],
            'stok' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'toko_id' => [
                'type' => 'INT',
                'null' => false,
            ],
            'kategori_id' => [
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
            $this->forge->addForeignKey('toko_id', 'toko', 'id', 'CASCADE', 'CASCADE', 'fk_produk_toko_toko');
            $this->forge->addForeignKey('kategori_id', 'kategori', 'id', 'CASCADE', 'CASCADE', 'fk_produk_toko_kategori');
            $this->forge->createTable('produk_toko');
    }

    public function down()
    {
        $this->forge->dropTable('produk_toko');
    }
}
