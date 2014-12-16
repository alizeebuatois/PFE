<?php
	$countries = $this->country_model->Country_getCountriesTable();
?>
		<div class="row">
			<?php require_once('user-nav.php'); ?>
			<div class="columns large-9">
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
				
				<div class="panel radius">
					<div class="row">
						<div class="columns large-6">
							<h5>Informations relatives au compte</h5>
						</div>
						<div class="columns large-6 text-right">
							<a href="<?php echo site_url('compte/modifier'); ?>" class="button tiny">Modifier</a>
						</div>
					</div>
					
					<table style="width:100%">
						<tbody>
							<tr>
								<td>Login</td>
								<td><?php echo $user['user_login']; ?></td>
							</tr>
							<tr>
								<td>Mot de passe</td>
								<td>********</td>
							</tr>
							<tr>
								<td>Adresse e-mail</td>
								<td><?php echo $user['user_email']; ?></td>
							</tr>
							<tr>
								<td>Adresse postale</td>
								<td>
									<?php echo $user['user_address1']; ?><br />
									<?php if ($user['user_address2'] != ''): ?>
									<?php echo $user['user_address2']; ?><br />
									<?php endif; ?>
									<?php echo $user['user_postalcode'] . ' ' . $user['user_city']; ?><br />
									<?php if ($user['user_country_id'] > 0): ?>
									<?php echo $countries[$user['user_country_id']]; ?>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td>Téléphone</td>
								<td><?php echo $user['user_phone']; ?></td>
							</tr>
							<tr>
								<td>Dernière connexion</td>
								<td><?php echo full_date($this->session->userdata('user_lastConnection')); ?></td>
							</tr>
							<tr>
								<td>Date d'inscription</td>
								<td><?php echo full_date($user['user_creation']); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="panel radius">
					<div class="row">
						<div class="columns large-6">
							<h5>Informations personnelles</h5>
						</div>
						<div class="columns large-6 text-right">
							<a href="<?php echo site_url('compte/client/modifier'); ?>" class="button tiny">Modifier</a>
						</div>
					</div>
					<table style="width:100%">
						<tbody>
							<tr>
								<td>Nom</td>
								<td><?php echo strtoupper($customer['customer_lastname']); ?></td>
							</tr>
							<tr>
								<td>Prénom</td>
								<td><?php echo $customer['customer_firstname']; ?></td>
							</tr>
							<tr>
								<td>Date de naissance</td>
								<td><?php echo display_date($customer['customer_birthdate']); ?></td>
							</tr>
							<tr>
								<td>Lieu de naissance</td>
								<td>
									<?php if ($customer['customer_birthcity'] != null): ?>
									<?php echo $customer['customer_birthcity'] . ', ' . $countries[$customer['customer_birth_country_id']]; ?>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
							<tr>
								<td>Age</td>
								<td><?php echo $customer['customer_age']; ?></td>
							</tr>
								<td>Sexe</td>
								<td>
									<?php
										switch($customer['customer_sex']){
											case 'M': echo 'Homme'; break;
											case 'F': echo 'Femme'; break;
										}
									?>
								</td>
							</tr>
							<tr>
								<td>Poids</td>
								<td><?php echo $customer['customer_weight']; ?></td>
							</tr>
							<tr>
								<td>Numéro de sécurité sociale</td>
								<td><?php echo $customer['customer_numsecu']; ?></td>
							</tr>
							<tr>
								<td>Groupe sanguin</td>
								<td><?php echo $customer['customer_bloodgroup']; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>