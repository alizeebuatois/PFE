<?php
	$countriesList = $this->country_model->Country_getAllCountries();

	if (set_value('post'))
	{
		$title = set_value('title');
		$firstname = set_value('firstname');
		$lastname = set_value('lastname');
		$type = set_value('type');
		$birthdate = set_value('birthdate');
		$birthcity = set_value('birthcity');
		$birth_country_id = set_value('birth_country_id');
		$address1 = set_value('address1');
		$address2 = set_value('address2');
		$postalcode = set_value('postalcode');
		$city = set_value('city');
		$country_id = set_value('country_id');
		$phone = set_value('phone');
		$user_right = set_value('user_right');
		$email = set_value('email');
		$email_confirm = set_value('email_confirm');
	}
	else
	{
		$title = 'Dr.';
		$firstname = '';
		$lastname = '';
		$type = 0;
		$birthdate = '';
		$birthcity = '';
		$birth_country_id = 0;
		$address1 = '';
		$address2 = '';
		$postalcode = '';
		$city = '';
		$country_id = 0;
		$phone = '';
		$user_right = 1;
		$email = '';
		$email_confirm = '';
	}

?>
<div class="row">
	<?php require_once(__DIR__.'/../backend-nav.php'); ?>
	<div class="columns large-9">
		<div class="panel radius">
			<h5>Nouveau médecin</h5>
			<?php if (validation_errors() != ''): ?>
			<div class="row">
				<div class="columns large-12">
					<div data-alert class="alert-box warning radius">
						<?php echo validation_errors(); ?>
						<a href="#" class="close">&times;</a>
					</div>
				</div>
			</div>
			<?php endif; ?>

			<form action="<?php echo site_url('doctor/create'); ?>" method="post">
				<input type="hidden" name="post" value="1" />

				<div class="row">
					<div class="columns large-4"><p class="right">Civilité*</p></div>
					<div class="columns large-2 end">
						<select name="title">
						<?php
							$civilites = array('Dr.', 'Pr.', 'Mme.', 'Mlle.', 'M.');
							foreach ($civilites as $civilite)
							{
								echo '<option value="' . $civilite . '" ';
								if ($title == $civilite)
									echo 'selected="selected"';
								echo '>';
								echo $civilite;
								echo '</option>';
							}    
						?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="columns large-4"><p class="right">Nom*</p></div>
					<div class="columns large-5 end"><input type="text" name="lastname" placeholder="Nom" value="<?php echo $lastname; ?>" /></div>
				</div>

				<div class="row">
					<div class="columns large-4"><p class="right">Prénom*</p></div>
					<div class="columns large-5 end"><input type="text" name="firstname" placeholder="Prénom" value="<?php echo $firstname; ?>" /></div>
				</div>

				<div class="row">
					<div class="columns large-4"><p class="right">Fonction*</p></div>
					<div class="columns large-3">
						<select name="type">
						<?php
							$fonctions = array();
							if ($this->session->userdata('user_right') == 3)
								array_push($fonctions, array('id' => 0, 'name' => 'Secrétaire'));
							array_push($fonctions, array('id' => 1, 'name' => 'Infirmière'));
							array_push($fonctions, array('id' => 2, 'name' => 'Médecin'));
							foreach ($fonctions as $fonction)
							{
								echo '<option value="' . $fonction['id'] . '" ';
								if ($type == $fonction['id'])
									echo 'selected="selected"';
								echo '>';
								echo $fonction['name'];
								echo '</option>';
							}    
						?>
						</select>
					</div>
					<div class="columns large-4 end">
						<p style="line-height:35px;">
							<span data-tooltip class="has-tip" title="Secrétaire : <br />Infirmière : <br />Médecin : ">?</span>
						</p>
					</div>
				</div>

				<?php if ($this->session->userdata('user_right') == 3): ?>
				<div class="row">
					<div class="columns large-4"><p class="right">Droits d'accès*</p></div>
					<div class="columns large-4">
						<select name="user_right">
						<?php
							$rights = array();
							array_push($rights, array('id' => 1, 'name' => 'Personnel de soin'));
							array_push($rights, array('id' => 2, 'name' => 'Secrétaire'));
							array_push($rights, array('id' => 3, 'name' => 'Administrateur'));
							foreach ($rights as $right)
							{
								echo '<option value="' . $right['id'] . '" ';
								if ($user_right == $right['id'])
									echo 'selected="selected"';
								echo '>';
								echo $right['name'];
								echo '</option>';
							}    
						?>
						</select>
					</div>
					<div class="columns large-4">
						<p style="line-height:35px;">
							<span data-tooltip class="has-tip" title="Personnel de soin : <br />Secrétaire : <br />Administrateur : ">?</span>
						</p>
					</div>
				</div>
				<?php else: ?>
				<input type="hidden" name="user_right" value="1" />
				<?php endif; ?>

				<div class="row">
					<div class="columns large-4">&nbsp;</div>
					<div class="columns large-6 end">
						<label for="birth-checkbox"><input type="checkbox" id="birth-checkbox" name="birth" value="yes" onclick="birthPart();" />&nbsp; Date et lieu de naissance</label>
					</div>
				</div>
				<div id="birth" class="hide">
					<div class="row">
						<div class="columns large-4"><p class="right">Date de naissance</p></div>
						<div class="columns large-4"><input type="text" name="birthdate" placeholder="Date de naissance" id="newdoctordate" value="<?php echo set_value('birthdate'); ?>" /></div>
						<div class="columns large-4 medium-hide"><p><small>Format : AAAA-MM-JJ</small></p></div>
					</div>
					<div class="row">
						<div class="columns large-4"><p class="right">Ville de naissance</p></div>
						<div class="columns large-5 end"><input type="text" name="birthcity" placeholder="Ville de naissance" value="<?php echo $birthcity; ?>" /></div>
					</div>
					<div class="row">
						<div class="columns large-4"><p class="right">Pays de naissance</p></div>
						<div class="columns large-5 end">
							<select name="birth_country_id" id="birth_country_id">
								<option value="0">Pays</option>
						 			<?php 
						 				foreach($countriesList as $country)
						 				{
						 					echo '<option value="' . $country['country_id'] . '" ';
						 					if ($birth_country_id == $country['country_id'])
						 						echo 'selected="selected"';
						 					echo '>';
						 					echo $country['country_label_fr'] . '</option>';
						 				}
						 			?>
							</select>
						</div>
					</div>
				</div>	

				<div class="row">
					<div class="columns large-4">&nbsp;</div>
					<div class="columns large-6 end">
						<label for="address-checkbox"><input type="checkbox" id="address-checkbox" name="address" value="yes" onclick="addressPart();" />&nbsp; Adresse postale</label>
					</div>
				</div>
				<div id="address" class="hide">
					<div class="row">
						<div class="columns large-4"><p class="right">Adresse</p></div>
						<div class="columns large-6 end"><input type="text" name="address1" placeholder="Adresse" value="<?php echo $address1; ?>" /></div>
					</div>
					<div class="row">
						<div class="columns large-4"><p class="right">Complément d'adresse</p></div>
						<div class="columns large-6 end"><input type="text" name="address2" placeholder="Complément adresse" value="<?php echo $address2; ?>" /></div>
					</div>
					<div class="row">
						<div class="columns large-4"><p class="right">Code postal</p></div>
						<div class="columns large-3 end"><input type="text" name="postalcode" placeholder="Code postal" value="<?php echo $postalcode; ?>" /></div>
					</div>
					<div class="row">
						<div class="columns large-4"><p class="right">Ville</p></div>
						<div class="columns large-5 end"><input type="text" name="city" placeholder="Ville" value="<?php echo $city; ?>" /></div>
					</div>
					<div class="row">
						<div class="columns large-4"><p class="right">Pays</p></div>
						<div class="columns large-5 end">
							<select name="country_id" id="country_id">
									<option value="0">Pays</option>
						 			<?php 
						 				foreach($countriesList as $country)
						 				{
						 					echo '<option value="' . $country['country_id'] . '" ';
						 					if ($country_id == $country['country_id'])
						 						echo 'selected="selected"';
						 					echo '>';
						 					echo $country['country_label_fr'] . '</option>';
						 				}
						 			?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="columns large-4">&nbsp;</div>
					<div class="columns large-6 end">
						<label for="contact-checkbox"><input type="checkbox" id="contact-checkbox" name="contact" value="yes" onclick="contactPart();" />&nbsp; Contact</label>
					</div>
				</div>
				<div id="contact" class="hide">
					<div class="row">
						<div class="columns large-4"><p class="right">Adresse e-mail</p></div>
						<div class="columns large-6 end"><input type="text" name="email" placeholder="Adresse e-mail" value="<?php echo $email; ?>" /></div>
					</div>
					<div class="row">
						<div class="columns large-4"><p class="right">Confirmation e-mail</p></div>
						<div class="columns large-6 end"><input type="text" name="email_confirm" placeholder="Confirmation" value="<?php echo $email_confirm; ?>" /></div>
					</div>
					<div class="row">
						<div class="columns large-4"><p class="right">Téléphone</p></div>
						<div class="columns large-4 end"><input type="text" name="phone" placeholder="Téléphone" value="<?php echo $phone; ?>" /></div>
					</div>
				</div>

				<div class="row">
					<div class="columns">
						<input type="submit" class="custom-button-class" value="Terminer" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="<?php echo js_url('cvi/doctor'); ?>"></script>
<script>
	$(document).ready(function() {
		$('#newdoctordate').fdatepicker({
			format: 'yyyy-mm-dd'
		});
	});

	function birthPart() {
		if ($('#birth-checkbox').is(':checked'))
			$('#birth').show();
		else
			$('#birth').hide();
	}
	function addressPart() {
		if ($('#address-checkbox').is(':checked'))
			$('#address').show();
		else
			$('#address').hide();
	}
	function contactPart() {
		if ($('#contact-checkbox').is(':checked'))
			$('#contact').show();
		else
			$('#contact').hide();
	}
</script>
