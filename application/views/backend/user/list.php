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

	<div class="row">
		<?php require_once(__DIR__.'/../backend-nav.php'); ?>
		<div class="columns large-9">
			<div class="panel radius">
				<div class="row">
					<div class="columns large-6 medium-6 small-6">
						<h4>Utilisateurs du CVI</h4>
					</div>
					<?php if ($this->session->userdata('user_right') > 1): ?>
					<div class="columns large-6 medium-6 small-6 text-right">
						<a href="<?php echo site_url('user/create'); ?>" class="custom-button-class">Nouveau</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
			
			<form action="" method="" id="search-form">
			<div class="panel radius">
				<div class="row collapse">
					<div class="columns large-4">
						<input type="text" id="search" placeholder="Rechercher un utilisateur" />
					</div>
					<div class="columns large-1 text-center">
						<p style="line-height:37px;">par :</p>
					</div>
					<div class="columns large-3">
						<select id="filter">
							<option value="titulaire">Titulaire</option>
							<option value="login">Identifiant</option>
							<option value="email">Adresse e-mail</option>
							<option value="phone">Téléphone</option>
						</select>
					</div>
					<div class="colums large-4">
						<input type="submit" class="button tiny" id="search-submit" value="Rechercher" />
						<input type="reset" class="button tiny" id="reset" value="Reset" />
					</div>
				</div>
			</div>
			</form>
				
			<div class="row">
				<div class="columns large-12">
					<table style="width:100%">
						<thead>
							<tr>
								<th>Titulaire</th>
								<th>Identifiant</th>
								<!--<th>Type de compte</th>-->
								<th>Adresse e-mail</th>
								<th>Téléphone</th>
								<?php if ($this->session->userdata('user_right') > 1): ?>
								<!--<th></th>-->
								<?php endif; ?>
								<th>Actif</th>
							</tr>
						</thead>
						<tbody id="users">
						</tbody>
					</table>
				</div>
				<p class="text-center" id="loading">
					<?php echo img('ajax-loader.gif', 'Chargement...'); ?><br />
				</p>
			</div>
		</div>
	</div>
	
	<script>
		$(document).ready(function(){
		
			reset();
			
			$('form#search-form').submit(function(){
				$('#users').empty();
				$('#loading').show();
				var search = $('#search').val();
				var filter = $('#filter').val();
				
				$.get(globalBaseURL + 'user/search?s='+search+'&f='+filter, function(data){
					$('#loading').hide();
					$('#users').html(data);
				});
				
				return false;				
			});
			
			$('#reset').on('click',function(){reset()});
		});
		
		function reset() {
			$('#users').empty();
			$('#loading').show();
			$('#users').load(globalBaseURL + 'user/search', function(){
				$('#loading').hide();
			});
		}
	</script>