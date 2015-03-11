<?php

include '../lib/auth.php';
include '../lib/functions.php';
include '../lib/db.php';

checkCSRF();
$id = htmlspecialchars($_GET['id']);

delete('categories', $id, $connection);

header('Location: categories.php');
die();
