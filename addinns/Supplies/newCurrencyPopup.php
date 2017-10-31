<?php
 session_start();
 include "../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<link rel="stylesheet" type="text/css" href="../../css/erpstyle.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script type="text/jscript">
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
	alert(id);
  var el = document.getElementById(id);
 // alert(el);
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
</script>
</head>

<body>
<table width="600" height="198" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="cursercross" onmousedown="grab(document.getElementById('frmNewCurrency'),event);">
		<td height="25" bgcolor="#498CC2" class="TitleN2white" align="center">Add New Currency</td>
	</tr>
	<tr>
		<td align="center">
			<table width="100%">
                    <tr>
                      <td height="30" class="normalfntMid">Currency</td>
                      <td width="20%" class="normalfntMid"><input name="txtCurrency" type="text" class="txtbox" id="txtCurrency" /></td>
                      <td width="30%" class="normalfntMid">Title</td>
                      <td width="20%" align="left"><input name="txtTitle" type="text" class="txtbox" id="txtTitle" /></td>
                    </tr>
                    <tr>
                      <td height="26" class="normalfntMid">Rate</td>
                      <td class="normalfntMid"><input name="txtRate" type="text" class="txtbox" id="txtRate" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                      <td class="normalfntMid">Fractional Unit</td>
                      <td class="normalfntMid"><span class="normalfntp2">
                        <input name="txtFraction" type="text" class="txtbox" id="txtFraction" />
                      </span></td>
                    </tr>
                    <tr>
                      <td height="26" class="normalfntMid">Active</td>
                      <td class="normalfntMid"><input type="checkbox" name="chkActive" id="chkActive" checked="checked" /></td>
                      <td class="normalfntMid">Exchange Rate</td>
                      <td class="normalfntMid"><input name="txtExRate" type="text" class="txtbox" id="txtExRate" /></td>
                    </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="20" >
			<table align="center" >
				<tr>
					<td><span class="normalfntp2"><img src="../../images/new.png" class="mouseover" alt="report" width="96" height="24" onclick="cleatrFields();" /></span></td>
					<td><span class="normalfntp2"><img src="../../images/save.png" class="mouseover" alt="report" width="84" height="24" onclick="saveData()" /></span></td>
					<td><span class="normalfntp2"><img src="../../images/delete.png" class="mouseover" alt="report" width="100" height="24" onclick="#" /></span></td>
					<td><span class="normalfntp2"><img src="../../images/close.png" class="mouseover" alt="close" width="97" height="24" border="0" onclick="closeWindow2('')" /></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<p class="grid-1">&nbsp;</p>
</body>
</html>
 