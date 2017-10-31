<?php
	session_start();
	include("../../Connector.php");
	include "../../eshipLoginDB.php";
	$backwardseperator = "../../";
	include $backwardseperator."authentication.inc";	
	$status = $_GET["cboStatus"];
	$eshipDB = new eshipLoginDB();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cost Work Sheet</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
	<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
	<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
    <link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
    
	<!--<link href="../../css/JqueryTabs.css" rel="stylesheet" type="text/css" />-->
    
	<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="../../javascript/script.js"></script>
   <script type="text/javascript" src="../../javascript/calendar/calendar.js"></script>
   <script type="text/javascript" src="../../javascript/calendar/calendar-en.js"></script>
	<!--<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>-->
   <!-- <script type="text/javascript" src="../../js/jquery-ui-1.8.9.custom.min.js"></script>
	<script type="text/javascript" src="../../js/tablegrid.js"></script>-->
	

	<script type="text/javascript">
		$(function(){
			// TABS
			$('#tabs').tabs();
		});
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
</head>

<body onload="loadShippingCostWorksheet(<?php 
$id = $_GET["id"];
if($id !=0)
	echo $_GET["invoiceID"];
else
	echo "0";  ?>)">
<table width="100%" align="center">
	<tr>
    	<td><?php include '../../Header.php'; ?></td>
	</tr>
</table>
<!--<div>
	<div align="center">
		<div class="trans_layoutL" style="padding-bottom:20px;">
			<div class="trans_text">Cost Work Sheet<span class="volu"></span></div>-->
	<table width="950" align="center">
    <tr><td>&nbsp;</td></tr>
    <tr><td class="mainHeading">Cost Worksheet</td></tr>
	<tr>
    	<td>
			<div  id="tabs" style="background-color:#FFFFFF">
				<ul>
					<li><a href="#tabs-1" class="normalfnt">Cost Work Sheet</a></li>
					<li><a href="#tabs-2" class="normalfnt">Pending Cost Work Sheet</a></li>
					<li><a href="#tabs-3" class="normalfnt" onclick="loadApprovedOrderNoList();">Approved Cost Work Sheet</a></li>
				</ul>
				
				<!-----------------------------------------------SAMPLE MODULE------------------------------------------>
				<div id="tabs-1">
              <form id="frmShipCostWorkSheet" action="">
					<table width="100%" border="0">
                   <tr>
                   <td colspan="4"></td>
                    </tr> 
                     <tr>
                    <td class="normalfnt" id="styleID" title="">Order No</td>
                     <td><span class="normalfnt">
                       <!--<select name="cboOrderNo" id="cboOrderNo" style="width:152px;" onchange="loadOrder_comInv_details();">
                         <?php 
						  $sql = "select fsh.intStyleId,o.strOrderNo 
from firstsalecostworksheetheader fsh inner join orders o on 
fsh.intStyleId = o.intStyleId
where fsh.intStatus=0 and fsh.intStyleId not in
(select intStyleId from firstsale_shippingdata where intStatus in (0,1,10))
order by o.strOrderNo";
							
							$result =$db->RunQuery($sql); 
							//echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($row=mysql_fetch_array($result))
							{
								//echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
							}		
						  ?>
                       </select>-->
                       <input type="text" name="txtOrderNo" id="txtOrderNo" onkeypress="enterLoadStyleDetails(event);" style="width:150px;" />
                     </span></td>
                     <td><span class="normalfnt">Color</span></td>
                       <td><span class="normalfnt">
                         <select name="cboColor" class="txtbox" id="cboColor" style="width: 252px;" disabled="disabled">
                           <?php 
							$sqlColor = "select distinct strColor from colors where intStatus=1 ";
							
							$resColor =$db->RunQuery($sqlColor); 
							echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($row=mysql_fetch_array($resColor))
							{
								echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;
							}
						?>
                         </select>
                       </span></td>
                    </tr>
						<tr >
							<td width="19%" class="normalfnt" >Com Inv No</td>
					  	  <td width="27%" class="normalfnt" id="orderId" title=""><select name="cboComInvNo" id="cboComInvNo" style="width:152px;" onchange="load_order_details();">
                          </select></td>
							<td width="23%" class="normalfnt">Product Description Fabric</td>
			              <td width="31%" class="normalfnt"><!--<input type="text" name="txtComInvNo" id="txtComInvNo" style="width:150px;" onkeypress="enableEnterLoadOrderList(event);" />-->
		                  <input type="text" class="txtbox" style="width:250px;" id="txtfabric" /></td>
					  </tr>
						
						<tr>
							<td width="19%" class="normalfnt">Style</td>
						  	<td width="27%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="txtStyle" /></td>
							<td class="normalfnt">Product Description Other</td>
					        <td class="normalfnt"><input type="text" class="txtbox" style="width:250px;" id="txtotherDetail" /></td>
					  </tr>
						<tr>
							<td width="19%" class="normalfnt">Invoice no</td>
						  	<td width="27%" class="normalfnt"><input type="text" name="txtInvNo" id="txtInvNo" style="width:150px;" /></td>
							<td class="normalfnt">Sewing Factory</td>
					        <td class="normalfnt"><select name="cboFactory" id="cboFactory" style="width:252px;">
                              <?php 
							$sql_Fac = "select strCustomerID,strName,strCompanyCode from customers order by strName ";
							
							$resFac =$eshipDB->RunQuery($sql_Fac); 
							echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($row=mysql_fetch_array($resFac))
							{
								echo "<option value=\"". $row["strCustomerID"] ."\">" . $row["strName"] .' - '.$row["strCompanyCode"]."</option>" ;
							}
						?>
                            </select></td>
					  </tr>
						<tr>
							<td width="19%" class="normalfnt">Saling Date</td>
						  	<td width="27%" class="normalfnt"><input type="text" name="txtsalingDate" id="txtsalingDate" style="width:150px;" /></td>
							<td class="normalfnt">CMP</td>				
					      <td class="normalfnt"><input type="checkbox" name="chkCMP" id="chkCMP" />
				          Outsourcing to external factory</td>
					  </tr>
						<tr>
							<td width="19%" class="normalfnt">Ship Quantity</td>
							<td width="27%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="txtShipQty" /></td>
							<td class="normalfnt">Buyer</td>				
			        <td class="normalfnt"><select name="cboBuyer" id="cboBuyer" style="width:252px;">
                      <?php 
							$sql_Buyer = "select strBuyerID,strBuyerCode from buyers order by strBuyerCode";
							
							$resBuyer =$eshipDB->RunQuery($sql_Buyer); 
							echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($rowB=mysql_fetch_array($resBuyer))
							{
								echo "<option value=\"". $rowB["strBuyerID"] ."\">" . $rowB["strBuyerCode"] ."</option>" ;
							}
						?>
                    </select></td>
					  </tr>
						<tr>
							<td width="19%" class="normalfnt">Inv Cost.FOB</td>
						  	<td width="27%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;"  id="txtInvFob" /></td>
                            <td class="normalfnt">Consignee</td>
              <td><span class="normalfnt">
                <select name="cboConsignee" id="cboConsignee" style="width:252px;">
                  <?php 
							$sql_Buyer = "select strBuyerID,strName from buyers order by strName";
							
							$resBuyer =$eshipDB->RunQuery($sql_Buyer); 
							echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($rowB=mysql_fetch_array($resBuyer))
							{
								echo "<option value=\"". $rowB["strBuyerID"] ."\">" . $rowB["strName"] ."</option>" ;
							}
						?>
                </select>
              </span></td>
					  </tr>
						<tr>
							<td  class="normalfnt">Com Inv.FOB</td>
							<td  class="normalfnt"><input type="text" name="txtComInvFob" id="txtComInvFob" style="width:150px;" /></td>	
                            <td  class="normalfnt">Shipped To</td>
                          <td  class="normalfnt"><select name="cboShipto" id="cboShipto" style="width:252px;">
                            <?php 
							$sql_Buyer = "select strBuyerID,strName from buyers order by strName";
							
							$resBuyer =$eshipDB->RunQuery($sql_Buyer); 
							echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($rowB=mysql_fetch_array($resBuyer))
							{
								echo "<option value=\"". $rowB["strBuyerID"] ."\">" . $rowB["strName"] ."</option>" ;
							}
						?>
                          </select></td>		
					  </tr>
						<tr>
						  <td class="normalfnt">Carrier</td>
						  <td class="normalfnt"><input type="text" name="txtCarrier" id="txtCarrier" style="width:150px;" /></td>
						  <td class="normalfnt">Final Destination</td>
					      <td class="normalfnt"><select name="cboFinalDestination" id="cboFinalDestination" style="width:252px;">
                            <?php 
							$sql_city = "select strCityCode,strCity from city order by strCity ";
							
							$resCity =$eshipDB->RunQuery($sql_city); 
							echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($rowC=mysql_fetch_array($resCity))
							{
								echo "<option value=\"". $rowC["strCityCode"] ."\">" . $rowC["strCity"] ."</option>" ;
							}
						?>
                          </select></td>
					  </tr>
						<tr>
						  <td class="normalfnt">Vat Rate</td>
						  <td class="normalfnt"><input type="text" name="txtVatRate" id="txtVatRate" style="width:150px;" value="12" /></td>
						  <td class="normalfnt">Gender</td>
					      <td class="normalfnt"><input type="text" name="txtgender" id="txtgender" style="width:250px;" disabled="disabled"/></td>
					  </tr>
						<tr>
						  <td class="normalfnt">Payment Term</td>
						  <td class="normalfnt"><select name="cboPayTerm" id="cboPayTerm" style="width:152px;">
                           <?php 
							$sql_PT = "select strPaymentTermID, strPaymentTerm from paymentterm order by strPaymentTerm";
							
							$resPT =$eshipDB->RunQuery($sql_PT); 
							//echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($rowP=mysql_fetch_array($resPT))
							{
								echo "<option value=\"". $rowP["strPaymentTerm"] ."\">" . $rowP["strPaymentTerm"] ."</option>" ;
							}
						?>
						    </select>						  </td>
						  <td class="normalfnt">U.S.HTS Data</td>
					      <td class="normalfnt"><input type="text" name="txtHTSData" id="txtHTSData" style="width:250px;" disabled="disabled"/></td>
					  </tr>
						<tr>
						  <td class="normalfnt">Shipment Term</td>
						  <td class="normalfnt"><select name="cboShipmentTerm" id="cboShipmentTerm" style="width:152px;">
                           <?php 
							$sql_ST = "select strShipmentTermId,strShipmentTerm from shipmentterms order by strShipmentTerm ";
							
							$resST =$eshipDB->RunQuery($sql_ST); 
							//echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($rowS=mysql_fetch_array($resST))
							{
								echo "<option value=\"". $rowS["strShipmentTermId"] ."\">" . $rowS["strShipmentTerm"] ."</option>" ;
							}
						?>
						    </select>						  </td>
						  <td class="normalfnt">Bank</td>
					      <td class="normalfnt"><select name="cboBank" id="cboBank" style="width:252px;">
                            <?php 
							$sql_Bank = "select strBankCode,strName from bank order by strName";
							
							$resBank =$eshipDB->RunQuery($sql_Bank); 
							echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($rowB=mysql_fetch_array($resBank))
							{
								echo "<option value=\"". $rowB["strBankCode"] ."\">" . $rowB["strName"] ."</option>" ;
							}
						?>
                          </select></td>
					  </tr>
						<tr>
							<td width="19%" class="normalfnt">&nbsp;</td>
					  	  <td width="27%" class="normalfnt">&nbsp;</td>
						  <td colspan="2" class="normalfnt"></td>
						</tr>
					</table>
	
        <!--<div style="overflow:scroll; height:360px; width:698px;">-->

				 <!-- </div>-->
				 
				 
	  
					
					
	 <!-- <table width="800" border="0">
						<tr>
							<td width="37%">&nbsp;</td>
							<td width="9%"><img src="../../images/additem2.png" width="65" /></td>
							<td width="11%"><img src="../../images/delete.png" width="80" /></td>
							<td width="10%"><img src="../../images/select.png" alt="close" width="75" border="0" /></td>
							<td width="33%">&nbsp;</td>
						</tr>
					</table>
					<br />-->
	 <br />
					<table width="750" border="0" class="tableFooter" align="center">
						<tr>
							<td width="37%">&nbsp;</td>
							<td width="9%"><img src="../../images/new.png" onclick="clearShippingCWS();" /></td>
							<td width="11%"><img src="../../images/save.png" width="80" onclick="saveShippingCWS();" /></td>
							
						  <td width="33%">&nbsp;</td>
						</tr>
					</table>
                  </form>
                  <div style="left:310px; top:400px; z-index:10; position:absolute; visibility:hidden; width: 430px;  height: 65px;" id="copyOrderDetails">
  <table width="427" height="56" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr bgcolor="#550000">
                <td width="96%">&nbsp;</td>
                <td width="4%"><img src="../../images/cross.png" width="17" height="17" onclick="closeCopyOrderPopup();" /></td>
              </tr>
            </table></td>
            
          </tr>
          <tr>
            <td width="56">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td id="copyOrderId" title=""><div align="center">Order No </div></td>
            <td width="153">
              <div align="right">
                <input type="text" name="txtCopyOrderNo" id="txtCopyOrderNo" style="width:140px;" onkeypress="enterSubmitLoadComInvNo(event);" />
              </div></td><td colspan="2"> &nbsp;Com. INV No
&nbsp;
<select name="copycomInvNo" class="txtbox" id="copycomInvNo" style="width:120px" >
  
</select></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right"><img src="../../images/go.png" alt="Copy PO" width="30" height="22" vspace="3" class="mouseover" onclick="copyOrder();" /></div></td>
            <td width="65">&nbsp;</td>
            <td width="151">&nbsp;</td>
          </tr>
  </table>
		
		
</div>
			  </div>
				
				<!-----------------------------------------------PENDING WORK SHEET------------------------------------------>
				<div id="tabs-2">
					<!--<div style="overflow:scroll; height:350px; width:750px;">
					<table style="width:780px" class="transGrid" border="0" cellspacing="1">
						<thead>
							<tr>
								<td colspan="6">Materials and Trims</td>			
							</tr>	
							<tr>
								<td width="48">Select</td>
								<td width="407">Meterial, Parts, Trims Description</td>
								<td width="45">YY</td>	
								<td width="62">Unit</td>	
								<td width="190">Placement</td>				
							</tr>		
						</thead>	
						<tbody>
							<tr>
								<td width="48"><input id="" name="" type="checkbox" class="txtbox"  /></td>
								<td width="407"><a href="costworksheet.php">select</a></td>
								<td width="45">****</td>	
								<td width="62">****</td>
								<td width="190">****</td>			
							</tr>
							<tr>
								<td width="48"><input id="" name="" type="checkbox" class="txtbox"  /></td>
								<td width="407">****</td>
								<td width="45">****</td>
								<td width="62">****</td>
								<td width="190">****</td>				
							</tr>	
						</tbody>
					</table>
					</div>-->
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>Pending List</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><div style="overflow:scroll; width:900px; height:550px;"> 
                        <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF">
                          <tr class="mainHeading4">
                            <td  width="47" height="22">Ref Id</td>
                            <td width="108" >CVWS</td>
                            <td width="86" >Comercial Inv No</td>
                            <td width="51" >Inv No</td>
                            <td width="85" >Order No</td>
                            <td width="57" >Color</td>
                            <td width="87" >Sailing Date</td>
                            <td width="66" >Shipped Qty</td>
                            <td width="69" >Buyer</td>
                            <td width="82" >Record Date</td>
                            <td width="84" >Summary Date</td>
                          </tr>
                          <?php 
						  	$sql_shipData = "Select  fsship.intStyleId,fsship.strOrderNo,fsship.strOrderColorCode,
					fsship.dblInvoiceId as invoiceID,fsship.strInvoiceNo,fsship.strComInvNo,fsship.dtmDate as summeryDate,
					fsh.dtmDate as recDate,fsh.intStatus
					from firstsale_shippingdata fsship inner join firstsalecostworksheetheader fsh on
					fsship.intStyleId = fsh.intStyleId 
					where fsship.intStatus=0 order by fsship.dblInvoiceId";
					//echo $sql_shipData;
					$result =$db->RunQuery($sql_shipData); 
					while($row = mysql_fetch_array($result))
					{
						$invStatus = $row["intStatus"];
						$cls = ($invStatus =='1' ?'grid_raw_pink' :'grid_raw_white');
						$comInvNo = $row["strComInvNo"];
						$color = $row["strOrderColorCode"];
						$shipOrderNo = $row["strOrderNo"];
						$intStyleId = $row["intStyleId"];
						
						$strUrl  = "shippingCWS.php?id=1&invoiceID=".$row["invoiceID"];
						
						$strUrlCVWS = "cvwsReport.php?invoiceID=".$row["invoiceID"]."&styleID=".$row["intStyleId"];
						
						$preOrderNo = $row["strOrderNo"];
						if($color != '')
							$preOrderNo = $preOrderNo.'-'.$color;
						  ?>
                          <tr class="<?php echo $cls; ?>">
                          <?php 
						  	if($invStatus == '1')
							{
						  ?>
                           <td><?php echo $row["invoiceID"]; ?></td>
                           <?php 
						   }
						   else
						   {
						   ?>
                            <td><a href="<?php echo $strUrl; ?>" style="text-decoration:underline"><?php echo $row["invoiceID"]; ?></a></td>
                            <?php 
							}
							?>
                            <td><a href="<?php echo $strUrlCVWS; ?>" target="cvwsReport.php"><?php echo $row["strInvoiceNo"]; ?></a></td>
                            <td><?php echo $row["strComInvNo"]; ?></td>
                            <td align="center"><img src="../../images/pdf.png" width="16" height="16" onclick="viewInvoiceRpt(<?php echo $row["invoiceID"].','.$row["intStyleId"] ?>);" /></td>
                            <td><?php echo $preOrderNo;//$row["strOrderNo"].'-'.$row["strOrderColorCode"] ?></td>
                            <td><?php echo $row["strOrderColorCode"]; ?></td>
                            <?php 
								$sql_ship_data = "select date(cih.dtmSailingDate) as SailingDate,sum(cid.dblQuantity) as dblQuantity ,b.strBuyerCode
			from shipmentplheader splh inner join commercial_invoice_detail cid on
			cid.strPLno = splh.strPLNo --  and cid.strBuyerPONo = splh.strStyle 
			inner join commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
			inner join buyers b on b.strBuyerID = cih.strBuyerID
			where cid.strInvoiceNo ='$comInvNo'   and splh.intStyleId ='$intStyleId' group by splh.intStyleId ";
			 
			// echo $sql_ship_data;
			 $resShipping = $eshipDB->RunQuery($sql_ship_data);
			 while($rowS = mysql_fetch_array($resShipping))
			 {
							?>
                            <td><?php echo $rowS["SailingDate"]; ?></td>
                            <td><?php echo $rowS["dblQuantity"]; ?></td>
                            <td><?php echo $rowS["strBuyerCode"]; ?></td>
                            <?php 
							}
							?>
                            <td><?php echo $row["recDate"]; ?></td>
                            <td width="65"><?php echo $row["summeryDate"]; ?></td>
                          </tr>
                          <?php 
						  }
						  ?>
                        </table></div></td>
                      </tr>
                      <tr>
                        <td></td>
                      </tr>
                    </table>
			    <br />
					

				</div>
				
				<!-----------------------------------------------APPROCED WORK SHEET------------------------------------------>
				<div id="tabs-3">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td></td>
                      </tr>
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="14%" class="normalfnt">Order No</td>
                            <td width="18%"><input type="text" name="txtAppOrderNo" id="txtAppOrderNo" onkeypress="enableEnterSubmitApprovShipDetails(event)" /></td>
                            <td width="68%"><img src="../../images/search.png" width="80" height="24" onclick="viewApprovedOrderData();"/></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td>
					<div style="overflow:scroll; height:550px; width:900px;">
					<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblAppShip">
                          <tr class="mainHeading4">
                            <td  width="52" height="22">Ref Id</td>
                            <td width="120" >CVWS</td>
                            <td width="110" >Comercial Inv No</td>
                            <td width="50" >Inv No</td>
                            <td width="89" >Order No</td>
                            <td width="79" >Color</td>
                            <td width="83" >Sailing Date</td>
                            <td width="68" >Shipped Qty</td>
                            <td width="75" >Buyer</td>
                            <td width="81" >Record Date</td>
                            <td width="81" >Summary Date</td>
                      </tr>
                          <?php 
						  	$rw=0;
						  	$sql_shipData = " Select  fsship.intStyleId,fsship.strOrderNo,fsship.strOrderColorCode,
					fsship.dblInvoiceId as invoiceID,fsship.strInvoiceNo,fsship.strComInvNo,fsship.dtmDate as summeryDate,
					fsh.dtmDate as recDate,fsship.intStatus,fsship.intTaxInvoiceConfirmBy
					from firstsale_shippingdata fsship inner join firstsalecostworksheetheader fsh on
					fsship.intStyleId = fsh.intStyleId 
					where fsship.intStatus =1 order by fsship.dblInvoiceId ";
				
					$result =$db->RunQuery($sql_shipData); 
					while($row = mysql_fetch_array($result))
					{
						$invStatus = $row["intStatus"];
						//$cls = 'grid_raw_white';//($rw%2 ==0 ?'grid_raw' :'grid_raw2');
						if($row["intTaxInvoiceConfirmBy"] != '')
							$cls = 'grid_raw_white';
						else
							$cls = 'grid_raw_pink';
						$comInvNo = $row["strComInvNo"];
						$color = $row["strOrderColorCode"];
						$shipOrderNo = $row["strOrderNo"];
						$preOrderNo = $row["strOrderNo"];
						if($color != '')
							$preOrderNo = $preOrderNo.'-'.$color;
						//$strUrl  = "shippingCWS.php?id=1&invoiceID=".$row["invoiceID"];
						
						$strUrlCVWS = "cvwsReport.php?invoiceID=".$row["invoiceID"]."&styleID=".$row["intStyleId"];
						$intStyleId = $row["intStyleId"];
						  ?>
                          <tr class="<?php echo $cls; ?>">
                         
                           <td><?php echo $row["invoiceID"]; ?></td>
                          
                            <td><a href="<?php echo $strUrlCVWS; ?>" target="cvwsReport.php"><?php echo $row["strInvoiceNo"]; ?></a></td>
                            <td><?php echo $row["strComInvNo"]; ?></td> 
                            <td align="center"><img src="../../images/pdf.png" width="16" height="16" onclick="viewInvoiceRpt(<?php echo $row["invoiceID"].','.$row["intStyleId"] ?>);" /></td>
                            <td><?php echo $preOrderNo; ?></td>
                            <td><?php echo $row["strOrderColorCode"]; ?></td>
                            <?php 
								$sql_ship_data = "select date(cih.dtmSailingDate) as SailingDate,sum(cid.dblQuantity) as dblQuantity, b.strBuyerCode
			from shipmentplheader splh inner join commercial_invoice_detail cid on
			cid.strPLno = splh.strPLNo  -- and cid.strBuyerPONo = splh.strStyle 
			inner join commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
			inner join buyers b on b.strBuyerID = cih.strBuyerID
			where cid.strInvoiceNo ='$comInvNo'   and  splh.intStyleId='$intStyleId' group by splh.intStyleId ";
			
			 
			 $resShipping = $eshipDB->RunQuery($sql_ship_data);
			 while($rowS = mysql_fetch_array($resShipping))
			 {
							?>
                            <td><?php echo $rowS["SailingDate"]; ?></td>
                            <td><?php echo $rowS["dblQuantity"]; ?></td>
                            <td><?php echo $rowS["strBuyerCode"]; ?></td>
                            <?php 
							}
							?>
                            <td><?php echo $row["recDate"]; ?></td>
                            <td><?php echo $row["summeryDate"]; ?></td>
                          </tr>
                          <?php
						  $rw++;
						  }
						  ?>
                        </table>
					</div></td></tr></table>
					<br />
					<!--<table width="800" border="0">
						<tr>
							<td width="34%">&nbsp;</td>
							<td width="12%"><img src="../../images/new.png" id="butNew" name="butNew" width="90" /></td>
							<td width="11%"><img src="../../images/save.png" id="butSave" name="butSave" width="80" /></td>
							<td width="12%"><a href="../../main.php"><img src="../../images/close.png" id="butClose" name="butClose" alt="close" width="90" border="0" /></a></td>
							<td width="31%">&nbsp;</td>
						</tr>
					</table>-->
				</div>
			</div>	
		<!--</div>
	</div>
</div>-->
</td>
	</tr>
</table>
</body>
<script type="text/javascript" src="shippingCWS.js"></script>
 <script type="text/javascript" src="../../js/jquery.fixedheader.js"></script>
</html>
