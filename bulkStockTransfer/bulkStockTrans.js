var mainArrayIndex 		= 0;
var Materials 			= [];
var pub_index			= 0;
var pub_mainRw			= 0;
var pub_serialNo 		= 0;
var pub_serialYear 		= 0;
var validateCount		= 0;
var validateBinCount	= 0;

//BEGIN - Main Item Grid Column Variable
var m_del 				= 0 ;	// Delete button
var m_iDec 				= 1 ;	// Item Description
var m_order				= 2	;	// Order No
var m_co				= 3 ;	// Color
var m_size				= 4	;	// Size
var m_un				= 5 ; 	// Unit
var m_st				= 6	;	// Current Stock
var m_adjQty			= 7 ; 	// Adjust Qty
var m_uprice			= 9 ; 	// Unitprice
var m_grnNo				= 10;    // GRN no
var m_grnYear			= 11;   //GRN year
var m_loc				= 12;	// Add Location
var m_orderUprice		= 8;  //specification unit price
var m_poNo				= 13;   //old PO no
var m_poYear			= 14;	//old PO year
var m_forderNo			= 15;	//old order no
//END - Main Item Grid Column Variable

function RemoveItem(obj,index)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		var td 	= obj.parentNode;
		var tro = td.parentNode;
		tro.parentNode.removeChild(tro);	
		Materials[index] = null;	
	}
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
	document.frmStyleStockAdjestment.reset();
	document.getElementById('cboStyleNo').onchange();
	ClearTable('tblMain');
	Materials = [];
	mainArrayIndex 	= 0;
	document.getElementById('cboStyleNo').focus();
	document.getElementById('cboMainCategory').disabled = false;
	document.getElementById('butSave').style.display = 'inline';
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
function OpenItemPopUp()
{
	var styleId 	= document.getElementById('cboOrderNo');
	var mainStore 	= document.getElementById('cboMainCategory');
	var color		= URLEncode(document.getElementById('cboColor').value);
	var size		= URLEncode(document.getElementById('cboSize').value);
	if(!Validate('OpenItemPopUp',styleId,mainStore))
		return;
	if(!IsRatioAvilable(styleId))
		return;
		
	showBackGround('divBG',0);
	var url = "popupitem.php?StyleId="+styleId.value;
	url += "&color="+color;
	url += "&size="+size;
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(566,532,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	fix_header('tblPopItem',550,388);	
}

function SetOrderNo(obj)
{
	document.getElementById('cboOrderNo').value = obj.value;
}

function SetScNo(obj)
{
	document.getElementById('cboScNo').value = obj.value;
}

function LoadSubStore(obj)
{
	var url  = "bulkStockTransdb.php?RequestType=URLLoadSubStore";
		url += "&MSId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboSubCat').innerHTML = htmlobj.responseText;	
}

function LoadOrderDetails(obj)
{
	LoadColor(obj);
	LoadSize(obj);
}

function LoadColor(obj)
{
	var url  = "bulkStockTransdb.php?RequestType=URLColor";
	url += "&StyleId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboColor').innerHTML = htmlobj.responseText;	
}

function LoadSize(obj)
{
	var url  = "bulkStockTransdb.php?RequestType=URLSize";
	url += "&StyleId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboSize').innerHTML = htmlobj.responseText;	
}

function LoadItemToGrid()
{
	var url  = "ostockmiddle.php?RequestType=URLColor";
		url += "&StyleId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});	
	CreateGrid();
}

function Validate(obj0,obj1,obj2,obj3,obj4,obj5,obj6,obj7,obj8,obj9)
{
	if(obj0=='OpenItemPopUp')
	{
		if(obj1.value=="")
		{
			alert("Please select 'Order No'.");
			obj1.focus();
			return false;
		}
		else if(obj2.value=="")
		{
			alert("Please select 'Main Store'.");
			obj2.focus();
			return false;
		}
	}
	if(obj0=='AddBins')
	{
		if(obj1.value=="")
		{
			alert("Please select 'Main Store'.");
			obj1.focus();
			return false;
		}
		if(obj2.value=="")
		{
			alert("Please select 'Sub Store'.");
			obj2.focus();
			return false;
		}
		if(obj3.value=="0")
		{
			alert("'Allocation Qty' should be more than 0.");
			obj3.select();
			return false;
		}
		if(obj4.value=="0")
		{
			alert("'Unitprice' should be more than 0.");
			obj4.select();
			return false;
		}
		if(obj5.value=="0")
		{
			alert("Please enter 'GRN No'.");
			obj5.select();
			return false;
		}
		if(obj6.value=="0")
		{
			alert("Please enter 'GRN Year'.");
			obj6.select();
			return false;
		}
		if(obj7.value=="0")
		{
			alert("Please enter 'PO No'.");
			obj7.select();
			return false;
		}
		if(obj8.value=="0")
		{
			alert("Please enter 'PO Year'.");
			obj8.select();
			return false;
		}
		if(obj9.value=="")
		{
			alert("Please enter 'From Order No'.");
			obj9.select();
			return false;
		}
	}
	if(obj0=="SaveOpenStock")
	{		
		if(obj1.rows.length <=1)
		{
			alert("No details appear to save.");
			return false
		}
		for(loop=1;loop<obj1.rows.length;loop++)
		{
			if (obj1.rows[loop].cells[0].id==0){
				alert ("Cannot save without allocation bin \nPlease allocate the bin in Line No : " + [loop] +".");
				return false;				
			}	
		}
	}
return true;
}

function LoadPopItems()
{
	/*if(ev.KeyCode!='13')
		return;*/
	var url  = "bulkStockTransdb.php?RequestType=URLLoadPopItems";
		url += "&StyleId="+document.getElementById('cboOrderNo').value;
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
	ClearTable('tblPopItem');
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
	var tblMain = document.getElementById('tblMain');
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			var url  = "bulkStockTransdb.php?RequestType=URLAddToMainPage";
				url += "&StyleId="+document.getElementById('cboOrderNo').value;
				url += "&MatId="+tbl.rows[loop].cells[1].id;
				url += "&MainStore="+document.getElementById('cboMainCategory').value;
				url += "&Color="+URLEncode(document.getElementById('cboColor').value);
				url += "&Size="+URLEncode(document.getElementById('cboSize').value);
			htmlobj=$.ajax({url:url,async:false});
			var XMLOrderId = htmlobj.responseXML.getElementsByTagName("OrderId");
			for(i=0;i<XMLOrderId.length;i++)
			{
				var orderId 	= htmlobj.responseXML.getElementsByTagName("OrderId")[i].childNodes[0].nodeValue;
				var orderNo 	= htmlobj.responseXML.getElementsByTagName("OrderNo")[i].childNodes[0].nodeValue;
				var matId 		= htmlobj.responseXML.getElementsByTagName("MatId")[i].childNodes[0].nodeValue;
				var itemDesc 	= htmlobj.responseXML.getElementsByTagName("ItemDesc")[i].childNodes[0].nodeValue;
				var units 		= htmlobj.responseXML.getElementsByTagName("Unit")[i].childNodes[0].nodeValue;
				var color 		= htmlobj.responseXML.getElementsByTagName("Color")[i].childNodes[0].nodeValue;
				var size 		= htmlobj.responseXML.getElementsByTagName("Size")[i].childNodes[0].nodeValue;
				var stockBal 	= htmlobj.responseXML.getElementsByTagName("StockBal")[i].childNodes[0].nodeValue;
				var subCatId 	= htmlobj.responseXML.getElementsByTagName("SubCatId")[i].childNodes[0].nodeValue;
				var unitprice   = htmlobj.responseXML.getElementsByTagName("unitPrice")[i].childNodes[0].nodeValue;
				
				CreadeMainGrid(tblMain,orderId,orderNo,matId,itemDesc,units,color,size,stockBal,subCatId,unitprice);
			}
		}
	}
	CloseOSPopUp('popupLayer1');
	document.getElementById('cboMainCategory').disabled = true;
}

function CreadeMainGrid(tbl,orderId,orderNo,matId,itemDesc,units,color,size,stockBal,subCatId,unitprice)
{
	var booCheck = true;
	for(mainLoop=1;mainLoop<tbl.rows.length;mainLoop++)
	{
		var mainMatId 	= tbl.rows[mainLoop].cells[m_iDec].id;
		var mainOrderId = tbl.rows[mainLoop].cells[m_order].id;
		var mainColor 	= tbl.rows[mainLoop].cells[m_co].childNodes[0].nodeValue;
		var mainSize 	= tbl.rows[mainLoop].cells[m_size].childNodes[0].nodeValue;
		
		if(mainMatId==matId && mainOrderId==orderId && mainColor==color && mainSize==size)
			booCheck = false;			
	}
	if(booCheck)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className 	= "bcgcolor-tblrowWhite";
		
		var cell 		= row.insertCell(m_del);
		cell.className 	= "normalfntMid";
		cell.setAttribute('height','20');
		cell.id			= 0;
		cell.innerHTML 	= "<img alt=\"add\" src=\"../images/del.png\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" >";
		
		var cell 		= row.insertCell(m_iDec);
		cell.className 	= "normalfnt";
		cell.id 		= matId;
		cell.innerHTML 	= itemDesc;
		
		var cell 		= row.insertCell(m_order);
		cell.className 	= "normalfnt";
		cell.id			= orderId
		cell.innerHTML 	= orderNo;
		
		var cell 		= row.insertCell(m_co);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= color;
		
		var cell 		= row.insertCell(m_size);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= size;
		
		var cell 		= row.insertCell(m_un);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= units;
		
		var cell 		= row.insertCell(m_st);
		cell.className 	= "normalfntRite";
		cell.innerHTML 	= stockBal;
		
		var cell 		= row.insertCell(m_adjQty);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 70px; text-align: right;\" class=\"txtbox\"  value=\"0\" onkeyup=\"SetQtyToArray(this,"+mainArrayIndex+");\">";
		
		var cell 		= row.insertCell(m_orderUprice);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= unitprice;
		
		var cell 		= row.insertCell(m_uprice);
		cell.className 	= "normalfnt";
		cell.id			= unitprice;
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 70px; text-align: right;\" class=\"txtbox\"  value=\""+unitprice+"\" onkeyup=\"validateUnitprice(this,"+mainArrayIndex+");\">";
		
		var cell 		= row.insertCell(m_grnNo);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 75px; text-align: right;\" class=\"txtbox\"  value=\"0\" onkeyup=\"SetDetailsToArray(this,"+mainArrayIndex+");\">";
		
		var cell 		= row.insertCell(m_grnYear);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 35px; text-align: right;\" class=\"txtbox\"  value=\"0\" onkeyup=\"SetDetailsToArray(this,"+mainArrayIndex+");\">";
	
		var cell 		= row.insertCell(m_loc);
		cell.className 	= "normalfntMid";
		cell.innerHTML 	= "<img alt=\"add\" src=\"../images/plus_16.png\" onclick=\"AddBins(this," + mainArrayIndex  + ")\">";
		
		var cell 		= row.insertCell(m_poNo);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 75px; text-align: right;\" class=\"txtbox\"  value=\"0\" onkeyup=\"SetDetailsToArray(this,"+mainArrayIndex+");\">";
		
		var cell 		= row.insertCell(m_poYear);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width:35px; text-align: right;\" class=\"txtbox\"  value=\"0\" onkeyup=\"SetDetailsToArray(this,"+mainArrayIndex+");\">";
		
		var cell 		= row.insertCell(m_forderNo);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" style=\"width: 100px;\" class=\"txtbox\" onkeyup=\"SetDetailsToArray(this,"+mainArrayIndex+");\">";
		
		var details = [];
		details[0] = matId; 	// Matdetail Id
		details[1] = orderId; 	// Oreder Id
		details[2] = color ;	// Color
		details[3] = size; 		// Size
		details[4] = units; 	// Unit
		details[6] = 0; 		// Adjust Qty
		details[7] = unitprice; 		//Unitprice
		details[8] = '#Main Ratio#'; 		//Buyer PoNo
		details[9] = subCatId; 		//subcategory id
		details[10] = 0;   // GRN no 
		details[11] = 0; //GRN year
		details[12] = 0;   // PO no 
		details[13] = 0;   // PO year 
		details[14] = 0;   // from order no 
		
		Materials[mainArrayIndex] = details;
		mainArrayIndex ++ ;
	}
}

function SetQtyToArray(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var adjustQty 		= parseFloat(obj.value);
	var stockQty		= parseFloat(rw.cells[m_st].childNodes[0].nodeValue);
	
	if(adjustQty>stockQty)
		{
			obj.value 	= stockQty;
			adjustQty	= stockQty;
		}
	Materials[index][6] = adjustQty;
	rw.cells[m_del].id 	= 0;
	rw.className 		= "bcgcolor-tblrowWhite";
}

function validateUnitprice(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var unitprice 		= parseFloat(obj.value);
	var spUnitprice 	= parseFloat(rw.cells[m_uprice].id);
	
	if(unitprice>spUnitprice)
	{
		obj.value 	= spUnitprice;
		unitprice	= spUnitprice;
	}
	
	Materials[index][7] = unitprice;
	rw.cells[m_del].id 	= 0;
	rw.className 		= "bcgcolor-tblrowWhite";
}

function SetDetailsToArray(obj,index)
{
	var rw 			= obj.parentNode.parentNode;
	var grnNo 		= rw.cells[m_grnNo].childNodes[0].value;
	var grnYear		= rw.cells[m_grnYear].childNodes[0].value;
	var poNo		= rw.cells[m_poNo].childNodes[0].value;
	var poYear		= rw.cells[m_poYear].childNodes[0].value;
	var orderNo		= rw.cells[m_forderNo].childNodes[0].value;
	
	Materials[index][10] = grnNo;
	Materials[index][11] = grnYear;
	Materials[index][12] = poNo;
	Materials[index][13] = poYear;
	Materials[index][14] = orderNo;
	rw.cells[m_del].id 	= 0;
	rw.className 		= "bcgcolor-tblrowWhite";
}
function SetMarkToArray(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var adjustQty 		= parseFloat(rw.cells[m_adjQty].childNodes[0].value);
	var stockQty		= parseFloat(rw.cells[m_st].childNodes[0].nodeValue);
	var adjMark			= rw.cells[m_adj].childNodes[0].value;
	if(adjMark=='-')
	{
		if(adjustQty>stockQty)
		{
			rw.cells[m_adjQty].childNodes[0].value 	= stockQty;
		}
	}
	Materials[index][7] = obj.value;
	rw.cells[m_del].id 	= 0;
	rw.className 		= "bcgcolor-tblrowWhite";
}

function AddBins(obj,index)
{
	var rw 			= obj.parentNode.parentNode;
	pub_index		= index;
	pub_mainRw 		= obj.parentNode.parentNode.rowIndex;
	var mainStore	= document.getElementById('cboMainCategory');
	var subStore	= document.getElementById('cboSubCat');
	var orderId		= rw.cells[m_order].id;
	var matId		= rw.cells[m_iDec].id;
	var size		= rw.cells[m_size].childNodes[0].nodeValue;
	var color		= rw.cells[m_co].childNodes[0].nodeValue;
	var adjestQty	= rw.cells[m_adjQty].childNodes[0];
	var unitprice	= rw.cells[m_uprice].childNodes[0];
	var grnNo		= rw.cells[m_grnNo].childNodes[0];
	var grnYear		= rw.cells[m_grnYear].childNodes[0];
	var poNo		= rw.cells[m_poNo].childNodes[0];
	var poYear		= rw.cells[m_poYear].childNodes[0];
	var forderNo	= rw.cells[m_forderNo].childNodes[0];
	
	if(!Validate('AddBins',mainStore,subStore,adjestQty,unitprice,grnNo,grnYear,poNo,poYear,forderNo))
		return;
		
	showBackGround('divBG',0);
	var url  = "popupbin.php?StyleId="+orderId;
		url += "&MainStore="+mainStore.value;
		url += "&SubStore="+subStore.value;
		url += "&StyleId="+orderId;
		url += "&MatId="+matId;
		url += "&Color="+URLEncode(color);
		url += "&Size="+URLEncode(size);
		url += "&AdjustQty="+adjestQty.value;
		//url += "&AdjestM="+URLEncode(unitprice);
 	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(650,250,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	fix_header('tblPopItem',550,388);	
}

function SetBinItemQuantity(obj)
{	
	var tblMain =document.getElementById("tblMain");				
	var tblBin = document.getElementById('tblBinItem');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPLoopQty = 0;	
	
	for (loop =1; loop < tblBin.rows.length; loop++)
	{
		if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){		
				GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value);
		}	
	}
	
	if (GPLoopQty == totReqQty ){	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 1 ;loop < tblBin.rows.length ; loop ++ ){
				if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){					
						var Bindetails = [];
							Bindetails[0] =   parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value); // issueQty
							Bindetails[1] =   tblBin.rows[loop].cells[5].id; // MainStores
							Bindetails[2] =   tblBin.rows[loop].cells[6].id;// SubStores
							Bindetails[3] =   tblBin.rows[loop].cells[4].id; // Location
							Bindetails[4] =   tblBin.rows[loop].cells[3].id; // BinId							
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;						
				}
			}
		Materials[pub_index][5] = BinMaterials;				
		tblMain.rows[pub_mainRw].className = "bcgcolor-tblrowLiteBlue";
		tblMain.rows[pub_mainRw].cells[0].id = 1;
		CloseOSPopUp('popupLayer1');
	}
	else{
		alert ("Allocated qty must equal with Issue Qty. \nIssue Qty =" + totReqQty + "\nAllocated Qty =" + GPLoopQty +"\nVariance is =" +(totReqQty-GPLoopQty));
		return false;
	}	
}

function SaveOpenStock()
{
	document.getElementById('butSave').style.display = 'none';
	var no 	= document.getElementById('txtSerialNo');
	var tbl = document.getElementById('tblMain');
	if(!Validate('SaveOpenStock',tbl))
	{
		document.getElementById('butSave').style.display = 'inline';
		return;
	}
	
	if(no.value=="")
	{
		GetNewSerialNo();
		SaveHeader();
		SaveDetails()
	}
	else
	{
		no 				= no.value.split("/");
		pub_serialNo 	= parseInt(no[1]);
		pub_serialYear 	= parseInt(no[0]);
		//SaveHeader();
		SaveDetails()
	}
	alert("Saved successfully.");
	ClearForm();
}

function GetNewSerialNo()
{
	var url  = "bulkStockTransdb.php?RequestType=URLGetNewSerialNo";
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLAdmin	= htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
	if(XMLAdmin=="TRUE")
	{
		var XMLNo 		= htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
		var XMLYear 	= htmlobj.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
		pub_serialNo 	= parseInt(XMLNo);
		pub_serialYear 	= parseInt(XMLYear);
		document.getElementById("txtSerialNo").value = pub_serialYear + "/" + pub_serialNo;			
	}
	else
	{
		alert("Please contact system administrator to assign new Return No.");
	}
}

function SaveHeader()
{
	var url  = "bulkStockTransdb.php?RequestType=URLSaveHeader";
	    url += "&SerialNo="+pub_serialNo;
		url += "&SerialYear="+pub_serialYear;
	htmlobj=$.ajax({url:url,async:false});
}

function SaveDetails()
{
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{	
		var details = Materials[loop] ;
		if 	(details!=null)
		{			
			var matId 		= details[0]; 	// Matdetail Id
			var orderId		= details[1]; 	// Oreder Id
			var color		= details[2];	// Color
			var size		= details[3]; 	// Size
			var units		= details[4];	// Unit
			var binArray 	= details[5];	
			var qty			= details[6]; 	// Adjust Qty
			var unitprice	= details[7]; 	//Unitprice
			var buyerPoNo	= details[8];	// BuyerPoNo
			var subCatId	= details[9];	//SubCatId
			var grnNo		= details[10]; //GRN no
			var grnYear		= details[11]; //GRN Year
			var poNo		= details[12]; //PO no
			var poYear		= details[13]; //PO Year
			var forderNo	= details[14]; //from order no
			validateCount++;
			
	var url = 'bulkStockTransdb.php?RequestType=URLSaveDetails&SerialNo=' +pub_serialNo+ '&SerialYear=' +pub_serialYear+ '&StyleID=' +URLEncode(orderId)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ '&ItemDetailId=' +matId+ '&Color=' +URLEncode(color)+ '&Size=' +URLEncode(size)+ '&Units=' +URLEncode(units)+ '&Qty=' +qty+ '&unitprice=' +unitprice+'&grnNo='+grnNo+'&grnYear='+grnYear+'&poNo='+poNo+'&poYear='+poYear+'&forderNo='+forderNo;
	
	var htmlobj=$.ajax({url:url,async:false});
			
			//try{
				//if(pub_commonBin==0 && mainStore !='')
				//{
					for (i = 0; i < binArray.length; i++)
					{
						var Bindetails 		= binArray[i];
						var binQty 			= Bindetails[0];  // issueQty
						var mainStoreId		= Bindetails[1];  // MainStores
						var subStoreId		= Bindetails[2];  // SubStores
						var locationId		= Bindetails[3];  // Location
						var binId			= Bindetails[4];  // BinId							
						validateBinCount++;
					
						var url='bulkStockTransdb.php?RequestType=URLSaveBinDetails&SerialNo=' +pub_serialNo+ '&SerialYear=' +pub_serialYear+ '&StyleID=' +URLEncode(orderId)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ '&ItemDetailId=' +matId+ '&Color=' +URLEncode(color)+ '&Size=' +URLEncode(size)+ '&Units=' +URLEncode(units)+ '&BinQty=' +binQty+ '&MSId=' +mainStoreId+ '&SSId=' +subStoreId+ '&LocId=' +locationId+ '&BinId=' +binId+ '&SubCatId='+subCatId+'&grnNo='+grnNo+'&grnYear='+grnYear;
						var htmlobj=$.ajax({url:url,async:false});
						
					}
				//}
				//else
				//{
					//validateBinCount++;
					//var url ='ostockmiddle.php?RequestType=URLSaveBinDetails&returnNo=' +pub_returnNo+ '&returnYear=' +pub_returnYear+ '&StyleID=' +URLEncode(StyleID)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&binQty=' +qty+ '&mainStoreId=' +pub_mainStoreID+ '&subStoreId=' +pub_subStoreID+ '&subCatID=' +subCatID+ '&commonBin=' +pub_commonBin+'&grnNo='+grnNo;
					
					//var htmlobj=$.ajax({url:url,async:false});
				//}
		/*	}
			catch(err)
			{
			}*/
		}
	}
}

function GetStockQty(objbin)
{
	var tbl = document.getElementById('tblBinItem');
	var rw = objbin.parentNode.parentNode.parentNode;
	
	if (rw.cells[2].childNodes[0].childNodes[1].checked){
	
	    totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
		var reqQty = parseFloat(rw.cells[0].lastChild.nodeValue);
		var issueQty = rw.cells[1].childNodes[0].value;
		rw.cells[1].childNodes[0].value = 0;
		var issueLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ ){
				if (tbl.rows[loop].cells[2].childNodes[0].childNodes[1].checked){		
						issueLoopQty +=  parseFloat(tbl.rows[loop].cells[1].childNodes[0].value);
					}				
			}		
				var reduceQty = parseFloat(totReqQty) - parseFloat(issueLoopQty) ;

					if (reqQty <= reduceQty ){
						rw.cells[1].childNodes[0].value = reqQty ;
					}
					else{
						 rw.cells[1].childNodes[0].value = reduceQty;
					}					
	}	
	else 
		rw.cells[1].childNodes[0].value = 0;
}

function LoadOrderAndSc(obj)
{
	var url  = "bulkStockTransdb.php?RequestType=URLLoadOrderAndScNo";
		url += "&StyleNo="+URLEncode(obj.value);
		url += "&Status="+11;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboOrderNo').innerHTML = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	document.getElementById('cboScNo').innerHTML = htmlobj.responseXML.getElementsByTagName("ScNo")[0].childNodes[0].nodeValue;
}

function IsRatioAvilable(styleId)
{
	var url  = "bulkStockTransdb.php?RequestType=URLIsRatioAvilable";
		url += "&StyleNo="+styleId.value;
	htmlobj=$.ajax({url:url,async:false});	
	var XMLCheck = htmlobj.responseXML.getElementsByTagName("Available")[0].childNodes[0].nodeValue;
	if(XMLCheck=='false')
	{
		alert("Sorry.\nNo style ratio available for selected 'Order No'");
		styleId.focus();
		return false;
	}
return true;
}

function LoadSubCat(obj)
{
	var url  = "bulkStockTransdb.php?RequestType=loadSubcategoryDetails";
		url += "&mainStoreID="+obj.value;
		url += "&styleId="+document.getElementById('cboOrderNo').value;
	htmlobj=$.ajax({url:url,async:false});	
	
	document.getElementById('cboPopSubCat').innerHTML = htmlobj.responseXML.getElementsByTagName("subCat")[0].childNodes[0].nodeValue;
}