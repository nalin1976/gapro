<?php
	session_start();
	include "../../Connector.php";	
	$backwardseperator = "../../";	
	
	$cmbFactory = $_POST["cmbFactory"];
	$cmbStyle	= $_POST["cmbStyle"];
	$checkwipdate = $_POST["checkwipdate"];
	$txtWipFDate = $_POST["txtWipFDate"];
	$txtWipTDate = $_POST["txtWipTDate"];
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--<style type="text/css">
#tblwip_foot tr:hover{
	background-color:#EBE9FE;
	color:#fff;	
}
</style>-->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Production WIP</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="wip.js" type="text/javascript"></script>
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
<form name="FrmFactoryWiseWIP" id="FrmFactoryWiseWIP" method="post" action="wip.php">
<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td align="center"><table width="95%" border="0" cellspacing="0"  cellpadding="2" class="normalfnt tableBorder">
      <tr>
        <td colspan="6" class="mainHeading">FACTORY WISE - WORK IN PROGRESS</td>
        </tr>
		 <tr>
		 <td colspan="6" align="center"><table width="100%" border="0" cellspacing="3" cellpadding="0">
           <tr>
             <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
               <tr>
                 <td width="9%" height="10"></td>
                 <td width="22%"></td>
                 <td width="27%"></td>
                 <td width="11%"></td>
                 <td width="9%"></td>
                 <td width="22%"></td>
               </tr>
               <tr>
                 <td height="25">&nbsp; Factory</td>
                 <td><select name="cmbFactory" class="txtbox" style="width:190px" id="cmbFactory"  tabindex="6">
                     <option value=""></option>
                     <?php 
			$strtofactory="select intCompanyID,strComCode,strName from companies";
		
			$factresults=$db->RunQuery($strtofactory);
			
		while($factrow=mysql_fetch_array($factresults))
		{
			if($cmbFactory==$factrow["intCompanyID"])
			echo "<option selected=\"selected\" value=\"". $factrow["intCompanyID"] ."\">" . $factrow["strName"] ."</option>" ;
			else
			echo "<option value=\"". $factrow["intCompanyID"] ."\">" . $factrow["strName"] ."</option>" ;
		}
		?>
              
                 </select></td>
                 <td rowspan="2"><fieldset class="bcgl1">
                   <legend>Cut Date</legend>
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
                     <tr>
                       <td rowspan="2" width="15%"><div align="center">
                           <input name="checkwipdate" type="checkbox" class="txtbox" id="checkwipdate" <?php if($checkwipdate){?> checked="checked"<?php } ?> onchange="disable_time();"/>
                       </div></td>
                       <td width="30%" height="20">From</td>
                       <td width="55%" ><input name="txtWipFDate" type="text" tabindex="7" class="txtbox" id="txtWipFDate" style="width:90px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date('d/m/Y');?>" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                     </tr>
                     <tr>
                       <td height="20"> To</td>
                       <td><input name="txtWipTDate" type="text" tabindex="7" class="txtbox" id="txtWipTDate" style="width:90px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onfocus="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo date('d/m/Y');?>" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                     </tr>
                   </table>
                 </fieldset></td>
                 <td rowspan="2" valign="bottom" align="center"><img src="../../images/search.png" alt="search" width="80" height="24" onclick="ReloadPage();" /></td>
                 <td colspan="2" rowspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
                     <tr>
                       <td><input type="radio" name="rdoRptType" id="RPT1" class="txtbox" />
                         Cutting - to - Gate Pass Generation </td>
                     </tr>
                     <tr>
                       <td><input type="radio" name="rdoRptType" id="radio" class="txtbox" />
                         Line Input - to - Washing Process </td>
                     </tr>
                     <tr>
                       <td><input type="radio" name="rdoRptType" id="radio2" class="txtbox" />
                         Washing - to - Shipping Process </td>
                     </tr>
                 </table></td>
               </tr>
               <tr>
                 <td height="23">&nbsp; PO Number</td>
                 <td><select name="cmbStyle" class="txtbox" style="width:190px" id="cmbStyle" tabindex="6">
                     <option value=""></option>
				   <?php 
			$strpo="select 	intStyleId, strOrderNo from orders where intStatus=11 order by strOrderNo ";
		
			$poresults=$db->RunQuery($strpo);
			
		while($porow=mysql_fetch_array($poresults))
		{
			if($cmbStyle==$porow["intStyleId"])
			echo "<option selected=\"selected\" value=\"". $porow["intStyleId"] ."\">" . $porow["strOrderNo"] ."</option>" ;
			else
			echo "<option value=\"". $porow["intStyleId"] ."\">" . $porow["strOrderNo"] ."</option>" ;
		}		
		?>  
              </select></td>
               </tr>
               <tr>
                 <td height="10" colspan="6" ></td>
               </tr>
             </table>
             </td>
           </tr>
         </table></td>	    
		</tr>
		<tr>
		<td height="15" colspan="6" class="mainHeading2">PRODUCTION WORK IN PROGRESS  </td>
		</tr>
	  <tr>
	    <td height="15" colspan="6" align="center"><div id="divcons"   style="overflow:scroll; height:500px;width:1200px" >
          <table  cellpadding="3" cellspacing="1" bgcolor="#CCCCFF" id="tblWip" >
            <tr class="mbari8">
              <td  height="25" class="mainHeading4" width="2%" nowrap="nowrap">&nbsp; </td>
			  <td  height="25" class="mainHeading4" width="2%" nowrap="nowrap">Manufacturer </td>
              <td  height="25" class="mainHeading4" width="2%" nowrap="nowrap">Order No</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Style No</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Buyer</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Order Qty</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Color</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Season</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Cut Qty</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Cut Rate</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Cut Total Value</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Issued to factory</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Balance</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Canceled</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">GPT In Qty</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Return Qty</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Variance</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">In Put</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Out Put </td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">In Out Balance</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Missing PCs Charge Back </td>
              <td  class="mainHeading4" width="1%" nowrap="nowrap">Wash Ready</td>
              <td  class="mainHeading4" width="1%" nowrap="nowrap">Wash Balance</td>
              <td  class="mainHeading4" width="1%" nowrap="nowrap">Finish Good Gp</td>
              <td  class="mainHeading4" width="1%" nowrap="nowrap">Finish Good Received</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Sewing Tot Balance </td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Sewing Rates</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Sewing Tot Value</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Wash Rec</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Missing Pcs Carge Back & QC/Wash/Sand Blast Standard For Washing Plant</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Issued Wash</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Sent Pcs</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">Wsh Return</td>
              <td  class="mainHeading4" width="2%" nowrap="nowrap">At Washing</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Wash Rate</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Wash Total Value</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Checking Trimming Input</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Checking Trimming Output</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Balance</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Packing Input</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Packed</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Packing For Sample</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Return To Stores</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Packed Balance</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Packing Total Pcs</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Packing Rate</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Packing Total Value</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">FG Out From Fact</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Shipped Qty</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Finished TTL</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Finished Rate</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Finished Value</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">INV.NO</td>
			  <td  class="mainHeading4" width="2%" nowrap="nowrap">Balance at yard</td>
			  </tr>
		<?php
          
		   $sql ="select comp.strName,
		   			ordr.intStyleId,
					ordr.strStyle,
					ordr.strOrderNo,
					WV.dblCutting,
					WV.dblSewing,
					pwip.intStyleID, 
					pwip.strColor, 
					pwip.strSeason, 
					pwip.intSourceFactroyID, 
					pwip.intDestinationFactroyID, 
					pwip.intOrderQty, 
					pwip.intCutQty, 
					pwip.intCutIssueQty, 
					pwip.intCutReceiveQty, 
					pwip.intCutReturnQty, 
					pwip.intInputQty, 
					pwip.intOutPutQty, 
					pwip.intMissingPcs, 
					pwip.intWashReady, 
					pwip.intSentToWash, 
					pwip.intMissingPcsBeforeWash, 
					pwip.intIssuedtoWash, 
					pwip.intFGReturnsBeforeWash,
					pwip.intFGgatePass, 
					pwip.intFGReceived,
					ordr.intQty,
					ordr.intSeasonId,
					ordr.reaSMV,
					ordr.reaSMVRate,
					B.buyerCode
					from 
					productionwip pwip inner join orders ordr on ordr.intStyleID=pwip.intStyleID
					left join companies comp on comp.intCompanyID=pwip.intDestinationFactroyID
					inner join wip_valuation WV on WV.intCompanyId=pwip.intDestinationFactroyID
					inner join buyers B on B.intBuyerID=ordr.intBuyerID
					where pwip.intStyleID <> 'a' "; 
		if($cmbFactory!="")
		$sql .= "and pwip.intDestinationFactroyID='$cmbFactory' ";
		if($cmbStyle!="")
		$sql .= "and pwip.intStyleID='$cmbStyle' ";
		
		$sql .= "order by ordr.strOrderNo";
		
		$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$season = '';
			if($row["intSeasonId"] != '')	
			$season = getSeason($row["intSeasonId"]);
			$Cuttingbalance = $row["intCutQty"]-$row["intCutIssueQty"];
			$inOutBal = $row["intInputQty"]-$row["intOutPutQty"];
			$cutRate = round((($row["reaSMV"]*$row["dblCutting"])/100)*($row["reaSMVRate"]),4);
			$sewingTotBal = ($row["intOutPutQty"]-$row["intWashReady"]);
			$sewingRate = round((($row["reaSMV"]*$row["dblSewing"])/100)*($row["reaSMVRate"]),4);
        ?>            
            <tr class="bcgcolor-tblrowLiteBlue">
              <td  height="25" class="normalfntMid" width="2%" nowrap="nowrap"><img src="../../images/print_icon.png"alt="Report"onclick="print_wip()" /></td>
			  <td  height="25" class="normalfnt" width="2%" nowrap="nowrap"><?php echo $row["strName"]; ?></td>
              <td  height="25" class="normalfnt" width="2%" nowrap="nowrap" id="<?php echo $row["intStyleId"]; ?>"><?php echo $row["strOrderNo"]; ?></td>
              <td  class="normalfnt" width="2%" nowrap="nowrap"><?php echo $row["strStyle"]; ?></td>
              <td  class="normalfnt" width="2%" nowrap="nowrap"><?php echo $row["buyerCode"]; ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo $row["intQty"]; ?></td>
              <td  class="normalfnt" width="2%" nowrap="nowrap"><?php echo $row["strColor"]; ?></td>
              <td  class="normalfnt" width="2%" nowrap="nowrap"><?php echo $season; ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo $row["intCutQty"]; ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo number_format($cutRate,4); ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo number_format(($Cuttingbalance>=0?$Cuttingbalance:0)*$cutRate,4); ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo $row["intCutIssueQty"]; ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo ($Cuttingbalance>=0?$Cuttingbalance:0) ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo ($Cuttingbalance<0?($Cuttingbalance*-1):0) ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo $row["intCutReceiveQty"]; ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo $row["intCutReturnQty"]; ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo $row["intInputQty"]; ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo $row["intOutPutQty"]; ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo $inOutBal; ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
              <td  class="normalfntRite" width="1%" nowrap="nowrap"><?php echo $row["intWashReady"]; ?></td>
              <td  class="normalfntRite" width="1%" nowrap="nowrap">0</td>
              <td  class="normalfntRite" width="1%" nowrap="nowrap"><?php echo $row["intFGgatePass"]; ?></td>
              <td  class="normalfntRite" width="1%" nowrap="nowrap"><?php echo $row["intFGReceived"]; ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo $sewingTotBal; ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo number_format($sewingRate,4); ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap"><?php echo number_format($sewingTotBal*$sewingRate,4); ?></td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
              <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  <td  class="normalfntRite" width="2%" nowrap="nowrap">0</td>
			  </tr>
      <?php
		}
		?>
          </table>
        </div></td>
	    </tr>
	  <tr>
        <td width="10%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
        <td width="28%">&nbsp;</td>
        <td width="11%"></td>
		<td width="15%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
<?php
function getSeason($seasonId)
{
	global $db;
	$sql = " select strSeason from seasons where intSeasonId='$seasonId' ";
	$result = $db->RunQuery($sql); 
	$row = mysql_fetch_array($result);
	
	return $row["strSeason"];
}
?>
