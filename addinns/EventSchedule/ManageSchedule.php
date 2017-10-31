<?php

session_start();
$backwardseperator = "../";
include "${backwardseperator}authentication.inc";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Schdules</title>
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
<script src="ManageSchedule.js" type="text/javascript"></script>
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

// ----------------------------------------------------------

function showReportMenu()
{
	
	if (document.getElementById("divReport").style.visibility == "hidden")
	{
		if(document.getElementById("cbostyle").value == "Select One")
		{
			alert("Please select the style first.");
			document.getElementById("cbostyle").focus();
			return ;
		}
		document.getElementById("divReport").style.visibility = "";
	}
	else
		document.getElementById("divReport").style.visibility = "hidden";

}

function openReport(type)
{
	var styleID = document.getElementById("cbostyle").value;
	if(type == "critical")
		window.open("criticalScheduleReport.php?styleID=" + URLEncode(styleID));
	else if (type == "completed")
		window.open("completedEvents.php?styleID=" + URLEncode(styleID));
	else
		window.open("revisedEvents.php?styleID=" + URLEncode(styleID));
}

function showAddItemPopUp()
{
	
	if (document.getElementById("divAddItem").style.visibility == "hidden")
	{
		if(document.getElementById("cbostyle").value == "Select One")
		{
/*			alert("Please select the style first.");
			document.getElementById("cbostyle").focus();
			return ;*/
		}
		document.getElementById("divAddItem").style.visibility = "";
	}
	else
		document.getElementById("divAddItem").style.visibility = "hidden";

}

</script>

<style type="text/css">
<!--
.style5 {color: #993333}
-->
</style>
</head>

<body>
<?php
	include "../Connector.php";	
?>
<form name="frmbom" id="frmbom">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td width="8%"  height="25" class="normalfnt">Style ID </td>
            <td width="25%" class="normalfnt">
            <select name="cbostyle" class="txtbox" id="cbostyle" style="width:200px" onchange="LoadDeliveryDates();">
            	<option value="Select One">Select One</option>
            <?php
	
	$sql = "SELECT DISTINCT orders.intStyleId AS StyleID,orders.strStyle FROM eventscheduleheader
			INNER JOIN orders ON eventscheduleheader.strStyleId = orders.intStyleId 
			WHERE orders.intStatus NOT IN (12,13) 
			ORDER BY orders.intStyleId ASC ;";
			
	

	$result = $db->RunQuery($sql);
	
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["StyleID"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                    </select></td>
            <td width="14%" class="normalfnt">Delivery Date</td>
            <td width="24%" class="normalfnt"><select name="cbodelivery" class="txtbox" id="cbodelivery" style="width:150px" onchange="LoadBuyerPO();">
            </select></td>
            <td width="14%" class="normalfnt" >Buyer PO</td>
            <td width="15%" class="normalfntleft" ><select name="cboBuyerPO" class="txtbox" id="cboBuyerPO" style="width:150px" onchange="LoadEventScheduleData();">
            </select></td>
          </tr>
        </table></td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1">
      <tr>
        <td colspan="3"><div id="divcons" style="overflow:scroll; height:425px; width:945px;">
            <table width="950" bgcolor="#CCCCFF" cellpadding="0" cellspacing="1" id="tblschedule">
              <tr >
			  <td width="30%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">Event</td>
                <td width="30%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">Event</td>
                <td width="10%" height="33" bgcolor="#498CC2" class="normaltxtmidb2" align="left">Estimated Date</td>
                <td width="14%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">Change Date</td>
                <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">Changed Reason</td>
                <td width="14%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">Completed Date</td>
				<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2" align="left"><input type="checkbox"   /></td>
				<td width="7%" bgcolor="#498CC2" class="normaltxtmidb2" align="left">Delay</td>
              </tr>
   
            </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
		<td>
			<table>
				<tr>
					<td width="20px" style="background:#CCFF33;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td class="normalfnt">Completed Events</td>
					<td width="20px"></td>
					<td width="20px" style="background:#FF6633;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td class="normalfnt">Delayed Events</td>
					<td width="20px"></td>
					<td width="20px" style="background:#FFFFFF;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td class="normalfnt">Pending Events</td>
					<td width="20px"></td>
					<td width="20px" style="background:#7A7AFF;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td class="normalfnt">Today Pending Events</td>
					<td width="20px"></td>
					<td width="20px" style="background:#FFFFCC;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td class="normalfnt">To Be Completed In Next 2 Days </td>
					<td width="20px"></td>
				</tr>	
			</table>	
		</td>  
  </tr>
  <tr>
    <td bgcolor="#D6E7F5"><table width="100%" border="0">
      <tr>
        <td width="21%" id="tdStatus" class="normalfntMid" style="color:#FF0000"></td>
        <td width="9%"><span class="normalfntp2"><img src="../images/save.png" alt="Save" width="84" height="24" class="mouseover" onclick="SaveEventSchedule();" id="butSave"/></span></td>
        <td width="19%"><span class="normalfntp2"><img src="../images/send2app.png" alt="SendToApprove" class="mouseover" id="butSendToApprove" name="butSendToApprove" onclick="SendToApproval();"/></span></td>
        <td width="12%"><span class="normalfntp2"><img class="mouseover" onClick="showReportMenu();" src="../images/report.png" alt="report" width="108" height="24" /></span></td>
        <td width="11%"><div align="center"><a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0" /></a></div></td>
        <td width="17%"><img src="../images/addsmall.png" alt="add" width="95" height="24" onclick="showAddItemPopUp();" /></td>
        <td width="11%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<div id="divReport" style="background-color: #999999;position:absolute;width:200px;left:580px;top:515px;visibility:hidden;">
<table>	
				<tr>
					<td width="20px" style="background:#FF6633;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td class="normalfnt mouseover" onClick="openReport('critical');">Critical Events</td>
					<td width="20px"></td>
				</tr>	
				<tr>
					<td width="20px" style="background:#CCFF33;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td class="normalfnt mouseover" onClick="openReport('completed');">Completed Events</td>
					<td width="20px"></td>
				</tr>	
				<tr>
					<td width="20px" style="background:#FFFFFF;border: 1px solid #333333;">&nbsp;</td>
					<td width="5px"></td>
					<td class="normalfnt mouseover" onClick="openReport('revised');">Due Date Revised</td>
					<td width="20px"></td>
				</tr>	
  </table>	
</div>

<div id="divAddItem" style="background-color: #999999;position:absolute;width:272px;left:682px;top:502px;visibility:hidden;border: 1px solid #333333">
<table width="268">	
				<tr>
					<td width="31"  class="normalfnt">Event</td>
					<td width="10"></td>
				  <td width="216" class="normalfnt mouseover"><select name="cboEvent" class="txtbox" id="cboEvent" style="width:200px">
				  <option value="Select One">Select One</option>
				<?php
				
				$sql = "select intEventID,strDescription from events order by strDescription";
				
				$result = $db->RunQuery($sql);
				
				
				while($row = mysql_fetch_array($result))
				{
				echo "<option value=\"". $row["intEventID"] ."\">" . $row["strDescription"] ."</option>" ;
				}
				
				?>
	 		</select>
	</td>
				</tr>	
				<tr>
					<td width="31"  class="normalfnt">Offset </td>
					<td width="10"></td>
					<td class="normalfnt mouseover"><input type="text" class="txtbox" id="txtOffSet" name="txtOffSet" size="15" /></td>
				</tr>	
				<tr>
					<td colspan="3" style="text-align:center;background:#D6E7F5"><img src="../images/ok.png" alt="ok" class="mouseover" onclick="AddNewItemToPage();"/></td>
				</tr>	
  </table>	
</div>
</body>
</html>
