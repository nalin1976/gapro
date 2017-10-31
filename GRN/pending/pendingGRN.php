<?php

session_start();
$backwardseperator = "../../";

			  	$grnFromNo		= $_POST["txtGrnFromNo"];
				$grnToNo		= $_POST["txtGrnToNo"];
				$grnFromDate	= $_POST["fromDate"];
				$grnToDate		= $_POST["toDate"];
				$chkDate= $_POST["chkDate"];
				$intStatus		= $_POST["cboMode"];
				$invNo 			= $_POST["txtinvlike"];
				$intPoNo		= $_POST["txtPONo"];
				//$intCompanyId	= $_POST["cboFactory"];
				//display grn list according to the user company
				 $intCompanyId		=$_SESSION["FactoryID"];
				$intUserId		= $_POST["cboUser"];
				
				$arrFdate = explode('/',$grnFromDate);
				$dfrom = $arrFdate[2].'-'.$arrFdate[1].'-'.$arrFdate[0];
				
				$arrTdate = explode('/',$grnToDate);
				$dTo      = $arrTdate[2].'-'.$arrTdate[1].'-'.$arrTdate[0];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | GRN list</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
/*body {
	background-color: #CCCCCC;
}*/
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="pending-java.js" type="text/javascript"></script>

<script type="text/javascript">
function pageSubmit()
{
	document.getElementById("frmGrnList").submit();
}
function dateDisable1(obj)
{
	if(obj.checked){
		document.getElementById('fromDate').disabled=false;
		document.getElementById('toDate').disabled=false;
	}
	else{
		document.getElementById('fromDate').disabled=true;
		document.getElementById('toDate').disabled=true;
	}
}
//-----------------------
function validateForm(){
<?php
if ($dfrom>$dTo){
 ?>
		alert("\"Date From\" cannot be greater than the \"Date To\".");
		document.getElementById('fromDate').focus();

<?php
	$grnFromDate= date ("d/m/Y");	
  	$grnToDate	= date ("d/m/Y");
}
 ?>

}
function getDocument(year,grnNo)
{
	
	var	popwindow= window.open ("uploader.php?No="+grnNo+"&Year="+year,"view Documents","location=1,status=1,scrollbars=1,width=450,height=300");
	popwindow.moveTo(((screen.width - 450)/2),((screen.height - 160)/2));
	popwindow.focus();	
	
}
function checkDocument()
{
	showPleaseWait();
	alert("No available document.");
	hidePleaseWait();
}
//----------------------

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

<body onload="validateForm();">
<?php
	include "../../Connector.php";	
	
	$SQL = " SELECT intCompanyID FROM useraccounts  where intUserID=".$_SESSION["UserID"].";";
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result))
					$_SESSION["intUserComp"]=$row["intCompanyID"];
?>
<form name="frmGrnList" id="frmGrnList" action="pendingGRN.php" method="post">

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
<tr>
    <td><?php include '../../Header.php'; ?></td>
</tr>
  <tr>
    <td><table width="950" border="0" align="center" class="tableBorder">
	<tr>
		<td height="25" class="mainHeading">GRN List</td>
	</tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableBorder">
          
          <tr>
            <td width="3%">&nbsp;</td>
            <td width="10%" class="normalfnt">GRN No From</td>
            <td width="13%"><span class="normalfnt">
              <input name="txtGrnFromNo" type="text" class="txtbox" id="txtGrnFromNo" value="<?php echo $_POST["txtGrnFromNo"]; ?>" style="width:80px;" />
            </span></td>
            <td width="8%"><span class="normalfnt">GRN No to</span></td>
            <td width="12%"><span class="normalfnt">
              <input name="txtGrnToNo" type="text" class="txtbox" id="txtGrnToNo" style="width:80px;" value="<?php echo $_POST["txtGrnToNo"]; ?>"/>
            </span></td>
            <td width="7%" class="normalfnt">INV Like</td>
            <td width="14%"><input value="<?php echo $_POST["txtinvlike"]; ?>" name="txtinvlike"  type="text" class="txtbox" id="txtinvlike"  style="width:117px;" /></td>
            <td width="8%" class="normalfnt" style="visibility:hidden">Company</td>
            <td width="16%" style="visibility:hidden"><select name="cboFactory" class="txtbox"  style="width:150px" id="cboFactory">
              <option value="" ></option>
              <?php
	
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			//echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
			
			if ($intCompanyId==  $row["intCompanyID"])
				echo "<option selected=\"selected\" value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
			else
				echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td width="9%"><img src="../../images/search.png" alt="search" width="80" height="24" class="mouseover" onclick="pageSubmit();"/></td>
          </tr>
          <tr>
            <td><span class="normalfnt">
              <input <?php if($chkDate=='on') {?>checked="checked" <?php }?> type="checkbox" name="chkDate" id="chkDate" onclick="dateDisable1(this);"/>
            </span></td>
            <td><span class="normalfnt">PO Date From</span></td>
            <td>
             <input value="<?php echo ($grnFromDate=="" ? date ("d/m/Y"):$grnFromDate) ?>" name="fromDate" type="text" class="txtbox" id="fromDate" style="width:80px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" <?php if($chkDate!='on') {?>disabled="disabled" <?php }?>/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');">            </td>
            <td class="normalfnt">Date To</td>
            <td>
             <input value="<?php echo ($grnToDate=="" ? date ("d/m/Y"):$grnToDate) ?>" name="toDate" type="text" class="txtbox" id="toDate" style="width:80px;" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" <?php if($chkDate!='on') {?>disabled="disabled" <?php }?>/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');">           </td>
            <td class="normalfnt">PO No</td>
            <td><!--<select name="cbopono" class="txtbox" id="cbopono" style="width:120px" >
              <?php
					$poNo = $_POST["cbopono"];
					$SQL = 	"SELECT  DISTINCT ".
							"P.intPONo  AS dd, P.intPONo , S.strTitle, P.intYear, concat(P.intYear , '/' , P.intPONo , ' -- ' , S.strTitle) AS ListF, ".
							"concat(P.intYear  ,'/', P.intPONo) AS NPONO, P.strPINO, P.intDelToCompID ".
							"FROM         purchaseorderdetails PO INNER JOIN ".
							"purchaseorderheader P ON PO.intPONo = P.intPONo AND PO.intYear = P.intYear INNER JOIN ".
							"suppliers S ON P.strSupplierID = S.strSupplierID ".
							"WHERE  (P.intStatus = 10) AND (P.intDelToCompID = ".$_SESSION["FactoryID"].") ";
			
					$result = $db->RunQuery($SQL);
			
					//echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					//while($row = mysql_fetch_array($result))
//					{
//						if($poNo==$row["dd"])
//							echo "<option selected=\"selected\"value=\"". $row["dd"] ."\">" . trim($row["ListF"]) ."</option>" ;
//						else
//							echo "<option value=\"". $row["dd"] ."\">" . trim($row["ListF"]) ."</option>" ;
//					}
				?>
            </select>-->
              <input type="text" name="txtPONo" id="txtPONo"  style="width:117px;" value="<?php echo $_POST["txtPONo"]; ?>"/></td>
            <td class="normalfnt">User</td>
            <td><select name="cboUser" class="txtbox"  style="width:150px" id="cboUser">
              <option value="" ></option>
              <?php	
	$SQL = "SELECT name,intUserID FROM useraccounts order by name;";	
	$result = $db->RunQuery($SQL);	
	while($row = mysql_fetch_array($result))
	{
		if($intUserId == $row["intUserID"])
			echo "<option selected=\"selected\" value=\"". $row["intUserID"] ."\">" . $row["name"] ."</option>" ;
		else
			echo "<option value=\"". $row["intUserID"] ."\">" . $row["name"] ."</option>" ;
	}	
	?>
            </select></td>
            <td width="9%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>     
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td width="100%" class="mainHeading2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="4%">&nbsp;</td>
            <td width="10%" class="normalfnBLD1">Mode </td>
            <td width="86%" class="normalfnt">				
			<select name="cboMode" class="txtbox" id="cboMode" style="width:190px" >
				<option value="0" <?php echo $_POST["cboMode"]=='0' ? "selected=\"selected\"":""?> >Pending GRN</option>
				<option value="1" <?php echo $_POST["cboMode"]=='1' ? "selected=\"selected\"":""?> >Processed GRN </option>
				<option value="10" <?php echo $_POST["cboMode"]=='10' ? "selected=\"selected\"":""?> >Cancel GRN</option>
            </select></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td class="normalfnt"><div id="divcons" style="overflow:scroll; height:450px; width:950px;">
          <table width="950" cellpadding="0" cellspacing="1" id="tblPendingGrn" bgcolor="#CCCCFF">
<?php 
		$SQL=  "SELECT DISTINCT
				grnheader.intGrnNo AS GrnNo,
				grnheader.intPoNo AS PoNo,
				grnheader.intYear AS PoYear,
				suppliers.strTitle AS SupplierName,
				grnheader.intGRNYear AS GrnYear,
				grnheader.dtmRecievedDate AS GrnDate,
				grnheader.strInvoiceNo AS invNo,
				useraccounts.name As UserName,
				purchaseorderheader.intDelToCompID as grnFactory				
				FROM
				grnheader
				Inner Join purchaseorderheader ON grnheader.intPoNo = purchaseorderheader.intPONo AND purchaseorderheader.intYear = grnheader.intYear
				Inner Join suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID 
				Inner Join useraccounts ON useraccounts.intUserID = grnheader.intUserId
				 WHERE
				 grnheader.intStatus = '$intStatus' AND grnheader.intCompanyID=$intCompanyId ";
				
				if($grnFromNo!=0)
				{
					$SQL.=" AND grnheader.intGrnNo>=".(int)$grnFromNo;
				}
						
				if($grnToNo!="")
				{
					$SQL.=" AND grnheader.intGrnNo<=".(int)$grnToNo;
				}

				if($grnFromDate!="")
				{
					$SQL.=" AND date(grnheader.dtmRecievedDate)>='$dfrom' ";
				}
				if($grnToDate!="")
				{
					$SQL.=" AND date(grnheader.dtmRecievedDate)<='$dTo'";
				}
				
				if($invNo!="")
				{
					$SQL.=" AND grnheader.strInvoiceNo LIKE '%$invNo%' ";
				}
				
				if($intPoNo!="")
				{
					$SQL.=" AND grnheader.intPoNo like '%$intPoNo%' ";
				}
				/*if($intCompanyId!="")
				{
					$SQL.=" AND grnheader.intCompanyID=$intCompanyId ";
				}*/
				if($intUserId!="")
				{
					$SQL.=" AND grnheader.intUserId=$intUserId ";
				}
				$SQL.= " group by  GrnYear DESC, GrnNo DESC  ";
		$result = $db->RunQuery($SQL);
?>
            <tr class="mainHeading4">
		      <td width="3%" height="25" >&nbsp;</td>
              <td width="10%" >GRN No</td>
              <td width="10%" >PO No</td>
              <td width="30%" >Supplier</td>
			  <td width="8%" >Invoice No</td>
              <td width="9%" >Date</td>
			  <td width="13%" >User</td>
			  <td width="10%" >View</td>
			  <td width="14%" >Print</td>
              <td width="14%" >Payment Price Confirmation </td>
			   <td width="10%" >document</td>
            </tr>
			  
<?php
while($row = mysql_fetch_array($result))
{
	$invoConfirmation = CheckInvoConfirmation($row["GrnYear"],$row["GrnNo"]);
	if($intStatus=='')
	$intStatus =0;
	$strUrl  = "../Details/grndetails.php?id=1&GRNNo=".$row["GrnNo"]."&intYear=".$row["GrnYear"]."&intStatus=".$intStatus."&thisGrnFactory=".$row["grnFactory"];
	$reportPath = "../Details/grnReport.php?grnno=".$row["GrnNo"]."&grnYear=".$row["GrnYear"];
	?>
	<tr class="bcgcolor-tblrowWhite">
	<td></td>
	<td class="normalfntMid"><a href="<?php echo $strUrl; ?>" class="non-html pdf" target="_blank"><?php echo $row["GrnYear"].'/'.$row["GrnNo"]; ?></a></td>
	<td class="normalfntMid"><?php echo $row["PoYear"].'/'.$row["PoNo"]; ?></td>
	<td class="normalfnt" ><?php echo $row["SupplierName"]; ?></td>
	<td class="normalfnt" ><?php echo $row["invNo"]; ?></td>
	<td class="normalfnt" style="text-align:center"><?php echo substr($row["GrnDate"],0,10); ?></td>
	<td class="normalfnt" style="text-align:center"><?php echo $row["UserName"]; ?></td>
	<td>
	<!--<a href="<img border="0" src="../../images/view.png" alt="view" />" class="non-html pdf" target="_blank"><div align="center"><img border="0" src="../../images/view.png" alt="view" /></div></a>-->
	<img border="0" src="../../images/view.png" alt="view" onclick="viewGRNdetails(<?php echo $row["GrnNo"].','.$row["GrnYear"].','.$intStatus.','.$row["grnFactory"] ?>);"/>            </td>
	<td>
	<!-- <a target="_blank" href="<?php //echo $reportPath; ?>"><img border="0" src="../../images/report.png" id="butReport"  class="mouseover" width="90" height="20" /></a>-->
	<img border="0" src="../../images/report.png" id="butReport"  class="mouseover" width="90" height="20" onclick="viewReport(<?php echo $row["GrnNo"].','.$row["GrnYear"] ?>)"/>            </td>
	<td>
	<?php if($invoConfirmation) { ?>
	<a href="../../confirmInvoicePrice/additionalPOprice.php?intPONo=<?php echo $row["PoNo"];?>&intYear=<?php echo $row["PoYear"];?>&intGRNno=<?php echo $row["GrnNo"]?>&intGRNYear=<?php echo $row["GrnYear"];?>" target="additionalPOprice.php"><img border="0" src="../../images/view.png" alt="view" /></a>
	<?php } ?></td>
	
	<?php
			$boo = true;
			$file = "";
			$year = $row["GrnYear"];
			$grnNo = $row["GrnNo"];
			$url = "../../upload files/Style grn/". $row["GrnYear"].'-'.$row["GrnNo"]."/";
			$serverRoot = $_SERVER['DOCUMENT_ROOT'];
			$dh = opendir($url);
			if(file_exists($url))
			{
				$count = 0;
				while (($file = readdir($dh)) != false)
				{				
					if($file!='.' && $file!='..')
					{
						$boo = true;
						$file1	= $file;
						$count++;
					}
					else			
						$boo = false;
				}
				if($boo=='true' && $count==1)
				echo "<td><div align=\"center\"><a href=\"$url$file1\" target=\"_new\" ><img border=\"0\" src=\"../../images/pdf.png\" alt=\"view\"/></div></a></td>";
				elseif($boo=='true' && $count>1)
				echo "<td class=\"normalfntMid\"><img border=\"0\" src=\"../../images/pdf.png\" alt=\"view\" onclick=\"getDocument($year,$grnNo);\"/></div></a></td>";
				else
				echo "<td class=\"normalfntMid\"><img border=\"0\" src=\"../../images/pdf.png\" alt=\"view\" /></div></a></td>";
			}
			else
			echo "<td class=\"normalfntMid\"><img border=\"0\" src=\"../../images/pdf.png\" alt=\"view\" onclick=\"checkDocument();\"/></div></a></td>";
				
			?>
	</tr>
	
	<?php
}
?>
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  
  <tr>  </tr>
</table>
</form>
</body>
</html>
<?php
function CheckInvoConfirmation($year,$no)
{
global $db;
$booCheck = false;
	$sql1="select dblPaymentPrice from grndetails GD where GD.intGRNYear='$year' and GD.intGrnNo='$no' and dblPoPrice<>dblInvoicePrice and dblPaymentPrice='0';";
	$result1=$db->RunQuery($sql1);
	while($row1=mysql_fetch_array($result1))
	{
		$booCheck = true;
	}
return $booCheck;
}
?>