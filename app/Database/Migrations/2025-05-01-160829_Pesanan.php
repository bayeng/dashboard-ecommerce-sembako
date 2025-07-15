<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pesanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'kode_pesanan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'alamat_pengiriman' => [
                'type' => 'LONGTEXT',
            ],
            'total_harga' => [
                'type' => 'FLOAT',
                'constraint' => 11,
            ],
            'metode_pembayaran' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status_value' => [
                'type' => 'TINYINT',
                'constraint' => 1,
            ],
            'catatan' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'lat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'lng' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'kurir_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'user_id' => [
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
            $this->forge->addForeignKey('kurir_id', 'kurir', 'id', 'CASCADE', 'CASCADE', 'fk_pesanan_kurir');
            $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE', 'fk_pesanan_user');
            $this->forge->addForeignKey('toko_id', 'toko', 'id', 'CASCADE', 'CASCADE', 'fk_pesanan_toko');
            $this->forge->createTable('pesanan');
    }

    public function down()
    {
        $this->forge->dropTable('pesanan');
    }
}
