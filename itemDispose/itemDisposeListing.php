<?php
session_start();
$backwardseperator = "../";
$intCompanyId		= $_SESSION["FactoryID"];
$disposeNo		= 	$_POST["cboDisposeNo"];
$fromDate		= 	$_POST["fromDate"];
$toDate			= 	$_POST["toDate"];	
$companyId		= 	$_SESSION["FactoryID"];
$status			=	$_POST["cboStatus"];
$mainStore		=	$_POST['cboMainStore'];
$tbl="";
	($status==2)?$tbl="stocktransactions":$tbl="stocktransactions_temp";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Item Dispose Listing</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="pending-java.js" type="text/javascript"></script>
<script src="itemDispos.js" type="text/javascript"></script>
<script type="text/javascript">
function pageSubmit()
{
	//document.getElementById("frmGrnList").submit();
}
</script>

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

<body  >
<?php
	include "../Connector.php";	
	
	$SQL = " SELECT intCompanyID FROM useraccounts  where intUserID=".$_SESSION["UserID"].";";
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result))
					$_SESSION["intUserComp"]=$row["intCompanyID"];
?>
<form name="frmdisposelist" id="frmdisposelist" action="itemDisposeListing.php" method="post">
<tr>
    <td><?php include '../Header.php'; ?></td>
</tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
<tr>
	<td class="mainHeading">Item Disposed Listing</td>
</tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr>
		  	<td width="4%" height="24" class="normalfnt">Status</td>
			<td width="11%" height="24" class="normalfnt"><select name="cboStatus" id="cboStatus" class="txtbox"  style="width:100px" onchange="selectDisposeNo(this);">
			
			<option value="1" <?php if($_POST["cboStatus"]==1){?>selected="selected"<?php }?> >Pending</option>
			<option value="2" <?php if($_POST["cboStatus"]==2){?>selected="selected"<?php }?> >Confirmed</option>
			</select></td>
            <td width="7%" height="24" class="normalfnt">Dispose No</td>
            <td width="11%" class="normalfnt"><select name="cboDisposeNo" class="txtbox"  style="width:100px" id="cboDisposeNo">
              <option value="" ></option>
              <?php
			  
				/*$SQL="SELECT DISTINCT
				concat($tbl.intDocumentYear,'/',$tbl.intDocumentNo) as  disposeNo
				FROM
				$tbl
				Inner Join mainstores ON mainstores.strMainID = $tbl.strMainStoresID
				Inner Join companies ON companies.intCompanyID = mainstores.intCompanyId
				WHERE
				companies.intCompanyID =  '$companyId' AND
				$tbl.strType =  'DISPOSE' AND dblQty < 0;";*/
				$status = $_POST["cboStatus"];
				$SQL = "select concat(intYear,'/',intDocumentNo) as disposeNo from itemdispose where intStatus='$status'";
				$result = $db->RunQuery($SQL);
				
				while($row = mysql_fetch_array($result))
				{	if($_POST['cboDisposeNo']==$row["disposeNo"])
						echo "<option value=\"". $row["disposeNo"] ."\" selected=\"selected\">" . $row["disposeNo"] ."</option>" ;
					else
						echo "<option value=\"". $row["disposeNo"] ."\">" . $row["disposeNo"] ."</option>" ;
				}
	
	?>
            </select></td>
            <td width="7%" class="normalfnt">Main Store</td>
            <td width="15%" class="normalfnt">
			<select id="cboMainStore" name="cboMainStore" style="width:140px;">
					<option value=""></option>
					<?php
					$sql_sub="select * from mainstores where intCompanyId='$intCompanyId';";
					$result=$db->RunQuery($sql_sub);
					//echo $sql_sub;
					
					while($row=mysql_fetch_array($result))
					{ if($mainStore==$row["strMainID"]){ ?>
						
						 <option value="<?php echo $row["strMainID"] ;?>" selected="selected"> <?php echo $row["strName"] ;?></option>
					<?php }
					else {?>
						<option value="<?php echo $row["strMainID"] ;?>"> <?php echo $row["strName"] ;?></option>
					<?php }?>
					
				<?php }?>
				</select></td>
            <td width="2%" class="normalfnt"><input type="checkbox" name="chkDate" id="chkDate" onclick="dateDisable(this);"/></td>
            <td width="7%" class="normalfnt">Date From</td>
            <td width="14%" class="normalfnt"><input value="<?php echo $_POST["fromDate"]; ?>" name="fromDate" type="text" class="txtbox" id="fromDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
            <td width="6%" class="normalfnt">Date To</td>
            <td width="15%" class="normalfnt"><input value="<?php echo $_POST["toDate"]; ?>" name="toDate" type="text" class="txtbox" id="toDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
            <td width="1%" class="normalfnt">&nbsp;</td>
          </tr>
		  <tr>
			  <td width="4%" height="26" class="normalfnt">&nbsp;</td>
				<td width="11%" height="26" class="normalfnt">&nbsp;</td>
				<td width="7%" height="26" class="normalfnt">&nbsp;</td>
				<td width="11%" class="normalfnt">&nbsp;</td>
				<td width="7%" class="normalfnt"></td>
				<td width="15%" class="normalfnt">
				</td>
				<td width="2%" class="normalfnt">&nbsp;</td>
				<td width="7%" class="normalfnt">&nbsp;</td>
				<td width="14%" class="normalfnt">&nbsp;</td>
				<td width="6%" class="normalfnt">&nbsp;</td>
				<td width="15%" class="normalfnt"><img src="../images/search.png" alt="search" class="mouseover" onclick="searchDet();"/></td>
				<td width="1%" class="normalfnt">&nbsp;</td>
		  </tr>
         
        </table></td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="mainHeading2">Item Disposed Details </td>
        </tr>
      <tr>
        <td class="normalfnt"><div id="divcons" style="overflow:scroll; height:450px; width:950px;">
          <table width="926" cellpadding="0" cellspacing="1" id="tblPendingGrn" bgcolor="#CCCCFF">
		  <thead>
            <tr class="mainHeading4">
		      <td width="4%" height="25">&nbsp;</td>
              <td width="10%">Dispose No</td>
			  <td width="15%">Style</td>
              <td width="20%">Main store</td>
              <td width="10%">Date</td>
			  <td width="20%">User</td>
			  <td width="13%">View</td>
              </tr>
			  </thead>
			  <tbody>
				<?php
				
	
		$SQL=  "SELECT DISTINCT
				date(dtmDate) AS dt,
				intDocumentYear,
				intDocumentNo,
				intStyleId,
				mainstores.strName as MainStore,
				useraccounts.Name as uname,
				companies.strName
				FROM
				$tbl
				Inner Join useraccounts ON useraccounts.intUserID = $tbl.intUser
				Inner Join mainstores on mainstores.strMainID=$tbl.strMainStoresID
				Inner Join companies ON companies.intCompanyID = mainstores.intCompanyId
				WHERE strType = 'StyleDispose' and companies.intCompanyID= $companyId ";
				
				if($disposeNo!='')
				{
					$disposeNo		= split('/',$_POST["cboDisposeNo"]);
					$disposeNo		= $disposeNo[1];
					$SQL.=" AND $tbl.intDocumentNo=$disposeNo";
				}
				if($fromDate!="" && $toDate!="")
				{
					$fromDate		= split('/',$_POST["fromDate"]);
					$fromDate		= $fromDate[2].'-'.$fromDate[1].'-'.$fromDate[0];
					$toDate			= split('/',$_POST["toDate"]);
					$toDate			= $toDate[2].'-'.$toDate[1].'-'.$toDate[0];
					$SQL.=" AND date($tbl.dtmDate) BETWEEN '$fromDate' AND '$toDate'";
				}
				if($mainStore!=""){
					$SQL.=" AND mainstores.strMainID=$mainStore ";
				}
					$SQL.=" and dblQty < 0 group by  intDocumentNo, intDocumentNo DESC";
				$SQL.=" order by dtmDate DESC";
				//echo $SQL;
				$result = $db->RunQuery($SQL);
				$ResponseXML .="<LoadDisposeList>\n";
				$c=1;
			while($row = mysql_fetch_array($result))
			{
				$no=$row["intDocumentNo"];
				$year=$row["intDocumentYear"];
			?>
			<tr class="bcgcolor-tblrowWhite">
		      <td width="4%" height="25"><?php echo $c;?></td>
              <td width="10%"><a href="#" onclick="openReport(<?php echo $no.",".$year; ?>)"><?php echo $row["intDocumentYear"]."/".$row["intDocumentNo"]; ?> </a></td>
			  <td width="15%"><?php echo getStyleName( $row["intStyleId"]);?> </td>
              <td width="20%"><?php echo $row["MainStore"];?></td>
              <td width="10%"><?php 
			  $s="select dtmPDate from itemdispose 
			  where intDocumentNo='".$row["intDocumentNo"]."' and intYear='".$row["intDocumentYear"]."';";	
			 
										$r=$db->RunQuery($s);
										
										if(mysql_num_rows($r)>0){
										
										$rw=mysql_fetch_array($r);
										echo substr($rw['dtmPDate'],0,10);
										}
										else {
											echo substr($row['dt'],0,10);
										}
										?> </td>
			  <td width="20%"><?php echo $row["uname"];?></td>
			  <?php if($status==""){$status=1;}?>
			  <td width="13%"> <img src="../images/report.png" onclick="openReport(<?php echo $no.",".$year; ?>)" /></td>
             </tr>
			<?php 
			$c++;
			}
			function getStyleName($StyleID)
			{
			global $db;
				$SQLS = " select strOrderNo from orders where intStyleId='$StyleID'";	
				$resultS=$db->RunQuery($SQLS);
				$rowS=mysql_fetch_array($resultS);
				return $rowS["strOrderNo"];
			}
			?>
				
			</tbody>
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" class="tableBorder">
      <tr>
        <td height="29" align="center"><a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0" class="mouseover" /></a></td>
        </tr>
    </table></td>
  </tr>
  <tr>
  </tr>
</table>
</form>
</body>
</html>
