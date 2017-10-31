<?php
 session_start();
 include "../../Connector.php";
 $intCompanyId		=$_SESSION["FactoryID"];
 //echo $intCompanyId;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Change Working Time </title>

<link href="../css/planning.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../javascript/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>

<script src="plan-js.js" type="text/javascript"></script>
<script type="text/javascript" src="popupMenu.js"></script>

<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
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
</head>  

<body >

<table width="472" height="243" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="cursercross"  onmousedown="grab(document.getElementById('changeTimePopUp'),event);">
            <td width="852" height="30" bgcolor="#498CC2" class="mainHeading">Change Working Hours</td>
  </tr>
  <tr>
    <td><table width="59%" border="0">
      <tr>
        <td width="88%" height="58">
		<table width="59%" border="0">
      <tr>
        <td valign="top" >
          <table width="460" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="571">
          
              <table width="100%" border="0" class="">
          <tr>
            <td width="21%" class="grid_raw"><b>Team - <span id="span_teamNo" ></span></b></td>
            </tr>
          
        </table>
       
        </td>
              </tr>
          </table>
          </td>
        </tr>
    </table>
		
		
<table width="59%" border="0">
      <tr>
        <td valign="top" >
          <table width="460" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="571">
              <fieldset style="-moz-border-radius: 5px;">
              <table width="100%" border="0" class="">
          <tr>
            <td width="21%" bgcolor="#FFFFFF" class="normalfnt">Start Date </td>
            <td width="34%" bgcolor="#FFFFFF" class="normalfnt"><input name="txt_newStartDate" type="text"  class="txtbox" id="txt_newStartDate" size="15" onclick="return showCalendar(this.id, '%Y-%m-%d');" readonly="true"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value=""  /></td>
			
            <td width="14%" bgcolor="#FFFFFF" class="normalfnt">End Date </td>
            <td width="31%" bgcolor="#FFFFFF" class="normalfnt"><input name="txt_newEndDate" type="text"  class="txtbox" id="txt_newEndDate" size="15" onclick="return showCalendar(this.id, '%Y-%m-%d');" readonly="true"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
            </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="normalfnt">&nbsp;</td>
            <td bgcolor="#FFFFFF" class="normalfnt">&nbsp;</td>
            <td bgcolor="#FFFFFF" class="normalfnt">&nbsp;</td>
            <td bgcolor="#FFFFFF" class="normalfnt">&nbsp;</td>
            </tr>
        </table>
        </fieldset>
        </td>
              </tr>
          </table>
          </td>
        </tr>
    </table>
	
	<table width="100%" border="0">
      <tr>
        <td valign="top" >
          <table width="444" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="444">
              <fieldset style="-moz-border-radius: 5px;">
              <table width="99%" border="0" class="">
          <tr>
		  <td width="6%">&nbsp;</td>
		   <td width="9%">&nbsp;
		     <input type="checkbox" id="chk_newStartTime" name="chk_newStartTime" align="right"  onchange="enableTimeTextBoxes(this);"/></td>
            <td width="39%" bgcolor="#FFFFFF" class="normalfnt">Start Time </td>
            <td width="36%" bgcolor="#FFFFFF" class="normalfnt"><input type="text" name="txt_newStartTimeH" id="txt_newStartTimeH" value="00" style="width:18px;" disabled="disabled" size="2" maxlength="2" onblur="checkTime(this);" onkeypress="return isNumberKey(event);" onkeyup="calculateNewWorkingHours();"/><span >:</span>
						    <input type="text" name="txt_newStartTimeM" id="txt_newStartTimeM" value="00" style="width:18px;" size="2" maxlength="2" onkeypress="return isNumberKey(event);" disabled="disabled" onblur="checkTime(this);" onkeyup="calculateNewWorkingHours();" /></td>
			<td width="10%">&nbsp;</td>
          </tr>
		  
		   <tr>
		  <td>&nbsp;</td>
		  <td width="9%">&nbsp;</td>
            <td width="39%" bgcolor="#FFFFFF" class="normalfnt">End Time </td>
            <td width="36%" bgcolor="#FFFFFF" class="normalfnt"><input type="text" name="txt_newEndTimeH" id="txt_newEndTimeH" value="00" style="width:18px;" size="2" disabled="disabled" maxlength="2" onkeypress="return isNumberKey(event);" onblur="checkTime(this);" onkeyup="calculateNewWorkingHours();"/><span >:</span>
						    <input type="text" name="txt_newEndTimeM" id="txt_newEndTimeM" value="00" style="width:18px;" size="2" maxlength="2" onkeypress="return isNumberKey(event);" disabled="disabled" onblur="checkTime(this);" onkeyup="calculateNewWorkingHours();" /></td>
			<td>&nbsp;</td>
          </tr>
		  
		   <tr>
		  <td>&nbsp;</td>
		  <td width="9%">&nbsp;</td>
            <td width="39%" bgcolor="#FFFFFF" class="normalfnt">Working Time</td>
            <td width="36%" bgcolor="#FFFFFF" class="normalfnt"><input  name="txt_newWorkingHours" type="text" class="txtbox" id="txt_newWorkingHours" style="text-align:right;background-color:#C7D9F3"  onkeypress="return CheckforValidDecimal(this.value,2,event);" value="" size="10" maxlength="2" readonly="true" /></td>
			<td>&nbsp;</td>
          </tr>
		   <tr>
		  <td>&nbsp;</td>
		  <td width="9%">&nbsp;
		    <input type="checkbox" id="chk_teamEfficiency" name="chk_teamEfficiency" align="right" onchange="enableEfficiencyTextBox(this);"/></td>
            <td width="39%" bgcolor="#FFFFFF" class="normalfnt">Team Efficiency</td>
            <td width="36%" bgcolor="#FFFFFF" class="normalfnt"><input type="text" class="textbox" id="txt_teamEfficiency" name="txt_teamEfficiency" size="10" disabled="disabled" onkeypress="return isNumberKey(event);" style="text-align:right" /></td>
			<td>&nbsp;</td>
          </tr>
		   <tr>
		  <td>&nbsp;</td>
		  <td width="9%">&nbsp;
		    <input type="checkbox" id="chk_noOfMachines" name="chk_noOfMachines" align="right" onchange="enableNoMachinesTextBox(this)"/></td>
            <td width="39%" bgcolor="#FFFFFF" class="normalfnt">No of Machines</td>
            <td width="36%" bgcolor="#FFFFFF" class="normalfnt"><input type="text" class="textbox" id="txt_noOfMachines" name="txt_noOfMachines" size="10" disabled="disabled" onkeypress="return isNumberKey(event);" style="text-align:right" /></td>
			<td>&nbsp;</td>
          </tr>
		   <tr>
		     <td>&nbsp;</td>
			 <td width="9%">&nbsp;</td>
		     <td bgcolor="#FFFFFF" class="normalfnt">Day Type </td>
		     <td bgcolor="#FFFFFF" class="normalfnt"><select id="cbo_dayType" disabled="disabled" name="cbo_dayType" style="width:135px">
			 <option value=""></option>
			 <option value="All">All Days</option>
			 <option value="Sa">Saturday</option>
			 <option value="Su">Sunday</option>
			 <option value="Ho">Holiday</option>
			 </select></td>
		     <td>&nbsp;</td>
		     </tr>
        </table>
		<table width="442">
		<tr>
		<td width="62">&nbsp;</td>
			<td width="136" bgcolor="#FFFFFF" class="normalfnt">Update For All Teams </td>
			<td width="18">&nbsp;</td>
			<td width="24"><input type="checkbox" id="chk_updateAllTeams" name="chk_updateAllTeams"  disabled="disabled" /></td>
			<td width="178">&nbsp;</td>
		</tr>
		<tr>
		<td width="62">&nbsp;</td>
			<td width="136" bgcolor="#FFFFFF" class="normalfnt">&nbsp;</td>
			<td width="18">&nbsp;</td>
			<td width="24">&nbsp;</td>
			<td width="178">&nbsp;</td>
		</tr>
		</table>
        </fieldset>
        </td>
              </tr>
          </table>
          </td>
        </tr>
    </table>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
			  
                <td width="70%" bgcolor=""><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td width="136">&nbsp;</td>
                      
                      
                      <td width="84"><img src="../../images/save.png" class="mouseover" alt="save"  name="save"  onclick="validateData(<?php echo $intCompanyId ?>);"  /></td>
                      <td width="97"><img src="../../images/close.png" alt="Close" name="Close"  border="0" id="Close" onclick="closeWindow();"/></td>
					  <td width="127">&nbsp;</td>
                      
                    </tr>
                </table></td>
              </tr>
            </table>	
			
		</td>
	  </tr>
	</table>
	</td>
  </tr>
</table>
		
</body>
</html>
