<?php

include '../lib/functions.php';
include '../lib/auth.php';
include '../lib/db.php';

include 'template/header.php';
?>
<div class="container">
<br>
<br>
<br>

	<div class="row login-form">
				<div class="col-md-8 col-md-offset-2">
				<h4>Ajouter une nouvelle categorie</h4>
					<form action="login.php" method="POST">
						<div class="form-group">
							<label for="category-name">Nom du categorie :</label>
							<input type="text" class="form-control" id="username" name="username" value="<?=isset($username) ? $username : '';?>">
						</div>
						<div class="form-group">
							<label for="password">Le Slug du categorie :</label>
							<input type="password" class="form-control" id="password" name="password">
						</div>
						<button type="submit" class="btn btn-default">Enregestrer</button>
					</form>
</div>
<?php
include '../partials/footer.php';
?>