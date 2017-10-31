<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php"; 
include "{$backwardseperator}authentication.inc";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>Wash Receive</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="washReceive.js" type="text/javascript"></script>

<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>

<script type="text/javascript">
function dateInDisable(obj)
{
	if(obj.checked){
		document.getElementById('machineLoading_dateIn').disabled=false;
		<?php
		
		?>
	}
	else{
		document.getElementById('machineLoading_dateIn').disabled=true;
	}
}

function dateOutDisable(obj)
{
	if(obj.checked){
		document.getElementById('machineLoading_dateOut').disabled=false;
	}
	else{
		document.getElementById('machineLoading_dateOut').disabled=true;
	}
}


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

<?php 
$id = $_GET["id"];
$year = $_GET["intYear"];
$serial = $_GET["SerialNumber"];
?>

<body  <?php if($id!=0){?>onload="loadInputFrom(<?php echo $year; echo "," ; echo $serial;?>)" <?php }?> >

<form id="frmWashReceive" name="frmWashReceive">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Wash Receive</div></div>
<div class="main_body">
<table width="600" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td>
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="">  
    <tr>
      <td valign="top"><fieldset class="fieldsetStyle" style="width:380px;height:150px;-moz-border-radius: 5px;">
      <table width="380" border="0">		
		<tr>
          <td class="normalfnt">Receive #</td>
          <td colspan="0"><input type="text" name="txtWashRecvNo" id="txtWashRecvNo" style="width:100px" readonly="readonly"/><input type="text" name="txtWashRecvYear" id="txtWashRecvYear" style="width:47px" readonly="readonly"/></td>
        </tr>
		
        <tr>
          <td class="normalfnt">Style No </td>
          <td colspan="0"><select name="cboStyle" class="txtbox" id="cboStyle" style="width:150px" onchange="loadColors(this.value)">
		  <option value="">Select one</option> 

		<?php
		
		$SQL="	SELECT DISTINCT o.intStyleId,o.strStyle 
				FROM orders o
				INNER JOIN was_issuedheader AS ws ON ws.intStyleId=o.intStyleId";
		
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strStyle"]."</option>";
			}
	
 	    ?>
 </select></td>
        </tr>
        <tr>
          <td class="normalfnt">Order No </td>
          <td colspan="0"><select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:150px" onchange="loadColors(this.value)">
		  <option value="">Select one</option> 

		<?php
		
		$SQL="	SELECT DISTINCT o.intStyleId,o.strOrderNo 
				FROM orders o
				INNER JOIN was_issuedheader AS ws ON ws.intStyleId=o.intStyleId";
		
			$result =$db->RunQuery($SQL);
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			}
	
 	    ?>
 </select></td>
        </tr>
        <tr>
          <td class="normalfnt">Color</td>
          <td colspan="0">
          <select name="cboColor" id="cboColor" style="width:150px" onchange="loadData(this.value)">
          	<option value="">Select One</option>
          </select>
          </td>
        </tr>
		
        <tr>
          <td class="normalfnt">Factory</td>

 <td colspan="0"><input type="text" name="txtFactory" id="txtFactory" style="width:150px"/></td>
        </tr>
         <tr>
        	<td colspan="4">
            </td>
        </tr>
      </table>
      </fieldset></td>
      <td width="400" valign="top"><fieldset style="width:380px;height:150px;-moz-border-radius: 5px;" class="fieldsetStyle">
      <table width="380" border="0" cellpadding="0" cellspacing="1" >
        <tr>
          <td width="138"  class="normalfnt"><div align="left">
              <!--<input  type="checkbox" name="machineLoading_chkDateIn" id="machineLoading_chkDateIn"  onclick="dateInDisable(this);"/>-->
            Date</div></td>
          <td width="239"  class="normalfnt"><input name="washRcvDate" type="text" class="txtbox" id="washRcvDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  /><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/>
		  
<input type="hidden" name="txtYear" id="txtYear" value="<?php echo date(Y); ?>" /><input type="hidden" name="txtUser" id="txtUser" value="<?php echo $_SESSION["UserID"] ?>" />		  </td>
        </tr>
        <tr>
          <td class="normalfnt">Style</td>
          <td><input type="text" name="txtStyle" id="txtStyle" style="width:150px" readonly=""/></td>
        </tr>
        <tr>
          <td class="normalfnt">Order No</td>
          <td><input type="text" name="txtOrderNo" id="txtOrderNo" style="width:150px" readonly=""/></td>
        </tr>
        <tr>
          <td class="normalfnt">PO Qty</td>
          <td width="153"><input type="text" name="txtPoQty" id="txtPoQty" style="width:150px" readonly=""/></td>
        </tr>
        <tr>
          <td class="normalfnt">Wash Qty</td>
          <td><input type="text" name="txtWashQty" id="txtWashQty" style="width:150px" readonly=""/></td>
        </tr>
        <tr>
          <td class="normalfnt">Receive Qty</td>
          <td><input type="text" name="txtRcvQty" id="txtRcvQty" style="width:150px"  onkeypress="return isNumberKey(event);"/><input type="hidden" name="txtExistQty" id="txtExistQty" style="width:150px" readonly="" value="0"/></td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      </fieldset>
      </td>
    </tr>
    <tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
      	<td colspan="2">
            <table align="right" border="0" class="tableFooter" width="100%">
                <tr>
				<td width="32%"></td>
                    <td width="12%">
                    <img src="../../images/new.png" alt="new"  width="84" height="24" border="0" onclick="ClearForm();" />
					</td>
                    <td width="12%">
                    <img src="../../images/save.png" alt="save" width="84" height="24" border="0" onclick="saveWashRvc();"/>
					</td>
                    <td width="12%">
                    <a href="../../main.php">
                    <img src="../../images/close.png" alt="close" width="84" height="24" border="0"/>
                    </a>
                    </td>
					<td width="32%"></td>
                </tr>
            </table>
        </td>
	</tr>


</table>
    </form>
</body>
</html>

        
        