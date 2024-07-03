<?php

require_once "app/config/config.php";
require_once "app/helpers/helpers.php";

$ruta = !empty($_GET['url']) ? $_GET['url'] : 'Home/index';
$arrayRuta = explode("/", $ruta);
$controller = $arrayRuta[0];
$method = "index";
$params = "";

if (!empty($arrayRuta[1])) {
    if ($arrayRuta[1] != "") {
        $method = $arrayRuta[1];
    }
}

if (!empty($arrayRuta[2])) {
    if ($arrayRuta[2] != "") {
        for ($i = 2; $i < count($arrayRuta); $i++) {
            $params .=  $arrayRuta[$i] . ',';
            # code...
        }
        $params = trim($params, ',');
    }
}

require_once("app/Libraries/Core/Autoload.php");
require_once("app/Libraries/Core/Load.php");
