<?php
$backwardseperator = "../../";
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Bulk GRN</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />


<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="java.js" type="text/javascript"></script>
<script type="text/javascript" >
	function pageSubmit()
	{
		document.getElementById("frmbom").submit();
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

<body onload="loadGrnFrom(
<?php 	
$id = $_GET["id"];
if($id!=0)
{
	echo $_GET["GRNNo"] ; echo "," ; echo $_GET["intYear"] ; echo "," ; echo $_GET["intStatus"]; echo "," ; echo $_GET["thisGrnFactory"];
}
else
	echo "0,0,99,0";
?> );locadComonbin();">

	<?php
	include "../../Connector.php";	
	
				$SQL = " SELECT intCompanyID FROM useraccounts  where intUserID=".$_SESSION["UserID"].";";
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result))
					$_SESSION["intUserComp"]=$row["intCompanyID"];
	
	
	///////////////////////// get common bin 
					$pub_active=0;
					$SQL = " Select strValue from settings where strKey='CommonStockActivate'";
					$result = $db->RunQuery($SQL);
					$active =10;
					while($row = mysql_fetch_array($result))
					{
						$pub_active = $row["strValue"];
						break;
					}
?>
    <form name="frmbom" id="frmbom" action="grndetails.php" method="post" >
<table width="100%">
<tr>
    <td><?php include '../../Header.php'; ?></td>
</tr>
<tr><td>
<table width="1100" height="546" border="0" align="center" bgcolor="#FFFFFF"  class="bcgl1">
 <tr>
    <td height="25" colspan="2" class="mainHeading">Bulk Grn</td>
</tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td height="36" colspan="5"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgcolor-highlighted">
          <tr>
            <td width="6%" height="24" class="normalfntSM">Suplier Origin</td>
            <td width="10%" class="normalfnt"><select name="cbosuporigin" onchange="GetSuppliers()" class="txtbox" id="cbosuporigin" style="width:80px">
              <option>.</option>
              <option>Local</option>
              <option>Foreign</option>
            </select></td>
            <td width="5%" class="normalfntSM">Suplier</td>
            <td width="13%" class="normalfnt"><select name="cbosuplier"  class="txtbox" id="cbosuplier" style="width:120px">
              <?php
				$SQL = " SELECT * FROM suppliers  ORDER BY strTitle;";
		
				$result = $db->RunQuery($SQL);
		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
				}
			?>
            </select></td>
            <td width="7%" class="normalfntSM">PO No Like</td>
            <td width="13%" class="normalfnt"><input name="txtpino" type="text" class="txtbox" id="txtpino" size="10" /></td>
            <td width="2%" class="normalfnt"><input type="checkbox" name="chkpodate" id="chkpodate" value="true" onclick="dateDisable(this);" /></td>
            <td width="8%" class="normalfntSM">PO Date From</td>
            <td width="13%" class="normalfnt"><input name="fromDate" type="text" class="txtbox" id="fromDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
            <td width="2%" class="normalfntSM">To</td>
            <td width="13%" class="normalfnt"><input name="toDate" type="text" class="txtbox" id="toDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
            <td width="8%" class="normalfnt"><img src="../../images/search.png" alt="search" width="80" height="24" class="mouseover" onclick="LoadPo()"/></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="2" class="normalfnt">Bulk GRN No</td>
        <td width="35%" class="normalfnt"><input name="txtgrnno" type="text" class="txtbox" id="txtgrnno"  style="width:290px" onfocus="this.blur();" /></td>
        <td width="12%" class="normalfnt">Date</td>
        <td width="39%" class="normalfnt"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="38%" class="normalfnt"><input name="grnDate" type="text" class="txtbox" id="grnDate" value=<?php echo date("Y-m-d"); ?>   style="width:100px" onfocus="this.blur();"/></td>
            <td width="29%">GRN Value</td>
            <td width="33%"><input name="txtGrnValue" type="text" class="txtbox" id="txtGrnValue"   style="width:100px;text-align:right" onfocus="this.blur()" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="8%" class="normalfnt">Bulk PONo<span class="compulsoryRed"> *</span></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <td class="normalfnt"><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td><select name="txtpono" class="txtbox" id="txtpono" style="width:291px" onchange="ShowItems();">
<?php
	$SQL = 	"SELECT  DISTINCT PH.intBulkPoNo  AS dd, PH.intBulkPoNo, S.strTitle, PH.intYear, concat(PH.intYear,'/',PH.intBulkPoNo, ' -- ' , S.strTitle) AS ListF, 
concat(PH.intYear  ,'/', PH.intBulkPoNo) AS NPONO 
FROM bulkpurchaseorderdetails PD INNER JOIN 
bulkpurchaseorderheader  PH ON PH.intBulkPoNo = PD.intBulkPoNo AND PH.intYear = PD.intYear INNER JOIN 
suppliers S ON PH.strSupplierID = S.strSupplierID 
WHERE     (PH.intStatus = 1) AND (PH.intDeliverTo = ".$_SESSION["FactoryID"].")";
		
if($intPoNo !='')
	$SQL .=" AND PH.intBulkPoNo like '%$intPoNo%'";

	$SQL .= " order by NPONO DESC";

	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["NPONO"] ."\">" . trim($row["ListF"]) ."</option>" ;
	}
?>
              </select></td>
              </tr>
          </table></td>
        <td class="normalfnt">Invoice No <span class="compulsoryRed">*</span></td>
        <td class="normalfnt"><input name="txtinvoiceno" type="text" class="txtbox" id="txtinvoiceno"  style="width:383px;text-transform: uppercase;" maxlength="100" /></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt">Supplier Advice No <span class="compulsoryRed">*</span></td>
        <td class="normalfnt"><input name="txtsupadviceno" type="text" class="txtbox" id="txtsupadviceno"   style="width:290px" maxlength="10" /></td>
        <td class="normalfnt">Main Store<span class="compulsoryRed"> *</span></td>
        <td class="normalfnt"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="38%"><select name="cbomainstores" class="txtbox" id="cbomainstores" style="width:102px" onchange="loadSubStores()" >
			
			<?php
			
				$SQL = " Select strValue from settings where strKey='CommonStockActivate'";
				$result = $db->RunQuery($SQL);
				$active =0;
				while($row = mysql_fetch_array($result))
				{
					$active = $row["strValue"];
					break;
				}
				
				if($active==0)
				{
						
					$SQL = "Select * from mainstores where intStatus=1 and intCompanyId='".$_SESSION["FactoryID"]."'";
					$result = $db->RunQuery($SQL);
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["strMainID"] ."\">" . $row["strName"] ."</option>" ;
						$i++;
						if($i==1)
							$firstMainId = $row["strMainID"];
					}				
				
				}
				else
				{
					$SQL = "Select * from mainstores where intStatus=1 and intCompanyId='".$_SESSION["FactoryID"]."'";
					$result = $db->RunQuery($SQL);
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["strMainID"] ."\">" . $row["strName"] ."</option>" ;
						$i++;
						if($i==1)
							$firstMainId = $row["strMainID"];
					}		
				}
			?>
                  </select></td>
            <td width="29%" id="subStore">Sub Store<span class="compulsoryRed">*</span></td>
            <td width="33%"><select name="cboSubStores" class="txtbox" id="cboSubStores" style="width:102px">
              	<?php
					$SQL = " Select strValue from settings where strKey='CommonStockActivate'";
					$result = $db->RunQuery($SQL);
					$active =0;
					while($row = mysql_fetch_array($result))
					{
						$active = $row["strValue"];
						break;
					}
					
					if($active==1)
					{
							//$SQL = " Select * from storesbins where intStatus=9";
							$SQL = "Select * from substores Where strMainID='$firstMainId' AND intStatus = 1 ORDER BY strSubStoresName  ";
							$result = $db->RunQuery($SQL);
							while($row = mysql_fetch_array($result))
							{
								echo "<option value=\"". $row["strSubID"] ."\">" . $row["strSubStoresName"] ."</option>" ;
							}	
					}
					else
					{
							$SQL = "Select * from substores Where strMainID='$firstMainId' AND intStatus = 1 ORDER BY strSubStoresName  ";
							$result = $db->RunQuery($SQL);
							while($row = mysql_fetch_array($result))
							{
								echo "<option value=\"". $row["strSubID"] ."\">" . $row["strSubStoresName"] ."</option>" ;
							}	
					}
				?>
            </select></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt">Advice Date</td>
        <td class="normalfnt"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
			<td width="46%" class="normalfnt"><input name="adviceDate" type="text" value=<?php echo date("d/m/Y"); ?> class="txtbox" id="adviceDate"   style="width:100px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');"/><input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"></td>
			<?php 
			$xml = simplexml_load_file('../../config.xml');
			$DisplayBatchNo = $xml->GRN->DisplayBatchNo;
			?>
            <td width="18%"><?php echo ($DisplayBatchNo=='false')?'':'Batch No'; ?></td>
            <td width="36%"><input <?php echo ($DisplayBatchNo=='false')?"style=\"visibility:hidden\"":''; ?> name="txtbatchno" type="text" class="txtbox" id="txtbatchno"   style="width:100px" /></td>
          </tr>
        </table></td>
        <td >&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="89%" align="left" bgcolor="#9BBFDD" class="normalfnth2"><span class="normalfnt"><img src="../../images/add_bin.png" alt="Auto Bin"  align="right" class="mouseover" onclick="autoBin()" style="visibility:<?php echo ($pub_active==0)?'visible':'hidden' ?>"  id="auto_Bin"/></span></td>
        <td width="11%" bgcolor="#9BBFDD" class="normalfnt"><img src="../../images/add-new.png" alt="add new" width="109" height="18" class="mouseover" onclick="ShowItems()" /></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:250px; width:1100px;">
          <table  width="1400" border="0" cellpadding="0" cellspacing="1" bordercolor="#162350" bgcolor="#CCCCFF" id="tblMainGrn">
            <tr>
              <td  width="1%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Main Category </td>
              <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Color</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Size</td>
              <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
              <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">PO Rate</td>
               <td width="4%" bgcolor="#498CC2" class="normaltxtmidb2">PO Qty </td>
               <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Pending Qty</td>
              <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Rec Qty</td>
              <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">Location</td>
              <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Excess</td>
			  <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Balance</td>
              <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Value</td>
			  <td width="5%" bgcolor="#498CC2"  class="normaltxtmidb2">PONo</td>
          </table>
        </div></td>
        </tr>
        
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#D6E7F5">
      <tr>
        <td align="center">
        <img src="../../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="newPage();"/>
        <img src="../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="save();" />
        <img src="../../images/conform.png" alt="conform" name="butConform" width="115" height="24" class="mouseover" id="butConform" onclick="grnConfirmReport();" <?php echo (($PP_confirmBulkGRN) ?  "style=\"display:inline\"":"style=\"display:none\"")?>/>
        <img src="../../images/cancel.jpg" alt="Cancel" name="butCancel" width="104" height="24" class="mouseover" id="butCancel" onclick ="cancel();" />
        <img src="../../images/report.png" name="butReport" width="108" height="24" class="mouseover" id="butReport" onclick="grnReport();"/><img src="../../images/upload.jpg" width="97" height="24" onclick="UploadFile();" /><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" class="mouseover" /></a>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div id="divcons2" style="overflow:scroll; height:100px; width:1100px;">
      <table width="1100" cellpadding="0" cellspacing="0" id="tblMainBin">
        <tr>
          <td width="6%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Bin ID</td>
          <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2R">Req Qty</td>
          <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Main Stores</td>
          <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Sub Stores</td>
          <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Location</td>
          <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2R">Bin Capacity Qty </td>
          <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2R">Bin Available Qty </td>
          <td width="17%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
          <td width="15%" bgcolor="#498CC2" class="normaltxtmidb2">Mat Sub Cat Id </td>
          <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">Bin Name  </td>
          </tr>
      </table>
    </div></td>
  </tr>
</table>
</td>
</tr>
</table>
</form>
</body>
</html>
<script type="text/javascript">
var confirmBulkGRN = "<?php echo $PP_confirmBulkGRN?>";
</script>
