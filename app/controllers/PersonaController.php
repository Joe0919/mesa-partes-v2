<?php

class PersonaController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Persona");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/dashboard');
            exit();
        }
    }

    public function getPersona(string $dni)
    {
        if (!$_SESSION['permisosMod']['rea']) {
            echo json_encode($this->unauthorizedResponse(), JSON_UNESCAPED_UNICODE);
            die();
        }

        $DNI = limpiarCadena($dni);
        if ($DNI != '') {
            $arrData = $this->model->selectPersona($DNI);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'title' => 'Error', 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'title' => 'ok', 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }

        die();
    }
}
