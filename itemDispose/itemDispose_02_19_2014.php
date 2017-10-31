<?php
$backwardseperator = "../";
session_start();
include "../Connector.php";	
$arrStatus  = explode(',',$headerPub_AllowOrderStatus);
$intCompanyId		= $_SESSION["FactoryID"];

//echo $intCompanyId;
$StyleNo 			= $_POST["cmbStyle"];
$SCNo 				= $_POST["cmbSC"];
/*$AgeFrom			= $_POST["txtAgeFrom"];
$AgeTo 				= $_POST["txtAgeTo"];
$DateFrom 			= $_POST["txtValidFrom"];
$DateTo 			= $_POST["txtValidTo"];*/
$StoreID			= $_POST["cmbStore"];
$mainCat 			= $_POST["cmbMainCat"];
$subCat				= $_POST["cmbSubCat"];
$matName 			= $_POST["txtItem"];
$mainStoresID		= $_POST["cmbStore"];
$subStores			= $_POST["cboSubStore"];
$type			= $_POST["txtMainType"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache"> 
<title>Item Dispose</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style>
<script src="itemDispos.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../javascript/jquery.js"></script>
<script src="../javascript/jquery-ui.js"></script>
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
<form name="frmItemDispose" id="frmItemDispose" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
<tr ><td colspan="5"><?php include $backwardseperator.'Header.php'; ?></td></tr>
<tr><td>
  <table width="919" border="0" cellspacing="0" cellpadding="0" align="center" class="bcgl1" >
  	
    <tr>
      <td height="22" colspan="5" class="mainHeading">Item Disposal</td>
    </tr>
    <tr>
      <td width="20%">&nbsp;</td>
      <td width="26%">&nbsp;</td>
      <td width="12%">&nbsp;</td>
      <td width="24%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5"><table align="center" width="99%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
        <tr bgcolor="#FFFFFF">
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Style No </td>
          <td><select name="cmbStyleName" id="cmbStyleName" style="width:200px" class="txtbox" onChange="LoadStyleWiseOrderAndSc(this);">
            <?php 
			$SQL = "SELECT DISTINCT orders.strStyle FROM specification Inner Join orders ON specification.intStyleId = orders.intStyleId AND orders.intStatus <> 13 order by orders.strStyle ";	
			$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\">Select One</option>";
		while ($row=mysql_fetch_array($result))
		{
			if($_POST["cmbStyleName"]==$row["strStyle"])
				echo "<option selected=\"selected\" value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
			else
				echo "<option value=\"".$row["strStyle"]."\">".$row["strStyle"]."</option>";
		}
				
	  ?>
          </select></td>
          <td class="normalfnt">&nbsp;Disposal No</td>
          <td><input type="text" name="txtDisposeNo" id="txtDisposeNo" disabled style="width:198px;" value="<?php echo $_POST["txtDisposeNo"]; ?>"></td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="5%" class="normalfnt">&nbsp;</td>
          <td width="14%" class="normalfnt">Order No </td>
          <td width="30%"><select name="cmbStyle" id="cmbStyle" style="width:200px" class="txtbox" onChange="LoadSC(this);">
              <?php 
			$SQL = "SELECT DISTINCT orders.strOrderNo,specification.intStyleId FROM specification Inner Join orders ON specification.intStyleId = orders.intStyleId AND orders.intStatus <> 13 order by orders.strOrderNo ";	
			$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\">Select One</option>";
		while ($row=mysql_fetch_array($result))
		{
			if($_POST["cmbStyle"]==$row["intStyleId"])
				echo "<option selected=\"selected\" value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
			else
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strOrderNo"]."</option>";
		}
				
	  ?>
            </select>          </td>
          <td width="18%" class="normalfnt">&nbsp;SC No </td>
          <td width="32%"><select name="cmbSC" id="cmbSC" style="width:200px" class="txtbox" onChange="LoadStyle(this);">
              <?php 
			$SQL = "SELECT distinct intStyleId, intSRNO FROM specification order by intSRNO DESC ";	
			$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\">Select One</option>";
		while ($row=mysql_fetch_array($result))
		{
			if($_POST["cmbStyle"]==$row["intStyleId"])
				echo "<option selected=\"selected\"value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
			else
				echo "<option value=\"".$row["intStyleId"]."\">".$row["intSRNO"]."</option>";
		}
				
	  ?>
					 
            </select>          </td>
          <td width="1%">&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Main Stores</td>
          <td><select name="cmbStore" id="cmbStore" class="txtbox" style="width:200px" onChange="loadSubStores(this);">
		<?php 
			//$SQLstore = "select * from mainstores where intCompanyId='$intCompanyId' and intStatus=1";
			
			$SQLstore ="SELECT 
						mainstores.strMainID,
						mainstores.strName
						FROM
						mainstores
						WHERE
						mainstores.intCompanyId =  '$intCompanyId' AND
						mainstores.intStatus =  '1';";
			$resultStore =$db->RunQuery($SQLstore);	
						
			echo "<option value =\"".""."\">Select One</option>";
			while ($rowS =mysql_fetch_array($resultStore))
			{
				if($_POST["cmbStore"]==$rowS["strMainID"])
					echo "<option selected=\"selected\" value=\"".$rowS["strMainID"]."\">".$rowS["strName"]."</option>";
				else
					echo "<option value=\"".$rowS["strMainID"]."\">".$rowS["strName"]."</option>";
			}
		  ?>
            </select><input type="hidden" value="<?php echo $type ?>" name="txtMainType" id="txtMainType"></td>
          <td class="normalfnt">&nbsp;Sub Stores</td>
          <td><select style="width:200px" class="txtbox" id="cboSubStore" name="cboSubStore">
              <?php 
				$sql_SubStore="SELECT strSubID,strSubStoresName FROM substores WHERE strMainID='$mainStoresID' and intStatus=1;";
				$res=$db->RunQuery($sql_SubStore);
				echo "<option value =\"".""."\">Select One</option>";
				while($row=mysql_fetch_array($res))
				{
					if($_POST["cboSubStore"]==$row["strSubID"])
						echo "<option selected=\"selected\" value=\"".$row["strSubID"]."\">".$row["strSubStoresName"]."</option>";
					else
						echo "<option value=\"".$row["strSubID"]."\">".$row["strSubStoresName"]."</option>";
				}
	  			?>
          </select></td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Main Category </td>
          <td><select name="cmbMainCat" id="cmbMainCat" style="width:200px" class="txtbox" onChange="LoadSubCat(this);">
              <?php 
	  	$SQLmainCat = "select * from matmaincategory order by intID ";
		
		$resultmainCat =$db->RunQuery($SQLmainCat);	
					
					echo "<option value =\"".""."\">Select One</option>";
		while ($rowMain =mysql_fetch_array($resultmainCat))
		{
				if($_POST["cmbMainCat"]==$rowMain["intID"])
					echo "<option selected=\"selected\"value=\"". $rowMain["intID"] ."\">" . $rowMain["strDescription"] ."</option>" ;
				else
					echo "<option value=\"".$rowMain["intID"]."\">".$rowMain["strDescription"]."</option>";
		}
	  ?>
          </select></td>
          <td class="normalfnt">&nbsp;Sub Category</td>
          <td><select name="cmbSubCat" id="cmbSubCat" class="txtbox" style="width:200px">
		  <?php 
				$sql_SubStore="SELECT intSubCatNo, StrCatName FROM matsubcategory WHERE matsubcategory.intCatNo =  '$mainCat';";
				$res=$db->RunQuery($sql_SubStore);
				echo "<option value =\"".""."\">Select One</option>";
				while($row=mysql_fetch_array($res))
				{
					if($_POST["cmbSubCat"]==$row["intSubCatNo"])
						echo "<option selected=\"selected\" value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
					else
						echo "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
				}
	  			?>
          </select></td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">Mat Name Like </td>
          <td colspan="2"><input class="txtbox" type="text" name="txtItem" id="txtItem" style="width:200px" value="<?php echo $_POST["txtItem"];?>"></td>
          <td rowspan="2"><div align="right"><img src="../images/search.png" alt="search"  class="mouseover" onClick="LoadItemData();"></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
      </table></td>
      </tr>
	   <tr>
      <td >&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	 <tr>
      <td align="center" colspan="5"><div align="center"  style="height:300px;overflow:auto;width:901px" class="bcgl1" >
      <table align="center" width="1200" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblMain">
      <thead>
        <tr class="mainHeading4" >
          <td height="25">Order No </td>
          <td >Buyer PO </td>
          <td >Material Description</td>
          <td >Qty </td>
          <td >Dispose Qty </td>
          <td >Dispose</td>
          <td>Pending Dispose Qty</td>
          <td >Main Stores</td>
          <td >Sub Stores </td>
          <td >Location</td>
          <td >BIN</td>
          <td >Color</td>
          <td >Size</td>
          <td >Unit</td>
		  <td >GRN No.</td>
          <td>GRN Type</td>
        </tr>
      </thead>
      <tbody>
        <?php 
		$SQL = "select sum(st.dblQty) as Qty,strMainStoresID,st.strSubStores,st.strLocation,st.strBin,st.intStyleId,st.strBuyerPoNo,st.intGrnNo,
st.intGrnYear,st.strGRNType,mil.strItemDescription,ms.strName as MainStore,sub.strSubStoresName,sl.strLocName,sb.strBinName,
o.strOrderNo,st.intMatDetailId,st.strColor,st.strSize,st.strUnit
from stocktransactions as st 
inner join matitemlist mil on st.intMatDetailId = mil.intItemSerial 
inner join mainstores ms on ms.strMainID = st.strMainStoresID 
inner join substores sub on sub.strSubID = st.strSubStores
inner join storeslocations sl on sl.strLocID = st.strLocation
inner join storesbins sb on sb.strBinID = st.strBin
inner join orders o on o.intStyleId = st.intStyleId
where st.intStyleId='$StyleNo' and st.strMainStoresID='$StoreID' ";

	if($subStores !='') 
		$SQL .= " and st.strSubStores = '$subStores' ";
	if($mainCat != '')		
		$SQL .= " and mil.intMainCatID = '$mainCat' ";
	if($subCat != '')		
		$SQL .= " and mil.intSubCatID = '$subCat' ";
	if($matName != '')		
		$SQL .= " and mil.strItemDescription like '%$matName%' ";
			
		$SQL .= "group by strMainStoresID,st.strSubStores,st.strLocation,st.strBin,st.intStyleId,st.strBuyerPoNo,st.intGrnNo,
st.intGrnYear,st.strGRNType,mil.strItemDescription, MainStore, sub.strSubStoresName, sl.strLocName, sb.strBinName, o.strOrderNo,st.intMatDetailId,st.strColor,st.strSize,st.strUnit
having Qty>0";
					//echo $SQL;
					$result= $db->RunQuery($SQL);
	while($row =@mysql_fetch_array($result))
	{
		$grnType = $row["strGRNType"];
		switch($grnType)
		{
			case 'S':
			{
				$strGRNType = 'Style';
				break;
			}
			case 'B':
			{
				$strGRNType = 'Bulk';
				break;
			}
		}
	?>
        <tr class="bcgcolor-tblrowWhite">
          <td width="100" class="normalfnt" id="<?php echo $row["intStyleId"];?>"><?php echo $row["strOrderNo"]; ?></td>
          <td width="100" class="normalfnt" id="
		  <?php
		   echo $row["strBuyerPoNo"]; ?>"><?php  echo $row["strBuyerPoNo"];?>  </td>
          <td class="normalfnt" id=" <?php echo $row["intMatDetailId"]; ?> "> <?php echo $row["strItemDescription"]; ?> </td>
          <td width="80" align="right" class="normalfntRite"><?php echo round($row["Qty"],2); ?></td>
          <td nowrap="nowrap">
          	<input type="text" disabled="disabled" name="txtdisposeQty" id="txtdisposeQty" class="txtboxRightAllign" size="10" onKeyPress="return CheckforValidDecimal(this.value,4,event);" onKeyUp="setBalance(this);" onMouseDown="DisableRightClickEvent();" />          </td>
          <td class="normalfnt"><div align="center"><input onClick="setArray(this);" type="checkbox" name="chkDispose" id="chkDispose"></div></td>
          <td class="normalfntRite"><?php echo abs(getPendingDisposeQty($row["intStyleId"],$row["strBuyerPoNo"],$row["intMatDetailId"],$row["strColor"],$row["strSize"],$row["strMainStoresID"],$row['intGrnNo'],$row['intGrnYear'],$grnType)); ?></td>
          <td class="normalfnt" id="<?php echo $row["strMainStoresID"]; ?>"><?php echo $row["MainStore"]; ?></td>
          <td class="normalfnt" id="<?php echo $row["strSubStores"]; ?>"><?php echo $row["strSubStoresName"]; ?></td>
          <td class="normalfnt" id="<?php echo $row["strLocation"]; ?>"><?php echo $row["strLocName"]; ?></td>
          <td class="normalfnt" id="<?php echo $row["strBin"]; ?>"><?php echo $row["strBinName"]; ?></td>
          <td class="normalfnt"><?php echo $row["strColor"]; ?></td>
          <td class="normalfnt"><?php echo $row["strSize"]; ?></td>
          <td class="normalfnt"><?php echo $row["strUnit"]; ?></td>
		  <td class="normalfnt"><?php if($row['intGrnNo']!=""){echo $row["intGrnYear"]."/".$row['intGrnNo'];} ?>
		  </td>
          <td class="normalfnt" id="<?php echo $grnType; ?>"><?php echo $strGRNType; ?></td>
        </tr>
        <?php 
	}
		?>
        </tbody>
      </table></div></td>
    </tr>
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
    <tr>
      <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bcgl1">
        <tr >
          <td width="50%"><div align="center">
		  <img src="../images/new.png" onClick="clearPage();"  /> 
		  <img src="../images/save.png" width="84" height="24" class="mouseover" onClick="saveGrid();" id="butSave" />
          <img src="../images/conform.png" onClick="openConfirmReport();" style="display:none" id="butConfirm">
		  <a href="../main.php"><img src="../images/close.png" width="97" height="24" border="0" /></a>
		  </div></td>
        </tr>
      </table></td>
      </tr>
  </table>
  </td>
  </tr>
  </table>
  <?php 
  	function getStyleName($StyleID)
	{
		$SQLS = " select strOrderNo from orders where intStyleId='$StyleID'";
		 global $db;
			$resultS=$db->RunQuery($SQLS);
	$rowS=mysql_fetch_array($resultS);
	return $rowS["strOrderNo"];
	}
		
	function getBuerPOName($StyleID,$buyerPOno)
	{
		$SQL = " SELECT strBuyerPoName FROM style_buyerponos
				 WHERE intStyleId='$StyleID' AND strBuyerPONO='$buyerPOno'";
			 
				global $db;
				$result = $db->RunQuery($SQL);
				while($row = mysql_fetch_array($result))
				{
					$BPOname = $row["strBuyerPoName"];
				}
			return $BPOname;	 			 
	}
	function getPendingDisposeQty($styleId,$buyerPO,$matDetailID,$color,$size,$mainStoreId,$grnNo,$grnYear,$grnType)
	{
		global $db;
		
		$sql ="select  COALESCE(sum(dblQty),0) as Qty from stocktransactions_temp
where intStyleId='$styleId' and strMainStoresID='$mainStoreId' and strBuyerPoNo='$buyerPO' and intMatDetailId='$matDetailID' and 
strColor='$color' and strSize='$size' and strType='StyleDispose' and intGrnNo='$grnNo' and intGrnYear='$grnYear' and strGRNType='$grnType'";

		$result = $db->RunQuery($sql);
		$row = mysql_fetch_array($result);
		//echo $sql;
		return $row["Qty"];
	}
  ?>
</form>
</body>
</html>
