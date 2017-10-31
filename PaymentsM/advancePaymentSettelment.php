<?php
	session_start();
	include "../Connector.php";
	$backwardseperator = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Advanced Payment</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<script language="javascript" type="text/javascript" src="advancePaymentSettelment.js"> </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>

        <script src="../jquery.fixedheadertable.js"></script>
<script src="../javascript/script.js" type="text/javascript"></script>
<script src="../javascript/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.7.2.custom.min.js"></script>

</script>

</head>

<body>

<form name="frmAdvancePayment" id="frmAdvancePayment">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
   
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
    
	  <tr>
	    <td><?php include "../Header.php"; ?></td>
	    </tr>
	  <tr>
        <td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablezRED">
          
		  <tr><div>
            <td width="6%" height="25" class="normalfnt"> Supplier </td>
            <td width="31%" class="normalfnt"><select name="cboSuppliers" class="txtbox" id="cboSuppliers" style="width:350px">
              <?php
						
						$SQL="SELECT strSupplierID,strTitle FROM suppliers WHERE intStatus=1 order by strTitle";
						echo($SQL);
						$result = $db->RunQuery($SQL);
						echo "<option value=\"". 0 ."\">" . "" ."</option>" ;
						while($row = mysql_fetch_array($result))
						{
						echo "<option value=\"". $row["strSupplierID"] ."\">" . $row["strTitle"] ."</option>" ;
						}
					?>
            </select></td></div></tr>
			<tr><div>
            <td width="4%" class="normalfnt">&nbsp;</td>
            <td width="2%" class="normalfnt"><input name="radio" type="radio" id="radio" value="radio" checked="checked" /></td>
            <td width="7%" class="normalfnt">Style</td>
            <td width="2%" class="normalfnt"><input type="radio" name="radio" id="radio2" value="radio" /></td>
            <td width="7%" class="normalfnt">General</td>
            <td width="2%" class="normalfnt"><input type="radio" name="radio" id="radio3" value="radio" /></td>
            <td width="7%" class="normalfnt">Bulk</td>
            <td width="2%" class="normalfnt"><input type="radio" name="radio" id="radio4" value="radio" /></td>
            <td width="6%" class="normalfnt">Wash</td>
            <td width="9%" class="normalfnt">&nbsp;</td>
            <td width="15%" class="normalfnt"><img src="../images/search.png" alt="search" width="80" height="24" onclick="getStylePO()" /></td>
             </div></tr>
       
        </table></td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td height="156"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#9BBFDD" class="normalfnth2">POs</td>
        </tr>
      <tr>
        <td>
          <table width="860" cellpadding="0" cellspacing="0" id="tblPOList">
            <tr>
              <td width="8%" bgcolor="#498CC2" class="normaltxtmidb2">Set Off</td>
			  <td width="37%" height="25" bgcolor="#498CC2" class="normaltxtmidb2" style="text-align:center">Style</td>
              <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">PO No</td>
              <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2" style="text-align:right">PO00000 Amount</td>
              <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2" style="text-align:right">Paid Amount</td>
              <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2" style="text-align:right">Balance</td>
              <td width="10%" bgcolor="#498CC2" class="normaltxtmidb2">GRN</td>
              <td width="13%" bgcolor="#498CC2" class="normaltxtmidb2">&nbsp;</td>
            </tr>
			</table>
			</td>
      </tr>
	  <tr><div id="divcons2" style="overflow:; height:330px; width:950px;">
        </div></tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#D6E7F5"><table width="100%" border="0">
      <tr>
        <td width="40%">&nbsp;</td>
        <td width="13%"><img src="../images/save.png" alt="Save" width="84" height="24" /></td>
        <td width="11%"><a href="../main.php"><img src="../images/close.png" alt="close" width="97" height="24" border="0" /></a></td>
        <td width="36%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
