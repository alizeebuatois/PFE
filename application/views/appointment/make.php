	<div class="row">
		<!-- Il faut ici faire un if sur les droits pour afficher la bonne barre de nanigation latérale...-->
			<?php require_once(__DIR__.'/../user/user-nav.php'); ?> 

		<div class="columns large-9">
			<!--<div class="row">
				<div class="columns large-12">
					<!-- Breadcrumbs -->
					<!--<ul class="breadcrumbs">
						<li class="current" id="1">Choix des membres</li>
						<li id="2">Dates du voyage</li>
						<li id="3">Destinations</li>
						<li id="4">Hébergement</li>
						<li id="5">Activités</li>
						<li id="6">Date du rendez-vous</li>
						<li id="7">Confirmation</li>
					</ul>
				</div>
			</div>-->
			<div class="row">
				<div class="columns large-12">
					<div class="panel radius">
						<h5>Formulaire de prise de rendez-vous</h5>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="columns large-12">
					<!-- Formulaire -->
					<div class="panel radius">
						<form action="<?php echo site_url('appointment/make'); ?>" method="post" id="makeAppointmentForm">

							<?php 
								require_once('make-step1.php'); // Liste des membres
								require_once('make-step2.php'); // Choix des dates
								require_once('make-step3.php'); // Destinations
								require_once('make-step4.php'); // Hébergements
								require_once('make-step5.php'); // Activités
								require_once('make-step6.php'); // Date du rendez-vous
								require_once('make-step7.php'); // Confirmation
							?>					

							<div class="row">
								<div class="columns large-12" style="margin-top:1.5em;">

									<div class="hide"><a class="custom-button-class previous left">Retour</a></div>
									<a class="custom-button-class continue right clearfix">Continuer</a>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>	
		<!--<div class="columns large-4">
			<div class="panel radius">
				<h3>Lorem ipsum</h3>
				<p>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</p>
			</div>
		</div>-->
	</div>

	<script src="<?php echo js_url('cvi/appointment'); ?>"></script>