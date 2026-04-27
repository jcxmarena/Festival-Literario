<?php 

// Este archivo define las rutas de la aplicación y qué controlador debe ejecutarse en cada momento

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\EscritoresController;
use Controllers\RegistrosController;
use Controllers\EventosController;
use Controllers\LibrosController;
use Controllers\EditorialesController;
use Controllers\LocalizacionesController;
use Controllers\CategoriasController;
use Controllers\PaginasController;

$router = new Router();

// Formulario login 
$router->get('/login', [AuthController::class, 'login']); // Renderiza la vista del login
$router->post('/login', [AuthController::class, 'login']); // Procesa los credenciales

// Logout
$router->post('/logout', [AuthController::class, 'logout']);

// Formulario registro 
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Administración

$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/registros', [RegistrosController::class, 'index']);
$router->post('/admin/registros/eliminar', [RegistrosController::class, 'eliminar']);

$router->get('/admin/eventos', [EventosController::class, 'index']);
$router->get('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->post('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->get('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/eliminar', [EventosController::class, 'eliminar']);

$router->get('/admin/escritores', [EscritoresController::class, 'index']);
$router->get('/admin/escritores/crear', [EscritoresController::class, 'crear']);
$router->post('/admin/escritores/crear', [EscritoresController::class, 'crear']);
$router->get('/admin/escritores/editar', [EscritoresController::class, 'editar']);
$router->post('/admin/escritores/editar', [EscritoresController::class, 'editar']);
$router->post('/admin/escritores/eliminar', [EscritoresController::class, 'eliminar']);

$router->get('/admin/libros', [LibrosController::class, 'index']);
$router->get('/admin/libros/crear', [LibrosController::class, 'crear']);
$router->post('/admin/libros/crear', [LibrosController::class, 'crear']);
$router->get('/admin/libros/editar', [LibrosController::class, 'editar']);
$router->post('/admin/libros/editar', [LibrosController::class, 'editar']);
$router->post('/admin/libros/eliminar', [LibrosController::class, 'eliminar']);


$router->get('/admin/editoriales', [EditorialesController::class, 'index']);
$router->get('/admin/editoriales/crear', [EditorialesController::class, 'crear']);
$router->post('/admin/editoriales/crear', [EditorialesController::class, 'crear']);
$router->get('/admin/editoriales/editar', [EditorialesController::class, 'editar']);
$router->post('/admin/editoriales/editar', [EditorialesController::class, 'editar']);
$router->post('/admin/editoriales/eliminar', [EditorialesController::class, 'eliminar']);

$router->get('/admin/localizaciones', [LocalizacionesController::class, 'index']);
$router->get('/admin/localizaciones/crear', [LocalizacionesController::class, 'crear']);
$router->post('/admin/localizaciones/crear', [LocalizacionesController::class, 'crear']);
$router->get('/admin/localizaciones/editar', [LocalizacionesController::class, 'editar']);
$router->post('/admin/localizaciones/editar', [LocalizacionesController::class, 'editar']);
$router->post('/admin/localizaciones/eliminar', [LocalizacionesController::class, 'eliminar']);

$router->get('/admin/categorias', [CategoriasController::class, 'index']);
$router->get('/admin/categorias/crear', [CategoriasController::class, 'crear']);
$router->post('/admin/categorias/crear', [CategoriasController::class, 'crear']);
$router->get('/admin/categorias/editar', [CategoriasController::class, 'editar']);
$router->post('/admin/categorias/editar', [CategoriasController::class, 'editar']);
$router->post('/admin/categorias/eliminar', [CategoriasController::class, 'eliminar']);

// Zona pública

$router->get('/', [PaginasController::class, 'index']);
$router->get('/festival', [PaginasController::class, 'festival']);
$router->get('/programa', [PaginasController::class, 'programa']);
$router->get('/localizaciones', [PaginasController::class, 'localizaciones']);
$router->get('/escritores', [PaginasController::class, 'escritores']);
$router->get('/entradas', [PaginasController::class, 'entradas']);
$router->post('/entradas', [PaginasController::class, 'entradas']);

$router->get('/404', [PaginasController::class, 'error']);

$router->get('/mis-entradas', [\Controllers\PaginasController::class, 'misEntradas']);
$router->post('/mis-entradas', [\Controllers\PaginasController::class, 'misEntradas']);



$router->comprobarRutas(); // Lee la ruta actual y la lista de rutas registradas. Si está bien se ejecuta, de lo contrario mostrará el mensaje de error
