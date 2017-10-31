<?php

session_start();
$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pending GRN list</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<link rel="stylesheet" type="text/css" href="../../js/jquery-ui-1.8.9.custom.css"/>
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="pending-java.js" type="text/javascript"></script>

<script type="text/javascript">
function pageSubmit()
{
	document.getElementById("frmGrnList").submit();
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
	include "../../Connector.php";	
	
	$SQL = " SELECT intCompanyID FROM useraccounts  where intUserID=".$_SESSION["UserID"].";";
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result))
					$_SESSION["intUserComp"]=$row["intCompanyID"];
?>
<form name="frmGrnList" id="frmGrnList" action="pendingGRN.php" method="post">
<tr>
    <td><?php include '../../Header.php'; ?></td>
</tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td height="25" colspan="2" class="mainHeading">Bulk Grn 
      <select name="cboMode" class="txtbox" id="cboMode" style="width:100px" >
        <?php 
			  	if($_POST["cboMode"]=='0')
				{
			  ?>
        <option selected="selected"  value="0">Pending</option>
        <option  value="1">Processed</option>
        <option  value="10">Cancel</option>
        <?php 
			  	}
				else if($_POST["cboMode"]=='1')
				{
			  ?>
        <option   value="0">Pending</option>
        <option selected="selected" value="1">Processed</option>
        <option  value="10">Cancel</option>
        <?php 
			  	}
				else if($_POST["cboMode"]=='10')
				{
			  ?>
        <option   value="0">Pending</option>
        <option value="1">Processed</option>
        <option  selected="selected" value="10">Cancel</option>
        <?php
			  	}
				else
				{
			  ?>
        <option  selected="selected" value="0">Pending</option>
        <option value="1">Processed</option>
        <option   value="10">Cancel</option>
        <?php 
			  	}
			  ?>
      </select>
      Listing</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr>
            <td width="0%" height="28" class="normalfnt">&nbsp;</td>
            <td width="10%" class="normalfnt">GRN No From</td>
            <td width="13%" class="normalfnt"><input name="txtGrnFromNo" type="text" class="txtbox" id="txtGrnFromNo" style="width:100px" value="<?php echo $_POST["txtGrnFromNo"]; ?>" /></td>
            <td width="7%" class="normalfnt">GRN No to</td>
            <td width="13%" class="normalfnt"><input name="txtGrnToNo" type="text" class="txtbox" id="txtGrnToNo" style="width:100px" value="<?php echo $_POST["txtGrnToNo"]; ?>"/></td>
            <td width="2%" class="normalfnt"><input checked="<?php echo $_POST["checkbox"]; ?>" type="checkbox" name="chkDate" id="chkDate" onclick="dateDisable(this);"/></td>
            <td width="10%" class="normalfnt">PO date From</td>
            <td width="17%" class="normalfnt"><input value="<?php echo $_POST["fromDate"]; ?>" name="fromDate" type="text" class="txtbox" id="fromDate" style="width:120px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
            <td width="3%" class="normalfnt">To</td>
            <td width="17%" class="normalfnt"><input value="<?php echo $_POST["toDate"]; ?>" name="toDate" type="text" class="txtbox" id="toDate"  style="width:120px"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
            <td width="8%" rowspan="2" class="normalfnt"><img src="../../images/search.png" alt="search" width="80" height="24" class="mouseover" onclick="pageSubmit();"/></td>
          </tr>
          <tr>
            <td height="12" class="normalfnt">&nbsp;</td>
             <td width="10%" class="normalfnt">PO No</td>
                <td width="13%"><input type="text" id="cbopono" name="cbopono" style="width:100px" value="<?php echo ($_POST["cbopono"]=="" ? "":$_POST["cbopono"])?>"/></td>
                <td width="7%" class="normalfnt">INV Like</td>
                <td width="13%"><input value="<?php echo $_POST["txtinvlike"]; ?>" name="txtinvlike"  type="text" class="txtbox" id="txtinvlike" style="width:100px" /></td>
                <td width="2%">&nbsp;</td>
                <td width="10%" class="normalfnt">Company</td>
                <td width="17%"><select name="cboFactory" class="txtbox"  style="width:120px" id="cboFactory">
                  <option value="" ></option>
                  <?php
	
	$SQL = "SELECT intCompanyID,strName FROM companies c where intStatus=1 order by strName;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
	}
	
	?>
                </select></td>
                <td width="3%" class="normalfnt">User</td>
                <td height="12" class="normalfnt"><select name="cboUser" class="txtbox"  style="width:120px" id="cboUser">
                  <option value="" ></option>
                  <?php
	
	$SQL = "SELECT name,intUserID FROM useraccounts order by name;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			echo "<option value=\"". $row["intUserID"] ."\">" . $row["name"] ."</option>" ;
	}
	
	?>
                </select></td>
          </tr>
        </table></td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      
      <tr>
        <td width="100%" colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:450px; width:950px;">
          <table width="100%" cellpadding="0" cellspacing="1" id="tblPendingGrn" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
		      <td width="2%" height="25" >No</td>
              <td width="9%" >GRN No</td>
              <td width="9%" >PO No</td>
              <td width="29%" >Supplier</td>
			  <td width="7%" >Invoice No</td>
              <td width="8%" >Date</td>
			  <td width="12%" >User</td>
			  <td width="12%" >View</td>
			  <td width="8%" >Document</td>			  
              </tr>
			  
			  <?php 
			    $limit = true;
			  	$grnFromNo		= $_POST["txtGrnFromNo"];
				$grnToNo		= $_POST["txtGrnToNo"];
				$grnFromDate	= $_POST["fromDate"];
				$grnToDate		= $_POST["toDate"];
				$intStatus		= $_POST["cboMode"];
				$invNo 			= $_POST["txtinvlike"];
				$intPoNo		= $_POST["cbopono"];
				$intCompanyId	= $_POST["cboFactory"];
				$intUserId		= $_POST["cboUser"];
		
		$SQL= "SELECT DISTINCT
				GH.intBulkGrnNo AS GrnNo,
				GH.intBulkPoNo AS PoNo,
				GH.intBulkPoYear AS PoYear,
				S.strTitle AS SupplierName,
				GH.intYear AS GrnYear,
				GH.dtRecdDate AS GrnDate,
				GH.strInvoiceNo AS invNo,
				UA.name As UserName,
				GH.intCompanyId as grnFactory				
				FROM
				bulkgrnheader GH
				Inner Join bulkpurchaseorderheader PH ON GH.intBulkPoNo = PH.intBulkPoNo AND PH.intYear = GH.intBulkPoYear
				Inner Join suppliers S ON PH.strSupplierID = S.strSupplierID 
				Inner Join useraccounts UA ON UA.intUserID = GH.intUserId
				WHERE GH.intStatus = '$intStatus' ";
				
				if($grnFromNo!=0)
				{
					$SQL.=" AND GH.intBulkGrnNo>=".(int)$grnFromNo;
					$limit = false;
				}
						
				if($grnToNo!="")
				{
					$SQL.=" AND GH.intBulkGrnNo<=".(int)$grnToNo;
					$limit = false;
				}

				if($grnFromDate!="")
				{
					$SQL.=" AND GH.dtRecdDate>='$grnFromDate' ";
					$limit = false;
				}
				if($grnToDate!="")
				{
					$SQL.=" AND GH.dtRecdDate<='$grnToDate'";
					$limit = false;
				}
				
				if($invNo!="")
				{
					$SQL.=" AND GH.strInvoiceNo LIKE '%$invNo%' ";
					$limit = false;
				}
				
				if($intPoNo!="")
				{
					$SQL.=" AND GH.intBulkPoNo=$intPoNo ";
					$limit = false;
				}
				if($intCompanyId!="")
				{
					$SQL.=" AND GH.intCompanyId=$intCompanyId ";
					$limit = false;
				}
				if($intUserId!="")
				{
					$SQL.=" AND GH.intUserId=$intUserId ";
					$limit = false;
				}
				$SQL.= " group by  GrnYear DESC, GrnNo DESC  ";
				if($limit)
					$SQL .=" limit 0,50";
					
		$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
			{
			if($intStatus=='')
				$intStatus =0;
			$strUrl  = "../Details/grndetails.php?id=1&GRNNo=".$row["GrnNo"]."&intYear=".$row["GrnYear"]."&intStatus=".$intStatus."&thisGrnFactory=".$row["grnFactory"];
			$reportPath = "../Details/grnReport.php?grnno=".$row["GrnNo"]."&grnYear=".$row["GrnYear"];
			
			?>
			<tr class="bcgcolor-tblrowWhite">
			<td><?php echo ++$loop;?></td>
			<td class="normalfntMid"><a href="<?php echo $strUrl; ?>" class="non-html pdf" target="_blank"><?php echo $row["GrnYear"].'/'.$row["GrnNo"]; ?></a></td>
			<td class="normalfntMid"><?php echo $row["PoYear"].'/'.$row["PoNo"]; ?></td>
			<td class="normalfnt" ><?php echo $row["SupplierName"]; ?></td>
			<td class="normalfnt" ><?php echo $row["invNo"]; ?></td>
			<td class="normalfnt" style="text-align:center"><?php echo substr($row["GrnDate"],0,10); ?></td>
			<td class="normalfnt" style="text-align:center"><?php echo $row["UserName"]; ?></td>
			<td><a href="<?php echo $reportPath; ?>" class="non-html pdf" target="_blank"><img border="0" src="../../images/view.png" alt="view" /></a></td>
			
			<?php
			$boo = true;
			$file = "";
			$year = $row["GrnYear"];
			$grnNo = $row["GrnNo"];
			$url = "../../upload files/bulk grn/". $row["GrnYear"].'-'.$row["GrnNo"]."/";
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
<script type="text/javascript">
$(document).ready(function() 
{
	var url = "../Details/xml.php?id=URLListingPONo";
	var pub_xml_http_obj	= $.ajax({url:url,async:false});
	var pub_po_arr			= pub_xml_http_obj.responseText.split("|");
	
	$( "#cbopono" ).autocomplete({
		source: pub_po_arr
	});
		
		
});
</script>