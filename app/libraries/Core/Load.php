<?php
$controller = $controller . "Controller";
$controllerFile = "app/controllers/" . $controller . ".php";

if (file_exists($controllerFile)) {
    require_once($controllerFile);
    $controllerInstance = new $controller();

    if (method_exists($controllerInstance, $method)) {
        // Si los parámetros son un array, usa call_user_func_array para pasarlos al método
        if (is_array($params)) {
            call_user_func_array([$controllerInstance, $method], $params);
        } else {
            // Si no hay parámetros, llama al método sin parámetros
            $controllerInstance->{$method}();
        }
    } else {
        // Manejo de error si el método no existe
        // echo "No existe el método '{$method}' en el controlador '{$controller}'.";
        require_once "app/controllers/ErrorController.php";
    }
} else {
    // Manejo de error si el controlador no existe
    // echo "No existe el controlador '{$controller}'.";
    require_once "app/controllers/ErrorController.php";
}
