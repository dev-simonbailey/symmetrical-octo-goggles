<?php
error_reporting(E_ALL);
require_once(__DIR__ . "/../deepstore/Connector.php");
$todaysDate = date("Y-m-d 00:00:00");
$query1 = " SELECT * FROM api_keys WHERE client_id='" .
    $data['client_id'] . "' AND api_key = '" .
    $data['api-key'] . "' AND valid_till >= date('now')";
$db = new Connector();
if (!$db) {
    echo $db->lastErrorMsg();
}
$result1 = $db->query($query1);
$rowCount = 0;
$apiArray = [];
while ($row1 = $result1->fetchArray(SQLITE3_ASSOC)) {
    $apiArray[$rowCount]['id'] = $row1['id'];
    $apiArray[$rowCount]['client_id'] = $row1['client_id'];
    $apiArray[$rowCount]['api_key'] = $row1['api_key'];
    $apiArray[$rowCount]['valid_till'] = $row1['valid_till'];
    $rowCount++;
}
if (empty($apiArray)) {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray = ['Error' => 'API KEY NOT FOUND'];
    echo json_encode($errorArray);
    exit();
}
$db->close();
