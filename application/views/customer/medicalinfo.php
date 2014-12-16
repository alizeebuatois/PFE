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

	<div class="row">
		<?php require_once(__DIR__.'/../user/user-nav.php'); ?>
		<div class="columns large-9">
			<div class="panel radius">

				<h5>Informations Médicales <small><?php echo $title . ' ' . $firstname . ' ' . $lastname; ?></small></h5><br />

				<div class="row" id="message"></div>

				<form method="post" action="<?php echo site_url('medicalinfo/update'); ?>" class="ajaxPost">

					<input type="hidden" name="customer_key" value="<?php echo $customer_key; ?>" />

<?php if ($sex != 'M'): ?>
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
						<p>Antécédents de réaction vaccinale</p>
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
						<p>Maladies chroniques</p>
					</div>
					<div class="columns large-8">
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

				<!-- vspace -->
			 	<div style="height:30px"></div>
			 	
			 	<!--<span class="label secondary">Pour effectuer les modifications, merci de rentrer votre mot de passe.</span>
				<div class="row">
					<div class="columns large-5">
						<input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" />
					</div>
				</div>-->
				<div class="row">
					<div class="columns large-12">
						<input type="submit" class="custom-button-class" value="Sauvegarder" />
						<?php
							if ($this->uri->segment(3) != null || $this->uri->segment(3) == $this->session->userdata('user_default_customer_key'))
								$backurl = site_url('compte/famille');
							else
								$backurl = site_url('compte');
						?>
						<a href="<?php echo $backurl; ?>" class="custom-button-class">Annuler</a>
					</div>	
				</div>

				</form>

			</div>
		</div>
	</div>

	<script src="<?php echo js_url('cvi/medicalinfo'); ?>"></script>

