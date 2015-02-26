<?php

include '../lib/functions.php';
include '../lib/auth.php';
include '../lib/db.php';
require '../lib/form.php';
require '../lib/session.php';

/*=============================================
=            Section adding a work            =
=============================================*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $work_name        = cleanString($_POST['name']);
    $work_slug        = cleanString($_POST['slug']);
    $work_content     = cleanString($_POST['content']);
    $work_category_id = (int) cleanString($_POST['category_id']);

    if (isset($work_name) && isset($work_slug) && isset($work_content)) {

        if (preg_match('/^[a-z\-0-9]+$/', $work_slug)) {

            if (isset($_GET['id'])) {

                $work_id = (int) $_GET['id'];
                $update  = 'UPDATE works SET
                name = :work_name ,
                slug = :work_slug,
                content = :work_content,
                category_id = :work_category_id WHERE id  = :id';
                $stmt = $connection->prepare($update);
                $stmt->bindValue(':work_name', $work_name, PDO::PARAM_STR);
                $stmt->bindValue(':work_slug', $work_slug, PDO::PARAM_STR);
                $stmt->bindValue(':work_content', $work_content, PDO::PARAM_STR);
                $stmt->bindValue(':work_category_id', (int) $work_category_id, PDO::PARAM_INT);
                $stmt->bindValue(':id', $work_id, PDO::PARAM_INT);
                $stmt->execute();
                setFlash("La realisation $work_name a ete modefie avec success");
                header('Location: works.php');
                die();

            } else {

                $insert = "INSERT INTO works SET name = :work_name , slug = :work_slug, category_id = :work_category_id, content = :work_content";
                $stmt   = $connection->prepare($insert);
                $stmt->bindValue(':work_name', $work_name, PDO::PARAM_STR);
                $stmt->bindValue(':work_slug', $work_slug, PDO::PARAM_STR);
                $stmt->bindValue(':work_category_id', $work_category_id, PDO::PARAM_STR);
                $stmt->bindValue(':work_content', $work_content, PDO::PARAM_STR);
                $stmt->execute();
                setFlash("La realisation $work_name a ete ajouter avec success");
                header('Location: works.php');
                die();

            }
        } else {
            setFlash("Le Slug m'est pas valide", 'danger');
        }
    }
}

/*-----  End of Section adding a work  ------*/

/*=============================================
=            Section editing a work            =
=============================================*/

if (isset($_GET['id'])) {

    $id   = cleanString($_GET['id']);
    $stmt = $connection->prepare("SELECT id, name, slug, content, category_id FROM works WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $result = $stmt->execute();

    $count = $stmt->rowCount();

    if ($count == 0) {
        setFlash("La realisation Selectionne n'exesste pas", 'danger');
        header('Location: works.php');
        die();
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $_POST  = $result;

}

/*-----  End Section Editing a work  ------*/

/*========================================================
=            Section for categories name list            =
========================================================*/

$select          = $connection->query("SELECT id, name FROM categories ORDER BY name ASC");
$categories      = $select->fetchAll();
$categories_list = [];
foreach ($categories as $category) {
    $categories_list[$category['id']] = $category['name'];
}
print_r($categories_list);

/*-----  End of Section for categories name list  ------*/

include 'template/header.php';

?>
<div class="container">
    <br>
    <br>
    <br>
    <?=flash();?>
    <div class="row login-form">
        <div class="col-md-8 col-md-offset-2">
            <h4>Ajouter une nouvelle realisation</h4>
            <form action="#" method="POST">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Nom du la resalisation :</label>
                        <?=input('name');?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="slug">URL de la realisation :</label>
                        <?=input('slug');?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="categoty_id">La categorie :</label>
                        <?=selectInput('category_id', $categories_list);?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="slug">Le Contenu du la realisation :</label>
                    <?=input('content', 'textarea');?>
                </div>
                <button type="submit" class="btn btn-default">Enregestrer</button>
            </form>
        </div>
    </div>
</div>


<!-- <script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="../js/editor-config.js"></script> -->
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>
<?php
include 'template/footer.php';
?>