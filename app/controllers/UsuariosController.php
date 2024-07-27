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

        getPermisos(2);
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
            $arrData = $this->model->selectUsuarios();
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

    public function getUsuario($idusuario)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $idusuario = intval($idusuario);
            if ($idusuario > 0) {
                $arrData = $this->model->consultarUsuario($idusuario);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    public function setUsuario()
    {
        if ($_POST) {
            if (
                empty($_POST['idni']) || empty($_POST['inombre']) || empty($_POST['iappat']) || empty($_POST['iapmat'])
                || empty($_POST['iemail']) || empty($_POST['idir']) || empty($_POST['icel'] || empty($_POST['inomusu']))
                || empty($_POST['irol'])
            ) {
                $arrResponse = array("status" => false, "title" => "Faltan Datos", "msg" => 'Completar todos los campos.');
            } else {
                $idUsuario = intval(limpiarCadena($_POST['idusuario']));
                $idPersona = intval(limpiarCadena($_POST['idpersona']));
                $dni = limpiarCadena($_POST['idni']);
                $nombre = strtoupper(limpiarCadena($_POST['inombre']));
                $appat = strtoupper(limpiarCadena($_POST['iappat']));
                $apmat = strtoupper(limpiarCadena($_POST['iapmat']));
                $celular = limpiarCadena($_POST['icel']);
                $email = limpiarCadena($_POST['iemail']);
                $direccion = strtoupper(limpiarCadena($_POST['idir']));
                $nom_usu = limpiarCadena($_POST['inomusu']);
                $idrol = limpiarCadena($_POST['irol']);
                $foto = $_FILES['foto'];
                $estado = limpiarCadena($_POST['estado']);

                $request_user = "";
                $ruta_foto = "";
                $success = false;

                if ($_POST['foto_bdr'] === '1') {
                    $ruta_aux = UPLOADS_PATH; // RAIZ/public/files/images/
                    $rutaID = $idUsuario . '/'; // 1/
                    $file_tmp_name = $foto['tmp_name'];

                    $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
                    $date = date("Ymd");

                    $nuevo_nombre = UPLOADS_PATH . $rutaID . 'profile' . $idUsuario . '_' . $dni . '_' . $date . '.' . $ext;

                    if (!file_exists($ruta_aux)) {
                        mkdir($ruta_aux, 0777, true);
                    }
                    if (file_exists(UPLOADS_PATH . $rutaID)) {
                        $files = array_diff(scandir(UPLOADS_PATH . $rutaID), array('.', '..'));
                        if (count($files) > 0) {
                            eliminarArchivos(UPLOADS_PATH . $rutaID);
                        }
                    } else {
                        mkdir(UPLOADS_PATH . $rutaID, 0777, true);
                    }

                    if (move_uploaded_file($file_tmp_name, $nuevo_nombre)) {
                        $ruta_foto = 'files/images/' . $idUsuario . '/profile_' . $idUsuario . '_' . $dni . '_' . $date . '.' . $ext;
                        $success = true;
                    } else {
                        $arrResponse = array("status" => false, "title" => "Error", "msg" => 'No fue posible guardar la foto.');
                    }
                } else {
                    $ruta_foto = 'files/images/0/user.png';
                    $success = true;
                }

                if ($success) {
                    if ($idUsuario == 0) {
                        $option = 1;
                        $strPassword =  empty($_POST['ipassword']) ?  genContrasena() :  limpiarCadena($_POST['ipassword']);
                        if ($_SESSION['permisosMod']['cre']) {
                            $request_user = $this->model->insertUsuario(
                                $dni,
                                $appat,
                                $apmat,
                                $nombre,
                                $email,
                                $celular,
                                $direccion,
                                $nom_usu,
                                $strPassword,
                                $idrol,
                                $ruta_foto
                            );
                        }
                    } else {
                        $option = 2;
                        if ($_SESSION['permisosMod']['upd']) {
                            $ruta_foto = ($_POST['foto_bdr'] === '1') ? $ruta_foto : "";
                            $request_user = $this->model->editarusuarioID(
                                $idUsuario,
                                $nom_usu,
                                $idPersona,
                                $nombre,
                                $appat,
                                $apmat,
                                $email,
                                $celular,
                                $direccion,
                                $estado,
                                $idrol,
                                $ruta_foto
                            );
                        }
                    }
                    if ($request_user === 'exist') {
                        $arrResponse = array(
                            'status' => false, 'title' => 'Datos duplicados', 'msg' => 'Email, telefono o nombre de usuario ya existen.',
                            'results' =>  $request_user
                        );
                    } else if ($request_user > 0) {
                        if ($option == 1) {
                            $arrResponse = array(
                                'status' => true,
                                'title' => 'Registrado',
                                'msg' => 'Datos guardados correctamente.',
                                'results' => ""
                            );
                        } else {
                            $arrResponse = array(
                                'status' => true,
                                'title' => 'Actualizado',
                                'msg' => 'Datos actualizados correctamente.',
                                'results' => ""
                            );
                        }
                    } else {
                        $arrResponse = array(
                            "status" => false, 'title' => 'Error', "msg" => 'No es posible almacenar los datos.',
                            'results' => ""
                        );
                    }
                } else {
                    $arrResponse = array(
                        'status' => false, 'title' => 'Error', 'msg' => 'No fue posible guardar la imagen.',
                        'results' => $success
                    );
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setPerfil()
    {
        if ($_POST) {
            if (
                empty($_POST['idni']) || empty($_POST['inombre']) || empty($_POST['iappat']) || empty($_POST['iapmat'])
                || empty($_POST['iemail']) || empty($_POST['idir']) || empty($_POST['icel'] || empty($_POST['inomusu']))
            ) {
                $arrResponse = array("status" => false, "title" => "Faltan Datos", "msg" => 'Completar todos los campos obligatorios.');
            } else {
                $idUsuario = intval(limpiarCadena($_POST['idusuario']));
                $idPersona = intval(limpiarCadena($_POST['idpersona']));
                $dni = limpiarCadena($_POST['idni']);
                $nombre = strtoupper(limpiarCadena($_POST['inombre']));
                $appat = strtoupper(limpiarCadena($_POST['iappat']));
                $apmat = strtoupper(limpiarCadena($_POST['iapmat']));
                $celular = limpiarCadena($_POST['icel']);
                $email = limpiarCadena($_POST['iemail']);
                $direccion = strtoupper(limpiarCadena($_POST['idir']));
                $nom_usu = limpiarCadena($_POST['inomusu']);
                $foto = $_FILES['foto'];

                $request_user = "";
                $ruta_foto = "";
                $success = false;

                if ($_POST['foto_bdr'] === '1') {
                    $ruta_aux = UPLOADS_PATH; // RAIZ/public/files/images/
                    $rutaID = $idUsuario . '/'; // 1/
                    $file_tmp_name = $foto['tmp_name'];

                    $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
                    $date = date("Ymd");

                    $nuevo_nombre = UPLOADS_PATH . $rutaID . 'profile' . $idUsuario . '_' . $dni . '_' . $date . '.' . $ext;

                    if (!file_exists($ruta_aux)) {
                        mkdir($ruta_aux, 0777, true);
                    }

                    if (file_exists(UPLOADS_PATH . $rutaID)) {
                        $files = array_diff(scandir(UPLOADS_PATH . $rutaID), array('.', '..'));
                        if (count($files) > 0) {
                            eliminarArchivos(UPLOADS_PATH . $rutaID);
                        }
                    } else {
                        mkdir(UPLOADS_PATH . $rutaID, 0777, true);
                    }

                    if (move_uploaded_file($file_tmp_name, $nuevo_nombre)) {
                        $ruta_foto = 'files/images/' . $idUsuario . '/profile' . $idUsuario . '_' . $dni . '_' . $date . '.' . $ext;
                        $success = true;
                    } else {
                        $arrResponse = array("status" => false, "title" => "Error", "msg" => 'No fue posible guardar la foto.');
                    }
                } else {

                    $success = true;
                }

                if ($success) {
                    if ($idUsuario <= 0) {
                        $request_user = 'El ID es 0';
                    } else {
                        if ($_SESSION['permisosMod']['upd']) {
                            $ruta_foto = ($_POST['foto_bdr'] === '1') ? $ruta_foto : "";
                            $request_user = $this->model->editarPerfil(
                                $idUsuario,
                                $nom_usu,
                                $idPersona,
                                $nombre,
                                $appat,
                                $apmat,
                                $email,
                                $celular,
                                $direccion,
                                $ruta_foto
                            );
                        }
                    }
                    if ($request_user === 'exist') {
                        $arrResponse = array(
                            'status' => false, 'title' => 'Datos duplicados', 'msg' => 'Email, telefono o nombre de usuario ya existen.',
                            'results' =>  $request_user
                        );
                    } else if ($request_user > 0) {

                        $arrResponse = array(
                            'status' => true,
                            'title' => 'Actualizado',
                            'msg' => 'Datos actualizados correctamente.',
                            'results' => $request_user
                        );
                    } else {
                        $arrResponse = array(
                            "status" => false, 'title' => 'Error', "msg" => 'No es posible almacenar los datos.',
                            'results' => $request_user
                        );
                    }
                } else {
                    $arrResponse = array(
                        'status' => false, 'title' => 'Error', 'msg' => 'No fue posible guardar la imagen.',
                        'results' => $success
                    );
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function putPasswordUser()
    {
        if ($_POST) {
            if (
                empty($_POST['ioldpassword']) !== empty($_POST['iconfirmpsw'])
            ) {
                $arrResponse = array("status" => false, "title" => "No coinciden", "msg" => 'Ingrese contraseñas que coincidan.');
            } else {
                $idUsuario = intval(limpiarCadena($_POST['idusuario']));
                $strOldPsw = $_POST['ioldpassword'];
                $strNewPsw = $_POST['iconfirmpsw'];
                $request_user = "";

                if ($idUsuario !== 0) {
                    if ($_SESSION['permisosMod']['upd']) {
                        $request_user = $this->model->editarPswUsuarioID(
                            $strOldPsw,
                            $strNewPsw,
                            $idUsuario
                        );
                    }
                    if ($request_user === 0) {
                        $arrResponse = array(
                            'status' => false, 'title' => 'Incorrecto', 'msg' => 'La contraseña actual no es correcta.',
                            'results' =>  $request_user
                        );
                    } else if ($request_user > 0) {

                        $arrResponse = array(
                            'status' => true,
                            'title' => 'Actualizado',
                            'msg' => 'La contraseña fue actualizada correctamente.',
                            'results' =>  $request_user
                        );
                    } else {
                        $arrResponse = array(
                            "status" => false, 'title' => 'Error', "msg" => 'No es posible almacenar los datos.',
                            'results' => ""
                        );
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }

    public function delUser()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['del']) {
                $strDNI = limpiarCadena($_POST['dni']);
                $requestDelete = $this->model->eliminarUsuarioDNI($strDNI);
                if ($requestDelete == 1) {
                    $arrResponse = array('status' => true, 'title' => 'Eliminado', 'msg' => 'Se ha eliminado al Usuario');
                } else if ($requestDelete == 'exist') {
                    $arrResponse = array('status' => false, 'title' => 'Rol asociado', 'msg' => 'No es posible eliminar un al Usuario.');
                } else {
                    $arrResponse = array('status' => false, 'title' => 'Error', 'msg' => 'Error al eliminar al Usuario.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
