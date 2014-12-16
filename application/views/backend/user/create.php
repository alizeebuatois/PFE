<?php
	$countriesList = $this->country_model->Country_getAllCountries();
?>

<div class="row">
	<?php require_once(__DIR__.'/../backend-nav.php'); ?>
	<div class="columns large-9">
		<div class="panel radius">
			<h5>Nouveau compte</h5>
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

			<form action="<?php echo site_url('user/create'); ?>" method="post">
				<input type="hidden" name="post" value="1" />

			
			<div class="row">
				<div class="columns large-4"><p class="right">Civilité*</p></div>
				<div class="columns large-2 end">
					<select name="title" class="span2">
					<?php
						$civilites = array('Mme.', 'Mlle.', 'M.');
						foreach ($civilites as $civilite)
						{
							echo '<option value="' . $civilite . '" ';
							if (set_value('title') == $civilite) echo 'selected="selected"';
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
				<div class="columns large-5 end"><input type="text" name="lastname" placeholder="Nom" value="<?php echo set_value('lastname'); ?>" /></div>
			</div>
			<div class="row">
				<div class="columns large-4"><p class="right">Prénom*</p></div>
				<div class="columns large-5 end"><input type="text" name="firstname" placeholder="Prénom" value="<?php echo set_value('firstname'); ?>" /></div>
			</div>
			<div class="row">
				<div class="columns large-4"><p class="right">Date de naissance*</p></div>
				<div class="columns large-4"><input type="text" name="birthdate" placeholder="Date de naissance" id="newprofiledate" value="<?php echo set_value('birthdate'); ?>" /></div>
				<div class="columns large-4 medium-hide"><p><small>Format : AAAA-MM-JJ</small></p></div>
			</div>

			<div class="row">
				<div class="columns large-4">&nbsp;</div>
				<div class="columns large-6 end">
					<label for="birthplace-checkbox"><input type="checkbox" id="birthplace-checkbox" name="birthplace" value="yes" onclick="birthplacePart();" />&nbsp; Lieu de naissance</label>
				</div>
			</div>
			<div id="birthplace" class="hide">
				<div class="row">
					<div class="columns large-4"><p class="right">Commune de naissance</p></div>
					<div class="columns large-6 end"><input type="text" name="birth_city" placeholder="Commune de naissance" value="<?php echo set_value('birth_city'); ?>" /></div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">Pays de naissance</p></div>
					<div class="columns large-5 end">
						<select name="birth_country_id" id="birth_country_id">
							<option value="0">Pays</option>
			 			<?php 
			 				foreach($countriesList as $country)
			 				{
			 					echo '<option value="' . $country['country_id'] . '"';
			 					if (set_value('birth_country_id') == $country['country_id']) echo ' selected="selected">';
			 					else echo '>';
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
					<label for="address-checkbox"><input type="checkbox" id="address-checkbox" name="address" onclick="addressPart();" />&nbsp; Adresse postale</label>
				</div>
			</div>
			<div id="address" class="hide">
				<div class="row">
					<div class="columns large-4"><p class="right">Adresse</p></div>
					<div class="columns large-6 end"><input type="text" name="address1" placeholder="Adresse" value="<?php echo set_value('address1'); ?>" /></div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">Complément d'adresse</p></div>
					<div class="columns large-6 end"><input type="text" name="address2" placeholder="Complément adresse" value="<?php echo set_value('address2'); ?>" /></div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">Code postal</p></div>
					<div class="columns large-3 end"><input type="text" name="postalcode" placeholder="Code postal" value="<?php echo set_value('postalcode'); ?>" /></div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">Ville</p></div>
					<div class="columns large-6 end"><input type="text" name="city" placeholder="Ville" value="<?php echo set_value('city'); ?>" /></div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">Pays</p></div>
					<div class="columns large-5 end">
						<select name="country_id" id="country_id">
							<option value="0">Pays</option>
			 			<?php 
			 				foreach($countriesList as $country)
			 				{
			 					echo '<option value="' . $country['country_id'] . '"';
			 					if (set_value('country_id') == $country['country_id']) echo ' selected="selected">';
			 					else echo '>';
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
					<label for="contact-checkbox"><input type="checkbox" id="contact-checkbox" name="contact" checked="checked" onclick="contactPart();" />&nbsp; Contact</label>
				</div>
			</div>
			<div id="contact">
				<div class="row">
					<div class="columns large-4"><p class="right">Adresse e-mail</p></div>
					<div class="columns large-6 end"><input type="text" name="email" placeholder="Adresse e-mail" value="<?php echo set_value('email'); ?>" /></div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">Confirmation e-mail</p></div>
					<div class="columns large-6 end"><input type="text" name="email_confirm" placeholder="Confirmation e-mail" value="<?php echo set_value('email_confirm'); ?>" /></div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">Téléphone</p></div>
					<div class="columns large-4 end"><input type="text" name="phone" placeholder="Numéro de téléphone" value="<?php echo set_value('phone'); ?>" /></div>
				</div>
			</div>

			<div class="row">
				<div class="columns large-12">
					<label for="activate-id"><input type="checkbox" name="activate" id="activate-id" checked="checked" /> Auto-activation</label>
					<input type="submit" value="Terminer" class="custom-button-class" />

				</div>
			</div>

			</form>

		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#newprofiledate').fdatepicker({
			format: 'yyyy-mm-dd'
		});
	});

	function contactPart() {
		if ($('#contact-checkbox').is(':checked'))
			$('#contact').show();
		else
			$('#contact').hide();
	}
	function addressPart() {
		if ($('#address-checkbox').is(':checked'))
			$('#address').show();
		else
			$('#address').hide();
	}
	function birthplacePart() {
		if ($('#birthplace-checkbox').is(':checked'))
			$('#birthplace').show();
		else
			$('#birthplace').hide();
	}
</script>
