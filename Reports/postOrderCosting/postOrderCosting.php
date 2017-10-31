<?php
session_start();
include "../../Connector.php";	
$companyId = $_SESSION["FactoryID"];
$backwardseperator = "../../";
$txtDfrom	= date('Y-m-01');
$txtDto		= date('Y-m-d');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Post Order Costing</title>
<link href="../../Units/css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="postOrderCosting.js" type="text/javascript" ></script>
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
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
<form id="frmPostOrderCosting" name="frmPostOrderCosting" method="post" action="">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
<table width="645" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
        <td ><table width="100%" border="0" class="tableBorder">
          <tr>
            <td height="25" class="mainHeading">Post Order Costing</td>
          </tr>
          <tr>
            <td ><table width="100%" border="0" class="tableBorder" >
			<tr>
	  	      <td colspan="5"><fieldset class="roundedCorners" >
                            <legend class="legendHeader">&nbsp;Order Status&nbsp;</legend>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="36" class="normalfntMid" ><input type="radio" id="rbAllStyle" name="radio" checked="checked" onchange="LoadCompleteStyle('')" value="all"/></td>
              <td width="91" class="normalfnt" >&nbsp;All Orders</td>
              <td width="21"   class="normalfnt"><input type="radio" id="rbCompleteStyle" name="radio" onchange="LoadCompleteStyle('13')" value="completed"/></td>
              <td width="158"   class="normalfnt">&nbsp;Completed Orders</td>
              <td width="22"   class="normalfnt"><input type="radio" name="radio" id="rbApprovedStyle"  onchange="LoadCompleteStyle('11')" value="approved" /></td>
              <td width="145"   class="normalfnt">&nbsp;Approved Orders</td>
              <td width="22" class="normalfnt" ><input type="radio" id="rbPendingStyle" name="radio" value="pending" onchange="LoadCompleteStyle('0,10')"/></td>
			  <td width="126" class="normalfnt" >&nbsp;Pending Orders </td>
            </tr> 
			</table>
	  	      </fieldset></td> 
              <tr>
                <td colspan="5"><fieldset class="roundedCorners" >
                            <legend class="legendHeader">&nbsp;Order Date&nbsp;</legend><table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td width="33" class="normalfntMid"><input name="checkDate" id="checkDate" type="checkbox" checked="checked" onclick="SetDate(this);"/></td>
                    <td width="126" class="normalfnt">Date From </td>
                    <td width="140"><input type="text" name="txtDfrom " id="txtDfrom" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfrom=="" ? "":$txtDfrom);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                    <td width="104" class="normalfnt">Date To</td>
                    <td width="198"><input type="text" name="txtDto" id="txtDto" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDto=="" ? "":$txtDto);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                  </tr>
                </table></fieldset></td>
              <tr>
                <td width="50" class="normalfnt">&nbsp;</td>
                <td width="115" class="normalfnt" height="24">Style No</td>
               <td width="200"><select name="cboStyleID" class="txtbox" id="cboStyleID" style="width:200px" onchange="LoadOrderNo(this.value);">
                       <option value="" selected="selected">Select One</option>
<?php
	$sql="select distinct strStyle 
		  from orders O 
		  INNER JOIN specification SP ON O.intStyleId=SP.intStyleId
		  Order By O.strStyle;";
	$result=$db->RunQuery($sql);			
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=\"".trim($row["strStyle"],' ')."\">".$row["strStyle"]."</option>";
	}
?>
                </select></td>
                <td width="40" class="normalfnt">&nbsp;</td>
             <td width="202">&nbsp;</td>
                </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Order No </td>
                <td><select name="cboOrderNo" id="cboOrderNo" style="width:200px;" onchange="SetSCNo(this);">
                  <option value="" selected="selected">Select One</option>
                  <?php
	
	$SQL = "select distinct SP.intStyleId,O.strOrderNo
			from specification SP
			INNER JOIN orders O ON O.intStyleId=SP.intStyleId
			order by O.strOrderNo ;";
	$result = $db->RunQuery($SQL);

	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                </select></td>
                <td class="normalfnt">SC No</td>
                <td class="normalfnt"><select name="cboScNo" class="txtbox" id="cboScNo" style="width:90px"  onchange="SetOrderNo(this)">
                  <option value="" selected="selected">Select One</option>
                  <?php
		$sql="select SP.intStyleId,SP.intSRNO
				from specification SP
				INNER JOIN orders O ON O.intStyleId=SP.intStyleId
				order by SP.intSRNO DESC;";
				
		$result=$db->RunQuery($sql);		
		while($row=mysql_fetch_array($result)){
		echo "<option value=\"".trim($row["intStyleId"],' ')."\">".$row["intSRNO"]."</option>";
		}
?>
                </select></td>
                </tr>
              <tr>
                <td class="normalfnt">&nbsp;</td>
              	<td class="normalfnt">Buyer</td>
                <td><select name="cboBuyer" id="cboBuyer" style="width:200px;">
                 <?php 	
	$SQL="select B.intBuyerID,B.strName from buyers B where B.intStatus=1 order by B.strName";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intBuyerID"]."\">".$row["strName"]."</option>";
	}
?>
                </select>                </td>
                <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">&nbsp;</td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Order Type </td>
                  <td><select name="cboOrderType" class="txtbox" id="cboOrderType" style="width:200px">
                    <?php 	
	$SQL="select intTypeId,strTypeName from orders_ordertype where intStatus=1 order by strTypeName";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intTypeId"]."\">".$row["strTypeName"]."</option>";
	}
?>
                  </select></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                <td class="normalfnt">Report Category</td>
                 <td><select name="cboReportCategory" id="cboReportCategory" style="width:200px;">
                <option value="0">Post Order Costing Report</option>
				<option value="1">Post Order Costing Summary Report</option>
                <option value="2">Post Order Costing Summary Detail Report </option>
                </select></td>
                  <td>&nbsp;</td>
                   <td>&nbsp;</td>
			    </tr>
            </table>            </td>
          </tr>
          <tr>
            <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
              <tr>
                <td width="100%" ><table width="100%" border="0">
                    <tr>
                      <td align="center">
					  <img src="../../images/new.png" alt="New" name="New" id="butNew" onclick="ClearForm();">
					  <img src="../../images/report.png" alt="Report" name="Report" id="butReport" onclick="ViewReport();"/>
					   <img src="../../images/download.png" alt="Report" name="Report" id="butReport" onclick="ViewExReport();"/>
					  <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" border="0" id="Close"/></a></td>
                      </tr>
                </table></td>
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
</body>
</html>