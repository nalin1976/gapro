var xmlHttp;
var pub_TrimIStatus = 0;
function ClearForm()
{	
	setTimeout("location.reload(true);",0);
}

function RomoveData(data)
{
		var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 0) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}

function RemoveAllRows(tableName)
{
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

var AllowableCharators=new Array("38","37","39","40","8");
 function isNumberKey(evt)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 
	  for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }

	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
  }

function LoadGrnDetailsOnClick()
{
	var grnNo = document.getElementById('cboGrnNo').value;
	LoadGrnDetails(grnNo);
}

function LoadGrnDetails(grnNo)
{
	if(!validateSearch())
		return;
	document.getElementById('butSave').style.display='none';
	var orderNo	= document.getElementById('cboOrderNo').value;
	var url = 'TrimInspactionGrnWiseXml.php?RequestType=LoadGrnDetails&grnNo=' +grnNo+ '&OrderNo='+orderNo ;
	htmlobj=$.ajax({url:url,async:false});
	LoadGrnDetailsRequest(htmlobj);
	
}

function LoadGrnDetailsRequest(xmlHttp)
{
	pub_TrimIStatus 			= xmlHttp.responseXML.getElementsByTagName("TrimIStatus")[0].childNodes[0].nodeValue;	
	var XMLColor 				= xmlHttp.responseXML.getElementsByTagName("Color");				 
	RemoveAllRows('tblTrimInspectionGrn');
	for (loop = 0;loop < XMLColor.length;loop++)			
	{
		var GRNNo	 			= xmlHttp.responseXML.getElementsByTagName("GRNNo")[loop].childNodes[0].nodeValue;
		var buyerPoNo 			= xmlHttp.responseXML.getElementsByTagName("BuyerPONO")[loop].childNodes[0].nodeValue;
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
		
		var preInsp 			= xmlHttp.responseXML.getElementsByTagName("PreInsp")[loop].childNodes[0].nodeValue;
		var preInspQty 			= xmlHttp.responseXML.getElementsByTagName("PreInspQty")[loop].childNodes[0].nodeValue;
		
		var visInspected 		= xmlHttp.responseXML.getElementsByTagName("VisInspected")[loop].childNodes[0].nodeValue;
		var inspPercentage 		= xmlHttp.responseXML.getElementsByTagName("InspPercentage")[loop].childNodes[0].nodeValue;
		
		var approved 			= xmlHttp.responseXML.getElementsByTagName("Approved")[loop].childNodes[0].nodeValue;
		var approvedQty 		= xmlHttp.responseXML.getElementsByTagName("ApprovedQty")[loop].childNodes[0].nodeValue;			
		var approvedRemark 		= xmlHttp.responseXML.getElementsByTagName("ApprovedRemark")[loop].childNodes[0].nodeValue;
		
		var reject 				= xmlHttp.responseXML.getElementsByTagName("Reject")[loop].childNodes[0].nodeValue;
		var rejectQty 			= xmlHttp.responseXML.getElementsByTagName("RejectQty")[loop].childNodes[0].nodeValue;
		var rejectReason 		= xmlHttp.responseXML.getElementsByTagName("RejectReason")[loop].childNodes[0].nodeValue;
		
		var specialApp 			= xmlHttp.responseXML.getElementsByTagName("SpecialApp")[loop].childNodes[0].nodeValue;
		var specialAppQty 		= xmlHttp.responseXML.getElementsByTagName("SpecialAppQty")[loop].childNodes[0].nodeValue;
		var specialAppReason 	= xmlHttp.responseXML.getElementsByTagName("SpecialAppReason")[loop].childNodes[0].nodeValue;
		
		CreateMainGrid(GRNNo,buyerPoNo,styleName,styleId,orderNo,orderDesc,itemDesc,matDetailId,color,size,units,qty,preInsp,preInspQty,visInspected,inspPercentage,approved,approvedQty,approvedRemark,reject,rejectQty,rejectReason,specialApp,specialAppQty,specialAppReason);
	}
				
	if(XMLColor.length>0)
	{
		InterfaceRestriction(pub_TrimIStatus);
	}
}

function CreateMainGrid(GRNNo,buyerPoNo,styleName,styleId,orderNo,orderDesc,itemDesc,matDetailId,color,size,units,qty,preInsp,preInspQty,visInspected,inspPercentage,approved,approvedQty,approvedRemark,reject,rejectQty,rejectReason,specialApp,specialAppQty,specialAppReason)
{
	var tblGl 		= document.getElementById('tblTrimInspectionGrn');
	var lastRow		= tblGl.rows.length;	
	var row 		= tblGl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(0);
	cell.className 	= "normalfnt";
	cell.id			= buyerPoNo;
	cell.innerHTML 	= styleName;
	
	var cell 		= row.insertCell(1);
	cell.className 	= "normalfnt";
	cell.id			= styleId;
	cell.innerHTML 	= orderNo;
	
	var cell 		= row.insertCell(2);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= orderDesc;
	
	var cell 		= row.insertCell(3);
	cell.className 	= "normalfnt";
	cell.id			= matDetailId;
	cell.innerHTML 	= itemDesc;
	
	var cell 		= row.insertCell(4);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= color;
	
	var cell 		= row.insertCell(5);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= size;
	
	var cell 		= row.insertCell(6);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= units;
	
	var cell 		= row.insertCell(7);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= qty;
	
	var cell 		= row.insertCell(8);
	cell.className 	= "normalfntMid";
	cell.innerHTML 	= "<input type=\"checkbox\" name=\"cboPreIns\" id=\"cboPreIns\" "+ (preInsp =="TRUE" ? "checked=checked" : "" )+" onclick=\"PreInsValidate(this);\" />";
	
	var cell 		= row.insertCell(9);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" name=\"txtPreInsQty\" id=\"txtPreInsQty\" class=\"txtbox\" size=\"8\" value=\"" + preInspQty + "\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\"  onkeyup=\"compPreInspect("+loop+");\" maxlength=\"10\"/>";
	
	var cell 		= row.insertCell(10);
	cell.className 	= "normalfntMid";
	cell.innerHTML 	= "<input type=\"checkbox\" name=\"cboVisInsp\" id=\"cboVisInsp\" "+(visInspected=="TRUE" ? "checked=checked" : "" )+" onclick=\"VisInspValidate(this);\"/>";
	
	var cell 		= row.insertCell(11);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" value=\""+inspPercentage+"\" name=\"txtPersontageQty\" id=\"txtPersontageQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\"  maxlength=\"5\"  onkeyup=\"validPrecentage("+loop+");\"/>";
	
	var cell 		= row.insertCell(12);
	cell.className 	= "normalfntMid";
	cell.innerHTML 	= "<input type=\"checkbox\" name=\"cboApproved\" id=\"cboApproved\" "+(approved=="TRUE" ? "checked=checked" : "" )+" onclick=\"ApprovedValidate(this);\" />";
	
	var cell 		= row.insertCell(13);
	cell.className 	= "normalfnt";
	cell.id 		= approvedQty;
	cell.innerHTML 	= "<input type=\"text\" value=\""+approvedQty+"\" name=\"txtAppQty\" id=\"txtAppQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\" onkeyup=\"compQty("+loop+",\'app');\"  maxlength=\"10\"/>";
	
	var cell 		= row.insertCell(14);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" value=\""+approvedRemark+"\" name=\"txtAppRemark\" id=\"txtAppRemark\" class=\"txtbox\" size=\"15\" maxlength=\"100\"/>";
	
	var cell 		= row.insertCell(15);
	cell.className 	= "normalfntMid";
	cell.innerHTML 	= "<input type=\"checkbox\" name=\"cboReject\" id=\"cboReject\" "+(reject=="TRUE" ? "checked=checked" :"" )+" onclick=\"RejectValidation(this);\" />";
	
	var cell 		= row.insertCell(16);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" value=\""+rejectQty+"\" name=\"txtRejQty\" id=\"txtRejQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\" onkeyup=\"compQty("+loop+",\'rej\');\"  maxlength=\"10\"/>";
	
	var cell 		= row.insertCell(17);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" value=\""+rejectReason+"\" name=\"txtRejRemark\" id=\"txtRejRemark\" class=\"txtbox\" size=\"15\" maxlength=\"100\"/>";
	
	var cell 		= row.insertCell(18);
	cell.className 	= "normalfntMid";
	cell.innerHTML 	= "<input type=\"checkbox\" name=\"cboSpApp\" id=\"cboSpApp\" "+(specialApp=="TRUE" ? "checked=checked" :"" )+" onclick=\"SpAppValidate(this);\" />";
	
	var cell 		= row.insertCell(19);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" value=\""+specialAppQty+"\" name=\"txtSpAppQty\" id=\"txtSpAppQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\"  onkeyup=\"specialAppcompQty("+loop+");\"  maxlength=\"10\"/>";
	
	var cell 		= row.insertCell(20);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" value=\""+specialAppReason+"\" name=\"txtSpAppRemark\" id=\"txtSpAppRemark\" class=\"txtbox\" size=\"15\" maxlength=\"100\"/>";
	
	var cell 		= row.insertCell(21);
	cell.className 	= "normalfnt";
	cell.id 		= styleId;
	cell.innerHTML 	= GRNNo;
}

function CheckAllPreInsp(obj)
{
	var tbl = document.getElementById('tblTrimInspectionGrn');
	if (obj.parentNode.childNodes[0].checked==true)
	{			
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			tbl.rows[loop].cells[8].childNodes[0].checked=true;	
			var Qty=tbl.rows[loop].cells[7].childNodes[0].nodeValue;									 
			tbl.rows[loop].cells[9].childNodes[0].value	= Qty;
				tbl.rows[loop].cells[15].childNodes[0].checked=false;
				tbl.rows[loop].cells[16].childNodes[0].value=0;
				tbl.rows[loop].cells[17].childNodes[0].value="";
					tbl.rows[loop].cells[18].childNodes[0].checked=false;
					tbl.rows[loop].cells[19].childNodes[0].value=0;
					tbl.rows[loop].cells[20].childNodes[0].value="";						
		}
	}
	else
	{
		for(loop=1;loop<tbl.rows.length;loop++)
			{
				tbl.rows[loop].cells[8].childNodes[0].checked=false;	
				tbl.rows[loop].cells[9].childNodes[0].value=0;
			}		
	}
}

function CheckAllVisInsp(obj)
{
	var tbl = document.getElementById('tblTrimInspectionGrn');
	if (obj.parentNode.childNodes[0].checked==true)
	{	    
		for(loop=1;loop<tbl.rows.length;loop++)
		{					
			tbl.rows[loop].cells[10].childNodes[0].checked=true;
			tbl.rows[loop].cells[11].childNodes[0].value=10+"%";
				tbl.rows[loop].cells[15].childNodes[0].checked=false;
				tbl.rows[loop].cells[16].childNodes[0].value=0;
				tbl.rows[loop].cells[17].childNodes[0].value="";
					tbl.rows[loop].cells[18].childNodes[0].checked=false;
					tbl.rows[loop].cells[19].childNodes[0].value=0;
					tbl.rows[loop].cells[20].childNodes[0].value="";
		}
	}
	else
	{
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			tbl.rows[loop].cells[10].childNodes[0].checked=false;		
			tbl.rows[loop].cells[11].childNodes[0].value=0;
		}			
	}
}

function CheckAllAppInsp(obj)
{	
	var tbl = document.getElementById('tblTrimInspectionGrn');
	var tblH = document.getElementById('header');	
	if (obj.parentNode.childNodes[0].checked==true)
	{		
		document.getElementById('chkAllPreInsp').checked=true;
		document.getElementById('chkAllVisInsp').checked=true;
		for(loop=1;loop<tbl.rows.length;loop++)
		{					
			tbl.rows[loop].cells[12].childNodes[0].checked=true;
			var Qty=tbl.rows[loop].cells[7].childNodes[0].nodeValue;									 
			tbl.rows[loop].cells[13].childNodes[0].value = Qty;
		}
	}
	else
	{
		document.getElementById('chkAllPreInsp').checked=false;
		document.getElementById('chkAllVisInsp').checked=false;
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			tbl.rows[loop].cells[12].childNodes[0].checked=false;		
			tbl.rows[loop].cells[13].childNodes[0].value =0;
			tbl.rows[loop].cells[14].childNodes[0].value ="";
		}			
	}
}

function PreInsValidate(obj)
{
	var tbl = document.getElementById('tblTrimInspectionGrn');
	var rw = obj.parentNode.parentNode;
	if (rw.cells[8].childNodes[0].checked==true)
	{
		var Qty = rw.cells[7].childNodes[0].nodeValue;
		rw.cells[9].childNodes[0].value=Qty;
	}
	else 
	{
		rw.cells[9].childNodes[0].value=0;	
	}
		
	//rw.cells[13].childNodes[0].value=0;	
	//rw.cells[14].childNodes[0].value="";
	//rw.cells[15].childNodes[0].checked=false;
	//rw.cells[16].childNodes[0].value=0;	
	//rw.cells[17].childNodes[0].value="";
	//rw.cells[18].childNodes[0].checked=false;
	//rw.cells[19].childNodes[0].value=0;
	//rw.cells[20].childNodes[0].value="";
}

function VisInspValidate(obj)
{
	var tbl = document.getElementById('tblTrimInspectionGrn');
	var rw = obj.parentNode.parentNode;
	if (rw.cells[10].childNodes[0].checked==true)
	{
		rw.cells[11].childNodes[0].value=10;
		//rw.cells[15].childNodes[0].checked=false;
		//rw.cells[16].childNodes[0].value=0;	
		//rw.cells[17].childNodes[0].value="";
		//rw.cells[18].childNodes[0].checked=false;
		//rw.cells[19].childNodes[0].value=0;
		//rw.cells[20].childNodes[0].value="";
	}
	else
	{
		rw.cells[11].childNodes[0].value=0;	
	}
}

function ApprovedValidate(obj)
{		
	var tbl = document.getElementById('tblTrimInspectionGrn');
	var rw = obj.parentNode.parentNode;
	
	if (rw.cells[12].childNodes[0].checked==true)
	{
		var Qty = rw.cells[7].childNodes[0].nodeValue;
		rw.cells[13].childNodes[0].value=Qty
		rw.cells[16].childNodes[0].value=0;
	}
	else if(rw.cells[15].childNodes[0].checked==true) 
	{
		rw.cells[16].childNodes[0].value=parseFloat(rw.cells[16].childNodes[0].value)+parseFloat(rw.cells[13].childNodes[0].value)
		rw.cells[13].childNodes[0].value=0;
		rw.cells[14].childNodes[0].value="";
	}
	else
	{
		rw.cells[13].childNodes[0].value=0;
		rw.cells[14].childNodes[0].value="";
	}
}

function RejectValidation(obj)
{
	var tbl = document.getElementById('tblTrimInspectionGrn');
	var rw = obj.parentNode.parentNode;
	
	if (rw.cells[15].childNodes[0].checked==true)
	{
		var Qty = rw.cells[7].childNodes[0].nodeValue;
		rw.cells[16].childNodes[0].value=Qty
		rw.cells[13].childNodes[0].value=0;
	}
	else if(rw.cells[12].childNodes[0].checked==true) 
	{
		rw.cells[13].childNodes[0].value=parseFloat(rw.cells[13].childNodes[0].value)+parseFloat(rw.cells[16].childNodes[0].value)
		rw.cells[16].childNodes[0].value=0;
		rw.cells[17].childNodes[0].value="";
	}
	else
	{
		rw.cells[16].childNodes[0].value=0;
		rw.cells[17].childNodes[0].value="";
	}
}

function SpAppValidate(obj)
{
	var tbl = document.getElementById('tblTrimInspectionGrn')
	var rw = obj.parentNode.parentNode;
	
	if (rw.cells[18].childNodes[0].checked==true)
	{
		document.getElementById('chkAllPreInsp').checked=false;
		document.getElementById('chkAllVisInsp').checked=false;
		document.getElementById('chkAllAppInsp').checked=false;
		
		var Qty=rw.cells[16].childNodes[0].value;
		rw.cells[19].childNodes[0].value=Qty;
	}
	else 
	{
		rw.cells[19].childNodes[0].value=0;
		rw.cells[20].childNodes[0].value="";
	}
}

function SaveGrnTrimInsDetails()
{	
	var booCheck = true;
	showBackGround('divBG',0);
	var tbl = document.getElementById('tblTrimInspectionGrn');
	var noRows = tbl.rows.length;
	if(noRows<2)
	{
		alert('No records found to save.');
		hideBackGround('divBG');
		return false;
	}
	
	for(loop=1;loop<tbl.rows.length;loop++)
	{	
		if(tbl.rows[loop].cells[12].childNodes[0].checked)
		{
			booCheck = false;			
		}
		
		if ((tbl.rows[loop].cells[15].childNodes[0].checked==true) && (tbl.rows[loop].cells[17].childNodes[0].value==""))
		{
			alert("Please enter  the 'Reject Reason'.");
			tbl.rows[loop].cells[17].childNodes[0].select();
			hideBackGround('divBG');
			return false
		}
		else if((tbl.rows[loop].cells[18].childNodes[0].checked==true) && (tbl.rows[loop].cells[20].childNodes[0].value==""))
		{
			alert("Please enter  the 'Special Accept Reason'.");
			tbl.rows[loop].cells[20].childNodes[0].select();
			hideBackGround('divBG');
			return false;
		}
		else if(booCheck)
		{
			alert("You cannot save without enter approve qty.Please select atlease one row.");
			hideBackGround('divBG');
			return false;
		}
	}	
	//var intGrnNo = document.getElementById('cboGrnNo').options[document.getElementById('cboGrnNo').selectedIndex].text;
	
/*	var url  = 'triminspactiongrnwisedb.php?';
				url += 'RequestType=SaveHeader';
				url += '&intGrnNo='+intGrnNo;				
	var htmlobj=$.ajax({url:url,async:false});*/
			
	for (loop=1;loop<tbl.rows.length;loop++)
	{	
		if(tbl.rows[loop].cells[12].childNodes[0].checked)
		{
			var grnNo 			= tbl.rows[loop].cells[21].childNodes[0].nodeValue;
			var strStyleId 		= tbl.rows[loop].cells[1].id;
			var BuyerPoNo 		= tbl.rows[loop].cells[0].id;
			var intMatDetailID 	= tbl.rows[loop].cells[3].id;
			var strColor 		= tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var strSize 		= tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			
			var PreIns 			= tbl.rows[loop].cells[8].childNodes[0].checked==true ? "1" : "0";  //pre inspection 
			var PreInsQty 		= tbl.rows[loop].cells[9].childNodes[0].value;
			
			var visIns 			= tbl.rows[loop].cells[10].childNodes[0].checked==true ? "1" : "0";  //visual inspection 
			var visInsQty 		= tbl.rows[loop].cells[11].childNodes[0].value;
			
			var approved 		= tbl.rows[loop].cells[12].childNodes[0].checked==true ? "1" : "0";  //Approved inspection 
			var approvedQty 	= tbl.rows[loop].cells[13].childNodes[0].value;
			var approvedRemark 	= tbl.rows[loop].cells[14].childNodes[0].value;
			
			var reject 			= tbl.rows[loop].cells[15].childNodes[0].checked==true ? "1" : "0";  //Reject inspection 
			var rejectQty 		= tbl.rows[loop].cells[16].childNodes[0].value;
			var rejectRemark 	= tbl.rows[loop].cells[17].childNodes[0].value;
			
			var spApp 			= tbl.rows[loop].cells[18].childNodes[0].checked==true ? "1" : "0";  //special inspection 
			var spAppQty 		= tbl.rows[loop].cells[19].childNodes[0].value;
			var spAppRemark 	= tbl.rows[loop].cells[20].childNodes[0].value;
			
			var url = 'triminspactiongrnwisedb.php?RequestType=SaveGrnTrimInsDetails&intGrnNo=' + grnNo + '&strStyleId=' + strStyleId + '&BuyerPoNo=' + URLEncode(BuyerPoNo) + '&intMatDetailID=' + intMatDetailID + '&strColor=' + URLEncode(strColor) + '&strSize=' + URLEncode(strSize) + '&PreIns=' + PreIns + '&PreInsQty=' + PreInsQty + '&visIns=' +  visIns + '&visInsQty=' + visInsQty + '&approved=' + approved + '&approvedQty=' + approvedQty + '&approvedRemark=' + URLEncode(approvedRemark) + '&reject=' + reject + '&rejectQty='+ rejectQty + '&rejectRemark=' + URLEncode(rejectRemark) + '&spApp=' + spApp + '&spAppQty=' + spAppQty + '&spAppRemark=' + URLEncode(spAppRemark);
			var htmlobj=$.ajax({url:url,async:false});
		}
	}
	alert(htmlobj.responseText);
	if(htmlobj.responseText=="Saved successfully.")
	{
		pub_TrimIStatus = 1;
		InterfaceRestriction(1);
	}else{
		pub_TrimIStatus = 0;
		InterfaceRestriction(0);
	}
	hideBackGround('divBG');
}

function ConfirmGrnTrimInsDetails()
{
	showBackGround('divBG',0);
	if(pub_TrimIStatus==0)
	{
		alert("Please save before the confirm.");
		hideBackGround('divBG');
		return;
	}
	else if(pub_TrimIStatus==2)
	{
		alert("This Grn No already confirmed.");
		hideBackGround('divBG');
		return;
	}
	var tbl 	 = document.getElementById('tblTrimInspectionGrn');
	var intGrnNo = document.getElementById('cboGrnNo').options[document.getElementById('cboGrnNo').selectedIndex].text;
/*	var url  = 'triminspactiongrnwisedb.php?';
		url += 'RequestType=ConfirmHeader';
		url += '&intGrnNo='+intGrnNo;				
	var htmlobj=$.ajax({url:url,async:false});*/
	
	for (loop=1;loop<tbl.rows.length;loop++)
	{	
		if(tbl.rows[loop].cells[12].childNodes[0].checked)
		{
			var grnNo 			= tbl.rows[loop].cells[21].childNodes[0].nodeValue;
			var strStyleId 		= tbl.rows[loop].cells[1].id;
			var BuyerPoNo 		= tbl.rows[loop].cells[0].id;
			var intMatDetailID 	= tbl.rows[loop].cells[3].id;
			var strColor 		= tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var strSize 		= tbl.rows[loop].cells[5].childNodes[0].nodeValue;		
			var approvedQty 	= tbl.rows[loop].cells[13].childNodes[0].value;
			
			var url = 'triminspactiongrnwisedb.php?RequestType=ConfirmGrnTrimInsDetails&intGrnNo=' + grnNo + '&strStyleId=' + strStyleId + '&BuyerPoNo=' + URLEncode(BuyerPoNo) + '&intMatDetailID=' + intMatDetailID + '&strColor=' + URLEncode(strColor) + '&strSize=' + URLEncode(strSize) + '&approvedQty=' + approvedQty;
			var htmlobj = $.ajax({url:url,async:false});
		}
	}
	
	alert(htmlobj.responseText);
	if(htmlobj.responseText=="Confirmed successfully.")
	{
		pub_TrimIStatus = 2;
		InterfaceRestriction(2);
	}else{
		pub_TrimIStatus = 1;
		InterfaceRestriction(1);
	}
	hideBackGround('divBG');
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

function newPage()
{
	var sURL = unescape(window.location.pathname);
    window.location.href = sURL;
}	

function validateSearch()
{
	if(document.getElementById('cboGrnNo').value =="" && document.getElementById('cboOrderNo').value=="")
	{
		alert("Please select GRN No or Order No.")
		return false;
	}
return true;
}

function compQty(loop,field)
{
var tbl 	  		= document.getElementById('tblTrimInspectionGrn');
loop		  		= parseFloat(loop)+1;
var inputQty  		= parseFloat(tbl.rows[loop].cells[7].innerHTML);
var acceptQty 		= parseFloat(tbl.rows[loop].cells[13].childNodes[0].value);
var rejectQty 		= parseFloat(tbl.rows[loop].cells[16].childNodes[0].value);
	
	if(acceptQty > inputQty)
	{
		alert("Invalid Input Qty");
		tbl.rows[loop].cells[13].childNodes[0].value = inputQty;
		tbl.rows[loop].cells[16].childNodes[0].value = 0;
	}
	else if(rejectQty > inputQty)
	{
		alert("Invalid Input Qty");
		tbl.rows[loop].cells[16].childNodes[0].value = 0;
		tbl.rows[loop].cells[13].childNodes[0].value = inputQty;
	}
	else if(field=='app')
	{
		tbl.rows[loop].cells[16].childNodes[0].value = inputQty-tbl.rows[loop].cells[13].childNodes[0].value;
	}
	else if(field=='rej')
	{
		tbl.rows[loop].cells[13].childNodes[0].value = inputQty-tbl.rows[loop].cells[16].childNodes[0].value;
	}

	if(tbl.rows[loop].cells[13].childNodes[0].value>0)
	{
		tbl.rows[loop].cells[12].childNodes[0].checked = true;
	}
	else
	{
		tbl.rows[loop].cells[12].childNodes[0].checked = false;
	}

	if(tbl.rows[loop].cells[16].childNodes[0].value>0)
	{
		tbl.rows[loop].cells[15].childNodes[0].checked = true;
	}
	else
	{
		tbl.rows[loop].cells[15].childNodes[0].checked = false;
	}
}
//-------------------------------------------
function specialAppcompQty(loop,field)
{
var tbl = document.getElementById('tblTrimInspectionGrn');
	//var rw = obj.parentNode.parentNode;

loop=parseFloat(loop)+1;
var rejectQty=parseFloat(tbl.rows[loop].cells[16].childNodes[0].value);
var specialAppQty =parseFloat(tbl.rows[loop].cells[19].childNodes[0].value);


//alert(tbl.rows[loop].cells[5].childNodes[0].value);
//alert(tbl.rows[loop].cells[4].innerHTML);
if(specialAppQty > rejectQty){
alert("Invalid Special Approved Qty");
tbl.rows[loop].cells[19].childNodes[0].value=rejectQty;
//document.getElementById(loop).focus();
}
if(tbl.rows[loop].cells[19].childNodes[0].value>0){
tbl.rows[loop].cells[18].childNodes[0].checked=true;
}
else{
tbl.rows[loop].cells[18].childNodes[0].checked=false;
}

}

function sameRejReason()
{
	
	var tbl = document.getElementById('tblTrimInspectionGrn');
	
	
		if (document.getElementById('chkRejR').checked==true)
		{	

				for(loop=1;loop<tbl.rows.length;loop++)
				{		
							//alert(tbl.rows[1].cells[17].childNodes[0].value);

							tbl.rows[loop].cells[17].childNodes[0].value=tbl.rows[1].cells[17].childNodes[0].value;
				}
		}
		else
		{
			for(loop=1;loop<tbl.rows.length;loop++)
				{
					tbl.rows[loop].cells[17].childNodes[0].value="";
				}			
		}
}

function sameSpeAppReason()
{	
	var tbl = document.getElementById('tblTrimInspectionGrn');
	
	
		if (document.getElementById('chkSpeApR').checked==true)
		{	

				for(loop=1;loop<tbl.rows.length;loop++)
				{		
							//alert(tbl.rows[1].cells[17].childNodes[0].value);

							tbl.rows[loop].cells[20].childNodes[0].value=tbl.rows[1].cells[20].childNodes[0].value;
				}
		}
		else
		{
			for(loop=1;loop<tbl.rows.length;loop++)
				{
					tbl.rows[loop].cells[20].childNodes[0].value="";
				}			
		}
}

function sameApproveReason()
{
	var tbl = document.getElementById('tblTrimInspectionGrn');
	if (document.getElementById('chkRemarks').checked==true)
	{	
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

function compPreInspect(loop)
{
var tbl 	 = document.getElementById('tblTrimInspectionGrn');
loop		 = parseFloat(loop)+1;
var inputQty  =parseFloat(tbl.rows[loop].cells[7].innerHTML);
var preQty	 = parseFloat(tbl.rows[loop].cells[9].childNodes[0].value);

	if(preQty > inputQty)
	{
		alert("Invalid Pre Inspect Qty");
		tbl.rows[loop].cells[9].childNodes[0].value=inputQty;
		//tbl.rows[loop].cells[13].childNodes[0].value=0;
		//tbl.rows[loop].cells[16].childNodes[0].value=0;
		//tbl.rows[loop].cells[19].childNodes[0].value=0;
		//tbl.rows[loop].cells[12].childNodes[0].checked=false;
		//tbl.rows[loop].cells[15].childNodes[0].checked=false;
		//tbl.rows[loop].cells[18].childNodes[0].checked=false;
	}
	else
	{
		//tbl.rows[loop].cells[13].childNodes[0].value=0;
		//tbl.rows[loop].cells[16].childNodes[0].value=0;
		//tbl.rows[loop].cells[19].childNodes[0].value=0;
		//tbl.rows[loop].cells[12].childNodes[0].checked=false;
		//tbl.rows[loop].cells[15].childNodes[0].checked=false;
		//tbl.rows[loop].cells[18].childNodes[0].checked=false;
	}

	if(tbl.rows[loop].cells[9].childNodes[0].value>0)
		tbl.rows[loop].cells[8].childNodes[0].checked=true;
	else
		tbl.rows[loop].cells[8].childNodes[0].checked=false;
}

function validPrecentage(loop)
{
	var tbl = document.getElementById('tblTrimInspectionGrn');
	loop=parseFloat(loop)+1;	
	var precentage =parseFloat(tbl.rows[loop].cells[11].childNodes[0].value);
	
	if(precentage > 100)
	{
		alert("Invalid Precentage");
		tbl.rows[loop].cells[11].childNodes[0].focus();
		tbl.rows[loop].cells[11].childNodes[0].value=100;
	}
	
	if(tbl.rows[loop].cells[11].childNodes[0].value==0)
		tbl.rows[loop].cells[10].childNodes[0].checked=false;
	else
		tbl.rows[loop].cells[10].childNodes[0].checked=true;
}

//BEGIN - Load GRN no when change the order no
function LoadGrnNo()
{
	var StyleId = document.getElementById('cboOrderNo').value;
	
	var url  = "TrimInspactionGrnWiseXml.php?RequestType=URLLoadGRNNo";
 		url += "&StyleId="+StyleId;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboGrnNo').innerHTML = htmlobj.responseText;
	
}
//END - Load GRN no when change the order no