<div class="row">
	<?php require_once(__DIR__.'/backend-nav.php'); ?>
	<div class="columns large-9">
		<div class="panel radius">
			<h5>Paramètres</h5>

			<div class="row" id="message"></div>
			
			<form action="<?php echo site_url('parameters/save'); ?>" method="post" class="ajaxPost">
			<table style="width:100%">
				<tr>
					<td>
						<label for="isLongTripFrom"><kbd>Durée d'un long voyage</kbd></label>
						<small>Nombre de jours à partir duquel un voyage est dit "long"</small>
					</td>
					<td>
						<select name="isLongTripFrom" id="isLongTripFrom">
						<?php
							for ($i=0 ; $i<=250 ; ++$i)
							{
								echo '<option value="'.$i.'"';
								if ($i == $parameters_isLongTripFrom)
									echo ' selected="selected"';
								echo '>'.$i.' jours</option>';
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="appointmentNbMaxCustomer"><kbd>Nombre de clients</kbd></label>
						<small>Nombre maximum de clients par rendez-vous</small>
					</td>
					<td>
						<select name="appointmentNbMaxCustomer" id="appointmentNbMaxCustomer">
						<?php
							for ($i=0 ; $i<=15 ; ++$i)
							{
								echo '<option value="'.$i.'"';
								if ($i == $parameters_appointmentNbMaxCustomer)
									echo ' selected="selected"';
								echo '>'.$i.' clients</option>';
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="appointment1Pduration"><kbd>Durée consultation</kbd></label>
						<small>Durée d'une consultation pour 1 seule personne</small>
					</td>
					<td>
						<select name="appointment1Pduration" id="appointment1Pduration">
						<?php
							for ($i=0 ; $i<=60 ; ++$i)
							{
								echo '<option value="'.$i.'"';
								if ($i == $parameters_appointment1Pduration)
									echo ' selected="selected"';
								echo '>'.$i.' minutes</option>';
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="appointmentLongTripMinDuration"><kbd>Durée consultation longue</kbd></label>
						<small>Durée minimum d'une consultation pour un voyage dit "long"</small>
					</td>
					<td>
						<select name="appointmentLongTripMinDuration" id="appointmentLongTripMinDuration">
						<?php
							for ($i=0 ; $i<=60 ; ++$i)
							{
								echo '<option value="'.$i.'"';
								if ($i == $parameters_appointmentLongTripMinDuration)
									echo ' selected="selected"';
								echo '>'.$i.' minutes</option>';
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="appointmentNPdurationPP"><kbd>Durée consultation en famille</kbd></label>
						<small>Temps de consultation par personne pour un rendez-vous en famille</small>
					</td>
					<td>
						<select name="appointmentNPdurationPP" id="appointmentNPdurationPP">
						<?php
							for ($i=0 ; $i<=60 ; ++$i)
							{
								echo '<option value="'.$i.'"';
								if ($i == $parameters_appointmentNPdurationPP)
									echo ' selected="selected"';
								echo '>'.$i.' minutes</option>';
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="appointmentEmergencySlotDuration"><kbd>Créneaux d'urgence</kbd></label>
						<small>Durée des créneaux d'urgence</small>
					</td>
					<td>
						<select name="appointmentEmergencySlotDuration" id="appointmentEmergencySlotDuration">
						<?php
							for ($i=0 ; $i<=60 ; ++$i)
							{
								echo '<option value="'.$i.'"';
								if ($i == $parameters_appointmentEmergencySlotDuration)
									echo ' selected="selected"';
								echo '>'.$i.' minutes</option>';
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="appointmentNbRoom"><kbd>Salles de consultation</kbd></label>
						<small>Nombre de salles de consultation</small>
					</td>
					<td>
						<select name="appointmentNbRoom" id="appointmentNbRoom">
						<?php
							for ($i=0 ; $i<=15 ; ++$i)
							{
								echo '<option value="'.$i.'"';
								if ($i == $parameters_appointmentNbRoom)
									echo ' selected="selected"';
								echo '>'.$i.' salles</option>';
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="emailContact"><kbd>Email</kbd></label>
						<small>Adresse e-mail de contact du centre</small>
					</td>
					<td>
						<input type="text" name="emailContact" id="emailContact" placeholder="Adresse e-mail" value="<?php echo $parameters_emailContact; ?>" />
				</tr>
			</table>
			<input type="submit" class="custom-button-class" value="Sauvegarder" />
			</form>
		</div>
	</div>
</div>