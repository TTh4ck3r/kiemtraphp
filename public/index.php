<?php
// Basic Front Controller
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/config/database.php';
// Autoloading is better, but for simplicity:
require_once BASE_PATH . '/controllers/BaseController.php';
require_once BASE_PATH . '/controllers/AuthController.php';
require_once BASE_PATH . '/controllers/NhanVienController.php';
require_once BASE_PATH . '/controllers/UserController.php'; // <<< INCLUDE UserController

// Routing
$controllerName = isset($_GET['controller']) ? ucfirst(strtolower($_GET['controller'])) . 'Controller' : 'AuthController';
$actionName = isset($_GET['action']) ? strtolower($_GET['action']) : 'login';

// Security checks (basic)
if (!preg_match('/^[a-zA-Z0-9_]+$/', $controllerName) || !preg_match('/^[a-zA-Z0-9_]+$/', $actionName)) {
    die('Invalid controller or action name');
}

$controllerFile = BASE_PATH . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $actionName)) {
            // Pass 'id' parameter if present
            $params = [];
            if(isset($_GET['id'])) {
                $params['id'] = $_GET['id']; // Pass as named param maybe? Or just call_user_func_array expects numeric array
            }
             // Call action. Using call_user_func_array is flexible if actions take parameters
             // For simple GET id, directly calling is fine if the method expects it via $_GET
            // $controller->{$actionName}(); // Simpler if no complex params needed
             call_user_func([$controller, $actionName]); // Works if method uses $_GET['id'] internally

        } else {
            http_response_code(404);
            die("Action '{$actionName}' not found in controller '{$controllerName}'.");
        }
    } else {
        http_response_code(404);
        die("Controller class '{$controllerName}' not found.");
    }
} else {
     // If default controller (AuthController) is requested but file doesn't exist (unlikely here)
     if ($controllerName === 'AuthController' && $actionName === 'login'){
        // Maybe show a more specific setup error
         die("Critical error: AuthController not found.");
     }
    http_response_code(404);
    die("Controller file '{$controllerFile}' not found.");
}
?>