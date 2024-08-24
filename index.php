<?php
require_once "app/config/config.php";
require_once "app/config/cons.php";
require_once "app/helpers/helpers.php";
date_default_timezone_set('America/Lima');

// Decodifica la URL para convertir %20 en espacios
$ruta = !empty($_GET['url']) ? urldecode($_GET['url']) : 'Home/index';
$arrayRuta = explode("/", $ruta);

// Función para convertir guiones a PascalCase
function convertToPascalCase($string)
{
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
}

$controller = convertToPascalCase($arrayRuta[0]);
$method = "index";
$params = [];

if (!empty($arrayRuta[1])) {
    if ($arrayRuta[1] != "") {
        $method = $arrayRuta[1];
    }
}

if (!empty($arrayRuta[2])) {
    if ($arrayRuta[2] != "") {
        for ($i = 2; $i < count($arrayRuta); $i++) {
            $params[] = $arrayRuta[$i];
        }
    }
}

// Requiere el archivo del controlador
require_once("app/Libraries/Core/Autoload.php");
require_once("app/Libraries/Core/Load.php");