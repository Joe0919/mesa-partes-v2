<?php

require_once "../../config/conexion.php";
require_once "../../../app/config/cons.php";

if (!isset($_SESSION["idusuarios"])) {
    header("Location:" . URL . "views/acceso/");
}

date_default_timezone_set('America/Lima');


