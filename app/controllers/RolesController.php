<?php

class RolesController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Roles");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
        }
        getPermisos(3);
    }

    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 4;
        $data['page_tag'] = "Roles Usuario";
        $data['page_name'] = "rol_usuario";
        $data['page_title'] = "Roles Usuario";
        $data['file_js'] = "roles.js";
        $this->views->getView("Roles", "index", $data);
    }

    public function getRoles()
    {
        if ($_SESSION['permisosMod']['rea']) {
            $btnPermisos = '';
            $btnEditar = '';
            $btnBorrar = '';
            $arrData = $this->model->selectRoles();

            for ($i = 0; $i < count($arrData); $i++) {

                if ($arrData[$i]['estado'] == 1) {
                    $arrData[$i]['estado'] = '<span class="badge bg-success">ACTIVO</span>';
                } else {
                    $arrData[$i]['estado'] = '<span class="badge bg-secondary">INACTIVO</span>';
                }

                if ($_SESSION['permisosMod']['upd']) {
                    $btnPermisos = '<button class="btn btn-secondary btn-sm btn-table btnPermisos" title="Ver Permisos"><i class="nav-icon fas fa-key"></i></button>';
                    $btnEditar = '<button class="btn btn-primary btn-sm btn-table btnEditar" title="Editar"><i class="nav-icon fas fa-edit"></i></button>';
                }
                if ($_SESSION['permisosMod']['del']) {
                    $btnBorrar = '<button class="btn btn-danger btn-sm btn-table btnBorrar" title="Eliminar"><i class="nav-icon fas fa-trash"></i></button>';
                }
                $arrData[$i]['opciones'] = '<div class="text-center"><div class="btn-group">' . $btnPermisos . ' ' . $btnEditar . ' ' . $btnBorrar . '</div></div>';

                $arrData[$i]['asociados'] = '<h5 class="mb-0" title="Número de datos asociados"><span class="badge badge-pill badge-warning">' . $arrData[$i]['asociados'] . '</span></h5>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getSelectRoles()
    {
        $arrData = $this->model->selectRoles();
        // $htmlOptions = "";
        // if (count($arrData) > 0) {
        //     for ($i = 0; $i < count($arrData); $i++) {
        //         if ($arrData[$i]['status'] == 1) {
        //             $htmlOptions .= '<option value="' . $arrData[$i]['idrol'] . '">' . $arrData[$i]['nombrerol'] . '</option>';
        //         }
        //     }
        // }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setRol()
    {
        $intIdrol = intval(limpiarCadena($_POST['idrol']));
        $strRol =  strtoupper(limpiarCadena($_POST['irol']));
        $strDescipcion = strtoupper(limpiarCadena($_POST['idescripcion']));
        $intEstado = intval(limpiarCadena($_POST['estado']));
        $request_rol = "";

        if ($intIdrol == 0) {
            //Crear
            if ($_SESSION['permisosMod']['cre']) {
                $request_rol = $this->model->insertRol($strRol, $strDescipcion, $intEstado);
                $option = 1;
            } else {
                $request_rol = "denegado";
            }
        } else {
            //Actualizar
            if ($_SESSION['permisosMod']['upd']) {
                $request_rol = $this->model->editarRol($intIdrol, $strRol, $strDescipcion, $intEstado);
                $option = 2;
            } else {
                $request_rol = "denegado";
            }
        }

        if ($request_rol == 'exist') {
            $arrResponse = array(
                'status' => false, 'title' => 'Datos duplicados', 'msg' => 'El Rol ya existe.',
                'results' => $request_rol
            );
        } else if ($request_rol > 0) {
            if ($option == 1) {
                $arrResponse = array(
                    'status' => true,
                    'title' => 'Registrado',
                    'msg' => 'Datos guardados correctamente.',
                    'results' => $request_rol
                );
            } else {
                $arrResponse = array(
                    'status' => true, 'title' => 'Actualizado', 'msg' => 'Datos Actualizados correctamente.',
                    'results' => $request_rol
                );
            }
        } else if ($request_rol == 'denegado') {
            $arrResponse = array(
                "status" => false, 'title' => 'No permitido', "msg" => 'No tiene permisos para realizar esta acción.',
                'results' => $request_rol
            );
        } else {
            $arrResponse = array(
                "status" => false, 'title' => 'Error', "msg" => 'No es posible almacenar los datos.',
                'results' => $request_rol
            );
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getRol(int $idrol)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $intIdrol = intval(limpiarCadena($idrol));
            if ($intIdrol > 0) {
                $arrData = $this->model->selectRol($intIdrol);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'title' => 'ok', 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $arrResponse = array('status' => false, 'title' => 'No permitido', 'msg' => 'No tiene permisos para realizar esta acción.');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delRol()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['del']) {
                $intIdrol = intval(limpiarCadena($_POST['idrol']));
                $requestDelete = $this->model->eliminarRol($intIdrol);
                if ($requestDelete == 1) {
                    $arrResponse = array('status' => true, 'title' => 'Eliminado', 'msg' => 'Se ha eliminado el Rol');
                } else if ($requestDelete == 'exist') {
                    $arrResponse = array('status' => false, 'title' => 'Rol asociado', 'msg' => 'No es posible eliminar un Rol asociado a usuarios.');
                } else {
                    $arrResponse = array('status' => false, 'title' => 'Error', 'msg' => 'Error al eliminar el Rol.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $arrResponse = array('status' => false, 'title' => 'No permitido', 'msg' => 'No tiene permisos para realizar esta acción.');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
