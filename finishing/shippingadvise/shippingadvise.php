<?php
session_start();
	include "../../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	$backwardseperator = "../../";
	include "../../authentication.inc";
	include "../../eshipLoginDB.php";	
	$userId			= $_SESSION["UserID"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Shipping Advise</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css"/>
<script src="shippingadvise.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
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

<body><form id="frmWkShipSchedule" name="frmWkShipSchedule">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include '../../Header.php';?></td>
  </tr>
  <tr>
  	<td height="5"></td>
  </tr>
  <tr>
    <td><table width="867" border="0" cellspacing="0" cellpadding="2" align="center" class="tableBorder">
      <tr class="mainHeading">
        <td width="880" height="25">Shipping Advise </td>
        </tr>
		<tr>
			<td height="2"></td>
		</tr>
		<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="bcgl1">
      <tr>
        <td width="129" class="normalfnt">Shipping Advise No </td>
        <td width="190"><select name="cboShipAdvNo" id="cboShipAdvNo" style="width:150px;" onChange="loadShipAdvData();">
          <option value=""></option>
          <?php 
			$sql = "Select concat(intShippingAdviseNo,'/',intShippingAdviseYear) as shipAdvId from 				finishing_shipping_advise_header where intUserId='$userId' ";
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=".$row["shipAdvId"].">".$row["shipAdvId"]."</option>\n";
			}
				?>
        </select></td>
        <td width="111" class="normalfnt">Date</td>
        <td width="169"><input type="text" name="txtDate " id="txtDate" style="width:100px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"  onKeyDown="" / value="<?php echo date ("d/m/Y") ?>"><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
        <td width="83" class="normalfnt">&nbsp;</td>
        <td width="171"></td>
      </tr>
    </table></td>
  </tr>
</table>
</td>
		</tr>
       <tr>
        <td><table width="863" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="880"><table width="869" border="0" cellspacing="3" cellpadding="0" class="bcgl1" >
            <tr>
            	<td width="130" class="normalfnt">Weekly Schedule No</td>
                <td width="190"><select name="cboScheduleNo" id="cboScheduleNo" style="width:150px;">
                  <option value=""></option>
                  <?php 
			$sql = "Select concat(intWkScheduleNo,'/',intYear) as intWkScheduleNo ,strWkScheduleNo from finishing_week_schedule_header where intUserId='$userId' ";
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=".$row["intWkScheduleNo"].">".$row["strWkScheduleNo"]."</option>\n";
			}
				?>
                </select></td>
                <td width="110" class="normalfnt">Mode</td>
                <td width="169"><select name="cboMode" id="cboMode" style="width:150px;">
                  <option value=""></option>
                 <?php
				 $sql="SELECT * FROM shipmentmode where intStatus='1' order by intShipmentModeId";
				 $result = $db->RunQuery($sql);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=".$row["intShipmentModeId"].">".$row["strDescription"]."</option>\n";
				}
				 ?>
                </select></td>
                <td width="82" class="normalfnt">Destination</td>
                <td width="172"><select name="cboDestination" id="cboDestination" style="width:150px;">
                  <option value=""></option>
                  <?php 
	$eshipDB = new eshipLoginDB();
			$sql = "select strCityCode,strCity,strPortOfLoading from city order by strCity ";
			$result = $eshipDB->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
				 echo "<option value=".$row["strCityCode"].">".$row["strCity"].'-'.$row["strPortOfLoading"]."</option>\n";
			}
			?>
                </select></td>
            </tr>
            
        </table></td>
          </tr>
		  <tr>
		  	<td height="2"></td>
		  </tr>
        </table></td>
        </tr>
      <tr class="mainHeading2" align="right">
        <td><img src="../../images/search.png" align="right" onClick="loadWeekSheduleData();"></td>
        </tr>
      <tr>
        <td><div style="width:100%; height:450px; overflow:scroll;">
        <table width="852" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblMainGrid">
  <tr class="mainHeading4">
    <td width="32" height="22"><input type="checkbox" id="checkBoxAll" name="checkBoxAll" onClick="checkAll(this)" /></td>
    <td width="144" nowrap="nowrap">PO No</td>
    <td width="154" nowrap="nowrap">Style</td>
    <td width="78" nowrap="nowrap">Mode</td>
    <td width="95" nowrap="nowrap">Order Qty</td>
    <td width="170" nowrap="nowrap">Destination</td>
    <td nowrap="nowrap">PL No </td>
    <td width="30" nowrap="nowrap">&nbsp;</td>
  </tr>
</table>

        </div></td>
        </tr>
      <tr>
        <td height="5"></td>
        </tr>
      <tr>
        <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableFooter">
  <tr>
    <td align="center"><img src="../../images/new.png" width="96" height="24" onClick="clearPage();"><img src="../../images/conform.png" id="butConform" alt="conform" onClick="conform();" /><img src="../../images/save.png" width="84" height="24" id="butSave" onClick="saveData();"><img src="../../images/report.png" onClick="openWkReport();"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0"></a></td>
  </tr>
</table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table></form>
</body>
</html>
