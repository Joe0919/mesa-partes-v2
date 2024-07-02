<?php

class AreaModel extends Conectar
{


    public function listarAreas(
        string $columnas = "a.idarea ID, cod_area, area, ae.idareainstitu IdAInst",
        string $tablas = "institucion i
        inner join areainstitu ae on ae.idinstitucion=i.idinstitucion
        inner join area a on a.idarea=ae.idarea",
        string $condicion = "",
        array $valores = []
    ) {
        $conectar = parent::conexion();

        $consulta = "SELECT $columnas from $tablas $condicion";
        $consulta = $conectar->prepare($consulta);
        ($condicion != "") ? $consulta->execute($valores) : $consulta->execute();
        $consulta->execute();
        return $consulta->fetchall(pdo::FETCH_ASSOC);
    }

    public function consultarAreaID($id_area)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT a.idarea ID, cod_area, area,  i.idinstitucion
        from institucion i
        inner join areainstitu ae on ae.idinstitucion=i.idinstitucion
        inner join area a on a.idarea=ae.idarea
        where a.idarea=?";
        $consulta = $conectar->prepare($consulta);
        $consulta->bindValue(1, $id_area);
        $consulta->execute();

        return $consulta->fetch(pdo::FETCH_ASSOC);
    }


    public function crearNuevaArea($codigo, $area, $idinst)
    {
        $conectar = parent::conexion();
        // VERFICAR DUPLICIDAD DE CODIGO Y NOMBRE DE AREA
        $consulta = "SELECT count(*) total from area where cod_area=? or area=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $codigo);
        $resultado->bindValue(2, $area);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {
            // INGRESO DEL AREA
            $consulta = "INSERT into area values (null,?,?)";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $codigo);
            $resultado->bindValue(2, $area);
            $resultado->execute();

            // INGRESO DE AREAINSTITUCION
            $consulta = "INSERT into areainstitu values (null,?,(select idarea from area where cod_area=?))";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $idinst);
            $resultado->bindValue(2, $codigo);
            $resultado->execute();

            //CONSULTAR EL ULTIMO REGISTRO INGRESADO
            $consulta = "SELECT a.idarea ID, cod_area, area
            from institucion i
            inner join areainstitu ae on ae.idinstitucion=i.idinstitucion
            inner join area a on a.idarea=ae.idarea
            ORDER BY ID DESC LIMIT 1";
            $resultado = $conectar->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetch(PDO::FETCH_ASSOC);
        } else {
            $data = 1; //SI HAY DUPLICIDAD
        }
        return $data;
    }


    public function editarAreaID($id_area, $codigo, $area)
    {
        $conectar = parent::conexion();

        // VALIDAR DUPLICIDAD DE CODIGO Y NOMBRE DE AREA
        $consulta = "SELECT count(*) total from area where (cod_area=? or area=?) and idarea != ?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $codigo);
        $resultado->bindValue(2, $area);
        $resultado->bindValue(3, $id_area);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {
            $data = '';
            //VALIDAR SI SE MODIFICARON LOS DATOS O SON LOS MISMOS
            $consulta = "SELECT count(*) total from area where (cod_area=? and area=?) and idarea = ?";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $codigo);
            $resultado->bindValue(2, $area);
            $resultado->bindValue(3, $id_area);
            $resultado->execute();
            $data = $resultado->fetch(PDO::FETCH_ASSOC);

            if ($data['total'] == 0) {

                $consulta = "UPDATE area SET cod_area=?, area=? WHERE idarea=?";
                $resultado = $conectar->prepare($consulta);
                $resultado->bindValue(1, $codigo);
                $resultado->bindValue(2, $area);
                $resultado->bindValue(3, $id_area);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $data = 2; //SI NO SE MODIFICO NADA
            }
        } else {
            $data = 1; //SI HAY DUPLICIDAD
        }

        return $data;
    }

    public function eliminarAreaID($id_area)
    {
        $conectar = parent::conexion();

        //VALIDAR SI EXISTEN REGISTROS EN DERIVACION DE ESTA AREA
        $consulta = "SELECT count(*) total from derivacion d
        inner join areainstitu ae on ae.idareainstitu=d.idareainstitu
        inner join area a on a.idarea=ae.idarea
        where a.idarea=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $id_area);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {
            //VALIDAR SI EXISTEN REGISTROS EN EMPLEADOS DE ESTA AREA
            $consulta = "SELECT count(*) total from empleado 
            where idareainstitu=(select idareainstitu from areainstitu where idarea=?);";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $id_area);
            $resultado->execute();
            $data = $resultado->fetch(PDO::FETCH_ASSOC);

            if ($data['total'] == 0) {
                //ELIMINAR AREA EN CASCADA
                $consulta = "DELETE FROM areainstitu WHERE idarea=? ";
                $resultado = $conectar->prepare($consulta);
                $resultado->bindValue(1, $id_area);
                $resultado->execute();

                $consulta = "DELETE FROM area WHERE idarea=?";
                $resultado = $conectar->prepare($consulta);
                $resultado->bindValue(1, $id_area);
                return $resultado->execute();
            } else {
                $data = 2; //SI HAY EMPLEADOS CON ESTA AREA
            }
        } else {
            $data = 1; //SI HAY DOCUMENTOS con esta area        
        }
        return $data;
    }
}
