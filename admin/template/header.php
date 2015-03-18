<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Administation du Site</title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="../css/style.css">
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-header">
				<a href="<?=WEB_ROOT?>" class="navbar-brand">My Portfolio</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<p class="navbar-text pull-right">Signed in as
				<strong><?=ucfirst($_SESSION['username']);?></strong>
				</p>
				<ul class="nav navbar-nav navbar-left">
					<li><a href="<?=WEB_ROOT;?>">Home</a></li>
					<li><a href="<?=WEB_ROOT;?>admin/categories.php">Categories</a></li>
					<li><a href="<?=WEB_ROOT;?>admin/works.php">Realisation</a></li>
					<li><a href="<?=WEB_ROOT;?>admin/messages.php">Messages</a></li>
					<li><a href="<?=WEB_ROOT;?>admin/profiles.php">Profiles</a></li>
				</ul>
			</div>
		</div>
	</nav>