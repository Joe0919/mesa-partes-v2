<?php
require_once "../../app/config/config.php";
require_once "../../app/config/conexion.php";
require_once "../../app/config/cons.php";

if (!isset($_SESSION["idusuarios"])) {
    header("Location:" . URL . "views/Acceso/");
}

$iduser = $_SESSION["idusuarios"];
$foto = $_SESSION["foto"];
$dni = $_SESSION["dni"];

date_default_timezone_set('America/Lima');
