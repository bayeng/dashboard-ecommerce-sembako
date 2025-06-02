<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'alamat'   => 'alamat admin',
                'no_hp'    => 'no hp admin',
                'toko_id'  => null,
            ],
            [
                'username' => 'penjual1',
                'password' => password_hash('penjual', PASSWORD_DEFAULT),
                'role'     => 'penjual',
                'alamat'   => 'alamat penjual',
                'no_hp'    => 'no hp penjual',
                'toko_id'  => 1,
            ],
            [
                'username' => 'supplier1',
                'password' => password_hash('supplier', PASSWORD_DEFAULT),
                'role'     => 'supplier',
                'alamat'   => 'alamat supplier',
                'no_hp'    => 'no hp supplier',
                'toko_id'  => null,
            ],
            // [
            //     'username' => 'penjual2',
            //     'password' => password_hash('penjual', PASSWORD_DEFAULT),
            //     'role'     => 'penjual',
            //     'alamat'   => 'alamat penjual 2',
            //     'no_hp'    => 'no hp penjual 2',
            //     'toko_id'  => 2,
            // ],
            // [
            //     'username' => 'penjual3',
            //     'password' => password_hash('penjual', PASSWORD_DEFAULT),
            //     'role'     => 'penjual',
            //     'alamat'   => 'alamat penjual 3',
            //     'no_hp'    => 'no hp penjual 3',
            //     'toko_id'  => 3,
            // ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
