<?php

const DB_DRIVER = 'mysql';
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'db_hacdp';
const DB_CHARSET = 'utf8';


define('APP', dirname(dirname(__FILE__)));
const URL = 'http://localhost/MesaPartesVirtual';
// Definir BASE_PATH para obtener la ruta base del proyecto
define('BASE_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);

// Definir UPLOADS_PATH para la ruta pública donde se almacenan los archivos subidos
define('UPLOADS_PATH', BASE_PATH . 'public/files/');
