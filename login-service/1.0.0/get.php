<?php
error_reporting(E_ALL);
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
    exit();
}
echo json_encode($result);
exit();
