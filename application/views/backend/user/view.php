<?php
	$countriesList = $this->country_model->Country_getAllCountries();
	$fullName = $this->user_model->User_getMainName($user_key);
?>

<!--<style></style>-->

<div class="row">
	<?php require_once(__DIR__.'/../backend-nav.php'); ?>
	<div class="columns large-9">
		<div class="row">
			<div class="columns large-6 medium-6 small-6">
				<p><a href="<?php echo site_url('user/view/'.$user_key); ?>" class="button"><?php echo strtoupper($user_login); ?></a></p>
			</div>
			<div class="columns large-6 medium-6 small-6 text-right">
				<a class="button" href="javascript:history.back();">Retour</a>
			</div>
		</div>

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

		<div class="row"><div id="message"></div></div>

		<!-- TABS -->
		<dl class="tabs" data-tab>
			<dt></dt>
			<dd class="active"><a href="#details">Détails</a></dd>
			<?php if($this->session->userdata('user_right') > 1 || $this->session->userdata('user_doctor_key') == $user_default_customer_key): ?>
			<dd><a href="#info">Modification du compte</a></dd>
			<?php endif; ?>
			<?php if($user_right == 0): ?>
			<dd><a href="#family">Famille</a></dd>
			<?php endif; ?>
		</dl>

		<div class="tabs-content">
			<div class="content active" id="details">
				<div class="row">
					<div class="columns large-6">
						<p>
							<label>Identifiant</label>
							<?php echo $user_login; ?>
						</p>
						<p>
							<label>Type de compte</label>
							<?php
								switch($user_right)
								{
									case 1: echo 'Personnel de soin'; break;
									case 2: echo 'Secrétaire'; break;
									case 3: echo 'Administrateur'; break;
									default: echo 'Client'; break;
								}
							?>
						</p>
						<p>
							<label>Adresse e-mail</label>
							<?php if(!empty($user_email)): ?>
							<i class="fi-mail"></i>&nbsp;<a href="mailto:<?php echo $user_email; ?>"><?php echo $user_email; ?></a>
							<?php endif; ?>
						</p>
						<p>
							<label>Propriétaire</label>
							<?php if($user_right == 0): ?>
							<a href="<?php echo site_url('customer/view/'.$user_default_customer_key); ?>">
							<?php echo $fullName; ?></a>
							<?php else: ?>
								<?php if ($this->session->userdata('user_right') > 1): ?>
							<a href="<?php echo site_url('doctor/view/'.$user_default_customer_key); ?>">
							<?php echo $fullName; ?></a>
								<?php else: ?>
							<?php echo $fullName; ?>
								<?php endif; ?>
							<?php endif; ?>
						</p>
					</div>
					<div class="columns large-6">
						<!--<p>
							<label>Mot de passe</label>
							********
						</p>-->
						<p>
							<label>Adresse postale</label>
							<?php if (!empty($user_address1)): ?>
							<?php echo $user_address1; ?><br />
							<?php endif; ?>
							<?php if (!empty($user_address2)) : ?>
							<?php echo $user_address2; ?><br />
							<?php endif; ?>
							<?php echo $user_postalcode . ' ' . $user_city; ?>
							<?php if($user_country_id > 0): ?>
							<br /><?php echo $this->country_model->Country_getLabelById($user_country_id); ?>
							<?php endif; ?>
						</p>
						<p>
							<label>Téléphone</label>
							<?php if(!empty($user_phone)): ?>
							<i class="fi-telephone"></i>&nbsp;<?php echo $user_phone; ?><br />
							<?php endif; ?>
						</p>
						<p>
							<label>Dernière connexion</label>
							<?php if (!empty($user_lastConnection)): ?>
							<?php echo full_date($user_lastConnection); ?>
							<?php else: ?>
							Jamais
							<?php endif; ?>
						</p>
					</div>
				</div>
						
			</div>

			<?php if($this->session->userdata('user_right') > 1 || $this->session->userdata('user_doctor_key') == $user_default_customer_key): ?>
			<div class="content" id="info">
				<form action="<?php echo site_url('user/updateAjax'); ?>" method="post" class="ajaxPost">
				<input type="hidden" name="user_key" value="<?php echo $user_key; ?>" />

				<div class="row">
					<div class="columns large-4"><p class="right">Identifiant</p></div>
					<div class="columns large-4 end">
						<input type="text" name="login" placeholder="Identifiant" value="<?php echo $user_login; ?>" />
					</div>
				</div>

				<div class="row">
					<div class="columns large-4"><p class="right">Mot de passe</p></div>
					<div class="columns large-6 end">
						********<!--<br /><p><small><a href="">Renvoyer un nouveau mot de passe</a></small></p>-->
					</div>
				</div>

				<div class="row">
					<div class="columns large-4"><p class="right">Adresse e-mail</p></div>
					<div class="columns large-5 end">
						<input type="text" name="email" placeholder="Adresse e-mail" value="<?php echo $user_email; ?>" />
					</div>
				</div>

				<div class="row">
					<div class="columns large-4"><p class="right">Adresse</p></div>
					<div class="columns large-5 end">
						<input type="text" name="address1" placeholder="Adresse" value="<?php echo $user_address1; ?>" />
					</div>
				</div>

				<div class="row">
					<div class="columns large-4"><p class="right">Complément d'adresse</p></div>
					<div class="columns large-5 end">
						<input type="text" name="address2" placeholder="Complément adresse (facultatif)" value="<?php echo $user_address2; ?>" />
					</div>
				</div>

				<div class="row">
					<div class="columns large-4"><p class="right">Code postal</p></div>
					<div class="columns large-2 end">
						<input type="text" name="postalcode" placeholder="Code postal" value="<?php echo $user_postalcode; ?>" />
					</div>
				</div>

				<div class="row">
					<div class="columns large-4"><p class="right">Ville</p></div>
					<div class="columns large-5 end">
						<input type="text" name="city" placeholder="Ville" value="<?php echo $user_city; ?>" />
					</div>
				</div>

				<div class="row">
					<div class="columns large-4"><p class="right">Pays</p></div>
					<div class="columns large-5 end">
						<select name="country_id" id="country_id">
							<option value="0">Pays</option>
					 			<?php 
					 				foreach($countriesList as $country)
					 				{
					 					echo '<option value="' . $country['country_id'] . '"';
					 					if ($user_country_id == $country['country_id']) echo ' selected="selected">';
					 					else echo '>';
					 					echo $country['country_label_fr'] . '</option>';
					 				}
					 			?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="columns large-4"><p class="right">Téléphone</p></div>
					<div class="columns large-5 end">
						<input type="text" name="phone" placeholder="Téléphone" value="<?php echo $user_phone; ?>" />
					</div>
				</div>

				<?php if ($this->session->userdata('user_right') == 3): ?>
				<div class="row">
					<div class="columns large-4"><p class="right">Droit d'accès</p></div>
					<div class="columns large-4 end">
						<select name="user_right" <?php if($user_right==0)echo 'disabled="disabled"'; ?>>
						<?php
							$rights = array();
							if ($user_right == 0) {
								array_push($rights, array('id' => 0, 'name' => 'Client'));
							}
							array_push($rights, array('id' => 1, 'name' => 'Personnel de soin'));
							array_push($rights, array('id' => 2, 'name' => 'Secrétaire'));
							array_push($rights, array('id' => 3, 'name' => 'Administrateur'));
							foreach ($rights as $right)
							{
								echo '<option value="' . $right['id'] . '" ';
								if ($user_right == $right['id']) echo 'selected="selected">';
								else echo '>';
								echo $right['name'];
								echo '</option>';
							}    
						?>
						</select>
					</div>
				</div>
				<?php endif; ?>

				<div class="row">
					<div class="columns">
						<input type="submit" value="Mettre à jour" class="custom-button-class" />
					</div>
				</div>
				</form>
			</div>
			<?php endif; ?>
			<?php if($user_right == 0): ?>
			<div class="content" id="family">
				<div class="row">
					<div class="columns large-6">
						<p>
							<label>Profils</label>
							
							<?php foreach($profiles as $profile): ?>
								
								<a href="<?php echo site_url('customer/view/'.$profile['customer_key']); ?>">
								<?php echo $this->customer_model->Customer_getFullName($profile['customer_key']); ?>
								</a><br />
							
							<?php endforeach; ?>
						</p>
						<label>Nouveau profil</label>
						<form action="<?php echo site_url('customer/createFast'); ?>" method="post" class="ajaxPost">
						<input type="hidden" name="user_key" value="<?php echo $user_key; ?>" />
							<div class="row">
								<div class="columns large-4 end">									
									<select name="title">
									<?php
										$titles = array('Mlle.', 'M.');
										foreach ($titles as $title)
										{
											echo '<option value="' . $title . '">';
											echo $title;
											echo '</option>';
										}    
									?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="columns large-9 end">									
									<input type="text" name="firstname" placeholder="Prénom" />
								</div>
							</div>
							<div class="row">
								<div class="columns large-9 end">									
									<input type="text" name="lastname" placeholder="Nom" />
								</div>
							</div>
							<div class="row">
								<div class="columns large-7 end">									
									<input type="text" name="birthdate" placeholder="Date de naissance" id="newprofiledate" />
								</div>
							</div>
							<div class="row">
								<div class="columns large-9 end">									
									<input type="submit" value="Créer" class="custom-button-class" />
								</div>
							</div>
						</form>													
					</div>
					<div class="columns large-6">
						<p>
							<label>Relations</label>
							<?php if(empty($partners)): ?>
							Aucune
							<?php else: ?>
								<?php foreach($partners as $partner): ?>
									<?php if ($partner['partnership_a_user_key'] == $user_key): ?>
										<a href="<?php echo site_url('user/view/'.$partner['partnership_b_user_key']); ?>">
										<?php echo $this->user_model->User_getMainName($partner['partnership_b_user_key']); ?>
										</a><br />
									<?php else: ?>
										<a href="<?php echo site_url('user/view/'.$partner['partnership_a_user_key']); ?>">
										<?php echo $this->user_model->User_getMainName($partner['partnership_a_user_key']); ?>
										</a><br />
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						</p>
	
						<label>Nouvelle relation</label>
						<form action="<?php echo site_url('partnership/createFast'); ?>" method="post" class="ajaxPost">
							<div class="row">
								<div class="columns large-9 end">
									<input type="hidden" name="user_a" value="<?php echo $user_key; ?>" />					
									<input type="text" name="usersearch" id="search" placeholder="Rechercher un utilisateur" />
									<input type="hidden" name="user_b" id="user_key" />
								</div>
							</div>
							<div class="row">
								<div class="columns large-9 end">									
									<input type="submit" value="Créer" class="custom-button-class" />
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<script src="<?php echo js_url('cvi/user'); ?>"></script>