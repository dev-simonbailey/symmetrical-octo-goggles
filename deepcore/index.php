<?php
$rootDIR =  dirname(__DIR__) . "/";
require_once($rootDIR . "routes.php");
$method = htmlspecialchars($_SERVER['REQUEST_METHOD'],  ENT_QUOTES, 'UTF-8');
$data = json_decode(file_get_contents('php://input'), true);
$routing = htmlspecialchars($data["routing"],  ENT_QUOTES, 'UTF-8');
$v1 = explode("-", $data['version']);
$version = implode(".", $v1);


if (array_key_exists($routing, $allowedRoutes)) {
    $route = $rootDIR . "/" . $allowedRoutes[$routing] . "/";
} else {
    header("Content-Type: application/json");
    http_response_code(405);
    echo "ERROR -> No Available Route Found -> " . $routing;
    exit();
}
require_once($rootDIR . "deepstore/meekro.php");
if (!empty(htmlspecialchars($data["help"],  ENT_QUOTES, 'UTF-8'))) {
    $helpPath = $route . "help.php";
    require_once($helpPath);
    exit();
}
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
        $servicePath = $route . "/" . $version . "/put.php";
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "POST":
        $servicePath = $route . "/" . $version . "/post.php";
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "PATCH":
        $servicePath = $route . "/" . $version . "/patch.php";
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "GET":
        $servicePath = $route . "/" . $version . "/get.php";
        if (!file_exists($servicePath)) {
            routeError($method, $version);
        }
        break;
    case "DELETE":
        $servicePath = $route . "/" . $version . "/delete.php";
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
