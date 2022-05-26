<?php
error_reporting(E_ALL);
require_once(__DIR__ . "/../../deepstore/Connector.php");
$db = new Connector();
if (!$db) {
    echo $db->lastErrorMsg();
}

//site-advertising-service
// TODO: Remove before deployment
echo "Welcome to Site Advertising Service -> ";
echo PHP_EOL;
echo "Version -> " . $data['version'];
echo PHP_EOL;
echo "Api Key -> " . $data['api-key'];
echo PHP_EOL;
echo "Client ID -> " . $data['client_id'];
echo PHP_EOL;
echo "Ad Service -> " . $data['service'];
echo PHP_EOL;
echo "Campaign -> " . $data['campaign'];
echo PHP_EOL;

$query1 = "SELECT * FROM site_advertising_service WHERE service='" . $data['service'] . "'";
$result1 = $db->query($query1);
$rowCount = 0;
$resultsArray = [];
while ($row1 = $result1->fetchArray(SQLITE3_ASSOC)) {
    $resultsArray[$rowCount]['id'] = $row1['id'];
    $resultsArray[$rowCount]['service'] = $row1['service'];
    $resultsArray[$rowCount]['endpoint'] = $row1['endpoint'] . "/" . $data['campaign'];
    $rowCount++;
}
if (empty($resultsArray)) {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray = ['Error' => 'No Records Found'];
    echo json_encode($errorArray);
    exit();
}
header("Content-Type: application/json");
echo json_encode($resultsArray);
$db->close();
