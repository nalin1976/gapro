//updated from roshan 2009-10-12
//updated by Nero 2012 February

var xmlHttp;
var altxmlHttp;
var altxmlHttpArray = [];
var strPaymentType=""
var incr =0;
var invNoAvailability=false;
var listing = 0;
var arrearlySavedInvAmt = new Array();


//var fltGlAmt =0;
//var fltPrevGlAmt = 0;
var totGRNAmount = 0;

var pub_grnBalance=0;
var pub_poBalance = 0;

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

function createXMLHttpCheckInvBalance() 
{
    if (window.ActiveXObject) 
    {
        XMLHttpCheckInvBalance = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        XMLHttpCheckInvBalance = new XMLHttpRequest();
    }
}


function CreateXMLHttpForCheckInvoiceNo() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpCheckInvoiceNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpCheckInvoiceNo = new XMLHttpRequest();
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

function SearchInvoiceNoEdit(invNo)
{
	strPaymentType=document.getElementById("cboPymentType").value
	
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = HandleSearchInvoiceNoEdit;
	altxmlHttp.open("GET",'supplierInvXML.php?RequestType=SearchInvoiceNoEdit&strPaymentType=' + strPaymentType + '&InvoiceNo=' + invNo,true);
	altxmlHttp.send(null);
}

function HandleSearchInvoiceNoEdit()
{
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {
			var XMLSupId = altxmlHttp.responseXML.getElementsByTagName("SupId");
			var XMLSupNm = altxmlHttp.responseXML.getElementsByTagName("SupNm");

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

function SearchEdit(invNo,supId,strPaymentType)
{
	listing = 1;
	document.getElementById("txtinvno").value = invNo;
	document.getElementById("cbosupplier").value =supId;
	SearchInvoiceNoEdit(invNo);
	document.getElementById("search").style.visibility = 'hidden'; 
	GetSupplierInvoiceExst(invNo,supId);
	
	
	
	LoadSupplierGLEdit(invNo,supId);
	
	LoadPoDetailsEdit(invNo,supId);
	
	
	genDescription(invNo,supId);
	
	ShowAllTax();
	
	ShowAllTaxExst(invNo,supId);
	//LoadBatchNoEdit(invNo,supId);
}

function LoadBatchNoEdit(invNo,supId){

	var path="supplierInvXML.php?RequestType=loadBatchNo&invNo="+invNo+"&supNo="+supId;
	//alert(path);
	htmlobj=$.ajax({url:path,async:false});
	
		var XMLBatchNo	=htmlobj.responseXML.getElementsByTagName("BatchNo");

	if(XMLBatchNo.length > 0){
		document.getElementById('cbobatch').value = XMLBatchNo[0].childNodes[0].nodeValue;
	}
}
function GetSupplierInvoiceExst(invNo,supId)
{
	strPaymentType=document.getElementById("cboPymentType").value
	
/*	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;

	altxmlHttpArray[incr].onreadystatechange = HandleGetSupplierInvoiceExst;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=GetSupplierInvoiceExst&strPaymentType=' + strPaymentType + '&InvoiceNo=' + invNo + '&SupplierId=' + supId ,true);
	altxmlHttpArray[incr].send(null);
	incr++;*/
	
	var url   = 'supplierInvXML.php?RequestType=GetSupplierInvoiceExst&strPaymentType=' + strPaymentType + '&InvoiceNo=' + invNo + '&SupplierId=' + supId;
	altxmlHttpArray   = $.ajax({url:url,async:false});	
	
			var XMLCompId = altxmlHttpArray.responseXML.getElementsByTagName("CompId");
			var XMLCompNm = altxmlHttpArray.responseXML.getElementsByTagName("CompNm");
			var XMLCompCd = altxmlHttpArray.responseXML.getElementsByTagName("CompCd");
			var XMLAccPacID = altxmlHttpArray.responseXML.getElementsByTagName("AccPacID");
			var XMLInvCurrency = altxmlHttpArray.responseXML.getElementsByTagName("InvCurrency");
			var XMLCreditDays = altxmlHttpArray.responseXML.getElementsByTagName("CreditDays");
			
			var XMLInvDate = altxmlHttpArray.responseXML.getElementsByTagName("InvDate");
			var XMLInvAmt = altxmlHttpArray.responseXML.getElementsByTagName("InvAmt");
			var XMLInvDes = altxmlHttpArray.responseXML.getElementsByTagName("InvDes");
			var XMLInvCommission = altxmlHttpArray.responseXML.getElementsByTagName("InvCommission");
			var XMLInvTotTaxAmt = altxmlHttpArray.responseXML.getElementsByTagName("InvTotTaxAmt");
			
			var XMLInvFreight = altxmlHttpArray.responseXML.getElementsByTagName("InvFreight");
			var XMLInvInsurance = altxmlHttpArray.responseXML.getElementsByTagName("InvInsurance");
			var XMLInvOther = altxmlHttpArray.responseXML.getElementsByTagName("InvOther");
			var XMLInvVatGL = altxmlHttpArray.responseXML.getElementsByTagName("InvVatGL");
			
			var XMLInvTotAmt = altxmlHttpArray.responseXML.getElementsByTagName("InvTotAmt");
			var XMLPaidStatus = altxmlHttpArray.responseXML.getElementsByTagName("PaidStatus");
			var XMLstrBatchNo = altxmlHttpArray.responseXML.getElementsByTagName("strBatchNo");
			
			
			RemoveCurrentCombo("cbocompany");
			//RemoveCurrentCombo("cboinvdate");
			
			for ( var loop = 0; loop < XMLCompId.length; loop++)
			{
				//alert(XMLPaidStatus[loop].childNodes[0].nodeValue);
				if(XMLPaidStatus[loop].childNodes[0].nodeValue == "1")
				{
					//document.getElementById("btnsave").onclick = "" ;
					var oimageSave=document.getElementById('btnsave');
					oimageSave.style.display='none';
					//oimageSave.style.display=(oimageSave.style.display=='none')?'inline':'none'
				}
				else if(XMLPaidStatus[loop].childNodes[0].nodeValue == "0")
				{
					
					var oimageSave=document.getElementById('btnsave');
					oimageSave.style.display='inline';
				}
				
				// Invoice Date
				var InvDt = XMLInvDate[loop].childNodes[0].nodeValue;
				
				InvDt = InvDt.substr(0,10);
				InvDt = InvDt.split('-');
				InvDt = InvDt[2]+"/"+InvDt[1]+"/"+InvDt[0];
				document.getElementById("cboinvdate").value=InvDt;
				/*InvDt = InvDt.replace(/-/gi,"/");alert(InvDt);
				var opt = document.createElement("option");
				opt.text = InvDt;
				opt.value = InvDt;
				document.getElementById("cboinvdate").options.add(opt);*/
				
				// Ivoice Amount
				
				document.getElementById("txttotglamount").value =  new Number(XMLInvAmt[loop].childNodes[0].nodeValue).toFixed(4);
				//document.getElementById("txtRealAmount").value =  new Number(XMLInvAmt[loop].childNodes[0].nodeValue).toFixed(4);
				
				var earlySavedInvAmt = XMLInvAmt[loop].childNodes[0].nodeValue;
				if(isNaN(earlySavedInvAmt) == true){
				earlySavedInvAmt = 0;	
				}
				arrearlySavedInvAmt.push(earlySavedInvAmt);	
				
				totGRNAmount = document.getElementById("txttotglamount").value;
				pub_grnBalance = totGRNAmount;
				totGRNAmount=Math.round(totGRNAmount*100)/100;
				// Invoice Desc
				document.getElementById("txtDescription").value =  XMLInvDes[loop].childNodes[0].nodeValue ;
				//alert(XMLInvDes[loop].childNodes[0].nodeValue);
				// Invoice Commission
				document.getElementById("txtcommission").value =  new Number(XMLInvCommission[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total Tax Invoice
				document.getElementById("txttottaxamount").value =  new Number(XMLInvTotTaxAmt[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total Freight charge
				document.getElementById("txtfreight").value =  new Number(XMLInvFreight[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total Insurance charge
				document.getElementById("txtinsurance").value =  new Number(XMLInvInsurance[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total Other Charge
				document.getElementById("txtother").value =  new Number(XMLInvOther[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total VatGl
				document.getElementById("txtvatgl").value =  new Number(XMLInvVatGL[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total Amount
				document.getElementById("txtinvoiceamount").value =  new Number(XMLInvTotAmt[loop].childNodes[0].nodeValue).toFixed(2);
				document.getElementById("cbobatch").value = XMLstrBatchNo[loop].childNodes[0].nodeValue;

				
				var opt = document.createElement("option");
				opt.text = XMLCompNm[loop].childNodes[0].nodeValue;
				opt.value = XMLCompCd[loop].childNodes[0].nodeValue;
				document.getElementById("cbocompany").options.add(opt);
				
				document.getElementById("txtcompid").value = XMLCompId[loop].childNodes[0].nodeValue;
				
				document.getElementById("txtaccpacid").value = XMLAccPacID[loop].childNodes[0].nodeValue;
				
				//Select Supplier Currency
				var optCombo1 = document.getElementById("cbocurrency").options;
				for (var i = 0; i < optCombo1.length; i++)
				{
					if(optCombo1[i].text == XMLInvCurrency[loop].childNodes[0].nodeValue)
					{
						document.getElementById("cbocurrency").options.selectedIndex = optCombo1[i].index;
						getCurrencyRate();
					}
				}
				
				//Select Supplier CreditPeriod
				var optCombo2 = document.getElementById("cbocreditprd").options;
				for (var y = 0; y < optCombo2.length; y++)
				{
					if(optCombo2[y].value == XMLCreditDays[loop].childNodes[0].nodeValue)
					{
						document.getElementById("cbocreditprd").options.selectedIndex = optCombo2[y].index;
						CreditDueDate();
					}
				}
			}
			//LoadBatch();
}

function HandleGetSupplierInvoiceExst()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
			//alert(altxmlHttpArray[this.index].responseText);
			
			var XMLCompId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("CompId");
			var XMLCompNm = altxmlHttpArray[this.index].responseXML.getElementsByTagName("CompNm");
			var XMLCompCd = altxmlHttpArray[this.index].responseXML.getElementsByTagName("CompCd");
			var XMLAccPacID = altxmlHttpArray[this.index].responseXML.getElementsByTagName("AccPacID");
			var XMLInvCurrency = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvCurrency");
			var XMLCreditDays = altxmlHttpArray[this.index].responseXML.getElementsByTagName("CreditDays");
			
			var XMLInvDate = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvDate");
			var XMLInvAmt = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvAmt");
			var XMLInvDes = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvDes");
			var XMLInvCommission = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvCommission");
			var XMLInvTotTaxAmt = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvTotTaxAmt");
			
			var XMLInvFreight = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvFreight");
			var XMLInvInsurance = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvInsurance");
			var XMLInvOther = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvOther");
			var XMLInvVatGL = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvVatGL");
			
			var XMLInvTotAmt = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvTotAmt");
			var XMLPaidStatus = altxmlHttpArray[this.index].responseXML.getElementsByTagName("PaidStatus");
			var XMLstrBatchNo = altxmlHttpArray[this.index].responseXML.getElementsByTagName("strBatchNo");
			
			
			RemoveCurrentCombo("cbocompany");
			//RemoveCurrentCombo("cboinvdate");
			
			for ( var loop = 0; loop < XMLCompId.length; loop++)
			{
				//alert(XMLPaidStatus[loop].childNodes[0].nodeValue);
				if(XMLPaidStatus[loop].childNodes[0].nodeValue == "1")
				{
					//document.getElementById("btnsave").onclick = "" ;
					var oimageSave=document.getElementById('btnsave');
					oimageSave.style.display='none';
					//oimageSave.style.display=(oimageSave.style.display=='none')?'inline':'none'
				}
				else if(XMLPaidStatus[loop].childNodes[0].nodeValue == "0")
				{
					
					var oimageSave=document.getElementById('btnsave');
					oimageSave.style.display='inline';
				}
				
				// Invoice Date
				var InvDt = XMLInvDate[loop].childNodes[0].nodeValue;
				
				InvDt = InvDt.substr(0,10);
				InvDt = InvDt.split('-');
				InvDt = InvDt[2]+"/"+InvDt[1]+"/"+InvDt[0];
				document.getElementById("cboinvdate").value=InvDt;
				/*InvDt = InvDt.replace(/-/gi,"/");alert(InvDt);
				var opt = document.createElement("option");
				opt.text = InvDt;
				opt.value = InvDt;
				document.getElementById("cboinvdate").options.add(opt);*/
				
				// Ivoice Amount
				
				document.getElementById("txttotglamount").value =  new Number(XMLInvAmt[loop].childNodes[0].nodeValue).toFixed(4);
				//document.getElementById("txtRealAmount").value =  new Number(XMLInvAmt[loop].childNodes[0].nodeValue).toFixed(4);
				
				
				totGRNAmount = document.getElementById("txttotglamount").value;
				
				totGRNAmount=Math.round(totGRNAmount*100)/100;
				// Invoice Desc
				document.getElementById("txtDescription").value =  XMLInvDes[loop].childNodes[0].nodeValue ;
				//alert(XMLInvDes[loop].childNodes[0].nodeValue);
				// Invoice Commission
				document.getElementById("txtcommission").value =  new Number(XMLInvCommission[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total Tax Invoice
				document.getElementById("txttottaxamount").value =  new Number(XMLInvTotTaxAmt[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total Freight charge
				document.getElementById("txtfreight").value =  new Number(XMLInvFreight[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total Insurance charge
				document.getElementById("txtinsurance").value =  new Number(XMLInvInsurance[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total Other Charge
				document.getElementById("txtother").value =  new Number(XMLInvOther[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total VatGl
				document.getElementById("txtvatgl").value =  new Number(XMLInvVatGL[loop].childNodes[0].nodeValue).toFixed(2);
				
				//Invoice Total Amount
				document.getElementById("txtinvoiceamount").value =  new Number(XMLInvTotAmt[loop].childNodes[0].nodeValue).toFixed(2);
				document.getElementById("cbobatch").options[document.getElementById("cbobatch").selectedIndex].value = XMLstrBatchNo[loop].childNodes[0].nodeValue ;
				

				
				var opt = document.createElement("option");
				opt.text = XMLCompNm[loop].childNodes[0].nodeValue;
				opt.value = XMLCompCd[loop].childNodes[0].nodeValue;
				document.getElementById("cbocompany").options.add(opt);
				
				document.getElementById("txtcompid").value = XMLCompId[loop].childNodes[0].nodeValue;
				
				document.getElementById("txtaccpacid").value = XMLAccPacID[loop].childNodes[0].nodeValue;
				
				//Select Supplier Currency
				var optCombo1 = document.getElementById("cbocurrency").options;
				for (var i = 0; i < optCombo1.length; i++)
				{
					if(optCombo1[i].text == XMLInvCurrency[loop].childNodes[0].nodeValue)
					{
						document.getElementById("cbocurrency").options.selectedIndex = optCombo1[i].index;
						getCurrencyRate();
					}
				}
				
				//Select Supplier CreditPeriod
				var optCombo2 = document.getElementById("cbocreditprd").options;
				for (var y = 0; y < optCombo2.length; y++)
				{
					if(optCombo2[y].value == XMLCreditDays[loop].childNodes[0].nodeValue)
					{
						document.getElementById("cbocreditprd").options.selectedIndex = optCombo2[y].index;
						CreditDueDate();
					}
				}
			}
			//LoadBatch();
			
			//LoadSupplierGL();
			
			//totGRNAmount = 0;
			//InvoicePayable();
			
			//LoadPoDetails();

			//ShowAllTax();
		}		
	}
}

function LoadSupplierGLEdit(invNo,supId)
{
/*	var SupID = invNo;
	var FacCd = supId;
	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleLoadSupplierGLEdit;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=LoadSupplierGLEdit&strPaymentType=N&invNo=' + invNo + '&supId=' + supId,true);
	altxmlHttpArray[incr].send(null);
	incr++;*/
	
	var path="supplierInvXML.php?RequestType=LoadSupplierGLEdit&strPaymentType=N&invNo=" + invNo + "&supId=" + supId;

	htmlobj=$.ajax({url:path,async:false});
	
			var XMLGLAccId = htmlobj.responseXML.getElementsByTagName("GLAccId");
			var XMLGLAccDesc = htmlobj.responseXML.getElementsByTagName("GLAccDesc");
			var XMLGLAccAmt = htmlobj.responseXML.getElementsByTagName("GLAccAmt");
			var XMLSelected = htmlobj.responseXML.getElementsByTagName("Selected");
			
			var tableText = "<table width=\"560\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblglaccounts\"> " +
                  				"<tr><td width=\"39\" height=\"22\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td> " +
                    			"<td width=\"102\" bgcolor=\"#498CC2\" class=\"grid_header\">GL Acc Id</td>" +
                    			"<td width=\"302\" bgcolor=\"#498CC2\" class=\"grid_header\">Description</td>" +
                    			"<td width=\"115\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>" +
                    			"</tr>";

				for(var loop = 0; loop < XMLGLAccId.length; loop++)
				{
					var selection = "";
					//var GLAmt = 0 ;
					if (XMLSelected[loop].childNodes[0].nodeValue == "True")
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
					else
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckTextBox(this);\" />";
					var cls;
					(loop%2==1)?cls='grid_raw':cls='grid_raw2';
						tableText += "<tr>"+
									"<td class=\""+cls+"\"><div align=\"center\">"+ selection +"</div></td>" +
									"<td class=\""+cls+"\" id=\"" + XMLGLAccId[loop].childNodes[0].nodeValue + "\" style=\"text-align:left;\">" + XMLGLAccId[loop].childNodes[0].nodeValue + "</td>" +
									"<td class=\""+cls+"\" id=\"" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "\" style=\"text-align:left;\">" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "</td>" +
									"<td class=\""+cls+"\"><input type=\"text\" id=\"glamount\" name=\"glamount\" class=\"txtbox\" style=\"width:100px;text-align:right;\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" value=\""+ XMLGLAccAmt[loop].childNodes[0].nodeValue +"\"> " +
									"</input></td>" +
									"</tr>";
				}
				tableText += "</table>";
				document.getElementById("divcons").innerHTML = tableText;
}


/*function HandleLoadSupplierGLEdit()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
			var XMLGLAccId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccId");
			var XMLGLAccDesc = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccDesc");
			var XMLGLAccAmt = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccAmt");
			var XMLSelected = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Selected");
			
			var tableText = "<table width=\"560\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblglaccounts\"> " +
                  				"<tr><td width=\"39\" height=\"22\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td> " +
                    			"<td width=\"102\" bgcolor=\"#498CC2\" class=\"grid_header\">GL Acc Id</td>" +
                    			"<td width=\"302\" bgcolor=\"#498CC2\" class=\"grid_header\">Description</td>" +
                    			"<td width=\"115\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>" +
                    			"</tr>";

				for(var loop = 0; loop < XMLGLAccId.length; loop++)
				{
					var selection = "";
					//var GLAmt = 0 ;
					if (XMLSelected[loop].childNodes[0].nodeValue == "True")
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
					else
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckTextBox(this);\" />";
					var cls;
					(loop%2==1)?cls='grid_raw':cls='grid_raw2';
						tableText += "<tr>"+
									"<td class=\""+cls+"\"><div align=\"center\">"+ selection +"</div></td>" +
									"<td class=\""+cls+"\" id=\"" + XMLGLAccId[loop].childNodes[0].nodeValue + "\" style=\"text-align:left;\">" + XMLGLAccId[loop].childNodes[0].nodeValue + "</td>" +
									"<td class=\""+cls+"\" id=\"" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "\" style=\"text-align:left;\">" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "</td>" +
									"<td class=\""+cls+"\"><input type=\"text\" id=\"glamount\" name=\"glamount\" class=\"txtbox\" style=\"width:100px;text-align:right;\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" value=\""+ XMLGLAccAmt[loop].childNodes[0].nodeValue +"\"> " +
									"</input></td>" +
									"</tr>";
				}
				tableText += "</table>";
				document.getElementById("divcons").innerHTML = tableText;
		}
	}
}*/

function LoadPoDetailsEdit(invNo,supId)
{
	var InvNo = invNo;
		InvNo =InvNo.trim();
	var SupID = supId;
	
	strPaymentType=document.getElementById("cboPymentType").value

	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleLoadPoDetailsEdit;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=LoadPoDetailsEdit&strPaymentType=' + strPaymentType + '&SupplierId=' + SupID + '&InvoiceNo=' + InvNo,true);
	altxmlHttpArray[incr].send(null);
	incr++;
	
}

function HandleLoadPoDetailsEdit()
{
	if (altxmlHttpArray[this.index].readyState == 4)
	{
		if (altxmlHttpArray[this.index].status == 200)
		{			
			var XMLPONo = altxmlHttpArray[this.index].responseXML.getElementsByTagName("PO");
			var XMLCurrency = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Currency");
			var XMLPOAmount = altxmlHttpArray[this.index].responseXML.getElementsByTagName("POAmount");
			var XMLPOBalance = altxmlHttpArray[this.index].responseXML.getElementsByTagName("POBalance");
			var XMLSelected = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Selected");
			
			tableText = "<table width=\"450\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblpodetails\">"  +
						"<tr>"+
							 "<td width=\"39\" height=\"22\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td>" +
							 "<td width=\"22%\" bgcolor=\"#498CC2\" class=\"grid_header\">PO NO</td>" +
              				 "<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Currency</td>" +
              				 "<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>" + 
              				 "<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Balance</td>" +
              				 "<td width=\"15%\" bgcolor=\"#498CC2\" class=\"grid_header\">View</td>" +
						 "</tr>";
			for(var loop = 0; loop < XMLPONo.length ; loop++)
			{
				var PONo = XMLPONo[loop].childNodes[0].nodeValue;
				var Currency = XMLCurrency[loop].childNodes[0].nodeValue;
				var POAmount = XMLPOAmount[loop].childNodes[0].nodeValue;
				var POBalance = XMLPOBalance[loop].childNodes[0].nodeValue;
				var selection = XMLSelected[loop].childNodes[0].nodeValue;
				
				if (selection == "True")
					selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
					else
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" />";
				var cls;
				(loop%2==1)?cls='grid_raw':cls='grid_raw2';
				tableText += "<tr>"+
							 "<td class=\""+cls+"\"><div align=\"center\">"+ selection +"</div></td>" +
							 "<td class=\""+cls+"\">"+ PONo +"</td>" +
              				 "<td class=\""+cls+"\" style=\"text-align:left;\">"+ Currency +"</td>" +
              				 "<td class=\""+cls+"\" style=\"text-align:right;\">"+ parseFloat(POAmount).toFixed(2) +"</td>" +  
              				 "<td class=\""+cls+"\" style=\"text-align:right;\">"+ parseFloat(POBalance).toFixed(2) +"</td>" +
              				 "<td class=\""+cls+"\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" onclick=\"loadPo(this);\"/></div></td>" +
							 "</tr>";
				}
				tableText += "</table>";
				//alert(tableText);
				document.getElementById("divcons2").innerHTML = tableText;
		}	
	}
}
////////==================lasantha description genaration ============================/////////////
function genDescription()
{
	var InvNo = document.getElementById('txtinvno').value.trim();
	var SupID = document.getElementById('cbosupplier').value.trim();
	var w 	  = document.getElementById('cbosupplier').selectedIndex;
    var selected_text = document.getElementById('cbosupplier').options[w].text;
	var type	=	document.getElementById('cboPymentType').value.trim();
	strPaymentType=document.getElementById("cboPymentType").value

	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].index2 = InvNo;
	altxmlHttpArray[incr].index3 = selected_text;
	altxmlHttpArray[incr].onreadystatechange = HandleGenDesc;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=getDescription&InvoiceNo=' + InvNo +'&SupplierId='+SupID+'&type='+type,true);
	altxmlHttpArray[incr].send(null);
	incr++;
}
////////==================End=========================================================/////////////
function HandleGenDesc()
{
	if (altxmlHttpArray[this.index].readyState == 4)
	{
		if (altxmlHttpArray[this.index].status == 200)
		{			
			var XMLPONo = altxmlHttpArray[this.index].responseXML.getElementsByTagName("PONo");
			var poNo=XMLPONo[0].childNodes[0].nodeValue;
			var SupId=altxmlHttpArray[this.index].index3.substring(0,10);
			var InvNo=altxmlHttpArray[this.index].index2;
			document.getElementById('txtDescription').value=(SupId+"-"+InvNo+"-"+poNo);
		}
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////
function ShowAllTaxExst(invNo,supId)
{
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index=incr;
	altxmlHttpArray[incr].onreadystatechange = HandleShowAllTaxExst;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=ShowAllTaxExst&strPaymentType=N&InvoiceNo=' + invNo + '&SupplierId=' + supId,true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function HandleShowAllTaxExst()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
			var XMLTaxID = altxmlHttpArray[this.index].responseXML.getElementsByTagName("TaxID");
			var XMLSelected = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Selected");
			var XMLTaxAmt = altxmlHttpArray[this.index].responseXML.getElementsByTagName("TaxAmt");
			
			var tblall = document.getElementById('tbltaxdetails');
			for ( var loop = 0 ;loop < XMLTaxID.length ; loop ++ )
			{
				for ( var loop2 = 1 ;loop2 < tblall.rows.length ; loop2 ++ )
				{
					var rwTaxId = tblall.rows[loop2].cells[1].id;
					//alert(rwTaxId +" "+ XMLTaxID[loop].childNodes[0].nodeValue);
					if(rwTaxId == XMLTaxID[loop].childNodes[0].nodeValue)
					{
						
						//alert(tblall.rows[loop2].cells[0].childNodes[0].lastChild.checked);
						tblall.rows[loop2].cells[0].childNodes[0].lastChild.checked = true;
						tblall.rows[loop2].cells[3].lastChild.value = XMLTaxAmt[loop].childNodes[0].nodeValue;
					}
				}
			}	
		}
	}
}

/*function AddNewGLAccountRow(objevent)
{
	var tblall = document.getElementById('tblallglaccounts');
		
	for ( var loop = 1 ;loop < tblall.rows.length ; loop ++ )
	{
		if (tblall.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{
			var rwGLAcc = tblall.rows[loop].cells[1].childNodes[0].nodeValue;
			var rwGLDesc = tblall.rows[loop].cells[2].childNodes[0].nodeValue;
			
			var tbl = document.getElementById('tblglaccounts');
			var lastRow = tbl.rows.length;	
			var row = tbl.insertRow(lastRow);
			var cls;
			//(lastRow%2==1)?cls='row_grid':cls='row_grid2';
			var cellGLChk = row.insertCell(0);
			//row.attribute=cls;
			cellGLChk.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" onclick=\"checkUncheckTextBox(this);\" /></div>";
			
			var cellGLAcc = row.insertCell(1);
			cellGLAcc.innerHTML = rwGLAcc;
			
			var cellGLDesc = row.insertCell(2);
			cellGLDesc.innerHTML = rwGLDesc;
			
			var cellGLAmt = row.insertCell(3);
			cellGLAmt.innerHTML = "<input type=\"text\" id=\"glamount\" name=\"glamount\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" value=\""+ 0 +"\">";			
		}
	}
}*/

function InvoiceInitialize(invNo,supId)
{
	/* --- Inovoice Date Taken As System Date --- */
	var today = new Date();
	var invDate =  (today.getDate())+ "/" + (today.getMonth() + 1) + "/" + (today.getYear() + 1900);
	var opt = document.createElement("option");
	opt.text = invDate ;
	opt.value = invDate ;
	document.getElementById("cboinvdate").value=invDate;
	/* -------------------------------------------*/
		
	LoadCurrency(invNo);
	
	LoadBatch();
	
	LoadCreditPeriod();
	
	/* Edit/View Invoice */
	if (invNo != "" && supId != "")
	{
		//alert(invNo +" "+ supId);
		SearchEdit(invNo,supId);
		
	}
//SearchInvoiceNo();
}

// Removes leading whitespaces
function LTrim( value ) {
	
	var re = /\s*((\S+\s*)*)/;
	return value.replace(re, "$1");
	
}
// Removes ending whitespaces
function RTrim( value ) {
	
	var re = /((\s*\S+)*)\s*/;
	return value.replace(re, "$1");
	
}

// Removes leading and ending whitespaces
function trim( value ) {
	
	return LTrim(RTrim(value));
	
}

function SearchInvoiceNo()
{
	var InvNo = document.getElementById("txtinvno").value;
	var supId = document.getElementById("cbosupplier").value;
	LoadSupplierGLEdit(InvNo,supId);
	
	var InvNo = document.getElementById("txtinvno").value;
		InvNo =InvNo.trim();
		//alert(InvNo);
	if(InvNo.length == 0)
	{
		alert ("Please enter invoice number to search !");
		//Sexy.alert('<h1>Search invoice</h1><p>Please enter invoice number to search !</p>');return false;
		document.getElementById('txtinvno').focus();
	}
	else
	{
		strPaymentType=document.getElementById("cboPymentType").value
		
		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandleSearchInvoiceNo;
		xmlHttp.open("GET",'supplierInvXML.php?RequestType=SearchInvoiceNo&strPaymentType=' + strPaymentType + '&InvoiceNo=' + InvNo,true);
		xmlHttp.send(null);
	}
}

function HandleSearchInvoiceNo()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var XMLSupId = xmlHttp.responseXML.getElementsByTagName("SupId");
			var XMLSupNm = xmlHttp.responseXML.getElementsByTagName("SupNm");

			
			if(XMLSupId.length==0)
			{
				alert("Invalid Invoice No under " + document.getElementById("cboPymentType").options[document.getElementById("cboPymentType").selectedIndex].text + " Payment")	
				
				clearControls()
				return;
			}

			RemoveCurrentCombo("cbosupplier");
			//var opt = document.createElement("option");
//			opt.text = "";				
//			document.getElementById("cbosupplier").options.add(opt);
			
			for ( var loop = 0; loop < XMLSupId.length; loop ++)
			{
				var opt = document.createElement("option");
				opt.text = XMLSupNm[loop].childNodes[0].nodeValue;
				opt.value = XMLSupId[loop].childNodes[0].nodeValue;
				document.getElementById("cbosupplier").options.add(opt);
	
			}
			
			var cbosupplier = document.getElementById("cbosupplier").value;
			var cboPymentType = document.getElementById("cboPymentType").value;
			
				var invNo=document.getElementById('txtinvno').value.trim();
				var path="newXml.php?RequestType=checkInvoiceNo&cbosupplier="+cbosupplier+"&invNo="+invNo+"&strPaymentType="+cboPymentType;
				//alert(path);
				htmlobj=$.ajax({url:path,async:false});
				
				if(htmlobj.responseText == 0){
				 alert("Invoice already saved for this Supplier");
				 return false;
				}
	
	
			if (loop > 1)
			{
				alert("There are two or more suppliers put the same invoice number ! Please select the supplier from list !");
				var have2sup = 'true';
			}
			
			GetSupplierInvoiceDetails(have2sup);
		}		
	}

	
}

function GetSupplierInvoiceDetails(have2sup)
{
	var InvNo = document.getElementById("txtinvno").value;
		InvNo =InvNo.trim();
		
	var SupId = document.getElementById("cbosupplier").value;
	
	strPaymentType=document.getElementById("cboPymentType").value
	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr ;
	altxmlHttpArray[incr].have2sup = have2sup;
	altxmlHttpArray[incr].onreadystatechange = HandleGetSupplierInvoiceDetails;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=GetSupplierInvoiceDetails&strPaymentType=' + strPaymentType + '& InvoiceNo=' + InvNo + '&SupplierId=' + SupId,true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function HandleGetSupplierInvoiceDetails()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
			//alert(altxmlHttpArray[this.index].responseText);
			
			var XMLCompId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("CompId");
			var XMLCompNm = altxmlHttpArray[this.index].responseXML.getElementsByTagName("CompNm");
			var XMLCompCd = altxmlHttpArray[this.index].responseXML.getElementsByTagName("CompCd");
			var XMLAccPacID = altxmlHttpArray[this.index].responseXML.getElementsByTagName("AccPacID");
			var XMLPOCurrency = altxmlHttpArray[this.index].responseXML.getElementsByTagName("POCurrency");
			var XMLCreditDays = altxmlHttpArray[this.index].responseXML.getElementsByTagName("CreditDays");
			
			RemoveCurrentCombo("cbocompany");
					
			for ( var loop = 0; loop < XMLCompId.length; loop++)
			{
				var opt = document.createElement("option");
				opt.text = XMLCompNm[loop].childNodes[0].nodeValue;
				opt.value = XMLCompCd[loop].childNodes[0].nodeValue;
				document.getElementById("cbocompany").options.add(opt);
				
				document.getElementById("txtcompid").value = XMLCompId[loop].childNodes[0].nodeValue;
				
				document.getElementById("txtaccpacid").value = XMLAccPacID[loop].childNodes[0].nodeValue;
				
				/* Select Supplier Currency */
				var optCombo1 = document.getElementById("cbocurrency").options;
				
				for (var i = 0; i < optCombo1.length; i++)
				{ 	//alert( XMLPOCurrency[loop].childNodes[0].nodeValue);
					if(optCombo1[i].text == XMLPOCurrency[loop].childNodes[0].nodeValue)
					{
						//alert(optCombo1[i].text);
						//alert(optCombo1[i].index);
						document.getElementById("cbocurrency").options.selectedIndex = optCombo1[i].index;
						getCurrencyRate();
					}
				}
				
				/* Select Supplier CreditPeriod */
				var optCombo2 = document.getElementById("cbocreditprd").options;
				
				for (var y = 0; y < optCombo2.length; y++)
				{
					//alert(XMLCreditDays[loop].childNodes[0].nodeValue);
					if(optCombo2[y].value == XMLCreditDays[loop].childNodes[0].nodeValue)
					{
//						alert(optCombo2[y].value);
//						alert(optCombo2[y].text);
//						alert(optCombo2[y].index);
						document.getElementById("cbocreditprd").options.selectedIndex = optCombo2[y].index;
						CreditDueDate();
					}
				}
			}
			//return false;
			loadInvDet();///
			
			LoadSupplierGL();
			
			totGRNAmount = 0;
			
			//InvoicePayable(altxmlHttpArray[this.index].have2sup);
			
			LoadPoDetails();
			
			genDescription();
			
			ShowAllTax();
			
			
		}		
	}
}
//lasanhta ------------ Load other Inv Details-----------------------------------------------------------
//Commission-Entry No-Freight-Insurance-other-Vat GL Acc
function loadInvDet(){
	
	var invNo=document.getElementById('txtinvno').value.trim();
	var path="supplierInvXML.php?RequestType=loadInvOther&invNo="+invNo;
	//alert(path);
	htmlobj=$.ajax({url:path,async:false});
	
		var XMLCommission	=htmlobj.responseXML.getElementsByTagName("Commission");
		var XMLEntryNo		=htmlobj.responseXML.getElementsByTagName("EntryNo");
		//var XMLLineNo		=htmlobj.responseXML.getElementsByTagName("LineNo");
		var XMLFreight		=htmlobj.responseXML.getElementsByTagName("Freight");
		var XMLInsurance	=htmlobj.responseXML.getElementsByTagName("Insurance");
		var XMLOther		=htmlobj.responseXML.getElementsByTagName("Other");
		var XMLVATGLAcc		=htmlobj.responseXML.getElementsByTagName("VATGLAcc");
	if(XMLCommission.length > 0){
		document.getElementById("txtcommission").value=XMLCommission[0].childNodes[0].nodeValue;
	}
	if(XMLEntryNo.length > 0){
		document.getElementById("txtentryno").value=XMLEntryNo[0].childNodes[0].nodeValue;
	}
		//document.getElementById("txtlineno").value=XMLLineNo[0].childNodes[0].nodeValue;
	if(XMLFreight.length > 0){
		document.getElementById("txtfreight").value=XMLFreight[0].childNodes[0].nodeValue;
	}
	if(XMLInsurance.length > 0){
		document.getElementById("txtinsurance").value=XMLInsurance[0].childNodes[0].nodeValue;
	}
	if(XMLOther.length > 0){
		document.getElementById("txtother").value=XMLOther[0].childNodes[0].nodeValue;
	}
	if(XMLVATGLAcc.length > 0){
		document.getElementById("txtvatgl").value=XMLVATGLAcc[0].childNodes[0].nodeValue;
	}
}
//--------------------------------------END-------------------------------------------------------------
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

//Load Currency Types
function LoadCurrency(invNo)
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleLoadCurrency;
	xmlHttp.open("GET",'supplierInvXML.php?RequestType=LoadCurrency&strPaymentType=N&invNo='+invNo,true);
	xmlHttp.send(null);
}

function HandleLoadCurrency()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var XMLCurrCd = xmlHttp.responseXML.getElementsByTagName("CurrCd");
			var XMLCurrDesc = xmlHttp.responseXML.getElementsByTagName("CurrDesc");
			var XMLRate = xmlHttp.responseXML.getElementsByTagName("Rate");
			
			//RemoveCurrentCombo("cbocurrency");

			/*for ( var loop = 0; loop < XMLCurrCd.length; loop ++)
			{
				var opt = document.createElement("option");
				opt.text = XMLCurrCd[loop].childNodes[0].nodeValue;
				opt.value = XMLCurrCd[loop].childNodes[0].nodeValue;
				document.getElementById("cbocurrency").options.add(opt);
				document.getElementById("txtcurrate").value=XMLCurrCd[loop].childNodes[0].nodeValue;
			}*/
			//alert(XMLCurrCd[0].childNodes[0].nodeValue);
			if(XMLCurrCd.length>0){
				document.getElementById("cbocurrency").value=XMLCurrCd[0].childNodes[0].nodeValue;
				document.getElementById("txtcurrate").value=XMLRate[0].childNodes[0].nodeValue;
			}
			
		}		
	}
}

function getCurrencyRate()//lasantha
{
	var CurrRate = document.getElementById("cbocurrency").value.trim();
	//document.getElementById("txtcurrate").value = CurrRate ;
	var path="supplierInvXML.php?RequestType=loadCurrate&currID="+CurrRate;
	
	htmlobj=$.ajax({url:path,async:false});
	var XMLCurRate	=htmlobj.responseXML.getElementsByTagName("Rate");
	document.getElementById("txtcurrate").value="";
	document.getElementById("txtcurrate").value=XMLCurRate[0].childNodes[0].nodeValue;
}

//Load Credit Periods
function LoadCreditPeriod()
{
/*	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr ;
	altxmlHttpArray[incr].onreadystatechange = HandleLoadCreditPeriod;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=LoadCreditPeriod&strPaymentType=N',true);
	altxmlHttpArray[incr].send(null);
	incr++;*/
	
	var url   = 'supplierInvXML.php?RequestType=LoadCreditPeriod&strPaymentType=N';
	htmlobj   = $.ajax({url:url,async:false});	
	
	document.getElementById("cbocreditprd").innerHTML = htmlobj.responseText;
}

function HandleLoadCreditPeriod()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
			var XMLCreditPrd = altxmlHttpArray[this.index].responseXML.getElementsByTagName("CreditPrd");
			var XMLNoOfDays = altxmlHttpArray[this.index].responseXML.getElementsByTagName("NoOfDays");
			
			RemoveCurrentCombo("cbocreditprd");
			
			//opt.text = "";
			//opt.value ="";
				
			for ( var loop = 0; loop < XMLCreditPrd.length; loop ++)
			{
				var opt = document.createElement("option");
				opt.text = XMLCreditPrd[loop].childNodes[0].nodeValue;
				opt.value = XMLNoOfDays[loop].childNodes[0].nodeValue;
				document.getElementById("cbocreditprd").options.add(opt);
			}
		}		
	}
}

//Load Batch Numbers & Descriptions
function LoadBatch()
{
/*	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = HandleLoadBatch;
	altxmlHttp.open("GET",'supplierInvXML.php?RequestType=LoadBatch&strPaymentType=N',true);
	altxmlHttp.send(null);*/
		var url   = 'supplierInvXML.php?RequestType=LoadBatch&strPaymentType=N';
		htmlobj   = $.ajax({url:url,async:false});	
		
		document.getElementById("cbobatch").innerHTML = htmlobj.responseText;
}

function HandleLoadBatch()
{
	if(altxmlHttp.readyState == 4) 
    {
        if(altxmlHttp.status == 200) 
        {
			var XMLBatchId = altxmlHttp.responseXML.getElementsByTagName("BatchId");
			var XMLBatchDesc = altxmlHttp.responseXML.getElementsByTagName("BatchDesc");
			
			//RemoveCurrentCombo("cbobatch");
			
			var opt = document.createElement("option");
			opt.text = "";
			opt.value = "";
			document.getElementById("cbobatch").options.add(opt);

			for ( var loop = 0; loop < XMLBatchId.length; loop ++)
			{
				var opt = document.createElement("option");
				opt.text = XMLBatchDesc[loop].childNodes[0].nodeValue;
				opt.value = XMLBatchId[loop].childNodes[0].nodeValue;
				document.getElementById("cbobatch").options.add(opt);
			}
		}		
	}
}

// Load Supplier GL Accounts
function LoadSupplierGL()
{
	var SupID = document.getElementById("cbosupplier").value;
	var FacCd = document.getElementById("cbocompany").value;
	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleLoadSupplierGL;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=LoadSupplierGL&strPaymentType=N&SupplierId=' + SupID + '&FactoryCode=' + FacCd,true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function HandleLoadSupplierGL()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
        	var XMLBTNo	   = altxmlHttpArray[this.index].responseXML.getElementsByTagName("BTNO");
        	if(XMLBTNo.length > 0){
        	document.getElementById('cbobatch').value=XMLBTNo[0].childNodes[0].nodeValue;
        	}
			var XMLGLAccId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccId");
			var XMLGLAccDesc = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccDesc");
			var XMLSelected = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Selected");
			
			var tableText = "<table width=\"560\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblglaccounts\"> " +
                  				"<tr><td width=\"39\" height=\"22\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td> " +
                    			"<td width=\"102\" bgcolor=\"#498CC2\" class=\"grid_header\">GL Acc Id</td>" +
                    			"<td width=\"302\" bgcolor=\"#498CC2\" class=\"grid_header\">Description</td>" +
                    			"<td width=\"115\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>" +
                    			"</tr>";

				for(var loop = 0; loop < XMLGLAccId.length; loop++)
				{
					var rowColor = ''
					if((loop % 2)==0)
						rowColor = "grid_raw";
					else
						rowColor = "grid_raw2";
						
					var selection = "";
					var GLAmt = 0 ;
					
					if (XMLSelected[loop].childNodes[0].nodeValue == "True")
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
					else
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckTextBox(this);\" />";
			
						tableText += "<tr >"+
									"<td class=\""+rowColor+"\" class=\"normalfnt\"><div align=\"center\">"+ selection +"</div></td>" +
									"<td class=\""+rowColor+"\" class=\"normalfnt\" id=\"" + XMLGLAccId[loop].childNodes[0].nodeValue + "\" style=\"text-align:left;\">" + XMLGLAccId[loop].childNodes[0].nodeValue + "</td>" +
									"<td class=\""+rowColor+"\" class=\"normalfnt\" id=\"" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "\" style=\"text-align:left;\">" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "</td>" +
									"<td class=\""+rowColor+"\" class=\"normalfnt\"><input type=\"text\" id=\"glamount\" name=\"glamount\" class=\"txtbox\" style=\"width:100px; text-align: right;\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" value=\""+ GLAmt +"\"> " +
									"</input></td>" +
									"</tr>";
				}
				tableText += "</table>";
				//alert(tableText);
				document.getElementById("divcons").innerHTML = tableText;
		}
	}
}

//Clear GL Accounts Table Data
function ClearTableData()
{
	var tableText = "<table width=\"560\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblglaccounts\"> " +
                  				"<tr><td width=\"39\" height=\"22\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td> " +
                    			"<td width=\"102\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GL Acc Id</td>" +
                    			"<td width=\"302\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>" +
                    			"<td width=\"115\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Amount</td>" +
                    			"</tr></table>";
	document.getElementById("divcons").InnerHTML = tableText;
}

function checkInvoiceBalence()
{
	var SupID = document.getElementById("cbosupplier").value;
	var InvNo = document.getElementById("txtinvno").value;
		InvNo =InvNo.trim();
		strPaymentType=document.getElementById("cboPymentType").value
	
		createXMLHttpCheckInvBalance() ;
		XMLHttpCheckInvBalance.onreadystatechange = HandleCheckInvoiceBalence;
		XMLHttpCheckInvBalance.open("GET", 'supplierInvXML.php?RequestType=getInvoiceBalance&strPaymentType=' + strPaymentType + '&SupplierId=' + SupID + '&InvoiceNo=' + InvNo,true);
		XMLHttpCheckInvBalance.send(null); 
		
}

function HandleCheckInvoiceBalence()
{	
	if(XMLHttpCheckInvBalance.readyState == 4) 
    {
	   if(XMLHttpCheckInvBalance.status == 200) 
        {  
			var XMLInvNo = XMLHttpCheckInvBalance.responseXML.getElementsByTagName("invNo");
			if(XMLInvNo.length>0)
			{
				var invNo = XMLInvNo[loop].childNodes[0].nodeValue;	
			}
			 
			 
		}
	}
}

// Calculate Invoice Payable Data
function InvoicePayable(have2sup)
{
	var SupID = document.getElementById("cbosupplier").value;
	var InvNo = document.getElementById("txtinvno").value;
		InvNo =InvNo.trim();
		strPaymentType=document.getElementById("cboPymentType").value
	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleInvoicePayable;
	altxmlHttpArray[incr].have2sup = have2sup;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=InvoicePayable&strPaymentType=' + strPaymentType + '&SupplierId=' + SupID + '&InvoiceNo=' + InvNo,true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function toNum(value)
{
	if(isNaN(value))
		value = 0;
	else if(value='')
		value = 0;
	else
		value = parseFloat(value);
	
	return value;
}
function HandleInvoicePayable()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
			
			var XMLInvoiceNo = altxmlHttpArray[this.index].responseXML.getElementsByTagName("InvoiceNo");
			//var XMLGrnQty = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GrnQty");
			//var XMLUnitPrice = altxmlHttpArray[this.index].responseXML.getElementsByTagName("UnitPrice");
			var XMLgrnAmount = altxmlHttpArray[this.index].responseXML.getElementsByTagName("grnAmount");
			var XMLPaidAmount = altxmlHttpArray[this.index].responseXML.getElementsByTagName("invoiceAmount");
			var XMLCurrency = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Currency");InvoiceNo
			var PaidAmount=0;
			var InvoiceNo="";
			
			
			for(var loop = 0; loop < XMLInvoiceNo.length; loop++)
			{
				if(InvoiceNo=="")
				{
					InvoiceNo=XMLInvoiceNo[loop].childNodes[0].nodeValue;
				}
				else
				{
					InvoiceNo+= " / " + XMLInvoiceNo[loop].childNodes[0].nodeValue;
				}
				var Currency= XMLCurrency[0].childNodes[0].nodeValue;
				//var GrnQty = XMLGrnQty[loop].childNodes[0].nodeValue;
				//var UnitPrice = XMLUnitPrice[loop].childNodes[0].nodeValue;
				//alert(XMLPaidAmount[0].childNodes[0].nodeValue);
					//var tempPaid = 
					//if(isNull(tempPaid))
						//alert("this is NaN ("+tempPaid);
					PaidAmount=parseFloat(XMLPaidAmount[loop].childNodes[0].nodeValue);
				//alert(PaidAmount);
				totGRNAmount = totGRNAmount+ parseFloat(XMLgrnAmount[loop].childNodes[0].nodeValue);
				//alert(totGRNAmount);
			}
				
			pub_grnBalance =parseFloat(totGRNAmount)-parseFloat(PaidAmount);
			//alert("total pub_grnBalance = "+pub_grnBalance);
			
			if(pub_poBalance < pub_grnBalance)
			{
				//pub_grnBalance = pub_poBalance; 
			}
			
			
			
			pub_grnBalance = pub_grnBalance.toFixed(2);
			//alert(pub_grnBalance);
			if(parseFloat(PaidAmount)>0)
			{
				var balamt=parseFloat(totGRNAmount)-parseFloat(PaidAmount)
				//alert(balamt);
				if(Currency=="USD")
				{
					balamt=new Number(balamt).toFixed(4);
				}
				else
				{
					balamt=new Number(balamt).toFixed(4);
				}
					
					
					
					if(balamt>0)
					{
			alert("Total GRN amount for this PO "+parseFloat(totGRNAmount)+"\n"+"You have entered invoice/s for "+ PaidAmount + " of " + Currency + ".The new entry allow only for the balence(" + parseFloat(balamt).toFixed(2) + ")")			
					
					//alert(pub_grnBalance);
					document.getElementById("txttotglamount").value 	= new Number(parseFloat(pub_grnBalance)-parseFloat(PaidAmount)).toFixed(2);
					//alert(document.getElementById("txttotglamount").value);
					
					//pub_grnBalance = new Number(parseFloat(totGRNAmount)-parseFloat(PaidAmount)).toFixed(2);
					
					//alert(document.getElementById("txttotglamount").value);
					//bookmark1
					
					//document.getElementById("txtRealAmount").value		= new Number(parseFloat(totGRNAmount)-parseFloat(PaidAmount)).toFixed(4);
					//before line comment by roshan 2009-10-19
					
					document.getElementById("txtinvoiceamount").value 	=  new Number(parseFloat(totGRNAmount)-parseFloat(PaidAmount)).toFixed(2);
					//alert(document.getElementById("txtinvoiceamount").value);
					
					}
					else
					{
						if(altxmlHttpArray[this.index].have2sup!='true')
						{
							alert("You have compleated this invoice for "+ PaidAmount + " of " + Currency + ".")
							clearControls()
							document.getElementById("txtinvno").focus();
							return;
						}
					}
			}
			else
			{
				//alert(pub_grnBalance);
				document.getElementById("txttotglamount").value 	= new Number(pub_grnBalance).toFixed(2);
				document.getElementById("txtinvoiceamount").value 	=  new Number(pub_grnBalance).toFixed(2);
			}
		}
	}
}

function clearControls()
{
	//bookmark 1
	document.getElementById('txtinvno').value=""
	document.getElementById('cbocompany').value=0
	document.getElementById('txtDescription').value=""
	
	var strgltbl="	<table width=\"560\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblglaccounts\">"+
		  "<tr>"+
			"<td width=\"39\" height=\"22\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td>"+
			"<td width=\"102\" bgcolor=\"#498CC2\" class=\"grid_header\">GL Acc Id</td>"+
			"<td width=\"302\" bgcolor=\"#498CC2\" class=\"grid_header\">Description</td>"+
			"<td width=\"115\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>"+
			"</tr>"+
		"</table>"
	document.getElementById('divcons').innerHTML=strgltbl
	
	var strpotbl="<table width=\"450\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblpodetails\">"+
	"<tr>"+
	"<td width=\"39\" height=\"22\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td>"+
	"<td width=\"22%\" height=\"22\" bgcolor=\"#498CC2\" class=\"grid_header\">PO NO </td>"+
	"<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Currency</td>"+
	"<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>"+
	"<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Balance</td>"+
	"<td width=\"15%\" bgcolor=\"#498CC2\" class=\"grid_header\">View</td>"+
	"</tr>"+
	"</table>"
	
	document.getElementById('divcons2').innerHTML=strpotbl
	
	
	var strpaymenttax = "<table width=\"450\" cellpadding=\"0\" cellspacing=\"0\" id=\"tbltaxdetails\">"+
						"<tr>"+
						"<td width=\"39\" height=\"22\" class=\"grid_header\">*</td>"+
						"<td width=\"208\" class=\"grid_header\">Tax</td>"+
						"<td width=\"87\" class=\"grid_header\">Rate</td>"+
						"<td width=\"103\" class=\"grid_header\">Amount</td>"+
						"</tr>"+
					"</table>";
	document.getElementById('divcons3').innerHTML=strpaymenttax;			
					//ShowAllTax()
	

	//document.getElementById('cbosupplier').value=0
	RemoveCurrentCombo("cbosupplier");
	RemoveCurrentCombo("cbocompany");
	
	document.getElementById('txttotglamount').value=""
	
	document.getElementById('txtcommission').value=""
	document.getElementById('txtcurrate').value=""
	document.getElementById('cbocurrency').value=0
	document.getElementById('txttottaxamount').value=""
	document.getElementById('txtinvoiceamount').value=""
	document.getElementById('txtentryno').value=""
	var myDate=new Date();
	document.getElementById('cbocreditprd').value=myDate
	document.getElementById('txtlineno').value=""
	document.getElementById('txtaccpacid').value="."
	document.getElementById('txtvatgl').value=""
	document.getElementById('txtother').value=""
	document.getElementById('txtinsurance').value=""
	document.getElementById('txtfreight').value=""
	
	document.getElementById('txtinvno').focus();
	
}
function validateGrnAmountVsGLAmount(GlAmt)
{
	var TotGLAmt = parseFloat(document.getElementById('txttotglamount').value);
	GlAmt = 0;
	
	var tbl = document.getElementById('tblglaccounts');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{
			GlAmt = parseFloat(GlAmt);
			var rwGlAmt = parseFloat(tbl.rows[loop].cells[3].childNodes[0].value);
			GlAmt = GlAmt + rwGlAmt;
			//GlAmt = round(GlAmt,2);
	
			if(TotGLAmt < GlAmt)
			{
				alert("Total GL value can not exceed Invoice Value!");
				//Sexy.alert('<h1>Invoice GL Valuation</h1><p>Total GL value can not bee exceed Invoice Value!</p>');return false;
				tbl.rows[loop].cells[3].childNodes[0].value = 0;
			}
		}
	}
	if (TotGLAmt != GlAmt)
	{
		//alert("Total invoice value has been put into GL Accounts !");
		//Sexy.alert('<h1>Invoice GL Valuation</h1><p>Total invoice value has been put into GL Accounts !</p>');return false;
		//document.getElementById('txtcommission').focus();
	}
	else if(TotGLAmt > GlAmt)
	{
		alert("Total GL value not tally with Invoice Value!" + "\n" + "You have to put more: " + (TotGLAmt - GlAmt) + " in to Gl Accounts !");
		//var remainAmt = TotGLAmt - GlAmt ;
		//Sexy.alert('<h1>Invoice GL Valuation</h1><p>Total GL value not tally with Invoice Value!" + "\n" + "You have to put more: " + (TotGLAmt - GlAmt) + " in to Gl Accounts !</p>');return false;
		
		//tbl.rows[loop].cells[3].childNodes[0].focus();
	}		
}

function Commission()
{
	var txttotglamount = parseFloat(document.getElementById('txttotglamount').value);
	var commission = parseFloat(document.getElementById('txtcommission').value);
	var totinvamt = txttotglamount - commission;
	
	document.getElementById('txtinvoiceamount').value = totinvamt;
}

function CreditDueDate()
{
	var invoiceDate = document.getElementById('cboinvdate').value;
	var creditPeriod = document.getElementById('cbocreditprd').value;
	
	if(creditPeriod != "")
	{
		var invDt = new Date(parseInt(invoiceDate.split("/")[2].split(" ")[0]),parseInt(invoiceDate.split("/")[1])-1,parseInt(invoiceDate.split("/")[0]) );
	

		var dueDate = invDt.setDate(invDt.getDate() + parseInt(creditPeriod));
		var newDate=invoiceDate+creditPeriod;		
		dueDate = (invDt.getDate())  + "/" + (invDt.getMonth() + 1)  + "/" + (invDt.getYear() + 1900) ;
		document.getElementById("txtdatedue").value = dueDate;
	}
}

function LoadPoDetails()
{
	var SupID = document.getElementById("cbosupplier").value;
	var InvNo = document.getElementById("txtinvno").value;
		InvNo =InvNo.trim();
		
	strPaymentType=document.getElementById("cboPymentType").value
	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleLoadPoDetails;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=LoadPoDetails&strPaymentType=' + strPaymentType + '&SupplierId=' + SupID + '&InvoiceNo=' + InvNo,true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function HandleLoadPoDetails()
{
	if (altxmlHttpArray[this.index].readyState == 4)
	{
		if (altxmlHttpArray[this.index].status == 200)
		{			
			//alert(1);
			var XMLPONo = altxmlHttpArray[this.index].responseXML.getElementsByTagName("PO");
			var XMLCurrency = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Currency");
			var XMLPOAmount = altxmlHttpArray[this.index].responseXML.getElementsByTagName("POAmount");
			var XMLPOBalance = altxmlHttpArray[this.index].responseXML.getElementsByTagName("POBalance");
			var XMLSelected = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Selected");
			var XMLgrnBalance = altxmlHttpArray[this.index].responseXML.getElementsByTagName("grnBalance");
			var XMLinvoiceAmount = altxmlHttpArray[this.index].responseXML.getElementsByTagName("invoiceAmount");
			//alert(123);
			tableText = "<table width=\"450\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblpodetails\">"  +
						"<tr>"+
							 "<td width=\"39\" height=\"22\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td>" +
							 "<td width=\"22%\" bgcolor=\"#498CC2\" class=\"grid_header\">PO NO</td>" +
              				 "<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Currency</td>" +
              				 "<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>" + 
              				 "<td width=\"18%\" bgcolor=\"#498CC2\" class=\"grid_header\">Balance</td>" +
              				 "<td width=\"8%\" bgcolor=\"#498CC2\" class=\"grid_header\">PO</td>" +
							 "<td width=\"8%\" bgcolor=\"#498CC2\" class=\"grid_header\">ADV</td>" +
							 "<td width=\"8%\" bgcolor=\"#498CC2\" class=\"grid_header\">Excess</td>" +
							 "<td width=\"8%\" bgcolor=\"#498CC2\" class=\"grid_header\">PO/GRN</td>" +
						 "</tr>";
			
			var selType=document.getElementById("cboPymentType").value;
			
//			alert(XMLPONo.length)
			var poBalance = 0;
			var grnBalance = 0;
			var invBalance=0;
			var txtinvno = document.getElementById('txtinvno').value;
			for(var loop = 0; loop < XMLPONo.length ; loop++)
			{
				var PONo = XMLPONo[loop].childNodes[0].nodeValue;
				var Currency = XMLCurrency[loop].childNodes[0].nodeValue;
				var POAmount = XMLPOAmount[loop].childNodes[0].nodeValue;
				var x = parseFloat(XMLPOBalance[loop].childNodes[0].nodeValue);
				var invAmount = parseFloat(XMLinvoiceAmount[loop].childNodes[0].nodeValue);
				var earlySavedInvAmt = parseFloat(XMLinvoiceAmount[loop].childNodes[0].nodeValue);
				//alert(earlySavedInvAmt);
				if(isNaN(earlySavedInvAmt) == true){
				earlySavedInvAmt = 0;	
				}
				arrearlySavedInvAmt.push(earlySavedInvAmt);	
				
				if(x>0)
					poBalance +=x;
					//alert(poBalance);
					
				var y = parseFloat( XMLgrnBalance[loop].childNodes[0].nodeValue );
				if(y>0)
					grnBalance +=y;
					//alert(y);
					
				if(poBalance<grnBalance)
					pub_grnBalance  = poBalance.toFixed(2);
				else
					pub_grnBalance =grnBalance.toFixed(2);
				
				//alert(grnBalance);
				var selection = XMLSelected[loop].childNodes[0].nodeValue;
				
				///pub_poBalance +=parseFloat(POBalance);
				
				var POr = PONo.split("/");
				
				//alert (PONo)
				if (selection == "True")
				{
					selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
				}
				else
				{
					selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" />";
				}
				
				var rowColor = ''
					if((loop % 2)==0)
						rowColor = "grid_raw";
					else
						rowColor = "grid_raw2";
						
				tableText += "<tr>"+
							 "<td class=\""+rowColor+"\"><div align=\"center\">"+ selection +"</div></td>" +
							 "<td class=\""+rowColor+"\">"+ PONo +"</td>" +
              				 "<td class=\""+rowColor+"\" style=\"text-align:left;\">"+ Currency +"</td>" +
              				 "<td class=\""+rowColor+"\" style=\"text-align:right;\">"+ parseFloat(POAmount).toFixed(2) +"</td>" +  
              				 "<td class=\""+rowColor+"\" style=\"text-align:right;\">"+ parseFloat(x).toFixed(2) +"</td>"

							 tableText +="<td class=\""+rowColor+"\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\"                                          onclick=\"loadPo(this)\" /></div></td>"
							 tableText +="<td class=\""+rowColor+"\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\"                                          onclick=\"viewGrnPopUp("+loop+");\" /></div></td>"
							 tableText +="<td class=\""+rowColor+"\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\"                                          onclick=\"viewExcessPopUp("+loop+");\" /></div></td>"
							 tableText +="<td class=\""+rowColor+"\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\"                                          onclick=\"viewPOGRNLIST("+loop+");\" /></div></td>"
							 
							 tableText +="</tr>";
				}

				if(isNaN(invAmount)){
				invAmount=0;		 
		        }
				//alert(invAmount);
				//alert(grnBalance);
				if(invAmount>0)
					grnBalance-=invAmount;
				
				if(grnBalance < 0){
					grnBalance = 0;
				}
			if(! isNaN(invAmount) && invAmount>0)
			alert("Total GRN amount for this PO ( "+(parseFloat(invAmount)+grnBalance)+" )\n"+"You have entered invoice/s for ( "+ invAmount + " ).The new entry allow only for the balance( " + roundNumber(grnBalance,2) + " )")		
							//alert(poBalance);
							//alert(grnBalance);
				if(parseFloat(poBalance)<parseFloat(grnBalance))
				{
						grnBalance = poBalance;
				}
				
				//alert(Math.round(grnBalance*100)/100);
				document.getElementById("txttotglamount").value = roundNumber(grnBalance,2);//ok
				document.getElementById("txtinvoiceamount").value = roundNumber(grnBalance,2);
				
				tableText += "</table>";
				document.getElementById("divcons2").innerHTML = tableText;
		}	
	}
}

function loadPo(obj)
{	
	var row=obj.parentNode.parentNode.parentNode
	var cells=row.getElementsByTagName("TD")
	var POr = cells[1].innerHTML.split("/");

	var selType=document.getElementById("cboPymentType").value;
	
	if(selType=="G")
	{
		var path="../GeneralInventory/GeneralPO/generalPurchaeOrderReport.php?bulkPoNo=" + POr[1] + "&intYear=" + POr[0]
	}
	
	else if(selType=="S")
	{
		var path="../reportpurchase.php?pono=" + POr[1] + "&year=" + POr[0]
	}
	window.open(path)
}

function LoadCreditDebit()
{
	var SupID = document.getElementById("cbosupplier").value;
	var InvNo = document.getElementById("txtinvno").value;
		InvNo =InvNo.trim();
		
	strPaymentType=document.getElementById("cboPymentType").value
	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleLoadCreditDebit;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=LoadCreditDebit&strPaymentType=' + strPaymentType + '&SupplierId=' + SupID + '&InvoiceNo=' + InvNo,true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function HandleLoadCreditDebit()
{
	if (altxmlHttpArray[this.index].readyState == 4)
	{
		if (altxmlHttpArray[this.index].status == 200)
		{			
			var XMLType = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Type");
			var XMLDocNo = altxmlHttpArray[this.index].responseXML.getElementsByTagName("DocNo");
			var XMLCdDate = altxmlHttpArray[this.index].responseXML.getElementsByTagName("CdDate");
			var XMLTotal = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Total");
			var XMLAmount = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Amount");
			var XMLTax = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Tax");
			
			var tableText = "<table width=\"900\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblcreditdebit\">" +
            			"<tr>" +
              			"<td width=\"23%\" height=\"22\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Type</td>" +
              			"<td width=\"18%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Doc No</td>" +
              			"<td width=\"19%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>" +
              			"<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Total</td>" +
              			"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Amount</td>" +
              			"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Tax</td>" +
              			"</tr>";
			for(var loop = 0; loop < XMLType.length ; loop++)
			{			
				tableText += "<tr>" +
							"<td width=\"23%\" height=\"22\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">"+ XMLType[loop].childNodes[0].nodeValue +"</td>" +
							"<td width=\"18%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">"+ XMLDocNo[loop].childNodes[0].nodeValue +"</td>" +
							"<td width=\"19%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">"+ XMLCdDate[loop].childNodes[0].nodeValue +"</td>" +
							"<td width=\"14%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">"+ XMLTotal[loop].childNodes[0].nodeValue +"</td>" +
							"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">"+ XMLAmount[loop].childNodes[0].nodeValue +"</td>" +
							"<td width=\"13%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">"+ XMLTax[loop].childNodes[0].nodeValue +"</td>" +
							"</tr>";							
			}
				tableText += "</table>";
				document.getElementById("divcons1").innerHTML = tableText;
		}	
	}
}


function ShowAllGLAccounts()
{
	var SupID = document.getElementById("cbosupplier").value;
	var FacCd = document.getElementById("cbocompany").value;
	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleShowAllGLAccounts;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=ShowAllGLAccounts&strPaymentType=N&SupplierId=' + SupID + '&FactoryCode=' + FacCd,true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function ShowAllTax()
{
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index=incr;
	altxmlHttpArray[incr].onreadystatechange = HandleShowAllTax;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=ShowAllTax&strPaymentType=N',true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function HandleShowAllTax()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
			var XMLTaxID = altxmlHttpArray[this.index].responseXML.getElementsByTagName("TaxID");
			var XMLTaxType = altxmlHttpArray[this.index].responseXML.getElementsByTagName("TaxType");
			var XMLTaxRate = altxmlHttpArray[this.index].responseXML.getElementsByTagName("TaxRate");
			var XMLSelected = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Selected");
			
			taxText = "<table width=\"450\" cellpadding=\"0\" cellspacing=\"0\" id=\"tbltaxdetails\">"+					
						"<tr>"+
			  			"<td width=\"39\" height=\"22\" bgcolor=\"#498CC2\" class=\"grid_header\">*</td>"+
			  			"<td width=\"208\" bgcolor=\"#498CC2\" class=\"grid_header\">Tax</td>"+
			  			"<td width=\"87\" bgcolor=\"#498CC2\" class=\"grid_header\">Rate</td>"+
			  			"<td width=\"103\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>"
			  			"</tr>";
			for(var loop = 0; loop < XMLTaxID.length ; loop++)
			{
//				var TaxID = XMLTaxID[loop].childNodes[0].nodeValue;
//				var TaxType = XMLTaxType[loop].childNodes[0].nodeValue;
//				var TaxRate = XMLTaxRate[loop].childNodes[0].nodeValue;
				
				var selection = "";
				
				if (XMLSelected[loop].childNodes[0].nodeValue == "True")
					selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
				else
					selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckCheckBox(this);\" />";
					
				/*tableText += "<tr>"+
			  				 "<td class=\"normalfnt\"><div align=\"center\">"+ selection +"</div></td>"+
			  				 "<td class=\"normalfnt\" id=\""+  XMLTaxID[loop].childNodes[0].nodeValue +"\">"+ XMLTaxType[loop].childNodes[0].nodeValue +"</td>"+
			  				 "<td class=\"normalfntMidSML\">"+  XMLTaxRate[loop].childNodes[0].nodeValue +"</td>"+
"<td class=\"normalfntRite\"><input type=\"text\" id=\"taxamount\" name=\"taxamount\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event);\" onchange=\"calculateTaxAmount();\" value=\""+ 0 +"\"  readonly=\"true\">" +
							"</input></td>"+
			  				"</tr>";*/
							
					var rowColor = ''
					if((loop % 2)==0)
						rowColor = "grid_raw";
					else
						rowColor = "grid_raw2";
						
						
					taxText += "<tr>"+
			  				 "<td class=\""+rowColor+"\"><div align=\"center\">"+ selection +"</div></td>"+
			  				 "<td class=\""+rowColor+"\" id=\""+  XMLTaxID[loop].childNodes[0].nodeValue +"\" style=\"text-align:left;\">"+ XMLTaxType[loop].childNodes[0].nodeValue +"</td>"+
			  				 "<td class=\""+rowColor+"\" style=\"text-align:right;\">"+  XMLTaxRate[loop].childNodes[0].nodeValue +"</td>"+
"<td class=\""+rowColor+"\"><input type=\"text\" id=\"taxamount\" name=\"taxamount\" class=\"txtbox\" style=\"width:100px;text-align:right;\" align =\"right\" onkeypress=\"return isNumberKey(event);\" value=\""+ 0 +"\" >" +
							"</input></td>"+
			  				"</tr>";
				}
				taxText += "</table>";
				//alert(tableText);
				document.getElementById("divcons3").innerHTML = taxText;
		}
	}
}

function checkUncheckCheckBox(objevent)
{
	var tbl = document.getElementById('tbltaxdetails');
	var rw = objevent.parentNode.parentNode.parentNode;
	
	if (rw.cells[0].childNodes[0].childNodes[0].checked)
	{
		calculateTaxAmount();
		CalculateTotalInvoiceAmount();
	}
	else
	{
		//calculateTaxAmountRevise();
		calculateTaxAmount();
		CalculateTotalInvoiceAmount();
		rw.cells[3].childNodes[0].value=0.00;
	}
}

function calculateTaxAmount()
{
	var TotGRNAmt = parseFloat(document.getElementById('txttotglamount').value);
	var TaxAmt = new Number(0);
	
	var tbl = document.getElementById('tbltaxdetails');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{
			var TaxRate = parseFloat(tbl.rows[loop].cells[2].childNodes[0].nodeValue);
			var rwTaxAmt = new Number(((TotGRNAmt/100) * TaxRate));
			tbl.rows[loop].cells[3].childNodes[0].value = rwTaxAmt.toFixed(4);
			TaxAmt = TaxAmt + rwTaxAmt;
		}
	}
	document.getElementById('txttottaxamount').value = TaxAmt.toFixed(4);
}

function calculateTaxAmountRevise()
{
	var TotGRNAmt = parseFloat(document.getElementById('txttotglamount').value);
	var TaxAmt = new Number(0);
	
	var tbl = document.getElementById('tbltaxdetails');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
			var TaxRate = parseFloat(tbl.rows[loop].cells[2].childNodes[0].nodeValue);
			var rwTaxAmt = new Number(((TotGRNAmt/100) * TaxRate));
			var rwTaxAmtMin =  new Number(((TotGRNAmt/100) * TaxRate) * -1)
			tbl.rows[loop].cells[3].childNodes[0].value = rwTaxAmt.toFixed(4);
			TaxAmt = TaxAmt + (rwTaxAmtMin * -1);
	}
	document.getElementById('txttottaxamount').value = TaxAmt.toFixed(4);
}


function CalculateTotalInvoiceAmount()
{
	//var TotInvoiceAmt = parseFloat(document.getElementById('txtinvoiceamount').value);
	
	var TotGrnAmt = parseFloat(document.getElementById('txttotglamount').value);
	var TotTaxAmt = parseFloat(document.getElementById('txttottaxamount').value);
	var TotInsurance = parseFloat(document.getElementById('txtinsurance').value);
	var TotOther = parseFloat(document.getElementById('txtother').value);
	var TotVATGlAcc = parseFloat(document.getElementById('txtvatgl').value);
	var TotFreightChg = parseFloat(document.getElementById('txtfreight').value);
	var TotCommission = parseFloat(document.getElementById('txtcommission').value);
	
	if(isNaN(TotGrnAmt))
	{TotGrnAmt=0;}else{TotGrnAmt=TotGrnAmt;}
	if(isNaN(TotTaxAmt))
	{TotTaxAmt=0;}else{TotTaxAmt=TotTaxAmt;}
	if(isNaN(TotInsurance))
	{TotInsurance=0;}else{TotInsurance=TotInsurance;}
	if(isNaN(TotOther))
	{TotOther=0;}else{TotOther=TotOther;}
	if(isNaN(TotVATGlAcc))
	{TotVATGlAcc=0;}else{TotVATGlAcc=TotVATGlAcc;}
	if(isNaN(TotFreightChg))
	{TotFreightChg=0;}else{TotFreightChg=TotFreightChg;}
	if(isNaN(TotCommission))
	{TotCommission=0;}else{TotCommission=TotCommission;}
	var TotInvoiceAmt = new Number((TotGrnAmt + TotTaxAmt + TotInsurance + TotOther + TotVATGlAcc + TotFreightChg) - TotCommission);
	
	//var TotAmtWithFreight = new Number(TotInvoiceAmt + TotFreightChg);
	//document.getElementById('txtinvoiceamount').value = TotAmtWithFreight.toFixed(2);
	document.getElementById('txtinvoiceamount').value = TotInvoiceAmt.toFixed(2);
	
}

function checkUncheckTextBox(objevent)
{
	var tbl = document.getElementById('tblglaccounts');
	var rw = objevent.parentNode.parentNode.parentNode;
	
	if (rw.cells[0].childNodes[0].childNodes[0].checked)
	{
		rw.cells[3].childNodes[0].value = "0";
	}
	else if(rw.cells[0].childNodes[0].childNodes[0].checked == false) 
	{
		rw.cells[3].childNodes[0].value = "";
	}
}

function isNumberKey(evt)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
		
	  for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }

	 if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
		return false;

	 return true;
}
function checkMaxGrn()
{
	//alert(1);
	var dblvalue = parseFloat(document.getElementById("txttotglamount").value);
	//alert(dblvalue);
	
	if(pub_grnBalance <dblvalue)
	{
			alert("You can't exceed grn amount of "+pub_grnBalance);
			document.getElementById("txttotglamount").value = pub_grnBalance;
			document.getElementById("txtinvoiceamount").value = pub_grnBalance;
	}
}

function setBalance()
{
	document.getElementById('cbocurrency').options.selectedIndex;
	var strCurrency = document.getElementById("tblglaccounts").value=document.getElementById('cbocurrency').options[CurIndex].text
}

function SaveInvoice()			// Save Invoice 
{ 



	if(document.getElementById('txtinvno').value.trim()==""){
		alert("Please enter \"Invoice No\".");
		return false;
	}//txtcurrate
	if((document.getElementById('cbocurrency').value=='') || (document.getElementById('txtcurrate').value==''))
	{
		alert('Please select Currency Type.');	
		return false;
	}
	
    var glAmt=0;  
    var row=document.getElementById("tblglaccounts").getElementsByTagName("TR");
	if(row.length==2)
	{ 
		var cell=row[1].getElementsByTagName("TD")

		if(cell[1].innerHTML!="" && cell[0].childNodes[0].childNodes[0].checked == true)
		{
			
			cell[3].firstChild.value=document.getElementById("txttotglamount").value;
		}else{
		 alert("Please Select a GL Account");
		 return false;
		}
		
		glAmt=parseFloat(document.getElementById("txttotglamount").value);
	}
	
	else if(row.length>2)
	{
		for(var loop=1;loop<row.length;loop++)
		{
			var cell=row[loop].getElementsByTagName("TD")
	
			if(cell[0].childNodes[0].childNodes[0].checked == true){
			glAmt=parseFloat(glAmt)+parseFloat(cell[3].firstChild.value);	
			}
		}
		//return false;
		var amountForGLTotal=parseFloat(document.getElementById('txttotglamount').value);
		if(parseFloat(amountForGLTotal)<parseFloat(glAmt))
		{
			alert("Please correctly assign the GL Amount.GL Amount can not be greater than amount of the invoice")	
			return false;
		}
		else if(parseFloat(amountForGLTotal)>parseFloat(glAmt))
		{
			alert("Please correctly assign the GL Amount.GL Amount can not be less than amount of the invoice")	
			return false;
		}
	}
	else
	{
		alert("Please assign the GL Account Details correctly.")
		document.getElementById('btnshowgl').focus();
		return false;
	}

//return false;
	if(document.getElementById("cbobatch").value==0)
	{
		alert("Please enter \"Batch No.\"")
		document.getElementById('cbobatch').focus();
		return false;
	}
	
	if(document.getElementById("txtinvoiceamount").value == "")
	{
		alert("Please enter valid amount to save!");
		document.getElementById('txtinvoiceamount').focus();
		return false;
		//Sexy.alert('<h1>Invoice save fail</h1><p>Please enter valid amount to save!</p>');return false;
	}
	
	if(document.getElementById("txtaccpacid").value == "")
	{
		alert("Please enter valid Accpac ID to save!")
		document.getElementById('txtaccpacid').focus();
		return false;
		//Sexy.alert('<h1>Invoice save fail</h1><p>Please enter valid Accpac ID to save!</p>');return false;
	}
	
	if (dblAmount > totGRNAmount)
	{
		alert("Please enter valid invoice amount to save!")
		return false;
		//Sexy.alert('<h1>Invoice save fail</h1><p>Please enter valid invoice amount to save!</p>');return false;	
	}
	
	
	var strInvoiceNo = document.getElementById('txtinvno').value;
	var strSupplierId = document.getElementById('cbosupplier').value;
	var dtmDate = document.getElementById('cboinvdate').value;
	var dblAmount =  parseFloat(document.getElementById('txttotglamount').value);
	var strDescription =  document.getElementById('txtDescription').value;	
	var batchno=document.getElementById("cbobatch").value;
	
	//var dblCommission = parseFloat(document.getElementById('txtcommission').value);
	var dblCommission=0;
	var dblTotalTax = 0;
	var dblFreight=0;
	var dblInsurance=0;
	var dblOther=0;
	var dblVatGl=0;
	
	if(document.getElementById('txtcommission').value != "")
	{
		var dblCommission = parseFloat(document.getElementById('txtcommission').value)
	}
	if(document.getElementById('txttottaxamount').value != "")
	{
		var dblTotalTax = parseFloat(document.getElementById('txttottaxamount').value)
	}
	if(document.getElementById('txtfreight').value != "")
	{
		var dblFreight = parseFloat(document.getElementById('txtfreight').value)
	}

	if(document.getElementById('txtinsurance').value != "")
	{
		var dblInsurance = parseFloat(document.getElementById('txtinsurance').value)
	}

	if(document.getElementById('txtother').value != "")
	{
		var dblOther = parseFloat(document.getElementById('txtother').value)
	}

	if(document.getElementById('txtvatgl').value != "")
	{
		var dblVatGl = parseFloat(document.getElementById('txtvatgl').value)
	}
	
	var intcompanyiD = document.getElementById('txtcompid').value;
	var intStatus = 0;
	var dblPaidAmount = parseFloat(document.getElementById('txttotglamount').value);
	//alert(document.getElementById('txtRealAmount').value);
	
	//comment by roshan for error saving  2009-09-28
	//var dblBalance = parseFloat(document.getElementById('txtRealAmount').value)-parseFloat(document.getElementById('txttotglamount').value);
	var dblBalance = parseFloat(document.getElementById('txttotglamount').value);
	
	var dblTotalAmount = parseFloat(document.getElementById('txtinvoiceamount').value);
	var CurIndex = document.getElementById('cbocurrency').options.selectedIndex;
	var strCurrency = document.getElementById('cbocurrency').options[CurIndex].text;
	//alert(strCurrency);
	var intPaid = 0;
	var intCreditPeriod = document.getElementById('cbocreditprd').value;
	var dblCurrencyRate = parseFloat(document.getElementById('txtcurrate').value);
	
	var ArrPoNo = "";
	var ArrCurrency = "";
	var ArrAmount = "";
	var ArrBalance = "";
	

	
	totGRNAmount=Math.round(totGRNAmount*100)/100;
	
	
	
	var tbl = document.getElementById('tblpodetails');
	var tblgl = document.getElementById('tblglaccounts');
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
	{
		var Selected = tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked;
		var PoNo = tbl.rows[loop].cells[1].childNodes[0].nodeValue;
		var Currency = tbl.rows[loop].cells[2].childNodes[0].nodeValue;
		var Amount =  tbl.rows[loop].cells[3].childNodes[0].nodeValue;
		//var Balance =  tbl.rows[loop].cells[4].childNodes[0].nodeValue;
		var Balance = 0;
		
		if (tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
			{
				ArrPoNo += PoNo + ",";
				ArrCurrency += Currency + ",";
				ArrAmount += Amount + ",";
				ArrBalance += Balance + ",";
			 } 
	}
	
	var ArrGlAcc  = "";
	var ArrGlAmt  = "";
	
	var tblgl = document.getElementById('tblglaccounts');
	for ( var loop = 1 ;loop < tblgl.rows.length ; loop ++ )
	{

		var GlAcc =  tblgl.rows[loop].cells[1].childNodes[0].nodeValue;
		var GlAmt =  tblgl.rows[loop].cells[3].childNodes[0].value;
	 
		if (tblgl.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
			{
				ArrGlAcc += GlAcc + ",";
				ArrGlAmt += GlAmt + ",";
			 } 
	}
	
	var ArrTaxId  = "";
	var ArrTaxAmt  = "";
	
	var tbltax = document.getElementById('tbltaxdetails');
	for ( var loop = 1 ;loop < tbltax.rows.length ; loop ++ )
	{
		var TaxId =  tbltax.rows[loop].cells[1].id;
		var TaxAmt =  tbltax.rows[loop].cells[3].childNodes[0].value;
		if (tbltax.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
			{
				ArrTaxId += TaxId + ",";
				ArrTaxAmt += TaxAmt + ",";
			 } 
	}
	
	var size = parseFloat(arrearlySavedInvAmt.length) - 1;

	//return false;
	//return false;

		if(pub_grnBalance == 0){
		 dblBalance = 0;	
		}else if((dblBalance < pub_grnBalance) && listing == 1){
		 dblBalance = 	parseFloat(pub_grnBalance)-parseFloat(dblBalance);
		 dblAmount  =   parseFloat(document.getElementById("txttotglamount").value);
		}else if((dblBalance < pub_grnBalance) && listing == 0){
		 dblBalance = document.getElementById("txttotglamount").value;
		 dblAmount = parseFloat(document.getElementById("txttotglamount").value) + parseFloat(arrearlySavedInvAmt[size]);
		}else if(pub_grnBalance == dblBalance && listing == 0){
		 dblBalance = document.getElementById("txttotglamount").value;
		 dblAmount = document.getElementById("txttotglamount").value;
		}else if(pub_grnBalance == dblBalance && listing == 1){
		dblBalance = 0;
		dblAmount = 0;
		}
	

//return false;
		strPaymentType=document.getElementById("cboPymentType").value
		var accPaccID=document.getElementById("txtaccpacid").value.trim();
		var entryNo=document.getElementById('txtentryno').value.trim();
		var lineNo=document.getElementById('txtlineno').value.trim();
		var invDesc=document.getElementById('txtDescription').value.trim();
		var dueDate=document.getElementById("txtdatedue").value.trim();
		//return false;
		createAltXMLHttpRequestArray(incr);
		altxmlHttpArray[incr].index=incr;
		altxmlHttpArray[incr].onreadystatechange = HandleSaveInvoice;
		var url='supplierInvXML.php?RequestType=SaveInvoice&strPaymentType=' + strPaymentType + '&InvNo=' + strInvoiceNo + '&SupId=' + strSupplierId + '&InvDt=' + dtmDate + '&InvAmt=' + parseFloat(dblAmount).toFixed(2) + '&InvDesc=' + strDescription + '&Commission=' + dblCommission + '&CompId=' + intcompanyiD + '&Status=' + intStatus + '&PaidAmt=' + parseFloat(dblPaidAmount).toFixed(2) + '&BalanceAmt=' + parseFloat(dblBalance).toFixed(2) + '&TotalTaxAmt=' + dblTotalTax + '&FreightAmt=' + dblFreight + '&Insurance=' + dblInsurance + '&Other=' + dblOther + '&VatGl=' + dblVatGl + '&TotalAmt=' + dblTotalAmount + '&Currency=' + strCurrency + '&Paid=' + intPaid + '&CreditPeriod=' + intCreditPeriod + '&CurrencyRate=' + dblCurrencyRate + '&ArrPoNo=' + ArrPoNo + '&ArrCurrency=' + ArrCurrency + '&ArrAmount=' + ArrAmount + '&ArrBalance=' + ArrBalance + '&ArrGlAcc=' + ArrGlAcc + '&ArrGlAmt=' + ArrGlAmt + '&ArrTaxId=' + ArrTaxId + '&ArrTaxAmt=' + ArrTaxAmt + '&batchno=' + batchno+'&accPaccId='+accPaccID+'&entryNo='+entryNo+'&lineNo='+lineNo+'&invDesc='+invDesc+'&dueDate='+dueDate;
		//alert(url);
		altxmlHttpArray[incr].open("GET",url,true);
		
		altxmlHttpArray[incr].send(null);
		incr++;
		document.getElementById("btnsave").style.visibility="hidden";
        
}

function HandleSaveInvoice()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {			
			var XMLSave = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Save");
			var XMLExist = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Exist");
			
			for ( var loop = 0; loop < XMLSave.length; loop++)
			{
				if(XMLExist[loop].childNodes[0].nodeValue == "True")
				{
					alert("Supplier invoice updates successfully !");
					clearControls()
					document.getElementById("btnsave").style.visibility="visible";
					//Sexy.info('<h1>Invoice update successful</h1><p>Supplier invoice updates successfuly !</p>');return true;
					//newPage();
				}
				else
				{
					if(XMLSave[loop].childNodes[0].nodeValue == "True")
					{
						alert("Supplier \"Invoice No.\" saved successfully !");
						document.getElementById("btnsave").style.visibility="visible";
						clearControls()
						
						//Sexy.info('<h1>Invoice save successful</h1><p>Supplier invoice saved successful!</p>');return true;
						//newPage();
					}
					else
					{
						alert("There is an error.Supplier invoice save failed !");
						//Sexy.error('<h1>Error in saving invoice</h1><p>Supplier invoice save failed !</p>');return false;	
					}
				}
			}
			
		}
	}
}

function checkInvoiceNo(strInvoiceNo,strPaymentType,strSupplierId)
{
	CreateXMLHttpForCheckInvoiceNo();
	xmlHttpCheckInvoiceNo.onreadystatechange = HandleCheckInvoiceNo;
	xmlHttpCheckInvoiceNo.open("GET", 'supplierInvXML.php?RequestType=checkInvoiceNo&strPaymentType=' + strPaymentType + '&supID=' + strSupplierId + '&invoiceNo=' + strInvoiceNo, true);
	xmlHttpCheckInvoiceNo.send(null); 
}

function HandleCheckInvoiceNo()
{
	if(xmlHttpCheckInvoiceNo.readyState == 4) 
		{
			if(xmlHttpCheckInvoiceNo.status == 200) 
			{			
				var XMLINVNo = xmlHttpCheckInvoiceNo.responseXML.getElementsByTagName("invNo");
				//var strInvNo=XMLINVNo[0].childNodes[0].nodeValue
				//alert(XMLINVNo.length);
				if(XMLINVNo.length>0)
				{
					invNoAvailability=true
					return ;					
				}
				else 
				{
					invNoAvailability=false
					return ;	
				}
			}
		}
}

function quit(from)
{
	//alert(document.getElementById("txtinvoiceamount").value)
	if(document.getElementById("txtinvoiceamount").value=='')
	{
		switch (from)
		{
			case 1:
			{
				var sURL = unescape(window.location.href);
				window.location.href = sURL;
			}
			case 2:
			{
				window.location.href = "../main.php";
			}
		}
	}
	else
	{
		var x=window.confirm("This invoice is not saved, Do you want to quit ?")
		if (x)
		{
			switch (from)
			{
				case 1:
				{
					var sURL = unescape(window.location.href);
					window.location.href = sURL;
				}
				case 2:
				{
					window.location.href = "../main.php";
				}
			}
		}
		
	}
}

function newPage()
{
	var sURL = unescape(window.location.pathname);
   // window.location.href = sURL;
    document.getElementById('frmsupinv').reset();
    document.getElementById('txtinvno').focus();
    var tblArr=['tblpodetails','tbltaxdetails','tblglaccounts'];
    for(var i=0;i<tblArr.length;i++){
	    var tbl=document.getElementById(tblArr[i])
		var rCount = tbl.rows.length;
		for(var loop=1;loop<rCount;loop++)
		{
				tbl.deleteRow(loop);
				rCount--;
				loop--;
		}
    }
    loadCombo('SELECT strSupplierID,strTitle AS strName FROM suppliers WHERE intStatus=1 ORDER BY strTitle','cbosupplier');
    document.getElementById('cbocompany').innerHTML=""; 
}

function HandleShowAllGLAccounts()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
					//alert(altxmlHttpArray[this.index].responseText);
			
			var XMLGLAccId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccId");
			var XMLGLAccDesc = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccDesc");
			var XMLSelected = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Selected");
			
			drawPopupArea(670,450,'frmAllGLAccounts');
			
			var tableText = "<table width=\"650\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblsearch\" bgcolor=\"#FFF\"> " +
							"<tr>"+
							"<td>"+
							"	<table width=\"650\">"+
							"		<tr>"+
			              	"			<td height=\"25\" bgcolor=\"#FFF\" class=\"TitleN2white\">GL Accounts</td>"+
							"		</tr>"+
							"	</table>"+
							"<td>"+
            				"</tr>"+							
							"<tr  class=\"containers\">"+
							"<td>"+
							"	<table>"+
							"		<tr>"+
							"<td width=\"39\" height=\"25\">&nbsp;</td>"+
                    		"<td width=\"50\" class=\"normalfnt\">Factory</td>"+
                    		"<td width=\"250\">"+
                      		"<select name=\"cboFactory\"  class=\"normalfnt\" id=\"cboFactory\" style=\"width:250px\" onchange='getGLAccounts();'>"+
                      		"</select>"+
                    		"</td>"+
                    		"<td>&nbsp;</td>"+
                   	 		"<td width=\"100\" class=\"normalfnt\">Acc.Like</td>"+
                    		"<td width=\"200\"><input type=\"text\"  class=\"txtbox\"  name=\"txtNameLike\" id=\"txtNameLike\" size=\"25\" /></td>"+
							"<td width=\"8%\"><img src=\"../images/search.png\" onclick=\"getGLAccounts()\" alt=\"search\" width=\"86\" height=\"24\" /></td>"+
							"</td>"+
							"	</table>"+
							"		</tr>"+
							
							"</tr>"+
							
							
							"</table> " +
							
							"<div id=\"divbuttons\" style=\"overflow:scroll; height:350px; width:665px;\">"+
							"<table width=\"650\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblallglaccounts\"> " +
               				"<tr><td width=\"39\" height=\"22\"  class=\"grid_header\">*</td> " +
                   			"<td width=\"350\"  class=\"grid_header\">GL Acc Id</td>" +
                   			"<td width=\"450\"  class=\"grid_header\">Description</td>" +
                   			"</tr>";

				for(var loop = 0; loop < XMLGLAccId.length; loop++)
				{
					var selection = "";
					
					if (XMLSelected[loop].childNodes[0].nodeValue == "True")
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
					else
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"\" />";
					var cls;(loop%2==1)?cls='grid_raw':cls='grid_raw2';
					tableText += "<tr>"+
								"<td class='"+cls+"'><div align=\"center\">"+ selection +"</div></td>" +
								"<td class='"+cls+"' id=\"" + XMLGLAccId[loop].childNodes[0].nodeValue + "\">" + XMLGLAccId[loop].childNodes[0].nodeValue + "</td>" +
                    			"<td class='"+cls+"' id=\"" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "\">" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "</td>" +
								"</tr>";
				}
				tableText += "</table></div>";

				tableText += "<tr>"+
								"<td width=\"3%\" bgcolor=\"#D6E7F5\">&nbsp;</td>"+
								"<td colspan=\"2\" bgcolor=\"#D6E7F5\" class=\"normalfnt\">"+
								"<table width=\"100%\" border=\"0\">"+
									"<tr>"+
								  		"<td width=\"13%\">&nbsp;</td>"+
										"<td width=\"31\" colspan=\"2\"><img src=\"../images/addsmall.png\" onClick=\"AddNewGLAccountRow(this);\" alt=\"Add\" /></td>"+
								  		"<td width=\"11%\"><img src=\"../images/close.png\" onClick=\"closeWindow();\" alt=\"Close\" name=\"Close\" width=\"97\" height=\"24\" id=\"Close\" /></td>"+
									"</tr>"+
							   "</table></td>"+
						  	"</tr>";
				
				var frame = document.createElement("div");
    			frame.id = "glselectwindow";
				document.getElementById('frmAllGLAccounts').innerHTML=tableText;
				
				LoadFactoryList();
		}
	}
}

function AddNewGLAccountRow(objevent)
{
	//alert(objevent);
	var tblall = document.getElementById('tblallglaccounts');
		
	for ( var loop = 1 ;loop < tblall.rows.length ; loop ++ )
	{	
		if (tblall.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{
			var rwGLAcc = tblall.rows[loop].cells[1].childNodes[0].nodeValue;
			var rwGLDesc = tblall.rows[loop].cells[2].childNodes[0].nodeValue;
			
			var tbl = document.getElementById('tblglaccounts');
			
			var lastRow = tbl.rows.length;	
			for(var i=1;i<lastRow;i++){
				if(tbl.rows[i].cells[1].childNodes[0].nodeValue==rwGLAcc){
					alert("GL Acc Id Allready exist.");
					tblall.rows[loop].cells[0].childNodes[0].childNodes[0].checked=false;
					return false;
				}
			}
			var row = tbl.insertRow(lastRow);
			
			/*var cellGLChk = row.insertCell(0);
			cellGLChk.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" onclick=\"checkUncheckTextBox(this);\" /></div>";
			
			var cellGLAcc = row.insertCell(1);
			cellGLAcc.innerHTML = rwGLAcc;
			
			var cellGLDesc = row.insertCell(2);
			cellGLDesc.innerHTML = rwGLDesc;
			
			var cellGLAmt = row.insertCell(3);
			cellGLAmt.innerHTML = "<input type=\"text\" id=\"glamount\" name=\"glamount\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" value=\""+ 0 +"\">";			
			*/
			var cls;
			((lastRow % 2)==1)?cls='grid_raw':cls='grid_raw2';
			var htm="<td class=\""+cls+"\"><div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" onclick=\"checkUncheckTextBox(this);\" /></div></td>";
			htm +="<td style='text-align:left'  class=\""+cls+"\">"+rwGLAcc+"</td>";
			htm +="<td style='text-align:left' class=\""+cls+"\">"+rwGLDesc+"</td>";
			htm +="<td class=\""+cls+"\"><input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" value=\""+ 0 +"\"></td>";
			 row.innerHTML=htm;
		}
	}
	        var supID = document.getElementById('cbosupplier').value;
			var url = 'supplierInvXML.php?RequestType=saveSupWiseGlAllocation';
			    url += '&supID='+supID;
				url += '&rwGLAcc='+rwGLAcc;
		    htmlobj=$.ajax({url:url,async:false});
}

function getGLAccounts()
{
	var facCode=document.getElementById("cboFactory").value;
	var nameLike=document.getElementById("txtNameLike").value;	
		nameLike =nameLike.trim();
	
	//CreateXMLHttpForGLAccs();
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index=incr;
	altxmlHttpArray[incr].onreadystatechange = HandleGLAccs;
    altxmlHttpArray[incr].open("GET", 'advancepaymentDB.php?DBOprType=getGLAccountList&facID=' + facCode + '&NameLike=' + nameLike , true);
	altxmlHttpArray[incr].send(null);
	incr++;
}
function HandleGLAccs()
{	
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
	   if(altxmlHttpArray[this.index].status == 200) 
        {  
			var XMLaccNo = altxmlHttpArray[this.index].responseXML.getElementsByTagName("accNo");
			var XMLaccName = altxmlHttpArray[this.index].responseXML.getElementsByTagName("accDes");
		  
			var strGLAccs="<table width=\"650\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblallglaccounts\"> " +
               				"<tr><td width=\"39\" height=\"22\" bgcolor=\"\" class=\"grid_header\">*</td> " +
                   			"<td width=\"350\" bgcolor=\"\" class=\"grid_header\">GL Acc Id</td>" +
                   			"<td width=\"450\" bgcolor=\"\" class=\"grid_header\">Description</td>" +
                   			"</tr>"

			for ( var loop = 0; loop < XMLaccNo.length; loop ++)
			 {
				var accNo = XMLaccNo[loop].childNodes[0].nodeValue;
				var accDes = XMLaccName[loop].childNodes[0].nodeValue;
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strGLAccs += "<tr>"+
							"<td class=\""+cls+"\"><div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"\" /></div></td>" +
							"<td class=\""+cls+"\" id=\"" + accNo + "\">" + accNo + "</td>" +
                    		"<td class=\""+cls+"\" id=\"" + accDes + "\">" + accDes + "</td>" +
							"</tr>";
			}
			strGLAccs+=	"</table>"
			
			//document.getElementById("divGLAccs").innerHTML=strGLAccs;
			document.getElementById("divbuttons").innerHTML=strGLAccs;			
		}
	}
}

function LoadFactoryList()
{
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index=incr;
	altxmlHttpArray[incr].onreadystatechange = HandleFactories;
    altxmlHttpArray[incr].open("GET", 'advancepaymentDB.php?DBOprType=getFactoryList', true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function HandleFactories()
{	
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
	   if(altxmlHttpArray[this.index].status == 200) 
        {  
			var XMLFactoryID = altxmlHttpArray[this.index].responseXML.getElementsByTagName("compID");
			var XMLFactoryName = altxmlHttpArray[this.index].responseXML.getElementsByTagName("compName");
			RemoveCurrentCombo("cboFactory");
			
			var optFirst = document.createElement("option");			
			optFirst.text = "";
			optFirst.value = 0;
			document.getElementById("cboFactory").options.add(optFirst);
				
			for ( var loop = 0; loop < XMLFactoryID.length; loop ++)
			 {
				var FactoryID = XMLFactoryID[loop].childNodes[0].nodeValue;
				var FactoryName = XMLFactoryName[loop].childNodes[0].nodeValue;
				var optFactory = document.createElement("option");
				
				optFactory.text =FactoryName.toUpperCase() ;
				optFactory.value = FactoryID;
				//alert(FactoryName + "   " + FactoryID);
				
				document.getElementById("cboFactory").options.add(optFactory);
			 }
			 document.getElementById("cboFactory").value=0;
		}
	}
}

function search(e)
{
		var characterCode ;
	
	if(e && e.which){ //if which property of event object is supported (NN4)
	e = e
	characterCode = e.which //character code is contained in NN4's which property
	}
	else{
	e = event
	characterCode = e.keyCode //character code is contained in IE's keyCode property
	}
	
	if(characterCode==13)
	{
		SearchInvoiceNo();	
	}
}

function roundNumber(num, dec) {
	var result = Math.round( Math.round( num * Math.pow( 10, dec + 1 ) ) / Math.pow( 10, 1 ) ) / Math.pow(10,dec);
	return result;
	
}

function loadInvNOPopUp(obj){
	alert(obj);
}

function viewGrnPopUp(loop)
{	
    var cbosupplier = document.getElementById("cbosupplier").value;
	var poNoandYear = document.getElementById("tblpodetails").rows[loop+1].cells[1].innerHTML;
	var splitpoNoandYear = poNoandYear.split("/");
	var poYear = splitpoNoandYear[0];
	var poNo   = splitpoNoandYear[1];
	
	var path = "advPaymentPopUp.php?cbosupplier="+cbosupplier+"&Type="+document.getElementById('cboPymentType').value.trim()+"&poYear="+poYear+"&poNo="+poNo;
	htmlobj=$.ajax({url:path,async:false});	
	
	var text = htmlobj.responseText;

	drawPopupArea(450,190,'frmServer');
	var frame = document.createElement("div");
	frame.id = "serverSelection";
	document.getElementById('frmServer').innerHTML=text;
}

function viewExcessPopUp(loop){
	var cbosupplier = document.getElementById("cbosupplier").value;
	var poNoandYear = document.getElementById("tblpodetails").rows[loop+1].cells[1].innerHTML;
	var splitpoNoandYear = poNoandYear.split("/");
	var poYear = splitpoNoandYear[0];
	var poNo   = splitpoNoandYear[1];
	
	var path = "excessPoPopUp.php?cbosupplier="+cbosupplier+"&Type="+document.getElementById('cboPymentType').value.trim()+"&poYear="+poYear+"&poNo="+poNo;
	htmlobj=$.ajax({url:path,async:false});	
	
	var text = htmlobj.responseText;

	drawPopupArea(630,190,'frmServer');
	var frame = document.createElement("div");
	frame.id = "serverSelection";
	document.getElementById('frmServer').innerHTML=text;
}

function viewPOGRNLIST(loop){
	//window.open('../Reports/pogrnlist/style/POGrnList.php','PO/GRN List','width=1000,height=500,left=150px,location=no,top=200px,menubar=no')
	
    var cbosupplier = document.getElementById("cbosupplier").value;
	var poNoandYear = document.getElementById("tblpodetails").rows[loop+1].cells[1].innerHTML;
	var splitpoNoandYear = poNoandYear.split("/");
	var poYear = splitpoNoandYear[0];
	var poNo   = splitpoNoandYear[1];

	
	var path = "POGRNListPopup.php?cbosupplier="+cbosupplier+"&Type="+document.getElementById('cboPymentType').value.trim()+"&poYear="+poYear+"&poNo="+poNo;
	htmlobj=$.ajax({url:path,async:false});	
	
	var text = htmlobj.responseText;

	drawPopupArea(400,190,'frmServer');
	var frame = document.createElement("div");
	frame.id = "serverSelection";
	document.getElementById('frmServer').innerHTML=text;
}

