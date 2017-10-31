<?php
	session_start();
	include "../../Connector.php";	
	$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Normal Gatepass</title>

<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="gennormalgatepassjs.js"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>


<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<link rel="stylesheet" type="text/css" href="../../js/jquery-ui-1.8.9.custom.css"/>

<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>

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



</head>
<body onload="loadDetails(
<?php 	
	$no = $_GET["No"];
	$noArray	= explode('/',$no);
	if($no!=""){
		echo $noArray[0] ; echo "," ; echo $noArray[1];		 
	}
	else
		echo "0,0";
?> );">

<form name="frmNormalGatePass" id="frmNormalGatePass">
  <tr>
    <td><?php include "${backwardseperator}Header.php"; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
   <tr>
    <td height="26" class="mainHeading">General Normal Gate Pass</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table  width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td class="normalfnt" height="25" >Gatepass No</td>
            <td class="normalfnt"><input name="txtGPNo" type="text" class="txtbox" id="txtGPNo" maxlength="11" style="width:150px;" readonly="readonly" /></td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt"><input name="podate" type="text" style="visibility:hidden;width:5px" class="txtbox" id="podate" size="15" value="<?php echo date("Y-m-d"); ?>"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input type="text" class="txtbox" style="visibility:hidden;width:5px" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
            <td class="normalfnt">Gate Pass To </td>
            <td class="normalfnt"><input name="txtGatePassTo" type="text" class="txtbox" id="txtGatePassTo" style="width:150px;" maxlength="60" /></td>
          </tr>
          <tr>
            <td width="13%" height="25" class="normalfnt">Attention</td>
            <td width="18%" class="normalfnt"><input name="txtAttention" type="text" class="txtbox" id="txtAttention" style="width:150px;" maxlength="60" /></td>
            <td width="9%" class="normalfnt">Through</td>
            <td width="24%" class="normalfnt"><input name="txtThrough" type="text" class="txtbox" id="txtThrough" style="width:150px;" maxlength="60" /></td>
            <td width="10%" class="normalfnt">Instructed By </td>
            <td width="26%" class="normalfnt"><input name="txtInstructBy" type="text" class="txtbox" id="txtInstructBy" style="width:150px;" maxlength="60" /></td>          
			<td width="0%" class="normalfnt">&nbsp;</td>
          </tr>
          <tr>       
            <td  height="25" class="normalfnt">Remarks</td>
            <td  colspan="3" class="normalfnt"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" style="width:407px;" maxlength="100" /></td>
            <td class="normalfnt">Style No</td>
            <td class="normalfnt"><input name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo" style="width:150px" maxlength="60"/></td>
  </tr>
           <tr>
            <td class="normalfnt">Special Instruction</td>
            <td colspan="3" class="normalfnt"><textarea name="txtInstructions" class="txtbox" id="txtInstructions"  rows="2"  style="width:407px" onkeypress="return imposeMaxLength(this,event, 200);"></textarea></td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
           </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr class="mainHeading2">
        <td width="89%"> <div align="center">Normal Gatepass Details</div></td>
        <td width="11%" class="normalfnt"><img src="../../images/add-new.png" alt="add new" id="addNew" width="109" height="18" onclick="OpenItemPopUp();"/></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:250px; width:950px;">
          <table id="tblNGMain" width="100%" bgcolor="#CCCCFF"  cellpadding="0" cellspacing="1" >
            <tr class="mainHeading4">
              <td width="2%" height="25">Del</td>              
			  <td width="17%" >PO No </td>			  
              <td width="53%" >Description</td>
              <td width="10%" >Quantity</td>
              <td width="10%" >Unit</td>
			  <td width="8%" nowrap="nowrap">Returnable</td>
			  </tr>
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" >

	  <tr>
        <td width="20%" id="unitbox" style="visibility:hidden;width:5px;"  height="29"><select name="cboOrderUnit" class="txtbox"  id="cboOrderUnit" style="width:92px">
<?php

$SQL = "select intUnitID, strUnit from units Order By strUnit;";
$result = $db->RunQuery($SQL);

while($row = mysql_fetch_array($result))
{
	echo "<option value=\"". $row["strUnit"] ."\">" . $row["strUnit"] ."</option>" ;
}
?>                                                
</select>
</td>
<td height="30">
<div align="center"  >
   		<img src="../../images/new.png" title="New" alt="new" width="96" height="24"  border="0" onclick="resetAll();"/> 
        <img src="../../images/save.png" title="Save" alt="save" width="84" height="24" id="Save" onclick="SaveNormalGatePass();" />
        <img src="../../images/report.png" title="Report" width="108" height="24" onclick="showReport();" />
        <img src="../../images/print.png" style="display:none" title="Print" alt="print" width="115" height="24" onclick="printReport();" />
        <a href="../../main.php"><img src="../../images/close.png" title="Go to home page" width="97" height="24" border="0" /></a>
       </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<div style="left:550px; top:285px; z-index:10; position:absolute; width:240px; visibility:hidden; " id="gotoReport" ><table width="270" height="65" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="82" height="27">State </td>
            <td width="186"><select name="select3" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpIssueNo();">              
              <option value="1">Confirm</option>             
            </select></td>
            <td width="186">Year</td>
            <td width="186"><select name="select4" class="txtbox" id="cboYear" style="width:55px" onchange="LoadPopUpIssueNo();">
             
<?php

$SQL = " SELECT DISTINCT intRetYear FROM gensupreturnheader ORDER BY intRetYear DESC;";	
$result = $db->RunQuery($SQL);		
while($row = mysql_fetch_array($result))
{

echo "<option value=\"". $row["intRetYear"] ."\">" . $row["intRetYear"] ."</option>" ;
}
?>
            </select></td>
          </tr>
          <tr>
            <td><div align="center">Return No</div></td>
            <td><select name="select" class="txtbox" id="cboRptIssueNo" style="width:100px" onchange="showReport();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		
		
</div>
</body>

</html>
 <script type="text/javascript" src="../../js/jquery.fixedheader.js"></script>