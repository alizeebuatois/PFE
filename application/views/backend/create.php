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
			<?php $selected_menu=1 ?>
			<?php require_once('backend-nav.php'); ?>
			<div class="columns large-9">

				<div class="row">
					<div class="columns large-9">
						<div class="panel radius">
							<h4>Création d'un rendez-vous</h4>
		
						</div>
					</div>

				</div>

				<div class="row">
					<div class="columns large-9">
						<div class="panel radius">
							<a href="<?php echo site_url('user/listing'); ?>" class="button small"> Sélectionner un voyageur existant</a>
							<a href="<?php echo site_url('user/create'); ?>" class="button small">Créer un compte voyageur</a>
		
						</div>

				</div>

			</div>
		</div>
