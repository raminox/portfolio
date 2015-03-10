<?php

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

// generateCSRF() it's a function to generate CSRF Code

function generateCSRF()
{
    if (empty($_SESSION['code-csrf'])) {

        $_SESSION['code-csrf'] = md5(time() + rand());
    }

}

// Add CSRF

function CSRF()
{
    return 'csrf=' . $_SESSION['code-csrf'];
}

// Verifiy the CSRF code

function checkCSRF()
{
    if (empty($_GET['csrf']) || $_GET['csrf'] != $_SESSION['code-csrf']) {
        header('Location: csrf.php');
        die();
    }
}

// Clean String

function cleanString($string = [])
{
    return htmlspecialchars(trim($string));

}

function arrayConvert($input_array)
{
    $output_array = [];
    foreach ($input_array as $key => $input_value) {
        $output_array = $input_value;
    }
    return $output_array;
}
