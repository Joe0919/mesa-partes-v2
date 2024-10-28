<?php

class HomeController extends Controllers
{
    private $personaModel;
    public function __construct()
    {
        parent::__construct("Tramite"); //Importante tener Modelo
    }

    // Método para cargar la vista de acceso
    public function index()
    {
        $data = [
            'page_id' => 1,
            'page_tag' => "Inicio",
            'page_title' => "Inicio",
        ];
        $this->views->getView("Home", "home", $data);
    }
}
