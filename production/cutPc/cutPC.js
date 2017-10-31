var ArrayCutBundleSerial= "";
var ArrayBundleNo="";
var ArrayQty = "";
var ArrayBalQty = "";
var ArrayStyleID = "";
var noOfRows=0;
var ArrRemarks="";
var pub_cutpcPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_url = pub_cutpcPath+"/production/cutPc/";

$(document).ready(function() 
{
	loadData1();
});

function loadData1()
{
	document.getElementById('txtGpNoteNo').value="";
	document.getElementById('cboGpDate').value="";
	document.getElementById('cboFromFactory').value="";
	if(document.getElementById('cboFactory').value.trim()=='')
	{
		document.getElementById('cboGPNo').innerHTML="";
		document.getElementById('cboFromFactory').value="";
		var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblevents\" >"+
		"<tr>"+
		"<td width=\"14%\" height=\"18\" class=\"grid_header\">PO No</td>"+
		"<td width=\"17%\" class=\"grid_header\">Style</td>"+
		"<td width=\"9%\" class=\"grid_header\">Cut No</td>"+
		"<td width=\"8%\" class=\"grid_header\">Size</td>"+
		"<td width=\"11%\" class=\"grid_header\">Bundle No</td>"+
		"<td width=\"7%\" class=\"grid_header\">GP PC's</td>"+
		"<td width=\"7%\" class=\"grid_header\">Balance Qty</td>"+
		"<td width=\"7%\" class=\"grid_header\">Recieved</td>"+
		"<td width=\"3%\" class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" checked=\"checked\"  /></td>"+
		"<td width=\"10%\" class=\"grid_header\">Remarks</td>"+
		"<td width=\"15%\" class=\"grid_header\">Color</td>"+
		"</tr>";
		
		tableText += "</table>";
		document.getElementById('divcons').innerHTML=tableText;
		return false;
	}
	var factoryID = document.getElementById("cboFactory").value;
	var url = pub_url+'xml.php?RequestType=LoadGatePassNo&factoryID='+ factoryID;
	htmlobj=$.ajax({url:url,async:false});
	HandleLoadGatePassNoForFactory(htmlobj);
}

function HandleLoadGatePassNoForFactory(htmlobj)
{
	 var XMLGatePass = htmlobj.responseXML.getElementsByTagName("gatePass");
	 document.getElementById('cboGPNo').innerHTML = XMLGatePass[0].childNodes[0].nodeValue;
	 document.getElementById('cboGPNo').focus();
}

function LoadGpNo()
{
	document.getElementById("txtGpNoteNo").value = document.getElementById("cboGPNo").value;
}

function getGatePassDetails()
{
	if(document.getElementById('cboFactory').value.trim()=='')
	{
		alert("Please select 'Factory'.");
		document.getElementById('cboFactory').focus();
		return;
	}
	
	if(document.getElementById('cboGPNo').value.trim()=='')
	{
		document.getElementById('txtGpNoteNo').value="";
		document.getElementById('cboGpDate').value="";
		document.getElementById('cboFromFactory').value="";
		var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblevents\" >"+
						"<tr>"+
						  "<td width=\"14%\" height=\"18\" class=\"grid_header\">PO No</td>"+
						  "<td width=\"17%\" class=\"grid_header\">Style</td>"+
						  "<td width=\"9%\" class=\"grid_header\">Cut No</td>"+
						  "<td width=\"8%\" class=\"grid_header\">Size</td>"+
						  "<td width=\"11%\" class=\"grid_header\">Bundle No</td>"+
						  "<td width=\"7%\" class=\"grid_header\">GP PC's</td>"+
						  "<td width=\"7%\" class=\"grid_header\">Balance Qty</td>"+
						  "<td width=\"7%\" class=\"grid_header\">Recieved</td>"+
						  "<td width=\"3%\" class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" checked=\"checked\"  /></td>"+
						  "<td width=\"10%\" class=\"grid_header\">Remarks</td>"+
						  "<td width=\"15%\" class=\"grid_header\">Color</td>"+
						"</tr>";							
			tableText += "</table>";
			document.getElementById('divcons').innerHTML=tableText;
		return false;
	}

	var factoryID = document.getElementById('cboFactory').value;
	var gatePassNo= document.getElementById('cboGPNo').value;

	var url = pub_url+'xml.php?RequestType=LoadGPHeader&factoryID=' + factoryID+'&gatePassNo=' + gatePassNo;
	htmlobj=$.ajax({url:url,async:false});
	ShowPassDetails(htmlobj);
}

function ShowPassDetails(htmlobj)
{
	var XMLLoad 		= htmlobj.responseXML.getElementsByTagName("GpNoteNo");	
	var XMLLoadDate 	= htmlobj.responseXML.getElementsByTagName("GpDate");
	var XMLFFactory 	= htmlobj.responseXML.getElementsByTagName("FromFactory");
	var XMLYear 		= htmlobj.responseXML.getElementsByTagName("Year");
	document.getElementById('cboGpDate').value 		= XMLLoadDate[0].childNodes[0].nodeValue;	
	document.getElementById('cboFromFactory').value = XMLFFactory[0].childNodes[0].nodeValue;	
	document.getElementById('txtYear').value 		= XMLYear[0].childNodes[0].nodeValue;
	document.getElementById('txtGpNoteNo').value 	= XMLYear[0].childNodes[0].nodeValue+'/'+XMLLoad[0].childNodes[0].nodeValue;
	LoadEventsforGatePass()
}

function LoadEventsforGatePassBtn()
{
	var searchYear=document.getElementById('cboTransferinYear').value;
	var searchTransf=document.getElementById('cboTransferin').value;
	
	if(document.getElementById('cboTransferin').value=="")
	{
		alert("Please select a \"Transer In#\".");	
		return false;	
	}
	else if(document.getElementById('cboTransferinYear').value=="")
	{
		alert("Please select a \"Year\".");	
		return false;	
	}
	else
	{
		LoadEventsforGatePass();	
	}
}

function LoadEventsforGatePass()
{
	var searchYear=document.getElementById('cboTransferinYear').value;
	var searchTransf=document.getElementById('cboTransferin').value;

	if((document.getElementById('cboFactory').value.trim()=='') && ((searchYear=="") || (searchTransf=="")))
	{
		return false;
	}

    var gatePassNo = document.getElementById('cboGPNo').value; 
	var url = pub_url+'xml.php?RequestType=LoadGPDetailsGrid&gatePassNo='+ gatePassNo +'&searchYear='+ searchYear+'&searchTransf='+ searchTransf;
	htmlobj=$.ajax({url:url,async:false});
	HandleLoadGrid(htmlobj);
}

function HandleLoadGrid(htmlobj)
{
	var searchYear=document.getElementById('cboTransferinYear').value;
	var searchTransf=document.getElementById('cboTransferin').value;
		
	if((searchYear!="") && (searchTransf!=""))
	{
		var XMLfromFactory 	= htmlobj.responseXML.getElementsByTagName("fromFactory");
		var XMLtofactory 	= htmlobj.responseXML.getElementsByTagName("tofactory");
		var XMLgatePassNo 	= htmlobj.responseXML.getElementsByTagName("gatePassNo");
		var XMLdate 		= htmlobj.responseXML.getElementsByTagName("date");
		var XMLgpNoteDate 	= htmlobj.responseXML.getElementsByTagName("gpNoteDate");
		var XMLgatePassNoCombo = htmlobj.responseXML.getElementsByTagName("gatePassNoCombo");
		var XMLYear 		= htmlobj.responseXML.getElementsByTagName("Year");
		
		document.getElementById('cboFactory').disabled = true;
		document.getElementById('cboGPNo').disabled = true;		
		document.getElementById('cboFactory').value=XMLfromFactory[0].childNodes[0].nodeValue;
		document.getElementById('cboTransIn').value=searchTransf;		
		document.getElementById('cboGpDate').value=XMLgpNoteDate[0].childNodes[0].nodeValue;
		document.getElementById('txtCutDate').value=XMLdate[0].childNodes[0].nodeValue;		
		
		/*var opt = document.createElement("option");		
		opt.text = XMLgatePassNo[0].childNodes[0].nodeValue;
		opt.value = XMLgatePassNo[0].childNodes[0].nodeValue;
		document.getElementById("cboGPNo").options.add(opt);*/
		
		document.getElementById('cboGPNo').innerHTML=XMLgatePassNoCombo[0].childNodes[0].nodeValue;
		document.getElementById('cboFromFactory').value=XMLtofactory[0].childNodes[0].nodeValue;
		document.getElementById('txtYear').value = XMLYear[0].childNodes[0].nodeValue;	
		document.getElementById('txtGpNoteNo').value=XMLYear[0].childNodes[0].nodeValue+'/'+XMLgatePassNo[0].childNodes[0].nodeValue;			
	}
	
	var lt 					= htmlobj.responseXML.getElementsByTagName("EventsforLeadTime");
	var XMLpoNo 			= htmlobj.responseXML.getElementsByTagName("poNo");
	var XMLStyle 			= htmlobj.responseXML.getElementsByTagName("Style");
	var XMLStyleID 			= htmlobj.responseXML.getElementsByTagName("StyleID");
	var XMLCutNo 			= htmlobj.responseXML.getElementsByTagName("CutNo");
	var XMLSize 			= htmlobj.responseXML.getElementsByTagName("Size");
	var XMLGPPC 			= htmlobj.responseXML.getElementsByTagName("GPPC");
	var XMLstatus 			= htmlobj.responseXML.getElementsByTagName("status");
	var XMLRemarks 			= htmlobj.responseXML.getElementsByTagName("Remarks");
	var XMLRecieved 		= htmlobj.responseXML.getElementsByTagName("Recieved");
	var XMLCutBundleSerial 	= htmlobj.responseXML.getElementsByTagName("CutBundleSerial");
	var XMLBundleNo 		= htmlobj.responseXML.getElementsByTagName("BundleNo");
	var XMLBalanceQty 		= htmlobj.responseXML.getElementsByTagName("BalanceQty");
	var XMLRemark 			= htmlobj.responseXML.getElementsByTagName("remarks");
	var XMLColor 			= htmlobj.responseXML.getElementsByTagName("color");
			
	var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblevents\" >"+
		"<tr>"+
			"<td width=\"14%\" height=\"18\" class=\"grid_header\">PO No</td>"+
		    "<td width=\"17%\" class=\"grid_header\">Style</td>"+
		 	"<td width=\"9%\" class=\"grid_header\">Cut No</td>"+
			"<td width=\"8%\" class=\"grid_header\">Size</td>"+
			"<td width=\"11%\" class=\"grid_header\">Bundle No</td>"+
			"<td width=\"7%\" class=\"grid_header\">GP PC's</td>"+
			"<td width=\"7%\" class=\"grid_header\">Balance Qty</td>"+
			"<td width=\"7%\" class=\"grid_header\">Recieved</td>"+
			"<td width=\"3%\" class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" checked=\"checked\"  /></td>"+
			"<td width=\"10%\" class=\"grid_header\">Remarks</td>"+
			"<td width=\"15%\" class=\"grid_header\">Color</td>"+
		"</tr>";

	for ( var loop = 0; loop < XMLpoNo.length; loop ++)
	{
		var grid="true";		
		if((loop%2)==0)
			var rowClass="grid_raw";
		else
			var rowClass="grid_raw2";
			
		var tabindex1=loop*3+6;
		var tabindex2=loop*3+7;
		var tabindex3=loop*3+8;
		
		tableText +=" <tr class=\"" + rowClass + "\">" +
		" <td class=\"normalfntMid\" id=\"" + XMLStyleID[loop].childNodes[0].nodeValue + "\" > "+ XMLpoNo[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfntMid\" id=\"" + XMLStyle[loop].childNodes[0].nodeValue + "\" > "+ XMLStyle[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfntMid\" id=\"" + XMLCutNo[loop].childNodes[0].nodeValue + "\" > "+ XMLCutNo[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfntMid\" id=\"" + XMLSize[loop].childNodes[0].nodeValue + "\" > "+ XMLSize[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfntMid\" id=\"" + XMLCutBundleSerial[loop].childNodes[0].nodeValue + "\" > "+ XMLBundleNo[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfntRite\" id=\"" + XMLGPPC[loop].childNodes[0].nodeValue + "\" > "+ XMLGPPC[loop].childNodes[0].nodeValue +"&nbsp;</td>"+
		" <td class=\"normalfntRite\" id=\"" + XMLBalanceQty[loop].childNodes[0].nodeValue + "\" > "+ XMLBalanceQty[loop].childNodes[0].nodeValue +"&nbsp;</td>"+
		" <td class=\"normalfntMid\"><input type=\"text\" id=\"" + loop + "\" name=\"" + loop + "\"class=\"txtbox\" style=\"text-align:right\" size=\"10px\" onkeypress=\"return isNumberKey(event);\" onkeyup=\"compQty(this.name);\" value=\""+ XMLRecieved[loop].childNodes[0].nodeValue +"\"  tabindex=\"" +tabindex1 + "\" > " +
		"</input></td>" +
		" <td class=\"normalfntMid\"><input type=\"checkbox\" checked=\"true\" name=\"chkStatus\" id=\"chkStatus\"  onclick=\"checkUncheckTextBox(this);\" tabindex=\"" +tabindex2 + "\"> " +
		"</input></td>" +
		" <td class=\"normalfntMid\"><input type=\"text\" id=\"txtRmks" + loop + "\" name=\"txtRmks" + loop + "\" class=\"txtbox\" style=\"width:100px;text-align:left\" value=\""+XMLRemark[loop].childNodes[0].nodeValue+"\"  tabindex=\"" +tabindex3 + "\"> " +
		"</input></td>" +
		" <td class=\"normalfntleft\" align=\"left\" id=\"" + XMLColor[loop].childNodes[0].nodeValue + "\" > "+ XMLColor[loop].childNodes[0].nodeValue +"&nbsp;</td>"+
		"</input></td>" +
		" </tr>";							
	}
	
	tableText += "</table>";
	document.getElementById('divcons').innerHTML=tableText;  
	if(grid=="true")
	{
		var tabindex3=tabindex3+1;
		document.getElementById('butSave').tabIndex=tabindex3;  
		document.getElementById('butClose').tabIndex=tabindex3+1;  
	}
}

function compQty(loop)
{
	var tbl = document.getElementById('tblevents');
	loop=parseFloat(loop)+1;
	var inputQty =parseFloat(tbl.rows[loop].cells[7].childNodes[0].value.trim());
	var recvQty=parseFloat(tbl.rows[loop].cells[6].innerHTML.trim());
	
	if(inputQty > recvQty)
	{
		alert("Invalid Input Qty");
		tbl.rows[loop].cells[7].childNodes[0].value=recvQty;
	}
	
	if(inputQty ==0)
		tbl.rows[loop].cells[8].childNodes[0].checked=false;
	else
		tbl.rows[loop].cells[8].childNodes[0].checked=true;
	
	var chk=0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[8].childNodes[0].checked == true)
		chk++;
	}
	
	if(chk==tbl.rows.length-1)
		document.getElementById('chkCheckAll').checked=true;	
	else
		document.getElementById('chkCheckAll').checked=false;	
}

function checkAll(obj)
{
	var tbl = document.getElementById('tblevents');
	if(obj.checked)
	{		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[8].childNodes[0].checked = true;
			tbl.rows[loop].cells[7].childNodes[0].value =tbl.rows[loop].cells[6].childNodes[0].data.trim();
		}
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
		    tbl.rows[loop].cells[7].childNodes[0].value = 0;
			tbl.rows[loop].cells[8].childNodes[0].checked = false;
		}
	}
}

function checkUncheckTextBox(objevent)
{
	var tbl = document.getElementById('tblevents');
	var rw = objevent.parentNode.parentNode;
	
	if (rw.cells[8].childNodes[0].checked)
	{
		rw.cells[7].childNodes[0].value =rw.cells[6].childNodes[0].data.trim();
		rw.cells[7].childNodes[0].focus();
	}
	else
	{
		rw.cells[7].childNodes[0].value = 0;
		rw.cells[7].childNodes[0].focus();
		document.getElementById('chkCheckAll').checked=false;
	}

	var chk=0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[8].childNodes[0].checked == true)
		chk++;
	}
	
	if(chk==tbl.rows.length-1)
		document.getElementById('chkCheckAll').checked=true;	
	else
		document.getElementById('chkCheckAll').checked=false;	
}
//--------------------------------------------------------------
function SaveEventTemplates()
{
	if(!ValidateHeaderDets())
		return;
		
	showBackGroundBalck();

	var CutGPTransferIN  = document.getElementById("cboTransIn").value;
	var GPTYear 		 = document.getElementById("cboTransferinYear").value;
	var GPnumber 		 = document.getElementById("cboGPNo").value;
	var GPYear 			 = document.getElementById("txtYear").value;
	var GPTransferInDate = document.getElementById("txtCutDate").value;
	var Status 			 = 0;
	var User 			 = document.getElementById("txtUser").value;
	var PrintStatus 	 = 0;
	var toFactory 		 = document.getElementById("cboFromFactory").value;
	var searchYear		 = document.getElementById('cboTransferinYear').value;
	var searchTransf	 = document.getElementById('cboTransferin').value;
	
	
	var url = 'xml.php?RequestType=SaveCutPCTransferINHeader&CutGPTransferIN=' + CutGPTransferIN + '&GPTYear='+ GPTYear + '&GPnumber='+ GPnumber + '&GPYear='+ GPYear + '&GPTransferInDate='+ GPTransferInDate + '&Status='+ Status + '&User='+ User + '&PrintStatus='+ PrintStatus+ '&toFactory='+ toFactory + '&searchYear='+ searchYear+ '&searchTransf='+ searchTransf;
	htmlobj=$.ajax({url:url,async:false});
	HandleSavingHeader(htmlobj);
}
//------------------------------------------------
function HandleSavingHeader(htmlobj)
{
	var XMLOutput 			= htmlobj.responseXML.getElementsByTagName("Save");
	var XMLCutGpTrnsfIn 	= htmlobj.responseXML.getElementsByTagName("cutGPTrnsfIn");
	var XMLCutGpTrnsfInYear = htmlobj.responseXML.getElementsByTagName("cutGPTrnsfInYear");
			
	if(XMLOutput[0].childNodes[0].nodeValue == "True")
	{
		var CutGPTransferIN = XMLCutGpTrnsfIn[0].childNodes[0].nodeValue;
		document.getElementById("cboTransIn").value=CutGPTransferIN;
		document.getElementById("cboTransferin").value=CutGPTransferIN;
		var year =  XMLCutGpTrnsfInYear[0].childNodes[0].nodeValue;
		document.getElementById("cboTransferinYear").value=year;
		var GPnumber = document.getElementById("cboGPNo").value;
		var factory = document.getElementById("cboFromFactory").value;
		var date = document.getElementById("txtCutDate").value;
		
		//----------
		var tbl = document.getElementById('tblevents');
		
		var noOfRows				= 0;
		var CutBundleSerial	= "";
		var Qty 			= "";
		var RecvQty 				= "";
		var BalQty 			= "";
		var StyleID			= "";
		var remarks 				= "";
		
		noOfRows=tbl.rows.length-1;
		var savedRcds=0;
		var tblRecords=0;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[7].childNodes[0].value!=0)
			{
				CutBundleSerial = tbl.rows[loop].cells[4].id;
				BundleNo =  tbl.rows[loop].cells[4].innerHTML.trim();
				Qty =parseFloat(tbl.rows[loop].cells[5].innerHTML.trim());
				RecvQty = parseFloat(tbl.rows[loop].cells[7].childNodes[0].value);
				StyleID = tbl.rows[loop].cells[0].id;
				remarks = tbl.rows[loop].cells[9].childNodes[0].value;
				if(RecvQty=="")
					RecvQty=0;				
				if(Qty=="")
					Qty=0;
				
				BalQty =  Qty-RecvQty;
					
				//SaveCutPCTransferINDetails(CutGPTransferIN,year,ArrayCutBundleSerial,ArrayBundleNo,ArrayQty,ArrayBalQty,noOfRows,GPnumber,ArrayStyleID,factory,date,ArrRemarks);
				var url = 'xml.php?RequestType=SaveCutPCTransferINDetails&CutGPTransferIN=' + CutGPTransferIN + '&year='+ year + '&CutBundleSerial='+ CutBundleSerial + '&BundleNo='+ BundleNo + '&Qty='+ RecvQty + '&BalQty='+ BalQty + '&BalQty='+ BalQty +' &GPnumber='+ GPnumber +' &StyleID='+ StyleID +' &factory='+ factory +' &date='+ date+'&remarks='+remarks;
				htmlobj=$.ajax({url:url,async:false});
				
				var XMLResult = htmlobj.responseXML.getElementsByTagName("result");
				if(XMLResult[0].childNodes[0].nodeValue==1){
				savedRcds++;	
				}
				tblRecords++;
			}
			
		}
			if(savedRcds==tblRecords)
			HandleSavingDetails(1);
			else
			HandleSavingDetails(0);
	}
	else
		alert("The event CutPc Transfer header save failed.");	
}
//----------------------------------------
function SaveCutPCTransferINDetails(CutGPTransferIN,year,ArrayCutBundleSerial,ArrayBundleNo,ArrayQty,ArrayBalQty,noOfRows,GPnumber,ArrayStyleID,factory,date )
{
	var url = 'xml.php?RequestType=SaveCutPCTransferINDetails&CutGPTransferIN=' + CutGPTransferIN + '&year='+ year + '&ArrayCutBundleSerial='+ ArrayCutBundleSerial + '&ArrayBundleNo='+ ArrayBundleNo + '&ArrayQty='+ ArrayQty + '&ArrayBalQty='+ ArrayBalQty + '&noOfRows='+ noOfRows + '&ArrayBalQty='+ ArrayBalQty +' &GPnumber='+ GPnumber +' &ArrayStyleID='+ ArrayStyleID +' &factory='+ factory +' &date='+ date+'&ArrRemarks='+ArrRemarks;
	htmlobj=$.ajax({url:url,async:false});
	HandleSavingDetails(htmlobj);
}
//-----------------------------------------
function HandleSavingDetails(saved)
{
	var searchYear=document.getElementById('cboTransferinYear').value;
	var searchTransf=document.getElementById('cboTransferin').value;
/*	var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
	var XMLTransfCombo = htmlobj.responseXML.getElementsByTagName("transf");
	document.getElementById('cboTransferin').innerHTML=XMLTransfCombo[0].childNodes[0].nodeValue;
	var XMLYear = htmlobj.responseXML.getElementsByTagName("year");
	document.getElementById('cboTransferinYear').innerHTML=XMLYear[0].childNodes[0].nodeValue;*/
	if(saved== 1)
	{
		hideBackGroundBalck();
		alert("Saved successfully.");
	
		if((searchYear=="") && (searchTransf==""))
		{
			document.frmCutPcTrnsfIn.reset();
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblevents\" >"+
			"<tr>"+
			"<td width=\"14%\" height=\"18\" class=\"grid_header\">PO No</td>"+
			"<td width=\"17%\" class=\"grid_header\">Style</td>"+
			"<td width=\"9%\" class=\"grid_header\">Cut No</td>"+
			"<td width=\"8%\" class=\"grid_header\">Size</td>"+
			"<td width=\"11%\" class=\"grid_header\">Bundle No</td>"+
			"<td width=\"7%\" class=\"grid_header\">GP PC's</td>"+
			"<td width=\"7%\" class=\"grid_header\">Balance Qty</td>"+
			"<td width=\"7%\" class=\"grid_header\">Recieved</td>"+
			"<td width=\"3%\" class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" checked=\"checked\"  /></td>"+
			"<td width=\"10%\" class=\"grid_header\">Remarks</td>"+
			"<td width=\"15%\" class=\"grid_header\">Color</td>"+
			"</tr>";			
			tableText += "</table>";
			document.getElementById('divcons').innerHTML=tableText;
		}
		else
		{
			document.getElementById('cboTransferinYear').value= searchYear;
			document.getElementById('cboTransferin').value=searchTransf;
			document.getElementById('cboTransferinYear').disabled = true;
			document.getElementById('cboTransferin').disabled = true;
			document.getElementById('cboGPNo').disabled = true;
			document.getElementById('cboFactory').disabled = true;
		}
		
		document.getElementById("cboFactory").focus();
	}
}
//----------------------------------------------------------
function loadInputFrom(year,serialNo)
{
	var searchYear=year;
	var searchTransf=serialNo;
	document.getElementById('cboTransferinYear').value=searchYear;
	document.getElementById('cboTransferin').value=searchTransf;	
	document.getElementById('cboTransferinYear').disabled = true;
	document.getElementById('cboTransferin').disabled = true;
	document.getElementById('cboGPNo').disabled = true;
	
	var url = pub_url+'xml.php?RequestType=LoadGPDetailsGrid&searchYear='+ searchYear+'&searchTransf='+ searchTransf;
	htmlobj=$.ajax({url:url,async:false});
	HandleLoadGrid(htmlobj);
}

function ClearTableData()
{
	var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblevents\"  border=\"0\" >"+
		"<tr>"+
		"<td width=\"27\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Edit</td>"+
		"<td width=\"48\" height=\"18\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Select</td>"+
		"<td width=\"271\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Event Name</td>"+
		"<td width=\"112\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Offset</td>"+
		"</tr>"+
		"<tr bgcolor=\"#D6E7F5\"><td class=\"normalfnt\">"+" "+"</td><td></td><td></td><td></td></tr>"
		"</table>";
	document.getElementById('divcons').innerHTML=tableText;
}

function ValidateHeaderDets()
{
	var tbl = document.getElementById('tblevents');
    var rows = tbl.rows.length-1;
	var recvCount=0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[7].childNodes[0].value != 0)
			recvCount += parseFloat(tbl.rows[loop].cells[5].childNodes[0].value);		
	}
	
	var gpdate=document.getElementById('cboGpDate').value.trim().split("-");
	var date=document.getElementById('txtCutDate').value.trim().split("/");
	gpdate=gpdate[0]+gpdate[1]+gpdate[2];
	date=date[2]+date[1]+date[0];
	
	if (document.getElementById('cboFactory').value == "" )	
	{
		alert("Please select 'Factory'.");
		document.getElementById('cboFactory').focus();
		return false;
	}
	else if (document.getElementById('cboGPNo').value == "" )	
	{
		alert("Please select 'Gate Pass No'.");
		document.getElementById('cboGPNo').focus();
		return false;
	}
	else if (document.getElementById('txtCutDate').value == "" )	
	{
		alert("Please select the 'Date'.");
		document.getElementById('txtCutDate').focus();
		return false;
	}
	else if (gpdate>date )	
	{
		alert("Date cannot be less than the 'Gate Pass Note Date'.");
		document.getElementById('txtCutDate').focus();
		return false;
	}
	else if (rows<1)	
	{
		alert("There are no details for selected header.");
		document.getElementById('cboFactory').focus();
		return false;
	}
	else if (recvCount<=0)	
	{
		alert("There is no any 'Recieved Qty' to save.");
		return false;
	}
return true;
}

function clearform()
{
	var searchYear=document.getElementById('cboTransferinYear').value;
	var searchTransf=document.getElementById('cboTransferin').value;
	
	if((searchYear!="") && (searchTransf!=""))
		document.frmCutPcTrnsfIn.reset();

//29-04-2011 hem	document.getElementById('cboFactory').disabled = true;
document.getElementById('cboFactory').disabled = false;

	var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblevents\" >"+
			"<tr>"+
			"<td width=\"14%\" height=\"18\" class=\"grid_header\">PO No</td>"+
			"<td width=\"17%\" class=\"grid_header\">Style</td>"+
			"<td width=\"9%\" class=\"grid_header\">Cut No</td>"+
			"<td width=\"8%\" class=\"grid_header\">Size</td>"+
			"<td width=\"11%\" class=\"grid_header\">Bundle No</td>"+
			"<td width=\"7%\" class=\"grid_header\">GP PC's</td>"+
			"<td width=\"7%\" class=\"grid_header\">Balance Qty</td>"+
			"<td width=\"7%\" class=\"grid_header\">Recieved</td>"+
			"<td width=\"3%\" class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" checked=\"checked\"  /></td>"+
			"<td width=\"10%\" class=\"grid_header\">Remarks</td>"+
			"<td width=\"15%\" class=\"grid_header\">Color</td>"+
			"</tr>";
	
	tableText += "</table>";
	document.getElementById('cboTransferinYear').disabled = false;
	document.getElementById('cboTransferin').disabled = false;
	document.getElementById('cboGPNo').disabled = false;
	document.getElementById('divcons').innerHTML=tableText;
	document.getElementById('cboGPNo').value='';
	document.getElementById('cboGpDate').value='';
	document.getElementById('cboFromFactory').value='';
	document.getElementById('cboGPNo').focus();
			
	if((searchYear!="") && (searchTransf!=""))
	{
		document.getElementById('cboGPNo').innerHTML='';
		document.getElementById('cboFactory').focus();
	}
	loadData1();
}