
function CreateXMLHttpForPayNo()
{
	if (window.ActiveXObject) 
    {
        xmlHttpPayNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpPayNo = new XMLHttpRequest();
    }	
}

function CreateXMLHttpSave()
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

function CreateXMLHttpSaveDetails()
{
	if (window.ActiveXObject) 
    {
        xmlHttpSaveDt = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSaveDt = new XMLHttpRequest();
    }		
}
function CreateXMLHttpForInvData()
{
	if (window.ActiveXObject) 
    {
        xmlHttpInvData = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpInvData = new XMLHttpRequest();
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
	getWithutPOSchedNo(1)
}

function  SaveInvoiceSchedule()
{
	if(document.getElementById("cboPayee").value==0)
	{
		alert("Can not be blank the Name of Payee")
		document.getElementById("cboPayee").focus();
		return
	}
	
	if(document.getElementById("txAmount").value==0)
	{
		alert("Schedule Amoount Can not be zero(0).Please select invoice/s to get arranged a schedule")
		document.getElementById("tblInvoices").focus();
		return
	}
	
	var scheduleNo=document.getElementById("txtScheduleNo").value
	var payeeID=document.getElementById("cboPayee").value
	var datex=document.getElementById("txtDate").value
	var amount=document.getElementById("txAmount").value
	var tottax=document.getElementById("txtTaxAmt").value
	var totdiscount=document.getElementById("txtDiscountAmt").value
	var totamount=document.getElementById("txtTotalAmt").value
	
	CreateXMLHttpSave();
	xmlHttpSave.onreadystatechange = HandleSaveNewSchedule;
	xmlHttpSave.open("GET", 'withoutPOScheduleDB.php?DBOprType=WithouPONewShedule&scheduleNo=' + scheduleNo + '&payeeID=' + payeeID + '&datex=' + datex + '&amount=' + amount + '&tottax=' + tottax + '&totdiscunt=' + totdiscount + '&totamount=' + totamount , true);
	
	xmlHttpSave.send(null); 
	
	
	
}

function HandleSaveNewSchedule()
{
	if(xmlHttpSave.readyState == 4) 
    {
	   if(xmlHttpSave.status == 200) 
        {  
			var XMLNewSchedule = xmlHttpSave.responseXML.getElementsByTagName("Result");
			if(XMLNewSchedule[0].childNodes[0].nodeValue == "True")
			{
				var scheduleNo=document.getElementById("txtScheduleNo").value
				var row=document.getElementById("tblInvoices").getElementsByTagName("TR")
				for(var loop=1;loop<row.length;loop++)
				{
					var cell=row[loop].getElementsByTagName("TD")
					if(cell[1].firstChild.checked==true)
					{
						var invNo=cell[2].innerHTML
					
						CreateXMLHttpSaveDetails();
						xmlHttpSaveDt.onreadystatechange = HandleSaveNewScheduleInvs;
						xmlHttpSaveDt.open("GET", 'withoutPOScheduleDB.php?DBOprType=WithouPONewSheduleInvs&scheduleNo=' + scheduleNo + '&invID=' + invNo , true);
						
						xmlHttpSaveDt.send(null);
					}
				}
				
				alert("New invoice schedule saved successfully")
				getWithutPOSchedNo(2)
				clearAll()
				
				return
			}
		}
	}
}

function HandleSaveNewScheduleInvs()
{
	if(xmlHttpSaveDt.readyState == 4) 
    {
	   if(xmlHttpSaveDt.status == 200) 
        {  
			var XMLNewSchdDt = xmlHttpSaveDt.responseXML.getElementsByTagName("WithouPOSchedNo");
	
		}
	}
}



function clearAll()
{
	document.getElementById("txAmount").value="0.00"
	document.getElementById("txtTaxAmt").value="0.00"
	document.getElementById("txtDiscountAmt").value="0.00"
	document.getElementById("txtTotalAmt").value="0.00"
	document.getElementById("cboPayee").value=0
	
	var strInv="<table width=\"955\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblInvoices\">"+
				"<tr>"+
				"<td width=\"1\" height=\"23\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"></td>"+
				"<td width=\"26\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
				"<td width=\"87\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Invoice No </td>"+
				"<td width=\"184\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
				"<td width=\"104\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
				"<td width=\"131\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Amount</td>"+
				"<td width=\"131\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Tax</td>"+
				"<td width=\"131\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Discount</td>"+
				"<td width=\"125\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Total Amount </td>"+
				"</tr></table>"
				
	document.getElementById("divInvs").innerHTML=strInv
	getWithutPOSchedNo(1)
}





function getWithutPOSchedNo(task)
{
	CreateXMLHttpForPayNo();
	xmlHttpPayNo.onreadystatechange = HandleWithouPOPayNoTask;
	xmlHttpPayNo.open("GET", 'withoutPOScheduleDB.php?DBOprType=WithouPOPayNoTask&task=' + task, true);
	xmlHttpPayNo.send(null); 
}

function HandleWithouPOPayNoTask()
{
	if(xmlHttpPayNo.readyState == 4) 
    {
	   if(xmlHttpPayNo.status == 200) 
        {  
			var XMLWithouPOPayNo = xmlHttpPayNo.responseXML.getElementsByTagName("WithouPOSchedNo");
	
			if(XMLWithouPOPayNo.length>0)
			{
				var No = XMLWithouPOPayNo[0].childNodes[0].nodeValue;
			}
			else
			{
				var No ='100'
			}
			document.getElementById("txtScheduleNo").value=No;
		}
	}
}


function GetSupplierWPOInvoiceDetails()
{
	var payeeID=document.getElementById("cboPayee").value	
	document.getElementById("txAmount").value="0.00"
	document.getElementById("txtTaxAmt").value="0.00"
	document.getElementById("txtDiscountAmt").value="0.00"
	document.getElementById("txtTotalAmt").value="0.00"
	CreateXMLHttpForInvData();
	xmlHttpInvData.onreadystatechange = HandleInvoiceDetails;
	xmlHttpInvData.open("GET",'withoutPOScheduleDB.php?DBOprType=getPayeeInvoices&payeeID=' + payeeID , true);
	xmlHttpInvData.send(null); 
}

function HandleInvoiceDetails()
{
	if(xmlHttpInvData.readyState == 4) 
    {
	   if(xmlHttpInvData.status == 200) 
        {  
			var XMLInvNo = xmlHttpInvData.responseXML.getElementsByTagName("invoiceNo");
			var XMLdiscription = xmlHttpInvData.responseXML.getElementsByTagName("discription");
			var XMLamount = xmlHttpInvData.responseXML.getElementsByTagName("amount");
			var XMLtaxAmt = xmlHttpInvData.responseXML.getElementsByTagName("taxAmt");
			var XMLdiscount = xmlHttpInvData.responseXML.getElementsByTagName("discount");
			var XMLtotalInvAmount = xmlHttpInvData.responseXML.getElementsByTagName("totalInvAmount");
			var XMLinvDate = xmlHttpInvData.responseXML.getElementsByTagName("invDate");
			
			
			
			if(XMLInvNo.length==0)
			{
				alert("There is no any Invoice to get listed");
			}
			
			var strData="<table width=\"955\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblInvoices\">"+
						"<tr>"+
						"<td width=\"1\" height=\"23\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"></td>"+
						"<td width=\"26\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
						"<td width=\"87\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Invoice No </td>"+
						"<td width=\"184\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
						"<td width=\"104\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
						"<td width=\"131\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Amount</td>"+
						"<td width=\"131\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Tax</td>"+
						"<td width=\"131\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Discount</td>"+
						"<td width=\"125\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Total Amount </td>"+
						"</tr>"
			
			for(var loop=0;loop<XMLInvNo.length;loop++)
			{
				var invoiceNo=XMLInvNo[loop].childNodes[0].nodeValue;
				var discription=XMLdiscription[loop].childNodes[0].nodeValue;
				var amount=XMLamount[loop].childNodes[0].nodeValue;
				var taxAmt=XMLtaxAmt[loop].childNodes[0].nodeValue;
				var discount=XMLdiscount[loop].childNodes[0].nodeValue;
				var totalInvAmount=XMLtotalInvAmount[loop].childNodes[0].nodeValue;
				var invDate=XMLinvDate[loop].childNodes[0].nodeValue;
				
				strData+="<tr>"+
						  "<td width=\"1\" height=\"18\" ></td>"+
						  "<td width=\"26\" ><input name=\"chkSelect\" type=\"checkbox\" onmouseover=\"highlight(this.parentNode)\" onclick=\"valueCalculate()\" id=\"chkSelect\" value=\"chkSelect\" /></td>"+
						  "<td width=\"87\" onmouseover=\"highlight(this.parentNode)\">" + invoiceNo + "</td>"+
						  "<td width=\"184\" onmouseover=\"highlight(this.parentNode)\">" + discription + "</td>"+
						  "<td width=\"104\" style=\"text-align:center\" onmouseover=\"highlight(this.parentNode)\">" + invDate + "</td>"+
						  "<td width=\"131\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + amount + "</td>"+
						  "<td width=\"131\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + taxAmt + "</td>"+
						  "<td width=\"131\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + discount + "</td>"+
						  "<td width=\"125\" style=\"text-align:right\" onmouseover=\"highlight(this.parentNode)\">" + totalInvAmount + "</td>"+
						 "</tr>"
				
				
			}

			strData+="</table>"
			document.getElementById("divInvs").innerHTML=strData


		}
	}
}


function valueCalculate()
{
	var amt=0;
	var taxamt=0;
	var discount=0;
	
	var row =document.getElementById("tblInvoices").getElementsByTagName("TR")
	for(var loop=1; loop<row.length;loop++)
	{
		var cell=row[loop].getElementsByTagName("TD");
		if(cell[1].firstChild.checked==true)
		{
			amt=amt+parseFloat(cell[5].innerHTML);
			taxamt=taxamt+parseFloat(cell[6].innerHTML);
			discount=discount+parseFloat(cell[7].innerHTML);
		}	
	}
	document.getElementById("txAmount").value=amt
	document.getElementById("txtTaxAmt").value=taxamt
	document.getElementById("txtDiscountAmt").value=discount
	document.getElementById("txtTotalAmt").value=parseFloat(amt)+parseFloat(taxamt)-parseFloat(discount)
	
	
	
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

