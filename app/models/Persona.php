<?php

class Persona extends Conectar
{

    public function consultarPersonaDNI($dni)
    {
        try {
            $conectar = parent::conexion();
            $consulta = "SELECT * FROM persona where dni=?";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $dni);
            $resultado->execute();

            return $resultado->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejo de la excepción PDOException
            die("¡Error en la consulta!: " . $e->getMessage() . "<br/>");
            // Otra lógica de manejo de errores si es necesario
        }
    }

    public function verificarPersonaDNI($dni)
    {

        try {
            $conectar = parent::conexion();

            $consulta = "SELECT count(*) total  FROM persona where dni=?";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $dni);
            $resultado->execute();

            $data = $resultado->fetch(pdo::FETCH_ASSOC);

            return $data['total'];
        } catch (PDOException $e) {
            // Manejo de la excepción PDOException
            die("¡Error en la consulta!: " . $e->getMessage() . "<br/>");
            // Otra lógica de manejo de errores si es necesario
        }
    }

    public function crearNuevaPersona($dni, $appat, $apmat, $nombres, $correo, $cel, $direc, $ruc, $entidad)
    {

        try {
            $conectar = parent::conexion();

            $consulta = "INSERT into persona values (null,?,?,?,?,?,?,?,?,?);";
            $resultado = $conectar->prepare($consulta);
            $valores = array($dni, $appat, $apmat, $nombres, $correo, $cel, $direc, $ruc, $entidad);
            $resultado->execute($valores);

            return $resultado->fetch(pdo::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejo de la excepción PDOException
            die("¡Error en la consulta!: " . $e->getMessage() . "<br/>");
            // Otra lógica de manejo de errores si es necesario
        }
    }

    public function editarDato(string $columnas, array $datos)
    {
        try {
            $stm = $this->pdo->prepare("UPDATE $this->tabla SET $columnas WHERE id$this->tabla = ?");
            $stm->execute($datos);

            return "Dato editado";
        } catch (PDOException $e) {
            die("¡Error BD!: " . $e->getMessage() . "<br/>");
        }
    }
}
