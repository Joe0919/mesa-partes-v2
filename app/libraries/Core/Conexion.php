<?php

class Conexion
{
  protected $dbh;
  protected function Conectar()
  {
    try {
      $connectionString = DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
      $requestCnx = $this->dbh = new PDO($connectionString, DB_USER, DB_PASSWORD);
      return $requestCnx;
    } catch (Exception $e) {
      die("¡Error BD!: " . $e->getMessage() . "<br/>");
    }
  }
}
