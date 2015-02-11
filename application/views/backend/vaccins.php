<div class="row">
	<?php require_once(__DIR__.'/backend-nav.php'); ?>
	<div class="columns large-9">
		<div class="panel radius">
			<h5>Vaccins</h5>

			<div class="row">
		<div class="columns large-14">
			<div class="panel radius">
				<script>
				var vaccinations = '<?php echo json_encode($this->vaccin_model->Vaccin_getAllWithGeneralVaccin()); ?>';
				</script>
				<div class="row" id="message"></div>

				<form method="post" action="<?php echo site_url('vaccins/update'); ?>" class="ajaxPost">

					<div class="columns large-14">
						<div class="row">
								
 							<div class="columns large-3">
 								<p style="line-height:37px;text-align:center;"> Catégorie </p>
 							</div>
							<div class="columns large-6">
								<p style="line-height:37px;text-align:center;"> Nom</p>
							</div>
							<div class="columns large-2">
								<p style="line-height:37px;text-align:center;"> Prix</p>
							</div>
							<div class="columns large-1">
							</div>
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

