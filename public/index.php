<?php   

require __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropiedadController;
use Controllers\VendedorControllers;

$router = new Router();

$router->get('/admin', [PropiedadController::class, 'index']);
$router->get('/propiedades/crear', [PropiedadController::class, 'crear']);
$router->post('/propiedades/crear', [PropiedadController::class, 'crear']);
$router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/propiedades/eliminar', [PropiedadController::class, 'eliminar']);

$router->get('/vendedores/crear', [VendedorControllers::class, 'crear']);
$router->post('/vendedores/crear', [VendedorControllers::class, 'crear']);
$router->get('/vendedores/actualizar', [VendedorControllers::class, 'actualizar']);
$router->post('/vendedores/actualizar', [VendedorControllers::class, 'actualizar']);
$router->post('/vendedores/eliminar', [VendedorControllers::class, 'eliminar']);

$router->comprobarRutas();