var nbStamaril;
var nbPreviousVaccination;
var nbVaccinations;
var compteur =0;

$(document).ready(function(){

	nbStamaril = 0;
	nbPreviousVaccination = 0;
	nbVaccinations = 0;

	// Mise en page des champs stamaril du client
	fillStamaril(customerStamarils);

	// Récupération des options des champs SELECT
	$.ajax({

        url :  globalBaseURL + 'medicalrecord/getMedicalRecordVaccins', 
        type:   'POST',

        success: function(data) {
            data = $.parseJSON(data);
            generalVaccins = data['generalVaccins'];
            vaccins = data['vaccins'];
            fillPreviousVaccination(customerPreviousVaccinations);
            fillVaccinations(customerVaccinationsA);
        },

        error: function() {
			alert('Une erreur s\'est produite. La page va être rechargée.');
			window.location.reload();
        }
    });

});

/*
 * Mise en page des champs stamaril du client
 */
function fillStamaril(content)
{
	if(content != '')
	{
		content = $.parseJSON(content);
		for(var i=0 ; i<content.length ; ++i)
		{
			addStamaril(content[i]['date'], content[i]['lot']);
		}
	}
}

/*
 * Ajout d'un nouveau champ stamaril dans la page
 */
function addStamaril(stamaril_date, stamaril_lot)
{
	stamaril_date = typeof stamaril_date !== 'undefined' ? stamaril_date : dateFormat(new Date(),'yyyy-mm-dd');
   	stamaril_lot = typeof stamaril_lot !== 'undefined' ? stamaril_lot : '';

	nbStamaril += 1;
	var id = 'stamaril' + nbStamaril;

	var content = '';
	content += '<div class="row" id="' + id + '">';
	content += '<div class="columns large-1">';
	content += '<p>Date :</p>';
	content += '</div>';
	content += '<div class="columns large-3">';
	content += '<input type="text" value="' + stamaril_date + '" id="' + id + '_date" name="stamaril_dates[]" placeholder="Date" />';
	content += '</div>';
	content += '<div class="columns large-2 text-right">';
	content += '<p>Lot n° :</p>';
	content += '</div>';
	content += '<div class="columns large-5">';
	content += '<input type="text" value="' + stamaril_lot + '" name="stamaril_lots[]" placeholder="Numéro de lot" />';
	content += '</div>';
	content += '<div class="columns large-1 end">';
	content += '<h5><a href="javascript:void(0);" onclick="removeTags(' + id + ');"><i class="fi-trash"></i></a></h5>';
	content += '</div>';
	content += '</div>';
	$('#stamarils').append(content);

	// Date Picker
	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 23, 59, 59, 0);
	$('#' + id + '_date').fdatepicker({
        format: 'yyyy-mm-dd',
        onRender: function(date){
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    });

	if($("#stamarils").html() !== "")
	{
		$('#no-stamarils').hide();
	}
}

/*
 * Mise en place des champs précédents vaccins du client
 */
function fillPreviousVaccination(content)
{
	if(content != '')
	{
		content = $.parseJSON(content);
		for(var i=0 ; i<content.length ; ++i)
		{
			addPreviousVaccination(content[i]['id'], content[i]['date'], content[i]['comment']);
		}
	}
}

/*
 * Mise en place des champs vaccin du client
 */
function fillVaccinations(content)
{
	if(content != '')
	{
		content = $.parseJSON(content);
		for(var i=0 ; i<content.length ; ++i)
		{
			addVaccination(content[i]['historic_vaccin_id'], content[i]['historic_id'], content[i]['historic_date'], content[i]['historic_lot'], content[i]['historic_comment']);
		}
	}
}

/*
 * Ajout d'un champ précédent vaccin sur la page 
 */
function addPreviousVaccination(previousVaccination_id, date, comment)
{
	previousVaccination_id = typeof previousVaccination_id !== 'undefined' ? previousVaccination_id : 0;
   	date = typeof date !== 'undefined' ? date : dateFormat(new Date(), 'yyyy-mm-dd');
   	comment = typeof comment !== 'undefined' ? comment : '';

	nbPreviousVaccination += 1;
	var id = 'previousVaccination' + nbPreviousVaccination;

	var options = '<option value="0"></option>';
	for(var i=0 ; i<generalVaccins.length ; ++i)
	{
		options += '<option value="' + generalVaccins[i]['generalVaccin_id'] + '"';
		if (generalVaccins[i]['generalVaccin_id']==previousVaccination_id)
			options += 'selected="selected"';
		options += '>' + generalVaccins[i]['generalVaccin_label'] + '</option>';
	}

	var content = '<div class="row" id="' + id + '">';
    content += '<div class="columns large-3">';
	content += '<select name="previousVaccinationsIds[]">' + options + '</select>';
	content += '</div>';
	content += '<div class="columns large-3">';
	content += '<input type="text" value="' + date + '" id="' + id + '_date" name="previousVaccinationsDates[]" />';
	content += '</div>';
	content += '<div class="columns large-5">';
	content += '<input type="text" name="previousVaccinationsComments[]" placeholder="Commentaire..." value="' + comment + '" />';
	content += '</div>';
	content += '<div class="columns large-1">';
	content += '<h5><a href="javascript:void(0);" onclick="removeTags(' + id + ')"><i class="fi-trash"></i></a></h5>';
	content += '</div>';
	content += '</div>';

	$('#previousVaccinations').append(content);

	// Date Picker
	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 23, 59, 59, 0);
	$('#' + id + '_date').fdatepicker({
        format: 'yyyy-mm-dd',
        onRender: function(date){
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    });

    if($("#previousVaccinations").html() !== "")
	{
		$('#no-previousVaccinations').hide();
	}
}

/*
 * Ajout d'un nouveau champ vaccin sur la page
 */
function addVaccination(vaccin_id,historic_id, date, lot, comment)
{
	vaccin_id = typeof vaccin_id !== 'undefined' ? vaccin_id : 0;
   	date = typeof date !== 'undefined' ? date : dateFormat(new Date(), 'yyyy-mm-dd');
   	lot = typeof lot !== 'undefined' ? lot : '';
   	comment = typeof comment !== 'undefined' ? comment : '';

	nbVaccinations += 1;

	var id = '' + historic_id;

	var options = '<option value="0"></option>';
	for(var i=0 ; i<vaccins.length ; ++i)
	{
		options += '<option value="' + vaccins[i]['vaccin_id'] + '"';
		if (vaccins[i]['vaccin_id']==vaccin_id)
			options += 'selected="selected"';
		options += '>' + vaccins[i]['vaccin_label'] + '</option>';
	}

		if (typeof historic_id == 'undefined')
		{
			id = 0;
			compteur++;
		}
	else
		{
				compteur = id;
		}


	var content = '<div class="row" id="vaccinations' + compteur + '">';
 	content += '<input type="hidden" name="historicIds[]" value="'+compteur+'" />';
    content += '<div class="columns large-3">';
	content += '<select name="vaccinationsIds[]">' + options + '</select>';
	content += '</div>';
	content += '<div class="columns large-3">';
	content += '<input type="text" value="' + date + '" id="vaccinations' + compteur + '_date" name="vaccinationsDates[]" />';
	content += '</div>';
	content += '<div class="columns large-2">';
	content += '<input type="text" name="vaccinationsLots[]" placeholder="Lot..." value="' + lot + '" />';
	content += '</div>';
	content += '<div class="columns large-3">';
	content += '<input type="text" name="vaccinationsComments[]" placeholder="Commentaire..." value="' + comment + '" />';
	content += '</div>';
	content += '<div class="columns large-1">';
	content += '<h5><a href="javascript:void(0);" onclick="deleteVaccin(\'' + compteur + '\')"><i class="fi-trash"></i></a></h5>';
	content += '</div>';
	content += '</div>';

	$('#vaccinations').append(content);

	// Date Picker
	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 23, 59, 59, 0);
	$('#' + id + '_date').fdatepicker({
        format: 'yyyy-mm-dd',
        onRender: function(date){
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        }
    });

    if($("#vaccinations").html() !== "")
	{
		$('#no-vaccinations').hide();
	}


}

function deleteVaccin(id){
	
	$.ajax({
 	//, 
        url :  globalBaseURL + 'medicalrecord/delete',
        type:   'POST',
        data: {vaccin_id:id},

        success: function(data) {	
        	 	removeTags('#vaccinations'+id);
        },

        error: function() {
			alert('Une erreur s\'est produite.');
        }
	});

}


