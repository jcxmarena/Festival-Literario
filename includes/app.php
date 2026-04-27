<?php 

use Dotenv\Dotenv; // Librería para manejar el .env
use Model\ActiveRecord; // Modelo para la conexión a la base de datos

// Carga del composer
require __DIR__ . '/../vendor/autoload.php';

// Cargamos la variables de .env solo si todo está bien
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php'; // Funciones extra
require 'database.php'; // Para la conexión

// Conectamos nuestro ORM a la base de datos, así evitamos estar haciendo consultas escribiendo directamente la sentencia SQL
ActiveRecord::setDB($db);