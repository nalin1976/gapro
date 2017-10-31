<?php
$backwardseperator = "../../";
session_start();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document List</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
	font-family: Tahoma;
}
-->
</style>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="summary.js"></script>
<!--calender-->
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script type="text/javascript" src="../../javascript/calendar/calendar.js" ></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js" ></script>

 <link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
 
 <script type="text/javascript">


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

</script>
</head>

<body onload="">
<?php
	include "../../Connector.php";	
?>
<form id="frmSummary" name="frmSummary" method="post">
<table width="950" border="0" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
<tr>
	<td><?php include '../../Header.php'; ?></td>
</tr>
<tr>
  <td><table width="500" border="0" cellspacing="0" cellpadding="2" align="center" class="bcgl1">
    <tr>
      <td height="30" colspan="4" align="center" bgcolor="#498CC2" class="TitleN2white" >Invoice Listing</td>
      </tr>
    <tr>
      <td colspan="4"  class="normalfnt"></td>
      </tr>
    <tr>
      <td height="25" class="normalfntRite">From Date :</td>
      <td colspan="3"><input name="txtInvoiceFromDate" tabindex="2" type="text" class="txtbox" id="txtInvoiceFromDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="" onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
      </tr>
    <tr>
      <td class="normalfntRite" height="25">To Date :</td>
      <td colspan="3"><input name="txtInvoiceToDate" tabindex="2" type="text" class="txtbox" id="txtInvoiceToDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="" onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
      </tr>
    <tr>
      <td colspan="4"  class="normalfnt"></td>
      </tr>
    <tr>
      <td colspan="4"><div style="overflow: scroll; height: 250px; width:100%;" id="selectitem">
        <table width="100%" align="center" cellpadding="1" cellspacing="1" class="normalfnt" id="tblProperty" bgcolor="#A2B0F4">
          <thead>
            <tr  bgcolor="#588DE7">
              <td width="9%" class="normaltxtmidb2">Select</td>
              <td height="20" width="91%" class="normaltxtmidb2">Property</td>
              </tr>
            </thead>
          <tbody>
            <!--   code goes here
                                    IMPORTANT : when a new property is required to be added to the grid list, the id of the check box should be the 
                                    data base field which is required to be shown in the report. The id of the check box should be of the format
                                    <Alias Name>.<field Name>. Check the summaryReport.php page for deciding the aliases.
                                    
                                    -->
            <tr class="bcgcolor-tblrow">
              <td><div align="center"><input type="checkbox" class="chkbx" id ="CID.strISDno" /></div></td>
              <td   id ="ISD No">ISD No</td>
              </tr>
            <tr class="bcgcolor-tblrowWhite">
              <td   ><div align="center"><input type="checkbox" class="chkbx" id ="FI.strHAWB" /></div></td>
              <td  id ="HAWB">HAWB</td>
              </tr>
            <tr class="bcgcolor-tblrow">
              <td   ><div align="center"><input type="checkbox" class="chkbx" id ="FI.strMAWB" /></div></td>
              <td    id ="MAWB">MAWB</td>
              </tr>
            <tr class="bcgcolor-tblrowWhite">
              <td   ><div align="center"><input type="checkbox" class="chkbx" id ="CIH.strCarrier" /></div></td>
              <td    id ="VESSEL">VESSEL</td>
              </tr>
            <tr class="bcgcolor-tblrow">
              <td   ><div align="center"><input type="checkbox" class="chkbx" id ="CIH.dtmSailingDate" /></div></td>
              <td    id ="ETD">ETD</td>
              </tr>
            <tr class="bcgcolor-tblrowWhite">
              <td   ><div align="center"><input type="checkbox" class="chkbx" id ="CIH.dtmETA" /></div></td>
              <td   id ="ETA">ETA</td>
              </tr>
            </tbody>
          </table>
        </div></td>
      </tr>
    <tr bgcolor="#d6e7f5">
      <td>&nbsp;</td>
      <td><img src="../../images/report.png" width="108" height="24" onclick="showReport();" /></td>
      <td><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="84" height="24" border="0"  class="mouseover" id="btnClose"lass="mouseover" /></a></td>
      <td>&nbsp;</td>
      </tr>
    <tr bgcolor="#d6e7f5">
      <td width="29%"></td>
      <td width="23%"></td>
      <td width="19%"></td>
      <td width="29%"></td>
      </tr>
    </table></td>
</tr>
</table>





</form>




</body>
</html>