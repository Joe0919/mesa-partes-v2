<?php

class Conexion
{
  protected $dbh;
  protected function Conectar()
  {
    try {
      $connectionString = DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
      $this->dbh = new PDO($connectionString, DB_USER, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
      ]);
      return $this->dbh;
    } catch (Exception $e) {
      // Manejo de errores mejorado
      error_log("¡Error BD!: " . $e->getMessage()); // Registra el error en el log
      throw new Exception("No se pudo conectar a la base de datos."); // Lanza una excepción
    }
  }
}
