
function CreateXMLHttpForVoucherNo()
{
	if (window.ActiveXObject) 
    {
        xmlHttpVoucherNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpVoucherNo = new XMLHttpRequest();
    }	
}



function CreateXMLHttpForNewVoucher()
{
	if (window.ActiveXObject) 
    {
        xmlHttpNewVoucher = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpNewVoucher = new XMLHttpRequest();
    }	
}

function CreateXMLHttpForSchedules()
{
	if (window.ActiveXObject) 
    {
        xmlHttpSchedNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSchedNo = new XMLHttpRequest();
    }	
	
}

function CreateXMLHttpSchdData()
{
	if (window.ActiveXObject) 
    {
        xmlHttpschdData = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpschdData = new XMLHttpRequest();
    }	
	
}

function CreateXMLHttpForInvs()
{
	if (window.ActiveXObject) 
    {
        xmlHttpInvs = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpInvs = new XMLHttpRequest();
    }	
	
}

function SaveNewVoucher()
{
	if(document.getElementById("cboPayee").value==0)
	{
		alert("Please select the payee of voucher");
		document.getElementById("cboPayee").focus();
		return
	}
	
	if(document.getElementById("txtDescription").value=="")
	{
		alert("Can not be blank the description of voucher");
		document.getElementById("txtDescription").focus();
		return
	}
	
	if(document.getElementById("cbobatch").value==0)
	{
		alert("Can not be blank the Accpac Batch No");
		document.getElementById("cbobatch").focus();
		return
	}
	
	if(document.getElementById("cboScheduleNo").value==0)
	{
		alert("Please select the schedule of voucher");
		document.getElementById("cboScheduleNo").focus();
		return
	}
	
	if(document.getElementById("txtChequeNo").value=="")
	{
		alert("Can not be balnk the Cheque No of voucher");
		document.getElementById("txtChequeNo").focus();
		return
	}
	
	if(document.getElementById("txtAccount").value==0)
	{
		alert("Can not be balnk the Accpac account of voucher");
		document.getElementById("txtAccount").focus();
		return
	}
	
	if(document.getElementById("cboCurrencyFrom").value==0)
	{
		alert("Please select the Currency From");
		document.getElementById("cboCurrencyFrom").focus();
		return
	}	
	
	if(document.getElementById("cboCurrencyTo").value==0)
	{
		alert("Please select the Currency From");
		document.getElementById("cboCurrencyTo").focus();
		return
	}
	
	var voucherNo=document.getElementById("txtPayNo").value
	var datex=document.getElementById("txtDate").value
	var payeeID=document.getElementById("cboPayee").value
	var description=document.getElementById("txtDescription").value
	var batchno=document.getElementById("cbobatch").value
	var scheduleno=document.getElementById("cboScheduleNo").options[document.getElementById("cboScheduleNo").selectedIndex].text
	var chequeno=document.getElementById("txtChequeNo").value
	var accno=document.getElementById("txtAccount").value
	var taxcode=document.getElementById("txtTaxCode").value
	var currFrom=document.getElementById("cboCurrencyFrom").options[document.getElementById("cboCurrencyFrom").selectedIndex].text
	var rateFrom=document.getElementById("cboCurrencyFrom").value	
	var currTo=document.getElementById("cboCurrencyTo").options[document.getElementById("cboCurrencyTo").selectedIndex].text
	var rateTo=document.getElementById("cboCurrencyFrom").value
	var totalAmt=document.getElementById("txtTotalAmt").value
	var txtUserID=document.getElementById("txtUserID").value
	
	CreateXMLHttpForNewVoucher();
	xmlHttpNewVoucher.onreadystatechange = HandleNewVoucher;
	xmlHttpNewVoucher.open("GET", 'withoutPOVoucherDB.php?DBOprType=SaveNewVoucher&voucherNo=' + voucherNo + '&datex=' + datex + '&payeeID=' + payeeID + '&description=' + description + '&batchno=' + batchno + '&scheduleno=' + scheduleno + '&chequeno=' + chequeno + '&accno=' + accno + '&taxcode=' + taxcode  + '&currFrom=' + currFrom + '&rateFrom=' + rateFrom + '&currTo=' + currTo + '&rateTo=' + rateTo + '&totalAmt=' + totalAmt + '&txtUserID=' + txtUserID, true);
	
	xmlHttpNewVoucher.send(null); 
	
	
	
}

function HandleNewVoucher()
{
	if(xmlHttpNewVoucher.readyState == 4) 
    {
	   if(xmlHttpNewVoucher.status == 200) 
        {  
			var XMLResult = xmlHttpNewVoucher.responseXML.getElementsByTagName("Result");
	
			if(XMLResult[0].childNodes[0].nodeValue=="True")
			{
				alert("New Voucher Saved Succesfully")
				getWithutPOVoucherNo(2)
				ClearAll()
				return
			}
			else
			{
				alert("Save Process Failed")	
				return
			}
		}
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
	
	var ddate=(year + "/" + month + "/" + day);
	document.getElementById("txtDate").value=ddate
	getWithutPOVoucherNo(1)
}

function ClearAll()
{
	 document.getElementById("cboPayee").value=0
	 document.getElementById("txtDescription").value=""
	 document.getElementById("cbobatch").value=0
	 document.getElementById("cboScheduleNo").value=0
	 document.getElementById("txtChequeNo").value=""
	 document.getElementById("txtAccount").value=""
	 document.getElementById("txtTaxCode").value="-"
	 document.getElementById("cboCurrencyFrom").value=0	
	 document.getElementById("cboCurrencyTo").value=0
	 document.getElementById("txtTotalAmt").value="0.00"
	 document.getElementById("txtRateTo").value="0.00"
	 document.getElementById("txtRateFrom").value="0.00"
	 
	 var strInvs="<table width=\"950\" cellpadding=\"0\" cellspacing=\"0\"  id=\"tblGLAccs\">"+
				"<tr>"+
				"<td width=\"10\" height=\"24\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
				"<td width=\"97\" height=\"24\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Invoice No</td>"+
				"<td width=\"79\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
				"<td width=\"263\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
				"<td width=\"100\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Amount</td>"+
				"<td width=\"102\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Tax</td>"+
				"<td width=\"101\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Discount</td>"+
				"<td width=\"129\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Total Amount </td>"+
				"<td width=\"67\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Currency</td>"+
				"</tr></table>"
	
	document.getElementById("divInvs").innerHTML=strInvs
	getWithutPOVoucherNo(1)
}

function rateShow(intType)
{
	if(intType==1)
	{
		document.getElementById("txtRateFrom").value=document.getElementById("cboCurrencyFrom").value	
	}
	else if(intType==2)
	{
		document.getElementById("txtRateTo").value=document.getElementById("cboCurrencyTo").value	
	}
}

function getWithutPOVoucherNo(task)
{
	
	CreateXMLHttpForVoucherNo();
	xmlHttpVoucherNo.onreadystatechange = HandleWithouPOPayNoTask;
	xmlHttpVoucherNo.open("GET", 'withoutPOVoucherDB.php?DBOprType=WithouPOVoucherNoTask&task=' + task, true);
	xmlHttpVoucherNo.send(null); 
}

function HandleWithouPOPayNoTask()
{
	if(xmlHttpVoucherNo.readyState == 4) 
    {
	   if(xmlHttpVoucherNo.status == 200) 
        {  
			var XMLWithouPOPayNo = xmlHttpVoucherNo.responseXML.getElementsByTagName("WithouPOVoucherNo");
	
			if(XMLWithouPOPayNo.length>0)
			{
				var No = XMLWithouPOPayNo[0].childNodes[0].nodeValue;
			}
			else
			{
				var No ='100'
			}
			document.getElementById("txtPayNo").value=No;
		}
	}
}

function getInvoiceDetails()
{	var schedulaNo=document.getElementById("cboScheduleNo").options[document.getElementById("cboScheduleNo").selectedIndex].text
	document.getElementById("txtTotalAmt").value=document.getElementById("cboScheduleNo").value
	
	var payeeID=document.getElementById("cboPayee").value
	
	
	CreateXMLHttpSchdData();
	xmlHttpschdData.onreadystatechange = HandleSchedData;
	xmlHttpschdData.open("GET",'withoutPOVoucherDB.php?DBOprType=getInvoiceDetails&schedulaNo=' + schedulaNo + '&payeeID=' + payeeID, true);
	xmlHttpschdData.send(null); 	
}

function HandleSchedData()
{
	if(xmlHttpschdData.readyState == 4) 
    {
	   if(xmlHttpschdData.status == 200) 
        {  
			var XMLinvoiceNo = xmlHttpschdData.responseXML.getElementsByTagName("invoiceNo");
			var XMLdescription = xmlHttpschdData.responseXML.getElementsByTagName("description");
			var XMLdatex = xmlHttpschdData.responseXML.getElementsByTagName("datex");
			var XMLamount = xmlHttpschdData.responseXML.getElementsByTagName("amount");
			var XMLtax = xmlHttpschdData.responseXML.getElementsByTagName("tax");
			var XMLdiscount = xmlHttpschdData.responseXML.getElementsByTagName("discount");
			var XMLtotalAmt = xmlHttpschdData.responseXML.getElementsByTagName("totalAmt");
			var XMLcurrency = xmlHttpschdData.responseXML.getElementsByTagName("currency");
			
			var strInvoiceTable="<table width=\"950\" cellpadding=\"0\" cellspacing=\"0\"  id=\"tblGLAccs\">"+
								"<tr>"+
								"<td width=\"10\" height=\"24\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
								"<td width=\"97\" height=\"24\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Invoice No</td>"+
								"<td width=\"79\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
								"<td width=\"263\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
								"<td width=\"100\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Amount</td>"+
								"<td width=\"102\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Tax</td>"+
								"<td width=\"101\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Discount</td>"+
								"<td width=\"129\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Total Amount</td>"+
								"<td width=\"67\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Currency</td>"+
								"</tr>"
			

			for(var loop=0;XMLinvoiceNo.length>loop;loop++)
			{
				var invoiceNo=XMLinvoiceNo[loop].childNodes[0].nodeValue;
				var description=XMLdescription[loop].childNodes[0].nodeValue;
				var datex=XMLdatex[loop].childNodes[0].nodeValue;
				var amount=XMLamount[loop].childNodes[0].nodeValue;
				var tax=XMLtax[loop].childNodes[0].nodeValue;
				var discount=XMLdiscount[loop].childNodes[0].nodeValue;
				var totalAmt=XMLtotalAmt[loop].childNodes[0].nodeValue;
				var currency=XMLcurrency[loop].childNodes[0].nodeValue;
				

				strInvoiceTable+="<tr>"+
									"<td width=\"10\" onmouseover=\"highlight(this.parentNode)\">&nbsp;</td>"+
									"<td width=\"97\" height=\"17\" onmouseover=\"highlight(this.parentNode)\">" + invoiceNo + "</td>"+
									"<td width=\"79\" onmouseover=\"highlight(this.parentNode)\">" + datex + "</td>"+
									"<td width=\"263\" onmouseover=\"highlight(this.parentNode)\">" + description + "</td>"+
									"<td width=\"100\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + amount + "</td>"+
									"<td width=\"102\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + tax + "</td>"+
									"<td width=\"101\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + discount + "</td>"+
									"<td width=\"129\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + totalAmt + "</td>"+									
									"<td width=\"67\" style=\"text-align:center\" onmouseover=\"highlight(this.parentNode)\">" + currency + "</td>"+									
									"</tr>"
			}
			strInvoiceTable+="</table>"
			document.getElementById("divInvs").innerHTML=strInvoiceTable
			
		}
	}
}






function GetSupplierInvoiceSchedules()
{
	var payeeID=document.getElementById("cboPayee").value
	
	CreateXMLHttpForSchedules();
	xmlHttpSchedNo.onreadystatechange = HandleSchedNos;
	xmlHttpSchedNo.open("GET",'withoutPOVoucherDB.php?DBOprType=getSchedules&payeeID=' + payeeID, true);
	xmlHttpSchedNo.send(null); 	
}


function HandleSchedNos()
{
	if(xmlHttpSchedNo.readyState == 4) 
    {
	   if(xmlHttpSchedNo.status == 200) 
        {  
			var XMLSchdNo = xmlHttpSchedNo.responseXML.getElementsByTagName("schedulesNo");
			var XMLamount = xmlHttpSchedNo.responseXML.getElementsByTagName("amount");
			
			clearSelectControl("cboScheduleNo")
			
			var opt = document.createElement("option");
			opt.text = ""
			opt.value = 0
			document.getElementById("cboScheduleNo").options.add(opt);
			
			if(XMLSchdNo.length==0)
			{
				alert("There is no any schedule of " + document.getElementById("cboPayee").options[document.getElementById("cboPayee").selectedIndex].text )	
			}
			
			for(var loop=0;XMLSchdNo.length>loop;loop++)
			{
				var opt2 = document.createElement("option");
				opt2.text = XMLSchdNo[loop].childNodes[0].nodeValue;
				opt2.value = XMLamount[loop].childNodes[0].nodeValue;
				document.getElementById("cboScheduleNo").options.add(opt2);
			}
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

function setSelect(obj)
{
	obj.select();
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

