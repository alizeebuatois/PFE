<?php
	if (empty($doctor_key))
	{
		if ($this->session->userdata('user_right') == 2)
			$doctor_key = 'all';
		else
			$doctor_key = $this->session->userdata('user_doctor_key');
	}	
?>
<script>
var getJsonURL = globalBaseURL + 'appointment/getEventsJson/<?php echo $doctor_key; ?>';
</script>
<script src="<?php echo js_url('vendor/fullcalendar'); ?>"></script>
<script src="<?php echo js_url('cvi/schedule'); ?>"></script>

<div class="row">
	<?php require_once('backend-nav.php'); ?>
	<div class="columns large-9">
		<?php if ($this->session->userdata('user_right') > 1): ?>
		<div class="panel radius">
			<div class="row">
				<div class="columns large-4">
					<form class="custom">
						<label>Voir le planning de :<br /><br />
						<select class="doctors">
							<option value="all">Tout le monde</option>
						<?php
							foreach($doctors as $doctor)
							{
								echo '<option value="' . $doctor['doctor_key'] . '" ';
								if ($doctor['doctor_key'] == $doctor_key)
									echo 'selected="selected"';
								echo '>';
								echo $this->doctor_model->Doctor_getShortName($doctor['doctor_key']);
								echo '</option>';
							}
						?>
						</select>
						</label>
					</form>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="row">
			<div class="columns large-12">
				<div id="calendar"></div>
			</div>
		</div>

	</div>
</div>