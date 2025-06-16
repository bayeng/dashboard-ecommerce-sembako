<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bumbus extends Migration
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
            'resep_id' => [
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
        $this->forge->addForeignKey('resep_id', 'reseps', 'id');
        $this->forge->createTable('bumbus');
    }

    public function down()
    {
        $this->forge->dropTable('bumbus');
    }
}
