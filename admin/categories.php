<?php

require_once '../lib/auth.php';
require_once '../lib/functions.php';
require_once '../lib/db.php';
require_once '../lib/session.php';
require_once '../lib/constants.php';

$categories = select(['id', 'name', 'slug'], 'categories', $connection);

generateCSRF();

view('categories', $categories = ['categories' => $categories]);
