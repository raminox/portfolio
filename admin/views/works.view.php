<div class="container">
	<br>
	<br>
	<br>
	<br>
<?=flash();?>
	<p><a href="work_edit.php" class="btn btn-success">Ajouter une nouvelle réalisation</a></p>
	<?php if (count($works)): ?>
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
	<?php else: ?>
		<div class="alert alert-danger" role="alert">Sorry there is no realizations to display</div>
	<?php endif;?>
</div>