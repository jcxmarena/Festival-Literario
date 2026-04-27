<?php

// Aquí se gestionan los libros dentro del panel de Administración

namespace Controllers;

use MVC\Router;
use Model\Escritor;
use Model\Editorial;
use Model\Categoria;
use Model\Libro;

class LibrosController {

    // Listado de libros
    public static function index(Router $router) {
        $libros = Libro::all();

        if(!is_admin()) {
            header('Location: /login');
        }

        foreach($libros as $libro) {
            $libro->categoria = Categoria::find($libro->getIdCategoria());
            $libro->escritor = Escritor::find($libro->getIdEscritor());
            $libro->editorial = Editorial::find($libro->getIdEditorial());
        }

        $router->render('admin/libros/index', [
            'titulo' => 'Libros',
            'libros' => $libros
        ]);
    }

    // Crear libro
    public static function crear(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        
        $alertas = [];

        $categorias = Categoria::all();

        $escritores = Escritor::all();

        $editoriales = Editorial::all();

        $libro = new Libro;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
                return;
            }
            
            $libro->sincronizar($_POST);

            $alertas = $libro->validar();

            if(empty($alertas)) {
                $resultado = $libro->guardar();
                if($resultado) {
                    header('Location: /admin/libros');
                    return;
                }
            }
        }


        $router->render('admin/libros/crear', [
            'titulo' => 'Añadir libro',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'escritores' => $escritores,
            'editoriales' => $editoriales,
            'libro' => $libro
        ]);
    }

    // Editar libro
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

        $categorias = Categoria::all();

        $escritores = Escritor::all();

        $editoriales = Editorial::all();

        $libro = Libro::find($id);

        if(!$libro) {
            header('Location: /admin/libros');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
                return;
            }
            
            $libro->sincronizar($_POST);

            $alertas = $libro->validar();

            if(empty($alertas)) {
                $resultado = $libro->guardar();
                if($resultado) {
                    header('Location: /admin/libros');
                    return;
                }
            }
        }


        $router->render('admin/libros/editar', [
            'titulo' => 'Editar libro',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'escritores' => $escritores,
            'editoriales' => $editoriales,
            'libro' => $libro
        ]);
    }

    // Eliminar libro
    public static function eliminar() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
                return;
            }

            $id = $_POST['id'];
            $libro = Libro::find($id);
            if(!isset($libro) ) {
                header('Location: /admin/libros');
                return;
            }
            $resultado = $libro->eliminar();
            if($resultado) {
                header('Location: /admin/libros');
                return;
            }
        }

    }
    
}