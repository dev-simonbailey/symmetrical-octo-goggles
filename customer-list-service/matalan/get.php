<?php

include(__DIR__ . "/../../deepstore/connector.php");

$db = new Connector();
if (!$db) {
    echo $db->lastErrorMsg();
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://jsonplaceholder.typicode.com/users',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

$results = json_decode($response, true);

foreach ($results as $keys => $values) {
    //$userName = explode(" ", $values['name']);
    //echo "User Firstname: " . $userName[0] . "<br />";
    //echo "User Firstname: " . $userName[1] . "<br />";
    //echo "Username: " . $values['email'] . "<br />";
    //echo "Password: " . $values['username'] . "<br />";
    //echo "<hr />";

    $insertQuery = "INSERT INTO customer_list_service (client_id, customer_first, customer_last, username, password) 
    VALUES('MAT','" . $userName[0] . "','" . $userName[1] . "','" . $values['email'] . "','" . $values['username'] . "')";

    $searchQuery = "SELECT * FROM customer_list_service WHERE 
    customer_first='" . $userName[0] . "' 
    AND 
    customer_last = '" . $userName[1] . "' 
    AND
    username = '" . $values['email'] . "'
    AND
    username = '" . $values['username'] . "'
    COLLATE NOCASE";

    $searchResult = $db->query($searchQuery);
    $row1 = $searchResult->fetchArray(SQLITE3_ASSOC);
    print_r($row1);

    //echo $insertQuery;
    //$db->query($insertQuery);
}
