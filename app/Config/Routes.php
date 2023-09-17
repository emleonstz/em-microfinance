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
$routes->post('/hifadimkopaji', 'WakopajiController::kusanyafomuYkuhariri',['filter'=>'oauth']);
$routes->get('/haririwakopaji/(:any)', 'WakopajiController::fomuYakuhariri/$1',['filter'=>'oauth']);
$routes->get('/tazamamkopaji/(:any)', 'WakopajiController::tazama/$1',['filter'=>'oauth']);
$routes->get('/pakuamkataba/(:any)', 'WakopajiController::pakuafomu/$1',['filter'=>'oauth']);
$routes->post('/hifadhimdhamin', 'GuarantorController::ongezaMdahamin',['filter'=>'oauth']);
$routes->post('/haririmdhamin', 'GuarantorController::haririMdahamin',['filter'=>'oauth']);
$routes->get('/ongezamkopo/(:any)', 'MikopoController::index/$1',['filter'=>'oauth']);
$routes->get('/calc', 'MikopoController::kototoa',['filter'=>'oauth']);
$routes->post('/ombamkopo', 'MikopoController::processMkopo',['filter'=>'oauth']);
$routes->get('/tazamamkopo/(:any)', 'MikopoController::tazamaMkopo/$1',['filter'=>'oauth']);



