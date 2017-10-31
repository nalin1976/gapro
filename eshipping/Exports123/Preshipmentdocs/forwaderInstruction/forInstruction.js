// JavaScript Document
function validateData()
{
	if(document.getElementById('chk_ups').checked==false && document.getElementById('chk_expeditors').checked==false && document.getElementById('chk_bax').checked==false)
		alert("Please Select a Document");
	else
		printDoc();
}

function printDoc()
{
	if(document.getElementById('txtDocNo').value!='')
	{
		if(document.getElementById('chk_ups').checked)
			window.open("UpsSupply_PdfReport.php?type=doc&docNo="+document.getElementById('txtDocNo').value);
		if(document.getElementById('chk_expeditors').checked)
			window.open("expeditors_report.php?type=doc&docNo="+document.getElementById('txtDocNo').value);
		if(document.getElementById('chk_bax').checked)
			window.open("Baxreport.php?type=doc&docNo="+document.getElementById('txtDocNo').value)
	}
	else
	{
		if(document.getElementById('chk_ups').checked)
			window.open("UpsSupply_PdfReport.php?type=cdn&docNo="+document.getElementById('txtCDNNo').value);
		if(document.getElementById('chk_expeditors').checked)
		{
			//window.open("expeditors_report.php?type=cdn&docNo="+document.getElementById('txtCDNNo').value);
			window.open("expeditors_sea.php?type=cdn&docNo="+document.getElementById('txtCDNNo').value);
		}
		if(document.getElementById('chk_bax').checked)
			window.open("Baxreport.php?type=doc&docNo="+document.getElementById('txtCDNNo').value);
	}
}