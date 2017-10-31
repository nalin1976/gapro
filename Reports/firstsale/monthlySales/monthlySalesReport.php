<?php 
session_start();
$backwardseperator = "../../../";

include $backwardseperator."authentication.inc";
$txtDfrom	= date("Y-m-01");
$txtDto		= date("Y-m-d");

include "../../../Connector.php";
$txtDfrom = $_GET["txtDfrom"];
$txtDto   = $_GET["txtDto"];	
$factory = $_GET["factory"];
$buyer = $_GET["buyer"];

$buyerName = $_GET["buyerName"];
$factoryName = $_GET["factoryName"];
$reportType	= $_GET["ReportType"];

if($reportType=="E")
{
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment;filename="MonthSaleReport.xls"');
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Gapro | Inter Company Sales For the Month</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
<style type="text/css">

    table.fixHeader {

        border: solid #FFFFFF;

        border-width: 1px 1px 1px 1px;

        width: 1050px;

    }

    tbody.ctbody {

        height: 580px;

        overflow-y: auto;

        overflow-x: hidden;

    }

 

</style>
<script language="javascript" src="../../../js/jquery-1.4.2.min.js"></script>
</head>

<body>
<table width="950" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="head2"  height="35">INTER COMPANY SALES FOR THE MONTH &nbsp;<?php echo strtoupper(date('F',strtotime($txtDfrom))); ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
    <tr>
    	<td height="20"><b>Date From</b></td>
        <td width="29%"><b>:</b>&nbsp;&nbsp;<?php echo $txtDfrom; ?></td>
        <td width="7%"><b>Date To</b></td>
        <td width="53%"><b>:</b>&nbsp;&nbsp;<?php echo $txtDto; ?></td>
    </tr>
    <?php if($buyer != '') {?>
      <tr>
        <td width="11%" height="20"><b>Buyer</b></td>
        <td colspan="3"><b>:</b>&nbsp;&nbsp;<?php echo $buyerName; ?></td>
      </tr>
      <?php }
	  if($factory != '') {
	  ?>
      <tr>
        <td height="20"><b>Factory </b></td>
        <td colspan="3"><b>:</b>&nbsp;&nbsp;<?php echo $factoryName?></td>
      </tr>
      <?php } ?>
      <tr>
      	<td colspan="4">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="1081" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000" id="tblMain">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="45" rowspan="2">Ref Id</th>
        <th width="91" rowspan="2">Invoice Date</th>
        <th width="83" rowspan="2">Invoice No</th>
        <th width="50" rowspan="2">Commercial Invoice No</th>
        <th width="50" rowspan="2">Buyer</th>
        <th width="69" rowspan="2">Country</th>
        <th width="62" rowspan="2">OrderNo</th>
        <th width="49" rowspan="2">Color</th>
        <th width="39" rowspan="2">Style No</th>
        <th width="53" rowspan="2">Factory</th>
        <th width="42" rowspan="2">Type</th>
        <th width="58" rowspan="2">Ship Qty(PCS)</th>
        <th width="69" rowspan="2">Ship Qty(DOZ)</th>
        <th colspan="3">Cost Per Doz</th>
        <th colspan="3">Value (USD)</th>
        <th width="46" rowspan="2">Total</th>
        </tr>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="36">CMP</th>
        <th width="27">Wet</th>
        <th width="24">Dry</th>
        <th width="36">CMP</th>
        <th width="27">Wet</th>
        <th width="24">Dry</th>
      </tr>
     <?php 
	 $sql = "select
FSD.dblInvoiceId,FSD.strComInvNo,
DATE_FORMAT(FSH.dtmConfirm,'%d-%b-%y') as ConfirmDate,
FSD.strInvoiceNo,
B.strBuyerCode,GB.strName AS Buyer,CN.strCountry AS Country,
FSD.strOrderNo,
FSD.strOrderColorCode,
O.strStyle,
C.strCompanyCode,
FI.strGender,
CID.strDescOfGoods,
round(CID.dblQuantity/12,2) as 'Ship Qty Per DOZ',
round(CID.dblQuantity) as 'Ship Qty Per PCS',
(select round(sum(fsd.dblValue),4) as WashPrice from gapro.firstsalecostworksheetdetail fsd where O.intStyleId=fsd.intStyleId and fsd.strType=4) AS 'CMPW Cost Per PCS',
(select round(sum(fsd.dblValue*CID.dblQuantity),4) as WashPrice from gapro.firstsalecostworksheetdetail fsd 
where  fsd.strType=4 and fsd.intStyleId=O.intStyleId)as 'CMPW Cost',
(select round(sum(fsd.dblValue),4) as WashPrice from gapro.firstsalecostworksheetdetail fsd inner join gapro.matitemlist mil on mil.intItemSerial=fsd.intMatDetailID where O.intStyleId=fsd.intStyleId and mil.strItemDescription like'%WASHING - WET COST%' )as 'WET Cost Per PCS',
(select round(COALESCE(sum(fsd.dblValue),0),4) as WashPrice from gapro.firstsalecostworksheetdetail fsd inner join gapro.matitemlist mil on mil.intItemSerial=fsd.intMatDetailID where O.intStyleId=fsd.intStyleId and mil.strItemDescription like'%WASHING - DRY COST%' ) +
(select round(COALESCE(sum(FID.dblUnitprice),0),4) from firstsale_invprocessdetails FID inner join was_dryprocess WD on WD.intSerialNo= FID.intProcessId  where FID.intStyleId=O.intStyleId and WD.FScategory=4) as 'DRY Cost Per PCS'
from gapro.firstsale_shippingdata FSD
inner join eshipping.commercial_invoice_header CIH on CIH.strInvoiceNo=FSD.strComInvNo
inner join eshipping.buyers B on B.strBuyerID=CIH.strBuyerID
inner join eshipping.customers C on C.strCustomerID=CIH.strCompanyID
inner join gapro.orders O on O.intStyleId=FSD.intStyleId
INNER JOIN gapro.buyers GB ON GB.intBuyerID = O.intBuyerID
inner join eshipping.commercial_invoice_detail CID on CID.strInvoiceNo=CIH.strInvoiceNo 
INNER JOIN firstsalecostworksheetheader FSH ON FSH.intStyleId = FSD.intStyleId
inner join eshipping.shipmentplheader PLH ON PLH.intStyleId = FSH.intStyleId AND CID.strPLNo = PLH.strPLNo
INNER JOIN eshipping.city CT ON CT.strCityCode = CIH.strFinalDest
INNER JOIN eshipping.country CN ON CN.strCountryCode = CT.strCountryCode
inner join eshipping.finalinvoice FI on FI.strInvoiceNo = CIH.strInvoiceNo
where DATE(FSH.dtmConfirm) BETWEEN '$txtDfrom' AND '$txtDto' AND FSH.intStatus=10 AND FSD.intStatus=1 ";
	if($factory != '')
		$sql .= " and CIH.strCompanyID = '$factory' ";
	if($buyer != '')
		$sql .= " and O.intBuyerID = '$buyer' ";
	$sql .= " order by FSD.dblInvoiceId ";	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$shipQtyPcs 	= $row["Ship Qty Per PCS"];
		$shipQtyDoz 	= $row["Ship Qty Per DOZ"];
		$cmpDozCost 	= $row["CMPW Cost Per PCS"]*12;
		$wetDozCost 	= $row["WET Cost Per PCS"]*12;
		$dryDozCost 	= $row["DRY Cost Per PCS"]*12;
		
		
		$wetValue		= $shipQtyPcs*$row["WET Cost Per PCS"];
		$dryValue 		= $shipQtyPcs*$row["DRY Cost Per PCS"];
		
		
		$totOrderCost 	= round($row["CMPW Cost Per PCS"],2)*$shipQtyPcs;//$cmpValue + $wetValue + $dryValue;
		$cmpValue 		= $totOrderCost-$wetValue-$dryValue;
		
		$totShipQtyPcs 	+= $shipQtyPcs;
		$totShipQtyDoz 	+= $shipQtyDoz;
		
		$totcmpDozCost 	+= $cmpDozCost;
		$totwetDozCost 	+= $wetDozCost;
		$totdryDozCost 	+= $dryDozCost;
		
		$totcmpValue 	+= $cmpValue;
		$totwetValue 	+= $wetValue;
		$totdryValue 	+= $dryValue;
					
		$totValue 		+= $totOrderCost;
		
	 ?> 
      <tr bgcolor="#FFFFFF" class="normalfntRite">
        <td height="20" class="normalfnt"><?php echo $row["dblInvoiceId"]; ?></td>
        <td class="normalfnt" ><?php echo $row["ConfirmDate"]; ?></td>
        <td class="normalfnt" nowrap><?php echo $row["strInvoiceNo"]; ?></td>
        <td class="normalfnt" nowrap><?php echo $row["strComInvNo"]; ?></td>
        <td class="normalfnt" nowrap><?php echo $row["Buyer"]; ?></td>
        <td class="normalfnt" nowrap><?php echo $row["Country"]; ?></td>
       <td class="normalfnt" nowrap><?php echo $row["strOrderNo"]; ?></td>
       <td class="normalfnt" nowrap><?php echo $row["strOrderColorCode"]; ?></td>
        <td class="normalfnt" nowrap><?php echo $row["strStyle"]; ?></td>
         <td class="normalfnt" nowrap><?php echo $row["strCompanyCode"]; ?></td>
        <td class="normalfnt" nowrap><?php echo $row["strGender"]; ?></td>
        <td><?php echo number_format($shipQtyPcs,0); ?></td>
        <td><?php echo number_format($shipQtyDoz,4); ?></td>
        <td><?php echo number_format($cmpDozCost,4); ?></td>
        <td><?php echo number_format($wetDozCost,4); ?></td>
         <td><?php echo number_format($dryDozCost,4); ?></td>
      <td><?php echo number_format($cmpValue,4); ?></td>
        <td><?php echo number_format($wetValue,4); ?></td>
         <td><?php echo number_format($dryValue,4); ?></td>
         <td><?php echo number_format($totOrderCost,4); $totOrderCost=0;?></td>
        </tr>
        <?php 
		}
		?>
        <tr bgcolor="#FFFFFF" class="normalfntRite">
        <td colspan="11" class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Grand Total</b></td>
        <td><b><?php echo number_format($totShipQtyPcs,4); ?></b></td>
        <td><b><?php echo number_format($totShipQtyDoz,4); ?></b></td>
        <td><b><?php echo number_format($totcmpDozCost,4); ?></b></td>
        <td><b><?php echo number_format($totwetDozCost,4); ?></b></td>
        <td><b><?php echo number_format($totdryDozCost,4); ?></b></td>
        <td><b><?php echo number_format($totcmpValue,4); ?></b></td>
        <td><b><?php echo number_format($totwetValue,4); ?></b></td>
        <td><b><?php echo number_format($totdryValue,4); ?></b></td>
         <td><b><?php echo number_format($totValue,4); ?></b></td>
        </tr>
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
