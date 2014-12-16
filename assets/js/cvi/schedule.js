$(document).ready(function() {

	// Affichage du calendrier et chargement des données via l'URL défaut
	$('#calendar').fullCalendar({
		selectable: true,
		selectHelper: true,
		editable: false,
		events: getJsonURL,
		eventRender: function(event, element) { 
			element.find('.fc-event-title').html("<br />" + event.title + "<br/><br />" + event.description); 
		}
	});

	// Changement des données du calendrier
	$('.doctors').change(function() {
		// suppression des ressources courantes
		$('#calendar').fullCalendar('removeEventSource', getJsonURL);
		
		// ajout de la nouvelle ressource
		getJsonURL = globalBaseURL + 'appointment/getEventsJson/' + $('.doctors').val();
		$("#calendar").fullCalendar('addEventSource', getJsonURL);
	});	
});