<?php
error_reporting(E_ALL);
$query = " SELECT id FROM api_keys WHERE client_id='" .
    $data['client_id'] . "' AND api_key = '" .
    $data['api-key'] . "' AND valid_till >= NOW()";
$result = DB::queryFirstRow($query);
if (empty($result)) {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray = ['Error' => 'API KEY NOT FOUND AND / OR API EXPIRED'];
    echo json_encode($errorArray);
    exit();
}
