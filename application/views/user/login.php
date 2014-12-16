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
			<h5>Connectez-vous...</h5>
			<form method="post" action="<?php site_url('login'); ?>">
				<input type="text" name="login" placeholder="Nom d'utilisateur ou adresse e-mail" value="<?php echo set_value('login'); ?>" />
				<input type="password" name="password" placeholder="Mot de passe" />
				<label for="remember"><input type="checkbox" name="remember" value="yes" id="remember" /> Se souvenir de moi</label>
				<div class="row">
					<div class="columns large-5">
						<input type="submit" class="custom-button-class small" value="Connexion" />
					</div>
					<div class="columns large-7 text-right">
						<small><a href="<?php echo site_url('inscription'); ?>">Pas encore de compte ?</a><br /><a href="<?php echo site_url('user/password'); ?>">Mot de passe oublié ?</a></small>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>