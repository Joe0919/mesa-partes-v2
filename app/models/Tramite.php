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
}
