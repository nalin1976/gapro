<?php

session_start();
$backwardseperator = "../../";
include "{$backwardseperator}authentication.inc";
$companyId=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Allocation List</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="bulkAlloReport.js" type="text/javascript"></script>
<script type="text/javascript">
//----------------------hem-------------------------------------------------------------------
</script>
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
<script language="javascript" type="text/javascript">
var comID ="<?php echo $_SESSION["FactoryID"];?>";
</script>
</head>

<body>
<?php
	include "../../Connector.php";	
?>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include "../../Header.php";?></td>
  </tr>
  <tr>
    <td><table width="950" border="0" align="center">
      <tr>
        <td width="28%">&nbsp;</td>
        <td width="51%"><form name="frmBulkAlloRpt" id="frmBulkAlloRpt" method="post" action="">
          <table width="922" border="0" class="tableBorder">
            <tr>
              <td width="920" height="16" bgcolor="#498CC2" class="mainHeading">Allocation List</td>
            </tr>
            <tr>
              <td height="17"><table width="100%" border="0">
			  <tr>
			  <td colspan="2"></td>
			  <td width="68"></td>
			  <td width="123"></td>
			  <td width="140"></td>
			  <td width="62"></td>
			  <td width="120"></td>
			  <td width="37"></td>
			  <td width="141"></td>
			  <td width="121"></td>
			  </tr>
                <tr>
                  <td width="23" class="normalfnt"><input type="radio" id="orderNo" name="orderOrBulk" value="1" tabindex="1" onclick="disableCombo(this.value);"/></td>
					<td width="51" class="normalfnt">Order</td>
					<td class="normalfnt">Order No </td>
                    <td><select name="cboOrder"  id="cboOrder" class="txtbox" style="width:105px" tabindex="2" disabled="disabled">
                      <?php
						$SQL = "SELECT distinct CBH.intToStyleId, O.strStyle
								from commonstock_bulkheader CBH inner join orders O on
								CBH.intToStyleId = O.intStyleId 
								where CBH.intStatus=1 and CBH.intCompanyId = '$companyId' order by  O.strStyle ";
								
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["intToStyleId"] ."\">" . $row["strStyle"] . "</option>";
						}
					?>
                    </select> </td>
					<td></td>
					<td class="normalfnt">Item</td>
					<td colspan="3"><select name="cboItem"  id="cboItem" class="txtbox" style="width:295px" tabindex="3">
                      <?php
						$SQL = "SELECT DISTINCT	bGRN.intMatDetailID, m.strItemDescription
								FROM bulkgrndetails bGRN inner join matitemlist m on
								bGRN.intMatDetailID = m.intItemSerial 
								order by m.strItemDescription";
								
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["intMatDetailID"] ."\">" . $row["strItemDescription"] . "</option>";
						}
					?>
                    </select></td>
					<td></td>
                </tr>
				
                <tr>
                  <td class="normalfnt"><input type="radio" id="BulkPONo" name="orderOrBulk" value="0" tabindex="4" onclick="disableCombo(this.value);" /></td>
                  <td class="normalfnt">Bulk PO</td>
                  <td class="normalfnt">Bulk PO No</td>
                  <td><select name="cboBulkPO"  id="cboBulkPO" class="txtbox" style="width:105px" tabindex="5" disabled="disabled">
                    <?php
						$SQL = "SELECT DISTINCT  concat(CBulkDet.intBulkPOYear,'/',CBulkDet.intBulkPoNo) as BPONo,
								concat(CBulkDet.intBulkPOYear,'/',CBulkDet.intBulkPoNo) as BPO
								from commonstock_bulkdetails CBulkDet inner join commonstock_bulkheader CBulkH on
								CBulkH.intTransferNo = CBulkDet.intTransferNo and 
								CBulkH.intTransferYear = CBulkDet.intTransferYear
								where CBulkH.intStatus=1 and CBulkH.intCompanyId='$companyId'
								order by CBulkDet.intBulkPOYear,CBulkDet.intBulkPoNo";
						
						$result = $db->RunQuery($SQL);
						
						echo "<option value = \"". "" . "\">" . "" . "</option>";
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row["BPONo"] ."\">" . $row["BPO"] . "</option>";
						}
					?>
                  </select></td>
                  <td><img  src="../../images/print.png" alt="print" name="butPrint" id="butPrint2" tabindex="6" class="mouseover" onclick="openStyleReport();"/></td>
                  <td class="normalfnt">From</td>
                  <td><input name="txtFromDate" type="text" tabindex="9" class="txtbox" id="txtFromDate" style="width:94px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                  <td class="normalfnt">To</td>
                  <td><input name="txtToDate" type="text" tabindex="9" class="txtbox" id="txtToDate" style="width:97px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                  <td><img  src="../../images/print.png" alt="print" name="butPrint" id="butPrint" tabindex="6" class="mouseover" onclick="openBulkUtilizationReport();"/></td>
                <tr>
                  <td colspan="10" class="normalfnt"><table width="910" border="0" cellspacing="0" cellpadding="2" align="center" class="bcgl1">
                    <tr>
                      <td width="411"><input type="checkbox" name="chkTodayAllo" id="chkTodayAllo" />
                        Today Allocation</td>
                      <td width="65">Date From</td>
                      <td width="120"><input name="txtTodayAllFromDate" type="text" tabindex="9" class="txtbox" id="txtTodayAllFromDate" style="width:94px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                      <td width="42">To</td>
                      <td width="165"><input name="txtTodayAllToDate" type="text" tabindex="9" class="txtbox" id="txtTodayAllToDate" style="width:97px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                      <td width="93"><img src="../../images/view.png" width="91" height="19" onclick="viewAllocationData();" /></td>
                    </tr>
                    <tr>
                      <td colspan="6"><table width="910" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
                        <tr>
                          <td><div id="divcons" style="overflow:scroll; height:300px; width:910px;">
							<!-- Populating Table Grid with Events [start]-->
                              <table width="100%" cellpadding="0" cellspacing="1" id="tblevents" bgcolor="#CCCCFF">
                                <tr>
                                  <td width="3%" bgcolor="#804000" class="normaltxtmidb2L"></td>
                                  <td width="18%" height="18" bgcolor="#804000" class="normaltxtmidb2L">Bulk Allocation No</td>
                                  <td width="18%" bgcolor="#804000" class="normaltxtmidb2L">Style No</td>
                                  <td width="14%" bgcolor="#804000" class="normaltxtmidb2L">Enterd By</td>
                                  <td width="16%" height="18" bgcolor="#804000" class="normaltxtmidb2L">Date</td>
                                  <td width="31%" bgcolor="#804000" class="normaltxtmidb2L">Description</td>
                                </tr>
                              </table>
                          </div></td>
                        </tr>
                      </table></td>
                      </tr>
                  </table></td>
				  </table></td>
            </tr>
            <tr class="bcgl1">
              <td ><table width="927" border="0" class="bcgl1">
			 
			  <tr bgcolor="#FFD5AA">
				<td width="919" bgcolor=""><table width="100%" border="0" class="tableFooter">
                    <tr>
                      <td width="14%">&nbsp;</td>
                      <td width="19%">&nbsp;</td>
                      <td width="11%">&nbsp;</td>
					          <td width="13%" class="normalfnt">&nbsp;</td>
                      <td width="30%" id="td_coDelete"><a href="../../main.php"></a></td>
                      <td width="0%">&nbsp;</td>
                      <td width="13%"><a href="../../main.php"><img  class="mouseover" src="../../images/close.png" alt="Close" name="Close" id="butClose" tabindex="11" border="0"/></a></td>
                    </tr>
                </table></td>
			  </tr>
		  </table></td>
		</tr>

          </table>
        </form></td>
        <td width="21%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
