<?php

class Controllers
{

    public $model;
    public $views;
    private $controler;

    public function __construct($controler)
    {
        $this->controler = $controler;

        $this->views = new Views();
        $this->loadModel($this->controler);
    }

    public function loadModel($controler)
    {
        // Obtener el nombre del modelo
        $model = $controler . "Model";
        $routClass = "app/models/" . $model . ".php";

        // Verificar si el archivo del modelo existe
        if (file_exists($routClass)) {
            
            require_once($routClass);

            // Crear una instancia del modelo
            if (class_exists($model)) {
                $this->model = new $model();
            } else {
                throw new Exception("La clase $model no existe.");
            }
        } else {
            throw new Exception("El archivo del modelo $routClass no existe.");
        }
    }
}
