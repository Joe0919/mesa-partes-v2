<?php

class Empleado extends Conectar
{


    function listarEmpleados()
    {

        $conectar = parent::conexion();

        $consulta = "SELECT idempleado ID, cod_empleado Codigo, dni, concat(ap_paterno,' ',ap_materno,' ',nombres) Datos, telefono, area
        from empleado e inner join persona p on e.idpersona=p.idpersona
        inner join areainstitu a on e.idareainstitu=a.idareainstitu
        inner join area ae on ae.idarea=a.idarea";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarUsuariosPendientes()
    {
        $conectar = parent::conexion();

        $consulta = "SELECT u.idusuarios ID,  concat('DNI : ',p.dni,' : ',ap_paterno,' ', ap_materno,' ',nombres) Datos
        from (usuarios u inner join persona p on u.dni=p.dni) left join empleado e on p.idpersona = e.idpersona
        where e.idpersona is null";
        $consulta = $conectar->prepare($consulta);
        $consulta->execute();
        return $consulta->fetchall(pdo::FETCH_ASSOC);
    }


    function consultarEmpleadoDNI($dni)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT e.idempleado ID, p.dni dni, p.nombres, p.ap_paterno ap, p.ap_materno am, 
        p.telefono, p.direccion, e.cod_empleado cod, e.idareainstitu ID2,ar.idarea IDArea, ar.area Area, a.idinstitucion IDInst
        FROM empleado e
        INNER JOIN persona p ON e.idpersona = p.idpersona
        INNER JOIN areainstitu a ON e.idareainstitu = a.idareainstitu
        INNER JOIN area ar ON a.idarea = ar.idarea
        WHERE p.dni = ?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $dni);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    function crearNuevoEmpleado($dni, $codigo, $idpersona, $idareainst)
    {
        $conectar = parent::conexion();

        //VALIDAR SI EXISTE MISMO CODIGO REGISTRADO
        $consulta = "SELECT count(*) total FROM empleado where cod_empleado=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $codigo);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {
            $consulta = "INSERT INTO empleado VALUES(null,?,?,?)";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $codigo);
            $resultado->bindValue(2, $idpersona);
            $resultado->bindValue(3, $idareainst);
            $resultado->execute();

            $consulta = "UPDATE usuarios SET estado='ACTIVO' where dni=?";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $dni);
            $resultado->execute();
            $data = $resultado->fetch(PDO::FETCH_ASSOC);
        } else {
            $data = 1; //EN EL CASO DE QUE EXISTA DUPLICIDAD
        }

        return $data;
    }

    function editarEmpleadoID($id, $codigo, $idareainst)
    {

        $conectar = parent::conexion();

        //CONSULTAMOS SI EXISTE MISMO CODIGO REGISTRADO
        $consulta = "SELECT count(*) total FROM empleado where cod_empleado=? and idempleado != ?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $codigo);
        $resultado->bindValue(2, $id);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {
            //CONSULTAMOS SI SE HICIERON CAMBIOS O NO
            $consulta = "SELECT count(*) total FROM empleado where cod_empleado=? and idareainstitu=? and idempleado = ?";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $codigo);
            $resultado->bindValue(2, $idareainst);
            $resultado->bindValue(3, $id);
            $resultado->execute();
            $data = $resultado->fetch(PDO::FETCH_ASSOC);

            if ($data['total'] == 0) {

                $consulta = "UPDATE empleado SET cod_empleado=?,idareainstitu=? where idempleado = ?";
                $resultado = $conectar->prepare($consulta);
                $resultado->bindValue(1, $codigo);
                $resultado->bindValue(2, $idareainst);
                $resultado->bindValue(3, $id);
                $resultado->execute();
                $data = $resultado->fetch(PDO::FETCH_ASSOC);
            } else {
                $data = 2; //EN EL CASO DE QUE NO SE HAYA REALIZADO CAMBIOS
            }
        } else {
            $data = 1; //EN EL CASO DE EXISTIR DUPLICIDAD
        }
        return $data;
    }

    function eliminarEmpleado($id, $dni)
    {
        $conectar = parent::conexion();

        $consulta = "DELETE FROM empleado WHERE idempleado=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $id);
        $resultado->execute();

        $consulta = "UPDATE usuarios SET estado='INACTIVO' where dni=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $dni);
        return $resultado->execute();
    }
}
