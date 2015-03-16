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
                update(['name' => $work_name, 'slug' => $work_slug, 'content' => $work_content, 'category_id' => $work_category_id], 'works', $work_id, $connection);
                setFlash("La realisation $work_name a ete modefie avec success");

            } else {

                $_GET['id'] = insert(['name' => $work_name, 'slug' => $work_slug, 'category_id' => $work_category_id, 'content' => $work_content], 'works', $connection);

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
                    insert(['work_id' => $work_id, 'name' => $image_name], 'images', $connection);
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

    $id   = (int) cleanString($_GET['id']);
    $work = select(['id', 'name', 'slug', 'content', 'category_id'], 'works', $connection, $id);

    if (count($work) == 0) {

        setFlash("La realisation Selectionne n'exesste pas", 'danger');
        header('Location: works.php');
        die();

    } else {

        $_POST = arrayConvert($work);
    }
}

/*-----  End Section Editing a work  ------*/

/*========================================================
=            Section for categories name list            =
========================================================*/
$categories = select(['id', 'name'], 'categories', $connection);

foreach ($categories as $category) {
    $categories_list[$category['id']] = $category['name'];
}

/*-----  End of Section for categories name list  ------*/

/**
 *  Suppression d'une image
 */
if (isset($_GET['delete_image'])) {

    checkCSRF();

    $image_id     = cleanString($_GET['delete_image']);
    $select_stmt  = select(['name', 'work_id'], 'images', $connection, $image_id);
    $select_image = arrayConvert($select_stmt);

    $selected_image = IMAGES_DIR . "/" . $select_image['name'];

    if (file_exists($selected_image)) {

        unlink($selected_image);

    }

    $images_thumbs = glob(IMAGES_DIR . "/" . pathinfo($select_image['name'], PATHINFO_FILENAME) . "_*x*.*");

    foreach ($images_thumbs as $image_thumb) {
        unlink($image_thumb);
    }

    delete('images', ['id' => $image_id], $connection);

    header('Location: work_edit.php?id=' . $select_image['work_id']);
    die();

}

/**
 * listing the images
 */

if (isset($_GET['id'])) {

    $work_id = (int) cleanString($_GET['id']);
    $images  = select(['id', 'name'], 'images', $connection, ['work_id' => $work_id]);

} else {
    $images = [];
}

/**
 * Hightlighting Image
 */

if (isset($_GET['highlight_image'])) {

    $work_id    = $_GET['id'];
    $image_id   = $_GET['highlight_image'];
    $hightlight = update(['image_id' => $image_id], 'works', $work_id, $connection);
    header('Location: work_edit.php?id=' . $work_id);
    die();

}

view('work_edit', $work = ['work' => $work, 'images' => $images, 'categories_list' => $categories_list]);
