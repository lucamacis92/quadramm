

$(document).ready(function()
{
	//	Svuota l'inputbox della ricerca quando questo viene selezionato
	$('#inputSearch').focus(function()
	{
		if($("#inputSearch").val() == 'Cerca...')
			$("#inputSearch").val('');
	});
	
	//	Valorizza l'inputbox della ricerca se viene lasciato vuoto
	$('#inputSearch').blur(function()
	{
		if($("#inputSearch").val() == '')
			$("#inputSearch").val('Cerca...');
	});			
});           