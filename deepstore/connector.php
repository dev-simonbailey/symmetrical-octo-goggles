<?php
class Connector extends SQLite3
{
    function __construct()
    {
        $this->open(__DIR__ . '/deepstore.db');
    }
}
