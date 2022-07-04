<?php

/**
 * Set the rootDIR
 */
$rootDIR =  dirname(__DIR__);
/**
 * Require the routes whitelist
 */
require_once($rootDIR . "/routes.php");
/**
 * Require the version whitelist
 */
require_once($rootDIR . "/versions.php");
/**
 * Cleanse the REQUEST_METHOD
 */
$method = htmlspecialchars($_SERVER['REQUEST_METHOD'],  ENT_QUOTES, 'UTF-8');
/**
 * Decode the JSON data as associative array
 */
$data = json_decode(file_get_contents('php://input'), true);
/**
 * Cleanse the requested route string
 */
$route = htmlspecialchars($data["route"],  ENT_QUOTES, 'UTF-8');
/**
 * Cleanse the requested action string
 */
$action = htmlspecialchars($data["action"],  ENT_QUOTES, 'UTF-8');
/**
 * Cleanse the requested version string
 */
$version = htmlspecialchars($data["version"],  ENT_QUOTES, 'UTF-8');
/**
 * If the requested resource route is allowed, then build routePath, otherwise error
 */
if (array_key_exists($route, $allowedRoutes)) {
    $routePath = $rootDIR . "/" . $allowedRoutes[$route] . "/" . $action . "/";
} else {
    header("Content-Type: application/json");
    errorHandler(405, "No Available Route Found -> " . $route);
}
/**
 * If the requested resource version is allowed, then add to routePath, otherwise error
 */
if (array_key_exists($version, $allowedVersions)) {
    $routePath .= $allowedVersions[$version] . "/";
} else {
    header("Content-Type: application/json");
    errorHandler(405, "No Available Version Found -> " . $version);
}
/**
 * If the requested help file does not exist, error
 */
if (isset($data["help"])) {
    $helpPath = $routePath . "help.php";
    if (!file_exists($helpPath)) {
        errorHandler(405, 'HELP is not available on this route with version number: ' . $version);
    }
    require_once($helpPath);
    exit();
}
/**
 * Require the meekroDB class
 */
require_once($rootDIR . "/deepstore/meekro.php");
if (empty($routePath) && empty($version)) {
    errorHandler(400, "No Route and / or Version given");
}
/**
 * Require the api check
 */
require_once($rootDIR . "/deepcore/api.php");
/**
 * Add the default filename to the routePath
 */
$routePath .= "index.php";
/**
 * If the requested resource doesn't exist, error
 */
if (!file_exists($routePath)) {
    routeError($route, $action, $version);
}
/**
 * require the requested resource
 */
require_once($routePath);
/**
 * routeError
 *
 * @param string $route
 * @param string $action
 * @param string $version
 * @return void
 */
function routeError(string $route, string $action, string $version): void
{
    header("Content-Type: application/json");
    http_response_code(405);
    $errorArray[0]['Error'] = 'Action [ ' . $action . ' ] not available on route [ ' . $route . ' ] with version number [ ' . $version . ' ]';
    echo json_encode($errorArray);
    exit();
}
/**
 * errorHandler
 *
 * @param integer $errCode
 * @param string $errMsg
 * @return void
 */
function errorHandler(int $errCode, string $errMsg): void
{
    header("Content-Type: application/json");
    http_response_code($errCode);
    $errorArray[0]['Error'] = $errMsg;
    echo json_encode($errorArray);
    exit();
}
