<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterAlamatTableRefactor extends Migration
{
    public function up()
    {
        // Ubah nama kolom 'provinsi' menjadi 'nama_penerima'
        $this->forge->modifyColumn('alamat', [
            'provinsi' => [
                'name'       => 'nama_penerima',
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);

        // Ubah nama kolom 'kabupaten' menjadi 'nomor_hp'
        $this->forge->modifyColumn('alamat', [
            'kabupaten' => [
                'name'       => 'nomor_hp',
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        // Balikkan nama kolom jika migrasi di-rollback
        $this->forge->modifyColumn('alamat', [
            'nama_penerima' => [
                'name'       => 'provinsi',
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);

        $this->forge->modifyColumn('alamat', [
            'nomor_hp' => [
                'name'       => 'kabupaten',
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);
    }
}
