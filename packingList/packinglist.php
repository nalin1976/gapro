<?php
$backwardseperator = "../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Packing List</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
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
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="packinglist-java.js" type="text/javascript"></script>
<script src="packinglist-java.js" type="text/javascript"></script>
<script type="text/javascript" >
	function pageSubmit()
	{
		document.getElementById("frmbom").submit();
	}
	

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
</head>

<body>

<?php
	include "../Connector.php";	
?>
<form name="frmbom" id="frmbom" action="Details/grndetails.php" method="post" >
<table width="950" height="546" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../Header.php'; ?></td>
</tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1">
      <tr>
        <td height="36" colspan="8"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td width="4%" height="24" bgcolor="#498CC2" >&nbsp;</td>
            <td width="8%" bgcolor="#498CC2" class="normalfnt">&nbsp;</td>
            <td width="3%" bgcolor="#498CC2" class="normalfnt">&nbsp;</td>
            <td width="6%" bgcolor="#498CC2" class="normalfntSM">&nbsp;</td>
            <td width="16%" bgcolor="#498CC2" class="TitleN2white">PACKING LIST </td>
            <td width="2%" bgcolor="#498CC2" class="normalfntSM">&nbsp;</td>
            <td width="17%" bgcolor="#498CC2" class="normalfnt">&nbsp;</td>
            <td width="9%" bgcolor="#498CC2" class="normalfnt">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td width="17%" class="normalfnt">Packing List No </td>
        <td class="normalfnt"><input name="txtPackingListNo" type="text" class="txtbox" id="txtPackingListNo" size="25" onfocus="this.blur();" /></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Company</td>
        <td class="normalfnt"><select name="cboCompany" class="txtbox" id="cboCompany" style="width:160px" >
		<option value="" >Select One</option>
            <?php
			$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus=1 order by strName;";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
			}
			?>
        </select></td>
        <td width="5%" class="normalfnt">&nbsp;</td>
        <td width="12%" class="normalfnt">Hanger</td>
        <td width="16%" class="normalfnt"><input name="chkHanger" type="checkbox" class="txtbox" id="chkHanger" value="checkbox" />         </td>
      </tr>
      <tr>
        <td class="normalfnt">No Of Cartons</td>
        <td class="normalfnt"><input name="txtNoOfCartons" type="text" class="txtbox" id="txtNoOfCartons" size="25" onfocus="this.blur();" /></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Quantity</td>
        <td class="normalfnt"><input name="txtQuantity" type="text" class="txtbox" id="txtQuantity" size="25" onfocus="this.blur();" /></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Price Ticket</td>
        <td class="normalfnt"><input name="chkPriceTicket" type="checkbox" class="txtbox" id="chkPriceTicket" value="checkbox" /></td>
      </tr>
      <tr>
        <td class="normalfnt">CTN Measurements</td>
        <td width="16%" class="normalfnt"><input name="txtCtnMeasurements" type="text" class="txtbox" id="txtCtnMeasurements" size="25" /></td>
        <td width="5%" class="normalfnt">&nbsp;</td>
        <td width="10%" class="normalfnt">Gross Mass</td>
        <td width="19%" class="normalfnt"><input name="txtGrossMass" type="text" class="txtbox" id="txtGrossMass" size="25" onfocus="this.blur();" /></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Price Sticker</td>
        <td class="normalfnt"><input name="chkPriceSticker" type="checkbox" class="txtbox" id="chkPriceSticker" value="checkbox" /></td>
      </tr>
      <tr>
        <td class="normalfnt">Buyer PO No</td>
        <td class="normalfnt"><input name="txtBuyerPoNo" type="text" class="txtbox" id="txtBuyerPoNo" size="25" onfocus="this.blur();" /></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Net Mass</td>
        <td class="normalfnt"><input name="txtNetMass" type="text" class="txtbox" id="txtNetMass" size="25" onfocus="this.blur();" /></td>
        <td >&nbsp;</td>
        <td class="normalfnt" >Leg Sticker</td>
        <td class="normalfnt"><input name="chkLegSticker" type="checkbox" class="txtbox" id="chkLegSticker" value="checkbox" /></td>
      </tr>
      <tr>
        <td class="normalfnt">Style No</td>
        <td class="normalfnt"><input name="txtStyleNo" type="text" class="txtbox" id="txtStyleNo" size="25" onfocus="this.blur();" /></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">C.B.M</td>
        <td class="normalfnt"><input name="txtCbm" type="text" class="txtbox" id="txtCbm" size="25" onfocus="this.blur();" /></td>
        <td >&nbsp;</td>
        <td class="normalfnt" >PO/Flasher</td>
        <td class="normalfnt"><input name="chkPoFlasher" type="checkbox" class="txtbox" id="chkPoFlasher" value="checkbox" /></td>
      </tr>
      <tr>
        <td class="normalfnt">Pre Pack</td>
        <td class="normalfnt"><select name="cboPrePack" class="txtbox" id="cboPrePack" style="width:160px" >
		<option value="">Select One</option>
		<option value="SOLID">SOLID</option>
		<option value="RATIO">RATIO</option>
        </select></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Pro Code</td>
        <td class="normalfnt"><input name="txtProCode" type="text" class="txtbox" id="txtProCode" size="25"  /></td>
        <td >&nbsp;</td>
        <td class="normalfnt" >Belt</td>
        <td class="normalfnt"><input name="chkBelt" type="checkbox" class="txtbox" id="chkBelt" value="checkbox" /></td>
      </tr>
      <tr>
        <td class="normalfnt">Label</td>
        <td class="normalfnt"><input name="txtLabel" type="text" class="txtbox" id="txtLabel" size="25" /></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Com. Code</td>
        <td class="normalfnt"><input name="txtComCode" type="text" class="txtbox" id="txtComCode" size="25"  /></td>
        <td >&nbsp;</td>
        <td class="normalfnt" >Hanger Tag</td>
        <td class="normalfnt"><input name="chkHangerTag" type="checkbox" class="txtbox" id="chkHangerTag" value="checkbox" /></td>
      </tr>
      <tr>
        <td class="normalfnt">Line No</td>
        <td class="normalfnt"><input name="txtLineNo" type="text" class="txtbox" id="txtLineNo" size="25" /></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Fabric</td>
        <td class="normalfnt"><input name="txtFabric" type="text" class="txtbox" id="txtFabric" size="25" /></td>
        <td >&nbsp;</td>
        <td class="normalfnt" >Jocker Tag</td>
        <td class="normalfnt"><input name="chkJockerTag" type="checkbox" class="txtbox" id="chkJockerTag" value="checkbox" /></td>
      </tr>
    </table>
      </td>
  </tr>
  <tr>
        <td height="36" colspan="8"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1" >
          <tr>
            <td height="24"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="3%" class="normalfnt">&nbsp;</td>
                <td width="7%" class="normalfnt">Style Id  </td>
                <td width="17%" class="normalfnt"><span class="normalfnt">
                  <select name="cboStyleId" class="txtbox" id="cboStyleId" style="width:160px" onchange="loadGridDetails();" >
				  	<option value="" >Select One</option>
					<?php
					$SQL = "SELECT
							specification.intStyleId
							FROM
							specification
							WHERE
							specification.intStyleId IS NOT NULL  AND
							specification.intStyleId<>  ''";
					$result = $db->RunQuery($SQL);
					while($row = mysql_fetch_array($result))
					{
					echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intStyleId"] ."</option>" ;
					}
					?>
                  </select>
                </span></td>
                <td width="3%" class="normalfnt">&nbsp;</td>
                <td width="10%" class="normalfnt">Packing Type</td>
                <td width="17%" class="normalfnt"><select name="cboPackingType" class="txtbox" id="cboPackingType" style="width:160px" onchange="loadGridDetails();" >
				<option value="">Select One</option>
                  <option >Cartons</option>
                  <option >Hanging</option>
                                </select></td>
                <td width="3%" class="normalfnt">&nbsp;</td>
                <td width="3%" class="normalfnt"><input name="rdoUnitType" checked="checked" type="radio" class="rdoPcs" id="radiobutton" value="radiobutton" />
                  </td>
                <td width="3%" class="normalfnt">PCS</td>
                <td width="3%" class="normalfnt">&nbsp;</td>
                <td width="3%" class="normalfnt"><input name="rdoUnitType" type="radio" class="rdoSets" id="radio" value="radiobutton" /></td>
                <td width="3%" class="normalfnt">Sets</td>
                <td width="1%" class="normalfnt">&nbsp;</td>
                <td width="3%" class="normalfnt"><input name="rdoUnitType" type="radio" class="txtbox" id="rdoColorPack" value="radiobutton" /></td>
                <td width="7%" class="normalfnt">Color Pack </td>
                <td width="1%" class="normalfnt">&nbsp;</td>
                <td width="3%" class="normalfnt"><input name="rdoUnitType" type="radio" class="txtbox" id="rdoSizePack" value="radiobutton" /></td>
                <td width="8%" class="normalfnt">Size Pack </td>
                <td width="2%" class="normalfnt">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
   </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="80%" align="left" bgcolor="#9BBFDD" class="normalfnth2">&nbsp;</td>
        <td width="9%" align="left" bgcolor="#9BBFDD" class="normalfnth2"><span class="normalfnt"><img src="../images/addcolor.png" alt="add new" name="butAddColor" class="mouseover" id="butAddColor" onclick="ShowItems()" /></span></td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt"><img src="../images/addlengths.png" alt="add new" name="butAddLengths" class="mouseover" id="butAddLengths" onclick="ShowItems()" /></td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnt"><div id="divGrid" style="overflow:scroll; height:250px; width:950px;">
          <table  width="1200" border="0" cellpadding="0" cellspacing="1" bordercolor="#162350" bgcolor="#CCCCFF" id="tblMainGrid">
            <tr>
              <td  width="3%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
              <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Buyer PO</td>
				  <td width="3%" bgcolor="#498CC2" class="normaltxtmidb2">SH</td>
              <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Length</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Sticker</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Container</td>
              <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">From</td>
              <td width="3%" bgcolor="#498CC2" class="normaltxtmidb2">To </td>
              <td width="3%" bgcolor="#498CC2" class="normaltxtmidb2">CTNs</td>
              <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
			  <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">PSC/CTN</td>
              <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Total</td>
              <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Gross WGT</td>
			  <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Net WGT</td>
			  <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Net-Net WGT</td>
              <!--          </tr>
              <td  height="80" class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
			  <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td colspan="3"    class="normaltxtmidb2"><img src="../../images/loading5.gif" width="100" height="100" border="0"  /></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
           </tr>-->
            <tr>
                <td height="18" colspan="17" bgcolor="#FFFFFF" >&nbsp;</td>
                </table>
        </div></td>
        </tr>
        
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="14%" height="29">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="10%"><img src="../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="newPage();"/> </td>
        <td width="9%"><img src="../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="save();" /></td>
        <td width="10%"><a  target="_blank" href="report.php"><img border="0" src="../images/report.png" name="butReport" width="108" height="24" class="mouseover" id="butReport" /></a></td>
        <td width="14%"><a href="../main.php"><img src="../images/close.png" name="butClose" width="97" height="24" border="0" class="mouseover" id="butClose" /></a></td>
        <td width="10%">&nbsp;</td>
        <td width="23%">&nbsp;</td>
      </tr>
    </table></td></tr>
</table>
</form>
</body>
</html>


