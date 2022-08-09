<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'vatsal');
define('DB_PASSWORD', 'vatsal@123');
define('DB_NAME', 'demo');

$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($connection->connect_error) {
    die('Connection to database failed' . $connection->connect_error);
}
