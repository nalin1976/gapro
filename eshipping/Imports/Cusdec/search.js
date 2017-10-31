var xmlHttp2	= [];

function createXMLHttpRequest2(index){
    if (window.ActiveXObject) 
    {
        xmlHttp2[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp2[index] = new XMLHttpRequest();
    }
}

function SearchTab()
{
	var deliveryNo	 = document.getElementById('txtSearchDeliveryNo').value;
	var invoiceNo	 = document.getElementById('txtSearchInvoiceNo').value;
	var preDocs		 = document.getElementById('txtSearchPreDocs').value;
	var entryNo		 = document.getElementById('txtSearchEntryNo').value;
	var exporter 	 = document.getElementById('cboSearchExporter').value;
	var consignee	 = document.getElementById('cboSearchConsignee').value;
	var invoiceValue = document.getElementById('txtSearchInvoiceValue').value;
	var containerNo	 = document.getElementById('txtSearchContainerNo').value;
	
	createXMLHttpRequest2(1);
	xmlHttp2[1].onreadystatechange=SearchTabRequest;
	xmlHttp2[1].open("GET",'cusdecxml.php?RequestType=SearchDelivery&deliveryNo=' +deliveryNo+ '&invoiceNo=' +invoiceNo+ '&preDocs=' +preDocs+ '&entryNo=' +entryNo+ '&exporter=' +exporter+ '&consignee=' +consignee+ '&invoiceValue=' +invoiceValue+ '&containerNo=' +containerNo ,true);
	xmlHttp2[1].send(null);
}

function SearchTabRequest()
{
	if(xmlHttp2[1].readyState == 4 && xmlHttp2[1].status == 200)
	{
		RemoveAllRows('tblSearch');
		var tblSearch		= document.getElementById('tblSearch');
		var XMLDeliveryNo	= xmlHttp2[1].responseXML.getElementsByTagName('DeliveryNo');
		var XMLInvoiceNo	= xmlHttp2[1].responseXML.getElementsByTagName('InvoiceNo');
		var XMLCreateDate	= xmlHttp2[1].responseXML.getElementsByTagName('CreateDate');
		var XMLExporter		= xmlHttp2[1].responseXML.getElementsByTagName('Exporter');
		var XMLCustomer		= xmlHttp2[1].responseXML.getElementsByTagName('Customer');
		var XMLTotalAmount	= xmlHttp2[1].responseXML.getElementsByTagName('TotalAmount');
		var XMLPrevDoc		= xmlHttp2[1].responseXML.getElementsByTagName('PrevDoc');
		
		for(var loop=0;loop<XMLDeliveryNo.length;loop++)
			{
				var lastRow 		= tblSearch.rows.length;	
				var row 			= tblSearch.insertRow(lastRow);
				
				if(loop % 2 ==0)
					row.className ="bcgcolor-tblrowWhite";
				else
					row.className ="bcgcolor-tblrow";			
				
				row.onclick	= rowclickColorChangeIou;
				
				var cell0 = row.insertCell(0); 
				cell0.className ="normalfntMid";	
				cell0.innerHTML = XMLDeliveryNo[loop].childNodes[0].nodeValue;
				
				var cell1 = row.insertCell(1);
				cell1.className ="normalfntMid";			
				cell1.innerHTML =XMLInvoiceNo[loop].childNodes[0].nodeValue;
				
				var cell2 = row.insertCell(2);
				cell2.className ="normalfntMid";
				cell2.innerHTML =XMLCreateDate[loop].childNodes[0].nodeValue;
				
				var cell3 = row.insertCell(3);
				cell3.className ="normalfnt";			
				cell3.innerHTML =XMLExporter[loop].childNodes[0].nodeValue;
				
				
				var cell4 = row.insertCell(4);
				cell4.className ="normalfnt";			
				cell4.innerHTML =XMLCustomer[loop].childNodes[0].nodeValue;
				
				
				var cell5 = row.insertCell(5);
				cell5.className ="normalfntRite";			
				cell5.innerHTML =XMLTotalAmount[loop].childNodes[0].nodeValue;
				
				var cell6 = row.insertCell(6);
				cell6.className ="normalfntMid";			
				cell6.innerHTML =XMLPrevDoc[loop].childNodes[0].nodeValue;				
			}
	}
}