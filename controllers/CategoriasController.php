<?php
// Aquí se gestionan las categorías dentro del panel de administrador. Se repite más o menos lo mismo por cada sección correspondiente
namespace Controllers;

use MVC\Router;
use Model\Categoria;
use Model\Evento;
use Model\Libro;

class CategoriasController {

    // Listado de categorías
    public static function index(Router $router) {
        // Cargamos todas las categorías desde el modelo
        $categorias = Categoria::all();

        // Seguridad solo para admins
        if(!is_admin()) {
            header('Location: /login');
            exit;
        }
        // Renderizamos vista
        $router->render('admin/categorias/index', [
            'titulo' => 'Categorías',
            'categorias' => $categorias
        ]);
    }

    // Crear categoría
    public static function crear(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];
        $categoria = new Categoria;

        // Si llega el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {  

            // Sincronizamos propiedades con los campos
            $categoria->sincronizar($_POST);
            // Validamos
            $alertas = $categoria->validar();

            //Guardamos si no hay errores y volvemos al listado
            if(empty($alertas)) {
                $resultado = $categoria->guardar();

                if($resultado) {
                    header('Location: /admin/categorias');
                }
            }
        }

        $router->render('admin/categorias/crear', [
            'titulo' => 'Añadir categoría',
            'alertas' => $alertas,
            'categoria' => $categoria
        ]);
    }

    // Editar categoría
    public static function editar(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];

        // Validamos el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/categorias');
        }

        // Obtenemos la categoría por su ID
        $categoria = Categoria::find($id);

        if(!$categoria) {
            header('Location: /admin/categorias');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $categoria->sincronizar($_POST);
            $alertas = $categoria->validar();

            if(empty($alertas)) {
                $resultado = $categoria->guardar();
                if($resultado) {
                    header('Location: /admin/categorias');
                }
            }
        }

        $router->render('admin/categorias/editar', [
            'titulo' => 'Actualizar categoría',
            'alertas' => $alertas,
            'categoria' => $categoria
        ]);

    }

    // Eliminar una categoría
    public static function eliminar() {
        if(!is_admin()) {
            header('Location: /login');
            exit;
        }
 
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (session_status() !== PHP_SESSION_ACTIVE) session_start();

            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if (!$id) {
                header('Location: /admin/categorias');
                exit;
            }

            $numEventos = Evento::total('id_categoria', $id);
            $numLibros  = Libro::total('id_categoria', $id);

            if ($numEventos > 0 || $numLibros > 0) {
                $partes = [];
                if ($numEventos > 0) $partes[] = "{$numEventos} evento(s)";
                if ($numLibros  > 0) $partes[] = "{$numLibros} libro(s)";
                $detalle = implode(' y ', $partes);

                $_SESSION['alerta'] = "No se puede eliminar la categoría porque tiene {$detalle} asociados.";
                header('Location: /admin/categorias');
                exit;
            }

            $categoria = Categoria::find($id);
            if(!$categoria) {
                header('Location: /admin/categorias');
                exit;
            }

            $resultado = $categoria->eliminar();
            if($resultado) {
                header('Location: /admin/categorias');
                exit;
            }
        }
    }


}