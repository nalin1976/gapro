<?php
	session_start();
	

	include("../../Connector.php");
	$backwardseperator = "../../";
	$companyID=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Import Cusdec</title>

<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
	
}

-->
</style>

<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="cusdec.js" type="text/javascript"></script>
<script src="cusdecdescription.js" type="text/javascript"></script>
<script src="iou.js" type="text/javascript"></script>
<script src="search.js" type="text/javascript"></script>
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
<link type="text/css" href="../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });
	
				// Tabs
				$('#tabs').tabs();
	

				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		</script>
	
</head>
<?php
$xml = simplexml_load_file('../../config.xml');
$Declarant = $xml->companySettings->Declarant; 
$Destination = $xml->companySettings->Country; 
?>
<?php
$country="";
$sqlcountry="SELECT strCountryCode,strCountry FROM country ORDER BY strCountry";
$result_country=$db->RunQuery($sqlcountry);
		$country .= "<option value=\"".""."\">".""."</option>";		
	while($row_country=mysql_fetch_array($result_country))
	{
		$country .= "<option value=\"".$row_country["strCountryCode"]."\">".$row_country["strCountry"]."</option>";
	} 
?>

<body>
<form name="frmFabricIns" id="frmFabricIns" >
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../../Header.php'; 
 ?></td>
</tr>
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white" style="text-align:center"><input type="radio" name="optHeader" id="optBoi" value="IM" checked="checked" onclick="SetOptionValue(this);" onfocus="CloseSearchPopUp();" />&nbsp;Import Cusdec - BOI&nbsp;&nbsp;<input type="radio" name="optHeader" id="optGenaral" value="IMGEN" onclick="SetOptionValue(this);" onfocus="CloseSearchPopUp();"/>&nbsp;Import Cusdec - Genaral</td>
    </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr class="bcgl1txt1NB">
	  <td>
      <div  id="tabs" >
			<ul>
				<li><a href="#tabs-1" id="tabtest" >Header Information </a></li>
				<li><a href="#tabs-2" onclick="CloseSearchPopUp();LoadCusdecDetails();">Description Of Goods </a></li>
				<li><a href="#tabs-3" onclick="CloseSearchPopUp();">Cusdec List</a></li>
			    <li><a href="#tabs-4" onclick="CloseSearchPopUp();LoadExpenceType();">I O U </a></li>
			</ul>
			<div id="tabs-1">
			  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="89%" bgcolor="#9BBFDD" class="head1">Header Information </td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:hidden; height:581px; width:100%;">
		<table width="108%" height="262" id="tblGen">
		    <tr class="bcgl1">
		      <td height="23"><table width="100%" cellspacing="0" class="bcgl1">
                <tr>
                  <td width="0%">&nbsp;</td>
                  <td width="9%">Delivery No </td>
                  <td width="12%"><input name="txtDeliveryNo" type="text" class="txtbox" id="txtDeliveryNo" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="15" disabled="disabled" /></td>
                  <td width="11%"><img src="../../images/view.png" alt="view" width="91" height="19" onclick="SearchPopUp();" /></td>
				  <td width="1%">&nbsp;</td>
                  <td width="13%">Invoice No </td>
                  <td width="18%"><input name="txtInvoice" id="txtInvoice"  class="txtbox" size="28" maxlength="30"></td>
                  <td width="3%">&nbsp;</td>
                  <td width="8%">Date</td>
                  <td width="20%"><input name="txtDate" type="text" class="txtbox" id="txtDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date ("d/m/Y");?>"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
                  <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Mode</td>
                  <td><select name="cboMode" style="width:100px" id="cboMode" class="txtbox" >
<?php
$sqlmode="select strMode,CONCAT(strMode,'->',strPlaceofDcs) AS placeOfDocs from mode";
$result_mode=$db->RunQuery($sqlmode);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_mode=mysql_fetch_array($result_mode))
	{
		echo "<option value=\"".$row_mode["strMode"]."\">".$row_mode["placeOfDocs"]."</option>";
	}
?>
                  </select></td>
                  <td>&nbsp;</td>
				  <td>&nbsp;</td>
                  <td>Declarant</td>
                  <td><input name="txtDeclarent" type="text" class="txtbox" id="txtDeclarent" size="28"  readonly="readOnly"  value="<?php echo $Declarant ;?>" /></td>
                  <td>&nbsp;</td>
                  <td>Destination</td>
                  <td ><input name="txtDestination" type="text" class="txtbox" id="txtDestination" size="28" readonly="readOnly" value="<?php echo $Destination;?>"/></td>
                  </tr>
              </table></td>
		      </tr>
		    <tr>
		      <td height="35"><table width="100%" class="bcgl1">
                <tr>
                  <td width="3%" class="normalfnt">&nbsp;</td>
                  <td width="15%" class="normalfnt">Exporter</td>
                  <td width="26%" class="normalfnt"><select name="cboExporter" style="width:200px" id="cboExporter" class="txtbox">
<?php
$sqlsupplier="SELECT strSupplierId,strName FROM suppliers Order By strName";
$result_supplier=$db->RunQuery($sqlsupplier);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_supplier=mysql_fetch_array($result_supplier))
	{
		echo "<option value=\"".$row_supplier["strSupplierId"]."\">".$row_supplier["strName"]."</option>";
	}
?>
                  </select></td>
                  <td width="3%" class="normalfnt">&nbsp;</td>
                  <td width="19%" class="normalfnt">Consignee</td>
                  <td colspan="2" class="normalfnt"><select name="cboConsignee" style="width:200px" id="cboConsignee" class="txtbox" onchange="GetTQBNo(this);">
<?php
$sqlcostomer="SELECT strCustomerID,strName  FROM customers Order By strName";
$result_costomer=$db->RunQuery($sqlcostomer);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_costomer=mysql_fetch_array($result_costomer))
	{
		echo "<option value=\"".$row_costomer["strCustomerID"]."\">".$row_costomer["strName"]."</option>";
	} 
?>
                  </select></td>
                  <td width="4%" class="normalfnt">&nbsp;</td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Country Of Origin </td>
                  <td class="normalfnt"><select name="cboOrignCountry" style="width:200px" id="cboOrignCountry" class="txtbox"  onchange="GetOtherCountryAuto(this);">
				  <?php echo $country;?>
                  	</select></td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Consignee Ref Code </td>
                  <td colspan="2" class="normalfnt"><input name="txtConsigneeRetCode" style="width:200px" id="txtConsigneeRetCode" class="txtbox" maxlength="10"></td>
                  <td class="normalfnt">&nbsp;</td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Country Of Export </td>
                  <td class="normalfnt"><select name="cboExCountry" style="width:200px" id="cboExCountry" class="txtbox" >
				  <?php echo $country;?>
				  </select></td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">City Of Last Consi </td>
                  <td width="11%" class="normalfnt"><select name="cboLastConsiCity" style="width:100px" id="cboLastConsiCity" class="txtbox" >
				  <?php echo $country;?>
				  </select></td>
                  <td width="19%" class="normalfnt"><select name="cboTradingCountry" style="width:100px" id="cboTradingCountry" class="txtbox" >
				  <?php echo $country;?>
				  </select></td>
                  <td class="normalfnt">&nbsp;</td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Place Of Loading </td>
                  <td class="normalfnt"><input name="txtPlaceOfLoading" type="text" class="txtbox" id="txtPlaceOfLoading" style="width:200px" maxlength="30"/></td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                </tr>

              </table></td>
		      </tr>
		    <tr>
              <td height="35"><table width="100%" class="bcgl1">
                  <tr>
                    <td width="3%" class="normalfnt">&nbsp;</td>
                    <td width="15%" class="normalfnt">Vessel / Flight </td>
                    <td width="26%" class="normalfnt"><input name="txtVessel" type="text" class="txtbox" id="txtVessel"  size="37" maxlength="30"/></td>
                    <td width="3%" class="normalfnt">&nbsp;</td>
                    <td width="18%" class="normalfnt">Delivery Terms </td>
                    <td width="32%" class="normalfnt"><table width="100%" cellspacing="0">
                      <tr>
                        <td width="32%"><select name="txtDeliveryTerm" style="width:200px" id="txtDeliveryTerm" class="txtbox">
<?php
$sql_delivery="select strDeliveryCode,concat(strDeliveryCode,'-->',strDeliveryName)AS deliveryName from deliveryterms where intStatus=1";
$result_delivery=$db->RunQuery($sql_delivery);
	echo "<option value=\"".""."\">".""."</option>\n";
while($row_delivery=mysql_fetch_array($result_delivery))
{
	echo "<option value=\"".$row_delivery["strDeliveryCode"]."\">".$row_delivery["deliveryName"]."</option>\n";
}
?>
                        </select>
                          </select></td>
                        </tr>
                    </table></td>
                    <td width="3%" class="normalfnt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Voyage No </td>
                    <td class="normalfnt"><input name="txtVoyageNo" type="text" class="txtbox" id="txtVoyageNo" size="37" maxlength="30" /></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td colspan="2" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="36%">FCL</td>
                        <td width="8%"><input type="checkbox" name="chkFcl" id="chkFcl" onclick="VisibleFCLCombo(this);" /></td>
                        <td width="10%"><input name="txtFcl" type="text" class="txtbox" id="txtFcl" size="4" disabled="disabled" maxlength="2"/></td>
                        <td width="46%"><select name="cboFcl" style="width:70px" id="cboFcl" class="txtbox" disabled="disabled">
                          <option value="0" selected="selected"></option>
                          <option value="20">20</option>
                          <option value="40">40</option>
                        </select></td>
                      </tr>
                    </table></td>
                    <td class="normalfnt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Voyage Date </td>
                    <td class="normalfnt"><input name="txtVoyageDate" type="text" class="txtbox" id="txtVoyageDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Container No </td>
                    <td class="normalfnt"><input name="txtContainerNo" type="text" class="txtbox" id="txtContainerNo" style="width:200px"maxlength="50"/></td>
                    <td class="normalfnt">&nbsp;</td>
                  </tr>

              </table></td>
		      </tr>
		    <tr>
              <td height="35"><table width="100%" class="bcgl1">
                  <tr>
                    <td width="3%" class="normalfnt">&nbsp;</td>
                    <td width="15%" class="normalfnt">Curency</td>
                    <td width="26%" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="32%"><select name="cboCurrency" style="width:70px" id="cboCurrency" class="txtbox" onChange='GetCurrencyRate(this);'>
<?php
$sqlcurrency="SELECT strCurrency FROM currencytypes where intStatus=1;";
$result_currency=$db->RunQuery($sqlcurrency);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_currency=mysql_fetch_array($result_currency))
	{
		echo "<option value=\"".$row_currency["strCurrency"]."\">".$row_currency["strCurrency"]."</option>";
	} 
?>                       
                        </select></td>
                        <td width="29%">Ex Rate </td>
                        <td width="39%"><input name="txtExRate" type="text" class="txtbox" id="txtExRate" size="10" disabled=""/></td>
                      </tr>
                    </table></td>
                    <td width="3%" class="normalfnt">&nbsp;</td>
                    <td width="18%" class="normalfnt">Amount Invoiced </td>
                    <td width="32%" class="normalfnt"><table width="100%" cellspacing="0">
                        <tr>
                          <td width="35%"><input name="txtInvoAmount" type="text" class="txtbox" id="txtInvoAmount" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" /></td>
                          <td width="11%">&nbsp;</td>
                          <td width="54%">&nbsp;</td>
                        </tr>
                    </table></td>
                    <td width="3%" class="normalfnt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Previous Docs </td>
                    <td class="normalfnt"><input name="txtPreviousDoc" type="text" class="txtbox" id="txtPreviousDoc" size="37" maxlength="50" style="width:200px"/></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Bank</td>
                    <td class="normalfnt"><select name="cboBank" style="width:200px" id="cboBank" class="txtbox">
                      <?php
$sqlbank="select strBankCode,concat(strName,'-',strRemarks)as strName from bank order by strName";
$result_bank=$db->RunQuery($sqlbank);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_bank=mysql_fetch_array($result_bank))
	{
		echo "<option value=\"".$row_bank["strBankCode"]."\">".$row_bank["strName"]."</option>";
	}
?>
                    </select></td>
                    <td class="normalfnt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Terms Of Payment </td>
                    <td class="normalfnt"><select name="cboTermsOfPayment" style="width:200px" id="cboTermsOfPayment" class="txtbox" >
<?php
$sqlpayterms="select *  from paymentterm where intStatus=1";
$result_payterm=$db->RunQuery($sqlpayterms);
	echo "<option value=\"".""."\">".""."</option>";
while($row_payterm=mysql_fetch_array($result_payterm))
{
$paymentTerm	= $row_payterm["strPaymentTermID"].'-->'.$row_payterm["strPaymentTerm"];
	echo "<option value=\"".$row_payterm["strPaymentTermID"]."\">".$paymentTerm."</option>";
}
?>
                    </select></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Bank Ref No </td>
                    <td class="normalfnt"><input name="txtBankRefNo" style="width:200px" id="txtBankRefNo" class="txtbox" maxlength="20" /></td>
                    <td class="normalfnt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Office Of Endtry/Exit </td>
                    <td class="normalfnt"><input name="txtOfficeEntry" type="text" class="txtbox" id="txtOfficeEntry" size="37" maxlength="20" style="width:200px" /></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">LC No </td>
                    <td class="normalfnt"><input name="txtLcNo" style="width:200px" id="txtLcNo" class="txtbox" maxlength="20" /></td>
                    <td class="normalfnt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">TQB No </td>
                    <td class="normalfnt"><input name="txtTQBNo" type="text" class="txtbox" id="txtTQBNo" size="37" maxlength="20" style="width:200px" /></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">CBM</td>
                    <td class="normalfnt"><input name="txtWeight1" type="text" class="txtbox" id="txtWeight1" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" />
                      <input name="txtWeight2" type="text" class="txtbox" id="txtWeight2" size="15" maxlength="20" /></td>
                    <td class="normalfnt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Preference Code </td>
                    <td class="normalfnt"><input name="txtPreferenceCode" type="text" class="txtbox" id="txtPreferenceCode" maxlength="50" style="width:200px" /></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Buyer</td>
                    <td class="normalfnt"><select name="cboBuyer" style="width:200px" id="cboBuyer" class="txtbox">
                      <?php
$sqlbuyer="SELECT strBuyerID,strName  FROM buyers";
$result_buyer=$db->RunQuery($sqlbuyer);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_buyer=mysql_fetch_array($result_buyer))
	{
		echo "<option value=\"".$row_buyer["strBuyerID"]."\">".$row_buyer["strName"]."</option>";
	}
?>
                    </select></td>
                    <td class="normalfnt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Licence No </td>
                    <td class="normalfnt"><input name="txtLicenceNo" type="text" class="txtbox" id="txtLicenceNo" style="width:200px" maxlength="100" /></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">Authorized By </td>
                    <td class="normalfnt"><input name="txtAuthorizedBy" type="text" class="txtbox" id="txtAuthorizedBy" onkeyup="AutoCompleteAuthorizeName(event);" style="width:200px" maxlength="30" /></td>
                    <td class="normalfnt">&nbsp;</td>
                  </tr>
              </table></td>
		      </tr>
		    <tr>
              <td height="35"><table width="100%" class="bcgl1">
                  <tr>
                    <td width="3%" class="normalfnt">&nbsp;</td>
                    <td width="15%" class="normalfnt">Package Types </td>
                    <td width="26%" class="normalfnt"><select name="cboPackageType" style="width:200px" id="cboPackageType" class="txtbox">
                      <?php
$sqlpackage="select intPackageID,concat(strPackageCode,'-->',strPackageName)AS packageName from packagetypes where intStatus=1";
$result_package=$db->RunQuery($sqlpackage);
	echo "<option value=\"".""."\">".""."</option>\n";
while($row_package=mysql_fetch_array($result_package))
{
	echo "<option value=\"".$row_package["intPackageID"]."\">".$row_package["packageName"]."</option>\n";
}
?>
                    </select></td>
                    <td width="3%" class="normalfnt">&nbsp;</td>
                    <td width="18%" class="normalfnt">Marks</td>
                    <td width="32%" rowspan="2" class="normalfnt"><label for="textarea"></label>
                      <label for="textarea"></label>
                      <textarea name="txtMarks" id="txtMarks" style="width:250px" ></textarea></td>
                    <td width="3%" class="normalfnt">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">No Of Packages </td>
                    <td width="26%" class="normalfnt"><input name="txtNoOfPackages" type="text" class="txtbox" id="txtNoOfPackages" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="12" maxlength="10" /></td>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">&nbsp;</td>
                    <td class="normalfnt">&nbsp;</td>
                  </tr>
              </table></td>
		      </tr>
		    <tr>
              <td height="35"><table width="100%" class="bcgl1">

                  <tr>
                    <td width="2%" class="normalfnt">&nbsp;</td>
                    <td width="15%" class="normalfnt">FOB/CIF</td>
                    <td width="11%" class="normalfnt"><input name="txtFOB" type="text" class="txtbox" id="txtFOB" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" value="0" style="text-align:right"/></td>
                    <td width="7%" class="normalfnt">Insurance</td>
                    <td width="11%" class="normalfnt"><input name="txtInsurance" type="text" class="txtbox" id="txtInsurance" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" value="0" style="text-align:right"/></td>
                    <td width="7%" class="normalfnt">Freight</td>
                    <td width="18%" class="normalfnt"><input name="txtFreight" type="text" class="txtbox" id="txtFreight" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" value="0" style="text-align:right"/></td>
                    <td width="8%" class="normalfnt">Other</td>
                    <td width="7%" class="normalfnt"><input name="txtOther" type="text" class="txtbox" id="txtOther" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" value="0" style="text-align:right"/></td>
                    <td width="14%" class="normalfnt">&nbsp;</td>
                  </tr>
              </table></td>
		      </tr>
		    <tr>
              <td height="35"><table width="100%" class="bcgl1">
                  <tr>
                    <td width="2%" class="normalfnt">&nbsp;</td>
                    <td width="15%" class="normalfnt">Forwader</td>
                    <td width="11%" class="normalfnt"><select name="cboForwaders" style="width:150px" id="cboForwaders" class="txtbox">
<?php
$sqlforwaders="SELECT intForwaderID,strName  FROM forwaders Order By strName";
$result_forwaders=$db->RunQuery($sqlforwaders);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_forwaders=mysql_fetch_array($result_forwaders))
	{
		echo "<option value=\"".$row_forwaders["intForwaderID"]."\">".$row_forwaders["strName"]."</option>";
	}
?>
                    </select></td>
                    <td width="7%" class="normalfnt">&nbsp;</td>
                    <td width="6%" class="normalfnt">&nbsp;</td>
                    <td width="10%" class="normalfnt">Merchandiser</td>
                    <td width="15%" class="normalfnt"><input name="txtMerchandiser" type="text" class="txtbox" id="txtMerchandiser" size="15" maxLength="20"/></td>
                    <td width="11%" class="normalfnt">Wharf Cleark </td>
                    <td width="12%" class="normalfnt"><select name="cboWalfCleark" style="width:150px" id="cboWalfCleark" class="txtbox">
                      <?php
$sqlwolfcleark="SELECT intWharfClerkID,strName  FROM wharfclerks Order By strName";
$result_wolfcleark=$db->RunQuery($sqlwolfcleark);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_wolfcleark=mysql_fetch_array($result_wolfcleark))
	{
		echo "<option value=\"".$row_wolfcleark["intWharfClerkID"]."\">".$row_wolfcleark["strName"]."</option>";
	}
?>
                    </select></td>
                    <td width="11%" class="normalfnt">&nbsp;</td>
                  </tr>
              </table></td>
		      </tr>
		    <tr bgcolor="#D6E7F5">
		      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="22%">&nbsp;</td>
                  <td width="10%"><img src="../../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="ClearForm();"/></td>
                  <td width="10%"><img src="../../images/save.png" alt="new" name="butSave" width="84" height="24" class="mouseover"  id="butSave" onclick="SaveValidation();"/></td>
                  <td width="11%"><img src="../../images/cancel.jpg" alt="new" name="butCancel" class="mouseover"  id="butCancel" onclick="CancelCusdec();"/></td>
                  <td width="12%"><img src="../../images/print.png" alt="new" name="butPrint" width="115" height="24" class="mouseover"  id="butPrint" onclick="PrintCusdec();"/></td>
                  <td width="12%"><img src="../../images/close.png" alt="new" name="butClose" width="97" height="24" class="mouseover"  id="butClose" onclick="ClearForm();"/></td>
                  <td width="9%"><img src="../../images/report.png" width="108" height="24" alt="report" onclick="PrintOtherReport();" /></td>
                  <td width="14%">&nbsp;</td>
                  <td width="0%">&nbsp;</td>
                </tr>
              </table></td>
		      </tr>
		</table>
		</div>		</td>
        </tr>
    </table></div>
			<div id="tabs-2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="95%" bgcolor="#9BBFDD" class="head1"><div align="center">Description Of Goods </div></td>
        <td width="5%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:hidden; height:280px; width:100%px;">
		
		<table width="100%" height="293" class="bcgl1">		 
		<tr>
		<td height="45" colspan="6" ><div id="selectitem" style="overflow:scroll;height:250px;width:900px" ><table width="1200" cellpadding="0" cellspacing="1" id="tblDescription" class="bcgl1">
          <tr>
            <td width="1%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
            <td width="1%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">No</td>
            <td width="22%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
            <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Price</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Gross</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Net</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Packege</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Proc Code 1</td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Proc Code 2</td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">UMO_QTY 1</td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">UMO_QTY 2 </td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">UMO_QTY 3 </td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Value</td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">HS Code</td>
			<td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">Tax</td>     
		  </table></div></td>
		<td width="25" >&nbsp;</td>
		</tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td height="22" >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="6" >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td colspan="7" >&nbsp;</td>
          </tr>
		</table>
		</div>		</td>
        </tr>
		<tr><td colspan="2" bgcolor="#D6E7F5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="32%">&nbsp;</td>
            <td width="10%"><img src="../../images/addsmall.png" alt="new" name="butNew" width="95" height="24" class="mouseover"  id="openItemPopUp" onclick="OpenItemPoPup();"/></td>
            <td width="17%"><img src="../../images/calculateandsave.png" alt="new" name="butSave" class="mouseover"  id="butSave" onclick="SaveDetailValidation();"/></td>
            <td width="12%"><a href="../../main.php"><img src="../../images/close.png" alt="new" name="butClose" width="97" height="24" class="mouseover" border="0"  id="butClose"/></a></td>
            <td width="10%">&nbsp;</td>
            <td width="13%">&nbsp;</td>
            <td width="6%">&nbsp;</td>
          </tr>
        </table></td>
		</tr>
    </table>
			</div>
		<div id="tabs-3"  height:280px ><table width="100%" height="280" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="95%" height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="center" class="head1">Lots</div></td>
        <td width="5%" bgcolor="#9BBFDD" class="normalfnth2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" height="79%">  
		<tr>
              <td width="100%" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3%" height="24" class="normalfnt">&nbsp;</td>
                  <td width="9%" class="normalfnt">Delivery No </td>
                  <td width="15%" class="normalfnt"><input name="txtSearchDeliveryNo" type="text" class="txtbox" id="txtSearchDeliveryNo" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
                  <td width="10%" colspan="2" class="normalfnt">Invoice No </td>
                  <td width="13%" class="normalfnt"><input name="txtSearchInvoiceNo" type="text" class="txtbox" id="txtSearchInvoiceNo" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
                  <blockquote>&nbsp;</blockquote>
                  <td width="10%" colspan="2" class="normalfnt">Previous Docs </td>
                  <td width="12%" class="normalfnt"><input name="txtSearchPreDocs" type="text" class="txtbox" id="txtSearchPreDocs" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
                  <td width="12%" class="normalfnt">Entry No</td>
                  <td width="10%" class="normalfnt"><input name="txtSearchEntryNo" type="text" class="txtbox" id="txtSearchEntryNo" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
                  <td width="6%" class="normalfnt">&nbsp;</td>
                </tr>
                <tr>
                  <td height="24" class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">Exporter</td>
                  <td class="normalfnt"><select name="cboSearchExporter" style="width:150px" id="cboSearchExporter" class="txtbox">
				  <?php
$sqlsupplier="SELECT strSupplierId,strName FROM suppliers";
$result_supplier=$db->RunQuery($sqlsupplier);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_supplier=mysql_fetch_array($result_supplier))
	{
		echo "<option value=\"".$row_supplier["strSupplierId"]."\">".$row_supplier["strName"]."</option>";
	}
?></select></td>
                  <td colspan="2" class="normalfnt">Consignee</td>
                  <td class="normalfnt"><select name="cboSearchConsignee" style="width:150px" id="cboSearchConsignee" class="txtbox">
				  <?php
$sqlcostomer="SELECT strCustomerID,strName  FROM customers";
$result_costomer=$db->RunQuery($sqlcostomer);
		echo "<option value=\"".""."\">".""."</option>";
	while($row_costomer=mysql_fetch_array($result_costomer))
	{
		echo "<option value=\"".$row_costomer["strCustomerID"]."\">".$row_costomer["strName"]."</option>";
	} 
?>
</select></td>
                  <td colspan="2" class="normalfnt">Invoice Value </td>
                  <td class="normalfnt"><input name="txtSearchInvoiceValue" type="text" class="txtbox" id="txtSearchInvoiceValue" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
                  <td class="normalfnt">Container No </td>
                  <td class="normalfnt"><input name="txtSearchContainerNo" type="text" class="txtbox" id="txtSearchContainerNo" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
                  <td class="normalfnt">&nbsp;</td>
                </tr>
                <tr>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt">From</td>
                  <td class="normalfnt"><input type="checkbox" name="chkFrom" value="checkbox" id="chkFrom" /></td>
                  <td class="normalfnt"><input name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
                  <td class="normalfnt">To</td>
                  <td class="normalfnt"><input type="checkbox" name="chkTo" value="checkbox" id="chkTo" /></td>
                  <td class="normalfnt"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" /></td>
                  <td class="normalfnt">&nbsp;</td>
                  <td class="normalfnt"><img src="../../images/search.png" name="butSearch" id="butSearch" alt="search" onclick="SearchTab();" /></td>
                  <td class="normalfnt">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td class="normalfnt"><div id="divLotInterface" style=" overflow:scroll; width:100%; height:260px" ><table  id="tblSearch" width="902" cellpadding="0" cellspacing="1" class="bcgl1">
                <tr>
                  <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Delivery No</td>
                  <td width="7%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Invoice No</td>
                  <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
                  <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Exporter</td>
                  <td width="20%" bgcolor="#498CC2" class="normaltxtmidb2">Consignee</td>
                  <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Invoice Value </td>
                  <td width="15%" bgcolor="#498CC2" class="normaltxtmidb2">Previous Docs</td>
                </tr>
         <!--       <tr class="osc3">
                  <td    class="normalfnt">1000</td>
                  <td    class="normalfnt">1</td>
                  <td    class="normalfnt"> Description </td>
                  <td    class="normalfnt">Unit</td>
                  <td    class="normalfnt">500</td>
                  <td    class="normalfnt">1200</td>
                  <td    class="normalfnt">1200</td>
                </tr>-->
              </table></div></td>
            </tr>
          </table>
          <blockquote>&nbsp;</blockquote>
        
          </p></td>
      </tr>
    </table>
		</div>
		<div id="tabs-4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="44%" bgcolor="#9BBFDD" class="head1"><div align="right">I O U -</div></td>
        <td width="45%" bgcolor="#9BBFDD" id="tdIouNo" class="head1"></td>
        <!--<td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>-->
      </tr>
      <tr>
        <td height="280" colspan="3" class="normalfnt">
		<div id="divcons" style="overflow:hidden; height:280px; width:100%px;">
		<table width="100%" height="293" class="bcgl1">
		<tr>
		<td width="66" height="45" ><div id="selectitem" style="overflow:scroll;height:250px;width:900px" ><table id="tblIou" width="882" cellpadding="0" cellspacing="1" class="bcgl1">
          <tr>
            <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
            <td width="2%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">No</td>
            <td width="34%" bgcolor="#498CC2" class="normaltxtmidb2">Expenses Type</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Estimate</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Actual</td>
            <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">variance</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">invoice</td>
            </tr>
		  </table></div></td>
		<td width="33" >&nbsp;</td>
		</tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td ></td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td height="22" >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		<tr>
		  <td >&nbsp;</td>
          <td >&nbsp;</td>
		  </tr>
		</table>
		</div>		</td>
        </tr>
		<tr><td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="9%" bgcolor="#D6E7F5">Original</td>
            <td width="0%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="7%" bgcolor="#D6E7F5">Reason For Dupplicate </td>
            <td colspan="7" bgcolor="#D6E7F5"><span class="normalfnt">
              <input name="txtDuplicateRe" type="text" class="txtbox" id="txtDuplicateRe" size="100" maxlength="10" />
            </span></td>
            </tr>
          <tr>
            <td bgcolor="#D6E7F5"><span class="normalfnt">
              <input name="txtInsurance2" type="text" class="txtbox" id="txtInsurance2" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="10" />
            </span></td>
            <td bgcolor="#D6E7F5">&nbsp;</td>
            <td bgcolor="#D6E7F5">B/L No </td>
            <td width="9%" bgcolor="#D6E7F5"><span class="normalfnt">
              <input name="txtDocNo" type="text" class="txtbox" id="txtDocNo" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="20" readonly=""/>
            </span></td>
            <td width="8%" bgcolor="#D6E7F5">&nbsp;</td>
            <td width="9%" bgcolor="#D6E7F5"><img src="../../images/StyleNoRef.png" alt="new" name="butStyleRefNo" width="115" height="24" class="mouseover"  id="butStyleRefNo"/></td>
            <td width="13%" bgcolor="#D6E7F5"><img src="../../images/print.png" alt="new" name="butIouPrint" width="115" height="24" class="mouseover"  id="butIouPrint" onclick="PrintIOU();"/></td>
            <td width="12%" bgcolor="#D6E7F5"><img src="../../images/save.png" alt="new" name="butIouSave" width="84" height="24" class="mouseover"  id="butIouSave" onclick="ValidateIOU();"/></td>
            <td width="9%" bgcolor="#D6E7F5"><img src="../../images/close.png" alt="new" name="butNew" width="97" height="24" class="mouseover"  id="butNew" onclick="ClearForm();"/></td>
            <td width="24%" bgcolor="#D6E7F5">&nbsp;</td>
          </tr>
        </table></td></tr>
    </table>
		</div></div>		</td>
		</tr>
		
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td height="19" bgcolor="#D6E7F5">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
<script type="text/javascript">
	//T$('openItemPopUp').onclick = function(){TINY.box.show('itempopup.php',1,100,100,10)}
		//var content3 = "hi shanka";
	//T$('openItemPopUp').onclick = function(){TINY.box.show(content3,0,0,0,0,3)}
</script>

<!--Start - Search popup-->
<div style="left:334px; top:172px; z-index:10; position:absolute; width: 261px; visibility:hidden; height: 61px;" id="NoSearch" >
  <table width="260" height="61" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
		  	<td width="29" height="22" class="normalfnt"></td>
            <td width="70" height="22" class="normalfnt">State </td>
            <td width="159"><select name="select3" class="txtbox" id="cboState" style="width:125px" onchange="LoadPopUpNo();">              
              <option value="1">Saved</option>              
			  <option value="10">Cancelled</option>
            </select></td>
            
          </tr>
          <tr>
		  <td width="29" height="34" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Job No</div></td>
            <td><select name="cboNo" class="txtbox" id="cboNo" style="width:125px" onchange="LoadPopUpDeliveryNoToPage(this.value);">
<?php
$sqlpopup="select distinct intDeliveryNo from deliverynote where intStatus=0 AND RecordType='IM' order By intDeliveryNo DESC";
$result=$db->RunQuery($sqlpopup);
	echo "<option value=\"".""."\">"."select one"."</option>";
while($row=mysql_fetch_array($result))
{
	echo "<option value=\"".$row["intDeliveryNo"]."\">".$row["intDeliveryNo"]."</option>";
}
?>
            </select>            </td>
            
          </tr>
  </table>
		

</div>
<!--End - Search popup-->
<!--Start - Unit Conversion-->
<div style="left:90px; top:252px; z-index:10; position:absolute; width: 350px; visibility:hidden; height: 130px;" id="unitConversion">
<table width="353" height="130" border="0" cellpadding="0" cellspacing="0" class="normalfnt" bgcolor="#ffffff">
<tr>
<td colspan="8">
    <tr bgcolor="#ccff33" class="normalfntMid" height="15"><td  colspan="7" bgcolor="#99CCFF" ><strong>Unit Conversion</strong></td>
      <td align="right" bgcolor="#99CCFF" ><img src="../../images/cross.png" class="mouseover" onclick="closePOP();" /></td>
    </tr>
		<tr height="10"><td colspan="8">&nbsp;</td>		
		<tr class="normalfnt">		
	    <td width="70" align="left">&nbsp;&nbsp;From Unit  </td>
<?php 
$strText	="";
$sqlunits ="select 	strUnit
from 
units 
where intStatus=1";
$result_unit=$db->RunQuery($sqlunits);
	$strText	.= "<option vlue=\"".""."\">".""."</option>\n";
while($row_unit=mysql_fetch_array($result_unit))
{
	$strText	.= "<option vlue=\"".$row_unit["strUnit"]."\">".$row_unit["strUnit"]."</option>\n";
}
?>
	    <td width="90"><select name="cboPopupFromUnit" class="txtbox"  style="width:90px"  id="cboPopupFromUnit" onchange="ConvertCurrency();" >
<?php 
echo $strText

?>
        </select></td>
	     <td width="59">&nbsp;Qty</td>
	    <td width="97"><input name="txtFromUnitQty" type="text" class="txtbox" id="txtFromUnitQty" style="text-align:right;" size="12" maxlength="15" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onkeyup="ConvertCurrency();"/></td>
	
	    <td colspan="4" rowspan="2">&nbsp;</td>
    </tr>
	<tr  >
	 	
	    <td  align="left">&nbsp;&nbsp;To Unit </td>
	    <td ><select name="cboPopupToUnit" class="txtbox"  style="width:90px"  id="cboPopupToUnit" onchange="ConvertCurrency(this);" >
          <?php
echo $strText

?>
        </select></td>
	 <td >&nbsp;Qty</td>	
	 <td><input name="txtToUnitQty" type="text" class="txtbox" id="txtToUnitQty" style="text-align:right;" size="12" maxlength="15" onkeypress="return CheckforValidDecimal(this.value, 4,event);" readonly="" /></td>
	 <!-- <td colspan="2">Recived From wharf Cleark </td>-->
	  
	    <!--<td width="108"><input name="txtDeliveryNo3" type="text" class="txtbox" id="txtDeliveryNo3" " size="15" maxlength="15" disabled="disabled" />--><td width="2"></td>
	</tr>	
	<tr class="normalfnt">     
	  
	
	 
	 <td colspan="2" align="center" ><table class="mouseover" onclick="AddCovertedQty()">
	   <tr>
	     <td  ><img src="../../images/eok.png" alt="Ok" name="btnOk" width="18" height="18"  id="butCancel" /></td>
	       <td>&nbsp;Add</td>
          </tr>
      </table></td>
	 <td colspan="5"align="center" ><table class="mouseover" onclick ="ConvertCurrency()"><tr><td width="16"   ><img src="../../images/transfer.png" width="20" height="20"  alt="Cancel" name="butCancel" id="butCancel" /></td>
	 <td width="43">&nbsp;Convert</td>
	 </tr></table></td>
     <td width="32" align="center" >&nbsp;</td>
	</tr>
<tr><td colspan="8"></td>
<tr><td colspan="8"></tr>
</table>
</div>
<!--End - Unit Conversion-->
<script type="text/javascript">
if(document.getElementById('optBoi').checked)
		document.getElementById('txtDeliveryNo').parentNode.value = document.getElementById('optBoi').value;
	if(document.getElementById('optGenaral').checked)
document.getElementById('txtDeliveryNo').parentNode.value = document.getElementById('optGenaral').value;
</script>
</body>
</html>