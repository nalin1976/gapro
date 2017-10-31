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
<link rel="stylesheet" type="text/css" href="../js/jquery-ui-1.8.9.custom.css"/>
<link rel="stylesheet" href="mootools/SexyAlertBox/sexyalertbox.css" type="text/css" media="all" />
<style type="text/css">
<!--
body {
	background-color: #FFF;
}
.style1 {color: #0000FF}
-->
.button{
	background-color: #FBF8B3;
	border: outset;
	font-family: Arial;
	letter-spacing: 5px;
	font-size: 10px;
	font-weight: 200;
	width: 55px;
	height: 20px;
	text-align: center;
	
}
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
            <td class="normalfnt">Payment Type </td>
            <td colspan="2"><span class="containers">
              <select name="cboPymentType" class="txtbox" id="cboPymentType" style="width:300px" onchange="loadSupInvoice()" >
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
            <td width="23%" class="normalfnt">Supplier</td>
            <td width="77%" colspan="2"><select name="cboSupliers" class="txtbox" id="cboSupliers" style="width:300px" onchange="loadSupInvoice()" >
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
        <td width="64%" rowspan="3" valign="top"><table width="93%" border="0" class="bcgl1">
          <tr>
            <td><div id="divSupInvs" style="overflow: none; height:152px; width:536px;">
              <table width="534" cellpadding="0" cellspacing="0" id="tblInvoices">
                <thead>
                  <td width="24" bgcolor="#FBF8B3" class='normalfntMid'>*</td>
                  <td width="82" bgcolor="#FBF8B3" class='normalfntMid'>Invoice No</td>
                  <td width="63" bgcolor="#FBF8B3" class='normalfntMid'>GRN</td>
                  <td width="68" height="20" bgcolor="#FBF8B3" class='normalfntMid'>PO</td>				  
                  <td width="73" bgcolor="#FBF8B3" class='normalfntMid'>Amount</td>
                 <!-- <td width="71" bgcolor="#498CC2" class="grid_header">Tot GRN</td>-->
                  <td width="71" bgcolor="#FBF8B3" class='normalfntMid'>Balance</td>
                  <td width="73" bgcolor="#FBF8B3" class='normalfntMid'>Pay Amount</td>
                </thead>
               <!-- <tr>
                  <td class="normalfnt"><div align="center"><span class="normalfntMid">
                    <label>
                    <input type="checkbox" name="checkbox2" value="checkbox" />
                    </label>
                  </span></div></td>
                  <td class="normalfnt">10339</td>
                  <td class="normalfntRite">10339</td>
                  <td class="normalfntMid">10339</td>
                  <td class="normalfntMid">Test</td>
                  <td class="normalfntMid">10339</td>
                  <td class="normalfntMid" ><label>
                    <input type="text" name="textfield" size="15"   value="222" style="text-align:right"  class="txtbox" />
                  </label></td>
                  <td class="normalfntMid">Test</td>
                </tr>-->
              </table>
            </div></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
<!--              onkeypress="return findInvNumber(event)"-->
                <td width="35%" class="normalfntMid"> Find Invoice by Invoice No</td>
                <td width="29%"><input name="txtFindInvNo" type="text"  style="text-align:right" align="right" class="normalfntRite" id="txtFindInvNo" size="20"  /></td>
                <td width="11%"><img src="../images/search.png" onclick="showWaitingWindow();searchInvoices();"></img></td>
                <td width="25%">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <!--<tr>
        <td valign="top" bgcolor="#9BBFDD" class="normalfnth2"><div align="left">Tex Types</div></td>
      </tr>-->
      <tr>
        <td valign="top"><div id="divTaxType" style="overflow:scroll; height:133px; width:432px;" class="bcgl1">
          <table width="409" cellpadding="0" cellspacing="0" id="tblTaxType">
          	<thead>
            <tr class="mainHeading4">
             <!-- <td width="27" bgcolor="#498CC2" class="normaltxtmidb2">*</td>-->
              <td width="102" bgcolor="#FBF8B3" class='normalfntMid'>Tax Type</td>
              <td width="59" bgcolor="#FBF8B3" class='normalfntMid'>Rate</td>
              <td width="93" bgcolor="#FBF8B3" class='normalfntMid'>Amount</td>
              <td width="102" height="20" bgcolor="#FBF8B3" class='normalfntMid'>Invoice</td>
            </tr>
            </thead>
            <tbody>
            
            </tbody>
            <!--<tr>
              <td class="normalfnt"><label>
                <input type="checkbox" name="checkbox" value="checkbox" />
                </label></td>
              <td class="normalfnt">ssa</td>
              <td class="normalfntRite">10339</td>
              <td class="normalfntRite">Test</td>
              <td class="normalfntMid">Test</td>
              <td class="normalfntMid">Test</td>
            </tr>-->
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
<!--      <tr>
        <td height="17" bgcolor="#9BBFDD" class="normalfnth2"><div align="left">GRN Details - Style</div></td>
        </tr>style="overflow: -moz-scrollbars-vertical
      <tr>-->
        <td><div id="divGRNItems" style="overflow: -moz-scrollbars-vertical; height:190px; width:982px;" class="bcgl1">
          <table width="1200" cellpadding="0" cellspacing="0" id="tblGRNs">
            <tr>
              <td width="23" bgcolor="#FBF8B3" class='normalfntMid'>*</td>
              <td width="74" height="20" bgcolor="#FBF8B3" class='normalfntMid'>Invoice No</td>
              <td width="74" bgcolor="#FBF8B3" class='normalfntMid'>GRN No</td>
              <td width="74" bgcolor="#FBF8B3" class='normalfntMid'>Style No</td>
              <td width="74" bgcolor="#FBF8B3" class='normalfntMid'>Order No</td>
              <td width="203" bgcolor="#FBF8B3" class='normalfntMid'>Description</td>
              <td width="67" bgcolor="#FBF8B3" class='normalfntMid'>QTY</td>
              <td width="75" bgcolor="#FBF8B3" class='normalfntMid'>Rate</td>
              <td width="83" bgcolor="#FBF8B3" class='normalfntMid'>Value</td>
              <td width="79" bgcolor="#FBF8B3" class='normalfntMid'>Balance</td>			  
              <td width="138" bgcolor="#FBF8B3" class='normalfntMid'>Pay Amount </td>
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
            <!--<tr>
              <td class="normalfntMid"><label>
                <input type="checkbox" name="checkbox" value="checkbox"  />
              </label></td>

              <td class="normalfnt">FABR</td>
              <td class="normalfnt">Pocketing</td>
              <td class="normalfnt">110110</td>
              <td class="normalfnt">110110</td>
              <td class="normalfntMid">110110</td>
              <td class="normalfntRite">110110</td>
              <td class="normalfntRite">110110</td>
              <td class="normalfntRite"><label>
                <input type="text" name="textfield" class="txtbox" size="15"/>
              </label></td>
              <td class="normalfntRite">110110</td>

              <td class="normalfntRite" width="0"></td>
              <td class="normalfntRite" width="0"></td>
              <td class="normalfntRite" width="0"></td>
              <td class="normalfntRite" width="0"></td>
              <td class="normalfntRite" width="0"></td>
            </tr>-->
          </table>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" class="bcgl1">
      <tr>
        <td width="48%">&nbsp;</td>
        <td width="2%">&nbsp;</td>
        <td width="5%" class="normalfntMid">Total</td>
        <td width="11%"><input name="txtTotValue"  disabled="disabled" type="text" class="normalfntRite" id="txtTotValue" size="15" style="text-align:right" /></td>
        <td width="15%" class="normalfntMid"><input name="txtTotBalance" disabled="disabled" type="text" class="normalfntRite" id="txtTotBalance" size="15" /></td>
        <td width="11%"><input name="txtTotPayAmount" disabled="disabled" type="text" class="normalfntRite" id="txtTotPayAmount" size="15" /></td>
        <td width="8%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor=""><table width="100%" border="0">
      <tr>
        <td width="29%">&nbsp;</td>
        <td width="10%"><img   src="../images/new.png" alt="NEW" width="96" height="24" class="mouseover" onclick="interfaceClear()" /></td>
        <td width="9%"><img src="../images/save.png" alt="SAVE" width="84" height="24" class="mouseover" onclick="savePaymentSchedule()" /></td>
        <td width="11%"><img src="../images/report.png" alt="REPORT" width="108" height="24" class="mouseover" onclick="scheduleReport();"/></td>
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
<script src="../js/jquery.fixedheader.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="paymentSchedule.js">
</html>
