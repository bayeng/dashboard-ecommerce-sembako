<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', function () {
    return view('pages/dashboard/index');
});
$routes->get('/hello', function () {
    return view('pages/hello-world');
});
$routes->get('login', 'Web\AuthController::index');
$routes->post('auth/login', 'Web\AuthController::login');
$routes->post('auth/logout', 'Web\AuthController::logout');


$routes->group('', ['namespace' => 'App\Controllers\Web', 'filter' => 'auth'], function ($routes) {

    $routes->group('admin', function ($routes) {
        // dashboard
        $routes->get('/', 'DashboardController::dashboardAdmin');

        // user
        $routes->group('pengguna', function ($routes) {
            $routes->get('', 'UserController::index');
            $routes->post('store', 'UserController::store');
            $routes->put('update/(:num)', 'UserController::update/$1');
            $routes->post('delete/(:num)', 'UserController::delete/$1');
        });

        // toko
        $routes->group('toko', function ($routes) {
            $routes->get('', 'TokoController::index');
            $routes->post('store', 'TokoController::store');
            $routes->put('update/(:num)', 'TokoController::update/$1');
            $routes->post('delete/(:num)', 'TokoController::delete/$1');
        });

        $routes->group('detail-toko', function ($routes) {
            $routes->get('(:num)', 'ProductTransferController::show/$1');
            $routes->post('store', 'ProductTransferController::transferToStore');
            $routes->put('update/(:num)', 'ProductTransferController::update/$1');
            $routes->post('delete/(:num)', 'ProductTransferController::delete/$1');
        });

        // Supplier
        $routes->get('supplier', 'SupplierController::index');
        $routes->post('supplier/store', 'SupplierController::store');
        $routes->put('supplier/update/(:num)', 'SupplierController::update/$1');
        $routes->post('supplier/delete/(:num)', 'SupplierController::delete/$1');

        // Produk Mentah
        $routes->get('produk-mentah', 'ProdukMentahController::index');
        $routes->get('produk-mentah/pengemasan-produk/(:num)', 'ProdukMentahController::showPengemasanProduk/$1');
        $routes->post('produk-mentah/store', 'ProdukMentahController::store');
        $routes->post('produk-mentah/pengemasan-produk', 'ProdukMentahController::tambahPengemasanProduk');
        $routes->post('produk-mentah/pengemasan-produk/tambah-stok', 'ProdukMentahController::tambahStokPengemasanProduk');
        $routes->put('produk-mentah/update/(:num)', 'ProdukMentahController::update/$1');
        $routes->post('produk-mentah/delete/(:num)', 'ProdukMentahController::delete/$1');

        // Pengemasan Produk
        $routes->get('pengemasan-produk', 'PengemasanProdukController::index');
        $routes->post('pengemasan-produk/store', 'PengemasanProdukController::store');
        $routes->put('pengemasan-produk/update/(:num)', 'PengemasanProdukController::update/$1');
        $routes->post('pengemasan-produk/delete/(:num)', 'PengemasanProdukController::delete/$1');

        // resep
        $routes->get('resep', 'ResepController::index');
        $routes->get('resep/create', 'ResepController::create');
        $routes->get('resep/edit/(:num)', 'ResepController::edit/$1');
        $routes->post('resep/store', 'ResepController::store');
        $routes->put('resep/update/(:num)', 'ResepController::update/$1');
        $routes->post('resep/delete/(:num)', 'ResepController::delete/$1');

        // Produk Gudang
        $routes->get('produk-gudang', 'ProdukGudangController::index');
        $routes->post('produk-gudang/store', 'ProdukGudangController::store');
        $routes->put('produk-gudang/update/(:num)', 'ProdukGudangController::update/$1');
        $routes->post('produk-gudang/delete/(:num)', 'ProdukGudangController::delete/$1');

        // Pengemesan Stok
        $routes->get('pengemasan-stok', 'ProductTransferController::showPengemasanStok');
        $routes->post('pengemasan-stok', 'ProductTransferController::createPengemasanStok');
//        $routes->put('pengemasan-stok/update/(:num)', 'ProductTransferController::update/$1');
        $routes->post('pengemasan-stok/(:num)', 'ProductTransferController::deletePengemasanStok/$1');

        // Kategori
        $routes->get('kategori', 'KategoriController::index');


    });

    $routes->group('kategori', function ($routes) {
        $routes->post('store', 'KategoriController::store');
        $routes->put('update/(:num)', 'KategoriController::update/$1');
        $routes->post('delete/(:num)', 'KategoriController::delete/$1');
    });

    $routes->group('toko', function ($routes) {
        $routes->get('', 'DashboardController::dashboardToko');

        $routes->get('kategori', 'KategoriController::index');

        $routes->group('produk', function ($routes) {
            $routes->get('', 'ProdukTokoController::index');
            $routes->post('store', 'ProdukTokoController::store');
            $routes->put('update/(:num)', 'ProdukTokoController::update/$1');
            $routes->post('delete/(:num)', 'ProdukTokoController::delete/$1');
        });

        $routes->group('pesanan', function ($routes) {
            $routes->get('', 'PesananController::index', ['as' => 'pesanan.index']);
            $routes->get('(:num)', 'PesananController::show/$1', ['as' => 'pesanan.show']);
            $routes->put('update/(:num)', 'PesananController::update/$1', ['as' => 'pesanan.update']);
            $routes->post('delete/(:num)', 'PesananController::delete/$1', ['as' => 'pesanan.delete']);
        });
        // kurir
        $routes->group('kurir', function ($routes) {
            $routes->get('', 'KurirController::index');
            $routes->post('store', 'KurirController::store');
            $routes->put('update/(:num)', 'KurirController::update/$1');
            $routes->post('delete/(:num)', 'KurirController::delete/$1');
        });
    });
});


$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    //Login
    $routes->post('auth/login', 'AuthController::login');
    $routes->post('auth/register', 'AuthController::register');
    $routes->post('auth/logout', 'AuthController::logout');

    //Kurir
    $routes->get('kurir', 'KurirController::getAllKurirByFilters');
    $routes->get('kurir/(:num)', 'KurirController::getKurirById/$1');
    $routes->post('kurir/ulasan/(:num)', 'KurirController::createUlasanKurir/$1');
    $routes->get('kurir/ulasan', 'KurirController::getAllUlasanByKurirId');
    $routes->get('kurir/total-rating', 'KurirController::getTotalRatingByKurirId');

    //produk toko
    $routes->get('produk', 'ProdukTokoController::getAllProdukTokoByFilters');
    $routes->get('produk/(:num)', 'ProdukTokoController::getProdukTokoById/$1');

    // alamat
    $routes->get('alamat', 'AlamatController::getAlamatByFilters');
    $routes->get('alamat/(:num)', 'AlamatController::getAlamatById/$1');
    $routes->post('alamat', 'AlamatController::addAlamat');
    $routes->post('alamat/(:num)', 'AlamatController::updateAlamat/$1');
    $routes->post('alamat/(:num)', 'AlamatController::deleteAlamat/$1');

    //keranjang
    $routes->get('keranjang', 'KeranjangController::getKeranjangByUser');
    $routes->get('keranjang/(:num)', 'KeranjangController::getKeranjangById/$1');
    $routes->post('keranjang', 'KeranjangController::createKeranjangUser');
    $routes->put('keranjang/(:num)', 'KeranjangController::updateKeranjangUser/$1');
    $routes->post('keranjang/delete/(:num)', 'KeranjangController::deleteKeranjangUser/$1');

    $routes->group('pesanan', function ($routes) {
        $routes->get('', 'PesananController::getAllPesananByFilters');
        $routes->get('(:num)', 'PesananController::getPesananById/$1');
        $routes->post('', 'PesananController::createPesanan');
        $routes->post('(:num)', 'PesananController::updateStatusPesanan/$1');
        $routes->post('delete/(:num)', 'PesananController::deletePesanan/$1');
    });

    $routes->group('resep', function ($routes) {
        $routes->get('', 'ResepController::getResepByFilters');
        $routes->get('(:num)', 'ResepController::getResepById/$1');
    });
});
