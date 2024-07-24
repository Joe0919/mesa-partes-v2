<?php

class Mysql extends Conexion
{
    private $conexion;
    private $strquery;
    private $arrValues;

    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->Conectar();
    }

    //Insertar un registro
    public function insert(string $query, array $arrValues)
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;
        $insert = $this->conexion->prepare($this->strquery);
        $resInsert = $insert->execute($this->arrValues);
        if ($resInsert) {
            $lastInsert = $this->conexion->lastInsertId();
        } else {
            $lastInsert = 0;
        }
        return $lastInsert;
    }
    //Busca un registro
    public function selectOne(string $query, array $arrValues)
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute($this->arrValues);
        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    //Devuelve todos los registros
    public function select_all(string $query)
    {
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        return $data;
    }
    //Consultar registro por ID o cualquier otra condicion
    public function consultar(string $columnas = "*", string $tabla, string $condicion = "", array $arrValues = [])
    {
        $this->strquery = "SELECT $columnas FROM $tabla $condicion";
        $result = $this->conexion->prepare($this->strquery);
        $condicion == "" ? $result->execute() : $result->execute($arrValues);
        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    //Actualiza registros
    public function update(string $query, array $arrValues)
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;
        $update = $this->conexion->prepare($this->strquery);
        $resExecute = $update->execute($this->arrValues);
        return $resExecute;
    }
    //Eliminar un registros
    public function delete(string $query)
    {
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $del = $result->execute();
        return $del;
    }

    public function consultarTabla(string $columnas = "*", string $tabla, string $condicion = "", array $arrDatos = [])
    {

        $this->strquery = "SELECT $columnas FROM $tabla $condicion";
        $this->arrValues = $arrDatos;
        $result = $this->conexion->prepare($this->strquery);
        $condicion == "" ? $result->execute() : $result->execute($this->arrValues);
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        return $data;
    }
    public function registrar(string $tabla, string $marcadores, array $arrDatos)
    {
        $this->strquery = "INSERT INTO $tabla VALUES $marcadores";
        $this->arrValues = $arrDatos;
        $insert = $this->conexion->prepare($this->strquery);
        $resInsert = $insert->execute($this->arrValues);
        if ($resInsert) {
            $lastInsert = $this->conexion->lastInsertId();
        } else {
            $lastInsert = 0;
        }
        return $lastInsert;
    }

    public function editar(string $tabla, string $marcadores, string $condicion, array $arrDatos)
    {

        $this->strquery = "UPDATE $tabla SET $marcadores WHERE $condicion";
        $this->arrValues = $arrDatos;
        $update = $this->conexion->prepare($this->strquery);
        $resExecute = $update->execute($this->arrValues);
        if ($resExecute) {;
            $lastInsert = 1;
        }
        return $lastInsert;
    }
}
