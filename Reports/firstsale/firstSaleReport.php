<?php 
session_start();
include "../../Connector.php";
$txtDfrom = $_GET["txtDfrom"];
$txtDto = $_GET["txtDto"];
$orderNo = $_GET["orderNo"];
$buyer = $_GET["buyer"];
$taxStatus = $_GET["taxStatus"];
$ocStatus = $_GET["ocStatus"];
$reportType	= $_GET["ReportType"];

if($reportType=="E")
{
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment;filename="FirstSale.xls"');
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | First Sale Reports</title>
<link href="../../css/erpstyle.css" rel="stylesheet" />
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
</head>

<body>
<table width="950" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="head2"  height="35">First Sale Report</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="950" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000" align="center" id="tblMain">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th>Order No</th>
        <th>Color</th>
        <th>Ship Qty</th>
        <th>Invoice No</th>
        <th>Dry Wash Price</th>
        <th>Dry Act Wash Price</th>
        <th>Wet Wash Price</th>
        <th>Wet Act Wash Price</th>
        <th>Pcs Per CTN</th>
        <th>CM</th>
        <th>SMV</th>
        <th>Act SMV</th>
        <th>Inv C. FOB</th>
        <th>FS FOB</th>
        <th>Diff %</th>
        <th>Buyer</th>
        <th>Pre Cost FOB</th>
        <th>Com Inv FOB</th>
        <th>BPO FOB</th>
        <?php if($reportType!="E")
{?>
        <th>OC</th>
        <th>CVW</th>
        <th>CVWS</th>
        <th>STI</th>
        <?php 
		}
		?>
      </tr>
      </thead>
      <tbody>
      <?php 
	  $sql = "select fsh.intStyleId,fsh.strOrderNo,fsh.strColor,
fsh.buyerFOB,fsh.intOrderQty,fsh.dblSMV,
fsh.dblPCScarton,fsh.dblCMvalue,fsh.dblPreorderFob,fsh.dblInvFob,fsh.dblFsaleFob,b.buyerCode,
fss.dblInvoiceId,fss.strComInvNo,fss.intStatus,fsa.dblFabricConpc as actFabConPC,fsa.dblPocketConpc as actPocConpc,
fsa.dblThreadConpc as actThreadConpc, fsa.dblSMV as actSMV, fsa.dblDryWashPrice actDryWashPrice, fsa.dblWetWashPrice as actWetWashPrice,
b.intinvFOB,fss.intTaxInvoiceConfirmBy,fsh.dblInvoiceId as ocInvoiceNo,fsh.intExtraApprovalRequired,
(select sum(cid.dblQuantity) from eshipping.commercial_invoice_detail cid inner join eshipping.shipmentplheader plh on plh.strPLNo= cid.strPLNo
where cid.strInvoiceNo = fss.strComInvNo and plh.intStyleId = fss.intStyleId group by plh.intStyleId) as shipQty,
(select  fsd.dblUnitPrice
from firstsalecostworksheetdetail fsd inner join matitemlist mil on mil.intItemSerial=fsd.intMatDetailID 
where fsd.strType='4' and mil.strItemDescription like '%WASHING - DRY %' and fsd.intStyleId = fsh.intStyleId) as dryWashprice,
(select  fsd.dblUnitPrice
from firstsalecostworksheetdetail fsd inner join matitemlist mil on mil.intItemSerial=fsd.intMatDetailID 
where fsd.strType='4' and mil.strItemDescription like '%WASHING - WET COST%' and fsd.intStyleId = fsh.intStyleId) as wetWashprice,(select distinct cid.dblUnitPrice from eshipping.commercial_invoice_detail cid inner join eshipping.shipmentplheader plh on plh.strPLNo= cid.strPLNo
where cid.strInvoiceNo = fss.strComInvNo and plh.intStyleId = fss.intStyleId) as comInvFob
from firstsalecostworksheetheader fsh inner join orders o on 
o.intStyleId = fsh.intStyleId inner join buyers b on
b.intBuyerID = o.intBuyerID 
inner join  firstsale_shippingdata fss on fss.intStyleId = fsh.intStyleId
inner join firstsale_actualdata fsa on fsa.intStyleId = fsh.intStyleId
where fsh.intStatus =10  and fss.intStatus =1 ";
	if($orderNo !='')
		$sql .= " and fsh.strOrderNo like '%$orderNo%' ";
	if($buyer != '')
		$sql .= " and b.intBuyerID = '$buyer' ";
	if($taxStatus == '0')	
		$sql .= " and fss.intTaxInvoiceConfirmBy is null ";
	if($taxStatus == '1')	
		$sql .= " and fss.intTaxInvoiceConfirmBy <> '' ";		
	if($txtDfrom != '')	
		$sql .= " and date(fsh.dtmConfirm) >= '$txtDfrom' ";
	if($txtDto != '')	
		$sql .= " and date(fsh.dtmConfirm) <= '$txtDto' ";
	if($ocStatus !='')
		$sql .= " and fsh.intExtraApprovalRequired =1 and fsh.intExtraApprovalStatus='$ocStatus' ";	
	$sql .= "order by fsh.strOrderNo ";		
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$invFOB = round(($row["intinvFOB"]==1?$row["dblInvFob"]:$row["dblPreorderFob"]),2);
		$fsFob = round($row["dblFsaleFob"],2);
		$preorderFob = round($row["dblPreorderFob"],2);
		$buyerFob = round($row["buyerFOB"],2);
		$comFob = round($row["comInvFob"],2);
		$fobDiff = round(($invFOB - $row["dblFsaleFob"])/$row["dblFsaleFob"]*100,2);
		
		$dryPrice = ($row["dryWashprice"]==''?'':round($row["dryWashprice"],2));
		$actDryWashPrice = ($row["actDryWashPrice"]==''?'':round($row["actDryWashPrice"],2));
		
		$wetWashprice = ($row["wetWashprice"]==''?'':round($row["wetWashprice"],2));
		$actWetWashPrice = ($row["actWetWashPrice"]==''?'':round($row["actWetWashPrice"],2));
		
		$clsComFob = ($invFOB != $comFob ?'bcgcolor-InvoiceCostICNA':'bcgcolor-tblrowWhite');
		$clsBuyerFob = ($invFOB != $buyerFob ?'bcgcolor-InvoiceCostICNA':'bcgcolor-tblrowWhite');
		$clsPreFob = ($invFOB != $preorderFob ?'bcgcolor-InvoiceCostICNA':'bcgcolor-tblrowWhite');
		
		$clsDryWash = ($dryPrice < $actDryWashPrice ?'bcgcolor-InvoiceCostICNA':'bcgcolor-tblrowWhite');
		$clsWetWash = ($wetWashprice < $actWetWashPrice ?'bcgcolor-InvoiceCostICNA':'bcgcolor-tblrowWhite');
	  ?>
      <tr bgcolor="#FFFFFF" class="normalfntRite">
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strOrderNo"]; ?></td>
        <td class="normalfnt" nowrap="nowrap"><?php echo $row["strColor"]; ?></td>
        <td nowrap="nowrap"><?php echo number_format($row["shipQty"],0); ?></td>
        <td nowrap="nowrap"><?php echo $row["dblInvoiceId"]; ?></td>
        <td nowrap="nowrap"><?php echo $dryPrice ?></td>
        <td nowrap="nowrap" class="<?php echo $clsDryWash; ?>"><?php echo $actDryWashPrice ?></td>
        <td nowrap="nowrap"><?php echo $wetWashprice; ?></td>
        <td nowrap="nowrap" class="<?php echo $clsWetWash; ?>"><?php echo $actWetWashPrice; ?></td>
        <td nowrap="nowrap"><?php echo $row["dblPCScarton"]; ?></td>
        <td nowrap="nowrap"><?php echo $row["dblCMvalue"]; ?></td>
        <td nowrap="nowrap"><?php echo $row["dblSMV"]; ?></td>
        <td nowrap="nowrap"><?php echo $row["actSMV"]; ?></td>
        <td nowrap="nowrap"><?php echo $invFOB; ?></td>
        <td nowrap="nowrap"><?php echo $fsFob; ?></td>
        <td nowrap="nowrap"><?php echo $fobDiff; ?></td>
        <td class="normalfnt"><?php echo $row["buyerCode"]; ?></td>
        <td nowrap="nowrap" class="<?php echo $clsPreFob; ?>"><?php echo $preorderFob; ?></td>
        <td nowrap="nowrap" class="<?php echo $clsComFob; ?>"><?php echo $comFob; ?></td>
        <td nowrap="nowrap" class="<?php echo $clsBuyerFob; ?>"><?php echo $buyerFob; ?></td>
         <?php if($reportType!="E")
	{
 if($row["intExtraApprovalRequired"]==1){?>
        <td><a href="../../firstsale/costworksheet/orderContractRpt.php?styleID=<?php echo $row["intStyleId"] ?>&invoiceID=<?php echo $row["ocInvoiceNo"]; ?>" target="orderContractRpt.php">OC</a></td>
        <?php 
		}
		else
			echo "<td>&nbsp;</td>";
		?>
        <td><a href="../../firstsale/costworksheet/costworksheetRpt.php?styleId=<?php echo $row["intStyleId"]; ?>" target="costworksheetRpt.php">CVW</a></td>
        <td><a href="../../firstsale/costworksheet/cvwsReport.php?styleID=<?php echo $row["intStyleId"]; ?>&invoiceID=<?php echo $row["dblInvoiceId"]; ?>" target="cvwsReport.php">CVWS</a></td>
        <td><a href="../../firstsale/costworksheet/taxInvoiceRpt.php?styleID=<?php echo $row["intStyleId"]; ?>&invoiceID=<?php echo $row["dblInvoiceId"]; ?>" target="taxInvoiceRpt.php">STI</a></td>
      </tr>
      <?php 
	  }
	  }
	  ?>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">

var prev_row_no=-99;

var pub_bg_color_click='#FFFFFF';

$(document).ready(function()
{
     $('#tblMain tbody tr').click(function(){
         if($(this).attr('bgColor')!='#82FF82')
             {
                 var color=$(this).attr('bgColor')
                 $(this).attr('bgColor','#82FF82')
                 if(prev_row_no!=-99){
                    $('#tblMain tbody')[0].rows[prev_row_no].bgColor=pub_bg_color_click;           
                       }
                  if(prev_row_no==$(this).index())
                   {
                         prev_row_no=-99

                                }

						else

						prev_row_no=$(this).index()                                   

						pub_bg_color_click=color                  
					   }                                             
		})
});

</script>
</body>
</html>
