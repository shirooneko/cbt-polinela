<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('/login', 'Login::authenticate');

$routes->get('/admin/getChartData', 'Admin::getChartData');


$routes->get('/mahasiswa/getExamData/(:num)/(:any)', 'Mahasiswa::getExamData/$1/$2');
$routes->get('admin/getExamData/(:num)', 'Admin::getExamData/$1');
$routes->get('/admin/mahasiswa/getMahasiswaByKelas/(:segment)', 'MahasiswaController::getMahasiswaByKelas/$1');
// $routes->get('/admin/mahasiswa/search', 'MahasiswaController::search');
$routes->get('/dosen/filterExams', 'Dosen::filterExams');
$routes->post('/admin/searchMahasiswa', 'Admin::searchMahasiswa');


