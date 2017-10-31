<?php
$backwardseperator = "../../";
session_start();
include "../../Connector.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eShipping Web | Expenses Type</title>
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style>

<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="expense.js"></script>
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
        <td width="23%">&nbsp;</td>
        <td width="58%"><table width="90%" border="0">
          <tr>
            <td height="19" bgcolor="#588DE7" class="TitleN2white">Expense Details </td>
          </tr>
          <tr>
            <td height="96">
              <table width="83%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" class="normalfnt"><table width="97%" height="186" border="0" class="bcgl1">
                    <tr>
                      <td colspan="3" class="normalfnt"><table width="60%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="90%" height="144" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="89%" bgcolor="#9BBFDD" class="normalfnth2">Items</td>
                              <td width="11%" bgcolor="#9BBFDD" class="normalfnt">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="2" class="normalfnt"><div id="divcons" style="overflow:scroll; height:130px; width:600px;">
                                  <table width="599" cellpadding="0" cellspacing="1" id="tblExType" class='normalfnt'>
                                    <tr><td width="2%" bgcolor="#498CC2" class="normaltxtmidb2" >&nbsp;</td>
                                      <td width="48%" height="25" bgcolor="#498CC2" class="normaltxtmidb2" align="left">Description</td>
									  <td width="50%" height="25" bgcolor="#498CC2" class="normaltxtmidb2">Expenses Types </td>
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
 		$SQL="SELECT intExpensesID,strDescription,strExpencesType	FROM 	expensestype ";
		$result = $db->RunQuery($SQL);
		$i=1;
		while($row = mysql_fetch_array($result))
	{
		$id=$row['intExpensesID'];
		$type=$row['strExpencesType'];
		$desc=$row['strDescription'];
		echo "<tr><td width='40' ><img src='../../images/edit.png' id=".$i." class='mouseover' alt='Edit' width='20' height='20' name='Edit' onclick=\"editlist(" .$row['intExpensesID']. ",'" .$type."','" .$desc. "',this.id);\"></td><td > " . $row["strDescription"] . " </td><td align='center'> "	.$row["strExpencesType"]. "</td><tr>";
		$i+=1;	
	
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
                      <td width="176">&nbsp;</td>
                      <td width="172"><img src="../../images/new.png" alt="New" width="100" height="24" name="New"onclick="editlist();"/></td>
                      <!--<td width="84"><img src="../../images/save.png" alt="Save" width="84" height="24" name="Save" onclick="butCommand(this.name)"/></td>
                      --><td width="100"><a href="../../main.php"><img src="../../images/close.png" alt="Close" name="Close" width="97" height="24" border="0"/></a></td>
                      <td width="7">&nbsp;</td>
                      <td width="141">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="19%">&nbsp;</td>
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
