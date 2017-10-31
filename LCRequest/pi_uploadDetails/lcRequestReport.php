<?php 
//$piNoList = $_GET["piNo"];
//$piNo = explode("~",$piNoList);
include "../../Connector.php";	

$lcNo = $_GET["lcNo"];
$arrLcNo = explode('/',$lcNo);
 $sql_s = "select intStatus from lcrequest_pialloheader where intLCRequestNo='$arrLcNo[1]' and intRequestYear='$arrLcNo[0]'
";
$result_s = $db->RunQuery($sql_s);
$rowS = mysql_fetch_array($result_s);
$intStatus = $rowS["intStatus"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>LC Request Form</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css"/>
<script language="javascript" src="../../javascript/script.js"></script>
<script language="javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script src="../../js/jquery-ui-1.8.9.custom.min.js"></script>

<script src="lcRequest.js" ></script>
<script src="../../javascript/calendar/calendar.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" language="javascript" type="text/javascript" ></script>
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

<body>
<table width="906" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="head2BLCK">LC Request Form </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="906" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000" align="center" id="tblReport">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="35">P/I No</th>
        <th width="61">Fabric Mill</th>
        <th width="58"><p>&nbsp;</p>
          <p>Fabric Ref (Fabric ID)</p></th>
        <th width="44">Buyer</th>
        <th width="48">Style Ref</th>
        <th width="76">Repeating style or No</th>
        <th width="58">Buyer PO No</th>
        <th width="63">Export Qty(Pcs)</th>
        <th width="42">Conpc</th>
        <th width="82">Total Requirement-YDS</th>
        <th width="40">PI Qty-(YDS)</th>
        <th width="54">Variance</th>
        <th width="43">Fabric Price</th>
        <th width="45">Import Term</th>
        <th width="43">Fabric ETA</th>
        <th width="52">Product In Line Date</th>
        <th width="62">Garments ETD Date</th>
        <th width="62">Whether same ID is in leftover stock</th>
        <th width="62">Remarks</th>
      </tr>
      <?php 
	 	$pub_dateId=1;
			$firstRow = true;
			$totExportQty =0;
			$totPIQty =0;
			$sql = "select bpo.strPINO,s.strTitle,lcd.intMatDetailID,b.buyerCode,o.strOrderNo,o.strStyle,dd.dblQty,lcd.reaConPc,
lcd.dblUnitPrice,st.strShipmentTerm,date(lcd.dtmProdutLineDate) as prodDate,lcd.intStyleId,
date(bpo.dtmETA) as PoETA,date(dd.dtDateofDelivery) as deliveryDate,lcd.strRemarks,bpo.intYear,bpo.intBulkPoNo
from lcrequestdetail lcd 
inner join bulkpurchaseorderheader bpo on lcd.intBulkPoNo = bpo.intBulkPoNo and lcd.intYear= bpo.intYear
inner join suppliers s on s.strSupplierID = bpo.strSupplierID
inner join orders o on o.intStyleId = lcd.intStyleId
inner join buyers b on b.intBuyerID = o.intBuyerID
inner join deliveryschedule dd on dd.intDeliveryId = lcd.intDelDateId
inner join shipmentterms st on st.strShipmentTermId = bpo.intShipmentTermID
inner join lcrequest_piallodetails lc on lc.intBulkPoNo= lcd.intBulkPoNo and lc.intYear= lcd.intYear
where lc.intLCRequestNo='$arrLcNo[1]' and lc.intRequestYear='$arrLcNo[0]' ";
echo $sql;
$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$totExportQty +=$row["dblQty"]; 
		$PIQty = $row["dblQty"]*$row["reaConPc"];
		$totPIQty +=$PIQty;
		$currPINo = $row["strPINO"]; 
		$poQty	= GetPOQty($row["intYear"],$row["intBulkPoNo"],$row["intMatDetailID"]);
		$prodDate = ($row["prodDate"] == '0000-00-00'?'':$row["prodDate"]);
	   if($firstRow == true)
	   {
	   		$chkLeftoverAv = checkLeftoverAvailability($row["intMatDetailID"]);
			
	   ?>
      <tr bgcolor="#FFFFFF">
        <td class="normalfnt" nowrap height="20" id="<?php echo $row["intBulkPoNo"];  ?>"><?php echo $row["strPINO"]; ?></td>
        <td class="normalfnt" nowrap id="<?php echo $row["intYear"];  ?>"><?php echo $row["strTitle"]; ?></td>
        <td class="normalfnt" id="<?php echo $row["intMatDetailID"];  ?>"><?php echo $row["intMatDetailID"]; ?></td>
        <td class="normalfnt" id="<?php echo $row["intStyleId"];  ?>"><?php echo $row["buyerCode"]; ?></td>
        <td class="normalfnt" nowrap><?php echo $row["strStyle"] ?></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt" nowrap><?php echo $row["strOrderNo"] ?></td>
        <td class="normalfntRite"><?php echo $row["dblQty"] ?></td>
        <td class="normalfntRite"><?php echo $row["reaConPc"] ?></td>
        <td class="normalfntRite"><?php echo number_format($PIQty,4); ?></td>
        <td class="normalfntRite"><?php echo number_format($poQty,4);?></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfntRite"><?php echo $row["dblUnitPrice"] ?></td>
        <td class="normalfnt"><?php echo $row["strShipmentTerm"] ?></td>
        <td class="normalfnt"><?php echo $row["PoETA"]; ?></td>
        <td class="normalfnt" nowrap><input type="text" name="txtDfrom" id="<?php echo $pub_dateId++; ?>" style="width:90px;" onMouseDown="DisableRightClickEvent();" value="<?php echo $prodDate; ?>" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  onKeyDown="" <?php if($intStatus !=1) {?>  disabled <?php } ?> onBlur="updateProdLineDate(this);"/><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
        <td class="normalfnt"><?php echo $row["deliveryDate"]; ?></td>
         <td class="normalfnt"><?php echo ($chkLeftoverAv == '1'?'Available':'Not Available'); ?></td>
        <td class="normalfnt"><?php echo $row["strRemarks"]; ?></td>
      </tr>
      <?php 
	  $firstRow = false;
	  $prePINo = $row["strPINO"]; 
	  }
	  else
	  {
	  		if($prePINo!= $currPINo)
			{
	  ?>
       <tr bgcolor="#FFFFFF">
        <td class="normalfnt" nowrap height="20" id="<?php echo $row["intBulkPoNo"];  ?>"><?php echo $row["strPINO"]; ?></td>
        <td class="normalfnt" nowrap id="<?php echo $row["intYear"];  ?>"><?php echo $row["strTitle"]; ?></td>
        <td class="normalfnt" id="<?php echo $row["intMatDetailID"];  ?>"><?php echo $row["intMatDetailID"]; ?></td>
        <td class="normalfnt" id="<?php echo $row["intStyleId"];  ?>"><?php echo $row["buyerCode"]; ?></td>
        <td class="normalfnt" nowrap><?php echo $row["strStyle"] ?></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt" nowrap><?php echo $row["strOrderNo"] ?></td>
        <td class="normalfntRite"><?php echo $row["dblQty"] ?></td>
        <td class="normalfntRite"><?php echo $row["reaConPc"] ?></td>
        <td class="normalfntRite"><?php echo number_format($PIQty,4); ?></td>
        <td class="normalfntRite"><?php echo number_format($poQty,4);?></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfntRite"><?php echo $row["dblUnitPrice"] ?></td>
        <td class="normalfnt"><?php echo $row["strShipmentTerm"] ?></td>
        <td class="normalfnt"><?php echo $row["PoETA"]; ?></td>
        <td class="normalfnt"><input type="text" name="txtDfrom" id="<?php echo $pub_dateId++; ?>" style="width:90px;" onMouseDown="DisableRightClickEvent();" value="<?php echo $prodDate; ?>" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  onKeyDown=""  <?php if($intStatus !=1) {?>  disabled <?php } ?>/><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
        <td class="normalfnt"><?php echo $row["deliveryDate"]; ?></td>
         <td class="normalfnt"><?php echo ($chkLeftoverAv == '1'?'Available':'Not Available'); ?></td>
        <td class="normalfnt"><?php echo $row["strRemarks"]; ?></td>
      </tr>
      <?php
	  		}
			else
			{
			?>
             <tr bgcolor="#FFFFFF">
        <td class="normalfnt" height="20" id="<?php echo $row["intBulkPoNo"];  ?>">&nbsp;</td>
        <td class="normalfnt" id="<?php echo $row["intYear"];  ?>">&nbsp;</td>
        <td class="normalfnt" id="<?php echo $row["intMatDetailID"];  ?>">&nbsp;</td>
        <td class="normalfnt" id="<?php echo $row["intStyleId"];  ?>">&nbsp;</td>
        <td class="normalfnt" nowrap><?php echo $row["strStyle"] ?></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt" nowrap><?php echo $row["strOrderNo"] ?></td>
        <td class="normalfntRite"><?php echo $row["dblQty"] ?></td>
        <td class="normalfntRite"><?php echo $row["reaConPc"] ?></td>
        <td class="normalfntRite"><?php echo number_format($PIQty,4); ?></td>
        <td class="normalfnt"><?php echo number_format($poQty,4);?></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfntRite"><?php echo $row["dblUnitPrice"] ?></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt"><?php echo $row["PoETA"]; ?></td>
        <td class="normalfnt"><input type="text" name="txtDfrom" id="<?php echo $pub_dateId++; ?>" style="width:90px;" onMouseDown="DisableRightClickEvent();" value="<?php echo $prodDate; ?>" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"  onKeyDown=""  <?php if($intStatus !=1) {?>  disabled <?php } ?>/><input type="text" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%Y-%m-%d');"></td>
        <td class="normalfnt"><?php echo $row["deliveryDate"]; ?></td>
         <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt"><?php echo $row["strRemarks"]; ?></td>
      </tr>
            <?php
			}
	  }
	  
	  $prePINo = $currPINo;
	 }
	 if($totExportQty>0)
	 {
	 ?>
     <tr bgcolor="#FFFFFF">
     <td colspan="7">&nbsp;</td>
     <td class="normalfntRite"><?php echo number_format($totExportQty,0); ?></td>
      <td >&nbsp;</td>
      <td class="normalfntRite"><?php echo number_format($totPIQty,4); ?></td>
     <td colspan="9">&nbsp;</td>
     </tr>
     <?php
	 }
// }
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <?php 
  
	if($intStatus == 0)
	{
  ?>
  <tr bgcolor="#D6E7F5" id="comfirmLC">
    <td align="center"><img src="../images/conform.png" width="115" height="24" onClick="updateSendToAppStatus(<?php echo $arrLcNo[0]; ?>,<?php echo $arrLcNo[1] ?>);"></td>
  </tr>
  <?php 
  }
  ?>
  <?php 
  
	if($intStatus == 1)
	{
  ?>
  <tr bgcolor="#D6E7F5" id="comfirmProdDate" >
    <td align="center"><img src="../images/approve.png" width="113" height="24" onClick="updateProdDateDetails(<?php echo $arrLcNo[0]; ?>,<?php echo $arrLcNo[1] ?>)"><img src="../images/reject.png" width="102" height="24" onClick="updateRejectStatus(<?php echo $arrLcNo[0]; ?>,<?php echo $arrLcNo[1] ?>,'app1');"></td>
  </tr>
  <?php 
  }
  ?>
  <?php 
  
	if($intStatus == 2)
	{
  ?>
  <tr bgcolor="#D6E7F5" id="comfirmLCRequest">
    <td align="center"><img src="../images/approve.png" width="113" height="24" onClick="confirmLCRequest(<?php echo $arrLcNo[0]; ?>,<?php echo $arrLcNo[1] ?>)"><img src="../images/reject.png" width="102" height="24" onClick="updateRejectStatus(<?php echo $arrLcNo[0]; ?>,<?php echo $arrLcNo[1] ?>,'app2');"></td>
  </tr>
  <?php 
  }
  ?>
</table>
<?php 
function checkLeftoverAvailability($matDetailId)
{
	global $db;
	$sql = "select COALESCE(sum(dblQty),0) as qty from stocktransactions_leftover where intMatDetailId='$matDetailId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	if($row["qty"] >0)
	{
		$pendingQty = getPendingAlloQty($matDetailId);
		$balQty = $row["qty"] -$pendingQty;
		if($balQty >0)
			return true;
		else
			return false;	
	}
	else
	{
		return false;
	}
}

function  getPendingAlloQty($matDetailId)
{
	global $db;
	$sql = "SELECT COALESCE(sum(LCD.dblQty),0) as LeftAlloqty
FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
LCH.intTransferNo = LCD.intTransferNo AND 
LCH.intTransferYear = LCD.intTransferYear
WHERE LCD.intMatDetailId = '$matDetailId' and LCH.intStatus=0 ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["LeftAlloqty"];
}

function GetPOQty($poYear,$poNo,$matDetailId)
{
global $db;
$qty=0;
	$sql_po="select dblQty from bulkpurchaseorderdetails where intYear='$poYear' and intBulkPoNo='$poNo' and intMatDetailId='$matDetailId';";
	$result_po=$db->RunQuery($sql_po);
	while($row_po=mysql_fetch_array($result_po))
	{
		$qty	= $row_po["dblQty"];
	}
return $qty;
}
?>

</body>
</html>
