<?php

// Aquí se gestionan los Eventos dentro del Panel de Administración.

namespace Controllers;

use MVC\Router;
use Model\Escritor;
use Model\Localizacion;
use Model\Categoria;
use Model\Evento;
use Model\Registro;

class EventosController {

    // Listado de eventos
    public static function index(Router $router) {
        $eventos = Evento::all();

        if(!is_admin()) {
            header('Location: /login');
        }

        // En vez de hacer un JOIN he hecho esto 
        foreach($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->getIdCategoria());
            $evento->escritor = Escritor::find($evento->getIdEscritor());
            $evento->localizacion = Localizacion::find($evento->getIdLocalizacion());
        }

        $router->render('admin/eventos/index', [
            'titulo' => 'Eventos',
            'eventos' => $eventos
        ]);
    }

    // Crear evento
    public static function crear(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        
        $alertas = [];

        $categorias = Categoria::all();

        $escritores = Escritor::all();

        $localizaciones = Localizacion::all();

        $evento = new Evento;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
                return;
            }
            
            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if(empty($alertas)) {
                $resultado = $evento->guardar();
                if($resultado) {
                    header('Location: /admin/eventos');
                    return;
                }
            }
        }


        $router->render('admin/eventos/crear', [
            'titulo' => 'Añadir evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'escritores' => $escritores,
            'localizaciones' => $localizaciones,
            'evento' => $evento
        ]);
    }

    // Editar evento
    public static function editar(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        
        $alertas = [];

        // Validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/eventos');
        }

        $categorias = Categoria::all();

        $escritores = Escritor::all();

        $localizaciones = Localizacion::all();

        $evento = Evento::find($id);

        if(!$evento) {
            header('Location: /admin/eventos');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
                return;
            }
            
            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if(empty($alertas)) {
                $resultado = $evento->guardar();
                if($resultado) {
                    header('Location: /admin/eventos');
                    return;
                }
            }
        }


        $router->render('admin/eventos/editar', [
            'titulo' => 'Editar evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'escritores' => $escritores,
            'localizaciones' => $localizaciones,
            'evento' => $evento
        ]);
    }

    // Eliminar evento
    public static function eliminar() {
    if (!is_admin()) {
        header('Location: /login');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/eventos');
            exit;
        }

        $numRegistros = Registro::total('id_evento', $id);

        if ($numRegistros > 0) {
            $_SESSION['alerta'] = "No se puede eliminar el evento porque tiene {$numRegistros} registro(s) de inscripción asociados.";
            header('Location: /admin/eventos');
            exit;
        }

        $evento = Evento::find($id);
        if (!$evento) {
            header('Location: /admin/eventos');
            exit;
        }

        $resultado = $evento->eliminar();
        if ($resultado) {
            header('Location: /admin/eventos');
            exit;
        }
    }
}

    
}