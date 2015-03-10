<?php

require 'config.php';

/**
 * [connection description]
 * @param  [type] $config [description]
 * @return [type]         [description]
 */
function connection($config)
{
    extract($config);
    $dsn = "$db_type:host=$db_host;dbname=$db_name";

    try {
        $connection = new PDO($dsn, $db_user, $db_pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;

    } catch (Exception $e) {

        echo "Can't Connect to Database, Errors : " . $e->getMessage();
        return flase;
        die();

    }

}

/**
 * [ SELECT FUNCTION ]
 *
 * @param  [array / '*'] $items      [define the elements to select from table / '*' for all]
 * @param  [string] $table      [name of table]
 * @param  [object] $connection [the PDO object]
 * @return [type]             [description]
 */
function select($items, $table, $connection, $condition = null)
{

    if ($condition) {

        if (is_numeric($condition)) {
            $condition = "WHERE " . "`id`=" . $condition;
        }
        if (is_array($condition)) {
            $condition = "WHERE " . "`" . implode(array_keys($condition)) . "`=" . '"' . implode(array_values($condition)) . '"' . "";
        }
    }

    if (is_array($items)) {
        $items = '`' . implode('`,`', $items) . '`';

    }

    $stmt = $connection->prepare("SELECT $items FROM `$table` $condition");
    $stmt->execute();
    return $stmt->fetchAll();

}

/**
 * [INSERT FUNCTION]
 *
 * @param  [array] $items      [associative arrray columns => values]
 * @param  [string] $table      [name of table]
 * @param  [object] $connection [the PDO object]
 * @return [boolean]             [description]
 */
function insert($items, $table, $connection)
{
    $keys        = array_keys($items);
    $col_name    = '`' . implode('`,`', $keys) . '`';
    $bind_values = ':' . implode(',:', $keys);
    $stmt        = $connection->prepare("INSERT INTO $table ($col_name) VALUES($bind_values)");
    $insert      = $stmt->execute($items);
    if ($insert == true) {
        return $connection->lastInsertId();
    } else {
        return false;
    }

}

/**
 * [update description]
 *
 * @param  [type] $items      [description]
 * @param  [type] $table      [description]
 * @param  [type] $condition  [description]
 * @param  [type] $connection [description]
 * @return [type]             [description]
 */
function update($items, $table, $condition, $connection)
{
    // Working on the set part of the SQL request
    $set = '';
    foreach ($items as $key => $item) {
        $set .= "`$key`" . '=' . ":" . "$key" . ", ";
    }
    // Remove the last space & comma from the request line
    $set = rtrim($set, ', ');

    if (is_numeric($condition)) {
        $condition   = "`id`=" . $condition;
        $bind_values = $items;
    } elseif (is_array($condition)) {
        $condition   = '`' . implode(array_keys($condition)) . '`=:' . implode(array_keys($condition));
        $bind_values = array_merge($items, $condition);
    }
    $stmt = $connection->prepare("UPDATE `$table` SET $set WHERE $condition");
    $stmt->execute($bind_values);
}

/**
 * [DETELE FUNCTION]
 *
 * @param  [string] $table      [description]
 * @param  [type] $condition  [description]
 * @param  [type] $connection [description]
 * @return [type]             [description]
 */
function delete($table, $condition, $connection)
{
    if (is_numeric($condition)) {
        $condition   = '`id`=' . $condition;
        $bind_values = null;
    } elseif (is_array($condition)) {
        $bind_values = $condition;
        $condition   = '`' . implode(array_keys($condition)) . '`=:' . implode(array_keys($condition));
    }
    $stmt = $connection->prepare("DELETE FROM `$table` WHERE $condition ");
    $stmt->execute($bind_values);
}

/**
 * Setup the connection
 * @var [PDO object]
 */
$connection = connection($config);
