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
	  
function AppDateDisable(obj)
{
var day= new Date();
var d=day.getDate();
var m=day.getMonth()+1;
var y=day.getFullYear();
	if(obj.checked){
		document.getElementById('AppDateFrom').disabled=false;
		document.getElementById('AppDateTo').disabled=false;
		document.getElementById('AppDateFrom').value=d+"/"+m+"/"+y;
		document.getElementById('AppDateTo').value=d+"/"+m+"/"+y;
	}
	else{
		document.getElementById('AppDateFrom').disabled=true;
		document.getElementById('AppDateTo').disabled=true;
		document.getElementById('AppDateFrom').value="";
		document.getElementById('AppDateTo').value="";
	}
}

function userDisable(obj)
{
	if(obj.checked){
		document.getElementById('cboUser').disabled=false;
	}
	else{
		document.getElementById('cboUser').disabled=true;
		document.getElementById('cboUser').value="";
	}
}

function tableDisable(obj)
{
	if(obj.checked){
		document.getElementById('cboTable').disabled=false;
	}
	else{
		document.getElementById('cboTable').disabled=true;
		document.getElementById('cboTable').value="";
	}
}


function programDisable(obj)
{
	if(obj.checked){
		document.getElementById('cboProgram').disabled=false;
	}
	else{
		document.getElementById('cboProgram').disabled=true;
		document.getElementById('cboProgram').value="";
	}
}


function operationDisable(obj)
{
	if(obj.checked){
		document.getElementById('cboOperation').disabled=false;
	}
	else{
		document.getElementById('cboOperation').disabled=true;
		document.getElementById('cboOperation').value="";
	}
}


function qryDisable(obj)
{
	if(obj.checked){
		document.getElementById('txtQry').disabled=false;
	}
	else{
		document.getElementById('txtQry').disabled=true;
		document.getElementById('txtQry').value="";
	}
}


function IPDisable(obj)
{
	if(obj.checked){
		document.getElementById('txtIP').disabled=false;
	}
	else{
		document.getElementById('txtIP').disabled=true;
		document.getElementById('txtIP').value="";
	}
}

function SubmitForm()
{
	if(document.frmAuditTrial.chkAppDate.checked == true){
	 var dateFrom    = document.getElementById("AppDateFrom").value;
	 var dateTo    = document.getElementById("AppDateTo").value;
	}else{
	 var dateFrom    = "";
	 var dateTo    = "";
	}
	
	if(document.frmAuditTrial.chkUser.checked == true){
	 var user    = document.getElementById("cboUser").value;
	}else{
	 var user    = "";
	}
	
	if(document.frmAuditTrial.chkTable.checked == true){
	 var table    = document.getElementById("cboTable").value;
	}else{
	 var table    = "";
	}
	if(document.frmAuditTrial.chkProgram.checked == true){
	 var program    = document.getElementById("cboProgram").value;
	}else{
	 var program    = "";
	}
	if(document.frmAuditTrial.chkOperat.checked == true){
	 var operation    = document.getElementById("cboOperation").value;
	}else{
	 var operation    = "";
	}
	if(document.frmAuditTrial.chkQry.checked == true){
	 var querry    = document.getElementById("txtQry").value;
	}else{
	 var querry    = "";
	}
	if(document.frmAuditTrial.chkIP.checked == true){
	 var ip    = document.getElementById("txtIP").value;
	}else{
	 var ip    = "";
	}

	
	 if(dateFrom > dateTo ){
	  alert("Invalid date range");
	  document.frmAuditTrial.AppDateFrom.focus();
	  return false;
	 }
	 
//alert("auditTrialRpt.php?dateFrom=" + dateFrom+"&dateTo=" +dateTo+"&user=" +user+"&table=" +table+"&program=" +program+"&operation=" +operation+"&querry=" +querry+"&ip=" +ip);	
window.open("auditTrialRpt.php?dateFrom=" + dateFrom+"&dateTo=" +dateTo+"&user=" +user+"&table=" +table+"&program=" +program+"&operation=" +operation+"&querry=" +querry+"&ip=" +ip);
	 
	//document.getElementById('frmordershed').submit();
	return true;
}
