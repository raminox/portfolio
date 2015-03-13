<?php

session_start();

require_once 'lib/db.php';
require_once 'lib/constants.php';
require_once 'lib/image.php';

$select = $connection->query(
    "SELECT  works.id, works.name, works.slug, images.name
	AS image_name FROM works LEFT JOIN images
	ON images.id = works.image_id"
);
$select->execute();
$works = $select->fetchAll();

require_once 'partials/header.php';

?>

<div class="container">
<h1>Keep Learning ...</h1>
<div class="row">
	<div class="col-md-12">
	<?php foreach ($works as $key => $work): ?>
		<article>
		<img src="works/images/<?=resizedName($work['image_name'])?>" alt="">

			<a href="realisation/<?=$work['slug']?>"><?=$work['name']?></a>
		</article>
	<?php endforeach;?>

	</div>
</div>

</div>

<!-- End .container -->
