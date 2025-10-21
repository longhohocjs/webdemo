<?php
session_start();
require_once '../config/database.php';

$controller = $_GET['controller'] ?? 'admin';
$action = $_GET['action'] ?? 'dashboard';

$controller = ucfirst(strtolower($controller));
$controllerFile = "controller/{$controller}Controller.php";

if(file_exists($controllerFile)){
    require_once $controllerFile;
    $controllerClass = ucfirst($controller) . 'Controller';
    $obj = new $controllerClass($conn);
    if(method_exists($obj, $action)){
        $obj->$action();
    } else {
        echo "Action không tồn tại!";
    }
} else {
    echo "Controller không tồn tại!";
}
?>