<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";  
$date		= 	$_GET['todayWash_txtDate'];
$dateTo		= 	$_GET['todayWash_txtDateTo'];
$factoryId	=	$_GET['todayWash_cboFactory'];
$poNo	  	=	$_GET['todayWash_cboPo'];
$style	  	=	$_GET['todayWash_cboStyle'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gapro:Washing-Today Receive</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../../javascript/calendar/calendar.js"></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js"></script>
<script type="text/javascript">
$(function(){
	// TABS
	$('#tabs').tabs();
});
</script>
<script src="issuedWash.js" type="text/javascript"></script>
<script src="issuedWash_0utSide.js" type="text/javascript"></script>
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
var tdate = "<?php echo date('Y-m-d');?>"
function today(){
var tDay= new Date();
//document.getElementById('issuedWash_txtDate').value =(tDay.getFullYear())+"-"+(tDay.getMonth()+1)+"-"+tDay.getDate();
}
function fromSubmit(){
document.getElementById('frmRcvdToday').submit();
}
</script>
</head>

<body>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<form name="frmRcvdToday" id="frmRcvdToday" method="GET">
<table style="width:750px;" border="0" align="center" class="bcgl1" bgcolor="#FFFFFF">
  <tr>
    <td class="mainHeading" colspan="5">Issued to Wash Production Report</td>
  </tr>
  <tr>
    <td class="normalfnt" style="width:100px;">Factory</td>
    <td colspan="4" style="width:50px;"><select style="width:455px;" id="todayWash_cboFactory" name="todayWash_cboFactory">
      <option></option>
      <?php 
		$sql="SELECT companies.intCompanyID,companies.strName,companies.strCity FROM companies WHERE companies.intStatus =  '1' ORDER BY companies.strName ASC";
		$res=$db->RunQuery($sql);
		while($row=mysql_fetch_array($res)){
			if($_GET["todayWash_cboFactory"]== $row["intCompanyID"])
				echo "<option selected=\"selected\" value=\"".$row["intCompanyID"]."\">".$row["strName"]."-".$row["strCity"]."</option>";
			else
				echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."-".$row["strCity"]."</option>";
		}?>
    </select></td>
  </tr>
  <tr>
  	<td style="width:100px;" class="normalfnt">Date From</td>
    <td style="width:100px;">
      <input name="todayWash_txtDate" type="text" class="txtbox" id="todayWash_txtDate"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" style="width:100px"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $_GET['todayWash_txtDate'];?>"/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/>
    </td>
    <td style="width:100px;" class="normalfnt">Date To</td>
    <td style="width:100px;">
      <input name="todayWash_txtDateTo" type="text" class="txtbox" id="todayWash_txtDateTo"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" style="width:100px"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $_GET['todayWash_txtDateTo'];?>"/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/>
    </td>
  </tr>
  <tr>
  	<td style="width:100px;" class="normalfnt">PO No</td>
  	<td style="text-align:left;width:150px;" >
    	
    	<select id="todayWash_cboPo" name="todayWash_cboPo" style="width:102px;height:20px;" onclick="setStyle('todayWash_cboPo','todayWash_cboStyle');">
        <option value=""></option>
        <?php
        	$sqlO="select distinct o.strOrderNo,o.intStyleId from orders o inner join was_stocktransactions wst on wst.intStyleId=o.intStyleId  order by o.strOrderNo;";
			$resO=$db->RunQuery($sqlO);
			while($rowO=mysql_fetch_array($resO)){
			  if($_GET["todayWash_cboPo"]== $rowO["intStyleId"])
				echo "<option value=\"".$rowO['intStyleId']."\" selected=\"selected\">".$rowO['strOrderNo']."</option>";
			  else
			  	echo "<option value=\"".$rowO['intStyleId']."\">".$rowO['strOrderNo']."</option>";
			}
		?>
        </select>
    </td>
    <td style="width:100px;" class="normalfnt">Style No</td>
    <td style="width:100px;">
    	<select id="todayWash_cboStyle" name="todayWash_cboStyle" style="height:20px;width:102px;" onclick="setStyle('todayWash_cboStyle','todayWash_cboPo');">
        <option value=""></option>
        <?php
        $sqlS="select distinct o.strStyle,o.intStyleId from orders o inner join was_stocktransactions wst on wst.intStyleId=o.intStyleId  order by o.strStyle;";
			$resS=$db->RunQuery($sqlS);
			while($rowS=mysql_fetch_array($resS)){
			  if($_GET["todayWash_cboPo"]== $rowS["intStyleId"])
				echo "<option value=\"".$rowS['intStyleId']."\" selected=\"selected\">".$rowS['strStyle']."</option>";
			  else
			    echo "<option value=\"".$rowS['intStyleId']."\">".$rowS['strStyle']."</option>"; 
			}
		?>
        </select>
    </td>
    <td style="width:50px;"><img src="../../images/search.png" onclick="fromSubmit();" /></td>
  </tr>
  <tr>
  	<td colspan="5">
    <div style="overflow:scroll;height:350px;width:750px;">
		<table style="width:750px;">
			<tr>
				<td style="width:30px;" class="grid_header">*</td>
				<td style="width:145px;" class="grid_header">PO Number</td>
				<td style="width:145px;" class="grid_header">Style</td>
				<td style="width:150px;" class="grid_header">Color</td>
				<td style="width:50px;" class="grid_header">Qty(Pcs)</td>
				<td style="width:230px;" class="grid_header">Remarks</td>
			</tr>
			<?php 
			$resD=getDets($_GET['todayWash_txtDate'],$_GET['todayWash_cboFactory'],$dateTo,$factoryId,$poNo);
			
			$count=1;
			$cls="";
			$total=0;
			$factory="";
			$subTot=0;
			$t=1;
			while($rowD=mysql_fetch_array($resD)){ ($count%2==1)?$cls='grid_raw':$cls='grid_raw2';
			$total=$total+$rowD['RCVDQty'];
			$subTot=$subTot+$rowD['RCVDQty'];
			
			//if($rowD['intFromFactory']== $factory){$t=1;}else{$t=0;}
			//echo $rowD['intFromFactory']."= ".$factoryId."<br>";
			if($rowD['intFromFactory']!= $factory){
				
				$nr=mysql_num_rows(getDets($td="",$rowD['intFromFactory'],$dateTo,$rowD['intFromFactory'],$poNo ));
			?>
			<tr>
			  <td class="normalfnt" style="background-color:#EFEFFF;">Factory-</td>
			  <td colspan="5" style="background-color:#EFEFFF;" class="normalfnt"> <?php echo $rowD['strName']; ?></td>
            </tr>
			<?php }
			
			$factory=$rowD['intFromFactory'];
			?>
			<tr>
				<td  class="<?php echo $cls;?>" style="text-align:left"><?php echo $count;?></td>
				<td  class="<?php echo $cls;?>"  style="text-align:left"><?php echo $rowD['strOrderNo'];?></td>
				<td  class="<?php echo $cls;?>"  style="text-align:left"><?php echo $rowD['strStyle'];?></td>
				<td  class="<?php echo $cls;?>"  style="text-align:left"><?php echo $rowD['strColor'];?></td>
				<td  class="<?php echo $cls;?>"  style="text-align:right"><?php echo $rowD['RCVDQty'];?></td>
				<td  class="<?php echo $cls;?>"  style="text-align:left"><?php echo getRemarks($rowD['intStyleId']); ?></td>
			</tr>
			<?php 

			if($t==$nr){
			?>
			<tr style="background-color:#FFF;" >
				<td   style="text-align:left"></td>
				<td   style="text-align:left">&nbsp;</td>
				<td   style="text-align:left">&nbsp;</td>
				<td   style="text-align:left"><!--Total--></td>
				<td   class="normalfnt" style="text-align:right"><?php echo $subTot; $subTot=0;$cls="";?></td>
				<td   style="text-align:left"></td>
			</tr>
			<?php $t=0; 
			} $t++;

			 $count++; }
			?>
            <!--<tr style="background-color:#FFF;" >
				<td width="31"  style="text-align:left"></td>
				<td width="106"  style="text-align:left">&nbsp;</td>
				<td width="120"  style="text-align:left">&nbsp;</td>
				<td width="129"  style="text-align:left">Total</td>
				<td width="95"  class="normalfnt" style="text-align:right"><?php //echo $subTot; $subTot=0;$cls="";?></td>
				<td width="227"  style="text-align:left"></td>
			</tr>-->
	  </table>
    </div>
 <table style="width:750px;" border="0" align="center" class="bcgl1" bgcolor="#FFFFFF">
      <tr style="background-color:#FFF;">
				<td   style="text-align:left">&nbsp;</td>
				<td   style="text-align:left">&nbsp;</td>
				<td   style="text-align:left">&nbsp;</td>
				<td   class="normalfnt"  style="text-align:left">TOTAL</td>
				<td   class="normalfnt" style="text-align:right"><?php echo $total; ?></td>
				<td   align="right" ><img src="../../images/new.png" onclick="clearF();" /><img src="../../images/report.png" onclick="showTodayReport();"/></td>
			</tr>
  </table>
	</td>
  </tr>
</table>
<?php 
function getDets($todayWashDate,$todayWashFactory,$dateTo,$factoryId,$poNo){
	global $db;
$sqlD="SELECT
					was_stocktransactions.strColor,
					sum(was_stocktransactions.dblQty) as RCVDQty,
					orders.strOrderNo,
					orders.strStyle,
					orders.intStyleId,
					was_stocktransactions.intFromFactory,
					companies.strName
					FROM
					was_stocktransactions
					Inner Join orders ON was_stocktransactions.intStyleId = orders.intStyleId 
					inner join companies on companies.intCompanyID= was_stocktransactions.intFromFactory
					WHERE
					was_stocktransactions.strType =  'FTransIn'";
					if($todayWashDate!=""){ 
						if($dateTo!="")
							$sqlD.=" AND DATE(was_stocktransactions.dtmDate) between '$todayWashDate' and '$dateTo'";
						else
							$sqlD.=" AND DATE(was_stocktransactions.dtmDate) = '$todayWashDate'";
						
					}
					if($todayWashFactory != ""){
						$sqlD.=" and was_stocktransactions.intFromFactory = '$factoryId'"; 
					}
					if($poNo !=""){
						$sqlD.=" and was_stocktransactions.intStyleId = '$poNo'";
					}
					
					$sqlD.=" GROUP BY
					was_stocktransactions.intFromFactory,
					-- was_stocktransactions.dtmDate,
					orders.intStyleId,
					was_stocktransactions.strColor;";
					//echo $sqlD;
					return $db->RunQuery($sqlD);
}

function getRemarks($po){
	global $db;
	$sql="SELECT productionfinishedgoodsreceiveheader.strRemarks FROM productionfinishedgoodsreceiveheader Inner Join was_stocktransactions ON  productionfinishedgoodsreceiveheader.dblTransInNo = was_stocktransactions.intDocumentNo AND productionfinishedgoodsreceiveheader.intGPTYear = was_stocktransactions.intDocumentYear WHERE was_stocktransactions.intStyleId =  '$po' AND was_stocktransactions.strType =  'FTransIn';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	$arrRemarks=array();
	$c=0;
	while($row=mysql_fetch_array($res)){
		$arrRemarks[$c]=$row['strRemarks'];
		$c++;
	}
	return implode(',',$arrRemarks);
}

?>
</form>
</body>
</html>
