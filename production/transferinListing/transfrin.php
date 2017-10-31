<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";

	$companyId 		= $_SESSION["FactoryID"];
	$styleNo		= $_POST["cboStylNo"];

	if(!isset($_POST["txtOrderNo"]) && $_POST["txtOrderNo"]=="")
	{
		$dateFrom = date("Y-m-d");
		$dateTo   = date("Y-m-d");
		$chkDate = "on";
	}
	else
	{
		$chkDate		= $_POST["chkDate"];
		$dateFrom		= $_POST["txtDateFrom"];
		$dateTo			= $_POST["txtDateTo"];
	}
	$OrderNo		= $_POST["txtOrderNo"];
	$tranInNoFrm	= $_POST["txtTranferInFrm"];
	$tranInNoTo		= $_POST["txtTranferInTo"];
	$GPNoFrm		= $_POST["txtGPNoFrm"];
	$GPNoTo			= $_POST["txtGPNoTo"];
	
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cut PC's Transfer In Listing</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<link rel="stylesheet" type="text/css" href="../../js/jquery-ui-1.8.9.custom.css"/>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script src="transfrin.js" type="text/javascript"></script>
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
<script>
function ClearDate(obj)
{
	if(obj.checked)
	{
		document.getElementById('txtDateFrom').value = "<?php echo date("Y-m-d"); ?>";
		document.getElementById('txtDateTo').value = "<?php echo date("Y-m-d"); ?>";
		document.getElementById('txtDateFrom').disabled = false;
		document.getElementById('txtDateTo').disabled = false;
	}
	else
	{
		document.getElementById('txtDateFrom').value = "";
		document.getElementById('txtDateTo').value = "";
		document.getElementById('txtDateFrom').disabled = true;
		document.getElementById('txtDateTo').disabled = true;
	}
}
function loadGrid()
{
	document.frmInputListing.submit();
}
</script>
</head>

<body>
<?php
	include "../../Connector.php";	
?>
<form id="frmInputListing" name="frmInputListing" method="post" action="transfrin.php">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
   <tr>
		<td><?php include $backwardseperator."Header.php";?></td>
   </tr>
   <tr>
     <td>
		<table width="850" border="0" cellpadding="0" cellspacing="1" align="center" bgcolor="#FFFFFF" class="tableBorder">
        <tr>
         <td height="24"class="mainHeading"> Cut PC's Transfer In Listing </td>
        </tr>
        <tr>
          <td>
          	<table width="100%" border="0" cellpadding="0" cellspacing="1" align="center" bgcolor="#FFFFFF">
            <tr>
              <td>
                <table width="100%" border="0" cellpadding="0" cellspacing="1" class="tableBorder">
			<tr>
				<td></td>
			</tr>
			<tr>
				<td width="23">&nbsp;</td>
				<td width="149" class="normalfnt">Style No</td>
				<td><select name="cboStylNo" id="cboStylNo" style="width:200px;" onchange="loadOrderNo(this.value)">
				  <?php 
			  $sql = "select distinct o.strStyle
						from orders o inner join productiongpheader pgph on
						o.intStyleId = pgph.intStyleId inner join productiongptinheader pgpth on
						pgpth.intGPnumber = pgph.intGPnumber and 
						pgpth.intGPYear = pgph.intYear 
						where pgpth.intFactoryId='$companyId'
						order by o.strStyle ";
			
				$result = $db->RunQuery($sql);
					
					echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
					while($row = mysql_fetch_array($result))
					{
						if($styleNo==$row["strStyle"])
						echo "<option value=\"" . $row["strStyle"] ."\" selected=\"selected\">" . $row["strStyle"] ."</option>";
						else
						echo "<option value=\"" . $row["strStyle"] ."\" >" . $row["strStyle"] ."</option>";
					}		
						
			  ?>
				  </select></td>
				<td><span class="normalfnt">Order No</span></td>
				<td> <input type="text" name="txtOrderNo" id="txtOrderNo" class="txtbox" style="width:200px" value="<?php echo ($OrderNo!="" ? $OrderNo:'');?>"/></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td class="normalfnt">Transer In# From </td>
			  <td><input type="text" name="txtTranferInFrm" id="txtTranferInFrm" class="txtbox" style="width:200px" value="<?php echo ($tranInNoFrm!="" ? $tranInNoFrm:'');?>"/></td>
			  <td class="normalfnt">Transer In#  To</td>
			  <td><input type="text" name="txtTranferInTo" id="txtTranferInTo" class="txtbox" style="width:200px" value="<?php echo ($tranInNoTo!="" ? $tranInNoTo:'');?>"/></td>
			  <td>&nbsp;</td>
		    </tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalfnt">Gate Pass # From</td>
				<td width="253"><input type="text" name="txtGPNoFrm" id="txtGPNoFrm" class="txtbox" style="width:200px" value="<?php echo ($GPNoFrm!="" ? $GPNoFrm:'');?>"/></td>
				<td width="103" class="normalfnt">Gate Pass #To</td>
	  	  	  	<td width="202"><input type="text" name="txtGPNoTo" id="txtGPNoTo" class="txtbox" style="width:200px" value="<?php echo ($GPNoTo!="" ? $GPNoTo:'');?>"/></td>
	  	  	  	<td width="92">&nbsp;</td>
			</tr>
			<tr>
				<td align="center"><span class="normalfnt">
				  <input name="chkDate" type="checkbox" id="chkDate"  onclick="ClearDate(this);"
			  <?php
			  	if($chkDate=="on")
					echo "checked=\"checked\"";
			  ?> />
				</span></td>
				<td class="normalfnt">Date From</td>
				<td><input name="txtDateFrom" type="text" tabindex="9" class="txtbox" id="txtDateFrom" style="width:100px"  onmousedown="DisableRightClickEvent()" onmouseout="EnableRightClickEvent()" onfocus="return showCalendar(this.id, '%Y-%m-%d');" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($dateFrom=="" ? "":$dateFrom);?>" <?php echo ($chkDate!="on"?'disabled="disabled"':"");?> /><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
				
				<td width="103" class="normalfnt">Date To</td>
	  	  	  	<td width="202"><input name="txtDateTo" type="text" tabindex="9" class="txtbox" id="txtDateTo" style="width:100px"  onmousedown="DisableRightClickEvent()" onmouseout="EnableRightClickEvent()" onfocus="return showCalendar(this.id, '%Y-%m-%d');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($dateTo=="" ? "":$dateTo);?>" <?php echo ($chkDate!="on"?'disabled="disabled"':"");?> /><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
	  	  	  	<td width="92"><img src="../../images/search.png" alt="save" onclick="loadGrid()"/></td>
	  	  	</tr>
			<tr>
			  <td></td>
			  </tr>
		</table>
         </td>
            </tr>
         <tr>
         <td>
		<div id="divcons" style="overflow:scroll; height:450px; width:850px;">
        <table width="833" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF" id="tableGatePass">
			<tr class="mainHeading2">
				<td height="20" colspan="7">Gate Pass</td>
			</tr>
			<tr class="mainHeading4">
				<th height="25" width="127" >Transf No</th>
				<th width="134" >Gate Pass No</th>
				<th width="122" >Date</th>
				<th width="117" >Total Qty</th>
				<th width="99" >View</th>
				<th width="123" >Report</th>
			</tr>
            <?php
			$sqlLoad = "SELECT 
						pgpth.dblCutGPTransferIN, 
						pgpth.intGPnumber, 
						pgpth.intGPTYear, 
						date(pgpth.dtmGPTransferInDate) as dtmGPTransferInDate, 
						pgpth.dblTotQty 
						from orders o inner join productiongpheader pgph on
						o.intStyleId = pgph.intStyleId inner join productiongptinheader pgpth on
						pgpth.intGPnumber = pgph.intGPnumber and 
						pgpth.intGPYear = pgph.intYear
						WHERE
						pgpth.intFactoryId='$companyId' ";
			
			if($styleNo!="")
			$sqlLoad.="and o.strStyle='$styleNo' ";
			
			if($OrderNo!="")
			$sqlLoad.="and o.strOrderNo='$OrderNo' ";
			
			if($tranInNoFrm!="")
			$sqlLoad.="and pgpth.dblCutGPTransferIN >= '$tranInNoFrm' ";
			 
			if($tranInNoTo!="")
			$sqlLoad.="and pgpth.dblCutGPTransferIN <= '$tranInNoTo' ";
			
			if($GPNoFrm!="")
			$sqlLoad.="and pgpth.intGPnumber >= '$GPNoFrm' ";
			
			if($GPNoTo!="")
			$sqlLoad.="and pgpth.intGPnumber <= '$GPNoTo' ";
			
			if($chkDate=="on")
			{
				if($dateFrom!="")
				$sqlLoad.="and pgpth.dtmGPTransferInDate >= '$dateFrom' ";
				
				if($dateTo!="")
				$sqlLoad.="and pgpth.dtmGPTransferInDate <= '$dateTo' ";
			}
			
			$sqlLoad.="ORDER BY pgpth.dblCutGPTransferIN DESC ";
			
			$result = $db->RunQuery($sqlLoad);
			while($row = mysql_fetch_array($result))
			{
			?>
            	<tr class="bcgcolor-tblrowWhite">
                <td height="20" width="127" class="normalfnt" nowrap="nowrap"><a href="../cutPc/cutPC.php?inputSerialNumber=<?php echo $row["dblCutGPTransferIN"]?>&intYear=<?php echo $row["intGPTYear"]?>&id=1" target="cutPC.php" id="cutPC.php">&nbsp;<?php echo $row["intGPTYear"].'/'.$row["dblCutGPTransferIN"]?>&nbsp;</a></td>
				<td width="134" class="normalfnt">&nbsp;<?php echo $row["intGPnumber"]; ?>&nbsp;</td>
				<td width="122" class="normalfntMid">&nbsp;<?php echo $row["dtmGPTransferInDate"]; ?>&nbsp;</td>
				<td width="117" class="normalfnt" style="text-align:right">&nbsp;<?php echo number_format($row["dblTotQty"],2); ?>&nbsp;</td>
				<td width="99"  class="normalfntMid"><a target="cutPC.php" class="non-html pdf" href="../cutPc/cutPC.php?inputSerialNumber=<?php echo $row["dblCutGPTransferIN"]?>&intYear=<?php echo $row["intGPTYear"]?>&id=1"/><img src="../../images/view2.png" border="0" /></a></td>
				<td width="123" class="normalfntMid"><a target="rptCutPC.php" class="non-html pdf" href="../cutPc/rptCutPC.php?inputSerialNumber=<?php echo $row["dblCutGPTransferIN"]?>&intYear=<?php echo $row["intGPTYear"]?>"><img src="../../images/view2.png" border="0"/></a></td>
                </tr>
               <?php
			}
			?>
		</table></div>
		<br/>
              </td>
            </tr>
            </table>
          </td>
        </tr>
        </table>
     </td>
   </tr>
</table>

		
	</form>
</body>
</html>