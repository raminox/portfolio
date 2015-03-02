<?php

include '../lib/functions.php';
include '../lib/auth.php';
include '../lib/db.php';
require '../lib/form.php';
require '../lib/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$category_name = cleanString($_POST['name']);
	$category_slug = cleanString($_POST['slug']);

	if (isset($category_name) && isset($category_slug)) {

		if (preg_match('/^[a-z\-0-9]+$/', $category_slug)) {

			if (isset($_GET['id'])) {
				$category_id = $_GET['id'];
				$stmt = $connection->prepare("UPDATE categories SET name=:category_name , slug=:category_slug WHERE id=:id");
				$stmt->bindValue(':id', $category_id, PDO::PARAM_INT);
				$stmt->bindValue(':category_name', $category_name, PDO::PARAM_STR);
				$stmt->bindValue(':category_slug', $category_slug, PDO::PARAM_STR);
				$stmt->execute();
				setFlash("La categorie $category_name a ete modefie avec success");
				header('Location: categories.php');
				die();
			} else {

				$stmt = $connection->prepare("INSERT INTO categories SET name = :category_name , slug = :category_slug");
				$stmt->bindValue(':category_name', $category_name, PDO::PARAM_STR);
				$stmt->bindValue(':category_slug', $category_slug, PDO::PARAM_STR);
				$stmt->execute();

				setFlash("La categorie $category_name a ete ajouter avec success");
				header('Location: categories.php');
				die();
			}
		} else {
			setFlash("Le Slug m'est pas valide", 'danger');
		}

	}
}

if (isset($_GET['id'])) {

	$id = cleanString($_GET['id']);
	$stmt = $connection->prepare("SELECT id, name, slug FROM categories WHERE id = :id");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$result = $stmt->execute();

	$count = $stmt->rowCount();

	if ($count == 0) {
		setFlash("La Categoriec Selectionne n'exesste pas", 'danger');
		header('Location: categories.php');
		die();
	}

	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$_POST = $result;

}

include 'template/header.php';

?>
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
						<div class="form-group">
							<label for="slug">Le Slug du categorie :</label>
							<?=input('slug')?>
						</div>
						<button type="submit" class="btn btn-default">Enregestrer</button>
					</form>
                    <?php include '../lib/debug.php';?>
</div>
<?php
include '../partials/footer.php';
?>