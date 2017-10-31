<?php
	session_start();
	$backwardseperator = "../";
	include "../Connector.php";	
	$arrStatus  = explode(',',$headerPub_AllowOrderStatus);
	$UserId = $_SESSION["UserID"];
	$companyId=$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Style Items :: Material Transfer</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
/*body {
	background-color: #CCCCCC;
}*/
-->
</style>
<script type="text/javascript" src="materialsTransfer.js"></script>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../java.js" type="text/javascript"></script>
<script type="text/javascript">

//Start - Calender
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
//End - Calender
</script>
</head>

<body onload="hideButtons();">
<form name="frmMeterialsTransfer" id="frmMeterialsTransfer" >
<table width="100%">
<tr>
	<td><?php include '../Header.php'; ?></td>
</tr>
<tr>
<td>
	<table width="1200" border="0" align="center" bgcolor="#FFFFFF" class="bcgl1">
<tr>
    <td width="449"></td>
</tr>
  <tr>
    <td height="12" colspan="3" class="mainHeading">Style Items - Material Transfer</td>
  </tr>
  
  <tr>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1" >
      <tr>
        <td width="20%" height="25" class="normalfnt">&nbsp;From Style</td>
		<td width="30%" class="normalfnt">&nbsp;<select name="cboFromStyles" class="txtbox" id="cboFromStyles" style="width:115px" 
		onchange="getStylewiseOrderNoNewFROM('InterJobFROMGetStylewiseOrderNoFROM',this.value,'cboFrom');getScNoFrom('InterJobFROMgetStyleWiseSCNumFROM','cboFromScno');clearMainGrid();">
		<?php
				$SQL="SELECT distinct  O.strStyle
									FROM  orders O INNER JOIN  stocktransactions S ON O.intStyleId = S.intStyleId
									where(O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2])
									GROUP BY O.intStyleId,O.strStyle 
									HAVING SUM(S.dblQty)>0
									order by O.strStyle";	
			 
					 echo "<option value =\"".""."\">"."Select One"."</option>";
				 $result =$db->RunQuery($SQL);		 
				 while($row =mysql_fetch_array($result))
				 {
					if($_POST["strStyle"] == $row["strStyle"])
						echo "<option selected=\"selected\" value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
					else
						echo "<option value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
				 }			 
		?>
         </select></td>
			
			<td width="18%" class="normalfntMid">From Order</td>
            <td width="32%" class="normalfnt"><select name="cboFrom"  class="txtbox" id="cboFrom" style="width:135px" onchange="LoadMerchandiser();getSC('cboFromScno','cboFrom');getStyleNoFromSC('cboFromScno','cboFrom');clearMainGrid();">
		<?php
		
					$SQL1 = "SELECT distinct  O.intStyleId,O.strOrderNo
									FROM  orders O INNER JOIN  stocktransactions S ON O.intStyleId = S.intStyleId
									where(O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2])
									GROUP BY O.intStyleId,O.strStyle 
									HAVING SUM(S.dblQty)>0
									order by O.strOrderNo";
			
			$result1 =$db->RunQuery($SQL1);
			
					echo "<option value =\"".""."\">"."Select One"."</option>";
				while ($row1=mysql_fetch_array($result1))
				{	
					/*$Qty =$row1["BalQty"];
					if ($Qty>0)	*/	
					echo "<option value=\"".$row1["intStyleId"]."\">".$row1["strOrderNo"]."</option>";
				}
		
		?>
       </select></td>
	  </tr>	
	  <tr>
	  	<td width="20%" class="normalfnt">&nbsp;From SC No </td>
            <td width="30%" class="normalfnt">&nbsp;<select name="cboFromScno"  class="txtbox" id="cboFromScno" style="width:115px" onchange="SeachFromStyle(this);RemoveData();clearMainGrid(); loadStyleName();">
<?php

			/*
			$SQL2="SELECT DISTINCT ".
				"stocktransactions.strStyleNo, ".
				"Sum(stocktransactions.dblQty) AS BalQty, ".
				"specification.intSRNO ".
				"FROM ".
				"stocktransactions ".
				"Inner Join specification ON stocktransactions.strStyleNo = specification.strStyleID ".
				"Inner Join useraccounts AS UA ON UA.intUserID = stocktransactions.intUser ".
				"WHERE ".
				"UA.intCompanyID ='$companyId' ".
				"GROUP BY ".
				"stocktransactions.strStyleNo ".
				"Order By specification.intSRNO";
		*/
		/*$SQL2="SELECT DISTINCT ".
				"stocktransactions.strStyleNo, ".
				"Sum(stocktransactions.dblQty) AS BalQty, ".
				"specification.intSRNO ".
				"FROM ".
				"stocktransactions ".
				"Inner Join specification ON stocktransactions.strStyleNo = specification.strStyleID ".			
				"GROUP BY ".
				"stocktransactions.strStyleNo ".
				"Order By specification.intSRNO desc";*/
		$SQL2= "SELECT distinct  S.intSRNO,S.intStyleId
							FROM specification S INNER JOIN orders O ON S.intStyleId = O.intStyleId
							INNER JOIN stocktransactions ST ON ST.intStyleId = O.intStyleId
							WHERE (O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2])
							GROUP BY S.intSRNO,S.intStyleId
							HAVING SUM(ST.dblQty)>0
							ORDER BY  intSRNO DESC";		

	$result2 =$db->RunQuery($SQL2);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($row2=mysql_fetch_array($result2))
		{	
			/*$Qty =$row2["BalQty"];
			if ($Qty>0)	*/	
			echo "<option value=\"".$row2["intStyleId"]."\">".$row2["intSRNO"]."</option>";
		}
			
?>
            </select></td>     
	  </tr>
   </table></td>
   
   <td width="98"></td>
   
      <td width="637"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1" >
      <tr>
        <td width="11%" height="25" class="normalfnt">&nbsp;&nbsp;To Style</td>
        <td width="18%" class="normalfnt">&nbsp;<select name="cboToStyles" class="txtbox" id="cboToStyles" style="width:115px" 
		onchange="getStylewiseOrderNoNewTO('InterJobTOGetStylewiseOrderNoTO',this.value,'cboTo');getScNoTo('InterJobTOgetStyleWiseSCNumTO','cboToScno');clearMainGrid();">
		<?php
				$SQL="SELECT distinct  O.strStyle
									FROM  orders O 
									where(O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2])
									order by O.strStyle";	
			 
					 echo "<option value =\"".""."\">"."Select One"."</option>";
				 $result =$db->RunQuery($SQL);		 
				 while($row =mysql_fetch_array($result))
				 {
					if($_POST["strStyle"] == $row["strStyle"])
						echo "<option selected=\"selected\" value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
					else
						echo "<option value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
				 }			 
		?>
            </select></td>
			
            <td width="9%" class="normalfnt">&nbsp;To Order</td>
            <td width="20%" class="normalfnt"><select name="cboTo"  class="txtbox" id="cboTo" style="width:115px" onchange="getSC('cboToScno','cboTo');getStyleNoFromSC('cboToScno','cboTo');GetToBuyerPoNo();clearMainGrid();">
        <?php
		 $SQL3= "SELECT distinct  O.intStyleId,O.strOrderNo
								FROM  orders O 
								where (O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2])
								order by O.strOrderNo";
		$result3 =$db->RunQuery($SQL3);
			
				echo "<option value =\"".""."\">"."Select One"."</option>";
			while ($row3=mysql_fetch_array($result3))
			{			
				echo "<option value=\"".$row3["intStyleId"]."\">".$row3["strOrderNo"]."</option>";
			}
		?>
            </select></td>
			</tr>
			
	  <tr>
		 <td width="5%" class="normalfnt">&nbsp;&nbsp;To SC No </td>
            <td width="9%" class="normalfnt">&nbsp;<select name="cboToScno"  class="txtbox" id="cboToScno" style="width:115px" onchange="SeachToStyle(this);RemoveData();clearMainGrid(); loadStyleNameTo();">
<?php
	/*$SQL4="SELECT DISTINCT ".
		  "specification.strStyleID, ".	
		  "specification.intSRNO ".	 
		  "FROM ".
		  "specification ".
		  "WHERE ".
		  "specification.intOrdComplete =0 ".
		  "Order By specification.intSRNO desc";
*/
 $SQL4 =  "SELECT distinct  S.intSRNO,S.intStyleId
							FROM specification S INNER JOIN orders O ON S.intStyleId = O.intStyleId
							WHERE(O.intStatus = $arrStatus[0] or O.intStatus = $arrStatus[1] or O.intStatus = $arrStatus[2])
							ORDER BY  intSRNO DESC";
	$result4 =$db->RunQuery($SQL4);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($row4=mysql_fetch_array($result4))
		{		
			echo "<option value=\"".$row4["intStyleId"]."\">".$row4["intSRNO"]."</option>";
		}
			
?>

            </select></td>
			<td width="10%" class="normalfnt">&nbsp;Buyer PO</td>
            <td width="18%" class="normalfnt"><select name="cboToBuyerPoNo"  class="txtbox" id="cboToBuyerPoNo" style="width:115px" onchange="SeachToStyle();RemoveData();">
             </select></td>
            <td width="14%" class="normalfnt"><img src="../images/search.png" alt="search" id="cmdSearch" name="cmdSearch" width="80" height="24" onclick="LoadStockDetails()"/></td>
	  </tr>	
   </table></td>
  </tr>
 
		
	<tr>
  	<td colspan="3">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
		<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
			<tr>
			<td width="7%" class="normalfnt">&nbsp;Job No</td>

		    <td width="11%">&nbsp;
		      <input name="txtJobNo" type="text" class="txtbox" id="txtJobNo" size="15" style="width:115px"/></td>

	
			
			<td width="8%"><img src="../images/view.png" alt="view" width="91" height="19" onclick="JobNoSearchPopUp();" /></td>
			<td width="3%" class="normalfntMid">Date</td>
			<td width="18%"><input name="gatePassDate" type="text" class="txtbox" id="gatePassDate" value="<?php echo date ("d/m/Y") ?>" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" style="width:100px"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;width:1px" onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
			<td width="8%" class="normalfnt"><span class="normalfnt">&nbsp;User</span></td>
			<?php
$SQL="select Name from  useraccounts where intUserID=$UserId";
$result =$db->RunQuery($SQL);
while ($row=mysql_fetch_array($result))
{

?>
			<td width="13%"><input name="txtfindpo" type="text" class="txtbox" id="txtfindpo" size="17" value="<?php echo $row[Name]?>" readonly=""/></td>
<?php
}
?>
			<td width="7%" class="normalfnt">&nbsp;Merchandiser</td>

			<td width="24%">
			  <input name="txtMerchant" type="text" class="txtbox" id="txtMerchant" size="40" readonly=""/></td>
			<td width="1%">&nbsp;</td>
			</tr>
			</table>
		</td>
		</tr>
		
		<tr>
		<td style="height:5px;"></td>
		</tr>
		
		<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
			<tr>
			<td width="7%" class="normalfnt">&nbsp;Stores</td>
			<td width="39%">
<?PHP
$sqlsetting="select strValue from settings where strKey='CommonStockActivate'";
$result_setting=$db->RunQuery($sqlsetting);
while($row_setting=mysql_fetch_array($result_setting))
{
	$commonBinID	= $row_setting["strValue"];	
}
	
?>
			  &nbsp;
			  <select name="cboMainStores"  class="txtbox" id="cboMainStores" style="width:358px" onchange="RemoveData();activeCommonBins();" >
<?php
	$SQL="select strMainID,strName,intCommonBin from mainstores where intStatus=1 ";

	$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($row=mysql_fetch_array($result))
		{		
			echo "<option value=\"".$row["strMainID"]."\">".$row["strName"]."</option>";
			$intCommonBin = $row["intCommonBin"];
		}
			
?>
			  
              </select>
			</td>
	
			<td width="9%" class="normalfnt" name = '<?php echo $intCommonBin;?>' id="remTD">&nbsp;&nbsp;&nbsp;&nbsp;Remarks </td>
			<td width="43%"><input name="txtRemarks" type="text" class="txtbox" id="txtRemarks" size="80"/></td>
			<td width="2%"><div align="center"></div></td>
			</tr>
			</table>
		</td>
		</tr>
		</table>
	</td>
    </tr>
		
		
    </table></td>
  </tr>
  <tr>
    <td align="center"><table width="90%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td   class="mainHeading2" ></td>
        <td   class="mainHeading2" >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:350px; width:1200px;">
          <table width="1183" cellpadding="0" cellspacing="1" id="tblMain" bgcolor="#CCCCFF">
            <thead class="mainHeading4">
              <td width="2%" height="25" >Del</td>
              <td width="26%" >Description</td>
              <td width="10%" >Buyer PO No</td>
              <td width="9%" >Color</td>
              <td width="7%" >Size</td>
              <td width="5%" >Unit</td>
              <td width="8%" >Stock Bal</td>
              <td width="7%" >Trans. Qty </td>
              <td width="6%" >Location</td>
              <td width="7%" >GRN No </td>
              <td width="13%" >GRN Type </td>
            </thead>
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="1200" cellpadding="0" cellspacing="0"  class="bcgl1" align="center">
      <tr>
        <td width="7%" class="normalfntMid">
        <img src="../images/new.png" alt="new" name="cmdNew" width="96" height="24" class="mouseover"  id="cmdNew" onclick="ClearForm();"/>        
        <img src="../images/save.png" <?php if (!$canSaveInterjobTransfer) { echo 'style="display:none;"'; }?> alt="save" name="cmdSave" width="84" height="24" class="mouseover" id="cmdSave" onclick="SaveValidation();" />
        <img src="../images/approve.png" <?php if (!$canApproveInterjobTransfer) { echo 'style="display:none;"'; }?> alt="approved" name="cmdApproved" width="113" height="24" id="cmdApproved" onclick="Approved();"/>        
		<img src="../images/AUTHORISE.png" <?php if (!$canAuthorizeInterjobTransfer) { echo 'style="display:none;"'; }?> alt="authorise" width="116" height="24" name="cmdAuthorise"id="cmdAuthorise" onclick="Authorise();"  />
        <img src="../images/conform.png"  <?php if (!$canConfirmInterjobTransfer) { echo 'style="display:none;"'; }?> alt="conform" name="cmdConform" width="115" height="24" class="mouseover" id="cmdConform" onclick="Confirm();" />
        <img src="../images/cancel.jpg" <?php if (!$canCancelInterjobTransfer) { echo 'style="display:none;"'; }?>  alt="Cancel" name="cmdCancel" width="104" height="24" class="mouseover" id="cmdCancel" onclick ="Cancel();"/>
        <img src="../images/report.png" name="butReport" width="108" height="24" class="mouseover" id="butReport" onclick="ViewReport();"/>
        <a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0" class="mouseover" /></a>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td id="StatusBar">&nbsp;</td>
  </tr>
</table>
</form>
<!--Start - Open search job no window-->
<div style="left:426px; top:149px; z-index:10; position:absolute; width: 261px; visibility:hidden; height: 61px;" id="jobSearch" ><table width="280" height="59" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
		  	<td width="3" height="22" class="normalfnt"></td>
            <td width="41" height="22" class="normalfnt">State </td>
            <td width="100"><select name="select3" class="txtbox" id="cboState" style="width:100px" onchange="LoadPopUpJobNo();">              
              <option value="0">Saved</option>
              <option value="1">Approved</option>
			  <option value="2">Autorised</option>
			  <option value="3">Confirmed</option>
			  <option value="10">Cancelled</option>
            </select></td>
            <td width="26" class="normalfnt">Year</td>
            <td width="69"><select name="select4" class="txtbox" id="cboYear" style="width:55px" onchange="LoadPopUpJobNo();">
             
			   <?php
	
	$SQL = "SELECT DISTINCT intTransferYear FROM itemtransfer ORDER BY intTransferYear DESC;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intTransferYear"] ."\">" . $row["intTransferYear"] ."</option>" ;
	}
	
	?>
            </select></td>
            <td width="19"><img src="../images/cross.png" onclick="JobNoSearchPopUp();"/></td>
          </tr>
          <tr>
		  <td width="3" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Job No</div></td>
            <td><select name="select" class="txtbox" id="cboJobNo" style="width:100px" onchange="loadTransferIn();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
        
        </table>
		

</div>
<!--End - Open search job no window-->		
<!--Start - open Mian Bin locations-->
<div style="left:525px; top:113px; z-index:10; position:absolute; width: 408px; visibility:hidden; height: 86px;" id="ShowMainBin" >
  <table width="407" height="88" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
		  	<td width="2" height="28" class="normalfnt"></td>
            <td width="99" height="28" class="normalfnt">Main Stores </td>
           <td width="279"><select name="select3" class="txtbox" id="cboMainStores" style="width:250px" onchange="LoadPopUpSubStores();"> 
		   <option value="Select One" selected="selected">Select One</option>           </select></td>
           <td width="25" align="right" valign="top"><img src="../images/cross.png" alt="close" width="17" height="17" align="top" onclick="CloseMainBin();" /></td>
          </tr>
          <tr>
		  <td width="2" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Sub Stores </div></td>
            <td colspan="2"><select name="select" class="txtbox" id="cboSubStores" style="width:250px" onchange="LoadPopUpLocations();">
			<option value="Select One" selected="selected">Select SubStores</option>
            </select>            </td>
          </tr>
		   <tr>
		  <td width="2" height="27" class="normalfnt"></td>
            <td><div align="center" class="normalfnt">Location</div></td>
            <td colspan="2"><select name="select" class="txtbox" id="cboLocation" style="width:250px" onchange="loadTransferIn();">
			<option value="Select One" selected="selected">Select Location</option>
            </select>            </td>
          </tr>
  </table>
		
	</td></tr></table>
</div>
<!--End - open Mian Bin locations-->
<script type="text/javascript">
var canSaveInterjobTransfer = <?php echo $canSaveInterjobTransfer?"true":"false"; ?>;
var canApproveInterjobTransfer = <?php echo $canApproveInterjobTransfer?"true":"false"; ?>;
var canAuthorizeInterjobTransfer = <?php echo $canAuthorizeInterjobTransfer?"true":"false"; ?>;
var canConfirmInterjobTransfer = <?php echo $canConfirmInterjobTransfer?"true":"false"; ?>;
var canCancelInterjobTransfer = <?php echo $canCancelInterjobTransfer?"true":"false"; ?>;
</script>
</body>
</html>


