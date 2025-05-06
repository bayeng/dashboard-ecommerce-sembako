<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukMentah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'supplier_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'kuantiti' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'satuan_kuantiti' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'harga' => [
                'type'       => 'FLOAT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('supplier_id', 'supplier', 'id', 'CASCADE', 'CASCADE', 'fk_produk_mentah_suppliers');
        $this->forge->createTable('produk_mentah');
    }

    public function down()
    {
        $this->forge->dropTable('produk_mentah');
    }
}
