<?php
session_start();
$backwardseperator = "../../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | General GRN</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../../javascript/calendar/theme.css" />
<script src="../../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../../javascript/script.js" type="text/javascript"></script>
<script src="genjava.js" type="text/javascript"></script>
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
	echo "'".$_GET["GRNNo"] ; echo "'," ; echo $_GET["intYear"] ; echo "," ; echo $_GET["intStatus"];
}
else
	echo "0,0,99";
?> );">
<!--loadComonbin();-->
<?php
	include "../../../Connector.php";	
	//$FactoryID				= $_SESSION["FactoryID"];
	
					$CommonStock_active=0;
					$SQL = " Select strValue from settings where strKey='CommonStockActivate'";
					$result = $db->RunQuery($SQL);
					while($row = mysql_fetch_array($result))
					{
						$CommonStock_active = $row["strValue"];
						break;
					}
?>
<form name="frmbom" id="frmbom" >
<tr>
	<td><?php include '../../../Header.php'; ?></td>
</tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">
  <tr>
    <td height="25" colspan="2" class="mainHeading">General GRN</td>
  </tr>
   <tr>
     <td colspan="2" ><table width="100%" border="0" cellspacing="2" cellpadding="0" class="bcgl1">
       <tr>
         <td><table width="100%" border="0" cellpadding="0" cellspacing="0" >
           <tr>
             <td width="10%" height="24" class="normalfnt">Supplier Origin</td>
             <td width="9%" class="normalfnt"><select name="cbosuporigin" onchange="GetSuppliers()" class="txtbox" id="cbosuporigin" style="width:80px">
                <?php 
			 $SQL="SELECT intOriginNo,strOriginType FROM itempurchasetype WHERE intStatus=1;";
			 $result = $db->RunQuery($SQL);
			echo "<option value=\"". "" ."\">" . "" ."</option>" ;
			 while($row = mysql_fetch_array($result))
				{
					 echo "<option value=\"". $row["intOriginNo"] ."\">" . $row["strOriginType"] ."</option>" ;
				}
			 ?>
             </select></td>
             <td width="5%" class="normalfnt">Supplier</td>
             <td width="13%" class="normalfnt"><select name="cbosuplier"  class="txtbox" id="cbosuplier" style="width:120px">
                 <?php
				$SQL = " SELECT * FROM suppliers  ORDER BY strTitle;";
		
				$result = $db->RunQuery($SQL);
		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
				}
			?>
             </select></td>
             <td width="7%" class="normalfnt">PO No Like</td>
             <td width="8%" class="normalfnt"><input name="txtpino" type="text" class="txtbox" id="txtpino" size="10" /></td>
             <td width="3%" class="normalfnt" style="text-align:center"><input type="checkbox" name="chkpodate" id="chkpodate" value="true" onclick="dateDisable(this);" /></td>
             <td width="6%" class="normalfnt">PO date From</td>
             <td width="14%" class="normalfnt"><input name="fromDate" type="text" class="txtbox" id="fromDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled"/>
                 <input name="reset" type="reset"  class="txtbox" style="visibility:hidden;width:2px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
             <td width="2%" class="normalfnt">To</td>
             <td width="14%" class="normalfnt"><input name="toDate" type="text" class="txtbox" id="toDate" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" disabled="disabled"/>
                 <input name="reset" type="reset"  class="txtbox" style="visibility:hidden;;width:2px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
             <td width="9%" class="normalfnt"><img src="../../../images/search.png" alt="search" width="80" height="24" onclick="LoadPo()"/></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="bcgl1" >
      <tr>
        <td><table width="100%" border="0"  cellpadding="0" >
          <tr>
            <td width="14%" class="normalfnt">GRN No</td>
            <td width="41%" class="normalfnt"><input name="txtgrnno" type="text" class="txtbox" id="txtgrnno" style="width:100px" onfocus="this.blur();" /></td>
            <td width="13%" class="normalfnt">Date</td>
            <td width="32%" class="normalfnt"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="40%" class="normalfnt"><input name="grnDate" type="text" class="txtbox" id="grnDate" value="<?php echo date("Y-m-d"); ?>" size="15" onfocus="this.blur();"/></td>
                  <td width="28%">GRN Value</td>
                  <td width="32%"><input name="txtGrnValue" type="text" style="text-align:right" class="txtbox" id="txtGrnValue" size="15" onfocus="this.blur()" /></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td class="normalfnt">PO No</td>
            <td class="normalfnt"><select name="txtpono" class="txtbox" id="txtpono" style="width:302px" onchange="ShowItems();removePoItems();">
                <?php
				$SQL = 	"select * from (SELECT
						generalpurchaseorderheader.intGenPONo,
						suppliers.strTitle,
						generalpurchaseorderheader.intYear,
						concat(generalpurchaseorderheader.intYear ,'/' ,generalpurchaseorderheader.intGenPONo ,' -- ' ,strTitle) AS ListF,
						concat(generalpurchaseorderheader.intYear,'/',generalpurchaseorderheader.intGenPONo) AS BulkPoNo,
						generalpurchaseorderheader.strPINO,
						generalpurchaseorderheader.intStatus,
						Sum(generalpurchaseorderdetails.dblPending) as TotalQty
						FROM
						generalpurchaseorderheader
						Inner Join suppliers ON suppliers.strSupplierID = generalpurchaseorderheader.intSupplierID
						Inner Join generalpurchaseorderdetails ON 
						generalpurchaseorderdetails.intGenPONo = generalpurchaseorderheader.intGenPONo 
						AND generalpurchaseorderdetails.intYear = generalpurchaseorderheader.intYear
						
						WHERE
						generalpurchaseorderheader.intStatus =  '1' AND
						generalpurchaseorderheader.intDeliverTo =  ".$_SESSION["FactoryID"]."
						
					    GROUP BY
						generalpurchaseorderheader.intGenPONo,
						suppliers.strTitle,
						generalpurchaseorderheader.intYear,
						generalpurchaseorderheader.strPINO,
						generalpurchaseorderheader.intStatus
						ORDER BY  generalpurchaseorderheader.intYear,generalpurchaseorderheader.intGenPONo) as bpoheader 	";

						if($CommonStock_active==0)
							$SQL .=" where TotalQty>0";	
				
				$result = $db->RunQuery($SQL);
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["BulkPoNo"] ."\">" . trim($row["ListF"]) ."</option>" ;
				}
			?>
            </select></td>
            <td class="normalfnt">Invoice No<span class="compulsoryRed">*</span></td>
            <td class="normalfnt"><input name="txtinvoiceno" type="text" class="txtbox" id="txtinvoiceno" size="50" maxlength="30" /></td>
          </tr>
          <tr>
            <td class="normalfnt">Suplier Advice No<span class="compulsoryRed">*</span></td>
            <td class="normalfnt"><input name="txtsupadviceno" type="text" class="txtbox" id="txtsupadviceno" style="width:300px" maxlength="30"/></td>
            <td class="normalfnt">Advice Date</td>
            <td class="normalfnt"><input name="adviceDate" type="text" class="txtbox" id="adviceDate" value="<?php echo date('Y-m-d'); ?>" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;width:2px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></td>
          </tr>
          <tr>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="34%" class="normalfnt"></td>
                  <td width="15%">&nbsp;</td>
                  <td width="51%">&nbsp;</td>
                </tr>
            </table></td>
            <td class="normalfnt">&nbsp;</td>
            <td class="normalfnt">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr class="mainHeading2">
        <td width="89%" >&nbsp;</td>
        <td width="11%" ><img src="../../../images/add-new.png" alt="add new" width="109" height="18" onclick="ShowItems()" /></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:280px; width:950px;">
          <table width="1500" cellpadding="0" cellspacing="1" id="tblMainGrn" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <th width="1%" height="25" >Del</th>
              <th width="6%" >Material</th>
              <th width="10%">Category</th>
              <th width="14%" >Description</th>
              <th width="4%" >Unit</th>
              <th width="5%" >Rate</th>
              <th width="4%" >Pending Qty</th>
              <th width="4%" >Received Qty</th>
			  <th width="5%" >Excess</th>
              <th width="5%" >Value</th>
              <th width="6%" >Mat Details ID</th>
			  <th width="4%" >Year</th>
              <th width="5%" >PO No </th>
              </tr>
          </table>
        </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="12%" align="center"> 
        <img src="../../../images/new.png"  id="butNew" alt="new" width="96" height="24" onclick="newPage(); "/>
        <img src="../../../images/save.png" id="butSave" alt="save" width="84" height="24" onclick="save(0);" />
        <img src="../../../images/conform.png" id="butConform" alt="conform" width="115" height="24" onclick="conform();" />
        <img src="../../../images/cancel.jpg" id="butCancel" alt="Cancel" width="104" height="24" onclick ="cancel();"/>
        <img src="../../../images/report.png" id="butReport" width="108" height="24" onclick="grnReport();"/>
        <a href="../../../main.php"><img src="../../../images/close.png" width="97" height="24" border="0"/></a>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>


