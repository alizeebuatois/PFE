<div class="row">
	<?php require_once(__DIR__.'/backend-nav.php'); ?>
	<div class="columns large-9">
		<h5>Administration</h5>
		<div class="panel radius">
						<div class="row" style="text-align:center">
							<a href="<?php echo site_url('parameters'); ?>" class="custom-button-class">Paramètres Généraux</a>
							<a href="<?php echo site_url('dparameters'); ?>" class="custom-button-class">Paramètres des Documents</a>
							<a href="<?php echo site_url('backend/statistics'); ?>" class="custom-button-class">Statistiques</a>
							
						</div>
					</br>
						<div class="row" style="text-align:center">
							<a href="<?php echo site_url('vaccins'); ?>" class="custom-button-class">Vaccins</a>
							<a href="<?php echo site_url('treatment'); ?>" class="custom-button-class">Traitements</a>
							<a href="<?php echo site_url('stock'); ?>" class="custom-button-class">Gestion des stocks</a>
						</div>
		</div>
	</div>
</div>