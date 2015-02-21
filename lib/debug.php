<div class="row">
	<div class="col-sm-4">
		<h1>Debug Server</h1>
		<?php var_dump($_SERVER)?>
	</div>
	<div class="col-sm-4">
		<h1>Debug Constants</h1>
		<?php var_dump(get_defined_constants())?>
	</div>
	<div class="col-sm-4">
		<h1>Debug SESSION</h1>
		<?php var_dump($_SESSION)?>
	</div>
</div>