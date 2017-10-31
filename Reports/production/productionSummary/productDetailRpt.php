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
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | Production Detail Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1600" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="36" class="head2">PRODUCTION DETAIL REPORT</td>
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
        <th width="89" rowspan="2">PO #</th>
        <th width="100" rowspan="2">STYLE #</th>
        <th width="145" rowspan="2">STYLE DESCRIPTION</th>
        <th width="66" rowspan="2">PATTEREN</th>
        <th width="72" rowspan="2">COLOR</th>
        <th width="60" rowspan="2">ORDER QTY(PCs)</th>
        <th width="81" rowspan="2">INPUT DATE</th>
        <th width="51" rowspan="2">CUT #</th>
        <th width="67" rowspan="2">RECEIVED QTY(PCs)</th>
        <th width="58" rowspan="2">LINE</th>
        <th width="71" rowspan="2">INPUT QTY(PCs)</th>
        <th colspan="2">OUTPUT QTY(PCs)</th>
        <th width="123" rowspan="2">LINE EFFICIENCY([LINE OUTPUT/LINE INPUT]*100)</th>
        <th width="77" rowspan="2">WASH READY(PCs)</th>
        <th width="83" rowspan="2">SENT TO WASH(PCs)</th>
        <th width="109" rowspan="2">EFFICIENCY ([SET TO WASH/LINE INPUT]*100)</th>
        <th width="83" rowspan="2">BALANCE REMAINING (PCs)</th>
      </tr>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="85">TARGET(PCs)</th>
        <th width="85">ACTUAL(PCs)</th>
        </tr>
       </thead> 
      <?php 
	  	$sql_s = "select distinct PLIH.intStyleId,PLIH.dtmDate,strTeamNo,PT.strTeam 
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
select distinct PLOH.intStyleId,PLOH.dtmDate,strTeamNo,PT.strTeam 
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
select distinct PWRH.intStyleId,PWRH.dtmDate, PLOH.strTeamNo,PT.strTeam 
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
select distinct PFGH.intStyleId,PFGH.dtmGPDate,PLOH.strTeamNo,PT.strTeam 
from productionfggpheader PFGH INNER JOIN  productionfggpdetails PFGD ON PFGH.intGPnumber = PFGD.intGPnumber AND PFGH.intGPYear = PFGD.intGPYear
INNER JOIN productionlineoutdetail PLOD ON PLOD.intCutBundleSerial = PFGD.intCutBundleSerial AND PLOD.dblBundleNo= PFGD.dblBundleNo
INNER JOIN productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial AND PLOH.intLineOutputYear = PLOD.intLineOutputYear
INNER JOIN plan_teams PT ON PT.intTeamNo = PLOH.strTeamNo
inner join orders O on O.intStyleId = PFGH.intStyleId 
where dtmGPDate BETWEEN '$dtmFromDate' and '$dtmToDate' and strFromFactory='$factoryId' ";
if($styleId != '')
		$sql_s .= " and PFGH.intStyleId = '$styleId' ";
if($lineNo != '')
		$sql_s .= " and PLOH.strTeamNo = '$lineNo' ";	
if($styleNo != '')
		$sql_s .= " and O.strStyle = '$styleNo' ";					
		$sql_s .= " order by dtmDate,strTeamNo,intStyleId";
	//echo $sql_s;	
$result_s = $db->RunQuery($sql_s);
while($rowS = mysql_fetch_array($result_s))
{
	$styleId = $rowS["intStyleId"];
	$lineId = $rowS["strTeamNo"];
	$dtmDate = $rowS["dtmDate"];
	
	$sql = "SELECT  O.strOrderNo,O.strStyle,O.strDescription,O.intQty,PBH.strCutNo,PBH.strColor,PBH.strPatternNo,O.intStyleId,
(SELECT SUM(PLID.dblQty) FROM productionlineindetail PLID INNER JOIN productionlineinputheader PLIH ON
PLIH.intLineInputSerial = PLID.intLineInputSerial AND PLIH.intLineInputYear= PLID.intLineInputYear
WHERE PLIH.intStyleId = O.intStyleId AND PBH.intCutBundleSerial= PLID.intCutBundleSerial AND  PLIH.dtmDate='$dtmDate' AND PLIH.strTeamNo='$lineId' and PLIH.intStatus!=10 AND PLIH.intFactory='$factoryId'
) AS LineInQty,
(SELECT SUM(PLOD.dblQty) FROM productionlineoutdetail PLOD INNER JOIN productionlineoutputheader PLOH ON
PLOD.intLineOutputSerial = PLOH.intLineOutputSerial AND PLOD.intLineOutputYear = PLOH.intLineOutputYear
WHERE PLOH.intStyleId = O.intStyleId AND PBH.intCutBundleSerial= PLOD.intCutBundleSerial AND PLOH.dtmDate='$dtmDate' AND PLOH.strTeamNo='$lineId' AND  PLOH.intFactory='$factoryId') AS LineOutQty,
(SELECT SUM(PWRD.dblQty) FROM productionwashreadydetail PWRD INNER JOIN productionwashreadyheader PWRH ON
PWRD.intWashreadySerial = PWRH.intWashreadySerial AND PWRD.intWashReadyYear = PWRH.intWashReadyYear 
INNER JOIN productionlineoutdetail PLOD ON PLOD.intCutBundleSerial = PWRD.intCutBundleSerial AND PLOD.dblBundleNo=PWRD.dblBundleNo
INNER JOIN productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial AND PLOH.intLineOutputYear = PLOD.intLineOutputYear
WHERE PWRH.intStyleId = O.intStyleId AND PBH.intCutBundleSerial =PWRD.intCutBundleSerial AND PWRH.dtmDate ='$dtmDate' AND PLOH.strTeamNo='$lineId' AND  PWRH.intFactory= '$factoryId') AS WashReadyQty,
(SELECT SUM(PFGD.dblQty) FROM productionfggpdetails PFGD INNER JOIN productionfggpheader PFGH ON 
PFGH.intGPnumber = PFGD.intGPnumber AND PFGH.intGPYear = PFGD.intGPYear
INNER JOIN productionlineoutdetail PLOD ON PLOD.intCutBundleSerial = PFGD.intCutBundleSerial AND PLOD.dblBundleNo=PFGD.dblBundleNo
INNER JOIN productionlineoutputheader PLOH ON PLOH.intLineOutputSerial = PLOD.intLineOutputSerial AND PLOH.intLineOutputYear = PLOD.intLineOutputYear
WHERE PFGH.intStyleId=O.intStyleId AND PBH.intCutBundleSerial =PFGD.intCutBundleSerial AND PFGH.dtmGPDate ='$dtmDate' AND PLOH.strTeamNo='$lineId' AND PFGH.strFromFactory='$factoryId') AS GPqty,
(SELECT SUM(PGPTD.dblQty) FROM productiongptindetail PGPTD 
INNER JOIN productiongptinheader PGPTH ON 
PGPTH.dblCutGPTransferIN = PGPTD.dblCutGPTransferIN AND PGPTH.intGPTYear = PGPTD.intGPTYear
WHERE PGPTD.intCutBundleSerial=PBH.intCutBundleSerial AND PGPTH.intFactoryId='$factoryId' and PGPTH.dtmGPTransferInDate='$dtmDate') AS transQty	
FROM orders O INNER JOIN productionbundleheader PBH ON O.intStyleId = PBH.intStyleId 
WHERE O.intStyleId='$styleId'";
if($cutNo !='')
	$sql .= " and PBH.intCutBundleSerial = '$cutNo' ";
  $sql .= " GROUP BY O.strOrderNo,O.strStyle,O.strDescription,O.intQty,PBH.strCutNo ";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$LineInQty =$row["LineInQty"];
		$LineOutQty = $row["LineOutQty"];
		$WashReadyQty = $row["WashReadyQty"]; 
		$GPqty = $row["GPqty"]; 
		 
		$totQty = $LineInQty+$LineOutQty+$WashReadyQty+$GPqty;
		if($totQty>0)
		{
			$lineEffciency = round($LineOutQty/$LineInQty*100,2);
			$washEffciency = round($GPqty/$LineInQty*100,2);
			$balQty = $LineInQty-$LineOutQty;
			
	  ?>
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20"><?php echo $row["strOrderNo"] ?></td>
        <td><?php echo $row["strStyle"]; ?></td>
        <td><?php echo $row["strDescription"]; ?></td>
        <td><?php echo $row["strPatternNo"] ?></td>
        <td nowrap="nowrap"><?php echo $row["strColor"] ?></td>
        <td><?php echo $row["intQty"] ?></td>
        <td><?php echo $rowS["dtmDate"]; ?></td>
        <td><?php echo $row["strCutNo"]; ?></td>
        <td class="normalfntRite"><?php echo $row["transQty"] ?></td>
        <td><?php echo $rowS["strTeam"]; ?></td>
        <td class="normalfntRite"><?php echo $LineInQty; ?></td>
        <td>&nbsp;</td>
        <td class="normalfntRite"><?php echo $LineOutQty; ?></td>
        <td class="normalfntRite"><?php echo $lineEffciency; ?></td>
       <td class="normalfntRite"><?php echo $WashReadyQty; ?></td>
         <td class="normalfntRite"><?php echo $GPqty; ?></td>
       <td class="normalfntRite"><?php echo $washEffciency; ?></td>
       <td class="normalfntRite"><?php echo $balQty; ?></td>
      </tr>
     <?php
	 	} 
	 }
}
	 ?> 
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
