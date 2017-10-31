var pub_date_from='';
var pub_date_to='';

var xmlHttpreq = [];
var xmlHttp;
var xmlHttp1;
var xmlHttp2;
var xmlHttp3;
var xmlHttp4;

var ArrayCutBundleSerial="";
var ArrayBundleNo="";
var ArrayQty ="";
var ArrayBalQty ="";
var noOfRows=0;
var totInputQty=0;
var ArrRemarks ="";
var pub_url = "/gapro/production/lineInput/";
var pub_styleId	= "";
//-----------------------------------------------------------
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


function createXMLHttpRequest() 
{

    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}
//------
function createXMLHttpRequest1() 
{

    if (window.ActiveXObject) 
    {
        xmlHttp1 = new ActiveXObject("Microsoft.XMLHTTP");
		
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp1 = new XMLHttpRequest();
    }
}
//------

function createXMLHttpRequest2() 
{

    if (window.ActiveXObject) 
    {
        xmlHttp2 = new ActiveXObject("Microsoft.XMLHTTP");
		
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp2 = new XMLHttpRequest();
    }
}
//-----------
function createXMLHttpRequest3() 
{

    if (window.ActiveXObject) 
    {
        xmlHttp3 = new ActiveXObject("Microsoft.XMLHTTP");
		
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp3 = new XMLHttpRequest();
    }
}
//-----------
function createXMLHttpRequest4() 
{

    if (window.ActiveXObject) 
    {
        xmlHttp4 = new ActiveXObject("Microsoft.XMLHTTP");
		
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp4 = new XMLHttpRequest();
    }
}

//--------------
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
//------------------------------------------------------------------------------------------------------------
function loadStylePoCutNo()
{
	if(document.getElementById('cboFactory').value==""){
	clearform();
	return false;	
	}
	
var pub_url = "/gapro/production/lineInput/";
//---clear----------------------
		 document.getElementById('cboPoNo1').innerHTML= "";
		 document.getElementById('cboStyle1').innerHTML = "";
		 document.getElementById('cboPatternNo').innerHTML = "";
		 document.getElementById('cboCutNo').innerHTML = "";
		 clearGrid()	

		var factoryID=document.getElementById("cboFactory").value;
		createNewXMLHttpRequest(5);
		xmlHttpreq[5].onreadystatechange = HandleStylePoCutNo ;
		xmlHttpreq[5].open("GET",pub_url+'xml.php?RequestType=loadStylePoCutNo&factoryID='+ factoryID ,true);
		xmlHttpreq[5].send(null);
}

//-----------------------------------------------------------------------------------------------------------
function HandleStylePoCutNo()
{
	if(xmlHttpreq[5].readyState == 4) 
	{
		if(xmlHttpreq[5].status == 200) 
		{
		 	var XMLStyle = xmlHttpreq[5].responseXML.getElementsByTagName("style");
		 	var XMLPO = xmlHttpreq[5].responseXML.getElementsByTagName("orderNo");
			 
			 document.getElementById('cboPoNo1').innerHTML= XMLStyle[0].childNodes[0].nodeValue;
			 document.getElementById('cboStyle1').innerHTML = XMLPO[0].childNodes[0].nodeValue;
			 document.getElementById('cboPatternNo').innerHTML = "";
			 document.getElementById('cboCutNo').innerHTML = "";
			 document.getElementById('cboPoNo1').focus();

		}
	}		
}
//BEGIN - load cut number (relevent to d style/po)
function loadCutNo(styleID)
{
	document.getElementById('cboPoNo1').value= styleID;
	document.getElementById('cboStyle1').value = styleID;
	document.getElementById('cboPatternNo').innerHTML = "";
	clearGrid();	
	var url = pub_url+'xml.php?RequestType=LoadCutNo&styleID='+ styleID;	
	var htmlobj = $.ajax({url:url,async:false});
	HandleLoadCutNo(htmlobj);
}

function HandleLoadCutNo(xmlHttp4)
{
	var XMLCutNo = xmlHttp4.responseXML.getElementsByTagName("cutPC");
	document.getElementById('cboCutNo').innerHTML = XMLCutNo[0].childNodes[0].nodeValue;
	document.getElementById('cboCutNo').focus();
}
//END - load cut number (relevent to d style/po)

function loadInputFrom(year,serialNo,permission)
{

	 	if(permission==true)
			document.getElementById("butCancle").style.display="inline";
		
		var pub_url = "/gapro/production/lineInput/";
		
		createNewXMLHttpRequest(0);
		xmlHttpreq[0].onreadystatechange = HandleLoadCutNoToSerial;
		xmlHttpreq[0].open("GET",pub_url+'xml.php?RequestType=LoadCutNoToSerial&serialNo='+ serialNo + '&year='+ year ,true);
		xmlHttpreq[0].send(null);
						disableFields();

}
//-------------------------------------------------------------------------------------------------------------
	
	
function HandleLoadCutNoToSerial()
	{
		if(xmlHttpreq[0].readyState == 4) 
		{
			if(xmlHttpreq[0].status == 200) 
			{	
		//	alert(xmlHttpreq[0].responseText);
			
		         var XMLFactory = xmlHttpreq[0].responseXML.getElementsByTagName("factory");
			     document.getElementById('cboFactory').value = XMLFactory[0].childNodes[0].nodeValue;
			     document.getElementById('cboFactory').disabled = true;

				// loadStylePoCutNo();
				 
		         var XMLstyleID = xmlHttpreq[0].responseXML.getElementsByTagName("style");
			     document.getElementById('cboStyle1').innerHTML = XMLstyleID[0].childNodes[0].nodeValue;
				 
		         var XMLorderNo= xmlHttpreq[0].responseXML.getElementsByTagName("orderNo");
			     document.getElementById('cboPoNo1').innerHTML = XMLorderNo[0].childNodes[0].nodeValue;
				 
		         var XMLCutNo = xmlHttpreq[0].responseXML.getElementsByTagName("cutPC");
			     document.getElementById('cboCutNo').innerHTML = XMLCutNo[0].childNodes[0].nodeValue;
				 
				 getInputEntryDetails();
			}
		}
	}

function getInputEntryDetails()
{  
	var cutBundleSerial = document.getElementById('cboCutNo').value;

	var url = pub_url+'xml.php?RequestType=LoadPattNo&cutBundleSerial='+ cutBundleSerial;
	var htmlobj=$.ajax({url:url,async:false});
	HandleLoadPatternNo(htmlobj);
}

function HandleLoadPatternNo(htmlobj)
{
	var XMLPattrnNo = htmlobj.responseXML.getElementsByTagName("pattern");
	document.getElementById('cboPatternNo').innerHTML = XMLPattrnNo[0].childNodes[0].nodeValue
	LoadDetails()
}

//Load Events Existing for a Particular Customer & LeadTime
function LoadDetails()
{
clearGrid();	
var searchYear=document.getElementById('txtSearchInputYear').value;
var searchInputNo=document.getElementById('txtSearchInputNo').value;

	
	xmlHttp2=GetXmlHttpObject();
	if (xmlHttp2==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cboCutNo').value.trim()=='')
	{
		return false;
	}

	var cutBundleSerial = document.getElementById("cboCutNo").value;
	createXMLHttpRequest3();
	xmlHttp3.onreadystatechange = HandleLoadEventsforLeadTime1 ;
	var url = pub_url+'xml.php?RequestType=LoadNewInputDataEntry&cutBundleSerial='+ cutBundleSerial +'&searchYear='+ searchYear+'&searchInputNo='+ searchInputNo;
	var htmlobj=$.ajax({url:url,async:false});
	HandleLoadEventsforLeadTime1(htmlobj);
}

function HandleLoadEventsforLeadTime1(xmlHttp3)
{
	var XMLSize = xmlHttp3.responseXML.getElementsByTagName("Size");
	var XMLCutBundserial = xmlHttp3.responseXML.getElementsByTagName("CutBundserial");
	var XMLBundlNo = xmlHttp3.responseXML.getElementsByTagName("BundlNo");
	var XMLRange = xmlHttp3.responseXML.getElementsByTagName("Range");
	var XMLShade = xmlHttp3.responseXML.getElementsByTagName("Shade");
	var XMLPcs = xmlHttp3.responseXML.getElementsByTagName("Pcs");
	var XMLRecieved = xmlHttp3.responseXML.getElementsByTagName("Recieved");
	
	var XMLDate = xmlHttp3.responseXML.getElementsByTagName("date");
	var XMLTeam = xmlHttp3.responseXML.getElementsByTagName("team");
	var XMLremark =xmlHttp3.responseXML.getElementsByTagName("remark");  
	var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblevents\" border=\"0\">"+
					"<tr>"+
					"<td width=\"12%\" height=\"25\" bgcolor=\"#498CC2\" class=\"grid_header\">Size</td>"+
					"<td width=\"10%\" bgcolor=\"#498CC2\" class=\"grid_header\">Bundle No</td>"+
					"<td width=\"12%\" bgcolor=\"#498CC2\" class=\"grid_header\">Range</td>"+
					"<td width=\"15%\" bgcolor=\"#498CC2\" class=\"grid_header\">Shade</td>"+
					"<td width=\"12%\" bgcolor=\"#498CC2\" class=\"grid_header\">Bal Qty</td>"+
					"<td width=\"12%\" bgcolor=\"#498CC2\" class=\"grid_header\">Input</td>"+
					"<td width=\"5%\" bgcolor=\"#498CC2\" class=\"grid_header\"><input name=\"checkbox\" type=\"checkbox\" id=\"chkCheckAll\" onclick=\"checkAll(this);\" checked=\"checked\"  /></td>"+
					"<td width=\"12%\" bgcolor=\"#498CC2\" class=\"grid_header\" >Remark</td>"+
					"</tr>";
								
	for ( var loop = 0; loop < XMLSize.length; loop ++)
	{
		if((loop%2)==0)
			var rowClass="grid_raw";		
		else
			var rowClass="grid_raw2";		
	
		tableText +=" <tr class=\"" + rowClass + "\">" +
		" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLSize[loop].childNodes[0].nodeValue + "\" > "+ XMLSize[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLCutBundserial[loop].childNodes[0].nodeValue + "\" > "+ XMLBundlNo[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLRange[loop].childNodes[0].nodeValue + "\" > "+ XMLRange[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLShade[loop].childNodes[0].nodeValue + "\" > "+ XMLShade[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfntRite\" align=\"center\" id=\"" + XMLPcs[loop].childNodes[0].nodeValue + "\" > "+ XMLPcs[loop].childNodes[0].nodeValue +"&nbsp;</td>"+
		" <td class=\"normalfntMid\" align=\"right\" id=\"" + XMLRecieved[loop].childNodes[0].nodeValue + "\" ><input type=\"text\" id=\"" + loop + "\" name=\"" + loop + "\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" onkeypress=\"return isNumberKey(event);\" onkeyup=\" getTotQty();compQty(this.name);\" value=\""+ XMLRecieved[loop].childNodes[0].nodeValue+"\"> " +
		"</input></td>" +
		" <td class=\"normalfntMid\" align=\"right\"><input type=\"checkbox\" checked=\"true\" name=\"chkStatus\" id=\"chkStatus\"  onclick=\"checkUncheckTextBox(this);\" /> " +
		"</input></td>" +
		" <td class=\"normalfntMid\" align=\"right\" ><input type=\"text\" id=\"offset\" name=\"offset\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"left\" value=\""+ XMLremark[loop].childNodes[0].nodeValue+"\"> " +
		"</input></td>" +
		
		" </tr>";
				
	}
	tableText += "</table>";
	document.getElementById('divcons').innerHTML=tableText;  
	document.getElementById('txtBundles').value= XMLSize.length;  
	if(XMLDate[0].childNodes[0].nodeValue !="")
		document.getElementById('txtInputtDate').value=  XMLDate[0].childNodes[0].nodeValue;  
	document.getElementById('cboTeam').value=  XMLTeam[0].childNodes[0].nodeValue;  
	getTotQty();
}
//----------------------------------------------------
function disableFields(){
	 document.getElementById('cboFactory').disabled = true;
	 document.getElementById('cboPoNo1').disabled = true;
	 document.getElementById('cboStyle1').disabled = true;
	 document.getElementById('cboCutNo').disabled = true;
	 document.getElementById('cboPatternNo').disabled = true;
	//document.getElementById('cboTeam').disabled = true;
}
//-------------------------------------------------------------------------------------
function getTotQty()
{
	totInputQty=0;
	var bundles=0;
	var tbl = document.getElementById('tblevents');
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[6].childNodes[0].checked == true){
		    totInputQty += parseFloat(tbl.rows[loop].cells[5].childNodes[0].value);
			bundles++;
			}
		}
	document.getElementById('txtTotInpQty').value= totInputQty;  
	document.getElementById('txtBundles').value= bundles;  
}
//-------------------------------------------
function compQty(loop)
{
var tbl = document.getElementById('tblevents');
loop=parseFloat(loop)+1;
var inputQty =parseFloat(tbl.rows[loop].cells[5].childNodes[0].value);
var recvQty=parseFloat(tbl.rows[loop].cells[4].innerHTML.trim());

var searchYear=document.getElementById('txtSearchInputYear').value;
var searchInput=document.getElementById('txtSearchInputNo').value;
if((searchYear!="") && (searchInput!="")){
	recvQty +=parseFloat(tbl.rows[loop].cells[5].id)	
}

if(inputQty > recvQty){
alert("Invalid Input Qty");
tbl.rows[loop].cells[5].childNodes[0].value=recvQty;
}

if(inputQty ==0){
tbl.rows[loop].cells[6].childNodes[0].checked=false;
}
else{
tbl.rows[loop].cells[6].childNodes[0].checked=true;
}
var chk=0;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[6].childNodes[0].checked == true)
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
//-------------------------------------------
function checkAll(obj)
{
	var tbl = document.getElementById('tblevents');
	if(obj.checked)
	{
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			tbl.rows[loop].cells[6].childNodes[0].checked = true;
			tbl.rows[loop].cells[5].childNodes[0].value =tbl.rows[loop].cells[5].id.trim();
		}
	document.getElementById('txtTotInpQty').value= 0;  
	}
	else
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
		    tbl.rows[loop].cells[5].childNodes[0].value = 0;
			tbl.rows[loop].cells[6].childNodes[0].checked = false;
		}
	}
			getTotQty();
}
//--------------------------------------------------------------------------------------------------------------
function checkUncheckTextBox(objevent)
{
	var tbl = document.getElementById('tblevents');
	var rw = objevent.parentNode.parentNode;
	
	if (rw.cells[6].childNodes[0].checked)
	{
		//if(rw.cells[5].childNodes[0].value == "")
			rw.cells[5].childNodes[0].value =rw.cells[5].id.trim();
			rw.cells[5].childNodes[0].focus();
	}
	else
	{
		rw.cells[5].childNodes[0].value = 0;
		rw.cells[5].childNodes[0].focus();
	}

var chk=0;
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[6].childNodes[0].checked == true)
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
//--------------12-05-2011-hem-----------------------
function SaveLineInputDetails()
{
	if(ValidateHeaderDets())
	{	
		showBackGroundBalck();
		var InputDate	= document.getElementById("txtInputtDate").value;
		var factory 	= document.getElementById("cboFactory").value;
		var InpYear 	= document.getElementById("txtYear").value;
		var styleID 	= document.getElementById("cboPoNo1").value;
		pub_styleId		= styleID;
		var Status 		= 0;
		
		
		var SelectOption 	= document.frmLineInput.cboCutNo;
		var SelectedIndex 	= SelectOption.selectedIndex;
		var SelectedValue	= SelectOption.value;
		var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
		var cutNo 			= SelectedText;		
		var teamNo 			= document.getElementById("cboTeam").value;
		var patternNo 		= document.getElementById("cboPatternNo").value;
		var totQty 			= 0;
		var totBalQty 		= 0;
		
		//--if searching---------
		var searchYear	= document.getElementById('txtSearchInputYear').value;
		var searchInput	= document.getElementById('txtSearchInputNo').value;
		//-----------------------

		var url = 'xml.php?RequestType=SaveLineInputHeader&InputDate=' + InputDate + '&factory='+ factory + '&InpYear='+ InpYear + '&styleID='+ styleID + '&Status='+ Status + '&cutNo='+ cutNo + '&teamNo='+ teamNo + '&patternNo='+ patternNo+ '&totQty='+ totQty+ '&totBalQty='+ totBalQty + '&searchYear='+ searchYear+ '&searchInput='+ searchInput;
		htmlobj=$.ajax({url:url,async:false});
		HandleSavingHeader(htmlobj);
		
	}
}

function HandleSavingHeader(htmlobj)
{
	var XMLOutput 			= htmlobj.responseXML.getElementsByTagName("Save");
	var XMLInputserial 		= htmlobj.responseXML.getElementsByTagName("Inputserial");
	var XMLInputserialYear 	= htmlobj.responseXML.getElementsByTagName("InputserialYear");
	
	if(XMLOutput[0].childNodes[0].nodeValue == "True")
	{
		var lineInputSerial = XMLInputserial[0].childNodes[0].nodeValue;
		var year 			= XMLInputserialYear[0].childNodes[0].nodeValue;
		var cutBundSerail 	= document.getElementById("cboCutNo").value;
		var styleID 		= document.getElementById("cboStyle1").value;
		
		var SelectOption	= document.frmLineInput.cboCutNo;
		var SelectedIndex	= SelectOption.selectedIndex;
		var SelectedValue	= SelectOption.value;
		var SelectedText	= SelectOption.options[SelectOption.selectedIndex].text;	
		var cutNo 			= SelectedText;
		var factory 		= document.getElementById("cboFactory").value;
		
		var tbl	 			= document.getElementById('tblevents');
		var CutBundleSerial = "";
		var BundleNo		= "";
		var Qty 			= "";
		var RecvQty 		= "";
		var remarks			= "";
		var BalQty			= "";
		var savedRcds		= 0;
		var tblRecords		= 0;
	
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[5].childNodes[0].value!=0)
			{
				BundleNo 	=  trim(tbl.rows[loop].cells[1].innerHTML);
				Qty 	 	= tbl.rows[loop].cells[4].innerHTML.trim();
				RecvQty  	= tbl.rows[loop].cells[5].childNodes[0].value;
				remarks  	= tbl.rows[loop].cells[7].childNodes[0].value;
				
				if(RecvQty=="")
					RecvQty = 0;
				
				if(Qty=="")
				 	Qty 	= 0;
				
				BalQty 		=  Qty-RecvQty;	

				var url = 'xml.php?RequestType=SaveLineInputDetails&lineInputSerial=' + lineInputSerial + '&cutBundSerail='+ cutBundSerail + '&cutNo='+ cutNo + '&year='+ year + '&BundleNo='+ BundleNo + '&Qty='+ RecvQty + '&BalQty='+ BalQty + '&factory='+ factory + '&styleID='+ styleID +'&remarks='+remarks;
				htmlobj=$.ajax({url:url,async:false});
				
				var XMLResult = htmlobj.responseXML.getElementsByTagName("result");
				if(XMLResult[0].childNodes[0].nodeValue==1)
					savedRcds++;	
				
					tblRecords++;
			}
		}
		
		if(savedRcds==tblRecords)
			HandleSavingDetails(1,htmlobj);
		else
			HandleSavingDetails(0,'');
	}
	else
		alert("The event Line Input header save failed.");	
}
//-----------------------------------------------
function HandleSavingDetails(saved,htmlobj)
{
	var searchYear=document.getElementById('txtSearchInputYear').value;
	var searchInput=document.getElementById('txtSearchInputNo').value;
	
	if(saved== 1)
	{
		var XMLYear = htmlobj.responseXML.getElementsByTagName("year");
		var XMLSerial = htmlobj.responseXML.getElementsByTagName("serial");
		
		hideBackGroundBalck();
		alert("Line Input No \""+XMLSerial[0].childNodes[0].nodeValue+"/"+XMLYear[0].childNodes[0].nodeValue+"\" saved successfully.");
			
		if((searchYear=="") && (searchInput==""))
		{
			// BEGIN - 14-06-2011 - After save without order no other details must clear
			document.frmLineInput.reset();
			clearGrid();
			document.getElementById('cboPoNo1').value = pub_styleId;
			//END - 14-06-2011 - After save without order no other details must clear 
			//document.frmLineInput.submit();
		}
		else
		{
			getInputEntryDetails();
		}
		document.getElementById("cboFactory").focus();
	}
	else
	{
		alert("The details saved fail.");
	}
}

function ValidateHeaderDets()
{
	var tbl = document.getElementById('tblevents');
    var rows = tbl.rows.length-1;
	var recvCount=0;
	
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[5].childNodes[0].value != 0){
			recvCount += parseFloat(tbl.rows[loop].cells[5].childNodes[0].value);
		}
	}
	
	if (document.getElementById('cboFactory').value == "" )	
	{
		alert("Please select a \"Factory\".");
		document.getElementById('cboFactory').focus();
		return false;
	}
	else if (document.getElementById('cboCutNo').value == "" )	
	{
		alert("Please select a \"Cut No.\"");
		document.getElementById('cboCutNo').focus();
		return false;
	}
	else if (document.getElementById('txtInputtDate').value == "" )	
	{
		alert("Please select the \"Date\".");
		document.getElementById('txtInputtDate').focus();
		return false;
	}
	else if (document.getElementById('cboTeam').value == "" )	
	{
		alert("Please select the \"Line No.\"");
		document.getElementById('cboTeam').focus();
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
		alert("There is no any \"Input Qty\" to save. ");
		return false;
	}
return true;
}

function clearform()
{
	showBackGround('divBG',0);
	document.frmLineInput.reset();
	document.getElementById('txtSearchInputNo').value="";
	document.getElementById('txtSearchInputYear').value="";	
	clearGrid();	
	document.getElementById('cboPoNo1').innerHTML = "";
	document.getElementById('cboPoNo1').disabled = false;
	document.getElementById('cboStyle1').innerHTML = "";
	document.getElementById('cboStyle1').disabled = false;
	document.getElementById('cboCutNo').innerHTML = "";
	document.getElementById('cboCutNo').disabled = false;
	document.getElementById('cboPatternNo').innerHTML = "";	
	document.getElementById('cboPatternNo').disabled = false;
	document.getElementById('cboTeam').value = "";
	document.getElementById('cboTeam').disabled = false;
	document.getElementById('cboFactory').focus();
	LoadOrders();
	hideBackGround('divBG');
	pub_styleId	= "";
}

function clearGrid()
{
	$("#tblevents tr:gt(0)").remove();
}

function popreporter()
{
	var url  = "lineinreport_plugin.php?";
	
	var W	= 0;
	var H	= 0;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeCountryModePopUpInSupplier";
	var tdPopUpClose = "country_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

function closeCountryModePopUpInSupplier(id)
{
	closePopUpArea(id);	
}

function closePopUpArea(id)
{
	try
	{
		var box = document.getElementById('popupLayer'+id);
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

function date_setter()
{
	if($('#cbxSetDate').attr('checked'))
	{
		$("#txtDateFrom").removeAttr("disabled", "disabled"); 
		$("#txtDateTo").removeAttr("disabled", "disabled"); 
		$("#txtDateFrom").val(pub_date_from);
		$("#txtDateTo").val(pub_date_to);
	}
	else
	{
		$("#txtDateFrom").attr("disabled", "disabled"); 
		$("#txtDateTo").attr("disabled", "disabled"); 
		pub_date_from=$("#txtDateFrom").val();
		pub_date_to=$("#txtDateTo").val();
		$("#txtDateFrom").val('');
		$("#txtDateTo").val('');
	}						
}

function printSummary()
{
	var factoryid	= $("#cboPopFactory").val();
	var teamno		= $("#cboPopTeam").val();
	var from_date	= $('#txtDateFrom').val();
	var to_date		= $('#txtDateTo').val();
	var styleId		= $('#cboStyleId').val();
	if(factoryid=="")
	{
		alert("Please select 'Factory'.");
		$("#cboPopFactory").focus();
		return;
	}
	if(teamno=="")
	{
		alert("Please select 'Line'.")
		$("#cboPopTeam").focus();
		return;
	}
	window.open('rptTransInSummary.php?factoryid='+factoryid+'&teamno='+teamno+'&from_date='+from_date+'&to_date='+to_date+ '&StyleId='+styleId,"rptin");	
}

function LoadOrders()
{
	var url = 'xml.php?RequestType=URLLoadOrders';
	var htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboPoNo1').innerHTML = htmlobj.responseText;
}
function cancleLineInput()
{
	var reason = prompt("Please enter a reason for the cancellation.", "");
	if(reason=="")
	{
		alert("You cannot cancle the Line Input without enter a reason.");
		return;
	}
	
	var lineInputNo   = document.getElementById("txtSearchInputNo").value;
	var lineInputYear = document.getElementById("txtSearchInputYear").value;
	var lineInputQty  = document.getElementById("txtTotInpQty").value;
	
	var url = "xml.php?RequestType=CancleLineInput&lineInputNo="+lineInputNo+"&lineInputYear="+lineInputYear+"&reason="+reason;
	htmlobj = $.ajax({url:url,async:false});
	var cancleRes = htmlobj.responseXML.getElementsByTagName("cancleResponse")[0].childNodes[0].nodeValue;
	if(cancleRes == "Updated")
		alert("Cancled successfully.");

	else if(cancleRes == "Error")
	{
		alert("Error in cancling.");
		return;
	}
	else if(cancleRes == "LineOut")
	{
		alert("Cannot cancle. Line Output already raise for this Line Input.")
		return;
	}
	else if(cancleRes == "Cancle")
	{
		alert("Line Input already cancled.")
		return;
	}
	
}