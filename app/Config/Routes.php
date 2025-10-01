<?php


use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');


$routes->get('/login', 'AuthController::index');
$routes->post('/auth/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

$routes->group('gudang', ['filter' => 'role:gudang'], static function ($routes) {
    $routes->get('dashboard', 'GudangController::index');
});

$routes->group('dapur', ['filter' => 'role:dapur'], static function ($routes) {
    $routes->get('dashboard', 'DapurController::index');
    
  
});


$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/dashboard', 'Home::index');
});