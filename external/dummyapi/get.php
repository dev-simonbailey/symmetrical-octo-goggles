<?php
include(__DIR__ . "/../../deepstore/meekro.php");
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://dummyapi.io/data/v1/user',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'app-id: 629e08de26bca77900a3d65c'
    ),
));
$response = curl_exec($curl);
curl_close($curl);
$results = json_decode($response, true);

//var_dump($results);
foreach ($results as $keys => $values) {
    foreach ($values as $key => $value) {

        $userName = strtolower($value['firstName']) . "." . strtolower($value['lastName']);
        $passWord = MD5($value['firstName'] . $value['lastName'] . $value['id]']);

        $query = "  INSERT INTO deepstore.customer_list_service (`client_id`, `customer_first`, `customer_last`, `username`, `password`)
        SELECT 'DUMMYAPI','" . $value['firstName'] . "', '" . $value['lastName'] . "','" . $userName . "','" . substr($passWord, -16) . "' FROM DUAL
        WHERE NOT EXISTS (SELECT * FROM customer_list_service 
                WHERE client_id='DUMMYAPI' 
                AND customer_first = '" . $value['firstName'] . "'
                AND customer_last = '" . $value['lastName'] . "' 
                AND username = '" . $userName . "'
                AND password = '" . substr($passWord, -16) . "'
                LIMIT 1)";
        DB::query($query);
        if (DB::insertId() != 0) {
            echo $value['firstName'] . " " . $value['lastName'] . " added" . PHP_EOL;
        } else {
            echo $value['firstName'] . " " . $value['lastName'] . " already exists" . PHP_EOL;
        }
    }
}
