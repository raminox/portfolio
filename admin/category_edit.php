<?php

include '../lib/functions.php';
include '../lib/auth.php';
include '../lib/db.php';
require '../lib/form.php';
require '../lib/constants.php';
require '../lib/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $category_name = cleanString($_POST['name']);
    $category_slug = cleanString($_POST['slug']);

    if (isset($category_name) && isset($category_slug)) {

        if (preg_match('/^[a-z\-0-9]+$/', $category_slug)) {

            if (isset($_GET['id'])) {

                $category_id = (int) cleanString($_GET['id']);
                update(['name' => $category_name, 'slug' => $category_slug], 'categories', $category_id, $connection);
                setFlash("La categorie $category_name a ete modefie avec success");
                header('Location: categories.php');
                die();

            } else {

                insert(['name' => $category_name, 'slug' => $category_slug], 'categories', $connection);

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

    $id     = (int) cleanString($_GET['id']);
    $result = select(['id', 'name', 'slug'], 'categories', $connection, $id);

    if (count($result) == 0) {
        setFlash("La Categoriec Selectionne n'exesste pas", 'danger');
        header('Location: categories.php');
        die();
    }

    $_POST = arrayConvert($result);

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