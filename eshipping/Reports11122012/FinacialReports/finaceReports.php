<?php
session_start();
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
<title>WaveEDGE | Production Report List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>

<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="finacereports.js" type="text/javascript"></script>
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

<table width="950" cellspacing="1" align="center">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
      <tr>
        <td height="307"><table width="100%" height="302" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr>
            <td><table width="100%" border="0" cellspacing="4">
                  <tr >
                    <td height="10"></td>
                    <td width="1%" rowspan="17" align="left"><img src="../../images/bluebar.png" alt="bar" width="2" height="320" border="0" /></td>
                    <td width="68%" rowspan="17">
                    <div id="div1" style="height:250px;width:auto; display:none">
                      <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Buyerwise Exports-Detail</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;  Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate1" id="chkDate1" type="checkbox" checked="checked" onclick="ValidateDate(this,1);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom1" id="txtDfrom1" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto1" id="txtDto1" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            </tr>
                                          </table>
                                        </fieldset></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                        <tr>
                                          <td width="459" class="normalfnt"><div>
                                            <fieldset class="roundedCorners_reportHeader">
                                              <legend class="legendHeader">Buyers</legend>
                                              <div style="overflow:scroll;height:150px">
                                              <table id="tblMain1" class="bcgl1" width="100%" cellspacing="1" bgcolor="#F0F0FF">
                                                <tr>
                                                  <td width="29" class="normaltxtmidb2" bgcolor="#498CC2"><input type="checkbox" onclick="CheckAll(this,1);"/></td>
                                                  <td width="414" class="normaltxtmidb2" bgcolor="#498CC2">Buyer name</td>
                                                  </tr>
                                                 <?php 
												 $sql="SELECT intMainBuyerId,strMainBuyerName FROM buyers_main WHERE intStatus=1 ORDER BY strMainBuyerName";
												 $result=$db->RunQuery($sql);
												 while($row=mysql_fetch_array($result))
												 {
												 ?>
                                                	<tr class="bcgcolor-tblrowWhite">
                                                  		<td class="normalfntMid"><input type="checkbox" /></td>
                                                  		<td class="normalfnt" id="<?php echo $row["intMainBuyerId"]?>"><?php echo $row["strMainBuyerName"];?></td>
                                                  	</tr>
                                                  <?php
												 }
                                                  ?>
                                                </table></div>
                                              </fieldset>
                                          </div></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(1);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                      </div>
                      <div id="div2" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Buyerwise Exports-Summary</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;  Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate2" id="chkDate2" type="checkbox" checked="checked" onclick="ValidateDate(this,2);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom2" id="txtDfrom2" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto2" id="txtDto2" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            </tr>
                                          </table>
                                        </fieldset></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                        <tr>
                                          <td width="459" class="normalfnt"><div>
                                            <fieldset class="roundedCorners_reportHeader">
                                              <legend class="legendHeader">Buyers</legend>
                                              <div style="overflow:scroll;height:150px">
                                              <table id="tblMain2" class="bcgl1" width="100%" cellspacing="1" bgcolor="#F0F0FF">
                                                <tr>
                                                  <td width="29" class="normaltxtmidb2" bgcolor="#498CC2"><input type="checkbox" onclick="CheckAll(this,2);"/></td>
                                                  <td width="414" class="normaltxtmidb2" bgcolor="#498CC2">Buyer name</td>
                                                  </tr>
                                                 <?php 
												 $sql="SELECT intMainBuyerId,strMainBuyerName FROM buyers_main WHERE intStatus=1 ORDER BY strMainBuyerName";
												 $result=$db->RunQuery($sql);
												 while($row=mysql_fetch_array($result))
												 {
												 ?>
                                                	<tr class="bcgcolor-tblrowWhite">
                                                  		<td class="normalfntMid"><input type="checkbox" /></td>
                                                  		<td class="normalfnt" id="<?php echo $row["intMainBuyerId"]?>"><?php echo $row["strMainBuyerName"];?></td>
                                                  	</tr>
                                                  <?php
												 }
                                                  ?>
                                                </table></div>
                                              </fieldset>
                                          </div></td>
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
                      <div id="div3" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Factorywise Exports Detail</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;  Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate3" id="chkDate3" type="checkbox" checked="checked" onclick="ValidateDate(this,3);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom3" id="txtDfrom3" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto3" id="txtDto3" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            </tr>
                                          </table>
                                        </fieldset></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                        <tr>
                                          <td width="459" class="normalfnt"><div>
                                            <fieldset class="roundedCorners_reportHeader">
                                              <legend class="legendHeader">Buyers</legend>
                                              <div style="overflow:scroll;height:150px">
                                              <table id="tblMain3" class="bcgl1" width="100%" cellspacing="1" bgcolor="#F0F0FF">
                                                <tr>
                                                  <td width="29" class="normaltxtmidb2" bgcolor="#498CC2"><input type="checkbox" onclick="CheckAll(this,3);"/></td>
                                                  <td width="414" class="normaltxtmidb2" bgcolor="#498CC2">Location</td>
                                                  </tr>
                                                 <?php 
												 $sql="SELECT C.strCustomerID,CONCAT(C.strName,' - ',C.strAddress2)AS companyName FROM customers C ORDER BY C.strName";
												 $result=$db->RunQuery($sql);
												 while($row=mysql_fetch_array($result))
												 {
												 ?>
                                                	<tr class="bcgcolor-tblrowWhite">
                                                  		<td class="normalfntMid"><input type="checkbox" /></td>
                                                  		<td class="normalfnt" id="<?php echo $row["strCustomerID"]?>"><?php echo $row["companyName"];?></td>
                                                  	</tr>
                                                  <?php
												 }
                                                  ?>
                                                </table></div>
                                              </fieldset>
                                          </div></td>
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
                      <div id="div4" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Factorywise Exports-Summary with Buyers </td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;  Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate4" id="chkDate4" type="checkbox" checked="checked" onclick="ValidateDate(this,4);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom4" id="txtDfrom4" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto4" id="txtDto4" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            </tr>
                                          </table>
                                        </fieldset></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                        <tr>
                                          <td width="459" class="normalfnt"><div>
                                            <fieldset class="roundedCorners_reportHeader">
                                              <legend class="legendHeader">Buyers</legend>
                                              <div style="overflow:scroll;height:150px">
                                              <table id="tblMain4" class="bcgl1" width="100%" cellspacing="1" bgcolor="#F0F0FF">
                                                <tr>
                                                  <td width="29" class="normaltxtmidb2" bgcolor="#498CC2"><input type="checkbox" onclick="CheckAll(this,4);"/></td>
                                                  <td width="414" class="normaltxtmidb2" bgcolor="#498CC2">Location</td>
                                                  </tr>
                                                 <?php 
												 $sql="SELECT C.strCustomerID,CONCAT(C.strName,' - ',C.strAddress2)AS companyName FROM customers C ORDER BY C.strName";
												 $result=$db->RunQuery($sql);
												 while($row=mysql_fetch_array($result))
												 {
												 ?>

                                                	<tr class="bcgcolor-tblrowWhite">
                                                  		<td class="normalfntMid"><input type="checkbox" /></td>
                                                  		<td class="normalfnt" id="<?php echo $row["strCustomerID"]?>"><?php echo $row["companyName"];?></td>
                                                  	</tr>
                                                  <?php
												 }
                                                  ?>
                                                </table></div>
                                              </fieldset>
                                          </div></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(4);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        </div>
                      <div id="div5" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Factorywise Exports-Summary</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" ><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td width="100%" colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate5" id="chkDate5" type="checkbox" checked="checked" onclick="ValidateDate(this,5);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom5" id="txtDfrom5" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto5" id="txtDto5" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            </tr>
                                          </table>
                                        </fieldset></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <tr>
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                        <tr>
                                          <td width="459" class="normalfnt"><div>
                                            <fieldset class="roundedCorners_reportHeader">
                                              <legend class="legendHeader">Factory</legend>
                                              <div style="overflow:scroll;height:150px">
                                              <table id="tblMain5" class="bcgl1" width="100%" cellspacing="1" bgcolor="#F0F0FF">
                                                <tr>
                                                  <td width="29" class="normaltxtmidb2" bgcolor="#498CC2"><input type="checkbox" onclick="CheckAll(this,5);"/></td>
                                                  <td width="414" class="normaltxtmidb2" bgcolor="#498CC2">Buyer name</td>
                                                  </tr>
                                                 <?php 
												 $sql="SELECT strCustomerID,strMLocation FROM customers ORDER BY strMLocation";
												 $result=$db->RunQuery($sql);
												 while($row=mysql_fetch_array($result))
												 {
												 ?>
                                                	<tr class="bcgcolor-tblrowWhite">
                                                  		<td class="normalfntMid"><input type="checkbox" /></td>
                                                  		<td class="normalfnt" id="<?php echo $row["strCustomerID"]?>"><?php echo $row["strMLocation"];?></td>
                                                  	</tr>
                                                  <?php
												 }
                                                  ?>
                                                </table></div>
                                              </fieldset>
                                          </div></td>
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
                      <div id="div6" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Destinationwise Exports</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" ><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td width="4%" class="normalfnt">&nbsp;</td>
                                  <td width="22%" class="normalfnt">Buyer</td>
                                  <td width="74%" >
                                  <select class="normalfnt" name="cboBuyer6" id="cboBuyer6" style="width:400px">
                                  <option value="">All Buyers</option>
                                  <?php
								  $sql="SELECT intMainBuyerId,strMainBuyerName FROM buyers_main WHERE intStatus=1 ORDER BY strMainBuyerName";
								  $result=$db->RunQuery($sql);
								  while($row=mysql_fetch_array($result))
								  {
								?>
									<option value="<?php echo $row["intMainBuyerId"]?>"><?php echo $row["strMainBuyerName"]?></option>
								<?php
                                  }
								  ?>
                                  
                                  </select></td>
                                </tr>
                                <tr>
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate6" id="chkDate6" type="checkbox" checked="checked" onclick="ValidateDate(this,6);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom6" id="txtDfrom6" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto6" id="txtDto6" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
                                    </tr>
                                  </table></td>
                                  </tr>
                                <tr style="display:none">
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice No&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid">&nbsp;</td>
                                            <td width="103">From No</td>
                                            <td width="138"><input class="txtbox" type="text" name="txtInvoNoFrom6" id="txtInvoNoFrom6" style="width:90px;" /></td>
                                            <td width="78">To No</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtInvoNoTo6" id="txtInvoNoTo6" style="width:90px;" /></td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
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
                      <div id="div7" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Exports Receivable - Summary</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" ><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td width="5%" class="normalfnt">&nbsp;</td>
                                  <td width="21%" class="normalfnt">Buyer</td>
                                  <td width="74%" >
                                  <select class="normalfnt" name="cboBuyer7" id="cboBuyer7" style="width:400px">
                                  <option value="">All Buyers</option>
                                  <?php
								  $sql="SELECT intMainBuyerId,strMainBuyerName FROM buyers_main WHERE intStatus=1 ORDER BY strMainBuyerName";
								  $result=$db->RunQuery($sql);
								  while($row=mysql_fetch_array($result))
								  {
								?>
									<option value="<?php echo $row["intMainBuyerId"]?>"><?php echo $row["strMainBuyerName"]?></option>
								<?php
                                  }
								  ?>
                                  
                                  </select></td>
                                </tr>
                                <tr>
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate7" id="chkDate7" type="checkbox" checked="checked" onclick="ValidateDate1(this,7);"  /></td>
                                            <td width="103">Date To </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDto7" id="txtDto7" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text2" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">&nbsp;</td>
                                            <td width="202">&nbsp;</td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
                                    </tr>
                                  </table></td>
                                  </tr>
                                <tr >
                                  <td class="normalfnt">&nbsp;</td>
                                  <td class="normalfnt">Currency</td>
                                  <td class="normalfnt"><select class="normalfnt" name="cboCurrency7" id="cboCurrency7" style="width:400px">
                                    <option value="">All Currency</option>
                                    <?php
								  $sql="SELECT DISTINCT strCurrency FROM currencytypes ORDER BY strCurrency";
								  $result=$db->RunQuery($sql);
								  while($row=mysql_fetch_array($result))
								  {
								?>
                                    <option value="<?php echo $row["strCurrency"]?>"><?php echo $row["strCurrency"]?></option>
                                    <?php
                                  }
								  ?>
                                  </select></td>
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
                      <div id="div8" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Exports Receivable - Detail</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate8" id="chkDate8" type="checkbox" checked="checked" onclick="ValidateDate1(this,8);"  /></td>
                                            <td width="103">Date To </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDto8" id="txtDto8" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text4" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">&nbsp;</td>
                                            <td width="202">&nbsp;</td>
                                            </tr>
                                          </table>
                                        </fieldset></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                        <tr>
                                          <td width="459" class="normalfnt"><div>
                                            <fieldset class="roundedCorners_reportHeader">
                                              <legend class="legendHeader">Buyers</legend>
                                              <div style="overflow:scroll;height:150px">
                                              <table id="tblMain8" class="bcgl1" width="100%" cellspacing="1" bgcolor="#F0F0FF">
                                                <tr>
                                                  <td width="29" class="normaltxtmidb2" bgcolor="#498CC2"><input type="checkbox" onclick="CheckAll(this,8);"/></td>
                                                  <td width="414" class="normaltxtmidb2" bgcolor="#498CC2">Buyer name</td>
                                                  </tr>
                                                 <?php 
												 $sql="SELECT intMainBuyerId,strMainBuyerName FROM buyers_main WHERE intStatus=1 ORDER BY strMainBuyerName";
												 $result=$db->RunQuery($sql);
												 while($row=mysql_fetch_array($result))
												 {
												 ?>
                                                	<tr class="bcgcolor-tblrowWhite">
                                                  		<td class="normalfntMid"><input type="checkbox" /></td>
                                                  		<td class="normalfnt" id="<?php echo $row["intMainBuyerId"]?>"><?php echo $row["strMainBuyerName"];?></td>
                                                  	</tr>
                                                  <?php
												 }
                                                  ?>
                                                </table></div>
                                              </fieldset>
                                          </div></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(8);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        </div>
                      <div id="div9" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Customs Invoice Register</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" ><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td width="4%" class="normalfnt">&nbsp;</td>
                                  <td width="22%" class="normalfnt">Buyer</td>
                                  <td width="74%" >
                                  <select class="normalfnt" name="cboBuyer9" id="cboBuyer9" style="width:400px">
                                  <option value="">All Buyers</option>
                                  <?php
								  $sql="SELECT intMainBuyerId,strMainBuyerName FROM buyers_main WHERE intStatus=1 ORDER BY strMainBuyerName";
								  $result=$db->RunQuery($sql);
								  while($row=mysql_fetch_array($result))
								  {
								?>
									<option value="<?php echo $row["intMainBuyerId"]?>"><?php echo $row["strMainBuyerName"]?></option>
								<?php
                                  }
								  ?>
                                  
                                  </select></td>
                                </tr>
                                <tr>
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate9" id="chkDate9" type="checkbox" checked="checked" onclick="ValidateDate(this,1);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom9" id="txtDfrom9" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto9" id="txtDto9" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
                                    </tr>
                                  </table></td>
                                  </tr>
                                <tr style="display:none">
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice No&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid">&nbsp;</td>
                                            <td width="103">From No</td>
                                            <td width="138"><input class="txtbox" type="text" name="txtInvoNoFrom9" id="txtInvoNoFrom9" style="width:90px;" /></td>
                                            <td width="78">To No</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtInvoNoTo9" id="txtInvoNoTo9" style="width:90px;" /></td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(9);"/><img src="../../images/print.png" alt="dwnload"  border="0" onclick="ShowExcelReport(9);" style="" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        </div>
                        
                      <div id="div10" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Final Invoice Register</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" ><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td width="100%" colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate10" id="chkDate10" type="checkbox" checked="checked" onclick="ValidateDate(this,10);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom10" id="txtDfrom10" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto10" id="txtDto10" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            </tr>
                                          </table>
                                        </fieldset></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <tr style="display:none">
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice No&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid">&nbsp;</td>
                                            <td width="103">From No</td>
                                            <td width="138"><input class="txtbox" type="text" name="txtInvoNoFrom6" id="txtInvoNoFrom6" style="width:90px;" /></td>
                                            <td width="78">To No</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtInvoNoTo6" id="txtInvoNoTo6" style="width:90px;" /></td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(10);"/><img src="../../images/print.png" alt="dwnload"  border="0" onclick="ShowExcelReport(10);" style="" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        </div>
                        
                      <div id="div11" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Pending Invoice Register</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" ><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td width="100%" colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <tr>
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid">&nbsp;</td>
                                            <td width="103">&nbsp;</td>
                                            <td width="123">To Date</td>
                                            <td width="324"><input class="txtbox" type="text" name="txtDto11" id="txtDto11" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(11);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        </div>
                      
                        <div id="div12" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Bank Letter Register</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;  Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate12" id="chkDate12" type="checkbox" checked="checked" onclick="ValidateDate(this,12);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom12" id="txtDfrom12" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto12" id="txtDto12" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            </tr>
                                          </table>
                                        </fieldset></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                        <tr>
                                          <td width="459" class="normalfnt"><div>
                                            <fieldset class="roundedCorners_reportHeader">
                                              <legend class="legendHeader">Buyers</legend>
                                              <div style="overflow:scroll;height:150px">
                                              <table id="tblMain12" class="bcgl1" width="100%" cellspacing="1" bgcolor="#F0F0FF">
                                                <tr>
                                                  <td width="29" class="normaltxtmidb2" bgcolor="#498CC2"><input type="checkbox" onclick="CheckAll(this,12);"/></td>
                                                  <td width="414" class="normaltxtmidb2" bgcolor="#498CC2">Buyer name</td>
                                                  </tr>
                                                 <?php 
												 $sql="SELECT intMainBuyerId,strMainBuyerName FROM buyers_main WHERE intStatus=1 ORDER BY strMainBuyerName";
												 $result=$db->RunQuery($sql);
												 while($row=mysql_fetch_array($result))
												 {
												 ?>
                                                	<tr class="bcgcolor-tblrowWhite">
                                                  		<td class="normalfntMid"><input type="checkbox" /></td>
                                                  		<td class="normalfnt" id="<?php echo $row["intMainBuyerId"]?>"><?php echo $row["strMainBuyerName"];?></td>
                                                  	</tr>
                                                  <?php
												 }
                                                  ?>
                                                </table></div>
                                              </fieldset>
                                          </div></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(12);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        </div>
                     <div id="div13" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Pending Bank Letter Invoices</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" ><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td width="100%" colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <tr>
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid">&nbsp;</td>
                                            <td width="103">&nbsp;</td>
                                            <td width="123">To Date</td>
                                            <td width="324"><input class="txtbox" type="text" name="txtDto13" id="txtDto13" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(13);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        </div>
                      <div id="div14" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Factorywise Receivable Detailed</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;  Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate14" id="chkDate14" type="checkbox" checked="checked" onclick="ValidateDate(this,14);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom14" id="txtDfrom14" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto14" id="txtDto14" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            </tr>
                                          </table>
                                        </fieldset></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                        <tr>
                                          <td width="459" class="normalfnt"><div>
                                            <fieldset class="roundedCorners_reportHeader">
                                              <legend class="legendHeader">Location</legend>
                                              <div style="overflow:scroll;height:150px">
                                              <table id="tblMain14" class="bcgl1" width="100%" cellspacing="1" bgcolor="#F0F0FF">
                                                <tr>
                                                  <td width="29" class="normaltxtmidb2" bgcolor="#498CC2"><input type="checkbox" onclick="CheckAll(this,14);"/></td>
                                                  <td width="414" class="normaltxtmidb2" bgcolor="#498CC2">Location</td>
                                                  </tr>
                                                 <?php 
												 $sql="SELECT C.strCustomerID,CONCAT(C.strName,' - ',C.strAddress2)AS companyName FROM customers C ORDER BY C.strName";
												 $result=$db->RunQuery($sql);
												 while($row=mysql_fetch_array($result))
												 {
												 ?>
                                                	<tr class="bcgcolor-tblrowWhite">
                                                  		<td class="normalfntMid"><input type="checkbox" /></td>
                                                  		<td class="normalfnt" id="<?php echo $row["strCustomerID"]?>"><?php echo $row["companyName"];?></td>
                                                  	</tr>
                                                  <?php
												 }
                                                  ?>
                                                </table></div>
                                              </fieldset>
                                          </div></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(14);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                      </div>
                      
                        <div id="div15" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Factorywise Receivables Summary With Buyers</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;  Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate15" id="chkDate15" type="checkbox" checked="checked" onclick="ValidateDate(this,15);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom15" id="txtDfrom15" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto15" id="txtDto15" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            </tr>
                                          </table>
                                        </fieldset></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                        <tr>
                                          <td width="459" class="normalfnt"><div>
                                            <fieldset class="roundedCorners_reportHeader">
                                              <legend class="legendHeader">Location</legend>
                                              <div style="overflow:scroll;height:150px">
                                              <table id="tblMain15" class="bcgl1" width="100%" cellspacing="1" bgcolor="#F0F0FF">
                                                <tr>
                                                  <td width="29" class="normaltxtmidb2" bgcolor="#498CC2"><input type="checkbox" onclick="CheckAll(this,15);"/></td>
                                                  <td width="414" class="normaltxtmidb2" bgcolor="#498CC2">Location</td>
                                                  </tr>
                                                 <?php 
												 $sql="SELECT C.strCustomerID,CONCAT(C.strName,' - ',C.strAddress2)AS companyName FROM customers C ORDER BY C.strName";
												 $result=$db->RunQuery($sql);
												 while($row=mysql_fetch_array($result))
												 {
												 ?>
                                                	<tr class="bcgcolor-tblrowWhite">
                                                  		<td class="normalfntMid"><input type="checkbox" /></td>
                                                  		<td class="normalfnt" id="<?php echo $row["strCustomerID"]?>"><?php echo $row["companyName"];?></td>
                                                  	</tr>
                                                  <?php
												 }
                                                  ?>
                                                </table></div>
                                              </fieldset>
                                          </div></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(15);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                      </div>
                      <div id="div16" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Factorywise Receivables Summary</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" class="normalfnt"><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;  Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate16" id="chkDate16" type="checkbox" checked="checked" onclick="ValidateDate(this,16);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom16" id="txtDfrom16" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text3" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto16" id="txtDto16" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text22" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            </tr>
                                          </table>
                                        </fieldset></td>
                                      </tr>
                                    <tr>
                                      <td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                                        <tr>
                                          <td width="459" class="normalfnt"><div>
                                            <fieldset class="roundedCorners_reportHeader">
                                              <legend class="legendHeader">Location</legend>
                                              <div style="overflow:scroll;height:150px">
                                              <table id="tblMain16" class="bcgl1" width="100%" cellspacing="1" bgcolor="#F0F0FF">
                                                <tr>
                                                  <td width="29" class="normaltxtmidb2" bgcolor="#498CC2"><input type="checkbox" onclick="CheckAll(this,16);"/></td>
                                                  <td width="414" class="normaltxtmidb2" bgcolor="#498CC2">Location</td>
                                                  </tr>
                                                 <?php 
												 $sql="SELECT C.strCustomerID,CONCAT(C.strName,' - ',C.strAddress2)AS companyName FROM customers C ORDER BY C.strName";
												 $result=$db->RunQuery($sql);
												 while($row=mysql_fetch_array($result))
												 {
												 ?>
                                                	<tr class="bcgcolor-tblrowWhite">
                                                  		<td class="normalfntMid"><input type="checkbox" /></td>
                                                  		<td class="normalfnt" id="<?php echo $row["strCustomerID"]?>"><?php echo $row["companyName"];?></td>
                                                  	</tr>
                                                  <?php
												 }
                                                  ?>
                                                </table></div>
                                              </fieldset>
                                          </div></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(16);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                      </div>
                      <div id="div17" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">Pending CDN Register</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" ><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td width="4%" class="normalfnt">&nbsp;</td>
                                  <td width="22%" class="normalfnt">Buyer</td>
                                  <td width="74%" >
                                  <select class="normalfnt" name="cboBuyer17" id="cboBuyer17" style="width:400px">
                                  <option value="">All Buyers</option>
                                  <?php
								  $sql="SELECT intMainBuyerId,strMainBuyerName FROM buyers_main WHERE intStatus=1 ORDER BY strMainBuyerName";
								  $result=$db->RunQuery($sql);
								  while($row=mysql_fetch_array($result))
								  {
								?>
									<option value="<?php echo $row["intMainBuyerId"]?>"><?php echo $row["strMainBuyerName"]?></option>
								<?php
                                  }
								  ?>
                                  
                                  </select></td>
                                </tr>
                                <tr>
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate17" id="chkDate17" type="checkbox" checked="checked" onclick="ValidateDate(this,1);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom17" id="txtDfrom17" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto17" id="txtDto17" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
                                    </tr>
                                  </table></td>
                                  </tr>
                                <tr style="display:none">
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice No&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid">&nbsp;</td>
                                            <td width="103">From No</td>
                                            <td width="138"><input class="txtbox" type="text" name="txtInvoNoFrom17" id="txtInvoNoFrom17" style="width:90px;" /></td>
                                            <td width="78">To No</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtInvoNoTo17" id="txtInvoNoTo17" style="width:90px;" /></td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(17);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        </div>
                        <div id="div18" style="height:250px;width:auto; display:none">
                        <table width="100%" border="0" class="tableBorder">
                        <tr>
                          <td height="25" class="ReportTitleHeader">CDN Register</td>
                          </tr>
                        <tr>
                          <td height="75"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="92%" ><table width="100%" border="0" class="tableBorder">
                                <tr>
                                  <td width="4%" class="normalfnt">&nbsp;</td>
                                  <td width="22%" class="normalfnt">Buyer</td>
                                  <td width="74%" >
                                  <select class="normalfnt" name="cboBuyer18" id="cboBuyer18" style="width:400px">
                                  <option value="">All Buyers</option>
                                  <?php
								  $sql="SELECT intMainBuyerId,strMainBuyerName FROM buyers_main WHERE intStatus=1 ORDER BY strMainBuyerName";
								  $result=$db->RunQuery($sql);
								  while($row=mysql_fetch_array($result))
								  {
								?>
									<option value="<?php echo $row["intMainBuyerId"]?>"><?php echo $row["strMainBuyerName"]?></option>
								<?php
                                  }
								  ?>
                                  
                                  </select></td>
                                </tr>
                                <tr>
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice Date&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid"><input name="chkDate18" id="chkDate18" type="checkbox" checked="checked" onclick="ValidateDate(this,1);"  /></td>
                                            <td width="103">Date From </td>
                                            <td width="138"><input class="txtbox" type="text" name="txtDfrom18" id="txtDfrom18" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  value="<?php echo ($txtDfromW=="" ? "":$txtDfromW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                            <td width="78">To</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtDto18" id="txtDto18" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($txtDtoW=="" ? "":$txtDtoW);?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
                                    </tr>
                                  </table></td>
                                  </tr>
                                <tr style="display:none">
                                  <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td colspan="5" height="15"><fieldset class="roundedCorners_reportHeader" >
                                        <legend class="legendHeader">&nbsp;Invoice No&nbsp;</legend>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tr>
                                            <td width="33" class="normalfntMid">&nbsp;</td>
                                            <td width="103">From No</td>
                                            <td width="138"><input class="txtbox" type="text" name="txtInvoNoFrom18" id="txtInvoNoFrom1" style="width:90px;" /></td>
                                            <td width="78">To No</td>
                                            <td width="202"><input class="txtbox" type="text" name="txtInvoNoTo18" id="txtInvoNoTo18" style="width:90px;" /></td>
                                          </tr>
                                        </table>
                                      </fieldset></td>
                                    </tr>
                                    <tr>
                                      <td colspan="3"></td>
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
                                  <td width="25%" align="center"><img src="../../images/new.png" alt="new" onclick="ClearForm();" class="mouseover"/> <img src="../../images/report.png" alt="Report" name="Delete"  border="0" class="mouseover" id="Delete" onclick="viewReport(18);"/><img src="../../images/download.png" alt="dwnload"  border="0" onclick="ShowExcelReport();" style="display:none" /> <a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0" id="Close"/></a></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        </div></td>
                  </tr>
                  <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(3,'<?php echo $PP_AllowProductionWIPReport;?>')">
                <td width="31%" class="normalfnt" id="link1" style="text-align:left;font-size:10px">&nbsp;<b>Buyerwise Exports-Detailed </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(1,'<?php echo $PP_AllowCutQuantityReport;?>')">
                <td id="link2" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Buyerwise Exports-Summary </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(2,'<?php echo $PP_AllowWashingPlanReport;?>')">
                <td id="link3" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Factorywise Exports-Detailed </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(4,'<?php echo $PP_AllowSizeWiseGatePassReport;?>')">
                <td id="link4" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Factorywise Exports-Summary with Buyers </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(5,'<?php echo $PP_AllowProductionSummaryReport;?>')">
                <td id="link5" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Factorywise Exports-Summary </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(6,'<?php echo $PP_AllowProductionDetailReport;?>')">
                <td id="link6" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Destinationwise Exports </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td id="link7" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Exports Receivable - Summary </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td id="link8" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Exports Receivable - Detail</b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td id="link9" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Customs Invoice Register </b></td>
                </tr>
                <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td id="link17" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Pending CDN Register </b></td>
                </tr>
                <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td id="link18" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>CDN Register </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td id="link10" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Final Invoice Register </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td id="link11" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Pending Final Invoice Listing </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td id="link12" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Bank Letter Register </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td id="link13" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Pending Bank Letter Invoice Listing </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td class="normalfnt" id="link14" style="text-align:left;font-size:10px">&nbsp;<b>Factorywise Receivable-Detailed</b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td id="link15" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Factorywise Receivables-Summary with Buyers </b></td>
                </tr>
              <tr class="mouseover" onmouseover="this.style.background ='#C4E9F2';" onmouseout="this.style.background='';" onclick="showdiv(7,'<?php echo $PP_AllowBundleMovementReport;?>')">
                <td id="link16" class="normalfnt" style="text-align:left;font-size:10px">&nbsp;<b>Factorywise Receivables-Summary </b></td>
                </tr>
              </table></td>
            </tr>
        </table></td>
        <td width="11" rowspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

</form>
</body>
</html>
