// JavaScript Document

function validateData()
{
	if(document.getElementById('txtVessalName').value=='' && document.getElementById('txtCDNNo').value=='')
		alert("Please Enter CDN Doc No or Vessal");
	else
		showExcell();
}
function showExcell()
{
	var url  = "fcldbReport.php?";
		url += "&vessalName="+document.getElementById('txtVessalName').value;
		url += "&cdnDocNo="+document.getElementById('txtCDNNo').value;
			
		window.open(url,'fcldbReport.php');
}