//updated from roshan 2009-10-12

var xmlHttp;
var altxmlHttp;
var altxmlHttpArray = [];
var strPaymentType=""
var incr =0;
var invNoAvailability=false;
var checkGLfirstTime = 0;

//var fltGlAmt =0;
//var fltPrevGlAmt = 0;
var XMLBatchNo = 0;
var pubCurrencyId = 0;
var pubXMLBatchNo = 0;
var pubXMLLoadEntryNo = "";
var pubXMLBatchId = "";
var totGRNAmount = 0;
var InvNo = 0;
var SupId = 0;
var InvoiNo = 0;
var paymentType = 0;
var strPaymentType = 0;
var payType = 0;
var pub_grnBalance=0;
var pub_poBalance = 0;
var preValue = 0;
var totamt = 0;
var GLAmt = 0;
var GLAmnt = 0;
var entryNo = 0;
var invDate = 0;

	var url					='advancepaymentDB.php?DBOprType=load_GLID';
	var pub_xml_http_obj	=$.ajax({url:url,async:false});
	var pub_po_arr			=pub_xml_http_obj.responseText.split("|");
	event_setter();

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

function getTotalGrnValue(obj) 
{	
	if(obj.value == "")
	  return;
	var invAmount=obj.value.trim();
	
	if(parseFloat(invAmount)>parseFloat(pub_grnBalance)+5){
		alert("Amount can not be exceed GRN Value!");
		obj.value=Number(pub_grnBalance).toFixed(2);
		setTotGlVale();
		return false;
	}
	
	
}
function saveFreihtCharges(supID){
	var tbl=document.getElementById('tblFreight').tBodies[0];
	var rc=tbl.rows.length;
	var invNo=document.getElementById('txtinvno').value.toUpperCase();

	var path='supplierInvXML.php?RequestType=saveCharges&strPaymentType='+document.getElementById('cboPymentType').value.trim()+'&invNo='+URLEncode(invNo);
	for(var i=0;i<rc;i++){
		if(tbl.rows[i].cells[0].childNodes[0].checked){
			path+='&glId='+tbl.rows[i].cells[1].id+'&amount='+tbl.rows[i].cells[3].childNodes[0].value+'&tbl=tblfreightgl&supId='+supID;
			objhtml=$.ajax({url:path,async:false});
		}
	}
}

function saveInsuranceCharges(supID){
	var tbl=document.getElementById('tblInsurance').tBodies[0];
	var rc=tbl.rows.length;
	var invNo=document.getElementById('txtinvno').value.toUpperCase();
	var supId=document.getElementById('cbosupplier').value.trim();
	var path='supplierInvXML.php?RequestType=saveCharges&strPaymentType='+document.getElementById('cboPymentType').value.trim()+'&invNo='+URLEncode(invNo);
	for(var i=0;i<rc;i++){
		if(tbl.rows[i].cells[0].childNodes[0].checked){
			path+='&glId='+tbl.rows[i].cells[1].id+'&amount='+tbl.rows[i].cells[3].childNodes[0].value+'&tbl=tblinsurancegl&supId='+supID;
			objhtml=$.ajax({url:path,async:false});
		}
	}
}

function saveOtherCharges(supID){
	var tbl=document.getElementById('tblOther').tBodies[0];
	var rc=tbl.rows.length;
	var invNo=document.getElementById('txtinvno').value.toUpperCase();
	var supId=document.getElementById('cbosupplier').value.trim();
	var path='supplierInvXML.php?RequestType=saveCharges&strPaymentType='+document.getElementById('cboPymentType').value.trim()+'&invNo='+URLEncode(invNo);
	for(var i=0;i<rc;i++){
		if(tbl.rows[i].cells[0].childNodes[0].checked){
			path+='&glId='+tbl.rows[i].cells[1].id+'&amount='+tbl.rows[i].cells[3].childNodes[0].value+'&tbl=tblothergl&supId='+supID;
			objhtml=$.ajax({url:path,async:false});
		}
	}
}

function setCharges(obj,control,tbl){
	var amt=0;
	var rc=tbl.rows.length;
	
	for(var i=1;i<rc;i++){
		if(tbl.rows[i].cells[0].childNodes[0].checked){
			amt=Number(amt)+Number(tbl.rows[i].cells[3].childNodes[0].value);			
		}
		else{
			tbl.rows[i].cells[3].childNodes[0].value=0;
		}
	}
	control.value=amt;
	control.onchange();
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

function SearchInvoiceNoEdit(invNo,supId)
{
	strPaymentType 	= document.getElementById("cboPymentType").value
	var url    	 	= 'supplierInvXML.php?RequestType=SearchInvoiceNoEdit&strPaymentType=' + strPaymentType + '&InvoiceNo=' + invNo;
	htmlobj 		= $.ajax({url:url,async:false});
	
	var XMLSupId = htmlobj.responseXML.getElementsByTagName("SupId");
	var XMLSupNm = htmlobj.responseXML.getElementsByTagName("SupNm");

		for ( var loop = 0; loop < XMLSupId.length; loop ++)
		{
			var opt   = document.createElement("option");
			opt.text  = XMLSupNm[loop].childNodes[0].nodeValue;
			opt.value = XMLSupId[loop].childNodes[0].nodeValue;
			if(supId==XMLSupId[loop].childNodes[0].nodeValue)
				opt.selected = XMLSupId[loop].childNodes[0].nodeValue;
			document.getElementById("cbosupplier").options.add(opt);
		}
}

function SearchEdit(invNo,supId,invDate,type)
{
	document.getElementById("txtinvno").value 	 = invNo;
	document.getElementById("cbosupplier").value = supId;
	SearchInvoiceNoEdit(invNo,supId);
	
	GetSupplierInvoiceExst(invNo,supId,invDate,type);
	
	LoadSupplierGLEdit(invNo,supId);
	
	LoadPoDetailsEdit(invNo,supId,type);
	
	genDescription();
	
	ShowAllTax();
	
	ShowAllTaxExst(invNo,supId,type);
	
	setTotGlVale();

	//loadFreightCharges(invNo,supId);
	
//	loadInsuranceCharges(invNo,supId);
	
	//loadOtherCharges(invNo,supId);
	

}
function loadFreightCharges(invNo,supId){
	var strPaymentType=document.getElementById('cboPymentType').value.trim();
	var path="supplierInvXML.php?RequestType=loadCharges&invNo="+invNo+"&supNo="+supId+'&strPaymentType='+strPaymentType+'&tbl=tblfreightgl';
	htmlobj=$.ajax({url:path,async:false});
	var XMLAccName	=	htmlobj.responseXML.getElementsByTagName("AccName");
	var XMLDescription	=	htmlobj.responseXML.getElementsByTagName("Description");
	var XMLGLAccAllowNo	=	htmlobj.responseXML.getElementsByTagName("GLAccAllowNo");
	var XMLAmount	=	htmlobj.responseXML.getElementsByTagName("Amount");
	
	var tbl=document.getElementById('tblFreight').tBodies[0];
	tbl.innerHTML="";
	var tblHTML="";
	var c=0;
	var cls="";
	if(XMLGLAccAllowNo.length>0){
		for(var i=0;i<XMLGLAccAllowNo.length;i++){
			(c%2==0)?cls="grid_raw":cls="grid_raw2";
			tblHTML+="<tr><td width=\"20\" class=\"cls\"><input type=\"checkbox\" onclick=\"setCharges(this,document.getElementById('txtfreight'),document.getElementById('tblFreight'))\" checked=\"true\" /></td><td id=\""+XMLGLAccAllowNo[i].childNodes[0].nodeValue +"\" class=\""+cls+"\">"+XMLAccName[i].childNodes[0].nodeValue+"</td><td class=\""+cls+"\">"+ XMLDescription[i].childNodes[0].nodeValue+"</td><td class=\""+cls+"\"><input type=\"text\" value=\""+XMLAmount[i].childNodes[0].nodeValue+"\" onkeyup=\"clckSGLBox(this),setCharges(this,document.getElementById('txtfreight'),document.getElementById('tblFreight'));\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" style=\"width: 50px; text-align: right;\"></td></tr>";
			c++;
		}	
	}
	tbl.innerHTML=tblHTML;
}

function loadInsuranceCharges(invNo,supId){
	var strPaymentType=document.getElementById('cboPymentType').value.trim();
	var path="supplierInvXML.php?RequestType=loadCharges&invNo="+invNo+"&supNo="+supId+'&strPaymentType='+strPaymentType+'&tbl=tblinsurancegl';
	htmlobj=$.ajax({url:path,async:false});
	var XMLAccName	=	htmlobj.responseXML.getElementsByTagName("AccName");
	var XMLDescription	=	htmlobj.responseXML.getElementsByTagName("Description");
	var XMLGLAccAllowNo	=	htmlobj.responseXML.getElementsByTagName("GLAccAllowNo");
	var XMLAmount	=	htmlobj.responseXML.getElementsByTagName("Amount");
	
	var tbl=document.getElementById('tblInsurance').tBodies[0];
	tbl.innerHTML="";
	var tblHTML="";
	var c=0;
	var cls="";
	if(XMLGLAccAllowNo.length>0){
		for(var i=0;i<XMLGLAccAllowNo.length;i++){
			(c%2==0)?cls="grid_raw":cls="grid_raw2";
			tblHTML+="<tr><td class=\""+cls+"\"><input type=\"checkbox\" checked=\"true\" onclick=\"setCharges(this,document.getElementById('txtinsurance'),document.getElementById('tblInsurance'))\"/></td><td id=\""+XMLGLAccAllowNo[i].childNodes[0].nodeValue +"\" class=\""+cls+"\">"+XMLAccName[i].childNodes[0].nodeValue+"</td><td class=\""+cls+"\">"+ XMLDescription[i].childNodes[0].nodeValue+"</td><td class=\""+cls+"\"><input type=\"text\" value=\""+XMLAmount[i].childNodes[0].nodeValue+"\" onkeyup=\"clckSGLBox(this),setCharges(this,document.getElementById('txtinsurance'),document.getElementById('tblInsurance'));\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" style=\"width: 50px; text-align: right;\"></td></tr>";
			c++;
		}	
	}
	tbl.innerHTML=tblHTML;
}
function loadOtherCharges(invNo,supId){
	var strPaymentType=document.getElementById('cboPymentType').value.trim();
	var path="supplierInvXML.php?RequestType=loadCharges&invNo="+invNo+"&supNo="+supId+'&strPaymentType='+strPaymentType+'&tbl=tblothergl';
	htmlobj=$.ajax({url:path,async:false});
	var XMLAccName	=	htmlobj.responseXML.getElementsByTagName("AccName");
	var XMLDescription	=	htmlobj.responseXML.getElementsByTagName("Description");
	var XMLGLAccAllowNo	=	htmlobj.responseXML.getElementsByTagName("GLAccAllowNo");
	var XMLAmount	=	htmlobj.responseXML.getElementsByTagName("Amount");
	
	var tbl=document.getElementById('tblOther').tBodies[0];
	tbl.innerHTML="";
	var tblHTML="";
	var c=0;
	var cls="";
	if(XMLGLAccAllowNo.length>0){
		for(var i=0;i<XMLGLAccAllowNo.length;i++){
			(c%2==0)?cls="grid_raw":cls="grid_raw2";
			tblHTML+="<tr><td width=\"20\" class=\""+cls+"\"><input type=\"checkbox\" onclick=\"setCharges(this,document.getElementById('txtother'),document.getElementById('tblOther'));\" checked=\"true\"/></td><td id=\""+XMLGLAccAllowNo[i].childNodes[0].nodeValue +"\" class=\""+cls+"\">"+XMLAccName[i].childNodes[0].nodeValue+"</td><td class=\""+cls+"\">"+ XMLDescription[i].childNodes[0].nodeValue+"</td><td class=\""+cls+"\"><input type=\"text\" value=\""+XMLAmount[i].childNodes[0].nodeValue+"\" onkeyup=\"clckSGLBox(this),setCharges(this,document.getElementById('txtother'),document.getElementById('tblOther'));\" onkeypress=\"return CheckforValidDecimal(this.value, 3,event);\" style=\"width: 50px; text-align: right;\"></td></tr>";
			c++;
		}	
	}
	tbl.innerHTML=tblHTML;
}

/*function LoadBatchNoEdit(invNo,supId){

	var path="supplierInvXML.php?RequestType=loadBatchNo&invNo="+invNo+"&supNo="+supId;
	htmlobj=$.ajax({url:path,async:false});
	
		var XMLBatchNo	=htmlobj.responseXML.getElementsByTagName("BatchNo");
		var XMLEntryNo	=htmlobj.responseXML.getElementsByTagName("EntryNo");
		var XMLLineNo	=htmlobj.responseXML.getElementsByTagName("LineNo");

	if(XMLBatchNo.length > 0){
		document.getElementById('cbobatch').value = XMLBatchNo[0].childNodes[0].nodeValue;
		document.getElementById('txtentryno').value = XMLEntryNo[0].childNodes[0].nodeValue;
		document.getElementById('txtlineno').value = XMLLineNo[0].childNodes[0].nodeValue;
	}
}*/
function GetSupplierInvoiceExst(invNo,supId,invDate,type)
{
	var url = 'supplierInvXML.php?RequestType=GetSupplierInvoiceExst&PaymentType=' + type + '&InvoiceNo=' + invNo + '&SupplierId=' + supId ;
	htmlobj = $.ajax({url:url,async:false});	

	var XMLCompId		 = htmlobj.responseXML.getElementsByTagName("CompId");
	var XMLCompNm		 = htmlobj.responseXML.getElementsByTagName("CompNm");
	var XMLCompCd 		 = htmlobj.responseXML.getElementsByTagName("CompCd");
	var XMLAccPacID 	 = htmlobj.responseXML.getElementsByTagName("AccPacID");
	var XMLInvCurrency 	 = htmlobj.responseXML.getElementsByTagName("InvCurrency");
	var XMLCreditDays 	 = htmlobj.responseXML.getElementsByTagName("CreditDays");
	var XMLInvAmt 		 = htmlobj.responseXML.getElementsByTagName("InvAmt");
	//var XMLInvAmtwithNBT = htmlobj.responseXML.getElementsByTagName("invAmountwithNBT");
	var XMLInvDes 		 = htmlobj.responseXML.getElementsByTagName("InvDes");
	var XMLInvTotTaxAmt  = htmlobj.responseXML.getElementsByTagName("InvTotTaxAmt");
	var XMLInvFreight 	 = htmlobj.responseXML.getElementsByTagName("InvFreight");
	var XMLInvInsurance  = htmlobj.responseXML.getElementsByTagName("InvInsurance");
	var XMLInvOther 	 = htmlobj.responseXML.getElementsByTagName("InvOther");
	var XMLInvVatGL 	 = htmlobj.responseXML.getElementsByTagName("InvVatGL");
	var XMLInvTotAmt 	 = htmlobj.responseXML.getElementsByTagName("InvTotAmt");
	var XMLPaidStatus 	 = htmlobj.responseXML.getElementsByTagName("PaidStatus");
	var XMLBatchNo 		 = htmlobj.responseXML.getElementsByTagName("BatchNo");
	var XMLEntryNo 		 = htmlobj.responseXML.getElementsByTagName("EntryNo");
	var XMLlineNo 		 = htmlobj.responseXML.getElementsByTagName("lineNo");
					
	RemoveCurrentCombo("cbocompany");

			
		for ( var loop = 0; loop < XMLCompId.length; loop++)
		{
			pub_grnBalance = new Number(XMLInvAmt[loop].childNodes[0].nodeValue).toFixed(2);
			document.getElementById("txttotglamount").value 	=  pub_grnBalance;
			document.getElementById("txttotglamountTemp").value = document.getElementById("txttotglamount").value.trim();
			
			totGRNAmount = document.getElementById("txttotglamount").value;
			document.getElementById("txtDescription").value     =  XMLInvDes[loop].childNodes[0].nodeValue ;
			document.getElementById("txttottaxamount").value  	=  new Number(XMLInvTotTaxAmt[loop].childNodes[0].nodeValue).toFixed(2);
			document.getElementById("txtfreight").value 	  	=  new Number(XMLInvFreight[loop].childNodes[0].nodeValue).toFixed(2);
			document.getElementById("txtinsurance").value	  	=  new Number(XMLInvInsurance[loop].childNodes[0].nodeValue).toFixed(2);
			document.getElementById("txtother").value 		  	=  new Number(XMLInvOther[loop].childNodes[0].nodeValue).toFixed(2);
			document.getElementById("txtvatgl").value 		  	=  new Number(XMLInvVatGL[loop].childNodes[0].nodeValue).toFixed(2);
			document.getElementById("txtinvoiceamount").value 	=  new Number(XMLInvTotAmt[loop].childNodes[0].nodeValue).toFixed(2);
			document.getElementById("txtlineno").value 			=  XMLlineNo[loop].childNodes[0].nodeValue;
			
			var opt   = document.createElement("option");
			opt.text  = XMLCompNm[loop].childNodes[0].nodeValue;
			opt.value = XMLCompCd[loop].childNodes[0].nodeValue;
			document.getElementById("cbocompany").options.add(opt);
			
			document.getElementById("txtcompid").value   = XMLCompId[loop].childNodes[0].nodeValue;
			document.getElementById("txtaccpacid").value = XMLAccPacID[loop].childNodes[0].nodeValue;
			document.getElementById("txtentryno").value  = XMLEntryNo[loop].childNodes[0].nodeValue;
			document.getElementById("txtBatchId").value  = XMLBatchNo[loop].childNodes[0].nodeValue;
			document.getElementById("cbobatch").value 	 = XMLBatchNo[loop].childNodes[0].nodeValue;
			
		}
}

function LoadSupplierGLEdit(invNo,supId)
{
	var invNo = invNo;

	var type=document.getElementById('cboPymentType').value.trim();
	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr;
	altxmlHttpArray[incr].onreadystatechange = HandleLoadSupplierGLEdit;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=LoadSupplierGLEdit&strPaymentType='+type+'&SupplierId=' + supId + '&invNo=' + invNo,true);
	altxmlHttpArray[incr].send(null);
	incr++;
}


function HandleLoadSupplierGLEdit()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
			var XMLGLAccId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("accNo");
			var XMLGLAccName = altxmlHttpArray[this.index].responseXML.getElementsByTagName("accName");
			var XMLGLAccDsc = altxmlHttpArray[this.index].responseXML.getElementsByTagName("accDsc");
			var XMLGLAccAmt = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccAmt");
			var XMLSelected = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Selected");
			
			tableText = "<table width=\"582\" cellpadding=\"0\" border=\"0\" cellspacing=\"1\" id=\"tblglaccounts\" bgcolor=\"#CCCCFF\">"  +
						"<tr class=\"mainHeading4\">"+
							 "<td width=\"39\" height=\"20\" >*</td>" +
							 "<td width=\"102\" >GL Acc Id</td>" +
              				 "<td width=\"302\" >Description</td>" +
              				 "<td width=\"115\" >Amount</td>" + 
						 "</tr>";

				for(var loop = 0; loop < XMLGLAccId.length; loop++)
				{
					var selection = "";
					//var GLAmt = 0 ;
					if (XMLSelected[loop].childNodes[0].nodeValue == "True")
						selection = "<input type=\"checkbox\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" id=\"checkbox\" name=\"checkbox\" checked=\"true\">";
					else
						selection = "<input type=\"checkbox\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" id=\"checkbox\" name=\"checkbox\">";
					var cls;
					(loop%2==1)?cls='grid_raw':cls='grid_raw2';
						tableText += "<tr class=\"bcgcolor-tblrowWhite\">"+
									"<td ><div align=\"center\">"+ selection +"</div></td>" +
									"<td id=\"" + XMLGLAccId[loop].childNodes[0].nodeValue + "\" style=\"text-align:left;\">" + XMLGLAccName[loop].childNodes[0].nodeValue + "</td>" +
									"<td style=\"text-align:left;\">" + XMLGLAccDsc[loop].childNodes[0].nodeValue + "</td>" +
									"<td><input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox lastcellz\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onkeyup=\"clckGLBox(this.value,this.parentNode.parentNode.rowIndex);setTotGlVale();setAmountToGlAcc(event,this)\" onblur=\"setFixedValue(this.value,this.parentNode.parentNode.rowIndex);\" value=\""+ RoundNumbers(XMLGLAccAmt[loop].childNodes[0].nodeValue,2) +"\"> " +
									"</input></td>" +
									"</tr>";
				}
				tableText += "</table>";
				document.getElementById("divcons").innerHTML = tableText;
		}
	}
}
function LoadPoDetailsEdit(invNo,supId,type)
{
	var InvNo = invNo;
	InvNo 	  = InvNo.trim();
	var SupID = supId;
	var url   = 'supplierInvXML.php?RequestType=LoadPoDetailsEdit&PaymentType=' + type + '&SupplierId=' + SupID + '&InvoiceNo=' + InvNo;
	htmlobj   = $.ajax({url:url,async:false});		
	
	var XMLPONo 	  = htmlobj.responseXML.getElementsByTagName("PO");
	var XMLCurrency   = htmlobj.responseXML.getElementsByTagName("Currency");
	var XMLPOAmount   = htmlobj.responseXML.getElementsByTagName("POAmount");
	var XMLPOBalance  = htmlobj.responseXML.getElementsByTagName("POBalance");
	var XMLAdvaPOBal  = htmlobj.responseXML.getElementsByTagName("AdvancedPOBal");
	var XMLSelected   = htmlobj.responseXML.getElementsByTagName("Selected");
			
			tableText = "<table width=\"457\" cellpadding=\"0\" border=\"0\" cellspacing=\"1\" id=\"tblpodetails\" bgcolor=\"#CCCCFF\">"  +
						"<tr class=\"mainHeading4\">"+
							 "<td width=\"25\" height=\"22\">*</td>" +
							 "<td width=\"80\" >PO NO</td>" +
              				 "<td width=\"70\" >Currency</td>" +
              				 "<td width=\"70\" >Amount</td>" + 
							 "<td width=\"85\" >Advance Bal </td>" +
              				 "<td width=\"70\" >Balance</td>" +
              				 "<td width=\"50\" >View</td>" +
						 "</tr>";
			for(var loop = 0; loop < XMLPONo.length ; loop++)
			{
				var PONo 		= XMLPONo[loop].childNodes[0].nodeValue;
				var Currency  	= XMLCurrency[loop].childNodes[0].nodeValue;
				var POAmount 	= XMLPOAmount[loop].childNodes[0].nodeValue;
				var POBalance 	= XMLPOBalance[loop].childNodes[0].nodeValue;
				var AdvPOBal 	= XMLAdvaPOBal[loop].childNodes[0].nodeValue;
				var selection 	= XMLSelected[loop].childNodes[0].nodeValue;
				
				
				if (selection == "True")
					selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
					else
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" />";
				
				tableText += "<tr class=\"bcgcolor-tblrowWhite\" >"+
							 "<td class=\"normalfnt\"><div align=\"center\">"+ selection +"</div></td>" +
							 "<td class=\"normalfnt\">"+ PONo +"</td>" +
              				 "<td class=\"normalfnt\" style=\"text-align:left;\">"+ Currency +"</td>" +
              				 "<td class=\"normalfnt\" style=\"text-align:right;\">"+ parseFloat(POAmount).toFixed(2) +"</td>" + 
							 "<td class=\"normalfnt\" style=\"text-align:right;\">"+ parseFloat(AdvPOBal).toFixed(2) +"</td>" + 
              				 "<td class=\"normalfnt\" style=\"text-align:right;\">"+ parseFloat(POBalance).toFixed(2) +"</td>" +
              				 "<td class=\"normalfnt\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" onclick=\"loadPo(this);\"/></div></td>" +
							 "</tr>";
				}
				tableText += "</table>";
				document.getElementById("divcons2").innerHTML = tableText;	
}

//----Lasantha -- chage to jquery-End
/*function HandleLoadPoDetailsEdit()
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
}*/
////////==================lasantha description genaration ============================/////////////
function genDescription()
{
	var InvNo = document.getElementById('txtinvno').value.toUpperCase();
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
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=getDescription&InvoiceNo=' + URLEncode(InvNo) +'&SupplierId='+SupID+'&type='+type,true);
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
				if(XMLPONo.length  >0){
				var poNo=XMLPONo[0].childNodes[0].nodeValue;
				var SupId=altxmlHttpArray[this.index].index3.substring(0,10);
				var InvNo=altxmlHttpArray[this.index].index2;
				document.getElementById('txtDescription').value=(SupId+"-"+InvNo+"-"+poNo);
				}
		}
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////
function ShowAllTaxExst(invNo,supId,type)
{
	var url = 'supplierInvXML.php?RequestType=ShowAllTaxExst&PaymentType='+type+ '&InvoiceNo=' + URLEncode(invNo) + '&SupplierId=' + supId;
	htmlobj = $.ajax({url:url,async:false});
	
	var XMLTaxID    = htmlobj.responseXML.getElementsByTagName("TaxID");
	var XMLSelected = htmlobj.responseXML.getElementsByTagName("Selected");
	var XMLTaxAmt   = htmlobj.responseXML.getElementsByTagName("TaxAmt");
	
	var tblall = document.getElementById('tbltaxdetails');
	for ( var loop = 0 ;loop < XMLTaxID.length ; loop ++ )
	{
		for ( var loop2 = 1 ;loop2 < tblall.rows.length ; loop2 ++ )
		{
			var rwTaxId = tblall.rows[loop2].cells[1].id;
			
			if(rwTaxId == XMLTaxID[loop].childNodes[0].nodeValue)
			{
				tblall.rows[loop2].cells[0].childNodes[0].lastChild.checked = true;
				tblall.rows[loop2].cells[3].lastChild.value = XMLTaxAmt[loop].childNodes[0].nodeValue;
			}
		}
	}	
}

function AddNewGLAccountRow(objevent)
{
	var tblall = document.getElementById('tblallglaccounts');
		//alert(objevent);
	for ( var loop = 1 ;loop < tblall.rows.length ; loop ++ )
	{
		if (tblall.rows[loop].cells[0].childNodes[0].checked)
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
			cellGLAmt.innerHTML = "<input type=\"text\" id=\"glamount\" name=\"glamount\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onblur=\"addNewGLRow();setFixedValue(this.value,this.parentNode.parentNode.rowIndex);\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\"  onkeyup=\"clckGLBox1(this);\" value=\""+ 0 +"\">";			
		}
	}
}

function InvoiceInitialize(invNo,supId,invType,invDate,batchStatus)
{
	interfaceValidate(batchStatus);
	document.getElementById('cboinvdate').value=invDate;
	document.getElementById('cboPymentType').value=invType;
	var type=document.getElementById('cboPymentType').value.trim();
	
	LoadCurrency(invNo,supId,type);

	LoadCreditPeriod(invNo,supId,type);
	
	if (invNo != "" && supId != "")
	{
		SearchEdit(invNo,supId,invDate,type);	
	}
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
function interfaceValidate(batchStatus)
{
	if(batchStatus=="")
	 return;
	if(batchStatus==1)
	{
		document.getElementById("butSave").style.display = "none";
	}
	document.getElementById("txtinvno").disabled = "disabled";
	document.getElementById("cbosupplier").disabled = "disabled";
	document.getElementById("cbocompany").disabled = "disabled";
	document.getElementById("cboPymentType").disabled = "disabled";
	document.getElementById("cbobatch").disabled = "disabled";
	
	
}
function SearchInvoiceNo()
{
	InvNo = document.getElementById("txtinvno").value.toUpperCase();
	paymentType = document.getElementById("cboPymentType").value;
	newPage();
	
	document.getElementById("txtinvno").value=InvNo;
	document.getElementById("cboPymentType").value = paymentType;
	if(InvNo.length == 0)
	{
		alert ("Please enter invoice number to search.");
		document.getElementById('txtinvno').focus();
		return false;
	}
	else
	{
		strPaymentType=document.getElementById("cboPymentType").value
		var url='supplierInvXML.php?RequestType=SearchInvoiceNo&strPaymentType=' + strPaymentType + '&InvoiceNo=' + URLEncode(InvNo);
		htmlobj=$.ajax({url:url,async:false});
		var XMLSupId = htmlobj.responseXML.getElementsByTagName("SupId");
			var XMLSupNm = htmlobj.responseXML.getElementsByTagName("SupNm");
			var XMLInvDate=htmlobj.responseXML.getElementsByTagName("InvDate");
			var XMLVATSP=htmlobj.responseXML.getElementsByTagName("VATSP");
			
			if(XMLSupId.length==0)
			{
				alert("Invalid Invoice No under " + document.getElementById("cboPymentType").options[document.getElementById("cboPymentType").selectedIndex].text + " Payment")	
				
				clearControls()
				return;
			}
			document.getElementById('cboinvdate').value=XMLInvDate[0].childNodes[0].nodeValue;
			if(XMLVATSP[0].childNodes[0].nodeValue=='1'){
				document.getElementById('chksuspendedvat').checked=true; 
			}
			else{document.getElementById('chksuspendedvat').checked=false; }
			RemoveCurrentCombo("cbosupplier");
		
			for ( var loop = 0; loop < XMLSupId.length; loop ++)
			{
				var opt = document.createElement("option");
				opt.text = XMLSupNm[loop].childNodes[0].nodeValue;
				opt.value = XMLSupId[loop].childNodes[0].nodeValue;
				document.getElementById("cbosupplier").options.add(opt);
	
			}
			
			if (loop > 1)
			{
				alert("There are two or more suppliers having the same invoice number ! Therefore please select the correct supplier from list !");
				var have2sup = 'true';
				var supplier = document.getElementById('cbosupplier').value;
				/*var url='supplierInvXML.php?RequestType=getInvoiceNoPayble&paymentType=' + paymentType + '&InvNo=' + URLEncode(InvNo) +'&supplier='+supplier;
				htmlobj      	= $.ajax({url:url,async:false});
				var XMLBatchNo 	= htmlobj.responseXML.getElementsByTagName("BatchNo");
				var XMLSupplier = htmlobj.responseXML.getElementsByTagName("Supplier");
				var XMLEntryNo 	= htmlobj.responseXML.getElementsByTagName("EntryNo");
				
				if(XMLBatchNo.length>0)
				{
					alert("Invoice No already exist.\n Invoice No : "+InvNo+"\n Supplier : "+XMLSupplier[0].childNodes[0].nodeValue+"\n Batch No : "+XMLBatchNo[0].childNodes[0].nodeValue+"\n Entry No : "+XMLEntryNo[0].childNodes[0].nodeValue);
					return;
				}*/
					
			}
			
			
			GetSupplierInvoiceDetails(have2sup);
	}
}

function newclearPage()
{

   	document.frmsupinv.reset();
	document.getElementById("txtinvno").value = InvoiNo;
	document.getElementById("cbosupplier").value = SupId;
	document.getElementById("cboinvdate").value = invDate;
    var tblArr=['tblpodetails','tbltaxdetails','tblglaccounts','tblFreight','tblInsurance','tblOther'];
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
    /*loadCombo('SELECT strSupplierID,strTitle AS strName FROM suppliers WHERE intStatus=1 ORDER BY strTitle','cbosupplier');*/
    document.getElementById('cbocompany').innerHTML=""
	 
}


function GetSupplierInvoiceDetails(have2sup)
{
	getCurrencyRate();
	InvoiNo = document.getElementById("txtinvno").value.toUpperCase();	
	SupId = document.getElementById("cbosupplier").value;
	strPaymentType = document.getElementById("cboPymentType").value;
	invDate = document.getElementById("cboinvdate").value;

	var url='supplierInvXML.php?RequestType=getInvoiceNoPayble&paymentType=' + strPaymentType + '&InvNo=' + URLEncode(InvoiNo) +'&supplier='+SupId;
				htmlobj      	= $.ajax({url:url,async:false});
				var XMLBatchNo 	= htmlobj.responseXML.getElementsByTagName("BatchNo");
				var XMLSupplier = htmlobj.responseXML.getElementsByTagName("Supplier");
				var XMLEntryNo 	= htmlobj.responseXML.getElementsByTagName("EntryNo");
				
				if(XMLBatchNo.length>0)
				{
					alert("Invoice No already exist.\n Invoice No : "+InvNo+"\n Supplier : "+XMLSupplier[0].childNodes[0].nodeValue+"\n Batch No : "+XMLBatchNo[0].childNodes[0].nodeValue+"\n Entry No : "+XMLEntryNo[0].childNodes[0].nodeValue);
					newclearPage();
					document.getElementById("cboPymentType").value = strPaymentType;
					return;
				}
	
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index = incr ;
	altxmlHttpArray[incr].have2sup = have2sup;
	altxmlHttpArray[incr].onreadystatechange = HandleGetSupplierInvoiceDetails;
	altxmlHttpArray[incr].open("GET",'supplierInvXML.php?RequestType=GetSupplierInvoiceDetails&strPaymentType=' + strPaymentType + '& InvoiceNo=' + URLEncode(InvoiNo) + '&SupplierId=' + SupId,true);
	altxmlHttpArray[incr].send(null);
	incr++;
}

function HandleGetSupplierInvoiceDetails()
{
	if(altxmlHttpArray[this.index].readyState == 4) 
    {
        if(altxmlHttpArray[this.index].status == 200) 
        {
			
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
				{ 	
					if(optCombo1[i].text == XMLPOCurrency[loop].childNodes[0].nodeValue)
					{
						document.getElementById("cbocurrency").options.selectedIndex = optCombo1[i].index;
						getCurrencyRate();
					}
				}
				
				/* Select Supplier CreditPeriod */
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
			
			loadInvDet();
			
			LoadSupplierGL();
			
			totGRNAmount = 0;
			
			//InvoicePayable(altxmlHttpArray[this.index].have2sup);
			
			LoadPoDetails();
			
			genDescription();
			
			ShowAllTax();
			
			setTotGlVale();
			
		}		
	}
}
//lasanhta ------------ Load other Inv Details-----------------------------------------------------------
//Commission-Entry No-Freight-Insurance-other-Vat GL Acc
function loadInvDet(){
	
	var invNo=document.getElementById('txtinvno').value.toUpperCase();
	var path="supplierInvXML.php?RequestType=loadInvOther&invNo="+URLEncode(invNo);
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
		//document.getElementById("txtcommission").value=XMLCommission[0].childNodes[0].nodeValue;
	}
	if(XMLEntryNo.length > 0){
		document.getElementById("txtentryno").value=parseFloat(XMLEntryNo[0].childNodes[0].nodeValue)+1;
	}
		//document.getElementById("txtlineno").value=XMLLineNo[0].childNodes[0].nodeValue;
	if(XMLFreight.length > 0){
		//document.getElementById("txtfreight").value=XMLFreight[0].childNodes[0].nodeValue;
	}
	if(XMLInsurance.length > 0){
		//document.getElementById("txtinsurance").value=XMLInsurance[0].childNodes[0].nodeValue;
	}
	if(XMLOther.length > 0){
		//document.getElementById("txtother").value=XMLOther[0].childNodes[0].nodeValue;
	}
	if(XMLVATGLAcc.length > 0){
		//document.getElementById("txtvatgl").value=XMLVATGLAcc[0].childNodes[0].nodeValue;
	}
}
//--------------------------------------END-------------------------------------------------------------
//Clear ListBox

function getEntryNo()
{
	pubXMLBatchNo = $('#cbobatch').val();
	if(pubXMLBatchNo=="")
	{
		document.getElementById("txtBatchId").value="";
		document.getElementById("txtentryno").value="";
		return;
	}
	var url = "supplierInvXML.php?RequestType=getEntryNoandBatchId&pubXMLBatchNo="+pubXMLBatchNo;
	htmlobj = $.ajax({url:url,async:false});
	 pubXMLBatchId = htmlobj.responseXML.getElementsByTagName("batchId")[0].childNodes[0].nodeValue;
	 pubXMLLoadEntryNo = htmlobj.responseXML.getElementsByTagName("EntryNo")[0].childNodes[0].nodeValue;
	
	document.getElementById("txtBatchId").value=pubXMLBatchId;
	document.getElementById("txtentryno").value=pubXMLLoadEntryNo;
		
}

function setBatchCurrency(batchNo)
{
	
}
/*function setLineNumber()
{
	var tbl = document.getElementById('tblglaccounts').tBodies[0];
	var count=0;
	for ( var loop = 0 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{
			count++;
		}
	}
	document.getElementById('txtlineno').value=count;
}*/
function setLineNumber()
{
	var tbl = document.getElementById('tblglaccounts');
	var count=0;
	for ( var loop = 0 ;loop < tbl.rows.length ; loop ++ )
	{
		if(tbl.rows[loop].cells[0].childNodes[0].checked)
		{
			count++;
		}
	}
	var tblTax = document.getElementById('tbltaxdetails');
	for(var loop = 1 ;loop < tblTax.rows.length ; loop ++){
		if(tblTax.rows[loop].cells[0].childNodes[0].checked)
		{
			count++;
		}
	}
	var tblFreight = document.getElementById('tblFreight').tBodies[0];
	var fC=0;
	for(var loop = 0 ;loop < tblFreight.rows.length ; loop ++){
		if(tblFreight.rows[loop].cells[0].checked)
		{
				count++;
				fC=1;
		}
	}
	if(fC==0){
		if(Number(document.getElementById('txtfreight').value.trim())!=0)
				count++;	
	}
	var tblCourier = document.getElementById('tblInsurance').tBodies[0];
	var cC=0;
	for(var loop = 0 ;loop < tblCourier.rows.length ; loop ++){
		if(tblCourier.rows[loop].cells[0].checked)
		{
			count++;
			cC=1;
		}
	}
	if(cC==0){
		if(Number(document.getElementById('txtinsurance').value.trim())!=0)
				count++;
	}
	var tblOther = document.getElementById('tblOther').tBodies[0];
	var cO=0;
	for(var loop = 0 ;loop < tblOther.rows.length ; loop ++){
		if(tblOther.rows[loop].cells[0].childNodes[0].checked)
		{
				count++;
		}
	}
	if(cC==0){
		if(Number(document.getElementById('txtother').value.trim())!=0)
			count++;
	}
	document.getElementById('txtlineno').value=count;
}
function clckGLBox(value,row)
{
	var tbl = document.getElementById('tblglaccounts');
	if(value == 0 || value == "")
	{
		tbl.rows[row].cells[0].childNodes[0].childNodes[0].checked = false;
	}
	else
		tbl.rows[row].cells[0].childNodes[0].childNodes[0].checked = true;
}


function RemoveCurrentCombo(comboname)
{
	var index = document.getElementById(comboname).options.length;
	while(document.getElementById(comboname).options.length > 0) 
	{
		index --;
		document.getElementById(comboname).options[index] = null;
	}
}
function LoadCurrency(invNo,supId,type)
{
	var path='supplierInvXML.php?RequestType=LoadCurrency&strPaymentType='+type+'&invNo='+invNo+'&supId='+supId;
	htmlobj=$.ajax({url:path,async:false});
	var XMLCurrCd = htmlobj.responseXML.getElementsByTagName("CurrCd");
	var XMLRate = htmlobj.responseXML.getElementsByTagName("Rate");
	if(XMLCurrCd.length>0)
	{
		document.getElementById("cbocurrency").value=XMLCurrCd[0].childNodes[0].nodeValue;
		document.getElementById("txtcurrate").value=XMLRate[0].childNodes[0].nodeValue;
	}
}

function getCurrencyRate()//lasantha
{
	var SupID   = document.getElementById("cbosupplier").value;
	var InvNo   = document.getElementById("txtinvno").value.toUpperCase();
	var payType = document.getElementById("cboPymentType").value;
	var path="supplierInvXML.php?RequestType=loadCurrate&SupID="+SupID+"&InvNo="+URLEncode(InvNo)+"&payType="+URLEncode(payType);
	
	htmlobj=$.ajax({url:path,async:false});
	var XMLCurRate	=htmlobj.responseXML.getElementsByTagName("Rate");
	document.getElementById("txtcurrate").value="";
	document.getElementById("txtcurrate").value=XMLCurRate[0].childNodes[0].nodeValue;
}

//Load Credit Periods
function LoadCreditPeriod(invNo,supId,type)
{
	if(supId=="")
		return;
	var invoiceDate = document.getElementById('cboinvdate').value;
	var url = 'supplierInvXML.php?RequestType=LoadCreditPeriod&PaymentType='+type+'&supId='+supId+'&invoiceDate='+invoiceDate+'&invNo='+invNo;
	htmlobj = $.ajax({url:url,async:false});

	var XMLNoOfDays  		= htmlobj.responseXML.getElementsByTagName("NoOfDays");
	var XMLinvoiceDueDate	= htmlobj.responseXML.getElementsByTagName("invoiceDueDate");
	var creditPeriod	 	= XMLNoOfDays[0].childNodes[0].nodeValue;
	document.getElementById("cbocreditprd").value = creditPeriod;	
	document.getElementById("txtdatedue").value   = XMLinvoiceDueDate[0].childNodes[0].nodeValue;
}
function LoadBatch()
{
	createAltXMLHttpRequest();
	altxmlHttp.onreadystatechange = HandleLoadBatch;
	altxmlHttp.open("GET",'supplierInvXML.php?RequestType=LoadBatch&strPaymentType=N',true);
	altxmlHttp.send(null);
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
			/*var XMLGLAccId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccId");
			var XMLGLAccDesc = altxmlHttpArray[this.index].responseXML.getElementsByTagName("GLAccDesc");*/
			var XMLSelected = altxmlHttpArray[this.index].responseXML.getElementsByTagName("Selected");
			
			var XMLAccNo = altxmlHttpArray[this.index].responseXML.getElementsByTagName("accNo");
			var XMLDesc = altxmlHttpArray[this.index].responseXML.getElementsByTagName("accName");
			var XMLfacId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("facId"); 
			var XMLfacAccId = altxmlHttpArray[this.index].responseXML.getElementsByTagName("facAccId"); 
			var boolcheck = false;
			var tableText = "<table width=\"582\" cellpadding=\"0\" border=\"0\" cellspacing=\"1\" id=\"tblglaccounts\" bgcolor=\"#CCCCFF\">"  +
						"<tr class=\"mainHeading4\">"+
							 "<td width=\"39\" height=\"20\" >*</td>" +
							 "<td width=\"102\" >GL Acc Id</td>" +
              				 "<td width=\"302\" >Description</td>" +
              				 "<td width=\"115\" >Amount</td>" + 
						 "</tr>";
						 
				
				for(var loop = 0; loop < XMLAccNo.length; loop++)
				{
					var accNo=XMLAccNo[loop].childNodes[0].nodeValue;
					var accName=XMLDesc[loop].childNodes[0].nodeValue;
					var facId=XMLfacId[loop].childNodes[0].nodeValue;
					var facAccId=XMLfacAccId[loop].childNodes[0].nodeValue;
						
					var selection = "";
					var GLAmt = 0 ;
					
				/*	if (XMLSelected[loop].childNodes[0].nodeValue == "True")
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
					else*/
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckTextBox(this),setLineNumber();\"  />";
			
						tableText += "<tr class=\"bcgcolor-tblrowWhite\">"+
									"<td class=\"normalfnt\"><div align=\"center\">"+ selection +"</div></td>" +
									"<td class=\"normalfnt\" id=\"" +facId + "\" style=\"text-align:left;\">" + accNo+""+facAccId + "</td>" +
									"<td class=\"normalfnt\" id=\"" + XMLDesc[loop].childNodes[0].nodeValue + "\" style=\"text-align:left;\">" +accName + "</td>" +
									"<td class=\"normalfnt\"><input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox lastcellz\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onkeyup=\"clckGLBox(this.value,this.parentNode.parentNode.rowIndex);setTotGlVale();setAmountToGlAcc(event,this)\" onblur=\"setFixedValue(this.value,this.parentNode.parentNode.rowIndex);\" value=\""+ GLAmt +"\"> " +
									"</input></td>" +
									"</tr>";
					boolcheck = true;
				}
				tableText+="</table>";
				document.getElementById("divcons").innerHTML = tableText;
				if(!boolcheck)
				{
					
					var tbl = document.getElementById('tblglaccounts');
					var lastRow = tbl.rows.length;	
					var row = tbl.insertRow(lastRow);
					row.className="bcgcolor-tblrowWhite";
						
					var cellCheck = row.insertCell(0);   
					cellCheck.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" disabled=\"disabled\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" /></div>";
					
					var cellGLId = row.insertCell(1);
					cellGLId.ondblclick = changeToStyleTextBox;
					 
					var cellDescription = row.insertCell(2);  
					
					var cellAmt = row.insertCell(3);
				}
			//	event_setter();
		}
	}
}

//Clear GL Accounts Table Data
function ClearTableData()
{
	var tableText = "<table width=\"582\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblglaccounts\"> " +
                  				"<tr class=\"bcgcolor-tblrowWhite\"><td width=\"39\" height=\"22\" class=\"normaltxtmidb2\">*</td> " +
                    			"<td width=\"102\" class=\"normaltxtmidb2\">GL Acc Id</td>" +
                    			"<td width=\"302\" class=\"normaltxtmidb2\">Description</td>" +
                    			"<td width=\"115\" class=\"normaltxtmidb2\">Amount</td>" +
                    			"</tr></table>";
	document.getElementById("divcons").InnerHTML = tableText;
}

function checkInvoiceBalence()
{
	var SupID = document.getElementById("cbosupplier").value;
	var InvNo = document.getElementById("txtinvno").value.toUpperCase();
		InvNo =URLEncode(InvNo);
		strPaymentType=document.getElementById("cboPymentType").value
	
		var url='supplierInvXML.php?RequestType=getInvoiceBalance&strPaymentType=' + strPaymentType + '&SupplierId=' + SupID + '&InvoiceNo=' + InvNo;
		htmlobj=$.ajax({url:url,async:false});
		var XMLInvNo = htmlobj.responseXML.getElementsByTagName("invNo");
			if(XMLInvNo.length>0)
			{
				var invNo = XMLInvNo[loop].childNodes[0].nodeValue;	
			}
}

// Calculate Invoice Payable Data
function InvoicePayable(have2sup)
{
	var SupID = document.getElementById("cbosupplier").value;
	var InvNo = document.getElementById("txtinvno").value.toUpperCase();
		InvNo =URLEncode(InvNo);
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
					balamt=new Number(balamt).toFixed(2);
				}
				else
				{
					balamt=new Number(balamt).toFixed(2);
				}
					
					
					
					if(balamt>0)
					{
			alert("Total GRN amount for this PO "+parseFloat(totGRNAmount)+"\n"+"You have entered invoice/s for "+ PaidAmount + " of " + Currency + ".The new entry allow only for the balance(" + parseFloat(balamt).toFixed(2) + ")")			
					
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
				//document.getElementById("txtinvoiceamount").value 	=  new Number(pub_grnBalance).toFixed(4);
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
	document.getElementById('cbobatch').value="";
	document.getElementById('txtGLTotal').value="";
	
	var strgltbl="<table width=\"582\" cellpadding=\"0\" border=\"0\" cellspacing=\"1\" id=\"tblglaccounts\" bgcolor=\"#CCCCFF\">"  +
						"<tr class=\"mainHeading4\">"+
							 "<td width=\"39\" height=\"20\" >*</td>" +
							 "<td width=\"102\" >GL Acc Id</td>" +
              				 "<td width=\"302\" >Description</td>" +
              				 "<td width=\"115\" >Amount</td>" + 
						 "</tr>"+
						 "</table>"
	document.getElementById('divcons').innerHTML=strgltbl
	
	var strpotbl="<table width=\"450\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblpodetails\" bgcolor=\"#CCCCFF\">"+
	"<tr class=\"mainHeading4\">"+
	"<td width=\"39\" height=\"22\"  >*</td>"+
	"<td width=\"22%\" height=\"22\" >PO NO </td>"+
	"<td width=\"18%\" >Currency</td>"+
	"<td width=\"18%\"  >Amount</td>"+
	"<td width=\"18%\"  >Balance</td>"+
	"<td width=\"15%\"  class=\"mainHeading4\">View</td>"+
	"</tr>"+
	"</table>"
	
	document.getElementById('divcons2').innerHTML=strpotbl
	
	
	var strpaymenttax = "<table width=\"500\" cellpadding=\"0\" cellspacing=\"1\" id=\"tbltaxdetails\" bgcolor=\"#CCCCFF\">"+
						"<tr class=\"mainHeading4\">"+
						"<td width=\"39\" height=\"22\" >*</td>"+
						"<td width=\"208\" >Tax</td>"+
						"<td width=\"87\" >Rate</td>"+
						"<td width=\"103\" >Amount</td>"+
						"<td width=\"50\" >Tax GL</td>"+
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
	
	clearCharges('tblFreight');
	clearCharges('tblInsurance');
	clearCharges('tblOther'); 
}
function clearCharges(tbl){
	var tbl=document.getElementById(tbl).tBodies[0]
	var rc=tbl.rows.length;
	for(var i=0;i<rc;i++){
		tbl.rows[i].cells[0].childNodes[0].checked=false;
		tbl.rows[i].cells[3].childNodes[0].vale=0;
	}
}
function validateGrnAmountVsGLAmount(GlAmt)
{
	
	/*var TotGLAmt = parseFloat(document.getElementById('txtGLTotal').value);
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
			
			/*if(TotGLAmt.toFixed(4) < GlAmt.toFixed(4))
			{

				alert("Total GL value can not be exceed Invoice Value!");
				//tbl.rows[loop].cells[3].childNodes[0].value = 0;
				//document.getElementById('txtGLTotal').value=0;
			}
			else{
				//setGLTotal(GlAmt.toFixed(4)-TotGLAmt.toFixed(4),1);
			}
		}
	}
	if (TotGLAmt != GlAmt)
	{

	}
	else*
	if(TotGLAmt.toFixed(4) > GlAmt.toFixed(4))
	{	
		setGLTotal(TotGLAmt-GlAmt,0);
		alert("Total GL value not tally with Invoice Value!" + "\n" + "You have to put more: " + (TotGLAmt - GlAmt).toFixed(4) + " in to Gl Accounts !");
	}		*/
}

function setGLTotal(glTot,i){
	if(i==1)
		document.getElementById('txtGLTotal').value=-glTot.toFixed(2);
	else
		document.getElementById('txtGLTotal').value=glTot.toFixed(2);
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
		var url = 'supplierInvXML.php?RequestType=LoadCreditDuePeriod&invoiceDate=' + invoiceDate + '&creditPeriod=' + creditPeriod;
		htmlobj = $.ajax({url:url,async:false});
		var InvDueDate =  htmlobj.responseXML.getElementsByTagName("invoiceDueDate")[0].childNodes[0].nodeValue;
		document.getElementById("txtdatedue").value = InvDueDate;
	}
}

/*function LoadPoDetails()
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
}*/
//--------------
function LoadPoDetails()
{
	
	var SupID = document.getElementById("cbosupplier").value;
	var InvNo = document.getElementById("txtinvno").value.toUpperCase();
		InvNo =URLEncode(InvNo);
	var crId="";	
	strPaymentType=document.getElementById("cboPymentType").value
	var url  = 'supplierInvXML.php?RequestType=LoadPoDetails&strPaymentType=' + strPaymentType + '&SupplierId=' + SupID + '&InvoiceNo=' + InvNo;
	htmlobj=$.ajax({url:url,async:false});	
	
			var XMLCurrencyId = htmlobj.responseXML.getElementsByTagName("BTNO");
			var XMLPONo = htmlobj.responseXML.getElementsByTagName("PO");
			var XMLCurrency = htmlobj.responseXML.getElementsByTagName("Currency");
			var XMLPOAmount = htmlobj.responseXML.getElementsByTagName("POAmount");
			var XMLPOBalance = htmlobj.responseXML.getElementsByTagName("POBalance");
			var XMLAdvancePOBal = htmlobj.responseXML.getElementsByTagName("AdvancedPOBal");
			var XMLSelected =htmlobj.responseXML.getElementsByTagName("Selected");
			var XMLgrnBalance = htmlobj.responseXML.getElementsByTagName("grnBalance");
			var XMLinvoiceAmount = htmlobj.responseXML.getElementsByTagName("invoiceAmount");
			var CurrencyId	= XMLCurrencyId[0].childNodes[0].nodeValue;
			
			
			
			var url  = 'supplierInvXML.php?RequestType=getBatchNo&CurrencyId='+CurrencyId;
			html_obj = $.ajax({url:url,async:false});
			XMLBatchNo = html_obj.responseText;
			document.getElementById('cbobatch').innerHTML = XMLBatchNo;
			
			if(pubCurrencyId==CurrencyId)
			{
				document.getElementById('cbobatch').value = pubXMLBatchNo;
				//document.getElementById("txtBatchId").value=pubXMLBatchId;
				//document.getElementById("txtentryno").value=pubXMLLoadEntryNo;
				document.getElementById('cbobatch').onchange(); 
			}
			
			pubCurrencyId = CurrencyId;
			
			tableText = "<table width=\"450\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblpodetails\" bgcolor=\"#CCCCFF\">"  +
						"<tr class=\"mainHeading4\">"+
							 "<td width=\"25\" height=\"22\">*</td>" +
							 "<td width=\"80\" >PO NO</td>" +
              				 "<td width=\"70\" >Currency</td>" +
              				 "<td width=\"70\" >Amount</td>" + 
							 "<td width=\"85\" >Advance Bal </td>" +
              				 "<td width=\"70\" >Balance</td>" +
              				 "<td width=\"50\" >View</td>" +
						 "</tr>";
			
			var selType=document.getElementById("cboPymentType").value;
			
//			alert(XMLPONo.length)
			var poBalance = 0;
			var grnBalance = 0;
			var invBalance=0;
			for(var loop = 0; loop < XMLPONo.length ; loop++)
			{
				var PONo = XMLPONo[loop].childNodes[0].nodeValue;
				var Currency = XMLCurrency[loop].childNodes[0].nodeValue;
				var POAmount = XMLPOAmount[loop].childNodes[0].nodeValue;
				var AdvncedPOBal = (XMLAdvancePOBal[loop].childNodes[0].nodeValue==""?0:XMLAdvancePOBal[loop].childNodes[0].nodeValue);
				var x = parseFloat(XMLPOBalance[loop].childNodes[0].nodeValue);
				var invAmount = parseFloat(XMLinvoiceAmount[loop].childNodes[0].nodeValue);
				
				if(x>0)
					poBalance +=x;
					//alert(poBalance);
					
				var y = parseFloat( XMLgrnBalance[loop].childNodes[0].nodeValue );
				if(y>0)
					grnBalance +=y;
					//alert("GRN BALANCE"+y);
					
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
				
				tableText += "<tr class=\"bcgcolor-tblrowWhite\">"+
							 "<td class=\"normalfnt\"><div align=\"center\">"+ selection +"</div></td>" +
							 "<td class=\"normalfnt\">"+ PONo +"</td>" +
              				 "<td class=\"normalfnt\" style=\"text-align:left;\">"+ Currency +"</td>" +
              				 "<td class=\"normalfnt\" style=\"text-align:right;\">"+ parseFloat(POAmount).toFixed(2) +"</td>" +
							 "<td class=\"normalfnt\" style=\"text-align:right;\">"+ parseFloat(AdvncedPOBal).toFixed(2) +"</td>" +
              				 "<td class=\"normalfnt\" style=\"text-align:right;\">"+ parseFloat(x).toFixed(2) +"</td>"
	
							 	tableText +="<td class=\"normalfnt\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\" onclick=\"loadPo(this)\" /></div></td>"
					
							 
							 tableText +="</tr>";
				}

				if(invAmount>0)
					grnBalance-=invAmount;
				
			if(! isNaN(invAmount) && invAmount > 0)
			alert("Total GRN amount for this PO ( "+(parseFloat(invAmount)+grnBalance)+" )\n"+"You have entered invoice/s for ( "+ invAmount + " ).The new entry allow only for the balance( " + parseFloat(grnBalance).toFixed(2)  + " )")		//roundNumber(grnBalance,2)
						
				/*if(parseFloat(poBalance) < parseFloat(grnBalance))
				{
						grnBalance = poBalance;
				}*/
				
				//alert(Math.round(grnBalance*100)/100);
				document.getElementById("txttotglamount").value = parseFloat(grnBalance).toFixed(2); //roundNumber(grnBalance,4);//ok
		
				document.getElementById("txtGLTotal").value = parseFloat(grnBalance).toFixed(2);
					
				document.getElementById("txtinvoiceamount").value = parseFloat(grnBalance).toFixed(2); //roundNumber(grnBalance,4);
				
				tableText += "</table>";
				document.getElementById("divcons2").innerHTML = tableText;

}

function addNewGLRow(rowIndex)
{	
	var tbl=document.getElementById('tblglaccounts');
	var rc=tbl.rows.length;
	
		if(rc==rowIndex+1)
		{
		
			var row = tbl.insertRow(rc);
			row.className="bcgcolor-tblrowWhite";
				
			var cellCheck = row.insertCell(0);   
			cellCheck.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" disabled=\"disabled\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" /></div>";
			
			var cellGLId = row.insertCell(1);
			cellGLId.ondblclick = changeToStyleTextBox;
			cellGLId.align = "Left";
			cellGLId.innerHTML ="<input type=\"text\" name=\"txtGLID\" id=\"txtGLID\" onkeydown=\"isEnterKey(this,event,this.value,this.parentNode.parentNode.rowIndex);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return isNumberKey(event,this.value);\" class=\"txtbox\" value =\"\" size=\"13\">";
	
	$( "#txtGLID" ).autocomplete({
		source: pub_po_arr
	});
			 
			var cellDescription = row.insertCell(2);  
			
			var cellAmt = row.insertCell(3);   
				
	}
}

function clckSGLBox(obj){
		obj.parentNode.parentNode.cells[0].childNodes[0].checked=true;	
	
	//obj.parentNode.parentNode.cells[0].childNodes[0].onclick();
		setLineNumber();
	//setPOValue();
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
			tableText = "<table width=\"450\" cellpadding=\"0\" cellspacing=\"1\" id=\"tblpodetails\" bgcolor=\"#CCCCFF\">"  +
						"<tr class=\"mainHeading4\">"+
							 "<td width=\"39\" height=\"22\" >*</td>" +
							 "<td width=\"22%\" >PO NO</td>" +
              				 "<td width=\"18%\" >Currency</td>" +
              				 "<td width=\"18%\" >Amount</td>" + 
              				 "<td width=\"18%\" >Balance</td>" +
              				 "<td width=\"15%\" >View</td>" +
						 "</tr>";
			
			var selType=document.getElementById("cboPymentType").value;
			
//			alert(XMLPONo.length)
			var poBalance = 0;
			var grnBalance = 0;
			var invBalance=0;
			for(var loop = 0; loop < XMLPONo.length ; loop++)
			{
				var PONo = XMLPONo[loop].childNodes[0].nodeValue;
				var Currency = XMLCurrency[loop].childNodes[0].nodeValue;
				var POAmount = XMLPOAmount[loop].childNodes[0].nodeValue;
				var x = parseFloat(XMLPOBalance[loop].childNodes[0].nodeValue);
				var invAmount = parseFloat(XMLinvoiceAmount[loop].childNodes[0].nodeValue);
				
				if(x>0)
					poBalance +=x;
					//alert(poBalance);
					
				var y = parseFloat( XMLgrnBalance[loop].childNodes[0].nodeValue );
				if(y>0)
					grnBalance +=y;
					//alert("GRN BALANCE"+y);
					
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
              				 /*"<td class=\"normalfntRite\"><div align=\"center\"><a href=\"#\">View</a></div></td>";*/
							 
							// if(selType=="G")
							// {
							 //	tableText +="<td class=\"normalfntRite\"><div align=\"center\"><a href= \"../GeneralInventory/GeneralPO/generalPurchaeOrderReport.php?bulkPoNo=" + POr[1] + "&intYear=" + POr[0] + "\">view</a></div></td>"
							 	//tableText +="<td class=\"normalfntRite\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\" onclick=\"loadPo(" + PONo + ",'G')\" /></div></td>"
							 //}
							// else if(selType=="S")
							// {
								//tableText +="<td class=\"normalfntRite\"><div align=\"center\"><a href=\"../reportpurchase.php?pono=" + POr[1] + "&year=" + POr[0] + "\">view</a></div></td>"	
							 	tableText +="<td class=\""+rowColor+"\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\" onclick=\"loadPo(this)\" /></div></td>"
							// }
							 
							 tableText +="</tr>";
				}
				//alert(invAmount);
				//alert(grnBalance);
				if(invAmount>0)
					grnBalance-=invAmount;
				
			if(! isNaN(invAmount) && invAmount > 0)
			alert("Total GRN amount for this PO ( "+(parseFloat(invAmount)+grnBalance)+" )\n"+"You have entered invoice/s for ( "+ invAmount + " ).The new entry allow only for the balance( " + roundNumber(grnBalance,2) + " )")		
						
				if(parseFloat(poBalance) < parseFloat(grnBalance))
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
	var url ='supplierInvXML.php?RequestType=ShowAllTax&strPaymentType=N';
	htmlobj = $.ajax({url:url,async:false});
	
			var XMLTaxID 	= htmlobj.responseXML.getElementsByTagName("TaxID");
			var XMLTaxType  = htmlobj.responseXML.getElementsByTagName("TaxType");
			var XMLTaxRate  = htmlobj.responseXML.getElementsByTagName("TaxRate");
			var XMLSelected = htmlobj.responseXML.getElementsByTagName("Selected");
			var XMLTAXGL	= htmlobj.responseXML.getElementsByTagName("TAXGL");
			var XMLTAXCode	= htmlobj.responseXML.getElementsByTagName("TAXCode");
			
			taxText = "<table width=\"457\" cellpadding=\"0\" cellspacing=\"1\" id=\"tbltaxdetails\" bgcolor=\"#CCCCFF\">"+					
						"<tr class=\"mainHeading4\">"+
			  			"<td width=\"39\" height=\"20\"  >*</td>"+
			  			"<td width=\"208\"  >Tax</td>"+
			  			"<td width=\"87\"  >Rate</td>"+
			  			"<td width=\"103\" >Amount</td>"+
						"<td width=\"50\"  >Tax GL</td>"
			  			"</tr>";
			for(var loop = 0; loop < XMLTaxID.length ; loop++)
			{				
				if(XMLTaxType[loop].childNodes[0].nodeValue=="" && XMLTaxRate[loop].childNodes[0].nodeValue=="")
					continue;
				
				var selection = "";
				if (XMLSelected[loop].childNodes[0].nodeValue == "True")
					selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
				else
					selection = "<input type=\"checkbox\" name=\"checkboxNS\" id=\"checkbox\" onclick=\"checkUncheckCheckBox(this.parentNode.parentNode.parentNode.rowIndex);\" />";
							
					taxText += "<tr class=\"bcgcolor-tblrowWhite\">"+
			  				 "<td class=\"normalfnt\"><div align=\"center\">"+ selection +"</div></td>"+
			  				 "<td class=\"normalfnt\" id=\""+  XMLTaxID[loop].childNodes[0].nodeValue +"\" style=\"text-align:left;\">"+ XMLTaxType[loop].childNodes[0].nodeValue +"</td>"+
			  				 "<td class=\"normalfnt\" style=\"text-align:right;\">"+  XMLTaxRate[loop].childNodes[0].nodeValue +"</td>"+
"<td class=\"normalfnt\"><input type=\"text\" id=\"taxamount\" name=\"taxamount\" class=\"txtbox\" style=\"width:100px;text-align:right;\" align =\"right\" onkeypress=\"return isNumberKey(event);\" value=\""+ 0 +"\" >" +
							"</input></td>"+
							"<td class=\"normalfnt\" id=\""+  XMLTAXGL[loop].childNodes[0].nodeValue +"\"><div align=\"center\">"+ XMLTAXCode[loop].childNodes[0].nodeValue +"</div></td>"+
			  				"</tr>";
				}
				taxText += "</table>";
				document.getElementById("divcons3").innerHTML = taxText;
				var supID = document.getElementById('cbosupplier').value.trim();
				setTax(supID);
					
}

function rEntry(){
	
}
function checkUncheckCheckBox(rowIndex)
{
	setTotGlVale();
}

function calculateTaxAmount(rw)
{
	var rwTaxAmt = new Number(0);
	var TaxAmt = new Number(0);
	var tbl = document.getElementById('tbltaxdetails');
		
	if(rw.cells[4].id =="0")
	{
		var TotGRNAmt = parseFloat(document.getElementById('txttotglamount').value);
		var TaxRate = parseFloat(rw.cells[2].childNodes[0].nodeValue);
		var rwTaxAmt = rwTaxAmt+((TotGRNAmt/100) * TaxRate);	

	}
	else
	{
		var TotGRNAmt = parseFloat(document.getElementById('txtcommission').value);
		var TaxRate = parseFloat(rw.cells[2].childNodes[0].nodeValue);
		var rwTaxAmt = rwTaxAmt+((TotGRNAmt/100) * TaxRate);
		TaxAmt+=rwTaxAmt;	
	}
			
	rw.cells[3].childNodes[0].value = rwTaxAmt.toFixed(2);
	document.getElementById('txttottaxamount').value = TaxAmt.toFixed(2);
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
			tbl.rows[loop].cells[3].childNodes[0].value = rwTaxAmt.toFixed(2);
			TaxAmt = TaxAmt + (rwTaxAmtMin * -1);
	}
	document.getElementById('txttottaxamount').value = TaxAmt.toFixed(2);
}


function CalculateTotalInvoiceAmount()
{
	
	setTotGlVale();
}

function checkUncheckTextBox(objevent)
{
	var tbl = document.getElementById('tblglaccounts');
	var rw = objevent.parentNode.parentNode.parentNode;
	var tAmt	=document.getElementById('txttotglamount');
	if (rw.cells[0].childNodes[0].checked)
	{
		//rw.cells[3].childNodes[0].value = "0";
	}
	else if(rw.cells[0].childNodes[0].checked == false) 
	{
		rw.cells[3].childNodes[0].value = "";
	}
	setTotGlVale();
	
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
	/*if(pub_grnBalance <dblvalue)
	{
			alert("You can't exceed grn amount of "+pub_grnBalance);
			document.getElementById("txttotglamount").value = pub_grnBalance;
			document.getElementById("txtinvoiceamount").value = pub_grnBalance;
	}*/
}

function setBalance()
{
	document.getElementById('cbocurrency').options.selectedIndex;
	var strCurrency = document.getElementById("tblglaccounts").value=document.getElementById('cbocurrency').options[CurIndex].text
}

function SaveInvoice()			// Save Invoice 
{
	showPleaseWait();
	if(document.getElementById('txtinvno').value.trim()==""){
		alert("Please enter \"Invoice No\".");
		hidePleaseWait();
		document.getElementById('txtinvno').focus();
		return false;
	}
	if(document.getElementById('cbocreditprd').value.trim()==""){
		alert("Please select \"Credit Period\".");
		hidePleaseWait();
		document.getElementById('cbocreditprd').focus();
		return false;
	}
	var amountForGLTotal=parseFloat(document.getElementById('txtGLTotal').value);
	
		if(amountForGLTotal<0)
		{
			alert("Please correctly assign the GL Amount.  GL Amount can not be greater than amount of the invoice")	
			hidePleaseWait();
			return false;
		}
		else if(amountForGLTotal>0)
		{
			alert("Please correctly assign the GL Amount.  GL Amount can not be less than amount of the invoice")	
			hidePleaseWait();
			return false;
		}
	
/*var glAmt=0;
var row=document.getElementById("tblglaccounts").getElementsByTagName("TR");
	if(row.length==2)
	{
		var cell=row[1].getElementsByTagName("TD")
		if(cell[1].innerHTML!="")
		{
			cell[3].firstChild.value=document.getElementById("txttotglamount").value;
		}
		
		glAmt=parseFloat(document.getElementById("txttotglamount").value);
		
	}
	
	else if(row.length>2)
	{
		for(var loop=1;loop<row.length;loop++)
		{
			var cell=row[loop].getElementsByTagName("TD")
			glAmt=parseFloat(glAmt)+parseFloat(cell[3].firstChild.value);	
		}
		
		var amountForGLTotal=parseFloat(document.getElementById('txtGLTotal').value);
		if(parseFloat(amountForGLTotal)<0)
		{
			alert("Please correctly assign the GL Amount.GL Amount can not be greater than amount of the invoice")	
			hidePleaseWait();
			return false;
		}
		else if(parseFloat(amountForGLTotal)>0)
		{
			alert("Please correctly assign the GL Amount.GL Amount can not be less than amount of the invoice")	
			hidePleaseWait();
			return false;
		}
	}*/
	/*else
	{
		alert("Please assign the GL Account Details correctly.")
		hidePleaseWait();
		document.getElementById('btnshowgl').focus();
		return false;
	}
*/
	
	if(document.getElementById("cbobatch").value==0)
	{
		alert("Please select \"Batch No.\"")
		hidePleaseWait();
		document.getElementById('cbobatch').focus();
		return false;
	}
	
	if(document.getElementById("txtinvoiceamount").value == "")
	{
		alert("Please enter valid amount to save.");
		hidePleaseWait();
		document.getElementById('txtinvoiceamount').focus();
		return false;
		//Sexy.alert('<h1>Invoice save fail</h1><p>Please enter valid amount to save!</p>');return false;
	}
	
	if(document.getElementById("txtaccpacid").value == "")
	{
		alert("Please enter Accpac ID.")
		hidePleaseWait();
		document.getElementById('txtaccpacid').focus();
		return false;
		//Sexy.alert('<h1>Invoice save fail</h1><p>Please enter valid Accpac ID to save!</p>');return false;
	}
	
	if (dblAmount > totGRNAmount)
	{
		alert("Please enter valid invoice amount to save!")
		hidePleaseWait();
		return false;
		//Sexy.alert('<h1>Invoice save fail</h1><p>Please enter valid invoice amount to save!</p>');return false;	
	}
	
	var strInvoiceNo = document.getElementById('txtinvno').value.toUpperCase();
	var strSupplierId = document.getElementById('cbosupplier').value;
	var dtmDate = document.getElementById('cboinvdate').value;
	var dblAmount =  parseFloat(document.getElementById('txttotglamount').value);
	var dblInvoiceAmount =  parseFloat(document.getElementById('txtcommission').value);
	var dblAmountTemp	=	parseFloat(document.getElementById('txttotglamountTemp').value);
	
	if(dblAmountTemp!=0){
		if(dblAmount>dblAmountTemp){
			dblAmountTemp=dblAmount-dblAmountTemp;
			//alert(dblAmount-dblAmountTemp);
		}
		else if(dblAmount==dblAmountTemp){
			dblAmountTemp=0;
			//alert(dblAmount);
		}
		else{
			dblAmountTemp=dblAmount-dblAmountTemp;
			//alert(dblAmount-dblAmountTemp);
		}
	}
//alert(dblAmountTemp);
	//return false;
	
	//var dblCommission = parseFloat(document.getElementById('txtcommission').value);
	//var dblCommission=0;
	var dblTotalTax = 0;
	var dblFreight=0;
	var dblInsurance=0;
	var dblOther=0;
	var dblVatGl=0;
	/*
	if(document.getElementById('txtcommission').value != "")
	{
		var dblCommission = parseFloat(document.getElementById('txtcommission').value)
	}*/
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
	var strCurrency = document.getElementById('cbocurrency').value.trim();
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
		//var GlAcc =  tblgl.rows[loop].cells[1].childNodes[0].nodeValue;
		if (tblgl.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
			{
				var GlAcc =  tblgl.rows[loop].cells[1].id;
				var GlAmt =  tblgl.rows[loop].cells[3].childNodes[0].value;
				ArrGlAcc += GlAcc + ",";
				ArrGlAmt += GlAmt + ",";
			 } 
	}
	
	var ArrTaxId  = "";
	var ArrTaxAmt  = "";
	var ArrTaxGLAlocaId = "";
	var ArrTaxCode = "";
	
	var tbltax = document.getElementById('tbltaxdetails');
	for ( var loop = 1 ;loop < tbltax.rows.length ; loop ++ )
	{
		var TaxId =  tbltax.rows[loop].cells[1].id;
		var TaxAmt =  tbltax.rows[loop].cells[3].childNodes[0].value;
		var TaxGLAlocaId =  tbltax.rows[loop].cells[4].id;
		var TaxCode =  tbltax.rows[loop].cells[4].childNodes[0].value;
		
		if (tbltax.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
			{
				ArrTaxId += TaxId + ",";
				ArrTaxAmt += TaxAmt + ",";
				ArrTaxGLAlocaId += TaxGLAlocaId + ",";
				
			 } 
	}
	
	if(document.getElementById('chksuspendedvat').checked==true)
		var suspendedVat=1;
	else
		var suspendedVat=0;
	strPaymentType=document.getElementById("cboPymentType").value
	var accPaccID=document.getElementById("txtaccpacid").value.trim();
	var batchNo=document.getElementById('cbobatch').value.trim();
	var lineNo=(document.getElementById('txtlineno').value.trim()==""?null:document.getElementById('txtlineno').value.trim());
	var invDesc=document.getElementById('txtDescription').value.trim();
	var dueDate=document.getElementById("txtdatedue").value.trim();
	createAltXMLHttpRequestArray(incr);
	altxmlHttpArray[incr].index=incr;
	altxmlHttpArray[incr].onreadystatechange = HandleSaveInvoice;
	var url='supplierInvXML.php?RequestType=SaveInvoice&strPaymentType=' + strPaymentType + '&InvNo=' + URLEncode(strInvoiceNo) + '&SupId=' + strSupplierId + '&InvDt=' + dtmDate + '&InvAmt=' + parseFloat(dblAmount).toFixed(2) + '&InvAmtwithoutNBT=' + parseFloat(dblInvoiceAmount).toFixed(2) + '&InvDesc=' + URLEncode(invDesc) + '&CompId=' + intcompanyiD + '&Status=' + intStatus + '&PaidAmt=' + parseFloat(dblPaidAmount).toFixed(2) + '&BalanceAmt=' + parseFloat(dblBalance).toFixed(2) + '&TotalTaxAmt=' + dblTotalTax + '&FreightAmt=' + dblFreight + '&Insurance=' + dblInsurance + '&Other=' + dblOther + '&VatGl=' + dblVatGl + '&TotalAmt=' + dblTotalAmount + '&Currency=' + strCurrency + '&Paid=' + intPaid + '&CreditPeriod=' + intCreditPeriod + '&CurrencyRate=' + dblCurrencyRate + '&ArrPoNo=' + ArrPoNo + '&ArrCurrency=' + ArrCurrency + '&ArrAmount=' + ArrAmount + '&ArrBalance=' + ArrBalance + '&ArrGlAcc=' + ArrGlAcc + '&ArrGlAmt=' + ArrGlAmt + '&ArrTaxId=' + ArrTaxId + '&ArrTaxAmt=' + ArrTaxAmt + '&batchno=' + batchNo+'&accPaccId='+accPaccID+'&lineNo='+lineNo+'&invDesc='+invDesc+'&dueDate='+dueDate+'&dblAmountTemp='+dblAmountTemp+'&ArrTaxGLAlocaId='+ArrTaxGLAlocaId+'&suspendedVat='+suspendedVat;

		altxmlHttpArray[incr].open("GET",url,true);
		
		altxmlHttpArray[incr].send(null);
		incr++;
		document.getElementById("butSave").style.display="none";
	
}

//======================

function setTax(supID)
{
	var url  = 'supplierInvXML.php?RequestType=setTaxTypes&supID='+supID;
	htmlobj  = $.ajax({url:url,async:false});		
	var Suptax  = htmlobj.responseXML.getElementsByTagName("suptax"); 
	var SuptaxId=0;
	var rows=document.getElementById('tbltaxdetails').getElementsByTagName("TR");
	
	if(Suptax.length>0){
		SuptaxId	= Suptax[0].childNodes[0].nodeValue;
		for(var x=1;x<rows.length;x++)
		{
			var cells=rows[x].getElementsByTagName("TD");
			if(cells[1].id==SuptaxId)
			{
				cells[0].childNodes[0].firstChild.checked=true;
				
			}
		}
	}
	
}

//==============
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
					var supID=document.getElementById('cbosupplier').value.trim();
									saveFreihtCharges(supID);
									saveInsuranceCharges(supID);
									saveOtherCharges(supID);
					alert("Supplier invoice updates successfully !");
					hidePleaseWait();
					clearControls();
					newPage();
					document.getElementById("butSave").style.display="inline";
					//Sexy.info('<h1>Invoice update successful</h1><p>Supplier invoice updates successfuly !</p>');return true;
					//newPage();
				}
				else
				{
					if(XMLSave[loop].childNodes[0].nodeValue == "True")
					{	
								var supID=document.getElementById('cbosupplier').value.trim();
									saveFreihtCharges(supID);
									saveInsuranceCharges(supID);
									saveOtherCharges(supID);
						var batchNoText = document.getElementById("cbobatch").options[document.getElementById("cbobatch").selectedIndex].text;
						
						//alert("Supplier Invoice No : \""+document.getElementById('txtinvno').value.trim()+"\" saved successfully !"+ '\n' + "Batch No : "+batchNoText+" \nEntry No  : "+ entryNo +"");
						alert("Supplier Invoice No : \""+document.getElementById('txtinvno').value.toUpperCase()+"\" saved successfully !"+ '\n' + "Batch No : "+batchNoText+" \nEntry No  : "+ document.getElementById('txtentryno').value +"");
						document.getElementById("butSave").style.display="inline";
						hidePleaseWait();
						clearControls();
						newPage();
						//Sexy.info('<h1>Invoice save successful</h1><p>Supplier invoice saved successful!</p>');return true;
						//newPage();
					}
					else
					{
						alert("There is an error.Supplier invoice save failed !");
						hidePleaseWait();
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
	xmlHttpCheckInvoiceNo.open("GET", 'supplierInvXML.php?RequestType=checkInvoiceNo&strPaymentType=' + strPaymentType + '&supID=' + strSupplierId + '&invoiceNo=' + URLEncode(strInvoiceNo), true);
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
    var tblArr=['tblpodetails','tbltaxdetails','tblglaccounts','tblFreight','tblInsurance','tblOther'];
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
    /*loadCombo('SELECT strSupplierID,strTitle AS strName FROM suppliers WHERE intStatus=1 ORDER BY strTitle','cbosupplier');*/
    document.getElementById('cbocompany').innerHTML=""
	 document.getElementById('cbosupplier').innerHTML=""
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
			
			drawPopupArea(650,450,'frmAllGLAccounts');
			
			var tableText = "<table width=\"650\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblsearch\" bgcolor=\"#FFFFFF\"> " +
							"<tr>"+
							"<td>"+
							"	<table width=\"650\">"+
							"		<tr>"+
			              	"			<td height=\"25\" class=\"mainHeading\">GL Accounts</td>"+
							"		</tr>"+
							"	</table>"+
							"<td>"+
            				"</tr>"+							
							"<tr>"+
							"<td>"+
							"	<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
							"		<tr class=\"mainHeading2\">"+
							"<td width=\"35\" >&nbsp;</td>"+
                    		"<td width=\"50\" >Factory</td>"+
                    		"<td width=\"250\">"+
                      		"<select name=\"cboFactory\"  class=\"normalfnt\" id=\"cboFactory\" style=\"width:250px\">"+
                      		"</select>"+
                    		"</td>"+
                    		"<td>&nbsp;</td>"+
                   	 		"<td width=\"100\" >Acc.Like</td>"+
                    		"<td width=\"200\"><input type=\"text\"  class=\"txtbox\"  name=\"txtNameLike\" id=\"txtNameLike\" size=\"25\" /></td>"+
							"<td ><img src=\"../images/search.png\" onclick=\"getGLAccounts()\" alt=\"search\" /></td>"+
							"</td>"+
							"	</table>"+
							"		</tr>"+
							
							"</tr>"+
							
							
							"</table> " +
							
							"<div id=\"divbuttons\" style=\"overflow:scroll; height:350px; width:650px;\">"+
							"<table width=\"650\" border=\'0\' cellpadding=\"0\" cellspacing=\"1\" id=\"tblallglaccounts\" bgcolor=\"#CCCCFF\"> " +
               				"<thead><tr class=\"mainHeading4\"><td width=\"39\" height=\"22\">*</td> " +
                   			"<td width=\"350\">GL Acc Id</td>" +
                   			"<td width=\"450\">Description</td>" +
                   			"</tr></thead><tbody></tbody>";

				for(var loop = 0; loop < XMLGLAccId.length; loop++)
				{
					var selection = "";
					
					if (XMLSelected[loop].childNodes[0].nodeValue == "True")
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"true\" />";
					else
						selection = "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"\" />";
					var cls;(loop%2==1)?cls='grid_raw':cls='grid_raw2';
					tableText += "<tbody><tr class=\"bcgcolor-tblrowWhite\">"+
								"<td ><div align=\"center\">"+ selection +"</div></td>" +
								"<td style=\"text-align:left;\" id=\"" + XMLGLAccId[loop].childNodes[0].nodeValue + "\">" + XMLGLAccId[loop].childNodes[0].nodeValue + "</td>" +
                    			"<td style=\"text-align:left;\" id=\"" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "\">" + XMLGLAccDesc[loop].childNodes[0].nodeValue + "</td>" +
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
						  	"</tr></tbody>";
				
				var frame = document.createElement("div");
    			frame.id = "glselectwindow";
				document.getElementById('frmAllGLAccounts').innerHTML=tableText;
				
				LoadFactoryList();
		}
	}
}

function AddNewGLAccounttoMain(objevent)
{
	//alert(objevent);
	var tblall = document.getElementById('tblallglaccounts');
	for ( var loop = 0 ;loop < tblall.rows.length ; loop ++ )
	{	
		var boolcheck = false;	
		if (tblall.rows[loop].cells[0].childNodes[0].checked)
		{
			var glAccId = tblall.rows[loop].cells[1].id;
			var rwGLAcc = tblall.rows[loop].cells[1].childNodes[0].nodeValue;
			var rwGLDesc = tblall.rows[loop].cells[2].childNodes[0].nodeValue;
			
			var tbl = document.getElementById('tblglaccounts');
			
			var lastRow = tbl.rows.length;
			for(var i=1;i<lastRow;i++)
			{
				try
				{
					if(tbl.rows[i].cells[1].childNodes[0].nodeValue==rwGLAcc)
					{
						boolcheck=true;
						
					}
				}
				catch(e)
				{
					checkGLfirstTime = 1;
				}
					
			}
			if(!boolcheck)
					{
							
						var row = tbl.insertRow(lastRow);
						row.className = "bcgcolor-tblrowWhite";
						
						var cell = row.insertCell(0);
						cell.className ="normalfntMid";	
						cell.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"false\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" /></div>";
						
						var cell = row.insertCell(1);
						cell.className ="normalfnt";
						cell.id		   = glAccId;
						cell.ondblclick = changeToStyleTextBox;
						cell.innerHTML = rwGLAcc;
						
						var cell = row.insertCell(2);
						cell.className ="normalfnt";
						cell.innerHTML = rwGLDesc;
						
						var cell = row.insertCell(3);
						cell.className ="normalfnt";
						cell.innerHTML = "<input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox lastcellz\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onkeyup=\"clckGLBox(this.value,this.parentNode.parentNode.rowIndex);setTotGlVale();setAmountToGlAcc(event,this);\" onblur=\"setFixedValue(this.value,this.parentNode.parentNode.rowIndex);\" onkeydown=\"addNewGLRow(event,this.parentNode.parentNode.rowIndex);\" value=\""+ 0 +"\">";
						
				
						/*var cls;
						((lastRow % 2)==1)?cls='normalfnt':cls='normalfnt';
					    htm="<td class=\""+cls+"\"><div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" checked=\"false\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" /></div></td>";
						htm +="<td class=\""+cls+"\" style=\"text-align:left;\" id=\""+glAccId+"\">"+rwGLAcc+"</td>";
						htm +="<td class=\""+cls+"\" style=\"text-align:left;\">"+rwGLDesc+"</td>";
						htm +="<td class=\""+cls+"\"><input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onchange=\"validateGrnAmountVsGLAmount(this.value);\" onkeyup=\"clckGLBox(this);\" onkeydown=\"addNewGLRow(event,this.parentNode.parentNode.rowIndex);\" value=\""+ 0 +"\"></td>";
						 row.innerHTML=htm;*/
					}
					else
					{
						alert("GL Acc Id "+rwGLAcc+" Allready exist.");
					}
					
			
		}
	}
	// event_setter();
	if(checkGLfirstTime==1)
		tbl.deleteRow(1);
	checkGLfirstTime = 0;
	
		
}

function getGLAccounts()
{
	var facCode=document.getElementById("cboFactory").value;
	var nameLike=document.getElementById("txtNameLike").value;	
		nameLike =nameLike.trim();
	var url='supplierInvXML.php?RequestType=getGLAccountList&facID=' + facCode + '&NameLike=' + nameLike;
	htmlobj=$.ajax({url:url,async:false});
	
	$('#tblallglaccounts tr:gt(0)').remove();
	
	var XMLaccNo = htmlobj.responseXML.getElementsByTagName("accNo");
	var XMLaccName = htmlobj.responseXML.getElementsByTagName("accDes");
	var XMLAccountNo = htmlobj.responseXML.getElementsByTagName("AccountNo");	
	var XMLGLAccID = htmlobj.responseXML.getElementsByTagName("GLAccID");
	
			var strGLAccs="";
				  
			for ( var loop = 0; loop < XMLaccNo.length; loop ++)
			 {
				var accNo 		= XMLaccNo[loop].childNodes[0].nodeValue;
				var accDes 		= XMLaccName[loop].childNodes[0].nodeValue;
				var AccountNo   = XMLAccountNo[loop].childNodes[0].nodeValue;
				var GLAccID   = XMLGLAccID[loop].childNodes[0].nodeValue;
				
				var tbl 		= document.getElementById('tblallglaccounts');
				var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);
				row.className = "bcgcolor-tblrowWhite";
				
				var cell = row.insertCell(0);
				cell.className ="normalfntMid";
				cell.innerHTML = "<input type=\"checkbox\" name=\"chkSelGLAcc\" id=\"chkSelGLAcc\"/>";
				
				var cell = row.insertCell(1);
				cell.className ="normalfnt";
				cell.id		   = GLAccID;
				cell.innerHTML = accNo+""+AccountNo;
				
				var cell = row.insertCell(2);
				cell.className ="normalfnt";
				cell.innerHTML = accDes;
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

function search(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode==9)
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

// -------------------------------- 27/07/2011 edit by lahiru ---------------------------------------
function changeToStyleTextBox()
{
	
	var obj = this;
	
	if ( obj.childNodes[0] instanceof HTMLInputElement)
	{
		return;
	}
	obj.align = "Left";
	obj.innerHTML ="<input type=\"text\" name=\"txtGLID\" id=\"txtGLID\" onkeydown=\"isEnterKey(this,event,this.value,this.parentNode.parentNode.rowIndex);\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return isNumberKey(event,this.value);\" class=\"txtbox\" value =\"\" size=\"13\" >";
	
	obj.childNodes[0].focus();
	
	$( "#txtGLID" ).autocomplete({
		source: pub_po_arr
	});
}

function isEnterKey(obj,evt,No,rowIndex)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode == 9)
	 {
		var url="supplierInvXML.php?RequestType=loadGLDetailstoGrid&GLID="+No;
		htmlobj=$.ajax({url:url,async:false});
		
		var XMLAccId				= htmlobj.responseXML.getElementsByTagName("accId");
		var XMLAccDes				= htmlobj.responseXML.getElementsByTagName("accDes");
		 
			if(XMLAccId[0].childNodes[0].nodeValue=="")
			{
				alert("No record.");
				currentModifyRowIndex = rowIndex;
				var tbl = document.getElementById('tblglaccounts');
				var conpc = tbl.rows[currentModifyRowIndex].cells[1].lastChild.nodeValue;
				obj.parentNode.innerHTML = obj.value;
				return;
			}
		
		var tbl = document.getElementById('tblglaccounts');
		var tbl_row_source = $('#tblglaccounts tr')
		var booCheck = false;
		for(var loopz=1;loopz<=tbl_row_source.length-1;loopz++)
		{
			if(tbl_row_source[loopz].cells[1].lastChild.nodeValue==No)
				booCheck = true;
		}
		if(booCheck)
		{
			alert("GL Acc Id already exist.")
			return;
		}
		var row = tbl.insertRow(rowIndex);
		row.className="bcgcolor-tblrowWhite";
				
		var cellCheck = row.insertCell(0);   
		cellCheck.innerHTML = "<div align=\"center\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"checkUncheckTextBox(this),setLineNumber();\" /></div>";
		
		var cellGLId = row.insertCell(1);
		cellGLId.id	 = XMLAccId[0].childNodes[0].nodeValue;
		cellGLId.ondblclick = changeToStyleTextBox;
		cellGLId.align ="left";
		cellGLId.innerHTML = No;  
		
		var cellDes = row.insertCell(2);
		cellDes.innerHTML = XMLAccDes[0].childNodes[0].nodeValue;
		cellDes.align ="left";
		
		var cellAmt = row.insertCell(3);   
		cellAmt.innerHTML = "<input type=\"text\" id=\"glamount\" name=\"glamount\" style=\"width: 100px; text-align: right;\" class=\"txtbox lastcellz\" style=\"width:100px\" align =\"right\" onkeypress=\"return isNumberKey(event,this.value);\" onkeyup=\"clckGLBox(this.value,this.parentNode.parentNode.rowIndex);setTotGlVale();setAmountToGlAcc(event,this);\" onblur=\"setFixedValue(this.value,this.parentNode.parentNode.rowIndex);\"  value=\""+ 0 +"\">"; 
				
		tbl.deleteRow(rowIndex+1);
		tbl.rows[rowIndex].cells[3].childNodes[0].select();
	 }
	 //event_setter()
  }
function ShowAllGL()
{
	var SupID = document.getElementById("cbosupplier").value;
	var FacCd = document.getElementById("cbocompany").value;
	showBackGround('divBG',0);
	var url = "GLAccpop.php";
	
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(653,439,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;

}
function CloseOSPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}

function setTotGlVale()
{
	var glTbl	= document.getElementById('tblglaccounts');
	var taxTbl 	= document.getElementById('tbltaxdetails');
	var glTotAmount	= 0;
	var taxTotAmount = 0;
	var taxAmount = 0;
	var glTotValue = parseFloat((document.getElementById('txttotglamount').value)==""?0:(document.getElementById('txttotglamount').value));
	

	for(var i=1;i<taxTbl.rows.length;i++)
	{
		if(taxTbl.rows[i].cells[0].childNodes[0].childNodes[0].checked == true && taxTbl.rows[i].cells[4].id=='0' )
		{
			var NBTrate 	= taxTbl.rows[i].cells[2].childNodes[0].nodeValue;			
			taxTbl.rows[i].cells[3].childNodes[0].value = RoundNumbers((glTotValue*NBTrate)/100,2);
			taxTotAmount += parseFloat((taxTbl.rows[i].cells[3].childNodes[0].value == ""?0:taxTbl.rows[i].cells[3].childNodes[0].value));	
			
		}
		else if (taxTbl.rows[i].cells[0].childNodes[0].childNodes[0].checked == false)
			taxTbl.rows[i].cells[3].childNodes[0].value = 0.00;
	}
	var totalOtherAmount = parseFloat(RoundNumbers(glTotValue+taxTotAmount,2));
	document.getElementById('txtcommission').value = RoundNumbers(totalOtherAmount,2);
	
	for(var i=1;i<taxTbl.rows.length;i++)
	{
		if(taxTbl.rows[i].cells[0].childNodes[0].childNodes[0].checked == true && taxTbl.rows[i].cells[4].id!='0' )
		{
			var rate 	= taxTbl.rows[i].cells[2].childNodes[0].nodeValue;			
			taxTbl.rows[i].cells[3].childNodes[0].value = RoundNumbers((totalOtherAmount*rate)/100,2);
			taxAmount	+= parseFloat(RoundNumbers((totalOtherAmount*rate)/100,2));
		}
	}
	
	for(var loop=1;loop<glTbl.rows.length;loop++)
	{
		if(glTbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked)
		{
			glTotAmount += parseFloat((glTbl.rows[loop].cells[3].childNodes[0].value=="" ? 0:glTbl.rows[loop].cells[3].childNodes[0].value));
		}
	}
	
	document.getElementById('txttottaxamount').value = RoundNumbers(taxAmount,2);
	document.getElementById('txtinvoiceamount').value = RoundNumbers(totalOtherAmount+taxAmount,2);
	document.getElementById('txtGLTotal').value = RoundNumbers((glTotValue+taxTotAmount)-glTotAmount,2);
}
/*function setPrevValue()
{
	$('#glamount').keydown(function(){
  		preValue = ($('#glamount').val()==""?0:$('#glamount').val())
	 })
}	
*/
function RoundNumbers(number,decimals) {
	number = parseFloat(number).toFixed(parseInt(decimals));
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
	if (newString.charAt(newString.length-1) == ".")
		newString =newString.substring(0,newString.length-1);
	//var newNumber = Number(newString);// make it a number if you like
	newString = newString.replace("Infinity","0");
	return newString; // Output the result to the form field (change for your purposes)
}
function resetValue()
{
	payType = document.getElementById('cboPymentType').value;
	newPage();
	document.getElementById('cboPymentType').value = payType;
}
function setFixedValue(value,row)
{
	if(value=="")
	value = 0;
	var tbl = document.getElementById('tblglaccounts');
	tbl.rows[row].cells[3].childNodes[0].value=RoundNumbers(value,2);
}

function event_setter(){
$('.txtbox.lastcellz').live('keydown', function(e) { 
	  var keyCode = e.keyCode || e.which; 
	  if (keyCode == 9) {	  
				addNewGLRow(this.parentNode.parentNode.rowIndex)
	  }
	});
	document.getElementById('txtinvno').focus();
$('#frmsupinv').keypress(function(e) { 
	  var keyCode = e.keyCode || e.which; 
	  if (keyCode == 120) {	  
				$('#butSave').trigger('click');
	  }
	});
}
function setAmountToGlAcc(evt,obj)
{
	var tbl = document.getElementById("tblglaccounts");
	var amount   = $('#txtGLTotal').val();
	var glAmount = (obj.value==""?0:obj.value);
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	 if(charCode == 112)
	 {
		 var totAmt = parseFloat(amount)+parseFloat(glAmount);
		 obj.value = RoundNumbers(totAmt,2);
		 document.getElementById("txtGLTotal").value = RoundNumbers(0,2);
		 var row = obj.parentNode.parentNode.rowIndex;
		 tbl.rows[row].cells[0].childNodes[0].childNodes[0].checked = true;
		 
		
	 }
}