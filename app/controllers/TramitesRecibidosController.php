<?php

class TramitesRecibidosController extends Controllers
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
        getPermisos(8);
    }
    public function index()
    {
        if (empty($_SESSION['permisosMod']['rea'])) {
            header("Location:" . base_url() . '/dashboard');
        }

        $data['page_id'] = 9;
        $data['page_tag'] = "Trámites Recibidos";
        $data['page_title'] = "Trámites Recibidos";
        $data['file_js'] = "tramitesRecibidos.js";
        $this->views->getView("tramites-recibidos", "index", $data);
    }

    public function getTramites($idarea, $area, $estado)
    {

        if ($_SESSION['permisosMod']['rea']) {
            $arrData = $this->model->selectTramitesRecibidos($area, $estado, $idarea);
            for ($i = 0; $i < count($arrData); $i++) {

                $botones = '';

                $arrData[$i]['expediente'] = '<b>' . $arrData[$i]['expediente'] . '</b>';

                if ($_SESSION['permisosMod']['upd']) {
                    switch ($arrData[$i]['estado']) {
                        case "PENDIENTE":
                            $botones = '<button class="btn btn-success btn-sm btn-table btnAceptar" title="Aceptar/Rechazar"><i class="nav-icon fas fa-check"></i></button>';
                            break;
                        case "ACEPTADO":
                            $botones = '<button class="btn btn-danger btn-sm btn-table btnDerivar" title="Derivar/Archivar"><i class="nav-icon fas fa-arrow-right"></i></button>';
                            break;
                    }
                }

                if ($_SESSION['permisosMod']['rea']) {
                    $botones .= '<button class="btn btn-info btn-sm btn-table btnMas" title="Más Información"><i class="nav-icon fas fa-eye"></i></button>
                                <button class="btn btn-warning btn-sm btn-table btnSeguimiento" title="Ver Historial"><i class="nav-icon fas fa-search"></i></button>';
                }

                switch ($arrData[$i]['estado']) {
                    case "PENDIENTE":
                        $arrData[$i]['estado'] = '<span class="badge bg-black">' . $arrData[$i]['estado'] . '</span>';
                        break;
                    case "ACEPTADO":
                        $arrData[$i]['estado'] = '<span class="badge bg-success">' . $arrData[$i]['estado'] . '</span>';
                        break;
                    case "DERIVADO":
                        $arrData[$i]['estado'] = '<span class="badge bg-primary">' . $arrData[$i]['estado'] . '</span>';
                        break;
                    case "RECHAZADO":
                        $arrData[$i]['estado'] = '<span class="badge bg-danger">' . $arrData[$i]['estado'] . '</span>';
                        break;
                    default:
                        $arrData[$i]['estado'] = '<span class="badge bg-info">' . $arrData[$i]['estado'] . '</span>';
                        break;
                }



                $arrData[$i]['opciones'] = '<div class="text-center"><div class="btn-group">' . $botones .  '</div></div>';
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
