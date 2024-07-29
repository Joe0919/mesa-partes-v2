<?php

class AreaModel extends Mysql
{

    private $intIdArea;
    private $strCodArea;
    private $strArea;
    private $intIdInstitucion;


    public function __construct()
    {
        parent::__construct();
    }


    public function selectAreas()
    {
        $whereAdmin = "";
        if ($_SESSION['idUsuario'] != 1) {
            $whereAdmin = " and a.idareas != 1 ";
        }
        $sql = "SELECT a.idarea ID, cod_area, area, ai.idareainstitu IdAInst, COUNT(e.idareainstitu) asociados
        FROM areainstitu ai LEFT JOIN derivacion e on ai.idareainstitu=e.idareainstitu
        JOIN institucion i on ai.idinstitucion=i.idinstitucion
        JOIN area a on a.idarea=ai.idarea WHERE ai.deleted = 0" . $whereAdmin . " GROUP BY a.idarea, cod_area, area, ai.idareainstitu;";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectArea(int $idArea)
    {
        $this->intIdArea = $idArea;
        $sql = "SELECT a.idarea, cod_area, area,  i.idinstitucion
        from institucion i
        inner join areainstitu ae on ae.idinstitucion=i.idinstitucion
        inner join area a on a.idarea=ae.idarea
        where a.idarea= ? ";
        $request = $this->selectOne($sql, [$this->intIdArea]);
        return $request;
    }

    public function crearArea($codigo, $area, $idinst)
    {
        $this->strCodArea = $codigo;
        $this->strArea = $area;
        $this->intIdInstitucion = $idinst;

        $where = " WHERE area = ? and deleted = 0";
        $request = $this->consultar(
            "*",
            "area",
            $where,
            [$this->strArea]
        );

        if (empty($request)) {
            $arrData = array($this->strArea);
            $request_insert = $this->registrar("area", "(null,(gen_cod_area('A', 4)),?,0)", $arrData);

            $arrData = array($this->intIdInstitucion);
            $request_insert = $this->registrar("areainstitu", " (null,?," . $request_insert . ",0)", $arrData);

            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }


    public function editarArea($id_area, $codigo, $area)
    {
        $this->intIdArea = $id_area;
        $this->strCodArea = $codigo;
        $this->strArea = $area;

        $where = " WHERE area = ? and deleted = 0 and idarea != ? ";
        $request = $this->consultar(
            "*",
            "area",
            $where,
            [$this->strArea, $this->intIdArea]
        );

        if (empty($request)) {
            $request = $this->editar(
                "area",
                "area = ?",
                "idarea = ?",
                [$this->strArea, $this->intIdArea]
            );
        } else {
            $request = 'exist';
        }
        return $request;
    }

    public function eliminarArea($id_area)
    {
        $this->intIdArea = $id_area;

        $where = " WHERE a.idarea=? ";
        $request = $this->consultar(
            "*",
            "derivacion d JOIN areainstitu ae ON ae.idareainstitu=d.idareainstitu
            JOIN area a ON a.idarea=ae.idarea",
            $where,
            [$this->intIdArea]
        );

        if (empty($request)) {
            $where = " WHERE idareainstitu=(select idareainstitu from areainstitu where idarea=?) ";
            $request = $this->consultar(
                "*",
                "empleado",
                $where,
                [$this->intIdArea]
            );
            if (empty($request)) {
                $request = $this->editar(
                    " areainstitu",
                    " deleted = 1 ",
                    " idarea = ? ",
                    [$this->intIdArea]
                );
                $request = $this->editar(
                    " area",
                    " deleted = 1 ",
                    " idarea = ? ",
                    [$this->intIdArea]
                );
                if ($request) {
                    $request = 1;
                } else {
                    $request = 'error';
                }
            } else {
                $request = 'existE';
            }
        } else {
            $request = 'existD';
        }
        return $request;
    }
}
