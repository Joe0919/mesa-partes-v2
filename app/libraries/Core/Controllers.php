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
    public function loadAdditionalModel($modelName)
    {
        $modelFile = "app/models/" . $modelName . "Model.php";
        $modelClass = $modelName . "Model";

        if (file_exists($modelFile)) {
            require_once($modelFile);

            if (class_exists($modelClass)) {
                return new $modelClass();
            } else {
                throw new Exception("La clase $modelClass no existe.");
            }
        } else {
            throw new Exception("El archivo del modelo $modelFile no existe.");
        }
    }

    public function getFechaBadge($fecha)
    {
        $fechaColors = [
            0 => ['class' => 'badge-danger font-p'],
            1 => ['class' => 'badge-warning font-p'],
            2 => ['class' => 'badge-info font-p'],
            3 => ['class' => 'badge-success font-p'],
            4 => ['class' => 'badge-secondary font-p'],
            5 => ['class' => 'bg-purple font-p'],
            6 => ['class' => 'bg-dark font-p'],
            'default' => ['class' => 'badge-light font-p']
        ];

        $fechaRegistro = DateTime::createFromFormat('d/m/Y', $fecha);
        $fechaActual = new DateTime();
        $diferenciaDias = $fechaActual->diff($fechaRegistro)->days;

        if ($diferenciaDias <= 1 ) {
            return '<span class="badge ' . $fechaColors[0]['class'] . '">' . $fecha . '</span>';
        } elseif ($diferenciaDias > 1 && $diferenciaDias <= 4) {
            return '<span class="badge ' . $fechaColors[1]['class'] . '">' . $fecha . '</span>';
        } elseif ($diferenciaDias > 4 && $diferenciaDias <= 7) {
            return '<span class="badge ' . $fechaColors[2]['class'] . '">' . $fecha . '</span>';
        } elseif ($diferenciaDias > 7 && $diferenciaDias <= 30) {
            return '<span class="badge ' . $fechaColors[3]['class'] . '">' . $fecha . '</span>';
        } elseif ($diferenciaDias > 30 && $diferenciaDias <= 180) {
            return '<span class="badge ' . $fechaColors[4]['class'] . '">' . $fecha . '</span>';
        } elseif ($diferenciaDias > 180 && $diferenciaDias <= 365) {
            return '<span class="badge ' . $fechaColors[5]['class'] . '">' . $fecha . '</span>';
        } elseif ($diferenciaDias > 365) {
            return '<span class="badge ' . $fechaColors[6]['class'] . '">' . $fecha . '</span>';
        }
    }
}
