<?php

require_once 'lib/db.php';
require_once 'lib/constants.php';
require_once 'lib/functions.php';

$slug = $_GET['slug'];

if (isset($slug)) {

    /**
     * Select the work
     */

    $work = select('*', 'works', $connection, ['slug' => $slug]);
    $work = arrayConvert($work);
    var_dump($work);

    if (count($work) == 0) {

        header("HTTP/1.1 301 Moved Permanently");
        header("Location : ../index.php");

    }

    $work_id = $work['id'];

    /**
     * Select the images
     */
    $images = select('*', 'images', $connection, ['work_id' => $work_id]);

    var_dump($images);

} else {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location : index.php");
}

require_once 'partials/header.php';
?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<article>
				<h1><?=$work['name'];?></h1>
				<p>
					<?=htmlspecialchars_decode($work['content']);?>
				</p>
				<?php foreach ($images as $key => $image): ?>
				<img src="<?="../works/images/" . $image['name']?>" class="img-responsive img-rounded" alt="Responsive image">
			<?php endforeach;?>
			</article>
		</div>
	</div>
</div>












<?php require_once 'partials/footer.php';?>