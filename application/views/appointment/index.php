	<div class="row">
		<?php require_once(__DIR__.'/../user/user-nav.php'); ?>
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
		

			<div class="panel radius">
			<a href="<?php echo site_url('appointment/make'); ?>" class="button medium">Prendre rendez-vous</a>
			</div>

			<div class="panel radius">
				<h5>Mes rendez-vous à venir</h5>
				
				<?php 
					if ($nextAppointments==null)
					 echo'<p>Aucun rendez-vous à afficher.</p>';
					else
					{
						$count = 0;
				?>

				<div class="row">
				<?php foreach($nextAppointments as $appointment): $count++; ?>

					<div class="columns large-6">
					<ul class="pricing-table">
						<li class="title"><?php echo substr(full_date($appointment['appointment_start']), 0, -3); ?></li>
						<li class="bullet-item"><?php
							foreach($this->appointment_model->Appointment_getCustomers($appointment['appointment_id']) as $customer_key)
							{
								echo $this->customer_model->Customer_getFullName($customer_key) . '<br />';
							}
						?></li>
						<li class="description">Créé par : <?php
						// On récupère le nom du créateur du rendez-vous (peut être customer ou doctor)
						echo $this->user_model->User_getMainName($appointment['appointment_creator_user_key']);
						?></li>
						<li class="cta-button"><a class="button small" href="<?php echo site_url('appointment/view/'.$appointment['appointment_id']); ?>">Plus d'infos</a><br /><br />
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
				<?php } ?>
				
			</div>
			<div class="panel radius">
				
				<h5>Mes rendez-vous passés</h5>

				<?php 
					if ($previousAppointments==null)
					 echo'<p>Aucun rendez-vous à afficher.</p>';
					else
					{
						$count = 0;
				?>

				<div class="row">
				<?php foreach($previousAppointments as $appointment): $count++; ?>

					<div class="columns large-6">
					<ul class="pricing-table">
						<li class="title"><?php echo substr(full_date($appointment['appointment_start']), 0, -3); ?></li>
						<li class="bullet-item"><?php
							foreach($this->appointment_model->Appointment_getCustomers($appointment['appointment_id']) as $customer_key)
							{
								echo $this->customer_model->Customer_getFullName($customer_key) . '<br />';
							}
						?></li>
						<li class="description">Créé par : <?php
						// On récupère le nom du créateur du rendez-vous (peut être customer ou doctor)
						echo $this->user_model->User_getMainName($appointment['appointment_creator_user_key']);
						?></li>
						<li class="cta-button"><a class="button small" href="<?php echo site_url('appointment/view/'.$appointment['appointment_id']); ?>">Plus d'infos</a><br /><br />
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
				<?php } ?>
				
			</div>
		</div>
	</div>