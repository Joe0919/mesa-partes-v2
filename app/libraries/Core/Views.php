<?php

class Views
{
    function getView($controller, $view, $data = "")
    {

        if ($controller == "Home") {
            $view = "views/" . $view . ".php";
        } else {
            $view = "views/" . $controller . "/" . $view . ".php";
        }
        require_once($view);
    }
}
