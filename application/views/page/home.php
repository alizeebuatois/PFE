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

		<!-- Slider -->
		<div class="row" style="margin-bottom:40px;">
			<div class="columns large-8">
				<ul class="example-orbit" data-orbit>
					<li>
						<?php echo img('slide0.jpg', 'slide 0'); ?>
						<div class="orbit-caption">Bienvenue sur la nouvelle plateforme en ligne du Centre de Vaccinations Internationales du CHRU de Tours.</div>
					</li>
					<li>
						<?php echo img('slide1.jpg', 'slide 1'); ?>
						<div class="orbit-caption">Le Centre de Vaccinations Internationales du CHRU de Tours vous accueille du Lundi au Vendredi avant vos départs à l'étranger.</div>
					</li>
					<li>
						<?php echo img('slide2.jpg', 'slide 2'); ?>
						<div class="orbit-caption">Nouveau ! Remplissez désormais vos informations médicales en ligne.</div>
					</li>
				</ul>
			</div>
			<div class="columns large-4">
			<?php if (!$this->session->userdata('connected')): ?>	
				<h4 class="text-center">Prenez rendez-vous...</h4>		
				<form method="post" action="<?php echo site_url('login'); ?>">
					<input type="text" name="login" placeholder="Nom d'utilisateur ou adresse e-mail" />
					<input type="password" name="password" placeholder="Mot de passe" />
					<input type="checkbox" name="remember" id="rem" value="yes" /><label for="rem">Se souvenir de moi</label>
					<div class="row">
						<div class="columns large-5">
							<input type="submit" class="custom-button-class small" value="Connexion" />
						</div>
						<div class="columns large-7 text-right">
							<small><a href="<?php echo site_url('inscription'); ?>">Pas encore de compte ?</a><br /><a href="<?php echo site_url('user/password'); ?>">Mot de passe oublié ?</a></small>
						</div>
					</div>
				</form>
			<?php else: ?>
				<?php if ($this->session->userdata('user_right') > 0): ?>
				<h4 class="text-center">Accéder au système</h4>
				<p class="text-center">Le système de gestion est accessible via le Dashboard, en cliquant ci-dessous.<br /><br /><br />
				<a href="<?php echo site_url('dashboard'); ?>" class="button large">Dashboard</a></p>
				<?php else: ?>	
				<h4 class="text-center">Prenez rendez-vous...</h4>
				<p class="text-center">Le Centre de Vaccinations Internationales vous accueille et vous vaccine avant votre départ en vacances !<br /><br /><br />
				<a href="<?php echo site_url('appointment/make'); ?>" class="button large">Prendre rendez-vous</a></p>
				<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
