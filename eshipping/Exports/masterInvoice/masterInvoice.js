// JavaScript Document
var pub_MasterInvNo  = 0;
var pub_InvId = 0;


$(document).ready(function() 
{
		
		var url1					='masterInvoicedb.php?request=load_carrier';
		var pub_xml_http_obj1	=$.ajax({url:url1,async:false});
		var carrier_arr			=pub_xml_http_obj1.responseText.split("|");
		
		$( "#cboBuyer" ).autocomplete({
			source: carrier_arr
		});

});


function getInvoiceDetails()
{
	var carrier = document.getElementById('cboBuyer').value;
	 var url     = 'masterInvoicedb.php?request=getInvoiceDetails&carrier='+carrier+'&dateTo='+document.getElementById('txtDateTo').value+'&dateFrom='+document.getElementById('txtDateFrom').value;
	 var htmlobj = $.ajax({url:url,async:false});
	 del_tbl_pop();
	 
	var xmlInvoiceNo		= htmlobj.responseXML.getElementsByTagName('InvoiceNo');
	var xmlDescOfGoods		= htmlobj.responseXML.getElementsByTagName('DescOfGoods');
	var xmlBuyerPONo		= htmlobj.responseXML.getElementsByTagName('BuyerPONo');
	var xmlStyle			= htmlobj.responseXML.getElementsByTagName('Style');
	var xmlNoOfCTns			= htmlobj.responseXML.getElementsByTagName('NoOfCTns');
	var xmlQuantity			= htmlobj.responseXML.getElementsByTagName('Quantity');
	var xmlUnitPrice		= htmlobj.responseXML.getElementsByTagName('UnitPrice');
	var xmlAmount			= htmlobj.responseXML.getElementsByTagName('Amount');
	
	var tbl				=$('#tblDescription')
	for(var loop=0; loop<xmlInvoiceNo.length;loop++)
	{
		var InvoiceNo 		= xmlInvoiceNo[loop].childNodes[0].nodeValue;
		var DescOfGoods     = xmlDescOfGoods[loop].childNodes[0].nodeValue;
		var BuyerPONo	    = xmlBuyerPONo[loop].childNodes[0].nodeValue;
		var Style 		  	= xmlStyle[loop].childNodes[0].nodeValue;
		var NoOfCTns   	  	= xmlNoOfCTns[loop].childNodes[0].nodeValue;
		var Qty	      		= xmlQuantity[loop].childNodes[0].nodeValue;
		var UnitPrice 		= xmlUnitPrice[loop].childNodes[0].nodeValue;
		var Amount	        = xmlAmount[loop].childNodes[0].nodeValue;
		
		createMainGrid(InvoiceNo,DescOfGoods,BuyerPONo,Style,NoOfCTns,Qty,UnitPrice,Amount,loop);
	}
}
function createMainGrid(InvoiceNo,DescOfGoods,BuyerPONo,Style,NoOfCTns,Qty,UnitPrice,Amount,loop)
{		
	var tbl			= $('#tblDescription');	
	var lastRow 	= $('#tblDescription tr').length;
	var row 		= tbl[0].insertRow(lastRow);
	row.className	='bcgcolor-tblrowWhite';
	
	if(loop % 2 ==0)
	row.className ="bcgcolor-tblrowWhite";
	else
	row.className ="bcgcolor-tblrow";
	
	var rowCell 	  	= row.insertCell(0);
	rowCell.height	  	="25"
	rowCell.className 	= "normalfntMid";
	rowCell.innerHTML 	="<input type=\"checkbox\" id=\"checkboxgrid\" name=\"checkboxgrid\" checked=\"\" /> ";	
	
	
	var rowCell 	  	= row.insertCell(1);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML 	= InvoiceNo;
	rowCell.noWrap		='nowrap';
	
	var rowCell 	  	= row.insertCell(2);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML 	= DescOfGoods;
	
	var rowCell 	  	= row.insertCell(3);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML 	= BuyerPONo;
	rowCell.noWrap	  	= "nowrap"
	
	var rowCell 	  	= row.insertCell(4);
	rowCell.className 	= "normalfnt";
	rowCell.innerHTML 	= Style;
	rowCell.noWrap	  	= "nowrap"
	
	var rowCell 	  	= row.insertCell(5);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML 	= NoOfCTns;
	rowCell.noWrap	  	= "nowrap"
	
	var rowCell 	  	= row.insertCell(6);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML 	= Qty;
	rowCell.noWrap	  	= "nowrap"
	
	var rowCell 	  	= row.insertCell(7);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML 	= UnitPrice;
	rowCell.noWrap	  	= "nowrap"
	
	var rowCell 	  	= row.insertCell(8);
	rowCell.className 	= "normalfntRite";
	rowCell.innerHTML 	= Amount;
	rowCell.noWrap	  	= "nowrap"
	
}
function del_tbl_pop()

{
	$('#tblDescription tr:gt(0)').remove()
}
function clearData()
{
	del_tbl_pop();
	document.frmMasterInvoice.reset();
}
function saveData()
{
	var masterInvId = $('#cboMasterInvNo').val();
	
	if(!ValidateInvNoBeforeSave())
		return;
	
	if(!validateSave())
		return;
		
	if(masterInvId=="")
	{
		getInvId();
		saveHeader(pub_InvId);
	}
	else
	{
		pub_InvId = masterInvId;
		saveHeader(pub_InvId);
	}
}
function getInvId()
{
	var url      = 'masterInvoicedb.php?request=getMasterInvId';
	var htmlobj  = $.ajax({url:url,async:false});
	if(htmlobj.responseText=="")
	{
		alert("Error in Saving.");
		return;
	}
	else
	pub_InvId    = htmlobj.responseText;
}
function ValidateInvNoBeforeSave()
{
	var masterInvId = $('#cboMasterInvNo').val();
	var masterInvNo = $('#txtInvoiceNo').val();
	var url = 'masterInvoicedb.php?request=checkMasterInvNoAvailble&masterInvId='+masterInvId+'&masterInvNo='+masterInvNo;
	var htmlobj  = $.ajax({url:url,async:false});
	if(htmlobj.responseText==true)
	{
		alert("\""+masterInvNo+"\" is already exist.");	
		document.getElementById("txtInvoiceNo").focus();
		return false;
	}
	return true;
}
function saveHeader(InvId)
{
	var masterInvoiceNo = $('#txtInvoiceNo').val();
	var date 		    = $('#txtDate').val();
	var buyerId 		= $('#cboBuyer').val();
	
	var url     = 'masterInvoicedb.php?request=saveHeaderData&InvId='+InvId+'&masterInvoiceNo='+masterInvoiceNo+'&date='+date+'&buyerId='+buyerId;
	var htmlobj = $.ajax({url:url,async:false});
	//alert(htmlobj.responseText);
	if(htmlobj.responseText=="headerSaved")
	{
		saveDetails(InvId);
	}
	else
	{
		alert("Error in saving.");
		return;
	}
}
function saveDetails(InvId)
{
	var tbl = document.getElementById("tblDescription");
	for(var i=1;i<tbl.rows.length;i++)
	{
		if(tbl.rows[i].cells[0].childNodes[0].checked == true)
		{
			var checkSave = false;
			var invNo	   	= tbl.rows[i].cells[1].childNodes[0].nodeValue;
			var Description	= tbl.rows[i].cells[2].childNodes[0].nodeValue;
			var PONo    	= tbl.rows[i].cells[3].childNodes[0].nodeValue;
			var styleNo	   	= tbl.rows[i].cells[4].childNodes[0].nodeValue;
			var CTNS	  	= tbl.rows[i].cells[5].childNodes[0].nodeValue;
			var Pcs 	   	= tbl.rows[i].cells[6].childNodes[0].nodeValue;
			var UPrice	   	= tbl.rows[i].cells[7].childNodes[0].nodeValue;
			var amount 	   	= tbl.rows[i].cells[8].childNodes[0].nodeValue;
			
			var url = "masterInvoicedb.php?request=saveDetailData&InvId="+InvId+"&invNo="+URLEncode(invNo)+"&Description="+URLEncode(Description)+"&PONo="+URLEncode(PONo)+"&styleNo="+URLEncode(styleNo)+"&CTNS="+CTNS+"&Pcs="+Pcs+"&UPrice="+UPrice+"&amount="+amount;
			var htmlobj  = $.ajax({url:url,async:false});
			if(htmlobj.responseText=="detailSaved")
				checkSave = true;	
		}
	}
	if(checkSave==true)
		{
			alert("saved Successfully.");
			loadCombo('select intMasterInvId,strMasterInvNo from masterinvoice_header order by strMasterInvNo;','cboMasterInvNo');
			
		}
		else
		{
			alert("Error in saving.");
			return;
		}
}

function validateSave()
{
	var invoiceNo = $('#txtInvoiceNo').val();
	var buyer	  = $('#cboBuyer').val();
	var tbl       = document.getElementById("tblDescription");
	var checkStatus = false;
	
	if(invoiceNo=="")
	{
		alert("Please enter Invoice No.")
		document.getElementById("txtInvoiceNo").focus();
		return false;
	}
	if(tbl.rows.length<2)
	{
		alert("No record to save. Please select a buyer.");
		document.getElementById("cboBuyer").focus();
		return false;
	}
	
	for(var i=1;i<tbl.rows.length;i++)
	{
		if(tbl.rows[i].cells[0].childNodes[0].checked ==true)
		{
			checkStatus = true;
		}
	}
	if(checkStatus==false)
	{
		alert("Please check at least one record to save.");
		document.getElementById("cboBuyer").focus();
		return false;
	}
	
	return true;
}
function checkAll(obj)
{
	var tblgrid = document.getElementById("tblDescription");
	if(obj.checked)
		var check = true;
	else
		var check = false;
		
	for(loop=1;loop<tblgrid.rows.length;loop++)
	{
		tblgrid.rows[loop].cells[0].childNodes[0].checked = check;		
	}
}
function loadMasterInvData()
{
	var masterInvNo = $('#cboMasterInvNo').val();
	if(masterInvNo=="")
	{
		clearData();
		return;
	}
	var url = 'masterInvoicedb.php?request=loadMasterInvHData&masterInvNo='+masterInvNo;
	var xml_http_obj = $.ajax({url:url,async:false});
	
	 $('#txtInvoiceNo').val(xml_http_obj.responseXML.getElementsByTagName('MasterInvNo')[0].childNodes[0].nodeValue);
     $('#txtDate').val(xml_http_obj.responseXML.getElementsByTagName('Date')[0].childNodes[0].nodeValue);
	 $('#cboBuyer').val(xml_http_obj.responseXML.getElementsByTagName('BuyerId')[0].childNodes[0].nodeValue);
	 
	 loadMasterInvDetailData(masterInvNo);
}
function loadMasterInvDetailData(masterInvNo)
{
	var url = 'masterInvoicedb.php?request=loadMasterInvDData&masterInvNo='+masterInvNo;
	var htmlobj = $.ajax({url:url,async:false});
	del_tbl_pop();
	
	var xmlInvoiceNo		= htmlobj.responseXML.getElementsByTagName('InvoiceNo');
	var xmlDescOfGoods		= htmlobj.responseXML.getElementsByTagName('DescOfGoods');
	var xmlBuyerPONo		= htmlobj.responseXML.getElementsByTagName('BuyerPONo');
	var xmlStyle			= htmlobj.responseXML.getElementsByTagName('Style');
	var xmlNoOfCTns			= htmlobj.responseXML.getElementsByTagName('NoOfCTns');
	var xmlQuantity			= htmlobj.responseXML.getElementsByTagName('Quantity');
	var xmlUnitPrice		= htmlobj.responseXML.getElementsByTagName('UnitPrice');
	var xmlAmount			= htmlobj.responseXML.getElementsByTagName('Amount');
	
	
	for(var loop=0; loop<xmlInvoiceNo.length;loop++)
	{
		var InvoiceNo 		= xmlInvoiceNo[loop].childNodes[0].nodeValue;
		var DescOfGoods     = xmlDescOfGoods[loop].childNodes[0].nodeValue;
		var BuyerPONo	    = xmlBuyerPONo[loop].childNodes[0].nodeValue;
		var Style 		  	= xmlStyle[loop].childNodes[0].nodeValue;
		var NoOfCTns   	  	= xmlNoOfCTns[loop].childNodes[0].nodeValue;
		var Qty	      		= xmlQuantity[loop].childNodes[0].nodeValue;
		var UnitPrice 		= xmlUnitPrice[loop].childNodes[0].nodeValue;
		var Amount	        = xmlAmount[loop].childNodes[0].nodeValue;
		
		createMainGrid(InvoiceNo,DescOfGoods,BuyerPONo,Style,NoOfCTns,Qty,UnitPrice,Amount,loop);
	}
}

function showReport()
{
	if(document.getElementById('cboMasterInvNo').value=="")
		alert("Please select Invoice No");
	else
		window.open('landsendMasterInv.php?masInvNo='+document.getElementById('cboMasterInvNo').value,'landsEnd');
}