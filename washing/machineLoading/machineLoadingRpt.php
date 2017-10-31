<?php
session_start();
$backwardseperator = "../../";
include "{$backwardseperator}authentication.inc";
include "../../Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Machine Loading Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<link rel="stylesheet" type="text/css" href="../../js/jquery-ui-1.8.9.custom.css"/>

<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="machineLoading.js"></script>

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
<body>		

<form id="frmMachineLoading" name="frmMachineLoading" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<div class="main_bottom">
	<div class="main_top">
	  <div class="main_text">Machine Loading Reports </div>
	</div>
<div class="main_body">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="600" border="0" align="center">
      <tr>
        <td width="19%">&nbsp;</td>
        <td width="62%">
        <fieldset class="fieldsetStyle" style="width:500px;-moz-border-radius: 5px;">
        <table width="100%" border="0" class="">
          <tr>
            <td height="96">
              <table width="100%" border="0">
                <tr>
                  <td colspan="4" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="18%" height="20" align="right"><input name="rdoReport" type="radio" id="radioWash" value="0" onclick="selectReports(this);" checked="checked"/></td>
                      <td width="36%">&nbsp; Wash Report</td>
                      <td width="4%"><input name="rdoReport" type="radio" id="radioMachine" value="1"  onclick="selectReports(this);" /></td>
                      <td width="42%">&nbsp; Machine Loading Report</td>
                    </tr>
                    <tr>
                      <td width="18%" height="20" align="right"><input name="rdoReport" type="radio" id="radioWashSum" value="2" onclick="selectReports(this);"/></td>
                      <td width="36%">&nbsp; Wash Summary</td>
                      <td width="4%">&nbsp;</td>
                      <td width="42%">&nbsp;</td>
                    </tr>
                  </table></td>
                  </tr>
                <tr>
                  <td align="right">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                </tr>
                <tr>
                  <td width="19%" class="normalfnt">Date from </td>
                  <td width="35%" class="normalfnt"><input name="dateFrom" type="text" class="txtbox" id="dateFrom" size="15" value="<?php echo date("Y-m-d"); ?>"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reseta" type="text"  class="txtbox" style="visibility:hidden;width:10px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                  <td width="14%" class="normalfnt">Date to </td>
                  <td width="32%" class="normalfnt"><input name="dateTo" type="text" class="txtbox" id="dateTo" size="15" value="<?php echo date("Y-m-d"); ?>"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reseta2" type="text"  class="txtbox" style="visibility:hidden;width:10px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                </tr>
                <tr>
                  <td class="normalfnt">PO</td>
                  <td class="normalfnt"><select name="cboPO" class="txtbox" id="cboPO"  style="width:130px" tabindex="1" onchange="chaneColor();">
				  <?php
				  $sql="select distinct MH.intStyleId,OD.strOrderNo
						from was_machineloadingheader MH inner join orders OD on MH.intStyleId=OD.intStyleId
						where MH.intStatus=1;";
						$i=1;
						$result = $db->RunQuery($sql);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
							{
								echo "<option value=\"".$row["intStyleId"]."\">" . $row["strOrderNo"] ."</option>" ;
								$i++;
							}  
					?>
				  
				  </select></td>
                  <td class="normalfnt">Color</td>
                  <td class="normalfnt" id="cellColor"><select name="cboColor" class="txtbox" id="cboColor" style="width:130px" tabindex="1">
				  
				  <?php
				  $sql="select distinct strColor,intStyleId from was_machineloadingheader 
						where intStatus=1 group by strColor,intStyleId ;";
						$i=1;
						$result = $db->RunQuery($sql);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
							{
								echo "<option value=\"".$row["intStyleId"]."\">" . $row["strColor"] ."</option>" ;
								$i++;
							}  
				  ?>
				  
				  </select></td>
                </tr>
                <tr>
                  <td class="normalfnt">Shift</td>
                  <td class="normalfnt"><select name="cboShift" class="txtbox" id="cboShift"  style="width:130px" tabindex="1">
				  <?php
				  $sql="select 	intShiftId,strShiftName
						from was_shift 
						where intStatus=1;";
						
						$result = $db->RunQuery($sql);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
							{
								echo "<option value=\"".$row["intShiftId"]."\">" . $row["strShiftName"] ."</option>" ;
								
							}  
										   
				  ?>
				  
				  
				  </select></td>
                  <td class="normalfnt">Machine</td>
                  <td class="normalfnt" id="cellMachine"><select name="cboMachine" class="txtbox" id="cboMachine"  style="width:130px" tabindex="1" >
				  <?php
				  
				  $sql="select intMachineId,strMachineName
						from was_machine 
						where intStatus=1;";
						$result = $db->RunQuery($sql);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
							{
								echo "<option value=\"".$row["intMachineId"]."\">" . $row["strMachineName"] ."</option>" ;
								
							}  
				  ?>
				  
				  </select></td>
                </tr>
                <tr>
                  <td class="normalfnt">Wash Type  </td>
                  <td class="normalfnt" id="cellWash"><select name="cboWashType" class="txtbox" id="cboWashType"  style="width:130px" tabindex="1">
				  <?php
				  
				  $sql="select 	intWasID,strWasType
						from was_washtype
						where intStatus=1;";
						$result = $db->RunQuery($sql);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
							{
								echo "<option value=\"".$row["intWasID"]."\">" . $row["strWasType"] ."</option>" ;
								
							}  
				  ?>
				  </select></td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                </tr>
                
                  <tr>
                    <td colspan="3" class="normalfnt">&nbsp;<span id="txtHint" style="color:#FF0000"></span></td>
                  </tr>
                 </table>
                 </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0"class="">
              <tr>
                <td width="100%"><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td align="center"  ><img src="../../images/new.png" alt="New" name="New"
					  width="96" height="24" onclick="ClearForm();" class="mouseover"/>&nbsp;<img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="ViewMLoadingRpt();"  />&nbsp;<a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                      </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
        </fieldset>
        </td>
       <td width="19%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
 </div>
</form>
</body>
</html>
