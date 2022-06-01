<?php
error_reporting(E_ALL);
//customer-list-service
/* TODO: Remove before deployment
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
*/

if ($data['get_from'] == "id") {
    if ($data['condition'] == "match") {
        $query = "SELECT id, customer_first, customer_last FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND id LIKE '%" . $data['search_for'] . "%'";
    }
    if ($data['condition'] == "equal") {
        $query = "SELECT id, customer_first, customer_last FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND id = '" . $data['search_for'] . "'";
    }
}
if ($data['get_from'] == "last") {
    if ($data['condition'] == "match") {
        $query = "SELECT id, customer_first, customer_last FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND customer_last LIKE '%" . $data['search_for'] . "%'";
    }
    if ($data['condition'] == "equal") {
        $query = "SELECT id, customer_first, customer_last FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND customer_last = '" . $data['search_for'] . "'";
    }
}
if ($data['get_from'] == "first") {
    if ($data['condition'] == "match") {
        $query = "SELECT id, customer_first, customer_last FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND customer_first LIKE '%" . $data['search_for'] . "%'";
    }
    if ($data['condition'] == "equal") {
        $query = "SELECT id,customer_first, customer_last FROM customer_list_service WHERE client_id='" . $data['client_id'] . "' AND customer_first = '" . $data['search_for'] . "'";
    }
}

$result = DB::query($query);

header("Content-Type: application/json");

if (empty($result)) {
    http_response_code(400);
    $errorArray = ['Error' => 'No Records Found'];
    echo json_encode($errorArray);
    exit();
}

echo json_encode(($result));

exit();
