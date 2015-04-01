<div class="row">
	<?php require_once(__DIR__.'/backend-nav.php'); ?>
	<div class="columns large-9">
		<h5>Gestion des stocks</h5>
		<div class="panel radius">

			<!-- TABS -->
			<dl class="tabs" data-tab>
				<dt></dt>
				<dd class="active"><a href="#accueil">Accueil</a></dd>
				<dd><a href="#nouveaulot">Nouveau Lot</a></dd>
				<dd><a href="#regu">Régularisation</a></dd>
				<dd><a href="#historique">Historique</a></dd>
			</dl>

			<!-- CONTENT -->
			<div class="tabs-content">

						</br>

				<div id="accueil" class="content active">
					<div class="row">
							<div class="columns large-12">
									<table style="width:100%">
										<thead>
											<tr>
												<th>Vaccin</th>
												<th>Lot</th>
												<th>Quantité du lot</th>
												<th>Quantité restante</th>
												<th>Dernière mise à jour</th>
											</tr>
										</thead>

										<?php $stockcurrent = $this->stockcurrent_model->StockCurrent_getAll(); ?>
										<tbody>
											<?php for($i = 0; $i < count($stockcurrent); $i++) { ?>
											<tr>
												<td> <?php echo $this->vaccin_model->Vaccin_getLabelById($stockcurrent[$i]['stock_vaccin_id']); ?> </td>
												<td> <?php echo $stockcurrent[$i]['stock_vaccin_lot']; ?> </td>
												<td> <?php echo $stockcurrent[$i]['stock_quantity_lot']; ?> </td>
												<td> <?php echo $stockcurrent[$i]['stock_remaining']; ?> </td>
												<td> <?php echo $stockcurrent[$i]['stock_last_update']; ?></td>
											</tr>

											<?php } ?>

										</tbody>
									</table>
							</div>
						</div>
					</div>

				<div id="nouveaulot" class="content">

				<form method="post" action="<?php echo site_url('stock/newlot'); ?>">
							</br>
				<table style="width:100%">
					<thead>
						<tr>
							<th>Vaccin</th>
							<th>Nouveau Lot</th>
							<th>Quantité</th>
						</tr>
					</thead>

					<?php $options = $this->vaccin_model->Vaccin_getAll(); ?>

					<tbody>

						<tr>
							<td> <select name="vaccinLOT">
									<?php for($i = 0; $i < count($options); $i++) { ?>
									<option value="<?php echo $options[$i]['vaccin_id']?>"><?php echo $options[$i]['vaccin_label'];?></option>
									<?php } ?>
								 </select>
							</td>
							<td><input type="text" type="newlot"/></td>
							<td><input type="text" type="quantity"/></td>
						</tr>

					</tbody>
				</table>
				<input type="submit" class="custom-button-class" value="Sauvegarder"/>


				</form>
				</div>

				<div id="regu" class="content">

				<form method="post" action="<?php echo site_url('stock/newregulation'); ?>">
				</br>
					<table style="width:100%">
						<thead>
							<tr>
								<th>Vaccin</th>
								<th>Lot</th>
								<th>Quantité théorique</th>
								<th>Nouvelle quantité</th>
								<th>Commentaires</th>
							</tr>
						</thead>

						<?php $options = $this->vaccin_model->Vaccin_getAll(); ?>

						<tbody>

							<tr>
								<td> <select name="vaccinREG">
									<?php for($i = 0; $i < count($options); $i++) { ?>
									<option value="<?php echo $options[$i]['vaccin_id']?>"><?php echo $options[$i]['vaccin_label'];?></option>
									<?php } ?>
							 		</select>
							 	</td>
								<td>(à remplir)</td>
								<td>(à remplir)</td>
								<td><input type="text" name="newquantity"/></td>
								<td><input type="text" name="comment"/></td>
							</tr>

						</tbody>
					</table>
				<input type="submit" class="custom-button-class" value="Sauvegarder"/>

				</form> 

				</div>


				<div id="historique" class="content">
								</br>
					<div class="row">
							<div class="columns large-12">

								<?php $stocklot = $this->stocklot_model->StockLot_getAll(); ?>

								<?php for($i = 0; $i < count($stocklot); $i++) { ?>

								<h5><b><?php echo $this->vaccin_model->Vaccin_getLabelById($stocklot[$i]['stock_vaccin_id']); ?></b></h5>
										</br>
									<h6>Résumé</h6>
									<table style="width:100%">
										<thead>
											<tr>
												<th>Lot </th>
												<th>Ajouté le </th>
												<th>Quantité </th>
											</tr>
										</thead>

										<tbody>

											<tr>
												<td><?php echo $stocklot[$i]['stock_vaccin_id']; ?></td>
												<td><?php echo $stocklot[$i]['stock_vaccin_id']; ?></td>
												<td><?php echo $stocklot[$i]['stock_vaccin_id']; ?></td>
											</tr>

										</tbody>
									</table>

									<?php $stockregulation = $this->stockregulation_model->StockRegulation_getAll(); ?>

									<?php for($j = 0; $j < count($stockregulation); $j++) { ?>

										<?php if ($stocklot[$i]['stock_vaccin_id'] == $stocklot[$j]['stock_vaccin_id']){ ?>

									<h6>Régularisations</h6>
									<table style="width:100%">
										<thead>
											<tr>
												<th>Lot</th>
												<th>Mise à jour</th>
												<th>Quantité restante théorique</th>
												<th>Quantité restante réelle</th>
												<th>Commentaires</th>
											</tr>
										</thead>

										<tbody>

											<tr>
												<td><?php echo $stockregulation[$j]['stock_vaccin_lot']; ?></td>
												<td><?php echo $stockregulation[$j]['stock_date']; ?></td>
												<td><?php echo $stockregulation[$j]['stock_theorical_quantity']; ?></td>
												<td><?php echo $stockregulation[$j]['stock_real_quantity']; ?></td>
												<td><?php echo $stockregulation[$j]['stock_comment']; ?></td>
											</tr>

										</tbody>

									</table>

								</br>
									<?php } ?>
									<?php } ?>

								<?php } ?>

							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>