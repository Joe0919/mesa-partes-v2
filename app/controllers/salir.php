<?php
require_once "../config/conexion.php";



session_start();
session_destroy();
header("Location:" . Conectar::ruta()  . "views/Acceso/");

?>