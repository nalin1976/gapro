var strPaymentType =""
var xmlHttpTaxSave= [];
var xmlHttpGLSave = [];
var xmlHttpPOSave = [];
var reportPaymentId = 0;

var savedStatus=0;

var curTypeCombo = '';
//getCurType();
var fixedAmt=0; ;
var th = ['','thousand','million', 'billion','trillion'];

var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine']; var tn = ['ten','eleven','twelve','thirteen', 'fourteen','fifteen','sixteen', 'seventeen','eighteen','nineteen']; var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

var	xmlHttpSup;

/*function getCurType()
{
var url='advancepaymentDB.php?DBOprType=getCType';
var http_obj=$.ajax({url:url,async:false});
var XMLCurType = http_obj.responseXML.getElementsByTagName("currType");
var XMLCurID = http_obj.responseXML.getElementsByTagName("currId");
alert(http_obj.responseText);
}
*/
function CreateXMLHttpForSuppliers() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpSup = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSup = new XMLHttpRequest();
    }
}

var	xmlHttpCurrency;
function CreateXMLHttpForCurrency() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpCurrency = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpCurrency = new XMLHttpRequest();
    }
}
var xmlHttpBatch;
function CreateXMLHttpForBatches() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpBatch = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpBatch = new XMLHttpRequest();
    }
}

var xmlHttpFactory;
function CreateXMLHttpForFactories() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpFactory = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpFactory = new XMLHttpRequest();
    }
}

var xmlHttpTax;
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

var xmlHttpPos;
function CreateXMLHttpPOs() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpPos = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpPos = new XMLHttpRequest();
    }
}

var xmlHttpGLs;
function CreateXMLHttpGLs() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpGLs = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpGLs = new XMLHttpRequest();
    }
}

var xmlHttpGLAccs;
function CreateXMLHttpForGLAccs() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpGLAccs = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpGLAccs = new XMLHttpRequest();
    }
}
var xmlHttpAdvNo;
function CreateXMLHttpForAdvanceNo() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpAdvNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpAdvNo = new XMLHttpRequest();
    }
}

var xmlHttpSave;
function CreateXMLHttpForAdvanceSave() 
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

function CreateXMLHttpForTaxSave(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpTaxSave[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpTaxSave[index] = new XMLHttpRequest();
    }
}

function CreateXMLHttpForGLsSave(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpGLSave[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpGLSave[index] = new XMLHttpRequest();
    }
}

function CreateXMLHttpForPOsSave(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpPOSave[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpPOSave[index] = new XMLHttpRequest();
    }
}


function CreateXMLHttpForAdvPays() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpAdvs = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpAdvs = new XMLHttpRequest();
    }
}
function CreateXMLHttpForAdvPaysGL() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpAdvsGL = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpAdvsGL = new XMLHttpRequest();
    }
}


function showGlPoup(globalFacId)
{
			var strGLAccounts="<table width=\"100%\" height=\"350\" border=\"0\" class=\"TitleN2white\"  bgcolor=\"#FFF\" >"+
            "<tr>"+
              "<td height=\"25\" bgcolor=\"#498CC2\" class=\"containers \">GL Accounts</td>"+
            "</tr>"+
            "<tr class=\"tablezRED\">"+
              "<td height=\"17\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                  "<tr>"+
                    "<td width=\"1%\" height=\"25\">&nbsp;</td>"+
                    "<td width=\"8%\" class=\"normalfnt\">Factory</td>"+
                    "<td width=\"50%\"><label>"+
                      "<select name=\"cboFactory\" onchange=\"getGLAccounts()\"  class=\"normalfnt\" id=\"cboFactory\" style=\"width:250px\">"+
                      "</select>"+
                    "</label></td>"+
                    "<td width=\"1%\">&nbsp;</td>"+
                    "<td width=\"6%\"  class=\"normalfnt\">Acc.Like</td>"+
                    "<td width=\"8%\"> <input type=\"text\"  class=\"txtbox\"  name=\"txtNameLike\" id=\"txtNameLike\" size=\"25\" /></td>"+
                    "<td width=\"8%\"><img src=\"../images/search.png\" onclick=\"getGLAccounts()\" alt=\"ok\" width=\"86\" height=\"24\" /></td>"+
                  "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"350\"><table width=\"100%\" height=\"350\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                  "<tr class=\"bcgl1\">"+
                    "<td width=\"100%\" height=\"250\"><table width=\"93%\" height=\"350\" border=\"0\" class=\"bcgl1\">"+
                        "<tr>"+
                          "<td colspan=\"3\"><div id=\"divGLAccs\" style=\"overflow: -moz-scrollbars-vertical; height:390px; width:650px;\" >"+
                              "<table class=\"grid_header\" width=\"630\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccounts\">"+
                                "<tr>"+
                                  "<td width=\"10%\" class=\"grid_header\">*</td>"+
                                  "<td width=\"20%\" class=\"grid_header\">GL Acc ID</td>"+
                                  "<td width=\"70%\" height=\"25\" class=\"grid_header\">Description</td>"+
                                  "</tr>"+
                              "</table>"+
                          "</div></td>"+
                        "</tr>"+
                    "</table></td>"+
                  "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"32\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                "<tr bgcolor=\"#D6E7F5\">"+
                  "<td width=\"28%\">&nbsp;</td>"+
                  "<td width=\"18%\"><img src=\"../images/ok.png\" onclick=\"getSelectedGLAccounts()\" alt=\"ok\" width=\"86\" height=\"24\" /></td>"+
                  "<td width=\"6%\">&nbsp;</td>"+
                  "<td width=\"20%\"><img src=\"../images/close.png\" onclick=\"closeWindow()\" width=\"97\" height=\"24\" /></td>"+
                  "<td width=\"28%\">&nbsp;</td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>"
	
/*		var popupbox = document.createElement("div");
		popupbox.id = "popupGLAccounts";
		popupbox.style.position = 'absolute';
		popupbox.style.zIndex = 1;
		popupbox.style.left = 341 + 'px';
		popupbox.style.top = 10 + 'px';  
		popupbox.innerHTML = strGLAccounts;  
		document.body.appendChild(popupbox);*/
		
		drawPopupArea(665,495,'popupGLAccounts');
		document.getElementById('popupGLAccounts').innerHTML = strGLAccounts; 
		LoadFactoryList();
		var url1='advancepaymentDB.php?DBOprType=getFacCode&facCode='+globalFacId;
		var http_obj=$.ajax({url:url1,async:false});
		//alert(http_obj.responseText);
			
		document.getElementById('cboFactory').value=http_obj.responseText;
		if(document.getElementById('cboFactory').value!=0)
			getGLAccounts();
		loadTaxTypes();
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

function initializeTheInterface()
{
	//LoadFactoryList();
	loadTaxTypes();
}

function checkValues()
{
	var poAmount=Number(document.getElementById("txtPOAmount").value);
	var totGLAmt=0;
	
	if(parseFloat(document.getElementById("txtPOTotalAmount").value)==0 || isNaN(parseFloat(document.getElementById("txtPOTotalAmount").value))==true)
	{
		alert("Please Select PO(s) to Pay an Advance");
		return false;
	}
	
	var rows=document.getElementById('tblGLAccs').getElementsByTagName("TR");
	if(rows.length==1)
	{
		alert("Please Select the GL Account(s) of AccPac");
		document.getElementById("cmdShowGLs").focus();
		return false;
	}
	
	for(var loop=1;loop<rows.length;loop++)
	{
		cells=rows[loop].getElementsByTagName("TD");
		totGLAmt=Number(totGLAmt)+Number(cells[3].firstChild.value)
	}
	
	
	if(Number(poAmount)!=Number(totGLAmt))
	{
		var diff=Number(poAmount)-Number(totGLAmt)
		diff=Math.round(diff*100)/100;
		alert("There is a different (" + Number(diff) + ") between Amount of PO (" + Number(poAmount) +") and the Total Amount of GL Acccount (" + Number(totGLAmt) + ").The Total Amount of GL account and PO Amount should be equal"				)	;
		return false;
	}
	
	if(document.getElementById("cboBatchNo").value==0)
	{
		alert("Please Select a AccPac Batch No");
		document.getElementById("cboBatchNo").focus();
		
		return false;
	}

	

	if(document.getElementById("cboCurrencyTo").value==0)
	{
		alert("Please Select the Type of Currency of Advace Payment");
		document.getElementById("cboCurrencyTo").focus();	
		return false;
	}


	if(savedStatus==0)
		SaveAdvPayment();
	
}

function advclose()
{
	location = "../main.php";
	return;
}

function findSupGLAccs(supID)
{
	CreateXMLHttpGLs();
	xmlHttpGLs.onreadystatechange = HandleGLs;
	xmlHttpGLs.open("GET", 'advancepaymentDB.php?DBOprType=getSupGLList&supID=' + supID, true);
	xmlHttpGLs.send(null); 
}
function HandleGLs()
{	
	if(xmlHttpGLs.readyState == 4) 
    {
	   if(xmlHttpGLs.status == 200) 
        {  
			var XMLAccNo = xmlHttpGLs.responseXML.getElementsByTagName("accNo");
			var XMLDesc = xmlHttpGLs.responseXML.getElementsByTagName("accName");
			


			var strPOTable="<table width=\"420\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccs\" name=id=\"tblGLAccs\">"+
							"<tr>"+
							"<td width=\"114\" height=\"25\" bgcolor=\"#\" class=\"grid_header\">#</td>"+
							"<td width=\"114\" height=\"25\" bgcolor=\"#\" class=\"grid_header\">GL Acc</td>"+
							"<td width=\"187\" bgcolor=\"#\" class=\"grid_header\">Description</td>"+
							"<td width=\"234\" bgcolor=\"#\" class=\"grid_header\">Amount</td>"+
							"</tr>"
							  
			
			for ( var loop = 0; loop < XMLAccNo.length; loop ++)
			 {
				var AccNo = XMLAccNo[loop].childNodes[0].nodeValue;
				var Desc = XMLDesc[loop].childNodes[0].nodeValue;
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strPOTable+="<tr>"+
				            "<td class=\""+cls+"\"><input type='checkbox'/></td>"+
							"<td class=\""+cls+"\">" + AccNo + "</td>"+
							"<td class=\""+cls+"\" style=\"text-align:left;\">" + Desc + "</td>"+
							"<td class=\""+cls+"\"><input name=\"txtamount\" type=\"text\" style=\"text-align:right\" class=\"txtbox\" id=\"txtamount\" size=\"20\" onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\" /></td>"+
							"</tr>"

				

			 }
				strPOTable+="</table>"
				
				document.getElementById("divconsOfSelGLs").innerHTML=strPOTable;
		}
	}
}



function findSupPOs()
{
	//strPaymentType=document.getElementById("cboPymentType").value
	
	var type = '';
	
	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';
	
	
	
	var supID=document.getElementById("cboSuppliers").value;
	CreateXMLHttpPOs();
	xmlHttpPos.onreadystatechange = HandlePOs;
	xmlHttpPos.open("GET", 'advancepaymentDB.php?DBOprType=getSupPOList&strPaymentType=' + type + '&supID=' + supID, true);
	xmlHttpPos.send(null); 
	
	findSupGLAccs(supID)
}

function HandlePOs()
{	
	if(xmlHttpPos.readyState == 4) 
    {
	   if(xmlHttpPos.status == 200) 
        { 
		
			var XMLPONo = xmlHttpPos.responseXML.getElementsByTagName("poNo");
			var XMLCurrency = xmlHttpPos.responseXML.getElementsByTagName("currency");
			var XMLPOAmt = xmlHttpPos.responseXML.getElementsByTagName("poAmount");
			var XMLPOBal = xmlHttpPos.responseXML.getElementsByTagName("poBalance");
			var XMLPayTerm = xmlHttpPos.responseXML.getElementsByTagName("payTerm");
			var XMLPayCur = xmlHttpPos.responseXML.getElementsByTagName("payCurrency");
			var XMLEXrate =xmlHttpPos.responseXML.getElementsByTagName("payrate");
			var XMLCurID = xmlHttpPos.responseXML.getElementsByTagName("currencyId");



			var strPOTable="<table   cellpadding=\"0\" cellspacing=\"0\" boder=\"1\" name=\"tblPOList\" id=\"tblPOList\">"+
			               "<thead>"+
							"<tr>"+
							  "<td style='width:15px;' bgcolor=\"\" class=\"grid_header\">*</td>"+
							  "<td style='width:120px;' height=\"33\" bgcolor=\"\" class=\"grid_header\">PO NO</td>"+
							  "<td style='width:75px;' bgcolor=\"\" class=\"grid_header\">Currency</td>"+
							  "<td style='width:120px;' bgcolor=\"\" class=\"grid_header\">PO Amount</td>"+
							  "<td style='width:120px;' bgcolor=\"\" class=\"grid_header\">PO Paid Amount</td>"+
							  "<td style='width:120px;' bgcolor=\"\" class=\"grid_header\">PO Balance</td>"+
							  "<td style='width:120px;' bgcolor=\"\" class=\"grid_header\">Pay Amount</td>"+
							  "<td style='width:122px;' bgcolor=\"\" class=\"grid_header\">According To<br>"+document.getElementById('cboCurrencyTo').options[document.getElementById('cboCurrencyTo').selectedIndex].text+"</td>"+
							  "<td style='width:122px;' bgcolor=\"\" class=\"grid_header\">Pay Term</td>"+													  							                            "</tr>"+
							"</thead>";
							  
			var txtcurrency = document.getElementById("txtcurrency").value;
			for ( var loop = 0; loop < XMLPONo.length; loop ++)
			 {
				var poNo = XMLPONo[loop].childNodes[0].nodeValue;
				var currency = XMLCurrency[loop].childNodes[0].nodeValue;
				var poAmount = XMLPOAmt[loop].childNodes[0].nodeValue;
				var poBalance = XMLPOBal[loop].childNodes[0].nodeValue;
				var payTerm = XMLPayTerm[loop].childNodes[0].nodeValue;
				var payCur=XMLPayCur[loop].childNodes[0].nodeValue;
				var payrate=XMLEXrate[loop].childNodes[0].nodeValue;
				var curId=XMLCurID[loop].childNodes[0].nodeValue;
				//var convertSL=
				//document.getElementById("cboCurrencyTo").value=payCur;
				
				
				
				
				
			if(poBalance=="")
				{
				poBalance=poAmount;
				}
				
				var poPaidAmt=(poAmount-poBalance);
				
				var txtcurrency=document.getElementById("txtcurrency").value;
				
				if ( currency != document.getElementById("cboCurrencyTo").value)
				{
					var convertSL = (poBalance / payrate) * (txtcurrency);
					var PayAmt = (poBalance / payrate) * (txtcurrency);
					//var poPaidAmt=((poAmount-poBalance)/ payrate) * (txtcurrency);
				}
				else 
				{
				var convertSL =  (poBalance = poAmount);
				var PayAmt =  (poBalance = poAmount);
				//var poPaidAmt=(poAmount-poBalance);
				}
				var intPoNo		= 	poNo.split('/')[0];
				var intPoYear	= 	poNo.split('/')[1];
					var type = '';
	
	if(document.getElementById("rdoStyle").checked)
	{
		var linkPo		=	"<a target=\"_blank\" href=\"../reportpurchase.php?pono="+intPoYear+"&year="+intPoNo+"\">";
	}
	else if(document.getElementById("rdoBulk").checked)
	{ var linkPo		=	"<a target=\"_blank\" href=\"../BulkPo/bulkPurchaeOrderReport.php?pono="+intPoYear+"&year="+intPoNo+"\">";
		
	}
	else if(document.getElementById("rdoGeneral").checked)
	{ var linkPo		=	"<a target=\"_blank\" href=\"../GeneralInventory/GeneralPO/oritgeneralpurcahseorderreport.php?bulkPoNo="+intPoYear+"&intYear="+intPoNo+"\">";
		
	}
	
				
				//var linkPo		=	"<a target=\"_blank\" href=\"../reportpurchase.php?pono="+intPoYear+"&year="+intPoNo+"\">";
				var txtPayAmt= parseFloat(PayAmt).toFixed(2);
				
				//alert(linkPo);
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2"
					strPOTable+="<tr id="+loop+">"+
								  "<td class=\""+cls+"\" style='width:15px;' id=\""+payrate+"\"><input type=\"checkbox\" onclick=\"setPOValue(this)\" onmouseover=\"highlight(this.parentNode)\"  name=\"chkSelPo\" id=\"chkSelPo\"  /></td>"+
								  "<td class=\""+cls+"\" style='width:120px;'>" + linkPo  + poNo + "</a></td>"+
								  "<td class=\""+cls+"\" style='width:75px;' id=\""+curId+"\" >" + currency + "</td>"+
								  "<td style=\"text-align:right\" class=\""+cls+"\" style='width:120px;'>" + parseFloat(poAmount).toFixed(2) + "</td>"+
								  "<td style=\"text-align:right\" class=\""+cls+"\" style='width:120px;'>" + parseFloat(poPaidAmt).toFixed(2) + "</td>"+
								  "<td style=\"text-align:right\" class=\""+cls+"\" style='width:120px;'>" + parseFloat(poBalance).toFixed(2)  + "</td>"+
								  "<td align=\"center\" class=\""+cls+"\" style='width:120px;'><input type=\"text\" name=\"txtPayAmt\" size='10'  id=\""+poBalance+"\" style=\"text-align:right\"  onmouseover=\"highlight(this.parentNode)\"  class=\"txtbox\"   style=\"height:14px\"  value="+ parseFloat(PayAmt).toFixed(2) + " onchange=\"clckBox(this)\"  onblur='replaceValues(this,this.value)' onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\" onkeyup=\"checkvalue(this,this.value);convertcur(this,this.value)\" </td>"+
								  "<td class=\""+cls+"\" style='width:120px;text-align:right'>" + convertSL.toFixed(2) + "</td>"+
								  "<td class=\""+cls+"\" style='width:120px;'>" + payTerm + "</td>"+
								"</tr>"
				//convertcur(this,this.value)
				//arrValue[loop]=parseFloat(txtPayAmt).toFixed(2)
			 }
				strPOTable+="</table>"
				
				document.getElementById("divPOs").innerHTML=strPOTable;
				grid_fix_header_poList();
		}
	}
	//loadBatchNo();
}
function replaceValues(obj,value)
{
	var tblPOList=document.getElementById('tblPOList');
	var selectedRow = obj.parentNode.parentNode.rowIndex;
	if(value=='')
		tblPOList.rows[selectedRow].cells[6].childNodes[0].value=tblPOList.rows[selectedRow].cells[6].lastChild.id;
}
/*function cleartext(obj)
{
	var tblPOList=document.getElementById('tblPOList');
	obj.value='';
}*/
function clckBox(obj){
	obj.parentNode.parentNode.cells[0].childNodes[0].checked=true;	
	
	setPOValue();
}
//........passing value to currncy money
function convertcur(obj,value)
{
	var tblPOList=document.getElementById('tblPOList');
var selectedRow = obj.parentNode.parentNode.rowIndex;

if(tblPOList.rows[selectedRow].cells[2].id==document.getElementById("cboCurrencyTo").value)
	var convertSL =parseFloat(value);
else
{
	var txtcurrency = document.getElementById("txtcurrency").value;
	var convertSL = (parseFloat(value) / parseFloat(tblPOList.rows[selectedRow].cells[0].id)  * txtcurrency);
}
//alert(convertSL);

//document.getElementById("tblPOList").rows[selectedRow].cells[7].innerHTML = convertSL.toFixed(2);

//alert(convertSL);

}
//===============================================================================================================
function checkvalue(obj,value){
	//alert(fixedAmt);
	var tblPOList=document.getElementById('tblPOList');	
	var selectedRow = obj.parentNode.parentNode.rowIndex;
	//alert(selectedRow);
	//if(parseFloat(value)>arrValue[selectedRow-1])
	//alert(tblPOList.rows[selectedRow-1].cells[6].lastChild.value);

	if(parseFloat(value)> tblPOList.rows[selectedRow].cells[7].innerHTML)
	{
		alert("Amount is Large");
		//alert(arrValue[selectedRow-1]);
		tblPOList.rows[selectedRow].cells[7].childNodes[0].value=tblPOList.rows[selectedRow].cells[7].innerHTML;
	}
		
		
	
}

//.............................Clear all the text box...............................
function clearTextAll(obj)
{
	obj.value='';
}


  

function loadTaxTypes()
{
	CreateXMLHttpForTaxTypes();
	xmlHttpTax.onreadystatechange = HandleTaxTypes;
    xmlHttpTax.open("GET", 'advancepaymentDB.php?DBOprType=getTaxTypes', true);
	xmlHttpTax.send(null); 
}

function HandleTaxTypes()
{	
	if(xmlHttpTax.readyState == 4) 
    {
	   if(xmlHttpTax.status == 200) 
        {  
			var XMLTaxID = xmlHttpTax.responseXML.getElementsByTagName("taxTypeID");
			var XMLTaxType = xmlHttpTax.responseXML.getElementsByTagName("taxType");
			var XMLTaxRate = xmlHttpTax.responseXML.getElementsByTagName("taxRate");
			
			var strTaxTbl="<table width=\"458\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"normaltxtmidb2\" id=\"tblTax\">"+
						  "<tr>"+
							"<td bgcolor=\"#498CC2\" width=\"20\" height=\"22\" class=\"grid_header\">*</td>"+
							"<td bgcolor=\"#498CC2\" width=\"70\" class=\"grid_header\">Tax</td>"+
							//"<td bgcolor=\"#498CC2\" width=\"10\" class=\"grid_header\"></td>"+
							"<td bgcolor=\"#498CC2\" width=\"40\" class=\"grid_header\">Rate</td>"+
							"<td bgcolor=\"#498CC2\" width=\"80\" class=\"grid_header\">Value</td>"+

						  "</tr>"
									
			
									
			for ( var loop = 0; loop < XMLTaxID.length; loop++)
			 {
				var taxID = XMLTaxID[loop].childNodes[0].nodeValue;
				var taxType = XMLTaxType[loop].childNodes[0].nodeValue;
				var taxRate = parseFloat(XMLTaxRate[loop].childNodes[0].nodeValue);
				
				taxRate = taxRate.toFixed(2);
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strTaxTbl+="<tr>"+
								"<td width=\"20\" class=\""+cls+"\" ><input type=\"checkbox\" onclick=\"setPOValue()\" onmouseover=\"highlight(this.parentNode)\" name=\"chkSelTax\" id=\"chkSelTax\" /></td>"+
								"<td width=\"70\" onmouseover=\"highlight(this.parentNode)\"  class=\""+cls+"\" style=\"text-align:left\">" + taxType + "</td>"+
								//"<td width=\"10\"  class=\""+cls+"\"></td>"+
								"<td width=\"40\"  class=\""+cls+"\" style=\"text-align:right\">" + taxRate + "</td>"+
								"<td width=\"80\"  class=\""+cls+"\" style=\"text-align:right\">0.00</td>"
								
							"</tr>"
				
			 }
			 
			 strTaxTbl+="</table>"
			 document.getElementById("divTaxType").innerHTML=strTaxTbl;
		}
	}
}


function showGLAccounts(booGLOk)
{
	
	try
	{
		if(booGLOk==true)
		{
			document.getElementById('popupGLAccounts').style.visibility = 'visible';
			document.getElementById('txtNameLike').value=""
			document.getElementById('cboFactory').value=0
			var strGLAccs="<table bgcolor=\"#FFFFE1\" width=\"460\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccounts\">"+
							"<tr>"+
							  "<td width=\"39\" bgcolor=\"\" class=\"grid_header\">*</td>"+
							  "<td width=\"102\" bgcolor=\"\" class=\"grid_header\">GL Acc ID</td>"+
							  "<td width=\"269\" height=\"25\" bgcolor=\"\" class=\"grid_header\">Description</td>"+
							  "</tr>"+
						  "</table>"
							  
			document.getElementById('divGLAccs').innerHTML=strGLAccs;
			
			 
		}
		else
		{
			document.getElementById('popupGLAccounts').style.visibility = 'hidden';
		}
	}
	catch(err)
	{        
	}	
	
}



function setPOValue(obj)
{
	//document.getElementById("txtDraftNo").style.backgroundColor ="#ffffff"
	document.getElementById("txtFrightChargers").style.backgroundColor ="#ffffff"
	document.getElementById("txtDiscount").style.backgroundColor ="#ffffff"
	document.getElementById("txtCourierChargers").style.backgroundColor ="#ffffff"
	document.getElementById("txtBankChargers").style.backgroundColor ="#ffffff"



	var payAmount=0;
	var amt=parseFloat(document.getElementById("txtPOAmount").value);
	
	//var amtDraft=parseFloat(document.getElementById("txtDraftNo").value);
	//if(parseFloat(amtDraft)>0)
	//{
	//	document.getElementById("txtDraftNo").style.backgroundColor ="#DCFCC9"
	//}
	
	var amtFrightChargers=parseFloat(document.getElementById("txtFrightChargers").value);
	if(parseFloat(amtFrightChargers)>0)
	{
		document.getElementById("txtFrightChargers").style.backgroundColor ="#DCFCC9"
	}
	
	var amtDiscount=parseFloat(document.getElementById("txtDiscount").value);
	if(parseFloat(amtDiscount)>0)
	{
		document.getElementById("txtDiscount").style.backgroundColor ="#DCFCC9"
	}
	
	var amtCourierChargers=parseFloat(document.getElementById("txtCourierChargers").value);
	if(parseFloat(amtCourierChargers)>0)
	{
		document.getElementById("txtCourierChargers").style.backgroundColor ="#DCFCC9"
	}

	var amtBankChargers=parseFloat(document.getElementById("txtBankChargers").value);
	if(parseFloat(amtBankChargers)>0)
	{
		document.getElementById("txtBankChargers").style.backgroundColor ="#DCFCC9"
	}
	
	var extAmt=amtFrightChargers-amtDiscount+amtCourierChargers+amtBankChargers//amtDraft+
	var taxTot=0

		var tblPOList = document.getElementById('tblPOList');
			var payAmount = 0;
				for(var loop=1;loop<tblPOList.rows.length;loop++)
				{
					 if(tblPOList.rows[loop].cells[0].lastChild.checked == true)
					 {
						payAmount += parseFloat(tblPOList.rows[loop].cells[6].lastChild.value); 
					 }
				}
				
		
	if(amt=="" || isNaN(amt)==true )	{ amt=0	}

	var totAmt=payAmount.toFixed(2);
	var convertTotAmt=totAmt ;
	
	//convert();
	
	//totAmt = Math.round(totAmt*100)/100;
	
	document.getElementById("txtPOAmount").value=totAmt;
	document.getElementById("txtPOTotalAmount").value=totAmt;
	
		
	
	
	rows=document.getElementById('tblTax').getElementsByTagName("TR");
	
	for(var x=1;x<rows.length;x++)
	{
		cells=rows[x].getElementsByTagName("TD");
		
		if(cells[0].firstChild.checked==true)
		{		
			var rate=cells[2].firstChild.nodeValue;
			
			var amou	 = parseFloat(totAmt) * parseFloat(rate);
			cells[3].childNodes[0].nodeValue = parseFloat(amou.toFixed(2)/100).toFixed(2);
			taxTot	=taxTot+(totAmt*(rate))/100;
			//alert(amou.toFixed(2)/100);
			
		}
		else
		{
			cells[3].firstChild.nodeValue ="0.00"
		}
		
	}
	
	if(totAmt>0 && extAmt )
	{
		totAmt=parseFloat(totAmt)+parseFloat(extAmt);
		document.getElementById("txtTaxAmount").value=taxTot.toFixed(2);
		document.getElementById("txtPOTotalAmount").value=totAmt.toFixed(2);
	}
	//if(taxTot>amt)
	//{
		document.getElementById("txtTaxAmount").value=taxTot.toFixed(2);
		var 	poTotalAmount 	= parseFloat(totAmt)+parseFloat(taxTot);
		document.getElementById("txtPOTotalAmount").value=poTotalAmount.toFixed(2);
	//}

}

function LoadFactoryList()
{
	CreateXMLHttpForFactories();
	xmlHttpFactory.onreadystatechange = HandleFactories;
    xmlHttpFactory.open("GET", 'advancepaymentDB.php?DBOprType=getFactoryList', true);
	xmlHttpFactory.send(null); 
}

function HandleFactories()
{	
	if(xmlHttpFactory.readyState == 4) 
    {
	   if(xmlHttpFactory.status == 200) 
        {  
			var XMLFactoryID = xmlHttpFactory.responseXML.getElementsByTagName("compID");
			var XMLFactoryName = xmlHttpFactory.responseXML.getElementsByTagName("compName");
			clearSelectControl("cboFactory");
			
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

function loadCurrencyType()
{
	CreateXMLHttpForCurrency();
	xmlHttpCurrency.onreadystatechange = HandleCurrency;
    xmlHttpCurrency.open("GET", 'advancepaymentDB.php?DBOprType=getTypeOfCurrency', true);
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



function getGLAccounts()
{
	var facCode=document.getElementById("cboFactory").value;
	var nameLike=document.getElementById("txtNameLike").value;	
	
	CreateXMLHttpForGLAccs();
	xmlHttpGLAccs.onreadystatechange = HandleGLAccs;
    xmlHttpGLAccs.open("GET", 'advancepaymentDB.php?DBOprType=getGLAccountList&facID=' + facCode + '&NameLike=' + nameLike , true);
	xmlHttpGLAccs.send(null); 
}
function HandleGLAccs()
{	
	if(xmlHttpGLAccs.readyState == 4) 
    {
	   if(xmlHttpGLAccs.status == 200) 
        {  
			var XMLaccNo = xmlHttpGLAccs.responseXML.getElementsByTagName("accNo");
			var XMLaccName = xmlHttpGLAccs.responseXML.getElementsByTagName("accDes");
			
			//alert(XMLaccNo.length);
			var strGLAccs="<table width=\"630\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccounts\" name=\"tblGLAccounts\" >"+
							"<tr>"+
							"<td width=\"39\" bgcolor=\"\" class=\"grid_header\">*</td>"+
							"<td width=\"102\" bgcolor=\"\" class=\"grid_header\">GL Acc ID</td>"+
							"<td width=\"269\" height=\"25\" bgcolor=\"\" class=\"grid_header\">Description</td>"+
							"</tr>"
				  
			for ( var loop = 0; loop < XMLaccNo.length; loop ++)
			 {
				 //alert(loop);
				var accNo = XMLaccNo[loop].childNodes[0].nodeValue;
				var accDes = XMLaccName[loop].childNodes[0].nodeValue;
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strGLAccs+="<tr>"+
				  			"<td class=\""+cls+"\"><div align=\"center\">"+
							"<input type=\"checkbox\" name=\"chkSelGLAcc\" id=\"chkSelGLAcc\" />"+
				  			"</div></td>"+
				  			"<td class=\""+cls+"\">" + accNo + "</td>"+
				  			"<td class=\""+cls+"\">" + accDes + "</td>"+
				  			"</tr>"
				
				//rows=document.getElementById('tblGLAccounts').getElementsByTagName("TR");
				//cells=rows[loop].getElementsByTagName("TD");
				//cells[0].firstChild.checked = true;
				//cells[1].firstChild.innerHtml = accNo;
				//cells[2].firstChild.innerHtml = accDes;





			}
			strGLAccs+=	"</table>"
			
			document.getElementById("divGLAccs").innerHTML=strGLAccs;
		}
	}
}


function getSelectedGLAccounts()
{
	
	var glrows=document.getElementById('tblGLAccounts').getElementsByTagName("TR");
	var rows=document.getElementById('tblGLAccs').getElementsByTagName("TR");
	
	var strSelGLs="<table width=\"420\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccs\" name=id=\"tblGLAccs\">"+
                	"<tr>"+
					"<td width=\"10\" height=\"25\" bgcolor=\"\" class=\"grid_header\">#</td>"+
                  	"<td width=\"114\" height=\"25\" bgcolor=\"\" class=\"grid_header\">GL Acc</td>"+
                  	"<td width=\"187\" bgcolor=\"\" class=\"grid_header\">Description</td>"+
                  	"<td width=\"234\" bgcolor=\"\" class=\"grid_header\">Amount</td>"+
                  	"</tr>"
	for(var loop=1;loop<glrows.length;loop++)
	{
		var glcells=glrows[loop].getElementsByTagName("TD");
		
			var accNo=(glcells[1].firstChild.nodeValue)
			var accName=(glcells[2].firstChild.nodeValue)
			var cls;
			(loop%2==0)?cls="grid_raw":cls="grid_raw2";
			if(glcells[0].firstChild.firstChild.checked == true)
			{
				strSelGLs+="<tr>"+
				            "<td class=\""+cls+"\"><input type='checkbox' checked='checked'/></td>"+
							"<td class=\""+cls+"\">" + accNo + "</td>"+
							"<td class=\""+cls+"\">" + accName + " </td>"+
							"<td class=\""+cls+"\"><input type=\"text\"  style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\"  class=\"txtbox\"  name=\"txtGLAmount\" id=\"txtGLAmount\" onkeypress=\"return CheckforValidDecimal(this.value, 1,event);\" /></td>"+
						  "</tr>"
			
						
			}
	}
	strSelGLs+="</table>"
	document.getElementById("divconsOfSelGLs").innerHTML=strSelGLs;
	
	//cells[1].firstChild.innerHtml = accNo;
	//cells[2].firstChild.innerHtml = accDes;
}


function LoadAccPackBatches()
{
	CreateXMLHttpForBatches();
	xmlHttpBatch.onreadystatechange = HandleBatches;
    xmlHttpBatch.open("GET", 'advancepaymentDB.php?DBOprType=getBatches', true);
	xmlHttpBatch.send(null); 
}

function HandleBatches()
{	
	if(xmlHttpBatch.readyState == 4) 
    {
	   if(xmlHttpBatch.status == 200) 
        {  
			var XMLbatchID = xmlHttpBatch.responseXML.getElementsByTagName("batchID");
			var XMLbatchDes = xmlHttpBatch.responseXML.getElementsByTagName("batchDes");
			clearSelectControl("cboBatchNo");
			
			var optStorex = document.createElement("option");			
			optStorex.text = "";
			optStorex.value = 0;
			document.getElementById("cboBatchNo").options.add(optStorex);
				
			for ( var loop = 0; loop < XMLbatchID.length; loop ++)
			 {
				var batchID = XMLbatchID[loop].childNodes[0].nodeValue;
				var batchDes = XMLbatchDes[loop].childNodes[0].nodeValue;
				var optStore = document.createElement("option");
				
				optStore.text = batchDes;
				optStore.value = batchID;
				document.getElementById("cboBatchNo").options.add(optStore);
			 }
			 document.getElementById("cboBatchNo").value=0;
		}
	}
}

function LoadSuppliers()
{
	CreateXMLHttpForSuppliers();
	xmlHttpSup.onreadystatechange = HandleSuppliers;
    xmlHttpSup.open("GET", 'advancepaymentDB.php?DBOprType=getSupList', true);
	xmlHttpSup.send(null); 
}

function HandleSuppliers()
{	

	if(xmlHttpSup.readyState == 4) 
    {
	   if(xmlHttpSup.status == 200) 
        {  
			var XMLSupID = xmlHttpSup.responseXML.getElementsByTagName("supID");
			var XMLSupName = xmlHttpSup.responseXML.getElementsByTagName("supName");
			clearSelectControl("cboSuppliers");
			
			var optStorex = document.createElement("option");			
			optStorex.text = "";
			optStorex.value = 0;
			document.getElementById("cboSuppliers").options.add(optStorex);
				
			for ( var loop = 0; loop < XMLSupID.length; loop ++)
			 {
				var SupID = XMLSupID[loop].childNodes[0].nodeValue;
				var SupName = XMLSupName[loop].childNodes[0].nodeValue;
				var optStore = document.createElement("option");
				
				optStore.text = SupName;
				optStore.value = SupID;
				document.getElementById("cboSuppliers").options.add(optStore);
			 }
			 document.getElementById("cboSuppliers").value=0;
		}
	}
}
//bookmark2
function SaveAdvPayment()
{
	var type = '';
	
	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';
	
	CreateXMLHttpForAdvanceNo();
	xmlHttpAdvNo.onreadystatechange = HandleAdvanceNo;
    xmlHttpAdvNo.open("GET", 'advancepaymentDB.php?DBOprType=AdvPaymentNoTask&strPaymentType=' + type , true);
	xmlHttpAdvNo.send(null); 
}

function HandleAdvanceNo()
{
	if(xmlHttpAdvNo.readyState == 4) 
    {
	   if(xmlHttpAdvNo.status == 200) 
        {  
			var no	= xmlHttpAdvNo.responseText;
			savePayment(no);
		}
	}
}

//bookmark
function savePayment(intPaymentNo)
{
		
		var type = '';
	
	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';
	
strPaymentType=type;

//var paymentno=document.getElementById("txtPaymentNo").value;
//var datex=document.getElementById("txtDate").value

var supid=document.getElementById("cboSuppliers").value;

var description=document.getElementById("txtDescription").value;
var batchno=document.getElementById("cboBatchNo").value;
var draft=document.getElementById("txtDraftNo").value;
var discount=document.getElementById("txtDiscount").value;
var frightcharge=document.getElementById("txtFrightChargers").value;
var couriercharge=document.getElementById("txtCourierChargers").value;	
var bankcharge=document.getElementById("txtBankChargers").value;
var poamount=document.getElementById("txtPOAmount").value;
var totalamount=document.getElementById("txtPOTotalAmount").value;
var currency=document.getElementById("cboCurrencyTo").value;
var ExRate=document.getElementById("txtcurrency").value;
if(draft=="")
{	
	draft=0;	
}

	var tblPOList=document.getElementById('tblPOList');
	var txtcurrency=document.getElementById("txtcurrency").value;
	var cboCurrency=document.getElementById("cboCurrencyTo").value;
				
				
				
var taxamount=0;//document.getElementById("cboSuppliers").value	
	var taxTot=0;
	var tax="";
	var rate=0;
	var amount=0;

	
	var rows=document.getElementById('tblTax').getElementsByTagName("TR");
	for(var x=1;x<rows.length;x++)
	{
		var cells=rows[x].getElementsByTagName("TD");

		if(cells[0].firstChild.checked==true)
		{
			
			
			
			
			taxamount	=taxamount+parseFloat(cells[3].firstChild.nodeValue );
			tax=cells[1].firstChild.nodeValue ;
			rate=cells[2].firstChild.nodeValue ;
			amount=cells[3].firstChild.nodeValue ;
			CreateXMLHttpForTaxSave(x);
			xmlHttpTaxSave[x].onreadystatechange = HandleTaxSave;	
			xmlHttpTaxSave[x].index = x;
			xmlHttpTaxSave[x].open("GET", 'advancepaymentDB.php?DBOprType=SaveAdvTax&strPaymentType=' + strPaymentType+'&paymentno='+intPaymentNo + '&tax=' + tax + '&rate=' + rate + '&amount=' + amount, true);
			xmlHttpTaxSave[x].send(null); 		
		}
	}
	
	var rows=document.getElementById('tblGLAccs').getElementsByTagName("TR");
	for(var loop=1;loop<rows.length;loop++)
	{
		var cells=rows[loop].getElementsByTagName("TD");
		if(cells[0].firstChild.checked==true)
		{
		var GLAmt=parseFloat(cells[3].firstChild.value);
		var GLAccNo=cells[1].firstChild.nodeValue ;
		CreateXMLHttpForGLsSave(loop);
		xmlHttpGLSave[loop].onreadystatechange = HandleGLAccSave;
		xmlHttpGLSave[loop].index = loop;
		xmlHttpGLSave[loop].open("GET", 'advancepaymentDB.php?DBOprType=SaveAdvGLs&strPaymentType=' + strPaymentType + '&paymentno=' + intPaymentNo + '&glaccno=' + GLAccNo + '&amount=' + GLAmt , true);
		xmlHttpGLSave[loop].send(null); 	
		}
	}
	

	var rows=document.getElementById('tblPOList').getElementsByTagName("TR");
	
	for(var loop=1;loop<rows.length;loop++)
	{
		var cells=rows[loop].getElementsByTagName("TD");
		
		if(cells[0].firstChild.checked == true)
		{	
			var pono=cells[1].childNodes[0].firstChild.nodeValue ;
		
				var poNo		= 	pono.split('/')[1];
				var poYear		= 	pono.split('/')[0];
				
			var txtcurrency = document.getElementById("txtcurrency").value;	
			
			var paidamount = parseFloat(cells[6].firstChild.value);
			//var paidamount=parseFloat(cells[6].firstChild.value) ;
			
			if(tblPOList.rows[loop].cells[2].id==document.getElementById("cboCurrencyTo").value)
			{
				paidamount =parseFloat(cells[6].firstChild.value);
			}
			else
			{	
				paidamount = parseFloat(cells[6].firstChild.value) / (txtcurrency)  * parseFloat(tblPOList.rows[loop].cells[0].id);
			}
			
			
			CreateXMLHttpForPOsSave(loop);
			xmlHttpPOSave[loop].onreadystatechange = HandlePOSave;
			xmlHttpPOSave[loop].index				= loop;
			var url='advancepaymentDB.php?DBOprType=SaveAdvPOs&strPaymentType=' + strPaymentType + '&paymentno=' + intPaymentNo + '&poNo=' + poNo +'&poYear='+poYear+ '&paidamount=' + paidamount ;
			//console.log(url);
			xmlHttpPOSave[loop].open("GET", url , true);
			
			xmlHttpPOSave[loop].send(null); 	
		}
	}
	
	
	CreateXMLHttpForAdvanceSave();
	
	xmlHttpSave.onreadystatechange = HandleAdvanceSave;
	xmlHttpSave.index	= intPaymentNo;
    xmlHttpSave.open("GET", 'advancepaymentDB.php?DBOprType=SaveAdvPayment&strPaymentType=' + strPaymentType + '&paymentno=' + intPaymentNo  + '&supid=' + supid + '&description=' + description + '&batchno=' + batchno + '&draft=' + draft + '&discount=' + discount + '&frightcharge=' + frightcharge + '&couriercharge=' + couriercharge + '&bankcharge=' + bankcharge + '&poamount=' + poamount + '&taxamount=' + taxamount + '&totalamount=' + totalamount + '&currency=' + currency + '&dblExchangeRate =' + ExRate + true);
	xmlHttpSave.send(null); 
}
function HandleAdvanceSave()
{
	
	if(xmlHttpSave.readyState == 4) 
    {
	   if(xmlHttpSave.status == 200) 
        {  
		//alert('done');
			var XMLResult = xmlHttpSave.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				alert("Advance Payment Saved Successfully. No is "+xmlHttpSave.index); 
			
				savedStatus=1;
				//getAdvPaymentNo(2)
			}
			else
			{
				alert("Save Process Failed.");
				
			}
		}
	}
    reportPaymentId = xmlHttpSave.index ;
}
function buttindisable()
	{
	document.getElementById("savebutton").hidden == true;
	}
function HandleTaxSave()
{
	if(xmlHttpTaxSave[this.index].readyState == 4) 
    {
	   if(xmlHttpTaxSave[this.index].status == 200) 
        {  
			var XMLResult = xmlHttpTaxSave[this.index].responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				//alert("New Tax Saved Successfully.");
			}

		}
	}
}

function HandleGLAccSave()
{
	if(xmlHttpGLSave[this.index].readyState == 4) 
    {
	   if(xmlHttpGLSave[this.index].status == 200) 
        {  
			var XMLResult = xmlHttpGLSave[this.index].responseXML.getElementsByTagName("Result");
		}
	}
}

function HandlePOSave()
{
	if(xmlHttpPOSave[this.index].readyState == 4) 
    {
	   if(xmlHttpPOSave[this.index].status == 200) 
        {  
			var XMLResult = xmlHttpPOSave[this.index].responseXML.getElementsByTagName("Result");
		}
	}
}

function clearAll()
{
	var rows=document.getElementById('tblTax').getElementsByTagName("TR");
	
	for(var x=1;x<rows.length;x++)
	{
		var cells=rows[x].getElementsByTagName("TD");
		cells[3].firstChild.nodeValue ="0.00"
		cells[0].firstChild.checked=false;
	}
	
	
	var glaccTable="<table width=\"420\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccs\" name=id=\"tblGLAccs\">"+
					"<tr>"+
						"<td width=\"114\" height=\"25\" bgcolor=\"#498CC2\" class=\"grid_header\">GL Acc</td>"+
						"<td width=\"187\" bgcolor=\"#498CC2\" class=\"grid_header\">Description</td>"+
						"<td width=\"234\" bgcolor=\"#498CC2\" class=\"grid_header\">Amount</td>"+
					"</tr>"+
					"</table>"
	document.getElementById("divconsOfSelGLs").innerHTML=glaccTable	
		
		
			  
	var poTable="<table width=\"933\"  cellpadding=\"0\" cellspacing=\"0\" boder=\"1\" name=\"tblPOList\" id=\"tblPOList\">"+
					"<tr>"+
					  "<td width=\"5\" bgcolor=\"\" class=\"grid_header\">*</td>"+
					  "<td width=\"10\" height=\"33\" bgcolor=\"\" class=\"grid_header\">PO NO</td>"+
					  "<td width=\"9\" bgcolor=\"\" class=\"grid_header\">Currency</td>"+
					  "<td width=\"9\" bgcolor=\"\" class=\"grid_header\">PO Amount</td>"+
					  "<td width=\"9\" bgcolor=\"\" class=\"grid_header\">PO Paid Amount</td>"+
					  "<td width=\"9\" bgcolor=\"\" class=\"grid_header\">PO Balance</td>"+
					  "<td width=\"9\" bgcolor=\"\" class=\"grid_header\">Pay Amount</td>"+
					  "<td width=\"9\" bgcolor=\"\" class=\"grid_header\">SL Amount</td>"+
					  "<td width=\"9\" bgcolor=\"\" class=\"grid_header\">Pay Term</td>"+
					"</tr>"+
				 "</table>"
	document.getElementById("divPOs").innerHTML=poTable;	
	document.getElementById("cboSuppliers").value=0;
	document.getElementById("txtDescription").value="";
	document.getElementById("cboBatchNo").value="";
	document.getElementById("txtDraftNo").value=0;
	document.getElementById("txtDiscount").value="0.00";
	document.getElementById("txtFrightChargers").value="0.00";
	document.getElementById("txtCourierChargers").value="0.00";
	document.getElementById("txtBankChargers").value="0.00";
	document.getElementById("txtPOAmount").value="0.00";
	document.getElementById("txtPOTotalAmount").value="0.00";
	document.getElementById("cboCurrencyTo").value=0;
	savedStatus=0;
	//getAdvPaymentNo(1)
}



function clearSelectControl(cboid)
{
   var select=document.getElementById(cboid);
   if(select!=null)
   {
	   var options=select.getElementsByTagName("option");
	   var aa=0;
	   for (aa=select.options.length-1;aa>=0;aa--)
	   {
			select.remove(aa);
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



function ReportPrint()
{
var strPaymentType = '';
	
	if(document.getElementById("rdoStyle").checked)
		{
	strPaymentType = 'S';
	window.open('rptAdvancePaymentReport.php?PayNo=' + reportPaymentId + '&strPaymentType=' + strPaymentType)
		}
	else if(document.getElementById("rdoBulk").checked)
	    {
	strPaymentType = 'B';
	window.open('rptAdvancePaymentReport.php?PayNo=' + reportPaymentId + '&strPaymentType=' + strPaymentType)
		}	
	else if(document.getElementById("rdoGeneral").checked)
		{
	strPaymentType = 'G';
	window.open('rptAdvancePaymentReport.php?PayNo=' + reportPaymentId + '&strPaymentType=' + strPaymentType)
		}
	else if(document.getElementById("rdoWash").checked)
		{
	strPaymentType = 'W';
    window.open('rptAdvancePaymentReport.php?PayNo=' + reportPaymentId + '&strPaymentType=' + strPaymentType)
		}
	
	
}

function AdvancePaymentReport()
{
	location = "advancePaymentFinder.php";
	return;
	try
	{
		document.getElementById('popupGLAccounts').style.visibility = 'hidden';
		document.getElementById('popupAdvancePayment').style.visibility = 'hidden';

	}
	catch(err)
	{        
	}
	


	var advReport="<table width=\"800\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
	"<tr>"+
	"<td><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">"+
	"<tr>"+
	"<td width=\"20%\"><img src=\"../images/eplan_logo.png\" alt=\"\" width=\"191\" height=\"47\" class=\"normalfnt\" /></td>"+
	"<td width=\"6%\" class=\"normalfnt\">&nbsp;</td>"+
	"<td width=\"74%\" class=\"tophead\"><p class=\"topheadBLACK\">Jinadasa Brothers Ltd</p>"+
	"<p class=\"normalfnt\">Colombo, Sri Lanka. Tel: (+94) 112 345678 Fax: (+94) 112 345678 </p>"+
	"<p class=\"normalfnt\">E-Mail: info@jinadasa.com Web: www.jinadasa.com</p></td>"+
	"</tr>"+
	"</table></td>"+
	"</tr>"+
	"<tr>"+
	"<td><div id=\"divCaption\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  id=\"tblCaption\">"+
	"<tr>"+
	"<td height=\"36\" colspan=\"5\" class=\"head2\">ADVANCE PAYMENT</td>"+
	"</tr>"+
	"<tr>"+
	"<td width=\"8%\" class=\"normalfnth2B\">PAYEE</td>"+
	"<td width=\"40%\" class=\"normalfnt\"></td>"+
	"<td width=\"6%\" class=\"normalfnt\">&nbsp;</td>"+
	"<td width=\"19%\" class=\"normalfnth2B\">PAYMENT NO</td>"+
	"<td width=\"27%\" class=\"normalfnt\">&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td height=\"13\" class=\"normalfnth2B\">&nbsp;</td>"+
	"<td class=\"normalfnt\">&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td class=\"normalfnth2B\">DATE</td>"+
	"<td class=\"normalfnt\">&nbsp;</td>"+
	"</tr>"+
	"</table></div></td>"+
	"</tr>"+
	"<tr>"+
	"<td class=\"normalfnth2B\">Style Ratio</td>"+
	"</tr>"+
	"<tr>"+
	"<td><div id=\"divItems\"> <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"tablez\"  id=\"tblItems\">"+
	"<tr>"+
	"<td width=\"36%\" height=\"25\" class=\"normalfntBtab\">DISCRIPTION</td>"+
	"<td width=\"14%\" class=\"normalfntBtab\">AMOUNT</td>"+
	"<td width=\"10%\" class=\"normalfntBtab\">VAT</td>"+
	"<td width=\"13%\" class=\"normalfntBtab\">CHARGERS</td>"+
	"<td width=\"11%\" class=\"normalfntBtab\">DISCOUNT</td>"+
	"<td width=\"16%\" class=\"normalfntBtab\">TOTAL AMOUNT</td>"+
	"</tr>"+
	"<tr>"+
	"<td class=\"normalfntTAB\"></td>"+
	"<td class=\"normalfntRiteTAB\"></td>"+
	"<td class=\"normalfntRiteTAB\"></td>"+
	"<td class=\"normalfntRiteTAB\"></td>"+
	"<td class=\"normalfntMidTAB\"></td>"+
	"<td class=\"normalfntRiteTAB\"></td>"+
	"</tr>"+
	/*"<tr>"+
	"<td class=\"normalfntTAB\"> Cotton 98% Cotton 2% Elastane</td>"+
	"<td class=\"normalfntRiteTAB\">14752</td>"+
	"<td class=\"normalfntRiteTAB\">14752</td>"+
	"<td class=\"normalfntRiteTAB\">14752</td>"+
	"<td class=\"normalfntMidTAB\">0.00%</td>"+
	"<td class=\"normalfntRiteTAB\">14752</td>"+
	"</tr>"+*/
	"<tr>"+
	"<td class=\"normalfnth2Bm\">Grand Total</td>"+
	"<td class=\"normalfnth2Bm\">&nbsp;</td>"+
	"<td class=\"normalfnth2Bm\">&nbsp;</td>"+
	"<td class=\"normalfnth2Bm\">&nbsp;</td>"+
	"<td class=\"normalfnth2Bm\">&nbsp;</td>"+
	"<td class=\"nfhighlite1\"></td>"+
	"</tr>"+
	"</table></div></td>"+
	"</tr>"+
	"<tr>"+
	"<td>&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td><div id=\"divGLAccs\"> <table width=\"100%\" height=\"60\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  id=\"tblGLAccs\">"+
	"<tr>"+
	"<td width=\"27%\" height=\"25\" class=\"normalfntBtab\">ACCOUNT</td>"+
	"<td width=\"26%\" class=\"normalfntBtab\">A/C CODE</td>"+
	"<td width=\"13%\" class=\"normalfntBtab\">AMOUNT</td>"+
	"<td width=\"34%\" class=\"normalfntBtab\">ADDRESS</td>"+
	"</tr>"+
	"<tr>"+
	"<td height=\"18\" class=\"normalfntTAB\"></td>"+
	"<td class=\"normalfntTAB\"></td>"+
	"<td class=\"normalfntTAB\"></td>"+
	"<td class=\"normalfntTAB\"></td>"+
	"</tr>"+
	/*"<tr>"+
	"<td height=\"17\" class=\"normalfntTAB\">97C AQUA</td>"+
	"<td class=\"normalfntTAB\">452</td>"+
	"<td class=\"normalfntTAB\">247</td>"+
	"<td class=\"normalfntTAB\">456</td>"+
	"</tr>"+*/
	"</table></div></td>"+
	"</tr>"+
	"<tr>"+
	"<td>&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td><table width=\"100%\" border=\"0\">"+
	"<tr>"+
	"<td width=\"20%\" class=\"normalfnt\">PREPARED BY</td>"+
	"<td width=\"25%\" class=\"bcgl1txt1\">&nbsp;</td>"+
	"<td width=\"13%\">&nbsp;</td>"+
	"<td width=\"15%\">&nbsp;</td>"+
	"<td width=\"27%\">&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td class=\"normalfnt\">CHECKED BY</td>"+
	"<td class=\"bcgl1txt1\">&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td class=\"normalfnt\">AUTHORIZED BY</td>"+
	"<td class=\"bcgl1txt1\">&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"</tr>"+
	"<tr>"+
	"<td class=\"normalfnt\">APPROVED BY</td>"+
	"<td class=\"bcgl1txt1\">&nbsp;</td>"+
	"<td>&nbsp;</td>"+
	"<td class=\"normalfnt\">RECIVED BY</td>"+
	"<td class=\"bcgl1txt1\">&nbsp;</td>"+
	"</tr>"+
	"</table></td>"+
	"</tr>"+
	"</table>"
	
	var popupbox3 = document.createElement("div");
	popupbox3.id = "popupAdvancePaymentReport";
	popupbox3.style.position = 'absolute';
	popupbox3.style.zIndex = 1;
	popupbox3.style.left = 100 + 'px';
	popupbox3.style.top = 20 + 'px';  
	popupbox3.innerHTML = advReport//testA;//aa;//strAdvRepot;        
	document.body.style.background="#FFFFFF"
	document.body.appendChild(popupbox3);
	
	var PaymentNo=document.getElementById("txtPaymentNo").value
	PaymentNo=PaymentNo-1
	//getAdvacePaymentsList(supid);
	//getAdvPayData(PaymentNo)
	}

function getAdvacePaymentsList(supid)
{
	strPaymentType=document.getElementById("cboPymentType").value
	
	CreateXMLHttpForAdvPays();
	xmlHttpAdvs.onreadystatechange = HandleAdvacePaymentsList;
	xmlHttpAdvs.open("GET", 'advancepaymentDB.php?DBOprType=getAdvacePaymentsList&strPaymentType=' + strPaymentType + '&supid=' + supid , true);
	xmlHttpAdvs.send(null); 
}
function HandleAdvacePaymentsList()
{
	if(xmlHttpAdvs.readyState == 4) 
    {
	   if(xmlHttpAdvs.status == 200) 
        {  
			var XMLAdvPayNo = xmlHttpAdvs.responseXML.getElementsByTagName("AdvPayNo");

			var strAdvPayList="<table width=\"124\" class=\"backcolorYellow\" height=\"440\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#9999FF\">"+
      "<tr bgcolor=\"#498CC2\">"+
        "<td width=\"100\" height=\"25\" bgcolor=\"#498CC2\"  class=\"normaltxtmidb2\">Payment No</td>"+
        "<td width=\"100\" height=\"25\" bgcolor=\"#498CC2\"  class=\"normaltxtmidb2\"></td>"+
        "</tr>"
			for(var loop=0;loop<XMLAdvPayNo.length;loop++)
			{
				var AdvPayNo=XMLAdvPayNo[loop].childNodes[0].nodeValue;
				
				strAdvPayList+="<tr>"+
							   "<td  class=\"normalfnt\" height=\"5\">" + AdvPayNo  + "</td>"+
							   "<td class=\"normalfnt\" height=\"5\"><img src=\"../images/manage.png\" onclick=\"getAdvPayData(this)\" alt=\"AdvPayReport\" width=\"16\" /></td>"+
						       "</tr>"
			
			}
			strAdvPayList+="</table>"
	
			document.getElementById("divAdvReportPONOList").innerHTML=strAdvPayList;
		}
	}
}

function CreateXMLHttpAdvData() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpData = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpData = new XMLHttpRequest();
    }
}

function fillAvailableAdvData()
{
		
	//strPaymentType=document.getElementById("cboPymentType").value
	/*if( document.getElementById("rdoStyle").checked )
	{
		strPaymentType = 'S';	
	}
	else if( document.getElementById("rdoBulk").checked )
	{
		strPaymentType = 'B';	
	}
	else
		strPaymentType = 'G';	*/
		
		
	if(document.getElementById("rdoStyle").checked)
		strPaymentType = 'S';
	else if(document.getElementById("rdoBulk").checked)
		strPaymentType = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		strPaymentType = 'G';
	else if(document.getElementById("rdoWash").checked)
		strPaymentType = 'W';
	//paymentType=paymentTypexx
	var supID=document.getElementById("cboSuppliers").value;
	var dateFrom=document.getElementById("txtDateFrom").value;
	var dateTo=document.getElementById("txtDateTo").value;

	CreateXMLHttpAdvData() 
	
	xmlHttpData.onreadystatechange = HandleAdvData;
	xmlHttpData.open("GET", 'advancepaymentDB.php?DBOprType=findAdvData&strPaymentType=' + strPaymentType + '&supID=' + supID + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo , true);
	xmlHttpData.send(null); 
	
}

function HandleAdvData()
{	

	if(xmlHttpData.readyState == 4) 
    {
	   if(xmlHttpData.status == 200) 
        {  
			var XMLPaymentNo = xmlHttpData.responseXML.getElementsByTagName("PaymentNo");
			var XMLDate = xmlHttpData.responseXML.getElementsByTagName("paydate");
			var XMLAmount = xmlHttpData.responseXML.getElementsByTagName("poamount");
			var XMLTaxAmount = xmlHttpData.responseXML.getElementsByTagName("taxamount");
			var XMLTotalAmount = xmlHttpData.responseXML.getElementsByTagName("totalamount");
			
			
			var strData="<td colspan=\"2\"><table id=\"tblAdvData\" width=\"945\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bordercolor=\"#162350\" bgcolor=\"\" >"+
			"<thead>"+
			"<tr>"+
			"<td width=\"2%\"  height=\"33\" bgcolor=\"\" class=\"grid_header\"></td>"+
			"<td width=\"16%\" height=\"29\" bgcolor=\"\" class=\"grid_header\">Payment No </td>"+
			"<td width=\"16%\" bgcolor=\"\" class=\"grid_header\">Date</td>"+
			"<td width=\"18%\" bgcolor=\"\" class=\"grid_header\">Amount</td>"+
			"<td width=\"18%\" bgcolor=\"\" class=\"grid_header\">Tax</td>"+
			"<td width=\"18%\" bgcolor=\"\" class=\"grid_header\">Total Amount</td>"+
			"<td width=\"10%\" bgcolor=\"\" class=\"grid_header\">View</td>"+
			"<td width=\"5%\" bgcolor=\"\" class=\"grid_header\">&nbsp;</td>"+
			"</tr>"+
			
			"</thead>";
			
			strData+="<tbody style=\"overflow: -moz-scrollbars-vertical; height:160px\">";
				
			for ( var loop = 0; loop < XMLPaymentNo.length; loop ++)
			 {
				var advNo = XMLPaymentNo[loop].childNodes[0].nodeValue;
				var datex = XMLDate[loop].childNodes[0].nodeValue;
				var amt = XMLAmount[loop].childNodes[0].nodeValue;
				var taxAmt = XMLTaxAmount[loop].childNodes[0].nodeValue;
				var totAmt = XMLTotalAmount[loop].childNodes[0].nodeValue;
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				strData+="<tr>"+
				"<td width=\"2%\" bgcolor=\"\" class=\""+cls+"\"></td>"+
				"<td height=\"20\"  bgcolor=\"\" class=\""+cls+"\"  onmouseover=\"highlight(this.parentNode)\">" + advNo + "</td>"+
				"<td height=\"20\" bgcolor=\"\" class=\""+cls+"\"  onmouseover=\"highlight(this.parentNode)\">" + datex + "</td>"+
				"<td height=\"20\" bgcolor=\"\" class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + amt + "</td>"+
				"<td height=\"20\" bgcolor=\"\" class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + taxAmt + "</td>"+
				"<td height=\"20\" bgcolor=\"\" class=\""+cls+"\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + totAmt + "</td>"+
				"<td height=\"20\" bgcolor=\"\" class=\""+cls+"\"><div align=\"center\" onmouseover=\"highlight(this.parentNode)\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\" onclick=\"previewReport(this)\"/></div></td>"+
				"</tr>";
				
			 }
			 if(XMLPaymentNo.length<9)
			 {
				 while(loop<7)
				 {
					 loop++;
					 strData+="<tr>"+
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
			 strData+="</tbody></table>";
			 document.getElementById("divAdvData").innerHTML=strData;
		}
		//document.getElementById("divAdvData").innerHTML=strData
		
	}
}

function previewReport(obj)
{
	/*if( document.getElementById("rdoStyle").checked )
	{
		strPaymentType = 'S';	
	}
	else
		strPaymentType = 'G';	*/
		
		if(document.getElementById("rdoStyle").checked)
		strPaymentType = 'S';
	else if(document.getElementById("rdoBulk").checked)
		strPaymentType = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		strPaymentType = 'G';
	else if(document.getElementById("rdoWash").checked)
		strPaymentType = 'W';
	var row=obj.parentNode.parentNode.parentNode
	var selectedAdvPaymentNo =  row.cells[1].innerHTML;
	window.open('rptAdvancePaymentReport.php?PayNo=' + selectedAdvPaymentNo + '&strPaymentType=' + strPaymentType)
}

function setDefaultDate()
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
	
	var ddate=( year + "/" + month + "/" + day);
	document.getElementById("txtDate").value=ddate
	//getAdvPaymentNo(1)
}

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
	document.getElementById("txtDateFrom").value=ddate
	document.getElementById("txtDateTo").value=ddate
	
	
}

 //==================

function toWords(s)
{s = s.toString(); s = s.replace(/[\, ]/g,''); if (s != String(parseFloat(s))) return 'not a number'; 
var x = s.indexOf('.'); if (x == -1) x = s.length; if (x > 15) return 'too big'; var n = s.split(''); var str = ''; var sk = 0; for (var i=0; i < x; i++) {if ((x-i)%3==2) {if (n[i] == '1') {str += tn[Number(n[i+1])] + ' '; i++; sk=1;} else if (n[i]!=0) {str += tw[n[i]-2] + ' ';sk=1;}} else if (n[i]!=0) {str += dg[n[i]] +' '; if ((x-i)%3==0) str += 'hundred ';sk=1;} if ((x-i)%3==1) {if (sk) str += th[(x-i-1)/3] + ' ';sk=0;}} if (x != s.length) {var y = s.length; str += 'point '; for (var i=x+1; i<y; i++) str += dg[n[i]] +' ';} return str.replace(/\s+/g,' ');
}

//===================================================
var oldLink = null;
// code to change the active stylesheet
function setActiveStyleSheet(link, title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
  if (oldLink) oldLink.style.fontWeight = 'normal';
  oldLink = link;
  link.style.fontWeight = 'bold';
  return false;
}

// This function gets called when the end-user clicks on some date.
function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.
  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
    // if we add this call we close the calendar on single-click.
    // just to exemplify both cases, we are using this only for the 1st
    // and the 3rd field, while 2nd and 4th will still require double-click.
    cal.callCloseHandler();
}

// And this gets called when the end-user clicks on the _selected_ date,
// or clicks on the "Close" button.  It just hides the calendar without
// destroying it.
function closeHandler(cal) {
  cal.hide();                        // hide the calendar
//  cal.destroy();
  _dynarch_popupCalendar = null;
}

// This function shows the calendar under the element having the given id.
// It takes care of catching "mousedown" signals on document and hiding the
// calendar if the click was outside.
function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) {
    // we already have some calendar created
    _dynarch_popupCalendar.hide();                 // so we hide it first.
  } else {
    // first-time call, create the calendar.
    var cal = new Calendar(1, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    _dynarch_popupCalendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  return false;
}

var MINUTE = 60 * 1000;
var HOUR = 60 * MINUTE;
var DAY = 24 * HOUR;
var WEEK = 7 * DAY;

// If this handler returns true then the "date" given as
// parameter will be disabled.  In this example we enable
// only days within a range of 10 days from the current
// date.
// You can use the functions date.getFullYear() -- returns the year
// as 4 digit number, date.getMonth() -- returns the month as 0..11,
// and date.getDate() -- returns the date of the month as 1..31, to
// make heavy calculations here.  However, beware that this function
// should be very fast, as it is called for each day in a month when
// the calendar is (re)constructed.
function isDisabled(date) {
  var today = new Date();
  return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;
}

function flatSelected(cal, date) {
  var el = document.getElementById("preview");
  el.innerHTML = date;
}

function showFlatCalendar() {
  var parent = document.getElementById("display");

  // construct a calendar giving only the "selected" handler.
  var cal = new Calendar(0, null, flatSelected);

  // hide week numbers
  cal.weekNumbers = false;

  // We want some dates to be disabled; see function isDisabled above
  cal.setDisabledHandler(isDisabled);
  cal.setDateFormat("%A, %B %e");

  // this call must be the last as it might use data initialized above; if
  // we specify a parent, as opposite to the "showCalendar" function above,
  // then we create a flat calendar -- not popup.  Hidden, though, but...
  cal.create(parent);

  // ... we can show it here.
  cal.show();
}

function pageRefresh()
{
	document.getElementById("frmAdvance").submit();
}
function pageRefreshListing()
{
	document.getElementById("form1").submit();
}
//==============================================


/*//Calander Functions
function toggleCalendar()
{	
	var txtObj=document.getElementById("txtDate")
	cObj = txtObj.myCalendar;

	if (!cObj) {
		cObj = new CalendarDisplay(txtObj);
		document.body.appendChild(cObj.cDiv);
		txtObj.myCalendar = cObj;
	}
	
	cObj.toggle();
}

CalendarDisplay = function(txtObj)
{
	this.txtObj = txtObj;
	this.tBox = this.txtObj;
	this.cDiv = document.createElement('div');
	this.cDiv.style.position = 'absolute';
	this.cDiv.style.display = 'none';
}

CalendarDisplay.prototype.MONTHS_CALENDAR = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
CalendarDisplay.prototype.DAYS_1_CALENDAR = new Array("S", "M", "T", "W", "T", "F", "S");
CalendarDisplay.prototype.DAYS_2_CALENDAR = new Array("Su", "Mo", "Tu", "We", "Th", "Fr", "Sa");

CalendarDisplay.prototype.toggle = function() {
	if (this.cDiv.style.display == 'none') {
		this.adjustPosition();
		this.fillCalendar(this.grabDate());
		this.cDiv.style.display = 'block';
	} else {
		this.cDiv.style.display = 'none';
	}
}

CalendarDisplay.prototype.grabDate = function() {
	var tempDate = new Date(this.tBox.value);
	if (!tempDate.getYear()) {
		tempDate = new Date();
	}
	return tempDate;
}

CalendarDisplay.prototype.fillCalendar = function(theDate) {
	if (this.cDiv.firstChild) {
		this.cDiv.removeChild(this.cDiv.firstChild);
	}
	this.adjustPosition();
	this.cDiv.appendChild(this.getCalendar(theDate));
}

CalendarDisplay.prototype.adjustPosition = function() {
	this.cDiv.style.top = this.tBox.offsetHeight + this.findPosY(this.tBox) + 'px';

	this.cDiv.style.left = this.findPosX(this.tBox) + 'px';
}

CalendarDisplay.prototype.getCalendar = function(theDate) {
	var theYear = theDate.getFullYear();
	var theMonth = theDate.getMonth();
	var theDay = theDate.getDate();

	var theTable = document.createElement('table');
	theTable.id = 'calendartable';
	var theTHead = theTable.createTHead();
	var theTBody = document.createElement('tbody');
	theTable.appendChild(theTBody);
	
	var monthRow = theTHead.insertRow(0);
	var navLeftCell = monthRow.insertCell(0);
	var monthCell = monthRow.insertCell(1);
	var navRightCell = monthRow.insertCell(2);
	monthCell.colSpan = 5;
	monthCell.appendChild(document.createTextNode(this.MONTHS_CALENDAR[theMonth] + ', ' + theYear));
	var leftLink = document.createElement('a');
	leftLink.href = '#';
	this.setCalendarPrevious(leftLink, this.txtObj, theYear, theMonth, theDay);
	leftLink.appendChild(document.createTextNode('-'));
	navLeftCell.appendChild(leftLink);
	var rightLink = document.createElement('a');
	rightLink.href = '#';
	this.setCalendarNext(rightLink, this.txtObj, theYear, theMonth, theDay);
	rightLink.appendChild(document.createTextNode('+'));
	navRightCell.appendChild(rightLink);
	
	var weeksRow = theTHead.insertRow(1);
	for (var i=0; i<7; i++) {
		var tempWeeksCell = weeksRow.insertCell(i);
		tempWeeksCell.appendChild(document.createTextNode(this.DAYS_2_CALENDAR[i]));
	}
	
	var temporaryDate1 = new Date(theYear, theMonth, 1);
	var startDayOfWeek = temporaryDate1.getDay();
	var temporaryDate2 = new Date(theYear, theMonth + 1, 0);
	var lastDateOfMonth = temporaryDate2.getDate();
	var dayCount = 1;
		
	for (var r=0; r<6; r++) {
		var tempDaysRow = theTable.tBodies[0].insertRow(r);
		tempDaysRow.className = 'dayrow';
		for (var c=0; c<7; c++) {
			var tempDaysCell = tempDaysRow.insertCell(c);
			var mysteryNode;
			if ((r > 0 || c >= startDayOfWeek) && dayCount <= lastDateOfMonth) {
				tempDaysCell.className = 'yestext';
				var mysteryNode = document.createElement('a');
				mysteryNode.href = '#';
				this.setCalendarClick(mysteryNode, this.txtObj, theYear, theMonth, dayCount);
				mysteryNode.appendChild(document.createTextNode(dayCount));
				dayCount++;
			} else {
				tempDaysCell.className = 'notext';
				mysteryNode = document.createTextNode('');
			}
			tempDaysCell.appendChild(mysteryNode);
		}
	}
	
	return theTable;
}
CalendarDisplay.prototype.setCalendarClick = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {fillInFields(theObj, theYear, (theMonth + 1), theDay); return false;}
}
CalendarDisplay.prototype.setCalendarPrevious = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {showPrevious(theObj, theYear, theMonth, theDay); return false;}
}
CalendarDisplay.prototype.setCalendarNext = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {showNext(theObj, theYear, theMonth, theDay); return false;}
}
	


CalendarDisplay.prototype.findPosX = function(obj) {
	var curleft = 0;
	if (obj.offsetParent) {
		while (obj.offsetParent) {
			curleft += obj.offsetLeft;
			obj = obj.offsetParent;
		}
	}
	else if (obj.x) {
		curleft += obj.x;
	}
	return curleft;
}


CalendarDisplay.prototype.findPosY = function(obj) {
	var curtop = 0;
	if (obj.offsetParent)	{
		while (obj.offsetParent) {
			curtop += obj.offsetTop;
			obj = obj.offsetParent;
		}
	}
	else if (obj.y) {
		curtop += obj.y;
	}
	return curtop;
}

function fillInFields(obj, year, month, day)
{
	obj.value = (month < 10 ? '0'+month : month) + '/' + (day < 10 ? '0'+day : day) + '/' + year;
	cObj = obj.myCalendar;
	cObj.toggle();
}

function showPrevious(obj, year, month, day)
{
	cObj = obj.myCalendar;
	var lastMonth = new Date(year, month - 1, day)
	cObj.fillCalendar(lastMonth);
}
function showNext(obj, year, month, day)
{
	cObj = obj.myCalendar;
	var nextMonth = new Date(year, month + 1, day)
	cObj.fillCalendar(nextMonth);
}*/

/*function loadBatch(){
	var supplier   = document.getElementById('cboSuppliers').value;
	var CurrencyTo   = document.getElementById('cboCurrencyTo').value;

		
	var path = "advancepaymentDB.php?DBOprType=loadBatch2";
	    path += "&CurrencyTo="+CurrencyTo;

	htmlobj=$.ajax({url:path,async:false});	
	
	document.getElementById("cboBatchNo").innerHTML = htmlobj.responseText;
}*/

//----------------------------display_currency-------------------------------------

function loadcurrency(){
	
    var curID=document.getElementById('cboCurrencyTo').value.trim();

	var path = "advancepaymentDB.php?DBOprType=dbloadcurr";
	    path += "&curID="+curID;

	htmlobj=$.ajax({url:path,async:false});	
	
	var XMLExrate	=htmlobj.responseXML.getElementsByTagName("Exrate");
	
	if(XMLExrate.length > 0){
	  document.getElementById("txtcurrency").value=XMLExrate[0].childNodes[0].nodeValue;
	  
	}
}

//-------------------------------------------------------------------------------------

function grid_fix_header_poList()
{
	$("#tblPOList").fixedHeader({
	width: 955,height: 150
	});	
}

//-------------------------------------------------------------------------------------

function loadBatchAccCurr(){
var CurrencyTo   = document.getElementById('cboCurrencyTo').value;	

	var path = "advancepaymentDB.php?DBOprType=loadBatchAccCurr";
	    path += "&CurrencyTo="+CurrencyTo;

	htmlobj=$.ajax({url:path,async:false});
	document.getElementById("cboBatchNo").innerHTML = htmlobj.responseText;
}
