<?php
session_start();
$backwardseperator = "../../";
$companyId  	= $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General Material Requisition</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

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
<script src="genMRNScript.js" type="text/javascript"></script>
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

<body onload="loadMRNForm(
<?php 	
$id = $_GET["id"];
if($id!=0)
{
	$mrnno = $_GET["genMRNno"] ;
	//echo "'$mrnno'" ; echo "," ; echo $_GET["intYear"] ; echo "," ; echo $_GET["intStatus"];
	echo $mrnno.','.$_GET["intYear"].','.$_GET["intStatus"];
}
else
	echo "0,0,99";
?> );">

<form name="frmMrn" id="frmMrn">
<?php
		  include "../../Connector.php"; 
?>
<table width="100%" align="center">
<tr><td><?php include '../../Header.php';  ?></td></tr>
<tr><td>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td></td>
  </tr>
  <tr>
    <td height="26" colspan="2" class="mainHeading" >General Material Requisition</td>
  </tr>
  <tr>
  <td><table width="100%" border="0" class="bcgl1">
   <tr>
        <td width="100%"><table width="100%" border="0" cellpadding="2"  class="bcgl1" >
      <tr>
        <td width="8%" class="normalfnt">MRN No</td>
        <td width="15%" class="normalfnt"><label id="txtStyleNo">
          <input name="txtReqNo" type="text" class="txtbox" style="text-align:center" id="txtReqNo" size="20" disabled="disabled" readonly="true" />
        </label></td>
        <td width="10%" class="normalfnt">Requested By</td>
        <td width="29%" class="normalfnt"><input name="txtrequestedby" type="text" class="txtbox" id="txtrequestedby" size="20" value="<?php 		
		$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
		$result = $dbheader->RunQuery($SQL);
	
		while($row = mysql_fetch_array($result))
		{
			echo $row["Name"];
		}
		?>" readonly="true" /></td>
        <td width="11%" class="normalfnt">Date</td>
        <td width="27%" class="normalfnt"><label id="txtBuyerPo">
		<!--<input name="deliverydateDD" type="text" class="txtbox" id="deliverydateDD" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="<?php echo date('d/m/y');?>" />-->
		<input name="deliverydateDD" type="text" class="txtbox" id="deliverydateDD" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date ("d/m/Y") ?>"/><input type="reset" value="" class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"> 
        </label></td>
      </tr>
      <tr>
        <td class="normalfnt">Cost Center </td>
        <td colspan="3" class="normalfnt"><select name="cboCostCenter" class="txtbox" id="cboCostCenter" style="width:225px" onchange="resetGridData();">
          <option value="" selected="selected">Select One</option>
          <?php 
			 //include "../../Connector.php";
			$SQL = "select 	intCostCenterId, 
					strDescription  
					from 
					costcenters 
					where intFactoryId='$companyId'";
			$result = $db->RunQuery($SQL);		
			while($row = mysql_fetch_array($result))
			{
			echo "<option value=\"". $row["intCostCenterId"] ."\">" . $row["strDescription"] ."</option>" ;
			}
		?>
        </select></td>
        <td class="normalfnt">Department</td>
        <td class="normalfnt"><select name="cbodepartment" class="txtbox" id="cbodepartment" style="width:150px">
          <option value="" selected="selected">Select One</option>
          <?php 
			 //include "../../Connector.php";
			$SQL = "select intDepID,strDepartment from department where intStatus=1 order by strDepartment";	
			$result = $db->RunQuery($SQL);		
			while($row = mysql_fetch_array($result))
			{
			echo "<option value=\"". $row["intDepID"] ."\">" . $row["strDepartment"] ."</option>" ;
			}
		?>
        </select>        </td>
      </tr>
    </table></td>
  </tr>
  </table>
  </td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr class="mainHeading2">
        <td width="89%" >&nbsp;</td>
        <td width="11%" ><img src="../../images/add-new.png" alt="add new" name="butAddNew" id="butAddNew" width="109" height="18" onclick="createRequestItemPopUp();" /></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:320px; width:950px;">
          <table width="1000" cellpadding="2" id="mainMatGrid" cellspacing="1" bgcolor="#CCCCFF" >
            <tr class="mainHeading4">
              <td width="3%"  height="25">Del</td>
              <td width="10%" >Material</td>
              <td width="27%" >Detail</td>
              <td width="3%" >Note</td>
              <td width="9%" >Bal Qty</td>
              <td width="9%" >Qty</td>
              <td width="12%" >Asset No</td>
              <td width="8%" >GRN No </td>
              <td width="8%" >GRN Year </td>
              <td width="11%" >GL Code</td>
            </tr>           
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" class="bcgl1" >
      <tr>
        <td width="100%" height="29" align="center">
        <img src="../../images/new.png" alt="new" width="96" height="24" onclick="newPage();" />
       <img src="../../images/save.png" alt="save" width="84" height="24" onclick="saveMrn();" id="butSave"/>
       <img src="../../images/conform.png"  onclick="cofirmMRN();" id="butConfirm"/>
       <img src="../../images/report.png" width="108" height="24" onclick="ViewReport();" />
        <a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" /></a>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</td></tr>
</table>
</form>

<div style="left:500px; top:220px; z-index:10; position:absolute; width: 161px; visibility:hidden;" id="gotoMrnReport">
  <table width="180" height="65" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="60" height="27">Year</td>
            <td width="118"><select name="select4" class="txtbox" id="cboYear" style="width:50px" onchange="LoadMrnacYear();">
              <?php
	
	$SQL = "SELECT DISTINCT intMRNYear FROM matrequisition ORDER BY intMRNYear DESC;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intMRNYear"] ."\">" . $row["intMRNYear"] ."</option>" ;
	}
	
	?>
            </select></td>
            
          </tr>
         
          <tr>
            <td>Mrn No</td>
            <td><select name="select" class="txtbox" id="cboRptMrnNo" style="width:100px" onchange="showMrnReport();">
              <option value="Select One" selected="selected">Select One</option>
            </select></td>
            
          </tr>
  </table>
	
</div>
</body>
</html>
