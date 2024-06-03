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
                $sql = "select * from usuarios where dni=? and contraseña=? and estado='ACTIVO'";
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
                    header("Location:" . Conectar::ruta() . "views/Home/");
                    exit();
                } else {
                    header("Location:" . Conectar::ruta()  . "views/Acceso/index.php?m=1");
                    exit();
                }
            }
        }
    }

    public function listarUsuarios()
    {
        $conectar = parent::conexion();

        $consulta = "SELECT idusuarios, nombre, dni, email, estado FROM usuarios";
        $consulta = $conectar->prepare($consulta);
        $consulta->execute();
        return $consulta->fetchall(pdo::FETCH_ASSOC);
    }

    public function consultarUsuarioID($idusu, $dni)
    {
        $conectar = parent::conexion();

        $consulta = "select idusuarios ID1, idpersona ID2, p.dni dni, nombres ,ap_paterno ap, ap_materno am, telefono, direccion, u.email email, nombre,r.idroles IDR, estado,foto
        from persona p, usuarios u, roles r
        where p.dni=u.dni and r.idroles=u.idroles and idusuarios=? and p.dni=?";
        $consulta = $conectar->prepare($consulta);
        $consulta->bindValue(1, $idusu);
        $consulta->bindValue(2, $dni);
        $consulta->execute();

        return $consulta->fetch(pdo::FETCH_ASSOC);
    }

    public function editarusuarioID($idusu, $nom_usu, $idper, $nombre, $appat, $apmat, $email, $celular, $direccion)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT count(*) AS total FROM persona p 
        INNER JOIN usuarios u ON p.dni = u.dni 
        INNER JOIN roles r ON r.idroles = u.idroles
        WHERE (nombre = ? OR u.email = ?) AND idpersona != ?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $nom_usu);
        $resultado->bindValue(2, $email);
        $resultado->bindValue(3, $idper);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {

            $consulta = "UPDATE persona SET  ap_paterno=?, ap_materno=?, nombres=?, email=?, telefono=?, direccion=?
                WHERE idpersona=?";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $appat);
            $resultado->bindValue(2, $apmat);
            $resultado->bindValue(3, $nombre);
            $resultado->bindValue(4, $email);
            $resultado->bindValue(5, $celular);
            $resultado->bindValue(6, $direccion);
            $resultado->bindValue(7, $idper);
            $resultado->execute();

            $consulta = "UPDATE usuarios SET nombre=?, email=?, fechaedicion=sysdate()
                WHERE idusuarios=?";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $nom_usu);
            $resultado->bindValue(2, $email);
            $resultado->bindValue(3, $idusu);
            $resultado->execute();
            return $data = $resultado->fetch(PDO::FETCH_ASSOC);
        } else {
            $data = 1;
        }
    }

    public function editarFotoUsuarioID($idusu, $nueva_ruta)
    {
        $conectar = parent::conexion();

        $consulta = "UPDATE usuarios SET foto=?, fechaedicion=sysdate() where idusuarios=?";
        $consulta = $conectar->prepare($consulta);
        $consulta->bindValue(1, $nueva_ruta);
        $consulta->bindValue(2, $idusu);
        $consulta->execute();

        return $consulta->fetch(pdo::FETCH_ASSOC);
    }

    public function cambioContraUsuarioID($psw_anterior, $psw_nueva, $idusu)
    {
        $conectar = parent::conexion();

        $consulta = "SELECT count(*) total FROM usuarios where contraseña=? and idusuarios=?";
        $resultado = $conectar->prepare($consulta);
        $resultado->bindValue(1, $psw_anterior);
        $resultado->bindValue(2, $idusu);
        $resultado->execute();
        $data = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($data['total'] == 0) {
            $data = 1;
        } else {
            $consulta = "UPDATE usuarios SET contraseña=?, fechaedicion=sysdate() where idusuarios=?";
            $resultado = $conectar->prepare($consulta);
            $resultado->bindValue(1, $psw_nueva);
            $resultado->bindValue(2, $idusu);
            $resultado->execute();
            $data = $resultado->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }
}
