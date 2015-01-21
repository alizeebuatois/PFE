<div class="row">
	<?php require_once(__DIR__.'/backend-nav.php'); ?>
	<div class="columns large-9">
		<div class="panel radius">
			<h5>Vaccins et Traitements</h5>

			<div class="row">
		<div class="columns large-14">
			<div class="panel radius">
				<script>
				var vaccinations = '<?php echo $vaccins; ?>';
				</script>
				<div class="row" id="message"></div>

				<form method="post" action="<?php echo site_url('vaccins/update'); ?>" class="ajaxPost">

				<div class="row">
					<div class="columns large-4">
						<p>Vaccins</p>
				</div>
					</div>
					<div class="columns large-14">
						<div id="vaccins">
						</div>
						<div class="row">
							<div class="columns large-14">
								<a class="button tiny" onclick="addVaccin();">Ajouter un vaccin</a>
							</div>
						</div>
					</div>
				

				<hr />


				<!-- vspace -->
			 	<div style="height:30px"></div>

				<div class="row">
					<div class="columns large-12">
						<input type="submit" class="custom-button-class" value="Sauvegarder" />
						<?php
								$backurl = site_url('vaccins');
						?>
						<a href="<?php echo $backurl; ?>" class="custom-button-class">Annuler</a>
					</div>	
				</div>

				</form>

			</div>
		</div>
	</div>

		</div>
	</div>
</div>

<script src="<?php echo js_url('cvi/vaccins'); ?>"></script>

