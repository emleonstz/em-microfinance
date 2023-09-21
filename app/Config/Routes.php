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
$routes->get('/ratibamalipo/(:any)', 'MikopoController::ratibaYaMalipo/$1',['filter'=>'oauth']);
$routes->get('/baruayamaombi/(:any)', 'MikopoController::baruaYakuombaMkopo/$1',['filter'=>'oauth']);
$routes->get('/futamaombi/(:any)', 'MikopoController::futaMkopo/$1',['filter'=>'oauth']);
$routes->get('/tazamamalipo/(:any)', 'MikopoController::tazamaMalipo/$1',['filter'=>'oauth']);
$routes->get('/tazamamikopo', 'MikopoController::orodhaYaMikopo',['filter'=>'oauth']);
$routes->get('/mikopoisiyomalizika', 'MikopoController::orodhaYaMikopoHajimalizika',['filter'=>'oauth']);
$routes->get('/mikopoisiyolipwa', 'MikopoController::orodhaYaMikopoHajalipwa',['filter'=>'oauth']);
$routes->get('/maombiyanayosubiri', 'MikopoController::orodhaYaMikopoPending',['filter'=>'oauth']);
$routes->get('/iliyopitiliza', 'MikopoController::orodhaYaMikopoPitiliza',['filter'=>'oauth']);
$routes->post('/lipamkopo', 'MikopoController::lipaMkopo',['filter'=>'oauth']);











