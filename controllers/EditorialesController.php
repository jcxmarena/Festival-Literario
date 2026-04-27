<?php
// Aquí se gestionan las editoriales dentro del panel de administrador.
namespace Controllers;

use MVC\Router;
use Model\Editorial;
use Model\Libro;

class EditorialesController {

    // Listado de editoriales
    public static function index(Router $router) {
        $editoriales = Editorial::all();

        if(!is_admin()) {
            header('Location: /login');
        }

        $router->render('admin/editoriales/index', [
            'titulo' => 'Editoriales',
            'editoriales' => $editoriales
        ]);
    }

    public static function crear(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];
        $editorial = new Editorial;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
            header('Location: /login');
        }    

            $editorial->sincronizar($_POST);
            $alertas = $editorial->validar();

            if(empty($alertas)) {
                $resultado = $editorial->guardar();

                if($resultado) {
                    header('Location: /admin/editoriales');
                }
            }
        }

        $router->render('admin/editoriales/crear', [
            'titulo' => 'Añadir editorial',
            'alertas' => $alertas,
            'editorial' => $editorial
        ]);
    }

    // Crear editoriales
    public static function editar(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/editoriales');
        }

        $editorial = Editorial::find($id);

        if(!$editorial) {
            header('Location: /admin/editoriales');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
            header('Location: /login');
        }

            $editorial->sincronizar($_POST);
            $alertas = $editorial->validar();

            if(empty($alertas)) {
                $resultado = $editorial->guardar();
                if($resultado) {
                    header('Location: /admin/editoriales');
                }
            }
        }

        $router->render('admin/editoriales/editar', [
            'titulo' => 'Actualizar editorial',
            'alertas' => $alertas,
            'editorial' => $editorial
        ]);

    }

    // Eliminar editoriales
    public static function eliminar() {
    if (!is_admin()) {
        header('Location: /login');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/editoriales');
            exit;
        }

        $numLibros = Libro::total('id_editorial', $id);

        if ($numLibros > 0) {
            $_SESSION['alerta'] = "No se puede eliminar la editorial porque tiene {$numLibros} libro(s) asociados.";
            header('Location: /admin/editoriales');
            exit;
        }

        $editorial = Editorial::find($id);
        if (!$editorial) {
            header('Location: /admin/editoriales');
            exit;
        }

        $resultado = $editorial->eliminar();
        if ($resultado) {
            header('Location: /admin/editoriales');
            exit;
        }
    }
}


}