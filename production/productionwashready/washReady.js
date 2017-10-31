var xmlHttpreq 		= [];
var pub_Path 		= document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_url 		= pub_Path+"/production/productionwashready/";
var totWashQty		= 0;
var ArrayRemarks	= "";
var pub_orderId		= ""
//-------------------------------------------------------------------------------------------------------------
function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpreq[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpreq[index] = new XMLHttpRequest();
    }
}

function loadPoNoAndStyle()
{
	var factoryID = document.getElementById("cboFactory").value;
	var url 	  = pub_url+'xml.php?RequestType=loadPoNoAndStyle&factoryID='+ factoryID;
	var htmlobj   = $.ajax({url:url,async:false});
	HandlePoNoAndStyle(htmlobj);
}

function HandlePoNoAndStyle(xmlHttp)
{
	var XMLPoNo 	= xmlHttp.responseXML.getElementsByTagName("orderNo");
	var XMLStyle 	= xmlHttp.responseXML.getElementsByTagName("style");
	
	document.getElementById('cboPoNo').innerHTML	 = "";
	document.getElementById('cboStyle').innerHTML	 = "";
	document.getElementById('cboCutNo').innerHTML	 = "";
	document.getElementById('cboBundleNo').innerHTML = "";
	clearTable();
	document.getElementById('cboPoNo').innerHTML 	= XMLPoNo[0].childNodes[0].nodeValue;
	document.getElementById('cboStyle').innerHTML 	= XMLStyle[0].childNodes[0].nodeValue;
	document.getElementById("cboPoNo").focus();
}

function loadStylePoCutNo(styleID)
{
	document.getElementById('cboPoNo').value	= styleID;
	document.getElementById('cboStyle').value 	= styleID;
	var factoryID = document.getElementById("cboFactory").value;

	var url = pub_url+'xml.php?RequestType=LoadCutNo&factoryID='+ factoryID + '&styleID='+ styleID;
	var htmlobj   = $.ajax({url:url,async:false});
	HandleCutNo(htmlobj);
	document.getElementById('cboBundleNo').innerHTML = "";
}

function HandleCutNo(xmlHttp)
{
	clearTable();
	var XMLCutNo 	= xmlHttp.responseXML.getElementsByTagName("cutPC");
	document.getElementById('cboCutNo').innerHTML = XMLCutNo[0].childNodes[0].nodeValue
	document.getElementById("cboCutNo").focus();
}
//----------Load Bundle No---------------------------------------------------------------------------------
function loadBundleNo()
{
	showBackGroundBalck();
	var factoryID	= document.getElementById("cboFactory").value;
	var cutNo		= document.getElementById("cboCutNo").value;
	var PoNo		= document.getElementById("cboPoNo").value;

	var url = pub_url+'xml.php?RequestType=loadBundleNo&factoryID='+ factoryID+ '&cutNo='+ cutNo + '&PoNo='+ PoNo;
	var htmlobj=$.ajax({url:url,async:false});
	HandleBundleNo(htmlobj);
}

function HandleBundleNo(xmlHttp)
{
	var XMLBundleNo = xmlHttp.responseXML.getElementsByTagName("BundleNo");
	var XMLPattern 	= xmlHttp.responseXML.getElementsByTagName("Pattern");
	var XMLTeamNo 	= xmlHttp.responseXML.getElementsByTagName("TeamNo");
	
	document.getElementById('cboBundleNo').innerHTML = XMLBundleNo[0].childNodes[0].nodeValue;
	document.getElementById('txtPattern').value		 = XMLPattern[0].childNodes[0].nodeValue;
	document.getElementById('txtLineNo').value		 = XMLTeamNo[0].childNodes[0].nodeValue;
	document.getElementById("cboBundleNo").focus();
	
	LoadGrid();
}

function LoadGrid()
{
	var searchYear		= document.getElementById('txtSearchWashReadyYear').value;
	var searchSerialNo	= document.getElementById('txtSearchWashReadyNo').value;
	
	if(((searchYear=="") && (searchSerialNo=="")) && (document.getElementById('cboFactory').value.trim()==''))
		return false;
	
	var factoryID	= document.getElementById("cboFactory").value;
	var cutNo		= document.getElementById("cboCutNo").value;
	var PoNo		= document.getElementById("cboPoNo").value;
	var bundleNo 	= document.getElementById("cboBundleNo").value;

	var url = pub_url+'xml.php?RequestType=LoadGrid&factoryID='+ factoryID + '&cutNo='+ cutNo + '&PoNo='+ PoNo + '&bundleNo='+ bundleNo + '&searchYear='+ searchYear + '&searchSerialNo='+ searchSerialNo;
	var htmlobj=$.ajax({url:url,async:false});
	HandleLoadGrid(htmlobj);
}

function HandleLoadGrid(xmlHttp)
{
	var XMLSize 			= xmlHttp.responseXML.getElementsByTagName("Size");
	var XMLCutBundserial 	= xmlHttp.responseXML.getElementsByTagName("CutBundserial");
	var XMLCutNo 			= xmlHttp.responseXML.getElementsByTagName("cutNo");
	var XMLBundlNo 			= xmlHttp.responseXML.getElementsByTagName("BundlNo");
	var XMLRange 			= xmlHttp.responseXML.getElementsByTagName("Range");
	var XMLShade 			= xmlHttp.responseXML.getElementsByTagName("Shade");
	var XMLOutput 			= xmlHttp.responseXML.getElementsByTagName("Output");
	var XMLWash 			= xmlHttp.responseXML.getElementsByTagName("Wash");
	var XMLLine 			= xmlHttp.responseXML.getElementsByTagName("Line");
	var XMLRemarks 			= xmlHttp.responseXML.getElementsByTagName("remarks");
	var XMLColor 			= xmlHttp.responseXML.getElementsByTagName("color");
	
	var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblevents\" border=\"0\">"+
					"<tr>"+
						"<td width=\"9%\" height=\"18\" class=\"grid_header\">Cut No</td>"+
						"<td width=\"9%\" class=\"grid_header\">Size</td>"+
						"<td width=\"9%\" class=\"grid_header\">Bundle No</td>"+
						"<td width=\"9%\" class=\"grid_header\">Range</td>"+
						"<td width=\"9%\" class=\"grid_header\">Shade</td>"+
						"<td width=\"10%\" class=\"grid_header\">Bal Qty</td>"+
						"<td width=\"10%\" class=\"grid_header\">Wash Qty</td>"+
						"<td width=\"5%\" class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" checked=\"checked\"  /></td>"+
						"<td width=\"9%\" class=\"grid_header\">Line No</td>"+
						"<td width=\"10%\" class=\"grid_header\">Remarks</td>"+
						"<td width=\"10%\" class=\"grid_header\">Color</td>"+
						"<td width=\"1%\" class=\"grid_header\" style=\"display:none\"></td>"+
					"</tr>";
						
	 for ( var loop = 0; loop < XMLSize.length; loop ++)
	 {
		if((loop%2)==0)
			var rowClass="grid_raw"	
		else
		var rowClass="grid_raw2"	
		
		tableText +=" <tr class=\"" + rowClass + "\">" +
					" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLCutNo[loop].childNodes[0].nodeValue + "\" > "+ XMLCutNo[loop].childNodes[0].nodeValue +"</td>"+
					" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLSize[loop].childNodes[0].nodeValue + "\" > "+ XMLSize[loop].childNodes[0].nodeValue +"</td>"+
					" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLBundlNo[loop].childNodes[0].nodeValue + "\" > "+ XMLBundlNo[loop].childNodes[0].nodeValue +"</td>"+
					" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLRange[loop].childNodes[0].nodeValue + "\" > "+ XMLRange[loop].childNodes[0].nodeValue +"</td>"+
					" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLShade[loop].childNodes[0].nodeValue + "\" > "+ XMLShade[loop].childNodes[0].nodeValue +"</td>"+
					" <td class=\"normalfntRite\" align=\"center\" id=\"" + XMLOutput[loop].childNodes[0].nodeValue + "\" > "+ XMLOutput[loop].childNodes[0].nodeValue +"&nbsp;</td>"+
					" <td class=\"normalfntMid\" align=\"right\" id=\"" + XMLWash[loop].childNodes[0].nodeValue + "\"><input type=\"text\" id=\"" + loop + "\" name=\"" + loop + "\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" onkeypress=\"return isNumberKey(event);\" onkeyup=\" getTotQty();compQty(this.name);\" value=\""+ XMLWash[loop].childNodes[0].nodeValue+"\"> " +
					"</input></td>" +
					" <td class=\"normalfntMid\" align=\"right\"><input type=\"checkbox\" checked=\"true\" name=\"chkStatus\" id=\"chkStatus\"  onclick=\"checkUncheckTextBox(this);\" /> " +
					"</input></td>" +
					" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLLine[loop].childNodes[0].nodeValue + "\" > "+ XMLLine[loop].childNodes[0].nodeValue +"</td>"+
					" <td class=\"normalfntMid\" align=\"center\" ><input type=\"text\" id=\"" + loop + "\" name=\"" + loop + "\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" value=\""+ XMLRemarks[loop].childNodes[0].nodeValue+"\"> " +
					"</input></td>"+
					" <td class=\"normalfntMid\" align=\"right\" style=\"display:none\"><input type=\"hidden\" id=\"offset\" name=\"offset\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" value=\""+ XMLCutBundserial[loop].childNodes[0].nodeValue+"\"> " +
					" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLColor[loop].childNodes[0].nodeValue + "\" > "+ XMLColor[loop].childNodes[0].nodeValue +"</td>"+
					"</input></td>" +
					
					" </tr>";
	 }
	 
	tableText += "</table>";
	document.getElementById('divcons').innerHTML = tableText;  
	document.getElementById('txtBundles').value  = XMLSize.length;  
	getTotQty();
	hideBackGroundBalck();
}

function getTotQty()
{
totOutputQty	= 0;
var bundles		= 0;
var tbl 		= document.getElementById('tblevents');

	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[7].childNodes[0].checked == true){
			totOutputQty += parseFloat(tbl.rows[loop].cells[6].childNodes[0].value);
			bundles++;
		}
	}
document.getElementById('txtTotWashQty').value= totOutputQty;  
document.getElementById('txtBundles').value= bundles;  
}
//------check whether the output Qty is greater than input Qty------------------
function compQty(loop)
{
var tbl 			= document.getElementById('tblevents');
loop				= parseFloat(loop)+1;
var OutputQty 		= parseFloat(tbl.rows[loop].cells[6].childNodes[0].value);
var InputQty		= parseFloat(tbl.rows[loop].cells[5].innerHTML.trim());

var searchYear		= document.getElementById('txtSearchWashReadyYear').value;
var searchSerialNo	= document.getElementById('txtSearchWashReadyNo').value;

	if((searchYear!="") && (searchSerialNo!=""))
		InputQty +=parseFloat(tbl.rows[loop].cells[6].id)	

	if(OutputQty > InputQty){
		alert("Invalid Output Qty");
		tbl.rows[loop].cells[6].childNodes[0].value=InputQty;
	}
	if(OutputQty ==0){
		tbl.rows[loop].cells[7].childNodes[0].checked=false;
	}
	else{
		tbl.rows[loop].cells[7].childNodes[0].checked=true;
	}

	var chk=0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[7].childNodes[0].checked == true)
		chk++;
	}
	
	if(chk==tbl.rows.length-1)
		document.getElementById('chkCheckAll').checked=true;	
	else
	document.getElementById('chkCheckAll').checked=false;
	
	getTotQty();		
}

function checkAll(obj)
{
	var tbl = document.getElementById('tblevents');
	if(obj.checked)
	{		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[7].childNodes[0].checked = true;
			tbl.rows[loop].cells[6].childNodes[0].value =tbl.rows[loop].cells[6].id.trim();
			
		}
	document.getElementById('txtTotWashQty').value= 0;  
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
		    tbl.rows[loop].cells[6].childNodes[0].value = 0;
			tbl.rows[loop].cells[7].childNodes[0].checked = false;
			
		}
	}
	getTotQty();
}

function checkUncheckTextBox(objevent)
{
	var tbl = document.getElementById('tblevents');
	var rw 	= objevent.parentNode.parentNode;
	
	if (rw.cells[7].childNodes[0].checked)
	{
		rw.cells[6].childNodes[0].value =rw.cells[6].id.trim();
		rw.cells[6].childNodes[0].focus();
	}
	else
	{
		rw.cells[6].childNodes[0].value = 0;
		rw.cells[6].childNodes[0].focus();
	}
	
	var chk=0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[7].childNodes[0].checked == true)
		chk++;
	}
	if(chk==tbl.rows.length-1)
		document.getElementById('chkCheckAll').checked=true;	
	else
		document.getElementById('chkCheckAll').checked=false;	
	
	getTotQty();
}

function SaveWashReadyData()
{
	if(ValidateHeaderDets())
	{	
		showBackGroundBalck();
		pub_orderId			= document.getElementById("cboPoNo").value;
		var WashDate 		= document.getElementById("txtDate").value;
		var factory 		= document.getElementById("cboFactory").value;
		var WashReadyYear 	= document.getElementById("txtYear").value;
		var styleID 		= document.getElementById("cboPoNo").value;
		var pattern 		= document.getElementById("txtPattern").value;
		var teamNo 			= document.getElementById("txtLineNo").value;
		var Status 			= 0;
		
		var SelectOption	= document.frmProductionWashReady.cboCutNo;
		var SelectedIndex	= SelectOption.selectedIndex;
		var SelectedValue	= SelectOption.value;
		var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
		var cutNo 			= SelectedText;	
		
		if(document.getElementById("cboCutNo").value=="")
			cutNo="";	
		
		var totQty 			= 0;
		var totBalQty 		= 0;
		
		var searchYear=document.getElementById('txtSearchWashReadyYear').value;
		var searchSerialNo=document.getElementById('txtSearchWashReadyNo').value;

		var url = 'xml.php?RequestType=SaveWashReadyHeader&WashDate=' + WashDate + '&factory='+ factory + '&WashReadyYear='+ WashReadyYear + '&styleID='+ styleID + '&cutNo='+ cutNo + '&pattern='+ pattern + '&teamNo='+ teamNo + '&totQty='+ totQty+ '&totBalQty='+ totBalQty+ '&Status='+ Status+ '&searchSerialNo='+ searchSerialNo+ '&searchYear='+ searchYear;
		htmlobj=$.ajax({url:url,async:false});
		HandleSavingHeader(htmlobj);
	}
}

function HandleSavingHeader(htmlobj)
{
	var XMLOutput 			= htmlobj.responseXML.getElementsByTagName("Save");
	var XMLWashreadySerial 	= htmlobj.responseXML.getElementsByTagName("WashreadySerial");
	var XMLWashreadyYear 	= htmlobj.responseXML.getElementsByTagName("WashreadyYear");
	if(XMLOutput[0].childNodes[0].nodeValue == "True")
	{
		var WashreadySerial = XMLWashreadySerial[0].childNodes[0].nodeValue;
		var year 			= XMLWashreadyYear[0].childNodes[0].nodeValue;
		var factory 		= document.getElementById("cboFactory").value;
		
		var tbl 			= document.getElementById('tblevents');
		var CutBundleSerial	= "";
		var BundleNo		= "";
		var Qty				= "";
		var RecvQty			= "";
		var remarks			= "";
		var BalQty			= "";		
		var savedRcds		= 0;
		var tblRecords		= 0;
	
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[6].childNodes[0].value!=0)
			{
				CutBundleSerial = tbl.rows[loop].cells[10].childNodes[0].value;
				BundleNo 		=  tbl.rows[loop].cells[2].innerHTML;
				Qty 			= tbl.rows[loop].cells[5].innerHTML.trim();
				RecvQty 		= tbl.rows[loop].cells[6].childNodes[0].value;
				remarks 		= tbl.rows[loop].cells[9].childNodes[0].value; 
				
				if(RecvQty=="")
					RecvQty=0;

				if(Qty=="")
				 	Qty=0;
				
				BalQty =  Qty-RecvQty;
	
				var url = 'xml.php?RequestType=SaveWashReadyDetails&WashreadySerial=' + WashreadySerial + '&CutBundleSerial='+ CutBundleSerial+ '&year='+ year + '&BundleNo='+ BundleNo + '&Qty='+ RecvQty + '&BalQty='+ BalQty + '&factory='+ factory  + '&remarks='+ remarks;
				htmlobj=$.ajax({url:url,async:false});
				
				var XMLResult = htmlobj.responseXML.getElementsByTagName("result");
				if(XMLResult[0].childNodes[0].nodeValue==1)
					savedRcds++;	

				tblRecords++;
			}

		}//end of for loop
		if(savedRcds==tblRecords)
			HandleSavingDetails(1,htmlobj);
		else
			HandleSavingDetails(0,'');
	}
	else
	{
		alert("The event Wash Ready header save failed.");	
	}
}

function HandleSavingDetails(saved,htmlobj)
{
	var searchYear		= document.getElementById('txtSearchWashReadyYear').value;
	var searchSerialNo	= document.getElementById('txtSearchWashReadyNo').value;
	
	if(saved== 1)
	{		
		alert("Saved successfully.");
		
		if((searchYear=="") && (searchSerialNo==""))
			ClearForm();
		else
			loadInputFrom(searchYear,searchSerialNo);	
	}
	else
		alert("Error occur while saving data.Please save again.");
	
	if((searchYear=="") && (searchSerialNo==""))
	{
		document.getElementById("cboPoNo").value = pub_orderId;
		document.getElementById('cboPoNo').onchange();
	}
	hideBackGroundBalck();
}

function loadInputFrom(year,serialNo)
{
	document.getElementById('txtSearchWashReadyYear').value = year;
	document.getElementById('txtSearchWashReadyNo').value 	= serialNo;
	var url = pub_url+'xml.php?RequestType=LoadHeaderToSerial&serialNo='+ serialNo + '&year='+ year;
	var htmlobj = $.ajax({url:url,async:false});
	LoadHeaderToSerial(htmlobj)
	LoadGrid();
	disableFields();
}

function LoadHeaderToSerial(xmlHttp)
{
	 var XMLFactory 	= xmlHttp.responseXML.getElementsByTagName("factory");
	 document.getElementById('cboFactory').value 	  = XMLFactory[0].childNodes[0].nodeValue;			 
	 document.getElementById('cboFactory').disabled   = true;			 
	 var XMLStyle 		= xmlHttp.responseXML.getElementsByTagName("style");
	 document.getElementById('cboPoNo').innerHTML 	  = XMLStyle[0].childNodes[0].nodeValue;			 
	 var XMLPoNo 		= xmlHttp.responseXML.getElementsByTagName("PoNo");
	 document.getElementById('cboStyle').innerHTML 	  = XMLPoNo[0].childNodes[0].nodeValue;			 
	 var XMLCutNo 		= xmlHttp.responseXML.getElementsByTagName("cutNo");
	 document.getElementById('cboCutNo').innerHTML 	  = XMLCutNo[0].childNodes[0].nodeValue;			 
	 var XMLBundleNo 	= xmlHttp.responseXML.getElementsByTagName("bundleNo");
	 document.getElementById('cboBundleNo').innerHTML = XMLBundleNo[0].childNodes[0].nodeValue;			 
	 var XMLDate 		= xmlHttp.responseXML.getElementsByTagName("date");
	 document.getElementById('txtDate').value 		  = XMLDate[0].childNodes[0].nodeValue;
}

function ClearForm()
{
	document.frmProductionWashReady.reset();	
	document.getElementById('txtSearchWashReadyNo').value	= "";
	document.getElementById('txtSearchWashReadyYear').value = "";	
	document.getElementById('cboFactory').disabled 			= false;	
	document.getElementById('cboPoNo').innerHTML			= "";
	document.getElementById('cboStyle').innerHTML 			= "";
	document.getElementById('cboCutNo').innerHTML			= "";
	document.getElementById('cboBundleNo').innerHTML 		= "";
	clearTable();	
	document.getElementById('cboFactory').disabled 			= false;
	document.getElementById('cboStyle').disabled 			= false;
	document.getElementById('cboPoNo').disabled 			= false;
	document.getElementById('cboBundleNo').disabled 		= false;
	document.getElementById('cboCutNo').disabled 			= false;
	document.getElementById('cboFactory').onchange();	
}
//---------Validate form----------------------------------------------------------------------
function clearTable()
{
	var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblevents\" border=\"0\">"+
					"<tr>"+
						"<td width=\"9%\" height=\"18\" class=\"grid_header\">Cut No</td>"+
						"<td width=\"9%\" class=\"grid_header\">Size</td>"+
						"<td width=\"9%\" class=\"grid_header\">Bundle No</td>"+
						"<td width=\"9%\" class=\"grid_header\">Range</td>"+
						"<td width=\"9%\" class=\"grid_header\">Shade</td>"+
						"<td width=\"10%\" class=\"grid_header\">Bal Qty</td>"+
						"<td width=\"10%\" class=\"grid_header\">Wash Qty</td>"+
						"<td width=\"5%\" class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" checked=\"checked\"  /></td>"+
						"<td width=\"9%\" class=\"grid_header\">Line No</td>"+
						"<td width=\"10%\" class=\"grid_header\">Remarks</td>"+
						"<td width=\"10%\" class=\"grid_header\">Color</td>"+
						"<td width=\"1%\" class=\"grid_header\" style=\"display:none\"></td>"+
					"</tr>";	
	tableText += "</table>";

document.getElementById('divcons').innerHTML = tableText;
document.getElementById("cboFactory").focus();
}

function ValidateHeaderDets()
{
	var tbl = document.getElementById('tblevents');
    var rows = tbl.rows.length-1;
	var recvCount=0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[6].childNodes[0].value != 0){
			recvCount += parseFloat(tbl.rows[loop].cells[6].childNodes[0].value);
		}
	}	
	
	if (document.getElementById('cboFactory').value == "" )	
	{
		alert("Please select the 'Factory' ");
		document.getElementById('cboFactory').focus();
		return false;
	}
	else if (document.getElementById('cboPoNo').value == "" )	
	{
		alert("Please select the 'Order No'");
		document.getElementById('cboPoNo').focus();
		return false;
	}
	else if (document.getElementById('cboStyle').value == "" )	
	{
		alert("Please select the 'Style No'");
		document.getElementById('cboStyle').focus();
		return false;
	}
	else if (document.getElementById('txtDate').value == "" )	
	{
		alert("Please select the 'Date' ");
		document.getElementById('txtDate').focus();
		return false;
	}
	else if (rows<1)	
	{
		alert("No details appear in the grid.");
		document.getElementById('cboFactory').focus();
		return false;
	}
	else if (recvCount<=0)	
	{
		alert("There is no any 'Wash Qty' to save. ");
		return false;
	}
return true;
}

function disableFields()
{
	 document.getElementById('cboFactory').disabled 	= true;
	 document.getElementById('cboStyle').disabled 		= true;
	 document.getElementById('cboPoNo').disabled 		= true;
	 document.getElementById('cboBundleNo').disabled 	= true;
	 document.getElementById('cboCutNo').disabled 		= true;
}
//line 634