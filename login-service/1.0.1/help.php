<?php
echo "Login Service:" . PHP_EOL . PHP_EOL;
echo "Version Number: 1.0.1" . PHP_EOL;
echo "The username and password in this version are case sensitive" . PHP_EOL . PHP_EOL;
echo "The following is the payload format (All fields are required): " . PHP_EOL . PHP_EOL;
echo '{
        "routing": "{Service Routing}",
        "version": "{version.version.verison}",
        "api-key": "{API-KEY}",
        "client_id": "{Client ID}",
        "username": "{USERNAME}",
        "password": "{PASSWORD}"
    }' . PHP_EOL . PHP_EOL;
exit();
