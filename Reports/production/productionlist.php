<?php
session_start();
$backwardseperator = "../../";

$txtDfromCut	= date("Y-m-01");
$txtDtoCut		= date("Y-m-d");
$txtDfromW		= date("Y-m-01");
$txtDtoW		= date("Y-m-d");
/*$PP_AllowProductionWIPReport   = false;
$PP_AllowCutQuantityReport  	 = true;
$PP_AllowWashingPlanReport  	 = false;
$PP_AllowSizeWiseGatePassReport  = false;
$PP_AllowProductionSummaryReport = false;
$PP_AllowProductionDetailReport  = false;
$PP_AllowBundleMovementReport  	 = false;*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Production Report List</title>

<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript"></script>
<script src="productionlist.js" type="text/javascript"></script>
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
<form id="frmProductionList" name="frmProductionList">
<?php
include "../../Connector.php";
?>
<tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>

<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td width="75" rowspan="2">&nbsp;</td>
    <td width="788" height="307"><table width="100%" height="302" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
      <tr>
        <td><table width="100%" border="0" cellspacing="4">
          <tr>
            <td width="18%" class="normalfnBLD1" style="text-align:center;font-size:12px">&nbsp;</td>
            <td width="1%" rowspan="12" align="left"><img src="../../images/bluebar.png" alt="bar" width="2" height="250" border="0" /></td>
            <td width="81%" rowspan="12">
              <div id="div1" style="height:250px;width:auto;display:none">
                
                <table width="100%" border="0" class="tableBorder">
                  <tr>
                    <td height="25" class="mainHeading">Cut Quantity</td>
                    </tr>
                  <tr>
                    <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                          <tr>
                            <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td colspan="5" height="15"><fieldset class="roundedCorners" >
                                  <legend class="legendHeader">&nbsp;cut Date&nbsp;</legend>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td width="33" class="normalfntMid"><input name="checkDateC" id="checkDateC" type="checkbox" checked="checked" onclick="setDateChecked(this);"/></td>
                                      <td width="105">Date From </td>
                                      <td width="131"><input type="text" name="txtDfromCut" id="txtDfromCut" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromCut=="" ? "":$txtDfromCut);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      <td width="76">To</td>
                                      <td width="194"><input type="text" name="txtDtoCut" id="txtDtoCut" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoCut=="" ? "":$txtDtoCut);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      </tr>
                                    </table>
                                  </fieldset></td>
                                </tr>
                              
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                </tr>
                              <tr>
                                <td width="42">&nbsp;</td>
                                <td width="104">Style No</td>
                                <td width="407" colspan="3"><select name="cboStyleIDCut" class="txtbox" id="cboStyleIDCut" style="width:250px" onchange="loadOrderNo(this.value,'cut')">
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
                                </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>Order No </td>
                                <td colspan="3"><select name="cboOrderNoCut" id="cboOrderNoCut" style="width:250px;">
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
                                </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>Division</td>
                                <td colspan="3"><select name="cboDivisionCut" class="txtbox" id="cboDivisionCut" style="width:250px">
                                  <?php 	
	$SQL="select intDivisionId,strDivision from buyerdivisions where intStatus=1 order by strDivision";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">".""."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intDivisionId"]."\">".$row["strDivision"]."</option>";
	}
?>
                                  </select></td>
                                </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>Factory</td>
                                <td colspan="3"><select name="cboFactoryCut" class="txtbox" id="cboFactoryCut" style="width:250px">
                                  <?php 	
	$SQL="select intCompanyID,strName from companies where intStatus=1 order by strName";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">".""."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
	}
?>
                                  </select></td>
                                </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                      <tr>
                        <td width="100%" bgcolor="#FFFFFF"><table width="100%" border="0">
                          <tr>
                            <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(1);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" class="mouseover" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                
                </div> 
              <div id="div2" style="height:250px;width:auto;display:none">
                
                <table width="100%" border="0" class="tableBorder">
                  <tr>
                    <td height="25" class="mainHeading">Washing Plan </td>
                    </tr>
                  <tr>
                    <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                          <tr>
                            <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td colspan="5" height="15"><fieldset class="roundedCorners" >
                                  <legend class="legendHeader">&nbsp;Transfer In  Date&nbsp;</legend>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td width="33" class="normalfntMid"><input name="checkDateW" id="checkDateW" type="checkbox" checked="checked" onclick="SetDate(this);"/></td>
                                      <td width="105">Date From </td>
                                      <td width="131"><input type="text" name="txtDfromW" id="txtDfromW" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      <td width="76">To</td>
                                      <td width="194"><input type="text" name="txtDtoW" id="txtDtoW" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      </tr>
                                    </table>
                                  </fieldset></td>
                                </tr>
                              
                              <tr>
                                <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                  <tr>
                                    <td width="50" class="normalfnt">&nbsp;</td>
                                    <td width="115" class="normalfnt">Style No</td>
                                    <td width="200"><select name="cboStyleIDWash" class="txtbox" id="cboStyleIDWash" style="width:180px" onchange="loadOrderNo(this.value,'wash')" >
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
                                    <td><select name="cboOrderNoWash" id="cboOrderNoWash" style="width:180px;" onchange="SetSCNo(this,'Wash');">
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
                                    <td class="normalfnt"><select name="cboScNoWash" class="txtbox" id="cboScNoWash" style="width:90px"  onchange="SetOrderNo(this,'Wash')">
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
                                    <td><select name="cboBuyerWash" id="cboBuyerWash" style="width:180px;">
                                      <?php 	
	$SQL="select B.intBuyerID,B.strName from buyers B where B.intStatus=1 order by B.strName";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intBuyerID"]."\">".$row["strName"]."</option>";
	}
?>
                                      </select></td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                      <tr>
                        <td width="100%" bgcolor="#FFFFFF"><table width="100%" border="0">
                          <tr>
                            <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(2);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                
                </div>
                <div id="div3" style="height:250px;width:auto;display:none">
                
                <table width="100%" border="0" class="tableBorder">
                  <tr>
                    <td height="25" class="mainHeading">Cutting Work In Progress </td>
                    </tr>
                  <tr>
                    <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                          <tr>
                            <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td colspan="5" height="15"><fieldset class="roundedCorners" >
                                  <legend class="legendHeader">&nbsp;Cut  Date&nbsp;</legend>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td width="33" class="normalfntMid"><input name="checkDateWip" id="checkDateWip" type="checkbox" checked="checked" onclick="SetDateWip(this);"/></td>
                                      <td width="103">Date From </td>
                                      <td width="138"><input type="text" name="txtDfromWip" id="txtDfromWip" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      <td width="78">To</td>
                                      <td width="202"><input type="text" name="txtDtoWip" id="txtDtoWip" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      </tr>
                                    </table>
                                  </fieldset></td>
                                </tr>
                              
                              <tr>
                                <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                  <tr>
                                    <td width="39" class="normalfnt">&nbsp;</td>
                                    <td width="100" class="normalfnt">Style No</td>
                                    <td width="195"><select name="cboStyleIDWip" class="txtbox" id="cboStyleIDWip" style="width:180px" onchange="loadOrderNo(this.value,'wip')" >
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
                                    <td width="42" class="normalfnt">&nbsp;</td>
                                    <td width="174">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">Order No </td>
                                    <td><select name="cboOrderNoWip" id="cboOrderNoWip" style="width:180px;" onchange="SetSCNo(this,'Wip');">
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
                                    <td class="normalfnt"><select name="cboScNoWip" class="txtbox" id="cboScNoWip" style="width:90px"  onchange="SetOrderNo(this,'Wip')">
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
                                    <td><select name="cboBuyerWip" id="cboBuyerWip" style="width:180px;">
                                      <?php 	
	$SQL="select B.intBuyerID,B.strName from buyers B where B.intStatus=1 order by B.strName";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intBuyerID"]."\">".$row["strName"]."</option>";
	}
?>
                                      </select></td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">Sewing Factory</td>
                                    <td><select name="cboFactoryWip" id="cboFactoryWip" style="width:180px;">
                                      <?php 	
	$SQL="select intCompanyID,strName from companies where intStatus=1 order by strName";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">".""."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
	}
?>
                                    </select></td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                  </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                      <tr>
                        <td width="100%" bgcolor="#FFFFFF"><table width="100%" border="0">
                          <tr>
                            <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(3);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                
                </div>
                <div id="div4" style="height:250px;width:auto;display:none">
                
                <table width="100%" border="0" class="tableBorder">
                  <tr>
                    <td height="25" class="mainHeading">Size Wise Gate Pass</td>
                    </tr>
                  <tr>
                    <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                          <tr>
                            <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td colspan="5" height="15"><fieldset class="roundedCorners" >
                                  <legend class="legendHeader">&nbsp;Gate Pass Date&nbsp;</legend>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td width="33" class="normalfntMid"><input name="checkDateGP" id="checkDateGP" type="checkbox" checked="checked" onclick="setDateCheckedGP(this);"/></td>
                                      <td width="105">Date From </td>
                                      <td width="131"><input type="text" name="txtDfromGP" id="txtDfromGP" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromCut=="" ? "":$txtDfromCut);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      <td width="76">To</td>
                                      <td width="194"><input type="text" name="txtDtoGP" id="txtDtoGP" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoCut=="" ? "":$txtDtoCut);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      </tr>
                                    </table>
                                  </fieldset></td>
                                </tr>
                              
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                </tr>
                              <tr>
                                <td width="42">&nbsp;</td>
                                <td width="104">Style No</td>
                                <td width="407" colspan="3"><select name="cboStyleIDGP" class="txtbox" id="cboStyleIDGP" style="width:250px" onchange="loadOrderNo(this.value,'GP')">
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
                                </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>Order No </td>
                                <td colspan="3"><select name="cboOrderNoGP" id="cboOrderNoGP" style="width:250px;">
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
                                </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>From Factory</td>
                                <td colspan="3"><select name="cboFromFactory" class="txtbox" id="cboFromFactory" style="width:250px">
                                  <?php 	
	$SQL="select intCompanyID,strName from companies where intStatus=1 order by strName";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">".""."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
	}
?>
                                </select></td>
                                </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>To Factory</td>
                                <td colspan="3"><select name="cboToFactory" class="txtbox" id="cboToFactory" style="width:250px">
                                  <?php 	
	$SQL="select intCompanyID,strName from companies where intStatus=1 order by strName";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">".""."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
	}
?>
                                  </select></td>
                                </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                      <tr>
                        <td width="100%" bgcolor="#FFFFFF"><table width="100%" border="0">
                          <tr>
                            <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(4);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" class="mouseover" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                
                </div>
                <div id="div5" style="height:250px;width:auto;display:none">
                
                <table width="100%" border="0" class="tableBorder">
                  <tr>
                    <td height="25" class="mainHeading">Production Summary</td>
                    </tr>
                  <tr>
                    <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                          <tr>
                            <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td colspan="5" height="15"><fieldset class="roundedCorners" >
                                  <legend class="legendHeader">&nbsp;Date&nbsp;</legend>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td width="33" class="normalfntMid"><input name="checkDatePS" id="checkDatePS" type="checkbox" checked="checked" onclick="SetDatePS(this);" disabled="disabled"/></td>
                                      <td width="103">Date From </td>
                                      <td width="138"><input type="text" name="txtDfromPS" id="txtDfromPS" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      <td width="78">To</td>
                                      <td width="202"><input type="text" name="txtDtoPS" id="txtDtoPS" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      </tr>
                                    </table>
                                  </fieldset></td>
                                </tr>
                              
                              <tr>
                                <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                  <tr>
                                    <td width="39" class="normalfnt">&nbsp;</td>
                                    <td width="100" class="normalfnt">Style No</td>
                                    <td width="195"><select name="cboStyleIDPS" class="txtbox" id="cboStyleIDPS" style="width:180px" onchange="loadOrderNo(this.value,'PS')" >
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
                                    <td width="42" class="normalfnt">&nbsp;</td>
                                    <td width="174">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">Order No </td>
                                    <td><select name="cboOrderNoPS" id="cboOrderNoPS" style="width:180px;">
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
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">Line No</td>
                                    <td><select name="cboLineNoPS" id="cboLineNoPS" style="width:180px;">
                                      <?php 	
	$SQL="select intTeamNo,strTeam from plan_teams";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intTeamNo"]."\">".$row["strTeam"]."</option>";
	}
?>
                                      </select></td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                  </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                      <tr>
                        <td width="100%" bgcolor="#FFFFFF"><table width="100%" border="0">
                          <tr>
                            <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(5);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                
                </div>
                <div id="div6" style="height:250px;width:auto;display:none">
                
                <table width="100%" border="0" class="tableBorder">
                  <tr>
                    <td height="25" class="mainHeading">Production Detail</td>
                    </tr>
                  <tr>
                    <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                          <tr>
                            <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td colspan="5" height="15"><fieldset class="roundedCorners" >
                                  <legend class="legendHeader">&nbsp;Date&nbsp;</legend>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td width="33" class="normalfntMid"><input name="checkDatePD" id="checkDatePD" type="checkbox" checked="checked" onclick="SetDatePD(this);" disabled="disabled"/></td>
                                      <td width="103">Date From </td>
                                      <td width="138"><input type="text" name="txtDfromPD" id="txtDfromPD" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      <td width="78">To</td>
                                      <td width="202"><input type="text" name="txtDtoPD" id="txtDtoPD" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      </tr>
                                    </table>
                                  </fieldset></td>
                                </tr>
                              
                              <tr>
                                <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                  <tr>
                                    <td width="39" class="normalfnt">&nbsp;</td>
                                    <td width="100" class="normalfnt">Style No</td>
                                    <td width="195"><select name="cboStyleIDPD" class="txtbox" id="cboStyleIDPD" style="width:180px" onchange="loadOrderNo(this.value,'PD')" >
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
                                    <td width="42" class="normalfnt">&nbsp;</td>
                                    <td width="174">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">Order No </td>
                                    <td><select name="cboOrderNoPD" id="cboOrderNoPD" style="width:180px;" onChange="loadCutNoDetails(this.value,'PD');">
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
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">Cut No</td>
                                    <td><select name="cboCutNoPD" id="cboCutNoPD" style="width:180px;">
                                    </select></td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">Line No</td>
                                    <td><select name="cboLineNoPD" id="cboLineNoPD" style="width:180px;">
                                      <?php 	
	$SQL="select intTeamNo,strTeam from plan_teams";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intTeamNo"]."\">".$row["strTeam"]."</option>";
	}
?>
                                      </select></td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                  </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                      <tr>
                        <td width="100%" bgcolor="#FFFFFF"><table width="100%" border="0">
                          <tr>
                            <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(6);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                
                </div>
                <div id="div7" style="height:250px;width:auto;display:none">
                
                <table width="100%" border="0" class="tableBorder">
                  <tr>
                    <td height="25" class="mainHeading">Production Bundle Movement</td>
                    </tr>
                  <tr>
                    <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                          <tr>
                            <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td colspan="5" height="15"><fieldset class="roundedCorners" >
                                  <legend class="legendHeader">&nbsp;Date&nbsp;</legend>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td width="33" class="normalfntMid"><input name="checkDatePBM" id="checkDatePBM" type="checkbox" checked="checked" onclick="SetDatePBM(this);" disabled="disabled"/></td>
                                      <td width="103">Date From </td>
                                      <td width="138"><input type="text" name="txtDfromPBM" id="txtDfromPBM" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      <td width="78">To</td>
                                      <td width="202"><input type="text" name="txtDtoPBM" id="txtDtoPBM" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                      </tr>
                                    </table>
                                  </fieldset></td>
                                </tr>
                              
                              <tr>
                                <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                  <tr>
                                    <td width="39" class="normalfnt">&nbsp;</td>
                                    <td width="100" class="normalfnt">Style No</td>
                                    <td width="195"><select name="cboStyleIDPBM" class="txtbox" id="cboStyleIDPBM" style="width:180px" onchange="loadOrderNo(this.value,'PBM')" >
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
                                    <td width="42" class="normalfnt">&nbsp;</td>
                                    <td width="174">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">Order No </td>
                                    <td><select name="cboOrderNoPBM" id="cboOrderNoPBM" style="width:180px;" onChange="loadCutNoDetails(this.value,'PBM');">
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
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">Cut No</td>
                                    <td><select name="cboCutNoPBM" id="cboCutNoPBM" style="width:180px;" onChange="loadBundleNo();">
                                    </select></td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">Line No</td>
                                    <td><select name="cboLineNoPBM" id="cboLineNoPBM" style="width:180px;">
                                      <?php 	
	$SQL="select intTeamNo,strTeam from plan_teams";	
	$result =$db->RunQuery($SQL);	
		echo "<option value =\"".""."\">"."All"."</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"".$row["intTeamNo"]."\">".$row["strTeam"]."</option>";
	}
?>
                                      </select></td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">Bundle No</td>
                                    <td><select name="cboBundleNoPBM" id="cboBundleNoPBM" style="width:180px;">
                                    </select></td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                    <td class="normalfnt">&nbsp;</td>
                                  </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
                      <tr>
                        <td width="100%" bgcolor="#FFFFFF"><table width="100%" border="0">
                          <tr>
                            <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(7);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                
                </div>
                 <div id="div8" style="height:250px;width:auto;display:none;vertical-align:middle">
                 <table width="100%" height="250" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                 <td class="head2BLCK" style="text-align:center">No Permission to view Report</td>
                 </tr>
				</table>
                 </div>
                 <div id="div9" style="height:250px;width:auto;vertical-align:middle">
                 <table width="100%" height="250" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                 <td class="head1" style="text-align:center">Please select a report category to view the report</td>
                 </tr>
				</table>

                 </div>
                </td>
            </tr>
          
          <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(3,'<?php echo $PP_AllowProductionWIPReport;?>')">
            <td id="WIP" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Work In Progress</b></td>
          </tr>
          <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(1,'<?php echo $PP_AllowCutQuantityReport;?>')">
            <td id="cutQty" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Cut Quantity</b></td>
            </tr>
          <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(2,'<?php echo $PP_AllowWashingPlanReport;?>')">
            <td id="washPlan" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Washing Plan</b></td>
            </tr>
         <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(4,'<?php echo $PP_AllowSizeWiseGatePassReport;?>')">
           <td id="GatePass" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Size Wise Gate Pass</b></td>
            </tr>
          <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(5,'<?php echo $PP_AllowProductionSummaryReport;?>')">
           <td id="ProductionSum" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Production Summary</b></td>
             <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(6,'<?php echo $PP_AllowProductionDetailReport;?>')">
           <td id="ProductionDet" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Production Detail</b></td>
            </tr>
          <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
           <td id="ProductionBM" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Bundle Movement</b></td>
            </tr>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          </table></td>
        </tr>
      </table></td>
    <td width="73" rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
</table>
</form>
</body>
</html>
