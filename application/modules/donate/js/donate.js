var Donate = {	
	disableButton: function(id)
	{
        $('#button_'+id).prop("disabled", true);
		document.getElementById("overlay_"+id).style.display = "flex";
	}
};