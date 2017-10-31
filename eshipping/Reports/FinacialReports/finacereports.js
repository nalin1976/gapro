function CheckAll(obj,id)
{
	var tbl = document.getElementById('tblMain'+id);
	
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].checked = (obj.checked ? true:false);
	}
}

function viewReport(type)
{
	if(type==1)
	{
		var tbl = document.getElementById('tblMain'+type);
		var booFirst	= true;
		var buyerId		= ""; 
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				if(booFirst)
					buyerId = tbl.rows[loop].cells[1].id;
				else
					buyerId += ','+tbl.rows[loop].cells[1].id;
					
				booFirst	= false;
			}
		}			
		var url  = "reports/rptBuyerwiseExportsDetaile.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+buyerId
		window.open(url,'rptBuyerwiseExportsDetail.php');
	}
	if(type==2)
	{
		var tbl = document.getElementById('tblMain'+type);
		var booFirst	= true;
		var buyerId		= "";
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				if(booFirst)
					buyerId = tbl.rows[loop].cells[1].id;
				else
					buyerId += ','+tbl.rows[loop].cells[1].id;
					
				booFirst	= false;
			}
		}			
		var url  = "reports/rptBuyerwiseExportsSummary.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+buyerId
		window.open(url,'rptBuyerwiseExportsSummary.php');
	}
	if(type==3)
	{
		var tbl 		= document.getElementById('tblMain'+type);
		var booFirst	= true;
		var location	= "";
		
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				if(booFirst)
					location = tbl.rows[loop].cells[1].id;
				else
					location += ','+tbl.rows[loop].cells[1].id;
					
				booFirst	= false;
			}
		}
		
		var url  = "reports/rptFactorywiseExportsDetailed.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&Location="+location;
		window.open(url,'rptFactorywiseExportsDetailed.php');
	}
	if(type==4)
	{
		//alert("hi");
		var tbl 		= document.getElementById('tblMain'+type);
		var booFirst	= true;
		var location	= "";
		
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				if(booFirst)
					location = tbl.rows[loop].cells[1].id;
				else
					location += ','+tbl.rows[loop].cells[1].id;
					
				booFirst	= false;
			}
		}
		
		var url  = "reports/rptFacExSumBuy.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&locationId="+location;
		window.open(url,'rptFacExSumBuy.php');
	}
	if(type==5)
	{
		var tbl 		= document.getElementById('tblMain'+type);
		var booFirst	= true;
		var location	= "";
		
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				if(booFirst)
					location = tbl.rows[loop].cells[1].id;
				else
					location += ','+tbl.rows[loop].cells[1].id;
					
				booFirst	= false;
			}
		}
		
		var url  = "reports/rptFactorywiseExportsSummary.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&Location="+location;
		window.open(url,'rptFactorywiseExportsSummary.php');
	}
	if(type==6)
	{
		var url  = "reports/rptDestinationwiseExports.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+document.getElementById('cboBuyer'+type).value;
		window.open(url,'rptDestinationwiseExports.php');
	}
	if(type==7)
	{
		var url  = "reports/rptExportsReceivableSummary.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+document.getElementById('cboBuyer'+type).value;
			url += "&Currency="+document.getElementById('cboCurrency'+type).value;			
		window.open(url,'rptExportsReceivableSummary.php');
	}
	if(type==8)
	{
		var tbl = document.getElementById('tblMain'+type);
		var booFirst	= true;
		var buyerId		= "";
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				if(booFirst)
					buyerId = tbl.rows[loop].cells[1].id;
				else
					buyerId += ','+tbl.rows[loop].cells[1].id;
					
				booFirst	= false;
			}
		}
		
		var url  = "reports/rptExportsReceivableDetailed.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+buyerId;
		window.open(url,'rptExportsReceivableDetailed.php');
	}
	if(type==9)
	{
		var url  = "reports/rptCustomsInvoiceRegister.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+document.getElementById('cboBuyer'+type).value;
			//url += "&InvoNoFrom="+document.getElementById('txtInvoNoFrom'+type).value.trim();
			//url += "&InvoNoTo="+document.getElementById('txtInvoNoTo'+type).value.trim();
			
		window.open(url,'rptCustomsInvoiceRegister.php');
	}
	if(type==17)
	{
		var url  = "reports/rptPendingCustomInvoiceRegister.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+document.getElementById('cboBuyer'+type).value;
			//url += "&InvoNoFrom="+document.getElementById('txtInvoNoFrom'+type).value.trim();
			//url += "&InvoNoTo="+document.getElementById('txtInvoNoTo'+type).value.trim();
			
		window.open(url,'rptPendingCustomInvoiceRegister.php');
	}
	if(type==18)
	{
		var url  = "reports/cdnRegister.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+document.getElementById('cboBuyer'+type).value;
			//url += "&InvoNoFrom="+document.getElementById('txtInvoNoFrom'+type).value.trim();
			//url += "&InvoNoTo="+document.getElementById('txtInvoNoTo'+type).value.trim();
			
		window.open(url,'cdnRegister.php');
	}
	if(type==1)
	{
		var url  = "reports/rptPendingCustomInvoiceRegister.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+document.getElementById('cboBuyer'+type).value;
			//url += "&InvoNoFrom="+document.getElementById('txtInvoNoFrom'+type).value.trim();
			//url += "&InvoNoTo="+document.getElementById('txtInvoNoTo'+type).value.trim();
			
		window.open(url,'rptPendingCustomInvoiceRegister.php');
	}
	if(type==10)
	{
		var url  = "reports/rptFinalInvRegister.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			
			//url += "&InvoNoFrom="+document.getElementById('txtInvoNoFrom'+type).value.trim();
			//url += "&InvoNoTo="+document.getElementById('txtInvoNoTo'+type).value.trim();
			
		window.open(url,'rptFinalInvRegister.php');
	}
	if(type==11)
	{
		var url  = "reports/rptPendingFinalInvoiceListing.php?";
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			//url += "&InvoNoFrom="+document.getElementById('txtInvoNoFrom'+type).value.trim();
			//url += "&InvoNoTo="+document.getElementById('txtInvoNoTo'+type).value.trim();
			
		window.open(url,'rptPendingFinalInvoiceListing.php');
	}
	if(type==12)
	{
		var tbl = document.getElementById('tblMain'+type);
		var booFirst	= true;
		var buyerId		= "";
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				if(booFirst)
					buyerId = tbl.rows[loop].cells[1].id;
				else
					buyerId += ','+tbl.rows[loop].cells[1].id;
					
				booFirst	= false;
			}
		}
		
		var url  = "reports/rptBankLetterRegister.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+buyerId;
		window.open(url,'rptBankLetterRegister.php');
	}
	
	if(type==19)
	{
		var tbl = document.getElementById('tblMain'+type);
		var booFirst	= true;
		var buyerId		= "";
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				if(booFirst)
					buyerId = tbl.rows[loop].cells[1].id;
				else
					buyerId += ','+tbl.rows[loop].cells[1].id;
					
				booFirst	= false;
			}
		}
		
		var url  = "reports/rptDiscountedBillsRegiter.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+buyerId;
		window.open(url,'rptDiscountedBillsRegiter.php');
	}
	if(type==13)
	{
		var url  = "reports/rptPendingBankLetterInvoices.php?";
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			//url += "&InvoNoFrom="+document.getElementById('txtInvoNoFrom'+type).value.trim();
			//url += "&InvoNoTo="+document.getElementById('txtInvoNoTo'+type).value.trim();
			
		window.open(url,'rptPendingBankLetterInvoices.php');
	}
	if(type==14)
	{
		var tbl 		= document.getElementById('tblMain'+type);
		var booFirst	= true;
		var location	= "";
		
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				if(booFirst)
					location = tbl.rows[loop].cells[1].id;
				else
					location += ','+tbl.rows[loop].cells[1].id;
					
				booFirst	= false;
			}
		}
		
		var url  = "reports/rptFactorywiseReceivablesDetailed.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&locationId="+location;
		window.open(url,'rptFactorywiseReceivablesDetailed.php');
	}
	if(type==15)
	{
		var tbl 		= document.getElementById('tblMain'+type);
		var booFirst	= true;
		var location	= "";
		
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				if(booFirst)
					location = tbl.rows[loop].cells[1].id;
				else
					location += ','+tbl.rows[loop].cells[1].id;
					
				booFirst	= false;
			}
		}
		
		var url  = "reports/rptFactorywiseReceivablesSummaryBuyers.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&locationId="+location;
		window.open(url,'rptFactorywiseReceivablesSummaryBuyers.php');
	}
	if(type==16)
	{
		var tbl 		= document.getElementById('tblMain'+type);
		var booFirst	= true;
		var location	= "";
		
		for(loop=1;loop<tbl.rows.length;loop++)
		{
			if(tbl.rows[loop].cells[0].childNodes[0].checked)
			{
				if(booFirst)
					location = tbl.rows[loop].cells[1].id;
				else
					location += ','+tbl.rows[loop].cells[1].id;
					
				booFirst	= false;
			}
		}
		
		var url  = "reports/rptFactorywiseReceivablesSummary.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&locationId="+location;
		window.open(url,'rptFactorywiseReceivablesSummary.php');
	}
}

function ShowExcelReport(type)
{
	//alert("Bhagya");
	if(type==10)
	{
		var url  = "reports/excellFinalInv.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			
		window.open(url,'excellFinalInv.php');
	}
	if(type==9)
	{
		var url  = "reports/excellCustomInv.php?";
			url += "CheckDate="+(document.getElementById('chkDate'+type).checked ? 1:0);
			url += "&DateFrom="+document.getElementById('txtDfrom'+type).value;
			url += "&DateTo="+document.getElementById('txtDto'+type).value;
			url += "&BuyerId="+document.getElementById('cboBuyer'+type).value;
			//url += "&InvoNoFrom="+document.getElementById('txtInvoNoFrom'+type).value.trim();
			//url += "&InvoNoTo="+document.getElementById('txtInvoNoTo'+type).value.trim();
			
		window.open(url,'excellCustomInv.php');
	}
}
function ValidateDate(obj,id)
{
	if(!obj.checked)
	{
		document.getElementById("txtDfrom"+id).disabled = true;
		document.getElementById("txtDto"+id).disabled = true;		
	}
	else
	{
		document.getElementById("txtDfrom"+id).disabled = false;
		document.getElementById("txtDto"+id).disabled = false;
	}	
}

function ValidateDate1(obj,id)
{
	if(!obj.checked)
	{
		//document.getElementById("txtDfrom"+id).disabled = true;
		document.getElementById("txtDto"+id).disabled = true;		
	}
	else
	{
		//document.getElementById("txtDfrom"+id).disabled = false;
		document.getElementById("txtDto"+id).disabled = false;
	}	
}

function ClearForm()
{
	document.frmProductionList.reset();
}

$(document).ready(function(){
	
	$('#link1').click(function(){
		$('#mainform1').empty();
		$('#div1').css("display","inline");
		
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div5').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		
		
		$('#div1').fadeIn(2000);
	})
	$('#link2').click(function(){
		$('#mainform1').empty();
		$('#div2').css("display","inline");
		$('#div1').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div5').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link3').click(function(){
		
		//$('#mainform1').empty();
		$('#div3').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div4').css("display","none");
		$('#div5').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link4').click(function(){
		//$('#mainform1').empty();
		$('#div4').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div5').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link5').click(function(){
		//$('#mainform1').empty();
		$('#div5').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link6').click(function(){
		//$('#mainform1').empty();
		$('#div6').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div5').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link7').click(function(){
		//$('#mainform1').empty();
		$('#div7').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div6').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link8').click(function(){
		//$('#mainform1').empty();
		$('#div8').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link9').click(function(){
		//$('#mainform1').empty();
		$('#div9').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link10').click(function(){
		//$('#mainform1').empty();
		$('#div10').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link11').click(function(){
		//$('#mainform1').empty();
		$('#div11').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link12').click(function(){
		//$('#mainform1').empty();
		$('#div12').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link13').click(function(){
		//$('#mainform1').empty();
		$('#div13').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link14').click(function(){
		//$('#mainform1').empty();
		$('#div14').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link15').click(function(){
		//$('#mainform1').empty();
		$('#div15').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	$('#link16').click(function(){
		//$('#mainform1').empty();
		$('#div16').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div17').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	
	$('#link17').click(function(){
		//$('#mainform1').empty();
		//alert("Bhagya");
		$('#div17').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div18').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
		
	$('#link18').click(function(){
		//$('#mainform1').empty();
		//alert("Bhagya");
		$('#div18').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div17').css("display","none");
		$('#div19').css("display","none");
		$(this).fadeIn(2000);
	})
	
		$('#link19').click(function(){
		//$('#mainform1').empty();
		//alert("Bhagya");
		$('#div19').css("display","inline");
		$('#div1').css("display","none");
		$('#div2').css("display","none");
		$('#div3').css("display","none");
		$('#div4').css("display","none");
		$('#div6').css("display","none");
		$('#div7').css("display","none");
		$('#div8').css("display","none");
		$('#div9').css("display","none");
		$('#div10').css("display","none");
		$('#div11').css("display","none");
		$('#div12').css("display","none");
		$('#div13').css("display","none");
		$('#div14').css("display","none");
		$('#div15').css("display","none");
		$('#div16').css("display","none");
		$('#div18').css("display","none");
		
		$(this).fadeIn(2000);
	})
})

function showdiv()
{
}
