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
});

