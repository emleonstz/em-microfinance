<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index',['filter'=>'oauth']);
$routes->get('/ingia', 'LoginController::index',['filter'=>'maskani']);
$routes->post('/auth', 'LoginController::login',['filter'=>'maskani']);
$routes->get('/ondoka', 'LoginController::logout');
$routes->get('/wakopaji', 'WakopajiController::index',['filter'=>'oauth']);
$routes->get('/ongezawakopaji', 'WakopajiController::fomuYakuongeza',['filter'=>'oauth']);
$routes->post('/sajilimtumiaji', 'WakopajiController::kusanyafomuYakuongeza',['filter'=>'oauth']);
$routes->get('/tazamamkopaji/(:any)', 'WakopajiController::tazama/$1',['filter'=>'oauth']);
