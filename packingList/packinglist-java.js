// JavaScript Document
var xmlHttp 		= [];
var xmlHttpCommit;
var xmlHttpRollBack;

var pub_rowIndex = 0;
function createXMLHttpRequest(index) 
{
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
}

//==========================================================================================================
function dataValidation()
{
	var styleId 	= document.getElementById("cboStyleId").value;	
	var packingType = document.getElementById("cboPackingType").value;	
		
	if((styleId =='' )||(packingType==''))
		return false;
	else
		return true;
}

function loadGridDetails()
{
	if(dataValidation()==false)
		return;
	
	var styleId 	= document.getElementById("cboStyleId").value;	
	var packingType = document.getElementById("cboPackingType").value;	
	createXMLHttpRequest(0);
    xmlHttp[0].onreadystatechange = gridDateRequest;
    xmlHttp[0].open("GET", 'template-cartons.php?id=loadGridDetails&styleId='+styleId+'&type='+packingType, true);
	//xmlHttp[0].open('GET','www.facebook.com',true);
    xmlHttp[0].send(null); 
	
}

function gridDateRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		document.getElementById("divGrid").innerHTML = text;
	}
}

function addNewRow()
{
	var tblGrid = 	document.getElementById("tblMainGrid");
	var intNo 	=	tblGrid.rows.length-1;
	//var colorIndex = tblGrid.rows[intNo-1].cells[0].innerHTML;
	//alert(colorIndex);
		tblGrid.insertRow(intNo);
		tblGrid.rows[intNo].innerHTML = tblGrid.rows[intNo-1].innerHTML;
}

function calculateCartons(obj)
{
	var rowIndex 	=	obj.parentNode.parentNode.rowIndex;
	var fromCtn		=	toNum(getGridValue(rowIndex,6));
	var toCtn		=	toNum(getGridValue(rowIndex,7));
	setGridValue(rowIndex,8,(toCtn-fromCtn+1));
	//document.getElementById("txtNoOfCartons").value = getGridValue(rowIndex,8);
	loopCalculate();
}

function calculateSizeTotal(obj)
{
	var tblGrid 	= 	document.getElementById("tblMainGrid");
	var rowIndex 	=	obj.parentNode.parentNode.rowIndex;
	var cellCount	=	obj.parentNode.parentNode.cells.length;
	
	
	var total		= 0;
	for(var i=10;i<cellCount-5;i++)
	{
		var value = getGridValue(rowIndex,i);	
		total= parseFloat(total)+value;
	}
	setGridValue(rowIndex,cellCount-5,total);
	setGridValue(rowIndex,cellCount-4,total*getGridValue(rowIndex,8));
	
	
	loopCalculate();
}

function loopCalculate()
{
	var tblGrid 	= 	document.getElementById("tblMainGrid");
	var rows		= 	tblGrid.rows.length;
	
	var value = 0;
	var value2 = 0;
	var value3 = 0;
	var value4 = 0;
	for(var i=1;i<rows-1;i++)
	{
		var cells = tblGrid.rows[i].cells.length;
		value =parseFloat(value)+ getGridValue(i,cells-4);
		value2 =parseFloat(value2)+ getGridValue(i,8);
		
		value3 =parseFloat(value3)+ getGridValue(i,cells-3);
		value4 =parseFloat(value4)+ getGridValue(i,cells-2);
		//alert(value3);	
	}
	
	document.getElementById("txtQuantity").value = value;
	document.getElementById("txtNoOfCartons").value = value2;
	
	document.getElementById("txtGrossMass").value = value3*value2;
	document.getElementById("txtNetMass").value = value4*value2;
}


function getGridValue(row,cell)
{
	var tblGrid = 	document.getElementById("tblMainGrid");
	return toNum(tblGrid.rows[row].cells[cell].childNodes[0].value);
}
function getGridNodeValue(row,cell)
{
	var tblGrid = 	document.getElementById("tblMainGrid");
	return tblGrid.rows[row].cells[cell].innerHTML;
}
function setGridValue(row,cell,value)
{
	var tblGrid = 	document.getElementById("tblMainGrid");
	tblGrid.rows[row].cells[cell].childNodes[0].value = value;
}
function toNum(objValue)
{
	var value = parseFloat(objValue);
	if(isNaN(value))
		return 0;
	else if(value=='')
		return 0;
	else 
		return value;
}

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


function save()
{
	var packingListNo = savePackingListHeader();
}

function savePackingListHeader()
{
	var intPackingListNo		=	document.getElementById("txtPackingListNo").value;
	var strStyleId				=	document.getElementById("cboStyleId").value;
	var intNoOfCartons			=	document.getElementById("txtNoOfCartons").value;
	var dblCtnMeasurements		=	document.getElementById("txtCtnMeasurements").value;
	var strBuyerPoNo			=	document.getElementById("txtBuyerPoNo").value;
	var strPrePack 				=	document.getElementById("cboPrePack").value;
	var dblQuantity 			=	document.getElementById("txtQuantity").value;
	var dblGrossMass			=	document.getElementById("txtGrossMass").value;
	var dblNetMass 				=	document.getElementById("txtNetMass").value;
	var dblCbm					=	document.getElementById("txtCbm").value;
	var strProCode				=	document.getElementById("txtProCode").value;
	var strComCode				=	document.getElementById("txtComCode").value;
	var strFabric				=	document.getElementById("txtFabric").value;
	var strLineNo				=	document.getElementById("txtLineNo").value;
	var intHanger				=	document.getElementById("chkHanger").checked;
	var intPriceTicket			=	document.getElementById("chkPriceTicket").checked;
	var intPriceSticker			=	document.getElementById("chkPriceSticker").checked;
	var intLegSticker 			=	document.getElementById("chkLegSticker").checked;
	var intPoFlasher			=	document.getElementById("chkPoFlasher").checked;
	var intBelt					=	document.getElementById("chkBelt").checked;
	var intHangerTag			=	document.getElementById("chkHangerTag").checked;
	var intJockerTag			=	document.getElementById("chkJockerTag").checked;
	var strPackingType			=	document.getElementById("cboPackingType").value;
	var strUnitType				=	'PCS';
	var intCompany				=	document.getElementById("cboCompany").value;
	
	createXMLHttpRequest(0);
    xmlHttp[0].onreadystatechange = saveHeaderRequest;
	var url		 =	'packinglist-db.php?id=savePackingListHeader';
		url		+=	'&intPackingListNo='+intPackingListNo;
		url		+=	'&strStyleId='+URLEncode(strStyleId);
		url		+=	'&intNoOfCartons='+intNoOfCartons;
		url		+=	'&dblCtnMeasurements='+URLEncode(dblCtnMeasurements);
		url		+=	'&strBuyerPoNo='+URLEncode(strBuyerPoNo);
		url		+=	'&strPrePack='+strPrePack;
		url		+=	'&dblQuantity='+dblQuantity;
		url		+=	'&dblGrossMass='+dblGrossMass;
		url		+=	'&dblNetMass='+dblNetMass;
		url		+=	'&dblCbm='+URLEncode(dblCbm);
		url		+=	'&strProCode='+URLEncode(strProCode);
		url		+=	'&strComCode='+URLEncode(strComCode);
		url		+=	'&strFabric='+URLEncode(strFabric);
		url		+=	'&strLineNo='+URLEncode(strLineNo);
		url		+=	'&intHanger='+intHanger;
		url		+=	'&intPriceTicket='+intPriceTicket;
		url		+=	'&intPriceSticker='+intPriceSticker;
		url		+=	'&intLegSticker='+intLegSticker;
		url		+=	'&intPoFlasher='+intPoFlasher;
		url		+=	'&intBelt='+intBelt;
		url		+=	'&intHangerTag='+intHangerTag;
		url		+=	'&intJockerTag='+intJockerTag;
		url		+=	'&strPackingType='+strPackingType;
		url		+=	'&intCompany='+intCompany;
		//alert(url);
    xmlHttp[0].open("GET", url, true);
    xmlHttp[0].send(null); 
}

function saveHeaderRequest()
{
    if((xmlHttp[0].readyState == 4) && (xmlHttp[0].status == 200)) 
    {
		var text = xmlHttp[0].responseText;
		if(text=='error')
		{
			alert("Packing List Header not saved");	
			rollback();
		}
		else
		{
			alert("Packing List Header saved");	
			document.getElementById('txtPackingListNo').value = text;
			saveDetails(text);
		}
	}
}

function saveDetails(intPackingListNo)
{
	var tblGrid 	=	document.getElementById("tblMainGrid");
	var rowCount 	= 	tblGrid.rows.length;
	
	for(var i=1;i<rowCount-1;i++)
	{	
		var cellCount	= tblGrid.rows[i].cells.length;
		
		var intColorIndex	= 	i;
		var strBuyerPoNo	=	getGridValue(i,1);
		var strSh			=	getGridValue(i,2);
		var strLength		=	getGridValue(i,3);
		var strSticker		=	getGridValue(i,4);
		var strContainer	=	getGridValue(i,5);
		var intFromCtn		=	getGridValue(i,6);
		var intToCtn		=	getGridValue(i,7);
		var strColor		=	getGridValue(i,8);
		var dblPscCtn		=	getGridValue(i,cellCount-1);
		var dblTotal 		=	getGridValue(i,cellCount-1);
		var dblGrossWgt		=	getGridValue(i,cellCount-1);
		var dblNetWgt		=	getGridValue(i,cellCount-1);
		var dblNetNetWgt	=	getGridValue(i,cellCount-1);
		var intCompany		=	document.getElementById("cboCompany").value;
		
		////////////////////////////////////////////////////////////////	for catons details 	/////////////////////////////
		createXMLHttpRequest(i);
    	xmlHttp[i].onreadystatechange = saveDetailsRequest;	
		var url		 =	'packinglist-db.php?id=savepackingListDetails';
			url		+=	'&intPackingListNo='+intPackingListNo;
			url		+=	'&intColorIndex='+intColorIndex;
			url		+=	'&strBuyerPoNo='+URLEncode(strBuyerPoNo);
			url		+=	'&strSh='+URLEncode(strSh);
			url		+=	'&strLength='+strLength;
			url		+=	'&strSticker='+URLEncode(strSticker);
			url		+=	'&strContainer='+URLEncode(strContainer);
			url		+=	'&intFromCtn='+intFromCtn;
			url		+=	'&intToCtn='+intToCtn;
			url		+=	'&strColor='+URLEncode(strColor);
			url		+=	'&dblPscCtn='+dblPscCtn;
			url		+=	'&dblTotal='+dblTotal;
			url		+=	'&dblGrossWgt='+dblGrossWgt;
			url		+=	'&dblNetWgt='+dblNetWgt;
			url		+=	'&dblNetNetWgt='+dblNetNetWgt;
			url		+=	'&intCompany='+intCompany;
		xmlHttp[i].index = i;	
		xmlHttp[i].open("GET", url, true);
   		xmlHttp[i].send(null); 
		
		///////////////////////////////////////////////////////////////// for catons size /////////////////////////////////////
		
		var sSize ='';
		var sValue='';
		for (var n=10;n<cellCount-5;n++)
		{
			sSize +=getGridNodeValue(0,n)+',';		
			sValue+=getGridValue(i,n)+',';
		}
		
		createXMLHttpRequest(i+1000);
    	xmlHttp[i+1000].onreadystatechange = saveSizesRequest;	
		var sizeUrl = 'packinglist-db.php?id=saveSizeDetails&sSize='+sSize+'&sValue='+sValue+'&intPackingListNo='+intPackingListNo+'&intColorIndex='+intColorIndex+'&intCompany='+intCompany;
		xmlHttp[i+1000].index = i+1000;	
		xmlHttp[i+1000].open("GET", sizeUrl, true);
   		xmlHttp[i+1000].send(null); 
		//alert(sizeUrl);
		
	}
}

function saveSizesRequest()
{
	if((xmlHttp[this.index].readyState == 4) && (xmlHttp[this.index].status == 200)) 
    {
		var text = xmlHttp[this.index].responseText;
		alert(text);
	}
}
function saveDetailsRequest()
{
	if((xmlHttp[this.index].readyState == 4) && (xmlHttp[this.index].status == 200)) 
    {
		var text = xmlHttp[this.index].responseText;
		alert(text);
	}
}

function createXMLHttpRequestForCommit() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpCommit = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpCommit = new XMLHttpRequest();
    }
}

function createXMLHttpRequestForRollback() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpRollBack = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpRollBack = new XMLHttpRequest();
    }
}

function rollback()
{
	createXMLHttpRequestForRollback();
	xmlHttpRollBack.onreadystatechange = rollbackRequest;
	var url  = "packinglist-db.php?id=rollback";
	xmlHttpRollBack.open("GET",url,true);
	xmlHttpRollBack.send(null);	
}

function commit()
{
	createXMLHttpRequestForCommit();
	xmlHttpCommit.onreadystatechange = commitRequest;
	var url  = "packinglist-db.php?id=commit";
	xmlHttpCommit.open("GET",url,true);
	xmlHttpCommit.send(null);	
}

function commitRequest()
{
	if(xmlHttpCommit.readyState==4 && xmlHttpCommit.status==200)
	{
		alert("commit done")
	}
}

function rollbackRequest()
{
	if(xmlHttpRollBack.readyState==4 && xmlHttpRollBack.status==200)
	{
		alert("rollback done")
	}
}


function abc()
{
	alert("message");	
}


