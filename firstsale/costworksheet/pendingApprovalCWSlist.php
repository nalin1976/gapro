<?php
	session_start();
	include("../../Connector.php");
	$backwardseperator = "../../";
	include $backwardseperator."authentication.inc";
	include "../../eshipLoginDB.php";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cost Work Sheet - Approval</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
	<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
	<link href="../../css/tableGrib.css" rel="stylesheet" type="text/css" />
    <link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
    
	<!--<link href="../../css/JqueryTabs.css" rel="stylesheet" type="text/css" />-->
   <style type="text/css">
<!--
.bcgcolor-Red {
	background-color: #FF0000;
}
<style type="text/css">

    table.fixHeader {

        border: solid #FFFFFF;

        border-width: 2px 2px 2px 2px;

        width: 1050px;

    }

    tbody.ctbody {

        height: 650px;

        overflow-y: auto;

        overflow-x: hidden;

    }

 

</style>

</style> 
	<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="../../javascript/script.js"></script>
   <script type="text/javascript" src="../../javascript/calendar/calendar.js"></script>
   <script type="text/javascript" src="../../javascript/calendar/calendar-en.js"></script>
	<!--<script type="text/javascript" src="../../js/jquery-ui-1.7.2.custom.min.js"></script>-->
   <!-- <script type="text/javascript" src="../../js/jquery-ui-1.8.9.custom.min.js"></script>
	<script type="text/javascript" src="../../js/tablegrid.js"></script>-->
	<script type="text/javascript" src="costWorksheet.js"></script>

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

<body onload="loadCostWorksheet(<?php 
$id = $_GET["id"];
if($id !=0)
	echo $_GET["StyleID"].','.$_GET["invoiceID"];
else
	echo "0";  ?>)">
<table width="100%" align="center" id="tblMain">
	<tr>
    	<td><?php include '../../Header.php'; ?></td>
	</tr>
</table>
<!--<div>
	<div align="center">
		<div class="trans_layoutL" style="padding-bottom:20px;">
			<div class="trans_text">Cost Work Sheet<span class="volu"></span></div>-->
	<table width="100%" align="center">
    <tr><td height="5"></td></tr>
    <tr><td class="mainHeading">Cost Worksheet</td></tr>
	<tr>
    	<td>
			<div  id="tabs" style="background-color:#FFFFFF">
				<ul>
					<!--<li><a href="#tabs-1" class="normalfnt" >Cost Work Sheet</a></li>-->
					<li><a href="#tabs-2" class="normalfnt">Pending Cost Work Sheet</a></li>
					<li><a href="#tabs-3" class="normalfnt" onclick="clearApprovedList();">Approved Cost Work Sheet</a></li>
				</ul>
				
				<!-----------------------------------------------SAMPLE MODULE------------------------------------------>
<!--				<div id="tabs-1">
              <form id="frmCostWorkSheet" action="">
					<table width="100%" border="0">
						<tr >
							<td width="19%" class="normalfnt" >Order No</td>
					  	  <td width="27%" class="normalfnt" id="orderId" title=""><input type="text" class="txtbox" style="width:150px;" id="txtOrderNo"  onkeypress="enableEnterSubmitLoadDetails(event)"/></td>
							<td width="23%" class="normalfnt">Inv. Cost. FOB</td>
						    <td width="31%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="txtInvFOB" /></td>
						</tr>
						<tr>
							<td width="19%" class="normalfnt">Color</td>
						  	<td width="27%" class="normalfnt">
								<select style="width: 152px;" class="txtbox" id="cboColor">
									<?php 
							$sqlColor = "select distinct strColor from colors where intStatus=1 ";
							
							$resColor =$db->RunQuery($sqlColor); 
							echo "<option value=\"". "" ."\">" . "" ."</option>" ;
							while($row=mysql_fetch_array($resColor))
							{
								echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;
							}
						?>
								</select>						  </td>
							<td class="normalfnt">Pre. Cost. FOB</td>
						    <td class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="txtPreorderFob" /></td>
						</tr>
						<tr>
							<td width="19%" class="normalfnt">Style</td>
						  	<td width="27%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="txtStyle" /></td>
							<td class="normalfnt">Buyer PO FOB</td>
						    <td class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="txtBuyerFob" /></td>
						</tr>
						<tr>
							<td width="19%" class="normalfnt">Buyer</td>
						  	<td width="27%" class="normalfnt">
								<select style="width: 152px;" class="txtbox" id="cboBuyer">
									<option value=""></option>
									<?php 
										$sql = "select intBuyerID,strName from buyers where intStatus=1 order by strName";
									$result = $db->RunQuery($sql);	
						while($row = mysql_fetch_array($result))
						{
							if($_POST["cboBuyer"]==$row["intBuyerID"])
								echo "<option selected=\"selected\" value=\"". $row["intBuyerID"] ."\">" . trim($row["strName"]) ."</option>" ;								
							else
								echo "<option value=\"". $row["intBuyerID"] ."\">" . trim($row["strName"]) ."</option>" ;
						}
									?>
								</select>						  </td>
							<td class="normalfnt">CM</td>
						    <td class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="txtCMV" /></td>
						</tr>
						<tr>
							<td width="19%" class="normalfnt">Order Qty</td>
						  	<td width="27%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="orderQty" /></td>
							<td class="normalfnt">OTL PO Date</td>				
						    <td class="normalfnt"><input type="text" id="txtOTLdate" class="txtbox" style="width:150px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
						</tr>
						<tr>
							<td width="19%" class="normalfnt">SMV</td>
							<td width="27%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="txtSMV" /></td>
							<td class="normalfnt">Buyer PO Date</td>				
						    <td class="normalfnt"><input type="text" class="txtbox" style="width:150px;" id="txtOrderDate" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" onblur="calOTLdate();"/><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
						</tr>
						<tr>
							<td width="19%" class="normalfnt">PCS Per CTN</td>
						  	<td width="27%" class="normalfnt"><input type="text" class="txtbox" style="width:150px;"  id="txtpcsCarton" /></td>
                            <td><span class="normalfnt">Ex Factory Date</span></td>
                            <td><span class="normalfnt">
                              <input type="text" class="txtbox" style="width:150px;" id="txtFacDate" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  /><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');">
                            </span></td>
						</tr>
						<tr>
							<td  class="normalfnt">Difference Inv FOB vs  First Sale FOB %</td>
							<td  class="normalfnt"><input type="text" class="txtbox" style="width:150px;"  id="txtFobDiff" /></td>	
                            <td class="normalfnt"><input type="hidden" name="invoiceID" id="invoiceID" /></td>
                            <td class="normalfnt">&nbsp;</td>		
						</tr>
						<tr>
						  <td class="normalfnt">&nbsp;</td>
						  <td class="normalfnt">&nbsp;</td>
						  <td colspan="2" class="normalfnt"></td>
					  </tr>
						<tr>
							<td width="19%" class="normalfnt">&nbsp;</td>
						  	<td width="27%" class="normalfnt">&nbsp;</td>
							<td colspan="2" class="normalfnt"></td>
						</tr>
					</table>
<br />		
			
<table style="width:850px"  border="0" cellspacing="1" bgcolor="#C58B8B" class="bcgcolor" >						
								<tr class="mainHeading4">
								  <th width="744" >Cost Work Sheet</th>
                                  <th width="99"><img src="../../images/additem2.png" onclick="addPreorderItems();" /></th>			
			  </tr>	
								
						</table>
						<table style="width:847px"  border="0" cellspacing="1" id="tblItemList" bgcolor="#C58B8B" class="bcgcolor" >
                        
							<thead>
								
								<tr  class="mainHeading4">
                                <th width="3%" height="20"><input type="checkbox" name="chkAll" id="chkAll" onclick="CheckAll(this,'tblItemList');" /></th>	
                                 <th width="3%">Del</th>		
								  <th width="44%">Description</th>
								  <th width="7%">Unit</th>
								  <th width="10%">Unit Price</th>
								  <th width="10%">Consumption</th>
								  <th width="11%">Value</th>	
                                   <th width="12%">Catogory</th>	
                                    
							  </tr>		
							</thead>	
							<tbody>
								
							</tbody>
						</table>
				 
				  <br />
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="44%" align="left"><table width="89%" border="0" cellspacing="1" class="main_border_line" >
                          <thead>
                            
                            <tr >
                              <td width="243" class="grid_header" height="25">Description</td>
                              <td width="66" class="grid_header">Total</td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class="grid_raw" >
                              <td style="text-align:left">Material</td>
                              <td id="txtMaterialCost" style="text-align:right" >0</td>
                            </tr>
                            <tr class="grid_raw2">
                              <td style="text-align:left">Accessories</td>
                              <td id="txtAccessoriesCost" style="text-align:right">0</td>
                            </tr>
                            <tr class="grid_raw">
                              <td style="text-align:left">Hanger</td>
                              <td id="txtHanger" style="text-align:right">0</td>
                            </tr>
                            <tr class="grid_raw2">
                              <td style="text-align:left">Belts</td>
                              <td id="txtbeltsCost" style="text-align:right">0</td>
                            </tr>
                            <tr class="grid_raw">
                              <td style="text-align:left">Transporting Assists & Other Services</td>
                              <td id="txtTransportCost" style="text-align:right">0</td>
                            </tr>
                            <tr class="grid_raw2">
                              <td style="text-align:left">CMPW</td>
                              <td id="txtcmpwCost" style="text-align:right">0</td>
                            </tr>
                            <tr class="grid_raw">
                              <td ><b>Total</b></td>
                              <td id="txtTotalCost" style="text-align:right; font-weight:bolder">0</td>
                            </tr>
                          </tbody>
                        </table></td>
                        <td width="56%" valign="top"><table width="86%" border="0">
<tr>
							<td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="1" cellpadding="0" class="main_border_line" id="tblInvDryProcess">
                              <tr>
                                <td width="5%" height="25" class="grid_header">Del</td>
                                <td width="34%" class="grid_header">Description</td>
                                <td width="14%" class="grid_header">Unit</td>
                                <td width="13%" class="grid_header">Unit Price</td>
                                <td width="12%" class="grid_header">Conpc</td>
                                <td width="9%" class="grid_header">Value</td>
                                <td width="13%" class="grid_header">Category</td>
                              </tr>
                            </table></td>
					  	  </tr>
						
					</table></td>
                      </tr>
                    </table>
                <br />
	  
					
					
	
					
		      <table width="750" border="0" cellspacing="2" cellpadding="0" class="tableFooter">
                <tr>
                  <td width="25" class="txtbox bcgcolor-InvoiceCostFabric">&nbsp;</td>
                  <td width="100" class="normalfnt">Fabric</td>
                  <td width="25" class="txtbox bcgcolor-InvoiceCostTrim">&nbsp;</td>
                  <td width="100" class="normalfnt">Accessories</td>
                  <td width="25" class="txtbox bcgcolor-InvoiceCostPocketing">&nbsp;</td>
                  <td width="100" class="normalfnt">Hanger</td>
                  <td width="25" class="txtbox bcgcolor-CostWSBelts">&nbsp;</td>
                  <td width="100" class="normalfnt">Belts</td>
                  <td width="25" class="txtbox bcgcolor-InvoiceCostOther">&nbsp;</td>
                  <td width="100" class="normalfnt">Services</td>
                  <td width="25" class="txtbox bcgcolor-InvoiceCostICNA">&nbsp;</td>
                  <td width="100" class="normalfnt">CMPW</td>
                </tr>
              </table>
	      <br />
					<table width="750" border="0" class="tableFooter" align="center">
						<tr>
							<td align="center"><img src="../../images/new.png" onclick="clearCostWorkSheet();" />
						  <img src="../../images/save.png" width="80" onclick="saveCostWorkSheet();" />
							<img src="../../images/send2app.png" width="171" height="24" style="display:none"; id="butSentApp" onclick="updateShipData();"/><img src="../../images/upload.jpg" onclick="UploadFile();" />
						    <img src="../../images/download.png" width="115" height="24" onclick="showExcelFile();" /><img src="../../images/report.png" width="108" height="24" onclick="showInvExcelReport();" /></td>
					  </tr>
					</table>
                    </form>
				</div>
				-->
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
                        <td><!--<div style="overflow:scroll; height:350px; width:1200px;">-->
                        	<table width="1200" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblPendingList">
                            <thead>
                          <tr class="mainHeading4">
                            <th >Order No</th>
                            <th >Color</th>
                            <th >Ship Qty</th>
                            <th >OC</th>
                            <th >CVW</th>
                            <th >CVWS</th>
                            <th >WSTI</th>
                            <th >STI</th>
                            <th >FI</th>
                            <th >Fabric Price</th>
                            <th >Fabric Cons</th>
                            <th >Fab Act Cons</th>
                            <th >Pocketing Price</th>
                            <th >Pocketing Cons</th>
                            <th >Poc Act cons</th>
                              <th >PI</th>
                            <th >Thread cons</th>
                             <th >Thread Act cons</th>
                            <th >Dry Washing Price</th>
                             <th >Dry Act Washing Price</th>
                              <th >Wet Washing Price</th>
                               <th >Wet Act Washing Price</th>
                            <th >Pcs Per CTN</th>
                            <th >CM</th>
                            <th >SMV</th>
                             <th >Act SMV</th>
                            <th >Inv C. FOB</th>
                            <th >FS FOB</th>
                            <th >Diff %</th>
                            <th >Buyer</th>
                            <th >Pre Cost FOB</th>
                            <th >Com Inv FOB</th>
                            <th >BPO FOB</th>
                            <th >Ref Id</th>
                          
                            <th >BPO</th>
                  <?php           if($manageCWSapproval) {?>
                            <th >Approve</th>
                            <?php } 
							if($manageCWSreject){
							?>
                            <th>Reject</th>
                            <?php 
							}
							?>
                          </tr>
                          </thead>
                          <?php 
						  
						  	/*$sqlFSdetail = "select fsh.intStyleId,fsh.strOrderNo,fsh.strColor,fsh.buyerFOB,fsh.intOrderQty,fsh.dblSMV,
fsh.dblPCScarton,fsh.dblCMvalue,fsh.dblPreorderFob,fsh.dblInvFob,fsh.dblFsaleFob,b.buyerCode
from firstsalecostworksheetheader fsh inner join orders o on 
o.intStyleId = fsh.intStyleId inner join buyers b on
b.intBuyerID = o.intBuyerID 
where fsh.intStatus=0
order by fsh.strOrderNo ";*/
	$deci =2;
				$sqlFSdetail = "select fsh.intStyleId,fsh.strOrderNo,fsh.strColor,fsh.buyerFOB,fsh.intOrderQty,fsh.dblSMV,
fsh.dblPCScarton,fsh.dblCMvalue,fsh.dblPreorderFob,fsh.dblInvFob,fsh.dblFsaleFob,b.buyerCode,
fss.dblInvoiceId,fss.strComInvNo,fss.intStatus,b.intinvFOB,fsh.dblInvoiceId as OCinvoiceNo,fsh.intExtraApprovalRequired
from firstsalecostworksheetheader fsh inner join orders o on 
o.intStyleId = fsh.intStyleId inner join buyers b on
b.intBuyerID = o.intBuyerID 
inner join  firstsale_shippingdata fss on fss.intStyleId = fsh.intStyleId
where (fsh.intStatus =1) or (fsh.intStatus=10 and fss.intStatus=0)
order by strOrderNo";			

		$resultFS = $db->RunQuery($sqlFSdetail);
		$rw=0;	
		//echo $sqlFSdetail;
						while($rowfs = mysql_fetch_array($resultFS))
						{
							$invStatus = $rowfs["intStatus"];
							$cls = ($invStatus=='1' ?'grid_raw_pink' :'grid_raw_white');
							$styleID = $rowfs["intStyleId"];
							$refID = $rowfs["dblInvoiceId"];
							$strUrl  = "costworksheet.php?id=1&StyleID=".$styleID.'&invoiceID='.$refID;
							$OCinvoiceNo = $rowfs["OCinvoiceNo"];
							
							//get Actual Data 2011-06-09-----------------
							$actFabconPc = '';
							$actThread = '';
							$actSMV = '';
							$actPocketConPc = '';
							$actDryWashPrice = '';
							$actWetWashPrice = ''; 
							
							$resActualData = getCWSactualData($styleID);
							while($rowA = mysql_fetch_array($resActualData))
							{
								$actFabconPc = round($rowA["dblFabricConpc"],$deci);
								$actThread = round($rowA["dblThreadConpc"],$deci);
								$actSMV = round($rowA["dblSMV"],$deci);
								$actPocketConPc = round($rowA["dblPocketConpc"],$deci);
								$actDryWashPrice = round($rowA["dblDryWashPrice"],$deci);
								$actWetWashPrice = round($rowA["dblWetWashPrice"],$deci); 
							
							}
							//end Actual Data 2011-06-09-----------------
							
							$shipQty = $rowfs["intOrderQty"]; 
							
							if($refID != '1')
							{
								$shipQty = getShipQty($styleID,$rowfs["strComInvNo"]);
								$res = getShippingData($styleID);
								
							}
																
							$preOrderNo = $rowfs["strOrderNo"];
							if($rowfs["strColor"] != '')
								$preOrderNo = $preOrderNo.'-'.$rowfs["strColor"];
							
						  ?>
                          <tr class="<?php echo $cls; ?>" onclick="rowclickColorChange(this,'tblPendingList')">
                          <?php 
						  	if($invStatus=='1')
							{
						  ?>
                          <td><?php echo $preOrderNo;//$rowfs["strOrderNo"].'-'.$rowfs["strColor"]; ?></td>
                          <?php 
						  }
						  else
						  {
						  ?>
                            <td id="<?php echo $styleID; ?>">
                           <!-- <a href="<?php //echo $strUrl; ?>" style="text-decoration:underline">-->
							<?php echo $preOrderNo;//$rowfs["strOrderNo"].'-'.$rowfs["strColor"]; ?>
                          <!--  </a>-->                            </td>
                            <?php 
							}
							?>
                            <td height="25"><?php echo $rowfs["strColor"]; ?></td>
                            <td><?php echo $shipQty;?></td>
                            <?php 
											
							
							if($refID != 1 && $rowfs["intExtraApprovalRequired"]==1)
							{
							?>
                             <td align="center"><img src="../../images/pdf.png" onclick="loadOrderContractRpt(<?php echo $styleID.','.$OCinvoiceNo; ?>);"/></td>
                            <?php 
							}
							else
							{
							?>
                            <td >&nbsp;</td>
                            <?php 
							}
							?>
                            <td align="center"><img src="../../images/pdf.png" onclick="loadCostWSReport(<?php echo $styleID; ?>);"/></td>
                         <?php   if($refID != 1)
							{
							?>
                             <td align="center"><img src="../../images/pdf.png" onclick="viewCVWSRpt(<?php echo $styleID.','.$refID; ?>);"/></td>
                            <?php 
							}
							else
							{
							?>
                            <td >&nbsp;</td>
                            <?php 
							}
							?>
                            <td>&nbsp;</td>
                             <?php   if($refID != 1)
							{
							?>
                             <td align="center"><img src="../../images/pdf.png" onclick="viewInvoiceRpt(<?php echo $styleID.','.$refID; ?>);"/></td>
                            <?php 
							}
							else
							{
							?>
                            <td >&nbsp;</td>
                            <?php 
							}
							?>
                            <?php 
						/*$sql_fabric = "select fsd.dblUnitPrice,fsd.reaConPc,fsd.strItemDescription
from firstsalecostworksheetdetail fsd 
 inner join matitemlist mil on  mil.intItemSerial = fsd.intMatDetailID
inner join matpropertyvaluesinitems mpi on mpi.intMatItemSerial=fsd.intMatDetailID
inner join matpropertyvalues mp on mp.intSubPropertyNo= mpi.intMatPropertyValueId
where fsd.intStyleId='$styleID'  and mp.strSubPropertyName='STD'  
and mil.intMainCatID=1";*/
									
								$result_fabric = getFabricDetails($styleID,1);
								while($row_fabric = mysql_fetch_array($result_fabric))
								{
									$fabConpc = round($row_fabric["reaConPc"],$deci);
									$fabUnitprice = round($row_fabric["dblUnitPrice"],$deci); 
									$fabMatId = $row_fabric["intMatDetailID"];
								}
								if($fabConpc < $actFabconPc )
									$tdCls = "bcgcolor-InvoiceCostICNA";
								else
									$tdCls = "bcgcolor-InvoiceCostFabric";
									
							$sql_FabInv = "select bgh.intBulkGrnNo,bgh.intYear 
from bulkgrnheader bgh inner join commonstock_bulkdetails cbd on 
bgh.intBulkGrnNo = cbd.intBulkGrnNo and bgh.intYear=cbd.intBulkGRNYear inner join commonstock_bulkheader cbh on
cbh.intTransferNo = cbd.intTransferNo and cbh.intTransferYear = cbd.intTransferYear
where cbh.intToStyleId='$styleID' and cbd.intMatDetailId='$fabMatId'";


				$res_Fabgrn= $db->RunQuery($sql_FabInv);
				$numrows = mysql_num_rows($res_Fabgrn);
				$numFab = mysql_num_rows($res_Fabgrn);
//check leftover allocation availability
	$sql_leftFab = "SELECT  LCD.intGrnNo AS intBulkGrnNo,LCD.intGrnYear AS intYear
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$styleID'  and 
						LCD.intMatDetailId = '$fabMatId' and LCH.intStatus=1 ";
		
		$res_Left_Fabgrn = $db->RunQuery($sql_leftFab);
		$numrows += mysql_num_rows($res_Left_Fabgrn);	
						
							if($numrows>1)
							{					
									
							?>
                            <td align="center"><img src="../../images/pdf.png" onclick="viewFabInvoice(<?php echo $styleID.','.$fabMatId; ?>);"/>                            </td>
                            <?php 
							}else if($numrows==1)
	{
		$file="";
		if($numFab==1)
			$rowFab = mysql_fetch_array($res_Fabgrn);
		else
			$rowFab = mysql_fetch_array($res_Left_Fabgrn);
		$url = "../../upload files/bulk grn/". $rowFab["intYear"].'-'.$rowFab["intBulkGrnNo"]."/";
		$serverRoot = $_SERVER['DOCUMENT_ROOT'];
		$dh = opendir($url);
		
		if(file_exists($url))
		{		
			while (($file = readdir($dh)) != false)
			{
			
				if($file!='.' && $file!='..')
				{
					$boo = true;
					$file1	= $url.rawurlencode($file);
				}
				else
				{
					$boo = false;
				}
			 
			}
			$folder = "../../upload files/bulk grn/". $rowFab["intYear"].'-'.$rowFab["intBulkGrnNo"];
			if(count(glob("$folder/*")) === 0)
				echo  "<td>&nbsp;</td>";	
			else
			 echo  "<td ><a href=\"$file1\" target=\"_blank\"><img src=\"../../images/pdf.png\" border=\"0\" /></a></td>";		 
					 	
		}
		else
		{
		?>
         <td>&nbsp;</td>
        <?php
			}
		//echo 'pass'.$styleID;
	}
	else
	{
			 ?> 
             <td>&nbsp;</td>
             <?php 
			 }
			 ?>    
                            <td class="bcgcolor-InvoiceCostFabric"><?php echo $fabUnitprice; ?></td>
                            <td class="bcgcolor-InvoiceCostFabric"><?php echo $fabConpc; ?></td>
                             <td class="<?php echo $tdCls; ?>"><?php echo ($actFabconPc==0?'':$actFabconPc); ?></td>
                            <?php 
							$noOfPockRecords=0;
						/*$sql_pocket = "select fsd.dblUnitPrice,fsd.reaConPc
from firstsalecostworksheetdetail fsd 
 inner join matitemlist mil on  mil.intItemSerial = fsd.intMatDetailID
inner join matpropertyvaluesinitems mpi on mpi.intMatItemSerial=fsd.intMatDetailID
inner join matpropertyvalues mp on mp.intSubPropertyNo= mpi.intMatPropertyValueId
where fsd.intStyleId='$styleID'  and mp.strSubPropertyName='POC'  
and mil.intMainCatID=1";*/	
							$result_pocket = getFabricDetails($styleID,'2');
							while($row_pocket = mysql_fetch_array($result_pocket))
							{
								$fsPocConpc = round($row_pocket["reaConPc"],$deci);
								$fsPocUnitprice =round($row_pocket["dblUnitPrice"],$deci);
								$pocMatDetailId = $row_pocket["intMatDetailID"];  
							}		
							if(($fsPocConpc < $actPocketConPc))
									$tdCls = "bcgcolor-InvoiceCostICNA";
								else
									$tdCls = "bcgcolor-InvoiceCostPocketing";
							?>
                            <td class="bcgcolor-InvoiceCostPocketing"><?php echo ($fsPocUnitprice==0?'':$fsPocUnitprice); ?></td>
                            <td class="bcgcolor-InvoiceCostPocketing"><?php echo ($fsPocConpc==0?'':$fsPocConpc); ?></td>
                     
                            <td class="<?php echo $tdCls; ?>"><?php echo $actPocketConPc; ?></td>
                            <?php 
							$sql_pocInv = "select bgh.intBulkGrnNo,bgh.intYear 
from bulkgrnheader bgh inner join commonstock_bulkdetails cbd on 
bgh.intBulkGrnNo = cbd.intBulkGrnNo and bgh.intYear=cbd.intBulkGRNYear inner join commonstock_bulkheader cbh on
cbh.intTransferNo = cbd.intTransferNo and cbh.intTransferYear = cbd.intTransferYear
where cbh.intToStyleId='$styleID' and cbd.intMatDetailId='$pocMatDetailId'";
//echo $pocMatDetailId.' '.$styleID;
	$res_POCgrn= $db->RunQuery($sql_pocInv);
	
	$POCnumrows = mysql_num_rows($res_POCgrn);
	
	if($POCnumrows>1)
	{
	?>
   <td align="center"><img src="../../images/pdf.png" onclick="viewFabInvoice(<?php echo $styleID.','.$pocMatDetailId; ?>);"/>                            </td>
    <?php
	}
	else if($POCnumrows==1)
	{
		$rowPOCGrn = mysql_fetch_array($res_POCgrn);	
			$file = "";
			$url = "../../upload files/bulk grn/". $rowPOCGrn["intYear"].'-'.$rowPOCGrn["intBulkGrnNo"]."/";
			
			$serverRoot = $_SERVER['DOCUMENT_ROOT'];
			$dh = opendir($url);
			
			if(file_exists($url))
			{
			
				while (($file = readdir($dh)) != false)
				{
			
				if($file!='.' && $file!='..')
				{
					$boo = true;
					$file1	= $url.rawurlencode($file);
				}
				else
				{
					$boo = false;
				}
			 
			}
			$folder = "../../upload files/bulk grn/". $rowPOCGrn["intYear"].'-'.$rowPOCGrn["intBulkGrnNo"];
			if(count(glob("$folder/*")) === 0)
				echo  "<td>&nbsp;</td>";	
			else
			 echo  "<td ><a href=\"$file1\" target=\"_blank\"><img src=\"../../images/pdf.png\" border=\"0\" /></a></td>";	
			}
			else
			{
			?>
              <td>&nbsp;</td>        
            <?php
			}
	}
	else
	{
							?>
             <td>&nbsp;</td>                
  <?php } ?>
                            <td><?php 
							$threadConpc = round(getThreadConpc($styleID),$deci);
							echo ($threadConpc==0?'':$threadConpc); ?></td>

                            <td><?php echo ($actThread==0?'':$actThread); ?></td>
                            <?php 
								$dryWashprice = round(getWashprice($styleID,'WASHING - DRY COST'),$deci);
								$wetWashPrice = round(getWashprice($styleID,'WASHING - WET COST'),$deci);
								
								$tdDryCls = 'bcgcolor-InvoiceCostService';
								if(($dryWashprice <$actDryWashPrice))
									$tdDryCls = 'bcgcolor-InvoiceCostICNA';
									
								$tdWetCls = 'bcgcolor-InvoiceCostService';
								if(($wetWashPrice <$actWetWashPrice))
									$tdWetCls = 'bcgcolor-InvoiceCostICNA';	
								
							?>
                            <td class="bcgcolor-InvoiceCostService"><?php echo ($dryWashprice==0?'':$dryWashprice); ?></td>
                            <td class="<?php echo $tdDryCls; ?>"><?php echo ($actDryWashPrice==0?'':$actDryWashPrice); ?></td>
                            <td class="bcgcolor-InvoiceCostService"><?php echo ($wetWashPrice==0?'':$wetWashPrice); ?></td>
                            <td class="<?php echo $tdWetCls; ?>"><?php echo ($actWetWashPrice==0?'':$actWetWashPrice); ?></td>
                            <?php 
							$tdSMV ='bcgcolor-interjobAllo';
							if($actSMV != '' &&($actSMV !=$rowfs["dblSMV"]))
								$tdSMV ='bcgcolor-InvoiceCostICNA';
							?>
                            <td><?php echo $rowfs["dblPCScarton"];	 ?></td>
                            <td><?php echo $rowfs["dblCMvalue"];	 ?></td>
                            <td class="bcgcolor-interjobAllo"><?php echo $rowfs["dblSMV"];	 ?></td>
                             <td class="<?php echo $tdSMV; ?>"><?php echo ($actSMV==0?'':$actSMV); ?></td>
                            <td class="bcgcolor-CostWSBelts"><?php
							$preorderFOB = round($rowfs["dblPreorderFob"],$deci);
							 $invFob= round(($rowfs["intinvFOB"]==1?$rowfs["dblInvFob"]:$preorderFOB),$deci);//$rowfs["dblInvFob"];	
							 echo $invFob;
							  ?></td>
                            <td class="bcgcolor-CostWSBelts"><?php echo round($rowfs["dblFsaleFob"],$deci);	 ?></td>
                            <td class="bcgcolor-CostWSBelts"><?php 
							$fobDiff = ($invFob - $rowfs["dblFsaleFob"])/$invFob*100;
							echo round($fobDiff,$deci);	 ?></td>
                            <td><?php echo $rowfs["buyerCode"]; ?></td>
                            <?php 
							$tdFOB = 'bcgcolor-CostWSBelts';
							
							$comFOB = round(getComInvFOB($styleID,$rowfs["strComInvNo"]),$deci); 
							$buyerFOB = round($rowfs["buyerFOB"],$deci);
							
						$tdFOB = ($preorderFOB != $invFob ?'bcgcolor-InvoiceCostICNA':'bcgcolor-CostWSBelts');	
							?>
                            <td class="<?php echo $tdFOB; ?>"><?php echo $preorderFOB; ?></td>
                    <?php $tdFOB = ($comFOB != $invFob ?'bcgcolor-InvoiceCostICNA':'bcgcolor-CostWSBelts');?>
                            <td class="<?php echo $tdFOB; ?>"><?php 	echo $comFOB; ?></td>
                 <?php $tdFOB = ($buyerFOB != $invFob ?'bcgcolor-InvoiceCostICNA':'bcgcolor-CostWSBelts');?>                                   <td class="<?php echo $tdFOB ?>"><?php echo $buyerFOB; ?></td>
                            
                            <td><?php echo $refID; ?></td>
                          
  
  <?php
  $file = "";
			$url = "../../upload files/cws/". $styleID."/BPO/";
			
			$serverRoot = $_SERVER['DOCUMENT_ROOT'];
			$dh = opendir($url);
			
			if(file_exists($url))
			{
			
				while (($file = readdir($dh)) != false)
			{
			
				if($file!='.' && $file!='..')
				{
					$boo = true;
					$file1	= $url.rawurlencode($file);
				}
				else
				{
					$boo = false;
				}
			 
			}
			$folder = "../../upload files/cws/". $styleID."/BPO";
			if(count(glob("$folder/*")) === 0)
				echo  "<td>&nbsp;</td>";	
			else
			 echo  "<td ><a href=\"$file1\" target=\"_blank\"><img src=\"../../images/pdf.png\" border=\"0\" /></a></td>";	
			}
			else
			{
               ?>
               <td>&nbsp;</td>
               <?php 
			 }
			   ?>
                            <?php           if($manageCWSapproval) {?>
                            <td ><input name="" type="checkbox" value="" onclick="approveCWS(this);"/></td>
                            <?php } 
							if($manageCWSreject){
							$cwsAppStatus = getCWSApprovalStatus($styleID);
								if($cwsAppStatus == 1)
								{
							?>
                            <td ><input name="" type="checkbox" value="" onclick="rejectCWS(this);"/></td>
                            <?php
								} 
								else
								{
								?>
                                <td>&nbsp;</td>
                                <?php
								}
							}
							?>
                          </tr>
                          <?php
						  	$rw++; 
						  }
						  ?>
                        </table><!--</div>--></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
			    <br />
					

				</div>
				
				<!-----------------------------------------------APPROCED WORK SHEET------------------------------------------>
				<div id="tabs-3">
                <table width="800" border="0" cellspacing="0" cellpadding="0">
                      
                      
                       <tr>
                        <td><table width="93%" border="0" cellspacing="0" cellpadding="1" class="bcgl1">
                          <tr>
                          <td class="normalfnt">&nbsp;Order No</td>
                           <td><input type="text" name="txtAppOrderNo" id="txtAppOrderNo" onkeypress="enableEnterSubmitApprovDetails(event)" style="width:250px;" /></td>
                            <td colspan="2" class="normalfnt">Tax Invoice Status</td>
                             <td class="normalfnt"><select name="cboTaxStatus" id="cboTaxStatus" style="width:122px;" class="txtbox">
                              <option value="" selected="selected">All</option>
                             <option value="0">Pending</option>
                             <option value="1">Approved</option>
                             </select>                             </td>
                             <td class="normalfnt">Order Contract</td>
                             <td class="normalfnt"><select name="cboOC" id="cboOC" style="width:122px;">
                             <option value="" selected="selected">All</option>
                             <option value="0">Pending</option>
                             <option value="1">First Approved</option>
                              <option value="2">Second Approved</option>
                             </select></td>
                          </tr>	
                          <tr>
                            <td width="9%" class="normalfnt">&nbsp;Buyer </td>
                            <td width="26%" class="normalfnt"><select name="cboAppBuyer" id="cboAppBuyer" style="width:252px;" class="txtbox">
                             <option value="" >Select One</option>
                    <?php
	$SQL = " select intBuyerID, strName from buyers where intStatus=1 order by strName ";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intBuyerID"] ."\">" . $row["strName"] ."</option>" ;
	}
?>
                            </select>                            </td>
                            <td width="2%" class="normalfnt"><input type="checkbox" name="chkDate" id="chkDate" onclick="enableApprovDate(this);" /></td>
                            <td width="14%" class="normalfnt">Approved Date From</td>
                            <td width="14%"><input type="text" name="txtAppDfrom" id="txtAppDfrom" style="width:120px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" disabled="disabled"/><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                            <td width="10%" class="normalfnt">Date To</td>
                            <td width="16%" class="normalfnt"><input type="text" name="txtAppDateTo" id="txtAppDateTo" style="width:120px;" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  disabled="disabled"/><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
                            <td width="9%"><img src="../../images/search.png" alt="" width="80" height="24" onclick="loadApprovedCWS('appCWSlist');" /></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr><td height="10"></td></tr>
                      <tr>
                        <td>
				<!--	<div style="overflow:scroll; height:350px; width:1200px;">-->
					<table width="1200" cellspacing="1" cellpadding="0" id="appCWSlist" bgcolor="#CCCCFF">
                    <thead>
                          <tr class="mainHeading4">
                            <th >Order No</th>
                            <th >Color</th>
                            <th >Ship Qty</th>
                            <th >OC</th>
                            <th >CVW</th>
                            <th >CVWS</th>
                            <th >WSTI</th>
                            <th >STI</th>
                            <th >FI</th>
                            <th >Fabric Price</th>
                            <th >Fabric Cons</th>
                            <th >Fab Act Cons</th>
                            <th >Pocketing Price</th>
                            <th >Pocketing Cons</th>
                            <th >Poc Act cons</th>
                             <th >PI</th>
                            <th >Thread cons</th>
                             <th >Thread Act cons</th>
                            <th >Dry Washing Price</th>
                             <th >Dry Act Washing Price</th>
                              <th >Wet Washing Price</th>
                               <th >Wet Act Washing Price</th>
                            <th >Pcs Per CTN</th>
                            <th >CM</th>
                            <th >SMV</th>
                             <th >Act SMV</th>
                            <th >Inv C. FOB</th>
                            <th >FS FOB</th>
                            <th >Diff %</th>
                            <th >Buyer</th>
                            <th >Pre Cost FOB</th>
                            <th >Com Inv FOB</th>
                            <th >BPO FOB</th>
                            <th >Ref Id</th>
                           
                            <th >BPO</th>
                            <?php 
								/*if($manageCWSRevise)
								{*/
							?>
                           <!-- <td class="grid_header">Revise</td>-->
                           <?php 
						   		//}
						   ?>
                          </tr>
                          </thead>
                          	<tbody>
								
							</tbody>
                         
                        </table>
					<!--</div>-->
                    
                    </td></tr></table>
				  <br />
					
				</div>
			</div>	
		<!--</div>
	</div>
</div>-->
</td>
	</tr>
</table>
<?php 
function getShipQty($styleID,$commInvNo)
{
	$eshipDB = new eshipLoginDB();
	
	$sql = " select cid.dblQuantity from commercial_invoice_detail cid inner join shipmentplheader plh on
cid.strPLNo = plh.strPLNo  where strInvoiceNo='$commInvNo' and plh.intStyleId='$styleID' ";
	
	$result_qty= $eshipDB->RunQuery($sql);
	$rowQ = mysql_fetch_array($result_qty);
	
	return $rowQ["dblQuantity"];
	
}
function getComInvFOB($styleID,$commInvNo)
{
	$eshipDB = new eshipLoginDB();
	
	$sqlF = "select cid.dblUnitPrice from commercial_invoice_detail cid inner join shipmentplheader plh on
cid.strPLNo = plh.strPLNo  where strInvoiceNo='$commInvNo' and plh.intStyleId='$styleID' ";
	
	$result_fob= $eshipDB->RunQuery($sqlF);
	$rowF = mysql_fetch_array($result_fob);
	
	return $rowF["dblUnitPrice"];
	
}

function getShippingData($styleId)
{
global $db;
	
	$sql = "select * from firstsale_shippingdata where intStyleId='$styleId' ";
	return $db->RunQuery($sql);
}

function getWashprice($styleID,$itemLike)
{
	global $db;
	
	$sql = "select fsd.dblUnitPrice as WashPrice
from firstsalecostworksheetdetail fsd inner join matitemlist mil on mil.intItemSerial=fsd.intMatDetailID
where mil.strItemDescription like'%$itemLike%' and fsd.intStyleId='$styleID'";
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["WashPrice"];
}

function getCWSactualData($styleID)
{
	global $db;
	
	$sql = "select * from firstsale_actualdata where intStyleId='$styleID'";
	return $db->RunQuery($sql);
}

function getFabricDetails($styleID,$category)
{
	global $db;
	
	
	$sql = "select fsd.dblUnitPrice,fsd.reaConPc,fsd.intMatDetailID
from firstsalecostworksheetdetail fsd inner join invoicecostingdetails id on id.strItemCode=fsd.intMatDetailID and 
id.intStyleId = fsd.intStyleId
where id.strType='$category' and fsd.intStyleId='$styleID'";
	return $db->RunQuery($sql);
}
function getThreadConpc($styleID)
{
	global $db;
	$threadSubcat = getThreadSubCatId();
	
	$sql = "select fsd.reaConPc from firstsalecostworksheetdetail fsd inner join matitemlist mil on 
fsd.intMatDetailID = mil.intItemSerial
where mil.intSubCatID='$threadSubcat' and fsd.intStyleId='$styleID' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["reaConPc"];
}
function getThreadSubCatId()
{
	global $db;
	
	$sql = "select strValue from firstsale_settings where strFieldName='intThreadSubcatID' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strValue"];
}
function getCWSApprovalStatus($styleID)
{
	global $db;
	$sql = " select intStatus from firstsalecostworksheetheader where intStyleId='$styleID' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["intStatus"];
}
?>
</body>
 <script type="text/javascript" src="../../js/jquery.fixedheader.js"></script>
 <script language="javascript" type="text/javascript">
var manageCWSsendToapproval ='<?php echo $manageCWSsendToapproval; ?>';
var manageCWSRevise = '<?php echo $manageCWSRevise; ?>';
var tblmainWidth = parseInt(document.getElementById('tblMain').offsetWidth);
	fix_header('tblPendingList',tblmainWidth,530);
</script>	
</html>
