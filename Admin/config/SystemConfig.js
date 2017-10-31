function save_configuration()
{
	var currency=document.getElementById("sys_currency").value;
	var country=document.getElementById("sys_country").value;
	if(currency=="")
		{
			alert("Please select a currency.");
			document.getElementById("sys_currency").focus();
			return false;
		}
	var url="SystemConfigDB.php?opt=save&currency="+currency+"&country="+country;
	var xmlhttpobj=$.ajax({url:url,async:false});
	alert(xmlhttpobj.responseText);
	
}