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
		<?php require_once(__DIR__.'/../user/user-nav.php'); ?>
		<div class="columns large-9">
			<div class="panel radius">

				<h5>Nouveau membre</h5><br />


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
					<input type="hidden" name="customer_key" value="0000000000" />

					<div class="row">
						<div class="columns large-2">
							<select name="title" class="span2">
							<?php
								$titles = array('Mme.', 'Mlle.', 'M.');
								foreach ($titles as $title)
								{
									echo '<option value="' . $title . '" ';
									if (set_value('title') == $title) echo 'selected="selected">';
									else echo '>';
									echo $title;
									echo '</option>';
								}    
							?>
							</select>
						</div>
						<div class="columns large-5">
							<input type="text" name="firstname" id="firstname" placeholder="Prénom" value="<?php echo set_value('firstname'); ?>" />
						</div>
						<div class="columns large-5">
							<input type="text" name="lastname" id="lastname" placeholder="Nom" value="<?php echo set_value('lastname'); ?>" />
						</div>	
					</div>

					<div class="row">
						<div class="columns large-3">
							<label for="birthdate_day">Jour de naissance</label>
							<select name="birthdate_day" id="birthdate_day" class="span2">
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

						<div class="columns large-5">
							<label for="birthdate_month">Mois de naissance</label>
							<select name="birthdate_month" class="span2">
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
						<div class="columns large-4">
							<label for="birthdate_year">Année de naissance</label>
							<select name="birthdate_year" class="span2">
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
							<label for="birthcity">Lieu de naissance</label>
							<input type="text" name="birthcity" id="birthcity" placeholder="Ville de naissance" value="<?php echo set_value('birthcity'); ?>" />
						</div>
						<div class="columns large-6">
							<label for="birth_country_id">Pays de naissance</label>
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

					<div class="row">
						<div class="columns large-4">
							<label for="numsecu">N° de sécurité social</label>
							<input type="text" name="numsecu" id="numsecu" placeholder="N° de sécurité social" value="<?php echo set_value('numsecu'); ?>" />
						</div>
						<div class="columns large-3">
							<label for="bloodgroup">Groupe sanguin</label>
							<input type="text" name="bloodgroup" id="bloodgroup" placeholder="Groupe sanguin" value="<?php echo set_value('bloodgroup'); ?>" />
						</div>
						<div class="columns large-6">
						</div>
					</div>

					<!-- vspace -->
				 	<div style="height:30px"></div>
				 	
				 	<!--<span class="label secondary">Pour effectuer les modifications, merci de rentrer votre mot de passe.</span>
					<div class="row">
						<div class="columns large-5">
							<input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" />
						</div>
					</div>-->
					<input type="submit" class="custom-button-class" value="Sauvegarder" />
					<a href="<?php echo site_url('compte/famille'); ?>" class="custom-button-class">Annuler</a>

				</form>
			</div>
		</div>
	</div>