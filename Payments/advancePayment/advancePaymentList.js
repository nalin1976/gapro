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