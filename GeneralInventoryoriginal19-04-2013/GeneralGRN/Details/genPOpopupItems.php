<?php
session_start();
$backwardseperator = "../../../";
$genPONo = $_GET["genPONo"];
$arrGenPO = explode('/',$genPONo);
include $backwardseperator."Connector.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<table width="600" height="390" border="0" align="center" bgcolor="#FFFFFF">
	 <tr>
		<td width="25%"   height="25" class="mainHeading">Genaral Po Items</td>	
	  </tr>
	  <tr>
		<td><table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="100%" class="normalfnt"><div id="divItem" style="overflow:scroll; height:320px; width:600px;">
			  <table width="100%" cellpadding="0" cellspacing="1" id="tblItem"  bgcolor="#CCCCFF">
              	<tr class="mainHeading4">
				  <th width="4%" height="25"><input type="checkbox" name="chkSelectAll" id="chkSelectAll" onClick="SelectAll(this);"/></th>
				  <th width="47%">Description</th>
				  <th width="8%">Unit</th>
				  <th width="7%">Qty</th>
                  <th width="7%">Detail Id</th>
                  <th width="14%">Cost Center</th>
                  <th width="13%">GL Code</th>
			    </tr>
                <?php 
				$sql = "select 	strItemDescription as Description,gpd.strUnit as strUnit,
dblPending as Qty,intGenPONo ,intMatDetailID, c.strDescription as costCenter,c.intCostCenterId,gpd.intGLAllowId,
gl.strAccID,(select c.strCode from costcenters c where c.intCostCenterId = gla.FactoryCode) as costCenterCode,gl.strDescription 
from generalpurchaseorderdetails gpd inner join genmatitemlist gmil on 
gpd.intMatDetailID = gmil.intitemserial  
inner join costcenters c on c.intCostCenterId = gpd.intCostCenterId
inner join glallowcation gla on gla.GLAccAllowNo = gpd.intGLAllowId
inner join glaccounts gl on gl.intGLAccID = gla.GLAccNo
where  intGenPONo= '$arrGenPO[1]' AND intYear=$arrGenPO[0] ";
			$result=$db->RunQuery($sql);
			$i=0;
			while($row = mysql_fetch_array($result))
			{
				if($i%2==0)
					$strColor = "bcgcolor-tblrowWhite";
				else
					$strColor = "bcgcolor-tblrow";
						
				?>
              <tr class="<?php echo $strColor; ?>">
									<td height="20"><div align="center" >
									<input type="checkbox" name="cboadd" id="cboadd" />
									</div></td>
									<td><?php echo $row["Description"]; ?></td>
									<td class="normalfntMid"><?php echo $row["strUnit"]; ?></td>
									<td><?php echo $row["Qty"]; ?></td>
                                    <td><?php echo $row["intMatDetailID"]; ?></td>
									<td id="<?php echo $row["intCostCenterId"] ?>"><?php echo $row["costCenter"]; ?></td>
									<td title="<?php echo $row["strDescription"] ?>" id="<?php echo $row["intGLAllowId"] ?>"><?php echo $row["strAccID"].'-'.$row["costCenterCode"] ?></td>
									</tr>
                <?php 
				
			}	?>
			  </table>
			</div></td>
			</tr>
		</table></td>
	  </tr>
	  <tr>
		<td><table width="100%" cellpadding="0" cellspacing="0" class="tableBorder">
	  <tr>
			<td width="38%" align="center" >
			<img src="../../../images/ok.png" alt="OK" width="86" height="24" onClick="addItemToGrn();" >
			<img src="../../../images/close.png" width="97" height="24" border="0" onClick="CloseOSPopUp('popupLayer1');" />
			</td>
		  </tr>
		</table></td>
	 </tr>
	</table>
    </body>
    </html>