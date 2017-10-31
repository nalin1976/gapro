// JavaScript Documentvar 
mainArrayIndex 		= 0;
var Materials 			= [];
var pub_index			= 0;
var pub_mainRw			= 0;
var pub_serialNo 		= 0;
var pub_serialYear 		= 0;
var validateCount		= 0;
var validateBinCount	= 0;
var pubTotReturnQty		= 0;
var pubTotPlusQty		= 0;

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
	document.frmGeneralStockAdjestment.reset();
	ClearTable('tblMain');
	Materials = [];
	mainArrayIndex 	= 0;
	document.getElementById('cboCostCenter').disabled = false;
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
	var costcenter 	= document.getElementById('cboCostCenter');

if(!Validate('OpenItemPopUp',costcenter))
		return;
			
	showBackGround('divBG',0);
	var url = "popupitem.php";
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(566,532,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	fix_header('tblPopItem',550,388);	
}

function Validate(obj0,obj1,obj2,obj3,obj4,obj5)
{
	if(obj0=='OpenItemPopUp')
	{
		if(obj1.value=="")
		{
			alert("Please select 'Cost Center'.");
			obj1.focus();
			return false;
		}
	}
	if(obj0=='AddBins')
	{
		if(obj1.value=="")
		{
			alert("Please select 'Cost Center'.");
			obj1.focus();
			return false;
		}
		if(obj2.value=="0")
		{
			alert("'Adjust Qty' should be more than 0.");
			obj2.select();
			return false;
		}
		if(obj3.value=="0" && obj4=='+')
		{
			alert("Please enter 'Unitprice'.");
			obj3.select();
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
			if(obj1.rows[loop].cells[7].childNodes[0].value==0)	
			{
				alert("Cannot save with 0 adjust qty in Line No : "+[loop]+".");
				obj1.rows[loop].cells[7].childNodes[0].focus();
				return;
			}
			if(obj1.rows[loop].cells[5].childNodes[0].value==0 && obj1.rows[loop].cells[8].childNodes[0].value=='+')	
			{
				alert("Cannot save with 0 unit price in Line No : "+[loop]+".");
				obj1.rows[loop].cells[5].childNodes[0].focus();
				return;
			}
		}
	}
return true;
}
function LoadSubCat(mainCatId)
{
	var url = "genstockadjustXML.php?RequestType=URLLoadSubCat&mainCatId="+mainCatId;
	htmlobj = $.ajax({url:url,async:false});
	var xml_http_obj	=$.ajax({url:url,async:false});	
	document.getElementById("cboPopSubCat").innerHTML = xml_http_obj.responseXML.getElementsByTagName('SubCat')[0].childNodes[0].nodeValue;
}
function LoadPopItems()
{
	var url  = "genstockadjustXML.php?RequestType=URLLoadPopItems";
		url += "&MainCat="+document.getElementById('cboPopMainCat').value;
		url += "&SubCat="+document.getElementById('cboPopSubCat').value;
		url += "&ItemDesc="+URLEncode(document.getElementById('txtDesc').value.trim());
		url += "&ItemCode="+URLEncode(document.getElementById('txtItemCode').value.trim());
	htmlobj=$.ajax({url:url,async:false});
	CreatePopUpItemGrid(htmlobj);
}

function CreatePopUpItemGrid(htmlobj)
{
	var XMLItemId 		= htmlobj.responseXML.getElementsByTagName("ItemId");
	var XMLItemDesc	 	= htmlobj.responseXML.getElementsByTagName("ItemDesc");
	var XMLUnit 		= htmlobj.responseXML.getElementsByTagName("Unit");
	var XMLmainCat 		= htmlobj.responseXML.getElementsByTagName("mainCategory");
	var XMLsubCat 		= htmlobj.responseXML.getElementsByTagName("subCategory");
	var XMLmainCatId 	= htmlobj.responseXML.getElementsByTagName("mainCatId");
	var tbl 			= document.getElementById('tblPopItem');
	ClearTable('tblPopItem');
	for(loop=0;loop<XMLItemId.length;loop++)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
		
		var cell = row.insertCell(0);
		cell.className ="normalfntMid";
		cell.id = XMLmainCat[loop].childNodes[0].nodeValue+'/'+XMLmainCatId[loop].childNodes[0].nodeValue;
		cell.setAttribute('height','20');
		cell.innerHTML = "<input name=\"checkbox\" type=\"checkbox\">";
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.id = XMLItemId[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLItemDesc[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.id = XMLsubCat[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLUnit[loop].childNodes[0].nodeValue;
	}
}

function AddToMainPage()
{
	var tbl 	= document.getElementById('tblPopItem');
	var tblMain = document.getElementById('tblMain');
	var costcenter = document.getElementById('cboCostCenter').value;
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
				
				var matId 		= tbl.rows[loop].cells[1].id;
				var itemDesc 	= tbl.rows[loop].cells[1].childNodes[0].nodeValue;
				var units 		= tbl.rows[loop].cells[2].childNodes[0].nodeValue;
				var mainCat 	= tbl.rows[loop].cells[0].id;
				var subCat 		= tbl.rows[loop].cells[2].id;
				
				var url = "genstockadjustXML.php?RequestType=getStockQty&matId="+matId+"&costcenter="+costcenter;
				htmlobj = $.ajax({url:url,async:false});
				var XMLStockQty = htmlobj.responseXML.getElementsByTagName("stockQty")[0].childNodes[0].nodeValue;
				CreadeMainGrid(tblMain,matId,itemDesc,units,XMLStockQty,mainCat,subCat);
			
		}
	}
	//CloseOSPopUp('popupLayer1');
	document.getElementById('cboCostCenter').disabled = true;
}

function CreadeMainGrid(tbl,matId,itemDesc,units,stockQty,mainCat,subCat)
{

	var booCheck = true;
	for(mainLoop=1;mainLoop<tbl.rows.length;mainLoop++)
	{
		var mainMatId 	= tbl.rows[mainLoop].cells[3].id;
		if(mainMatId==matId)
			booCheck = false;			
	}
	if(booCheck)
	{
		mainCatArry = mainCat.split('/');
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className 	= "bcgcolor-tblrowWhite";
		
		var cell 		= row.insertCell(0);
		cell.className 	= "normalfntMid";
		cell.setAttribute('height','20');
		cell.id			= 0;
		cell.innerHTML 	= "<img alt=\"add\" src=\"../../images/del.png\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" >";
		
		var cell 		= row.insertCell(1);
		cell.className 	= "normalfnt";
		cell.id 		= mainCatArry[1];
		cell.innerHTML 	= mainCatArry[0];
		
		var cell 		= row.insertCell(2);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= subCat;
		
		var cell 		= row.insertCell(3);
		cell.className 	= "normalfnt";
		cell.id 		= matId;
		cell.innerHTML 	= itemDesc;
		
		var cell 		= row.insertCell(4);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= units;
		
		var cell 		= row.insertCell(5);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 81px; text-align: right;\" class=\"txtbox\"  value=\"0\" onkeyup=\"SetDetialsToArray(this,"+mainArrayIndex+");\">";
		
		var cell 		= row.insertCell(6);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= stockQty;
		
		var cell 		= row.insertCell(7);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 81px; text-align: right;\" class=\"txtbox\"  value=\"0\" onblur=\"setQty(this,"+mainArrayIndex+")\" onkeyup=\"SetQtyToArray(this,"+mainArrayIndex+");\">";
		
		var cell 		= row.insertCell(8);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<select name=\"cboMark\" id=\"cboMark\" class=\"txtbox\" style=\"width:40px\" onchange=\"SetMarkToArray(this,"+mainArrayIndex+");setLocation(this.value,this,"+mainArrayIndex+");\">"+
							"<option value=\"+\">+</option>"+
							"<option value=\"-\">-</option>"+
						  "</select>";
		var mark		= document.getElementById("cboMark").value;
		
		var cell 		= row.insertCell(9);
		cell.className 	= "normalfntMid";
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
function setLocation(mark,obj,mainArrayIndex)
{
	var rw				= obj.parentNode.parentNode;
	var tbl				= document.getElementById("tblMain");
	if(mark=='-')
	{
		rw.cells[9].innerHTML = "<img alt=\"add\" src=\"../../images/plus_16.png\" onclick=\"AddBins(this," + mainArrayIndex  + ")\">";
		rw.cells[0].id = 0;
		rw.className = "bcgcolor-tblrowWhite";
		
	}
	else
	{
		rw.cells[9].innerHTML ="<img alt=\"add\" src=\"../../images/plus_16.png\" onclick=\"AddBins(this," + mainArrayIndex  + ")\">";
		rw.cells[0].id = 0;
		rw.className = "bcgcolor-tblrowWhite";
	}
}
function SetQtyToArray(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var adjustQty 		= parseFloat(obj.value);
	var stockQty		= parseFloat(rw.cells[6].childNodes[0].nodeValue);
	var adjMark			= rw.cells[8].childNodes[0].value;

	if(adjMark=='-')
	{
		if(adjustQty>stockQty)
		{
			obj.value 	= stockQty;
			adjustQty	= stockQty;
		}
	}
	Materials[index][3] = adjustQty;
	if(adjMark=='-')
	{
		rw.cells[0].id 	= 0;
		rw.className 		= "bcgcolor-tblrowWhite";
	}
}
function setQty(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var adjustQty 		= obj.value;
	var adjMark			= rw.cells[8].childNodes[0].value;
	if(adjustQty=="")
	{
		obj.value 	= 0;
		adjustQty	= 0;
	}
	if(adjMark=='-')
	{
		rw.cells[0].id 	= 0;
		rw.className 		= "bcgcolor-tblrowWhite";
	}
	Materials[index][3] = adjustQty;
}

function SetMarkToArray(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var adjustQty 		= parseFloat(rw.cells[7].childNodes[0].value);
	var stockQty		= parseFloat(rw.cells[6].childNodes[0].nodeValue);
	var adjMark			= rw.cells[m_adj].childNodes[0].value;
	rw.cells[7].childNodes[0].value 	= 0;
	if(adjMark=='-')
	{
		if(adjustQty>stockQty)
		{
			rw.cells[7].childNodes[0].value 	= stockQty;
		}
	}
	Materials[index][4] = obj.value;
	rw.cells[0].id 	= 0;
	rw.className 		= "bcgcolor-tblrowWhite";
}

function SetDetialsToArray(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var unitprice 		= parseFloat(rw.cells[5].childNodes[0].value);
	
	Materials[index][7] = unitprice;
}

function AddBins(obj,index)
{
	var rw 			= obj.parentNode.parentNode;
	pub_index		= index;
	pub_mainRw 		= obj.parentNode.parentNode.rowIndex;
	var costCenter	= document.getElementById('cboCostCenter');
	var matId		= rw.cells[3].id;
	var adjestQty	= rw.cells[7].childNodes[0];
	var adjestM		= rw.cells[8].childNodes[0].value;
	var unitprice	= rw.cells[6].childNodes[0];
	var mainCatId	= rw.cells[1].id;
	
	if(!Validate('AddBins',costCenter,adjestQty,unitprice,adjestM))
		return;
	if(adjestM=='-')
	{	
		showBackGround('divBG',0);
		var url  = "popupbin.php?MatId="+matId;
			url += "&costCenter="+costCenter.value;
			url += "&AdjustQty="+adjestQty.value;
			url += "&AdjestM="+URLEncode(adjestM);
		htmlobj=$.ajax({url:url,async:false});
		drawPopupBox(950,250,'frmPopItem',1);
		document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
		fix_header('tblPopItem',550,388);	
		pubTotReturnQty = parseFloat(adjestQty.value);
	}
	else if(adjestM=='+')
	{
		showBackGround('divBG',0);
		var url  = "popupplusbin.php?MatId="+matId;
			url += "&costCenter="+costCenter.value;
			url += "&AdjustQty="+adjestQty.value;
			url += "&AdjestM="+URLEncode(adjestM);
			url += "&mainCatId="+mainCatId;
		htmlobj=$.ajax({url:url,async:false});
		drawPopupBox(450,250,'frmPopItem',1);
		document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
		fix_header('tblPopItem',550,388);	
		pubTotReturnQty = parseFloat(adjestQty.value);
	}
}

function SetBinItemQuantity(obj)
{	
	var tblMain =document.getElementById("tblMain");				
	var tblBin = document.getElementById('tblBinItem');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPLoopQty = 0;	
	
	for (loop =2; loop < tblBin.rows.length; loop++)
	{
		if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){		
				GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value);
		}	
	}
	
	if (GPLoopQty == totReqQty )
	{	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 2 ;loop < tblBin.rows.length ; loop ++ ){
				if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked){					
						var Bindetails = [];
							Bindetails[0] =   parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value); // issueQty
							Bindetails[1] =   tblBin.rows[loop].cells[3].id; // MainStores
							Bindetails[2] =   tblBin.rows[loop].cells[4].childNodes[0].nodeValue; // Unit
							Bindetails[3] =   tblBin.rows[loop].cells[5].childNodes[0].nodeValue; // GRN No
							Bindetails[4] =   tblBin.rows[loop].cells[6].childNodes[0].nodeValue; // GRN Year
							Bindetails[5] =   tblBin.rows[loop].cells[7].id; // GLAllowId										
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
	var tblMain =document.getElementById("tblMain");				
	var tblBin = document.getElementById('tblBinItem');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPLoopQty = 0;	
	
	for (loop =2; loop < tblBin.rows.length; loop++)
	{
		if (tblBin.rows[loop].cells[1].childNodes[0].childNodes[1].checked)
		{		
				GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[0].childNodes[0].value);
		}	
	}
	
	if (GPLoopQty == totReqQty )
	{	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 2 ;loop < tblBin.rows.length ; loop ++ )
			{
				if (tblBin.rows[loop].cells[1].childNodes[0].childNodes[1].checked)
				{					
						var Bindetails = [];
							Bindetails[0] =   parseFloat(tblBin.rows[loop].cells[0].childNodes[0].value); // issueQty
							Bindetails[1] =   tblBin.rows[loop].cells[0].id; // MainStores
							Bindetails[2] =   0; // Unit
							Bindetails[3] =   0; // GRN No
							Bindetails[4] =   0;// GRN Year
							Bindetails[5] =   tblBin.rows[loop].cells[2].id; // GLAllowId										
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
		alert ("Return qty must equal with Total Issue Qty. \n Total Issue Qty =" + GPLoopQty + "\n Return Qty =" + totReqQty +"\n Variance is =" +(totReqQty-GPLoopQty));
		return false;
	}	
}


function SaveOpenStock()
{
	document.getElementById('butSave').style.display = 'none';
	var no 	= document.getElementById('txtSerialNo');
	var tbl = document.getElementById('tblMain');
	var costCenterId = document.getElementById('cboCostCenter').value;
	if(!Validate('SaveOpenStock',tbl))
	{
		document.getElementById('butSave').style.display = 'inline';
		return;
	}
	
	if(no.value=="")
	{
		GetNewSerialNo();
		SaveHeader();
		SaveDetails(costCenterId,tbl);
	}
	else
	{
		no 				= no.value.split("/");
		pub_serialNo 	= parseInt(no[1]);
		pub_serialYear 	= parseInt(no[0]);
		SaveHeader();
		SaveDetails(costCenterId,tbl);
	}
	//alert("Saved successfully.");
	ClearForm();
}

function GetNewSerialNo()
{
	var url  = "genstockadjustXML.php?RequestType=URLGetNewSerialNo";
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
	var url  = "genstockadjustXML.php?RequestType=URLSaveHeader";
	    url += "&SerialNo="+pub_serialNo;
		url += "&SerialYear="+pub_serialYear;
	htmlobj=$.ajax({url:url,async:false});
}

function SaveDetails(costCenterId,tbl)
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
			var Units       = details[2];
			var unitprice	= details[7]; 	// unitprice
			validateCount++;
			if(ajMark=='-')		
			{
				for (i = 0; i < binArray.length; i++)
				{
					
					
						var Bindetails 		= binArray[i];
						var binQty 			= Bindetails[0];  // issueQty
						var mainStoreId		= Bindetails[1];  // MainStores
						var Unit			= Bindetails[2];  // Unit
						var grnNo			= Bindetails[3];  // GRN No
						var grnYear			= Bindetails[4]; // GRN Year
						var GLAllowId		= Bindetails[5]; // GLAllowId
						
						var url='genstockadjustXML.php?RequestType=URLSaveDetails&SerialNo=' +pub_serialNo+ '&SerialYear=' +pub_serialYear+ '&matId=' +URLEncode(matId)+ '&ajMark=' +URLEncode(ajMark)+ '&unitprice=' +unitprice+ '&binQty=' +binQty+ '&mainStoreId=' +mainStoreId+ '&Unit=' +URLEncode(Unit)+ '&grnNo=' +grnNo+ '&grnYear='+grnYear+ '&costCenterId='+costCenterId+ '&GLAllowId='+GLAllowId;
					
					var htmlobj = $.ajax({url:url,async:false});
					if(htmlobj.responseText=="Error")
					{
						booCheck = false;	
					}
				}
			}
			else
			{
				for (i = 0; i < binArray.length; i++)
				{
					var Bindetails 		= binArray[i];
					var binQty 			= Bindetails[0];  // issueQty
					var mainStoreId		= 0 ;  // MainStores
					//var Unit			= Bindetails[2];  // Unit
					var grnNo			= 1 ;  // GRN No
					var grnYear			= pub_serialYear; // GRN Year
					var GLAllowId		= Bindetails[5]; // GLAllowId
					
					var url='genstockadjustXML.php?RequestType=URLSaveDetails&SerialNo=' +pub_serialNo+ '&SerialYear=' +pub_serialYear+ '&matId=' +URLEncode(matId)+ '&ajMark=' +URLEncode(ajMark)+ '&unitprice=' +unitprice+ '&binQty=' +binQty+ '&mainStoreId=' +mainStoreId+ '&Unit=' +URLEncode(Units)+ '&grnNo=' +grnNo+ '&grnYear='+grnYear+ '&costCenterId='+costCenterId+ '&GLAllowId='+GLAllowId;
					
					var htmlobj = $.ajax({url:url,async:false});
					if(htmlobj.responseText=="Error")
					{
						booCheck = false;	
					}
				}
			}
			
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
function validatePlusQty(obj)
{
	var totPlusQty = 0;
	var tblPlus    = document.getElementById('tblBinItem'); 	
	var rw 		   = obj.parentNode.parentNode;
	var reqQty	   = parseFloat(obj.value=="" ? 0:obj.value);
	var totQty     = parseFloat(document.getElementById("txtReqQty").value);
	
	for(var i=2;i<tblPlus.rows.length;i++)
	{
		totPlusQty += parseFloat(tblPlus.rows[i].cells[0].childNodes[0].value);
	}
	rw.cells[1].childNodes[0].childNodes[1].checked = true;
	if(reqQty==0)
	{
		rw.cells[1].childNodes[0].childNodes[1].checked = false;	
	}
	if(totPlusQty>totQty)
	{
		var newQty = parseFloat(totPlusQty-reqQty);
		obj.value  = totQty-newQty;
		if(obj.value==0)
		{
			rw.cells[1].childNodes[0].childNodes[1].checked = false;	
		}
	}
	else
	{
		obj.value = reqQty;
	}
}
function checkStockQty(obj)
{
	var rw = obj.parentNode.parentNode.parentNode;
	if(obj.checked)
	{
		if(rw.cells[0].childNodes[0].value==0 || rw.cells[0].childNodes[0].value=="")
		{
			rw.cells[1].childNodes[0].childNodes[1].checked = false;	
		}
	}
}