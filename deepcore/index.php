<?php
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);
if (!empty($data["routing"]) && !empty($data["version"])) {
    $servicePath = __DIR__ . '/../'
        . $data["routing"] . "/"
        . $data["version"] . "/"
        . strtolower($method) . ".php";
} else {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray[0]['Error'] = 'No Route and/or Version given';
    echo json_encode($errorArray);
    exit();
}
include(__DIR__ . "/api.php");
switch ($method) {
    case "PUT":
        if (!file_exists($servicePath)) {
            routeError($method);
        }
        break;
    case "POST":
        if (!file_exists($servicePath)) {
            routeError($method);
        }
        include($servicePath);
        break;
    case "PATCH":
        if (!file_exists($servicePath)) {
            routeError($method);
        }
        break;
    case "GET":
        if (!file_exists($servicePath)) {
            routeError($method);
        }
        break;
    case "DELETE":
        if (!file_exists($servicePath)) {
            routeError($method);
        }
        break;
    default:
        header("Content-Type: application/json");
        http_response_code(405);
        echo "ERROR -> No Available Method Found -> " . $data["routing"];
        exit();
        break;
}
include($servicePath);
function routeError($method)
{
    header("Content-Type: application/json");
    http_response_code(405);
    $errorArray[0]['Error'] = 'Method (' . $method . ') not allowed on this route';
    echo json_encode($errorArray);
    exit();
}
