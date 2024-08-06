<?php

class TramiteModel extends Mysql
{
    private $intIdTramite;
    private $strExpediente;
    private $strFecha;


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

    // public function listarTramites(string $condicion = "", array $valores = [])
    // {
    //     $conectar = parent::conexion();

    //     $consulta = "SELECT nro_expediente expediente,  date_format(fechad, '%d/%m/%Y') Fecha, tipodoc, dni, concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, origen, area, estado
    //     from derivacion d join documento dc on d.iddocumento=dc.iddocumento
    //     join areainstitu a on d.idareainstitu=a.idareainstitu
    //     join area ae on a.idarea=ae.idarea
    //     join persona p on dc.idpersona=p.idpersona 
    //     join tipodoc t on dc.idtipodoc=t.idtipodoc 
    //     $condicion order by fechad desc;";
    //     $resultado = $conectar->prepare($consulta);

    //     // Validamos si hay valores de condicion o no
    //     $condicion == "" ? $resultado->execute() : $resultado->execute($valores);

    //     return $resultado->fetchAll(pdo::FETCH_ASSOC);
    // }

    public function selectTramite(string $expediente, string $limit = "LIMIT 1")
    {
        $this->strExpediente = $expediente;
        $sql = "SELECT idderivacion, nro_expediente,dc.iddocumento, nro_doc,folios, estado, tipodoc, asunto, dni,
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
            "*",
            "historial",
            "WHERE expediente = ? AND deleted = 0",
            [$this->strExpediente]
        );
        return $request;
    }
}
