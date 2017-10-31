<?php
$backwardseperator = "../../";
include '../../Connector.php' ;
session_start();
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Gapro | Finishing Line Issue In</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<script language="javascript" src="../../javascript/script.js" ></script>
<script language="javascript" src="lineIssueIn.js"></script>
</head>

<body>
<form id="frmFinishingLineIn" name="frmFinishingLineIn">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><?php include '../../Header.php';?></td>
  </tr>
  <tr>
    <td><table width="750" border="0" cellspacing="0" cellpadding="2" align="center" class="tableFooter"s>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr class="mainHeading">
            <td height="25">Finishing Line Issue In</td>
          </tr>
        </table></td>
      </tr>
    
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="2" class="tableFooter">
        <tr class="normalfnt"><td colspan="5"></td></tr>
          <tr class="normalfnt">
            <td width="17%">Style No</td>
            <td width="36%"><select name="cboStyle" id="cboStyle" style="width:250px;" onChange="loadStylewiseOrders();">
            <option value="" ></option>
            <?php 
			$SQL = " SELECT DISTINCT O.strStyle FROM productionbundleheader PBH
INNER JOIN orders O ON O.intStyleId=PBH.intStyleId
ORDER BY O.strStyle";
			$result = $db->RunQuery($SQL);
			while($row=mysql_fetch_array($result))
			{
				 echo "<option value=".$row["strStyle"].">".$row["strStyle"]."</option>\n";
			}
			?>
            </select></td>
            <td width="13%">&nbsp;</td>
            <td width="13%">Line Issue No</td>
            <td width="21%"><input type="text" name="txtIssueNo" id="txtIssueNo" style="width:120px;" disabled></td>
          </tr>
          <tr class="normalfnt">
            <td>Order No</td>
            <td><select name="cboOrderNo" id="cboOrderNo" style="width:250px;" onChange="loadOrderwiseColors();">
            <option value=""></option>
            <?php 
			$SQL = " SELECT DISTINCT O.intStyleId,O.strOrderNo FROM productionbundleheader PBH
INNER JOIN orders O ON O.intStyleId=PBH.intStyleId
ORDER BY O.strOrderNo";
			$result = $db->RunQuery($SQL);
			while($row=mysql_fetch_array($result))
			{
				 echo "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>\n";
			}
			?>
            </select></td>
            <td>&nbsp;</td>
            <td>Order Qty</td>
            <td><input type="text" name="txtOrderQty" id="txtOrderQty"  style="width:120px; text-align:right" disabled></td>
          </tr>
          <tr class="normalfnt">
            <td>Color</td>
            <td><select name="cboColor" id="cboColor" style="width:250px;">
             <option value=""></option>
             <?php 
			$SQL = " SELECT DISTINCT WIFH.strColor
FROM  was_issuestofinishing_header WIFH 
WHERE WIFH.intStatus=1";
			$result = $db->RunQuery($SQL);
			while($row=mysql_fetch_array($result))
			{
				 echo "<option value=".$row["strColor"].">".$row["strColor"]."</option>\n";
			}
			?>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="normalfnt"><td colspan="5"></td></tr>
        </table></td>
      </tr>
      
      <tr>
        <td><div id="divLineIn" style="width:750px; height:300px; overflow:scroll;">
          <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCFF" id="tblMainGrid">
            <tr class="mainHeading4">
              <td width="4%"><input type="checkbox" name="chkAll" id="chkAll" onClick="checkAll(this);"></td>
              <td width="32%" height="22">Size</td>
              <td width="15%">Issued Qty</td>
              <td width="15%">Issue Qty</td>
              </tr>
           
          </table>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2" class="tableFooter">
          <tr>
            <td align="center"><a href="lineIssueIn.php"><img src="../../images/new.png" width="96" height="24" border="0"></a><img src="../../images/save.png" width="84" height="24" onClick="saveFinishInData();"><a href="../../main.php"><img src="../../images/close.png" width="97" height="24" border="0"></a></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>