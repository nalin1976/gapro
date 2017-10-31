// JavaScript Document
mainArrayIndex 		= 0;
var Materials 		= [];
var pub_index       = 0;
var pub_mainRow     = 0;
var pub_serialNo	= 0;
var pub_serialYear	= 0;

function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
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
function OpenItemPopUp()
{
	/*var costcenter 	= document.getElementById('cboCostCenter').value;
	if(costcenter=="")
	{
		alert("Please select a 'Cost Center'.");
		document.getElementById('cboCostCenter').focus();
		return;
	}*/
	showBackGround('divBG',0);
	var url = "popupitem.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(566,532,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	fix_header('tblPopItem',550,407);	
}
function LoadPopItems()
{
	var url  = "chemicalAllocationXML.php?RequestType=URLLoadPopItems";
		url += "&MainCatId="+URLEncode(document.getElementById('cboPopMainCat').value.trim());
		url += "&SubCatId="+URLEncode(document.getElementById('cboPopSubCat').value.trim());
		url += "&ItemDesc="+URLEncode(document.getElementById('txtItemDesc').value);
		url += "&ItemCode="+URLEncode(document.getElementById('txtItemCode').value);
	htmlobj  = $.ajax({url:url,async:false});

	var XMLItemId 	 = htmlobj.responseXML.getElementsByTagName("ItemId");
	var XMLItemDesc	 = htmlobj.responseXML.getElementsByTagName("ItemDesc");
	var XMLUnit 	 = htmlobj.responseXML.getElementsByTagName("Unit");
	var tbl 		 = document.getElementById('tblPopItem');
	ClearTable('tblPopItem');
	for(loop=0;loop<XMLItemId.length;loop++)
	{
		var itemId   = XMLItemId[loop].childNodes[0].nodeValue;
		var itemDes  = XMLItemDesc[loop].childNodes[0].nodeValue;
		var Unit     = XMLUnit[loop].childNodes[0].nodeValue;
		
		CreatePopUpItemGrid(itemId,itemDes,Unit,tbl);
	}	
}
function CreatePopUpItemGrid(itemId,itemDes,Unit,tbl)
{
	var lastRow		 = tbl.rows.length;	
	var row 		 = tbl.insertRow(lastRow);
	row.className	 = "bcgcolor-tblrowWhite";
	
	var cell 		 = row.insertCell(0);
	cell.className 	 = "normalfntMid";
	cell.id 		 = itemId;
	cell.setAttribute('height','20');
	cell.innerHTML	 = "<input name=\"checkbox\" type=\"checkbox\" onclick=\"AddToMainPage();\">";
	
	var cell 		 = row.insertCell(1);
	cell.className   = "normalfnt";
	cell.id 		 = itemId;
	cell.innerHTML 	 = itemDes;
	
	var cell 		 = row.insertCell(2);
	cell.className   = "normalfnt";
	cell.innerHTML 	 = Unit;
}
function AddToMainPage()
{
	var tbl 		= document.getElementById('tblPopItem');
	var tblMain 	= document.getElementById('tblMain');
	ClearTable('tblMain');
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{	
			var matId 		= tbl.rows[loop].cells[0].id;
			var itemDesc 	= tbl.rows[loop].cells[1].childNodes[0].nodeValue;
			var units 		= tbl.rows[loop].cells[2].childNodes[0].nodeValue;
			
	
			CreadeMainGrid(tblMain,matId,itemDesc,units);
		}
	}
	//document.getElementById('cboCostCenter').disabled = true;
	CloseOSPopUp('popupLayer1');
}
function CreadeMainGrid(tblMain,matId,itemDesc,units)
{
	var booCheck = true;
	for(mainLoop=1;mainLoop<tblMain.rows.length;mainLoop++)
	{
		var mainMatId 	= tblMain.rows[mainLoop].cells[1].id;
		if(mainMatId==matId)
			booCheck = false;			
	}
	if(booCheck)
	{
		var lastRow 	= tblMain.rows.length;	
		var row 		= tblMain.insertRow(lastRow);
		row.className 	= "bcgcolor-tblrowWhite";
		
		var cell 		= row.insertCell(0);
		cell.className 	= "normalfntMid";
		cell.setAttribute('height','20');
		cell.id			= 0;
		cell.innerHTML 	= "<img alt=\"add\" src=\"../../images/del.png\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" >";
		
		var cell 		= row.insertCell(1);
		cell.className 	= "normalfnt";
		cell.id 		= matId;
		cell.innerHTML 	= itemDesc;
		
		var cell 		= row.insertCell(2);
		cell.className 	= "normalfntMid";
		cell.id			= units;
		cell.innerHTML 	= document.getElementById('comboUnit').innerHTML;
		
		var cell 		= row.insertCell(3);
		cell.className 	= "normalfntMid";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 81px; text-align: right;\" class=\"txtbox\"  value=\"0\" onkeyup=\"SetUnitPrice(this,"+mainArrayIndex+");\" >";
		
		var cell 		= row.insertCell(4);
		cell.className 	= "normalfntMid";
		cell.innerHTML 	=  "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 81px; text-align: right;\" class=\"txtbox\"  value=\"0\" onkeyup=\"SetChemQty(this,"+mainArrayIndex+");\" >";
		
		var cell 		= row.insertCell(5);
		cell.className 	= "normalfntMid";
		cell.innerHTML 	= "<img alt=\"add\" src=\"../../images/plus_16.png\" onclick=\"AddChemicals(this," + mainArrayIndex  + ")\">";
		
		/*var cell 		= row.insertCell(6);
		cell.className 	= "normalfntMid";
		cell.innerHTML 	= document.getElementById('comboGLCode').innerHTML;
		
		var cell 		= row.insertCell(7);
		cell.className 	= "normalfnt";
		cell.innerHTML 	="";*/
		
		row.cells[2].childNodes[0].value = units;
	
		var currentTime = new Date();
		var year 		= currentTime.getFullYear();
		var details = [];
		details[0] = matId; 	// Matdetail Id
		details[1] = units; 	// Unit
		details[2] = 0; 	// Unit price
		details[3] = 0; 	// stock Qty
		details[5] = 1+'/'+year; 		//GRN No
		details[6] = 0; 	// GL Id
		Materials[mainArrayIndex] = details;
		mainArrayIndex ++ ;
	}
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
function CheckPlusChemAll(obj,tbl)
{
	var tbl  = document.getElementById(tbl);
	if(obj.checked)
		var check = true;
	else 
		var check = false;
	for(i=1;i<tbl.rows.length;i++)	
	{
		tbl.rows[i].cells[4].childNodes[0].checked = check;
	}
}

function setGLDescription(obj,row)
{
	var url = "chemicalAllocationXML.php?RequestType=loadGLDescription&GLId="+obj.value;
	htmlobj = $.ajax({url:url,async:false});
	var tblMain = document.getElementById("tblMain");
	var index = parseFloat(row-1);

	
	var XMLGLDescription = htmlobj.responseXML.getElementsByTagName("GLDes")[0].childNodes[0].nodeValue;
	tblMain.rows[row].cells[7].innerHTML = XMLGLDescription;
	tblMain.rows[row].cells[6].id = obj.value;
	Materials[index][6] = obj.value;
}
function LoadSubCat(mainCatId)
{
	var url = "chemicalAllocationXML.php?RequestType=URLLoadSubCat&mainCatId="+mainCatId;
	htmlobj = $.ajax({url:url,async:false});
	var xml_http_obj	=$.ajax({url:url,async:false});	
	document.getElementById("cboPopSubCat").innerHTML = xml_http_obj.responseXML.getElementsByTagName('SubCat')[0].childNodes[0].nodeValue;
}
function AddChemicals(obj,index)
{
	showBackGround('divBG',0);
	var url = "plusChimicalAlloc.php?index="+index;
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(950,350,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	pub_mainRow = obj.parentNode.parentNode.rowIndex;
	pub_index   = index;

}
function SetQtyToArray(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var adjustQty 		= parseFloat(obj.value);
	var stockQty		= parseFloat(rw.cells[2].childNodes[0].nodeValue);
	rw.cells[4].childNodes[0].checked = true;
	
	if(adjustQty>stockQty)
	{
		obj.value 		= stockQty;
		adjustQty   	= stockQty;
	}
}
function checkEmptyQty(obj)
{
	var rw 				= obj.parentNode.parentNode;
	if(obj.value=="" || obj.value==0)
	{
		rw.cells[4].childNodes[0].checked = false;
		obj.value = 0;
	}
}
function SetUnitPrice(obj,index)
{
	
	Materials[index][2] = parseFloat(obj.value);
}
function SetChemQty(obj,index)
{
	Materials[index][3] = parseFloat(obj.value);
}
function setUnit(obj)
{
	var index			= parseFloat(obj.parentNode.parentNode.rowIndex);
	var rw				= obj.parentNode.parentNode;
	rw.cells[2].id      =  obj.value;
	Materials[index-1][1] = obj.value;
}
function checkAddQty(rw)
{
	if(rw.cells[3].childNodes[0].value=="" || rw.cells[3].childNodes[0].value==0)
	{
		alert("Please enter a qty");
		rw.cells[3].childNodes[0].focus();
		rw.cells[4].childNodes[0].checked = false;
	}
}
function addChemToMain()
{
	var tblPlusChem 	  = document.getElementById('tblPopPlusChimical');
	var tblMain			  = document.getElementById('tblMain');
	var boolChk 		  = false;
	var BinMaterials 	  = [];
	var mainBinArrayIndex = 0;		
	for(var i=1;i<tblPlusChem.rows.length;i++)
	{
		if(tblPlusChem.rows[i].cells[4].childNodes[0].checked)
		{
				boolChk = true;		
				var Bindetails = [];
				Bindetails[0]  = tblPlusChem.rows[i].cells[0].id; // matDetail Id
				Bindetails[1]  = tblPlusChem.rows[i].cells[1].childNodes[0].nodeValue; // Unit
				Bindetails[2]  = parseFloat(tblPlusChem.rows[i].cells[3].childNodes[0].value); // add Qty
				Bindetails[3]  = tblPlusChem.rows[i].cells[5].childNodes[0].nodeValue; // GRN No
				/*Bindetails[4]  = tblPlusChem.rows[i].cells[6].id; // GLAllowId
				Bindetails[5]  = tblPlusChem.rows[i].cells[7].id; // cost center id		*/							
				BinMaterials[mainBinArrayIndex] = Bindetails;
				mainBinArrayIndex ++ ;						
		}
	}
	if(boolChk==false)
	{
		alert("Please select a chemical to add.");
		return;
	}
	
	Materials[pub_index][4] = BinMaterials;				
	tblMain.rows[pub_mainRow].className = "osc2";
	tblMain.rows[pub_mainRow].cells[0].id = 1;
	CloseOSPopUp('popupLayer1');	
}
function SaveChemAllocation()
{
	showPleaseWait();
	var tblMain = document.getElementById('tblMain');
	document.getElementById('butSave').style.display = 'none';

	if(tblMain.rows.length<=1)
	{
		alert("No record to save.");
		document.getElementById('butSave').style.display = 'inline';
		hidePleaseWait();
		return;
	}
	for(var i=1;i<tblMain.rows.length;i++)
	{
		if(tblMain.rows[i].cells[2].id=="")
		{
			alert("Please select a unit.");
			tblMain.rows[i].cells[2].childNodes[0].focus();
			document.getElementById('butSave').style.display = 'inline';
			hidePleaseWait();
			return;
		}
		if(tblMain.rows[i].cells[3].childNodes[0].value==0 || tblMain.rows[i].cells[3].childNodes[0].value=="")
		{
			alert("Please enter a Unit Price.");
			tblMain.rows[i].cells[3].childNodes[0].focus();
			document.getElementById('butSave').style.display = 'inline';
			hidePleaseWait();
			return;
		}
		if(tblMain.rows[i].cells[4].childNodes[0].value==0 || tblMain.rows[i].cells[4].childNodes[0].value=="")
		{
			alert("Please enter a Qty.");
			tblMain.rows[i].cells[4].childNodes[0].focus();
			document.getElementById('butSave').style.display = 'inline';
			hidePleaseWait();
			return;
		}
		/*if(tblMain.rows[i].cells[6].id=="")
		{
			alert("Please select a GL Code.");
			tblMain.rows[i].cells[6].childNodes[0].focus();
			document.getElementById('butSave').style.display = 'inline';
			hidePleaseWait();
			return;
		}*/
		if(tblMain.rows[i].cells[0].id==0)
		{
			alert("cannot save without allocationg any chemicals \nPlease allocate at least one chemical to Line No "+i);
			document.getElementById('butSave').style.display = 'inline';
			hidePleaseWait();
			return;
		}
	}
	getNewSerialNo();
	
}
function getNewSerialNo()
{
	var url  = "chemicalAllocationXML.php?RequestType=URLGetNewSerialNo";
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLAdmin	= htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
	var XMLNo 		= htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
	
	if(XMLAdmin=="TRUE" && XMLNo!='')
	{

		var XMLYear 	= htmlobj.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
		pub_serialNo 	= parseInt(XMLNo);
		pub_serialYear 	= parseInt(XMLYear);
		document.getElementById("txtSerialNo").value = pub_serialYear + "/" + pub_serialNo;		
		SaveHeader();	
	}
	else
	{
		alert("Please contact system administrator to assign new Return No.");
		document.getElementById('butSave').style.display = 'inline';
		hidePleaseWait();
	}
}
function SaveHeader()
{
	//var costCenter = document.getElementById('cboCostCenter').value;
	var url  = "chemicalAllocationXML.php?RequestType=URLSaveHeader";
	    url += "&SerialNo="+pub_serialNo;
		url += "&SerialYear="+pub_serialYear;
		//url += "&costCenter="+costCenter;
	htmlobj = $.ajax({url:url,async:false});
	if(htmlobj.responseText=="saved")
	{
		SaveDetail();
	}
	else
	{
		alert("Header saving Error.");
		hidePleaseWait();
		document.getElementById('butSave').style.display = 'inline';
		return;
	}
}
function SaveDetail()
{
	var booCheck = true;
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{	
		var details = Materials[loop] ;
		if 	(details!=null)
		{			
			var tarMatId 		= details[0]; 	// Matdetail Id
			var tarUnit			= details[1];	// Unit
			var tarUnitPrice 	= details[2];	// unit price
			var tarQty      	= details[3];	// qty
			var binArray 		= details[4];	
			//var tarGLId			= details[6]; 	// GL Id
			
			var url  = "chemicalAllocationXML.php?RequestType=URLSaveDetail";
				url += "&SerialNo="+pub_serialNo;
				url += "&SerialYear="+pub_serialYear;
				url += "&tarMatId="+tarMatId;
				url += "&tarUnit="+URLEncode(tarUnit);
				url += "&tarUnitPrice="+tarUnitPrice;
				url += "&tarQty="+tarQty;
				//url += "&tarGLId="+tarGLId;
				//url += "&costCenter="+costCenter;
			htmlobj = $.ajax({url:url,async:false});
			if(htmlobj.responseText=="savedDetail")
			{
				for (i = 0; i < binArray.length; i++)
				{
						var Bindetails 		= binArray[i];
						var srcMatId 		= Bindetails[0];  // Mat Id
						var SrcUnit			= Bindetails[1];  // Unit
						var SrcQty			= Bindetails[2];  // Qty
						var SrcgrnNo		= Bindetails[3];  // GRN No
						//var SrcGLId			= Bindetails[4]; // GLAllowId
						//var SrcCostCenter	= Bindetails[5]; // Cost center id
					
					var url  = "chemicalAllocationXML.php?RequestType=URLSaveSubDetail";
						url += "&SerialNo="+pub_serialNo;
						url += "&SerialYear="+pub_serialYear;
						url += "&tarMatId="+tarMatId;
						url += "&srcMatId="+srcMatId;
						url += "&SrcUnit="+URLEncode(SrcUnit);
						url += "&SrcQty="+SrcQty;
						url += "&SrcgrnNo="+SrcgrnNo;
						//url += "&SrcGLId="+SrcGLId;
						//url += "&costCenter="+SrcCostCenter;
					htmlobj = $.ajax({url:url,async:false});
					if(htmlobj.responseText=="error")
					{
						booCheck = false;
						alert("Sub Detail saving error.");
						hidePleaseWait();
						document.getElementById('butSave').style.display = 'inline';
						return;	
					}
			
				}
			}
			else
			{
				alert("Detail saving error");
				hidePleaseWait();
				document.getElementById('butSave').style.display = 'inline';
				return;
			}
		}
	}
	if(booCheck)
	{
		alert("Saved Successfully.");
		hidePleaseWait();
	}
}
function ClearForm()
{
	location.href = "chemicalAllocation.php";
}

function ViewReport()
{
		var issueNo = document.getElementById('txtSerialNo').value;
	if(issueNo=="" || issueNo=="0")
	{
	 alert("No Chemical Allocation No to preview.");
	 return;
	}
	else
	{	
		
		newwindow=window.open('chemicalallocationRpt.php?issueNo='+issueNo,'name');
		if (window.focus) {newwindow.focus()}
	}
}