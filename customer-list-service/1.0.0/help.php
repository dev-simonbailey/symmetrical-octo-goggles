<?php
echo "Customer List Service:" . PHP_EOL . PHP_EOL;
echo "Version Number: 1.0.0" . PHP_EOL;
echo "The following is the payload format (All fields are required): " . PHP_EOL . PHP_EOL;
echo '{
        "routing": "{Service Routing}",
        "version": "{major-minor-patch}",
        "api-key": "{API-KEY}",
        "client_id": "{Client ID}",
        "get_from": "{first || last}",
        "condition": "{match || equal}"
        "search_for": "{full or partial string}"
    }' . PHP_EOL . PHP_EOL;
echo "Example:" . PHP_EOL . PHP_EOL;
echo '{
    "routing": "CustomerListService",
    "version": "1-0-0",
    "api-key": "ABC123",
    "client_id": "SUPERCLIENT",
    "get_from": "last",
    "condition": "equal"
    "search_for": "smith"
}' . PHP_EOL . PHP_EOL;
exit();
