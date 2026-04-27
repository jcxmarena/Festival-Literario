<?php
// Aquí se gestionan las localizaciones dentro del panel de administrador
namespace Controllers;

use MVC\Router;
use Model\Localizacion;
use Model\Evento;

class LocalizacionesController {

    // Listado de localizaciones
    public static function index(Router $router) {
        $localizaciones = Localizacion::all();

        if(!is_admin()) {
            header('Location: /login');
        }

        $router->render('admin/localizaciones/index', [
            'titulo' => 'Localizaciones',
            'localizaciones' => $localizaciones
        ]);
    }

    // Crear localizacion
    public static function crear(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];
        $localizacion = new Localizacion;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
            header('Location: /login');
        }    

            $localizacion->sincronizar($_POST);
            $alertas = $localizacion->validar();

            //Guardar el registro
            if(empty($alertas)) {
                // Guardar en la BD
                $resultado = $localizacion->guardar();

                if($resultado) {
                    header('Location: /admin/localizaciones');
                }
            }
        }

        $router->render('admin/localizaciones/crear', [
            'titulo' => 'Añadir localización',
            'alertas' => $alertas,
            'localizacion' => $localizacion
        ]);
    }

    // Editar localizacion
    public static function editar(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/localizaciones');
        }

        $localizacion = Localizacion::find($id);

        if(!$localizacion) {
            header('Location: /admin/localizaciones');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
            header('Location: /login');
        }

            $localizacion->sincronizar($_POST);
            $alertas = $localizacion->validar();

            if(empty($alertas)) {
                $resultado = $localizacion->guardar();
                if($resultado) {
                    header('Location: /admin/localizaciones');
                }
            }
        }

        $router->render('admin/localizaciones/editar', [
            'titulo' => 'Actualizar localización',
            'alertas' => $alertas,
            'localizacion' => $localizacion
        ]);

    }

    // Eliminar localizacion
    public static function eliminar() {
    if (!is_admin()) {
        header('Location: /login');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/localizaciones');
            exit;
        }

        $numEventos = Evento::total('id_localizacion', $id);

        if ($numEventos > 0) {
            $_SESSION['alerta'] = "No se puede eliminar la localización porque tiene {$numEventos} evento(s) asociados.";
            header('Location: /admin/localizaciones');
            exit;
        }

        $localizacion = Localizacion::find($id);
        if (!$localizacion) {
            header('Location: /admin/localizaciones');
            exit;
        }

        $resultado = $localizacion->eliminar();
        if ($resultado) {
            header('Location: /admin/localizaciones');
            exit;
        }
    }
}

}