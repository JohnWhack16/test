<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/penjualan', 'Penjualan::index');
$routes->get('/penjualan/create', 'Penjualan::create');
$routes->post('/penjualan/create', 'Penjualan::create');
$routes->get('/penjualan/edit/(:segment)', 'Penjualan::edit/$1');
$routes->post('/penjualan/edit/(:segment)', 'Penjualan::edit/$1');
$routes->get('/penjualan/delete/(:segment)', 'Penjualan::delete/$1');
$routes->get('/penjualan/view/(:segment)', 'Penjualan::view/$1');

