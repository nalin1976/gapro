var m_check			= 0;
var m_supp			= 1;
var m_fac 			= 2;
var m_orderno  		= 3;
var m_piNo 			= 4;
var m_oritRefNo 	= 5;
var m_suppPI 		= 6;
var m_ddn 			= 7;
var m_shipMode 		= 8;
var m_Item 			= 9;
var m_col 			= 10;
var m_size 			= 11;
var m_qty 			= 12;
var m_amount 		= 13;
var m_gw 			= 14;
var m_cm			= 15;
var m_payment		= 16;
var m_handle		= 17;
var m_readyDate		= 18;
var m_confirmDate	= 19;
var m_handDate		= 20;
var m_remarks		= 21;


function viewLCRequestData(type)
{
	var oritRefNo = document.getElementById('txtOritRefNo').value;
	var piNo = document.getElementById('txtPIno').value;
	var factory =  document.getElementById('txtFactory').value;
	var shipMode = document.getElementById('txtShipMode').value;
	var chkAllLC = document.getElementById('chkAllLC').checked;
	var status = 0;
	if(chkAllLC)
		status='';

	var url = 'lcRequestDatadb.php?id=viewLCRequestData';
	url += "&orderNo="+ URLEncode(document.getElementById('txtOrderNo').value);
	url += "&supplier="+ URLEncode(document.getElementById('txtSupplierNo').value);
	url += "&oritRefNo="+URLEncode(oritRefNo);
		url += "&piNo="+URLEncode(piNo);
		url += "&factory="+URLEncode(factory);
		url += "&shipMode="+URLEncode(shipMode);
		url += "&status="+status;
		
	htmlobj	=$.ajax({url:url,async:false});
	clearTbl('tblMain');
	var xml_orderNo	=htmlobj.responseXML.getElementsByTagName('orderno');
	var tbl = document.getElementById('tblMain');
	for(var loop=0; loop<xml_orderNo.length; loop++)
	{
		var factory =  htmlobj.responseXML.getElementsByTagName('factory')[loop].childNodes[0].nodeValue;
		var orderno =  htmlobj.responseXML.getElementsByTagName('orderno')[loop].childNodes[0].nodeValue;
		var strPINo =  htmlobj.responseXML.getElementsByTagName('strPINo')[loop].childNodes[0].nodeValue;
		var oritRefNo =  htmlobj.responseXML.getElementsByTagName('strOritRefNo')[loop].childNodes[0].nodeValue;
		var supPINo =  htmlobj.responseXML.getElementsByTagName('SupplierPINo')[loop].childNodes[0].nodeValue;
		var strDNNo =  htmlobj.responseXML.getElementsByTagName('strDNNo')[loop].childNodes[0].nodeValue;
		var ShipMode =  htmlobj.responseXML.getElementsByTagName('ShipMode')[loop].childNodes[0].nodeValue;
		var ItemCode =  htmlobj.responseXML.getElementsByTagName('ItemCode')[loop].childNodes[0].nodeValue;
		var color =  htmlobj.responseXML.getElementsByTagName('strColor')[loop].childNodes[0].nodeValue;
		var size =  htmlobj.responseXML.getElementsByTagName('strSize')[loop].childNodes[0].nodeValue;
		var qty =  htmlobj.responseXML.getElementsByTagName('dblQty')[loop].childNodes[0].nodeValue;
		var amount =  htmlobj.responseXML.getElementsByTagName('dblAmount')[loop].childNodes[0].nodeValue;
		var gw =  htmlobj.responseXML.getElementsByTagName('strGW')[loop].childNodes[0].nodeValue;
		var cm =  htmlobj.responseXML.getElementsByTagName('dblCM')[loop].childNodes[0].nodeValue;
		var payment =  htmlobj.responseXML.getElementsByTagName('strPayment')[loop].childNodes[0].nodeValue;
		var handle =  htmlobj.responseXML.getElementsByTagName('strHandleBy')[loop].childNodes[0].nodeValue;
		var readyDate =  htmlobj.responseXML.getElementsByTagName('dtmReadyDate')[loop].childNodes[0].nodeValue;
		var confirmDate =  htmlobj.responseXML.getElementsByTagName('dtmPIConfirmDate')[loop].childNodes[0].nodeValue;
		var handoverDate =  htmlobj.responseXML.getElementsByTagName('dtmHandoverDate')[loop].childNodes[0].nodeValue;
		var remarks =  htmlobj.responseXML.getElementsByTagName('strRemarks')[loop].childNodes[0].nodeValue;
		var supplier =  htmlobj.responseXML.getElementsByTagName('supplier')[loop].childNodes[0].nodeValue;
		var recNo =  htmlobj.responseXML.getElementsByTagName('recNo')[loop].childNodes[0].nodeValue;
		var status = htmlobj.responseXML.getElementsByTagName('intStatus')[loop].childNodes[0].nodeValue;
		
		createMainGrid(type,tbl,factory,orderno,strPINo,oritRefNo,supPINo,strDNNo,ShipMode,ItemCode,color,size,qty,amount,gw,cm,payment,handle,readyDate,confirmDate,handoverDate,remarks,supplier,recNo,status);
	}
}
function clearTbl(tbl)
{
	$("#"+tbl+" tr:gt(0)").remove();	
	
}

function createMainGrid(type,tbl,factory,orderno,strPINo,oritRefNo,supPINo,strDNNo,ShipMode,ItemCode,color,size,qty,amount,gw,cm,payment,handle,readyDate,confirmDate,handoverDate,remarks,supplier,recNo,status)
{
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	var readonly = '';
	row.className = "bcgcolor-tblrowWhite";	
	var disabled = '';
	
	if(status ==1 || type!='M')
		readonly='readonly'; 
		
	if(status ==1)
		disabled = 'disabled';
		
	var rowCell 	  	= row.insertCell(m_check);
	rowCell.className 	= "normalfnt";
	if(type == 'E')
		rowCell.innerHTML  = "<input type=\"checkbox\" name=\"chkAll\" id=\"chkAll\" onClick=\"addEmportRecord(this);\" "+disabled+">";
	else if(type == 'M')	
		rowCell.innerHTML  = "";
	else if(type == '')
		rowCell.innerHTML  = "<img src=\"../../images/del.png\" width=\"15\" height=\"15\" onClick=\"removeEmpRecord(this)\">";
	
	if(status ==1 && type != '')
		row.className = "bcgcolor-highlighted";	
	
		
		
	var rowCell 	  	= row.insertCell(m_supp);
	rowCell.className 	= "normalfnt";
	rowCell.id 			=  recNo;
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+supplier+"\" "+readonly+" />";	
	
	var cell = row.insertCell(m_fac);
	cell.className ="normalfnt";
	cell.setAttribute('height','20');
	cell.innerHTML = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+factory+"\"  "+readonly+"/>";
		
	var rowCell 	  	= row.insertCell(m_orderno);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+orderno+"\" "+readonly+"/>";	
	
	var rowCell 	  	= row.insertCell(m_piNo);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+strPINo+"\" "+readonly+" />";
	
	var rowCell 	  	= row.insertCell(m_oritRefNo);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+oritRefNo+"\" "+readonly+" />";	
	
	var rowCell 	  	= row.insertCell(m_suppPI);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+supPINo+"\" "+readonly+" />";	
	
	var rowCell 	  	= row.insertCell(m_ddn);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+strDNNo+"\" "+readonly+"/>";	
	
	var rowCell 	  	= row.insertCell(m_shipMode);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+ShipMode+"\" "+readonly+"/>";	
	
	var rowCell 	  	= row.insertCell(m_Item);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+ItemCode+"\" "+readonly+" />";	
	
	var rowCell 	  	= row.insertCell(m_col);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+color+"\" "+readonly+" />";	
	
	var rowCell 	  	= row.insertCell(m_size);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+size+"\" "+readonly+" />";	
	
	var rowCell 	  	= row.insertCell(m_qty);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+qty+"\" "+readonly+" onkeypress=\"return CheckforValidDecimal(this.value, 0,event);\"/>";	
	
	var rowCell 	  	= row.insertCell(m_amount);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+amount+"\" "+readonly+"   onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"/>";	
	
	var rowCell 	  	= row.insertCell(m_gw);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+gw+"\" "+readonly+" />";	
	
	var rowCell 	  	= row.insertCell(m_cm);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+cm+"\" "+readonly+"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" />";	
	
	var rowCell 	  	= row.insertCell(m_payment);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+payment+"\" "+readonly+" />";	
	
	var rowCell 	  	= row.insertCell(m_handle);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+handle+"\" "+readonly+" />";	
	
	var rowCell 	  	= row.insertCell(m_readyDate);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+readyDate+"\" "+readonly+" />";	
	
	var rowCell 	  	= row.insertCell(m_confirmDate);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+confirmDate+"\" "+readonly+"/>";	
	
	var rowCell 	  	= row.insertCell(m_handDate);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+handoverDate+"\" "+readonly+" />";	
	
	var rowCell 	  	= row.insertCell(m_remarks);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = "<input type=\"text\" name=\"txtremarks\"  style=\"width:140px;\"  value=\""+remarks+"\" "+readonly+" />";
	
	if(type == 'E')
		checkAlloDetailAvinEmporttbl(recNo,lastRow);
}

function viewReport(type)
{
	var orderNo  =document.getElementById('txtOrderNo').value;
	var supplier = document.getElementById('txtSupplierNo').value;
	var oritRefNo = document.getElementById('txtOritRefNo').value;
	var piNo = document.getElementById('txtPIno').value;
	var factory =  document.getElementById('txtFactory').value;
	var shipMode = document.getElementById('txtShipMode').value;
	
		var url = "lcRequestDataReport.php?orderNo="+URLEncode(orderNo)+"&supplier="+URLEncode(supplier);
		url += "&oritRefNo="+URLEncode(oritRefNo);
		url += "&piNo="+URLEncode(piNo);
		url += "&factory="+URLEncode(factory);
		url += "&shipMode="+URLEncode(shipMode);
		url += "&type="+(type);
		if(type == 'I')
			url += "&LCno="+document.getElementById('txtLCNo').value;
			
		window.open(url,'lcRequestDataReport.php?');
	
}

function addEmportRecord(obj)
{
	var rowNo = obj.parentNode.parentNode;
	var recNo =  rowNo.cells[1].id;
	if(obj.checked)
	{
		var tbl = document.getElementById('tblEmport');
		
		var factory =  rowNo.cells[2].childNodes[0].value;
		var orderno =  rowNo.cells[3].childNodes[0].value;
		var strPINo =  rowNo.cells[4].childNodes[0].value;
		var oritRefNo =  rowNo.cells[5].childNodes[0].value;
		var supPINo = rowNo.cells[6].childNodes[0].value;
		var strDNNo = rowNo.cells[7].childNodes[0].value;
		var ShipMode = rowNo.cells[8].childNodes[0].value;
		var ItemCode = rowNo.cells[9].childNodes[0].value;
		var color = rowNo.cells[10].childNodes[0].value;
		var size =  rowNo.cells[11].childNodes[0].value;
		var qty = rowNo.cells[12].childNodes[0].value;
		var amount = rowNo.cells[13].childNodes[0].value;
		var gw =  rowNo.cells[14].childNodes[0].value;
		var cm = rowNo.cells[15].childNodes[0].value;
		var payment = rowNo.cells[16].childNodes[0].value;
		var handle =  rowNo.cells[17].childNodes[0].value;
		var readyDate = rowNo.cells[18].childNodes[0].value;
		var confirmDate = rowNo.cells[19].childNodes[0].value;
		var handoverDate = rowNo.cells[20].childNodes[0].value;
		var remarks = rowNo.cells[21].childNodes[0].value;
		var supplier = rowNo.cells[1].childNodes[0].value;
		
		var type = '';	
		createMainGrid(type,tbl,factory,orderno,strPINo,oritRefNo,supPINo,strDNNo,ShipMode,ItemCode,color,size,qty,amount,gw,cm,payment,handle,readyDate,confirmDate,handoverDate,remarks,supplier,recNo);
	}
	else
	{
		removeRow(recNo);	
	}
}
function removeRow(recNo)
{
	var tblEmport 	= document.getElementById('tblEmport');
	var test	= tblEmport.rows.length;
	for(var i =1;i<test;i++)
	{
		var no = tblEmport.rows[i].cells[1].id;		
		if(no==recNo){
			tblEmport.deleteRow(i);
		}
	}
}

function removeEmpRecord(obj)
{
	var tblMain = obj.parentNode.parentNode.parentNode.parentNode;
	var rowNo = obj.parentNode.parentNode.rowIndex;
	var recNo = obj.parentNode.parentNode.cells[1].id;
	
	var tblMainGrid 	= document.getElementById('tblMain');
	var test	= tblMainGrid.rows.length;
	for(var i =1;i<test;i++)
	{
		var no = tblMainGrid.rows[i].cells[1].id;		
		if(no==recNo){
			tblMainGrid.rows[i].cells[0].childNodes[0].checked = false;
		}
	}
	tblMain.deleteRow(rowNo);
	
	
}

function saveLCData()
{
	var lcName = document.getElementById('txtSavedLCname').value;
	var tblEmport 	= document.getElementById('tblEmport');
	var tblLen	= tblEmport.rows.length;
	
	if(tblLen==1)
	{
		alert("Please select item(s) to save");
		return false;
	}
	if(lcName =='')
	{
		alert("Please enter 'LC Name'");
		return false;
	}
	var strlcNo = document.getElementById('txtLCNo').value;
	if(strlcNo == '')
	{
		var url = 'lcRequestDatadb.php?id=save_lcAlloNo';
		url += "&lcName="+URLEncode(document.getElementById('txtSavedLCname').value);
		htmlobj	=$.ajax({url:url,async:false});
		var lcNo = htmlobj.responseXML.getElementsByTagName('lcRequestNo')[0].childNodes[0].nodeValue;
		var lcYear = htmlobj.responseXML.getElementsByTagName('lcRequestYear')[0].childNodes[0].nodeValue;
		document.getElementById('txtLCNo').value = lcYear+'/'+lcNo;
	}
	else
	{
		var lcNo = 	strlcNo.split("/")[1];
		var lcYear = strlcNo.split("/")[0];
		
		var url = 'lcRequestDatadb.php?id=update_LCallocateHeader';
		url += "&lcName="+URLEncode(document.getElementById('txtSavedLCname').value);
		url += "&intLCNo="+lcNo;
		url += "&intLCYear="+lcYear;
		htmlobj	=$.ajax({url:url,async:false});
	}
	
	for(var i =1;i<tblLen;i++)
	{
		var no = tblEmport.rows[i].cells[1].id;		
		var url_d = 'lcRequestDatadb.php?id=save_lcAlloDetails';
		url_d += "&no="+no;
		url_d += "&lcNo="+lcNo;
		url_d += "&lcYear="+lcYear;
		htmlobj	=$.ajax({url:url_d,async:false});
	}
	alert("Saved successfully");
}
function checkAlloDetailAvinEmporttbl(recNo,lastRow)
{
	var tblEmport 	= document.getElementById('tblEmport');
	var tblMain  =  document.getElementById('tblMain');
	
	var test	= tblEmport.rows.length;
	for(var i =1;i<test;i++)
	{
		var no = tblEmport.rows[i].cells[1].id;		
		if(no==recNo){
			tblMain.rows[lastRow].cells[0].childNodes[0].checked = true;
		}
	}	
}

function viewSavedLCAlloData()
{
	var lcNo = 	document.getElementById('txtSavedLCNo').value;
	var lcYear = 	document.getElementById('cboLCYear').value;
	
	
	if(lcNo =='')
	{
		alert("Please enter 'L/C Request No'");
		document.getElementById('txtSavedLCNo').focus();
		return false;
	}
	
	var url_h = 'lcRequestDatadb.php?id=getSavedLCAllocatedHeaderData';
		url_h += '&lcNo='+lcNo;
		url_h += '&lcYear='+lcYear;
	
	var htmlobj_h	=$.ajax({url:url_h,async:false});
	
	document.getElementById('txtSavedLCname').value = htmlobj_h.responseXML.getElementsByTagName('lcRequestName')[0].childNodes[0].nodeValue;
	document.getElementById('txtLCNo').value = lcYear+'/'+lcNo;
	var url = 'lcRequestDatadb.php?id=getSavedLCAllocatedData';
		url += '&lcNo='+lcNo;
		url += '&lcYear='+lcYear;
	
	htmlobj	=$.ajax({url:url,async:false});	
	clearTbl('tblMain');
	clearTbl('tblEmport');
	var xml_orderNo	=htmlobj.responseXML.getElementsByTagName('orderno');
	var tbl = document.getElementById('tblEmport');
	var type = '';
	for(var loop=0; loop<xml_orderNo.length; loop++)
	{
		var factory =  htmlobj.responseXML.getElementsByTagName('factory')[loop].childNodes[0].nodeValue;
		var orderno =  htmlobj.responseXML.getElementsByTagName('orderno')[loop].childNodes[0].nodeValue;
		var strPINo =  htmlobj.responseXML.getElementsByTagName('strPINo')[loop].childNodes[0].nodeValue;
		var oritRefNo =  htmlobj.responseXML.getElementsByTagName('strOritRefNo')[loop].childNodes[0].nodeValue;
		var supPINo =  htmlobj.responseXML.getElementsByTagName('SupplierPINo')[loop].childNodes[0].nodeValue;
		var strDNNo =  htmlobj.responseXML.getElementsByTagName('strDNNo')[loop].childNodes[0].nodeValue;
		var ShipMode =  htmlobj.responseXML.getElementsByTagName('ShipMode')[loop].childNodes[0].nodeValue;
		var ItemCode =  htmlobj.responseXML.getElementsByTagName('ItemCode')[loop].childNodes[0].nodeValue;
		var color =  htmlobj.responseXML.getElementsByTagName('strColor')[loop].childNodes[0].nodeValue;
		var size =  htmlobj.responseXML.getElementsByTagName('strSize')[loop].childNodes[0].nodeValue;
		var qty =  htmlobj.responseXML.getElementsByTagName('dblQty')[loop].childNodes[0].nodeValue;
		var amount =  htmlobj.responseXML.getElementsByTagName('dblAmount')[loop].childNodes[0].nodeValue;
		var gw =  htmlobj.responseXML.getElementsByTagName('strGW')[loop].childNodes[0].nodeValue;
		var cm =  htmlobj.responseXML.getElementsByTagName('dblCM')[loop].childNodes[0].nodeValue;
		var payment =  htmlobj.responseXML.getElementsByTagName('strPayment')[loop].childNodes[0].nodeValue;
		var handle =  htmlobj.responseXML.getElementsByTagName('strHandleBy')[loop].childNodes[0].nodeValue;
		var readyDate =  htmlobj.responseXML.getElementsByTagName('dtmReadyDate')[loop].childNodes[0].nodeValue;
		var confirmDate =  htmlobj.responseXML.getElementsByTagName('dtmPIConfirmDate')[loop].childNodes[0].nodeValue;
		var handoverDate =  htmlobj.responseXML.getElementsByTagName('dtmHandoverDate')[loop].childNodes[0].nodeValue;
		var remarks =  htmlobj.responseXML.getElementsByTagName('strRemarks')[loop].childNodes[0].nodeValue;
		var supplier =  htmlobj.responseXML.getElementsByTagName('supplier')[loop].childNodes[0].nodeValue;
		var recNo =  htmlobj.responseXML.getElementsByTagName('recNo')[loop].childNodes[0].nodeValue;
		var status = htmlobj.responseXML.getElementsByTagName('intStatus')[loop].childNodes[0].nodeValue;
		
		createMainGrid(type,tbl,factory,orderno,strPINo,oritRefNo,supPINo,strDNNo,ShipMode,ItemCode,color,size,qty,amount,gw,cm,payment,handle,readyDate,confirmDate,handoverDate,remarks,supplier,recNo,status);
	}	
}

function updateLCData()
{
	var tblMain  =  document.getElementById('tblMain');
	var test	= tblMain.rows.length;
	
	for(var i =1;i<test;i++)
	{
		var no = tblMain.rows[i].cells[1].id;		
		var supplier = tblMain.rows[i].cells[1].childNodes[0].value;
		var fac = tblMain.rows[i].cells[2].childNodes[0].value;
		var orderNo = tblMain.rows[i].cells[3].childNodes[0].value;
		var piNo = tblMain.rows[i].cells[4].childNodes[0].value;
		var oritRef = tblMain.rows[i].cells[5].childNodes[0].value;
		var suppPI = tblMain.rows[i].cells[6].childNodes[0].value;
		var DNno = tblMain.rows[i].cells[7].childNodes[0].value;
		var shipmode = tblMain.rows[i].cells[8].childNodes[0].value;
		var itemCode = tblMain.rows[i].cells[9].childNodes[0].value;
		var color = tblMain.rows[i].cells[10].childNodes[0].value;
		var size = tblMain.rows[i].cells[11].childNodes[0].value;
		var qty = tblMain.rows[i].cells[12].childNodes[0].value;
		var amount = tblMain.rows[i].cells[13].childNodes[0].value;
		var gw = tblMain.rows[i].cells[14].childNodes[0].value;
		var cm = tblMain.rows[i].cells[15].childNodes[0].value;
		var pay = tblMain.rows[i].cells[16].childNodes[0].value;
		var handle = tblMain.rows[i].cells[17].childNodes[0].value;
		var readydate = tblMain.rows[i].cells[18].childNodes[0].value;
		var piConfirm = tblMain.rows[i].cells[19].childNodes[0].value;
		var handoverDate = tblMain.rows[i].cells[20].childNodes[0].value;
		var remarks = tblMain.rows[i].cells[21].childNodes[0].value;
		
		var url = 'lcRequestDatadb.php?id=updateLCDetails';
		url += '&no='+no;
		url += '&supplier='+URLEncode(supplier);
		url += '&fac='+URLEncode(fac);
		url += '&orderNo='+URLEncode(orderNo);
		url += '&piNo='+URLEncode(piNo);
		url += '&oritRef='+URLEncode(oritRef);
		url += '&suppPI='+URLEncode(suppPI);
		url += '&DNno='+URLEncode(DNno);
		url += '&shipmode='+URLEncode(shipmode);
		url += '&itemCode='+URLEncode(itemCode);
		url += '&color='+URLEncode(color);
		url += '&size='+URLEncode(size);
		url += '&qty='+(qty);
		url += '&amount='+(amount);
		url += '&gw='+(gw);
		url += '&cm='+(cm);
		url += '&pay='+(pay);
		url += '&handle='+URLEncode(handle);
		url += '&readydate='+URLEncode(readydate);
		url += '&piConfirm='+URLEncode(piConfirm);
		url += '&handoverDate='+URLEncode(handoverDate);
		url += '&remarks='+URLEncode(remarks);
		
		htmlobj	=$.ajax({url:url,async:false});
	}
	alert("Saved successfully");
}