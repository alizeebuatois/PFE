var nbAllergy;
var nbChronicDisease;
var nbImmunosuppressive;
var allergies;
var chronicDiseases;
var immunosuppressives;

$(document).ready(function(){

	nbAllergy = 0;
	nbChronicDisease = 0;
	nbImmunosuppressive = 0;

	// Récupération de l'ensemble des éléments des champs SELECT
	$.ajax({

        url :  globalBaseURL + 'medicalinfo/getAllergiesChronicDiseasesImmunosuppressives', 
        type:   'POST',

        success: function(data) {
            data = $.parseJSON(data);
            allergies = data['allergies'];
            chronicDiseases = data['chronicDiseases'];
            immunosuppressives = data['immunosuppressives'];
            fillAllergies(customerAllergies);
            fillChronicDiseases(customerChronicDiseases);
            fillImmunosuppressives(customerImmunosuppressives);
        },

        error: function() {
			alert('Une erreur s\'est produite.');
        }
    });

});

/*
 * Mise en place des allergies du client
 */
function fillAllergies(content)
{
	if(content != '')
	{
		content = $.parseJSON(content);
		for(var i=0 ; i<content.length ; ++i)
		{
			addAllergy(content[i]['id'], content[i]['comment']);
		}
	}
}

/*
 * Mise en page des maladies chroniques du client
 */
function fillChronicDiseases(content)
{
	if(content != '')
	{
		content = $.parseJSON(content);
		for(var i=0 ; i<content.length ; ++i)
		{
			addChronicDisease(content[i]['id'], content[i]['comment']);
		}
	}
}

/*
 * Mise en place des traitements immunosuppressives du client
 */
function fillImmunosuppressives(content)
{
	if(content != '')
	{
		content = $.parseJSON(content);
		for(var i=0 ; i<content.length ; ++i)
		{
			addImmunosuppressive(content[i]['id'], content[i]['comment']);
		}
	}
}

/*
 * Création d'un nouveau champ allergie
 */
function addAllergy(allergy_id, comment)
{
	allergy_id = typeof allergy_id !== 'undefined' ? allergy_id : 0;
   	comment = typeof comment !== 'undefined' ? comment : '';

	nbAllergy += 1;
	var id = 'allergy' + nbAllergy;

	var options = '<option value="0"></option>';
	for(var i=0 ; i<allergies.length ; ++i)
	{
		options += '<option value="' + allergies[i]['allergy_id'] + '"';
		if (allergies[i]['allergy_id']==allergy_id)
			options += 'selected="selected"';
		options += '>' + allergies[i]['allergy_label_fr'] + '</option>';
	}

    $('#allergies').append(getTags(id, 'allergies', options, comment));

    if($("#allergies").html() !== "")
	{
		$('#no-allergies').hide();
	}

 }

/*
 * Création d'un nouveau champ maladie chronique 
 */
function addChronicDisease(chronicDisease_id, comment)
{
	chronicDisease_id = typeof chronicDisease_id !== 'undefined' ? chronicDisease_id : 0;
   	comment = typeof comment !== 'undefined' ? comment : '';

	nbChronicDisease += 1;
	var id = 'chronicDisease' + nbChronicDisease;

	var options = '<option value="0"></option>';
	for(var i=0 ; i<chronicDiseases.length ; ++i)
	{
		options += '<option value="' + chronicDiseases[i]['chronicDisease_id'] + '"';
		if (chronicDiseases[i]['chronicDisease_id']==chronicDisease_id)
			options += 'selected="selected"';
		options += '>' + chronicDiseases[i]['chronicDisease_label_fr'] + '</option>';
	}

    $('#chronicdiseases').append(getTags(id, 'chronicDiseases', options, comment));

    if($("#chronicdiseases").html() !== "")
	{
		$('#no-chronicDiseases').hide();
	}

}

/*
 * Création d'un nouveau champ traitement immunosuppressive
 */
function addImmunosuppressive(immunosuppressive_id, comment)
{
	immunosuppressive_id = typeof immunosuppressive_id !== 'undefined' ? immunosuppressive_id : 0;
   	comment = typeof comment !== 'undefined' ? comment : '';

	nbImmunosuppressive += 1;
	var id = 'immunosuppressive' + nbImmunosuppressive;

	var options = '<option value="0"></option>';
	for(var i=0 ; i<immunosuppressives.length ; ++i)
	{
		options += '<option value="' + immunosuppressives[i]['immunosuppressive_id'] + '"';
		if (immunosuppressives[i]['immunosuppressive_id']==immunosuppressive_id)
			options += 'selected="selected"';
		options += '>' + immunosuppressives[i]['immunosuppressive_label_fr'] + '</option>';
	}

    $('#immunosuppressives').append(getTags(id, 'immunosuppressives', options, comment));

    if($("#immunosuppressives").html() !== "")
	{
		$('#no-immunosuppressives').hide();
	}

}

/*
 * Retourne les tags nécessaire à la création d'un nouveau champ
 */
function getTags(id, name, options, comment)
{
 	var ret = '<div class="row" id="' + id + '">';
	ret += '<div class="columns large-5">';
	ret += '<select name="' + name + '[]">' + options + '</select>';
	ret += '</div>';
	ret += '<div class="columns large-6">';
	ret += '<input type="text" name="' + name + 'Comments[]" placeholder="Précisez..." value="' + comment + '" />';
	ret += '</div>';
	ret += '<div class="columns large-1">';
	ret += '<h5><a href="javascript:void(0);" onclick="removeTags(' + id + ')"><i class="fi-trash"></i></a></h5>';
	ret += '</div>';
	ret += '</div>';

	return ret;
}