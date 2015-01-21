var generalVaccin;
var vaccins;

var nbVaccins;

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

        erro: function() {
			alert('Une erreur s\'est produite.');
        }
    });

});

/*
 * Mise en place des vaccins
 */
function fillVaccins(content)
{
	alert(content);
	if(content != '')
	{
		content = $.parseJSON(content);
		for(var i=0 ; i<content.length ; ++i)
		{
			addVaccin(content[i]['id'], content[i]['nom'], content[i]['price']);
		}
	}
}

/*
 * Création d'un nouveau champ vaccin
 */
function addVaccin(Gvac_id, nom, price)
{
	Gvac_id = typeof Gvac_id !== 'undefined' ? Gvac_id : 0;
   	nom = typeof nom !== 'undefined' ? nom : '';
   	price = typeof price !== 'undefined' ? price : '';

	nbVaccins += 1;
	var id = 'vac' + nbVaccins;


	// On récupère les noms des différents des generalvaccins que l'on met dans options
	var options = '<option value="0"></option>';
	for(var i=0 ; i< generalVaccin.length ; ++i)
	{
		options += '<option value="' + generalVaccin[i]['generalVaccin_id'] + '"';
		if (generalVaccin[i]['generalVaccin_id']==Gvac_id)
			options += 'selected="selected"';
		options += '>' + generalVaccin[i]['generalVaccin_label'] + '</option>';
	}
 
    $('#vaccins').append(getTags(id, 'vaccins', options, nom, price));

    if($("#vaccins").html() !== "")
	{
		$('#no-vaccins').hide();
	}

 }

/*
 * Retourne les tags nécessaires à la création d'un nouveau champ
 */
function getTags(id, name, options, nom, price)
{
 	var ret = '<div class="row" id="' + id + '">';
 	ret += '<div class="columns large-3">';
 	ret += '<p style="line-height:37px;">Catégorie : </p>';
 	ret += '</div>'
	ret += '<div class="columns large-3">';
	ret += '<select name="' + name + 'General[]" >' + options + '</select>';
	ret += '</div>';
	ret += '<div class="columns large-3">';
	ret += '<input type="text" name="' + name + 'Names[]" placeholder="Nom" value="' + nom + '" />';
	ret += '</div>';
	ret += '<div class="columns large-2">';
	ret += '<input type="text" name="' + name + 'Prices[]" placeholder="Prix" value="' + price + '" />';
	ret += '</div>';
	ret += '<div class="columns large-1">';
	ret += '<h5><a href="javascript:void(0);" onclick="removeTags(' + id + ')"><i class="fi-trash"></i></a></h5>';
	ret += '</div>';
	ret += '</div>';

	return ret;
}


