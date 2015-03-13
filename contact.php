<?php
session_start();

require_once 'lib/session.php';
require_once 'lib/form.php';
require_once 'lib/constants.php';
require_once 'partials/header.php';

$services_name = ['Commercial', 'Support technique', 'Marketing'];

if (isset($_SESSION['post'])) {

    $_POST = $_SESSION['post'];
    unset($_SESSION['post']);
}
?>

<div class="container">
<div class="col-sm-12">
	<?=flash();?>
	<form action="post-contact.php" method="POST">
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
				<?=selectInput('service', $services_name);?>
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
</div>



<?php require_once 'partials/footer.php';?>