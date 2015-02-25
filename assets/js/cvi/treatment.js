var treatment;
var nbTreatment;
var compteur;

$(document).ready(function(){

	nbTreatment = 0;

	// Récupération de l'ensemble des éléments des champs SELECT
	$.ajax({

        url :  globalBaseURL + 'treatment/getTreatment',
        type:   'POST',

        success: function(data) {
            data = $.parseJSON(data);
           // console.log(data['treatment']);
            traitement = data['treatment'];

            fillTreatment(traitement); // traitements ici
        },

        error: function() {
			alert('Une erreur s\'est produite.');
        }
    });

});


/*
 * Mise en place des traitements
 */
function fillTreatment(content)
{
	if(content != '')
	{

		for(var i=0 ; i<content.length ; ++i)
		{
			addTreatment(content[i]['treatment_id'], content[i]['treatment_name'], content[i]['treatment_description']);
		}
	}
}

/*
 * Création d'un nouveau champ traitement
 */
function addTreatment(t_id, t_name, t_description)
{
	t_id = typeof t_id !== 'undefined' ? t_id : 0; // 
   	t_name = typeof t_name !== 'undefined' ? t_name : '';
   	t_description = typeof t_description !== 'undefined' ? t_description : '';

 
    $('#treatment').append(getTags(t_id, 'treatment', t_name, t_description));

    if($("#treatment").html() !== "")
	{
		$('#no-treatment').hide();
	}

	CKEDITOR.replace('editor'+t_id);
 }

 function deleteTreatment(id){

	$.ajax({

        url :  globalBaseURL + 'treatment/delete',
        type:   'POST',
        data: {id:id},

        success: function(data) {	
        	 	removeTags('#treatment'+id);
        },

        error: function() {
			alert('Une erreur s\'est produite.');
        }
	});

}

/*
 * Retourne les tags nécessaires à la création d'un nouveau champ
 */
function getTags(id, name, nom, description)
{
 	var ret = '<div class="row" id="treatment' + id + '">';
 	ret += '<input type="hidden" name="'+name+'Ids[]" value="'+id+'" />';
	ret += '<div class="columns large-4">';
	ret += '<input type="text" name="' + name + 'Names[]" placeholder="Nom" value="' + nom + '" />';
	ret += '</div>';
	ret += '<div class="columns large-6">';
	ret += '<textarea type="text" id="editor'+ id +'" name="' + name + 'Descriptions[]" placeholder="Description" value="' + nom + '">'+description+'</textarea>';
	ret += '</div>';
	ret += '<div class="columns large-1">';
	ret += '<h5><a href="javascript:void(0);" onclick="deleteTreatment('+id+')"><i class="fi-trash"></i></a></h5>';
	ret += '</div>';
	ret += '</div>';

	return ret;
}


