			</div>
		</div>

		<div id="footer">
			<div class="row">
				<div class="columns large-5">
					<div class="row collapse" style="margin-bottom:15px;">
						<div class="columns large-3">
							<a href="http://www.chu-tours.fr/sites-du-chu/"><?php echo img('icon-plansite.png','plan'); ?></a>
						</div>
						<div class="columns large-9">
							<p style="font-size:0.9em;padding-top:15px;"><a href="http://www.chu-tours.fr/sites-du-chu/">Plan d'accès aux Hôpitaux de Tours</a></p>
						</div>
					</div>
					<div class="row collapse">
						<div class="columns large-3">
							<?php echo img('logo-polytech2.png', 'Polytech', '55px'); ?>
						</div>
						<div class="columns large-9">
							<p style="line-height:20px;font-size:0.9em;">
								Site internet réalisé par des étudiants de 5<sup>ème</sup> année à l'Ecole Polytechnique de l'Université de Tours.
							</p>
						</div>
					</div>
				</div>
				<div class="columns large-7 text-right">
					<div class="row collapse">
						<div class="columns large-10 text-right" style="padding-right:10px;">
							<p style="line-height:20px;">
								<strong>Centre Hospitalier<br />Régional Universitaire de Tours</strong><br />
								37044 Tours Cedex 9<br />
								Tél. : 02.47.47.38.49
							</p>
						</div>
						<div class="columns large-2">
							<?php echo img('chru_logo_blanc.png', 'Chru', '80px'); ?>
						</div>
					</div>
					<div class="row collapse" style="padding-top:35px;">
						<div class="columns large-11 text-right">
							<p style="font-size:0.6em;">&copy; 2014 - CHRU de Tours - Polytech Tours - Tous droits réservés.</p>
						</div>
						<div class="columns large-1">							
						</div>
					</div>
					
				</div>
			</div>
		</div>

		<script src="<?php echo js_url('foundation/foundation.min'); ?>"></script>
		<script src="<?php echo js_url('foundation/foundation.alert'); ?>"></script>
		<script src="<?php echo js_url('foundation/foundation-datepicker'); ?>"></script>
		<script src="<?php echo js_url('foundation/app'); ?>"></script>
		
		<?php if ($this->session->userdata('connected') && $this->session->userdata('user_right') == 0): ?>
		<script>
			$(document).ready(function(){
				$("#upcomingAppointments").load(globalBaseURL + 'appointment/upcomingAppointments');
			});
		</script>			
		<?php endif; ?>
	</body>
</html>
