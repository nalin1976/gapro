// JavaScript Document
var mainArrayIndex=0;
var Materials 			= [];
var popArrIndex=0;
var pub_sheduleNo=0;

//BEGIN - Main Item Grid Column Variable
var m_del 				= 0 ;	// Delete button
var m_dDate				= 1 ;	// Delivery Date
var m_hDate				= 2;	//handover Date
var m_order				= 3	;	// Order No
var m_style				= 4 ;	// Style no
var m_Oqty				= 5	;	// orderQty
var m_DQty				= 6 ; 	// Delivery Qty
var m_sQty				= 7 ; 	// sea Qty
//var m_aQty				= 8	;	// air Qty
var m_balQty			= 8 ; 	// bal Qty
var m_rmk				= 9;    // remarks

//END - Main Item Grid Column Variable
//load delivery date popup
var url = "delDatePopup.php?";
htmlobj=$.ajax({url:url,async:false});
var popHTML = htmlobj.responseText;

function addDeliverySchedules()
{
	var shipMonth = document.getElementById('cbomonth').value;
	if(shipMonth == '')
	{
		alert("Please select Month");
		return false;
	}
	
	showBackGround('divBG',0);
	chkMonthShipScheduleAv();
	
	drawPopupBox(700,260,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = popHTML;
}

function CloseOSPopUp(LayerId)
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
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}
function loadDeliverySchedules()
{
	document.getElementById('chkDelAll').checked = false;
	var dfrom = document.getElementById('txtPopupDfrom').value;
	var dTo   = document.getElementById('txtPopupDTo').value;
	var url = 'monthShipScheduleDb.php?RequestType=getOrderDelSchedule&dfrom='+URLEncode(dfrom)+'&dTo='+URLEncode(dTo);
	htmlobj=$.ajax({url:url,async:false});
	CreatePopUpItemGrid(htmlobj);
}
function CreatePopUpItemGrid(htmlobj)
{
	var XMLDelDate 	= htmlobj.responseXML.getElementsByTagName("deliveryDate");
	var XMLDelDateId = htmlobj.responseXML.getElementsByTagName("dateDateId");
	var XMLDelQty 	= htmlobj.responseXML.getElementsByTagName("deliveryQty");
	var styleId 	=  htmlobj.responseXML.getElementsByTagName("intStyleId");
	var styleNo 	=  htmlobj.responseXML.getElementsByTagName("strStyle");
	var orderNo 	=  htmlobj.responseXML.getElementsByTagName("strOrderNo");
	var orderQty	=  htmlobj.responseXML.getElementsByTagName("orderQty");
	
	var tbl 		= document.getElementById('popupDelSchedule');
	ClearTable('popupDelSchedule');
	for(loop=0;loop<XMLDelDateId.length;loop++)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
		
		var cell = row.insertCell(0);
		cell.className ="normalfntMid";
		cell.setAttribute('height','20');
		cell.innerHTML = "<input name=\"checkbox\" type=\"checkbox\">";
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.id = XMLDelDateId[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLDelDateId[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(2);
		cell.className ="normalfntRite";
		cell.innerHTML = XMLDelQty[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(3);
		cell.className ="normalfntRite";
		cell.innerHTML = orderQty[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(4);
		cell.className ="normalfnt";
		cell.innerHTML = styleNo[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(5);
		cell.className ="normalfnt";
		cell.id = styleId[loop].childNodes[0].nodeValue;
		cell.innerHTML = orderNo[loop].childNodes[0].nodeValue;
	}
}

function CheckAll(obj,tbl)
{
	var tbl  = document.getElementById(tbl);
	if(obj.checked)
		var check = true;
	else 
		var check = false;
	for(i=1;i<tbl.rows.length;i++)	
	{
		tbl.rows[i].cells[0].childNodes[0].checked = check;
	}
}

function addItemToMainGrid()
{
	var popTbl = document.getElementById('tblPopItems');
	var delId=0;
	for(var loop=1;loop<popTbl.rows.length;loop++)
	{
		var styleId =  popTbl.rows[loop].cells[7].id;
		var delDate = popTbl.rows[loop].cells[3].id;
		var deliveryDate = popTbl.rows[loop].cells[3].innerHTML;
		var orderNo = popTbl.rows[loop].cells[7].innerHTML;
		var styleNo = popTbl.rows[loop].cells[6].innerHTML;
		var orderQty =  popTbl.rows[loop].cells[5].innerHTML;
		var delQty = popTbl.rows[loop].cells[4].innerHTML;
		var HOdate = popTbl.rows[loop].cells[2].innerHTML;
		var chk = popTbl.rows[loop].cells[0].childNodes[0].checked;
		var seaQty=0;
		var airQty=0;
		var remarks='';
		if(chk)
		{
			if(!ValidateMainGridData(styleId,delDate,HOdate))
			continue;
			else
			 createMainGrid(styleId,delDate,deliveryDate,HOdate,orderNo,styleNo,orderQty,delQty,seaQty,remarks,delId)	
		}
		
	}
}

function createMainGrid(styleId,delDate,deliveryDate,HOdate,orderNo,styleNo,orderQty,delQty,seaQty,remarks,delId)
{
	var tbl 	= document.getElementById('tblMainGrid');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";
	
	var cell = row.insertCell(m_del);
	cell.className ="normalfntMid";
	cell.setAttribute('height','20');
	cell.id= delId;
	cell.innerHTML = "<img alt=\"add\" src=\"../../../images/del.png\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" >";
	
	var cell = row.insertCell(m_dDate);
	cell.className ="normalfnt";
	cell.id = delDate;
	cell.innerHTML = deliveryDate;
	
	var cell = row.insertCell(m_hDate);
	cell.className ="normalfnt";
	cell.innerHTML = HOdate;
	
	var cell = row.insertCell(m_order);
	cell.className ="normalfnt";
	cell.id = styleId;
	cell.innerHTML = orderNo;
	
	var cell = row.insertCell(m_style);
	cell.className ="normalfnt";
	cell.innerHTML = styleNo;
	
	var cell = row.insertCell(m_Oqty);
	cell.className ="normalfntRite";
	cell.innerHTML = orderQty;
	
	var cell = row.insertCell(m_DQty);
	cell.className ="normalfntRite";
	cell.id=mainArrayIndex;
	cell.innerHTML = delQty;
	
	var cell = row.insertCell(m_sQty);
	cell.className ="normalfnt";
	cell.innerHTML = "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 70px; text-align: right;\" class=\"txtbox\"  value=\""+seaQty+"\" onkeyup=\"validateSeaQty(this,"+mainArrayIndex+");\" >";
	
	/*var cell = row.insertCell(m_aQty);
	cell.className ="normalfnt";
	cell.innerHTML = "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 70px; text-align: right;\" class=\"txtbox\"  value=\""+airQty+"\" onkeyup=\"validateAirQty(this,"+mainArrayIndex+");\"  >";
	*/
	var cell = row.insertCell(m_balQty);
	cell.className ="normalfntRite";
	cell.innerHTML = '';
	
	var cell = row.insertCell(m_rmk);
	cell.className ="normalfnt";
	cell.innerHTML = "<input type=\"text\" value=\""+remarks+"\" onkeyup=\"setValueToArray(this,"+mainArrayIndex+");\"  >";
	
	var details = [];
		details[0] = styleId; 	// styleId
		details[1] = delDate; 	// delDate Id
		details[2] = HOdate ;	// Hand Over date
		details[3] = delQty; 	// delivery Qty
		details[4] = seaQty; 	// sea Qty
		//details[5] = airQty; 	// air Qty
		details[6] = remarks; 		//remarks
		details[7] = delId; 		//check new record or already available record	
		Materials[mainArrayIndex] = details;
		mainArrayIndex ++ ;
}

function ValidateMainGridData(styleId,delDate,HOdate)
{
	var tbl =  document.getElementById('tblMainGrid');
	for(var i=1;i<tbl.rows.length;i++)
	{
		var mainStyleId = tbl.rows[i].cells[3].id;
		var mainDelDate = tbl.rows[i].cells[1].id;
		var mainHOdate  = tbl.rows[i].cells[2].innerHTML;
		if(mainStyleId==styleId && mainDelDate==delDate && mainHOdate==HOdate)
			return false;
	}
	return true;
}

function addItemToItemGrid()
{
	var HOdate = document.getElementById('txtPopupHOdate').value;
	if(HOdate == '')
	{
		alert("Please select 'Hand Over Date'");
		document.getElementById('txtPopupHOdate').focus();
		return;
	}
	var tblDel = document.getElementById('popupDelSchedule');
	for(var i=1;i<tblDel.rows.length;i++)
	{
		var chk = tblDel.rows[i].cells[0].childNodes[0].checked;
		if(chk)
		{
			var deldate = tblDel.rows[i].cells[1].id;
			var styleId = tblDel.rows[i].cells[5].id;
			var StyleName = tblDel.rows[i].cells[4].innerHTML;
			var orderNo  = tblDel.rows[i].cells[5].innerHTML;
			var delQty = tblDel.rows[i].cells[2].innerHTML;
			var orderQty = tblDel.rows[i].cells[3].innerHTML;
			
			if(!ValidatePopItem(styleId,deldate,HOdate))
				continue;
			else
				createPopItem(styleId,deldate,HOdate,StyleName,orderNo,delQty,orderQty)
		}
	}
}

function ValidatePopItem(styleId,deldate,HOdate)
{
	var tbl =  document.getElementById('tblPopItems');
	for(var i=1;i<tbl.rows.length;i++)
	{
		var mainStyleId = tbl.rows[i].cells[7].id;
		var mainDelDate = tbl.rows[i].cells[3].id;
		var mainHOdate  = tbl.rows[i].cells[2].innerHTML;
		
		if(mainStyleId==styleId && mainDelDate==deldate && mainHOdate==HOdate)
			return false;
	}
	return true;	
}

function createPopItem(styleId,deldate,HOdate,StyleName,orderNo,delQty,orderQty)
{
	var tbl = document.getElementById('tblPopItems');
	var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
		
		var cell = row.insertCell(0);
		cell.className ="normalfntMid";
		cell.setAttribute('height','20');
		cell.innerHTML = "<input name=\"checkbox\" type=\"checkbox\" checked>";
		
		var cell = row.insertCell(1);
		cell.className ="normalfntMid";
		cell.innerHTML = "<img alt=\"add\" src=\"../../../images/del.png\" onclick=\"RemoveItemPop(this,"+popArrIndex+");\" >";
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.innerHTML = HOdate;
		
		var cell = row.insertCell(3);
		cell.className ="normalfnt";
		cell.id = deldate;
		cell.innerHTML = deldate;
		
		var cell = row.insertCell(4);
		cell.className ="normalfntRite";
		cell.innerHTML = delQty;
		
		var cell = row.insertCell(5);
		cell.className ="normalfntRite";
		cell.innerHTML = orderQty;
		
		var cell = row.insertCell(6);
		cell.className ="normalfnt";
		cell.innerHTML = StyleName;
		
		var cell = row.insertCell(7);
		cell.className ="normalfnt";
		cell.id = styleId;
		cell.innerHTML = orderNo;	
		
		popArrIndex++;
}
function RemoveItem(obj,index)
{
	
		var td 	= obj.parentNode;
		var tro = td.parentNode;
		var id = tro.cells[0].id;
		/*if(id==1)
		{*/
			var delDate = tro.cells[1].id;
			var hoDate = tro.cells[2].innerHTML;
			var styleId = tro.cells[3].id;
			var delQty = tro.cells[6].innerHTML;
			var scheduleNo = document.getElementById('txtScheduleNo').value;
			
			var url = "monthShipScheduleDb.php?RequestType=deleteScheduleDetailItems&scheduleNo="+URLEncode(scheduleNo)+"&delDate="+URLEncode(delDate)+"&hoDate="+URLEncode(hoDate)+"&styleId="+styleId+"&delQty="+delQty;
			htmlobj=$.ajax({url:url,async:false});
			
			var result = htmlobj.responseText;
			if(result!='0')
			{
				alert('Monthly Schedule detail already allocate for weekly shipment schedule');
				return;
			}
		//}
		tro.parentNode.removeChild(tro);	
		Materials[index] = null;	

}
function RemoveItemPop(obj,index)
{
	
		var td 	= obj.parentNode;
		var tro = td.parentNode;
		tro.parentNode.removeChild(tro);	
		//Materials[index] = null;	

}
function validateSeaQty(obj,index)
{
	var rw 			= obj.parentNode.parentNode;
	var styleId 	= rw.cells[m_order].id;
	var seaQty 		= obj.value;
	seaQty 	= (seaQty ==''?0:parseFloat(seaQty));
	/*var airQty		= rw.cells[m_aQty].childNodes[0].value;
	airQty = (airQty==''?0:parseFloat(airQty));
	var delQty		= parseFloat(rw.cells[m_DQty].innerHTML);
	var totQty      = airQty+seaQty;
	if(totQty>delQty)
	{
		seaQty 	= delQty-airQty;
		rw.cells[m_balQty].innerHTML = 0;
	}
	else
	{
		rw.cells[m_balQty].innerHTML = delQty-totQty;	
	}*/
	var delQty		= parseFloat(rw.cells[m_DQty].innerHTML);
	var POalloQty   = parseFloat(getPOQty(styleId));
	
	var balQty = delQty -POalloQty;
	if(balQty<0)
	{
		obj.value=0;
		POalloQty   = parseFloat(getPOQty(styleId));
		balQty = delQty -POalloQty;
		rw.cells[m_balQty].innerHTML = 0;	
	}
	else
	{
		balQty=seaQty
		rw.cells[m_balQty].innerHTML = delQty-POalloQty;	
	}
	obj.value = balQty;
	Materials[index][4] = balQty;
	
}
function getPOQty(styleId)
{
	var totQty =0;
	var tbl = document.getElementById('tblMainGrid');
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		var styleNo = tbl.rows[loop].cells[m_order].id;
				
		if(styleId==styleNo)
			totQty += parseFloat(tbl.rows[loop].cells[m_sQty].childNodes[0].value);
	}
	return totQty;
}
function validateAirQty(obj,index)
{
	var rw 			= obj.parentNode.parentNode;
	var seaQty 		= rw.cells[m_sQty].childNodes[0].value;
	seaQty = (seaQty==''?0:parseFloat(seaQty));
	var airQty		= obj.value;
	airQty = (airQty==''?0:parseFloat(airQty));
	var delQty		= parseFloat(rw.cells[m_DQty].innerHTML);
	var totQty      = airQty+seaQty;
	if(totQty>delQty)
	{
		airQty 	= delQty-seaQty;
		rw.cells[m_balQty].innerHTML = 0;
	}
	else
	{
		rw.cells[m_balQty].innerHTML = delQty-totQty;	
	}
	obj.value = airQty;
	Materials[index][5] = airQty;
	
}
function setValueToArray(obj,index)
{
	Materials[index][6] = obj.value;
}

function saveShipSchedule()
{
	showBackGroundBalck();
	var month = document.getElementById('cbomonth').value;
	var s_year = document.getElementById('cboYear').value;
	var sheduleNo = document.getElementById('txtScheduleNo').value;
	
	if(month == '')
	{
		alert('Select Month ');
		document.getElementById('cbomonth').focus();
		return;
	}
	var tbl = document.getElementById('tblMainGrid');
	var rwCount = tbl.rows.length;
	if(rwCount==1)
	{
	 	alert('No details appear to save.');
		return;
	}
	
	if(sheduleNo=='')
	{
		getSheduleNo(month,s_year);
		saveHeaderData(month,s_year);
		saveDetails();
	}
	else
	{
		var sNo = sheduleNo.split("/");
		pub_sheduleNo = parseInt(sNo[0]);
		saveDetails();
	}
	loadCombo("select intScheduleNo,strMonthSheduleNo from finishing_month_schedule_header where intStatus=0 " +
			"  order by strMonthSheduleNo desc",'cboScheduleNo');
	alert("Saved successfully");
	hideBackGroundBalck();
}

function getSheduleNo(month,s_year)
{
		
	var url = 'monthShipScheduleDb.php?RequestType=getShipSheduleNo';
	htmlobj=$.ajax({url:url,async:false});
	
	var m_shipNo = htmlobj.responseXML.getElementsByTagName("monthShipNo")[0].childNodes[0].nodeValue;
	
	pub_sheduleNo = m_shipNo;
	 document.getElementById('txtScheduleNo').value = m_shipNo+'/'+month+'/'+s_year;
}

function saveHeaderData(s_month,s_year)
{
	var url = 'monthShipScheduleDb.php?RequestType=SaveScheduleHeader&s_month='+s_month+'&s_year='+s_year+'&pub_sheduleNo='+pub_sheduleNo;
	htmlobj=$.ajax({url:url,async:false});
}

function saveDetails()
{
	/*var url_d = 'monthShipScheduleDb.php?RequestType=deleteScheduleDetails&pub_sheduleNo='+pub_sheduleNo;
	htmlobj_D =$.ajax({url:url_d,async:false});*/
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{	
		var details = Materials[loop] ;
		if 	(details!=null)
		{			
			var styleId		= details[0]; 	// styleId Id
			var delDate		= details[1]; 	// delDate Id
			var HOdate		= details[2];	// HOdate
			var delQty		= details[3]; 	// delQty
			var seaQty		= details[4];	// seaQty
			//var airQty		= details[5];	// airQty
			var remarks     = details[6];   //remarks
			var id			= details[7];  //check already save record or new record
			var url = 'monthShipScheduleDb.php?RequestType=SaveScheduleDetails&pub_sheduleNo='+pub_sheduleNo+'&styleId='+styleId+'&delDate='+delDate+'&HOdate='+HOdate+'&delQty='+delQty+'&seaQty='+seaQty+'&remarks='+URLEncode(remarks)+'&id='+id;
			htmlobj=$.ajax({url:url,async:false});
		}
	}
	 document.getElementById('butConfirm').style.display = 'inline';
}
function clearPage()
{
	$("#frmMnthSchedule")[0].reset();
	ClearTable('tblMainGrid');
	Materials = [];
	mainArrayIndex 	= 0;
	loadCombo("select intScheduleNo,strMonthSheduleNo from finishing_month_schedule_header where intStatus=0 " +
			"  order by strMonthSheduleNo desc",'cboScheduleNo');
	document.getElementById('butConfirm').style.display = 'none'
}
function loadPendingScheduleData()
{
	ClearTable('tblMainGrid');
	var scheduleNo = $("#cboScheduleNo option:selected").text();
	document.getElementById('txtScheduleNo').value = scheduleNo
	var sNo = scheduleNo.split("/");
	var intScheduleNo = parseInt(sNo[0]);
	document.getElementById('cbomonth').value = parseInt(sNo[1]);
	document.getElementById('cboYear').value = parseInt(sNo[2]);
	loadScheduleDetails(intScheduleNo);
}
function loadScheduleDetails(intScheduleNo)
{
	var url = 'monthShipScheduleDb.php?RequestType=getPendingScheduleData&intScheduleNo='+intScheduleNo;
	htmlobj=$.ajax({url:url,async:false});
	var xmlStyleId = htmlobj.responseXML.getElementsByTagName("intStyleId");
	Materials = [];
	mainArrayIndex 	= 0;
	var delId=1;
	for(loop=0;loop<xmlStyleId.length;loop++)
	{
		var styleId = htmlobj.responseXML.getElementsByTagName("intStyleId")[loop].childNodes[0].nodeValue;
		var delDate = htmlobj.responseXML.getElementsByTagName("dtmDeliveryDate")[loop].childNodes[0].nodeValue;
		var deliveryDate = htmlobj.responseXML.getElementsByTagName("dtmDeliveryDate")[loop].childNodes[0].nodeValue;
		var HOdate = htmlobj.responseXML.getElementsByTagName("dtmHODate")[loop].childNodes[0].nodeValue;
		var orderNo = htmlobj.responseXML.getElementsByTagName("strOrderNo")[loop].childNodes[0].nodeValue;
		var styleNo = htmlobj.responseXML.getElementsByTagName("strStyle")[loop].childNodes[0].nodeValue;
		var orderQty = htmlobj.responseXML.getElementsByTagName("orderQty")[loop].childNodes[0].nodeValue;
		var delQty = htmlobj.responseXML.getElementsByTagName("dblDelQty")[loop].childNodes[0].nodeValue;
		var seaQty = htmlobj.responseXML.getElementsByTagName("seaQty")[loop].childNodes[0].nodeValue;
		//var airQty = htmlobj.responseXML.getElementsByTagName("airQty")[loop].childNodes[0].nodeValue;
		var remarks = htmlobj.responseXML.getElementsByTagName("strRemarks")[loop].childNodes[0].nodeValue;
		createMainGrid(styleId,delDate,deliveryDate,HOdate,orderNo,styleNo,orderQty,delQty,seaQty,remarks,delId)
	}
	 document.getElementById('butConfirm').style.display = 'inline';
}
function openReport()
{
	var path = "monthShipScheduleRpt.php?intScheduleNo="+URLEncode(document.getElementById("txtScheduleNo").value);
	window.open(path,'frmMnthSchedule');	
}
function OpenConfirmScheduleRpt()
{
	document.getElementById('butConfirm').style.display = 'none';
	var path = "monthSchedConfirmRpt.php?intScheduleNo="+URLEncode(document.getElementById("txtScheduleNo").value);
	window.open(path,'frmMnthSchedule');	
}
function confirmMonthSchedule(sno,intYear,intMonth)
{
	
	var url = "monthShipScheduleDb.php?RequestType=confirmMonthSchedule&intScheduleNo="+sno;
	htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseText== '1')
		{
			var path = "monthShipScheduleRpt.php?intScheduleNo="+URLEncode(sno+'/'+intMonth+'/'+intYear);
	window.open(path,'frmMnthSchedule');	
			}
}

function chkMonthShipScheduleAv()
{
	var sMonth = document.getElementById('cbomonth').value;
	var url = "monthShipScheduleDb.php?RequestType=checkScheduleDetails&sMonth="+sMonth;
		url += "&sYear="+document.getElementById('cboYear').value;
	htmlobj=$.ajax({url:url,async:false});
	
	var numrows = htmlobj.responseXML.getElementsByTagName("numRows")[0].childNodes[0].nodeValue;
	if(numrows>0)
	{
		var scheduleNo = htmlobj.responseXML.getElementsByTagName("monthSheduleNo")[0].childNodes[0].nodeValue;
		document.getElementById('txtScheduleNo').value = scheduleNo;
		var sNo = scheduleNo.split("/");
	var intScheduleNo = parseInt(sNo[0]);
	ClearTable('tblMainGrid');
	loadScheduleDetails(intScheduleNo);
	}
}