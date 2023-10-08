<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('wiki', 'wikiController::index');
$routes->get('pretendientes', 'wikiController::pretendientesLista');
$routes->get('personajes', 'wikiController::personajesLista');
$routes->get('pretendientes', 'wikiController::lugaresLista');
$routes->get('login', 'Users::login');
$routes->get('signUp', 'Users::signUp');

