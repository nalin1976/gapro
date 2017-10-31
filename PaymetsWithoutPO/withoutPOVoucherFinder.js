function CreateXMLHttpFindPVoucher() 
{
	if (window.ActiveXObject) 
    {
        xmlHttpPV = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpPV = new XMLHttpRequest();
    }	
}




function fillAvailablePaymentData()
{
	var payeeID=document.getElementById("cboPayees").value;
	var dateFrom=document.getElementById("txtDateFrom").value;
	var dateTo=document.getElementById("txtDateTo").value;
	
	CreateXMLHttpFindPVoucher() 
	xmlHttpPV.onreadystatechange = HandlePaymentVouchers;
    xmlHttpPV.open("GET", 'withoutPOVoucherDB.php?DBOprType=getPaymentVoucherList&payeeID=' + payeeID + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo , true);
	xmlHttpPV.send(null); 
}

function HandlePaymentVouchers()
{
	if(xmlHttpPV.readyState == 4) 
	{
	   if(xmlHttpPV.status == 200) 
		{
			var XMLVoucherNo = xmlHttpPV.responseXML.getElementsByTagName("VoucherNo");
			var XMLPayee = xmlHttpPV.responseXML.getElementsByTagName("Payee");
			var XMLPayeeid = xmlHttpPV.responseXML.getElementsByTagName("Payeeid");
			var XMLDescription = xmlHttpPV.responseXML.getElementsByTagName("Description");
			var XMLDate = xmlHttpPV.responseXML.getElementsByTagName("Date");
			var XMLAmount = xmlHttpPV.responseXML.getElementsByTagName("Amount");
			
			var strPVoucher="<table id=\"tblPVData\" width=\"900\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >"+
							"<tr>"+
							"<td width=\"1%\" height=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
							"<td width=\"9%\" height=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Voucher No</td>"+
							"<td width=\"26%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Payee</td>"+
							"<td width=\"26%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
							"<td width=\"10%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
							"<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Amount</td>"+
							"<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Voucher</td>"+
							"<td width=\"8%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Schedule</td>"+
							"</tr>"

			if(XMLVoucherNo.length==0)
			{
				alert("There is no any voucher to display according to you's options")
				strPVoucher+="</table>"
				document.getElementById("divPayVoucherData").innerHTML=strPVoucher
				return
			}
			
			
			for ( var loop = 0; loop < XMLVoucherNo.length; loop ++)
			 {
				var voucherno = XMLVoucherNo[loop].childNodes[0].nodeValue;
				var payee= XMLPayee[loop].childNodes[0].nodeValue;
				var payeeid= XMLPayeeid[loop].childNodes[0].nodeValue;
				var	description=XMLDescription[loop].childNodes[0].nodeValue;
				var	date=XMLDate[loop].childNodes[0].nodeValue;
				var	amount=XMLAmount[loop].childNodes[0].nodeValue;
					amount=Math.round(amount*100)/100;
				
				
					strPVoucher+="<tr>"+
								"<td height=\"20\" class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" ></td>"+
								"<td height=\"20\" class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" >" + voucherno + "</td>"+
								"<td height=\"20\" class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" >" + payee + "</td>"+
								"<td height=\"20\" class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" >" + description + "</td>"+
								"<td height=\"20\" class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" >" + date + "</td>"+
								"<td height=\"20\" class=\"normalfnt\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\" >" + amount + "</td>"+
								"<td height=\"20\" class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" ><div align=\"center\"><img src=\"../images/butt_1.png\" id=\"" + payeeid + "\"  width=\"15\" height=\"15\" onclick=\"printVoucher(this)\" /></div></td>"+
								"<td height=\"20\" class=\"normalfnt\" onmouseover=\"highlight(this.parentNode)\" ><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" id=\"" + payeeid + "\" height=\"15\" onclick=\"printSchedule(this)\" /></div></td>"+
								"</tr>"
				
				
				
			}
			strPVoucher+="</table>"
			document.getElementById("divPayVoucherData").innerHTML=strPVoucher
			
		}
	}
}

function printVoucher(obj)
{
	var row=obj.parentNode.parentNode.parentNode
	//var row=document.getElementById("tblPVData").getElementsByTagName("TR");
	var cell=row.getElementsByTagName("TD");
	var voucherNo=cell[1].innerHTML;
	
	
	window.open('rptWPOChequePaymentVoucher.php?PayVoucherNo=' + voucherNo )
	
	
}

function printSchedule(obj)
{
	var row=obj.parentNode.parentNode.parentNode
	//var row=document.getElementById("tblPVData").getElementsByTagName("TR");
	var cell=row.getElementsByTagName("TD");
	var voucherNo=cell[1].innerHTML;
	var payeeid=obj.id
		
	
	window.open('rptWPOPaymentSchedule.php?PayVoucherNo=' + voucherNo + '&payeeid=' + payeeid )
	
	
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

