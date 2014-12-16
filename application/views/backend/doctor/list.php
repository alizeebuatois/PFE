<?php
	$functions = array('Secrétaire','Infirmière','Médecin');
	$rights = array('','Personnel de soin','Secrétaire','Administrateur');
	$countries = $this->country_model->Country_getCountriesTable();
?>
	
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
		<?php require_once(__DIR__.'/../backend-nav.php'); ?>
		<div class="columns large-9">
			<div class="panel radius">
				<div class="row">
					<div class="columns large-6">
						<h4>Médecins du CVI</h4>
					</div>
					<?php if ($this->session->userdata('user_right') > 1): ?>
					<div class="columns large-6 text-right">
						<a href="<?php echo site_url('doctor/create'); ?>" class="custom-button-class">Nouveau</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="row">
				<div class="columns large-12">
					<table style="width:100%">
						<thead>
							<tr>
								<th>Nom complet</th>
								<th>Fonction</th>
								<th>Droits</th>
								<?php if ($this->session->userdata('user_right') > 1): ?>
								<th></th>
								<th></th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>

						<?php foreach($doctors as $doctor): ?>
							<tr>
								<td><?php echo $this->doctor_model->Doctor_getFullName($doctor['doctor_key']); ?><br /><i>(<?php echo $doctor['user']['user_login']; ?>)</i></td>
								<td><?php echo $functions[$doctor['doctor_type']]; ?></td>
								
								<td><?php echo $rights[$doctor['user']['user_right']]; ?></td>
								<?php if ($this->session->userdata('user_right') > 1): ?>
								<td class="text-right">
									<?php $planningURL = site_url('backend/schedule/' . $doctor['doctor_key']); ?>
									<a href="<?php echo $planningURL; ?>" class="button tiny">Voir planning</a>&nbsp;
								</td>
								<td>
									<?php $editURL = site_url('doctor/view/' . $doctor['doctor_key']); ?>
									<a href="<?php echo $editURL; ?>" class="button tiny">Plus d'infos</a>
								</td>
								<?php endif; ?>
							</tr>
						<?php endforeach; ?>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>