<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TokoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Toko 1',
                'alamat' => 'Alamat Toko 1',
                'foto' => 'toko1.jpg',
            ],
            [
                'nama' => 'Toko 2',
                'alamat' => 'Alamat Toko 2',
                'foto' => 'toko1.jpg',
            ],
            [
                'nama' => 'Toko 3',
                'alamat' => 'Alamat Toko 3',
                'foto' => 'toko1.jpg',
            ],
            [
                'nama' => 'Toko 4',
                'alamat' => 'Alamat Toko 4',
                'foto' => 'toko1.jpg',
            ],
        ];

        $this->db->table('toko')->insertBatch($data);
    }
}
