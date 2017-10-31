$(document).ready(function() 
{
	/*var url					='shippingCWSxml.php?id=load_comm_invNo';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtComInvNo" ).autocomplete({
			source: pub_po_arr
		});*/
		loadStatusWiseOrderNo();
				
});

function enableEnterLoadOrderList(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				loadOrder_list();
}

function loadOrder_list()
{
	var url = 'shippingCWSxml.php?id=load_orderNo_list';
		url += '&comInvNo='+URLEncode(document.getElementById("txtComInvNo").value);
		
	var xml_http_obj	=$.ajax({url:url,async:false});
	
	document.getElementById("cboOrderNo").innerHTML =xml_http_obj.responseXML.getElementsByTagName('orderNoList')[0].childNodes[0].nodeValue;
	
	loadOrder_Color_details();
	
}

function loadOrder_Color_details()
{
	var url = 'shippingCWSxml.php?id=load_orderNo_Colorlist';
		url += '&comInvNo='+URLEncode(document.getElementById("txtComInvNo").value);	
		url += '&orderNo='+URLEncode(document.getElementById("cboOrderNo").value);	
		
	var xml_http_obj	=$.ajax({url:url,async:false});
	document.getElementById("cboColor").innerHTML =xml_http_obj.responseXML.getElementsByTagName('orderNoColorList')[0].childNodes[0].nodeValue;
	
	load_order_details();
}

function load_order_details()
{
		var url = 'shippingCWSxml.php?id=load_orderNoDetails';
		url += '&comInvNo='+URLEncode(document.getElementById("cboComInvNo").value);	
		url += '&orderNo='+URLEncode(document.getElementById("txtOrderNo").value);	
		url += '&strColor='+URLEncode(document.getElementById("cboColor").value);
		url += '&styleId='+document.getElementById("styleID").title;
		
	var xml_http_obj	=$.ajax({url:url,async:false});
	
	document.getElementById("txtStyle").value =xml_http_obj.responseXML.getElementsByTagName('styleNo')[0].childNodes[0].nodeValue;
	document.getElementById("txtsalingDate").value =xml_http_obj.responseXML.getElementsByTagName('sailingDate')[0].childNodes[0].nodeValue;
	document.getElementById("txtShipQty").value =xml_http_obj.responseXML.getElementsByTagName('Qty')[0].childNodes[0].nodeValue;
	document.getElementById("txtCarrier").value =xml_http_obj.responseXML.getElementsByTagName('carrier')[0].childNodes[0].nodeValue;
	document.getElementById("txtfabric").value =xml_http_obj.responseXML.getElementsByTagName('fabric')[0].childNodes[0].nodeValue;
	document.getElementById("txtotherDetail").value =xml_http_obj.responseXML.getElementsByTagName('otherDetails')[0].childNodes[0].nodeValue;
	document.getElementById("cboFactory").value =xml_http_obj.responseXML.getElementsByTagName('companyId')[0].childNodes[0].nodeValue;
	document.getElementById("cboBuyer").value =xml_http_obj.responseXML.getElementsByTagName('buyerID')[0].childNodes[0].nodeValue;
	document.getElementById("cboConsignee").value =xml_http_obj.responseXML.getElementsByTagName('buyerID')[0].childNodes[0].nodeValue;
	document.getElementById("cboFinalDestination").value =xml_http_obj.responseXML.getElementsByTagName('destination')[0].childNodes[0].nodeValue;
	document.getElementById("cboBank").value =xml_http_obj.responseXML.getElementsByTagName('bankId')[0].childNodes[0].nodeValue;
	document.getElementById("cboShipto").value =xml_http_obj.responseXML.getElementsByTagName('deliverTo')[0].childNodes[0].nodeValue;
	document.getElementById("txtComInvFob").value =xml_http_obj.responseXML.getElementsByTagName('commFob')[0].childNodes[0].nodeValue;
	document.getElementById("txtInvFob").value =xml_http_obj.responseXML.getElementsByTagName('invFob')[0].childNodes[0].nodeValue;
	document.getElementById("txtgender").value =xml_http_obj.responseXML.getElementsByTagName('gender')[0].childNodes[0].nodeValue;
	document.getElementById("cboPayTerm").value =xml_http_obj.responseXML.getElementsByTagName('strPayTerm')[0].childNodes[0].nodeValue;
	document.getElementById("txtHTSData").value =xml_http_obj.responseXML.getElementsByTagName('HTSdata')[0].childNodes[0].nodeValue;
	document.getElementById("txtInvNo").value =xml_http_obj.responseXML.getElementsByTagName('strInvoiceNo')[0].childNodes[0].nodeValue;
	
}


//------Start 2011-03-09 get order no from Firstsaleheader and load data---------------------------------------------

function loadOrder_comInv_details()
{
	var url = 'shippingCWSxml.php?id=load_ComInv_list';
		url += '&styleId='+document.getElementById("styleID").title;
		url += '&orderNo='+URLEncode(document.getElementById("txtOrderNo").value);	
	
	var xml_http_obj	=$.ajax({url:url,async:false});
	
	document.getElementById("cboComInvNo").innerHTML =xml_http_obj.responseXML.getElementsByTagName('comInvList')[0].childNodes[0].nodeValue;
	document.getElementById("cboColor").value =xml_http_obj.responseXML.getElementsByTagName('color')[0].childNodes[0].nodeValue;
	if(document.getElementById("cboComInvNo").innerHTML == '')
	{
		alert("Commercial Invoice data not available");
		clearShippingCWS();
		return;
	}
	else
	{
		load_order_details();
	}
	
}

function saveShippingCWS()
{
	var styleId = document.getElementById("txtOrderNo").value;
	if(styleId=='')
	{
		alert("Please select OrderNo");
		document.getElementById("txtOrderNo").focus();
		return false;
	}
	if(document.getElementById("cboFinalDestination").value =='')
	{
		alert("Please select Final Destination ");
		document.getElementById("cboFinalDestination").focus();
		return false;
	}
	if(!checkApprovedOrderAvailable())
	{
		var url_s = 'shippingCWSxml.php?id=checkOrderSendtoApproval'; 
		url_s += '&styleId='+document.getElementById("styleID").title;
		htmlobj = $.ajax({url:url_s,async:false});
		
		if(htmlobj.responseText =='')
		{
		var url = 'shippingCWSxml.php?id=saveShippingCWSdetails';
			url += '&styleId='+document.getElementById("styleID").title;
			url += '&orderNo='+URLEncode(document.getElementById("txtOrderNo").value);	
			url += '&strColor='+URLEncode(document.getElementById("cboColor").value);
			url += '&comInvNo='+URLEncode(document.getElementById("cboComInvNo").value);
			url += '&paytermId='+URLEncode(document.getElementById("cboPayTerm").value);
			url += '&shiptermId='+document.getElementById("cboShipmentTerm").value;
			url += '&invoiceNo='+document.getElementById("txtInvNo").value;
			url += '&vatRate='+URLEncode(document.getElementById("txtVatRate").value);
			url += '&buyerCode='+URLEncode($('#cboBuyer option:selected').text());	
			url += '&fDestinationId='+document.getElementById("cboFinalDestination").value;
			url += '&companyId='+document.getElementById("cboFactory").value;
			url += '&buyerID='+document.getElementById("cboBuyer").value
			var xml_http_obj = $.ajax({url:url,async:false});
			
			document.getElementById("txtInvNo").value =xml_http_obj.responseXML.getElementsByTagName('invNo')[0].childNodes[0].nodeValue;
			var response = xml_http_obj.responseXML.getElementsByTagName('result')[0].childNodes[0].nodeValue;
			
			if(response == 'TRUE')
			{
				alert('Saved successfully');
				location = "shippingCWS.php?";	
			}	
			else
				alert(response);
		}
		else
		{
			alert("Order Details send to approval. Can't change Order Details.")
			return false;
			}
	}
}

function clearShippingCWS()
{
	
	$("#frmShipCostWorkSheet")[0].reset();
	document.getElementById("cboComInvNo").innerHTML='';
	//document.getElementById("cboOrderNo").disabled = '';
}

/*function copyInvNo()
{
	if(document.getElementById('copyOrderDetails').style.visibility == "hidden")
	{
		document.getElementById("txtCopyOrderNo").value='';
		document.getElementById("copycomInvNo").innerHTML = '';
		var url = 'shippingCWSxml.php?id=load_confirm_OrderNoList';
		var xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr		=xml_http_obj.responseText.split("|");
		
		$( "#txtCopyOrderNo" ).autocomplete({
			source: pub_po_arr
		});
		
		document.getElementById('copyOrderDetails').style.visibility = "visible";
	}
	else
	{
		document.getElementById('copyOrderDetails').style.visibility = "hidden";
		
	}
			
}*/

function loadShippingCostWorksheet(invID)
{
	if(invID !=0)
	{
		var url = 'shippingCWSxml.php?id=load_pending_orderNoDetails';
		url += '&invID='+invID;
		
		var xml_http_obj	=$.ajax({url:url,async:false});
		var styleID = xml_http_obj.responseXML.getElementsByTagName('styleId')[0].childNodes[0].nodeValue;
		var orderNo = xml_http_obj.responseXML.getElementsByTagName('orderNo')[0].childNodes[0].nodeValue;
		var color = xml_http_obj.responseXML.getElementsByTagName('strColor')[0].childNodes[0].nodeValue;
		
		/*var newOption = $('<option value="'+styleID+'">'+orderNo+'</option>');
 $('#cboOrderNo').append(newOption);
		document.getElementById("cboOrderNo").value = styleID;
		document.getElementById("cboOrderNo").disabled = 'disabled';*/
		document.getElementById("txtOrderNo").value=orderNo;
		document.getElementById("styleID").title=styleID;
		
		var newOptionColor = $('<option value="'+color+'">'+color+'</option>');
 $('#cboColor').append(newOptionColor);
		document.getElementById("cboColor").value = color;
		
		document.getElementById("txtStyle").value =xml_http_obj.responseXML.getElementsByTagName('styleNo')[0].childNodes[0].nodeValue;
	document.getElementById("txtsalingDate").value =xml_http_obj.responseXML.getElementsByTagName('sailingDate')[0].childNodes[0].nodeValue;
	document.getElementById("txtShipQty").value =xml_http_obj.responseXML.getElementsByTagName('Qty')[0].childNodes[0].nodeValue;
	document.getElementById("txtCarrier").value =xml_http_obj.responseXML.getElementsByTagName('carrier')[0].childNodes[0].nodeValue;
	document.getElementById("txtfabric").value =xml_http_obj.responseXML.getElementsByTagName('fabric')[0].childNodes[0].nodeValue;
	document.getElementById("txtotherDetail").value =xml_http_obj.responseXML.getElementsByTagName('otherDetails')[0].childNodes[0].nodeValue;
	document.getElementById("cboFactory").value =xml_http_obj.responseXML.getElementsByTagName('companyId')[0].childNodes[0].nodeValue;
	document.getElementById("cboBuyer").value =xml_http_obj.responseXML.getElementsByTagName('buyerID')[0].childNodes[0].nodeValue;
	document.getElementById("cboConsignee").value =xml_http_obj.responseXML.getElementsByTagName('buyerID')[0].childNodes[0].nodeValue;
	document.getElementById("cboFinalDestination").value =xml_http_obj.responseXML.getElementsByTagName('destination')[0].childNodes[0].nodeValue;
	document.getElementById("cboBank").value =xml_http_obj.responseXML.getElementsByTagName('bankId')[0].childNodes[0].nodeValue;
	document.getElementById("cboShipto").value =xml_http_obj.responseXML.getElementsByTagName('deliverTo')[0].childNodes[0].nodeValue;
	document.getElementById("txtComInvFob").value =xml_http_obj.responseXML.getElementsByTagName('commFob')[0].childNodes[0].nodeValue;
	document.getElementById("txtInvFob").value =xml_http_obj.responseXML.getElementsByTagName('invFob')[0].childNodes[0].nodeValue;
	document.getElementById("txtgender").value =xml_http_obj.responseXML.getElementsByTagName('gender')[0].childNodes[0].nodeValue;
	
	var comInv = xml_http_obj.responseXML.getElementsByTagName('comInvNo')[0].childNodes[0].nodeValue;
	
	/*var newOptionCom = $('<option value="'+comInv+'">'+comInv+'</option>');
 $('#cboComInvNo').append(newOptionCom);
		document.getElementById("cboComInvNo").value = color;*/
	document.getElementById("cboComInvNo").innerHTML =	xml_http_obj.responseXML.getElementsByTagName('comInvNo')[0].childNodes[0].nodeValue;
	document.getElementById("txtInvNo").value =xml_http_obj.responseXML.getElementsByTagName('invoiceNo')[0].childNodes[0].nodeValue;
	document.getElementById("txtVatRate").value =xml_http_obj.responseXML.getElementsByTagName('vatRate')[0].childNodes[0].nodeValue;
	document.getElementById("cboPayTerm").value =xml_http_obj.responseXML.getElementsByTagName('payterm')[0].childNodes[0].nodeValue;
	document.getElementById("cboShipmentTerm").value =xml_http_obj.responseXML.getElementsByTagName('shipterm')[0].childNodes[0].nodeValue;
	document.getElementById("txtHTSData").value =xml_http_obj.responseXML.getElementsByTagName('HTSdata')[0].childNodes[0].nodeValue;
	}		
}

function loadCopyComInvList()
{
	var orderNo = document.getElementById("txtOrderNo").value;
	
	var url = 'shippingCWSxml.php?id=load_AppOrderComInv_list';
		url += '&orderNo='+URLEncode(orderNo);	
	
	var xml_http_obj	=$.ajax({url:url,async:false});
	var styleID = xml_http_obj.responseXML.getElementsByTagName('styleId')[0].childNodes[0].nodeValue;
	
				
	document.getElementById("cboComInvNo").innerHTML =xml_http_obj.responseXML.getElementsByTagName('comInvList')[0].childNodes[0].nodeValue;
	
}

function copyOrder()
{
	$("#frmShipCostWorkSheet")[0].reset();
	document.getElementById("cboComInvNo").innerHTML = '';
	document.getElementById("cboOrderNo").innerHTML = '';
	
	var orderNo = document.getElementById("txtCopyOrderNo").value;
	var styleId = document.getElementById("copyOrderId").title;
	
	var newOption_o = $('<option value="'+styleId+'">'+orderNo+'</option>');
 $('#cboOrderNo').append(newOption_o);
		document.getElementById("cboOrderNo").value = styleId;
	
	var comInv = document.getElementById("copycomInvNo").value;
	var newOption = $('<option value="'+comInv+'">'+comInv+'</option>');
 $('#cboComInvNo').append(newOption);
		document.getElementById("cboComInvNo").value = comInv;
		load_order_details();
		closeCopyOrderPopup();
}

function closeCopyOrderPopup()
{
	document.getElementById('copyOrderDetails').style.visibility = "hidden";		
	}
	
function viewInvoiceRpt(invoiceID,StyleID)
{
	window.open("taxInvoiceRpt.php?invoiceID=" + invoiceID+"&styleID="+StyleID,'frmShipCostWorkSheet');
}

function enterSubmitLoadComInvNo(evt)
{
var charCode = (evt.which) ? evt.which : evt.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				loadCopyComInvList();	
}
function enableEnterSubmitApprovShipDetails(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				viewApprovedOrderData();
}
function viewApprovedOrderData()
{
	var orderNo = document.getElementById('txtAppOrderNo').value;
	clearTbl('tblAppShip');
	var tbl 	= document.getElementById('tblAppShip');
	
	if(orderNo != '')
		orderNo = URLEncode(orderNo);
	var url = "shippingCWSxml.php?id=load_AppShipping_data&orderNo="+orderNo;
	var htmlobj	=$.ajax({url:url,async:false});
	
	var XMLinvoiceID	= htmlobj.responseXML.getElementsByTagName("invoiceID");
	
	for(loop=0;loop<XMLinvoiceID.length;loop++)
	{
		var invoiceID = XMLinvoiceID[loop].childNodes[0].nodeValue;
		var cvws = htmlobj.responseXML.getElementsByTagName('CVWSUrlStr')[loop].childNodes[0].nodeValue;
		var strInvoiceno = htmlobj.responseXML.getElementsByTagName('taxStr')[loop].childNodes[0].nodeValue;
		var orderNo = htmlobj.responseXML.getElementsByTagName('preOrderNo')[loop].childNodes[0].nodeValue;
		var color = htmlobj.responseXML.getElementsByTagName('color')[loop].childNodes[0].nodeValue;
		var SailingDate = htmlobj.responseXML.getElementsByTagName('SailingDate')[loop].childNodes[0].nodeValue;
		var shiQty = htmlobj.responseXML.getElementsByTagName('shiQty')[loop].childNodes[0].nodeValue;
		var strBuyerCode = htmlobj.responseXML.getElementsByTagName('strBuyerCode')[loop].childNodes[0].nodeValue;
		var recDate = htmlobj.responseXML.getElementsByTagName('recDate')[loop].childNodes[0].nodeValue;
		var summeryDate = htmlobj.responseXML.getElementsByTagName('summeryDate')[loop].childNodes[0].nodeValue;
	var comInvNo = htmlobj.responseXML.getElementsByTagName('comInvNo')[loop].childNodes[0].nodeValue;
	var cls = htmlobj.responseXML.getElementsByTagName('cls')[loop].childNodes[0].nodeValue;
	
	createApprovedShipData(tbl,invoiceID,cvws,strInvoiceno,orderNo,color,SailingDate,shiQty,strBuyerCode,recDate,summeryDate,comInvNo,cls);
	}
}

function createApprovedShipData(tbl,invoiceID,cvws,strInvoiceno,orderNo,color,SailingDate,shiQty,strBuyerCode,recDate,summeryDate,comInvNo,cls)
{
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className = cls;	
	
	var cell = row.insertCell(0);
		cell.setAttribute('height','20');
		cell.height = '25';
		cell.innerHTML = invoiceID;
		
		
		var cell = row.insertCell(1);
		cell.innerHTML = cvws;
		
		var cell = row.insertCell(2);
		cell.innerHTML = comInvNo;
		
		var cell = row.insertCell(3);
		cell.innerHTML = strInvoiceno;
		
		var cell = row.insertCell(4);
		cell.innerHTML = orderNo;
		
		var cell = row.insertCell(5);
		cell.innerHTML = color;
		
		var cell = row.insertCell(6);
		cell.innerHTML = SailingDate;
		
		var cell = row.insertCell(7);
		cell.innerHTML = shiQty;
		
		var cell = row.insertCell(8);
		cell.innerHTML = strBuyerCode;
		var cell = row.insertCell(9);
		cell.innerHTML = recDate;
		var cell = row.insertCell(10);
		cell.innerHTML = summeryDate;
}
function clearTbl(tbl)
{
	$("#"+tbl+" tr:gt(0)").remove();	
	
}
function loadApprovedOrderNoList()
{
	var url					='shippingCWSxml.php?id=load_AppOrder_list';
		var pub_xml_http	=$.ajax({url:url,async:false});
		var pub_style			=pub_xml_http.responseText.split("|");	
	
	$( "#txtAppOrderNo" ).autocomplete({
			source: pub_style
		});
}

function loadStatusWiseOrderNo()
{
	var url					='shippingCWSxml.php?id=load_Order_list';
		var pub_xml_http	=$.ajax({url:url,async:false});
		var pub_style			=pub_xml_http.responseText.split("|");	
	
	$( "#txtOrderNo" ).autocomplete({
			source: pub_style
		});
	document.getElementById('txtOrderNo').value='';
	//document.getElementById('cboOrderNo').innerHTML='';
	
}
function enterLoadStyleDetails(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				getStyleID();	
}

function getStyleID()
{
	var orderNo = document.getElementById('txtOrderNo').value;
	var url	='shippingCWSxml.php?id=getStyleDetails&orderno='+URLEncode(orderNo);
	var pub_xml_http	=$.ajax({url:url,async:false});
	
	document.getElementById('styleID').title= pub_xml_http.responseText;
	if(checkFirstsaleCostingAvailable())
		loadOrder_comInv_details();
	
	
}

function checkApprovedOrderAvailable()
{
	var styleId = document.getElementById('styleID').title;
	var ComInvNo = document.getElementById('cboComInvNo').value;
	
	var url = "shippingCWSxml.php?id=checkApprovedOrderAvailable&styleId="+styleId;
	url += "&ComInvNo="+URLEncode(ComInvNo);
	var htmlobj	=$.ajax({url:url,async:false});
	
	if(htmlobj.responseText == '')
		return false;
	else
	{
		alert("Approved Shipping Order Details available");
		return true;
			}
}

function checkFirstsaleCostingAvailable()
{
	var styleId = document.getElementById('styleID').title;	
	var url = "shippingCWSxml.php?id=checkFSCostingAvailable&styleId="+styleId;
	var htmlobj	=$.ajax({url:url,async:false});
	
	if(htmlobj.responseText == '')
	{
		alert("First Sale Costing not available for :"+ document.getElementById('txtOrderNo').value);
		clearShippingCWS();
		return false;
		}
	else
		return true;
}