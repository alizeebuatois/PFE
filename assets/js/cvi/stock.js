$(document).ready(function(){

});


function getLot(idv){

    if (idv != 0){

	$.ajax({
 	//, 
        url :  globalBaseURL + 'stock/getLots',
        type:   'POST',
        data:  { id : idv},

        success: function(data) {
            data = $.parseJSON(data);

			lot = data['lot'];
            //var options = '<option value="8"></option>';
            $("#lotAjax").html("");
			for(var i=0 ; i< lot.length ; ++i)
			{
				$("<option>").attr("value",lot[i]['stock_vaccin_lot']).text(lot[i]['stock_vaccin_lot']).appendTo("#lotAjax");
			}

			getQuantity($("#lotAjax option:selected").val());

            //$('#lotAjax').html(options);
            //$('#quantityAjax').html(nblot['stock_remaining']);

        },

        error: function() {
			alert('Une erreur s\'est produite.');
        }
    });
    }

    else{

        $("#lotAjax").html("");
         $('#quantityAjax').html("---");
    }

}

function getQuantity(idl){

	$.ajax({
 	//, 
        url :  globalBaseURL + 'stock/getQuantityFromLot',
        type:   'POST',
        data:  { idlot : idl, idvaccin : $("#vaccinREG option:selected").val()},

        success: function(data) {
            data = $.parseJSON(data);

			quantity = data['quantity'];

            $('#quantityAjax').text(quantity[0]['stock_quantity_lot']);
            $('#quantityAjaxHidden').val(quantity[0]['stock_quantity_lot']);
            
            
        },

        error: function() {
			alert('Une erreur s\'est produite.');
        }
    });


}