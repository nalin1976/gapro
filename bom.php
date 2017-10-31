<?php
session_start();
include "authentication.inc";
include "Connector.php";
$backwardseperator ='';
$reqStyleID = $_POST["cboOrderNo"];
$reqSRNO = $_POST["cboSR"];
$isPurchased = false;
$styleId = $_POST["cboStyles"];
//$canIncreaseItemUnitprice=true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bill of Material</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />

<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/buyerPO.js"></script>

<script type="text/javascript" src="editStyleRatio_Popup/editStyleRatio_Popup-js.js"></script>
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<!--<script type="text/javascript" src="js/jquery-ui-1.8.9.custom.min.js"></script>-->

<link href="js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />

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
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script type="text/javascript">
var factoryID = <?php

 echo $_SESSION["CompanyID"]; 
 ?>;
var UserID = <?php
 echo $_SESSION["UserID"]; 
 ?>;
 
var EscPercentage = '<?php

$xml = simplexml_load_file('config.xml');
$esc = $xml->companySettings->ESCPercentage;
echo $esc;

$EnableAdvancedBuyePO = $xml->BuyerPO->EnableAdvanceMode;

?>';

var consumptionDecimalLength = <?php
$consumptionDecimalLength = $xml->SystemSettings->ConsumptionDecimalLength;
echo $consumptionDecimalLength;
?>;

var maxWastage = '<?php 
$maxWasatePC = $xml->PreOrder->MaxWastagePercentage;
echo $maxWasatePC;
?>'; 
var serverDate = new Date();
serverDate.setYear(parseInt(<?php
echo date("Y"); 
?>));
serverDate.setMonth(parseInt(<?php
echo date("m"); 
?>,10)-1);
serverDate.setDate(parseInt(<?php
echo date("d")+1; 
?>,10));


</script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="javascript/bom.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<script type="text/javascript" src="allocation_inbom/allocation.js"></script>


</head>

<body onload="calculateCMValue();ScrollToElement(200,200);">
<?php
	

//die();


if ($_POST["cboOrderNo"] != NULL)
{
	$SQL = "select intSRNO from specification where intStyleId = '$reqStyleID'";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$reqSRNO =  $row["intSRNO"];
	}
}
else
{
	$SQL = "select intStyleId from specification where intSRNO = '$reqSRNO'";
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$reqStyleID =  $row["intStyleId"];
	}
}

$SQL = "select orders.strStyle,specification.intStyleId, specification.dblQuantity , specification.intSRNO,specification.intStyleId,orders.strDescription,buyers.strName,orders.reaExPercentage,orders.reaSMV, orders.reaFOB, orders.reaFinPercntage, orders.reaUPCharges, orders.reaECSCharge, orders.reaSMVRate, orders.intBuyerID, orders.dblFacProfit, orders.strOrderNo from specification, orders, buyers where specification.intStyleId = orders.intStyleId AND orders.intBuyerID = buyers.intBuyerID AND specification.intStyleId = '" .  $reqStyleID . "';";


$result = $db->RunQuery($SQL);

while($row = mysql_fetch_array($result))
{
	$StyleNo =  $row["strStyle"];
	$styleId =  $row["intStyleId"];
	$SCNo =  $row["intSRNO"];
	$BuyerName=  trim($row["strName"]);
	$BuyerID=  $row["intBuyerID"];
	$StyleName=  $row["strDescription"];
	$OrderQty =  $row["dblQuantity"];
	$EXPercentage =  $row["reaExPercentage"];
	
	$preOrderFOB = $row["reaFOB"];
	$fiancePctng =  $row["reaFinPercntage"];
	$upcharge = $row["reaUPCharges"]; 
	$escCharge = $row["reaECSCharge"];
	
	$SMV = $row["reaSMV"];
	$SMVRate = $row["reaSMVRate"];
	
	$CMV = round($SMV*$SMVRate,4);
	$profit = $row["dblFacProfit"];
	$strOrderNo = $row["strOrderNo"];
}
	
?>
<script type="text/javascript">

var fob = <?php echo $preOrderFOB; ?>;
var currentBuyerID = <?php echo $BuyerID; ?>;
var currentBuyerName = "<?php echo $BuyerName;?> ";
var escCharge = '<?php echo $escCharge ; ?>';
var cmvInPreoder = '<?php echo $CMV; ?>';
//alert(currentBuyerID);
</script>

<form name="frmbom" id="frmbom" action="bom.php" method="post">
  <tr>
    <td width="954"><?php include $backwardseperator.'Header.php'; ?></td>
  </tr>
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.9.custom.min.js"></script>  
<table width="1292" border="0" align="center" class="bcgl1">
  <tr>
     <td height="27" bgcolor="#550000" class="tophead"><div align="center" class="mainHeading">BOM - Bill of Material</div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="64" class="normalfnt">Style No</td>
        <td width="342">
        <input type="text" name="txtStyleNo" id="txtStyleNo" value="<?php echo $StyleNo; ?>" disabled="disabled" maxlength="30" size="30" /></td>
        <td width="39" style="visibility:hidden"><label class="normalfnth2" id="lblStyleNo"><?php echo $styleId; ?></label></td>
        <td width="91" class="normalfnt">SC No.</td>
        <td width="180">        <input type="text" name="txtSCNo" id="txtSCNo" disabled="disabled" maxlength="5"  value="<?php echo $SCNo;?>" style="width:120px;"/></td>
        <td  width="64" class="normalfnt">Buyer</td>
        <td class="normalfnth2" width="199">
  <input type="text" name="txtBuyerName" id="txtBuyerName" disabled="disabled" maxlength="30"  style="width:150px;" value="<?php echo $BuyerName; ?>" /></td>
        <td width="6">&nbsp;</td>
        <td width="261" rowspan="3" valign="top"><table style="visibility:visible;" width="100%" height="83" border="0">
          <tr>
            <td width="100%" colspan="2" class="tablezRED"><table width="253" border="0">
                  <tr>
                  <td width="58">Style No</td>
                 <!-- <td width="150"><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="getScNo();getOrderNo();">-->
                  <td width="150"><select name="cboStyles" class="txtbox" style="width:150px" id="cboStyles" onchange="getStylewiseOrderNoNew();getScNo();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	/*$SQL = "select specification.intStyleId,orders.strStyle from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11;";*/
	$SQL = "select distinct orders.strStyle,orders.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by  orders.strStyle;";
	$result = $db->RunQuery($SQL);
	
	
	/*while($row = mysql_fetch_array($result))
	{
		if ($reqStyleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}*/
	while($row = mysql_fetch_array($result))
	{
		if ($styleId==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>" ;
	}
	?>
                  </select></td>
                  <td width="31"><span class="normalfnt"><img src="images/go.png" alt="go" width="30" height="22" class="mouseover" onclick="reloadPreOrderStyle(this.id);" style="visibility:hidden"/></span></td>
                </tr>
                  <tr>
                    <td>SC</td>
                    <td><select name="cboSR" class="txtbox" style="width:150px" id="cboSR" onchange="getStyleNo();">
                      <option value="Select One" selected="selected">Select One</option>
                      <?php
	
	$SQL = "select specification.intSRNO,specification.intStyleId from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11";
	
	if($styleName != 'Select One' && $styleName != '')
		$SQL .= " and orders.strStyle='$styleName' ";
		
		$SQL .= " order by specification.intSRNO desc";
		
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($reqStyleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
	}
	
	?>
                    </select></td>
                    <td><img src="images/go.png" alt="go" width="30" height="22" class="mouseover" onclick="reloadPreOrderSR(this.id);" style="visibility:hidden" /></td>
                  </tr>
                  <tr>
                  <td>Order No</td>
                  <td><select name="cboOrderNo" class="txtbox" style="width:150px" id="cboOrderNo" onchange="getStyleandSC();">
                    <option value="Select One" selected="selected">Select One</option>
                    <?php
	
	$SQL = "select specification.intStyleId,orders.strOrderNo from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11";
	
	if($styleName != 'Select One' && $styleName != "")
		$SQL .= " where  orders.strStyle = '$styleName'";
		
		$SQL .= " order by strOrderNo ";	
	$result = $db->RunQuery($SQL);
	
	
	while($row = mysql_fetch_array($result))
	{
		if ($reqStyleID==  $row["intStyleId"])
		{
			echo "<option selected=\"selected\" value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
		}
		else
			echo "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
	}
	
	?>
                  </select></td>
                  <td><img src="images/go.png" width="30" height="22" onclick="reloadPreOrderOrderNo()" /></td>
                </tr>
              </table>              </td>
          </tr>
          
        </table></td>
      </tr>
      <tr>
        <td class="normalfnt">Order Qty.</td>
        <td><table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="83">
              <input name="txtorderqty" type="text" class="txtbox" disabled="disabled" id="txtorderqty" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();"  onkeypress="return isNumberKey(event);" onkeyup="doQuantityChange();" value="<?php echo $OrderQty; ?>" style="width:70px; text-align:right" />            </td>
            <td width="69" class="normalfnt">Ex.Qty.(%)</td>
            <td width="183"><input name="txtexcessqty" type="text" class="txtbox" disabled="disabled" id="txtexcessqty" value="<?php echo $EXPercentage; ?>" style="width:25px;"/></td>
          </tr>
        </table></td>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">Total Qty</td>
        <td><input name="txtTotQty" type="text" class="txtbox" disabled="disabled" id="txtTotQty" value="<?php 
		//echo intval($OrderQty + ($OrderQty * $EXPercentage / 100));
		echo ceil($OrderQty + ($OrderQty * $EXPercentage / 100));
		 ?>" style="width:120px;" text-align:right"/></td>
        <td width="64" class="normalfnt">FOB</td>
        <td width="199"><span class="normalfnt">
          <input type="text" name="txtFob" id="txtFob"  value="<?php echo $preOrderFOB; ?>" disabled="disabled" maxlength="9" size="10" style="text-align:right"/>
        </span></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td height="21" class="normalfnt">Description</td>
        <td colspan="2">
            <input type="text" name="txtDescription" id="txtDescription" disabled="disabled" maxlength="30" size="30" value="<?php echo $StyleName; ?>" />
        </label></td>
        <td class="normalfnt">Order No </td>
        <td height="21" class="normalfnt">
            <input type="text" name="textfield" disabled="disabled" style="width:120px;" value="<?php echo $strOrderNo; ?>"/>
       </td>
        <td height="21" class="normalfnt"></label></td>
        <td style="visibility:hidden"><label class="normalfnth2" id="lbldate"><?php echo date("Y-m-d") ?></label></td>
        </tr>
      
      <tr class="bcgl1">
        <td colspan="9"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
          <tr>
            <td width="1%">&nbsp;</td>
            <td width="2%"><span class="normalfntp2"><img src="images/color4.png" width="12" height="12" /></span></td>
            <td width="10%" class="normalfntp2">Style Ratio</td>
            <td width="2%" class="normalfntp2"><img src="images/color2.png" width="12" height="12" /></td>
            <td width="11%" class="normalfntp2">Material Ratio</td>
            <td width="2%" class="normalfntp2">&nbsp;</td>
            <td class="normalfntp2">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="92%" bgcolor="#fbf8b3" class="normaltxtmidb2" style=" color:#b4b4b4; border:1px solid"><label style=" color:#800000;">Consumptions</label></td>
        <td width="8%" bgcolor="#9BBFDD"  class="normalfnt"><img src="images/add-new.png" <?php if (!$bomItemAddition) {  echo 'style="visibility:hidden;"';  }?> alt="add new" width="109" height="18" border="0" class="mouseover" onclick="ShowAddingForm();" /></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:350px; width:100%;">
          <table id="tblConsumption" bgcolor="#CCCCFF"  width="100%" cellpadding="0" cellspacing="1">
            <tr>
              <td width="40" height="33" bgcolor="#fbf8b3" class="normaltxtmidb6">Edit</td>
              <td width="40" bgcolor="#fbf8b3" class="normaltxtmidb6">Del</td>
              <td width="40" bgcolor="#fbf8b3" class="normaltxtmidb6">Ratio </td>
              <td width="65" bgcolor="#fbf8b3" class="normaltxtmidb6">Material</td>
              <td width="100" bgcolor="#fbf8b3" class="normaltxtmidb6">Category</td>
              <td width="440" bgcolor="#fbf8b3" class="normaltxtmidb6">Description</td>
              <td width="50" bgcolor="#fbf8b3" class="normaltxtmidb6">ConPC</td>
              <td width="55" bgcolor="#fbf8b3" class="normaltxtmidb6">Waste</td>
              <td width="60" bgcolor="#fbf8b3" class="normaltxtmidb6">Tot Qty</td>
              <td width="50" bgcolor="#fbf8b3" class="normaltxtmidb6">Unit</td>
              <td width="70" bgcolor="#fbf8b3" class="normaltxtmidb6">Unit Price</td>
              <td width="50" bgcolor="#fbf8b3" class="normaltxtmidb6">Freight</td>
              <td width="70" bgcolor="#fbf8b3" class="normaltxtmidb6">Purchase Type </td>
              <td width="60" bgcolor="#fbf8b3" class="normaltxtmidb6">Cost PC</td>
              <td width="70" bgcolor="#fbf8b3" class="normaltxtmidb6">Value</td>
              <td width="40" bgcolor="#fbf8b3" class="normaltxtmidb6">Order Type</td>
              <td width="30" bgcolor="#fbf8b3" class="normaltxtmidb6">Placement</td>
              <td width="40" bgcolor="#fbf8b3" class="normaltxtmidb6"> Origin </td>
              <td width="40" bgcolor="#fbf8b3" class="normaltxtmidb6">Purch + Allo Qty </td>
              <td width="40" bgcolor="#fbf8b3" class="normaltxtmidb6">Average <br />
                Price </td>
              <td width="40" bgcolor="#fbf8b3" class="normaltxtmidb6">Average Value </td>
              <td width="40" bgcolor="#fbf8b3" class="normaltxtmidb6">Variation</td>
			  <td width="40" bgcolor="#fbf8b3" class="normaltxtmidb6">Left Over</td>
            </tr>
			<?php
	


$SQL = "select specificationdetails.intStyleId,specificationdetails.strMatDetailID,specificationdetails.strUnit,specificationdetails.dblUnitPrice,specificationdetails.sngConPc,specificationdetails.sngWastage,specificationdetails.strPurchaseMode,specificationdetails.strOrdType,specificationdetails.strPlacement, specificationdetails.intOriginNo ,specificationdetails.intRatioType,specificationdetails.dblReqQty, specificationdetails.dblTotalQty,specificationdetails.dblTotalValue,specificationdetails.dblCostPC,specificationdetails.dblfreight,matmaincategory.strDescription as matdesc,matmaincategory.intID,matsubcategory.StrCatName,matsubcategory.intSubCatNo, matitemlist.strItemDescription,itempurchasetype.strOriginType,itempurchasetype.intType as itemPurchType
  from specificationdetails,matitemlist,matmaincategory,matsubcategory,itempurchasetype
   where specificationdetails.strMatDetailID = matitemlist.intItemSerial AND matitemlist.intMainCatID =  matmaincategory.intID AND matitemlist.intSubCatID = matsubcategory.intSubCatNo AND specificationdetails.intStyleId = '" .  $reqStyleID . "' AND (specificationdetails.intStatus != '0' or specificationdetails.intStatus IS NULL) and  itempurchasetype.intOriginNo = specificationdetails.intOriginNo
    order by matmaincategory.intID,matsubcategory.StrCatName,matitemlist.strItemDescription;";
$result = $db->RunQuery($SQL);

$pos = 0 ;

while($row = mysql_fetch_array($result))
{

	$purchasedQty = 0;
	$averageValue = 0;
	$averagePrice = 0;
	
	/*==================================================================================
	  Change On - 01/20/2016
	  Change By - Nalin Jayakody
	  Change For - Only PO is confirm user cannot edit item or remove. 
	               Remove PO confirm validation and get if PO raise even if confirm or not	
	  ==================================================================================			                    
	*/
	 # $sqlcurrency = "SELECT distinct purchaseorderheader.intYear,purchaseorderdetails.intPoNo,purchaseorderheader.strCurrency FROM purchaseorderdetails INNER JOIN purchaseorderheader ON purchaseorderdetails.intPONo = purchaseorderheader.intPONo and purchaseorderdetails.intYear = purchaseorderheader.intYear WHERE purchaseorderdetails.intStyleId = '$reqStyleID'  AND purchaseorderdetails.intMatDetailID = '" . $row["strMatDetailID"] . "'  AND purchaseorderdetails.intPOType=0 and purchaseorderheader.intStatus = 10;";
	/*================================================================================== */
	
	$sqlcurrency = "SELECT distinct purchaseorderheader.intYear,purchaseorderdetails.intPoNo,purchaseorderheader.strCurrency FROM purchaseorderdetails INNER JOIN purchaseorderheader ON purchaseorderdetails.intPONo = purchaseorderheader.intPONo and purchaseorderdetails.intYear = purchaseorderheader.intYear WHERE purchaseorderdetails.intStyleId = '$reqStyleID'  AND purchaseorderdetails.intMatDetailID = '" . $row["strMatDetailID"] . "'  AND purchaseorderdetails.intPOType=0;";
	
	$resultcur = $db->RunQuery($sqlcurrency);	
	
	while($rowcur = mysql_fetch_array($resultcur))
	{
		/*==================================================================================
	  		Change On - 01/20/2016
	  		Change By - Nalin Jayakody
	 		Change For - Only PO is confirm user cannot edit item or remove. 
	                     Remove PO confirm validation and get if PO raise even if confirm or not	
	     ==================================================================================			                    
	    */
		 # $sqlpurch = "select COALESCE(Sum(purchaseorderdetails.dblQty),0) as purchasedQty, COALESCE(sum(purchaseorderdetails.dblUnitPrice * purchaseorderdetails.dblQty),0) as avgValue  from purchaseorderdetails inner join purchaseorderheader on purchaseorderheader.intPONo = purchaseorderdetails.intPONo AND purchaseorderheader.intYear = purchaseorderdetails.intYear  where intStyleId = '$reqStyleID' AND purchaseorderdetails.intMatDetailID = '" . $row["strMatDetailID"] . "' AND purchaseorderdetails.intPOType=0 and purchaseorderheader.intStatus = 10 AND purchaseorderdetails.intPONo = " . $rowcur["intPoNo"] . " and purchaseorderdetails.intYear='" . $rowcur["intYear"] . "';";		
		/*================================================================================== */
		
		$sqlpurch = "select COALESCE(Sum(purchaseorderdetails.dblQty),0) as purchasedQty, COALESCE(sum(purchaseorderdetails.dblUnitPrice * purchaseorderdetails.dblQty),0) as avgValue  from purchaseorderdetails inner join purchaseorderheader on purchaseorderheader.intPONo = purchaseorderdetails.intPONo AND purchaseorderheader.intYear = purchaseorderdetails.intYear  where intStyleId = '$reqStyleID' AND purchaseorderdetails.intMatDetailID = '" . $row["strMatDetailID"] . "' AND purchaseorderdetails.intPOType=0 and purchaseorderdetails.intPONo = " . $rowcur["intPoNo"] . " and purchaseorderdetails.intYear='" . $rowcur["intYear"] . "';";
	
		$resultpurch = $db->RunQuery($sqlpurch);
		
		while($rowpurch = mysql_fetch_array($resultpurch))
		{
			$dollarRate = 1;
			if ( $rowcur["strCurrency"] != GetDefaultCurrency())
			{
				/*$sql = "SELECT dblRate FROM currencytypes WHERE strCurrency = '". $rowcur["strCurrency"] . "'";
				$rst = $db->RunQuery($sql);
				while($rw = mysql_fetch_array($rst))
				{
					$dollarRate = $rw["dblRate"];
					break;
				}*/
				$dollarRate = GetExchangeRate($rowcur["strCurrency"]);
			}
			$purchasedQty += $rowpurch["purchasedQty"];
			$averageValue += $rowpurch["avgValue"] / $dollarRate;
			//$averagePrice = $averageValue /$purchasedQty;
			if ($purchasedQty > 0)
				$isPurchased = true;

		}
	
	}
	
	//start 2010-10-12 Display the Allocation Qty with the PO qty -------------------------------------- 
	//get bulk and leftover allocation details
	//get bulk allocation Qty
	
	$sqlBulkAllo = "SELECT COALESCE(sum(BCD.dblQty)) as Bulkqty
					FROM commonstock_bulkdetails BCD INNER JOIN commonstock_bulkheader BCH ON
					BCD.intTransferNo = BCH.intTransferNo AND 
					BCD.intTransferYear = BCH.intTransferYear
					WHERE BCH.intToStyleId = '$reqStyleID'  and 
					BCD.intMatDetailId = '" .$row["strMatDetailID"] ."' and BCH.intStatus=1";
					
			$resulBulkAllo = $db->RunQuery($sqlBulkAllo);	
			$rowBulkAllo = mysql_fetch_array($resulBulkAllo);
			$Bulkqty = $rowBulkAllo["Bulkqty"];
			
			if($Bulkqty == '' || is_null($Bulkqty))
				$Bulkqty = 0;
				
		$sqlLeftover = "SELECT COALESCE(sum(LCD.dblQty)) as LeftAlloqty
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$reqStyleID'  and 
						LCD.intMatDetailId = '" . $row["strMatDetailID"] ."' and LCH.intStatus=1 ";	
						
			$resultLeftAllo = $db->RunQuery($sqlLeftover);	
			$rowLeftAllo = mysql_fetch_array($resultLeftAllo);
			$LeftAlloqty = $rowLeftAllo["LeftAlloqty"];
			
			if($LeftAlloqty == '' || is_null($LeftAlloqty))
				$LeftAlloqty = 0;	
	
	//get confirmed liablity qty
	$sqlLB = "SELECT COALESCE(sum(LCD.dblQty),0) as LiabilityAlloqty
						FROM commonstock_liabilitydetails LCD INNER JOIN commonstock_liabilityheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$reqStyleID'  and 
						LCD.intMatDetailId = '" . $row["strMatDetailID"] ."' and LCH.intStatus=1 ";	
						
			$resultLB = $db->RunQuery($sqlLB);	
			$rowLB = mysql_fetch_array($resultLB);
			$LBAlloqty = $rowLB["LiabilityAlloqty"];			
	//---------------------end---------------------------------------------------------
		//Start - Get interjob allocation qty
	$sqlinter="select COALESCE(Sum(ID.dblQty),0) as interJobQty from itemtransfer IH 
inner join itemtransferdetails ID on IH.intTransferId=ID.intTransferId and IH.intTransferYear=ID.intTransferYear
where IH.intStyleIdTo='$reqStyleID'
and  ID.intMatDetailId='" . $row["strMatDetailID"] ."'
and IH.intStatus=3";
	$result_inter=$db->RunQuery($sqlinter);
	$interJobQty	= 0;
	while($row_inter=mysql_fetch_array($result_inter))
	{
		$interJobQty += $row_inter["interJobQty"];
	}
	//End - Get interjob allocation qty
?>
            <tr onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';" class="<?php 
			
				$visibility = "style=\"visibility:hidden;\"";
				if ($row["strPurchaseMode"] == "NONE" || $row["strPurchaseMode"] == "" || $row["strPurchaseMode"] == "BOTH")
					$visibility = "";
				
				//$sqlratio = "SELECT * FROM materialratio WHERE intStyleId = '$reqStyleID' AND strMatDetailID = '" . $row["strMatDetailID"] . "' and strColor <> 'N/A' AND strSize <> 'N/A'";
				/*
				$sqlratio = "SELECT * FROM materialratio WHERE intStyleId = '$reqStyleID' AND strMatDetailID = '" . $row["strMatDetailID"] . "' AND (strColor NOT IN
 (SELECT DISTINCT strColor FROM styleratio WHERE intStyleId = '$reqStyleID' ) OR strSize NOT IN 
 (SELECT DISTINCT strSize FROM styleratio WHERE intStyleId = '$reqStyleID' ) ) AND  strColor <> 'N/A' OR strSize <> 'N/A'";
 				*/
 				
 				$sqlratio = "SELECT strColor,strSize FROM materialratio m WHERE m.intStyleId = '$reqStyleID' and strMatDetailID = '" . $row["strMatDetailID"] . "'";
				$resultratio = $db->RunQuery($sqlratio);
				$hasRatios = false;
				
				while($rowratio = mysql_fetch_array($resultratio))
				{
					$hasRatios = true;
					break;
				}
				
				if ($row["strPurchaseMode"] == "NONE" || $row["strPurchaseMode"] == "")
				{
					if ($hasRatios)
					{
						$sqlratiomat = "SELECT strColor,strSize FROM materialratio WHERE intStyleId = '$reqStyleID'  AND strMatDetailID = '" . $row["strMatDetailID"] . "' AND (strColor NOT IN (SELECT strColor FROM styleratio WHERE intStyleId = '$reqStyleID'  ) OR strSize NOT IN (SELECT strSize FROM styleratio WHERE intStyleId = '$reqStyleID'  )) AND strColor != 'N/A' and strSize != 'N/A'";
						$resultratio = $db->RunQuery($sqlratiomat);
						$matRatio = false;
						while($rowratio = mysql_fetch_array($resultratio))
						{
							$matRatio = true;							
							break;
						}
						
						if ($matRatio)
						{
							echo "backcolorGreen";
						}
						else
						{
							echo "backcolorWhite";
						}
					}
					else
						echo "backcolorWhite";
				}
				else
					echo "bcgcolor-tblrow";
					
				
				
			
			 ?>">
			 
              <td id="<?php echo $row["strMatDetailID"]; ?>">
			  <?php 
			 //echo $sqlratiomat ;
			  $validateQty = $purchasedQty + $LeftAlloqty + $Bulkqty + $interJobQty+$LBAlloqty;
			  if ($bomItemModify && $validateQty == 0)
			  {
			  	echo '<div id="' . $row["strMatDetailID"] . '"  onClick="ShowEditForm(this.id);" align="center"><img src="images/edit.png" alt="edit" width="15" height="15" border="0" class="mouseover" /></div></td>';
				}/*else{$visibility = "style=\"visibility:hidden;\"";}*/
			  ?>			  </td>
			  
<!--			   <td><div id="<?php //echo $row["strMatDetailID"]; ?>"  onClick="ShowEditForm(this.id);" align="center"><img style="visibility:hidden;" src="images/edit.png" alt="edit" width="15" height="15" border="0" class="mouseover" /></div></td>-->
              <td>
			  
			  <?php 
			  $validateQty = $purchasedQty + $LeftAlloqty + $Bulkqty + $interJobQty+$LBAlloqty;
			 if ($bomItemDeletion && $validateQty == 0)
			 {
				
			 
			 echo ' <div align="center" id="' . $row["strMatDetailID"] .'" onclick="RemoveItem(this);" ><img src="images/del.png" alt="del" width="15" height="15" border="0" class="mouseover"/></div>';
			  
			 	}/*else{$visibility = "style=\"visibility:hidden;\"";}*/
				?>			  </td>
              <td><div align="center">
			  
			  <?php
              if ($row["strPurchaseMode"] == "NONE" || $row["strPurchaseMode"] == "")
             {
              ?><img src="images/matratio.png" <?php echo $visibility; ?> class="mouseover" onclick="ShowMaterialRatiowindow(this,<?php echo $purchasedQty; ?>);" />
              <?php
					}
					// Add SIZE to the filter
					else if ($row["strPurchaseMode"] == "COLOR" || $row["strPurchaseMode"] == "BOTH" || $row["strPurchaseMode"] == "SIZE")
					{
					?><!--<img src="images/variation.png" onclick="showContrastWindow(this);"  class="mouseover" >-->
                    	<img src="images/matratio.png" <?php echo $visibility; ?> class="mouseover" onclick="ShowMaterialRatiowindow(this,<?php echo $purchasedQty; ?>);" />
					<?php
					}
					?></div>  
              </td>
              <td class="normalfntSM" id="<?php echo $pos; ?>"><?php echo substr($row["matdesc"],0,3); ?></td>
              <td class="normalfntSM" id="<?php echo $row["intID"]; ?>"><?php echo $row["StrCatName"]; ?></td>
              <td class="normalfntSM" id="<?php  echo $row["strMatDetailID"]; ?>"><?php echo $row["strItemDescription"]; ?></td>
              <td class="normalfntRiteSML"><?php echo number_format($row["sngConPc"],(int)$consumptionDecimalLength); ?></td>
              <td class="normalfntRiteSML"><?php echo $row["sngWastage"]; ?></td>
              <td class="normalfntRiteSML"><?php echo round($row["dblTotalQty"],0); ?></td>
              <td class="normalfntMidSML" id="<?php echo $row["strUnit"]; ?>"><?php echo $row["strUnit"]; ?></td>
              <td class="normalfntRiteSML"><?php echo number_format($row["dblUnitPrice"], 4, '.', ''); ?></td>
              <td class="normalfntRiteSML"><?php echo round($row["dblfreight"],4); ?></td>
              <!--<td class="normalfntMidSML"><?php  if ($row["dblUnitPrice"] <= 0) {echo "NFE"; }else{ echo "FOB";}; ?></td>-->
			  <td class="normalfntMid" id="<?php echo $row["strMatDetailID"]; ?>"><select name="select" id="cboPos" class="txtbox" <?php if($validateQty > 0 ) echo " disabled=\"disabled\" ";?> onchange="updatePurchaseType(this);">
					<option  <?php
				  if ($row["strPurchaseMode"] == "NONE")
				  {
				   	echo  "selected=\"selected\""; 
				   }		   
				   
				   ?> value="NONE">NONE</option>
			      <option <?php
				  if ($row["strPurchaseMode"] == "COLOR")
				  {
				   	echo  "selected=\"selected\""; 
				   }		   
				   
				   ?> value="COLOR">COLOR</option>
				  <option  <?php
				  if ($row["strPurchaseMode"] == "SIZE")
				  {
				   	echo  "selected=\"selected\""; 
				   }		   
				   
				   ?> value="SIZE">SIZE</option>
			      <option  <?php
				  if ($row["strPurchaseMode"] == "BOTH")
				  {
				   	echo  "selected=\"selected\""; 
				   }		   
				   
				   ?> value="BOTH">BOTH</option>
			      </select></td>
              <td class="normalfntRiteSML"><?php echo round($row["dblCostPC"],4); ?></td>
              <td class="normalfntRiteSML"><?php echo round($row["dblTotalValue"],4); ?></td>
<!--			  <td class="normalfntMid" id="<?php echo $row["strMatDetailID"]; ?>"><select name="select" id="cboPos" class="txtbox" <?php if($purchasedQty > 0 ) echo " disabled=\"disabled\" ";?> onchange="updatePurchaseType(this);">
					<option  <?php
				  if ($row["strPurchaseMode"] == "NONE")
				  {
				   	echo  "selected=\"selected\""; 
				   }		   
				   
				   ?> value="NONE">NONE</option>
			      <option <?php
				  if ($row["strPurchaseMode"] == "COLOR")
				  {
				   	echo  "selected=\"selected\""; 
				   }		   
				   
				   ?> value="COLOR">COLOR</option>
				  <option  <?php
				  if ($row["strPurchaseMode"] == "SIZE")
				  {
				   	echo  "selected=\"selected\""; 
				   }		   
				   
				   ?> value="SIZE">SIZE</option>
			      <option  <?php
				  if ($row["strPurchaseMode"] == "BOTH")
				  {
				   	echo  "selected=\"selected\""; 
				   }		   
				   
				   ?> value="BOTH">BOTH</option>
			      </select></td>-->
			  <td class="normalfntMidSML"><?php  if ($row["dblUnitPrice"] <= 0) {echo "NFE"; }else{ echo "FOB";}; ?></td>	  
              <td class="normalfntMidSML"><?php echo $row["strPlacement"]==""? " " : $row["strPlacement"]; ?></td>
              <td class="normalfntSM" id="<?php echo $row["intOriginNo"]; ?>"><?php 
			  									/*if ($row["intOriginNo"] == 1)
												{
			  										 echo  "IMP-F";
												}
												else if ($row["intOriginNo"] == 2)
												{
													 echo "IMP";
												}
												else if ($row["intOriginNo"] == 3)
												{
													 echo "LOC-F";
												}
												else
												{
													 echo "LOC";	
												}*/
			  										echo $row["strOriginType"];											 
													 ?></td>
              <td class="normalfntRite" id="<?php echo $row["itemPurchType"]; ?>"><?php 
			  //echo round($purchasedQty,4);
			  //display PO qty + Bulk allo Qty + LeftOver Qty
			  //$totPOqty = $purchasedQty + $LeftAlloqty  + $Bulkqty;
			  $totPOqty = $validateQty;
			  echo round($totPOqty,4);
			   ?></td>
              <td class="normalfntRite"><?php 
			  
			  echo round($averagePrice,4);
			   ?></td>
              <td class="normalfntRite"><?php 
			  
			  echo round($averageValue,4);
			   ?></td>
              <td class="normalfntRite"><?php 
			  $variation = $row["dblUnitPrice"] -  round($averagePrice,4);
			  echo round($variation,4);
			   ?></td>
			    <td class="normalfntRite"  ><img src="images/butt_1.png" onclick="LoadAllocation(this,'BOM')"/></td>
            </tr>
           <?php
		   
		   $pos ++;
		   }
		   
		   ?>
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <script type="text/javascript">
  
  var arrayLocation = <?php echo $pos; ?>;
  var userID = <?php echo $_SESSION["UserID"]; ?>;
  var fiancePctng = <?php echo $fiancePctng; ?>;
  var upcharge = <?php echo $upcharge; ?>;
 
  </script>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="15%" class="normalfnt">Estimated CM+Profit</td>
        <td width="17%"><input name="txtcmvpreorder" type="text" disabled="disabled" class="txtbox" id="txtcmvpreorder" value="<?php 
		//$preorderCM = getPreorderCM($reqStyleID,$escCharge,$upcharge,$fiancePctng,$preOrderFOB,$CMV);
		//echo $preorderCM;
		 echo $profit+$CMV; //cmv in preorder for orit (cmv include the profit also) 
		?>" style="text-align:right" /></td>
        <td width="9%" class="normalfnt">CMV Now</td>
        <td width="19%"><input name="cmvnow" type="text" disabled="disabled" class="txtbox" id="cmvnow" value="<?php

		// echo $preorderCM;
		 //echo '0.23';
		  ?>" style="text-align:right"  /></td>
        <td width="24%"><div align="right"><img src="images/delivery-sch.png" alt="SET STYLE" class="mouseover" onclick="showDeliveryForm();" /></div></td>
        <td width="16%"><div align="right">
		<img src="images/set_style.png" alt="SET STYLE"  class="mouseover" onclick="ShowStyleRatiowindow();" />
		</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#fdc93f">
      <tr>
        <td width="15%" height="29" style="visibility:hidden">
        <!--<div align="center"><img src="images/subcontract.png" class="mouseover" <?php if ($assignSubContractorOrders) { ?> onClick="ShowSubContractWindow();" <?php } else {?> onClick="alert('Sorry! You are not authorized to assign sub contractors for orders.');" <?php }?>></div>-->
        </td>
        <td width="15%" style="visibility:hidden"><div align="center"><img src="images/applycontrast.jpg" class="mouseover" onClick="applyContrast();" ></div></td>        
       
        <?php 
            if ($EnableAdvancedBuyePO == "true")
            {
            ?>
            <td width="15%" style="visibility:hidden"><div align="center"><img src="images/sbpo.png" alt="Style Buyer PO" width="171" height="24" class="mouseover" onclick="showBPODeliveryForm();" /></div></td>
            <?php 
            }
            else
            {
            ?>
        	<td width="20%" style="visibility:hidden"><div align="center"><img src="images/sbpo.png" alt="Style Buyer PO" width="171" height="24" class="mouseover" onclick="showStyleBuyerPOForm();" /></div></td>
        	<?php
        	
        	}
        	?>
			 <td width="15%"><img src="images/cutQty.png" width="108" height="24" border="0" onclick="loadStyleEditionPopup(<?php echo $reqStyleID; ?>);"/></td>
			 <td width="12%"><img src="images/report.png" width="108" height="24" border="0" onclick="loadBomReport(<?php echo $reqStyleID; ?>);"/></td>
        <td width="20%"><a href="main.php"><img src="images/close.png" width="97" height="24" border="0" /></a><a href="#"></a></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<script type="text/javascript">
  
var hasStyleRatio = <?php

 $sql = "select intStyleId from styleratio where intStyleId = '" . $reqStyleID . "';"; 
 $result = $db->CheckRecordAvailability($sql);
 if ($result)
 	echo "true";
 else
 	echo "false";
 
 ?>;
var isPurchased = <?php

if ($isPurchased)
	echo "true";
else
	echo "false";

?>;

var isSuperStyleRatioEditot = <?php

if ($supperStyleRatioEditor)
	echo "true";
else
	echo "false";

?>;

var isSuperMaterialRatioEditot = <?php

if ($supperMaterialRatioEditor)
	echo "true";
else
	echo "false";

?>;


var canUseSavedCmForAddingInSameCategory = <?php

if ($canUseSavedCmForAddingInSameCategory)
	echo "true";
else
	echo "false";

?>;

var preOrderFabricCost = <?php

 $SQL = "select COALESCE(sum(round(dbltotalcostpc,4)),0) as totcost from orderdetails inner join matitemlist on orderdetails.intMatDetailID = matitemlist.intItemSerial  where intStyleId = '$reqStyleID' and matitemlist.intMainCatID = 1";
 $result = $db->RunQuery($SQL);
 while($row = mysql_fetch_array($result))
 {
 	echo $row["totcost"];
 } 
 ?>;
 
 var preOrderAccessoriesCost = <?php

 $SQL = "select COALESCE(sum(round(dbltotalcostpc,4)),0) as totcost from orderdetails inner join matitemlist on orderdetails.intMatDetailID = matitemlist.intItemSerial  where intStyleId = '$reqStyleID' and matitemlist.intMainCatID = 2";
 $result = $db->RunQuery($SQL);
 while($row = mysql_fetch_array($result))
 {
 	echo $row["totcost"];
 } 
 ?>;
 
 var preOrderPacMatCost = <?php

 $SQL = "select COALESCE(sum(round(dbltotalcostpc,4)),0) as totcost from orderdetails inner join matitemlist on orderdetails.intMatDetailID = matitemlist.intItemSerial  where intStyleId = '$reqStyleID' and matitemlist.intMainCatID = 3";
 $result = $db->RunQuery($SQL);
 while($row = mysql_fetch_array($result))
 {
 	echo $row["totcost"];
 } 
 ?>;
 
  var preOrderServiceCost = <?php
 $SQL = "select COALESCE(sum(round(dbltotalcostpc,4)),0) as totcost from orderdetails inner join matitemlist on orderdetails.intMatDetailID = matitemlist.intItemSerial  where intStyleId = '$reqStyleID' and matitemlist.intMainCatID = 4";
 $result = $db->RunQuery($SQL);
 while($row = mysql_fetch_array($result))
 {
 	echo $row["totcost"];
 } 
 ?>;
 
 var preOrderOtherCost = <?php
 $SQL = "select COALESCE(sum(round(dbltotalcostpc,4)),0) as totcost from orderdetails inner join matitemlist on orderdetails.intMatDetailID = matitemlist.intItemSerial  where intStyleId = '$reqStyleID' and matitemlist.intMainCatID = 5";
 $result = $db->RunQuery($SQL);
 while($row = mysql_fetch_array($result))
 {
 	echo $row["totcost"];
 } 
 ?>;
 
 var bomItemDeletion = <?php

if($bomItemDeletion)
	echo 'true';
else
	echo 'false';
?>;

var bomItemAddition = <?php

if($bomItemAddition)
	echo 'true';
else
	echo 'false';
?>;

var bomItemModify = <?php

if($bomItemModify)
	echo 'true';
else
	echo 'false';
?>;
 
 var canplaysamecategory = <?php

if($canUseSavedCmForAddingInSameCategory)
	echo 'true';
else
	echo 'false';
?>;
var canDecreaseItemUnitprice='<?php echo $PP_canDecreaseItemUnitprice; ?>';
var canIncreaseItemUnitprice='<?php echo $PP_canIncreaseItemUnitprice; ?>';
var editDelScheduleAfterFirstRevision = '<?php echo $PP_editDelScheduleAfterFirstRevision  ?>';
var editDelScheduleAfterRevision = '<?php echo $PP_editDelScheduleAfterRevision;  ?>';

</script>

</script>
<?php
include "dbConfigLoader.php";

function getPreorderCM($styleNo,$escCharge,$upcharge,$fiancePctng,$preOrderFOB,$CMV)
{
	
	global $db;
	$totalMaterialCost = 0;
	$totalFinanceCost = 0 ;
	/*$SQL = "select intMatDetailID,dblUnitPrice,reaConPc,reaWastage,strCurrencyID,intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dblFreight, dbltotalcostpc from orderdetails where intStyleId ='$styleNo'";*/
	$SQL = "select intMatDetailID,dblUnitPrice,reaConPc,reaWastage,strCurrencyID,itempurchasetype.intType,orderdetails.intOriginNo,
dblReqQty,dblTotalQty,dblTotalValue,dblFreight, dbltotalcostpc 
from orderdetails inner join itempurchasetype on itempurchasetype.intOriginNo = orderdetails.intOriginNo where intStyleId ='styleNo'";
	
	$result = $db->RunQuery($SQL);
	 while($row = mysql_fetch_array($result))
	 {
	 	
	 	$totalMaterialCost += $row["dbltotalcostpc"];//round($row["dbltotalcostpc"],4);
		/*if ($row["intOriginNo"] == 1)
		{
			$totalFinanceCost += $row["dbltotalcostpc"] * $fiancePctng / 100;
		}
		else if ($row["intOriginNo"] == 3)
		{
			$totalFinanceCost += $row["dbltotalcostpc"] * $fiancePctng / 100;
		}*/
		
		if ($row["intType"] == 0)
		{
			$totalFinanceCost += $row["dbltotalcostpc"] * $fiancePctng / 100;
		}
	 }
	$profit = $preOrderFOB - ($totalMaterialCost + $totalFinanceCost + $escCharge + $CMV);
	//return number_format($preOrderFOB - $totalMaterialCost - $totalFinanceCost - $escCharge - $CMV + $upcharge,4);
	return number_format($profit,4);
}

function GetDefaultCurrency()
{
global $db;
	$sql ="select intBaseCurrency from systemconfiguration";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["intBaseCurrency"];
}

function GetExchangeRate($currencyId)
{
global $db;
	$sql ="select rate from exchangerate where currencyID=$currencyId and intStatus=1";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["rate"];
}
?>
</body>
 
</html>