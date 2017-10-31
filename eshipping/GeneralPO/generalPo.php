<?php
session_start();
$backwardseperator = "../../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>General PO</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {color: #FFFFFF}
-->
</style>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<script src="generalPo-java.js" type="text/javascript"></script>
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
<!--<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>-->
</head>

<body onload="loadBulkPoForm(
<?php 	
$id = $_GET["id"];
if($id!=0)
{
	$bpono = $_GET["BulkPoNo"] ;
	echo "'$bpono'" ; echo "," ; echo $_GET["intYear"] ; echo "," ; echo $_GET["intStatus"];
}
else
	echo "0,0,99";
?> );">

<form name="frmbom" id="frmbom">
<?php
		  include "../../Connector.php"; 
?>
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
    <tr>
    <td height="12" colspan="2" bgcolor="#316895" class="TitleN2white">General PO</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="50%" valign="top"><table width="100%" border="0" class="bcgl1">
          <tr>
            <td width="12%" class="normalfnt">PO No </td>
            <td width="30%"><input type="text" name="txtBulkPoNo" class="txtbox" id="txtBulkPoNo" style="width:133px" onfocus="this.blur();"></td>
            <!--<td width="20%" class="tablezRED" ><span class="normalfnt">Find PO</span></td>
            <td width="44%" class="tablezRED"><input name="txtFindPo" type="text" class="txtbox" id="txtFindPo" size="18" /></td>
            <td width="32%" class="tablezRED"><img src="../../images/search.png" id="butSearch" name="butSearch" alt="search" width="80" height="24" /></td>-->
			<td width="56%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
                        <tr class="tablezRED">
                          <td width="24%" class="normalfnt"><span class="normalfnt">Find PO</span></td>
                          <td width="44%"><input name="txtFindPo" type="text" class="txtbox" id="txtFindPo" size="18" /></td>
                          <td width="32%"><img src="../../images/search.png" id="butSearch" name="butSearch" alt="search" width="80" height="24" /></td>
             </tr>
			  </table></td>
          </tr>
          <tr>
            <td class="normalfnt">Currency</td>
            <td colspan="4"><select name="cboCurrency" class="txtbox" id="cboCurrency" style="width:133px" >
              <?php
			 
				$SQL = "SELECT strCurrency FROM currencytypes c where intStatus='1';";	
				$result = $db->RunQuery($SQL);		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
			/*	if($row["strCurrency"]=="USD")
				echo "<option value=\"". $row["strCurrency"] ."\" selected=\"selected\">" . $row["strCurrency"] ."</option>";
				else*/
				echo "<option value=\"". $row["strCurrency"] ."\">" . $row["strCurrency"] ."</option>" ;
				}
	
			?>
            </select></td>
            </tr>
          <tr>
            <td class="normalfnt">Supplier</td>
 <td colspan="4"><select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:328px" onchange="setCurrency(this);"> <option value="0" selected="selected" >Select One</option>
                          <?php
	
	$SQL = "SELECT strTitle,strSupplierID FROM suppliers s where intStatus='1' order by strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
	}
	
	?>
            </select></td>
            </tr>

        </table></td>
        <td width="50%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="100%" border="0" class="bcgl1">
              
              <tr>
                <td width="14%" class="normalfnt">Deliver To</td>
                <td width="30%"><select name="cboDeliverto" class="txtbox" id="cboDeliverto" style="width:150px">
				<?php 
				$SQL = "SELECT strName,intCompanyID FROM companies where intStatus='1';";	
				$result = $db->RunQuery($SQL);		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
				echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
				}
				
				?>
                </select></td>
                <td width="16%"  class="normalfnt">PO Amount</td>
                <td width="40%"><input name="txtPoAmount" type="text" class="txtbox" id="txtPoAmount" size="15" onfocus="this.blur();"/></td>
              </tr>
              <tr>
                <td class="normalfnt">Invoice To</td>
                <td><select name="cboInvoiceTo" class="txtbox" id="cboInvoiceTo" style="width:150px">
								<?php 
				$SQL = "SELECT strName,intCompanyID FROM companies where intStatus='1';";	
				$result = $db->RunQuery($SQL);		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
				echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
				}
				
				?>

                </select></td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td class="normalfnt">Instructions</td>
                <td colspan="3"><textarea name="txtIntroduction" cols="66" rows="1" class="txtbox" id="txtIntroduction"></textarea></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0">
      <tr>
	  <td width="47%" valign="top"><table width="100%" border="0" class="bcgl1">
      <tr>
        <td width="17%" class="normalfnt">Pay Mode</td>
        <td width="32%"><select name="cboPayMode" class="txtbox" id="cboPayMode" style="width:120px">
          <option value="0" selected="selected">Select One</option>
          <?php
	
	$SQL = "SELECT strPayModeId,strDescription FROM popaymentmode p where intstatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
        </select></td>
        <td width="16%"><span class="normalfnt">Pay Terms</span></td>
        <td width="35%"><select name="cboPayTerms" class="txtbox" id="cboPayTerms" style="width:120px">
          <option value="0" selected="selected">Select One</option>
          <?php
	
	$SQL = "SELECT strPayTermId,strDescription FROM popaymentterms p where intStatus='1';";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
        </select></td>
		
		</tr></table></td>
		
		<td width="53%"><table width="100%"  border="0" class="bcgl1">
      	<tr>
	  
        <td width="15%" class="normalfnt">Date</td>
        <td width="30%"><input name="podate" type="text" class="txtbox" id="podate" size="15" value=<?php echo date("Y-m-d"); ?> onfocus="this.blur();"/></td>
        <td width="5%" class="normalfnt"><input type="checkbox" name="checkbox" id="checkbox" onclick="dateDisable(this);" /></td>
        <td width="13%" class="normalfnt">Delivery</td>
        <td width="37%"><input name="deliverydateDD" type="text" class="txtbox" id="deliverydateDD" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  disabled="disabled"  onclick="return showCalendar(this.id, '%d/%m/%Y');" /><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></select></td>
		 
		  </tr></table></td>
		  
      </tr>
     <!-- <tr>
        <td colspan="4">&nbsp;</td>
        <td colspan="5" class="normalfnt"></td>
        </tr>-->
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="88%" height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="center">General PO's</div></td>
        <td width="12%" bgcolor="#9BBFDD" class="normalfnth2"><img src="../../images/add-new.png" alt="add new" id="cmdAddNew" width="109" height="18" onclick="ShowItems()" /></td>
      </tr>
      <tr>
        <td colspan="2"><div id="divcons2" style="overflow:scroll; height:230px; width:950px;">
          <table width="1200" cellpadding="2" cellspacing="0" id="tblMain">
            <tr>
              <td width="3%"  bgcolor="#498CC2" class="normaltxtmidb2">Del</td>
              <td width="24%" bgcolor="#498CC2" class="normaltxtmidb2">Material</td>
              <td width="24%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Description</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Unit</td>
              <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">Qty</td>
			  <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Unit Price </td>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Value</td>
              <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">MatDetail ID </td>
              <td width="5%" bgcolor="#498CC2" class="normaltxtmidb2">Fixed</td>
              <td width="6%" bgcolor="#498CC2" class="normaltxtmidb2">GL</td>
              <td width="7%" bgcolor="#498CC2" class="normaltxtmidb2">Budgeted</td>
			  <td width="9%" bgcolor="#498CC2" class="normaltxtmidb2">Utilized</td>
			  <td width="11%" bgcolor="#498CC2" class="normaltxtmidb2">stock</td>
              </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#D6E7F5"><table width="100%" border="0">
      <tr>
        <td width="1%" height="29">&nbsp;</td>
        <td width="11%"><img src="../../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="newPage();"/></td>
        <td width="9%"><img src="../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="save();" /></td>
        <td width="13%"><img src="../../images/conform.png" alt="conform" name="butConform" width="115" height="24" class="mouseover" id="butConform" onclick="conform();" /></td>
        <td width="11%"><img src="../../images/cancel.jpg" alt="Cancel" name="butCancel" width="104" height="24" class="mouseover" id="butCancel" onclick ="cancel();"/></td>
        <td width="12%"><span class="normalfnt2"><span class="normalfnt"><img src="../../images/copyPO.png" alt="copy PO" width="108" height="24" onclick="loadPO();" /></span></span></td>
        <td width="10%"><img src="../../images/report.png" name="butReport" width="108" height="24" class="mouseover" id="butReport"  onclick="BulkPoReport();"/></td>
        <td width="11%"><img src="../../images/btn-email.png" name="butMail"  id="butMail"  alt="Email" width="91" height="24" class="mouseover" /></td>
        <td width="11%" class="normalfnt2">&nbsp;</td>
        <td width="11%"><label><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" /></a></label></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>

<div style="left:345px; top:360px; z-index:10; position:absolute; width: 240px; visibility:hidden;" id="copyPOMain"><table width="221" height="58" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          <tr>
            <td width="69">&nbsp;</td>
            <td width="115">&nbsp;</td>
			<td width="1" class="normalfntRiteTAB style1" bgcolor="#FF0000" ><a href="#" onclick="closeCopyPo();">X</a></td>
          </tr>
          <tr>
            <td><div align="center">PO No </div></td>
            <td><select name="select" class="txtbox" id="cboPONo" style="width:100px" onchange="copyPO();">
			<option value="Select One" selected="selected">Select One</option>
            </select>            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		
		
</div>



</body>
</html>
