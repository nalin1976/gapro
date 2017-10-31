var pub_prossId = 0;
function ClosePopUp()
{
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}
}

function RemoveItem(obj){
	if(confirm('Are you sure you want to remove this item?'))
	{
		var rw = obj.parentNode.parentNode;
		var prossId	= document.getElementById('cboSearch').value;
		var chemiId	= rw.cells[1].id;
		var td = obj.parentNode;
		var tro = td.parentNode;
		tro.parentNode.removeChild(tro);
		
		
		var url = 'chemicalallocationdb.php?RequestType=RemoveItem&ProcessId='+prossId+ '&ChemiId='+chemiId;
		var xml_http = $.ajax({url:url,async:false});
	}
}

function LoadChemical(obj)
{
	var url = 'chemicalallocationmiddle.php?RequestType=LoadChemical&ProcessId='+obj;
	var xml_http = $.ajax({url:url,async:false});
	
	var XMLChemicalId 	= xml_http.responseXML.getElementsByTagName('ChemicalId');
	var XMLDesc 		= xml_http.responseXML.getElementsByTagName('ItemDescription');
	var XMLUnitId 		= xml_http.responseXML.getElementsByTagName('UnitId');
	var XMLUnit 		= xml_http.responseXML.getElementsByTagName('Unit');
	var XMLUnitPrice 	= xml_http.responseXML.getElementsByTagName('UnitPrice');
	$("#tblMain tr:gt(0)").remove();
	for(loop=0;loop<XMLChemicalId.length;loop++)
	{
		var chemicalId 	= XMLChemicalId[loop].childNodes[0].nodeValue;
		var desc 		= XMLDesc[loop].childNodes[0].nodeValue;
		var units 		= XMLUnit[loop].childNodes[0].nodeValue;
		var unitPrice 	= XMLUnitPrice[loop].childNodes[0].nodeValue;
		var unitId 	= XMLUnitId[loop].childNodes[0].nodeValue;
		CreateGrid(chemicalId,desc,units,unitPrice,unitId);
	}
}

function CreateGrid(chemicalId,desc,units,unitPrice,unitId)
{
	var tbl = document.getElementById('tblMain');
	var lastRow = tbl.rows.length;	
	var row = tbl.insertRow(lastRow);
	row.className = "bcgcolor-tblrowWhite";	
	
	var cell = row.insertCell(0);
	cell.className ="normalfntMid";
	cell.innerHTML ="<img src=\"../../../images/del.png\" alt=\"del\" onclick=\"RemoveItem(this);\" />";
	
	var cell = row.insertCell(1);
	cell.className ="normalfnt";
	cell.id=chemicalId;
	cell.innerHTML =desc;
	
	var cell = row.insertCell(2);
	cell.className ="normalfnt";
	cell.id=unitId;
	cell.innerHTML =units;
	
	var cell = row.insertCell(3);
	cell.className ="normalfnt";
	cell.innerHTML ="<input type=\"text\" name=\"txtUP\" id=\"txtUP\" style=\"width:72px;text-align:right\" value=\""+unitPrice+"\" onblur=\"UpdateRow(this);\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" onkeyup=\"checkfirstDecimal(this);\" onchange=\"checkLastDecimal(this);\"/>";
}

function OpenChemicalPopUp()
{
	pub_prossId	= document.getElementById('cboSearch').value;
	if(pub_prossId=="")
	{
		alert("Please select 'Process Name'.");
		document.getElementById('cboSearch').focus();
		return;
	}
	var url = 'chemicalpopup.php?ProssId='+pub_prossId;
	var xml_http = $.ajax({url:url,async:false});
	
	drawPopupArea(529,390,'frmChemicalpopup');				
	document.getElementById('frmChemicalpopup').innerHTML = xml_http.responseText;	
}

function AddToMainGrid()
{
	var tbl = document.getElementById('tblPopUp');
	var booCheck = false;
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			booCheck = true;
			var chemId		= tbl.rows[loop].cells[1].id;
			var unitId		= tbl.rows[loop].cells[2].id;
			var unitPrice	= tbl.rows[loop].cells[3].childNodes[0].value;
			var url = 'chemicalallocationdb.php?RequestType=AddToMainGrid&ChemId='+chemId+ '&UnitId='+unitId+ '&UnitPrice='+unitPrice+ '&ProssId='+pub_prossId;
			var xmlhttp = $.ajax({url:url,async:false});
		}
	}
	if(!booCheck)
	{
		alert("No selected item found. Please select at least one or more item/items.");
		return;
	}
		ClosePopUp();
		LoadChemical(pub_prossId);
}

function CheckAll(obj)
{
	var tbl = document.getElementById('tblPopUp');
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].checked = (obj.checked ? true:false);
	}
}

function UpdateRow(obj)
{
	var rw 		= obj.parentNode.parentNode;
	var prossId	= document.getElementById('cboSearch').value;
	var chemId	= rw.cells[1].id;
	var url = 'chemicalallocationdb.php?RequestType=UpdateRow&ChemId='+chemId+ '&UnitPrice='+obj.value+ '&ProssId='+prossId;
	var xmlhttp = $.ajax({url:url,async:false});
}

function SaveRow()
{
	alert("Updated successfully.");
}

function SearchChemical(obj,e)
{
	if(e.keyCode!=13)
		return;
	
	var url="chemicalallocationmiddle.php?RequestType=SearchChemical&id="+URLEncode(obj.value);
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('tblPopUp').innerHTML=htmlobj.responseText;
}

function checkfirstDecimal(obj){
	var d=obj.value.trim().charAt(0);	
	if(d=='.')
		obj.value=0;	
}

function checkLastDecimal(obj){
	var len=obj.value.trim().length;
	if(obj.value.trim().charAt(len-1)=='.')
			obj.value=obj.value.trim().substr(0,len-1);
}

function checkDecimals(obj){
	var d=obj.value.trim();	
	if(d.indexOf('.') > -1){
		//var c=d.charAt(d.indexOf('.'));
		obj.value=d.replace(/\./g,' ');
		obj.value=obj.value.trim();
	}
}