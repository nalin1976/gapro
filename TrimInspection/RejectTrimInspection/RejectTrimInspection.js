// JavaScript Document
var pub_TrimIStatus = 0;
function getStylewiseOrderNoNew(styleId)
{
	var url = "RejectTrimInspectionXml.php?RequestType=LoadOrderData&styleId="+styleId;
	htmlobj = $.ajax({url:url,async:false});
	var XMLLoadData = htmlobj.responseText;
	document.getElementById('cboOrderNo').innerHTML = XMLLoadData;
	LoadSCNo(styleId);
}
function LoadSCNo(styleId)
{
	var url = "RejectTrimInspectionXml.php?RequestType=LoadSCNo&styleId="+styleId;
	htmlobj = $.ajax({url:url,async:false});
	var XMLSCData = htmlobj.responseText;
	document.getElementById('cboSR').innerHTML = XMLSCData;
}
function setOrederNo(obj)
{
	$('#cboOrderNo').val(obj.value);
}
function setSCNo(obj)
{
	$('#cboSR').val(obj.value);
}
function LoadGrnNo()
{
	if(document.getElementById('cboGrnNo').value=="" && document.getElementById('cboOrderNo').value=="")
	{
		ClearTable('tblTrimInspectionGrn');
	}
	var StyleId = document.getElementById('cboOrderNo').value;
	var url  = "RejectTrimInspectionXml.php?RequestType=URLLoadGRNNo";
 		url += "&StyleId="+StyleId;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboGrnNo').innerHTML = htmlobj.responseText;
	
}
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}
function validateSearch()
{
	if(document.getElementById('cboGrnNo').value=="" && document.getElementById('cboOrderNo').value=="")
	{
		alert("Please select GRN No or Order No.");
		hidePleaseWait();
		return false;
	}
	return true;
}
function LoadGrnDetails()
{
	showPleaseWait();
	if(!validateSearch())
	{
		return;
	}
	
	var orderNo = $('#cboOrderNo').val();
	var GRNNo 	= $('#cboGrnNo').val();
	var url = 'RejectTrimInspectionXml.php?RequestType=LoadGrnDetails&GRNNo=' +GRNNo+ '&orderNo='+orderNo ;
	xmlHttp = $.ajax({url:url,async:false});
	
	pub_TrimIStatus 			= xmlHttp.responseXML.getElementsByTagName("SATrimIStatus")[0].childNodes[0].nodeValue;	
	var XMLColor 				= xmlHttp.responseXML.getElementsByTagName("Color");				 
	ClearTable('tblTrimInspectionGrn');
	for (loop = 0;loop < XMLColor.length;loop++)			
	{
		var GRNNo	 			= xmlHttp.responseXML.getElementsByTagName("GRNNo")[loop].childNodes[0].nodeValue;
		var styleName 			= xmlHttp.responseXML.getElementsByTagName("Style")[loop].childNodes[0].nodeValue;
		var styleId 			= xmlHttp.responseXML.getElementsByTagName("StyleID")[loop].childNodes[0].nodeValue;
		var orderNo 			= xmlHttp.responseXML.getElementsByTagName("OrderNo")[loop].childNodes[0].nodeValue;
		var orderDesc 			= xmlHttp.responseXML.getElementsByTagName("Description")[loop].childNodes[0].nodeValue;
		var itemDesc 			= xmlHttp.responseXML.getElementsByTagName("ItemDescription")[loop].childNodes[0].nodeValue;
		var matDetailId 		= xmlHttp.responseXML.getElementsByTagName("MatDetailID")[loop].childNodes[0].nodeValue;
		var color 				= xmlHttp.responseXML.getElementsByTagName("Color")[loop].childNodes[0].nodeValue;
		var size 				= xmlHttp.responseXML.getElementsByTagName("Size")[loop].childNodes[0].nodeValue;	
		var units	 			= xmlHttp.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
		var qty 				= xmlHttp.responseXML.getElementsByTagName("Qty")[loop].childNodes[0].nodeValue;
		
		var reject 				= xmlHttp.responseXML.getElementsByTagName("Reject")[loop].childNodes[0].nodeValue;
		var rejectQty 			= xmlHttp.responseXML.getElementsByTagName("RejectQty")[loop].childNodes[0].nodeValue;
		var rejectReason 		= xmlHttp.responseXML.getElementsByTagName("RejectReason")[loop].childNodes[0].nodeValue;
		
		var specialApp 			= xmlHttp.responseXML.getElementsByTagName("SpecialApp")[loop].childNodes[0].nodeValue;
		var specialAppQty 		= xmlHttp.responseXML.getElementsByTagName("SpecialAppQty")[loop].childNodes[0].nodeValue;
		var specialAppReason 	= xmlHttp.responseXML.getElementsByTagName("SpecialAppReason")[loop].childNodes[0].nodeValue;
		
		CreateMainGrid(GRNNo,styleName,styleId,orderNo,orderDesc,itemDesc,matDetailId,color,size,units,qty,reject,rejectQty,rejectReason,specialApp,specialAppQty,specialAppReason);
	}
	InterfaceRestriction(pub_TrimIStatus);
	hidePleaseWait();
}
function CreateMainGrid(GRNNo,styleName,styleId,orderNo,orderDesc,itemDesc,matDetailId,color,size,units,qty,reject,rejectQty,rejectReason,specialApp,specialAppQty,specialAppReason)
{
	var tblGl 		= document.getElementById('tblTrimInspectionGrn');
	var lastRow		= tblGl.rows.length;	
	var row 		= tblGl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(0);
	cell.className 	= "normalfnt";
	cell.id			= styleId;
	cell.innerHTML 	= GRNNo;
	
	var cell 		= row.insertCell(1);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= styleName;
	
	var cell 		= row.insertCell(2);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= orderNo;
	
	var cell 		= row.insertCell(3);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= orderDesc;
	
	var cell 		= row.insertCell(4);
	cell.className 	= "normalfnt";
	cell.id			= matDetailId;
	cell.innerHTML 	= itemDesc;
	
	var cell 		= row.insertCell(5);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= color;
	
	var cell 		= row.insertCell(6);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= size;
	
	var cell 		= row.insertCell(7);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= units;
	
	var cell 		= row.insertCell(8);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= qty;
	
	var cell 		= row.insertCell(9);
	cell.className 	= "normalfntMid";
	cell.innerHTML 	= "<input type=\"checkbox\" disabled=\"disabled\" name=\"cboReject\" id=\"cboReject\" "+(reject=="TRUE" ? "checked=checked" :"" )+" />";
	
	var cell 		= row.insertCell(10);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" readonly=\"readonly\" value=\""+rejectQty+"\" name=\"txtRejQty\" id=\""+rejectQty+"\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" />";
	
	var cell 		= row.insertCell(11);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" readonly=\"readonly\" value=\""+rejectReason+"\" name=\"txtRejRemark\" id=\"txtRejRemark\" class=\"txtbox\" size=\"15\" maxlength=\"100\"/>";
	
	var cell 		= row.insertCell(12);
	cell.className 	= "normalfntMid";
	cell.innerHTML 	= "<input type=\"checkbox\" name=\"cboSpApp\" id=\"cboSpApp\" "+(specialApp=="TRUE" ? "checked=checked" :"" )+" onclick=\"SpAppValidate(this);\" />";
	
	var cell 		= row.insertCell(13);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" value=\""+specialAppQty+"\" name=\"txtSpAppQty\" id=\"txtSpAppQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\"  onkeyup=\"specialAppcompQty(this.value,this);\" onblur=\"setRejectionQty(this);\"  maxlength=\"10\"/>";
	
	var cell 		= row.insertCell(14);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" value=\""+specialAppReason+"\" name=\"txtSpAppRemark\" id=\"txtSpAppRemark\" class=\"txtbox\" size=\"15\" maxlength=\"100\"/>";
}
function SpAppValidate(obj)
{
	var tbl = document.getElementById('tblTrimInspectionGrn')
	var rw = obj.parentNode.parentNode;
	var Qty = rw.cells[10].childNodes[0].id;
	
	if(rw.cells[12].childNodes[0].checked==true)
	{
		
	//	rw.cells[10].childNodes[0].value=0;
		rw.cells[13].childNodes[0].value=Qty;
		
	}
	else
	{
	//	rw.cells[10].childNodes[0].value=Qty;
		rw.cells[13].childNodes[0].value=0;
		rw.cells[14].childNodes[0].value="";
	}
}
function specialAppcompQty(value,obj)
{
	
	var tbl 	   = document.getElementById('tblTrimInspectionGrn')
	var rw		   = obj.parentNode.parentNode;
	var rejQty 	   = parseFloat(rw.cells[10].childNodes[0].id);
	var currRejQty =(rw.cells[13].childNodes[0].value);
	value   	   = parseFloat(value);
	
	if(value>rejQty)
	{
		
		rw.cells[13].childNodes[0].value = rejQty;
		//rw.cells[10].childNodes[0].value = 0;
		return;
	}
	
	if(currRejQty=="")
	{
		
		rw.cells[13].childNodes[0].value = "";
		rw.cells[10].childNodes[0].value = rejQty;
		return;
	}
	//rw.cells[10].childNodes[0].value = rejQty-value;
}
function setRejectionQty(obj)
{
	var rw = obj.parentNode.parentNode;
	if(rw.cells[13].childNodes[0].value=="")
	{
		rw.cells[13].childNodes[0].value=0;
	}
	
}
function sameSpeAppReason()
{	
	var tbl = document.getElementById('tblTrimInspectionGrn');
	
	if (document.getElementById('chkSpeApR').checked==true)
	{	
		if(tbl.rows[1].cells[14].childNodes[0].value=="")
		{
			alert("Please enter first reason.");
			document.getElementById('chkSpeApR').checked=false;
			tbl.rows[1].cells[14].childNodes[0].focus();
			return;
		}
		for(loop=1;loop<tbl.rows.length;loop++)
		{		
			tbl.rows[loop].cells[14].childNodes[0].value=tbl.rows[1].cells[14].childNodes[0].value;
		}
	}
	else
	{
		for(loop=1;loop<tbl.rows.length;loop++)
			{
				tbl.rows[loop].cells[14].childNodes[0].value="";
			}			
	}
}
function InterfaceRestriction(status)
{
	if(status==0)
	{
		document.getElementById('butSave').style.display = 'inline';
		document.getElementById('butConfirm').style.display = 'inline';
	}
	else if(status==1)
	{
		document.getElementById('butSave').style.display = 'inline';
		document.getElementById('butConfirm').style.display = 'inline';
	}
	else if(status==2)
	{
		document.getElementById('butSave').style.display = 'none';
		document.getElementById('butConfirm').style.display = 'none';
	}
}
function SaveGrnRejTrimInsDetails()
{
	showPleaseWait();
	var booCheck = true;
	var tbl = document.getElementById('tblTrimInspectionGrn');
	if(tbl.rows.length<2)
	{
		alert('No records found to save.');
		hidePleaseWait();
		return false;
	}
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[12].childNodes[0].checked==true)
		{
			booCheck = false;	
		}
		if((tbl.rows[loop].cells[12].childNodes[0].checked==true) && (tbl.rows[loop].cells[14].childNodes[0].value==""))
		{
			alert("Please enter  the 'Special Accept Reason'.");
			hidePleaseWait();
			tbl.rows[loop].cells[14].childNodes[0].focus();
			return false;
		}
		if((tbl.rows[loop].cells[12].childNodes[0].checked==true) && (tbl.rows[loop].cells[13].childNodes[0].value==0))
		{
			alert("You cannot save with '0' qty.Please enter atlease one qty.");
			hidePleaseWait();
			tbl.rows[loop].cells[13].childNodes[0].focus();
			return false;
		}
	}
	 if(booCheck)
		{
			alert("You cannot save without enter approve qty.Please select atlease one row.");
			hidePleaseWait();
			return false;
		}
	
	for(var i=1;i<tbl.rows.length;i++)
	{
		if(tbl.rows[i].cells[12].childNodes[0].checked)
		{
			var grnNo 	 		= tbl.rows[i].cells[0].childNodes[0].nodeValue;
			var styleId  		= tbl.rows[i].cells[0].id;
			var matDetId 		= tbl.rows[i].cells[4].id;
			var Color 	 		= tbl.rows[i].cells[5].childNodes[0].nodeValue;
			var Size 		    = tbl.rows[i].cells[6].childNodes[0].nodeValue;
			
			var spApp 			= tbl.rows[i].cells[12].childNodes[0].checked==true ? "1" : "0"; 
			var spAppQty 		= tbl.rows[i].cells[13].childNodes[0].value;
			var spAppRemark 	= tbl.rows[i].cells[14].childNodes[0].value;
			
			var url = 'RejectTrimInspectionXml.php?RequestType=SaveGrnRejTrimInsDetails&grnNo=' + grnNo + '&styleId=' + styleId + '&matDetId=' + matDetId + '&Color=' + URLEncode(Color) + '&Size=' + URLEncode(Size) + '&spApp=' + spApp + '&spAppQty=' + spAppQty  + '&spAppRemark=' + URLEncode(spAppRemark);
			var htmlobj=$.ajax({url:url,async:false});
		}
	}
	if(htmlobj.responseText=="Saved")
	{
		alert("Saved successfully.");
		hidePleaseWait();
		pub_TrimIStatus = 1;
		InterfaceRestriction(pub_TrimIStatus);
	}else
	{
		alert("Error in saving.");
		pub_TrimIStatus = 0;
		InterfaceRestriction(pub_TrimIStatus);
		hidePleaseWait();
	}
}
function ConfirmGrnRejTrimInsDetails()
{
	showPleaseWait();
	if(pub_TrimIStatus==0)
	{
		alert("Please save before the confirm.");
		hidePleaseWait();
		return;
	}
	else if(pub_TrimIStatus==2)
	{
		alert("This Grn No already confirmed.");
		hidePleaseWait();
		return;
	}
	var tbl 	 = document.getElementById('tblTrimInspectionGrn');
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[12].childNodes[0].checked)
		{
			var grnNo 	 		= tbl.rows[loop].cells[0].childNodes[0].nodeValue;
			var styleId  		= tbl.rows[loop].cells[0].id;
			var matDetId 		= tbl.rows[loop].cells[4].id;
			var Color 	 		= tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			var Size 		    = tbl.rows[loop].cells[6].childNodes[0].nodeValue;
			var spAppQty 		= tbl.rows[loop].cells[13].childNodes[0].value;
			
			var url = 'RejectTrimInspectionXml.php?RequestType=ConfirmGrnRejTrimInsDetails&grnNo=' + grnNo + '&styleId=' + styleId + '&matDetId=' + matDetId + '&Color=' + URLEncode(Color) + '&Size=' + URLEncode(Size) + '&spAppQty=' + spAppQty;
			var htmlobj = $.ajax({url:url,async:false});
		}
	}
	if(htmlobj.responseText=="Confirmed")
	{
		alert("Confirmed successfully.");
		hidePleaseWait();
		pub_TrimIStatus = 2;
		InterfaceRestriction(pub_TrimIStatus);
	}
	else
	{
		alert("Error in confirming.");
		hidePleaseWait();
		pub_TrimIStatus = 1;
		InterfaceRestriction(pub_TrimIStatus);
	}
}
function newPage()
{
	window.location.href = 'RejectTrimInspection.php';
}
