<?php

class PersonaModel extends Mysql
{
    private $strDNI;
    private $strApPat;
    private $strApMat;
    private $strNombres;
    private $strEmail;
    private $strCel;
    private $strDireccion;
    private $strRUC;
    private $strEntidad;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectPersona(string $dni)
    {
        $this->strDNI = $dni;
        $sql = "SELECT * FROM persona WHERE dni = ? and deleted = 0";
        $request = $this->selectOne($sql, [$this->strDNI]);
        return $request;
    }

    public function insertPersona($dni, $appat, $apmat, $nombres, $correo, $cel, $direc, $ruc, $entidad)
    {
        $this->strDNI = $dni;
        $this->strApPat = $appat;
        $this->strApMat = $apmat;
        $this->strNombres = $nombres;
        $this->strEmail = $correo;
        $this->strCel = $cel;
        $this->strDireccion = $direc;
        $this->strRUC = $ruc;
        $this->strEntidad = $entidad;

        $where = " WHERE dni = ? or email = ? or telefono = ?";
        $request = $this->consultar(
            "*",
            "persona",
            $where,
            [$this->strDNI, $this->strEmail, $this->strCel]
        );

        if (empty($request)) {
            $arrData = array(
                $this->strDNI,
                $this->strApPat,
                $this->strApMat,
                $this->strNombres,
                $this->strEmail,
                $this->strCel,
                $this->strDireccion,
                $this->strRUC,
                $this->strEntidad
            );
            $request_insert = $this->registrar("persona", "(null,?,?,?,?,?,?,?,?,?,0)", $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function editarPersona($correo, $telefono, $dni)
    {
        $this->strEmail = $correo;
        $this->strCel = $telefono;
        $this->strDNI = $dni;

        $where = " WHERE (email = ? or telefono = ?) and dni != ?";
        $request = $this->consultar(
            "*",
            "persona",
            $where,
            [$this->strEmail, $this->strCel, $this->strDNI]
        );

        if (empty($request)) {
            $request = $this->editar(
                "persona",
                "email = ?, telefono = ?",
                "dni = ?",
                [$this->strEmail, $this->strCel, $this->strDNI]
            );
            $return = $request;
        } else {
            $return = "exist";
        }
        return $return;
    }
}
