

var xmlHttpreq = [];
var pub_countryUrl = "/hela/workstudy/opbdReport/";
function loadReport(){ 

	var styleNo = URLEncode(document.getElementById('opbdrpt_intStyleID').value);
	var scNo    = URLEncode(document.getElementById('cboScNo').options[document.getElementById('cboScNo').selectedIndex].text);
	var path = "xml.php?RequestType=loadCategories&styleNo="+styleNo;  	
	htmlobj = $.ajax( { url :path, async :false });
	
	var XMLCategory 	= htmlobj.responseXML.getElementsByTagName("category");
	
	for ( var loop = 0; loop < XMLCategory.length; loop ++)
	{
		var category	= XMLCategory[loop].childNodes[0].nodeValue;
	
		var opbdrpt_intStyleID = URLEncode(document.getElementById('opbdrpt_intStyleID').value);
		window.open("../operationbreakdown/operation_Break_DownReport.php?opbdrpt_intStyleID=" + opbdrpt_intStyleID+"&category="+category+"&scNo="+scNo,'frmCountries'+loop); 
	}
	
}


// Created by suMitH HarShan  2011-05-04

// load SCNO when selected the style No
function loadSCNo()
{
	var styleNo = URLEncode(document.getElementById('opbdrpt_intStyleID').value);
	var path = "xml.php?RequestType=loadSCNo&styleNo="+styleNo;  	
	htmlobj = $.ajax( { url:path, async:false });
    document.getElementById('cboScNo').innerHTML =	htmlobj.responseText;
}


// LoadStyleID when selected the SCNO
function LoadStyleID()
{
	var cboScNo = URLEncode(document.getElementById('cboScNo').value);
	var path = "xml.php?RequestType=loadStyleNo&cboScNo="+cboScNo;  	
	htmlobj = $.ajax( { url:path, async:false });
    document.getElementById('opbdrpt_intStyleID').innerHTML =	htmlobj.responseText;
}