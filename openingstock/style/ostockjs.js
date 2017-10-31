var mainArrayIndex 		= 0;
var Materials 			= [];
var pub_index			= 0;
var pub_mainRw			= 0;
var pub_serialNo 		= 0;
var pub_serialYear 		= 0;
var validateCount		= 0;
var validateBinCount	= 0;
var pubTotReturnQty		= 0;
var pub_matNo = 0;
//BEGIN - Main Item Grid Column Variable
var m_del 				= 0 ;	// Delete button
var m_iDec 				= 1 ;	// Item Description
var m_un				= 2 ; 	// Unit
var m_unPrice			= 3 ;   //unitprice
var m_stockQty			= 4 ;  // Stock Qty
var m_adjQty			= 5 ; 	// Adjust Qty
var m_adj				= 6 ; 	// Adjust Mark
var m_loc				= 7	;	// Add Location

//END - Main Item Grid Column Variable
function CloseBPPopupBox(index)
{
	try
	{
		var box = document.getElementById('popupLayer' + index);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}

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
	//document.getElementById('cboStyleNo').onchange();
	ClearTable('tblMain');
	Materials = [];
	mainArrayIndex 	= 0;
	//document.getElementById('cboStyleNo').focus();
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
	//var styleId 	= document.getElementById('cboOrderNo');
	var mainStore 	= document.getElementById('cboMainCategory');

if(!Validate('OpenItemPopUp',mainStore))
		return;
	//if(!IsRatioAvilable(styleId))
	//	return;
		
	showBackGround('divBG',0);
	var url = "popupitem.php";
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
	var url  = "ostockmiddle.php?RequestType=URLLoadSubStore";
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
	var url  = "ostockmiddle.php?RequestType=URLColor";
	url += "&StyleId="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboColor').innerHTML = htmlobj.responseText;	
}

function LoadSize(obj)
{
	var url  = "ostockmiddle.php?RequestType=URLSize";
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

function Validate(obj0,obj1,obj2,obj3,obj4,obj5)
{
	if(obj0=='OpenItemPopUp')
	{
		if(obj1.value=="")
		{
			alert("Please select 'Main Store'.");
			obj1.focus();
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
			alert("'Adjust Qty' should be more than 0.");
			obj3.select();
			return false;
		}
		if(obj4.value=="0" && obj5=='+')
		{
			alert("Please enter 'Unitprice'.");
			obj4.select();
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
function LoadSubCat(mainCatId)
{
	var url = "ostockmiddle.php?RequestType=URLLoadSubCat&mainCatId="+mainCatId;
	htmlobj = $.ajax({url:url,async:false});
	var XMLSubcatName = htmlobj.responseText;
	document.getElementById('cboPopSubCat').innerHTML = XMLSubcatName;
}
function LoadPopItems()
{
	var url  = "ostockmiddle.php?RequestType=URLLoadPopItems";
		url += "&MainCat="+document.getElementById('cboPopMainCat').value;
		url += "&SubCat="+document.getElementById('cboPopSubCat').value;
		url += "&ItemDesc="+URLEncode(document.getElementById('txtDesc').value.trim());
		url += "&ItemCode="+URLEncode(document.getElementById('txtItemCode').value.trim());
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

function ShowBulkPurchaseRatio(objRatio)
{
	pub_matNo = objRatio.parentNode.parentNode.parentNode.parentNode.rowIndex;
	showBulkPurchaseRatioWindow();
}
	
function showBulkPurchaseRatioWindow()
{		
	var url="bulkPurchaseRatio.php";
	htmlobj=$.ajax({url:url,async:false});
	var HTMLText=htmlobj.responseText;
	drawPopupBox(500,513,'frmColorSize',2);
	document.getElementById('frmColorSize').innerHTML=HTMLText;
	//LoadBuyersBulk();
		
}
function MoveColorRight()
{
	var colors = document.getElementById("cbocolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cboselectedcolors"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cboselectedcolors").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveColorLeft()
{
	var colors = document.getElementById("cboselectedcolors");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cbocolors"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cbocolors").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveAllColorsLeft()
{
	var colors = document.getElementById("cbocolors");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cboselectedcolors"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cboselectedcolors").options.add(optColor);
		}
	}
	RemoveCurrentColors();
}

function MoveAllColorsRight()
{
	var colors = document.getElementById("cboselectedcolors");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cbocolors"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cbocolors").options.add(optColor);
		}
	}
	RemoveSelectedColors();
}
function AddColor()
{
	var color = document.getElementById('txtColor').value;	
	var optColor = document.createElement("option");
	optColor.text = color;
	optColor.value = color;
	document.getElementById("cboselectedcolors").options.add(optColor);
	document.getElementById('txtColor').value = '';
}

function AddNewColor()
{
	if (document.getElementById("txtColor").value == "")
	{
		alert("Please enter the color name.");
		document.getElementById("txtColor").focus();
		return ;
	}
	
	var added = false;
	for(var i = 0; i < document.getElementById("cbocolors").options.length ; i++) 
	{
		if ( document.getElementById("cbocolors").options[i].text.toLowerCase() == document.getElementById("txtColor").value.toLowerCase())
		{
			if(!CheckitemAvailability(document.getElementById("txtColor").value,document.getElementById("cboselectedcolors"),false))
			{
				var optColor = document.createElement("option");
				optColor.text = document.getElementById("cbocolors").options[i].text;
				optColor.value = document.getElementById("cbocolors").options[i].text;
				document.getElementById("cboselectedcolors").options.add(optColor);
				document.getElementById("cbocolors").options[i] = null;				
				added =true;
			}					
		}
	}		
	if (!added)
	{
		if(!CheckitemAvailability(document.getElementById("txtColor").value,document.getElementById("cboselectedcolors"),false))
			SaveColor(document.getElementById("txtColor").value);
		else
			alert("The color already exists.");
	}
}	

function AddSize()
{
	var size = document.getElementById('txtSize').value;	
	var optSize = document.createElement("option");
	optSize.text = size;
	optSize.value = size;
	document.getElementById("cboselectedsizes").options.add(optSize);
}

function CheckitemAvailability(itemName, cmb, message)
{
	for(var i = 0; i < cmb.options.length ; i++) 
	{
		if ( cmb.options[i].text.toLowerCase() == itemName.toLowerCase())
		{
			if (message)
				alert("The item " + itemName + " is already exists in the list.");
			return true;			
		}
	}
	return false;
}

function RemoveSelectedColors()
{
	var index = document.getElementById("cboselectedcolors").options.length;
	while(document.getElementById("cboselectedcolors").options.length > 0) 
	{
		index --;
		document.getElementById("cboselectedcolors").options[index] = null;
	}
}

function RemoveSelectedSizes()
{
	var index = document.getElementById("cboselectedsizes").options.length;
	while(document.getElementById("cboselectedsizes").options.length > 0) 
	{
		index --;
		document.getElementById("cboselectedsizes").options[index] = null;
	}
}

function MoveSizeRight()
{
	var colors = document.getElementById("cbosizes");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cboselectedsizes"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cboselectedsizes").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveSizeLeft()
{
	var colors = document.getElementById("cboselectedsizes");
	if(colors.selectedIndex <= -1) return;
	var selectedColor = colors.options[colors.selectedIndex].text;
	if (!CheckitemAvailability(selectedColor,document.getElementById("cbosizes"),true))
	{
		var optColor = document.createElement("option");
		optColor.text = selectedColor;
		optColor.value = selectedColor;
		document.getElementById("cbosizes").options.add(optColor);
		colors.options[colors.selectedIndex] = null;
	}
}

function MoveAllSizesLeft()
{
	var colors = document.getElementById("cbosizes");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cboselectedsizes"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cboselectedsizes").options.add(optColor);
		}
	}
	RemoveCurrentSizes();
}

function MoveAllSizesRight()
{
	var colors = document.getElementById("cboselectedsizes");
	for(var i = 0; i < colors.options.length ; i++) 
	{
		if(!CheckitemAvailability(colors.options[i].text,document.getElementById("cbosizes"),false))
		{
			var optColor = document.createElement("option");
			optColor.text = colors.options[i].text;
			optColor.value = colors.options[i].text;
			document.getElementById("cbosizes").options.add(optColor);
		}
	}
	RemoveSelectedSizes();
}
function isValidColorSizeSelection()
{
	if (document.getElementById("cboselectedcolors").options.length == 0 && document.getElementById("cboselectedsizes").options.length == 0)
	{
		alert ("Please choose your color size ratio.");
		return false;
	}
	return true;
}

function RemoveCurrentColors()
{
	var index = document.getElementById("cbocolors").options.length;
	while(document.getElementById("cbocolors").options.length > 0) 
	{
		index --;
		document.getElementById("cbocolors").options[index] = null;
	}
}
function RemoveCurrentSizes()
{
	var index = document.getElementById("cbosizes").options.length;
	while(document.getElementById("cbosizes").options.length > 0) 
	{
		index --;
		document.getElementById("cbosizes").options[index] = null;
	}
}
function SaveColor(colorName)
{
	/*var buyer = document.getElementById("cboBuyer").value;
	var division = document.getElementById("cboDivision").value;
	
	var url='../bomMiddletire.php?RequestType=AddNewColor&colorName=' + URLEncode(colorName) + '&buyer=' + buyer + '&division=' + division
	htmlobj=$.ajax({url:url,async:false});*/
	
	var optColor = document.createElement("option");
	optColor.text = document.getElementById("txtColor").value;
	optColor.value = document.getElementById("txtColor").value;
	document.getElementById("cboselectedcolors").options.add(optColor);
	document.getElementById("txtColor").value = "";
}
/*function addItemToMainTable()
{
	
var tblMain = document.getElementById("tblMain");
var tblMaterial = document.getElementById("tblPopItem");
var lstColor  = document.getElementById("cboselectedcolors");
var lstSize  = document.getElementById("cboselectedsizes");

var strMain = document.getElementById("cboMainCategory").value;

tblMaterial.rows[pub_matNo].cells[0].innerHTML = "<img  src=\"../../images/ok-mark.png\" alt=\"login\"  class=\"noborderforlink\" />";
	
	if (lstColor.length <= 0)
	{
		var optColor = document.createElement("option");
		optColor.text = "N/A";
		optColor.value = "N/A";
		lstColor.options.add(optColor);
	}
	
	if (lstSize.length <= 0)
	{
		var optSize = document.createElement("option");
		optSize.text = "N/A";
		optSize.value = "N/A";
		lstSize.options.add(optSize);
	}

	var tempText="";
	for(var i = 0; i < lstColor.options.length ; i++) 
	{		
		for(var n = 0; n < lstSize.options.length ; n++) 
		{				
			var color 	 	= lstColor.options[i].text;
			var size 	 	= lstSize.options[n].text;
			var detailId 	= tblMaterial.rows[pub_matNo].cells[3].lastChild.nodeValue;
			var units	 	= tblMaterial.rows[pub_matNo].cells[4].lastChild.nodeValue;
			var description = tblMaterial.rows[pub_matNo].cells[2].lastChild.nodeValue;	
			var detailID 	= tblMaterial.rows[pub_matNo].cells[3].id;
//Start - validation part with main menu			
			var booCheck =false;
			for (var mainLoop =1 ;mainLoop < tblMain.rows.length; mainLoop++ )
			{
				var mainItemDetailId 	= tblMain.rows[mainLoop].cells[1].lastChild.nodeValue;					
				var mainColor 			= tblMain.rows[mainLoop].cells[3].lastChild.nodeValue;
				var mainSize 			= tblMain.rows[mainLoop].cells[4].lastChild.nodeValue;										
				
				if ((mainItemDetailId==detailId) && (mainColor==color) && (mainSize==size))
					{
						booCheck =true;
						alert("Sorry!\nThis Item already added.\nItem description = "+description+"\nColor = "+color+"\nSize = "+size);
					}			
			}
//End - validation part with main menu
			if(booCheck==false)
			{
				var url = "ostockmiddle.php?RequestType=getStockQty&matId="+detailId+"&mainStoresId="+strMain;
				htmlobj = $.ajax({url:url,async:false});
				var XMLStockQty = htmlobj.responseXML.getElementsByTagName("stockQty")[0].childNodes[0].nodeValue;
				var rowCount = tblMain.rows.length;		
				var row = tblMain.insertRow(rowCount);
				row.className = "bcgcolor-tblrowWhite";			
	
				tblMain.rows[rowCount].innerHTML=  "<td class=\"normalfntMid\"><img src=\"../../images/del.png\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" /></td>"+
					"<td class=\"normalfnt\" id=\""+detailID+"\">"+description+"</td>"+
					"<td class=\"normalfntSM\">"+units+"</td>"+
					"<td class=\"normalfntSM\">"+color+"</td>"+
					"<td class=\"normalfntMidSML\">"+size+"</td>"+
					"<td class=\"normalfntRite\"><input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 81px; text-align: right;\" class=\"txtbox\"  value=\"0\" onkeyup=\"SetDetialsToArray(this,"+mainArrayIndex+");\"></td>"+
					"<td class=\"normalfntRite\">"+XMLStockQty+"</td>"+
					"<td class=\"normalfntRite\"><input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 81px; text-align: right;\" class=\"txtbox\"  value=\"0\" onkeyup=\"SetDetialsToArray(this,"+mainArrayIndex+");\"></td>"+
					"<td class=\"normalfntMidSML\"><select class=\"txtbox\" style=\"width:40px\" onchange=\"SetMarkToArray(this,"+mainArrayIndex+");\">"+
							"<option value=\"+\">+</option>"+
							"<option value=\"-\">-</option>"+
						  "</select></td>"+
					"<td class=\"normalfntMidSML\"><img alt=\"add\" src=\"../../images/plus_16.png\" onclick=\"AddBins(this," + mainArrayIndex  + ")\"></td>";
					
					
					var details = [];
		details[0] = detailID; 	// Matdetail Id
		details[1] = XMLStockQty; 	// Unit
		details[2] = units; 	// Unit
		details[3] = 0; 		// Adjust Qty
		details[4] = '+'; 		//Adjust Mark
		details[6] = '#Main Ratio#'; 		//Buyer PoNo
		details[7] = 0; 		//unitprice
		Materials[mainArrayIndex] = details;
		mainArrayIndex ++ ;
			}
		}
	}
	CloseBPPopupBox(2);
}*/

function AddToMainPage()
{
	var tbl 	= document.getElementById('tblPopItem');
	var tblMain = document.getElementById('tblMain');
	var mainStoresId = document.getElementById('cboMainCategory').value;
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
				
				var matId 		= tbl.rows[loop].cells[m_iDec].id;
				var itemDesc 	= tbl.rows[loop].cells[m_iDec].childNodes[0].nodeValue;
				var units 		= tbl.rows[loop].cells[m_un].childNodes[0].nodeValue;
				/*var coLor 	= tbl.rows[loop].cells[m_coLor].childNodes[0].nodeValue;
				var siZe 		= tbl.rows[loop].cells[m_siZe].childNodes[0].nodeValue;*/
				
				var url = "ostockmiddle.php?RequestType=getStockQty&matId="+matId+"&mainStoresId="+mainStoresId;
				htmlobj = $.ajax({url:url,async:false});
				var XMLStockQty = htmlobj.responseXML.getElementsByTagName("stockQty")[0].childNodes[0].nodeValue;
				CreadeMainGrid(tblMain,matId,itemDesc,units,XMLStockQty);
			
		}
	}
	//CloseOSPopUp('popupLayer1');
	document.getElementById('cboMainCategory').disabled = true;
}

function CreadeMainGrid(tbl,matId,itemDesc,units,stockQty)
{
	var booCheck = true;
	for(mainLoop=1;mainLoop<tbl.rows.length;mainLoop++)
	{
		var mainMatId 	= tbl.rows[mainLoop].cells[1].id;
	
		if(mainMatId==matId)
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
		cell.innerHTML 	= "<img alt=\"add\" src=\"../../images/del.png\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" >";
		
		var cell 		= row.insertCell(m_iDec);
		cell.className 	= "normalfnt";
		cell.id 		= matId;
		cell.innerHTML 	= itemDesc;
		
		var cell 		= row.insertCell(m_un);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= units;

		
		var cell 		= row.insertCell(m_unPrice);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 81px; text-align: right;\" class=\"txtbox\"  value=\"0\" onkeyup=\"SetDetialsToArray(this,"+mainArrayIndex+");\">";
		
		var cell 		= row.insertCell(m_stockQty);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= stockQty;
		
		var cell 		= row.insertCell(m_adjQty);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 81px; text-align: right;\" class=\"txtbox\"  value=\"0\" onblur=\"setQty(this,"+mainArrayIndex+")\" onkeyup=\"SetQtyToArray(this,"+mainArrayIndex+");\">";
		
		var cell 		= row.insertCell(m_adj);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<select class=\"txtbox\" style=\"width:40px\" onchange=\"SetMarkToArray(this,"+mainArrayIndex+");\">"+
							"<option value=\"+\">+</option>"+
							"<option value=\"-\">-</option>"+
						  "</select>";
	
		var cell 		= row.insertCell(m_loc);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<img alt=\"add\" src=\"../../images/plus_16.png\" onclick=\"AddBins(this," + mainArrayIndex  + ")\">";
		
		
		var details = [];
		details[0] = matId; 	// Matdetail Id
		details[1] = stockQty; 	// Unit
		details[2] = units; 	// Unit
		details[3] = 0; 		// Adjust Qty
		details[4] = '+'; 		//Adjust Mark
		details[6] = '#Main Ratio#'; 		//Buyer PoNo
		details[7] = 0; 		//unitprice
		Materials[mainArrayIndex] = details;
		mainArrayIndex ++ ;
	}
}

function SetQtyToArray(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var adjustQty 		= parseFloat(obj.value);
	var stockQty		= parseFloat(rw.cells[m_stockQty].childNodes[0].nodeValue);
	var adjMark			= rw.cells[m_adj].childNodes[0].value;
	
	if(adjMark=='-')
	{
		if(adjustQty>stockQty)
		{
			obj.value 	= stockQty;
			adjustQty	= stockQty;
		}
	}
	Materials[index][3] = adjustQty;
	rw.cells[m_del].id 	= 0;
	rw.className 		= "bcgcolor-tblrowWhite";
}
function setQty(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var adjustQty 		= obj.value;
	if(adjustQty=="")
	{
		obj.value 	= 0;
		adjustQty	= 0;
	}
	Materials[index][3] = adjustQty;
	rw.cells[m_del].id 	= 0;
	rw.className 		= "bcgcolor-tblrowWhite";
}

function SetMarkToArray(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var adjustQty 		= parseFloat(rw.cells[m_adjQty].childNodes[0].value);
	var stockQty		= parseFloat(rw.cells[m_stockQty].childNodes[0].nodeValue);
	var adjMark			= rw.cells[m_adj].childNodes[0].value;
	if(adjMark=='-')
	{
		if(adjustQty>stockQty)
		{
			rw.cells[m_adjQty].childNodes[0].value 	= stockQty;
		}
	}
	Materials[index][4] = obj.value;
	rw.cells[m_del].id 	= 0;
	rw.className 		= "bcgcolor-tblrowWhite";
}

function SetDetialsToArray(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var unitprice 		= parseFloat(rw.cells[m_unPrice].childNodes[0].value);
	
	Materials[index][7] = unitprice;
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
	var matId		= rw.cells[m_iDec].id;
	var adjestQty	= rw.cells[m_adjQty].childNodes[0];
	var adjestM		= rw.cells[m_adj].childNodes[0].value;
	var unitprice	= rw.cells[m_unPrice].childNodes[0];
	
	if(!Validate('AddBins',mainStore,subStore,adjestQty,unitprice,adjestM))
		return;
	if(adjestM=='-')
	{	
		showBackGround('divBG',0);
		var url  = "popupbin.php?MatId="+matId;
			url += "&MainStore="+mainStore.value;
			url += "&SubStore="+subStore.value;
			url += "&AdjustQty="+adjestQty.value;
			url += "&AdjestM="+URLEncode(adjestM);
		htmlobj=$.ajax({url:url,async:false});
		drawPopupBox(950,250,'frmPopItem',1);
		document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
		fix_header('tblPopItem',550,388);	
		pubTotReturnQty = parseFloat(adjestQty.value);
	}
	else
	{
		showBackGround('divBG',0);
		var url  = "popupbinplus.php?MatId="+matId;
			url += "&MainStore="+mainStore.value;
			url += "&SubStore="+subStore.value;
			url += "&AdjustQty="+adjestQty.value;
			url += "&AdjestM="+URLEncode(adjestM);
		htmlobj=$.ajax({url:url,async:false});
		drawPopupBox(950,250,'frmPopItem',1);
		document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
		fix_header('tblPopItem',550,388);	
		pubTotReturnQty = parseFloat(adjestQty.value);
	}
}

function SetBinItemQuantity(obj)
{	
	var tblMain =document.getElementById("tblMain");				
	var tblLOBin = document.getElementById('tblLeftOverBinItem');
	var tbBBin = document.getElementById('tblBulkBinItem');
	var tblRBin = document.getElementById('tblRunningBinItem');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPLoopQty = 0;	
	
	for (loop =2; loop < tblLOBin.rows.length; loop++)
	{
		if (tblLOBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){		
				GPLoopQty +=  parseFloat(tblLOBin.rows[loop].cells[1].childNodes[0].value);
		}	
	}
	for (loop2 =2; loop2 < tbBBin.rows.length; loop2++)
	{
		if (tbBBin.rows[loop2].cells[2].childNodes[0].childNodes[1].checked){		
				GPLoopQty +=  parseFloat(tbBBin.rows[loop2].cells[1].childNodes[0].value);
		}	
	}
	for (loop3 =2; loop3 < tblRBin.rows.length; loop3++)
	{
		if (tblRBin.rows[loop3].cells[2].childNodes[0].childNodes[1].checked){		
				GPLoopQty +=  parseFloat(tblRBin.rows[loop3].cells[1].childNodes[0].value);
		}	
	}
	
	if (GPLoopQty == totReqQty ){	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 2 ;loop < tblLOBin.rows.length ; loop ++ ){
				if (tblLOBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){					
						var Bindetails = [];
							Bindetails[0] =   parseFloat(tblLOBin.rows[loop].cells[1].childNodes[0].value); // issueQty
							Bindetails[1] =   tblLOBin.rows[loop].cells[5].id; // MainStores
							Bindetails[2] =   tblLOBin.rows[loop].cells[6].id;// SubStores
							Bindetails[3] =   tblLOBin.rows[loop].cells[4].id; // Location
							Bindetails[4] =   tblLOBin.rows[loop].cells[3].id; // BinId	
							Bindetails[5] =   tblLOBin.rows[loop].cells[7].id; // StyleId	
							Bindetails[6] =   tblLOBin.rows[loop].cells[8].childNodes[0].nodeValue; // Color
							Bindetails[7] =   tblLOBin.rows[loop].cells[9].childNodes[0].nodeValue; // Size
							Bindetails[8] =   tblLOBin.rows[loop].cells[10].childNodes[0].nodeValue; // Unit
							Bindetails[9] =   tblLOBin.rows[loop].cells[11].childNodes[0].nodeValue; // GRN No
							Bindetails[10] =   tblLOBin.rows[loop].cells[12].childNodes[0].nodeValue; // GRN Year	
							Bindetails[11] =   tblLOBin.rows[loop].cells[13].id; // GRN Type	
							Bindetails[12] =   "L"; // Stock Type										
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;						
				}
				
			}
			for ( var loop = 2 ;loop < tbBBin.rows.length ; loop ++ ){
				if (tbBBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){					
						var Bindetails = [];
							Bindetails[0] =   parseFloat(tbBBin.rows[loop].cells[1].childNodes[0].value); // issueQty
							Bindetails[1] =   tbBBin.rows[loop].cells[5].id; // MainStores
							Bindetails[2] =   tbBBin.rows[loop].cells[6].id;// SubStores
							Bindetails[3] =   tbBBin.rows[loop].cells[4].id; // Location
							Bindetails[4] =   tbBBin.rows[loop].cells[3].id; // BinId	
							Bindetails[5] =   0 ; // StyleId	
							Bindetails[6] =   tbBBin.rows[loop].cells[7].childNodes[0].nodeValue; // Color
							Bindetails[7] =   tbBBin.rows[loop].cells[8].childNodes[0].nodeValue; // Size
							Bindetails[8] =   tbBBin.rows[loop].cells[9].childNodes[0].nodeValue; // Unit
							Bindetails[9] =   tbBBin.rows[loop].cells[10].childNodes[0].nodeValue; // GRN No
							Bindetails[10] =   tbBBin.rows[loop].cells[11].childNodes[0].nodeValue; // GRN Year	
							Bindetails[11] =  "B"; // GRN Type	
							Bindetails[12] =  "B"; // Stock Type									
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;						
				}
				
			}
			for ( var loop = 2 ;loop < tblRBin.rows.length ; loop ++ ){
				if (tblRBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){					
						var Bindetails = [];
							Bindetails[0] =   parseFloat(tblRBin.rows[loop].cells[1].childNodes[0].value); // issueQty
							Bindetails[1] =   tblRBin.rows[loop].cells[5].id; // MainStores
							Bindetails[2] =   tblRBin.rows[loop].cells[6].id;// SubStores
							Bindetails[3] =   tblRBin.rows[loop].cells[4].id; // Location
							Bindetails[4] =   tblRBin.rows[loop].cells[3].id; // BinId	
							Bindetails[5] =   tblRBin.rows[loop].cells[7].id;// StyleId	
							Bindetails[6] =   tblRBin.rows[loop].cells[8].childNodes[0].nodeValue; // Color
							Bindetails[7] =   tblRBin.rows[loop].cells[9].childNodes[0].nodeValue; // Size
							Bindetails[8] =   tblRBin.rows[loop].cells[10].childNodes[0].nodeValue; // Unit
							Bindetails[9] =   tblRBin.rows[loop].cells[11].childNodes[0].nodeValue; // GRN No
							Bindetails[10] =  tblRBin.rows[loop].cells[12].childNodes[0].nodeValue; // GRN Year	
							Bindetails[11] =  tblRBin.rows[loop].cells[13].id; // GRN Type	
							Bindetails[12] =  "S"; // Stock Type									
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
function SetPlusBinItemQuantity(obj)
{
	var tblMain   = document.getElementById("tblMain");				
	var tblLOBin  = document.getElementById('tblLeftOverBinItem');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPLoopQty = 0;	
	
	for (loop =2; loop < tblLOBin.rows.length; loop++)
	{
		if (tblLOBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked)
		{	
			if(tblLOBin.rows[loop].cells[8].childNodes[0].value=="")	
			{
				alert("Please selct a color.");
				tblLOBin.rows[loop].cells[8].childNodes[0].focus();
				return;
				
			}
			if(tblLOBin.rows[loop].cells[9].childNodes[0].value=="")
			{
				alert("Please select a size.");
				tblLOBin.rows[loop].cells[9].childNodes[0].focus();
				return;
			}
			if(tblLOBin.rows[loop].cells[7].childNodes[0].value=="")
			{
				alert("Please select a Order No.");
				tblLOBin.rows[loop].cells[7].childNodes[0].focus();
				return;
			}
			GPLoopQty +=  parseFloat(tblLOBin.rows[loop].cells[1].childNodes[0].value);
		}	
	}
	
	if (GPLoopQty == totReqQty )
	{	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 2 ;loop < tblLOBin.rows.length ; loop ++ )
			{
				if (tblLOBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked)
				{					
						var Bindetails = [];
							Bindetails[0] =   parseFloat(tblLOBin.rows[loop].cells[1].childNodes[0].value); // issueQty
							Bindetails[1] =   tblLOBin.rows[loop].cells[5].id; // MainStores
							Bindetails[2] =   tblLOBin.rows[loop].cells[6].id;// SubStores
							Bindetails[3] =   tblLOBin.rows[loop].cells[4].id; // Location
							Bindetails[4] =   tblLOBin.rows[loop].cells[3].id; // BinId	
							Bindetails[5] =   tblLOBin.rows[loop].cells[7].childNodes[0].value; // StyleId	
							Bindetails[6] =   tblLOBin.rows[loop].cells[8].childNodes[0].value; // Color
							Bindetails[7] =   tblLOBin.rows[loop].cells[9].childNodes[0].value; // Size
							Bindetails[8] =   tblLOBin.rows[loop].cells[10].childNodes[0].nodeValue; // Unit
							Bindetails[9] =   tblLOBin.rows[loop].cells[11].childNodes[0].nodeValue; // GRN No
							Bindetails[10] =   tblLOBin.rows[loop].cells[12].childNodes[0].nodeValue; // GRN Year	
							Bindetails[11] =   tblLOBin.rows[loop].cells[13].id; // GRN Type	
							Bindetails[12] =   "L"; // Stock Type										
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;						
				}
			}
		Materials[pub_index][5] = BinMaterials;				
		tblMain.rows[pub_mainRw].className = "bcgcolor-tblrowLiteBlue";
		tblMain.rows[pub_mainRw].cells[0].id = 1;
		CloseOSPopUp('popupLayer1');
	}
	else
	{
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
	if(document.getElementById('radioCut').checked ==true)
	{
	  if(no.value=="")
	  {
		  //alert("ok");
		  GetNewSerialNo();
		  SaveHeader();
		  SaveDetails1();
	  }
  
	  else
	  {
		  no 				= no.value.split("/");
		  pub_serialNo 	= parseInt(no[1]);
		  pub_serialYear 	= parseInt(no[0]);
		  SaveHeader();
		  SaveDetails1();
	  }
	}
	else if(document.getElementById('radioBut').checked ==true)
	{
	  if(no.value=="")
	  {
		  //alert("ok");
		  GetNewSerialNo();
		  SaveHeader();
		  SaveDetails();
	  }
  
	  else
	  {
		  no 				= no.value.split("/");
		  pub_serialNo 	= parseInt(no[1]);
		  pub_serialYear 	= parseInt(no[0]);
		  SaveHeader();
		  SaveDetails();
	  }
	}
	//alert("Saved successfully.");
	ClearForm();
}

function GetNewSerialNo()
{
	var url  = "ostockmiddle.php?RequestType=URLGetNewSerialNo";
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLAdmin	= htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
	var XMLNo 		= htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
	
	if(XMLAdmin=="TRUE" && XMLNo!='')
	{

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
	var url  = "ostockmiddle.php?RequestType=URLSaveHeader";
	    url += "&SerialNo="+pub_serialNo;
		url += "&SerialYear="+pub_serialYear;
	htmlobj=$.ajax({url:url,async:false});
}

function SaveDetails()
{
	var booCheck = true;
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{	
		var details = Materials[loop] ;
		if 	(details!=null)
		{			
			var matId 		= details[0]; 	// Matdetail Id
			var ajMark		= details[4];	//Adjust Mark
			var binArray 	= details[5];	
			var buyerPoNo	= details[6]; 	// buyer PONo
			var unitprice	= details[7]; 	// unitprice
			validateCount++;
			
/*	var url = 'ostockmiddle.php?RequestType=URLSaveDetails&SerialNo=' +pub_serialNo+ '&SerialYear=' +pub_serialYear+ '&StyleID=' +URLEncode(orderId)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ '&ItemDetailId=' +matId+ '&Color=' +URLEncode(color)+ '&Size=' +URLEncode(size)+ '&Units=' +URLEncode(units)+ '&Qty=' +qty+ '&AjMark=' +URLEncode(ajMark)+'&unitprice='+unitprice;
	var htmlobj=$.ajax({url:url,async:false});
			*/
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
						var StyleId			= Bindetails[5];  // StyleId
						var Color			= Bindetails[6];  // Color
						var Size			= Bindetails[7];	  // Size
						var Unit			= Bindetails[8];	  // Unit
						var grnNo			= Bindetails[9];  // GRN No
						var grnYear			= Bindetails[10]; // GRN Year
						var grnType			= Bindetails[11];	  // GRN Type
						var stockType		= Bindetails[12];  // Stock Type						
					
						var url='ostockmiddle.php?RequestType=URLSaveDetails&SerialNo=' +pub_serialNo+ '&SerialYear=' +pub_serialYear+ '&matId=' +URLEncode(matId)+ '&ajMark=' +URLEncode(ajMark)+ '&unitprice=' +unitprice+ '&binQty=' +binQty+ '&mainStoreId=' +mainStoreId+ '&subStoreId=' +subStoreId+ '&locationId=' +locationId+ '&binId=' +binId+ '&StyleId=' +StyleId+ '&Color=' +URLEncode(Color)+ '&Size=' +URLEncode(Size)+ '&Unit=' +URLEncode(Unit)+ '&grnNo=' +grnNo+ '&grnYear='+grnYear+ '&grnType='+grnType+ '&stockType='+stockType+ '&buyerPoNo='+URLEncode(buyerPoNo);
						//alert(url);
						var htmlobj = $.ajax({url:url,async:false});
						
						if(htmlobj.responseText=="Error")
						{
							booCheck = false;	
						}
						
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
	if(booCheck)
	{
		alert("Saved successfully.");
	}
	else
	{
		alert("Error in saving.");
	}
}
function SaveDetails1()
{
	var booCheck = true;
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{	
		var details = Materials[loop] ;
		if 	(details!=null)
		{			
			var matId 		= details[0]; 	// Matdetail Id
			var ajMark		= details[4];	//Adjust Mark
			var binArray 	= details[5];	
			var buyerPoNo	= details[6]; 	// buyer PONo
			var unitprice	= details[7]; 	// unitprice
			validateCount++;
			
/*	var url = 'ostockmiddle.php?RequestType=URLSaveDetails&SerialNo=' +pub_serialNo+ '&SerialYear=' +pub_serialYear+ '&StyleID=' +URLEncode(orderId)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ '&ItemDetailId=' +matId+ '&Color=' +URLEncode(color)+ '&Size=' +URLEncode(size)+ '&Units=' +URLEncode(units)+ '&Qty=' +qty+ '&AjMark=' +URLEncode(ajMark)+'&unitprice='+unitprice;
	var htmlobj=$.ajax({url:url,async:false});
			*/
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
						var StyleId			= Bindetails[5];  // StyleId
						var Color			= Bindetails[6];  // Color
						var Size			= Bindetails[7];	  // Size
						var Unit			= Bindetails[8];	  // Unit
						var grnNo			= Bindetails[9];  // GRN No
						var grnYear			= Bindetails[10]; // GRN Year
						var grnType			= Bindetails[11];	  // GRN Type
						var stockType		= Bindetails[12];  // Stock Type						
					
						var url='ostockmiddle.php?RequestType=URLSaveDetails1&SerialNo=' +pub_serialNo+ '&SerialYear=' +pub_serialYear+ '&matId=' +URLEncode(matId)+ '&ajMark=' +URLEncode(ajMark)+ '&unitprice=' +unitprice+ '&binQty=' +binQty+ '&mainStoreId=' +mainStoreId+ '&subStoreId=' +subStoreId+ '&locationId=' +locationId+ '&binId=' +binId+ '&StyleId=' +StyleId+ '&Color=' +URLEncode(Color)+ '&Size=' +URLEncode(Size)+ '&Unit=' +URLEncode(Unit)+ '&grnNo=' +grnNo+ '&grnYear='+grnYear+ '&grnType='+grnType+ '&stockType='+stockType+ '&buyerPoNo='+URLEncode(buyerPoNo);
						//alert(url);
						var htmlobj = $.ajax({url:url,async:false});
						
						if(htmlobj.responseText=="Error")
						{
							booCheck = false;	
						}
						
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
	if(booCheck)
	{
		alert("Saved successfully.");
	}
	else
	{
		alert("Error in saving.");
	}
}
function GetStockQty(objbin)
{
	var rw = objbin.parentNode.parentNode.parentNode;
	var totretQty = parseFloat(document.getElementById("txtReqQty").value);
	
	if (rw.cells[2].childNodes[0].childNodes[1].checked)
	{
	  var AvailQty 	  = parseFloat(rw.cells[0].childNodes[0].nodeValue); 

	  if(AvailQty<pubTotReturnQty)
	  {
		  rw.cells[1].childNodes[0].value = AvailQty;
		  pubTotReturnQty-=parseFloat(AvailQty);
	  }
	  else
	  {
		  rw.cells[1].childNodes[0].value = pubTotReturnQty;
		   pubTotReturnQty-=parseFloat(pubTotReturnQty);
	  }	
	}
	else
	{
		if(pubTotReturnQty!=totretQty)
		{
		 	pubTotReturnQty+=parseFloat(rw.cells[1].childNodes[0].value);
		 	rw.cells[1].childNodes[0].value = 0;
		}
		else
			rw.cells[1].childNodes[0].value = 0;
	}
	  		
}
function validateQty(obj)
{
	
	var rw 		  = obj.parentNode.parentNode;
	var reqQty	  = parseFloat(obj.value=="" ? 0:obj.value);
	var totQty    = parseFloat(document.getElementById("txtReqQty").value);
	var AvalQty   = parseFloat(rw.cells[0].childNodes[0].nodeValue);
	rw.cells[2].childNodes[0].childNodes[1].checked = true;
	if(reqQty==0)
	{
		rw.cells[2].childNodes[0].childNodes[1].checked = false;
	}
	if(AvalQty>totQty)
	{
		if(reqQty>totQty)
		{
			obj.value = totQty;
		}
		else
		{
			obj.value = reqQty;
		}
	}
	else
	{
		if(reqQty>AvalQty)
		{
			obj.value = AvalQty;
		}
		else
		{
			obj.value = reqQty;
		}
	}	
}
function LoadOrderAndSc(obj)
{
	var url  = "ostockmiddle.php?RequestType=URLLoadOrderAndScNo";
		url += "&StyleNo="+URLEncode(obj.value);
		url += "&Status="+11;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboOrderNo').innerHTML = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	document.getElementById('cboScNo').innerHTML = htmlobj.responseXML.getElementsByTagName("ScNo")[0].childNodes[0].nodeValue;
}

function IsRatioAvilable(styleId)
{
	var url  = "ostockmiddle.php?RequestType=URLIsRatioAvilable";
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