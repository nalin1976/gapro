<?php 
session_start();
include "../../../Connector.php";
$backwardseperator = '../../../';
$factoryId = $_SESSION["FactoryID"];
$dateFrom = $_GET["dateFrom"];
$dateTo = $_GET["dateTo"];
$styleId = $_GET["styleId"];
$lineNo = $_GET["lineNo"];
$styleNo = $_GET["styleNo"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | Production Summary Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="950" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">Production Summary Report</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr class="normalfnt">
        <td width="81" height="20"><b>Date From :</b></td>
        <td width="161"><?php echo $dateFrom; ?></td>
        <td width="67"><b>Date To :</b></td>
        <td width="175"><?php echo $dateTo; ?></td>
      </tr>
      <tr class="normalfnt">
      <?php if($styleId != '') {?>
        <td height="20"><b>Order No :</b></td>
        <td><?php  echo getOrderNo($styleId);?></td>
        <?php } 
		if($styleNo != '') {
		?>
        <td><b>Style No:</b></td>
        <td><?php echo $styleNo; ?></td>
        <?php 
		}
		?>
      </tr>
      <tr class="normalfnt">
      <?php if($lineNo != '') {?>
        <td height="20"><b>Line No :</b></td>
        <td><?php echo getLineName($lineNo); ?></td>
        <?php }?>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="9%" rowspan="2">INPUT DATE</th>
        <th width="9%" rowspan="2">LINE</th>
        <th width="8%" rowspan="2">INPUT QTY(Pcs)</th>
        <th height="20" colspan="2">OUTPUT QTY(Pcs)</th>
        <th width="15%" rowspan="2">LINE EFFICIENCY([LINE OUTPUT/LINE INPUT]*100)</th>
        <th width="9%" rowspan="2">WASH READY(PCs)</th>
        <th width="8%" rowspan="2">SENT TO WASH(PCs)</th>
        <th width="13%" rowspan="2">EFFICIENCY([SET TO WASH/LINE INPUT]*100)</th>
        <th width="9%" rowspan="2">BALANCE REMAINING (PCs)</th>
      </tr>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th height="20" >TARGET(PCs)</th>
         <th height="20" >ACTUAL(PCs)</th>
        </tr>
      </thead>
      <?php 
	  $sql_t = "select distinct PLIH.dtmDate,PLIH.strTeamNo from productionlineinputheader PLIH 
	  inner join orders O on O.intStyleId = PLIH.intStyleId
where PLIH.dtmDate between '$dateFrom' and '$dateTo' and PLIH.intFactory='$factoryId' ";
		if($styleId != '')
		$sql_t .= " and PLIH.intStyleId = '$styleId' ";
	if($lineNo != '')
		$sql_t .= " and PLIH.strTeamNo = '$lineNo' ";	
	if($styleNo != '')
		$sql_t .= " and O.strStyle = '$styleNo' ";	
	
	$sql_t .= "  union 
select distinct PLOH.dtmDate,PLOH.strTeamNo from productionlineoutputheader PLOH
 inner join orders O on O.intStyleId = PLOH.intStyleId
where PLOH.dtmDate between '$dateFrom' and '$dateTo' and PLOH.intFactory='$factoryId'";
	if($styleId != '')
		$sql_t .= " and PLOH.intStyleId = '$styleId' ";
	if($lineNo != '')
		$sql_t .= " and PLOH.strTeamNo = '$lineNo' ";	
	if($styleNo != '')
		$sql_t .= " and O.strStyle = '$styleNo' ";	
		
	$sql_t .= " union
select distinct PWRH.dtmDate, PLOH.strTeamNo 
FROM productionwashreadyheader PWRH INNER JOIN productionwashreadydetail PWRD ON
PWRH.intWashreadySerial = PWRD.intWashreadySerial AND PWRH.intWashReadyYear = PWRD.intWashReadyYear 
INNER JOIN productionlineoutdetail PLOD ON PLOD.intCutBundleSerial = PWRD.intCutBundleSerial AND PLOD.dblBundleNo = PWRD.dblBundleNo
INNER JOIN productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial AND PLOH.intLineOutputYear = PLOD.intLineOutputYear
inner join orders O on O.intStyleId = PWRH.intStyleId 
WHERE PWRH.dtmDate BETWEEN '$dateFrom' AND '$dateTo' AND PWRH.intFactory='$factoryId' ";
	if($styleId != '')
		$sql_t .= " and PWRH.intStyleId = '$styleId' ";
	if($lineNo != '')
		$sql_t .= " and PLOH.strTeamNo = '$lineNo' ";	
	if($styleNo != '')
		$sql_t .= " and O.strStyle = '$styleNo' ";	
		
	$sql_t .= " union
select distinct PFGH.dtmGPDate,PLOH.strTeamNo
from productionfggpheader PFGH INNER JOIN  productionfggpdetails PFGD ON PFGH.intGPnumber = PFGD.intGPnumber AND PFGH.intGPYear = PFGD.intGPYear
INNER JOIN productionlineoutdetail PLOD ON PLOD.intCutBundleSerial = PFGD.intCutBundleSerial AND PLOD.dblBundleNo= PFGD.dblBundleNo
INNER JOIN productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial AND PLOH.intLineOutputYear = PLOD.intLineOutputYear
inner join orders O on O.intStyleId = PFGH.intStyleId
where dtmGPDate BETWEEN '$dateFrom' and '$dateTo' and strFromFactory='$factoryId' ";
	if($styleId != '')
		$sql_t .= " and PFGH.intStyleId = '$styleId' ";
	if($lineNo != '')
		$sql_t .= " and PLOH.strTeamNo = '$lineNo' ";	
	if($styleNo != '')
		$sql_t .= " and O.strStyle = '$styleNo' ";	
		
	$sql_t .= " order by dtmDate,strTeamNo ";
	$result_t = $db->RunQuery($sql_t);
//echo $sql_t;
	$mainArray = array();
	$loop=0;
	$fRow = true;
	while($rowT = mysql_fetch_array($result_t))
	{
		$dtmDate = $rowT["dtmDate"];
		$lineId  = $rowT["strTeamNo"];
		
		$result = getLinewiseQtyDetails($dtmDate,$lineId,$factoryId,$styleId);
		$row = mysql_fetch_array($result);
		$lineName = $row["strTeam"];
		
		$lineInQty = $row["LineInQty"];
		$lineOutQty = $row["LineOutQty"];
		$washReadyQty = $row["WashReadyQty"];
		$facGPQty = $row["GPqty"];
		$balQty = $lineInQty-$lineOutQty;
		
		$lineEffciency = round($lineOutQty/$lineInQty*100,2);
		$washEffciency = round($facGPQty/$lineInQty*100,2);
		
	  ?>
      <tr bgcolor="#FFFFFF" class="normalfntRite">
      <?php  if($fRow) {?>
        <td height="20" class="normalfnt"><?php echo $dtmDate; ?></td>
        <?php
			$prevDate = $dtmDate;
		 }
		else
		{
			if($prevDate != $dtmDate) {
				$mainArray[$loop][1] = $prevDate;
				$mainArray[$loop][2] = $dateLineInQty;
				$mainArray[$loop][3] = $dateLineOutQty;
				$mainArray[$loop][4] = $datewashReadyQty;
				$mainArray[$loop][5] = $datefacGPQty;
				$loop++;
				$dateLineInQty  =0;
				$dateLineOutQty =0;
				$datewashReadyQty=0;
				$datefacGPQty=0;
			?>
        		<td class="normalfnt"><?php echo $dtmDate; ?></td>
        		<?php
				 }
				else
				{
				?>
                <td>&nbsp;</td>
        <?php }
				$prevDate = $dtmDate;
			}
			
			
			
		?>
        <td  class="normalfnt"><?php echo $lineName; ?></td>
        <td><?php echo $lineInQty; ?></td>
        <td width="10%">0</td>
        <td width="10%"><?php  echo $lineOutQty; ?></td>
        <td><?php echo $lineEffciency; ?></td>
        <td><?php echo $washReadyQty; ?></td>
        <td><?php echo $facGPQty; ?></td>
        <td><?php echo $washEffciency; ?></td>
        <td><?php echo $balQty; ?></td>
      </tr>
      <?php
	  $fRow=false; 
	  $dateLineInQty += $lineInQty;
	  $dateLineOutQty += $lineOutQty;
	  $datewashReadyQty += $washReadyQty;
	  $datefacGPQty += $facGPQty;
	  	
	  }
	  $mainArray[$loop][1] = $dtmDate;
	  $mainArray[$loop][2] = $dateLineInQty;
	  $mainArray[$loop][3] = $dateLineOutQty;
	  $mainArray[$loop][4] = $datewashReadyQty;
	  $mainArray[$loop][5] = $datefacGPQty;
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt2Black"><b>Summary</b></td>
  </tr>
  <tr>
    <td><table width="850" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="102">DATE</th>
        <th width="111">RECEIVED QTY(PCs)</th>
        <th width="82">INPUT QTY(PCs)</th>
        <th width="86">OUTPUT QTY(PCs)</th>
        <th width="83">WASH READY(PCs)</th>
        <th width="90">SENT TO WASH(PCs)</th>
        <th width="109">BALANCE REMAINING(PCs)</th>
        <th width="146">OVERALL EFFICIENCY([SENT TO WASH/INPUT QTY]*100)</th>
      </tr>
      <?php 
	  
	/*  $sql_p = " SELECT SUM(PGTID.dblQty) AS ProdctTransInQty
FROM productiongptindetail PGTID INNER JOIN productiongptinheader PGTIH ON 
PGTID.dblCutGPTransferIN = PGTIH.dblCutGPTransferIN AND PGTID.intGPTYear = PGTIH.intGPTYear
WHERE PGTIH.dtmGPTransferInDate='$dtmDate' AND PGTIH.intFactoryId='$factoryId' ";
		$result_p = $db->RunQuery($sql_p);
		$rowP = mysql_fetch_array($result_p);
		$ProdctTransInQty = $rowP["ProdctTransInQty"];
		$totBal = $totLineInQty-$totLineOutQty;
		$totEffciency = round($totFacGpQty/$totLineInQty*100,2);*/
		
		for($i=0;$i<count($mainArray);$i++)
		{
			$productLineInQty = $mainArray[$i][2];
			$productLineOutQty = $mainArray[$i][3];
			$productWashReadyQty = $mainArray[$i][4];
			$productGPQty = $mainArray[$i][5];
			
			$productBal = $productLineInQty-$productLineOutQty;
			$productEfficiency = round($productGPQty/$productLineInQty*100,2);
	  ?>
      <tr bgcolor="#FFFFFF" class="normalfntRite">
        <td class="normalfnt"><?php echo $mainArray[$i][1]; ?></td>
        <td><?php  //echo $mainArray[$i][2]; ?></td>
        <td><?php echo $productLineInQty; ?></td>
        <td><?php echo $productLineOutQty; ?></td>
        <td><?php echo $productWashReadyQty;?></td>
        <td><?php echo $productGPQty; ?></td>
        <td><?php echo $productBal; ?></td>
        <td><?php echo $productEfficiency; ?></td>
      </tr>
      <?php 
	  }
	  ?>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php 
function getLinewiseQtyDetails($dtmDate,$lineId,$factoryId,$styleId)
{
	global $db;
	
	$sql = "SELECT PT.strTeam,
(SELECT SUM(PLID.dblQty) FROM productionlineindetail PLID INNER JOIN productionlineinputheader PLIH ON
PLIH.intLineInputSerial = PLID.intLineInputSerial AND PLIH.intLineInputYear= PLID.intLineInputYear
WHERE PLIH.strTeamNo = PT.intTeamNo  AND  PLIH.dtmDate='$dtmDate' AND PLIH.intFactory='$factoryId' ";
	if($styleId != '')
		$sql .= " and PLIH.intStyleId= '$styleId' ";
	$sql .= " ) AS LineInQty,
(SELECT SUM(PLOD.dblQty) FROM productionlineoutdetail PLOD INNER JOIN productionlineoutputheader PLOH ON
PLOD.intLineOutputSerial = PLOH.intLineOutputSerial AND PLOD.intLineOutputYear = PLOH.intLineOutputYear
WHERE PLOH.strTeamNo = PT.intTeamNo  AND PLOH.dtmDate='$dtmDate' AND PLOH.intFactory='$factoryId' ";
	if($styleId != '')
		$sql .= " and PLOH.intStyleId= '$styleId' ";
	$sql .= " ) AS LineOutQty,
(SELECT SUM(PWRD.dblQty) FROM productionwashreadydetail PWRD INNER JOIN productionwashreadyheader PWRH ON
PWRD.intWashreadySerial = PWRH.intWashreadySerial AND PWRD.intWashReadyYear = PWRH.intWashReadyYear 
INNER JOIN productionlineoutdetail PLOD ON PLOD.intCutBundleSerial = PWRD.intCutBundleSerial AND PLOD.dblBundleNo=PWRD.dblBundleNo
INNER JOIN productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial AND PLOH.intLineOutputYear = PLOD.intLineOutputYear
WHERE PLOH.strTeamNo = PT.intTeamNo   AND PWRH.dtmDate ='$dtmDate' AND PWRH.intFactory='$factoryId' ";
	if($styleId != '')
		$sql .= " and PWRH.intStyleId= '$styleId' ";
	$sql .= " ) AS WashReadyQty,
(SELECT SUM(PFGD.dblQty) FROM productionfggpdetails PFGD INNER JOIN productionfggpheader PFGH ON 
PFGH.intGPnumber = PFGD.intGPnumber AND PFGH.intGPYear = PFGD.intGPYear
INNER JOIN productionlineoutdetail PLOD ON PLOD.intCutBundleSerial = PFGD.intCutBundleSerial AND PLOD.dblBundleNo=PFGD.dblBundleNo
INNER JOIN productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial AND PLOH.intLineOutputYear = PLOD.intLineOutputYear
WHERE PLOH.strTeamNo = PT.intTeamNo  AND PFGH.dtmGPDate ='$dtmDate' AND PFGH.strFromFactory='$factoryId' ";
	if($styleId != '')
		$sql .= " and PFGH.intStyleId= '$styleId' ";
	$sql .= " ) AS GPqty
FROM plan_teams PT
WHERE PT.intTeamNo='$lineId' ";
//echo $sql;
	return $db->RunQuery($sql);
}

function getOrderNo($styleId)
{
	global $db;
	$sql = " select strOrderNo from orders where intStyleId='$styleId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
		
	return $row["strOrderNo"];
}

function getLineName($lineNo)
{
	global $db;
	$sql = " select strTeam from plan_teams where intTeamNo='$lineNo' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
		
	return $row["strTeam"];
}

?>