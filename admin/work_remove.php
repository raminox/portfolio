<?php

include '../lib/auth.php';
include '../lib/functions.php';
include '../lib/db.php';

checkCSRF();

$id = htmlspecialchars($_GET['id']);

delete('works', $id, $connection);

header('Location: works.php');
die();
