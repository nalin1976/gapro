// JavaScript Document
var mainArrayIndex=0;
var Materials 			= [];
var pub_WksheduleNo=0;
//BEGIN - Main Item Grid Column Variable
var m_del 				= 0 ;	// Delete button
var m_order				= 1	;	// Order No
var m_style				= 2 ;	// Style no
var m_dest				= 3 ;	// Destination
var m_Oqty				= 4	;	// orderQty
var m_mode				= 5 ; 	// mode
var m_ctn				= 6 ; 	// Cartoon Qty
var m_pcs				= 7	;	//  Qty Pcs
var m_isd				=8; // ISD NO
var m_dcN0				= 9; //DC No
var m_doNo				=10; //DO No
//END - Main Item Grid Column Variable
function loadMonthScheduleData()
{
	var dfrom =  document.getElementById('txtDfrom').value;
	var dTo = document.getElementById('txtDto').value;
	if(dfrom == '')
	{
		alert("Please select 'Date From'");
		document.getElementById('txtDfrom').focus();
		return;
	}
	if(dTo == '')
	{
		alert("Please select 'Date To'");
		document.getElementById('txtDto').focus();
		return;
	}
	showBackGround('divBG',0);
	checkWkScheduleAv();
	var url = "weekShipPopup.php?";
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(600,260,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
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
function loadMonthScheduleDetails()
{
	var scheduleNo = document.getElementById('cboPopMonthScheduleNo').value;
	var url = 'weekShipScheduledb.php?RequestType=getMonthScheduleData&scheduleNo='+scheduleNo;
	htmlobj=$.ajax({url:url,async:false});
	ClearTable('popupMonthSchedule');
	var XMLDelDate 	= htmlobj.responseXML.getElementsByTagName("deliveryDate");
	var XMLHOdate  = htmlobj.responseXML.getElementsByTagName("HOdate");
	var XMLstrType 	= htmlobj.responseXML.getElementsByTagName("strType");
	var XMLMode		= htmlobj.responseXML.getElementsByTagName("mode");
	var XMLstyleId 	=  htmlobj.responseXML.getElementsByTagName("intStyleId");
	var XMLstyleNo 	=  htmlobj.responseXML.getElementsByTagName("strStyle");
	var XMLorderNo 	=  htmlobj.responseXML.getElementsByTagName("strOrderNo");
	var XMLQty	=  htmlobj.responseXML.getElementsByTagName("dblQty");
	var XMLScheduleDetailId	=  htmlobj.responseXML.getElementsByTagName("ScheduleDetailId");
	
	for(loop=0;loop<XMLstyleId.length;loop++)
	{
		var styleId = XMLstyleId[loop].childNodes[0].nodeValue;
		var orderNo = XMLorderNo[loop].childNodes[0].nodeValue;
		var ScheduleDetailId = XMLScheduleDetailId[loop].childNodes[0].nodeValue;
		var styleNo = XMLstyleNo[loop].childNodes[0].nodeValue;
		var HOdate = XMLHOdate[loop].childNodes[0].nodeValue;
		var DelDate = XMLDelDate[loop].childNodes[0].nodeValue;
		var strType = XMLstrType[loop].childNodes[0].nodeValue;
		var mode = XMLMode[loop].childNodes[0].nodeValue;
		var Qty = XMLQty[loop].childNodes[0].nodeValue;
		
		createPopupItemGrid(styleId,orderNo,styleNo,ScheduleDetailId,HOdate,DelDate,strType,mode,Qty);
	}
	//createPopupItemGrid(htmlobj);
}
function createPopupItemGrid(styleId,orderNo,styleNo,ScheduleDetailId,HOdate,DelDate,strType,mode,Qty)
{	
	var tbl 		= document.getElementById('popupMonthSchedule');

		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
		
		var cell = row.insertCell(0);
		cell.className ="normalfntMid";
		cell.setAttribute('height','20');
		cell.innerHTML = "<input name=\"checkbox\" type=\"checkbox\">";
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.id = styleId;
		cell.innerHTML = orderNo;
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.id=ScheduleDetailId;
		cell.innerHTML = styleNo;
		
		var cell = row.insertCell(3);
		cell.className ="normalfnt";
		cell.innerHTML = HOdate;
		
		var cell = row.insertCell(4);
		cell.className ="normalfnt";
		cell.innerHTML = DelDate;
		
		var cell = row.insertCell(5);
		cell.className ="normalfnt";
		cell.id		= 	strType;
		cell.innerHTML = mode;
		
		var cell = row.insertCell(6);
		cell.className ="normalfntRite";
		cell.innerHTML = Qty;
	
}

function addToMainGrid()
{
	var city = 	document.getElementById('cboPopupDestination').value;
	var strCity = $("#cboPopupDestination option:selected").text();
	var tbl = document.getElementById('popupMonthSchedule');
	var type='Additem';
	var isdNo= document.getElementById('txtISDNo').value;
	var dcNo = document.getElementById('txtDCNo').value;
	var doNo = document.getElementById('txtDONo').value;
	
	if(!validateInterfaceData(type,tbl,city))
		return;
	
	var Qty_ctn =0;
	var Qty_pcs =0;
	var delId=0;
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		var styleId =  tbl.rows[loop].cells[1].id;
		var delDate = tbl.rows[loop].cells[4].innerHTML;
		var orderNo = tbl.rows[loop].cells[1].innerHTML;
		var styleNo = tbl.rows[loop].cells[2].innerHTML;
		var Qty =  tbl.rows[loop].cells[6].innerHTML;
		var chk = tbl.rows[loop].cells[0].childNodes[0].checked;
		var modeId = tbl.rows[loop].cells[5].childNodes[0].selectedIndex;
		var shipMode = tbl.rows[loop].cells[5].childNodes[0].childNodes[modeId].text;
		
		var mnthScheduleDetailId = tbl.rows[loop].cells[2].id;
		if(chk)
		{
			if(!ValidateMainGridData(styleId,city,modeId))
			continue;
			else
			 createMainGrid(styleId,orderNo,styleNo,city,strCity,Qty,modeId,Qty_ctn,Qty_pcs,mnthScheduleDetailId,delId,isdNo,dcNo,doNo,shipMode);	
		}
		
	}
}

function validateInterfaceData(type,tbl,obj1)
{
	if(type == 'Additem')
	{
		if(obj1 == '')
		{
			alert("Please select 'Destination'");
			document.getElementById('cboPopupDestination').focus();
			return;
		}
		var count=0;
		var Shipmode=0;
		for(var loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				count++;
				if(tbl.rows[loop].cells[5].id == 'null')
				Shipmode++;
			}
				
			
			
		}
		if(count==0)
		{
			alert("Please select item(s) to add main grid");
			return;
		}
		if(Shipmode>0)
		{
			alert("Please select Mode to add main grid");
			return;
		}
	}
	return true;
}
function ValidateMainGridData(styleId,city,mode)
{
	var tbl =  document.getElementById('tblMainGrid');
	for(var i=1;i<tbl.rows.length;i++)
	{
		var mainStyleId = tbl.rows[i].cells[1].id;
		var mainDest = tbl.rows[i].cells[3].id;
		var mainMode =tbl.rows[i].cells[5].id; 
		if(mainStyleId==styleId && mainDest==city && mainMode==mode)
			return false;
	}
	return true;		
}
function setComboVal(obj)
{
	obj.parentNode.parentNode.cells[5].id = obj.value;
}
function createMainGrid(styleId,orderNo,styleNo,city,strCity,Qty,modeId,Qty_ctn,Qty_pcs,mnthScheduleDetailId,delId,isdNo,dcNo,doNo,shipMode)
{
	var tbl 	= document.getElementById('tblMainGrid');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";
	
	var cell = row.insertCell(m_del);
	cell.className ="normalfntMid";
	cell.setAttribute('height','20');
	cell.id = delId;
	cell.innerHTML = "<img alt=\"add\" src=\"../../../images/del.png\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" >";
	
	var cell = row.insertCell(m_order);
	cell.className ="normalfnt";
	cell.id = styleId;
	cell.innerHTML = orderNo;
	
	var cell = row.insertCell(m_style);
	cell.className ="normalfnt";
	cell.id	=mnthScheduleDetailId;
	cell.innerHTML = styleNo;
	
	var cell = row.insertCell(m_dest);
	cell.className ="normalfnt";
	cell.id = city;
	cell.innerHTML = strCity;
	
	var cell = row.insertCell(m_Oqty);
	cell.className ="normalfntRite";
	cell.innerHTML = Qty;
	
	var cell = row.insertCell(m_mode);
	cell.className ="normalfnt";
	cell.id = modeId;
	cell.innerHTML = shipMode;
	
	var cell = row.insertCell(m_ctn);
	cell.className ="normalfnt";
	cell.innerHTML = "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 70px; text-align: right;\" class=\"txtbox\"  value=\""+Qty_ctn+"\" onkeyup=\"SetDetailsToArray(this,"+mainArrayIndex+");\" >";
	
	var cell = row.insertCell(m_pcs);
	cell.className ="normalfnt";
	cell.innerHTML = "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 70px; text-align: right;\" class=\"txtbox\"  value=\""+Qty_pcs+"\" onkeyup=\"validateQtyPcs(this,"+mainArrayIndex+");\"  >";
	
	var cell = row.insertCell(m_isd);
	cell.className ="normalfnt";
	cell.innerHTML = "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 70px; text-align: right;\" class=\"txtbox\"  value=\""+isdNo+"\" onkeyup=\"SetDetailsToArray(this,"+mainArrayIndex+");\"  >";
	
	var cell = row.insertCell(m_dcN0);
	cell.className ="normalfnt";
	cell.innerHTML = "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 70px; text-align: right;\" class=\"txtbox\"  value=\""+dcNo+"\" onkeyup=\"SetDetailsToArray(this,"+mainArrayIndex+");\"  >";
	
	var cell = row.insertCell(m_doNo);
	cell.className ="normalfnt";
	cell.innerHTML = "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 70px; text-align: right;\" class=\"txtbox\"  value=\""+doNo+"\" onkeyup=\"SetDetailsToArray(this,"+mainArrayIndex+");\"  >";
	
	var details = [];
	details[0] = styleId; 	// styleId
	details[1] = city; 	// city Id
	details[2] = Qty ;	// order qty
	details[3] = modeId; 	// Mode
	details[4] = Qty_ctn; 	// Qty cartoon
	details[5] = Qty_pcs; 	//  Qty Pcs
	details[6] = mnthScheduleDetailId; 	// Monthly shipment Schedule details id
	details[7] = delId;
	details[8] = isdNo;	 	
	details[9] = dcNo;	 	
	details[10] = doNo;	 	
			
	Materials[mainArrayIndex] = details;
	mainArrayIndex ++ ;
}
function RemoveItem(obj,index)
{
	
		var td 	= obj.parentNode;
		var tro = td.parentNode;
		/*if(td.id !=0)
		{*/
			var url="weekShipScheduledb.php?RequestType=deleteWkScheduleDetails&Sno="+td.id;
			htmlobj=$.ajax({url:url,async:false});
		//}
		
		tro.parentNode.removeChild(tro);	
		Materials[index] = null;	

}
function SetDetailsToArray(obj,index)
{
	var rw 			= obj.parentNode.parentNode;
	var Qty_ctn 	= rw.cells[m_ctn].childNodes[0].value;
	var isdNo		= rw.cells[m_isd].childNodes[0].value;
	var dcNo		= rw.cells[m_dcN0].childNodes[0].value;
	var doNo		= rw.cells[m_doNo].childNodes[0].value;
	
	Materials[index][4] = Qty_ctn;
	Materials[index][8] = isdNo;
	Materials[index][9] = dcNo;
	Materials[index][10] = doNo;
	//Materials[index][5] = Qty_pcs;
	
}
function validateQtyPcs(obj,index)
{
	var rw 			= obj.parentNode.parentNode;
	var styleId 	= rw.cells[m_order].id;
	var mode		= rw.cells[m_mode].id;
	var QtyPcs = parseFloat(obj.value);
	
	var Alloqty = parseFloat(getPOQty(styleId,mode));
	var POqty 	= parseFloat(rw.cells[m_Oqty].innerHTML);
	var balQty = POqty-Alloqty;
	
	if(balQty<0)
	{
		obj.value =0;
		Alloqty = parseFloat(getPOQty(styleId,mode));
		QtyPcs = POqty-Alloqty;
		obj.value =QtyPcs;
	}
		
	Materials[index][5] = QtyPcs;		
}
function clearPage()
{
	$("#frmWkShipSchedule")[0].reset();
	ClearTable('tblMainGrid');
	Materials = [];
	mainArrayIndex 	= 0;
}
function save()
{
	var wkScheduleNo = document.getElementById('txtScheduleNo').value;
	if(wkScheduleNo == '')
	{
		getScheduleNo();
		saveHeader();
		saveDetails();
	}
	else
	{
		saveDetails();
	}
	alert("Saved successfully");
}
function getScheduleNo()
{
	var dfrom = document.getElementById('txtDfrom').value;
	var url = "weekShipScheduledb.php?RequestType=getWkScheduleNo&dfrom="+URLEncode(dfrom);
	htmlobj=$.ajax({url:url,async:false});
	pub_WksheduleNo	 = htmlobj.responseText;
	document.getElementById('txtScheduleNo').value = pub_WksheduleNo;
}
function saveHeader()
{
	var dfrom = document.getElementById('txtDfrom').value;
	var dTo = document.getElementById('txtDto').value;
	var url = "weekShipScheduledb.php?RequestType=saveScheduleHeader&pub_WksheduleNo="+URLEncode(pub_WksheduleNo)+"&dfrom="+URLEncode(dfrom)+"&dTo="+URLEncode(dTo);
	htmlobj=$.ajax({url:url,async:false});
}
function saveDetails()
{
	var scheduleNo = document.getElementById('txtScheduleNo').value;
	for (loop = 0 ; loop < Materials.length ; loop++)
	{	
		var details = Materials[loop] ;
		if 	(details!=null)
		{			
			var styleId		= details[0]; 	// styleId Id
			var city		= details[1]; 	// city Id
			var Qty			= details[2];	// Qty
			var mode		= details[3]; 	// mode
			var Qty_ctn		= details[4];	// Qty_ctn
			var Qty_pcs		= details[5];	// Qty_pcs
			var mnthScheduleDetailId     = details[6];   //mnthScheduleDetailId
			var wkScheduleId = details[7];
			var isdNo       =details[8];	 	
			var dcNo     = details[9];	 	
	 		var doNo    = details[10];
			
			var url = 'weekShipScheduledb.php?RequestType=SaveScheduleDetails&scheduleNo='+URLEncode(scheduleNo)+'&styleId='+styleId+'&city='+city+'&Qty='+Qty+'&mode='+mode+'&Qty_ctn='+Qty_ctn+'&Qty_pcs='+Qty_pcs+'&mnthScheduleDetailId='+mnthScheduleDetailId+'&wkScheduleId='+wkScheduleId+'&isdNo='+isdNo+'&dcNo='+dcNo+'&doNo='+doNo;
			//alert(url)
			htmlobj=$.ajax({url:url,async:false});
		}
	}	
}

function loadWkScheduleData()
{
	var scheduleNo = document.getElementById('cboScheduleNo').value;
	var wkScheduleNo = $("#cboScheduleNo option:selected").text();
	var sNo = wkScheduleNo.split("/");
	var intYear = parseInt(sNo[2]);
	
	if(scheduleNo!= '')
	{
		var url = "weekShipScheduledb.php?RequestType=getwkSheduleHeaderData&scheduleNo="+scheduleNo;
		htmlobj=$.ajax({url:url,async:false});
		document.getElementById('txtDfrom').value = htmlobj.responseXML.getElementsByTagName("DateFrom")[0].childNodes[0].nodeValue;
		document.getElementById('txtDto').value = htmlobj.responseXML.getElementsByTagName("DateTo")[0].childNodes[0].nodeValue;
		document.getElementById('txtScheduleNo').value = $("#cboScheduleNo option:selected").text();
		loadWkScheduleDetails(scheduleNo,intYear);
	}
}
function loadWkScheduleDetails(scheduleNo,intYear)
{
	Materials = [];
	mainArrayIndex 	= 0;
	var url = "weekShipScheduledb.php?RequestType=getwkSheduleItemDetails&scheduleNo="+scheduleNo+"&intYear="+intYear;
	htmlobj=$.ajax({url:url,async:false});
	var XMLIntWkScheduleDetailId	=  htmlobj.responseXML.getElementsByTagName("intWkScheduleDetailId");
	ClearTable('tblMainGrid');
	for(loop=0;loop<XMLIntWkScheduleDetailId.length;loop++)
	{
		var intWkScheduleDetailId = XMLIntWkScheduleDetailId[loop].childNodes[0].nodeValue;
		var styleId = htmlobj.responseXML.getElementsByTagName("intStyleId")[loop].childNodes[0].nodeValue;
		var orderNo = htmlobj.responseXML.getElementsByTagName("strOrderNo")[loop].childNodes[0].nodeValue;
		var styleNo = htmlobj.responseXML.getElementsByTagName("strStyle")[loop].childNodes[0].nodeValue;
		var city = htmlobj.responseXML.getElementsByTagName("intCityId")[loop].childNodes[0].nodeValue;
		var strCity = htmlobj.responseXML.getElementsByTagName("city")[loop].childNodes[0].nodeValue;
		var Qty = htmlobj.responseXML.getElementsByTagName("dblQty")[loop].childNodes[0].nodeValue;
		var modeId=htmlobj.responseXML.getElementsByTagName("strType")[loop].childNodes[0].nodeValue;
		var mode=htmlobj.responseXML.getElementsByTagName("shipMode")[loop].childNodes[0].nodeValue;
		var Qty_ctn = htmlobj.responseXML.getElementsByTagName("dblCtnQty")[loop].childNodes[0].nodeValue;
		var Qty_pcs = htmlobj.responseXML.getElementsByTagName("dblPcsQty")[loop].childNodes[0].nodeValue; 
		var mnthScheduleDetailId =htmlobj.responseXML.getElementsByTagName("intMonthScheduleDetId")[loop].childNodes[0].nodeValue;
		var isdNo = htmlobj.responseXML.getElementsByTagName("strISDNo")[loop].childNodes[0].nodeValue;
		var dcNo = htmlobj.responseXML.getElementsByTagName("strDCNo")[loop].childNodes[0].nodeValue; 
		var doNo = htmlobj.responseXML.getElementsByTagName("strDONo")[loop].childNodes[0].nodeValue; 
		var shipMode = htmlobj.responseXML.getElementsByTagName("shipMode")[loop].childNodes[0].nodeValue; 
		createMainGrid(styleId,orderNo,styleNo,city,strCity,Qty,modeId,Qty_ctn,Qty_pcs,mnthScheduleDetailId,intWkScheduleDetailId,isdNo,dcNo,doNo,shipMode);
		
	}
}

function openWkReport()
{
	/*var wkScheduleNo = document.getElementById('txtScheduleNo').value;
	var path = "wkShipScheduleRpt.php?wkScheduleNo="+URLEncode(wkScheduleNo);
	window.open(path,'frmWkShipSchedule');	*/
	showBackGround('divBG',0);
	var url = "wkShipScheduleDestinationList.php?";
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(400,260,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
}
function getPOQty(styleId,mode)
{
	var totQty =0;
	var tbl = document.getElementById('tblMainGrid');
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		var styleNo = tbl.rows[loop].cells[m_order].id;
		var mMode = tbl.rows[loop].cells[m_mode].id;
		
		if(styleId==styleNo)
			totQty += parseFloat(tbl.rows[loop].cells[m_pcs].childNodes[0].value);
	}
	
	return totQty;
}
function checkWkScheduleAv()
{
	var dfrom = document.getElementById('txtDfrom').value;
	var url = "weekShipScheduledb.php?RequestType=checkScheduleDetails&dfrom="+URLEncode(dfrom);
	htmlobj=$.ajax({url:url,async:false});
	
	var numrows = htmlobj.responseXML.getElementsByTagName("numRows")[0].childNodes[0].nodeValue;
	if(numrows >0)
	{
		var sno = htmlobj.responseXML.getElementsByTagName("strWkScheduleNo")[0].childNodes[0].nodeValue;
		document.getElementById('txtScheduleNo').value  = sno;
		var No = sno.split("/");
		var intYear = parseInt(No[2]);
		document.getElementById('txtDfrom').value = htmlobj.responseXML.getElementsByTagName("DateFrom")[0].childNodes[0].nodeValue;
		document.getElementById('txtDto').value = htmlobj.responseXML.getElementsByTagName("DateTo")[0].childNodes[0].nodeValue;
		var scheduleNo = htmlobj.responseXML.getElementsByTagName("intWkScheduleNo")[0].childNodes[0].nodeValue;
		loadWkScheduleDetails(scheduleNo,intYear);
	}
}
function loadDestinationList()
{
	document.getElementById('chkDest').checked = false;
	var sno = document.getElementById('cboWkSNo').value;
	var url = "weekShipScheduledb.php?RequestType=getDestinationList&sno="+sno;	
	htmlobj=$.ajax({url:url,async:false});
	var XMLCityId 	= htmlobj.responseXML.getElementsByTagName("intCityId");
	var XMLCity =  htmlobj.responseXML.getElementsByTagName("city");
	var mode =  htmlobj.responseXML.getElementsByTagName("strType");
	var shipMode = htmlobj.responseXML.getElementsByTagName("shipMode");
	
	var tbl 		= document.getElementById('tblDestination');
	ClearTable('tblDestination');
	for(loop=0;loop<XMLCityId.length;loop++)
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
		cell.id = XMLCityId[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLCity[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.id = mode[loop].childNodes[0].nodeValue;
		cell.innerHTML = shipMode[loop].childNodes[0].nodeValue;
	}
		
}
function viewWkScheduleReport()
{
	var wkScheduleNo = document.getElementById('cboWkSNo').value;
	var destId = '';
	var tbl = document.getElementById('tblDestination');
	for(var i=1;i<tbl.rows.length;i++)
	{
		if(tbl.rows[i].cells[0].childNodes[0].checked)
			destId += tbl.rows[i].cells[1].id+'*'+tbl.rows[i].cells[2].id+',';
	}
	
	var path = "wkShipScheduleRpt.php?wkScheduleNo="+URLEncode(wkScheduleNo)+'&destId='+destId;
	window.open(path,'frmWkShipSchedule');	
}