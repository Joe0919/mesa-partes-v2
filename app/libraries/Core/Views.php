<?php

class Views
{
    function getView($controller, $view, $data = "")
    {

        if ($controller == "Home") {
            $view = "Views/" . $view . ".php";
        } else {
            $view = "Views/" . $controller . "/" . $view . ".php";
        }
        require_once($view);
    }
}
