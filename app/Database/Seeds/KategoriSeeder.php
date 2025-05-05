<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Makanan'],
            ['nama' => 'Minuman'],
            ['nama' => 'Bahan Mentah'],
            ['nama' => 'Peralatan Dapur'],
            ['nama' => 'Kemasan'],
        ];

        $this->db->table('kategori')->insertBatch($data);
    }
}
