<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
	$companyId 	= $_SESSION["FactoryID"];
	$No = 1;

	$GPDateFrom 		= $_POST["GPDateFrom"];
	
	$GPDateTO 			= $_POST["GPDateTo"];
	
	$storesCategory 	= $_POST["radiobutton"];
	$chkDate			= $_POST["chkDate"];
	$category			= $_POST["cbocategory"];
	$gatePassNoFrom 	= $_POST["GPNOFrom"];
	$gatePassNoTo		= $_POST["GPNOTo"];
	$destination		= $_POST["cboDestination"];
	if(!isset($_POST["cbocategory"])&&$_POST["cbocategory"]=="")
	{
		
		$GPDateFrom	= date("d/m/Y");
		$GPDateTO	= date("d/m/Y");
		$chkDate 	= "on";
		$category 	= 0;
		$storesCategory = "I";
	}	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Bulk-GatePass Details List</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<script type="text/javascript" src="bulkgatepass.js"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../java.js" type="text/javascript"></script>

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
<tr>
<td><?php include '../Header.php'; ?></td>
</tr>
<form name="frmBulkGPListing" id="frmBulkGPListing" action="bulkgatepasslist.php" method="post">
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td class="mainHeading"><table width="100%" border="0"  >
      <tr>
        <td width="20%">Bulk - Gate Pass List</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
      <tr>
        <td width="1%" valign="middle" class="normalfnt"></td>
        <td width="40%" valign="middle" class="normalfnt"><table width="299" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
		
              <tr>
                <td width="78" style="text-align:center">Category</td>			  
                <td width="108" style="text-align:center">
                  <input name="radiobutton" type="radio" value="I" <?php echo($storesCategory=="I" ? "checked=\"checked\"":"");?> id="radiobutton" />
                  Internal</td>
                <td width="111" style="text-align:center">
                    <input name="radiobutton" type="radio" value="E" <?php echo($storesCategory=="E" ? "checked=\"checked\"":"");?> id="radiobutton"/>
					External                </td>
              </tr>
            </table></td>
            <td width="13%" class="normalfnt">Destination</td>
            <td width="21%"><select name="cboDestination" id="cboDestination" style="width:150px;">
            <?php
$xml = simplexml_load_file('../config.xml');
$AllowSubContractorToGatePass = $xml->styleInventory->AllowSubContractorToGatePass;
$SQL="";
if($AllowSubContractorToGatePass=="true"){	
	$SQL="select strSubContractorID,strName from subcontractors  where intStatus =1";
	$result=$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">"."Select Destination"."</option>";
		
	while($row=mysql_fetch_array($result))
	{
		
		echo "<option value =\"".$row["strSubContractorID"]."\">".$row["strName"]."</option>";
	}
}
else{
	$SQL="select strMainID,strName from mainstores  where intCompanyId <> '$companyId'";
	$result=$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">"."Select Destination"."</option>";
		
	while($row=mysql_fetch_array($result))
	{
		if($destination==$row["strMainID"])
		echo "<option value =\"".$row["strMainID"]."\" selected=\"selected\">".$row["strName"]."</option>";
		else
		echo "<option value =\"".$row["strMainID"]."\" >".$row["strName"]."</option>";
	}
	
}
			  
?>
            </select>
            </td>
        <td width="9%"><span class="normalfnt">Status</span></td>
        <td width="16%"><select name="cbocategory" class="txtbox" id="cbocategory" style="width:130px" >
          <option  value="0" <?php echo ($category=='0'? "selected=selected":"");?>>Pending for Process</option>
          <option value="1" <?php echo ($category=='1'? "selected=selected":"");?>>Processed</option>
          <option value="10"<?php echo ($category=='10'? "selected=selected":"");?>>Cancelled</option>
        </select>
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="tableBorder">
      <tr>
        <td width="13%" class="normalfnt">GatePass No From</td>
        <td width="14%" class="normalfnt"><input name="GPNOFrom" type="text" class="txtbox" id="GPNOFrom" size="20" value="<?php echo ($gatePassNoFrom=="" ? "":$gatePassNoFrom);?>" /></td>
        <td width="2%" class="normalfnt">To</td>
        <td width="15%" class="normalfnt"><input name="GPNOTo" type="text" class="txtbox" id="GPNOTo" size="20" value="<?php echo ($gatePassNoTo=="" ? "":$gatePassNoTo);?>" /></td>
        <td width="3%" class="normalfnt"><input type="checkbox" name="chkDate" id="chkDate" <?php echo($chkDate=="on" ? "checked=\"checked\"":"");?>/></td>
        <td width="8%" class="normalfnt">Date From</td>
        <td width="14%" class="normalfnt"><input name="GPDateFrom" type="text" class="txtbox" id="GPDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($GPDateFrom=="" ? "":$GPDateFrom);?>" /><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
        <td width="6%" class="normalfnt">To</td>
        <td width="14%" class="normalfnt"><input name="GPDateTo" type="text" class="txtbox" id="GPDateTo" size="15"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($GPDateTO=="" ? "":$GPDateTO);?>"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
        <td width="11%" class="normalfnt"><img src="../images/search.png"  alt="search" width="80" height="24" onclick="LoadBulkGateDetails();" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="mainHeading2"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td width="32%" >&nbsp;</td>
            <td width="56%" >&nbsp;</td>
            <td width="12%" >&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divGatePassDetails" style="overflow:scroll; height:450px; width:950px;">
          <table id="tblGatePassDetails" width="100%" cellpadding="0" border="0" cellspacing="1" bgcolor="#CCCCFF" >
            <tr class="mainHeading4">
			  <td width="2%" height="25">No</td>	
              <td width="12%">GatePass No</td>
              <td width="18%">Date</td>
              <td width="38%">Destination</td>
			  <td width="19%">User</td>
			  <td width="15%">View</td>
			  </tr>
			<?php
$SQL =  "SELECT DISTINCT BGP.intGatePassNo,BGP.intGatePassYear,date(BGP.dtmDate) as dtmDate ,BGP.intStatus, 
				(select Name from useraccounts UA where UA.intUserID=BGP.intUserId)as userName,
				(select strName from mainstores MS  where MS.strMainID=BGP.intDestination) as Destination
				 FROM bulk_gatepassheader AS BGP 
				 Inner Join bulk_gatepassdetails AS BGPD ON BGP.intGatePassNo = BGPD.intGatePassNo AND BGP.intGatePassYear = BGPD.intGatePassYear ";
				 
	if($storesCategory=="E")
	{
	$SQL .= " Inner Join subcontractors ON BGP.intDestination = subcontractors.strSubContractorID ";
	}
	elseif($storesCategory=="I")
	{
	$SQL .= "Inner Join mainstores ON BGP.intDestination = mainstores.strMainID ";
	}
	$SQL .= " WHERE BGP.intGatePassNo !=0 and strCategory='$storesCategory' and BGP.intCompanyId='$companyId'";
	
	if ($gatePassNoFrom!="")
			{
				$SQL .=" AND BGP.intGatePassNo >= $gatePassNoFrom ";	
			}		
	 if ($gatePassNoTo!="")
			{
				$SQL .=" AND BGP.intGatePassNo <= $gatePassNoTo ";	
			}		
	
	if ($chkDate=="on")
	{
		if ($GPDateFrom!="" && $GPDateTO!="")
		{
			$GPDateFromArray	= explode('/',$GPDateFrom);
			$formatedFromDate	= $GPDateFromArray[2].'-'.$GPDateFromArray[1].'-'.$GPDateFromArray[0];
			$GPDateTOArray		= explode('/',$GPDateTO);
			$formatedToDate		= $GPDateTOArray[2].'-'.$GPDateTOArray[1].'-'.$GPDateTOArray[0];
			$SQL .=" AND date(dtmDate) between '$formatedFromDate' and '$formatedToDate' ";		
		}
		
	}
	if ($category!="2")
	{
		$SQL .=" AND BGP.intStatus =$category ";		
	}
	if($destination !="")
		$SQL .=" AND BGP.intDestination =$destination ";	
		
		$SQL .=" order by BGP.dtmDate desc ";

$result = $db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
{
?>
         <tr class="bcgcolor-tblrowWhite">
			  <td width="2%" height="25" class="normalfntMid"><?php echo $No; ?></td>	
              <td width="12%" class="normalfntMid" ><a href="bulkgatepass.php?id=1&GatePassNo=<?php echo $row["intGatePassNo"];?>&GatePassYear=<?php echo $row["intGatePassYear"];?>&Status=<?php echo $row["intStatus"];?>" class="non-html pdf" target="_blank"><?php echo $row["intGatePassYear"].'/'.$row["intGatePassNo"]?></a></td>
              <td width="18%" class="normalfntMid"><?php echo $row["dtmDate"]?></td>
              <td width="38%" class="normalfntMid"><?php echo $row["Destination"]?></td>
			  <td width="19%" class="normalfntMid"><?php echo $row["userName"]?></td>
			  <td width="15%" class="normalfntMid"><a href="rptgatepass.php?id=1&GatePassNo=<?php echo $row["intGatePassNo"];?>&GatePassYear=<?php echo $row["intGatePassYear"];?>" class="non-html pdf" target="_blank"><img border="0" src="../images/view.png" alt="view" /></a></td>
			  </tr>
<?php
$No++;
}
?>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
 
</table>
</form>
</body>
</html>
