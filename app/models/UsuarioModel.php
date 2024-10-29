<?php

class UsuarioModel extends Mysql
{
    private $intIdUsuario;
    private $intIdPersona;
    private $strDNI;
    private $strApPaterno;
    private $strApMaterno;
    private $strNombre;
    private $strEmail;
    private $intTelefono;
    private $strDireccion;
    private $strNombreUsuario;
    private $strOldPassword;
    private $strPassword;
    private $strToken;
    private $intIdRol;
    private $strFoto;
    private $strEstado;


    public function selectUsuario()
    {
        $whereAdmin = "";
        if ($_SESSION['userData']['idroles'] != 1) {
            $whereAdmin = " and u.idroles != 1 ";
        }
        $sql = "SELECT idusuarios, concat(p.nombres,' ',p.ap_paterno) datos, u.dni dni, email,telefono, u.idroles, rol, u.estado
        FROM usuarios u join persona p on p.dni=u.dni join roles r on r.idroles=u.idroles 
        WHERE u.deleted = 0" . $whereAdmin;
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectReportUsuarios(
        string $columnas = "ROW_NUMBER() OVER (ORDER BY idusuarios) N°,p.dni DNI,
         concat(ap_paterno,' ',ap_materno,' ', nombres) 'APELLIDOS Y NOMBRES', p.email EMAIL, telefono TELEFONO,
         rol ROL, u.estado",
        string $tablas = "usuarios u JOIN persona p on p.dni=u.dni JOIN roles r on r.idroles=u.idroles",
        string $condicion = "where u.deleted = 0 ",
    ) {
        $whereAdmin = "";
        // if ($_SESSION['idUsuario'] != 1) {
        //     $whereAdmin = " and u.idroles != 1 ";
        // }
        $sql = "SELECT $columnas FROM $tablas $condicion " . $whereAdmin;
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertUsuario($dni,  $appat, $apmat, $nombre, $email, $celular, $direccion, $nom_usu, $psw, $rol, $Foto)
    {
        $this->strDNI = $dni;
        $this->strApPaterno = $appat;
        $this->strApMaterno = $apmat;
        $this->strNombre = $nombre;
        $this->strEmail = $email;
        $this->intTelefono = $celular;
        $this->strDireccion = $direccion;
        $this->strNombreUsuario = $nom_usu;
        $this->strPassword = password_hash($psw, PASSWORD_BCRYPT);
        $this->strFoto = $Foto;
        $this->intIdRol = $rol;

        $where = " WHERE p.dni=? or nombre=? or p.email=? or telefono=? ";
        $request = $this->consultar(
            "*",
            "usuarios u join persona p on u.dni=p.dni",
            $where,
            [$this->strDNI, $this->strNombreUsuario, $this->strEmail, $this->intTelefono]
        );

        if (empty($request)) {
            $arrData = array($this->strDNI, $this->strApPaterno, $this->strApMaterno, $this->strNombre, $this->strEmail, $this->intTelefono, $this->strDireccion);
            $request_insert = $this->registrar("persona", "(null,?,?,?,?,?,?,?,null,null,0)", $arrData);

            $arrData = array($this->strNombreUsuario, $this->strDNI, $this->strPassword, $this->strFoto, $this->intIdRol);
            $request_insert = $this->registrar("usuarios", " (null,?,?,?,sysdate(),null,sysdate(),'INACTIVO',?,?,0)", $arrData);

            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function consultarUsuario($IdUsuario, $dni = '')
    {
        $this->intIdUsuario = $IdUsuario;
        $queryParams = [$this->intIdUsuario];

        if ($dni !== '') {
            $this->strDNI = $dni;
            $whereClause = " WHERE u.idusuarios = ? AND p.dni = ?";
            array_unshift($queryParams, $this->strDNI);
        } else {
            $whereClause = " WHERE u.idusuarios = ? ";
        }

        $request = $this->consultar(
            "u.idusuarios, p.idpersona, p.dni, p.nombres, p.ap_paterno ap, p.ap_materno am, p.telefono, p.direccion, p.email, nombre, r.idroles,r.rol, u.estado, u.foto",
            "usuarios u JOIN persona p ON p.dni = u.dni JOIN roles r ON r.idroles = u.idroles",
            $whereClause,
            $queryParams
        );
        return $request;
    }

    public function validarDuplicidadDatosUsuario($dni,  $email, $celular, $nom_usu)
    {
        $this->strDNI = $dni;
        $this->strEmail = $email;
        $this->intTelefono = $celular;
        $this->strNombreUsuario = $nom_usu;
        $where = " where p.dni=? or nombre=? or p.email=? or telefono=?";
        $request = $this->consultar(
            "*",
            "usuarios u join persona p on u.dni=p.dni",
            $where,
            [$this->strDNI, $this->strEmail, $this->intTelefono, $this->strNombreUsuario]
        );
        if (empty($request)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function editarPerfil($idusu, $nom_usu, $idper, $nombre, $appat, $apmat, $email, $celular, $direccion, $foto = "")
    {
        $this->intIdUsuario = $idusu;
        $this->strNombreUsuario = $nom_usu;
        $this->intIdPersona = $idper;
        $this->strNombre = $nombre;
        $this->strApPaterno = $appat;
        $this->strApMaterno = $apmat;
        $this->strEmail = $email;
        $this->intTelefono = $celular;
        $this->strDireccion = $direccion;
        $this->strFoto = $foto;

        $where = " WHERE (nombre=? or p.email=? or telefono=?) AND idusuarios != ? ";
        $request = $this->consultar(
            "*",
            "persona p JOIN usuarios u ON p.dni = u.dni JOIN roles r ON r.idroles = u.idroles",
            $where,
            [$this->strNombreUsuario, $this->strEmail, $this->intTelefono, $this->intIdUsuario]
        );

        if (empty($request)) {

            $request = $this->editar(
                "persona",
                "ap_paterno = ?, ap_materno = ?, nombres = ?, email = ?, telefono = ?, direccion = ?",
                "idpersona = ?",
                [$this->strApPaterno, $this->strApMaterno, $this->strNombre, $this->strEmail, $this->intTelefono, $this->strDireccion, $this->intIdPersona]
            );
            if ($foto == "") {
                $columns = "nombre = ?, fechaedicion = sysdate()";
                $arrayData =  [$this->strNombreUsuario, $this->intIdUsuario];
            } else {
                $columns = "nombre = ?, fechaedicion = sysdate(), foto = ?";
                $arrayData = [$this->strNombreUsuario,  $this->strFoto, $this->intIdUsuario];
            }
            $request = $this->editar(
                "usuarios",
                $columns,
                "idusuarios = ?",
                $arrayData
            );
        } else {
            $request = 'exist';
        }
        return $request;
    }
    public function editarUsuario($idusu, $nom_usu, $idper, $nombre, $appat, $apmat, $email, $celular, $direccion, $estado, $Idrol, $foto = "")
    {
        $this->intIdUsuario = $idusu;
        $this->strNombreUsuario = $nom_usu;
        $this->intIdPersona = $idper;
        $this->strNombre = $nombre;
        $this->strApPaterno = $appat;
        $this->strApMaterno = $apmat;
        $this->strEmail = $email;
        $this->intTelefono = $celular;
        $this->strDireccion = $direccion;
        $this->strEstado = $estado;
        $this->intIdRol = $Idrol;
        $this->strFoto = $foto;

        $opcion = 1;
        $columns = '';

        $where = " WHERE (nombre=? or p.email=? or telefono=?) AND idusuarios != ? ";
        $request = $this->consultar(
            "*",
            "persona p JOIN usuarios u ON p.dni = u.dni JOIN roles r ON r.idroles = u.idroles",
            $where,
            [$this->strNombreUsuario, $this->strEmail, $this->intTelefono, $this->intIdUsuario]
        );

        if (empty($request)) {

            $request = $this->editar(
                "persona",
                "ap_paterno = ?, ap_materno = ?, nombres = ?, email = ?, telefono = ?, direccion = ?",
                "idpersona = ?",
                [$this->strApPaterno, $this->strApMaterno, $this->strNombre, $this->strEmail, $this->intTelefono, $this->strDireccion, $this->intIdPersona]
            );

            $columns = "nombre = ?, fechaedicion = sysdate(), estado = ?";
            $arrayData =  [$this->strNombreUsuario, $this->strEstado];

            $where = " WHERE idusuarios = ? ";
            $request = $this->consultar(
                " idroles IDROL ",
                "usuarios",
                $where,
                [$this->intIdUsuario]
            );

            if ($request['IDROL'] == 1) {

                $where = " WHERE idroles = 1 and deleted = 0";
                $request = $this->consultar(
                    " count(*) num_admins ",
                    "usuarios",
                    $where
                );

                if ($request['num_admins'] >= 2) {
                    $columns .= ", idroles = ?";
                    $arrayData[] =   $this->intIdRol;
                } else {
                    $opcion = 2;
                }
            } else {
                $columns .= ", idroles = ?";
                $arrayData[] =   $this->intIdRol;
            }

            if ($foto != "") {
                $columns .= ", foto = ?";
                $arrayData[] =  $this->strFoto;
            }

            $arrayData[] =  $this->intIdUsuario;

            $request = $arrayData;

            $request = $this->editar(
                "usuarios",
                $columns,
                "idusuarios = ?",
                $arrayData
            );

            $opcion == 2 ? $request = 'admin' :  $request = $request;
        } else {
            $request = 'exist';
        }
        return $request;
    }
    public function editarPswUsuario($psw_anterior, $psw_nueva, $idusu)
    {
        $this->intIdUsuario = $idusu;
        $this->strOldPassword = $psw_anterior;
        $this->strPassword = password_hash($psw_nueva, PASSWORD_BCRYPT);

        $where = " WHERE idusuarios = ? ";
        $request = $this->consultar(
            "*",
            "usuarios",
            $where,
            [$this->intIdUsuario]
        );

        if (!empty($request)) {
            $pswGuardado = $request['contrasena'];
            if (password_verify($this->strOldPassword, $pswGuardado)) {
                $request = $this->editar(
                    "usuarios",
                    "contrasena = ? , fechaedicion = sysdate()",
                    "idusuarios = ?",
                    [$this->strPassword, $this->intIdUsuario]
                );
            } else {
                $request = 0;
            }
        } else {
            $request = 'no hay';
        }
        return $request;
    }
    public function eliminarUsuario($dni)
    {
        $this->strDNI = $dni;

        $where = " where idpersona=(select idpersona from persona where dni = ?) ";
        $request = $this->consultar("*", "empleado", $where, [$this->strDNI]);

        if (empty($request)) {
            $request = $this->editar(
                "usuarios",
                " deleted = 1, estado = 'INACTIVO' ",
                " dni = ? ",
                [$this->strDNI]
            );
            if ($request) {
                $request = 1;
            } else {
                $request = 'error';
            }
        } else {
            $request = 'exist';
        }
        return $request;
    }
}
