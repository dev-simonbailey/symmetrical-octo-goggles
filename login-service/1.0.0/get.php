<?php
error_reporting(E_ALL);
require_once(__DIR__ . "/../../deepstore/Connector.php");
$db = new Connector();
if (!$db) {
    echo $db->lastErrorMsg();
}

/**
 * Version 1.0.0 is a case-insensitive version of the login
 */
// TODO: Remove -> for dev only
echo "Welcome to Login Service";
echo PHP_EOL;
echo "Version -> " . $data['version'];
echo PHP_EOL;
echo "Api Key -> " . $data['api-key'];
echo PHP_EOL;
echo "Client ID -> " . $data['client_id'];
echo PHP_EOL;
echo "Username -> " . $data['username'];
echo PHP_EOL;
echo "Password -> " . $data['password'];
echo PHP_EOL;

$query1 = "SELECT * FROM customer_list_service WHERE username='" .
    $data['username'] . "' COLLATE NOCASE AND password = '" .
    $data['password'] . "' COLLATE NOCASE";
$result1 = $db->query($query1);
$rowCount = 0;
$resultsArray = [];
while ($row1 = $result1->fetchArray(SQLITE3_ASSOC)) {
    $resultsArray[$rowCount]['id'] = $row1['id'];
    $resultsArray[$rowCount]['client_id'] = $row1['client_id'];
    $resultsArray[$rowCount]['customer_first'] = $row1['customer_first'];
    $resultsArray[$rowCount]['customer_last'] = $row1['customer_last'];
    $rowCount++;
}
if (empty($resultsArray)) {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray[0]['Error'] = 'No records found';
    echo json_encode($errorArray);
    exit();
}
header("Content-Type: application/json");
echo json_encode($resultsArray);
$db->close();
