<?php

// Aquí se gestionan los escritores dentro del panel de administración.

namespace Controllers;

use MVC\Router;
use Model\Escritor;
use Model\Libro;
use Model\Evento;
use Intervention\Image\ImageManagerStatic as Image;

class EscritoresController {

    // Listado de escritores
    public static function index(Router $router) {
        $escritores = Escritor::all();

        if(!is_admin()) {
            header('Location: /login');
        }

        $router->render('admin/escritores/index', [
            'titulo' => 'Escritores',
            'escritores' => $escritores
        ]);
    }

    // Crear escritor
    public static function crear(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];
        $escritor = new Escritor;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
            header('Location: /login');
        }
            //Comprobamos la imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
                
                $carpeta_imagenes = '../public/img/escritores';

                // Si no exite la carpeta la va a crear para prevenir errores
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                // La imagen se guarda como png o webp

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5( uniqid( rand(), true) ); //Para generar un nombre aleatoria y así evitamos duplicados

                $_POST['imagen'] = $nombre_imagen; // Se guarda la imagen
            }        

            $escritor->sincronizar($_POST);
            $alertas = $escritor->validar();

            //Guardamos
            if(empty($alertas)) {

                // Guardamos las imagenes
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png" );
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp" );

                $resultado = $escritor->guardar();

                if($resultado) {
                    header('Location: /admin/escritores');
                }
            }
        }

        $router->render('admin/escritores/crear', [
            'titulo' => 'Añadir escritor',
            'alertas' => $alertas,
            'escritor' => $escritor
        ]);
    }

    // Editar escritor
    public static function editar(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/escritores');
        }

        $escritor = Escritor::find($id);

        if(!$escritor) {
            header('Location: /admin/escritores');
        }

        // Guardamos la imagen actual para conservarla si no se sube una nueva
        $escritor->imagen_actual = $escritor->getImagen();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
            header('Location: /login');
        }
            if(!empty($_FILES['imagen']['tmp_name'])) {
                
                $carpeta_imagenes = '../public/img/escritores';
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5( uniqid( rand(), true) );

                $_POST['imagen'] = $nombre_imagen; // Esto sobreescribirá la imagen existente
            } else {
                $_POST['imagen'] = $escritor->imagen_actual; // Si no se subió nueva imagen conserva la existente
            }

            $escritor->sincronizar($_POST);
            $alertas = $escritor->validar();

            if(empty($alertas)) {
                if(isset($nombre_imagen)) {
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png" );
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp" );
                }
                $resultado = $escritor->guardar();
                if($resultado) {
                    header('Location: /admin/escritores');
                }
            }
        }



        $router->render('admin/escritores/editar', [
            'titulo' => 'Actualizar escritor',
            'alertas' => $alertas,
            'escritor' => $escritor
        ]);

    }

    // Eliminar escritor
    public static function eliminar() {
    if (!is_admin()) {
        header('Location: /login');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/escritores');
            exit;
        }

        $numEventos = Evento::total('id_escritor', $id);
        $numLibros  = Libro::total('id_escritor', $id);

        if ($numEventos > 0 || $numLibros > 0) {
            $partes = [];
            if ($numEventos > 0) $partes[] = "{$numEventos} evento(s)";
            if ($numLibros  > 0) $partes[] = "{$numLibros} libro(s)";
            $detalle = implode(' y ', $partes);

            $_SESSION['alerta'] = "No se puede eliminar el escritor porque tiene {$detalle} asociados.";
            header('Location: /admin/escritores');
            exit;
        }

        $escritor = EscritoR::find($id);
        if (!$escritor) {
            header('Location: /admin/escritores');
            exit;
        }

        $resultado = $escritor->eliminar();
        if ($resultado) {
            header('Location: /admin/escritores');
            exit;
        }
    }
}

}