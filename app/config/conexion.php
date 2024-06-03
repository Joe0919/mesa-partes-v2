<?php

require_once "config.php";

session_start();
class Conectar
{
  protected $dbh;
  protected function Conexion()
  {
    try {
      $conectar = $this->dbh = new PDO(DB_DRIVER . ":local=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD);
      $this->set_names();
      return $conectar;
    } catch (Exception $e) {
      die("¡Error BD!: " . $e->getMessage() . "<br/>");
    }
  }

  public function set_names()
  {
    return $this->dbh->query("SET NAMES 'utf8'");
  }

  public static function ruta()
  {
    return "http://localhost/MesaPartesVirtual/";
  }
}
