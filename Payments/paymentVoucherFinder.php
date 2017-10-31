<?php
session_start();
include "../Connector.php"; 
$strPaymentType=$_GET["strPaymentType"];
$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web - Payments Finder</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../javascript/calendar/theme.css" />
<style type="text/css">
<!--
body {
	background-color: #FFF;
}
-->
</style>

<style type="text/css">
<!--
#tblSample td, th { padding: 0.5em; }
.classy0 { background-color: #234567; color: #89abcd; }
.classy1 { background-color: #89abcd; color: #234567; }
-->
.border-bottom-style-report {
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #C9DFF1;
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}
</style>


</head>
<script src="paymentVoucher.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar.js" type="text/javascript"></script>
<script src="../javascript/calendar/calendar-en.js" type="text/javascript"></script>
<script src="../javascript/script.js" type="text/javascript"></script>


<body onload="setDefaultDateofFinder()">

<form id="frmPayment_search" name="frmPayment_search" method="post" action="paymentVoucherFinder.php">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../Header.php'; ?></td>
	</tr> 
</table>
<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">Payment Voucher Listing and Reports</div></div>
<div class="main_body">
  <table width="950" border="0" align="center" bgcolor="#FFFFFF">
    <tr>
      <td colspan="3">
	  	<table width="100%">
	  		<tr>
				<td width="1%"  height="26" >&nbsp;</td>
				<td width="9%"  class="normalfnt">Supplier</td>
				<td colspan="2">
					<select name="cboSuppliers" class="txtbox" id="cboSuppliers" style="width:250px" >
					<option value="0"></option>
					<?php
					$SQL = "SELECT strSupplierID,strTitle FROM suppliers WHERE intStatus=1 ORDER BY strTitle;";	
					$result = $db->RunQuery($SQL);		
					while($row = mysql_fetch_array($result))
					{
						echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
					}
					?>
				  </select>			  	</td>
				<td width="17%" class="normalfnt">Payement Type</td>
				<td>
					<?php 
					  $type = $_POST["cboPaymentType"];
					  $checked	= "selected=\"selected\""; 
				   ?>
				  <select name="cboPaymentType" id="cboPaymentType" onchange="pageRefreshSearch();">
					<option value="S" <?php if($type=="S"){ echo $checked;} ?>>Style</option>
					<option value="G" <?php if($type=="G"){ echo $checked;} ?>>General</option>
					<option value="B" <?php if($type=="B"){ echo $checked;} ?>>Bulk</option>
					<option value="W" <?php if($type=="W"){ echo $checked;} ?>>Wash</option>
				  </select>				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td ><span class="normalfnt">Voucher No</span></td>
                <td width="16%" class="normalfnt" ><input name="txtVoucherNo" type="text" class="txtbox" id="txtVoucherNo" size="20"/></td>
                <td width="21%"  >&nbsp;</td>
                <td class="normalfnt">Invoice No Like</td>
                <td width="24%"><span class="normalfnt">
                  <input name="txtInvoiceNo" type="text" class="txtbox" id="txtInvoiceNo" size="20"/>
                </span></td>
                <td width="12%" >&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
              <td class="normalfnt"><input name="checkbox" type="checkbox" id="chkDate" onclick="Clear(this);" checked="checked" /></td>
              <td><span class="normalfnt" style="text-align:center">Date From </span></td>
			  <td class="normalfnt"><input name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset2" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
              <td><span class="normalfnt">Date To</span></td>
			  <td><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="15" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/><input name="reset" type="reset"  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');" value="" /></td>
			  <td><span class="normalfnt"><img src="../images/search.png" alt="go" class="mouseover" onclick="fillAvailablePaymentData();" /></span></td>
            </tr>
	  	</table>
	  </td>
          </tr>
        <tr>
          <td colspan="3">
		  <div class="bcgl1" id="divPayVoucherData" style="overflow:scroll; width:945px;height:350px">
		  <table id="tblPVData" width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="" >
		  	<thead>
            <tr>
			  <td height="25" bgcolor="" class="grid_header">Sup ID </td>
              <td height="25" bgcolor="" class="grid_header">Voucher No</td>
              <td bgcolor="" class="grid_header">Date</td>
              <td bgcolor="" class="grid_header">Amount </td>
              <td bgcolor="" class="grid_header">Cheque No</td>           
              <td bgcolor="" class="grid_header">View Voucher </td>
              <td bgcolor="" class="grid_header">View Schedule </td>
             </tr>
			 </thead>
			 <tbody>
			 </tbody>
          </table>
		  </div></td>
        </tr>
	
		
      </table></td>
    </tr>
    
  </table>
<script type="text/javascript">
function Clear(obj){
	if(obj.checked){
		document.getElementById('txtDateFrom').disabled = false;
		document.getElementById('txtDateTo').disabled = false;	
	}
	else{
		document.getElementById('txtDateFrom').disabled = true;
		document.getElementById('txtDateTo').disabled = true;	
		document.getElementById('txtDateFrom').value = "";
		document.getElementById('txtDateTo').value = "";	
	}
}
</script>
</div>
</div>
</form>
</body>
</html>
