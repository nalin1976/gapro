<?php
session_start();
$backwardseperator = "../../";
include "${backwardseperator}authentication.inc";
include('../../Connector.php');
include("class.washReceiveSummary.php");
$report_companyId = $_SESSION["FactoryID"];
 
$styleID=$_GET['po'];
$style=$_GET['style'];
$dfrom=$_GET['dFrm'];
$dto=$_GET['dTo'];
$comID=$_GET['fFac'];
if ($styleID!='' || $style!='' || $dfrom!='' || $dto!='' || $comID!='')
	$chk=1;
else
	$chk=0;
$wrsr=new washReceiveSummary();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro :: Wash Receive Summary- Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->
table
{
	border-spacing:0px;
}
</style>
</head>
<body>
<table width="900" align='center' CELLPADDING=3 CELLSPACING=1 >
	  <tr>
	    <td><?php include '../../reportHeader.php';?></td>
  </tr>
  <tr>
	    <td class="head2">Wash Receive Summary</td>
  </tr>
  <tr>
	    <td class="head2">&nbsp;</td>
  </tr>
</table>
 
<table width="900"  align='center' border='0'>
	
      <tr>
      	<td colspan="3" width="100%">
        
        	<table width="100%" border='1' cellpadding="0" cellspacing="0" rules="all" >
            <tr  height="20">
                <td width="89" class='normalfntMid'><b>PO No</b></td>
                <td width="94" class='normalfntMid'><b>Style No</b></td>
                <td width="184" class='normalfntMid'><b>Style</b></td>
                <td width="114" class='normalfntMid'><b>Color</b></td>
                <td width="89" class='normalfntMid'><b>Order Qty</b></td>
                <td width="100" class='normalfntMid'><b>Gatepass Qty</b></td>
                <td width="73" class='normalfntMid'><b>Cum.QTY</b></td>
                <td width="133" class='normalfntMid'><b>To be Received Qty</b></td>
            </tr>
            <?php 
			$res=$wrsr->getMainDetails($_SESSION["FactoryID"],$chk,$styleID,$style,$dfrom,$dto,$comID);
			while($row=mysql_fetch_assoc($res)){
				$rcvd=0;
				$totGp=0
			?>
            <tr  height="20">
                <td width="89" class='normalfnt'>&nbsp;<?php echo $row['strOrderNo'];?></td>
                <td width="94" class='normalfnt'>&nbsp;<?php echo $row['strStyle'];?></td>
                <td width="184" class='normalfnt'>&nbsp;<?php echo $row['strDescription'];?></td>
                <td width="114" class='normalfnt'>&nbsp;<?php echo $row['strColor'];?></td>
                <td width="89" class='normalfntR'><?php echo $row['intQty'];?>&nbsp;</td>
                <td width="100" class='normalfntR'><?php echo $totGp=$wrsr->getGPQtyAndToBRcvd($_SESSION["FactoryID"],$row['GPNO'],$row['intStyleId']);?></td>
                <td width="73" class='normalfntR'><?php echo $rcvd=$row['CQty'];?>&nbsp;</td>
                <td width="133" class='normalfntR'><?php echo $totGp-$rcvd;?>&nbsp;</td>
                
            </tr>
            <?php }?>
</table>	

  </td>
  </tr>
  </table>


</body>
</html>
