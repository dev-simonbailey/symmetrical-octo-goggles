<?php
error_reporting(E_ALL);
$query = "SELECT id, service, endpoint FROM site_advertising_service WHERE service='" . $data['service'] . "'";
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
