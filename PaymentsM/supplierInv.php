<?php
session_start();
$backwardseperator = "../";
include "../Connector.php";
//updated from roshan 2009-10-12

//$strPaymentType = $_GET["strPaymentType"]; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Supplier Invoice</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />

<script src="../javascript/jquery.js"></script>
<!-- * Alert * -->
<script src="mootools/SexyAlertBox/mootools.js" type="text/javascript"></script>
<link rel="stylesheet" href="mootools/SexyAlertBox/sexyalertbox.css" type="text/css" media="all" />
<script src="mootools/SexyAlertBox/sexyalertbox.packed.js" type="text/javascript"></script>
<script type="text/javascript">
/*window.addEvent('domready', function() {
    Sexy = new SexyAlertBox();
});*/

</script>

<!-- ** Alert ** -->

<!-- *FX Slide* -->
<!--<link rel="stylesheet" href="mootools/Fx.Slide_files/screen.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="mootools/Fx.Slide_files/print.css" type="text/css" media="print">
<link rel="stylesheet" href="mootools/Fx.Slide_files/main.css" type="text/css" media="screen">
 <script type="text/javascript">
        window.demo_path = 'demos/Fx.Slide/';
   </script>
<script type="text/javascript" src="mootools/Fx.Slide_files/mootools.js">
</script>
<script type="text/javascript" src="mootools/Fx.Slide_files/site.js">
</script>
<link rel="stylesheet" href="mootools/Fx.Slide_files/demo.css" type="text/css">
<script src="mootools/Fx.Slide_files/demo.js" type="text/javascript">
</script>
<script src="mootools/Fx.Slide_files/fx.js" type="text/javascript">
</script>-->

<!-- ** FX Slide ** -->

<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>
	<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
	<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
	<script src="../javascript/script.js" type="text/javascript"></script>
	<script src="supplierInv.js" type="text/javascript"></script>
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

<?php /*?><body onload="InvoiceInitialize(<?php 	
$invNo = $_GET["InvoiceNo"];
$supId = $_GET["SupplierId"];
	echo "'$invNo'"; echo ","; echo "'$supId'"
?>);fxVerticalSlide();"><?php */?>
<body onload="InvoiceInitialize(<?php 	
$invNo = $_GET["InvoiceNo"];
$supId = $_GET["SupplierId"];
	echo "'$invNo'"; echo ","; echo "'$supId'"
?>);">


<form name="frmsupinv" id="frmsupinv">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../Header.php'; ?></td>
	</tr> 
</table>
<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Supplier Invoice</div></div>
<div class="main_body">
	<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  		<tr>
    		<td>
			<table width="100%" border="0" class="button_row">
      			<tr>
					<td width="10" class="normalfnth2">&nbsp;</td>
					<td width="111" class="normalfnt">Saving in AccPac</td>
					<td width="33" class="normalfnth2"><input type="checkbox" name="chksaveaccpac" id="chksaveaccpac"/></td>
					<td width="102" class="normalfnt">Suspended VAT</td>
					<td width="31" class="normalfnth2"><input type="checkbox" name="chksuspendedvat" id="chksuspendedvat" /></td>
					<td width="261" class="normalfnth2">
						<input name="btnshowgl" type="button" style="background-color:#fdeec0;" id="btnshowgl" value="Show all GLS" onclick="ShowAllGLAccounts();"/>
					</td>
					<td width="37" class="normalfnth2"><!--<a id="v_toggle" href="#" name="v_toggle">
					  <input name="btnshowcrdr" type="button"  class="tablezREDMid" id="btnshowcrdr" value="Show Credit/Debit Notes" /></a>--></td>
        			<td width="329" class="normalfnth2"><!--<strong>status</strong>: <span id="vertical_status">close</span>-->
              			<table width="329" height="26" border="0" cellpadding="0" cellspacing="0" >
                			<tr>
								<td width="89" ><div align="center" class="normalfnt">&nbsp;Payment Type </div></td>
								<td width="242"><select name="cboPymentType" class="txtbox" id="cboPymentType" style="width:222px" >
								  <?php 
											$strSQL="SELECT strTypeID,strDescription FROM paymenttype ORDER BY intID";
											$result = $db->RunQuery($strSQL);
											while($row = mysql_fetch_array($result))
											{
												echo "<option value=\"". $row["strTypeID"] ."\">" . $row["strDescription"] ."</option>" ;
											}
											
										?>
								</select></td>
							</tr>
            			</table>
					</td>
      			</tr>
    		</table>
			</td>
  		</tr>
  <!-- * CREDIT / DEBIT NOTES * -->
  <!-- <tr>
  <td>
  <div id="main" style="margin: 0px;">
  <div style="margin: 0px; overflow: hidden; position: static;"><div style="margin: 0px;" id="vertical_slide">
  <table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
        <td height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="center">Credit and Debit Details</div></td>
        </tr>
      <tr>
        <td><div id="divcons1" style="overflow:scroll; height:130px; width:950px;">
          <table width="900" cellpadding="0" cellspacing="0" id="tblcreditdebit">
            <tr>
              <td width="23%" height="33" bgcolor="#498CC2" class="normaltxtmidb2">Type</td>
              <td width="18%" bgcolor="#498CC2" class="normaltxtmidb2">Doc No</td>
              <td width="19%" bgcolor="#498CC2" class="normaltxtmidb2">Date</td>
              <td width="14%" bgcolor="#498CC2" class="normaltxtmidb2">Total</td>
              <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">Amount</td>
              <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">Tax</td>
              </tr>
          </table>
        </div></td>
      </tr></table>
  </div></div>
  </div>
  </td>
  </tr>-->
  <!-- ** CREDIT / DEBIT NOTES ** -->
  		<tr>
    		<td>
				<table width="100%" border="0" >
      				<tr>
						<td width="65%" height="132" valign="top">	
							<table width="97%" height="125" border="0" cellpadding="0" cellspacing="0" class="button_row">
          						<tr>
									<td width="2%" class="containers">&nbsp;</td>
									<td width="12%" height="27" class="containers">Invoice No</td>
									<td width="31%" class="containers">
									<span class="normalfnt">
									  <input onkeypress="search(event);" name="txtinvno" type="text" class="txtbox" id="txtinvno" size="30" maxlength="30" />
									</span></td>
            						<td width="15%" class="containers">
									<img src="../images/search.png" alt="search" width="80" height="24" border="0" class="mouseover"  onclick="SearchInvoiceNo();" id="search"/>									</td>
									<td width="9%" class="containers">Date</td>
									<td width="31%" class="containers"><!--<select name="cboinvdate" class="txtbox" id="cboinvdate" style="width:120px">
									</select>-->
                                    <input name="cboinvdate" type="text"  class="txtbox" id="cboinvdate" size="15" onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);" onclick="return showCalendar(this.id, '%d/%m/%Y');" tabindex="1"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');"  value="" />
                                    </td>
          						</tr>
          						<tr>
									<td>&nbsp;</td>
									<td height="23" class="normalfnt">Supplier</td>
									<td colspan="4">
									<select name="cbosupplier" class="txtbox" id="cbosupplier" style="width:459px" onchange="GetSupplierInvoiceDetails();">
									  <?php 
										$strSQL="SELECT strSupplierID,strTitle AS strName FROM suppliers WHERE intStatus=1 ORDER BY strTitle";
										$result = $db->RunQuery($strSQL);
										echo "<option value=\"0\"></option>" ;
										while($row = mysql_fetch_array($result))
										{
											echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strName"] ."</option>" ;
										}
										
									?>
									</select></td>
								</tr>
          						<tr>
								<td>&nbsp;</td>
									<td height="23" class="normalfnt">Company</td>
									<td colspan="4"><select name="cbocompany" class="txtbox" id="cbocompany" style="width:459px">
									  <?php 
										//				$strSQL="SELECT intCompanyID,strComCode,strName FROM companies WHERE intstatus=1 ORDER BY strName";
										//				$result = $db->RunQuery($strSQL);
										//				echo "<option value=\"0\"></option>" ;
										//				while($row = mysql_fetch_array($result))
										//				{
										//					echo "<option value=\"". $row["intCompanyID"] ."\">" . $row["strName"] ."</option>" ;
										//				}
										
									?>
									</select>
											<input name="txtcompid" type="hidden" class="txtbox" id="txtcompid" size="10" /></td>
          						</tr>
          						<tr>
								<td>&nbsp;</td>
									<td height="22" class="normalfnt">Description</td>
									<td colspan="4"><input name="txtDescription" type="text" class="txtbox" id="txtDescription" size="76" style="width:457px"/></td>
          						</tr>
								<tr>
									<td height="19"></td>
								</tr>
						  </table>						</td>
        				<td width="35%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><table width="100%" height="126" border="0" class="button_row">
                                <tr>
                                  <td width="25%" class="normalfnt">Amount</td>
                                  <td colspan="2"><input name="txttotglamount" type="text" class="txtbox" id="txttotglamount"  style="text-align:right;width:220px" onkeypress="return CheckforValidDecimal(this.value,1,event);" onchange="CalculateTotalInvoiceAmount();calculateTaxAmount();CalculateTotalInvoiceAmount();" onkeyup="checkMaxGrn();" /></td>	

                                </tr>
                                <tr>
                                  <td class="normalfnt">Commission</td>
                                  <td colspan="2"><!--<input name="txtcommission" type="text" class="txtbox" id="txtcommission" onchange="Commission();" size="35" />-->
                                      <input name="txtcommission" type="text" class="txtbox" id="txtcommission" onkeypress="return CheckforValidDecimal(this.value,1,event);" onchange="CalculateTotalInvoiceAmount();" style="text-align: right;width:220px" />                                  </td>
                                </tr>
                                <tr>
                                  <td class="normalfnt">Currency</td>
                                  <td width="23%"><select name="cbocurrency" class="txtbox" id="cbocurrency" style="width:60px" onchange="getCurrencyRate();">
                                  <option value=""></option>
                                  <?php 
                                  	$sqlCur="SELECT strCurrency,strTitle FROM currencytypes WHERE intStatus='1';";
                                  	$resCurr=$db->Runquery($sqlCur);
                                  	while($row=mysql_fetch_array($resCurr)) {?>
                                  		<option value="<?php echo $row['strCurrency'];?>"><?php echo $row['strCurrency'];?></option>
                                  	<?php }?>
                                  </select></td>
                                  <td width="52%"><input name="txtcurrate" type="text" class="txtbox" id="txtcurrate" size="15" style="text-align:right"  onkeypress="return CheckforValidDecimal(this.value,1,event);" /></td>
                                </tr>
                                <tr>
                                  <td class="normalfnt">Tot Tax Amt </td>
                                  <td colspan="2"><input name="txttottaxamount" type="text" class="txtbox" 
										id="txttottaxamount" style="text-align:right;width:220px"   readonly="true" />                                  </td>
                                </tr>
                                <tr>
                                  <td height="24" class="normalfnt">Tot Amt</td>
                                  <td colspan="2">
									<input name="txtinvoiceamount" type="text" class="txtbox" id="txtinvoiceamount" size="35" style="text-align:right;width:220px"  readonly="true"/>                                  
								  </td>
                                </tr>
                            </table></td>
                          </tr>
                        </table></td>
      				</tr>
    	</table>
		</td>
  </tr>
  <tr>
    <td>
		<table width="100%" border="0" >
      	<tr>
        	<td width="65%" height="130" valign="top">
		        <table width="90%" border="0" cellpadding="0" cellspacing="0" class="button_row">
		          <tr>
		            <td width="2%" class="containers">&nbsp;</td>
		            <td width="12%" height="23" class="containers">Batch No</td>
		            <td width="86%" class="containers">
		            	<select name="cbobatch" class="txtbox" id="cbobatch" style="width:195px"></select>            
		            </td>
<!--		            <td width="1%" class="containers">&nbsp;</td>-->
		          </tr>
		          <tr>
		            <td height="100" colspan="3" class="normalfnt">
			            <div id="divcons" style="overflow:scroll; height:100px; width:600px;">
			                <table width="560" cellpadding="0" border="1" cellspacing="0" id="tblglaccounts">
			                  <tr>
			                    <td width="39" height="22" class="grid_header">*</td>
			                    <td width="102" class="grid_header">GL Acc Id</td>
			                    <td width="302" class="grid_header">Description</td>
			                    <td width="115" class="grid_header">Amount</td>
			                  </tr>
			                </table>
			            </div>
		            </td>
		          </tr>
		        </table>
        	</td>
        	<td width="35%" valign="top">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
          		<tr>
            		<td>
            			<table width="100%" border="0" class="button_row">
              	<tr>
	                <td width="25%" height="25" class="normalfnt">Entry No</td>
	                <td width="75%"><input name="txtentryno" type="text" class="txtbox" id="txtentryno" style="width:220px"/></td>
              	</tr>
              	<tr>
	                <td class="normalfnt">Credit Period</td>
	                <td>
	                	<select name="cbocreditprd" class="txtbox" id="cbocreditprd" style="width:222px" onchange="CreditDueDate();">
	                		<option value=""></option>
			                <?php 
							$sqlCp="SELECT creditperiods.strDescription AS CreditPeriod, creditperiods.dblNoOfDays AS NoOfDays 
									FROM creditperiods WHERE creditperiods.intStatus = '1'";
							$resCp=$db->RunQuery($sqlCp);
							while($row=mysql_fetch_array($resCp)){?>
					 		<option value="<?php echo $row['NoOfDays'];?>"><?php echo $row['CreditPeriod'];?></option>
							<?php }?>
	                	</select>
	                </td>
              	</tr>
              	<tr>
                	<td class="normalfnt">Date Due</td>
                	<td>
               			<input name="txtdatedue" type="text"  class="txtbox" id="txtdatedue" style="width:100px"  onMouseDown="DisableRightClickEvent();" onMouseOut="EnableRightClickEvent();" onKeyPress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%d/%m/%Y');" tabindex="1"/><input name="reset1" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%d/%m/%Y');" value="" />
               		</td>
              	</tr>
              	<tr>
                	<td class="normalfnt">Line No</td>
                	<td>
                		<input name="txtlineno" type="text" class="txtbox" id="txtlineno"  style="width:220px"/>
                	</td>
              	</tr>
              	<tr>
	                <td height="29" class="normalfnt">AccPacc ID</td>
	                <td><input name="txtaccpacid" type="text" class="txtbox" id="txtaccpacid"  style="width:100px"/></td>
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
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="51%" height="17" class="containers"><div align="center"><b>Purchase Order Details</b></div></td>
        <td width="49%" height="17" class="containers"><div align="center"><b>Tax Details</b></div></td>
      </tr>
      <tr>
        <td><div id="divcons2" style="overflow:scroll; height:130px; width:475px;">
          <table width="450" cellpadding="0" cellspacing="0" id="tblpodetails">
            <tr>
              <td width="39" height="22" class="grid_header">*</td>
              <td width="22%" height="22"class="grid_header">PO No. </td>
              <td width="18%" class="grid_header">Currency</td>
              <td width="18%"class="grid_header">Amount</td>
              <td width="18%" class="grid_header">Balance</td>
              <td width="15%" class="grid_header">PO</td>
			  <td width="15%" class="grid_header">ADV</td>
			  <td width="15%" class="grid_header">Excess</td>
			  <td width="15%" class="grid_header">PO/GRN</td>
            </tr>
          </table>
        </div>
	</td>
	<td valign="top">
		<div id="divcons3" style="overflow:scroll; height:130px; width:475px;">
			<table width="450" cellpadding="0" cellspacing="0" id="tbltaxdetails">
				<tr>
					<td width="39" height="22" class="grid_header">*</td>
					<td width="208" class="grid_header">Tax</td>
					<td width="87" class="grid_header">Rate</td>
					<td width="103" class="grid_header">Amount</td>
				</tr>
			</table>
		</div>
	</td>
	</tr>
	</table>
	</td>
  </tr>
  <tr>
    <td height="49" class="color_for_td">
		<table width="100%" border="0">
      		<tr>
        		<td width="7%" class="normalfnt">Freight</td>
        		<td width="14%" class="normalfnt">
					<input name="txtfreight" type="text" class="txtbox" id="txtfreight" size="16" style="text-align:right" onkeypress="return   	 	 	                    isNumberKey(event,this.value);" onchange="CalculateTotalInvoiceAmount();" /></td>
        		<td width="10%" class="normalfnt">Insurance</td>
				<td width="14%" class="normalfnt">
					<input name="txtinsurance" type="text" class="txtbox" id="txtinsurance" size="16" style="text-align:right" onkeypress="return 	     	   	   	   	                isNumberKey(event,this.value);" onchange="CalculateTotalInvoiceAmount();"/></td>
				<td width="7%" class="normalfnt">Other</td>
				<td width="13%" class="normalfnt">
					<input name="txtother" type="text" class="txtbox" id="txtother" size="16" style="text-align:right" onkeypress="return                    isNumberKey(event,this.value);" onchange="CalculateTotalInvoiceAmount();"/></td>
				<td width="9%" class="normalfnt">VAT GL Acc</td>
				<td width="15%" class="normalfnt">
					<input name="txtvatgl" type="text" class="txtbox" id="txtvatgl" size="16" style="text-align:right" onkeypress="return 															        			isNumberKey(event,this.value);" onchange="CalculateTotalInvoiceAmount();"/></td>
				<td width="11%" class="normalfnt">&nbsp;</td>
      		</tr>
    	</table>
	</td>
	</tr>
	<tr>
		<td class="button_row">
			<table width="100%" border="0">
				<tr>
					<td width="29%">&nbsp;</td>
					<td width="11%"><img src="../images/new.png" alt="new" class="mouseover" onclick="newPage();"/></td>
					<td width="10%"><img id="btnsave" src="../images/save.png" alt="Save" class="mouseover" onclick="SaveInvoice();" /></td>
					<td width="12%"><img src="../images/report.png" alt="report" /></td>
					<td width="15%"><a href="../Header.php"><img src="../images/close.png" alt="close" border="0" /></a></td>
					<td width="23%">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>

<div class="gap"></div>

</body>
</html>
