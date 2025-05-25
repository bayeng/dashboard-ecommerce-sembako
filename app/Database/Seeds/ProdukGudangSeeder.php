<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukGudangSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'nama'         => 'Produk ' . $i,
                'kode'         => 'PRD' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'harga'        => rand(10000, 50000),
                'foto'         => 'produk' . $i . '.jpg',
                'stok'         => rand(10, 100),
                'jenis_value'  => rand(1, 2),
                'kategori_id'  => rand(1, 3),
                'supplier_id'  => rand(1, 3),
                'satuan_stok'  => 'pcs'
            ];
        }

        $this->db->table('produk_gudang')->insertBatch($data);
    }
}
