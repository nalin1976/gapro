<?php

	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Items :: Mrn List & Report</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<!--<script type="text/javascript" src="../StyleItemGatePass/Details/gatePassDetails.js"></script>-->
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>

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
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script type="text/javascript">
var factoryID = <?php

 echo $_SESSION["CompanyID"]; 
 ?>;
var UserID = <?php
 session_start();
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

<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../java.js" type="text/javascript"></script>
</head>
<body>

<form name="frmordershed" id="frmordershed" action="ordershedrpt.php" method="POST">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#316895" class="TitleN2white"><table width="100%" border="0">
      <tr>
        <td width="24%" height="15"><div align="center">Order Shedule Report</div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1" bgcolor="#d6e7f5">
      <tr>
	    <td width="4%" class="normalfnt"><input  type="checkbox" name="chkAppDate" id="chkAppDate"  onclick="AppDateDisable(this);"/></td>
        <td width="18%" class="normalfnt">Approved Date </td>
        <td width="16%" class="normalfnt"><div align="right">From</div></td>
        <td width="19%" class="normalfnt"><input name="AppDateFrom" type="text" class="txtbox" id="AppDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($AppDateFrom=="" ? date ("d/m/Y"):$AppDateFrom) ?>" disabled="disabled"/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value=""/></td>
        <td width="16%" class="normalfnt"><div align="right">To</div></td>
        <td width="19%" class="normalfnt"><input name="AppDateTo" type="text" class="txtbox" id="AppDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($AppDateTo=="" ? date ("d/m/Y"):$AppDateTo) ?>" disabled="disabled"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
      </tr>
	  
	    <tr>
		<td width="4%" class="normalfnt"><input  type="checkbox" name="chkShipDate" id="chkShipDate"  onclick="ShipDateDisable(this);"/></td>
        <td width="18%" class="normalfnt">Shipment Date </td>
        <td width="16%" class="normalfnt"><div align="right">From</div></td>
        <td width="19%" class="normalfnt"><input name="ShipDateFrom" type="text" class="txtbox" id="ShipDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($ShipDateFrom=="" ? date ("d/m/Y"):$ShipDateFrom) ?>" disabled="disabled"/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value=""/></td>
        <td width="16%" class="normalfnt"><div align="right">To</div></td>
        <td width="19%" class="normalfnt"><input name="ShipDateTo" type="text" class="txtbox" id="ShipDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($ShipDateTo=="" ? date ("d/m/Y"):$ShipDateTo) ?>" disabled="disabled"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
      </tr>  
	  
	  	<tr>
	    <td width="4%" class="normalfnt"><input  type="checkbox" name="chkSRNODate" id="chkSRNODate"  onclick="SRNODateDisable(this);"/></td>
        <td width="18%" class="normalfnt">SRNO </td>
        <td width="16%" class="normalfnt"><div align="right">From</div></td>

        <td width="19%" class="normalfnt"><select name="cbointSRNOFrom" class="txtbox" id="cbointSRNOFrom" style="width:110px" disabled="disabled">		
		<?php
		$SQL ="SELECT  intSRNO FROM specification ORDER BY intSRNO;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intSRNO"]."\">".$row["intSRNO"]."</option>";
			}
	
 	    ?>
		</select></td>
		
        <td width="16%" class="normalfnt"><div align="right">To</div></td>
        <td width="19%" class="normalfnt"><select name="cbointSRNOTo" class="txtbox" id="cbointSRNOTo" style="width:110px" disabled="disabled">		
		<?php
		$SQL ="SELECT  intSRNO FROM specification ORDER BY intSRNO;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intSRNO"]."\">".$row["intSRNO"]."</option>";
			}
	
 	    ?>
		</select></td>
      </tr>
	  
	  	<tr>
	    <td width="4%" class="normalfnt"><input  type="checkbox" name="chkCutDate" id="chkCutDate"  onclick="CutDateDisable(this);"/></td>
        <td width="18%" class="normalfnt">Cut Date</td>
        <td width="16%" class="normalfnt"><div align="right">From</div></td>
        <td width="19%" class="normalfnt"><input name="CutDateFrom" type="text" class="txtbox" id="CutDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($CutDateFrom=="" ? date ("d/m/Y"):$CutDateFrom) ?>" disabled="disabled"/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value=""/></td>
        <td width="16%" class="normalfnt"><div align="right">To</div></td>
        <td width="19%" class="normalfnt"><input name="CutDateTo" type="text" class="txtbox" id="CutDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($CutDateTo=="" ? date ("d/m/Y"):$CutDateTo) ?>" disabled="disabled"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
      </tr>
	  
	    <td width="4%" class="normalfnt">Item </td>
        <td width="18%" class="normalfnt"><select name="cboItem" class="txtbox" id="cboItem" style="width:110px">
          <?php
		$SQL ="SELECT DISTINCT strDescription FROM orders ORDER BY strDescription;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["strDescription"]."\">".$row["strDescription"]."</option>";
			}
	
 	?>
        </select></td>
		
	    <td width="16%" class="normalfnt"><div align="right">Company </div></td>
        <td width="19%" class="normalfnt"><select name="cboCompany1" class="txtbox" id="cboCompany1" style="width:110px">
          <?php
		$SQL ="SELECT intCompanyID,strName FROM companies ORDER BY intCompanyID;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
			}
	
 	?>
        </select></td>
		
	    <td width="16%" class="normalfnt"><div align="right">Buyer </div></td>
        <td width="19%" class="normalfnt"><select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:110px">
          <?php
		$SQL ="SELECT intBuyerID,strName FROM buyers ORDER BY intBuyerID;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				echo "<option value=\"".$row["intBuyerID"]."\">".$row["strName"]."</option>";
			}
	
 	?>
        </select></td>
            <td width="8%" rowspan="4" class="normalfnt" ><img border="0" src="../../images/report.png"  alt="search" width="80" height="24" onclick="SubmitForm();" /></td>	
<td>
</td>
    </table></td>
  </tr>

<script type="text/javascript" language="javascript">
function AppDateDisable(obj)
{
	if(obj.checked){
		document.getElementById('AppDateFrom').disabled=false;
		document.getElementById('AppDateTo').disabled=false;
	}
	else{
		document.getElementById('AppDateFrom').disabled=true;
		document.getElementById('AppDateTo').disabled=true;
	}
}

function ShipDateDisable(obj)
{
	if(obj.checked){
		document.getElementById('ShipDateFrom').disabled=false;
		document.getElementById('ShipDateTo').disabled=false;
	}
	else{
		document.getElementById('ShipDateFrom').disabled=true;
		document.getElementById('ShipDateTo').disabled=true;
	}
}

function SRNODateDisable(obj)
{
	if(obj.checked){
		document.getElementById('cbointSRNOFrom').disabled=false;
		document.getElementById('cbointSRNOTo').disabled=false;
	}
	else{
		document.getElementById('cbointSRNOFrom').disabled=true;
		document.getElementById('cbointSRNOTo').disabled=true;
	}
}

function CutDateDisable(obj)
{
	if(obj.checked){
		document.getElementById('CutDateFrom').disabled=false;
		document.getElementById('CutDateTo').disabled=false;
	}
	else{
		document.getElementById('CutDateFrom').disabled=true;
		document.getElementById('CutDateTo').disabled=true;
	}
}

function SubmitForm()
{
    var cbointSRNOFrom = document.frmordershed.cbointSRNOFrom.value; 
	var cbointSRNOTo   = document.frmordershed.cbointSRNOTo.value; 
	if(document.frmordershed.chkSRNODate.checked == true){
	 if(cbointSRNOFrom == ""){
	  alert("Blank Not Allowed");
	  document.frmordershed.cbointSRNOFrom.focus();
	  return false;
	 }
	  if(cbointSRNOTo == ""){
	  alert("Blank Not Allowed");
	  document.frmordershed.cbointSRNOTo.focus();
	  return false;
	 }
	
	}
	if(document.frmordershed.chkAppDate.checked == true){
	 var AppDateFromGET    = document.getElementById("AppDateFrom").value;
	 var AppDateToGET      = document.getElementById("AppDateTo").value;
	}else{
	 var AppDateFromGET    = "";
	 var AppDateToGET      = "";
	}
	
    if(document.frmordershed.chkShipDate.checked == true){
	 var ShipDateFromGET   = document.getElementById("ShipDateFrom").value;
	 var ShipDateToGET     = document.getElementById("ShipDateTo").value;
	}else{
	 var ShipDateFromGET    = "";
	 var ShipDateToGET    = "";
	}
	
	if(document.frmordershed.chkSRNODate.checked == true){
	 var cbointSRNOFromGET = document.getElementById("cbointSRNOFrom").value;
	 var cbointSRNOToGET   = document.getElementById("cbointSRNOTo").value;
	}else{
	 var cbointSRNOFromGET = "";
	 var cbointSRNOToGET   = "";
	}
	
    if(document.frmordershed.chkCutDate.checked == true){
     var CutDateFromGET    = document.getElementById("CutDateFrom").value;
	 var CutDateToGET      = document.getElementById("CutDateTo").value;	
	}else{
	 var CutDateFromGET = "";
	 var CutDateToGET   = "";
	}
	
	var cboItem        = document.getElementById("cboItem").value;
	var cboCompany1     = document.getElementById("cboCompany1").value;

	var cboBuyer       = document.getElementById("cboBuyer").value;
	window.open("ordershedrpt.php?AppDateFromGET=" + AppDateFromGET+"&AppDateToGET=" +AppDateToGET+"&ShipDateFromGET=" +ShipDateFromGET+"&ShipDateToGET=" +ShipDateToGET+"&cbointSRNOFromGET=" +cbointSRNOFromGET+"&cbointSRNOToGET=" +cbointSRNOToGET+"&CutDateFromGET=" +CutDateFromGET+"&CutDateToGET=" +CutDateToGET+"&cboItem=" +cboItem+"&cboCompany1=" +cboCompany1+"&cboBuyer=" +cboBuyer);
	 
	//document.getElementById('frmordershed').submit();
	return true;
}
function RefreshPage()
{
	setTimeout("location.reload(true);",0);
}
function LoadStyleID(){
	var ScNo =document.getElementById("cboScNo").options[document.getElementById("cboScNo").selectedIndex].text;
	document.getElementById("cboStyleID").value =ScNo;	
}
function LoadScNo(){
	var StyleID =document.getElementById("cboStyleID").options[document.getElementById("cboStyleID").selectedIndex].text;
	document.getElementById("cboScNo").value =StyleID;	
}
</script>
</form>
</body>
</html>
