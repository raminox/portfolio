<?php

/**
 * [checkUser description]
 * @param  [type] $username   [description]
 * @param  [type] $password   [description]
 * @param  [type] $connection [description]
 * @return [type]             [description]
 */
function checkUser($username, $password, $connection)
{

    $stmt   = $connection->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $result = $stmt->execute(array(':username' => $username, ':password' => $password));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //$count  = $result->rowCount();
    if ($username === $result['username'] && $password === $result['password']) {
        return true;
    } else {
        return false;
    }

}

/**
 * [generateCSRF description]
 * @return [type] [description]
 */
function generateCSRF()
{
    if (empty($_SESSION['code-csrf'])) {

        $_SESSION['code-csrf'] = md5(time() + rand());
    }

}

/**
 * [CSRF description]
 */
function CSRF()
{
    return 'csrf=' . $_SESSION['code-csrf'];
}

/**
 * [checkCSRF description]
 * @return [type] [description]
 */
function checkCSRF()
{
    if (empty($_GET['csrf']) || $_GET['csrf'] != $_SESSION['code-csrf']) {
        header('Location: csrf.php');
        die();
    }
}

/**
 * [cleanString description]
 * @param  [type] $string [description]
 * @return [type]         [description]
 */
function cleanString($string = [])
{
    return htmlspecialchars(trim($string));

}

/**
 * [arrayConvert description]
 * @param  [type] $input_array [description]
 * @return [type]              [description]
 */
function arrayConvert($input_array)
{
    $output_array = [];
    foreach ($input_array as $key => $input_value) {
        $output_array = $input_value;
    }
    return $output_array;
}

function view($path_name, $data = null)
{
    if ($data) {
        extract($data);
    }
    $path_name .= ".view.php";
    include '../admin/views/layout.php';
}
