//Start - main grid variables
$main0 						= 0;  		//delete button
$main1 						= 1;		//item description 
$main2 						= 2;		//style Id
$main3 						= 3;		//buyer pono
$main4 						= 4;		//color
$main5 						= 5;    	//size
$main6 						= 6;		//units
$main7 						= 7;		//allocared qty
$main8 						= 8;		//tranfer qty
$main9 						= 9;		//bin allocation image
$main10 					= 10;		//GRN No
$main11 					= 11;		//GRN Type
//End - main grid variables 

//Srart bin allocation popup
$bin0 						= 0;		//available qty
$bin1 						= 1;		//req qty
$bin2 						= 2;		//check bok
$bin3 						= 3;		//bin
$bin4 						= 4;		//location
$bin5 						= 5;		//substore
$bin6 						= 6;		//main store
//End bin allocation popup

var xmlHttpArray 			= [];
var xmlHttpArray1 			= [];
var Materials 				= [];
var mainArrayIndex 			= 0;
var pub_index				= 0;
var	pub_No 					= 0;
var pub_Year 				= 0;
var pub_validateCount 		= 0;
var pub_validateBinCount	= 0;
var pub_commonbin			= 0;

function RemoveAllRows(tableName)
{
	$("#"+tableName+" tr:gt(0)").remove();
}
function RomoveData(data)
{
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 0) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}
function ClearForm()
{
	Materials 				= [];
	$("#frmLeftOverAllocation")[0].reset();
	RemoveAllRows('tblMain');
	RestricInterface(0);
	var url = 'leftoverdb.php?RequestType=ReloadAllocationNo';
	htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboNo').innerHTML = htmlobj.responseText;
}
	
function LoadDetails(obj)
{
	document.getElementById("txtTransferNo").value = obj;
	var url = 'leftoverdb.php?RequestType=LoadDetails&no='+obj;
	htmlobj=$.ajax({url:url,async:false});
	LoadDetailsRequest(htmlobj);
}
 
function LoadDetailsRequest(htmlobj)
{
	var XMLLength 		= htmlobj.responseXML.getElementsByTagName("Qty");
	var XMLMSId			= htmlobj.responseXML.getElementsByTagName("MSId")[0].childNodes[0].nodeValue;
	$("#cboMainStore").val(XMLMSId);
	RemoveAllRows('tblMain');
	Materials 				= [];
	mainArrayIndex=0;
	for(loop=0;loop<XMLLength.length;loop++)
	{
		var XMLItemDescription 	= htmlobj.responseXML.getElementsByTagName("ItemDescription")[loop].childNodes[0].nodeValue;
		var XMLMatDetailId 		= htmlobj.responseXML.getElementsByTagName("MatDetailId")[loop].childNodes[0].nodeValue;
		var XMLStyleId 			= htmlobj.responseXML.getElementsByTagName("StyleId")[loop].childNodes[0].nodeValue;
		var XMLStyleName 		= htmlobj.responseXML.getElementsByTagName("StyleName")[loop].childNodes[0].nodeValue;
		var XMLBuyerPoId 		= htmlobj.responseXML.getElementsByTagName("BuyerPoId")[loop].childNodes[0].nodeValue;
		var XMLBuyerPoName 		= htmlobj.responseXML.getElementsByTagName("BuyerPoName")[loop].childNodes[0].nodeValue;
		var XMLColor 			= htmlobj.responseXML.getElementsByTagName("Color")[loop].childNodes[0].nodeValue;
		var XMLSize 			= htmlobj.responseXML.getElementsByTagName("Size")[loop].childNodes[0].nodeValue;
		var XMLUnit 			= htmlobj.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
		var XMLQty 				= htmlobj.responseXML.getElementsByTagName("Qty")[loop].childNodes[0].nodeValue;
		var XMLSubCatId			= htmlobj.responseXML.getElementsByTagName("SubCatId")[loop].childNodes[0].nodeValue;
		var XMLGRNNo			= htmlobj.responseXML.getElementsByTagName("GRNNo")[loop].childNodes[0].nodeValue;
		var XMLGRNTypeId		= htmlobj.responseXML.getElementsByTagName("GRNTypeId")[loop].childNodes[0].nodeValue;
		var XMLGRNType			= htmlobj.responseXML.getElementsByTagName("GRNType")[loop].childNodes[0].nodeValue;
	
		CreateGrid(XMLItemDescription,XMLMatDetailId,XMLStyleId,XMLStyleName,XMLBuyerPoId,XMLBuyerPoName,XMLColor,XMLSize,XMLUnit,XMLQty,XMLSubCatId,XMLGRNNo,XMLGRNTypeId,XMLGRNType);
	}
}

function CreateGrid(XMLItemDescription,XMLMatDetailId,XMLStyleId,XMLStyleName,XMLBuyerPoId,XMLBuyerPoName,XMLColor,XMLSize,XMLUnit,XMLQty,XMLSubCatId,XMLGRNNo,XMLGRNTypeId,XMLGRNType)
{
	var tbl 		= document.getElementById('tblMain');
	var lastRow 	= tbl.rows.length;	
	var row 		= tbl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell = row.insertCell(0);
	cell.className ="normalfntMid";
	cell.innerHTML = "<img src=\"../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" />";
	
	var cell = row.insertCell(1);
	cell.className ="normalfnt";
	cell.id =XMLMatDetailId;
	cell.innerHTML =XMLItemDescription;
	
	var cell = row.insertCell(2);
	cell.className ="normalfnt";
	cell.id =XMLStyleId;
	cell.innerHTML =XMLStyleName;
	
	var cell = row.insertCell(3);
	cell.className ="normalfnt";
	cell.id =XMLBuyerPoId;
	cell.innerHTML =XMLBuyerPoName;
	
	var cell = row.insertCell(4);
	cell.className ="normalfnt";
	cell.innerHTML =XMLColor;
	
	var cell = row.insertCell(5);
	cell.className ="normalfnt";
	cell.innerHTML =XMLSize;
	
	var cell = row.insertCell(6);
	cell.className ="normalfnt";
	cell.id=XMLSubCatId;
	cell.innerHTML =XMLUnit;
	
	var cell = row.insertCell(7);
	cell.className ="normalfnt";
	cell.innerHTML =XMLQty;
	
	var cell = row.insertCell(8);
	cell.className ="normalfntMid";
	cell.innerHTML="<input type=\"text\" class=\"txtbox\" name=\"txtQty\" id=\"txtQty\" value =\""+XMLQty+"\" style=\"width:83px;text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\"ValidateQty(this,"+mainArrayIndex+");\"/>";
	
	var cell = row.insertCell(9);
	cell.className ="normalfntMid";
	cell.id = 0;
	cell.innerHTML = "<img src=\"../../images/plus_16.png\" alt=\"add\" onclick=\"LoadBinPopUp(this,"+mainArrayIndex+");\"/>";
	
	var cell = row.insertCell(10);
	cell.className ="normalfnt";
	cell.innerHTML =XMLGRNNo;
	
	var cell = row.insertCell(11);
	cell.className ="normalfnt";
	cell.id =XMLGRNTypeId;
	cell.innerHTML =XMLGRNType;
	
	var details		= [];
	details[0]	= XMLStyleId;
	details[1]	= XMLBuyerPoId;
	details[2]	= XMLMatDetailId;
	details[3]	= XMLColor;
	details[4]	= XMLSize;
	details[6]	= XMLSubCatId;
	details[7]	= XMLUnit;
	details[8]	= parseFloat(XMLQty);
	details[9]	= XMLGRNNo;
	details[10]	= XMLGRNTypeId;
	
	Materials[mainArrayIndex]= details;
	mainArrayIndex++;
}
function LoadBinPopUp(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var mainStoreId		= $('#cboMainStore').val();
	var reqQty			= parseFloat(rw.cells[$main8].childNodes[0].value);
	pub_index			= index;
	var styleId			= rw.cells[$main2].id;
	var matDetailId		= rw.cells[$main1].id;
	var color			= rw.cells[$main4].childNodes[0].nodeValue;
	var size			= rw.cells[$main5].childNodes[0].nodeValue;
	var buyerPoNo		= rw.cells[$main3].id;
	var grnNo			= rw.cells[$main10].childNodes[0].nodeValue;
	var grnType			= rw.cells[$main11].id;
	if(mainStoreId==""){
		alert("Please select the 'Main Stores'.");
		return;
	}
	else if(pub_commonbin == 1)
	{
		alert("Common Bin System Activated.\nNo need to add bins.\nAll the bin details will save to Common Bin automatically.");
		return;
	}

	var url = 'binallocation.php?MainStoreId='+mainStoreId+ '&ReqQty='+reqQty+ '&StyleId='+styleId+ '&MatDetailId='+matDetailId+'&Color='+URLEncode(color)+ '&Size='+URLEncode(size)+ '&BuyerPoNo='+URLEncode(buyerPoNo)+ '&grnNo='+grnNo+ '&grnType='+grnType;
	htmlobj=$.ajax({url:url,async:false});
	ShowExtraRequest(htmlobj);
}

function ShowExtraRequest(htmlobj)
{
	drawPopupArea(650,350,'frmBinAllocation');				
	var HTMLText = htmlobj.responseText;
	document.getElementById('frmBinAllocation').innerHTML = HTMLText;				
}
function GetStockQty(objbin)
{
	var tbl = document.getElementById('tblBinItem');
	var rw = objbin.parentNode.parentNode;
		
	if (objbin.checked){	
	    totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
		var reqQty = parseFloat(rw.cells[$bin0].lastChild.nodeValue);
		var issueQty = rw.cells[$bin1].childNodes[0].value;
		rw.cells[$bin0].childNodes[0].value = 0;
		var issueLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ ){
				if (tbl.rows[loop].cells[$bin2].childNodes[0].checked)	
						issueLoopQty +=  parseFloat(tbl.rows[loop].cells[$bin1].childNodes[0].value);				
			}		
				var reduceQty = parseFloat(totReqQty) - parseFloat(issueLoopQty);

					if (reqQty <= reduceQty)
						rw.cells[$bin1].childNodes[0].value = reqQty ;					
					else
						 rw.cells[$bin1].childNodes[0].value = reduceQty;
	}	
	else 
		rw.cells[$bin1].childNodes[0].value = 0;
}

function SetBinItemQuantity(obj)
{	
	var tblMain =document.getElementById("tblMain");				
	var tblBin = document.getElementById('tblBinItem');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPLoopQty = 0;	
	
		for (loop =1; loop < tblBin.rows.length; loop++){
			if (tblBin.rows[loop].cells[$bin2].childNodes[0].checked){		
					GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[$bin1].childNodes[0].value);
			}	
		}
	
	if (GPLoopQty == totReqQty ){	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for(var loop = 1 ;loop < tblBin.rows.length ; loop ++ ){
				if (tblBin.rows[loop].cells[$bin2].childNodes[0].checked){					
					var Bindetails = [];
					Bindetails[0]  =   parseFloat(tblBin.rows[loop].cells[$bin1].childNodes[0].value); // issueQty
					Bindetails[1]  =   tblBin.rows[loop].cells[$bin6].id; 	// MainStores
					Bindetails[2]  =   tblBin.rows[loop].cells[$bin5].id;	// SubStores
					Bindetails[3]  =   tblBin.rows[loop].cells[$bin4].id; 	// Location
					Bindetails[4]  =   tblBin.rows[loop].cells[$bin3].id; 	// BinId							
					BinMaterials[mainBinArrayIndex] = Bindetails;
					mainBinArrayIndex ++;						
				}
			}
		Materials[pub_index][5] = BinMaterials;				
		tblMain.rows[pub_index+1].className = "bcgcolor-tblrowLiteBlue";
		tblMain.rows[pub_index+1].cells[$main9].id =1;
		closeWindow();		
	}
	else{
		alert ("Allocated Qty must Equal with Issue Qty. \nIssue Qty =" + totReqQty + "\nAllocated Qty =" + GPLoopQty +"\nVariance is =" +(totReqQty-GPLoopQty));
		return false;
	}	
}
function SaveValidation()
{
	document.getElementById('cmdConfirm').style.display='none';
	showBackGroundBalck();
	if (!Validate())
	{
		document.getElementById('cmdConfirm').style.display='inline';
		hideBackGroundBalck();
		return;		
	}
	LoadJobNo();
}
function Validate()
{
	var tbl = document.getElementById('tblMain');
	if(tbl.rows.length<=1){
		alert("No details appear to save.");
		return false;
	}
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		var qty = parseFloat(tbl.rows[loop].cells[$main8].childNodes[0].value);
		var qty	= (isNaN(qty)? 0:qty);
		if(qty=="" || qty ==0)
		{
			alert("Sorry!\nCannot proceed with '0' Or empty qty.")
			return false;
		}
		var checkBin = tbl.rows[loop].cells[$main9].id;
		if(checkBin=='0' && pub_commonbin == '0')
		{
			alert ("Cannot Save without Allocation Bin \nPlease Allocate the bin in Line No : " + [loop] +"." )
			return false;
		}
	}
	return true;
}
function LoadJobNo()
{
	var No = document.getElementById("txtTransferNo").value
	if (No=="")
	{
		var url = 'leftoverdb.php?RequestType=LoadNo';
		htmlobj=$.ajax({url:url,async:false});
		LoadJobNoRequest(htmlobj);
	}
	else
	{		
		No = No.split("/");
		
		pub_No =parseInt(No[1]);
		pub_Year = parseInt(No[0]);
		Save();
	}
}

function LoadJobNoRequest(htmlobj)
{
	var XMLAdmin	= htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
	if(XMLAdmin=="TRUE")
	{
		var XMLNo 	= htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
		var XMLYear = htmlobj.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
		pub_No =parseInt(XMLNo);
		pub_Year = parseInt(XMLYear);
		document.getElementById("txtTransferNo").value = pub_Year + "/" + pub_No;			
		Save();
	}
	else
	{
		alert("Please contact system administrator to Assign New Allocation No....");
		document.getElementById('cmdConfirm').style.display='inline';
		hideBackGroundBalck();
	}
}
function Save()
{
	pub_validateCount 		= 0;
	pub_validateBinCount	= 0;
	if(document.getElementById("txtTransferNo").value=="")
	{
		alert ("No 'Allocation No' appear to save.");
		document.getElementById('cmdConfirm').style.display='inline';
		return
	}	

	var remarks 		= document.getElementById('txtRemarks').value;	
	var toStyleId		= document.getElementById('tdToStyleId').title;
	var toBuyerPoId		= document.getElementById('tdBuyerPoId').title;
	
	var url = 'leftoverdb.php?RequestType=SaveHeader&no=' +pub_No+ '&year=' +pub_Year+ '&remarks=' +URLEncode(remarks);
	htmlobj=$.ajax({url:url,async:false});

	for (loop = 0 ; loop < Materials.length ; loop ++)
	{	
		var details = Materials[loop] ;
		if 	(details!=null)
		{
			var styleId		= details[0];
			var buyerPoNo	= details[1];
			var matDetailId	= details[2];
			var color 		= details[3];
			var size 		= details[4];
			var binArray 	= details[5];
			var subCatId	= details[6];
			var units 		= details[7];
			var qty 		= details[8];
			var grnNo 		= details[9];
			var grnType		= details[10];
			pub_validateCount++;
				
	var url = 'leftoverdb.php?RequestType=SaveDetails&no=' +pub_No+ '&year=' +pub_Year+ '&styleId=' +styleId+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&matDetailId=' +matDetailId+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&qty=' +qty+ '&grnNo='+grnNo+ '&grnType='+grnType;
	htmlobj=$.ajax({url:url,async:false});
	
			for (i = 0; i < binArray.length; i++)
			{
				var Bindetails 		= binArray[i];
				var stockQty	= Bindetails[0];	// qty
				var mainStoreId	= Bindetails[1]; 	// MainStores
				var subStoreId	= Bindetails[2];	// SubStores
				var locationId	= Bindetails[3]; 	// Location
				var binId		= Bindetails[4]; 	// BinId						
				pub_validateBinCount++;
			
				var url='leftoverdb.php?RequestType=SaveBinDetails&no=' +pub_No+ '&year=' +pub_Year+ '&styleId=' +URLEncode(styleId)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&matDetailId=' +matDetailId+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&stockQty=' +stockQty+ '&mainStoreId=' +mainStoreId+ '&subStoreId=' +subStoreId+ '&locationId=' +locationId+ '&binId=' +binId+ '&subCatId=' +subCatId+ '&toStyleId=' +toStyleId+ '&toBuyerPoId='+URLEncode(toBuyerPoId)+ '&grnNo='+grnNo+ '&grnType='+grnType;
				htmlobj=$.ajax({url:url,async:false});
			}
		}
	}
	SaveValidate();
}

function SaveValidate()
{	
	var url = 'leftoverdb.php?RequestType=SaveValidate&no=' +pub_No+ '&year=' +pub_Year+ '&validateCount=' +pub_validateCount+ '&validateBinCount=' +pub_validateBinCount;
	htmlobj=$.ajax({url:url,async:false});
	SaveValidateRequest(htmlobj);
}

function SaveValidateRequest(htmlobj)
{
	var XMLCountHeader		= htmlobj.responseXML.getElementsByTagName("recCountHeader")[0].childNodes[0].nodeValue;
	var XMLCountDetails		= htmlobj.responseXML.getElementsByTagName("recCountDetails")[0].childNodes[0].nodeValue;				
	var XMLCountBinDetails	= htmlobj.responseXML.getElementsByTagName("recCountBinDetails")[0].childNodes[0].nodeValue;
		
	if((XMLCountHeader=="TRUE") && (XMLCountDetails=="TRUE") &&(XMLCountBinDetails=="TRUE"))
	{
		alert ("Transfer No : " + document.getElementById("txtTransferNo").value +  " Saved Successfully!");							
		RestricInterface(1);
		document.getElementById('cmdConfirm').style.display='none';
		hideBackGroundBalck();
	}
	else 
	{
		alert("Sorry!\nError occured while saving the data. Please Save it again.");
		document.getElementById('cmdConfirm').style.display='inline';
		hideBackGroundBalck();
		return;
	}
}

function SearchPopUp()
{
	if(document.getElementById('NoSearch').style.visibility=="hidden")
	{
		document.getElementById('NoSearch').style.visibility = "visible";
		LoadPopUpNo();
	}
	else
	{
		document.getElementById('NoSearch').style.visibility="hidden";
		return;
	}	
}
function LoadPopUpNo()
{
	RomoveData('cboPopUpNo');
	document.getElementById('NoSearch').style.visibility = "visible";	
	var state = document.getElementById('cboState').value;
	var year  = document.getElementById('cboYear').value;
	
    var url = 'leftoverdb.php?RequestType=LoadPopNo&state='+state+'&year='+year;
    htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboPopUpNo').innerHTML = htmlobj.responseText;	
}

function LoadMainDetails()
{
	var no = $("#cboNo").val();
	if(no=="")
	{
		alert("Please select 'Allocation No'.");
		$('#cboNo').focus();
		return;
	}
	LoadHeaderDetails(no);
	LoadDetails(no);
	//RestricInterface(0);
	loadStoreDetails();
}

function loadPopUpDetails(obj)
{
	var status = $("#cboState").val();
	document.getElementById('cboNo').value = '';
	LoadHeaderDetails(obj);
	LoadDetails(obj);
	SearchPopUp();
	RestricInterface(status);
}

function LoadHeaderDetails(obj)
{
    var url = 'leftoverdb.php?RequestType=LoadHeaderDetails&no='+obj;
  	htmlobj=$.ajax({url:url,async:false});
	LoadHeaderDetailsRequest(htmlobj);
}

function LoadHeaderDetailsRequest(htmlobj)
{
	var XMLRemarks		= htmlobj.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
		document.getElementById('txtRemarks').value 	= XMLRemarks;
	var XMLToStyleName	= htmlobj.responseXML.getElementsByTagName("ToStyleName")[0].childNodes[0].nodeValue;	
		document.getElementById('txtToStyle').value 	= XMLToStyleName;
	var XMLToStyleId	=  htmlobj.responseXML.getElementsByTagName("ToStyleId")[0].childNodes[0].nodeValue;
		document.getElementById('tdToStyleId').title 	= XMLToStyleId;
	var ToBuyerPoName	= htmlobj.responseXML.getElementsByTagName("ToBuyerPoName")[0].childNodes[0].nodeValue;	
		document.getElementById('txtToBuyerPoNo').value = ToBuyerPoName;
	var XMLToBuyerPoId	=  htmlobj.responseXML.getElementsByTagName("ToBuyerPoId")[0].childNodes[0].nodeValue;
	document.getElementById('txtMerchandRemarks').value =htmlobj.responseXML.getElementsByTagName("merchantRemarks")[0].childNodes[0].nodeValue;
	var status = htmlobj.responseXML.getElementsByTagName("intStatus")[0].childNodes[0].nodeValue;
	RestricInterface(parseInt(status));
		document.getElementById('tdBuyerPoId').title 	= XMLToBuyerPoId;
}

function RestricInterface(status)
{
	
	if(status==1){
		document.getElementById("cmdConfirm").style.display="none";
		if(cancelLeftAllo)
			document.getElementById("cmdCancel").style.display="inline";
	}else if(status==10){
		document.getElementById("cmdConfirm").style.display="none";
		document.getElementById("cmdCancel").style.display="none";
	}else if(status==0){
		document.getElementById("cmdConfirm").style.display="inline";
		if(cancelLeftAllo)
			document.getElementById("cmdCancel").style.display="inline";
	}
}

function Cancel()
{
	var no = document.getElementById('txtTransferNo').value;
	if(no == '')
	{
		alert('Please select Leftover No');
		return;
	}
	var reason = prompt("Please enter cancel reason", "");
	if(reason == '' || reason == null)
	{
		alert('Sorry !\nYou cannot cancel allocation without having a reason');
		return false;
	}
	showBackGroundBalck();
    var url = 'leftoverdb.php?RequestType=Cancel&no='+no +'&reason='+URLEncode(reason);
    htmlobj=$.ajax({url:url,async:false});
	CancelRequest(htmlobj);
}
function CancelRequest(htmlobj)
{
	var XMLCheck= htmlobj.responseXML.getElementsByTagName("Check")[0].childNodes[0].nodeValue;		
	if(XMLCheck=="FALSE")
	{
		var XMLMessage= htmlobj.responseXML.getElementsByTagName("Message")[0].childNodes[0].nodeValue;
		alert(XMLMessage);
		hideBackGroundBalck();
	}
	else
	{
		alert("Cancelled successfully.");
		RestricInterface(10);
		hideBackGroundBalck();
	}
}
	
function ValidateQty(obj,index)
{
	var rw = obj.parentNode.parentNode;
	var allocateQty = parseFloat(rw.cells[7].childNodes[0].nodeValue);
	var qty = parseFloat(obj.value);
	
	if(allocateQty<qty){
		obj.value = allocateQty;
		Materials[index][8] = allocateQty;	
	}else{
		Materials[index][8] = qty;	
	}
	rw.cells[$main9].id = 0;
	rw.className = "bcgcolor-tblrowWhite";
}

function loadStoreDetails()
{
	var mainstoreID = $("#cboMainStore").val();
	
	if(mainstoreID != '')
	{
		var url = "leftoverdb.php?RequestType=getCommonBin";
		url += "&mainstoreID="+mainstoreID;		
		var htmlobj=$.ajax({url:url,async:false});
		pub_commonbin = htmlobj.responseText;
	}
}