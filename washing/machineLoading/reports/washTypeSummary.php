<?php
session_start();
$backwardseperator 	= "../../../";
include($backwardseperator.'Connector.php');
$report_companyId=$_SESSION['FactoryID'];
$datefrom	= $_REQUEST['datefrom'];
$dateto		= $_REQUEST['dateto'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gapro:Washing-Wash Summary Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
-->
table
{
	border-spacing:0px;
}
</style>
</head>

<body>
<table align="center" width="900" border="0">
	<tr>
		<td align="center"  colspan="5">
		<?php include($backwardseperator.'reportHeader.php'); ?>
		</td>
	</tr>
    <tr>
 		<td align="center" colspan="5" class="head2">

 		</td>
 	</tr>
	<tr>
 		<td align="center" colspan="5" class="head2">
			Wash Summary
 		</td>
 	</tr>
    <tr>
 		<td align="center" colspan="5" class="head2">

 		</td>
 	</tr>
 	<tr>
 		<td width="166" align="right" class="normalfnt">Summarized by:</td>
		<td width="210" align="left" class="normalfnt">Wash Types for the period from :</td>
		<td width="82" class="normalfnt"><?php  echo $datefrom;?></td>
		<td width="35" class="normalfnt">To :</td>
		<td width="268" class="normalfnt"><?php echo $dateto;?></td>
 	</tr>
	<tr>
		<td colspan="5">
			<table border="1" rules="all" width="800">
				<tr>
					<td style="">&nbsp;</td>
					<?php 
					$res=getWashTypes();
					$nrs=mysql_num_rows($res);
					$arrWid=array();
					$c=0;
					while($row=mysql_fetch_array($res)){
						$arrWid[$c]=$row['intWasID'];
						?>
							
							<td class="normalfnt" style="width:<?php echo strlen($row['strWasType'])*5;?>px;"><?php echo $row['strWasType']; ?></td>
					<?php  $c++;} ?>
                    <td style="width:20px;" class="normalfnt">Total</td>
				</tr>
				<?php 
				$res1= getFactories();
					while($row=mysql_fetch_array($res1)){
				?>
				<tr>
					<td class="normalfnt" style="width:<?php echo strlen($row['strName'])*10;?>px;"><?php echo $row['strName']; ?></td>
					<?php 
					$fTot=0;
						for( $i=0; $i<$nrs;$i++){ ?> 
							<td class="normalfntR">
							<?php 
								echo $tot= getWashSum($arrWid[$i],$row['intFromFactory'],$row['intStyleId'],$datefrom,$dateto);
								$fTot= $fTot+$tot;

							?></td>
						<?php 	} ?>
                        <td class="normalfntR"><?php echo $fTot;?></td>
				</tr>
                <?php }?>
                <tr>
                <td class="normalfnt">Total</td>
                <?php 
				$res3=getWashTypes();
				$cTot=0;
				while($row=mysql_fetch_array($res3)){ ?>
					<td class="normalfntR">
					<?php 
						echo $wTot=getTotWashSum($row['intWasID'],$datefrom,$dateto);
						$cTot=$cTot+$wTot;
					?></td>
			   <?php }?>
               <td class="normalfntR"><?php echo $cTot;?></td>
                </tr>
			</table>
		</td>
	</tr>
</table>
<?php 
function getWashTypes(){
	global $db;
	$sql="SELECT DISTINCT was_washtype.intWasID,was_washtype.strWasType FROM was_machineloadingheader Inner Join was_washtype ON was_machineloadingheader.intWashType = was_washtype.intWasID;";
	return $db->RunQuery($sql);
}

function getWashSum($wType,$factory,$styleId,$datefrom,$dateto){
	global $db;
	/*$sql="SELECT
COALESCE(Sum(was_machineloadingheader.dblQty),0) as QTY
FROM
was_machineloadingheader
WHERE
was_machineloadingheader.intWashType =  '$wType' AND
was_machineloadingheader.dtmInDate BETWEEN  '$datefrom' AND '$dateto' AND
was_machineloadingheader.intStyleId =  '$styleId'
AND 
was_machineloadingheader.intStyleId =(select distinct wst.intStyleId 
from was_stocktransactions wst where wst.strType='FTransIn'  and wst.intFromFactory='$factory');";*/
	$sql="SELECT
COALESCE(Sum(was_machineloadingheader.dblQty),0) as QTY
FROM
was_machineloadingheader
INNER JOIN was_actualcostheader ON was_machineloadingheader.intStyleId = was_actualcostheader.intStyleId AND was_machineloadingheader.intCostId = was_actualcostheader.intSerialNo
WHERE
was_machineloadingheader.intWashType = '$wType' AND
date(was_machineloadingheader.dtmInDate) BETWEEN '$datefrom' AND '$dateto' -- AND was_machineloadingheader.intStyleId = '$styleId' 
 AND was_machineloadingheader.intStatus=1
and 
was_actualcostheader.intCustomerId='$factory';";
//echo $sql;
	 $res=$db->RunQuery($sql);
	 $row=mysql_fetch_array($res);
	 return $row['QTY'];
}

function getFactories(){
	global $db;
	$sql="select distinct wst.intFromFactory,c.strName,wst.intStyleId 
from was_stocktransactions wst
inner join companies c on c.intCompanyId=wst.intFromFactory 
where wst.strType='FTransIn';";	
	return $db->RunQuery($sql);
}

function getTotWashSum($wType,$datefrom,$dateto){
	global $db;
	$sql="SELECT
COALESCE(Sum(was_machineloadingheader.dblQty),0) as QTY
FROM
was_machineloadingheader
WHERE
was_machineloadingheader.intWashType =  '$wType' AND
was_machineloadingheader.dtmInDate BETWEEN  '$datefrom' AND '$dateto' AND was_machineloadingheader.intStatus=1";
//echo $sql;
 $res=$db->RunQuery($sql);
	 $row=mysql_fetch_array($res);
	 return $row['QTY'];
}
?>
 
</body>
</html>
