<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdukPackingSeeder extends Seeder
{
    public function run()
    {
        $produkJadi = $this->db->table('produk_gudang')
            ->select('id')
            ->where('jenis_value', 2)
            ->get()
            ->getResultArray();

        // Ambil ID produk dengan jenis_value 1 (produk mentah)
        $produkMentah = $this->db->table('produk_gudang')
            ->select('id')
            ->where('jenis_value', 1)
            ->get()
            ->getResultArray();

        $data = [];

        // Misal buat 5 data packing
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'produk_gudang_id'   => $produkJadi[array_rand($produkJadi)]['id'],
                'produk_mentah_id'   => $produkMentah[array_rand($produkMentah)]['id'],
                'stok'               => rand(10, 50),
                'satuan_stok'        => 'pcs'
            ];
        }

        $this->db->table('produk_packing')->insertBatch($data);
    }
}
