
<div id="step1" class="step active">

<div class="row">
		<div class="columns large-12">
			<div class="panel radius">
				<h6>Pensez à vérifier que vos informations sont à jour avant de prendre un rendez-vous.
			</div>
		</div>
</div>
	<!--<h5>Choix des membres</h5>-->
	<p>Sélectionnez les voyageurs :</p>

	<div class="message"></div>

	<div class="row">
		<div class="columns large-6">
	<?php 
		$membersArrays = array_chunk($family, 3);
		foreach($membersArrays as $membersArray)
		{
			foreach($membersArray as $member)
			{
				echo '<label for="' . $member['customer_key'] . '">';
				echo '<input type="checkbox" name="members[]" id="' . $member['customer_key'] . '" value="' . $member['customer_key'] . '" class="members" />';
				echo '&nbsp;';
				echo $member['customer_firstname'] . ' ' . $member['customer_lastname'];
				echo '</label>';
			}
			echo '</div><div class="columns large-6">';
		}
	?>
		</div>
	</div>
	<a onclick="selectAllCheckbox('members');" class="label secondary">Tout sélectionner</a>
</div>