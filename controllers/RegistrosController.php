<?php

// Aquí se gestionan los Registros a los eventos dentro del panel de administración.

namespace Controllers;
use Model\Registro;
use Model\Evento;
use Model\Usuario;

use MVC\Router;

class RegistrosController {

    public static function index(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $registros = Registro::all();

        foreach($registros as $registro) {
            $registro->evento = Evento::find($registro->getIdEvento());
            $registro->usuario = Usuario::find($registro->getIdUsuario());
        }

        $router->render('admin/registros/index', [
            'titulo' => 'Registros',
            'registros' => $registros
        ]);
    }

    // Eliminar registro
    public static function eliminar() {
        if(!is_admin()) {
            header('Location: /login');
        }
 
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id = $_POST['id'];
            $registro = Registro::find($id);
            if(!isset($registro) ) {
                header('Location: /admin/registros');
            }
            $resultado = $registro->eliminar();
            if($resultado) {
                header('Location: /admin/registros');
            }
        }

    }
}