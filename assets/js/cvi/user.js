$(document).ready(function(){
	
	// Champ Date de naissance du nouveau membre
	$('#newprofiledate').fdatepicker({
		format: 'yyyy-mm-dd'
	});

	// Récupération des comptes clients pour l'autocomplete du champ recherche pour association 
	$.get(globalBaseURL + 'user/getAllAutocomplete', function(result) {
		$("#search").autocomplete({
			source: $.parseJSON(result),
			minLength: 2,
			select: function (event, ui) {
				$('#user_key').val(ui.item.key);
			}
		});
		$('.ui-autocomplete').addClass('f-dropdown');
	});

});
