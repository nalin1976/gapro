var xmlHttpreq = [];
var pub_FGRPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_url = pub_FGRPath+"/production/finishGoodsReceive/";
var ArrayCutNos="";

var ArrayCutBundleSerial="";
var ArrayBundleNo ="";
var ArrayQty ="";
var ArrayBalQty = "";
var ArrayCutNo ="";
var ArraySize="";
var ArrayRange="";
var ArrayShade="";
var	ArrayColor="";
var totGatePassQty=0;
var ArrRemark = "";

var rCount=0;
var rChk=0;
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
//----------Load Po No & Style--------------------------------------
function loadPoNoAndStyle()
{

	var factoryID=document.getElementById("cboFactory").value;
	var gatePassNo=document.getElementById("cboGPNo").value;
	
	createNewXMLHttpRequest(0);
	xmlHttpreq[0].onreadystatechange = HandlePoNoAndStyle;

	xmlHttpreq[0].open("GET",pub_url+'xml.php?RequestType=loadPoNoAndStyle&factoryID='+ factoryID +'&gatePassNo='+ gatePassNo,true);
	xmlHttpreq[0].send(null);
}
//------------------------------
function HandlePoNoAndStyle()
{
	if(xmlHttpreq[0].readyState == 4) 
	{
		if(xmlHttpreq[0].status == 200) 
		{
		//alert(xmlHttpreq[0].responseText);
		 document.getElementById('cboPoNo').innerHTML="<option>Select One</option>";
		 document.getElementById('cboStyle').innerHTML= "<option>Select One</option>";
		 document.getElementById('cboColor').innerHTML= "<option>Select One</option>";
		 document.getElementById('txtOrderQty').value="";
		 document.getElementById('txtGpQty').value="";
		 document.getElementById('txtRemarks').value="";
		 document.getElementById('txtTotGpQty').value="";
		 
		 var XMLPoNo = xmlHttpreq[0].responseXML.getElementsByTagName("orderNo");
		 var XMLStyle = xmlHttpreq[0].responseXML.getElementsByTagName("style");
		 var XMLfromFactory = xmlHttpreq[0].responseXML.getElementsByTagName("fromFactory");
		 
		// clearFirstGrid();  
		 clearSecondGrid();  
		 document.getElementById('cboPoNo').innerHTML= XMLPoNo[0].childNodes[0].nodeValue;
		 document.getElementById('cboStyle').innerHTML= XMLStyle[0].childNodes[0].nodeValue;
		 document.getElementById('cboFactory').value= XMLfromFactory[0].childNodes[0].nodeValue;
		 document.getElementById('cboPoNo').selectedIndex=1;
		 document.getElementById('cboPoNo').onchange();		 
		}
	}		
}
//----------Load Po No & Style--------------------------------------
function loadColor(styleID)
{
	
    document.getElementById('cboPoNo').value= styleID;
    document.getElementById('cboStyle').value = styleID;

	var factoryID=document.getElementById("cboFactory").value;
	var gatePassNo=document.getElementById("cboGPNo").value;
	var style=document.getElementById("cboStyle").value;
	
	createNewXMLHttpRequest(5);
	xmlHttpreq[5].onreadystatechange = HandleloadColor;

	xmlHttpreq[5].open("GET",pub_url+'xml.php?RequestType=loadColor&factoryID='+ factoryID +'&gatePassNo='+ gatePassNo +'&style='+ style,true);
	xmlHttpreq[5].send(null);
}
//------------------------------
function HandleloadColor()
{
	if(xmlHttpreq[5].readyState == 4) 
	{
		if(xmlHttpreq[5].status == 200) 
		{
			var XMLColor 		= xmlHttpreq[5].responseXML.getElementsByTagName("color");
			var XMLOrderQty 	= xmlHttpreq[5].responseXML.getElementsByTagName("OrderQty");
			document.getElementById('cboColor').innerHTML= "";
			clearSecondGrid();  
			document.getElementById('cboColor').innerHTML = XMLColor[0].childNodes[0].nodeValue;
			document.getElementById('txtOrderQty').value  = XMLOrderQty[0].childNodes[0].nodeValue;
		}
	}		
}
//-----------------------------------------------------
function clearGP(){
document.getElementById('cboGPNo').value="";	
	
}
//-----------load (style & Po when click po or style) & load Grids----------------------------
function loadStylePoNoGrids(styleID)
{
			 loadGrids('');
}


//-----------------------------------
function loadGrids(ArrayCutNos)
{	
	var searchYear=document.getElementById('txtSearchYear').value;
	var searchSerialNo=document.getElementById('txtSerial').value;
	
	if(((searchYear=="") && (searchSerialNo=="")) && (document.getElementById('cboFactory').value.trim()==''))
	{
		return false;
	}
	
		 var styleID=document.getElementById('cboStyle').value;
		 var color=document.getElementById('cboColor').value;
		 var factoryID=document.getElementById("cboFactory").value;
		 var gatePassNo=document.getElementById("cboGPNo").value;
	
		//hem-30/09/2010-----------------
		var url=pub_url+"xml.php";
		url=url+"?RequestType=loadGrids";
		url += '&factoryID='+factoryID;
		url += '&gatePassNo='+gatePassNo;
		url += '&styleID='+styleID;
		url += '&color='+URLEncode(color);
		url += '&searchYear='+searchYear;
		url += '&searchSerialNo='+searchSerialNo;
		url += '&ArrayCutNos='+ArrayCutNos;
		
		var htmlobj=$.ajax({url:url,async:false});
		//-------------------------------
		//alert(htmlobj.responseText); 
		
		
		//Load First Grid---------------------------------------------
		
			//clearFirstGrid();  
			clearSecondGrid();  
			
			var XMLDate = htmlobj.responseXML.getElementsByTagName("Date");
			var XMLCutNo = htmlobj.responseXML.getElementsByTagName("CutNo");
			
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblFirst\" border=\"0\">"+
                                "<tr>"+
                                  "<td width=\"35%\" class=\"grid_header\">Cut No</td>"+
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
			
			if(ArrayCutNos==""){
		//	document.getElementById('divTable1').innerHTML=tableText;  
			}
			
			
		//Load Second Grid---------------------------------------------
		
		/*	var XMLFromFactory = htmlobj.responseXML.getElementsByTagName("FromFactory");
			var XMLGPNumber = htmlobj.responseXML.getElementsByTagName("GPNumber");
			var XMLGPYear = htmlobj.responseXML.getElementsByTagName("GPYear");
			document.getElementById('txtFromFactory').value=XMLFromFactory[0].childNodes[0].nodeValue;
			document.getElementById('txtGpNo').value=XMLGPNumber[0].childNodes[0].nodeValue;
			document.getElementById('txtGPTYear').value=XMLGPYear[0].childNodes[0].nodeValue;*/

			var XMLCutNo1 = htmlobj.responseXML.getElementsByTagName("CutNo1");
			var XMLSize = htmlobj.responseXML.getElementsByTagName("Size");
			var XMLBundle = htmlobj.responseXML.getElementsByTagName("Bundle");
			var XMLRange = htmlobj.responseXML.getElementsByTagName("Range");
			var XMLShade = htmlobj.responseXML.getElementsByTagName("Shade");
			var XMLGPQty = htmlobj.responseXML.getElementsByTagName("GPQty");
			var XMLReceiveQty = htmlobj.responseXML.getElementsByTagName("ReceiveQty");
			var XMLCutBundserial = htmlobj.responseXML.getElementsByTagName("CutBundserial");
			var XMLColor = htmlobj.responseXML.getElementsByTagName("Color");
			var XMLRemarks = htmlobj.responseXML.getElementsByTagName("remarks");
			
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblSecond\" border=\"0\">"+
                                "<tr>"+
                                  "<td width=\"10%\" class=\"grid_header\">Cut No</td>"+
                                  "<td width=\"12%\" height=\"18\" class=\"grid_header\">Size</td>"+
                                  "<td width=\"12%\" class=\"grid_header\">Bundle No</td>"+
                                  "<td width=\"18%\" class=\"grid_header\">Range</td>"+
                                  "<td width=\"12%\" height=\"18\" class=\"grid_header\">Shade</td>"+
                                  "<td width=\"8%\" class=\"grid_header\">Bal Qty</td>"+
                                  "<td width=\"8%\" class=\"grid_header\">Receive Qty</td>"+
                                  "<td width=\"3%\" class=\"grid_header\"><input name=\"chkAllSecond\" type=\"checkbox\" id=\"chkAllSecond\" onclick=\"checkAllTblSecond(this);\" checked=\"checked\"  /></td>"+
                                  "<td width=\"1%\" style=\"display:none\" class=\"grid_header\"></td>"+
                                  "<td width=\"1%\" style=\"display:none\" class=\"grid_header\"></td>"+
								  " <td width=\"12%\" class=\"grid_header\">Remarks</td>"+
								  "</tr>";
								totGatePassQty=0;
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
							" <td class=\"normalfntRite\" align=\"center\" id=\"" + XMLGPQty[loop].childNodes[0].nodeValue + "\" > "+ XMLGPQty[loop].childNodes[0].nodeValue +"&nbsp;</td>"+
							" <td class=\"normalfntMid\" align=\"right\" id=\""+ XMLReceiveQty[loop].childNodes[0].nodeValue+"\" ><input type=\"text\"  id=\"" + loop + "\" name=\"" + loop + "\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" value=\""+ XMLReceiveQty[loop].childNodes[0].nodeValue+"\" onkeypress=\"return isValidZipCode(this.value,event);\" onkeyup=\" compQty(this.name);getTotQty();\" > " +
							"</input></td>" +
							" <td class=\"normalfntMid\" align=\"right\"><input type=\"checkbox\" checked=\"true\" name=\"chkStatus\" id=\"chkStatus\"  onclick=\"checkUncheckTextBox(this);\" /> " +
							"</input></td>" +
							" <td class=\"normalfntMid\" align=\"right\" style=\"display:none\"><input type=\"hidden\" id=\"offset\" name=\"offset\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" value=\""+ XMLCutBundserial[loop].childNodes[0].nodeValue+"\"> " +
							"</input></td>" +
							" <td class=\"normalfntMid\" align=\"right\" style=\"display:none\"><input type=\"hidden\" id=\"offset\" name=\"offset\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" value=\""+ XMLColor[loop].childNodes[0].nodeValue+"\" > " +
							"</input></td>" +
							" <td class=\"normalfntMid\" align=\"left\"><input type=\"text\" class=\"txtbox\" style=\"text-align:left\" size=\"10px\" align =\"right\" value=\""+ XMLRemarks[loop].childNodes[0].nodeValue+"\" maxlength=\"50\"> " +
							" </tr>";
	
			totGatePassQty += parseFloat(XMLReceiveQty[loop].childNodes[0].nodeValue)
							
			 }
			tableText += "</table>";
			var XMLGPQty=htmlobj.responseXML.getElementsByTagName('TotGPQty');
			document.getElementById('divTable2').innerHTML=tableText;  
			document.getElementById('txtTotGpQty').value= totGatePassQty; 
			document.getElementById('txtGpQty').value= XMLGPQty[0].childNodes[0].nodeValue; 
			
document.getElementById("cboFactory").focus();
			
}
//-------------check all cut numbers--------------------------------------------------
function checkAll(obj)
{
	/*var tbl = document.getElementById('tblFirst');
	if(obj.checked)
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[2].childNodes[0].checked = true;
		}
		 loadGrids('')
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[2].childNodes[0].checked = false;
		}
		clearSecondGrid();
	}
	*/
}
//-----clear first grid-----------------------------------------------------
function clearFirstGrid()
{
 document.getElementById('cboPoNo').innerHTML= "";
 document.getElementById('cboStyle').innerHTML = "";
 document.getElementById('cboColor').innerHTML = "";
			
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblSecond\" border=\"0\">"+
                                "<tr>"+
                                  "<td width=\"35%\"  class=\"grid_header\">Cut No</td>"+
                                  "<td width=\"35%\"  class=\"grid_header\">Date</td>"+
                                  "<td width=\"30%\"  class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" /></td>"+
							    "</tr>";
								
			tableText += "</table>";
		//	document.getElementById('divTable1').innerHTML=tableText;  
}
//-----clear second grid-----------------------------------------------------
function clearSecondGrid()
{
			
			/*var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblSecond\" border=\"0\">"+
                                "<tr>"+
                                  "<td width=\"10%\"  class=\"grid_header\">Cut No</td>"+
                                  "<td width=\"12%\"  class=\"grid_header\">Size</td>"+
                                  "<td width=\"12%\"  class=\"grid_header\">Bundle No</td>"+
                                  "<td width=\"18%\"  class=\"grid_header\">Range</td>"+
                                  "<td width=\"12%\"  class=\"grid_header\">Shade</td>"+
                                  "<td width=\"10%\"  class=\"grid_header\">GP Qty</td>"+
                                  "<td width=\"12%\"  class=\"grid_header\">Receive Qty</td>"+
                                  "<td width=\"12%\"  class=\"grid_header\"><input name=\"chkAllSecond\" type=\"checkbox\" id=\"chkAllSecond\" onclick=\"checkAllTblSecond(this);\" /></td>"+
                                  "<td width=\"1%\" style=\"display:none\" class=\"grid_header\"></td>"+
                                  "<td width=\"1%\" style=\"display:none\" class=\"grid_header\"></td>"+
								  "</tr>";
								
			tableText += "</table>";
			document.getElementById('divTable2').innerHTML=tableText;*/  
			$("#tblSecond tr:gt(0)").remove();
}
//-----load clickes cut numbers data-----------------------------------------------------
function loadChkCutGrid(obj)
{
/*	ArrayCutNos="";
	
	var tbl = document.getElementById('tblFirst');
	var chk=0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[2].childNodes[0].checked == true)
		{
			chk++;
		    var cutNo = tbl.rows[loop].cells[0].innerHTML;
			ArrayCutNos += cutNo + ",";
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
	 loadGrids(ArrayCutNos);
	}
	else{
	clearSecondGrid();
	}
	 */
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
//------------------save---------(1)header--------------------------------------------------------
function SaveFinishGoodGPData()
{
	if(ValidateHeaderDets())
	{	
	 showBackGroundBalck();
	
		var fgRcvDate = document.getElementById("txtDate").value;
		var fgRcvYear = document.getElementById("txtYear").value;
		var factory = document.getElementById("cboFactory").value;
		var toFactory = document.getElementById("cboToFactory").value;
		var styleID = document.getElementById("cboPoNo").value;
		var FromFactory = document.getElementById("cboFactory").value;
		var GpNo = document.getElementById("cboGPNo").value;
		var GPTYear = document.getElementById("txtGPTYear").value;
		var remarks = document.getElementById("txtRemarks").value;
		//--if searching---------
		var searchYear=document.getElementById('txtSearchYear').value;
		var searchSerialNo=document.getElementById('txtSerial').value;
		//-----------------------
		
		var Status = 0;
		
		var totQty = 0;
		var totBalQty = 0;

// Saving Event Template Header
	    createNewXMLHttpRequest(3);
    	xmlHttpreq[3].onreadystatechange = HandleSavingHeader;
    	xmlHttpreq[3].open("GET",pub_url+'xml.php?RequestType=SaveFinishGoodReceiveHeader&fgRcvDate=' + fgRcvDate + '&fgRcvYear='+ fgRcvYear + '&factory='+ factory + '&styleID='+ styleID + '&toFactory='+ toFactory + '&FromFactory='+ FromFactory + '&GpNo='+ GpNo + '&GPTYear='+ GPTYear + '&Status='+ Status + '&totQty='+ totQty + '&totBalQty='+ totBalQty + '&searchSerialNo='+ searchSerialNo+ '&searchYear='+ searchYear + '&Remarks='+URLEncode(remarks) , true);
    	xmlHttpreq[3].send(null);
		
		/*noOfRows=0;
		ArrayCutBundleSerial="";
		ArrayBundleNo ="";
		ArrayCutNo ="";
		ArraySize="";
		ArrayRange="";
		ArrayShade="";
		ArrayColor="";
		ArrayQty =0;
		ArrayBalQty = 0;
		ArrRemark = "";
		var tbl = document.getElementById('tblSecond');
		noOfRows=tbl.rows.length-1;
	*/
		/*for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
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
				var Color = tbl.rows[loop].cells[9].childNodes[0].value;
				var remarks =  tbl.rows[loop].cells[10].childNodes[0].value;
				
				if(RecvQty==""){
				 RecvQty=0;
				}
				if(Qty==""){
				 Qty=0;
				}
				var BalQty =  Qty-RecvQty;
	

				if (factory.length > 0)
				{
						ArrayCutBundleSerial += CutBundleSerial + "<*>";
						ArrayBundleNo += BundleNo + "<*>";
						ArrayQty += RecvQty + "<*>";
						ArrayBalQty += BalQty + "<*>";
						ArrayCutNo += CutNo + "<*>";
						ArraySize += Size + "<*>";
						ArrayRange += Range + "<*>";
						ArrayShade += Shade + "<*>";
						ArrayColor += Color + "<*>";
						ArrRemark += remarks + "<*>";
				 }
			}

		}*/
	}
}
//----------------------------
function HandleSavingHeader()
{
	if(xmlHttpreq[3].readyState == 4) 
    {
        if(xmlHttpreq[3].status == 200) 
        {
			//	alert(xmlHttpreq[3].responseText);
 
			var XMLOutput = xmlHttpreq[3].responseXML.getElementsByTagName("Save");
			var XMLTrsfInNo = xmlHttpreq[3].responseXML.getElementsByTagName("fgRcvTrsfInNo");
			if(XMLOutput[0].childNodes[0].nodeValue == "True")
			{
				var fgRcvTrsfInNo = XMLTrsfInNo[0].childNodes[0].nodeValue;
				var year = document.getElementById("txtYear").value;
		        var factory = document.getElementById("cboFactory").value;
		        var gpNo = document.getElementById("cboGPNo").value;
				var styleId = document.getElementById('cboPoNo').value;
				var tbl = document.getElementById('tblSecond');
				//rCount=0;
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
			{
				if(tbl.rows[loop].cells[6].childNodes[0].value!=0 && tbl.rows[loop].cells[7].childNodes[0].checked==true ){
					rCount++;
				}
			}
			rChk=rCount;
		noOfRows=tbl.rows.length-1;
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[6].childNodes[0].value!=0 && tbl.rows[loop].cells[7].childNodes[0].checked==true)
			{
				var CutBundleSerial = tbl.rows[loop].cells[8].childNodes[0].value;
				var BundleNo =  tbl.rows[loop].cells[2].innerHTML;
				var Qty = tbl.rows[loop].cells[5].innerHTML.trim();
				var RecvQty = tbl.rows[loop].cells[6].childNodes[0].value;
				var CutNo =  tbl.rows[loop].cells[0].innerHTML;
				var Size =  tbl.rows[loop].cells[1].innerHTML;
				var Range =  tbl.rows[loop].cells[3].innerHTML;
				var Shade =  tbl.rows[loop].cells[4].innerHTML;
				var Color = tbl.rows[loop].cells[9].childNodes[0].value;
				var remarks =  tbl.rows[loop].cells[10].childNodes[0].value;
				
			
				if(RecvQty==""){
				 RecvQty=0;
				}
				if(Qty==""){
				 Qty=0;
				}
				var BalQty =  Qty-RecvQty;
				//alert(factory.length)
				/*if (factory.length > 0)
				{*/
					
						ArrayCutBundleSerial = CutBundleSerial ;
						ArrayBundleNo = BundleNo ;
						ArrayQty = RecvQty ;
						ArrayBalQty = BalQty ;
						ArrayCutNo = CutNo;
						ArraySize = Size;
						ArrayRange = Range;
						ArrayShade = Shade;
						ArrayColor = Color;
						ArrRemark = remarks;
				// }
				 rChk--;
				SaveOutputDetails(factory,fgRcvTrsfInNo,year,ArrayCutBundleSerial,ArrayBundleNo,ArrayQty,ArrayBalQty,ArrayCutNo,ArraySize,ArrayRange,ArrayShade,ArrayColor,noOfRows,gpNo,ArrRemark,styleId,rChk);
			
			}

		}
				
			}
			else
			{
				alert("The Finish Goods Receive save failed.");	
//				document.getElementById('txtevent').focus();
			}
		}		
	}
}
//--------------------------(2)Save details-------------------------------------------------------------------------------
function SaveOutputDetails(factory,fgRcvTrsfInNo,year,ArrayCutBundleSerial,ArrayBundleNo,ArrayQty,ArrayBalQty,ArrayCutNo,ArraySize,ArrayRange,ArrayShade,ArrayColor,noOfRows,gpNo,ArrRemark,styleId,rChk)
{
	// Saving Event Template Details

	var path=pub_url+'xml.php?RequestType=SaveFinishGoodReceiveDetails&fgRcvTrsfInNo=' + fgRcvTrsfInNo + '&year='+ year+ '&ArrayCutBundleSerial='+ ArrayCutBundleSerial + '&ArrayBundleNo='+ ArrayBundleNo + '&ArrayQty='+ ArrayQty + '&ArrayBalQty='+ ArrayBalQty + '&ArrayCutNo='+ URLEncode(ArrayCutNo) + '&ArraySize='+ URLEncode(ArraySize) + '&ArrayRange='+ ArrayRange + '&ArrayShade='+ ArrayShade + '&ArrayColor='+ URLEncode(ArrayColor) + '&noOfRows='+ noOfRows + '&factory='+ factory + '&gpNo='+ gpNo+'&ArrRemark='+URLEncode(ArrRemark)+ '&StyleId=' +styleId+'&rCount='+rChk;
	htmlobj=$.ajax({url:path,async:false});
	
	
			var searchYear=document.getElementById('txtSearchYear').value;
			var searchSerialNo=document.getElementById('txtSerial').value;
			
			 var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
			
			if(XMLResult[0].childNodes[0].nodeValue == "True")
			{
				rCount=rCount-1;
				//rChk=rChk-1;
				if(rCount==0){
					hideBackGroundBalck();
					alert("The details saved successfully.");
					
					document.getElementById('txtSearchYear').value=year;
					document.getElementById('txtSerial').value=fgRcvTrsfInNo;
			
					document.getElementById('butSave').style.display='none';
					document.getElementById('butRpt').style.display='inline';
					loadReport()
					
					
					if((searchYear=="") && (searchSerialNo=="")){
					//document.frmProductionFinishGoodRecieved.reset();
					//clearFirstGrid()
					//clearSecondGrid();
					//document.getElementById('cboFactory').value = ""	
					//document.getElementById('txtDate').value = ""		
					//document.frmProductionFinishGoodRecieved.reset();
					//document.getElementById('cboPoNo').innerHTML="";  
					//document.getElementById('cboStyle').innerHTML="";  
					}
					else{
						loadInputFrom(searchYear,searchSerialNo);
					}
				}
			}
			else{
				alert("The details saved fail.");
			}
}
//Report

function loadReport(){
	var serial=document.getElementById('txtSerial').value.trim();
	var year=document.getElementById('txtSearchYear').value.trim();
	window.open("rptFinishGoodsReceive.php?SerialNumber="+serial+"&intYear="+year+"&id=1",'New')
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
			var searchSerialNo=document.getElementById('txtSerial').value;
			
			 var XMLResult = xmlHttpreq[4].responseXML.getElementsByTagName("SaveDetail");
			
			if(XMLResult[0].childNodes[0].nodeValue == "True")
			{
				
				hideBackGroundBalck();
				alert("The details saved successfully.");
				
				if((searchYear=="") && (searchSerialNo=="")){
				document.frmProductionFinishGoodRecieved.reset();
				clearFirstGrid()
				clearSecondGrid();
				//document.getElementById('cboFactory').value = ""	
				//document.getElementById('txtDate').value = ""		
				document.frmProductionFinishGoodRecieved.reset();
				document.getElementById('cboPoNo').innerHTML="";  
				document.getElementById('cboStyle').innerHTML="";  
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
//	alert(rows);
	
	if (document.getElementById('cboFactory').value == "" )	
	{
		alert("Please select a \"From Factory\". ");
		document.getElementById('cboFactory').focus();
		return false;
	}
	if (document.getElementById('cboToFactory').value == "" )	
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
		document.getElementById('cboFactory').focus();
		return false;
	}
	else if (recvCount<=0)	
	{
		alert("There is no any \"Recieved Qty\" to save. ");
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
	totOutputQty=0;
	
	var tbl = document.getElementById('tblSecond');
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
		//	if(tbl.rows[loop].cells[7].childNodes[0].checked == true){
			if(tbl.rows[loop].cells[6].childNodes[0].value!="")
				totOutputQty += parseFloat(tbl.rows[loop].cells[6].childNodes[0].value);
			else
				tbl.rows[loop].cells[6].childNodes[0].value=0;
		   
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
	var searchSerialNo=document.getElementById('txtSerial').value;
		if((searchYear=="") && (searchSerialNo=="")){
			//recvQty +=parseFloat(tbl.rows[loop].cells[6].id)	
		}
		else{
			var recvQty=parseFloat(tbl.rows[loop].cells[5].id.trim());
			//alert(inputQty);
		}
		
		var GpQty=parseInt(document.getElementById('txtGpQty').value);
		var Ch=(parseInt(document.getElementById('txtTotGpQty').value)+(inputQty-recvQty));
		var Ch2= GpQty+ parseInt(Math.ceil((GpQty/100)*5));
		if( Ch > Ch2 ){
					alert("Input Qty is less than or equal to Excess percentage 5%");	
					tbl.rows[loop].cells[6].childNodes[0].value=inputQty-(Ch-Ch2); 
					return false;
				}
				
		
		if(inputQty > Math.ceil(recvQty+(GpQty/100)*5) ){
		alert("Invalid Input Qty");		
		tbl.rows[loop].cells[6].childNodes[0].value=recvQty;
		return false;
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
			// tbl.rows[loop].cells[10].childNodes[0].value = 0;
		}
	}
			getTotQty();
}
//----onload function--------------------------------------------------------------------------
function loadInputFrom(year,serialNo)
{
	document.getElementById('txtSearchYear').value=year;
	document.getElementById('txtSerial').value=serialNo;

	//hem-30/09/2010-----------------
	var url=pub_url+"xml.php";
	url=url+"?RequestType=LoadHeaderToSerial";
	url += '&serialNo='+serialNo;
	url += '&year='+year;
	
	var htmlobj=$.ajax({url:url,async:false});

	var XMLfromFactory = htmlobj.responseXML.getElementsByTagName("fromFactory");
	document.getElementById('cboFactory').value = XMLfromFactory[0].childNodes[0].nodeValue;
	
	var XMLtoFactory = htmlobj.responseXML.getElementsByTagName("toFactory");
	document.getElementById('cboToFactory').value = XMLtoFactory[0].childNodes[0].nodeValue;
	
	document.getElementById('cboFactory').disabled = true;
	document.getElementById('cboToFactory').disabled = true;
	
	var XMLStyle = htmlobj.responseXML.getElementsByTagName("style");
	document.getElementById('cboStyle').innerHTML = XMLStyle[0].childNodes[0].nodeValue;
	
	var XMLPoNo = htmlobj.responseXML.getElementsByTagName("PoNo");
	document.getElementById('cboPoNo').innerHTML = XMLPoNo[0].childNodes[0].nodeValue;
	
	var XMLColor = htmlobj.responseXML.getElementsByTagName("color");
	document.getElementById('cboColor').innerHTML = XMLColor[0].childNodes[0].nodeValue;
	
	var XMLCutNo = htmlobj.responseXML.getElementsByTagName("cutNo");
	// document.getElementById('cboCutNo').innerHTML = XMLCutNo[0].childNodes[0].nodeValue;
	
	var XMLDate = htmlobj.responseXML.getElementsByTagName("date");
	document.getElementById('txtDate').value = XMLDate[0].childNodes[0].nodeValue; 
	
	var XMLgpNo = htmlobj.responseXML.getElementsByTagName("gpNo");
	var XMLgpYear = htmlobj.responseXML.getElementsByTagName("gpYear");
	
	document.getElementById('cboGPNo').value = XMLgpYear[0].childNodes[0].nodeValue+'/'+XMLgpNo[0].childNodes[0].nodeValue; 
	document.getElementById('cboGPNo').disabled = true;
	 
	var XMLRemarks = htmlobj.responseXML.getElementsByTagName("Remarks");
	document.getElementById('txtRemarks').value = XMLRemarks[0].childNodes[0].nodeValue; 
	
	var XMLOrderQty =  htmlobj.responseXML.getElementsByTagName("OrderQty");
	document.getElementById('txtOrderQty').value = XMLOrderQty[0].childNodes[0].nodeValue; 
	
	loadGrids('');
	disableFields();
	}

function ClearForm()
{
	document.frmProductionFinishGoodRecieved.reset();	
	document.getElementById('txtSerial').value= "";
	document.getElementById('txtSearchYear').value = "";	
	//document.getElementById('cboFactory').disabled = false; // User should not change the combo this combo will fill when user select the GatePass
	//document.getElementById('cboToFactory').disabled = false;	//User should not change this combo.This combo will fill using session factory
	document.getElementById('cboPoNo').innerHTML= "";
	document.getElementById('cboStyle').innerHTML = "";
	document.getElementById('cboColor').innerHTML = "";	
	clearSecondGrid(); 	
	document.getElementById("cboGPNo").focus();
	document.getElementById('cboGPNo').disabled = false;
	document.getElementById('cboPoNo').disabled = false;
	document.getElementById('cboStyle').disabled = false;
	document.getElementById('cboColor').disabled = false;
	
	document.getElementById('butSave').style.display='inline';
	document.getElementById('butRpt').style.display='none';
}

function disableFields()
{
	document.getElementById('cboGPNo').disabled = true;
	document.getElementById('cboFactory').disabled = true;
	document.getElementById('cboToFactory').disabled = true;
	document.getElementById('cboPoNo').disabled = true;
	document.getElementById('cboStyle').disabled = true;
	document.getElementById('cboColor').disabled = true;
}

function checkDecimals(obj){
	var d=obj.value.trim();	
	if(d.indexOf('.') > -1){
		//var c=d.charAt(d.indexOf('.'));
		obj.value=d.replace(/\./g,' ');
		obj.value=obj.value.trim();
	}
}