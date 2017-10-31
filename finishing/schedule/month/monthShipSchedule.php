<?php
session_start();
	include "../../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../../../";
	include "../../../authentication.inc";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Monthly Shipment Forecast</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../../javascript/calendar/theme.css" rel="stylesheet" type="text/css"/> 

<script src="../../../javascript/script.js" language="javascript" type="text/javascript"></script>
<script src="../../../javascript/script.js" language="javascript" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
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

<body>
<form id="frmMnthSchedule" name="frmMnthSchedule">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../../Header.php';?></td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td><table width="850" border="0" cellspacing="0" cellpadding="1" align="center">
      <tr>
        <td colspan="4" class="mainHeading">Monthly Shipment Forecast</td>
        </tr>
      <tr>
        <td width="127">&nbsp;</td>
        <td width="189">&nbsp;</td>
        <td width="280">&nbsp;</td>
        <td width="254">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" colspan="4"><table width="349" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
          <tr>
            <td width="137" class="normalfnt">Find Schedule No</td>
            <td width="210"><select name="cboScheduleNo" id="cboScheduleNo" style="width:150px;" onChange="loadPendingScheduleData();">
             <option value=""></option>
            <?php 
			$sql = "select intScheduleNo,strMonthSheduleNo from finishing_month_schedule_header where intStatus=0 order by strMonthSheduleNo desc ";
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				 echo "<option value=".$row["intScheduleNo"].">".$row["strMonthSheduleNo"]."</option>\n";
			}
			?>
            </select>            </td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="4"></td>
        </tr>
      <tr>
        <td class="normalfnt">Schedule No</td>
        <td><input type="text" name="txtScheduleNo" id="txtScheduleNo" disabled></td>
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="18%" class="normalfnt">Month</td>
            <td width="34%"><select name="cbomonth" id="cbomonth" style="width:120px;">
            <option value=""></option>
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
            </select>            </td>
            <td width="22%" class="normalfnt">Year</td>
            <td width="26%"><select name="cboYear" id="cboYear" style="width:120px;">
            <?php
			for ($loop = date("Y")+1 ; $loop >= 2008; $loop --)
			{
				if($loop==date("Y"))
					echo "<option  value=\"$loop\" selected=\"selected\">$loop</option>";
				else	
					echo "<option value=\"$loop\">$loop</option>";
			}
			?>
            </select>            </td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="mainHeading2" align="right" ><img src="../../../images/add-new.png" width="109" height="18" align="right" onClick="addDeliverySchedules();"></td>
        </tr>
      <tr>
        <td colspan="4"><div style="width:850px; height:450px; overflow:scroll;">
        <table width="950" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblMainGrid">
  <tr class="mainHeading4">
    <td width="27" height="20">Del</td>
    <td width="87">Del Date</td>
     <td width="87">Hand Over Date</td>
    <td width="136">Order No</td>
    <td width="106">Style No</td>
    <td width="75">Order Qty</td>
    <td width="68">Del Qty</td>
    <td width="84">Total Qty</td>
   
    <td width="66">Balance</td>
    <td width="107">Remarks</td>
  </tr>
</table>

        </div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center" class="tableFooter"><img src="../../../images/new.png" onClick="clearPage();"><img src="../../../images/save.png" width="84" height="24" onClick="saveShipSchedule();"><img src="../../../images/conform.png" style="display:none" id="butConfirm" onClick="OpenConfirmScheduleRpt();"><img src="../../../images/report.png" onClick="openReport();"><a href="../../../main.php"><img src="../../../images/close.png" width="97" height="24" border="0"></a></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<script src="monthShipSchedule.js" language="javascript" type="text/javascript"></script>
</body>
</html>
