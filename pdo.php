<?php

$db_connection = DB_CONNECTION;
$db_host = DB_HOST;
$db_database = DB_DATABASE;

define("DSN", "{$db_connection}:host={$db_host};dbname={$db_database}");

try {
    $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}