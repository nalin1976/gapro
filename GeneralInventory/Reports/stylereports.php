<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General Stock Reports Filter</title>
<script type="text/javascript" src="Reports.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
.legendHeader{
	background-color:#FFFFFF;	
	font-family: Verdana;
	font-size: 11px;
	color: #000099;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:bold;
}
.border-bottom-style-report {
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #C9DFF1;
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}
.border-bottom-top-style-report {
	border-top-width: thin;
	border-top-style: solid;
	border-top-color: #C9DFF1;
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #C9DFF1;
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}
.roundedCorners{	
      -moz-border-radius-bottomleft:9px;  
      -moz-border-radius-bottomright:9px;  
      -moz-border-radius-topleft:9px;  
      -moz-border-radius-topright:9px;  
      -moz-border-radius:5px;
	  border-style:solid;
	  border-color:#C9DFF1;
	  border-width:1px;
}
-->
</style>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>

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

include "../../Connector.php";
$backwardseperator = "../../";

?>
<form name="frmStyleReport" id="frmStyleReport">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="950" border="0" >
      <tr>
        <td width="55%" height="5"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr>
	<td ><fieldset class="roundedCorners" >
	<legend class="legendHeader">&nbsp;Purchase Orders&nbsp;</legend>    
	<table width="100%" border="0" class="fontColor10">
	<tr>
	<td width="3%" class="normalfnt"><input type="radio" name="radio" id="radConPO" value="radConPO" onclick="setReport('rptStylePO.php',1);" /></td>
	<td width="30%" class="normalfnt">Confirmed</td>
	<td width="3%"  ><input type="radio" name="radio" id="radPenPO" value="radPenPO" onclick="setReport('rptStylePO.php',0);" /></td>
	<td width="30%" class="normalfnt">Pending</td>
	<td width="3%" ><input type="radio" name="radio" id="radCanPO" value="radCanPO" onclick="setReport('rptStylePO.php',10);"/></td>
	<td width="30%" class="normalfnt">Canceled</td>
	</tr>
	</table>
	</fieldset>	</td>	
	</tr>

	<tr>
	<td ><fieldset class="roundedCorners" >
	<legend class="legendHeader">&nbsp;Grn Details&nbsp;</legend>    
	<table width="100%" border="0" class="fontColor10">
	<tr>
	<td width="3%" class="normalfnt"><input type="radio" name="radio" id="radConGRN" value="radConGRN" onclick="setReport('rptStyleGRN.php',1);" /></td>
	<td width="30%" class="normalfnt">Confirmed</td>
	<td width="3%" ><input type="radio" name="radio" id="radPenGRN" value="radPenGRN" onclick="setReport('rptStyleGRN.php',0);" /></td>
	<td width="30%" class="normalfnt">Pending</td>
	<td width="3%" ><input type="radio" name="radio" id="radCanGRN" value="radCanGRN" onclick="setReport('rptStyleGRN.php',10);" /></td>
	<td width="30%" class="normalfnt">Canceled</td>
	</tr>
	</table>
	</fieldset>	</td>	
	</tr>

	<tr>
	<td ><fieldset class="roundedCorners" >
	<legend class="legendHeader">&nbsp;Issue Details&nbsp;</legend>    
	<table width="100%" border="0" class="fontColor10">
	<tr>
	<td width="3%" class="normalfnt"><input type="radio" name="radio" id="radConIssue" value="radConIssue" onclick="setReport('rptStyleIssues.php',1)" /></td>
	<td width="30%" class="normalfnt">Confirmed</td>
	<td width="3%" ><input type="radio" name="radio" id="radConGatePass" value="radConGatePass" onclick="setReport('rptStyleGatePass.php',0)" style="visibility:hidden" /></td>
	<td width="30%" class="normalfnt">&nbsp;</td>
	<td width="3%" >&nbsp;</td>
	<td width="30%" class="normalfnt">&nbsp;</td>
	</tr>
	</table>
	</fieldset>	</td>	
	</tr>

	<tr>
	<td ><fieldset class="roundedCorners" >
	<legend class="legendHeader">&nbsp;Return To Stores:&nbsp;</legend>    
	<table width="100%" border="0" class="fontColor10">
	<tr>
	<td width="3%" class="normalfnt"><input type="radio" name="radio" id="radCanRetToSto" value="radCanRetToSto" onclick="setReport('rptStyleRetToStores.php',1);" /></td>
	<td width="30%" class="normalfnt">Confirmed</td>
	<td width="3%" ><input type="radio" name="radio" id="radConGatePass" value="radConGatePass" onclick="setReport('rptStyleGatePass.php',0)" style="visibility:hidden" /></td>
	<td width="30%" class="normalfnt">&nbsp;</td>
	<td width="3%" ><input type="radio" name="radio" id="radConRetToSto" value="radConRetToSto" onclick="setReport('rptStyleRetToStores.php',10)" /></td>
	<td width="30%" class="normalfnt">Canceled</td>
	</tr>
	</table>
	</fieldset>	</td>	
	</tr>
	
	<tr>
	<td ><fieldset class="roundedCorners" >
	<legend class="legendHeader">&nbsp;Return To Supplier:&nbsp;</legend>    
	<table width="100%" border="0" class="fontColor10">
	<tr>
	<td width="3%" class="normalfnt"><input type="radio" name="radio" id="radConRetToSup" value="radConRetToSup" onchange="setReport('rptStyleRetToSupplier.php',1)" /></td>
	<td width="30%" class="normalfnt">Confirmed</td>
	<td width="3%" ><input type="radio" name="radio" id="radConGatePass" value="radConGatePass" onclick="setReport('rptStyleGatePass.php',0)" style="visibility:hidden" /></td>
	<td width="30%" class="normalfnt">&nbsp;</td>
	<td width="3%" ><input type="radio" name="radio" id="radCanRetToSup" value="radCanRetToSup" onchange="setReport('rptStyleRetToSupplier.php',10)" /></td>
	<td width="30%" class="normalfnt">Canceled</td>
	</tr>
	</table>
	</fieldset>	</td>	
	</tr>
	
	<tr>
	<td ><fieldset class="roundedCorners" >
	<legend class="legendHeader">&nbsp;Gate Pass :&nbsp;</legend>    
	<table width="100%" border="0" class="fontColor10">
	<tr>
	<td width="3%" class="normalfnt"><input type="radio" name="radio" id="radConGatePass" value="radConGatePass" onclick="setReport('rptStyleGatePass.php',1)" /></td>
	<td width="30%" class="normalfnt">Confirmed</td>
	<td width="3%" ><input type="radio" name="radio" id="radConGatePass" value="radConGatePass" onclick="setReport('rptStyleGatePass.php',0)" /></td>
	<td width="30%" class="normalfnt">Pending</td>
	<td width="3%" ><input type="radio" name="radio" id="radCanGatePass" value="radConGatePass" onclick="setReport('rptStyleGatePass.php',10)" /></td>
	<td width="30%" class="normalfnt">Canceled</td>
	</tr>
	</table>
	</fieldset>	</td>	
	</tr>
	
	<tr>
	<td ><fieldset class="roundedCorners" >
	<legend class="legendHeader">&nbsp;Gate Pass Transfer In&nbsp;</legend>    
	<table width="100%" border="0" class="fontColor10">
	<tr>
	<td width="3%" class="normalfnt"><input type="radio" name="radio" id="radConGatePassTrIn" value="radConGatePassTrIn" onclick="setReport('rptgatepasstransferin.php',1)" /></td>
	<td width="30%" class="normalfnt">Confirmed</td>
	<td width="3%" ><input type="radio" name="radio" id="radConGatePass" value="radConGatePass" onclick="setReport('rptStyleGatePass.php',0)" style="visibility:hidden" /></td>
	<td width="30%" class="normalfnt">&nbsp;</td>
	<td width="3%" ><input type="radio" name="radio" id="rbreport19" value="rbreport" /></td>
	<td width="30%" class="normalfnt">Canceled</td>
	</tr>
	</table>
	</fieldset>	</td>	
	</tr>

	<tr>
	<td colspan="6" ><fieldset class="roundedCorners" >
	<legend class="legendHeader">&nbsp;Interjob Transfer In:&nbsp;</legend>    
	<table width="100%" border="0" class="fontColor10">
	<tr>
	<td width="3%" class="normalfnt"><input type="radio" name="radio" id="radSaveIntJobTrns" value="radSaveIntJobTrns" onclick="setReport('rptInterJobTransfer.php',0);" /></td>
	<td width="30%" class="normalfnt">Saved</td>
	<td width="3%" ><input type="radio" name="radio" id="radApprIntJobTrns" value="radApprIntJobTrns" onclick="setReport('rptInterJobTransfer.php',1);" /></td>
	<td width="30%" class="normalfnt">Approved</td>
	<td width="3%" ><input type="radio" name="radio" id="radAuthIntJobTrns" value="radAuthIntJobTrns" onclick="setReport('rptInterJobTransfer.php',2);" /></td>
	<td width="30%" class="normalfnt">Authorized</td>
	</tr>
	<tr>
	  <td class="normalfnt"><input type="radio" name="radio" id="radConfIntJobTrns" value="radConfIntJobTrns" onclick="setReport('rptInterJobTransfer.php',3);" /></td>
	  <td class="normalfnt">Confirmed</td>
	  <td >&nbsp;</td>
	  <td class="normalfnt">&nbsp;</td>
	  <td ><input type="radio" name="radio" id="radCanIntJobTrns" value="radCanIntJobTrns" onclick="setReport('rptInterJobTransfer.php',10);" /></td>
	  <td class="normalfnt">Canceled</td>
	  </tr>
	</table>
	</fieldset>
	</td>	
	</tr>       
         
          <tr>
            <td height="5"></td>
            </tr>
        </table></td>
        <td width="45%" valign="top"><table width="100%" height="146" border="0" class="bcgl1">
          <tr>
            <td height="24" class="normalfntMid border-bottom-top-style-report " bgcolor="#EAEAFF">Style Details</td>
            </tr>
          <tr >
            <td height="116" class="normalfnt"><table width="100%" height="431" border="0" cellpadding="0" cellspacing="0">
              <tr height="20">
                <td width="36%" class="normalfnt">Main Meretial </td>
                <td width="64%"><select name="cboMeterial" class="txtbox" id="cboMeterial" style="width:250px" onchange="loadSubCategory();">
                  <option  value="" ></option>
                  <?php
	     	$Meterial="SELECT intID,strDescription FROM genmatmaincategory where status='1' ORDER BY strDescription";
			//$Meterial="SELECT  intID, strDescription FROM matmaincategory ORDER BY strDescription;";			
			$result_Meterial = $db->RunQuery($Meterial);	
			while($row_Meterial = mysql_fetch_array($result_Meterial))
			{
				echo "<option value=\"". $row_Meterial["intID"] ."\">" . $row_Meterial["strDescription"] ."</option>" ;
			}
			?>
                  </select></td>
              </tr>
              <tr height="20">
                <td class="normalfnt">Sub Category </td>
                <td><select name="cboCategory" class="txtbox" id="cboCategory" style="width:250px" onchange="loadItemDetails();">
            <option value=""></option>
             <?php
			$subCategory="SELECT intSubCatNo,StrCatName FROM genmatsubcategory ORDER BY StrCatName";
			//$subCategory="SELECT intSubCatNo, StrCatName FROM matsubcategory ORDER BY strCatName;";			
			$result_subCategory = $db->RunQuery($subCategory);	
			while($row_subCategory = mysql_fetch_array($result_subCategory))
			{
				echo "<option value=\"". $row_subCategory["intSubCatNo"] ."\">" . $row_subCategory["StrCatName"] ."</option>" ;
			}
			?>
            </select></td>
              </tr>
              <tr height="20">
                <td class="normalfnt">Description</td>
                <td><select name="cboDescription" class="txtbox" id="cboDescription" style="width:250px">
            <option value=""></option>
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
              <tr>
                <td   class="border-bottom-style-report">&nbsp;</td>
                <td  class="border-bottom-style-report">&nbsp;</td>
              </tr>
              <tr>
                <td   class="normalfnt">&nbsp;</td>
                <td  class="normalfnt">&nbsp;</td>
              </tr>
              <tr height="20">
                <td class="normalfnt">Supplier</td>
                <td  class="normalfnt"><select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:250px">
            <option value=""></option>
             <?php
			$suppliers="SELECT strSupplierID, strTitle FROM suppliers ORDER BY strTitle;";			
			$result_suppliers = $db->RunQuery($suppliers);	
			while($row_suppliers = mysql_fetch_array($result_suppliers))
			{
				echo "<option value=\"". $row_suppliers["strSupplierID"] ."\">" . $row_suppliers["strTitle"] ."</option>" ;
			}
			?>
            
            </select></td>
              </tr>
              <tr>
                <td   class="normalfnt">Company</td>
                <td  class="normalfnt"><select name="cboCompany" class="txtbox" id="cboCompany" style="width:250px">
                  <option value=""></option>
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
              <tr>
                <td class="border-bottom-style-report">&nbsp;</td>
                <td class="border-bottom-style-report">&nbsp;</td>
              </tr>
              <tr>
              <td height="20" colspan="2" class="normalfntMid border-bottom-style-report" bgcolor="#EAEAFF">Number  Range</td>
              </tr>
			<tr height="10">
			<td   class="normalfnt">&nbsp;</td>
			<td  class="normalfnt">&nbsp;</td>
			</tr>  
              <tr height="20">
                <td class="normalfnt">Number From </td>
                <td  class="normalfnt"><input name="txtponofrom" type="text" class="txtbox" id="txtponofrom" style="width:100px"/></td>
              </tr>
              <tr height="20">
                <td   class="normalfnt">Number To </td>
                <td  class="normalfnt"><input name="txtponoto" type="text" class="txtbox" id="txtponoto" style="width:100px"/></td>
              </tr>             
              <tr  height="20">
                <td class="border-bottom-style-report">&nbsp;</td>
                <td class="border-bottom-style-report">&nbsp;</td>
              </tr>
			    <tr  height="20">
                 <td class="normalfntMid border-bottom-style-report" bgcolor="#EAEAFF"><input name="checkbox" type="checkbox" id="chkDate" onclick="Clear(this);" checked="checked" /></td>
                 <td class="normalfnt border-bottom-style-report" bgcolor="#EAEAFF"> Data Range </td>
			    </tr>
			<tr height="10">
			<td   class="normalfnt">&nbsp;</td>
			<td  class="normalfnt">&nbsp;</td>
			</tr>  
              <tr  height="20">
                <td class="normalfnt">Date From </td>
                <td  class="normalfnt"><input name="dtmDateFrom" type="text" class="txtbox" id="dtmDateFrom" style="width:100px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
              </tr>
              <tr  height="20">
                <td   class="normalfnt">Date To </td>
                <td  class="normalfnt"><input name="dtmDateTo" type="text" class="txtbox" id="dtmDateTo" style="width:100px"onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
              </tr>
              <tr>
                <td   class="normalfnt">&nbsp;</td>
                <td  class="normalfnt">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0"  bgcolor="#D6E7F5">
                  <tr>
                    <td width="40%" align="center" valign="top" class="border-bottom-top-style-report "><div align="center"><img src="../../images/report.png" width="108" height="24" onclick="ShowReport();" />&nbsp;</div></td>
                    <td width="24%" align="center" valign="top" class="border-bottom-top-style-report "><div align="center"><img src="../../images/download.png" onclick="ShowExcelReport();" /></div></td>
                    <td width="36%" align="center" valign="top" class="border-bottom-top-style-report "><div align="center"><a href="../main.php"><img src="../../images/close.png" width="97" height="24" border="0" /></a></div></td>
                  </tr>
                </table></td>
                </tr>              
            </table></td>
            </tr>
        </table></td>
      </tr>    
    </table></td>
  </tr>
  <tr>   
  </tr>
</table>
</form>
</body>
</html>
