<?php

class AccesoController extends Controllers
{
    public function __construct()
    {
        session_start();
        if (isset($_SESSION['login'])) {
            header('Location: ' . base_url() . '/dashboard');
            echo $_SESSION['login'];
        }

        parent::__construct("Acceso");
    }

    public function index()
    {
        $data['page_id'] = 1;
        $data['page_tag'] = "Acceso";
        $data['page_title'] = "Acceso al Sistema";
        $data['page_name'] = "acceso";
        $data['page_content'] = "Contenido";

        $this->views->getView("Acceso", "index", $data);
    }

    public function login()
    {

        if (isset($_POST["enviar"])) {

            $usuario = $_POST["usuario"];
            $password = $_POST["password"];

            $requestUser = $this->model->loginUser($usuario, $password);

            if (!empty($requestUser)) {
                $arrData = $requestUser;
                print_r($arrData);
                if ($arrData["estado"] === 'ACTIVO') {
                    $_SESSION["idUsuario"] = $arrData["idusuarios"];
                    $_SESSION["login"] = true;

                    $arrData = $this->model->sessionLogin($_SESSION['idUsuario']);
                    sessionUser($_SESSION['idUsuario']);

                    header("Location:" . base_url()  . "/dashboard");
                    exit();
                } else {
                    // header("Location:" . URL  . "/views/acceso/index.php?m=2");
                    echo "El usuario no esta activo";
                }
            } else {
                // header("Location:" . URL  . "/views/acceso/index.php?m=1");
                echo "El usuario no existe";
                exit();
            }
        }
        die();
    }
}
