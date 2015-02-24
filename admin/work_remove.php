<?php

include '../lib/auth.php';
include '../lib/functions.php';
include '../lib/db.php';

checkCSRF();

$id = htmlspecialchars($_GET['id']);

$stmt = $connection->prepare("DELETE FROM works WHERE id = :id ");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header('Location: works.php');
die();
