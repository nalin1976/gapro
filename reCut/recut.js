// JavaScript Document

function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}

function getRecutScNo()
{
	document.getElementById('cboRecutSR').value = document.getElementById('cboRecutOrderNo').value
}
function getRecutOrderNo()
{
	document.getElementById('cboRecutOrderNo').value = document.getElementById('cboRecutSR').value
}
function getStyleWiseRecutOrderData()
{
	var styleName = document.getElementById('cboRecutStyles').value;
	var chkUser ='TRUE';
	var url = "recutpreorderdb.php?RequestType=getStyleWiseData&styleName="+URLEncode(styleName)+"&chkUser="+chkUser;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboRecutOrderNo').innerHTML = htmlobj.responseXML.getElementsByTagName("OrderNoList")[0].childNodes[0].nodeValue;
	document.getElementById('cboRecutSR').innerHTML = htmlobj.responseXML.getElementsByTagName("SCNolist")[0].childNodes[0].nodeValue;
	
}
function reloadPreOrderDetails()
{
	var styleID = document.getElementById('cboRecutOrderNo').value;
	var StyleName = document.getElementById('cboRecutStyles').value;
	//alert(styleID + ' ' + StyleName);
	if(StyleName != "Select One" || styleID != "Select One")
		location = "recutpreorder.php?StyleNo=" + URLEncode(styleID)+"&StyleName="+StyleName;
		else
			location = "recutpreorder.php?";
}

function LoadSavedPreOrderDetails()
{
	var styleId = document.getElementById('cboRecutOrderNo').value;
	if(styleId=="")
		return;
	var recutNo = document.getElementById('txtRecutNo').value;
	var url = "recutpreorderdb.php?RequestType=getPreorderData&styleId="+styleId+"&recutNo="+recutNo;
	var htmlobj=$.ajax({url:url,async:false});
	loadSavedPreorderHeaderData(htmlobj);
	loadPreorderItemDetails();
}

function loadSavedPreorderHeaderData(htmlobj)
{
	var XMLOrderNo 			= htmlobj.responseXML.getElementsByTagName("OrderNo");
	var XMLStyleName 		= htmlobj.responseXML.getElementsByTagName("StyleName");
	var XMLStyleID 			= htmlobj.responseXML.getElementsByTagName("StyleID");
	var XMLCompanyID 		= htmlobj.responseXML.getElementsByTagName("CompanyID");
	var XMLDescription 		= htmlobj.responseXML.getElementsByTagName("Description");
	var XMLBuyerID 			= htmlobj.responseXML.getElementsByTagName("BuyerID");
	var XMLintQty 			= htmlobj.responseXML.getElementsByTagName("intQty");
	var XMLStatus 			= htmlobj.responseXML.getElementsByTagName("Status");
	var XMLCustomerRefNo 	= htmlobj.responseXML.getElementsByTagName("CustomerRefNo");
	var XMLSMVRate 			= htmlobj.responseXML.getElementsByTagName("SMVRate");
	var XMLFOB 				= htmlobj.responseXML.getElementsByTagName("FOB");
	var XMLFinance 			= htmlobj.responseXML.getElementsByTagName("Finance");
	var XMLUserID 			= htmlobj.responseXML.getElementsByTagName("UserID");
	var XMLFinPercntage 	= htmlobj.responseXML.getElementsByTagName("FinPercntage");
	var XMLEfficiencyLevel 	= htmlobj.responseXML.getElementsByTagName("EfficiencyLevel");
	var XMLCostPerMinute 	= htmlobj.responseXML.getElementsByTagName("CostPerMinute");
	var XMLECSCharge 		= htmlobj.responseXML.getElementsByTagName("ECSCharge");
	var XMLBuyingOfficeId 	= htmlobj.responseXML.getElementsByTagName("BuyingOfficeId");
	var XMLDivisionId 		= htmlobj.responseXML.getElementsByTagName("DivisionId");
	var XMLSeasonId 		= htmlobj.responseXML.getElementsByTagName("SeasonId");
	var XMLRPTMark 			= htmlobj.responseXML.getElementsByTagName("RPTMark");
	var XMLLineNos 			= htmlobj.responseXML.getElementsByTagName("LineNos");
	var XMLUPCharges 		= htmlobj.responseXML.getElementsByTagName("UPCharges");
	var XMLUPChargesReason 	= htmlobj.responseXML.getElementsByTagName("UPChargesReason");
	var XMLExPercentage 	= htmlobj.responseXML.getElementsByTagName("ExPercentage");
	var XMLExSMV 			= htmlobj.responseXML.getElementsByTagName("SMV");
	var XMLExShedule 		= htmlobj.responseXML.getElementsByTagName("SheduleMethod");
	var XMLSubQty 			= htmlobj.responseXML.getElementsByTagName("SubQty");
	var XMLorderUnit 		= htmlobj.responseXML.getElementsByTagName("orderUnit");
	var XMLproSubcat 		= htmlobj.responseXML.getElementsByTagName("proSubcat");
	var XMLCoordinator 		= htmlobj.responseXML.getElementsByTagName("Coordinator");
	var XMLLabourCost 		= htmlobj.responseXML.getElementsByTagName("labourCost");
	var XMLMargin 			= htmlobj.responseXML.getElementsByTagName("Profit");
	var XMLFacProfit 		= htmlobj.responseXML.getElementsByTagName("facProfit");
	var XMLFacCostPerMin 	= htmlobj.responseXML.getElementsByTagName("facCostPerMin");
	var XMLOrderType		= htmlobj.responseXML.getElementsByTagName("OrderType");
	var RecutQty 			= htmlobj.responseXML.getElementsByTagName("intRecutQty")[0].childNodes[0].nodeValue;
	var recutReason 		= htmlobj.responseXML.getElementsByTagName("recutReason")[0].childNodes[0].nodeValue;
	var resposiblePerson 		= htmlobj.responseXML.getElementsByTagName("resposiblePerson")[0].childNodes[0].nodeValue;
	var epfNo 				= 	htmlobj.responseXML.getElementsByTagName("epfNo")[0].childNodes[0].nodeValue;
	
	document.getElementById('txtStyleNo').value 		= XMLStyleID[0].childNodes[0].nodeValue;
	document.getElementById('txtRepeatNo').value 		= XMLStyleName[0].childNodes[0].nodeValue;
	document.getElementById('cboFactory').value 		= XMLCompanyID[0].childNodes[0].nodeValue;
	document.getElementById('txtStyleName').value 		= XMLDescription[0].childNodes[0].nodeValue;
	document.getElementById('cboCustomer').value 		= XMLBuyerID[0].childNodes[0].nodeValue;
	document.getElementById('cboBuyingOffice').value 	= XMLBuyingOfficeId[0].childNodes[0].nodeValue;
	document.getElementById('txtRefNo').value 			= XMLCustomerRefNo[0].childNodes[0].nodeValue;
	document.getElementById('cboMerchandiser').value 	= XMLUserID[0].childNodes[0].nodeValue;
	document.getElementById('txtOrderNo').value 		= XMLOrderNo[0].childNodes[0].nodeValue;
	document.getElementById('txtSMV').value 			= XMLExSMV[0].childNodes[0].nodeValue;
	document.getElementById('txtQTY').value 			= XMLintQty[0].childNodes[0].nodeValue;
	POorderQty = XMLintQty[0].childNodes[0].nodeValue;
	document.getElementById('txtEXQTY').value 			= 0;
	document.getElementById('dboDivision').value 		= XMLDivisionId[0].childNodes[0].nodeValue;
	document.getElementById('dboSeason').value 			= XMLSeasonId[0].childNodes[0].nodeValue;
	document.getElementById('txtEffLevel').value 		= XMLEfficiencyLevel[0].childNodes[0].nodeValue;
	document.getElementById('txtNoLines').value 		= XMLLineNos[0].childNodes[0].nodeValue;
	document.getElementById('txtFinancePercentage').value = XMLFinPercntage[0].childNodes[0].nodeValue;
	document.getElementById('txtFinanceAmount').value 	= XMLFinance[0].childNodes[0].nodeValue;
	document.getElementById('txtSMVRate').value 		= XMLSMVRate[0].childNodes[0].nodeValue;
	document.getElementById('txtSubContactQty').value 	= XMLSubQty[0].childNodes[0].nodeValue;
	document.getElementById('txtTargetFOB').value 		= XMLFOB[0].childNodes[0].nodeValue;
	document.getElementById('txtUPCharge').value 		= XMLUPCharges[0].childNodes[0].nodeValue;
	document.getElementById('txtUPChargeReason').value 	= XMLUPChargesReason[0].childNodes[0].nodeValue;
	document.getElementById('txtESC').value 			= XMLECSCharge[0].childNodes[0].nodeValue;
	document.getElementById('cboScheduleMethod').value 	= XMLExShedule[0].childNodes[0].nodeValue;
	factoryID  = XMLCompanyID[0].childNodes[0].nodeValue;
	document.getElementById('cboOrderUnit').value 		= XMLorderUnit[0].childNodes[0].nodeValue;
	document.getElementById('cboProductCategory').value = XMLproSubcat[0].childNodes[0].nodeValue;
	document.getElementById('cboMerchandiser').value 	= XMLCoordinator[0].childNodes[0].nodeValue;
	document.getElementById('txtLabourCost').value		= XMLLabourCost[0].childNodes[0].nodeValue;
	document.getElementById('txtMargin').value 			=  XMLMargin[0].childNodes[0].nodeValue;
	document.getElementById('txtCostPerMinute').value 	=  XMLFacCostPerMin[0].childNodes[0].nodeValue;
	RecutQty = (RecutQty==0?'':RecutQty);
	document.getElementById('txtRecutQty').value 		= RecutQty
	document.getElementById('txtRecutReason').value 	= recutReason
	document.getElementById('cboResposiblePerson').value 	= resposiblePerson
	document.getElementById('cboOrderType').value 	= XMLOrderType[0].childNodes[0].nodeValue;
	if(epfNo != '')
		document.getElementById('txtEPF').value = epfNo;
}

function loadPreorderItemDetails()
{
	var styleId = document.getElementById('cboRecutOrderNo').value;
	var recutNo = document.getElementById('txtRecutNo').value;
	var url = "recutpreorderdb.php?RequestType=getPreorderItemData&styleId="+styleId+"&recutNo="+recutNo;
	var htmlobj=$.ajax({url:url,async:false});
	savedPreorderItemDetails(htmlobj);
}
function savedPreorderItemDetails(htmlobj)
{
	var XMLstrOrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo");
			var XMLintMatDetailID = htmlobj.responseXML.getElementsByTagName("MatDetailID");
			var XMLMatName = htmlobj.responseXML.getElementsByTagName("ItemName");
			var XMLOrigineName = htmlobj.responseXML.getElementsByTagName("OrigineName");
			var XMLUnit = htmlobj.responseXML.getElementsByTagName("Unit");
			var XMLdblUnitPrice = htmlobj.responseXML.getElementsByTagName("UnitPrice");
			var XMLreaConPc = htmlobj.responseXML.getElementsByTagName("ConPc");
			var XMLreaWastage = htmlobj.responseXML.getElementsByTagName("Wastage");
			var XMLintOriginNo = htmlobj.responseXML.getElementsByTagName("OriginNo");
			var XMLdblReqQty = htmlobj.responseXML.getElementsByTagName("dblReqQty");
			var XMLdblTotalQty = htmlobj.responseXML.getElementsByTagName("dblTotalQty");
			var XMLdblTotalValue = htmlobj.responseXML.getElementsByTagName("dblTotalValue");
			var XMLdbltotalcostpc = htmlobj.responseXML.getElementsByTagName("dbltotalcostpc");
			var XMLdblFreight = htmlobj.responseXML.getElementsByTagName("Freight");
			var XMLCategory = htmlobj.responseXML.getElementsByTagName("MainItem");
			var XMLMainCatID = htmlobj.responseXML.getElementsByTagName("MatMainCat");
			var XMLoriginType = htmlobj.responseXML.getElementsByTagName("OriginType");
	
			for ( var loop = 0; loop < XMLstrOrderNo.length; loop ++)
			{
				var itemCode = XMLintMatDetailID[loop].childNodes[0].nodeValue;
				var itemDescription = XMLMatName[loop].childNodes[0].nodeValue;
				var conPc = XMLreaConPc[loop].childNodes[0].nodeValue;
				var unitType = XMLUnit[loop].childNodes[0].nodeValue;
				var unitPrice = XMLdblUnitPrice[loop].childNodes[0].nodeValue;wastage = XMLreaWastage[loop].childNodes[0].nodeValue;
				var originName = XMLOrigineName[loop].childNodes[0].nodeValue;
				var freight = XMLdblFreight[loop].childNodes[0].nodeValue;
				var originid = XMLintOriginNo[loop].childNodes[0].nodeValue;
				var category =  XMLCategory[loop].childNodes[0].nodeValue;
				var mainCatID = XMLMainCatID[loop].childNodes[0].nodeValue;
				var originType = XMLoriginType[loop].childNodes[0].nodeValue;
				if(wastage == null || wastage == "")
					wastage = 0;
				
				if(freight == null || freight == "")
					freight = 0;
					
				if(originName == null || originName == "")
					originName = " ";
				
			
				AddItemDetails(itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originid,category,mainCatID,originType);
				arrayLocation ++
			}
			var tblmainWidth = parseInt(document.getElementById('tblMain').offsetWidth);
			fix_header('tblConsumption',tblmainWidth,230);
			HideLoadingImage();
}
function AddItemDetails(itemCode,itemDescription,conPc,unitType,unitPrice,wastage,originName,freight,originid,category,mainCatID,originType)
{
	var tbl = $('#tblConsumption tbody');
	var lastRow 		= $('#tblConsumption tbody tr').length;
	var row 			= tbl[0].insertRow(lastRow);
	//row.setAttribute('bgcolor',xml_RwClass);
	
	if ((lastRow % 2) == 0)
	{
		row.className="bcgcolor-tblrow";
	}
	else
	{
		row.className="bcgcolor-tblrowWhite";		
	}
	
	row.onclick = rowclickColorChange;
	
	var cellEdit = row.insertCell(0);   
	cellEdit.id = itemCode;
	cellEdit.innerHTML = "<div onClick=\"showEditItemWindow(this);\" id=" + itemCode + " align=\"center\"><img src=\"../images/edit.png\" /></div>";
	
	var cellDelete = row.insertCell(1);   
	cellDelete.id = itemCode;
	cellDelete.innerHTML = ""; 
	
	var cellDescription = row.insertCell(2);     
	cellDescription.className="normalfnt";
	cellDescription.id = arrayLocation;
	cellDescription.id = lastRow;
	cellDescription.innerHTML = itemDescription;
	
	var cellConPc = row.insertCell(3);     
	cellConPc.className="normalfntRite";
	
	cellConPc.id = category;
	//cellConPc.ondblclick = changeToStyleTextBox;
	cellConPc.innerHTML = RoundNumbers(conPc,consumptionDecimalLength);
	
	var cellUnit = row.insertCell(4);     
	cellUnit.className="normalfntMid";
	if (unitType == null || unitType == "" )
			unitType = " ";
	//cellUnit.ondblclick = openUnitConvertionPopup;
	cellUnit.innerHTML = unitType;
	
	var cellUnitPrice = row.insertCell(5);     
	cellUnitPrice.className="normalfntRite";
	//cellUnitPrice.ondblclick = changeToStyleTextBox;
	cellUnitPrice.innerHTML = RoundNumbers(unitPrice,4);
	
	var cellWastage = row.insertCell(6);     
	cellWastage.className="normalfntMid";
	cellWastage.innerHTML = wastage;
	
	
	var orderQty = document.getElementById('txtRecutQty').value;
	if(orderQty =='' || orderQty==0)
		orderQty = document.getElementById('txtQTY').value;
	var ReqQty = calculateReqQty(orderQty,conPc);
	
	var cellRecQty = row.insertCell(7);     
	cellRecQty.className="normalfntRite";
	cellRecQty.innerHTML = ReqQty;
	
	var exQty = parseInt(document.getElementById('txtEXQTY').value);
	if (document.getElementById('txtEXQTY').value == "" || document.getElementById('txtEXQTY').value == null)
		exQty = 0;
	
	var totalQty = 0;

	
	totalQty = calculateTotalQty(orderQty,conPc,wastage,exQty,mainCatID);
	
	var cellTotQty = row.insertCell(8);     
	cellTotQty.className="normalfntRite";
	cellTotQty.innerHTML = totalQty;
	
	//orit CostPC calculation ------------ start----------------------
	var price = 0;
	var value = calculateCostValue(totalQty,unitPrice,freight);
	
	var totOrderQty = parseFloat(document.getElementById('txtQTY').value*exQty/100) + parseFloat(document.getElementById('txtQTY').value);
			price = RoundNumbers(calCostPCwithExcess(orderQty,value),4);
	//---------end ------------------------------
	
	var cellPrice = row.insertCell(9);     
	cellPrice.className="normalfntRite";
	cellPrice.innerHTML = value;

	var cellValue = row.insertCell(10);     
	cellValue.className="normalfntRite";
	cellValue.innerHTML = price;
	
	var cellOrigin = row.insertCell(11);     
	cellOrigin.className="normalfntMid";
	cellOrigin.id=originid;
	cellOrigin.innerHTML = originName;
	
	var cellFreight = row.insertCell(12);     
	cellFreight.className="normalfntRite";
	cellFreight.id=originType;
	cellFreight.innerHTML = RoundNumbers(freight,4);	
	
	
}
function showEditItemWindow(obj)
{
	var rw = obj.parentNode.parentNode;
	showBackGround('divBG',0);
	var url = "itemPopup.php?itemId="+obj.id+"&possitionID="+rw.rowIndex;
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(550,150,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	document.getElementById('txtConpc').value = rw.cells[3].innerHTML;
	document.getElementById('cboUnits').value = rw.cells[4].innerHTML;
	document.getElementById('txtUnitPrice').value = rw.cells[5].innerHTML;
	document.getElementById('txtwastage').value = rw.cells[6].innerHTML;
	document.getElementById('cboOrigin').value = rw.cells[11].id;
	document.getElementById('txtfreight').value = rw.cells[12].innerHTML;
	
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
function updateItemDetails(position)
{
	var tbl = document.getElementById('tblConsumption');
		
	var orderQty = document.getElementById('txtRecutQty').value;
	if(orderQty == '')
	{
		alert("Please enter 'Recut Qty'");
		document.getElementById('txtRecutQty').focus();
		CloseOSPopUp('popupLayer1');
		return false;
	}
	var conpc = document.getElementById('txtConpc').value;
	var unitPrice = document.getElementById('txtUnitPrice').value;
	var exQty = document.getElementById('txtEXQTY').value;
	if (document.getElementById('txtEXQTY').value == "" || document.getElementById('txtEXQTY').value == null)
		exQty = 0;
	var freight = document.getElementById('txtfreight').value;
	var ReqQty = calculateReqQty(orderQty,conpc);
	var wastage = tbl.rows[position].cells[6].innerHTML;
	var mainCat = tbl.rows[position].cells[3].id;
	var totalQty = calculateTotalQty(orderQty,conpc,wastage,exQty,mainCat);
	var value  = calculateCostValue(totalQty,unitPrice,freight);
	var price = 0;
	 price = RoundNumbers(calCostPCwithExcess(orderQty,value),4);
	 
	tbl.rows[position].cells[3].innerHTML = RoundNumbers(conpc,consumptionDecimalLength) ;
	tbl.rows[position].cells[5].innerHTML = unitPrice;
	tbl.rows[position].cells[7].innerHTML = ReqQty; 
	tbl.rows[position].cells[8].innerHTML= totalQty;
	tbl.rows[position].cells[9].innerHTML = RoundNumbers((parseFloat(totalQty) * (parseFloat(unitPrice) + parseFloat(freight))),4) ; 
	tbl.rows[position].cells[10].innerHTML = RoundNumbers(price,4);
	CloseOSPopUp('popupLayer1');
}
function ChangeRecutOrderQuantity()
{
	var Qty = (isNaN(parseFloat(document.getElementById('txtRecutQty').value))==true ? 0:parseFloat(document.getElementById('txtRecutQty').value));
	var exQty = parseFloat(document.getElementById('txtEXQTY').value);
	
	var tbl = document.getElementById('tblConsumption');
    for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{
		var rw = tbl.rows[loop];
        var itemid = rw.cells[0].id;
		var posID = tbl.rows[loop].cells[2].id;
		var conpc = parseFloat(tbl.rows[loop].cells[3].lastChild.nodeValue)  ;
		var unitType = tbl.rows[loop].cells[4].lastChild.nodeValue ;
		var unitPrice = parseFloat(tbl.rows[loop].cells[5].lastChild.nodeValue);
		var wastage = parseFloat(tbl.rows[loop].cells[6].lastChild.nodeValue)  ;
		var freight = parseFloat(tbl.rows[loop].cells[12].lastChild.nodeValue) ;
		var mainCat = parseInt(tbl.rows[loop].cells[3].id)
				
		var reqQty = calculateReqQty(Qty,conpc);
		var totalQty = calculateTotalQty(Qty,conpc,wastage,exQty,mainCat);
		var value  = calculateCostValue(totalQty,unitPrice,freight);
		var totOrderQty = parseFloat(Qty*exQty/100) + Qty;
		var price  = RoundNumbers(calCostPCwithExcess(Qty,value),4);
		
		tbl.rows[loop].cells[7].lastChild.nodeValue = reqQty;
		tbl.rows[loop].cells[8].lastChild.nodeValue = totalQty;
		tbl.rows[loop].cells[9].lastChild.nodeValue = value;
		tbl.rows[loop].cells[10].lastChild.nodeValue = price;
	}	
}

function saveRecutDetails(type)
{
	if(validateInterface())
	{
		if(document.getElementById('txtRecutNo').value == '')
			getRecutNo();
		saveRecutHeaderDetails();
		saveRecutItemDetails(type);
	}
	else
		return false;	
}

function getRecutNo()
{
	var url = "recutpreorderdb.php?RequestType=getRecutNo";
	var htmlobj=$.ajax({url:url,async:false});
	var recutNo = htmlobj.responseXML.getElementsByTagName("intRecutNo")[0].childNodes[0].nodeValue;
	var recutYear = htmlobj.responseXML.getElementsByTagName("intYear")[0].childNodes[0].nodeValue;
	
	document.getElementById('txtRecutNo').value = recutYear+'/'+recutNo;
}

function saveRecutHeaderDetails()
{	
	var styleID = document.getElementById('cboRecutOrderNo').value;
	var recutQty = document.getElementById('txtRecutQty').value;
	var recutNo = document.getElementById('txtRecutNo').value;
	var recutReason = URLEncode(document.getElementById('txtRecutReason').value);
	var responsiblePerson = document.getElementById('cboResposiblePerson').value;
	var epfNo = URLEncode(document.getElementById('txtEPF').value);
	
	var url = "recutpreorderdb.php?RequestType=getRecutHeader&styleID="+styleID+"&recutQty="+recutQty+'&recutNo='+recutNo+"&recutReason="+recutReason+"&responsiblePerson="+responsiblePerson+"&epfNo="+epfNo;
	htmlobj=$.ajax({url:url,async:false});
	
}
function validateInterface()
{
	var styleID = document.getElementById('cboRecutOrderNo').value;
	var recutQty = document.getElementById('txtRecutQty').value;
	var recutReason = document.getElementById('txtRecutReason').value;
	//var resposiblePerson = document.getElementById('cboResposiblePerson').value;
	var EPFno = document.getElementById('txtEPF').value;
	
	if(styleID == '')
	{
		alert("Please select the 'Order No'.");
		document.getElementById('cboRecutOrderNo').focus();
		return false;
	}
	if(recutQty == '')
	{
		alert("Please enter 'Recut Qty'.");
		document.getElementById('txtRecutQty').focus();
		return false;
	}
	if(recutReason == '')
	{
		alert("Please enter 'Recut Reason'.");
		document.getElementById('txtRecutReason').focus();
		return false;
	}
	/*if(resposiblePerson=='')
	{
		alert("Please select 'Resposible Person'.");
		document.getElementById('cboResposiblePerson').focus();
		return false;
	}*/
	if(EPFno=='' || EPFno =='Enter EPF No')
	{
		alert("Please enter 'EPF No'.");
		document.getElementById('txtEPF').onclick();
		document.getElementById('txtEPF').focus();
		return false;
	}
	return true;
}

function saveRecutItemDetails(type)
{
	var tbl = document.getElementById('tblConsumption'); 
	var recutNo = document.getElementById('txtRecutNo').value;
	var No = recutNo.split("/");
	var intrecutNo = No[1];
	var intrecutYear =No[0];
	var recutQty = document.getElementById('txtRecutQty').value;
	var exQty = document.getElementById('txtEXQTY').value;
	
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		var conpc =tbl.rows[loop].cells[3].innerHTML;
		var wastage = tbl.rows[loop].cells[6].innerHTML;
		var mainCat = tbl.rows[loop].cells[3].id;
		var unitPrice = tbl.rows[loop].cells[5].innerHTML;
		var freight = tbl.rows[loop].cells[12].innerHTML;
		
		var url = "recutpreorderdb.php?RequestType=getRecutItemDetails&intrecutNo="+intrecutNo;
		url += "&intrecutYear="+intrecutYear;
		url += "&matDetailID="+tbl.rows[loop].cells[0].id;
		url += "&strUnit="+tbl.rows[loop].cells[4].innerHTML;
		url += "&unitprice="+unitPrice;
		url += "&conPc="+conpc;
		url += "&wastage="+wastage;
		url += "&originId="+tbl.rows[loop].cells[11].id;
		url += "&freight="+freight;
		
		var reqQty = calculateReqQty(recutQty,conpc);
		var totalQty = calculateTotalQty(recutQty,conpc,wastage,exQty,mainCat);
		var value  = calculateCostValue(totalQty,unitPrice,freight);
		var price  = RoundNumbers(calCostPCwithExcess(recutQty,value),4);
		
		url += "&reqQty="+reqQty;
		url += "&totalQty="+totalQty;
		url += "&totalValue="+value;
		url += "&costpc="+price;
		
		htmlobj=$.ajax({url:url,async:false});
	}
	if(type ==0)
		alert("Saved successfully.");
}
function recutSendtoApp(styleNo)
{
	
	if(!confirm("Are you sure you want to send To Approve this recut."))
		return;
	var recutNo = document.getElementById('txtRecutNo').value;
	saveRecutDetails(1);
	var url  = "recutpreorderdb.php?RequestType=checkFileUploaded&recutNo="+recutNo;
	var htmlobj = $.ajax({url:url,async:false});
	var checkUpload = htmlobj.responseXML.getElementsByTagName("checkUpload")[0].childNodes[0].nodeValue;
	if(checkUpload=="False")
	{
		alert("Please attach the approval document befor send to approval.")
		document.getElementById("butUpload").focus();
		return;
	}
	var url_s = "recutpreorderdb.php?RequestType=chekStyleRatio&styleNo="+styleNo;
	htmlobj_s =$.ajax({url:url_s,async:false});
	var styleRatioAv = htmlobj_s.responseXML.getElementsByTagName("styleRatioAv")[0].childNodes[0].nodeValue;
	if(styleRatioAv=='')
	{
		alert("Style Ratio not available for Order No : "+$("#cboRecutOrderNo option:selected").text());
		return false;
	}
	
	var url = "recutpreorderdb.php?RequestType=updateRecutSendtoAppStatus&recutNo="+recutNo;
	htmlobj=$.ajax({url:url,async:false});
	var appResult = htmlobj.responseXML.getElementsByTagName("updateResult")[0].childNodes[0].nodeValue;
	
	if(appResult=='1')
	{
		alert("Recut No "+ recutNo+ " send to approval");
		location = "recutpreorder.php?";
	}
}

function showRecutReport()
{
	var recutNo = document.getElementById('txtRecutNo').value;
	if(recutNo == '')
	{
		alert("Recut details not available to generate report. Please save the recut details and try again.");
		return false;
	}
	window.open("recutReport.php?recutNo=" + recutNo,'frm_main'); 
}

function ClearReCutForm()
{
	document.frm_main.reset();
	ClearTable('tblConsumption');
}//line 526
function UploadFile()
{
	if (document.getElementById('txtRecutNo').value == null || document.getElementById('txtRecutNo').value == "")
	{
		alert("Please get saved \"Recut No\".");	
		document.getElementById('txtRecutNo').focus();
		return ;
	}
	
	var RecutNo = document.getElementById('txtRecutNo').value;
	var	popwindow= window.open ("recutfileupload.php?No=" + RecutNo, "Recut Uploader","location=1,status=1,scrollbars=1,width=450,height=300");
	popwindow.moveTo(((screen.width - 450)/2),((screen.height - 160)/2));
	popwindow.focus();	
}
function clearEPFTextbox()
{
	document.getElementById('txtEPF').value='';
}