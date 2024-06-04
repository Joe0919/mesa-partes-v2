<?php

require_once "../config/conexion.php";
require_once "../models/Documento.php";

$documento = new Documento();

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$idubicacion = (isset($_POST['idubicacion'])) ? $_POST['idubicacion'] : '';

$origen = (isset($_POST['origen'])) ? $_POST['origen'] : '';
$destino = (isset($_POST['destino'])) ? $_POST['destino'] : '';
$descripcion = (isset($_POST['descrip'])) ? $_POST['descrip'] : '';

$bdr = (isset($_POST['bdr'])) ? $_POST['bdr'] : '';

$expediente = (isset($_POST['id'])) ? $_POST['id'] : '';
$expe = (isset($_POST['nrexpe'])) ? $_POST['nrexpe'] : '';
$año = (isset($_POST['año'])) ? $_POST['año'] : '';
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
$idarea = (isset($_POST['idarea'])) ? $_POST['idarea'] : '';
$idder = (isset($_POST['idder'])) ? $_POST['idder'] : '';

switch ($opcion) {
    case 1:
        // Consultar todos los datos por estado
        $data = $documento->consultarDocsxEstado();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 2:
        // Consultar todos los datos por estado y area 
        $data = $documento->consultarDocsxEstadoxArea($idubicacion);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    default:
        # code...
        break;
}
