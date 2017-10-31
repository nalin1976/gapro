<?php
session_start();
include "../../Connector.php";
$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web - Invoices Finder</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<style type="text/css">
<!--
body {
	background-color: #FFF;
}
-->
</style>

<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
-->
</style>


</head>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="supplierInvFinder.js" type="text/javascript"></script>
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

<body onload="InitializeInvoiceFinder();">

<form id="form1" name="form1" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../../Header.php'; ?></td>
	</tr>
    <tr>
    <td>
    <table width="950" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">
    <tr>
    		<td class="mainHeading">Supplier Invoice List</td>
		</tr>
    <tr>
          <td colspan="2"><table width="100%" border="0" class="bcgl1">
            <tr>
              <td width="1%" height="32" rowspan="3">&nbsp;</td>
              <td width="8%" class="normalfnt">Invoice No </td>
              <td colspan="3"><span class="normalfnt">
                <input name="txtinvoiceno" type="text" class="txtbox" id="txtinvoiceno" size="15" />
              </span></td>
              <td width="10%" class="normalfnt">Entry No</td>
              <td><input type="text" name="txtEntryNo" id="txtEntryNo" size="15"/></td>
              <td colspan="2" ><table width="321" height="25" class="tableBorder" border="0" cellpadding="0" cellspacing="0"  >
                <tr >
                  <td width="205" height="25" class="normalfnth2Bm" >Payment Type</td>
                  <td width="265" ><select name="cboPymentType" class="txtbox" id="cboPymentType" style="width:150px" onchange="SearchInvoices()" >
                    <?php 
								$strSQL="SELECT strTypeID,strDescription FROM paymenttype where strTypeID!='W' ORDER BY intID";
								$result = $db->RunQuery($strSQL);
								while($row = mysql_fetch_array($result))
								{
									echo "<option value=\"". $row["strTypeID"] ."\">" . $row["strDescription"] ."</option>" ;
								}
								
							?>
                  </select></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td class="normalfnt">Date From</td>
              <td colspan="3"><span class="normalfnt">
                <input disabled="disabled" style="background-color:#CCC" name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
              </span></td>
              <td><span class="normalfnt">Date To</span></td>
              <td width="26%"><span class="normalfnt">
                <input disabled="disabled"  style="background-color:#CCC"  name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
              </span>
              <input type="checkbox" id="chkActInAct" name="chkActInAct"  onclick="actInAct(this);"/> </td>
              <td width="8%">&nbsp;</td>
              <td width="31%">&nbsp;</td>
              </tr>
            <tr>
              <td height="21" class="normalfnt">Paid</td>
              <td width="5%"><span class="normalfnt">
                <input name="paid" id="paid" type="checkbox" value="" />
              </span></td>
              <td width="5%"><span class="normalfnt">UnPaid</span></td>
              <td width="6%"><span class="normalfnt">
                <input name="unpaid" id="unpaid" type="checkbox" value="" />
              </span></td>
              <td class="normalfnt">Supplier</td>
              <td class="normalfnt"><select name="cbosupplier" class="txtbox" id="cbosupplier" style="width:240px" > 
              <option value="0"></option>
              <?php 
			  		$sql="SELECT strSupplierID AS SupID, strTitle AS SupNm FROM suppliers WHERE intstatus = 1 ORDER BY SupNm ASC;";
			  		$res=$db->RunQuery($sql);
					while($row=mysql_fetch_array($res))
					{  ?>
						<option value="<?php echo $row['SupID'];?>"	><?php echo $row['SupNm'];?></option>	
               
               <?php } ?>
              </select></td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt"><div align="right"><img src="../../images/search.png" alt="go" width="80" height="24" class="mouseover" onclick="SearchInvoices();" /></div></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2">
		  <div id="divinvData" style="width:945px;height:320px;overflow:scroll" class="" >
		  <table id="tblinvdata" width="950" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" >
            <tr class="mainHeading4">
<!--			  <td width="1%" height="29" bgcolor="#498CC2" class="normaltxtmidb2"></td>
-->              <td width="16%" height="25" >Invoice No </td>
              <td width="25%"  >Supplier</td>
              <td width="15%" >Date </td>
              <td width="15%" >Amount</td>
              <td width="15%" >Paid</td>
              <td width="14%" >Balance</td>
			  <td width="14%" >View</td>
            </tr>
          </table>
		  </div>
		  </td>
    </tr> 
  </table>
    </td>
    </tr>   
</table>
</form>
</body>
</html>
