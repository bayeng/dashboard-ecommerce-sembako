<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KurirSeeder extends Seeder
{
    public function run()
    {
        $data = [
          [
              'nama' => 'JNE',
              'foto' => 'jne.jpg',
              'no_hp' => '081234567890',
              'alamat' => 'Jl. Kemerdekaan No.10, Jakarta',
              'kontak_person' => 'John Doe',
              'user_id' => 4,
              'toko_id' => 1
          ],
            [
                'nama' => 'JNT',
                'foto' => 'jnt.jpg',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Kemerdekaan No.10, Jakarta',
                'kontak_person' => 'John Doe',
                'user_id' => 5,
                'toko_id' => 2
            ]
        ];

        $this->db->table('kurir')->insertBatch($data);
    }
}
