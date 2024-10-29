<?php


class InstitucionModel extends Mysql
{
    public $intIdInst;
    public $strRUC;
    public $strRazon;
    public $strDireccion;
    public $strTelefono;
    public $strEmail;
    public $strPagWeb;
    public $strSector;
    public $Foto;

    public function __construct()
    {
        parent::__construct();
    }


    public function selectInst()
    {
        //EXTRAE ROLES
        $sql = "SELECT * FROM institucion where deleted != 1 ";
        $request = $this->select_all($sql);
        return $request;
    }

    public function consultarInst($idinstitucion)
    {
        $this->intIdInst = $idinstitucion;
        $sql = "SELECT * FROM institucion WHERE idinstitucion = ? ";
        $request = $this->selectOne($sql, [$this->intIdInst]);
        return $request;
    }

    public function editarInst(int $idinst, string $ruc, string $razon, string $desc, string $tel, string $email, string $web, string $sector, string $logo = "")
    {
        $this->intIdInst = $idinst;
        $this->strRUC = $ruc;
        $this->strRazon = $razon;
        $this->strDireccion = $desc;
        $this->strTelefono = $tel;
        $this->strEmail = $email;
        $this->strPagWeb = $web;
        $this->strSector = $sector;
        $this->Foto = $logo;

        $where = " WHERE ruc = ? and razon = ? AND idinstitucion != ? ";
        $request = $this->consultar("*", "institucion", $where, [$this->strRUC, $this->strRazon, $this->intIdInst]);

        if (empty($request)) {

            if ($logo == "") {
                $columns = "ruc = ?, razon = ?, direccion = ?, telefono = ?, email = ?, web = ?, sector = ?";
                $arrayData =  [$this->strRUC, $this->strRazon, $this->strDireccion, $this->strTelefono, $this->strEmail, $this->strPagWeb, $this->strSector, $this->intIdInst];
            } else {
                $columns = "ruc = ?, razon = ?, direccion = ?, telefono = ?, email = ?, web = ?, sector = ?, logo = ?";
                $arrayData = [$this->strRUC, $this->strRazon, $this->strDireccion, $this->strTelefono, $this->strEmail, $this->strPagWeb, $this->strSector, $this->Foto, $this->intIdInst];
            }
            $request = $this->editar(
                "institucion",
                $columns,
                "idinstitucion = ? ",
                $arrayData
            );
        } else {
            $request = "exist";
        }
        return $request;
    }
}
