<?php

class PermisosModel extends Mysql
{
    public $intIdpermiso;
    public $intIdRol;
    public $intIdModulo;
    public $cre;
    public $rea;
    public $upd;
    public $del;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectModulos()
    {
        $sql = "SELECT * FROM modulo WHERE estado != 0";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectPermisosRol(int $idrol)
    {
        $this->intIdRol = $idrol;
        $sql = "SELECT * FROM permiso WHERE idroles = $this->intIdRol";
        $request = $this->select_all($sql);
        return $request;
    }

    public function deletePermisos(int $idrol)
    {
        $this->intIdRol = $idrol;
        $sql = "DELETE FROM permiso WHERE idroles = $this->intIdRol";
        $request = $this->delete($sql);
        return $request;
    }

    public function insertPermisos(int $idrol, int $idmodulo, int $cre, int $rea, int $upd, int $del)
    {
        $this->intIdRol = $idrol;
        $this->intIdModulo = $idmodulo;
        $this->cre = $cre;
        $this->rea = $rea;
        $this->upd = $upd;
        $this->del = $del;
        $arrData = array($this->intIdRol, $this->intIdModulo, $this->cre, $this->rea, $this->upd, $this->del);
        $request_insert = $this->registrar("permiso", "(null,?,?,?,?,?,?)", $arrData);
        return $request_insert;
    }

    public function permisosModulo(int $idrol)
    {
        $this->intIdRol = $idrol;
        $sql = "SELECT p.idroles, p.idmodulo, m.titulo modulo,
			    p.cre, p.rea, p.upd, p.del
                FROM permiso p
                INNER JOIN modulo m ON p.idmodulo = m.idmodulo
                WHERE p.idroles = $this->intIdRol ";
        $request = $this->select_all($sql);
        $arrPermisos = array();
        for ($i = 0; $i < count($request); $i++) {
            $arrPermisos[$request[$i]['idmodulo']] = $request[$i];
        }
        return $arrPermisos;
    }
}
