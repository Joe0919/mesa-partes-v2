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
            header('Location: ' . base_url() . '/dashboard');
        }
    }
    public function getInstitucion(int $idinstitucion)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $IDinst = intval($idinstitucion);
            if ($IDinst > 0) {
                $arrData = $this->model->consultarInst($IDinst);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $arrResponse = array(
                'status' => true, 'title' => 'Acceso denegado',
                'msg' => 'No tienes permisos para esta acción.'
            );
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setInstitucion()
    {
        if ($_POST) {

            if (empty($_POST['idinstitucion']) || empty($_POST['ruc']) || empty($_POST['razon']) || empty($_POST['instdirec'])) {
                $arrResponse = array("status" => false, "title" => "Faltan Datos", "msg" => 'Completar todos los campos obligatorios.');
            } else {
                $idInst = intval(limpiarCadena($_POST['idinstitucion']));
                $RUC = limpiarCadena($_POST['ruc']);
                $Razon = strtoupper(limpiarCadena($_POST['razon']));
                $Direc = strtoupper(limpiarCadena($_POST['instdirec']));
                $foto = $_FILES['foto'];

                $request_inst = "";
                $ruta_foto = "";


                if ($_POST['logo_bdr'] === '1') {
                    $ruta_aux = UPLOADS_PATH . 'inst/'; // RAIZ/public/files/images/
                    $file_tmp_name = $foto['tmp_name'];

                    $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
                    $date = date("Ymd");

                    $nuevo_nombre = $ruta_aux . 'logo' . $idInst . '_' . $RUC . '_' . $date . '.' . $ext;

                    if (file_exists($ruta_aux)) {
                        $files = array_diff(scandir($ruta_aux), array('.', '..'));
                        if (count($files) > 0) {
                            eliminarArchivos($ruta_aux);
                        }
                    } else {
                        mkdir($ruta_aux, 0777, true);
                    }

                    if (move_uploaded_file($file_tmp_name, $nuevo_nombre)) {
                        $ruta_foto = 'files/images/inst/logo' . $idInst . '_' . $RUC . '_' . $date . '.' . $ext;
                    } else {
                        $arrResponse = array("status" => false, "title" => "Error", "msg" => 'No fue posible guardar la foto.');
                    }
                }

                if ($idInst > 0) {
                    if ($_SESSION['permisosMod']['upd']) {
                        $ruta_foto = ($_POST['logo_bdr'] === '1') ? $ruta_foto : "";
                        $request_inst = $this->model->editarInst(
                            $idInst,
                            $RUC,
                            $Razon,
                            $Direc,
                            $ruta_foto
                        );
                    }
                } else {
                    $request_inst = "ID es 0";
                }

                if ($request_inst === 'exist') {
                    $arrResponse = array(
                        'status' => false, 'title' => 'Datos duplicados', 'msg' => 'Ruc o Razon de la Institucion ya existen.',
                        'results' =>  $request_inst
                    );
                } else if ($request_inst > 0) {

                    $arrResponse = array(
                        'status' => true,
                        'title' => 'Actualizado',
                        'msg' => 'Datos actualizados correctamente.',
                        'results' => $request_inst . " " . $ruta_foto
                    );
                } else {
                    $arrResponse = array(
                        "status" => false, 'title' => 'Error', "msg" => 'No es posible almacenar los datos.',
                        'results' => $request_inst
                    );
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
