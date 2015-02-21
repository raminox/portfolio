<?php

session_start();

if (empty($_SESSION['username'])) {

    header('Location: login.php');
    die();

}

if (empty($_SESSION['code-csrf'])) {

    //$_SESSION['code-csrf'] = md5(time() + rand());
    generateCSRF();
}
