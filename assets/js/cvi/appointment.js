var nbStep = 7;

$(document).ready(function() {

    // Clique du continuer
    $('form#makeAppointmentForm a.continue').click(function() {

        var currentStep = getCurrentStep();
        var nextStep = currentStep + 1;

        // Appel ajax, pour vérification de l'étape du formulaire
        $.ajax({

            url :   $('form#makeAppointmentForm').attr('action') + '/' + currentStep,
            type:   $('form#makeAppointmentForm').attr('method'),
            data:   $('form#makeAppointmentForm').serialize(),

            success: function(data) {
                console.log('data : ' + data);
                if (currentStep == 6) // Dernère étape
                {
                    data = $.parseJSON(data);
                    if (data['success']) // Dernière étape validée avec succès !
                    {
                        // Remplissage du tableau récapitulatif
                        // à partir des données validées et renvoyées par le contrôleur
                        $('td.members').html(data['displayed-members']);
                        $('td.travelling-date').html(data['displayed-travelling-date']);
                        $('td.travelling-date').append('<br /><i>' + $('small.trip-duration').text() + '</i>');
                        $('td.destinations').html(data['displayed-destinations']);
                        $('td.hostings').html(data['displayed-hostings']);
                        $('td.activities').html(data['displayed-activities']);
                        $('td.datetime').html(data['displayed-datetime']);
                        setErrorMessage(currentStep, null);
                        setStep(nextStep); // affiche la page de confirmation
                    }
                    else
                    {
                    	// Création du message d'erreur pour l'alerte
                        var error_message = '';
                        if (data['error-members']['message'] !== '')
                            error_message += data['error-members']['message'] + '<br />';
                        if (data['error-travelling-date']['message'] !== '')
                            error_message += data['error-travelling-date']['message'] + '<br />';
                        if (data['error-destinations']['message'] !== '')
                            error_message += data['error-destinations']['message'] + '<br />';
                        if (data['error-hostings']['message'] !== '')
                            error_message += data['error-hostings']['message'] + '<br />';
                        if (data['error-activities']['message'] !== '')  
                            error_message += data['error-activities']['message'] + '<br />';
                        if (data['error-datetime']['message'] !== '')   
                            error_message += data['error-datetime']['message'];
                        setErrorMessage(currentStep, error_message);
                    }
                }
                else if (currentStep == 7) // Confirmation
                {
                    data = $.parseJSON(data);
                    if (data['success'])
                    {
                        window.location = globalBaseURL + 'appointment';
                    }
                    else
                    {
                        setErrorMessage(currentStep, data['message']);
                    }                    
                }
                else
                {
                    if (data == true) 
                    {
                        setErrorMessage(currentStep, null);
                        setStep(nextStep);
                    }
                    else
                    {
                        data = $.parseJSON(data);
                        setErrorMessage(currentStep, data['message']);
                    }
                }
            },

            error: function() {
                alert('Une erreur s\'est produite. La page va être rechargée.');
            }
        });

        $('form#makeAppointmentForm a.continue').html('Continuer');

    });

    // Clique sur précédent
    $('form a.previous').click(function() {

        var currentStep = getCurrentStep();
        setStep(currentStep - 1);

    });


    // Date Picker
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 23, 59, 59, 0);
     
    // Champ pour la date de départ
    var checkin = $('.dp-departure').fdatepicker({
                            format: 'dd/mm/yyyy',
                            onRender: function (date) {
                                return date.valueOf() < now.valueOf() ? 'disabled' : '';
                            }
                    }).on('changeDate', function (ev) {
                        checkin.hide();
                        $('#fullDepartureDate').text(
                            getLongFrenchDate(checkin.date)
                        );
                        setTripDuration(checkin, checkout);
                        if(checkin.date.valueOf() != '')
                        {
                            $('.dp-return').attr('disabled',false);
                        }
                        else
                        {
                            $('.dp-return').attr('disabled',true);
                        }
                    }).data('datepicker');
    
    // Champ pour la date de retour
    var checkout = $('.dp-return').fdatepicker({
                            format: 'dd/mm/yyyy',
                            onRender: function (date) {
                                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
                            }
                    }).on('changeDate', function (ev) {
                        $('#fullReturnDate').text(
                            getLongFrenchDate(checkout.date)
                        );
                        setTripDuration(checkin, checkout);
                        checkout.hide();
                    }).data('datepicker');

	// Champ pour choix 1 de la date du rendez-vous
    var appDate1 = $('#appointmentDate1').fdatepicker({
        format: 'yyyy-mm-dd',
        onRender: function(date){
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        seekAppointmentDate();
        $('#displayAppointmentDate1').text(
            getLongFrenchDate(appDate1.date)
        );
    }).data('datepicker');

	// Champ pour choix 2 de la date du rendez-vous
    var addDate2 = $('#appointmentDate2').fdatepicker({
        format: 'yyyy-mm-dd',
        onRender: function(date){
            var minDate = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate() + 10, 0, 0, 0, 0);
            return date.valueOf() < minDate.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function (ev) {
        seekAppointmentDate();
        $('#displayAppointmentDate2').text(
            getLongFrenchDate(appDate2.date)
        );
    }).data('datepicker');

	// Recherche des disponibilité lors l'utilisateur change de demi-journée
    $('#appointmentDate1Option').on('change', seekAppointmentDate);
    $('#appointmentDate2Option').on('change', seekAppointmentDate);

});

/*
 * Requête Ajax récupérant les créneaux disponibles 
 */
function seekAppointmentDate()
{
    var date1 = $('#appointmentDate1').val();
    var date2 = $('#appointmentDate2').val();
    var option1 = $('#appointmentDate1Option').val();
    var option2 = $('#appointmentDate2Option').val();

    if (date1 != '' || date2 != '')
    {
        $('#propositionsLoading').show();
        $('#propositions').hide();
        $.ajax({
            url: globalBaseURL + 'appointment/getPropositions',
            data:'date1='+date1+'&date2='+date2+'&option1='+option1+'&option2='+option2,
            type: 'GET',
            timeout: 10000,
            success: function(data){
                $('#propositions').show().html(data);
                $('#propositionsLoading').hide();
            },
            error: function(x,t,m){
                alert('Une erreur s\'est produite. La page va être rechargée.');
                window.location.reload();
            }
        });
    }
        
}

/*
 * Affiche la durée du voyage lors l'utilisateur agit sur les date du voyage
 */
function setTripDuration(checkin, checkout)
{
    var departureTime = checkin.date.valueOf(); // valeur en ms
    var returnTime = checkout.date.valueOf(); // valeur en ms
    if ((returnTime - departureTime) > 0)
    {
        var duration = returnTime - departureTime;
        var text = 'Durée : ';

        var dayDuration = 3600*1000*24;
        var weekDuration = 7*dayDuration;
        var monthDuration = 4*weekDuration;
        var yearDuration = 12*monthDuration;

        // Années
        var years = parseInt(duration / (yearDuration));
        if(years != 0)
        {
            text += years;
            if(years == 1) text += ' an ';
            else           text += ' ans ';
            duration = duration - (years*yearDuration);
        }
        // Mois
        var months = parseInt(duration / (monthDuration));
        if(months != 0)
        {
            text += months + ' mois ';
            duration = duration - (months*monthDuration);
        }
        // Semaines
        var weeks = parseInt(duration / (weekDuration));
        if(weeks != 0)
        {
            text += weeks;
            if(weeks == 1) text += ' semaine ';
            else           text += ' semaines ';
            duration = duration - (weeks*weekDuration);
        }
        // Jours
        var days = parseInt(duration / (dayDuration));
        if(days != 0)
        {
            text += days;
            if(days == 1) text += ' jour ';
            else           text += ' jours ';
            duration = duration - (days*dayDuration);
        }
        // Affichage
        $('small.trip-duration').text(text);
    }
    else
    {
        $('small.trip-duration').text('');
    }
    
}

/*
 * Passage à une étape donné
 */
function setStep(step)
{
    // On marque l'ensemble des parties du formulaire
    $('div.step').removeClass('active');
    $('div.step').hide();
    //$("div.step").effect('fade', {direction: 'left', mode: 'hide'}, 500);

    // On affiche l'étape donnée en paramètre
    $('#step' + step).addClass('active');
    $('#step' + step).show();
    //$('#step' + step + '').effect('fade', {direction: 'right', mode: 'show'}, 500);
    
    // On met à jour le breadcrumbs
    /*$('ul.breadcrumbs li').removeClass('current');
    $('ul li#' + step).addClass('current');*/

    // On met à jour les boutons
    if(step > 1)
    {
        $('form#makeAppointmentForm a.previous').parent().show();
    }
    else
    {
        $('form#makeAppointmentForm a.previous').parent().hide();
    }

    if(nbStep == step)
    {
        $('form#makeAppointmentForm a.continue').html('Confirmer le rendez-vous');
    }
    else
    {
        $('form#makeAppointmentForm a.continue').html('Continuer');
    }
}

/*
 * Renvoi l'étape courrante 
 */
function getCurrentStep()
{
    for (var i=1 ; i<=nbStep ; i++)
    {
        if ($('#step' + i).hasClass('active'))
        {
            return parseInt(i);
        }
    }
}

/*
 * Affiche l'alerte du message d'erreur dans le block .message de l'étape
 */
function setErrorMessage(step, message)
{
    if (message == null)
    {
        $('#step' + step + ' .message').html('');
    }
    else
    {
        $('#step' + step + ' .message').html('<div class="row">' +
                        '<div class="columns large-12">' +
                            '<div data-alert class="alert-box alert radius">' +
                                message +
                                '<a href="javascript:void(0);" class="close">&times;</a>' + 
                            '</div>' +
                        '</div>' +
                    '</div>');

        $(document).foundation(); // Nécessaire pour pouvoir fermer l'alert-box
    }
}

/*
 * Sélectionne toutes les cases d'un checkbox donné
 */
function selectAllCheckbox(checkboxclass)
{
    var checkboxes = $('form#makeAppointmentForm input[type=checkbox].' + checkboxclass);

    for(var i=0 ; i < checkboxes.length ; i++)
    {
        if(checkboxes[i].type == 'checkbox')
        {
            checkboxes[i].checked = "checked";
        }
    }
}

/*
 * Ajoute un nouveau champ destination au DOM
 */
function addDestination()
{
    var first = $('#select1');
    var options = first.html();

    var second = '<select name="destinations[]">' + options + '</select>';

    $('#selects').append(second);
}