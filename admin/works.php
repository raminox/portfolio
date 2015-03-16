<?php

require_once '../lib/auth.php';
require_once '../lib/functions.php';
require_once '../lib/db.php';
require_once '../lib/session.php';
require_once '../lib/constants.php';

$works = select(['id', 'name', 'slug'], 'works', $connection);

generateCSRF();

view('works', $works = ['works' => $works]);
