<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('wiki', 'wikiController::index');
$routes->get('pretendientes', 'wikiController::pretendientesLista');
$routes->post('verPretendiente', 'wikiController::verPretendiente');
$routes->get('personajes', 'wikiController::personajesLista');
$routes->post('verPersonaje', 'wikiController::verPersonaje');
$routes->get('lugares', 'wikiController::lugaresLista');
$routes->post('verLugar', 'wikiController::verLugar');
$routes->get('control', 'wikiController::control');
$routes->post('control', 'wikiController::control');

$routes->get('login', 'Users::login');
$routes->post('login', 'Users::login');

//$routes->get('olvide_contrasenia', 'Users::olvide_contrasenia');
//$routes->post('olvide_contrasenia', 'Users::olvide_contrasenia');

$routes->get('signUp', 'Users::signUp');
$routes->post('signUp', 'Users::signUp');

$routes->get('logOut', 'Users::logOut');
$routes->post('logOut', 'Users::login');

$routes->get('perfil', 'Users::update');
$routes->post('perfil', 'Users::update');
$routes->post('update', 'Users::update');
$routes->get('update', 'Users::update');

$routes->get('updatePassword', 'Users::updatePassword');
$routes->post('updatePassword', 'Users::updatePassword');

$routes->get('delete', 'Users::deleteUser');
$routes->post('delete', 'Users::deleteUser');

$routes->get('control_usuarios', 'Users::controlUsuarios');
$routes->post('control_usuarios', 'Users::controlUsuarios');

$routes->post('esAdmin', 'Users::nivelUsuario');
$routes->post('acceso', 'Users::acceso');
$routes->post('deleteUser', 'Users::borrarUsuario');

$routes->get('play', 'Play::juega');
$routes->get('recreativos', 'Play::recreativos');
$routes->post('jugarCapitulo', 'Play::seleccionarCapitulo');
$routes->post('saveAvatar', 'Play::saveAvatar');
$routes->post('avanzarDialogo', 'Play::avanzarDialogo');
$routes->post('elegirRespuesta', 'Play::elegirRespuesta');

$routes->get('foro', 'Foro::foro');
$routes->post('foro', 'Foro::foro');
$routes->post('comenta', 'Foro::comentar');
$routes->post('verPerfil', 'Users::verOtroPerfil');
$routes->post('denunciarComentario', 'Foro::denunciarComentario');
$routes->post('denunciarUsuario', 'Users::denunciarUsuario');
$routes->post('bloquearUsuario', 'Foro::bloquearUsuario');
$routes->post('borrarComentario', 'Foro::borrarComentario');

$routes->get('contacta', 'Mensajes::contacta');
$routes->post('control_mensajes', 'Mensajes::control_mensajes');
$routes->get('control_mensajes', 'Mensajes::control_mensajes');
$routes->post('guardarmensajes', 'Mensajes::guardarmensajes');
$routes->get('guardarmensajes', 'Mensajes::guardarmensajes');

$routes->get('deleteMsg', 'Mensajes::deleteMsg');
$routes->post('deleteMsg', 'Mensajes::deleteMsg');



