<?php
error_reporting(E_ALL);

/*TODO Error check the data
This endpoint requires the username and password, 
so we need to check if they have been supplied.
If they are not both present and have values, then
return an error, along with an explaination

carolina.lima 
17ecb08a7049bd62
*/

if (!isset($data['username'], $data['password'])) {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray[0]['Error'] = 'Either the Username or Password field was not found. Please check your JSON payload.';
    echo json_encode($errorArray);
    exit();
}
if (empty($data['username']) || empty($data['password'])) {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray[0]['Error'] = 'Either the Username or Password value was not found.';
    $errorArray[1]['Message'] = 'Please check your JSON payload.';
    echo json_encode($errorArray);
    exit();
}

$query = "SELECT id FROM customer_list_service 
WHERE username = BINARY '" . $data['username'] . "' 
AND password = BINARY '" . $data['password'] . "'";
$result = DB::queryFirstRow($query);
header("Content-Type: application/json");
if (empty($result)) {
    header("Content-Type: application/json");
    http_response_code(400);
    $errorArray[0]['Error'] = 'No records found.';
    echo json_encode($errorArray);
    exit();
}
echo json_encode($result);
exit();
