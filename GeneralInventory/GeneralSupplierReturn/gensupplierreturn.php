<?php
	session_start();
	include "../../Connector.php";	
	$backwardseperator = "../../";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General Return To Supplier</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="../GeneralSupplierReturn/gensupplierreturn.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>


<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<link href="../GeneralIssue/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../GeneralIssue/javascript/calendar/theme.css" />
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
 //alert(factoryID);
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

<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../GeneralIssue/java.js" type="text/javascript"></script>
</head>

<body>
<form id="frmPurchaseRequisition" name="frmPurchaseRequisition">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../../Header.php'; ?></td>
	</tr> 
</table>

		<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
          <tr>
            <td height="26" class="mainHeading">General Supplier Return </td>
          </tr>
          <tr>
            <td><table width="100%" border="0" class="tableBorder">
                 <tr>
                  <td width="100%"><table  width="100%" border="0" >
                      <tr>
                        <td width="50%" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="25%">Supplier Return No</td>
                            <td width="28%"><input name="txtreturnNo" type="text" class="txtbox" id="txtreturnNo" size="15" readonly="readonly" /></td>
                            <td width="10%">Date</td>
                            <td width="37%"><input name="txtdate" type="text" class="txtbox" id="txtdate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date ("d/m/Y") ?>"/><input name="reset" type="reset" class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                          </tr>
                        </table></td>
                        <td width="8%" class="normalfnt">Reason</td>
                        <td width="42%" rowspan="2" class="normalfnt">
                        <textarea name="txtReason" style="text-align:left" id="txtReason" cols="45">
                        </textarea></td>
                      </tr>
                      <tr>
 
                        <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="25%">Supplier</td>
                            <td width="75%"><select name="cboreturnedby" class="txtbox" id="cboreturnedby" style="width:340px">
                              <?php 	

	echo "<option value =\"".""."\">"."Select One"."</option>";
	$SQL="select strSupplierID,strTitle from suppliers where intStatus = 1 order by strTitle ";
	
	$result =$db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["strSupplierID"]."\">".$row["strTitle"]."</option>";
	}
?>
                            </select></td>
                          </tr>
                        </table></td>
                        <td class="normalfnt">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0" >
                <tr class="mainHeading2">
                  <td width="89%"><div align="center">General Supplier Return Details</div></td>
                  <td width="11%"><img src="../../images/add-new.png" alt="add new" width="109" height="18"  id="butAddNew" name="butAddNew" onclick="ShowItems();"/></td>
                </tr>
                <tr>
                  <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:320px; width:950px;">
                      <table id="tblIssueList" width="1000" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" >
                        <tr class="mainHeading4">
                          <td width="2%" height="28"  >Del</td>
                          <td width="12%" >GRN No</td>
                          <td width="18%" >Detail</td>
                          <td width="8%" >Qty. Return </td>
                          <td width="11%" >Unit</td>
                          <td width="7%" >Grn Qty</td>
                          <td width="7%" >Stock Balance</td>
                          <!--<td width="7%" >GL Code</td>-->
                        </tr>
                      </table>
                  </div></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellpadding="2" cellspacing="0" class="tableBorder">
                <tr>
                  <td height="29" style="text-align:center"><img src="../../images/new.png" alt="new" width="96" height="24" onclick="ClearForm();" /> <img src="../../images/save.png" alt="save" width="84" height="24" id="Save" onclick="getIssueNo();" /><img src="../../images/report.png" alt="image" width="108" height="24" onclick="showReport();" /><a href="../../main.php"><img src="../../images/close.png" alt="image" width="97" height="24" border="0" /></a></td>
                </tr>
            </table></td>
          </tr>
        </table>
</form>
</body>
</html>
 <script type="text/javascript" src="../js/jquery.fixedheader.js"></script>