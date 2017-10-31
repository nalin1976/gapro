<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reports Filter</title>
<script type="text/javascript" src="Reports.js"></script>
<script type="text/javascript" src="../javascript/script.js"></script>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
.roundedCorners{   
      -moz-border-radius-bottomleft:9px;  
      -moz-border-radius-bottomright:9px;  
      -moz-border-radius-topleft:9px;  
      -moz-border-radius-topright:9px;  
       border-radius:10px;  
      
    } 
-->
</style>
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>

<script type="text/javascript">


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

 function ControlableKeyAccess(evt)
  {
	 var charCode = (evt.which) ? evt.which : evt.keyCode;


	 if (charCode == 9)
		return true;

	 return false;

  }
  
   function DisableRightClickEvent()
 {
	  document.oncontextmenu = DisableContextMenu;
	  return false;
 }
 
  function EnableRightClickEvent()
 {
	 document.oncontextmenu = null;
	  return false;
 }
</script>
</head>

<body>
<?php

include "../Connector.php";
$backwardseperator = "../";

?>
<form name="frmStyleReport" id="frmStyleReport">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="roundedCorners">
      <tr>
        <td width="65%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
          <tr>
            <td width="3%"><input type="radio" name="radio" id="radConPO" value="radConPO" onclick="setReport('rptStylePO.php',10);" /></td>
            <td width="20%" class="normalfnt">Confirmed POs</td>
            <td width="3%" class="normalfnt"><input type="radio" name="radio" id="radPenPO" value="radPenPO" onclick="setReport('rptStylePO.php',1);" /></td>
            <td width="26%" class="normalfnt">Pending POs</td>
            <td width="5%" class="normalfnt"><input type="radio" name="radio" id="radCanPO" value="radCanPO" onclick="setReport('rptStylePO.php',11);"/></td>
            <td width="43%" class="normalfnt">Canceled POs</td>
          </tr>
          <tr>
            <td bgcolor="#DCEAF5"><input type="radio" name="radio" id="radConGRN" value="radConGRN" onclick="setReport('rptStyleGRN.php',1);" /></td>
            <td bgcolor="#DCEAF5" class="normalfnt">Confirmed GRNs</td>
            <td bgcolor="#DCEAF5" class="normalfnt"><input type="radio" name="radio" id="radPenGRN" value="radPenGRN" onclick="setReport('rptStyleGRN.php',0);" /></td>
            <td bgcolor="#DCEAF5" class="normalfnt">Pending GRNs</td>
            <td bgcolor="#DCEAF5" class="normalfnt"><input type="radio" name="radio" id="radCanGRN" value="radCanGRN" onclick="setReport('rptStyleGRN.php',10);" /></td>
            <td bgcolor="#DCEAF5" class="normalfnt">Canceled GRNs</td>
          </tr>
          <tr>
            <td><input type="radio" name="radio" id="radConIssue" value="radConIssue" onclick="setReport('rptStyleIssues.php',1)" /></td>
            <td class="normalfnt">Issues</td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#DCEAF5"><input type="radio" name="radio" id="radCanRetToSto" value="radCanRetToSto" onclick="setReport('rptStyleRetToStores.php',1);" /></td>
            <td bgcolor="#DCEAF5" class="normalfnt">Return to Stores</td>
            <td bgcolor="#DCEAF5" class="normalfnt"><input type="radio" name="radio" id="radConRetToSto" value="radConRetToSto" onclick="setReport('rptStyleRetToStores.php',10)" /></td>
            <td colspan="2" bgcolor="#DCEAF5" class="normalfnt">Canceled Return to Stores</td>
            <td bgcolor="#DCEAF5" class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td><input type="radio" name="radio" id="radConRetToSup" value="radConRetToSup" onchange="setReport('rptStyleRetToSupplier.php',1)" /></td>
            <td class="normalfnt">Return to Supplier</td>
            <td class="normalfnt"><input type="radio" name="radio" id="radCanRetToSup" value="radCanRetToSup" onchange="setReport('rptStyleRetToSupplier.php',10)" /></td>
            <td colspan="2" class="normalfnt">Canceled Rate to Supplier</td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="6"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="3%" bgcolor="#DCEAF5"><input type="radio" name="radio" id="radConIntJobTrns" value="radConIntJobTrns" onclick="setReport('rptInterJobTransfer.php',0);" /></td>
                <td width="22%" bgcolor="#DCEAF5" class="normalfnt">Inter Job Transfer</td>
                <td width="4%" bgcolor="#DCEAF5" class="normalfnt"><input type="radio" name="radio" id="rbreport17" value="rbreport" /></td>
                <td width="25%" bgcolor="#DCEAF5" class="normalfnt">Approved</td>
                <td width="3%" bgcolor="#DCEAF5" class="normalfnt"><input type="radio" name="radio" id="rbreport18" value="rbreport" /></td>
                <td width="16%" bgcolor="#DCEAF5" class="normalfnt">Authorized</td>
                <td width="3%" bgcolor="#DCEAF5" class="normalfnt"><input type="radio" name="radio" id="rbreport20" value="rbreport" /></td>
                <td width="15%" bgcolor="#DCEAF5" class="normalfnt">Confirmed</td>
                <td width="3%" bgcolor="#DCEAF5" class="normalfnt"><input type="radio" name="radio" id="rbreport21" value="rbreport" /></td>
                <td width="6%" bgcolor="#DCEAF5" class="normalfnt">Cancel</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td><input type="radio" name="radio" id="radConGatePass" value="radConGatePass" onclick="setReport('rptStyleGatePass.php',1)" /></td>
            <td class="normalfnt">Gate Pass</td>
            <td class="normalfnt"><input type="radio" name="radio" id="radConGatePassTrIn" value="radConGatePassTrIn" onclick="setReport('rptGatePassTransferIn.php',1)" /></td>
            <td class="normalfnt">GP Transfer IN</td>
            <td class="normalfnt"><input type="radio" name="radio" id="rbreport19" value="rbreport" /></td>
            <td class="normalfnt">GP Transfer IN Cancelled</td>
          </tr>
          <tr>
            <td colspan="6"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20" bgcolor="#DCEAF5"><input type="radio" name="radio" id="rbreport8" value="rbreport" /></td>
                <td width="130" bgcolor="#DCEAF5" class="normalfnt">GST Transfer</td>
                <td width="24" bgcolor="#DCEAF5" class="normalfnt"><input type="radio" name="radio" id="rbreport22" value="rbreport" /></td>
                <td width="152" bgcolor="#DCEAF5" class="normalfnt">Approved</td>
                <td width="20" bgcolor="#DCEAF5" class="normalfnt"><input type="radio" name="radio" id="rbreport23" value="rbreport" /></td>
                <td width="76" bgcolor="#DCEAF5" class="normalfnt">Authorized</td>
                <td width="20" bgcolor="#DCEAF5" class="normalfnt"><input type="radio" name="radio" id="rbreport24" value="rbreport" /></td>
                <td width="169" bgcolor="#DCEAF5" class="normalfnt">Confirmed</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="6"><table width="100%" border="0" class="tablezRED">
              <tr>
                <td width="20%" height="15">PO No From</td>
                <td width="35%"><input name="txtponofrom" type="text" class="txtbox" id="txtponofrom" size="30" /></td>
                <td width="13%">To</td>
                <td width="32%"><input name="txtponoto" type="text" class="txtbox" id="txtponoto" size="30" /></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
        <td width="35%" valign="top"><table width="100%" border="0" class="bcgl1">
          <tr>
            <td width="22%" class="normalfnt">Style No</td>
            <td width="32%"><select name="cboStyleNo" class="txtbox" id="cboStyleNo" style="width:100px" onchange="loadBuyerPONo(); loadMaterial(); loadSubCategory(); loadItemDetails();">
			<option value="0">Select One</option>
			<!-- --> <option value="ALBYW014-PUUPY">ALBYW014-PUUPY</option>
			ALBYW014-PUUPY <!-- -->
            <?php		
				$sqlStyle="SELECT intStyleId FROM orders ORDER BY intStyleId;";			
				$resultStyle = $db->RunQuery($sqlStyle);	
				while($rowStyle = mysql_fetch_array($resultStyle))
				{
					echo "<option value=\"". $rowStyle["intStyleId"] ."\">" . $rowStyle["intStyleId"] ."</option>" ;
				}
			?>
            </select></td>
            <td width="46%" rowspan="3" valign="top"><table width="100%" border="0" class="tablezRED">
              <tr>
                <td width="">From</td>
                <td width=""><input name="dtmDateFrom" type="text" class="txtbox" id="dtmDateFrom" size="12" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
              </tr>
              <tr>
                <td>To</td>
                <td><input name="dtmDateTo" type="text" class="txtbox" id="dtmDateTo" size="12" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td class="normalfnt">BPO No</td>
            <td><select name="cboBPo" class="txtbox" id="cboBPo" style="width:100px">
			<option value="0">Select One</option>
			<option value="#Main Ratio#">#Main Ratio#</option>
             <?php
			 	$sqlBPo="SELECT DISTINCT purchaseorderdetails.strBuyerPONO FROM purchaseorderdetails ORDER BY purchaseorderdetails.strBuyerPONO;";
				$resultBPo=$db->RunQuery($sqlBPo);
				while ($rowBPo=mysql_fetch_array($resultBPo))
				{
					echo "<option value=\"".$rowBPo["strBuyerPONO"]."\">".$rowBPo["strBuyerPONO"]."</option>>";
				}
			 ?>
            </select></td>
            </tr>
          <tr>
            <td class="normalfnt">Meterial</td>
            <td><select name="cboMeterial" class="txtbox" id="cboMeterial" style="width:100px" onchange="loadSubCategory();">  
            <option  value="0" >Select One</option>        
             <?php
			$Meterial="SELECT  intID, strDescription FROM matmaincategory ORDER BY strDescription;";			
			$result_Meterial = $db->RunQuery($Meterial);	
			while($row_Meterial = mysql_fetch_array($result_Meterial))
			{
				echo "<option value=\"". $row_Meterial["intID"] ."\">" . $row_Meterial["strDescription"] ."</option>" ;
			}
			?>
            </select></td>
            </tr>
          <tr>
            <td class="normalfnt">Mat. Cat.</td>
            <td><select name="cboCategory" class="txtbox" id="cboCategory" style="width:100px" onchange="loadItemDetails();">
            <option value="0">Select One</option>
             <?php
			$subCategory="SELECT intSubCatNo, StrCatName FROM matsubcategory ORDER BY strCatName;";			
			$result_subCategory = $db->RunQuery($subCategory);	
			while($row_subCategory = mysql_fetch_array($result_subCategory))
			{
				echo "<option value=\"". $row_subCategory["intSubCatNo"] ."\">" . $row_subCategory["StrCatName"] ."</option>" ;
			}
			?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt">Met Det</td>
            <td colspan="2"><select name="cboDescription" class="txtbox" id="cboDescription" style="width:225px">
            <option value="0">Select One</option>
            <?php
			$Description="SELECT strItemDescription, intItemSerial FROM matitemlist ORDER BY strItemDescription;";			
			$result_Des = $db->RunQuery($Description);	
			while($row_Des = mysql_fetch_array($result_Des))
			{
				echo "<option value=\"". $row_Des["intItemSerial"] ."\">" . $row_Des["strItemDescription"] ."</option>" ;
			}
			?>
            </select></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0">
          <tr>
            <td width="5%" class="normalfnt">Supplier</td>
            <td width="27%"><select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:250px">
            <option value="0">Select One</option>
             <?php
			$suppliers="SELECT strSupplierID, strTitle FROM suppliers ORDER BY strTitle;";			
			$result_suppliers = $db->RunQuery($suppliers);	
			while($row_suppliers = mysql_fetch_array($result_suppliers))
			{
				echo "<option value=\"". $row_suppliers["strSupplierID"] ."\">" . $row_suppliers["strTitle"] ."</option>" ;
			}
			?>
            
            </select></td>
            <td width="4%" class="normalfnt">Buyer</td>
            <td width="33%"><select name="cboBuyer" class="txtbox" id="cboBuyer" style="width:280px">
            <option value="0">Select One</option>
             <?php
			$buyers="SELECT buyers.intBuyerID, buyers.strName FROM buyers ORDER BY strName;";			
			$result_buyers = $db->RunQuery($buyers);	
			while($row_buyers = mysql_fetch_array($result_buyers))
			{
				echo "<option value=\"". $row_buyers["intBuyerID"] ."\">" . $row_buyers["strName"] ."</option>" ;
			}
			?>
            </select></td>
            <td width="8%" class="normalfnt">Company</td>
            <td width="23%" ><select name="cboCompany" class="txtbox" id="cboCompany" style="width:250px">
              <option value="0">Select One</option>
              <?php
			$buyers="select intCompanyID,strName from companies order by strName;";			
			$result_buyers = $db->RunQuery($buyers);	
			while($row_buyers = mysql_fetch_array($result_buyers))
			{
				echo "<option value=\"". $row_buyers["intCompanyID"] ."\">" . $row_buyers["strName"] ."</option>" ;
			}
			?>
            </select></td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>   
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="23%" height="29">&nbsp;</td>
        <td width="14%"><img src="../images/report.png" width="108" height="24" onclick="ShowReport();" /></td>
        <td width="11%"><a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0" /></a></td>
        <td width="20%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
