<?php 
	session_start();
	include "authentication.inc";
	include "Connector.php";
	$year=$_GET["year"];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Material Requisition</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
-->
</style>

<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="javascript/script.js" type="text/javascript"></script>
<script src="javascript/MRNScript.js?n=1" type="text/javascript"></script>
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

<body onload="LoardMRN(<?php 	
$id = $_GET["id"];
if($id!=0)
{
	echo $_GET["mrnNo"] ; echo "," ; echo $_GET["year"] ; echo "," ; echo $_GET["intStatus"]; echo "," ; echo $_GET["mainStore"];
}
else
	echo "0,0,99,0";
?>);">
<form name="frmMrn" id="frmMrn">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><?php include 'Header.php';  ?></td>
    </tr>
    <tr>
      <td align="center"><table width="950" border="0" cellspacing="3" cellpadding="0" class="tableBorder">
        <tr>
          <td class="mainHeading">Material Requisition Detail </td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="5" cellpadding="0" class="bcgl1 normalfnt">
            <tr>
              <td width="10%" height="25">MRN No </td>
              <td width="28%"><input name="txtMRNNo" type="text" class="txtbox" id="txtMRNNo" style="text-align:left; width:180px;"  disabled="disabled" readonly="true" /></td>
              <td width="10%">Requested By</td>
              <td width="27%"><span class="normalfnt">
                <input name="txtrequestedby" type="text" class="txtbox" id="txtrequestedby"  value="<?php 		
		$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
		$result = $dbheader->RunQuery($SQL);
	
		while($row = mysql_fetch_array($result))
		{
			echo $row["Name"];
		}
		?>" readonly="true"  style="width:180px"/>
              </span></td>
              <td width="5%"><span class="normalfnt">Date</span></td>
              <td width="20%"><input name="deliverydateDD" type="text" class="txtbox" id="deliverydateDD" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" style="width:100px" /><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
            </tr>
            <tr>
              <td height="25"><span class="normalfnt">Store</span></td>
              <td><select name="cboFactory" class="txtbox" id="cboFactory" onchange="clearData();" style="width:182px">
                <option value="0" selected="selected">Select One</option>
                <?php 
			$SQL = "SELECT strMainID,strName FROM mainstores WHERE intStatus = '1' order by strName";	
			$result = $db->RunQuery($SQL);		
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"". $row["strMainID"] ."\">" . $row["strName"] ."</option>" ;
			}
		?>
              </select></td>
              <td><span class="normalfnt">Department</span></td>
              <td><span class="normalfnt">
                <select name="cbodepartment" class="txtbox" id="cbodepartment" style="width:182px">
                  <option value="0" selected="selected">Select One</option>
                  <?php 

			$SQL = "SELECT intDepID,strDepartment FROM department where intStatus='1'  order by strDepartment";	
			$result = $db->RunQuery($SQL);		
			while($row = mysql_fetch_array($result))
			{
			echo "<option value=\"". $row["intDepID"] ."\">" . $row["strDepartment"] ."</option>" ;
			}
		?>
                </select>
              </span></td>
              <td>&nbsp;</td>
              <td><input type="hidden" id="mrnYear" value="<?php echo $year;?>"/></td>
            </tr>
					
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" height="197" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
            <tr>
              <td width="89%"class="mainHeading2" style="text-align:left"></td>
              <td width="11%" bgcolor="#9BBFDD" class="normalfnt"><img src="images/add-new.png" class="mouseover" alt="add new" width="109" height="18" onclick="validateAddNew();"  id="addNew"/></td>
            </tr>
            <tr>
              <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:380px; width:100%px;">
                  <table width="100%" bgcolor="#CCCCFF"  cellpadding="0" cellspacing="1" id="mainMatGrid">
                    <tr class="mainHeading4">
                      <td width="2%" height="25">Del</td>
                      <td width="10%" >Style</td>
                      <td width="5%" >SC No</td>
                      <td width="8%">Order No</td>
                      <td width="8%" >Material</td>
                      <td width="18%" >Detail</td>
                      <td width="8%" >Color</td>
                      <td width="6%">Size</td>
                      <td width="6%">Bal Qty</td>
                      <td width="6%">Qty</td>
                      <td width="12%">Note</td>
                       <td width="7%">GRN No</td>
                        <td width="4%">GRN Year</td>
                         <td width="4%">GRN Type</td>
                         <td width="4%">Invoice No</td>
                    </tr>
                  </table>
              </div></td>
            </tr>
          </table></td>
        </tr>
		<tr>
          	<td ><table width="100%" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr>
                <td width="14%" height="29">&nbsp;</td>
                <td width="14%"><img src="images/new.png" alt="new" width="96" height="24"  class="mouseover" onclick="newForm();" /></td>
                <td width="14%"><img src="images/save.png" id="save" alt="save" width="84" height="24"  class="mouseover" onclick="ValidateMRNSaving();" /></td>
                 <?php if($confirmMRN)
				{
					?>
                <td width="16%"><img src="images/conform.png" width="115" height="24" alt="confirm" id="butConfirm" name="butConfirm" onclick="confirmReport(<?php echo  $year;?>);" class="mouseover" /></td>
                <?php } else { ?>
                <td class="normalfnt"></td>
                <?php } ?>
                <td width="16%"><img src="images/report.png" alt="r" width="108" height="24"  class="mouseover" id="report"  onclick="reportPopup();" style="visibility:hidden" /></td>
                <td width="12%"><a href="main.php"><img src="images/close.png" alt="c" width="97" height="24" border="0" /></a></td>
                <td width="14%">&nbsp;</td>
              </tr>
            </table></td>
        </tr>	
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<div style="left:470px; top:270px; z-index:10; position:absolute; width: 161px; visibility:hidden;" id="gotoMrnReport">
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
