<?php
$controller = $controller . "Controller";
$controllerFile = "app/controllers/" . $controller . ".php";
if (file_exists($controllerFile)) {
    require_once($controllerFile);
    $controller = new $controller();
    if (method_exists($controller, $method)) {
        $controller->{$method}($params);
    } else {
        // require_once("Controllers/Error.php");
        print_r("No existe el método => " . $method . " en el controlador => " . var_dump($controller));
    }
} else {
    // require_once("Controllers/Error.php");
    print_r("No existe el controlador => " . $controller);
}
