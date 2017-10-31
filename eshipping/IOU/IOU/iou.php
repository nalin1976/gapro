<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IOU Details</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="iou.js" type="text/javascript"></script>
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

<?php
	include "../../Connector.php";	
	
				
?>
<form name="frmbom" id="frmbom" >
<table width="950" border="0" align="center" bgcolor="#ffffff">
<tr>
    <td><?php include '../../Header.php'; ?></td>
</tr>
<tr>
	<td><table width="100%" border="0">
  		<tr>
        <td height="36" colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="4%" height="24" class="normalfnt">&nbsp;</td>
            <td width="3%" class="normalfnt"><input name="radiobutton" type="radio" value="radiobutton" id="radiobutton" checked="checked" />
              <label for="radiobutton"></label></td>
            <td width="5%" class="normalfnt">Imp</td>
            <td width="2%" class="normalfnt"><input name="radiobutton" type="radio" value="radiobutton" id="radio"  disabled="disa" /></td>
            <td width="8%" class="normalfnt">Exp</td>
            <td width="9%" class="normalfnt">IOU No </td>
            <td width="13%" class="normalfnt"><select name="cboiouno"  class="txtbox" id="cboiouno" onchange="setbydelivery(this);" style="width:120px">
               <?php
				$SQL = " SELECT 	intIOUNo FROM tbliouheader WHERE intSettled=0  ";
		
				$result = $db->RunQuery($SQL);
		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intIOUNo"] ."\">" . $row["intIOUNo"] ."</option>" ;
				}
			?>
           
            </select></td>
            <td width="2%" class="normalfnt">&nbsp;</td>
            <td width="9%" class="normalfnt">Delivery No </td>
            <td width="13%" class="normalfnt"><select name="cboDelivery"  class="txtbox" id="cboDelivery" style="width:120px" onchange="setbydelivery(this);">
              <?php
				$SQL = " SELECT 	intIOUNo,intDeliveryNo FROM tbliouheader WHERE intSettled=0";
		
				$result = $db->RunQuery($SQL);
		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intIOUNo"] ."\">" . $row["intDeliveryNo"] ."</option>" ;
				}
			?>
            </select></td>
            <td width="3%" class="normalfnt">&nbsp;</td>
            <td width="6%" class="normalfnt">B/L NO </td>
            <td width="13%" class="normalfnt"><input name="txtBL" readonly="readonly" class="txtbox" id="txtBL" style="width:120px" ></td>
            <td width="10%" class="normalfnt"><img src="../../images/search.png" alt="search" width="80" height="24" onclick="LoadPo()"/></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td width="14%" class="normalfnt">Consignee</td>
        <td width="37%" class="normalfnt"><input name="txtConsignee" readonly="readonly" class="txtbox" id="txtConsignee" style="width:289px" >
        </td>
        <td width="17%" class="normalfnt">Exporter</td>
        <td width="32%" class="normalfnt"><input name="txtExporter" readonly="readonly" class="txtbox" id="txtExporter" style="width:285px" >
         
        </td>
      </tr>
      <tr>
        <td class="normalfnt">Forwader</td>
        <td class="normalfnt"><input name="txtForwader" readonly="readonly" class="txtbox" id="txtForwader" style="width:289px">
	 	</td>
        <td class="normalfnt">Wharf Clerk </td>
        <td class="normalfnt"><input name="txtClerk" class="txtbox" readonly="readonly" id="txtClerk" style="width:285px" >
          
        </td>
      </tr>
      <tr>
        <td class="normalfnt">Vessel / Flight </td>
        <td class="normalfnt"><table width="89%" cellspacing="0">
          <tr>
            <td width="32%"><input name="txtVessel" type="text" class="txtbox" id="txtVessel" readonly="readonly" size="15" /></td>
            <td width="27%">No Of PKGS </td>
            <td width="41%"><input name="txtPKGS"  type="text" class="txtbox" id="txtPKGS" readonly="readonly" size="14" /></td>
            </tr>
        </table></td>
        <td class="normalfnt">Merchandiser</td>
        <td class="normalfnt"><table width="100%" readonly="readonly" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="44%"><input name="txtMerchandiser" type="text" readonly="readonly" class="txtbox" id="txtMerchandiser" size="15" /></td>
            <td width="17%">LC # </td>
            <td width="39%"><input name="txtLC" type="text" readonly="readonly" class="txtbox" id="txtLC" size="14" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="normalfnt">Reason For Dupplicate </td>
        <td class="normalfnt"><input name="txtReason" readonly="readonly" type="text" class="txtbox" id="txtReason" style="width:289px" /></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="normalfnth2"><span id="txtHint" style="color:#FFFFFF">Expenses</span></td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt"></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons"  style="overflow:scroll; height:230px; width:950px;">
          <table width="935" cellpadding="0" cellspacing="1" bgcolor="#9BBFDD" id="tbliou">
            <tr>
              <td width="2%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Id</td>
              <td width="19%" bgcolor="#498CC2" class="normaltxtmidb2">Expense</td>
			  <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Estimate</td>
              <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Actual</td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Ex / short </td>
			  <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Invoice</td>
			  <!--          </tr>
              <td  height="80" class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
			  <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td colspan="3"    class="normaltxtmidb2"><img src="../../images/loading5.gif" width="100" height="100" border="0"  /></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
           </tr>-->
          </table>
        </div></td>
        </tr>
        
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        
        <td width="12%" align="center" onclick="updateiou('settle');" ><table class="mouseover"><tr><td><img src="../../images/eok.png" alt="new" name="butSettle" width="16" height="16"   id="butSettle" /></td><td><div id="divstl">Settle</div></td></tr></table></td> 
			
			<td width="11%">&nbsp;</td>    	
        <td width="11%"><img src="../../images/new.png" alt="new" name="butNew" width="84" height="24" class="mouseover"  id="butNew" onclick="frmReload();"/></td>
        <td width="11%"><img src="../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="updateiou('save');" /></td>
        <td width="11%"><img src="../../images/cancel.jpg" alt="Cancel" name="butCancel" width="84" height="24" class="mouseover" id="butCancel" onclick="frmReload();"/></td>
        <td width="11%"><img src="../../images/report.png" name="butReport" width="84" height="24" class="mouseover" id="butReport"  onclick="printthis();"/></td>
        <td width="11%"><a href="../../main.php"><img src="../../images/close.png" width="84" height="24" border="0" class="mouseover" /></a></td>
        <td width="11%">&nbsp;</td>    
      </tr>
    </table></td>
  </tr>
</table>
</form>
<div class="tablezRED"  style="left:90px; top:252px; z-index:10;  width: 530px; visibility:hidden; height: 100px;" id="confirmReport">
<table style="background-color:#F8DDB6" width="528" height="96" border="0" cellpadding="0" cellspacing="0" class="normalfnt">

<tr>
<td colspan="7">
		<div class="normalfnt2bldBLACKmid" style=" background-color:#ccff33;" >IOU Settlement</div></td></tr>
        <tr> <td colspan="7">&nbsp;</td>
</tr>		
		<tr>
		<td>&nbsp;</td>
	    <td>Amount Released (Rs.) </td>
	    <td><input name="txtEstim" type="text" class="txtbox" id="txtEstim" style="text-align:right;" size="15" maxlength="15" disabled="disabled" /></td>
	    <td>&nbsp;</td>
	    <td colspan="2">Actual Cost (Rs) </td>
	    <td><input name="txtAct" type="text" class="txtbox" id="txtAct" style="text-align:right;" size="15" maxlength="15" disabled="disabled"/></td>
	</tr>
	<tr>
	 <td width="12" height="28">&nbsp;</td>
	    <td width="134">Balance (Rs) </td>
	    <td width="102"><input name="txtBalance" type="text" class="txtbox" id="txtBalance" style="text-align:right;" size="15" maxlength="15" disabled="disabled" /></td>
	 <td width="14"></td>
	     <!-- <td colspan="2">Recived From wharf Cleark </td>-->
	    <td colspan="2"><div id="divbalance" align="left"  >&nbsp;</div></td>
	    <!--<td width="108"><input name="txtDeliveryNo3" type="text" class="txtbox" id="txtDeliveryNo3" " size="15" maxlength="15" disabled="disabled" />--></td>
	</tr>
	<tr>
     <td>&nbsp;</td>
	  <td>Setting Date </td>
	  <td><input name="txtSettingDate" type="txtDate" class="txtbox" id="txtSettingDate"  size="15" maxlength="15" disabled="disabled" /></td>
	  <td>&nbsp;</td>
	  <td colspan="2">&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
     <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td width="95">&nbsp;</td>
	  <td width="55"><table class="mouseover" onclick ="dosettle();"><tr><td ><img src="../../images/eok.png" alt="Ok" name="btnOk" width="16" height="16"  id="butOk" /></td><td class="normalfnt">Ok</td></tr></table>
	  <td align="right"><table class="mouseover" onclick ="closePOP();" ><tr><td ><img src="../../images/eclose.png" alt="Cancel" name="butCancel" width="16" height="16"  id="butCancel" /></td><td class="normalfnt">Cancel</td></tr></table>
    </tr>

 
</table>
</div>
<div style="  width: 200px; visibility:hidden; height:70 2px;" id="savingprogress" >
<table border=0><tr><td height="55" align="center"><h3>Saving......</h3></td></tr></table>
</div>
</body>
</html>


