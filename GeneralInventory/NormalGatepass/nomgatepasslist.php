<?php

session_start();
include "../../Connector.php";	
$backwardseperator = "../../";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Normal :: Saved Gatepass List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<script type="text/javascript" src="nomgatepass.js"></script>


<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
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
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script type="text/javascript">
var factoryID = <?php

 echo $_SESSION["CompanyID"]; 
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
<script src="../../java.js" type="text/javascript"></script>
</head>

<body>

<form name="frmIssuesList" id="frmIssuesList">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="bcgl1">
          <tr>
            <td width="13%" height="24" class="normalfnt">Gatepass No. From</td>
            <td width="9%" class="normalfnt"><select name="cboissuenofrom" class="txtbox" id="cboissuenofrom" style="width:80px">
 <?php

 	$SQL ="select concat(intYear,'/', strGatepassID)as issueNo from nomgatepassheader ; ";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>";
	
	while ($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".""."\">". $row["issueNo"] ."</option>";
	}
 ?>
			</select>            </td>
            <td width="11%" class="normalfnt">Gatepass No. To</td>
            
			<td width="9%" class="normalfnt"><select name="cboissuenoto" class="txtbox" id="cboissuenoto" style="width:80px">
 <?php
 
 	$SQL ="select concat(intYear,'/', strGatepassID)as issueNo from nomgatepassheader ; ";
	
	$result = $db->RunQuery($SQL);
	
	echo "<option value=\"".""."\">" .""."</option>";
	
	while ($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".""."\">". $row["issueNo"] ."</option>";
	}
	
 ?>
			
			</select>            </td>
			           
			<td width="2%" class="normalfnt">&nbsp;</td>
            <td width="2%" class="normalfnt"><input type="checkbox" name="chkdate" id="chkdate" /></td>
            <td width="7%" class="normalfnt">Date From</td>
            <td width="14%" class="normalfnt"><!--<select name="cbopodatefrm" class="txtbox" id="cbopodatefrm" style="width:80px">
            </select>--> 
			<input name="issuedatefrom" type="text" class="txtbox" id="issuedatefrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');">	              </td>
            <td width="6%" class="normalfnt">Date to</td>
            <td width="17%" class="normalfnt"><!--<select name="cbopodateto" class="txtbox" id="cbopodateto" style="width:80px">
            </select>-->
			<input name="issuedateto" type="text" class="txtbox" id="issuedateto" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');">		
			
			</td>
            <td width="10%" class="normalfnt"><img src="../../images/search.png" alt="search" width="80" height="24" onclick="LoadSavedDetails();" /></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="18" bgcolor="#9BBFDD" class="normalfnth2"><div align="center">Saved Gatepass List</div></td>
        </tr>
      <tr>
        <td class="normalfnt"><div id="divtblIssueDetails" style="overflow:scroll; height:400px; width:950px;">
          <table id="tblIssueDetails" width="100%" cellpadding="0" cellspacing="1"  bgcolor="#CCCCFF">
            <tr>
              <td width="12%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Gatepass No</td>
              <td width="37%" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
              <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">Gatepass To </td>
			  <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Normal Print</td>
			  <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Pre Print</td>
              </tr>
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="40%" height="29"></td>
        <td width="13%"><img src="../../images/new.png" class="mouseover"  alt="new" width="96" height="24" onclick="ClearForm();" /></td>        
        <td width="47%"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" /></a></td>
       
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
