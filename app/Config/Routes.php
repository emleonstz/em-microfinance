<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index',['filter'=>'oauth']);
$routes->get('/login', 'LoginController::index');
$routes->post('/auth', 'LoginController::login');
$routes->get('/logout', 'LoginController::logout');
