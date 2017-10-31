//updated from roshan 2009-10-12
var xmlHttp;
var altxmlHttp;
var altxmlHttpArray = [];
	
var incr =0;
var strPaymentType="";

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function createAltXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        altxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttp = new XMLHttpRequest();
    }
}

function createAltXMLHttpRequestArray(index) 
{
    if (window.ActiveXObject) 
    {
        altxmlHttpArray[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttpArray[index] = new XMLHttpRequest();
    }
}

function LoadSupplier()
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleLoadSupplier;
	xmlHttp.open("GET",'supplierInvFinderXML.php?RequestType=LoadSupplier',true);
	xmlHttp.send(null);
}
function actInAct(obj){
	if(obj.checked==true){
		document.getElementById('txtDateFrom').disabled=false;
		document.getElementById('txtDateTo').disabled=false;
		document.getElementById('txtDateFrom').style.backgroundColor = '#FFF';
		document.getElementById('txtDateTo').style.backgroundColor = '#FFF';
	}
	else
	{
		document.getElementById('txtDateFrom').disabled=true;
		document.getElementById('txtDateTo').disabled=true;
		document.getElementById('txtDateFrom').style.backgroundColor = '#CCC';
		document.getElementById('txtDateTo').style.backgroundColor = '#CCC';
		document.getElementById('txtDateTo').value="";
		document.getElementById('txtDateFrom').value="";
	}
}
function HandleLoadSupplier()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var XMLSupId = xmlHttp.responseXML.getElementsByTagName("SupId");
			var XMLSupNm = xmlHttp.responseXML.getElementsByTagName("SupNm");

			RemoveCurrentCombo("cbosupplier");
			var opt = document.createElement("option");
			opt.text = "";	
			opt.value = "0";
			document.getElementById("cbosupplier").options.add(opt);
			
			for ( var loop = 0; loop < XMLSupId.length; loop ++)
			{
				var opt = document.createElement("option");
				opt.text = XMLSupNm[loop].childNodes[0].nodeValue;
				opt.value = XMLSupId[loop].childNodes[0].nodeValue;
				document.getElementById("cbosupplier").options.add(opt);
			}
		}		
	}
}

function InitializeInvoiceFinder()
{
	//LoadSupplier();
}

//Clear ListBox
function RemoveCurrentCombo(comboname)
{
	var index = document.getElementById(comboname).options.length;
	while(document.getElementById(comboname).options.length > 0) 
	{
		index --;
		document.getElementById(comboname).options[index] = null;
	}
}

function SearchInvoices()
{
	strPaymentType=document.getElementById("cboPymentType").value
	
	var invNo = document.getElementById("txtinvoiceno").value;
	
	/*if (document.getElementById('cbosupplier').options.selectedIndex != 0)
	{
		var supCurIndex = document.getElementById('cbosupplier').options.selectedIndex;
		var supId = document.getElementById("cbosupplier").options[supCurIndex].value;
	}*/
	var supId=document.getElementById('cbosupplier').value.trim();
	var fDate = document.getElementById("txtDateFrom").value;
	var tDate = document.getElementById("txtDateTo").value;
	
	var paid = document.getElementById("paid").checked;
	var unPaid = document.getElementById("unpaid").checked;
	var entryNo= document.getElementById('txtEntryNo').value.trim();
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleSearchInvoices;
	var url='supplierInvFinderXML.php?RequestType=SearchInvoices&strPaymentType=' + strPaymentType + '&InvoiceNo=' + invNo + '&SupplierId=' + supId + '&FromDt=' + fDate + '&ToDt=' + tDate + '&Paid=' + paid + '&UnPaid=' + unPaid+'&entryNo='+entryNo;
	//alert(url);
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function HandleSearchInvoices()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var XMLInvoiceNo = xmlHttp.responseXML.getElementsByTagName("InvoiceNo");
			var XMLSupplier = xmlHttp.responseXML.getElementsByTagName("Supplier");
			var XMLInvoiceDate = xmlHttp.responseXML.getElementsByTagName("InvoiceDate");
			var XMLInvoiceAmt = xmlHttp.responseXML.getElementsByTagName("InvoiceAmt");
			var XMLPaidAmt = xmlHttp.responseXML.getElementsByTagName("PaidAmt");
			var XMLBalanceAmt = xmlHttp.responseXML.getElementsByTagName("BalanceAmt");
			var XMLSupplierId = xmlHttp.responseXML.getElementsByTagName("SupplierId");
			
			var tableText = "<table id=\"tblinvdata\" width=\"950\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >" +
            				"<tr>"+
              				"<td width=\"16%\" height=\"22\" bgcolor=\"#498CC2\" class=\"grid_header\">Invoice No </td>"+
              				"<td width=\"16%\" bgcolor=\"#498CC2\" class=\"grid_header\">Supplier</td>"+
              				"<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Date </td>"+
              				"<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>"+
              				"<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Paid</td>"+
              				"<td width=\"14%\" bgcolor=\"#498CC2\" class=\"grid_header\">Balance</td>"+
			  				"<td width=\"14%\" bgcolor=\"#498CC2\" class=\"grid_header\">View</td>"+
            				"</tr>";
			//alert(XMLInvoiceNo.length);
			if (XMLInvoiceNo.length == 0)
				alert("There are no records to view !");
			
			for ( var loop = 0; loop < XMLInvoiceNo.length; loop ++)
			{
				var invDate = XMLInvoiceDate[loop].childNodes[0].nodeValue;
				invDate = invDate.substr(0,10);
				var cls;
				(loop % 2==1)?cls="grid_raw":cls="grid_raw2";
				tableText += "<tr class='"+cls+"'>"+
              				"<td class=\""+cls+"\" style=\"text-align:left;\">" + XMLInvoiceNo[loop].childNodes[0].nodeValue +"</td>"+
              				"<td class=\""+cls+"\" id=\""+ XMLSupplierId[loop].childNodes[0].nodeValue +"\"style=\"text-align:left;\">" + XMLSupplier[loop].childNodes[0].nodeValue +"</td>"+
              				"<td class=\""+cls+"\">" + invDate +" </td>"+
              				"<td class=\""+cls+"\" style=\"text-align:right;\">" + XMLInvoiceAmt[loop].childNodes[0].nodeValue +"</td>"+
              				"<td class=\""+cls+"\" style=\"text-align:right;\">" + XMLPaidAmt[loop].childNodes[0].nodeValue +"</td>"+
              				"<td class=\""+cls+"\" style=\"text-align:right;\">" + XMLBalanceAmt[loop].childNodes[0].nodeValue +"</td>"+
			  				"<td class=\""+cls+"\"><a href=\"supplierInv.php?InvoiceNo=" + XMLInvoiceNo[loop].childNodes[0].nodeValue + "&SupplierId=" + XMLSupplierId[loop].childNodes[0].nodeValue + "\"><img src=\"../images/view2.png\" border='0'/></a></td>"+
            				"</tr>";
			}
			tableText += "</table>";
			document.getElementById("divinvData").innerHTML = tableText;
		}		
	}
}