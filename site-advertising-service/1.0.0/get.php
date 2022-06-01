<?php
error_reporting(E_ALL);


//site-advertising-service
/* TODO: Remove before deployment
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
*/

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
