<?php
include("../../../Connector.php");
$backwardseperator = "../../../";
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web :: Import Entry</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="importentry.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />
<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
</head>
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
<body>


<form id="frmBanks" name="form1" method="POST" action="">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><?php include '../../../Header.php'; ?></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
          <tr>
            <td width="19%">&nbsp;</td>
            <td width="62%"><table width="100%" border="0">
                <tr>
                  <td height="30" bgcolor="#316895" class="TitleN2white">Import Entry</td>
                </tr>
                <tr bgcolor="#FEFDEB">
                  <td height="96"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="100%" class="normalfnt"><table width="100%" height="130" border="0" cellspacing="0" class="bcgl1">
                            <tr>
                              <td width="2%" bgcolor="#C6E4FD" class="normalfnt">&nbsp;</td>
                              <td width="20%" bgcolor="#C6E4FD" class="normalfnt">Delivery No </td>
                              <td width="33%" bgcolor="#C6E4FD"><select name="cboDeliveryNo" class="txtbox" style="width:120px" id="cboDeliveryNo" onchange="ChangeInvoiceNo(this);">
                                  <?php
$sql_delivery="select strInvoiceNo,intDeliveryNo from deliverynote where intStatus=0 AND RecordType='IM'
Order BY intDeliveryNo DESC";
$result_delivery=$db->RunQuery($sql_delivery);
	echo "<option value=\"".""."\">".""."</option>";
while($row_delivery=mysql_fetch_array($result_delivery))
{
	echo  "<option value=\"".$row_delivery["strInvoiceNo"]."\">".$row_delivery["intDeliveryNo"]."</option>\n";
}
?>
                              </select></td>
                              <td width="17%" bgcolor="#C6E4FD">Invoice No </td>
                              <td width="28%" bgcolor="#C6E4FD"><select name="cboInvoiceNo" class="txtbox" style="width:120px" id="cboInvoiceNo" onchange="ChangeDeliveryNo(this);">
                                  <?php
$sql_invoice="select strInvoiceNo,intDeliveryNo from deliverynote where intStatus=0 AND RecordType='IM'
Order BY intDeliveryNo DESC";
$result_invoice=$db->RunQuery($sql_invoice);
	echo "<option value=\"".""."\">".""."</option>";
while($row_invoice=mysql_fetch_array($result_invoice))
{
	echo  "<option value=\"".$row_invoice["intDeliveryNo"]."\">".$row_invoice["strInvoiceNo"]."</option>\n";
}
					  ?>
                              </select></td>
                            </tr>
                            <tr>
                              <td colspan="2" class="normalfnt">&nbsp;</td>
                              <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                              <td class="normalfnt">&nbsp;</td>
                              <td class="normalfnt">Entry No </td>
                              <td><input name="txtEntryNo" class="txtbox" style="width:170px" id="txtEntryNo" /></td>
                              <td>Cleared On </td>
                              <td><input name="dtmClearedOn" type="text" class="txtbox" id="dtmClearedOn" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                            </tr>
                            <tr>
                              <td class="normalfnt">&nbsp;</td>
                              <td class="normalfnt">Merchandiser</td>
                              <td><input name="txtMerchandiser" class="txtbox" style="width:170px" id="txtMerchandiser" />
                              </td>
                              <td>Cleared By </td>
                              <td><select name="cboCleardBy" class="txtbox" style="width:120px" id="cboCleardBy">
                                  <?php
$sql="select intUserID,
	Name AS UserName	 
	from useraccounts ";
$result=$db->RunQuery($sql);
	echo "<option value=\"".""."\">".""."</option>";
while($row=mysql_fetch_array($result))
{
	echo  "<option value=\"".$row["intUserID"]."\">".$row["UserName"]."</option>\n";
}
?>
                              </select></td>
                            </tr>
                            <tr>
                              <td class="normalfnt">&nbsp;</td>
                              <td class="normalfnt">Location Of Goods </td>
                              <td><input name="txtLocationOfGood" type="text" class="txtbox" id="txtLocationOfGood" style="width:170px"/></td>
                              <td>Style Id </td>
                              <td><input name="txtStyleID" type="text" class="txtbox" id="txtStyleID" style="width:170px"/></td>
                            </tr>
                            <tr>
                              <td class="normalfnt">&nbsp;</td>
                              <td class="normalfnt">&nbsp;</td>
                              <td colspan="3">&nbsp;</td>
                            </tr>
                        </table></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                      <tr bgcolor="#d6e7f5">
                        <td width="100%"><table width="100%" border="0" cellspacing="0">
                            <tr bgcolor="#d6e7f5">
                              <td width="101"><img src="../../../images/new.png" alt="New" width="100" height="24" name="New"onclick="ClearForm();"/></td>
                              <td width="84"><img src="../../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="SaveDetails();"/></td>
                              <td width="104"><img src="../../../images/cancel.jpg" alt="calcel" width="104" height="24" onclick="Cancel();" /></td>
                              <td width="104"><img src="../../../images/report.png" alt="calcel" width="104" height="24" onclick="ViewReportPoPUp();" /></td>
                              <td width="66"><img src="../../../images/search.png" border="0" onclick="OpenDetailsList();" /></td>
                              <td width="97"><a href="../../../main.php"><img src="../../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                              <td width="3">&nbsp;</td>
                            </tr>
                        </table></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
            <td width="19%">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
