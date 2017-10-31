<?php
	session_start();
	include "../../Connector.php";
	$backwardseperator = '../../';
	$factoryId = $_SESSION["FactoryID"];
	$report_companyId = $factoryId;
	
	$orderNo 	= $_GET["orderNo"];
	$buyer 		= $_GET["buyer"];
	$Factory 	= $_GET["sewFactory"];
	$styleNo	= $_GET["styleNo"];
	$CheckDate	= $_GET["CheckDate"];
	$DateFrom	= $_GET["DateFrom"];
	$DateTo		= $_GET["DateTo"];
	
	$poQtyArray = 0;
	$allocateQtyArry = 0;
	$cutQtyArry = 0;
	$varianceArray = 0;
	$line = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Cutting Work In Progress Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td height="36" class="head2">Cutting Work In Progress Report</td>
        </tr>
      <tr>
        <td class="normalfntRite">Prdoction No:  QAP 09 -AC</td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellpadding="0" cellspacing="1" id="tblItems" rules="all">
	<tr bgcolor="#CCCCCC">
		<th width="6%" height="25" rowspan="2" class="normalfntMid" scope="col">&nbsp;FTY</th>
		<th width="10%" rowspan="2" class="normalfntMid" scope="col"><b>BULK START DATE</b></th>
		<th width="11%" rowspan="2" class="normalfntMid" scope="col"><b>PO No</b></th>
		<th width="10%" rowspan="2" class="normalfntMid" scope="col"><b>DIV</b></th>
		<td width="21%" rowspan="2" class="normalfntMid" scope="col"><b>STYLE No</b></td>         
		<td width="21%" rowspan="2" class="normalfntMid" scope="col"><b>COLOUR</b></th>
		<th width="13%" rowspan="2" class="normalfntMid" scope="col"><b>ORDER QTY </b></th>
		<th width="13%" rowspan="2" class="normalfntMid" scope="col">PLAN QTY/PCS</th>
		<th colspan="3" class="normalfntMid" scope="col">CUT</th>
		<th colspan="5" class="normalfntMid" scope="col">LOAD</th>
		<th width="13%" rowspan="2" class="normalfntMid" scope="col">COMMENTS</th>
	</tr>
	<tr bgcolor="#CCCCCC">
		<th width="13%" class="normalfntMid" scope="col">TODAY CUT/PCS</th>
		<th width="13%" class="normalfntMid" scope="col">TOTAL CUT QTY/PCS</th>
		<th width="13%" class="normalfntMid" scope="col">BALANCE TO CUT/PCS</th>
		<th width="13%" class="normalfntMid" scope="col">AOD#</th>
		<th width="13%" class="normalfntMid" scope="col">TODAY SENT</th>
		<th width="13%" class="normalfntMid" scope="col">TOTAL SENT QTY/PCS</th>
		<th width="13%" class="normalfntMid" scope="col">BALANCE LOAD</th>
		<th width="13%" class="normalfntMid" scope="col">BALANCE AT SW</th>
		</tr>
<?php
$sql="select 
	O.intStyleId,
	PBH.strToFactory,
	C.strComCode,
	O.strOrderNo,
	BD.strDivision,
	O.strStyle,
	PBH.strColor,
	O.intQty,
	(select sum(PBH.dblTotalQty) from productionbundleheader PBH where O.intStyleId=PBH.intStyleId and  date(PBH.dtmCutDate)=date(now()) and cut_type=1)as todayCutQty,
	sum(PBH.dblTotalQty)as dblTotalQty,
	(select sum(PGD.dblQty) from productiongpheader PGH inner join productiongpdetail PGD where PGD.intGPnumber=PGH.intGPnumber and PGD.intYear=PGH.intYear and O.intStyleId=PGH.intStyleId and PGH.intTofactory=PBH.strToFactory and date(PGH.dtmDate)=date(now()))as todaySentQty,
	(select sum(PGD.dblQty) from productiongpheader PGH inner join productiongpdetail PGD where PGD.intGPnumber=PGH.intGPnumber and PGD.intYear=PGH.intYear and O.intStyleId=PGH.intStyleId and PGH.intTofactory=PBH.strToFactory)as totSentQty
	from productionbundleheader PBH
	inner join orders O on O.intStyleId=PBH.intStyleId
	inner join companies C on C.intCompanyID=PBH.strToFactory
	inner join buyerdivisions BD on BD.intDivisionId=O.intDivisionId
	where PBH.cut_type=1 ";

if($styleNo!="")
$sql.="and O.strStyle='$styleNo' ";

if($orderNo!="")
$sql.="and O.intStyleId='$orderNo' ";

if($buyer!="")
$sql.="and O.intBuyerID='$buyer' ";

if($Factory!="")
$sql.="and PBH.strToFactory='$Factory' ";

if($CheckDate=="1")
{
	$sql.="and PBH.dtmCutDate>='$DateFrom' and PBH.dtmCutDate<='$DateTo'  ";
}
$sql.="group by O.intStyleId,PBH.strToFactory order by O.strOrderNo ";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$todayCutQty	= round($row["todayCutQty"],0);
	$totCutQty		= round($row["dblTotalQty"],0);
	//$planQty		= $totCutQty;
	$planQty		= round($row["intQty"],0);
	$balanceToCut	= round($planQty-$totCutQty,0);
	$todaySentQty	= round($row["todaySentQty"],0);
	$totSentQty		= round($row["totSentQty"],0);
	$balanceAtSW	= round($totCutQty-$totSentQty,0);
	$balanceLoad	= round($planQty-$totSentQty,0);
?>
	<tr >
		<td class="normalfnt">&nbsp;<?php echo $row["strComCode"]; ?>&nbsp;</td>
		<td class="normalfnt">&nbsp;</td>
		<td class="normalfnt" id="<?php echo $row["intStyleId"]?>">&nbsp;<?php echo $row["strOrderNo"]; ?>&nbsp;</td>
		<td class="normalfnt">&nbsp;<?php echo $row["strDivision"]; ?>&nbsp;</td>
		<td class="normalfnt">&nbsp;<?php echo $row["strStyle"]; ?>&nbsp;</td>
		<td class="normalfnt">&nbsp;<?php echo $row["strColor"]; ?>&nbsp;</td>
		<td class="normalfntRite">&nbsp;<?php echo number_format($row["intQty"],0); ?>&nbsp;</td>
		<td class="normalfntRite">&nbsp;<?php echo number_format($planQty,0); ?>&nbsp;</td>
		<td class="normalfntRite">&nbsp;<?php echo $todayCutQty=='0'?'':$todayCutQty ;?>&nbsp;</td>
		<td class="normalfntRite">&nbsp;<?php echo number_format($totCutQty,0);?>&nbsp;</td>
		<td class="normalfntRite">&nbsp;<?php echo number_format($balanceToCut,0);?>&nbsp;</td>
		<td class="normalfntRite">&nbsp;<?php echo GetAODNos($row["intStyleId"],$row["strToFactory"]);?>&nbsp;</td>
		<td class="normalfntRite">&nbsp;<?php echo $todaySentQty=='0'?'':$todaySentQty,0?>&nbsp;</td>
		<td class="normalfntRite">&nbsp;<?php echo number_format($totSentQty,0)?>&nbsp;</td>
		<td class="normalfntRite">&nbsp;<?php echo number_format($balanceLoad,0)?>&nbsp;</td>
		<td class="normalfntRite">&nbsp;<?php echo number_format($balanceAtSW,0)?>&nbsp;</td>
		<td class="normalfnt">&nbsp;</td>
	</tr>
<?php
}
?>
    </table></td>
  </tr>
  </table>
</td>
  </tr>
</table>
</body>
</html>
<?php
function GetAODNos($styleId,$toFactory)
{
global $db;
	$sql="select distinct concat(PGH.intYear,'/',PGH.intGPnumber) as AODNo
			from productiongpheader PGH
			where PGH.intStyleId='$styleId' and PGH.intTofactory='$toFactory'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$aod .= $row["AODNo"].'<br/>';
	}
return $aod ;
}
?>