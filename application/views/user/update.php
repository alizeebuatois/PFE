<?php
	$countriesList = $this->country_model->Country_getCountries();

	if (set_value('post'))
	{
		$email = set_value('email');
		$email_confirm = set_value('email_confirm');
		$address1 = set_value('address1');
		$address2 = set_value('address2');
		$postalcode = set_value('postalcode');
		$city = set_value('city');
		$country_id = set_value('country_id');
		$phone = set_value('phone');
		$user_key = set_value('user_key');
	}
	else if (isset($user))
	{
		$email = $user['user_email'];
		$email_confirm = $email;
		$address1 = $user['user_address1'];
		$address2 = $user['user_address2'];
		$postalcode = $user['user_postalcode'];
		$city = $user['user_city'];
		$country_id = $user['user_country_id'];
		$phone = $user['user_phone'];
		$user_key = $user['user_key'];	
	}
	else
	{
		show_404();
	}
?>

	<div class="row">
		<?php require_once('user-nav.php'); ?>
		<div class="columns large-9">
			<div class="panel">
				
				<h5>Modifier <small>Informations relatives au compte</small></h5><br />

				<?php if( validation_errors() != '' ): ?>
					<div class="row">
						<div class="columns large-12">
							<div data-alert class="alert-box warning radius">
								<?php echo validation_errors(); ?>
								<a href="#" class="close">&times;</a>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<form class="custom" method="post">
					<input type="hidden" name="post" value="1" />
					<input type="hidden" name="user_key" value="<?php echo $user_key; ?>" />

					<label for="newpassword">Nouveau mot de passe</label>
					<div class="row">
						<div class="columns large-6">
							<input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Mot de passe" />
						</div>
						<div class="columns large-6">
							<input type="password" class="form-control" id="newpassword" name="newpassword_confirm" placeholder="Confirmez le mot de passe" />
						</div>
					</div>

					<label for="email">Adresse e-mail</label>
					<div class="row">
						<div class="columns large-6">
							<input type="text" class="form-control" id="email" name="email" placeholder="Adresse e-mail" value="<?php echo $email; ?>" />
						</div>
						<div class="columns large-6">
							<input type="text" class="form-control" id="email" name="email_confirm" placeholder="Confirmez l'adresse e-mail" value="<?php echo $email_confirm; ?>" />
						</div>
					</div>
					
					<label for="address1">Adresse</label>		
					<div class="row">
						<div class="columns large-6">
							<input type="text" class="form-control span5" id="address1" name="address1" placeholder="Adresse" value="<?php echo $address1; ?>" />
						</div>
						<div class="columns large-6">
							<input type="text" class="form-control span5" id="address2" name="address2" placeholder="Complément d'adresse (facultatif)" value="<?php echo $address2; ?>" />
						</div>
					</div>
				 	
				 	<div class="row">
					 	<div class="columns large-2">
					 		<input type="text" class="form-control span2" id="postalcode" name="postalcode" placeholder="Code postal" value="<?php echo $postalcode; ?>" />
					 	</div>
					 	<div class="columns large-5">
					 		<input type="text" class="form-control span3" id="city" name="city" placeholder="Ville" value="<?php echo $city; ?>" />
					 	</div>
					 	<div class="columns large-5">
					 		<select name="country_id" id="country_id">
					 			<option value="0">Choisissez un pays</option>
					 			<?php 
					 				foreach($countriesList as $country)
					 				{
					 					echo '<option value="' . $country['country_id'] . '"';
					 					if ($country_id == $country['country_id']) echo ' selected="selected">';
					 					else echo '>';
					 					echo $country['country_label_fr'] . '</option>';
					 				}
					 			?>
					 		</select>
					 	</div>
				 	</div>
				 	
				 	<label for="phone">Téléphone</label>
				 	<div class="row">
				 		<div class="columns large-5">
				 			<input type="text" class="form-control" id="phone" name="phone" placeholder="Téléphone" value="<?php echo $phone; ?>" />
				 		</div>
				 	</div>	

				 	<!-- vspace -->
				 	<div style="height:30px"></div>
				 	
					<input type="submit" class="custom-button-class" value="Sauvegarder" />
					<a href="<?php echo site_url('compte'); ?>" class="custom-button-class">Annuler</a>
				</form>
			</div>
		</div>
	</div>

