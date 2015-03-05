<div class="row">
	<?php require_once(__DIR__.'/../backend-nav.php'); ?>

	<div class="columns large-9">
	
		<?php if ($this->session->userdata('alert-message') != ''): ?>
		<div class="row">
			<div class="columns large-12">
				<div data-alert class="alert-box <?php echo $this->session->userdata('alert-type'); ?> radius">
		 			<?php echo $this->session->userdata('alert-message'); ?>
		 			<a href="#" class="close">&times;</a>
				</div>
			</div>
		</div>			
		<?php $this->session->set_userdata(array('alert-message' => '')); endif; ?>


		<div class="columns large-10">
			<div class="row" id="message"></div>

		<label><b>Choisir le type de document à générer </b> </label> <br />
		<div class="panel radius">
		<label><input type="radio" name="doc" value="ordo" onclick='show("ordo")' required> Ordonnance<br></label>
		<label><input type="radio" name="doc" value="facture" onclick='show("facture")' required> Facture</label>
		<label><input type="radio" name="doc" value="trousse" onclick='show("trousse")' required> Trousse de secours</label>
		</div>



			<!-- Formulaire Ordo -->
			<div id='ordo' class='doc'>
			<form method='post' action="<?php echo site_url('pdf/generateOrdo');?>">

				<label><b>Sélectionnez un membre : </b> </label> <br />
				<div class="panel radius">

					<?php 
			
						foreach($customers as $customer)
						{
								//echo $this->customer_model->Customer_getFullName($customer);
								$member = $this->customer_model->Customer_getFromKey($customer);
								$member = $member[0];
								echo '<label for="' . $member['customer_key'] . '">';
								echo '<input type="radio" name="customer" id="' . $member['customer_key'] . '" value="' . $member['customer_key'] . '" class="customers" required/>';
								echo '&nbsp;';
								echo $member['customer_firstname'] . ' ' . $member['customer_lastname'];
								echo '</label>';
								//echo "<a href=\"".site_url('pdf/generate/'.$member['customer_key'])."\" class='button tiny'>Générer</a></p>";
						}
						//echo '</div><div class="columns large-6">';
					?>
				</div>

				<label><b>Sélectionnez un ou plusieurs traitements : </b> </label> <br />
				<div class="panel radius">

					<?php 
						
							foreach($treatments as $treatment)
							{
									//echo $this->customer_model->Customer_getFullName($customer);
									//$treatment = $this->treatment_model->Treatment_getAll();
									//$treatment = $treatment[0];

									echo '<label for="' . $treatment['treatment_id'] . '" style="display:inline-block;margin-right: 20px;">';
									echo '<input type="checkbox" name="treatmentIds[]" id="' . $treatment['treatment_id'] . '" value="' . $treatment['treatment_id'] . '" class="treatments"/>';
									echo '&nbsp;';
									echo $treatment['treatment_name'];
									echo '</label>';
									//echo "<a href=\"".site_url('pdf/generate/'.$member['customer_key'])."\" class='button tiny'>Générer</a></p>";
							}
							//echo '</div><div class="columns large-6">';
					?>
				</div>

				<div class="columns large-10">
				<input type='submit' class='button tiny' value='Générer'/>
				<a href="<?php echo site_url('appointment/proceed/'. $appointment['appointment_id']); ?>" class="button tiny">Retour</a>
				</div>

			</form>
			</div>


			<!-- Formulaire Facture -->
			<div id='facture' class='doc' style='clear:both'>
			<form method='post' action="<?php echo site_url('pdf/generateTreatments');?>">

				<label><b>Sélectionnez un membre : </b> </label> <br />
				<div class="panel radius">

					<?php 
			
						foreach($customers as $customer)
						{
								//echo $this->customer_model->Customer_getFullName($customer);
								$member = $this->customer_model->Customer_getFromKey($customer);
								$member = $member[0];
								echo '<label for="' . $member['customer_key'] . '">';
								echo '<input type="radio" name="customer" id="' . $member['customer_key'] . '" value="' . $member['customer_key'] . '" class="customers" required/>';
								echo '&nbsp;';
								echo $member['customer_firstname'] . ' ' . $member['customer_lastname'];
								echo '</label>';
						}
					?>
				</div>

				<label><b>Sélectionnez un ou plusieurs vaccins : </b> </label> <br />
				<div class="panel radius">

					<?php 
						
							foreach($vaccins as $vaccin)
							{
									echo '<label for="' . $vaccin['vaccin_id'] . '" style="display:inline-block;margin-right: 20px;">';
									echo '<input type="checkbox" name="vaccinIds[]" id="' . $vaccin['vaccin_id'] . '" value="' . $vaccin['vaccin_id'] . '" class="vaccins"/>';
									echo '&nbsp;';
									echo $vaccin['vaccin_label'];
									echo '</label>';
							}
					?>
				</div>

				<div class="columns large-10">
				<input type='submit' class='button tiny' value='Générer'/>
				<a href="<?php echo site_url('appointment/proceed/'. $appointment['appointment_id']); ?>" class="button tiny">Retour</a>
				</div>

			</form>
			</div>

			<!-- Formulaire Trousse -->
			<div id='trousse' class='doc' style='clear:both'>
			<form method='post' action="<?php echo site_url('pdf/generateTrousse');?>">

				<label><b>Sélectionnez le type de trousse de secours : </b> </label> <br />
				<div class="panel radius">
					<label><input type="radio" name="trousse" value="enfant" required> Enfant<br></label>
					<label><input type="radio" name="trousse" value="adulte" required> Adulte</label>

				</div>
				<div class="columns large-10">
				<input type='submit' class='button tiny' value='Générer'/>
				<a href="<?php echo site_url('appointment/proceed/'. $appointment['appointment_id']); ?>" class="button tiny">Retour</a>
				</div>

			</form>
			</div>

		</div>
	</div>
</div>


<script>
	function hideAll(){
		$(".doc").hide();
	}

	function show(id){
    	hideAll();
    	$("#"+id).show();
	}

	$( document ).ready(function() {
		hideAll();
	});
</script>