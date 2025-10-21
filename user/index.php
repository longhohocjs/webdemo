<?php
session_start();

// Lấy controller và action từ URL
$controller = $_GET['controller'] ?? 'user';  // controller mặc định
$action     = $_GET['action'] ?? 'index';     // action mặc định

// Tên class và file controller
$controllerClass = ucfirst(strtolower($controller)) . 'Controller';
$controllerFile  = __DIR__ . "/controller/" . ucfirst(strtolower($controller)) . "Controller.php";

// Kiểm tra file controller tồn tại
if (!file_exists($controllerFile)) {
    die("Controller không tồn tại!");
}

// Require file và tạo đối tượng
require_once $controllerFile;

if (!class_exists($controllerClass)) {
    die("Class controller $controllerClass không tồn tại!");
}

$ctrl = new $controllerClass();

// Kiểm tra method/action tồn tại
if (!method_exists($ctrl, $action)) {
    die("Action '$action' không tồn tại trong controller '$controllerClass'!");
}

// Gọi action
$ctrl->$action();