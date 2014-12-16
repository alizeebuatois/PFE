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
					<div class="columns large-12">
						<h4>Voyageurs</h4>
					</div>
				</div>
			</div>
			
			<form action="" method="" id="search-form">
			<div class="panel radius">
				<div class="row collapse">
					<div class="columns large-4">
						<input type="text" id="search" placeholder="Rechercher un voyageur" autocomplete="off" />
					</div>
					<div class="columns large-1 text-center">
						<p style="line-height:37px;">par :</p>
					</div>
					<div class="columns large-3">
						<select id="filter">
							<option value="fullname">Nom complet</option>
							<option value="lastname">Nom de famille</option>
							<option value="firstname">Prénom</option>
							<option value="birthcity">Ville de naissance</option>
							<option value="bloodgroup">Groupe sanguin</option>
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
							<th>Genre</th>
							<th>Prénom</th>
							<th>Nom de famille</th>
							<th>Date de naissance</th>
							<th>Ville de naissance</th>							
							<!--<th>Date de naissance</th>-->
							<th>Malade chronique</th>
						</thead>
						<tbody id="customers">
						</tbody>
					</table>
					<p class="text-center" id="loading"><?php echo img('ajax-loader.gif', 'Chargement...'); ?></p>
				</div>
			</div>
		</div>
	</div>
	
	<script>
		$(document).ready(function(){
		
			reset();
			
			$('form#search-form').submit(function(){
				$('#customers').empty();
				$('#loading').show();
				var search = $('#search').val();
				var filter = $('#filter').val();
				
				$.get(globalBaseURL + 'customer/search?s='+search+'&f='+filter, function(data){
					$('#loading').hide();
					$('#customers').html(data);
				});
				
				return false;				
			});
			
			$('#reset').on('click',function(){reset()});
		});
		
		function reset() {
			$('#customers').empty();
			$('#loading').show();
			$('#customers').load(globalBaseURL + 'customer/search', function(){
				$('#loading').hide();
			});
		}
	</script>