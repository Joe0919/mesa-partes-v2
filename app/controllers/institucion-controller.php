<?php

require_once "../config/conexion.php";
require_once "../models/Institucion.php";

$institucion = new Institucion();

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$idinstitu = (isset($_POST['idinst'])) ? $_POST['idinst'] : '';

$rucinsti = (isset($_POST['iruci'])) ? $_POST['iruci'] : '';
$razon = (isset($_POST['irazoni'])) ? strtoupper(trim($_POST['irazoni'])) : '';
$direc = (isset($_POST['idirei'])) ? strtoupper(trim($_POST['idirei'])) : '';


switch ($opcion) {
    case 1:
        // Consultar datos
        $data = $institucion->mostrarDatosInstitucion();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 2:
        // Editar Datos por ID
        $data = $institucion->editarDatosInstitucion($idinstitu,$rucinsti,$razon,$direc);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    default:
        # code...
        break;
}
