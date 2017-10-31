<?php 
session_start();
include "../../Connector.php";
include '../../eshipLoginDB.php';
$pub_styleId	= $_GET["StyleID"];
$buyer 			= $_GET["buyer"];
$styleName 		= $_GET["styleName"];
$checkDate		= $_GET["CheckDate"];
$dateFrom		= $_GET["DateFrom"];
$dateTo			= $_GET["DateTo"];
$orderStatus 	= $_GET["orderStatus"];
$orderType		= $_GET["OrderType"];
$deci2=2;
$deci4=4;
//header('Content-Type: application/vnd.ms-word');
//header('Content-Disposition: attachment;filename="report.doc"');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Post Order Costing Summary Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.vertical-text {
	color:#333;
	position:absolute
	border:0px solid black;
	writing-mode:tb-rl;
	-webkit-transform:rotate(90deg);
	-moz-transform:rotate(270deg);
	-o-transform: rotate(90deg);
	-ms-transform: rotate(90deg);
	display:inline;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:14px;
	font-weight:bold;
	min-width:150px;
	min-height:200px;
	line-height:normal;
	word-spacing:normal;
	white-space:nowrap;
}

.vertical-text1 {	
	color:#333;
	position:absolute
	border:0px solid black;
	writing-mode:tb-rl;
	-webkit-transform:rotate(90deg);
	-moz-transform:rotate(270deg);
	-o-transform: rotate(90deg);
	-ms-transform: rotate(90deg);
	display:inline;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:13px;
	font-weight:bold;
	min-width:150px;
	min-height:200px;
	line-height:normal;
	word-spacing:normal;
	white-space:nowrap;
}

.vertical-text2 {
	color:#333;
	position:absolute
	border:0px solid black;
	writing-mode:tb-rl;
	-webkit-transform:rotate(270deg);
	-moz-transform:rotate(270deg);
	-o-transform: rotate(90deg);
	-ms-transform: rotate(90deg);
	display:inline;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:13px;
	font-weight:bold;
	min-width:150px;
	min-height:200px;
	line-height:normal;
	word-spacing:normal;
	white-space:nowrap;
}
</style>
<style type="text/css">
    table.fixHeader {
        border: solid #FFFFFF;
        border-width: 2px 2px 2px 2px;
        width: 1050px;
    }
    tbody.ctbody {
        height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
    }

</style>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
</head>
<body>
<?php 
$status = '';
	switch($orderStatus)
	{
		case 'all':
		{
			$status = '';
			break;
		}
		case 'completed':
		{
			$status = '13';
			break;
		}
		case 'approved':
		{
			$status = '11';
			break;
		}
		case 'pending':
		{
			$status = '0,10';
			break;
		}
	}
?>
<table width="100%" border="0" align="center" cellpadding="0">
	<tr>
		<td height="53" colspan="6" class="head2">Post Order Costing Summary Report </td>
	</tr>
<?php if($styleName!="") {?>    
  	<tr>
		<td width="137" class="normalfnt">&nbsp;<b>Order No</b>&nbsp;</td>
		<td width="6" class="normalfnt"><b>:</b></td>
		<td colspan="4" class="normalfnt">&nbsp;<?php echo $styleName;?>&nbsp;</td>
	</tr>
<?php } ?>
<?php if($buyer!="") {?>   
  	<tr>
		<td width="137" class="normalfnt">&nbsp;<b>Buyer Name</b>&nbsp;</td>
	  <td width="6" class="normalfnt"><b>:</b></td>
		<td colspan="4" class="normalfnt">&nbsp;<?php echo GetBuyerName($buyer)?>&nbsp;</td>
	</tr>
<?php } ?>
<?php if($checkDate=='1') {?> 
  <tr>
	  <td width="137" class="normalfnt">&nbsp;<b>Order Date From</b>&nbsp;</td>
	<td width="6" class="normalfnt"><b>:</b></td>
	<td width="125" class="normalfnt">&nbsp;<?php echo $dateFrom?>&nbsp;</td>
	<td width="29" class="normalfnt">&nbsp;<b>To</b>&nbsp;</td>
	<td width="7" class="normalfnt"><b>:</b></td>
	<td width="2168" class="normalfnt">&nbsp;<?php echo $dateTo?>&nbsp;</td>
  </tr>
<?php } ?>
  <tr>
    <td height="53" colspan="6">
	<table width="100%" border="0" class="fixHeader" cellspacing="0" cellpadding="2" id="tblMain">
	<thead >
    <tr>
    <th colspan="10" rowspan="2" class="bcgl1txt1B">&nbsp;</th>
    <th height="29" colspan="15" class="bcgl1txt1B">Pre Order</th>
     <th colspan="14" class="bcgl1txt1B">Post Order</th>
     <th colspan="15" class="bcgl1txt1B">Pre Order Vs Post Order Variance</th>
      <th colspan="15" class="bcgl1txt1B">Buyer Pricing</th>
      <th colspan="15" class="bcgl1txt1B">Pre Order Vs Buyer Pricing Variance</th> 
      <th colspan="4" rowspan="2" class="bcgl1txt1B">Actual </th>
      <th class="bcgl1txt1B">&nbsp;</th>
    </tr>
    <tr>
     <th colspan="3" class="bcgl1txt1B">Consumption Per Piece (YDS)</th>
    <th colspan="12" class="bcgl1txt1B">Value Per Piece in US$</th>
    
    <th colspan="3" class="bcgl1txt1B">Consumption Per Piece (YDS)</th>
    <th colspan="11" class="bcgl1txt1B">Value Per Piece in US$</th>
    <th colspan="3" class="bcgl1txt1B">Consumption Per Piece (YDS)</th>
     <th colspan="12" class="bcgl1txt1B">Value Per Piece in US$</th>
     <th class="bcgl1txt1B">Consumption Per Piece (YDS)</th>
     <th class="bcgl1txt1B">&nbsp;</th>
     <th class="bcgl1txt1B">&nbsp;</th> 
        <th colspan="12" class="bcgl1txt1B">Value Per Piece in US$</th>
        <th colspan="3" class="bcgl1txt1B">Consumption Per Piece (YDS)</th>
        <th colspan="12" class="bcgl1txt1B">Value Per Piece in US$</th>
        <th class="bcgl1txt1B">&nbsp;</th>
    </tr>
    <tr>
    <th class="bcgl1txt1" height="168"><span class="vertical-text1" style="vertical-align:-45px;">Orit Order No </span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-70px;">Buyer </span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-60px;">Order No </span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-62px;">Style No </span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-32px;">Style Description </span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-65px; margin:0 0 0 -15px;">Division</span></th>
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/orderQty.png" /></th>  
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/excess_percent.png" /></th>
    <th class="bcgl1txt1" valign="bottom"><img src="../../images/excess_qty.png" /></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-62px;">Cut Qty</span></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Main Fabric</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Other Fabric</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-50px;">Pocketing</div></th>
     <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-65px;">Fabric</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-60px;">Pocketing</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-50px;">Accessories</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-30px;">Packing Materials</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-62px;">Services</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-65px;">Others</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-48px;">Washing Wet</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-48px;">Washing Dry</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-35px;">Finance Charges</span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-80px; margin:0 0 0 5px;">CM</span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-75px; margin:0 0 0 5px;">Profit</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-80px;">FOB</span></th>
       
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Main Fabric</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Other Fabric</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-50px;">Pocketing</div></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-65px;">Fabric</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-60px;">Pocketing</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-50px;">Accessories</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-30px;">Packing Materials</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-62px;">Services</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-65px;">Others</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-48px;">Washing Wet</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-48px;">Washing Dry</span></th>
  
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-80px; margin:0 0 0 5px;">CM</span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-75px; margin:0 0 0 5px;">Profit</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-80px;">FOB</span></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Main Fabric</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Other Fabric</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Pocketing</div></th>
     <th class="bcgl1txt1"><div class="vertical-text1" style="vertical-align:-35px;">Fabric</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Pocketing</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Accessories</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Packing Materials</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Services</div></th>
     <th class="bcgl1txt1"><div class="vertical-text1" style="vertical-align:-35px;">Others</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Washing Wet</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Washing Dry</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Finance Charges</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">CM</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Profit</div></th>
     <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">FOB</div></th>
       <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Main Fabric</div></th>
       <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Other Fabric</div></th>
       <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Pocketing</div></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-65px;">Fabric</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-60px;">Pocketing</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-50px;">Accessories</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-30px;">Packing Materials</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-62px;">Services</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-65px;">Others</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-48px;">Washing Wet</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-48px;">Washing Dry</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-35px;">Finance Charges</span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-80px; margin:0 0 0 5px;">CM</span></th>
    <th class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-75px; margin:0 0 0 5px;">Profit</span></th>
    <th class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-80px;">FOB</span></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Main Fabric</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Other Fabric</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Pocketing</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Fabric</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Pocketing</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Accessories</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Packing Materials</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Services</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Others</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Washing Wet</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Washing Dry</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Finance Charges</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">C&M </div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Profit</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">FOB</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1">11</div>
      <div class="vertical-text1">10</div><div class="vertical-text1">9</div><div>8</div><div>7</div><div>6</div><div>5</div><div>4</div><div>3</div><div>2</div><div>1</div><div>0</div></div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Actual Shipped Qty</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Order ship (%)</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-35px;">Cut_Shipped (%)</div></th>
    <th class="bcgl1txt1" ><div class="vertical-text1" style="vertical-align:-25px;">Total Fabric Savings</div></th>
    </tr>
	</thead>
	<tbody class="ctbody">
      <!--<tr>
        <td width="3%" rowspan="2" class="bcgl1txt1" height="168"><span class="vertical-text1" style="vertical-align:-114px;">Orit Order No </span></td>
        <td width="4%" rowspan="2" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-129px;">Order No </span></td>
        <td width="5%" rowspan="2" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-129px;">Style No </span></td>
        <td width="5%" rowspan="2"  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-99px;">Style Description </span></td>
        <td width="2%" rowspan="2" class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-130px; margin:0 0 0 -15px;">Division</span></td>
        <td width="5%" rowspan="2"  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-125px; margin:0 0 0 -20px;">Order Qty</span></td>
        <td width="5%" rowspan="2"  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-120px;  margin:0 0 0 -15px;">Excess[%]</span></td>
        <td width="5%" rowspan="2" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-95px; margin:0 0 0 -25px;" >Excess Qty [Pc's]</span></td>
        <td height="168" colspan="4" class="bcgl1txt1B">PRE ORDER (PC's)</td>
        <td colspan="5" class="bcgl1txt1B">POST ORDER</td>
        <td colspan="6" class="bcgl1txt1B">INVOICE</td>
      </tr>
      <tr>
        <td width="5%" height="279"  class="bcgl1txt1" valign="bottom"><img src="../../images/tot_Material_cost.png" /></td>
        <td width="2%"  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-135px; margin:0 0 0 5px;">CM</span></td>
        <td width="5%"  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-125px; margin:0 0 0 5px;">Profit</span></td>
        <td width="5%"  class="bcgl1txt1" ><span class="vertical-text1" style="vertical-align:-130px;">FOB</span></td>
        <td  class="bcgl1txt1" valign="bottom"><img src="../../images/tot_Material_cost.png" /></td>
        <td  class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-135px;">CM</span></td>
        <td  width="5%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-125px; margin:0 0 0 -5px;">Profit</span></td>
        <td width="4%" class="bcgl1txt1"><img src="../../images/varience_pre_post.png" /></td>
        <td width="4%" class="bcgl1txt1" valign="bottom"><img src="../../images/pre_post_profit.png" /></td>
        <td width="4%" class="bcgl1txt1" valign="bottom"><img src="../../images/tot_Material_cost.png" /></td>
        <td width="4%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-137px;">CM</span></td>
        <td width="4%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-130px;">Profit</span></td>
        <td width="4%" class="bcgl1txt1"><span class="vertical-text1" style="vertical-align:-133px;">FOB</span></td>
         <td width="4%" class="bcgl1txt1" valign="bottom"><img src="../../images/pre_Inv_fob.png" /></td>
          <td width="4%" class="bcgl1txt1" valign="bottom"><img src="../../images/inv_post_material.png" /></td>
      </tr>-->
<!--      <tr>
        <td colspan="21" class="bcgl1txt1">&nbsp;</td>
      </tr>-->
      
     <?php 
	 $sql = "select o.intStyleId,concat(date_format(o.dtmOrderDate,'%Y%m'),'',o.intCompanyOrderNo)as oritOrderNo,o.strOrderNo,b.strName as buyerName,
o.strStyle,o.strDescription,dv.strDivision,o.intQty as orderQty,o.reaExPercentage ,round(o.intQty*o.reaExPercentage/100) as exQty,
(select sum(ph.dblTotalQty) as qty from productionbundleheader ph where ph.intStyleId=o.intStyleId and cut_type=1) as cutQty,
(select sum(ph.dblTotalQty) as qty from productionbundleheader ph where ph.intStyleId=o.intStyleId and cut_type=2) as PocCutQty,
(select round(sum(od.reaConPc),2) from orderdetails od where od.intStyleId=o.intStyleId and od.intMainFabricStatus=1) as mainFabricConpc,
(select round(sum(od.reaConPc),2) from orderdetails od inner join invoicecostingdetails id on id.strItemCode=od.intMatDetailID and od.intStyleId= id.intStyleId
 where od.intStyleId=o.intStyleId and id.strType=1) as preorderFabricConpc,
(select round(sum(od.reaConPc),2) from orderdetails od inner join invoicecostingdetails id on id.strItemCode=od.intMatDetailID and od.intStyleId= id.intStyleId
 where od.intStyleId=o.intStyleId and id.strType=2) as pocConpc,
(select round(sum(od.dbltotalcostpc),2) from orderdetails od inner join invoicecostingdetails id on id.strItemCode=od.intMatDetailID and od.intStyleId= id.intStyleId
 where od.intStyleId=o.intStyleId and id.strType=1) as preorderFabricCost,
(select round(sum(od.dbltotalcostpc),2) from orderdetails od inner join invoicecostingdetails id on id.strItemCode=od.intMatDetailID and od.intStyleId= id.intStyleId
 where od.intStyleId=o.intStyleId and id.strType=2) as preorderPocketCost,
(select round(sum(od.dbltotalcostpc),2) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial=od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=2) as preorderAccessoriesCost,
(select round(sum(od.dbltotalcostpc),2) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial=od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=3) as preorderPackingCost,
(select round(sum(od.dbltotalcostpc),2) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial=od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=4) as preorderServiceCost,
(select round(sum(od.dbltotalcostpc),2) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial=od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=5) as preorderOtherCost,
(select round(sum(od.dbltotalcostpc),2) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial=od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=6 and mil.strItemDescription like '%WET%') as preorderWetCost,
(select round(sum(od.dbltotalcostpc),2) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial=od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=6 and mil.strItemDescription like '%DRY%') as preorderDryCost,
o.reaFinance as preFinance,round(o.reaSMV*o.reaSMVRate,4) as preCMvalue,o.dblFacProfit as preProfit,o.reaFOB as preFob,
(select round(sum(id.reaConPc/12),2) from invoicecostingdetails id inner join orderdetails od on od.intMatDetailID=id.strItemCode 
and od.intStyleId=id.intStyleId where id.intStyleId = o.intStyleId and od.intMainFabricStatus=1) as invMainFabricConpc,
(select round(sum(id.reaConPc/12),2) from invoicecostingdetails id  where id.intStyleId = o.intStyleId and id.strType=1) as invFabricConpc,
(select round(sum(id.reaConPc/12),2) from invoicecostingdetails id  where id.intStyleId = o.intStyleId and id.strType=2) as invPocConpc,
(select round(sum(id.dblValue+id.dblValue*reaWastage/100)/12,2) from invoicecostingdetails id  where id.intStyleId = o.intStyleId and 
id.strType=1) as invFabricCost,
(select round(sum(id.dblValue+id.dblValue*reaWastage/100)/12,2) from invoicecostingdetails id  where id.intStyleId = o.intStyleId and 
id.strType=2) as invPocCost,
(select round(sum(id.dblValue+id.dblValue*reaWastage/100)/12,2) from invoicecostingdetails id inner join matitemlist mil on
mil.intItemSerial = id.strItemCode  where id.intStyleId = o.intStyleId and mil.intMainCatID=2) as invAccCost,
(select round(sum(id.dblValue+id.dblValue*reaWastage/100)/12,2) from invoicecostingdetails id inner join matitemlist mil on
mil.intItemSerial = id.strItemCode  where id.intStyleId = o.intStyleId and mil.intMainCatID=3) as invPackingCost,
(select round(sum(id.dblValue+id.dblValue*reaWastage/100)/12,2) from invoicecostingdetails id inner join matitemlist mil on
mil.intItemSerial = id.strItemCode  where id.intStyleId = o.intStyleId and mil.intMainCatID=4) as invServiceCost,
(select round(sum(id.dblValue+id.dblValue*reaWastage/100)/12,2) from invoicecostingdetails id inner join matitemlist mil on
mil.intItemSerial = id.strItemCode  where id.intStyleId = o.intStyleId and mil.intMainCatID=5) as invOtherCost,
(select round(sum(id.dblValue+id.dblValue*reaWastage/100)/12,2) from invoicecostingdetails id inner join matitemlist mil on
mil.intItemSerial = id.strItemCode  where id.intStyleId = o.intStyleId and mil.intMainCatID=6 and mil.strItemDescription like '%WET%') as invWashWetCost,
(select round(COALESCE(sum(id.dblValue+id.dblValue*reaWastage/100)/12,0),2) from invoicecostingdetails id inner join matitemlist mil on
mil.intItemSerial = id.strItemCode  where id.intStyleId = o.intStyleId and mil.intMainCatID=6 and mil.strItemDescription like '%DRY%') +
(select round(COALESCE(sum(ip.dblUnitPrice)/12,0),2) from invoicecostingproceses ip inner join was_dryprocess wp on
wp.intSerialNo = ip.intProcessId where ip.intStyleId = o.intStyleId and wp.strCategory='DP') as invWashDryCost,
(select round(sum(id.dblValue*dblFinance/100),2) from invoicecostingdetails id where id.intStyleId = o.intStyleId) as invFinance,
round(ih.dblTotalCostValue,2) as invMatcost,ih.dblTotalCostValue as invFob,o.dblActualEfficencyLevel,ih.dblNewCM, o.dblFacProfit as preorderProfit,o.reaSMVRate as smvRate, o.reaECSCharge as preESC, o.reaUPCharges as preUpcharge,(select round(sum(od.dbltotalcostpc),4) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial= od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=4) as preServiceCost,
(select round(sum(od.dbltotalcostpc),4) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial= od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=5) as preOtherCost,
(select round(sum(od.dbltotalcostpc),4) from orderdetails od inner join matitemlist mil on 
mil.intItemSerial= od.intMatDetailID  where od.intStyleId=o.intStyleId and mil.intMainCatID=6) as preWashCost, o.strBuyerOrderNo,b.intinvFOB as buyerInvFOB,
(select dblSMV from  firstsale_actualdata fa where fa.intStyleId=o.intStyleId) as actSMV,
(select distinct cid.dblUnitPrice from eshipping.commercial_invoice_detail cid inner join eshipping.commercial_invoice_header cih on cih.strInvoiceNo= cid.strInvoiceNo 
inner join eshipping.shipmentplheader plh on plh.strPLNo = cid.strPLNo where plh.intStyleId=o.intStyleId and strInvoiceType='F') as ActaulFob 
from orders o inner join buyerdivisions dv on 
dv.intDivisionId = o.intDivisionId and dv.intBuyerID = o.intBuyerID
left join invoicecostingheader ih on ih.intStyleId= o.intStyleId
inner join buyers b on b.intBuyerID = o.intBuyerID
 where o.intStyleId >0 ";
 	
	if($pub_styleId !='')
		$sql .= " and o.intStyleId='$pub_styleId' ";
	if($status !='')
		$sql .= " and o.intStatus in ($status) ";
	if($buyer != '')
		$sql .= "and o.intBuyerID = '$buyer' ";
	if($styleName != '')
		$sql .= "and o.strStyle = '$styleName' ";
	if($checkDate=='1')
		$sql .= "and o.dtmOrderDate >='$dateFrom' and o.dtmOrderDate <='$dateTo' ";
	if($orderType!="")
		$sql .= "and o.intOrderType='$orderType' ";
	$sql .= "order by o.strOrderNo ";
	$result = $db->RunQuery($sql);
	//echo $sql;
	while($row=mysql_fetch_array($result))
	{
		$pub_styleId = $row["intStyleId"];
		$url = "rptPostOrderCosting.php?&StyleID=".$row["intStyleId"];
		//$shipQty = getShipQty($row["buyerInvFOB"]);
		
		$orderQty = $row["orderQty"];
		
		//preorder costing details ------------------------------------------------
		$preMainFabConpc = round($row["mainFabricConpc"],$deci2);
		$preorderFabricConpc = round($row["preorderFabricConpc"],$deci2)-$preMainFabConpc;
		if($preorderFabricConpc<0)
			$preorderFabricConpc=0;
		$prePocConpc	 = round($row["pocConpc"],$deci2);
		$preFabCost 	 = round($row["preorderFabricCost"],$deci2);
		$prePocCost 	 = round($row["preorderPocketCost"],$deci2);
		$preAccCost 	 =  round($row["preorderAccessoriesCost"],$deci2);
		$prePacCost		 = round($row["preorderPackingCost"],$deci2);
		$preServiceCost	 = round($row["preorderServiceCost"],$deci2);
		$preOtherCost	 = round($row["preorderOtherCost"],$deci2);
		$preWetCost	 = round($row["preorderWetCost"],$deci2);
		$preDryCost	 = round($row["preorderDryCost"],$deci2);
		$preFinance  = round($row["preFinance"],$deci2);
		$preCM		 = round($row["preCMvalue"],$deci2);	
		$preProfit	 = round($row["preProfit"],$deci4);	
		$preFob 	 = round($row["preFob"],$deci4);	
		
		//preorder costing details ------------------------------------------------
		
		//invoice costing details ------------------------------------------------
		$invMainFabricConpc = round($row["invMainFabricConpc"],$deci2);
		$invFabricConpc = round($row["invFabricConpc"],$deci2)-$invMainFabricConpc;
		$invPocConpc = round($row["invPocConpc"],$deci2);
		
		//$invPocConpc	 = round($row["pocConpc"],$deci2);
		$invFabCost 	 = round($row["invFabricCost"],$deci2);
		$invPocCost 	 = round($row["invPocCost"],$deci2);
		$invAccCost 	 =  round($row["invAccCost"],$deci2);
		$invPacCost		 = round($row["invPackingCost"],$deci2);
		$invServiceCost	 = round($row["invServiceCost"],$deci2);
		$invOtherCost	 = round($row["invOtherCost"],$deci2);
		$invWetCost	 = round($row["invWashWetCost"],$deci2);
		$invDryCost	 = round($row["invWashDryCost"],$deci2);
		$invFinance  = round($row["invFinance"],$deci2);
		$invCM		 = round($row["dblNewCM"],$deci2);	
		$invFob = ($row["buyerInvFOB"]==1?$row["invFob"]:$row["preFob"]);
		$invProfit	 = round(($preFob - $invFob),$deci4);	
		//invoice costing details ------------------------------------------------
		
		//preorder vs invoice costing details ----------------------------------
		$preInvMainFabConpc = $preMainFabConpc - $invMainFabricConpc;
		$preInvFabricConpc = $preorderFabricConpc - $invFabricConpc;
		$preInvPocConpc = $prePocConpc - $invPocConpc;
		//$preInvPocConpc 	= 
		$preInvFabCost = $preFabCost - $invFabCost;
		$preInvPocCost = $prePocCost - $invPocCost;
		$preInvAccCost = $preAccCost - $invAccCost;
		$preInvPacCost = $prePacCost - $invPacCost;
		$preInvServiceCost = $preServiceCost - $invServiceCost;
		$preInvOtherCost = $preOtherCost - $invOtherCost;
		$preInvWetCost = $preWetCost - $invWetCost;
		$preInvDryCost = $preDryCost - $invDryCost;
		$preInvFinance = $preFinance - $invFinance;
		$preInvCM	   = $preCM - $invCM;
		$preInvProfit	= $preProfit - $invProfit;
		$preInvFob	   = $preFob - $invFob;	
		//preorder vs invoice costing details ----------------------------------
		
		//Actual -----------------------------------------
		$shipQty = round(getShipQty($pub_styleId),0);
		$cutQty = $row["cutQty"];
		$orderShipRatio = round(($shipQty/$orderQty)*100,0);
		$cutShipRatio 	= round(($shipQty/$cutQty)*100,0);
	
		//Actual  -----------------------------------------
		
		//postorder costing details -------------------------------------------------
		$postFabConpc = round(($preMainFabConpc*$orderQty)/$cutQty,$deci2);
		$postOtherFabConpc = round(($preorderFabricConpc*$orderQty)/$cutQty,$deci2);
		$PocCutQty = $row["PocCutQty"];
		$postPocConpc = round(($prePocConpc*$orderQty)/$PocCutQty,$deci2);
		$postFabPrice = round(getItemCost($pub_styleId,1,1,$cutQty),$deci2);
		$postPocPrice = round(getItemCost($pub_styleId,1,2,$cutQty),$deci2);
		$postAccPrice = round(getItemCost($pub_styleId,2,'',$cutQty),$deci2);
		$postPacPrice = round(getItemCost($pub_styleId,3,'',$cutQty),$deci2);
		$postServicePrice = round(getItemCost($pub_styleId,4,'',$cutQty),$deci2);
		$postOtherPrice = round(getItemCost($pub_styleId,5,'',$cutQty),$deci2);
		$postFob = round($row["ActaulFob"],$deci2);
		$postProfit = $postFob-($postFabPrice+$postPocPrice+$postAccPrice+$postPacPrice+$postServicePrice+$postOtherPrice);
		//postorder costing details -------------------------------------------------
		
		//preorder vs postorder details --------------------------------------------------------------
		$prePostMainFabConpc = $preMainFabConpc-$postFabConpc;
		$prePostFabricConpc = $preorderFabricConpc-$postOtherFabConpc;
		$prePostPocConpc = $prePocConpc-$postPocConpc;
		$prePostFabricCost = $preFabCost-$postFabPrice;
		$prePostPocCost = $prePocCost - $postPocPrice;
		$prePostAccCost = $preAccCost - $postAccPrice;
		$prePostPacCost = $prePacCost - $postPacPrice;
		$prePostServiceCost = $preServiceCost - $postServicePrice;
		$prePostOtherPrice = $preOtherCost - $postOtherPrice;
		
		$prePostFob = $preFob-$postFob;
		//--------------------------------------------------------------------------------------------
	 ?>
       <tr height="20" onmouseover="this.style.background ='#E8E8FF';" onmouseout="this.style.background='';">
        <td class="normalfntTAB" nowrap="nowrap" height="20">&nbsp;<?php echo $row["oritOrderNo"]; ?>&nbsp;</td>
        <td class="normalfntTAB" nowrap="nowrap"><?php echo $row["buyerName"]; ?></td>
        <td class="normalfntTAB" nowrap="nowrap">&nbsp;<a href="<?php echo $url; ?>" target="postordercostingRpt.php" style="text-decoration:underline" title="Click here to view Post Order Costing Report"><?php echo $row["strOrderNo"]; ?></a>&nbsp;</td>
        <td class="normalfntTAB" nowrap="nowrap">&nbsp;<?php echo $row["strStyle"]; ?>&nbsp;</td>
        <td class="normalfntTAB" nowrap="nowrap">&nbsp;<?php echo $row["strDescription"]; ?>&nbsp;</td>
        <td class="normalfntTAB" nowrap="nowrap">&nbsp;<?php echo $row["strDivision"]; ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($row["orderQty"],0); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo $row["reaExPercentage"]; ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($row["exQty"],0); ?>&nbsp;</td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($cutQty,0); ?>&nbsp;</td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preMainFabConpc,$deci2); ?></td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preorderFabricConpc,$deci2); ?></td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePocConpc,$deci2); ?></td>
           <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preFabCost,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePocCost,2); ?></td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preAccCost,2); ?></td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePacCost,2); ?></td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preServiceCost,2); ?></td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preOtherCost,2); ?></td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preWetCost,2); ?></td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preDryCost,2); ?></td>
          <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 
			echo number_format($preFinance,2); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preCM,4); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 	echo number_format($preProfit,4); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preFob,2); ?>&nbsp;</td>
       
        <td  class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($postFabConpc,$deci2); ?></td>
        <td  class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($postOtherFabConpc,$deci2); ?></td>
        <td  class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($postPocConpc,$deci2); ?>
       &nbsp;</td>
        <td  class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($postFabPrice,$deci2);?></td>
        <td  class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 	echo number_format($postPocPrice,$deci2);
		?>&nbsp;</td>
      <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($postAccPrice,$deci2); ?>&nbsp;</td>
       <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 	  echo number_format($postPacPrice,$deci2);
	   ?>&nbsp;</td>
       <td class="normalfntRiteTAB"  nowrap="nowrap"><?php 	echo number_format($postServicePrice,$deci2);
		?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo  number_format($postOtherPrice,2); ?>&nbsp;</td>
         <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($postProfit,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php  echo number_format($postFob,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePostMainFabConpc,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePostFabricConpc,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePostPocConpc,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePostFabricCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePostPocCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePostAccCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePostPacCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePostServiceCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePostOtherPrice,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($prePostFob,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invMainFabricConpc,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invFabricConpc,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invPocConpc,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invFabCost,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invPocCost,2); ?></td>
         <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invAccCost,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invPacCost,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invServiceCost,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invOtherCost,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invWetCost,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invDryCost,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invFinance,2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invCM,4) ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php 	echo number_format($invProfit,4);?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($invFob,2); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvMainFabConpc,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvFabricConpc,$deci2) ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvPocConpc,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvFabCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvPocCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvAccCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvPacCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvServiceCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvOtherCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvWetCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvDryCost,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvFinance,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvCM,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvProfit,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($preInvFob,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($cutQty,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($shipQty,$deci2); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($orderShipRatio,0); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;<?php echo number_format($cutShipRatio,0); ?></td>
        <td class="normalfntRiteTAB"  nowrap="nowrap">&nbsp;</td>
       </tr>
      
     <?php
	 $totOrderQty += $row["orderQty"];
	 $totExQty += $row["exQty"]; 
	 $totPreMatCost += $row["preMaterialCost"]; 
	 $totPreCM += $row["preCMvalue"]; 
	 $totPreProfit += $row["preProfit"];
	 $totPreFOB += $row["preFob"]; 
	 $totPostMatCost += $totValue;
	 $totPostCM += $actCM;
	 $totPastProfit += $postProfit;
	 $totmatVariPostorder += $matVariPostorder;
	 $totprofitVariPost += $profitVariPost;
	 $totInvMatcost += $row["invMatcost"];
	 $totInvCM += $row["dblNewCM"];
	 $totInvFob += $row["invFob"];
	 $totinvProfit += $invProfit;
	 $totinvFobVari += $invFobVari;
	 $totinvPreMatVari += $invPreMatVari;
	 }
	 ?> 
      <tr >
         <td colspan="89" nowrap="nowrap" class="normalfntTAB">&nbsp;</td>
         </tr>
     <!-- <tr>
        <td colspan="21" height="7">&nbsp;</td>
      </tr>-->
      <tr style="display:none">
        <td height="20" colspan="6" class="normalfntBtab">TOTAL</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totOrderQty,0); ?>&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totExQty,0); ?>&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totPreMatCost,4); ?>&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totPreCM,4); ?>&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totPreProfit,4); ?>&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totPreFOB,2); ?>&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totPostMatCost,4); ?>&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totmatVariPostorder,4); ?>&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totInvMatcost,4); ?>&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totInvCM,4); ?>&nbsp;</td>  
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totinvProfit,4); ?>&nbsp;</td>
         <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totInvFob,2); ?>&nbsp;</td>
        <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totinvFobVari,4); ?>&nbsp;</td>
         <td class="normalfntBtab" style="text-align:right">&nbsp;<?php echo number_format($totinvPreMatVari,4); ?>&nbsp;</td>
      </tr>
      <tr style="display:none" height="20">
        <td colspan="6" class="normalfntBtab">GRAND TOTAL</td>
        <td class="normalfntRiteTAB">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
        <td class="normalfntBtab">&nbsp;</td>
         <td class="normalfntBtab">&nbsp;</td>
          <td class="normalfntBtab">&nbsp;</td>
      </tr>
	  </tbody>
    </table>  
  </table>
</td>
  </tr>
</table>
<?php 

function GetBuyerName($buyerId)
{
global $db;
	$sql = "select strName from buyers where intBuyerID='$buyerId'";
 	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strName"];
}
function getShipQty($pub_styleId)
{
	$eshipDB = new eshipLoginDB();
	$sql = " select sum(cid.dblQuantity) as shipQty from commercial_invoice_detail cid inner join
	 commercial_invoice_header cih on cih.strInvoiceNo = cid.strInvoiceNo
inner join shipmentplheader plh on plh.strPLNo = cid.strPLNo
where plh.intStyleId='$pub_styleId' and cih.strInvoiceType='F' ";
	
	$result = $eshipDB->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["shipQty"];
}
function getItemCost($pub_styleId,$category,$type,$cutQty)
{
	global $db;
	if($category==1)
		$result = getFabricItemDetails($pub_styleId,$type);
	else
		$result = getItemDetails($pub_styleId,$category);
	
	$itemPcsCost =0;
	$value=0;		
	while($row = mysql_fetch_array($result))
	{
		
		//style GRN details-----------------------------------------
		$grnValue = getGRNData($pub_styleId,$row["intMatDetailID"]);
		$qty += $grnValue[1];
		$value += $grnValue[0];
		//style GRN details-----------------------------------------
		
		//Bulk Allocation Details------------------------------------------------
		$bulkAlloValue = getBulkAlloData($pub_styleId,$row["intMatDetailID"]);
		$qty += $bulkAlloValue[0];
		$value += $bulkAlloValue[1];
		//Bulk Allocation Details------------------------------------------------
		
		//Leftover Details -------------------------------------------------------
		$leftAlloValue = getLeftAlloQtyandPrice($pub_styleId,$row["intMatDetailID"]);
		$qty += $leftAlloValue[0];
		$value += $leftAlloValue[1];
		//Leftover Details -------------------------------------------------------
		
		//interjob details--------------------------------------------------
		$interjobVal = getInterJobWAprice($pub_styleId,$row["intMatDetailID"]);
		$qty += $interjobVal[0];
		$value += $interjobVal[1];
		//interjob details--------------------------------------------------
		
		//$itemPcsCost += $value/$cutQty; 
	}
	
	//return $value/$qty;
	return $value/$cutQty;
}
function getFabricItemDetails($pub_styleId,$type)
{
	global $db;
	$sql = " select od.intMatDetailID from orderdetails od inner join invoicecostingdetails id on id.strItemCode=od.intMatDetailID and od.intStyleId= id.intStyleId
 where od.intStyleId=$pub_styleId and id.strType='$type' ";
   	
	return $db->RunQuery($sql);
}
function getItemDetails($pub_styleId,$category)
{
	global $db;
	$sql = "select od.intMatDetailID from orderdetails od inner join matitemlist mil on mil.intItemSerial = od.intMatDetailID
where od.intStyleId='$pub_styleId' and mil.intMainCatID='$category' ";

	return $db->RunQuery($sql);
}
function getGRNData($pub_styleId,$matDetailId)
{
	global $db;
	$totPrice =0;
	$totQty =0;
	$arrPO =  array();

	$sql = "select gd.dblQty, gd.dblInvoicePrice/gh.dblExRate as unitPrice
				from grndetails gd inner join grnheader gh on
				gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
				where gh.intStatus =1 and gd.intStyleId='$pub_styleId' and gd.intMatDetailID='$matDetailId' ";
		
		
		$result = $db->RunQuery($sql);
		
		while($row = mysql_fetch_array($result))
		{
			$totPrice += round($row["unitPrice"],4)*$row["dblQty"];
			$totQty   +=  $row["dblQty"];
		}
	
	$arrPO[0] = $totPrice;
	$arrPO[1] = $totQty;
	
	return $arrPO;

}

function getBulkAlloData($pub_styleId,$matDetailId)
{
	global $db;
	$arrBulk =  array();
	$sql = "select cbd.dblQty,round(bgd.dblRate/bgh.dblRate,4) as UnitPrice
from commonstock_bulkdetails cbd inner join commonstock_bulkheader cbh on
cbd.intTransferNo = cbh.intTransferNo and cbd.intTransferYear = cbh.intTransferYear
inner join bulkgrnheader bgh on bgh.intBulkGrnNo = cbd.intBulkGrnNo  and bgh.intYear = cbd.intBulkGRNYear
inner join bulkgrndetails bgd on bgd.intBulkGrnNo = bgh.intBulkGrnNo and bgd.intYear = bgh.intYear
and bgd.intMatDetailID=cbd.intMatDetailId
where cbh.intStatus=1 and cbh.intToStyleId='$pub_styleId' and cbd.intMatDetailId='$matDetailId' ";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$Qty += $row["dblQty"];
		$Value += $row["dblQty"]*$row["UnitPrice"];
	}
	
	$arrBulk[0] = $Qty;
	$arrBulk[1] = $Value;
	return $arrBulk;
}


function getLeftAlloQtyandPrice($pub_styleId,$matDetailId)
{
	global $db;
	$sql = "SELECT COALESCE(sum(LCD.dblQty)) as LeftAlloqty, LCD.intGrnNo,LCD.intGrnYear, LCD.strGRNType,LCD.strColor,LCD.strSize,LCD.intFromStyleId,LCD.intMatDetailId
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$pub_styleId'  and  LCH.intStatus=1 and LCD.intMatDetailId='$matDetailId'
group by LCD.intGrnNo,LCD.intGrnYear,LCD.strGRNType,LCD.strColor,LCD.strSize,LCD.intMatDetailId ";
			
	$result = $db->RunQuery($sql);
	$price =0;
	$leftOverQty =0;
	$arrleft = array();
	while($row = mysql_fetch_array($result))
	{
		$lQty = $row["LeftAlloqty"];
		$matDetailId = $row["intMatDetailId"];
		
		$totQty += $lQty;
		$intGrnNo = $row["intGrnNo"];
		if($intGrnNo>30)
		{
			$strGRNType = $row["strGRNType"];
			switch($strGRNType)
			{
				case 'S':
				{
					
					$LOprice = getGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$row["intFromStyleId"],$matDetailId);
					$price += $LOprice*$lQty;
					break;
				}
				case 'B':
				{
					$BAprice = getBulkGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$matDetailId);
					$price += $BAprice*$lQty;
					break;
				}
			}
		}
		else
		{
			$LAprice = getLeftoverPrice($matDetailId,$intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$row["strGRNType"]);
			$price += $LAprice*$lQty;
		}
	}
	$arrleft[0] = $Qty;
	$arrleft[1] = $Value;
	return $arrleft;
}
function getInterJobWAprice($styleId,$matDetailId)
{
	global $db;
	$arrInterjob = array();
	$sql = "select COALESCE(Sum(ID.dblQty),0) as interJobQty,ID.strColor,ID.strSize,ID.intGrnNo, ID.intGrnYear,ID.strGRNType,intStyleIdFrom,ID.intMatDetailId from itemtransfer IH 
inner join itemtransferdetails ID on IH.intTransferId=ID.intTransferId and IH.intTransferYear=ID.intTransferYear
where IH.intStyleIdTo='$styleId' and IH.intStatus=3 and ID.intMatDetailId='$matDetailId'
group by ID.strColor,ID.strSize,ID.intGrnNo,ID.intGrnYear,ID.strGRNType,ID.intMatDetailId ";

	$result = $db->RunQuery($sql);
	$price =0;
	$leftOverQty =0;
	$waPrice =0;
	while($row = mysql_fetch_array($result))
	{
		$lQty = $row["interJobQty"];
		$matDetailId = $row["intMatDetailId"];
		
		$totQty += $lQty;
		$intGrnNo = $row["intGrnNo"];
		$fromStyleID = $row["intStyleIdFrom"];
		if($intGrnNo>30)
		{
			$strGRNType = $row["strGRNType"];
			switch($strGRNType)
			{
				case 'S':
				{
					$LOprice = getGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$fromStyleID,$matDetailId);
					$price += $LOprice*$lQty;
					break;
				}
				case 'B':
				{
					$BAprice = getBulkGRNprice($intGrnNo,$row["intGrnYear"],$row["strColor"],$row["strSize"],$matDetailId);
					$price += $BAprice*$lQty;
				}
			}
		}
	}	
	
	$arrInterjob[0] = $totQty;
	$arrInterjob[1] = $price;
	return $arrInterjob;
	
	
}

function getBulkGRNprice($intGrnNo,$grnYear,$strColor,$strSize,$matDetailId)
{
	global $db;
	
	$sql = "select bpo.dblUnitPrice/bgh.dblRate as uintprice
from  bulkgrnheader bgh inner join bulkgrndetails bgd on
bgh.intBulkGrnNo = bgd.intBulkGrnNo and bgh.intYear = bgd.intYear		
inner join bulkpurchaseorderdetails bpo on
bpo.intBulkPoNo = bgh.intBulkPoNo and 
bpo.intYear = bgh.intBulkPoYear and 
bpo.intMatDetailId = bgd.intMatDetailID
where bgh.intStatus=1 and  bgd.intMatDetailID='$matDetailId' and bgh.intBulkGrnNo='$intGrnNo' and bgh.intYear='$grnYear' and bgd.strColor='$strColor' and  bgd.strSize='$strSize'";

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["uintprice"];
}
function getLeftoverPrice($matDetailId,$intGrnNo,$grnYear,$color,$size,$grnType)
{
	global $db;
	$sql = "select dblUnitPrice from stocktransactions_leftover where intMatDetailId='$matDetailId' and
 strColor='$color' and strSize='$size' and intGrnNo='$intGrnNo' and intGrnYear='$grnYear' and strGRNType='$grnType' and strType='Leftover' ";
 	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["dblUnitPrice"];
}
function getGRNprice($intGrnNo,$grnYear,$strColor,$strSize,$styleId,$matDetailId)
{
	global $db;
	
	$sql = "select gd.dblInvoicePrice/gh.dblExRate as unitPrice
from grndetails gd inner join grnheader gh on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
where gh.intStatus =1 and gd.intStyleId='$styleId' and gd.intMatDetailID='$matDetailId' and gd.strColor='$strColor' and gd.strSize = '$strSize' and  gd.intGrnNo='$intGrnNo' and gd.intGRNYear='$grnYear'";

	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["unitPrice"];
}
?>
 <?php 
		//$totValue=0;
//		$purchasedQty=0;
//// start 2011-09-13 get total purchased qty (normal po qty & value) ----------------------------------------------
//	$sql_po = "select round(pd.dblUnitPrice/ph.dblExchangeRate,4) as UnitPrice ,pd.dblQty,pd.dblAdditionalQty 
//from purchaseorderdetails pd inner join purchaseorderheader ph on 
//pd.intPONo = ph.intPONo and ph.intYear= pd.intYear
//where ph.intStatus=10 and pd.intPOType=0 and pd.intStyleId='$pub_styleId' ";
//	$resultpurch = $db->RunQuery($sql_po);
//	
//	while($row_po = mysql_fetch_array($resultpurch))
//	{
//		$purchasedQty += $row_po["dblQty"];
//		$totValue += $row_po["dblQty"]*$row_po["UnitPrice"];
//	}
//// end 2011-09-13 get total purchased qty -------------------------------------------------
//
////start 2011-09-13 get total bulk allocation Qty and value --------------------------------------
//	$sql_bulk = " select cbd.dblQty,round(bgd.dblRate/bgh.dblRate,4) as UnitPrice
//from commonstock_bulkdetails cbd inner join commonstock_bulkheader cbh on
//cbd.intTransferNo = cbh.intTransferNo and cbd.intTransferYear = cbh.intTransferYear
//inner join bulkgrnheader bgh on bgh.intBulkGrnNo = cbd.intBulkGrnNo  and bgh.intYear = cbd.intBulkGRNYear
//inner join bulkgrndetails bgd on bgd.intBulkGrnNo = bgh.intBulkGrnNo and bgd.intYear = bgh.intYear
//and bgd.intMatDetailID=cbd.intMatDetailId
//where cbh.intStatus=1 and cbh.intToStyleId='$pub_styleId' ";
//	$result_bulk = $db->RunQuery($sql_bulk);
//	
//	while($row_b = mysql_fetch_array($result_bulk))
//	{
//		$purchasedQty += $row_b["dblQty"];
//		$totValue += $row_b["dblQty"]*$row_b["UnitPrice"];
//	}
////end 2011-09-13 get total bulk allocation Qty and value -------------------------------------------------
//
////start 2011-09-13 get leftover allocated qty and value ---------------------------------------------
//
//	$LeftAlloDet = getLeftAlloQtyandPrice($pub_styleId);
//	$arrLeftAlloDet = explode('**',$LeftAlloDet);
//	$purchasedQty += $arrLeftAlloDet[1];
//	$totValue += $arrLeftAlloDet[0];
//	
////end 2011-09-13 get leftover allocated qty and value------------------------------------------------
//
////start 2011-09-13 total interjob transfer in qty and value
//	$interjobDet = getInterJobWAprice($pub_styleId);
//	$arrInterjobDet = explode('**',$interjobDet);
//	$purchasedQty += $arrInterjobDet[1];
//	$totValue += $arrInterjobDet[0];
////end 2011-09-13 total interjob transfer in qty and value
//
//$totValue = round($totValue/$orderQty,2);
//echo number_format($totValue,2);
		?>
</body>
</html>
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

