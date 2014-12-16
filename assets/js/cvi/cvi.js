$(document).ready(function() {	

	/*
	 * Envoi d'un formulaire par Ajax
	 */
	$('form.ajaxPost').submit(function(){

		$.ajax({
			url: this.action,
			type: this.method,
			data: $(this).serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				if(data['success'])
				{
					if (data['reload'])
					{
                    	window.location.reload();
                    	return;
					}
                    else
                    {
                    	// Message pour alerte du type succès
						message = 
	                        '<div data-alert class="alert-box success radius">' +                                
	                            data['message'] +
	                            '<a href="#" class="close">&times;</a>' +
	                        '</div>';
	                }
				}
				else
				{
					// Message pour alerte de type warning
					message = 
                        '<div data-alert class="alert-box warning radius">' +                                
                            data['message'] +
                            '<a href="#" class="close">&times;</a>' +
                        '</div>';
				}

				// Affichage de l'alerte sur la page
                $('#message').html('<div class="columns large-12">' + message + '</div>');
                $('html, body').animate({ scrollTop: $('#message').position().top }, 'slow');

                $(document).foundation(); // Nécessaire pour pouvoir fermer l'alert-box

			},
			error: function() {
				alert('Une erreur s\'est produite. La page va être rechargée.');
			}
		});

		// Evite au formulaire d'être renvoyé une seconde fois avec chargement de page
		return false;
	});

});

/*
 * Retourne une date dans son format complet (ex : Vendredi 14 Mars 2014)
 */
function getLongFrenchDate(date)
{
    var months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    var days = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
    return days[date.getDay()] + ' ' + date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
}

/*
 * Supprime totalement une balise du DOM donnée par son id
 */
function removeTags(id)
{
 	$(id).remove();
}
