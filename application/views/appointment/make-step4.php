<div id="step4" class="step hide">
	
	<p>Sélectionnez un ou plusieurs types d'hébergement.</p>

	<div class="message"></div>

	<div class="row">
		<div class="columns large-6">
			
			<?php
				$hostings = $this->hosting_model->Hosting_getAll();
				$hostingsArrays = array_chunk($hostings, 3);
				foreach($hostingsArrays as $hostingsArray)
				{
					foreach($hostingsArray as $hosting)
					{
						echo '<label for="' . $hosting['hosting_label_fr'] . '">';
						echo '<input type="checkbox" name="hostings[]" id="' . $hosting['hosting_label_fr'] . '" value="' . $hosting['hosting_id'] . '" class="hostings" />';
						echo '&nbsp;';
						echo ucfirst($hosting['hosting_label_fr']);
						echo '</label>';
					}
					echo '</div><div class="columns large-6">';
				}
			?>

		</div>
	</div>
</div>