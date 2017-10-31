//updated from roshan 2009-10-12
var totValue=0;
var totPayAmt=0;
var totBalance=0;
var SchNo=""
var decpoint=false;
var strPaymentType=""
var	xmlHttpSaveDetails = [];
var xmlHttp1 = [];
function CreateXMLHttpForSaveSchedule() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpSave = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSave = new XMLHttpRequest();
    }
}
function CreateXMLHttpForSaveScheduleDetails(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpSaveDetails[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSaveDetails[index] = new XMLHttpRequest();
    }
}

function CreateXMLHttpForTaxTypes() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpTax = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpTax = new XMLHttpRequest();
    }
}
function CreateXMLHttpForSchedualNo() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpSchNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSchNo = new XMLHttpRequest();
    }
}

function CreateXMLHttpForGRNItems() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpGRNItems = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpGRNItems = new XMLHttpRequest();
    }
}

function CreateXMLHttpForSupInvoice() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpSupInvoice = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSupInvoice = new XMLHttpRequest();
    }
}
function setSelect(obj)
{
	obj.select();
}
function loadSupInvoice()
{
	

		var tblG=document.getElementById('tblGRNs');
		var rCount = tblG.rows.length;
		for(var loop=1;loop<rCount;loop++)
		{
			tblG.deleteRow(loop);
			rCount--;
			loop--;
		}
		
		var tblT=document.getElementById('tblTaxType');
		var tCount = tblT.rows.length;
		for(var loop=1;loop<tCount;loop++)
		{
			tblT.deleteRow(loop);
			tCount--;
			loop--;
		}
		var tblT=document.getElementById('tblPoDetails');
		var tCount = tblT.rows.length;
		for(var loop=1;loop<tCount;loop++)
		{
			tblT.deleteRow(loop);
			tCount--;
			loop--;
		}
		
	strPaymentType=document.getElementById("cboPymentType").value
	//alert(123);
	var supId=document.getElementById("cboSupliers").value;
	if(supId==0)
	{
		return	;
	}
	
	CreateXMLHttpForSupInvoice();
	xmlHttpSupInvoice.onreadystatechange = HandleSupInvoice;
    xmlHttpSupInvoice.open("GET", 'paymentScheduleDB.php?DBOprType=getSupInvoices&strPaymentType=' + strPaymentType + '&supID='+ supId, true);
	xmlHttpSupInvoice.send(null); 
	
}

function HandleSupInvoice()
{	
	if(xmlHttpSupInvoice.readyState == 4) 
    {
	   if(xmlHttpSupInvoice.status == 200) 
        {  
		//alert(1);
			var XMLInvNo = xmlHttpSupInvoice.responseXML.getElementsByTagName("invoiceno");
			var XMLAmount = xmlHttpSupInvoice.responseXML.getElementsByTagName("amount");
			var XMLGRNNo = xmlHttpSupInvoice.responseXML.getElementsByTagName("grnno");
			var XMLGRNYear = xmlHttpSupInvoice.responseXML.getElementsByTagName("grnYear");
			var XMLTotAmount = xmlHttpSupInvoice.responseXML.getElementsByTagName("totamount");
			var XMLBalance = xmlHttpSupInvoice.responseXML.getElementsByTagName("balance");
			var XMLPaidAmount = xmlHttpSupInvoice.responseXML.getElementsByTagName("paidammount");
			var XMLSchdAmount = xmlHttpSupInvoice.responseXML.getElementsByTagName("SchdAmount");
			var XMLPONo = xmlHttpSupInvoice.responseXML.getElementsByTagName("pono");
			
			var strInvsTbl="<table width=\"510\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblInvoices\">"+
							"<tr>"+
							"<td width=\"24\" bgcolor=\"\" class=\"grid_header\"><input type=\"checkbox\" onclick=\"chkAll(this);\" /></td>"+
							"<td width=\"64\" bgcolor=\"\" class=\"grid_header\">Invoice No</td>"+
							"<td width=\"61\" bgcolor=\"\" class=\"grid_header\">GRN</td>"+
							"<td width=\"73\" height=\"24\" bgcolor=\"\" class=\"grid_header\">PO</td>"+							
							"<td width=\"76\" bgcolor=\"\" class=\"grid_header\">Amount</td>"+
							//"<td width=\"72\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Tot GRN</td>"+
							"<td width=\"75\" bgcolor=\"\" class=\"grid_header\">Balance</td>"+
							"<td width=\"63\" bgcolor=\"\" class=\"grid_header\">Pay Amount</td>"+

							"</tr>"
			//alert(XMLInvNo.length);
			if( XMLInvNo.length==0)
			{
				 strInvsTbl+="</table>"
				 document.getElementById("divSupInvs").innerHTML=strInvsTbl;
				 
				 var strGRNDetailsTbl="<table width=\"1900\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGRNs\">"+
								"<tr>"+
								"<td width=\"23\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td>"+
								"<td width=\"74\" height=\"20\" bgcolor=\"#498CC2\" class=\"grid_header\">Invoice No</td>"+
								"<td width=\"74\" bgcolor=\"#498CC2\" class=\"grid_header\">GRN No</td>"+
								"<td width=\"74\" bgcolor=\"#498CC2\" class=\"grid_header\">Style No</td>"+
								"<td width=\"74\" bgcolor=\"#498CC2\" class=\"grid_header\">Order No</td>"+
								"<td width=\"203\" bgcolor=\"#498CC2\" class=\"grid_header\">Description</td>"+
								"<td width=\"67\" bgcolor=\"#498CC2\" class=\"grid_header\">QTY</td>"+
								"<td width=\"75\" bgcolor=\"#498CC2\" class=\"grid_header\">Rate</td>"+
								"<td width=\"83\" bgcolor=\"#498CC2\" class=\"grid_header\">Value</td>"+
								"<td width=\"79\" bgcolor=\"#498CC2\" class=\"grid_header\">Balance</td>"+			  
								"<td width=\"138\" bgcolor=\"#498CC2\" class=\"grid_header\">Pay Amount </td>"+
								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
								"</tr>"
				 strGRNDetailsTbl+="</table>"
				 document.getElementById("divGRNItems").innerHTML=strGRNDetailsTbl;

				 strGRNDetailsTbl=""
				 strGRNDetailsTbl="<table width=\"409\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblTaxType\">"+
								"<tr>"+
								"<td width=\"102\" bgcolor=\"\" class=\"grid_header\">Tax Type</td>"+
								"<td width=\"59\" bgcolor=\"\" class=\"grid_header\">Rate</td>"+
								"<td width=\"93\" bgcolor=\"\" class=\"grid_header\">Amount</td>"+
								"<td width=\"102\" height=\"20\" bgcolor=\"\" class=\"grid_header\">Invoice</td>"+
								"</tr>"+
								"</table>"
				 document.getElementById("divTaxType").innerHTML=strGRNDetailsTbl;
				 
				 alert("There is no Invoice to Display");
				 document.getElementById("txtFindInvNo").focus();
				 document.getElementById("txtFindInvNo").select();
			
			}
			for ( var loop = 0; loop < XMLInvNo.length; loop++)
			 {
				var invNo = XMLInvNo[loop].childNodes[0].nodeValue;
				var amount = parseFloat(XMLAmount[loop].childNodes[0].nodeValue);
				var grnNo = XMLGRNNo[loop].childNodes[0].nodeValue;
				var grnYear = XMLGRNYear[loop].childNodes[0].nodeValue;
				var totAmount = parseFloat(XMLTotAmount[loop].childNodes[0].nodeValue);
				var balance = parseFloat(XMLBalance[loop].childNodes[0].nodeValue);
				var paidAmount = XMLPaidAmount[loop].childNodes[0].nodeValue;
				var poNo = XMLPONo[loop].childNodes[0].nodeValue;
				
				var SchdAmount=XMLSchdAmount[loop].childNodes[0].nodeValue;
					SchdAmount =roundNumber(SchdAmount,4)
				//alert(SchdAmount)
					var cls;;
					(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				if(amount>SchdAmount)
				{
					//alert(2);
					strInvsTbl+="<tr>"+
							"<td class=\""+cls+"\">"+
							"<input type=\"checkbox\" onmouseover=\"highlight(this.parentNode)\"   name=\"chkSelect\" value=\"chkSelect\" onclick=\"loadPoDetails(this),loadGRNDetails(this),getPayNow();\" />"+
							"</td>"+
							"<td class=\""+cls+"\" onmouseover=\"highlight(this.parentNode)\" >" + invNo  + "</td>"+
"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" ><img onclick=\"viewGrnPopUp('"+invNo+"');\"  src=\"../images/view2.png\" border=\"0\"/></td>"+
							"<td class=\""+cls+"\" onmouseover=\"highlight(this.parentNode)\" ><img onclick=\"viewPOPopUp('"+invNo+"');\" src=\"../images/view2.png\" border=\"0\"/></td>"+								
							"<td class=\""+cls+"\" onmouseover=\"highlight(this.parentNode)\" >" + amount.toFixed(4)  + "</td>"+
							//"<td class=\"normalfntMid\">" + totAmount + "</td>"+
							"<td class=\""+cls+"\" onmouseover=\"highlight(this.parentNode)\" >" + balance.toFixed(4) + "</td>"+
							"<td class=\""+cls+"\" ><label>"+
							
							"<input type=\"text\" onmouseover=\"highlight(this.parentNode)\"  name=\"textfield\" size=\"15\" value=\"" + balance.toFixed(4) +"\"  style=\"text-align:right\" disabled=\"disabled\" onfocus=\"setSelect(this)\"  onkeyup=\"return BalanceNumbersOnly(this, event,6)\" class=\"txtbox\" />"+
							
							"</label></td>"+
							"</tr>"
							
				}
				
			 }
			 
			 strInvsTbl+="</table>"
			 document.getElementById("divSupInvs").innerHTML=strInvsTbl;			
			
		}
	}
}


function roundNumber(number,decimals)
{
	var newString;// The new rounded number
	decimals = Number(decimals);
	if (decimals < 1) {
		newString = (Math.round(number)).toString();
	} else {
		var numString = number.toString();
		if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
			numString += ".";// give it one at the end
		}
		var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
		var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
		var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
		if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
			if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
				while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
					if (d1 != ".") {
						cutoff -= 1;
						d1 = Number(numString.substring(cutoff,cutoff+1));
					} else {
						cutoff -= 1;
					}
				}
			}
			d1 += 1;
		} 
		if (d1 == 10) {
			numString = numString.substring(0, numString.lastIndexOf("."));
			var roundedNum = Number(numString) + 1;
			newString = roundedNum.toString() + '.';
		} else {
			newString = numString.substring(0,cutoff) + d1.toString();
		}
	}
	if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
		newString += ".";
	}
	var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
	for(var i=0;i<decimals-decs;i++) newString += "0";
	//var newNumber = Number(newString);// make it a number if you like
	return  newString; // Output the result to the form field (change for your purposes)
}

/*function getScheduleNoTask(task,strType)
{					
	strPaymentType=document.getElementById("cboPymentType").value
	var	compCode=""
	paymentType=strType
	CreateXMLHttpForSchedualNo();
	xmlHttpSchNo.onreadystatechange = HandleSchedualNo;
    //xmlHttpSchNo.open("GET", 'paymentScheduleDB.php?DBOprType=getScheduleNo&task=' + task + '&compCode=' + compCode, true);
    xmlHttpSchNo.open("GET", 'paymentScheduleDB.php?DBOprType=getScheduleNo&strPaymentType=' + strPaymentType + '&task=' + task + '&paymentType=' + paymentType, true);
	xmlHttpSchNo.send(null); 
}

function HandleSchedualNo()
{
	if(xmlHttpSchNo.readyState == 4) 
    {
	   if(xmlHttpSchNo.status == 200) 
        {  
			var XMLSchNo = xmlHttpSchNo.responseXML.getElementsByTagName("schNo");
			if(XMLSchNo.length==0)
			{
				alert("Please configer the system number range of syscontrol")
				return
			}
			SchNo = XMLSchNo[0].childNodes[0].nodeValue;
			
			document.getElementById("txtSchdNo").value=SchNo;
		}
	}
}*/

function loadTaxTypes(strInvNoTaxs,type)
{		
		if(strInvNoTaxs!=undefined){
			var url= 'paymentScheduleDB.php?DBOprType=getTaxTypes&INVNo=' + URLEncode(strInvNoTaxs)+'&type='+type;
			htmlobj=$.ajax({url:url,async:false});
			var XMLTaxType = htmlobj.responseXML.getElementsByTagName("taxType");
			var XMLTaxRate = htmlobj.responseXML.getElementsByTagName("taxRate");
			var XMLTaxAmount = htmlobj.responseXML.getElementsByTagName("taxAmount");
			var XMLTaxInvNo = htmlobj.responseXML.getElementsByTagName("taxInvNo");
			
				var htm="";
				var tblTax=document.getElementById('tblTaxType').tBodies[0];
				var rowCount = tblTax.rows.length;
	           
	            for(var i=0;i < XMLTaxType.length;i++)
	    		{ 
					var row = tblTax.insertRow(rowCount);
	            	var taxType = XMLTaxType[i].childNodes[0].nodeValue;
					var taxRate = XMLTaxRate[i].childNodes[0].nodeValue;
					var taxAmt = XMLTaxAmount[i].childNodes[0].nodeValue;
					var taxInvNo = XMLTaxInvNo[i].childNodes[0].nodeValue;
					
	            	var cls;
	            	(i%2==0)?cls="grid_raw":cls="grid_raw2";
					row.className=cls;
					htm="<td class=\""+cls+"\" >"+ taxType +"</td>"+
					" <td class=\""+cls+"\"  >"+ taxRate  +"</td>"+
					" <td class=\""+cls+"\"  >" + taxAmt + "</td>"+
					" <td class=\""+cls+"\"   >" + taxInvNo + "</td>"
					row.innerHTML =htm;
	    		}
		}
}

function loadGRNDetails(obj)
{
//	var tbl = document.getElementById("tblInvoices");
//	var r=tbl.rows.length;
//	var f=0;
//	for(var c=1;c<r;c++)
//	{
//		if(tbl.rows[c].cells[0].childNodes[0].checked==false){
//			f++;
//		}
//	}
//	
//	if(f!=0){
//		var tblG=document.getElementById('tblGRNs');
//		var rCount = tblG.rows.length;
//		for(var loop=1;loop<rCount;loop++)
//		{
//			tblG.deleteRow(loop);
//			rCount--;
//			loop--;
//		}
//	}
//	
	strPaymentType=document.getElementById("cboPymentType").value
	var supId=document.getElementById("cboSupliers").value
	
	var rowId = obj.parentNode.parentNode.rowIndex;
	var i = rowId;
	strSelectedGRN="";
	var x=0;
	var theRow =document.getElementById("tblInvoices").getElementsByTagName("TR")
	var strGrnNos=""
	var strInvNoTax=""
	var totalAvailableValue = 0;
	//for(var i=1;i<theRow.length;i++)
	//{
		var cells=theRow[i].getElementsByTagName("TD");

		if(cells[0].firstChild.checked==false)
		{
				var tbl = document.getElementById("tblGRNs");
				var invNo=cells[1].innerHTML;
				invNo=URLEncode(invNo);
				var x = tbl.rows.length;
				for(var i=1;i<x;i++)
				{
					
						var invNo2 =URLEncode(tbl.rows[i].cells[1].innerHTML);
						if(invNo2==invNo)
						{
							tbl.deleteRow(i);
							--i;
							--x;
						}
				}
				var tblTax = document.getElementById("tblTaxType").tBodies[0];
				var y=tblTax.rows.length;
				
				for(var a=0;a<y;a++){
					var invNoTax =URLEncode(tblTax.rows[a].cells[3].innerHTML);
				
					if(invNoTax==invNo)
					{	
						tblTax.deleteRow(a);
						
						--a;
						--y;
						//return;
					}
					
				}
				calculateTotal();
		}
		else
		{
			
			var advPayNo=cells[1].nodeValue
			var GRNNo=cells[2].innerHTML.substr(5)
			var GRNYear=cells[2].innerHTML.substr(0,4)
			//totalAvailableValue =parseFloat(cells[6].childNodes[0].childNodes[0].value);
			//if(isNaN(document.getElementById("txtTotValue").value)||document.getElementById("txtTotValue").value=='')
				//document.getElementById("txtTotValue").value=0;
//document.getElementById("txtTotValue").value = (parseFloat(document.getElementById("txtTotValue").value) + totalAvailableValue);
			
			var INVNO=cells[1].innerHTML
			
			if(strGrnNos=="" && x==0)
			{
				if(strPaymentType=="S") 
				{
/*					strGrnNos=" grnheader.intGrnNo =" + GRNNo + " and grnheader.intGRNYear=" + GRNYear + " or grnheader.intGrnNo =" + GRNNo + " and grnheader.intGRNYear=" + GRNYear + " "*/

//AND purchaseorderheader.strSupplierID =  'xxx'
					strGrnNos=" grnheader.strInvoiceNo ='"+ URLEncode(INVNO)+"' AND purchaseorderheader.strSupplierID =  '"+supId+"'" ;
				}
				else if(strPaymentType=="G")
				{
					//strGrnNos=" gengrnheader.strGenGrnNo ='" + GRNNo + "'  and gengrnheader.intYear =" + GRNYear + " or gengrnheader.strGenGrnNo ='" + GRNNo + "'  and gengrnheader.intYear =" + GRNYear + " "
					//AND
//generalpurchaseorderheader.intSupplierID =  'xxx'
					strGrnNos = " gengrnheader.strInvoiceNo = '"+URLEncode(INVNO)+"' AND generalpurchaseorderheader.intSupplierID =  '"+supId+"'";
					
				}
				else if(strPaymentType=="B")
				{
					//strGrnNos=" gengrnheader.strGenGrnNo ='" + GRNNo + "'  and gengrnheader.intYear =" + GRNYear + " or gengrnheader.strGenGrnNo ='" + GRNNo + "'  and gengrnheader.intYear =" + GRNYear + " "
					//AND
//generalpurchaseorderheader.intSupplierID =  'xxx'
					strGrnNos = " bulkgrnheader.strInvoiceNo = '"+URLEncode(INVNO)+"' AND bulkpurchaseorderheader.strSupplierID =  '"+supId+"'";
					
				}
			}
			else if(strGrnNos!="" && x!=0)
			{
				if(strPaymentType=="S") 
				{
					strGrnNos=" grnheader.strInvoiceNo ='"+ URLEncode(INVNO)+"' AND purchaseorderheader.strSupplierID =  '"+supId+"'" ;
				}
				else if(strPaymentType=="G")
				{
					//strGrnNos+=" or gengrnheader.strGenGrnNo ='" + GRNNo + "' and gengrnheader.intYear =" + GRNYear + " "
					strGrnNos = " gengrnheader.strInvoiceNo = '"+URLEncode(INVNO)+"' AND generalpurchaseorderheader.intSupplierID =  '"+supId+"'";
				}
				else if(strPaymentType=="B")
				{
					strGrnNos = " bulkgrnheader.strInvoiceNo = '"+URLEncode(INVNO)+"' AND bulkpurchaseorderheader.strSupplierID =  '"+supId+"'";
				}
			}				

/*			if(strInvNoTax=="" && x==0)
			{
				strInvNoTax=" invoicetaxes.strinvoiceno ='" + INVNO +"' "
			}
			else if(strInvNoTax!="" && x!=0)
			{
				strInvNoTax+=" or invoicetaxes.strinvoiceno ='" + INVNO +"' "
			}*/	
			
			x=x+1;
			
		}
	//}	

	if(INVNO!="")
	{
		CreateXMLHttpForGRNItems();
		xmlHttpGRNItems.onreadystatechange = HandleGRNItems;
		var url='paymentScheduleDB.php?DBOprType=getGRNItemsList&GRNNo=' + strGrnNos + '&strPaymentType=' + strPaymentType ;
		xmlHttpGRNItems.open("GET",url, true);
		xmlHttpGRNItems.send(null); 
		
			loadTaxTypes(INVNO,strPaymentType)
		
		//alert(strGrnNos);
	}
	else
	{
/*		var strGRNDetailsTbl="<table width=\"1200\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGRNs\">"+
							"<tr>"+
							"<td width=\"23\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
							"<td width=\"74\" height=\"20\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Invoice No</td>"+
							"<td width=\"74\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GRN No</td>"+
							"<td width=\"74\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style No</td>"+
							"<td width=\"203\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
							"<td width=\"67\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">QTY</td>"+
							"<td width=\"75\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Rate</td>"+
							"<td width=\"83\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Value</td>"+
							"<td width=\"79\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Balance</td>"+			  
							"<td width=\"158\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Pay Amount </td>"+
							"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
							"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
							"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
							"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
							"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
							"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
							"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
							"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
							"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
							"</tr></table>"	*/
		//document.getElementById("divGRNItems").innerHTML=strGRNDetailsTbl;
	}
}
function HandleGRNItems()
{	
	
	if(xmlHttpGRNItems.readyState == 4) 
    {
	   if(xmlHttpGRNItems.status == 200) 
        {  
			var XMLinvoiceno = xmlHttpGRNItems.responseXML.getElementsByTagName("invoiceno");
			var XMLgrnno = xmlHttpGRNItems.responseXML.getElementsByTagName("grnno");
			var XMLstyle = xmlHttpGRNItems.responseXML.getElementsByTagName("style");
			var XMLstyleId = xmlHttpGRNItems.responseXML.getElementsByTagName("styleId");
			
			var XMLOrderNo = xmlHttpGRNItems.responseXML.getElementsByTagName("orderNo");
			
			var XMLdescription = xmlHttpGRNItems.responseXML.getElementsByTagName("description");
			var XMLqty = xmlHttpGRNItems.responseXML.getElementsByTagName("qty");
			var XMLtaxRate = xmlHttpGRNItems.responseXML.getElementsByTagName("taxRate");
			var XMLrate = xmlHttpGRNItems.responseXML.getElementsByTagName("rate");
			//dblSheduledValue
			
			var XMLValueBalance = xmlHttpGRNItems.responseXML.getElementsByTagName("dblValueBalance");
			
			var XMLmainID = xmlHttpGRNItems.responseXML.getElementsByTagName("mainID");
			var XMLcatID = xmlHttpGRNItems.responseXML.getElementsByTagName("catID");
			var XMLdetailID = xmlHttpGRNItems.responseXML.getElementsByTagName("detailID");
			var XMLcolor = xmlHttpGRNItems.responseXML.getElementsByTagName("color");
			var XMLsize = xmlHttpGRNItems.responseXML.getElementsByTagName("size");
			var XMLpo=xmlHttpGRNItems.responseXML.getElementsByTagName("po");
			var XMLpoyear=xmlHttpGRNItems.responseXML.getElementsByTagName("poyear");
			var XMLgrnyear=xmlHttpGRNItems.responseXML.getElementsByTagName("grnyear");
			//var XMLavlSchdAmt=xmlHttpGRNItems.responseXML.getElementsByTagName("avlschdAmt");
			
/*			var strGRNDetailsTbl="<tr>"+
								"<td width=\"23\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
								"<td width=\"74\" height=\"20\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Invoice No</td>"+
								"<td width=\"74\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GRN No</td>"+
								"<td width=\"74\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Style No</td>"+
								"<td width=\"203\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
								"<td width=\"67\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">QTY</td>"+
								"<td width=\"75\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Rate</td>"+
								"<td width=\"83\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Value</td>"+
								"<td width=\"79\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Balance</td>"+			  
								"<td width=\"158\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Pay Amount </td>"+
								"<td style=\"visibility:hidden\"  bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
								"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
								"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
								"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
								"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
								"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
								"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
								"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
								"<td style=\"visibility:hidden\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\" width=\"0\"></td>"+
								"</tr>";*/
			//if(document.getElementById("tblGRNs").rows.length>1)
				//var strGRNDetailsTbl = '';
								//"<tr>";
			
			var totalValueBalance = 0;
			 for ( var loop = 0; loop < XMLinvoiceno.length; loop++)
			 {
				 
				var invoiceno = XMLinvoiceno[loop].childNodes[0].nodeValue;
				var grnno = XMLgrnno[loop].childNodes[0].nodeValue;
				var type=document.getElementById('cboPymentType').value.trim();
				var style;
				var styleId;
				var orderNo;
				
				if(type!="B"){
					style = XMLstyle[loop].childNodes[0].nodeValue;	
					orderNo = XMLOrderNo[loop].childNodes[0].nodeValue;
					styleId=XMLstyleId[loop].childNodes[0].nodeValue;
				}
				else
				{
					style="-";
					orderNo="-";
					styleId="-";
				}
				var description = XMLdescription[loop].childNodes[0].nodeValue;
				//alert(XMLqty[loop].childNodes[0].nodeValue);
				var qty = parseFloat(XMLqty[loop].childNodes[0].nodeValue);
				
				var rate = parseFloat(XMLrate[loop].childNodes[0].nodeValue);
				var valueBalance = parseFloat(XMLValueBalance[loop].childNodes[0].nodeValue);
				//alert(valueBalance);
				
					////rate = new Number(rate).toFixed(2);
				//var balance = XMLbalance[loop].childNodes[0].nodeValue;
				 	///balance=Math.round(balance*100)/100;
					//balance = new Number(balance).toFixed(2);
					
				var mainID 		= XMLmainID[loop].childNodes[0].nodeValue;
				var catID 		= XMLcatID[loop].childNodes[0].nodeValue;
				var detailID 	= XMLdetailID[loop].childNodes[0].nodeValue;
				var color 		= XMLcolor[loop].childNodes[0].nodeValue;
				var size 		= XMLsize[loop].childNodes[0].nodeValue;			
				var po 			= XMLpo[loop].childNodes[0].nodeValue;			
				var poyear 		= XMLpoyear[loop].childNodes[0].nodeValue;			
				var grnyear 	= XMLgrnyear[loop].childNodes[0].nodeValue;			
				//var avlschdamt = XMLavlSchdAmt[loop].childNodes[0].nodeValue;			
				
				var value	=	parseFloat(qty	*	rate).toFixed(4);
				//var valueBalance	=	parseFloat(value - sheduledValue).toFixed(2);
				
					//totvalue=Math.round(totvalue*100)/100;
					//totvalue = new Number(totvalue).toFixed(2);
					
					//balance=totvalue
				
/*				if(avlschdamt>0)
				{
					//avlschdamt=Math.round(avlschdamt*100)/100;
					avlschdamt = new Number(avlschdamt).toFixed(2);
					var paybalance=totvalue-avlschdamt
				}*/
				
					//paybalance=Math.round(balance*100)/100;
					
					//paybalance = new Number(balance).toFixed(2);
				var tbl = document.getElementById("tblGRNs");
				var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);
					//alert(lastRow);
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				var strGRNDetailsTbl="<td class=\""+cls+"\" ><label>"+
									"<input type=\"checkbox\" name=\"chkSelect\" value=\"chkSelect\" onclick=\"setTotalAmts(this)\" checked=\"checked\" /></label></td>"+
									"<td class=\""+cls+"\" style=\"text-align:left\" >" + invoiceno + "</td>"+
									"<td class=\""+cls+"\" style=\"text-align:left\">" + grnno + "</td>"+
									"<td class=\""+cls+"\" style=\"text-align:left\" id=\""+styleId+"\">" + style + "</td>"+
									"<td class=\""+cls+"\" style=\"text-align:left\">" + orderNo + "</td>"+
									
									"<td class=\""+cls+"\" style=\"text-align:left\">" + description + "</td>"+
									"<td class=\""+cls+"\" style=\"text-align:right\" >" + qty.toFixed(4) + "</td>"+
									"<td class=\""+cls+"\" style=\"text-align:right\" >" + rate.toFixed(4) + "</td>"+
									
									"<td class=\""+cls+"\" style=\"text-align:right\" >" + value + "</td>"+
									"<td class=\""+cls+"\" style=\"text-align:right\" >" + valueBalance.toFixed(4) + "</td>"+
									//alert(3);
									"<td class=\""+cls+"\" >"+
									"<input type=\"text\"   name=\"txtBalance\" id=\"txtBalance\" class=\"txtbox\" onkeypress=\"return CheckforValidDecimal2(this,4,event);\" onkeyup=\"return BalanceNumbersOnly(this, event,9)\" size=\"15\" onfocus=\"setSelect(this)\" style=\"text-align:right\"   value=\"" + roundNumber(valueBalance,4)  + "\" /></td>"+
							//Math.round(grnBalance*100)/100		
									"<td style=\"visibility:hidden\" class=\""+cls+"\"  >" + mainID + "</td>"+
									"<td style=\"visibility:hidden\" class=\""+cls+"\"  >" + catID + "</td>"+
									"<td style=\"visibility:hidden\" class=\""+cls+"\"  >" + detailID + "</td>"+
									"<td style=\"visibility:hidden\" class=\""+cls+"\"  >" + color + "</td>"+
									"<td style=\"visibility:hidden\" class=\""+cls+"\"  >" + size + "</td>"+
									"<td style=\"visibility:hidden\" class=\""+cls+"\"  >" + po + "</td>"+
									"<td style=\"visibility:hidden\" class=\""+cls+"\"  >" + poyear + "</td>"+
									"<td style=\"visibility:hidden\" class=\""+cls+"\"  >" + grnyear + "</td>"+
									"<td style=\"visibility:hidden\" class=\""+cls+"\"  >" + invoiceno + "</td>";  //style=\"visibility:hidden\">" 
							//alert(valueBalance);
							totalValueBalance+=valueBalance;	
							//alert(1);
										//document.getElementById("txtTotBalance").value = totalValueBalance;
			//document.getElementById("txtTotPayAmount").value = (parseFloat(document.getElementById("txtTotValue").value) - parseFloat(document.getElementById("txtTotBalance").value));
			//strGRNDetailsTbl+="</table>"
			
			tbl.rows[lastRow].innerHTML  	=  strGRNDetailsTbl ;
					
			 }
			
			
			
			
		}
		calculateTotal();
	}
}

function searchInvoices(){
	var tbl=document.getElementById('tblGRNs').tBodies[0];
	tbl.innerHTML="<tr>"+
								"<td width=\"23\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td>"+
								"<td width=\"74\" height=\"20\" bgcolor=\"#498CC2\" class=\"grid_header\">Invoice No</td>"+
								"<td width=\"74\" bgcolor=\"#498CC2\" class=\"grid_header\">GRN No</td>"+
								"<td width=\"74\" bgcolor=\"#498CC2\" class=\"grid_header\">Style No</td>"+
								"<td width=\"74\" bgcolor=\"#498CC2\" class=\"grid_header\">Order No</td>"+
								"<td width=\"203\" bgcolor=\"#498CC2\" class=\"grid_header\">Description</td>"+
								"<td width=\"67\" bgcolor=\"#498CC2\" class=\"grid_header\">QTY</td>"+
								"<td width=\"75\" bgcolor=\"#498CC2\" class=\"grid_header\">Rate</td>"+
								"<td width=\"83\" bgcolor=\"#498CC2\" class=\"grid_header\">Value</td>"+
								"<td width=\"79\" bgcolor=\"#498CC2\" class=\"grid_header\">Balance</td>"+			  
								"<td width=\"138\" bgcolor=\"#498CC2\" class=\"grid_header\">Pay Amount </td>"+
//								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
//								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
//								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
//								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
//								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
//								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
//								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
//								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
//								"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"></td>"+
								"</tr>";
	var invNo=document.getElementById('txtFindInvNo').value.trim();

	var strPaymentType = document.getElementById('cboPymentType').value.trim();
	//alert(invNo);
	//loadGRNDetails();
	
	if(strPaymentType=="S") 
	{
		strGrnNos=" grnheader.strInvoiceNo ='"+ URLEncode(invNo)+"'" ;
	}
	else if(strPaymentType=="G")
	{
		strGrnNos = " gengrnheader.strInvoiceNo = '"+URLEncode(invNo)+"'";
	}
	else if(strPaymentType=="B")
	{
		strGrnNos = " bulkgrnheader.strInvoiceNo = '"+URLEncode(invNo)+"'";
	}
	CreateXMLHttpForGRNItems();
	xmlHttpGRNItems.onreadystatechange = HandleGRNItems;
	var url='paymentScheduleDB.php?DBOprType=getGRNItemsList&GRNNo=' + strGrnNos + '&strPaymentType=' + strPaymentType ;
	xmlHttpGRNItems.open("GET",url, true);
	xmlHttpGRNItems.send(null); 
}

function findInvNumber(e)//
{
	var keynum;
	var keychar;
	var numcheck;
	
	if(window.event) // IE
		{
		keynum = e.keyCode;
		}
	else if(e.which) // Netscape/Firefox/Opera
		{
		keynum = e.which;
		}
	
	if((keynum==13) && (document.getElementById("txtFindInvNo").value!=""))
	{
		var supId=document.getElementById("cboSupliers").value;
		//alert(supId);
		var invNo=document.getElementById("txtFindInvNo").value;
		var strPaymentType=document.getElementById("cboPymentType").value
		
		CreateXMLHttpForSupInvoice();
		xmlHttpSupInvoice.onreadystatechange = HandleSupInvoice;
		xmlHttpSupInvoice.open("GET", 'paymentScheduleDB.php?DBOprType=findSupInvoices&supID='+ supId + '&invNo=' +URLEncode(invNo) + '&strPaymentType=' +strPaymentType , true);
		xmlHttpSupInvoice.send(null); 	
	}
	else if((keynum==13) && (document.getElementById("txtFindInvNo").value==""))
	{
		alert("Please enter the invoice no to find..");
		document.getElementById("txtFindInvNo").focus();
	}

}

/*function numbersOnly(e)
{
	var dotPos=false;
	var keynum;
	var keychar;
	var numcheck;
	
	if(window.event) // IE
	{
		keynum = e.keyCode;
	}
	else if(e.which) // Netscape/Firefox/Opera
	{
		keynum = e.which;
	}
	alert(keynum)
	if((keynum==46) && (dotPos==false) && (document.getElementById("txtBalance").value==""))
	{
		dotPos=true;
		keynum=0
	}
	else if((keynum==46) && (dotPos==false) )
	{
		dotPos=true;
		keynum=0
	}
	
	if(keynum <= 47 && keynum >= 58 )
	{
		keynum=0
	}
}
*/

function interfaceClear()
{
	var strGRNTbl="<table width=\"1930\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGRNs\">"+
						"<tr>"+
						"<td width=\"24\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td>"+
						"<td width=\"95\" height=\"24\" bgcolor=\"#498CC2\" class=\"grid_header\">Invoice No</td>"+
						"<td width=\"95\" bgcolor=\"#498CC2\" class=\"grid_header\">GRN No</td>"+
						"<td width=\"115\" bgcolor=\"#498CC2\" class=\"grid_header\">Style No</td>"+
						"<td width=\"115\" bgcolor=\"#498CC2\" class=\"grid_header\">Order No</td>"+
						"<td width=\"150\" bgcolor=\"#498CC2\" class=\"grid_header\">Description</td>"+//orderNo
						"<td width=\"80\" bgcolor=\"#498CC2\" class=\"grid_header\">QTY</td>"+
						"<td width=\"80\" bgcolor=\"#498CC2\" class=\"grid_header\">Rate</td>"+
						"<td width=\"80\" bgcolor=\"#498CC2\" class=\"grid_header\">Value</td>"+
						"<td width=\"92\" bgcolor=\"#498CC2\" class=\"grid_header\">Balance</td>"+
						"<td width=\"158\" bgcolor=\"#498CC2\" class=\"grid_header\">Pay Amount</td>"+
						"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\"  style=\"visibility:hidden\"></td>"+
						"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\" style=\"visibility:hidden\"></td>"+
						"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\" style=\"visibility:hidden\"></td>"+
						"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\" style=\"visibility:hidden\"></td>"+
						"<td bgcolor=\"#498CC2\" class=\"grid_header\" width=\"0\" style=\"visibility:hidden\"></td>"+
						"</tr></table>"
	document.getElementById("divGRNItems").innerHTML=strGRNTbl;
	
	
	var strTaxTbl="<table width=\"370\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblTaxType\">"+
							"<tr>"+
							//"<td width=\"100\"bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
							"<td width=\"170\" bgcolor=\"#498CC2\" class=\"grid_header\">Tax Type</td>"+
							"<td width=\"170\" bgcolor=\"#498CC2\" class=\"grid_header\">Rate</td>"+
							"<td width=\"170\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>"+
							"<td width=\"170\" height=\"24\" bgcolor=\"#498CC2\" class=\"grid_header\">Invoice</td>"+
							"</tr></table>"
	document.getElementById("divTaxType").innerHTML=strTaxTbl;
	
	var strInvTbl="<table width=\"510\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblInvoices\">"+
							"<tr>"+
							"<td width=\"24\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td>"+
							"<td width=\"64\" bgcolor=\"#498CC2\" class=\"grid_header\">Invoice No</td>"+
							"<td width=\"61\" bgcolor=\"#498CC2\" class=\"grid_header\">GRN</td>"+
							"<td width=\"73\" height=\"24\" bgcolor=\"#498CC2\" class=\"grid_header\">PO</td>"+							
							"<td width=\"76\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>"+
							//"<td width=\"72\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Tot GRN</td>"+
							"<td width=\"75\" bgcolor=\"#498CC2\" class=\"grid_header\">Balance</td>"+
							"<td width=\"63\" bgcolor=\"#498CC2\" class=\"grid_header\">Pay Amount</td>"+
							"</tr></table>"
	document.getElementById("divSupInvs").innerHTML=strInvTbl;
	document.getElementById("txtFindInvNo").value="";	
	//document.getElementById("txtTotValue").value="0.00";	
	document.getElementById("txtTotPayAmount").value="0.00";	
	document.getElementById("txtTotBalance").value="0.00";	
	document.getElementById("cboSupliers").value=0;
	//getScheduleNoTask("get");
}

function savePaymentSchedule()
{
	var totAmt		=	parseFloat(document.getElementById("txtTotValue").value);
	var totpaid		=	parseFloat(document.getElementById("txtTotPayAmount").value);
	var dblBalance	= 	parseFloat(document.getElementById("txtTotPayAmount").value);//txtTotPayAmount

	if(document.getElementById("cboSupliers").value==0)
	{
		alert("Please select supplier and invoice for payment Schedule");
		document.getElementById("cboSupliers").focus();
		return false;
	}
	
	var grnTab=document.getElementById('tblInvoices');
	var c=0;
	for(var i=1;i<grnTab.rows.length;i++){
		if(grnTab.rows[i].cells[0].childNodes[0].checked){
			c+=1;
		}
	}
	if(c==0){
		alert('Please select a GRN.');
		return false;
	}
	
	/*if(dblBalance>0)
	{
		alert("Please add \""+ dblBalance + "\" amount to the list.");
		return;
	}
	else */if(dblBalance<0)
	{
		alert("Please remove "+ dblBalance*-1 + " amount to the list.");
		return;
	}
		
	var supID=document.getElementById("cboSupliers").value;
	var user="";
	
	strPaymentType	=document.getElementById("cboPymentType").value
	var dblPaid		=document.getElementById("txtTotPayAmount").value
	var dblBalance	=document.getElementById("txtTotBalance").value

	
	CreateXMLHttpForSaveSchedule();
	xmlHttpSave.onreadystatechange = HandleSaveSchedule;
	var url='paymentScheduleDB.php?DBOprType=savePaymentScheduleHeader&strPaymentType=' + strPaymentType + '&SupID='+ supID +'&dblPaid=' + dblPaid + '&dblBalance=' + dblBalance ;
	xmlHttpSave.open("GET", url, true);
	xmlHttpSave.send(null); 	
	
	
	
}

function HandleSaveSchedule()
{	if(xmlHttpSave.readyState == 4) 
    {
	   if(xmlHttpSave.status == 200) 
        {  
			var XMLsave = xmlHttpSave.responseXML.getElementsByTagName("Result");
			var XMLSchedule = xmlHttpSave.responseXML.getElementsByTagName("Schedule");
			var intScheduleNo  = XMLSchedule[0].childNodes[0].nodeValue;
			if(XMLsave.length==0)
			{
				alert("Save Process Failed.");
				return;
			}
			if (XMLsave[0].childNodes[0].nodeValue == "True")
			{
				
				var scheduelNo=intScheduleNo;//document.getElementById("txtSchdNo").value;
				var theRows =document.getElementById("tblGRNs").getElementsByTagName("TR");
				var rowCount = theRows.length;
				
				for (var i=1; i<rowCount; i++)
				{
					var cells=theRows[i].getElementsByTagName("TD");
					
					if(cells[0].firstChild.firstChild.checked==true)
					{
							
						/*var InvoiceNo=cells[18].innerHTML;
						
						var PONO=cells[15].innerHTML;
						var POYear=cells[16].innerHTML;
						var GRNNO=cells[2].innerHTML;
						GRNNO = GRNNO.split("/")[1];
						var GRNYear=cells[17].innerHTML;
						var StyleID=cells[3].innerHTML;
						var MatId=cells[11].innerHTML;
						var MatCatId=cells[12].innerHTML;
						var MatDetailId=cells[13].innerHTML;
						var Colour=cells[14].innerHTML;
						var Size=cells[15].innerHTML;
						var Qty=cells[5].innerHTML;
						var Rate=cells[6].innerHTML;
						var PaidAmt=parseFloat(cells[10].childNodes[0].value);
						var SupID=document.getElementById("cboSupliers").value*/
						
						var InvoiceNo=URLEncode(cells[1].innerHTML);
						
						var PONO=cells[16].innerHTML;
						var POYear=cells[18].innerHTML;
						var GRNNOA=cells[2].innerHTML;
						GRNNO = GRNNOA.split("/")[1];
						var GRNYear=GRNNOA.split("/")[0];
						var StyleID=cells[3].id;
						var MatId=cells[11].innerHTML;
						var MatCatId=cells[12].innerHTML;
						var MatDetailId=cells[13].innerHTML;
						var Colour=cells[14].innerHTML;
						var Size=cells[15].innerHTML;
						var Qty=cells[6].innerHTML;
						var Rate=cells[7].innerHTML;
						var PaidAmt=parseFloat(cells[10].childNodes[0].value);
						var SupID=document.getElementById("cboSupliers").value
						
						
							//alert(PaidAmt);
						strPaymentType=document.getElementById("cboPymentType").value;
						CreateXMLHttpForSaveScheduleDetails(i);
						xmlHttpSaveDetails[i].index = i;
						xmlHttpSaveDetails[i].onreadystatechange = HandleSaveScheduleData;
						var url = 'paymentScheduleDB.php?DBOprType=savePaymentScheduleDetails&strPaymentType=' + strPaymentType + '&scheduelNo=' + scheduelNo + '&InvoiceNo=' + InvoiceNo + '&PONO=' + PONO  + '&POYear=' + POYear + '&GRNNO=' + GRNNO + '&GRNYear=' + GRNYear + '&StyleID=' + URLEncode(StyleID) + '&MatId=' + MatId + '&MatCatId=' + MatCatId + '&MatDetailId=' + MatDetailId + '&Colour=' + Colour + '&Size=' + Size + '&Qty=' + Qty + '&Rate=' + Rate + '&PaidAmt=' + PaidAmt + '&SupID=' + SupID;
						xmlHttpSaveDetails[i].open("GET",url, true);
						xmlHttpSaveDetails[i].send(null);
						//alert(url);
					
					}
				}
				
				alert("Payment Schedule No : \""+scheduelNo +"\" saved successfully.\n" );
				//getScheduleNoTask("set"); //commet by roshan 2009-11-06
				loadSupInvoice();
			}
		}	
	}
}

function HandleSaveScheduleData()
{
	if(xmlHttpSaveDetails[this.index].readyState == 4) 
    {
	   if(xmlHttpSaveDetails[this.index].status == 200) 
        {  
			var XMLResult = xmlHttpSaveDetails[this.index].responseXML.getElementsByTagName("Result");
		}
	}
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

//------------------------Load Po Dateils-------------------
function loadPoDetails(obj){
	
	var invNo=obj.parentNode.parentNode.cells[1].innerHTML; 
	var supId=document.getElementById('cboSupliers').value.trim();
	var strPaymentType=document.getElementById('cboPymentType').value.trim();
	var tbl=document.getElementById('tblPoDetails').tBodies[0];
	var del=0;
	if(!obj.checked){
		del=1;
	}
	var path='paymentScheduleDB.php?DBOprType=loadSchedulePO&InvoiceNo='+invNo+'&SupID='+supId+'&strPaymentType='+strPaymentType;
	htmlobj=$.ajax({url:path,async:false});
	var XMLPONo 		 = htmlobj.responseXML.getElementsByTagName("PONo");
	var XMLPOAmount  	 = htmlobj.responseXML.getElementsByTagName("POAmount");
	var XMLAdvanceAmount = htmlobj.responseXML.getElementsByTagName("AdvanceAmount");
	var XMLPrePaid	 	 = htmlobj.responseXML.getElementsByTagName("PrePaid");	
	
	var tblHtml="";
	var cls="";
		if(del==0){
			for(var i=0;i<XMLPONo.length;i++){
			(i%2==0)?cls='grid_raw':cls='grid_raw2';
			var PoNo	=	XMLPONo[i].childNodes[0].nodeValue;
			var PoAmt	=	XMLPOAmount[i].childNodes[0].nodeValue;
			var AdvAmnt	=	XMLAdvanceAmount[i].childNodes[0].nodeValue; 
			var prePaid	=	XMLPrePaid[i].childNodes[0].nodeValue;
			if(AdvAmnt=="")
				AdvAmnt=0;
			if(prePaid=="")
				prePaid=0;
			var lastRow = tbl.rows.length;	
			var row = tbl.insertRow(lastRow);
		
			
			var balance=Number(PoAmt)-(Number(AdvAmnt)+Number(prePaid));
			
					tblHtml+="<td class=\""+cls+"\" id=\""+invNo+"\">&nbsp;</td>";
					tblHtml+="<td class=\""+cls+"\"><input type=\"checkbox\" ></td>";
					tblHtml+="<td class=\""+cls+"\" style=\"width:50px;text-align:left;\">"+ PoNo +"</td>";
					tblHtml+="<td class=\""+cls+"\" style=\"width:50px;text-align:right;\">"+ PoAmt+"</td>";
					tblHtml+="<td class=\""+cls+"\" style=\"width:50px;text-align:right;\">"+ AdvAmnt+"</td>";
					tblHtml+="<td class=\""+cls+"\" style=\"width:50px;text-align:right;\">"+ prePaid+"</td>";
					tblHtml+="<td class=\""+cls+"\" style=\"width:50px;text-align:right;\">"+ balance +"</td>";
					tblHtml+="<td class=\""+cls+"\"><input type=\"text\" value=\"0\" style=\"width:50px;text-align:right;\"></td>";
	
				if(lastRow>0){
					//alert('0')
					var p=0;
					for(var a=0;a<tbl.rows.length;a++){
						if(tbl.rows[0].cells[2].innerHTML==PoNo){
							p++;
						}
					}
					if(p==0)
						row.innerHTML  	=  tblHtml ;
				}
				else{
					row.innerHTML  	=  tblHtml ;
				}
			}
		}
	else{
		for(var a=0;a<tbl.rows.length;a++){
			var invId=tbl.rows[a].cells[0].id;
			var  invId2=obj.parentNode.parentNode.cells[1].innerHTML;
			if(invId==invId2){
				tbl.deleteRow(a);
			}
		}
	}
	
}

function getPayNow(){
var tblGRN	=	document.getElementById('tblGRNs');
var tblPo	=	document.getElementById('tblPoDetails').tBodies[0];
for(var i=0;i<tblPo.rows.length;i++){
	var POno=tblPo.rows[i].cells[2].innerHTML;
	
	var payNw=0;
	for(var a=1;a<tblGRN.rows.length;a++){
		var GRNPo=tblGRN.rows[a].cells[17].innerHTML+"/"+tblGRN.rows[a].cells[16].innerHTML;

		if(POno==GRNPo){
			payNw=payNw+Number(tblGRN.rows[a].cells[10].childNodes[0].value.trim());
		}
	}
	tblPo.rows[i].cells[7].childNodes[0].value=payNw;
	var PrePaid=tblPo.rows[i].cells[5].innerHTML;
	var Bal=tblPo.rows[i].cells[6].innerHTML
	tblPo.rows[i].cells[5].innerHTML=Number(PrePaid)+Number(payNw);
	tblPo.rows[i].cells[6].innerHTML=Number(Bal)-Number(payNw);
}

}
//----------------------------------------------------------
function calculateTotal()
{
		//var row = obj.parentNode.parentNode.parentNode;
	//tblInvoices
	
	var tbl = document.getElementById("tblInvoices");
	var total = 0;
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		//alert(tbl.rows.length);
		var row = tbl.rows[loop];
		var boolCheck = row.cells[0].childNodes[0].checked;
		if(boolCheck)
			total +=parseFloat(row.cells[6].childNodes[0].childNodes[0].value);
	}	
	
	document.getElementById("txtTotValue").value 		= (roundNumber(total,4)).toFixed(4);
	
/*	var tbl = document.getElementById("tblGRNs");
	var total = 0;
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		var row = tbl.rows[loop];
		//alert(row.cells[0].chi);
		var boolCheck = row.cells[0].childNodes[0].checked;
		if(boolCheck)
			total +=parseFloat(row.cells[9].childNodes[0].childNodes[0].value);
	}	
	document.getElementById("txtTotBalance").value 		= (roundNumber(total,2)).toFixed(2);
	//document.getElementById("txtTotPayAmount").value	= (parseFloat(document.getElementById("txtTotValue").value) - total).toFixed(2);*/
	
		
	var tbl = document.getElementById("tblGRNs");
	var total1 = 0;
	var total2 = 0;
	var invNo1 = '';
	var invNo2 = '';
	for(var loop=1;loop<tbl.rows.length;loop++)
	{
		var row = tbl.rows[loop];
		var boolCheck = row.cells[0].childNodes[0].childNodes[0].checked;
		
		invNo2 =  URLEncode(row.cells[1].innerHTML);
		
		if(invNo1 !=invNo2)
		{
			invNo1 = invNo2;
			
			total1 = parseFloat(total1)+parseFloat(roundNumber(total2,2));
			total2 = 0;

		}
		
		total2 =  parseFloat(total2) + parseFloat(row.cells[10].childNodes[0].value);
	}
	
	total1 = parseFloat(total1)+parseFloat(total2);
	document.getElementById("txtTotBalance").value 		= (roundNumber(total1,4)).toFixed(4);
	document.getElementById("txtTotPayAmount").value	= (parseFloat(document.getElementById("txtTotValue").value) -  (roundNumber(total1,4)).toFixed(4)).toFixed(4);
	getPayNow();
}

function setTotalAmts(obj)
{
	//document.getElementById("txtTotValue").value="";
	var row = obj.parentNode.parentNode.parentNode;
		if(!obj.checked)
		{
			document.getElementById("txtTotBalance").value =(parseFloat(document.getElementById("txtTotBalance").value) -  parseFloat(row.cells[9].childNodes[0].value)).toFixed(4);
			row.cells[10].childNodes[0].value=0;
		
			document.getElementById("txtTotPayAmount").value = (parseFloat(document.getElementById("txtTotValue").value) - parseFloat(document.getElementById("txtTotBalance").value)).toFixed(4);
		}
		else
		{
			
			row.cells[10].childNodes[0].value=row.cells[9].innerHTML;
			document.getElementById("txtTotBalance").value =(parseFloat(document.getElementById("txtTotBalance").value)+ parseFloat(row.cells[9].childNodes[0].value)).toFixed(4);
			document.getElementById("txtTotPayAmount").value = (parseFloat(document.getElementById("txtTotValue").value) - parseFloat(document.getElementById("txtTotBalance").value)).toFixed(4);
		}
		
		calculateTotal();
/*	totValue=0;
	totPayAmt=0;
	totBalance=0;
	var theRows =document.getElementById("tblGRNs").getElementsByTagName("TR")

	for (var i=1; i<theRows.length; i++)
	{
		var cells=theRows[i].getElementsByTagName("TD");
		
		if(cells[0].firstChild.firstChild.checked==true)
		{
			totValue=+parseFloat(totValue)+parseFloat(cells[7].innerHTML);
			//totValue=Math.round(totValue*100)/100;
			totValue = new Number(totValue).toFixed(3);

			
			totPayAmt=+parseFloat(totPayAmt)+parseFloat(cells[9].firstChild.firstChild.value);	
			//totPayAmt=Math.round(totPayAmt*100)/100;
			totPayAmt = new Number(totPayAmt).toFixed(3);
			
			totBalance=+parseFloat(totBalance)+parseFloat(cells[18].innerHTML);
			//totBalance=Math.round(totBalance*100)/100;
			totBalance = new Number(totBalance).toFixed(3);
		}
		else if(cells[0].firstChild.firstChild.checked==false)
		{
			cells[8].innerHTML="0.00"
			cells[9].firstChild.firstChild.value=cells[18].innerHTML
		}
		
	}
	
	document.getElementById("txtTotValue").value=totValue;
	document.getElementById("txtTotPayAmount").value=totPayAmt;
	var balAmt=totValue-totPayAmt
		balAmt=balAmt-(totValue-totBalance)
		//balAmt=Math.round(balAmt*100)/100;
		balAmt = new Number(balAmt).toFixed(3);
	document.getElementById("txtTotBalance").value=balAmt*/
	/*if(!obj.checked)
		{
			var val=(parseFloat(document.getElementById("txtTotValue").value))-parseFloat(row.cells[10].childNodes[0].value)
			document.getElementById("txtTotValue").value = val.toFixed(4) ;
		}
		else
		{
			document.getElementById("txtTotValue").value = (parseFloat(document.getElementById("txtTotValue").value)) + parseFloat(row.cells[9].innerHTML);
		}*/
}

function chkAll(obj){
	/*var tbl=document.getElementById('tblInvoices');
	var rc=tbl.rows.length;
	if(obj.checked){
		for(var i=1;i<rc;i++){
			tbl.rows[i].celles[0].childNodes[0].checked=true;
			tbl.rows[i].celles[0].childNodes[0].onclick();
		}
	}*/
}

function BalanceNumbersOnly(myfield, e, dec)
{
	
var theRows=myfield.parentNode.parentNode
//var cells=theRows.getElementsByTagName("TD");

var fixBalance	=	parseFloat(theRows.cells[9].innerHTML); //parseFloat(cells);
var value		=	parseFloat(myfield.value);

if(fixBalance<value)
{
	myfield.value = fixBalance;
	
	alert("Maximum pay amount is "+fixBalance);	
	
}
validateLimit(myfield);
calculateTotal();
/*var amtBalance=parseFloat(cells[dec+9].innerHTML);
var amtPay=parseFloat(cells[dec].firstChild.firstChild.value);//cells[8].innerHTML;
var amt=parseFloat(cells[dec-2].innerHTML);
var key;
var keychar;

if (window.event)
{   
   key = window.event.keyCode;
}
else if (e)
{
	key = e.which;
}
else
{
   return true;
}

keychar = String.fromCharCode(key);

// control keys
if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
{
   return true;
}
// numbers
else if ((("0123456789").indexOf(keychar) > -1))
{
	var xBal=cells[dec+9].innerHTML
	
	if(amtBalance < amtPay)
	{
		alert("Can not be Balance less than Paid Amount");
		cells[dec-1].innerHTML=xBal
		cells[dec].firstChild.firstChild.value=xBal;
		setTotalAmts()
		return false;
	}
	else
	{
		
		var newBal=parseFloat(xBal)-parseFloat(amtPay)
		    //newBal=Math.round(newBal*100)/100;
			newBal = new Number(newBal).toFixed(3);
			
		cells[dec-1].innerHTML=newBal
		setTotalAmts()
		return true;
	}
	
}
// catch decimal point 
else if (decpoint==false && (keychar == "."))
{
	decpoint=true;
	return true;
}
else
{
   return false;
}


//amtBalance*/


}
function validateLimit(obj){
	var mValue=obj.value;
	var invoiceValue;
	var invTab=document.getElementById('tblInvoices');
	var grnTab=document.getElementById('tblGRNs');
	var mInv=obj.parentNode.parentNode.cells[1].innerHTML
	var bal=0;
	for(var i=1;i<invTab.rows.length;i++){		
		if(mInv == invTab.rows[i].cells[1].innerHTML)
		{
			invoiceValue=parseFloat(invTab.rows[i].cells[6].childNodes[0].childNodes[0].value);
		}
	}
	for(var i=1;i<grnTab.rows.length;i++){		
		if(mInv == grnTab.rows[i].cells[1].innerHTML)
		{
			bal+=parseFloat(grnTab.rows[i].cells[10].childNodes[0].value);
			
		}
	}
	if(invoiceValue < bal){
		alert("Maximum pay amount is "+invoiceValue);
		obj.value=0;
	//return false;
	}
}
function CheckforValidDecimal2(sCell,decimalPoints,evt)
{
	var value=sCell.value;

	var charCode = (evt.which) ? evt.which : evt.keyCode;
	
	var allowableCharacters = new Array(9,45,36,35);
	for (var loop = 0 ; loop < allowableCharacters.length ; loop ++ )
	{
		if (charCode == allowableCharacters[loop] )
		{
			return true;
		}
	}
	
	
	for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }
	
	if (charCode==46 && value.indexOf(".") >-1)
		return false;
	else if (charCode==46)
		return true;
	
	if (value.indexOf(".") > -1 && value.substring(value.indexOf("."),value.length).length > decimalPoints)
		return false;
	
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
}

////////////////////////////////////////////////// popup
function createXMLHttpRequest1(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}

function viewGrnPopUp(invNo)
{
	//alert(invNo);
	createXMLHttpRequest1(0);
	xmlHttp1[0].onreadystatechange=showPopUpRequest1;
	var url  = "paymentSchedulePopUpGrn.php?invNo="+invNo+"&Type="+document.getElementById('cboPymentType').value.trim();
	xmlHttp1[0].open("GET", url, true);
	xmlHttp1[0].send(null);	
}

function showPopUpRequest1()
{
	if(xmlHttp1[0].readyState == 4 && xmlHttp1[0].status == 200) 
    {
		var text = xmlHttp1[0].responseText;
		//alert(text);
			drawPopupArea(300,190,'frmServer');
			var frame = document.createElement("div");
			frame.id = "serverSelection";
			document.getElementById('frmServer').innerHTML=text;
	}
}

function viewPOPopUp(invNo)
{
	//alert(invNo);
	createXMLHttpRequest1(1);
	xmlHttp1[1].onreadystatechange=showPopUpRequest2;
	var url  = "paymentSchedulePopUpPo.php?invNo="+invNo+"&Type="+document.getElementById('cboPymentType').value.trim();
	xmlHttp1[1].open("GET", url, true);
	xmlHttp1[1].send(null);	
}

function showPopUpRequest2()
{
	if(xmlHttp1[1].readyState == 4 && xmlHttp1[1].status == 200) 
    {
		var text = xmlHttp1[1].responseText;
		//alert(text);
		drawPopupArea(300,190,'frmServer');
		var frame = document.createElement("div");
		frame.id = "serverSelection";
		document.getElementById('frmServer').innerHTML=text;
	}
}

function closeWindow()
{
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

function roundNumber(num, dec) {
	var result = Math.round( Math.round( num * Math.pow( 10, dec + 1 ) ) / Math.pow( 10, 1 ) ) / Math.pow(10,dec);
	return result;
	
}