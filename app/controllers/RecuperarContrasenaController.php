<?php
class RecuperarContrasenaController extends Controllers
{
    private $tramiteModel;
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

    // Método para cargar la vista
    public function index()
    {
        $data = [
            'page_id' => 5,
            'page_tag' => "Recuperar contraseña",
            'page_title' => "Recuperar contraseña",
            'file_js' => "recuperarContrasena.js"
        ];
        $this->views->getView("recuperar-contrasena", "index", $data);
    }

    public function getUsuario()
    {
        if ($_POST) {
            $dni = limpiarCadena($_POST["dni"]);
            $correo = limpiarCadena($_POST["correo"]);

            $request = $this->model->verificarUsuario($dni, $correo);

            if (empty($request)) {
                $arrResponse = [
                    'status' => false,
                    'title' => 'Usuario no encontrado',
                    'msg' => 'Intente ingresar nuevamente los datos correctos.',
                ];
            } else {
                $arrResponse = [
                    'status' => true,
                    'title' => 'Usuario encontrado',
                    'data' => $request
                ];
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setPswUsuario()
    {
        if ($_POST) {
            if (
                empty($_POST['idusuario'])
            ) {
                $arrResponse = array("status" => false, "title" => "Faltan Datos", "msg" => 'Complete correctamente');
            } else {
                $idUsuario = intval(limpiarCadena($_POST['idusuario']));
                $usuario = limpiarCadena($_POST['usuario']);
                $correo = limpiarCadena($_POST['correo']);
                $nuevaContrasena = genContrasena();
                $request = "";

                if ($idUsuario !== 0) {

                    $request = $this->model->editarPswUsuario($idUsuario, $nuevaContrasena);

                    if ($request > 0) {

                        $html = "<p class='p_name'>Estimado(a): <b>" . $usuario . "</b></p>
                            <hr>
                            <p>Se le envía este mensaje desde la <b>Mesa de Partes Virtual</b> del <b>Hospital Antonio Caldas Domínguez -
                                    Pomabamba.</b>
                                <br>Para informarle que se realizó satisfactoriamente el cambio de su contraseña la cual se muestra a continuación:
                            </p> 
                            <div class='container div-contra'>
                                <h1>
                                    Su nueva contraseña es:
                                </h1>
                                <h2>
                                    " . $nuevaContrasena . "
                                </h2>
                                <br>
                                <p>
                                    Le recomendamos ingresar al sistema y cambiar su contraseña para asi evitar cualquier inconveniente o robo
                                    de información.
                                </p>
                                <br>
                            </div>";

                        $this->tramiteModel = $this->loadAdditionalModel("Tramite");
                        $arrInst = $this->tramiteModel->selectInstitucion();
                        $response = $this->enviarCorreo("MESA DE PARTES VIRTUAL", $usuario, $correo, "CAMBIO DE CONTRASEÑA", $html, $arrInst);

                        $arrResponse = array(
                            'status' => true,
                            'title' => 'Actualizado',
                            'msg' => 'La contraseña se actualizó',
                            'data' =>  $nuevaContrasena,
                            'response' => $response
                        );
                    } else {
                        $arrResponse = array(
                            'status' => false,
                            'title' => 'Error',
                            'msg' => 'No se actualizó la contraseña',
                            'data' =>  $request
                        );
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode($this->sinPOSTResponse(), JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
