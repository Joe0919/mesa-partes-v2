<?php

class Tramite extends Conectar
{


    public function listarTramites()
    {
        $conectar = parent::conexion();

        $consulta = "SELECT nro_expediente expediente,  date_format(fechad, '%d/%m/%Y') Fecha, tipodoc, dni, concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, origen, area, estado
        from derivacion d inner join documento dc on d.iddocumento=dc.iddocumento
        inner join areainstitu a on d.idareainstitu=a.idareainstitu
        inner join area ae on a.idarea=ae.idarea
        inner join persona p on dc.idpersona=p.idpersona
        inner join tipodoc t on dc.idtipodoc=t.idtipodoc order by fechad desc;";
        $consulta = $conectar->prepare($consulta);
        $consulta->execute();
        return $consulta->fetchAll(pdo::FETCH_ASSOC);
    }

    public function consultarTramitexExpediente($expediente)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT idderivacion ID, nro_expediente,dc.iddocumento doc, nro_doc,folios, estado, tipodoc, asunto, dni, concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, ruc_institu, institucion, archivo, area
        from derivacion d inner join documento dc on d.iddocumento=dc.iddocumento
        inner join areainstitu a on d.idareainstitu=a.idareainstitu
        inner join area ae on a.idarea=ae.idarea
        inner join persona p on dc.idpersona=p.idpersona
        inner join tipodoc t on dc.idtipodoc=t.idtipodoc
        where nro_expediente=?";
        $consulta = $conectar->prepare($consulta);
        $consulta->bindValue(1, $expediente);
        $consulta->execute();
        return $consulta->fetchAll(pdo::FETCH_ASSOC);
    }
}
