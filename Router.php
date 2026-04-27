<?php

// Este es el router. IMPORTANTE, no es mío, es otra plantilla. Se irá adaptando en función de lo que necesitemos

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    // Guarda una ruta para el GET
    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    // Guarda una ruta para el POST
    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    // Determina la URL actual, busca si existe y de ser así la ejecuta o muestra un mensaje de error
    public function comprobarRutas()
    {

        $url_actual = $_SERVER['PATH_INFO'] ?? '/'; // URL actual o / si no existe
        $method = $_SERVER['REQUEST_METHOD']; // GET o POST

        if ($method === 'GET') {
            // Si existe en GET se recupera, de lo contrario null
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else {
            // Else para buscar en cualquer otro método
            $fn = $this->postRoutes[$url_actual] ?? null;
        }

        // Si todo está bien mostrará la ruta, de lo contrario error
        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            header('Location: /404');
        }
    }

    // Para renderizar las vistas

    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value; 
        }

        ob_start(); 

        include_once __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean();

        // Utilizar el layout en función de la url

        $url_actual = $_SERVER['PATH_INFO'] ?? '/';

        if(str_contains($url_actual, '/admin')) {
            include_once __DIR__ . '/views/admin-layout.php';
        } else {
            include_once __DIR__ . '/views/layout.php';
        }
    }
}
