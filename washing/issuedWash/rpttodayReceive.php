<?php
session_start();
$backwardseperator 	= "../../";
include("{$backwardseperator}Connector.php");
$report_companyId=$_SESSION["FactoryID"];;
$date	=$_GET['date'];
$dateTo	=$_GET['dateTo'];
$factory=$_GET['factory'];
$po		=$_GET['po'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gapro:Washing-Today Receive Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
-->
table
{
	border-spacing:0px;
}
</style>
<script type="text/javascript" src="issuedWash.js"></script>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
</head>
<body>
<table align="center" width="800" border="0">

<tr>
 <td align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
  <?php include("{$backwardseperator}reportHeader.php"); ?>
</td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">&nbsp;
	
 </td>
 </tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">
  Issued to Wash Production Report
 </td>
 </tr>
 <tr>
 	<td>
    <table border="1" width="800" rules="rows">
			<tr>
				<td width="47" class="normalfntBtab">&nbsp;</td>
				<td width="144" class="normalfntBtab">PO Number</td>
				<td width="166" class="normalfntBtab">Style</td>
				<td width="107" class="normalfntBtab">Color</td>
				<td width="69" class="normalfntBtab">Qty(Pcs)</td>
				<td width="227" class="normalfntBtab">Remarks</td>
			</tr>
			<?php 
			$resD=getDets($date,$factory,$dateTo,$po);
			
			$count=1;
			$cls="";
			$total=0;
			$factoryID="";
			$subTot=0;
			$t=1;
			while($rowD=mysql_fetch_array($resD)){ ($count%2==1)?$cls='grid_raw':$cls='grid_raw2';
			$total=$total+$rowD['RCVDQty'];
			$subTot=$subTot+$rowD['RCVDQty'];
			
			//if($rowD['intFromFactory']== $factory){$t=1;}else{$t=0;}
			if($rowD['intFromFactory']!= $factoryID){
				
				$nr=mysql_num_rows(getDets($date,$rowD['intFromFactory'],$dateTo,$po)); //$rowD['Dt']
			?>
			<tr>
			  <td class="normalfnt">Factory-</td>
			  <td colspan="5" class="normalfnt"> <?php echo $rowD['strName']; ?></td>
            </tr>
			<?php }
			
			$factoryID=$rowD['intFromFactory'];
			?>
			<tr>
				<td width="47" class="normalfntR"><?php echo $count;?>&nbsp;</td>
				<td width="144" class="normalfnt"  style="text-align:left"><?php echo $rowD['strOrderNo'];?></td>
				<td width="166" class="normalfnt"  style="text-align:left"><?php echo $rowD['strStyle'];?></td>
				<td width="107" class="normalfnt"  style="text-align:left"><?php echo $rowD['strColor'];?></td>
				<td width="69" class="normalfnt"  style="text-align:right"><?php echo $rowD['RCVDQty'];?>&nbsp;</td>
				<td width="227" class="normalfnt"  style="text-align:left"><?php echo getRemarks($rowD['intStyleId']); ?></td>
			</tr>
			<?php 
			//echo $t."-".$nr;
			if($t==$nr){
			?>
			<tr style="background-color:#FFF;" >
				<td width="47"  style="text-align:left"></td>
				<td width="144"  style="text-align:left">&nbsp;</td>
				<td width="166"  style="text-align:left">&nbsp;</td>
				<td width="107" class="normalfnt" style="text-align:right"><!--Total--></td>
				<td width="69"  class="normalfnt" style="text-align:right"><?php echo $subTot; $subTot=0;$cls="";?>&nbsp;</td>
				<td width="227"  style="text-align:left"></td>
			</tr>
			<?php $t=0; 
			} $t++;
			 $count++; }
			?>
            <tr style="background-color:#FFF;">
				<td width="47"  style="text-align:left">&nbsp;</td>
				<td width="144"  style="text-align:left">&nbsp;</td>
				<td width="166"  style="text-align:left">&nbsp;</td>
				<td width="107" class="normalfnt"  style="text-align:right">TOTAL</td>
				<td width="69"  class="normalfnt" style="text-align:right"><?php echo $total; ?>&nbsp;</td>
				<td width="227" align="center" >&nbsp;</td>
		</tr>
	  </table>
      
    </td>
 </tr>
</table>
<?php 
function getDets($date,$factoryId,$dateTo,$po){
	global $db;
$sqlD="SELECT
					was_stocktransactions.strColor,
					sum(was_stocktransactions.dblQty) as RCVDQty,
					orders.strOrderNo,
					orders.strStyle,
					was_stocktransactions.intFromFactory,
					companies.strName,
					orders.intStyleId,
					DATE(was_stocktransactions.dtmDate) as Dt
					FROM
					was_stocktransactions
					Inner Join orders ON was_stocktransactions.intStyleId = orders.intStyleId 
					inner join companies on companies.intCompanyID= was_stocktransactions.intFromFactory
					WHERE
					was_stocktransactions.strType =  'FTransIn'";
					if($date!=""){ 
						if($dateTo!="")
							$sqlD.=" AND DATE(was_stocktransactions.dtmDate) between '$date' and '$dateTo'";
						else
							$sqlD.=" AND DATE(was_stocktransactions.dtmDate) = '$date'";
					}
					if($factoryId != ""){
						$sqlD.=" and was_stocktransactions.intFromFactory = '$factoryId'"; 
					}
					if($po!=""){
						$sqlD.=" and was_stocktransactions.intStyleId='$po'";
					}
					$sqlD.=" GROUP BY
					was_stocktransactions.intFromFactory,
					-- was_stocktransactions.dtmDate,
					orders.intStyleId,
					was_stocktransactions.strColor;";
					
					return $db->RunQuery($sqlD);
}
function getRemarks($po){
	global $db;
	$sql="SELECT productionfinishedgoodsreceiveheader.strRemarks FROM productionfinishedgoodsreceiveheader Inner Join was_stocktransactions ON  productionfinishedgoodsreceiveheader.dblTransInNo = was_stocktransactions.intDocumentNo AND productionfinishedgoodsreceiveheader.intGPTYear = was_stocktransactions.intDocumentYear WHERE was_stocktransactions.intStyleId =  '$po' AND was_stocktransactions.strType =  'FTransIn';";
	//echo $sql;
	$res=$db->RunQuery($sql);
	$arrRemarks=array();
	$c=0;
	while($row=mysql_fetch_array($res)){
		$arrRemarks[$c]=$row['strRemarks'];
		$c++;
	}
	return implode(',',$arrRemarks);
}
?>
</body>
</html>
