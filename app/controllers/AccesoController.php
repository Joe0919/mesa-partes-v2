<?php

class AccesoController extends Controllers
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['login'])) {
            header('Location: ' . base_url() . '/dashboard');
        }

        parent::__construct("Acceso");
    }

    public function index()
    {
        $data['page_id'] = 1;
        $data['page_tag'] = "Acceso";
        $data['page_title'] = "Acceso";
        $data['file_js'] = "acceso.js";

        $this->views->getView("Acceso", "index", $data);
    }

    public function login()
    {
        if ($_POST) {

            $usuario = $_POST["usuario"];
            $password = $_POST["password"];

            $requestUser = $this->model->loginUser($usuario, $password);

            if (!empty($requestUser)) {
                if ($requestUser != 1) {
                    $arrData = $requestUser;
                    if ($arrData["estado"] === 'ACTIVO') {

                        $_SESSION["idUsuario"] = $arrData["idusuarios"];
                        $_SESSION["login"] = true;

                        $arrData = $this->model->sessionLogin($_SESSION['idUsuario']);
                        sessionUser($_SESSION['idUsuario']);

                        $arrResponse = array(
                            'status' => true,
                            'title' => 'OK',
                            'msg' => 'Ingresando.',
                            'results' => $requestUser
                        );
                    } else {
                        $arrResponse = array(
                            'status' => false,
                            'title' => 'Usuario Inactivo',
                            'msg' => 'Comuniquese con el administrador para activar su cuenta.',
                            'results' => $requestUser
                        );
                    }
                } else {
                    $arrResponse = array(
                        'status' => false,
                        'title' => 'Datos Incorrectos',
                        'msg' => 'Usuario y/o contraseña incorrectos.',
                        'results' => $requestUser
                    );
                }
            } else {
                $arrResponse = array(
                    'status' => false,
                    'title' => 'Usuario Inexistente',
                    'msg' => 'No se encuentra registrado en el sistema.',
                    'results' => $requestUser
                );
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
