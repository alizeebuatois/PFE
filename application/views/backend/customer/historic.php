
<div class="row">
	<?php require_once(__DIR__.'/../backend-nav.php'); ?>
		<div class="columns large-9 medium-6 small-6 text-right">
			<a class="button" href="javascript:history.back();">Retour</a>
		</div><br />
	<div class="columns large-9">

			<h4>Historique Médical</h4><br />
				<h5> <?php echo $this->customer_model->Customer_getFullName($customer['customer_key']) ?></h5>
				<div class="panel radius">

					<h5>Vaccins</h5><br />
						<div class="row">
							<div class="columns large-12">
									<table style="width:100%">
										<thead>
											<tr>
												<th>Nom</th>
												<th>Lot</th>
												<th>Date</th>
												<th>Médecin</th>
												<th>Commentaire</th>
											</tr>
										</thead>

										<tbody>


										<?php $historic_vaccins = $this->historicvaccin_model->HistoricVaccin_getByCustomer($customer['customer_key']); ?>

											<?php for($i = 0; $i < count($historic_vaccins); $i++) { ?>
											<tr>
												<td> <?php echo $this->vaccin_model->Vaccin_getLabelById($historic_vaccins[$i]['historic_vaccin_id']); ?> </td>
												<td> <?php echo $historic_vaccins[$i]['historic_lot']; ?> </td>
												<td> <?php echo $historic_vaccins[$i]['historic_date']; ?> </td>
												<td> <?php echo $this->doctor_model->Doctor_getShortName($historic_vaccins[$i]['historic_doctor_key']); ?> </td>
												<td> <?php echo $historic_vaccins[$i]['historic_comment']; ?> </td></tr>
											<?php } ?>

										</tbody>
									</table>
							</div>
						</div>

					<hr/>

					<h5>Traitements</h5><br />
						<div class="row">
							<div class="columns large-12">
								<table style="width:100%">
									<thead>
										<tr>
											<th>Nom</th>
											<th>Date</th>
											<th>Médecin</th>
											<th>Commentaire</th>
										</tr>
									</thead>
									<tbody>

									<?php $historic_treatments = $this->historictreatment_model->HistoricTreatment_getByCustomer($customer['customer_key']); ?>

										<?php for($i = 0; $i < count($historic_treatments); $i++) { ?>
										<tr>
											<td> <?php echo $this->treatment_model->Treatment_getNameById($historic_treatments[$i]['historic_treatment_id']); ?> </td>
											<td> <?php echo $historic_treatments[$i]['historic_date']; ?> </td>
											<td> <?php echo $this->doctor_model->Doctor_getShortName($historic_treatments[$i]['historic_doctor_key']); ?> </td>
										</tr>
										<?php } ?>
	
									</tbody>
								</table>
							</div>
						</div>
				</div>
		</div>
</div>