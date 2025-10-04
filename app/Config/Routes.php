<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->GET('/', 'AuthController::index');

// Auth Routes
$routes->GET('login', 'AuthController::index');
$routes->POST('login', 'AuthController::login');
$routes->GET('logout', 'AuthController::logout');

$routes->group('gudang', ['filter' => 'auth:gudang'], static function($routes) {
	$routes->get('dashboard', 'GudangController::index');
	$routes->get('bahan/create', 'GudangController::create');
	$routes->post('bahan/store', 'GudangController::store');
	$routes->get('bahan/(:num)/update-stock', 'GudangController::updateStockForm/$1');
	$routes->post('bahan/(:num)/update-stock', 'GudangController::updateStock/$1');
	$routes->get('bahan/(:num)/delete', 'GudangController::confirmDelete/$1');
	$routes->post('bahan/(:num)/delete', 'GudangController::delete/$1');
});

$routes->get('/dapur/dashboard', 'DapurController::index', ['filter' => 'auth:dapur']);