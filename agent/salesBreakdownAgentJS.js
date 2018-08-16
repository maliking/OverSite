function editCommInfo(type,commId)
{
	if(type == "settlementDate")
	{
		bootbox.prompt({
	    title: "Enter new Settlement Date",
	    inputType: 'date',
	    callback: function (result) 
	    {
	    	if(result != "" && result != null)
	    	{
		    	post( "../updateComm.php", { type: "settlementDate", data: result, commId: commId })
				  .done(function( data ) {
				    alert( "Settlement Date updated" );
				  });
			}
	        // alert(result);
	    }
		});
	}
	else if(type == "address")
	{
		bootbox.prompt("Enter new " + type, 
			function(result)
			{ 
				if(result != "" && result != null)
	    		{
					$.post( "../updateComm.php", { type: "address", data: result, commId: commId })
					  .done(function( data ) {
					    alert( "Address updated" );
					  });
				}
				// alert(result); 
			});
	}
	else if(type == "name")
	{
		var firstName = "";
		var lastName = "";
		bootbox.prompt("Enter new " + type, 
			function(fName)
			{ 
				firstName = fName;
				bootbox.prompt("Enter new " + type, 
				function(result)
				{ 
					lastName = result;
					alert(firstName);
					alert(lastName);
					$.post( "../updateComm.php", { type: "name", firstName: firstName, lastName: lastName })
					  .done(function( data ) {
					    alert( "Name updated" );
					  });
					// alert(result); 
				});
			});
	}
	else if(type == "initialGross")
	{
		bootbox.prompt("Enter new Initial Gross", 
			function(result)
			{ 
				if(result != "" && result != null)
	    		{
					$.post( "../updateComm.php", { type: "InitialGross", data: result, commId: commId })
					  .done(function( data ) {
					    alert( "Initial Gross updated" );
					  });
				}
				// alert(result); 
			});
	}
	else if(type == "eoFee")
	{
		bootbox.prompt("Enter new E&O Insurance", 
			function(result)
			{ 
				if(result != "" && result != null)
	    		{
					$.post( "../updateComm.php", { type: "eoFee", data: result, commId: commId })
					  .done(function( data ) {
					    alert( "E&O Insurance updated" );
					  });
				}
				// alert(result); 
			});
	}
	else if(type == "techFee")
	{
		bootbox.prompt("Enter new Tech Fee", 
			function(result)
			{ 
				if(result != "" && result != null)
	    		{
					$.post( "../updateComm.php", { type: "techFee", data: result, commId: commId })
					  .done(function( data ) {
					    alert( "Tech Fee updated" );
					  });
				}
				// alert(result); 
			});
	}
	else if(type == "procFee")
	{
		bootbox.prompt("Enter new Transaction Coordinator Fee", 
			function(result)
			{ 
				if(result != "" && result != null)
	    		{
					$.post( "../updateComm.php", { type: "procFee", data: result, commId: commId })
					  .done(function( data ) {
					    alert( "Transaction Coordinator Fee updated");
					  });
				}
				// alert(result); 
			});
	}
	else if(type == "remaxFee")
	{
		bootbox.prompt("Enter new Remax Fee", 
			function(result)
			{ 
				if(result != "" && result != null)
	    		{
					$.post( "../updateComm.php", { type: "remaxFee", data: result, commId: commId })
					  .done(function( data ) {
					    alert( "Remax Fee updated");
					  });
				}
				// alert(result); 
			});
	}
	else if(type == "miscTitle")
	{
		bootbox.prompt("Enter new Misc Title", 
			function(result)
			{ 
				if(result != "" && result != null)
	    		{
					$.post( "../updateComm.php", { type: "miscTitle", data: result, commId: commId })
					  .done(function( data ) {
					    alert( "Misc Title updated" );
					  });
				}
				// alert(result); 
			});
	}
	else if(type == "miscFee")
	{
		bootbox.prompt("Enter new Misc Fee", 
			function(result)
			{
				if(result != "" && result != null)
		    	{ 
					$.post( "../updateComm.php", { type: "misc", data: result, commId: commId })
					  .done(function( data ) {
					    alert( "Misc Fee updated" );
					  });
				}
				// alert(result); 
			});
	}
	else if(type == "clients")
	{
		bootbox.prompt("Enter new " + type + " name(s)", 
			function(result)
			{ 
				if(result != "" && result != null)
	    		{	
					$.post( "../updateComm.php", { type: "clients", data: result, commId: commId })
					  .done(function( data ) {
					    alert( "Client name updated" );
					  });
				}
				// alert(result); 
			});
	}
	else if(type == "finalHousePrice")
	{
		bootbox.prompt("Enter new final house price", 
			function(result)
			{ 
				if(result != "" && result != null)
	    		{
					$.post( "../updateComm.php", { type: "finalHousePrice", data: result, commId: commId })
					  .done(function( data ) {
					    alert( "Final House price updated" );
					  });
				}
				// alert(result); 
			});
	}
	else if(type == "type")
	{
		bootbox.prompt({
	    title: "Enter new " + type,
	    inputType: 'checkbox',
	    inputOptions: [
	        {
	            text: 'Seller',
	            value: 'seller',
	        },
	        {
	            text: 'Buyer',
	            value: 'buyer',
	        },
	        {
	            text: 'Seller/Buyer',
	            value: 'seller/buyer',
	        }
	    ],
	    callback: function (result) 
	    {
	    	if(result != "" && result != null)
	    	{
		    	$.post( "../updateComm.php", { type: "type", data: result, commId: commId })
				  .done(function( data ) {
				    alert( "Type updated" );
				  });
			}
	        // alert(result);
	    }
	});
	}
	// alert(type);
}
