<?php
session_start();
require_once 'lib/form.php';
require_once 'lib/constants.php';
require_once 'lib/session.php';
require_once 'lib/db.php';

$services_list = ['Commercial' => 'comercial.service@gmail.com', 'Support technique' => 'support.technique@gmail.com'];

require_once 'partials/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors  = [];
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $service = $_POST['service'];
    $message = $_POST['message'];

    foreach ($_POST as $post => $value) {
        if (empty($value)) {
            $errors[$post] = "please fill out the form of $post";
        }

    }
    if (empty($errors)) {
        insert(['sender_name' => $name, 'sender_email' => $email, 'service' => $service, 'message' => $message], 'messages', $connection);
        // setFlash("Your message was been send");
        // header('Location: index.php');
        // die();
    }

}
?>


<div class="container">
	<form action="#" method="POST">
		<div class="col-sm-4">
			<div class="form-group">
				<label for="name">Full name :</label>
				<?=input('name');?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label for="slug">E-mail :</label>
				<?=input('email', 'email');?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label for="categoty_id">Service :</label>
				<?=selectInput('service', array_keys($services_list));?>
			</div>
		</div>
		<div class="form-group">
			<label for="slug">Message :</label>
			<?=input('message', 'textarea');?>
		</div>
		<div class="form-group">
			<?=input('submit', 'submit', 'Envoyer')?>
		</div>
	</form>
</div>

<?php flash()?>

<?php require_once 'partials/footer.php';?>