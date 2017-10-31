// JavaScript Document


	$(document).ready(function() {
		$('#butSave').keypress(function(e) {
			if(e.keyCode==13)
			{
				$('#butSave').trigger('click');
				
			}
		});
		$('#butDelete').keypress(function(e) {
			if(e.keyCode==13)
				$('#butDelete').trigger('click');
		});
		$('#butReport').keypress(function(e) {
			if(e.keyCode==13)
				$('#butReport').trigger('click');
		});
		$('#butNew').keypress(function(e) {
			if(e.keyCode==13)
				$('#butNew').trigger('click');
		});
		$('#butClose').keypress(function(e) {
			if(e.keyCode==13)
				$('#butClose').trigger('click');
		});
		$('#butView').keypress(function(e) {
			if(e.keyCode==13)
				$('#butView').trigger('click');
		});
		$('#butcpoyPO').keypress(function(e) {
			if(e.keyCode==13)
				$('#butcpoyPO').trigger('click');
		});
		/////////////////////
		
		$('.cboCountry').change(function() {
			
				//alert(this.form.id);
		});
		
	});	
