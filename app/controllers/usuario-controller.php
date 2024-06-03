<?php

require_once "../config/conexion.php";
require_once "../models/Usuario.php";

$usuario = new Usuario();

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : 0;

$idper = (isset($_POST['idper'])) ? $_POST['idper'] : '';
$idusu = (isset($_POST['idusu'])) ? $_POST['idusu'] : '';

$dni = (isset($_POST["idni"])) ? $_POST["idni"] : '';
$nombre = (isset($_POST['inombre'])) ? strtoupper(trim($_POST['inombre'])) : '';
$appat = (isset($_POST['iappat'])) ? strtoupper(trim($_POST['iappat'])) : '';
$apmat = (isset($_POST['iapmat'])) ? strtoupper(trim($_POST['iapmat'])) : '';
$celular = (isset($_POST['icel'])) ? $_POST['icel'] : '';
$direccion = (isset($_POST['idir'])) ? strtoupper(trim($_POST['idir'])) : '';
$email = (isset($_POST['iemail'])) ? $_POST['iemail'] : '';



$psw_anterior = (isset($_POST['icontra'])) ? $_POST['icontra'] : '';
$psw_nueva = (isset($_POST['inewcontra'])) ? $_POST['inewcontra'] : '';


$foto = (isset($_FILES['idfile'])) ? $_FILES['idfile'] : '';

switch ($opcion) {
    case 1:
        // Consultar todos los datos
        $data = $usuario->listarUsuarios();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;

    case 2:
        // Consultar por ID para edición
        $data = $usuario->consultarUsuarioID($idusu, $dni);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 3:
        // Editar datos por ID
        $data = $usuario->editarusuarioID($idusu, $nom_usu, $idper, $nombre, $appat, $apmat, $email, $celular, $direccion);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    case 4:
        // ELiminar por ID
        break;
    case 5:
        // Editar foto por ID
        $a = "../../public/";
        $ruta_aux = $a . "files/images/";
        $ruta = "files/images/" . $idusu . "/";
        $file_tmp_name = $foto['tmp_name'];
        $file_tmp_type = $foto['type'];
        $nuevo_nombre = $a . $ruta . $idusu . '_' . date('Y') . '_' . $dni . '.jpg';
        $nueva_ruta = $ruta . $idusu . '_' . date('Y') . '_' . $dni . '.jpg';

        if (!file_exists($ruta_aux)) {
            mkdir($ruta_aux, 0777, true);
        }
        if (!file_exists($a . $ruta)) {
            mkdir($a . $ruta, 0777, true);
        }

        if (move_uploaded_file($file_tmp_name, $nuevo_nombre)) {
            $data = $usuario->editarFotoUsuarioID($idusu, $nueva_ruta);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            $nuevo_nombre = '';
            $nueva_ruta = '';
        } else {
            $data = 'Error';
        }

        break;
    case 6:
        //Editar contraseña de usuario
        $data = $usuario->cambioContraUsuarioID($psw_anterior, $psw_nueva, $idusu);
        // $data = $psw_anterior." - ". $psw_nueva. " - ". $idusu;
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    default:
        $data = $nombre . " - " . $opcion;
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
}
