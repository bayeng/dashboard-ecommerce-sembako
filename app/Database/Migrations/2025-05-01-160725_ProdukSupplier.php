<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukSupplier extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'produk_gudang_id' => [
                'type' => 'INT',
            ],
            'supplier_id' => [
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
            $this->forge->addForeignKey('produk_gudang_id', 'produk_gudang', 'id', 'CASCADE', 'CASCADE', 'fk_produk_supplier_produk_gudang');
            $this->forge->addForeignKey('supplier_id', 'suppliers', 'id', 'CASCADE', 'CASCADE', 'fk_produk_supplier_supplier');
            $this->forge->createTable('produk_supplier');
    }

    public function down()
    {
        $this->forge->dropTable('produk_supplier');
    }
}
