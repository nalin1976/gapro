<?php
session_start();
$backwardseperator 	= "../../";
include('../../Connector.php');
$report_companyId=$_SESSION['FactoryID'];
$date=$_GET['req'];
$factory=$_GET['factory'];
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
<table align="center" width="1200" border="0">

<tr>
 <td width="1152" align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
  <?php 
 /* $sql="SELECT
		was_subcontractout.intCompanyID,
		was_subcontractout.intUser
		from was_subcontractout
		WHERE
		was_subcontractout.intCompanyID = 9 AND
		was_subcontractout.intAODYear='' AND
		was_subcontractout.intAODNo='';";

		$res=$db->RunQuery($sql);*/
	
  include('../../reportHeader.php'); ?>
</td>
</tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">&nbsp;
	
 </td>
 </tr>
<tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">
	DAILY STATUS OF SUB CONTRACT
 </td>
 </tr>
 <tr>
 <td align="center" style="font-family: Arial;	font-size: 12pt;color: #000000;font-weight: bold;">&nbsp;

 </td>
 </tr>
 <tr>
 	<td><table width="1200" border="1" rules="all">
 	  <tr>
 	    <td width="8%" rowspan="2" class="normalfntBtab">PO Number</td>
 	    <td width="8%" rowspan="2" class="normalfntBtab">Style</td>
 	    <td width="8%" rowspan="2" class="normalfntBtab">Color</td>
 	    <td width="5%" rowspan="2" class="normalfntBtab">Order Qty</td>
 	    <td width="5%" rowspan="2" class="normalfntBtab">RCVD QTY</td>
 	    <td width="19%" rowspan="2" class="normalfntBtab">FABRIC ID</td>
 	    <td width="7%" rowspan="2" class="normalfntBtab">SHIPMENT DATE</td>
 	    <td class="normalfntBtab" colspan="2" width="10%"> SEND</td>
 	    <td class="normalfntBtab" colspan="2" width="10%">RECEIVE</td>
 	    <td width="5%" rowspan="2" class="normalfntBtab">BALANCE</td>
 	    <td width="15%" rowspan="2" class="normalfntBtab">Remarks</td>
 	    </tr>
 	  <tr>
 	    <td width="5%" class="normalfntBtab">TODAY</td>
 	    <td width="5%" class="normalfntBtab">CUMULATE</td>
 	    <td width="5%" class="normalfntBtab">TODAY</td>
 	    <td width="5%" class="normalfntBtab">CUMULATE</td>
 	    </tr>
 	  <?php 
		$res=getDets($date,$po,$color,$type,$factory,'was_subcontractout','');
		$otFac='';
		$i=0;
		$cls='';
		while($row=mysql_fetch_assoc($res)){ 
		if($row['strName']=="" || $row['strName']!="$otFac"){
			$outC=0;
			$inC=0;
			($i%2==0)?$cls='grid_raw':$cls='grid_raw2';
			?>
 	  <tr>
 	    <td colspan="13" class="normalfnt" style="background-color:#F4F4F4"><?php echo $row['strName']; $otFac=$row['strName'];?></td>
 	    </tr>
 	  <?php } ?>
 	  <tr>
 	    <td height="22" class="normalfnt"><?php echo $row['strOrderNo'];?></td>
 	    <td class="normalfnt"><?php echo $row['strStyle'];?></td>
 	    <td class="normalfnt"><?php echo $row['strColor'];?></td>
 	    <td class="normalfntRite" ><?php echo $row['intQty'];?></td>
 	    <td class="normalfntRite" ><?php echo getRcvdQty($row['intStyleId']);?></td>
 	    <td class="normalfnt"><?php echo $row['strItemDescription'];?></td>
 	    <td class="normalfnt"><?php echo getShipmentDate($row['intStyleId']);?></td>
 	    <td class="normalfntRite"><?php 
				$tdO=getDets($date,$row['intStyleId'],$row['strColor'],'SubOut',$row['intSubContractNo'],'was_subcontractout',"='".$date."'");
				$r=mysql_fetch_assoc($tdO);
				echo $r['QTY'];
				?></td>
 	    <td class="normalfntRite"><?php 
				$cO=getDets($date,$row['intStyleId'],$row['strColor'],'SubOut',$row['intSubContractNo'],'was_subcontractout'," <= '".$date."'");
				$r=mysql_fetch_assoc($cO);
				echo $outC=$r['QTY'];
				?></td>
 	    <td class="normalfntRite"><?php 
				$tdO=getDets($date,$row['intStyleId'],$row['strColor'],$type,$row['intSubContractNo'],'was_subcontractin',"='".$date."'");
				$r=mysql_fetch_assoc($tdO);
				echo $r['QTY'];
				?></td>
 	    <td class="normalfntRite"><?php 
				$cO=getDets($date,$row['intStyleId'],$color,$type,$row['intSubContractNo'],'was_subcontractin'," <= '".$date."'");
				$r=mysql_fetch_assoc($cO);
				echo $inC=$r['QTY'];
				?></td>
 	    <td class="normalfntRite"><?php echo $outC-$inC?></td>
 	    <td class="normalfnt"><?php ?></td>
 	    </tr>
 	  <?php $i++; } ?>
    </table></td>
 </tr>
</table>
<?php 
function getDets($date,$po,$color,$type,$factory,$tbl,$dt){
	//echo $type."-".$facory;
	global $db;
	$sqlD="SELECT
			Sum(`$tbl`.dblQty) AS QTY,
			O.strOrderNo,
			O.strStyle,
			`$tbl`.strColor,
			O.intQty,
			M.strItemDescription,
			`$tbl`.intSubContractNo,
			was_outside_companies.strName,
			O.intStyleId
			FROM
			orders AS O
			INNER JOIN orderdetails AS OD ON OD.intStyleId = O.intStyleId
			INNER JOIN matitemlist AS M ON M.intItemSerial = OD.intMatDetailID
			INNER JOIN `$tbl` ON `$tbl`.intStyleId = O.intStyleId
			INNER JOIN was_outside_companies ON `$tbl`.intSubContractNo = was_outside_companies.intCompanyID
			WHERE
			OD.intMainFabricStatus = '1' ";
			if(isset($factory))
			$sqlD.="AND `$tbl`.intSubContractNo = '$factory' ";
			
			if(isset($dt)) 
			$sqlD.=" AND DATE(`$tbl`.dtmDate) $dt ";
			
			if(isset($po))
				$sqlD.= " AND O.intStyleId='$po' ";
			
			$sqlD.= "AND `$tbl`.intCompanyID = '".$_SESSION['FactoryID']."'
			 		GROUP BY
					O.strOrderNo,
					`$tbl`.strColor,
					`$tbl`.intSubContractNo;";
					//echo $sqlD;
					return $db->RunQuery($sqlD);
}

function getRcvdQty($po){
	global $db;
	$sql="select sum(dblQty) as RCVDQty from was_stocktransactions where intStyleId='$po' and strType='FTransIn';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['RCVDQty'];
}

function getFab($po){
	global $db;
	
	$sql="SELECT DISTINCT
				matitemlist.strItemDescription
				FROM
				orders
				Inner Join orderdetails ON orders.intStyleId = orderdetails.intStyleId
				Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
				Inner Join was_stocktransactions wst ON wst.intStyleId = orders.intStyleId
				WHERE orders.intStyleId='$po' AND orderdetails.intMainFabricStatus=1;";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return $row['strItemDescription'];
}

function getShipmentDate($po){
	global $db;
	$sql="SELECT d.dtDateofDelivery FROM deliveryschedule d WHERE d.intStyleId='$po';";
	$res=$db->RunQuery($sql);
	$row=mysql_fetch_array($res);
	return substr($row['dtDateofDelivery'],0,10);
}

?>
</body>
</html>
