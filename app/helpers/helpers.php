<?php

//Retorna la url del proyecto
function base_url()
{
    return URL;
}
//Retorna la url de public
function media()
{
    return URL . "/public";
}
//Agrega el header general para todas las paginas
function headerAdmin($data = "")
{
    $view_header = "";
    require_once($view_header);
}
//Agrega el footer general para todas las paginas
function footerAdmin($data = "")
{
    $view_footer = "";
    require_once($view_footer);
}

//Muestra información formateada
function debug($data)
{
    $format  = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}

function sessionUser(int $IdUser)
{
    require_once("app/models/AccesoModel.php");
    $objLogin = new AccesoModel();
    $request = $objLogin->sessionLogin($IdUser);
    return $request;
}
