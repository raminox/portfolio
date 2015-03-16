<div class="container">
	<br>
	<br>
	<br>
	<br>
<?=flash();?>
	<p><a href="category_edit.php" class="btn btn-success">Ajouter une nouvelle categorie</a></p>

		<?php if (count($categories)): ?>
			<div class="panel panel-default">
		<!-- Default panel contents -->
			<div class="panel-heading">Les Categories :</div>
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
				<?php foreach ($categories as $category): ?>
				<tr>
					<td><?=$category['id'];?></td>
					<td><?=$category['name'];?></td>
					<td>
						<a href="category_edit.php?id=<?=$category['id'];?>" class="btn btn-sm btn-primary">Editer</a>
						<a href="category_remove.php?id=<?=$category['id'] . '&' . CSRF();?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez Vous Supprimer ? ')">Supprimer</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	<?php else: ?>
<div class="alert alert-danger" role="alert">Sorry there is no categories to display</div>
	<?php endif;?>
	</div>
</div>