 
jQuery(document).ready(function($){
	//alert('main alert');
	$(document).on('change', '[name=shears_subscription]', function() {
    	var valueSelected = this.value;
    	if( valueSelected == 1)
    	{
			$( "#dialog-free" ).dialog( "open" );
    	}
    	else if(valueSelected == 2){
    		$( "#dialog-paid" ).dialog( "open" );
    	}

    });

   $( "#dialog-free" ).dialog({
		width: 500,
		autoOpen: false,
		show: {
			effect: "blind",
			duration: 1000
		},
		hide: {
			effect: "explode",
			duration: 1000
		},
	  	open: function() {
			shears_subscription_status = $('[name=shears_subscription_status]').val();
		 	if ( undefined !== shears_subscription_status ) {
	 			if(shears_subscription_status != 'Free Membership' )
				{
		   			 $('[name=shears_subscription_free]').prop("checked",false);
				}
		 		
		    } 
        }
    });


	$( "#dialog-paid" ).dialog({
		width: 500,
        autoOpen: false,
		show: {
			effect: "blind",
			duration: 1000
		},
		hide: {
			effect: "explode",
			duration: 1000
		},
		open: function() {
			shears_subscription_status = $('[name=shears_subscription_status]').val();
		 	if ( undefined !== shears_subscription_status ) {
	 			if(shears_subscription_status != 'Paid Membership' )
				{
		   			 $('[name=shears_subscription_paid]').prop("checked",false);
				}
		 		
		    } 
        }
	
    });

    $( "#dialog-paid-textboxes" ).dialog({
		width: 500,
        autoOpen: false,
		show: {
			effect: "blind",
			duration: 1000
		},
		hide: {
			effect: "explode",
			duration: 1000
		},
    });
 	
 	// dialogbox close
	$('[name=shears_subscription_free]').click(function() {
		if ($(this).is(':checked')) {
			var checked_value =$(this).val();
			$('[name=shears_subscription_status]').val(checked_value); 
		}
		else{	
			$('[name=shears_subscription_status]').val('0');
		}
	});

	$('[name=shears_subscription_paid]').click(function() {
		if ($(this).is(':checked')) {
			var checked_value =$(this).val();
			$('[name=shears_subscription_status]').val(checked_value); 
		}
		else{	
			$('[name=shears_subscription_status]').val('0');
		}
	});


 	$('.shears_subscription_ok_free').click(function(event) {
 		/* Act on the event */
 		$( "#dialog-free" ).dialog( "close" );
 		//$( ".shears_subscription_ok" ).dialog( "close" );
 	});

 	$('.shears_subscription_ok_paid').click(function(event) {
 		/* Act on the event */
 		$( "#dialog-paid" ).dialog( "close" );
 		var checking_subscription_status = $('[name=shears_subscription_status]').val();
 		if(checking_subscription_status == 'Paid Membership')
 		{ 
 			//shears_subscription_status
 			$( "#dialog-paid-textboxes" ).dialog( "open" );
 		}
 		//$( ".shears_subscription_ok" ).dialog( "close" );
 	});

 	$('.shears_subscription_paid_fields').click(function(event) {
 		/* Act on the event */
 		var client_cardno =$('[name=client_cardno]').val();
		if (!client_cardno) {
  			$('[name=paypal_cardno]').val('0');
		}
		else
		{
			$('[name=paypal_cardno]').val(client_cardno);
		}
		
 		
 		var card_expirydate =$('[name=card_expirydate]').val();
		var card_expdate= card_expirydate.split("-");
		card_expdate_year = card_expdate[0]; // year
		card_expdate_month = card_expdate[1]; // month

		if (!card_expdate_year) {
		  		$('[name=paypal_expdate]').val('0');
		}
		else
		{
			$('[name=paypal_expdate]').val(card_expdate_month+card_expdate_year);
		}
		
 		var card_cvv = $('[name=card_cvv]').val();
 		if (!card_cvv) {
  			$('[name=paypal_cvv2]').val('0');
		}
		else
		{
			$('[name=paypal_cvv2]').val(card_cvv);
		}
 		
		var country_code = $('[name=country_code]').val();
		$('[name=paypal_countrycode]').val(country_code);
 		
 		//client_cardno 
 		//paypal_cardno

 		//card_expirydate
 		//paypal_expdate
 		
 		//card_cvv
 		//paypal_cvv2
 		$( "#dialog-paid-textboxes" ).dialog( "close" );
 		
 	});

            
});

