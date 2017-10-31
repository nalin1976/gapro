function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
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

function OpenItemPopUp()
{
	/*if(!Validate_OpenItemPopUp())
		return;*/
	showBackGround('divBG',0);
	var url  = "popupitem.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(572,504,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	fix_header('tblPopItem',550,388);
}

function LoadPopItems()
{
	var url  = "bookingxml.php?RequestType=URLLoadPopItems";
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
		cell.innerHTML = "<input name=\"checkbox\" type=\"checkbox\" onclick=\"AddDetailsToMainTbl(this)\">";
		
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
	 	pub_mainCat = rw.cells[0].id;
		
	var url  = "bookingxml.php?RequestType=URLLoadDetailsToItemTbl";
		url += "&ItemId="+itemId;
		//url += "&CostCenter="+document.getElementById('cboCostCenter').value;;
	var htmlobj=$.ajax({url:url,async:false});	
	
	var XMLItemId 		= htmlobj.responseXML.getElementsByTagName("ItemId");
		
	for(loop=0;loop<XMLItemId.length;loop++)
	{
		var XMLItemId 		= htmlobj.responseXML.getElementsByTagName("ItemId")[loop].childNodes[0].nodeValue;
		var XMLItemDesc 	= htmlobj.responseXML.getElementsByTagName("ItemDesc")[loop].childNodes[0].nodeValue;
		
		CreateMainItemTbl(XMLItemId,XMLItemDesc);
	}
}

function CreateMainItemTbl(XMLItemId,XMLItemDesc)
{
	var tbl 			= document.getElementById('tblItemMain');
	
	var lastRow		= tbl.rows.length;	
	var row 		= tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(0);
	cell.className 	= "normalfnt";
	cell.id 		= XMLItemId;
	cell.innerHTML 	= "<input type=\"text\" style=\"width:150px;text-align:right\" class=\"txtbox\" maxlength=\"10\" value=\"\"/>";
	
	var cell 		= row.insertCell(1);
	cell.className 	= "normalfnt";
	cell.id 		= XMLItemId;
	cell.innerHTML 	= "<input type=\"text\" style=\"width:150px;text-align:right\" class=\"txtbox\" maxlength=\"10\" value=\"\"/>";
	
	var cell 		= row.insertCell(2);
	cell.className 	= "normalfnt";
	cell.id 		= XMLItemId;
	cell.noWrap 	= 'nowrap';
	cell.innerHTML 	= "<input name=\"txtDateFrom\" type=\"text\" tabindex=\"9\" class=\"txtbox\" id=\"txtDateFrom\" style=\"width:100px\"  onmousedown=\"DisableRightClickEvent()\" onmouseout=\"EnableRightClickEvent()\" onfocus=\"return showCalendar(this.id, '%d/%m/%Y');\" onkeypress=\"return ControlableKeyAccess(event);\" onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\"\"/><input name=\"reset1\" type=\"text\" class=\"txtbox\" style=\"visibility:hidden;width:1px\" onclick=\"return showCalendar(this.id, '%d/%m/%Y');\"/>";
	
	var cell 		= row.insertCell(3);
	cell.className 	= "normalfnt";
	cell.id 		= XMLItemId;
	cell.noWrap 	= 'nowrap';
	cell.innerHTML 	= "<input name=\"txtDateFrom\" type=\"text\" tabindex=\"9\" class=\"txtbox\" id=\"txtDateFrom\" style=\"width:100px\"  onmousedown=\"DisableRightClickEvent()\" onmouseout=\"EnableRightClickEvent()\" onfocus=\"return showCalendar(this.id, '%d/%m/%Y');\" onkeypress=\"return ControlableKeyAccess(event);\" onclick=\"return showCalendar(this.id, '%d/%m/%Y');\" value=\"\"/><input name=\"reset1\" type=\"text\" class=\"txtbox\" style=\"visibility:hidden;width:1px\" onclick=\"return showCalendar(this.id, '%d/%m/%Y');\"/>";
	
	var cell 		= row.insertCell(4);
	cell.className 	= "normalfnt";
	cell.id 		= XMLItemId;
	cell.innerHTML 	= XMLItemDesc;
	
	var cell 		= row.insertCell(5);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" style=\"width:100px;text-align:right\" class=\"txtbox\" maxlength=\"10\" value=\"\"/>";
	
	var cell 		= row.insertCell(6);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" style=\"width:100px;text-align:right\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value,1,event);\" maxlength=\"10\" value=\"\" onkeyup=\"CalculateRowValue(this.parentNode.parentNode.rowIndex)\"/>";
	
	var cell 		= row.insertCell(7);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<input type=\"text\" style=\"width:100px;text-align:right\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal(this.value,1,event);\" maxlength=\"10\" value=\"\" onkeyup=\"CalculateRowValue(this.parentNode.parentNode.rowIndex)\"/>";
}

function LoadSubCategory(obj)
{
	var url  = "bookingxml.php?RequestType=URLLoadSubCategory";
		url += "&MainCat="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboPopSubCat').innerHTML = htmlobj.responseText;
}