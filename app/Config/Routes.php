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

$routes->get('/reporte/showui','ReporteController::showUIreporte');

$routes->post('/reporte/publisher','ReporteController::getReportByPublisher');
$routes->post('/reporte/racealignment','ReporteController::getReportByRaceAlignment');

$routes->get('/dashboard/informe01','DashboardController::getinforme01');
$routes->get('/dashboard/informe2','DashboardController::getinforme02');
$routes->get('/dashboard/informe3','DashboardController::getinforme03');

$routes->get('/public/api/Informe2','DashboardController::getDataInforme2');
$routes->get('/public/api/Informe3','DashboardController::getDataInforme3');
$routes->get('/public/api/Informe3','DashboardController::getDataInforme3Cache');

//Ruta de los informes
$routes->get('/dashboard/genderReporte','DashboardController::getGenero');
$routes->get('/dashboard/PublisherCount','DashboardController::getInformePublishers');
$routes->get('/dashboard/avgWeight','DashboardController::getInformeAvgWeight');
//Ruta de las APIs
$routes->get('/public/api/publisherCounts', 'DashboardController::getDataPublishers');
$routes->get('/public/api/avgWeightByPublisher','DashboardController::getDataAvgWeightByPublisher');
//Ruta que genera el PDF
$routes->get('/dashboard/pdf','DashboardController::VistaPdf');