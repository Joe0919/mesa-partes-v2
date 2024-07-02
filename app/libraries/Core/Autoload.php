<?php
spl_autoload_register(function ($class) {
    if (file_exists("app/libraries/" . 'Core/' . $class . ".php")) {
        require_once("app/libraries/" . 'Core/' . $class . ".php");
    }
});
