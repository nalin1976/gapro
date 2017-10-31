// JavaScript Document

$(document).ready(function() 
{
		
		var url					='search-db.php?id=load_po_no';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtPONo" ).autocomplete({
			source: pub_po_arr
		});

  

});



function validateData()
{
	var plNo=document.getElementById('cboPLNo').value;
	var poNo=document.getElementById('txtPONo').value;
	var buyerCode=document.getElementById('cboBuyer').value;
	var dateFrom=document.getElementById('txtFromDate').value;
	var dateTo=document.getElementById('txtToDate').value;
	
	if(plNo=='' && poNo=='' && buyerCode=='' && dateFrom=='' && dateTo=='')
		alert("Please select or enter a value");
	else
		beginSearch();
}


function beginSearch()
{
	var plNo=document.getElementById('cboPLNo').value;
	var poNo=document.getElementById('txtPONo').value;
	var buyerCode=document.getElementById('cboBuyer').value;
	
	var buyerName=$("#cboBuyer option:selected").text();
	var dateFrom=document.getElementById('txtFromDate').value;
	var dateTo=document.getElementById('txtToDate').value;
	var tblDispatchDetails=document.getElementById('tblDispatchDetails');
	
	if(tblDispatchDetails.rows.length>1)
	{
		//alert(tblDispatchDetails.rows.length);
		for(var x=tblDispatchDetails.rows.length;x>1;x--)
		{
			tblDispatchDetails.deleteRow(x-1);
		}
	}
	
	
	var url="search-db.php?id=beginSearch";
		url+="&plNo="+plNo;
		url+="&poNo="+poNo;
		url+="&buyerCode="+buyerCode;
		url+="&dateFrom="+dateFrom;
		url+="&dateTo="+dateTo;
	
	var xmlhttp_obj= $.ajax({url:url,async:false});
	
	var XMLDispatchNo    = xmlhttp_obj.responseXML.getElementsByTagName("DispatchNo");
	var XMLDispatchDate  = xmlhttp_obj.responseXML.getElementsByTagName("DispatchDate");
	var XMLBuyerId	 = xmlhttp_obj.responseXML.getElementsByTagName("BuyerId");
	var XMLBuyerName	 = xmlhttp_obj.responseXML.getElementsByTagName("BuyerName");
	var XMLBuyerCode	 = xmlhttp_obj.responseXML.getElementsByTagName("BuyerCode");
	
	for(var x=0;x<XMLDispatchNo.length;x++)
	{	
		var newRow			  = tblDispatchDetails.insertRow(x+1);
		newRow.className ="bcgcolor-tblrow";
		
		var newCellDispatchNo       = tblDispatchDetails.rows[x+1].insertCell(0);
		//newCellDispatchNo.width="4%";
		newCellDispatchNo.align="center";
		newCellDispatchNo.innerHTML = XMLDispatchNo[x].childNodes[0].nodeValue;
		
		
		var newCellDispatchDate        = tblDispatchDetails.rows[x+1].insertCell(1);
		//newCellDispatchDate.width="14%";
		newCellDispatchDate.align="center";
		newCellDispatchDate.innerHTML  =  XMLDispatchDate[x].childNodes[0].nodeValue;
		
		
		var newBuyerName            = tblDispatchDetails.rows[x+1].insertCell(2);
		//newCellStyle.width="15%";
		newBuyerName.id=XMLBuyerId[x].childNodes[0].nodeValue;
		newBuyerName.align="center";
		newBuyerName.innerHTML    = XMLBuyerName[x].childNodes[0].nodeValue+"-->"+XMLBuyerCode[x].childNodes[0].nodeValue;
		
		var newCellReport        = tblDispatchDetails.rows[x+1].insertCell(3);
		//newCellReport.width="15%";
		newCellReport.align="center";
		newCellReport.innerHTML  = "<img src=\"../../../images/report.png\" id=\""+(x+1)+"\" onclick=\"loadDispatchNoteReport(this);\" class=\"mouseover\" />";
		
		var newCellView       = tblDispatchDetails.rows[x+1].insertCell(4);
		//newCellView.width="12%";
		newCellView.align="center";
		newCellView.innerHTML  = "<img src=\"../../../images/view.png\" id=\""+(x+1)+"\" onclick=\"loadDispatchNoteScreen(this);\" class=\"mouseover\"/>";;
	}
	
}

function loadDispatchNoteScreen(obj)
{
	var rowIndex=obj.id;
	var dispatchNo=document.getElementById('tblDispatchDetails').rows[rowIndex].cells[0].innerHTML;
	var dispatchDate=document.getElementById('tblDispatchDetails').rows[rowIndex].cells[1].innerHTML;
	var buyerCode=document.getElementById('tblDispatchDetails').rows[rowIndex].cells[2].id;
	//alert(buyerCode);
	//var buyerCode=document.getElementById('cboBuyer').value;
	window.open("../Details/DispathNote.php?dispatchNo="+dispatchNo);	
}

function loadDispatchNoteReport(obj)
{
	var rowIndex=obj.id;
	var dispatchNo=document.getElementById('tblDispatchDetails').rows[rowIndex].cells[0].innerHTML;
	window.open("../Details/DispathNoteReport.php?dispatchNo="+dispatchNo);	
}



function deleteRows()
{
	var tblDispatchDetails=document.getElementById('tblDispatchDetails');
	if(tblDispatchDetails.rows.length>1)
	{
		//alert(tblDispatchDetails.rows.length);
		for(var x=tblDispatchDetails.rows.length;x>1;x--)
		{
			tblDispatchDetails.deleteRow(x-1);
		}
	}
}