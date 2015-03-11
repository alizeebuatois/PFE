<?php
	$countriesList = $this->country_model->Country_getAllCountries(); 

	$fullName = $this->doctor_model->Doctor_getFullName($doctor['doctor_key']);

	$doctor_key = $doctor['doctor_key'];
	$title = $doctor['doctor_title'];
	$firstname = $doctor['doctor_firstname'];
	$lastname = $doctor['doctor_lastname'];
	$birthdate = $doctor['doctor_birthdate'];
	$birthcity = $doctor['doctor_birthcity'];
	$birth_country_id = $doctor['doctor_birth_country_id'];
	$type = $doctor['doctor_type'];
	$timetable = json_decode($doctor['doctor_timetable'], true);
	$fax = $doctor['doctor_fax'];
	$adeli = $doctor['doctor_adeli'];

	$user_key = $user['user_key'];
	$login = $user['user_login'];
	$email = $user['user_email'];
	$address1 = $user['user_address1'];
	$address2 = $user['user_address2'];
	$postalcode = $user['user_postalcode'];
	$city = $user['user_city'];
	$country_id = $user['user_country_id'];
	$phone = $user['user_phone'];
	$user_right = $user['user_right'];

	// TIMETABLE
	$morningMin = new Datetime('07:00:00');
	$morningMax = new Datetime('14:00:00');
	$afternoonMin = new Datetime('12:00:00');
	$afternoonMax = new Datetime('19:00:00');
	$interval = new DateInterval('PT15M'); // intervale de 15minutes
	$morningOptions = array();
	while($morningMin <= $morningMax)
	{
		array_push($morningOptions, $morningMin->format('H:i'));
		$morningMin->add($interval);
	}
	$afternoonOptions = array();
	while($afternoonMin <= $afternoonMax)
	{
		array_push($afternoonOptions, $afternoonMin->format('H:i'));
		$afternoonMin->add($interval);
	}	
	//-------------------------------------------------------------------
?>
	<div class="row">
		<?php require_once(__DIR__.'/../backend-nav.php'); ?>
		<div class="columns large-9">
			<div class="row">
				<div class="columns large-6 medium-6 small-6">
					<p><a href="<?php echo site_url('doctor/view/'.$doctor_key); ?>" class="button"><?php echo $fullName; ?></a></p>
				</div>
				<div class="columns large-6 medium-6 small-6 text-right">
					<a class="button" href="javascript:history.back();">Retour</a>
				</div>
			</div>

			<div class="row"><div id="message"></div></div>

			<dl class="tabs" data-tab>
				<dt></dt>
				<dd class="active"><a href="#details">Détails</a></dd>
				<dd><a href="#info">Données personnelles</a></dd>
				<dd><a href="#timetable">Horaires de présence</a></dd>
			</dl>

			<div class="tabs-content">
				<div class="content active" id="details">
					<div class="row">
						<div class="columns large-6">
							<p>
								<label>Nom complet</label>
								<?php echo $fullName; ?>
							</p>
							<p>
								<label>Date de naissance</label>
								<?php if(!empty($birthdate)): ?>
								<?php echo display_date($birthdate); ?><br />
								<?php endif; ?>
								<?php if (!empty($birthcity)): ?>
								à <?php echo $birthcity; ?><?php endif; ?><?php if ($birth_country_id > 0): ?>,
								<?php echo $this->country_model->Country_getLabelById($birth_country_id,'fr'); ?>
								<?php endif; ?>
							</p>
							<p>
								<label>Fonction</label>
								<?php
									switch ($type) {
									    case 0:
											echo 'Secrétaire';
									        break;
									    case 1:
											echo 'Infirmière';
									        break;
									    case 2:
											echo 'Médecin';
									        break;
									}
								?>
							</p>
						</div>

						<div class="columns large-6">
							<p>
								<label>Compte titulaire</label>
								<a href="<?php echo site_url('user/view/'.$user_key); ?>"><?php echo $login; ?></a><br />
								<?php if (!empty($address1)) : ?>
								<?php echo $address1; ?><br />
								<?php endif; ?>
								<?php if (!empty($address2)) : ?>
								<?php echo $address2; ?><br />
								<?php endif; ?>
								<?php if (!empty($postalcode) || !empty($city)): ?>
								<?php echo $postalcode . ' ' . $city; ?><br />
								<?php endif; ?>
								<?php if (!empty($email)) :?>
								<i class="fi-mail"></i>&nbsp;<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a><br />
								<?php endif; ?>
								<?php if (!empty($phone)): ?>
								<i class="fi-telephone"></i>&nbsp;<?php echo $phone; ?>
								<?php endif; ?><br />
								<?php if (!empty($fax)): ?>
								<i></i>fax : &nbsp;<?php echo $fax; ?>
								<?php endif; ?><br /><br />
								<?php if (!empty($adeli)): ?>
								<i></i><label>Numéro adeli</label><?php echo $adeli; ?>
								<?php endif; ?>
							</p>
						</div>
					</div>
				</div>
				<div class="content" id="info">
					<form action="<?php echo site_url('doctor/update'); ?>" method="post" class="custom ajaxPost">
					<input type="hidden" name="doctor_key" value="<?php echo $doctor_key; ?>" />

					<div class="row">
						<div class="columns large-4"><p class="right">Civilité</p></div>
						<div class="columns large-2 end">
							<select name="title">
							<?php
								$civilites = array('Dr.', 'Pr.', 'Mme.', 'Mlle.', 'M.');
								foreach ($civilites as $civilite)
								{
									echo '<option value="' . $civilite . '" ';
									if ($title == $civilite) echo 'selected="selected">';
									else echo '>';
									echo $civilite;
									echo '</option>';
								}    
							?>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="columns large-4"><p class="right">Nom</p></div>
						<div class="columns large-4 end"><input type="text" name="lastname" placeholder="Nom" value="<?php echo $lastname; ?>" /></div>
					</div>

					<div class="row">
						<div class="columns large-4"><p class="right">Prénom</p></div>
						<div class="columns large-4 end"><input type="text" name="firstname" placeholder="Prénom" value="<?php echo $firstname; ?>" /></div>
					</div>

					<div class="row">
						<div class="columns large-4"><p class="right">Date de naissance</p></div>
						<div class="columns large-4 end"><input type="text" name="birthdate" placeholder="Date de naissance" value="<?php echo $birthdate; ?>" id="dp1" /></div>
					</div>

					<div class="row">
						<div class="columns large-4"><p class="right">Commune de naissance</p></div>
						<div class="columns large-4 end"><input type="text" name="birthcity" placeholder="Ville de naissance" value="<?php echo $birthcity; ?>" /></div>
					</div>

					<div class="row">
						<div class="columns large-4"><p class="right">Pays de naissance</p></div>
						<div class="columns large-4 end">
							<select name="birth_country_id" id="birth_country_id">
								<option value="0">Pays</option>
						 			<?php 
						 				foreach($countriesList as $country)
						 				{
						 					echo '<option value="' . $country['country_id'] . '"';
						 					if ($birth_country_id == $country['country_id']) echo ' selected="selected">';
						 					else echo '>';
						 					echo $country['country_label_fr'] . '</option>';
						 				}
						 			?>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="columns large-4"><p class="right">Fax</p></div>
						<div class="columns large-4 end"><input type="text" name="fax" placeholder="Fax" value="<?php echo $fax; ?>" /></div>
					</div>


					<div class="row">
						<div class="columns large-4"><p class="right">Adeli</p></div>
						<div class="columns large-4 end"><input type="text" name="adeli" placeholder="Numéro adeli" value="<?php echo $adeli; ?>" /></div>
					</div>


					<?php if ($this->session->userdata('user_right') == 3): ?>
					<div class="row">
						<div class="columns large-4"><p class="right">Fonction</p></div>
						<div class="columns large-4 end">
							<select name="type">
							<?php
								$fonctions = array();
								array_push($fonctions, array('id' => 0, 'name' => 'Secrétaire'));
								array_push($fonctions, array('id' => 1, 'name' => 'Infirmière'));
								array_push($fonctions, array('id' => 2, 'name' => 'Médecin'));
								foreach ($fonctions as $fonction)
								{
									echo '<option value="' . $fonction['id'] . '" ';
									if ($type == $fonction['id']) echo 'selected="selected">';
									else echo '>';
									echo $fonction['name'];
									echo '</option>';
								}    
							?>
							</select>
						</div>
					</div>
					<?php else: ?>
						<input type="hidden" name="type" value="<?php echo $type; ?>" />
					<?php endif; ?>

					<div class="row">
						<div class="columns">
							<input type="submit" class="custom-button-class" value="Mettre à jour" />
						</div>
					</div>	

					</form>				
				</div>

				<!-- HORAIRES DE PRESENCE -->
				<div class="content" id="timetable">
					<form action="<?php echo site_url('doctor/updateTimetable'); ?>" method="post" class="custom ajaxPost">
					<input type="hidden" name="doctor_key" value="<?php echo $doctor_key; ?>" />
					<div class="row">						
						<div class="columns large-12">
							<table style="width:100%">
								<thead>
									<tr>
										<th></th>
										<th class="large-5 text-center">Matin</th>
										<th class="large-5 text-center">Après-midi</th>
									</tr>
								</thead>
								<tbody>

								<?php

								$days = array();
								array_push($days, array('id' => 0, 'fr' => 'lundi', 'en' => 'monday'));
								array_push($days, array('id' => 1, 'fr' => 'mardi', 'en' => 'tuesday'));
								array_push($days, array('id' => 2, 'fr' => 'mercredi', 'en' => 'wednesday'));
								array_push($days, array('id' => 3, 'fr' => 'jeudi', 'en' => 'thursday'));
								array_push($days, array('id' => 4, 'fr' => 'vendredi', 'en' => 'friday'));
								array_push($days, array('id' => 5, 'fr' => 'samedi', 'en' => 'saturday'));
								array_push($days, array('id' => 6, 'fr' => 'dimanche', 'en' => 'sunday'));

								foreach($days as $day)
								{
									echo '<tr>';
									echo '<th>' . ucfirst($day['fr']) . '</th>';
									echo '<td>';
									echo '<select name="' . $day['en'] . 'MorningStart">';
									echo '<option value="">&nbsp;</option>';
									foreach($morningOptions as $morningOption)
									{
										echo '<option value="' . $morningOption . '" ';
										if ($timetable[$day['id']]['am'][0] == $morningOption)
											echo 'selected="selected"';
										echo '>';
										echo $morningOption; 
										echo '</option>';
									}
									echo '</select>';
									echo '<select name="' . $day['en'] . 'MorningEnd">';
									echo '<option value="">&nbsp;</option>';
									foreach($morningOptions as $morningOption)
									{
										echo '<option value="' . $morningOption . '" ';
										if ($timetable[$day['id']]['am'][1] == $morningOption)
											echo 'selected="selected"';
										echo '>';
										echo $morningOption; 
										echo '</option>';
									}
									echo '</select>';
									echo '</td>';
									echo '<td>';
									echo '<select name="' . $day['en'] . 'AfternoonStart">';
									echo '<option value="">&nbsp;</option>';
									foreach($afternoonOptions as $afternoonOption)
									{
										echo '<option value="' . $afternoonOption . '" ';
										if ($timetable[$day['id']]['pm'][0] == $afternoonOption)
											echo 'selected="selected"';
										echo '>';
										echo $afternoonOption; 
										echo '</option>';
									}
									echo '</select>';
									echo '<select name="' . $day['en'] . 'AfternoonEnd">';
									echo '<option value="">&nbsp;</option>';
									foreach($afternoonOptions as $afternoonOption)
									{
										echo '<option value="' . $afternoonOption . '" ';
										if ($timetable[$day['id']]['pm'][1] == $afternoonOption)
											echo 'selected="selected"';
										echo '>';
										echo $afternoonOption; 
										echo '</option>';
									}
									echo '</select>';
									echo '</td>';
									echo '</tr>';
								}

								?>
				
								</tbody>
							</table>
						</div>
					</div>

					<div class="row">
						<div class="columns">
							<input type="submit" class="custom-button-class" value="Mettre à jour" />
						</div>
					</div>

					</form>
				</div>
			</div>
		</div>
	</div>

	<script src="<?php echo js_url('cvi/doctor'); ?>"></script>
