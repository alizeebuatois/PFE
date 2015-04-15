<?php
	$countriesList = $this->country_model->Country_getAllCountries(); 
	$fullName = $this->customer_model->Customer_getFullName($customer_key);
?>
<div class="row">
	<?php require_once(__DIR__.'/../backend-nav.php'); ?>
	<div class="columns large-9">
		<div class="row">
			<div class="columns large-4 medium-6 small-6">
				<p><a href="<?php echo site_url('customer/view/'.$customer_key); ?>" class="button"><?php echo $fullName; ?></a></p>
			</div>

			<div class="columns large-4 medium-6 small-6">
				<p><a href="<?php echo site_url('customer/viewHistoric/'.$customer_key); ?>" class="success button">Historique Médical</a></p>
			</div>

			<div class="columns large-4 medium-6 small-6 text-right">
				<a class="button" href="javascript:history.back();">Retour</a>
			</div>
		</div>

		<div class="row" id="message"></div>

		<!-- TABS -->
		<dl class="tabs" data-tab>
			<dt></dt>
			<dd class="active"><a href="#details">Détails</a></dd>
			<dd><a href="#personnalInfo">Données personnelles</a></dd>
			<dd><a href="#medicalInfo">Données médicales</a></dd>
			<dd><a href="#medicalRecord">Dossier médical</a></dd>
		</dl>

		<!-- CONTENT -->
		<div class="tabs-content">

			<!-- DETAILS -->
			<div class="content active" id="details">
				<div class="row">
					<div class="columns large-6">	
						<p>
							<label>Nom complet</label>
							<?php echo $fullName; ?>
						</p>
						<p>
							<label>Date de naissance</label>
							<?php echo display_date($customer_birthdate); ?><br />
							<?php if (!empty($customer_birthcity)): ?>
							à <?php echo $customer_birthcity; ?><?php endif; if ($customer_birth_country_id > 0): ?>, <?php echo $this->country_model->Country_getLabelById($customer_birth_country_id,'fr'); ?>
							<?php endif; ?>
						</p>
						<p>
							<label>N° de sécurité social</label>
							<?php echo $customer_numsecu; ?>
						</p>
						<p>
							<label>Groupe sanguin</label>
							<?php echo $customer_bloodgroup; ?>
						</p>
					</div>

					<div class="columns large-6">
						<p>
							<label>Compte titulaire</label>
							<a href="<?php echo site_url('user/view/'.$customer_user_key); ?>"><?php echo $this->user_model->User_getMainName($customer_user_key) . ' <small>(' . $user_login . ')</small> '; ?></a><br />
							<?php if (!empty($user_address1)): ?>
							<?php echo $user_address1; ?><br />
							<?php endif; ?>
							<?php if (!empty($user_address2)) : ?>
							<?php echo $user_address2; ?><br />
							<?php endif; ?>
							<?php if (!empty($user_postalcode) || !empty($user_city)): ?>
							<?php echo $user_postalcode . ' ' . $user_city; ?><br />
							<?php endif; ?>
							<?php if($user_country_id > 0): ?>
							<?php echo $this->country_model->Country_getLabelById($user_country_id); ?><br />
							<?php endif; ?>
							<?php if (!empty($user_email)) :?>
							<i class="fi-mail"></i>&nbsp;<a href="mailto:<?php echo $user_email; ?>"><?php echo $user_email; ?></a><br />
							<?php endif; ?>
							<?php if (!empty($user_phone)): ?>
							<i class="fi-telephone"></i>&nbsp;<?php echo $user_phone; ?>
							<?php endif; ?>
						</p>
						<p>
							<label>Rendez-vous</label>
							<?php if (empty($appointments)): ?>
								<small>Aucun</small>
							<?php endif; ?>
							<?php foreach($appointments as $appointment): ?>
								<?php echo substr(full_date($appointment['appointment_start'], true), 0, -3); ?>
								<a href="<?php echo site_url('appointment/proceed/'.$appointment['appointment_id']); ?>"><i class="fi-link"></i></a><br />
							<?php endforeach; ?>
						</p>
					</div>
				</div>
			</div>

			<!-- INFOS PERSONNELLES -->
			<div class="content" id="personnalInfo">
				<form class="custom ajaxPost" action="<?php echo site_url('customer/updateAjax'); ?>" method="post">
				<input type="hidden" name="customer_key" value="<?php echo $customer_key; ?>" />

				<div class="row">
					<div class="columns large-4"><p class="right">Civilité</p></div>
					<div class="columns large-2 end">
						<select name="title" class="span2">
						<?php
							$civilites = array('Mme.', 'Mlle.', 'M.');
							foreach ($civilites as $civilite)
							{
								echo '<option value="' . $civilite . '" ';
								if ($customer_title == $civilite) echo 'selected="selected">';
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
					<div class="columns large-4 end"><input type="text" name="lastname" placeholder="Nom" value="<?php echo $customer_lastname; ?>" /></div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">Prénom</p></div>
					<div class="columns large-4 end"><input type="text" name="firstname" placeholder="Prénom" value="<?php echo $customer_firstname; ?>" /></div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">Date de naissance</p></div>
					<div class="columns large-4 end"><input type="text" name="birthdate" placeholder="Date de naissance" value="<?php echo $customer_birthdate; ?>" id="birthdatePicker" /></div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">Commune de naissance</p></div>
					<div class="columns large-4 end"><input type="text" name="birthcity" placeholder="Commune de naissance" value="<?php echo $customer_birthcity; ?>" /></div>
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
			 					if ($customer_birth_country_id == $country['country_id']) echo ' selected="selected">';
			 					else echo '>';
			 					echo $country['country_label_fr'] . '</option>';
			 				}
			 			?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">N° de sécurité sociale</p></div>
					<div class="columns large-4 end"><input type="text" name="numsecu" placeholder="N° de sécurité sociale" value="<?php echo $customer_numsecu; ?>" /></div>
				</div>
				<div class="row">
					<div class="columns large-4"><p class="right">Groupe sanguin</p></div>
					<div class="columns large-4 end"><input type="text" name="bloodgroup" placeholder="Groupe sanguin" value="<?php echo $customer_bloodgroup; ?>" /></div>
				</div>

				<div class="row">
					<div class="columns large-12 text-left">
						<input type="submit" class="custom-button-class" value="Mettre à jour" />
					</div>	
				</div>

				</form>
			</div>

			<!-- Infos médicales -->
			<div id="medicalInfo" class="content">
<?php
	if ($medicalInfo == null)
	{
		$pregnancy = array();
		$pregnancy['medicalInfoPregnancy_state'] = 'N';
		$pregnancy['medicalInfoPregnancy_contraception'] = null;
		$pregnancy['medicalInfoPregnancy_breastFeeding'] = '0';
		$repatriation = null;
		$recentIntervention = null;
		$previousVaccinReaction = null;
		$diseaseRecentFever = null;
		$allergies = null;
		$chronicDiseases = null;
		$immunosuppressives = null;
		$currentTreatment = '';
?>
<script>
var customerAllergies = '';
var customerChronicDiseases = '';
var customerImmunosuppressives = '';
</script>
<?php
	}
	else
	{
		$pregnancy = $medicalInfo['medicalInfo_pregnancy'];
		if ($pregnancy == null)
		{
			$pregnancy['medicalInfoPregnancy_state'] = 'N';
			$pregnancy['medicalInfoPregnancy_contraception'] = null;
			$pregnancy['medicalInfoPregnancy_breastFeeding'] = '0';
		}
		$repatriation = $medicalInfo['medicalInfo_repatriationInsurance'];
		$recentIntervention = $medicalInfo['medicalInfo_recentIntervention'];
		$previousVaccinReaction = $medicalInfo['medicalInfo_previousVaccinReaction'];
		$diseaseRecentFever = $medicalInfo['medicalInfo_diseaseRecentFever'];
		$allergies = $medicalInfo['medicalInfo_allergies'];
		$chronicDiseases = $medicalInfo['medicalInfo_chronicDiseases'];
		$immunosuppressives = $medicalInfo['medicalInfo_immunosuppressiveTreatments'];
		$currentTreatment = $medicalInfo['medicalInfo_currentTreatment'];
?>
<script>
var customerAllergies = '<?php echo $allergies; ?>';
var customerChronicDiseases = '<?php echo $chronicDiseases; ?>';
var customerImmunosuppressives = '<?php echo $immunosuppressives; ?>';
</script>
<?php
	}
?>
					<form method="post" action="<?php echo site_url('medicalinfo/update'); ?>" class="ajaxPost">

						<input type="hidden" name="customer_key" value="<?php echo $customer_key; ?>" />

	<?php if ($customer_sex != 'M'): ?>
					<div class="row">
						<div class="columns large-6">
							<p>Grossesse en cours</p>
						</div>
						<div class="columns large-6">
							<div class="row">
								<div class="columns large-6">
									<label for="pregnancy_y"><input type="radio" id="pregnancy_y" name="pregnancy" value="Y" <?php if($pregnancy['medicalInfoPregnancy_state']=='Y')echo'checked="checked"';?> /> Oui</label>
									<label for="pregnancy_p"><input type="radio" id="pregnancy_p" name="pregnancy" value="P" <?php if($pregnancy['medicalInfoPregnancy_state']=='P')echo'checked="checked"';?> /> Présomption</label>
								</div>
								<div class="columns large-6">
									<label for="pregnancy_n"><input type="radio" id="pregnancy_n" name="pregnancy" value="N" <?php if($pregnancy['medicalInfoPregnancy_state']=='N')echo'checked="checked"';?> /> Non</label>
									<label for="pregnancy_m"><input type="radio" id="pregnancy_m" name="pregnancy" value="M" <?php if($pregnancy['medicalInfoPregnancy_state']=='M')echo'checked="checked"';?> /> Ménopauée</label>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<div class="row">
						<div class="columns large-6">
							<p>Contraception</p>
						</div>
						<div class="columns large-6">
							<div class="row">
								<div class="columns	large-6">
									<?php $other=true; ?>
									<label for="contraception_n"><input type="radio" id="contraception_n" name="contraception" value="N" <?php if($pregnancy['medicalInfoPregnancy_contraception']==null||$pregnancy['medicalInfoPregnancy_contraception']=='N'){echo'checked="checked"';$other=false;}?> /> Aucune</label>
									<label for="contraception_iud"><input type="radio" id="contraception_iud" name="contraception" value="IUD" <?php if($pregnancy['medicalInfoPregnancy_contraception']=='IUD'){echo'checked="checked"';$other=false;}?> /> Stérilet</label>
								</div>
								<div class="columns large-6">
									<label for="contraception_pill"><input type="radio" id="contraception_pill" name="contraception" value="pill" <?php if($pregnancy['medicalInfoPregnancy_contraception']=='pill'){echo'checked="checked"';$other=false;}?> /> Pillule</label>
									<input type="text" placeholder="Autre..." name="contraception_other" 
									<?php
										if ($other) echo 'value="' . $pregnancy['medicalInfoPregnancy_contraception'] . '"';
									?>
									/>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<div class="row">
						<div class="columns large-6">
							<p>Allaitement</p>
						</div>
						<div class="columns large-6">
							<div class="row">
								<div class="columns	large-3">
									<label for="breastfeeding_y"><input type="radio" id="breastfeeding_y" name="breastfeeding" value="1" <?php if($pregnancy['medicalInfoPregnancy_breastFeeding']=='1')echo'checked="checked"';?> /> Oui</label>
								</div>
								<div class="columns large-3 end">
									<label for="breastfeeding_n"><input type="radio" id="breastfeeding_n" name="breastfeeding" value="0" <?php if($pregnancy['medicalInfoPregnancy_breastFeeding']=='0')echo'checked="checked"';?> /> Non</label>
								</div>
							</div>
						</div>
					</div>
					
					<hr />
	<?php endif; ?>
					<div class="row">
						<div class="columns large-6">
							<p>Assurance rapatriement</p>
						</div>
						<div class="columns large-6">
							<div class="row">
								<div class="columns	large-3">
									<label for="repatriation_y"><input type="radio" id="repatriation_y" name="repatriation" value="Y" <?php if($repatriation=='Y') echo 'checked="checked"';?> /> Oui</label>
								</div>
								<div class="columns large-3">
									<label for="repatriation_n"><input type="radio" id="repatriation_n" name="repatriation" value="N" <?php if($repatriation=='N') echo 'checked="checked"';?> /> Non</label>
								</div>
								<div class="columns large-6">
								<label for="repatriation_dk"><input type="radio" id="repatriation_dk" name="repatriation" value="DK" <?php if($repatriation==null) echo 'checked="checked"';?> /> Ne sais pas</label>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<div class="row">
						<div class="columns large-6">
							<p>Intervention récente</p>
						</div>
						<div class="columns large-6">
							<div class="row">
								<div class="columns	large-3">
									<label for="recentIntervention_y"><input type="radio" id="recentIntervention_y" name="recentIntervention" value="1" <?php if($recentIntervention!=null) echo 'checked="checked"';?> /> Oui</label>
								</div>
								<div class="columns large-3 end">
									<label for="recentIntervention_n"><input type="radio" id="recentIntervention_n" name="recentIntervention" value="0" <?php if($recentIntervention==null) echo 'checked="checked"';?> /> Non</label>
								</div>
							</div>
							<div class="row">
								<div class="columns large-12">
									<textarea name="recentInterventionComment" rows="4" placeholder="Si oui, précisez..."><?php echo $recentIntervention; ?></textarea>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<div class="row">
						<div class="columns large-6">
							<p>Antécédents de réactions vaccinales</p>
						</div>
						<div class="columns large-6">
							<div class="row">
								<div class="columns	large-3">
									<label for="previousVaccinReaction_y"><input type="radio" id="previousVaccinReaction_y" name="previousVaccinReaction" value="1" <?php if($previousVaccinReaction!=null) echo 'checked="checked"';?> /> Oui</label>
								</div>
								<div class="columns large-3 end">
									<label for="previousVaccinReaction_n"><input type="radio" id="previousVaccinReaction_n" name="previousVaccinReaction" value="0" <?php if($previousVaccinReaction==null) echo 'checked="checked"';?> /> Non</label>
								</div>
							</div>
							<div class="row">
								<div class="columns large-12">
									<textarea name="previousVaccinReactionComment" rows="4" placeholder="Si oui, précisez..."><?php echo $previousVaccinReaction; ?></textarea>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<div class="row">
						<div class="columns large-6">
							<p>Maladie aiguë ou fièvre récente</p>
						</div>
						<div class="columns large-6">
							<div class="row">
								<div class="columns	large-3">
									<label for="diseaseOrRecentFever_y"><input type="radio" id="diseaseOrRecentFever_y" name="diseaseOrRecentFever" value="1" <?php if($diseaseRecentFever!=null) echo 'checked="checked"'; ?> /> Oui</label>
								</div>
								<div class="columns large-3 end">
									<label for="diseaseOrRecentFever_n"><input type="radio" id="diseaseOrRecentFever_n" name="diseaseOrRecentFever" value="0" <?php if($diseaseRecentFever==null) echo 'checked="checked"'; ?> /> Non</label>
								</div>
							</div>
							<div class="row">
								<div class="columns large-12">
									<textarea name="diseaseOrRecentFeverComment" rows="4" placeholder="Si oui, précisez..."><?php echo $diseaseRecentFever; ?></textarea>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<div class="row">
						<div class="columns large-4">
							<p>Allergies</p>
						</div>
						<div class="columns large-8">
							<div id="no-allergies"><p>Rien à afficher.</p></div>
							<div id="allergies">
							</div>
							<div class="row">
								<div class="columns large-12">
									<a class="button tiny" onclick="addAllergy();">Ajouter une allergie</a>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<div class="row">
						<div class="columns large-4">
							<p>Maladie chronique</p>
						</div>
						<div class="columns large-8">
							<div id="no-chronicDiseases"><p>Rien à afficher.</p></div>
							<div id="chronicdiseases">
							</div>
							<div class="row">
								<div class="columns large-12">
									<a class="button tiny" onclick="addChronicDisease();">Ajouter une maladie chronique</a>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<div class="row">
						<div class="columns large-4">
							<p>Traitements immunosuppresseurs<br /><small>Dans les 6 derniers mois</small></p>
						</div>
						<div class="columns large-8">
							<div id="no-immunosuppressives"><p>Rien à afficher.</p></div>
							<div id="immunosuppressives">
							</div>
							<div class="row">
								<div class="columns large-12">
									<a class="button tiny" onclick="addImmunosuppressive();">Ajouter un traitement</a>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<div class="row">
						<div class="columns large-4">
							<p>Traitements actuels</p>
						</div>
						<div class="columns large-8">
							<div class="row">
								<div class="columns large-12">
									<textarea name="currentTreatments" rows="4" placeholder="Indiquez vos traitements actuels..."><?php echo $currentTreatment;?></textarea>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="columns large-12 text-left">
							<input type="submit" class="custom-button-class" value="Mettre à jour" />
						</div>	
					</div>

					</form>
				</div>

				<!-- DOSSIER MEDICAL -->
				<div id="medicalRecord" class="content">
<?php
	$yellowFevers = $this->yellowfever_model->YellowFever_getAll();

	if ($medicalRecord == null)
	{
		// Initialisation des champs de fièvre jaune à VIDE
		$medicalRecord_yellowFever = array();
		foreach ($yellowFevers as $yellowFever)
		{
			$medicalRecord_yellowFever[$yellowFever['yellowFever_id']]['done'] = '';
			$medicalRecord_yellowFever[$yellowFever['yellowFever_id']]['comment'] = '';
		}
?>
<script>
var customerStamarils = '';
var customerPreviousVaccinations = '';
var customerVaccinationsA = '';
var customerHistoricTreatment = '';

</script>
<?php
	}
	else
	{
		$medicalRecord_yellowFever = json_decode($medicalRecord['medicalRecord_yellowFever'], true);
?>
<script>
var customerStamarils = '<?php echo $medicalRecord["medicalRecord_stamaril"]; ?>';
var customerPreviousVaccinations = '<?php echo $medicalRecord["medicalRecord_previousVaccinations"]; ?>';
var customerVaccinationsA = '<?php echo $medicalRecordA; ?>';
var customerHistoricTreatment = '<?php echo $historicTreatment; ?>';


</script>

<?php
	}
?>
					<form method="post" action="<?php echo site_url('medicalrecord/update'); ?>" class="ajaxPost">

						<input type="hidden" name="customer_key" value="<?php echo $customer_key; ?>" />

					
					<hr />

					

					<h5>Vaccinations antérieures</h5>

					<div class="row">
						<div class="columns large-12">
							<div id="no-previousVaccinations"><p>Rien à afficher.</p>
							</div>
							<div id="previousVaccinations">
							</div>
							<div class="row">
								<div class="columns large-12">
									<a class="button tiny" onclick="addPreviousVaccination();">Ajouter</a>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<h5>Vaccins réalisés</h5>

					<div class="row">
						<div class="columns large-12">
							<div id="no-vaccinations"><p>Rien à afficher.</p>
							</div>
							<div id="vaccinations">
							</div>
							<div class="row">
								<div class="columns large-12">
									<a class="button tiny" onclick="addVaccination();">Ajouter</a>
								</div>
							</div>
						</div>
					</div>

					<hr />

					<h5>Traitements prescrits</h5>

					<div class="row">
						<div class="columns large-12">
							<div id="no-treatments"><p>Rien à afficher.</p>
							</div>
							<div id="treatments">
							</div>
							<div class="row">
								<div class="columns large-12">
									<a class="button tiny" onclick="addTreatment();">Ajouter</a>
								</div>
							</div>
						</div>
					</div>

					<hr />
					<hr />

					<h5>Stamaril</h5>

					<div class="row">
						<div class="columns large-12">
							<div id="no-stamarils"><p>Rien à afficher.</p>
							</div>
							<div id="stamarils">
							</div>
							<div class="row">
								<div class="columns large-12">
									<a class="button tiny" onclick="addStamaril();">Ajouter</a>
								</div>
							</div>
						</div>
					</div>

					<hr />


					<h5>Stamaril - Détails</h5>

					<?php foreach($yellowFevers as $yellowFever): ?>
						<?php
							// On regarde si on a les infos pour ce champ
							if (isset($medicalRecord_yellowFever[$yellowFever['yellowFever_id']]))
							{
								// On regarde quel radio il faut cocher
								if ($medicalRecord_yellowFever[$yellowFever['yellowFever_id']]['done'] === 'Y')
								{
									// Le OUI
									$yes = true;
									$no = false;
								}
								else if ($medicalRecord_yellowFever[$yellowFever['yellowFever_id']]['done'] === 'N')
								{
									// Le NON
									$yes = false;
									$no = true;
								}
								else
								{
									// AUCUN
									$yes = false;
									$no = false;
								}
								// On récupère le commentaire
								$comment = $medicalRecord_yellowFever[$yellowFever['yellowFever_id']]['comment'];
							}
							else
							{				
								$yes = false;
								$no = false;
								$comment = '';
							}
						?>

					<div class="row">
						<div class="columns large-4"><?php echo $yellowFever['yellowFever_label']; ?></div>
						<div class="columns large-3">
							<div class="row collapse">
								<div class="columns large-6">
									<label for="yellowFever_<?php echo $yellowFever['yellowFever_id']; ?>_1">
										<input type="radio" value="Y" id="yellowFever_<?php echo $yellowFever['yellowFever_id']; ?>_1" name="yellowFever_<?php echo $yellowFever['yellowFever_id']; ?>" 
										<?php if($yes) echo 'checked="checked"'; ?>
										/> Oui 
									</label>
								</div>
								<div class="columns large-6">
									<label for="yellowFever_<?php echo $yellowFever['yellowFever_id']; ?>_0">
										<input type="radio" value="N" id="yellowFever_<?php echo $yellowFever['yellowFever_id']; ?>_0" name="yellowFever_<?php echo $yellowFever['yellowFever_id']; ?>" 
										<?php if($no) echo 'checked="checked"'; ?>
										/> Non 
									</label>
								</div>
							</div>
						</div>
						<div class="columns large-5">
							<input type="text" name="yellowFever_<?php echo $yellowFever['yellowFever_id']; ?>_comment" placeholder="Commentaire..." value="<?php echo $comment ?>" />
						</div>
					</div>
					<?php endforeach; ?>

				<hr />


					<div class="row">
						<div class="columns large-12 text-left">
							<input type="submit" class="custom-button-class" value="Mettre à jour" />
						</div>	
					</div>

					</form>
				</div>
			</div>
		</div>
	</div>

<script src="<?php echo js_url('cvi/customer'); ?>"></script>
<script src="<?php echo js_url('cvi/medicalinfo'); ?>"></script>
<script src="<?php echo js_url('cvi/medicalrecord'); ?>"></script>