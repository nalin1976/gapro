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
    <div class="main_top">
      <div class="main_text">Payment Voucher Listing and Reports</div>
    </div>
    <div class="main_body">
      <table width="950" border="0" align="center" bgcolor="#FFFFFF">
        <tr>
          <td colspan="3"><table width="100%" border="0">
              <tr>
                <td width="1%">&nbsp;</td>
                <td width="63%"><table width="100%" height="66" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
                    <tr>
                      <td width="17%" class="normalfnt">&nbsp;Supplier</td>
                      <td width="44%" ><select name="cboSuppliers" class="txtbox" id="cboSuppliers" style="width:250px" >
                          <option value="0"></option>
                          <?php
							$SQL = "SELECT strSupplierID,strTitle FROM suppliers WHERE intStatus=1 ORDER BY strTitle;";	
							$result = $db->RunQuery($SQL);		
							while($row = mysql_fetch_array($result))
							{
								echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
							}
			             ?>
                        </select></td>
                      <td width="39%">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="25" class="border-bottom-style-report" >&nbsp;Voucher No</td>
                      <td class="border-bottom-style-report"><input name="txtVoucherNo" type="text" class="txtbox" id="txtVoucherNo" style="width:90px"/>
                        <span class="normalfntMid" style="text-align:right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice No</span></td>
                      <td class="border-bottom-style-report"><input name="txtInvoiceNo" type="text" class="txtbox" id="txtInvoiceNo" style="width:90px"/></td>
                    </tr>
                    <tr>
                      <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="4%" ><input name="checkbox" type="checkbox" id="chkDate" onclick="Clear(this);" checked="checked" /></td>
                            <td width="13%" ><span class="normalfnt">&nbsp;Date From</span></td>
                            <td width="29%"><input name="txtDateFrom" type="text" class="txtbox" id="txtDateFrom" size="13" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/>
                            <input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
                            <td width="15%" ><span class="normalfnt" >Date To</span></td>
                            <td width="24%"><input name="txtDateTo" type="text" class="txtbox" id="txtDateTo" size="13" onmousedown="DisableRightClickEvent();" onmouseout="EnableRightClickEvent();" onkeypress="return ControlableKeyAccess(event);"  onclick="return showCalendar(this.id, '%Y/%m/%d');"/>
                            <input type="reset" value=""  class="txtbox" style="visibility:hidden;"   onclick="return showCalendar(this.id, '%Y/%m/%d');"></td>
                            <td width="15%"><span class="normalfnt"><img src="../images/search.png" alt="go" class="mouseover" onclick="fillAvailablePaymentData();" /></span></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
                <td width="36%" class=" bcgl1"><table width="349" height="40" border="0" cellpadding="0" cellspacing="0" class="normalfnt2BITAB" >
                    <tr>
                      <td height="21" colspan="5" align="center" class="normalfntBtab">Payment Types </td>
                    </tr>
                    <tr>
                      <td class="normalfnt">Payment Type</td>
                      <td class="normalfnt">
					  <?php 
			               $type    = $_POST["cboPaymentType"];
			               $checked	= "selected=\"selected\""; 
		              ?>
                        <select name="cboPaymentType" id="cboPaymentType" onchange="pageRefresh();" style="width:80px;">
                          <option value="S" <?php if($type=="S"){ echo $checked;} ?>>Style</option>
                          <option value="G" <?php if($type=="G"){ echo $checked;} ?>>General</option>
                          <option value="B" <?php if($type=="B"){ echo $checked;} ?>>Bulk</option>
                          <option value="W" <?php if($type=="W"){ echo $checked;} ?>>Wash</option>
                        </select></td>
                      <td >&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td colspan="3"><div class="bcgl1" id="divPayVoucherData" style="overflow:scroll; width:945px;height:350px">
              <table id="tblPVData" width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="" >
                <tr>
                  <td width="8%" height="25" bgcolor="" class="grid_header">Sup ID </td>
                  <td width="17%" height="25" bgcolor="" class="grid_header">Voucher No</td>
                  <td width="16%" bgcolor="" class="grid_header">Date</td>
                  <td width="18%" bgcolor="" class="grid_header">Amount </td>
                  <td width="18%" bgcolor="" class="grid_header">Cheque No</td>
                  <td width="11%" bgcolor="" class="grid_header">View Voucher </td>
                  <td width="12%" bgcolor="" class="grid_header">View Schedule </td>
                </tr>
              </table>
            </div></td>
        </tr>
      </table>
      </td>
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
