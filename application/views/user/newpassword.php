<div class="row">
	<div class="columns large-5 large-centered medium-5 medium-centered">
	<?php if( validation_errors() != '' ): ?>
		<div class="row">
			<div class="columns large-12">
				<div data-alert class="alert-box alert radius">
					<?php echo validation_errors(); ?>
					<a href="#" class="close">&times;</a>
				</div>
			</div>
		</div>
	<?php endif; ?>

		<div class="panel radius">
			<h5>Votre nouveau mot de passe...</h5>
			<p><small>Choisissez votre nouveau mot de passe.</small></p>
			<form method="post" action="">
				<input type="password" name="newpassword" placeholder="Mot de passe" />
				<input type="password" name="newpassword_confirm" placeholder="Confirmation du mot de passe" />
				<input type="submit" class="custom-button-class small" value="Confirmer" />
			</form>
		</div>

	</div>
</div>