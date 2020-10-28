<?php  if(count($errors) > 0) : ?>
	<div>
		<?php foreach ($errors as $error) : ?>
			<p class="error-msg"><?php echo $error ?></p>
		<?php endforeach ?>
	</div>
<?php  endif ?>