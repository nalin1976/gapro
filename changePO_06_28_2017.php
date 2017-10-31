<?php
session_start();
include "authentication.inc";
include "Connector.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Confirmed PO - Correction</title>
<script src="javascript/script.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<!--BEGIN - Calander js codes-->
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
<!--END - Calander js codes-->
<?php

$pono = $_REQUEST["pono"];
$poyear = $_REQUEST["year"];


$sql = "SELECT strSupplierID,strPayMode,strPayTerm,strShipmentMode,strShipmentTerm,intInvCompID,intDelToCompID, DATE_FORMAT(dtmDeliveryDate,'%d/%m/%Y') as DeliveryDate,DATE_FORMAT(dtmETD,'%d/%m/%Y') as ETDDate,DATE_FORMAT(dtmETA,'%d/%m/%Y') as ETADate  FROM purchaseorderheader
WHERE intPONo = '$pono' AND intYear = '$poyear';";
$result = $db->RunQuery($sql);		
while($row = mysql_fetch_array($result))
{
	$strSupplierID 		= $row["strSupplierID"];
	$strPayTerm 		= $row["strPayTerm"];
	$strPayMode 		= $row["strPayMode"];
	$strShipmentMode 	= $row["strShipmentMode"];
	$strShipmentTerm 	= $row["strShipmentTerm"];
	$intInvCompID 		= $row["intInvCompID"];
	$intDelToCompID 	= $row["intDelToCompID"];
	$dtmDeliveryDate 	= $row["DeliveryDate"];
	$etdDate 			= $row["ETDDate"];
	$etaDate 			= $row["ETADate"];
}



if (!isset($_GET["pono"]))
{
	$user	 			= $_SESSION["UserID"];
	$newSupplier 		= $_REQUEST["cboSupFind"];
	$newPayTerm 		= $_REQUEST["cbopayterms"];
	$newPayMode 		= $_REQUEST["cbopaymode"];
	$newShipmentMode 	= $_REQUEST["cboshipment"];
	$newShipmentTerm 	= $_REQUEST["cboshipmentTerm"];
	$newInvoiceTo 		= $_REQUEST["cboinvoiceto"];
	$newDeleverTo 		= $_REQUEST["cbodeliverto"];	
	$newDeleveryDate 	= $_REQUEST["deliverydateDD"];
	$newETD 			= $_REQUEST["txtETD"];
	$newETA 			= $_REQUEST["txtETA"];
	

	if ($strSupplierID != $newSupplier)
	{
		$sql = "INSERT INTO pochangelog 	(intPONO, 	intYear,	dtmchangedDate,	strsource,	strPrevious,	strNew,	intUserID) VALUES ('$pono',	'$poyear',NOW(),	'Supplier','$strSupplierID','$newSupplier','$user');";
		$db->ExecuteQuery($sql);	
	}
	if ($strPayTerm != $newPayTerm)
	{
		$sql = "INSERT INTO pochangelog 	(intPONO, 	intYear,	dtmchangedDate,	strsource,	strPrevious,	strNew,	intUserID) VALUES ('$pono',	'$poyear',NOW(),	'Pay Term','$strPayTerm','$newPayTerm','$user');";
		$db->ExecuteQuery($sql);	
	}
	if ($strPayMode != $newPayMode)
	{
		$sql = "INSERT INTO pochangelog 	(intPONO, 	intYear,	dtmchangedDate,	strsource,	strPrevious,	strNew,	intUserID) VALUES ('$pono',	'$poyear',NOW(),	'Pay Mode','$strPayMode','$newPayMode','$user');";
		$db->ExecuteQuery($sql);	
	}
	if ($strShipmentMode != $newShipmentMode)
	{
		$sql = "INSERT INTO pochangelog 	(intPONO, 	intYear,	dtmchangedDate,	strsource,	strPrevious,	strNew,	intUserID) VALUES ('$pono',	'$poyear',NOW(),	'Shippment Mode','$strShipmentMode','$newShipmentMode','$user');";
		$db->ExecuteQuery($sql);	
	}
	if ($strShipmentTerm != $newShipmentTerm)
	{
		$sql = "INSERT INTO pochangelog 	(intPONO, 	intYear,	dtmchangedDate,	strsource,	strPrevious,	strNew,	intUserID) VALUES ('$pono',	'$poyear',NOW(),	'Shippment Term','$strShipmentTerm','$newShipmentTerm','$user');";
		$db->ExecuteQuery($sql);	
	}
	if ($intInvCompID != $newInvoiceTo)
	{
		$sql = "INSERT INTO pochangelog 	(intPONO, 	intYear,	dtmchangedDate,	strsource,	strPrevious,	strNew,	intUserID) VALUES ('$pono',	'$poyear',NOW(),	'Invoice To','$intInvCompID','$newInvoiceTo','$user');";
		$db->ExecuteQuery($sql);	
	}
	if ($intDelToCompID != $newDeleverTo)
	{
		$sql = "INSERT INTO pochangelog 	(intPONO, 	intYear,	dtmchangedDate,	strsource,	strPrevious,	strNew,	intUserID) VALUES ('$pono',	'$poyear',NOW(),	'Deliver To','$intDelToCompID','$newDeleverTo','$user');";
		$db->ExecuteQuery($sql);	
	}
	if ($newDeleveryDate != $dtmDeliveryDate)
	{
		$sql = "INSERT INTO pochangelog 	(intPONO, 	intYear,	dtmchangedDate,	strsource,	strPrevious,	strNew,	intUserID) VALUES ('$pono',	'$poyear',NOW(),	'Delivery Date','$dtmDeliveryDate','$newDeleveryDate','$user');";
		$db->ExecuteQuery($sql);	
	}
	if ($newETD != $etdDate)
	{
		$sql = "INSERT INTO pochangelog 	(intPONO, 	intYear,	dtmchangedDate,	strsource,	strPrevious,	strNew,	intUserID) VALUES ('$pono',	'$poyear',NOW(),	'ETD Date','$etdDate','$newETD','$user');";
		$db->ExecuteQuery($sql);	
	}
	if ($newETA != $etaDate)
	{
		$sql = "INSERT INTO pochangelog 	(intPONO, 	intYear,	dtmchangedDate,	strsource,	strPrevious,	strNew,	intUserID) VALUES ('$pono',	'$poyear',NOW(),	'ETA Date','$etaDate','$newETA','$user');";
		$db->ExecuteQuery($sql);	
	}

	$year = substr($newDeleveryDate,-4);
	$month = substr($newDeleveryDate,-7,-5);
	$day = substr($newDeleveryDate,-10,-8);
	$dtDateofDelivery = $year . "-" . $month . "-" . $day;
	$newETDArray = explode('/',$newETD);
	$formatETD		= $newETDArray[2].'-'.$newETDArray[1].'-'.$newETDArray[0];
	$newETAArray = explode('/',$newETA);
	$formatETA		= $newETAArray[2].'-'.$newETAArray[1].'-'.$newETAArray[0];
	
	$sql = "update purchaseorderheader set strSupplierID = '$newSupplier' ,strPayMode = '$newPayMode' ,strPayTerm = '$newPayTerm',strShipmentMode = $newShipmentMode,strShipmentTerm = $newShipmentTerm,intInvCompID = '$newInvoiceTo',intDelToCompID = '$newDeleverTo', dtmDeliveryDate='$dtDateofDelivery',dtmETA='$formatETA',dtmETD='$formatETD' where intPONo = '$pono' AND intYear = '$poyear';";
	
	$db->ExecuteQuery($sql);
}

$sql = "SELECT strSupplierID,strPayMode,strPayTerm,strShipmentMode,strShipmentTerm,intInvCompID,intDelToCompID, DATE_FORMAT(dtmDeliveryDate,'%d/%m/%Y') as DeliveryDate,DATE_FORMAT(dtmETD,'%d/%m/%Y') as ETDDate,DATE_FORMAT(dtmETA,'%d/%m/%Y') as ETADate FROM purchaseorderheader
WHERE intPONo = '$pono' AND intYear = '$poyear';";
$result = $db->RunQuery($sql);		
while($row = mysql_fetch_array($result))
{
	$strSupplierID 		= $row["strSupplierID"];
	$strPayTerm 		= $row["strPayTerm"];
	$strPayMode 		= $row["strPayMode"];
	$strShipmentMode 	= $row["strShipmentMode"];
	$strShipmentTerm 	= $row["strShipmentTerm"];
	$intInvCompID 		= $row["intInvCompID"];
	$intDelToCompID 	= $row["intDelToCompID"];
	$dtmDeliveryDate 	= $row["DeliveryDate"];
	$etdDate 			= $row["ETDDate"];
	$etaDate 			= $row["ETADate"];
}

?>

<body>
  <tr>
    <td width="752"><?php include 'Header.php'; ?></td>
  </tr>
<table width="965" border="0" align="center">

  <tr>
    <td><form method="post" action="changePO.php"><table width="100%" border="0"  cellpadding="0" cellspacing="1" class="bcgl1">
      <tr>
        <td height="21">&nbsp;</td>
      </tr>
      <tr>
        <td height="57" align="center">
			<div>
			<table width="50%" >
			<tr>
			<td height="41" colspan="2"><span class="head1">Confirmed PO - Correction</span></td>			
			</tr>			
			<tr>
			<td class="txtbox">PO Number</td>		
			<td class="txtbox"><?php echo $pono; ?><input type="hidden" name="pono" value="<?php echo $pono; ?>"></td>	
			</tr>
			<tr>
			<TD class="txtbox">Year</td>
			<TD class="txtbox"><?php echo $poyear; ?><input type="hidden" name="year" value="<?php echo $poyear; ?>"></td>
			</tr>
			<tr>
			<td class="txtbox">Supplier</td>
			<td class="txtbox"><select name="cboSupFind" class="txtbox" id="cboSupFind" style="width:250px" onchange="LoadPOacSup();">
              <option value="0" selected="selected">Select One</option>
			  <?php
	
	$SQL = "SELECT strTitle,strSupplierID FROM suppliers s where intStatus='1' order by strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($strSupplierID == $row["strSupplierID"])
			echo "<option selected=\"selected\" value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
		else
			echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
            </select></td>			
			</tr>
			<tr>
			<td class="txtbox">Payment Mode</td>
			<td class="txtbox"><select name="cbopaymode" class="txtbox" id="cbopaymode" style="width:250px">
			  
                          <?php
	
	$SQL = "SELECT strPayModeId,strDescription FROM popaymentmode p where intstatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($row["strPayModeId"] == $strPayMode)
		{
			echo "<option selected=\"selected\" value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
	}
	
	?>
                </select></td>			
			</tr>
			<tr>
			<td class="txtbox">Payment Term</td>
			<td class="txtbox"><select name="cbopayterms" class="txtbox" id="cbopayterms" style="width:250px">
                
                <?php
	
	$SQL = "SELECT strPayTermId,strDescription FROM popaymentterms p where intStatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($row["strPayTermId"] == $strPayTerm)
		{
			echo "<option selected=\"selected\" value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
	}
	
	?>
              </select></td>			
			</tr>
			<tr>
			<td class="txtbox">Shipment Mode</td>
			<td class="txtbox"><select name="cboshipment" class="txtbox" id="cboshipment" style="width:250px"><option value="null" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strDescription,intShipmentModeId FROM shipmentmode s where intStatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($strShipmentMode == $row["intShipmentModeId"])
			echo "<option selected=\"selected\" value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
		else
			echo "<option value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
                            </select></td>			
			</tr>
			<tr>
			<td class="txtbox">Shipment Terms</td>
			<td class="txtbox"><select name="cboshipmentTerm" class="txtbox" id="cboshipmentTerm" style="width:250px"><option value="null" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strShipmentTerm,strShipmentTermId FROM shipmentterms s where intStatus='1' order by strShipmentTerm;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($strShipmentTerm == $row["strShipmentTermId"])
			echo "<option selected=\"selected\" value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
		else
			echo "<option value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
	}
	
	?>
                            </select></td>			
			</tr>
			<tr>
			<td class="txtbox">Invoice To</td>
			<td class="txtbox"><select name="cboinvoiceto" class="txtbox" id="cboinvoiceto" style="width:280px">
			<option value="0" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strName,intCompanyID FROM companies where intStatus='1' order by strName;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($intInvCompID == $row["intCompanyID"])
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		else
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?> 
                  </select></td>			
			</tr>
			<tr>
			<td class="txtbox">Deliver To</td>
			<td class="txtbox"><select name="cbodeliverto" class="txtbox" id="cbodeliverto" style="width:280px">
			<option value="0" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strName,intCompanyID FROM companies where intStatus='1' order by strName;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if ($intDelToCompID == $row["intCompanyID"])
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		else
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                  </select></td>			
			</tr>
			<tr>
			<td class="txtbox">Delevery Date</td>
			<td class="txtbox"><input name="deliverydateDD" type="text" class="txtbox" id="deliverydateDD" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo $dtmDeliveryDate; ?>" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px" onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
			</tr>
			<tr>
			  <td class="txtbox">ETD</td>
			  <td class="txtbox"><input name="txtETD" type="text" class="txtbox" id="txtETD" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo $etdDate; ?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
			  </tr>
			<tr>
			  <td class="txtbox">ETA</td>
			  <td class="txtbox"><input name="txtETA" type="text" class="txtbox" id="txtETA" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo $etaDate; ?>" /><input name="text" type="text"  class="txtbox" style="visibility:hidden;width:1px" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
			  </tr>
			<tr>
			<td></td>
			<td class="txtbox"><input  style="font-family: Verdana;font-size: 11px;color: #20407B;" type="submit" value="Update PO" ></td>			
			</tr>
			<tr>
			<td></td>
			<td height="36"><a href="main.php" ><img border="0" src="images/close.png" width="97" height="24" /></a></td>			
			</tr>
			<tr>
			<td colspan="2" class="head1">Change Log</td>		
			</tr>
			
			
			<?php
			$sql="SELECT dtmchangedDate,strsource,strPrevious,strNew,NAME FROM pochangelog 
INNER JOIN useraccounts ON pochangelog.intUserID = useraccounts.intUserID
WHERE  intPONo = '$pono' AND intYear = '$poyear';";
			$result = $db->RunQuery($sql);	
			$previousDate	 = "";
			while($row = mysql_fetch_array($result))
			{
				if ($previousDate!= $row["dtmchangedDate"])
				{
			?>
				<tr>
			<td></td>
			<td height="18"></td>			
			</tr>
			<tr>
			<td colspan="2" class="normalfnth2"><?php echo $row["dtmchangedDate"]; ?> - <?php echo $row["NAME"]; ?></td>		
			</tr>
			<?php } ?>
			<tr>
			<td colspan="2" class="normalfnt"><?php echo $row["strsource"]; ?> - <?php
			
			$source = $row["strsource"];
			$Value = $row["strPrevious"];
			
			if ($row["strsource"] == "Supplier")
			{
				$sql = "SELECT strTitle FROM suppliers WHERE strSupplierID = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strTitle"];
					break;
				}
			}
			else if ($row["strsource"] == "Pay Term")
			{
				$sql = "SELECT strDescription FROM popaymentterms WHERE strPayTermId = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strDescription"];
					break;
				}
			}
			else if ($row["strsource"] == "Pay Mode")
			{
				$sql = "SELECT strDescription FROM popaymentmode WHERE strPayModeId = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strDescription"];
					break;
				}
			}
			else if ($row["strsource"] == "Shippment Mode")
			{
				$sql = "SELECT strDescription FROM shipmentmode WHERE intShipmentModeId = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strDescription"];
					break;
				}
			}
			else if ($row["strsource"] == "Shippment Term")
			{
				$sql = "SELECT strShipmentTerm FROM shipmentterms WHERE strShipmentTermId = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strShipmentTerm"];
					break;
				}
			}
			else if ($row["strsource"] == "Invoice To")
			{
				$sql = "SELECT strName FROM companies WHERE intCompanyID = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strName"];
					break;
				}
			}
			else if ($row["strsource"] == "Deliver To")
			{
				$sql = "SELECT strName FROM companies WHERE intCompanyID = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strName"];
					break;
				}
			}
			else if ($row["strsource"] == "Delivery Date")
			{
				echo $Value;
			}
			else if ($row["strsource"] == "ETA Date")
			{
				echo $Value;
			}
			else if ($row["strsource"] == "ETD Date")
			{
				echo $Value;
			}
			?> --> <?php
			
			$source = $row["strsource"];
			$Value = $row["strNew"];
			
			if ($row["strsource"] == "Supplier")
			{
				$sql = "SELECT strTitle FROM suppliers WHERE strSupplierID = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strTitle"];
					break;
				}
			}
			else if ($row["strsource"] == "Pay Term")
			{
				$sql = "SELECT strDescription FROM popaymentterms WHERE strPayTermId = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strDescription"];
					break;
				}
			}
			else if ($row["strsource"] == "Pay Mode")
			{
				$sql = "SELECT strDescription FROM popaymentmode WHERE strPayModeId = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strDescription"];
					break;
				}
			}
			else if ($row["strsource"] == "Shippment Mode")
			{
				$sql = "SELECT strDescription FROM shipmentmode WHERE intShipmentModeId = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strDescription"];
					break;
				}
			}
			else if ($row["strsource"] == "Shippment Term")
			{
				$sql = "SELECT strShipmentTerm FROM shipmentterms WHERE strShipmentTermId = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strShipmentTerm"];
					break;
				}
			}
			else if ($row["strsource"] == "Invoice To")
			{
				$sql = "SELECT strName FROM companies WHERE intCompanyID = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strName"];
					break;
				}
			}
			else if ($row["strsource"] == "Deliver To")
			{
				$sql = "SELECT strName FROM companies WHERE intCompanyID = '$Value'";
				$dataresult = $db->RunQuery($sql);
				while($datarow = mysql_fetch_array($dataresult))
				{
					echo $datarow["strName"];
					break;
				}
			}
			else if ($row["strsource"] == "Delivery Date")
			{
				echo $Value;
			}
			else if ($row["strsource"] == "ETA Date")
			{
				echo $Value;
			}
			else if ($row["strsource"] == "ETD Date")
			{
				echo $Value;
			}
			?> </td>		
			</tr>
			<?php
			$previousDate = $row["dtmchangedDate"];
			}
			?>
			</table>			
			</div>
</td>
      </tr>
      <tr>
        <td height="74">&nbsp;</td>
      </tr>
      
    </table></form>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
	$sql="select count(intGrnNo)as count from grnheader where intPoNo='$pono' and intYear='$poyear' and intStatus<>10";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	$rowCount = $row["count"];
?>
<script type="text/javascript">

var rowCount =<?php echo $rowCount?>;
if(rowCount>0){
	alert("Sorry!\nYou cannot change this PO.GRN available for this PO.");
	window.close();
}
</script>