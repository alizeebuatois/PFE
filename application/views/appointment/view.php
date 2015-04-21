<div class="row">
	<?php require_once(__DIR__.'/../user/user-nav.php'); ?>
	<div class="columns large-9">
		<div class="panel radius">
			<h5>Rendez-vous du <?php echo full_date($appointment_start, false); ?></h5>
			
			<table style="width:100%">
				<tbody>
					<tr>
						<th>Voyageur(s)</th>
						<td>
						<?php
						foreach($appointment_customers as $customer)
							echo $this->customer_model->Customer_getFullName($customer) . '<br />';
						?>
						</td>
					</tr>
					<tr>
						<th>Dates du voyage</th>
						<td>							
						<?php 
							if ($appointment_return == null)
								echo full_date($appointment_departure, false);
							else
								echo 'Du ' . full_date($appointment_departure, false) . ' au ' . full_date($appointment_return, false);
						?>
						</td>
					</tr>
					<tr>
						<th>Destination(s)</th>
						<td>							
						<?php
						foreach($appointment_destinations as $destination)
							echo $this->country_model->Country_getLabelById($destination) . '<br />';
						?>
						</td>
					</tr>
					<tr>
						<th>Hébergement(s)</th>
						<td>							
						<?php
						foreach($appointment_hostings as $hosting)
							echo ucfirst($this->hosting_model->Hosting_getLabelById($hosting)) . '<br />';
						?>
						</td>
					</tr>
					<tr>
						<th>Activité(s)</th>
						<td>							
						<?php
						foreach($appointment_activities as $activity)
							echo ucfirst($this->activity_model->Activity_getLabelById($activity)) . '<br />';
						?>
						</td>
					</tr>
					<tr>
						<th>Heure du rendez-vous</th>
						<td>							
						<?php echo substr(full_date($appointment_start), 0, -3); ?>
						</td>
					</tr>

					<?php
						$departure = new DateTime($appointment_departure);
						$appointmentdate = new DateTime($appointment_start);
						$now = new DateTime();
						if ($departure < $now) {
					?>

					<tr>
						<th>Remarque(s)</th>
						<td>
							<p style="width:100%" class="text-justify">
							De manière à rendre notre service plus efficace, merci de nous informer ci-dessous quelque remarque que ce soit concernant votre voyage passé.
							</p>
							<div class="row" id="message"></div>
							<form action="<?php echo site_url('appointment/updateFeedback/' . $appointment_id); ?>" method="post" class="ajaxPost">
								<textarea name="feedback" rows="7" cols="30" placeholder="Vos remarques ici..."><?php echo $appointment_feedback; ?></textarea>
								<input type="submit" class="custom-button-class" value="Soumettre" />
							</form>
						</td>
					</tr>

					<?php } 
					if ($now < $appointmentdate->sub(new DateInterval('P2D')) && $appointment_user_key == $this->session->userdata('user_key')) {
					?>

					<tr>
						<th></th>
						<td>
							<a href="" data-reveal-id="appointmentCancelConfirmBox" data-reveal class="custom-button-class" style="background:red">Annuler ce rendez-vous</a>
							<!-- Box de confirmation d'annulation de l'association -->
							<div id="appointmentCancelConfirmBox" class="reveal-modal" data-reveal>
								<p>
									Êtes-vous certain de vouloir annuler ce rendez-vous ?
								</p>
								<?php $appointmentCancelURL = site_url('appointment/cancel/' . $appointment_id); ?>
								<a href="<?php echo $appointmentCancelURL; ?>" class="custom-button-class" id="appointmentCancel">Oui</a>
								<a class="custom-button-class" onclick="$('a.close-reveal-modal').trigger('click');">Non</a>
								<a class="close-reveal-modal">&times;</a>
							</div>

						</td>
					</tr>

			
					<?php } ?>

				</tbody>
			</table>

			<a href="<?php echo site_url('appointment'); ?>" class="custom-button-class">Retour</a>

		</div>
	</div>
</div>