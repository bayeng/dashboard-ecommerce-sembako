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
            [
                'nama' => 'CV Sinar Terang',
                'alamat' => 'Jl. Matahari No.20, Bandung',
                'no_hp' => '082112341234',
                'email' => 'sinar@supplier.com',
                'bank' => 'BCA',
                'no_rekening' => '9876543210',
            ],
            [
                'nama' => 'UD Lancar Jaya',
                'alamat' => 'Jl. Anggrek No.30, Surabaya',
                'no_hp' => '083812345678',
                'email' => 'lancar@supplier.com',
                'bank' => 'BNI',
                'no_rekening' => '5678901234',
            ],
        ];

        $this->db->table('supplier')->insertBatch($data);
    }
}
