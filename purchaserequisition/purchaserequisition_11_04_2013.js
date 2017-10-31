//BEGIN - Main Item Grid Column Variable
var m_del 		= 0 ;	// Delete button
var m_iC 		= 1 ;	// Item Code
var m_iDec		= 2	;	// Item Description
var m_u			= 3 ;	// Unit
var m_up		= 4	;	// Unit Price
var m_pu		= 5 ; 	// Price Updated Date
var m_cs		= 6	;	// Current Stock
var m_rl		= 7 ; 	// Reorder Level
var m_qty		= 8	;	// Order Qty
var m_val		= 9	;	// Value = unit price * qty
var m_dis		= 10;	// Discount percentage value
var m_disVal	= 11;	// Discount Value = Value * Discount percentage value / 100
var m_FinVval	= 12;	// Value - Discount Value
var m_asset		= 13; 	// Asset
//END - Main Item Grid Column Variable

//BEGIN - Main GL Grid Column Variable
var g_gc 	= 0 ;	// GL Code
var g_des 	= 1 ;	// GL Description
var g_bud	= 2	;	// Budget
var g_add	= 3 ;	// Additional
var g_tra	= 4	;	// Transfer
var g_totB	= 5 ; 	// Total Budget
var g_act	= 6	;	// Actual
var g_pen	= 7 ; 	// Pending
var g_bvari	= 8	;	// Budget Variance
var g_req	= 9 ;	// Requested
var g_currB	= 10 ;	// Current Budget
//END - Main GL Grid Column Variable

var commonSupName = '';
var pub_mainCat = 0;
function fix_header(tblName,w,h)
{
	$("#"+tblName+"").fixedHeader({
	width: w,height: h
	});
}

function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}

function ClearForm()
{
	document.frmPurchaseRequisition.reset();
	ClearTable('tblGlMain');
	ClearTable('tblItemMain');
	ValidateButtons(0);
}

function RemoveItem(obj)
{	
	if(!confirm('Are you sure you want to remove this item?'))
		return false;
		
	var url  = "purchaserequisitiondb.php?RequestType=URLRemoveItemFromPRTbl";
	url += "&SerialNo="+document.getElementById('txtSerialNo').value;
	url += "&MatId="+obj.parentNode.parentNode.cells[m_iDec].id;
	var htmlobj=$.ajax({url:url,async:false});
	
	var td = obj.parentNode;
	var tro = td.parentNode;
	tro.parentNode.removeChild(tro);
return true;
}

function ClosePRPopUp(LayerId)
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

function ClosePRPopUp1(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		//hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}

function roundNumber(num,dec)
{
	num = parseFloat(num).toFixed(parseFloat(dec));
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}

function CheckAll(obj,tblName)
{
	var tbl = document.getElementById(tblName);
	var checked = ((obj.checked)? true:false);
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].checked = checked;
	}
}

function LoadCurrencyRate(obj)
{
	var url  = "purchaserequisitionxml.php?RequestType=URLLoadCurrencyRate";
		url += "&CurrId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	var XMLRate = htmlobj.responseXML.getElementsByTagName("Rate");
	document.getElementById('txtExRate').value = XMLRate[0].childNodes[0].nodeValue;
	UpdateGLRowValue_whenCurrencyChange();
}

function OpenItemPopUp()
{
	if(!Validate_OpenItemPopUp())
		return;
	showBackGround('divBG',0);
	var url  = "popupitem.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(572,504,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	fix_header('tblPopItem',550,388);
}

function OpenGlPopUp()
{
	var url  = "popupgl.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(572,504,'frmPopGl',2);
	document.getElementById('frmPopGl').innerHTML = htmlobj.responseText;
	fix_header('tblPopGl',550,355);
}

function LoadSubCategory(obj)
{
	var url  = "purchaserequisitionxml.php?RequestType=URLLoadSubCategory";
		url += "&MainCat="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboPopSubCat').innerHTML = htmlobj.responseText;
}

function LoadPopItems()
{
	var url  = "purchaserequisitionxml.php?RequestType=URLLoadPopItems";
		url += "&MainCat="+document.getElementById('cboPopMainCat').value;
		url += "&SubCat="+document.getElementById('cboPopSubCat').value;
		url += "&ItemDesc="+URLEncode(document.getElementById('txtDesc').value.trim());
	htmlobj=$.ajax({url:url,async:false});
	CreatePopUpItemGrid(htmlobj);
}

function CreatePopUpItemGrid(htmlobj)
{
	var XMLMainCatId = htmlobj.responseXML.getElementsByTagName("MainCatId");
	var XMLItemId 	 = htmlobj.responseXML.getElementsByTagName("ItemId");
	var XMLItemDesc  = htmlobj.responseXML.getElementsByTagName("ItemDesc");
	var XMLUnit 	 = htmlobj.responseXML.getElementsByTagName("Unit");
	var tbl 		 = document.getElementById('tblPopItem');
	ClearTable('tblPopItem');
	for(loop=0;loop<XMLItemId.length;loop++)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
		
		var cell = row.insertCell(0);
		cell.className ="normalfntMid";
		cell.setAttribute('height','20');
		cell.id = XMLMainCatId[loop].childNodes[0].nodeValue;
		var tbl1 = document.getElementById("tblItemMain");
		var checked = "";
		for(i=1;i<tbl1.rows.length;i++)
		{
			if(tbl1.rows[i].cells[2].id == XMLItemId[loop].childNodes[0].nodeValue)
				var checked = "checked=checked";				
		}
		cell.innerHTML = "<input name=\"checkbox\" type=\"checkbox\" "+checked+" onclick=\"AddDetailsToMainTbl(this)\">";
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.id = XMLItemId[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLItemDesc[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.innerHTML = XMLUnit[loop].childNodes[0].nodeValue;
		
		
	}
}

function AddDetailsToMainTbl(obj)
{
	var rw 			= obj.parentNode.parentNode;
	var itemId 		= rw.cells[1].id;
	var mainCatId	= rw.cells[0].id;
	var booAvail	=  false;
	if(obj.checked)
	{
		var url  = "purchaserequisitionxml.php?RequestType=URLLoadDetailsToGLTbl";
			url += "&ItemId="+mainCatId;
			url += "&CostCenter="+document.getElementById('cboCostCenter').value;
		htmlobj_gl		 	= $.ajax({url:url,async:false});
		
		var XMLGlID 	 	= htmlobj_gl.responseXML.getElementsByTagName("GlID");
		var XMLGlDesc 	 	= htmlobj_gl.responseXML.getElementsByTagName("GlDesc");
		var XMLGlCode 		= htmlobj_gl.responseXML.getElementsByTagName("GlCode");
		var XMLModAmount 	= htmlobj_gl.responseXML.getElementsByTagName("ModAmount");
		var XMLAddAmount 	= htmlobj_gl.responseXML.getElementsByTagName("AddAmount");
		var XMLTrInAmount 	= htmlobj_gl.responseXML.getElementsByTagName("TransInAmount");
		var XMLBalAmount 	= htmlobj_gl.responseXML.getElementsByTagName("BalAmount");
		var XMLAcAmount 	= htmlobj_gl.responseXML.getElementsByTagName("ActualAmount");
		var XMLVarience 	= htmlobj_gl.responseXML.getElementsByTagName("Varience");
		var XMLRequested 	= htmlobj_gl.responseXML.getElementsByTagName("Requested");
		var XMLPending 		= htmlobj_gl.responseXML.getElementsByTagName("Pending");
		
		/* --------------------------------------------- */
		// Below condition comment on 30/07/2013
		// By Nalin Jayakody
		// Disable checking of budjet value and GL accounts
		/* -------------------------------------------- */
		
		/*if(XMLGlID.length<=0)
		{
			alert("No 'GL Account' found.");
			booAvail	=  false;
			obj.checked = false;
		}
		else if(XMLGlID.length>1)
		{
			//alert("Multiple 'GL Account' found.");
			ViewMultipleGLPopUp(mainCatId,document.getElementById('cboCostCenter').value,itemId);
			booAvail	=  false;
		}
		else
		{
			booAvail			=  true;
			var glId 			= XMLGlID[0].childNodes[0].nodeValue;
			var glDesc 			= XMLGlDesc[0].childNodes[0].nodeValue;
			var glCode 			= XMLGlCode[0].childNodes[0].nodeValue;
			var modAmount 		= XMLModAmount[0].childNodes[0].nodeValue;
			var addAmount 		= XMLAddAmount[0].childNodes[0].nodeValue;
			var transInAmount 	= XMLTrInAmount[0].childNodes[0].nodeValue;
			var balAmount 		= XMLBalAmount[0].childNodes[0].nodeValue;
			var acAmount 		= XMLAcAmount[0].childNodes[0].nodeValue;
			var varience 		= XMLVarience[0].childNodes[0].nodeValue;
			var requested 		= XMLRequested[0].childNodes[0].nodeValue;
			var pending			= XMLPending[0].childNodes[0].nodeValue;
			//pub_mainCat		= glId;
			CreateGLItemTbl(glId,glDesc,glCode,itemId,modAmount,addAmount,transInAmount,balAmount,acAmount,varience,requested,pending);
		}*/
		booAvail			=  true;
		
		if(booAvail)
		{			
			var glId = 0;
			
			var url  = "purchaserequisitionxml.php?RequestType=URLLoadDetailsToItemTbl";
			url += "&ItemId="+itemId;
			url += "&CostCenter="+document.getElementById('cboCostCenter').value;
			url += "&SupplierId="+document.getElementById('cboSupplier').value;;
			htmlobj=$.ajax({url:url,async:false});			
			
			var XMLItem 		= htmlobj.responseXML.getElementsByTagName("ItemId");
			
			for(loop=0;loop<XMLItem.length;loop++)
			{
				var XMLItemId 		= htmlobj.responseXML.getElementsByTagName("ItemId")[loop].childNodes[0].nodeValue;
				var XMLItemDesc 	= htmlobj.responseXML.getElementsByTagName("ItemDesc")[loop].childNodes[0].nodeValue;
				var XMLUnit 		= htmlobj.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
				var XMLUPrice 		= htmlobj.responseXML.getElementsByTagName("UPrice")[loop].childNodes[0].nodeValue;
				var XMLFUPriceDate 	= htmlobj.responseXML.getElementsByTagName("FUPriceDate")[loop].childNodes[0].nodeValue;
				var XMLUPriceDate 	= htmlobj.responseXML.getElementsByTagName("UPriceDate")[loop].childNodes[0].nodeValue;
				var XMLMainCat	 	= htmlobj.responseXML.getElementsByTagName("MainCat")[loop].childNodes[0].nodeValue;
				var XMLReorderLevel	= htmlobj.responseXML.getElementsByTagName("ReorderLevel")[loop].childNodes[0].nodeValue;
				var XMLStockBal		= htmlobj.responseXML.getElementsByTagName("StockBal")[loop].childNodes[0].nodeValue;
				var XMLOrderQty		= 0;
				var XMLDisPercent	= 0;
				var XMLRemarks		= "";
				CreateMainItemTbl(glId,XMLItemId,XMLItemDesc,XMLUnit,XMLUPrice,XMLFUPriceDate,XMLUPriceDate,XMLMainCat,XMLReorderLevel,XMLStockBal,XMLOrderQty,XMLDisPercent,XMLRemarks);
			}
		}
	}
	else
	{
		RemoveItemFromTbl1(itemId);
	}
}

function CreateMainItemTbl(glId,XMLItemId,XMLItemDesc,XMLUnit,XMLUPrice,XMLFUPriceDate,XMLUPriceDate,XMLMainCat,XMLReorderLevel,XMLStockBal,XMLOrderQty,XMLDisPercent,XMLRemarks)
{
	var tbl 			= document.getElementById('tblItemMain');
	if(IsItemAvailable(tbl,XMLItemId))
		return;
		
	var lastRow		= tbl.rows.length;	
	var row 		= tbl.insertRow(lastRow);
	
	if(parseFloat(XMLStockBal)<=parseFloat(XMLReorderLevel))
		row.className = "txtbox bcgcolor-InvoiceCostTrim";
	else
		row.className = "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(m_del);
	cell.className 	= "normalfntMid";
	cell.setAttribute('height','18');
	cell.id			= glId;
	cell.innerHTML 	= "<img src=\"../images/del.png\" alt=\"del\" onclick=\"RemoveItemFromTbl(this);\"/>";
	
	var cell 		= row.insertCell(m_iC);
	cell.className 	= "normalfnt";
	cell.id 		= XMLItemDesc;
	cell.innerHTML 	= XMLItemId;
	
	var cell 		= row.insertCell(m_iDec);
	cell.className 	= "normalfnt";
	cell.id 		= XMLItemId;
	cell.innerHTML 	= XMLItemDesc+"-"+XMLRemarks;
	cell.setAttribute("ondblclick", "OpenRemarkPopUp(this);");
	cell.setAttribute("title", XMLRemarks);
	
	var cell 		= row.insertCell(m_u);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= XMLUnit;
	
	var cell 		= row.insertCell(m_up);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= "<input type=\"text\" style=\"width:70px;text-align:right\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value,3,event);\" maxlength=\"10\" value=\""+XMLUPrice+"\" onkeyup=\"CalculateRowValue(this.parentNode.parentNode.rowIndex)\"/>";
	
	var cell 		= row.insertCell(m_pu);
	cell.className 	= "normalfntMid";
	cell.id			= XMLUPriceDate;
	cell.innerHTML 	= XMLFUPriceDate;
	
	var cell 		= row.insertCell(m_cs);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= XMLStockBal;
	
	var cell 		= row.insertCell(m_rl);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= XMLReorderLevel;
	
	var cell 		= row.insertCell(m_qty);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" style=\"width:70px;text-align:right\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value,1,event);\" maxlength=\"10\" value=\""+XMLOrderQty+"\" onkeyup=\"CalculateRowValue(this.parentNode.parentNode.rowIndex)\"/>";
	
	var cell		= row.insertCell(m_val);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= 0;
	
	var cell		= row.insertCell(m_dis);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= "<input type=\"text\" style=\"width:50px;text-align:right\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value,1,event);\" maxlength=\"10\" value=\""+XMLDisPercent+"\" onkeyup=\"CalculateRowValue(this.parentNode.parentNode.rowIndex)\"/>";
	
	var cell		= row.insertCell(m_disVal);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= 0;
	
	var cell		= row.insertCell(m_FinVval);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= 0;
	
	var cell		= row.insertCell(m_asset);
	cell.className 	= "normalfntMid";
	cell.innerHTML 	= "<input name=\"text\" type=\"checkbox\" />";
}

function CreateGLItemTbl(glId,glDesc,glCode,itemId,modAmount,addAmount,transInAmount,balAmount,acAmount,varience,requested,pending)
{
	var tblGl 			= document.getElementById('tblGlMain');
	if(IsGlAvailable(tblGl,glId))
		return;
	var lastRow		= tblGl.rows.length;	
	var row 		= tblGl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(0);
	cell.className 	= "normalfnt";
	cell.setAttribute('height','18');
	cell.id			= glId;
	cell.innerHTML 	= glCode;
	
	var cell 		= row.insertCell(1);
	cell.className 	= "normalfnt";
	cell.id 		= glId;
	cell.innerHTML 	= glDesc;
	
	var cell 		= row.insertCell(2);
	cell.className 	= "normalfntRite";	
	cell.innerHTML 	= modAmount;
	
	var cell 		= row.insertCell(3);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= addAmount;
	
	var cell 		= row.insertCell(4);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= transInAmount;
	
	var cell 		= row.insertCell(5);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= balAmount;
	
	var cell 		= row.insertCell(6);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= acAmount;
	
	var cell 		= row.insertCell(7);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= pending;
	
	var cell 		= row.insertCell(8);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= varience;
	
	var cell		= row.insertCell(9);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= requested;
	
	var cell		= row.insertCell(10);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= 0;
}

function IsGlAvailable(tblGl,itemId)
{
	for(i=1;i<tblGl.rows.length;i++)
	{
		var mainItemId	= tblGl.rows[i].cells[g_gc].id;
		if(mainItemId==itemId)
			return true;
	}
	return false;
}

function IsItemAvailable(tbl,itemId)
{
	for(i=1;i<tbl.rows.length;i++)
	{
		var mainItemId	= tbl.rows[i].cells[m_iDec].id;
		if(mainItemId==itemId)
			return true;
	}
	return false;
}

function RemoveItemFromTbl(obj)
{
	showBackGround('divBG',0);
	var tblMain	= document.getElementById('tblItemMain');
	var rw = obj.parentNode.parentNode;
	var mainId = rw.cells[m_del].id;
	if(!RemoveItem(obj)){
		hideBackGround('divBG');
		return;
	}
	var booAvail = false ;
	for(i=1;i<tblMain.rows.length;i++)
	{
		if(tblMain.rows[i].cells[m_del].id==mainId)
		{
			booAvail = true;
		}
	}
	
	if(!booAvail)
	{
		var tblGl = document.getElementById('tblGlMain');
		for(loop=1;loop<tblGl.rows.length;loop++)
		{
			if(tblGl.rows[loop].cells[g_gc].id==mainId)
			{
				var url  = "purchaserequisitiondb.php?RequestType=URLRemoveItemFromPRGLTbl";
					url += "&SerialNo="+document.getElementById('txtSerialNo').value;
					url += "&MainCatId="+tblGl.rows[loop].cells[g_gc].id;
					url += "&GLAllowId="+tblGl.rows[loop].cells[g_des].id;
				var htmlobj=$.ajax({url:url,async:false});
				tblGl.rows[loop].parentNode.removeChild(tblGl.rows[loop]);
			}
		}
	}
hideBackGround('divBG');
}

function RemoveItemFromTbl1(itemId)
{
	try{
	var tblMain		= document.getElementById('tblItemMain');	
	var booAvail 	= false ;
	for(i=1;i<tblMain.rows.length;i++)
	{
		if(tblMain.rows[i].cells[m_iDec].id==itemId)
		{
			glId	= tblMain.rows[i].cells[m_del].id;
			tblMain.rows[i].parentNode.removeChild(tblMain.rows[i]);
		}
	}
	
	for(i=1;i<tblMain.rows.length;i++)
	{
		if(tblMain.rows[i].cells[m_del].id==glId)
		{
			booAvail = true;
		}
	}
	if(!booAvail)
	{
		var tblGl = document.getElementById('tblGlMain');
		for(loop=1;loop<tblGl.rows.length;loop++)
		{
			if(tblGl.rows[loop].cells[g_gc].id==glId)
				tblGl.rows[loop].parentNode.removeChild(tblGl.rows[loop]);
		}
	}
	}
	catch(err)
	{
	}
}

function LoadSuppDetails(obj)
{
	var url  = "purchaserequisitionxml.php?RequestType=URLLoadSuppDetails";
	    url += "&SuppId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	var XMLCurrId = htmlobj.responseXML.getElementsByTagName("CurrId");
	document.getElementById('cboCurrencyId').value = XMLCurrId[0].childNodes[0].nodeValue;
	document.getElementById('cboCurrencyId').onchange();
}

//BEGIN - Calculation
function CalculateRowValue(rwIndex)
{
	var totRowValue 		= 0;
	var totRowDis 			= 0;
	var totRowFinalValue	= 0 ;
	var tbl 	 			= document.getElementById('tblItemMain');
	var glAllowNo			= parseInt(tbl.rows[rwIndex].cells[m_del].id);
	
	var uPrice 	 			= (tbl.rows[rwIndex].cells[m_up].childNodes[0].value=="" ? 0:parseFloat(tbl.rows[rwIndex].cells[m_up].childNodes[0].value));
	var qty 	 			= (tbl.rows[rwIndex].cells[m_qty].childNodes[0].value=="" ? 0:parseFloat(tbl.rows[rwIndex].cells[m_qty].childNodes[0].value));
	var disPercent 			= (tbl.rows[rwIndex].cells[m_dis].childNodes[0].value=="" ? 0:parseFloat(tbl.rows[rwIndex].cells[m_dis].childNodes[0].value));
	var rowValue			= uPrice*qty;
	rowValue 				= parseFloat(rowValue.toFixed(4));
	tbl.rows[rwIndex].cells[m_val].childNodes[0].nodeValue 	= roundNumber(rowValue,4);
	var rowDisValue			= (rowValue*disPercent)/100;
	rowDisValue				= parseFloat(rowDisValue.toFixed(4));
	tbl.rows[rwIndex].cells[m_disVal].childNodes[0].nodeValue 	= roundNumber(rowDisValue,4);
	tbl.rows[rwIndex].cells[m_FinVval].childNodes[0].nodeValue = roundNumber(rowValue-rowDisValue,4);
	
	for(i=1;i<tbl.rows.length;i++)
	{
		totRowValue 		+= parseFloat(tbl.rows[i].cells[m_val].childNodes[0].nodeValue);
		totRowDis 			+= (tbl.rows[i].cells[m_dis].childNodes[0].value=="" ? 0:parseFloat(tbl.rows[i].cells[m_dis].childNodes[0].value));
		totRowFinalValue	+= (tbl.rows[i].cells[m_FinVval].childNodes[0].nodeValue=="" ? 0:parseFloat(tbl.rows[i].cells[m_FinVval].childNodes[0].nodeValue));
	}
	
	if(totRowDis>0)
	{
		document.getElementById('txtDisPercent').disabled = true;
		document.getElementById('txtDisPercent').value 	  = 0;
		document.getElementById('txtDisValue').value	  = 0;
	}
	else
	{
		document.getElementById('txtDisPercent').disabled = false;
	}
	
	document.getElementById('txtTotalValue').value  = roundNumber(totRowFinalValue,4);
	var discount = parseFloat(document.getElementById('txtDisPercent').value);
	var disValue = roundNumber((totRowFinalValue*discount)/100,4);
	document.getElementById('txtDisValue').value 	= disValue;
	document.getElementById('txtPRValue').value 	= roundNumber(totRowFinalValue-disValue,4);
	
	var mainCatId	= parseInt(tbl.rows[rwIndex].cells[m_del].id);
	var fincalValue = roundNumber(rowValue-rowDisValue,4);
	UpdateGLRowValue(mainCatId,fincalValue,glAllowNo);
}

function CalculateDiscount(obj)
{
	var totValue = parseFloat(document.getElementById('txtTotalValue').value);
	var discount = (obj.value=="" ? 0:parseFloat(obj.value));
	var disValue = roundNumber((totValue*discount)/100,4);
	document.getElementById('txtDisValue').value 	= roundNumber(disValue,4);
	document.getElementById('txtPRValue').value 	= roundNumber(totValue-disValue,4);
}

function SetZeroIfEmpty(obj)
{
	if(obj.value=="")
	{
		obj.value = 0;
	}
}

/*BEGIN - When enter details to main grid automatically GL grid value will change.
@mainCatId param is a item main category Id
@fincalValue param is a final value of current row*/
function UpdateGLRowValue(mainCatId,fincalValue,glAllowNo)
{
	var fincalValue	= 0;
	var exRate 		= parseFloat(document.getElementById('txtExRate').value);
	var tblGlMain	= document.getElementById('tblGlMain');
	var tblMain		= document.getElementById('tblItemMain');
	for(loop=1;loop<tblMain.rows.length;loop++)
	{
		if(glAllowNo==parseInt(tblMain.rows[loop].cells[m_del].id))
		{
			fincalValue += parseFloat(tblMain.rows[loop].cells[m_FinVval].childNodes[0].nodeValue);
		}
	}
	value		= parseFloat(fincalValue)*exRate;
	for(i=1;i<tblGlMain.rows.length;i++)
	{
		if(mainCatId==tblGlMain.rows[i].cells[g_gc].id)
		{
			tblGlMain.rows[i].cells[g_currB].childNodes[0].nodeValue = roundNumber(value,4);
			tblGlMain.rows[i].cells[g_currB].id	 					 = roundNumber(fincalValue,4);
		}
	}
}
/*END - When enter details to main grid automatically GL grid value will change*/

/*BEGIN - When change the currency combo value will calculate from ex Rate.*/
function UpdateGLRowValue_whenCurrencyChange()
{
	var exRate 		= parseFloat(document.getElementById('txtExRate').value);
	var tblGlMain	= document.getElementById('tblGlMain');
	var value 		= 0;
	for(i=1;i<tblGlMain.rows.length;i++)
	{
		value = roundNumber(parseFloat(tblGlMain.rows[i].cells[g_currB].id)*exRate,4);
		tblGlMain.rows[i].cells[g_currB].childNodes[0].nodeValue = value;
	}
}
/*END - When change the currency combo value will calculate from ex Rate.*/

//END - Calculation

function SavePR()
{
	showBackGround('divBG',0);
	var tblMain		= document.getElementById('tblItemMain');
	var tblGlMain	= document.getElementById('tblGlMain');
	var no 			= document.getElementById('txtSerialNo').value;
	var currencyId 	= document.getElementById('cboCurrencyId').value;
	var exRange		= document.getElementById('txtExRate').value;
	var companyId 	= document.getElementById('cboCostCenter').value;
	var supplierId 	= document.getElementById('cboSupplier').value;
	var department 	= document.getElementById('cboDepartment').value;
	var attension 	= document.getElementById('txtAttension').value.trim();
	var jobType		= document.getElementById('cboJobType').value;
	
	if(!ValidateInterface(supplierId,currencyId,department,tblMain,jobType,companyId))
	{
		hideBackGround('divBG');
		return;
	}
	
	if(no=="")
	{
		GetNewSerialNo();
		SaveHeader();
		SaveDetails(tblMain);
		SaveGLDetails(tblGlMain);
		alert("Saved successfully.");
		ValidateButtons(0);
		hideBackGround('divBG');
	}
	else
	{
		no 				= no.split("/");
		pub_serialNo 	= parseInt(no[1]);
		pub_serialYear 	= parseInt(no[0]);
		SaveHeader();
		SaveDetails(tblMain);
		SaveGLDetails(tblGlMain);
		alert("Updated successfully.");
		ValidateButtons(0);
		hideBackGround('divBG');
	}
}

//BEGIN - Upload files
function UploadFile()
{
	if (document.getElementById('txtPRNo').value == null || document.getElementById('txtPRNo').value == "")
	{
		alert("Please get saved \"Purchase Requestion No\".");	
		document.getElementById('txtPRNo').focus();
		return ;
	}
	
	var PurchReqNo = document.getElementById('txtSerialNo').value;
	var	popwindow= window.open ("prUpload.php?No=" + PurchReqNo, "Supplier Uploader","location=1,status=1,scrollbars=1,width=450,height=300");
	popwindow.moveTo(((screen.width - 450)/2),((screen.height - 160)/2));
	popwindow.focus();	
}
//END - Upload files

//BEGIN - Save validation will return a booloen value true/false
function ValidateInterface(supplierId,currencyId,department,tblMain,jobType,costCenter)
{
	if(costCenter=="")
	{
		alert("Please select 'Cost Center'.");
		document.getElementById('cboCostCenter').focus();
		return false;
	}
	/*else if(supplierId=="null")
	{
		alert("Please select 'Supplier'.");
		document.getElementById('cboSupplier').focus();
		return false;
	}*/
	/*else if(currencyId=="null")
	{
		alert("Please select 'Currency'.");
		document.getElementById('cboCurrencyId').focus();
		return false;
	}*/
	else if(department=="null")
	{
		alert("Please select 'Department'.");
		document.getElementById('cboDepartment').focus();
		return false;
	}
	else if(jobType=="")
	{
		alert("Please select 'Job Type'");
		document.getElementById('cboJobType').focus();
		return false;
	}
	else if(tblMain.rows.length<=1)
	{
		alert("No item details found to save.\nPlease add item and try again.");
		return false;
	}
return true;
}
//END - Save validation will return a booloen value true/false

function GetNewSerialNo()
{
	var url  = "purchaserequisitiondb.php?RequestType=URLGetNewSerialNo";
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLAdmin	= htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
	if(XMLAdmin=="TRUE")
	{
		var XMLNo 		= htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
		var XMLYear 	= htmlobj.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
		var XMLPRCode 	= htmlobj.responseXML.getElementsByTagName("PRCode")[0].childNodes[0].nodeValue;
		pub_serialNo 	= parseInt(XMLNo);
		pub_serialYear 	= parseInt(XMLYear);
		document.getElementById("txtSerialNo").value = pub_serialYear + "/" + pub_serialNo;
		document.getElementById('txtPRNo').value = XMLPRCode;
		return true;
	}
	else
	{
		alert("Please contact system administrator to assign new Return No.");
		hideBackGround('divBG');
		return false;
	}
return true;
}

function SaveHeader()
{
	var url  = "purchaserequisitiondb.php?RequestType=URLSaveHeader";
		url += "&SerialNo="+pub_serialNo;
		url += "&SerialYear="+pub_serialYear;
		url += "&PRNo="+URLEncode(document.getElementById('txtPRNo').value.trim());
		url += "&SupplierId="+document.getElementById('cboSupplier').value;
		url += "&CurrencyId="+document.getElementById('cboCurrencyId').value;
		url += "&CurrRate="+document.getElementById('txtExRate').value;
		url += "&DeptId="+document.getElementById('cboDepartment').value;
		url += "&Attension="+URLEncode(document.getElementById('txtAttension').value.trim());
		url += "&Intro="+URLEncode(document.getElementById('txtIntroduction').value.trim());
		url += "&JobNo="+URLEncode(document.getElementById('txtJobNo').value.trim());
		url += "&Discount="+document.getElementById('txtDisPercent').value.trim();
		url += "&TotalValue="+document.getElementById('txtTotalValue').value.trim();
		url += "&TotalPRValue="+document.getElementById('txtPRValue').value.trim();
		url += "&CostCenterId="+document.getElementById('cboCostCenter').value.trim();
		url += "&DisValue="+document.getElementById('txtDisValue').value.trim();
		url += "&JobType="+document.getElementById('cboJobType').value;
		url += "&commonSupName="+URLEncode(commonSupName);
	htmlobj=$.ajax({url:url,async:false});
}

function SaveDetails(tblMain)
{
	for(i=1;i<tblMain.rows.length;i++)
	{
		var url  = "purchaserequisitiondb.php?RequestType=URLSaveDetails";
			url += "&SerialNo="+pub_serialNo;
			url += "&SerialYear="+pub_serialYear;
			url += "&MatId="+tblMain.rows[i].cells[m_iDec].id;
			url += "&Unit="+tblMain.rows[i].cells[m_u].childNodes[0].nodeValue;
			url += "&UnitPrice="+tblMain.rows[i].cells[m_up].childNodes[0].value;			
			url += "&Qty="+tblMain.rows[i].cells[m_qty].childNodes[0].value;
			url += "&Value="+tblMain.rows[i].cells[m_val].childNodes[0].nodeValue;
			url += "&Discount="+tblMain.rows[i].cells[m_dis].childNodes[0].value;
			url += "&DisValue="+tblMain.rows[i].cells[m_disVal].childNodes[0].nodeValue;
			url += "&FinalValue="+tblMain.rows[i].cells[m_FinVval].childNodes[0].nodeValue;
			url += "&Assest="+(tblMain.rows[i].cells[m_asset].childNodes[0].checked==true ? 1:0);
			url += "&GLAllowId="+(tblMain.rows[i].cells[m_del].id);
			url += "&Remarks="+(tblMain.rows[i].cells[m_iDec].title);
		htmlobj=$.ajax({url:url,async:false});
	}
}
//Break
/*BEGIN - Save GL Details to temp table till Ho approval.After Ho approval this details will save to actual table.
@tblGlMain param is GL table Id */
function SaveGLDetails(tblGlMain)
{
	for(i=1;i<tblGlMain.rows.length;i++)
	{
		var url  = "purchaserequisitiondb.php?RequestType=URLSaveGLDetails";
			url += "&SerialNo="+pub_serialNo;
			url += "&SerialYear="+pub_serialYear;
			url += "&GLAlloId="+tblGlMain.rows[i].cells[g_des].id;
			url += "&CurrBuAmount="+tblGlMain.rows[i].cells[g_currB].childNodes[0].nodeValue;
			url += "&MainCatId="+tblGlMain.rows[i].cells[g_gc].id;
			url += "&CurrentBudget="+tblGlMain.rows[i].cells[g_currB].childNodes[0].nodeValue;
			url += "&CostCenterId="+document.getElementById('cboCostCenter').value;
		htmlobj=$.ajax({url:url,async:false});
	}
}
/*BEGIN - Save GL Details to temp table till Ho approval.After Ho approval this details will save to actual table.*/
function SendToApproval()
{
	var prNo = document.getElementById("txtSerialNo").value;
		
	if(!ValidateSendToApproval(prNo))
		return;
		
	if(!confirm("Are you sure you want to send to approval PR No : "+ document.getElementById("txtPRNo").value +" ? "))
		return;
		
	var url  = "purchaserequisitiondb.php?RequestType=URLSendToApproval";
		url += "&SerialNo="+prNo;
	var htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseText=='true'){
		alert("PR No : "+document.getElementById("txtPRNo").value+" send for approvals.");
		ValidateButtons(1);
	}
	else{
		alert("Sorry!\nError occur while current process is running. Please click 'Send To Approval' button again.");
		ValidateButtons(0);
	}
}

//BEGIN - 25-04-2011 View report
function ViewReport()
{
	var no		= document.getElementById('txtSerialNo').value;
	if(no==""){alert("Sorry!\nNo saved details appear to view.");return;}
	if(no!="0"){			
	newwindow=window.open('rptPR.php?No='+no,'rptPR.php');
	if (window.focus) {newwindow.focus()}
	}
}
//END - 25-04-2011 View report

function Validate_OpenItemPopUp()
{
	if(document.getElementById('cboCostCenter').value=="")
	{
		alert("Please select 'Cost Center'.");
		document.getElementById('cboCostCenter').focus();
		return false;
	}
	/*if(document.getElementById('cboSupplier').value=="null")
	{
		alert("Please select 'Supplier'.");
		document.getElementById('cboSupplier').focus();
		return false;
	}*/
	/*if(document.getElementById('cboCurrencyId').value=="null")
	{
		alert("Please select 'Currency'.");
		document.getElementById('cboCurrencyId').focus();
		return false;
	}*/
return true;
}

//BEGIN - Load saved details for editing
function LoadSavedDeials(id,year,no)
{
	if(id=='0')
		return;
	
	LoadSaved_Header(year,no);	
	LoadSaved_GLdetails(year,no);
	LoadSaved_Details(year,no);
}

function LoadSaved_Header(year,no)
{
	var url  = "purchaserequisitionxml.php?RequestType=URLLoadSaved_Header";
		url += "&Year="+year;
		url += "&No="+no;
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('txtPRNo').value 		 = htmlobj.responseXML.getElementsByTagName("PRNo")[0].childNodes[0].nodeValue;
	document.getElementById('txtSerialNo').value 	 = htmlobj.responseXML.getElementsByTagName("SerialNo")[0].childNodes[0].nodeValue;
	no 												 = document.getElementById('txtSerialNo').value.split("/");
	pub_serialNo 									 = parseInt(no[1]);
	pub_serialYear 									 = parseInt(no[0]);
	document.getElementById('cboSupplier').value 	 = htmlobj.responseXML.getElementsByTagName("SuppId")[0].childNodes[0].nodeValue;
	document.getElementById('cboCurrencyId').value 	 = htmlobj.responseXML.getElementsByTagName("CurrId")[0].childNodes[0].nodeValue;
	document.getElementById('cboCurrencyId').onchange();
	document.getElementById('cboDepartment').value 	 = htmlobj.responseXML.getElementsByTagName("DeptId")[0].childNodes[0].nodeValue;
	document.getElementById('cboCostCenter').value 	 = htmlobj.responseXML.getElementsByTagName("CostCenterId")[0].childNodes[0].nodeValue;
	document.getElementById('txtAttension').value 	 = htmlobj.responseXML.getElementsByTagName("Attension")[0].childNodes[0].nodeValue;
	document.getElementById('txtIntroduction').value = htmlobj.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
	document.getElementById('txtJobNo').value 		 = htmlobj.responseXML.getElementsByTagName("JobNo")[0].childNodes[0].nodeValue;
	var status										 = htmlobj.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue;
	document.getElementById('cboJobType').value 	 = htmlobj.responseXML.getElementsByTagName("JobType")[0].childNodes[0].nodeValue;
	commonSupName	 = htmlobj.responseXML.getElementsByTagName("CommonSupName")[0].childNodes[0].nodeValue;
	ValidateButtons(status);
}

function LoadSaved_Details(year,no)
{
	var i=0;
	var url  = "purchaserequisitionxml.php?RequestType=URLLoadSaved_details";
		url += "&Year="+year;
		url += "&No="+no;
	var htmlobj=$.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseXML.getElementsByTagName("DetailId");
	for(var loop=0;loop<XMLItem.length;loop++)
	{
		var XMLItemId 		= htmlobj.responseXML.getElementsByTagName("DetailId")[loop].childNodes[0].nodeValue;
		var XMLItemDesc 	= htmlobj.responseXML.getElementsByTagName("ItemDesc")[loop].childNodes[0].nodeValue;
		var XMLUnit 		= htmlobj.responseXML.getElementsByTagName("UnitId")[loop].childNodes[0].nodeValue;
		var XMLUPrice 		= htmlobj.responseXML.getElementsByTagName("UPrice")[loop].childNodes[0].nodeValue;
		var XMLMainCat 		= htmlobj.responseXML.getElementsByTagName("MainCat")[loop].childNodes[0].nodeValue;
		var XMLReorderLevel = htmlobj.responseXML.getElementsByTagName("ReorderLevel")[loop].childNodes[0].nodeValue;
		var XMLStockBal 	= htmlobj.responseXML.getElementsByTagName("StockBal")[loop].childNodes[0].nodeValue;
		var XMLOrderQty 	= htmlobj.responseXML.getElementsByTagName("OrderQty")[loop].childNodes[0].nodeValue;
		var XMLDisPercent 	= htmlobj.responseXML.getElementsByTagName("DisPercent")[loop].childNodes[0].nodeValue;
		var XMLFUPriceDate	= htmlobj.responseXML.getElementsByTagName("FormatedDate")[loop].childNodes[0].nodeValue;
		var XMLUPriceDate	= htmlobj.responseXML.getElementsByTagName("Date")[loop].childNodes[0].nodeValue;
		var XMLGLAllowId	= htmlobj.responseXML.getElementsByTagName("GLAllowId")[loop].childNodes[0].nodeValue;
		var XMLRemarks		= htmlobj.responseXML.getElementsByTagName("Remarks")[loop].childNodes[0].nodeValue;
		
		CreateMainItemTbl(XMLGLAllowId,XMLItemId,XMLItemDesc,XMLUnit,XMLUPrice,XMLFUPriceDate,XMLUPriceDate,XMLMainCat,XMLReorderLevel,XMLStockBal,XMLOrderQty,XMLDisPercent,XMLRemarks);
		CalculateRowValue(++i);
	}
}

function LoadSaved_GLdetails(year,no)
{
	var url  = "purchaserequisitionxml.php?RequestType=URLLoadSaved_GLdetails";
		url += "&Year="+year;
		url += "&No="+no;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLMainCat = htmlobj.responseXML.getElementsByTagName("MainCatId");
	for(var loop=0;loop<XMLMainCat.length;loop++)
	{
		pub_mainCat 		= htmlobj.responseXML.getElementsByTagName("MainCatId")[loop].childNodes[0].nodeValue;
		var glId 			= htmlobj.responseXML.getElementsByTagName("GlID")[loop].childNodes[0].nodeValue;
		var glDesc 			= htmlobj.responseXML.getElementsByTagName("GlDesc")[loop].childNodes[0].nodeValue;
		var glCode 			= htmlobj.responseXML.getElementsByTagName("GlCode")[loop].childNodes[0].nodeValue;
		var modAmount 		= htmlobj.responseXML.getElementsByTagName("ModAmount")[loop].childNodes[0].nodeValue;
		var addAmount 		= htmlobj.responseXML.getElementsByTagName("AddAmount")[loop].childNodes[0].nodeValue;
		var transInAmount 	= htmlobj.responseXML.getElementsByTagName("TransInAmount")[loop].childNodes[0].nodeValue;
		var balAmount 		= htmlobj.responseXML.getElementsByTagName("BalAmount")[loop].childNodes[0].nodeValue;
		var acAmount 		= htmlobj.responseXML.getElementsByTagName("ActualAmount")[loop].childNodes[0].nodeValue;
		var varience 		= htmlobj.responseXML.getElementsByTagName("Varience")[loop].childNodes[0].nodeValue;
		var requested 		= htmlobj.responseXML.getElementsByTagName("Requested")[loop].childNodes[0].nodeValue;
		var pending			= htmlobj.responseXML.getElementsByTagName("Pending")[loop].childNodes[0].nodeValue
		var itemId			= '';
		CreateGLItemTbl(glId,glDesc,glCode,itemId,modAmount,addAmount,transInAmount,balAmount,acAmount,varience,requested,pending);
	}
}

//END - Load saved details for editing
function ValidateButtons(status)
{
	if(status=='0')
	{
		document.getElementById('butSave').style.display = 'inline';
		document.getElementById('butSendToApproval').style.display = 'inline';
		document.getElementById('butUpload').style.display = 'inline';
		document.getElementById('butRevise').style.display = 'none';
		document.getElementById('butCancel').style.display = 'none';
		document.getElementById('butHOApproval').style.display = 'none';
	}
	else if(status=='1')
	{
		document.getElementById('butSave').style.display = 'none';
		document.getElementById('butSendToApproval').style.display = 'none';
		document.getElementById('butUpload').style.display = 'none';
		document.getElementById('butRevise').style.display = 'none';
		document.getElementById('butCancel').style.display = 'none';
		document.getElementById('butHOApproval').style.display = 'none';
	}
	else if(status=='2')
	{
		document.getElementById('butSave').style.display = 'none';
		document.getElementById('butSendToApproval').style.display = 'none';
		document.getElementById('butUpload').style.display = 'none';
		document.getElementById('butRevise').style.display = 'none';
		document.getElementById('butCancel').style.display = 'none';
		document.getElementById('butHOApproval').style.display = 'inline';
	}
	else if(status=='3')
	{
		document.getElementById('butSave').style.display = 'none';
		document.getElementById('butSendToApproval').style.display = 'none';
		document.getElementById('butUpload').style.display = 'none';
		document.getElementById('butRevise').style.display = 'inline';
		document.getElementById('butCancel').style.display = 'inline';
		document.getElementById('butHOApproval').style.display = 'none';
	}
	else if(status=='10')
	{
		document.getElementById('butSave').style.display = 'none';
		document.getElementById('butSendToApproval').style.display = 'none';
		document.getElementById('butUpload').style.display = 'none';
		document.getElementById('butRevise').style.display = 'none';
		document.getElementById('butCancel').style.display = 'none';
		document.getElementById('butHOApproval').style.display = 'none';
	}
}

//BEGIN - 29-06-2011 First Approval , Second Approval & Reject Part
function ConfirmFirstApproval(no)
{	
	var url  = "purchaserequisitiondb.php?RequestType=URLConfirmFirstApproval";
		url += "&SerialNo="+no;
		url += "&ApprovalRemarks="+URLEncode(document.getElementById('txtApprovalRemarks').value.trim());
	var htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseText=='true'){
		alert("PR First Approval updated successfully.This PR send for Second Approval.");
		window.opener.location.reload();
		newwindow=window.open('rptPR.php?No='+no,'rptPR.php');
		
	}
	else{
		alert("Sorry!\nError occur while current process is running. Please click 'Approve' button again.");
	}
}

function ConfirmSecondApproval(no)
{
	var url  = "purchaserequisitiondb.php?RequestType=URLConfirmSecondApproval";
		url += "&SerialNo="+no;
		url += "&ApprovalRemarks="+URLEncode(document.getElementById('txtApprovalRemarks').value.trim());
	var htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseText=='true'){
		alert("PR Second Approval updated successfully.This PR ready for purchasing.");
		window.opener.location.reload();
		newwindow=window.open('rptPR.php?No='+no,'rptPR.php');
	}
	else{
		alert("Sorry!\nError occur while current process is running. Please click 'Approve' button again.");
	}
}

function RejectPR(no)
{
	if(document.getElementById('txtApprovalRemarks').value.trim()=="")
	{
		alert("Please enter reason for reject this PR.");
		document.getElementById('txtApprovalRemarks').focus();
		return;
	}
	if(!confirm("Are you sure you want to reject this PR ?"))
		return;
	var url  = "purchaserequisitiondb.php?RequestType=URLRejectPR";
		url += "&SerialNo="+no;
		url += "&ApprovalRemarks="+URLEncode(document.getElementById('txtApprovalRemarks').value.trim());
	var htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseText=='true'){
		alert("Rejected successfully.");
		window.opener.location.reload();
		newwindow=window.open('rptPR.php?No='+no,'rptPR.php');
	}
	else{
		alert("Sorry!\nError occur while current process is running. Please click 'Reject' button again.");
	}
}
//END - 29-06-2011 First Approval , Second Approval & Reject Part

function ValidateSendToApproval(prNo)
{
	var tblGL = document.getElementById('tblGlMain');
	if(prNo=="")
	{
		alert("Sorry !\nNo PR No appear to send to approval.");
		return false;
	}
	
	for(var loop=1;loop<tblGL.rows.length;loop++)
	{
		var totalBudget 	= parseFloat(tblGL.rows[loop].cells[g_totB].childNodes[0].nodeValue);
		var pending 		= parseFloat(tblGL.rows[loop].cells[g_pen].childNodes[0].nodeValue);
		var requested 		= parseFloat(tblGL.rows[loop].cells[g_req].childNodes[0].nodeValue);
		var currentBudget 	= parseFloat(tblGL.rows[loop].cells[g_currB].childNodes[0].nodeValue);
		var pendingCurrentBudget = roundNumber(pending+currentBudget,4);
		var variance 		= roundNumber(totalBudget-pendingCurrentBudget,4);
		if(variance<0)
		{
			alert("Sorry !\nYou cannot send this PR to approval , Because no enough budget available.\nPending budget + Current budget exceed total budget balance.\nBudget balance : "+totalBudget+"\nPending PR amount : " +pending+"\nCurrent budget amount : "+currentBudget+"\nPending budget + Current budget : "+pendingCurrentBudget+"\nVariance : "+variance);
			return false;
		}
	}
return true;
}

function CancelPR()
{
	var cancelReason = prompt("Please enter reason for cancellation :");
	if(cancelReason=="")
	{
		alert("Please enter 'Reason For Cancellation'.");
		return;
	}
	var url  = "purchaserequisitiondb.php?RequestType=URLCancelPR";
		url += "&SerialNo="+document.getElementById('txtSerialNo').value;
		url += "&CancelReason="+URLEncode(cancelReason);
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLValidate = htmlobj.responseXML.getElementsByTagName("Validate")[0].childNodes[0].nodeValue;
	var XMLMessage = htmlobj.responseXML.getElementsByTagName("Message")[0].childNodes[0].nodeValue;
	
	if(XMLValidate=='True')
	{
		alert(XMLMessage);
		ValidateButtons(10);
	}
	else if(XMLValidate=='False')
	{
		alert(XMLMessage);
		ValidateButtons(3);
	}	
}

function RevisePR()
{
	var reviseReason = prompt("Please enter reason for revise :");
	if(reviseReason==null)
		return;
	if(reviseReason=="")
	{
		alert("Please enter 'Reason For Revise'.");
		return;
	}
		var url  = "purchaserequisitiondb.php?RequestType=URLRevisePR";
		url += "&SerialNo="+document.getElementById('txtSerialNo').value;
		url += "&ReviseReason="+URLEncode(reviseReason);
		
	var htmlobj=$.ajax({url:url,async:false});
	var XMLValidate = htmlobj.responseXML.getElementsByTagName("Validate")[0].childNodes[0].nodeValue;
	var XMLMessage 	= htmlobj.responseXML.getElementsByTagName("Message")[0].childNodes[0].nodeValue;
	
	if(XMLValidate=='True')
	{
		var PRYear	= htmlobj.responseXML.getElementsByTagName("PRYear")[0].childNodes[0].nodeValue;
		var PRNo 	= htmlobj.responseXML.getElementsByTagName("PRNo")[0].childNodes[0].nodeValue;
		alert(XMLMessage);
		ValidateButtons(0);
		LoadSavedDeials(1,PRYear,PRNo);
	}
	else if(XMLValidate=='False')
	{
		alert(XMLMessage);
		ValidateButtons(3);
	}
}

//BEGIN - 21-11-2011 - 
function ViewMultipleGLPopUp(mainCatId,costId,itemId)
{
	//showBackGround('divBG',1);
	var url  = "popup_multiGL.php?MainCatId="+mainCatId+"&CostId="+costId+"&ItemId="+itemId;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(572,504,'frmPopItem1',2);
	document.getElementById('frmPopItem1').innerHTML = htmlobj.responseText;
	//fix_header('tblPopItem',550,388);
}

function AddDetailsToMainTbl_Multiple(obj)
{
	var rw 			= obj.parentNode.parentNode;
	var itemId 		= rw.cells[1].id;
	var glAlloId	= rw.cells[0].id;
	var booAvail	=  false;
	if(obj.checked)
	{
		var tblMulGL = document.getElementById("tblPopItem1");
		for(i=1;i<tblMulGL.rows.length;i++)
		{
			if(tblMulGL.rows[i].cells[0].id != glAlloId)
			{
				tblMulGL.rows[i].childNodes[1].childNodes[0].checked = false;
			}
		}
		RemoveItemFromTbl1(itemId);
		
		var url  = "purchaserequisitionxml.php?RequestType=URLLoadDetailsToGLTbl_Multiple";
			url += "&ItemId="+glAlloId;
			url += "&CostCenter="+document.getElementById('cboCostCenter').value;
		htmlobj_gl		 	= $.ajax({url:url,async:false});
		
		var XMLGlID 	 	= htmlobj_gl.responseXML.getElementsByTagName("GlID");
		var XMLGlDesc 	 	= htmlobj_gl.responseXML.getElementsByTagName("GlDesc");
		var XMLGlCode 		= htmlobj_gl.responseXML.getElementsByTagName("GlCode");
		var XMLModAmount 	= htmlobj_gl.responseXML.getElementsByTagName("ModAmount");
		var XMLAddAmount 	= htmlobj_gl.responseXML.getElementsByTagName("AddAmount");
		var XMLTrInAmount 	= htmlobj_gl.responseXML.getElementsByTagName("TransInAmount");
		var XMLBalAmount 	= htmlobj_gl.responseXML.getElementsByTagName("BalAmount");
		var XMLAcAmount 	= htmlobj_gl.responseXML.getElementsByTagName("ActualAmount");
		var XMLVarience 	= htmlobj_gl.responseXML.getElementsByTagName("Varience");
		var XMLRequested 	= htmlobj_gl.responseXML.getElementsByTagName("Requested");
		var XMLPending 		= htmlobj_gl.responseXML.getElementsByTagName("Pending");
		
		if(XMLGlID.length<=0)
		{
			alert("No 'GL Account' found.");
			booAvail	=  false;
			obj.checked = false;
		}
		else
		{
			booAvail			=  true;
			var glId 			= XMLGlID[0].childNodes[0].nodeValue;
			var glDesc 			= XMLGlDesc[0].childNodes[0].nodeValue;
			var glCode 			= XMLGlCode[0].childNodes[0].nodeValue;
			var modAmount 		= XMLModAmount[0].childNodes[0].nodeValue;
			var addAmount 		= XMLAddAmount[0].childNodes[0].nodeValue;
			var transInAmount 	= XMLTrInAmount[0].childNodes[0].nodeValue;
			var balAmount 		= XMLBalAmount[0].childNodes[0].nodeValue;
			var acAmount 		= XMLAcAmount[0].childNodes[0].nodeValue;
			var varience 		= XMLVarience[0].childNodes[0].nodeValue;
			var requested 		= XMLRequested[0].childNodes[0].nodeValue;
			var pending			= XMLPending[0].childNodes[0].nodeValue;
			CreateGLItemTbl(glId,glDesc,glCode,itemId,modAmount,addAmount,transInAmount,balAmount,acAmount,varience,requested,pending);
		}
		
		if(booAvail)
		{			
			var url  = "purchaserequisitionxml.php?RequestType=URLLoadDetailsToItemTbl_Multiple";
			url += "&ItemId="+itemId;
			url += "&CostCenter="+document.getElementById('cboCostCenter').value;;
			htmlobj=$.ajax({url:url,async:false});			
			
			var XMLItem 		= htmlobj.responseXML.getElementsByTagName("ItemId");
			for(loop=0;loop<XMLItem.length;loop++)
			{
				var XMLItemId 		= htmlobj.responseXML.getElementsByTagName("ItemId")[loop].childNodes[0].nodeValue;
				var XMLItemDesc 	= htmlobj.responseXML.getElementsByTagName("ItemDesc")[loop].childNodes[0].nodeValue;
				var XMLUnit 		= htmlobj.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
				var XMLUPrice 		= htmlobj.responseXML.getElementsByTagName("UPrice")[loop].childNodes[0].nodeValue;
				var XMLFUPriceDate 	= htmlobj.responseXML.getElementsByTagName("FUPriceDate")[loop].childNodes[0].nodeValue;
				var XMLUPriceDate 	= htmlobj.responseXML.getElementsByTagName("UPriceDate")[loop].childNodes[0].nodeValue;
				var XMLMainCat	 	= htmlobj.responseXML.getElementsByTagName("MainCat")[loop].childNodes[0].nodeValue;
				var XMLReorderLevel	= htmlobj.responseXML.getElementsByTagName("ReorderLevel")[loop].childNodes[0].nodeValue;
				var XMLStockBal		= htmlobj.responseXML.getElementsByTagName("StockBal")[loop].childNodes[0].nodeValue;
				var XMLOrderQty		= 0;
				var XMLDisPercent	= 0;
				var XMLRemarks		= "";
				CreateMainItemTbl(glId,XMLItemId,XMLItemDesc,XMLUnit,XMLUPrice,XMLFUPriceDate,XMLUPriceDate,XMLMainCat,XMLReorderLevel,XMLStockBal,XMLOrderQty,XMLDisPercent,XMLRemarks);
			}
		}
		ClosePRPopUp1('popupLayer2');	
	}
	else
	{
		RemoveItemFromTbl1(itemId);
	}
}
//END - 21-11-2011 - 
var public	= "";
function OpenRemarkPopUp(obj)
{
	public	= obj;
	showBackGround('divBG',0);
	var url  = "remarks.php?";
	var htmlobj = $.ajax({url:url,async:false});
	drawPopupBox(550,68,'frmPopItem1',1);
	document.getElementById('frmPopItem1').innerHTML = htmlobj.responseText;
	document.getElementById('txtPRRemarks').value = obj.title;
	document.getElementById('txtPRRemarks').select();
}

function AddRemarksToCell(obj,evt)
{
	if(evt.keyCode==13)
	{
		var rw 			= public.parentNode;
		var itemDesc 	= rw.cells[1].id;
		var title 	 	= obj.value.trim().toUpperCase();		

		public.childNodes[0].nodeValue = itemDesc+"-"+title;
		
		public.title = title;		
		ClosePRPopUp('popupLayer1')
	}
}

function SaveAndConfirmSecondApproval()
{
	showBackGround('divBG',0);
	if(!Validate_SaveAndConfirmSecondApproval()){
		hideBackGround('divBG');
		return;
	}
	
	var reason = prompt("Are you sure you want to approve this PR.\nPlease mention the reason for changes.")
	if(reason==null){
		hideBackGround('divBG');
		return;
	}
	if(reason=="")
	{
		alert("Cannot proceed without a reason.");
		hideBackGround('divBG');
		return;
	}


	var tblMain = document.getElementById('tblItemMain');
	var tblGlMain = document.getElementById('tblGlMain');
		
	SaveDetails(tblMain);
	SaveGLDetails(tblGlMain);
	SaveAndConfirmSecondApproval_header(reason);
	alert("Approved successfully.");
	ValidateButtons(3);
	hideBackGround('divBG');
}

function Validate_SaveAndConfirmSecondApproval()
{
var tblGlMain	= document.getElementById('tblGlMain');

	for(i=1;i<tblGlMain.rows.length;i++)
	{
		var url  = "purchaserequisitionxml.php?RequestType=URLValidate_SaveAndConfirmSecondApproval";
			url += "&SerialNo="+pub_serialNo;
			url += "&SerialYear="+pub_serialYear;
			url += "&GLAlloId="+tblGlMain.rows[i].cells[g_des].id;
			url += "&CurrentBudget="+tblGlMain.rows[i].cells[g_currB].childNodes[0].nodeValue;
		var htmlobj=$.ajax({url:url,async:false});
		var XMLBooStatus	= htmlobj.responseXML.getElementsByTagName('BooStatus')[0].childNodes[0].nodeValue;
		var XMLAlert		= htmlobj.responseXML.getElementsByTagName('Alert')[0].childNodes[0].nodeValue;
		if(XMLBooStatus=='false')
		{
			alert(XMLAlert);
			return false;
		}
	}
return true;
}

function SaveAndConfirmSecondApproval_header(changeReason)
{
	var url  = "purchaserequisitiondb.php?RequestType=URLSaveAndConfirmSecondApproval_header";
		url += "&SerialNo="+pub_serialNo;
		url += "&SerialYear="+pub_serialYear;
		url += "&SupplierId="+document.getElementById('cboSupplier').value;
		url += "&CurrencyId="+document.getElementById('cboCurrencyId').value;
		url += "&CurrRate="+document.getElementById('txtExRate').value;
		url += "&DeptId="+document.getElementById('cboDepartment').value;
		url += "&Attension="+URLEncode(document.getElementById('txtAttension').value.trim());
		url += "&Intro="+URLEncode(document.getElementById('txtIntroduction').value.trim());
		url += "&JobNo="+URLEncode(document.getElementById('txtJobNo').value.trim());
		url += "&Discount="+document.getElementById('txtDisPercent').value.trim();
		url += "&TotalValue="+document.getElementById('txtTotalValue').value.trim();
		url += "&TotalPRValue="+document.getElementById('txtPRValue').value.trim();
		url += "&DisValue="+document.getElementById('txtDisValue').value.trim();
		url += "&JobType="+document.getElementById('cboJobType').value;
		url += "&ChangeReason="+changeReason
	htmlobj=$.ajax({url:url,async:false});
}

function loadCommonSupplierDetails(obj)
{
	var url = "purchaserequisitiondb.php?RequestType=URLgetCommonSupplierId";
	htmlobj=$.ajax({url:url,async:false});
	if(htmlobj.responseText == obj.value)
	{
		showBackGround('divBG',0);
		var url = "commonSupplierPopup.php?";
		htmlobj=$.ajax({url:url,async:false});
		drawPopupBox(450,290,'frmPopItem',1);
		 $('#frmPopItem').html(htmlobj.responseText);
		 $('#frmPopItem').css('border','');	
		 $('#frmPopItem').css('background-color','');
		
	}
	else
		commonSupName ='';
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

function addCommonSupplierName()
{
	commonSupName = document.getElementById('txtSupplierName').value;
	if(commonSupName == '')
	{
		alert("Please enter 'Supplier Name'");
		document.getElementById('txtSupplierName').focus();
		return false;
	}
	CloseOSPopUp('popupLayer1');
}

function closeSupplierPopup()
{
	if(commonSupName=='')
		document.getElementById('cboSupplier').value='null'; 
	CloseOSPopUp('popupLayer1');
}