<?php
	session_start();
	$backwardseperator = "../";
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	include "../authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Bulk Gate Pass</title>
<script type="text/javascript" src="bulkgatepass.js"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<!--start -for calander-->
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script type="text/javascript" src="../fabricrollinspectionpopup/fabricrollinspectionpopup.js"></script>
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
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script type="text/javascript">
var factoryID = <?php

 echo $_SESSION["CompanyID"]; 
 ?>;
var UserID = <?php

 echo $_SESSION["UserID"]; 
 ?>;
var EscPercentage = 0.25;
 
var serverDate = new Date();
serverDate.setYear(parseInt(<?php
echo date("Y"); 
?>));
serverDate.setMonth(parseInt(<?php
echo date("m"); 
?>));
serverDate.setDate(parseInt(<?php
echo date("d")+1; 
?>));


</script>

<script src="../javascript/script.js" type="text/javascript"></script>
<script src="java.js" type="text/javascript"></script>
<!--End -for calander-->
</head>
<script type="text/javascript">
var xml_FabricRollInspectionAllow = '<?php

$xml = simplexml_load_file('../config.xml');
$esc = $xml->styleInventory->AllowFabricRollInspection;
echo $esc;
?>';
</script>

<body onload="loadGatePassDetails(
<?php 	
$id = $_GET["id"];
if($id!=0)
{
	echo $_GET["GatePassNo"] ; echo "," ; echo $_GET["GatePassYear"] ; echo "," ; echo $_GET["Status"];
}
else
	echo "0,0,99";
?> );">

<form id="frmgatepass" name="frmgatepass">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">
  <tr>
    <td height="26" class="mainHeading">Bulk Gate Pass</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td valign="top"><table width="100%" border="0" class="bcgl1">
		<tr>
			<td colspan="8" class="normalfnt"><table width="213" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
              <tr>
                <td width="122" style="text-align:center">
                  <input name="radiobutton" type="radio" value="I" checked="checked" id="optInternal" onchange="LoadStores(this.value)"/>
                  Internal</td>
                <td width="123" style="text-align:center">
                    <input name="radiobutton" type="radio" value="E" id="optExternal" onchange="LoadStores(this.value)"/>
					External                </td>
              </tr>
            </table></td>
			</tr>
            <tr>
<?PHP
$sqlsetting="select strValue from settings where strKey='CommonStockActivate'";
$result_setting=$db->RunQuery($sqlsetting);
while($row_setting=mysql_fetch_array($result_setting))
{
	$commonBinID	= $row_setting["strValue"];	
}	
?>
              <td width="11%" class="normalfnt">Attention By </td>
              <td colspan="3"><input name="txtAttention" type="text" class="txtbox" id="txtAttention" style="width:322px" maxlength="60"/></td>
              <td width="10%" class="normalfnt">Main Store</td>
              <td colspan="3">
                <select name="cboMainStore" id="cboMainStore" style="width:210px;" onchange="getCommonBinDetails(0)" >
                  <?php 
							  
							  $SQL="select strMainID,strName from mainstores  where intCompanyId = '$companyId'";
			$result=$db->RunQuery($SQL);
		
			echo "<option value=\"".""."\">"."Select Main Store"."</option>";
			
		while($row=mysql_fetch_array($result))
		{
			echo "<option value =\"".$row["strMainID"]."\">".$row["strName"]."</option>";
		}
							  ?>
                </select></td>
            </tr>
            <tr>
              <td class="normalfnt">Destination</td>
              <td colspan="3"><select name="cboDestination" class="txtbox" id="cboDestination"  style="width:325px" >
                <?php
$xml = simplexml_load_file('../config.xml');
$AllowSubContractorToGatePass = $xml->styleInventory->AllowSubContractorToGatePass;
$SQL="";
if($AllowSubContractorToGatePass=="true"){	
	$SQL="select strSubContractorID,strName from subcontractors  where intStatus =1";
	$result=$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">"."Select Destination"."</option>";
		
	while($row=mysql_fetch_array($result))
	{
		echo "<option value =\"".$row["strSubContractorID"]."\">".$row["strName"]."</option>";
	}
}
else{
	$SQL="select strMainID,strName from mainstores  where intCompanyId <> '$companyId'";
	$result=$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">"."Select Destination"."</option>";
		
	while($row=mysql_fetch_array($result))
	{
		echo "<option value =\"".$row["strMainID"]."\">".$row["strName"]."</option>";
	}
	
}
			  
?>
              </select></td>
              <td class="normalfnt">Gate Pass No</td>
              <td width="9%"><input  type="text" name="cboGatePassNo" class="txtbox" id="cboGatePassNo" style="width:80px" readonly="" /></td>
              <td width="4%"><span class="normalfnt">Date</span></td>
              <td width="21%"><input name="gatePassDate" type="text" class="txtbox" id="gatePassDate"  style="width:80px" value="<?php echo date ("d/m/Y") ?>" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reseta" type="text"  class="txtbox" style="visibility:hidden;width:5px" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
            </tr>
            <tr>
              <td class="normalfnt">Remarks</td>
              <td colspan="3"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks"  style="width:322px" maxlength="100"/></td>
              <td class="normalfnt">No Of Packages </td>
              <td colspan="3"><input  type="text" name="txtNoOfPackages" class="txtbox" id="txtNoOfPackages" style="width:80px;text-align:right" onkeypress="return IsNumberWithoutDecimals(this.value,event);"/></td>
            </tr>

        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" >
      <tr>
        <td class="mainHeading2"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td width="31%" id="commonBinID">&nbsp;</td>
            <td width="44%" >&nbsp;</td>
            <td width="25%" ><img src="../images/add-new.png" id="cmdAddNew" alt="add new" width="109" height="18" onclick="LoadGatePassItems();"/><img src="../images/add_bin.png" id="cmdAutoBin" onclick="autoBin();" style="display:none" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divGatePassMain" style="overflow:scroll; height:300px; width:950px;" class="tableBorder">
          <table id="tblGatePassMain"width="1000" border="0" cellpadding="0" cellspacing="1"  bgcolor="#CCCCFF" >
            <tr class="mainHeading4">
              <td width="2%" height="25">Del</td>
              <td width="14%">Material</td>
              <td width="21%">Detail</td>
              <td width="8%">Color</td>
              <td width="6%">Size</td>
              <td width="5%">Unit</td>
              <td width="7%">Stock Bal</td>
              <td width="7%">GP Qty</td>
              <td width="3%">RTN</td>
              <td width="2%">Bin</td>		
			  <td width="3%">GRN<br/>No</td>
              <td width="3%">GRN<br/>Year</td>
              </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr >
    <td height="30"><table width="100%" border="0" class="bcgl1">
      <tr >	
        <td class="normalfnt" style="text-align:center" ><a href="bulkgatepass.php">
        <img src="../images/new.png" alt="new" border="0" id="cmdNew" width="96" height="24" /></a><img src="../images/save.png" alt="Save" width="84" id="cmdSave" height="24" onclick="SaveValidation(0);" /><img src="../images/conform.png" alt="confirm" id="cmdConfirm" width="115" height="24" style="visibility: visible" onclick="Confirm();"/><img src="../images/report.png" alt="Report" border="0" width="108" height="24" onclick="ViewReport();" /><a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0" /></a></td>
        <!--<td width="12%" class="normalfnt"><img src="../images/cancel.jpg" alt="cancel" id="cmdCancel" width="104" height="24" onclick="Cancel();" /></td> - 
		cannot cancel confim gatepass if user want to cancel raise a transfer In note-->
        </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
