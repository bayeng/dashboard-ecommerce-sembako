<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
//        $this->call('SupplierSeeder');
//        $this->call('KategoriSeeder');
//        $this->call('ProdukGudangSeeder');
//        $this->call('ProdukPackingSeeder');
//        $this->call('TokoSeeder');
        $this->call('UserSeeder');
    }
}
