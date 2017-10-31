<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php"; 
$StyleNo	=	$_REQUEST['StyleNo'];
$rootCard	=	$_REQUEST['rootCard'];
$RootYear	=	$_REQUEST['RootYear'];
$status		=	$_REQUEST['status'];
if(!isset($StyleNo))
{	
	$StyleNo=0;
}
if(!isset($RootYear))
{	
	$RootYear=0;
}

if(!isset($rootCard))
{	
	$rootCard=0;
}
if(!isset($status))
{	
	$status=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>Machine Loading Monitoring</title>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<style>
/* TimeEntry styles */
.timeEntry_control {
	vertical-align: middle;
	margin-left: 3px;
}
* html .timeEntry_control { /* IE only */
	margin-top: -4px;
}

</style>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="machineLoading.js" type="text/javascript"></script>
<script src="machineLoading_outside.js" type="text/javascript"></script>

<script type="text/javascript">



function dateInDisable(obj)
{
	if(obj.checked){
		document.getElementById('machineLoading_dateIn').disabled=false;
		
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


function checkInHours(value){
if(value>12){
  alert("Please use 12 hour time format only");
  document.getElementById('machineLoading_TimeInHours').value="";
  
 }
}

function checkInMinutes(value){

 if(value>60){
  alert("Please enter valid minutes");
  document.getElementById('machineLoading_TimeInMinutes').value="";
  }
  
  if(value == 60){
  var TimeInHours = document.getElementById('machineLoading_TimeInHours').value;

   if(TimeInHours == 12){
   document.getElementById('machineLoading_TimeInHours').value = "1";
   }else{
     TimeInHours = (TimeInHours*1 + 1*1);
  document.getElementById('machineLoading_TimeInHours').value = TimeInHours;
  }
  document.getElementById('machineLoading_TimeInMinutes').value="00";
  }
}

function checkOutHours(value){
if(value>12){
  alert("Please use 12 hour time format only");
  document.getElementById('machineLoading_TimeOutHours').value="";
  
 }
}

function checkOutMinutes(value){
 if(value>60){
  alert("Please enter valid minutes");
  document.getElementById('machineLoading_TimeOutMinutes').value="";
  }
  if(value == 60){
  var TimeInHours = document.getElementById('machineLoading_TimeOutHours').value;

   if(TimeInHours == 12){
   document.getElementById('machineLoading_TimeOutHours').value = "1";
   /*
   var ampm = document.getElementById('machineLoading_TimeOutAMPM').options[0].text;
   if(ampm=="AM"){
   document.getElementById('machineLoading_TimeOutAMPM').options[0].text = "PM";
   document.getElementById('machineLoading_TimeOutAMPM').options[1].text = "AM";
   }else{
    document.getElementById('machineLoading_TimeOutAMPM').options[0].text = "AM";
	document.getElementById('machineLoading_TimeOutAMPM').options[1].text = "PM";
   }*/
   }else{
     TimeInHours = (TimeInHours*1 + 1*1);
  document.getElementById('machineLoading_TimeOutHours').value = TimeInHours;
  }
  document.getElementById('machineLoading_TimeOutMinutes').value="00";
  }
}
$(function () {
	$('#machineLoading_txtTimeIn').timeEntry({spinnerImage: 'spinnerDefault.png'});
	$('#machineLoading_txtTimeOut').timeEntry({spinnerImage: 'spinnerDefault.png'});
});
function checkWash(obj)
{

	if(obj=="machineLoading_Rewash")
	{
		$("#divRewashCmb").show(500);
	}
	else
	{
		$("#divRewashCmb").hide(500);
	}
}
</script>
</head>

<body onload="loadMachineLoadingLoad(<?php echo $StyleNo; ?>,<?php echo $rootCard;?>,<?php echo $RootYear;?>,<?php echo $status;?>);">

<form id="machineLoading" name="machineLoading" method="post" action="">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<!--<div class="main_bottom_center">
	<div class="main_top">
    <div class="main_text">Machine Loading Monitoring</div></div>
<div class="main_body">-->
<script type="text/javascript" src="../javascript/jquery.timeentry.js"></script>
<script type="text/javascript" src="../javascript/jquery.mousewheel.js"></script>
<table width="780"  border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">
	<tr>
  	<td width="806" class="mainHeading">Machine Loading Monitoring</td>
  </tr>
  
  <tr>
    <td>
  <table width="767" border="0" align="center" cellpadding="0" cellspacing="0" class="normalfnt" rules="rows">
    <tr>
      <td width="421" height="28" bgcolor="#FFFFFF"><table width="200" height="30" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><font size="2"><b> Operation Value</b></font> </td>
			<td class="normalfnt">In</td>
			<td><input type="radio" name="radioMachineLoading" id="r1" checked="checked" value="0" onclick="loadMLData(this);"/></td>
			<td class="normalfnt">Out</td>
			<td><input type="radio" name="radioMachineLoading" id="r2"  value="1" onclick="loadMLData(this);"/></td>
          </tr>
      </table></td>
      
    </tr>
    <tr>
      <td colspan="2" valign="top" ><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="2%" class="normalfnt">&nbsp;</td>
          <td width="20%" class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Machine Category</td>
          <td width="33%" class="normalfnt"><select name="machineLoading_cboMachineType" class="txtbox" id="machineLoading_cboMachineType" style="width:200px;height:20px;" onchange="loadMachine(this.value);" disabled="disabled">
            <?php
		echo "<option value=\""."0"."\">" ."Select One"."</option>";
		
		$SQL="SELECT DISTINCT intMachineId,strMachineType FROM was_machinetype ORDER BY strMachineType";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\""."0"."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intMachineId"]."\">".$row["strMachineType"]."</option>";
			}
	
 	    ?>
          </select></td>
          <td width="14%" class="normalfnt">Root Card No</td>
          <td width="31%" class="normalfnt"><select id="machineLoading_txtRootCardNo" name="machineLoading_txtRootCardNo" style="width:200px;" onchange="loadDetails(this);">
            <option value="">Select One</option>
            <?php 
				$sql="SELECT concat(was_rootcard.intRYear,'/',was_rootcard.dblRootCartNo)  AS ROOTCARD FROM was_rootcard WHERE was_rootcard.intFactory =  '".$_SESSION['FactoryID']."' ORDER BY
concat(was_rootcard.intRYear,'/',was_rootcard.dblRootCartNo) ASC";
				$res=$db->RunQuery($sql);
				while($row=mysql_fetch_assoc($res)){
					echo "<option value=\"".$row['ROOTCARD']."\">" .$row['ROOTCARD']."</option>";
				}
				?>
          </select></td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Machine</td>
          <td class="normalfnt"><select name="machineLoading_cboMachine" class="txtbox" id="machineLoading_cboMachine" style="width:200px;height:20px;" onchange="loadMachineOperator(this.value),loadLoatNumber(this);">
            <option></option>
            <?php
		/*
		$SQL="SELECT was_machine.intMachineId,was_machine.strMachineName FROM was_machine ORDER BY strMachineName";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intMachineId"]."\">".$row["strMachineName"]."</option>";
			}
	*/
 	    ?>
          </select></td>
          <td class="normalfnt">PO No</td>
          <td class="normalfnt"><select name="machineLoading_cboPoNo" class="txtbox" id="machineLoading_cboPoNo" style="width:200px;height:20px;" onchange="loadStyleName(this.value);">
            <?php
		
		/*$SQL="SELECT  distinct orders.intStyleId,orders.strOrderNo 
			  FROM orders INNER JOIN was_actualcostheader ON orders.intStyleId=was_actualcostheader.intStyleId 
			  WHERE was_actualcostheader.intStatus=1 ORDER BY orders.strStyle";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			}
	
*/ 	    ?>
          </select></td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Machine Operator Name</td>
          <td class="normalfnt"><select name="machineLoading_cboMachineOperator" class="txtbox" id="machineLoading_cboMachineOperator" style="width:200px;height:20px;">
          </select></td>
          <td class="normalfnt">Cost Id</td>
          <td class="normalfnt"><select name="machineLoading_cboCostId" class="txtbox" id="machineLoading_cboCostId" style="width:200px;height:20px;" onchange="loadCostID(this.value);">
            <?php
		echo "<option value=\"".""."\">" .""."</option>";
		/*
		$SQL="SELECT  intStyleId,strDescription from orders ORDER BY strDescription";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strDescription"]."</option>";
			}
	*/
 	    ?>
          </select></td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Shift</td>
          <td class="normalfnt"><select name="machineLoading_cboShift" class="txtbox" id="machineLoading_cboShift" style="width:200px;height:20px;">
            <?php
		
		$SQL="SELECT  DISTINCT intShiftId,strShiftName from was_shift WHERE intStatus!=10 ORDER BY strShiftName";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intShiftId"]."\">".$row["strShiftName"]."</option>";
			}
	
 	    ?>
          </select></td>
          <td class="normalfnt">Lot No</td>
          <td class="normalfnt"><input type="text" name="machineLoading_txtLotNo" id="machineLoading_txtLotNo" style="width:130px;text-align:right;" value="1" class="txtbox"  onkeypress="return CheckforValidDecimal(this.value, 0,event);" readonly="readonly"/><input type="hidden"  id="machineLoading_txtBatchId" name="machineLoading_txtBatchId" value=""/></td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Date In</td>
          <td class="normalfnt"><input name="machineLoading_dateIn" type="text" class="txtbox" id="machineLoading_dateIn" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo date('Y-m-d'); ?>"  /><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/></td>
          <td class="normalfnt">Qty</td>
          <td class="normalfnt"><input type="text" id="machineLoading_Qty" name="machineLoading_Qty" style="width:130px;text-align:right;" class="txtbox" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="controlMachingLoadingQty(this);"/><input type="hidden"  id="machineLoading_Qty_hdn" name="machineLoading_Qty_hdn" value=""/></td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Date Out</td>
          <td class="normalfnt"><input name="machineLoading_dateOut" type="text" class="txtbox" id="machineLoading_dateOut" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo date('Y-m-d'); ?>"  /><input name="reset2" id="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/></td>
          <td class="normalfnt">Lot Weight</td>
          <td class="normalfnt"><input type="text" name="machineLoading_LotWeight" id="machineLoading_LotWeight" style="width:130px;text-align:right; " class="txtbox" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Wash Type</td>
          <td class="normalfnt" id="washtype" title=""><input type="text" class="txtbox" name="machineLoading_txtWashType" id="machineLoading_txtWashType" size="23" maxlength="23" readonly="readonly"/></td>
          <td class="normalfnt">Time In</td>
          <td class="normalfnt"><input type="text" class="txtbox" id="machineLoading_txtTimeIn" style="width:130px;" /></td>
        </tr>
        <tr>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Color</td>
          <td class="normalfnt"><input type="text" class="txtbox" name="machineLoading_txtColor" id="machineLoading_txtColor" size="23" maxlength="23" readonly="readonly"/></td>
          <td class="normalfnt">Time Out</td>
          <td class="normalfnt"><input type="text" class="txtbox" id="machineLoading_txtTimeOut" style="width:130px;" /></td>
        </tr>
        <tr>
          <td colspan="2" class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
        </tr>
      </table></td>
      </tr>
    <tr valign="top" >
      <td height="25" align="center"><table width="99%" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td width="59"><input name="machineLoading_Status" type="radio" id="machineLoading_Pass" checked="checked" value="1" onclick="checkWash(this.id);"/>
              Pass </td>
            <td width="59"><input name="machineLoading_Status" type="radio" id="machineLoading_Fail" value="0" onclick="checkWash(this.id);"/>
              Fail</td>
			 <td width="93"><input name="machineLoading_Status" type="radio" id="machineLoading_Rewash" value="5" onclick="checkWash(this.id);"/>
Rewash</td>
			 <td width="180">
             <div id="divRewashCmb" style="display:none">
			   <select name="cboRewash" id="cboRewash" class="txtbox" style="width:150px">
               <option value="">Select One</option>
               <option value="S">Semi Rewash</option>
               <option value="F">Full Rewash</option>
			     </select>
             </div></td>
          </tr>
      </table></td>
      <td width="346"><table align="left" border="0"><tr><td>
      <img src="../../images/new.png" alt="new"  width="84" height="24" border="0" onclick="Clear();"/>
      <img src="../../images/save.png" alt="save" width="84" height="24" border="0" onclick="saveMachineLoadHeader();"/>
      <!--<img src="../../images/view.png" alt="save" width="84" height="24" border="0" onclick="viewMachineLoading()"/>-->
      <img src="../../images/print.png" alt="print" width="84" height="24" border="0" onclick="printPoAvailable();"  style="display:none;"/>
      <img src="../../images/close.png" alt="close" width="84" height="24" border="0" onclick="closeWindow();"/></td></tr></table></td>
    </tr>
    <tr style="display:none">
      <td height="30" colspan="2">
        <table width="719" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td width="86"  class="normalfntMid">Order Qty</td>
			<td width="86"><input type="text" size="10" id="txtOQty"  readonly="readonly" style="text-align:right;"/></td>
            <td width="120"  class="normalfntMid">Tot Receive Qty</td>
			<td width="86"><input type="text" id="txtTRQty" size="10"  readonly="readonly" style="text-align:right;"/></td>
            <td width="95"  class="normalfntMid"> Balance Qty</td>
			<td width="81"><input type="text" size="10" id="txtBalQty" readonly="readonly" style="text-align:right;"/></td>
            <td width="64"  class="normalfntMid">Wash Qty</td>
			<td width="92"><input type="text" size="10" id="txtWQty" readonly="readonly" style="text-align:right;"/></td>


          </tr>
        </table>
      </td>
    </tr>
  </table>  
    </td>  
</table>
<!--</div>
 </div>-->
</form>
</body>
</html>
