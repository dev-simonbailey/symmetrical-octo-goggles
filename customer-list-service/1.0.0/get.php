<?php
error_reporting(E_ALL);
require_once(__DIR__ . "/../../deepstore/Connector.php");
$db = new Connector();
if (!$db) {
    echo $db->lastErrorMsg();
}
//customer-list-service
// TODO: Remove before deployment
echo "Welcome to Customer List Service -> ";
echo PHP_EOL;
echo "Version -> " . $data['version'];
echo PHP_EOL;
echo "Api Key -> " . $data['api-key'];
echo PHP_EOL;
echo "Client ID -> " . $data['client_id'];
echo PHP_EOL;
echo "Get From -> " . $data['get_from'];
echo PHP_EOL;
echo "Condition -> " . $data['condition'];
echo PHP_EOL;
echo "Search For -> " . $data['search_for'];
echo PHP_EOL;

if ($data['get_from'] == "id") {
    if ($data['condition'] == "match") {
        $query1 = "SELECT * FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND id LIKE '%" . $data['search_for'] . "%'";
    }
    if ($data['condition'] == "equal") {
        $query1 = "SELECT * FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND id = '" . $data['search_for'] . "'";
    }
}
if ($data['get_from'] == "last") {
    if ($data['condition'] == "match") {
        $query1 = "SELECT * FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND customer_last LIKE '%" . $data['search_for'] . "%' COLLATE NOCASE";
    }
    if ($data['condition'] == "equal") {
        $query1 = "SELECT * FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND customer_last = '" . $data['search_for'] . "' COLLATE NOCASE";
    }
}
if ($data['get_from'] == "first") {
    if ($data['condition'] == "match") {
        $query1 = "SELECT * FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND customer_first LIKE '%" . $data['search_for'] . "%' COLLATE NOCASE";
    }
    if ($data['condition'] == "equal") {
        $query1 = "SELECT * FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND customer_first = '" . $data['search_for'] . "' COLLATE NOCASE";
    }
}
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
    $errorArray = ['Error' => 'No Records Found'];
    echo json_encode($errorArray);
}
header("Content-Type: application/json");
echo json_encode($resultsArray);
$db->close();
