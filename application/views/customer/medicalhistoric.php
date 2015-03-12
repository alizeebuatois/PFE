	<div class="row">
		<?php require_once(__DIR__.'/../user/user-nav.php'); ?>
		<div class="columns large-9">
			<h4>Historique Médical</h4><br />

			<?php foreach($customers as $customer): ?>

				<h5> <?php echo $this->customer_model->Customer_getFullName($customer) ?></h5>
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
											</tr>
										</thead>

										<tbody>


										<?php $historic_vaccins = $this->historicvaccin_model->HistoricVaccin_getByCustomer($customer); ?>

											<?php for($i = 0; $i < count($historic_vaccins); $i++) { ?>
											<tr>
												<td> <?php echo $historic_vaccins[$i]['historic_name']; ?> </td>
												<td> <?php echo $historic_vaccins[$i]['historic_lot']; ?> </td>
												<td> <?php echo $historic_vaccins[$i]['historic_date']; ?> </td>
												<td> <?php echo $this->doctor_model->Doctor_getShortName($historic_vaccins[$i]['historic_doctor_key']); ?> </td>
											</tr>
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
										</tr>
									</thead>
									<tbody>

									<?php $historic_treatments = $this->historictreatment_model->HistoricTreatment_getByCustomer($customer); ?>

										<?php for($i = 0; $i < count($historic_treatments); $i++) { ?>
										<tr>
											<td> <?php echo $historic_treatments[$i]['historic_name']; ?> </td>
											<td> <?php echo $historic_treatments[$i]['historic_date']; ?> </td>
											<td> <?php echo $this->doctor_model->Doctor_getShortName($historic_treatments[$i]['historic_doctor_key']); ?> </td>
										</tr>
										<?php } ?>
	
									</tbody>
								</table>
							</div>
						</div>
				</div>

			<?php endforeach; ?>

		</div>

	</div>

