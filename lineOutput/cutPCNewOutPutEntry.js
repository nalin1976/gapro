var xmlHttpreq = [];
var pub_loutPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_url = pub_loutPath+"/production/lineOutput/";
var totOutputQty=0;
var ArrRemark="";
var pub_styleId	= "";
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

function loadLineNo()
{
	var factoryID=document.getElementById("cboFactory").value;
	var PoNo=document.getElementById("cboPoNo").value;
	var url = pub_url+'xml.php?RequestType=loadLineNo&factoryID='+ factoryID+'&PoNo='+ PoNo;
	var htmlobj = $.ajax({url:url,async:false});
	HandleLineNo(htmlobj);
}

function HandleLineNo(xmlHttp)
{
	document.getElementById('cboLineNo').innerHTML	 = "";
	document.getElementById('cboStartDate').value	 = "";
	document.getElementById('cboCutNo').innerHTML	 = "";
	document.getElementById('cboBundleNo').innerHTML = "";
	clearTable();	
	
	document.getElementById('cboLineNo').innerHTML 	 = xmlHttp.responseText;
	document.getElementById('cboLineNo').focus();
}

function loadPONo()
{

	var factoryID=document.getElementById("cboFactory").value;
//	var lineNo=document.getElementById("cboLineNo").value;
//	var cutNo=document.getElementById("cboCutNo").value;
	createNewXMLHttpRequest(2);
	xmlHttpreq[2].onreadystatechange = HandlePoNo ;

	xmlHttpreq[2].open("GET",pub_url+'xml.php?RequestType=loadPoNo&factoryID='+ factoryID, true);
	xmlHttpreq[2].send(null);
}

//----------------------------
function HandlePoNo()
{
	if(xmlHttpreq[2].readyState == 4) 
	{
		if(xmlHttpreq[2].status == 200) 
		{
			//alert(xmlHttpreq[2].responseText);
			 document.getElementById('cboPoNo').innerHTML= "";
			 document.getElementById('cboLineNo').innerHTML= "";
			 document.getElementById('cboStartDate').value= "";
			 document.getElementById('cboCutNo').innerHTML= "";
			 document.getElementById('cboBundleNo').innerHTML= "";
			 
			 clearTable();	
			
			if(document.getElementById("cboFactory").value!=''){
			 var XMLPoNo = xmlHttpreq[2].responseXML.getElementsByTagName("PoNo");
			 var XMLPatternNo = xmlHttpreq[2].responseXML.getElementsByTagName("PatternNo");
			 document.getElementById('cboPoNo').innerHTML= XMLPoNo[0].childNodes[0].nodeValue;
			 document.getElementById('txtPattern').value= XMLPatternNo[0].childNodes[0].nodeValue;
			 document.getElementById('cboPoNo').focus();
			}

		}
	}		
}
//----------Load Cut No--------------------------------------------------------------------------------------
function loadCutNo()
{
	var factoryID	= document.getElementById("cboFactory").value;
	var lineNo		= document.getElementById("cboLineNo").value;
	var PoNo		= document.getElementById("cboPoNo").value;

	var url = pub_url+'xml.php?RequestType=loadCutNo&factoryID='+ factoryID + '&lineNo='+ lineNo + '&PoNo='+ PoNo;
	var htmlobj = $.ajax({url:url,async:false});
	HandleCutNo(htmlobj);
	
	if(PoNo!="")
		loadBundleNo()
}

//----------------------------
function HandleCutNo(xmlHttp)
{
	document.getElementById('cboStartDate').value= "";
	document.getElementById('cboCutNo').innerHTML= "";
	document.getElementById('cboBundleNo').innerHTML= "";
	clearTable();	
	
	if(document.getElementById("cboLineNo").value!='')
	{
		var XMLCutNo 	 = xmlHttp.responseXML.getElementsByTagName("cutNo");
		var XMLStartDate = xmlHttp.responseXML.getElementsByTagName("StartDate");
		document.getElementById('cboCutNo').innerHTML = XMLCutNo[0].childNodes[0].nodeValue;
		document.getElementById('cboStartDate').value = XMLStartDate[0].childNodes[0].nodeValue;
		document.getElementById('cboCutNo').focus();
	}
}
//----------Load Bundle No---------------------------------------------------------------------------------
function loadBundleNo()
{

	var factoryID=document.getElementById("cboFactory").value;
	var lineNo=document.getElementById("cboLineNo").value;
	var cutNo=document.getElementById("cboCutNo").value;
	var PoNo=document.getElementById("cboPoNo").value;

	var url = pub_url+'xml.php?RequestType=loadBundleNo&factoryID='+ factoryID + '&lineNo='+ lineNo + '&cutNo='+ cutNo + '&PoNo='+ PoNo;
	var htmlobj = $.ajax({url:url,async:false});
	HandleBundleNo(htmlobj);
}

function HandleBundleNo(xmlHttp)
{
	document.getElementById('cboBundleNo').innerHTML= "";
	var cutNo=document.getElementById("cboCutNo").value;
	//if(cutNo!=""){
		var XMLBundleNo = xmlHttp.responseXML.getElementsByTagName("BundleNo");
		document.getElementById('cboBundleNo').innerHTML= XMLBundleNo[0].childNodes[0].nodeValue;
		document.getElementById('cboBundleNo').focus();
	//}
	LoadGrid();
}
//----------Load Grid--------------------------------------------------------------------------------------
function LoadGrid()
{
	xmlHttp2=GetXmlHttpObject();
	if (xmlHttp2==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	
	
	//if searching.....
	var searchYear=document.getElementById('txtSearchLineOutYear').value;
	var searchOutputNo=document.getElementById('txtSearchLineOutNo').value;
	
	if(((searchYear=="") && (searchOutputNo=="")) && (document.getElementById('cboFactory').value.trim()==''))
	{
	//	clearFields();
		return false;
		//setTimeout("location.reload(true);",0);
	}
	
	

	//-------------
	
	var factoryID=document.getElementById("cboFactory").value;
	var lineNo=document.getElementById("cboLineNo").value;
	var cutNo=document.getElementById("cboCutNo").value;
	var PoNo=document.getElementById("cboPoNo").value;
	var bundleNo = document.getElementById("cboBundleNo").value;
	
	createNewXMLHttpRequest(4);
	xmlHttpreq[4].onreadystatechange = HandleLoadGrid ;
	xmlHttpreq[4].open("GET",pub_url+'xml.php?RequestType=LoadGrid&factoryID='+ factoryID + '&lineNo='+ lineNo + '&cutNo='+ cutNo + '&PoNo='+ PoNo + '&bundleNo='+ bundleNo + '&searchYear='+ searchYear + '&searchOutputNo='+ searchOutputNo ,true);
	xmlHttpreq[4].send(null);
}
//------------------------------------
function HandleLoadGrid()
{
	if(xmlHttpreq[4].readyState == 4) 
    {
        if(xmlHttpreq[4].status == 200) 
        { 
	//	alert(xmlHttpreq[4].responseText);
			

			var XMLSize = xmlHttpreq[4].responseXML.getElementsByTagName("Size");
			var XMLCutBundserial = xmlHttpreq[4].responseXML.getElementsByTagName("CutBundserial");
			var XMLCutNo = xmlHttpreq[4].responseXML.getElementsByTagName("cutNo");
			var XMLBundlNo = xmlHttpreq[4].responseXML.getElementsByTagName("BundlNo");
			var XMLRange = xmlHttpreq[4].responseXML.getElementsByTagName("Range");
			var XMLShade = xmlHttpreq[4].responseXML.getElementsByTagName("Shade");
			var XMLInput = xmlHttpreq[4].responseXML.getElementsByTagName("Input");
			var XMLOutput = xmlHttpreq[4].responseXML.getElementsByTagName("OutPut");
			var XMLRemark = xmlHttpreq[4].responseXML.getElementsByTagName("Remarks");
			
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblevents\" border=\"0\">"+
                                "<tr>"+
                                  "<td width=\"12%\" height=\"25\" class=\"grid_header\">Cut No</td>"+
                                  "<td width=\"12%\"class=\"grid_header\">Size No</td>"+
                                  "<td width=\"12%\" class=\"grid_header\">Bundle No</td>"+
                                  "<td width=\"16%\" class=\"grid_header\">Range</td>"+
                                  "<td width=\"12%\" class=\"grid_header\">Shade</td>"+
                                  "<td width=\"8%\" class=\"grid_header\">Bal Qty</td>"+
                                  "<td width=\"8%\" class=\"grid_header\">Output</td>"+
                                  "<td width=\"5%\" class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" checked=\"checked\"  /></td>"+
                                  "<td width=\"1%\" class=\"grid_header\" style=\"display:none\"></td>"+
								  "<td width=\"14%\" class=\"grid_header\">Remark</td>"+
								  "</tr>";
			
			totOutputQty=0;
			 for ( var loop = 0; loop < XMLSize.length; loop ++)
			 {
				if((loop%2)==0){
				var rowClass="grid_raw"	
				}
				else{
				var rowClass="grid_raw2"	
				}
				
				tableText +=" <tr class=\"" + rowClass + "\">" +
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLCutNo[loop].childNodes[0].nodeValue + "\" > "+ XMLCutNo[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLSize[loop].childNodes[0].nodeValue + "\" > "+ XMLSize[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLBundlNo[loop].childNodes[0].nodeValue + "\" > "+ XMLBundlNo[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLRange[loop].childNodes[0].nodeValue + "\" > "+ XMLRange[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLShade[loop].childNodes[0].nodeValue + "\" > "+ XMLShade[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntRite\" id=\"" + XMLInput[loop].childNodes[0].nodeValue + "\" > "+ XMLInput[loop].childNodes[0].nodeValue +"&nbsp;</td>"+
							" <td class=\"normalfntRite\" align=\"right\" id=\"" + XMLOutput[loop].childNodes[0].nodeValue + "\"><input type=\"text\" id=\"" + loop + "\" name=\"" + loop + "\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" onkeypress=\"return isNumberKey(event);\" onkeyup=\" getTotQty();compQty(this.name);\" value=\""+ XMLOutput[loop].childNodes[0].nodeValue+"\"> " +
							"</input></td>" +
							" <td class=\"normalfntMid\" align=\"right\"><input type=\"checkbox\" checked=\"true\" name=\"chkStatus\" id=\"chkStatus\"  onclick=\"checkUncheckTextBox(this);\" /> " +
							"</input></td>" +
							" <td class=\"normalfntMid\" align=\"right\" style=\"display:none\"><input type=\"hidden\" id=\"offset\" name=\"offset\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" value=\""+ XMLCutBundserial[loop].childNodes[0].nodeValue+"\"> " +
							"</input></td>" +
							" <td class=\"normalfntRite\" align=\"right\"><input type=\"text\" id=\"" + loop + "\" name=\"" + loop + "\" class=\"txtbox\" style=\"text-align:left\" size=\"10px\" align =\"left\" value=\""+ XMLRemark[loop].childNodes[0].nodeValue+"\"> " +
							" </tr>";
							
			 }
			tableText += "</table>";
		//	alert(tableText)
			document.getElementById('divcons').innerHTML=tableText;  
			document.getElementById('txtBundles').value= XMLSize.length;  
			getTotQty()
			}		
	}
}
//--------------12-05-2011---hem-----------------------
function SaveOutputData()
{
	if(ValidateHeaderDets())
	{	
		showBackGroundBalck();
		pub_styleId		= document.getElementById('cboPoNo').value
		var OutputDate 	= document.getElementById("txtDate").value;
		var StartDate 	= document.getElementById("cboStartDate").value;
		var factory 	= document.getElementById("cboFactory").value;
		var OutputYear 	= document.getElementById("txtYear").value;
		var styleID 	= document.getElementById("cboPoNo").value;
		var teamID		= document.getElementById("cboLineNo").value;
		var pattern 	= document.getElementById("txtPattern").value;
		var Status 		= 0;
		
		var SelectOption=document.frmProductionOutput.cboCutNo;
		var SelectedIndex=SelectOption.selectedIndex;
		var SelectedValue=SelectOption.value;
		var SelectedText=SelectOption.options[SelectOption.selectedIndex].text;	
		var cutNo = SelectedText;
		
		if(document.getElementById("cboCutNo").value==""){
		cutNo="";	
		}
		
		var totQty = 0;
		var totBalQty = 0;
		
		//--if searching---------
		var searchYear=document.getElementById('txtSearchLineOutYear').value;
		var searchOutputNo=document.getElementById('txtSearchLineOutNo').value;
		//-----------------------

		var url = 'xml.php?RequestType=SaveLineOutputHeader&OutputDate=' + OutputDate + '&factory='+ factory + '&OutputYear='+ OutputYear + '&styleID='+ styleID + '&teamID='+ teamID + '&pattern='+ pattern + '&cutNo='+ cutNo + '&totQty='+ totQty+ '&totBalQty='+ totBalQty+ '&Status='+ Status+ '&searchYear='+ searchYear+ '&searchOutputNo='+ searchOutputNo;
		htmlobj=$.ajax({url:url,async:false});
		HandleSavingHeader(htmlobj);
		
		
	}
}
//-------------------------------------------
function HandleSavingHeader(htmlobj)
{
	var XMLOutput = htmlobj.responseXML.getElementsByTagName("Save");
	var XMLOutputserial = htmlobj.responseXML.getElementsByTagName("Outputserial");
	var XMLOutputyear = htmlobj.responseXML.getElementsByTagName("OutputYear");
	if(XMLOutput[0].childNodes[0].nodeValue == "True"){

		var lineOutputSerial = XMLOutputserial[0].childNodes[0].nodeValue;
		var year = XMLOutputyear[0].childNodes[0].nodeValue;
		var factory = document.getElementById("cboFactory").value;

		var tbl = document.getElementById('tblevents');
		var CutBundleSerial = "";
		var BundleNo =  "";
		var Qty = "";
		var RecvQty = "";
		var remarks =""; 
		var BalQty = "";
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
				remarks =tbl.rows[loop].cells[9].childNodes[0].value; 
				if(RecvQty==""){
				 RecvQty=0;
				}
				if(Qty==""){
				 Qty=0;
				}
				BalQty =  Qty-RecvQty;
	
				var url = 'xml.php?RequestType=SaveLineOutputDetails&lineOutputSerial=' + lineOutputSerial + '&CutBundleSerial='+ CutBundleSerial+ '&year='+ year + '&BundleNo='+ BundleNo + '&Qty='+ RecvQty + '&BalQty='+ BalQty + '&factory='+ factory +'&remarks='+remarks;
				htmlobj=$.ajax({url:url,async:false});
				
				var XMLResult = htmlobj.responseXML.getElementsByTagName("result");
				if(XMLResult[0].childNodes[0].nodeValue==1){
				savedRcds++;	
				}
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
		alert("The event CutPc Transfer header save failed.");	
//				document.getElementById('txtevent').focus();
	}
}
//-----------------------------------------------
function HandleSavingDetails(saved,htmlobj)
{
		var year=document.getElementById('txtSearchLineOutYear').value;
		var serialNo=document.getElementById('txtSearchLineOutNo').value;				
	
	if(saved== 1)
	{
		hideBackGroundBalck();
		alert("Saved successfully.");
		
		if((year=="") && (serialNo==""))
		{
			document.frmProductionOutput.reset();
			clearTable();	
			document.getElementById('cboPoNo').value = pub_styleId;
		}
		else{
		loadInputFrom(year,serialNo);
		}
	}
	else{
		alert("Saving error.");
	}
}

function ClearForm()
{
	pub_styleId	= "";
	document.frmProductionOutput.reset();
	clearTable();	
	document.getElementById("cboFactory").focus();
}
//----clear table------------------------------------------------------------------------
function clearTable()
{
	$("#tblevents tr:gt(0)").remove();
}
//---------Validate form----------------------------------------------------------------------
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
		alert("Please select 'Factory'.");
		document.getElementById('cboFactory').focus();
		return false;
	}
	else if (document.getElementById('cboPoNo').value == "" )	
	{
		alert("Please select 'Order No'.");
		document.getElementById('cboPoNo').focus();
		return false;
	}
	else if (document.getElementById('cboLineNo').value == "" )	
	{
		alert("Please select 'Line No'.");
		document.getElementById('cboLineNo').focus();
		return false;
	}
	
	else if (document.getElementById('txtDate').value == "" )	
	{
		alert("Please select 'Date'.");
		document.getElementById('txtDate').focus();
		return false;
	}
	else if (document.getElementById('cboStartDate').value == "" )	
	{
		alert("Please select the 'Start Date'.");
		document.getElementById('cboStartDate').focus();
		return false;
	}
	else if (rows<1)	
	{
		alert("There are no details for selected criteria.");
		document.getElementById('cboFactory').focus();
		return false;
	}
	else if (recvCount<=0)	
	{
		alert("There is no any 'Output Qty' to save. ");
		return false;
	}
	else{

		return true;
	}

}
//--------calculate total output Quantity--------------------------------------------------------------
function getTotQty()
{
	totOutputQty=0;
	var bundles=0;
	var tbl = document.getElementById('tblevents');
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[7].childNodes[0].checked == true){
		    totOutputQty += parseFloat(tbl.rows[loop].cells[6].childNodes[0].value);
			bundles++;
			}
		}
	document.getElementById('txtTotOutQty').value= totOutputQty; 
	document.getElementById('txtBundles').value= bundles;  
	
}
//------check whether the output Qty is greater than input Qty----------------------
function compQty(loop)
{
var tbl = document.getElementById('tblevents');
loop=parseFloat(loop)+1;
var OutputQty =parseFloat(tbl.rows[loop].cells[6].childNodes[0].value);
var InputQty=parseFloat(tbl.rows[loop].cells[5].innerHTML.trim());

year=document.getElementById('txtSearchLineOutYear').value;
serialNo=document.getElementById('txtSearchLineOutNo').value;				
if((year!="") && (serialNo!="")){
	InputQty +=parseFloat(tbl.rows[loop].cells[6].id)	
}

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
		if(chk==tbl.rows.length-1){
		document.getElementById('chkCheckAll').checked=true;	
		}
		else{
		document.getElementById('chkCheckAll').checked=false;	
		}
getTotQty();
}
//------check Uncheck all records-----------------------------------------------------------------------
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
	document.getElementById('txtTotOutQty').value= 0;  
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
		    tbl.rows[loop].cells[6].childNodes[0].value = 0;
			tbl.rows[loop].cells[7].childNodes[0].checked = false;
			tbl.rows[loop].cells[9].childNodes[0].value = '';
		}
	}
			getTotQty();
}
//-----check uncheck a record--------------------------------------------------------------------------------
function checkUncheckTextBox(objevent)
{
	var tbl = document.getElementById('tblevents');
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
		document.getElementById('chkCheckAll').checked=true;	
		}
		else{
		document.getElementById('chkCheckAll').checked=false;	
		}
		
			getTotQty();

}
//--------------------------------------------------------------------------------------
function loadInputFrom(year,serialNo)
	{
	document.getElementById('txtSearchLineOutYear').value=year;
	document.getElementById('txtSearchLineOutNo').value=serialNo;
	createNewXMLHttpRequest(7);
	xmlHttpreq[7].onreadystatechange = LoadHeaderToSerial;
	xmlHttpreq[7].open("GET",pub_url+'xml.php?RequestType=LoadHeaderToSerial&serialNo='+ serialNo + '&year='+ year ,true);
	xmlHttpreq[7].send(null);
	LoadGrid();
	disableFields();
	}
//-------------------------------------------------------------------------------------------------------------
function LoadHeaderToSerial()
	{
		//alert("fgdf");
		if(xmlHttpreq[7].readyState == 4) 
		{
			if(xmlHttpreq[7].status == 200) 
			{	
		//	alert(xmlHttpreq[7].responseText);
			
		         var XMLFactory = xmlHttpreq[7].responseXML.getElementsByTagName("factory");
			     document.getElementById('cboFactory').value = XMLFactory[0].childNodes[0].nodeValue;
				 
			     document.getElementById('cboFactory').disabled = true;
				 
		         var XMLLineNo = xmlHttpreq[7].responseXML.getElementsByTagName("lineNo");
			     document.getElementById('cboLineNo').innerHTML = XMLLineNo[0].childNodes[0].nodeValue;
				 
		         var XMLPoNo = xmlHttpreq[7].responseXML.getElementsByTagName("PoNo");
			     document.getElementById('cboPoNo').innerHTML = XMLPoNo[0].childNodes[0].nodeValue;
				 
		         var XMLCutNo = xmlHttpreq[7].responseXML.getElementsByTagName("cutNo");
			     document.getElementById('cboCutNo').innerHTML = XMLCutNo[0].childNodes[0].nodeValue;
				 
		         var XMLBundleNo = xmlHttpreq[7].responseXML.getElementsByTagName("bundleNo");
			     document.getElementById('cboBundleNo').innerHTML = XMLBundleNo[0].childNodes[0].nodeValue;
				 
		         var XMLDate = xmlHttpreq[7].responseXML.getElementsByTagName("date");
			     document.getElementById('txtDate').value = XMLDate[0].childNodes[0].nodeValue;
				 
		         var XMLStart = xmlHttpreq[7].responseXML.getElementsByTagName("start");
			     document.getElementById('cboStartDate').value = XMLStart[0].childNodes[0].nodeValue;
				 
			}
		}
	}
//----------------------------------------------------------------------------------------------------------------
function clearform()
{
	showBackGround('divBG',0);
	document.frmProductionOutput.reset();
	document.getElementById('txtSearchLineOutYear').value = "";
	document.getElementById('txtSearchLineOutNo').value = "";
	document.getElementById('cboCutNo').innerHTML = "";
	document.getElementById('cboBundleNo').innerHTML = "";
	document.getElementById('cboPoNo').focus();
	document.getElementById('cboLineNo').disabled = false;
	document.getElementById('cboPoNo').disabled = false;
	document.getElementById('cboStartDate').disabled = false;
	document.getElementById('cboCutNo').disabled = false;
	document.getElementById('cboBundleNo').disabled = false;
	LoadOrders();
	hideBackGround('divBG');
}

function disableFields(){
	 document.getElementById('cboFactory').disabled = true;
	 document.getElementById('cboLineNo').disabled = true;
	 document.getElementById('cboPoNo').disabled = true;
	 document.getElementById('cboStartDate').disabled = true;
	 document.getElementById('cboCutNo').disabled = true;
	document.getElementById('cboBundleNo').disabled = true;
}

function LoadOrders()
{
	var url = 'xml.php?RequestType=URLLoadOrders';
	var htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboPoNo').innerHTML = htmlobj.responseText;
}