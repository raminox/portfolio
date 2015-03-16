<div class="container">
<br>
<br>
<br>
	<div class="col-sm-8">
	<?php if (count($messages) > 0): ?>
		<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">Messages</div>
		<!-- Table -->
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Sender name</th>
					<th>E-mail</th>
					<th>Service</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($messages as $message): ?>
				<tr>
					<td><?=$message['sender_name'];?></td>
					<td><?=$message['sender_email'];?></td>
					<td><?=$message['service'];?></td>
					<td>
						<a href="message_remove.php?id=<?=$message['id'] . '&' . CSRF();?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez Vous Supprimer ? ')">Supprimer</a>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
	<?php else: ?>
		<div class="alert alert-danger" role="alert">Sorry there is no messages to display</div>
	<?php endif;?>
	</div>

</div>