<?php

class Usuario extends Conectar
{

    public function login()
    {
        $conectar = parent::Conexion();

        if (isset($_POST["enviar"])) {

            $usuario = $_POST["usuario"];
            $password = $_POST["password"];

            if (empty($usuario) and empty($password)) {
                header("Location:" . Conectar::ruta() . "views/Acceso/index.php?m=2");
                exit();
            } else {
                $sql = "SELECT idusuarios, nombre, u.dni dni, p.email email, foto
                from usuarios u
                inner join persona p
                on p.dni=u.dni where u.dni=? and contrasena=? and estado='ACTIVO'";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $usuario);
                $sql->bindValue(2, $password);
                $sql->execute();
                $resultado = $sql->fetch();
                if (is_array($resultado) and count($resultado) > 0) {
                    $_SESSION["idusuarios"] = $resultado["idusuarios"];
                    $_SESSION["nombre"] = $resultado["nombre"];
                    $_SESSION["dni"] = $resultado["dni"];
                    $_SESSION["email"] = $resultado["email"];
                    $_SESSION["foto"] = $resultado["foto"];
                    header("Location:" . Conectar::ruta() . "views/inicio/");
                    exit();
                } else {
                    header("Location:" . Conectar::ruta()  . "views/acceso/index.php?m=1");
                    exit();
                }
            }
        }
    }

    public function listarUsuarios()
    {
        $conectar = parent::conexion();

        $consulta = "SELECT idusuarios, nombre, u.dni dni, email, estado FROM usuarios u
        INNER JOIN persona p
        ON p.dni=u.dni";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();
        return $resultado->fetchall(pdo::FETCH_ASSOC);
    }

    public function consultarUsuarioID($idusu, $dni)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT u.idusuarios ID1, p.idpersona ID2, p.dni, p.nombres, p.ap_paterno ap, p.ap_materno am, p.telefono, p.direccion, p.email, nombre, r.idroles IDR, u.estado, u.foto
        FROM usuarios u
        INNER JOIN persona p ON p.dni = u.dni
        INNER JOIN roles r ON r.idroles = u.idroles
        WHERE u.idusuarios = ? AND p.dni = ?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $idusu);
        $resultado->bindValue(2, $dni);
        $resultado->execute();

        return $resultado->fetch(pdo::FETCH_ASSOC);
    }
    public function consultarUsuarioxID($idusu)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT u.idusuarios IDUSU, p.idpersona IDPER, p.dni, p.nombres, p.ap_paterno ap, p.ap_materno am, p.telefono, p.direccion, p.email
        FROM usuarios u
        INNER JOIN persona p ON p.dni = u.dni
        WHERE u.idusuarios = ?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $idusu);
        $resultado->execute();

        return $resultado->fetch(pdo::FETCH_ASSOC);
    }

    public function validarDuplicidadDatosUsuario($dni,  $email, $celular, $nom_usu)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT count(*) total from usuarios u inner join persona p
        on u.dni=p.dni where p.dni=? or nombre=? or p.email=? or telefono=?";
        $resultado = $conectar->prepare($consulta);
        $valores = array($dni, $nom_usu, $email, $celular);
        $resultado->execute($valores);
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {
            $data = 0;
        } else {
            $data = 1;
        }
        return $data;
    }
    public function crearNuevoUsuario($dni,  $appat, $apmat, $nombre, $email, $celular, $direccion, $nom_usu, $psw, $rol)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT count(*) total from usuarios u inner join persona p
        on u.dni=p.dni where p.dni=? or nombre=? or p.email=? or telefono=?";
        $resultado = $conectar->prepare($consulta);
        $valores = array($dni, $nom_usu, $email, $celular);
        $resultado->execute($valores);
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {
            $consulta = "INSERT into persona values (null,?,?,?,?,?,?,?,null,null)";
            $resultado = $conectar->prepare($consulta);
            $valores = array($dni, $appat, $apmat, $nombre, $email, $celular, $direccion);
            $resultado->execute($valores);

            $consulta = "INSERT into usuarios values (null,?,?,?,sysdate(),null,sysdate(),'INACTIVO','files/images/0/persona.png',?)";
            $resultado = $conectar->prepare($consulta);
            $valores = array($nom_usu, $dni, $psw, $rol);
            $resultado->execute($valores);

            $consulta = "SELECT * FROM usuarios ORDER BY idusuarios DESC LIMIT 1";
            $resultado = $conectar->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $data = 1;
        }
        return $data;
    }


    public function editarusuarioID($idusu, $nom_usu, $idper, $nombre, $appat, $apmat, $email, $celular, $direccion, $estado)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT count(*) AS total FROM persona p 
        INNER JOIN usuarios u ON p.dni = u.dni 
        INNER JOIN roles r ON r.idroles = u.idroles
        WHERE (nombre=? or p.email=? or telefono=?) AND idpersona != ?";
        $resultado = $conectar->prepare($consulta);
        $valores = array($nom_usu, $email, $celular, $idper);
        $resultado->execute($valores);
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {

            $consulta = "UPDATE persona SET  ap_paterno=?, ap_materno=?, nombres=?, email=?, telefono=?, direccion=?
                WHERE idpersona=?";
            $resultado = $conectar->prepare($consulta);
            $valores = array($appat, $apmat, $nombre, $email, $celular, $direccion, $idper);
            $resultado->execute($valores);

            $consulta = "UPDATE usuarios SET nombre=?, fechaedicion=sysdate(), estado=?
                WHERE idusuarios=?";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $nom_usu);
            $resultado->bindValue(2, $estado);
            $resultado->bindValue(3, $idusu);
            $resultado->execute();
            $data = $resultado->fetch(PDO::FETCH_ASSOC);
        } else {
            $data = 1;
        }

        return $data;
    }

    public function editarFotoUsuarioID($idusu, $nueva_ruta)
    {
        $conectar = parent::conexion();

        $consulta = "UPDATE usuarios SET foto=?, fechaedicion=sysdate() where idusuarios=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $nueva_ruta);
        $resultado->bindValue(2, $idusu);
        $resultado->execute();

        return $resultado->fetch(pdo::FETCH_ASSOC);
    }

    public function cambioContraUsuarioID($psw_anterior, $psw_nueva, $idusu)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT count(*) total FROM usuarios where contrasena=? and idusuarios=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $psw_anterior);
        $resultado->bindValue(2, $idusu);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {
            $data = 1;
        } else {
            $consulta = "UPDATE usuarios SET contrasena=?, fechaedicion=sysdate() where idusuarios=?";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $psw_nueva);
            $resultado->bindValue(2, $idusu);
            $resultado->execute();
            $data = $resultado->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    public function eliminarUsuarioID($dni)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT count(*) total from empleado where idpersona=(select idpersona from persona where dni='$dni');";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {
            $consulta = "DELETE FROM usuarios WHERE dni='$dni' ";
            $resultado = $conectar->prepare($consulta);
            $resultado->execute();

            $consulta = "DELETE FROM persona WHERE dni='$dni'";
            $resultado = $conectar->prepare($consulta);
            $resultado->execute();
        } else {
            $data = 1;
        }
        return $data;
    }

    public function consultarRoles()
    {
        $conectar = parent::conexion();

        $consulta = "SELECT * FROM roles r";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute();

        return $resultado->fetchAll(pdo::FETCH_ASSOC);
    }

    public function editarUsuario(string $columnas, array $datos, string $condicion)
    {
        $conectar = parent::conexion();

        $consulta = "UPDATE usuarios SET $columnas WHERE $condicion)";
        $resultado = $conectar->prepare($consulta);
        $resultado->execute($datos);

        return $resultado->fetch(pdo::FETCH_ASSOC);
    }
}
