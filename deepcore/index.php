<?php
$rootDIR =  dirname(__DIR__) . "/";
require_once($rootDIR . "routes.php");
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);
$routing = htmlspecialchars($data["routing"],  ENT_QUOTES, 'UTF-8');
$version = htmlspecialchars($data["version"],  ENT_QUOTES, 'UTF-8');

if (array_key_exists($routing, $allowedRoutes)) {
    $route = $rootDIR . "/" . $allowedRoutes[$routing] . "/";
} else {
    header("Content-Type: application/json");
    http_response_code(405);
    echo "ERROR -> No Available Route Found -> " . $routing;
    exit();
}
require_once($rootDIR . "deepstore/meekro.php");
if (!empty($data['help'])) {
    $helpPath = $route . "help.php";
    require_once($helpPath);
    exit();
}
if (!empty($data["routing"]) && !empty($data["version"])) {
    $servicePath = $route . "/"
        . $version . "/"
        . strtolower($method) . ".php";
} else {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray[0]['Error'] = 'No Route and / or Version given';
    echo json_encode($errorArray);
    exit();
}
require_once($rootDIR . "/deepcore/api.php");
switch ($method) {
    case "PUT":
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "POST":
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "PATCH":
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "GET":
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "DELETE":
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    default:
        header("Content-Type: application/json");
        http_response_code(405);
        echo "ERROR -> No Available Method Found -> " . $routing;
        exit();
        break;
}
require_once($servicePath);
function routeError($method, $version)
{
    header("Content-Type: application/json");
    http_response_code(405);
    $errorArray[0]['Error'] = 'Method (' . $method . ') not available on this route with version number: ' . $version;
    echo json_encode($errorArray);
    exit();
}
