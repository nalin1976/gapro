var mainArrayIndex 		= 0  ;
var Materials 			= [] ;
var pub_index			= 0  ;
var pub_mainRw 			= 0  ;
var validateCount		= 0  ;
var validateBinCount	= 0  ;
//BEGIN - Main Item Grid Column Variable
var m_del 				= 0  ;	// Delete button
var m_iDec 				= 1  ;	// Item Description
var m_order				= 2	 ;	// Order No
var m_bupo				= 3  ;	// Buyer PoNo
var m_co				= 4  ;	// Color
var m_size				= 5	 ;	// Size
var m_un				= 6  ; 	// Unit
var m_st				= 7	 ;	// Current Stock
var m_adjQty			= 8  ;  // Adjust Qty
var m_loc				= 9	 ;	// Add Location
var m_grnno				= 10 ;	// GRN No
var m_grntype			= 11 ;	// GRN Type
//END - Main Item Grid Column Variable

//BEGIN - Define Popup table columns id
var p_chkBox 			= 0  ;
var p_mc				= 1  ;
var p_sc				= 2  ;
var p_itemDe			= 3  ;
//var p_buerpo			= 4  ;
var p_color				= 4  ;
var p_size				= 5	 ;
var p_unit				= 6	 ;
var p_stockBal			= 7	 ;
var p_grnno				= 8	 ;	// GRN No
//END - Define Popup table columns id

function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}

function CloseIWLOItem(LayerId)
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

function LoadSubStore(obj)
{
	var url  = "frmBulkItemWiseLeftOverxml.php?RequestType=URLLoadSubStore";
		url += "&MSId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboSubStore').innerHTML = htmlobj.responseText;	
}

function OpenItemPopUp()
{
	var mainStore	= document.getElementById('cboMainStore');
	var subStore	= document.getElementById('cboSubStore');
	if(!ValidateOpenItemPopUp(mainStore,subStore))
		return;
		
	showBackGround('divBG',0);
	var url  = "bulkpopupitem.php?";
		url += "MainStore="+mainStore.value;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(850,400,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	fix_header('tblPopItem',850,388);
	var tblPopup = document.getElementById('tblPopItem');
	if(tblPopup.rows.length<=1){
		alert("Sorry!\nNo Records found in selected options.")
		CloseIWLOItem('popupLayer1');
	}
	
}

function ValidateOpenItemPopUp(mainStore,subStore)
{
	if(mainStore.value=="")
	{
		alert("Please select the 'Main Store'.");
		mainStore.focus();
		return false;
	}
	if(subStore.value=="")
	{
		alert("Please select the 'Sub Store'.");
		subStore.focus();
		return false;
	}
	return true;
}

function EnterLoadPopItems(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;

	if (charCode == 13)
		LoadPopItems();
}
function EnterLoadPopItems(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;

	if (charCode == 13)
		LoadPopItems();
}
function LoadPopItems()
{	
	var url  = "frmBulkItemWiseLeftOverxml.php?RequestType=URLLoadPopItems";
		url += "&MainCat="+document.getElementById('cboPopMainCat').value;
		url += "&SubCat="+document.getElementById('cboPopSubCat').value;
		url += "&ItemDesc="+URLEncode(document.getElementById('txtDesc').value.trim());
		url += "&MainStore="+document.getElementById('cboMainStore').value;
	htmlobj=$.ajax({url:url,async:false});
	ResponseCreatePopUpItemGrid(htmlobj);
}

function ResponseCreatePopUpItemGrid(htmlobj)
{
	var XMLMainCatID 	= htmlobj.responseXML.getElementsByTagName("MainCatID");
	var tbl 		= document.getElementById('tblPopItem');
	ClearTable('tblPopItem');
	for(loop=0;loop<XMLMainCatID.length;loop++)
	{
		var mainCatID 	= htmlobj.responseXML.getElementsByTagName("MainCatID")[loop].childNodes[0].nodeValue;
		var mainDesc 	= htmlobj.responseXML.getElementsByTagName("Description")[loop].childNodes[0].nodeValue;
		var subCatId 	= htmlobj.responseXML.getElementsByTagName("SubCatID")[loop].childNodes[0].nodeValue;
		var subDesc 	= htmlobj.responseXML.getElementsByTagName("CatName")[loop].childNodes[0].nodeValue;
		var matId 		= htmlobj.responseXML.getElementsByTagName("MatDetailId")[loop].childNodes[0].nodeValue;
		var itemDesc 	= htmlobj.responseXML.getElementsByTagName("ItemDescription")[loop].childNodes[0].nodeValue;
		var color 		= htmlobj.responseXML.getElementsByTagName("Color")[loop].childNodes[0].nodeValue;
		var size 		= htmlobj.responseXML.getElementsByTagName("Size")[loop].childNodes[0].nodeValue;
		var unit 		= htmlobj.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
		var stockBal 	= htmlobj.responseXML.getElementsByTagName("StockBal")[loop].childNodes[0].nodeValue;
		var grnYear 	= htmlobj.responseXML.getElementsByTagName("GrnYear")[loop].childNodes[0].nodeValue;
		var grnNo 		= htmlobj.responseXML.getElementsByTagName("GrnNo")[loop].childNodes[0].nodeValue;

		CreatePopUpItemGrid(mainCatID,mainDesc,subCatId,subDesc,matId,itemDesc,color,size,unit,stockBal,grnYear,grnNo);
	}
}

function CreatePopUpItemGrid(mainCatID,mainDesc,subCatId,subDesc,matId,itemDesc,color,size,unit,stockBal,grnYear,grnNo)
{
	var tbl = document.getElementById('tblPopItem');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
		
	var cell 		= row.insertCell(p_chkBox);
	cell.className 	= "normalfntMid";
	cell.id 		= mainCatID;
	cell.innerHTML 	= "<input name=\"checkbox\" type=\"checkbox\" />";
	
	var cell 		= row.insertCell(p_mc);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= mainDesc;
	
	var cell 		= row.insertCell(p_sc);
	cell.className 	= "normalfnt";
	cell.id 		= subCatId;
	cell.innerHTML 	= subDesc;
	
	var cell 		= row.insertCell(p_itemDe);
	cell.className 	= "normalfnt";
	cell.id 		= matId;
	cell.innerHTML 	= itemDesc;

	var cell 		= row.insertCell(p_color);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= color;
	
	var cell 		= row.insertCell(p_size);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= size;
	
	var cell 		= row.insertCell(p_unit);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= unit;
	
	var cell 		= row.insertCell(p_stockBal);
	cell.className 	= "normalfntRite";
	cell.innerHTML 	= stockBal;
	
	var cell 		= row.insertCell(p_grnno);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= grnYear+'/'+grnNo;
}

function LoadSubCat(styleID)
{
	var mainCat = document.getElementById('cboPopMainCat').value;
	var url = "frmBulkItemWiseLeftOverxml.php?RequestType=URLloadPopupSubCategory&mainCat="+mainCat;
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboPopSubCat').innerHTML = htmlobj.responseText;
}