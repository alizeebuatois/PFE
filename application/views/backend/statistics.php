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
			</table>
		</div>
	</div>
</div>