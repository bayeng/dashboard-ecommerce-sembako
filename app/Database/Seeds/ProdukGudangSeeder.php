<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukGudangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'         => 'Paha ayam ',
                'kode'         => 'MNTH' . str_pad('KBG', 4, '0', STR_PAD_LEFT),
                'harga'        => rand(10000, 50000),
                'foto'         => 'gudang-' . 1 . '.png',
                'stok'         => rand(10, 100),
                'jenis_value'  => 2,
                'kategori_id'  => 1,
                'supplier_id'  => 1,
                'satuan_stok'  => 'KG'
            ],
            [
                'nama'         => 'Kepala Kambing ',
                'kode'         => 'MNTH' . str_pad('KBG', 4, '0', STR_PAD_LEFT),
                'harga'        => rand(10000, 50000),
                'foto'         => 'gudang-' . 2 . '.png',
                'stok'         => rand(10, 100),
                'jenis_value'  => 2,
                'kategori_id'  => 1,
                'supplier_id'  => 1,
                'satuan_stok'  => 'KG'
            ]
        ];
        $this->db->table('produk_gudang')->insertBatch($data);
    }
}
