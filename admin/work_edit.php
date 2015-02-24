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
    $work_name    = cleanString($_POST['name']);
    $work_slug    = cleanString($_POST['slug']);
    $work_content = cleanString($_POST['content']);
    if (isset($work_name) && isset($work_slug) && isset($work_content)) {

        if (preg_match('/^[a-z\-0-9]+$/', $work_slug)) {
            if (isset($_GET['id'])) {

                $work_id = $_GET['id'];
                $stmt    = $connection->prepare("UPDATE works SET name = :work_name , slug = :work_slug, content = :work_content WHERE id = :id");
                $stmt->bindValue(':id', $work_id, PDO::PARAM_INT);
                $stmt->bindValue(':work_name', $work_name, PDO::PARAM_STR);
                $stmt->bindValue(':work_slug', $work_slug, PDO::PARAM_STR);
                $stmt->execute();
                setFlash("La realisation $work_name a ete modefie avec success");
                header('Location: works.php');
                die();

            } else {
                $stmt = $connection->prepare("INSERT INTO works SET name = :work_name , slug = :work_slug, content = :work_content");
                $stmt->bindValue(':work_name', $work_name, PDO::PARAM_STR);
                $stmt->bindValue(':work_slug', $work_slug, PDO::PARAM_STR);
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
    $stmt = $connection->prepare("SELECT id, name, slug, content FROM works WHERE id = :id");
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nom du la resalisation :</label>
                        <?=input('name');?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="slug">URL de la realisation :</label>
                        <?=input('slug');?>
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


<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="../js/editor-config.js"></script>

<?php
include 'template/footer.php';
?>