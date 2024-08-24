<?php

class TramitesEnviadosController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Tramite");
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // session_regenerate_id(true); //# MEJORAR EL USO
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/acceso');
        }
        getPermisos(9);
    }
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data['page_id'] = 10;
        $data['page_tag'] = "Trámites Enviados";
        $data['page_title'] = "Trámites Enviados";
        $data['file_js'] = "tramitesEnviados.js";
        $this->views->getView("tramites-enviados", "index", $data);
    }

    public function getTramites($area)
    {
        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->selectTramitesEnviados($area);
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnHistory = '';

                $arrData[$i]['expediente'] = '<b>' . $arrData[$i]['expediente'] . '</b>';

                if ($arrData[$i]['estado'] == "PENDIENTE") {
                    $arrData[$i]['estado'] = '<span class="badge bg-black">' . $arrData[$i]['estado'] . '</span>';
                } else if ($arrData[$i]['estado'] == "ACEPTADO") {
                    $arrData[$i]['estado'] = '<span class="badge bg-success">' . $arrData[$i]['estado'] . '</span>';
                } elseif ($arrData[$i]['estado'] == "DERIVADO") {
                    $arrData[$i]['estado'] = '<span class="badge bg-primary">' . $arrData[$i]['estado'] . '</span>';
                } elseif ($arrData[$i]['estado'] == "RECHAZADO") {
                    $arrData[$i]['estado'] = '<span class="badge bg-danger">' . $arrData[$i]['estado'] . '</span>';
                } else {
                    $arrData[$i]['estado'] = '<span class="badge bg-info">' . $arrData[$i]['estado'] . '</span>';
                }

                if ($_SESSION['permisosMod']['rea']) {
                    $btnView = '<button class="btn btn-warning btn-sm btn-table btnMas" title="Más Información"><i class="nav-icon fas fa-eye"></i></button>';
                    $btnHistory = '<button class="btn btn-success btn-sm btn-table btnSeguimiento" title="Ver Historial"><i class="nav-icon fas fa-search"></i></button>';
                }
                $arrData[$i]['opciones'] = '<div class="text-center"><div class="btn-group">' . $btnView . ' ' . $btnHistory . '</div></div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }

        die();
    }

    public function getTramites1($idarea = null, $area = null, $estado = null)
    {
        // Verifica si los parámetros están presentes y no vacíos
        if ($idarea && $area && $estado) {
            // Procesa los parámetros
            echo "ID Area: " . htmlspecialchars($idarea) . "<br>";
            echo "Area: " . htmlspecialchars($area) . "<br>";
            echo "Estado: " . htmlspecialchars($estado) . "<br>";
        } else {
            echo "Faltan parámetros necesarios.";
        }
    }
}
