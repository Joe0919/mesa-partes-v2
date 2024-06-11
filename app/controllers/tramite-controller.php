<?php

require_once "../config/conexion.php";
require_once "../models/Tramite.php";

$tramite = new Tramite();

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


$origen = (isset($_POST['origen'])) ? $_POST['origen'] : '';
$destino = (isset($_POST['destino'])) ? $_POST['destino'] : '';
$descripcion = (isset($_POST['descrip'])) ? $_POST['descrip'] : '';


$bdr = (isset($_POST['bdr'])) ? $_POST['bdr'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$expediente = (isset($_POST['expediente'])) ? $_POST['expediente'] : '';
$año = (isset($_POST['año'])) ? $_POST['año'] : '';
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
$idarea = (isset($_POST['idarea'])) ? $_POST['idarea'] : '';
$idder = (isset($_POST['idder'])) ? $_POST['idder'] : '';


switch ($opcion) {
    case 1:
        // Consultar todos los datos
        $data = $tramite->listarTramites();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 2:
        // Crear nuevo registro
        // $data = $empleado->crearNuevoEmpleado($dni, $codigo, $idpersona, $idareainst);
        // $data = "DNI:" . $dni . " COd:" . $codigo . " IDPER:" . $idpersona . " IDAINS:" . $idareainst;
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 3:
        // Consultar por Expediente
        $data = $tramite->consultarTramitexExpediente($expediente);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 4:
        // Editar datos por ID
        // $data = $empleado->editarEmpleadoID($id, $codigo, $idareainst);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 5:
        // ELiminar por ID
        // $data = $area->eliminarAreaID($id_area);
        // echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 6:
        // Consultar usuarios que no son empleados
        // $data = $empleado->listarUsuariosPendientes();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    default:
        break;
}
