<div class="row">
	<?php require_once(__DIR__.'/backend-nav.php'); ?>
	<div class="columns large-9">
		<div class="panel radius">
			<h5>Paramètres des Documents</h5>

			<div class="row" id="message"></div>
			
			<form action="<?php echo site_url('dparameters/save'); ?>" method="post" class="ajaxPost">
			<table style="width:100%">
				<tr>
					<td>
						<label for="hospital_phone_number"><kbd>Numéro de l'Hôpital</kbd></label>
					</td>
					<td>
						<input type="text" name="hospital_phone_number" value="<?php echo $dparameters_hospital_phone_number;
						?>"> 	
						</select>
					</td>
				</tr>

				<tr>
					<td>
						<label for="hospital_finess"><kbd>Numéro Finess de l'Hôpital</kbd></label>
					</td>
					<td>
						<input type="text" name="hospital_finess" value="<?php echo $dparameters_hospital_finess;
						?>"> 	
						</select>
					</td>
				</tr>

				<tr>
					<td>
						<label for="center_phone_number"><kbd>Numéro du centre</kbd></label>
					</td>
					<td>
						<input type="text" name="center_phone_number" value="<?php echo $dparameters_center_phone_number;
						?>"> 	
						</select>
					</td>
				</tr>

				<tr>
					<td>
						<label for="center_fax"><kbd>Fax du centre</kbd></label>
					</td>
					<td>
						<input type="text" name="center_fax" value="<?php echo $dparameters_center_fax;
						?>"> 	
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="head_service"><kbd>Chef de service</kbd></label>
					</td>
					<td>
						<input type="text" name="head_service" value="<?php echo $dparameters_head_service;
						?>"> 	
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="adeli_head_service"><kbd>Numéro Adeli du chef de service</kbd></label>
					</td>
					<td>
						<input type="text" name="adeli_head_service" value="<?php echo $dparameters_adeli_head_service;
						?>"> 	
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="doctors"><kbd>Docteurs</kbd></label>
					</td>
					<td>
					<textarea rows="4" cols="30" name="doctors"><?php echo $dparameters_doctors;
						?> </textarea>	
					</td>
				</tr>	
		
			</table>
			<input type="submit" class="custom-button-class" value="Sauvegarder" />
			</form>
		</div>
	</div>
</div>