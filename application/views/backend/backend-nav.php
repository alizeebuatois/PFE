			<?php $selected_menu = $this->config->item('user-nav-selected-menu'); ?>

			<div class="columns large-3">
				<div class="panel radius">
					<h6>Gestion CVI</h6>

					<ul class="side-nav">
						<li <?php if($selected_menu==1)echo'class="active"';?>>
							<a href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
						</li>
						
						<li class="divider"></li>

						<li <?php if($selected_menu==2)echo'class="active"';?>>
							<a href="<?php echo site_url('doctor/view/'.$this->session->userdata('user_doctor_key')); ?>">Mon compte</a>
						</li>

						<li class="divider"></li>

						<li <?php if($selected_menu==3)echo'class="active"';?>>
							<a href="<?php echo site_url('backend/schedule'); ?>">Planning</a>
						</li>
						
						<li class="divider"></li>

						<li <?php if($selected_menu==6)echo 'class="active"';?>>
							<a href="<?php echo site_url('user'); ?>">Utilisateurs</a>
						</li>

						<li class="divider"></li>

						<li <?php if($selected_menu==4)echo'class="active"';?>>
							<a href="<?php echo site_url('doctor'); ?>">Personnel de soin</a>
						</li>

						<li class="divider"></li>

						<li <?php if($selected_menu==5)echo'class="active"';?>>
							<a href="<?php echo site_url('customer'); ?>">Voyageurs</a>
						</li>

						<li class="divider"></li>
						<?php if ($this->session->userdata('user_right') > 2): ?>
							<li <?php if($selected_menu==7)echo'class="active"';?>>
							<a href="<?php echo site_url('backend/admin'); ?>">Administration</a>
							</li>
						<li class="divider"></li>
						<?php endif; ?>


						
						<li><a href="<?php echo site_url('logout'); ?>">Déconnexion</a></li>
					</ul>

				</div>
			</div>