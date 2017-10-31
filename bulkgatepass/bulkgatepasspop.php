<?php
	session_start();
	$backwardseperator = "../";
	include "../Connector.php";	
	$companyId=$_SESSION["FactoryID"];
	include "../authentication.inc";
	$MstoresId	= $_GET["MstoresId"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 11px; color: #FFFFFF; margin: 0px; text-align: center; font-family: Verdana;}
-->
</style>
</head>

<body>
<table width="950" border="0" bgcolor="#ffffff" align="center" class="tableBorder">
<tr>
	<td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="tableBorder">
		<tr>
		<td width="97%" height="17" style="text-align:center" class="mainHeading">Gatepass Items</td>
		<td width="3%" align="left" class="mainHeading"><img src="../images/cross.png" alt="clase" width="17" height="17" align="right" onclick="CloseOSPopUp('popupLayer1');" /></td>
		</tr>
		<tr>
			<td colspan="2"><div style="overflow: scroll; height: 350px; width: 950px;" id="divGatePassItems">
			<table width="932" cellspacing="1" cellpadding="0" bgcolor="#ccccff" id="tblGatePassItems">
			<tr class="mainHeading4">
				<td height="25" width="1%"><input type="checkbox" onclick="SelectAll(this);" id="checkbox" name="checkbox"></td>
				<td width="8%">Main Materials</td>
				<td width="20%">Item Description</td>
				<td width="6%">Color</td>
				<td width="5%">Size</td>
				<td width="4%">Unit</td>
				<td width="3%">Stock Bal</td>
				<td width="2%"></td>
				<td width="5%">GRN No</td>
				<td width="4%">GRN Year</td>
				</tr>
				<?php
				$sql = "select intMatDetailId, 
						MMC.strDescription as Material,
						MIL.strItemDescription as Description,
						strColor, 
						strSize, 
						BST.strUnit, 
						round(sum(dblQty),2) as dblQty, 
						intBulkGrnNo, 
						intBulkGrnYear	 
						from 
						stocktransactions_bulk BST
						inner join matitemlist MIL on MIL.intItemSerial=BST.intMatDetailId
						inner join matmaincategory MMC on MMC.intID=MIL.intMainCatID
						where strMainStoresID='$MstoresId'
						group by BST.intMatDetailId,BST.strColor,BST.strSize,BST.strUnit,BST.intBulkGrnNo,BST.intBulkGrnYear
						having dblQty>0;";
						$result=$db->RunQuery($sql);	
						while ($row=mysql_fetch_array($result))
						{
							
							$allowPendingQty = GetAllowPendingQty($row["intMatDetailId"],$row["strColor"],$row["strSize"],$row["strUnit"],$row["intBulkGrnNo"],$row["intBulkGrnYear"]);
							$dblQty = $row["dblQty"]-$allowPendingQty;
						?>
				<tr class="bcgcolor-tblrowWhite"  onmouseover="this.style.background ='#D6E7F5';" onmouseout="this.style.background='';">
				<td class="normalfnt" id="<?php echo $row["intBulkGrnNo"];  ?>"><div align="center"><input type="checkbox" name="checkbox" id="checkbox"/></div></td>
				<td class="normalfnt" id="<?php echo $row["intBulkGrnYear"];  ?>"><?php echo $row["Material"]; ?></td>
				<td class="normalfnt" id="<?php echo $row["intMatDetailId"];  ?>" ><?php echo $row["Description"]; ?></td>
				<td class="normalfnt"><?php echo $row["strColor"]; ?></td>
				<td class="normalfnt"><?php echo $row["strSize"]; ?></td>
				<td class="normalfnt" style="text-align:right"><?php echo $row["strUnit"]; ?></td>
				<td class="normalfnt" style="text-align:right"><?php echo round($dblQty,2); ?></td>
				<td class="normalfnt"><div align="center"><img src="../images/house.png" onClick="setStockTransaction(this)" alt="del" width="15" height="15" /></div></td>
				<td class="normalfnt" style="text-align:right"><?php echo $row["intBulkGrnNo"]; ?></td>
				<td class="normalfnt" style="text-align:right"><?php echo $row["intBulkGrnYear"]; ?></td>
				</tr>
				<?php
				}
				?>
			</table>
			</div>			</td>
			</tr>
		</table>
	</td>
		</tr>
		<tr>
			<td><table width="100%" border="0" cellspacing="2" cellpadding="0" class="tableBorder">
  <tr>
   <td ><table width="100%" border="0">
		<tr>
			<td align="center"><img height="24" width="86" onclick="LoadDetalisToMainPage();" alt="ok" src="../images/ok.png"><img height="24" width="97" onclick="CloseOSPopUp('popupLayer1');" alt="close" src="../images/close.png"></td>
		</tr>
		</table>
		</td>
  		</tr>
		</table>
	</tr>
	</table>
</body>
</html>
<?php 
function GetAllowPendingQty($matId,$color,$size,$unts,$grnNo,$grnYear)
{
global $db;
$qty = 0;
	$sql="select COALESCE(sum(CBD.dblQty),0) as alowQty from commonstock_bulkdetails CBD inner join commonstock_bulkheader CBH on CBH.intTransferNo=CBD.intTransferNo and CBH.intTransferYear=CBD.intTransferYear where CBH.intStatus=0 and CBD.intMatDetailId='$matId' and CBD.strColor='$color' and CBD.strSize='$size' and CBD.strUnit='$unts' and CBD.intBulkGrnNo='$grnNo' and CBD.intBulkGRNYear='$grnYear'
group by CBD.intMatDetailId";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = round($row["alowQty"],2);
	}
return $qty;
}
?>