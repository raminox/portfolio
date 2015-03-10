<?php

$directory = basename(dirname(dirname(__FILE__)));

$url = explode($directory, $_SERVER['REQUEST_URI']);

if (count($url) == 1) {

    define('WEB_ROOT', '/');

} else {

    define('WEB_ROOT', $url['0'] . $directory . "/");
}

define('WWW_ROOT', dirname(dirname(__FILE__)));

define('IMAGES_DIR', WWW_ROOT . '/works/images');

var_dump(WEB_ROOT);
