<?php

session_start();
$backwardseperator = "../";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CAD Consumption</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color:#CCCCCC;
}
-->
</style>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="cad-java.js" type="text/javascript"></script>
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

<body onload="loadItems(
<?php 

	echo "'".$_GET["styleId"]  .   "','" .  $_GET["Fabric"] .  "','" .  $_GET["color"]."'" ;

?>
);">
<form name="frmbom" id="frmbom" >
<table width="940" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td width="100%"><?php 
	include "../Header.php" ;
	include "../Connector.php";?></td>
</tr>
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">CAD Consumption</td>
  </tr>

  <tr>
    <td><table width="100%" border="0">
	
	<tr>
  	<td>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
		
		<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
			<tr>
				<td width="6%" height="24">&nbsp;</td>
			    <td width="12%" class="normalfnt">Style</td>
			    <td width="26%"><select name="cboStyle" class="txtbox" id="cboStyle" style="width:233px" onchange="styleChange(<?php echo $_GET["Fabric"]; ?>);AddSizes();">
				<?php
				
				echo "<option value=\"". '' ."\"></option>" ;
				$SQL = "SELECT DISTINCT orders.intStyleId FROM orders where intStatus=11 ";
				
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intStyleId"] ."</option>" ;
				}
	
	?>
                </select></td>
			    <td colspan="2"><label></label></td>
			    <td width="13%" class="normalfnt">Fabric</td>
			    <td width="27%"><select name="cboFabric" class="txtbox" id="cboFabric" style="width:233px" onchange="fabricChange(<?php echo "'".$_GET["color"]."'"; ?>);" >
                </select></td>
			    <td width="11%">&nbsp;</td>
			</tr>
			
			<tr>
				<td height="24">&nbsp;</td>
			    <td class="normalfnt">Buyer Po </td>
			    <td><select name="cboBuyerPoNo" class="txtbox" id="cboBuyerPoNo" style="width:233px" onchange="buyerPoChange(this.value);">
                </select></td>
			    <td colspan="2">&nbsp;</td>
			    <td class="normalfnt">Color</td>
			    <td><select name="cboColor" class="txtbox" id="cboColor" style="width:233px" onchange="colorChange();AddSizes();">
                </select></td>
			    <td width="11%"><img src="../images/search.png" alt="save" name="butSearch" width="80" height="24" border="0" usemap="#butSearchMap" class="mouseover" id="butSearch" onclick="AddSizes();" /></td>
			</tr>
			<tr>
			  <td height="22">&nbsp;</td>
			  <td class="normalfnt">Width </td>
			  <td><select name="cboWidth"   class="txtbox" id="cboWidth" style="width:233px" onchange="widthChange();">
              </select></td>
			  <td colspan="2"><img src="../images/edit.png" alt="save" name="butAdd"  border="0" class="mouseover" id="butAdd" onclick="showAddWidth();" />
			    </td>
			  <td class="normalfnt">&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			</table>

		</td>
		</tr>
		</table>
	</td>
    </tr>
		
		
    </table></td>
  </tr>
  <tr>
  	<td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="6%">&nbsp;</td>
        <td width="12%"><span class="normalfnt">Buyer Po No</span></td>
        <td width="27%"><label>
          <input name="txtBuyerPoNo" type="text" class="txtbox" id="txtBuyerPoNo" size="30" onfocus="this.blur();"/>
        </label></td>
        <td width="4%">&nbsp;</td>
        <td width="13%" class="normalfnt">Color Ratio Qty </td>
        <td width="29%"><input name="txtColorRatioQty" type="text" class="txtbox" id="txtColorRatioQty" style="text-align:right" size="30" onfocus="this.blur();"/></td>
        <td width="9%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt">Merchandiser</td>
        <td><input name="txtMearchandiser" type="text" class="txtbox" id="txtMearchandiser" size="30" onfocus="this.blur();"/></td>
        <td>&nbsp;</td>
        <td><span class="normalfnt">Total Qty </span></td>
        <td><input name="txtTotalQty" style="text-align:right" type="text" class="txtbox" id="txtTotalQty" size="30" onfocus="this.blur();"/></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><span class="normalfnt">width</span></td>
        <td><input name="txtWidth" type="text" class="txtbox" id="txtWidth" size="30" onfocus="this.blur();"/></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>	</td>
  </tr>
  <tr>
    <td><table width="95%" height="196" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="91%" height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="left" class="normaltxtmidb2">Size / Order Qty / Ratio  </div></td>
        <td width="9%" bgcolor="#9BBFDD" class="normalfnth2"><img src="../images/add-new.png" alt="save" name="butSave" width="109" height="18" class="mouseover" id="butSave" onclick="addNewLine();" /></td>
      </tr>
      <tr>
        <td colspan="2"><div id="divcons2" style="overflow:scroll; height:230px; width:940px;">
            <table width="100" cellpadding="0" border="0" cellspacing="0" id="tblMain">
              <tr>
                <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">DEL</td>
                <td width="6%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Marker Name </td>
                <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Copy </td>
                <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Layer</td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Marker Length YRD </td>
                <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Marker Length Inch </td>
                <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">EFF</td>
                <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Total Yards </td>
                </tr>
              <tr>
                <td class="normalfntMid">&nbsp;</td>
                <td class="normalfntMid"><input name="xx2" onfocus="this.blur();" type="text" class="txtbox" id="xx2"  size="10" /></td>
                <td class="normalfntMid"><input  name="xx" onfocus="this.blur();" type="text" class="txtbox" id="xx"  size="10"  /></td>
                <td class="normalfntMid"><input name="txtColorRatioQty22" type="text" class="txtbox" id="txtColorRatioQty22" style="text-align:right" onfocus="this.blur();" size="10"/></td>
                <td class="normalfntMid"><input name="txtColorRatioQty2242" type="text" class="txtbox" id="txtColorRatioQty2242" style="text-align:right" size="10" onfocus="this.blur();"/></td>
                <td class="normalfntMid"><input name="txtColorRatioQty224" type="text" class="txtbox" id="txtColorRatioQty224" style="text-align:right" size="10" onfocus="this.blur();"/></td>
                <td class="normalfntMid"><input name="txtColorRatioQty223" type="text" class="txtbox" id="txtColorRatioQty223" style="text-align:right" size="10" onfocus="this.blur();"/></td>
                <td class="normalfntMid"><input name="txtColorRatioQty222" type="text" class="txtbox" id="txtColorRatioQty222" style="text-align:right" size="10" onfocus="this.blur();"/></td>
                </tr>
            </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
  <td><table width="100%" border="0" cellpadding="0" cel cellspacing="0" class="bcgl1" >
    <tr>
      <td width="3%">&nbsp;</td>
      <td width="27%" class="normalfnt">Budgeted Piping Consumption (YD)</td>
      <td width="16%"><input name="txtBudgetedConsumption" style="text-align:right" onkeypress="return CheckforValidDecimal(this, 4,event);" type="text" class="txtbox" id="txtBudgetedConsumption" size="20"/></td>
      <td width="1%">&nbsp;</td>
      <td width="28%" class="normalfnt">Piping consumption (YRD)</td>
      <td width="1%">&nbsp;</td>
      <td width="14%"><input name="txtPipingConsumption" type="text" onkeypress="return CheckforValidDecimal(this, 4,event);" style="text-align:right" class="txtbox" id="txtPipingConsumption" size="20" onkeyup="calculateProductionConPc();"/></td>
      <td width="10%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="normalfnt">budgeted Con/PCS (YD)</td>
      <td><input name="txtBudgetedPcs" type="text" style="text-align:right" onkeypress="return CheckforValidDecimal(this, 4,event);" class="txtbox" id="txtBudgetedPcs" size="20"/></td>
      <td>&nbsp;</td>
      <td><table width="98%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="52%" class="normalfnt">Production Con/PCS + </td>
          <td width="18%"><input name="txtPercentage" id="txtPercentage" onkeypress="return CheckforValidDecimal(this, 4,event);" type="text" class="txtbox" size="5" onkeyup="calculateProductionConPc();"/></td>
          <td width="30%" class="normalfnt">% (YRD)</td>
        </tr>
      </table></td>
      <td>&nbsp;</td>
      <td><input name="txtProductionPcs" type="text" style="text-align:right" class="txtbox" id="txtProductionPcs" size="20" onfocus="this.blur();"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="normalfnt">Fabric Recieved - Expected</td>
      <td><input name="txtFabricRecieved" type="text" style="text-align:right" class="txtbox" id="txtFabricRecieved" size="20" onfocus="this.blur();"/></td>
      <td>&nbsp;</td>
      <td class="normalfnt"> Cuttable Qty (YRD)</td>
      <td>&nbsp;</td>
      <td><input name="txtCuttableQty" type="text" style="text-align:right" class="txtbox" id="txtCuttableQty" size="20" onfocus="this.blur();"/></td>
      <td>&nbsp;</td>
    </tr>
  </table>  </td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="12%" height="29">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="10%"><img src="../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="verticalCalculate(this);"/></td>
        <td width="9%"><img src="../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="saveHeader();" /></td>
        <td width="12%"><img src="../images/conform.png" alt="conform" name="butConfirm" width="115" height="24" class="mouseover" id="butConfirm" onclick="conform();" /></td>
        <td width="11%"><img src="../images/report.png" name="butReport" width="108" height="24" class="mouseover" id="butReport" onclick="ViewReport();"/></td>
		<td width="9%"><a href="../../main.php"><img src="../images/btn-email.png" name="butEmail" width="91" height="24" border="0" class="mouseover" id="butEmail" /></a></td>
        <td width="14%"><a href="../../main.php"><img src="../images/close.png" name="butClose" width="97" height="24" border="0" class="mouseover" id="butClose" /></a></td>
        <td width="13%"><label></label></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

<map name="butSearchMap" id="butSearchMap"><area shape="poly" coords="58,5" href="#" />
</map>

<div style="left:365px; top:175px; z-index:10; position:absolute; width: 200px; visibility:hidden;" id="addWidth"><table width="200" height="30" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="41" rowspan="2"><div align="center">Width</div></td>
            <td width="94" rowspan="2"><input name="txtAddWidth" type="text" onkeypress="return CheckforValidDecimal(this, 4,event);" class="txtbox" id="txtAddWidth" size="15" /></td>
            <td width="46" rowspan="2"><img src="../images/manage.png"  name="imageField" width="16" height="16" onclick="addToCombo();"  /></td>
            <td width="17"><img src="../images/cross.png" alt="q"  name="imageField" id="imageField" onclick="closedWidth();" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          
        </table>
		
		
</div>
</body>
</html>


