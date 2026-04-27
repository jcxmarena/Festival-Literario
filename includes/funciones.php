<?php

// Funciones auxiliares

// Debuguear
// Solo para desarrollo y así poder comprobar el valor de la variable
function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Función para que el texto se vea bien
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Función para comprobar que el usuario se encuentra en una ruta. Esto lo he usado para que en css se quede fijo un diseño en función de la página en la que se encuentra
function pagina_actual($path): bool {
    $actual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
    return trim($actual, '/') === trim($path, '/');
}


function is_auth() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['login']) && !empty($_SESSION);
}

function is_admin(): bool {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    
    return isset($_SESSION['usuario_rol']) 
        && (int)$_SESSION['usuario_rol'] === 1 
        && !empty($_SESSION['login']);
}
