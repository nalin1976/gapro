<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gatepass - Transfer List</title>
<script type="text/javascript" src="TransferInDetails.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<!--start -for calander-->
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>

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
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script type="text/javascript">
var factoryID = <?php
 echo $_SESSION["FactoryID"]; 
 ?>;
var UserID = <?php
 session_start();
 echo $_SESSION["UserID"]; 
 ?>;
var EscPercentage = 0.25;
 
var serverDate = new Date();
serverDate.setYear(parseInt(<?php
echo date("Y"); 
?>));
serverDate.setMonth(parseInt(<?php
echo date("m"); 
?>));
serverDate.setDate(parseInt(<?php
echo date("d")+1; 
?>));


</script>

<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="java.js" type="text/javascript"></script>
<!--End -for calander-->
</head>

<body>
<form>
  <tr>
    <td colspan="2"><?php include '../../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">

      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr  height="25" class="mainHeading">
        <td width="28%">&nbsp;</td>
        <td width="20%">Gate Pass TransferIn</td>
        <td width="15%"><select name="cbocategory" class="txtbox" id="cbocategory" style="width:130px" onchange="LoadSavedDetails();">		
          	<option value="1">Processed Details</option>
		  	<!--<option value="10">Cancel Details</option>-->
                        </select></td>
        <td width="37%" class="normaltxtmidb2L">List</td>
      </tr>
    </table></td>
  <tr>
    <td colspan="2"><table width="100%" border="0" class="tableBorder">
      <tr>
        
        <td width="14%" class="normalfnt">TransferIn No From </td>
        <td width="13%" class="normalfnt"><input name="TrasnferNoFrom" type="text" class="txtbox" id="TrasnferNoFrom" size="15" /></td>
        <td width="4%" class="normalfnt">To</td>
        <td width="12%" class="normalfnt"><input name="TrasnferNoTo" type="text" class="txtbox" id="TrasnferNoTo" size="15" /></td>
        <td width="4%" class="normalfnt"><input type="checkbox" name="chkDate" id="chkDate" onclick="DateValidate(this);" /></td>
        <td width="8%" class="normalfnt">Date From </td>
        <td width="15%" class="normalfnt"><input name="DateFrom" type="text" class="txtbox" id="DateFrom" size="15" disabled="disabled" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date ("d/m/Y") ?>"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
        <td width="4%" class="normalfnt">To</td>
        <td width="15%" class="normalfnt"><input name="DateTo" type="text" class="txtbox" id="DateTo" size="15" disabled="disabled" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date ("d/m/Y") ?>"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
        <td width="11%" class="normalfnt"><img src="../../images/search.png" alt="search" width="80" height="24" onclick="LoadSavedDetails();" /></td>
      </tr>
    </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="32%"  class="mainHeading2">&nbsp;</td>
            <td width="56%"  class="mainHeading2">&nbsp;</td>
            <td width="12%"  class="mainHeading2">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divTranferInDetails" style="overflow:scroll; height:400px; width:950px;">
          <table id="tblTranferInDetails" width="930" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" >
            <tr class="mainHeading4">
			  <td width="1%" height="25" ></td>	
              <td width="7%" >Transfer In No</td>
              <td width="7%" >Date</td>
              <td width="8%" >Gate Pass No</td>
              <td width="8%" >View</td>			  
              </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr >
    <td height="30" colspan="2"><table width="100%" border="0" class="tableBorder">
      <tr>
        <td width="26%" class="normalfnt">&nbsp;</td>
        <td width="13%" class="normalfnt"><div align="center"></div></td>
        <td width="11%" class="normalfnt"><img src="../../images/new.png" alt="new" width="96" height="24" onclick="ClearForm();" /></td>
        <td width="12%" class="normalfnt"><a href="../../main.php"><img src="../../images/close.png" alt="close" width="97" height="24" border="0" /></a></td>
        <td width="12%" class="normalfnt"><div align="center"></div></td>
        <td width="26%" class="normalfnt">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
