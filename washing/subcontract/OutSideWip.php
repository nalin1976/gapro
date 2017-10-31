<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";  
$date	= $_GET['outside_txtDate'];
$factoryId=$_GET['outside_cboFactory'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gapro:Washing-Out Side WIP</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>
<script type="text/javascript" src="../../javascript/calendar/calendar.js"></script>
<script type="text/javascript" src="../../javascript/calendar/calendar-en.js"></script>
<script type="text/javascript">
function showWipReport(){
	var dt=document.getElementById('outside_txtDate').value.trim();
	window.open("rptOutSideWip.php?req="+dt,'OWIP')
	//$.ajax({url:path});
}
</script>
<script src="subcontractor.js" type="text/javascript"></script>
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
document.getElementById('frmSubWip').submit();
}
</script>
</head>

<body>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include($backwardseperator.'Header.php'); ?></td>
	</tr> 
</table>
<form name="frmSubWip" id="frmSubWip" method="GET">
<table width="95%" border="0" align="center" class="bcgl1" bgcolor="#FFFFFF">
  <tr>
  	<td class="mainHeading" colspan="5">Out Side Wip</td>
  </tr>
  <tr>
  	<td width="74" class="normalfnt" style="display:none">&nbsp;</td>
	<td width="817">
	<select style="width:150px;display:none" id="outside_cboFactory" name="outside_cboFactory" >
	<option></option>
	<?php 
		$sql="SELECT DISTINCT was_outside_companies.intCompanyID,was_outside_companies.strName FROM was_outside_companies WHERE was_outside_companies.intStatus = 1 ORDER BY was_outside_companies.strName ASC;";
		$res=$db->RunQuery($sql);
		while($row=mysql_fetch_array($res)){
			if($_GET["outside_cboFactory"]== $row["intCompanyID"])
				echo "<option selected=\"selected\"value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
			else
				echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
		}?>
	</select>
	</td>
	<td width="59" class="normalfnt">Date</td>
	<td width="143"><input name="outside_txtDate" type="text" class="txtbox" id="outside_txtDate"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" style="width:100px"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $date;?>"/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value=""/></td><td width="96"><img src="../../images/search.png" onclick="fromSubmit();" /></td>
  </tr>
  <tr><td colspan="4" >&nbsp;</td><td style="text-align:left;">&nbsp;</td></tr>
  <tr>
  	<td colspan="5">
    <div style="overflow:scroll;height:350px;">
      <table width="100%" border="0">
      	<tr>
          <td width="12" rowspan="2" class="grid_header">*</td>
          <td width="81" rowspan="2" class="grid_header">PO Number</td>
          <td width="55" rowspan="2" class="grid_header">Style</td>
          <td width="70" rowspan="2" class="grid_header">Color</td>
          <td width="74" rowspan="2" class="grid_header">Order Qty</td>
          <td width="66" rowspan="2" class="grid_header">RCVD QTY</td>
          <td width="126" rowspan="2" class="grid_header">FABRIC ID</td>
          <td width="103" rowspan="2" class="grid_header">SHIPMENT DATE</td>
          <td class="grid_header" colspan="2"><!--<table border="0" width="120">
            <tr>
              <td colspan="2" width="60" class="grid_header">SEND QTY</td>
            </tr>
            <tr>
              <td width="60" class="grid_header">TODAY</td>
              <td width="82" class="grid_header">CUMULATE</td>
            </tr>
          </table>-->SEND</td>
          <td class="grid_header" colspan="2">RECEIVE</td>
          <td width="78" class="grid_header">&nbsp;</td>
          <td width="161" class="grid_header">&nbsp;</td>
        </tr>
        <tr>
          <td width="72" class="grid_header">TODAY</td>
          <td width="70" class="grid_header">CUMULATE</td>
          <td width="86" class="grid_header">TODAY</td>
          <td width="93" class="grid_header">CUMULATE</td>
          <td width="78" class="grid_header">BALANCE</td>
          <td width="161" class="grid_header">Remarks</td>
        </tr>
        
		<?php 
		$res=getDets($date,$po,$color,$type,$factory,'was_subcontractout','');
		$otFac='';
		$i=0;
		$cls='';
		while($row=mysql_fetch_assoc($res)){ 
		if($row['strName']=="" || $row['strName']!="$otFac"){
			$outC=0;
			$inC=0;
			($i%2==0)?$cls='grid_raw':$cls='grid_raw2';
			?>
           <tr>
            	<td colspan="14" class="normalfnt" style="background-color:#CCC"> <?php echo $row['strName']; $otFac=$row['strName'];?> </td>
            </tr>
            <?php } ?>
			<tr>
            	<td class="<?php echo $cls;?>"> </td>
                <td class="<?php echo $cls;?>"><?php echo $row['strOrderNo'];?></td>
                <td class="<?php echo $cls;?>"><?php echo $row['strStyle'];?></td>
                <td class="<?php echo $cls;?>"><?php echo $row['strColor'];?></td>
                <td class="<?php echo $cls;?>"><?php echo $row['intQty'];?></td>
                <td class="<?php echo $cls;?>"><?php echo getRcvdQty($row['intStyleId']);?></td>
                <td class="<?php echo $cls;?>"><?php echo $row['strItemDescription'];?></td>
                <td class="<?php echo $cls;?>"><?php echo getShipmentDate($row['intStyleId']);?></td>
              <td class="<?php echo $cls;?>">
                
				<?php 
				$tdO=getDets($date,$row['intStyleId'],$color,$type,$row['intSubContractNo'],'was_subcontractout',"='".$date."'");
				$r=mysql_fetch_assoc($tdO);
				echo $r['QTY'];
				?>
				
                
              </td>
                <td class="<?php echo $cls;?>">
                <?php 
				$cO=getDets($date,$row['intStyleId'],$color,$type,$row['intSubContractNo'],'was_subcontractout'," <= '".$date."'");
				$r=mysql_fetch_assoc($cO);
				echo $outC=$r['QTY'];
				?>
                </td>
                
              <td class="<?php echo $cls;?>"><?php 
				$tdO=getDets($date,$row['intStyleId'],$color,$type,$row['intSubContractNo'],'was_subcontractin',"='".$date."'");
				$r=mysql_fetch_assoc($tdO);
				echo $r['QTY'];
				?>
                                
              </td>
                        
                <td class="<?php echo $cls;?>"><?php 
				$cO=getDets($date,$row['intStyleId'],$color,$type,$row['intSubContractNo'],'was_subcontractin'," <= '".$date."'");
				$r=mysql_fetch_assoc($cO);
				echo $inC=$r['QTY'];
				?>
                
                </td>
                
                <td class="<?php echo $cls;?>"><?php echo $outC-$inC?></td>
                <td class="<?php echo $cls;?>"><?php ?></td>
            </tr>
		<?php $i++; } ?>
      </table>
    </div>
 <table width="800" border="0" align="center" bgcolor="#FFFFFF"><!-- class="bcgl1"-->
      <tr style="background-color:#FFF;">
				<td width="25%" class="normalfnt"  style="text-align:left"><!--TOTAL--></td>
				<td width="25%"  class="normalfnt" style="text-align:right"><?php //echo $total; ?>
			    <img src="../../images/new.png" onclick="clearF();" /></td>
				<td width="25%"  ><img src="../../images/report.png" onclick="showWipReport();"/></td>
				<td width="25%" class="normalfnt"  style="text-align:left"><!--TOTAL--></td>
		  </tr>
  </table>
	</td>
  </tr>
</table>
<?php 
function getDets($date,$po,$color,$type,$factory,$tbl,$dt){
	//echo $type."-".$facory;
	global $db;
	$sqlD="SELECT
			Sum(`$tbl`.dblQty) AS QTY,
			O.strOrderNo,
			O.strStyle,
			`$tbl`.strColor,
			O.intQty,
			M.strItemDescription,
			`$tbl`.intSubContractNo,
			was_outside_companies.strName,
			O.intStyleId
			FROM
			orders AS O
			INNER JOIN orderdetails AS OD ON OD.intStyleId = O.intStyleId
			INNER JOIN matitemlist AS M ON M.intItemSerial = OD.intMatDetailID
			INNER JOIN `$tbl` ON `$tbl`.intStyleId = O.intStyleId
			INNER JOIN was_outside_companies ON `$tbl`.intSubContractNo = was_outside_companies.intCompanyID
			WHERE
			OD.intMainFabricStatus = '1' ";
			if(isset($factory))
			$sqlD.="AND `$tbl`.intSubContractNo = '$factory' ";
			
			if(isset($dt)) 
			$sqlD.=" AND DATE(`$tbl`.dtmDate) $dt ";
			
			if(isset($po))
				$sqlD.= " AND O.intStyleId='$po' ";
			
			$sqlD.= "AND `$tbl`.intCompanyID = '".$_SESSION['FactoryID']."'
			 		GROUP BY
					O.strOrderNo,
					`$tbl`.strColor,
					`$tbl`.intSubContractNo
					 ORDER BY `$tbl`.intSubContractNo;";
					//echo $sqlD;
					return $db->RunQuery($sqlD);
}
/*		-- DATE(was_stocktransactions.dtmDate),*/
function getRcvdQty($po){
	global $db;
	$sql="select sum(dblQty) as RCVDQty from was_stocktransactions where intStyleId='$po' and strType='FTransIn';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['RCVDQty'];
}

function getFab($po){
	global $db;
	
	$sql="SELECT DISTINCT
				matitemlist.strItemDescription
				FROM
				orders
				Inner Join orderdetails ON orders.intStyleId = orderdetails.intStyleId
				Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
				Inner Join was_stocktransactions wst ON wst.intStyleId = orders.intStyleId
				WHERE orders.intStyleId='$po' AND orderdetails.intMainFabricStatus=1;";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['strItemDescription'];
}

function getShipmentDate($po){
	global $db;
	$sql="SELECT d.dtDateofDelivery FROM deliveryschedule d WHERE d.intStyleId='$po';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return substr($row['dtDateofDelivery'],0,10);
}
?>
</form>
</body>
</html>
