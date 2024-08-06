<?php

class EmpleadosController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Empleado");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // session_regenerate_id(true); //# MEJORAR EL USO
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
        }
        getPermisos(5);
    }

    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data['page_id'] = 6;
        $data['page_tag'] = "Empleados";
        $data['page_name'] = "empleados";
        $data['page_title'] = "Empleados";
        $data['file_js'] = "empleados.js";
        $this->views->getView("Empleados", "index", $data);
    }

    public function getEmpleados()
    {
        if ($_SESSION['permisosMod']['rea']) {
            $btnEditar = '';
            $btnBorrar = '';
            $arrData = $this->model->selectEmpleados();
            for ($i = 0; $i < count($arrData); $i++) {
                if ($_SESSION['permisosMod']['upd']) {
                    $btnEditar = '<button class="btn btn-primary btn-sm btn-table btnEditar" title="Editar"><i class="nav-icon fas fa-edit"></i></button>';
                }
                if ($_SESSION['permisosMod']['del']) {
                    $btnBorrar = '<button class="btn btn-danger btn-sm btn-table btnBorrar" title="Eliminar"><i class="nav-icon fas fa-trash"></i></button>';
                }
                $arrData[$i]['opciones'] = '<div class="text-center"><div class="btn-group"> ' . $btnEditar . ' ' . $btnBorrar . '</div></div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getSelectUsuarios()
    {
        $arrData = $this->model->selectUsuariosPendientes();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function setEmpleado()
    {
        $IdEmpleado = intval(limpiarCadena($_POST['idempleado']));
        $IdPersona =  strtoupper(limpiarCadena($_POST['idpersona']));
        $Codigo = strtoupper(limpiarCadena($_POST['codigo']));
        $IdArea = intval(limpiarCadena($_POST['idarea']));
        $request_empleado = "";

        if ($IdEmpleado == 0) {
            //Crear
            if ($_SESSION['permisosMod']['cre']) {
                $request_empleado = $this->model->crearEmpleado($Codigo, $IdPersona, $IdArea);
                $option = 1;
            } else {
                $request_empleado = "denegado";
            }
        } else {
            //Actualizar
            if ($_SESSION['permisosMod']['upd']) {
                $request_empleado = $this->model->editarEmpleado($IdEmpleado, $IdArea);
                $option = 2;
            } else {
                $request_empleado = "denegado";
            }
        }

        if ($request_empleado == 'exist') {
            $arrResponse = array(
                'status' => false, 'title' => 'Datos duplicados', 'msg' => 'El código de Empleado ya existe.',
                'results' => $request_empleado
            );
        } else if ($request_empleado > 0) {
            if ($option == 1) {
                $arrResponse = array(
                    'status' => true,
                    'title' => 'Registrado',
                    'msg' => 'Datos guardados correctamente.',
                    'results' => $request_empleado
                );
            } else {
                $arrResponse = array(
                    'status' => true, 'title' => 'Actualizado', 'msg' => 'Datos Actualizados correctamente.',
                    'results' =>  $request_empleado
                );
            }
        } else if ($request_empleado == 'denegado') {
            $arrResponse = array(
                "status" => false, 'title' => 'No permitido', "msg" => 'No tiene permisos para realizar esta acción.',
                'results' => $request_empleado
            );
        } else if ($request_empleado == 'recuperar') {
        } else {
            $arrResponse = array(
                "status" => false, 'title' => 'Error', "msg" => 'No es posible almacenar los datos.',
                'results' => $request_empleado
            );
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getEmpleado(int $idEmpleado)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $idEmpleado = intval(limpiarCadena($idEmpleado));
            if ($idEmpleado > 0) {
                $arrData = $this->model->selectEmpleado($idEmpleado);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'title' => 'ok', 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $arrResponse = array('status' => false, 'title' => 'No permitido', 'msg' => 'No tiene permisos para realizar esta acción..');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function delEmpleado()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['del']) {
                $idEmpleado = intval(limpiarCadena($_POST['idempleado']));
                $requestDelete = $this->model->eliminarEmpleado($idEmpleado);
                if ($requestDelete == 1) {
                    $arrResponse = array('status' => true, 'title' => 'Eliminado', 'msg' => 'Se ha eliminado al Empleado');
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
