<?php

class TramiteModel extends Mysql
{
    private $intIdDerivacion;
    private $intIdUbicacion;
    private $intFolios;
    private $intIdPersona;
    private $intIdTipo;
    private $intIdUsuario;
    private $strExpediente;
    private $strFecha;
    private $strNroDoc;
    private $strAsunto;
    private $strRuta;
    private $strDNI;
    private $intIdDoc;
    private $strEstado;
    private $strArea;
    private $strOrigen;
    private $strIdDestino;
    private $strDescripcion;
    private $strAccion;


    public function __construct()
    {
        parent::__construct();
    }

    public function selectTramites($IdUbicacion, $area, $estado)
    {
        $this->strArea = $area;
        $this->strEstado = $estado;
        $this->intIdUbicacion = $IdUbicacion;

        $whereArea = "";
        $whereEstado = "";
        $arrValues = [];
        if ($IdUbicacion != '-1') {
            $whereArea = " AND area = ? AND idubicacion = ? ";
            array_push($arrValues, $this->strArea, $this->intIdUbicacion);
        }

        if ($estado != '0') {
            $whereEstado = " AND estado = ? ";
            array_push($arrValues, $this->strEstado);
        }

        $request = $this->consultarVarios(
            "dc.nro_expediente expediente, DATE_FORMAT(dc.fecha_registro, '%d/%m/%Y') Fecha,
                tipodoc, dni, CONCAT(p.nombres, ' ', p.ap_paterno, ' ', p.ap_materno) Datos,
                origen, area, estado ",
            " derivacion d   
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
            "WHERE d.deleted = 0 " . $whereArea . " " . $whereEstado . " ORDER BY dc.nro_expediente DESC",
            $arrValues
        );
        return $request;
    }
    public function selectTramitesRecibidos($area, $estado, $ubicacion)
    {
        $this->strArea = $area;
        $this->strEstado = $estado;
        $this->intIdUbicacion = $ubicacion;

        $request = $this->consultarVarios(
            "dc.nro_expediente expediente, DATE_FORMAT(dc.fecha_registro, '%d/%m/%Y') Fecha,
                tipodoc, dni, CONCAT(p.nombres, ' ', p.ap_paterno, ' ', p.ap_materno) Datos,
                origen, area, estado",
            "derivacion d JOIN documento dc ON d.iddocumento=dc.iddocumento
                JOIN areainstitu a ON d.idareainstitu=a.idareainstitu
                JOIN area ae ON a.idarea=ae.idarea
                JOIN persona p ON dc.idpersona=p.idpersona
                JOIN tipodoc t ON dc.idtipodoc=t.idtipodoc",
            "WHERE d.deleted = 0 AND area = ? AND estado = ? AND idubicacion = ? ORDER BY idderivacion ASC",
            [$this->strArea, $this->strEstado, $this->intIdUbicacion]
        );
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
    public function selectTramitexAnio(string $expediente, string $dni, string $anio)
    {
        $this->strExpediente = $expediente;
        $this->strDNI = $dni;
        $this->strFecha = $anio;

        $sql = "SELECT idderivacion, nro_expediente, dc.iddocumento, nro_doc ,folios, estado, tipodoc, asunto, dni,
                    concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, ruc_institu, institucion, archivo, area,
                    date_format(fechad , '%d/%m/%Y') Fecha, descripcion  
                FROM derivacion d JOIN documento dc ON d.iddocumento=dc.iddocumento
                JOIN areainstitu a ON d.idareainstitu=a.idareainstitu
                JOIN area ae ON a.idarea=ae.idarea
                JOIN persona p ON dc.idpersona=p.idpersona
                JOIN tipodoc t ON dc.idtipodoc=t.idtipodoc
                WHERE nro_expediente = ? AND dni = ? AND YEAR(fechad) = ? AND d.deleted = 0 LIMIT 1";
        $request = $this->selectOne($sql, [$this->strExpediente, $this->strDNI, $this->strFecha]);
        return $request;
    }
    public function selectHistorial(string $expediente, string $dni = '', string $anio = '')
    {
        $this->strExpediente = $expediente;
        $this->strDNI = $dni;
        $this->strFecha = $anio;

        $where = $this->strDNI == '' ? 'WHERE expediente = ? AND deleted = 0' :
            'WHERE expediente = ? AND dni = ? AND YEAR(fecha) = ? AND deleted = 0';

        $arrayValues =  $this->strDNI == '' ? [$this->strExpediente] :
            [$this->strExpediente, $this->strDNI, $this->strFecha];

        $request = $this->consultarTabla(
            "accion, DATE_FORMAT(fecha, '%d/%m/%Y %h:%i %p') fecha, DATE_FORMAT(fecha, '%d/%m/%Y') fecha1,
            DATE_FORMAT(fecha, '%h:%i %p') hora, area, descrip ",
            "historial",
            $where,
            $arrayValues
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
    public function selectAnios(string $column, string $condicion = '', array $arrValues = [])
    {

        $where = $condicion == '' ? '' : "WHERE $condicion";

        $arrayValues = $condicion == '' ? [] : $arrValues;

        $request = $this->consultarTabla(
            "distinct $column dato",
            "derivacion",
            $where,
            $arrayValues
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
                WHERE area = 'SECRETARIA' OR area = 'SECRETARÍA'), 0,sysdate())",
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
    public function registrarHistorial($expediente, $dni, $desc, $idusuario, $accion = 'DERIVADO', $area = 'SECRETARÍA')
    {
        $this->strExpediente = $expediente;
        $this->strDNI = $dni;
        $this->strDescripcion = $desc;
        $this->intIdUsuario = $idusuario;
        $this->strAccion = $accion;
        $this->strArea = $area;

        $sql = "SELECT idusuarios,u.dni , concat(nombres,' ',ap_paterno,' ',ap_materno) datos,
                 rol, IFNULL(area, 'N/A') as area
                FROM usuarios u JOIN persona p ON p.dni=u.dni
                JOIN roles r ON r.idroles=u.idroles
                LEFT JOIN empleado e ON e.idpersona = p.idpersona
                LEFT JOIN areainstitu a ON e.idareainstitu = a.idareainstitu
                LEFT JOIN area ar ON a.idarea = ar.idarea where idusuarios = ?";
        $request = $this->selectOne($sql, [$this->intIdUsuario]);

        $arrData = array(
            $this->strExpediente,
            $this->strDNI,
            $this->strAccion,
            $this->strArea,
            $this->strDescripcion,
            $this->intIdUsuario,
            $request['dni'],
            $request['datos'],
            $request['rol'],
            $request['area'],
        );

        $request_insert = $this->registrar(
            "historial",
            "(null, sysdate(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)",
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
    public function selectCantDocs($idarea = '')
    {
        $this->intIdUbicacion = $idarea;

        $where = $idarea == '' ? '' : "WHERE idubicacion = ?";
        $arrValues = $this->intIdUbicacion == '' ? [] : [$this->intIdUbicacion];

        $request = $this->consultarVarios(
            "SUM(CASE WHEN estado = 'PENDIENTE' THEN 1 ELSE 0 END) AS total_pendiente,
                SUM(CASE WHEN estado = 'ACEPTADO' THEN 1 ELSE 0 END) AS total_aceptado,
                SUM(CASE WHEN estado = 'RECHAZADO' THEN 1 ELSE 0 END) AS total_rechazado,
                SUM(CASE WHEN estado = 'ARCHIVADO' THEN 1 ELSE 0 END) AS total_archivado",
            "documento",
            $where,
            $arrValues
        );

        return $request;
    }
    public function selectRanking()
    {
        $sql = "SELECT ROW_NUMBER() OVER (ORDER BY COUNT(d.idubicacion) DESC) AS fila, a.area, COUNT(d.idubicacion) AS total_documentos
                FROM documento d JOIN areainstitu ae ON ae.idareainstitu = d.idubicacion
                JOIN area a ON ae.idarea = a.idarea
                GROUP BY a.area
                ORDER BY total_documentos DESC";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectDocsxTiempo()
    {
        $sql = "SELECT ROW_NUMBER() OVER (ORDER BY 
                        CASE periodo
                            WHEN 'Hoy' THEN 1
                            WHEN 'Esta semana' THEN 2
                            WHEN 'Este mes' THEN 3
                            WHEN 'Este año' THEN 4
                            WHEN 'Otros' THEN 5
                        END) AS fila,
                    periodo,
                    cantidad
                FROM (SELECT 'Hoy' AS periodo, COUNT(*) AS cantidad
                    FROM documento
                    WHERE DATE(fecha_registro) = CURDATE()
                    UNION ALL
                    SELECT 'Esta semana', COUNT(*)
                    FROM documento
                    WHERE fecha_registro >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    UNION ALL
                    SELECT 'Este mes', COUNT(*)
                    FROM documento
                    WHERE fecha_registro >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                    UNION ALL
                    SELECT 'Este año', COUNT(*)
                    FROM documento
                    WHERE fecha_registro >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                    UNION ALL
                    SELECT 'Otros', COUNT(*)
                    FROM documento
                    WHERE fecha_registro < DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                ) AS resultados
                ORDER BY 
                    CASE periodo
                        WHEN 'Hoy' THEN 1
                        WHEN 'Esta semana' THEN 2
                        WHEN 'Este mes' THEN 3
                        WHEN 'Este año' THEN 4
                        WHEN 'Otros' THEN 5
                    END";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectIngresoDocs()
    {
        $sql = "SELECT * FROM ingreso_docs_fecha i";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectProcesDocs()
    {
        $sql = "SELECT * FROM docs_procesados_fecha d;";
        $request = $this->select_all($sql);
        return $request;
    }
}
