var xmlHttp=[];
var xmlHttp1=[];
var xmlHttp3;
var pub_TotalYrd = 0;
var pub_TotalQty = 0;
var pub_printWindowNo=0;
// ************************************** Trim Function ***************************
function trim(str) {
	return ltrim(rtrim(str, ' '), ' ' );
}
 
function ltrim(str) {
	chars = ' '  || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str) {
	chars = ' ' || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}
// ************************************** End Of Trim Function ********************

// ************************************** Define xmlHttp Object *******************
function createXmlHttpObject(index)
{
 xmlHttp[index]=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp[index]=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp[index]=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp[index]=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
//return xmlHttp;
}
// ************************************** Define xmlHttp Object *******************
function createXmlHttpObject1(index)
{
 xmlHttp1[index]=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp1[index]=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
//return xmlHttp;
}

function createXmlHttpObject3() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp3 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp3 = new XMLHttpRequest();
    }
}
// ************************************** End of line xmlHttp Object *******************

function styleChange(itemNo)
{
	
	loadFabric(itemNo);
	loadBuyerPo();
	getMerchandiser();
}
function fabricChange(strColor)
{
	loadColor(strColor);
	loadWidth();
}
function buyerPoChange()
{
	loadColor();
	loadWidth();
	document.getElementById("txtBuyerPoNo").value=document.getElementById("cboBuyerPoNo").value;
}

function colorChange()
{
		loadWidth();
		getRatioQty();
}
function widthChange()
{
		document.getElementById("txtWidth").value=document.getElementById("cboWidth").value;
}

//////////////////////// LOAD FABRIC ////////////////////////
function loadFabric(itemNo)
{
	createXmlHttpObject(0);
	var strStyleId = document.getElementById("cboStyle").value;
	
    xmlHttp[0].onreadystatechange = loadFabricRequest;
	var url = 'cad-xml.php?id=loadFabric&styleId='+strStyleId;
	xmlHttp[0].id = itemNo;
    xmlHttp[0].open("GET", url, true);
    xmlHttp[0].send(null); 	
	
}
function loadFabricRequest()
{
	if(xmlHttp[0].readyState==4 && xmlHttp[0].status ==200)
	{
		var rText = xmlHttp[0].responseText;	
		document.getElementById("cboFabric").innerHTML = rText ;
		var itemNo = xmlHttp[0].id;
		if (itemNo>0)
		{
			document.getElementById("cboFabric").value=itemNo;
			document.getElementById("cboFabric").onchange();
		}
	}
}
///////////////////////// END OF LOAD FABRIC ////////////////////

//////////////////////// LOAD COLOR ////////////////////////
function loadColor(strColor)
{
	var strStyleId = document.getElementById("cboStyle").value;
	var strFabric = document.getElementById("cboFabric").value;
	var strBuyerPo = document.getElementById("cboBuyerPoNo").value;

//	alert(strFabric);
	strBuyerPo = strBuyerPo.replace(/#/gi,"***");
	
	createXmlHttpObject(1);
    xmlHttp[1].onreadystatechange = loadColorRequest;
	var url = 'cad-xml.php?id=loadColor&strStyleId='+strStyleId+'&FabricId='+strFabric+'&strBuyerPo='+strBuyerPo;
	xmlHttp[1].id = strColor;
    xmlHttp[1].open("GET", url, true);
    xmlHttp[1].send(null); 	

}
function loadColorRequest()
{
	if(xmlHttp[1].readyState==4 && xmlHttp[1].status ==200)
	{
		var rText = xmlHttp[1].responseText;	
		document.getElementById("cboColor").innerHTML = rText ;
		var strColor = xmlHttp[1].id;
		if(strColor!='')
		{
			document.getElementById("cboColor").value=strColor;
			document.getElementById("cboColor").onchange();
		}
	}
}
///////////////////////// END OF LOAD COLOR ////////////////////
//////////////////////// LOAD BUYER PO ////////////////////////

function loadBuyerPo()
{
	var strStyleId = document.getElementById("cboStyle").value;
	
	createXmlHttpObject(2);
    xmlHttp[2].onreadystatechange = loadBuyerPoRequest;
	var url = 'cad-xml.php?id=loadBuyerPo&styleId='+strStyleId;
    xmlHttp[2].open("GET", url, true);
    xmlHttp[2].send(null); 	
}
function loadBuyerPoRequest()
{
	if(xmlHttp[2].readyState==4 && xmlHttp[2].status ==200)
	{
		var rText = xmlHttp[2].responseText;	
		document.getElementById("cboBuyerPoNo").innerHTML = rText ;
		document.getElementById("txtBuyerPoNo").value = document.getElementById("cboBuyerPoNo").value;
	}
}
///////////////////////// END OF BUYER PO ////////////////////

//////////////////////// LOAD WIDTH ////////////////////////
function loadWidth()
{
	var strStyleId = document.getElementById("cboStyle").value;
	var strFabric = document.getElementById("cboFabric").value;
	var strColor = document.getElementById("cboColor").value;
	
	createXmlHttpObject(3);
    xmlHttp[3].onreadystatechange = loadWidthRequest;
	var url = 'cad-xml.php?id=loadWidth&styleId='+strStyleId+'&strFabric='+strFabric+'&strColor='+strColor;
    xmlHttp[3].open("GET", url, true);
    xmlHttp[3].send(null); 	
}

function loadWidthRequest()
{
	if(xmlHttp[3].readyState==4 && xmlHttp[3].status ==200)
	{
		var rText = xmlHttp[3].responseText;	
		document.getElementById("cboWidth").innerHTML = rText ;

	}
}
///////////////////////// END OF BUYER PO ////////////////////////////////////

//////////////////////// GET MERCHANDISER USING STYLE ////////////////////////
function getMerchandiser()
{
	var strStyleId = document.getElementById("cboStyle").value;
	
	createXmlHttpObject(4);
    xmlHttp[4].onreadystatechange = getMerchandiserRequest;
	var url = 'cad-xml.php?id=getUserByStyle&styleId='+strStyleId;
    xmlHttp[4].open("GET", url, true);
    xmlHttp[4].send(null); 	
}

function getMerchandiserRequest()
{
	if(xmlHttp[4].readyState==4 && xmlHttp[4].status ==200)
	{
		var rText = xmlHttp[4].responseText;	
		document.getElementById("txtMearchandiser").value = rText.split('--')[1];
		document.getElementById("txtMearchandiser").userid = rText.split('--')[0];
	}
}
///////////////////////// END OF MERCHANDISER USING STYLE ////////////////////

function getRatioQty()
{
	var strStyleId = document.getElementById("cboStyle").value;
	var strBuyerPo = document.getElementById("cboBuyerPoNo").value;
	strBuyerPo = strBuyerPo.replace(/#/gi,"***");
	
	var strColor = document.getElementById("cboColor").value;
	
	createXmlHttpObject(5);
    xmlHttp[5].onreadystatechange = ratioQtyRequest;
	var url = 'cad-xml.php?id=getRatioQty&styleId='+strStyleId+'&strBuyerPo='+strBuyerPo+'&strColor='+strColor;
    xmlHttp[5].open("GET", url, true);
    xmlHttp[5].send(null); 		
}
function ratioQtyRequest()
{
	if(xmlHttp[5].readyState==4 && xmlHttp[5].status ==200)
	{
		var rText = xmlHttp[5].responseText;	
		document.getElementById("txtColorRatioQty").value = rText ;

	}
}

/////////////////////// GET SIZES /////////////////////////////
function getSizes()
{
	var strStyleId = document.getElementById("cboStyle").value;
	var strBuyerPo = document.getElementById("cboBuyerPoNo").value;
	var intMaterialId = document.getElementById("cboFabric").value;
	strBuyerPo = strBuyerPo.replace(/#/gi,"***");
	var strColor = document.getElementById("cboColor").value;
	
	createXmlHttpObject(6);
    xmlHttp[6].onreadystatechange = sizeRequest;
	var url = 'cad-xml.php?id=getSizes&styleId='+strStyleId+'&strBuyerPo='+strBuyerPo+'&strColor='+strColor+'&intMaterialId='+intMaterialId;
    xmlHttp[6].open("GET", url, true);
    xmlHttp[6].send(null); 		
}
function sizeRequest()
{
	if(xmlHttp[6].readyState==4 && xmlHttp[6].status ==200)
	{
		var rText = xmlHttp[6].responseText;	
		document.getElementById("tblMain").innerHTML = rText ;
	}
}
function AddSizes()
{
	getSizes();
	getFabricRecievedQty_Exp();
}
///////////////////////////////////////////////////////////////


function CheckforValidDecimal(sCell,decimalPoints,evt)
{

	
	var value=sCell.value;

	var charCode = (evt.which) ? evt.which : evt.keyCode;
	
	var allowableCharacters = new Array(9,45,36,35);
	for (var loop = 0 ; loop < allowableCharacters.length ; loop ++ )
	{
		if (charCode == allowableCharacters[loop] )
		{
			return true;
		}
	}
	
	
	for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }
	
	if (charCode==46 && value.indexOf(".") >-1)
		return false;
	else if (charCode==46)
		return true;
	
	if (value.indexOf(".") > -1 && value.substring(value.indexOf("."),value.length).length > decimalPoints)
		return false;
	
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
}

function addNewLine()
{
	var tblMain  		= document.getElementById("tblMain");
	var intRowCount		= tblMain.rows.length;
	var intCellCount	= tblMain.rows[0].cells.length;
	if(intRowCount<3)
		return;
	var row 			=tblMain.insertRow(intRowCount-2);
	
	var rowString 	= "<td><div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"removeRow(this)\"/></div></td>"+
                	"<td class=\"normalfnt\"><input name=\"txtTotalYards\"  type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\"  /></td>"+
					 "<td class=\"normalfnt\"><input name=\"xx\" style=\"text-align:right\"  type=\"text\" class=\"txtbox\" id=\"xx\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>"+
                	"<td class=\"normalfnt\"><input name=\"txtLayer\" style=\"text-align:right\"  type=\"text\" class=\"txtbox\" id=\"txtLayer\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" onblur=\"verticalCalculate(this);\"  onkeyup=\"sizeCalculation(this);\"  /></td>";
					
			for(var loop=0;loop<(intCellCount-8);loop++)
			{
	rowString +="<td  class=\"normalfntRite\"><input name=\"txtSize\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtSize\" size=\"10\"  onkeypress=\"return CheckforValidDecimal(this, 4,event);\" onkeyup=\"sizeCalculation(this);\" /></td>";
			}
					
			
	rowString +="<td  class=\"normalfntRite\"><input name=\"txtTotalYards\" style=\"text-align:right\" type=\"text\" class=\"txtbox\" id=\"txtTotalYards\" size=\"10\"  onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  onblur=\"verticalCalculate(this);\"  /></td>"+
	"<td class=\"normalfnt\"><input name=\"txtMarkerLenghtYrd\" style=\"text-align:right\"  type=\"text\" class=\"txtbox\" id=\"txtMarkerLenghtYrd\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  onblur=\"verticalCalculate(this);\"   /></td>"+
                "<td class=\"normalfnt\"><input name=\"txtMarkerLenghtInch\"  type=\"text\" style=\"text-align:right\" class=\"txtbox\" id=\"txtMarkerLenghtInch\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\"  /></td>"+
                "<td class=\"normalfnt\"><input name=\"txtEff\" type=\"text\" style=\"text-align:right\" onfocus=\"this.blur();\" class=\"txtbox\" id=\"txtEff\" size=\"10\" onkeypress=\"return CheckforValidDecimal(this, 4,event);\" /></td>";
	row.innerHTML = rowString;
}


function verticalCalculate(objText)
{
	var rowId 			= objText.parentNode.parentNode.rowIndex;
	var tblMain  		= document.getElementById("tblMain");
	var intCellCount	= tblMain.rows[rowId].cells.length;
	var intRowCount		= tblMain.rows.length;
	

		var layer 	= parseFloat(tblMain.rows[rowId].cells[3].childNodes[0].value);
		var MLyrd 	= parseFloat(tblMain.rows[rowId].cells[intCellCount-4].childNodes[0].value);
		var MLinch 	= parseFloat(tblMain.rows[rowId].cells[intCellCount-3].childNodes[0].value);
		var TotalYRD= (((MLyrd*36)+MLinch)*layer)/36;
		
		if(isNaN(TotalYRD))
			tblMain.rows[rowId].cells[intCellCount-1].childNodes[0].value=0;
		else
			tblMain.rows[rowId].cells[intCellCount-1].childNodes[0].value=Math.round(TotalYRD*100)/100;
		
		getTotalYards();
}
function sizeCalculation(objText)
{
	//alert(objText.value);
	var value 	= objText.value;
	var rowId 	= objText.parentNode.parentNode.rowIndex;
	var cellId	= objText.parentNode.cellIndex;
	var tblMain = document.getElementById("tblMain");
	
	//var maxValue= parseFloat(tblMain.rows[tblMain.rows.length-1].cells[cellId].childNodes[0].value)*-1;
	var maxValue = availableQty(objText);
	//tblMain.rows[tblMain.rows.length-1].cells[cellId].childNodes[0].value = maxValue;
	var layer 	=  conNum(tblMain.rows[rowId].cells[3].childNodes[0].value);
	if(objText.id=="txtSize")
	{
		var intSize = Math.floor(maxValue/layer);
		if( conNum(objText.value)>intSize)
		{
				alert("You can't insert sizes over available sizes");
				objText.value=intSize;	
		}
		tblMain.rows[tblMain.rows.length-1].cells[cellId].childNodes[0].value =( availableQty(objText)-parseFloat(layer* conNum(objText.value)))*-1;
		tblMain.rows[tblMain.rows.length-2].cells[cellId].childNodes[0].value = parseFloat(tblMain.rows[tblMain.rows.length-2].cells[cellId].childNodes[0].alt) + parseFloat(tblMain.rows[tblMain.rows.length-1].cells[cellId].childNodes[0].value);
	}
	else if(objText.id=="txtLayer")
	{
			
			//sizeRemove(objText);
			AutoSize(objText);
	}
	getTotalFullQty();
}


function availableQty(objText)
{
	var tblMain  	= document.getElementById("tblMain");
	var rowId 		= objText.parentNode.parentNode.rowIndex;
	var cellId		= objText.parentNode.cellIndex;	
	var intRowCount	= tblMain.rows.length;
	var Total 		= 0;
	for(var loop=1;loop<=intRowCount-3;loop++)
	{
		if(rowId!=loop)
		{
			//var layers 	= parseFloat(tblMain.rows[loop].cells[3].childNodes[0].value);
			var layers 	=  parseFloat(tblMain.rows[loop].cells[3].childNodes[0].value);
			if(isNaN(layers))
				layers = 0;
			var sizes 	=  parseFloat(tblMain.rows[loop].cells[cellId].childNodes[0].value);
			if(isNaN(sizes))
				sizes = 0;
			Total +=(sizes*layers);
			
			//alert(rowId+ ' = ' +loop);
			//alert(layers);
		}
	}
	var TotalSizes = parseFloat(tblMain.rows[intRowCount-2].cells[cellId].childNodes[0].alt);
	//tblMain.rows[intRowCount-2].cells[cellId].childNodes[0].value = Total;
	
	var AvailableSizes = TotalSizes - Total;
	return AvailableSizes;
}


function sizeRemove(objText)
{
	var value 			= objText.value;
	var rowId 			= objText.parentNode.parentNode.rowIndex;
	var cellId			= objText.parentNode.cellIndex;
	var tblMain 		= document.getElementById("tblMain");
	var intCellCount	= tblMain.rows[rowId].cells.length;
	
	for(var loop=4;loop<intCellCount-4;loop++)
	{
		tblMain.rows[rowId].cells[loop].childNodes[0].value=0;
			
			var objText2 = objText.parentNode.parentNode.cells[loop].childNodes[0];
			sizeCalculation(objText2);
	}
}

function getFabricRecievedQty_Exp()
{
	var strStyleId = document.getElementById("cboStyle").value;
	var strBuyerPo = document.getElementById("cboBuyerPoNo").value;
	strBuyerPo = strBuyerPo.replace(/#/gi,"***");
	var strColor = document.getElementById("cboColor").value;
	
	createXmlHttpObject(7);
    xmlHttp[7].onreadystatechange = fabricReceivedQty;
	var url = 'cad-xml.php?id=getFabricRecieved&styleId='+strStyleId+'&strBuyerPo='+strBuyerPo+'&strColor='+strColor;
    xmlHttp[7].open("GET", url, true);
    xmlHttp[7].send(null); 		
}
function fabricReceivedQty()
{
	if(xmlHttp[7].readyState==4 && xmlHttp[7].status ==200)
	{
		var rText = parseFloat(xmlHttp[7].responseText);	
		if(isNaN(rText))
			rText = 0;
		document.getElementById("txtFabricRecieved").innerHTML = rText ;
	}
}
function getTotalYards()
{
	var tblMain = document.getElementById("tblMain");
	var totalYRD = 0;
	var intCellCount=0;
	for(var loop=1;loop<=tblMain.rows.length-3;loop++)
	{
			intCellCount	=  tblMain.rows[loop].cells.length;
			var tYRD =  parseFloat(tblMain.rows[loop].cells[intCellCount-1].childNodes[0].value);
			if(isNaN(tYRD))
				tYRD = 0;
			totalYRD += tYRD;
	}
	c = parseInt(tblMain.rows[1].cells.length);
	r = parseInt(tblMain.rows.length);
	tblMain.rows[r-2].cells[c-1].childNodes[0].value=totalYRD;
	tblMain.rows[r-1].cells[c-1].childNodes[0].value=totalYRD;
	pub_TotalYrd = totalYRD;
	calculateProductionConPc();
}
//////////////////////// END ////////////////////////////////////////////////////////////////////////////

function getTotalQty()
{
	var tblMain = document.getElementById("tblMain");
	var totalQty = 0;
	var intCellCount=0;
	for(var loop=1;loop<=tblMain.rows.length-3;loop++)
	{
			var tQty =  parseFloat(tblMain.rows[loop].cells[3].childNodes[0].value);
			if(isNaN(tQty))
				tQty = 0;
			totalQty += tQty;
	}
	pub_TotalQty = totalQty;
	
}

function calculateProductionConPc()
{
		getTotalQty();
		var dblPipingQty = conNum(document.getElementById("txtPipingConsumption").value);
		var dblPercentage = conNum(document.getElementById("txtPercentage").value);
		var totalQty		= conNum(document.getElementById("txtTotalQty").value);
		//alert((pub_TotalYrd / pub_TotalQty)+dblPipingQty);
document.getElementById("txtProductionPcs").value = Math.round(((((pub_TotalYrd / totalQty)+dblPipingQty)/100)*(dblPercentage+100))*1000)/1000;
		calCuttableqty();
		
		//bookmark1
		
}

function calCuttableqty()
{
		var fabricRec = conNum(document.getElementById("txtFabricRecieved").value);
		var productionPcs = conNum(document.getElementById("txtProductionPcs").value);
		var dblCuttable = (fabricRec/productionPcs);
		
		document.getElementById("txtCuttableQty").value=conNum(dblCuttable);
}


function removeRow(objDel)
{
		
		var no = objDel.parentNode.parentNode.parentNode.rowIndex;
		var tblMain = document.getElementById("tblMain");
		
		var objText = objDel.parentNode.parentNode.parentNode.cells[3].childNodes[0];
		sizeRemove(objText);

		if(confirm("Are you sure remove row no " + no ))
			tblMain.deleteRow(no);
		
		
}

function conNum(value)
{
		var dblValue = parseFloat(value);
		if(isNaN(dblValue))
			dblValue = 0;

		return dblValue;
}

function AutoSize(objText)
{
	var tblMain 		= document.getElementById("tblMain");
	var value 			= conNum(objText.value);
	var rowId 			= objText.parentNode.parentNode.rowIndex;
	var tblMain 		= document.getElementById("tblMain");
	var intCellCount	= tblMain.rows[rowId].cells.length;

	var layer	=  conNum(objText.value);
	if(objText.id=="txtLayer")
	{
		for(var loop=4;loop<intCellCount-4;loop++)
		{
			var objText2 = objText.parentNode.parentNode.cells[loop].childNodes[0];
			var maxValue = availableQty(objText2);
			if(layer==0)
				objText2.value=0;
			else
			{
			var intSize = conNum(Math.floor(maxValue/layer));
				objText2.value=intSize;
			}
			
			
			
			sizeCalculation(objText2);
		}
			
	}
	
	
}

function saveHeader()
{
  	var cboStyle = document.getElementById("cboStyle").value;
	var cboFabric = document.getElementById("cboFabric").value;
	var cboBuyerPoNo = document.getElementById("cboBuyerPoNo").value;
	var cboColor = document.getElementById("cboColor").value;
	var cboWidth = document.getElementById("cboWidth").value;
	var txtMearchandiser = document.getElementById("txtMearchandiser").userid;
	var txtColorRatioQty = conNum(document.getElementById("txtColorRatioQty").value);
	var txtTotalQty = conNum(document.getElementById("txtTotalQty").value);
	var txtWidth = conNum(document.getElementById("txtWidth").value);
	
	var txtBudgetedConsumption = conNum(document.getElementById("txtBudgetedConsumption").value);
	var txtBudgetedPcs = conNum(document.getElementById("txtBudgetedPcs").value);
	var txtFabricRecieved = conNum(document.getElementById("txtFabricRecieved").value);
	var txtPipingConsumption = conNum(document.getElementById("txtPipingConsumption").value);
	var txtProductionPcs = conNum(document.getElementById("txtProductionPcs").value);
	var txtCuttableQty = conNum(document.getElementById("txtCuttableQty").value);
	var txtPercentage = conNum(document.getElementById("txtPercentage").value);
	
	createXmlHttpObject(0);
    xmlHttp[0].onreadystatechange = saveHeaderRequest;
	var url  = "cad-db.php?id=saveHeader";
		url += "&Styleid="+cboStyle;
		url += "&Fabric="+cboFabric;
		url += "&BuyerPoNo="+cboBuyerPoNo.replace(/#/gi,"***");
		url += "&Color="+cboColor;
		url += "&Width="+cboWidth;
		url += "&Mearchandiser="+txtMearchandiser;
		url += "&TotalQty="+txtTotalQty;
		url += "&Width="+txtWidth;
		url += "&BudgetedConsumption="+txtBudgetedConsumption;
		url += "&BudgetedPcs="+txtBudgetedPcs;
		url += "&FabricRecieved="+txtFabricRecieved;
		url += "&PipingConsumption="+txtPipingConsumption;
		url += "&ProductionPcs="+txtProductionPcs;
		url += "&CuttableQty="+txtCuttableQty;
		url += "&Percentage="+txtPercentage;
		
    xmlHttp[0].open("GET", url, true);
    xmlHttp[0].send(null); 		

}

function saveHeaderRequest()
{
	if(xmlHttp[0].readyState==4 && xmlHttp[0].status ==200)
	{
		var rText = parseFloat(xmlHttp[0].responseText);	
		if(rText>=1)
		{
			alert("CAD header Saved successfully");
			saveMarkerDetail();
			saveSizeDetails();
		}
			//document.getElementById("txtFabricRecieved").innerHTML = "123" ;
	}
}

function saveMarkerDetail()
{
		var tblMain = document.getElementById("tblMain");
		var rows	= tblMain.rows.length;
		
		var cboStyle = document.getElementById("cboStyle").value;
		var cboFabric = document.getElementById("cboFabric").value;
		var cboBuyerPoNo = document.getElementById("cboBuyerPoNo").value;
		var cboColor = document.getElementById("cboColor").value;
		var txtWidth = conNum(document.getElementById("txtWidth").value);
		
		for(var loop=1;loop<= rows-3;loop++)
		{
			var colls			= tblMain.rows[loop].cells.length;
			
			var markerName 		= tblMain.rows[loop].cells[1].childNodes[0].value;
			var copy	   		= conNum(tblMain.rows[loop].cells[2].childNodes[0].value);
			var layer 	   		= conNum(tblMain.rows[loop].cells[3].childNodes[0].value);
			var markerLengthYrd = conNum(tblMain.rows[loop].cells[colls-4].childNodes[0].value);
			var markerLengthInc = conNum(tblMain.rows[loop].cells[colls-3].childNodes[0].value);
			var eff 			= conNum(tblMain.rows[loop].cells[colls-2].childNodes[0].value);
			var TotalYards 		= conNum(tblMain.rows[loop].cells[colls-1].childNodes[0].value);
			
			createXmlHttpObject(loop);
			xmlHttp[loop].onreadystatechange = saveMarkerDetailRequest;
			var url  = "cad-db.php?id=saveMarkerDetails";
				url += "&count="+loop;
				url += "&Styleid="+cboStyle;
				url += "&Fabric="+cboFabric;
				url += "&BuyerPoNo="+cboBuyerPoNo.replace(/#/gi,"***");
				url += "&Color="+cboColor;
				url += "&markerName="+markerName;
				url += "&copy="+copy;
				url += "&layer="+layer;
				url += "&markerLengthYrd="+markerLengthYrd;
				url += "&markerLengthInc="+markerLengthInc;
				url += "&eff="+eff;
				url += "&TotalYards="+TotalYards;
				url += "&txtWidth="+txtWidth;
				
			xmlHttp[loop].index = loop;
			xmlHttp[loop].count = rows-3;
			xmlHttp[loop].open("GET", url, true);
			xmlHttp[loop].send(null);

		}
}

function saveMarkerDetailRequest()
{
	if(xmlHttp[this.index].readyState==4 && xmlHttp[this.index].status ==200)
	{
		var rText = parseFloat(xmlHttp[this.index].responseText);	
		if(xmlHttp[this.index].index==xmlHttp[this.index].count)
		{
			alert("CAD Marker Details Saved successfully");
		}
	}	
}

function saveSizeDetails()
{
	var tblMain = document.getElementById("tblMain");
	var rows	= tblMain.rows.length;
		
	var strStyleId		 	= document.getElementById("cboStyle").value;
	var intMatdetailId		= document.getElementById("cboFabric").value;
	var strColor			= document.getElementById("cboColor").value;
	var dblWidth			= conNum(document.getElementById("txtWidth").value);
	
	var y=0;
	for(var loop=1;loop<= rows-3;loop++)
	{
		var colls = tblMain.rows[loop].cells.length;
		var strMarkerName 	=tblMain.rows[loop].cells[1].childNodes[0].value;	
		var dblLayers	 	=tblMain.rows[loop].cells[3].childNodes[0].value;

			for(var x=4;x<= colls-5;x++)
			{
					
				var strSize		    =tblMain.rows[0].cells[x].firstChild.nodeValue;		
				var dblQty			=conNum(tblMain.rows[loop].cells[x].childNodes[0].value);		
					y++;
					createXmlHttpObject1(y);
					xmlHttp1[y].onreadystatechange = saveSizeDetailRequest;
					var url  = "cad-db.php?id=saveSizeDetails";
						url += "&count="+y;
						url += "&strStyleId="+strStyleId;
						url += "&intMatdetailId="+intMatdetailId;
						url += "&strColor="+strColor;
						url += "&strMarkerName="+strMarkerName;
						url += "&dblLayers="+dblLayers;
						url += "&dblWidth="+dblWidth;
						url += "&dblQty="+dblQty;
						url += "&strSize="+strSize;
						
					xmlHttp1[y].index = y;
					xmlHttp1[y].count = rows-3;
					xmlHttp1[y].open("GET", url, true);
					xmlHttp1[y].send(null);

			}
	}
}

function saveSizeDetailRequest()
{
	if(xmlHttp1[this.index].readyState==4 && xmlHttp1[this.index].status ==200)
	{
		var rText = parseFloat(xmlHttp1[this.index].responseText);	
		if(xmlHttp1[this.index].index==xmlHttp1[this.index].count)
		{
			alert("CAD Size Details Saved successfully");
		}
	}
}

/////////////////////////////////////////////  FOR LISTING PART //////////////////////////////////////////////////////////////

function loadCadConsumptionListing()
{
	
	var SearchStyle		= document.getElementById("cboSearchStyle").value;
	var SearchFabric	= document.getElementById("cboSearchFabric").value;
	var fromDate		= document.getElementById("fromDate").value;
	var toDate		 	= document.getElementById("toDate").value;
	var status			= document.getElementById("cboMode").value;
			createXmlHttpObject(0);
			xmlHttp[0].onreadystatechange = getDetailsForListingRequest;
			var url  = "cad-xml.php?id=getCadListingDetails";
				url += "&SearchStyle="+SearchStyle;
				url += "&SearchFabric="+SearchFabric;
				url += "&fromDate="+fromDate;
				url += "&toDate="+toDate;
				url += "&status="+status;
			xmlHttp[0].open("GET", url, true);
			xmlHttp[0].send(null);
}

function getDetailsForListingRequest()
{
	if(xmlHttp[0].readyState==4 && xmlHttp[0].status ==200)
	{
		var XMLstrStyleId 		= xmlHttp[0].responseXML.getElementsByTagName("strStyleId");
		var XMLMatDetailId 		= xmlHttp[0].responseXML.getElementsByTagName("MatDetailId");
		var XMLDescription 		= xmlHttp[0].responseXML.getElementsByTagName("Description");
		var XMLstrColor 		= xmlHttp[0].responseXML.getElementsByTagName("strColor");
		var XMLdblwidth 		= xmlHttp[0].responseXML.getElementsByTagName("dblwidth");
		var XMLdtmDate   		= xmlHttp[0].responseXML.getElementsByTagName("dtmDate");
		var XMLName 			= xmlHttp[0].responseXML.getElementsByTagName("Name");
		var XMLstrUserId 		= xmlHttp[0].responseXML.getElementsByTagName("strUserId");
		
		var tblList = document.getElementById("tblList");
		
		tblList.innerHTML = "<tr>"+
						  "<td width=\"2%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">&nbsp;</td>"+
						  "<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style No</td>"+
						  "<td width=\"28%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Fabric</td>"+
						  "<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Color</td>"+
						  "<td width=\"9%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Width</td>"+
						  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
						  "<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">User</td>"+
						  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">View</td>"+
						  "<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Print</td>"
						 "</tr>";
		 
		for(var loop=0;loop<XMLstrStyleId.length;loop++)
		{
		var strUrl = 'cad.php?id=1&styleId='+XMLstrStyleId[loop].childNodes[0].nodeValue+'&Fabric='+XMLMatDetailId[loop].childNodes[0].nodeValue+'&color='+XMLstrColor[loop].childNodes[0].nodeValue;
		var strUrlPrint = 'CadReport.php?strStyleId='+XMLstrStyleId[loop].childNodes[0].nodeValue+'&matDetailId='+XMLMatDetailId[loop].childNodes[0].nodeValue+'&strColor='+XMLstrColor[loop].childNodes[0].nodeValue;
		strUrl = strUrl.replace(' ',"%20");
		strUrlPrint = strUrlPrint.replace(' ',"%20");
		//strBuyerPoNo=strBuyerPoNo.replace(/#/gi,"***");
		tblList.innerHTML += "<tr>"+
		  "<td height=\"20\">&nbsp;</td>"+
		  "<td >"+ XMLstrStyleId[loop].childNodes[0].nodeValue+"</td>"+
		  "<td >"+ XMLDescription[loop].childNodes[0].nodeValue+"</td>"+
		  "<td >"+ XMLstrColor[loop].childNodes[0].nodeValue+"</td>"+
		  "<td >"+ XMLdblwidth[loop].childNodes[0].nodeValue+"</td>"+
		  "<td >"+ XMLdtmDate[loop].childNodes[0].nodeValue+"</td>"+
		  "<td >"+ XMLName[loop].childNodes[0].nodeValue+"</td>"+
		  "<td ><a href="+strUrl+" class=\"non-html pdf\" target=\"_blank\"><img src=\"../images/view.png\" border=\"0\" alt=\"search\" width=\"91\" height=\"19\" class=\"mouseover\" /></a></td>"+
		  "<td><a  href="+strUrlPrint+" target=\"_blank\"><img src=\"../images/report.png\" border=\"0\" id=\"butReport\"  class=\"mouseover\" width=\"90\" height=\"20\" /></a></td>"+
		  "</tr>";
		  
		}

	}
}

function dateDisable(objChk)
{
		if(!objChk.checked)
		{
			document.getElementById("fromDate").disabled= true;
			document.getElementById("fromDate").value="";
			document.getElementById("toDate").disabled= true;
			document.getElementById("toDate").value="";
		}
		else
		{
			document.getElementById("fromDate").disabled=false;
			document.getElementById("toDate").disabled= false;
		}
}




//////////////////////// LOAD FABRIC ////////////////////////
function loadSearchFabric()
{
	createXmlHttpObject(1);
	var strStyleId = document.getElementById("cboSearchStyle").value;
	
    xmlHttp[1].onreadystatechange = loadSearchFabricRequest;
	var url = 'cad-xml.php?id=loadFabric&styleId='+strStyleId;
    xmlHttp[1].open("GET", url, true);
    xmlHttp[1].send(null); 	
	
}
function loadSearchFabricRequest()
{
	if(xmlHttp[1].readyState==4 && xmlHttp[1].status ==200)
	{
		var rText = xmlHttp[1].responseText;	
		document.getElementById("cboSearchFabric").innerHTML = rText ;
		
	}
}
///////////////////////// END OF LOAD FABRIC ////////////////////

function loadItems(styleid,fabric,color)
{
		if(styleid!='')
		{
			document.getElementById("cboStyle").value=styleid;
			document.getElementById("cboStyle").onchange();
		}
		if(fabric!='')
		{
			//alert(fabric);
			document.getElementById("cboFabric").value=fabric;
			document.getElementById("cboFabric").onchange();
		}
		if(color!='')
		{
			//alert(color);
			document.getElementById("cboColor").value=color;
			document.getElementById("cboColor").onchange();
		}
		if(styleid!='' && fabric!='' && color!='' )
			getHeaderDetails(styleid,fabric,color);
}


///////////////////////////// get header details
/////////////////////////////////////////////  FOR LISTING PART //////////////////////////////////////////////////////////////

function getHeaderDetails(styleid,matDetailId,color)
{
			createXmlHttpObject(500);
			xmlHttp[500].onreadystatechange = getHeaderDetails_2;
			var url  = "cad-xml.php?id=getHeaderDetails";
				url += "&styleid="+styleid;
				url += "&matDetailId="+matDetailId;
				url += "&color="+color;
			xmlHttp[500].open("GET", url, true);
			xmlHttp[500].send(null);
}

function getHeaderDetails_2()
{
	if(xmlHttp[500].readyState==4 && xmlHttp[500].status ==200)
	{
		var XMLdblBudgetedPipingConsumption	= xmlHttp[500].responseXML.getElementsByTagName("dblBudgetedPipingConsumption");
		document.getElementById("txtBudgetedConsumption").value=XMLdblBudgetedPipingConsumption[0].childNodes[0].nodeValue;
		
		var XMLdblBudgetedConPcs 		= xmlHttp[500].responseXML.getElementsByTagName("dblBudgetedConPcs");
		document.getElementById("txtBudgetedPcs").value=XMLdblBudgetedConPcs[0].childNodes[0].nodeValue;
		
		var XMLdblFabricRecievedExpected	= xmlHttp[500].responseXML.getElementsByTagName("dblFabricRecievedExpected");
		document.getElementById("txtFabricRecieved").value=XMLdblFabricRecievedExpected[0].childNodes[0].nodeValue;
		
		var XMLdblPipingConsumptionYrd 	= xmlHttp[500].responseXML.getElementsByTagName("dblPipingConsumptionYrd");
		document.getElementById("txtPipingConsumption").value=XMLdblPipingConsumptionYrd[0].childNodes[0].nodeValue;
		
		var XMLdblProductionConPcsPercentage	= xmlHttp[500].responseXML.getElementsByTagName("dblProductionConPcsPercentage");
		document.getElementById("txtPercentage").value=XMLdblProductionConPcsPercentage[0].childNodes[0].nodeValue;
		
		
		var XMLdblProductionConPcsYrd	= xmlHttp[500].responseXML.getElementsByTagName("dblProductionConPcsYrd");
		document.getElementById("txtProductionPcs").value=XMLdblProductionConPcsYrd[0].childNodes[0].nodeValue;
		
		var XMLCuttableQtyYrd 		= xmlHttp[500].responseXML.getElementsByTagName("CuttableQtyYrd");
		document.getElementById("txtCuttableQty").value=XMLCuttableQtyYrd[0].childNodes[0].nodeValue;
		
	}
}

function conform()
{	
	var strStyleId		 	= document.getElementById("cboStyle").value;
	var intMatdetailId		= document.getElementById("cboFabric").value;
	var strColor			= document.getElementById("cboColor").value;
	var BuyerPoNo 			= document.getElementById("cboBuyerPoNo").value;
	
	createXmlHttpObject(0);
	
    xmlHttp[0].onreadystatechange = confirmRequest;
	var url = 'cad-db.php?id=confirm&strStyleId='+strStyleId+'&intMatdetailId='+intMatdetailId+'&strColor='+strColor+'&BuyerPoNo='+BuyerPoNo.replace(/#/gi,"***");;
    xmlHttp[0].open("GET", url, true);
    xmlHttp[0].send(null); 	
	
}
function confirmRequest()
{
	if(xmlHttp[0].readyState==4 && xmlHttp[0].status ==200)
	{
		var rText = xmlHttp[0].responseText;	
		if(rText>0)
			alert("Cad Details Successfully Confirmed.");
		else
			alert("Cad Details Confirm in errors.");
		
	}
}
function ViewReport()
{
		var path = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1]+'/'+document.location.pathname.split("/")[2];
		var strStyleId = document.getElementById("cboStyle").value;
		var matDetailId = document.getElementById("cboFabric").value;
		var strColor = document.getElementById("cboColor").value;
	path += "/CadReport.php?strStyleId="+strStyleId+'&matDetailId='+matDetailId+'&strColor='+strColor;

	var win2=window.open(path,'win'+pub_printWindowNo++);

}

function showAddWidth()
{	
	
	document.getElementById('addWidth').style.visibility = "visible";	
}
function addToCombo()
{
		var value = document.getElementById('txtAddWidth').value;
		document.getElementById('cboWidth').innerHTML += "<option >"+value+"</option>";
		document.getElementById('addWidth').style.visibility = "hidden";
		document.getElementById('txtAddWidth').value = '';
}
function closedWidth()
{
		document.getElementById('addWidth').style.visibility = "hidden";
		document.getElementById('txtAddWidth').value = '';
}

/////////////////////////// get Total Qty //////////////////////////////////
function getTotalFullQty()
{
	var tblMain 		= document.getElementById("tblMain");
	var intCellCount	= tblMain.rows[2].cells.length;
	var rows 			= tblMain.rows.length;
	var value = 0;
		for(var loop=4;loop<intCellCount-4;loop++)
		{
			value += parseFloat(tblMain.rows[rows-2].cells[loop].childNodes[0].value);
		}
		document.getElementById("txtTotalQty").value= value;
}