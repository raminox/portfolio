<?php

session_start();

if (isset($_SESSION['username'])) {

    header('Location: index.php');

}

require '../lib/db.php';
require '../lib/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = htmlspecialchars($_POST['username']);
    $password = sha1(htmlspecialchars($_POST['password']));

    if (empty($username) || empty($password)) {

        $status = "Please Enter your username Or password";

    } elseif (checkUser($username, $password, $connection)) {

        $_SESSION['username'] = $username;
        header('Location: index.php');
        die();

    }
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="../css/style.css">
	</head>
	<body>
		<div class="container">
			<div class="row login-form">
				<div class="col-md-4 col-md-offset-4">
					<form action="login.php" method="POST">
						<div class="form-group">
							<label for="username">Nom d'utilisateur :</label>
							<input type="text" class="form-control" id="username" name="username" value="<?=isset($username) ? $username : '';?>">
						</div>
						<div class="form-group">
							<label for="password">Mot de passe :</label>
							<input type="password" class="form-control" id="password" name="password">
						</div>
						<button type="submit" class="btn btn-default">Se Connecter</button>
					</form>
					<?=isset($status) ? $status : '';?>
				</div>
			</div>
		</div>
	</body>
</html>
