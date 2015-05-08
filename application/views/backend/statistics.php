<div class="row">
	<?php require_once(__DIR__.'/backend-nav.php'); ?>
	<div class="columns large-9">
		<div class="panel radius">
			<h5>Statistiques</h5>

			<table style="width:100%">
				<tr>
					<td class="half">
						Taux d'occupation du centre<br />
						<?php if ($occupation_rate > 0): ?>
						<small>Entre aujourd'hui et le <?php echo $occupation_rate_endDate->format('d/m/Y'); ?></small>
						<?php endif; ?>
					</td>
					<td class="half"><?php echo $occupation_rate; ?>%</td>
				</tr>
				<tr>
					<td>Nombre de consultations données</td>
					<td><?php echo $nb_appointments_done; ?></td>
				</tr>
				<tr>
					<td>Nombre de clients actifs</td>
					<td><?php echo $active_customer; ?></td>
				</tr>
				<tr>
					<td>Nombre de comptes inactifs</td>
					<td><?php echo $inactive_user; ?></td>
				</tr>
				<tr>
					<td>Age moyen des consultants</td>
					<td><?php echo $mean_age; ?></td>
				</tr>
				<tr>
					<td>Nombre de certificat de contre indication pour le vaccin de la fièvre jaune</td>
					<td><?php echo $yellow_fever; ?></td>
				</tr>
				<tr>
					<td>Nombre de situations particulières (grossesse-allaitement, maladies chroniques, allergies)</td>
					<td><?php echo $particular_situation; ?></td>
				</tr>
				<!--<tr>
					<td>Nombre d’incidents post vaccination</td>
					<td></td>
				</tr>-->
				<!--<tr>
					<td>Nombre de consultations sans vaccinations</td>
					<td></td>
				</tr>-->
			</table>

			<!-- Voici quelques exemples de statistiques -->
			<h6><b>Pays visités par mois</b></h6>
			<table style="width:100%">
				  <thead>
				    <tr>
				      <th width="200">Pays</th>
				      <th width="150">Juin</th>
				      <th width="150">Juillet</th>
				      <th width="150">Août</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <td><b>Europe<b></td>
				      <td></td>
				      <td></td>
				      <td><?php echo $visited_coutriesEurope; ?></td>
				    </tr>
				    <tr>
				      <td><b>Guadeloupe</b></td>
				      <td></td>
				      <td></td>
				      <td><?php echo $visited_coutriesGuadeloupe; ?></td>
				    </tr>
				    <tr>
				      <td><b>Asie<b></td>
				      <td><?php echo $visited_coutriesAsie1; ?></td>
				      <td><?php echo $visited_coutriesAsie2; ?></td>
				      <td></td>
				    </tr>
				  </tbody>
			</table>

			<h6><b>Vaccins réalisés par mois</b></h6>
			<table style="width:100%">
				  <thead>
				    <tr>
				      <th width="200">Pays</th>
				      <th width="150">Janvier</th>
				      <th width="150">Février</th>
				      <th width="150">Mars</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <td><b>Avaxim<b></td>
				      <td>3</td>
				      <td>0</td>
				      <td>10</td>
				    </tr>
				    <tr>
				      <td><b>Bexsero</b></td>
				      <td>1</td>
				      <td>5</td>
				      <td>3</td>
				    </tr>
				    <tr>
				      <td><b>Revaxis<b></td>
				      <td>12</td>
				      <td>8</td>
				      <td>8</td>
				    </tr>
				  </tbody>
			</table>
		</div>
	</div>
</div>