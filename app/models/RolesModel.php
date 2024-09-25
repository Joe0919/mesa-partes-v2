<?php

class RolesModel extends Mysql
{

    private $intIdrol;
    private $strRol;
    private $strDescripcion;
    private $intEstado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectRoles()
    {
        $whereAdmin = "";
        if ($_SESSION['idUsuario'] != 1) {
            $whereAdmin = " and u.idroles != 1 ";
        }
        //EXTRAE ROLES
        $sql = "SELECT r.*, COUNT(u.idroles) asociados FROM 
            roles r LEFT JOIN usuarios u ON r.idroles = u.idroles " . $whereAdmin .
            " WHERE r.deleted = 0  GROUP BY r.idroles";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectRol(int $idrol)
    {
        //BUSCAR ROL
        $this->intIdrol = $idrol;
        $sql = "SELECT * FROM roles  WHERE idroles = ? ";
        $request = $this->selectOne($sql, [$this->intIdrol]);
        return $request;
    }

    public function insertRol(string $rol, string $descripcion, int $status)
    {

        $this->strRol = $rol;
        $this->strDescripcion = $descripcion;
        $this->intEstado = $status;

        $where = " WHERE rol = ? ";
        $request = $this->consultar("*", "roles", $where, [$this->strRol]);

        if (empty($request)) {
            $arrData = array($this->strRol, $this->strDescripcion, $this->intEstado);
            $request_insert = $this->registrar("roles", "(null,?,?,?,0)", $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function editarRol(int $idrol, string $rol, string $descripcion, int $status)
    {
        $this->intIdrol = $idrol;
        $this->strRol = $rol;
        $this->strDescripcion = $descripcion;
        $this->intEstado = $status;

        $where = " WHERE rol = ? AND idroles <> ? ";
        $request = $this->consultar("*", "roles", $where, [$this->strRol, $this->intIdrol]);

        if (empty($request)) {
            $arrData = array($this->strRol, $this->strDescripcion, $this->intEstado, $this->intIdrol);
            $request = $this->editar(
                "roles",
                " rol = ?, descripcion = ?, estado = ?",
                " idroles = ? ",
                $arrData
            );
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function eliminarRol(int $idrol)
    {
        $this->intIdrol = $idrol;

        $where = " WHERE idroles = ? ";
        $request = $this->consultar("*", "usuarios", $where, [$this->intIdrol]);

        if (empty($request)) {
            $request = $this->editar(
                "roles",
                " deleted = 1 ",
                " idroles = ? ",
                [$this->intIdrol]
            );
            if ($request) {
                $request = 1;
            } else {
                $request = 'error';
            }
        } else {
            $request = 'exist';
        }
        return $request;
    }
}
