// JavaScript Document
function getStylewiseOrderNo()
{
	var styleName = $("#cboStyleNo").val();
	var url = 'db.php?RequestType=loadOrderNolist';	
		url += '&styleName='+URLEncode(styleName);
		
		htmlobj=$.ajax({url:url,async:false});
		$("#cboOrderNo").html(htmlobj.responseXML.getElementsByTagName("orderNolist")[0].childNodes[0].nodeValue);
	
}

function loadIssueNo()
{
	
	var cboYear = $("#cboYear").val();
	var url = 'db.php?RequestType=loadIssueNolist';	
		url += '&cboYear='+cboYear;
		//alert(url);
		htmlobj=$.ajax({url:url,async:false});
		$("#cboissueNofrom").html(htmlobj.responseXML.getElementsByTagName("issuenofrom")[0].childNodes[0].nodeValue);
		$("#cboIssueNoTo").html(htmlobj.responseXML.getElementsByTagName("issuenoTo")[0].childNodes[0].nodeValue);
}

function loadToEdit(iYear,iNo,st){
	window.open('../issuedWash/issuedWash.php?iNo='+iNo+'&iYear='+iYear+"&st="+st,'iWash')
}

function loadReport(iYear,iNo){
	window.open('issueToWashReport.php?iNo='+iNo+'&iYear='+iYear,'iWashReport')
}