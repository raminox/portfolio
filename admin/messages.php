<?php
require_once '../lib/auth.php';
require_once '../lib/functions.php';
require_once '../lib/db.php';
require_once '../lib/session.php';
require_once '../lib/constants.php';

$messages = select('*', 'messages', $connection);

generateCSRF();

view('messages', $messages = ['messages' => $messages]);
