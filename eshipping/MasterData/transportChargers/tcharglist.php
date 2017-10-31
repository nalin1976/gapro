<?php
$backwardseperator = "../../";
session_start();
include "../../Connector.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Transport Charges</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="caharges.js"></script>
<script language="javascript" type="text/javascript" src="../../javascript/script.js"></script>
</head>

<body>



<form id="frmBanks" name="form1" method="POST" action="">
<table width="950" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include '../../Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="35%">&nbsp;</td>
        <td width="30%"><table width="100%" border="0">
          <tr>
            <td height="19" bgcolor="#588DE7" class="TitleN2white">Transport Charges</td>
          </tr>
          <tr>
            <td height="96">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="100%" height="186" border="0" class="bcgl1">
                    <tr>
                      <td colspan="3" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="71%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="100%" colspan="2" bgcolor="#9BBFDD" class="normalfnth2">Details</td>
                              
                            </tr>
                            <tr>
                              <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:130px; width:600px;">
                                  <table width="512" cellpadding="0" cellspacing="0" id="tblMainGrn">
                                    <tr><td class="normaltxtmidb2" bgcolor="#498CC2" ></td>
                                      <td width="25%" height="25" bgcolor="#498CC2" class="normaltxtmidb2" >Serial No</td>
									  <td width="25%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">CBM Floor </td>
									  <td width="25%" height="25" bgcolor="#498CC2" class="normaltxtmidb2" >CBM Ceiling</td>
									  <td width="25%" height="25" bgcolor="#498CC2" class="normaltxtmidb2" >Amount </td>

									  <!--          </tr>
              <td  height="80" class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
			  <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td colspan="3"    class="normaltxtmidb2"><img src="../../images/loading5.gif" width="100" height="100" border="0"  /></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
              <td    class="normaltxtmidb2"></td>
           </tr>-->
                                    </tr>
      <?php
 		$SQL="SELECT intSerialNo, dblCBMFloor, dblCBMCeiling, 	dblAmount FROM  transportcharges ;";
		$result = $db->RunQuery($SQL);
		while($row = mysql_fetch_array($result))
	{
		$floor=$row['dblCBMFloor'];
		$ceiling=$row['dblCBMCeiling'];
		$amount=$row['dblAmount'];
		
		echo "<tr><td width='20'><img src='../../images/edit.png' class='mouseover' alt='Edit' width='20' height='20' name='Edit' onclick=\"editlist(" .$row['intSerialNo']. ",'" .$floor."','" .$ceiling. "','".$amount."');\"></td><td align='center'> " . $row["intSerialNo"] . " </td><td align='center'> "	.$row["dblCBMFloor"]. "</td><td align='center'> "	.$row["dblCBMCeiling"]. "</td><td align='center'> "	.$row["dblAmount"]. "</td><tr>";
	}	
				?>
                                    
                                  </table>
                              </div></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                      </tr>
                    <tr>
                      <td width="5%" class="normalfnt">&nbsp;</td>
                      <td width="23%" class="normalfnt">&nbsp;</td>
                      <td width="72%">&nbsp;</td>
                    </tr>
                  </table></td>
                  </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="34"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="bcgl1">
              <tr bgcolor="#d6e7f5">
                <td width="100%"><table width="100%" border="0" cellspacing="0">
                    <tr bgcolor="#d6e7f5">
                      <td width="215">&nbsp;</td>
                      <td width="100"><img src="../../images/new.png" alt="New" width="100" height="24" name="New"onclick="editlist();"/></td>
                      <!--<td width="84"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="butCommand(this.name)"/></td>
                      --><td width="100"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="89">&nbsp;</td>
                      <td width="156">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="35%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

  
  
  
  
</table>

</form>
</body>
</html>
