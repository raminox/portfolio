<?php

require_once '../lib/functions.php';
require_once '../lib/auth.php';
require_once '../lib/db.php';
require_once '../lib/form.php';
require_once '../lib/session.php';
require_once '../lib/constants.php';

/*=============================================
=            Section adding a work            =
=============================================*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $work_name        = cleanString($_POST['name']);
    $work_slug        = cleanString($_POST['slug']);
    $work_content     = $_POST['content'];
    $work_category_id = (int) cleanString($_POST['category_id']);

    if (isset($work_name) && isset($work_slug) && isset($work_content)) {

        if (preg_match('/^[a-z\-0-9]+$/', $work_slug)) {

            if (isset($_GET['id'])) {

                $work_id = (int) $_GET['id'];
                $update  = 'UPDATE works SET name = :work_name, slug = :work_slug, content = :work_content, category_id = :work_category_id WHERE id  = :id';
                $stmt    = $connection->prepare($update);
                $stmt->bindValue(':work_name', $work_name, PDO::PARAM_STR);
                $stmt->bindValue(':work_slug', $work_slug, PDO::PARAM_STR);
                $stmt->bindValue(':work_content', $work_content, PDO::PARAM_STR);
                $stmt->bindValue(':work_category_id', $work_category_id, PDO::PARAM_INT);
                $stmt->bindValue(':id', $work_id, PDO::PARAM_INT);
                $stmt->execute();

                setFlash("La realisation $work_name a ete modefie avec success");

            } else {

                $insert = "INSERT INTO works SET name = :work_name , slug = :work_slug, category_id = :work_category_id, content = :work_content";
                $stmt   = $connection->prepare($insert);
                $stmt->bindValue(':work_name', $work_name, PDO::PARAM_STR);
                $stmt->bindValue(':work_slug', $work_slug, PDO::PARAM_STR);
                $stmt->bindValue(':work_category_id', $work_category_id, PDO::PARAM_STR);
                $stmt->bindValue(':work_content', $work_content, PDO::PARAM_STR);
                $stmt->execute();
                $_GET['id'] = $connection->lastInsertId();
            }

            setFlash("La realisation $work_name a ete ajouter avec success");
            /* Envoi des images */

            require_once '../lib/image.php';

            $work_id     = $_GET['id'];
            $files       = $_FILES['work_images'];
            $work_images = [];

            foreach ($files['tmp_name'] as $key => $value) {
                $work_image = [
                    'name'     => $files['name'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                ];
                $extension      = pathinfo($work_image['name'], PATHINFO_EXTENSION);
                $extension_list = ['jpg', 'jpeg', 'png'];
                if (in_array($extension, $extension_list)) {
                    $image_name = rand() . '_' . $work_id . '_IMG.' . $extension;
                    $stmt       = $connection->prepare('INSERT INTO images SET work_id = :work_id, name = :image_name');
                    $stmt->bindValue(':work_id', $work_id, PDO::PARAM_INT);
                    $stmt->bindValue(':image_name', $image_name, PDO::PARAM_STR);
                    $stmt->execute();
                    move_uploaded_file($work_image['tmp_name'], IMAGES_DIR . "/" . $image_name);

                    resizeImage(IMAGES_DIR . "/" . $image_name, 150, 150);
                }
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
    $count  = $stmt->rowCount();

    if ($count == 0) {

        setFlash("La realisation Selectionne n'exesste pas", 'danger');
        header('Location: works.php');
        die();

    } else {

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $_POST  = $result;
    }
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
/*-----  End of Section for categories name list  ------*/

/**
 *  Suppression d'une image
 */
if (isset($_GET['delete_image'])) {

    checkCSRF();

    $image_id = cleanString($_GET['delete_image']);

    $select_stmt = $connection->prepare("SELECT name, work_id FROM images WHERE id = :image_id");
    $select_stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
    $select_stmt->execute();
    $select_image = $select_stmt->fetch();

    $selected_image = IMAGES_DIR . "/" . $select_image['name'];

    if (file_exists($selected_image)) {

        unlink($selected_image);

    }

    $images_thumbs = glob(IMAGES_DIR . "/" . pathinfo($select_image['name'], PATHINFO_FILENAME) . "_*x*.*");

    foreach ($images_thumbs as $image_thumb) {
        unlink($image_thumb);
    }

    $stmt = $connection->prepare("DELETE FROM images WHERE id = :image_id");
    $stmt->bindValue(':image_id', $image_id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: work_edit.php?id=' . $select_image['work_id']);
    die();

}

/**
 * listing the images
 */

if (isset($_GET['id'])) {

    $work_id = cleanString($_GET['id']);
    $stmt    = $connection->prepare("SELECT id, name FROM images WHERE work_id = :work_id");
    $stmt->bindValue(':work_id', $work_id, PDO::PARAM_INT);
    $stmt->execute();
    $images = $stmt->fetchAll();

} else {
    $images = [];
}

/**
 * Hightlighting Image
 */

if (isset($_GET['highlight_image'])) {

    $work_id  = $_GET['id'];
    $image_id = $_GET['highlight_image'];

    $hightlight = $connection->prepare('UPDATE works SET image_id = :image_id WHERE id = :work_id');
    $hightlight->bindValue(':image_id', $image_id, PDO::PARAM_INT);
    $hightlight->bindValue(':work_id', $work_id, PDO::PARAM_INT);
    $hightlight->execute();
    header('Location: work_edit.php?id=' . $work_id);
    die();

}

require_once 'template/header.php';
?>
<div class="container">
    <br>
    <br>
    <br>
    <?=flash();?>
    <div class="row login-form">
        <h4>Ajouter une nouvelle realisation</h4>
        <div class="col-sm-8">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name">Nom du la resalisation :</label>
                        <?=input('name');?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="slug">URL de la realisation :</label>
                        <?=input('slug');?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="categoty_id">La categorie :</label>
                        <?=selectInput('category_id', $categories_list);?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="slug">Le Contenu du la realisation :</label>
                    <?=input('content', 'textarea');?>
                </div>
                <div class="form-group">
                    <?=input('work_images[]', 'file');?>
                    <input type="file" name="work_images[]"class="hidden form-control" id="copyinput">
                </div>
                <div class="form-group">
                    <p><a href="#" class="btn btn-success" id="copybtn">Ajouter une image</a></p>
                    <button type="submit" class="btn btn-default">Enregestrer</button>
                </div>
            </form>
        </div>
        <div class="col-sm-4">
            <?php foreach ($images as $key => $image): ?>
            <div class="col-xs-4 thumbnail">
                <img src="<?=WEB_ROOT . "/works/images/" . $image['name'];?>" alt="Photo de realisation">
                <ul class="pager">
                    <li>
                        <a href="?delete_image=<?=$image['id'] . "&" . CSRF()?>" onclick= "return confirm('Vous voulez vraimment de supprimer l\'image')">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true" class="previous"></span>
                        </a>
                    </li>
                    <li>
                        <a href="?highlight_image=<?=$image['id'] . '&id=' . $_GET['id'] . "&" . CSRF();?>"><span class="glyphicon glyphicon-bookmark" aria-hidden="true" class="next"></span></a>
                    </li>
                </ul>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
(function($){
$('#copybtn').click(function(e) {
e.preventDefault();
var $clone = $('#copyinput').clone().attr('id', '').removeClass('hidden');
$('#copyinput').before($clone);
});
})(jQuery);
tinymce.init({selector:'textarea'});
</script>
