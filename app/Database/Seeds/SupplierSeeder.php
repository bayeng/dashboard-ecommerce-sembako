<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'PT Sumber Makmur',
                'alamat' => 'Jl. Kemerdekaan No.10, Jakarta',
                'no_hp' => '081234567890',
                'email' => 'makmur@supplier.com',
                'bank' => 'BRI',
                'no_rekening' => '1234567890',
            ],
        ];

        $this->db->table('supplier')->insertBatch($data);
    }
}
