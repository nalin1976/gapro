<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";

	$companyId 		= $_SESSION["FactoryID"];
	$style			= $_POST["cboStyle"];

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
	$OrderNo			= $_POST["txtOrderNo"];
	$WashReadyNoFrm		= $_POST["txtWashReadyNoFrm"];
	$WashReadyTo		= $_POST["txtWashReadyNoTo"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Production Wash Ready Listing</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<link rel="stylesheet" type="text/css" href="../../js/jquery-ui-1.8.9.custom.css"/>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script src="washReadyListing.js" type="text/javascript"></script>
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
	document.frmWashReadyListing.submit();
}
</script>
</head>

<body>
<?php
	include "../../Connector.php";	
?>
<form id="frmWashReadyListing" name="frmWashReadyListing" method="post" action="washReadyListing.php">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
   <tr>
		<td><?php include $backwardseperator."Header.php";?></td>
   </tr>
   <tr>
     <td>
     	<table width="850" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
        <tr>
         <td height="24"class="mainHeading"> Production Wash Ready Listing  </td>
        </tr>
         <tr>
         <td>
          	<table width="100%" border="0" cellpadding="0" cellspacing="3" align="center" bgcolor="#FFFFFF">
            <tr>
              <td><table width="100%" border="0" class="main_border_line">
                <tr>
                  <td></td>
                </tr>
                <tr>
                  <td width="19">&nbsp;</td>
                  <td width="126" class="normalfnt">Style No</td>
                  <td width="244"><select name="cboStyle" id="cboStyle" class="txtbox" style="width:200px" onchange="loadOrderNo(this.value)" >
                    <?php
                $SQL = "select distinct O.strStyle
						from orders O 
						inner join productionwashreadyheader PWRH on PWRH.intStyleId=O.intStyleId
						where PWRH.intFactory='$companyId'
						order by O.strStyle ASC";
                $result = $db->RunQuery($SQL);
                
				echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
				while($row = mysql_fetch_array($result))
				{
					if($style==$row["strStyle"])
					echo "<option value=\"" . $row["strStyle"] ."\" selected=\"selected\">" . $row["strStyle"] . "</option>";
					else
					echo "<option value=\"" . $row["strStyle"] ."\">" . $row["strStyle"] . "</option>";
				}
   			 ?>
                    <option></option>
                  </select></td>
                  <td class="normalfnt">Order No</td>
                  <td><input type="text" name="txtOrderNo" id="txtOrderNo" class="txtbox" style="width:200px" value="<?php echo ($OrderNo!="" ? $OrderNo:'');?>"/></td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="normalfnt">Wash Ready No From</td>
                  <td><input type="text" class="txtbox" name="txtWashReadyNoFrm" id="txtWashReadyNoFrm" style="width:200px" value="<?php echo ($WashReadyNoFrm!="" ? $WashReadyNoFrm:'');?>" /></td>
                  <td width="117" class="normalfnt">Wash Ready No To</td>
                  <td width="218"><input type="text" class="txtbox" name="txtWashReadyNoTo" id="txtWashReadyNoTo" style="width:200px" value="<?php echo ($WashReadyTo!="" ? $WashReadyTo:'');?>" /></td>
                  <td width="98">&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="normalfnt">
                    <input name="chkDate" type="checkbox" id="chkDate"  onclick="ClearDate(this);"
			  <?php
			  	if($chkDate=="on")
					echo "checked=\"checked\"";
			  ?> />
                  </span></td>
                  <td class="normalfnt">Date From</td>
                  <td><input name="txtDateFrom" type="text" tabindex="9" class="txtbox" id="txtDateFrom" style="width:100px"  onmousedown="DisableRightClickEvent()" onmouseout="EnableRightClickEvent()" onfocus="return showCalendar(this.id, '%Y-%m-%d');" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($dateFrom=="" ? "":$dateFrom);?>" <?php echo ($chkDate!="on"?'disabled="disabled"':"");?> /><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                  <td width="117" class="normalfnt">Date To</td>
                  <td width="218"><input name="txtDateTo" type="text" tabindex="9" class="txtbox" id="txtDateTo" style="width:100px"  onmousedown="DisableRightClickEvent()" onmouseout="EnableRightClickEvent()" onfocus="return showCalendar(this.id, '%Y-%m-%d');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo ($dateTo=="" ? "":$dateTo);?>" <?php echo ($chkDate!="on"?'disabled="disabled"':"");?> /><input name="reset3" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                  <td width="98"><img src="../../images/search.png" alt="search" onclick="loadGrid()"/></td>
                </tr>
                <tr>
                  <td></td>
                </tr>
              </table></td>
        </tr>
        <tr>
        <td>
		<div id="divcons" style="overflow:scroll; height:450px; width:850px;">
        <table width="833" border="0" cellspacing="1" id="tableGatePass" bgcolor="#CCCCFF">
			<tr class="mainHeading2">
				<td height="15" colspan="9" >Wash Ready </td>
			</tr>
			<tr class="mainHeading4">
				<th height="20" width="87" >Transf No</th>
				<th width="150" >Order No</th>
				<th width="151" >Style No</th>
				<th width="88" >Date</th>
				<th width="78" >Total Qty</th>
				<th width="100" >View</th>
				<th width="100" >Report</th>
			</tr>
            <?php
			$sql = "SELECT PWRH.intWashreadySerial,PWRH.intWashReadyYear,PWRH.dtmDate,PWRH.dblTotQty,O.strOrderNo,O.strStyle 
					FROM productionwashreadyheader PWRH 
					inner join orders O on O.intStyleId=PWRH.intStyleId 
					WHERE PWRH.intFactory ='$companyId' ";
			
			if($style!="")
			$sql.="and O.strStyle='$style' ";
			
			if($OrderNo!="")
			$sql.="and O.strOrderNo='$OrderNo' ";
			
			if($WashReadyNoFrm!="")
			$sql.="and PWRH.intWashreadySerial>='$WashReadyNoFrm' ";
			
			if($WashReadyTo!="")
			$sql.="and PWRH.intWashreadySerial<='$WashReadyTo' ";
			
			if($chkDate=="on")
			{
				if($dateFrom!="")
				$sql.="and PWRH.dtmDate >= '$dateFrom' ";
				
				if($dateTo!="")
				$sql.="and PWRH.dtmDate <= '$dateTo' ";
			}
			
			$sql.="  ORDER BY PWRH.intWashreadySerial DESC";
			
			$result = $db->RunQuery($sql);
			while($row = mysql_fetch_array($result))
			{
			?>
            <tr class="bcgcolor-tblrowWhite">
				<td height="20" width="87" class="normalfnt" nowrap="nowrap" ><a target="_blank" class="non-html pdf" href="../productionwashready/washReady.php?SerialNumber=<?php echo $row["intWashreadySerial"]?>&intYear=<?php echo $row["intWashReadyYear"]?>&id=1 ">&nbsp;<?php echo $row["intWashReadyYear"].'/'.$row["intWashreadySerial"]?>&nbsp;</a></td>
				<td width="150" class="normalfnt" nowrap="nowrap" >&nbsp;<?php echo $row["strOrderNo"]; ?>&nbsp;</td>
				<td width="151" class="normalfnt" nowrap="nowrap" >&nbsp;<?php echo $row["strStyle"]; ?>&nbsp;</td>
				<td width="88" class="normalfnt" nowrap="nowrap" >&nbsp;<?php echo $row["dtmDate"]; ?>&nbsp;</td>
				<td width="78" class="normalfnt" nowrap="nowrap" style="text-align:right" >&nbsp;<?php echo number_format($row["dblTotQty"],2); ?>&nbsp;</td>
				<td width="100" class="normalfnt" nowrap="nowrap" ><a target="_blank" class="non-html pdf" href="../productionwashready/washReady.php?SerialNumber=<?php echo $row["intWashreadySerial"]?>&intYear=<?php echo $row["intWashReadyYear"]?>&id=1 "><img src="../../images/view2.png" height="18" border="0"/></a></td>
				<td width="100" class="normalfnt" nowrap="nowrap" ><a target="_blank" class="non-html pdf" href="../productionwashready/rptWashReady.php?SerialNumber=<?php echo $row["intWashreadySerial"]?>&intYear=<?php echo $row["intWashReadyYear"]?> "><img src="../../images/report.png" height="18" border="0"/></a></td>
			</tr>
            
            <?php
			}
			?>
		</table>
		</div>
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