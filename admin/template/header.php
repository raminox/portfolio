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
				<p class="navbar-text pull-right">Signed in as </p>
				<div class="dropdown">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
					<strong class="user-flag"><?=ucfirst($_SESSION['username']);?></strong>
					<span class="caret"></span>
					</button>
					<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
						<li role="presentation">
							<a role="menuitem" tabindex="-1" href="#">Action</a>
						</li>
					</ul>
				</div>

				<ul class="nav navbar-nav navbar-left">
					<li><a href="<?=WEB_ROOT;?>">Home</a></li>
					<li><a href="#about">About</a></li>
					<li><a href="#contact">Contact</a></li>
					<li><a href="<?=WEB_ROOT;?>admin/categories.php">Categories</a></li>
					<li><a href="<?=WEB_ROOT;?>admin/works.php">Realisation</a></li>
				</ul>
			</div>
		</div>
	</nav>