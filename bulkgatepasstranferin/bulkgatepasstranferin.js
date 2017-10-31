// JavaScript Document
var mainArrayIndex   = 0;
var Materials 		 = [];

var pub_commonBin	 = 0;
var pub_mainStoreID	 = 0;
var pub_subStoreID	 = 0;
var pub_location 	 = '';
var pub_bin 		 = '';
var pub_binQty 		 = 0;

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
function LoadSubStores(mainstId)
{
	var mainStoresID = mainstId;
	var url = 'bulkgatepasstranferinXML.php?Request=LoadSubStores&mainStoresID='+URLEncode(mainStoresID);
	htmlobj=$.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	document.getElementById('cboSubStores').innerHTML = XMLItem;
	
	var url = 'bulkgatepasstranferinXML.php?Request=getCommonBin&mainStoresID='+URLEncode(mainStoresID);
	htmlobj=$.ajax({url:url,async:false});
	var xmlCommBin 	= htmlobj.responseXML.getElementsByTagName("commBin");
	pub_commonBin 	=  xmlCommBin[0].childNodes[0].nodeValue;
	document.getElementById("titCommonBinID").title = pub_commonBin;
			
}
function LoadGatePassDetails()
{
	document.getElementById("cmdSave").style.display="inline";
	document.getElementById("cboGPTransInNo").value="";
	var tbl					= document.getElementById('tblTransInMain');
	pub_commonBin			= document.getElementById('titCommonBinID').title;
	RemoveAllRows('tblTransInMain');
	Materials      = [];
	mainArrayIndex = 0
	var gatePassNo = $('#cboGatePassNo').val();
	var url = 'bulkgatepasstranferinXML.php?Request=LoadGatePassDetails&gatePassNo=' +gatePassNo;
	xml_http_obj = $.ajax({url:url,async:false});
	
	var XMLMatDetailID	= xml_http_obj.responseXML.getElementsByTagName('intMatDetailId');
	for(var loop =0; loop < XMLMatDetailID.length; loop ++)
	{
		var MatDetailID	 = XMLMatDetailID[loop].childNodes[0].nodeValue;
		var XMLColor	 = xml_http_obj.responseXML.getElementsByTagName('strColor')[loop].childNodes[0].nodeValue;
		var XMLSize		 = xml_http_obj.responseXML.getElementsByTagName('strSize')[loop].childNodes[0].nodeValue;
		var XMLBalQty	 = xml_http_obj.responseXML.getElementsByTagName('dblBalQty')[loop].childNodes[0].nodeValue;
		var XMLSubCatId	 = xml_http_obj.responseXML.getElementsByTagName('intSubCatID')[loop].childNodes[0].nodeValue;
		var XMLDes		 = xml_http_obj.responseXML.getElementsByTagName('strItemDescription')[loop].childNodes[0].nodeValue;
		var XMLUnit		 = xml_http_obj.responseXML.getElementsByTagName('strUnit')[loop].childNodes[0].nodeValue;
		var XMLGrnNo	 = xml_http_obj.responseXML.getElementsByTagName('intGrnNo')[loop].childNodes[0].nodeValue;
		var XMLGrnYear	 = xml_http_obj.responseXML.getElementsByTagName('intGRNYear')[loop].childNodes[0].nodeValue;
		
		CreateMainGrid(tbl,MatDetailID,XMLColor,XMLSize,XMLBalQty,XMLBalQty,XMLSubCatId,XMLDes,XMLUnit,XMLGrnNo,XMLGrnYear,pub_commonBin,"bcgcolor-tblrowWhite",1);
		
		var details = [];
		details[0] 	= MatDetailID; 	// Mat ID
		details[1] 	= XMLColor; 		// Color
		details[2] 	= XMLSize;			// Size
		details[3] 	= XMLBalQty; 			// Default Qty
		details[4] 	= XMLUnit; 			// Units		
		details[5] 	= XMLSubCatId; 		// RTN							
		details[6]	= 0; 				// Add click
		details[7]  = XMLGrnNo;
		details[8]  = XMLGrnYear;
		
		Materials[mainArrayIndex] = details;
		mainArrayIndex++;
	}
}
function CreateMainGrid(tbl,MatDetailID,XMLColor,XMLSize,XMLBalQty,XMLGatPQTY,XMLSubCatId,XMLDes,XMLUnit,XMLGrnNo,XMLGrnYear,pub_commonBin,x,status)
{
	var lastRow 	= tbl.rows.length;	
	var row 		= tbl.insertRow(lastRow);
	row.className 	= x;
	
	var cell 		= row.insertCell(0);
	cell.className 	= "normalfnt";
	cell.id			= 0;
	if(status==1)
	{
	cell.innerHTML 	= "<div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" id=\"" + mainArrayIndex + "\" height=\"15\" onclick=\"RemoveItem(this);\" /></div>";
	}
	else
	cell.innerHTML 	= "<div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" id=\"" + mainArrayIndex + "\" height=\"15\" /></div>";
	
	var cell 		= row.insertCell(1);
	cell.className 	= "normalfnt";
	cell.id 		= MatDetailID;
	cell.innerHTML	= XMLDes;
	
	var cell 		= row.insertCell(2);
	cell.className 	= "normalfnt";
	cell.id 		= XMLSubCatId;
	cell.innerHTML	= XMLColor;
	
	var cell 		= row.insertCell(3);
	cell.className 	= "normalfnt";
	cell.innerHTML	= XMLSize;
	
	var cell 		= row.insertCell(4);
	cell.className 	= "normalfnt";
	cell.innerHTML	= XMLUnit;
	
	var cell 		= row.insertCell(5);
	cell.className 	= "normalfntRite";
	cell.innerHTML	= XMLGatPQTY;
	
	var cell 		= row.insertCell(6);
	cell.className 	= "normalfntRite";
	if(status==1)
	{
	cell.innerHTML	= "<input type=\"text\" id=\"txtTransInQty\" name=\"txtTransInQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onclick=\"return isNumberKey(event);\" value=\""+XMLBalQty+"\" onkeydown=\"RemoveBinColor(this);\" onkeyup=\"ValidateQty(this);SetQty(this," + mainArrayIndex  + ");\">";
	}
	else
	cell.innerHTML	= "<input type=\"text\" id=\"txtTransInQty\" name=\"txtTransInQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" value=\""+XMLBalQty+"\" readonly=\"readonly\">";
	
	
	var cell 		= row.insertCell(7);
	cell.className 	= "normalfntMid";
	if(status==1)
	{
		if(pub_commonBin==0)
			cell.innerHTML	= "<img src=\"../images/plus_16.png\" alt=\"add\"  onclick=\"OpenBinPopUp(this,"+mainArrayIndex+");SetQty(this,"+mainArrayIndex+");\"/>";
		else
			cell.innerHTML	= "&nbsp;";
	}
	else
	cell.innerHTML	= "<img src=\"../images/plus_16.png\" alt=\"add\" />";
	
	var cell 		= row.insertCell(8);
	cell.className 	= "normalfntRite";
	cell.innerHTML	= XMLGrnNo;
	
	var cell 		= row.insertCell(9);
	cell.className 	= "normalfntRite";
	cell.innerHTML	= XMLGrnYear;
}
function RemoveItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;		
		tt.parentNode.removeChild(tt);	
		Materials[obj.id] = null;		
	}
}
function SetQty(obj,index)
{
		var rw = obj.parentNode.parentNode;		
		Materials[index][3] = parseFloat(rw.cells[6].childNodes[0].value);	
}
function ValidateQty(obj)
{
	var rw 				= obj.parentNode.parentNode;
	var GatePass 		= parseFloat(rw.cells[5].childNodes[0].nodeValue);
	var TransInQty		= parseFloat(rw.cells[6].childNodes[0].value);
	
	if(GatePass<TransInQty){		
		rw.cells[6].childNodes[0].value=GatePass;
	}
}
function RemoveBinColor(obj,index)
{
	var tblMain =document.getElementById("tblTransInMain");	
	var Rw = obj.parentNode.parentNode.rowIndex;
	tblMain.rows[Rw].className = "bcgcolor-tblrowWhite";//osc3,backcolorGreen,normalfnt2BITAB,backcolorYellow
	tblMain.rows[Rw].cells[0].id =0;
}
function OpenBinPopUp(rowNo,index)
{
	showPleaseWait();
	var mainStore = document.getElementById("cboMainStore").value;
	if(mainStore == '')
	{
		alert('Please select \'Main Store \'');
		document.getElementById("cboMainStore").focus();
		hidePleaseWait();
		return false;
	}
	if(pub_commonBin==1)
	{
		alert("Common Bin System Activated.\nNo need to add bins.\nAll the bin details will save to Common Bin automatically.");
		hidePleaseWait();
		return;
	}
	var rw = rowNo.parentNode.parentNode;
	mainRw = rowNo.parentNode.parentNode.rowIndex;
	
	var ReqGatePassQty = parseFloat(rw.cells[6].childNodes[0].value);
	var stockQty	   = parseFloat(rw.cells[5].childNodes[0].nodeValue);
	
	if (ReqGatePassQty=="" || ReqGatePassQty==0 || ReqGatePassQty==isNaN)
	{
		alert ("GatePass Qty can't be '0' or empty.");
		rw.cells[6].childNodes[0].value=stockQty
		hidePleaseWait();
		 return false;
	}	
	else if (ReqGatePassQty > stockQty)
	{
		alert ("Can't issue more than stock balance.");
		rw.cells[6].childNodes[0].value =stockQty;
		hidePleaseWait();
		return false;
	}
	var subStore  = document.getElementById("cboSubStores").value;
	hidePleaseWait();
	
	var subCatId    = Materials[index][5];
	showBackGround('divBG',0);
	var url = "binitempop.php?mainStore="+mainStore +'&subStore='+subStore +'&subCatId='+subCatId +'&ReqGatePassQty='+ReqGatePassQty +'&index='+index ;
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(617,318,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
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
 function SetBinQty(objbin)
{
	var tbl = document.getElementById("tblGPTransferBinItem");
	var rw = objbin.parentNode.parentNode.parentNode;
	
	if (rw.cells[6].childNodes[0].childNodes[0].checked)
	{
	
	    totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
		var reqQty = parseFloat(rw.cells[4].lastChild.nodeValue);		
		//var GPQty = rw.cells[5].childNodes[0].value;
		
		rw.cells[5].childNodes[0].value = 0;
		var GPTranferLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
			{
				if (tbl.rows[loop].cells[6].childNodes[0].childNodes[0].checked)
					{		
						GPTranferLoopQty +=  parseFloat(tbl.rows[loop].cells[5].childNodes[0].value);
					}				
			}	
		
				var reduceQty = parseFloat(totReqQty) - parseFloat(GPTranferLoopQty) ;

					if (reqQty <= reduceQty )
					{
						rw.cells[5].childNodes[0].value = reqQty ;
					}
					else 
					{
						 rw.cells[5].childNodes[0].value = reduceQty;
					}					
	}	
	else 
		rw.cells[5].childNodes[0].value = 0;
}
function SetBinQuantityToArray(obj,index)
{	
	var tblMain =document.getElementById("tblTransInMain");	
	var tblBin = document.getElementById("tblGPTransferBinItem");
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPTransferLoopQty = 0;	
	
		for (loop =1; loop < tblBin.rows.length; loop++)
		{
			if (tblBin.rows[loop].cells[6].childNodes[0].childNodes[0].checked)
			{		
					GPTransferLoopQty +=  parseFloat(tblBin.rows[loop].cells[5].childNodes[0].value);
			}	
		}
	
	if (GPTransferLoopQty == totReqQty )
	{	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
		var details = Materials[index];
		subCatID =details[5];
			for ( var loop = 1 ;loop < tblBin.rows.length ; loop ++ )
			{
				var check =tblBin.rows[loop].cells[6].childNodes[0].childNodes[0];
				
				if (check.checked && parseFloat(tblBin.rows[loop].cells[5].childNodes[0].value)>0)
				{					
						var Bindetails = [];
							Bindetails[0] =   tblBin.rows[loop].cells[0].id; // MainStores
							Bindetails[1] =   tblBin.rows[loop].cells[1].id; // SubStores
							Bindetails[2] =   tblBin.rows[loop].cells[2].id;// Location
							Bindetails[3] =   tblBin.rows[loop].cells[3].id; // Bin ID
							Bindetails[4] =   tblBin.rows[loop].cells[5].childNodes[0].value; // IssueQty
							Bindetails[5] =   tblBin.rows[loop].cells[4].id;
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;
									
				}
			}
		Materials[index][9] = BinMaterials;				
		tblMain.rows[mainRw].className = "txtbox bcgcolor-InvoiceCostTrim";//osc3,backcolorGreen,normalfnt2BITAB,backcolorYellow
		tblMain.rows[mainRw].cells[0].id =1;
		Materials[index][6] =1;
		CloseOSPopUp('popupLayer1');
	}
	else 
	{
		alert ("Allocated Qty must equal with Req Qty. \nReq Qty =" + totReqQty + "\nAllocated Qty =" + GPTransferLoopQty +"\nVariance is =" +(totReqQty-GPTransferLoopQty));
		return false;
	}
	
}
//**************************** Saving Data **********************************************
function SaveValidation()
{
	showPleaseWait();
	document.getElementById('cmdSave').style.display = 'none';
	
	var tblMain 			= document.getElementById("tblTransInMain")
	pub_mainStoreID			= document.getElementById('cboMainStore').value;
	pub_subStoreID			= document.getElementById('cboSubStores').value;

	if(pub_mainStoreID=="")
	{
		alert("Please select the 'Main Stores'.");
		document.getElementById('cboMainStore').focus();
		hidePleaseWait();
		document.getElementById('cmdSave').style.display = 'inline';
		return false;
	}
	else if(pub_subStoreID=="")
	{
		alert("Please select the 'Sub Stores'.");
		document.getElementById('cboSubStores').focus;
		hidePleaseWait();
		document.getElementById('cmdSave').style.display = 'inline';
		return false;
	}
	else if(tblMain.rows.length<=1)
	{	alert ("No details appear to save.");
		hidePleaseWait();
		document.getElementById('cmdSave').style.display = 'inline';
		return false;
	}
	if(pub_commonBin == 0)
	{
		for(loop=1;loop<tblMain.rows.length;loop++)
		{
			if(tblMain.rows[loop].cells[0].id==0)
			{
				alert ("Cannot save without allocating bin.\nPlease allocate the bin in line no : " + [loop] +"." );
				hidePleaseWait();
				document.getElementById('cmdSave').style.display = 'inline';
				return false;
			}
		}
	}
	LoadGPTransferInNo();
}
function LoadGPTransferInNo()
{
	var TansferIn = document.getElementById("cboGPTransInNo").value
	if (TansferIn=="")
	{
		var url = 'bulkgatepasstranferinXML.php?Request=LoadGPTransferInNo';
		htmlobj=$.ajax({url:url,async:false});
		var XMLTransferInNo   = htmlobj.responseXML.getElementsByTagName("TransferInNo")[0].childNodes[0].nodeValue;
		var XMLTransferInYear = htmlobj.responseXML.getElementsByTagName("TransferInYear")[0].childNodes[0].nodeValue;
		TransferInNo 		  = parseInt(XMLTransferInNo);
		TransferInYear 		  = parseInt(XMLTransferInYear);
		document.getElementById("cboGPTransInNo").value = TransferInYear + "/" + TransferInNo;
		SaveHeader();
	}
	else
	{	
		transfer		= TansferIn.split("/");		
		TransferInNo 	= parseInt(transfer[1]);
		TransferInYear 	= parseInt(transfer[0]);
		SaveHeader();
	}
}
function SaveHeader()
{	
   var GatePassNo = $('#cboGatePassNo').val();
   var remarks    = $('#txtRemarks').val();

	var url = 'bulkgatepasstranferinXML.php?Request=SaveHeaderDetails&TransferInNo=' +TransferInNo+ '&TransferInYear=' +TransferInYear+  '&GatePassNo=' +GatePassNo+ '&remarks=' +URLEncode(remarks);
	htmlobj_header=$.ajax({url:url,async:false});
	SaveDetails();
}
function SaveDetails()
{
		var GatePassNo   = $('#cboGatePassNo').val();
	
	for (loop=0;loop<Materials.length;loop++)
	{
		var details = Materials[loop];
		
		if 	(details!=null)
		{
			var MatDetailID = details[0];
			var Color 		= details[1];
			var Size        = details[2];
			var Qty         = details[3]; 
			var Unit		= details[4];
			var SubCatID	= details[5];
			var grnNo       = details[7]; 
			var grnYear 	= details[8]; 
			var binArray    = details[9];
			
			var url = 'bulkgatepasstranferinXML.php?Request=SaveDetails&TransferInNo=' +TransferInNo+ '&TransferInYear=' +TransferInYear+'&MatDetailID=' +MatDetailID+ '&Color=' +URLEncode(Color)+ '&Size=' +URLEncode(Size)+ '&Qty=' +Qty+ '&Unit=' +Unit+ '&GatePassNo=' +GatePassNo+'&grnNo='+grnNo+'&grnYear='+grnYear;
			var htmlobj_detail=$.ajax({url:url,async:false});
			
			if(pub_commonBin==0)
			{			
				for (i = 0; i < binArray.length; i++)
				{
					var Bindetails = binArray[i];
					var MainStores = Bindetails[0]; // MainStores
					var SubStores  = Bindetails[1]; // SubStores
					var Location   = Bindetails[2];	// Location
					var BinID      = Bindetails[3]; // BinID
					var BinQty     = Bindetails[4]; // IssueQty							

					var url = 'bulkgatepasstranferinXML.php?Request=SaveBinDetails&TransferInNo=' +TransferInNo+ '&TransferInYear=' +TransferInYear+ '&MatDetailID=' +MatDetailID+ '&Color=' +URLEncode(Color)+ '&Size=' +URLEncode(Size)+ '&Unit=' +Unit+ '&MainStores=' +MainStores+ '&SubStores=' +SubStores+ '&Location=' +Location+ '&BinID=' +BinID+ '&BinQty=' +BinQty+ '&SubCatID=' +SubCatID +'&grnNo='+grnNo+'&grnYear='+grnYear;
					var htmlobj_bin=$.ajax({url:url,async:false});	
				}
			}
			else
			{
		
				var url = 'bulkgatepasstranferinXML.php?Request=SaveBinDetails&TransferInNo=' +TransferInNo+ '&TransferInYear=' +TransferInYear+ '&MatDetailID=' +MatDetailID+ '&Color=' +URLEncode(Color)+ '&Size=' +URLEncode(Size)+ '&Unit=' +Unit+ '&MainStores=' +pub_mainStoreID+ '&SubStores=' +pub_subStoreID+ '&BinQty=' +Qty+ '&commonBin=' +pub_commonBin+ '&SubCatID=' +SubCatID +'&grnNo='+grnNo+'&grnYear='+grnYear;
				var htmlobj_bin=$.ajax({url:url,async:false});						
			}
		}
	}
	if((htmlobj_header.responseText=="Header_Saved")&&(htmlobj_detail.responseText=="Detail_Saved") && (htmlobj_bin.responseText=="Stock_saved"))
	 {
		alert ("TransferIn No : " + document.getElementById("cboGPTransInNo").value +  " saved successfully.");
		hidePleaseWait();
		window.location.href='bulkgatepasstranferin.php';
		document.getElementById('cmdSave').style.display = 'none';
	 }
	 else
	 {
	 	alert("Error in saving.Please save it again.");
		hidePleaseWait();
		document.getElementById('cmdSave').style.display = 'inline';
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
	RomoveData('cboNo');
	document.getElementById('NoSearch').style.visibility = "visible";	
	var state=document.getElementById('cboState').value;
	var year=document.getElementById('cboYear').value;
	
    var url = 'bulkgatepasstranferinXML.php?Request=LoadPopUpTransIn&state='+state+'&year='+year;
    var htmlobj=$.ajax({url:url,async:false});
	document.getElementById("cboNo").innerHTML=htmlobj.responseText;	
}
function loadPopUpReturnToStores()
{
	var tbl	= document.getElementById('tblTransInMain');
	document.getElementById('NoSearch').style.visibility = "hidden";	
	
	var No   = document.getElementById('cboNo').value;
	var Year = document.getElementById('cboYear').value;
	if (No=="")
	   return false;
	
	RemoveAllRows('tblTransInMain');
	var url = 'bulkgatepasstranferinXML.php?Request=LoadPopUpHeaderDetails&No='+No+ '&Year='+Year;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLGpTranferNo 	= htmlobj.responseXML.getElementsByTagName('GpTranferNo')[0].childNodes[0].nodeValue;	
	var XMLGatePassNo 	= htmlobj.responseXML.getElementsByTagName('GatePassNo')[0].childNodes[0].nodeValue;
	var XMLStatus 		= parseInt(htmlobj.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue);
	var XMLRemarks 		= htmlobj.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
	var XMLDtmDate 		= htmlobj.responseXML.getElementsByTagName("formatedDate")[0].childNodes[0].nodeValue;
	var XMLMSID 		= htmlobj.responseXML.getElementsByTagName("MainStoresID")[0].childNodes[0].nodeValue;
	var XMLSSID 		= htmlobj.responseXML.getElementsByTagName("SubStoresID")[0].childNodes[0].nodeValue;
	
	document.getElementById('cboGatePassNo').innerHTML = XMLGatePassNo;	
	var opt = document.createElement("option");
				opt.text = XMLGatePassNo;
				opt.value = XMLGatePassNo;
				document.getElementById("cboGatePassNo").options.add(opt);
	document.getElementById('cboGatePassNo').value = XMLGatePassNo;
	
	document.getElementById('txtRemarks').value     = XMLRemarks ;
	document.getElementById('cboGPTransInNo').value = XMLGpTranferNo;				
	document.getElementById('cboGatePassNo2').value = XMLDtmDate ;
	document.getElementById('cboMainStore').value = XMLMSID ;
	LoadSubStores(XMLMSID);
	document.getElementById("cmdSave").style.display="none";
	
	
	var url     = 'bulkgatepasstranferinXML.php?Request=LoadPopUpDetails&No='+No+ '&Year='+Year;
	var xml_http_obj = $.ajax({url:url,async:false});
	
	var XMLMatDetailID	= xml_http_obj.responseXML.getElementsByTagName('MatDetailID');
	for(var loop =0; loop < XMLMatDetailID.length; loop ++)
	{
	   var MatDetailID	 	= XMLMatDetailID[loop].childNodes[0].nodeValue;
	   var XMLColor	 	    = xml_http_obj.responseXML.getElementsByTagName('Color')[loop].childNodes[0].nodeValue;
	   var XMLSize			= xml_http_obj.responseXML.getElementsByTagName('Size')[loop].childNodes[0].nodeValue;
	   var XMLBalQty		= xml_http_obj.responseXML.getElementsByTagName('BalQty')[loop].childNodes[0].nodeValue;
	   var XMLSubCatId	 	= xml_http_obj.responseXML.getElementsByTagName('intSubCatID')[loop].childNodes[0].nodeValue;
	   var XMLDes		 	= xml_http_obj.responseXML.getElementsByTagName('strItemDescription')[loop].childNodes[0].nodeValue;
	   var XMLUnit		 	= xml_http_obj.responseXML.getElementsByTagName('strUnit')[loop].childNodes[0].nodeValue;
	   var XMLGrnNo	 	    = xml_http_obj.responseXML.getElementsByTagName('intGRNNo')[loop].childNodes[0].nodeValue;
	   var XMLGrnYear	 	= xml_http_obj.responseXML.getElementsByTagName('intGRNYear')[loop].childNodes[0].nodeValue;
	   var XMLGatePassQty	= xml_http_obj.responseXML.getElementsByTagName('GatePassQty')[loop].childNodes[0].nodeValue;
		
		CreateMainGrid(tbl,MatDetailID,XMLColor,XMLSize,XMLBalQty,XMLGatePassQty,XMLSubCatId,XMLDes,XMLUnit,XMLGrnNo,XMLGrnYear,pub_commonBin,"txtbox bcgcolor-InvoiceCostTrim",0);
	}
	
	
}
function ClearForm()
{
	document.getElementById('cmdSave').style.display = 'inline';
	window.location.href='bulkgatepasstranferin.php';
}
function showReport()
{
	showPleaseWait();
	var No			= document.getElementById('cboGPTransInNo').value;
	if(No=="")
	{
		alert("No \"Transfer In No\" to generate report.");
		hidePleaseWait();
		return;
	}
	var NoArray		= No.split("/");
	var year		= NoArray[0];
	var TransInNo	= NoArray[1];
	if(TransInNo!="0")
	{
		hidePleaseWait();
		newwindow=window.open('BulkTransferInReport.php?TransferInNo='+TransInNo+'&TransferInYear='+year,'name');
			if (window.focus) {newwindow.focus()}	
	}
}
function LoadBTIDetails()
{
	document.frmBulkTIListing.submit();
}