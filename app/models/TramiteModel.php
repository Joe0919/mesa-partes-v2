<?php

class TramiteModel extends Mysql
{
    private $intIdDerivacion;
    private $strExpediente;
    private $strFecha;
    private $strNroDoc;
    private $intFolios;
    private $strAsunto;
    private $strRuta;
    private $intIdPersona;
    private $strDNI;
    private $intIdTipo;
    private $intIdDoc;
    private $strEstado;
    private $strArea;
    private $strOrigen;
    private $strIdDestino;
    private $strDescripcion;
    private $strAccion;
    private $intIdUbicacion;


    public function __construct()
    {
        parent::__construct();
    }

    public function selectTramites()
    {
        $sql = "SELECT idderivacion, dc.nro_expediente expediente, DATE_FORMAT(d.fechad, '%d/%m/%Y') Fecha,
                tipodoc, dni, CONCAT(p.nombres, ' ', p.ap_paterno, ' ', p.ap_materno) Datos,
                origen, area, estado 
                FROM derivacion d   
                JOIN documento dc ON d.iddocumento = dc.iddocumento
                JOIN areainstitu a ON d.idareainstitu = a.idareainstitu
                JOIN area ae ON a.idarea = ae.idarea
                JOIN persona p ON dc.idpersona = p.idpersona
                JOIN tipodoc t ON dc.idtipodoc = t.idtipodoc 
                JOIN 
                    (SELECT dc.nro_expediente, MAX(d.idderivacion) max_idderivacion
                    FROM derivacion d
                    JOIN documento dc ON d.iddocumento = dc.iddocumento
                    WHERE d.deleted = 0
                    GROUP BY dc.nro_expediente) sub_d
                    ON d.idderivacion = sub_d.max_idderivacion
                WHERE d.deleted = 0
                ORDER BY dc.nro_expediente DESC";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectTramitesRecibidos($area, $estado, $ubicacion)
    {
        $this->strArea = $area;
        $this->strEstado = $estado;
        $this->intIdUbicacion = $ubicacion;

        $request = $this->consultarVarios(
            "dc.nro_expediente expediente, DATE_FORMAT(d.fechad, '%d/%m/%Y') Fecha,
                tipodoc, dni, CONCAT(p.nombres, ' ', p.ap_paterno, ' ', p.ap_materno) Datos,
                origen, area, estado",
            "derivacion d JOIN documento dc ON d.iddocumento=dc.iddocumento
                JOIN areainstitu a ON d.idareainstitu=a.idareainstitu
                JOIN area ae ON a.idarea=ae.idarea
                JOIN persona p ON dc.idpersona=p.idpersona
                JOIN tipodoc t ON dc.idtipodoc=t.idtipodoc",
            "WHERE area = ? AND estado = ? AND idubicacion = ? ORDER BY idderivacion ASC",
            [$this->strArea, $this->strEstado, $this->intIdUbicacion]
        );
        // $request = $this->strArea . ' ' . $this->strEstado . ' ' . $this->intIdUbicacion;

        return $request;
    }
    public function selectTramitesEnviados($area)
    {
        $this->strArea = $area;

        $request = $this->consultarVarios(
            "idderivacion, dc.nro_expediente expediente, DATE_FORMAT(d.fechad, '%d/%m/%Y') Fecha,
                tipodoc, dni, CONCAT(p.nombres, ' ', p.ap_paterno, ' ', p.ap_materno) Datos,
                origen, area, estado ",
            "derivacion d   
                JOIN documento dc ON d.iddocumento = dc.iddocumento
                JOIN areainstitu a ON d.idareainstitu = a.idareainstitu
                JOIN area ae ON a.idarea = ae.idarea
                JOIN persona p ON dc.idpersona = p.idpersona
                JOIN tipodoc t ON dc.idtipodoc = t.idtipodoc 
                JOIN 
                    (SELECT dc.nro_expediente, MAX(d.idderivacion) max_idderivacion
                    FROM derivacion d
                    JOIN documento dc ON d.iddocumento = dc.iddocumento
                    WHERE d.deleted = 0
                    GROUP BY dc.nro_expediente) sub_d
                    ON d.idderivacion = sub_d.max_idderivacion",
            "WHERE d.deleted = 0 and origen = ?
                ORDER BY dc.nro_expediente DESC",
            [$this->strArea]
        );

        return $request;
    }
    public function selectTramite(string $expediente, string $limit = "LIMIT 1")
    {
        $this->strExpediente = $expediente;
        $sql = "SELECT idderivacion, nro_expediente, dc.iddocumento, nro_doc ,folios, estado, tipodoc, asunto, dni,
                    concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, ruc_institu, institucion, archivo, area,
                    date_format(fechad, '%d/%m/%Y') Fecha, descripcion  
                FROM derivacion d JOIN documento dc ON d.iddocumento=dc.iddocumento
                JOIN areainstitu a ON d.idareainstitu=a.idareainstitu
                JOIN area ae ON a.idarea=ae.idarea
                JOIN persona p ON dc.idpersona=p.idpersona
                JOIN tipodoc t ON dc.idtipodoc=t.idtipodoc
                WHERE nro_expediente = ? AND d.deleted = 0 $limit";
        $request = $this->selectOne($sql, [$this->strExpediente]);
        return $request;
    }
    public function selectHistorial(string $expediente)
    {
        $this->strExpediente = $expediente;
        $request = $this->consultarTabla(
            "accion, DATE_FORMAT(fecha, '%d/%m/%Y %h:%i %p') fecha, area, descrip ",
            "historial",
            "WHERE expediente = ? AND deleted = 0",
            [$this->strExpediente]
        );
        return $request;
    }
    public function selectTipo()
    {
        $sql = "SELECT * FROM tipodoc WHERE deleted = 0";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectAreaDestino($area)
    {
        $this->strArea = $area;

        $request = $this->consultarVarios(
            "ae.idareainstitu ID, cod_area, area",
            "institucion i JOIN areainstitu ae ON ae.idinstitucion = i.idinstitucion JOIN area a ON a.idarea=ae.idarea",
            "WHERE area != ? and ae.deleted = 0",
            [$this->strArea]
        );

        return $request;
    }
    public function genExpediente()
    {
        $sql = "SELECT gen_nroexpediente() Expediente";
        $request = $this->selectOne($sql, []);
        return $request;
    }
    public function registrarDocumento($expediente, $nrodoc, $folios, $asunto, $ruta, $idpersona, $tipo)
    {
        $this->strExpediente = $expediente;
        $this->strNroDoc = $nrodoc;
        $this->intFolios = $folios;
        $this->strAsunto = $asunto;
        $this->strRuta = $ruta;
        $this->intIdPersona = $idpersona;
        $this->intIdTipo = $tipo;

        $where = " WHERE nro_expediente = ? and archivo = ? ";
        $request = $this->consultar(
            "*",
            "documento",
            $where,
            [$this->strExpediente, $this->strRuta]
        );

        if (empty($request)) {
            $arrData = array(
                $this->strExpediente,
                $this->strNroDoc,
                $this->intFolios,
                $this->strAsunto,
                $this->strRuta,
                $this->intIdPersona,
                $this->intIdTipo
            );
            $request_insert = $this->registrar(
                "documento",
                "(null,?,?,?,?,'PENDIENTE',?,?,?,
                (SELECT idareainstitu 
                FROM areainstitu ai JOIN area a ON ai.idarea = a.idarea 
                WHERE area = 'SECRETARIA' OR area = 'SECRETARÍA'), 0)",
                $arrData
            );
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }
    public function editarDocumento($expediente, $estado, $ubicacion = '')
    {
        $this->strExpediente = $expediente;
        $this->strEstado = $estado;
        $this->intIdUbicacion = $ubicacion;

        $paramIdUbi = $this->intIdUbicacion === '' ? '' : ', idubicacion = ?';

        $arrayData = $this->intIdUbicacion === '' ?
            [$this->strEstado, $this->strExpediente] :
            [$this->strEstado,  $this->intIdUbicacion, $this->strExpediente];

        $request = $this->editar(
            "documento",
            "estado = ?" . $paramIdUbi,
            "nro_expediente = ?",
            $arrayData
        );

        $request = $this->strEstado . ' ' . $this->intIdDoc;

        return $request;
    }
    public function registrarHistorial($expediente, $dni, $desc, $accion = 'DERIVADO', $area = 'SECRETARÍA')
    {
        $this->strExpediente = $expediente;
        $this->strDNI = $dni;
        $this->strDescripcion = $desc;
        $this->strAccion = $accion;
        $this->strArea = $area;

        $arrData = array(
            $this->strExpediente,
            $this->strDNI,
            $this->strAccion,
            $this->strArea,
            $this->strDescripcion
        );
        $request_insert = $this->registrar(
            "historial",
            "(null, sysdate(), ?, ?, ?, ?, ?, 0)",
            $arrData
        );
        $return = $request_insert;

        return $return;
    }
    public function registrarDerivacion($idDoc, $expediente = '', $origen = 'EXTERIOR', $iddestino, $descripcion = 'DERIVANDO A SECRETARIA')
    {
        $this->intIdDoc = $idDoc;
        $this->strOrigen = $origen;
        $this->strIdDestino = $iddestino;
        $this->strDescripcion = $descripcion;
        $this->strExpediente = $expediente;

        $iddoc = $this->strExpediente !== '' ? '(SELECT iddocumento FROM documento WHERE nro_expediente = ?)' : '?';

        $arrData = $this->strExpediente !== '' ? array(
            $this->strOrigen,
            $this->strIdDestino,
            $this->strExpediente,
            $this->strDescripcion
        ) : array(
            $this->strOrigen,
            $this->strIdDestino,
            $this->intIdDoc,
            $this->strDescripcion
        );
        $request_insert = $this->registrar(
            "derivacion",
            "(null, sysdate(), ?, ? ,$iddoc, ?, 0)",
            $arrData
        );
        $return = $request_insert;

        return $return;
    }
    public function editarDerivacion($idderivacion, $descripcion)
    {
        $this->intIdDerivacion = $idderivacion;
        $this->strDescripcion = $descripcion;

        $request = $this->editar(
            "derivacion",
            "descripcion = ?",
            "idderivacion = ?",
            [$this->strDescripcion, $this->intIdDerivacion]
        );

        return $request;
    }
}
