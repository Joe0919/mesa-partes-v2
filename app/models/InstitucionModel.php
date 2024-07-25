<?php


class InstitucionModel extends Mysql
{
    public $intIdInst;
    public $strRUC;
    public $strRazon;
    public $strDireccion;
    public $Foto;

    public function __construct()
    {
        parent::__construct();
    }

    public function consultarInst($idinstitucion)
    {
        $this->intIdInst = $idinstitucion;
        $sql = "SELECT * FROM institucion WHERE idinstitucion = ? ";
        $request = $this->selectOne($sql, [$this->intIdInst]);
        return $request;
    }

    public function editarInst(int $idinst, string $ruc, string $razon, string $desc, string $logo = "")
    {
        $this->intIdInst = $idinst;
        $this->strRUC = $ruc;
        $this->strRazon = $razon;
        $this->strDireccion = $desc;
        $this->Foto = $logo;

        $where = " WHERE ruc = ? and razon = ? AND idinstitucion != ? ";
        $request = $this->consultar("*", "institucion", $where, [$this->strRUC, $this->strRazon, $this->intIdInst]);

        if (empty($request)) {

            if ($logo == "") {
                $columns = "ruc = ?, razon = ?, direccion = ?";
                $arrayData =  [$this->strRUC, $this->strRazon, $this->strDireccion, $this->intIdInst];
            } else {
                $columns = "ruc = ?, razon = ?, direccion = ?, logo = ?";
                $arrayData = [$this->strRUC, $this->strRazon, $this->strDireccion, $this->Foto, $this->intIdInst];
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
