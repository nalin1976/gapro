var xmlHttpAllocation = [];

var pub_No 			= 0;
var pub_Year 		= 0;
var pub_detailCount = 0;	
var pub_checkLoop   = 0;
var pub_BAlloUrl    = "/gaprohela/allocation_inbom/";
function createXMLHttpRequestAllocation(index) 
 {
	if (window.ActiveXObject) 
	{
		xmlHttpAllocation[index] = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttpAllocation[index] = new XMLHttpRequest();
	}
 }
 
var browserType;

if (document.layers) {browserType = "nn4"}
if (document.all) {browserType = "ie"}
if (window.navigator.userAgent.toLowerCase().match("gecko")) {
 browserType= "gecko"
}

function validatePopUp1(divId)
{
	if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById(divId)');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById(divId)');
  else
     document.poppedLayer =
        eval('document.layers[divId]');
		
	if(divId=="realtooltip1"){
		show('realtooltip1');
		hide('realtooltip2');
		hide('realtooltip3');
	}else if(divId=="realtooltip2"){
		hide('realtooltip1');
		show('realtooltip2');
		hide('realtooltip3');
	}else if(divId=="realtooltip3"){
		hide('realtooltip1');
		hide('realtooltip2');
		show('realtooltip3');
	}			
}

function hide(divId) {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById(divId)');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById(divId)');
  else
     document.poppedLayer =
        eval('document.layers[divId]');
  document.poppedLayer.style.display = "none";
}

function show(divId) {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById(divId)');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById(divId)');
  else
     document.poppedLayer =
         eval('document.layers[divId]');
  document.poppedLayer.style.display = "inline";
}
function ValidationLeftOver()
{
	var tbl = document.getElementById('tblLeftOver');
	var mainStoreID = document.getElementById('cboMainStore').value;
	var manufactCom = document.getElementById('cboManufactLeftCompany').value;
	var check = true;
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[8].childNodes[0].checked){
			check = false;
		}
	}
	if(check){
		alert("Sorry!\nCannot proceed without selecting a row.Please select at least one row.");
		return;
	}
	if(manufactCom == '')
	{
		alert("Please select the 'Manufacturing Company'");
		document.getElementById('cboManufactLeftCompany').focus();
		return;
	}
	/*showBackGroundBalck();
	if(validateLeftOverQtywithBomQty())
	{
		createXMLHttpRequestAllocation(1);	
	xmlHttpAllocation[1].onreadystatechange=GetNoRequest;
	xmlHttpAllocation[1].open("GET",'allocation_inbom/allocationdb.php?RequestType=GetNo&mainStoreID='+mainStoreID,true);
	xmlHttpAllocation[1].send(null);
		
		}
		else
		{
			hideBackGroundBalck();
			}*/
	showBackGroundBalck();
	createXMLHttpRequestAllocation(1);	
	xmlHttpAllocation[1].onreadystatechange=GetNoRequest;
	xmlHttpAllocation[1].open("GET",'allocation_inbom/allocationdb.php?RequestType=GetNo&mainStoreID='+mainStoreID,true);
	xmlHttpAllocation[1].send(null);
}
function GetNoRequest()
{
	if(xmlHttpAllocation[1].readyState == 4 && xmlHttpAllocation[1].status == 200){			
		var XMLNo = xmlHttpAllocation[1].responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
		
		if(XMLNo != 'NA')
		{
			var XMLYear = xmlHttpAllocation[1].responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
		
			pub_No = XMLNo;
			pub_Year = XMLYear;
			SaveDetails();
		}
		else
		{
			alert('Leftover Allocation NO range not available for selected Main Store\n Please contact system administrator');
			hideBackGroundBalck();
			return;
		}
		
		
	}
}

function SaveDetails()
{
	pub_checkLoop 	= 0;
	pub_detailCount = 0;
	var toStyleId	= document.getElementById('tdStyleId').title;
	var matDetailId	= document.getElementById('tdMatDetailId').title;
	var toBuyerPoNo	= document.getElementById('cboToBuyerPoNo').value;
	var mainStoreID = document.getElementById('cboMainStore').value;
	var manufactCom = document.getElementById('cboManufactLeftCompany').value;
	var merchantRemarks = document.getElementById('txtLAlloRemarks').value;
	var count 		= 0;
	var tbl 		= document.getElementById('tblLeftOver');
	
	var url  = 'allocation_inbom/allocationdb.php?RequestType=SaveHeader';
		url += '&no='+pub_No;
		url += '&year='+pub_Year;
		url += '&matDetailId='+matDetailId;
		url += '&toStyleId='+toStyleId;
		url += '&toBuyerPoNo='+URLEncode(toBuyerPoNo);
		url += '&mainStoreID='+mainStoreID;
		url += '&manufactCom='+manufactCom;
		url += '&merchantRemarks='+URLEncode(merchantRemarks);
					
	var htmlobj=$.ajax({url:url,async:false});
	var responseHeader = htmlobj.responseText;	
	
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[8].childNodes[0].checked)
		{
			var fromStyleId = tbl.rows[loop].cells[2].id;
			var buyerPoNo 	= tbl.rows[loop].cells[3].id;
			var color		= tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var size  		= tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			var units  		= tbl.rows[loop].cells[6].childNodes[0].nodeValue;
			var qty 		= tbl.rows[loop].cells[9].childNodes[0].value;
			var grnNo 		= tbl.rows[loop].cells[10].childNodes[0].nodeValue;
			var grnYear		= tbl.rows[loop].cells[11].childNodes[0].nodeValue;
			var grnType		= tbl.rows[loop].cells[12].id;

			pub_detailCount++
			var url = 'allocation_inbom/allocationdb.php?RequestType=SaveDetails';
			url += '&no='+pub_No;
					url += '&year='+pub_Year;
					url += '&fromStyleId='+fromStyleId;
					url += '&matDetailId='+matDetailId;
					//url += '&toStyleId='+toStyleId;
					url += '&color='+URLEncode(color);
					//url += '&toBuyerPoNo='+URLEncode(toBuyerPoNo);
					url += '&size='+URLEncode(size);
					url += '&units='+URLEncode(units);
					url += '&qty='+qty;
					url += '&buyerPoNo='+URLEncode(buyerPoNo);
					//url += '&mainStoreID='+mainStoreID;
					url += '&grnNo='+grnNo;
					url += '&grnYear='+grnYear;
					url += '&grnType='+grnType;
					
			var htmlobj=$.ajax({url:url,async:false});
			var responseID = htmlobj.responseText;
			
			if(responseID == '1')
			{
				count++;
			}
		}
	}
	
	if(count == pub_detailCount && responseHeader=='1')
	{
		var type = 'left';
		var url = 'allocation_inbom/allocationdb.php?RequestType=EmailAllocationNo';
		url += '&no='+pub_No;
		url += '&year='+pub_Year;
		url += '&toStyleId='+toStyleId;
		url += '&mainStoreID='+mainStoreID;
		url += '&type='+type;
		var htmlobj=$.ajax({url:url,async:false});
		
		var leftAlloNo = pub_No+"/"+pub_Year;
		alert("Left Over Transfer No : \""+ leftAlloNo  +"\" saved successfully!");
		viewLeftOver();
		hideBackGroundBalck();
		closeWindow();
	}
	else
	{
		alert("Sorry!\nError occured while saving the data. Please Save it again.");
		hideBackGroundBalck();
	}
}
function SaveValidation()
{
	createXMLHttpRequestAllocation(2);	
	xmlHttpAllocation[2].onreadystatechange=SaveValidationRequest;
	xmlHttpAllocation[2].open("GET",'allocation_inbom/allocationdb.php?RequestType=SaveValidation&no='+pub_No+ '&year='+pub_Year+ '&detailCount='+pub_detailCount,true);
	xmlHttpAllocation[2].send(null);
}
	function SaveValidationRequest()
	{
		if(xmlHttpAllocation[2].readyState == 4 && xmlHttpAllocation[2].status == 200){	
			var XMLHeader 	= xmlHttpAllocation[2].responseXML.getElementsByTagName("Header")[0].childNodes[0].nodeValue;
			var XMLDetails	= xmlHttpAllocation[2].responseXML.getElementsByTagName("Details")[0].childNodes[0].nodeValue;
			var XMLNo	= xmlHttpAllocation[2].responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
			
			if(XMLHeader=="TRUE" && XMLDetails=="TRUE")
			{
				alert("Left Over Transfer No : \""+XMLNo+"\" saved successfully!");
				//document.getElementById("butAllocatonSave").style.visibility="hidden";
				hideBackGroundBalck();
				//closeWindow();
			}
			else
			{
				pub_checkLoop++;
				if(pub_checkLoop>20){
					alert("Sorry!\nError occured while saving the data. Please Save it again.");
					document.getElementById("butAllocatonSave").style.visibility="visible";
					hideBackGroundBalck();
					pub_checkLoop = 0;
					return;
				}
					else{							
					SaveValidation();							
				}
			}

		}
	}
function GetQty(obj)
{
	var rw = obj.parentNode.parentNode;
	//when user tick the check box display the stock qty in transfer qty
	/*if(obj.checked)
	{
		var stockQty = parseFloat(rw.cells[7].childNodes[0].nodeValue);
		rw.cells[9].childNodes[0].value = stockQty;
	}else{
		rw.cells[9].childNodes[0].value = "";
	}*/	
	
	//validate stock qty with the allocation qty
	if(obj.checked)
	{
		var stockQty = parseFloat(rw.cells[7].childNodes[0].nodeValue);
		var ratioQty = parseFloat(rw.cells[4].id);
		
		//get already allocated bulk qty
		var allocatedQty = parseFloat(getAlreadyLeftoverAlloQty(rw.cells[4].childNodes[0].nodeValue,rw.cells[5].childNodes[0].nodeValue,'tblLeftOver'));
		var canAllocateTotalRatioQty = document.getElementById('tdAlloTotRatioLO').title;
		var totRatioQty = parseFloat(rw.cells[5].id);
		
		if(canAllocateTotalRatioQty)
		{
			if(allocatedQty >= totRatioQty)
			{
				//alert('Cant exceed Material Ratio Quntity');
				obj.checked = false;
				return false;
			}
			else
			{	
				var baltoAllocate = totRatioQty-allocatedQty;
				if(baltoAllocate>stockQty)
					rw.cells[9].childNodes[0].value = stockQty;
				else
					rw.cells[9].childNodes[0].value = baltoAllocate;
			}
		}
		else
		{
			if(allocatedQty >= ratioQty)
			{
				//alert('Cant exceed Material Ratio Quntity');
				obj.checked = false;
				return false;
			}
			else
			{	
				var baltoAllocate = ratioQty-allocatedQty;
				if(baltoAllocate>stockQty)
					rw.cells[9].childNodes[0].value = stockQty;
				else
					rw.cells[9].childNodes[0].value = baltoAllocate;
			}
		}
			
	}
	else{
		
		rw.cells[9].childNodes[0].value = "";
	}
	
}

function GetLiabilityQty(obj)
{
	var rw = obj.parentNode.parentNode;
		
	//validate stock qty with the allocation qty
	if(obj.checked)
	{
		var stockQty = parseFloat(rw.cells[7].childNodes[0].nodeValue);
		var ratioQty = parseFloat(rw.cells[4].id);
		
		//get already allocated bulk qty
		var allocatedQty = parseFloat(getAlreadyLeftoverAlloQty(rw.cells[4].childNodes[0].nodeValue,rw.cells[5].childNodes[0].nodeValue,'tblLiability'));
		
		var totRatioQty = parseFloat(rw.cells[5].id);
		
		if(allocatedQty >= ratioQty)
		{
			//alert('Cant exceed Material Ratio Quntity');
			obj.checked = false;
			return false;
		}
		else
		{	
			var baltoAllocate = ratioQty-allocatedQty;
			if(baltoAllocate>stockQty)
				rw.cells[9].childNodes[0].value = stockQty;
			else
				rw.cells[9].childNodes[0].value = baltoAllocate;
		}
		
			
	}
	else{
		
		rw.cells[9].childNodes[0].value = "";
	}
	
}
function Check(obj)
{
	var qty = (isNaN(parseFloat(obj.value)) ?0:parseFloat(obj.value));
	var rw = obj.parentNode.parentNode;
	if(qty=="" || qty==0)
	{
		rw.cells[8].childNodes[0].checked=false;
		rw.cells[9].childNodes[0].value = '';
	}
	else
		rw.cells[8].childNodes[0].checked=true
}
function ValidateQty(obj)
{
	var rw 			= obj.parentNode.parentNode;
	var transQty 	= parseFloat(obj.value);
	var stockQty 	= parseFloat(rw.cells[7].childNodes[0].nodeValue);	
	var ratioQty    = parseFloat(rw.cells[4].id);	
	/*if(stockQty<transQty)
	{		
		rw.cells[9].childNodes[0].value=stockQty;
	}
	Check(obj);*/
	var allocatedQty = parseFloat(getAlreadyLeftoverAlloQty(rw.cells[4].childNodes[0].nodeValue,rw.cells[5].childNodes[0].nodeValue,'tblLeftOver'));
	var canAllocateTotalRatioQty = document.getElementById('tdAlloTotRatioLO').title;
	var totRatioQty = parseFloat(rw.cells[5].id);
	
	if(canAllocateTotalRatioQty)
	{
		var baltoAllocate =  totRatioQty-allocatedQty;
		if(allocatedQty >= totRatioQty)
		{
			//alert('Cant exceed Material Ratio Quntity');
			rw.cells[8].childNodes[0].checked = false;
			var alreadyAlloQty = parseFloat(getAlreadyLeftoverAlloQty(rw.cells[4].childNodes[0].nodeValue,rw.cells[5].childNodes[0].nodeValue,'tblLeftOver'));
			var balQty = totRatioQty-alreadyAlloQty;
			if(balQty>stockQty)
				rw.cells[9].childNodes[0].value=stockQty;
			else
				rw.cells[9].childNodes[0].value=balQty;
			
			
			
		}
		else
		{
			
			if(totRatioQty<stockQty)
			{	
				if(totRatioQty<transQty)
					rw.cells[9].childNodes[0].value=totRatioQty;
				else
					rw.cells[9].childNodes[0].value=transQty;
			}
			else
			{
				if(stockQty<transQty)
					rw.cells[9].childNodes[0].value=stockQty;
				else
					rw.cells[9].childNodes[0].value=transQty;
			}
		}
	}
	else
	{
		var baltoAllocate =  ratioQty-allocatedQty;
		if(allocatedQty >= ratioQty)
		{
			//alert('Cant exceed Material Ratio Quntity');
			rw.cells[8].childNodes[0].checked = false;
			var alreadyAlloQty = parseFloat(getAlreadyLeftoverAlloQty(rw.cells[4].childNodes[0].nodeValue,rw.cells[5].childNodes[0].nodeValue,'tblLeftOver'));
			var balQty = ratioQty-alreadyAlloQty;
			if(balQty>stockQty)
				rw.cells[9].childNodes[0].value=stockQty;
			else
				rw.cells[9].childNodes[0].value=balQty;
			
			
			
		}
		else
		{
			
			if(ratioQty<stockQty)
			{	
				if(ratioQty<transQty)
					rw.cells[9].childNodes[0].value=ratioQty;
				else
					rw.cells[9].childNodes[0].value=transQty;
			}
			else
			{
				if(stockQty<transQty)
					rw.cells[9].childNodes[0].value=stockQty;
				else
					rw.cells[9].childNodes[0].value=transQty;
			}
		}
	}
		Check(obj);
	
}
function ValidateLiabilityQty(obj)
{
	var rw 			= obj.parentNode.parentNode;
	var transQty 	= parseFloat(obj.value);
	var stockQty 	= parseFloat(rw.cells[7].childNodes[0].nodeValue);	
	var ratioQty    = parseFloat(rw.cells[4].id);	
	
	var allocatedQty = parseFloat(getAlreadyLeftoverAlloQty(rw.cells[4].childNodes[0].nodeValue,rw.cells[5].childNodes[0].nodeValue,'tblLiability'));
	var totRatioQty = parseFloat(rw.cells[5].id);
	
	
	
	var baltoAllocate =  ratioQty-allocatedQty;
	if(allocatedQty >= ratioQty)
	{
		//alert('Cant exceed Material Ratio Quntity');
		rw.cells[8].childNodes[0].checked = false;
		var alreadyAlloQty = parseFloat(getAlreadyLeftoverAlloQty(rw.cells[4].childNodes[0].nodeValue,rw.cells[5].childNodes[0].nodeValue,'tblLeftOver'));
		var balQty = ratioQty-alreadyAlloQty;
		if(balQty>stockQty)
			rw.cells[9].childNodes[0].value=stockQty;
		else
			rw.cells[9].childNodes[0].value=balQty;
		
		
		
	}
	else
	{
		
		if(ratioQty<stockQty)
		{	
			if(ratioQty<transQty)
				rw.cells[9].childNodes[0].value=ratioQty;
			else
				rw.cells[9].childNodes[0].value=transQty;
		}
		else
		{
			if(stockQty<transQty)
				rw.cells[9].childNodes[0].value=stockQty;
			else
				rw.cells[9].childNodes[0].value=transQty;
		}
	}
	
		Check(obj);
	
}
function chkCheckAll(obj)
{
	var tbl = document.getElementById('tblLeftOver');
	if(obj.checked){		
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			tbl.rows[loop].cells[8].childNodes[0].checked = true;
			var stockQty = parseFloat(tbl.rows[loop].cells[7].childNodes[0].nodeValue);
			tbl.rows[loop].cells[9].childNodes[0].value = stockQty;
		}		
	}else{
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			tbl.rows[loop].cells[8].childNodes[0].checked = false;
			tbl.rows[loop].cells[9].childNodes[0].value = "";
		}
	}
}
//Bulk allocation part in following code
function ValidationBulk()
{
	var tbl = document.getElementById('tblBulk');
	var mainStoreID = document.getElementById('cboMainStoreBulk').value;
	var manufactCompany = document.getElementById('cboManufactBulkCompany').value;
	var check = true;
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[10].childNodes[0].checked){
			check = false;
		}
	}
	if(check){
		alert("Sorry!\nCannot proceed without selecting a row.Please select one row and try.");
		return;
	}
	if(manufactCompany == '')
	{
		alert("Please select 'Manufacturing Company'");
		document.getElementById('cboManufactBulkCompany').focus();
		return;
	}
	showBackGroundBalck();
	
	/*if(validateBulkAlloQtyWithBomQty())
	{
		createXMLHttpRequestAllocation(1);	
		xmlHttpAllocation[1].onreadystatechange=GetBulkNoRequest;
		xmlHttpAllocation[1].open("GET",'allocation_inbom/allocationdb.php?RequestType=GetBulkNo&mainStoreID='+mainStoreID,true);
		xmlHttpAllocation[1].send(null);
		
		}
		else
		{
			hideBackGroundBalck();
			}*/
			
	
	createXMLHttpRequestAllocation(1);	
	xmlHttpAllocation[1].onreadystatechange=GetBulkNoRequest;
	xmlHttpAllocation[1].open("GET",'allocation_inbom/allocationdb.php?RequestType=GetBulkNo&mainStoreID='+mainStoreID,true);
	xmlHttpAllocation[1].send(null);
}
function GetBulkNoRequest()
{
	if(xmlHttpAllocation[1].readyState == 4 && xmlHttpAllocation[1].status == 200){			
		var XMLNo = xmlHttpAllocation[1].responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
		
		
		if(XMLNo == 'NA')
		{
			alert('Bulk Allocation NO range not available for selected Main Store\n Please contact system administrator');
			hideBackGroundBalck();
			return;
		}
		else
		{
			var XMLYear = xmlHttpAllocation[1].responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
			pub_No = XMLNo;
		pub_Year = XMLYear;
		SaveBulkDetails();
			}
		
	}
}
function SaveBulkDetails()
{
	pub_checkLoop 		= 0;
	pub_detailCount 	= 0;
	var toStyleId		= document.getElementById('tdStyleId').title;
	var matDetailId		= document.getElementById('tdMatDetailId').title;
	var bulkToBuyerPoNo	= document.getElementById('cboBulkToBuyerPoNo').value;
	var manufactCompany = document.getElementById('cboManufactBulkCompany').value;
	var merchantRemarks = document.getElementById('txtBAlloRemarks').value;
	var tbl 			= document.getElementById('tblBulk');
	var count = 0;
	//start 2010-09-15 add BulkPO and BulkGRN details to commonstock_bulk detail tbl
	/*for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[6].childNodes[0].checked)
		{
			var color		= tbl.rows[loop].cells[2].childNodes[0].nodeValue;
			var size  		= tbl.rows[loop].cells[3].childNodes[0].nodeValue;
			var units  		= tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var qty 		= tbl.rows[loop].cells[7].childNodes[0].value;
			
			createXMLHttpRequestAllocation(loop);	
			xmlHttpAllocation[loop].open("GET",'allocation_inbom/allocationdb.php?RequestType=SaveBulkDetails&no='+pub_No+ '&year='+pub_Year+ '&matDetailId='+matDetailId+ '&toStyleId='+toStyleId+ '&color='+color+ '&size='+size+ '&units='+units+ '&qty='+qty+ '&bulkToBuyerPoNo=' +URLEncode(bulkToBuyerPoNo) ,true);
			xmlHttpAllocation[loop].send(null);
			pub_detailCount++
		}
	}*/
	
	if(pub_No != '' && pub_Year != '')
	{
		//save Allocation header details
		var mainStoreID = document.getElementById('cboMainStoreBulk').value;
		var url=pub_BAlloUrl+"allocationdb.php";
					url=url+"?RequestType=SaveBulkAlloHeader";
					url += '&no='+pub_No;
					url += '&year='+pub_Year;
					url += '&toStyleId='+toStyleId;
					url += '&bulkToBuyerPoNo='+URLEncode(bulkToBuyerPoNo);
					url += '&mainStoreID='+mainStoreID;
					url += '&manufactCompany='+manufactCompany;
					url += '&merchantRemarks='+URLEncode(merchantRemarks);
					
					var htmlobj=$.ajax({url:url,async:false});
					var resAlloHead = htmlobj.responseText;
					
					if(resAlloHead == '1')
					{
						//alert(resAlloHead);
						for(loop=1;loop<tbl.rows.length;loop++)
							{
								if(tbl.rows[loop].cells[10].childNodes[0].checked)
								{
								var color		= tbl.rows[loop].cells[5].childNodes[0].nodeValue;
								var size  		= tbl.rows[loop].cells[6].childNodes[0].nodeValue;
								var units  		= tbl.rows[loop].cells[7].childNodes[0].nodeValue;
								var qty 		= tbl.rows[loop].cells[11].childNodes[0].value;
								var BpoNo       = tbl.rows[loop].cells[1].childNodes[0].nodeValue;
								var BpoYear     = tbl.rows[loop].cells[1].id;
								var BgrnNo      = tbl.rows[loop].cells[2].childNodes[0].nodeValue;
								var BgrnYear    = tbl.rows[loop].cells[2].id;
								var storeID     = tbl.rows[loop].cells[4].id;
								
								var url = 'allocation_inbom/allocationdb.php?RequestType=SaveBulkAlloDetail&no='+pub_No+ '&year='+pub_Year+ '&matDetailId='+matDetailId+ '&color='+color+ '&size='+size+ '&units='+units+ '&qty='+qty+'&BpoNo='+BpoNo+'&BpoYear='+BpoYear+'&BgrnNo='+BgrnNo+'&BgrnYear='+BgrnYear+'&storeID='+storeID;
								/*createXMLHttpRequestAllocation(loop);	
								xmlHttpAllocation[loop].open("GET",'allocation_inbom/allocationdb.php?RequestType=SaveBulkAlloDetail&no='+pub_No+ '&year='+pub_Year+ '&matDetailId='+matDetailId+ '&color='+color+ '&size='+size+ '&units='+units+ '&qty='+qty+'&BpoNo='+BpoNo+'&BpoYear='+BpoYear+'&BgrnNo='+BgrnNo+'&BgrnYear='+BgrnYear+'&storeID='+storeID,true);
								xmlHttpAllocation[loop].send(null);*/
								var htmlobj=$.ajax({url:url,async:false});
								var resAlloDetail = htmlobj.responseText;
							pub_detailCount++;
									if(resAlloDetail == '1')
									{
										count++;
										}
									
								
								}
							}
					}
					else
					{
						alert("Sorry!\nError occured while saving the data. Please Save it again.");
						}
		}
	//SaveBulkValidation();
	var rwCnt = tbl.rows.length-1;
	if(pub_detailCount == count)
	{
		var type = 'bulk';
		var url = 'allocation_inbom/allocationdb.php?RequestType=EmailAllocationNo';
		url += '&no='+pub_No;
		url += '&year='+pub_Year;
		url += '&toStyleId='+toStyleId;
		url += '&mainStoreID='+mainStoreID;
		url += '&type='+type;
		
		var htmlobj=$.ajax({url:url,async:false});
		
		var alloNo = pub_No+"/"+pub_Year;
		alert("Bulk Transfer No : \""+alloNo+"\" saved successfully!");
		viewBulkDetails(matDetailId,toStyleId);
				//document.getElementById("butBulkSave").style.visibility="hidden";
				hideBackGroundBalck();
				closeWindow();
		}
		//SaveBulkValidation();
}
function SaveBulkValidation()
{
	createXMLHttpRequestAllocation(4);	
	xmlHttpAllocation[4].onreadystatechange=SaveBulkValidationRequest;
	xmlHttpAllocation[4].open("GET",'allocation_inbom/allocationdb.php?RequestType=SaveBulkValidation&no='+pub_No+ '&year='+pub_Year+ '&detailCount='+pub_detailCount,true);
	xmlHttpAllocation[4].send(null);
}
	function SaveBulkValidationRequest()
	{
		if(xmlHttpAllocation[4].readyState == 4 && xmlHttpAllocation[4].status == 200){	
			var XMLHeader 	= xmlHttpAllocation[4].responseXML.getElementsByTagName("Header")[0].childNodes[0].nodeValue;
			var XMLDetails	= xmlHttpAllocation[4].responseXML.getElementsByTagName("Details")[0].childNodes[0].nodeValue;
			var XMLNo	= xmlHttpAllocation[4].responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
			
			if(XMLHeader=="TRUE" && XMLDetails=="TRUE")
			{
				alert("Bulk Transfer No : \""+XMLNo+"\" saved successfully!");
				document.getElementById("butBulkSave").style.visibility="hidden";
				hideBackGroundBalck();
				closeWindow();
			}
			else
			{
				pub_checkLoop++;
				if(pub_checkLoop>20){
					alert("Sorry!\nError occured while saving the data. Please Save it again.");
					document.getElementById("butBulkSave").style.visibility="visible";
					hideBackGroundBalck();
					pub_checkLoop = 0;
					return;
				}
					else{							
					SaveBulkValidation();							
				}
			}

		}
	}
function GetBulkQty(obj)
{
	
	var rw = obj.parentNode.parentNode;
	
	//allocate stock qty
	/*if(obj.checked)
	{
		var stockQty = parseFloat(rw.cells[9].childNodes[0].nodeValue);
		rw.cells[11].childNodes[0].value = stockQty;
	}else{
		rw.cells[11].childNodes[0].value = "";
	}	*/
	
	//Allocate material ratio qty if Stock qty is greater than mat ratio Qty
	if(obj.checked)
	{
		var stockQty = parseFloat(rw.cells[9].childNodes[0].nodeValue);
		var ratioQty = parseFloat(rw.cells[5].id);
		var poPrice = parseFloat(rw.cells[12].childNodes[0].nodeValue);
		//get already allocated bulk qty
		var allocatedQty = parseFloat(getalreadyAllocatedQty(rw.cells[5].childNodes[0].nodeValue,rw.cells[6].childNodes[0].nodeValue));
		var canAllocateTotalRatioQty = document.getElementById('tdAlloTotRatio').title;
		var totRatioQty = parseFloat(rw.cells[6].id);
		
		if(canAllocateTotalRatioQty)
		{
			if(allocatedQty >= totRatioQty)
				{
					//alert('Cant exceed Material Ratio Quntity');
					obj.checked = false;
					return false;
				}
				else
				{	
					var baltoAllocate = totRatioQty-allocatedQty;
					if(baltoAllocate>stockQty)
						rw.cells[11].childNodes[0].value = stockQty;
					else
						rw.cells[11].childNodes[0].value = baltoAllocate;
				}
		}
		else
		{
			if(validatePOpriceWithBOMprice(poPrice))
			{
				if(allocatedQty >= ratioQty)
				{
					//alert('Cant exceed Material Ratio Quntity');
					obj.checked = false;
					return false;
				}
				else
				{	
					var baltoAllocate = ratioQty-allocatedQty;
					if(baltoAllocate>stockQty)
						rw.cells[11].childNodes[0].value = stockQty;
					else
						rw.cells[11].childNodes[0].value = baltoAllocate;
				}
			}
			else
			{
				obj.checked = false;
				}
		}
			
			
	}else{
		rw.cells[11].childNodes[0].value = "";
	}
	
}
function BulkCheck(obj)
{
	var qty = (isNaN(parseFloat(obj.value)) ?0:parseFloat(obj.value));
	var rw = obj.parentNode.parentNode;
	if(qty=="" || qty==0)
	{
		rw.cells[10].childNodes[0].checked=false;
		rw.cells[11].childNodes[0].value='';
	}
	else
		rw.cells[10].childNodes[0].checked=true
}
function ValidateBulkQty(obj)
{
	var rw 			= obj.parentNode.parentNode;
	var transQty 	= parseFloat(obj.value);
	var stockQty 	= parseFloat(rw.cells[9].childNodes[0].nodeValue);
	var ratioQty    = parseFloat(rw.cells[5].id);
	var poPrice = parseFloat(rw.cells[12].childNodes[0].nodeValue);
	var totRatioQty = parseFloat(rw.cells[6].id);
	var canAllocateTotalRatioQty = document.getElementById('tdAlloTotRatio').title;
	//set allocation max qty to stock qty
	/*if(stockQty<transQty)
	{		
		rw.cells[11].childNodes[0].value=stockQty;
	}*/
	
	//validate PO price with BOM price
	
	//set maximum allocation qty as material ratio qty if stock qty grater than mat ratio qty
	//get already allocated qty(including current allocation)
	var allocatedQty = parseFloat(getalreadyAllocatedQty(rw.cells[5].childNodes[0].nodeValue,rw.cells[6].childNodes[0].nodeValue));
	
	var baltoAllocate =  ratioQty-allocatedQty;
	//alert(baltoAllocate);
	if(canAllocateTotalRatioQty)
	{
		//Don't consider PO price and bal Qty. Allocate total ratio Qty
		if(allocatedQty >= totRatioQty)
		{
			rw.cells[10].childNodes[0].checked = false;
			var alreadyAlloQty = parseFloat(getalreadyAllocatedQty(rw.cells[5].childNodes[0].nodeValue,rw.cells[6].childNodes[0].nodeValue));
			var balQty = totRatioQty-alreadyAlloQty;
			//allocate balance qty
			if(balQty>stockQty)
			rw.cells[11].childNodes[0].value=stockQty;
			else
			rw.cells[11].childNodes[0].value=balQty;
		}
		else
		{
			if(totRatioQty<stockQty)
			{	
				//check ratio with the trans qty(entered qty)
				if(totRatioQty<transQty)
					rw.cells[11].childNodes[0].value=ratioQty;
				else
					rw.cells[11].childNodes[0].value=transQty;
			}
			else
			{
				if(stockQty<transQty)
					rw.cells[11].childNodes[0].value=stockQty;
				else
					rw.cells[11].childNodes[0].value=transQty;
			}
		}
		BulkCheck(obj);
	}
	else
	{
		if(validatePOpriceWithBOMprice(poPrice))
		{
			if(allocatedQty >= ratioQty)
			{
				//alert('Cant exceed Material Ratio Quntity');
				rw.cells[10].childNodes[0].checked = false;
				//get the total allocation qty without current allocation qty
				var alreadyAlloQty = parseFloat(getalreadyAllocatedQty(rw.cells[5].childNodes[0].nodeValue,rw.cells[6].childNodes[0].nodeValue));
				//alert(alreadyAlloQty);
				var balQty = ratioQty-alreadyAlloQty;
				//allocate balance qty
				if(balQty>stockQty)
				rw.cells[11].childNodes[0].value=stockQty;
				else
				rw.cells[11].childNodes[0].value=balQty;
				
				
				
			}
			else
			{
				// check ratio qty with the stock qty
				if(ratioQty<stockQty)
				{	
					//check ratio with the trans qty(entered qty)
					if(ratioQty<transQty)
						rw.cells[11].childNodes[0].value=ratioQty;
					else
						rw.cells[11].childNodes[0].value=transQty;
				}
				else
				{
					if(stockQty<transQty)
						rw.cells[11].childNodes[0].value=stockQty;
					else
						rw.cells[11].childNodes[0].value=transQty;
				}
			}
		
			BulkCheck(obj);
		}
		else
		{
			obj.checked = false;
			rw.cells[11].childNodes[0].value = '';
		}
	}
}
function chkBulkCheckAll(obj)
{
	var tbl = document.getElementById('tblBulk');
	if(obj.checked){		
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			/*tbl.rows[loop].cells[10].childNodes[0].checked = true;
			var stockQty = parseFloat(tbl.rows[loop].cells[9].childNodes[0].nodeValue);
			tbl.rows[loop].cells[11].childNodes[0].value = stockQty;*/
			//alert(tbl.rows[loop].cells[10].childNodes[0]);
			tbl.rows[loop].cells[10].childNodes[0].checked = true;
			GetBulkQty(tbl.rows[loop].cells[10].childNodes[0]);
		}		
	}else{
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			tbl.rows[loop].cells[10].childNodes[0].checked = false;
			tbl.rows[loop].cells[11].childNodes[0].value = "";
		}
	}
}

function viewBulkDetails(matID,StyleID)
{
	var MainStoreID = document.getElementById('cboMainStoreBulk').value;
	//alert(MainStoreID);
	if(MainStoreID == '0')
	{
		alert('Please select Main Store');
		return
		}
	else
	{
		var url=pub_BAlloUrl+"allocationxml.php";
					url=url+"?RequestType=viewBulkDetails";
					url += '&matID='+matID;
					url += '&MainStoreID='+MainStoreID;
					url += '&StyleID='+StyleID;
					
				var htmlobj=$.ajax({url:url,async:false});
				var tbl = document.getElementById('tblBulk');
					tbl.innerHTML = htmlobj.responseText;	
		
	}
	
}

function viewLeftOver()
{
	var toStyleId	= document.getElementById('tdStyleId').title;
	var matDetailId	= document.getElementById('tdMatDetailId').title;
	var toBuyerPoNo	= document.getElementById('cboToBuyerPoNo').value;	
	var MainStoreID = document.getElementById('cboMainStore').value;
	
	if(MainStoreID == '0')
	{
		alert('Please select Main Store');
		return
		}
	else
	{
		var url=pub_BAlloUrl+"allocationxml.php";
					url=url+"?RequestType=viewLeftOver";
					url += '&matDetailId='+matDetailId;
					url += '&MainStoreID='+MainStoreID;
					url += '&toStyleId='+toStyleId;
					
				var htmlobj=$.ajax({url:url,async:false});
				var tbl = document.getElementById('tblLeftOver');
					tbl.innerHTML = htmlobj.responseText;	
		
	}
}
function viewLiability()
{
	var toStyleId	= document.getElementById('tdStyleId').title;
	var matDetailId	= document.getElementById('tdMatDetailId').title;
	var toBuyerPoNo	= document.getElementById('cboLiabilityBuyerPoNo').value;	
	var MainStoreID = document.getElementById('cboLiabilityMainStore').value;
	
	if(MainStoreID == '0')
	{
		alert('Please select Main Store');
		return
		}
	else
	{
		var url=pub_BAlloUrl+"allocationxml.php";
					url=url+"?RequestType=viewLiability";
					url += '&matDetailId='+matDetailId;
					url += '&MainStoreID='+MainStoreID;
					url += '&toStyleId='+toStyleId;
					
				var htmlobj=$.ajax({url:url,async:false});
				var tbl = document.getElementById('tblLiability');
					tbl.innerHTML = htmlobj.responseText;	
		
	}
}
//start 2010-10-07 validate bom qty with allocated qty
/*function validateBulkAlloQtyWithBomQty()
{
	var bomQty =parseFloat(document.getElementById('tdBOMQty').title);
	
	var toStyleId	= document.getElementById('lblStyleNo').innerHTML;
	var matDetailId	= document.getElementById('tdMatDetailId').title;
	var tbl = document.getElementById('tblBulk');
	var url=pub_BAlloUrl+"allocationxml.php";
					url=url+"?RequestType=viewAllocatedBulkQtyforStyle";
					url += '&matDetailId='+matDetailId;
					url += '&toStyleId='+toStyleId;
					
					
		var htmlobj=$.ajax({url:url,async:false});
		var Allocatedqty = (htmlobj.responseText);
		
		if(Allocatedqty == '')
		 Allocatedqty=0;
		 
		var totAlloQty = 0;
		for(var loop=1;loop<tbl.rows.length;loop++)
			{
				//alert(tbl.rows[loop].cells[10].childNodes[0].checked);
				if(tbl.rows[loop].cells[10].childNodes[0].checked)
				{
					var qty 		= parseFloat(tbl.rows[loop].cells[11].childNodes[0].value);
					totAlloQty += qty;
					//alert(parseFloat(tbl.rows[loop].cells[11].childNodes[0].value));
				}
			}
			
			totAlloQty += parseFloat(Allocatedqty);
			
		if(bomQty < Allocatedqty)
		{
			alert('Already Allocated Qty is greater than the BOM qty');
			return false;
		}
		else if(bomQty<totAlloQty)
		{
			alert('Total Allocation Qty is greater than the BOM qty');
			return false;
			}
		else
			return true;
		
		
}*/

function validateLeftOverQtywithBomQty()
{
	var bomQty =parseFloat(document.getElementById('tdBOMQty').title);
	
	var toStyleId	= document.getElementById('lblStyleNo').innerHTML;
	var matDetailId	= document.getElementById('tdMatDetailId').title;
	var tbl			= document.getElementById('tblLeftOver');
	var url=pub_BAlloUrl+"allocationxml.php";
					url=url+"?RequestType=viewAllocatedLeftQtyforStyle";
					url += '&matDetailId='+matDetailId;
					url += '&toStyleId='+toStyleId;
					
					
		var htmlobj=$.ajax({url:url,async:false});
		var Allocatedqty = parseFloat(htmlobj.responseText);
		
		var totAlloQty = 0;
		for(var loop=1;loop<tbl.rows.length;loop++)
			{
				if(tbl.rows[loop].cells[8].childNodes[0].checked)
				{
					var qty 		= parseFloat(tbl.rows[loop].cells[9].childNodes[0].value);
					totAlloQty += qty;
					
				}
			}
			
			totAlloQty += Allocatedqty;
			//alert(totAlloQty);
		if(bomQty < Allocatedqty)
		{
			alert('Already Allocated Qty is greater than the BOM qty');
			return false;
		}
		else if(bomQty<totAlloQty)
		{
			alert('Total Allocation Qty is greater than the BOM qty');
			return false;
			}
		else
			return true;
		
}

function getalreadyAllocatedQty(color,size)
{
	var tbl			= document.getElementById('tblBulk');
	var qty = 0;
	for(var loop=1;loop<tbl.rows.length;loop++)
		{
			var bcolor =  tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			var bsize  =  tbl.rows[loop].cells[6].childNodes[0].nodeValue;
			if(tbl.rows[loop].cells[10].childNodes[0].checked)
			{
				if(bcolor == color && bsize == size)
				{
					if(tbl.rows[loop].cells[11].childNodes[0].value != '')
					qty += parseFloat(tbl.rows[loop].cells[11].childNodes[0].value);
					
				}
			}
		}
		//alert(qty);
		return qty;
}

function validatePOpriceWithBOMprice(poPrice)
{
	var bomPrice = parseFloat(document.getElementById('tdBOMQty').title);
	
	if(poPrice>bomPrice)	
	{
		alert('PO price exceed the BOM price');
		return false;
	}
	else
	{
		return true;
		}
}

function getAlreadyLeftoverAlloQty(color,size,tblName)
{
	var tbl			= document.getElementById(tblName);
	var qty = 0;
	for(var loop=1;loop<tbl.rows.length;loop++)
		{
			var bcolor =  tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var bsize  =  tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			if(tbl.rows[loop].cells[8].childNodes[0].checked)
			{
				if(bcolor == color && bsize == size)
				{
					if(tbl.rows[loop].cells[9].childNodes[0].value != '')
					qty += parseFloat(tbl.rows[loop].cells[9].childNodes[0].value);
					
				}
			}
		}
		//alert(qty);
		return qty;	
}

function ValidationLiability()
{
	var tbl = document.getElementById('tblLiability');
	var mainStoreID = document.getElementById('cboLiabilityMainStore').value;
	var manufactCom = document.getElementById('cboManufactLiabilityCompany').value;
	var check = true;
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[8].childNodes[0].checked){
			check = false;
		}
	}
	if(check){
		alert("Sorry!\nCannot proceed without selecting a row.Please select at least one row.");
		return;
	}
	if(manufactCom == '')
	{
		alert("Please select the 'Manufacturing Company'");
		document.getElementById('cboManufactLeftCompany').focus();
		return;
	}
	
	showBackGroundBalck();
	var url = 'allocation_inbom/allocationdb.php?RequestType=GetLiabilityNo&mainStoreID='+mainStoreID;
	var htmlobj=$.ajax({url:url,async:false});

	var XMLNo = htmlobj.responseXML.getElementsByTagName("No")[0].childNodes[0].nodeValue;
	var XMLYear = htmlobj.responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
	
	if(XMLNo != 'NA')
	{
		//var XMLYear = xmlHttpAllocation[1].responseXML.getElementsByTagName("Year")[0].childNodes[0].nodeValue;
		SaveLiabilityDetails(XMLNo,XMLYear);
	}
	else
	{
		alert('Liability Allocation NO range not available for selected Main Store\n Please contact system administrator');
		hideBackGroundBalck();
		return;
	}
}

function SaveLiabilityDetails(LAlloNo,LAlloYear)
{
	pub_checkLoop 	= 0;
	pub_detailCount = 0;
	var toStyleId	= document.getElementById('tdStyleId').title;
	var matDetailId	= document.getElementById('tdMatDetailId').title;
	var toBuyerPoNo	= document.getElementById('cboLiabilityBuyerPoNo').value;
	var mainStoreID = document.getElementById('cboLiabilityMainStore').value;
	var manufactCom = document.getElementById('cboManufactLiabilityCompany').value;
	var merchantRemarks = document.getElementById('txtLiabilityAlloRemarks').value;
	var count 		= 0;
	var tbl 		= document.getElementById('tblLiability');
	
	var url  = 'allocation_inbom/allocationdb.php?RequestType=SaveLiabilityHeader';
		url += '&no='+LAlloNo;
		url += '&year='+LAlloYear;
		url += '&toStyleId='+toStyleId;
		url += '&toBuyerPoNo='+URLEncode(toBuyerPoNo);
		url += '&mainStoreID='+mainStoreID;
		url += '&manufactCom='+manufactCom;
		url += '&merchantRemarks='+URLEncode(merchantRemarks);
					
	var htmlobj=$.ajax({url:url,async:false});
	var responseHeader = htmlobj.responseText;	
	
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[8].childNodes[0].checked)
		{
			var fromStyleId = tbl.rows[loop].cells[2].id;
			var buyerPoNo 	= tbl.rows[loop].cells[3].id;
			var color		= tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var size  		= tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			var units  		= tbl.rows[loop].cells[6].childNodes[0].nodeValue;
			var qty 		= tbl.rows[loop].cells[9].childNodes[0].value;
			var grnNo 		= tbl.rows[loop].cells[10].childNodes[0].nodeValue;
			var grnYear		= tbl.rows[loop].cells[11].childNodes[0].nodeValue;
			var grnType		= tbl.rows[loop].cells[12].id;

			pub_detailCount++
			var url = 'allocation_inbom/allocationdb.php?RequestType=SaveLiabilityDetails';
			url += '&no='+LAlloNo;
					url += '&year='+LAlloYear;
					url += '&fromStyleId='+fromStyleId;
					url += '&matDetailId='+matDetailId;
					//url += '&toStyleId='+toStyleId;
					url += '&color='+URLEncode(color);
					//url += '&toBuyerPoNo='+URLEncode(toBuyerPoNo);
					url += '&size='+URLEncode(size);
					url += '&units='+URLEncode(units);
					url += '&qty='+qty;
					url += '&buyerPoNo='+URLEncode(buyerPoNo);
					//url += '&mainStoreID='+mainStoreID;
					url += '&grnNo='+grnNo;
					url += '&grnYear='+grnYear;
					url += '&grnType='+grnType;
					
			var htmlobj=$.ajax({url:url,async:false});
			var responseID = htmlobj.responseText;
			
			if(responseID == '1')
			{
				count++;
			}
		}
	}
	
	if(count == pub_detailCount && responseHeader=='1')
	{
			
		var leftAlloNo = LAlloYear+"/"+LAlloNo;
		alert("Liability Allocation No : \""+ leftAlloNo  +"\" saved successfully!");
		viewLiability();
		hideBackGroundBalck();
		closeWindow();
	}
	else
	{
		alert("Sorry!\nError occured while saving the data. Please Save it again.");
		hideBackGroundBalck();
	}
}