<div id="step6" class="step hide">
	
	<p>Choisissez une date de rendez-vous.</p>

	<div class="message"></div>

	<div class="row collapse">
		<div class="columns large-4">
			<div class="row collapse">
				<label for="appoinmentDate1">Date du rendez-vous désirée</label>
				<div class="columns large-10">
					<input type="text" name="appointmentDate1" id="appointmentDate1" value="" />
				</div>
				<div class="columns large-2">
					<span class="postfix"><i class="fi-calendar"></i></span>
				</div>
			</div>
			<div class="row">
				<div class="columns"><small id="displayAppointmentDate1"></small><br /><br /></div>
			</div>
			<!--<div class="row collapse">
				<label for="appointmentDate2">Ou le : </label>
				<div class="columns large-9">
					<input type="text" name="appointmentDate2" id="appointmentDate2" />
				</div>
				<div class="columns large-3">
					<span class="postfix"><i class="icon-calendar"></i></span>
				</div>
			</div>-->
		</div>
		<div class="columns large-3 end">
			<div class="row">
				<label for="">&nbsp;&nbsp;</label>
				<div class="columns large-12">
					<select name="appointmentDate1Option" id="appointmentDate1Option">
						<option value="am">Matin</option>
						<option value="pm">Après-midi</option>
					</select>
				</div>
			</div>
			<!--<div class="row">
				<label for="">&nbsp;&nbsp;</label>
				<div class="columns large-12">
					<select name="appointmentDate2Option" id="appointmentDate2Option">
						<option value="am">Matin</option>
						<option value="pm">Après-midi</option>
					</select>
				</div>
			</div>-->
		</div>
	</div>
	<div class="row">
		<div class="columns large-12">
				<div id="propositionsLoading" class="text-center hide">
					<p><?php echo img('ajax-loader.gif','loader'); ?><br />
					Le système recherche les créneaux disponibles.<br />Merci de patienter.</p>
				</div>
				<div id="propositions" class="text-center hide"></div>
		</div>
	</div>

	<div class="row">
		<div class="columns large-12">
			<div class="panel radius">
				<h6>Attention !</br>
					Si aucun créneau ne convient, veuillez nous contacter rapidement au :</br>
					02.47.00.00.00</br>
					ou en nous envoyant un message via la page suivante : <a href="<?php echo site_url('page/contact'); ?>">Contact</a></h6>
			</div>
		</div>
	</div>
</div>