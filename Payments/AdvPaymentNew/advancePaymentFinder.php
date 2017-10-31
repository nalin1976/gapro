<?php
	session_start();
	
	include "../../Connector.php";
$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro:Advance Payments Finder</title>
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
<script src="advancePaymentList.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>


<body onload="setDefaultDateofFinder()">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td id="tdHeader"><?php include $backwardseperator ."Header.php";?></td>
  </tr>
</table>
<div class="main_bottom_center">
	<div class="main_top">
		<div class="main_text">Advance Payments Finder<span class="vol"></span><span id="advancePayments_popup_close_button"></span></div>
	</div>
	<div class="main_body">
<form id="form1" name="form1" method="post" action="">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td width="85%" class="head1" >
		  <table border="0">
		  	<tr>
				<td width="54" class="normalfnt">Supplier</td>
				<td width="216" class="normalfnt"><select name="cboSuppliers" class="txtbox" id="cboSuppliers" style="width:200px" >
                  <option value=""></option>
                  <?php
					$SQL = "SELECT strSupplierID,strTitle FROM suppliers WHERE intStatus=1 ORDER BY strTitle;";	
					$result = $db->RunQuery($SQL);		
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
					}
					
					?>
                </select></td>
				<td width="25" class="normalfnt"><input type="checkbox" onclick="edDate(this);" name="chk" id="chk" /></td>
				<td width="72" class="normalfnt">Date From </td>
				<td width="86" class="normalfnt"><input name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');" disabled="disabled"/><input name="reseta" type="text"  class="txtbox" style="visibility:hidden; width:2px;" onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
				<td width="50" class="normalfnt">Date To </td>
				<td width="87" class="normalfnt"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');" disabled="disabled"/><input name="reset2" type="text"  class="txtbox" style="visibility:hidden; width:2px;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
				<td width="93"><table cellspacing="0" cellpadding="0">
				  <tr>
                    <td width="96" class="normalfnt">Payment Type</td>
				    </tr>
				  </table>				</td>
				<td width="136"  > <?php 
			  $type = $_POST["cboPaymentType"];
			  $checked	= "selected=\"selected\""; 
		  ?>
		  <select name="cboPaymentType" id="cboPaymentType" onchange="pageRefreshListing();">
		  	<option value="S" <?php if($type=="S"){ echo $checked;} ?>>Style</option>
			<option value="G" <?php if($type=="G"){ echo $checked;} ?>>General</option>
			<option value="B" <?php if($type=="B"){ echo $checked;} ?>>Bulk</option>
			<option value="W" <?php if($type=="W"){ echo $checked;} ?>>Wash</option>
		  </select></td>
			</tr>
			<tr>
				<td class="normalfnt">PO No</td>
				<td><input type="text"  id="txtPoNo" name="txtPoNo" style="width:200px"/></td>
				<td class="normalfnt" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;User</td>
				<td class="normalfnt">
					<select name="cboUser" class="txtbox"  style="width:75px" id="cboUser">
								  <option value="" ></option>
								  <?php	
						$SQL = "SELECT name,intUserID FROM useraccounts order by name;";	
						$result = $db->RunQuery($SQL);	
						while($row = mysql_fetch_array($result))
						{
							if($intUserId == $row["intUserID"])
								echo "<option selected=\"selected\" value=\"". $row["intUserID"] ."\">" . $row["name"] ."</option>" ;
							else
								echo "<option value=\"". $row["intUserID"] ."\">" . $row["name"] ."</option>" ;
						}	
						?>
					</select></td>
				<td class="normalfnt"></td>
				<td class="normalfnt"></td>
				<td class="normalfnt"></td>
				<td class="normalfnt" style="text-align:right;">&nbsp;</td>
				<td width="81" class="normalfnt"><span class="normalfnt" style="text-align:left;"><img src="../../images/search.png" alt="go"  class="mouseover" onclick="fillAvailableAdvData();" /></span></td>
			</tr>
		  </table>		  </td>
        </tr>
          <td colspan="3">
		  <div class="bcgl1" id="divAdvData"  style="overflow: -moz-scrollbars-vertical; width:940px;height:400px ; background:#FFFFFF">
		  <table id="tblAdvData" width="922" border="0" cellpadding="0" cellspacing="1" bordercolor="#162350" bgcolor="#CCCCFF" >
		  	<thead>
            <tr>
			<!--  <td width="10%"  height="20" bgcolor="" class="grid_header">PO No</td>-->
              <td width="16%" height="" bgcolor="" class="grid_header">Payment No</td>
              <td width="12%" bgcolor="" class="grid_header">Date</td>
              <td width="16%" bgcolor="" class="grid_header">Amount </td>
              <td width="12%" bgcolor="" class="grid_header">Tax</td>
              <td width="16%" bgcolor="" class="grid_header">Total Amount </td>
              <td width="10%" bgcolor="" class="grid_header">View</td>
            </tr>
			</thead>
			<tbody>
			</tbody>
          </table>
		  </div>		  </td>
        </tr>
		<tr>
			 <td align="center"><img src="../../images/new.png" border="0" onclick="clearAdPay();" />
			 <span class="normalfnt"><a href="../../main.php"><img src="../../images/close.png"  border="0" /></a>
			 <img src="../../images/report.png" border="0" onclick="loadReport();" /></span></td>
        </tr>

      </table></td>
    </tr>
    
  </table>
</form>
</div>
</div>
</body>
</html>
