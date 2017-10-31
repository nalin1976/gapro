<?php
$backwardseperator = "../";
include '../authentication.inc';
include "../Connector.php"; 
session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Bulk Purchase Order</title>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />

<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="bulkPo-java.js?n=1" type="text/javascript"></script>
<script src="../javascript/autofill.js" type="text/javascript"></script>
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

<body onload="loadBulkPoForm(
<?php 	
$id = $_GET["id"];
if($id!=0)
{
	$bpono = $_GET["BulkPoNo"] ;
	echo "'$bpono'" ; echo "," ; echo $_GET["intYear"];
}
else
	echo "0,0,99";
?> );">

<form name="frmBulkPO" id="frmBulkPO">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">

    <tr>
    <td height="25" colspan="2"  class="mainHeading">Bulk Purchase Order</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td align="top"><table width="100%" height="83" border="0" class="tableBorder">
          <tr>
            <td width="97" class="normalfnt">B.PO No </td>
            <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="94"><input type="text" name="txtBulkPoNo" class="txtbox" id="txtBulkPoNo" style="width:65px" onclick="editBulkPO();" readonly=""/></td>
                <td width="104"><select name="cboBPOYearBox" id="cboBPOYearBox" class="txtbox"  style="width:63px" tabindex="2">
              
              <?php
			for ($loop = date("Y") ; $loop >= 2008; $loop --)
			{
				echo "<option value=\"$loop\">$loop</option>";
			}
	?>
	
            </select></td>
                <td width="88"><img src="../images/view2.png" width="62" height="21" onclick="SearchBulkPoNo();" /></td>
                <td width="45" style="visibility:hidden"><input type="checkbox" name="checkbox" id="checkbox" onclick="dateDisable(this);" />
                <?php $baseCountryId = getBaseCountryId(); ?>                </td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td class="normalfnt">Currency<span class="compulsoryRed"> *</span></td>
            <td width="92"><select name="cboCurrency" class="txtbox" id="cboCurrency" style="width:67px" onchange="convertRates();" >
              <?php
			 
				$SQL = "SELECT intCurID,strCurrency FROM currencytypes c where intStatus='1' order by strCurrency;";	
				$result = $db->RunQuery($SQL);		
				//echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					if($row["intCurID"]==GetDefaltBaseCurrency())
						echo "<option value=\"". $row["intCurID"] ."\" selected=\"selected\">" . $row["strCurrency"] ."</option>";
					else
						echo "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
				}
	
			?>
            </select></td>
            <td width="100" class="normalfnt">Merchandiser <span class="compulsoryRed">*</span></td>
            <td width="131" class="normalfnt"><select name="cboMerchandiser" id="cboMerchandiser" style="width:115px;">
            <option value="">Select One</option>
            <?php 
			$SQL = "SELECT useraccounts.Name, useraccounts.intUserID FROM useraccounts INNER JOIN userpermission ON useraccounts.intUserID = userpermission.intUserID INNER JOIN role ON userpermission.RoleID = role.RoleID WHERE role.RoleName = 'Merchandising' order by useraccounts.Name"; 

	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intUserID"] ."\">" . $row["Name"]  ."</option>" ;
	}
			?>
            </select>
            </td>
            </tr>
          <tr>
            <td class="normalfnt">Supplier <span class="compulsoryRed">*</span></td>
            <td colspan="3"><select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:315px" onchange="getSupplierData();">
              <option value="0" selected="selected" >Select One</option>
              <?php
	
	$SQL = "SELECT strTitle,strSupplierID FROM suppliers s where intApproved='1' order by strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
            </select></td>
          </tr>

        </table></td>
        <td width="500" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" height="83">
          <tr>
            <td><table width="500" border="0" cellspacing="0" cellpadding="1" class="tableBorder">
              <tr>
                <td width="90" ><span class="normalfnt">Deliver To <span class="compulsoryRed">*</span></span></td>
                <td width="200"><select name="cboDeliverto" class="txtbox" id="cboDeliverto" style="width:200px">
                  <?php 
				$SQL = "SELECT strName,intCompanyID FROM companies where intStatus='1' order by strName;";	
				$result = $db->RunQuery($SQL);		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
				echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
				}
				
				?>
                </select></td>
                <td width="84"><span class="normalfnt">PO Amount</span></td>
                <td width="116"><input name="txtPoAmount" type="text" class="txtbox" id="txtPoAmount"  style="width:90px;" onfocus="this.blur();"/></td>
              </tr>
              <tr>
                <td><span class="normalfnt">Invoice To <span class="compulsoryRed">*</span></span></td>
                <td><select name="cboInvoiceTo" class="txtbox" id="cboInvoiceTo" style="width:200px">
                  <?php 
				$SQL = "SELECT strName,intCompanyID FROM companies where intStatus='1' order by strName;";	
				$result = $db->RunQuery($SQL);		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
				echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
				}
				
				?>
                </select></td>
                <td><span class="normalfnt">PI NO</span></td>
                <td><input type="text" name="txtPinNo" class="txtbox" id="txtPinNo" style="width:90px" maxlength="30" /></td>
              </tr>
              <tr>
                <td><span class="normalfnt">Instructions</span></td>
                <td colspan="3"><textarea name="txtIntroduction" style="width:378px;" class="txtbox" id="txtIntroduction" onkeypress="return imposeMaxLength(this,event, 255);" rows="1"></textarea></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr><td><table width="950" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="447"><table width="99%" border="0" cellspacing="0" cellpadding="2" class="tableBorder">
        <tr>
          <td width="104" class="normalfnt">Pay Mode<span class="compulsoryRed"> *</span></td>
          <td width="105"><select name="cboPayMode" class="txtbox" id="cboPayMode" style="width:100px">
            <option value="" selected="selected">Select One</option>
            <?php
	
	$SQL = "SELECT strPayModeId,strDescription FROM popaymentmode p where intstatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
          </select></td>
          <td width="104" class="normalfnt">Pay Term <span class="compulsoryRed"> *</span></td>
          <td width="112"><select name="cboPayTerms" class="txtbox" id="cboPayTerms" style="width:100px">
            <option value="" selected="selected">Select One</option>
            <?php
	
	$SQL = "SELECT strPayTermId,strDescription FROM popaymentterms p where intStatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
          </select></td>
        </tr>
        <tr>
          <td><span class="normalfnt">Shipment Mode</span></td>
          <td><select name="cboShipment" class="txtbox" id="cboShipment" style="width:100px">
            <option value="Null" selected="selected">Select One</option>
            <?php
	
	$SQL = "SELECT strDescription,intShipmentModeId FROM shipmentmode s where intStatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
          </select></td>
          <td><span class="normalfnt">Shipment Term</span></td>
          <td><select name="cboshipmentTerm" class="txtbox" id="cboshipmentTerm" style="width:100px">
            <option value="Null" selected="selected">Select One</option>
            <?php
	
	$SQL = "SELECT strShipmentTerm,strShipmentTermId FROM shipmentterms s where intStatus='1' order by strShipmentTerm;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
	}
	
	?>
          </select>
          </td>
        </tr>
      </table></td>
      <td width="503"><table width="500" border="0" cellspacing="0" cellpadding="2" class="tableBorder">
        <tr>
          <td width="92"><span class="normalfnt">Date</span></td>
          <td width="151"><input name="podate" type="text" class="txtbox" id="podate"  value="<?php echo date("d/m/Y"); ?>" onfocus="this.blur();" style="width:90px;"/></td>
          <td width="132" class="normalfnt">Delivery Date<span class="compulsoryRed">*</span></td>
          <td width="115"><input name="deliverydateDD" type="text" class="txtbox" id="deliverydateDD"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" style="width:90px;"  /><input type="text" value=""  class="txtbox" style="visibility:hidden; width:10px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
        </tr>
        <tr>
          <td class="normalfnt">ETD</td>
          <td><input name="deliverydate" type="text" class="txtbox" id="deliverydate"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"  style="width:90px;"/><input type="text" value=""  class="txtbox" style="visibility:hidden; width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
          <td class="normalfnt">ETA</td>
          <td><input name="deliverydateETA" type="text" class="txtbox" id="deliverydateETA"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"  style="width:90px;" /><input type="text" value=""  class="txtbox" style="visibility:hidden; width:10px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
        </tr>
      </table></td>
    </tr>
  </table></td>
 
  </tr>
  
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="88%" height="17" class="mainHeading2"><div align="center">BULK PO's</div></td>
        <td width="12%" bgcolor="#FFD5AA" class="normalfnth2"><img src="../images/add-new.png" alt="add new" width="109" height="18" onclick="ShowItems()" /></td>
      </tr>
      <tr>
        <td colspan="2"><div id="divcons2" style="overflow:scroll; height:320px; width:950px;">
          <table width="1050" cellpadding="0" cellspacing="1" id="tblMain" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="3%" height="25">Del</td>
              <td width="13%" >Material</td>
              <td width="20%" >Description</td>
              <td width="12%" >Color</td>
              <td width="12%" >Size</td>
              <td width="8%" >Unit</td>
              <td width="9%" >Qty</td>
              <td width="9%" >Unit Price</td>
              <td width="12%" >Value</td>
			  <td width="12%" >Mat Detail Id</td>
              </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" class="tableBorder">
      <tr>
        <td width="12%" height="29"><div align="center">
       <img src="../images/new.png"  id="butNew" alt="new" width="96" height="24" onclick="newPage();"/>
       <img src="../images/save.png" id="butSave" alt="save" width="84" height="24" onclick="save();" />
	   <?php if($confirmBulkPo){?>
       <img src="../images/conform.png" id="butConform" alt="conform" width="115" height="24" onclick="conform();" />
	   <?php }?>
       <img src="../images/cancel.jpg" style="display:none" id="butCancel" alt="Cancel" width="104" height="24" onclick ="cancel();"/>
        <!--<img src="../images/porevise.png" id="butRevise" width="115" height="24" class="mouseover" onclick="Revise();"  />-->
        <img src="../images/report.png" id="butReport" width="108" height="24"  onclick="BulkPoReport();"/>
        <a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0" /></a></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<div style="left:300px; top:145px; z-index:10; position:absolute; width: 228px; visibility:hidden;" id="FindPO"><table width="270" height="58" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
<tr><td bgcolor="#550000" colspan="2" align="right"><img src="../images/cross.png" onClick="closeFindBPO();" alt="Close" name="Close" width="17" height="17" id="Close"/></tr>
          <tr>
            <td width="102"><div align="left">Supplier</div></td>
            <td width="242"><select name="select2" class="txtbox" id="cboSupFind" style="width:180px" onchange="LoadBulkPONO();">
              <option value="0" selected="selected">Select One</option>
			  <?php
	
	$SQL = "SELECT strTitle,strSupplierID FROM suppliers s where intStatus='1' order by strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
            </select></td>
          </tr>
          <tr>
            <td><div align="left">Bulk PO No </div></td>
            <td><select name="select" class="txtbox" id="cboPONoFind" style="width:100px" onchange="setValuetoPoBox();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td></td>
          </tr>
        </table>
		
		
</div>
</form>
<?php
function GetDefaltBaseCurrency()
{
global $db;
	$sql="select intBaseCurrency from systemconfiguration";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["intBaseCurrency"];
}
function getBaseCountryId()
{
	global $db;
	$sql="select intBaseCountry from systemconfiguration";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["intBaseCountry"];
}
?>
<script language="javascript" type="text/javascript">
var pub_curr = document.getElementById('cboCurrency').value;
var comfirmBulkPo = "<?php echo $confirmBulkPo?>";
var baseCountryId = "<?php echo $baseCountryId; ?>";
</script>
</body>
</html>
