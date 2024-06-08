<?php

class Institucion extends Conectar
{


    public function mostrarDatosInstitucion()
    {
        $conectar = parent::conexion();

        $consulta = "SELECT * FROM institucion LIMIT 1";
        $consulta = $conectar->prepare($consulta);
        $consulta->execute();
        return $consulta->fetchAll(pdo::FETCH_ASSOC);
    }

    public function editarDatosInstitucion($idinstitu, $rucinsti, $razon,$direc)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT count(*) total FROM institucion i where ruc=? and razon=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1,$rucinsti);
        $resultado->bindValue(2,$razon);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {
            $consulta = "UPDATE institucion SET ruc=?, razon=?, dirección=? where idinstitucion=?";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1,$rucinsti);
            $resultado->bindValue(2,$razon);
            $resultado->bindValue(3,$direc);
            $resultado->bindValue(4,$idinstitu);
            $resultado->execute();
            return $data = $resultado->fetch(PDO::FETCH_ASSOC);
        } else {
            $data == 1;
        }
    }
}
