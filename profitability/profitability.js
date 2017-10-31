// JavaScript Document
function LoadProfitabilityDetails()
{
	document.profitabilityListing.submit();
}
function LoadOrderNo(styleId)
{
	var styleID = styleId;
	var url = 'profitabilityXML.php?Request=loadItem&styleID='+URLEncode(styleID);
	htmlobj=$.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	document.getElementById('cboOrderNo').innerHTML = XMLItem;
	LoadSCNo(styleID);
	
}
function LoadSCNo(styleId)
{
	var styleID = styleId;
	var url = 'profitabilityXML.php?Request=loadSCNo&styleID='+URLEncode(styleID);
	htmlobj=$.ajax({url:url,async:false});
	var XMLScNo = htmlobj.responseText;
	document.getElementById('cboSCNo').innerHTML = XMLScNo;
	
}