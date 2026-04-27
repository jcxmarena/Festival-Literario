<?php

// Aquí se controlas las vistas públicas

namespace Controllers;

use Model\Evento;
use Model\Categoria;
use Model\Escritor;
use Model\Localizacion;
use Model\Libro;
use Model\Registro;
use Model\Editorial;
use MVC\Router; 

class PaginasController {

    public static function index(Router $router) {

        // Importamos todo lo necesario que vamos a visualizar en el inicio

        $escritores = Escritor::total();
        $localizaciones = Localizacion::total();
        $eventos = Evento::total();
        $registros = Registro::total();
        $editoriales = Editorial::ordenar('nombre', 'ASC');

        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'eventos' => $eventos,
            'escritores' => $escritores,
            'localizaciones' => $localizaciones,
            'registros' => $registros,
            'editoriales' => $editoriales,
        ]);
    }

    public static function festival(Router $router) {
        // Como es estática no necesitamos nada más

        $router->render('paginas/festival', [
            'titulo' => 'Sobre el festival'
        ]);

    }

    public static function localizaciones(Router $router) {
        // Aádimos solo las localizaciones
        $localizaciones = Localizacion::ordenar('nombre', 'ASC');

        $router->render('paginas/localizaciones', [
            'titulo' => '¿Dónde nos encontramos?',
            'localizaciones' => $localizaciones,
        ]);

    }

    public static function escritores(Router $router) {

        // Añadimos los escritores y libros. 

        $escritores = Escritor::ordenar('nombre', 'ASC');
        $libros = Libro::all();

        // Indexar libros por escritor
        $librosPorEscritor = [];
        foreach ($libros as $libro) {
            $librosPorEscritor[$libro->getIdEscritor()][] = $libro;
        }

        $router->render('paginas/escritores', [
            'titulo' => 'Los escritores de este año',
            'escritores' => $escritores,
            'librosPorEscritor' => $librosPorEscritor
        ]);

    }

    public static function programa(Router $router) {

        $eventos = Evento::ordenar('fecha', 'ASC');

        foreach($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->getIdCategoria());
            $evento->escritor = Escritor::find($evento->getIdEscritor());
            $evento->localizacion = Localizacion::find($evento->getIdLocalizacion());
        }

        $router->render('paginas/programa', [
            'titulo' => 'Programación',
            'eventos' => $eventos
        ]);

    }

    public static function entradas(Router $router) {

        // Si el usuario no está identificado muestra igualmente la página pero con un error que indica que se inicie sesión

        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!isset($_SESSION['usuario_id'])) {
            Registro::setAlerta('error', 'Debes iniciar sesión para registrar entradas.');
            $eventos = Evento::ordenar('fecha', 'ASC');
            $alertas = Registro::getAlertas();
            return $router->render('paginas/entradas', [
                'titulo' => 'Entradas',
                'eventos' => $eventos,
                'alertas' => $alertas
            ]);
        }

        $alertas = [];
        $eventos = Evento::ordenar('fecha', 'ASC');

        // Creamos el registro con los datos del formulario

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = (int) $_SESSION['usuario_id'];
            $id_evento  = isset($_POST['id_evento']) ? (int) $_POST['id_evento'] : 0;

            $registro = new Registro([
                'id_usuario' => $id_usuario,
                'id_evento'  => $id_evento
            ]);

            $alertas = $registro->validar();

            // Comprobamossi hay duplicados
            if (empty($alertas['error']) && Registro::yaRegistrado($id_usuario, $id_evento)) {
                Registro::setAlerta('error', 'Ya estás registrado en este evento.');
            }

            // Guardamos
            if (empty(Registro::getAlertas()['error'])) {
                $ok = false;

                $ok = $registro->guardar();

                if ($ok) {
                    Registro::setAlerta('exito', '¡Registro completado! Comprueba tus entradas en el menú administración.');
                } else {
                    Registro::setAlerta('error', 'No ha sido posible registrar tu entrada.');
                }
            }

            $alertas = Registro::getAlertas();
        }

        $router->render('paginas/entradas', [
            'titulo' => '¡Consigue ya tu entrada!',
            'eventos'  => $eventos,
            'alertas'  => $alertas
        ]);

    }

    public static function error(Router $router) {

        // Página estática estilo error 404

        $router->render('paginas/error', [
            'titulo' => 'Página no encontrada'
        ]);

    }

    public static function misEntradas(\MVC\Router $router)
{
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    if (!isset($_SESSION['usuario_id'])) {
        \Model\Registro::setAlerta('error', 'Debes iniciar sesión para ver tus entradas.');
        $router->render('paginas/mis-entradas', [
            'titulo'  => 'Mis entradas',
            'registros' => [],
            'alertas' => \Model\Registro::getAlertas()
        ]);
        return;
    }

    $idUsuario = (int) $_SESSION['usuario_id'];

    // Para eliminar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accion       = $_POST['accion'] ?? '';
        $id_registros = isset($_POST['id_registros']) ? (int)$_POST['id_registros'] : 0;

        if ($accion === 'eliminar' && $id_registros > 0) {
            if (Registro::eliminarDeUsuario($id_registros, $idUsuario)) {
                Registro::setAlerta('exito', 'Tu inscripción ha sido anulada.');
            } else {
                Registro::setAlerta('error', 'No se pudo anular la inscripción.');
            }
        } else {
            Registro::setAlerta('error', 'Acción no válida.');
        }
    }

    // Listado actualizado
    $registros = Registro::porUsuario($idUsuario);
    $alertas   = Registro::getAlertas();

    $router->render('paginas/mis-entradas', [
        'titulo'    => 'Mis entradas',
        'registros' => $registros,
        'alertas'   => $alertas
    ]);
}

}