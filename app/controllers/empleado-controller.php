<?php

require_once "../config/conexion.php";
require_once "../models/Empleado.php";

$empleado = new Empleado();

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


$dni = (isset($_POST['idni'])) ? $_POST['idni'] : '';
$codigo = (isset($_POST['codigo'])) ? trim($_POST['codigo'])  : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$idpersona = (isset($_POST['idper'])) ? $_POST['idper'] : '';
$idareainst = (isset($_POST['idareainst'])) ? $_POST['idareainst'] : '';


switch ($opcion) {
    case 1:
        // Consultar todos los datos
        $data = $empleado->listarEmpleados();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 2:
        // Crear nuevo registro
        $data = $empleado->crearNuevoEmpleado($dni, $codigo, $idpersona, $idareainst);
        // $data = "DNI:" . $dni . " COd:" . $codigo . " IDPER:" . $idpersona . " IDAINS:" . $idareainst;
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 3:
        // Consultar por ID para edición
        $data = $empleado->consultarEmpleadoDNI($dni);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 4:
        // Editar datos por ID
        $data = $empleado->editarEmpleadoID($id, $codigo, $idareainst);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 5:
        // ELiminar por ID
        $data = $empleado->eliminarEmpleado($id, $dni);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 6:
        // Consultar usuarios que no son empleados
        $data = $empleado->listarUsuariosPendientes();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    default:
        break;
}
