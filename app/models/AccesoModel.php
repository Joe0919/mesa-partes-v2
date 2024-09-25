<?php

class AccesoModel extends Mysql
{

	private $intIdUsuario;
	private $strUsuario;
	private $strPassword;
	private $strToken;

	public function __construct()
	{
		parent::__construct();
	}

	public function loginUser(string $usuario, string $password)
	{
		$this->strUsuario = $usuario;
		$this->strPassword = $password;
		// $sql = "SELECT u.idusuarios, u.contrasena, u.estado
		//     FROM usuarios u 
		//     INNER JOIN persona p ON p.dni = u.dni
		// 	INNER JOIN empleado e ON e.idpersona = p.idpersona
		//     WHERE u.dni = ?";
		$sql = "SELECT u.idusuarios, u.contrasena, u.estado
            FROM usuarios u 
            INNER JOIN persona p ON p.dni = u.dni
            WHERE u.dni = ?";
		$request = $this->selectOne($sql, [$this->strUsuario]);

		if (!empty($request)) {
			$pswGuardado = $request['contrasena'];
			if (password_verify($this->strPassword, $pswGuardado)) {
				return $request;
			} else {
				return 1; //contraseña incorrecta
			}
		} else {
			return $request; //No existe el Usuario
		}
	}

	public function sessionLogin(int $iduser)
	{
		$this->intIdUsuario = $iduser;
		//BUSCAR ROL
		$sql = "SELECT idusuarios, u.dni dni, nombre nomusu, 
				concat(p.nombres,' ', p.ap_paterno,' ', p.ap_materno) datos, foto, 
				u.estado, u.idroles, rol,
				IFNULL(a.idareainstitu, 0) as idareainstitu, 
				IFNULL(area, 'INVITADO') as area, 
				i.razon, i.logo
				FROM usuarios u
				INNER JOIN persona p ON p.dni = u.dni
				LEFT JOIN empleado e ON e.idpersona = p.idpersona 
				LEFT JOIN areainstitu a ON e.idareainstitu = a.idareainstitu
				LEFT JOIN area ar ON a.idarea = ar.idarea
				LEFT JOIN institucion i ON a.idinstitucion = i.idinstitucion OR i.idinstitucion = (
					SELECT idinstitucion FROM institucion LIMIT 1
				)
				INNER JOIN roles r ON r.idroles = u.idroles
				WHERE idusuarios = ?";
		$request = $this->selectOne($sql, [$this->intIdUsuario]);
		$_SESSION['userData'] = $request;
		return $request;
	}

	public function registrarAcceso(int $IdUsuario)
	{

		$this->intIdUsuario = $IdUsuario;

		$request = $this->editar(
			"usuarios",
			"ultacceso = sysdate()",
			"idusuarios = ?",
			[$this->intIdUsuario]
		);

		return $request;
	}
}
