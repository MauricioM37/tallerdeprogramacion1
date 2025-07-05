<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('test-db', 'Home::testDB');
$routes->get('/', 'Home::inicio');
$routes->get('quienesSomos', 'Home::quienes');
$routes->get('contactos', 'Home::contacto');
$routes->get('index', 'Home::inicio');
$routes->get('terminos', 'Home::termino');
$routes->get('comercializacion', 'Home::comercializaciones');
$routes->get('contacto', 'Home::contacto');

$routes->get('register', 'Home::registro');

$routes->post('consultas/guardar', 'ConsultaController::guardar');
$routes->get('contacto', 'ConsultaController::index');

// Rutas para el login y panel
$routes->get('login', 'login_controller::index');
$routes->post('enviarLogin', 'login_controller::auth');
$routes->get('panel', 'login_controller::index', ['filter' => 'auth']);
$routes->get('logout', 'login_controller::logout');

// Rutas para el registro
$routes->post('enviar-form', 'usuario_controller::formValidation');

$routes->post('ventas-ad', 'EnviosAdminController::guardarVenta');


$routes->get('/productos', 'TiposController::index');

$routes->get('compras-usuario', 'EnviosAdminController::indexUser');
//$routes->get('ventas-exito', 'EnviosAdminController::compraRealizada');
$routes->get('ventas-exito', 'EnviosAdminController::cargarVentas');

    // Rutas para ABM de usuarios   
    $routes->get('usuarios', 'UsuariosController::index');
    $routes->get('usuarios/create', 'UsuariosController::create');
    $routes->post('usuarios/store', 'UsuariosController::store');
    $routes->get('usuarios/edit/(:num)', 'UsuariosController::edit/$1');
    $routes->post('usuarios/update/(:num)', 'UsuariosController::update/$1');
    $routes->get('usuarios/delete/(:num)', 'UsuariosController::delete/$1');
    $routes->get('usuarios/baja', 'UsuariosController::baja');
    $routes->get('usuarios/alta/(:num)', 'UsuariosController::alta/$1');

    // Rutas para productos
    $routes->get('productos', 'TiposController::index');
    $routes->get('productos/admin', 'TiposController::admin');
    $routes->get('productos/crear', 'TiposController::crear');
    $routes->post('productos/guardar', 'TiposController::guardar');
    $routes->get('productos/editar/(:num)', 'TiposController::editar/$1');
    $routes->post('productos/actualizar', 'TiposController::actualizar');
    $routes->get('productos/eliminar/(:num)', 'TiposController::eliminar/$1');
    $routes->get('productos/eliminados', 'TiposController::mostrarEliminados');
    $routes->get('productos/restaurar/(:num)', 'TiposController::restaurar/$1');

    // Rutas para consultas
    $routes->get('contacto/formulario', 'ConsultaController::formulario');
    $routes->get('consultas/ver/(:num)', 'ConsultaController::ver/$1');
    $routes->get('consultas/eliminar/(:num)', 'ConsultaController::eliminar/$1');
    $routes->get('consultas/filtrar', 'ConsultaController::filtrar');

    $routes->get('ventas-admin', 'EnviosAdminController::index');


?>