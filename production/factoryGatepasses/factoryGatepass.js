var xmlHttpreq = [];
var pub_url = "/gapro/production/factoryGatepasses/";
var ArrayCutNos="";
var ArrayDate="";

var ArrayCutBundleSerial="";
var ArrayBundleNo ="";
var ArrayQty ="";
var ArrayBalQty = "";
var ArrayCutNo ="";
var ArraySize="";
var ArrayRange="";
var ArrayShade="";
var ArrRemarks="";
var totGatePassQty=0;
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
//------------------------------------------------------------------------------------------------------------
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
//----------Load Po No & Style-------------------------------------------------------------------------------------
function loadPoNoAndStyle()
{
	var factoryID=document.getElementById("cboFromFactory").value;
	createNewXMLHttpRequest(0);
	xmlHttpreq[0].onreadystatechange = HandlePoNoAndStyle;

	xmlHttpreq[0].open("GET",pub_url+'xml.php?RequestType=loadPoNoAndStyle&factoryID='+ factoryID ,true);
	xmlHttpreq[0].send(null);
}
//------------------------------
function HandlePoNoAndStyle()
{
	if(xmlHttpreq[0].readyState == 4) 
	{
		if(xmlHttpreq[0].status == 200) 
		{
		//	alert(xmlHttpreq[0].responseText);
			 document.getElementById('cboPoNo').innerHTML= "";
			 document.getElementById('cboStyle').innerHTML= "";
			 clearFirstGrid();
			 clearSecondGrid();
		 var XMLPoNo = xmlHttpreq[0].responseXML.getElementsByTagName("orderNo");
		 var XMLStyle = xmlHttpreq[0].responseXML.getElementsByTagName("style");
			 document.getElementById('cboPoNo').innerHTML= XMLPoNo[0].childNodes[0].nodeValue;
			 document.getElementById('cboStyle').innerHTML= XMLStyle[0].childNodes[0].nodeValue;
		}
	}		
}
//-----------load (style & Po when click po or style) & load Grids----------------------------------------------
function loadStylePoNoGrids(styleID)
{
	 document.getElementById('cboPoNo').value= styleID;
	 document.getElementById('cboStyle').value = styleID;
	 loadGrids('','');
}
//-----------------------------------
function loadGrids(arrCutNos,arrDates)
{

	var searchYear=document.getElementById('txtSearchYear').value;
	var searchSerialNo=document.getElementById('txtGPass').value;
	
	if(((searchYear=="") && (searchSerialNo=="")) && (document.getElementById('cboFromFactory').value.trim()==''))
	{
		return false;
	}
		 var styleID=document.getElementById('cboStyle').value
		 var factoryID=document.getElementById("cboFromFactory").value;
		 
		//hem-30/09/2010-----------------
		var url=pub_url+"xml.php";
		url=url+"?RequestType=loadGrids";
		url += '&factoryID='+factoryID;
		url += '&styleID='+styleID;
		url += '&searchYear='+searchYear;
		url += '&searchSerialNo='+searchSerialNo;
		url += '&ArrayCutNos='+arrCutNos;
		url += '&ArrayDates='+arrDates;
		
		var htmlobj=$.ajax({url:url,async:false});
		//-------------------------------
		//alert(htmlobj.responseText); 
		//Load First Grid---------------------------------------------
		var XMLDate = htmlobj.responseXML.getElementsByTagName("Date");
			var XMLCutNo = htmlobj.responseXML.getElementsByTagName("CutNo");

			
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblFirst\" border=\"0\">"+
                                "<tr>"+
                                  "<td width=\"35%\" height=\"18\" class=\"grid_header\">Cut No</td>"+
                                  "<td width=\"35%\" class=\"grid_header\">Date</td>"+
                                  "<td width=\"30%\" class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" checked=\"checked\"  /></td>"+
								  "</tr>";
								
			 for ( var loop = 0; loop < XMLCutNo.length; loop ++)
			 {
				if((loop%2)==0){
				var rowClass="grid_raw"	
				}
				else{
				var rowClass="grid_raw2"	
				}
				 
				tableText +=" <tr  class=\"" + rowClass + "\">" +
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLCutNo[loop].childNodes[0].nodeValue + "\" > "+ XMLCutNo[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLDate[loop].childNodes[0].nodeValue + "\" > "+ XMLDate[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"right\"><input type=\"checkbox\" checked=\"true\" name=\"chkStatus\" id=\"chkStatus\"  onclick=\"loadChkCutGrid(this);\" /> " +
							"</input></td>" +
							
							" </tr>";
							
							
			 }
			tableText += "</table>";
			
			if(arrCutNos==""){
			document.getElementById('divTable1').innerHTML=tableText;  
			}



	//---Load Second Grid----------------------------------------------	
			var XMLCutNo1 = htmlobj.responseXML.getElementsByTagName("CutNo1");
			var XMLSize = htmlobj.responseXML.getElementsByTagName("Size");
			var XMLBundle = htmlobj.responseXML.getElementsByTagName("Bundle");
			var XMLRange = htmlobj.responseXML.getElementsByTagName("Range");
			var XMLShade = htmlobj.responseXML.getElementsByTagName("Shade");
			var XMLWashQty = htmlobj.responseXML.getElementsByTagName("WashQty");
			var XMLGPQty = htmlobj.responseXML.getElementsByTagName("GPQty");
			var XMLCutBundserial = htmlobj.responseXML.getElementsByTagName("CutBundserial");
			var XMLRemarks = htmlobj.responseXML.getElementsByTagName("remarks");
			
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblSecond\" border=\"0\">"+
                                "<tr>"+
                                  "<td width=\"10%\" height=\"18\" class=\"grid_header\">Cut No</td>"+
                                  "<td width=\"12%\" class=\"grid_header\">Size</td>"+
                                  "<td width=\"12%\" class=\"grid_header\">Bundle No</td>"+
                                  "<td width=\"19%\" class=\"grid_header\">Range</td>"+
                                  "<td width=\"12%\" class=\"grid_header\">Shade</td>"+
                                  "<td width=\"10%\" class=\"grid_header\">Bal Qty</td>"+
                                  "<td width=\"8%\" class=\"grid_header\">GP Qty</td>"+
                                  "<td width=\"3%\" class=\"grid_header\"><input name=\"chkAllSecond\" type=\"checkbox\" id=\"chkAllSecond\" onclick=\"checkAllTblSecond(this);\" checked=\"checked\"  /></td>"+
                                  "<td width=\"1%\" style=\"display:none\" class=\"grid_header\"></td>"+
								  " <td width=\"12%\" class=\"grid_header\">Remarks</td>"+
								  "</tr>";

								
			 for ( var loop = 0; loop < XMLCutNo1.length; loop ++)
			 {
				if((loop%2)==0){
				var rowClass="grid_raw"	
				}
				else{
				var rowClass="grid_raw2"	
				}
				 
				tableText +=" <tr  class=\"" + rowClass + "\">" +
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLCutNo1[loop].childNodes[0].nodeValue + "\" > "+ XMLCutNo1[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLSize[loop].childNodes[0].nodeValue + "\" > "+ XMLSize[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLBundle[loop].childNodes[0].nodeValue + "\" > "+ XMLBundle[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLRange[loop].childNodes[0].nodeValue + "\" > "+ XMLRange[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLShade[loop].childNodes[0].nodeValue + "\" > "+ XMLShade[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntRite\" align=\"center\" id=\"" + XMLWashQty[loop].childNodes[0].nodeValue + "\" > "+ XMLWashQty[loop].childNodes[0].nodeValue +"&nbsp;</td>"+
							" <td class=\"normalfntMid\" align=\"right\" id=\"" + XMLGPQty[loop].childNodes[0].nodeValue + "\" ><input type=\"text\"  id=\"" + loop + "\" name=\"" + loop + "\"  class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" value=\""+ XMLGPQty[loop].childNodes[0].nodeValue+"\" onkeypress=\"return isNumberKey(event);\" onkeyup=\" compQty(this.name);getTotQty();\" > " +
							"</input></td>" +
							" <td class=\"normalfntMid\" align=\"right\"><input type=\"checkbox\" checked=\"true\" name=\"chkStatus\" id=\"chkStatus\"  onclick=\"checkUncheckTextBox(this);\" /> " +
							"</input></td>" +
							" <td class=\"normalfntMid\" align=\"right\" style=\"display:none\"><input type=\"hidden\" id=\"offset\" name=\"offset\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" value=\""+ XMLCutBundserial[loop].childNodes[0].nodeValue+"\"> " +
							"</input></td>" +
							" <td class=\"normalfntMid\" align=\"right\"><input type=\"text\"  class=\"txtbox\" style=\"text-align:left\" size=\"10px\" align =\"left\" value=\""+ XMLRemarks[loop].childNodes[0].nodeValue+"\"> " +
							" </tr>";
															  						

							
			 }
			tableText += "</table>";

			document.getElementById('divTable2').innerHTML=tableText;  
			
			
//get total gate pass Qty----------			
		getTotQty()
		
document.getElementById("cboFromFactory").focus();
}

//-------------check all cut numbers----------------------------------------------------------------------------------------------
function checkAll(obj)
{
	var tbl = document.getElementById('tblFirst');
	if(obj.checked)
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[2].childNodes[0].checked = true;
		}
		 loadGrids('','')
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[2].childNodes[0].checked = false;
		}
		clearSecondGrid();
	}
	
}
//-----clear first grid-----------------------------------------------------
function clearFirstGrid()
{
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblFirst\" border=\"0\">"+
                                "<tr>"+
                                  "<td width=\"35%\" height=\"18\" class=\"grid_header\">Cut No</td>"+
                                  "<td width=\"35%\" class=\"grid_header\">Date</td>"+
                                  "<td width=\"30%\" class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" /></td>"+
								  "</tr>";
								
			tableText += "</table>";
			document.getElementById('divTable1').innerHTML=tableText;  
}
//-----clear second grid-----------------------------------------------------
function clearSecondGrid()
{
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblSecond\" border=\"0\">"+
                                "<tr>"+
                                  "<td width=\"10%\" height=\"18\" class=\"grid_header\">Cut No</td>"+
                                  "<td width=\"12%\" class=\"grid_header\">Size</td>"+
                                  "<td width=\"12%\" class=\"grid_header\">Bundle No</td>"+
                                  "<td width=\"19%\" class=\"grid_header\">Range</td>"+
                                  "<td width=\"12%\" class=\"grid_header\">Shade</td>"+
                                  "<td width=\"10%\" class=\"grid_header\">Bal Qty</td>"+
                                  "<td width=\"8%\" class=\"grid_header\">GP Qty</td>"+
                                  "<td width=\"3%\" class=\"grid_header\"><input name=\"chkAllSecond\" type=\"checkbox\" id=\"chkAllSecond\" onclick=\"checkAllTblSecond(this);\" /></td>"+
                                  "<td width=\"1%\" style=\"display:none\" class=\"grid_header\"></td>"+
								  " <td width=\"12%\" class=\"grid_header\">Remarks</td>"+
								  "</tr>";
								
			tableText += "</table>";
			document.getElementById('divTable2').innerHTML=tableText;  
			
			//$("#tblSecond tr:gt(0)").remove();
}
//-----load clickes cut numbers data-----------------------------------------------------
function loadChkCutGrid(obj)
{
	ArrayCutNos ="";
	ArrayDate ="";
	
	var tbl = document.getElementById('tblFirst');
	var chk=0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[2].childNodes[0].checked == true)
		{
			chk++;
		    var cutNo = tbl.rows[loop].cells[0].innerHTML;
		    var date = tbl.rows[loop].cells[1].innerHTML;
			ArrayCutNos += cutNo + ",";
			ArrayDate += date + ",";
		//	alert(cutNo);
		//	alert(date);
		}
	}
	
	//--------
	if(chk==tbl.rows.length-1){
	document.getElementById('chkCheckAll').checked=true;	
	}
	else{
	document.getElementById('chkCheckAll').checked=false;	
	}
	//---------
	if(chk>0){
	loadGrids(ArrayCutNos,ArrayDate);
	}
	else{
	clearSecondGrid();
	}
	 
}
//------------------------------------
function HandleSecondGrid()
{
	if(xmlHttpreq[2].readyState == 4) 
    {
        if(xmlHttpreq[2].status == 200) 
        { 
			//alert(xmlHttpreq[2].responseText);
			LoadSecondGrid();
		}		
	}
}

//--------------11-05-2011-hem-----------------------
function SaveFinishGoodGPData()
{
	if(ValidateHeaderDets())
	{	
		showBackGroundBalck();
		
		var GPDate = document.getElementById("txtDate").value;
		var GPYear = document.getElementById("txtYear").value;
		var fromFactory = document.getElementById("cboFromFactory").value;
		var toFactory = document.getElementById("cboToFactory").value;
		var styleID = document.getElementById("cboPoNo").value;
		var vehicleNo = document.getElementById("txtVehicleNo").value;
		var Remarks   = document.getElementById("txtareaRemaks").value;
		var Status = 0;
		
		var totQty = 0;
		var totBalQty = 0;
		
		//--if searching---------
		var searchYear=document.getElementById('txtSearchYear').value;
		var searchSerialNo=document.getElementById('txtGPass').value;
		//-----------------------


		var url = 'xml.php?RequestType=SaveFinishGoodGPHeader&GPDate=' + GPDate + '&GPYear='+ GPYear + '&fromFactory='+ fromFactory + '&toFactory='+ toFactory + '&styleID='+ styleID + '&Status='+ Status + '&totQty='+ totQty + '&totBalQty='+ totBalQty + '&searchSerialNo='+ searchSerialNo+ '&searchYear='+ searchYear+ '&vehicleNo='+ vehicleNo +'&Remarks='+URLEncode(Remarks);
		htmlobj=$.ajax({url:url,async:false});
		HandleSavingHeader(htmlobj);
		
	}
}

//--------------11-05-2011-hem-----------------------
function HandleSavingHeader(htmlobj)
{
	var XMLOutput = htmlobj.responseXML.getElementsByTagName("Save");
	var XMLGatePassNo = htmlobj.responseXML.getElementsByTagName("GatePassNo");
	var XMLGatePassYear =htmlobj.responseXML.getElementsByTagName("GPyear");
	
	if(XMLOutput[0].childNodes[0].nodeValue == "True")
	{
		var GatePassNo = XMLGatePassNo[0].childNodes[0].nodeValue;
		//var year = document.getElementById("txtYear").value;
		var year = XMLGatePassYear[0].childNodes[0].nodeValue;
		var factory = document.getElementById("cboFromFactory").value;
		
		var tbl = document.getElementById('tblSecond');
		
		var noOfRows				= 0;
		var CutBundleSerial	= "";
		var BundleNo 			= "";
		var Qty 				= "";
		var RecvQty 			= "";
		var CutNo			= "";
		var Size 				= "";
		var Range 			= "";
		var Shade			= "";
		var remarks 				= "";
		var BalQty 				= "";
		
		//noOfRows=tbl.rows.length-1;
		var savedRcds=0;
		var tblRecords=0;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[6].childNodes[0].value!=0)
			{
				CutBundleSerial = tbl.rows[loop].cells[8].childNodes[0].value;
				BundleNo =  tbl.rows[loop].cells[2].innerHTML;
				Qty = tbl.rows[loop].cells[5].innerHTML.trim();
				RecvQty = tbl.rows[loop].cells[6].childNodes[0].value;
				CutNo =  tbl.rows[loop].cells[0].innerHTML;
				Size =  tbl.rows[loop].cells[1].innerHTML;
				Range =  tbl.rows[loop].cells[3].innerHTML;
				Shade =  tbl.rows[loop].cells[4].innerHTML;
				remarks = tbl.rows[loop].cells[9].childNodes[0].value;
				if(RecvQty==""){
				 RecvQty=0;
				}
				if(Qty==""){
				 Qty=0;
				}
				BalQty =  Qty-RecvQty;
	
					
				//SaveCutPCTransferINDetails(CutGPTransferIN,year,ArrayCutBundleSerial,ArrayBundleNo,ArrayQty,ArrayBalQty,noOfRows,GPnumber,ArrayStyleID,factory,date,ArrRemarks);
				var url = 'xml.php?RequestType=SaveFinishGoodGPDetails&GatePassNo=' + GatePassNo + '&year='+ year+ '&CutBundleSerial='+ CutBundleSerial + '&BundleNo='+ BundleNo + '&Qty='+ RecvQty + '&BalQty='+ BalQty + '&CutNo='+ CutNo + '&Size='+ Size + '&Range='+ Range + '&Shade='+ Shade + '&factory='+ factory+'&remarks='+remarks;
				htmlobj=$.ajax({url:url,async:false});
				
				var XMLResult = htmlobj.responseXML.getElementsByTagName("result");
			//	alert(XMLResult[0].childNodes[0].nodeValue);
				if(XMLResult[0].childNodes[0].nodeValue==1){
				savedRcds++;	
			//	alert(savedRcds);
				}
				tblRecords++;
			}
			
		}
		//alert(savedRcds);
		//alert(tblRecords);
			if(savedRcds==tblRecords)
			HandleSavingDetails(1,GatePassNo,year);
			else
			HandleSavingDetails(0,GatePassNo,year);
	}
	else
	{
		alert("The Gate pass header save failed.");	
	//				document.getElementById('txtevent').focus();
	}
}

//-----------------------------------------------
function HandleSavingDetails(saved,GatePassNo,year)
{
	var searchYear=document.getElementById('txtSearchYear').value;
	var searchSerialNo=document.getElementById('txtGPass').value;
//	var XMLResult = xmlHttpreq[4].responseXML.getElementsByTagName("SaveDetail");
	
	if(saved== 1)
	{
		hideBackGroundBalck();
		if(confirm("Saved successfully.\nAre you sure you want to view 'GatePass Report'."));
		{
			newwindow=window.open('rptFactoryGatepass.php?SerialNumber='+GatePassNo+ '&intYear='+year,'rptFactoryGatepass.php');
			if (window.focus) {newwindow.focus()}
		}
		
		if((searchYear=="") && (searchSerialNo=="")){
			clearForm(); //comment this line because user must able to get a report after save details.
			//document.getElementById('butSave').style.display='none';
		}
		else{
			loadInputFrom(searchYear,searchSerialNo);	
		}
	}
	else{
		alert("The details saved fail.");
	}
}









/*

//------------------save---------(1)header--------------------------------------------------------
function SaveFinishGoodGPData()
{
	if(ValidateHeaderDets())
	{	
		showBackGroundBalck();
		
		var GPDate = document.getElementById("txtDate").value;
		var GPYear = document.getElementById("txtYear").value;
		var fromFactory = document.getElementById("cboFromFactory").value;
		var toFactory = document.getElementById("cboToFactory").value;
		var styleID = document.getElementById("cboPoNo").value;
		var vehicleNo = document.getElementById("txtVehicleNo").value;
		var Status = 0;
		
		var totQty = 0;
		var totBalQty = 0;
		
		//--if searching---------
		var searchYear=document.getElementById('txtSearchYear').value;
		var searchSerialNo=document.getElementById('txtGPass').value;
		//-----------------------

// Saving Event Template Header
	    createNewXMLHttpRequest(3);
    	xmlHttpreq[3].onreadystatechange = HandleSavingHeader;
    	xmlHttpreq[3].open("GET",'xml.php?RequestType=SaveFinishGoodGPHeader&GPDate=' + GPDate + '&GPYear='+ GPYear + '&fromFactory='+ fromFactory + '&toFactory='+ toFactory + '&styleID='+ styleID + '&Status='+ Status + '&totQty='+ totQty + '&totBalQty='+ totBalQty + '&searchSerialNo='+ searchSerialNo+ '&searchYear='+ searchYear+ '&vehicleNo='+ vehicleNo , true);
    	xmlHttpreq[3].send(null);
		
		noOfRows=0;
		ArrayCutBundleSerial="";
		ArrayBundleNo ="";
		ArrayCutNo ="";
		ArraySize="";
		ArrayRange="";
		ArrayShade="";
		ArrayQty =0;
		ArrayBalQty = 0;
		ArrRemarks="";
		var tbl = document.getElementById('tblSecond');
		noOfRows=tbl.rows.length-1;
	
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[6].childNodes[0].value!=0)
			{
				var CutBundleSerial = tbl.rows[loop].cells[8].childNodes[0].value;
				var BundleNo =  tbl.rows[loop].cells[2].innerHTML;
				var Qty = tbl.rows[loop].cells[5].innerHTML.trim();
				var RecvQty = tbl.rows[loop].cells[6].childNodes[0].value;
				var CutNo =  tbl.rows[loop].cells[0].innerHTML;
				var Size =  tbl.rows[loop].cells[1].innerHTML;
				var Range =  tbl.rows[loop].cells[3].innerHTML;
				var Shade =  tbl.rows[loop].cells[4].innerHTML;
				var remarks = tbl.rows[loop].cells[9].childNodes[0].value;
				if(RecvQty==""){
				 RecvQty=0;
				}
				if(Qty==""){
				 Qty=0;
				}
				var BalQty =  Qty-RecvQty;
	

				if (fromFactory.length > 0)
				{
						ArrayCutBundleSerial += CutBundleSerial + "<*>";
						ArrayBundleNo += BundleNo + "<*>";
						ArrayQty += RecvQty + "<*>";
						ArrayBalQty += BalQty + "<*>";
						ArrayCutNo += CutNo + "<*>";
						ArraySize += Size + "<*>";
						ArrayRange += Range + "<*>";
						ArrayShade += Shade + "<*>";
						ArrRemarks += remarks+ "<*>";
				 }
			}

		}
	}
}
//----------------------------
function HandleSavingHeader()
{
	if(xmlHttpreq[3].readyState == 4) 
    {
        if(xmlHttpreq[3].status == 200) 
        {
				//alert(xmlHttpreq[3].responseText);
 
			var XMLOutput = xmlHttpreq[3].responseXML.getElementsByTagName("Save");
			var XMLGatePassNo = xmlHttpreq[3].responseXML.getElementsByTagName("GatePassNo");
			if(XMLOutput[0].childNodes[0].nodeValue == "True")
			{
				var GatePassNo = XMLGatePassNo[0].childNodes[0].nodeValue;
				var year = document.getElementById("txtYear").value;
		        var factory = document.getElementById("cboFromFactory").value;
				
				SaveOutputDetails(factory,GatePassNo,year,ArrayCutBundleSerial,ArrayBundleNo,ArrayQty,ArrayBalQty,ArrayCutNo,ArraySize,ArrayRange,ArrayShade,noOfRows,ArrRemarks);
			}
			else
			{
				alert("The Gate pass header save failed.");	
//				document.getElementById('txtevent').focus();
			}
		}		
	}
}
//--------------------------(2)Save details-------------------------------------------------------------------------------
function SaveOutputDetails(factory,GatePassNo,year,ArrayCutBundleSerial,ArrayBundleNo,ArrayQty,ArrayBalQty,ArrayCutNo,ArraySize,ArrayRange,ArrayShade,noOfRows,ArrRemarks)
{
	// Saving Event Template Details
	createNewXMLHttpRequest(4);

	xmlHttpreq[4].onreadystatechange = HandleSavingDetails;
	xmlHttpreq[4].open("POST",'xml.php?RequestType=SaveFinishGoodGPDetails&GatePassNo=' + GatePassNo + '&year='+ year+ '&ArrayCutBundleSerial='+ ArrayCutBundleSerial + '&ArrayBundleNo='+ ArrayBundleNo + '&ArrayQty='+ ArrayQty + '&ArrayBalQty='+ ArrayBalQty + '&ArrayCutNo='+ ArrayCutNo + '&ArraySize='+ ArraySize + '&ArrayRange='+ ArrayRange + '&ArrayShade='+ ArrayShade + '&noOfRows='+ noOfRows + '&factory='+ factory+'&ArrRemarks='+ArrRemarks , true);
	xmlHttpreq[4].send(null);	

}
//-----------------------------

function HandleSavingDetails()
{
	if(xmlHttpreq[4].readyState == 4) 
    {
        if(xmlHttpreq[4].status == 200)
 
        { 
		//alert(xmlHttpreq[4].responseText);
			var searchYear=document.getElementById('txtSearchYear').value;
			var searchSerialNo=document.getElementById('txtGPass').value;
			 var XMLResult = xmlHttpreq[4].responseXML.getElementsByTagName("SaveDetail");
			
			if(XMLResult[0].childNodes[0].nodeValue == "True")
			{
				hideBackGroundBalck();
				alert("The details saved successfully.");
				
				if((searchYear=="") && (searchSerialNo=="")){
				clearForm();
				}
				else{
				loadInputFrom(searchYear,searchSerialNo);	
				}
			}
			else{
				alert("The details saved fail.");
			}
		}		
	}
}
*/
//-clear form
function clearForm()
{
/*	document.frmProductionGatePass.reset();
	document.getElementById('cboPoNo').innerHTML= "";
	document.getElementById('cboStyle').innerHTML = "";
	
    document.getElementById('txtGPass').value= "";
    document.getElementById('txtSearchYear').value = "";
 
    document.getElementById('cboFromFactory').disabled = false;
    document.getElementById('cboToFactory').disabled = false;
	
	clearFirstGrid();
	clearSecondGrid();
	
document.getElementById("cboFromFactory").focus();

	 document.getElementById('cboFromFactory').disabled = false;
	 document.getElementById('cboToFactory').disabled = false;
	 document.getElementById('cboPoNo').disabled = false;
	 document.getElementById('cboStyle').disabled = false;
	var tbl = document.getElementById('tblFirst');
	tbl.rows[0].cells[2].childNodes[0].disabled=false;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		    tbl.rows[loop].cells[2].childNodes[0].disabled=false;
	}*/
	document.frmProductionGatePass.submit();
}
//---------Validate form----------------------------------------------------------------------
function ValidateHeaderDets()
{
	var tbl = document.getElementById('tblSecond');
    var rows = tbl.rows.length-1;
	var recvCount=0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[6].childNodes[0].value != 0){
		recvCount += parseFloat(tbl.rows[loop].cells[6].childNodes[0].value);
		}
	}
	
	if (document.getElementById('cboFromFactory').value == "" )	
	{
		alert("Please select a \"From Factory\". ");
		document.getElementById('cboFromFactory').focus();
		return false;
	}
	else if (document.getElementById('cboToFactory').value == "" )	
	{
		alert("Please select a \"To Factory\". ");
		document.getElementById('cboToFactory').focus();
		return false;
	}
	else if (document.getElementById('cboPoNo').value == "" )	
	{
		alert("Please select a \"PO No/Style\". ");
		document.getElementById('cboPoNo').focus();
		return false;
	}
	else if (document.getElementById('txtDate').value == "" )	
	{
		alert("Please select a \"Date\". ");
		document.getElementById('txtDate').focus();
		return false;
	}
	else if (rows<1)	
	{
		alert("There are no details for selected header. ");
		document.getElementById('cboFromFactory').focus();
		return false;
	}
	else if (recvCount<=0)	
	{
		alert("There is no any \"GP Qty\" to save. ");
		return false;
	}
	else{
		return true;
	}
}
//-----check uncheck a record--------------------------------------------------------------------------------
function checkUncheckTextBox(objevent)
{
	var tbl = document.getElementById('tblSecond');
	var rw = objevent.parentNode.parentNode;
	
	if (rw.cells[7].childNodes[0].checked)
	{
		//if(rw.cells[5].childNodes[0].value == "")
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
		if(chk==tbl.rows.length-1){
		document.getElementById('chkAllSecond').checked=true;	
		}
		else{
		document.getElementById('chkAllSecond').checked=false;	
		}
getTotQty();

}
//--------calculate total output Quantity--------------------------------------------------------------
function getTotQty()
{
	var totOutputQty=0;
	var tbl = document.getElementById('tblSecond');
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
		//	if(tbl.rows[loop].cells[7].childNodes[0].checked == true){
		    totOutputQty += parseFloat(tbl.rows[loop].cells[6].childNodes[0].value);
				//	alert(tbl.rows[loop].cells[6].childNodes[0].value);

		//	}
		}
	document.getElementById('txtTotGpQty').value= totOutputQty;  
}
//-------------------------------------------
function compQty(loop)
{
var tbl = document.getElementById('tblSecond');
loop=parseFloat(loop)+1;
var inputQty =parseFloat(tbl.rows[loop].cells[6].childNodes[0].value);
var recvQty=parseFloat(tbl.rows[loop].cells[5].innerHTML.trim());

var searchYear=document.getElementById('txtSearchYear').value;
var searchSerialNo=document.getElementById('txtGPass').value;
if((searchYear!="") && (searchSerialNo!="")){
	recvQty +=parseFloat(tbl.rows[loop].cells[6].id)	
}

if(inputQty > recvQty){
alert("Invalid Input Qty");
tbl.rows[loop].cells[6].childNodes[0].value=recvQty;
}
if(inputQty ==0){
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
		if(chk==tbl.rows.length-1){
		document.getElementById('chkAllSecond').checked=true;	
		}
		else{
		document.getElementById('chkAllSecond').checked=false;	
		}
getTotQty();
}
//------check Uncheck all records in second grid-----------------------------------------------------------------------
function checkAllTblSecond(obj)
{
	var tbl = document.getElementById('tblSecond');
	if(obj.checked)
	{
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[7].childNodes[0].checked = true;
			tbl.rows[loop].cells[6].childNodes[0].value =tbl.rows[loop].cells[6].id.trim();
			
		}
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
		    tbl.rows[loop].cells[6].childNodes[0].value = 0;
			tbl.rows[loop].cells[7].childNodes[0].checked = false;
			 tbl.rows[loop].cells[9].childNodes[0].value = "";
		}
	}
			getTotQty();
}

//----onload function--------------------------------------------------------------------------
function loadInputFrom(year,serialNo)
	{
	document.getElementById('txtSearchYear').value=year;
	document.getElementById('txtGPass').value=serialNo;
	
	
	//hem-30/09/2010-----------------
	var url=pub_url+"xml.php";
	url=url+"?RequestType=LoadHeaderToSerial";
	url += '&serialNo='+serialNo;
	url += '&year='+year;
	
	var htmlobj=$.ajax({url:url,async:false});
	//----------------------------------
	
	 var XMLfromFactory = htmlobj.responseXML.getElementsByTagName("fromFactory");
	 document.getElementById('cboFromFactory').value = XMLfromFactory[0].childNodes[0].nodeValue;
	 
	 var XMLtoFactory = htmlobj.responseXML.getElementsByTagName("toFactory");
	 document.getElementById('cboToFactory').value = XMLtoFactory[0].childNodes[0].nodeValue;
	 
	 document.getElementById('cboFromFactory').disabled = true;
	 document.getElementById('cboToFactory').disabled = true;
	 
	 var XMLStyle = htmlobj.responseXML.getElementsByTagName("style");
	 document.getElementById('cboStyle').innerHTML = XMLStyle[0].childNodes[0].nodeValue;
	 
	 var XMLPoNo = htmlobj.responseXML.getElementsByTagName("PoNo");
	 document.getElementById('cboPoNo').innerHTML = XMLPoNo[0].childNodes[0].nodeValue;
	 
	 var XMLCutNo = htmlobj.responseXML.getElementsByTagName("cutNo");
	// document.getElementById('cboCutNo').innerHTML = XMLCutNo[0].childNodes[0].nodeValue;
	 
	 var XMLDate = htmlobj.responseXML.getElementsByTagName("date");
	 document.getElementById('txtDate').value = XMLDate[0].childNodes[0].nodeValue; 
	
	 var XMLVehicle = htmlobj.responseXML.getElementsByTagName("vehicle");
	 document.getElementById('txtVehicleNo').value = XMLVehicle[0].childNodes[0].nodeValue; 
	 
	  var XMLRemarks = htmlobj.responseXML.getElementsByTagName("remarks");
	 document.getElementById('txtareaRemaks').value = XMLRemarks[0].childNodes[0].nodeValue; 
	 
	 var XMLRcvStatus = htmlobj.responseXML.getElementsByTagName('RcvStatus');
	 var CancelStatus = XMLRcvStatus[0].childNodes[0].nodeValue; 
	 
	 var XMLCStatus = htmlobj.responseXML.getElementsByTagName('CancelStatus');
	 var CStatus = XMLCStatus[0].childNodes[0].nodeValue; 
	 
	 if(CancelStatus == 0)
	 	document.getElementById('btnCancel').style.display='none';
	 else
	 	document.getElementById('btnCancel').style.display='none';
	
	if(CStatus==10){
		document.getElementById('btnCancel').style.display='none';
		document.getElementById('butSave').style.display='none';
	}
		
	loadGrids('','');
	disableFields();
	}
//-------------------------------------------------------------------
function disableFields(){
	 document.getElementById('cboFromFactory').disabled = true;
	 document.getElementById('cboToFactory').disabled = true;
	 document.getElementById('cboPoNo').disabled = true;
	 document.getElementById('cboStyle').disabled = true;
	 
	var tbl = document.getElementById('tblFirst');
	//tbl.rows[0].cells[2].childNodes[0].disabled=true;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		    tbl.rows[loop].cells[2].childNodes[0].disabled=true;
	}
}
function ViewReport()
{
	var gpNo		= document.getElementById('txtGPass').value;
	var gpYear		= document.getElementById('txtSearchYear').value;
	if(gpNo=="" || gpNo=="0")
	{
		alert("Sorry!\nNo saved details appear to view.");
		return;
	}
	
	newwindow=window.open('rptFactoryGatepass.php?SerialNumber='+gpNo+ '&intYear='+gpYear,'name');
		if (window.focus) {newwindow.focus()}
}