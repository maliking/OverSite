function editCommInfo(type)
{
	alert(type);
}

function formatNumbers()
{
    if(confirm("Are you sure you want to Re-Format Commission Numbers?"))
    {
        $.post( "commNumbersFormat.php", function( data ) {
          location.reload();
        });
        
    }
}

