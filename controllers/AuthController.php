<?php

// Este es el controlador para la autenticación. Se recibe una petición, el modelo de Usuario valida y finalmente el router renderiza la vista correspondiente.

namespace Controllers; // Agrupamos dentro de este espacio

use Model\Usuario; // Importamos el modelo usuario
use MVC\Router; // Importamos el router para las vistas

class AuthController {

    // Login

    public static function login(Router $router) {
        //Alertas almacenará los mensajes de error y éxito para mostrarlos
        $alertas = [];
        // Creamos un nuevo usuario vacío
        $usuario = new Usuario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Pasamos el POST al usuario para que se rellenen las propiedades con los datos del formulario
            $usuario = new Usuario($_POST);

            // Comprobamos que todo esté bien
            $alertas = $usuario->validarLogin();

            if (empty($alertas['error'])) {
                // Si no hay errores cargamos en la variable el usuario de la base de datos que coincida con el correo del usuario del formulario
                $dbUser = Usuario::findByCorreo($usuario->getCorreo());

                // Si no hay coincidencia por correo, o no hay coincidencia con la contraseña salta error
                if (!$dbUser || !$usuario->checkPassword($dbUser->getPassword())) {
                    $alertas['error'][] = 'Error en el correo o la contraseña.';
                } else {
                    // Si todo está bien, iniciamos sesión
                    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

                    // Y guardamos en la sesión los datos del usuario menos la contraseña
                    $_SESSION['usuario_id']     = $dbUser->getIdUsuario();
                    $_SESSION['usuario_nombre'] = $dbUser->getNombre();
                    $_SESSION['usuario_rol']    = $dbUser->getIdRol() ?? 2; // 1=admin, 2=usuario
                    $_SESSION['login']          = true;

                    // Ahora, en función del rol nos dirigimos a un lado u otro
                    if ((int)$dbUser->getIdRol() === 1) {
                        header('Location: /admin/dashboard'); // Si es admin nos vamos al panel de administración
                    } else {
                        header('Location: /entradas'); // Si es usuario normal nos vamos a las entradas para que se inscriba
                    }
                    exit;
                }
            }
        }

        // Si hubo algún error renderizamos login de nuevo
        $router->render('auth/login', [
            'titulo'  => 'Iniciar Sesión',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    // Registro

    public static function registro(Router $router) {
        $alertas = [];
        $usuario = new Usuario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Cargamos el usuario con los datos del formulario
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validar_cuenta();

            if (empty($alertas['error'])) {
                // Si existe el email muestra el error
                if ($usuario->existeCorreo()) {
                    $alertas['error'][] = 'El correo ya está registrado.';
                } else {
                    if ($usuario->registrar()) {
                        // Si todo está bien lo registra y redirige al login mostrando que está todo bien
                        header('Location: /login?registro=1');
                        exit;
                    } else {
                        $alertas['error'][] = 'No se pudo crear la nueva cuenta.';
                    }
                }
            }
        }

        $router->render('auth/registro', [
            'titulo'  => 'Crear cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    // Logout 
    // Se cierra sesión y redirige al login
    public static function logout() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION = [];
        session_destroy();
        header('Location: /login?logout=1');
        exit;
    }
}
