<?php

class DocumentoModel extends Conectar
{

    function consultarDocsxEstado()
    {

        $conectar = parent::conexion();

        $consulta = "SELECT 
        COUNT(CASE WHEN estado = 'RECHAZADO' THEN 1 END) AS cantidad_rechazado,
        COUNT(CASE WHEN estado = 'PENDIENTE' THEN 1 END) AS cantidad_pendiente,
        COUNT(CASE WHEN estado = 'ACEPTADO' THEN 1 END) AS cantidad_aceptado
      FROM documento;";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    function consultarDocsxEstadoxArea($idubicacion)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT
        COUNT(CASE WHEN estado = 'RECHAZADO' THEN 1 END) AS cantidad_rechazado_area,
        COUNT(CASE WHEN estado = 'PENDIENTE' THEN 1 END) AS cantidad_pendiente_area,
        COUNT(CASE WHEN estado = 'ACEPTADO' THEN 1 END) AS cantidad_aceptado_area
            FROM documento where idubi=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $idubicacion);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }
}
