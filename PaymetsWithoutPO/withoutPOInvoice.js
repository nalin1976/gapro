var invoiceNo="";
var invNoAvailable=false;

function CreateXMLHttpForInvNo()
{
	if (window.ActiveXObject) 
    {
        xmlHttpInvNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpInvNo = new XMLHttpRequest();
    }
	
}

function CreateXMLHttpNewInvoiceTax()
{
	if (window.ActiveXObject) 
    {
        xmlHttpNewInvoiceTax = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpNewInvoiceTax = new XMLHttpRequest();
    }
}


function CreateXMLHttpNewInvoiceGLAllow()
{
	if (window.ActiveXObject) 
    {
        xmlHttpNewInvoiceGLAllow = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpNewInvoiceGLAllow = new XMLHttpRequest();
    }
}

function CreateXMLHttpWPInvoice()
{
	if (window.ActiveXObject) 
    {
        xmlHttpWPInvoice = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpWPInvoice = new XMLHttpRequest();
    }	
}

function CreateXMLHttpNewInvoice()
{
	if (window.ActiveXObject) 
    {
        xmlHttpNewInvoice = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpNewInvoice = new XMLHttpRequest();
    }
	
}
function CreateXMLHttpEntryNo()
{
	if (window.ActiveXObject) 
    {
        xmlHttpEntryNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpEntryNo = new XMLHttpRequest();
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


function CreateXMLHttpForNewInvNo()
{
	if (window.ActiveXObject) 
    {
        xmlHttpNewInvNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpNewInvNo = new XMLHttpRequest();
    }
	
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
	
	var ddate=(year + "/" + month + "/" +day );
	document.getElementById("txtDate").value=ddate
	getNewInvNo(1)
	loadTaxTypes()
}

function getNewInvNo(task)
{	
	CreateXMLHttpForNewInvNo();
	xmlHttpNewInvNo.onreadystatechange = HandleNewInvNo;
	xmlHttpNewInvNo.open("GET",'withoutPOInvoiceDB.php?DBOprType=WithouPOInvNoOperation&task=' + task, true);
	xmlHttpNewInvNo.send(null); 
}

function HandleNewInvNo()
{
	if(xmlHttpNewInvNo.readyState == 4) 
    {
	   if(xmlHttpNewInvNo.status == 200) 
        {  
			var XMLNewInvNo = xmlHttpNewInvNo.responseXML.getElementsByTagName("dblWithoutPOInvNo");
			
			if(XMLNewInvNo.length==0)
			{
				alert("Please Contact the admin to configer the Without PO Invoice No Range")
				document.getElementById("txtInvNo").focus();
				return;
			}
			
			var invNo = XMLNewInvNo[0].childNodes[0].nodeValue;
			document.getElementById("txtInvNo").value=invNo
			document.getElementById("cboPayee").focus();
			return;
			
		}
	}
}


function checkWithutPOInvNo()
{
	
	var invNo=document.getElementById("txtInvNo").value
	var payeeId=document.getElementById("cboPayee").value
	
	CreateXMLHttpForInvNo();
	xmlHttpInvNo.onreadystatechange = HandleWithouPOInvNoTask;
	xmlHttpInvNo.open("GET", 'withoutPOInvoiceDB.php?DBOprType=WithouPOInvNoTask&invNo=' + invNo + '&payeeId=' + payeeId, true);
	xmlHttpInvNo.send(null); 
}

function HandleWithouPOInvNoTask()
{
	if(xmlHttpInvNo.readyState == 4) 
    {
	   if(xmlHttpInvNo.status == 200) 
        {  
			var XMLWithouPOInvNo = xmlHttpInvNo.responseXML.getElementsByTagName("WithouPOInvNo");
			
			if(XMLWithouPOInvNo.length>0)
			{
				invoiceNo=""
				invNoAvailable=true
				return;
			}
			else
			{
				invNoAvailable=false
				return;
			
			}
			
		}
	}
}

function getEntryNo()
{
	var batchNo=document.getElementById("cbobatch").value;
	CreateXMLHttpEntryNo();
	xmlHttpEntryNo.onreadystatechange = HandleEntryNo;
	xmlHttpEntryNo.open("GET",'withoutPOInvoiceDB.php?DBOprType=getEntryNo&batchNo=' + batchNo, true);
	xmlHttpEntryNo.send(null); 
}
function HandleEntryNo()
{
	if(xmlHttpEntryNo.readyState == 4) 
    {
	   if(xmlHttpEntryNo.status == 200) 
        {  
			var XMLEntryNo = xmlHttpEntryNo.responseXML.getElementsByTagName("entryNo");
	
			if(XMLEntryNo.length>0)
			{
				var entryNo = XMLEntryNo[0].childNodes[0].nodeValue;
			}
			else
			{
				var entryNo =0
			}
			document.getElementById("txtEntryNo").value=entryNo+1;
		}
	}
	
}



function saveNewWithoutPOInvoice()
{
	var invNo=""
	if(checkValidation()==true)
	{
		if (document.getElementById("txtInvNo").value=="")
		{
			invNo=""
			return;
		}
		
		if(document.getElementById("txtInvNo").value!="")
		{
			invNo=document.getElementById("txtInvNo").value	
		}
		
		if (invNo=="")
		{ return; }
		
		
				if (document.getElementById("txtInvNo").value=="")
		{
			invNo=""
			return;
		}
		
		if(document.getElementById("txtInvNo").value!="")
		{
			invNo=document.getElementById("txtInvNo").value	
		}
		
		if (invNo=="")
		{ return; }
		
		//alert(invNo)
		
		var payeeID=document.getElementById("cboPayee").value
		var companyID=document.getElementById("cbocompany").value
		var invDate=document.getElementById("txtDate").value
		var discription=document.getElementById("txtDescription").value
		var batchNo=document.getElementById("cbobatch").value
		var batchEntryNo=document.getElementById("txtEntryNo").value
		var vatNo=document.getElementById("txtVATNo").value
		var accpacID=document.getElementById("txtAccpacID").value
		var currency=document.getElementById("cboCurrency").options[document.getElementById("cboCurrency").selectedIndex].text
		var rate=document.getElementById("cboCurrency").value
		var amount=document.getElementById("txtAmount").value
		var discount=document.getElementById("txtDiscount").value
		var taxAmt=document.getElementById("txtTaxAmt").value
		var totalInvAmount=document.getElementById("txtTotalAmount").value
		
		CreateXMLHttpNewInvoice();
		xmlHttpNewInvoice.onreadystatechange = HandleNewInvoice;
		xmlHttpNewInvoice.open("GET",'withoutPOInvoiceDB.php?DBOprType=saveWithoutPOInvoice&invoiceNo=' + invNo + '&payeeID=' + payeeID + '&companyID=' + companyID + '&invDate=' + invDate + '&discription=' + discription + '&batchNo=' + batchNo + '&batchEntryNo=' + batchEntryNo + '&vatNo=' + vatNo + '&accpacID=' + accpacID + '&currency=' + currency + '&rate=' + rate + '&amount=' +amount  + '&discount=' + discount + '&taxAmt=' + taxAmt + '&totalInvAmount=' + totalInvAmount, true);
		xmlHttpNewInvoice.send(null); 	
	}
}
function HandleNewInvoice()
{
	if(xmlHttpNewInvoice.readyState == 4) 
    {
	   if(xmlHttpNewInvoice.status == 200) 
        {  
			var XMLNewInv = xmlHttpNewInvoice.responseXML.getElementsByTagName("Result");
			if(XMLNewInv.length==0)
			{
				alert("Save Process Failed.");
				return;
			}
			if (XMLNewInv[0].childNodes[0].nodeValue == "True")
			{
				//GL Allowcation Save Position==============================================
				var row=document.getElementById("tblGLAccs").getElementsByTagName("TR")
				for(var loop=1;loop<row.length;loop++)
				{
					var invoiceNo=document.getElementById("txtInvNo").value
					var cell=row[loop].getElementsByTagName("TD")
					var glAccNo=cell[1].innerHTML;
					var amount=parseFloat(cell[3].firstChild.value);
					var payeeID=document.getElementById("cboPayee").value
					
					if(amount>0)
					{
						CreateXMLHttpNewInvoiceGLAllow();
						xmlHttpNewInvoiceGLAllow.onreadystatechange = HandleNewInvoiceGLAllow;						          				xmlHttpNewInvoiceGLAllow.open("GET",'withoutPOInvoiceDB.php?DBOprType=saveWithoutPOInvoiceGLAllowcation&invoiceNo=' + invoiceNo + '&glAccNo=' + glAccNo + '&amount=' + amount + '&payeeID=' + payeeID, true);
						xmlHttpNewInvoiceGLAllow.send(null); 						
					}
				}
				
				//Tax Breakdown Save Position==============================================
				var taxrow=document.getElementById("tbltaxdetails").getElementsByTagName("TR")
				for(var loop=1;loop<taxrow.length;loop++)
				{
					var tatcell=taxrow[loop].getElementsByTagName("TD")
					
					if(tatcell[0].firstChild.checked==true)
					{
						var taxID=tatcell[2].innerHTML;
						var amount=parseFloat(tatcell[4].innerHTML);
					
						CreateXMLHttpNewInvoiceTax();
						xmlHttpNewInvoiceTax.onreadystatechange = HandleNewInvoiceTax;
						xmlHttpNewInvoiceTax.open("GET",'withoutPOInvoiceDB.php?DBOprType=saveWithoutPOInvoiceTaxes&invoiceNo=' + invoiceNo + '&taxID=' + taxID + '&amount='+ amount, true);
						xmlHttpNewInvoiceTax.send(null); 						
					}
				}
				
				alert("New Without PO Invoice Saved successfully.");
				getNewInvNo(2)
				setForNewInvData()
				return;
			}
			else
			{
				alert("Save Process Failed.");
				rollBacktrans();
				return;
			}
			
		}
	}
	
}

function rollBacktrans()
{
	CreateXMLHttpWPInvoice();
	xmlHttpWPInvoice.onreadystatechange = HandlerollBacktrans;
	xmlHttpWPInvoice.open("GET",'withoutPOInvoiceDB.php?DBOprType=rollBackTrance&invoiceNo=' + invoiceNo , true);
	xmlHttpWPInvoice.send(null); 
}
function HandlerollBacktrans()
{
	if(xmlHttpWPInvoice.readyState == 4) 
    {
	   if(xmlHttpWPInvoice.status == 200) 
        {  
			var XMLRBT = xmlHttpWPInvoice.responseXML.getElementsByTagName("Result");
			if(XMLRBT.length==0)
			{
				alert("Process Error");
				return;
			}
			if(XMLRBT==true)
			{
				alert("There is an error.Save process roll backed successfully.");
				return;
			}
		}
	}
}


function HandleNewInvoiceGLAllow()
{
	if(xmlHttpNewInvoiceGLAllow.readyState == 4) 
    {
	   if(xmlHttpNewInvoiceGLAllow.status == 200) 
        {  
			var XMLNewInvGL = xmlHttpNewInvoiceGLAllow.responseXML.getElementsByTagName("Result");
			if(XMLNewInvGL.length==0)
			{
				alert("GL Allowcation Save Process Failed.");
				rollBacktrans();
				return;
			}
		}
	}
	
}

function HandleNewInvoiceTax()
{
	if(xmlHttpNewInvoiceTax.readyState == 4) 
    {
	   if(xmlHttpNewInvoiceTax.status == 200) 
        {  
			var XMLNewInvTax = xmlHttpNewInvoiceTax.responseXML.getElementsByTagName("Result");
			if(XMLNewInvTax.length==0)
			{
				alert("Type of Taxes Save Process Failed.");
				rollBacktrans();
				return;
			}
		}
	}	
}

function setForNewInvData()
{
document.getElementById("txtInvNo").value=""
document.getElementById("cboPayee").value=0
document.getElementById("cbocompany").value=0
var d=new Date()
var xmon = d.getMonth()
var mon=parseInt(xmon)+1
mon=mon+''
if(mon.length==1){ mon='0'+mon}

document.getElementById("txtDate").value=d.getFullYear() + "/" + mon + "/" + d.getDate()
document.getElementById("txtDescription").value=""
document.getElementById("cbobatch").value=0
document.getElementById("txtEntryNo").value=""
document.getElementById("txtVATNo").value=""
document.getElementById("txtAccpacID").value=""
document.getElementById("cboCurrency").value=0
document.getElementById("txtRate").value="0.00"
document.getElementById("txtAmount").value="0.00"
document.getElementById("txtDiscount").value="0.00"
document.getElementById("txtTaxAmt").value="0.00"
document.getElementById("txtTotalAmount").value="0.00"

var glaccs="<table width=\"400\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccs\" name=\"tblGLAccs\" >"+
			"<tr>"+
			"<td width=\"39\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
			"<td width=\"102\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GL Acc ID</td>"+
			"<td width=\"269\" height=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
			"</tr>"+
			"<tr></tr>"+
			"</table>"
document.getElementById("divGLAccsList").innerHTML=glaccs

var glaccs="<table width=\"380\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"normaltxtmidb2\" id=\"tbltaxdetails\">"+
			"<tr>"+
			"<td bgcolor=\"#498CC2\" height=\"18\" width=\"10\">*</td>"+
			"<td bgcolor=\"#498CC2\" width=\"131\">Tax</td>"+
			"<td bgcolor=\"#498CC2\" width=\"58\" >Tax ID</td>"+
			"<td bgcolor=\"#498CC2\" width=\"70\">Rate</td>"+
			"<td bgcolor=\"#498CC2\" width=\"119\">Value</td>"+
			"</tr>"+
			"<tr></tr>"+
			"</table>"
document.getElementById("divTaxType").innerHTML=glaccs


getNewInvNo(1)
loadTaxTypes()

}




function showGLAccounts(booGLOk)
{
	var strGLAccounts="<table width=\"100%\" height=\"150\" border=\"0\" class=\"TitleN2white\"  bgcolor=\"#FFFFE1\" >"+
            "<tr>"+
              "<td height=\"25\" bgcolor=\"#498CC2\" class=\"TitleN2white\">GL Accounts</td>"+
            "</tr>"+
            "<tr class=\"tablezRED\">"+
              "<td height=\"17\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                  "<tr>"+
                    "<td width=\"1%\" height=\"25\">&nbsp;</td>"+
                    "<td width=\"8%\" class=\"normalfnt\">Factory</td>"+
                    "<td width=\"50%\"><label>"+
                      "<select name=\"cboFactory\"  class=\"normalfnt\" id=\"cboFactory\" style=\"width:250px\">"+
                      "</select>"+
                    "</label></td>"+
                    "<td width=\"1%\">&nbsp;</td>"+
                    "<td width=\"6%\"  class=\"normalfnt\">Acc.Like</td>"+
                    "<td width=\"8%\"> <input type=\"text\"  class=\"txtbox\"  name=\"txtNameLike\" id=\"txtNameLike\" size=\"25\" /></td>"+
                    "<td width=\"8%\"><img src=\"../images/search.png\" onclick=\"getGLAccounts()\" alt=\"find\" width=\"86\" height=\"24\" /></td>"+
                  "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"150\"><table width=\"100%\" height=\"130\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                  "<tr class=\"bcgl1\">"+
                    "<td width=\"100%\" height=\"185\"><table width=\"93%\" height=\"185\" border=\"0\" class=\"bcgl1\">"+
                        "<tr>"+
                          "<td colspan=\"3\"><div id=\"divGLAccs\" style=\"overflow:scroll; height:254px; width:630px;\">"+
                              "<table bgcolor=\"#FFFFE1\" width=\"460\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccounts\">"+
                                "<tr>"+
                                  "<td width=\"39\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
                                  "<td width=\"102\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GL Acc ID</td>"+
                                  "<td width=\"269\" height=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
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
                  "<td width=\"20%\"><img src=\"../images/close.png\" onclick=\"showGLAccounts(false)\" width=\"97\" height=\"24\" /></td>"+
                  "<td width=\"28%\">&nbsp;</td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>"
	try
	{
		if(booGLOk==false)
		{
			
			document.getElementById('txtNameLike').value=""
			document.getElementById('cboFactory').value=0
			var strGLAccs="<table bgcolor=\"#FFFFE1\" width=\"460\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccounts\">"+
							"<tr>"+
							  "<td width=\"39\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
							  "<td width=\"102\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GL Acc ID</td>"+
							  "<td width=\"269\" height=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
							  "</tr>"+
						  "</table>"
							  
			document.getElementById('divGLAccs').innerHTML=strGLAccs;	
			document.getElementById('popupGLAccounts').style.visibility = 'hidden';
			LoadFactoryList();
			return;
		}
		else
		{	var popupbox = document.createElement("div");
			popupbox.id = "popupGLAccounts";
			popupbox.style.position = 'absolute';
			popupbox.style.zIndex = 1;
			popupbox.style.left = 338 + 'px';
			popupbox.style.top = 80 + 'px';  
			popupbox.innerHTML = strGLAccounts;  
			document.body.appendChild(popupbox);
			document.getElementById('popupGLAccounts').style.visibility = 'visible';
			LoadFactoryList();
			return;
		}
	}
	catch(err)
	{}
		
	/*	document.getElementById('popupGLAccounts').style.visibility = 'visible';	
		LoadFactoryList();*/	
			

	
		
		
	
	
}
function LoadFactoryList()
{
	CreateXMLHttpForFactories();
	xmlHttpFactory.onreadystatechange = HandleFactories;
    xmlHttpFactory.open("GET", 'withoutPOInvoiceDB.php?DBOprType=getFactoryList', true);
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

function getGLAccounts()
{
	var facCode=document.getElementById("cboFactory").value;
	var nameLike=document.getElementById("txtNameLike").value;	
	
	CreateXMLHttpForGLAccs();
	xmlHttpGLAccs.onreadystatechange = HandleGLAccs;
    xmlHttpGLAccs.open("GET", 'withoutPOInvoiceDB.php?DBOprType=getGLAccountList&facID=' + facCode + '&NameLike=' + nameLike , true);
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
			
			
			var strGLAccs="<table width=\"400\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccounts\" name=\"tblGLAccounts\" >"+
							"<tr>"+
							"<td width=\"39\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
							"<td width=\"102\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GL Acc ID</td>"+
							"<td width=\"269\" height=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
							"</tr>"
				  
			for ( var loop = 0; loop < XMLaccNo.length; loop ++)
			 {
				var accNo = XMLaccNo[loop].childNodes[0].nodeValue;
				var accDes = XMLaccName[loop].childNodes[0].nodeValue;
				strGLAccs+="<tr>"+
				  			"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\"><div align=\"center\">"+
							"<input type=\"checkbox\" name=\"chkSelGLAcc\" onmouseover=\"highlight(this.parentNode)\" id=\"chkSelGLAcc\" />"+
				  			"</div></td>"+
				  			"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\">" + accNo + "</td>"+
				  			"<td class=\"normalfnt\"onmouseover=\"highlight(this.parentNode)\">" + accDes + "</td>"+
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
	
	glrows=document.getElementById('tblGLAccounts').getElementsByTagName("TR");
	rows=document.getElementById('tblGLAccs').getElementsByTagName("TR");
	
	var strSelGLs="<table width=\"380\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblGLAccs\">"+
					"<tr>"+
					"<td width=\"2\" height=\"18\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"></td>"+
					"<td width=\"80\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">GL Acc Id</td>"+
					"<td width=\"120\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
					"<td width=\"60\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Amount</td>"+
					"</tr>"
	for(var loop=1;loop<glrows.length;loop++)
	{
		glcells=glrows[loop].getElementsByTagName("TD");
		
			var accNo=(glcells[1].firstChild.nodeValue)
			var accName=(glcells[2].firstChild.nodeValue)
			
			if(glcells[0].firstChild.firstChild.checked == true)
			{
				strSelGLs+="<tr>"+
							"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\"></td>"+
							"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\">" + accNo + "</td>"+
							"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\">" + accName + " </td>"+
							"<td class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\"><input type=\"text\"  style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\" onfocus=\"setSelect(this)\" class=\"txtbox\"  name=\"txtGLAmount\" id=\"txtGLAmount\" value=\"0.00\" /></td>"+
						  "</tr>"
			
						
			}
	}
	strSelGLs+="</table>"
	document.getElementById("divGLAccsList").innerHTML=strSelGLs;
	
}



function calculateAmounts()
{
	var payAmt=document.getElementById('txtAmount').value;
	var taxAmt=0;
	var theRows=document.getElementById('tbltaxdetails').getElementsByTagName("TR");
	for(var loop=1;loop<theRows.length;loop++)
	{
		cells=theRows[loop].getElementsByTagName("TD");
		if(cells[0].firstChild.checked == true)
		{
			var rate=cells[3].innerHTML;
			cells[4].innerHTML=payAmt*rate/100;
			
			taxAmt=taxAmt+parseFloat(cells[4].innerHTML) ;
		}
	}
	document.getElementById("txtTaxAmt").value=taxAmt;
	document.getElementById("txtTotalAmount").value=(parseFloat(document.getElementById("txtAmount").value)+parseFloat(taxAmt))-parseFloat(document.getElementById("txtDiscount").value)
	
}

function checkValidation()
{
	var payAmt=0
	invoiceNo=""
	
if(document.getElementById("cboPayee").value==0)
{
	alert("Select a Payee to arrange an invoice");
	document.getElementById("cboPayee").focus();
	return false;	
}

if(document.getElementById("txtInvNo").value=="")
{
	alert("Please Enter Invoice No");
	document.getElementById("txtInvNo").focus();
	return false;		
}
else
{
	/*checkWithutPOInvNo();
	if(document.getElementById("txtInvNo").value=="")
	{
		alert("Please Enter Invoice No");
		invoiceNo=""
		document.getElementById("txtInvNo").value="";
		document.getElementById("txtInvNo").focus();
		return false;		
	}*/
	
}


if(document.getElementById("cbocompany").value==0)
{
	alert("Can not be blank the Company of Payment");
	document.getElementById("cbocompany").focus();
	return false;	
}
if(document.getElementById("txtDescription").value=="")
{
	alert("Can not be blank the Description of Payment");
	document.getElementById("txtDescription").focus();
	return false;	
}
if(document.getElementById("cbobatch").value==0)
{
	alert("Can not be blank the Accpac Batch No");
	document.getElementById("cbobatch").focus();
	return false;	
}
/*if(document.getElementById("txtVATNo").value=="")
{
	alert("Can not be blank the VAT No");
	document.getElementById("txtVATNo").focus();
	return false;	
}
if(document.getElementById("txtAccpacID").value=="")
{
	alert("Can not be blank the Accpac ID");
	document.getElementById("txtAccpacID").focus();
	return false;	
}*/
if(document.getElementById("cboCurrency").value==0)
{
	alert("Can not be blank the Type of Currency");
	document.getElementById("cboCurrency").focus();
	return false;
}

if(document.getElementById("txtAmount").value==0)
{
	alert("Can not be blank the Amount of Payment");
	document.getElementById("txtAmount").focus();
	return false;	
}
else
{
	payAmt=parseFloat(document.getElementById("txtAmount").value);
}

var theRow=document.getElementById("tblGLAccs").getElementsByTagName("TR");
var glAmt=0;
if(theRow.length==1)
{
	alert("Plase select the Accpac GL Account/s of Payment");
	showGLAccounts();
	return false;	
}
else
{
	for(var loop=1;loop<theRow.length;loop++)
	{
		var cell=theRow[loop].getElementsByTagName("TD");
		glAmt=glAmt+parseFloat(cell[3].firstChild.value);
	}

	if(payAmt!=glAmt)
	{
		alert("Ther is a different(" & parseFloat(payAmt)-parseFloat(glAmt) & ") between Pay Amount(" & payAmt & ") and Total Amount GL Account" & glAmt );
		document.getElementById("tblGLAccs").focus();
		return false;	
	}

}

checkWithutPOInvNo();
if(invNoAvailable==true)
{
	document.getElementById("txtInvNo").select();
	alert("This Invoice No has already entered under selected Payee");
	//invNoAvailable=false
	return false;	
	return;
}

	return true;
}






function setSelect(obj)
{
	obj.select();
}

function rateShow()
{
	document.getElementById("txtRate").value=document.getElementById("cboCurrency").value		
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
	
	var ddate=(day + "/" + month + "/" + year);
	document.getElementById("txtDateFrom").value=ddate
	document.getElementById("txtDateTo").value=ddate
}


function loadTaxTypes()
{
	CreateXMLHttpForTaxTypes();
	xmlHttpTax.onreadystatechange = HandleTaxTypes;
    xmlHttpTax.open("GET", 'withoutPOInvoiceDB.php?DBOprType=getTaxTypes', true);
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
			
			var strTaxTbl="<table width=\"380\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"normaltxtmidb2\" id=\"tbltaxdetails\">"+
						  "<tr>"+
							"<td bgcolor=\"#498CC2\" height=\"18\" width=\"10\">*</td>"+
							"<td bgcolor=\"#498CC2\" width=\"131\">Tax</td>"+
							"<td bgcolor=\"#498CC2\" width=\"58\" >Tax ID</td>"+
							"<td bgcolor=\"#498CC2\" width=\"70\">Rate</td>"+
							"<td bgcolor=\"#498CC2\" width=\"119\">Value</td>"+

						  "</tr>"
									
			
									
			for ( var loop = 0; loop < XMLTaxID.length; loop++)
			 {
				var taxID = XMLTaxID[loop].childNodes[0].nodeValue;
				var taxType = XMLTaxType[loop].childNodes[0].nodeValue;
				var taxRate = XMLTaxRate[loop].childNodes[0].nodeValue;
				
				
				strTaxTbl+="<tr>"+
								"<td width=\"20\"><input type=\"checkbox\" onclick=\"calculateAmounts()\" onmouseover=\"highlight(this.parentNode)\" name=\"chkSelTax\" id=\"chkSelTax\" /></td>"+
								"<td width=\"70\" onmouseover=\"highlight(this.parentNode)\"  class=\"normalfnt\">" + taxType + "</td>"+
								"<td width=\"10\" onmouseover=\"highlight(this.parentNode)\" class=\"normalfnt\">" + taxID + "</td>"+
								"<td width=\"40\" onmouseover=\"highlight(this.parentNode)\" class=\"normalfntRite\">" + taxRate + "</td>"+
								"<td width=\"80\" onmouseover=\"highlight(this.parentNode)\"class=\"normalfntRite\"> 0.00 </td>"
								
							"</tr>"
				
			 }
			 
			 strTaxTbl+="</table>"
			 document.getElementById("divTaxType").innerHTML=strTaxTbl;
		}
	}
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

//==============================================

