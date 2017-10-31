<?php
session_start();
$backwardseperator = "../../../";
include "$backwardseperator".''."Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forwarder Invoice List</title>
<style type="text/css"> 
body {
	background-color: #CCCCCC;
	
}
</style>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery-1.4.4.min.js"></script>
<link href="../../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery-ui-1.8.9.custom.min.js"></script>

<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />
<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="ForwarderInvList.js"></script>

<script src="../../../javascript/script.js" type="text/javascript"></script>
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


<style type="text/css">
.dataTable { font-family:Verdana, Arial, Helvetica, sans-serif; border-collapse: collapse; border:1px solid #999999; width: 750px; font-size:12px;}
.dataTable td, .dataTable th { padding: 0px 0px;  margin:0px;border:1px solid #D7CEFF;}

.dataTable thead a {text-decoration:none; color:#444444; }
.dataTable thead a:hover { text-decoration: underline;}

/* Firefox has missing border bug! https://bugzilla.mozilla.org/show_bug.cgi?id=410621 */
/* Firefox 2 */
html</**/body .dataTable, x:-moz-any-link {margin:1px;}
/* Firefox 3 */
html</**/body .dataTable, x:-moz-any-link, x:default {margin:1px}
</style>
</head>

<body>
<table  width="950" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "".$backwardseperator."Header.php"; ?></td>
  </tr>
  <tr>
    <td bgcolor="#316895"  height="25" class="TitleN2white" >Forwarder Invoice List</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
     
      <tr>
        <td width="11%" height="25">Forwarder</td>
        <td width="19%"> <select id="cboForwader" name="cboForwader" style="width:168px" class="normalfnt" onchange="loadSavedInvoices();">
				  <option value="0"></option>
				  <?php
				  	$sql="SELECT DISTINCT
							forwaders.strName,
							forwader_invoice_header.intForwaderId
							FROM
							forwader_invoice_header
							INNER JOIN forwaders ON forwader_invoice_header.intForwaderId = forwaders.intForwaderID
							;";
					$result=$db->RunQuery($sql);
						while($row=mysql_fetch_array($result))
						{
				  ?>
				  <option value="<?php echo $row['intForwaderId']; ?>"><?php echo $row['strName']; ?></option>
				  <?php
				 		 }
				  ?>
				  </select></td>
        <td width="13%">Forw.Invoice No</td>
        <td width="21%"><select style="width:168px" id="cboInvoice" name="cboInvoice" class="normalfnt" onchange="" disabled="disabled">
				  <option value="0"></option>
				  </select></td>
        <td width="13%">Acc. Submitted</td>
        <td width="23%"><select name="cboAccSubmitted" class="txtbox" id="cboAccSubmitted" style="width:180px" tabindex="3">
          <option value="All">All</option>
		  <option value="Submitted">Submitted</option>
		  <option value="NotSubmitted">Not Submitted</option>
        </select></td>
      </tr>
       <tr>
         <td height="25">Seach Date </td>
         <td><input type="checkbox" id="chk_dateRange" name="chk_dateRange" onclick="enableDateRange(this);"/></td>
         <td>Date From</td>
         <td><input name="txtDateFrom" tabindex="2" type="text" class="txtbox" id="txtDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled" /><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
         <td>Date To </td>
         <td><input name="txtDateTo" tabindex="2" type="text" class="txtbox" id="txtDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"  disabled="disabled"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
       </tr>
       <tr>
         <td height="25">&nbsp;</td>
         <td><img src="../../../images/search.png" width="80" height="24" id="btnSearch" class="mouseover" onclick="validateData();"/></td>
         <td><img src="../../../images/report.png" width="90" height="24" onclick="showReport();" /></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
    </table></td>
  </tr>
  <tr>
    <td height="300" valign="top">
	<div align="center">
	<div align="center" style="width:96%; height:400px; overflow:scroll; margin-top:25px; margin-bottom:25px;">
	<table style="width:100%;"  cellpadding="2" cellspacing="1" bgcolor="#EFDEFE"  id="tblForwarderInv" class="dataTable">
      <thead>
        <tr class="mainHeading4 normaltxtmidb2 " >
          <th height="25"  width="14%" bgcolor="#498CC2">Invoice No</th>
           <th height="25"  width="7%" bgcolor="#498CC2">Date</th>
          <th height="25"  width="11%" bgcolor="#498CC2">Amount</th>
           <th height="25"  width="14%" bgcolor="#498CC2">Cheque No</th>
          <th height="25"  width="19%" bgcolor="#498CC2">Paid Amount</th>
          <th height="25"  width="13%" bgcolor="#498CC2">Account Submit</th>
          <th height="25"  width="15%" bgcolor="#498CC2">Submit Date</th>
          <th height="25"  width="7%" bgcolor="#498CC2">View</th>
        </tr>
      </thead><tbody></tbody>
    </table>
	</div>
	</div>
	</td>
  </tr>
</table>
</body>
</html>