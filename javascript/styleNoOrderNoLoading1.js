// JavaScript Document

var pub_IssueUrl = "/gapro/commonPHP/";

function getStylewiseOrderNoNew(type,cboValue,orderID)
{
   var stytleName = cboValue;
   var url=pub_IssueUrl+"styleNoOrderNoSCLoadingXML1.php";
				url=url+"?RequestType="+type+"";
				    url += '&stytleName='+URLEncode(stytleName);
				
	var htmlobj=$.ajax({url:url,async:false});
	var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	document.getElementById(""+orderID+"").innerHTML =  OrderNo;
}

//-------------------------------------------------------------------------------------------------

function getScNo(type,id)
{
   var styleName = document.getElementById('cboStyles').value;
   var url=pub_IssueUrl+"styleNoOrderNoSCLoadingXML1.php";
					url=url+"?RequestType="+type+"";
					    url += '&styleName='+URLEncode(styleName);
					
   var htmlobj=$.ajax({url:url,async:false});
   //alert(htmlobj.responseText);
   var OrderNo = htmlobj.responseXML.getElementsByTagName("SCNO")[0].childNodes[0].nodeValue;
   document.getElementById(''+id+'').innerHTML =  OrderNo;
	
}

//-------------------------------------------------------------------------------------------------

function getStyleNo(type,styleID,cboStyles)
{
   var url=pub_IssueUrl+"styleNoOrderNoSCLoadingXML1.php";
					url=url+"?RequestType="+type+"";
					    url += '&styleID='+styleID;				
   var htmlobj=$.ajax({url:url,async:false});

   var StyleName = htmlobj.responseXML.getElementsByTagName("StyleName")[0].childNodes[0].nodeValue;
   document.getElementById(''+cboStyles+'').innerHTML =  StyleName;
   
}

//-------------------------------------------------------------------------------------------------

function getSC(cboSR,cboOrderNo)
{
	document.getElementById(''+cboSR+'').value = document.getElementById(''+cboOrderNo+'').value;
}
//------------------------------------------------------------------------------------------------

function getStyleNoFromSC(cboSR,cboOrderNo)
{
	var scNo = document.getElementById(''+cboSR+'').value;
	document.getElementById(''+cboOrderNo+'').value = scNo;
}