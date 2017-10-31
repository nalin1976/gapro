<?php
$backwardseperator	= '../';
include "../Connector.php";
$bookingDate	= date('Y-m-d');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GaPro | Booking</title>
</head>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />

<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../javascript/script.js"></script>
<script type="text/javascript" src="booking.js"></script>
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
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
	<td><?php include $backwardseperator."Header.php";?></td>
</tr>
<tr>
    <td align="center"><table width="850" border="0" cellspacing="2" cellpadding="0" class="tableBorder">
  	<tr>
    	<td height="25" class="mainHeading">Supplier Booking</td>
  	</tr>
 	
 	<tr>
 	  <td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="tableBorder">
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td>&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="4%" class="normalfnt">&nbsp;</td>
          <td width="11%" class="normalfnt">Supplier </td>
          <td width="49%"><select onchange="getSupplierData(this.value);" name="cboSupplier" class="txtbox" id="cboSupplier" style="width:312px" tabindex="5">
            <option value="0" selected="selected">Select One</option>
            <?php
if($displaySupplierCode=="true"){	
	$SQL = "SELECT concat(strTitle,' -> ',strSupplierCode)as strTitle,strSupplierID FROM suppliers s where intApproved='1' order by strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
}
else{
	$SQL = "SELECT strTitle,strSupplierID FROM suppliers s where intApproved='1' order by strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
}

	?>
          </select></td>
          <td width="14%" class="normalfnt">Date Booking </td>
          <td width="22%"><input name="txtBookingDate" type="text" tabindex="9" class="txtbox" id="txtBookingDate" style="width:100px"  onmousedown="DisableRightClickEvent()" onmouseout="EnableRightClickEvent()" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($bookingDate=="" ? "":$bookingDate);?>"/><input name="reset1" type="text"  class="txtbox" style="visibility:hidden;width:1px" onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td>&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5" class="mainHeading2"><div align="right"><img src="../images/additem.png" alt="add" onclick="OpenItemPopUp()"/></div></td>
          </tr>
      </table></td>
 	  </tr>
 	
 	<tr>
    	<td>
		<div id="divcons" style="overflow:scroll; height:450px; width:850px">
		<table id="tblItemMain" width="1200" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCFF">
          <tr class="mainHeading4">
            <th width="16%" height="25" scope="col">PO No </th>
            <th width="14%" scope="col">Style No </th>
            <th width="14%" nowrap="nowrap">Ex. Factory Date <br/>
              (From Supplier) </th>
            <th width="13%" nowrap="nowrap">Expected Arrivel <br/>
              Date </th>
            <th width="30%" scope="col">Item</th>
            <th width="10%" scope="col">Consumption</th>
            <th width="6%" scope="col">Qty</th>
            <th width="9%" scope="col">Price</th>
          </tr>
        </table>
		</div></td>
  	</tr>
	</table>
	</td>
  	</tr>
</table>
</body>
</html>
 <script type="text/javascript" src="../js/jquery.fixedheader.js"></script>