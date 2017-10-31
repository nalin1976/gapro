//Start - main gri variables
$main0 						= 0;  	//select item
$main1 						= 1;		//delete button
$main2 					= 2;		//item description
$main3 					= 3;		//unit
$main4 						= 4;		//unit price
$main5 						= 5;    	//consumption
$main6			= 6;  //value
$main7 =7 //fs Category combo
var pubNo=0;
//End - main gri variables 

$(document).ready(function() 
{
	var url					='costworksheetXml.php?id=load_ord_str';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtOrderNo" ).autocomplete({
			source: pub_po_arr
		});
		
		
	var url					='costworksheetXml.php?id=load_style_str';
		var pub_xml_http	=$.ajax({url:url,async:false});
		var pub_style			=pub_xml_http.responseText.split("|");	
	
	$( "#txtStyle" ).autocomplete({
			source: pub_style
		});
});

function loadOrderData()
{
	//load order header data
	var url_h = 'costworksheetXml.php?id=load_ordHeader_data';
	url_h += '&orderNo='+URLEncode($("#txtOrderNo").val());
	var xml_http	=$.ajax({url:url_h,async:false});
	
	var FsCostingAv = xml_http.responseXML.getElementsByTagName('chkFsCostingAv')[0].childNodes[0].nodeValue
	if(FsCostingAv == '1')
	{
		alert("First Sale Costing available for "+document.getElementById("txtOrderNo").value);
		location= "costworksheet.php?";
		
	}
	var chkinvAv = xml_http.responseXML.getElementsByTagName('chkinvAv')[0].childNodes[0].nodeValue
	if(chkinvAv == '1')
	{
		alert("Pending Invoice Costing available for "+document.getElementById("txtOrderNo").value);
		location= "costworksheet.php?";
	}
	if(chkinvAv == '2')
	{
		alert("Invoice Costing not available for "+document.getElementById("txtOrderNo").value);
		location= "costworksheet.php?";
	}
	if(chkinvAv =='' && FsCostingAv=='')
	{
	$('#txtStyle').val(xml_http.responseXML.getElementsByTagName('style')[0].childNodes[0].nodeValue);
	$('#cboBuyer').val(xml_http.responseXML.getElementsByTagName('buyerId')[0].childNodes[0].nodeValue);
	$('#orderQty').val(xml_http.responseXML.getElementsByTagName('orderQty')[0].childNodes[0].nodeValue);
	$('#txtPreorderFob').val(xml_http.responseXML.getElementsByTagName('fob')[0].childNodes[0].nodeValue);
	$('#txtInvFOB').val(xml_http.responseXML.getElementsByTagName('invFob')[0].childNodes[0].nodeValue);
	/*document.getElementById("txtpcsCarton").value = xml_http.responseXML.getElementsByTagName('noOfCarton')[0].childNodes[0].nodeValue;*/
	document.getElementById("cboColor").value = xml_http.responseXML.getElementsByTagName('colorCode')[0].childNodes[0].nodeValue;
	//$('#txtOrderDate').val(xml_http.responseXML.getElementsByTagName('orderDate')[0].childNodes[0].nodeValue);
	var styleId = xml_http.responseXML.getElementsByTagName('styleId')[0].childNodes[0].nodeValue;
	document.getElementById("orderId").title = styleId;
	
	var smvVal = xml_http.responseXML.getElementsByTagName('smv')[0].childNodes[0].nodeValue;
	var smvRate = xml_http.responseXML.getElementsByTagName('smvRate')[0].childNodes[0].nodeValue
	var cmv = xml_http.responseXML.getElementsByTagName('dblNewCM')[0].childNodes[0].nodeValue
	
	$('#txtSMV').val(smvVal);
	$('#txtCMV').val(cmv);
	
	//load order details
	var url = 'costworksheetXml.php?id=load_ord_data';
	url += '&orderNo='+URLEncode($("#txtOrderNo").val());
	url += '&buyerId='+$('#cboBuyer').val();
	url += '&styleId='+styleId;
	
	var xml_http_obj	=$.ajax({url:url,async:false});
	var xml_itemID			=xml_http_obj.responseXML.getElementsByTagName('itemID');
	
	clearTbl('tblItemList');
	//fix_header();
	pubNo=0;
	for(var loop=0; loop<xml_itemID.length; loop++)
	{
		var xml_itemDet			= xml_http_obj.responseXML.getElementsByTagName('itemDetail')[loop].childNodes[0].nodeValue;
		var xml_unit  		    = xml_http_obj.responseXML.getElementsByTagName('unit')[loop].childNodes[0].nodeValue;
		var xml_unitPrice		= xml_http_obj.responseXML.getElementsByTagName('unitPrice')[loop].childNodes[0].nodeValue;
		var xml_conPc			= xml_http_obj.responseXML.getElementsByTagName('conPC')[loop].childNodes[0].nodeValue;
		var itemID				= xml_itemID[loop].childNodes[0].nodeValue;
		var xml_RwClass		= xml_http_obj.responseXML.getElementsByTagName('bgcolor')[loop].childNodes[0].nodeValue;
		var xml_categoryID = xml_http_obj.responseXML.getElementsByTagName('categoryId')[loop].childNodes[0].nodeValue;
		var xml_value = xml_http_obj.responseXML.getElementsByTagName('PcsValue')[loop].childNodes[0].nodeValue;
		var xml_desID = xml_http_obj.responseXML.getElementsByTagName('decriptionID')[loop].childNodes[0].nodeValue;
		var xml_canDeleteItem = xml_http_obj.responseXML.getElementsByTagName('canDeleteItem')[loop].childNodes[0].nodeValue;
		//var fsCategory = xml_http_obj.responseXML.getElementsByTagName('FScategory')[loop].childNodes[0].nodeValue;
		var displayItem = xml_http_obj.responseXML.getElementsByTagName('displayItem')[loop].childNodes[0].nodeValue;
		var OtherPackItem = xml_http_obj.responseXML.getElementsByTagName('OtherPackItem')[loop].childNodes[0].nodeValue;
		
		if(displayItem ==1)
		createCostItemGrid(xml_itemDet,xml_unit,xml_unitPrice,xml_conPc,itemID,xml_RwClass,xml_categoryID,xml_value,xml_desID,xml_canDeleteItem,OtherPackItem);	
	}
	
	document.getElementById("txtMaterialCost").innerHTML = xml_http_obj.responseXML.getElementsByTagName('matCost')[0].childNodes[0].nodeValue;
	document.getElementById("txtAccessoriesCost").innerHTML = xml_http_obj.responseXML.getElementsByTagName('accCost')[0].childNodes[0].nodeValue;
	document.getElementById("txtHanger").innerHTML = xml_http_obj.responseXML.getElementsByTagName('hangerCost')[0].childNodes[0].nodeValue;
	document.getElementById("txtbeltsCost").innerHTML = xml_http_obj.responseXML.getElementsByTagName('beltsCost')[0].childNodes[0].nodeValue;
	document.getElementById("txtTransportCost").innerHTML = xml_http_obj.responseXML.getElementsByTagName('transportCost')[0].childNodes[0].nodeValue;
	document.getElementById("txtcmpwCost").innerHTML = xml_http_obj.responseXML.getElementsByTagName('cmpwCost')[0].childNodes[0].nodeValue;
	document.getElementById("txtTotalCost").innerHTML = xml_http_obj.responseXML.getElementsByTagName('totCostpcs')[0].childNodes[0].nodeValue;
	
	fix_header('tblItemList',847,360);
	loadWashDryProcessDetails();
	//calculateINVfobDiff();
	claculateCategoryCost();
	}
}

function createCostItemGrid(xml_itemDet,xml_unit,xml_unitPrice,xml_conPc,itemID,xml_RwClass,xml_categoryID,xml_value,xml_desID,xml_canDeleteItem,OtherPackItem)
{
	var tbl = $('#tblItemList tbody');
	var lastRow 		= $('#tblItemList tbody tr').length;
	var row 			= tbl[0].insertRow(lastRow);
	row.className = xml_RwClass;
	//row.setAttribute('bgcolor',xml_RwClass);
	
	var rowCell 	  	= row.insertCell($main0);
	rowCell.id 		    = xml_categoryID;
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML  = ++pubNo
	//rowCell.innerHTML 	= "<input type=\"checkbox\" />";
	
	var rowCell 	  	= row.insertCell($main1);
	rowCell.className 	= "normalfnt";
	if(xml_canDeleteItem==1)
		rowCell.innerHTML 	= "<img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\" />";
	else
		rowCell.innerHTML ="";
	
	var rowCell 	  	= row.insertCell($main2);
	rowCell.id 	= itemID;
	rowCell.innerHTML 	= "<input type=\"text\" class=\"txtbox\" style=\"width:360px;\" value=\""+xml_itemDet+"\" />";
	
	var rowCell 	  	= row.insertCell($main3);
	rowCell.className 	= "normalfnt";
	rowCell.id 	= OtherPackItem;
	rowCell.innerHTML	= xml_unit;
	
	var rowCell 	  	= row.insertCell($main4);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML 	= "<input type=\"text\"  style=\"width:100px; text-align:right\" value=\""+xml_unitPrice+"\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\"caculateValue(this);\" onblur=\"calculateOtherPackinCost();claculateCategoryCost();\" />";
	
	var rowCell 	  	= row.insertCell($main5);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML 	= "<input type=\"text\" class=\"txtbox\" style=\"width:100px; text-align:right\" value=\""+xml_conPc+"\"  onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\"caculateValue(this);\" onblur=\"calculateOtherPackinCost();claculateCategoryCost();\"/>";
	
	var rowCell 	  	= row.insertCell($main6);
	rowCell.className 	= "normalfntRite";
	rowCell.id 			= xml_desID;
	rowCell.innerHTML	= xml_value;
	
	/*var rowCell 	  	= row.insertCell($main7);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML	= fsCategory;*/
}

function clearTbl(tbl)
{
	$("#"+tbl+" tr:gt(0)").remove();	
	
}

function fix_header(tblName,w,h)
{
	$("#"+tblName+"").fixedHeader({
	width: w,height: h
	});
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

function clearCostWorkSheet()
{
	var sURL = unescape(window.location.pathname);
    window.location.href = sURL;
	//$("#frmCostWorkSheet")[0].reset();
	clearTbl('tblItemList');
	document.getElementById('orderId').title = '';
	pubNo=0;
	}
	
function removeRow(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex-1;
	var value = objDel.parentNode.parentNode.cells[6].innerHTML;
	var matId = objDel.parentNode.parentNode.cells[2].id;
	var isOtherPack = objDel.parentNode.parentNode.cells[3].id;
	
	var url = 'costworksheetXml.php?id=delFSItem&styleID='+document.getElementById("orderId").title;
		url += '&matId='+matId;
	var xml_http_obj	=$.ajax({url:url,async:false});
	tblMain.deleteRow(rowNo);
	if(isOtherPack == 1)
		calculateOtherPackinCost();
		
	if(value>0)
		claculateCategoryCost();
}

/*function getOtherPackingIDdetails()
{
	var url='costworksheetXml.php?id=chkPackingItem';
	var xml_http_obj	=$.ajax({url:url,async:false});
	var otherPackingID = xml_http_obj.responseXML.getElementsByTagName('otherPackId')[0].childNodes[0].nodeValue;
	return otherPackingID;
}
*/
function calculateOtherPackinCost()
{
	var styleID = document.getElementById("orderId").title;
	var buyerID = document.getElementById("cboBuyer").value;
	
	var url='costworksheetXml.php?id=chkPackingItem&styleID='+styleID+'&buyerID='+buyerID;
	var xml_http_obj	=$.ajax({url:url,async:false});
	var otherPackingID = xml_http_obj.responseXML.getElementsByTagName('otherPackId')[0].childNodes[0].nodeValue;
	var hangerAv = xml_http_obj.responseXML.getElementsByTagName('hangerAv')[0].childNodes[0].nodeValue;
	var directLabourId = xml_http_obj.responseXML.getElementsByTagName('directLabourId')[0].childNodes[0].nodeValue;
	var marginId = xml_http_obj.responseXML.getElementsByTagName('marginId')[0].childNodes[0].nodeValue;
	
	var tbl = document.getElementById('tblItemList');	
	var packingCost = getPackingMatCost();
	var otherCost=0;
	if(hangerAv == '1')
		otherCost = parseFloat(2/12)-packingCost;
	else
		otherCost = parseFloat(1.5/12)-packingCost;
	
	var directLabourCost=0;
	var marginCost =0;
	
	//2012-04-24 if user tick apparel approval check box labour cost calculate according to fomula otherwise get preorder cm
	var chkCM =  (document.getElementById("chkApproval").checked==true?1:0);
	//2012-04-24
		
	for(var loop=1; loop<tbl.rows.length; loop++)
	{
		if(tbl.rows[loop].cells[$main2].id == otherPackingID)
		{			
			tbl.rows[loop].cells[$main4].childNodes[0].value = RoundNumbers(otherCost,4);
			if(otherCost<=0)
			{
				otherCost=0;
				tbl.rows[loop].cells[$main1].innerHTML = "<img width=\"15\" height=\"15\" onclick=\"removeRow(this);\" src=\"../../images/del.png\">";
			}
			else
			{
				tbl.rows[loop].cells[$main1].innerHTML="";
			}
				
			tbl.rows[loop].cells[$main6].innerHTML = RoundNumbers(otherCost,4);
			
		}
		
		if(tbl.rows[loop].cells[$main2].id == directLabourId)
		{
			var url_f = 'costworksheetXml.php?id=getLabourAndMarginCost&styleID='+styleID+'&buyerID='+buyerID;
			url_f += '&directLabourId='+directLabourId+'&marginId='+marginId+'&packingCost='+packingCost+'&chkCM='+chkCM;
			var xml_http	=$.ajax({url:url_f,async:false});
			directLabourCost = xml_http.responseXML.getElementsByTagName('labourCost')[0].childNodes[0].nodeValue;
			marginCost = xml_http.responseXML.getElementsByTagName('marginCost')[0].childNodes[0].nodeValue;
			
			tbl.rows[loop].cells[$main4].childNodes[0].value = RoundNumbers(directLabourCost,4);
			tbl.rows[loop].cells[$main6].innerHTML = RoundNumbers(directLabourCost,4);
		}
		
		if(tbl.rows[loop].cells[$main2].id == marginId)
		{
			tbl.rows[loop].cells[$main4].childNodes[0].value = RoundNumbers(marginCost,4);
			tbl.rows[loop].cells[$main6].innerHTML = RoundNumbers(marginCost,4);
		}
		
	}
}

function getPackingMatCost()
{
	var tbl = document.getElementById('tblItemList');
	var packCost=0;
	for(var loop=1; loop<tbl.rows.length; loop++)
	{
		if(tbl.rows[loop].cells[$main3].id == 1)
			packCost += parseFloat(tbl.rows[loop].cells[$main6].innerHTML);
	}
	return packCost;
}

function removeRowProcess(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex-1;
	tblMain.deleteRow(rowNo);
	
}

function caculateValue(objDel)
{
	var tblMain = objDel.parentNode.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex-1;
	var unitprice = isNaN(parseFloat(objDel.parentNode.parentNode.cells[$main4].childNodes[0].value)) == true ?0:parseFloat(objDel.parentNode.parentNode.cells[$main4].childNodes[0].value);
	var conPc = isNaN(parseFloat(objDel.parentNode.parentNode.cells[$main5].childNodes[0].value)) == true ?0:parseFloat(objDel.parentNode.parentNode.cells[$main5].childNodes[0].value);
	var value =unitprice*conPc;
	 var newnumber = Math.round(value*Math.pow(10,4))/Math.pow(10,4);
objDel.parentNode.parentNode.cells[$main6].innerHTML = newnumber.toFixed(4); 
	if(unitprice==0)
		objDel.parentNode.parentNode.cells[$main1].innerHTML = 
"<img width=\"15\" height=\"15\" onclick=\"removeRow(this);\" src=\"../../images/del.png\">";
	
}

function saveCostWorkSheet()
{
	if(!interfaceValidation())
		return;
	showBackGroundBalck();
	calOTLdate();
	saveCostSheetHeader();	
}

function interfaceValidation()
{
	var orderNo	= $('#txtOrderNo').val();
	var chkCount =0;
	var tbl = document.getElementById('tblItemList');
	var tblInv = document.getElementById('tblInvDryProcess');
	var buyerPOdate = document.getElementById('txtOrderDate').value;
	var txtFacDate = document.getElementById('txtFacDate').value;
	var txtOTLdate = document.getElementById('txtOTLdate').value;
	
	if(orderNo == '')
	{
		alert("Please enter 'Order No'");
		$('#txtOrderNo').focus();
		return false;
	}
	if(buyerPOdate == '')
	{
		alert("Please enter 'Buyer PO Date'");
		$('#txtOrderDate').focus();
		return false;
	}
	if(txtFacDate == '')
	{
		alert("Please enter 'Ex Factory Date'");
		$('#txtFacDate').focus();
		return false;
	}
	
	for(var loop=1; loop<tblInv.rows.length; loop++)
	{
		if(tblInv.rows[loop].cells[6].childNodes[0].selectedIndex == 0)
		{
			alert("Please select allocate category from 'Wash Dry Process' before save");
			return false;
		}
	}
	for(var loop=1; loop<tbl.rows.length; loop++)
	{
		if(parseFloat(tbl.rows[loop].cells[6].innerHTML) == 0)
		{
			alert(tbl.rows[loop].cells[$main2].childNodes[0].value + " value should be greater than 0");
			tbl.rows[loop].cells[$main2].childNodes[0].select();
			return false;
		}	
	}
	return true;
}

function saveCostSheetHeader()
{
	var orderNo	= $('#txtOrderNo').val();
	var reqApparelApprov =0;
	if(document.getElementById("chkApproval").checked)
		reqApparelApprov=1;
	var url = 'costworksheetXml.php?id=saveCostHeader'; 
	url 	+= '&orderNo='+URLEncode(orderNo);
	url		+= '&styleId='+document.getElementById("orderId").title;
	url 	+= '&strColor='+URLEncode(document.getElementById("cboColor").value);
	url 	+= '&buyerFOB='+$('#txtBuyerFob').val();
	url		+= '&orderQty='+document.getElementById("orderQty").value;
	url		+= '&txtSMV='+document.getElementById("txtSMV").value;
	url		+= '&txtpcsCarton='+document.getElementById("txtpcsCarton").value;
	url		+= '&txtCMV='+document.getElementById("txtCMV").value;
	url		+= '&txtOTLdate='+document.getElementById("txtOTLdate").value;
	url		+= '&txtOrderDate='+document.getElementById("txtOrderDate").value;
	url		+= '&txtFacDate='+document.getElementById("txtFacDate").value;
	url		+= '&txtPreorderFob='+document.getElementById("txtPreorderFob").value;
	url		+= '&txtInvFOB='+document.getElementById("txtInvFOB").value;
	url 	+= '&fsaleFob='+document.getElementById("txtTotalCost").innerHTML;
	url 	+= '&reqApparelApprov='+reqApparelApprov;
	var xml_http_obj	=$.ajax({url:url,async:false});
	
	if(xml_http_obj.responseText == 1)
		saveFirstsaleCostDetails();
	else
	{
		alert('Error occured while saving the data ');
		hideBackGroundBalck();
		return false;
		}
}

function saveFirstsaleCostDetails()
{
	var styleId = document.getElementById("orderId").title;
	var requestCount = 0;
	var responseCount =0;
	var tbl = document.getElementById('tblItemList');	
	
	for(var loop=1; loop<tbl.rows.length; loop++)
	{
		/*if(tbl.rows[loop].cells[$main0].childNodes[0].checked)
		{*/
			requestCount++;
			var url = 'costworksheetXml.php?id=saveCostDetails';
			url += '&styleId='+styleId;
			url += '&matDetailID='+tbl.rows[loop].cells[$main2].id;
			url += '&matDetailDes='+URLEncode(tbl.rows[loop].cells[$main2].childNodes[0].value);
			url += '&unitPrice='+tbl.rows[loop].cells[$main4].childNodes[0].value;
			url += '&conPc='+tbl.rows[loop].cells[$main5].childNodes[0].value;
			url += '&value='+tbl.rows[loop].cells[$main6].innerHTML;
			url += '&categoryId='+tbl.rows[loop].cells[$main6].id;
			
			var xml_http	=$.ajax({url:url,async:false});
			
			if(xml_http.responseText == 1)
				responseCount++;
		//}
	}
	
	if(requestCount == responseCount)
	{
		/*alert('Saved successfully');
		return;*/
		saveInvProcessDetails();
	}
	else
	{
		alert('Error occured while saving the data ');
		hideBackGroundBalck();
		return false;
	}
}

function calculateINVfobDiff()
{
	var invFob = isNaN(parseFloat(document.getElementById('txtInvFOB').value)) == true?0:parseFloat(document.getElementById('txtInvFOB').value);
	
	var cmpwFob = isNaN(parseFloat(document.getElementById('txtTotalCost').innerHTML)) == true?0:parseFloat(document.getElementById('txtTotalCost').innerHTML);
	
	var diff = (invFob-cmpwFob)/invFob*100;
	var newnumber = RoundNumbers(diff,4);//Math.round(diff*Math.pow(10,4))/Math.pow(10,4)*100;
	document.getElementById('txtFobDiff').value = newnumber;// (newnumber.toFixed(4));
}

function claculateCategoryCost()
{
	var tbl = document.getElementById('tblItemList');	
	var materialCost =0;
	var accCost =0;
	var hanger=0;
	var belts =0;
	var transportCost =0;
	var cmpwCost =0;
	var value=0;
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		 //tbl.rows[loop].cells[$main0].childNodes[0].checked = true;
		 var descriptionId =  parseInt(tbl.rows[loop].cells[$main6].id);
		 value = parseFloat(tbl.rows[loop].cells[$main6].innerHTML);
		 if(value<0)
		 	value=0;
		 switch(descriptionId)
		 {
			case 1:
			{
				materialCost += value;
				
				continue;
				}
			case 2 :
			{
				accCost += value;
				continue;
				}
			case 3 :
			{
				transportCost += value;
				
				continue;
				}
			case 4 :
			{
				cmpwCost += value;
				continue;
				}
			case 5 :
			{
				hanger += value;
				continue;
				}
			case 6 :
			{
				belts += value;
				continue;
				}
		 }
		
	}
	calculateInvProcessCategoryCost(materialCost,accCost,hanger,belts,transportCost,cmpwCost);
	/*var totCost = materialCost+accCost+hanger+belts+transportCost+cmpwCost;
	document.getElementById("txtMaterialCost").innerHTML = materialCost.toFixed(4);
	document.getElementById("txtAccessoriesCost").innerHTML = accCost.toFixed(4);
	document.getElementById("txtHanger").innerHTML = hanger.toFixed(4);
	document.getElementById("txtbeltsCost").innerHTML = belts.toFixed(4);
	document.getElementById("txtTransportCost").innerHTML = transportCost.toFixed(4);
	document.getElementById("txtcmpwCost").innerHTML = cmpwCost.toFixed(4);
	document.getElementById("txtTotalCost").innerHTML = totCost.toFixed(4);*/
	calculateINVfobDiff();
		
}
function calculateInvProcessCategoryCost(materialCost,accCost,hanger,belts,transportCost,cmpwCost)
{
	var tbl = document.getElementById('tblInvDryProcess');
	var tbllength =  tbl.rows.length;
	
	if(tbllength>1)
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			var categotyId = parseInt(tbl.rows[loop].cells[6].id);
			
			switch(categotyId)
			 {
				case 1:
				{
					materialCost += parseFloat(tbl.rows[loop].cells[5].innerHTML);
					
					continue;
					}
				case 2 :
				{
					accCost += parseFloat(tbl.rows[loop].cells[5].innerHTML);
					continue;
					}
				case 3 :
				{
					transportCost += parseFloat(tbl.rows[loop].cells[5].innerHTML);
					
					continue;
					}
				case 4 :
				{
					cmpwCost += parseFloat(tbl.rows[loop].cells[5].innerHTML);
					continue;
					}
				case 5 :
				{
					hanger += parseFloat(tbl.rows[loop].cells[5].innerHTML);
					continue;
					}
				case 6 :
				{
					belts += parseFloat(tbl.rows[loop].cells[5].innerHTML);
					continue;
					}	
			 }
		}
	}
	var totCost = materialCost+accCost+hanger+belts+transportCost+cmpwCost;
	document.getElementById("txtMaterialCost").innerHTML = materialCost.toFixed(4);
	document.getElementById("txtAccessoriesCost").innerHTML = accCost.toFixed(4);
	document.getElementById("txtHanger").innerHTML = hanger.toFixed(4);
	document.getElementById("txtbeltsCost").innerHTML = belts.toFixed(4);
	document.getElementById("txtTransportCost").innerHTML = transportCost.toFixed(4);
	document.getElementById("txtcmpwCost").innerHTML = cmpwCost.toFixed(4);
	document.getElementById("txtTotalCost").innerHTML = totCost.toFixed(4);
	
}
function enableEnterSubmitLoadDetails(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				loadOrderData();
}

function loadCostWorksheet(styleId,invoiceID)
{
	if(styleId != 0)
	{
		document.getElementById("invoiceID").value = invoiceID
		var url1 = 'costworksheetXml.php?id=load_costwsPending_HeaderData';
	url1 += '&styleId='+styleId;
	url1 += '&invoiceID='+invoiceID;
	var xml_http	=$.ajax({url:url1,async:false});
	
	$('#txtStyle').val(xml_http.responseXML.getElementsByTagName('style')[0].childNodes[0].nodeValue);
	$('#cboBuyer').val(xml_http.responseXML.getElementsByTagName('buyerId')[0].childNodes[0].nodeValue);
	$('#orderQty').val(xml_http.responseXML.getElementsByTagName('orderQty')[0].childNodes[0].nodeValue);
	var strColor = xml_http.responseXML.getElementsByTagName('colorCode')[0].childNodes[0].nodeValue;
	var preorderNo = xml_http.responseXML.getElementsByTagName('strOrderNo')[0].childNodes[0].nodeValue
	if(strColor != '')
		preorderNo = preorderNo+'-'+strColor;
	document.getElementById("txtOrderNo").value = preorderNo;
	$('#txtPreorderFob').val(xml_http.responseXML.getElementsByTagName('preorderfob')[0].childNodes[0].nodeValue);
	$('#txtInvFOB').val(xml_http.responseXML.getElementsByTagName('invFob')[0].childNodes[0].nodeValue);
	//document.getElementById("txtOrderNo").value = xml_http.responseXML.getElementsByTagName('strOrderNo')[0].childNodes[0].nodeValue
	document.getElementById("txtBuyerFob").value = xml_http.responseXML.getElementsByTagName('buyerFob')[0].childNodes[0].nodeValue
	document.getElementById("txtpcsCarton").value = xml_http.responseXML.getElementsByTagName('noOfCarton')[0].childNodes[0].nodeValue;
	document.getElementById("cboColor").value = xml_http.responseXML.getElementsByTagName('colorCode')[0].childNodes[0].nodeValue;
	//$('#txtOrderDate').val(xml_http.responseXML.getElementsByTagName('orderDate')[0].childNodes[0].nodeValue);
	var styleId = xml_http.responseXML.getElementsByTagName('styleId')[0].childNodes[0].nodeValue;
	document.getElementById("orderId").title = styleId;
	
	document.getElementById("txtSMV").value = xml_http.responseXML.getElementsByTagName('smv')[0].childNodes[0].nodeValue;
	document.getElementById("txtCMV").value = xml_http.responseXML.getElementsByTagName('CMvalue')[0].childNodes[0].nodeValue;
	document.getElementById("txtOTLdate").value = xml_http.responseXML.getElementsByTagName('OTLPoDate')[0].childNodes[0].nodeValue;
	document.getElementById("txtOrderDate").value = xml_http.responseXML.getElementsByTagName('BuyerPoDate')[0].childNodes[0].nodeValue;
	document.getElementById("txtFacDate").value = xml_http.responseXML.getElementsByTagName('exFacDate')[0].childNodes[0].nodeValue;
	var exAppReq = xml_http.responseXML.getElementsByTagName('isApparelAppReq')[0].childNodes[0].nodeValue;
	if(exAppReq ==1)
		document.getElementById("chkApproval").checked = true;
		
	var url2 = 'costworksheetXml.php?id=load_pendingCostWS_details';
	url2 += '&styleId='+styleId;
	url2 += '&buyer='+document.getElementById("cboBuyer").value;
	
	var xml_http_obj	=$.ajax({url:url2,async:false});
	var xml_itemID			=xml_http_obj.responseXML.getElementsByTagName('itemID');
	
	clearTbl('tblItemList');
	//fix_header();
	//var xml_canDeleteItem=0;//can't delete saved item
		for(var loop=0; loop<xml_itemID.length; loop++)
		{
			var xml_itemDet			= xml_http_obj.responseXML.getElementsByTagName('itemDetail')[loop].childNodes[0].nodeValue;
			var xml_unit  		    = xml_http_obj.responseXML.getElementsByTagName('unit')[loop].childNodes[0].nodeValue;
			var xml_unitPrice		= xml_http_obj.responseXML.getElementsByTagName('unitPrice')[loop].childNodes[0].nodeValue;
			var xml_conPc			= xml_http_obj.responseXML.getElementsByTagName('conPC')[loop].childNodes[0].nodeValue;
			var itemID				= xml_itemID[loop].childNodes[0].nodeValue;
			var xml_RwClass		= xml_http_obj.responseXML.getElementsByTagName('bgcolor')[loop].childNodes[0].nodeValue;
			var xml_categoryID = xml_http_obj.responseXML.getElementsByTagName('categoryId')[loop].childNodes[0].nodeValue;
			var xml_value = xml_http_obj.responseXML.getElementsByTagName('PcsValue')[loop].childNodes[0].nodeValue;
			var xml_desID = xml_http_obj.responseXML.getElementsByTagName('decriptionID')[loop].childNodes[0].nodeValue;
			//var fsCategory = xml_http_obj.responseXML.getElementsByTagName('FScategory')[loop].childNodes[0].nodeValue;
			var xml_canDeleteItem=xml_http_obj.responseXML.getElementsByTagName('canDeleteItem')[loop].childNodes[0].nodeValue;
			var OtherPackItem = xml_http_obj.responseXML.getElementsByTagName('OtherPackItem')[loop].childNodes[0].nodeValue;
			createCostItemGrid(xml_itemDet,xml_unit,xml_unitPrice,xml_conPc,itemID,xml_RwClass,xml_categoryID,xml_value,xml_desID,xml_canDeleteItem,OtherPackItem);	
		}
		loadInvProcessDetails(styleId);
		claculateCategoryCost();
		
		if(manageCWSsendToapproval && invoiceID!=1)
			document.getElementById('butSentApp').style.display = 'inline';
		//if shipping details not available can delete fist sale details
		if(invoiceID==1)
			document.getElementById('butDelete').style.display = 'inline';
		if(invoiceID!=1)
			document.getElementById('cboConsignee').value = xml_http.responseXML.getElementsByTagName('consignee')[0].childNodes[0].nodeValue;
		
		fix_header('tblItemList',847,360);
	}	
}

function loadCostWSReport(styleID)
{
	window.open("costworksheetRpt.php?styleId=" + styleID,'frmCostWorkSheet');
}
function loadOrderContractRpt(styleID)
{
	window.open("orderContractRpt.php?styleID=" + styleID,'frmCostWorkSheet');
	
}
function viewInvoiceRpt(styleID,invoiceId)
{
	window.open("taxInvoiceRpt.php?invoiceID=" + invoiceId+"&styleID="+styleID,'frmCostWorkSheet');
}
function viewCVWSRpt(styleID,invoiceId)
{
	window.open("cvwsReport.php?invoiceID=" + invoiceId+"&styleID="+styleID,'frmCostWorkSheet');
}
function updateShipData()
{
	var styleId=document.getElementById("orderId").title;
	var invID = document.getElementById("invoiceID").value;
	
	var url  = "costworksheetXml.php?id=checkFileUploaded&styleId="+styleId;
	var htmlobj = $.ajax({url:url,async:false});
	var checkUpload = htmlobj.responseXML.getElementsByTagName("checkUpload")[0].childNodes[0].nodeValue;
	if(checkUpload=="False")
	{
		alert("Please attach the buyer purchase order document befor send to approval.")
		document.getElementById("butUpload").focus();
		return;
	}
	
	var reqApparelApprov =0; 
	if(document.getElementById("chkApproval").checked)
		reqApparelApprov=1;
	
	 var url_a = 'costworksheetXml.php?id=chkActualDataAv';
		url_a += '&styleId='+styleId;	
	var http_obj	=$.ajax({url:url_a,async:false});	
	
	if(invID != 1)
	{
		if(http_obj.responseText == '1')
		{
			if(reqApparelApprov==0)
			{
				if(confirm('Is Apparel Approval Required?'))
					reqApparelApprov=1;
			}
			
			
			/*
			BEGIN - 07-10-2010 
			var url = 'costworksheetXml.php?id=SendtoAppCWS';
			url += '&styleId='+styleId;
			url += '&invID='+invID;
			url += '&reqApparelApprov='+reqApparelApprov;
			var xml_http_obj	=$.ajax({url:url,async:false});
			if(xml_http_obj.responseText == 1)
			{	
				var sURL = unescape(window.location.pathname);
				window.location.href = sURL;	
			}
			END - 07-10-2010*/
			
			window.open("sendToApproval.php?styleId=" + styleId+"&invID="+invID+"&reqApparelApprov="+reqApparelApprov,'sendToApproval.php');
		}
		else
		{
			alert(http_obj.responseText);
			return false;
		}
	}
	else
	{
		alert("Please save shipping data before 'Send to approval'");
		return false;
	}
	
}
// BEGIN - 07-10-2010 
function sendToApproval(styleId,invID,reqApparelApprov)
{
	var url = 'costworksheetXml.php?id=SendtoAppCWS';
	url += '&styleId='+styleId;
	url += '&invID='+invID;
	//url += '&reqApparelApprov='+reqApparelApprov;
	var xml_http_obj	=$.ajax({url:url,async:false});
	if(xml_http_obj.responseText == 1)
	{	
		//var sURL = unescape(window.location.pathname);
		//window.location.href = sURL;
		//document.getElementById("sentoApproval").style.display="none";	
		window.opener.location ="costworksheet.php";
		window.close();
	}
	else
	{
		alert(xml_http_obj.responseText);
		}
}
function closeWindow()
{
	window.close();
}
//END - 07-10-2010
function approveCWS(obj)
{
	var tblMain = obj.parentNode.parentNode.parentNode;
	var rowNo = obj.parentNode.parentNode;
		
	var url = 'costworksheetXml.php?id=ApproveCWS';
	url += '&styleId='+rowNo.cells[0].id;
	url += '&invID='+rowNo.cells[33].innerHTML;
	
	var xml_http_obj	=$.ajax({url:url,async:false});
	if(xml_http_obj.responseText == 1)
	{	
		/*var sURL = unescape(window.location.pathname);
   		 window.location.href = sURL;	*/
		 removeRowProcess(obj);
	}
	else
		alert(xml_http_obj.responseText);
}

function rejectCWS(obj)
{
	var tblMain = obj.parentNode.parentNode.parentNode;
	var rowNo = obj.parentNode.parentNode;
	var reason = prompt("Please enter reject reason", "");
	var url = 'costworksheetXml.php?id=RejectCWS';
	url += '&styleId='+rowNo.cells[0].id;
	url += '&invID='+rowNo.cells[27].childNodes[0].nodeValue;
	url += '&reason='+URLEncode(reason);
	url += '&type='+'reject';
	
	var xml_http_obj	=$.ajax({url:url,async:false});
	if(xml_http_obj.responseText == 1)
	{
		 removeRowProcess(obj);
	}
}
function reviseCWS(obj)
{
	var tblMain = obj.parentNode.parentNode.parentNode;
	var rowNo = obj.parentNode.parentNode;
	var reason = prompt("Please enter revise reason", "");
	if(reason == '' || reason == null)
	{
		alert('Can not revise order without having a reason');
		obj.checked = false;
		return false;
	}
	else
	{
		var url = 'costworksheetXml.php?id=RejectCWS';
		url += '&styleId='+rowNo.cells[0].id;
		url += '&invID='+rowNo.cells[27].childNodes[0].nodeValue;
		url += '&reason='+reason;
		url += '&type='+'revise';
		var xml_http_obj	=$.ajax({url:url,async:false});
		if(xml_http_obj.responseText == 1)
		{
			removeRowProcess(obj);
		}
	}
	
}

function calOTLdate()
{
	var url = 'costworksheetXml.php?id=calOTLDate';
	url += '&buyerPODate='+document.getElementById("txtOrderDate").value;
	var xml_http_obj	=$.ajax({url:url,async:false});
	
	document.getElementById("txtOTLdate").value=xml_http_obj.responseText;
}
function UploadFile()
{
	if(document.getElementById("orderId").title == '')
	{
		alert("Please select 'Order No'");
		document.getElementById("txtOrderNo").focus();
		return;
	}
	var styleId = document.getElementById('orderId').title;
	var	popwindow= window.open ("cwsUpload.php?styleId=" + styleId, "CWS Uploader","location=1,status=1,scrollbars=1,width=500,height=360");
	popwindow.moveTo(((screen.width - 450)/2),((screen.height - 160)/2));
	popwindow.focus();
}
function addPreorderItems()
{
	var styleId = document.getElementById("orderId").title;
	if(styleId == '')
	{
		alert("Select Order No");
		document.getElementById("txtOrderNo").select();
		return;
	}
	showBackGround('divBG',0);
	var url = "popupItem.php?StyleId="+styleId;
	
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(566,532,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	fix_header('tblPopItem',550,388);		
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
function LoadSubCat(obj)
{
		
	var url = 'costworksheetXml.php?id=loadSubcategoryDetails';
	url += '&mainStoreID='+obj.value;
	url += "&styleId="+document.getElementById("orderId").title;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboPopSubCat').innerHTML = htmlobj.responseXML.getElementsByTagName("subCat")[0].childNodes[0].nodeValue;
}

function LoadPopItems()
{
	/*if(ev.KeyCode!='13')
		return;*/
	var url = 'costworksheetXml.php?id=LoadPopItems';
		url += "&StyleId="+document.getElementById("orderId").title;
		url += "&MainCat="+document.getElementById('cboPopMainCat').value;
		url += "&SubCat="+document.getElementById('cboPopSubCat').value;
		url += "&ItemDesc="+URLEncode(document.getElementById('txtDesc').value.trim());
	htmlobj=$.ajax({url:url,async:false});
	CreatePopUpItemGrid(htmlobj);
}

function CreatePopUpItemGrid(htmlobj)
{
	var XMLItemId 	= htmlobj.responseXML.getElementsByTagName("ItemId");
	var XMLItemDesc = htmlobj.responseXML.getElementsByTagName("ItemDesc");
	var XMLUnit 	= htmlobj.responseXML.getElementsByTagName("Unit");
	var tbl 		= document.getElementById('tblPopItem');
	clearTbl('tblPopItem');
	for(loop=0;loop<XMLItemId.length;loop++)
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
		cell.id = XMLItemId[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLItemDesc[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.innerHTML = XMLUnit[loop].childNodes[0].nodeValue;
	}
}
function AddToMainPage()
{
	var tbl 	= document.getElementById('tblPopItem');
	var tblMain = document.getElementById('tblItemList');
	var styleId = document.getElementById('orderId').title;
	var buyerId = document.getElementById('cboBuyer').value;
	var xml_canDeleteItem=1;
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			var matID = tbl.rows[loop].cells[1].id;
			
			if(validatePopItem(matID))
			{
				var url = "costworksheetXml.php?id=getPreorderItemDetails";
					url += "&styleId="+styleId;
					url += "&buyerId="+buyerId;
					url += "&matID="+matID;
				htmlobj=$.ajax({url:url,async:false});	
				
				var xml_unitPrice = htmlobj.responseXML.getElementsByTagName("unitPrice")[0].childNodes[0].nodeValue;
				/*if(xml_unitPrice>0)
				{*/
					var xml_itemDet = htmlobj.responseXML.getElementsByTagName("itemDetail")[0].childNodes[0].nodeValue;
					var xml_unit = htmlobj.responseXML.getElementsByTagName("unit")[0].childNodes[0].nodeValue;
					var xml_conPc = htmlobj.responseXML.getElementsByTagName("conPC")[0].childNodes[0].nodeValue;
					var itemID = htmlobj.responseXML.getElementsByTagName("itemID")[0].childNodes[0].nodeValue;
					var xml_RwClass = htmlobj.responseXML.getElementsByTagName("bgcolor")[0].childNodes[0].nodeValue;
					var xml_categoryID = htmlobj.responseXML.getElementsByTagName("categoryId")[0].childNodes[0].nodeValue;
					var xml_value = htmlobj.responseXML.getElementsByTagName("PcsValue")[0].childNodes[0].nodeValue;
					var xml_desID = htmlobj.responseXML.getElementsByTagName("decriptionID")[0].childNodes[0].nodeValue;
					var xml_canDeleteItem = htmlobj.responseXML.getElementsByTagName("canDeleteItem")[0].childNodes[0].nodeValue;
					
					createCostItemGrid(xml_itemDet,xml_unit,xml_unitPrice,xml_conPc,itemID,xml_RwClass,xml_categoryID,xml_value,xml_desID,xml_canDeleteItem);		
				//}
				claculateCategoryCost();
			}		
		}
	}
}

function validatePopItem(matID)
{
	var tbl = document.getElementById('tblItemList');
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		var mainMatID = tbl.rows[loop].cells[2].id;
		if(matID == mainMatID)
		{
			alert("Item : "+tbl.rows[loop].cells[2].childNodes[0].value +" available in Cost Worksheet");
			return false;	
		}	
	}
	return true;
	
}
function loadWashDryProcessDetails()
{
	var url = "costworksheetXml.php?id=getWashdryProcess";
		url += "&styleId="+document.getElementById('orderId').title;
		htmlobj=$.ajax({url:url,async:false});
		var XMLintProcessId 	= htmlobj.responseXML.getElementsByTagName("intProcessId");
		clearTbl('tblInvDryProcess');
	for(loop=0;loop<XMLintProcessId.length;loop++)
	{
		var intProcessId = XMLintProcessId[loop].childNodes[0].nodeValue;
		var processDesc = htmlobj.responseXML.getElementsByTagName("strDescription")[loop].childNodes[0].nodeValue;
		var unitprice = htmlobj.responseXML.getElementsByTagName("unitprice")[loop].childNodes[0].nodeValue;
		var conpc = htmlobj.responseXML.getElementsByTagName("conpc")[loop].childNodes[0].nodeValue;
		var ItemUnit = htmlobj.responseXML.getElementsByTagName("unit")[loop].childNodes[0].nodeValue;
		var FScategory = htmlobj.responseXML.getElementsByTagName("FScategory")[loop].childNodes[0].nodeValue;
		var categoryId =  htmlobj.responseXML.getElementsByTagName("FScategoryId")[loop].childNodes[0].nodeValue;
		createDryProcessGrid(intProcessId,processDesc,conpc,ItemUnit,unitprice,FScategory,categoryId)
	}
}
function createDryProcessGrid(intProcessId,processDesc,conpc,ItemUnit,unitprice,FScategory,categoryId)
{
	var tbl 	= document.getElementById('tblInvDryProcess');
	var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		//row.className = "bcgcolor-tblrowWhite";
		
		var cell = row.insertCell(0);
		cell.className ="grid_raw";
		cell.setAttribute('height','20');
		cell.innerHTML = "<img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRowProcess(this);\" />";
		
		var cell = row.insertCell(1);
		cell.className ="grid_raw";
		cell.id = intProcessId;
		cell.innerHTML = processDesc;
		
		var cell = row.insertCell(2);
		cell.className ="grid_raw";
		cell.innerHTML = ItemUnit;
		
		var cell = row.insertCell(3);
		cell.className ="grid_raw";
		cell.innerHTML = "<input type=\"text\"  style=\"width:60px; text-align:right\" value=\""+unitprice+"\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\"caculateValueDryProcess(this);\" onblur=\"claculateCategoryCost();\" />";
		
		var cell = row.insertCell(4);
		cell.className ="grid_raw";
		cell.innerHTML = conpc;
		
		var cell = row.insertCell(5);
		cell.className ="grid_raw";
		cell.innerHTML = unitprice;
		
		var cell = row.insertCell(6);
		cell.className ="grid_raw";
		cell.id = categoryId;
		cell.innerHTML = FScategory;
}

function AllocateMaterials(obj)
{
	var tblTd = obj.parentNode;
	tblTd.id =obj.value; 
	claculateCategoryCost();
}

function saveInvProcessDetails()
{
	var tbl = document.getElementById('tblInvDryProcess');
	var styleId = document.getElementById('orderId').title;
	for(var i=1; i<tbl.rows.length;i++)
	{
		var url ="costworksheetXml.php?id=saveWashDryProcessDetails";
			url += "&styleId="+styleId;
			url += "&processId="+tbl.rows[i].cells[1].id
			url += "&strUnit="+URLEncode(tbl.rows[i].cells[2].innerHTML);
			url += "&unitprice="+tbl.rows[i].cells[3].childNodes[0].value;
			url += "&conpc="+tbl.rows[i].cells[4].innerHTML;
			url += "&fsCategoryId="+tbl.rows[i].cells[6].childNodes[0].selectedIndex;
			htmlobj=$.ajax({url:url,async:false});
	}
	
	alert("Saved successfully");
	hideBackGroundBalck();
	var sURL = unescape(window.location.pathname);
    	window.location.href = sURL;
	return;
}
function loadInvProcessDetails(styleId)
{
	var url = "costworksheetXml.php?id=savedInvProcessDetails";
		url += "&styleId="+styleId;
		htmlobj=$.ajax({url:url,async:false});
		var XMLintProcessId 	= htmlobj.responseXML.getElementsByTagName("intProcessId");
		clearTbl('tblInvDryProcess');
	for(loop=0;loop<XMLintProcessId.length;loop++)
	{
		var intProcessId = XMLintProcessId[loop].childNodes[0].nodeValue;
		var processDesc = htmlobj.responseXML.getElementsByTagName("strDescription")[loop].childNodes[0].nodeValue;
		var unitprice = htmlobj.responseXML.getElementsByTagName("unitprice")[loop].childNodes[0].nodeValue;
		var conpc = htmlobj.responseXML.getElementsByTagName("conpc")[loop].childNodes[0].nodeValue;
		var ItemUnit = htmlobj.responseXML.getElementsByTagName("unit")[loop].childNodes[0].nodeValue;
		var FScategory = htmlobj.responseXML.getElementsByTagName("FScategory")[loop].childNodes[0].nodeValue;
		var categoryId = htmlobj.responseXML.getElementsByTagName("FScategoryId")[loop].childNodes[0].nodeValue;
		createDryProcessGrid(intProcessId,processDesc,conpc,ItemUnit,unitprice,FScategory,categoryId)
	}
}
function showExcelFile()
{
	var styleId = document.getElementById('orderId').title;
	var url = "../../Reports/excel/xclrptOrderBook.php?styleID="+styleId;
	window.open(url,'frmCostWorkSheet');
}
function showInvExcelReport()
{
	var styleId = document.getElementById('orderId').title;
	var url = "../../Reports/excel/xlsinvoicecostreport.php?orderNo="+styleId+"&reportCat=1";
	window.open(url,'frmCostWorkSheet');
}
function AllocateFSCategory(obj)
{
	var tblTd = obj.parentNode.parentNode;
	tblTd.cells[0].id =obj.value;
	var desId = obj.value; 
	var catId = desId;
	switch(desId)
	{
		case '3':
		{
			catId=5;
			break;
		}
		case '4':
		{
			catId=6;
			break;
		}
	}
	
	tblTd.cells[6].id =catId; 
	claculateCategoryCost();
	}
	
function loadApprovedCWS(tblName)
{
	loadApproveOrderNoList('txtAppOrderNo');
	var orderNo = document.getElementById('txtAppOrderNo').value;
	var buyer = document.getElementById('cboAppBuyer').value;
	var taxStatus = document.getElementById('cboTaxStatus').value;
	var appDfrom = document.getElementById('txtAppDfrom').value;
	var appDto =  document.getElementById('txtAppDateTo').value;
	
	if(orderNo != '')
		orderNo = URLEncode(orderNo);
	
		
	var url = "costworksheetXml.php?id=getApprovedDetails";	
		url += "&orderNo="+orderNo;
		url += "&buyer="+buyer;
		url += "&taxStatus="+taxStatus;
		url += "&appDfrom="+appDfrom;
		url += "&appDto="+appDto;
		url += "&ocStatus="+document.getElementById('cboOC').value;	
	htmlobj=$.ajax({url:url,async:false});	
	
	var XMLStyleId	= htmlobj.responseXML.getElementsByTagName("StyleId");
	var tbl 	= document.getElementById(tblName);
	//var tblName = 'appCWSlist';
	clearTbl(tblName);
	for(loop=0;loop<XMLStyleId.length;loop++)
	{
		
		var StyleId = XMLStyleId[loop].childNodes[0].nodeValue;
		var orderNo = htmlobj.responseXML.getElementsByTagName("orderNo")[loop].childNodes[0].nodeValue;
		var color = htmlobj.responseXML.getElementsByTagName("color")[loop].childNodes[0].nodeValue;
		var intOrderQty = htmlobj.responseXML.getElementsByTagName("intOrderQty")[loop].childNodes[0].nodeValue;
		var preOederSMV = htmlobj.responseXML.getElementsByTagName("preOederSMV")[loop].childNodes[0].nodeValue;
		var dblPCScarton = htmlobj.responseXML.getElementsByTagName("dblPCScarton")[loop].childNodes[0].nodeValue;
		var dblCMvalue = htmlobj.responseXML.getElementsByTagName("dblCMvalue")[loop].childNodes[0].nodeValue;
		
		var buyerFOB = htmlobj.responseXML.getElementsByTagName("buyerFOB")[loop].childNodes[0].nodeValue;
		var dblPreorderFob = htmlobj.responseXML.getElementsByTagName("dblPreorderFob")[loop].childNodes[0].nodeValue;
		var dblInvFob = htmlobj.responseXML.getElementsByTagName("dblInvFob")[loop].childNodes[0].nodeValue;
		var dblFsaleFob = htmlobj.responseXML.getElementsByTagName("dblFsaleFob")[loop].childNodes[0].nodeValue;
		var comFOB = htmlobj.responseXML.getElementsByTagName("comFOB")[loop].childNodes[0].nodeValue;
		var buyerCode = htmlobj.responseXML.getElementsByTagName("buyerCode")[loop].childNodes[0].nodeValue;
		
		var dblInvoiceId = htmlobj.responseXML.getElementsByTagName("dblInvoiceId")[loop].childNodes[0].nodeValue;
		var strComInvNo = htmlobj.responseXML.getElementsByTagName("strComInvNo")[loop].childNodes[0].nodeValue;
		var actFabConPC = htmlobj.responseXML.getElementsByTagName("actFabConPC")[loop].childNodes[0].nodeValue;
		var actPocConpc = htmlobj.responseXML.getElementsByTagName("actPocConpc")[loop].childNodes[0].nodeValue;
		var actThreadConpc = htmlobj.responseXML.getElementsByTagName("actThreadConpc")[loop].childNodes[0].nodeValue;
		var actSMV = htmlobj.responseXML.getElementsByTagName("actSMV")[loop].childNodes[0].nodeValue;
		var actDryWashPrice = htmlobj.responseXML.getElementsByTagName("actDryWashPrice")[loop].childNodes[0].nodeValue;
		var actWetWashPrice = htmlobj.responseXML.getElementsByTagName("actWetWashPrice")[loop].childNodes[0].nodeValue;
		var threadConpc = htmlobj.responseXML.getElementsByTagName("threadConpc")[loop].childNodes[0].nodeValue;
		
		var FSfabConpc = htmlobj.responseXML.getElementsByTagName("FSfabConpc")[loop].childNodes[0].nodeValue;
		var FSfabUnitprice = htmlobj.responseXML.getElementsByTagName("FSfabUnitprice")[loop].childNodes[0].nodeValue;
		var FSfsPocConpc = htmlobj.responseXML.getElementsByTagName("FSfsPocConpc")[loop].childNodes[0].nodeValue;
		var FSfsPocUnitprice = htmlobj.responseXML.getElementsByTagName("FSfsPocUnitprice")[loop].childNodes[0].nodeValue;
		var FSdryWashprice = htmlobj.responseXML.getElementsByTagName("FSdryWashprice")[loop].childNodes[0].nodeValue;
		var FSwetWashPrice = htmlobj.responseXML.getElementsByTagName("FSwetWashPrice")[loop].childNodes[0].nodeValue;
		
		var fabInv = htmlobj.responseXML.getElementsByTagName("fabInvStr")[loop].childNodes[0].nodeValue;
		var PocInv = htmlobj.responseXML.getElementsByTagName("PocInvStr")[loop].childNodes[0].nodeValue;
		var bpoDet = htmlobj.responseXML.getElementsByTagName("bpoStr")[loop].childNodes[0].nodeValue;
		var cls = htmlobj.responseXML.getElementsByTagName("cls")[loop].childNodes[0].nodeValue;
		var taxInvoiceConfirmBy = htmlobj.responseXML.getElementsByTagName("TaxInvoiceConfirmBy")[loop].childNodes[0].nodeValue;
		var ocInvoiceNo = htmlobj.responseXML.getElementsByTagName("ocInvoiceNo")[loop].childNodes[0].nodeValue;
		var extraApprovalNeed = htmlobj.responseXML.getElementsByTagName("extraApprovalNeed")[loop].childNodes[0].nodeValue; 
		
		createApproveCWSList(tbl,StyleId,orderNo,color,intOrderQty,preOederSMV,actSMV,dblPCScarton,dblCMvalue,buyerFOB,dblPreorderFob,dblInvFob,dblFsaleFob,comFOB,dblInvoiceId,strComInvNo,actFabConPC,actPocConpc,threadConpc,actThreadConpc,actDryWashPrice,actWetWashPrice,FSfabConpc,FSfabUnitprice,FSfsPocConpc,FSfsPocUnitprice,FSdryWashprice,FSwetWashPrice,buyerCode,fabInv,PocInv,bpoDet,cls,taxInvoiceConfirmBy,ocInvoiceNo,extraApprovalNeed);
	}	
	var tblmainWidth = parseInt(document.getElementById('tblMain').offsetWidth);
	fix_header(tblName,tblmainWidth,530);
}

function loadApproveOrderNoList(txtbox)
{
	var url					='costworksheetXml.php?id=getAppOrderNoList';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#"+txtbox).autocomplete({
			source: pub_po_arr
		});	
}

function createApproveCWSList(tbl,StyleId,orderNo,color,intOrderQty,preOederSMV,actSMV,dblPCScarton,dblCMvalue,buyerFOB,dblPreorderFob,dblInvFob,dblFsaleFob,comFOB,dblInvoiceId,strComInvNo,actFabConPC,actPocConpc,threadConpc,actThreadConpc,actDryWashPrice,actWetWashPrice,FSfabConpc,FSfabUnitprice,FSfsPocConpc,FSfsPocUnitprice,FSdryWashprice,FSwetWashPrice,buyerCode,fabInv,PocInv,bpoDet,cls,taxInvoiceConfirmBy,ocInvoiceNo,extraApprovalNeed)
{
	var tbl = $('#appCWSlist tbody');
	var lastRow 		= $('#appCWSlist tbody tr').length;
	var row 			= tbl[0].insertRow(lastRow);
	row.id = taxInvoiceConfirmBy;
	row.className = cls;
	row.onclick=ApprovRowclickColorChange;
	
	/*var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.id = taxInvoiceConfirmBy;
		row.className = cls;
		row.onclick=ApprovRowclickColorChange;*/
		
		var cell = row.insertCell(0);
		cell.setAttribute('height','20');
		cell.id = StyleId;
		cell.height = '25';
		cell.innerHTML = orderNo;
		
		
		var cell = row.insertCell(1);
		cell.innerHTML = color;
		
		var cell = row.insertCell(2);
		cell.innerHTML = intOrderQty;
		
		var cell = row.insertCell(3);
		if(extraApprovalNeed ==1)
			cell.innerHTML = "<img src=\"../../images/pdf.png\" onclick=\"loadOrderContractRpt("+StyleId+");\"/>";
		else
			cell.innerHTML = '&nbsp;';
		
		var cell = row.insertCell(4);
		cell.innerHTML = "<img src=\"../../images/pdf.png\" onclick=\"loadCostWSReport("+StyleId+");\"/>";
		
		var cell = row.insertCell(5);
		cell.innerHTML = "<img src=\"../../images/pdf.png\" onclick=\"viewCVWSRpt("+StyleId+","+dblInvoiceId+");\"/>";
		
		var cell = row.insertCell(6);
		cell.innerHTML = '';
		
		var cell = row.insertCell(7);
		cell.innerHTML = "<img src=\"../../images/pdf.png\" onclick=\"viewInvoiceRpt("+StyleId+","+dblInvoiceId+");\"/>";
		
		var cell = row.insertCell(8);
		cell.innerHTML = fabInv;
		
		var fabCls = 'bcgcolor-InvoiceCostFabric';
		var cell = row.insertCell(9);
		cell.className =fabCls;
		cell.innerHTML = FSfabUnitprice;
		
		var cell = row.insertCell(10);
		cell.className =fabCls;
		cell.innerHTML = FSfabConpc;	
		
		if(FSfabConpc < actFabConPC)
			fabCls = 'bcgcolor-InvoiceCostICNA';
			
		var cell = row.insertCell(11);
		cell.className =fabCls;
		cell.innerHTML = actFabConPC;
		
		var PocCls = 'bcgcolor-InvoiceCostPocketing';
			
		var cell = row.insertCell(12);
		cell.className =PocCls;
		cell.innerHTML = (FSfsPocUnitprice==0?'':FSfsPocUnitprice);
		
		var cell = row.insertCell(13);
		cell.className =PocCls;
		cell.innerHTML = (FSfsPocConpc==0?'':FSfsPocConpc);
		
		if(parseFloat(FSfsPocConpc) < parseFloat(actPocConpc))
			PocCls = 'bcgcolor-InvoiceCostICNA';
		var cell = row.insertCell(14);
		cell.className =PocCls;
		cell.innerHTML = (actPocConpc==0?'':actPocConpc);
		
		var cell = row.insertCell(15);
		cell.innerHTML = PocInv;
		
		var cell = row.insertCell(16);
		cell.innerHTML = (threadConpc==0?'':threadConpc);
		
		var cell = row.insertCell(17);
		cell.innerHTML = (actThreadConpc==0?'':actThreadConpc);
		
		var washCls = "bcgcolor-InvoiceCostService";	
		var cell = row.insertCell(18);
		cell.className =washCls;
		cell.innerHTML = (FSdryWashprice==0?'':FSdryWashprice);
		
		if((parseFloat(FSdryWashprice) < parseFloat(actDryWashPrice)))
			washCls = 'bcgcolor-InvoiceCostICNA';
		var cell = row.insertCell(19);
		cell.className =washCls;
		cell.innerHTML = (actDryWashPrice==0?'':actDryWashPrice);
		
		var washCls = "bcgcolor-InvoiceCostService";
		var cell = row.insertCell(20);
		cell.className =washCls;
		cell.innerHTML = (FSwetWashPrice==0?'':FSwetWashPrice);
		
		if((parseFloat(FSwetWashPrice) < parseFloat(actWetWashPrice)))
			washCls = 'bcgcolor-InvoiceCostICNA';
		var cell = row.insertCell(21);
		cell.className =washCls;
		cell.innerHTML = (actWetWashPrice==0?'':actWetWashPrice);
		
		var cell = row.insertCell(22);
		cell.innerHTML = dblPCScarton;
		
		var cell = row.insertCell(23);
		cell.innerHTML = dblCMvalue;
		
		var smvCls ="bcgcolor-interjobAllo";
					
		var cell = row.insertCell(24);
		cell.className =smvCls;
		cell.innerHTML = preOederSMV;
		
		if((parseFloat(preOederSMV) < parseFloat(actSMV)))
			smvCls = 'bcgcolor-InvoiceCostICNA';
		var cell = row.insertCell(25);
		cell.className =smvCls;
		cell.innerHTML = (actSMV==0?'':actSMV);
		
		var fobCls ="bcgcolor-CostWSBelts";
		var cell = row.insertCell(26);
		cell.className =fobCls;
		cell.innerHTML = dblInvFob;
		
		var cell = row.insertCell(27);
		cell.className =fobCls;
		cell.innerHTML = dblFsaleFob;
		
		var fobDiff = (parseFloat(dblInvFob) - parseFloat(dblFsaleFob))/parseFloat(dblInvFob)*100;
		var cell = row.insertCell(28);
		cell.className =fobCls;
		cell.innerHTML = RoundNumbers(fobDiff,2);
		
		var cell = row.insertCell(29);
		cell.innerHTML = buyerCode;
		
		var invFob = parseFloat(dblInvFob);
		var preFob = parseFloat(dblPreorderFob);
		var comFob = parseFloat(comFOB);
		var buyerFob = parseFloat(buyerFOB);
		
		fobCls = (preFob != invFob? 'bcgcolor-InvoiceCostICNA':'bcgcolor-CostWSBelts')	
		var cell = row.insertCell(30);
		cell.className =fobCls;
		cell.innerHTML = dblPreorderFob;
		
		fobCls = (comFob != invFob? 'bcgcolor-InvoiceCostICNA':'bcgcolor-CostWSBelts')	
		var cell = row.insertCell(31);
		cell.className =fobCls;
		cell.innerHTML = comFOB;
		
		fobCls = (buyerFob != invFob? 'bcgcolor-InvoiceCostICNA':'bcgcolor-CostWSBelts')	
		var cell = row.insertCell(32);
		cell.className =fobCls;
		cell.innerHTML = buyerFOB;
		
		var cell = row.insertCell(33);
		cell.innerHTML = dblInvoiceId;
		
	
		var cell = row.insertCell(34);
		cell.innerHTML = bpoDet;
		
		/*if(manageCWSRevise)
		{
			var cell = row.insertCell(35);
			cell.innerHTML = "<input name=\"\" type=\"checkbox\" value=\"\" onclick=\"reviseCWS(this);\"/>";
		}*/
}

function enableEnterSubmitApprovDetails(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				loadApprovedCWS('appCWSlist');
}
function OpenReportPopUp(obj)
{
	pub_reportCat = obj;
	 document.getElementById('rdoPreorderReport').checked = false;
	 document.getElementById('rdoInvReport').checked = false;
	 document.getElementById('rdoleftReport').checked = false;
	if(document.getElementById('divReport').style.visibility == "hidden")
	{
		document.getElementById('divReport').style.visibility = "visible";
	}
	else
	{
		document.getElementById('divReport').style.visibility = "hidden";
	}
}
function ViewReport(obj)
{
	
	
	if(obj=='rdoPreorderReport')
	{
		showExcelFile();
	}
	else if(obj=='rdoInvReport')
	{
		showInvExcelReport();
	}
	else if(obj=='rdoleftReport')
	{
		viewLeftoverDetailRpt('E');
	}
	OpenReportPopUp();
}

function viewFabInvoice(styleId,FabId)
{
	var url = "viewInvoiceDetails.php?styleId="+styleId+"&FabId="+FabId;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(455,138,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
}
function RoundNumbers(number,decimals) {
	number = parseFloat(number).toFixed(parseInt(decimals));
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
function rowclickColorChange(obj,tblName)
{
	var rowIndex = obj.rowIndex;
	
	var tbl = document.getElementById(tblName);
	
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
	
		if(tbl.rows[i].cells[0].id != '')
			tbl.rows[i].className="grid_raw_white";
		else
			tbl.rows[i].className="grid_raw_pink";
		
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-Row-highlighted";
	}
	
}
function ApprovRowclickColorChange()
{
	var rowIndex = this.rowIndex;
	
	var tbl = document.getElementById('appCWSlist');
	
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if(tbl.rows[i].id != '')
			tbl.rows[i].className="grid_raw_white";
		else
			tbl.rows[i].className="grid_raw_pink";
		
		if( i == rowIndex)
			tbl.rows[i].className = "bcgcolor-Row-highlighted";
	}
	
}
function enableApprovDate(obj)
{
	if(obj.checked)
	{
		document.getElementById('txtAppDfrom').disabled=false;
		document.getElementById('txtAppDateTo').disabled=false;
	}
	else
	{
		document.getElementById('txtAppDfrom').disabled=true;
		document.getElementById('txtAppDateTo').disabled=true;
		document.getElementById('txtAppDfrom').value='';
		document.getElementById('txtAppDateTo').value='';
	}
}
function deleteFSdetails()
{
	var styleId = document.getElementById("orderId").title;
	if(styleId != '')
	{
		var url	='costworksheetXml.php?id=deleteFistSaleDetails&styleId='+styleId;
		htmlobj = $.ajax({url:url,async:false});
		var response = htmlobj.responseText
		if(response == 'TRUE')
		{
			alert("Fist Sale Details deleted ");
			location= "costworksheet.php?";
		}
		else
		{
			alert("Can't delete Fist Sale Details. \n Shipping Details available");
			return false;
		}
	}
}
function clearApprovedList()
{
	document.getElementById('txtAppDfrom').disabled=true;
	document.getElementById('txtAppDateTo').disabled=true;
	document.getElementById('txtAppDfrom').value='';
	document.getElementById('txtAppDateTo').value='';
	document.getElementById('chkDate').checked=false;
	document.getElementById('txtAppOrderNo').value='';
	document.getElementById('cboAppBuyer').value='';
	clearTbl('appCWSlist');
	loadApprovedCWS('appCWSlist');
}

function viewLeftoverDetailRpt(type)
{
	var styleId = document.getElementById('orderId').title;
	var orderNo = document.getElementById('txtOrderNo').value;
	if(styleId=='')
	{
		alert("Please enter OrderNo");
		document.getElementById('txtOrderNo').focus();
		return false;
	}
	window.open("leftoverAllocationReport.php?styleId="+styleId+'&type='+type+'&orderNo='+URLEncode(orderNo),'frmCostWorkSheet');
}
function caculateValueDryProcess(objDel)
{
	var tblMain = objDel.parentNode.parentNode;
	var rowNo = objDel.parentNode.parentNode.rowIndex-1;
	
	var unitprice = isNaN(parseFloat(objDel.parentNode.parentNode.cells[3].childNodes[0].value)) == true ?0:parseFloat(objDel.parentNode.parentNode.cells[3].childNodes[0].value);
	var conPc = parseFloat(objDel.parentNode.parentNode.cells[4].innerHTML);
	var value =unitprice*conPc;
	 var newnumber = Math.round(value*Math.pow(10,4))/Math.pow(10,4);
objDel.parentNode.parentNode.cells[5].innerHTML = newnumber.toFixed(4); 
}