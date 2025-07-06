<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('TokoSeeder');
        $this->call('UserSeeder');
        $this->call('KurirSeeder');
        $this->call('SupplierSeeder');
        $this->call('KategoriSeeder');
        $this->call('SatuanStokSeeder');
        $this->call('ProdukMentahSeeder');
        $this->call('ProdukGudangSeeder');
//        $this->call('ProdukPackingSeeder');
    }
}
