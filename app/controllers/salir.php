<?php
require_once "../config/conexion.php";
//CIERRA LA SESION Y REDIRIJE
session_start();
session_destroy();
header("Location:" . Conectar::ruta()  . "views/Acceso/");
?>