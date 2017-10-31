// JavaScript Document
function setDefaultDateofFinder()
{
	var d=new Date();
	var day=d.getDate();
	day=day+''
	if(day.length==1)
	{
		day="0" + day
	}
	var month=d.getMonth() + 1;
	month=month+''
	if(month.length==1)
	{
		month="0" + month
	}
	var year=d.getFullYear();
	
	var ddate=(year + "/" + month + "/" + day);
	//document.getElementById("txtDateFrom").value=ddate
	//document.getElementById("txtDateTo").value=ddate	
}

function fillAvailableAdvData()
{	
	strPaymentType=document.getElementById("cboPaymentType").value.trim();

	var supID=document.getElementById("cboSuppliers").value;
	var dateFrom=document.getElementById("txtDateFrom").value;
	var dateTo=document.getElementById("txtDateTo").value;
	var po=document.getElementById('txtPoNo').value.trim();
	var poNo=po.split('/')[1];
	var poYear=po.split('/')[0];
	var url='advancePaymentListDB.php?DBOprType=findAdvData&strPaymentType=' + strPaymentType + '&supID=' + supID + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo+'&poNo='+poNo+'&poYear='+poYear;
	htmlobj=$.ajax({url:url,async:false});
	var XMLPaymentNo = htmlobj.responseXML.getElementsByTagName("PaymentNo");
			var XMLDate = htmlobj.responseXML.getElementsByTagName("paydate");
			var XMLAmount = htmlobj.responseXML.getElementsByTagName("poamount");
			var XMLTaxAmount = htmlobj.responseXML.getElementsByTagName("taxamount");
			var XMLTotalAmount = htmlobj.responseXML.getElementsByTagName("totalamount");
			var XMLPOno = htmlobj.responseXML.getElementsByTagName("POno");
			var XMLPOYear = htmlobj.responseXML.getElementsByTagName("POYear");

			
			var strData=""
				
			for ( var loop = 0; loop < XMLPaymentNo.length; loop ++)
			 {
				var advNo 	= XMLPaymentNo[loop].childNodes[0].nodeValue;
				var datex 	= XMLDate[loop].childNodes[0].nodeValue;
				var amt 	= XMLAmount[loop].childNodes[0].nodeValue;
				var taxAmt 	= XMLTaxAmount[loop].childNodes[0].nodeValue;
				var totAmt	= XMLTotalAmount[loop].childNodes[0].nodeValue;
				/*var POno	= XMLPOno[loop].childNodes[0].nodeValue;
				var POYear	= XMLPOYear[loop].childNodes[0].nodeValue;*/
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strData+="<tr>"+
				/*"<td class=\""+cls+"\" style=\"text-align:left\">&nbsp;"+POYear+"/"+POno+"</td>"+*/
				"<td class=\""+cls+"\"  onmouseover=\"highlight(this.parentNode)\">" + advNo + "</td>"+
				"<td class=\""+cls+"\"  onmouseover=\"highlight(this.parentNode)\">" + datex + "</td>"+
				"<td class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + amt + "</td>"+
				"<td class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + taxAmt + "</td>"+
				"<td class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + totAmt + "</td>"+
				"<td class=\""+cls+"\"><div align=\"center\" onmouseover=\"highlight(this.parentNode)\"><img src=\"../../images/butt_1.png\" width=\"15\" height=\"15\" onclick=\"previewReport(this)\"/></div></td>"+
				"</tr>"	
			 }
			 strData+="</table>"
	document.getElementById("tblAdvData").tBodies[0].innerHTML=strData;
}

function showAnalizeData()
{	

		var type = '';
	
	if(document.getElementById("style").checked)
		type = 'S';
	else if(document.getElementById("Genaral").checked)
		type = 'G';
	else if(document.getElementById("Bulk").checked)
		type = 'B';

		
	strPaymentType=document.getElementById("cboPaymentType").value.trim();

	var supID=document.getElementById("cboSuppliers").value;
	var dateFrom=document.getElementById("txtDateFrom").value;
	var dateTo=document.getElementById("txtDateTo").value;
    
	var url='advancePayment/advancePaymentListDB.php?DBOprType=showAnalizeData&strPaymentType=' + strPaymentType + '&supID=' + supID + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&type=' + type;
	htmlobj=$.ajax({url:url,async:false});
			
			
			var XMLSupplier = htmlobj.responseXML.getElementsByTagName("strTitle");
			var XMLPOno = htmlobj.responseXML.getElementsByTagName("POno");
			var XMLPayDate = htmlobj.responseXML.getElementsByTagName("PayDate");
			var XMLpaidAmount = htmlobj.responseXML.getElementsByTagName("paidAmount");
			var XMLPaymentNo = htmlobj.responseXML.getElementsByTagName("PaymentNo");
			var XMLAdvanceSettled = htmlobj.responseXML.getElementsByTagName("AdvanceSettled");
			var XMLCurrency = htmlobj.responseXML.getElementsByTagName("Currency");
			var XMLCurID = htmlobj.responseXML.getElementsByTagName("CurID");
			var XMLrate = htmlobj.responseXML.getElementsByTagName("rate");
			
			
			//for GRN VALUE
			var XMLExcessQty = htmlobj.responseXML.getElementsByTagName("ExcessQty");
			var XMLdblQty = htmlobj.responseXML.getElementsByTagName("dblQty");
			var XMLPoPrice = htmlobj.responseXML.getElementsByTagName("PoPrice");
			
			//var XMLPOYear = htmlobj.responseXML.getElementsByTagName("POYear");
			
			 
			var strAdData="<table id=\"tblAdvData\" height=\"298\" width=\"945\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bordercolor=\"#162350\" bgcolor=\"#FFFFFF\" >"+
             "<thead>"+
			 "<tr>"+
                "<td width=\"26%\" height=\"25\" class=\"grid_header\">Supplier</td>"+
                "<td width=\"7%\" class=\"grid_header\">PO No</td>"+
                 "<td width=\"8%\" bgcolor=\"\" class=\"grid_header\">Payment No </td>"+
				"<td width=\"15%\" class=\"grid_header\">Date </td>"+
				"<td width=\"5%\" bgcolor=\"\" class=\"grid_header\">Currency</td>"+
                "<td width=\"10%\" class=\"grid_header\">Advance Amount</td>"+
				
                "<td width=\"9%\" class=\"grid_header\">GRN Value</td>"+
                "<td width=\"8%\" class=\"grid_header\">To be received Value</td>"+
               "<td width=\"9%\" class=\"grid_header\">Advance settled</td>"+
			   "<td width=\"2%\" class=\"grid_header\">&nbsp;</td>"+
              "</tr>"+
             
			
            "</thead>";
		
			
			var tot_1	=	0;	
			var tot_2 = 0;
			var tot_3 = 0;
			var tot_4 = 0;
			strAdData+="<tbody style=\"overflow: -moz-scrollbars-vertical;height:298px\">";	
			for ( var loop = 0; loop < XMLPaymentNo.length; loop ++)
			 {
				var Supplier 	= XMLSupplier[loop].childNodes[0].nodeValue;
				var POno 	= XMLPOno[loop].childNodes[0].nodeValue;
				var PayDate 	= XMLPayDate[loop].childNodes[0].nodeValue;
				var AdvanceAmount 	= XMLpaidAmount[loop].childNodes[0].nodeValue;
				var PaymentNo	= XMLPaymentNo[loop].childNodes[0].nodeValue;
				var AdvanceSettled	= XMLAdvanceSettled[loop].childNodes[0].nodeValue;
				var currency = XMLCurrency[loop].childNodes[0].nodeValue;
				var CurID = XMLCurID[loop].childNodes[0].nodeValue;
				var rate = XMLrate[loop].childNodes[0].nodeValue;
				//TO GRN VALUE
				var ExcessQty 	= XMLExcessQty[loop].childNodes[0].nodeValue;
				var dblQty 	= XMLdblQty[loop].childNodes[0].nodeValue;
				var PoPrice	= XMLPoPrice[loop].childNodes[0].nodeValue;
						
				var ReceivedValue=0;
				
				var grnValue= dblQty*PoPrice;
				
				if(AdvanceAmount<grnValue){
				 ReceivedValue=0;
				}
				else {
					ReceivedValue=AdvanceAmount-grnValue;
				}
				
				
				var txtcurrency=document.getElementById("txtcurrency").value;
				
				if( document.getElementById("cboCurrencyTo").value !=0)
				{ 				
				
					if ( CurID != document.getElementById("cboCurrencyTo").value)
					{
						//alert(AdvanceAmount);alert(rate);alert(txtcurrency);
						var ConAdvanceAmount = (AdvanceAmount / rate) * (txtcurrency);
						var CongrnValue=(grnValue / rate) * (txtcurrency);
						var ConReceivedValue=(ReceivedValue / rate) * (txtcurrency);
						var ConAdvanceSettled=(AdvanceSettled / rate) * (txtcurrency);
						//alert(ConAdvanceAmount);
					}
					else 
					{
					var ConAdvanceAmount=AdvanceAmount;
					var CongrnValue=grnValue ;
					var ConReceivedValue=ReceivedValue ;
					var ConAdvanceSettled=AdvanceSettled;
							
					}
				}
				else{
					var ConAdvanceAmount=AdvanceAmount;
					var CongrnValue=grnValue ;
					var ConReceivedValue=ReceivedValue ;
					var ConAdvanceSettled=AdvanceSettled;
				}
				
				if( ConAdvanceSettled='NaN')
				{
					ConAdvanceSettled="0.00";
				}
				
				
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strAdData+=
				"<tr>"+
				/*"<td class=\""+cls+"\" style=\"text-align:left\">&nbsp;"+POYear+"/"+POno+"</td>"+*/
				"<td height=\"15\" id=\""+CurID+"\" width=\"20%\"  class=\""+cls+"\"  onmouseover=\"highlight(this.parentNode)\" style='text-align:left'>" + Supplier + "</td>"+
				"<td height=\"15\" class=\""+cls+"\"  onmouseover=\"highlight(this.parentNode)\">" + POno + "</td>"+
				"<td height=\"15\" class=\""+cls+"\"  onmouseover=\"highlight(this.parentNode)\">" + PaymentNo + "</td>"+
				"<td height=\"15\" class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + PayDate + "</td>"+			"<td height=\"20\" class=\""+cls+"\"  onmouseover=\"highlight(this.parentNode)\">" + currency + "</td>"+
				"<td height=\"15\" class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + parseFloat(ConAdvanceAmount).toFixed(2) + "</td>"+
								"<td height=\"20\" class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + parseFloat(CongrnValue).toFixed(2) + "</td>"+
				"<td height=\"15\" class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + parseFloat(ConReceivedValue).toFixed(2) + "</td>"+
				"<td height=\"15\" class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + parseFloat(ConAdvanceSettled).toFixed(2) + "</td>"
			 "</tr>"+"</tbody>"
			      
			 tot_1+= parseInt(ConAdvanceAmount);
			 tot_2+= parseInt(CongrnValue);
			 tot_3+= parseInt(ConReceivedValue);
			 tot_4+=parseInt(ConAdvanceSettled);
				
			 
			 }
			 
			 if(XMLPaymentNo.length<12)
			 {
				 while(loop<9)
				 {
					 loop++;
					 strAdData+="<tr>"+
				"<td>&nbsp;</td>"+
				"<td>&nbsp;</td>"+
				"<td>&nbsp;</td>"+
				"<td>&nbsp;</td>"+
				"<td>&nbsp;</td>"+
				"<td>&nbsp;</td>"+
				"<td>&nbsp;</td>"+
				"</tr>";
				 }
				
			 }
			 strAdData+="</table>"
			 
			 
			 
			 
	
	document.getElementById("tblAdvData").tBodies[0].innerHTML=strAdData;
	
	var footTotal="";
	footTotal+="<table>"+
	     "<tr>"+
		 "<td colspan=\"5\">"+
		 
				"<table id=\"tblAdvData\" width=\"945\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#162350\">"+
				  "<tr>"+
				  "<td width=\"61%\" height=\"25\" bgcolor=\"\" class=\"grid_header\">Total</td>"+
				   " <td width=\"10%\" bgcolor=\"\" class=\"grid_header\">"+ tot_1 +"</td>"+
					"<td width=\"9%\" bgcolor=\"\" class=\"grid_header\">"+ tot_2+"</td>"+
					"<td width=\"9%\" bgcolor=\"\" class=\"grid_header\">"+ tot_3 +"</td>"+
					"<td width=\"10%\" bgcolor=\"\" class=\"grid_header\">"+ tot_4 +"</td>"+
					"</tr>"+
					"</table>"+
			
			"</td>"+	
	"</tr>"
	footTotal+="</table>"
	
	document.getElementById("footTotal").tBodies[0].innerHTML=footTotal;
/*	"<table>"+
	     "<tr>"+
		 "<td colspan=\"10\">"+
		  "<div class=\"bcgl1\" id=\"divAdvData\">"
				+"<table id=\"tblAdvData\" width=\"953\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bordercolor=\"#162350\">"+
				  "<tr>"+
				  "<td width=\"64%\" height=\"25\" bgcolor=\"\" class=\"grid_header\">Total</td>"+
				   " <td width=\"11%\" bgcolor=\"\" class=\"grid_header\">&nbsp;</td>"+
					"<td width=\"9%\" bgcolor=\"\" class=\"grid_header\">&nbsp;</td>"+
					"<td width=\"8%\" bgcolor=\"\" class=\"grid_header\">&nbsp;</td>"+
					"<td width=\"8%\" bgcolor=\"\" class=\"grid_header\">&nbsp;</td>"+
					"</tr>"+
					"</table>"+
			"</div>"+
			"</td>"+	
	"</tr>"+
	"</table>";*/
		
}

function highlight(o)
{
	var p = o.parentNode;
	
	while( p.tagName != "TABLE")
	{
		p=p.parentNode;
	}
	for( var i=0; i < p.rows.length; ++i)
	{
		p.rows[i].className="";
	}
	while(o.tagName !="TR")
	o=o.parentNode
	o.className="backcolorYellow";
}

function previewReport(obj)
{
	document.getElementById("cboPaymentType").value.trim();	
	var row=obj.parentNode.parentNode.parentNode
	var selectedAdvPaymentNo =  row.cells[0].innerHTML;
	window.open('rptAdvancePaymentReport.php?PayNo=' + selectedAdvPaymentNo + '&strPaymentType=' + strPaymentType,"form1")
}
function edDate(obj){
	if(obj.checked==true){
		document.getElementById('txtDateFrom').disabled=false;
		document.getElementById('txtDateTo').disabled=false;
		}
	else{
		document.getElementById('txtDateFrom').disabled=true;
		document.getElementById('txtDateTo').disabled=true;
		document.getElementById('txtDateFrom').value="";
		document.getElementById('txtDateTo').value="";
		
	}
}
function pageRefreshListing()
{
	document.getElementById("form1").submit();
}

function clearAdPay()
{
	
$("#form1")[0].reset();	
$("#tblAdvData tr:gt(0)").remove();
}



function loadCurrencyType()
{
	CreateXMLHttpForCurrency();
	xmlHttpCurrency.onreadystatechange = HandleCurrency;
    xmlHttpCurrency.open("GET", 'advancePayment/advancepaymentDB.php?DBOprType=getTypeOfCurrency', true);
	xmlHttpCurrency.send(null); 
}

function HandleCurrency()
{	
	if(xmlHttpCurrency.readyState == 4) 
    {
	   if(xmlHttpCurrency.status == 200) 
        {  
			var XMLCurrType = xmlHttpCurrency.responseXML.getElementsByTagName("currType");
			var XMLCurrRate = xmlHttpCurrency.responseXML.getElementsByTagName("currRate");
			
			clearSelectControl("cboCurrencyTo");
			
			var optFirst = document.createElement("option");			
			optFirst.text = "";
			optFirst.value = 0;
			
			document.getElementById("cboCurrencyTo").options.add(optFirst);
				
			for ( var loop = 0; loop < XMLCurrType.length; loop ++)
			 {
				var currType = XMLCurrType[loop].childNodes[0].nodeValue;
				var currRate = XMLCurrRate[loop].childNodes[0].nodeValue;
				
				var optCurr = document.createElement("option");
				optCurr.text =currType ;
				optCurr.value = currType;
				//optCurr.value = currRate;
				
				document.getElementById("cboCurrencyTo").options.add(optCurr);
			 }
			 //document.getElementById("cboCurrencyTo").value=0;
		}
	}
}
function loadcurrency(){
	
  
			  var curID=document.getElementById('cboCurrencyTo').value.trim();
	
		var path = "advancePayment/advancePaymentListDB.php?DBOprType=dbloadcurr";
			path += "&curID="+curID;
	
		htmlobj=$.ajax({url:path,async:false});	
		
		var XMLExrate	=htmlobj.responseXML.getElementsByTagName("Exrate");
		//alert(XMLExrate[0].childNodes[0].nodeValue);
		if(XMLExrate.length > 0){
		  document.getElementById("txtcurrency").value=XMLExrate[0].childNodes[0].nodeValue;
		
					}
}
		

