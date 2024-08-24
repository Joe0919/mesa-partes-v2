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
		$sql = "SELECT idusuarios,  u.estado
                from usuarios u 
                inner join persona p on p.dni=u.dni 
                where u.dni=? and contrasena=? and u.estado='ACTIVO'";
		$request = $this->selectOne($sql, [$this->strUsuario, $this->strPassword]);

		return $request;
	}

	public function sessionLogin(int $iduser)
	{
		$this->intIdUsuario = $iduser;
		//BUSCAR ROLE 
		$sql = "SELECT idusuarios, u.dni dni, nombre nomusu, 
				concat(p.nombres,' ', p.ap_paterno,' ', p.ap_materno) datos, foto, 
						u.estado,a.idareainstitu, area, razon, logo, u.idroles, rol
				FROM usuarios u 
				INNER JOIN persona p ON p.dni=u.dni 
				INNER JOIN empleado e ON e.idpersona=p.idpersona 
				INNER JOIN areainstitu a ON e.idareainstitu = a.idareainstitu 
				INNER JOIN area ar ON a.idarea = ar.idarea 
				INNER JOIN institucion i ON a.idinstitucion=i.idinstitucion 
				INNER JOIN roles r ON r.idroles = u.idroles 
				WHERE idusuarios = ?";
		$request = $this->selectOne($sql, [$this->intIdUsuario]);
		$_SESSION['userData'] = $request;
		return $request;
	}
}
