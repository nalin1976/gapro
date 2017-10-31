<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = "../../";
	$IssueUserID		= $_POST["cboUser"];
	$IssueCompany		= $_POST["cboCompany"];
	$IssueNoFrom		= $_POST["IssueNoFrom"];
	$IssueNoTo			= $_POST["IssueNoTo"];
	$MrnNoFrom			= $_POST["MrnNoFrom"];
	$MrnNoTo			= $_POST["MrnNoTo"];
	$DateFrom			= $_POST["DateFrom"];	
	 $DateFromArray		= explode('/',$DateFrom);
  	  $formatedfromDate = $DateFromArray[2]."-".$DateFromArray[1]."-".$DateFromArray[0];
  	$DateTo				= $_POST["DateTo"];
     $DateToArray		= explode('/',$DateTo);
      $formatedToDate   = $DateToArray[2]."-".$DateToArray[1]."-".$DateToArray[0];
	$chkDate			= $_POST["chkDate"];
	$StyleID		 	= $_POST["cboScNo"];
	$BuyerPoNo		 	= $_POST["cboBuyerPoNo"];
	$Description        = $_POST["cboDescription"];
	$txtMatItem			= $_POST["txtMatItem"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Items :: Issue List & Report</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<!--<script type="text/javascript" src="../StyleItemGatePass/Details/gatePassDetails.js"></script>-->
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>

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
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
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

<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="../../java.js" type="text/javascript"></script>
</head>
<body>

<form name="frmIssueListReport" id="frmIssueListReport" action="issuelistreport.php" method="post">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td height="26" bgcolor="#316895" class="TitleN2white"><table width="100%" border="0">
      <tr>
        <td width="24%"><div align="center">Style Items - Issue Listing & Report</div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1" bgcolor="#d6e7f5">
      <tr>
        <td width="10%" class="normalfnt">Issue No From</td>
        <td width="14%" class="normalfnt"><select name="IssueNoFrom" class="txtbox" id="IssueNoFrom" style="width:130px">
          <?php
		$SQL ="SELECT DISTINCT CONCAT(intIssueYear , '/' , intIssueNo) AS issueNo FROM issues ORDER BY intIssueNo,intIssueYear;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["IssueNoFrom"]==$row["issueNo"])
					echo "<option selected=\"selected\"value=\"". $row["issueNo"] ."\">" . $row["issueNo"] ."</option>" ;
				else
				echo "<option value=\"".$row["issueNo"]."\">".$row["issueNo"]."</option>";
			}
	
 	?>
        </select></td>
        <td width="3%" class="normalfnt">To</td>
        <td width="15%" class="normalfnt"><select name="IssueNoTo" class="txtbox" id="IssueNoTo" style="width:129px">
	<?php
 
		$SQL ="SELECT DISTINCT CONCAT(intIssueYear , '/' , intIssueNo) AS issueNo FROM issues ORDER BY intIssueNo,intIssueYear;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["IssueNoTo"]==$row["issueNo"])
					echo "<option selected=\"selected\"value=\"". $row["issueNo"] ."\">" . $row["issueNo"] ."</option>" ;
				else
				echo "<option value=\"".$row["issueNo"]."\">".$row["issueNo"]."</option>";
			}
	
 	?>         
        </select></td>
        <td width="3%" class="normalfnt"><input  type="checkbox" <?php if($chkDate == 'on') {?>checked="checked" <?php }?> name="chkDate" id="chkDate"  onclick="DateDisable(this);"/></td>
        <td width="7%" class="normalfnt">Date From</td>
        <td width="14%" class="normalfnt"><input name="DateFrom" type="text" class="txtbox" id="DateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DateFrom=="" ? date ("d/m/Y"):$DateFrom) ?>" <?php if($chkDate != 'on') {?> disabled="disabled" <?php }?>/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value=""/></td>
        <td width="6%" class="normalfnt">To</td>
        <td width="14%" class="normalfnt"><input name="DateTo" type="text" class="txtbox" id="DateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DateTo=="" ? date ("d/m/Y"):$DateTo) ?>" <?php if($chkDate != 'on') {?> disabled="disabled" <?php }?>/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
        <td width="9%" rowspan="4" class="normalfnt"><img src="../../images/search.png"  alt="search" width="80" height="24" onclick="SubmitForm();" /></td>
      </tr>
      <tr>
        <td class="normalfnt">MRN No From </td>
        <td width="14%" class="normalfnt"><select name="MrnNoFrom" class="txtbox" id="MrnNoFrom" style="width:130px">
          <?php
 
		$SQL ="SELECT DISTINCT CONCAT(intMatReqYear , '/' , intMatRequisitionNo) AS mrnno FROM issuesdetails ORDER BY intMatReqYear,intMatRequisitionNo;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["MrnNoFrom"]==$row["mrnno"])
					echo "<option selected=\"selected\"value=\"". $row["mrnno"] ."\">" . $row["mrnno"] ."</option>" ;
				else
					echo "<option value=\"".$row["mrnno"]."\">".$row["mrnno"]."</option>";
			}
	
 	?>
        </select></td>
        <td width="3%" class="normalfnt">To</td>
        <td width="15%" class="normalfnt"><select name="MrnNoTo" class="txtbox" id="MrnNoTo" style="width:130px">
          <?php
 
		$SQL ="SELECT DISTINCT CONCAT(intMatReqYear , '/' , intMatRequisitionNo) AS toMrnNo FROM issuesdetails ORDER BY intMatReqYear,intMatRequisitionNo;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["MrnNoTo"]==$row["toMrnNo"])
					echo "<option selected=\"selected\"value=\"".$row["toMrnNo"]."\">".$row["toMrnNo"]."</option>";
				else
					echo "<option value=\"".$row["toMrnNo"]."\">".$row["toMrnNo"]."</option>";
			}
	
 	?>
        </select></td>
        <td width="3%" class="normalfnt"></td>
        <td width="7%" class="normalfnt">BuyerPoNo</td>
        <td width="14%" class="normalfnt"><select name="cboBuyerPoNo" class="txtbox" id="cboBuyerPoNo" style="width:108px">
          <?php
 
		$SQL ="select distinct strBuyerPONO from issuesdetails;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboBuyerPoNo"]==$row["strBuyerPONO"])
					echo "<option selected=\"selected\"value=\"". $row["strBuyerPONO"] ."\">" . $row["strBuyerPONO"] ."</option>" ;
				else
					echo "<option value=\"".$row["strBuyerPONO"]."\">".$row["strBuyerPONO"]."</option>";
			}
	
 	?>
        </select></td>
        <td width="6%" class="normalfnt">By User</td>
        <td width="14%" class="normalfnt"><select name="cboUser" class="txtbox" id="cboUser" style="width:110px">
          <?php
 
		$SQL ="select distinct intUserID,
				(select UA.Name FROM useraccounts UA where UA.intUserID=I.intUserid) AS UserName
				from issues I 
				Order By I.intUserID;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($IssueUserID==$row["intUserID"])
					echo "<option selected=\"selected\"value=\"".$row["intUserID"]."\">".$row["UserName"]."</option>";
				else
					echo "<option value=\"".$row["intUserID"]."\">".$row["UserName"]."</option>";
			}
	
 	?>
        </select></td>
      </tr>
      <tr>
        <td class="normalfnt">Order No</td>
        <td width="14%" class="normalfnt"><select name="cboStyleID" class="txtbox" id="cboStyleID" style="width:130px" onchange="LoadScNo();">
          <?php
 
		$SQL ="select distinct ID.intStyleId,o.strOrderNo 
			from issuesdetails ID
			inner join specification SP on ID.intStyleId=SP.intStyleId
			inner join orders o on o.intStyleId = ID.intStyleId
			order by o.strOrderNo;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboStyleID"]==$row["intStyleId"])
					echo "<option selected=\"selected\"value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
				else
					echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			}
	
 	?>
        </select></td>
        <td width="3%" class="normalfnt">SC</td>
        <td width="15%" class="normalfnt"><select name="cboScNo" class="txtbox" id="cboScNo" style="width:130px" onchange="LoadStyleID();">
          <?php
 
		$SQL ="select distinct intSRNO,ID.intStyleId from issuesdetails ID
inner join specification SP on ID.intStyleId=SP.intStyleId order by intSRNO desc;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboScNo"]==$row["intStyleId"])
					echo "<option selected=\"selected\"value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
				else
					echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
			}
	
 	?>
        </select></td>
        <td width="3%" class="normalfnt"></td>
        <td width="7%" class="normalfnt">Company</td>
        <td colspan="3" class="normalfnt"><select name="cboCompany" class="txtbox" id="cboCompany" style="width:306px">
          <?php
 
		$SQL ="select Distinct intCompanyID,(select strName from companies CO where I.intCompanyID=CO.intCompanyID)AS strName from issues I Order By I.intCompanyID;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboCompany"]==$row["intCompanyID"])
					echo "<option selected=\"selected\"value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
				else
					echo "<option value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
			}
	
 	?>
        </select></td>
        </tr>
      <tr>
        <td class="normalfnt">Meterial</td>
        <td colspan="3" class="normalfnt"><select name="cboDescription" class="txtbox" id="cboDescription" style="width:308px">
          <?php
 
		$SQL ="select distinct intMatDetailID,
(select strItemDescription from matitemlist MIL where ID.intMatDetailID=MIL.intItemSerial) AS Description
from issuesdetails ID
;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboDescription"]==$row["intMatDetailID"])
					echo "<option selected=\"selected\"value=\"".$row["intMatDetailID"]."\">".$row["Description"]."</option>";
				else
					echo "<option value=\"".$row["intMatDetailID"]."\">".$row["Description"]."</option>";
			}
	
 	?>
        </select></td>
        <td class="normalfnt"></td>
        <td class="normalfnt">Material Like</td>
        <td colspan="3" class="normalfnt"><input type="text" name="txtMatItem" id="txtMatItem" style="width:304px;" value="<?php echo $txtMatItem; ?>" /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          
        </table></td>
      </tr>
      <tr>
        <td><div id="divGatePassDetails" style="overflow:scroll; height:320px; width:950px;">
          <table id="tblGatePassDetails" width="100%" cellpadding="0" bgcolor="#CCCCFF" cellspacing="1">
            <tr>			  
              <td width="6%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">ISSUE NO</td>
              <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">ISSUE DATE</td>
              <td width="12%" bgcolor="#498CC2" class="normaltxtmidb2">PRODUCTION LINE</td>
			  <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">USER ID</td>
			  <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">COMPANY</td>
			   <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">VIEW</td>
            </tr>
<?PHP
$IssueNoFromArray	= explode('/',$IssueNoFrom);
$IssueNoToArray		= explode('/',$IssueNoTo);
$MrnNoFromArray		= explode('/',$MrnNoFrom);
$MrnNoToArray		= explode('/',$MrnNoTo);
$booCheck	= true;

$sqlDetails="select distinct concat(I.intIssueYear,'/',I.intIssueNo)AS IssueNo,
			date(dtmIssuedDate) as dtmIssuedDate,
			(select strDepartment from department D where I.strProdLineNo=D.intDepID)AS Department,
			(select UA.Name from useraccounts UA where I.intUserid=UA.intUserID)AS IssueUser,
			(select strName from companies CO where I.intCompanyID=CO.intCompanyID)AS Company
			from issues I
			inner join issuesdetails ID on I.intIssueNo=ID.intIssueNo AND I.intIssueYear=ID.intIssueYear
			inner join matitemlist MIL on MIL.intItemSerial = ID.intMatDetailID
			where I.intStatus=1 ";
if($IssueNoFrom!=""){
	$sqlDetails .=" AND I.intIssueNo>=$IssueNoFromArray[1] AND I.intIssueYear>=$IssueNoFromArray[0]";
	$booCheck	= false;
}
if($IssueNoTo!=""){
	$sqlDetails .=" AND I.intIssueNo<=$IssueNoToArray[1] AND I.intIssueYear<=$IssueNoToArray[0]";
	$booCheck	= false;
}
if($MrnNoFrom!=""){
	$sqlDetails .=" AND ID.intMatRequisitionNo>=$MrnNoFromArray[1] AND ID.intMatReqYear>=$MrnNoFromArray[0]";
	$booCheck	= false;
}
if($MrnNoTo!=""){
	$sqlDetails .=" AND ID.intMatRequisitionNo<=$MrnNoToArray[1] AND ID.intMatReqYear<=$MrnNoToArray[0]";
	$booCheck	= false;
}
if($StyleID!=""){
	$sqlDetails .=" AND ID.intStyleId='$StyleID'";
	$booCheck	= false;
}
if($BuyerPoNo!=""){
	$sqlDetails .=" AND ID.strBuyerPONO='$BuyerPoNo'";
	$booCheck	= false;
}
if($Description!=""){
	$sqlDetails .=" AND ID.intMatDetailID='$Description'";
	$booCheck	= false;
}
if($IssueCompany!=""){
	$sqlDetails .=" AND I.intCompanyID=$IssueCompany";		
	$booCheck	= false;
}
if($IssueUserID!=""){
	$sqlDetails .=" AND I.intUserid=$IssueUserID";
	$booCheck	= false;
}
if($DateFrom!=""){
	$sqlDetails .=" AND date(I.dtmIssuedDate)>='$formatedfromDate'";
	$booCheck	= false;
}
if($DateTo!=""){
	$sqlDetails .=" AND date(I.dtmIssuedDate)<='$formatedToDate'";
	$booCheck	= false;
}
if($txtMatItem != "")
{
	$sqlDetails .=" and  MIL.strItemDescription like '%$txtMatItem%'";
	$booCheck	= false;
}

	$sqlDetails .=" order by I.intIssueYear, IssueNo desc";
if($booCheck){
	$sqlDetails .=" limit 0,50";
}
//echo $sqlDetails;
$result_details = $db->RunQuery($sqlDetails);
	while($row_details=mysql_fetch_array($result_details))
	{
		$strUrl="../../issue/issuenote.php?issueNo=".$row_details["IssueNo"];
?>

            <tr class="bcgcolor-tblrow">
			  
              <td class="normalfntMid"><?php echo $row_details["IssueNo"];?></td>
              <td class="normalfntMid"><?php echo $row_details["dtmIssuedDate"];?></td>
              <td class="normalfntMid"><?php echo $row_details["Department"];?></td>
			  <td class="normalfntMid"><?php echo $row_details["IssueUser"];?></td>
			  <td class="normalfntMid"><?php echo $row_details["Company"];?></td>
			  <td class="normalfntMid"><a href="<?php echo $strUrl;?>" class="non-html pdf" target="_blank"><img border="0" src="../../images/view.png" alt="view" /></a></td>
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
    <td></td>
  </tr>
  <tr bgcolor="#D6E7F5">
    <td height="30"><table width="100%" border="0">
      <tr>
        <td width="37%" class="normalfnt">&nbsp;</td>       
        <td width="14%" class="normalfnt"><img src="../../images/refreshico.png" alt="Report" width="108" height="24" onclick="RefreshPage();" /></td>
        <td width="18%" class="normalfnt"><a href="../../main.php"><img src="../../images/close.png" alt="close" width="97" height="24" border="0" /></a></td>
        <td width="31%" class="normalfnt">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript" language="javascript">
function DateDisable(obj)
{
	if(obj.checked){
		document.getElementById('DateFrom').disabled=false;
		document.getElementById('DateTo').disabled=false;
	}
	else{
		document.getElementById('DateFrom').disabled=true;
		document.getElementById('DateTo').disabled=true;
	}
}
function SubmitForm()
{
	document.getElementById('frmIssueListReport').submit();
}
function RefreshPage()
{
	setTimeout("location.reload(true);",0);
}
function LoadStyleID(){
	var ScNo =document.getElementById("cboScNo").value;
	document.getElementById("cboStyleID").value =ScNo;	
}
function LoadScNo(){
	//var StyleID =document.getElementById("cboStyleID").options[document.getElementById("cboStyleID").selectedIndex].text;
	var StyleID = document.getElementById("cboStyleID").value
	document.getElementById("cboScNo").value =StyleID;	
}
</script>
</form>
</body>
</html>
