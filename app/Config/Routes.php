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

$routes->get('/gudang/dashboard', 'GudangController::index', ['filter' => 'auth:gudang']);
$routes->get('/dapur/dashboard', 'DapurController::index', ['filter' => 'auth:dapur']);