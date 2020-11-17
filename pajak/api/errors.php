<?php  if(count($errors) > 0) : ?>
	<div class="error">
		<h4><i class="fas fa-exclamation-triangle" style="color: white"></i> Warning</h4>
		<?php foreach ($errors as $error) : ?>
			<p><?php echo $error ?></p>
		<?php endforeach ?>
		<p class="mb-20"></p>
	</div>
<?php  endif ?>