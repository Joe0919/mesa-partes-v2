<?php


class UsuariosController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Usuario");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
    }

    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 3;
        $data['page_tag'] = "Usuarios";
        $data['page_name'] = "usuario";
        $data['page_title'] = "Usuarios";
        $data['file_js'] = "usuario.js";
        $this->views->getView("Usuarios", "index", $data);
    }

    public function getUsuarios()
    {
        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->listarUsuarios();
            for ($i = 0; $i < count($arrData); $i++) {
                // $btnView = '';
                $btnEditar = '';
                $btnEditPsw = '';
                $btnBorrar = '';

                if ($arrData[$i]['estado'] == "ACTIVO") {
                    $arrData[$i]['estado'] = '<span class="badge bg-success">ACTIVO</span>';
                } else {
                    $arrData[$i]['estado'] = '<span class="badge bg-gray">INACTIVO</span>';
                }

                // if ($_SESSION['permisosMod']['rea']) {
                //     $btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario(' . $arrData[$i]['idpersona'] . ')" title="Ver usuario"><i class="far fa-eye"></i></button>';
                // }
                if ($_SESSION['permisosMod']['upd']) {
                    if (($_SESSION['idUsuario'] == 1 and $_SESSION['userData']['idroles'] == 1) ||
                        ($_SESSION['userData']['idroles'] == 1 and $arrData[$i]['idroles'] != 1)
                    ) {
                        $btnEditar = '<button class="btn btn-primary btn-sm btn-table btnEditar" title="Editar"><i class="nav-icon fas fa-edit"></i></button>';
                        $btnEditPsw = '<button class="btn btn-warning btn-sm btn-table btnPsw" title="Cambiar contraseña"><i class="nav-icon fas fa-lock"></i></button>';
                    } else {
                        $btnEditar = '<button class="btn btn-primary btn-sm btn-table" title="Editar" disabled><i class="nav-icon fas fa-edit"></i></button>';
                        $btnEditPsw = '<button class="btn btn-warning btn-sm btn-table" title="Cambiar contraseña" disabled><i class="nav-icon fas fa-lock"></i></button>';
                    }
                }
                if ($_SESSION['permisosMod']['del']) {
                    if (($_SESSION['idUsuario'] == 1 and $_SESSION['userData']['idroles'] == 1) ||
                        ($_SESSION['userData']['idroles'] == 1 and $arrData[$i]['idroles'] != 1) and
                        ($_SESSION['userData']['idusuarios'] != $arrData[$i]['idusuarios'])
                    ) {
                        $btnBorrar = '<button class="btn btn-danger btn-sm btn-table btnBorrar" title="Eliminar"><i class="nav-icon fas fa-trash"></i></button>';
                    } else {
                        $btnBorrar = '<button class="btn btn-danger btn-sm btn-table" title="Eliminar" disabled><i class="nav-icon fas fa-trash"></i></button>';
                    }
                }
                $arrData[$i]['opciones'] = '<div class="text-center"><div class="btn-group">' . $btnEditar . ' ' . $btnEditPsw . ' ' . $btnBorrar . '</div></div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}

// require_once "../config/conexion.php";
// require_once "../models/UsuarioModel.php";

// $usuario = new UsuarioModel();

// $opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : 0;

// $idper = (isset($_POST['idper'])) ? $_POST['idper'] : '';
// $idusu = (isset($_POST['idusu'])) ? $_POST['idusu'] : '';

// $dni = (isset($_POST["idni"])) ? $_POST["idni"] : '';
// $nombre = (isset($_POST['inombre'])) ? strtoupper(trim($_POST['inombre'])) : '';
// $appat = (isset($_POST['iappat'])) ? strtoupper(trim($_POST['iappat'])) : '';
// $apmat = (isset($_POST['iapmat'])) ? strtoupper(trim($_POST['iapmat'])) : '';
// $celular = (isset($_POST['icel'])) ? $_POST['icel'] : '';
// $direccion = (isset($_POST['idir'])) ? strtoupper(trim($_POST['idir'])) : '';
// $email = (isset($_POST['iemail'])) ? $_POST['iemail'] : '';

// $nom_usu = (isset($_POST['inomusu'])) ? $_POST['inomusu'] : '';
// $rol = (isset($_POST['irol'])) ? $_POST['irol'] : '';
// $estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
// $psw = (isset($_POST['ipassco'])) ? $_POST['ipassco'] : '';

// $psw_anterior = (isset($_POST['icontra'])) ? $_POST['icontra'] : '';
// $psw_nueva = (isset($_POST['inewcontra'])) ? $_POST['inewcontra'] : '';


// $foto = (isset($_FILES['idfile'])) ? $_FILES['idfile'] : '';

// switch ($opcion) {
//     case 1:
//         // Consultar todos los datos
//         $data = $usuario->listarUsuarios();
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 2:
//         // Consultar por ID y DNI para edición
//         $data = $usuario->consultarUsuarioID($idusu, $dni);
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 3:
//         // Editar datos por ID
//         $data = $usuario->editarusuarioID($idusu, $nom_usu, $idper, $nombre, $appat, $apmat, $email, $celular, $direccion, $estado);
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 4:
//         // ELiminar por ID
//         $data = $usuario->eliminarUsuarioID($dni);
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 5:
//         // Editar foto por ID
//         $a = "../../public/";
//         $ruta_aux = $a . "files/images/";
//         $ruta = "files/images/" . $idusu . "/";
//         $file_tmp_name = $foto['tmp_name'];
//         $file_tmp_type = $foto['type'];
//         $nuevo_nombre = $a . $ruta . $idusu . '_' . date('Y') . '_' . $dni . '.jpg';
//         $nueva_ruta = $ruta . $idusu . '_' . date('Y') . '_' . $dni . '.jpg';

//         if (!file_exists($ruta_aux)) {
//             mkdir($ruta_aux, 0777, true);
//         }
//         if (!file_exists($a . $ruta)) {
//             mkdir($a . $ruta, 0777, true);
//         }

//         if (move_uploaded_file($file_tmp_name, $nuevo_nombre)) {
//             $data = $usuario->editarFotoUsuarioID($idusu, $nueva_ruta);
//             echo json_encode($data, JSON_UNESCAPED_UNICODE);
//             $nuevo_nombre = '';
//             $nueva_ruta = '';
//         } else {
//             $data = 'Error';
//         }

//         break;
//     case 6:
//         //Editar contraseña de usuario
//         $data = $usuario->cambioContraUsuarioID($psw_anterior, $psw_nueva, $idusu);
//         // $data = $psw_anterior." - ". $psw_nueva. " - ". $idusu;
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 7:
//         //validar Datos de Usuario
//         $data = $usuario->validarDuplicidadDatosUsuario($dni, $email, $celular,  $nom_usu);
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         // echo $dni, " ",  $appat," ", $apmat," ", $nombre," ", $email," ", $celular," ", $direccion," ", $nom_usu," ", $psw," ", $rol;
//         break;
//     case 8:
//         //Guardar Datos de Usuario
//         $data = $usuario->crearNuevoUsuario($dni, $appat, $apmat, $nombre, $email, $celular, $direccion, $nom_usu, $psw_nueva, $rol);
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         // echo $dni, " ",  $appat," ", $apmat," ", $nombre," ", $email," ", $celular," ", $direccion," ", $nom_usu," ", $psw," ", $rol;
//         break;
//     case 10:
//         //Mostrar roles de usuario
//         $data = $usuario->consultarRoles();
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     case 11:
//         // Consultar solo por ID para edición
//         $data = $usuario->consultarUsuarioxID($idusu);
//         echo json_encode($data, JSON_UNESCAPED_UNICODE);
//         break;
//     default:
//         break;
// }
