<?php 
 session_start();
 $backwardseperator 	= "../../";
 include "{$backwardseperator}authentication.inc";
 $report_companyId=$_SESSION['FactoryID'];
 $dfrom = '2011-03-01';
 $dto = '2011-03-31';
 $styleID = $_GET['req'];
 $sc=$_GET['sc'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Gapro:Washing-Sub Contractor report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<?php 
include "../../Connector.php";
?>
<body>

<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
 <td width="1174" align="center" style="font-family: Arial;	font-size: 10pt;color: #000000;font-weight: bold;">
  <?php include('../../reportHeader.php'); ?>
</td>
</tr>
 <tr>
	<td class="">&nbsp;</td>
 </tr>
 <tr>
	<td class="head2">Sub Contractor Log</td>
 </tr>
  <tr>
	<td class="">&nbsp;</td>
 </tr>
  <tr>
    <td>
    	<table style="width:800px;" border="1" rules="all">
        <?php 
		$sql="SELECT DISTINCT
				was_subcontractout.intStyleId,
				was_subcontractout.intSubContractNo,
				was_subcontractout.strColor,
				orders.strOrderNo,
				orders.strStyle
				FROM
				was_subcontractout
				INNER JOIN orders ON was_subcontractout.intStyleId = orders.intStyleId
				WHERE
				was_subcontractout.intStyleId= '$styleID' 
				AND was_subcontractout.intSubContractNo='$sc' 
				AND was_subcontractout.intCompanyID='".$_SESSION['FactoryID']."';";
		$result = $db->RunQuery($sql);
		$resRow=mysql_fetch_array($result);
		?>
        	<tr>
            	<td style="width:100px;" class="normalfnt">PO Number</td>
                <td style="width:300px;" class="normalfnt"><?php echo $resRow['strOrderNo'];?></td>
            	<td style="width:100px;" class="normalfnt">Style</td>
                <td style="width:300px;" class="normalfnt"><?php echo $resRow['strStyle'];?></td>
            </tr>
            <tr>
	            <td class="normalfnt">Color</td>
                 <td class="normalfnt"><?php echo $resRow['strColor'];?></td>
                <td class="normalfnt">Factory</td>
                 <td class="normalfnt"><?php echo getFactory($styleID);?></td>
            </tr>
            <tr>
	            <td class="normalfnt" colspan="4">&nbsp;</td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    <table style="width:800px;" border="1" rules="all">
			<tr>

				<td class="normalfntBtab" colspan="5" style="width:400px;">Send</td>
                <td class="normalfntBtab" colspan="4" style="width:400px;">Receive</td>
				
			</tr>
			<tr>
				<!--<td style="width:20px;" class="normalfntBtab"></td>-->
				<td style="width:100px;" class="normalfntBtab">Date</td>
				<td style="width:100px;" class="normalfntBtab">AOD</td>
				<td style="width:100px;" class="normalfntBtab">Qty</td>
				<td style="width:100px;" class="normalfntBtab">Total Qty</td>
                <td style="width:100px;"" class="normalfntBtab">AOD</td>
                <td style="width:100px;" class="normalfntBtab">Qty</td>
                <td style="width:100px;" class="normalfntBtab">Total Qty</td>
				<td style="width:100px;"class="normalfntBtab">Balance</td>
			</tr>
			
			       <?php 
				$res=getDets($styleID,$sc,$resRow['strColor']);
				$dt='';
				$sOutTot=0;
				$sInTot=0;
				$i=0;
				while($row=mysql_fetch_array($res)){
				$cls='';
				($i%2==0)?$cls="grid_raw":$cls="grid_raw2";
				if($row['SOD']=="" || $row['SOD']!=$dt){	
			?> 
        <tr>
				<td class="normalfnt" colspan="8"><?php echo $row['SOD'];$dt=$row['SOD'];?></td>
        </tr>
        <?php }?>
	    <tr>
				<!--<td style="width:20px;" class="normalfnt">&nbsp;</td>-->
				<td class="normalfnt" style="width:100px;text-align:left;">&nbsp;</td>
				<td class="normalfnt" style="text-align:left;"><?php if($row['STYPE']=='SUBOUT'){echo $row['AOD'];}?></td>
				<td class="normalfnt" style="text-align:right;"><?php if($row['STYPE']=='SUBOUT'){ echo $row['dblQty'];$sOutTot=$sOutTot+$row['dblQty'];}?></td>
				<td class="normalfnt" style="text-align:right;"><?php if($row['STYPE']=='SUBOUT'){echo $sOutTot;}?></td>
                <td class="normalfnt" style="text-align:left;"><?php if($row['STYPE']=='SUBIN'){echo $row['AOD'];}?></td>
				<td class="normalfnt" style="text-align:right;"><?php if($row['STYPE']=='SUBIN'){echo $row['dblQty'];$sInTot=$sInTot+$row['dblQty'];}?></td>
				<td class="normalfnt" style="text-align:right;"><?php if($row['STYPE']=='SUBIN'){echo $sInTot;}?></td>          
				<td class="normalfnt" style="text-align:right;"><?php $cum=$sOutTot-$sInTot;if($cum==0){?><font color="#FF0000"><?php }echo $cum;?></font></td>
         </tr>  
         <?php
			$i++;	}
		 ?>
       
	  </table>
    
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
function getDets($po,$factoryId,$color){
global $db;
$sqlO="SELECT TBL.AOD,TBL.dblQty,TBL.SOD,TBL.STYPE 
FROM (SELECT
concat(sO.intAODYear,'/',sO.intAODNo) AS AOD,
sO.dblSaveSerial,
sO.dblQty,
DATE(sO.dtmDate) AS SOD,
sO.intCompanyID,
'SUBOUT' AS STYPE
FROM
was_subcontractout AS sO
WHERE
sO.intStyleId = '$po' AND
sO.intSubContractNo = '$factoryId' AND
sO.strColor = '$color' AND
sO.intCompanyID='".$_SESSION['FactoryID']."'
UNION
SELECT
sI.strGatePassNo,
sI.dblSaveSerial,
sI.dblQty,
DATE(sI.dtmDate) AS SID,
sI.intCompanyID,
'SUBIN' AS STYPE
FROM
was_subcontractin AS sI
WHERE
sI.intSubContractNo='$factoryId' AND
sI.intStyleId='$po' AND
sI.strColor='$color' AND
sI.intCompanyID='".$_SESSION['FactoryID']."') AS TBL
ORDER BY TBL.dblSaveSerial;";
//echo $sqlO;
return $db->RunQuery($sqlO);

}

function getDateWiseDetails($po,$date){
	global $db;
	$sql="select concat(intDocumentYear,'/',intDocumentNo) AS AOD,strType,dblQty,dtmDate 
from was_stocktransactions 
where strType in('SubOut','SubIn') and date(dtmDate)='$date' and intStyleId='$po' order by AOD DESC;";

	return $db->RunQuery($sql);
}

function getDates($po){
	global $db;
	$sql="select distinct date(dtmDate) as dt from was_stocktransactions 
where strType in('SubOut','SubIn') and intStyleId='$po';";
return $db->RunQuery($sql);
}
function getPur($PO){
global $db;
$SQL="SELECT was_subcontractout.strPurpose from was_subcontractout WHERE was_subcontractout.intStyleId =  '$PO';";
//echo $SQL;
$res = $db->RunQuery($SQL);
$arrRemarks=array();
$c=0;
	while($row=mysql_fetch_array($res)){
		$arrRemarks[$c]=$row['strPurpose'];
		$c++;
	}
	return implode(",",$arrRemarks);
}

function getFactory($PO){
global $db;
	$SQL=" SELECT DISTINCT was_outside_companies.strName from was_subcontractout inner join was_outside_companies on was_outside_companies.intCompanyID=was_subcontractout.intSubContractNo WHERE was_subcontractout.intStyleId =  '$PO';";
	$res = $db->RunQuery($SQL);
	$row=mysql_fetch_array($res);
	return	$row['strName'];
}
function getGPNo($AOD){
 global $db;
 $no=split('/',$AOD);
 $sql="select strGatePassNo from was_subcontractin where intAODNo='".$no[1]."' and intAODYear='".$no[0]."' order by intAODNo DESC;";	
// echo $sql;
 $res=$db->RunQuery($sql);
	 $row=mysql_fetch_array($res);
	 return $row['strGatePassNo'];

}
?>
</body>
</html>
