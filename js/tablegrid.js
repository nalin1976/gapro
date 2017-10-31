$(document).ready(function() {
	$('.transGrid > thead > tr:odd').css("background-color", "#f4e9d7");
	$('.transGrid > thead > tr:odd').css("font-weight", "bold");
	$('.transGrid > thead > tr:even').css("background-color", "#e1cdaf");
	$('.transGrid > thead > tr:even').css("font-weight", "bold");
	$('.transGrid > tbody > tr:odd').css("background-color", "#f7f8f5");
	$('.transGrid > tbody > tr:even').css("background-color", "#ffffff");
});

$(document).ready(function() {
   $(function() {
        $('.transGrid > tbody > tr:odd').hover(function() {
            $(this).css('background-color', '#faf7ee');
			$(this).css('color', '#000000');
        },
        function() {
            $(this).css('background-color', '#f7f8f5');
			$(this).css('font-weight', 'normal');
			$(this).css('color', '#85887f');
        });
		
    });
});

$(document).ready(function() {
   $(function() {
        $('.transGrid > tbody > tr:even').hover(function() {
            $(this).css('background-color', '#faf7ee');
			$(this).css('color', '#000000');
        },
        function() {
            $(this).css('background-color', '#ffffff');
			$(this).css('font-weight', 'normal');
			$(this).css('color', '#85887f');
        });
		
    });
});


