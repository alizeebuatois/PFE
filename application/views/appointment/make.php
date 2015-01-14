	<div class="row">
		<!-- Il faut ici faire un if sur les droits pour afficher la bonne barre de navigation latérale...-->
			<?php 
				if ($this->session->userdata('user_right') > 0)
				{
					$selected_menu = 6;
					require_once(__DIR__.'/../backend/backend-nav.php');
				}
				else
					require_once(__DIR__.'/../user/user-nav.php');
			?>

		<div class="columns large-9">
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
	</div>

	<script src="<?php echo js_url('cvi/appointment'); ?>"></script>