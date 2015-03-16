<?php

include '../lib/auth.php';
include '../lib/functions.php';
include '../lib/db.php';

checkCSRF();

$id = htmlspecialchars($_GET['id']);

delete('messages', $id, $connection);

header('Location: messages.php');
die();
