var generalVaccin;
var vaccins;

var nbVaccins;

var compteur =0;

$(document).ready(function(){

	nbVaccins = 0;

	// Récupération de l'ensemble des éléments des champs SELECT
	$.ajax({
 	//, 
        url :  globalBaseURL + 'vaccins/getVaccins',
        type:   'POST',

        success: function(data) {
            data = $.parseJSON(data);
            vaccins = data['vaccins'];
            generalVaccin = data['general_vaccin'];

            fillVaccins(vaccinations);
        },

        error: function() {
			alert('Une erreur s\'est produite.');
        }
    });

});

		// generalVaccin_id
		// generalVaccin_label
		// vaccin_id
		// vaccin_label
		// vaccin_price


/*
 * Mise en place des vaccins
 */
function fillVaccins(content)
{
	if(content != '')
	{
		content = $.parseJSON(content);
		for(var i=0 ; i<content.length ; ++i)
		{
			addVaccin(content[i]['generalVaccin_id'], content[i]['vaccin_label'], content[i]['vaccin_price'], content[i]['vaccin_id']);
		}
	}
}

/*
 * Création d'un nouveau champ vaccin
 */
function addVaccin(Gvac_id, nom, price, id)
{
	Gvac_id = typeof Gvac_id !== 'undefined' ? Gvac_id : 0;
   	nom = typeof nom !== 'undefined' ? nom : '';
   	price = typeof price !== 'undefined' ? price : '';


	// On récupère les noms des generalvaccins que l'on met dans options
	var options = '<option value="8"></option>';
	for(var i=0 ; i< generalVaccin.length ; ++i)
	{
		options += '<option value="' + generalVaccin[i]['generalVaccin_id'] + '"';
		if (generalVaccin[i]['generalVaccin_id']==Gvac_id)
			options += 'selected="selected"';
		options += '>' + generalVaccin[i]['generalVaccin_label'] + '</option>';
	}
 	
 		// t_id = typeof t_id !== 'undefined' ? t_id : 0; // 
	if (typeof id == 'undefined')
		{
			id = 0;
			compteur++;

		}
	else
		{
			//if ( t_id > compteur)
				compteur = id;
		}
 
    $('#vaccins').append(getTags(compteur, 'vaccins', options, nom, price));



    if($("#vaccins").html() !== "")
	{
		$('#no-vaccins').hide();
	}

 }

 function deleteVaccin(id){



	$.ajax({
 	//, 
        url :  globalBaseURL + 'vaccins/delete',
        type:   'POST',
        data: {vid:id},

        success: function(data) {	
        	 	removeTags('#vac'+id);
        },

        error: function() {
			alert('Une erreur s\'est produite.');
        }
	});

}

/*
 * Retourne les tags nécessaires à la création d'un nouveau champ
 */
function getTags(id, name, options, nom, price)
{
 	var ret = '<div class="row" id="vac' + id + '">';
 	ret += '<input type="hidden" name="'+name+'Id[]" value="'+id+'" />';
	ret += '<div class="columns large-3">';
	ret += '<select name="' + name + 'General[]" >' + options + '</select>';
	ret += '</div>';
	ret += '<div class="columns large-6">';
	ret += '<input type="text" name="' + name + 'Names[]" placeholder="Nom" value="' + nom + '" />';
	ret += '</div>';
	ret += '<div class="columns large-2">';
	ret += '<input type="text" name="' + name + 'Prices[]" placeholder="Prix" value="' + price + '" />';
	ret += '</div>';
	ret += '<div class="columns large-1">';
	ret += '<h5><a href="javascript:void(0);" onclick="deleteVaccin('+id+')"><i class="fi-trash"></i></a></h5>';
	ret += '</div>';
	ret += '</div>';

	return ret;
}


