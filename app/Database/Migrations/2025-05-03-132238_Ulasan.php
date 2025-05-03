<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ulasan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'rating' => [
                'type' => 'TINYINT',
                'constraint' => 1,
            ],
            'kurir_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'pesanan_id' => [
                'type' => 'INT',
                'null' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kurir_id', 'kurir', 'id', 'CASCADE', 'CASCADE', 'fk_ulasan_kurir');
        $this->forge->addForeignKey('pesanan_id', 'pesanan', 'id', 'CASCADE', 'CASCADE', 'fk_ulasan_pesanan');
        $this->forge->createTable('ulasan');

    }

    public function down()
    {
        $this->forge->dropTable('ulasan');

    }
}
