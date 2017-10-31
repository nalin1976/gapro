<?php
session_start();
$backwardseperator='';
include "authentication.inc";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Purchase Order</title>

<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
.tableComStockColr {
	border: 1px solid #DC8714;
	background-color: #F8DDB6;
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	text-align:left;
}
-->
</style>
<link rel="stylesheet" type="text/css" href="js/jquery-ui-1.8.9.custom.css"/>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="javascript/script.js" type="text/javascript"></script>
<script src="javascript/bom.js" type="text/javascript"></script>
<script src="allocation_inbom/allocation.js" type="text/javascript"></script>
<script type="text/javascript">
<?php

$xml = simplexml_load_file('config.xml');
$canRevicePO = $xml->PurchaseOrder->RevisePo;
$displaySupplierCode = $xml->PurchaseOrder->DisplaySupplierCodeOnPoMain;

?>

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
<script type="text/javascript">
var supplierCountryID = "";
function createXMLHttpRequest() 
	{
		if (window.ActiveXObject) 
		{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else if (window.XMLHttpRequest) 
		{
			xmlHttp = new XMLHttpRequest();
		}
	}

function getSupplierData(id)
{
	
	var url = "POMiddle.php?RequestType=getSupplierData&supId="+id;
	var xmlHttp=$.ajax({url:url,async:false});
	
 
			 //var obj= xmlHttp.responseXML.getElementsByTagName("");
			
			 document.getElementById('cbopayterms').value =  xmlHttp.responseXML.getElementsByTagName("strPayTermId")[0].childNodes[0].nodeValue;
			 
			 //var obj=xmlHttp.responseXML.getElementsByTagName("");
			  document.getElementById('cbopaymode').value =  xmlHttp.responseXML.getElementsByTagName("strPayModeId")[0].childNodes[0].nodeValue;
			 
			 //var obj=xmlHttp.responseXML.getElementsByTagName("");
			  document.getElementById('cboshipmentTerm').value =  xmlHttp.responseXML.getElementsByTagName("strShipmentTermId")[0].childNodes[0].nodeValue;
			 
			 //var obj=xmlHttp.responseXML.getElementsByTagName("");
			  document.getElementById('cboshipment').value =  xmlHttp.responseXML.getElementsByTagName("intShipmentModeId")[0].childNodes[0].nodeValue;
			
			// var obj=xmlHttp.responseXML.getElementsByTagName("");
			  document.getElementById('cbocurrency').value =  xmlHttp.responseXML.getElementsByTagName("strCurrency")[0].childNodes[0].nodeValue;
			if(document.getElementById('cboSupplier').value !=0)	
				document.getElementById('cbocurrency').onchange(); 
			 supplierCountryID = xmlHttp.responseXML.getElementsByTagName("strCountry")[0].childNodes[0].nodeValue;	
}
</script>


</head>

<body onload="LoadCompanies();">

<form id="frmPO" name="frmPO">

  <tr>
    <td colspan="2"><?php include 'Header.php'; ?></td>
  </tr>
  <table width="950" border="0" align="center" class="bcgl1">

  <tr>
    <td height="12"  class="mainHeading">Purchase Order - Data</td>
  </tr>
  <tr style="display:none">
    <td height="12" class="TitleN2white"><table width="950" border="0" cellpadding="0" cellspacing="0" class="backcolorYellow">
      <tr>
        <td width="79"  class="normalfnt">&nbsp;&nbsp;Company</td>
        <td width="250"><select name="select5" class="txtbox" id="select" style="width:205px">
         
          <?php
		  include "Connector.php"; 
		  $compnayID="";
		  $userID=$_SESSION["UserID"];
	$sql="SELECT intCompanyID FROM useraccounts  where intUserID='$userID';";
	$result = $db->RunQuery($sql);		
	while($row = mysql_fetch_array($result))
	{
	$compnayID=$row["intCompanyID"];
	}
	
	
	$SQL = "SELECT concat(strName,'-',strCity)as strName,intCompanyID FROM companies where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	if($row["intCompanyID"]==$compnayID)
	echo "<option value=\"". $row["intCompanyID"] ."\" selected>" . $row["strName"] ."</option>" ;
	else
	echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
        </select>
        </td>
        <td width="621"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="430" height="101" valign="top"><table width="100%" height="97" border="0" class="bcgl1" cellspacing="0" cellpadding="1">
          <tr>
            <td width="97" height="30" class="normalfnt">&nbsp;Find PO</td>
            <td width="93"><input name="txtfindpo" style="width:65px;" type="text" class="txtbox" id="txtfindpo" onclick="showPopUpEditPO();" tabindex="1" onkeypress="return CheckforValidDecimal(this.value, 0,event);" readonly="readonly" /></td>
            <td width="84"><select name="cboPOYearBox" id="cboPOYearBox" class="txtbox"  style="width:62px" tabindex="2">
              
              <?php
			for ($loop = date("Y") ; $loop >= 2008; $loop --)
			{
				echo "<option value=\"$loop\">$loop</option>";
			}
	?>
	
            </select></td>
            <td width="75" class="normalfnt"><img src="images/view2.png" width="62" height="21" onclick="loadPOdetails();" tabindex="3"/></td>
            <td width="62"><input type="text" name="textHiddenPO" id="textHiddenPO" style="visibility:hidden;width:20px"  /></td>
          </tr>
          <tr>
            <td height="30" class="normalfnt">&nbsp;Currency<span class="compulsoryRed"> *</span></td>
            <td colspan="3"><select name="cbocurrency" class="txtbox" id="cbocurrency" style="width:65px" onchange="convertRates();onchangePocalculate();" tabindex="4" disabled="disabled">
              
              <?php
			 
	
	
	$SQL = "SELECT intCurID,strCurrency FROM currencytypes c where intStatus='1' order by strCurrency;";	
	$result = $db->RunQuery($SQL);	
		echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;	
	while($row = mysql_fetch_array($result))
	{
	/*if($row["strCurrency"]=="USD")
	echo "<option value=\"". $row["strCurrency"] ."\" selected=\"selected\">" . $row["strCurrency"] ."</option>";
	else*/
	echo "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td><input type="text" name="textHiddenPO2" id="textHiddenPO2" style="visibility:hidden;hidden;width:20px" /></td>
          </tr>
          <tr>
            <td height="35" class="normalfnt">&nbsp;Supplier<span class="compulsoryRed"> *</span></td>
            <td colspan="4"><select onchange="getSupplierData(this.value);" name="cboSupplier" class="txtbox" id="cboSupplier" style="width:312px" tabindex="5">
			<option value="0" selected="selected">Select One</option>
                          <?php
if($displaySupplierCode=="true"){	
	$SQL = "SELECT concat(strTitle,' -> ',strSupplierCode)as strTitle,strSupplierID FROM suppliers s where intApproved='1' AND intStatus='1' order by strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
}
else{
	$SQL = "SELECT strTitle,strSupplierID FROM suppliers s where intApproved='1' order by strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
}

	?>
            </select></td>
            </tr>
        </table></td>
        <td width="520"><table width="100%" border="0" class="bcgl1" cellspacing="0" cellpadding="1">
          <tr>
            <td width="101" class="normalfnt">Deliver to<span class="compulsoryRed"> *</span></td>
    <td width="204"><select name="cbodiliverto" class="txtbox" id="cbodiliverto" style="width:200px" tabindex="6"> 
                          <?php
	
	$SQL = "SELECT strName,intCompanyID FROM companies where intStatus='1' order by strName;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
            </select>            </td>
            <td width="74" class="normalfnt">PO Value </td>
            <td width="128" align="left"><input  name="txtpovalue" type="text" class="txtbox" id="txtpovalue" value="0" style="text-align:right; width:100px;" onkeypress="return CheckforValidDecimal(this.value, 4,event);" tabindex="7" disabled="disabled" /></td>
          </tr>
          <tr>
            <td class="normalfnt">Invoice to <span class="compulsoryRed">*</span></td>
            <td><select name="cboinvoiceto" class="txtbox" id="cboinvoiceto" style="width:200px" tabindex="8">
                          <?php
	$sql = "select intCompanyID from companies where strDefaultInvoiceTo='Yes' and intStatus='1'";
	$result = $db->RunQuery($sql);		
	while($row = mysql_fetch_array($result))
	{	
		$defaultCompId = $row["intCompanyID"];
	}
	
	
	$SQL = "SELECT strName,intCompanyID FROM companies where intStatus='1' order by strName;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		if($defaultCompId==$row['intCompanyID'])
			echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
		else
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                  </select></td>
            <td class="normalfnt">PI No</td>
            <td align="left"><input name="txtpino" type="text" class="txtbox" id="txtpino"  tabindex="9" maxlength="30" style="width:100px;"/></td>
          </tr>
          <tr>
          <td class="normalfnt">Cost Center<span class="compulsoryRed">*</span></td>
           <td><select name="cboSewFactory" id="cboSewFactory" style="width:200px;">
           <?php 
		   $SQL = " select intCostCenterId,strDescription from costcenters where intStatus=1 order by strDescription ";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intCostCenterId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
		   ?>
           </select>
           </td>
          </tr>
          <tr>
            <td colspan="4" valign="top" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="102">Instructions</td>
                <td width="411"><textarea name="txtinstructions" style="width:380px;" rows="1" class="txtbox" id="txtinstructions" tabindex="10" onkeypress="return imposeMaxLength(this,event, 200);" onblur="showCalendar('deliverydateDD', '%d/%m/%Y');ControlableKeyAccess(event);" ></textarea>
                  <img src="images/copy.png" alt="copy" width="20" height="25" onclick="OpenCopyInstruPopUp();" /></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="430" valign="top"><table width="100%" border="0" class="bcgl1">
            <tr>
              <td width="104" class="normalfnt">Shipment Mode</td>
              <td width="111"><select name="cboshipment" class="txtbox" id="cboshipment" style="width:100px" ><option value="0" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strDescription,intShipmentModeId FROM shipmentmode s where intStatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
                  </select></td>
              <td width="105" class="normalfnt">Shipment Term</td>
              <td width="110"><select name="cboshipmentTerm" class="txtbox" id="cboshipmentTerm" style="width:100px"><option value="0" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strShipmentTerm,strShipmentTermId FROM shipmentterms s where intStatus='1' order by strShipmentTerm;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
	}
	
	?>
                  </select></td>
            </tr>
            <tr>
              <td class="normalfnt">Pay Mode<span class="compulsoryRed"> *</span></td>
              <td><select name="cbopaymode" class="txtbox" id="cbopaymode" style="width:100px">
			  <option value="0" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strPayModeId,strDescription FROM popaymentmode p where intstatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		/*if ($row["strPayModeId"] == 8)
		{
			echo "<option selected=\"selected\" value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
			
		}*/
		echo "<option value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
                </select>              </td>
              <td class="normalfnt">Pay Term<span class="compulsoryRed"> *</span></td>
              <td><select name="cbopayterms" class="txtbox" id="cbopayterms" style="width:100px">
                <option value="0" selected="selected">Select One</option>
                <?php
	
	$SQL = "SELECT strPayTermId,strDescription FROM popaymentterms p where intStatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
		/*if ($row["strPayTermId"] == 3)
		{
			echo "<option selected=\"selected\" value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
		}
		else
		{
			echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
		}*/
		echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
              </select></td>
            </tr>

        </table></td>
        <td width="520" valign="top"><table width="100%" border="0" class="bcgl1" cellpadding="2" cellspacing="0">
            <tr>
              <td width="78" class="normalfnt">Date</td>
              <td width="202"><input name="deliverydateL" type="text" class="txtbox" id="deliverydateL"  style="width:100px;"  value="<?php echo date('d/m/Y');?>" readonly="true" /> </td>
              <td width="10" class="normalfnt"></td>
              <td width="100" class="normalfnt">Delivery Date<span class="compulsoryRed">*</span> </td>
              <td width="130"><input name="deliverydateDD" type="text" class="txtbox" id="deliverydateDD"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" style="width:100px;" tabindex="11"/><input type="reset" value=""  class="txtbox" style="visibility:hidden; width:10px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
            </tr>
            <tr>
              <td class="normalfnt">ETD</td>
              <td>
               <input name="deliverydate" type="text" class="txtbox" id="deliverydate"  style="width:100px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" tabindex="12" /><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
              <td class="normalfnt">&nbsp;</td>
              <td class="normalfnt">ETA</td>
              <td><input name="deliverydateETA" type="text" class="txtbox" id="deliverydateETA"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"  style="width:100px;" tabindex="13"/><input type="reset" value=""  class="txtbox" style="visibility:hidden; width:10px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
            </tr>

        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFD5AA">
          <tr>
            <td width="32%" >&nbsp;</td>
            <td width="56%" ><div align="right">
              <!--<img src="images/addmatv.png" alt="Add Material wise" onclick="createPopUpStyle();" />-->
            </div></td>
            <td width="12%" ><img src="images/add-new.png" alt="Save" name="Save"  id="butNew" width="109" height="18"  tabindex="14"  onclick="showPopUp();"/></td>
          </tr>
        </table></td>
      </tr>
      <?php 
	  //GET BASE CURRNENCY
	  $SQLC = "SELECT CT.strCurrency from currencytypes CT inner join systemconfiguration S on CT.intCurID=S.intBaseCurrency";
			$resultc = $db->RunQuery($SQLC);		
	$rowC = mysql_fetch_array($resultc);
	$bCurrency = $rowC["strCurrency"];
	
				
	  ?>
      <tr>
        <td><div id="divcons" style="overflow:scroll; height:350px; width:950px;" tabindex="26" >
          <table width="1400" id="PoMatMain" cellpadding="0" bgcolor="#CCCCFF" cellspacing="1" >
            <tr>
              <td width="2%" bgcolor="#804000" class="normaltxtmidb2L">&nbsp;Del</td>
              <td width="8%" bgcolor="#804000" class="normaltxtmidb2L">&nbsp;Style - Order No </td>
              <td width="7%" bgcolor="#804000" class="normaltxtmidb2L">&nbsp;BPO No</td>
              <td width="5%" bgcolor="#804000" class="normaltxtmidb2L">&nbsp;Category</td>
              <td width="12%" bgcolor="#804000" class="normaltxtmidb2L">&nbsp;Description</td>
              <td width="8%" bgcolor="#804000" class="normaltxtmidb2L">&nbsp;Remarks</td>
              <td width="4%" bgcolor="#804000" class="normaltxtmidb2L">&nbsp;Color</td>
              <td width="3%" bgcolor="#804000" class="normaltxtmidb2">Unit</td>
              <td width="3%" bgcolor="#804000" class="normaltxtmidb2L">&nbsp;Size</td>
              <td width="5%" bgcolor="#804000" class="normaltxtmidb2">Qty</td>
              <td width="6%" bgcolor="#804000" class="normaltxtmidb2">Aditi. Qty</td>
              <td width="5%" bgcolor="#804000" class="normaltxtmidb2R">Unit Price</td>
             <!-- <td width="5%" bgcolor="#804000" class="normaltxtmidb2R">Max Rate (USD)</td>-->
              <td width="5%" bgcolor="#804000" class="normaltxtmidb2">Max Rate (<?php echo $bCurrency; ?>)</td>
              <td width="5%" bgcolor="#804000" class="normaltxtmidb2R">Max Rate</td>
              <td width="5%" bgcolor="#804000" class="normaltxtmidb2R">Value</td>
              <td width="4%" bgcolor="#804000" class="normaltxtmidb2">Delivery To</td>
              <td width="10%" bgcolor="#804000" class="normaltxtmidb2">Delivery Date</td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><?php $baseCountryId = getBaseCountryId(); ?></td>
  </tr>
  <tr bgcolor="#FFD5AA">
    <td height="30"><table width="100%" border="0">
      <tr >
        <td colspan="8"  align="center"><img src="images/new.png" alt="new" name="imageField" width="96" height="24" class="mouseover" onclick="ClearForNewPO();" type="image" />
        <img src="images/save.png" id="butSave" alt="Save" width="84" height="24" class="mouseover" onclick="changedeliveryDate();savePOHeader();" />
        <img src="images/conform.png" id="imgConfirm" alt="conform" class="mouseover" onclick="conform();" style="display:none"    />
         <img src="images/send2app.png" id="imgsendToApprov" alt="conform" class="mouseover" onclick="sendToApproval();" style="display:none"    />
        <img src="images/copyPO.png" alt="copy PO" width="108" height="24" class="mouseover" onclick="loadPO();" id="butcpoyPO"/>
        <img src="images/report.png" alt="Report" width="108" height="24" border="0" class="mouseover" onclick="reportPopup();"  />
        <img src="images/porevise.png" width="115" height="24" class="mouseover" onclick="showRevisePopup();"  <?php if ($canRevicePO == "false") {  echo 'style="visibility:hidden;"';   }?> />
        <img src="images/cancel-po.png" width="122" height="24" class="mouseover"  onclick="showCanelPopup();" <?php if (!$canCancelPO) {  echo 'style="visibility:hidden;"';   }?> />
        <a href="main.php"><img src="images/close.png" alt="close" width="97" height="24" class="mouseover" border="0"/></a>
        </td>
        </tr>
      
    </table></td>
    </tr>
</table>
</form>
<div style="left:310px; top:460px; z-index:10; position:absolute; width: 240px; visibility:hidden; height: 65px;" id="copyPOMain">
  <table width="302" height="56" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="52">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td><div align="center">Year </div></td>
            <td width="62">
              <div align="right">
                <select name="cboCopyEear" id="cboCopyEear" class="txtbox"  style="width:60px" onchange="fireSearch();">
                  <?php
				  echo "<option value=\"0\">Select One</option>";
			for ($loop = date("Y") ; $loop >= 2008; $loop --)
			{ 
				echo "<option value=\"$loop\">$loop</option>";
			}
	?>
                </select>
                  </div></td><td colspan="2"> &nbsp;PO No 
&nbsp;
<select name="select7" class="txtbox" id="cboPONo" style="width:100px" >
  
</select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right"><img src="images/go.png" alt="Copy PO" width="30" height="22" vspace="3" class="mouseover" onclick="copyPO();" /></div></td>
            <td width="65">&nbsp;</td>
            <td width="121">&nbsp;</td>
          </tr>
  </table>
		
		
</div>

<div style="left:300px; top:145px; z-index:10; position:absolute; width: 228px; visibility:hidden;" id="FindPO"><table width="250" height="58" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
	<tr><td bgcolor="#550000" colspan="2" align="right"><img src="images/cross.png" onClick="closeFindPO();" alt="Close" name="Close" width="17" height="17" id="Close"/></tr>
          <tr>
            <td width="82"><div align="center">Supplier</div></td>
            <td width="242"><select name="select2" class="txtbox" id="cboSupFind" style="width:180px" onchange="LoadPOacSup();">
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
            <td><div align="center">PO No </div></td>
            <td><select name="select" class="txtbox" id="cboPONoFind" style="width:100px" onchange="setValuetoPoBox();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
          </tr>
          <tr>
            <td>Order By</td>
            <td><select name="cboOrderbyType" id="cboOrderbyType" style="width:100px;" >
            <option value="0" selected="selected">OrderNo & Item</option>
            <option value="1">By Item</option>
             <option value="2">By Order</option>
            </select></td>
          </tr>
        </table>
		
		
</div>
<div style="left:291px; top:460px; z-index:10; position:absolute; width: 399px; visibility:hidden;" id="gotoReport">
  <table width="404" height="65" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="42" height="27">Report State </td>
            <td width="100"><select name="select3" class="txtbox" id="RptState" style="width:100px" onchange="LoadPOacState();">
              <option value="1">Pending</option>
              <option value="10">Confirm</option>
              <option value="11">Cancel</option>
            </select></td>
            <td width="54">Year</td>
            <td width="50"><select name="select4" class="txtbox" id="cboYear" style="width:50px" onchange="LoadPOacState();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intYear FROM purchaseorderheader ORDER BY intYear DESC;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intYear"] ."\">" . $row["intYear"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td width="26">&nbsp;</td>
            <td width="41">Normal</td>
            <td width="24">
                <input type="radio" name="chkNormal2"  id="chkNormal" checked="checked"  /></td>
            <td width="25">&nbsp;</td>
            <td width="42">Other</td>
            <td width="120">
			    <input type="radio" name="chkNormal2" id="chkOther"  /></td>
          </tr>
          <tr>
            <td><div align="center">PO No </div></td>
            <td><select name="select" class="txtbox" id="cboRptPONo" style="width:100px" onchange="showReport();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>Suppplier</td>
            <td colspan="7"><select id="cborptSupplier" name="cborptSupplier" class="txtbox"  style="width:328px" onchange="LoadPOacState();">
              <option value="0" selected="selected"></option>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="7">&nbsp;</td>
          </tr>
  </table>
		
		
</div>
<div style="left:200px; top:424px; z-index:10; position:absolute; width: 100px; visibility:hidden;" id="confirmReport">
<table width="200" height="60" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
<tr>
<td colspan="6">
	<tr>
		<td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td><img src="images/cross.png"  onclick="closedConfirmReport();"/></td>
	</tr>
	<tr>
		<td width="5" height="20">&nbsp;</td>
	    <td width="42">Normal</td>
	    <td width="27"><input type="radio" name="chkNormal" value="checkbox" id="rdoNormal" checked="checked" /></td>
	    <td width="33">Other</td>
	    <td width="73"><input type="radio" name="chkNormal" value="checkbox" id="rdoOther" /></td>
	    <td width="18">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="4"><img src="images/view.png" alt="print" width="95" height="19" class="mouseover" onclick="viewConfirmReport();" /></td>
    </tr>
<tr><td colspan="6"></td>
<tr><td colspan="6"></tr>
</table>
</div>
<?php 
function getBaseCountryId()
{
	global $db;
	$sql="select intBaseCountry from systemconfiguration";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["intBaseCountry"];
}
?>
<script type="text/javascript">
var canIncreaseUnitPriceFromPO = <?php

if($canIncreaseUnitPriceFromPO)
	echo "true";
else
	echo "false";

?>;

var canConfirmPOs = <?php
if ($confirmPO)
	echo "true";
else
	echo "false";

?>;
var cantPurchaseStockAvailable='<?php echo $cantPurchaseStockAvailable; ?>';
var baseCountryId = '<?php echo $baseCountryId; ?>';
</script>
<script src="javascript/POScript.js" type="text/javascript"></script>
</body>
</html>
