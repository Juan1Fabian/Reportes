<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/reporte/r1','ReporteController::getReporte1');
$routes->get('/reporte/r2','ReporteController::getReporte2');
$routes->get('/reporte/r3','ReporteController::getReporte3');
$routes->get('/reporte/filtro','ReporteController::Filtro');
$routes->get('/reporte/r4','ReporteController::getReporte4');
$routes->get('/reporte/filtroR5', 'ReporteController::buscar'); 
$routes->post('/reporte/r5', 'ReporteController::getReporte5'); 