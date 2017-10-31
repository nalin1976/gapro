var colEdit 	= 0 	//Edit 
var colDel		= 1 	//Delete
var colOrigin	= 2 	//Origin Type
var colDes 		= 3 	//Item Description
var colConPc 	= 4 	//Consumption per pcs
var colWas		= 5 	//Wastage
var colUP		= 6 	//unit Price
var colVal		= 7 	//Value
var calFinPer	= 8 	//Fincance Percentage
var colFinVal	= 9 	//Finance Value
var colDiffe	= 10	//Different
var colCate		= 11 	//Category

var xmlHttp;
var xmlHttp1				= [];
var pub_intxmlHttp_count	= 0;

var pub_matNo 				= 0;
var pub_printWindowNo		= 0;
var deci2					= 2;
var pub_reportCat			= 0;

var start_auto_cell			= 4;
var pub_ListRowIndex		= 0;

function createXMLHttpRequest1(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function CloseInvoiceCostPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}
function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

function CalculateValue(conPc,unitPrice)
{
	var value 	= conPc * unitPrice;
	value 		= value.toFixed(4);
	return value;
	//return round_up(value,2);
}

function round_up (val, precision) {
    power = Math.pow (10, precision);
    poweredVal = Math.ceil (val * power);
    result = poweredVal / power;
    return result;
}

function RoundNumbers(number,decimals)
{
	var newString;// The new rounded number
	decimals = Number(decimals);
	if (decimals < 1) {
		newString = (Math.round(number)).toString();
	} else {
		var numString = number.toString();
		if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
			numString += ".";// give it one at the end
		}
		var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
		var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
		var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
		if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
			if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
				while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
					if (d1 != ".") {
						cutoff -= 1;
						d1 = Number(numString.substring(cutoff,cutoff+1));
					} else {
						cutoff -= 1;
					}
				}
			}
			d1 += 1;
		} 
		if (d1 == 10) {
			numString = numString.substring(0, numString.lastIndexOf("."));
			var roundedNum = Number(numString) + 1;
			newString = roundedNum.toString() + '.';
		} else {
			newString = numString.substring(0,cutoff) + d1.toString();
		}
	}
	if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
		newString += ".";
	}
	var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
	for(var i=0;i<decimals-decs;i++) newString += "0";
	if (newString.charAt(newString.length-1) == ".")
		newString =newString.substring(0,newString.length-1);
	//var newNumber = Number(newString);// make it a number if you like
	newString = newString.replace("Infinity","0");
	return newString; // Output the result to the form field (change for your purposes)
}

function clearTable(tableName)
{
	$("#"+tableName+" tr:gt(0)").remove();
}

function loadOrderNo(style){
	var url = 'invoiceCost-xml.php?id=loadOrderNo&styleNo='+URLEncode(style.trim());
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('strOrderNo').innerHTML  = htmlobj.responseText;
}

function loadComboOrderNo(sql,control)
{
	var url = 'invoiceCost-xml.php?loadOrderNo='+sql;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById(control).innerHTML  = htmlobj.responseText;
}

function loadCostHeader(){
	var orderNo = document.getElementById("strOrderNo").value;	
	if(orderNo != "")
	{
		var url  = "invoiceCost-xml.php?id=loadCostHeader";
			url += "&cbointStyleId="+orderNo;
		var htmlobj=$.ajax({url:url,async:false});
		loadCostHeaderRequest(htmlobj);
		document.getElementById('popSearch').style.display="inline";
		document.getElementById('cbointStyleId').disabled = false;
		document.getElementById('strOrderNo').disabled = false;

/*	var tblTable    = 	document.getElementById("tblMain");
	tblTable		= 	document.getElementById("tblMain");
	var binCount	=	tblTable.rows.length;
	for(var loop=1;loop<binCount;loop++)
	{
		tblTable.deleteRow(loop);
		binCount--;
		loop--;
	}*/
	clearTable('tblMain');
	
		createXMLHttpRequest1(1);
		xmlHttp1[1].onreadystatechange = loadCostDetailRequest;
		var url  = "invoiceCost-xml.php?id=loadCostDetails";
			url += "&cbointStyleId="+orderNo;
		xmlHttp1[1].open("GET",url,true);
		xmlHttp1[1].send(null);
	}
}

function loadCostHeaderRequest(xmlHttp)
{	
	if(xmlHttp.responseXML.getElementsByTagName("intStyleId").length != 0)
	{
		var XMLintStyleId     = xmlHttp.responseXML.getElementsByTagName("intStyleId");
		var XMLstrStyle       = xmlHttp.responseXML.getElementsByTagName("strStyle");
		var XMLstrOrderNo     = xmlHttp.responseXML.getElementsByTagName("strOrderNo");
		var XMLdblFob         = xmlHttp.responseXML.getElementsByTagName("dblFob");
		var XMLdblQty         = xmlHttp.responseXML.getElementsByTagName("dblQty");
		var XMLfabric         = xmlHttp.responseXML.getElementsByTagName("fabric");
		var XMLdblNewCM       = xmlHttp.responseXML.getElementsByTagName("dblNewCM");
		var XMLstrDescription = xmlHttp.responseXML.getElementsByTagName("strDescription");
		var XMLReduceCM 	  = xmlHttp.responseXML.getElementsByTagName("ReduceCM");
		var XMLStatus 	  		= xmlHttp.responseXML.getElementsByTagName("Status");

		document.getElementById("cbointStyleId").value 	= XMLintStyleId[0].childNodes[0].nodeValue;
		document.getElementById("strOrderNo").value     = XMLstrOrderNo[0].childNodes[0].nodeValue;
		document.getElementById("dblFob").value         = XMLdblFob[0].childNodes[0].nodeValue;
		document.getElementById("dblQty").value         = XMLdblQty[0].childNodes[0].nodeValue;
		document.getElementById("strFabric").value      = XMLfabric[0].childNodes[0].nodeValue;
		document.getElementById("dblNewCM").value       = XMLdblNewCM[0].childNodes[0].nodeValue;
		document.getElementById("txtReduceCM").value    = XMLReduceCM[0].childNodes[0].nodeValue;
		document.getElementById("strDescription").value = XMLstrDescription[0].childNodes[0].nodeValue;
		ValidateMainInterface(XMLStatus[0].childNodes[0].nodeValue);
	}
}

function loadCostDetailRequest()
{
	if(xmlHttp1[1].readyState == 4 && xmlHttp1[1].status == 200 ) 
	{
		var tblMain 			  = document.getElementById("tblMain");
		var XMLintItemSerial      = xmlHttp1[1].responseXML.getElementsByTagName("intItemSerial");
		var XMLstrItemDescription = xmlHttp1[1].responseXML.getElementsByTagName("strItemDescription");
		var XMLreaConPc           = xmlHttp1[1].responseXML.getElementsByTagName("reaConPc");
		var XMLreaWastage         = xmlHttp1[1].responseXML.getElementsByTagName("reaWastage");
		var XMLdblUnitPrice       = xmlHttp1[1].responseXML.getElementsByTagName("dblUnitPrice");
		var XMLFinancePercent     = xmlHttp1[1].responseXML.getElementsByTagName("FinancePercent");
		var XMLstrOriginType	  = xmlHttp1[1].responseXML.getElementsByTagName("strOriginType");
		var XMLCategory	  		  = xmlHttp1[1].responseXML.getElementsByTagName("Category");
		var XMLClassName  		  = xmlHttp1[1].responseXML.getElementsByTagName("ClassName");
		var XMLType  		  	  = xmlHttp1[1].responseXML.getElementsByTagName("Type");

		for(var n = 0; n < XMLstrItemDescription.length ; n++) 
		{
			var itemserial =XMLintItemSerial[n].childNodes[0].nodeValue
			var rowCount = tblMain.rows.length;
			var row = tblMain.insertRow(rowCount);
				row.className="bcgcolor-tblrowWhite";
				row.className=XMLClassName[n].childNodes[0].nodeValue;
				
			var conPc 		= parseFloat(XMLreaConPc[n].childNodes[0].nodeValue);
			//var conPc 		= RoundNumbers(conPc,4);
			var unitPrice 	= parseFloat(XMLdblUnitPrice[n].childNodes[0].nodeValue);
			//var unitPrice 	= RoundNumbers(unitPrice,4);
			var value 		= CalculateValue(conPc,unitPrice);
			
			var finPercent	= Math.round(parseFloat(XMLFinancePercent[n].childNodes[0].nodeValue),1);
			var finValue 	= RoundNumbers((parseFloat(value) * finPercent)/100,4);
			
			tblMain.rows[rowCount].innerHTML=  "<td class=\"normalfntMid\"><img src=\"../../images/edit.png\" onclick=\"Edit(this);\" /></td>"+			
			"<td class=\"normalfntMid\"><img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\" /></td>"+
			"<td  class=\"normalfntMid\">"+ XMLstrOriginType[n].childNodes[0].nodeValue +"</td>"+
			"<td id=\""+itemserial+"\" class=\"normalfnt\">&nbsp;"+XMLstrItemDescription[n].childNodes[0].nodeValue+"</td>"+
			"<td class=\"normalfntRite\"><input maxlength=\"8\" type='text' lenght='7' id='gridconPc' size='7' value='"+conPc+"' onkeyup='calValue(this);' onblur=\"SetToZero(this);\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" class=\"txtbox keymove\"/></td>"+
			"<td class=\"normalfntRite\"><input maxlength=\"4\" type='text' lenght='7' size='3' value='"+XMLreaWastage[n].childNodes[0].nodeValue+"' id='gridWastage' style=\"text-align:right\" onblur=\"SetToZero(this);\" onkeypress=\"return isValidZipCode(this.value,event);\" class=\"txtbox keymove\"/></td>"+
			"<td class=\"normalfntRite\"><input maxlength=\"8\" type='text' lenght='7' size='7' value='"+unitPrice+"' id='gridunitPrice' onkeyup='calValue(this);' style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onblur=\"SetToZero(this);\" class=\"txtbox keymove\"/></td>"+
			"<td class=\"normalfntRite\">"+value+"</td>"+
			"<td class=\"normalfntRite\"><input maxlength=\"4\" type='text' lenght='7' size='4' value='"+finPercent+"' id='finance' onkeyup='calFinanceValue(this);' style=\"text-align:right\" onkeypress=\"return isValidZipCode(this.value,event);\" onblur=\"SetToZero(this);\" class=\"txtbox keymove\"/></td>"+
			"<td class=\"normalfntRite\">"+finValue+"</td>"+
			"<td class=\"normalfnt\">"+ XMLType[n].childNodes[0].nodeValue +"</td>"+
			"<td  class=\"normalfntMid\">"+ XMLCategory[n].childNodes[0].nodeValue +"</td>";
		}
		eventsetter();
	}
}

function SetToZero(obj)
{
	if(obj.value=="")
		obj.value= 0;
		
		calValue(obj);
}

function calValue(obj)
{
	var rows 	  = obj.parentNode.parentNode;
	var tblMain   = document.getElementById("tblMain");
	var gridconPc = (rows.cells[4].lastChild.value=="" ? 0 :parseFloat(rows.cells[4].lastChild.value));
	var unitPrice = (rows.cells[6].lastChild.value=="" ? 0:parseFloat(rows.cells[6].lastChild.value));
	
	var gridValue = CalculateValue(gridconPc,unitPrice)
	rows.cells[7].lastChild.nodeValue = gridValue; 
	var finPercent= (rows.cells[8].lastChild.value=="" ? 0:parseFloat(rows.cells[8].lastChild.value));
	finPercent 	  = (gridValue * finPercent/100);
	finPercent    = finPercent.toFixed(4);
	rows.cells[9].lastChild.nodeValue = RoundNumbers(finPercent,4); 
}

function calFinanceValue(obj)
{
	var rows 		= obj.parentNode.parentNode;
	var tblMain 	= document.getElementById("tblMain");
	var gridValue 	= rows.cells[7].lastChild.nodeValue;
	var finPercent 	= (rows.cells[8].lastChild.value=="" ? 0:rows.cells[8].lastChild.value);
	
	var finPercent = parseFloat(gridValue) * parseFloat(finPercent)/100; 
	finPercent	= finPercent.toFixed(4);
	rows.cells[9].lastChild.nodeValue = RoundNumbers(finPercent,4); 
}

function removeRow(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex
	tblMain.deleteRow(rowNo);
}

function newPage()
{
	//document.getElementById('frminvcost').reset();
	//RemoveAllRows('tblMain');
	//document.getElementById('cbointStyleId').focus();
	//document.getElementById('cbointStyleId').disabled = false;
	//loadCombo('(SELECT distinct strStyle,strStyle FROM orders WHERE orders.intStyleId  NOT IN (SELECT invoicecostingheader.intStyleId FROM invoicecostingheader)) ORDER BY orders.strStyle','cbointStyleId');
	//ValidateInterface(0);
}

function ValidateInterface(obj)
{
	document.getElementById("butSave").style.visibility="visible";
	document.getElementById("butConform").style.visibility="visible";
}

function save()
{
	showBackGround('divBG',0);
	if(!InterfaceValidation())
	{
		hideBackGround('divBG');
		return;
	}
	saveInvoiceCostHeader();
}

function InterfaceValidation()
{
	if(document.getElementById('strOrderNo').value=="")
	{
		alert("Please select the 'Order No'.");
		document.getElementById('strOrderNo').focus();
		return false;
	}
	if(document.getElementById('dblNewCM').value.trim()=="")
	{
		alert("Please enter the 'CM'.");
		document.getElementById('dblNewCM').select();
		return false;
	}
	if(document.getElementById('tblMain').rows.length <=1)
	{
		alert("No details appear to save in the grid.");
		return false;
	}
return true;
}

function saveInvoiceCostHeader()
{		
	var cbointStyleId	= document.getElementById("strOrderNo").value;
	var strOrderNo  	= document.getElementById("strOrderNo").options[document.getElementById("strOrderNo").selectedIndex].text;
	var strFabric		= document.getElementById("strFabric").value;
	var dblNewCM		= document.getElementById("dblNewCM").value;
	var strDescription	= document.getElementById("strDescription").value.trim();
	var dblFob			= document.getElementById("dblFob").value;
	var dblQty          = document.getElementById("dblQty").value;
	var reduceCM		= document.getElementById("txtReduceCM").value;
	
	var url  = "invoiceCost-db.php?id=saveInvoiceHeader";
		url += "&cbointStyleId="+cbointStyleId;
		url += "&strOrderNo="+URLEncode(strOrderNo);
		url += "&strFabric="+URLEncode(strFabric);
		url += "&dblNewCM="+dblNewCM;
		url += "&strDescription="+URLEncode(strDescription);
		url += "&dblFob="+dblFob;
		url += "&dblQty="+dblQty;
		url += "&ReduceCM="+reduceCM;	
	var htmlobj=$.ajax({url:url,async:false});
	saveInvoiceCostHeaderRequest(htmlobj);
}

function saveInvoiceCostHeaderRequest(xmlHttp)
{
	var cbointStyleId = trim(xmlHttp.responseText);
	
	document.getElementById("cbointStyleId").value = cbointStyleId;
	if(cbointStyleId!="Saving-Error")
	{
		saveInvoiceCostDetails();
	}
	else
	{
		alert("Error : \nInvoice Costing header not saved");
		hideBackGround('divBG');
		return;
	}
}

function saveInvoiceCostDetails()
{
	
	var tblGrn = document.getElementById("tblMain");	
	pub_intxmlHttp_count = tblGrn.rows.length-1;

	for(var loop=1;loop<tblGrn.rows.length;loop++)
	{
		var	cbointStyleId		= document.getElementById("strOrderNo").value;
		var intOrigin     		= tblGrn.rows[loop].cells[colOrigin].childNodes[0].value;
		var strItemCode     	= tblGrn.rows[loop].cells[colDes].id;
		var reaConPC    		= tblGrn.rows[loop].cells[colConPc].lastChild.value;
		var reaWastage			= tblGrn.rows[loop].cells[colWas].lastChild.value;
		var dblUnitPrice		= tblGrn.rows[loop].cells[colUP].lastChild.value;
		var dblValue    		= tblGrn.rows[loop].cells[colVal].lastChild.nodeValue;
		var finPercent         	= tblGrn.rows[loop].cells[calFinPer].lastChild.value;
		var diferent         	= tblGrn.rows[loop].cells[colDiffe].childNodes[0].value;
		var category         	= tblGrn.rows[loop].cells[colCate].childNodes[0].value;
		
		var url  = "invoiceCost-db.php?id=saveInvoiceCostDetails";
			url += "&cbointStyleId="+cbointStyleId;
			url += "&intOrigin="+intOrigin;
			url += "&strItemCode="+strItemCode;
			url += "&reaConPC="+reaConPC;
			url += "&reaWastage="+reaWastage;
			url += "&dblUnitPrice="+dblUnitPrice;
			url += "&dblValue="+dblValue;
			url += "&category="+category;
			url += "&diferent="+diferent;
			
			url += "&finPercent="+finPercent;		
			url += "&count="+loop;			
		var htmlobj=$.ajax({url:url,async:false});
		saveInvoiceCostDetailsRequest(htmlobj)
	}
}

function saveInvoiceCostDetailsRequest(xmlHttp)
{
	var cbointStyleId =xmlHttp.responseText;
	if(cbointStyleId==1)
	{
		pub_intxmlHttp_count=pub_intxmlHttp_count-1;
		if (pub_intxmlHttp_count ==0)
		{
			var	cbointStyleId1		= document.getElementById("cbointStyleId").options[document.getElementById("cbointStyleId").selectedIndex].text;
			alert("Saved successfully.");
			ValidateMainInterface(0);
			hideBackGround('divBG');
		}
	}
	else{
		alert( "Invoice Costing details saving error...");
		hideBackGround('divBG');
	}
}

//---------------------------------------------------------------load form-------------------------------------------------------------------------

function loadInvoiceCostForm(id,intStyleId)
{
	if(id=='0')
		return;	

	var url  = "invoiceCost-xml.php?id=loadCostHeaderFromInvCostTbl";
		url += "&cbointStyleId="+intStyleId;
	var htmlobj=$.ajax({url:url,async:false});
	loadCostHeaderRequest(htmlobj);
	
	createXMLHttpRequest1(1);
	xmlHttp1[1].onreadystatechange = loadCostDetailRequest;
	var url  = "invoiceCost-xml.php?id=loadCostDetailsFromInvCostTbl";
		url += "&cbointStyleId="+intStyleId;
	xmlHttp1[1].intStyleId = intStyleId;
	xmlHttp1[1].open("GET",url,true);
	xmlHttp1[1].send(null);
}

function saveInvoiceCostConfirmedHeader()
{
	var orderId  	= document.getElementById("strOrderNo").value;
	
	if(!PP_InvoiceCostingPowerUser)
		if(!isValidDeliveryScheduleAvailable())
			return;
	
		var url = 'invoiceCost-db.php?id=ConfirmInvoiceCostSheet&orderId='+orderId;
		htmlobj=$.ajax({url:url,async:false});	
		if(htmlobj.responseText=='1'){
			alert("Confirmed successfully.");		
			ValidateMainInterface(1);
			var url = 'invoicecost_report.php?orderNo='+orderId+ '&ReportCat=1&fob_update=fob_update';
			htmlobj=$.ajax({url:url,async:false});	
		}
		else{
			alert("Error while confirming.Please confirm it again.");
			ValidateMainInterface(0);
		}
	
}
function CopyPopUp()
{	
	if (document.getElementById("divCopy").style.visibility == "hidden")
	{
		document.getElementById("divCopy").style.visibility = "visible";
		LoadPOToPopUp();
	}
	else
		document.getElementById("divCopy").style.visibility = "hidden";
}

function Edit(obj)
{
	var rw			= obj.parentNode.parentNode;
	
	var conpc		= rw.cells[4].childNodes[0].value;
	var wastage		= rw.cells[5].childNodes[0].value;
	var unitPrice	= rw.cells[6].childNodes[0].value;
	var finance		= rw.cells[8].childNodes[0].value;
	var originType	= rw.cells[2].childNodes[0].value;
	var category	= rw.cells[10].childNodes[0].value;
	var rowIndex	= rw.rowIndex;

	createXMLHttpRequest1(1);	
	xmlHttp1[1].onreadystatechange=ShowExtraRequest;
	xmlHttp1[1].originType = originType;
	xmlHttp1[1].category = category;
	xmlHttp1[1].open("GET",'editpopup.php?conpc=' +conpc+ '&wastage=' +wastage+ '&unitPrice=' +unitPrice+ '&finance=' +finance+ '&rowIndex=' +rowIndex ,true);
	xmlHttp1[1].send(null);
}

function ShowExtraRequest()
{
	if (xmlHttp1[1].readyState==4)
	{
		if (xmlHttp1[1].status==200)
		{
			drawPopupArea(450,135,'frmEditPopUp');				
			var HTMLText=xmlHttp1[1].responseText;
			document.getElementById('frmEditPopUp').innerHTML=HTMLText;
			document.getElementById('cboEditOrigin').value = xmlHttp1[1].originType;
			document.getElementById('cboEditCategory').value = xmlHttp1[1].category;			
		}
	}
}

function ViewReport(obj)
{
	var orderNo	= document.getElementById('strOrderNo').value;
	
	if(obj=='rdoReport1')
	{
		newwindow=window.open('invoicecost_report.php?orderNo='+orderNo+ '&ReportCat='+pub_reportCat,'rdoReport1'+pub_reportCat);
		if (window.focus) {newwindow.focus()}
	}
	else if(obj=='rdoReport2')
	{
		newwindow=window.open('invoicecost_report2.php?orderNo='+orderNo+ '&ReportCat='+pub_reportCat,'rdoReport2'+pub_reportCat);
		if (window.focus) {newwindow.focus()}
	}
	OpenReportPopUp();
}

function EditItem(obj)
{
	var tbl 			= document.getElementById('tblMain');
	var conPc			= RoundNumbers(document.getElementById('txtEditConPc').value,4);
	var unitPrice		= RoundNumbers(document.getElementById('txtEditUnitPrice').value,4);
	var finePercent 	= Math.round(document.getElementById('txtEditFinance').value)
	var value 			= conPc*unitPrice;
	var finValue  		= (value*finePercent)/100;
	
	tbl.rows[obj].cells[4].childNodes[0].value = conPc;
	tbl.rows[obj].cells[5].childNodes[0].value = Math.round(document.getElementById('txtEditWastage').value);
	tbl.rows[obj].cells[6].childNodes[0].value = unitPrice;
	tbl.rows[obj].cells[8].childNodes[0].nodeValue = finePercent;
	tbl.rows[obj].cells[2].childNodes[0].value 	   = document.getElementById('cboEditOrigin').value;
	tbl.rows[obj].cells[10].childNodes[0].value    = document.getElementById('cboEditCategory').value;
	tbl.rows[obj].cells[7].childNodes[0].nodeValue    = RoundNumbers(value,deci2);
	tbl.rows[obj].cells[9].childNodes[0].nodeValue    = RoundNumbers(finValue,4);
	closeWindow();
}

function OpenReportPopUp(obj)
{
	pub_reportCat = 1;
		document.getElementById('radio2').checked = true;
	 	document.getElementById('rdoReport1').checked = false;
	 	document.getElementById('rdoReport2').checked = false;
	if(document.getElementById('divReport').style.visibility == "hidden")
	{
		document.getElementById('divReport').style.visibility = "visible";
	}
	else
	{
		document.getElementById('divReport').style.visibility = "hidden";
	}
}

//Start - 31-10-2010 - Copy invoice costing detail to another Order No
function CopyInvoiceCosting()
{
	if(!CopyInvoiceCostingValidation())
		return;
	var sourceOrderNo = document.getElementById('cboCopySoOrderNo').value;	
	var targetOrderNo = document.getElementById('cboCopyTaOrderNo').value;
	var url = 'invoiceCost-xml.php?id=CopyInvoiceCosting&sourceOrderNo='+URLEncode(sourceOrderNo)+'&targetOrderNo='+URLEncode(targetOrderNo);
	RemoveAllRows('tblMain');
	createXMLHttpRequest1(1);
	xmlHttp1[1].onreadystatechange=loadCostDetailRequest;
	xmlHttp1[1].open("GET",url ,true);
	xmlHttp1[1].send(null);

	var url  = "invoiceCost-xml.php?id=URLGetOrderNo";
		url += "&TargetOrderNo="+URLEncode(targetOrderNo);
	var htmlobj=$.ajax({url:url,async:false});
	var targetOrderId	= htmlobj.responseText;
	
	
	document.getElementById("strOrderNo").innerHTML = "";
	var opt = document.createElement("option");
	opt.text = targetOrderNo;
	opt.value = targetOrderId;
	document.getElementById("strOrderNo").options.add(opt);	
		
	document.getElementById('strOrderNo').disabled = true;
	CopyPopUp();

	var url  = "invoiceCost-xml.php?id=loadCostHeader";
		url += "&cbointStyleId="+targetOrderId;
	var htmlobj=$.ajax({url:url,async:false});
	loadCostHeaderRequest(htmlobj);
}
function CopyInvoiceCostingValidation()
{
	if(document.getElementById('cboCopySoOrderNo').value=="")
	{
		alert("Please select the 'Sourse Order No'.");
		document.getElementById('cboCopySoOrderNo').focus();
		return false;
	}
	else if(document.getElementById('cboCopyTaOrderNo').value=="")
	{
		alert("Please select the 'Target Order No'.");
		document.getElementById('cboCopyTaOrderNo').focus();
		return false;
	}
	return true;
}
//End - 31-10-2010 - Copy invoice costing detail sto another Order No
function ChangeRowColor(obj,index)
{
	var rw = obj.parentNode.parentNode;
	if(rw.cells[10].childNodes[0].value=='1'){
		rw.className = "bcgcolor-InvoiceCostICNA";
		return;
	}
		
	if(index=='1')
		rw.className = "bcgcolor-InvoiceCostFabric";
	else if(index=='2')
		rw.className = "bcgcolor-InvoiceCostPocketing";
	else if(index=='3')
		rw.className = "bcgcolor-InvoiceCostTrim";
	else if(index=='4')
		rw.className = "bcgcolor-InvoiceCostService";
	else if(index=='5')
		rw.className = "bcgcolor-InvoiceCostOther";
}

function ChangeTypeRowColor(obj,index)
{
	var rw = obj.parentNode.parentNode;
	if(index=='1')
		rw.className = "bcgcolor-InvoiceCostICNA";
	else if(index=='0')
	{
		var index = rw.cells[11].childNodes[0].value;
		ChangeRowColor(obj,index)
	}
}
function SendToApproval()
{
	alert("'Send To Approval Process' is under construct.");
}
//01-11-2012-wash price popUp- lasa
function loadWashPrices(){
	pub_zIndex=0;
	var styId=document.getElementById('strOrderNo').value.trim();
	if(styId==""){
		alert("Please select 'Order No'.");	
		return false;
	}
	var url  = "invCostWashPrice.php?styId="+styId;
	inc('invoiceCost-java.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "tdHeader";
	var tdDelete = "tdDelete";
	var closePopUp = "closePrcPopUp";
	var tdPopUpClose = "prc_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}
function closePrcPopUp(id)
{
	//obj.parentNode.removeChild(obj);
	closePopUpArea(id);
}
function loadDryProcesses(tblPrc,styId){
	var url  = "invCostDryProcesses.php?styId="+styId;
	inc('invoiceCost-java.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "tdDrHeader";
	var tdDelete = "tdDelete";
	var closePopUp = "closeDryPrcPopUp";
	var tdPopUpClose = "dryPrc_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

function closeDryPrcPopUp(id)
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
function addToProcesses(tblDryPrc){
	var tblDryPrc=document.getElementById(tblDryPrc);
	var rCount=tblDryPrc.rows.length;
	for(var i=2;i<rCount;i++){
		if(tblDryPrc.rows[i].cells[0].childNodes[0].checked){
			var id=tblDryPrc.rows[i].cells[0].id;
			var desc=tblDryPrc.rows[i].cells[1].childNodes[0].nodeValue;
			addToMainTab(id,desc);
			
		}
	}
	closeDryPrcPopUp(pub_zIndex);
}
function addToMainTab(id,desc){
	var tblPrc=document.getElementById('tblPrc');	
	var rCnt=tblPrc.rows.length;
		for(var i=1;i<rCnt;i++){
			if(tblPrc.rows[i].cells[1].id==id){
				//alert(tblPrc.rows[i].cells[1].id+"="+id);
				return ;
			}
		}
	var rC="<td style=\"width:30px;\" class=\"\"><img src=\"../../images/del.png\" onclick=\"dltDet(this);\" /></td>";
		rC+="<td style=\"width:150px;text-align:left;\" class=\"\" id=\""+id+"\" >"+desc+"</td>";
		rC+="<td style=\"width:70px;\" class=\"\"><input type=\"text\" value=\"\" onkeypress=\"return CheckforValidDecimal(this.value, 2,event);\" style=\"text-align: right;width:50px;\" maxlength=\"10\" /></td>";
	var row = tblPrc.insertRow(rCnt);
	row.innerHTML=rC;
	arrRows(); 
	
}
function arrRows()
{
	var tblPrc=document.getElementById('tblPrc');	
	var rCnt=tblPrc.rows.length;
	var cls;
for(var i=1;i<rCnt;i++){
		(i%2==1)?cls="grid_raw":cls="grid_raw2";
		tblPrc.rows[i].cells[0].className=cls;
		tblPrc.rows[i].cells[1].className=cls;
		tblPrc.rows[i].cells[2].className=cls;
	}
}
function saveDryPrc(){
	var styId=document.getElementById('strOrderNo').value.trim();
	var tblPrc=document.getElementById('tblPrc');	
	var rCnt=tblPrc.rows.length;
	var cls;
	for(var i=1;i<rCnt;i++){
		//alert(i);
		var path="invoiceCost-db.php?id=addPrc&StyleId="+styId+"&ProcessId="+tblPrc.rows[i].cells[1].id+"&UnitPrice="+tblPrc.rows[i].cells[2].childNodes[0].value+"&tag="+i;
		var htmlobj=$.ajax({url:path,async:false});
	}
	
	if(htmlobj.responseText==1){
		alert("Successfully Added.")
		closePrcPopUp(1);
		return false ; 
		
	}
	else{
		return false;
		alert("");
	}
}	
function searchProcesses(){
	
	var path="invoiceCost-db.php?id=srcPrc&prc="+document.getElementById('txtDryPrcSrc').value.trim()+"&StyleId="+document.getElementById('strOrderNo').value.trim();
	var htmlobj=$.ajax({url:path,async:false});
	var tblRows=htmlobj.responseText;
	var tblDryPrc=document.getElementById('tblDryPrc').tBodies[0];
	tblDryPrc.innerHTML="";
	tblDryPrc.innerHTML=tblRows;
	//alert(tblRows);
}
function dltDet(obj){
	var styId=document.getElementById('strOrderNo').value.trim();
	var prcId=obj.parentNode.parentNode.cells[1].id;
	if(confirm("Are you sure you want to delete this ?"))
	{
		var path="invoiceCost-db.php?id=delPrc&prcId="+prcId+"&styId="+styId;
		var htmlobj=$.ajax({url:path,async:false});
		
		var tblMain = obj.parentNode.parentNode.parentNode;
		var rowNo = obj.parentNode.parentNode.rowIndex
		tblMain.deleteRow(rowNo);
		arrRows();
	}
}
//----------------end--------------

function ChangeAllOrigin(obj)
{
	var tblMain = document.getElementById('tblMain');
	for(var loop=1;loop<tblMain.rows.length;loop++)
	{
		tblMain.rows[loop].cells[2].childNodes[0].value = obj.value;
	}
}

//BEGIN - 19-05-2011
function OpenSearchPopUp()
{
	showBackGround('divBG',0);
	var url  = "popupsearch.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(80,75,'frmPopSearch',1);
	document.getElementById('frmPopSearch').innerHTML = htmlobj.responseText;
	document.getElementById('txtPopupOrderNo').focus();
	LoadOrderNoToPopUpSearch();
}

function CloseSearchPopup(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}

function LoadOrderNoToPopUpSearch()
{
	var url					= 'invoiceCost-xml.php?id=URLLoadOrderNoToPopUpSearch';
	var pub_xml_http_obj	= $.ajax({url:url,async:false});
	var pub_po_arr			= pub_xml_http_obj.responseText.split("|");
	
	$( "#txtPopupOrderNo" ).autocomplete({
		source: pub_po_arr
	});
}

function SetOrderNo(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode == 13)
	{
		var url  = "invoiceCost-xml.php?id=URLSetOrderNo";
		    url += "&OrderNo="+URLEncode($("#txtPopupOrderNo").val());
		var htmlobj=$.ajax({url:url,async:false});
		document.getElementById('strOrderNo').value = htmlobj.responseText;		
		document.getElementById('strOrderNo').onchange();
		CloseSearchPopup('popupLayer1');
	}
}
//END

//Start - 24-05-2011
function eventsetter()
{
	$('.txtbox.keymove').live('keydown', function(e) {
		var tbl 			= document.getElementById('tblMain');
		var rw				= tbl.parentNode.parentNode.parentNode;
		var keyCode 		= e.keyCode || e.which;
		var row_cell		= this.parentNode.cellIndex;
		var row_index		= this.parentNode.parentNode.rowIndex;
		$no=1;
		switch(keyCode)
		{			
			case 37: //left
				if(row_cell=='4')
					return;
				if(row_cell=='8')
					$no=2;
				row_cell  	= row_cell - $no; 
				break; 	
				
			case 38: //up
				row_index  	= row_index - $no; 
				break; 	
				
			case 39: //right
				if(row_cell=='8')
					return;
				if(row_cell=='6')
					$no=2;
				row_cell  	= row_cell + $no; 
				break; 		
				
			case 40: //down
				row_index 	= row_index + $no; 
				break; 
			
			default:
				return;
		}
		var val_row = tbl.rows.length;
			/*if(row_cell<1||row_cell>=start_auto_cell+10||row_index<0||row_index>=val_row)
				return;	*/
		if(row_index<1 || row_index>=val_row)
			return;
		tbl.rows[row_index].cells[row_cell].childNodes[0].focus();		
		tbl.rows[row_index].cells[row_cell].childNodes[0].select();
	});

}
//End - 24-05-2011

function ChangeReportCategory(obj)
{
	pub_reportCat = obj;
	
}

function OpenReportPopUp_List(obj)
{
	pub_ListRowIndex = obj.parentNode.parentNode.rowIndex;

	showBackGround('divBG',0);
	var url  = "popupreport.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(432,78,'frmPopupReport',1);
	document.getElementById('frmPopupReport').innerHTML = htmlobj.responseText;
	pub_reportCat	= 1;
}

function ViewReport_List(obj)
{
	var tbl = document.getElementById('tblInvoiceCostingList');
	var orderNo	= tbl.rows[pub_ListRowIndex].cells[0].id;
	
	if(obj=='rdoReport1')
	{
		newwindow=window.open('invoicecost_report.php?orderNo='+orderNo+ '&ReportCat='+pub_reportCat,'rdoReport1'+pub_reportCat);
		if (window.focus) {newwindow.focus()}
	}
	else if(obj=='rdoReport2')
	{
		newwindow=window.open('invoicecost_report2.php?orderNo='+orderNo+ '&ReportCat='+pub_reportCat,'rdoReport2'+pub_reportCat);
		if (window.focus) {newwindow.focus()}
	}
}

function loadInvoiceCosting()
{
	document.frmInvoiceCostingList.submit();
}

function RevisePO()
{
	var orderId	= document.getElementById('strOrderNo').value;
	if(orderId=="")
	{
		alert("Please select confirm Order No to revise.");
		return;
	}
	if(!confirm("Are you sure you want to revise Order No : "+$("#strOrderNo option:selected").text()+" ?"))
		return;
	if(!checkFirstSaleCostingAvailable())
	{
		var reason = prompt("Please enter revise reason", "");
		if(reason == '' || reason == null)
		{
			alert('Can not revise order without having a reason');
			return false;
		}
		var url  = "invoiceCost-db.php?id=URLRevisePO";
			url += "&OrderId="+orderId;
			url += "&reason="+URLEncode(reason)
		var htmlobj=$.ajax({url:url,async:false});
		if(htmlobj.responseText=="true")
		{
			alert("Revised successfully.");
			ValidateMainInterface(0);
		}
		else
		{
			alert("Revised process not completed");
		}
	}
}

function ValidateMainInterface(obj)
{
	if(obj=='0')
	{
		document.getElementById('popSearch').style.display="none";
		document.getElementById('cbointStyleId').disabled = true;
		document.getElementById('strOrderNo').disabled = true;
		if(confirmInvoiceCosting)
			document.getElementById("butConform").style.display="inline";
		document.getElementById('butRevise').style.display="none";
		document.getElementById('butSave').style.display="inline";
		document.getElementById('butCopy').style.display="inline";
	}
	else if(obj=='1')
	{
		document.getElementById("butSave").style.display="none";
		document.getElementById("butConform").style.display="none";
		if(PP_ReviseInvoiceCosting)
			document.getElementById('butRevise').style.display="inline";
		document.getElementById('butCopy').style.display="inline";
	}
	else if(obj=='10')
	{
		document.getElementById('cbointStyleId').disabled = true;
		document.getElementById('strOrderNo').disabled = true;
		if(confirmInvoiceCosting)
			document.getElementById("butConform").style.display="none";
		document.getElementById('popSearch').style.display="none";
		document.getElementById('butRevise').style.display="none";
		document.getElementById('butCopy').style.display="none";
	}
	else if(obj=='5')
	{
		document.getElementById('cbointStyleId').disabled = false;
		document.getElementById('strOrderNo').disabled = false;
		document.getElementById('popSearch').style.display="inline";
		document.getElementById('butRevise').style.display="none";
		document.getElementById('butCopy').style.display="none";
	}
	else
	{
		document.getElementById('cbointStyleId').disabled = false;
		document.getElementById('strOrderNo').disabled = false;
		document.getElementById("butSave").style.display="none";
		document.getElementById('popSearch').style.display="none";
		document.getElementById('butRevise').style.display="none";
		document.getElementById('butCopy').style.display="none";
	}
}

function LoadPOToPopUp()
{
	var url					= 'invoiceCost-xml.php?id=URLLoadSourceOrderNo';
	var pub_xml_http_obj	= $.ajax({url:url,async:false});
	var pub_po_arr			= pub_xml_http_obj.responseText.split("|");
	
	$( "#cboCopySoOrderNo" ).autocomplete({
		source: pub_po_arr
	});
	
		var url				= 'invoiceCost-xml.php?id=URLLoadTargetOrderNo';
	var pub_xml_http_obj	= $.ajax({url:url,async:false});
	var pub_po_arr			= pub_xml_http_obj.responseText.split("|");
	
	$( "#cboCopyTaOrderNo" ).autocomplete({
		source: pub_po_arr
	});
}

function OpenItemPopUp()
{
	if(!Validate_OpenItemPopUp())
		return;
	var orderNo = document.getElementById('strOrderNo').value;
	showBackGround('divBG',0);
	var url  = "popupitem.php?OrderNo="+orderNo;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(572,504,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	//fix_header('tblPopItem',550,388);
}

function AddItemToMainGrid(orderNo)
{
	var tblMain 	= document.getElementById('tblMain');
	var itemId		= '';
	var booFirst 	= true;
	
	var tblItem = document.getElementById('tblPopItem');
	for(var i=1;i<tblItem.rows.length;i++)
	{
		var booCheck 	= true;
		if(tblItem.rows[i].cells[0].childNodes[0].checked)
		{
			var itemId1		= tblItem.rows[i].cells[1].id;
			for(var loop=1;loop<tblMain.rows.length;loop++)
			{
				var mainItemId	= tblMain.rows[loop].cells[3].id;
				
				if(itemId1==mainItemId){
					booCheck = false;
				}
			}
			
			if((booFirst) && (booCheck))
			{
				itemId = tblItem.rows[i].cells[1].id;
				booFirst = false;
			}else if(booCheck)
				itemId += ","+tblItem.rows[i].cells[1].id;
		}		
	}
	
	createXMLHttpRequest1(1);
	xmlHttp1[1].onreadystatechange = loadCostDetailRequest;
	var url  = "invoiceCost-xml.php?id=URLAddItemToMainGrid&ItemId="+itemId+"&OrderNo="+orderNo;
	xmlHttp1[1].open("GET",url,true);
	xmlHttp1[1].send(null);
	
	CloseInvoiceCostPopUp('popupLayer1');
}

function CheckAll(obj,tbl)
{
	tbl = document.getElementById(tbl);
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].checked=obj.checked;
	}
}

function Validate_OpenItemPopUp()
{
	if(document.getElementById('strOrderNo').value.trim()=="")
	{
		alert("Please select the 'Order No'.");
		document.getElementById('strOrderNo').focus();
		return false;
	}
return true;
}
function isValidDeliveryScheduleAvailable()
{
	var orderId  	= document.getElementById("strOrderNo").value;
	var url = 'invoiceCost-db.php?id=validateDelDateBeforeConfirmInvCosting&orderId='+orderId;
	htmlobj=$.ajax({url:url,async:false});	
	if(htmlobj.responseText=='true')
		return true;
	else
	{
		alert(htmlobj.responseText);
		return false;
		}	
}
function checkFirstSaleCostingAvailable()
{
	var orderId  	= document.getElementById("strOrderNo").value;
	var url = 'invoiceCost-db.php?id=CheckFSCostingAvailability&orderId='+orderId;
	htmlobj=$.ajax({url:url,async:false});	
	if(htmlobj.responseText=='true')
	{
		alert(" You can't revise order \n First sale costing available for this order");
		return true;
	}	
	else
	{
		return false;
	}	
	
}

function ApproveInvoice(obj)
{
	var rw			= obj.parentNode.parentNode;
	var orderId  	= rw.cells[0].id;
	var url = 'invoiceCost-db.php?id=URLApproveInvoice&OrderId='+orderId;
	htmlobj=$.ajax({url:url,async:false});	
	if(htmlobj.responseText=='true')
	{
		alert("Approved successfully.");
		rw.cells[6].childNodes[1].hidden = true;
		return true;
	}	
	else
	{
		rw.cells[6].childNodes[1].hidden = false;
		//rw.cells[6].childNodes[1].innerHTML = '<img src=\"../../images/accept.png\" alt=\"approve\"  border=\"0\"  class=\"mouseover\" id=\"butApproved\" onclick=\"ApproveInvoice(this);\" />';
		return false;
	}	
	
}