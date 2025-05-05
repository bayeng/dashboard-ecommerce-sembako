<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/hello', function () {
    return view('pages/hello-world');
});

$routes->group('', ['namespace' => 'App\Controllers\Web'], function ($routes) {

    // Supplier
    $routes->get('supplier', 'SupplierController::index');
    $routes->post('supplier/store', 'SupplierController::store');
    $routes->put('supplier/update/(:num)', 'SupplierController::update/$1');
    $routes->post('supplier/delete/(:num)', 'SupplierController::delete/$1');

    // Kategori
    $routes->get('kategori-gudang', 'KategoriController::index');
    $routes->post('kategori-gudang/store', 'KategoriController::store');
    $routes->put('kategori-gudang/update/(:num)', 'KategoriController::update/$1');
    $routes->post('kategori-gudang/delete/(:num)', 'KategoriController::delete/$1');
});

