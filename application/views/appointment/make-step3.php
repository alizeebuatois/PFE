<div id="step3" class="step hide">

	<p>Choisissez une ou plusieurs destinations.</p>

	<div class="message"></div>

	<div id="selects">
		<select name="destinations[]" id="select1">
			<optgroup label="">
				<option value="0" selected="selected">Sélectionnez une destination...</option>
			</optgroup>
			<optgroup label="Tour du monde">
				<option value="1">Tour du monde</option>
			</optgroup>

			<?php 
				$continents = $this->country_model->Country_getContinents();
				echo '<optgroup label="Continents">';
				foreach($continents as $continent)
				{
					echo '<option value="' . $continent['country_id']. '">' . $continent['country_label_fr'] . '</option>';
				}
				echo '</optgroup>';

				$domtoms = $this->country_model->Country_getDOMTOM();
				echo '<optgroup label="DOM-TOM">';
				foreach($domtoms as $domtom)
				{
					echo '<option value="' . $domtom['country_id']. '">' . $domtom['country_label_fr'] . '</option>';
				}
				echo '</optgroup>';

				$countries = $this->country_model->Country_getCountries();
				echo '<optgroup label="Pays">';
				foreach($countries as $country)
				{
					echo '<option value="' . $country['country_id']. '">' . $country['country_label_fr'] . '</option>';
				}
				echo '</optgroup>';
			?>			
		</select>
	</div>

	<a class="label secondary" onclick="addDestination();">Ajouter une destination</a>

</div>