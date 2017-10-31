<?php 
session_start();
include "../../../Connector.php";
$backwardseperator = '../../../';
$factoryId = $_SESSION["FactoryID"];
$dtmFromDate = $_GET["dateFrom"];
$dtmToDate = $_GET["dateTo"];
$styleId = $_GET["styleId"];
$cutNo = $_GET["cutNo"];
$lineNo = $_GET["lineNo"];
$styleNo = $_GET["styleNo"];
$bundleNo = $_GET["bundleNo"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | Bundle Movement Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="1500" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">BUNDLE MOVEMENT REPORT</td>
  </tr>
  <tr>
    <td><table width="500" border="0" cellspacing="0" cellpadding="2">
      <tr class="normalfnt">
        <td width="78" height="20"><b>Date From :</b></td>
        <td width="183"><?php echo $dtmFromDate; ?></td>
        <td width="63"><b>Date To:</b></td>
        <td width="160"><?php echo $dtmToDate; ?></td>
      </tr>
      <tr class="normalfnt">
      <?php if($styleId != ''){?>
        <td height="20"><b>Order No :</b></td>
        <td><?php  echo getOrderNo($styleId);?></td>
        <?php } 
		if($styleNo != '')
		{
		?>
        <td><b>Style No :</b></td>
        <td><?php echo $styleNo; ?></td>
        <?php }?>
      </tr>
      <tr class="normalfnt">
      	<?php if($cutNo != '') {?>
        <td height="20"><b>Cut No :</b></td>
        <td><?php echo getCutNo($styleId,$cutNo); ?></td>
        <?php 
		}
		if($lineNo != '')
		{
		?>
        <td><b>Line No :</b></td>
        <td><?php echo getLineName($lineNo); ?></td>
        <?php 
		}
		?>
      </tr>
      <tr class="normalfnt">
      <?php if($bundleNo != '') {?>
        <td><b>Bundle No :</b></td>
        <td><?php echo $bundleNo; ?></td>
        <?php }?>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="7%">PO #</th>
        <th width="8%">STYLE #</th>
        <th width="12%">STYLE DESCRIPTION</th>
        <th width="11%">PATTEREN</th>
        <th width="7%">COLOR</th>
        <th width="4%">ORDER QTY(PCs)</th>
        <th width="5%">LINE</th>
        <th width="2%">CUT #</th>
        <th width="4%">BUNDLE NO</th>
        <th width="2%">SIZE</th>
        <th width="4%">BUNDLE RANGE</th>
        <th width="4%">CUT QTY(PCs)</th>
        <th width="5%">RECEIVED QTY(PCs)</th>
        <th width="5%">VARIENCE</th>
        <th width="4%">INPUT QTY(PCs)</th>
        <th width="4%">OUTPUT QTY(PCs)</th>
        <th width="3%">WASH READY (PCs)</th>
        <th width="3%">SENT TO WASH (PCs)</th>
        <th width="6%">BALANCE REMAINING (PCs)</th>
      </tr>
      </thead>
      <?php 
	  $sql_s = "select distinct PLIH.intStyleId,strTeamNo,PT.strTeam 
from productionlineinputheader PLIH INNER JOIN plan_teams PT ON PT.intTeamNo = PLIH.strTeamNo
inner join orders O on O.intStyleId = PLIH.intStyleId
where PLIH.dtmDate between '$dtmFromDate' and '$dtmToDate' and intFactory='$factoryId' ";
	if($styleId != '')
		$sql_s .= " and PLIH.intStyleId = '$styleId' ";
	if($lineNo != '')
		$sql_s .= " and strTeamNo = '$lineNo' ";
	if($styleNo != '')
		$sql_s .= " and O.strStyle = '$styleNo' ";
				
		$sql_s .=" union 
select distinct PLOH.intStyleId,strTeamNo,PT.strTeam 
from productionlineoutputheader PLOH INNER JOIN plan_teams PT ON PT.intTeamNo = PLOH.strTeamNo
inner join orders O on O.intStyleId = PLOH.intStyleId
 where PLOH.dtmDate='$dtmFromDate' and  '$dtmToDate' and intFactory='$factoryId' ";
 	if($styleId != '')
		$sql_s .= " and PLOH.intStyleId = '$styleId' ";
	if($lineNo != '')
		$sql_s .= " and strTeamNo = '$lineNo' ";	
	if($styleNo != '')
		$sql_s .= " and O.strStyle = '$styleNo' ";	
			
 	$sql_s .= " union
select distinct PWRH.intStyleId, PLOH.strTeamNo,PT.strTeam 
FROM productionwashreadyheader PWRH INNER JOIN productionwashreadydetail PWRD ON
PWRH.intWashreadySerial = PWRD.intWashreadySerial AND PWRH.intWashReadyYear = PWRD.intWashReadyYear INNER JOIN productionlineoutdetail PLOD ON
PLOD.intCutBundleSerial = PWRD.intCutBundleSerial AND PLOD.dblBundleNo = PWRD.dblBundleNo INNER JOIN productionlineoutputheader PLOH ON
PLOH.intLineOutputSerial = PLOD.intLineOutputSerial AND PLOH.intLineOutputYear = PLOD.intLineOutputYear 
INNER JOIN plan_teams PT ON PT.intTeamNo = PLOH.strTeamNo
inner join orders O on O.intStyleId = PWRH.intStyleId
WHERE PWRH.dtmDate BETWEEN '$dtmFromDate' AND '$dtmToDate' AND PWRH.intFactory='$factoryId' ";
	if($styleId != '')
		$sql_s .= " and PWRH.intStyleId = '$styleId' ";
	if($lineNo != '')
		$sql_s .= " and PLOH.strTeamNo = '$lineNo' ";
	if($styleNo != '')
		$sql_s .= " and O.strStyle = '$styleNo' ";	
				
	$sql_s .= " union
select distinct PFGH.intStyleId,PLOH.strTeamNo,PT.strTeam 
from productionfggpheader PFGH INNER JOIN  productionfggpdetails PFGD ON PFGH.intGPnumber = PFGD.intGPnumber AND PFGH.intGPYear = PFGD.intGPYear
INNER JOIN productionlineoutdetail PLOD ON PLOD.intCutBundleSerial = PFGD.intCutBundleSerial AND PLOD.dblBundleNo= PFGD.dblBundleNo
INNER JOIN productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial AND PLOH.intLineOutputYear = PLOD.intLineOutputYear
INNER JOIN plan_teams PT ON PT.intTeamNo = PLOH.strTeamNo
inner join orders O on O.intStyleId = PFGH.intStyleId 
where dtmGPDate='$dtmFromDate' and '$dtmToDate' and strFromFactory='$factoryId' ";
if($styleId != '')
		$sql_s .= " and PFGH.intStyleId = '$styleId' ";
if($lineNo != '')
		$sql_s .= " and PLOH.strTeamNo = '$lineNo' ";	
if($styleNo != '')
		$sql_s .= " and O.strStyle = '$styleNo' ";					
		$sql_s .= " order by strTeamNo,intStyleId";
	//echo $sql_s;	
$result_s = $db->RunQuery($sql_s);
while($rowS = mysql_fetch_array($result_s))
{
	//$dtmDate = $rowS["dtmDate"];
	$lineId = $rowS["strTeamNo"];
	$styleId = $rowS["intStyleId"];
	
	$sql = "SELECT  O.strOrderNo,O.strStyle,O.strDescription,O.intQty,PBH.strCutNo,PBH.strColor,PBH.strPatternNo,O.intStyleId,
PBD.dblPcs,PBD.dblBundleNo,PBD.strSize,PBD.strNoRange,PBH.intCutBundleSerial,
(SELECT SUM(PLID.dblQty) FROM productionlineindetail PLID INNER JOIN productionlineinputheader PLIH ON
PLIH.intLineInputSerial = PLID.intLineInputSerial AND PLIH.intLineInputYear= PLID.intLineInputYear
WHERE PLIH.intStyleId = O.intStyleId AND PBH.intCutBundleSerial= PLID.intCutBundleSerial AND PBD.dblBundleNo = PLID.dblBundleNo AND PLIH.intFactory='$factoryId'
AND  PLIH.dtmDate between '$dtmFromDate' and '$dtmToDate' AND PLIH.strTeamNo='$lineId' and PLIH.intStatus!=10
) AS LineInQty,
(SELECT SUM(PLOD.dblQty) FROM productionlineoutdetail PLOD INNER JOIN productionlineoutputheader PLOH ON
PLOD.intLineOutputSerial = PLOH.intLineOutputSerial AND PLOD.intLineOutputYear = PLOH.intLineOutputYear
WHERE PLOH.intStyleId = O.intStyleId AND PBH.intCutBundleSerial= PLOD.intCutBundleSerial AND PBD.dblBundleNo = PLOD.dblBundleNo AND  PLOH.intFactory='$factoryId' 
AND PLOH.dtmDate between '$dtmFromDate' and '$dtmToDate' AND PLOH.strTeamNo='$lineId') AS LineOutQty,
(SELECT SUM(PWRD.dblQty) FROM productionwashreadydetail PWRD INNER JOIN productionwashreadyheader PWRH ON
PWRD.intWashreadySerial = PWRH.intWashreadySerial AND PWRD.intWashReadyYear = PWRH.intWashReadyYear 
INNER JOIN productionlineoutdetail PLOD ON PLOD.intCutBundleSerial = PWRD.intCutBundleSerial AND PLOD.dblBundleNo=PWRD.dblBundleNo
INNER JOIN productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial AND PLOH.intLineOutputYear = PLOD.intLineOutputYear
WHERE PWRH.intStyleId = O.intStyleId AND PBH.intCutBundleSerial =PWRD.intCutBundleSerial AND PBD.dblBundleNo = PWRD.dblBundleNo  AND 
PWRH.dtmDate between '$dtmFromDate' and '$dtmToDate' AND PLOH.strTeamNo='$lineId' AND  PWRH.intFactory= '$factoryId') AS WashReadyQty,
(SELECT SUM(PFGD.dblQty) FROM productionfggpdetails PFGD INNER JOIN productionfggpheader PFGH ON 
PFGH.intGPnumber = PFGD.intGPnumber AND PFGH.intGPYear = PFGD.intGPYear
INNER JOIN productionlineoutdetail PLOD ON PLOD.intCutBundleSerial = PFGD.intCutBundleSerial AND PLOD.dblBundleNo=PFGD.dblBundleNo
INNER JOIN productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial AND PLOH.intLineOutputYear = PLOD.intLineOutputYear
WHERE PFGH.intStyleId=O.intStyleId AND PBH.intCutBundleSerial =PFGD.intCutBundleSerial AND PBD.dblBundleNo = PFGD.dblBundleNo
AND PFGH.dtmGPDate between '$dtmFromDate' and '$dtmToDate' AND PLOH.strTeamNo='$lineId' AND PFGH.strFromFactory='$factoryId') AS GPqty,
(SELECT SUM(PGPTD.dblQty) FROM productiongptindetail PGPTD 
INNER JOIN productiongptinheader PGPTH ON 
PGPTH.dblCutGPTransferIN = PGPTD.dblCutGPTransferIN AND PGPTH.intGPTYear = PGPTD.intGPTYear
WHERE PGPTD.intCutBundleSerial=PBH.intCutBundleSerial AND PGPTD.dblBundleNo = PBD.dblBundleNo 
and  PGPTH.dtmGPTransferInDate between '$dtmFromDate' and '$dtmToDate' AND PGPTH.intFactoryId='$factoryId') AS transQty	
FROM orders O 
INNER JOIN productionbundleheader PBH ON O.intStyleId = PBH.intStyleId
INNER JOIN productionbundledetails PBD ON PBD.intCutBundleSerial= PBH.intCutBundleSerial 
WHERE O.intStyleId='$styleId' ";
if($cutNo !='')
	$sql .= " and PBH.intCutBundleSerial = '$cutNo' ";
if($bundleNo != '')
	$sql .= " and PBD.dblBundleNo = '$bundleNo' ";	
	$result = $db->RunQuery($sql);
	
	$fRow=true;
	$mainArray = array();
	$loop=0;
	
	while($row = mysql_fetch_array($result))
	{
		$LineInQty =$row["LineInQty"];
		$LineOutQty = $row["LineOutQty"];
		$WashReadyQty = $row["WashReadyQty"]; 
		$GPqty = $row["GPqty"]; 
		$transQty = $row["transQty"]; 
		
		$intCutBundleSerial = $row["intCutBundleSerial"]; 
		$totQty = $LineInQty+$LineOutQty+$WashReadyQty+$GPqty;
		if($totQty>0)
		{
			
			$orderNo = $row["strOrderNo"];
			$style = $row["strStyle"];
			$styleDesc = $row["strDescription"];
			$orderQty = $row["intQty"];
			
			
			$balQty = $LineInQty-$LineOutQty;
			if($fRow)
			{
				$preCutBundleSerial = $intCutBundleSerial;
				$fRow=false;
			}
			else
			{
				if($preCutBundleSerial != $intCutBundleSerial)
				{
					$mainArray[$loop][1] = $orderNo;
					$mainArray[$loop][2] = $style;
					$mainArray[$loop][3] = $styleDesc;
					$mainArray[$loop][4] = $orderQty;
					$mainArray[$loop][5] = $cutNo;
					$mainArray[$loop][6] = $cutQty;
					$mainArray[$loop][7] = $cuttransQty;
					$mainArray[$loop][8] = $cutLineInQty;
					$mainArray[$loop][9] = $cutLineOutQty;
					$mainArray[$loop][10] = $cutWashReadyQty;
					$mainArray[$loop][11] = $cutGPqty;
					$mainArray[$loop][12] = $cuttransQty;
					
					$loop++;
					$cutQty  =0;
					$cuttransQty =0;
					$cutLineInQty=0;
					$cutLineOutQty=0;
					$cutGPqty=0;
					$cuttransQty=0;
					$cutWashReadyQty=0;
				}
				
			}
	  ?>
      <tr bgcolor="#FFFFFF" class="normalfntRite">
        <td height="20" class="normalfnt"><?php echo $row["strOrderNo"]; ?></td>
        <td class="normalfnt"><?php echo $row["strStyle"]; ?></td>
        <td class="normalfnt"><?php echo $row["strDescription"]; ?></td>
        <td class="normalfnt"><?php echo $row["strPatternNo"]; ?></td>
        <td class="normalfnt"><?php echo $row["strColor"]; ?></td>
        <td><?php echo $row["intQty"]; ?></td>
        <td class="normalfnt"><?php echo $rowS["strTeam"]; ?></td>
        <td class="normalfnt"><?php echo $row["strCutNo"]; ?></td>
        <td ><?php echo $row["dblBundleNo"]; ?></td>
        <td class="normalfnt"><?php echo $row["strSize"]; ?></td>
        <td class="normalfnt"><?php echo $row["strNoRange"]; ?></td>
        <td><?php echo $row["dblPcs"]; ?></td>
        <td><?php echo $row["transQty"]; ?></td>
        <td><?php echo $row["dblPcs"]-$row["transQty"];  ?></td>
        <td><?php echo $LineInQty ?></td>
        <td><?php echo $LineOutQty ?></td>
         <td><?php echo $WashReadyQty ?></td>
        <td><?php echo $GPqty ?></td>
        <td><?php echo $balQty; ?></td>
      </tr>
      <?php
	  	$cutNo = $row["strCutNo"];
	  		$cutQty += $row["dblPcs"];
			$cutLineInQty += $LineInQty;
			$cutLineOutQty += $LineOutQty;
			$cutWashReadyQty += $WashReadyQty;
			$cutGPqty += $GPqty; 
			$cuttransQty += $transQty;
			$preCutBundleSerial=$intCutBundleSerial;
		}
	  } 
	}
	
	$mainArray[$loop][1] = $orderNo;
	$mainArray[$loop][2] = $style;
	$mainArray[$loop][3] = $styleDesc;
	$mainArray[$loop][4] = $orderQty;
	$mainArray[$loop][5] = $cutNo;
	$mainArray[$loop][6] = $cutQty;
	$mainArray[$loop][7] = $cuttransQty;
	$mainArray[$loop][8] = $cutLineInQty;
	$mainArray[$loop][9] = $cutLineOutQty;
	$mainArray[$loop][10] = $cutWashReadyQty;
	$mainArray[$loop][11] = $cutGPqty;
	$mainArray[$loop][12] = $cuttransQty;
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
    <td><table width="1050" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="81">PO #</th>
        <th width="101">STYLE #</th>
        <th width="150">STYLE DESCRIPTION</th>
        <th width="75">ORDER QTY(PCs)</th>
        <th width="68">CUT #</th>
        <th width="63">CUT QTY(PCs)</th>
        <th width="76">RECEIVED QTY(PCs)</th>
        <th width="55">INPUT QTY(PCs)</th>
        <th width="65">OUTPUT QTY(PCs)</th>
        <th width="74">WASH READY(PCs)</th>
        <th width="83">SENT TO WASH(PCs)</th>
        <th width="98">BALANCE REMAINING (PCs)</th>
      </tr>
      <?php 
	  for($i=0;$i<count($mainArray);$i++)
		{
			$productLineInQty = $mainArray[$i][8];
			$productLineOutQty = $mainArray[$i][9];
			$productBal = $productLineInQty-$productLineOutQty;
	  ?>
      <tr bgcolor="#FFFFFF" class="normalfntRite">
        <td height="20" class="normalfnt"><?php echo $mainArray[$i][1]; ?></td>
        <td class="normalfnt"><?php echo $mainArray[$i][2]; ?></td>
        <td class="normalfnt"><?php echo $mainArray[$i][3]; ?></td>
        <td><?php echo $mainArray[$i][4]; ?></td>
        <td class="normalfnt"><?php echo $mainArray[$i][5]; ?></td>
        <td><?php echo $mainArray[$i][6]; ?></td>
        <td><?php echo $mainArray[$i][7]; ?></td>
        <td><?php echo $productLineInQty; ?></td>
        <td><?php echo $productLineOutQty; ?></td>
        <td><?php echo $mainArray[$i][10]; ?></td>
        <td><?php echo $mainArray[$i][11]; ?></td>
        <td><?php echo $productBal; ?></td>
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
function getOrderNo($styleId)
{
	global $db;
	$sql = " select strOrderNo from orders where intStyleId='$styleId' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
		
	return $row["strOrderNo"];
}

function getCutNo($styleId,$cutNo)
{
	global $db;
	$sql = "select  strCutNo from productionbundleheader where intStyleId='$styleId'  and intCutBundleSerial='$cutNo' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
		
	return $row["strCutNo"];
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