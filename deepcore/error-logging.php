<?php
function writeError(int $responseCode, string $message, string $action, string $route, string $version)
{
    global $allowedRoutes;
    global $allowedVersions;
    $filePath = __DIR__ . "/../" . $allowedRoutes[$route] . "/" . $action . "/" . $allowedVersions[$version];
    $errorLogFile = fopen($filePath . "/error.log", "a");
    $errorMessage = date("Y-m-d H:i:s") . "|" . $route . "|" . $version . "|" . $action . "|" . $message . "|" . $responseCode . "\n";
    fwrite($errorLogFile, $errorMessage);
    fclose($errorLogFile);
}
