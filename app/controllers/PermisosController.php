<?php

class PermisosController extends Controllers
{
    public function __construct()
    {
        parent::__construct("Permisos");
    }
    public function getPermisosRol(int $idrol)
    {
        $rolid = intval($idrol);
        if ($rolid > 0) {
            $arrModulos = $this->model->selectModulos();
            $arrPermisosRol = $this->model->selectPermisosRol($rolid);
            $arrPermisos = array('cre' => 0, 'rea' => 0, 'upd' => 0, 'del' => 0);
            $arrPermisoRol = array('idrol' => $rolid);

            if (empty($arrPermisosRol)) {
                for ($i = 0; $i < count($arrModulos); $i++) {

                    $arrModulos[$i]['permisos'] = $arrPermisos;
                }
            } else {
                for ($i = 0; $i < count($arrModulos); $i++) {
                    $arrPermisos = array('cre' => 0, 'rea' => 0, 'upd' => 0, 'del' => 0);
                    if (isset($arrPermisosRol[$i])) {
                        $arrPermisos = array(
                            'cre' => $arrPermisosRol[$i]['cre'],
                            'rea' => $arrPermisosRol[$i]['rea'],
                            'upd' => $arrPermisosRol[$i]['upd'],
                            'del' => $arrPermisosRol[$i]['del']
                        );
                    }
                    $arrModulos[$i]['permisos'] = $arrPermisos;
                }
            }
            $arrPermisoRol['modulos'] = $arrModulos;
            getModal('roles', "permisos", $arrPermisoRol);
        }
        die();
    }

    public function setPermisos()
    {
        if ($_POST) {
            $intIdrol = intval($_POST['idrol']);
            $modulos = $_POST['modulos'];

            $this->model->deletePermisos($intIdrol);
            foreach ($modulos as $modulo) {
                $idModulo = $modulo['idmodulo'];
                $cre = empty($modulo['cre']) ? 0 : 1;
                $rea = empty($modulo['rea']) ? 0 : 1;
                $upd = empty($modulo['upd']) ? 0 : 1;
                $del = empty($modulo['del']) ? 0 : 1;
                $requestPermiso = $this->model->insertPermisos($intIdrol, $idModulo, $cre, $rea, $upd, $del);
            }
            if ($requestPermiso > 0) {
                $arrResponse = array('status' => true, 'msg' => 'Permisos asignados correctamente.');
            } else {
                $arrResponse = array("status" => false, "msg" => 'No es posible asignar los permisos.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
