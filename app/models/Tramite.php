<?php

class Tramite extends Conectar
{


    public function listarTramites(string $condicion = "", array $valores = [])
    {
        $conectar = parent::conexion();

        $consulta = "SELECT nro_expediente expediente,  date_format(fechad, '%d/%m/%Y') Fecha, tipodoc, dni, concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, origen, area, estado
        from derivacion d inner join documento dc on d.iddocumento=dc.iddocumento
        inner join areainstitu a on d.idareainstitu=a.idareainstitu
        inner join area ae on a.idarea=ae.idarea
        inner join persona p on dc.idpersona=p.idpersona 
        inner join tipodoc t on dc.idtipodoc=t.idtipodoc 
        $condicion order by fechad desc;";
        $resultado = $conectar->prepare($consulta);

        // Validamos si hay valores de condicion o no
        $condicion == "" ? $resultado->execute() : $resultado->execute($valores);

        return $resultado->fetchAll(pdo::FETCH_ASSOC);
    }

    public function consultarTramitexExpediente(array $valores, string $condicion)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT idderivacion ID, nro_expediente,dc.iddocumento doc, nro_doc,folios, estado, tipodoc, asunto, dni,
         concat(nombres,' ',ap_paterno,' ',ap_materno) Datos, ruc_institu, institucion, archivo, area, date_format(fechad, '%d/%m/%Y') Fecha
        from derivacion d inner join documento dc on d.iddocumento=dc.iddocumento
        inner join areainstitu a on d.idareainstitu=a.idareainstitu
        inner join area ae on a.idarea=ae.idarea
        inner join persona p on dc.idpersona=p.idpersona
        inner join tipodoc t on dc.idtipodoc=t.idtipodoc
        where $condicion";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute($valores);
        return $resultado->fetchAll(pdo::FETCH_ASSOC);
    }

    public function consultarTipoDocs()
    {
        $conectar = parent::conexion();

        $consulta = "SELECT * FROM tipodoc";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(pdo::FETCH_ASSOC);
    }

    public function generarNroExpediente()
    {
        $conectar = parent::conexion();

        $consulta = "SELECT gen_nroexpediente() expediente";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        return $data['expediente'];
    }

    public function registrarDatos(string $tabla, string $marcadores, array $datos)
    {
        $conectar = parent::conexion();

        $consulta = "INSERT into $tabla values ($marcadores)";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute($datos);

        $id = $conectar->lastInsertId();

        return $id;
    }
}
