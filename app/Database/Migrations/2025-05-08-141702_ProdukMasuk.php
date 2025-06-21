<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukMasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'supplier_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'produk_gudang_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'stok' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'satuan_stok' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'harga' => [
                'type' => 'FLOAT',
                'constraint' => 11,
            ],
            'tanggal_masuk' => [
                'type' => 'DATE',
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
        $this->forge->addForeignKey('supplier_id', 'supplier', 'id', 'CASCADE', 'CASCADE', 'fk_produk_masuk_supplier');
        $this->forge->addForeignKey('produk_gudang_id', 'produk_gudang', 'id', 'cascade', 'cascade', 'fk_produk_masuk_produk_gudang');
        $this->forge->createTable('produk_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('produk_masuk');
    }
}
