<?php

class PersonaModel extends Conectar
{

    public function consultarPersonaDNI($dni)
    {

        $conectar = parent::conexion();
        $consulta = "SELECT * FROM persona where dni=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $dni);
        $resultado->execute();

        return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    public function verificarPersonaDNI($dni)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT count(*) total  FROM persona where dni=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $dni);
        $resultado->execute();

        $data = $resultado->fetch(pdo::FETCH_ASSOC);

        return $data['total'];
    }

    public function crearNuevaPersona($dni, $appat, $apmat, $nombres, $correo, $cel, $direc, $ruc, $entidad)
    {

        $conectar = parent::conexion();

        $consulta = "INSERT into persona values (null,?,?,?,?,?,?,?,?,?);";
        $resultado = $conectar->prepare($consulta);
        $valores = array($dni, $appat, $apmat, $nombres, $correo, $cel, $direc, $ruc, $entidad);
        $resultado->execute($valores);

        $idPersona = $conectar->lastInsertId();

        return $idPersona;
    }

    public function editarPersona($correo, $cel, $direc, $idpersona)
    {

        $conectar = parent::conexion();

        $consulta = "UPDATE persona SET email=?,telefono=?,direccion=? where idpersona=?";
        $resultado = $conectar->prepare($consulta);
        $valores = array($correo, $cel, $direc, $idpersona);
        $resultado->execute($valores);

        return $idpersona;
    }
}
