<?php
require_once 'vendor/autoload.php';

// Cargar las variables de entorno desde el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
$dotenv->load();

// Definir constantes usando las variables del archivo .env
define('DB_DRIVER', $_ENV['DB_DRIVER']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_CHARSET', $_ENV['DB_CHARSET']);
define('URL', $_ENV['URL']);

define('APP', dirname(dirname(__FILE__)));
define('BASE_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
define('UPLOADS_PATH', BASE_PATH . 'public/files/');
