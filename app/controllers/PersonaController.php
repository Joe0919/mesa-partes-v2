<?php

class PersonaController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Persona");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function getPersona(string $dni)
    {

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
