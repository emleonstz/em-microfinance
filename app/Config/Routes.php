<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index',['filter'=>'oauth']);
$routes->get('/login', 'LoginController::index',['filter'=>'maskani']);
$routes->post('/auth', 'LoginController::login',['filter'=>'maskani']);
$routes->get('/logout', 'LoginController::logout');
