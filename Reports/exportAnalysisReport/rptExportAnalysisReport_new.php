<?php
include "../../Connector.php";
$txtDfrom = $_GET["txtDfrom"];
$txtDto = $_GET["txtDto"];
$reportType	= $_GET["ReportType"];

if($reportType=="E")
{
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment;filename="ExportAnalysis.xls"');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>EXPORT SALES FOR THE MONTH</title>
<style type="text/css">
<!--
tbody.ctbody1 {
        height: 580px;

        overflow-y: auto;

        overflow-x: hidden;
}
-->
</style>
</head>
<link type="text/css"  href="../../css/erpstyle.css" rel="stylesheet" />
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

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="head2">EXPORT SALES FOR THE MONTH <?php echo strtoupper(date('F',strtotime($txtDfrom))); ?> <?php echo date('Y',strtotime($txtDfrom)); ?></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0">
     
      <tr>
        <td width="1%">&nbsp;</td>
        <td width="4%" class="normalfnt"><b>Date From</b></td>
        <td width="1%"  class="normalfntMid"><b>:</b></td>
        <td class="normalfnt" width="6%"><?php echo $txtDfrom?></td>
        <td class="normalfntMid" width="2%"><b>To</b></td>
        <td width="80%"  >&nbsp;<b>:<span class="normalfnt"><?php echo $txtDto?></span></b></td>
        <td width="6%" colspan="2" class="normalfnt">&nbsp;</td>
      </tr>
    </table></td></tr>
  <tr>
    <td><table width="100%" cellspacing="1" cellpadding="1"  bgcolor="#000000" id="tblMain" class="fixHeader">
      <thead>
        <tr bgcolor="#CCCCCC">
          <th width="1%" rowspan="2" class="normalfntMid" scope="col">No</th>
          <th width="1%" rowspan="2" class="normalfntMid" scope="col">INV DATE</th>
          <th width="2%" rowspan="2" class="normalfntMid" scope="col">INV.NO.</th>
          <th width="2%" rowspan="2" class="normalfntMid" scope="col">BUYER</th>
          <th width="1%" rowspan="2" class="normalfntMid" scope="col">PO NO</th>
          <th width="2%" rowspan="2" class="normalfntMid" scope="col">FACTORY</th>
          <th width="2%" rowspan="2" class="normalfntMid" scope="col">COL/DIM</th>
          <th width="2%" rowspan="2" class="normalfntMid" scope="col">STYLE NO </th>
          <th width="1%" rowspan="2" class="normalfntMid" scope="col">Style Name </th>
          <th width="1%" rowspan="2" class="normalfntMid" scope="col">Total <br/>
            DOZ </th>
          <th colspan="6" class="normalfntMid" scope="col">DOZEN</th>
          <th class="normalfntMid" scope="col" colspan="22" height="21">COST PER DZN</th>
          <th colspan="13" class="normalfntMid" scope="col" >VALUE (US$)</th>
          <th colspan="21" class="normalfntMid" scope="col" >&nbsp;</th>
        </tr>
        <tr bgcolor="#CCCCCC">
          <th width="1%" class="normalfntMid" scope="col">EMB</th>
          <th class="normalfntMid" scope="col">MR</th>
          <th class="normalfntMid" scope="col"> LAG</th>
          <th class="normalfntMid" scope="col">GC</th>
          <th width="1%" class="normalfntMid" scope="col">DUM</th>
          <th class="normalfntMid" scope="col">WASH</th>
          <th width="2%"  class="normalfntMid" scope="col">FABRIC <br/>
            COST </th>
          <th width="2%" class="normalfntMid" scope="col">FABRIC <br/>
            FINANCE</th>
          <th width="2%" class="normalfntMid" scope="col">TOTAL FABRIC COST</th>
          <th width="3%" class="normalfntMid" scope="col">ACCESSORIES <br/>
            COST</th>
          <th width="3%"  class="normalfntMid" scope="col">ACCESSORIES<br/>
            FINANCE</th>
          <th width="3%"  class="normalfntMid" scope="col">TOTAL ACCESSORIES COST </th>
          <th width="2%"  class="normalfntMid" scope="col">PACKING COST </th>
          <th width="2%"  class="normalfntMid" scope="col">PACKING FINANCE </th>
          <th width="2%"  class="normalfntMid" scope="col">HANGERS</th>
          <th width="2%"  class="normalfntMid" scope="col">TOTAL PACKING COST </th>
          <th width="3%"  class="normalfntMid" scope="col">EMBROIDERY COST </th>
          <th width="2%"  class="normalfntMid" scope="col">TESTING COST </th>
          <th width="2%"  class="normalfntMid" scope="col">PRINTING COST </th>
          <th width="2%"  class="normalfntMid" scope="col">INWARD FRIEGHT </th>
          <th width="2%" class="normalfntMid" scope="col">OUTWARD FRIEGHT </th>
          <th width="1%"  class="normalfntMid" scope="col">CM</th>
          <th width="2%"  class="normalfntMid" scope="col">OTHER COST </th>
          <th width="2%"  class="normalfntMid" scope="col">PROFIT</th>
          <th width="2%"  class="normalfntMid" scope="col"><strong>DESTINATION CHARGES</strong></th>
          <th width="3%" class="normalfntMid" scope="col">INSURANCE</th>
          <th width="1%" class="normalfntMid" scope="col">WET</th>
          <th width="1%"  class="normalfntMid" scope="col">DRY</th>
          <th width="2%"  class="normalfntMid" scope="col">TTL VALUE (USD)</th>
          <th width="1%"  class="normalfntMid" scope="col">TTL INVOICE VALUE (USD) </th>
          <th width="1%"  class="normalfntMid" scope="col">DIFF</th>
          <th width="1%"  class="normalfntMid" scope="col">EMB</th>
          <th width="1%"  class="normalfntMid" scope="col">MR</th>
          <th width="1%"  class="normalfntMid" scope="col">LAG</th>
          <th width="1%"  class="normalfntMid" scope="col">GC</th>
          <th width="1%"  class="normalfntMid" scope="col">DUM</th>
          <th width="1%"  class="normalfntMid" scope="col">WET WASH</th>
          <th width="1%"  class="normalfntMid" scope="col">DRY WASH</th>
          <th width="3%"  class="normalfntMid" scope="col">INWARD FRIEGHT</th>
          <th width="3%"  class="normalfntMid" scope="col">OUTWARD FRIEGHT</th>
          <th width="3%"  class="normalfntMid" scope="col">DISCOUNT</th>
          <th width="2%"  class="normalfntMid" scope="col">UNIT PRICE (USD)</th>
          <th width="2%"  class="normalfntMid" scope="col">VALUE (USD)</th>
          <th width="2%"  class="normalfntMid" scope="col">OCEAN FREIGHT</th>
          <th width="2%"  class="normalfntMid" scope="col">INSURANCE</th>
          <th width="2%"  class="normalfntMid" scope="col">FABRIC VALUE </th>
          <th width="2%"  class="normalfntMid" scope="col">FABRIC FINANCE VALUE </th>
          <th width="2%"  class="normalfntMid" scope="col">TOTAL FABRIC VALUE</th>
          <th width="3%"  class="normalfntMid" scope="col">ACCESSORIES VALUE</th>
          <th width="3%"  class="normalfntMid" scope="col">ACCESSORIES FINANCE VALUE</th>
          <th width="3%"  class="normalfntMid" scope="col">TOTAL ACCESSORIES VALUE</th>
          <th width="2%"  class="normalfntMid" scope="col">PACKING VALUE </th>
          <th width="2%"  class="normalfntMid" scope="col">PACKING FINANCE VALUE </th>
          <th width="2%"  class="normalfntMid" scope="col">HANGER VALUE </th>
          <th width="2%"  class="normalfntMid" scope="col">TOTAL PACKING VALUE </th>
          <th width="2%"  class="normalfntMid" scope="col">EMBROIDERY VALUE</th>
          <th width="2%"  class="normalfntMid" scope="col">TESTING VALUE </th>
          <th width="2%"  class="normalfntMid" scope="col">PRINTING VALUE </th>
          <th width="2%"  class="normalfntMid" scope="col">OTHER COST VALUE</th>
          <th width="3%"  class="normalfntMid" scope="col">CM VALUE </th>
          <th width="2%"  class="normalfntMid" scope="col">PROFIT</th>
          <th width="5"  class="normalfntMid">&nbsp;</th>
        </tr>
      </thead>
      <tbody class="ctbody1">
        <?php
$sql="delete from rpt_exportsalessummary";
$result=$db->RunQuery($sql);

$sql = "select date(cih.dtmInvoiceDate) as comInvoiceDate,cid.strInvoiceNo,b.strBuyerID,b.strBuyerCode,cid.strBuyerPONo,c.strCustomerID,c.strCompanyCode,
 cid.strStyleID,o.strDescription, round((cid.dblQuantity/12),2) as TTL,o.reaFinPercntage,
 if(GB.intinvFOB=1,(SELECT IH.dblNewCM*12 FROM invoicecostingheader IH WHERE IH.intStyleId = o.intStyleId),(round((o.reaSMV*o.reaSMVRate)*12,4))) as preCMvalue,
o.strOrderColorCode,
 if(GB.intinvFOB=1,(select sum(ID.dblValue*dblFinance/100) FROM invoicecostingdetails ID WHERE ID.intStyleId = o.intStyleId AND ID.strType=1),
	(select round((sum(od.dbltotalcostpc)*o.reaFinPercntage/100)*12,4) as fabFinance from gapro.orderdetails od inner join gapro.invoicecostingdetails id on
	od.intStyleId = id.intStyleId and id.strItemCode = od.intMatDetailID 
	inner join gapro.itempurchasetype i on i.intOriginNo = od.intOriginNo
	where od.intStyleId=o.intStyleId and id.strType=1 and i.intType=0)) AS fabFinance,
 if(GB.intinvFOB=1,(select sum(ID.dblValue+ID.dblValue*reaWastage/100) from invoicecostingdetails ID
	WHERE ID.intStyleId=o.intStyleId AND ID.strType=1),
	(select (sum(od.dbltotalcostpc))*12 as fabFinance from gapro.orderdetails od inner join gapro.invoicecostingdetails id on
	od.intStyleId = id.intStyleId and id.strItemCode = od.intMatDetailID 
	inner join gapro.itempurchasetype i on i.intOriginNo = od.intOriginNo
	where od.intStyleId=o.intStyleId and id.strType=1 )) as fabCost,
if(GB.intinvFOB=1,(select sum(ID.dblValue*dblFinance/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON MIL.intItemSerial=ID.strItemCode
	WHERE ID.intStyleId = o.intStyleId AND 	(ID.strType =2 OR MIL.intMainCatID=2)),
	(select round((sum(od.dbltotalcostpc)*o.reaFinPercntage/100)*12,4) as accFinance from orderdetails od inner join invoicecostingdetails id on
	od.intStyleId = id.intStyleId and id.strItemCode = od.intMatDetailID 	inner join itempurchasetype i on i.intOriginNo = od.intOriginNo
	inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID  and mil.intItemSerial=id.strItemCode
	where od.intStyleId=o.intStyleId 
	and (id.strType=2  or mil.intMainCatID=2)  and i.intType=0)) AS accFinance,
 if(GB.intinvFOB=1,(SELECT SUM(ID.dblValue+ID.dblValue*reaWastage/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON MIL.intItemSerial=ID.strItemCode
	WHERE ID.intStyleId = o.intStyleId AND (ID.strType =2 OR MIL.intMainCatID=2)),
	(select (sum(od.dbltotalcostpc))*12 as accCost from orderdetails od left join invoicecostingdetails id on
	od.intStyleId = id.intStyleId and id.strItemCode = od.intMatDetailID 	inner join itempurchasetype i on i.intOriginNo = od.intOriginNo
	inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID 
	where od.intStyleId=o.intStyleId 
	and (id.strType=2  or mil.intMainCatID=2))) AS accCost,
 if(GB.intinvFOB=1,(SELECT SUM(ID.dblValue*dblFinance/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON
	MIL.intItemSerial = ID.strItemCode WHERE MIL.intSubCatID not in(11,36) AND ID.intStyleId = o.intStyleId AND MIL.intMainCatID=3),
	(select round((sum(od.dbltotalcostpc)*o.reaFinPercntage/100)*12,4) as pacFinance from orderdetails od 
	inner join itempurchasetype i on i.intOriginNo = od.intOriginNo inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID  
	where od.intStyleId=o.intStyleId  and (mil.intMainCatID=3) and mil.intSubCatID not in(11,36)  and i.intType=0)) AS pacFinance,
if(GB.intinvFOB=1,(SELECT SUM(ID.dblValue+ID.dblValue*ID.reaWastage/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON
	MIL.intItemSerial = ID.strItemCode WHERE  ID.intStyleId = o.intStyleId AND MIL.intMainCatID=3 ),
	(select (sum(od.dbltotalcostpc))*12 as pacCost from orderdetails od inner join itempurchasetype i on i.intOriginNo = od.intOriginNo
	inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID  
	where od.intStyleId=o.intStyleId  and (mil.intMainCatID=3) )) AS pacCost,
if(GB.intinvFOB=1,(SELECT SUM(ID.dblValue+ID.dblValue*ID.reaWastage/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON
	MIL.intItemSerial = ID.strItemCode  WHERE MIL.intSubCatID in(11) AND ID.intStyleId=o.intStyleId),(select sum(od.dbltotalcostpc)*12 as hangerCost from orderdetails od 
	inner join itempurchasetype i on i.intOriginNo = od.intOriginNo inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID  
	where od.intStyleId=o.intStyleId  
	and (mil.intMainCatID=2) and mil.intSubCatID  in(11))) AS hangerCost,
if(GB.intinvFOB=1,(SELECT SUM(ID.dblValue*ID.dblFinance/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON
	MIL.intItemSerial = ID.strItemCode  WHERE MIL.intSubCatID in(11) AND ID.intStyleId=o.intStyleId),(select sum(od.dbltotalcostpc) as hangerCost from orderdetails od 
	inner join itempurchasetype i on i.intOriginNo = od.intOriginNo inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID  
	where od.intStyleId=o.intStyleId  
	and (mil.intMainCatID=3) and mil.intSubCatID  in(11) AND  i.intType=0)) AS hangerFinanceCost,
 if(GB.intinvFOB=1,(SELECT SUM(ID.dblValue+ID.dblValue*ID.reaWastage/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON
	MIL.intItemSerial = ID.strItemCode WHERE MIL.intMainCatID =4 AND MIL.strItemDescription like '%EMBROIDERY%' AND ID.intStyleId=o.intStyleId),
	(select (sum(od.dbltotalcostpc))*12 as fabFinance from orderdetails od 
	inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID  where od.intStyleId=o.intStyleId 
	and (mil.intMainCatID=4) and mil.strItemDescription like '%EMBROIDERY%')) AS embroideryCost,
  if(GB.intinvFOB=1,(SELECT SUM(ID.dblValue+ID.dblValue*ID.reaWastage/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON
	MIL.intItemSerial = ID.strItemCode WHERE MIL.intMainCatID =4 AND MIL.strItemDescription like '%PRINTING%' AND ID.intStyleId=o.intStyleId),(select (sum(od.dbltotalcostpc))*12 as fabFinance from orderdetails od 
	inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID  where od.intStyleId=o.intStyleId 
	and (mil.intMainCatID=4) and mil.strItemDescription like '%PRINTING%')) AS printCost,
 if(GB.intinvFOB=1,round((select IH.dblTotalCostValue from invoicecostingheader IH where IH.intStyleId=o.intStyleId),2),round((select O1.reaFOB from orders O1 where O1.intStyleId=o.intStyleId),2)) * 12 as fob,
	(select dblTotalCostValue from  invoicecostingheader ih where ih.intStyleId=o.intStyleId) as invFob,
 if(GB.intinvFOB=1,(SELECT SUM(IP.dblUnitPrice) FROM invoicecostingproceses IP  WHERE IP.intStyleId=o.intStyleId),(select (sum(od.dbltotalcostpc))*12 as fabFinance from orderdetails od 
	inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID  
	where od.intStyleId=o.intStyleId 
	and (mil.intMainCatID=5))) AS otherCost,
if(GB.intinvFOB=1,(SELECT SUM(ID.dblValue+ID.dblValue*ID.reaWastage/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON
	MIL.intItemSerial = ID.strItemCode WHERE MIL.intMainCatID =6 AND MIL.strItemDescription like '%WASHING - WET COST%' AND ID.intStyleId=o.intStyleId),
	(select od.dbltotalcostpc*12 as wetWashPrice
	from orderdetails od inner join matitemlist mil on mil.intItemSerial=od.intMatDetailID
	where mil.strItemDescription like'%WASHING - WET COST%' and od.intStyleId=o.intStyleId)) AS wetWashPrice,
if(GB.intinvFOB=1,(SELECT SUM(ID.dblValue+ID.dblValue*ID.reaWastage/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON
	MIL.intItemSerial = ID.strItemCode WHERE MIL.intMainCatID =6 AND MIL.strItemDescription like '%WASHING - DRY COST%' AND ID.intStyleId=o.intStyleId),
	(select od.dbltotalcostpc*12 as wetWashPrice
	from orderdetails od inner join matitemlist mil on mil.intItemSerial=od.intMatDetailID
	where mil.strItemDescription like'%WASHING - DRY COST%' and od.intStyleId=o.intStyleId)) AS dryWashPrice,
(SELECT round(SUM(pfd.lngRecQty)/12,2) as washReceivQty from productionfinishedgoodsreceivedetails pfd 
inner join productionfinishedgoodsreceiveheader pfh on pfh.dblTransInNo = pfd.dblTransInNo and 
pfh.intGPTYear = pfd.intGPTYear where pfh.intStyleNo=o.intStyleId ) as washReceivQty,
if(cn.strCountry='INDIA',(0),(fi.dblInsurance*12)) as Insurance,
if(cn.strCountry='INDIA',(0),(fi.dblFreight*12)) as freight,
splh.strColor,
if(GB.intinvFOB=1,(SELECT SUM(ID.dblValue+ID.dblValue*ID.reaWastage/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON
	MIL.intItemSerial = ID.strItemCode WHERE  MIL.strItemDescription like '%AIR FRIGHT%' AND ID.intStyleId=o.intStyleId),(select od.dbltotalcostpc*12 
	from orderdetails od inner join matitemlist mil on mil.intItemSerial=od.intMatDetailID
	where mil.strItemDescription like'% AIR FRIGHT %' and od.intStyleId=o.intStyleId)) AS invertFrieght,
if(GB.intinvFOB=1,(SELECT SUM(ID.dblValue+ID.dblValue*ID.reaWastage/100) FROM invoicecostingdetails ID INNER JOIN matitemlist MIL ON
	MIL.intItemSerial = ID.strItemCode WHERE  MIL.intMainCatID =4 AND ID.intStyleId=o.intStyleId),(select (sum(od.dbltotalcostpc))*12  from orderdetails od 
	inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID  
	where od.intStyleId=o.intStyleId  and (mil.intMainCatID=4))) AS serviceCost,
if(GB.intinvFOB=1,(0),(o.dblFacProfit*12)) as facProfit,
if(GB.intinvFOB=1,(0),(o.reaECSCharge*12)) as reaECSCharge,
cid.dblUnitPrice as comInvPrice,cid.dblQuantity as comInvQty,
fi.dblInsurance*12 as comInvInsurance,fi.dblFreight*12 as comInvFreight, fi.dblDestCharge*12 as dblDestCharge,
fi.dblDiscount as dblDiscount
from gapro.orders o inner join eshipping.shipmentplheader splh on splh.intStyleId=o.intStyleId
 inner join eshipping.commercial_invoice_detail cid on splh.strPLNo = cid.strPLNo 
inner join eshipping.commercial_invoice_header cih on cih.strInvoiceNo= cid.strInvoiceNo
inner join eshipping.buyers b on b.strBuyerID = cih.strBuyerID
inner join eshipping.customers c on c.strCustomerID = cih.strCompanyID
inner join eshipping.finalinvoice fi on fi.strInvoiceNo = cih.strInvoiceNo
inner join gapro.buyers GB on GB.intBuyerID=o.intBuyerID
inner join eshipping.city CT ON CT.strCityCode = cih.strFinalDest
inner join eshipping.country cn on cn.strCountryCode = CT.strCountryCode
where date(cih.dtmInvoiceDate) between '$txtDfrom' and '$txtDto' and cih.strInvoiceType='F' 
order by date(cih.dtmInvoiceDate),cid.strInvoiceNo    ";
//order by strBuyerCode,strCompanyID   -- date(cih.dtmInvoiceDate),cid.strInvoiceNo
$result=$db->RunQuery($sql);
//echo $sql;
while($row=mysql_fetch_array($result))
{	
	$totalWashQty		= round($row["TTL"],2); //$row["washReceivQty"]
	$profit				= round($row["facProfit"],4);
	$fabricCost			= round($row["fabCost"],4);
	$fabricFinance		= round($row["fabFinance"]+$row["reaECSCharge"],4);
	$totOrderFabCost 	= round($fabricCost+$fabricFinance,4);
	
	$acceCost			= round($row["accCost"],4);
	$acceFinance		= round($row["accFinance"],4);
	$packingHaging		= round($row["hangerCost"],4);
	$packingHangerFinance = round($row["hangerFinanceCost"],4);
	
	$acceCost -= $packingHaging;
	$acceFinance -= $packingHangerFinance;
	$totHangingCost 	= $packingHaging + $packingHangerFinance;
	$orderAccCost 		= round($acceCost+$acceFinance,4);
	
	$packingCost		= round($row["pacCost"],4);
	$packingFinance		= round($row["pacFinance"],4);
	
	$orderPacCost 		= round($packingCost+$packingFinance+$totHangingCost,4);
	
	$printCost			= round($row["printCost"],4);
	$printValue			= round($printCost*$totalWashQty,4);
	
	$embroideryCost		= round($row["embroideryCost"],4);
	$embroideryValue	= round($embroideryCost*$totalWashQty,4);
	
	$fabricValue		= round($fabricCost*$totalWashQty,4);
	$fabricFinanceValue	= round($fabricFinance*$totalWashQty,4);	
	$totalFabricValue 	= round($fabricValue+$fabricFinanceValue,4);
	
	$acceValue			= round($acceCost*$totalWashQty,4);
	$acceFinanceValue	= round($acceFinance*$totalWashQty,4);	
	$totalAcceValue 	= round($acceValue+$acceFinanceValue,4);
	
	$packingValue		= round($packingCost*$totalWashQty,4);
	$packingFinanceValue= round($packingFinance*$totalWashQty,4);
	$packingHagingValue	= round($packingHaging*$totalWashQty);
	$totalPackingValue	= round($packingValue+$packingFinanceValue+$packingHagingValue,4);
	
	$cm					= round($row["preCMvalue"],2);
	$cmValue			= round($cm*$totalWashQty,2);
	
	$serviceCost 		= round($row["serviceCost"],4);
	$otherCost 			= $row["otherCost"] + $serviceCost - $embroideryCost - $printCost-$row["invertFrieght"];
	$otherValue			= round($otherCost*$totalWashQty,4);
	$unitPrice			= round($row["fob"]+round($row["freight"],2)+round($row["Insurance"],2)+round($row["dblDestCharge"],2),2);
	$value_usd			= round($totalWashQty*($unitPrice),2);
	$dblDestCharge 		= round($row["dblDestCharge"],2);
	$dblDiscount 		= round($row["dblDiscount"],2);
	
?>
        
        <tr bgcolor="#FFFFFF">
          <td class="normalfntRite"><?php echo ++$i;?></td>
          <td class="normalfnt"><?php echo $row["comInvoiceDate"];?></td>
          <td class="normalfnt" nowrap="nowrap"><?php echo $row["strInvoiceNo"];?></td>
          <td class="normalfnt" nowrap="nowrap"><?php echo $row["strBuyerCode"]; ?></td>
          <td class="normalfnt" nowrap="nowrap"><?php echo $row["strBuyerPONo"];?></td>
          <td class="normalfnt"><?php echo $row["strCompanyCode"];?></td>
          <td class="normalfnt" nowrap="nowrap"><?php echo $row["strColor"];?></td>
          <td class="normalfnt" nowrap="nowrap"><?php echo $row["strStyleID"];?></td>
          <td class="normalfnt" nowrap="nowrap"><?php echo $row["strDescription"];?></td>
          <td class="normalfntRite"><?php echo $row["TTL"]; ?></td>
          <td  class="normalfntRite"><?php echo ($embCost = ($row["strCompanyCode"]=='EMB'?$row["TTL"]:'')); ?></td>
          <td width="1%" class="normalfntRite"><?php echo ($MRCost = ($row["strCompanyCode"]=='MAR'?$row["TTL"]:'')); ?></td>
          <td width="1%" class="normalfntRite"><?php echo ($NAUCost = ($row["strCompanyCode"]=='NAU'?$row["TTL"]:'')); ?></td>
          <td width="1%" class="normalfntRite"><?php echo ($SW3Cost = ($row["strCompanyCode"]=='SW3'?$row["TTL"]:'')); ?></td>
          <td>&nbsp;</td>
          <td width="1%" class="normalfntRite"><?php echo $totalWashQty; ?></td>
          <td width="2%" class="normalfntRite"><?php echo number_format($fabricCost,4); ?></td>
          <td width="2%" class="normalfntRite"><?php echo number_format($fabricFinance,4); ?></td>
          <td width="2%"  class="normalfntRite"><?php echo number_format($totOrderFabCost,4); ?></td>
          <td width="3%" class="normalfntRite"><?php echo number_format($acceCost,4); ?></td>
          <td width="3%" class="normalfntRite"><?php echo number_format($acceFinance,4); ?></td>
          <td width="3%"  class="normalfntRite"><?php echo number_format($orderAccCost,4); ?></td>
          <td width="2%" class="normalfntRite"><?php echo number_format($packingCost,4); ?></td>
          <td width="2%" class="normalfntRite"><?php echo number_format($packingFinance,4); ?></td>
          <td width="2%" class="normalfntRite"><?php echo number_format($packingHaging,4); ?></td>
          <td width="2%" class="normalfntRite"><?php echo number_format($orderPacCost,4);?></td>
          <td width="3%" class="normalfntRite"><?php echo $embroideryCost; ?></td>
          <td width="2%">&nbsp;</td>
          <td width="2%" class="normalfntRite"><?php echo $printCost; ?></td>
          <td width="2%" class="normalfntRite"><?php echo $row["invertFrieght"]; ?></td>
          <td width="2%" class="normalfntRite"><?php echo ($row["freight"]==0?'':$row["freight"]); ?></td>
          <td width="1%" class="normalfntRite"><?php echo number_format($cm,2); ?></td>
          <td width="2%" class="normalfntRite"><?php echo $otherCost; ?></td>
          <td width="2%" class="normalfntRite"><?php echo $profit;?></td>
          <td width="2%" class="normalfntRite"><?php echo $row["dblDestCharge"]; ?></td>
          <td width="3%" class="normalfntRite"><?php echo ($row["Insurance"]==0?'':$row["Insurance"]); ?></td>
          <td width="1%" class="normalfntRite"><?php echo $row["wetWashPrice"]; ?></td>
          <td width="1%" class="normalfntRite"><?php echo $row["dryWashPrice"]; ?></td>
          <td width="2%" class="normalfntRite"><?php
		$TTLValue = ($row["comInvQty"]*($totOrderFabCost+$orderAccCost+$orderPacCost+$embroideryCost+$printCost+$cm+$otherCost+$profit+$row["wetWashPrice"]+$row["dryWashPrice"]+$row["invertFrieght"]+$row["freight"]+$row["Insurance"]+$row["dblDestCharge"]))/12  - $dblDiscount*$row["comInvQty"];
		echo number_format($TTLValue,0); ?></td>
          <td class="normalfntRite"><?php $Comval = round(($row["comInvPrice"])*$row["comInvQty"]+($row["comInvInsurance"]/12)*$row["comInvQty"] + ($row["comInvFreight"]/12)*$row["comInvQty"] + ($dblDestCharge/12)*$row["comInvQty"],2);
		  echo  number_format($Comval,0); ?></td>
          <td class="normalfntRite"><?php echo number_format(round($TTLValue,0) - round($Comval,0),0);?></td>
          <td class="normalfntRite"><?php 
		$EMBvalue = $embCost*($totOrderFabCost+$orderAccCost+$orderPacCost+$embroideryCost+$printCost+$cm+$otherCost+$profit);
		echo ($EMBvalue != ''?round($EMBvalue,2):''); 
		?></td>
          <td class="normalfntRite"><?php 
		$MRValue = $MRCost*($totOrderFabCost+$orderAccCost+$orderPacCost+$embroideryCost+$printCost+$cm+$otherCost+$profit);
		echo ($MRValue != ''?round($MRValue,2):''); 
		?></td>
          <td class="normalfntRite"><?php 
		$NAUvalue = $NAUCost*($totOrderFabCost+$orderAccCost+$orderPacCost+$embroideryCost+$printCost+$cm+$otherCost+$profit);
		echo ($NAUvalue != ''?round($NAUvalue,2):''); 
		?></td>
          <td class="normalfntRite"><?php 
		$SW3Value = $SW3Cost*($totOrderFabCost+$orderAccCost+$orderPacCost+$embroideryCost+$printCost+$cm+$otherCost+$profit);
		echo ($SW3Value != ''?round($SW3Value,2):''); ?></td>
          <td>&nbsp;</td>
          <td class="normalfntRite"><?php $wetValue=round($row["wetWashPrice"]*$totalWashQty,2);
		echo ($wetValue==0?'':round($wetValue,2)); ?></td>
          <td class="normalfntRite"><?php $dryValue=round($row["dryWashPrice"]*$totalWashQty,2);
		echo ($dryValue==0?'':round($dryValue,2)); ?></td>
          <td class="normalfntRite"><?php $invertval = round($row["TTL"]*$row["invertFrieght"],4); echo number_format($invertval,4); ?></td>
          <td class="normalfntRite"><?php  $outvertVal = round($row["TTL"]*$row["freight"],4); echo number_format($outvertVal,4); ?></td>
          <td class="normalfntRite"><?php  $discountVal = round($row["comInvQty"]*$dblDiscount,4); echo number_format($discountVal,4); ?></td>
          <td class="normalfntRite"><?php echo number_format($unitPrice,2);?></td>
          <td class="normalfntRite"><?php echo number_format($value_usd,2);?></td>
          <td class="normalfntRite"><?php echo ($row["freight"]==0?'':$row["freight"]); ?></td>
          <td class="normalfntRite"><?php $insuranceValue = round($row["Insurance"]*$row["TTL"],2);
		echo ($insuranceValue==0?'':round($insuranceValue,2)); ?></td>
          <td class="normalfntRite"><?php echo number_format($fabricValue,4);?></td>
          <td class="normalfntRite"><?php echo number_format($fabricFinanceValue,4);?></td>
          <td class="normalfntRite"><?php echo number_format($totalFabricValue,4);?></td>
          <td class="normalfntRite"><?php echo number_format($acceValue,4);?></td>
          <td class="normalfntRite"><?php echo number_format($acceFinanceValue,4);?></td>
          <td class="normalfntRite"><?php echo number_format($totalAcceValue,4);?></td>
          <td class="normalfntRite"><?php echo number_format($packingValue,4);?></td>
          <td class="normalfntRite"><?php echo number_format($packingFinanceValue,4);?></td>
          <td class="normalfntRite"><?php echo number_format($packingHagingValue,4);?></td>
          <td class="normalfntRite"><?php echo number_format($totalPackingValue,4);?></td>
          <td class="normalfntRite"><?php echo number_format($embroideryValue,4);?></td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite"><?php echo number_format($printValue,4)?></td>
          <td class="normalfntRite"><?php echo round($otherValue,4);?></td>
          <td class="normalfntRite"><?php echo number_format($cmValue,2)?></td>
          <td class="normalfntRite"><?php echo round($row["TTL"]*$profit,2);?></td>
          <?php if($reportType!="E"){?>
          <td>12</td>
          <?php }
		  else {?>
          <td style="display:none">&nbsp;</td>
          <?php }?>
        </tr>
        <?php
		$s_totalValue = round($row["TTL"]*($totOrderFabCost+$orderAccCost+$orderPacCost+$embroideryCost+$printCost+$cm+$otherCost+$profit),2);
		InsertToSummaryReport($row["strBuyerCode"],$row["TTL"],$row["strCompanyCode"],$Comval,$s_totalValue,$wetValue,$dryValue,$outvertVal,$insuranceValue);
 
 		$totTTL 		+= $row["TTL"];
		$totEmbCost 	+= $embCost;
		$totMRCost 		+= $MRCost;
		$totNAUCost 	+= $NAUCost;
		$totSW3Cost 	+= $SW3Cost;
		$totComval 		+= $Comval;
		$totEMBvalue 	+= $EMBvalue;
		$totMRValue 	+= $MRValue;
		$totNAUvalue 	+= $NAUvalue;
		$totSW3Value 	+= $SW3Value;
		$totWetCost 	+= $wetValue;
		$totDryCost 	+= $dryValue;
		$totFreight 	+= $outvertVal;
		$totInsurance 	+= $insuranceValue;
}
?>
<tr bgcolor="#FFFFFF">
          <td colspan="9" class="normalfnt">&nbsp;&nbsp;&nbsp;&nbsp;<b>Grand Total</b></td>
          <td class="normalfntRite"><b><?php echo number_format($totTTL,2); ?></b></td>
          <td  class="normalfntRite"><b><?php echo number_format($totEmbCost,2); ?></b></td>
          <td class="normalfntRite"><b><?php echo number_format($totMRCost,2); ?></b></td>
          <td class="normalfntRite"><b><?php echo number_format($totNAUCost,2); ?></b></td>
          <td class="normalfntRite"><b><?php echo number_format($totSW3Cost,2); ?></b></td>
          <td>&nbsp;</td>
          <td class="normalfntRite"><b><?php echo number_format($totTTL,2); ?></b></td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td  class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td  class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td>&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite"><b><?php echo number_format($totComval,0); ?></b></td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite"><b><?php echo number_format($totEMBvalue,2); ?></b></td>
          <td class="normalfntRite"><b><?php echo number_format($totMRValue,2); ?></b></td>
          <td class="normalfntRite"><b><?php echo number_format($totNAUvalue,2); ?></b></td>
          <td class="normalfntRite"><b><?php echo number_format($totSW3Value,2); ?></b></td>
          <td>&nbsp;</td>
          <td class="normalfntRite"><b><?php echo number_format($totWetCost,2); ?></b></td>
          <td class="normalfntRite"><b><?php echo number_format($totDryCost,2); ?></b></td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite"><b><?php echo number_format($totFreight,2); ?></b></td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite"><b><?php echo number_format($totInsurance,2); ?></b></td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td class="normalfntRite">&nbsp;</td>
          <td>&nbsp;</td>
          <td style="display:none">&nbsp;</td>
        </tr>
 <?php if($reportType!="E"){?>
        <tr class="bcgcolor-tblrowWhite">
          <td colspan="72" class="normalfnt" nowrap="nowrap" >&nbsp;</td>
        </tr>
        <?php }?>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt" height="20">&nbsp;&nbsp;<b>Summary Details</b></td>
  </tr>
   <tr>
    <td><table width="1400" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="11%" height="22">Buyer</th>
        <th width="4%">TTL</th>
        <th width="4%">EMB</th>
        <th width="5%">MR</th>
        <th width="4%">LAG</th>
        <th width="4%">GC</th>
        <th width="4%">DUM</th>
        <th width="5%">WASH</th>
        <th width="6%">TTL VALUE</th>
        <th width="6%">EMB</th>
        <th width="6%">MR</th>
        <th width="6%">LAG</th>
        <th width="6%">GC </th>
        <th width="6%">DUM</th>
        <th width="6%">WASH WET</th>
        <th width="6%">WASH DRY</th>
        <th width="5%"> FRIEGHT</th>
        <th width="6%">INSURANCE</th>
        </tr>
<?php 
$sql_s="SELECT strBuyerCode,strCompanyCode,sum(dblTotalQty) as dblTotalQty,sum(dblTotalValue) as dblTotalValue,sum(dblFactoryValue) as dblFactoryValue,sum(dblWetCost) as dblWetCost,sum(dblDryCost) as dblDryCost, sum(dblFreight) as dblFreight,sum(dblInsurance) as dblInsurance
		FROM rpt_exportsalessummary
		group by strBuyerCode,strCompanyCode";
$result_s=$db->RunQuery($sql_s);
while($row_s=mysql_fetch_array($result_s))
{
	$s_buyerCode			= $row_s["strBuyerCode"];
	$s_compCode				= $row_s["strCompanyCode"];
	$s_totQty				= round($row_s["dblTotalQty"],2);
	$s_EMBTotCost 			= $row_s["strCompanyCode"]=='EMB' ? $s_totQty:'';
	$s_MARTotCost 			= $row_s["strCompanyCode"]=='MAR' ? $s_totQty:'';
	$s_NAUTotCost 			= $row_s["strCompanyCode"]=='NAU' ? $s_totQty:'';
	$s_SW3TotCost 			= $row_s["strCompanyCode"]=='SW3' ? $s_totQty:'';
	
	$s_totValue				= round($row_s["dblTotalValue"],0);
	
	$s_totFacValue			= round($row_s["dblFactoryValue"],2);
	
	$s_EMBTotCostValue 		= $row_s["strCompanyCode"]=='EMB' ? $s_totFacValue:'';
	$s_MARTotCostValue 		= $row_s["strCompanyCode"]=='MAR' ? $s_totFacValue:'';
	$s_NAUTotCostValue 		= $row_s["strCompanyCode"]=='NAU' ? $s_totFacValue:'';
	$s_SW3TotCostValue 		= $row_s["strCompanyCode"]=='SW3' ? $s_totFacValue:'';
	
	$s_WetCost				= round($row_s["dblWetCost"],2);
	$s_DryCost				= round($row_s["dblDryCost"],2);
	
	$s_Freight				= round($row_s["dblFreight"],4);
	$s_Insurance			= round($row_s["dblInsurance"],4);
	
?>     
<tr bgcolor="#FFFFFF">
    <td class="normalfnt" height="20" nowrap="nowrap"><?php echo $s_buyerCode; ?></td>
    <td class="normalfntRite"><?php  echo number_format($s_totQty,2); ?></td>
    <td class="normalfntRite"><?php echo ($s_EMBTotCost=='' ? '&nbsp;':number_format($s_EMBTotCost,2))?></td>
    <td class="normalfntRite"><?php echo ($s_MARTotCost=='' ? '&nbsp;':number_format($s_MARTotCost,2))?></td>
    <td class="normalfntRite"><?php echo ($s_NAUTotCost=='' ? '&nbsp;':number_format($s_NAUTotCost,2))?></td>
    <td class="normalfntRite"><?php echo ($s_SW3TotCost=='' ? '&nbsp;':number_format($s_SW3TotCost,2))?></td>
    <td>&nbsp;</td>
    <td class="normalfntRite"><?php  echo number_format($s_totQty,2); ?></td>
    <td class="normalfntRite"><?php  echo number_format($s_totValue,0); ?></td>
    <td class="normalfntRite"><?php  echo ($s_EMBTotCostValue == ''?'':number_format($s_EMBTotCostValue,2)); ?></td>
    <td class="normalfntRite"><?php  echo ($s_MARTotCostValue == ''?'':number_format($s_MARTotCostValue,2)); ?></td>
    <td class="normalfntRite"><?php  echo ($s_NAUTotCostValue == ''?'':number_format($s_NAUTotCostValue,2)); ?></td>
    <td class="normalfntRite"><?php  echo ($s_SW3TotCostValue == ''?'':number_format($s_SW3TotCostValue,2)); ?></td>
    <td>&nbsp;</td>
    <td class="normalfntRite"><?php echo number_format($s_WetCost,2); ?></td>
    <td class="normalfntRite"><?php echo number_format($s_DryCost,2); ?></td>
    <td class="normalfntRite"><?php  echo number_format($s_Freight,4); ?></td>
    <td class="normalfntRite"><?php  echo number_format($s_Insurance,4); ?></td>
</tr>
<?php
	$s_grandTotQty				+= $s_totQty;
	$s_grandEMBTotCost			+= $s_EMBTotCost;
	$s_grandMARTotCost			+= $s_MARTotCost;
	$s_grandNAUTotCost			+= $s_NAUTotCost;
	$s_grandSW3TotCost			+= $s_SW3TotCost;
	$s_grandTotValue			+= $s_totValue;
	$s_grandEMBTotCostValue		+= $s_EMBTotCostValue;
	$s_grandMARTotCostValue		+= $s_MARTotCostValue;
	$s_grandNAUTotCostValue		+= $s_NAUTotCostValue;
	$s_grandSW3TotCostValue		+= $s_SW3TotCostValue;
	$s_grandWetCost				+= $s_WetCost;
	$s_grandDryCost				+= $s_DryCost;
	$s_grandFreight				+= $s_Freight;
	$s_grandInsurance			+= $s_Insurance;
}
?>
<tr bgcolor="#FFFFFF">
    <td class="normalfnt" height="20">&nbsp;&nbsp;&nbsp;<b>Total</b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandTotQty,2); ?></b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandEMBTotCost,2); ?></b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandMARTotCost,2);?></b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandNAUTotCost,2); ?></b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandSW3TotCost,2); ?></b></td>
    <td>&nbsp;</td>
    <td class="normalfntRite"><b><b><?php  echo number_format($s_grandTotQty,2); ?></b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandTotValue,0); ?></b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandEMBTotCostValue,2); ?></b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandMARTotCostValue,2); ?></b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandNAUTotCostValue,2); ?></b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandSW3TotCostValue,2); ?></b></td>
    <td>&nbsp;</td>
    <td class="normalfntRite"><b><?php echo number_format($s_grandWetCost,2); ?></b></td>
    <td class="normalfntRite"><b><?php echo number_format($s_grandDryCost,2); ?></b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandFreight,2); ?></b></td>
    <td class="normalfntRite"><b><?php  echo number_format($s_grandInsurance,2); ?></b></td>
</tr>
    </table></td>
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
<?php
function InsertToSummaryReport($buyerCode,$totQty,$companyCode,$totValue,$s_totalValue,$wetValue,$dryValue,$outvertVal,$insuranceValue)
{
global $db;
$sql="INSERT INTO rpt_exportsalessummary
	(strBuyerCode,
	strCompanyCode,
	dblTotalQty,
	dblTotalValue,
	dblFactoryValue,
	dblWetCost,
	dblDryCost,
	dblFreight,
	dblInsurance
	)
	VALUES 
	('$buyerCode',
	'$companyCode',
	'$totQty',
	'$totValue',
	'$s_totalValue',
	'$wetValue',
	'$dryValue',
	'$outvertVal',
	'$insuranceValue');";
$result=$db->RunQuery($sql);
}
?>
</body>
</html>
