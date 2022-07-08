<?php
error_reporting(E_ALL);
if (!isset($data['username'], $data['password'])) {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray[0]['Error'] = 'Either the Username or Password field was not found. Please check your JSON payload.';
    echo json_encode($errorArray);
    writeError(400, 'Either the Username or Password field was not found.', $action, $route, $version);
    exit();
}
if (empty($data['username']) || empty($data['password'])) {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray[0]['Error'] = 'Either the Username or Password value was not found.';
    $errorArray[1]['Message'] = 'Please check your JSON payload.';
    echo json_encode($errorArray);
    writeError(400, 'Either the Username or Password value was not found.', $action, $route, $version);
    exit();
}
$query = "SELECT id FROM customer_list_service 
WHERE username = '" . $data['username'] . "' 
AND password = '" . $data['password'] . "'";
$result = DB::queryFirstRow($query);
header("Content-Type: application/json");
if (empty($result)) {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray[0]['Error'] = 'No records found';
    echo json_encode($errorArray);
    writeError(400, 'No records found', $action, $route, $version);
    exit();
}
echo json_encode($result);
exit();
