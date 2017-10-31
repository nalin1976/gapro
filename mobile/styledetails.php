<?php
include "mobiauthentication.inc";
ob_start();
include "../helapreorderReport.php";
ob_get_clean();
 session_start();
$styleNo = $_GET["styleID"];
$userIDNO = $_SESSION["UserID"] ;
?>
<html>
<head><title>ePlan Mobile</title></head>
<body>
	<table>
	<tr>
		<td colspan="3">Welcome - ePlan Mobile</td>
	</tr>
	<tr>
		<td colspan="3" >&nbsp;</td>	
	</tr>
	<tr>
		<td colspan="3">Style : <?php echo $styleNo;
		$sql= "SELECT intStatus FROM orders WHERE intStyleId = '$styleNo';";

		$result = $db->RunQuery($sql);
		$canApprove = false;
	while($row = mysql_fetch_array($result))
	{
		if ($row["intStatus"] == 10)
		{
			
			$canApprove = true;
		}
		break;		
	}
		 ?></td>	
	</tr>
	<?php
	if($canApprove)
	{
	?>
	<tr>
		<td colspan="3">User : <?php echo $mobileMerchandiser ;?></td>	
	</tr>
	<tr>
		<td>Odr. Qty.</td>	
		<td> : </td>
		<td><?php echo $mobileOdrQty ;?></td>
	</tr>
	<tr>
		<td>Exc. Qty.</td>	
		<td> : </td>
		<td><?php echo $mobileecessxqty ;?></td>
	</tr>
<tr>
		<td>Tot. Qty.</td>
		<td> : </td>
		<td><?php echo $mobiletotalqty ;?></td>
	</tr>
	<tr>
		<td>Sub. Qty.</td>
		<td> : </td>	
		<td><?php echo $mobilesubQty ;?></td>
	</tr>
	<tr>
		<td>Eff. Level</td>
		<td> : </td>	
		<td><?php echo $mobileEfflevel ;?>%</td>
	</tr>
<tr>
		<td>SMV</td>
		<td> : </td>	
		<td><?php echo $mobileSMV ;?></td>
	</tr>
<tr>
		<td>SMV Rate</td>	
		<td> : </td>
		<td><?php echo $mobileSMVRate ;?></td>
	</tr>
	<tr>
		<td>Profit</td>	
		<td> : </td>
		<td><?php echo $mobileProfit ;?>%</td>
	</tr>
	<tr>
		<td>Fac. OH/UM</td>
		<td> : </td>	
		<td><?php echo $mobileFACOHUM ;?></td>
	</tr>
	<tr>
		<td>GP/FOB</td>
		<td> : </td>	
		<td><?php echo $mobileGPFOB ;?>%</td>
	</tr>
	<tr>
		<td>GP/CM</td>	
		<td> : </td>
		<td><?php echo $mobileGPCM ;?>%</td>
	</tr>
<tr>
		<td>Fin + ESC</td>	
		<td> : </td>
		<td><?php echo $mobileFINESC ;?></td>
	</tr>
	<tr>
		<td>Direct Cost</td>	
		<td> : </td>
		<td><?php echo $mobileDirectCOst ;?></td>
	</tr>
	<tr>
		<td>CM + UP chge.</td>	
		<td> : </td>
		<td><?php echo $mobileCMUp ;?></td>
	</tr>
	<tr>
		<td>LAB/SUB OH</td>	
		<td> : </td>
		<td><?php echo $mobileLabSUb ;?></td>
	</tr>
	<tr>
		<td>Corp. Cost</td>	
		<td> : </td>
		<td><?php echo $mobileCorpCost ;?></td>
	</tr>
	<tr>
		<td>Net. Mrgn</td>
		<td> : </td>	
		<td><?php echo $mobileNetMargin ;?></td>
	</tr>
	<tr>
		<td>FOB</td>	
		<td> : </td>
		<td><?php echo $mobileFOB ;?></td>
	</tr>
	<tr>
		<td>Cost Of Sale</td>	
		<td> : </td>
		<td><?php echo $mobileCOstOfSale ;?></td>
	</tr>
<tr>
		<td>Tot. Cost</td>	
		<td> : </td>
		<td><?php echo $mobileTotCost ;?></td>
	</tr>
	<tr>	
	<td colspan="3">
	<table width="100%">
		<tr>
		<td style="text-align:left"><a href="../approvedResult.php?StyleID=<?php echo $styleNo; ?>&UesrID=<?php echo $userIDNO; ?>&Remarks=&AppState=1">Approve</a></td>
		<td style="text-align:right"><a href="../approvedResult.php?StyleID=<?php echo $styleNo; ?>&UesrID=<?php echo $userIDNO; ?>&Remarks=&AppState=0">Reject</a></td>
		</tr>
	</table>	
	</td>
	</tr>
	
	<?php 
	}
	else
	{
		echo "Sorry! You can't approve this style.";
	}
	?>
	</table>
</body>
</html>