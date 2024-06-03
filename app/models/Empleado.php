<?php

class Empleado extends Conectar
{


    function consultarEmpleadoDNI($dni)
    {
        $conectar = parent::conexion();

        $consulta = "select e.idempleado ID, p.dni dni, p.nombres, p.ap_paterno ap, p.ap_materno am, 
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
}
