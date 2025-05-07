<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukGudang extends Migration
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
            'harga' => [
                'type' => 'FLOAT',
                'constraint' => 11,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 350,
            ],
            'stok' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'kategori_id' => [
                'type' => 'INT',
            ],
            'produk_mentah_id' => [
                'type' => 'INT',
                'null' => true,
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
            $this->forge->addForeignKey('kategori_id', 'kategori', 'id', 'CASCADE', 'CASCADE', 'fk_produk_gudang_kategori');
            $this->forge->createTable('produk_gudang');
    }

    public function down()
    {
        $this->forge->dropTable('produk_gudang');
    }
}
