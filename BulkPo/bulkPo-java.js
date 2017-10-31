var pub_BPOUrl = '/gapro/BulkPo/';
var xmlHttp;
var xmlHttp1=[];
var pub_intxmlHttp_count=0;

var pub_matNo = 0;
var pub_printWindowNo=0;

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

function clearCombo(name)
{
	var index = document.getElementById(name).options.length;
	while(document.getElementById(name).options.length > 0) 
	{
		index --;
		document.getElementById(name).options[index] = null;
	}
}

function RemoveAllRows(tableName)
{
	$("#"+tableName+" tr:gt(0)").remove();	
}

function clearCancelPO()
{
	var tbl = document.getElementById('tblCancelPO');
	var rowCount=tbl.rows.length;
	
 	if(rowCount<2)return;
	for(var rowC=1; rowC<rowCount; rowC++)
	{
		tbl.deleteRow(1);  
		rowCount=tbl.rows.length;
	}
}
function ShowItems()
{
	showBackGround('divBG',0);
	if(document.getElementById('cboSupplier').value=='0')
	{
		alert("Please select the 'Supplier'.");
		document.getElementById('cboSupplier').focus();
		hideBackGround('divBG');
		return;			
	}
	
	drawPopupBox(525,520,'frmMaterial',1);
	var HTMLText =  " <table width=\"500\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\" >"+				
					"	<tr>"+
					"	<td><table width=\"100%\" border=\"0\">"+
					"	  <tr>"+				
					"		<td >"+
					"		  <table width=\"100%\" border=\"0\">"+
					"			<tr class=\"cursercross mainHeading\">"+
					"			  	<td width=\"94%\" height=\"25\" >Add Material</td>"+
					"				<td width=\"6%\" ><img src=\"../images/cross.png\" onclick=\"CloseBPPopupBox(1);\" /></td>"+
					"			</tr>"+
					"			<tr >"+
					"			  <td height=\"7\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
					"				<tr>"+
					"				  <td width=\"12%\" height=\"25\">&nbsp;</td>"+
					"				  <td width=\"26%\" class=\"normalfnt\">Main Category</td>"+
					"				  <td width=\"50%\"><select name=\"cboMainCategory\" class=\"txtbox\" id=\"cboMainCategory\" style=\"width:255px\" onchange=\"loadSubCategory();\">"+
					"				  </select>"+
					"				  </td>"+
					"				  <td width=\"12%\">&nbsp;</td>"+
					"				</tr>"+
					"				<tr>"+
					"				  <td height=\"25\">&nbsp;</td>"+
					"				  <td class=\"normalfnt\">Sub Category</td>"+
					"				  <td><select name=\"cboSubCategory\" class=\"txtbox\" id=\"cboSubCategory\" style=\"width:255px\" onchange=\"loadMaterial();\">"+
					"				  </select></td>"+
					"				  <td class=\"normalfntMid\">All&nbsp;&nbsp;<input type=\"checkbox\" id=\"chkPopAll\"></td>"+
					"				</tr>"+
					"				<tr>"+
					"				  <td height=\"25\">&nbsp;</td>"+
					"				  <td class=\"normalfnt\">Mat Detail Like</td>"+
					"				  <td><input name=\"txtDetailsLike\" type=\"text\"  class=\"txtbox\" id=\"txtDetailsLike\" style=\"width:255px\" onkeypress=\"EnterKeySubmition(event);\" /></td>"+
					"				  <td><img src=\"../images/search.png\"  id=\"butNew\" alt=\"new\" onclick=\"loadMaterial();\"/></td>"+
					"				</tr>"+
					"			  </table></td>"+
					"			</tr>"+
					"			<tr >"+
					"			  <td height=\"8\" class=\"mainHeading4\">Select Items</td>"+
					"			</tr>"+
					"			<tr>"+
					"			  <td height=\"74\"><table width=\"100%\" height=\"141\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
					"				  <tr class=\"bcgl1\">"+
					"					<td width=\"100%\" height=\"141\"><table width=\"93%\" height=\"250\" border=\"0\" class=\"bcgl1\">"+
					"						<tr>"+
					"						  <td colspan=\"3\"><div id=\"divcons\" style=\"overflow:scroll; height:350px; width:500px;\">"+
					"							  <table width=\"600\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblMaterial\" bgcolor=\"#CCCCFF\">"+
					"								<tr class=\"mainHeading4\">"+
					"								 	<td width=\"8%\" height=\"33\" >Add</td>"+
					"									<td width=\"8%\" >Ratio</td>"+
					"									<td width=\"74%\" >Item Description</td>"+
					"									<td width=\"10%\" >Item Code</td>"+
					"									<td width=\"10%\" >Unit</td>"+
					"								  </tr>"+
					"							  </table>"+
					"						  </div></td>"+
					"						</tr>"+
					"					</table></td>"+
					"				  </tr>"+
					"			  </table></td>"+
					"			</tr>"+
					"			<tr>"+
					"			  <td height=\"32\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
					"				<tr align=\"center\">"+
					"				  <td width=\"28%\">"+
					"				  <img src=\"../images/ok.png\" alt=\"ok\" width=\"86\" height=\"24\" onclick=\"CloseBPPopupBox(1);\" />"+
					"				  <img src=\"../images/close.png\" width=\"97\" height=\"24\" onclick=\"CloseBPPopupBox(1);\"/></td>"+
					"				</tr>"+
					"			  </table></td>"+
					"			</tr>"+
					"		  </table>"+
					"		</td>"+
					"	  </tr>"+
					"	</table></td>"+
					" </tr>"+
					"</table>";

	var frame = document.createElement("div");
    frame.id = "materialSelectedWindow";
	document.getElementById('frmMaterial').innerHTML=HTMLText;
	loadItems();	
}

function loadItems()
{
	loadMainCategory();
}

function loadMainCategory()
{
	var url = 'bulkPo-xml.php?id=loadMainCategory';
	var htmlobj=$.ajax({url:url,async:false});
	loadMainCategoryRequest(htmlobj);
}
	
function loadMainCategoryRequest(xmlHttp)
{
	document.getElementById("cboMainCategory").innerHTML = xmlHttp.responseText;
	loadSubCategory();
}
	
function loadSubCategory()
{	
	clearCombo('cboSubCategory');
	var mainCatId = document.getElementById("cboMainCategory").value;
	var url = 'bulkPo-xml.php?id=loadSubCategory&mainCatId='+mainCatId ;
	var htmlobj=$.ajax({url:url,async:false});
	loadSubCategoryRequest(htmlobj);
}

function loadSubCategoryRequest(xmlHttp)
{
	document.getElementById("cboSubCategory").innerHTML = xmlHttp.responseText;
	loadMaterial();
}

function loadMaterial()
{
	var popAll			= document.getElementById('chkPopAll').checked;
	var mainCatId 		= document.getElementById("cboMainCategory").value;
	var subCatId 		= document.getElementById("cboSubCategory").value;
	var txtDetailsLike 	= document.getElementById("txtDetailsLike").value;
	var supplier 		= document.getElementById('cboSupplier').value;
	var url = 'bulkPo-xml.php?id=loadMaterial&mainCatId='+mainCatId+'&subCatId='+subCatId+'&txtDetailsLike='+URLEncode(txtDetailsLike)+ '&popAll=' +popAll+ '&supplier=' +supplier;
	
	var htmlobj=$.ajax({url:url,async:false});
	var XMLid = htmlobj.responseXML.getElementsByTagName("intItemSerial");
	var XMLname = htmlobj.responseXML.getElementsByTagName("strItemDescription");
	var XMLUnit = htmlobj.responseXML.getElementsByTagName("strUnit");
	
	var tblMaterial = document.getElementById("tblMaterial");
		var tableText = "<tr class=\"mainHeading4\">"+
								"		<td width=\"8%\" height=\"33\" >Add</td>"+
								"		<td width=\"8%\" >Ratio</td>"+
								"		<td width=\"74%\" >Item Description</td>"+
								"		<td width=\"10%\" >Item Code</td>"+
								"		<td width=\"10%\" >Unit</td>"+
								"		</tr>"+
								"		<tr>";
		
	 for ( var loop = 0; loop < XMLid.length; loop++)
	 {
		tableText +="<tr class=\"bcgcolor-tblrowWhite\">"+
		"	<td class=\"normalfnt\" ><div align=\"center\">"+
		"	</div></td>"+
		"	<td class=\"normalfnt\"><div align=\"center\">"+
		"   <img  src=\"../images/matratio.png\" alt=\"login\"  class=\"noborderforlink\" onclick=\"ShowBulkPurchaseRatio(this);\" /></a>"+
		"	</div></td>"+
		"	<td class=\"normalfnt\">"+XMLname[loop].childNodes[0].nodeValue+"</td>"+
		"	<td class=\"normalfnt\">"+XMLid[loop].childNodes[0].nodeValue+"</td>"+
		"	<td class=\"normalfnt\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>"+
		"	</tr>";
	}
	tblMaterial.innerHTML = tableText;
	
}
	
function loadMaterialRequest()
{
	if(xmlHttp1[2].readyState == 4 && xmlHttp1[2].status == 200 ) 
	{
		var XMLid = xmlHttp1[2].responseXML.getElementsByTagName("intItemSerial");
		var XMLname = xmlHttp1[2].responseXML.getElementsByTagName("strItemDescription");
		var XMLUnit = xmlHttp1[2].responseXML.getElementsByTagName("strUnit");
		//alert(XMLid.length);
		var tblMaterial = document.getElementById("tblMaterial");
		var tableText = "<tr>"+
								"		<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Add</td>"+
								"		<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Ratio</td>"+
								"		<td width=\"74%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Detail</td>"+
								"		<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Material Id</td>"+
								"		<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Unit</td>"+
								"		</tr>"+
								"		<tr>";
		
	 for ( var loop = 0; loop < XMLid.length; loop++)
	 {
		tableText +="<tr class=\"bcgcolor-tblrowWhite\">"+
		"	<td class=\"normalfnt\" ><div align=\"center\">"+
		"	</div></td>"+
		"	<td class=\"normalfnt\"><div align=\"center\">"+
		"   <img  src=\"../images/matratio.png\" alt=\"login\"  class=\"noborderforlink\" onclick=\"ShowBulkPurchaseRatio(this);\" /></a>"+
		"	</div></td>"+
		"	<td class=\"normalfnt\">"+XMLname[loop].childNodes[0].nodeValue+"</td>"+
		"	<td class=\"normalfnt\">"+XMLid[loop].childNodes[0].nodeValue+"</td>"+
		"	<td class=\"normalfnt\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>"+
		"	</tr>";
	}
	tblMaterial.innerHTML = tableText;
	
	}
}

function textChange(text)
{
	loadMaterial();
}

function ShowBulkPurchaseRatio(objRatio)
{
	pub_matNo = objRatio.parentNode.parentNode.parentNode.rowIndex;
	showBulkPurchaseRatioWindow();
}
	
function showBulkPurchaseRatioWindow()
{		
	var url="bulkPurchaseRatio.php";
	htmlobj=$.ajax({url:url,async:false});
	var HTMLText=htmlobj.responseText;
	drawPopupBox(500,513,'frmColorSize',2);
	document.getElementById('frmColorSize').innerHTML=HTMLText;
	LoadBuyersBulk();
		
}

function loadColor()
{
	var url = 'bulkPo-xml.php?id=loadColor';
	var htmlobj = $.ajax({url:url,async:false});
	loadColorRequest(htmlobj);
}

function loadColorRequest(xmlHttp)
{
	var lstColor1 = document.getElementById("cbocolors");
	var strResponse = xmlHttp.responseText;
	lstColor1.innerHTML =  strResponse;
}
	
/*function loadSize()
{
	createXMLHttpRequest1(1);
	xmlHttp1[1].onreadystatechange = loadSizeRequest;
	xmlHttp1[1].open("GET", 'bulkPo-xml.php?id=loadSize', true);
	xmlHttp1[1].send(null); 
}

function loadSizeRequest()
{
	if(xmlHttp1[1].readyState == 4 && xmlHttp1[1].status == 200 ) 
	{
		var lstSize1 = document.getElementById("cbosizes");
		var strResponse = xmlHttp1[1].responseText;
		lstSize1.innerHTML =  strResponse;
	}
}*/	
	
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

function addItemToMainTable()
{
	
var tblMain = document.getElementById("tblMain");
var tblMaterial = document.getElementById("tblMaterial");
var lstColor  = document.getElementById("cboselectedcolors");
var lstSize  = document.getElementById("cboselectedsizes");

var strMain = document.getElementById("cboMainCategory").options[document.getElementById("cboMainCategory").selectedIndex].text;

tblMaterial.rows[pub_matNo].cells[0].innerHTML = "<img  src=\"../images/ok-mark.png\" alt=\"login\"  class=\"noborderforlink\" />";
	
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
//Start - validation part with main menu			
			var booCheck =false;
			for (var mainLoop =1 ;mainLoop < tblMain.rows.length; mainLoop++ )
			{
				var mainItemDetailId 	= tblMain.rows[mainLoop].cells[9].lastChild.nodeValue;					
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
				var rowCount = tblMain.rows.length;		
				var row = tblMain.insertRow(rowCount);
				row.className = "bcgcolor-tblrowWhite";			
	
				tblMain.rows[rowCount].innerHTML=  "<td class=\"normalfntMid\"><img src=\"../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\" /></td>"+
					"<td class=\"normalfntMid\">"+strMain+"</td>"+
					"<td class=\"normalfnt\">"+description+"</td>"+
					"<td class=\"normalfntSM\">"+color+"</td>"+
					"<td class=\"normalfntSM\">"+size+"</td>"+
					"<td class=\"normalfntMidSML\">"+units+"</td>"+
					"<td class=\"normalfntRite\"><input type=\"text\" name=\"txtQty\" style=\"text-align:right\" size=\"15\" class=\"txtbox\" id=\"txtQty\" style=\"width:80px\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" onkeyup=\"calculateRowValue(this);\"  onblur=\"calculateT();\" ></td>"+
					"<td class=\"normalfntRite\"><input type=\"text\" name=\"txtValue\" style=\"text-align:right\" size=\"15\" class=\"txtbox\" id=\"txtValue\" style=\"width:80px\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" onkeyup=\"calculateRowValue(this);\"  onblur=\"calculateT();\" ></td>"+
					"<td class=\"normalfntRite\">0</td>"+
					"<td class=\"normalfntMidSML\">"+detailId+"</td>";
			}
		}
	}
	CloseBPPopupBox(2);
}


function calculateRowValue(objText)
{
	var dblQty = dblQty = parseFloat(objText.parentNode.parentNode.cells[6].lastChild.value);
	var dblUnitPrice =  parseFloat(objText.parentNode.parentNode.cells[7].lastChild.value);
	var dblTotal =  parseFloat(dblQty * dblUnitPrice);
	objText.parentNode.parentNode.cells[8].lastChild.nodeValue =RoundNumbers(dblTotal,4);
}	

function removeRow(objDel)
{
	if(confirm("Are you sure you want to delete this ?"))
	{
		var tblMain = objDel.parentNode.parentNode.parentNode;
		var rowNo = objDel.parentNode.parentNode.rowIndex
		tblMain.deleteRow(rowNo);
	}
}

function calculateT()
{
	var tblMain  = document.getElementById("tblMain");
	var dblT = 0;
	for(var i=1;i<tblMain.rows.length;i++)
	{
		if(tblMain.rows[i].cells[6].lastChild.value=="")
			tblMain.rows[i].cells[6].lastChild.value=0;
			
		if(tblMain.rows[i].cells[7].lastChild.value=="")
			tblMain.rows[i].cells[7].lastChild.value=0;
		
		dblT = dblT +(parseFloat(tblMain.rows[i].cells[6].lastChild.value) * parseFloat(tblMain.rows[i].cells[7].lastChild.value));
	}
	document.getElementById("txtPoAmount").value = RoundNumbers(dblT,4);
}

function validateBulkPo()
{
	var fullDate=document.getElementById("podate").value;
	var strSupplier	= document.getElementById("cboSupplier").options[document.getElementById('cboSupplier').selectedIndex].text;
	if(strSupplier=="Select One")
	{
		alert("Please select \"Supplier\".");
		document.getElementById("cboSupplier").focus();
		return false;
	}
	
	var strCurrency	= document.getElementById("cboCurrency").value;
	if(strCurrency=="")
	{
		alert("Please select \"Currency\".");
		document.getElementById("cboSupplier").focus();
		return false;
	}
	var deliverydateDD	= document.getElementById("deliverydateDD").value;
	if(deliverydateDD=="")
	{
		alert("Please select \"Delivery Date\".");
		document.getElementById("deliverydateDD").focus();
		return false;
	}
	/*if(!validateDate(deliverydateDD))
	{
		alert("Delivery Date can not be prior to current date, Please select a correct delivery date.");
		document.getElementById('deliverydateDD').focus();
		return;
	}*/
	var Deliverto	= document.getElementById("cboDeliverto").value;
	if(Deliverto=="")
	{
		alert("Please select \"Deliver to Company\" .");
		document.getElementById("cboDeliverto").focus();
		return false;
	}
	
	var InvoiceTo	= document.getElementById("cboInvoiceTo").value;
	if(InvoiceTo=="")
	{
		alert("Please select \"Invoice to Company \".");
		document.getElementById("cboInvoiceTo").focus();
		return false;
	}	
	
	var paymentMode	= document.getElementById("cboPayMode").value;
	if(paymentMode=="")
	{
		alert("Please select \"Payment Mode\".");
		document.getElementById("cboPayMode").focus();
		return false;
	}
	
	var paymentTerm	= document.getElementById("cboPayTerms").value;
	if(paymentTerm=="")
	{
		alert("Please select \"Payment Term\".");
		document.getElementById("cboPayTerms").focus();
		return false;
	}
	
	/*var ETA=document.getElementById('deliverydateETA').value;
	if(ETA!="" && !validateDate(ETA))
	{
		alert("ETA can not be prior to current date, Please select a correct ETA date.");
		document.getElementById('deliverydateETA').focus();
		return;
	}
	var ETD=document.getElementById('deliverydate').value;
	if(ETD!="" && !validateDate(ETD))
	{
		alert("ETD can not be prior to current date, Please select a correct ETD date.");
		document.getElementById('deliverydate').focus();
		return;
	}*/
	if(baseCountryId != sup_countryId)
	{
		if(document.getElementById('cboShipment').value == "Null")	
		{
			alert("Please select  \"Shipment Mode\" .");
			document.getElementById('cboShipment').focus();
			return;	
		}
		if(document.getElementById('cboshipmentTerm').value == "Null")	
		{
			alert("Please select  \"Shipment Term\" .");
			document.getElementById('cboshipmentTerm').focus();
			return;	
		}
	}
	if(document.getElementById('cboMerchandiser').value == '')
	{
		alert("Please select 'Merchandiser' .");
		document.getElementById('cboMerchandiser').focus();
		return;
	}
	var tbl=document.getElementById('tblMain');
	
	if(tbl.rows.length<2)
	 {
		alert("No Items found in Bulk PO, Please add items to bulk purchase order.");
		document.getElementById('butNew').focus();
		return false;
	 }
	//check PO qty & prcie vaidation
	 for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  		{
			var tt=tbl.rows.length;
			var rw=tbl.rows[loop]; 
			var qty=rw.cells[6].lastChild.value;
			var price=rw.cells[7].lastChild.value;
			
			if(qty == '')
			{
				alert("Please enter \"Quantity\".");
				return false;
			}
			else if(price == '')
			{
				alert("Please enter \"Unit Price\".");	
				return false;
				}
		}
	return true;
}

function validateDate(dtmFullDate)
{
	var dtmdate = document.getElementById('podate').value;
	var arrDate = dtmdate.split("/")[2]+'-'+dtmdate.split("/")[1]+'-'+dtmdate.split("/")[0];
	var todayDate = new Date(arrDate);
	
	var arrTdate = dtmFullDate.split("/")[2]+'-'+dtmFullDate.split("/")[1]+'-'+dtmFullDate.split("/")[0];
	var testDate = new Date(arrTdate);
	
	
	if(testDate>=todayDate)
	  	return true;
	 else
	 	return false;
}

function save()
{
	document.getElementById("butSave").style.display="none";
	if(validateBulkPo())
	{
		saveBulkGrnHeader();
	}
	document.getElementById("butSave").style.display="inline";	
}

 var fullDate=new Date();
function saveBulkGrnHeader()
{
	var text1 =  document.getElementById("txtBulkPoNo").value;
	
	if( text1 == ""){
		var strBulkPONo			= "";
		var intYear				= "";
	}
	else{
		var strBulkPONo			= text1;//(text1).split("/")[1];
		var intYear				= document.getElementById("cboBPOYearBox").value;
	}
	
	var strSupplierID		= document.getElementById("cboSupplier").value;
	var strRemarks			= "";

	var dtDate		= (document.getElementById("podate").value).split("/")[2]+"-"+(document.getElementById("podate").value).split("/")[1]+"-"+(	document.getElementById("podate").value).split("/")[0];
	
	var dtDeliveryDate		= (document.getElementById("deliverydateDD").value).split("/")[2]+"-"+(document.getElementById("deliverydateDD").value).split("/")[1]+"-"+(	document.getElementById("deliverydateDD").value).split("/")[0];
	
	var strCurrency			= document.getElementById("cboCurrency").value;
	var dblTotalValue		= document.getElementById("txtPoAmount").value;
	
	var intInvoiceComp		= document.getElementById("cboInvoiceTo").value;
	var intDeliverTo		= document.getElementById("cboDeliverto").value;

	var strPayTerm			= document.getElementById("cboPayTerms").value;
	var intPayMode			= document.getElementById("cboPayMode").value;
	var intShipmentModeId   = document.getElementById("cboShipment").value;
	var intShipmentTermId   = document.getElementById("cboshipmentTerm").value;
	var strInstructions		= document.getElementById("txtIntroduction").value;
	
	var strPINO				= document.getElementById("txtPinNo").value;
	
	var ETA=document.getElementById('deliverydateETA').value;
	var ETD=document.getElementById('deliverydate').value;
	var merchandiser = document.getElementById('cboMerchandiser').value;
	
	var url  = pub_BPOUrl+"bulkPo-db.php?id=saveBulkPoHeader";
		url += "&strBulkPONo="+strBulkPONo;
		url += "&intYear="+intYear;
		url += "&strSupplierID="+strSupplierID;
		url += "&strRemarks="+URLEncode(strRemarks);
		url += "&dtDate="+dtDate;
		url += "&dtDeliveryDate="+dtDeliveryDate;
		url += "&strCurrency="+strCurrency;
		url += "&dblTotalValue="+dblTotalValue;		
		url += "&intInvoiceComp="+intInvoiceComp;
		url += "&intDeliverTo="+intDeliverTo;
		url += "&strPayTerm="+strPayTerm;
		url += "&intPayMode="+intPayMode;		
		url += "&intShipmentModeId="+intShipmentModeId;
		url += "&intShipmentTermId="+intShipmentTermId;
		url += "&strInstructions="+URLEncode(strInstructions);
		url += "&strPINO="+URLEncode(strPINO);
		url += '&ETA='+ETA;
		url += '&ETD='+ETD;
		url += '&merchandiser='+merchandiser;
		
	htmlobj=$.ajax({url:url,async:false});	
	var bulkPoNo = trim(htmlobj.responseText);
	var BPOnoDet = bulkPoNo.split("***")[1];
	document.getElementById("txtBulkPoNo").value = BPOnoDet.split('/')[1];
	if(bulkPoNo.split("***")[0]!="Saving-Error")
	{
		saveBulkGrnDetails(bulkPoNo.split("***")[1]);
	}
	else
	{
		alert("Error : \nBulk Purchase order header not saved");
		document.getElementById("butSave").style.display="inline";
		return;
	}
}

function saveBulkGrnDetails(pono)
{	
	var tblGrn = document.getElementById("tblMain");	
	pub_intxmlHttp_count = tblGrn.rows.length-1;
	var count=0;
	for(var loop=1;loop<tblGrn.rows.length;loop++)
	{		
		var	strBulkPoNo			= pono.split("/")[1];
		var intYear				= pono.split("/")[0];
		var	strMatDetailID		= tblGrn.rows[loop].cells[9].lastChild.nodeValue;
		var strColor			= tblGrn.rows[loop].cells[3].lastChild.nodeValue;
		var strSize				= tblGrn.rows[loop].cells[4].lastChild.nodeValue;
		var strUnit				= tblGrn.rows[loop].cells[5].lastChild.nodeValue;
		var dblUnitPrice		= tblGrn.rows[loop].cells[7].lastChild.value;
		var dblQty				= tblGrn.rows[loop].cells[6].lastChild.value;
		var dblPending			= tblGrn.rows[loop].cells[6].lastChild.value;
		var dblDlPrice			= tblGrn.rows[loop].cells[6].lastChild.value * tblGrn.rows[loop].cells[7].lastChild.value;
		var strDeliveryDates	= document.getElementById("deliverydateDD").value;
		var intDeliverTo 		= document.getElementById("cboDeliverto").value;	
	
		var url  = pub_BPOUrl+"bulkPo-db.php?id=saveBulkPoDetails";
			url += "&strBulkPoNo="+strBulkPoNo;
			url += "&intYear="+intYear;
			url += "&strMatDetailID="+strMatDetailID;
			url += "&strColor="+URLEncode(strColor);
			url += "&strSize="+URLEncode(strSize);
			url += "&strUnit="+strUnit;
			url += "&dblUnitPrice="+dblUnitPrice;
			url += "&dblQty="+dblQty;
			url += "&dblPending="+dblPending;
			url += "&dblDlPrice="+dblDlPrice;
			url += "&strDeliveryDates="+strDeliveryDates;
			url += "&intDeliverTo="+intDeliverTo;
			url += "&count="+loop;
		
		htmlobj=$.ajax({url:url,async:false});	
		var intNo =htmlobj.responseText;
		if(intNo==1)
		{
			count++;										
		}
	}
	if(count == pub_intxmlHttp_count)
	{
		alert("Bulk PO No saved successfully.\n\n Bulk PO No :"+pono);
		ValidateInterface(0);
	}
	else
	{
		alert( "Bulk PO details saving error...");
	}
}

function SearchBulkPoNo()
{
	var BPOno = document.getElementById('txtBulkPoNo').value;
	var POyear = document.getElementById('cboBPOYearBox').value;
	loadBulkPoForm(BPOno,POyear);
}

function loadBulkPoForm(strBulkPoNo,intYear)
{
	if ((strBulkPoNo==0)||(intYear==0))
		return;
		
	var url  = "bulkPo-xml.php?id=loadBulkPoHeader";
		url += "&strBulkPoNo="+strBulkPoNo;
		url += "&intYear="+intYear;			
	var htmlobj=$.ajax({url:url,async:false});
	bulkPoHeaderRequest(htmlobj);

	var url  = "bulkPo-xml.php?id=loadBulkPoDetails";
		url += "&strBulkPoNo="+strBulkPoNo;
		url += "&intYear="+intYear;
	var htmlobj=$.ajax({url:url,async:false});
	bulkPoDetailRequest(htmlobj);
}

function bulkPoHeaderRequest(xmlHttp)
{
	var XMLstrBulkPONo 			= xmlHttp.responseXML.getElementsByTagName("strBulkPONo");
	if(XMLstrBulkPONo.length<=0)
	{
		alert("Sorry!\nNo details to view.");
		return;
	}			
	var XMLintYear 				= xmlHttp.responseXML.getElementsByTagName("intYear");
	var XMLstrSupplierID 		= xmlHttp.responseXML.getElementsByTagName("strSupplierID");
	var XMLdtDate 				= xmlHttp.responseXML.getElementsByTagName("dtDate");
	var XMLdtDeliveryDate 		= xmlHttp.responseXML.getElementsByTagName("dtDeliveryDate");
	var XMLstrCurrency 			= xmlHttp.responseXML.getElementsByTagName("strCurrency");
	var XMLintStatus 			= xmlHttp.responseXML.getElementsByTagName("intStatus");
	var XMLintCompId 			= xmlHttp.responseXML.getElementsByTagName("intCompId");
	var XMLintDeliverTo 		= xmlHttp.responseXML.getElementsByTagName("intDeliverTo");
	var XMLstrPayTerm 			= xmlHttp.responseXML.getElementsByTagName("strPayTerm");
	var XMLintPayMode 			= xmlHttp.responseXML.getElementsByTagName("intPayMode");
	var XMLintShipmentModeId 	= xmlHttp.responseXML.getElementsByTagName("intShipmentModeId");
	var XMLstrInstructions 		= xmlHttp.responseXML.getElementsByTagName("strInstructions");
	var XMLstrPINO 				= xmlHttp.responseXML.getElementsByTagName("strPINO");
	var XMLintInvoiceComp 		= xmlHttp.responseXML.getElementsByTagName("intInvoiceComp");
	var XMLShipmentTerm 		= xmlHttp.responseXML.getElementsByTagName("intShipmentTermID");
	var XMLETAdate				= xmlHttp.responseXML.getElementsByTagName("ETADate");
	var XMLETDdate				= xmlHttp.responseXML.getElementsByTagName("ETDDate");
	
	document.getElementById("txtBulkPoNo").value= XMLstrBulkPONo[0].childNodes[0].nodeValue;
	var objDate = XMLdtDate[0].childNodes[0].nodeValue.split(" ");
	var currDate = objDate[0].split("-");
	var cdate   = currDate[2] +"/"+currDate[1]+"/"+currDate[0];
	document.getElementById("podate").value = cdate;
	document.getElementById("cboSupplier").value = XMLstrSupplierID[0].childNodes[0].nodeValue;
	
	var d = XMLdtDeliveryDate[0].childNodes[0].nodeValue;
		var d1 = "";
		d = d.split("-");
		d1= d[2].substring(0,2)+"/"+d[1]+"/"+d[0];
	document.getElementById("deliverydateDD").value = d1 ;			
	
	if(XMLETAdate[0].childNodes[0].nodeValue != '')
	{
		var objETADate = XMLETAdate[0].childNodes[0].nodeValue.split(" ");
		var ETAdate = objETADate[0].split("-");
		document.getElementById("deliverydateETA").value   = ETAdate[2] +"/"+ETAdate[1]+"/"+ETAdate[0];
	}
	else
		document.getElementById("deliverydateETA").value='';
		
	if(XMLETDdate[0].childNodes[0].nodeValue != '')
	{
		var objETDDate = XMLETDdate[0].childNodes[0].nodeValue.split(" ");
		var ETDdate = objETDDate[0].split("-");
		document.getElementById("deliverydate").value   = ETDdate[2] +"/"+ETDdate[1]+"/"+ETDdate[0];
	}
	else
		document.getElementById("deliverydate").value = '';

	document.getElementById("txtIntroduction").value = XMLstrInstructions[0].childNodes[0].nodeValue;
	document.getElementById("cboCurrency").value = XMLstrCurrency[0].childNodes[0].nodeValue;			
	document.getElementById("cboInvoiceTo").value = XMLintInvoiceComp[0].childNodes[0].nodeValue;
	document.getElementById("cboDeliverto").value = XMLintDeliverTo[0].childNodes[0].nodeValue;
	document.getElementById("cboPayMode").value = XMLintPayMode[0].childNodes[0].nodeValue;
	document.getElementById("cboPayTerms").value = XMLstrPayTerm[0].childNodes[0].nodeValue;
	document.getElementById("cboShipment").value = XMLintShipmentModeId[0].childNodes[0].nodeValue;
	document.getElementById("cboshipmentTerm").value = XMLShipmentTerm[0].childNodes[0].nodeValue;
	document.getElementById("txtPinNo").value = XMLstrPINO[0].childNodes[0].nodeValue;
	document.getElementById("cboCurrency").value = XMLstrCurrency[0].childNodes[0].nodeValue;
	document.getElementById("txtPoAmount").value = "0";
	document.getElementById("cboMerchandiser").value = xmlHttp.responseXML.getElementsByTagName("intMerchandiser")[0].childNodes[0].nodeValue;
	var status = parseFloat(XMLintStatus[0].childNodes[0].nodeValue);
	
	sup_countryId = xmlHttp.responseXML.getElementsByTagName("supCountry")[0].childNodes[0].nodeValue;
	
ValidateInterface(status);
}

function bulkPoDetailRequest(xmlHttp)
{
	RemoveAllRows('tblMain');
	var tblMain 			= document.getElementById("tblMain");		
	var XMLstrMainCategory 	= xmlHttp.responseXML.getElementsByTagName("strMainCategory");
	var XMLitemDescription 	= xmlHttp.responseXML.getElementsByTagName("itemDescription");
	var XMLstrColor 		= xmlHttp.responseXML.getElementsByTagName("strColor");
	var XMLstrSize 			= xmlHttp.responseXML.getElementsByTagName("strSize");
	var XMLstrUnit 			= xmlHttp.responseXML.getElementsByTagName("strUnit");
	var XMLdblUnitPrice 	= xmlHttp.responseXML.getElementsByTagName("dblUnitPrice");
	var XMLdblBalance 		= xmlHttp.responseXML.getElementsByTagName("dblBalance");
	var XMLdblQty 			= xmlHttp.responseXML.getElementsByTagName("dblQty");
	var XMLstrMatDetailID 	= xmlHttp.responseXML.getElementsByTagName("strMatDetailID");
	var XMLStatus 			= xmlHttp.responseXML.getElementsByTagName("Status");	
	
	for(var n = 0; n < XMLstrMainCategory.length ; n++) 
	{
		var value =RoundNumbers(XMLdblQty[n].childNodes[0].nodeValue * XMLdblUnitPrice[n].childNodes[0].nodeValue,4);
		var rowCount = tblMain.rows.length;
		var row 	 = tblMain.insertRow(rowCount);
		row.className = "bcgcolor-tblrowWhite";
		
		if(XMLStatus[n].childNodes[0].nodeValue==0)
			var imgDelete = "<img src=\"../images/del.png\" width=\"15\" height=\"15\" onclick=\"removeRow(this);\" />";
		else
			var imgDelete = "&nbsp;";
		tblMain.rows[rowCount].innerHTML =  "<td class=\"normalfntMid\">"+imgDelete+"</td>"+
		"<td class=\"normalfntMid\">"+XMLstrMainCategory[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfnt\">"+XMLitemDescription[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfntSM\">"+XMLstrColor[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfntSM\">"+XMLstrSize[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfntMidSML\">"+XMLstrUnit[n].childNodes[0].nodeValue+"</td>"+
		"<td class=\"normalfntRite\"><input type=\"text\" name=\"txtQty\" style=\"text-align:right\" size=\"15\" class=\"txtbox\" id=\"txtQty\" style=\"width:80px\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" onkeyup=\"calculateRowValue(this);\"  onblur=\"calculateT();\"  value="+XMLdblQty[n].childNodes[0].nodeValue+"></td>"+
		"<td class=\"normalfntRite\"><input type=\"text\" name=\"txtValue\" style=\"text-align:right\" size=\"15\" class=\"txtbox\" id=\"txtValue\"  onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\"  style=\"width:80px\"  onkeyup=\"calculateRowValue(this);\"  onblur=\"calculateT();\"  value="+XMLdblUnitPrice[n].childNodes[0].nodeValue+"></td>"+
		"<td class=\"normalfntRite\">"+value+"</td>"+
		"<td class=\"normalfntMidSML\">"+XMLstrMatDetailID[n].childNodes[0].nodeValue+"</td>";
	}
	calculateT();
}

function newPage()
{
	$("#frmBulkPO")[0].reset();
	$("#tblMain tr:gt(0)").remove();
	ValidateInterface(0);
}

function conform()
{
	var text1 =  document.getElementById("txtBulkPoNo").value;
	if( text1 == ""){
		alert("Please Select the \"Bulk Po No\".");
		return;
	}
	else{
		var strBulkPoNo			= text1;//(text1).split("/")[1];
		var intYear				= document.getElementById("cboBPOYearBox").value;//(text1).split("/")[0];
	}
		
	var url  = "bulkPo-db.php?id=confirmBulkPo";
		url += "&strBulkPoNo="+strBulkPoNo;
		url += "&intYear="+intYear;
	var htmlobj=$.ajax({url:url,async:false});
	saveBulPoConfirm(htmlobj);
}

function saveBulPoConfirm(xmlHttp)
{
	var response = xmlHttp.responseText;
	var Confirm = (response).split("-")[0];
	
	if(Confirm)
	{
		var BPONo = (response).split("-")[1];
		var Byear = (response).split("-")[2];
		var str   = BPONo.trim()+'/'+Byear.trim();
		alert("Bulk PO \""+str+"\" confirmed successfully.");				
		ValidateInterface(1);
	}
	else
		alert("Sorry!\nBulk Po is not confirmed.");
}

function cancel()
{
	var text1 =  document.getElementById("txtBulkPoNo").value;
	if( text1 == ""){
		alert("Please Select the \"Bulk PO No\".");
		return;
	}
	else{
		var strBulkPoNo			= text1;//(text1).split("/")[1];
		var intYear				= document.getElementById("cboBPOYearBox").value;//(text1).split("/")[0];
	}
	
	//var r=confirm("Are you sure you want to cancel  Bulk PONo \""+ intYear+"/"+strBulkPoNo+"\" ?");
/*	var answer	= prompt("Please enter reason for cancelation");
	alert(answer);
	return;
	if (answer==true)		
	{
		var url  = "bulkPo-db.php?id=cancelBulkPo";
			url += "&strBulkPoNo="+strBulkPoNo;
			url += "&intYear="+intYear;				
		var htmlobj=$.ajax({url:url,async:false});
		saveBulPoCancel(htmlobj);
	}*/
	var cancelReason	= prompt("Please enter reason for cancellation");
	if(cancelReason!=null)
	{
		if(cancelReason=="")
			alert("Please enter reason for cancellation.");		
		else
		{
			var url  = "bulkPo-db.php?id=cancelBulkPo";
				url += "&strBulkPoNo="+strBulkPoNo;
				url += "&intYear="+intYear;
				url += "&CancelReason="+cancelReason;			
			var htmlobj=$.ajax({url:url,async:false});
			saveBulPoCancel(htmlobj);
		}
	}
}

function saveBulPoCancel(xmlHttp)
{
	var response = xmlHttp.responseText;
	var cancel =(response).split("-")[0];
	if(cancel == "1")
	{
		var BPONo = (response).split("-")[1];
		var Byear = (response).split("-")[2];
		var str   = BPONo.trim()+'/'+Byear.trim();
		alert("Bulk PO No '"+str+"' canceled successfully.");
		ValidateInterface(10);
	}
	else
		alert("Sorry!\nYou cannot cancel this PO.\nConfirm GRN available for this PO.Cancel the GRN and try again.");
}

function Revise()
{
	var text1 =  document.getElementById("txtBulkPoNo").value;
	if( text1 == "")
	{
		alert("Please enter 'Bulk PO No'.");
		return;
	}
	else
	{
		var strBulkPoNo			= text1;//(text1).split("/")[1];
		var intYear				= document.getElementById("cboBPOYearBox").value;//(text1).split("/")[0];
	}
		
	var url  = "bulkPo-db.php?id=Revise";
		url += "&strBulkPoNo="+strBulkPoNo;
		url += "&intYear="+intYear;
	var htmlobj=$.ajax({url:url,async:false});
	ReviseRequest(htmlobj);
}

function ReviseRequest(xmlHttp)
{
	var revise = xmlHttp.responseText;
		
	if(revise)
	{
		var text1 =  document.getElementById("txtBulkPoNo").value;
		var bYear =  document.getElementById("cboBPOYearBox").value;
		alert("Bulk PO No \""+text1+ "/"+ bYear +"\" is revised");
		ValidateInterface(0);
	}
	else
		alert("Sorry!\nYou cannot revise this po\nConfirm GRN available for this PO.Cancel the GRN and try again.");
}

function BulkPoReport()
{
	var Supplier = document.getElementById('cboSupplier').options[document.getElementById('cboSupplier').selectedIndex].text;
	var path = pub_BPOUrl+"bulkPurchaeOrderReport.php?bulkPoNo="+document.getElementById("txtBulkPoNo").value+"&intYear="+document.getElementById("cboBPOYearBox").value+'&Supplier='+Supplier;
	window.open(path,'frmBulkPO');
}

function trim(str)
{
	return ltrim(rtrim(str, ' '), ' ' );
}

function EnterKeySubmition(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	
	if (charCode == 13)
	{
		loadMaterial();
	}
}

function ValidateInterface(status)
{	
	if(status=='0')
	{
		document.getElementById("butSave").style.display = "inline";
		if(comfirmBulkPo)
			document.getElementById("butConform").style.display ="inline";
		document.getElementById("butCancel").style.display = "none";		
	}
	else if(status=='1')
	{
		document.getElementById("butSave").style.display="none";
		document.getElementById("butConform").style.display="none";
		document.getElementById("butCancel").style.display="inline";		
	}
	else if(status=='10')
	{
		document.getElementById("butSave").style.display="none";
		document.getElementById("butConform").style.display="none";
		document.getElementById("butCancel").style.display="none";
	}
}

function clearDropDown(controName)
{  
	 var theDropDown = document.getElementById(controName)  
	 var numberOfOptions = theDropDown.options.length  
	 for (i=0; i<numberOfOptions; i++) {  
	   theDropDown.remove(0)  
	 }
}
function editBulkPO()
{
	if(document.getElementById('FindPO').style.visibility == "visible")	
	{
		document.getElementById('FindPO').style.visibility = "hidden";
	}
	else
	{
		document.getElementById('FindPO').style.visibility = "visible";
		LoadBulkPONO();
	}
}

function closeFindBPO()
{
	document.getElementById('FindPO').style.visibility = "hidden";	
}

function LoadBulkPONO()
{
	clearDropDown('cboPONoFind');
	var suplierID=document.getElementById('cboSupFind').value;
	var url = pub_BPOUrl+"bulkPo-xml.php";
		url += "?id=loadPendingBPONo";
		url += "&suplierID="+suplierID;	
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById("cboPONoFind").innerHTML = htmlobj.responseText;
}

function setValuetoPoBox()
{
	var poNo=document.getElementById("cboPONoFind").value;
	document.getElementById("txtBulkPoNo").value=poNo;
	document.getElementById('FindPO').style.visibility = "hidden";	
}

function getSupplierData()
{
	var suplierID=document.getElementById('cboSupplier').value;
	var url = pub_BPOUrl+"bulkPo-xml.php";
		url += "?id=getSupplierDetails";
		url += "&suplierID="+suplierID;	
	htmlobj=$.ajax({url:url,async:false});	
	
	document.getElementById('cboPayTerms').value 	 = htmlobj.responseXML.getElementsByTagName("strPayTermId")[0].childNodes[0].nodeValue;
	document.getElementById('cboPayMode').value 	 = htmlobj.responseXML.getElementsByTagName("strPayModeId")[0].childNodes[0].nodeValue;
	document.getElementById('cboshipmentTerm').value = htmlobj.responseXML.getElementsByTagName("strShipmentTermId")[0].childNodes[0].nodeValue;
	document.getElementById('cboShipment').value     = htmlobj.responseXML.getElementsByTagName("intShipmentModeId")[0].childNodes[0].nodeValue;
	document.getElementById('cboCurrency').value     = htmlobj.responseXML.getElementsByTagName("strCurrency")[0].childNodes[0].nodeValue;	
	pub_curr = document.getElementById('cboCurrency').value;
	sup_countryId = htmlobj.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;	
}

function convertRates()
{
	var curType = document.getElementById("cboCurrency").value;	
	var rate = 	getExRate(curType);
	
	if(rate == 'NA')
	{
		alert('Exchange rate not available for '+curType);
		return;
	}
	
	var tbl=document.getElementById('tblMain');
	var rwCnt = tbl.rows.length;		
	var prevCurrRate = parseFloat(getExRate(pub_curr));
	if(rwCnt>1)
	{
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
			var tt=tbl.rows.length;
			var ff=tbl.tBodies.length;
			var rw=tbl.rows[loop];
			var unitPrice= parseFloat(rw.cells[7].childNodes[0].value);
			var Qty = rw.cells[6].childNodes[0].value;
			var newPrice = unitPrice/prevCurrRate*rate;
			rw.cells[7].childNodes[0].value = RoundNumbers(newPrice,5);
			rw.cells[8].childNodes[0].nodeValue = RoundNumbers(parseFloat(newPrice*Qty),4);				
		}		 
	 calculateT();
	}		
	pub_curr = document.getElementById("cboCurrency").value;		
}

function getExRate(curType)
{
	var url  = pub_BPOUrl+"bulkPo-xml.php";
		url += "?id=getExchangeRate";
		url += '&curType='+curType;
	
	var htmlobj=$.ajax({url:url,async:false});
	var rate = htmlobj.responseXML.getElementsByTagName("Rate")[0].childNodes[0].nodeValue;
	return rate;
}

function RoundNumbers(number,decimals) 
{
	number = parseFloat(number).toFixed(parseInt(decimals))
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

function keyMoveColorRight(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;	
	if(charCode==13)
		MoveColorRight();
}

function  keyMoveSizeRight(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;	
	if(charCode==13)
		MoveSizeRight();
}

function LoadBuyersBulk()
{
	 var url="bulkPo-xml.php?id=loadBuyerinBulk";
	 htmlobj=$.ajax({url:url,async:false});
	 document.getElementById('cboBuyer').innerHTML =htmlobj.responseText;
	 ChangeBuyer();
}

function ChangeBuyer()
{
	if(document.getElementById("cbocolors")!= null)
	RemoveCurrentSizes();
	RemoveCurrentColors();
	RemoveSelectedColors();
	RemoveSelectedSizes();
	ShowBuyerDivisions();
	ShowBuyerColors();
	if(document.getElementById("cbosizes")!= null)
	ShowBuyerSizes();
}

function ShowBuyerDivisions()
{
	var custID = document.getElementById('cboBuyer').value;
	var url='../preordermiddletire.php?RequestType=GetDivision&CustID=' + custID;
	 htmlobj=$.ajax({url:url,async:false});
	 
	 var opt = document.createElement("option");
			opt.text = "Select One";
			opt.value = "Select One";
			document.getElementById("cboDivision").options.add(opt);
			document.getElementById("cboDivision").value = "Select One";
			
	 var XMLDivisionID = htmlobj.responseXML.getElementsByTagName("DivisionID");
			 var XMLDivisionName = htmlobj.responseXML.getElementsByTagName("Division");
			 
	 for ( var loop = 0; loop < XMLDivisionID.length; loop ++)
	 {
		var opt = document.createElement("option");
		opt.text = XMLDivisionName[loop].childNodes[0].nodeValue;
		opt.value = XMLDivisionID[loop].childNodes[0].nodeValue;
		document.getElementById("cboDivision").options.add(opt);
	 }
}

function ShowBuyerColors()
{
	var custID = document.getElementById('cboBuyer').value;	
	var url = '../bomMiddletire.php?RequestType=GetBuyerColors&BuyerID='+ custID;
	htmlobj = $.ajax({url:url,async:false});
	
	var XMLColor = htmlobj.responseXML.getElementsByTagName("Color");
	for ( var loop = 0; loop < XMLColor.length; loop ++)
	{
		var opt = document.createElement("option");
		opt.text = XMLColor[loop].childNodes[0].nodeValue;
		opt.value = XMLColor[loop].childNodes[0].nodeValue;
		document.getElementById("cbocolors").options.add(opt);		
	}			
}

function ShowBuyerSizes()
{
	var custID = document.getElementById('cboBuyer').value;	
	var url='../bomMiddletire.php?RequestType=GetBuyerSizes&BuyerID=' + custID;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLColor = htmlobj.responseXML.getElementsByTagName("Size");
	for ( var loop = 0; loop < XMLColor.length; loop ++)
	{
		var opt = document.createElement("option");
		opt.text = XMLColor[loop].childNodes[0].nodeValue;
		opt.value = XMLColor[loop].childNodes[0].nodeValue;
		document.getElementById("cbosizes").options.add(opt);		
	}			
}

function SaveColor(colorName)
{
	var buyer = document.getElementById("cboBuyer").value;
	var division = document.getElementById("cboDivision").value;
	
	var url='../bomMiddletire.php?RequestType=AddNewColor&colorName=' + URLEncode(colorName) + '&buyer=' + buyer + '&division=' + division
	htmlobj=$.ajax({url:url,async:false});
	
	var optColor = document.createElement("option");
	optColor.text = document.getElementById("txtColor").value;
	optColor.value = document.getElementById("txtColor").value;
	document.getElementById("cboselectedcolors").options.add(optColor);
	document.getElementById("txtColor").value = "";
}

function AddNewSize()
{
	if (document.getElementById("txtSize").value == "")
	{
		alert("Please enter the size name.");
		document.getElementById("txtnewSize").focus();
		return ;
	}
	
	var added = false;
	for(var i = 0; i < document.getElementById("cbosizes").options.length ; i++) 
	{
		if ( document.getElementById("cbosizes").options[i].text.toLowerCase() == document.getElementById("txtSize").value.toLowerCase())
		{
			if(!CheckitemAvailability(document.getElementById("txtSize").value,document.getElementById("cboselectedsizes"),false))
			{
				var optColor = document.createElement("option");
				optColor.text = document.getElementById("cbosizes").options[i].text;
				optColor.value = document.getElementById("cbosizes").options[i].text;
				document.getElementById("cboselectedsizes").options.add(optColor);
				document.getElementById("cbosizes").options[i] = null;				
				added =true;
			}					
		}
	}
		
	if (!added)
	{
		if(!CheckitemAvailability(document.getElementById("txtSize").value,document.getElementById("cboselectedsizes"),false))
			SaveSize(document.getElementById("txtSize").value);
		else
			alert("The size already exists.");
	}
}	

function SaveSize(SizeName)
{
	var buyer = document.getElementById("cboBuyer").value;
	var division = document.getElementById("cboDivision").value;
	
	var url='../bomMiddletire.php?RequestType=AddNewSize&SizeName=' + URLEncode(SizeName) + '&buyer=' + buyer + '&division=' + division
	htmlobj=$.ajax({url:url,async:false});
	
	var optColor = document.createElement("option");
	optColor.text = document.getElementById("txtSize").value;
	optColor.value = document.getElementById("txtSize").value;
	document.getElementById("cboselectedsizes").options.add(optColor);
	document.getElementById("txtSize").value = "";
}

//BEGIN - 23-06-2011 - Listing functions
function loadBulkPo()
{
	document.frmBulkPOListing.submit();
}
//END - 23-06-2011 - Listing functions