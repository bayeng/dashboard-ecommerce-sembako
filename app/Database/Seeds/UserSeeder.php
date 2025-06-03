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
                 'username' => 'penjual2',
                 'password' => password_hash('penjual', PASSWORD_DEFAULT),
                 'role'     => 'penjual',
                 'alamat'   => 'alamat penjual 2',
                 'no_hp'    => 'no hp penjual 2',
                 'toko_id'  => 2,
             ],

            [
                'username' => 'kurir1',
                'password' => password_hash('kurir', PASSWORD_DEFAULT),
                'role'     => 'kurir',
                'alamat'   => 'alamat kurir',
                'no_hp'    => 'no hp kurir',
                'toko_id'  => 1,
            ],

            [
                'username' => 'kurir2',
                'password' => password_hash('kurir', PASSWORD_DEFAULT),
                'role'     => 'kurir',
                'alamat'   => 'alamat kurir',
                'no_hp'    => 'no hp kurir',
                'toko_id'  => 2,
            ],
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
