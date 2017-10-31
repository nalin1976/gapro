//Start - main gri variables
$main0 						= 0;  	//delete button
$main1 						= 1;		//item description 
//$main2 					= 2;		//style Id
//$main3 					= 3;		//buyer pono
$main4 						= 2;		//color
$main5 						= 3;    	//size
$main6 						= 4;		//units
$main7 						= 5;		//allocared qty
$main8 						= 6;		//tranfer qty
$main9 						= 7;		//bin allocation image
$main10						= 8; 		//bulkPONo
$main11						= 9;			//bulkPOYear;
$main12						= 10;		//bulkGRNNo
$main13						= 11;		//bulkGRNYear
//End - main gri variables 

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
var checkLoop				= 0;
var pub_commonbin 			= 0;

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
	$("#bulkleftover")[0].reset();
	$("#tblMain tr:gt(0)").remove();
	RestricInterface(0);
	var url = 'bulkleftoverdb.php?RequestType=ReloadAllocationNo';
	htmlobj = $.ajax({url:url,async:false});
	document.getElementById('cboNo').innerHTML = htmlobj.responseText;
}
	
function LoadDetails(obj)
{
	document.getElementById("txtTransferNo").value = obj;
	var url = 'bulkleftoverdb.php?RequestType=LoadDetails&no='+obj;
	htmlobj = $.ajax({url:url,async:false});
	LoadDetailsRequest(htmlobj);
}
 
function LoadDetailsRequest(htmlobj)
{
	 var XMLLength 				= htmlobj.responseXML.getElementsByTagName("Qty");
	 RemoveAllRows('tblMain');
	 Materials 				= [];
	 mainArrayIndex =0;
	for(loop=0;loop<XMLLength.length;loop++)
	{
		var XMLItemDescription 	= htmlobj.responseXML.getElementsByTagName("ItemDescription")[loop].childNodes[0].nodeValue;
		var XMLMatDetailId 		= htmlobj.responseXML.getElementsByTagName("MatDetailId")[loop].childNodes[0].nodeValue;
		var XMLColor 			= htmlobj.responseXML.getElementsByTagName("Color")[loop].childNodes[0].nodeValue;
		var XMLSize 			= htmlobj.responseXML.getElementsByTagName("Size")[loop].childNodes[0].nodeValue;
		var XMLUnit 			= htmlobj.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
		var XMLQty 				= htmlobj.responseXML.getElementsByTagName("Qty")[loop].childNodes[0].nodeValue;
		var XMLSubCatId			= htmlobj.responseXML.getElementsByTagName("SubCatId")[loop].childNodes[0].nodeValue;
		var XMLBPONo			= htmlobj.responseXML.getElementsByTagName("BulkPONo")[loop].childNodes[0].nodeValue;
		var XMLBPOYear			= htmlobj.responseXML.getElementsByTagName("BulkPOYear")[loop].childNodes[0].nodeValue;
		var XMLBGRNNo			= htmlobj.responseXML.getElementsByTagName("BulkGRNNo")[loop].childNodes[0].nodeValue;
		var XMLBGRVYear			= htmlobj.responseXML.getElementsByTagName("BulkGRNYear")[loop].childNodes[0].nodeValue;
		
		CreateGrid(XMLItemDescription,XMLMatDetailId,XMLColor,XMLSize,XMLUnit,XMLQty,XMLSubCatId,XMLBPONo,XMLBPOYear,XMLBGRNNo,XMLBGRVYear);
	}
}

function CreateGrid(XMLItemDescription,XMLMatDetailId,XMLColor,XMLSize,XMLUnit,XMLQty,XMLSubCatId,XMLBPONo,XMLBPOYear,XMLBGRNNo,XMLBGRVYear)
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
	cell.innerHTML =XMLColor;
	
	var cell = row.insertCell(3);
	cell.className ="normalfnt";
	cell.innerHTML =XMLSize;
	
	var cell = row.insertCell(4);
	cell.className ="normalfnt";
	cell.id=XMLSubCatId;
	cell.innerHTML =XMLUnit;
	
	var cell = row.insertCell(5);
	cell.className ="normalfntRite";
	cell.innerHTML =XMLQty;
	
	var cell = row.insertCell(6);
	cell.className ="normalfntMid";
	cell.innerHTML="<input type=\"text\" class=\"txtbox\" name=\"txtQty\" id=\"txtQty\" value =\""+XMLQty+"\" style=\"width:83px;text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\"ValidateQty(this,"+mainArrayIndex+");\"/>";
	
	var cell = row.insertCell(7);
	cell.className ="normalfntMid";
	cell.id = 0;
	cell.innerHTML = "<img src=\"../../images/plus_16.png\" alt=\"add\" onclick=\"LoadBinPopUp(this,"+mainArrayIndex+");\"/>";
	
	var cell = row.insertCell(8);
	cell.className ="normalfntRite";
	cell.innerHTML =XMLBPONo;
	
	var cell = row.insertCell(9);
	cell.className ="normalfntRite";
	cell.innerHTML =XMLBPOYear;
	
	var cell = row.insertCell(10);
	cell.className ="normalfntRite";
	cell.innerHTML =XMLBGRNNo;
	
	var cell = row.insertCell(11);
	cell.className ="normalfntRite";
	cell.innerHTML =XMLBGRVYear;
	
	var details		= [];
	details[0]	= XMLMatDetailId;
	details[1]	= XMLColor;
	details[2]	= XMLSize;
	details[3]	= XMLSubCatId;
	details[4]	= XMLUnit;
	details[6]	= parseFloat(XMLQty);
	details[8]	= XMLBPONo;
	details[9]	= XMLBPOYear;
	details[10]	= XMLBGRNNo;
	details[11]	= XMLBGRVYear;
	
	Materials[mainArrayIndex]= details;
	mainArrayIndex++;
}

function LoadBinPopUp(obj,index)
{
	var mainStoreId		= document.getElementById('cboMainStore').value;
	if(mainStoreId==""){
		alert("Please select the \"Main Store\".");
		return;
	}
	if(pub_commonbin == 1)
	{
		alert("Common Bin System Activated.\nNo need to add bins.\nAll the bin details will save to Common Bin automatically.");return;
	}
		
	var rw 			= obj.parentNode.parentNode;	
	var matdetailId	= rw.cells[$main1].id;
	var color		= rw.cells[$main4].childNodes[0].nodeValue;
	var size		= rw.cells[$main5].childNodes[0].nodeValue;
	var reqQty		= parseFloat(rw.cells[$main8].childNodes[0].value);
	pub_index		= index;
	var grnNo		= rw.cells[$main12].childNodes[0].nodeValue;
	var grnYear		= rw.cells[$main13].childNodes[0].nodeValue;
	
	var url = 'binallocation.php?mainStoreId='+mainStoreId+ '&matdetailId='+matdetailId+ '&color='+color+ '&size='+size+ '&reqQty='+reqQty+ '&grnNo='+grnNo+ '&grnYear='+grnYear;
	htmlobj = $.ajax({url:url,async:false});
	ShowExtraRequest(htmlobj);
}

function ShowExtraRequest(htmlobj)
{
	drawPopupArea(650,350,'frmBinAllocation');				
	var HTMLText = htmlobj.responseText;
	document.getElementById('frmBinAllocation').innerHTML=HTMLText;				
}

function GetStockQty(objbin)
{
	var tbl = document.getElementById('tblBinItem');
	var rw = objbin.parentNode.parentNode;
		
	if (objbin.checked)
	{	
	    totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
		var reqQty = parseFloat(rw.cells[$bin0].lastChild.nodeValue);
		var issueQty = rw.cells[$bin1].childNodes[0].value;
		rw.cells[$bin0].childNodes[0].value = 0;
		var issueLoopQty = 0 ;
		
		for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
		{
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
	
	for (loop =1; loop < tblBin.rows.length; loop++)
	{
		if (tblBin.rows[loop].cells[$bin2].childNodes[0].checked)
			GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[$bin1].childNodes[0].value);
	}
	
	if (GPLoopQty == totReqQty )
	{	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
		for(var loop = 1 ;loop < tblBin.rows.length ; loop ++ )
		{
			if (tblBin.rows[loop].cells[$bin2].childNodes[0].checked)
			{					
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
	else
	{
		alert ("Allocated Qty must equal with Issue Qty. \nIssue Qty =" + totReqQty + "\nAllocated Qty =" + GPLoopQty +"\nVariance is =" +(totReqQty-GPLoopQty));
		return false;
	}	
}
function SaveValidation()
{
	showBackGroundBalck();
	if (!Validate()){
		hideBackGroundBalck();
		return;		
	}
	LoadJobNo();
}
function Validate()
{
	if(document.getElementById('cboNo').value == '')
	{
		alert('Please select \"Allocation No\"');
		return false;
	}
	var tbl = document.getElementById('tblMain');
	if(tbl.rows.length<=1)
	{
		alert("Please Allocate items ");
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
		if(checkBin=='0' && pub_commonbin ==0)
		{
			alert ("Cannot save without allocation Bin \nPlease Allocate the bin in Line No : " + [loop] +"." )
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
		var url = 'bulkleftoverdb.php?RequestType=LoadNo';
		var htmlobj=$.ajax({url:url,async:false});
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
		pub_No      = parseInt(XMLNo);
		pub_Year    = parseInt(XMLYear);
		document.getElementById("txtTransferNo").value=pub_Year + "/" + pub_No;			
		Save();	
	}
	else
	{
		alert("Please contact system administrator to Assign New Return No....");
		hideBackGroundBalck();
	}	
}

function Save()
{
	pub_validateCount 		= 0;
	pub_validateBinCount	= 0;
	checkLoop = 0;
	if(document.getElementById("txtTransferNo").value==""){alert ("No details appear to save.");return}	

	var remarks 		= document.getElementById('txtRemarks').value;	
	var toStyleId		= document.getElementById('tdToStyleId').title;
	var toBuyerPoId		= document.getElementById('tdBuyerPoId').title;
	var mainStoreId     = document.getElementById('cboMainStore').value

	var url = 'bulkleftoverdb.php?RequestType=SaveHeader';
		url += '&no='+pub_No;
		url += '&year='+pub_Year;
		url += '&remarks='+URLEncode(remarks);
		
	var htmlobj=$.ajax({url:url,async:false});
	var resAlloHead = htmlobj.responseText;

	if(resAlloHead == '1')
	{
		for (loop = 0 ; loop < Materials.length ; loop ++)
		{	
			var details = Materials[loop] ;
			if 	(details!=null)
			{
				var matDetailId	= details[0];
				var color 		= details[1];
				var size 		= details[2];			
				var subCatId	= details[3];
				var units 		= details[4];
				var binArray 	= details[5];
				var qty 		= details[6];
				var BPONo 		= details[8];
				var BPOYear		= details[9];
				var BGRNNo		= details[10];
				var BGRNYear 	= details[11];
				pub_validateCount++;
					
		var url = 'bulkleftoverdb.php?RequestType=SaveDetails';
			url += '&no=' +pub_No;
			url += '&year='+pub_Year;
			url += '&matDetailId=' +matDetailId;
			url += '&color=' +URLEncode(color);
			url += '&size=' +URLEncode(size);
			url += '&units=' +units;
			url += '&qty=' +qty;
			url += '&BPONo='+BPONo;
			url += '&BPOYear='+BPOYear;
			url += '&BGRNNo='+BGRNNo;
			url += '&BGRNYear='+BGRNYear;
			
		var htmlobj=$.ajax({url:url,async:false});
		var resAlloDetail = htmlobj.responseText;
		
				if(resAlloDetail == '1')
				{
					if(pub_commonbin == 0)
					{
						for (i = 0; i < binArray.length; i++)
						{
							var Bindetails 		= binArray[i];
							var stockQty	= Bindetails[0];	// qty
							var mainStoreId	= Bindetails[1]; 	// MainStores
							var subStoreId	= Bindetails[2];	// SubStores
							var locationId	= Bindetails[3]; 	// Location
							var binId		= Bindetails[4]; 	// BinId						
							pub_validateBinCount++;
						
							var url = 'bulkleftoverdb.php?RequestType=SaveBinDetails';
								url += '&no=' +pub_No;
								url += '&year='+pub_Year;
								url += '&matDetailId=' +matDetailId;
								url += '&color=' +URLEncode(color);
								url += '&size=' +URLEncode(size);
								url += '&units=' +units;
								url += '&stockQty=' +stockQty;
								url += '&mainStoreId=' +mainStoreId;
								url += '&subStoreId=' +subStoreId;
								url += '&locationId=' +locationId;
								url += '&binId=' +binId;
								url += '&subCatId=' +subCatId;
								url += '&toStyleId=' +toStyleId;
								url += '&toBuyerPoId='+URLEncode(toBuyerPoId);
								url += '&BPONo='+BPONo;
								url += '&BPOYear='+BPOYear;
								url += '&BGRNNo='+BGRNNo;
								url += '&BGRNYear='+BGRNYear;
								
							var htmlobj=$.ajax({url:url,async:false});
						}
					}
					else
					{
						pub_validateBinCount++;	
						var url = 'bulkleftoverdb.php?RequestType=SaveBinDetails';
								url += '&no=' +pub_No;
								url += '&year='+pub_Year;
								url += '&matDetailId=' +matDetailId;
								url += '&color=' +URLEncode(color);
								url += '&size=' +URLEncode(size);
								url += '&units=' +units;
								url += '&stockQty=' +qty;
								url += '&mainStoreId=' +mainStoreId;
								url += '&subCatId=' +subCatId;
								url += '&toStyleId=' +toStyleId;
								url += '&toBuyerPoId='+URLEncode(toBuyerPoId);
								url += '&BPONo='+BPONo;
								url += '&BPOYear='+BPOYear;
								url += '&BGRNNo='+BGRNNo;
								url += '&BGRNYear='+BGRNYear;
								url += '&pub_commonbin='+pub_commonbin;
							var htmlobj=$.ajax({url:url,async:false});
					}
				}
			}
		}
	}
	SaveValidate();
}

function SaveValidate()
{		
	var url = 'bulkleftoverdb.php?RequestType=SaveValidate';
	url += '&no=' +pub_No;
	url += '&year='+pub_Year;
	url += '&validateCount=' +pub_validateCount;
	url += '&validateBinCount=' +pub_validateBinCount;
	
	var htmlobj=$.ajax({url:url,async:false});
	var XMLCountHeader		= htmlobj.responseXML.getElementsByTagName("recCountHeader")[0].childNodes[0].nodeValue;
	var XMLCountDetails		= htmlobj.responseXML.getElementsByTagName("recCountDetails")[0].childNodes[0].nodeValue;				
	var XMLCountBinDetails	= htmlobj.responseXML.getElementsByTagName("recCountBinDetails")[0].childNodes[0].nodeValue;
	
	if((XMLCountHeader=="TRUE") && (XMLCountDetails=="TRUE") &&(XMLCountBinDetails=="TRUE"))
	{
		alert ("Transfer No : " + document.getElementById("txtTransferNo").value +  " confirmed successfully!");							
		RestricInterface(1);
		hideBackGroundBalck();	
	}
	else 
	{
		checkLoop++;
		if(checkLoop>20)
		{
			alert("Sorry!\nError occured while saving the data. Please Save it again.");
			hideBackGroundBalck();
			checkLoop = 0;
			return;
		}
		else
		SaveValidate();	
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
	
    var url = 'bulkleftoverdb.php?RequestType=LoadPopNo&state='+state+'&year='+year;
   	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboPopUpNo').innerHTML = htmlobj.responseText;	
}

function LoadMainDetails(obj)
{
	var no = $("#cboNo").val();
	if(no=="")
	{
		alert("Please select 'Bilk Allocation No'.");
		$('#cboNo').focus();
		return;
	}
	LoadHeaderDetails(no);
	LoadDetails(no);
	//RestricInterface(0);
}

function loadPopUpDetails(obj)
{
	document.getElementById('cboNo').value = '';
	var status = $("#cboState").val();
	LoadHeaderDetails(obj);
	LoadDetails(obj);
	SearchPopUp();
	RestricInterface(status);
}
function LoadHeaderDetails(obj)
{
    var url = 'bulkleftoverdb.php?RequestType=LoadHeaderDetails&no='+obj;
    htmlobj=$.ajax({url:url,async:false});
	LoadHeaderDetailsRequest(htmlobj);
}

function LoadHeaderDetailsRequest(htmlobj)
{
		var XMLRemarks			= htmlobj.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
			document.getElementById('txtRemarks').value 	= XMLRemarks;
		var XMLToStyleName		= htmlobj.responseXML.getElementsByTagName("ToStyleName")[0].childNodes[0].nodeValue;	
			document.getElementById('txtToStyle').value 	= XMLToStyleName;
		var XMLToStyleId		=  htmlobj.responseXML.getElementsByTagName("ToStyleId")[0].childNodes[0].nodeValue;
			document.getElementById('tdToStyleId').title 	= XMLToStyleId;
			var ToBuyerPoName	= htmlobj.responseXML.getElementsByTagName("ToBuyerPoName")[0].childNodes[0].nodeValue;	
			document.getElementById('txtToBuyerPoNo').value = ToBuyerPoName;
		var XMLToBuyerPoId		=  htmlobj.responseXML.getElementsByTagName("ToBuyerPoId")[0].childNodes[0].nodeValue;
			document.getElementById('tdBuyerPoId').title 	= XMLToBuyerPoId;
		var XMLMainstoreId		=  htmlobj.responseXML.getElementsByTagName("mainStore")[0].childNodes[0].nodeValue;
			document.getElementById('cboMainStore').value 	= XMLMainstoreId;
		document.getElementById('txtMerchantRemarks').value = htmlobj.responseXML.getElementsByTagName("merchantRemarks")[0].childNodes[0].nodeValue;
		var status = htmlobj.responseXML.getElementsByTagName("intStatus")[0].childNodes[0].nodeValue;
			document.getElementById("cboMainStore").disabled="disabled";
			 RestricInterface(parseInt(status))
}
	
function RestricInterface(status)
{
	if(status==1){
		document.getElementById("cmdConfirm").style.display="none";
		if(cancelBulkAllo)
			document.getElementById("cmdCancel").style.display="inline";
	}else if(status==10){
		document.getElementById("cmdConfirm").style.display="none";
		document.getElementById("cmdCancel").style.display="none";
	}else if(status==0){
		document.getElementById("cmdConfirm").style.display="inline";
		if(cancelBulkAllo)
			document.getElementById("cmdCancel").style.display="inline";
	}
}

function Cancel()
{
	var no = document.getElementById('txtTransferNo').value;
	if(no == '')
	{
		alert("Please select 'Allocation No'");
		return;
	}
	var reason = prompt("Please enter cancel reason", "");
	if(reason == '' || reason == null)
	{
		alert('Sorry!\nYou cannot cancel allocation without having a reason.');
		return false;
	}
	showBackGroundBalck();
	var url='bulkleftoverdb.php?RequestType=Cancel&no='+no+'&reason='+URLEncode(reason);
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
	var allocateQty = parseFloat(rw.cells[$main7].childNodes[0].nodeValue);
	var qty = parseFloat(obj.value);
	
	if(allocateQty<qty)
	{
		obj.value = allocateQty;
		Materials[index][6] = allocateQty;
	}
	else
		Materials[index][6] = qty;
	
	rw.cells[$main9].id = 0;
	rw.className = "bcgcolor-tblrowWhite";
}

function loadStoreDetails()
{
	var mainstoreID = $("#cboMainStore").val();
	
	if(mainstoreID != '')
	{
		var url = "bulkleftoverdb.php?RequestType=getCommonBin";
			url += "&mainstoreID="+mainstoreID;
			
			var htmlobj=$.ajax({url:url,async:false});
			pub_commonbin = htmlobj.responseText;
	}
}

function RemoveItem(obj,index)
{	
	if(confirm('Are you sure you want to remove this item?'))
	{
		var td = obj.parentNode;
		var tro = td.parentNode;		
		tro.parentNode.removeChild(tro);	
		Materials[index] = null;		
	}
}