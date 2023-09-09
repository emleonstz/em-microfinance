<?php if (!empty($errors)) : ?>
	<div class="errors" role="alert">

		<?php foreach ($errors as $error) : ?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong><i class="fa fa-exclamation-triangle"></i></strong> <?= esc($error) ?>.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endforeach ?>

	</div>
<?php endif ?>