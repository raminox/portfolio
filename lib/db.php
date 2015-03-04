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

// function connection($config)
// {
//     extract($config);
//     $dsn = "$db_type:host=$db_host;dbname=$db_name";

//     try {
//         $connection = new PDO($dsn, $db_user, $db_pass);
//         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//         return $connection;

//     } catch (Exception $e) {

//         echo "Can't Connect to Database, Errors : " . $e->getMessage();
//         return flase;
//         die();

//     }

// }

// require_once 'config.php';

// connection($config);

// function select($items = [], $table, $connection, $index = null, $limit = null)
// {

//     $stmt = $connection->prepare("SELECT id, name, slug, content, category_id FROM works WHERE id = :id");
//     $stmt->bindValue(':id', $id, PDO::PARAM_INT);
//     $result = $stmt->execute();
// }
