// JavaScript Document
var m_del 			= 0;  	//delete button
var m_style 		= 1;		//style Name
var m_order 		= 2;		//orderNo
var m_qty 			= 3;		//qty
var m_conpc		    = 4;		//consumption
var m_price 		= 5;    	//unit price
var m_delDate		= 6;  //delivery date
var m_prodDate		=7 //production in date
var m_remarks		=8;
var pub_dateId =1;
var lcAlloNo="";
var lcAlloYear="";
$(document).ready(function() 
{
	var url					='lcRequestDb.php?id=load_BulkPO';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtBulkPONo" ).autocomplete({
			source: pub_po_arr
		});
			
});

function loadPOList()
{
	var url					='lcRequestDb.php?id=load_BulkPO';
		url += '&intYear='+document.getElementById('cboBulkPOYear').value;
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtBulkPONo" ).autocomplete({
			source: pub_po_arr
		});	
}
function EnterLoadItemDetails(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;

	if (charCode == 13)
		viewBulkPOdetails();		
}
function viewBulkPOdetails()
{
	clearTbl('tblMain');
	var bulkPONo = document.getElementById('txtBulkPONo').value;
	var bulkPOYear = document.getElementById('cboBulkPOYear').value;
	var urlPI = 'lcRequestDb.php?id=load_PINo';
	urlPI += '&bulkPONo='+bulkPONo;
	urlPI += '&bulkPOYear='+bulkPOYear;
	xml_http_obj_PI	=$.ajax({url:urlPI,async:false});
	
	document.getElementById('txtPINo').value = xml_http_obj_PI.responseXML.getElementsByTagName('strPINO')[0].childNodes[0].nodeValue;
	var url		='lcRequestDb.php?id=load_BulkPODetails';
	url += '&bulkPONo='+bulkPONo;
	url += '&bulkPOYear='+bulkPOYear;
	xml_http_obj	=$.ajax({url:url,async:false});
	var xml_itemID	=xml_http_obj.responseXML.getElementsByTagName('intMatDetailId');
	
	for(var loop=0; loop<xml_itemID.length; loop++)
	{
		var strText = document.getElementById("tblMain").innerHTML;
		var itemID	= xml_http_obj.responseXML.getElementsByTagName('intMatDetailId')[loop].childNodes[0].nodeValue;
		var itemIDesc	= xml_http_obj.responseXML.getElementsByTagName('strItemDescription')[loop].childNodes[0].nodeValue;
		
		strText += "<tr class=\"bcgcolor-tblrowWhite\">";
		strText += "<td colspan=\"8\" class=\"normalfnt\" id=\""+itemID+"\">"+itemIDesc+"</td>";
		strText += "<td><img src=\"../images/additem2.png\" onclick=\"openOrderNoPopup(this);\" /></td></tr>";
		
		document.getElementById("tblMain").innerHTML=strText;
		var url_D = 'lcRequestDb.php?id=check_lc_dataAv';
		url_D += "&itemID="+itemID+'&bulkPONo='+bulkPONo+'&bulkPOYear='+bulkPOYear;
		htmlobj=$.ajax({url:url_D,async:false});
		
		if(loop==0)
			var rowId = loop+1;
		else
			var rowId = pub_dateId+1;
		if(htmlobj.responseXML.getElementsByTagName('numrows')[0].childNodes[0].nodeValue>0)
		{
			
			var xml_style = htmlobj.responseXML.getElementsByTagName('intStyleId');
			for(var i=0; i<xml_style.length; i++)
			{
				var styleId = xml_style[i].childNodes[0].nodeValue;
				var styleName = htmlobj.responseXML.getElementsByTagName('strStyle')[i].childNodes[0].nodeValue;
				var orderNo = htmlobj.responseXML.getElementsByTagName('orderno')[i].childNodes[0].nodeValue;
				var orderQty = htmlobj.responseXML.getElementsByTagName('Qty')[i].childNodes[0].nodeValue;
				var conpc = htmlobj.responseXML.getElementsByTagName('reaConPc')[i].childNodes[0].nodeValue;
				var unitprice = htmlobj.responseXML.getElementsByTagName('dblUnitPrice')[i].childNodes[0].nodeValue;
				var deliveryId = htmlobj.responseXML.getElementsByTagName('intDelDateId')[i].childNodes[0].nodeValue;
				var deliveryDate = htmlobj.responseXML.getElementsByTagName('delDate')[i].childNodes[0].nodeValue;
				var prodDate = htmlobj.responseXML.getElementsByTagName('prodDate')[i].childNodes[0].nodeValue;
				var remarks = htmlobj.responseXML.getElementsByTagName('strRemarks')[i].childNodes[0].nodeValue;
				createMainGrid(rowId,styleId,styleName,orderNo,orderQty,conpc,unitprice,deliveryId,deliveryDate,itemID,prodDate,remarks);
			}	
		}
	}
	//document.getElementById("tblMain").innerHTML=strText;
	fix_header('tblMain',850,350);
}

function openOrderNoPopup(obj)
{
	showBackGround('divBG',0);
	var intMatDetailID = obj.parentNode.parentNode.cells[0].id;
	var rwIndex = obj.parentNode.parentNode.rowIndex;
	var url = "lcItemPopup.php?intMatDetailID="+intMatDetailID+'&rwIndex='+rwIndex;
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(643,500,'frmPopItem',1);
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

function viewOrderDetails(matId)
{
	var styleName = document.getElementById('cboPopStyleNo').value;
	var styleId   = document.getElementById('cboPopOrderNo').value;
	
	var url = "lcRequestDb.php?id=load_OrderDetails&intMatDetailID="+matId+'&styleName='+URLEncode(styleName)+'&styleId='+styleId;
	htmlobj=$.ajax({url:url,async:false});
	clearTbl('tblPopupGrid')
	var xml_style	=htmlobj.responseXML.getElementsByTagName('intStyleId');
	for(var loop=0; loop<xml_style.length; loop++)
	{
		var intStyleId = htmlobj.responseXML.getElementsByTagName('intStyleId')[loop].childNodes[0].nodeValue;
		var strStyle = htmlobj.responseXML.getElementsByTagName('strStyle')[loop].childNodes[0].nodeValue;
		var strOrderNo = htmlobj.responseXML.getElementsByTagName('strOrderNo')[loop].childNodes[0].nodeValue;
		var reaConPc = htmlobj.responseXML.getElementsByTagName('reaConPc')[loop].childNodes[0].nodeValue;
		var dblUnitPrice = htmlobj.responseXML.getElementsByTagName('dblUnitPrice')[loop].childNodes[0].nodeValue;
		var intQty = htmlobj.responseXML.getElementsByTagName('intQty')[loop].childNodes[0].nodeValue;
		var deliveryDates = htmlobj.responseXML.getElementsByTagName('deliveryDates')[loop].childNodes[0].nodeValue;
		
		createPopupGrid(intStyleId,strStyle,strOrderNo,reaConPc,dblUnitPrice,intQty,deliveryDates);
	}
}
function createPopupGrid(intStyleId,strStyle,strOrderNo,reaConPc,dblUnitPrice,intQty,deliveryDates)
{
	var tbl = $('#tblPopupGrid tbody');
	var lastRow 		= $('#tblPopupGrid tbody tr').length;
	var row 			= tbl[0].insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";
	//row.setAttribute('bgcolor',xml_RwClass);
	
	var rowCell 	  	= row.insertCell(0);
	rowCell.className 	= "normalfntMid";
	rowCell.innerHTML  = "<input  type=\"checkbox\" >";	
	
	var rowCell 	  	= row.insertCell(1);
	rowCell.id 		    = intStyleId;
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = strStyle;	
	
	var rowCell 	  	= row.insertCell(2);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = strOrderNo;	
	
	var rowCell 	  	= row.insertCell(3);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML  = intQty;	
	
	var rowCell 	  	= row.insertCell(4);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML  = reaConPc;	
	
	var rowCell 	  	= row.insertCell(5);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML  = dblUnitPrice;
	
	var rowCell 	  	= row.insertCell(6);
	rowCell.className 	= "normalfntMid";
	rowCell.innerHTML  = deliveryDates;	
}
function clearTbl(tbl)
{
	$("#"+tbl+" tr:gt(0)").remove();	
	
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

function addStyleDetails(rowId,matDetailId)
{
	var tblPopup = document.getElementById('tblPopupGrid');
	if(validateInterface())
	{
		for(var loop=1;loop<tblPopup.rows.length;loop++)
		{
			if(tblPopup.rows[loop].cells[0].childNodes[0].checked)
			{
				var styleId = tblPopup.rows[loop].cells[1].id;
				var styleName = tblPopup.rows[loop].cells[1].innerHTML;
				var orderNo = tblPopup.rows[loop].cells[2].innerHTML;
				var orderQty = tblPopup.rows[loop].cells[3].innerHTML;
				var conpc = tblPopup.rows[loop].cells[4].innerHTML;
				var unitprice = tblPopup.rows[loop].cells[5].innerHTML;
				var deliveryId = tblPopup.rows[loop].cells[6].childNodes[0].value;
				var deliveryDate = tblPopup.rows[loop].cells[6].childNodes[0].textContent;
				var prodDate = '';
				var remarks = '';
				if(!isRecordExsist(styleId,matDetailId))
					createMainGrid(rowId,styleId,styleName,orderNo,orderQty,conpc,unitprice,deliveryId,deliveryDate,matDetailId,prodDate,remarks);
				
			}
		}
	}
	fix_header('tblMain',850,350);	
}

function createMainGrid(rowId,styleId,styleName,orderNo,orderQty,conpc,unitprice,deliveryId,deliveryDate,matDetailId,prodDate,remarks)
{
	var tbl = document.getElementById('tblMain');
	var lastRow 	= rowId+1;	
	var row 		= tbl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	row.setAttribute('height',20);
	
	var rowCell 	  	= row.insertCell(m_del);
	rowCell.id 		    = 0;
	rowCell.className 	= "normalfntMid";
	rowCell.innerHTML  = "<img src=\"../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\" />";
	
	var rowCell 	  	= row.insertCell(m_style);
	rowCell.className 	= "normalfnt";
	rowCell.id 		    = styleId;
	rowCell.innerHTML  = styleName;
	
	var rowCell 	  	= row.insertCell(m_order);
	rowCell.className 	= "normalfnt";
	rowCell.id 		    = matDetailId;
	rowCell.innerHTML  = orderNo;
	
	var rowCell 	  	= row.insertCell(m_qty);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML  = orderQty;
	
	var rowCell 	  	= row.insertCell(m_conpc);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML  = conpc;
	
		
	var rowCell 	  	= row.insertCell(m_price);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML  = unitprice;
	
	var rowCell 	  	= row.insertCell(m_delDate);
	rowCell.className 	= "normalfnt";
	rowCell.id 		    = deliveryId;
	rowCell.innerHTML  = deliveryDate;
	
	var rowCell 	  	= row.insertCell(m_prodDate);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtDfrom\" id=\""+pub_dateId+"\" style=\"width:90px;\" onMouseDown=\"DisableRightClickEvent();\" value=\""+prodDate+"\" onMouseOut=\"EnableRightClickEvent();\" onKeyPress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%Y-%m-%d');\"  onKeyDown=\"\" /><input type=\"text\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;width:1px\"   onclick=\"return showCalendar(this.id, '%Y-%m-%d');\">";
	
	var rowCell 	  	= row.insertCell(m_remarks);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+remarks+"\"  />";
	
	pub_dateId++;
}
function fix_header(tblName,w,h)
{
	$("#"+tblName+"").fixedHeader({
	width: w,height: h
	});
}

function removeRow(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex;
	tblMain.deleteRow(rowNo);	
}
function validateInterface()
{
	var count=0;
	var tblPopup = document.getElementById('tblPopupGrid');
	for(var loop=1;loop<tblPopup.rows.length;loop++)
		{
			if(tblPopup.rows[loop].cells[0].childNodes[0].checked)
				count++;
		}
		if(count == 0)
		{
			alert("Please select item(s)");
			return false
		}
		else
			return true;
}
function isRecordExsist(intStyleId,matDetailId)
{
	var tbl = document.getElementById('tblMain');	
	for(var loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].id == 0)
				{
					var styleId = tbl.rows[loop].cells[1].id;
					var matId = tbl.rows[loop].cells[2].id;
					
					if(intStyleId == styleId && matDetailId == matId)
						return true; 
				}
		}
		return false;
}

function saveDetails()
{
	var tbl = document.getElementById('tblMain');
	var bulkPOno = document.getElementById('txtBulkPONo').value;
	var bulkPOyear = document.getElementById('cboBulkPOYear').value;
	saveHeader();
	for(var loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].id == 0)
				{
					var intMatDetailID = tbl.rows[loop].cells[2].id;
					var styleId = tbl.rows[loop].cells[1].id;
					var conpc = tbl.rows[loop].cells[4].innerHTML;
					var url = "lcRequestDb.php?id=saveItemDetails&intMatDetailID="+intMatDetailID;
					url += "&styleId="+styleId;
					url += "&conpc="+conpc;
					url += "&uprice="+ tbl.rows[loop].cells[5].innerHTML;
					url += "&delDateId="+tbl.rows[loop].cells[6].id;
					url += "&prodInDate="+URLEncode(tbl.rows[loop].cells[7].childNodes[0].value);
					url += "&remarks="+URLEncode(tbl.rows[loop].cells[8].childNodes[0].value);
					url += "&bulkPOno="+bulkPOno;
					url += "&bulkPOyear="+bulkPOyear;
					htmlobj=$.ajax({url:url,async:false});
				}
		}
		
		alert("Saved successfully");
}

function saveHeader()
{
	var bulkPOno = document.getElementById('txtBulkPONo').value;
	var bulkPOyear = document.getElementById('cboBulkPOYear').value;
	
	var url = "lcRequestDb.php?id=saveHeader&bulkPOno="+bulkPOno+"&bulkPOyear="+bulkPOyear;
	htmlobj=$.ajax({url:url,async:false});
}
function openReportPopup()
{
	showBackGround('divBG',0);
	var url = "reportPopup.php?";
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(478,293,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;		
	//fix_header('tblRpt',343,250);
	loadPIList();
	
}

function viewReport()
{
	var tbl = document.getElementById('tblRpt');
	var piNo ='';
	for(var i=1;i<tbl.rows.length;i++)
	{
		if(tbl.rows[i].cells[0].childNodes[0].checked)
			piNo += tbl.rows[i].cells[1].innerHTML+'~';
	}
	
	var path = "lcRequestReport.php?piNo="+URLEncode(piNo);
	window.open(path,'frmWkShipSchedule');		
}

function movePINoRight()
{
	var piNo = document.getElementById("cboPIlist");
	if(piNo.selectedIndex <= -1) return;
	var selectedColor = piNo.options[piNo.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cboLCPIlist"),true))
	{
		var optPI = document.createElement("option");
		optPI.text = selectedColor;
		optPI.value = selectedColor;
		document.getElementById("cboLCPIlist").options.add(optPI);
		piNo.options[piNo.selectedIndex] = null;
	}	
}

function CheckitemAvailability(itemName, cmb, message)
{
	for(var i = 0; i < cmb.options.length ; i++) 
	{
		if ( cmb.options[i].text.toUpperCase() == itemName.toUpperCase())
		{
			if (message)
				alert("The item " + itemName + " is already exists in the list.");
			return true;			
		}
	}
	return false;
}

function keyMovePINoRight(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;	
	if(charCode==13)
		movePINoRight();
}
function moveAllPItoRight()
{
	var pi = document.getElementById("cboPIlist");
	for(var i = 0; i < pi.options.length ; i++) 
	{
		if(!CheckitemAvailability(pi.options[i].text,document.getElementById("cboLCPIlist"),false))
		{
			var optPI = document.createElement("option");
			optPI.text = pi.options[i].text;
			optPI.value = pi.options[i].text;
			document.getElementById("cboLCPIlist").options.add(optPI);
		}
	}
	RemoveSelectedPI('cboPIlist');
}
function RemoveSelectedPI(cboPI)
{
	var index = document.getElementById(cboPI).options.length;
	while(document.getElementById(cboPI).options.length > 0) 
	{
		index --;
		document.getElementById(cboPI).options[index] = null;
	}
}

function movePINoLeft()
{
	var PI = document.getElementById("cboLCPIlist");
	if(PI.selectedIndex <= -1) return;
	var selectedPI = PI.options[PI.selectedIndex].text;
	if (!CheckitemAvailability(selectedPI,document.getElementById("cboPIlist"),false))
	{
		var optPI = document.createElement("option");
		optPI.text = selectedPI;
		optPI.value = selectedPI;
		document.getElementById("cboPIlist").options.add(optPI);
		
	}
	PI.options[PI.selectedIndex] = null;
}

function keyMovePINoLeft(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;	
	if(charCode==13)
		movePINoLeft();
}
function moveAllPItoLeft()
{
	var pi = document.getElementById("cboLCPIlist");
	for(var i = 0; i < pi.options.length ; i++) 
	{
		if(!CheckitemAvailability(pi.options[i].text,document.getElementById("cboPIlist"),false))
		{
			var optPI = document.createElement("option");
			optPI.text = pi.options[i].text;
			optPI.value = pi.options[i].text;
			document.getElementById("cboPIlist").options.add(optPI);
		}
	}
	RemoveSelectedPI('cboLCPIlist');
}

function loadPIList()
{
	var url					='lcRequestDb.php?id=load_PIList';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		//alert(pub_po_arr)
		$( "#txtPINolist" ).autocomplete({
			source: pub_po_arr
		});
}

function enterLoadSelectedPIlist(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;	
	if(charCode==13)
		loadSelectedPIList();	
}
function loadSelectedPIList()
{
	
}
function savePIDetails()
{
	var recCount = document.getElementById("cboLCPIlist").options.length;
	
	if(recCount > 0)
	{
		var lcName = document.getElementById("txtLCname").value;
		var url_h = "lcRequestDb.php?id=save_lcAlloNo&lcName="+URLEncode(lcName);
		var pub_xml_http_obj	=$.ajax({url:url_h,async:false});
	
		lcAlloNo = pub_xml_http_obj.responseXML.getElementsByTagName('lcRequestNo')[0].childNodes[0].nodeValue;
		lcAlloYear = pub_xml_http_obj.responseXML.getElementsByTagName('lcRequestYear')[0].childNodes[0].nodeValue;
		
		for(var i=0;i<recCount;i++)
		{
			var url = "lcRequestDb.php?id=save_lcAlloDetails";
			url += "&piNo="+URLEncode(document.getElementById("cboLCPIlist").options[i].value);
			url += "&lcAlloNo="+lcAlloNo;
			url += "&lcAlloYear="+lcAlloYear
			htmlobj=$.ajax({url:url,async:false});
			
		}
	}
	else
	{
		alert("No PI Number(s) to save");
		return false;
	}
	var url_p = "lcRequestDb.php?id=get_LCreqNoList";
	htmlobj=$.ajax({url:url_p,async:false});
	document.getElementById('cboLCNo').innerHTML = htmlobj.responseXML.getElementsByTagName('lcRequestNoList')[0].childNodes[0].nodeValue;
	
	alert("Saved successfully");
	
}
function viewLCrequest()
{
	var lcNo = document.getElementById("cboLCNo").value;
	var path = "lcRequestReport.php?lcNo="+URLEncode(lcNo);
	if(confirm('Do you want to send to approve  LC No '+lcNo + ' ?'))
	{
		window.open(path,'frmWkShipSchedule');	
	}
}

function updateSendToAppStatus(lCyear,lcNo)
{
	document.getElementById("comfirmLC").style.display = 'none';
	var url_p = "lcRequestDb.php?id=updateSendToStatus&lcNo="+lcNo+"&lCyear="+lCyear;
	htmlobj=$.ajax({url:url_p,async:false});
	window.close();
}
function viewLcRequestData()
{
	clearTbl('tblMain');
	var lcNo = document.getElementById('cboLcReqNo').value;
	
	var urlLC = 'lcRequestDb.php?id=load_lc_name';
	urlLC += '&lcNo='+URLEncode(lcNo);
	
	xml_http_obj_PI	=$.ajax({url:urlLC,async:false});
	
	document.getElementById('txtLcName').value = xml_http_obj_PI.responseXML.getElementsByTagName('lcRequestName')[0].childNodes[0].nodeValue;
	var lcStatus = xml_http_obj_PI.responseXML.getElementsByTagName('lcRequestStatus')[0].childNodes[0].nodeValue;
	
	var url		='lcRequestDb.php?id=load_LC_Fabric_Details';
	url += '&lcNo='+URLEncode(lcNo);
	
	xml_http_obj	=$.ajax({url:url,async:false});
	var xml_itemID	=xml_http_obj.responseXML.getElementsByTagName('intMatDetailId');
	
	for(var loop=0; loop<xml_itemID.length; loop++)
	{
		var strText = document.getElementById("tblMain").innerHTML;
		var itemID	= xml_http_obj.responseXML.getElementsByTagName('intMatDetailId')[loop].childNodes[0].nodeValue;
		var itemIDesc	= xml_http_obj.responseXML.getElementsByTagName('strItemDescription')[loop].childNodes[0].nodeValue;
		var bulkPOno = xml_http_obj.responseXML.getElementsByTagName('intBulkPoNo')[loop].childNodes[0].nodeValue;
		var bulkPOYear = xml_http_obj.responseXML.getElementsByTagName('bulkPOYear')[loop].childNodes[0].nodeValue;
		var piNo = xml_http_obj.responseXML.getElementsByTagName('strPINO')[loop].childNodes[0].nodeValue;
		
		strText += "<tr class=\"bcgcolor-tblrowWhite\">";
		if(lcStatus==0)
			strText += "<td colspan=\"4\" class=\"normalfnt\" height=\"20\" id=\""+itemID+"\">"+itemIDesc+"</td>";
		else
			strText += "<td colspan=\"5\" class=\"normalfnt\" height=\"20\" id=\""+itemID+"\">"+itemIDesc+"</td>";

		strText += "<td colspan=\"2\" class=\"normalfnt\" height=\"20\" >PO No : "+bulkPOYear+'/'+bulkPOno+"</td>";
		strText += "<td colspan=\"2\" class=\"normalfnt\" height=\"20\" >PI NO : "+piNo+"</td>";
		if(lcStatus==0)
			strText += "<td><img src=\"../images/additem2.png\" onclick=\"openOrderNoPopup(this);\" /></td></tr>";
		
		document.getElementById("tblMain").innerHTML=strText;
		var url_D = 'lcRequestDb.php?id=check_lc_dataAv';
		url_D += "&itemID="+itemID+'&bulkPONo='+bulkPOno+'&bulkPOYear='+bulkPOYear;
		htmlobj=$.ajax({url:url_D,async:false});
		
		if(loop==0)
			var rowId = loop+1;
		else
			var rowId = pub_dateId+loop;
			
		if(htmlobj.responseXML.getElementsByTagName('numrows')[0].childNodes[0].nodeValue>0)
		{
			
			var xml_style = htmlobj.responseXML.getElementsByTagName('intStyleId');
			for(var i=0; i<xml_style.length; i++)
			{
				var styleId = xml_style[i].childNodes[0].nodeValue;
				var styleName = htmlobj.responseXML.getElementsByTagName('strStyle')[i].childNodes[0].nodeValue;
				var orderNo = htmlobj.responseXML.getElementsByTagName('orderno')[i].childNodes[0].nodeValue;
				var orderQty = htmlobj.responseXML.getElementsByTagName('Qty')[i].childNodes[0].nodeValue;
				var conpc = htmlobj.responseXML.getElementsByTagName('reaConPc')[i].childNodes[0].nodeValue;
				var unitprice = htmlobj.responseXML.getElementsByTagName('dblUnitPrice')[i].childNodes[0].nodeValue;
				var deliveryId = htmlobj.responseXML.getElementsByTagName('intDelDateId')[i].childNodes[0].nodeValue;
				var deliveryDate = htmlobj.responseXML.getElementsByTagName('delDate')[i].childNodes[0].nodeValue;
				var prodDate = htmlobj.responseXML.getElementsByTagName('prodDate')[i].childNodes[0].nodeValue;
				var remarks = htmlobj.responseXML.getElementsByTagName('strRemarks')[i].childNodes[0].nodeValue;
				createEditGrid(rowId,styleId,styleName,orderNo,orderQty,conpc,unitprice,deliveryId,deliveryDate,itemID,prodDate,remarks,bulkPOno,bulkPOYear,lcStatus);
			}	
		}
	}
	//document.getElementById("tblMain").innerHTML=strText;
	restrictInterface(lcStatus);
	fix_header('tblMain',850,350);
}

function updateProdLineDate(obj)
{
	var rw = obj.parentNode.parentNode;
	var bulkPO = rw.cells[0].id;
	var bulkPOYear = rw.cells[1].id; 
	var matDetailID = rw.cells[2].id; 
	var styleID = rw.cells[3].id; 
	
	var url = "lcRequestDb.php?id=updateProdLineDate&bulkPO="+bulkPO;
	url += "&bulkPOYear="+bulkPOYear;
	url += "&matDetailID="+matDetailID;
	url += "&styleID="+styleID;
	url += "&prodDate="+URLEncode(obj.value);
	htmlobj=$.ajax({url:url,async:false});
}

function updateProdDateDetails(lCyear,lcNo)
{
	var tbl = document.getElementById('tblReport');
	document.getElementById("comfirmProdDate").style.visibility = 'hidden';
	if(isValidateProdLineDate())
	{
		for(var loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].id != '')
			{
				var url = "lcRequestDb.php?id=updateProdLineDate&bulkPO="+tbl.rows[loop].cells[0].id;
				url += "&bulkPOYear="+tbl.rows[loop].cells[1].id;
				url += "&matDetailID="+tbl.rows[loop].cells[2].id;
				url += "&styleID="+tbl.rows[loop].cells[3].id;
				url += "&prodDate="+URLEncode(tbl.rows[loop].cells[15].childNodes[0].value);
				htmlobj=$.ajax({url:url,async:false});
			}
		}
		updateFirstAppData(lCyear,lcNo);
	}
	else
	{
		document.getElementById("comfirmProdDate").style.visibility = 'visible';	
	}
}

function isValidateProdLineDate()
{
	var tbl = document.getElementById('tblReport');	
	var count =0;
	for(var loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].id != '' && tbl.rows[loop].cells[15].childNodes[0].value=='')
				count++;
				//alert(tbl.rows[loop].cells[15].childNodes[0].value)
		}
		if(count>0)
		{
			alert('Please select the Product Line in Date');
			return false;
		}
		else
			return true;
}

function updateFirstAppData(lCyear,lcNo)
{
	var url = "lcRequestDb.php?id=updateFirstAppData&lCyear="+lCyear+"&lcNo="+lcNo;
	htmlobj=$.ajax({url:url,async:false});
	window.opener.location.reload();
}

function updateRejectStatus(lCyear,lcNo,type)
{
	if(type == 'app1')
		document.getElementById("comfirmProdDate").style.visibility = 'hidden';
	else
		document.getElementById("comfirmLCRequest").style.visibility = 'hidden';
		
	var url = "lcRequestDb.php?id=updateRejectStatus&lCyear="+lCyear+"&lcNo="+lcNo;
	htmlobj=$.ajax({url:url,async:false});
	alert("LC Request rejected");
	window.opener.location.reload();
}
function confirmLCRequest(lCyear,lcNo)
{
	document.getElementById("comfirmLCRequest").style.display = 'none';	
	var url = "lcRequestDb.php?id=confirmLCRequest&lCyear="+lCyear+"&lcNo="+lcNo;
	htmlobj=$.ajax({url:url,async:false});
	window.opener.location.reload();
}

function viewLCData(lCyear,lcNo)
{
	document.getElementById("cboLcReqNo").value = lCyear+'/'+lcNo;
	viewLcRequestData();
}

function createEditGrid(rowId,styleId,styleName,orderNo,orderQty,conpc,unitprice,deliveryId,deliveryDate,itemID,prodDate,remarks,bulkPOno,bulkPOYear,lcStatus)
{
	var tbl = document.getElementById('tblMain');
	var lastRow 	= rowId+1;	
	var row 		= tbl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	row.setAttribute('height',20);
	
	var rowCell 	  	= row.insertCell(m_del);
	rowCell.id 		    = 0;
	rowCell.className 	= "normalfntMid";
	if(lcStatus=='0')
		rowCell.innerHTML  = "<img src=\"../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeEditRow(this);\" />";
	else
		rowCell.innerHTML = '';
	
	var rowCell 	  	= row.insertCell(m_style);
	rowCell.className 	= "normalfnt";
	rowCell.id 		    = styleId;
	rowCell.innerHTML  = styleName;
	
	var rowCell 	  	= row.insertCell(m_order);
	rowCell.className 	= "normalfnt";
	rowCell.id 		    = itemID;
	rowCell.innerHTML  = orderNo;
	
	var rowCell 	  	= row.insertCell(m_qty);
	rowCell.className 	= "normalfntRite";
	rowCell.id 		    = bulkPOno;
	rowCell.innerHTML  = orderQty;
	
	var rowCell 	  	= row.insertCell(m_conpc);
	rowCell.className 	= "normalfntRite";
	rowCell.id 		    = bulkPOYear;
	rowCell.innerHTML  = conpc;
	
		
	var rowCell 	  	= row.insertCell(m_price);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML  = unitprice;
	
	var rowCell 	  	= row.insertCell(m_delDate);
	rowCell.className 	= "normalfnt";
	rowCell.id 		    = deliveryId;
	rowCell.innerHTML  = deliveryDate;
	
	var rowCell 	  	= row.insertCell(m_prodDate);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtDfrom\" id=\""+pub_dateId+"\" style=\"width:90px;\" onMouseDown=\"DisableRightClickEvent();\" value=\""+prodDate+"\" onMouseOut=\"EnableRightClickEvent();\" onKeyPress=\"return ControlableKeyAccess(event);\"  onclick=\"return showCalendar(this.id, '%Y-%m-%d');\"  onKeyDown=\"\" /><input type=\"text\" value=\"\"  class=\"txtbox\" style=\"visibility:hidden;width:1px\"   onclick=\"return showCalendar(this.id, '%Y-%m-%d');\">";
	
	var rowCell 	  	= row.insertCell(m_remarks);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+remarks+"\"  />";
	
	pub_dateId++;
}
function restrictInterface(lcStatus)
{
	if(lcStatus=='0')
		document.getElementById("butSave").style.display = 'inline';
	else
		document.getElementById("butSave").style.display = 'none';
}
function saveProdLineDateDetails()
{
	var tbl = document.getElementById('tblMain');
	for(var loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].id == 0)
				{
					var intMatDetailID = tbl.rows[loop].cells[2].id;
					var styleId = tbl.rows[loop].cells[1].id;
					var conpc = tbl.rows[loop].cells[4].innerHTML;
					var url = "lcRequestDb.php?id=saveItemDetails&intMatDetailID="+intMatDetailID;
					url += "&styleId="+styleId;
					url += "&conpc="+conpc;
					url += "&uprice="+ tbl.rows[loop].cells[5].innerHTML;
					url += "&delDateId="+tbl.rows[loop].cells[6].id;
					url += "&prodInDate="+URLEncode(tbl.rows[loop].cells[7].childNodes[0].value);
					url += "&remarks="+URLEncode(tbl.rows[loop].cells[8].childNodes[0].value);
					url += "&bulkPOno="+tbl.rows[loop].cells[3].id;;
					url += "&bulkPOyear="+tbl.rows[loop].cells[4].id;;
					htmlobj=$.ajax({url:url,async:false});
				}
		}
		alert("Saved successfully");
}

function removeEditRow(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex;
	//tblMain.deleteRow(rowNo);	
	var rwNo = objDel.parentNode.parentNode;
	var url = "lcRequestDb.php?id=deleteItem&bulkPOno="+rwNo.cells[3].id;
	url += "&bulkPOyear="+rwNo.cells[4].id;
	url += "&delDateId="+rwNo.cells[6].id;
	url += "&intMatDetailID="+rwNo.cells[2].id;
	url += "&styleId="+rwNo.cells[1].id;
	htmlobj=$.ajax({url:url,async:false});
	tblMain.deleteRow(rowNo);	
}