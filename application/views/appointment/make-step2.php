<div id="step2" class="step hide">

	<p>Sélectionnez les dates de départ et de retour.</p>

	<div class="message"></div>

	<div class="row">
		<div class="columns large-5">
			<div class="row collapse">
				<label for="departure">Départ <small>Obligatoire</small></label>
				<div class="columns large-10">
					<input type="text" class="dp-departure" name="departureDate" id="departure" /><small id="fullDepartureDate"></small>

				</div>
				<div class="columns large-2">
					<span class="postfix"><i class="fi-calendar"></i></span>
				</div>
			</div>
		</div>
		<div class="columns large-5 end">
			<div class="row collapse">
				<label for="return">Retour </label>
				<div class="columns large-10">
					<input type="text" class="dp-return" name="returnDate" id="return" disabled /><small id="fullReturnDate"></small>
				</div>
				<div class="columns large-2">
					<span class="postfix"><i class="fi-calendar"></i></span>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="columns large-12">
			<small class="trip-duration"></small>
		</div>
	</div>
</div>