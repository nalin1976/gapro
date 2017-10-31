var xmlHttp = [];

function createXMLHttpRequest(index){
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}

function ClearForm(){	
	setTimeout("location.reload(true);",0);
}

function closeWindow(){
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

function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 0) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}

function ChangeInvoiceNo(obj){
	document.getElementById('cboInvoiceNo').value =document.getElementById('cboDeliveryNo').options[document.getElementById('cboDeliveryNo').selectedIndex].text;
	LoadDetails();
}

function ChangeDeliveryNo(obj){
	document.getElementById('cboDeliveryNo').value =document.getElementById('cboInvoiceNo').options[document.getElementById('cboInvoiceNo').selectedIndex].text;
	LoadDetails();
}

function LoadDetails(){
	var deliveryNo	= document.getElementById('cboDeliveryNo').options[document.getElementById('cboDeliveryNo').selectedIndex].text;
	if(deliveryNo==""){ClearForm();return;}
	
createXMLHttpRequest(1);	
xmlHttp[1].onreadystatechange = LoadDetailsRequest;
xmlHttp[1].open("GET" ,'importentrymiddle.php?RequestType=LoadDetails&deliveryNo=' +deliveryNo ,true);
xmlHttp[1].send(null);	
}
	function LoadDetailsRequest(){
		if(xmlHttp[1].readyState == 4 && xmlHttp[1].status == 200){
			var XMLEntryNo	= xmlHttp[1].responseXML.getElementsByTagName("EntryNo")[0].childNodes[0].nodeValue;
				document.getElementById('txtEntryNo').value=XMLEntryNo;
			
			var XMLMerchandiser	= xmlHttp[1].responseXML.getElementsByTagName("Merchandiser")[0].childNodes[0].nodeValue;
				document.getElementById('txtMerchandiser').value=XMLMerchandiser;
				
			var XMLLocationOfGoods	= xmlHttp[1].responseXML.getElementsByTagName("LocationOfGoods")[0].childNodes[0].nodeValue;
				document.getElementById('txtLocationOfGood').value=XMLLocationOfGoods;
				
			var XMLClearedOn	= xmlHttp[1].responseXML.getElementsByTagName("ClearedOn")[0].childNodes[0].nodeValue;
				document.getElementById('dtmClearedOn').value=XMLClearedOn;
				
			var XMLClearedBy	= xmlHttp[1].responseXML.getElementsByTagName("ClearedBy")[0].childNodes[0].nodeValue;
				document.getElementById('cboCleardBy').value=XMLClearedBy;
				
			var XMLStyleId	= xmlHttp[1].responseXML.getElementsByTagName("StyleId")[0].childNodes[0].nodeValue;
				document.getElementById('txtStyleID').value=XMLStyleId;
			
			
		}
	}
	
function SaveDetails(){
	var deliveryNo		= document.getElementById('cboDeliveryNo').options[document.getElementById('cboDeliveryNo').selectedIndex].text;
	
	var entryNo			= document.getElementById('txtEntryNo').value;
	var merchandiser	= document.getElementById('txtMerchandiser').value;
	var locationOfGood	= document.getElementById('txtLocationOfGood').value;
	var clearedOn		= document.getElementById('dtmClearedOn').value;
	var clearedBy		= document.getElementById('cboCleardBy').value;
	var styleID			= document.getElementById('txtStyleID').value;
	if(deliveryNo==""){alert("No details appear to Save!");return;}
	if(clearedBy==""){alert("Please select Cleared By befor you save!");return;}
createXMLHttpRequest(2);	
xmlHttp[2].onreadystatechange = SaveRequest;
xmlHttp[2].open("GET" ,'importentrydb.php?RequestType=SaveDetails&deliveryNo=' +deliveryNo+ '&entryNo=' +entryNo+ '&merchandiser=' +merchandiser+ '&locationOfGood=' +locationOfGood+ '&clearedBy=' +clearedBy+ '&clearedOn=' +clearedOn+ '&styleID=' +styleID,true);
xmlHttp[2].send(null);	
}
	function SaveRequest(){
		if(xmlHttp[2].readyState == 4 && xmlHttp[2].status == 200){
			if(xmlHttp[2].responseText==1){
				alert("Import Entry saved successfully.")
				ClearForm();
			}
			else{
				alert("Sorry!\nError occured while saving Import Entry\nPlease save it again.")
			}
			
				
			
			
		}
	}

function Cancel(){
	var deliveryNo		= document.getElementById('cboDeliveryNo').options[document.getElementById('cboDeliveryNo').selectedIndex].text;	
	if(deliveryNo==""){alert("No details appear to Cancel.");return;}
createXMLHttpRequest(4);	
xmlHttp[4].onreadystatechange = CancelRequest;
xmlHttp[4].open("GET" ,'importentrydb.php?RequestType=Cancel&deliveryNo=' +deliveryNo ,true);
xmlHttp[4].send(null);	
}
	function CancelRequest(){
		if(xmlHttp[4].readyState == 4 && xmlHttp[4].status == 200){
			if(xmlHttp[4].responseText==1){
				alert("Import Entry Canceled.")
				ClearForm();
			}
			else{
				alert("Sorry!\nError occured while Cancelation Import Entry\nPlease Cancel it again.")
			}			
		}
	}
	
function OpenDetailsList(){	
	createXMLHttpRequest(5);	
	xmlHttp[5].onreadystatechange=OpenDetailsListRequest;
	xmlHttp[5].open("GET",'importentrylistpopup.php?',true);
	xmlHttp[5].send(null);
}

	function OpenDetailsListRequest(){
		if(xmlHttp[5].readyState == 4 && xmlHttp[5].status == 200){
				drawPopupArea(615,365,'frmImportEntryDetailsList');				
				var HTMLText=xmlHttp[5].responseText;
				document.getElementById('frmImportEntryDetailsList').innerHTML=HTMLText;		
		}
	}
	
function GetDetailsToMainPage(obj){	
	RomoveData('cboDeliveryNo');
	RomoveData('cboInvoiceNo');
	var opt = document.createElement("option");
	opt.text = obj.cells[0].childNodes[0].nodeValue;
	opt.value = obj.cells[1].childNodes[0].nodeValue;
	document.getElementById("cboDeliveryNo").options.add(opt);
	document.getElementById('cboDeliveryNo').value = obj.cells[1].childNodes[0].nodeValue;
		
	var opt = document.createElement("option");
	opt.text = obj.cells[1].childNodes[0].nodeValue;
	opt.value = obj.cells[0].childNodes[0].nodeValue;
	document.getElementById("cboInvoiceNo").options.add(opt);
	document.getElementById('cboInvoiceNo').value = obj.cells[0].childNodes[0].nodeValue;
	
	ChangeInvoiceNo(document.getElementById("cboDeliveryNo"));
	closeWindow();
}

function ViewReportPoPUp(){	
	createXMLHttpRequest(5);	
	xmlHttp[5].onreadystatechange=ViewReportPoPUpRequest;
	xmlHttp[5].open("GET",'entryreport.php?',true);
	xmlHttp[5].send(null);
}

	function ViewReportPoPUpRequest(){
		if(xmlHttp[5].readyState == 4 && xmlHttp[5].status == 200){
				drawPopupArea(615,304,'frmImportEntryDetailsList');				
				var HTMLText=xmlHttp[5].responseText;
				document.getElementById('frmImportEntryDetailsList').innerHTML=HTMLText;		
		}
	}

function ViewClearenceData()
{
	var optClearance 		= document.getElementById('optClearance').checked;
	var optAllImports 		= document.getElementById('optAllImports').checked;	
	var chkClearence 		= document.getElementById('chkClearence').checked;
	var dtmClearenceFrom 	= document.getElementById('dtmClearenceFrom').value;
	var dtmClearenceTo 		= document.getElementById('dtmClearenceTo').value;
	
	var No =100;
	if(No=="" || No=="0"){
		alert("No delivery no appear to view..");
		return false;
	}
	
	newwindow=window.open('importentryclearencereport.php?optClearance=' +optClearance+ '&optAllImports=' +optAllImports+ '&chkClearence=' +chkClearence+ '&dtmClearenceFrom=' +dtmClearenceFrom+ '&dtmClearenceTo=' +dtmClearenceTo ,'name');
	if (window.focus) {newwindow.focus()}
}

function SetDates(obj,index){	
	if(index==0){
		if(obj.checked){
			document.getElementById('dtmClearenceFrom').disabled=false;
			document.getElementById('dtmClearenceTo').disabled=false;
		}
		else{
			document.getElementById('dtmClearenceFrom').disabled=true;
			document.getElementById('dtmClearenceTo').disabled=true;
		}
	}
	else if(index==1){
		if(obj.checked){
			document.getElementById('dtmEntryFrom').disabled=false;
			document.getElementById('dtmEntryTo').disabled=false;
		}
		else{
			document.getElementById('dtmEntryFrom').disabled=true;
			document.getElementById('dtmEntryTo').disabled=true;
		}
	}
}

function ViewCusdecListReports()
{
	var optHeaderAllEntry 		= document.getElementById('optHeaderAllEntry').checked;   	
	var optHeaderEntryPass 		= document.getElementById('optHeaderEntryPass').checked;	
	var optHeaderAwaitingEntry 	= document.getElementById('optHeaderAwaitingEntry').checked;
	
	var cmbBuyer 				= document.getElementById('cmbBuyer').value;
	var cmbExporter 			= document.getElementById('cmbExporter').value;	
	var cboCustomer 			= document.getElementById('cboCustomer').value;	
	var chkEntry 				= document.getElementById('chkEntry').checked;
	
	var dtmEntryFrom 			= document.getElementById('dtmEntryFrom').value;
	var dtmEntryTo 				= document.getElementById('dtmEntryTo').value;
	
		
	newwindow=window.open('importentryreport.php?optHeaderAllEntry=' +optHeaderAllEntry+ '&optHeaderEntryPass=' +optHeaderEntryPass+ '&optHeaderAwaitingEntry=' +optHeaderAwaitingEntry+ '&cmbBuyer=' +cmbBuyer+ '&cmbExporter=' +cmbExporter+ '&cboCustomer=' +cboCustomer+ '&chkEntry=' +chkEntry+ '&dtmEntryFrom=' +dtmEntryFrom+ '&dtmEntryTo=' +dtmEntryTo ,'name');
	if (window.focus) {newwindow.focus()}
}


