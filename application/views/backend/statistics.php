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
					<td>Nombre de consultations sans vaccinations</td>
					<td></td>
				</tr>
				<tr>
					<td>Pays visités par mois</td>
					<td></td>
				</tr>
				<tr>
					<td>Nombre de vaccins réalisés par mois et par vaccin</td>
					<td></td>
				</tr>
				<tr>
					<td>Age moyen des consultants</td>
					<td></td>
				</tr>
				<tr>
					<td>Nombre de certificat de contre indication pour le vaccin de la fièvre jaune</td>
					<td></td>
				</tr>
				<tr>
					<td>Nombre d’incidents post vaccination</td>
					<td></td>
				</tr>
				<tr>
					<td>Nombre de situations particulières : par exemple : grossesse, allaitement, maladies chroniques</td>
					<td></td>
				</tr>
			</table>
		</div>
	</div>
</div>