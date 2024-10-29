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
            exit();
        }
        parent::__construct("Acceso");
    }

    // Método para cargar la vista de acceso
    public function index()
    {
        $data = [
            'page_id' => 4,
            'page_tag' => "Acceso",
            'page_title' => "Acceso",
            'file_js' => "acceso.js"
        ];
        $this->views->getView("Acceso", "index", $data);
    }

    // Método para manejar el inicio de sesión
    public function login()
    {
        try {
            if ($_POST) {
                $usuario = limpiarCadena($_POST["usuario"]);
                $password = limpiarCadena($_POST["password"]);
                $requestUser = $this->model->loginUser($usuario, $password);
                echo json_encode($this->handleLoginResponse($requestUser), JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
            }
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

    // Método para manejar la respuesta del inicio de sesión
    private function handleLoginResponse($requestUser)
    {
        if (empty($requestUser)) {
            return [
                'status' => false,
                'title' => 'Datos no Registrados',
                'msg' => 'No se encuentra registrado en el sistema.',
                'results' => $requestUser
            ];
        }

        if ($requestUser == 1) {
            return [
                'status' => false,
                'title' => 'Datos Incorrectos',
                'msg' => 'Usuario y/o contraseña incorrectos.',
                'results' => $requestUser
            ];
        }

        $arrData = $requestUser;
        if ($arrData["estado"] === 'ACTIVO') {
            $_SESSION["idUsuario"] = $arrData["idusuarios"];
            $_SESSION["login"] = true;

            // Iniciar la sesión y guardar los datos del usuario
            $this->model->sessionLogin($_SESSION['idUsuario']);
            sessionUser($_SESSION['idUsuario']);

            // Guardar datos de acceso
            $this->model->registrarAcceso($_SESSION['idUsuario']);

            return [
                'status' => true,
                'title' => 'OK',
                'msg' => 'Ingresando.',
                'results' => $requestUser
            ];
        } else {
            return [
                'status' => false,
                'title' => 'Usuario Inactivo',
                'msg' => 'Comuníquese con el administrador para activar su cuenta.',
                'results' => $requestUser
            ];
        }
    }
}
