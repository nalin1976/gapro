<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
	$strPaymentType = $_GET["strPaymentType"]; 
	//updated from roshan 2009-10-12
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Schdules</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #FFF;
}
.style1 {color: #0000FF}
-->
</style>
</head>

<script language="javascript" type="text/javascript" src="paymentSchedule.js">
</script>
<script language="javascript" type="text/javascript" src="../javascript/script.js"></script>

<body>
<form name="frmbom" id="frmbom">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"><?php include '../Header.php'; ?></td>
	</tr> 
</table>
<div class="main_bottom_center">
	<div class="main_top"><div class="main_text">PAYMENT SCHEDULE</div></div>
<div class="main_body_center">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="36%" valign="top"><table width="101%" border="0" class="bcgl1">
          <tr>
            <td bgcolor="" class="containers">Payment Type </td>
            <td colspan="2" bgcolor="" class="containers"><span class="containers">
              <select name="cboPymentType" class="txtbox" id="cboPymentType" style="width:150px" onchange="loadSupInvoice()" >
                <?php 
								$strSQL="SELECT strTypeID,strDescription FROM paymenttype ORDER BY intID";
								$result = $db->RunQuery($strSQL);
								while($row = mysql_fetch_array($result))
								{
									echo "<option value=\"". $row["strTypeID"] ."\">" . $row["strDescription"] ."</option>" ;
								}
								
							?>
              </select>
            </span></td>
          </tr>
          <tr>
            <td width="23%" bgcolor="" class="containers">Supplier</td>
            <td width="77%" colspan="2" bgcolor="" class="containers"><select name="cboSupliers" class="txtbox" id="cboSupliers" style="width:300px" onchange="loadSupInvoice()" >
              <?php
				$strSQL="SELECT strSupplierID,strTitle AS strSupName FROM suppliers WHERE intStatus=1 ORDER BY strTitle";
				$result = $db->RunQuery($strSQL);
	
				echo "<option value=\"". "0" ."\">" . "" ."</option>" ;
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strSupName"] ."</option>" ;
				}
			
			
			
			?>
            </select></td>
          </tr>
        </table></td>
        <td width="64%" rowspan="3" valign="top">
		<table width="93%" border="0" class="bcgl1">
          <tr>
            <td><div id="divSupInvs" style="overflow: -moz-scrollbars-vertical; height:152px; width:536px;">
              <table width="534" cellpadding="0" cellspacing="0" id="tblInvoices">
                <tr>
                  <td width="24" bgcolor="" class="grid_header"><input type="checkbox" onclick="chkAll(this);" /></td>
                  <td width="82" bgcolor="" class="grid_header">Invoice No</td>
                  <td width="63" bgcolor="" class="grid_header">GRN</td>
                  <td width="68" height="20" bgcolor="" class="grid_header">PO</td>				  
                  <td width="73" bgcolor="" class="grid_header">Amount</td>
                  <td width="71" bgcolor="" class="grid_header">Balance</td>
                  <td width="73" bgcolor="" class="grid_header">Pay Amount</td>
                </tr>
              </table>
            </div>
			</td>
          </tr>
          <tr>
            <td>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
              			<tr>
							<td width="35%" bgcolor="" class="containers"> Find Invoice by Invoice No</td>
							<td width="29%" bgcolor="" class="containers"><input name="txtFindInvNo" type="text"  style="text-align:right" align="right" class="normalfntRite" id="txtFindInvNo" size="20"  /></td>
							<td width="11%" bgcolor="" class="containers"><img src="../images/search.png" onclick="searchInvoices();"></img></td>
							<td width="25%" bgcolor="" class="containers">&nbsp;</td>
              			</tr>
            		</table>
			</td>
          </tr>
        </table>
		</td>
      	</tr>
      <tr>
        <td valign="top"><div id="divTaxType" style="overflow:scroll; height:133px; width:432px;" class="bcgl1">
          <table width="409" cellpadding="0" cellspacing="0" id="tblTaxType">
          	<thead>
            <tr>
              <td width="102" bgcolor="" class="grid_header">Tax Type</td>
              <td width="59" bgcolor="" class="grid_header">Rate</td>
              <td width="93" bgcolor="" class="grid_header">Amount</td>
              <td width="102" height="20" bgcolor="" class="grid_header">Invoice</td>
            </tr>
            </thead>
            <tbody>
            
            </tbody>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  	  <tr>
  		<td>
			<table>
				<tr>
					<td>
						<div id="" style="overflow:scroll; height:133px; width:432px;" class="bcgl1">
						<table width="409">	
							<tr>
								<td  class="grid_header">*</td>
								<td  class="grid_header">Type</td>
								<td  class="grid_header">Doc No</td>
								<td  class="grid_header">Date</td>
								<td  class="grid_header">Total</td>
								<td  class="grid_header">Tax</td>
							</tr>	
						</table>
						</div>
					</td>
					<td>
						<div id="" style="overflow:scroll; height:133px; width:536px;" class="bcgl1">
						<table width="471" id="tblPoDetails">	
							<thead>
							<tr>
								<td  class="grid_header" style="width:5px;">*</td>
								<td  class="grid_header" style="width:20px;">Sel</td>
								<td  class="grid_header" style="width:50px;">PO No</td>
								<td  class="grid_header" style="width:50px;">PO Amount</td>
								<td  class="grid_header" style="width:50px;">Advance Amount</td>
								<td  class="grid_header" style="width:50px;">Pre Paid</td>
								<td  class="grid_header" style="width:50px;">Balance</td>
								<td  class="grid_header" style="width:50px;">Pay Now</td>
							</tr>	
							</thead>
							<tbody>
								
							</tbody>
					  	</table>
						</div>
					</td>
				</tr>
			</table>
		</td>
  </tr>
  	  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <td><div id="divGRNItems" style="overflow: -moz-scrollbars-vertical; height:190px; width:990px;" class="bcgl1">
          <table width="1200" cellpadding="0" cellspacing="0" id="tblGRNs">
            <tr>
              <td width="23" bgcolor="#498CC2" class="grid_header">*</td>
              <td width="74" height="20" bgcolor="#498CC2" class="grid_header">Invoice No</td>
              <td width="74" bgcolor="#498CC2" class="grid_header">GRN No</td>
              <td width="74" bgcolor="#498CC2" class="grid_header">Style No</td>
              <td width="74" bgcolor="#498CC2" class="grid_header">Order No</td>
              <td width="203" bgcolor="#498CC2" class="grid_header">Description</td>
              <td width="67" bgcolor="#498CC2" class="grid_header">QTY</td>
              <td width="75" bgcolor="#498CC2" class="grid_header">Rate</td>
              <td width="83" bgcolor="#498CC2" class="grid_header">Value</td>
              <td width="79" bgcolor="#498CC2" class="grid_header">Balance</td>			  
              <td width="138" bgcolor="#498CC2" class="grid_header">Pay Amount </td>
			 <td style="visibility:hidden"  bgcolor="#498CC2" class="grid_header" width="0"></td>
			<td style="visibility:hidden"  bgcolor="#498CC2" class="grid_header" width="0"></td>
			<td style="visibility:hidden"  bgcolor="#498CC2" class="grid_header" width="0"></td>
			<td style="visibility:hidden"  bgcolor="#498CC2" class="grid_header" width="0"></td>
			<td style="visibility:hidden"  bgcolor="#498CC2" class="grid_header" width="0"></td>
			<td style="visibility:hidden"  bgcolor="#498CC2" class="grid_header" width="0"></td>
			<td style="visibility:hidden"  bgcolor="#498CC2" class="grid_header" width="0"></td>
			<td style="visibility:hidden"  bgcolor="#498CC2" class="grid_header" width="0"></td>
			<td style="visibility:hidden"  bgcolor="#498CC2" class="grid_header" width="0"></td>
              </tr>
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="48%" bgcolor="" class="containers">&nbsp;</td>
        <td width="7%" bgcolor="" class="containers">&nbsp;</td>
        <td width="6%" bgcolor="" class="containers">Total</td>
        <td width="12%" bgcolor="" class="containers"><input name="txtTotValue"  disabled="disabled" type="text" class="normalfntRite" id="txtTotValue" size="15" style="text-align:right" /></td>
        <td width="12%" bgcolor="" class="containers"><input name="txtTotBalance" disabled="disabled" type="text" class="normalfntRite" id="txtTotBalance" size="15" /></td>
        <td width="12%" bgcolor="" class="containers"><input name="txtTotPayAmount" disabled="disabled" type="text" class="normalfntRite" id="txtTotPayAmount" size="15" /></td>
        <td width="3%" bgcolor="" class="containers">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor=""><table width="100%" border="0">
      <tr>
        <td width="29%">&nbsp;</td>
        <td width="10%"><img   src="../images/new.png" alt="NEW" width="96" height="24" class="mouseover" onclick="interfaceClear()" /></td>
        <td width="9%"><img src="../images/save.png" alt="SAVE" width="84" height="24" class="mouseover" onclick="savePaymentSchedule()" /></td>
        <td width="11%"><img src="../images/report.png" alt="REPORT" width="108" height="24" class="mouseover" /></td>
        <td  width="10%"><a href="../main.php"><img src="../images/close.png" alt="CLOSED"  border="0" class="mouseover" /></a></td>
        <td width="31%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
</div>
</form>
</body>
</html>
