$(document).ready(function(){				   

	//$('#uploadFile').hide();

	$('#uploadFile').click(function(){
		//alert('ok');
		$('#uploadDetails').show('slow');
		$('#CloseFile').show('slow');
	});
	
	$('#CloseFile').click(function(){
		//alert('ok');
		$('#uploadDetails').hide('slow');
		$('#CloseFile').hide('slow');
	});
});

