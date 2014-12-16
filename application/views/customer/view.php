	<div class="row">
		<?php require_once(__DIR__.'/../user/user-nav.php'); ?>
			<div class="columns large-9">
				<div class="panel radius">

					<?php if ($this->session->userdata('alert-message') != ''): ?>
					<div class="row">
						<div class="columns large-12">
							<div data-alert class="alert-box <?php echo $this->session->userdata('alert-type'); ?> radius">
					 			<?php echo $this->session->userdata('alert-message'); ?>
					 			<a href="#" class="close">&times;</a>
							</div>
						</div>
					</div>			
					<?php $this->session->set_userdata(array('alert-message' => '')); endif; ?>

					<?php if (!empty($profiles) || !empty($partnership_profiles)): ?>
					<h5>Ma famille</h5>
					<table style="width:100%">
						<tbody>
						<?php
							// Liste des profils appartenant au compte
							foreach ($profiles as $member) 
							{
								$edit_url = site_url('customer/update/' . $member['customer_key']);
								$medicalInfo_url = site_url('customer/medicalinfo/' . $member['customer_key']);
								echo '<tr>';
								echo '<td>' . $member['customer_firstname'] . ' ' . $member['customer_lastname'] . '</td>';
								echo '<td class="right"><a href="' . $medicalInfo_url . '" class="button tiny">Dossier médical</a></td>';
								echo '<td class="right"><a href="' . $edit_url . '" class="button tiny">Modifier</a></td>';
								echo '</tr>';
							}
							// Liste des profils issus d'une association
							foreach ($partnership_profiles as $member)
							{
								echo '<tr>';
								echo '<td><span class="label radius"> ' . $member['customer_firstname'] . ' ' . $member['customer_lastname'] . '</span></td>';
								echo '<td></td>';
								echo '</tr>';
							}

						?>
						</tbody>
					</table>
					<?php endif; ?>
					<a href="<?php echo site_url('customer/create'); ?>" class="custom-button-class">Nouveau membre</a>
				</div>
				
				<div class="panel radius">
				<?php $count = 1; ?>

					<?php if (!empty($partnership_pendings)): ?>
					<!-- Demandes en attente -->
					<h5>Demande(s) en attente</h5>
					<table style="width:100%">
						<tbody>
						<?php foreach($partnership_pendings as $pending): ?>
							<tr>
								<td><?php echo $pending['user']['user_login']; ?></td>
								<td><?php echo $pending['user']['user_email']; ?></td>
								<td class="right">
								<?php if ($pending['partnership_creator_user_key'] == $this->session->userdata('user_key')): ?>
									<a href="#" data-reveal-id="partnershipCancelConfirmBox<?php echo $count; ?>" data-reveal class="button tiny">Annuler la demande</a>
									<!-- Box de confirmation d'annulation de l'association -->
									<div id="partnershipCancelConfirmBox<?php echo $count++; ?>" class="reveal-modal" data-reveal>
										<p>
											Annuler l'association avec <?php echo $pending['user']['user_email']; ?> ?
										</p>
										<a href="javascript:void(0);" class="custom-button-class" id="partnershipCancel" onclick="partnershipCancel('<?php echo $pending['user']['user_key']; ?>');">Oui</a>
										<a class="custom-button-class" onclick="$('a.close-reveal-modal').trigger('click');">Non</a>
										<a class="close-reveal-modal">&times;</a>
									</div>
								<?php else: ?>
									<?php $partnershipConfirmUrl = site_url('partnership/confirm/' . $pending['user']['user_key'] . '/' . $this->session->userdata('user_key') . '/ack'); ?>
									<a href="<?php echo $partnershipConfirmUrl; ?>" id="partnershipConfirm" class="button tiny">Confirmation la demande</a>
								<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
					<?php endif; ?>

					<?php if (!empty($partnerships_users)): ?>
						<h5>Compte(s) associé(s)</h5>
						<table style="width:100%">
						<tbody>
					<?php foreach($partnerships_users as $user): ?>
						<tr>
						<td><?php echo $user['user_login']; ?></td>
						<td><?php echo $user['user_email']; ?></td>
						<td class="right"><a href="#" data-reveal-id="partnershipCancelConfirmBox<?php echo $count; ?>" data-reveal class="button tiny">Supprimer la relation</a></td>
						</tr>

						<!-- Box de confirmation d'annulation de l'association -->
						<div id="partnershipCancelConfirmBox<?php echo $count++; ?>" class="reveal-modal" data-reveal>
							<p>
								Annuler l'association avec <?php echo $user['user_email']; ?> ?
							</p>
							<a href="javascript:void(0);" class="custom-button-class" id="partnershipCancel" onclick="partnershipCancel('<?php echo $user['user_key']; ?>');">Oui</a>
							<a class="custom-button-class" onclick="$('a.close-reveal-modal').trigger('click');">Non</a>
							<a class="close-reveal-modal">&times;</a>
						</div>

					<?php endforeach; ?>

						</tbody>
						</table>

					<?php endif; ?>
					
					<h5>Nouvelle association</h5>
					<p><small>Pour associer votre compte à un autre et fusionner vos profils, veuillez préciser une adresse e-mail.</small></p>
					<div class="row" id="message"></div>
					<form id="partnershipCreate" action="<?php echo site_url('partnership/create'); ?>" method="post">
					<div class="row collapse">							
    					<div class="columns large-4">
      						<input type="text" name="login" placeholder="Adresse e-mail">
    					</div>
						<div class="columns large-6 end">
							<input type="submit" value="Associer" class="button tiny" />
						</div>
  					</div>
  					</form>
  					</div>		
				</div>
			</div>
		</div>

		<!-- Javascript utile pour cette page -->
		<script src="<?php echo js_url('cvi/partnership'); ?>"></script>