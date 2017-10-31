// JavaScript Document
var url					='costworksheetrevisedb.php?RequestType=load_InvoiceNo';
var pub_xml_http_obj	=$.ajax({url:url,async:false});
var pub_po_arr			=pub_xml_http_obj.responseText.split("|");

$(document).ready(function() 
{
	$( "#txtFSNo" ).autocomplete({
			source: pub_po_arr
		});

});
function setOrderNo(invNo)
{
	var url = 'costworksheetrevisedb.php?RequestType=loadOrderNo&invNo='+URLEncode(invNo);
	htmlobj = $.ajax({url:url,async:false});
	var XMLOrderNo = htmlobj.responseText;
	document.getElementById('cboOrderNo').innerHTML = XMLOrderNo;
	loadOrderWiseColor('');
}
function isEnterKey(evt,invNo)
{
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode == 13)
	 {
		 setOrderNo(invNo);
	 }
}

function loadOrderWiseColor(styleId)
{
	if(styleId=="")
		styleId = document.getElementById("cboOrderNo").value;
	var url = 'costworksheetrevisedb.php?RequestType=loadOrderWiseColor&styleId='+styleId;
	var htmlobj = $.ajax({url:url,async:false});
	var XMLColor = htmlobj.responseText;
	document.getElementById('cboColor').innerHTML = XMLColor;
}
function saveData()
{
	if(!validateSave())
		return;
		
	var invNo   = $('#txtFSNo').val();
	var orderNo = $('#cboOrderNo').val();
	var reason  = $('#txtReviseReason').val();
	
	if(document.getElementById("rdoRevise1").checked=="1")
	{
		var url = "costworksheetrevisedb.php?RequestType=reviseInvandCost&invNo="+URLEncode(invNo)+"&orderNo="+orderNo+"&reason="+URLEncode(reason);
		var htmlobj = $.ajax({url:url,async:false});
		if(htmlobj.responseText == "true")
		{
			alert("revise Successfully.");
			window.location.href='costworksheetrevise.php';
		}
		else
		{
			alert("Error in revising.");
			return;
		}
	}
	if(document.getElementById("rdoRevise2").checked=="1")
	{
		var url = "costworksheetrevisedb.php?RequestType=reviseInvOnly&invNo="+URLEncode(invNo)+"&orderNo="+orderNo+"&reason="+URLEncode(reason);
		var htmlobj = $.ajax({url:url,async:false});
		if(htmlobj.responseText == "true")
		{
			alert("revise Successfully.");
			window.location.href='costworksheetrevise.php';
		}
		else
		{
			alert("Error in revising.");
			return;
		}
	}
	if(document.getElementById("rdoRevise3").checked=="1")
	{
		var url_c = "costworksheetrevisedb.php?RequestType=chkCostingHasManyInvoices&invNo="+URLEncode(invNo)+"&orderNo="+orderNo;
		var htmlobj_c = $.ajax({url:url_c,async:false});
		//alert(htmlobj_c.responseText)
		if(htmlobj_c.responseText >1)
		{
			alert("Costing has more than one invoice \n Can't Cancel invoice and costing");
			return false;
		}
		else
		{		
			var url = "costworksheetrevisedb.php?RequestType=cancleInvandCost&invNo="+URLEncode(invNo)+"&orderNo="+orderNo+"&reason="+URLEncode(reason);
			var htmlobj = $.ajax({url:url,async:false});
			if(htmlobj.responseText == "true")
			{
				alert("cancel Successfully.");
				window.location.href='costworksheetrevise.php';
			}
			else
			{
				alert("Error in cancel.");
				return;
			}
		}
	}
	if(document.getElementById("rdoRevise4").checked=="1")
	{
		var url = "costworksheetrevisedb.php?RequestType=cancleInvOnly&invNo="+URLEncode(invNo)+"&orderNo="+orderNo+"&reason="+URLEncode(reason);
		var htmlobj = $.ajax({url:url,async:false});
		if(htmlobj.responseText == "true")
		{
			alert("cancel Successfully.");
			window.location.href='costworksheetrevise.php';
		}
		else
		{
			alert("Error in cancel.");
			return;
		}
	}
		
}
function validateSave()
{
	if(document.getElementById("txtFSNo").value=="")
	{
		alert("Please enter a Invoice No.");
		document.getElementById("txtFSNo").focus();
		return;
	}
	if(document.getElementById("cboOrderNo").value=="")
	{
		alert("Please select a Order No.");
		document.getElementById("cboOrderNo").focus();
		return;
	}
	if(document.getElementById("txtReviseReason").value=="")
	{
		alert("Please enter a revise reason.");
		document.getElementById("txtReviseReason").focus();
		return;
	}
	return true;
}
function clearPage()
{
	document.frmRevision.reset();
	document.getElementById('cboOrderNo').innerHTML = "<option value=\"\"></option>";
	document.getElementById('cboColor').innerHTML = "<option value=\"\"></option>";
}
function loadCancleData()
{
	var url     = "costworksheetrevisedb.php?RequestType=loadCancleData";
	var htmlobj = $.ajax({url:url,async:false});
	ClearTable('tbldivtab3');
	
	var XMLOrderNo 			  = htmlobj.responseXML.getElementsByTagName("OrderNo");
	var XMLColor  			  = htmlobj.responseXML.getElementsByTagName("Color");
	var XMLCanceledDate 	  = htmlobj.responseXML.getElementsByTagName("CanceledDate");
	var XMLCanceledReason 	  = htmlobj.responseXML.getElementsByTagName("CanceledReason");
	var XMLInvoiceNo 		  = htmlobj.responseXML.getElementsByTagName("InvoiceNo");
	var XMLCancleBy			  = htmlobj.responseXML.getElementsByTagName("CancleBy");
	var i = 1;
	for(loop=0;loop<XMLOrderNo.length;loop++)
	{
		var OrderNo 		  = XMLOrderNo[loop].childNodes[0].nodeValue;
		var Color 		 	  = XMLColor[loop].childNodes[0].nodeValue;
		var CanceledDate 	  = XMLCanceledDate[loop].childNodes[0].nodeValue;
		var CanceledReason	  = XMLCanceledReason[loop].childNodes[0].nodeValue;
		var InvoiceNo 	 	  = XMLInvoiceNo[loop].childNodes[0].nodeValue;
		var CancleBy 		  = XMLCancleBy[loop].childNodes[0].nodeValue;
		
		createTab3Grid(OrderNo,Color,CanceledDate,CanceledReason,InvoiceNo,CancleBy,i);
		i++;
	}	
}
function createTab3Grid(OrderNo,Color,CanceledDate,CanceledReason,InvoiceNo,CancleBy,i)
{
	var tbl 	   = document.getElementById('tbldivtab3');

	var lastRow    = tbl.rows.length;	
	var row        = tbl.insertRow(lastRow);
	row.className  = "bcgcolor-tblrowWhite";
		
	var cell 	   = row.insertCell(0);
	cell.className ="normalfntMid";
	cell.nowrap    = "nowrap";
	cell.setAttribute('height','20');
	cell.id 	   = i;
	cell.innerHTML = i;
	
	var cell 	   = row.insertCell(1);
	cell.className ="normalfnt";
	cell.nowrap    = "nowrap";
	cell.innerHTML = InvoiceNo;
	
	var cell 	   = row.insertCell(2);
	cell.className ="normalfnt";
	cell.nowrap    = "nowrap";
	cell.innerHTML = OrderNo;
	
	var cell 	   = row.insertCell(3);
	cell.className ="normalfnt";
	cell.nowrap    = "nowrap";
	cell.innerHTML = Color;
	
	var cell 	   = row.insertCell(4);
	cell.className ="normalfnt";
	cell.nowrap    = "nowrap";
	cell.innerHTML = CanceledReason;
	
	var cell 	   = row.insertCell(5);
	cell.className ="normalfnt";
	cell.nowrap	   = "nowrap";
	cell.innerHTML = CancleBy;
	
	var cell       = row.insertCell(6);
	cell.className ="normalfnt";
	cell.nowrap    = "nowrap";
	cell.innerHTML = CanceledDate;
}
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}