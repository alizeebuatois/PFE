<div id="step5" class="step hide">
	
	<p>Sélectionnez une ou plusieurs activités.</p>

	<div class="message"></div>

	<div class="row">
		<div class="columns large-6">
			
			<?php
				$activities = $this->activity_model->Activity_getAll();
				$activitiesArrays = array_chunk($activities, 3);
				foreach($activitiesArrays as $activitiesArray)
				{
					foreach($activitiesArray as $activity)
					{
						echo '<label for="' . $activity['activity_label_fr'] . '">';
						echo '<input type="checkbox" name="activities[]" id="' . $activity['activity_label_fr'] . '" value="' . $activity['activity_id'] . '" class="activities" />';
						echo '&nbsp;';
						echo ucfirst($activity['activity_label_fr']);
						echo '</label>';
					}
					echo '</div><div class="columns large-6">';
				}
			?>

		</div>
	</div>
</div>