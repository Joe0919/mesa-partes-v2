<?php

class AreasController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Area");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // session_regenerate_id(true); //# MEJORAR EL USO
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
        }
        getPermisos(4);
    }

    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data['page_id'] = 5;
        $data['page_tag'] = "Áreas";
        $data['page_title'] = "Áreas";
        $data['file_js'] = "areas.js";
        $this->views->getView("Areas", "index", $data);
    }

    public function getAreas()
    {
        if ($_SESSION['permisosMod']['rea']) {
            $btnEditar = '';
            $btnBorrar = '';
            $arrData = $this->model->selectAreas();
            for ($i = 0; $i < count($arrData); $i++) {
                if ($_SESSION['permisosMod']['upd']) {
                    $btnEditar = '<button class="btn btn-primary btn-sm btn-table btnEditar" title="Editar"><i class="nav-icon fas fa-edit"></i></button>';
                }
                if ($_SESSION['permisosMod']['del']) {
                    $btnBorrar = '<button class="btn btn-danger btn-sm btn-table btnBorrar" title="Eliminar"><i class="nav-icon fas fa-trash"></i></button>';
                }
                $arrData[$i]['opciones'] = '<div class="text-center"><div class="btn-group"> ' . $btnEditar . ' ' . $btnBorrar . '</div></div>';

                $arrData[$i]['asociados'] = '<h5 class="mb-0" title="Número de datos asociados"><span class="badge badge-pill badge-warning">' . $arrData[$i]['asociados'] . '</span></h5>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } else {
            $arrResponse = array(
                'status' => false,
                'title' => 'No autorizado',
                'msg' => 'No tiene permitido ver este recurso.',
            );
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getSelectAreas()
    {
        $arrData = $this->model->selectAreas();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function setArea()
    {
        $intIdArea = intval(limpiarCadena($_POST['idarea']));
        $strCodigo =  strtoupper(limpiarCadena($_POST['icodigo']));
        $strArea = strtoupper(limpiarCadena($_POST['iarea']));
        $intIdInst = intval(limpiarCadena($_POST['id_inst']));
        $request_area = "";

        if ($intIdArea == 0) {
            //Crear
            if ($_SESSION['permisosMod']['cre']) {
                $request_area = $this->model->crearArea($strCodigo, $strArea, $intIdInst);
                $option = 1;
            } else {
                $request_area = "denegado";
            }
        } else {
            //Actualizar
            if ($_SESSION['permisosMod']['upd']) {
                $request_area = $this->model->editarArea($intIdArea, $strCodigo, $strArea);
                $option = 2;
            } else {
                $request_area = "denegado";
            }
        }

        if ($request_area == 'exist') {
            $arrResponse = array(
                'status' => false,
                'title' => 'Datos duplicados',
                'msg' => 'El Codigo o Area ya existe.',
                'results' => $request_area
            );
        } else if ($request_area > 0) {
            if ($option == 1) {
                $arrResponse = array(
                    'status' => true,
                    'title' => 'Registrado',
                    'msg' => 'Datos guardados correctamente.',
                    'results' => $request_area
                );
            } else {
                $arrResponse = array(
                    'status' => true,
                    'title' => 'Actualizado',
                    'msg' => 'Datos Actualizados correctamente.',
                    'results' => $request_area
                );
            }
        } else if ($request_area == 'denegado') {
            $arrResponse = array(
                "status" => false,
                'title' => 'No permitido',
                "msg" => 'No tiene permisos para realizar esta acción.',
                'results' => $request_area
            );
        } else {
            $arrResponse = array(
                "status" => false,
                'title' => 'Error',
                "msg" => 'No es posible almacenar los datos.',
                'results' => $request_area
            );
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getArea(int $idarea)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $intIdArea = intval(limpiarCadena($idarea));
            if ($intIdArea > 0) {
                $arrData = $this->model->selectArea($intIdArea);
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
    public function delArea()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['del']) {
                $intIdArea = intval(limpiarCadena($_POST['idarea']));
                $requestDelete = $this->model->eliminarArea($intIdArea);
                if ($requestDelete == 1) {
                    $arrResponse = array('status' => true, 'title' => 'Eliminado', 'msg' => 'Se ha eliminado el Área');
                } else if ($requestDelete == 'existD') {
                    $arrResponse = array('status' => false, 'title' => 'Trámite asociado', 'msg' => 'No es posible eliminar, el Área tiene trámites.');
                } else if ($requestDelete == 'existE') {
                    $arrResponse = array('status' => false, 'title' => 'Usuario asociado', 'msg' => 'No es posible eliminar, el Área tiene usuarios.');
                } else {
                    $arrResponse = array('status' => false, 'title' => 'Error', 'msg' => 'Error al eliminar el Área.');
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
