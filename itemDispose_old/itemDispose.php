<?php
$backwardseperator = "../";
session_start();
include "../Connector.php";	
$arrStatus  = explode(',',$headerPub_AllowOrderStatus);
$intCompanyId		=$_SESSION["FactoryID"];
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
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Item Dispose</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />

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
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr><td><?php include $backwardseperator.'Header.php'; ?></td></tr>
<!--<tr><td>&nbsp;</td></tr>-->
<tr><td>
  <table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td colspan="5" class="mainHeading"> Item Disposal </td>
    </tr>
    <tr>
      <td width="20%">&nbsp;</td>
      <td width="26%">&nbsp;</td>
      <td width="12%">&nbsp;</td>
      <td width="24%">&nbsp;</td>
      <td width="18%">&nbsp;</td>
    </tr>
    <tr>
      <td class="normalfnt">Style </td>
      <td><select name="cmbStyle" id="cmbStyle" style="width:150px" class="txtbox" onChange="LoadSC(this);">
      <?php 
	  	$SQL = " select distinct S.intStyleId, O.strStyle
				from stocktransactions S inner join orders O on
				S.intStyleId = O.intStyleId
				 where ";
				for($i=1;$i<=count($arrStatus); $i++)
				{
					if($i==count($arrStatus))
					{
						$SQL .= " O.intStatus ='$arrStatus[$i]'";	
					}
					else
					{
						$SQL .= " O.intStatus ='$arrStatus[$i]' or";	
						}
				}
				 /*O.intStatus = 0 or O.intStatus = 10 or O.intStatus=11
				order by S.intStyleId ";*/
				
				$result =$db->RunQuery($SQL);
		
			echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($row=mysql_fetch_array($result))
		{
			if($_POST["cmbStyle"]==$row["intStyleId"])
				echo "<option selected=\"selected\"value=\"".$row["intStyleId"]."\">".$row["strStyle"]."</option>";
			else
				echo "<option value=\"".$row["intStyleId"]."\">".$row["strStyle"]."</option>";
		}
				
	  ?>
      </select>      </td>
      <td class="normalfnt"> SC No </td>
      <td><select name="cmbSC" id="cmbSC" style="width:150px" class="txtbox" onChange="LoadStyle(this);">
      <?php $SQLSC = " select distinct S.intStyleId, sp.intSRNO
					  from stocktransactions S inner join orders O on
					  S.intStyleId = O.intStyleId inner join specification sp on
					  sp.intStyleId = S.intStyleId
					  where ";
					  
					 for($i=1;$i<=count($arrStatus); $i++)
					{
						if($i==count($arrStatus))
						{
							$SQLSC .= " O.intStatus ='$arrStatus[$i]'";	
						}
						else
						{
							$SQLSC .= " O.intStatus ='$arrStatus[$i]' or";	
							}
					} 
				$resultSC =$db->RunQuery($SQLSC);	
					echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($rowSC =mysql_fetch_array($resultSC))
		{
			if($_POST["cmbSC"]==$rowSC["intStyleId"])
				echo "<option selected=\"selected\"value=\"".$rowSC["intStyleId"]."\">".$rowSC["intSRNO"]."</option>";
			else
				echo "<option value=\"".$rowSC["intStyleId"]."\">".$rowSC["intSRNO"]."</option>";
		}
					  ?>
      </select>      </td>
      <td>&nbsp;</td>
    </tr>
  <!--  <tr>
      <td class="normalfnt">Age From </td>
      <td><input type="text" name="txtAgeFrom" id="txtAgeFrom" size="15" value="<?php echo $AgeFrom; ?>"></td>
      <td class="normalfnt">To</td>
      <td><input type="text" name="txtAgeTo" id="txtAgeTo" value="<?php echo $AgeTo?>" size="15"></td>
      <td>&nbsp;</td>
    </tr>-->
    <!--<tr>
      <td class="normalfnt">Date From </td>
      <td><input name="txtValidFrom" type="text"  class="txtbox" id="txtValidFrom" size="15" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');" value="<?php echo $_POST["txtValidFrom"];?>"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
      <td class="normalfnt">To</td>
      <td><input name="txtValidTo" type="text"  class="txtbox" id="txtValidTo" size="15" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"value="<?php echo $_POST["txtValidTo"];?>"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
      <td>&nbsp;</td>
    </tr>-->
    <tr>
      <td class="normalfnt">Main Stores</td>
      <td><select name="cmbStore" id="cmbStore" class="txtbox" style="width:150px" onChange="loadSubStores(this);"> 
      <?php 
	  	$SQLstore = "select * from mainstores
					where intCompanyId='$intCompanyId' and intStatus=1 ";
					
					$resultStore =$db->RunQuery($SQLstore);	
					
					echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($rowS =mysql_fetch_array($resultStore))
		{
			if($_POST["cmbStore"]==$rowS["strMainID"])
				echo "<option selected=\"selected\"value=\"".$rowS["strMainID"]."\">".$rowS["strName"]."</option>";
			else
				echo "<option value=\"".$rowS["strMainID"]."\">".$rowS["strName"]."</option>";
		}
	  ?>
      </select>      </td>
      <td class="normalfnt">Sub Stores</td>
      <td><select style="width:150px" class="txtbox" id="cboSubStore" name="cboSubStore">
      <?php 
	  	$sql_SubStore="SELECT strSubID,strSubStoresName FROM substores WHERE strMainID='$mainStoresID';";
	  	$res=$db->RunQuery($sql_SubStore);
		while($row=mysql_fetch_array($res))
		{
			if($_POST["cboSubStore"]==$row["strSubID"])
			{echo "<option selected=\"selected\"value=\"".$row["strSubID"]."\">".$row["strSubID"]."</option>";
			}
			else
			{echo "<option value=\"".$row["strSubID"]."\">".$row["strSubID"]."</option>";}
	  ?>
      
      <option value="<?php echo $row['strSubID']; ?>" ><?php echo $row['strSubID']; ?></option>
     <?php }?></select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="normalfnt">Main Category </td>
      <td><select name="cmbMainCat" id="cmbMainCat" style="width:150px" class="txtbox" onChange="LoadSubCat();">
        <?php 
	  	$SQLmainCat = "select * from matmaincategory order by intID ";
		
		$resultmainCat =$db->RunQuery($SQLmainCat);	
					
					echo "<option value =\"".""."\">"."Select One"."</option>";
		while ($rowMain =mysql_fetch_array($resultmainCat))
		{
				if($_POST["cmbMainCat"]==$rowMain["intID"])
					echo "<option selected=\"selected\"value=\"". $rowMain["intID"] ."\">" . $rowMain["strDescription"] ."</option>" ;
				else
					echo "<option value=\"".$rowMain["intID"]."\">".$rowMain["strDescription"]."</option>";
		}
	  ?>
        </select></td>
      <td class="normalfnt">Sub Category</td>
      <td><select name="cmbSubCat" id="cmbSubCat" class="txtbox" style="width:150px">
        <?php 
	  		
	  ?>
        </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="normalfnt">Mat Name Like </td>
      <td colspan="2"><input type="text" name="txtItem" id="txtItem" size="35" value="<?php echo $_POST["txtItem"];?>"></td>
      <td><img src="../images/search.png" width="80" height="24" class="mouseover" onClick="LoadItemData();"> </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
 <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	 <tr>
      <td colspan="5">
      <table width="800" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCFF" id="tblMain">
      <thead>
        <tr>
          <td bgcolor="#804000" class="normaltxtmidb2" height="25">Style</td>
          <td bgcolor="#804000" class="normaltxtmidb2">Buyer PO </td>
          <td bgcolor="#804000" class="normaltxtmidb2">Material Desc</td>
          <td bgcolor="#804000" class="normaltxtmidb2">Qty </td>
          <td bgcolor="#804000" class="normaltxtmidb2">Dispose Qty </td>
          <td bgcolor="#804000" class="normaltxtmidb2">Dispose</td>
          <td bgcolor="#804000" class="normaltxtmidb2">Main Stores</td>
          <td bgcolor="#804000" class="normaltxtmidb2">Sub Stores </td>
          <td bgcolor="#804000" class="normaltxtmidb2">Location</td>
          <td bgcolor="#804000" class="normaltxtmidb2" height="25">BIN</td>
          <td bgcolor="#804000" class="normaltxtmidb2" height="25">Color</td>
          <td bgcolor="#804000" class="normaltxtmidb2" height="25">Size</td>
          <td bgcolor="#804000" class="normaltxtmidb2" height="25">Unit</td>
        </tr>
      </thead>
      <tbody>
        <?php 
		/*$StyleNo 			= $_POST["cmbStyle"];
$SCNo 				= $_POST["cmbSC"];
$AgeFrom			= $_POST["txtAgeFrom"];
$AgeTo 				= $_POST["txtAgeTo"];
$DateFrom 			= $_POST["txtValidFrom"];
$DateTo 			= $_POST["txtValidTo"];
$StoreID			= $_POST["cmbStore"];
$mainCat 			= $_POST["cmbMainCat"];
$subCat				= $_POST["cmbSubCat"];
$matName 			= $_POST["txtItem"];*/

		
			
			$SQL = "select * from(SELECT
			Sum(st.dblQty) AS AvQty,
			st.strMainStoresID,
			st.strSubStores,
			st.strLocation,
			st.strBin,
			st.intStyleId,
			st.strBuyerPoNo,
			st.intMatDetailId,
			st.strColor,
			st.strSize,
			st.strUnit,
			mt.strItemDescription,
			mainstores.strName,
			substores.strSubStoresName,
			storeslocations.strLocName,
			storesbins.strBinName
			FROM
			stocktransactions AS st
			Inner Join matitemlist AS mt ON st.intMatDetailId = mt.intItemSerial
			Inner Join mainstores ON mainstores.strMainID = st.strMainStoresID
			Inner Join substores ON substores.strSubID = st.strSubStores AND substores.strMainID = st.strMainStoresID
			Inner Join storeslocations ON storeslocations.strLocID = st.strLocation AND storeslocations.strMainID = st.strMainStoresID AND storeslocations.strSubID = st.strSubStores
			Inner Join storesbins ON storesbins.strMainID = st.strMainStoresID AND storesbins.strSubID = st.strSubStores AND storesbins.strLocID = st.strLocation AND storesbins.strBinID = st.strBin
			where ";
								
			if($StyleNo != "")
			{
				$SQL .= " st.intStyleId='$StyleNo'";
			}
			if($StoreID != "")
			{
				$SQL .= "and st.strMainStoresID='$StoreID' and  mainstores.intStatus = 1  ";	
			}
			if($mainCat != "")
			{
				$SQL .= " and mt.intMainCatID = '$mainCat' ";
			}
			if($subCat != "")
			{
				$SQL .= "and mt.intSubCatID = '$subCat' ";
			}
			if($subStores != "")
			{
				$SQL .= "and st.strSubStores = '$subStores' ";
			}
				$SQL .= "group by st.strMainStoresID,st.strSubStores,st.strLocation,st.strBin,st.intStyleId,st.strBuyerPoNo,st.intMatDetailId,
			st.strColor,st.strSize,st.strUnit
			) as subTable where AvQty>0";
					
					//echo $SQL;
					$result= $db->RunQuery($SQL);
	while($row =@mysql_fetch_array($result))
	{
		?>
        <tr>
          <td bgcolor="#FFFFFF" class="normalfnt" id="<?php echo $row["intStyleId"];?>"><?php echo getStyleName($row["intStyleId"]); ?></td>
          <td bgcolor="#FFFFFF" class="normalfnt" id="<?php  $BuyerPO = $row["strBuyerPoNo"];
		  if($row["strBuyerPoNo"] != "#Main Ratio#")
		  	$BuyerPO = getBuerPOName($row["intStyleId"],$row["strBuyerPoNo"]);
			
		   echo $row["strBuyerPoNo"]; ?>"><?php  echo $BuyerPO;?>  </td>
          <td bgcolor="#FFFFFF" class="normalfnt" id=" <?php echo $row["intMatDetailId"]; ?> "> <?php echo $row["strItemDescription"]; ?> </td>
          <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["AvQty"]; ?></td>
          <td bgcolor="#FFFFFF" class="normalfnt">
          	<input type="text" name="txtdisposeQty" id="txtdisposeQty" class="txtboxRightAllign" size="10" onKeyPress="return CheckforValidDecimal(this.value,4,event);" onKeyUp="setBalance(this);" />
          </td>
          <td bgcolor="#FFFFFF" class="normalfnt"><input type="checkbox" name="chkDispose" id="chkDispose"></td>
          <td bgcolor="#FFFFFF" class="normalfntRite" id="<?php echo $row["strMainStoresID"]; ?>"><?php echo $row["strName"]; ?></td>
          <td bgcolor="#FFFFFF" class="normalfntRite" id="<?php echo $row["strSubStores"]; ?>"><?php echo $row["strSubStoresName"]; ?></td>
          <td bgcolor="#FFFFFF" class="normalfntRite" id="<?php echo $row["strLocation"]; ?>"><?php echo $row["strLocName"]; ?></td>
          <td bgcolor="#FFFFFF" class="normalfnt" id="<?php echo $row["strBin"]; ?>"><?php echo $row["strBinName"]; ?></td>
          <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["strColor"]; ?></td>
          <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["strSize"]; ?></td>
          <td bgcolor="#FFFFFF" class="normalfnt"><?php echo $row["strUnit"]; ?></td>
        </tr>
        <?php 
	}
		?>
        </tbody>
      </table></td>
    </tr>
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
    <tr>
      <td colspan="5"><table width="800" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#FFD5AA">
          <td width="50%"><img src="../images/save.png" width="84" height="24" align="right" class="mouseover" onClick="saveGrid();"></td>
          <td width="50%">&nbsp;</td>
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
		$SQLS = " select strStyle from orders where intStyleId='$StyleID'";
		 global $db;
			$resultS=$db->RunQuery($SQLS);
	$rowS=mysql_fetch_array($resultS);
	return $rowS["strStyle"];
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
  ?>
</form>
</body>
</html>
