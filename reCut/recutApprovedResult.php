<?php
 session_start();
include "../authentication.inc";
include "../Connector.php";
 $newSCNO = "";
 $backwardseperator ='../';
 $status = $_GET["status"];
 $remarks = $_GET["remarks"];
 $recutNo = $_GET["recutNo"];
 $recutYear = $_GET["recutYear"];
 
 $companyId=$_SESSION["FactoryID"];
 $userId		= $_SESSION["UserID"];
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro :: Recut Approved Result</title>
<link href="../css/erpstyle.css" rel="stylesheet"/>
<script language="javascript" type="text/javascript">
function Close()
{
	window.close();
}
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><?php include $backwardseperator.'Header.php';?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="850" border="0" cellspacing="0" cellpadding="2" class="bcgl1" bgcolor="#D2E9F7" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="50" class="normalfnth2Bm"><?php 
	if($status == 2)
	{
		
		$response = updateFistAppStatus($recutNo,$recutYear,$userId,$remarks);	
		if($response ==1)
			echo " Recut First Approval Saved Successfully. This Recut Order send for Second Approval";	
	}
	else if($status ==0)
	{
		$response = rejectRecutOrder($recutNo,$recutYear,$userId,$remarks);	
		if($response ==1)
			echo " Recut Rejected Successfully.";	
	}
	else if($status == 3)
	{
		$response = confirmRecutOrder($recutNo,$recutYear,$userId,$remarks);	
		if($response ==1)
			echo " Recut Confirmed Successfully.";	
	}
	?></td>
  </tr>
  <tr>
    <td align="center"><img src="../images/close.png" width="97" height="24" onClick="Close();"></td>
  </tr>
</table>
<?php 
function updateFistAppStatus($recutNo,$recutYear,$userId,$remarks)
{
	global $db;
	$sql = " update orders_recut 	set intStatus=2,
	intFirstApprovedBy = '$userId' , 
	dtmFirstAppDate = now() , 
	strAppRemarks = '$remarks'
	where
	intRecutNo = '$recutNo' and intRecutYear = '$recutYear' ";
	
	return $db->RunQuery($sql);
}
function rejectRecutOrder($recutNo,$recutYear,$userId,$remarks)
{
	global $db;
	$sql = " update orders_recut 	set intStatus=0,
	intFirstApprovedBy = Null , 
	dtmFirstAppDate = Null, 
	strAppRemarks = '$remarks'
	where
	intRecutNo = '$recutNo' and intRecutYear = '$recutYear' ";
	
	return $db->RunQuery($sql);
}
function confirmRecutOrder($recutNo,$recutYear,$userId,$remarks)
{
	global $db;
	$styleID = getStyleId($recutNo,$recutYear);

	$sql = "select orc.intStyleId,odr.intMatDetailID as strMatDetailID, odr.strUnit, odr.reaConPc as sngConPc, odr.reaWastage as sngWastage,s.strPurchaseMode,s.strOrdType,
s.strPlacement,s.intRatioType,odr.dblReqQty,odr.dblTotalQty,odr.dbltotalcostpc,odr.dblFreight,odr.intOriginNo
from orders_recut orc inner join orderdetails_recut odr on
orc.intRecutNo = odr.intRecutNo and orc.intRecutYear= odr.intRecutYear
inner join specificationdetails s on s.intStyleId = orc.intStyleId and odr.intMatDetailID = s.strMatDetailID
where s.intStyleId='$styleID' and orc.intRecutNo='$recutNo' and orc.intRecutYear='$recutYear'";

	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$styleNo =  $row["intStyleId"];			
		$item =  $row["strMatDetailID"];
		$freightCharge = $row["dblfreight"];
		//get order details
		$resOrder = getOrderDetails($styleNo);
		$row_o = mysql_fetch_array($resOrder);
		$orderQty = $row_o["intQty"];
		$newExpercentage = $row_o["reaExPercentage"];
		
		$qty = getTotRecutQty($styleNo,$item,$recutNo,$recutYear);
		$totQty = getTotRecutQty($styleNo,'N/A',$recutNo,$recutYear);
		//--------------end get order details
		
		if ($row["strPurchaseMode"] == "NONE" || $row["strPurchaseMode"] == "none" || $row["strPurchaseMode"] == "" )
		{
			
					
			$sqlbuyerPO = "select distinct styleratio.strBuyerPONO from styleratio where intStyleId = '$styleNo' ";
			$resulbpo=$db->RunQuery($sqlbuyerPO);
			while($rowbpo=mysql_fetch_array($resulbpo))
			{
				$buyerPONo = $rowbpo["strBuyerPONO"];
					$sqlratio = "select strColor,strSize,strBuyerPONO,sum(dblQty)AS matQty from materialratio where intStyleId = '$styleNo'  AND (strColor <> 'N/A' or strSize <> 'N/A')  AND strMatDetailID = '$item' AND strBuyerPONO = '$buyerPONo' group by strColor,strSize,strBuyerPONO;";
								
				$ismateriralratio = false;
				
				$sqlapprove="select Sum(dblQty)AS matTotal from materialratio where intStyleId='$styleNo' and strMatDetailID='$item' and strBuyerPONO='$buyerPONo'";
				$resultapprove=$db->RunQuery($sqlapprove);
				$rowapprove=mysql_fetch_array($resultapprove);				
				$matTotal=$rowapprove["matTotal"];				
			
				$resultratio=$db->RunQuery($sqlratio);
				while($rowratio=mysql_fetch_array($resultratio))
				{				
					$ismateriralratio = true;
					
					$color = $rowratio["strColor"];
					$size =  $rowratio["strSize"];
									
				
					$recutQty=(($rowratio["matQty"]/$matTotal)*$qty);
					if($recutQty>0)
						$recutQty =($recutQty<1?1:round($recutQty));
				
					updateMaterialRatioRecutQty($item,$styleNo,$buyerPONo,$color,$size,$recutQty);				
				}
				
				if (!$ismateriralratio)
				{
					
					$color = "N/A";
					$size = "N/A";
					
					$recutQty = getTotRecutQty($styleNo,$item,$recutNo,$recutYear);
					if($recutQty>0)
						$recutQty =($recutQty<1?1:round($recutQty));
					updateMaterialRatioRecutQty($item,$styleNo,$buyerPONo,$color,$size,$recutQty);	
				}
					
			}
		}
		else if ($row["strPurchaseMode"] == "COLOR" || $row["strPurchaseMode"] == "color" )
		{
			$sqlbuyerPO = "select distinct styleratio.strBuyerPONO from styleratio where intStyleId = '$styleNo' ";
			$resulbpo=$db->RunQuery($sqlbuyerPO);
			while($rowbpo=mysql_fetch_array($resulbpo))
			{
				$buyerPONo = $rowbpo["strBuyerPONO"];
								
				$sqlratio = "select strColor, sum(dblQty) as colorqty from styleratio where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' group by strColor;";
				$resultratio=$db->RunQuery($sqlratio);
				
				while($rowratio=mysql_fetch_array($resultratio))
				{
					$color = $rowratio["strColor"];
					$size =  "N/A";
					$colorQty = $rowratio["colorqty"]/$orderQty*$qty;
					//$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $rowratio["colorqty"];	
					$recutQty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $colorQty +( $row["sngConPc"] *($newExpercentage * $colorQty/ 100));	
					
					if($recutQty>0)
						$recutQty =($recutQty<1?1:round($recutQty));
						
					updateMaterialRatioRecutQty($item,$styleNo,$buyerPONo,$color,$size,$recutQty);	
				}	
			}
		}
		else if ($row["strPurchaseMode"] == "SIZE" || $row["strPurchaseMode"] == "size" )
		{
			
			$sqlbuyerPO = "select distinct styleratio.strBuyerPONO from styleratio where intStyleId = '$styleNo' ";
			$resulbpo=$db->RunQuery($sqlbuyerPO);
			while($rowbpo=mysql_fetch_array($resulbpo))
			{
				$buyerPONo = $rowbpo["strBuyerPONO"];
				
				$sqlratio = "select strSize, sum(dblQty) as sizeqty from styleratio where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' group by strSize;";
				$resultratio=$db->RunQuery($sqlratio);
				$charpos = 0;
				$previousColor ="";
				while($rowratio=mysql_fetch_array($resultratio))
				{
					$color = "N/A";
					$size =  $rowratio["strSize"];
					$sizeQty = $rowratio["sizeqty"]/$orderQty*$qty;
					
					//$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $rowratio["sizeqty"];	
					$recutQty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $sizeQty+( $row["sngConPc"] *($newExpercentage *$sizeQty / 100));	
					// echo $size.'-'.$rowratio["sizeqty"].'-'.$recutQty.'-'.$totQty.'-'.$sizeQty.'</br>';
					if($recutQty>0)
						$recutQty =($recutQty<1?1:round($recutQty));
					
					updateMaterialRatioRecutQty($item,$styleNo,$buyerPONo,$color,$size,$recutQty);				
			}
		}
	}
	else if ($row["strPurchaseMode"] == "BOTH" || $row["strPurchaseMode"] == "both" )
		{
					   
			$sqlbuyerPO = "select distinct styleratio.strBuyerPONO from styleratio where intStyleId = '$styleNo' ";
			$resulbpo=$db->RunQuery($sqlbuyerPO);
			while($rowbpo=mysql_fetch_array($resulbpo))
			{
				$buyerPONo = $rowbpo["strBuyerPONO"];
				$poQty = 0;
				
				
				$sqlratio = "select strSize, strColor,dblQty from styleratio where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' ;";
				$resultratio=$db->RunQuery($sqlratio);
				$charpos = 0;
				$previousColor = "";
				while($rowratio=mysql_fetch_array($resultratio))
				{
					$color = $rowratio["strColor"];
					$size =  $rowratio["strSize"];
					$ratioQty = $rowratio["dblQty"]/$orderQty*$qty;
					//echo $ratioQty.'-'.$color.'-'.$size.'</br>';
					//$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $rowratio["dblQty"];	
					$recutQty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $ratioQty+( $row["sngConPc"] *($newExpercentage *$ratioQty / 100));	
					if($recutQty>0)
						$recutQty =($recutQty<1?1:round($recutQty));
					updateMaterialRatioRecutQty($item,$styleNo,$buyerPONo,$color,$size,$recutQty);	
				}	
			}
		}
	}
		//$recutNo,$recutYear,$userId,$remarks
		$sql_s = " update orders_recut 	set
	intStatus = '3' , 	strAppRemarks = '$remarks',intConfirmedBy='$userId', dtmConfirm=now()
	where
	intRecutNo = '$recutNo' and intRecutYear = '$recutYear' ";
	return $db->RunQuery($sql_s);
}

function getStyleId($recutNo,$recutYear)
{
	global $db;
	$sql = "select intStyleId from orders_recut where intRecutNo='$recutNo' and intRecutYear='$recutYear'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["intStyleId"];
}
function getTotRecutQty($styleNo,$item,$recutNo,$recutYear)
{
	global $db;
	$confirmRecutQty = getConfirmedRecutItemTotalQty($styleNo,$item);
	
	$sql = "select sum(odr.dblTotalQty) as recutQty from orders_recut orc inner join orderdetails_recut odr on 
orc.intRecutNo = odr.intRecutNo and orc.intRecutYear= odr.intRecutYear 
where orc.intStatus=2 and orc.intRecutNo='$recutNo' and orc.intRecutYear='$recutYear' ";
if($item != 'N/A')
	$sql .= "  and odr.intMatDetailID='$item' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["recutQty"]+$confirmRecutQty;
	
}
function getConfirmedRecutItemTotalQty($styleNo,$item)
{
	global $db;
	$sql = "select sum(odr.dblTotalQty) as confirmQty from orders_recut orc inner join orderdetails_recut odr on 
orc.intRecutNo = odr.intRecutNo and orc.intRecutYear= odr.intRecutYear 
where orc.intStatus=3 and orc.intStyleId='$styleNo' ";
if($item != 'N/A')
	$sql .= "  and odr.intMatDetailID='$item' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["confirmQty"];
}
function updateMaterialRatioRecutQty($item,$styleNo,$buyerPONo,$color,$size,$recutQty)
{
	global $db;
	$recutQty = round($recutQty);
	//2011-09-06 start calculate material ratio bal qty
	$matRatioQty = getMaterialRatioQty($item,$styleNo,$buyerPONo,$color,$size);
	$purchasedQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 0);
	$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$buyerPONo,$item,$color,$size);
	$leftAlloQty = confirmLeftOverQty($styleNo,$buyerPONo,$item,$color,$size);
	
	$balQty = $matRatioQty + $recutQty - $purchasedQty - $bulkAlloQty - $leftAlloQty;
	//2011-09-06 end calculate material ratio bal qty
	$sql = " update materialratio 
	set
	dblRecutQty = '$recutQty', dblBalQty ='$balQty'
	where
	intStyleId = '$styleNo' and strMatDetailID = '$item' and strColor = '$color' and strSize = '$size' and strBuyerPONO = '$buyerPONo' ";
	
	$result = $db->RunQuery($sql);
}

function getOrderDetails($styleId)
{
	global $db;
	$sql = "select * from orders where intStyleId='$styleId' ";
	return $db->RunQuery($sql);
}
function getMaterialRatioQty($item,$styleNo,$buyerPONo,$color,$size)
{
	global $db;
	$sql = " select dblQty from materialratio where intStyleId='$styleNo' and strMatDetailID='$item' and strColor='$color'
and strSize='$size' and strBuyerPONO='$buyerPONo' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["dblQty"];
}

function getPurchasedQty($styleNo,$itemCode,$buyerPO,$color, $size, $Type)
{
	global $db;	
	//$buyerPO = str_replace("Main Ratio","#Main Ratio#",$buyerPO);
	$sql = "select sum(dblQty) as purchasedQty from purchaseorderdetails,purchaseorderheader where purchaseorderdetails.intStyleId = '$styleNo' AND purchaseorderdetails.intMatDetailID = $itemCode AND purchaseorderdetails.strBuyerPONO = '$buyerPO' AND purchaseorderdetails.strColor = '$color' AND purchaseorderdetails.strSize = '$size' AND purchaseorderdetails.intPOType = $Type  AND purchaseorderheader.intPONo = purchaseorderdetails.intPONo AND purchaseorderheader.intYear = purchaseorderdetails.intYear  AND  purchaseorderheader.intStatus = 10 AND intPOType=$Type";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		if ($row["purchasedQty"] == "" || $row["purchasedQty"]  == NULL)
			return 0;
			
		return $row["purchasedQty"];
	}
	
	return 0;
}
function confirmgetBulkAlloQty($styleID,$buyerPO,$matId,$color,$size)
{
global $db;
	$sqlBulkAllo = "SELECT COALESCE(sum(BCD.dblQty)) as Bulkqty
					FROM commonstock_bulkdetails BCD INNER JOIN commonstock_bulkheader BCH ON
					BCD.intTransferNo = BCH.intTransferNo AND 
					BCD.intTransferYear = BCH.intTransferYear
					WHERE BCH.intToStyleId = '$styleID'  and BCH.strToBuyerPoNo='$buyerPO' and 
					BCD.strColor = '$color' and BCD.strSize='$size' and 
					BCD.intMatDetailId = '$matId' and BCH.intStatus=1";
					
			$resulBulkAllo = $db->RunQuery($sqlBulkAllo);	
			$rowBulkAllo = mysql_fetch_array($resulBulkAllo);
			$Bulkqty = $rowBulkAllo["Bulkqty"];
			
			if($Bulkqty == '' || is_null($Bulkqty))
				$Bulkqty = 0;
			//echo $sqlBulkAllo;	
			return $Bulkqty;
}
function confirmLeftOverQty($styleID,$buyerPO,$matId,$color,$size)
{

global $db;
	$sqlLeftover = "SELECT COALESCE(sum(LCD.dblQty)) as LeftAlloqty
						FROM commonstock_leftoverdetails LCD INNER JOIN commonstock_leftoverheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$styleID'  and LCH.strToBuyerPoNo= '$buyerPO' 
						and LCD.strColor = '$color' and LCD.strSize='$size' and 
						LCD.intMatDetailId = '$matId' and LCH.intStatus=1 ";	
						
			$resultLeftAllo = $db->RunQuery($sqlLeftover);	
			$rowLeftAllo = mysql_fetch_array($resultLeftAllo);
			$LeftAlloqty = $rowLeftAllo["LeftAlloqty"];
			//echo $sqlLeftover;
			if($LeftAlloqty == '' || is_null($LeftAlloqty))
				$LeftAlloqty = 0;	
				
		return $LeftAlloqty;
}
?>
</body>
<script typr="text/javascript">
window.opener.location.reload();
</script>
</html>
