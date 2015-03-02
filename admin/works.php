<?php

include '../lib/auth.php';
include '../lib/functions.php';
include '../lib/db.php';
require '../lib/session.php';
require '../lib/constants.php';

$result = $connection->query("SELECT id, name, slug FROM works");
$works  = $result->fetchAll();

generateCSRF();

include 'template/header.php';
?>


<div class="container">
	<br>
	<br>
	<br>
	<br>
<?=flash();?>
	<p><a href="work_edit.php" class="btn btn-success">Ajouter une nouvelle réalisation</a></p>
	<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">Les works :</div>
		<!-- Table -->
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Nom</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($works as $work): ?>
				<tr>
					<td><?=$work['id'];?></td>
					<td><?=$work['name'];?></td>
					<td>
						<a href="work_edit.php?id=<?=$work['id'];?>" class="btn btn-sm btn-primary">Editer</a>
						<a href="work_remove.php?id=<?=$work['id'] . '&' . CSRF();?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez Vous Supprimer ? ')">Supprimer</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>


<?php include '../partials/footer.php';?>
