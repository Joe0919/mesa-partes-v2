<?php
class InstitucionController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Institucion");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
            exit();
        }
    }

    // Método para obtener información de una institución
    public function getInstitucion(int $idinstitucion)
    {
        if (!$_SESSION['permisosMod']['rea']) {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }

        $IDinst = intval($idinstitucion);
        if ($IDinst > 0) {
            $arrData = $this->model->consultarInst($IDinst);
            $arrResponse = empty($arrData)
                ? ['status' => false, 'msg' => 'Datos no encontrados.']
                : ['status' => true, 'data' => $arrData];
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // Método para establecer o actualizar una institución
    public function setInstitucion()
    {
        if (!$_POST) {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }

        $arrResponse = $this->validateInstitucionData($_POST);
        if ($arrResponse['status'] === false) {
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

        $idInst = intval(limpiarCadena($_POST['idinstitucion']));
        $RUC = limpiarCadena($_POST['ruc']);
        $Razon = strtoupper(limpiarCadena($_POST['razon']));
        $Direc = strtoupper(limpiarCadena($_POST['instdirec']));
        $ruta_foto = $this->handleFileUpload($idInst, $RUC);

        if ($idInst > 0 && $_SESSION['permisosMod']['upd']) {
            $request_inst = $this->model->editarInst($idInst, $RUC, $Razon, $Direc, $ruta_foto);
            $arrResponse = $this->generateResponse($request_inst, $ruta_foto);
        } else {
            $arrResponse = ["status" => false, "title" => "Error", "msg" => "El ID es 0 o no tiene permisos."];
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para obtener el listado de instituciones
    public function getSelectInst()
    {
        $arrData = $this->model->selectInst();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método para validar los datos de la institución
    private function validateInstitucionData($data)
    {
        if (empty($data['idinstitucion']) || empty($data['ruc']) || empty($data['razon']) || empty($data['instdirec'])) {
            return ["status" => false, "title" => "Faltan Datos", "msg" => 'Completar todos los campos obligatorios.'];
        }
        return ["status" => true];
    }

    // Método para manejar la subida de archivos
    private function handleFileUpload($idInst, $RUC)
    {
        if ($_POST['logo_bdr'] !== '1') {
            return '';
        }

        $foto = $_FILES['foto'];
        $ruta_aux = UPLOADS_PATH . 'inst/';
        $file_tmp_name = $foto['tmp_name'];
        $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $date = date("Ymd");
        $nuevo_nombre = $ruta_aux . 'logo' . $idInst . '_' . $RUC . '_' . $date . '.' . $ext;

        if (!file_exists($ruta_aux)) {
            mkdir($ruta_aux, 0777, true);
        } else {
            $files = array_diff(scandir($ruta_aux), array('.', '..'));
            if (count($files) > 0) {
                eliminarArchivos($ruta_aux);
            }
        }

        if (move_uploaded_file($file_tmp_name, $nuevo_nombre)) {
            return 'files/images/inst/logo' . $idInst . '_' . $RUC . '_' . $date . '.' . $ext;
        } else {
            return array("status" => false, "title" => "Error", "msg" => 'No fue posible guardar la foto.');
        }
    }

    // Método para generar la respuesta según el resultado de la operación
    private function generateResponse($request_inst, $ruta_foto)
    {
        if ($request_inst === 'exist') {
            return [
                'status' => false,
                'title' => 'Datos duplicados',
                'msg' => 'RUC o Razón de la Institución ya existen.',
            ];
        } elseif ($request_inst > 0) {
            return [
                'status' => true,
                'title' => 'Actualizado',
                'msg' => 'Datos actualizados correctamente.',
                'results' => $request_inst . " " . $ruta_foto,
            ];
        } else {
            return ["status" => false, 'title' => 'Error', "msg" => 'No es posible almacenar los datos.'];
        }
    }
}
