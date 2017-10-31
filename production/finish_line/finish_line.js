var xmlHttpreq = [];
var pub_url = "/gapro/production/washReceive/";

//----------Load colors--------------------------------------
function loadColors(styleID)
{
	
    document.getElementById('cboOrderNo').value= styleID;
    document.getElementById('cboStyle').value = styleID;

	var path="xml.php?RequestType=selectColors&styId="+styleID;
	
	htmlobj=$.ajax({url:path,async:false});
	var XMLColor	=htmlobj.responseXML.getElementsByTagName("strColor");
	document.getElementById("cboColor").innerHtml="";
	for(var i=0;i<XMLColor.length;i++)
	{
		var opt = document.createElement("option");
			opt.value = XMLColor[i].childNodes[0].nodeValue;
			opt.text = XMLColor[i].childNodes[0].nodeValue;	
			document.getElementById("cboColor").options.add(opt);
	}
	document.getElementById("cboColor").focus();
}
//-------------------------------------------------------------
function loadData(sNo)
{
	var path="xml.php?RequestType=selectDet&styId="+document.getElementById('cboStyle').value+"&color="+document.getElementById('cboColor').value;
	
	htmlobj=$.ajax({url:path,async:false});
	
		//alert(htmlobj.responseText); 
	var XMLTag   = htmlobj.responseXML.getElementsByTagName("strTag");
	var XMLFactory   = htmlobj.responseXML.getElementsByTagName("strName");
	var XMLPOQTY   = htmlobj.responseXML.getElementsByTagName("POQTY");
	var XMLSize   = htmlobj.responseXML.getElementsByTagName("Size");
	var XMLReceived   = htmlobj.responseXML.getElementsByTagName("Received");
	var XMLIssued   = htmlobj.responseXML.getElementsByTagName("Issued");
	
	//alert(XMLTag[0].childNodes[0].nodeValue);
	if(XMLTag[0].childNodes[0].nodeValue==1)
	{
		document.getElementById("txtFactory").value=XMLFactory[0].childNodes[0].nodeValue;
		document.getElementById("txtPoQty").value=XMLPOQTY[0].childNodes[0].nodeValue;
		
		//-------------------
	
			var tableText = "<table width=\"100%\" cellpadding=\"1\" cellspacing=\"0\" id=\"tblFinishLine\" class=\"thetable\">"+
                                "<tr>"+
				"<th>Size</th>"+
				"<th>PO Qty</th>"+
				"<th>Received Qty</th>"+
				"<th>Issued Qty</th>"+
				"<th>Issue Qty</th>"+
				"<th>Balance Qty</th>"+
				"<th>Status</th>"+
                                "</tr>";
								
			 for ( var loop = 0; loop < XMLSize.length; loop ++)
			 {
				if((loop%2)==0){
				var rowClass="grid_raw"	
				}
				else{
				var rowClass="grid_raw2"	
				}
				
	var balQty= XMLReceived[loop].childNodes[0].nodeValue-XMLIssued[loop].childNodes[0].nodeValue;
				
				tableText +=" <tr class=\"" + rowClass + "\">" +
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLSize[loop].childNodes[0].nodeValue + "\" > "+ XMLSize[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLPOQTY[loop].childNodes[0].nodeValue + "\" > "+ XMLPOQTY[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLReceived[loop].childNodes[0].nodeValue + "\" > "+ XMLReceived[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLIssued[loop].childNodes[0].nodeValue + "\" > "+ XMLIssued[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"right\"><input type=\"text\" id=\"" + loop + "\" name=\"" + loop + "\" class=\"txtbox\" style=\"text-align:right\" size=\"10px\" align =\"right\" onkeypress=\"return isNumberKey(event);\" onkeyup=\"SetQty(this.name);\" value=\"0\"> " +
							"</input></td>" +
							" <td class=\"normalfntRite\" id=\"" + balQty + "\" > "+ balQty +"&nbsp;</td>"+
							" <td class=\"normalfntMid\" align=\"right\"><input type=\"checkbox\" checked=\"true\" name=\"chkStatus\" id=\"chkStatus\"  onclick=\"checkUncheckTextBox(this);\" /> " +
							"</input></td>" +
							
							" </tr>";
							
			 }
			tableText += "</table>";
		//	alert(tableText)
			document.getElementById('divcons').innerHTML=tableText;
		//-------------------
	}
	else
	{
	//	document.getElementById("washIssue_txtIssueNo").value="";
		document.getElementById("txtPoQty").value="";
	}

}
function SetQty(loop)
{
var tbl = document.getElementById('tblFinishLine');
loop=parseFloat(loop)+1;
var ReceiveQty =parseFloat(tbl.rows[loop].cells[2].innerHTML.trim());
var IssuedQty =parseFloat(tbl.rows[loop].cells[3].innerHTML.trim());
var IssueQty=parseFloat(tbl.rows[loop].cells[4].childNodes[0].value);

	var exit= IssueQty + IssuedQty;
	//alert(ReceiveQty);

if(exit > ReceiveQty){
alert("Invalid \"Issue Qty\".");
tbl.rows[loop].cells[4].childNodes[0].value=ReceiveQty-IssuedQty;
}
tbl.rows[loop].cells[5].innerHTML=(ReceiveQty-IssuedQty-parseFloat(tbl.rows[loop].cells[4].childNodes[0].value));

if(IssueQty ==0){
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
		//document.getElementById('chkCheckAll').checked=true;	
		}
		else{
		//document.getElementById('chkCheckAll').checked=false;	
		}
		
}
//-------------------------------------------------------------------------------
function saveFinishLine()
{
	if(validateForm())
	{	
		showBackGroundBalck();
	
	var finishLineID=document.getElementById('txtFinishLineID').value;
	var finishLineYear='';
	
	var dtmDate=document.getElementById('finish_lineDate').value;
	var style=document.getElementById('cboStyle').value;
	var color=document.getElementById('cboColor').value;
	var year=document.getElementById('txtYear').value;
	var lineID='';
	
	
	var tbl = document.getElementById('tblFinishLine');
	noOfRows=tbl.rows.length-1;
	var ArraySize="";
	var ArrayQty =0;
	var TotExistQty =0;

		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			if(tbl.rows[loop].cells[6].childNodes[0].value!=0)
			{
				var ExistQty = parseFloat(tbl.rows[loop].cells[3].innerHTML);
				var Qty = tbl.rows[loop].cells[4].childNodes[0].value;
				var Size =  tbl.rows[loop].cells[0].innerHTML;
				
				if(Qty==""){
				 Qty=0;
				}
	
				if (tbl.rows.length > 1)
				{
						ArrayQty += Qty + ",";
						ArraySize += Size + ",";
						
						TotExistQty += ExistQty;
				 }
			}

		}
		
	var path="xml.php?RequestType=";
	if(TotExistQty==0)
	{
		path+="saveDet";
	}
	else
	{
		path+="updateDet&finishLineID="+finishLineID+"&finishLineYear="+finishLineYear;
	}
	path+="&style="+style+"&dtmDate="+dtmDate+"&lineID="+lineID+"&color="+color+"&year="+year;	
	
	htmlobj=$.ajax({url:path,async:false});
		
			var XMLOutput = htmlobj.responseXML.getElementsByTagName("SaveDetail");
			var XMLSerial = htmlobj.responseXML.getElementsByTagName("serial");
			if(XMLOutput[0].childNodes[0].nodeValue == "True")
			{
				var serialNo = XMLSerial[0].childNodes[0].nodeValue;
				var year = document.getElementById("txtYear").value;
				
				SaveLineFinishDetails(serialNo,year,ArrayQty,ArraySize,noOfRows);
			}
		
		
	}
}
//---------------------------------------------------------------------

function SaveLineFinishDetails(serialNo,year,ArrayQty,ArraySize,noOfRows)
{
	var path="xml.php?RequestType=SaveFinishLineDetails";
	path+="&serialNo="+serialNo+"&year="+year+"&ArrayQty="+ArrayQty+"&ArraySize="+ArraySize+"&noOfRows="+noOfRows;	
	
	htmlobj=$.ajax({url:path,async:false});
	
	//var searchSerialNo=document.getElementById('txtSerial').value;
	 var XMLResult = htmlobj.responseXML.getElementsByTagName("SaveDetail");
	
	if(XMLResult[0].childNodes[0].nodeValue == "True")
	{
		hideBackGroundBalck();
		alert("The details saved successfully.");
	}
	else{
		alert("The details saved fail.");
	}
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
				document.frmProductionGatePass.reset();
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
function validateForm()
{
	if (document.getElementById('cboStyle').value == "" )	
	{
		alert("Please select a \"Style No\" ");
		document.getElementById('cboStyle').focus();
		return false;
	}
	else if (document.getElementById('cboOrderNo').value == "" )	
	{
		alert("Please select a \"Order No\"");
		document.getElementById('cboOrderNo').focus();
		return false;
	}
	else if (document.getElementById('cboColor').value == "" )	
	{
		alert("Please select a \"Color\"");
		document.getElementById('cboColor').focus();
		return false;
	}
	else if (document.getElementById('finish_lineDate').value == "" )	
	{
		alert("Please select a \"Date\"");
		document.getElementById('finish_lineDate').focus();
		return false;
	}
	else{
		return true;
	}
}
//----onload function--------------------------------------------------------------------------
function loadInputFrom(year,serialNo)
	{
	document.getElementById('txtWashRecvYear').value=year;
	document.getElementById('txtWashRecvNo').value=serialNo;
	
	
	//hem-30/09/2010-----------------
	var url=pub_url+"xml.php";
	url=url+"?RequestType=LoadHeaderToSerial";
	url += '&serialNo='+serialNo;
	url += '&year='+year;
	
	var htmlobj=$.ajax({url:url,async:false});
	//----------------------------------
		//alert(htmlobj.responseText); 
	
	
	
	
	 var XMLfromFactory = htmlobj.responseXML.getElementsByTagName("styleId");
	 document.getElementById('cboStyle').value = XMLfromFactory[0].childNodes[0].nodeValue;
	 
	 var XMLtoFactory = htmlobj.responseXML.getElementsByTagName("styleId");
	 document.getElementById('cboOrderNo').value = XMLtoFactory[0].childNodes[0].nodeValue;
	 
	 document.getElementById('cboStyle').disabled = true;
	 document.getElementById('cboOrderNo').disabled = true;
	
	 var XMLColor = htmlobj.responseXML.getElementsByTagName("strColor");
	 
	document.getElementById("cboColor").innerHTML="";
	for(var i=0;i<XMLColor.length;i++)
	{
		var opt = document.createElement("option");
			opt.value = XMLColor[i].childNodes[0].nodeValue;
			opt.text = XMLColor[i].childNodes[0].nodeValue;	
			document.getElementById("cboColor").options.add(opt);
	}
	 document.getElementById('cboColor').disabled = true;
	 
	 var XMLFactory = htmlobj.responseXML.getElementsByTagName("strName");
	 document.getElementById('txtFactory').value = XMLFactory[0].childNodes[0].nodeValue;
	 
	 
	var XMLExQty   = htmlobj.responseXML.getElementsByTagName("ExistQty");
	 document.getElementById('txtExistQty').value = XMLExQty[0].childNodes[0].nodeValue;
	 
	var XMLWashQty   = htmlobj.responseXML.getElementsByTagName("WashQty");
	 document.getElementById('txtWashQty').value = XMLWashQty[0].childNodes[0].nodeValue;

	var XMLDate   = htmlobj.responseXML.getElementsByTagName("date");
	 document.getElementById('washRcvDate').value = XMLDate[0].childNodes[0].nodeValue;
	 
	var XMLStyle   = htmlobj.responseXML.getElementsByTagName("strStyle");
	 document.getElementById('txtStyle').value = XMLStyle[0].childNodes[0].nodeValue;
	 
	var XMLOrderNo = htmlobj.responseXML.getElementsByTagName("date");
	 document.getElementById('txtOrderNo').value = XMLOrderNo[0].childNodes[0].nodeValue;
	 
	var XMLPOQTY   = htmlobj.responseXML.getElementsByTagName("POQTY");
	 document.getElementById('txtPoQty').value = XMLPOQTY[0].childNodes[0].nodeValue;
	 
	var XMLQTY   = htmlobj.responseXML.getElementsByTagName("QTY");
	 document.getElementById('txtRcvQty').value = XMLQTY[0].childNodes[0].nodeValue;

//	loadData(XMLStyle[0].childNodes[0].nodeValue)	 
	}
//---------------------------------------------------
function ClearForm(){
	//document.frmWashReceive.reset();
	
	document.getElementById('txtWashRecvYear').value='';
	document.getElementById('txtWashRecvNo').value='';
	
	 document.getElementById('cboStyle').disabled = false;
	 document.getElementById('cboOrderNo').disabled = false;
	 document.getElementById('cboColor').disabled = false;
	 
	document.getElementById('cboStyle').value='';
	document.getElementById('cboOrderNo').value='';
	document.getElementById('txtFactory').value='';
	
	document.getElementById('washRcvDate').value='';
	document.getElementById('txtStyle').value='';
	document.getElementById('txtOrderNo').value='';
	document.getElementById('txtPoQty').value='';
	document.getElementById('txtWashQty').value='';
	document.getElementById('txtRcvQty').value='';
	document.getElementById('txtExistQty').value=0;

	 
	document.getElementById("cboColor").innerHTML="";
		var opt = document.createElement("option");
			opt.value = '';
			opt.text = 'Select One';	
			document.getElementById("cboColor").options.add(opt);
}