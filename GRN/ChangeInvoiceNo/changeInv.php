<?php
$backwardseperator = "../../";
session_start();
include $backwardseperator."authentication.inc";
$companyId  	= $_SESSION["FactoryID"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Change Invoce Number</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script src="changeInvoice.js" language="javascript" type="text/javascript"></script>
<script src="../../javascript/script.js" language="javascript" type="text/javascript"></script>
</head>

<body>
<form id="frmInvNo" name="frmInvNo">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include $backwardseperator."Header.php"?></td>
  </tr>
  <?php 
  include $backwardseperator."Connector.php"; 
  ?>
  <tr>
    <td><table width="600" border="0" align="center">
    <tr><td height="10"></td></tr>
    <tr><td>
    <table width="600" border="0" cellspacing="0" cellpadding="2" align="center" class="bcgl1">
      <tr>
        <td><table width="598" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td colspan="4" height="26" class="mainHeading">Change Invoice Number</td>
            </tr>
          <tr>
            <td width="125">&nbsp;</td>
            <td width="163">&nbsp;</td>
            <td width="135">&nbsp;</td>
            <td width="175">&nbsp;</td>
          </tr>
          <tr class="normalfnt">
            <td height="20">GRN Year</td>
            <td><select name="cboGRNyear" id="cboGRNyear" style="width:142px;" onChange="loadGRNno();">
                 <?php 
				for ($loop = date("Y") ; $loop >= 2008; $loop --)
				{
					if ($poyear ==  $loop)
						echo "<option selected=\"selected\" value=\"$loop\">$loop</option>";
					else
						echo "<option value=\"$loop\">$loop</option>";
				}
			?>
            </select>            </td>
            <td>GRN No</td>
            <td><select name="cboGRNno" id="cboGRNno" style="width:142px;" onChange="loadInvoceNo();">
            <option></option>
            <?php 
			$intYear = $_POST["cboGRNyear"];
			if($intYear == '')
				$intYear = date("Y");
				$sql = "select intGrnNo from grnheader where intGRNYear= '$intYear' and intCompanyID= '$companyId'
				 order by intGrnNo desc ";
				$result = $db->RunQuery($sql);		
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"". $row["intGrnNo"] ."\">" . $row["intGrnNo"] ."</option>" ;
				}
			?>
            </select>            </td>
          </tr>
          <tr class="normalfnt">
            <td height="20">Invoice Number</td>
            <td><input type="text" name="txtoldInvNo" id="txtoldInvNo" style="width:140px;text-transform: uppercase;" disabled></td>
            <td>New Invoice Number</td>
            <td><input type="text" name="txtNewInvNo" id="txtNewInvNo" style="width:140px;text-transform: uppercase;"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4"><table width="598" border="0" cellspacing="0" cellpadding="2" align="center" class="tableFooter">
              <tr>
                <td width="250" align="right"><img src="../../images/new.png" width="96" height="24" onClick="clearPage();"></td>
                <td width="86"><img src="../../images/save.png" width="84" height="24" onClick="updateInvNo();"></td>
                <td width="262"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0"></a></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td></tr></table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
