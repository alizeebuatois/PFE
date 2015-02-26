<div class="row">
	<?php require_once(__DIR__.'/backend-nav.php'); ?>
	<div class="columns large-9">
		<div class="panel radius">
			<h5>Traitements</h5>

			<div class="row">
		<div class="columns large-14">
			<div class="panel radius">
				<script>
				var treatment = '<?php echo json_encode($this->treatment_model->Treatment_getAll()); ?>';
				</script>
				
				<div class="row" id="message"></div>

				<form method="post" action="<?php echo site_url('treatment/update'); ?>" class="ajaxPost">

					<div class="columns large-14">
						<div class="row">
								
							<div class="columns large-4">
								<p style="line-height:37px;text-align:left;"> Nom</p>
							</div>
							<div class="columns large-4">
								<p style="line-height:37px;text-align:left;">Titre</p>
							</div>
							<div class="columns large-1">
							</div>
					</div>
				</div>
						<div class="columns large-14">
							<div id="treatment">
							</div>
							<div class="row">
								<div class="columns large-14">
									<a class="button tiny" onclick="addTreatment();">Ajouter un traitement</a>
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
									$backurl = site_url('treatment');
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

<script src="<?php echo js_url('cvi/treatment'); ?>"></script>
<script src="<?php echo js_url('ckeditor/ckeditor'); ?>"></script>

