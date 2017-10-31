var mainArrayIndex 		= 0;
var Materials 			= [];
var pub_genGPno			= 0;
var pub_genGPyear		= 0;
//BEGIN - Main Item Grid Column Variable
var m_del 				= 0 ;	// Delete button
var m_iDec 				= 1 ;	// Item Description
var m_unit				= 2; 	//unit
var m_gpQty				= 3;	//gatepass qty
var m_stockQty			= 4;    //stock Qty
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
	document.frmIssues.reset();
	ClearTable('tblGPItemList');
	Materials = [];
	mainArrayIndex 	= 0;
	document.getElementById('butSave').style.display = 'inline';
	document.getElementById('butSave').style.display = 'inline';
}
function OpenItemPopUp()
{
			
	showBackGround('divBG',0);
	var url = "gatepassitemlist.php?";
		
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(650,532,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;
	//fix_header('tblPopItem',550,388);	
}

function LoadSubCat(obj)
{
	var url = "gengatepassxml.php?RequestType=loadSubCategory";
	url += "&mainCatId="+obj.value;
	
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboPopSubCat').innerHTML = htmlobj.responseXML.getElementsByTagName("intSubCatNo")[0].childNodes[0].nodeValue;
}

function LoadPopItems()
{
	var url = "gengatepassxml.php?RequestType=LoadPopItems";
	url += "&MainCat="+document.getElementById('cboPopMainCat').value;
	url += "&SubCat="+document.getElementById('cboPopSubCat').value;
	url += "&ItemDesc="+document.getElementById('txtDesc').value;
	htmlobj=$.ajax({url:url,async:false});
	CreatePopUpItemGrid(htmlobj);
}

function CreatePopUpItemGrid(htmlobj)
{
	var XMLItemId 		= htmlobj.responseXML.getElementsByTagName("ItemId");
	var XMLItemDesc 	= htmlobj.responseXML.getElementsByTagName("ItemDesc");
	var XMLstockBalQty  = htmlobj.responseXML.getElementsByTagName("balQty");
	var XMLUnit 		= htmlobj.responseXML.getElementsByTagName("Unit");
	var XMLgrnno 		= htmlobj.responseXML.getElementsByTagName("GRNNo");
	var XMLgrnyear 		= htmlobj.responseXML.getElementsByTagName("GRNYear");
	var XMLcostCenterId = htmlobj.responseXML.getElementsByTagName("costCenterId");
	var XMLcostCenterDes = htmlobj.responseXML.getElementsByTagName("costCenterDes");
	var XMLGLAlloId		= htmlobj.responseXML.getElementsByTagName("intGLAllowId");
	var XMLGLcode		= htmlobj.responseXML.getElementsByTagName("glCode");
	var XMLCostCenterCode = htmlobj.responseXML.getElementsByTagName("costCenterCode");
	var XMLItemCodeCode = htmlobj.responseXML.getElementsByTagName("ItemCode");
	
	var tbl 			= document.getElementById('tblPopItem1');
	ClearTable('tblPopItem1');
	for(loop=0;loop<XMLItemId.length;loop++)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
		
		var cell = row.insertCell(0);
		cell.className ="normalfntMid";
		cell.setAttribute('height','20');
		cell.innerHTML = "<input name=\"checkbox\" type=\"checkbox\" >";
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.id = XMLItemId[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLItemDesc[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.innerHTML = XMLUnit[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(3);
		cell.className ="normalfntRite";
		cell.innerHTML = XMLstockBalQty[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(4);
		cell.className ="normalfntMid";
		cell.innerHTML = XMLgrnno[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(5);
		cell.className ="normalfntMid";
		cell.innerHTML = XMLgrnyear[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(6);
		cell.className ="normalfntMid";
		//cell.id		   = XMLItemCodeCode[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLItemCodeCode[loop].childNodes[0].nodeValue;
		
		/*var cell = row.insertCell(6);
		cell.className ="normalfntMid";
		cell.id		   = XMLcostCenterId[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLcostCenterDes[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(7);
		cell.className ="normalfntMid";
		cell.id		   = XMLGLAlloId[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLGLcode[loop].childNodes[0].nodeValue+'-'+XMLCostCenterCode[loop].childNodes[0].nodeValue;*/
	}
	fix_header('tblPopItem',550,388);	
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

function AddToMainPage()
{
	var tbl 	= document.getElementById('tblPopItem1');
	var tblMain = document.getElementById('tblGPItemList');
	var status  =0;
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			var matDetailID = tbl.rows[loop].cells[1].id;
			var ItemDesc	= tbl.rows[loop].cells[1].innerHTML;
			var Itemunit	= tbl.rows[loop].cells[2].innerHTML;
			var balQty		= tbl.rows[loop].cells[3].innerHTML;
			var gpQty       = 0;
			var grnno		= tbl.rows[loop].cells[4].innerHTML;
			var grnyear		= tbl.rows[loop].cells[5].innerHTML;
			
			//================================================================================
			// Comment On - 11/11/2013
			//================================================================================
			/*var costCenterId = tbl.rows[loop].cells[6].id;
			var costCenterDes = tbl.rows[loop].cells[6].innerHTML;
			var glAlloId 	= tbl.rows[loop].cells[7].id;
			var glCode = tbl.rows[loop].cells[7].innerHTML;
			
			CreadeMainGrid(tblMain,matDetailID,ItemDesc,Itemunit,balQty,gpQty,status,grnno,grnyear,costCenterId,costCenterDes,glAlloId,glCode);*/
			
			//================================================================================
			
			CreadeMainGrid(tblMain,matDetailID,ItemDesc,Itemunit,balQty,gpQty,status,grnno,grnyear,0,0,0,0);
		}
	}
	CloseOSPopUp('popupLayer1');
	
}
function CreadeMainGrid(tbl,matDetailID,ItemDesc,Itemunit,balQty,gpQty,status,grnno,grnyear,costCenterId,costCenterDes,glAlloId,glCode)
{
	var booCheck = true;
	for(mainLoop=1;mainLoop<tbl.rows.length;mainLoop++)
	{
		var mainMatId 	= tbl.rows[mainLoop].cells[1].id;
		var GRNNo		= tbl.rows[mainLoop].cells[5].childNodes[0].nodeValue;
		var GRNYear		= tbl.rows[mainLoop].cells[6].childNodes[0].nodeValue;
		//var ccId		= tbl.rows[mainLoop].cells[7].id;
		//var GLAllocationId = tbl.rows[mainLoop].cells[8].id;
		
		if(mainMatId==matDetailID && GRNNo==grnno && GRNYear==grnyear && costCenterId==ccId && glAlloId==GLAllocationId)
			booCheck = false;	
		
	}
	if(booCheck)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className 	= "bcgcolor-tblrowWhite";
		
		var cell 		= row.insertCell(m_del);
		cell.className 	= "normalfntMid";
		cell.setAttribute('height','20');
		cell.id			= 0;
		if(status == 0)
			cell.innerHTML 	= "<img alt=\"add\" src=\"../../images/del.png\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" >";
		else
			cell.innerHTML = "";
		
		var cell 		= row.insertCell(m_iDec);
		cell.className 	= "normalfnt";
		cell.id 		= matDetailID;
		cell.innerHTML 	= ItemDesc;
		
		var cell 		= row.insertCell(m_unit);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= Itemunit;
		
		var cell 		= row.insertCell(m_gpQty);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= "<input type=\"text\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" style=\"width: 70px; text-align: right;\" class=\"txtbox\"  value=\""+gpQty+"\" onkeyup=\"SetQtyToArray(this,"+mainArrayIndex+");\">";
		
		var cell 		= row.insertCell(m_stockQty);
		cell.className 	= "normalfnt";
		cell.innerHTML 	= balQty;
		
		var cell 		= row.insertCell(5);
		cell.className 	= "normalfntMid";
		cell.innerHTML 	= grnno;
		
		var cell 		= row.insertCell(6);
		cell.className 	= "normalfntMid";
		cell.innerHTML 	= grnyear;
		
		/*var cell 		= row.insertCell(7);
		cell.className 	= "normalfntMid";
		cell.id    		= costCenterId;
		cell.innerHTML 	= costCenterDes;
		
		var cell 		= row.insertCell(8);
		cell.className 	= "normalfntMid";
		cell.id    		= glAlloId;
		cell.innerHTML 	= glCode;*/
		
		var details = [];
		details[0] = matDetailID; 	// Matdetail Id
		details[1] = gpQty; 	// Gatepass Qty
		details[2] = Itemunit; //unit
		details[3] = grnno;
		details[4] = grnyear;
		details[5] = 0;//costCenterId;
		details[6] = 0;//glAlloId;
		
		Materials[mainArrayIndex] = details;
		mainArrayIndex ++ ;
	}
}

function SetQtyToArray(obj,index)
{
	var rw 				= obj.parentNode.parentNode;
	var gpQty 		= parseFloat(obj.value);
	var stockQty		= parseFloat(rw.cells[m_stockQty].innerHTML);
	
	if(gpQty>stockQty)
		{
			obj.value 	= stockQty;
			gpQty	= stockQty;
		}
	Materials[index][1] = gpQty;
	rw.cells[m_del].id 	= 0;
	rw.className 		= "bcgcolor-tblrowWhite";
}

function Validate(type,tbl)
{
	if(type == 'saveGP')
	{
		if(tbl.rows.length <=1)
		{
			alert("No details appear to save.");
			return false
		}
		if(document.getElementById('cboreturnedby').value == '')
		{
			alert ("Please select 'Destination'.");
			document.getElementById('cboreturnedby').focus();
			return false;
		}
		if(document.getElementById('cboinstruct').value == '')
		{
			alert ("Please select 'Instructed By'.");
			document.getElementById('cboinstruct').focus();
			return false;
		}
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if (tbl.rows[loop].cells[3].childNodes[0].value==0){
				alert ("Gatepass Qty should be greater than 0 \n Line No : " + [loop] +".");
				tbl.rows[loop].cells[3].childNodes[0].select();
				return false;				
			}	
		}	
	}
	
	return true;
}

function saveGatePass()
{
	showPleaseWait();
	document.getElementById('butSave').style.display = 'none';
	var no 	= document.getElementById('txtreturnNo');
	var tbl = document.getElementById('tblGPItemList');
	if(!Validate('saveGP',tbl))
	{
		document.getElementById('butSave').style.display = 'inline';
		hidePleaseWait();
		return;
	}
	
	if(no.value=="")
	{
		GetNewGPNo();
		SaveHeader();
		SaveDetails()
	}
	else
	{
		no 				= no.value.split("/");
		pub_genGPno 	= parseInt(no[1]);
		pub_genGPyear 	= parseInt(no[0]);
		SaveHeader();
		SaveDetails();
	}
	document.getElementById('butSave').style.display = 'none';
	document.getElementById('butConfirm').style.display = 'inline';
	hidePleaseWait();
	alert("Saved successfully.");
	
}

function GetNewGPNo()
{
	var url = "gengatepassxml.php?RequestType=LoadGenGPno";
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLresponse = htmlobj.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
	if(XMLresponse == 'TRUE')
	{
		var genGPno = htmlobj.responseXML.getElementsByTagName("genGPNo")[0].childNodes[0].nodeValue;
		var genGPyear = htmlobj.responseXML.getElementsByTagName("genGPYear")[0].childNodes[0].nodeValue;
		pub_genGPno = parseInt(genGPno);
		pub_genGPyear = parseInt(genGPyear);
		document.getElementById('txtreturnNo').value = pub_genGPyear+'/'+genGPno;
	}
	else
	{
		alert('Error in generating Gatepass No');
		return false;
	}
}

function SaveHeader()
{
	var url = "gengatepassxml.php?RequestType=saveGenGPheader";
		url += "&GenGPNo="+pub_genGPno;
		url += "&GenGPYear="+pub_genGPyear;
		url += "&GPtoFac="+document.getElementById('cboreturnedby').value;
		url += "&attentionBy="+URLEncode(document.getElementById('txtattention').value);
		url += "&txtthrough="+URLEncode(document.getElementById('txtthrough').value);
		url += "&instruct="+URLEncode(document.getElementById('cboinstruct').value);
		
	htmlobj=$.ajax({url:url,async:false});
	var response = htmlobj.responseXML.getElementsByTagName("genGPHeaderResponse")[0].childNodes[0].nodeValue;
	
	if(response != '1')
	{
		alert('Error in Genearal GP header');
		hidePleaseWait();
		return false;
	}
}

function SaveDetails()
{
	for (var loop = 0 ; loop < Materials.length ; loop ++)
	{	
		var details = Materials[loop] ;
		if 	(details!=null)
		{			
			var matId 		= details[0]; 	// Matdetail Id
			var gpQty		= details[1]; 	// gatepass qty
			var itemUnit    = details[2]; //unit
			var grnno    	= details[3];
			var grnyear     = details[4];
			var costCenterId = details[5];
			var glAlloId    = details[6];
			
			var url = "gengatepassxml.php?RequestType=saveGenGPdetails";
			url += "&GenGPNo="+pub_genGPno;
			url += "&GenGPYear="+pub_genGPyear;
			url += "&matId="+matId;
			url += "&gpQty="+gpQty;
			url += "&itemUnit="+itemUnit;
			url += "&grnno="+grnno;
			url += "&grnyear="+grnyear;
			url += "&GPtoFac="+document.getElementById('cboreturnedby').value;
			url += "&costCenterId="+costCenterId;
			url += "&glAlloId="+glAlloId;
			
			htmlobj=$.ajax({url:url,async:false});
		}
	}
}
function openReport()
{
	window.open('generalgatepassreport.php?gatePassNo='+document.getElementById('txtreturnNo').value,'frmIssues')	
}
function openConfirmRpt()
{
	document.getElementById('butConfirm').style.display = 'none';
	if(document.getElementById('txtreturnNo').value == '')
	{
		alert("Gatepass No not available");
		document.getElementById('butConfirm').style.display = 'inline';
		return;
	}
	else
		window.open('genGPconfirmReport.php?gatePassNo='+document.getElementById('txtreturnNo').value,'frmIssues')	
}
function showFindGenGPpopup()
{
	if(document.getElementById('gotoReport').style.visibility=="hidden")
	{
		document.getElementById('gotoReport').style.visibility = "visible";
		LoadPopUpGenGPNo();
	}
	else
	{
		document.getElementById('gotoReport').style.visibility="hidden";
		return;
	}
}
function closeFindGPpopup()
{
	document.getElementById('gotoReport').style.visibility="hidden";
	return;
}
function LoadPopUpGenGPNo()
{
	var status = document.getElementById('cboPpoupState').value;
	var GPyear = document.getElementById('cboPopupYear').value;
	var url = "gengatepassxml.php?RequestType=loadPopupGenGPNoList";
		url += "&status="+status;
		url += "&GPyear="+GPyear;
	htmlobj=$.ajax({url:url,async:false});
	
	document.getElementById('cboPopupGPNo').innerHTML = htmlobj.responseXML.getElementsByTagName("GPNoList")[0].childNodes[0].nodeValue;
}

function loadGPNolist()
{
	var status = document.getElementById('cboGPlistStatus').value;
	var GPyear = document.getElementById('cboGPYear').value;
	var url = "gengatepassxml.php?RequestType=loadPopupGenGPNoList";
		url += "&status="+status;
		url += "&GPyear="+GPyear;
	htmlobj=$.ajax({url:url,async:false});
	
	document.getElementById('cboGenGPNofrom').innerHTML = htmlobj.responseXML.getElementsByTagName("GPNoList")[0].childNodes[0].nodeValue;
	document.getElementById('cboGenGPNoTo').innerHTML = htmlobj.responseXML.getElementsByTagName("GPNoList")[0].childNodes[0].nodeValue;
}
function loadGenGPDetails()
{
	ClearForm();
	var status = document.getElementById('cboPpoupState').value;
	var GPyear = document.getElementById('cboPopupYear').value;
	var GPNo   = document.getElementById('cboPopupGPNo').value;
	
	loadGenGPData(GPNo,GPyear,status);
	closeFindGPpopup();
}

function loadGenGPData(GPNo,GPyear,status)
{
	if(GPNo !=0)
	{
	var url = "gengatepassxml.php?RequestType=loadGenGPHeaderDetails";
		url += "&status="+status;
		url += "&GPyear="+GPyear;
		url += "&GPNo="+GPNo;
		
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('txtreturnNo').value = GPyear+'/'+GPNo;
	document.getElementById('txtattention').value = htmlobj.responseXML.getElementsByTagName("strAttention")[0].childNodes[0].nodeValue;
	document.getElementById('txtthrough').value = htmlobj.responseXML.getElementsByTagName("strThrough")[0].childNodes[0].nodeValue;
	document.getElementById('cboreturnedby').value = htmlobj.responseXML.getElementsByTagName("intToStores")[0].childNodes[0].nodeValue;
	document.getElementById('cboinstruct').value = htmlobj.responseXML.getElementsByTagName("intInstructedBy")[0].childNodes[0].nodeValue;
	
	loadGPDetails(GPNo,GPyear,status);
		switch(parseInt(status))
		{
			case 0:
			{
				document.getElementById('butSave').style.display = 'inline';
				document.getElementById('butConfirm').style.display = 'inline';
				break;
			}
			case 1:
			{
				document.getElementById('butSave').style.display = 'none';
				document.getElementById('butConfirm').style.display = 'none';
				break;
			}
		}
	}
}
function loadGPDetails(GPNo,GPyear,status)
{
	
	var url = "gengatepassxml.php?RequestType=loadGenGPDetailsData";
		url += "&GPyear="+GPyear;
		url += "&GPNo="+GPNo;
		
	htmlobj=$.ajax({url:url,async:false});
	var tbl = document.getElementById('tblGPItemList');
	
	var XMLmatDetailID = htmlobj.responseXML.getElementsByTagName("intMatDetailID");
			for(i=0;i<XMLmatDetailID.length;i++)
			{
				var matDetailID	= htmlobj.responseXML.getElementsByTagName("intMatDetailID")[i].childNodes[0].nodeValue;
				var ItemDesc 	= htmlobj.responseXML.getElementsByTagName("strItemDescription")[i].childNodes[0].nodeValue;
				var Itemunit 	= htmlobj.responseXML.getElementsByTagName("strUnit")[i].childNodes[0].nodeValue;
				var balQty 		= htmlobj.responseXML.getElementsByTagName("stockBalQty")[i].childNodes[0].nodeValue;
				var gpQty 		= htmlobj.responseXML.getElementsByTagName("gpQty")[i].childNodes[0].nodeValue;
				var grnNo 		= htmlobj.responseXML.getElementsByTagName("grnNo")[i].childNodes[0].nodeValue;
				var grnYear 	= htmlobj.responseXML.getElementsByTagName("grnYear")[i].childNodes[0].nodeValue;
				var CCId 		= htmlobj.responseXML.getElementsByTagName("CostCenterId")[i].childNodes[0].nodeValue;
				var CCdes 		= htmlobj.responseXML.getElementsByTagName("CostCenterDes")[i].childNodes[0].nodeValue;
				var GLAlloID 	= htmlobj.responseXML.getElementsByTagName("GLAlloID")[i].childNodes[0].nodeValue;
				var GLcode 	= htmlobj.responseXML.getElementsByTagName("GLcode")[i].childNodes[0].nodeValue;
				
				CreadeMainGrid(tbl,matDetailID,ItemDesc,Itemunit,balQty,gpQty,status,grnNo,grnYear,CCId,CCdes,GLAlloID,GLcode);
			}
	
	
}

function confirmGenGP(GPNo,GPyear)
{
	var url = "gengatepassxml.php?RequestType=confirmGenGPDetails";
		url += "&GPyear="+GPyear;
		url += "&GPNo="+GPNo;
		
	htmlobj=$.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	var result = htmlobj.responseXML.getElementsByTagName("message")[0].childNodes[0].nodeValue;
	var GenGPno = GPyear+'/'+GPNo;
	if(result == 'saved')
	{
		alert('Confirmed successfully');
		window.open('generalgatepassreport.php?gatePassNo='+GenGPno,'frmIssues')
	}
	else
	{
		alert(result);
		return;
	}
}