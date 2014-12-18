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
			<?php require_once('backend-nav.php'); ?>
			<div class="columns large-9">

				<div class="row">
					<div class="columns large-8">
						<div class="panel radius">
							<h4>Aujourd'hui <small><?php $today=new DateTime(); echo $today->format('d/m/Y'); ?></small></h4>
							<?php if(empty($today_appointments)): ?>
								<p>Aucun rendez-vous aujourd'hui.</p>
							<?php else: ?>
								<table>
									<tbody>
							<?php foreach($today_appointments as $appointment): ?>
										<tr>
											<th colspan="2">
											<?php 
												$start = new DateTime($appointment['appointment_start']);
												$end = new DateTime($appointment['appointment_end']);
												echo $start->format('H\hi') . ' - ' . $end->format('H\hi');
											?>
											</th>
										</tr>	
										<tr>
											<td>
												<?php if ($appointment['appointment_done']): ?>
												<i class="fi-check"></i>
												<?php else: ?>
												
												<?php endif; ?>
											<?php
												$nbMember = count($appointment['members']);
												$count = 0;
												foreach($appointment['members'] as $member_key)
												{
													$count++;
													echo $this->customer_model->Customer_getFullName($member_key);
													if ($count < $nbMember) echo ', ';
												}
											?>
											</td>
											<td class="right">
												
												<a href="<?php echo site_url('appointment/proceed/'.$appointment['appointment_id']); ?>" class="button tiny">Consulter</a>
												
											</td>
										</tr>						
							<?php endforeach; ?>
									</tbody>
								</table>
							<?php endif; ?>
							<a href="<?php echo site_url('backend/schedule'); ?>" class="custom-button-class">Voir tout le planning</a>
							<a href="<?php echo site_url('backend/create'); ?>" class="custom-button-class">Créer un rendez-vous</a>
						</div>
					</div>

					<div class="columns large-4">
						<p class="text-center">
							<small><a href="<?php echo site_url('customer'); ?>" class="button tiny">Recherche un voyageur</a></small><br />
							<small><a href="<?php echo site_url('doctor'); ?>" class="button tiny">Recherche un médecin</a></small>
						</p>
					</div>

				</div>

			</div>
		</div>
