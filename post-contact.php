<?php
session_start();

require_once 'lib/session.php';

require_once 'lib/db.php';

$services_emails = ['commercial@devlab.local', 'support.technique@devlab.local', 'marketing@devlab.local'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors      = [];
    $name        = $_POST['name'];
    $email       = $_POST['email'];
    $service_key = $_POST['service'];
    $message     = $_POST['message'];

    foreach ($_POST as $post => $value) {
        if (empty($value)) {
            $errors[$post] = "Please fill out the form of $post";
        }

    }

    if (array_key_exists($service_key, $services_emails)) {
        $service_email = $services_emails[$service_key];

    } else {
        $errors['service'] .= " or service reauest does not exist";
    }

    if (count($errors) != 0) {

        $_SESSION['post'] = $_POST;
        $errors           = '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>';
        setFlash($errors, 'danger');
        header('Location: contact.php');
        die();

    } else {

        mail('contact@devlab.local', 'Mon Sujet', $message);
        insert(['sender_name' => $name, 'sender_email' => $email, 'service' => $service_email, 'message' => $message], 'messages', $connection);
        setFlash('Thank you, your message sent successfully');
        header('Location: contact.php');
        die();

    }

}
