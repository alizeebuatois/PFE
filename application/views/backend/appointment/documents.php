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
	</div>
</div>