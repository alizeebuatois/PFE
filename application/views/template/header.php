<!DOCTYPE html>
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="fr" >
<![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="fr" >
<!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" type="image/png" href="<?php echo img_url('favicon.png'); ?>" />
		<title>Centre de Vaccinations Internationales de Tours</title>
		<!-- CSS -->
		<link rel="stylesheet" href="<?php echo css_url('app'); ?>" />
		<link rel="stylesheet" href="<?php echo css_url('fi/foundation-icons'); ?>" />
		<link rel="stylesheet" href="<?php echo css_url('foundation-datepicker'); ?>" />
		<link rel="stylesheet" href="<?php echo css_url('fullcalendar'); ?>" />
		<!-- JS -->
		<script>
			var globalBaseURL = '<?php echo site_url(); ?>';
		</script>
		<script src="<?php echo js_url('vendor/modernizr'); ?>"></script>
		<script src="<?php echo js_url('vendor/jquery.min'); ?>"></script>
		<script src="<?php echo js_url('vendor/jquery-ui.min'); ?>"></script>
		<script src="<?php echo js_url('vendor/date.format'); ?>"></script>
		<script src="<?php echo js_url('cvi/cvi'); ?>"></script>

	</head>
<body>	
	<div id="wrap">
		<div id="main">

			<!-- Top bar -->
			<div class="contain-to-grid">
				<nav class="top-bar" data-topbar>
					<ul class="title-area">
						<li class="name"></li>
						<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
					</ul>
					<section class="top-bar-section">
						<ul class="left">
							<li><a href="<?php echo site_url(); ?>">Accueil</a></li>
							<li><a href="<?php echo site_url('qui-sommes-nous'); ?>">Qui sommes-nous ?</a></li>
							<li><a href="<?php echo site_url('bien-voyager'); ?>">Bien voyager</a></li>
							<li><a href="<?php echo site_url('contact'); ?>">Contact</a></li>
						</ul>
						<ul class="right">
						<?php if (!$this->session->userdata('connected')): ?>
							<li><a href="#" data-reveal-id="loginForm" data-reveal>Se connecter</a></li>
							<li><a href="<?php echo site_url('inscription'); ?>">S'inscrire</a></li>
						<?php else: ?>
							<li class="has-dropdown">
								<a href="#">Bonjour <?php echo $this->session->userdata('user_fullname'); ?></a>
								<?php if ($this->session->userdata('user_right') == 0): ?>
								<ul class="dropdown">
									<li><a href="<?php echo site_url('compte'); ?>">Mon compte</a></li>
									<li><a href="<?php echo site_url('appointment/make'); ?>">Prendre rendez-vous</a></li>
	          						<li><a href="<?php echo site_url('logout'); ?>">Déconnexion</a></li>
	        					</ul>
		        				<?php else: ?>
		        				<ul class="dropdown">
									<li><a href="<?php echo site_url('doctor/view/'.$this->session->userdata('user_doctor_key')); ?>">Mon compte</a></li>
									<?php if ($this->session->userdata('user_right') == 3): ?>
									<li><a href="<?php echo site_url('parameters'); ?>">Paramètres Généraux</a></li>
									<li><a href="<?php echo site_url('dparameters'); ?>">Paramètres des Documents</a></li>
									<li><a href="<?php echo site_url('backend/statistics'); ?>">Statistiques</a></li>
									<li><a href="<?php echo site_url('vaccins'); ?>">Vaccins</a></li>
									<li><a href="<?php echo site_url('treatment'); ?>">Traitements</a></li>
									<li><a href="<?php echo site_url('pdf'); ?>">PDF</a></li>
									<li><a href="<?php echo site_url('bbc'); ?>">BBC</a></li>
									<?php endif; ?>
	          						<li><a href="<?php echo site_url('logout'); ?>">Déconnexion</a></li>
	        					</ul>
		        				<?php endif; ?>
							</li>     					
						<?php endif; ?>
						<?php if ($this->session->userdata('user_right') > 0): ?>
						<li><a href="<?php echo site_url('dashboard'); ?>">Dashboard</a></li>
						<?php endif; ?>
						</ul>
					</section>
				</nav>
			</div>

			<?php if (!$this->session->userdata('connected')): ?>
			<!-- Formulaire de connexion -->
			<div id="loginForm" class="reveal-modal" data-reveal>
				<div class="row">
					<div class="columns large-12">
						<h5>Connectez-vous...</h5>
						<form method="post" action="<?php echo site_url('login'); ?>">
							<input type="text" name="login" placeholder="Nom d'utilisateur ou adresse e-mail" />
							<input type="password" name="password" placeholder="Mot de passe" />
							<input type="checkbox" name="remember" id="rem1" value="yes" /><label for="rem1">Se souvenir de moi</label>
							<div class="row">
								<div class="columns large-5">
									<input type="submit" class="custom-button-class small" value="Connexion" />
								</div>
								<div class="columns large-7 text-right">
									<small><a href="<?php echo site_url('inscription'); ?>">Pas encore de compte ?</a><br /><a href="<?php echo site_url('user/password'); ?>">Mot de passe oublié ?</a></small>
								</div>
							</div>
						</form>
					</div>
				</div>					
				<a class="close-reveal-modal">&times;</a>
			</div>
			<?php endif; ?>

			<!-- Bannière -->
			<header>
				<div class="row">
					<div class="columns large-8"><a href="<?php echo base_url(); ?>"><?php echo img('banner.png','CHRU Logo','100%'); ?></a></div>
					<div class="columns large-4 medium-4 medium-right small-8 small-right" id="upcomingAppointments"></div>
				</div>
			</header>