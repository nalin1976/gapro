<?php
session_start();
$backwardseperator = "../../";

include "../../Connector.php";
//include "../../HeaderConnector.php";
include "../../permissionProvider.php";

?>
<input type="hidden" id="hnd" value="<?php echo $canIncreaseUnitPriceInGPO; ?>" />
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | General Purchase Order</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
<link rel="stylesheet" type="text/css" href="../../js/jquery-ui-1.8.9.custom.css"/>

<script src="../../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../../javascript/script.js" type="text/javascript"></script>
<!--<script src="../../javascript/jquery.js" type="text/javascript"></script>
<script src="../../javascript/jquery-ui.js" type="text/javascript"></script>-->
<script src="../../js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="../../js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>


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

<style type="text/css" rel="stylesheet">
#tr_sundry{ display:none;}
</style>
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

<form name="frmGenPoMain" id="frmGenPoMain" method="POST" action="">
<?php
	 // include "../../Connector.php"; 
?>
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
<table width="950" border="0" align="center" bgcolor="#FFFFFF" class="tableBorder">

    <tr>
    <td height="25" colspan="2" bgcolor="#316895" class="mainHeading">General Purchase Order</td>
  </tr>
  <tr><td><table width="639" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td width="317"><table width="510" border="0" cellspacing="0" cellpadding="2" class="tableBorder">
        <tr>
          <td width="85" class="normalfnt">Find PO No</td>
          <td width="89"><input type="text" name="txtFindGenPO" id="txtFindGenPO" style="width:80px;" onkeypress="enableEnterSubmitLoadGenPODetails(event)"/></td>
          <td width="90" class="normalfnt">PO Year</td>
          <td width="145"><select name="cbofindGenPOYear" id="cbofindGenPOYear" style="width:100px;" onchange="loadPendingPONoList();">
           <?php
			for ($loop = date("Y") ; $loop >= 2008; $loop --)
			{
				echo "<option value=\"$loop\">$loop</option>";
			}
	?>
          </select></td>
          <td width="79"><img src="../../images/view2.png" width="62" height="21" onclick="viewGenPOdetails();" /></td>
        </tr>
      </table></td>
      <td width="318"></td>
    </tr>
  </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td valign="top" width="430"><table width="100%" border="0" class="tableBorder" height="75" cellspacing="0" cellpadding="1">
          <tr>
            <td width="83" class="normalfnt">PO No </td>
            <td width="82"><input type="text" name="txtBulkPoNo" class="txtbox" id="txtBulkPoNo" style="width:80px;" onfocus="this.blur();" onclick="loadfindPOpopup();" disabled="disabled"></td>
			<td width="113"><select name="cboPOYearBox" id="cboPOYearBox" class="txtbox"  style="width:62px" disabled="disabled">
              
              <?php
			for ($loop = date("Y") ; $loop >= 2008; $loop --)
			{
				echo "<option value=\"$loop\">$loop</option>";
			}
	?>
	
            </select></td>
            <td width="136">&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt">Currency <span class="compulsoryRed">*</span></td>
            <td><select name="cboCurrency" class="txtbox" id="cboCurrency" style="width:82px;"><!-- onchange="convertRates(); loadSuppliers();"-->
              <?php
			 
				$SQL = "SELECT intCurID,strCurrency FROM currencytypes c where intStatus='1' order by strCurrency;";	
				$result = $db->RunQuery($SQL);		
				echo "<option value=\"". "" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{			
					echo "<option value=\"". $row["intCurID"] ."\">" . $row["strCurrency"] ."</option>" ;
				}
	
			?>
            </select></td>
            <td><span class="normalfnt">
              <input name="text" type="text" disabled="disabled" class="txtbox" id="txtExRate" style="width:60px;text-align:right"/>
            </span></td>          
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="normalfnt">Supplier <span class="compulsoryRed">*</span></td>
            <td colspan="2"><select name="cboSupplier" class="txtbox" id="cboSupplier" style="width:310px" onchange="SetDetails(this);" tabindex="1"> <option value="" selected="selected" >Select One</option><!-- convertRates(); -->
                          <?php
	
	$SQL = "SELECT strTitle,strSupplierID, strSupplierCode FROM suppliers s where intApproved='1' order by strTitle;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"]. " - " . $row["strSupplierCode"] ."</option>" ;
	}
	
	?>
            </select></td>
            </tr>
			<tr height="35" id="tr_sundry">
            	<td class="normalfnt">Supplier Name</td>
                <td colspan="3"><textarea id="txtSundryName" name="txtSundryName" rows="1" style="width:300px;" class="txtbox" ></textarea> </td>
            </tr>
        </table></td>
        <td width="520" valign="top"><table width="100%" border="0" class="tableBorder" cellspacing="0" cellpadding="1">
              
              <tr>
                <td width="80" class="normalfnt">Deliver To <span class="compulsoryRed">*</span></td>
                <td width="210"><select name="cboDeliverto" class="txtbox" id="cboDeliverto" style="width:200px" tabindex="2">
				<?php 
				$SQL = "SELECT strName,intCompanyID FROM companies where intStatus='1' order by strName;";	
				$result = $db->RunQuery($SQL);		
				echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
				echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
				}
				
				?>
                </select></td>                               
                <td width="100" class="normalfnt">PO Amount</td>
                <td width="130"><input name="txtPoAmount" type="text" class="txtbox" id="txtPoAmount" style="width:100px" onfocus="this.blur();"/></td>
              </tr>
              <tr>
                <td class="normalfnt">Invoice To <span class="compulsoryRed">*</span></td>
                <td colspan="3"><select name="cboInvoiceTo" class="txtbox" id="cboInvoiceTo" style="width:200px" tabindex="3" >
								<?php 
				$SQL = "SELECT strName,intCompanyID FROM companies where intStatus='1' order by strName;";	
				$result = $db->RunQuery($SQL);		
				echo "<option value=\"". "" ."\">" . "Select One" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
				echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
				}
				
				?>

                </select></td>               
              </tr>
              <tr>
                <td class="normalfnt">Instructions</td>
                <td colspan="3">
				<textarea name="txtIntroduction" style="width:407px;" rows="1" class="txtbox" id="txtIntroduction" tabindex="4" onkeypress="return imposeMaxLength(this,event, 200);" onblur="ControlableKeyAccess(event);" ></textarea></td>              
              </tr>
            </table></td>          
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%"  border="0">
      <tr>
	  <td width="428" valign="top"><table width="100%" border="0" class="tableBorder">
       <tr>
              <td width="104" class="normalfnt">Shipment Mode</td>
              <td width="111"><select name="cboshipment" class="txtbox" id="cboshipment" style="width:100px" ><option value="Null" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strDescription,intShipmentModeId FROM shipmentmode s where intStatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["intShipmentModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
                  </select></td>
              <td width="105" class="normalfnt">Shipment Term</td>
              <td width="110"><select name="cboshipmentTerm" class="txtbox" id="cboshipmentTerm" style="width:100px"><option value="Null" selected="selected">Select One</option>
                          <?php
	
	$SQL = "SELECT strShipmentTerm,strShipmentTermId FROM shipmentterms s where intStatus='1' order by strShipmentTerm;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strShipmentTermId"] ."\">" . $row["strShipmentTerm"] ."</option>" ;
	}
	
	?>
                  </select></td>
            </tr>
      <tr>
        <td width="96" class="normalfnt">Pay Mode <span class="compulsoryRed">*</span></td>
        <td width="115"><select name="cboPayMode" class="txtbox" id="cboPayMode" style="width:100px">
          <option value="" selected="selected">Select One</option>
          <?php
	
	$SQL = "SELECT strPayModeId,strDescription FROM popaymentmode p where intstatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strPayModeId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
        </select></td>
        <td width="109"><span class="normalfnt">Pay Terms <span class="compulsoryRed">*</span></span></td>
        <td width="121"><select name="cboPayTerms" class="txtbox" id="cboPayTerms" style="width:100px">
          <option value="" selected="selected">Select One</option>
          <?php
	
	$SQL = "SELECT strPayTermId,strDescription FROM popaymentterms p where intStatus='1' order by strDescription;";	
	$result = $db->RunQuery($SQL);		
	while($row = mysql_fetch_array($result))
	{
	echo "<option value=\"". $row["strPayTermId"] ."\">" . $row["strDescription"] ."</option>" ;
	}
	
	?>
        </select></td>
		
		</tr></table></td>
		
		<td width="524"><table width="100%"  border="0" class="tableBorder">
      	<tr>
	  
        <td width="80" class="normalfnt">Date</td>
        <td width="204"><input name="podate" type="text" class="txtbox" id="podate" size="15" value=<?php echo date("Y-m-d"); ?>  onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%Y-%m-%d');"/><input name="reseta" type="text"  class="txtbox" style="visibility:hidden;width:10px"   onclick="return showCalendar(this.id, '%Y-%m-%d');" value="" /></td>
        <td width="10" class="normalfnt"><input type="checkbox" style="visibility:hidden" name="checkbox" id="checkbox" onclick="dateDisable(this);" /></td>
        <td width="100" class="normalfnt">Delivery Date <span class="compulsoryRed">*</span></td>
        <td width="130"><input name="deliverydateDD" type="text" class="txtbox" id="deliverydateDD"style="width:100px" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" tabindex="5"/><input name="resetb" type="text"  class="txtbox" style="visibility:hidden;width:10px"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" /></select></td>
		 
		  </tr></table></td>
		  
      </tr>
     <!-- <tr>
        <td colspan="4">&nbsp;</td>
        <td colspan="5" class="normalfnt"></td>
        </tr>-->
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" >
      <tr class="mainHeading4">
        <td width="88%" ><b>General PO Details</b></td>
        <td width="12%" ><img src="../../images/add-new.png" alt="add new" id="cmdAddNew" width="109" height="18" onclick="ShowItems()" /></td>
      </tr>
      <tr>
      <!--#CCCCFF-->
        <td colspan="2"><div id="divcons2" style="overflow:scroll; height:350px; width:950px;">
          <table width="1400" cellpadding="0" cellspacing="1" id="tblMain" bgcolor="#CCCCFF">
            <tr class="mainHeading4">
              <th width="2%" >Del</th>
              <th width="7%" >Material</th>
              <th width="19%" >Description</th>
              <th width="4%" >&nbsp;Remarks&nbsp;</th>
              <th width="4%" >Unit</th>
              <th width="4%" >Qty</th>
              <th width="6%" >Unit Price </th>
              <th width="6%" >Max Rate<br />(USD)</th>
              <th width="5%" >Value</th>
              <th width="3%" >Dis <br/>%</th>
              <th width="6%" >Dis Value</th>
              <th width="7%" >Final Value</th>
              <th width="4%" >Fixed</th>
              <th width="7%" >MatDetail ID </th>
              <!--<th width="7%" >PR No</th>
              <th width="5%" >Cost Center</th>
              <th width="5%" >GL Code</th>-->
            </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="100%" border="0" class="tableBorder">
      <tr>       
        <td ><div align="center"><img src="../../images/new.png" alt="new" name="butNew" width="96" height="24" class="mouseover"  id="butNew" onclick="newPage();"/>
        <img src="../../images/save.png" alt="save" name="butSave" width="84" height="24" class="mouseover" id="butSave" onclick="save();" />
      
        <img src="../../images/conform.png" alt="conform" name="butConform" width="115" height="24" class="mouseover" id="butConform" onclick="GeneralPoConfirmReport();" style="display:none"/>
        <img src="../../images/cancel.jpg" alt="Cancel" name="butCancel" width="104" height="24" class="mouseover" id="butCancel" onclick ="cancel();" style="display:none"/>
        <img src="../../images/copyPO.png" alt="copy PO" width="108" height="24" onclick="loadPO();" />
        <img src="../../images/report.png" name="butReport" width="108" height="24" border="0" class="mouseover" id="butReport" onclick="GeneralPoReport(<?php echo $PP_allowChemicalPOReport ?>);" />
        <img src="../../images/btn-email.png" name="butMail"  id="butMail"  alt="Email" width="91" height="24" class="mouseover" style="display:none" />
        <img src="../../images/porevise.png" name="btnRevise" id="btnRevise" alt="Revise PO" height="24" onclick="RevisePO()"  />       
        <label><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0" /></a></label>
		</div>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
<div style="left:550px; top:427px; z-index:10; position:absolute; width: 240px; visibility:hidden; height: 65px;" id="copyPOMain">
  <table width="302" height="56" border="0" cellpadding="0" cellspacing="0" class="tablezRED">     
          <tr>
            <td colspan="4" bgcolor="#550000"  align="right"><img src="../../images/cross.png" onClick="loadPO();" alt="Close" name="Close" width="17" height="17" id="Close"/></td>
          </tr>
          <tr>
            <td width="33"><div align="center">Year </div></td>
            <td width="62">
              <div align="right">
                <select name="cboCopyEear" id="cboCopyEear" class="txtbox"  style="width:60px" onchange="LoadCopyPopupPoNo(this.value);">
				<?php
				echo "<option value=\"0\">Select One</option>";
				for ($loop = date("Y") ; $loop >= 2009; $loop --)
				{ 
					echo "<option value=\"$loop\">$loop</option>";
				}
				?>
                </select>
            </div></td><td>PO No 
                <select name="select7" class="txtbox" id="cboCopyPopupPONo" style="width:100px" >
                </select></td>
            <td><img src="../../images/go.png" alt="Copy PO" width="30" height="22" vspace="3" class="mouseover" onclick="copyPO();" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right"></div></td>
            <td width="157">&nbsp;</td>
            <td width="48">&nbsp;</td>
          </tr>
  </table>
</div>

</form>
<script language="javascript" type="text/javascript">

confirmGPO = <?php if ($confirmGeneralPO)
	echo "true";
else
	echo "false";?>
</script>
<script src="generalPo-java.js?n=1" type="text/javascript"></script>

</body>
</html>