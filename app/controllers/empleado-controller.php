<?php

require_once "../config/conexion.php";
require_once "../models/Empleado.php";

$empleado = new Empleado();

$idpersona = (isset($_POST['idper'])) ? $_POST['idper'] : '';
$id = (isset($_POST['id'])) ? $_POST['ididdni'] : '';
$codigo = (isset($_POST['codigo'])) ? strtoupper(trim($_POST['codigo']))  : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$dni = (isset($_POST['idni'])) ? $_POST['idni'] : '';


switch ($opcion) {
    case 1:
        // Consultar todos los datos
        $data = $empleados->listarempleadoss();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;

    case 2:
        // Consultar por ID para edición
        $data = $empleado->consultarEmpleadoDNI($dni);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 3:
        // Editar datos por ID
        $data = $empleados->editarusuarioID($idusu, $nom_usu, $idper, $nombre, $appat, $apmat, $email, $celular, $direccion);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 4:
        // ELiminar por ID
        break;
    default:
        # code...
        break;
}
