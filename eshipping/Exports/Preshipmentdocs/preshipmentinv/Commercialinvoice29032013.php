<?php
	session_start();
	include("../../../Connector.php");
	$backwardseperator = "../../../";
	
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

.bcgcolorred
{
	background-color:#FF9999;
}
</style>
<link type="text/css" href="../../../css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../../../js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="../../../js/jquery-ui-1.7.2.custom.min.js"></script>
        
        
		<script type="text/javascript" src="../../../js/jquery-1.4.4.min.js"></script>
		<link href="../../../css/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../../../js/jquery-ui-1.8.9.custom.min.js"></script>
		<script src="jquery.fixedheader.js" type="text/javascript"></script>
		<script src="pl_plugin_search.js" type="text/javascript"></script>


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
    <td><?php include $backwardseperator.'Header.php'; 
 ?></td>
</tr>
  <tr>
    <td height="59" colspan="2" bgcolor="#316895" class="TitleN2white">Pre-Shipment Invoice</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
	<tr class="bcgl1txt1NB">
	  <td>
      <div  id="tabs" >
			<ul><li><a href="#tabs-2" onclick="clearall();">Invoice</a></li>
                <li><a href="#tabs-1" onclick="getInvoiceDetail();">Description Of Goods</a></li>
				<li style="visibility:hidden"><a href="#tabs-3" onclick="checkInvoiceNo();retrv_po_wise_ci();">Details</a></li>
			</ul>
			<div id="tabs-2">
			  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="86%" bgcolor="#9BBFDD" class="head1">Header Information </td>
        <td width="14%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons"  style="width:100%;">
		  <table width="100%"  id="tblGen">
		    <tr>
		      <td><table width="100%" height="26" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              
              <tr>
		         <td width="2%">&nbsp;</td>
		         <td width="12%" height="26">Search Invoice </td>
		         <td width="21%"><input name="txtInvoiceNo2"  type="text" class="txtbox" id="txtInvoiceNo2"  style="width:170px" tabindex="1" maxlength="30" onkeyup="changePreInvCombo(this,event);" /></td>
		         <td width="12%">Search With PO</td>
		         <td width="21%"><input name="txtInvoicePoNo" tabindex="2"  type="text" class="txtbox" id="txtInvoicePoNo"  style="width:160px" maxlength="30" onkeyup="changePrePoInvCombo(this,event);" /></td>
		         <td width="12%">SDP</td>
		         <td width="20%"><select name="cboComInvFormat" class="txtbox" tabindex="4"  id="cboComInvFormat"   style="width:160px;" onchange="loadFormat();">
		           <option value=""></option>
		           <?php 
                   $strInvFormat="select intCommercialInvId,strCommercialInv 
									from commercialinvformat 
									order by strCommercialInv";
                   $resultInvFormat=$db->RunQuery($strInvFormat);
						 while($row_InvFormat=mysql_fetch_array( $resultInvFormat)) 
						 echo "<option value=".$row_InvFormat['intCommercialInvId'].">".$row_InvFormat['strCommercialInv']."</option>";                 
                   ?>
                  
		           </select></td>
		         </tr>
		       <tr>
		         <td width="2%">&nbsp;</td>
		         <td width="12%">Select Invoice </td>
		         <td width="21%"><select name="cboInvoiceNo" tabindex="3" class="txtbox" id="cboInvoiceNo" style="width:170px" onchange="getInvoceData('pre')" >
		           <option value=""></option>
		           <?php 
                   $sqlInvoice="SELECT strInvoiceNo FROM invoiceheader where intCancelInv='0' order by intInvoiceId desc";
                   $resultInvoice=$db->RunQuery($sqlInvoice);
						 while($row=mysql_fetch_array( $resultInvoice)) { ?>
		           <option value="<?php echo $row['strInvoiceNo'];?>"><?php echo $row['strInvoiceNo'];?></option>
		           <?php }?>
		           </select></td>
		         <td width="12%">Invoice Date </td>
		         <td width="21%"><input name="txtInvoiceDate" type="text" class="txtbox" id="txtInvoiceDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
		         <td width="12%">Consignee</td>
		         <td width="20%"><select name="cboConsignee" tabindex="6"  class="txtbox"  id="cboConsignee" style="width:160px">
		            <option value=""></option>
		            <?php 
                   $sqlBuyer="SELECT strBuyerID,strName,strBuyerCode	FROM buyers ORDER BY strBuyerID  ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strName']." ---> ".$row['strBuyerCode']."</option>";                 
                   ?>
		            </select></td>
		         </tr>
		        </table></td>
		      </tr>
		    <tr>
		      <td height="65"><table width="100%" height="26" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		        <tr>
		          <td height="25">&nbsp;</td>
		          <td>Final Invoice No </td>
		          <td><input name="txtInvoiceNo" tabindex="5" type="text" class="txtbox" id="txtInvoiceNo"  style="width:170px" maxlength="30" disabled="disabled"/></td>
		          <td>Shipper</td>
		          <td><select name="cboShipper" tabindex="5"   class="txtbox" id="cboShipper"style="width:160px">
		            <option value=""></option>
		            <?php
                   $sqlConsignee="SELECT 	strCustomerID, 	strName, strMLocation FROM customers ORDER BY strName LIMIT 2 ";
                   $resultConsignee=$db->RunQuery( $sqlConsignee);
						 while($row=mysql_fetch_array( $resultConsignee)) 
						 echo "<option value=".$row['strCustomerID'].">".$row['strName']." - " .$row['strMLocation']."</option>";                 
                   ?>
		            </select></td>
		          <td>Manufacturer</td>
		          <td><select name="cboShipper2"  tabindex="9" class="txtbox" id="cboShipper2" style="width:160px">
		            <option value=""></option>
		            <?php
                   $sqlConsignee="SELECT strCustomerID, strName,strMLocation FROM customers WHERE strCustomerID <>10  ORDER BY strName ";
                   $resultConsignee=$db->RunQuery( $sqlConsignee);
						 while($row=mysql_fetch_array( $resultConsignee)) 
						 echo "<option value=".$row['strCustomerID'].">".$row['strMLocation']."</option>";                 
                   ?>
		            </select></td>
		          </tr>
		        <tr>
		          <td height="25">&nbsp;</td>
		          <td>Notify Part One </td>
		          <td><select name="cboNotoify1"  class="txtbox" tabindex="7" id="cboNotoify1" style="width:170px">
		            <option value=""></option>
		            <?php 
                   $sqlBuyer="SELECT strBuyerID,strBuyerCode,strName	FROM buyers ORDER BY strName ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strBuyerCode']." ---> ".$row['strName']."</option>";                 
                   ?>
		            </select></td>
		          <td>Notify Part Two </td>
		          <td><select name="cboNotoify2"  tabindex="8" class="txtbox" id="cboNotoify2" style="width:160px">
		            <option value=""></option>
		            <?php 
                   $sqlBuyer="SELECT strBuyerID,strBuyerCode,strName FROM buyers ORDER BY strName ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID']." > ".$row['strBuyerCode']."--->".$row['strName']."</option>";                 
                   ?>
		            </select></td>
		          <td>Sold/Deliver to</td>
		          <td><select name="cboSoldTo"  class="txtbox" tabindex="12" id="cboSoldTo"style="width:160px">
		            <option value=""></option>
		            <?php 
                   $sqlBuyer="SELECT strBuyerID,strName,strBuyerCode	FROM buyers ORDER BY strName  ";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBuyerID'].">".$row['strName']." ---> ".$row['strBuyerCode']."</option>";                 
                   ?>
		            </select></td>
		          </tr>
		        <tr>
		          <td height="25">&nbsp;</td>
		          <td>LC # &amp; Date </td>
		          <td><input name="txtLC" type="text" tabindex="10" class="txtbox" id="txtLC" style="width:100px" maxlength="30" />
		            <input name="txtLcDate" type="text" class="txtbox" id="txtLcDate" style="width:60px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;width:2px;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
		          <td>LC Issuing Bank </td>
		          <td><select name="cboBank"  tabindex="11" class="txtbox" id="cboBank" style="width:160px">
		            <option value=""></option>
		            <?php 
                   $sqlBuyer="SELECT strBankCode, 	strName FROM  bank ORDER BY strName";
                   $resultBuyer=$db->RunQuery($sqlBuyer);
						 while($row=mysql_fetch_array( $resultBuyer)) 
						 echo "<option value=".$row['strBankCode'].">".$row['strName']."</option>";                 
                   ?>
		            </select></td>
		          <td>Incoterms</td>
		          <td><select name="txtDeliveryTerm" tabindex="15" style="width:160px" id="txtDeliveryTerm" class="txtbox">
		            <option value=""></option>
		            <?php
$sql_delivery="select intDeliveryID,strDeliveryCode from deliveryterms where intStatus=1 order by strDeliveryCode";
$result_delivery=$db->RunQuery($sql_delivery);
	
while($row_delivery=mysql_fetch_array($result_delivery))
{
	echo "<option value=\"".$row_delivery["strDeliveryCode"]."\">".$row_delivery["strDeliveryCode"]."</option>\n";
}
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
		          <td><select name="txtLoading" tabindex="13"  class="txtbox" id="txtLoading"style="width:170px">
		            <option value=""></option>
		            <option value="COLOMBO">COLOMBO</option>
		            <option value="KATUNAYAKE">KATUNAYAKE</option>
		            </select></td>
		          <td>Final Destination </td>
		          <td>
		            <select name="cboDestination" tabindex="14"  class="txtbox" id="cboDestination" style="width:160px">
		              <option value=""></option>
		              <?php 
                   $sqlCity="SELECT strPortOfLoading,strCityCode, strCity FROM city  order by strCity";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['strCityCode'].">".$row['strCity']." --> ".$row['strPortOfLoading']."</option>";                 
                   ?>
		              </select></td>
		          <td>CTN Opr Code </td>
		          <td><input name="txtCTNOprCode"  class="txtbox" id="txtCTNOprCode" style="width:158px" /></td>
		          </tr>
		        <tr>
		          <td width="2%">&nbsp;</td>
		          <td width="12%" height="25">Carrier</td>
		          <td width="21%"><input name="txtCarrier" tabindex="16"  type="text" class="txtbox" id="txtCarrier"  style="width:167px" maxlength="50" /></td>
		          <td width="12%">Voyage No</td>
		          <td width="21%"><input name="txtVoyageeNo" tabindex="17" type="text" class="txtbox" id="txtVoyageeNo"  style="width:160px" /></td>
		          <td width="12%">Saling or about </td>
		          <td width="20%"><input name="txtSailing"  type="text" class="txtbox" id="txtSailing" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset3" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
		          </tr>
		        </table></td>
		      </tr>
		    <tr>
		      <td><table width="100%" height="175" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		        <tr>
		          <td height="25">&nbsp;</td>
		           <td>VSL Opr Code </td>
		          <td><input name="txtVSLOprCode"  class="txtbox" id="txtVSLOprCode" style="width:168px"/></td>
		          <td> Vessel Name</td>
		          <td><input name="txtVesselName" tabindex="15" type="text" class="txtbox" id="txtVesselName"  style="width:158px" maxlength="10" /></td>
		          <td>Port Of Discharging</td>
		          <td><input name="txtPortDischarge"  class="txtbox" id="txtPortDischarge" style="width:160px" />
                    </td>
		          </tr>
                  
                   <tr>
		          <td height="25">&nbsp;</td>
		           <td>SLPA No </td>
		          <td><input name="txtSLPANo" type="text" class="txtbox" id="txtSLPANo" style="width:167px" /></td>
		          <td>Vessel Date</td>
		          <td><input name="txtVesselDate" tabindex="2" type="text" class="txtbox" id="txtVesselDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" value="<?php echo date('d/m/Y');?>" onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
		          <td>E-No </td>
		          <td><input type="text" tabindex="19" name="E_No" id="E_No" style="width:158px" class="txtbox"/>
                    </td>
		          </tr>
 
 
  <tr>
		          <td height="25">&nbsp;</td>
		          <td>Currency</td>
		          <td><select name="cboCurrency"  onchange="setExchangeRates(this.value);setRates();"  class="txtbox" id="cboCurrency" tabindex="18" style="width:170px"/>
                 
		           <option value=""></option>
		            <?php 
                   $sqlCurrency="SELECT strCurrency, dblRate FROM currencytypes ORDER BY strCurrency ";
                   $resultCurrency=$db->RunQuery($sqlCurrency);
				   
						 while($row=mysql_fetch_array( $resultCurrency)) 
						if($row['strCurrency']=='USD')
						{
							 echo "<option  value=".$row['dblRate']." selected='selected'>".$row['strCurrency']."</option>";  
						}
						else
						{
							echo "<option  value=".$row['dblRate'].">".$row['strCurrency']."</option>";
						}
                   ?>
                  
		            </select></td>
		          <td>Exchange Rate </td>
		          <td><input type="text" name="txtExchangeRate" id="txtExchangeRate" style="width:158px" tabindex="19" class="txtbox"/></td>
		          <td >Freight</td>
		          <td><select name="cboCollect" style="width:160px" id="cboCollect" tabindex="20" class="txtbox">
		            <option value=""></option>
		          	<option value="COLLECT">COLLECT</option>
                    <option value="PREPAID">PREPAID</option>
		            </select>
                    </td>
		          </tr>
 
 
 
 
 
                  
                  
		        <tr>
		          <td height="25">&nbsp;</td>
		          <td>Marchant Name</td>
		          <td><select name="txtDeliveryTerm2" tabindex="21" style="width:170px" id="txtDeliveryTerm2" class="txtbox">
                  
		            <?php
$sql_delivery="select strName,intWharfClerkID from wharfclerks order by strName";
$result_delivery=$db->RunQuery($sql_delivery);
	echo "<option value=\"".""."\">".""."</option>\n";
while($row_delivery=mysql_fetch_array($result_delivery))
{
	echo "<option value=\"".$row_delivery["intWharfClerkID"]."\">".$row_delivery["strName"]."</option>\n";
}
?>
		            
                    </select></td>
		          <td>Shell Button</td>
		          <td><input type="checkbox" tabindex="22" id="chkShellBox" name="chkShellBox" style="cursor:pointer"/></td>
		          <td>Packing Method</td>
		          <td><select name="cboPackingMethod"  class="txtbox" tabindex="21" id="cboPackingMethod" style="width:160px">
		            <option value=""></option>
		            <option value="1">Cartoon</option>
		            <option value="2">GOH</option>
		            </select></td>
		          </tr>
		        <tr>
		          <td height="25">&nbsp;</td>
		          <td>Transport Mode </td>
		          <td><select name="cboTransMode" tabindex="23" class="txtbox" id="cboTransMode" style="width:170px">
		            <option value=""></option>
		            <option value="Sea">Sea Freight</option>
		            <option value="Air">Air Freight</option>
		            </select></td>
		          <td>Pre-Invoice Document No</td>
		          <td><input type="text" name="txtPreDocNo" id="txtPreDocNo" style="width:158px" tabindex="24" class="txtbox"/></td>
		          <td>Terms</td>
		          <td><select name="cboInvoiceType"   class="txtbox" id="cboInvoiceType"style="width:160px">
		             <option value=""></option>
		            <?php 
                   $sqlCity="SELECT
								paymentterm.intPaymentTermID,
								paymentterm.strPaymentTerm
								FROM
								paymentterm ";
                   $resultCity=$db->RunQuery($sqlCity);
						 while($row=mysql_fetch_array( $resultCity)) 
						 echo "<option value=".$row['intPaymentTermID'].">".$row['strPaymentTerm']."</option>";                 
                   ?>
		            </select></td>
		          </tr>
		        <tr>
		          <td height="25">&nbsp;</td>
		          <td>Marks And Nos </td>
		          <td width="21%" rowspan="3" valign="top"><textarea name="txtMarksofPKGS" tabindex="25"  rows="4" id="txtMarksofPKGS" style="width:170px;"></textarea></td>
		          <td>General Desc</td>
		          <td width="21%" rowspan="3"><textarea name="txtDiscription"  rows="4" tabindex="26" id="txtDiscription" style="width:158px;"></textarea></td>
		          <td>SN(BL) No </td>
		          <td><input name="txtSNBNNO" type="text" class="txtbox" id="txtSNBNNO" style="width:158px" /></td>
		          </tr>
		        <tr>
		          <td height="25">&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>&nbsp;</td>
		          <td>No Of Cartons</td>
		          <td><input name="txtNoCartoons" type="text" class="txtbox" id="txtNoCartoons" style="width:158px" /></td>
		          </tr>
		        <tr>
		          <td width="2%" height="25">&nbsp;</td>
		          <td width="12%">&nbsp;</td>
		          <td width="12%"><img src="../../../images/export_copy.gif" alt="copy" width="32" height="31" class="mouseover" onclick="copyMarksNos();"/></td>
		          <td width="12%"><img src="../../../images/export_copy.gif" alt="copy" width="32" onclick="copyGeneralDesc();" class="mouseover" height="31" /></td>
		          <td width="20%">&nbsp;</td>
		          </tr>
		        </table></td>
		      </tr>
		    <tr>
		      <td height="15" style="display:none">&nbsp;</td>
		      </tr>
		    </table>
		</div>		</td>
        </tr>
		 <tr bgcolor="#D6E7F5">
		
		<td><table width="900" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="28" height="29">&nbsp;</td>
        <td width="25"></td>
        <td width="99"><img src="../../../images/new.png" alt="new"  name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="pageReload(); "/></td>
        <td width="106"><img src="../../../images/cancel.jpg" width="104" height="24" class="mouseover" onclick ="rowupdater();" /></td>
        <td width="86"><img src="../../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="saveData();" /></td>
        <td width="108"><img src="../../../images/report.png" alt="butReportList" name="butReportList" width="108" height="24" class="mouseover" id="butReport" onclick="printthis();"/></td>
        <td width="99"><a href="../../../main.php"><img src="../../../images/close.png" width="97" height="24" border="0" class="mouseover"  /></a></td>
       
        
       <td width="39"><img src="../../../images/go.png"alt="go"  name="butgo" width="37" height="26" class="mouseover"  id="butgo" 	onclick="Loadshippingnote(); "/>
      </td>
       <td width="101"><img src="../../../images/print.png" alt="print" width="100" height="24" onclick="printReport();"/></td>
        
        
        
        
		<td width="41"><img src="../../../images/do_copy.png" width="32" height="31" alt="c" onclick="copy_invoice()" class="mouseover" title="Copy Invoice"/></td>
        <td width="166"><img src="../../../images/transfer.png" onclick="preToCdn();" class="mouseover" /></td>
      </tr>
    </table></td>
		</tr>
		
		
    </table></div>
			<div id="tabs-1" s><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
      
        <td width="91%" height="21" bgcolor="#9BBFDD" class="head1">Description Of Goods </td>
        <td width="9%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
      </tr>
      <tr>
        <td height="280" colspan="2" class="normalfnt">
		<div id="divcons" style="overflow:hidden;  width:100%;">
		<table width="100%"  >
		  <tr>
		    <td width="117" height="15">Invoice No </td>
		    <td width="213"><input name="txtInvoiceDetail" type="text" class="txtbox" id="txtInvoiceDetail"  size="25" maxlength="10" disabled="disabled" /></td>
		    <td width="152" ><img src="../../../images/addsmall.png" title="Add PL" style="cursor:pointer;" onclick="viewPOPUPDetail();"/></td>
		    <td width="161" >&nbsp;</td>
		    <td width="161" >&nbsp;</td>
		    <td width="164" >&nbsp;</td>
			</tr>
		<tr>
		<td height="80" colspan="6" ><div style="overflow: scroll; height: 250px; width: 900px;" id="selectitem"><table width="1200" cellspacing="1" cellpadding="0" class="bcgl1" id="tblDescription">
          <tbody id="tblDescriptionOfGood">
          <tr>
          	<td width="2%" bgcolor="#498CC2" class="normaltxtmidb2" height="25">&nbsp;</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Style </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">PO </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">PL </td>
            <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">Description</td>
            <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2" nowrap="nowrap">Fabrication</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Price </td>
            <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
            
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
             <td width="2%" bgcolor="#498CC2" class="normaltxtmidb2">Unit </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Value</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Gross </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Net </td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">HS</td>
           	<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">CTNS</td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">UOM_Qty1</td>
           	<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">UOM_Qty2</td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">UOM_Qty3</td>
			<td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">ISD#</td>
            <td width="3%" bgcolor="#498CC2" class="normaltxtmidb2">CBM</td>
            </tr>
            
            </tbody></table></div> </td>
            
		
		</tr>
		<tr>
		  <td colspan="6" ><table width="103%" border="0" cellspacing="0" cellpadding="0">
            <tr bgcolor="#D6E7F5">
              <td width="1%" height="29" >&nbsp;</td>
              <td width="40%" >&nbsp;</td>
              
              <td width="18%" ><img src="../../../images/save.png" style="visibility:hidden" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="InsertDetail();" /></td>
             
              <td width="30%" >&nbsp;</td>
            </tr>
          </table></td>
          </tr>
		<tr>
		  <td colspan="6" ><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
          
          <tr>
		      <td width="13%" height="25">Total Price</td>
		      <td width="21%"><input name="txtTotalPrice" maxlength="20" type="text" tabindex="1" class="txtbox" id="txtTotalPrice" style="width:158px" disabled="disabled" value="0" /></td>
		      <td width="13%">Total Qty</td>
		      <td width="21%"><input name="txtTotalQty" type="text" tabindex="2" class="txtbox" id="txtTotalQty" style="width:158px" disabled="disabled" value="0" maxlength="20" /></td>
		      <td width="10%">Total Amount </td>
		      <td width="22%"><input name="txtTotalAmount" type="text" class="txtbox" tabindex="3" id="txtTotalAmount" style="width:158px" maxlength="20" disabled="disabled" value="0"  /></td>
		      </tr>
          
          
          
          
          
          
          
		    <tr>
		      <td width="13%" height="25">Style No </td>
		      <td width="21%"><input name="txtStyle" maxlength="20" type="text" tabindex="1" class="txtbox" id="txtStyle" style="width:158px" onkeyup="changePreInvStyle(this,event)" /></td>
		      <td width="13%">Buyer Po No </td>
		      <td width="21%"><input name="txtBuyerPO" type="text" tabindex="2" class="txtbox" id="txtBuyerPO" style="width:158px" maxlength="20" /></td>
		      <td width="10%">ISD No / DO </td>
		      <td width="22%"><input name="txtISDNo" type="text" class="txtbox" tabindex="3" id="txtISDNo" style="width:158px" maxlength="20"  /></td>
		      </tr>
		    <tr>
		      <td height="25">HS Code</td>
		      <td><select  id="txtHS" tabindex="4" class="txtbox" name="txtHS" style="width:158px" onchange="loadFabricDescCat(this);">
		        <option value=""></option>
		        <?php 
							$sqlcategory="SELECT strCommodityCode,CONCAT(strCommodityCode,'->',strDescription,'->',
 strFabric) AS hsdesc FROM  excommoditycodes GROUP BY strCommodityCode";
							$resultcategory=$db->RunQuery($sqlcategory);							
							while($rowcategory=mysql_fetch_array($resultcategory)) 
							{
							echo "<option value=".$rowcategory['strCommodityCode'].">".$rowcategory['hsdesc']."</option>";
															
							}  
						         
                  	?>
		        </select></td>
		      <td>Description</td>
		      <td><input name="txtareaDisc" type="text" tabindex="5" class="txtbox" id="txtareaDisc" style="width:158px" maxlength="200" /></td>
		      <td> Fabrication</td>
		      <td><input name="txtFabric" type="text" tabindex="6" class="txtbox" id="txtFabric"  style="width:158px" maxlength="200"  /></td>
		      </tr>
              <tr>
              	<td>Packing List</td>
                <td><select disabled="disabled" name="txtPLno" type="text" id="txtPLno" class="txtbox" style="width:100px" tabindex="15" onchange="getMass()">
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
                
                
                <td>CBM</td>
                <td><input name="txtCBM" tabindex="7" type="text" class="txtbox" id="txtCBM" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="30" /></td>
                <td><input name="txtPL" tabindex="23" type="text" class="txtbox" id="txtPL" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="30" value="" style="visibility:hidden"/></td>
                <td><input name="txtColor" tabindex="23" type="text" class="txtbox" id="txtColor" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="30" value="" style="visibility:hidden"/></td>
              </tr>
		    <tr>
		      <td height="25">Qty</td>
		      <td nowrap="nowrap"><input name="txtQty"  class="txtbox" id="txtQty" tabindex="8" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15" onblur="getItemVal();calUOM();calMass();"/>
		        <select name="txtUnit" type="text" tabindex="9" id="txtUnit" class="txtbox" style="width:50px" >
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
		      <td>Price </td>
		      <td nowrap="nowrap"><input name="txtUnitPrice" type="text" class="txtbox" id="txtUnitPrice" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15"tabindex="10" onblur="getItemVal()"/>
		        <select name="txtQtyUnit" type="text" tabindex="11" id="txtQtyUnit" class="txtbox" style="width:50px" >
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
		      <td>Value</td>
		      <td><input name="txtValue" tabindex="12" class="txtbox" id="txtValue" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onfocus="getItemVal();" style="width:100px;" maxlength="12" /></td>
		      </tr>
		    <tr>
		      <td height="25">Gross Mass</td>
		      <td><input name="txtGross" type="text" class="txtbox" tabindex="13" id="txtGross" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15" /></td>
		      <td>Net Mass </td>
		      <td><input name="txtNet" type="text" tabindex="14" class="txtbox" id="txtNet" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;"maxlength="15" /></td>
		      <td>No of CTNs</td>
		      <td><input name="txtCtns" type="text" class="txtbox" tabindex="15" id="txtCtns" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="15" /></td>
		      </tr>		    
		    <tr>
		      <td height="25">UOM &amp; Qty 1</td>
		      <td><input name="txtUmoQty1"  class="txtbox" id="txtUmoQty1" tabindex="16" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="10" onfocus="calUOM()" />
		        <select name="cboUmoQty1" type="text" tabindex="17" id="cboUmoQty1" class="txtbox" style="width:50px" >
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
		      <td>UOM &amp; Qty 2</td>
		      <td><input name="txtUmoQty2"  class="txtbox" id="txtUmoQty2" tabindex="18" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="10" />
		        <select name="cboUmoQty2" type="text" tabindex="19" id="cboUmoQty2" class="txtbox" style="width:50px" >
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
		      <td>UOM &amp; Qty3</td>
		      <td><input name="txtUmoQty3"  class="txtbox" id="txtUmoQty3" tabindex="20" onkeypress="return CheckforValidDecimal(this.value, 4,event);" style="width:100px;" maxlength="10" onfocus="calUOM()"/>
		        <select name="cboUmoQty3" type="text" tabindex="21" id="cboUmoQty3" class="txtbox" style="width:50px" >
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
		      </tr>
              <tr>
                <td height="25">Category No </td>
                <td><select  id="cboCategory" tabindex="22" class="txtbox" name="cboCategory" style="width:160px" >
                  <option value=""></option>
                  <?php
              				$sqlunit1 = "SELECT strCatNo, strCatName, strContry FROM quotacat";
							$resultunit1=$db->RunQuery($sqlunit1);							
							while($rowunit1=mysql_fetch_array($resultunit1)) 
							{
								echo "<option value=".$rowunit1['strCatNo'].">".$rowunit1['strCatNo']."-".$rowunit1['strCatName']."-".$rowunit1['strContry']."</option>";
															
							}
				  ?>  
                </select></td>
                <td>Procedure Code</td>
                <td><input name="txtProcedureCode" type="text" class="txtbox" id="txtProcedureCode" style='text-align:right;width:158px' tabindex="23" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="8" value="3054.950" /></td>
                <td><input name="txtCM" tabindex="24" type="text" class="txtbox" id="txtCM" onkeypress="return CheckforValidDecimal(this.value, 4,event);" size="15" maxlength="30" value="0" style="visibility:hidden"/></td>
                <td><img src="../../../images/addsmall.png" alt="add" width="70" height="24" class="mouseover"  onclick="addToGrid();" /><img src="../../../images/new.png" alt="new" name="butNew" width="70" height="24" class="mouseover"  id="butNew2" onclick=" newDettail();setGenDesc();"/> <img src="../../../images/addmark.png" alt="addDetails" name="addDetails" width="40" height="25" class="mouseover" onclick="addDetailsToGrid();"/></td>
              </tr>
		   		    </table></td>
          </tr>
		</table>
		</div>		</td>
        </tr>
    </table></div>
		<div id="tabs-3"  height:280px ><table width="100%" height="443" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="95%" height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="left" class="head1">PO Wise Description</div></td>
        <td width="5%" bgcolor="#9BBFDD" class="normalfnth2">&nbsp;</td>
      </tr>
      <tr>
        <td height="394" colspan="2"><div id="divLotInterface" style=" overflow:scroll; width:100%; height:400px" >
          <table width="100%" border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt bcgl1">
                
                <tr>
                  <td height="25">HS Code </td>
                  <td><select  id="txtHS_po" tabindex="1" class="txtbox" name="txtHS_po" style="width:132px" >
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
                  <td>Desc</td>
                  <td><input name="txtDesc_po" type="text" class="txtbox" tabindex="2" id="txtDesc_po"  style="width:130px;" maxlength="30" /></td>
				   <td>Cat # </td>
                  <td><input name="txtCatno_po" type="text" class="txtbox" tabindex="3" id="txtCatno_po"  style="width:130px;" maxlength="30" /></td>
                  <td>ISD # </td>
                  <td><input name="txtISD_po" type="text" class="txtbox" tabindex="4" id="txtISD_po"  style="width:130px;" maxlength="30" /></td>
                </tr>
                <tr>
                  <td height="25">PO # </td>
                  <td><input name="txtPO_po" type="text" class="txtbox" tabindex="5" id="txtPO_po"  style="width:130px;" maxlength="30" /></td>
                  <td>Qty</td>
                  <td><input name="txtQty_po" type="text" class="txtbox" tabindex="6" id="txtQty_po"  style="width:130px; text-align:right" maxlength="15" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="cal_po_amount()" /></td>
                  <td>Unit</td>
                  <td><select name="txtUnit_po" type="text" tabindex="7" id="txtUnit_po" class="txtbox" style="width:132px" >
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
                  <td>Unit Price</td>
                  <td><input name="txtPrice_po" type="text" class="txtbox" tabindex="8" id="txtPrice_po"  style="width:130px; text-align:right" maxlength="15" onkeypress="return CheckforValidDecimal(this.value, 4,event);" onblur="cal_po_amount()" /></td>
                </tr>
                <tr>
                  <td width="10%">Price unit </td>
                  <td width="15%"><select name="cboCurrency_po"  onchange="setExchangeRates(this.value);"  class="txtbox" id="cboCurrency_po" tabindex="9" style="width:132px;"/>
				  <option value=""></option>				    
                    <?php 
							$sqlunit="SELECT 	strUnit FROM 	units ";
							$resultunit=$db->RunQuery($sqlunit);							
							while($rowunit=mysql_fetch_array($resultunit)) 
							{
							echo "<option value=".$rowunit['strUnit'].">".$rowunit['strUnit']."</option>";
															
							}  
						         
                  ?>
                  </select>
                  </td>
                  <td width="10%">Amount</td>
                  <td width="15%"><input name="txtAmount_po" type="text" class="txtbox" tabindex="10" id="txtAmount_po"  style="width:130px; text-align:right" maxlength="25" onkeypress="return CheckforValidDecimal(this.value, 4,event);"/></td>
                  <td width="10%">&nbsp;</td>
                  <td width="15%"><input name="image" type="image" tabindex="11"   onclick="add_po_wise_ci();" src="../../../images/addsmall.png"/></td>
                  <td width="10%">&nbsp;</td>
                  <td width="15%">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><div style="overflow: scroll; height: 250px; width: 900px;" id="selectitem"><table width="880" cellspacing="1" cellpadding="0" class="bcgl1 normalfnt" id="tblDescription_po">
          <tr>
          	<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
            <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">HS Code </td>
            <td width="10%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">PO # </td>
			<td width="10%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">ISD </td>
            <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">CAT # </td>
			<td width="25%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Desc</td>
            <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Qty </td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Unit </td>
			<td width="5%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Price </td>
			<td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Price unit  </td>
            <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Value </td>                     
            </tr></table></div></td>
            </tr>
          </table>
        </div>
          </td>
      </tr>
	  
	  <tr>
	  <td>
	  <table width="900" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td width="126" height="29">&nbsp;</td>
        <td width="167">&nbsp;</td>
        <td width="117"><img src="../../../images/new.png" alt="new" name="butNew"  class="mouseover"  id="butNew" onclick="pageReload(); "/></td>
        <td width="107"><img src="../../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="save_po_wise_ci();" /></td>
        <td width="123"><img src="../../../images/report.png" alt="butReportList" name="butReportList"  class="mouseover" id="butReport" onclick="print_preshipment_docs()"/></td>
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
<select name="cboShipper2"  tabindex="9" class="txtbox" id="cboShipper2" style="width:160px">
  <option value=""></option>
  <?php
                   $sqlConsignee="SELECT strCustomerID, strName,strMLocation FROM customers WHERE strCustomerID <>10  ORDER BY strName ";
                   $resultConsignee=$db->RunQuery( $sqlConsignee);
						 while($row=mysql_fetch_array( $resultConsignee)) 
						 echo "<option value=".$row['strCustomerID'].">".$row['strMLocation']."</option>";                 
                   ?>
</select>
</body>
</html>