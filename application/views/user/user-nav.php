			<?php $selected_menu = $this->config->item('user-nav-selected-menu'); ?>

			<div class="columns large-3">
				<div class="panel radius">
					<h6>Mon compte</h6>

					<ul class="side-nav">
						<li <?php if($selected_menu==1)echo'class="active"';?>>
							<a href="<?php echo site_url('compte'); ?>">Mes informations personnelles</a>
						</li>

						<li class="divider"></li>

						<li <?php if($selected_menu==2)echo'class="active"';?>>
							<a href="<?php echo site_url('customer/medicalinfo'); ?>">Mes informations médicales</a>
						</li>

						<li class="divider"></li>

						<li <?php if($selected_menu==3)echo'class="active"';?>>
							<a href="<?php echo site_url('customer/medicalhistoric'); ?>">Mon historique médical</a>
						</li>

						<li class="divider"></li>

						<li <?php if($selected_menu==4)echo'class="active"';?>>
							<a href="<?php echo site_url('compte/famille'); ?>">Ma famille</a>
						</li>
						
						<li class="divider"></li>
						
						<li <?php if($selected_menu==5)echo'class="active"';?>>
							<a href="<?php echo site_url('appointment'); ?>">Mes rendez-vous</a>
						</li>
						
						<li class="divider"></li>
						
						<li><a href="<?php echo site_url('logout'); ?>">Déconnexion</a></li>
					</ul>

					<!--<small>Compte complet à 50%</small>
					<div class="progress success">
						<span class="meter" style="width: 50%"></span>
					</div>-->

				</div>
			</div>