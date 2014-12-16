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
			<h5>Récupération de mot de passe...</h5>
			<p><small>Pour obtenir un nouveau mot de passe, merci de nous renseigner votre adresse e-mail.</small></p>
			<form method="post" action="">
				<input type="text" name="email" placeholder="Adresse e-mail" value="<?php echo set_value('email'); ?>" />
				<input type="submit" class="custom-button-class small" value="Valider" />
			</form>
		</div>

	</div>
</div>