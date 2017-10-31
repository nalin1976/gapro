<?php 
session_start();
include "../../Connector.php";
$styleid=$_GET["styleid"];
$str_order="SELECT 
O.strOrderNo AS strOrderNo,
O.intStyleId AS intStyleId,
O.strStyle AS strStyle,
O.intQty AS intQty,
(O.intApprovalNo-1) AS intApprovalNo,
COM.strComCode AS strComCode,
BU.buyerCode,
(SELECT SUM(ORR.intRecutQty) FROM orders_recut AS ORR WHERE O.intStyleId=ORR.intStyleId) AS intRecutQty,
DATE_FORMAT(O.strRevisedDate ,'%d/%m/%Y') AS strRevisedDate,
DATE_FORMAT(O.dtmAppDate ,'%d/%m/%Y') AS dtmAppDate,
O.reaExPercentage,
UA.Name AS merchant,
DATE_FORMAT(O.dtmDate ,'%d/%m/%Y') AS dtmDate
FROM
orders O
INNER JOIN useraccounts UA ON UA.intUserID=O.intUserID
INNER JOIN buyers BU ON O.intBuyerID=BU.intBuyerID
INNER JOIN companies COM ON O.intManufactureCompanyID=COM.intCompanyID
WHERE O.intStyleId='$styleid'";
$result_order=$db->RunQuery($str_order);
$data_order=mysql_fetch_array($result_order);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />
<link type="text/css"  href="../../css/erpstyle.css" rel="stylesheet" />
</head>

<body>
<table width="600" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" bgcolor="#FFFFFF"  cellpadding="3" style="-moz-border-radius: 3px 3px 3px 3px;
	 	border:#9EB6CE 1px solid;" class="normalfnt">
      <tr style="">
        <td height="20" valign="top" style="color:#045182;text-align:left;"> <strong>WIP EXPLORER</strong></td>
        <td style="color:#045182;text-align:right;font-size:120%" valign="top"><span onclick="closeWindow()" class="mouseover" ><strong>&nbsp;&nbsp;X&nbsp;</strong></span></td>
      </tr>
      <tr>
        <td colspan="2" valign="top" class="normalfnt"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="normalfnt" style="color:#666">
          <tr>
            <td colspan="2" ><fieldset>
              <legend><strong>Order Specification</strong></legend>
              <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#D0D7E5">
                <tr bgcolor="#9EB6CE" style="text-align:center">
                  <td>Order No </td>
                  <td>Style </td>
                  <td>Buyer</td>
                  <td>Order Qty </td>
                  <td>Recut Qty</td>
                  <td>Excess [%]</td>
                  <td>Manufacturer </td>
                  <td>Merchandiser</td>
                  <td>Created Date</td>
                  <td>Confirmed Date</td>
                  <td>Revise Date</td>
                  <td>No of Revisions</td>
                  </tr>
                <tr bgcolor="#FFFFFF">
                  <td nowrap="nowrap"><?php echo $data_order['strOrderNo'];?></td>
                  <td><?php echo $data_order['strStyle'];?></td>
                  <td><?php echo $data_order['buyerCode'];?></td>
                  <td><?php echo $data_order['intQty'];?></td>
                  <td><?php echo ($data_order['intRecutQty']>0?$data_order['intRecutQty']:0);?></td>
                  <td><?php echo $data_order['reaExPercentage'];?></td>
                  <td><?php echo $data_order['strComCode'];?></td>
                  <td><?php echo $data_order['merchant'];?></td>
                  <td><?php echo $data_order['dtmDate'];?></td>
                  <td><?php echo $data_order['dtmAppDate'];?></td>
                  <td><?php echo $data_order['strRevisedDate'];?></td>
                  <td><?php echo ($data_order['intApprovalNo']>0?$data_order['intApprovalNo']:0);?></td>
                  </tr>
                </table>
  <p>&nbsp;</p>
              </fieldset></td>
          </tr>
          <tr>
            <td colspan="2" ><fieldset>
              <legend><strong>Cutting Summary</strong></legend>
              <table  border="0" cellspacing="1" cellpadding="3" bgcolor="#D0D7E5">
                <tr bgcolor="#9EB6CE" style="text-align:center">
                  <td>Cut No</td>
                  <td>Date</td>
                  <td>Factory</td>
                  <td>To Factory</td>
                  <td>Cut Qty</td>
                  </tr>
                <?php 
				$str_cutting="SELECT 
								strFromFactory,
								strToFactory,
								strCutNo,
								DATE_FORMAT(dtmCutDate,'%d/%m/%Y') cutdate,
								dblTotalQty
								FROM
								productionbundleheader
								WHERE 
								intStyleId='$styleid' AND cut_type IN (1,6,7,10,11)
								ORDER BY dtmCutDate,strCutNo ";
				$result_cutting=$db->RunQuery($str_cutting);
				while($row_cutting=mysql_fetch_array($result_cutting)){
				?>
                
                <tr bgcolor="#FFFFFF">
                  <td><?php echo $row_cutting["strCutNo"];?></td>
                  <td><?php echo $row_cutting["cutdate"];?></td>
                  <td><?php echo getManufacturer($row_cutting["strFromFactory"]);?></td>
                  <td><?php echo getManufacturer($row_cutting["strToFactory"]);?></td>
                  <td style="text-align:right"><?php echo $cutqty=$row_cutting["dblTotalQty"];$totalcutqty+=$cutqty;?></td>
                  </tr><?php }?>
                  <tr bgcolor="#FFFFFF">
                  <td colspan="4"><strong>Total</strong></td>
                  <td style="text-align:right"><strong><?php echo number_format($totalcutqty,0);?></strong></td>
                </tr>
              </table>
<p>&nbsp;</p>
              </fieldset></td>
          </tr>
          <tr>
            <td colspan="2" ><fieldset>
              <legend><strong>Cut Dispatch Summary</strong></legend>
              <table  border="0" cellspacing="1" cellpadding="3" bgcolor="#D0D7E5">
                <tr bgcolor="#9EB6CE" style="text-align:center">
                  <td>AOD No</td>
                  <td>Date</td>
                  <td>Factory</td>
                  <td>To Factory</td>
                  <td> Qty</td>
                </tr>
                <?php 
				$str_cutting_dpt="SELECT
								SUM(PGD.dblQty) AS cutgpqty,
								PGH.intFromFactory,
								PGH.intTofactory,
								PGH.intGPnumber,
								PBH.strCutNo,
								DATE_FORMAT(PGH.dtmDate ,'%d/%m/%Y') AS cutgpdate
								FROM productiongpdetail PGD
								INNER JOIN productiongpheader PGH ON PGH.intGPnumber=PGD.intGPnumber AND PGH.intYear=PGD.intYear
								INNER JOIN productionbundleheader PBH ON PBH.intCutBundleSerial=PGD.intCutBundleSerial
								WHERE PGH.intStyleId='$styleid' AND cut_type IN (1,6,7,10,11) AND PGH.intStatus!=10 AND PGH.strType NOT IN ('R','NA') 
								GROUP BY PGH.intGPnumber
								ORDER BY PGH.dtmDate,PBH.strCutNo
								";
				$result_cutting_dpt=$db->RunQuery($str_cutting_dpt);
				while($row_cutting_dpt=mysql_fetch_array($result_cutting_dpt)){
				?>
                <tr bgcolor="#FFFFFF">
                  <td><?php echo $row_cutting_dpt["intGPnumber"];?></td>
                  <td><?php echo $row_cutting_dpt["cutgpdate"];?></td>
                  <td><?php echo getManufacturer($row_cutting_dpt["intFromFactory"]);?></td>
                  <td><?php echo getManufacturer($row_cutting_dpt["intTofactory"]);?></td>
                  <td style="text-align:right"><?php echo $cutdptqty=$row_cutting_dpt["cutgpqty"];$totalcutdptqty+=$cutdptqty;?></td>
                </tr>
                <?php }?>
                <tr bgcolor="#FFFFFF">
                  <td colspan="4"><strong>Total</strong></td>
                  <td style="text-align:right"><strong><?php echo number_format($totalcutdptqty,0);?></strong></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              </fieldset></td>
          </tr>
          <tr>
            <td colspan="2" ><fieldset>
              <legend><strong>Cut Received Summary</strong></legend>
              <table  border="0" cellspacing="1" cellpadding="3" bgcolor="#D0D7E5">
                <tr bgcolor="#9EB6CE" style="text-align:center">
                  <td>AOD No</td>
                  <td>Transfer In No</td>
                  <td>Date</td>
                  <td>Factory</td>
                  <td> Qty</td>
                </tr>
                <?php 
				$str_cutting_transin="SELECT 
SUM(dblQty) AS receivedqty,
PGTH.intFactoryId,
PGTH.intGPnumber,
PGTD.dblCutGPTransferIN,
DATE_FORMAT(dtmGPTransferInDate ,'%d/%m/%Y') AS dtmDate
FROM productiongptindetail PGTD
INNER JOIN productiongptinheader PGTH ON PGTD.dblCutGPTransferIN=PGTH.dblCutGPTransferIN AND PGTD.dblCutGPTransferIN=PGTH.dblCutGPTransferIN 
INNER JOIN productionbundleheader PBH ON PBH.intCutBundleSerial=PGTD.intCutBundleSerial
LEFT JOIN productiongpheader PGP ON PGP.intGPnumber=PGTH.intGPnumber AND PGP.intYear=PGTH.intGPYear
WHERE PBH.intStyleId='$styleid' AND cut_type IN (1,6,7,10,11) AND PGP.strType!='R' AND PGTH.intStatus!='99' 
GROUP BY PGTD.dblCutGPTransferIN ";
				$result_cutting_transin=$db->RunQuery($str_cutting_transin);
				while($row_cutting_transin=mysql_fetch_array($result_cutting_transin)){
				?>
                <tr bgcolor="#FFFFFF">
                  <td><?php echo $row_cutting_transin["intGPnumber"];?></td>
                  <td><?php echo $row_cutting_transin["dblCutGPTransferIN"];?></td>
                  <td><?php echo $row_cutting_transin["dtmDate"];?></td>
                  <td><?php echo getManufacturer($row_cutting_transin["intFactoryId"]);?></td>
                  <td style="text-align:right"><?php echo $cuttransqty=$row_cutting_transin["receivedqty"];$totalcuttransqty+=$cuttransqty;?></td>
                </tr>
                <?php }?>
                <tr bgcolor="#FFFFFF">
                  <td colspan="4"><strong>Total</strong></td>
                  <td style="text-align:right"><strong><?php echo number_format($totalcuttransqty,0);?></strong></td>
                </tr>
              </table>
<p>&nbsp;</p>
              </fieldset></td>
            </tr>
          <tr>
            <td colspan="2" ><fieldset>
              <legend><strong>Sewing Summary</strong></legend>
              <table  border="0" cellspacing="1" cellpadding="3" bgcolor="#D0D7E5">
                <tr bgcolor="#9EB6CE" style="text-align:center">
                  <td>Factory</td>
                  <td>Line</td>
                  <td>In Qty</td>
                  <td> Out Qty</td>
                  </tr>
                <?php 
				$str_cutting_transin="SELECT
				SUM(LID.dblQty) AS inputqty,
				LIH.intFactory,
				LIH.strTeamNo,
				PT.strTeam,
				(SELECT
				SUM(LOD.dblQty)
				FROM productionlineoutdetail LOD
				INNER JOIN productionlineoutputheader LOH
				ON LOH.intLineOutputSerial = LOD.intLineOutputSerial
				INNER JOIN productionbundleheader PBH 
				ON PBH.intCutBundleSerial = LOD.intCutBundleSerial
				 AND LOH.intLineOutputYear = LOD.intLineOutputYear
				WHERE LOH.intStyleID = LIH.intStyleId AND PBH.cut_type IN (1,6,7,10,11)
				AND LOH.intFactory = LIH.intFactory
				AND LOH.strTeamNo = LIH.strTeamNo
				GROUP BY LOH.strTeamNo) AS outqty
				FROM productionlineindetail LID
				INNER JOIN productionlineinputheader LIH
				ON LIH.intLineInputSerial = LID.intLineInputSerial
				AND LIH.intLineInputYear = LID.intLineInputYear
				INNER JOIN plan_teams PT
				ON LIH.strTeamNo = PT.intTeamNo
				INNER JOIN productionbundleheader PBH 
				ON PBH.intCutBundleSerial = LID.intCutBundleSerial
				WHERE LIH.intStyleId ='$styleid' AND PBH.cut_type IN (1,6,7,10,11) AND LIH.intStatus!='10'
				GROUP BY LIH.intFactory,LIH.strTeamNo";
				$result_cutting_transin=$db->RunQuery($str_cutting_transin);
				while($row_cutting_transin=mysql_fetch_array($result_cutting_transin)){
				?>
                <tr bgcolor="#FFFFFF">
                  <td><?php echo getManufacturer($row_cutting_transin["intFactory"]);?></td>
                  <td><?php echo $row_cutting_transin["strTeam"];?></td>
                  <td style="text-align:right"><?php echo $linein=$row_cutting_transin["inputqty"];$totallinein+=$linein;?></td>
                  <td style="text-align:right"><?php echo $lineout=$row_cutting_transin["outqty"];$totallineout+=$lineout;?></td>
                  </tr>
                <?php }?>
                <tr bgcolor="#FFFFFF">
                  <td colspan="2"><strong>Total</strong></td>
                  <td style="text-align:right"><strong><?php echo number_format($totallinein,0);?></strong></td>
                  <td style="text-align:right"><strong><?php echo number_format($totallineout,0);?></strong></td>
                  </tr>
                </table>
  <p>&nbsp;</p>
              </fieldset></td>
          </tr>
          <tr>
            <td width="28%"></td>
            <td width="72%"></td>
          </tr>
          <tr>
            <td colspan="2" ><fieldset>
              <legend><strong>Sewing Dispatch Summary</strong></legend>
              <table  border="0" cellspacing="1" cellpadding="3" bgcolor="#D0D7E5">
                <tr bgcolor="#9EB6CE" style="text-align:center">
                  <td>AOD No</td>
                  <td>Date</td>
                  <td>Factory</td>
                  <td>To Factory</td>
                  <td> Qty</td>
                </tr>
                <?php 
				$str_cutting_dpt="
				SELECT 
SUM(dblQty) AS totfggp,
FGGPD.intGPnumber,
FGGPH.strFromFactory,
DATE_FORMAT(dtmGPDate ,'%d/%m/%Y') AS dtmDate,
FGGPH.strToFactory,
FGGPD.intStatus
FROM productionfggpheader FGGPH
INNER JOIN productionfggpdetails FGGPD ON FGGPD.intGPnumber=FGGPH.intGPnumber
INNER JOIN productionbundleheader PBH 
				ON PBH.intCutBundleSerial =FGGPD.intCutBundleSerial
WHERE FGGPH.intStyleId='$styleid' and PBH.cut_type IN (1,6,7,10,11) AND FGGPH.strType='SD' GROUP BY FGGPD.intGPnumber";
				$result_cutting_dpt=$db->RunQuery($str_cutting_dpt);
				while($row_cutting_dpt=mysql_fetch_array($result_cutting_dpt)){
				?>
                <tr bgcolor="#FFFFFF">
                  <td><?php echo $row_cutting_dpt["intGPnumber"];?></td>
                  <td><?php echo $row_cutting_dpt["dtmDate"];?></td>
                  <td><?php echo getManufacturer($row_cutting_dpt["strFromFactory"]);?></td>
                  <td><?php echo getManufacturer($row_cutting_dpt["strToFactory"]);?></td>
                  <td style="text-align:right"><?php echo $totfggp=$row_cutting_dpt["totfggp"];$totaltotfggp+=$totfggp;?></td>
                </tr>
                <?php }?>
                <tr bgcolor="#FFFFFF">
                  <td colspan="4"><strong>Total</strong></td>
                  <td style="text-align:right"><strong><?php echo number_format($totaltotfggp,0);?></strong></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              </fieldset></td>
          </tr>
          <tr>
            <td colspan="2" ><fieldset>
              <legend><strong>Packing  Summary</strong></legend>
              <table  border="0" cellspacing="1" cellpadding="3" bgcolor="#D0D7E5">
                <tr bgcolor="#9EB6CE" style="text-align:center">
                  <td>Packing List No</td>
                  <td>Date</td>
                  <td> Qty</td>
                </tr>
                <?php 
				$str_packing_dpt="SELECT
				  DATE_FORMAT(dtmPLDate,'%d/%m/%Y') AS dtmDate,
				  SUM(dblQtyPcs) AS qty,
				  SPH.strPLNo
				FROM eshipping.shipmentplheader SPH
				  INNER JOIN eshipping.shipmentpldetail SPD
					ON SPH.strPLNo = SPD.strPLNo
				WHERE intStyleId ='$styleid' AND intConfirmaed=1
				GROUP BY SPD.strPLNo";
				$result_packing_dpt=$db->RunQuery($str_packing_dpt);
				while($row_packing_dpt=mysql_fetch_array($result_packing_dpt)){
				?>
                <tr bgcolor="#FFFFFF">
                  <td><?php echo $row_packing_dpt["strPLNo"];?></td>
                  <td><?php echo $row_packing_dpt["dtmDate"];?></td>
                  <td style="text-align:right"><?php echo $totpack=$row_packing_dpt["qty"];$totaltotpack+=$totpack;?></td>
                </tr>
                <?php }?>
                <tr bgcolor="#FFFFFF">
                  <td colspan="2"><strong>Total</strong></td>
                  <td style="text-align:right"><strong><?php echo number_format($totaltotpack,0);?></strong></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              </fieldset></td>
          </tr>
          <tr>
            <td colspan="2" ><fieldset>
              <legend><strong>Shipping  Summary</strong></legend>
              <table  border="0" cellspacing="1" cellpadding="3" bgcolor="#D0D7E5">
                <tr bgcolor="#9EB6CE" style="text-align:center">
                  <td>Invoice No</td>
                  <td>Date</td>
                  <td>ETD</td>
                  <td>Mode</td>
                  <td>BL/AWB No</td>
                  <td>FCR No</td>
                  <td> Qty</td>
                </tr>
                <?php 
				$str_shipping_dpt="SELECT
								  CIH.strInvoiceNo,
								  DATE_FORMAT(dtmInvoiceDate,'%d/%m/%Y') AS dtmDate,
								  DATE_FORMAT(dtmSailingDate,'%d/%m/%Y') AS dtmETD,
								  SUM(dblQuantity) AS qty,
								  CIH.strTransportMode,
								  FI.strBL,
								  FI.strHAWB,
								  FI.strFCR
								FROM eshipping.shipmentplheader SPH
								  INNER JOIN eshipping.commercial_invoice_detail CID
									ON CID.strPLno = SPH.strPLNo
								  INNER JOIN eshipping.commercial_invoice_header CIH
									ON CIH.strInvoiceNo = CID.strInvoiceNo
								  INNER JOIN eshipping.finalinvoice FI
									ON CIH.strInvoiceNo = FI.strInvoiceNo
								WHERE intStyleId = '$styleid' AND CIH.intType!='99'
									AND intShipped = 1 AND CIH.strInvoiceType='F'
								GROUP BY CIH.strInvoiceNo ";
				$result_shipping_dpt=$db->RunQuery($str_shipping_dpt);
				while($row_shipping_dpt=mysql_fetch_array($result_shipping_dpt)){
				?>
                <tr bgcolor="#FFFFFF">
                  <td><?php echo $row_shipping_dpt["strInvoiceNo"];?></td>
                  <td><?php echo $row_shipping_dpt["dtmDate"];?></td>
                  <td><?php echo $row_shipping_dpt["dtmETD"];?></td>
                  <td><?php echo $row_shipping_dpt["strTransportMode"];?></td>
                  <td><?php echo $row_shipping_dpt["strBL"].$row_shipping_dpt["strHAWB"];?></td>
                  <td><?php echo $row_shipping_dpt["strFCR"];?></td>
                  <td style="text-align:right"><?php echo $totshipped=$row_shipping_dpt["qty"];$totaltotshipped+=$totshipped;?></td>
                </tr>
                <?php }?>
                <tr bgcolor="#FFFFFF">
                  <td colspan="6"><strong>Total</strong></td>
                  <td style="text-align:right"><strong><?php echo number_format($totaltotshipped,0);?></strong></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              </fieldset></td>
            </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>     
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php 
function getManufacturer($obj){
	global $db;
	$str="SELECT strName FROM companies WHERE intcompanyiD='$obj'";
	$result=$db->RunQuery($str);
	$row=mysql_fetch_array($result);
	return $row["strName"];
}
?>