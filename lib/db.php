<?php

$dsn = "mysql:host=localhost;dbname=portfolio";

try {

    $connection = new PDO($dsn, 'root', '123456');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (Exception $e) {

    echo "Can't Connect to Database, Errors : " . $e->getMessage();
    die();

}
