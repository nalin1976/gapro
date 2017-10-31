<?php

session_start();
include "../Connector.php";	
$backwardseperator = "../";
$companyId 			= $_SESSION["FactoryID"];
$nGatePassNoFrom	= $_POST["txtNGatePassNoFrom"];
$nGatePassNoTo		= $_POST["txtNGatePassNoTo"];
$searchDescription	= $_POST["txtSearchDescription"];
$chkdate			= $_POST["chkdate"];
$datefrom			= $_POST["txtDatefrom"];
$dateTo				= $_POST["txtDateTo"];
$status				= $_POST["cboReportSatus"];
if(!isset($_POST["cboReportSatus"])&&$_POST["cboReportSatus"]=="")
	$status = 0;
//$mkDate				= date("m")-1,'/',date("d"),'/',date("Y");
$fMonth				= date("m", strtotime('-1 month'));//get previous month
$fDate				= date("d");
$fYear				= date("Y");
$mkDate				= $fDate.'/'.$fMonth.'/'.$fYear;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Normal GatePass Listing</title>
<script type="text/javascript" src="nomgatepass.js"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>

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
var factoryID = <?php

 echo $_SESSION["CompanyID"]; 
 ?>;
var UserID = <?php
 session_start();
 echo $_SESSION["UserID"]; 
 ?>;
var EscPercentage = 0.25;
 
var serverDate = new Date();
serverDate.setYear(parseInt(<?php
echo date("Y"); 
?>));
serverDate.setMonth(parseInt(<?php
echo date("m"); 
?>));
serverDate.setDate(parseInt(<?php
echo date("d")+1; 
?>));
</script>

</head>
<body>
<form name="frmNGList" id="frmNGList" action="nomgatepasslist.php" method="post">
  <tr>
    <td><?php include "${backwardseperator}Header.php"; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td class="mainHeading">Normal Gate Pass Listing&nbsp;&nbsp;&nbsp;&nbsp;
      <select name="cboReportSatus" id="cboReportSatus" style="width:160px">
	  <option value="0" <?php echo ($status=='0'? "selected=selected":"");?>>Pending Gate Pass</option>
	  <option value="1" <?php echo ($status=='1'? "selected=selected":"");?>>Confirmed Gate Pass</option>
	  <option value="10" <?php echo ($status=='10'? "selected=selected":"");?>>Cancelled Gate Pass</option>
      </select>
      </td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="100%" border="0" cellpadding="2" cellspacing="0" class="tableBorder">
          <tr>
            <td width="11%" height="24" nowrap="nowrap" class="normalfnt">GatePass No From</td>
            <td width="9%" class="normalfnt"><input type="text" name="txtNGatePassNoFrom" class="txtbox" id="txtNGatePassNoFrom" style="width:80px" value="<?php echo $nGatePassNoFrom=="" ? "":$nGatePassNoFrom?>">            </td>
            <td width="10%" class="normalfnt" nowrap="nowrap">GatePass No To</td>
            
			<td width="27%" class="normalfnt"><input type="text" name="txtNGatePassNoTo" class="txtbox" id="txtNGatePassNoTo" style="width:80px" value="<?php echo $nGatePassNoTo=="" ? "":$nGatePassNoTo?>"></td>
			           
			<td width="2%" class="normalfnt">&nbsp;</td>
			<td width="7%" nowrap="nowrap" class="normalfnt">
			<input type="checkbox" id="chkdate" name="chkdate" <?php if($chkdate){?> checked="checked"<?php } ?>>
			&nbsp;Date From</td>
            <td width="10%" class="normalfnt" nowrap="nowrap"><input name="txtDatefrom" type="text" class="txtbox" id="txtDatefrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo $datefrom=="" ? $mkDate:$datefrom;?>"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');">	              </td>
            <td width="5%" nowrap="nowrap" class="normalfnt">Date to</td>
            <td width="10%" class="normalfnt" nowrap="nowrap"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo $dateTo=="" ? date("d/m/Y"):$dateTo;?>"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');">			</td>
            <td width="9%" class="normalfnt"><img src="../images/search.png" alt="search" width="80" height="24" onclick="ReloadPage();" /></td>
          </tr>
          <tr>
            <td height="24" class="normalfnt">Description like </td>
            <td colspan="4" class="normalfnt"><input type="text" id="txtSearchDescription" name="txtSearchDescription" style="width:262px" value="<?php echo $searchDescription =="" ? "":$searchDescription?>"/></td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
        </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="18" class="mainHeading2"><div align="center">Saved Gate Pass Details   </div></td>
        </tr>
      <tr>
        <td class="normalfnt"><div id="divtblIssueDetails" style="overflow:scroll; height:400px; width:950px;">
          <table id="tblIssueDetails" width="100%" cellpadding="0" cellspacing="1"  bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <td width="17%" height="25" >Gatepass No</td>
              <td width="15%" >Date</td>
              <td width="42%" >Gatepass To </td>
			  <td width="13%" >View Report </td>
              </tr>
<?php
$fromArray 	= explode('/',$datefrom);
$toArray 	= explode('/',$dateTo);
	$sql ="SELECT distinct concat(GSH.intYear,'/',GSH.intGatepassId) as no , GSH.dtmDate ,GSH.intStatus, GSH.intToStores AS strName 
FROM  nomgatepassheader GSH inner join nomgatepassdetail NGD on NGD.intGatepassId=GSH.intGatepassId and NGD.intYear=GSH.intYear WHERE GSH.intCompanyID='$companyId' and GSH.intStatus = '$status'";
	
	if($nGatePassNoFrom!="")
			$sql .="AND GSH.intGatepassId >='" . $nGatePassNoFrom . "' "; 
	if ($nGatePassNoTo!="")
			$sql .="AND GSH.intGatepassId <='" . $nGatePassNoTo . "' ";
	if ($searchDescription!="")
			$sql .="AND NGD.intMatDetailID like '%$searchDescription%' ";
	if($chkdate)
	{
		if($datefrom!="")
				$sql .="AND date(dtmDate) >= '" . $fromArray[2].'-'.$fromArray[1].'-'.$fromArray[0] . "' ";
		
		if($dateTo!="")
				$sql .="AND date(dtmDate) <= '" . $toArray[2].'-'.$toArray[1].'-'.$toArray[0] . "' ";
	}
	$sql .="Order by GSH.intYear,GSH.intGatepassId DESC";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
?>
<tr class="bcgcolor-tblrowWhite" onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';">
<td class="normalfntMid"><a target="_blank" href="<?php echo "nomgatepass.php?No=".$row["no"] ;?>" ><?php echo $row["no"]?></a></td>
<td class="normalfntMid"><?php echo $row["dtmDate"];?></td>
<td class="normalfnt"><?php echo $row["strName"];?></td>
<td class="normalfntMid mouseover"><img src="../images/view.png" onclick="showReport1('<?php echo $row["no"];?>')"></td>
</tr>
<?php
}
?>								  
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffe1e1">
      <tr>
        <td width="40%" ><div align="center">
        <img src="../images/new.png" class="mouseover" title="New"  alt="new" width="96" height="24" onclick="ClearForm();" />        
        <a href="../main.php"><img src="../images/close.png" title="Go to home page" width="97" height="24" border="0" /></a></div></td>       
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
