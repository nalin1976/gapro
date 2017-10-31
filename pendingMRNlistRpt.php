<?php
	session_start();
	include "Connector.php";
	$backwardseperator = "";
	$IssueUserID		= $_POST["cboUser"];
	$IssueCompany		= $_POST["cboCompany"];
	$MrnNoFrom			= $_POST["cboMrnNoFrom"];
	$MrnNoTo			= $_POST["cboMrnNoTo"];
	$DateFrom			= $_POST["DateFrom"];	
	 $DateFromArray		= explode('/',$DateFrom);
  	  $formatedfromDate = $DateFromArray[2]."/".$DateFromArray[1]."/".$DateFromArray[0];
  	$DateTo				= $_POST["DateTo"];
     $DateToArray		= explode('/',$DateTo);
      $formatedToDate   = $DateToArray[2]."/".$DateToArray[1]."/".$DateToArray[0];
	$chkDate			= $_POST["chkDate"];
	$StyleID		 	= $_POST["cboSR"];
	$BuyerPoNo		 	= $_POST["cboBuyerPoNo"];
	$Description        = $_POST["cboDescription"];
	$comID 				= $_SESSION["CompanyID"];  
	$FactoryLocation 	= $_SESSION["FactoryID"];
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MRN List & Report</title>
<style type="text/css">
<!--
/*body {
	background-color: #CCCCCC;
}*/
-->
</style>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
<!--<script type="text/javascript" src="../StyleItemGatePass/Details/gatePassDetails.js"></script>-->
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
<script src="javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="javascript/styleNoOrderNoLoading.js" type="text/javascript"></script>

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

//-----------------------
function validateForm(){
<?php
if ($formatedfromDate>$formatedToDate){
 ?>
		alert("\"Date From\" cannot be greater than the \"Date To\".");
		document.getElementById('DateFrom').focus();

<?php
	$DateFrom= date ("d/m/Y");	
  	$DateTo	= date ("d/m/Y");
}
 ?>

}
//----------------------

</script>

<script src="javascript/script.js" type="text/javascript"></script>
<script src="java.js" type="text/javascript"></script>
</head>
<body onload="validateForm();">

<form name="frmMrnListReport" id="frmMrnListReport" action="pendingMRNlistRpt.php" method="post">
<tr>
	<td><?php include 'Header.php'; ?></td>
</tr>
<table width="950" cellpadding="0" cellspacing="0" align="center"class="tableBorder">
<tr>
<td>   
<table width="100%" border="0" >
  <tr>
    <td></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="25" width="24%" class="mainHeading">Style Items - MRN Listing & Report</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="tableBorder" >
      <tr>
        <td width="9%" class="normalfnt">MRN No From </td>
        <td width="15%" class="normalfnt"><select name="cboMrnNoFrom" class="txtbox" id="cboMrnNoFrom" style="width:130px">
          <?php
		$SQL ="SELECT DISTINCT CONCAT(intMRNYear , '/' , intMatRequisitionNo) AS mrnNo FROM matrequisition WHERE intCompanyID = '$FactoryLocation' ORDER BY intMatRequisitionNo,intMRNYear;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboMrnNoFrom"]==$row["mrnNo"])
					echo "<option selected=\"selected\"value=\"". $row["mrnNo"] ."\">" . $row["mrnNo"] ."</option>" ;
				else
				echo "<option value=\"".$row["mrnNo"]."\">".$row["mrnNo"]."</option>";
			}
	
 	?>
        </select></td>
        <td width="2%" class="normalfntMid">To </td>
        <td width="15%" class="normalfnt"><select name="cboMrnNoTo" class="txtbox" id="cboMrnNoTo" style="width:138px">
	<?php
 
		$SQL ="SELECT DISTINCT CONCAT(intMRNYear , '/' , intMatRequisitionNo) AS mrnNo FROM matrequisition WHERE intCompanyID = '$FactoryLocation' ORDER BY intMatRequisitionNo,intMRNYear;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboMrnNoTo"]==$row["mrnNo"])
					echo "<option selected=\"selected\"value=\"". $row["mrnNo"] ."\">" . $row["mrnNo"] ."</option>" ;
				else
				echo "<option value=\"".$row["mrnNo"]."\">".$row["mrnNo"]."</option>";
			}
	
 	?>         
        </select></td>
        <td width="4%" class="normalfnt"><input  type="checkbox" name="chkDate" id="chkDate" <?php if($chkDate=='on') {?>checked="checked" <?php }?> onclick="DateDisable(this);"/></td>
        <td width="8%" class="normalfnt">Date From</td>
        <td width="16%" class="normalfnt"><input name="DateFrom" type="text" class="txtbox" id="DateFrom" style="width:107px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DateFrom=="" ? date ("d/m/Y"):$DateFrom) ?>" <?php if($chkDate!='on') {?>disabled="disabled" <?php }?>/><input name="reset" id="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value=""/></td>
        <td width="3%" class="normalfnt">To</td>
        <td width="16%" class="normalfnt"><input name="DateTo" type="text" class="txtbox" id="DateTo" style="width:106px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DateTo=="" ? date ("d/m/Y"):$DateTo) ?>" <?php if($chkDate!='on') {?>disabled="disabled" <?php }?>/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
        <td width="12%"  class="normalfnt"><img src="images/search.png"  alt="search" width="80" height="24" onclick="SubmitForm();" /></td>
      </tr>
	  </table>
	  
	  <table width="959">
      <tr>
	  <td width="9%" class="normalfnt">Style </td>
        <td class="normalfnt" colspan="2"><select name="cboStyles" class="txtbox" id="cboStyles" style="width:300px" onchange="getStylewiseOrderNoNew('MRNGetStylewiseOrderNo',this.value,'cboOrderNo');getScNo('MRNgetStyleWiseSCNum','cboSR');" >
          <?php
 
		 $SQL ="select distinct orders.strStyle from matrequisitiondetails MD
inner join specification SP on MD.intStyleId=SP.intStyleId 
inner JOIN orders ON SP.intStyleId = orders.intStyleId Order By strOrderNo ASC;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboStyles"]==$row["strStyle"])
					echo "<option selected=\"selected\"value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>" ;
				else
					echo "<option value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
			}
	
 	?>
        </select></td>
		
		   <td width="4%" class="normalfnt">SC</td>
        <td width="6%" class="normalfnt"><select name="cboSR" class="txtbox" id="cboSR" style="width:50px" onchange="getStyleNoFromSC('cboSR','cboOrderNo');">
          <?php
 
		$SQL ="select distinct intSRNO,MD.intStyleId from matrequisitiondetails MD
inner join specification SP on MD.intStyleId=SP.intStyleId Order By intSRNO ASC;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboSR"]==$row["intStyleId"])
					echo "<option selected=\"selected\"value=\"". $row["intStyleId"] ."\">" . $row["intSRNO"] ."</option>" ;
				else
					echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
			}
	
 	?>
        </select></td>



		
        <td width="5%" class="normalfnt">Order </td>
        <td width="19%" class="normalfnt"><select name="cboOrderNo" class="txtbox" id="cboOrderNo" style="width:130px" onchange="getSC('cboSR','cboOrderNo');getStyleNoFromSC('cboSR','cboOrderNo');" >
          <?php
 
		 $SQL ="select distinct intSRNO,MD.intStyleId,orders.strOrderNo from matrequisitiondetails MD
inner join specification SP on MD.intStyleId=SP.intStyleId 
inner JOIN orders ON SP.intStyleId = orders.intStyleId Order By strOrderNo ASC;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboOrderNo"]==$row["intStyleId"])
					echo "<option selected=\"selected\"value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"] ."</option>" ;
				else
					echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			}
	
 	?>
        </select></td>
     
        <td width="10%" class="normalfnt">BuyerPONo</td>
        <td width="15%" class="normalfnt"><select name="cboBuyerPoNo" class="txtbox" id="cboBuyerPoNo" style="width:108px">
          <?php
 
		$SQL ="select distinct strBuyerPONO from matrequisitiondetails ORDER BY strBuyerPONO ASC;";
		
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
        
      </tr>

      <tr>
        <td width="9%" class="normalfnt">Meterial</td>
        <td colspan="2" class="normalfnt"><select name="cboDescription" class="txtbox" id="cboDescription" style="width:300px">
          <?php
 
		$SQL ="select distinct strMatDetailID,
(select strItemDescription from matitemlist MIL where MD.strMatDetailID=MIL.intItemSerial) AS Description
from matrequisitiondetails MD
 ORDER BY Description ASC;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboDescription"]==$row["strMatDetailID"])
					echo "<option selected=\"selected\"value=\"".$row["strMatDetailID"]."\">".$row["Description"]."</option>";
				else
					echo "<option value=\"".$row["strMatDetailID"]."\">".$row["Description"]."</option>";
			}
	
 	?>
        </select></td>

        <td width="4%" class="normalfnt"> Stores</td>
        <td colspan="3" class="normalfnt"><select name="cboCompany" class="txtbox" id="cboCompany" style="width:238px">
          <?php
 
		$SQL ="SELECT DISTINCT strMainStoresID,(SELECT strName FROM mainstores CO WHERE MH.strMainStoresID=CO.strMainID)AS strName FROM matrequisition MH ORDER BY strName ASC;";
		
			$result =$db->RunQuery($SQL);
		
		echo "<option value=\"".""."\">" .""."</option>";
		
			while ($row=mysql_fetch_array($result))
			{
				if($_POST["cboCompany"]==$row["strMainStoresID"])
					echo "<option selected=\"selected\"value=\"".$row["intCompanyID"]."\">".$row["strName"]."</option>";
				else
					echo "<option value=\"".$row["strMainStoresID"]."\">".$row["strName"]."</option>";
			}
	
 	?>
        </select></td>
		<td width="10%" class="normalfnt">By User</td>
        <td width="15%" class="normalfnt"><select name="cboUser" class="txtbox" id="cboUser" style="width:108px">
          <?php
 
		$SQL ="select distinct intUserID,
				(select UA.Name FROM useraccounts UA where UA.intUserID=MH.intUserId) AS UserName
				from matrequisition MH 
				Order By UserName ASC;";
		
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
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr class="mainHeading2">
            <td width="9%" class="normalfnBLD1" align="left">&nbsp;Mode </td>
            <td width="92%" class="normalfnt">
				
				
			  <select name="cboMode" class="txtbox" id="cboMode" style="width:303px" >
			  <?php 
			  	if($_POST["cboMode"]=='1')
				{
			  ?>
              <option selected="selected"  value="1">Pending MRN</option>
              <option  value="10">Processed MRN</option>
			  
			  <?php 
			  	}
				else if($_POST["cboMode"]=='10')
				{
			  ?>
			  <option   value="1">Pending MRN</option>
			  <option  selected="selected" value="10">Processed MRN</option>
			  <?php
			  	}
				else
				{
			  ?>
			  <option  selected="selected" value="1">Pending MRN</option>
			  <option   value="10">Processed MRN</option>
			  <?php 
			  	}
			  ?>
			  
			  
            </select></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="divGatePassDetails" style="overflow:scroll; height:320px; width:950px;">
          <table id="tblGatePassDetails" width="100%" cellpadding="0" bgcolor="#CCCCFF" cellspacing="1">
            <tr class="mainHeading4">
              <th width="6%" height="25" >MRN No</th>
              <th width="6%" >MRN Date</th>
              <th width="12%" >Department</th>
			  <th width="10%" >User</th>
			  <th width="18%" >Stores</th>
			   <th width="6%" >View</th>
            </tr>
<?PHP

$intStatus		= $_POST["cboMode"];
if($intStatus == '')
	$intStatus = 1;
$MrnNoFromArray		= explode('/',$MrnNoFrom);
$MrnNoToArray		= explode('/',$MrnNoTo);
$booCheck	= true;
$sqlDetails="select distinct concat(MH.intMRNYear,'/',MH.intMatRequisitionNo)AS MrnNo,
			date(dtmDate) as dtmDate,
			(select strDepartment from department D where MH.strDepartmentCode=D.intDepID)AS Department,
			(select UA.Name from useraccounts UA where MH.intUserId=UA.intUserID)AS IssueUser,
			 (SELECT strName FROM mainstores CO WHERE MH.strMainStoresID=CO.strMainID)AS Company,
			 (SELECT strMainStoresID FROM mainstores CO WHERE MH.strMainStoresID=CO.strMainID)AS CompanyID
			from matrequisition MH
			inner join matrequisitiondetails MD on MH.intMatRequisitionNo=MD.intMatRequisitionNo AND MH.intMRNYear=MD.intYear
			where MH.intStatus='$intStatus' AND MH.intCompanyID = '$FactoryLocation' ";

if($MrnNoFrom!=""){
	$sqlDetails .=" AND MH.intMatRequisitionNo>=$MrnNoFromArray[1] AND MH.intMRNYear>=$MrnNoFromArray[0]";
	$booCheck	= false;
}
if($MrnNoTo!=""){
	$sqlDetails .=" AND MH.intMatRequisitionNo<=$MrnNoToArray[1] AND MH.intMRNYear<=$MrnNoToArray[0]";
	$booCheck	= false;
}
if($StyleID!=""){
	$sqlDetails .=" AND MD.intStyleId='$StyleID'";
	$booCheck	= false;
}
if($BuyerPoNo!=""){
	$sqlDetails .=" AND MD.strBuyerPONO='$BuyerPoNo'";
	$booCheck	= false;
}
if($Description!=""){
	$sqlDetails .=" AND MD.strMatDetailID='$Description'";
	$booCheck	= false;
}	
if($IssueCompany!=""){
	$sqlDetails .=" AND MH.strMainStoresID=$IssueCompany";		
	$booCheck	= false;
}
if($IssueUserID!=""){
	$sqlDetails .=" AND MH.intUserId=$IssueUserID";
	$booCheck	= false;
}
if($DateFrom!=""){
	$sqlDetails .=" AND MH.dtmDate>='$formatedfromDate'";
	$booCheck	= false;
}
if($DateTo!=""){
	$sqlDetails .=" AND MH.dtmDate<='$formatedToDate'";
	$booCheck	= false;
}
	$sqlDetails .=" order by MH.intMatRequisitionNo desc";

if($booCheck){
	$sqlDetails .=" limit 0,50";
}
 $sqlDetails;
$result_details = $db->RunQuery($sqlDetails);
	while($row_details=mysql_fetch_array($result_details))
	{
		$MrnNoFromArray		= explode('/',$row_details["MrnNo"]);
		$mainStore          = $row_details["CompanyID"];
		$strUrl="mrnrep.php?mrnNo=".$MrnNoFromArray[1]."&year=".$MrnNoFromArray[0];
		$mrnUrl="MaterialRequisition.php?id=1&mrnNo=".$MrnNoFromArray[1]."&year=".$MrnNoFromArray[0]."&mainStore=".$mainStore."&intStatus=".$intStatus;
		
?>

            <tr class="bcgcolor-tblrowWhite">
			  
              <td class="normalfntMid"><a href="<?php echo $mrnUrl; ?>" class="non-html pdf" target="_blank"><?php echo $row_details["MrnNo"];?></a></td>
              <td class="normalfntMid"><?php echo $row_details["dtmDate"];?></td>
              <td class="normalfntMid"><?php echo $row_details["Department"];?></td>
			  <td class="normalfntMid"><?php echo $row_details["IssueUser"];?></td>
			  <td class="normalfntMid"><?php echo $row_details["Company"];?></td>
			  <td class="normalfntMid"><a href="<?php echo $strUrl;?>" class="non-html pdf" target="_blank"><img border="0" src="images/view.png" alt="view" /></a></td>
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
  <tr >
    <td height="30"><table width="100%" border="0" class="tableBorder">
      <tr align="center">
        <td width="37%" >     
        <img src="images/new.png" alt="Report" onclick="RefreshPage();" />
        <a href="main.php"><img src="images/close.png" alt="close" border="0" /></a>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</td></tr>
 </table>
 </form>
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
	document.getElementById('frmMrnListReport').submit();
}
function RefreshPage()
{
	//setTimeout("location.reload(true);",0);
	//document.frmMrnListReport.reset();
	document.getElementById('cboMrnNoFrom').value="";
	document.getElementById('cboStyleID').value="";
	document.getElementById('cboMrnNoTo').value="";
	document.getElementById('cboScNo').value="";
	document.getElementById('cboBuyerPoNo').value="";
	document.getElementById('cboUser').value="";
	document.getElementById('cboDescription').value="";
	document.getElementById('cboCompany').value="";
	document.getElementById('chkDate').checked=false;
	RemoveAllRows("tblGatePassDetails");
	
}


function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
		for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			tbl.deleteRow(loop);
		}	
	}
</script>

</body>
</html>
