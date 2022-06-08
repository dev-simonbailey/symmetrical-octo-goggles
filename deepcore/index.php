<?php
$rootDIR =  dirname(__DIR__);
require_once($rootDIR . "/routes.php");
require_once($rootDIR . "/versions.php");
$method = htmlspecialchars($_SERVER['REQUEST_METHOD'],  ENT_QUOTES, 'UTF-8');
$data = json_decode(file_get_contents('php://input'), true);
$routing = htmlspecialchars($data["routing"],  ENT_QUOTES, 'UTF-8');
$version = htmlspecialchars($data["version"],  ENT_QUOTES, 'UTF-8');
if (array_key_exists($routing, $allowedRoutes)) {
    $route = $rootDIR . "/" . $allowedRoutes[$routing] . "/";
} else {
    header("Content-Type: application/json");
    http_response_code(405);
    $errorArray[0]['Error'] = "No Available Route Found -> " . $routing;
    echo json_encode($errorArray);
    exit();
}
if (array_key_exists($version, $allowedVersion)) {
    $route .= $allowedVersion[$version] . "/";
} else {
    header("Content-Type: application/json");
    http_response_code(405);
    $errorArray[0]['Error'] = "No Available Version Found -> " . $version;
    echo json_encode($errorArray);
    exit();
}
if (isset($data["help"])) {
    $helpPath = $route . "help.php";
    require_once($helpPath);
    exit();
}
require_once($rootDIR . "/deepstore/meekro.php");
if (empty($route) && empty($version)) {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray[0]['Error'] = 'No Route and / or Version given';
    echo json_encode($errorArray);
    exit();
}
require_once($rootDIR . "/deepcore/api.php");
switch ($method) {
    case "PUT":
        $servicePath = $route . "put.php";
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "POST":
        $servicePath = $route . "post.php";
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "PATCH":
        $servicePath = $route . "patch.php";
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "GET":
        $servicePath = $route . "get.php";
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "DELETE":
        $servicePath = $route . "delete.php";
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
