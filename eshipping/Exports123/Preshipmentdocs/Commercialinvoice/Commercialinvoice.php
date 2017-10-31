<?php
	session_start();
	include("../../../Connector.php");
	$backwardseperator = "../../../";
	$invno=$_GET["invno"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web - Commercial Invoice</title>

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
.bcglm {
	border: 1px solid #CC9900;
}
</style>

<link type="text/css" href="../../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui-1.7.2.custom.min.js"></script>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />
<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
<script src="manualinvoice.js"></script>
<script src="Commercialinvoice.js" type="text/javascript"></script>
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

<link type="text/css" href="../../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../../js/jquery-ui-1.7.2.custom.min.js"></script>
        
        <link type="text/css" href="../../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../../js/jquery-ui-1.7.2.custom.min.js"></script>
        
        
		<script type="text/javascript" src="../../../js/jquery-1.4.4.min.js"></script>
		<link href="../../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../../../js/jquery-ui-1.8.9.custom.min.js"></script>
		<script src="jquery.fixedheader.js" type="text/javascript"></script>
		<script src="pl_plugin_search.js" type="text/javascript"></script>


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

<body><!-- setDefaultDate-->
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include $backwardseperator.'Header.php'; ?></td>
</tr>
  <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">Commercial Invoice</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr class="bcgl1txt1NB">
	  <td>
      <div  id="tabs" >
			<ul>
				<li><a href="#tabs-3" onclick="clearall();">Invoice</a></li>
				<li><a href="#tabs-2" onclick="getInvoiceDetail();">Description Of Goods</a></li>
				<li style="visibility:hidden"><a href="#tabs-1" onclick="checkInvoiceNo();retrv_po_wise_ci();">Details</a></li>
			</ul>
			<div id="tabs-3">
			  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="86%" bgcolor="#9BBFDD" class="head1">Pre-Shipment Information </td>
        <td width="14%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt"><div id="div"  style=" width:100%;">
          <table width="100%"  id="tblGen">
            
            <tr>
              <td><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                  <tr>
                    <td>&nbsp;</td>
                    <td>Pre Invoice </td>
                    <td height="25">
                    <input name="txtLoadPreInvoiceNo"  type="text" class="txtbox" id="txtLoadPreInvoiceNo"  style="width:90px" maxlength="30" onkeyup="loadPreInvNo(this,event);" />
                    <select name="cboInvoiceNo" class="txtbox" id="cboInvoiceNo" style="width:100px" onchange="getInvoceData('pre')" tabindex="3">
                      <option value=""></option>
                      <?php 
                   $sqlInvoice="SELECT strInvoiceNo FROM invoiceheader where strInvoiceNo in (select strInvoiceNo from cdn_header) and strInvoiceNo not in (select strPreInvoiceNo from commercial_invoice_header) order by intInvoiceId DESC";
                   //$sqlInvoice="SELECT strInvoiceNo FROM cdn_header ORDER BY strInvoiceNo";
				   $resultInvoice=$db->RunQuery($sqlInvoice);
						 while($row=mysql_fetch_array( $resultInvoice)) { ?>
                      <option value="<?php echo $row['strInvoiceNo'];?>"><?php echo $row['strInvoiceNo'];?></option>
                      <?php }?>
                    </select></td>
                    <td height="25">Invoice Type </td>
                    <td height="25"><select name="cboInvoiceType"  class="txtbox" tabindex="7" id="cboInvoiceType" style="width:160px">
                      <option value="F" >Final</option>
					  <option value="P" >Proforma</option>
                     
                    </select></td>
                    <td>Final Invoice </td>
                    <td><select name="cboFinalInvoice"   class="txtbox" id="cboFinalInvoice"style="width:160px" onchange="getInvoceData('final');freezFinalInvoice();" tabindex="1">
                      <option value=""></option>
                      <?php 
                   $sqlInvoice="SELECT strInvoiceNo FROM commercial_invoice_header order by strInvoiceNo";
                   $resultInvoice=$db->RunQuery($sqlInvoice);
						 while($row=mysql_fetch_array( $resultInvoice)) { ?>
                      <option value="<?php echo $row['strInvoiceNo'];?>"><?php echo $row['strInvoiceNo'];?></option>
                      <?php }?>
                    </select></td>
                  </tr>
                  <tr>
                    <td width="2%" height="25">&nbsp;</td>
                    <td width="10%">Invoice Format</td>
                    <td width="23%"><select name="cboComInvFormat" class="txtbox"  id="cboComInvFormat"   style="width:160px;" onchange="loadFormat()">
                      <option value=""></option>
                      <?php 
                   $strInvFormat="select intCommercialInvId,strCommercialInv from commercialinvformat order by strCommercialInv";
                   $resultInvFormat=$db->RunQuery($strInvFormat);
						 while($row_InvFormat=mysql_fetch_array( $resultInvFormat)) 
						 echo "<option value=".$row_InvFormat['intCommercialInvId'].">".$row_InvFormat['strCommercialInv']."</option>";                 
                   ?>
                    </select></td>
                    <td width="12%">Invoice Date </td>
                    <td width="21%"><input name="txtInvoiceDate" tabindex="2" type="text" class="txtbox" id="txtInvoiceDate" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                    <td width="12%">Po No</td>
                    <td width="20%"><select name="cboPreInvoiceNo"  class="txtbox" id="cboPreInvoiceNo" style="width:160px" onchange="loadPreInvoice(this);" >
                      <option value=""></option>
                      <?php 
                   $sqlInvoice="SELECT DISTINCT
								invoiceheader.strInvoiceNo,
								invoicedetail.strBuyerPONo
								FROM
								invoiceheader
								INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo
								where invoiceheader.strInvoiceNo in (select strInvoiceNo from cdn_header) and invoiceheader.strInvoiceNo not in (select strPreInvoiceNo from commercial_invoice_header)
								order by intInvoiceId DESC
								";
                   $resultInvoice=$db->RunQuery($sqlInvoice);
						 while($row=mysql_fetch_array( $resultInvoice)) { ?>
                      <option value="<?php echo $row['strInvoiceNo'];?>"><?php echo $row['strBuyerPONo'];?></option>
                      <?php }?>
                    </select></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="65"><table width="100%" height="26" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                <tr>
                  <td height="25">&nbsp;</td>
                  <td>Final Invoice No </td>
                  <td><input name="txtInvoiceNo" tabindex="4" type="text" class="txtbox" id="txtInvoiceNo"  style="width:158px; background-color:#FFC" maxlength="30" disabled="disabled" /></td>
                  <td>Pre Invoice No</td>
                  <td><input name="txtPreInvoiceNo" tabindex="4" type="text" class="txtbox" id="txtPreInvoiceNo"  style="width:158px; background-color:#FFC" maxlength="30" disabled="disabled"  /></td>
                  <td>Manufacturer</td>
                  <td><select name="cboShipper"  tabindex="5" class="txtbox" id="cboShipper"style="width:160px">
                    <option value=""></option>
                    <?php
                   $sqlConsignee="SELECT 	strCustomerID, 	strName,strMLocation FROM customers ORDER BY strName ";
                   $resultConsignee=$db->RunQuery( $sqlConsignee);
						 while($row=mysql_fetch_array( $resultConsignee)) 
						 echo "<option value=".$row['strCustomerID'].">".$row['strName']." - " .$row['strMLocation']."</option>";                 
                   ?>
                  </select></td>
                </tr>
                <tr>
                  <td height="25">&nbsp;</td>
                  <td>Consignee</td>
                  <td><select name="cboConsignee"  class="txtbox" tabindex="6" id="cboConsignee"style="width:160px">
                    <option value=""></option>
                    <?php 
                   $sqlBuyer="SELECT strBuyerID,strName,strBuyerCode FROM buyers where intDel!=1 ORDER BY strBuyerCode  ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
                  </select></td>
                  <td>NotifyOne/Broker</td>
                  <td><select name="cboNotoify1"  class="txtbox" tabindex="7" id="cboNotoify1" style="width:160px">
                    <option value=""></option>
                    <?php 
                   $sqlBuyer="SELECT strBuyerID,strBuyerCode,strName	FROM buyers where intDel=0 ORDER BY strBuyerCode ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) {
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";              }   
                   ?>
                  </select></td>
                  <td>Notify Two </td>
                  <td><select name="cboNotoify2"  tabindex="8" class="txtbox" id="cboNotoify2"style="width:160px">
                    <option value=""></option>
                    <?php 
                   $sqlBuyer="SELECT strBuyerID,strBuyerCode,strName FROM buyers where intDel=0 ORDER BY strBuyerCode ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID']." > ".$row['strBuyerCode']."--->".$row['strName']."</option>";                 
                   ?>
                  </select></td>
                </tr>
                <tr>
                  <td height="25">&nbsp;</td>
                  <td>Accountee</td>
                  <td><select name="cboAccountee"  class="txtbox" tabindex="6" id="cboAccountee"style="width:160px">
                    <option value=""></option>
                    <?php 
                   $sqlBuyer="SELECT strBuyerID,strName,strBuyerCode	FROM buyers where intDel=0 ORDER BY strBuyerCode  ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
                  </select></td>
                  <td>CSC </td>
                  <td><select name="cboCSC"  class="txtbox" tabindex="6" id="cboCSC"style="width:160px">
                    <option value=""></option>
                    <?php 
                   $sqlBuyer="SELECT strBuyerID,strName,strBuyerCode	FROM buyers where intDel=0 ORDER BY strBuyerCode  ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
                  </select></td>
                  <td>Ship/Deliver to</td>
                  <td><select name="cboSoldTo"  class="txtbox" tabindex="6" id="cboSoldTo"style="width:160px">
                    <option value=""></option>
                    <?php 
                   $sqlBuyer="SELECT strBuyerID,strName,strBuyerCode	FROM buyers where intDel=0 ORDER BY strBuyerCode  ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
                  </select></td>
                </tr>
                <tr>
                  <td height="25">&nbsp;</td>
                  <td>Incoterms</td>
                  <td><select name="txtDeliveryTerm" style="width:160px" id="txtDeliveryTerm" class="txtbox">
                    <?php
$sql_delivery="select strDeliveryCode,concat(strDeliveryCode,'-->',strDeliveryName)AS deliveryName from deliveryterms where intStatus=1";
$result_delivery=$db->RunQuery($sql_delivery);
	echo "<option value=\"".""."\">".""."</option>\n";
while($row_delivery=mysql_fetch_array($result_delivery))
{
	echo "<option value=\"".$row_delivery["strDeliveryCode"]."\">".$row_delivery["deliveryName"]."</option>\n";
}
?>
                  </select></td>
                  <td>LC # &amp; Date </td>
                  <td><input name="txtLC" type="text" tabindex="9" class="txtbox" id="txtLC" style="width:83px" maxlength="30" />
                  <input name="txtLcDate" tabindex="10" type="text" class="txtbox" id="txtLcDate" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                  <td>LC Issuing Bank </td>
                  <td><select name="cboLCBank"  tabindex="11" class="txtbox" id="cboLCBank" style="width:160px">
                    <option value=""></option>
                    <?php 
                   $sqlBuyer="SELECT strBankCode, 	strName FROM  bank ORDER BY strName";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBankCode'].">".$row['strName']."</option>";                 
                   ?>
                  </select></td>
                </tr>
                <tr>
                  <td width="2%"></td>
                  <td width="12%"></td>
                  <td width="21%"></td>
                  <td width="12%"></td>
                  <td width="21%"></td>
                  <td width="12%"></td>
                  <td width="20%"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                <tr>
                  <td>&nbsp;</td>
                  <td height="25">Port Of Loading </td>
                  <td><select name="txtLoading" tabindex="12" class="txtbox" id="txtLoading"style="width:160px">
                    <option value=""></option>
                    <option value="COLOMBO">COLOMBO</option>
                    <option value="KATUNAYAKE">KATUNAYAKE</option>
                  </select></td>
                  <td>Final Destination </td>
                  <td><select name="cboDestination"  tabindex="13" class="txtbox" id="cboDestination" style="width:160px">
                    <option value=""></option>
                    <?php 
                   $sqlCity="SELECT strPortOfLoading,strCityCode, strCity FROM city  order by strCity";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['strCityCode'].">".$row['strCity']." --> ".$row['strPortOfLoading']."</option>";                 
                   ?>
                  </select></td>
                  <td>Carrier</td>
                  <td><input name="txtCarrier" tabindex="14" type="text" class="txtbox" id="txtCarrier"  style="width:158px" maxlength="50" /></td>
                </tr>
                <tr>
                  <td width="2%">&nbsp;</td>
                  <td width="12%" height="25">Voyage No</td>
                  <td width="21%"><input name="txtVoyageeNo" tabindex="15" type="text" class="txtbox" id="txtVoyageeNo"  style="width:158px" maxlength="50" /></td>
                  <td width="12%">ETD/ ETA </td>
                  <td width="21%"><input name="txtSailing" tabindex="16" type="text" class="txtbox" id="txtSailing" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onfocus="set_default_date()" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset3" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
                    <input name="txtETA" tabindex="16" type="text" class="txtbox" id="txtETA" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset4" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                  <td width="12%">Manufacturer Date</td>
                  <td width="20%"><input name="txtManufacDate" tabindex="16" type="text" class="txtbox" id="txtManufacDate" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset3" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                <tr>
                  <td width="2%" height="25">&nbsp;</td>
                  <td width="12%">Currency</td>
                  <td><select name="cboCurrency"  onchange="setExchangeRates(this.value);setRates();"  class="txtbox" id="cboCurrency" tabindex="17" style="width:160px"/>  
                    <option value=""></option>
                    <?php 
                   $sqlCurrency="SELECT strCurrency, dblRate FROM currencytypes ORDER BY strCurrency ";
                   $resultCurrency=$db->RunQuery($sqlCurrency);
						 while($row=mysql_fetch_array( $resultCurrency)) 
						 echo "<option value=".$row['dblRate'].">".$row['strCurrency']."</option>";                 
                   ?>
                    </select></td>
                  <td width="12%">Exchange Rate </td>
                  <td><input type="text" name="txtExchangeRate" id="txtExchangeRate" style="width:158px" tabindex="18" class="txtbox"/></td>
                  <td width="12%">Authorized Person</td>
                  <td width="20%"><select name="txtAuthorizeby"  class="txtbox" id="txtAuthorizeby"style="width:160px">
                    <option value=""></option>
                    <?php 
                   $sqlClerk="SELECT 	intWharfClerkID, strName FROM wharfclerks  ";
                   $resultCity=$db->RunQuery($sqlClerk);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['intWharfClerkID'].">".$row['strName']."</option>";                 
                   ?>
                  </select></td>
                  </tr>
                <tr>
                  <td height="25">&nbsp;</td>
                  <td>Transport Mode </td>
                  <td><select name="cboTransMode" tabindex="20" class="txtbox" id="cboTransMode"style="width:160px">
                    <option value=""></option>
                    <option value="Sea">Sea Freight</option>
                    <option value="Air">Air Freight</option>
                    </select></td>
                  <td>Unit Price In </td>
                  <td><select name="cboUnit"  class="txtbox" id="cboUnit"style="width:160px">
                    <option value=""></option>
                    <option value="1">Per Dozen</option>
                    <option value="2" selected="selected">Per Piece</option>
                    </select></td>
                  <td>Payment Term </td>
                  <td><select name="cboPayterms"  tabindex="11" class="txtbox" id="cboPayterms" style="width:160px">
                    <option value=""></option>
                    <?php 
                   $strPayterms="select strPaymentTerm from paymentterm";
                   $resultPayterms=$db->RunQuery($strPayterms);
						 while($row_terms=mysql_fetch_array( $resultPayterms)) {?>
                    <option value="<?php echo $row_terms['strPaymentTerm'];?>"><?php echo $row_terms['strPaymentTerm'];?></option>
                    <?php }?>
                  </select></td>
                  </tr>
                <tr>
                  <td height="25">&nbsp;</td>
                  <td>Pro Invoice No </td>
                  <td width="21%" valign="top"><input name="txtProInvNo" tabindex="15" type="text" class="txtbox" id="txtProInvNo"  style="width:158px" maxlength="40" /></td>
                  <td>Bank</td>
                  <td width="21%"><select name="cboBank"  tabindex="11" class="txtbox" id="cboBank" style="width:160px">
                    <option value=""></option>
                    <?php 
                   $sqlBuyer="SELECT strBankCode, 	strName FROM  bank ORDER BY strName";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBankCode'].">".$row['strName']."</option>";                 
                   ?>
                    </select></td>
                  <td>Forwader</td>
                  <td><select name="cboForwader"  class="txtbox" id="cboForwader" style="width:160px">
                    <option value=""></option>
                    <?php 
                   $sqlClerk="SELECT 	intForwaderID, strName FROM forwaders  ";
                   $resultCity=$db->RunQuery($sqlClerk);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['intForwaderID'].">".$row['strName']."</option>";                 
                   ?>
                    </select></td>
                </tr>
                <tr>
                <td height="25">&nbsp;</td>
                <td>Discount</td>
                <td colspan="5"><input name="txtDiscount" type="text" value="0" class="txtbox" id="txtDiscount" style="width:50px; text-align:right"  maxlength="10" onkeypress="return CheckforValidDecimal(this.value, 4,event);" />
                <select name="cboPrecentageValue" type="text"  id="cboPrecentageValue" class="txtbox" style="width:50px" >
				    <option value="value">Value</option>
                    <option value="precentage">%</option>
				    </select></td>
                </tr>
                </table></td>
            </tr>
            
          </table>
        </div></td>
        </tr>
		 <tr bgcolor="#D6E7F5">
		
		<td colspan="2"><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
		  <tr>
		    <td width="189" height="29">&nbsp;</td>
		    <td width="109"><img src="../../../images/new.png" alt="new"  name="butNew" width="96" height="24" class="mouseover"  id="butNew2" onclick="pageReload(); "/></td>
		    <td width="97"><img src="../../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave2" onclick="saveData();" /></td>
		    <td width="62"><img src="../../../images/report.png" alt="butReportList" name="butReportList" width="108" height="24" class="mouseover" id="butReport2" onclick="printthis();"/></td>
		    <!--<td width="128"><img src="../../../images/print.png" width="115" height="24" class="mouseover" onclick="prit_straight()"/></td>-->
		    <td width="157"><a href="../../../main.php"><img src="../../../images/close.png" width="97" height="24" border="0" class="mouseover"  /></a></td>
		    <td width="134">&nbsp;</td>
		    </tr>
		  </table></td>
		</tr>	
    </table></div>
			<div id="tabs-2" ><table  width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="91%" height="21" bgcolor="#9BBFDD" class="head1">Description Of Goods </td>
        <td width="9%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:hidden;width:100%;">
		<table width="100%"  class="bcgl1">
		  <tr>
		    <td width="107" height="15">Order No</td>
		    <td width="187"><select name="cboPreDetInvoiceNo"  class="txtbox" id="cboPreDetInvoiceNo" style="width:160px" >
		      <option value=""></option>
		      <?php 
                   $sqlInvoice="SELECT DISTINCT
								invoiceheader.strInvoiceNo,
								invoicedetail.strBuyerPONo
								FROM
								invoiceheader
								INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo
								where invoiceheader.strInvoiceNo in (select strInvoiceNo from cdn_header) and invoiceheader.strInvoiceNo not in (select strPreInvoiceNo from commercial_invoice_header)
								order by intInvoiceId DESC
								";
                   $resultInvoice=$db->RunQuery($sqlInvoice);
						 while($row=mysql_fetch_array( $resultInvoice)) { ?>
		      <option value="<?php echo $row['strInvoiceNo'];?>"><?php echo $row['strBuyerPONo'];?></option>
		      <?php }?>
		      </select></td>
		    <td width="147" ><img src="../../../images/search.png" width="80" height="24" alt="search" onclick="loadPreDetData();" /></td>
		    <td width="147" ><select name="cmbISDnoz"  class="txtbox" id="cmbISDnoz" style="width:160px; visibility:hidden">
		      <option value=""></option>
		      </select></td>
		    <td width="147" ><input name="txtInvoiceDetail" type="text" class="txtbox" id="txtInvoiceDetail" style="width:158px;visibility:hidden;" maxlength="10" disabled="disabled" /></td>
		    <td width="148" ><img src="../../../images/addsmall.png" onclick="viewPOPUPDetail();" class="mouseover" style="visibility:hidden"/></td>
			</tr>
		<tr>
		<td colspan="6" class="bcgl1">
        <div style="overflow: scroll; height: 250px; width:910px;" id="selectitem"><table width="1100" cellspacing="1" cellpadding="0" class="bcgl1" id="tblDescription">
          <tbody id="tblDescriptionOfGood">
          <tr>
          	<td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
            <td width="2%"bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
            <td width="5%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Style</td>
            <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">PO</td>
            <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">ISD</td>
            <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">PL</td>
			<td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
            <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
            <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Fabric</td>
            <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Entry No </td>
            <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">Hs </td>      
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Price</td>                
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Unit </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Value</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Gross</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Net</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Net Net</td>
           	<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">CTNS</td>			
		</tr></tbody></table>
        </div>        
        </td>		
		</tr>
		<tr>
		  <td colspan="6" ><table width="103%" border="0" cellspacing="0" cellpadding="0">
            <tr bgcolor="#D6E7F5">
              <td width="27%" height="29" >&nbsp;</td>
              <td width="12%" ><img src="../../../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick=" newDettail();setGenDesc();"/></td>
              <td width="11%" ><img src="../../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="del_final_inv();" /></td>
              <td width="14%" ><a href="../../../main.php"><img src="../../../images/close.png" width="97" height="24" border="0" class="mouseover" /></a></td>
              <td width="24%" >&nbsp;</td>
            </tr>
          </table></td>
          </tr>
		<tr>
		  <td colspan="6" ><table width="100%" border="0" cellpadding="3" cellspacing="0" class="normalfnt bcgl1">
		    <tr>
		      <td>Style No</td>
		      <td><input name="txtStyle" tabindex="1" type="text"  maxlength="30"class="txtbox" id="txtStyle"style="width:158px" /></td>
		      <td>PO #</td>
		      <td><input name="txtBuyerPO" type="text" tabindex="2" class="txtbox" id="txtBuyerPO"  style="width:158px;" maxlength="25" /></td>
		      <td>ISD # / DO</td>
		      <td><input name="txtISDNo" type="text" tabindex="3" class="txtbox" id="txtISDNo"  style="width:158px;" maxlength="25"  /></td>
		      </tr>
		    <tr>
		      <td>SD</td>
		      <td><input name="txtSD" tabindex="4" type="text"  maxlength="100"class="txtbox" id="txtSD"style="width:158px" /></td>
		      <td>HS Code</td>
		      <td><select  id="txtHS" class="txtbox" name="txtHS" style="width:158px" tabindex="5" >
		        <option value=""></option>
		        <?php 
							$sqlcategory="SELECT strCommodityCode FROM  excommoditycodes GROUP BY strCommodityCode";
							$resultcategory=$db->RunQuery($sqlcategory);							
							while($rowcategory=mysql_fetch_array($resultcategory)) 
							{
							echo "<option value=".$rowcategory['strCommodityCode'].">".$rowcategory['strCommodityCode']."</option>";
															
							}  
						         
                  	?>
		        </select></td>
		      <td>CONSTN. Type</td>
		      <td>	<input name="txtConstType"  class="txtbox" id="txtConstType" tabindex="12" style="width:100px;" maxlength="15" onblur="getItemVal();"/></td>
		      </tr>
		    <tr>
		      <td>Gen. Desc.</td>
		      <td><input name="txtareaDisc" type="text"  maxlength="200"class="txtbox" id="txtareaDisc"style="width:158px" tabindex="7"/></td>
		      <td> Spec. Desc.</td>
		      <td><input name="txtareaSpecDisc" type="text"  maxlength="200"class="txtbox" id="txtareaSpecDisc"style="width:158px" tabindex="8"/></td>
		      <td>Fabric Desc.</td>
		      <td><input name="txtFabricDesc" type="text"  maxlength="200"class="txtbox" id="txtFabricDesc"style="width:158px" tabindex="9" /></td>
		      </tr>		    
		      <td width="12%">Price</td>
		      <td width="20%"><input name="txtUnitPrice" type="text" class="txtbox" id="txtUnitPrice" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15"tabindex="10" onblur="getItemVal();"/>
		        <select name="txtQtyUnit" type="text" id="txtQtyUnit" class="txtbox" style="width:50px" tabindex="11">
		          <option value=""></option>
		          <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
		          </select></td>
		      <td width="12%">Qty </td>
		      <td width="20%"><input name="txtQty"  class="txtbox" id="txtQty" tabindex="12" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15" onblur="getItemVal();"/>
		        <select name="txtUnit" type="text" id="txtUnit" class="txtbox" style="width:50px" tabindex="13">
		        <option value=""></option>
		        <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
		        </select></td>
		      <td width="12%">Value</td>
		      <td width="20%"><input name="txtValue"  class="txtbox" id="txtValue" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onfocus="getItemVal();" style="width:100px;" maxlength="30" tabindex="14"/></td>
		      </tr>
              <tr>
                <td>Packing List</td>
                <td><select name="txtPLno" type="text" id="txtPLno" class="txtbox" style="width:100px" tabindex="15" onchange="getMass()">
                  <option value=""></option>
                  <?php 
							$strpl="select concat(strPLNo,'/',strStyle,'/',strProductCode,'/',strISDno ,' ',strDO)as plno, strPLNo from shipmentplheader order by strPLNo desc";
							$resultpl=$db->RunQuery($strpl);							
							while($rowpl=mysql_fetch_array($resultpl)) 
							{
								echo "<option value=".$rowpl['strPLNo'].">".$rowpl['plno']."</option>";															
							}  
						         
                  ?>
                </select></td>
                <td> No of CTNs</td>
                <td><input name="txtCtns" type="text" class="txtbox"  id="txtCtns" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15" tabindex="16"/></td>
                <td>DC</td>
                <td><input name="txtDC" type="text" maxlength="30"class="txtbox" id="txtDC"style="width:158px" tabindex="17"/></td>
              </tr>
              <tr>
                <td>Gross Mass </td>
                <td valign="top"><input name="txtGross" type="text" class="txtbox"  id="txtGross" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15" tabindex="18"/></td>
                <td>Net Mass</td>
                <td valign="top"><input name="txtNet" type="text" class="txtbox" id="txtNet" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;"maxlength="15" tabindex="19"/></td>
                <td> Net Net Mas</td>
                <td><input name="txtNetNet" type="text" class="txtbox" id="txtNetNet" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;"maxlength="15" tabindex="20"/></td>
              </tr>
              <tr>
                <td height="25">Max Retail Price</td>
                <td ><input name="txtMRP" type="text" class="txtbox" id="txtMRP" style="width:100px;" maxlength="30" tabindex="10"/></td>
                <td>CBM</td>
                <td valign="top"><input name="txtCBM" type="text" class="txtbox" id="txtCBM" style="width:100px;" maxlength="10" tabindex="10" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
                <td >Entry No </td>
                <td ><input name="txtEntryNo" type="text" class="txtbox" id="txtEntryNo" style="width:100px;" maxlength="50" tabindex="10"/></td>
              </tr>
              <tr>
                <td height="25"><input name="txtColor" tabindex="23" type="text" class="txtbox" id="txtColor" size="15" maxlength="30" value="" style="visibility:hidden"/></td>
                <td >&nbsp;</td>
                <td>&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td bgcolor="#D6E7F5">&nbsp;</td>
                <td bgcolor="#D6E7F5"><img src="../../../images/addsmall.png" alt="add" width="95" height="24" class="mouseover"  onclick="addToGrid();" /></td>
              </tr>
              </table></td>
          </tr>
		</table>
		</div>		</td>
        </tr>
    </table></div>
		<div id="tabs-1"  ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1" >
      <tr>
        <td width="95%" height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="left" class="head1">Commercial Invoice Data</div></td>
        <td width="5%" bgcolor="#9BBFDD" class="normalfnth2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><div id="divLotInterface" style=" overflow:scroll; width:100%; " >
          <table width="100%" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td><form id="commercial_inv" >
                <table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
                  <tr>
                  <td height="25">Brand</td>
                  <td colspan="2"><select name="txtBrand" type="text"  id="txtBrand" class="txtbox" style="width:122px" >
                    <option value="LEVI'S">LEVI'S</option>
                    <option value="RED - TAB">Red - Tab</option>
                    <option value="RED - LOOP">Red - Loop</option>
                    <option value="SIGNATURE">Signature</option>
                    <option value="DENIZEN">DENIZEN</option>
                  </select></td>
                  <td>Quality</td>
                  <td><select name="cmbQuality" type="text"  id="cmbQuality" class="txtbox" style="width:122px" >
                      <option value="1">1st Quality</option>
                      <option value="2">2nd Quality</option>
                      <option value="3">3rd Quality</option>
                      
                  </select></td>
                  <td>Finish Std </td>
                  <td><input name="txtFinishStd" type="text" class="txtbox" id="txtFinishStd" style="width:120px"  maxlength="50" /></td>
                  <td>Pack Std </td>
                  <td><input name="txtrPackStd" type="text" class="txtbox" id="txtrPackStd" style="width:120px"  maxlength="50" value="NORMAL PACK"/></td>
                </tr>
                <tr>
                  <td height="25">Gender</td>
                  <td colspan="2"><select name="cmbGender" type="text" id="cmbGender" class="txtbox" style="width:122px" >
                    <option value=""></option>
                    <option value="MENS">MENS</option>
                    <option value="WOMENS">WOMENS</option>
                    <option value="LADIES">LADIES</option>
                    <option value="BOYS">BOYS</option>
                    <option value="GIRLS">GIRLS</option>
                    <option value="INFANTS">INFANTS</option>
                    <option value="MENS / LADIES">MENS / LADIES</option>
                    <option value="LADIES / MENS">LADIES / MENS</option>
                    <option value="MENS / WOMENS">MENS / WOMENS</option>
                    <option value="WOMENS / MENS">WOMENS / MENS</option>
                    <option value="TODDLERS">TODDLERS</option>
                    <option value="BABIES">BABIES</option>
                  </select></td>
                  <td>Gmnt Type </td>
                  <td><input name="txtGmntType" type="text"  class="txtbox" id="txtGmntType" style="width:120px"  maxlength="50" value="WOVEN"/></td>
                  <td>BTM / TOPS </td>
                  <td><select name="txtBTM" type="text" id="txtBTM" class="txtbox" style="width:122px" >
                    <option value=""></option>
                    <option value="TOPS">TOPS</option>
                    <option value="BTMS">BTMS</option>
                    </select></td>
                  <td>Quota Cat</td>
                  <td><input name="txtCat" type="text"  class="txtbox" id="txtCat" style="width:120px"  maxlength="50" /></td>
                </tr>
                <tr>
                  <td height="25">CTN Type </td>
                  <td colspan="2"><input name="txtCTNType" type="text"  class="txtbox" id="txtCTNType" style="width:120px"  maxlength="50" value="EURO / STANDARD"/></td>
                  <td>CTN NOs </td>
                  <td><input name="txtCTNNos" type="text"  class="txtbox" id="txtCTNNos" style="width:120px"  maxlength="200" /></td>
                  <td>CTN Size </td>
                  <td><input name="txtCTNSize" type="text"  class="txtbox" id="txtCTNSize" style="width:120px"  maxlength="50" /></td>
                  <td>Shipment Ref</td>
                  <td><input name="txtShipmentRef" type="text"  class="txtbox" id="txtShipmentRef"  style="width:120px"  maxlength="100" /></td>
                </tr>
                <tr>
                  <td height="25">Freight/Unit</td>
                  <td colspan="2"><input name="txtFreight" type="text"  class="txtbox" id="txtFreight" style="width:120px"  maxlength="50" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                  <td>Insurance/Unit</td>
                  <td><input name="txtInsurance" type="text"  class="txtbox" id="txtInsurance" style="width:120px"  maxlength="50" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                  <td>Dest Ch./Unit</td>
                  <td><input name="txtDestCh" type="text"  class="txtbox" id="txtDestCh" style="width:120px"  maxlength="50" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                  <td>Other/Unit</td>
                  <td><input name="txtOther" type="text" class="txtbox" id="txtOther" style="width:120px"  maxlength="50" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                </tr>
                <tr>
                  <td height="25">Freight/Shipment</td>
                  <td colspan="2"><input name="txtTotFreight" type="text"  class="txtbox" id="txtTotFreight" style="width:120px"  maxlength="15" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                  <td>Insurance/Shipment</td>
                  <td><input name="txtTotInsurance" type="text"  class="txtbox" id="txtTotInsurance" style="width:120px"  maxlength="15" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                  <td nowrap="nowrap">Dest Ch./Shipment</td>
                  <td><input name="txtTotDest" type="text"  class="txtbox" id="txtTotDest" style="width:120px"  maxlength="15" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                  <td nowrap="nowrap">Other/Shipment</td>
                  <td><input name="txtTotOther" type="text"  class="txtbox" id="txtTotOther" style="width:120px"  maxlength="15" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                </tr>
                <tr>
                  <td height="25">B/L # </td>
                  <td colspan="2"><input name="txtBL" type="text" class="txtbox" id="txtBL" style="width:120px"  maxlength="50" /></td>
                  <td>VAT # </td>
                  <td><input name="txtVat" type="text"  class="txtbox" id="txtVat" style="width:120px"  maxlength="50" /></td>
                  <td>Container</td>
                  <td><input name="txtContainer" type="text"  class="txtbox" id="txtContainer" style="width:120px"  maxlength="50" /></td>
                  <td>Seal #</td>
                  <td><input name="txtSealNo" type="text"  class="txtbox" id="txtSealNo" style="width:120px"  maxlength="50" /></td>
                </tr>
				<tr>
				  <td height="25">HAWB</td>
				  <td colspan="2"><input name="txtHAWB" type="text" class="txtbox" id="txtHAWB" style="width:120px"  maxlength="50" /></td>
				  <td>MAWB</td>
				  <td><input name="txtMAWB" type="text" class="txtbox" id="txtMAWB" style="width:120px"  maxlength="50" /></td>
				  <td>Collect/Pre</td>
				  <td><select name="txtFreightPC" type="text"  id="txtFreightPC" class="txtbox" style="width:122px" >
                    <option value=" "></option>
                    <option value="COLLECT">Collect</option>
                    <option value="PREPAID">Pre-Paid</option>
                  </select></td>
				  <td>P.S Number</td>
				  <td><input name="txtPSnumber" type="text"  class="txtbox" id="txtPSnumber" style="width:120px"  maxlength="50" /></td>
				  </tr>
				
				<tr>
				  <td height="25">Discount</td>
				  <td width="10%"><input name="txtDiscount" type="text" class="txtbox" id="txtDiscount" style="width:50px"  maxlength="10" onkeypress="return CheckforValidDecimal(this.value, 4,event);" /></td>
				  <td width="5%"><select name="cboPrecentageValue" type="text"  id="cboPrecentageValue" class="txtbox" style="width:50px" >
				    <option value="value">Value</option>
                    <option value="precentage">%</option>
				    </select></td>
				  <td>Container Type </td>
				  <td><select name="cboCtnrType" type="text"  id="cboCtnrType" class="txtbox" style="width:122px" >
				  <option value=""></option>
				  <?php
				  	$sql_con="select intConId, 
							strConType, 
							StrConDiscription
							from 
							container_type 
							order by strConType";
							
							$result_con=$db->RunQuery($sql_con);							
							while($row_con=mysql_fetch_array($result_con)) 
							{
							echo "<option value=".$row_con['strConType'].">".$row_con['strConType']."</option>";
															
							}  
				  ?>
                  </select></td>
				  <td>Web Tool ID </td>
				  <td><input name="txtWebToolId" type="text" class="txtbox" id="txtWebToolId" style="width:120px"  maxlength="50" /></td>
				  <td>Sample Quote </td>
				  <td><input name="txtSampleCode" type="text" class="txtbox" id="txtSampleCode" style="width:120px"  maxlength="500" /></td>
				  </tr>
                  <tr>
                    <td height="25">FCR #</td>
                    <td colspan="2"><input name="txtFCR" type="text" class="txtbox" id="txtFCR" style="width:120px"  maxlength="50" /></td>
                    <td>Export No</td>
                    <td><input name="txtExportNo" type="text" class="txtbox" id="txtExportNo" style="width:120px"  maxlength="50" /></td>
                    <td>Export File No</td>
                    <td><input name="txtExFile" type="text" class="txtbox" id="txtExFile" style="width:120px"  maxlength="50" /></td>
                    <td>SGS IO #</td>
                    <td><input name="txtSGSIONO" type="text" class="txtbox" id="txtSGSIONO" style="width:120px"  maxlength="50" /></td>
                  </tr>
                  <tr>
                    <td height="25">Doc Due Date</td>
                    <td colspan="2"><input name="txtDocDue" tabindex="10" type="text" class="txtbox" id="txtDocDue" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" readonly="readonly" disabled="disabled"/><input name="reset5" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                    <td>Doc Sub Date</td>
                    <td><input name="txtDocSub" tabindex="10" type="text" class="txtbox" id="txtDocSub" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" /><input name="reset5" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                    <td>Pay Due Date</td>
                    <td><input name="txtPayDue" tabindex="10" type="text" class="txtbox" disabled="disabled" id="txtPayDue" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" readonly="readonly"/><input name="reset5" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                    <td>Pay Sub Date</td>
                    <td><input name="txtPaySub" tabindex="10" type="text" class="txtbox" id="txtPaySub" style="width:70px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset5" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                  </tr>
                  <tr>
                    <td width="11%"></td>
                    <td colspan="2"></td>
                    <td width="13%"></td>
                    <td width="13%"></td>
                    <td width="12%"></td>
                    <td width="13%"></td>
                    <td width="10%"></td>
                    <td width="13%"></td>
                  </tr>
            </table>
              </form></td>
            </tr>
          </table>
        </div>
          </td>
      </tr>
	  
	  <tr>
	  <td colspan="2">
	  <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="126" height="29">&nbsp;</td>
        <td width="167">&nbsp;</td>
        <td width="117"><img src="../../../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="clearform(); "/></td>
        <td width="107"><img src="../../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="save_to_db_ci();" /></td>
        <td width="123"><img src="../../../images/report.png" alt="butReportList" name="butReportList" width="108" height="24" class="mouseover" id="butReport" onclick="printthis()"/></td>
        <td width="126">&nbsp;</td>
		<td width="132">&nbsp;</td>
      </tr>
    </table>
	  </td>
	  </tr>
	  
	  
    </table>
			
		
		</div>
      </div>
		</td>
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
<div style="left:486px; top:428px; z-index:10; position:absolute; width: 261px; visibility:hidden;" id="pop_print" >
<table width="260"  border="0" cellpadding="0" cellspacing="0" class="bcglm normalfnt" bgcolor="#FFFFFF" >
          <tr bgcolor="#498CC2">
		  	<td width="51" height="21" class="normalfnt"></td>
            <td width="185" height="21" class="normalfnt">&nbsp;</td>
            <td width="22"><img src="../../../images/cross.png" alt="cl" width="17" height="17" class="mouseover" onclick="hide_pop()"/></td>
          </tr>
          
          <tr>
            <td height="25" class="normalfnt" style="text-align:center"><input type="radio" name="rad_print" id="rad_euro" onclick="print_buyer_wise(1);"/></td>
            <td>LEVI'S EURO </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="25" class="normalfnt" style="text-align:center">
              <input type="radio" name="rad_print" id="rad_nw"  onclick="print_buyer_wise(2);"/>            </td>
            <td>LEVI'S NEW YORK </td>
            <td>&nbsp;</td>
          </tr>
  </table>
		

</div>
</body>
<script type="text/javascript">
<?php if($invno!=""){?>
$('#cboFinalInvoice').val('<?php echo $invno;?>');
getInvoceData('final');freezFinalInvoice();
<?php }?>
</script>
</html>