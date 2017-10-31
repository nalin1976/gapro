<?php
 session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GaPro - : :  Approved</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #716F64}
-->
</style>
</head>

<body>
<table width="965" border="0" align="center">
  <tr>
    <td width="752"><?php include 'Header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1">
      <tr>
        <td height="88">&nbsp;</td>
      </tr>
      <tr>
        <td height="57" bgcolor="#D2E9F7" class="normalfnth2Bm"><span class="style1">
          <?php
		  
include "Connector.php";

function startApprovalProcess($styleID)
{
	// Done by Prasad Rajapaksha
	// Creating variables	
	
	global $db;
	global $newSCNO;
	$appNo=0;
	$srNo=0;
	$currentOrderQty = getCurrentSpecQty($styleID);
	$currentExpercentage = getCurrentEXQty($styleID);
	$newOrderQty = 0;
	$newExpercentage = 0;
	
	// Generating Approval No
	$sql="SELECT  MAX(intApprovalNo) as appNo FROM history_orders h where intStyleId='".$styleID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$appNo=$row["appNo"];
	}
	$appNo++;
	
	// Generating SR No
	$sql="SELECT MAX(intSRNO)as srNo FROM specification ";
	$resultSr=$db->RunQuery($sql);
	while($rowsr=mysql_fetch_array($resultSr))
	{
		$srNo=$rowsr["srNo"];
	}
	$srNo++;
	
	
	$sql="SELECT * FROM orders o where intStyleId='".$styleID."' ;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$newOrderQty = $row["intQty"];
		$newExpercentage = $row["reaExPercentage"];

	}
	/*
	
	$sql="SELECT * FROM orderdetails o where intStyleId='".$styleID."';";
	$resultItems=$db->RunQuery($sql);
	while($rowItems=mysql_fetch_array($resultItems))
	{
		// Saving Order details to History Order Details
		saveHistoryOrderDetails($rowItems["strOrderNo"],$styleID,$rowItems["intMatDetailID"],$rowItems["strUnit"],$rowItems["dblUnitPrice"],$rowItems["reaConPc"],$rowItems["reaWastage"],$rowItems["strCurrencyID"],$rowItems["intOriginNo"],$rowItems["dblReqQty"],$rowItems["dblTotalQty"],$rowItems["dblTotalValue"],$rowItems["dbltotalcostpc"],$rowItems["dblFreight"],$appNo);
		if(IsVariationAvailable($styleID))
		{
			$resultVari=getVariationData($rowItems["intMatDetailID"],$styleID);
			while($rowVari=mysql_fetch_array($resultVari))
			{
				// Saving Variations to History Conpccalc
				SaveHistoryVariations($styleID,$rowVari["strMatDetailID"],$rowVari["intNo"],$rowVari["dblConPc"],$rowVari["dblUnitPrice"],$rowVari["dblWastage"],$rowVari["strColor"],$rowVari["strRemarks"],$rowVari["intqty"],$appNo);
			}
		}	
	}
	*/
	saveHistoryDeliveryDetails($styleID);
	$specavailability = IsSpecificationAvailable($styleID);
	///echo "."  . $specavailability . ".";
	 if($specavailability=="TRUE")
	  {
	
	  	  // Save History Specification
		  $sql="INSERT INTO historyspecification(intSRNO,intStyleId,dblQuantity)SELECT intSRNO,intStyleId,dblQuantity FROM specification where intStyleId='$styleID';";

		  $db->ExecuteQuery($sql); 
		  
		  // Getting Old SC No
		  $sql="SELECT intSRNO FROM specification WHERE intStyleId='$styleID';";
		  $result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{
				 
				$srNo=$row["intSRNO"];
			}
		  
		  // Delete Old Specifications
		  $sql="DELETE FROM specification WHERE intStyleId='$styleID';";

		   $db->ExecuteQuery($sql); 
		   
		   // Save History Specification Details
		   $sql="INSERT INTO historyspecificationdetails(intStyleId,strMatDetailID,strUnit,dblUnitPrice,sngConPc,
		sngWastage,strPurchaseMode,strOrdType,strPlacement,intRatioType,dblReqQty,dblTotalQty,
		dblTotalValue,dblCostPC,dblfreight,intOriginNo) SELECT intStyleId, strMatDetailID,
		 strUnit,dblUnitPrice,sngConPc,sngWastage,strPurchaseMode,strOrdType,strPlacement,
		 intRatioType,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblfreight,intOriginNo FROM specificationdetails where intStyleId='$styleID';";

		  $db->ExecuteQuery($sql); 
		  
		  // Delete Specification Details
		  $sql="DELETE FROM specificationdetails WHERE intStyleId='".$styleID."';";
  
		  $db->ExecuteQuery($sql);
	  }
	  $newSCNO = $srNo;
	
	// Save Specification
	$sql="INSERT INTO specification(intSRNO,intStyleId,dblQuantity,intOrdComplete) VALUES('$srNo','$styleID','$newOrderQty','0');";

	$db->ExecuteQuery($sql);
		
	//Save Specification Details
	$sql="SELECT * FROM orderdetails o where intStyleId='".$styleID."';";
	$resultItems=$db->RunQuery($sql);
	while($rowItems=mysql_fetch_array($resultItems))
	{
		saveSpecificationDetails($styleID,$rowItems["intMatDetailID"],$rowItems["strUnit"],$rowItems["dblUnitPrice"],$rowItems["reaConPc"],$rowItems["reaWastage"],"NONE","","",0,$rowItems["dblReqQty"],$rowItems["dblTotalQty"],$rowItems["dblTotalValue"],$rowItems["dbltotalcostpc"],$rowItems["dblFreight"],$rowItems["intOriginNo"] );
	}
	
	// Update ourchase types of new specifications
	$sql = "select strMatDetailID from specificationdetails where intStyleId = '$styleID';";
	$resultItems=$db->RunQuery($sql);
	while($rowItems=mysql_fetch_array($resultItems))
	{
		$sqlinner = "select intSpecID, strMatDetailID, strPurchaseMode from historyspecificationdetails where intStyleId = '$styleID' AND strMatDetailID = '" . $rowItems["strMatDetailID"] . "' order by intSpecID desc limit 1;";
		$resultmats=$db->RunQuery($sqlinner);
		while($rowmats=mysql_fetch_array($resultmats))
		{
			$prchMode = $rowmats["strPurchaseMode"];
			if ($prchMode == "")
				$prchMode = "NONE";
			$sql = "update specificationdetails set strPurchaseMode = '" . $prchMode   . "' where intStyleId = '$styleID' AND strMatDetailID ='" . $rowItems["strMatDetailID"]  . "';";

			$db->ExecuteQuery($sql);
		}
	}
	
	// If Order Quantity changed by pre order
	if ($newOrderQty != $currentOrderQty)
	{
		//  Modify the style ratio qty & exqty
		$sql = "update styleratio set dblQty = CAST((dblQty / $currentOrderQty * $newOrderQty) AS UNSIGNED INTEGER), dblExQty = CAST((dblQty + (dblQty * $newExpercentage / 100)) AS UNSIGNED INTEGER) where intStyleId = '$styleID';";

		$db->ExecuteQuery($sql);
		
		// get computer balance qty which generated due to computer calculations
		$balQty = 0 ;
		$sql = "select (select dblQuantity from specification where intStyleId = '$styleID') - (select sum(dblQty) as tot from styleratio where intStyleId = '$styleID') as diff ;";
		$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$balQty = $row["diff"];
		}
		
		// If balance quantity available
		if ($balQty  > 0)
		{
			$sql = "select intStyleId,strBuyerPONO,strColor,strSize from styleratio where intStyleId = '$styleID' Limit 1;";
			$result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{
				// Add available balance qty to immediate first style ratio | color -size
				$sql = "update styleratio set dblQty = dblQty + $balQty where intStyleId = '$styleID' AND strBuyerPONO = '". $row["strBuyerPONO"] . "' AND  strColor = '" . $row["strColor"] . "' AND strSize = '" . $row["strSize"] . "';";

				$db->ExecuteQuery($sql);
			}
		}
		
		// get computer balance excess qty which generated due to computer calculations
		$balQty = 0 ;
		$sql = "select (select dblQuantity + ( dblQuantity * (select reaExPercentage from orders where intStyleId  = '$styleID')/ 100) as  dblQuantity  from specification where intStyleId = '$styleID') - (select sum(dblExQty) as tot from styleratio where intStyleId = '$styleID') as diff ;";
		$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$balQty = $row["diff"];
		}
		
		// If balance excess quantity available
		if ($balQty  > 0)
		{
			$sql = "select intStyleId,strBuyerPONO,strColor,strSize from styleratio where intStyleId = '$styleID' Limit 1;";
			$result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{
				// Add available balance excess qty to immediate first style ratio | color -size
				$sql = "update styleratio set dblExQty = dblExQty + $balQty where intStyleId = '$styleID' AND strBuyerPONO = '". $row["strBuyerPONO"] . "' AND  strColor = '" . $row["strColor"] . "' AND strSize = '" . $row["strSize"] . "';";

				$db->ExecuteQuery($sql);
			}
		}		
	}
	
	saveToHistoryStyleMat($styleID);
	
	$sql = "insert into historymaterialratio (intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID)  select  intStyleId, 	strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID from materialratio where intStyleId = '$styleID' ";
	$db->ExecuteQuery($sql);
	
	// Remove material ratios which are not applicable for the current style materials
	$sql = "delete from materialratio where intStyleId = '$styleID' AND strMatDetailID not in (select strMatDetailID from specificationdetails where intStyleId = '$styleID') ; ";

	$db->ExecuteQuery($sql);
	
	
	// Delete material ratios for color - N/A , size N/A
	$sql = "delete from materialratio where intStyleId = '$styleID'  AND strColor = 'N/A' AND strSize = 'N/A'; ";

	$db->ExecuteQuery($sql);
	
	

	
	$sql = "select intStyleId,strMatDetailID,strUnit,dblUnitPrice,sngConPc,sngWastage,strPurchaseMode,strOrdType,strPlacement,intRatioType,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblfreight,intOriginNo from specificationdetails where intStyleId = '$styleID' ;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$styleNo =  $row["intStyleId"];			
		$item =  $row["strMatDetailID"];
		$freightCharge = $row["dblfreight"];
		if ($row["strPurchaseMode"] == "NONE" || $row["strPurchaseMode"] == "none" || $row["strPurchaseMode"] == "" )
		{		
			$sqlbuyerPO = "select distinct styleratio.strBuyerPONO from styleratio where intStyleId = '$styleNo' ";
			$resulbpo=$db->RunQuery($sqlbuyerPO);
			while($rowbpo=mysql_fetch_array($resulbpo))
			{
				$buyerPONo = $rowbpo["strBuyerPONO"];
				$poQty = 0;
				if ($buyerPONo == "#Main Ratio#" ||$buyerPONo ==  "#MAIN RATIO#")
				{
					$poQty = $newOrderQty;
				}
				else
				{
					$SQLPOQTY = "SELECT dblQty from style_buyerponos where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' ;";
					$resulbpoqty=$db->RunQuery($SQLPOQTY);
					while($rowbpoqty=mysql_fetch_array($resulbpoqty))
					{
						$poQty = $rowbpoqty["dblQty"];
					}
				}
				
				$sqlratio = "select strColor,strSize,strBuyerPONO from materialratio where intStyleId = '$styleNo'  AND (strColor = 'N/A' or strSize = 'N/A')  AND strMatDetailID = '$item' AND strBuyerPONO = '$buyerPONo';";
				
				$charpos = 0;
				$previousColor = "";
				$ismateriralratio = false;
				$resultratio=$db->RunQuery($sqlratio);
				while($rowratio=mysql_fetch_array($resultratio))
				{
					$ismateriralratio = true;
					
					$color = $rowratio["strColor"];
					$size =  $rowratio["strSize"];
					$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $poQty +( $row["sngConPc"] *($newExpercentage * $poQty / 100));
					
					$purchasedQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 0);
					$purchasedFreightQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 1);
					$balQty =  $qty - $purchasedQty;
					$dblFreightBal =  $qty  - $purchasedFreightQty; 
					if ($freightCharge  <= 0)
						$dblFreightBal = 0;
					SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,getCharforID($charpos));
					if($previousColor != $color)
					{
						$charpos ++;
						$previousColor = $color;
					}
				
				}
				
				if (!$ismateriralratio)
				{
					
					$color = "N/A";
					$size = "N/A";
					$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $poQty +( $row["sngConPc"] *($newExpercentage * $poQty / 100));
			
					$purchasedQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 0);
					$purchasedFreightQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 1);
					$balQty =  $qty- $purchasedQty;
					$dblFreightBal =  $qty - $purchasedFreightQty; 
					if ($freightCharge  <= 0)
						$dblFreightBal = 0;
					SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,getCharforID($charpos));
					if($previousColor != $color)
					{
						$charpos ++;
						$previousColor = $color;
					}
				}
					
			}
		}
		else if ($row["strPurchaseMode"] == "COLOR" || $row["strPurchaseMode"] == "color" )
		{
			$sql = "delete from materialratio where intStyleId = '$styleID'  AND strMatDetailID = '$item'; ";
		   $db->ExecuteQuery($sql);
		   
			$sqlbuyerPO = "select distinct styleratio.strBuyerPONO from styleratio where intStyleId = '$styleNo' ";
			$resulbpo=$db->RunQuery($sqlbuyerPO);
			while($rowbpo=mysql_fetch_array($resulbpo))
			{
				$buyerPONo = $rowbpo["strBuyerPONO"];
				$poQty = 0;
				if ($buyerPONo == "#Main Ratio#")
				{
					$poQty = $newOrderQty;
				}
				else
				{
					$SQLPOQTY = "SELECT dblQty from style_buyerponos where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' ;";
					$resulbpoqty=$db->RunQuery($SQLPOQTY);
					while($rowbpoqty=mysql_fetch_array($resulbpoqty))
					{
						$poQty = $rowbpoqty["dblQty"];
					}
				}
				
				$sqlratio = "select strColor, sum(dblExQty) as colorqty from styleratio where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' group by strColor;";
				$resultratio=$db->RunQuery($sqlratio);
				$charpos = 0;
				$previousColor = "";
				while($rowratio=mysql_fetch_array($resultratio))
				{
					$color = $rowratio["strColor"];
					$size =  "N/A";
					//$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $rowratio["colorqty"];	
					$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $rowratio["colorqty"] +( $row["sngConPc"] *($newExpercentage * $rowratio["colorqty"]/ 100));	
					
					$purchasedQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 0);
					$purchasedFreightQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 1);
					$balQty =  $qty - $purchasedQty;
					$dblFreightBal =  $qty  - $purchasedFreightQty; 
					if ($freightCharge  <= 0)
						$dblFreightBal = 0;
					SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,getCharforID($charpos));
					if($previousColor != $color)
					{
						$charpos ++;
						$previousColor = $color;
					}
					//echo $item . "   -   "  .  $qty  . "  -   "  . $purchasedQty . "  - "  .  $balQty . "   -   " . $color . "    -    " .   $row["sngConPc"] .  "   -    " . $rowratio["colorqty"] . "<br>";
				}	
			}
		}
		else if ($row["strPurchaseMode"] == "SIZE" || $row["strPurchaseMode"] == "size" )
		{
			$sql = "delete from materialratio where intStyleId = '$styleID'  AND strMatDetailID = '$item'; ";
		   $db->ExecuteQuery($sql);
		   
			$sqlbuyerPO = "select distinct styleratio.strBuyerPONO from styleratio where intStyleId = '$styleNo' ";
			$resulbpo=$db->RunQuery($sqlbuyerPO);
			while($rowbpo=mysql_fetch_array($resulbpo))
			{
				$buyerPONo = $rowbpo["strBuyerPONO"];
				$poQty = 0;
				if ($buyerPONo == "#Main Ratio#")
				{
					$poQty = $newOrderQty;
				}
				else
				{
					$SQLPOQTY = "SELECT dblQty from style_buyerponos where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' ;";
					$resulbpoqty=$db->RunQuery($SQLPOQTY);
					while($rowbpoqty=mysql_fetch_array($resulbpoqty))
					{
						$poQty = $rowbpoqty["dblQty"];
					}
				}
				
				$sqlratio = "select strSize, sum(dblExQty) as sizeqty from styleratio where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' group by strSize;";
				$resultratio=$db->RunQuery($sqlratio);
				$charpos = 0;
				$previousColor ="";
				while($rowratio=mysql_fetch_array($resultratio))
				{
					$color = "N/A";
					$size =  $rowratio["strSize"];
					//$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $rowratio["sizeqty"];	
					$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $rowratio["sizeqty"]+( $row["sngConPc"] *($newExpercentage * $rowratio["sizeqty"] / 100));	
					$purchasedQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 0);
					$purchasedFreightQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 1);
					$balQty =  $qty - $purchasedQty;
					$dblFreightBal =  $qty  - $purchasedFreightQty; 
					if ($freightCharge  <= 0)
						$dblFreightBal = 0;
					SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,getCharforID($charpos));
				if($previousColor != $color)
					{
						$charpos ++;
						$previousColor = $color;
					}
				}	
			}
		}
		else if ($row["strPurchaseMode"] == "BOTH" || $row["strPurchaseMode"] == "both" )
		{
			$sql = "delete from materialratio where intStyleId = '$styleID'  AND strMatDetailID = '$item'; ";
		   $db->ExecuteQuery($sql);
			$sqlbuyerPO = "select distinct styleratio.strBuyerPONO from styleratio where intStyleId = '$styleNo' ";
			$resulbpo=$db->RunQuery($sqlbuyerPO);
			while($rowbpo=mysql_fetch_array($resulbpo))
			{
				$buyerPONo = $rowbpo["strBuyerPONO"];
				$poQty = 0;
				if ($buyerPONo == "#Main Ratio#")
				{
					$poQty = $newOrderQty;
				}
				else
				{
					$SQLPOQTY = "SELECT dblQty from style_buyerponos where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' ;";
					$resulbpoqty=$db->RunQuery($SQLPOQTY);
					while($rowbpoqty=mysql_fetch_array($resulbpoqty))
					{
						$poQty = $rowbpoqty["dblQty"];
					}
				}
				
				$sqlratio = "select strSize, strColor,dblQty from styleratio where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' ;";
				$resultratio=$db->RunQuery($sqlratio);
				$charpos = 0;
				$previousColor = "";
				while($rowratio=mysql_fetch_array($resultratio))
				{
					$color = $rowratio["strColor"];
					$size =  $rowratio["strSize"];
					//$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $rowratio["dblQty"];	
					$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $rowratio["dblQty"]+( $row["sngConPc"] *($newExpercentage * $rowratio["dblQty"] / 100));	
					$purchasedQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 0);
					$purchasedFreightQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 1);
					$balQty =  $qty - $purchasedQty;
					$dblFreightBal =  $qty  - $purchasedFreightQty; 
					if ($freightCharge  <= 0)
						$dblFreightBal = 0;
					SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,getCharforID($charpos));
					{
						$charpos ++;
						$previousColor = $color;
					}
				}	
			}
		}
	}
	
// Deleting unwanted contrast items 
	$sql = "DELETE FROM contrastitem WHERE intStyleId = '$styleID' AND strMatDetailID NOT IN 
(SELECT strMatDetailID FROM specificationdetails WHERE  intStyleId = '$styleID' )";
	$db->ExecuteQuery($sql);
	
	$contrastStyle = $styleID;
	include 'contrastprocess.php';
	
	return true;
}

function getCurrentSpecQty($styleID)
{
	global $db;
	$SQL = "select dblQuantity from specification where intStyleId = '$styleID'";
	$result=$db->RunQuery($SQL);
	while($row=mysql_fetch_array($result))
	{
		return $row["dblQuantity"];
	}
	return 0;
}

function getCurrentEXQty($styleID)
{
	global $db;
	$SQL = "select intApprovalNo , reaExPercentage from history_orders where intStyleId = '$styleID'  order by intApprovalNo  desc limit 1";
	$result=$db->RunQuery($SQL);
	while($row=mysql_fetch_array($result))
	{
		return $row["reaExPercentage"];
	}
	return 0;
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

function SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,$charPos)
{
	global $db;
	global $newSCNO;
	$qty = round($qty);
	$sql = "select intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO from materialratio where intStyleId = '$styleNo' and  strMatDetailID = '$item' and strColor = '$color' and strSize = '$size' and strBuyerPONO = '$buyerPONo';";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$sql = "update materialratio set dblQty = $qty, dblBalQty = $balQty, dblFreightBalQty = $dblFreightBal where intStyleId = '$styleNo' and  strMatDetailID = '$item' and strColor = '$color' and strSize = '$size' and strBuyerPONO = '$buyerPONo';";

		$db->executeQuery($sql); 
		return true;
	}
	
	$matRatioID = $newSCNO . "-" . $item . "" . $charPos;
	//$buyerPONo = str_replace("Main Ratio","#Main Ratio#",$buyerPONo);
	$sql="insert into materialratio (intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,dblFreightBalQty,materialRatioID) values ('$styleNo','$item','$color','$size','$buyerPONo',$qty,$balQty,$dblFreightBal,'$matRatioID');";

	$db->executeQuery($sql);
	return true;
}

function IsVariationAvailable($styleID)
{
	global $db;
	$sql="SELECT COUNT(intStyleId)AS Variation FROM conpccalculation c where intStyleId='".$styleID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row["Variation"]>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

function IsDeliveryShedule($styleID)
{
	global $db;
	$sql="SELECT COUNT(intStyleId)AS DeliveryCount FROM deliveryschedule d WHERE intStyleId='".$styleID."';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row["DeliveryCount"]>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
}
function IsSpecificationAvailable($styleID)
{
global $db;
$sql="SELECT COUNT(intStyleId) AS specCount FROM specification s WHERE intStyleId='".$styleID."';";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
	{
	if($row["specCount"]>0)
		{
			return "TRUE";
		}
		else
		{
			return "FALSE";
		}
	}
}

function saveSpecification($srNo,$styleID,$dblQty,$orderComplete)
{
	  global $db;
	  if(IsSpecificationAvailable($styleID)=="TRUE")
	  {
		  $sql="INSERT INTO historyspecification(intSRNO,intStyleId,dblQuantity)SELECT intSRNO,intStyleId,dblQuantity FROM specification where intStyleId='$styleID';";

		  $db->ExecuteQuery($sql); 
		  
		  $sql="DELETE FROM specification WHERE intStyleId='$styleID';";

		   $db->ExecuteQuery($sql); 
		   
		   $sql="INSERT INTO historyspecificationdetails(intStyleId,strMatDetailID,strUnit,dblUnitPrice,sngConPc,
		sngWastage,strPurchaseMode,strOrdType,strPlacement,intRatioType,dblReqQty,dblTotalQty,
		dblTotalValue,dblCostPC,dblfreight,intOriginNo) SELECT intStyleId, strMatDetailID,
		 strUnit,dblUnitPrice,sngConPc,sngWastage,strPurchaseMode,strOrdType,strPlacement,
		 intRatioType,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblfreight,intOriginNo FROM specificationdetails where intStyleId='$styleID';";

		  $db->ExecuteQuery($sql); 
		  
		  $sql="DELETE FROM specificationdetails WHERE intStyleId='".$styleID."';";

		  
		  $db->ExecuteQuery($sql);
	  }
  	
		$sql="INSERT INTO specification(intSRNO,intStyleId,dblQuantity,intOrdComplete) VALUES('$srNo','$styleID','$dblQty','$orderComplete');";

		return $db->ExecuteQuery($sql);
  	
}
  
function saveSpecificationDetails($strStyleID,$strMatDetailID,$strUnit,$dblUnitPrice,$sngConPc,$sngWastage,$strPurchaseMode,$strOrdType,$strPlacement,$intRatioType,$dblReqQty,$dblTotalQty,$dblTotalValue,$dblCostPC,$dblfreight,$intOriginNo )
{
	global $db;
	// $strStyleID,$strMatDetailID,$strUnit,$dblUnitPrice,$sngConPc,$sngWastage,$strPurchaseMode,$strOrdType,$strPlacement,$intRatioType
	//$sql="INSERT INTO specificationdetails(intStyleId,strMatDetailID,strUnit,dblUnitPrice,sngConPc,sngWastage,strPurchaseMode,strOrdType,strPlacement,intRatioType)VALUES('".$intStyleId."','".$strMatDetailID."','".$strUnit."',".$dblUnitPrice.",".$sngConPc.",".$sngWastage.",'".$strPurchaseMode."','".$strOrdType."','".$strPlacement."',".$intRatioType.");";
	$sql= "INSERT INTO specificationdetails (intStyleId,strMatDetailID,strUnit,dblUnitPrice,sngConPc,sngWastage,strPurchaseMode,strOrdType,strPlacement,intRatioType,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblfreight,intOriginNo ) VALUES ('$strStyleID','$strMatDetailID','$strUnit',$dblUnitPrice,$sngConPc,$sngWastage,'$strPurchaseMode','$strOrdType','$strPlacement',$intRatioType,$dblReqQty,$dblTotalQty,$dblTotalValue,$dblCostPC,$dblfreight,$intOriginNo );";
	

	return $db->executeQuery($sql);

}
  

function saveHistoryOrder($orderNo,$styleID,$companyID,$description,$buyerID,$qty,$Coordinator,$status,$customerRefNo,$smv,$date,$smvRate,$fob,$finance,$userID,$approvedBy,$appRemarks,$AppDate,$exPercentage,$finPercntage,$approvalNo,$revisedReason,$revisedDate,$revisedBy,$confirmedPrice,$conPriceCurrency,$commission,$efficiencyLevel,$costPerMinute,$dateSentForApprovals,$sentForApprovalsTo,$deliverTo,$freightCharges,$ECSCharge,$labourCost,$buyingOfficeId,$divisionId,$seasonId,$RPTMark,$subContractQty,$subContractSMV,$subContractRate,$subTransportCost,$subCM,$lineNos,$profit,$uPCharges,$UPChargeDescription,$fabFinance,$trimFinance,$newCM,$newSMV,$firstApprovedBy,$FirstAppDate)
  {
  
  	global $db;
  	$sql="Insert into history_orders(strOrderNo,intStyleId,intCompanyID,strDescription,intBuyerID,intQty".
  	",intCoordinator,intStatus,strCustomerRefNo,reaSMV,dtmDate,reaSMVRate,reaFOB,reaFinance,intUserID".",intApprovedBy,strAppRemarks,dtmAppDate,reaExPercentage,reaFinPercntage,intApprovalNo".  	",strRevisedReason,strRevisedDate,intRevisedBy,reaConfirmedPrice,strConPriceCurrency,reaCommission".
  ",reaEfficiencyLevel,reaCostPerMinute,dtmDateSentForApprovals,intSentForApprovalsTo,strDeliverTo".  	",reaFreightCharges,reaECSCharge,reaLabourCost,intBuyingOfficeId,intDivisionId,intSeasonId,strRPTMark". ",intSubContractQty,reaSubContractSMV,reaSubContractRate,reaSubTransportCost,reaSubCM,intLineNos".
  	",reaProfit,reaUPCharges,strUPChargeDescription,reaFabFinance,reaTrimFinance,reaNewCM,reaNewSMV".
  	",intFirstApprovedBy,dtmFirstAppDate)values('".$orderNo."','".$styleID."',".$companyID.",'".$description."',".$buyerID.",".$qty.",'".$Coordinator."',".$status.",'".$customerRefNo."',".$smv.",'".$date."',".$smvRate.",".$fob.",".$finance.",'".$userID."','".$approvedBy."','".$appRemarks."',null,".$exPercentage.",".$finPercntage.",".$approvalNo.",'".$revisedReason."',null,'".$revisedBy."',".$confirmedPrice.",'".$conPriceCurrency."',".$commission.",".$efficiencyLevel.",".$costPerMinute.",null,'".$sentForApprovalsTo."','".$deliverTo."',".$freightCharges.",".$ECSCharge.",".$labourCost.",".$buyingOfficeId.",".$divisionId.",".$seasonId.",'".$RPTMark."',".$subContractQty.",".$subContractSMV.",".$subContractRate.",".$subTransportCost.",".$subCM.",".$lineNos.",0,".$uPCharges.",'".$UPChargeDescription."',".$fabFinance.",".$trimFinance.",0,0,0,null);";
	

		 
  	return $db->executeQuery($sql);
  	
  }
  
function saveHistoryOrderDetails($strOrderNo,$strStyleID,$intMatDetailID,$strUnit,$dblUnitPrice,$reaConPc,$reaWastage,$strCurrencyID,$intOriginNo,$dblReqQty,$dblTotalQty,$dblTotalValue,$dbltotalcostpc,$freight,$approvalNo)
{
	global $db;
	$sql="insert into history_orderdetails(strOrderNo,intStyleId,intMatDetailID,strUnit,dblUnitPrice,reaConPc,reaWastage,strCurrencyID,intOriginNo,dblReqQty,dblTotalQty,dblTotalValue,dbltotalcostpc,dblFreight,intApprovalNo) values ('".$strOrderNo."','".$strStyleID."',".$intMatDetailID.",'".$strUnit."',".$dblUnitPrice.",".$reaConPc.",".$reaWastage.",'".$strCurrencyID."',".$intOriginNo.",".$dblReqQty.",".$dblTotalQty.",".$dblTotalValue.",".$dbltotalcostpc.",'".$freight."','".$approvalNo."');";
	

	return $db->executeQuery($sql);
}

function saveHistoryDeliveryDetails($strStyleID)
{
	global $db;
	$sql="
insert into history_deliveryschedule 
	(intStyleId, 
	dtDateofDelivery, 
	dblQty, 
	dblBalQty, 
	dtPODate, 
	dtGRNDate, 
	strRemarks, 
	intComplete, 
	dtmPlanCutDate, 
	dtmactuCutDate, 
	dtmPlanFabDate, 
	strPPSampleStatus, 
	strTopSampleStatus, 
	intTrimCards, 
	intOffSet, 
	strShippingMode, 
	dbExQty, 
	intMsSql, 
	isDeliveryBase, 
	intSerialNO,
	estimateddate
	)
	
select * from deliveryschedule where intStyleId = '$strStyleID'";

	return	$db->executeQuery($sql);
}

function SaveHistoryVariations($strStyleID,$strMatDetailID,$intNo,$dblConPc,$dblUnitPrice,$dblWastage,$strColor,$strRemarks,$qty,$approvalNo)
{
	global $db;
	$sql="Insert into history_conpccalc(intStyleId,strMatDetailID,intNo,dblConPc,dblUnitPrice,dblWastage,strColor,strRemarks,intqty,intApprovalNo)values('".$strStyleID."','".$strMatDetailID."',".$intNo.",".$dblConPc.",".$dblUnitPrice.",".$dblWastage.",'".$strColor."','".$strRemarks."',".$qty.",".$approvalNo.");";
	

	return	$db->executeQuery($sql);
}

function getVariationData($MatDetailID,$styleID)
{
	global $db;
	$sql="SELECT intNo,strMatDetailID,dblConPc,dblUnitPrice,dblWastage,strColor,strRemarks,intqty FROM conpccalculation c where strMatDetailID='".$MatDetailID."' AND intStyleId= '" .$styleID . "';";
	return $db->RunQuery($sql);
}
// check whether revise preoder qty have changed than privious.
function IsQtyChanged($styleID,$newQty)
{
	global $db;
	$sql="SELECT dblQuantity FROM specification WHERE intStyleId='$styleID';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty=$row["dblQuantity"];
	}
	if($qty!=$newQty)
		return $qty;
	else
		return 0;

}

function modifyStyleRatio($styleID,$newQty)
{
	global $db;
	
	$prevQty=IsQtyChanged($styleID,$newQty);
	if($prevQty>0)
	{
		$sql="SELECT intStyleId,strBuyerPONO,strColor,strSize,dblQty FROM styleratio where intStyleId='$styleID';";
		$result=$db->RunQuery($sql);
		while($row=mysql_fetch_array($result))
		{
			$matQty=$row["dblQty"];
			$styleID=$row["intStyleId"];
			$buyerPO=$row["strBuyerPONO"];
			$strColor=$row["strColor"];
			$size=$row["strSize"];
			$newMatQty=$matQty/$prevQty*$newQty;
			$roundMatQty=round($newMatQty);
			$sql="UPDATE styleratio SET dblQty='$roundMatQty' WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPO' AND strColor='$strColor' AND strSize='$size'";

			$db->executeQuery($sql);
		}
	}
}

function modifyStyleExcesStyle($styleID,$newExcesPecen,$qty)
{
	global $db;
	
	$sql="SELECT intStyleId,strBuyerPONO,strColor,strSize,dblQty,dblExQty FROM styleratio where intStyleId='$styleID';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$matQty=$row["dblQty"];
		$styleID=$row["intStyleId"];
		$buyerPO=$row["strBuyerPONO"];
		$strColor=$row["strColor"];
		$size=$row["strSize"];
		$preExcesQty=$row["dblExQty"];
		$qtywithExc=$matQty+((float)$matQty*(float)$newExcesPecen/100);
		$roundExces=round($qtywithExc);
		if($roundExces!=$preExcesQty)
		{
			$sql="UPDATE styleratio SET dblExQty='$roundExces' WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPO' AND strColor='$strColor' AND strSize='$size'";

			$db->executeQuery($sql);
		}
	}
}

function modifyMatratio($styleID)
{
	global $db;
	//$sql="SELECT s.intStyleId,s.strPurchaseMode,m.strMatDetailID,m.strColor,m.strSize,m.dblQty,m.dblBalQty FROM specificationdetails s INNER JOIN materialratio m ON s.intStyleId=m.intStyleId WHERE s.intStyleId='$styleID' AND s.strPurchaseMode!='NONE' AND (m.strColor='N/A' OR m.strSize='N/A');";
	$sql = "SELECT s.intStyleId,s.strPurchaseMode,m.strMatDetailID,m.strColor,m.strSize,m.dblQty,m.dblBalQty,matitemlist.intMainCatID FROM specificationdetails s INNER JOIN materialratio m ON s.intStyleId=m.intStyleId inner join matitemlist on m.strMatDetailID = matitemlist.intItemSerial WHERE s.intStyleId='$styleID' AND s.strPurchaseMode!='NONE' AND (m.strColor='N/A' OR m.strSize='N/A')";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$styleID=$row["intStyleId"];
		$matDetaiID=$row["strMatDetailID"];
		$color=$row["strColor"];
		$size=$row["strSize"];
		$dblQty=$row["dblQty"];
		$balQty=$row["dblBalQty"];
		$mainCat = $row["intMainCatID"];
		//deleteMatRatio($styleID,$matDetaiID,$color,$size);
		insertToMatRatio($styleID,$matDetaiID,$color,$size,$dblQty,$balQty,$mainCat);
	}
}

function deleteMatRatio($styleID,$MatID,$Color,$size)
{
	global $db;
	$sql="DELETE materialratio WHERE intStyleId='$styleID' AND strMatDetailID='$MatID' AND strColor='$Color' AND strSize='$size'";

	$db->executeQuery($sql);
}

function insertToMatRatio($styleID,$MatID,$Color,$size,$qty,$balqty,$mainCat)
{
	$poQty=$qty-$balqty;
	global $db;
	$sql="select sngConPc,sngWastage FROM  specificationdetails WHERE intStyleId='$styleID' AND strMatDetailID='$MatID'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$conPc=$row["sngConPc"];
		$wastage=$row["sngWastage"];
	}
	$realConPc=(float)$conPc+((float)$conPc*(float)$wastage/100);
	$sql="SELECT reaExPercentage from orders where intStyleId='$styleID'";
	$resultEx=$db->RunQuery($sql);
	while($rowEx=mysql_fetch_array($resultEx))
	{
		$exPercent=$rowEx["reaExPercentage"];
	}
	$realQty=(float)$qty+((float)$qty*$exPercent/100);
	$matQty=round($realConPc*$realQty);
	$balaneQty=$matQty-$poQty;
	$sql="UPDATE materialratio SET dblQty='$matQty', dblBalQty='$balaneQty' WHERE intStyleId='$styleID' AND strMatDetailID='$MatID' AND strColor='$Color' AND strSize='$size'";

	$db->ExecuteQuery($sql);
}

function saveToHistoryStyleMat($styleID)
{
	
	global $db;
	
	$sql="INSERT INTO historystyleratio(intStyleId,strBuyerPONO,
	strColor,strSize,dblQty,dblExQty,strUserId) SELECT intStyleId,strBuyerPONO,
	strColor,strSize,dblQty,dblExQty,strUserId FROM styleratio where intStyleId='$styleID';";
	
	  $db->ExecuteQuery($sql);
		
			
	
}

 function getCharforID($id)
   {
   		$charVal = "";
		$pos = 0;		
		for ($loop = 'A' ;  $loop <= 'Z' ;  $loop ++)
		{
			if ($pos == $id)
			{
				$charVal .= $loop;
				break;
			}
			$pos ++;		
		}
		return $charVal;
   }




	$styleID=$_POST["StyleID"];
		
	if(startApprovalProcess($styleID))
	{
		echo "Style has been resolved successfully";		
	}
	else
	{
		echo "Style resolving process failed.";
	}
	 ?>
        </span></td>
      </tr>
      <tr>
        <td height="74">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td class="copyright" align="right">&nbsp;</td>
  </tr>
</table>
</body>
</html>
