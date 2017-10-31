<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	include $backwardseperator."authentication.inc";	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>OutSide PO</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />

<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="outsidepo.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
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
<form id="outsidepo" name="outsidepo" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include $backwardseperator.'Header.php';?></td>
  </tr>
  <tr>
    <td><table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="900" border="0" cellspacing="0" cellpadding="2" align="center" class="bcgl1"><tr><td>
        <table width="900" border="0" cellspacing="1" cellpadding="1" align="center" class="normalfnt">
          <tr>
            <td colspan="6" class="mainHeading" height="25">OutSide PO</td>
            </tr>
          <tr>
            <td width="144">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td width="195">&nbsp;</td>
            <td width="273">&nbsp;</td>
          </tr>
          <tr>
            <td>Search</td>
            <td colspan="3"><select tabindex="1" onChange="searchData();" name="cboSearch" id="cboSearch" style="width:200px;">
              <?php
			
			$sql="select intPONo,intId from was_outsidepo order by intPONo";
						$result=$db->RunQuery($sql);
							echo "<option value="."".">"." "."</option>\n";
						while($row=mysql_fetch_array($result))
						{
							echo "<option value=".$row["intId"].">".$row["intPONo"]."</option>\n";
						}
			
			?>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>PO No</td>
            <td colspan="3"><input type="text" tabindex="2" name="txtPONo" id="txtPONo" maxlength="30" style="width:200px;"></td>
            <td>Date</td>
            <td><input tabindex="13" type="text" name="txtDate" id="txtDate" onMouseDown="DisableRightClickEvent();"  onmouseout="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);" value="<?php echo date('Y-m-d');?>" onClick="return showCalendar(this.id, '%Y-%m-%d');" style="width:200px;"><input type="radio"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/></td>
          </tr>
          <tr>
            <td>Fabric ID</td>
            <td colspan="3"><select tabindex="3" onChange="loadDetails();" name="cboFabric" id="cboFabric" style="width:200px;">
                <?php
			
			$sql="select strFabricId,intID from was_outsidewash_fabdetails order by strFabricId";
						$result=$db->RunQuery($sql);
							echo "<option value="."".">"." "."</option>\n";
						while($row=mysql_fetch_array($result))
						{
							echo "<option value=".$row["intID"].">".$row["strFabricId"]."</option>\n";
						}
			
			?>
            </select></td>
            <td>Style Name</td>
            <td><input tabindex="14" type="text" name="txtStyleName" id="txtStyleName" maxlength="50" style="width:200px;"></td>
          </tr>
          <tr>
            <td>Style No </td>
            <td colspan="3"><input tabindex="4" type="text" name="txtStyleNo" id="txtStyleNo" maxlength="50" style="width:200px;"></td>
            <td>Fabric Description</td>
            <td><input tabindex="15" type="text" name="txtFabricDes" id="txtFabricDes" maxlength="50"  style="width:200px;"></td>
          </tr>
          <tr>
            <td>Division</td>
            <td colspan="3"><select tabindex="5" name="cboDivision" id="cboDivision" style="width:200px;">
          <?php
			
			$sql="select was_outsidewash_fabdetails.intDivision,buyerdivisions.strDivision from was_outsidewash_fabdetails,buyerdivisions where was_outsidewash_fabdetails.intDivision=buyerdivisions.intDivisionId order by buyerdivisions.strDivision";
						$result=$db->RunQuery($sql);
							echo "<option value="."".">"." "."</option>\n";
						while($row=mysql_fetch_array($result))
						{
							echo "<option  value=".$row["intDivision"]." >".$row["strDivision"]."</option>\n";
						}
			
			?>
		    </select></td>
            <td>Fabric Content</td>
            <td><input tabindex="16" type="text" name="txtFabricCon" id="txtFabricCon" maxlength="50" style="width:200px;"></td>
          </tr>
          <tr>
            <td>Color</td>
            <td colspan="3"><select tabindex="6" name="cboColor" id="cboColor" style="width:200px;">
			<?php
			
			$sql="select strColor from colors order by strColor";
						$result=$db->RunQuery($sql);
							echo "<option value="."".">"." "."</option>\n";
						while($row=mysql_fetch_array($result))
						{
							echo "<option >".$row["strColor"]."</option>\n";
						}
			
			?>
            </select></td>
            <td>Mill</td>
            <td><select tabindex="17" name="cboMill" id="cboMill" style="width:200px;">
			<?php
			
			$sql="select strSupplierID,strTitle from suppliers where intStatus=1 order by strTitle";
						$result=$db->RunQuery($sql);
							echo "<option value="."".">"." "."</option>\n";
						while($row=mysql_fetch_array($result))
						{
							echo "<option  value=".$row["strSupplierID"]." >".$row["strTitle"]."</option>\n";
						}
			
			?>
            </select></td>
          </tr>
          <tr>
            <td>Garment</td>
            <td colspan="3"><select tabindex="7" name="cboGarment" id="cboGarment" style="width:200px;">
			<?php
			
			$sql="select intGamtID,strGarmentName from was_garmenttype where intStatus=1 order by strGarmentName" ;
						$result=$db->RunQuery($sql);
							echo "<option value="."".">"." "."</option>\n";
						while($row=mysql_fetch_array($result))
						{
							echo "<option  value=".$row["intGamtID"]." >".$row["strGarmentName"]."</option>\n";
						}
			
			?>
            </select></td>
            <td>Wash Type</td>
            <td><select tabindex="18" name="cboWashType" id="cboWashType" style="width:200px;">
			<?php
			
			$sql="select intWasID,strWasType from was_washtype where intStatus=1 order by strWasType";
						$result=$db->RunQuery($sql);
							echo "<option value="."".">"." "."</option>\n";
						while($row=mysql_fetch_array($result))
						{
							echo "<option  value=".$row["intWasID"]." >".$row["strWasType"]."</option>\n";
						}
			
			?>
            </select></td>
          </tr>
          <tr>
            <td>Size</td>
            <td colspan="3"><select tabindex="8" name="cboSize" id="cboSize" style="width:200px;">
                <?php
			
			$sql="select Distinct strSize from sizes order by strSize";
						$result=$db->RunQuery($sql);
							echo "<option value="."".">"." "."</option>\n";
						while($row=mysql_fetch_array($result))
						{
							echo "<option >".$row["strSize"]."</option>\n";
						}
			
			?>
            </select></td>
            <td>Factory</td>
            <td><select tabindex="19" name="cboFactory" id="cboFactory" style="width:200px;">
			<?php
			
			$sql="select intCompanyID,strName from was_outside_companies where intStatus=1 order by strName";
						$result=$db->RunQuery($sql);
							echo "<option value="."".">"." "."</option>\n";
						while($row=mysql_fetch_array($result))
						{
							echo "<option  value=".$row["intCompanyID"]." >".$row["strName"]."</option>\n";
						}
			
			?>
            </select></td>
          </tr>
          <tr>
            <td>Order Qty</td>
            <td width="137"><input tabindex="9" type="text" name="txtOrderQty" id="txtOrderQty" value="" style="width:120px;" onKeyPress="return IsNumberWithoutDecimals(this,event);"></td>
            <td width="27">Ex</td>
            <td width="112"><input tabindex="10" type="text" name="txtEx" id="txtEx" value="0" maxlength="3" style="width:30px; text-align:right;" onKeyPress="return IsNumberWithoutDecimals(this,event);">
              %</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
           <tr>
             <td>Cut Qty</td>
             <td colspan="3"><input tabindex="11" type="text" name="txtCutQty" id="txtCutQty" value="" style="width:120px;" onKeyPress="return IsNumberWithoutDecimals(this,event);"></td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
           </tr>
           <tr>
            <td>Wash Qty</td>
            <td colspan="3"><input tabindex="12" type="text" name="txtWashQty" id="txtWashQty" value="" style="width:120px;" onKeyPress="return IsNumberWithoutDecimals(this,event);"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="900" border="0" cellspacing="0" cellpadding="2" class="bcgl1">
          <tr>
            <td width="402" align="right"><img src="../../images/new.png" tabindex="22" width="96" height="24" class="mouseover" id='btnNew'></td>
            <td width="88" ><img src="../../images/save.png" tabindex="20" width="84" height="24" class="mouseover" id='btnSave'></td>
            <td width="410"><img src="../../images/delete.png" tabindex="21" width="100" height="24" class="mouseover" id='btnDelete'></td>
            
          </tr>
        </table></td>
      </tr>
    </table></td></tr></table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
