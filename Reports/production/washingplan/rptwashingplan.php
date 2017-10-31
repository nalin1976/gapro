<?php
session_start();
include "../../../Connector.php";
$backwardseperator = '../../../';
$orderNo 	= $_GET["OrderNo"];
$buyer 		= $_GET["Buyer"];
$styleNo	= $_GET["StyleNo"];
$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo		= $_GET["DateTo"];
$factoryId 	= $_SESSION["FactoryID"];
$report_companyId = $factoryId;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Washing Plan Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td width="12%" height="36" class="normalfnt"><strong>DATE : <?php echo date("d/m/Y"); ?></strong></td>
        <td width="88%" class="head2">Washing Plan as @ <?php echo date("d/m"); ?></td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
      </tr>
      

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1" id="tblItems" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="6%" height="25"   nowrap="nowrap">#</th>
        <th width="10%"  nowrap="nowrap">STYLE#</th>
        <th width="11%"  nowrap="nowrap">PO#</th>
        <th width="10%"  nowrap="nowrap">COLOUR</th>
        <th width="21%"  nowrap="nowrap">ORDER QTY</th>
        <th width="7%"   nowrap="nowrap">RECEIVED<br />QTY AT<br />FTY</th>
        <th width="7%"  nowrap="nowrap">TOTAL<br />INPUT</th>
        <th width="7%"   nowrap="nowrap">TOTAL<br />OUTPUT</th>
        <th width="7%"   nowrap="nowrap">READY<br />FOR<br />WASH</th>
        <th width="16%"  nowrap="nowrap">SENT<br />FOR<br />WASH<br />TODAY</th>
        <th width="16%"  nowrap="nowrap">SENT<br />FOR<br />WASH<br />TTL</th>
        <th width="16%"  nowrap="nowrap">BALANCE<br />TO<br />BE<br />SENT</th>
        <th width="16%"  nowrap="nowrap">RUNING<br />LINE<br />NO</th>
        <th width="16%"  nowrap="nowrap">LAST<br />WASH/<br />DATE</th>
        <th width="16%"  nowrap="nowrap">REMARKS</th>
        <th width="16%"  nowrap="nowrap">ETD</th>
        </tr>
		<?php
			$totalWashReady = 0;
			$totSentWashToday = 0;
			$totSenBal = 0;
			$sql = "select O.strStyle,O.strOrderNo,PBH.strColor,O.intQty,sum(PGPTD.dblQty)as receivedQty,
					(select sum(PID.dblQty) from productionlineinputheader PIH inner join productionlineindetail PID where PIH.intLineInputSerial=PID.intLineInputSerial and PIH.intStyleId=O.intStyleId and PIH.intFactory='$factoryId' )as lineIn,
					(select sum(POD.dblQty) from productionlineoutputheader POH inner join productionlineoutdetail POD where POH.intLineOutputSerial=POD.intLineOutputSerial and POH.intStyleId=O.intStyleId and POH.intFactory='$factoryId' )as lineOut,
					(select sum(PWRD.dblQty) from productionwashreadyheader PWRH inner join productionwashreadydetail PWRD where PWRH.intWashreadySerial=PWRD.intWashreadySerial and PWRH.intStyleId=O.intStyleId and PWRH.intFactory='$factoryId' )as washReady,
					(select sum(PFGPD.dblQty) from productionfggpheader PFGPH inner join productionfggpdetails PFGPD where PFGPH.intGPnumber=PFGPD.intGPnumber and PFGPH.intGPYear=PFGPD.intGPYear and PFGPH.intStyleId=O.intStyleId and PFGPH.strFromFactory='$factoryId' and PFGPH.dtmGPDate=date(now()) )as sentForWashToday,
					(select sum(PFGPD.dblQty) from productionfggpheader PFGPH inner join productionfggpdetails PFGPD where PFGPH.intGPnumber=PFGPD.intGPnumber and PFGPH.intGPYear=PFGPD.intGPYear and PFGPH.intStyleId=O.intStyleId and PFGPH.strFromFactory='$factoryId' )as sentForWashTTL
					from productiongptinheader PGPTH
					INNER JOIN productiongptindetail PGPTD ON PGPTH.dblCutGPTransferIN=PGPTD.dblCutGPTransferIN AND PGPTH.intGPTYear=PGPTD.intGPTYear
					INNER JOIN productionbundleheader PBH ON PBH.intCutBundleSerial=PGPTD.intCutBundleSerial
					INNER JOIN orders O ON O.intStyleId=PBH.intStyleId
					where PGPTH.intFactoryId='$factoryId' ";
					
				if($orderNo!="")
					$sql .= "and O.intStyleId='$orderNo' ";
				if($styleNo!="")
					$sql .= "and O.strStyle='$styleNo' ";
				if($buyer!="")
					$sql .= "and O.intBuyerID='$buyer' ";
				if($checkDate=='1')
				{
					$sql .= "and O.intStyleId in (select distinct PBH.intStyleId 
from productiongptinheader PGPTH 
INNER JOIN productiongptindetail PGPTD ON PGPTH.dblCutGPTransferIN=PGPTD.dblCutGPTransferIN AND PGPTH.intGPTYear=PGPTD.intGPTYear 
INNER JOIN productionbundleheader PBH ON PBH.intCutBundleSerial=PGPTD.intCutBundleSerial 
where date(PGPTH.dtmGPTransferInDate) >='$dateFrom' and date(PGPTH.dtmGPTransferInDate) <='$dateTo') ";
				}
					
					$sql .= "group by O.intStyleId ";
					$sql .= "order by O.strOrderNo ";
			$result=$db->RunQuery($sql);
			$No = 1;
			while($row = mysql_fetch_array($result))
			{ 
				$totalWashReady+= $row["washReady"];
				$totSenBal+= ($row["receivedQty"]-$row["sentForWashTTL"]);
				$totSentWashToday += $row["sentForWashToday"];
		?>
				<tr class="bcgcolor-tblrowWhite">
				<td height="18" class="normalfntMid" nowrap="nowrap"><?PHP echo $No;  ?></td>
				<td class="normalfnt"  nowrap="nowrap">&nbsp;<?PHP echo($row["strStyle"]);  ?>&nbsp;</td>
				<td class="normalfnt"  nowrap="nowrap">&nbsp;<?PHP echo ($row["strOrderNo"]);  ?>&nbsp;</td>
				<td class="normalfnt"  nowrap="nowrap">&nbsp;<?PHP echo($row["strColor"]);  ?>&nbsp;</td>
				<td class="normalfntRite"  nowrap="nowrap"><?PHP echo($row["intQty"]);  ?>&nbsp;</td>
				<td class="normalfntRite"  nowrap="nowrap"><?PHP echo($row["receivedQty"]);  ?>&nbsp;</td>
				<td class="normalfntRite"  nowrap="nowrap"><?PHP echo($row["lineIn"]);  ?>&nbsp;</td>
				<td class="normalfntRite"  nowrap="nowrap"><?PHP echo($row["lineOut"]);  ?>&nbsp;</td>
				<td class="normalfntRite"  nowrap="nowrap"><?PHP echo($row["washReady"]);  ?>&nbsp;</td>
				<td class="normalfntRite"  nowrap="nowrap"><?PHP echo($row["sentForWashToday"]);  ?>&nbsp;</td>
				<td class="normalfntRite" nowrap="nowrap"><?PHP echo($row["sentForWashTTL"]);  ?>&nbsp;</td>
				<td class="normalfntRite"  nowrap="nowrap"><?PHP echo ($row["receivedQty"]-$row["sentForWashTTL"]);  ?>&nbsp;</td>
				<td class="normalfntRite"  nowrap="nowrap">&nbsp;</td>
				<td class="normalfnt"  nowrap="nowrap">&nbsp;</td>
				<td class="normalfnt"     nowrap="nowrap">&nbsp;</td>
				<td class="normalfnt"  nowrap="nowrap">&nbsp;</td>	
				</tr>
		<?php
			$No++;
			}
		?>
        	<tr bgcolor="#EAEAEA">
				<td height="18" class="normalfntMid" nowrap="nowrap"></td>
				<td class="normalfntMid"  nowrap="nowrap"></td>
				<td class="normalfntMid"  nowrap="nowrap"></td>
				<td class="normalfntMid"  nowrap="nowrap"></td>
				<td class="normalfntMid"  nowrap="nowrap"></td>
				<td class="normalfntMid"  nowrap="nowrap"></td>
				<td class="normalfntMid"  nowrap="nowrap"></td>
				<td class="normalfntMid"  nowrap="nowrap"></td>
				<th class="normalfntRite"  nowrap="nowrap"><?php echo $totalWashReady; ?>&nbsp;</th>
				<th class="normalfntRite"  nowrap="nowrap"><?php echo $totSentWashToday; ?>&nbsp;</th>
				<td class="normalfntRite" nowrap="nowrap"></td>
				<th class="normalfntRite"  nowrap="nowrap"><?php echo $totSenBal; ?>&nbsp;</th>
				<td class="normalfntMid"  nowrap="nowrap">&nbsp;</td>
				<td class="normalfntMid"  nowrap="nowrap">&nbsp;</td>
				<td class="normalfnt"     nowrap="nowrap">&nbsp;</td>
				<td class="normalfntMid"  nowrap="nowrap">&nbsp;</td>	
				</tr>
        
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  </table></td>
  </tr>
</table>
</body>
</html>
