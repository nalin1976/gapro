<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
	
	$cboBuyer 			= $_POST["cboBuyer"];
	$cboStyleNo			= $_POST["cboStyleNo"];
	$cboOrderNo			= $_POST["cboOrderNo"];
	$cboSCNo 			= $_POST["cboSCNo"];
	$cboFactory			= $_POST["cboFactory"];
	$cboMerchandiser	= $_POST["cboMerchandiser"];
	$chkDate			= $_POST["chkDate"];
	$DeliveryDateFrom 	= $_POST["DeliveryDateFrom"];
	$DeliveryDateTO 	= $_POST["DeliveryDateTO"];
	
	if(!isset($_POST["cboBuyer"])&&$_POST["cboBuyer"]=="" )
	{
		
		$DeliveryDateFrom	= date("d/m/Y");
		$DeliveryDateTO		= date("d/m/Y");
		$chkDate 	= "on";
		
	}	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gapro - Profitability</title>
<script type="text/javascript" src="profitability.js"></script>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../css/tableGrib.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/tablegrid.js"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../java.js" type="text/javascript"></script>

<style type="text/css">

.mainScreen{
	width:1050px; height:auto;
	border:1px solid;
	border-bottom-color:#fcb334;
	border-top-color:#fcb334;
	border-left-color:#fcb334;
	border-right-color:#fcb334;
	background-color:#FFFFFF;
	padding-right:15px;
	padding-top:10px;
	padding-left:30px;
	padding-right:30px;
	margin-top:20px;
	-moz-border-radius-bottomright:5px;
	-moz-border-radius-bottomleft:5px;
	-moz-border-radius-topright:10px;
	-moz-border-radius-topleft:10px;
	border-bottom:13px solid #fcb334;
	border-top:30px solid #fcb334;
}
</style>
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
<form name="profitabilityListing" id="profitabilityListing" action="profitability.php" method="post">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../Header.php'; ?></td>
	</tr> 
</table>
<div>
	<div align="center">
		<div class="mainScreen">
		<div class="trans_text">Profitability<span class="volu"></span></div>
			<table align="center" width="99%" border="0" cellspacing="2" class="bcgl1" >
              <tr>
                <td class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <td width="12%">Buyer</td>
                    <td width="28%"><select name="cboBuyer" id="cboBuyer" style="width:255px;">
                      <?php
					$SQL = "select intBuyerID,strName
							from buyers
							where intStatus =1 ";
					$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						if($row["intBuyerID"]==$cboBuyer)
						echo "<option value=\"". $row["intBuyerID"] ."\" selected=\"selected\" >" . $row["strName"] ."</option>";
						else
						echo "<option value=\"". $row["intBuyerID"] ."\" >" . $row["strName"] ."</option>";
					}		  
					?>
                    </select></td>
                    <td width="8%">Style No</td>
                    <td width="13%"><select name="cboStyleNo" id="cboStyleNo" style="width:110px;" onchange="LoadOrderNo(this.value)">
                      <?php
					$SQL = "select distinct strStyle
							from orders
							where intStatus <> 'a'
							order by strStyle";
					$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						if($row["strStyle"]==$cboStyleNo)
						echo "<option value=\"". $row["strStyle"] ."\" selected=\"selected\" >" . $row["strStyle"] ."</option>";
						else
						echo "<option value=\"". $row["strStyle"] ."\">" . $row["strStyle"] ."</option>";
						
					}		
					?>
                    </select></td>
                    <td width="8%">Order No</td>
                    <td width="13%"><select name="cboOrderNo" id="cboOrderNo" style="width:110px;">
                      <?php
					$SQL ="select strOrderNo,intStyleId
							from orders
							where intStatus <> 'a' ";
							
					if($cboStyleNo!="")
					{
						$SQL .=" AND strStyle='$cboStyleNo'";
					}
						$SQL .=" order by strOrderNo";
					$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						if($row["intStyleId"]==$cboOrderNo)
						echo "<option value=\"". $row["intStyleId"] ."\" selected=\"selected\">" .$row["strOrderNo"]."</option>";
						else
						echo "<option value=\"". $row["intStyleId"] ."\" >" .$row["strOrderNo"]."</option>";
					}	
					?>
                    </select></td>
                    <td width="6%">SC No</td>
                    <td width="12%"><select name="cboSCNo" id="cboSCNo" style="width:110px;">
                      <?php
					$SQL = "select SP.intStyleId,SP.intSRNO
							from specification SP
							INNER JOIN orders O ON O.intStyleId=SP.intStyleId
							where O.intStatus <> 'a'";
					if($cboStyleNo!="")
					{
						$SQL.=" and O.strStyle='$cboStyleNo'";
					}
						$SQL.=" order by SP.intStyleId desc ";	
					$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						if($row["intStyleId"]==$cboSCNo)
						echo "<option value=\"". $row["intStyleId"] ."\" selected=\"selected\">" . $row["intSRNO"] ."</option>" ;
						else
						echo "<option value=\"". $row["intStyleId"] ."\" >" . $row["intSRNO"] ."</option>" ;
					}		
					?>
                    </select></td>
                  </tr>
                  <tr>
                    <td height="20">Delivery Date From</td>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="38%"><input name="DeliveryDateFrom" type="text" class="txtbox" id="DeliveryDateFrom" size="10" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DeliveryDateFrom=="" ? "":$DeliveryDateFrom);?>" /><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                        <td width="13%">&nbsp;To</td>
                        <td width="35%"><input name="DeliveryDateTO" type="text" class="txtbox" id="DeliveryDateTO" size="10"  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" value="<?php echo ($DeliveryDateTO=="" ? "":$DeliveryDateTO);?>"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;;width:1px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
                        <td width="14%"><input type="checkbox" name="chkDate" id="chkDate" <?php echo($chkDate=="on" ? "checked=\"checked\"":"");?>/></td>
                      </tr>
                    </table></td>
                    <td>Profitability</td>
                    <td><input name="text2" type="text" class="txtbox" style="width:50px;" />&nbsp;
                      <input name="text2" type="text" class="txtbox" style="width:45px;" /></td>
                    <td>Merchandiser</td>
                    <td><select name="cboMerchandiser" id="cboMerchandiser" style="width:110px;">
                      <?php
					$SQL = "SELECT useraccounts.Name, useraccounts.intUserID FROM useraccounts INNER JOIN userpermission ON useraccounts.intUserID = userpermission.intUserID INNER JOIN role ON userpermission.RoleID = role.RoleID WHERE role.RoleName = 'Merchandising' order by useraccounts.Name";
					$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						if($row["intUserID"]==$cboMerchandiser)
						echo "<option value=\"". $row["intUserID"] ."\" selected=\"selected\">" . $row["Name"] ."</option>" ;
						else
						echo "<option value=\"". $row["intUserID"] ."\" >" . $row["Name"] ."</option>" ;
					}		
					?>
                    </select></td>
                    <td>Factroy</td>
                    <td><select name="cboFactory" id="cboFactory" style="width:110px;">
                      <?php
					$SQL = "select intCompanyID,strName
							from companies
							order by strName";
					$result = $db->RunQuery($SQL);
						echo "<option value=\"". "" ."\">" . "" ."</option>" ;
					while($row = mysql_fetch_array($result))
					{
						if($row["intCompanyID"]==$cboFactory)
						echo "<option value=\"". $row["intCompanyID"] ."\" selected=\"selected\">" . $row["strName"] ."</option>";
						else
						echo "<option value=\"". $row["intCompanyID"] ."\" >" . $row["strName"] ."</option>";
					}		
					?>
                    </select></td>
                  </tr>
				  <tr>
				   <td colspan="8"><table width="100%" border="0" align="center" cellspacing="2">
		  	<tr>	
				<td align="right" ><img src="../images/search.png" alt="search" onclick="LoadProfitabilityDetails();" />
				</td>
			</tr>
			
		  </table></td>
			      </tr>
                </table></td>
              </tr>
            </table>
		    <div align="center" style="overflow:scroll; margin-left:-5px; margin-top:15px; border:1px solid #cccccc; height:300px; width:1050px;">
              <div style="background:#E1E1E1; width:3000px; color:#999999; padding-left:10px; text-align:center; font-size:12px;">Profitability Details</div>
		      <table style="width:3000px" class="transGrid" border="1" cellspacing="1">
                <thead>
                  <tr>
                    <td colspan="31" >Profitability Details</td>
                  </tr>
                  <tr>
                    <td>Buyer</td>
                    <td>Style No</td>
                    <td>Order No</td>
                    <td>SC No</td>
                    <td>Order Date</td>
                    <td>Qty</td>
                    <td>EST. Fabric Cost</td>
                    <td>ACT. Fabric Cost</td>
                    <td>EST. Trim Cost</td>
                    <td>ACT. Trim Cost</td>
                    <td>EST. Packing Mat. Cost</td>
                    <td>ACT. Packing Mat. Cost</td>
                    <td>EST. Services Cost</td>
                    <td>ACT. Services Cost</td>
                    <td>EST. Other Cost</td>
                    <td>ACT. Other Cost</td>
                    <td>EST. Wash Cost</td>
                    <td>ACT. Wash Cost</td>
                    <td>Finance</td>
                    <td>CM</td>
                    <td>Direct Cost</td>
                    <td>Total Cost</td>
                    <td>FOB</td>
                    <td>Profit</td>
                    <td>Shipped qty</td>
                    <td>Profit</td>
                    <td>Non shipped Qty</td>
                    <td>Non Shipped Cost</td>
                    <td>Actual Profit</td>
                    <td>Merchandiser</td>
                    <td>Factroy</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
				$SQL_grid = "select B.buyerCode,O.intStyleId,SP.intSRNO,O.strOrderNo,date(O.dtmOrderDate) as dtmOrderDate ,O.intQty,O.strStyle,O.reaFOB,O.dblFacProfit,UA.Name as Merchandiser,C.strName
							from orders O
							inner join buyers B on B.intBuyerID=O.intBuyerID 
							INNER JOIN specification SP ON O.intStyleId=SP.intStyleId
							INNER JOIN useraccounts UA ON UA.intUserID = O.intUserID 
							INNER JOIN companies C ON C.intCompanyID = O.intCompanyID 
							where O.intStatus <> 'a' ";
				if($cboBuyer!="")
				{
				$SQL_grid .= " AND B.intBuyerID ='$cboBuyer' ";
				}
				if($cboStyleNo!="")
				{
				$SQL_grid .= " AND O.intStyleId ='$cboStyleNo' ";
				}
				if($cboOrderNo!="")
				{
				$SQL_grid .= " AND O.intStyleId ='$cboOrderNo' ";
				}
				if($cboSCNo!="")
				{
				$SQL_grid .= " AND SP.intStyleId ='$cboSCNo' ";
				}
				if($cboFactory!="")
				{
				$SQL_grid .= " AND O.intCompanyID ='$cboFactory' ";
				}
				if($cboMerchandiser!="")
				{
				$SQL_grid .= " AND O.intUserID ='$cboMerchandiser' ";
				}
				if ($chkDate=="on")
				{
					if ($DeliveryDateFrom!="" && $DeliveryDateTO!="")
					{
						$DateFromArray		= explode('/',$DeliveryDateFrom);
						$formatedFromDate	= $DateFromArray[2].'-'.$DateFromArray[1].'-'.$DateFromArray[0];
						$DateTOArray		= explode('/',$DeliveryDateTO);
						$formatedToDate		= $DateTOArray[2].'-'.$DateTOArray[1].'-'.$DateTOArray[0];
						$SQL_grid .=" AND date(dtmOrderDate) between '$formatedFromDate' and '$formatedToDate' ";		
					}
					
				}
				$SQL_grid .=" order by O.strOrderNo ";
							
				$result=$db->RunQuery($SQL_grid);
				while($row=mysql_fetch_array($result))
				{
					$values=GetValues($row["intStyleId"]);
				?>
                  <tr>
                    <td nowrap="nowrap" style="text-align:left"><?php echo $row["buyerCode"]; ?></td>
                    <td nowrap="nowrap" style="text-align:left"><?php echo $row["strStyle"]; ?></td>
                    <td nowrap="nowrap" style="text-align:left"><?php echo $row["strOrderNo"]; ?></td>
                    <td nowrap="nowrap" style="text-align:left"><?php echo $row["intSRNO"]; ?></td>
                    <td nowrap="nowrap" style="text-align:left"><?php echo $row["dtmOrderDate"]; ?></td>
                    <td nowrap="nowrap" style="text-align:right"><?php echo number_format($row["intQty"],0); ?></td>
                    <td nowrap="nowrap" style="text-align:right"><?php echo number_format($values[0],4);?></td>
                    <td nowrap="nowrap" >****</td>
                    <td nowrap="nowrap" style="text-align:right"><?php echo number_format($values[1],4);?></td>
                    <td nowrap="nowrap" >****</td>
                    <td nowrap="nowrap" style="text-align:right"><?php echo number_format($values[2],4);?></td>
                    <td nowrap="nowrap" >****</td>
                    <td nowrap="nowrap" style="text-align:right"><?php echo number_format($values[3],4);?></td>
                    <td nowrap="nowrap" >****</td>
                    <td nowrap="nowrap" style="text-align:right"><?php echo number_format($values[4],4);?></td>
                    <td nowrap="nowrap" >****</td>
                    <td nowrap="nowrap" style="text-align:right"><?php echo number_format($values[5],4);?></td>
                    <td>****</td>
                    <td>****</td>
                    <td>****</td>
                    <td>****</td>
                    <td>****</td>
                    <td nowrap="nowrap" style="text-align:right"><?php echo number_format($row["reaFOB"],4); ?></td>
                    <td nowrap="nowrap" style="text-align:right"><?php echo number_format($row["dblFacProfit"],4); ?></td>
                    <td>****</td>
                    <td>****</td>
                    <td>****</td>
                    <td>****</td>
                    <td>****</td>
                    <td nowrap="nowrap" style="text-align:left"><?php echo $row["Merchandiser"]; ?></td>
                    <td nowrap="nowrap" style="text-align:left"><?php echo $row["strName"]; ?></td>
                  </tr>
                  <?php
				}
				?>
                </tbody>
              </table>
	      </div>
	       
			
			<table align="center" width="367" border="0">
      			<tr>
					<td width="15%">&nbsp;</td>
					<td width="23%"><img src="../images/save.png" /></td>
					<td width="23%"><img src="../images/delete.png" /></td>
					<td width="23%"><img src="../images/report.png" /></td>
					<td width="26%"><a href="../main.php"><img src="../images/close.png" alt="close" border="0" /></a></td>
					<td width="10%">&nbsp;</td>
      			</tr>
		  </table>
		</div>
	</div>
</div>
</form>
</body>
</html>
<?php
function  GetValues($styleId)
{
global $db;
$array = array();
	$sql="select COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=1),0)as totalFabValue,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=2),0)as totalTrimValue,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=3),0)as totalPackingValue,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=4),0)as totalServiceValue,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=5),0)as totalOtherValue,
	COALESCE((select sum(OD.dblTotalValue) from orderdetails OD inner join matitemlist MIL on MIL.intItemSerial=OD.intMatDetailID where OD.intStyleId='$styleId' and MIL.intMainCatID=6),0)as totalWashValue;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array[0] = $row["totalFabValue"];
		$array[1] = $row["totalTrimValue"];
		$array[2] = $row["totalPackingValue"];
		$array[3] = $row["totalServiceValue"];
		$array[4] = $row["totalOtherValue"];
		$array[5] = $row["totalWashValue"];
	}
	return $array;
}
?>
