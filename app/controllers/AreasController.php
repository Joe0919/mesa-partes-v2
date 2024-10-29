<?php
class AreasController extends Controllers
{
    private $tramiteModel;
    public function __construct()
    {
        parent::__construct("Area");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
            exit();
        }
        getPermisos(4);
    }

    // Método para cargar la vista principal de áreas
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
            exit();
        }
        $data = [
            'page_id' => 9,
            'page_tag' => "Áreas",
            'page_title' => "Áreas",
            'file_js' => "areas.js"
        ];
        $this->views->getView("Areas", "index", $data);
    }

    // Método para obtener todas las áreas
    public function getAreas()
    {
        if (!$_SESSION['permisosMod']['rea']) {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }

        $arrData = $this->model->selectAreas();
        foreach ($arrData as &$area) {
            $area['opciones'] = $this->getOpcionesBotones();
            $area['asociados'] = '<h5 class="mb-0" title="Número de datos asociados"><span class="badge badge-pill badge-warning">' . $area['asociados'] . '</span></h5>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método privado para generar los botones de opciones
    private function getOpcionesBotones()
    {
        $btnEditar = $_SESSION['permisosMod']['upd'] ?
            '<button class="btn btn-primary btn-sm btn-table btnEditar" title="Editar"><i class="nav-icon fas fa-edit"></i></button>' : '';
        $btnBorrar = $_SESSION['permisosMod']['del'] ?
            '<button class="btn btn-danger btn-sm btn-table btnBorrar" title="Eliminar"><i class="nav-icon fas fa-trash"></i></button>' : '';

        return '<div class="text-center"><div class="btn-group">' . $btnEditar . ' ' . $btnBorrar . '</div></div>';
    }

    // Método para obtener las áreas para un select
    public function getSelectAreas()
    {
        $arrData = $this->model->selectAreas();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para crear o actualizar un área
    public function setArea()
    {
        try {
            $intIdArea = intval(limpiarCadena($_POST['idarea']));
            $strCodigo = strtoupper(limpiarCadena($_POST['icodigo']));
            $strArea = strtoupper(limpiarCadena($_POST['iarea']));
            $intIdInst = intval(limpiarCadena($_POST['id_inst']));

            $request_area = $this->handleAreaRequest($intIdArea, $strCodigo, $strArea, $intIdInst);
            echo json_encode($request_area, JSON_UNESCAPED_UNICODE);
            die();
        } catch (ArgumentCountError $e) {
            echo json_encode([
                "status" => false,
                "title" => "Error en el servidor",
                "msg" => "Ocurrió un error. Revisa la consola para más detalles.",
                "error" => $e->getMessage()
            ]);
        }
    }

    // Método para manejar las solicitudes de creación o actualización de áreas
    private function handleAreaRequest($intIdArea, $strCodigo, $strArea, $intIdInst)
    {
        if ($intIdArea == 0) {
            return $this->crearArea($strCodigo, $strArea, $intIdInst);
        } else {
            return $this->editarArea($intIdArea, $strCodigo, $strArea);
        }
    }

    // Método para crear un área
    private function crearArea($strCodigo, $strArea, $intIdInst)
    {
        if (!$_SESSION['permisosMod']['cre']) {
            return $this->responseDenegado();
        }

        $request_area = $this->model->crearArea($strCodigo, $strArea, $intIdInst);
        return $this->generateResponse($request_area, 1);
    }

    // Método para editar un área
    private function editarArea($intIdArea, $strCodigo, $strArea)
    {
        if (!$_SESSION['permisosMod']['upd']) {
            return $this->responseDenegado();
        }

        $request_area = $this->model->editarArea($intIdArea, $strCodigo, $strArea);
        return $this->generateResponse($request_area, 2);
    }

    // Método para generar la respuesta basada en el resultado de la operación
    private function generateResponse($request_area, $option)
    {
        if ($request_area == 'exist') {
            return [
                'status' => false,
                'title' => 'Datos duplicados',
                'msg' => 'El Codigo o Area ya existe.',
                'results' => $request_area
            ];
        }

        if ($request_area > 0) {
            return [
                'status' => true,
                'title' => $option == 1 ? 'Registrado' : 'Actualizado',
                'msg' => $option == 1 ? 'Datos guardados correctamente.' : 'Datos Actualizados correctamente.',
                'results' => $request_area
            ];
        }

        return $this->responseError($request_area);
    }



    // Método para obtener un área específica
    public function getArea(int $idarea)
    {
        if (!$_SESSION['permisosMod']['rea']) {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }

        $intIdArea = intval(limpiarCadena($idarea));
        if ($intIdArea <= 0) {
            echo json_encode(['status' => false, 'title' => 'Error', 'msg' => 'ID de área inválido.'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $arrData = $this->model->selectArea($intIdArea);
        $arrResponse = empty($arrData) ?
            ['status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.'] :
            ['status' => true, 'title' => 'ok', 'data' => $arrData];

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para eliminar un área
    public function delArea()
    {
        if (!$_POST) {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }

        if (!$_SESSION['permisosMod']['del']) {
            echo json_encode($this->responseDenegado(), JSON_UNESCAPED_UNICODE);
            die();
        }

        $intIdArea = intval(limpiarCadena($_POST['idarea']));
        $requestDelete = $this->model->eliminarArea($intIdArea);

        switch ($requestDelete) {
            case 1:
                $arrResponse = ['status' => true, 'title' => 'Eliminado', 'msg' => 'Se ha eliminado el Área'];
                break;
            case 'existD':
                $arrResponse = ['status' => false, 'title' => 'Trámite asociado', 'msg' => 'No es posible eliminar, el Área tiene trámites.'];
                break;
            case 'existE':
                $arrResponse = ['status' => false, 'title' => 'Usuario asociado', 'msg' => 'No es posible eliminar, el Área tiene usuarios.'];
                break;
            default:
                $arrResponse = ['status' => false, 'title' => 'Error', 'msg' => 'Error al eliminar el Área.'];
                break;
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getReportAreas()
    {
        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->selectReportAreas();
            $this->tramiteModel = $this->loadAdditionalModel("Tramite");
            $arrInst = $this->tramiteModel->selectInstitucion();
            $reportGenerator = new ReportGenerator();
            $reportGenerator->createReport($arrInst, $arrData, "Areas", "portrait", -1);
        } else {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
        }
    }
}
