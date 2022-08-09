<?php

$connection = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_USER']);

if ($connection->connect_error) {
    die('Connection to database failed' . $connection->connect_error);
}
