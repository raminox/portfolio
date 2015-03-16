<div class="container">
	<br>
	<br>
	<br>
	<?=flash();?>
	<div class="row login-form">
		<div class="col-md-8 col-md-offset-2">
			<h4>Ajouter une nouvelle categorie</h4>
			<form action="#" method="POST">
				<div class="form-group">
					<label for="name">Nom du categorie :</label>
					<?=input('name')?>
				</div>
				<div class="form-group">
					<label for="slug">Le Slug du categorie :</label>
					<?=input('slug')?>
				</div>
				<button type="submit" class="btn btn-default">Enregestrer</button>
			</form>
		</div>
	</div>
</div>