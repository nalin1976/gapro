<?php
 session_start();
 include "../../Connector.php"; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - PCD Tracking</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="pcdTracking.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>

<script src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery-1.4.4.min.js"></script>

<script type="text/javascript" src="../../javascript/calendar/calendar.js"></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js"></script>

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
<table width="100%" border="0">
<tr><td><?php  include 'Header.php'; ?></td></tr>
<tr><td>
  <table width="1100" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" class="bcgl1">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="4%"><div align="center"><img src="../../images/butt_1.png" width="15" height="15" /></div></td>
          <td width="96%" class="head1">GaPro - PCD Tracking </td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0">
            <!--DWLayoutTable-->
            <tr>
              <td width="50%" height="21"><table width="1100" border="0" class="bcgl1">
                <tr>
                  <td width="85"  class="normalfnt">SC No</td>
                  <td width="190" ><select name="cboSR" class="txtbox" style="width:170px" id="cboSR" onchange="AutoSelect(this,'cboStNo'); loadOrderNo(this,'sc');">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,specification.intSRNO from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by  intSRNO desc;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
	
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="78"  class="normalfnt">Style No </td>
                  <td width="176"><select name="cboStNo" class="txtbox" style="width:170px" id="cboStNo" onchange="AutoSelect(this,'cboSR');loadOrderNo(this,'style');">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId, orders.strStyle from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by orders.strOrderNo ;";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td width="72"  class="normalfnt">Buyer Po No </td>
                  <td width="175" ><select name="cboBpo" class="txtbox" style="width:170px" id="cboBpo">
                    <option value="Select One" selected="selected">Select One</option>

                  </select></td>
                  <td width="112"  class="normalfnt">Buyer</td>
                  <td colspan="2" class="normalfnt"><select name="buyer" class="txtbox" style="width:170px" id="buyer">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "SELECT
buyers.intBuyerID,
CONCAT(buyers.strName,' - ',buyers.buyerCode) as buyerName
FROM
buyers
WHERE
buyers.intStatus = 1
ORDER BY
buyers.strName ASC";
	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
	
			echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["buyerName"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  </tr>
				  

				  
                <tr>
                  <td  class="normalfnt">PCD Date From</td>
                  <td><input name="pcdDateFrom" type="text"  class="txtbox" id="pcdDateFrom" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
                  <td class="normalfnt">PCD Date To</td>
                 <td width="176" ><input name="PcdDateTo" type="text"  class="txtbox" id="PcdDateTo" style="width:90px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" /></td>
                  <td class="normalfnt">Emb. Status</td>
                  <td ><input id="txtEmbType"  class="txtbox" type="text" style="width:175px; text-align:center" disabled="disabled" name="txtEmbType"></td>
                  <td nowrap="nowrap"><input type="checkbox" name="chkBuyerFilter" id="chkBuyerFilter"  />  &nbsp;  Hela Alliance</td>
                  <td width="156"><div align="right"><img src="../../images/search.png" alt="Search" width="80" height="24" class="mouseover" onclick="gatDeta();" /></div></td>
                  <td width="18">&nbsp;</td>
                </tr>
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td align="center" colspan="2"><div align="center" id="divData" style="width:1100px; height:500px; overflow: scroll; border-width:3px; border-style:solid;border-color:#99CCFF;">
            <table width="1090" border="0" cellpadding="0" cellspacing="1" class="bcgl1" id="tblBomDetails" >
              <tr>
                <td width="10%" height="19" bgcolor="#498CC2" class="normaltxtmidb2">SC#</td>
                <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">BPO#</td>
                <td width="14%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer</td>
                <td width="14%" bgcolor="#498CC2" class="normaltxtmidb2">Mat. Description</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Bom Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Po Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">GRN Qty</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Grn Date</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Mat Plan Date</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">PCD Date</td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Status</td>
                
				<!--<td width="15%" bgcolor="#498CC2" class="normaltxtmidb2">Detail Rpt</td>-->
              </tr>
				<tbody id='aaa'>
                </tbody>
            </table>
          </div></td>
        </tr>
        
 
            </table>
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
    </tr>
  </table>
  </td></tr></table>

</body>
</html>
