<?php
include(__DIR__ . "/../../deepstore/meekro.php");
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
    $userName = explode(" ", $values['name']);
    $query = "  INSERT INTO deepstore.customer_list_service (`client_id`, `customer_first`, `customer_last`, `username`, `password`)
                SELECT 'JSONPLACEHOLDER','" . $userName[0] . "', '" . $userName[1] . "','" . strtolower($values['email']) . "','" . $values['username'] . "' FROM DUAL
                WHERE NOT EXISTS (SELECT * FROM customer_list_service 
                        WHERE client_id='JSONPLACEHOLDER' 
                        AND customer_first = '" . $userName[0] . "'
                        AND customer_last = '" . $userName[1] . "' 
                        AND username = '" . strtolower($values['email']) . "'
                        AND password = '" . $values['username'] . "'
                        LIMIT 1)";

    DB::query($query);
    if (DB::insertId() != 0) {
        echo $values['name'] . " added" . PHP_EOL;
    } else {
        echo $values['name'] . " already exists" . PHP_EOL;
    }
}
