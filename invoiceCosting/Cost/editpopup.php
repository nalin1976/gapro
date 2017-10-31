<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";

$conpc			= $_GET["conpc"];		
$wastage		= $_GET["wastage"];				
$unitPrice		= $_GET["unitPrice"];
$finance		= $_GET["finance"];
$rowIndex		= $_GET["rowIndex"];

?>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<body>
<html>
<table width="450" border="0">
            <tr>
            <td height="16" colspan="4" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="94%" class="mainHeading">Edit Item </td>
                  <td width="6%" class="mainHeading"><div align="right"><img src="../../images/cross.png" alt="close" width="17" height="17" onClick="closeWindow();" class="mouseover"/></div></td>
                </tr>
              </table></td>
            </tr>
			<tr>
				<td width="15%" class="normalfnt">Con Pc </td>
			    <td width="29%" class="normalfnt"><input type="text" id="txtEditConPc" value="<?php echo $conpc?>" style="width:100px;text-align:right"/></td>
			    <td width="22%" class="normalfnt">Unit Price</td>
			    <td width="34%" class="normalfnt"><input type="text" id="txtEditUnitPrice" value="<?php echo $unitPrice?>" style="width:100px;text-align:right"/></td>
			</tr>
            <tr>
              <td height="0" class="normalfnt">Wastage</td>
              <td height="0" class="normalfnt"><input name="txtEditWastage" type="text" id="txtEditWastage" style="width:100px;text-align:right" value="<?php echo $wastage?>"/></td>
              <td height="0" class="normalfnt">Finance</td>
              <td height="0" class="normalfnt"><input name="txtEditFinance" type="text" id="txtEditFinance" style="width:100px;text-align:right" value="<?php echo $finance?>"/></td>
            </tr>
            <tr>
              <td height="0" class="normalfnt">Origin</td>
              <td height="0" class="normalfnt"><select name="cboEditOrigin" class="txtbox" id="cboEditOrigin" style="width:100px">
			  <?php 
			  $sql="SELECT intOriginNo,strOriginType FROM itempurchasetype where intStatus=1 order by strOriginType";
			  $result=$db->RunQuery($sql);
			  while($row=mysql_fetch_array($result))
			  {
			  	echo "<option value=\"". $row["intOriginNo"] ."\">" . $row["strOriginType"] ."</option>";
			  }
			  ?>
			  </select></td>
              <td height="0" class="normalfnt">Category</td>
              <td height="0" class="normalfnt"><select name="cboEditCategory" class="txtbox" id="cboEditCategory" style="width:100px" >
			  <?php 
			  $sql="SELECT intCategoryId,intCategoryName FROM invoicecostingcategory where intStatus=1 order by intOrderId";
			  $result=$db->RunQuery($sql);
			  while($row=mysql_fetch_array($result))
			  {
			  	echo "<option value=\"". $row["intCategoryId"] ."\">" . $row["intCategoryName"] ."</option>";
			  }
			  ?>
			  </select></td>
            </tr>
            <tr>
              <td height="21" colspan="4" ><table width="100%" border="0" class="tableFooter1">
                <tr>
                  <td width="31%" class="normalfnBLD1"><div align="center">
				  <img src="../../images/addsmall.png" alt="add" width="95" height="24" onClick="EditItem(<?php echo $rowIndex?>);"/>
				  <img src="../../images/close.png" alt="close" width="97" height="24" onClick="closeWindow();"/>
				  </div></td>
                </tr>
              </table></td>
            </tr>
          </table>
</html>
</body>