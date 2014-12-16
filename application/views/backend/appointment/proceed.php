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
	
		<div class="row">
			<div class="columns large-12">
				<ul class="breadcrumbs">
					<li><a href="<?php echo site_url('dashboard'); ?>">Consultation</a></li>
					<li><?php 
						$nbCustomers = count($customers);
						$count = 0;
						foreach($customers as $customer) {
							$count++;
							echo $this->customer_model->Customer_getFullName($customer['customer_key']);
							if ($count < $nbCustomers)
								echo ', ';
						}
					?></li>
				</ul>
			</div>
		</div>

		<div class="row">
			<div class="columns large-12">
				<p><?php echo 'Créé par : ' . $this->user_model->User_getMainName($appointment['appointment_creator_user_key']); ?></p>
			</div>
		</div>

		<div class="row collapse">
			<div class="columns large-4">
				<a href="#" class="button small large-12 disabled">Imprimer la facture</a>
			</div>
			<div class="columns large-4">
				<a href="#" class="button small large-12">Planifier un rappel</a>
			</div>
			<div class="columns large-4">
				<?php if (!$appointment['appointment_done']): ?>
				<a href="<?php echo site_url('appointment/finish/' . $appointment['appointment_id']); ?>" class="button small alert large-12">Terminer la consultation</a>
				<?php else: ?>
				<span class="button small success large-12">Consultation terminée</span>
				<?php endif; ?>
			</div>
		</div>

		<div class="row">
			<div class="columns large-12">
				<div class="panel">
					<div class="row">
						<div class="columns large-6">
							<p>
								<label>Départ</label>
								<?php echo full_date($appointment['appointment_departure'], false); ?>
							</p>
							<p>
								<label>Durée du voyage</label>
								<?php if ($appointment['appointment_return'] == null): ?>
									<i><small>Non déterminée</small></i>
								<?php else: ?>
									<?php
										$d = new DateTime($appointment['appointment_departure']);
										$r = new DateTime($appointment['appointment_return']);
										$diff = $d->diff($r);
										echo $diff->format('%d jours');
									?>
								<?php endif; ?>
							</p>
							<p>
								<label>Médecin</label>
								<?php echo $this->doctor_model->Doctor_getFullName($appointment['appointment_doctor_key']); ?>
							</p>
						</div>
						<div class="columns large-6">
							<p>
								<label>Destination(s)</label>
								<?php
									$nbDestinations = count($destinations);
									$count = 0;
									foreach($destinations as $destination)
									{
										$count++;
										echo $this->country_model->Country_getLabelById($destination);
										if ($count < $nbDestinations)
											echo ', ';
									}
								?>
							</p>
							<p>
								<label>Hébergement(s)</label>
								<?php
									$nbHostings = count($hostings);
									$count = 0;
									foreach($hostings as $hosting)
									{
										$count++;
										if ($count == 1)
											echo ucfirst($this->hosting_model->Hosting_getLabelById($hosting));
										else
											echo $this->hosting_model->Hosting_getLabelById($hosting);
										if ($count < $nbHostings)
											echo ', ';
									}
								?>
							</p>
							<p>
								<label>Activité(s)</label>
								<?php
									$nbActivities = count($activities);
									$count = 0;
									foreach($activities as $activity)
									{
										$count++;
										if ($count == 1)
											echo ucfirst($this->activity_model->Activity_getLabelById($activity));
										else
											echo $this->activity_model->Activity_getLabelById($activity);
										if ($count < $nbActivities)
											echo ', ';
									}
								?>
							</p>
						</div>
					</div>							
				</div>
			</div>
		</div>

		<div class="row">
		<?php $count = 0; foreach($customers as $customer): $count++; ?>

			<div class="columns large-6">
				<ul class="pricing-table">
					<li class="title"><?php echo $this->customer_model->Customer_getFullName($customer['customer_key']); ?></li>
					<li class="bullet-item">Né(e) le 
					<?php 
						echo display_date($customer['customer_birthdate']) . ' ';
						// Calcul de l'age
						$birthdate = new DateTime($customer['customer_birthdate']);
						$now = new DateTime();
						echo $now->diff($birthdate)->format('(%y ans)');
					?></li>
					<!--<li class="description"></li>-->
					<li class="cta-button"><a class="button small" href="<?php echo site_url('customer/view/'.$customer['customer_key']); ?>">Consulter</a><br /><br />
					</li>
				</ul>
			</div>

		<?php 

		if ($count == 2)
		{
			echo '</div>';
			echo '<div class="row">';
			$count = 0;
		}

		endforeach; ?>
		</div>
	</div>
</div>