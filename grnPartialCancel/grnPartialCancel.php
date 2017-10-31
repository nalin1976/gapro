<?php

session_start();
$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purchase Order Partial Cancellation</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="grnCancel.js" type="text/javascript"></script>
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

<body  >
<?php
	include "../Connector.php";	
?>
<form name="frmbom" id="frmbom">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../Header.php'; ?></td>
</tr>
<tr>
<td bgcolor="#316895" class="TitleN2white">GRN  Partial Cancellation </td>
</tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            
            <td width="9%" rowspan="2" class="normalfnt"><img src="../images/search.png" alt="search" width="80" height="24" class="mouseover" onclick="loadPoDetails();"/></td>
          </tr>
          <tr>
            <td width="2%" height="12" class="normalfnt">&nbsp;</td>
            <td width="89%" colspan="9" class="normalfnt"><table width="100%" border="0">
              <tr>
                <td width="10%">GRN  Year </td>
                <td width="11%"><select name="cboYear" class="txtbox" id="cboYear" style="width:80px" >
				<?php
			for ($loop = date("Y") ; $loop >= 2006; $loop --)
			{
				if ($poyear ==  $loop)
					echo "<option selected=\"selected\" value=\"$loop\">$loop</option>";
				else
					echo "<option value=\"$loop\">$loop</option>";
			}
	?>
                </select></td>
                <td width="1%">&nbsp;</td>
                <td width="8%">GRN No</td>
                <td width="24%"><select name="cboPoNo" class="txtbox" id="cboPoNo" style="width:160px"  onchange="loadGRNDetails();">
                  <?php
					$SQL = 	"SELECT intGrnNo  FROM     grnheader
							WHERE (intStatus = 1) AND (intUserId = ".$_SESSION["UserID"].") 
							and (intGRNYear ='" . date("Y") . "') ";
							
					$result = $db->RunQuery($SQL);
			
					echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["intGrnNo"] ."\">" . trim($row["intGrnNo"]) ."</option>" ;
					}
				?>
                </select></td>
                <td width="46%" class="normalfntLeftBlue">&nbsp;</td>
              </tr>
            </table></td>
            </tr>
        </table></td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="normalfnth2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="5%"><div align="center" >
				<input name="chkCheckAll" type="checkbox" id="chkCheckAll" onclick="checkAll(this)" />
			 </div></td>
            <td width="95%">check All </td>
          </tr>
        </table></td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:450px; width:950px;">
          <table width="900" id="tblPoDetails" cellpadding="0" cellspacing="0">
            <tr>
              <td width="4%"  bgcolor="#498CC2" class="normaltxtmidb2" height="22">Sel</td>
              <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">Style Id </td>
              <td width="17%" bgcolor="#498CC2" class="normaltxtmidb2">Discription</td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
              <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer PoNo </td>
              <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Remarks </td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2R">Unit Price </td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Value</td>
            </tr>
<!--			<tr>
				<td height="18"><div align="center" ><img src="../images/del.png"  border="0" alt="search" width="15" height="15" class="mouseover" onclick="removeLine();"/></div></td>
				<td class="normalfnt">&nbsp;</td>
				<td class="normalfntRite">&nbsp;</td>
				<td class="normalfnt">&nbsp;</td>
				<td class="normalfnt">&nbsp;</td>
				<td class="normalfnt">&nbsp;</td>
				<td class="normalfnt">&nbsp;</td>
				<td class="normalfnt">&nbsp;</td>
				<td class="normalfnt"><input name="txtBuyerPoNo" type="text" class="txtbox" id="txtBuyerPoNo" size="12" style="text-align:right" /></td>
				<td class="normalfnt">&nbsp;</td>
			</tr>-->
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="12%" height="29">&nbsp;</td>
        <td width="12%">&nbsp;</td>
        <td width="11%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
        <td width="13%"><img src="../images/cancel.jpg" alt="Cancel" width="104" height="24" border="0" class="mouseover" onclick="savePartialCancellation();" /></td>
        <td width="10%"><a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0" class="mouseover" /></a></td>
        <td width="12%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
  </tr>
</table>
</form>
</body>
</html>
