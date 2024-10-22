<?php

class EmpleadoModel extends Mysql
{
    private $intIdEmpleado;
    private $strCod_empleado;
    private $intIdPersona;
    private $intIdArea;

    function __construct()
    {
        parent::__construct();
    }

    public function selectEmpleados()
    {
        $whereAdmin = "";
        if ($_SESSION['idUsuario'] != 1) {
            $whereAdmin = " and e.idempleado != 1 ";
        }
        $sql = "SELECT idempleado ID, cod_empleado Codigo, dni, concat(ap_paterno,' ',ap_materno,' ',nombres) Datos, telefono, area
        FROM empleado e JOIN persona p on e.idpersona=p.idpersona
        JOIN areainstitu a on e.idareainstitu=a.idareainstitu
        JOIN area ae on ae.idarea=a.idarea WHERE e.deleted = 0" . $whereAdmin;
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectReportEmpleados(
        string $columnas = "ROW_NUMBER() OVER (ORDER BY idempleado) N°,p.dni DNI, concat(ap_paterno,' ',ap_materno,' ', nombres) 'APELLIDOS Y NOMBRES',
         p.telefono TELEFONO, e.cod_empleado Codigo, ae.area Area",
        string $tablas = "empleado e JOIN persona p on e.idpersona=p.idpersona JOIN areainstitu a on e.idareainstitu=a.idareainstitu
        JOIN area ae on ae.idarea=a.idarea",
        string $condicion = "where e.deleted = 0 ",
    ) {
        $sql = "SELECT $columnas FROM $tablas $condicion ";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectEmpleado(int $idempleado)
    {
        $this->intIdEmpleado = $idempleado;
        $sql = "SELECT e.idempleado,p.idpersona, p.dni dni, p.nombres, p.ap_paterno ap, p.ap_materno am, 
                p.telefono, p.direccion, e.cod_empleado, e.idareainstitu,ar.idarea,
                ar.area Area, a.idinstitucion IDInst
                from empleado e
                JOIN persona p ON e.idpersona = p.idpersona
                JOIN areainstitu a ON e.idareainstitu = a.idareainstitu
                JOIN area ar ON a.idarea = ar.idarea
                where e.idempleado = ? ";
        $request = $this->selectOne($sql, [$this->intIdEmpleado]);
        return $request;
    }

    public function selectUsuariosPendientes()
    {
        $sql = "SELECT u.idusuarios,
                CONCAT('DNI : ', p.dni, ' : ', p.ap_paterno, ' ', p.ap_materno, ' ', p.nombres) AS Datos
                FROM usuarios u JOIN persona p ON u.dni = p.dni
                LEFT JOIN empleado e ON p.idpersona = e.idpersona
                WHERE u.deleted = 0
                    AND (e.idpersona IS NULL OR e.deleted = 1)";
        $request = $this->select_all($sql);
        return $request;
    }

    public function crearEmpleado($codigo, $idpersona, $idArea)
    {
        $this->strCod_empleado = $codigo;
        $this->intIdPersona = $idpersona;
        $this->intIdArea = $idArea;

        $where = " WHERE idpersona = ? and deleted = 1 ";
        $request = $this->consultar(
            "*",
            "empleado",
            $where,
            [$this->intIdPersona]
        );

        if (empty($request)) {

            $arrData = array($this->intIdPersona, $this->intIdArea);
            $request_insert = $this->registrar("empleado", "(null,(gen_cod_empleado('E', 5)),?,
                (SELECT idareainstitu FROM areainstitu WHERE idarea = ?),0)", $arrData);

            $request = $this->editar(
                "usuarios",
                "estado = 'ACTIVO'",
                "dni = (SELECT dni FROM persona WHERE idpersona = ?)",
                [$this->intIdPersona]
            );

            $return = $request_insert;
        } else {

            $request = $this->editar(
                " empleado",
                " deleted = 2",
                " idpersona = ?",
                [$this->intIdPersona]
            );

            $arrData = array($this->intIdPersona, $this->intIdArea);
            $request_insert = $this->registrar("empleado", "(null,(gen_cod_empleado('E', 5)),?,
                (SELECT idareainstitu FROM areainstitu WHERE idarea = ?),0)", $arrData);

            $request = $this->editar(
                "usuarios",
                "estado = 'ACTIVO'",
                "dni = (SELECT dni FROM persona WHERE idpersona = ?)",
                [$this->intIdPersona]
            );

            return $request;
        }

        return $return;
    }

    public function editarEmpleado($idempleado, $idArea)
    {
        $this->intIdEmpleado = $idempleado;
        $this->intIdArea = $idArea;

        $request = $this->editar(
            " empleado",
            " idareainstitu = (SELECT idareainstitu FROM areainstitu WHERE idarea = ?) ",
            " idempleado = ? ",
            [$this->intIdArea, $this->intIdEmpleado]
        );

        return $request;
    }

    public function eliminarEmpleado($idempleado)
    {
        $this->intIdEmpleado = $idempleado;

        $request = $this->editar(
            " empleado",
            " deleted = 1 ",
            " idempleado = ? ",
            [$this->intIdEmpleado]
        );

        $request = $this->editar(
            "usuarios",
            "estado = 'INACTIVO'",
            "dni = (SELECT dni FROM persona WHERE idpersona = 
            (SELECT idpersona FROM empleado WHERE idempleado = ?))",
            [$this->intIdEmpleado]
        );

        return $request;
    }
}
