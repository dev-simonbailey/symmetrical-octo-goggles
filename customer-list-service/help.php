<?php
echo "Customer List Service:" . PHP_EOL . PHP_EOL;
echo "Version Number: 1.0.0" . PHP_EOL;
echo "The following is the payload format (All fields are required): " . PHP_EOL . PHP_EOL;
echo '{
        "routing": "{Service Routing}",
        "version": "{version.version.version}",
        "api-key": "{API-KEY}",
        "client_id": "{Client ID}",
        "get_from": "{first || last}",
        "condition": "{match || equal}"
        "search_for": "{full or partial string}"
    }' . PHP_EOL . PHP_EOL;
exit();
