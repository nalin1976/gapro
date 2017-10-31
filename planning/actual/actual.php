<?php
$backwardseperator = "../../";
session_start();
$intCompanyId =$_SESSION["FactoryID"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Actual Production Entry</title>

<link href="../../Seasons/css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="actual.js"></script>

<link href="../css/planning.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css">
<script src="../../calendar/calendar.js" type="text/javascript" language="javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../js/jquery-1.js" type="text/javascript"></script>
<script src="../js/jquery-ui-1.js" type="text/javascript"></script>
<script language="javascript" src="time_picker_files/mootools.v1.11.js"></script>
<script language="javascript" src="time_picker_files/nogray_time_picker_min.js"></script>

<script language="javascript">
	
	window.addEvent("domready", function (){
		(function($) { 
			var tp1 = new TimePicker('time1_picker', 'actual_time1', 'time1_toggler', {format24:true}, { clockSize:{width:30, height:30}});
			var tp2 = new TimePicker('time2_picker', 'actual_time2', 'time2_toggler', {format24:true}, { clockSize:{width:30, height:30}});
		 })(jQuery);
	});

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

<!--<style>
	* {font-family:Arial, Helvetica, sans-serif;
		font-size:9pt;}
		
	/* table list */
	.table_list {border-collapse:collapse;
		border:solid #cccccc 1px;
		width:100%;}
	
	.table_list td {padding:5px;
		border:solid #efefef 1px;}
	
	.table_list th {background:#75b2d1;
		padding:5px;
		color:#ffffff;}
	
	.table_list tr.odd {background:#e1eff5;}
	
	.time_picker_div {padding:5px;
		border:solid #999999 1px;
		background:#ffffff;}
		
</style>-->

</head>

<body>
<?php
include "../../Connector.php";
?>
<form id="frmbanks" name="form1" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="*">&nbsp;</td>
        <td width="500"><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="35" bgcolor="#498CC2" class="mainHeading">Actual Production Entry</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0">
                <td class="normalfnt"><table width="100%" border="0" class="">
                	<tr>
                      <td class="normalfnt" >&nbsp;</td>
                      <td height="3">&nbsp;</td>
                      <td height="3">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="normalfnt" width="30">&nbsp;</td>
                      <td class="normalfnt">Date</td>
                      <td><input name="txtValidFrom" type="text"  class="txtbox" id="txtValidFrom" size="10" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                      </tr>
                    <tr>
                      <td class="normalfnt" >&nbsp;</td>
                      <td height="3" colspan="2">
                      	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="102">Start Time:</td>
                              <td width="92"><input type="text" name="actual_time1" id="actual_time1" value="00" style="width:18px;" size="2" maxlength="2" onkeypress="return isNumberKey(event);" onblur="checkTime(this);"/><span >:</span>
							  <input type="text" name="actual_time1Min" id="actual_time1Min" value="00" style="width:18px;" size="2" maxlength="2" onkeypress="return isNumberKey(event);" onblur="checkTime(this);" /> 
							  <i>24h</i> <!--<a href="#" id="time1_toggler">pick time</a>
<div id="time1_picker" class="time_picker_div"></div>--></td>
                              <td width="60">End Time:</td>
                              <td width="140"><input type="text" name="actual_time2" id="actual_time2" value="00" style="width:18px;" size="2" maxlength="2" onkeypress="return isNumberKey(event);" onblur="checkTime(this);"/><span >:</span>
							   <input type="text" name="actual_time2Min" id="actual_time2Min" value="00" style="width:18px;" size="2" maxlength="2" onkeypress="return isNumberKey(event);" onblur="checkTime(this);" />
							    <!--<a href="#" id="time2_toggler">pick time</a>
<div id="time2_picker" class="time_picker_div"></div>--><i>24h</i></td>  
								<td width="*">&nbsp;</td>                            
                            </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                    	<td class="normalfnt" >&nbsp;</td>
                      <td width="21%" >Team</td>
                      <td><select onchange="loadStyle();" name="actual_cboTeam" class="txtbox" id="actual_cboTeam"  style="width:200px">
                        <?php
							
							$SQL="SELECT DISTINCT ps.intTeamNo,pt.strTeam FROM plan_stripes ps,plan_teams pt
WHERE ps.intTeamNo=pt.intTeamNo ORDER BY intTeamNo;";
							
							$result = $db->RunQuery($SQL);
							echo "<option>" . "" ."</option>" ;
							while($row = mysql_fetch_array($result))
							{
									echo "<option value=\"". $row["intTeamNo"] ."\">" . $row["strTeam"] ."</option>" ;
							}
					?>
                      </select></td>
                      </tr>      
                      <tr>
                    	<td class="normalfnt" >&nbsp;</td>
                      <td >Style</td>
                      <td><select name="actual_cboStyle" onchange="loadStripe();" class="txtbox" id="actual_cboStyle"  style="width:200px">
					 
					  </select></td>
                      </tr>
					  <tr>
                    	<td class="normalfnt" >&nbsp;</td>
                      <td >Stripe</td>
                      <td><select name="actual_cboStripe" class="txtbox" id="actual_cboStripe"  style="width:200px" onchange="loadFullQuantity();">
					  
					  
					  </select></td>
                      </tr> 
					  
					  <tr>
                      <td >&nbsp;</td>
                      <td height="3">Left Quantity</td>
                      <td height="3"><input name="txt_leftQty" value="" size="11" maxlength="11" type="text" id="txt_leftQty" disabled="disabled" style="background-color:#CCCCCC; text-align:right" /></td>
                    </tr> 
					  
					  
                      <tr>
                      <td >&nbsp;</td>
                      <td height="3">Produced Qty</td>
                      <td height="3"><input name="actual_txtProducedQty" value="" size="11" maxlength="11" type="text" id="actual_txtProducedQty" style="text-align:right" /></td>
                    </tr>   
                    <tr>
                      <td >&nbsp;</td>
                      <td height="3">SMV</td>
                      <td height="3"><input name="actual_txtSMV" value="" size="11" maxlength="11"  type="text" id="actual_txtSMV" style="text-align:right" /></td>
                    </tr>   
                    <tr>
                      <td >&nbsp;</td>
                      <td height="3">No. Of Workers</td>
                      <td height="3"><input name="actual_txtWorkers" value="" size="11" maxlength="11"  type="text" id="actual_txtWorkers" style="text-align:right" /></td>
                    </tr>
                    <tr>
                      <td >&nbsp;</td>
                      <td height="3">No. Of Working Mins</td>
                      <td height="3"><input name="actual_txtWorkingMins" value="" size="11" maxlength="11"  type="text" id="actual_txtWorkingMins" style="text-align:right" /></td>
                    </tr>
                     <tr>
                      <td class="normalfnt" >&nbsp;</td>
                      <td height="3">&nbsp;</td>
                      <td height="3">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="100%" bgcolor=""><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td width="25%">&nbsp;</td>
                      <td width="100"><img src="../../images/new.png" class="mouseover" alt="New" name="New" onclick="ClearForm();"width="96" height="24" /></td>
                      <td width="90"><img src="../../images/save.png" class="mouseover" alt="Save" name="Save" onclick="validateData()"width="84" height="24" /></td>
                     <!-- <td width="100"><img src="../../images/delete.png" class="mouseover" alt="Delete" name="Delete" onclick="ConfirmDelete(this.name);"width="100" height="24" /></td>
					  <td width="100" class="normalfnt"><img src="../../images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="loadReport();"  /></td> -->
                      <td width="100"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                      <td width="25%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="*">&nbsp;</td>
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
