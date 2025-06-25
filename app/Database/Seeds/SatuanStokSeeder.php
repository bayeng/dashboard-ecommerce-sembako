<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SatuanStokSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'PCS'],
            ['nama' => 'KG'],
            ['nama' => 'LITER'],
        ];

        $this->db->table('satuan_stok')->insertBatch($data);
    }
}
