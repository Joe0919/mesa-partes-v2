<?php

require_once "../config/conexion.php";
require_once "../models/Area.php";

$area = new Area();

//VALIDAMOS SI SE SE ENVIAN DATOS POR METODO POST E INICIALIZAMOS
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_area = (isset($_POST['id'])) ? $_POST['id'] : '';

$codigo = (isset($_POST['icod'])) ? $_POST['icod'] : '';
$nom_area = (isset($_POST['iarea'])) ? strtoupper(trim($_POST['iarea'])) : '';
$id_inst = (isset($_POST['id_inst'])) ? $_POST['id_inst'] : '';


switch ($opcion) {
    case 1:
        // Consultar todos los datos
        $data = $area->listarAreas();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 2:
        // Crear nuevo registro
        $data = $area->crearNuevaArea($codigo, $nom_area, $id_inst);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 3:
        // Consultar por ID para edición
        $data = $area->consultarAreaID($id_area);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 4:
        // Editar datos por ID
        $data = $area->editarAreaID($id_area, $codigo, $nom_area);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 5:
        // ELiminar por ID
        $data = $area->eliminarAreaID($id_area);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    default:
        break;
}
