<?php

require_once "../config/conexion.php";
require_once "../models/Persona.php";

$persona = new Persona();

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : 0;

$dni = (isset($_POST["idni"])) ? $_POST["idni"] : '';


switch ($opcion) {
    case 1:
        // Consultar registro por DNI
        $data = $persona->consultarPersonaDNI($dni);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    default:
        break;
}
