<?php

class EmpleadosController extends Controllers
{
    private $tramiteModel;
    public function __construct()
    {
        parent::__construct("Empleado");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // session_regenerate_id(true); //# MEJORAR EL USO
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
            exit();
        }
        getPermisos(5);
    }

    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
            exit();
        }

        $data = [
            'page_id' => 10,
            'page_tag' => "Empleados",
            'page_title' => "Empleados",
            'file_js' => "empleados.js",
        ];
        $this->views->getView("Empleados", "index", $data);
    }

    public function getEmpleados()
    {
        if (!$_SESSION['permisosMod']['rea']) {
            echo json_encode(array(
                'status' => false,
                'title' => 'No autorizado',
                'msg' => 'No tiene permitido acceder a este recurso.',
            ), JSON_UNESCAPED_UNICODE);
            die();
        }

        $arrData = $this->model->selectEmpleados();
        foreach ($arrData as &$empleado) {
            $empleado['opciones'] = $this->getOpcionesBotones();
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    private function getOpcionesBotones()
    {
        $btnEditar = $_SESSION['permisosMod']['upd'] ?
            '<button class="btn btn-primary btn-sm btn-table btnEditar" title="Editar"><i class="nav-icon fas fa-edit"></i></button>' : '';
        $btnBorrar = $_SESSION['permisosMod']['del'] ?
            '<button class="btn btn-danger btn-sm btn-table btnBorrar" title="Eliminar"><i class="nav-icon fas fa-trash"></i></button>' : '';

        return '<div class="text-center"><div class="btn-group">' . $btnEditar . ' ' . $btnBorrar . '</div></div>';
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
        $IdPersona = strtoupper(limpiarCadena($_POST['idpersona']));
        $Codigo = strtoupper(limpiarCadena($_POST['codigo']));
        $IdArea = intval(limpiarCadena($_POST['idarea']));

        $request_empleado = $this->handleEmpleadoRequest($IdEmpleado, $Codigo, $IdPersona, $IdArea);
        echo json_encode($request_empleado, JSON_UNESCAPED_UNICODE);
        die();
    }

    private function handleEmpleadoRequest($IdEmpleado, $Codigo, $IdPersona, $IdArea)
    {
        if ($IdEmpleado == 0) {
            return $this->crearEmpleado($Codigo, $IdPersona, $IdArea);
        } else {
            return $this->editarEmpleado($IdEmpleado, $IdArea);
        }
    }

    private function crearEmpleado($Codigo, $IdPersona, $IdArea)
    {
        if (!$_SESSION['permisosMod']['cre']) {
            return $this->responseDenegado();
        }

        $request_empleado = $this->model->crearEmpleado($Codigo, $IdPersona, $IdArea);
        return $this->generateResponse($request_empleado, 1);
    }

    private function editarEmpleado($IdEmpleado, $IdArea)
    {
        if (!$_SESSION['permisosMod']['upd']) {
            return $this->responseDenegado();
        }

        $request_empleado = $this->model->editarEmpleado($IdEmpleado, $IdArea);
        return $this->generateResponse($request_empleado, 2);
    }

    private function generateResponse($request_empleado, $option)
    {
        if ($request_empleado == 'exist') {
            return array(
                'status' => false,
                'title' => 'Datos duplicados',
                'msg' => 'El código de Empleado ya existe.',
                'results' => $request_empleado
            );
        }

        if ($request_empleado > 0) {
            return array(
                'status' => true,
                'title' => $option == 1 ? 'Registrado' : 'Actualizado',
                'msg' => $option == 1 ? 'Datos guardados correctamente.' : 'Datos Actualizados correctamente.',
                'results' => $request_empleado
            );
        }

        return $this->responseError($request_empleado);
    }

    public function getEmpleado(int $idEmpleado)
    {
        if (!$_SESSION['permisosMod']['rea']) {
            echo json_encode(array(
                'status' => false,
                'title' => 'No permitido',
                'msg' => 'No tiene permisos para realizar esta acción.',
            ), JSON_UNESCAPED_UNICODE);
            die();
        }

        $idEmpleado = intval(limpiarCadena($idEmpleado));
        if ($idEmpleado <= 0) {
            echo json_encode(array('status' => false, 'title' => 'Error', 'msg' => 'ID de empleado inválido.'), JSON_UNESCAPED_UNICODE);
            die();
        }

        $arrData = $this->model->selectEmpleado($idEmpleado);
        $arrResponse = empty($arrData) ?
            array('status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.') :
            array('status' => true, 'title' => 'ok', 'data' => $arrData);

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delEmpleado()
    {
        if (!$_POST) {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }

        if (!$_SESSION['permisosMod']['del']) {
            echo json_encode(array(
                'status' => false,
                'title' => 'No autorizado',
                'msg' => 'No tiene permitido realizar esta acción.',
            ), JSON_UNESCAPED_UNICODE);
            die();
        }

        $idEmpleado = intval(limpiarCadena($_POST['idempleado']));
        $requestDelete = $this->model->eliminarEmpleado($idEmpleado);

        $arrResponse = $requestDelete == 1 ?
            array('status' => true, 'title' => 'Eliminado', 'msg' => 'Se ha eliminado al Empleado') :
            array('status' => false, 'title' => 'Error', 'msg' => 'Error al eliminar el Empleado.');

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getReportEmpleados()
    {
        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->selectReportEmpleados();
            $this->tramiteModel = $this->loadAdditionalModel("Tramite");
            $arrInst = $this->tramiteModel->selectInstitucion();
            $reportGenerator = new ReportGenerator();
            $reportGenerator->createReport($arrInst, $arrData, "Empleados", "landscape", 2);
        } else {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
        }
    }
}
