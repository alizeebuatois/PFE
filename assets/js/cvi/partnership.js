
$(document).ready(function() {
    
    // Envoi du formulaire de demande d'association
    $('#partnershipCreate').submit(function(){
        
        $.ajax({
            url :   this.action,
            type :  this.method,
            data :  $(this).serialize(),

            success :   function(data) {
				console.log(data);

                var obj = $.parseJSON(data);
                var message = '';

                if (obj['success']) {
                    window.location.reload();
                }
                else {
                    message = 
                            '<div data-alert class="alert-box warning radius">' +                                
                                obj['message'] +
                                '<a href="javascript:void(0);" class="close">&times;</a>' +
                            '</div>';
                }

                $('#message').html('<div class="columns large-12">' + message + '</div>');

                $(document).foundation(); // Nécessaire pour permettre la fermeture de l'alertbox        
            
            },

            error :      function() {
                
                alert('Une erreur s\'est produite. La page va être rechargée.');
                window.location.reload();
            }                        
        });
    
        return false;
    });
    
    
	// Confirmation d'une association
    $('#partnershipConfirm').click(function(){

        $.ajax({

            url :   this.href,
            type :  "POST",

            success :   function(data) {

                var obj = $.parseJSON(data);
                if (obj['success'] == true)
                    window.location.reload();
                else
                    alert("Une erreur s'est produite lors de la confirmation de la relation. Merci de réessayer.");                
            
            },

            error :      function() {                
                window.location.reload();
            }                        
        });
    
        return false;

    });

});

/*
 * Annulation d'une association
 */
function partnershipCancel(key)
{
    $.ajax({
        url: globalBaseURL + 'partnership/cancel/'+key,
        type: "POST",
        success :   function(data) {
            var obj = $.parseJSON(data);
            if (obj['success'] == true)
                window.location.reload();
            else
                alert("Une erreur s'est produite lors de la suppression de la relation. Merci de réessayer.");                
        },
        error: function() {                
            window.location.reload();
        }                        
    });
}