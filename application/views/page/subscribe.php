<?php
	$countriesList = $this->country_model->Country_getAllCountries(); 
	$mois = array(
		array(
			'month_id' => '01',
			'month_label' => 'Janvier'),
		array(
			'month_id' => '02',
			'month_label' => 'Février'),
		array(
			'month_id' => '03',
			'month_label' => 'Mars'),
		array(
			'month_id' => '04',
			'month_label' => 'Avril'),
		array(
			'month_id' => '05',
			'month_label' => 'Mai'),
		array(
			'month_id' => '06',
			'month_label' => 'Juin'),
		array(
			'month_id' => '07',
			'month_label' => 'Juillet'),
		array(
			'month_id' => '08',
			'month_label' => 'Août'),
		array(
			'month_id' => '09',
			'month_label' => 'Septembre'),
		array(
			'month_id' => '10',
			'month_label' => 'Octobre'),
		array(
			'month_id' => '11',
			'month_label' => 'Novembre'),
		array(
			'month_id' => '12',
			'month_label' => 'Décembre')
		);
?>
	<div class="row">

		<div class="columns large-12">
			<div class="panel radius">

			<form method="post" action="" class="custom">
			<div class="row">
				<div class="columns large-5">
					<h5>Inscrivez-vous...</h5>
					
					<?php echo img('subscribe.jpg', 'chru', '100%'); ?>
				</div>

				<div class="columns large-7">
					<div class="row">
						<div class="columns large-12">
							<p class="text-justify">
								Afin de prendre rendez-vous et de vous faire vacciner avec votre départ en voyage, inscrivez-vous auprès du Centre de Vaccinations Internationales du CHRU de Tours gratuitement !
							</p>
							<p>
								Pour cela, remplissez le formulaire ci-dessous.
							</p>
						</div>
					</div>

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

					<fieldset>
						<legend>Informations personnelles</legend>

					<div class="row">
						<div class="columns large-2">
							<label for="civilite">Civilité
								<select name="title" id="civilite">
									<option value="Mme." <?php if(set_value('title')=="Mme.")echo 'selected="selected"';?> >Mme.</option>
									<option value="Mlle." <?php if(set_value('title')=="Mlle.")echo 'selected="selected"';?> >Mlle.</option>
									<option value="M." <?php if(set_value('title')=="M.")echo 'selected="selected"';?> >M.</option>
								</select>
							</label>
						</div>
						<div class="columns large-5">
							<label for="nom">Nom
								<input type="text" name="lastname" placeholder="Nom" value="<?php echo set_value('lastname'); ?>" id="nom" />
							</label>
						</div>
						<div class="columns large-5">
							<label for="prenom">Prénom
								<input type="text" name="firstname" placeholder="Prénom" value="<?php echo set_value('firstname'); ?>" id="prenom" />
							</label>
						</div>
					</div>
					
					<label for="datenaissance">Date de naissance</label>
					<div class="row">						
						<div class="columns large-2 left">
							<select name="birthdate_day" id="datenaissance">
								<option value="0">Jour</option>
								<?php 
									for($i=1;$i<10;++$i) 
									{
										echo '<option value="0' . $i . '" ';
										if (set_value('birthdate_day') == $i) echo 'selected="selected">';
										else echo '>';
										echo '0' . $i . '</option>';
									}
									for($i=10;$i<32;++$i) 
									{
										echo '<option value="' . $i . '" ';
										if (set_value('birthdate_day') == $i) echo 'selected="selected">';
										else echo '>';
										echo $i . '</option>';
									}
								?>
							</select>
						</div>
						<div class="columns large-4 left">
							<select name="birthdate_month">
								<option value="0">Mois</option>
								<?php 
									foreach($mois as $option) 
									{ 
										echo '<option value="'. $option['month_id'] . '" ';
										if (set_value('birthdate_month') == $option['month_id']) echo 'selected="selected">';
										else echo '>';
										echo $option['month_id'] . ' - ' . $option['month_label'] . '</option>';
									}
								?>
							</select>
						</div>
						<div class="columns large-3 end">
							<select name="birthdate_year">
								<option value="0">Année</option>
								<?php
				          			for($i=2010;$i>=1900;--$i)
				          			{
										echo '<option value="' . $i . '" ';
										if (set_value('birthdate_year') == $i) echo 'selected="selected">';
										else echo '>';
										echo $i . '</option>';
				          			}
				          		?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="columns large-6">
							<label for="communenaissance">Commune de naissance
								<input type="text" name="birthcity" placeholder="Commune de Naissance" value="<?php echo set_value('birthcity'); ?>" id="communenaissance" />
							</label>
						</div>
						<div class="columns large-6">
							<label for="paysnaissance">Pays de naissance
								<select name="birth_country_id" id="paysnaissance">
					 				<option value="0">Sélectionnez un pays</option>
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
					 		</label>
						</div>
					</div>
							
					</fieldset>
					
					<fieldset>
						<legend>Adresse postale</legend>

					<label for="address1">Adresse</label>
					<input type="text" name="address1" id="address1" placeholder="N°, voie" value="<?php echo set_value('address1'); ?>" />
					<input type="text" name="address2" placeholder="Complément d'adresse (facultatif)" value="<?php echo set_value('address2'); ?>" />
					<div class="row">
						<div class="columns large-3">
							<label for="codepostal">Code postal
								<input type="text" name="postalcode" placeholder="Code postal" value="<?php echo set_value('postalcode'); ?>" id="codepostal" />
							</label>
						</div>
						<div class="columns large-4">
							<label for="ville">Ville
								<input type="text" name="city" placeholder="Ville" value="<?php echo set_value('city'); ?>" id="ville" />
							</label>
						</div>
						<div class="columns large-5">
							<label for="pays">Pays
								<select name="country_id" id="pays">
					 				<option value="0">Sélectionnez un pays</option>
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
							</label>
						</div>
					</div>

					</fieldset>
					
					<div class="row">
						<div class="columns large-6">
							<label for="email">Adresse e-mail
								<input type="text" name="email" placeholder="Adresse e-mail" value="<?php echo set_value('email'); ?>" id="email" />
							</label>
						</div>
						<div class="columns large-6">
							<label for="email_confirm">Confirmation adresse e-mail
								<input type="text" name="email_confirm" placeholder="Confirmez votre adresse e-mail" value="<?php echo set_value('email_confirm'); ?>" id="email_confirm" />
							</label>
						</div>
					</div>					
				
					<input type="submit" class="custom-button-class" value="Valider" />
					<input type="reset" class="custom-button-class" value="Reset" />
					&nbsp;<span class="label secondary radius">Tous les champs sont obligatoires.</span>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
	