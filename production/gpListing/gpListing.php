<?php
	session_start();
	$backwardseperator = "../../";
	include "${backwardseperator}authentication.inc";
	include "../../Connector.php";
	$companyId 		= $_SESSION["FactoryID"];
	$chkDate		= $_POST["chkDate"];
	$styleNo		= $_POST["cboStyle"];
	if(!isset($_POST["txtDateFrom"])&&$_POST["txtDateFrom"]==""){
		$_POST["txtDateFrom"]=date("d/m/Y");
		$_POST["txtDateTo"]=date("d/m/Y");
		$chkDate = "on";
	}
	
	$factoryID		= $_POST["cboFactory"];
	$gpFrom			= $_POST["txtGoNoFrom"];
	$gpTo			= $_POST["txtGoNoTo"];
	
	$dateFrom		= $_POST["txtDateFrom"];
	$dateFromArray 	= explode('/',$dateFrom);
	$dateTo			= $_POST["txtDateTo"];
	$dateToArray 	= explode('/',$dateTo);
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gate Pass Listing</title>
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script src="gpListing.js" type="text/javascript"></script>
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

<form name="frmGPListing" id="frmGPListing" action="gpListing.php" method="post">
	<tr>
		<td><?php include $backwardseperator."Header.php";?></td>
	</tr>
<table width="850" border="0" align="center" class="tableBorder">
	<tr>
	  <td colspan="5"><table width="100%" border="0" class="main_border_line">
			
			<tr>
			  <td colspan="6" class="mainHeading">Gate Pass Listing</td>
		  </tr>
			<tr>
			  <td width="20" class="normalfnt">&nbsp;</td>
				<td width="101" class="normalfnt">To Factory</td>
				<td width="254">
				<select name="cboFactory" id="cboFactory" class="txtbox" style="width:250px" onchange="loadStyle();" tabindex="1">
					<?php
					$SQL = "SELECT DISTINCT c.intCompanyID,c.strName
								FROM companies c
									INNER JOIN productiongpheader p ON p.intTofactory=c.intCompanyID
										WHERE c.intManufacturing=1;";
					$result = $db->RunQuery($SQL);
					
					echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
					while($row = mysql_fetch_array($result))
					{
						if($factoryID==$row["intCompanyID"])
							echo "<option value=\"" . $row["intCompanyID"] ."\" selected=\"selected\">" . $row["strName"] . "</option>";
						else
							echo "<option value=\"" . $row["intCompanyID"] ."\">" . $row["strName"] . "</option>";
					}
					?>
			  </select>			  </td>
				<td class="normalfnt">Order No/Style No</td>
				<td><select name="cboStyle" id="cboStyle" class="txtbox" style="width:250px">
<?php
$SQL = "SELECT PGH.intStyleId,O.strOrderNo,O.strStyle FROM productiongpheader PGH inner join orders O ON PGH.intStyleId = O.intStyleId ";
if($factoryID!="")
	$SQL .="WHERE PGH.intTofactory = '".$factoryID."' ";
	
$SQL .= "group by PGH.intStyleId order by O.strOrderNo ASC";
$result = $db->RunQuery($SQL);						
echo "<option value = \"". "" . "\">" . "Select One" . "</option>";
while($row = mysql_fetch_array($result))
{
	if($styleNo==$row["intStyleId"])
		echo "<option value=\"" . $row["intStyleId"] ."\" selected=\"selected\">" . $row["strOrderNo"].' / '.$row["strStyle"] . "</option>";
	else
		echo "<option value=\"" . $row["intStyleId"] ."\">" . $row["strOrderNo"].' / '.$row["strStyle"] . "</option>";
}
?>
					</select>				</td>
			    <td>&nbsp;</td>
			</tr>
			<tr>
			  <td class="normalfnt"><input name="chkDate" type="checkbox" id="chkDate"  onclick="ClearDate(this);"
			  <?php
			  	if($chkDate=="on")
					echo "checked=\"checked\"";
				else
					echo ""
			  ?> /></td>
				<td class="normalfnt">Date From</td>
				<td><input name="txtDateFrom" type="text" tabindex="9" class="txtbox" id="txtDateFrom" style="width:100px"  onmousedown="DisableRightClickEvent()" onmouseout="EnableRightClickEvent()" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($dateFrom=="" ? "":$dateFrom);?>"/><input name="reset1" type="text"  class="txtbox" style="visibility:hidden;" onclick="return showCalendar(this.id, '%d/%m/%Y');"/></td>
				
				<td width="112" class="normalfnt">Date To</td>
  	  	  	  <td width="255"><input name="txtDateTo" type="text" tabindex="9" class="txtbox" id="txtDateTo" style="width:100px"  onmousedown="DisableRightClickEvent()" onmouseout="EnableRightClickEvent()" onfocus="return showCalendar(this.id, '%d/%m/%Y');" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($dateTo=="" ? "":$dateTo);?>"/><input name="reset1" type="text"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"/></td>
	  	  	  <td width="80">&nbsp;</td>
			</tr>
			<tr>
			  <td class="normalfnt">&nbsp;</td>
				<td class="normalfnt">GP No From</td>
				<td><input name="txtGoNoFrom" id="txtGoNoFrom" type="text" class="txtbox" style="width:100px;" value="<?php echo $gpFrom ?>"/></td>
				
				<td width="112" class="normalfnt">GP No To</td>
			  <td width="255"><input name="txtGoNoTo" id="txtGoNoTo" type="text" class="txtbox" style="width:100px;" value="<?php echo $gpTo ?>"/></td>
				<td width="80"><img src="../../images/search.png" alt="search" onclick="ReloadPage();"/></td>
			</tr>
			
		</table></td>
    </tr>
	<tr>
	  <td colspan="5"> <div id="divcons" style="overflow:scroll; height:450px; width:850px">
		<table width="100%" border="0" id="tableGatePass" cellpadding="0" cellspacing="1" bgcolor="#CCCCFF">
		<thead>
		<tr class="mainHeading4">
			<th width="65" height="25" >GP No</th>
			<th width="127" >To Factory</th>
			<th width="111" >Order No </th>
			<th width="123" >Style No </th>
			<th width="72" >Date</th>
			<th width="84" >Total Qty</th>
			<th width="61" >View</th>
			<th width="71" >Report</th>
		</tr>
		</thead>
<?php
$dateFrom		= $_POST["txtDateFrom"];
$dateFromArray 	= explode('/',$dateFrom);
$dateTo			= $_POST["txtDateTo"];
$dateToArray 	= explode('/',$dateTo);
	$sql = "SELECT O.strOrderNo,O.strStyle,PGH.intGPnumber,PGH.intYear,PGH.dtmDate,PGH.dblTotQty,PGH.intTofactory,C.strName,PGH.intStatus FROM productiongpheader PGH join companies C on PGH.intTofactory=C.intCompanyID inner join orders O on O.intStyleId=PGH.intStyleId WHERE PGH.intFromFactory <> '0'";
	
if($factoryID!="")
	$sql .=" AND PGH.intTofactory = '".$factoryID."'";
if($styleNo!="")
	$sql .=" AND PGH.intStyleId = '".$styleNo."'";
if($dateFrom!="")
	$sql .=" AND date(PGH.dtmDate) >= '".$dateFromArray[2].'-'.$dateFromArray[1].'-'.$dateFromArray[0]."'";
if($dateTo!="")
	$sql .=" AND date(PGH.dtmDate) <= '".$dateToArray[2].'-'.$dateToArray[1].'-'.$dateToArray[0]."'";
if($gpFrom!="")
	$sql .=" AND PGH.intGPnumber >= '".$gpFrom."'";
if($gpTo!="")
	$sql .=" AND PGH.intGPnumber <= '".$gpTo."'";
  
  	$sql .="  ORDER BY PGH.intGPnumber DESC";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
	if($row["intStatus"]=='10')
		$className = "bcgcolor-InvoiceCostTrim";
	else
		$className = "bcgcolor-tblrowWhite";
?>
			<tr class="<?php echo $className;?>">
				<td height="20" class="normalfnt" nowrap="nowrap" ><a href="../cutting/gatepass/gatepass.php?gpnumber=<?php echo $row["intGPnumber"]?>&intYear=<?php echo $row["intYear"]?>" target="_blank" id="a">&nbsp;<?php echo $row["intYear"].'/'.$row["intGPnumber"]?>&nbsp;</a></td>
				<td class="normalfnt" nowrap="nowrap">&nbsp;<?php echo $row["strName"]?>&nbsp;</td>
				<td class="normalfnt" nowrap="nowrap">&nbsp;<?php echo $row["strOrderNo"]?>&nbsp;</td>
				<td class="normalfnt" nowrap="nowrap">&nbsp;<?php echo $row["strStyle"]?>&nbsp;</td>
				<td class="normalfnt" nowrap="nowrap">&nbsp;<?php echo $row["dtmDate"]?>&nbsp;</td>
				<td class="normalfntRite" nowrap="nowrap">&nbsp;<?php echo $row["dblTotQty"]?>&nbsp;</td>
				<td class="normalfntMid" nowrap="nowrap"><a href="../cutting/gatepass/gatepass.php?gpnumber=<?php echo $row["intGPnumber"]?>&intYear=<?php echo $row["intYear"]?>" target="_blank">&nbsp;<img src="../../images/view2.png" height="18" border="0"/>&nbsp;</a></td>
				<td class="normalfntMid" nowrap="nowrap"><a href="../cutting/gatepass/rptgatepass.php?gpnumber=<?php echo $row["intYear"].'/'.$row["intGPnumber"]?>" target="_blank">&nbsp;<img src="../../images/report.png" height="18" border="0"/>&nbsp;</a></td>
			</tr>
<?php
	}
?>
		</table>
		</div></td>
    </tr>
	<tr class="tableBorder">
	<td height="20" ><table width="100%" border="0" cellspacing="1" cellpadding="0" class="tableBorder">
		<tr >
		<td height="20" width="3">&nbsp;</td>
		<td width="20" class="txtbox bcgcolor-tblrowWhite">&nbsp;</td>
		<td width="208" class="normalfnt">&nbsp;Confirm GatePass </td>
		<td width="20" class="txtbox bcgcolor-InvoiceCostTrim">&nbsp;</td>
		<td width="580" class="normalfnt">&nbsp;Cancel GatePass</td>
	</tr>
    </table></td>
	</tr>
</table>
</form>
</body>
</html>