<?php
require_once(__DIR__ . "/../deepstore/meekro.php");
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['help'])) {
    $helpPath = __DIR__ . '/../'
        . $data["routing"] . "/"
        . "help.php";
    include($helpPath);
    exit();
}
if (!empty($data["routing"]) && !empty($data["version"])) {
    $servicePath = __DIR__ . '/../'
        . $data["routing"] . "/"
        . $data["version"] . "/"
        . strtolower($method) . ".php";
} else {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray[0]['Error'] = 'No Route and / or Version given';
    echo json_encode($errorArray);
    exit();
}
include(__DIR__ . "/api.php");
switch ($method) {
    case "PUT":
        if (!file_exists($servicePath)) {
            routeError($method, $data['version']);
        }
        break;
    case "POST":
        if (!file_exists($servicePath)) {
            routeError($method, $data['version']);
        }
        include($servicePath);
        break;
    case "PATCH":
        if (!file_exists($servicePath)) {
            routeError($method, $data['version']);
        }
        break;
    case "GET":
        if (!file_exists($servicePath)) {
            routeError($method, $data['version']);
        }
        break;
    case "DELETE":
        if (!file_exists($servicePath)) {
            routeError($method, $data['version']);
        }
        break;
    default:
        header("Content-Type: application/json");
        http_response_code(405);
        echo "ERROR -> No Available Method Found -> " . htmlspecialchars($data["routing"],  ENT_QUOTES, 'UTF-8');
        exit();
        break;
}
include($servicePath);
function routeError($method, $version)
{
    header("Content-Type: application/json");
    http_response_code(405);
    $errorArray[0]['Error'] = 'Method (' . $method . ') not available on this route with version number: ' . $version;
    echo json_encode($errorArray);
    exit();
}
