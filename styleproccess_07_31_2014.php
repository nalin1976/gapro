<link href="css/erpstyle.css" rel="stylesheet" type="text/css">
<title>Order Proccess</title><table width="965" border="0" align="center">
  <tr>
    <td width="752"><?php
     	include 'Header.php'; 
     ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="bcgl1">
      <tr>
        <td height="88">&nbsp;</td>
      </tr>
      <tr>
        <td height="57" bgcolor="#fbf8b3" class="normalfnth2Bm"><p><span  class="normalfnth2">
          <br />
<?php
include "Connector.php";


for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
    ob_implicit_flush(1);
	
echo "WAIT...<BR><BR>";
	$sql_main 		 = 	"SELECT intStyleId FROM orders where intStatus=20";
	$result_main 	 = 	$db->RunQuery($sql_main);
	$v= mysql_num_rows($result_main);
	
	while ($row_main = 	mysql_fetch_array($result_main))
	{
		
		
		$styleid_main = $row_main['intStyleId'];
		echo "$v ---  $styleid_main  <br><br>";
		
		startApprovalProcess($styleid_main);
		
		$sql_1="UPDATE orders SET intStatus=11 where intStyleId='".$styleid_main."';";
		$result_1=$db->ExecuteQuery($sql_1);
		
		//------hem---------------
/*$sql4="SELECT
orders.intQty
FROM orders
WHERE
orders.intStyleId =  '$styleid_main'";
					$res4= $db->RunQuery($sql4);
					$row4 = mysql_fetch_array($res4);
					$orderQty=$row4["intQty"];
		UpateMaterialRatioInPreorder($styleid_main,$orderQty);*/
		//------hem---------------
		$v--;
	}
echo "Proccess Completed.";
?>
</span>
</p>
</td>
</tr>
</table>



<?php 
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
		$intMatDetailID = $row["intMatDetailID"];

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
	
	//start 2011-01-10 delivery schedule report - show unwanted records
	//saveHistoryDeliveryDetails($styleID);
	//end 2011-01-10
	
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
		 // $sql="DELETE FROM specification WHERE intStyleId='$styleID';";
		 //-------------------------------------------UPDATE OLD SPECIFICATION EDIT BY BADRA 02.08.2013 -----------------------------------------------------// 
            $sql="UPDATE `specification` SET `dblQuantity`='$newOrderQty' , `intOrdComplete`='0'  WHERE (`intStyleId`='$styleID') AND (`intSRNO`='$srNo');";
		   $db->ExecuteQuery($sql); 
		   
		   // Save History Specification Details
		     $sql="INSERT INTO historyspecificationdetails(intStyleId,strMatDetailID,strUnit,dblUnitPrice,sngConPc,
		sngWastage,strPurchaseMode,strOrdType,strPlacement,intRatioType,dblReqQty,dblTotalQty,
		dblTotalValue,dblCostPC,dblfreight,intOriginNo) SELECT intStyleId, strMatDetailID,
		 strUnit,dblUnitPrice,sngConPc,sngWastage,strPurchaseMode,strOrdType,strPlacement,
		 intRatioType,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblfreight,intOriginNo FROM specificationdetails where intStyleId='$styleID';";

		  $db->ExecuteQuery($sql); 
		  
		   $sql1="SELECT * FROM orderdetails o where intStyleId='".$styleID."' ;";
	$result1=$db->RunQuery($sql1);
	while($row1=mysql_fetch_array($result1))
	{
		//$newOrderQty = $row1["intQty"];
		//$newExpercentage = $row1["reaExPercentage"];
		$intMatDetailID = $row1["intMatDetailID"];
		$strUnit = $row1["strUnit"];
		$dblUnitPrice = $row1["dblUnitPrice"];
		$reaConPc = $row1["reaConPc"];
		$reaWastage = $row1["reaWastage"];
		$dblReqQty = $row1["dblReqQty"];
		$dblTotalQty = $row1["dblTotalQty"];
		$dblTotalValue = $row1["dblTotalValue"];
		$dbltotalcostpc = $row1["dbltotalcostpc"];
		$intOriginNo = $row1["intOriginNo"];
		$dblFreight = $row1["dblFreight"];
		$intstatus = $row1["intstatus"];
		if($intstatus == "" || $intstatus == '1' )
		{
			$status = 1;
		}
		else
		{
			$status = 0;
		}

	
		 
		  
		  // Delete Specification Details
		  //-------------------------------------------UPDATE OLD SPECIFICATION DETAILS EDIT BY BADRA 02.08.2013 -----------------------------------------------------// 
		//  $sql="DELETE FROM specificationdetails WHERE intStyleId='".$styleID."';";
		 $sql2 	 = "SELECT *
FROM `specificationdetails`
WHERE
specificationdetails.intStyleId = '$styleID' AND
specificationdetails.strMatDetailID = '$intMatDetailID' "; 
				$result2 = $db->RunQuery($sql2);
				
				if(mysql_num_rows($result2))
				{
					$sql="UPDATE `specificationdetails` SET `strUnit`='$strUnit', `dblUnitPrice`='$dblUnitPrice', `strOrdType`='', `sngConPc`='$reaConPc', 
		`sngWastage`='$reaWastage', `dblReqQty`='$dblReqQty', `dblTotalQty`='$dblTotalQty', `dblTotalValue`='$dblTotalValue',
		 `dblCostPC`='$dbltotalcostpc', `intOriginNo`='$intOriginNo' ,`intMillId` = '0' , `intMainFabricStatus` = '0' , `dblfreight` = '$dblFreight' , 
		  `strPurchaseMode` = 'NONE' , `strPlacement` = '' , `intRatioType` = '0', `intStatus` = '$status'  
		   WHERE (`intStyleId`='$styleID') AND (`strMatDetailID`='$intMatDetailID');";
 
		  $db->ExecuteQuery($sql);
				}
				else
				{
					$sql2= "INSERT INTO specificationdetails (intStyleId,strMatDetailID,strUnit,dblUnitPrice,sngConPc,sngWastage,strPurchaseMode,strOrdType,
					strPlacement,intRatioType,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblfreight,intOriginNo,intMillId,intMainFabricStatus,intStatus) VALUES 
					('$styleID','$intMatDetailID','$strUnit',$dblUnitPrice,$reaConPc,$reaWastage,'NONE','','','0',
					$dblReqQty,$dblTotalQty,$dblTotalValue,$dbltotalcostpc,$dblFreight,$intOriginNo,0,0,1);";
					$db->executeQuery($sql2);
				}
		  }
	  }
	  else
	  {
	  $newSCNO = $srNo;
	
	// Save Specification
	#============================================================================================
	# Comment On - 01/10/2014
	# Description - Remove manually inserting SC number to the system
	#============================================================================================
	
		//$sql="INSERT INTO specification(intSRNO,intStyleId,dblQuantity,intOrdComplete) VALUES('$srNo','$styleID','$newOrderQty','0');";
	
	#============================================================================================
	
	$sql="INSERT INTO specification(intStyleId,dblQuantity,intOrdComplete) VALUES('$styleID','$newOrderQty','0');";

	$db->ExecuteQuery($sql);
		
	//Save Specification Details
	$sql="SELECT * FROM orderdetails o where intStyleId='".$styleID."';";
	$resultItems=$db->RunQuery($sql);
	while($rowItems=mysql_fetch_array($resultItems))
	{
		$intMatDetailID = $rowItems["intMatDetailID"];
		$strUnit = $rowItems["strUnit"];
		$dblUnitPrice = $rowItems["dblUnitPrice"];
		$reaConPc = $rowItems["reaConPc"];
		$reaWastage = $rowItems["reaWastage"];
		$dblReqQty = $rowItems["dblReqQty"];
		$dblTotalQty = $rowItems["dblTotalQty"];
		$dblTotalValue = $rowItems["dblTotalValue"];
		$dbltotalcostpc = $rowItems["dbltotalcostpc"];
		$intOriginNo = $rowItems["intOriginNo"];
		$dblFreight = $rowItems["dblFreight"];
		$intstatus = $rowItems["intstatus"];
		if($intstatus == "" || $intstatus == '1' )
		{
			$status = 1;
		}
		else
		{
			$status = 0;
		}

		echo $sql2= "INSERT INTO specificationdetails (intStyleId,strMatDetailID,strUnit,dblUnitPrice,sngConPc,sngWastage,strPurchaseMode,strOrdType,
					strPlacement,intRatioType,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblfreight,intOriginNo,intMillId,intMainFabricStatus,intStatus) VALUES 
					('$styleID','$intMatDetailID','$strUnit',$dblUnitPrice,$reaConPc,$reaWastage,'NONE','','','0',
					$dblReqQty,$dblTotalQty,$dblTotalValue,$dbltotalcostpc,$dblFreight,$intOriginNo,0,0,$status);";
					$db->executeQuery($sql2);
	}
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
	
	$sql = "insert into historymaterialratio (intStyleId, strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID,dblRecutQty)  select  intStyleId, 	strMatDetailID, strColor, strSize, strBuyerPONO, dblQty, dblBalQty, dblFreightBalQty, materialRatioID,dblRecutQty from materialratio where intStyleId = '$styleID'; ";
	$db->ExecuteQuery($sql);
	
	// Remove material ratios which are not applicable for the current style materials
	//$sql = "delete from materialratio where intStyleId = '$styleID' AND strMatDetailID not in (select strMatDetailID from specificationdetails where intStyleId = '$styleID') ; ";

	//$db->ExecuteQuery($sql);
	
	
	// Delete material ratios for color - N/A , size N/A
	//$sql = "delete from materialratio where intStyleId = '$styleID'  AND strColor = 'N/A' AND strSize = 'N/A'; ";

	//$db->ExecuteQuery($sql);
	
	

	
	 $sql = "select intStyleId,strMatDetailID,strUnit,dblUnitPrice,sngConPc,sngWastage,strPurchaseMode,strOrdType,strPlacement,intRatioType,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblfreight,intOriginNo from specificationdetails where intStyleId = '$styleID' ;";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$styleNo =  $row["intStyleId"];			
		$item =  $row["strMatDetailID"];
		$freightCharge = $row["dblfreight"];
		$confirmRecutQty = getConfirmRecutQty($styleID,$item);
		
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
				
				$sqlratio = "select strColor,strSize,strBuyerPONO,sum(dblQty)AS matQty from materialratio where intStyleId = '$styleNo'  AND (strColor <> 'N/A' or strSize <> 'N/A')  AND strMatDetailID = '$item' AND strBuyerPONO = '$buyerPONo' group by strColor,strSize,strBuyerPONO;";
								
				$charpos = 0;
				$previousColor = "";
				$ismateriralratio = false;
				//
				$sqlapprove="select Sum(dblQty)AS matTotal from materialratio where intStyleId='$styleNo' and strMatDetailID='$item' and strBuyerPONO='$buyerPONo' and  (intStatus != '0' or intStatus IS NULL);";
				$resultapprove=$db->RunQuery($sqlapprove);
				$rowapprove=mysql_fetch_array($resultapprove);				
				$matTotal=$rowapprove["matTotal"];				
				//
				$resultratio=$db->RunQuery($sqlratio);
				while($rowratio=mysql_fetch_array($resultratio))
				{				
					$ismateriralratio = true;
					
					$color = $rowratio["strColor"];
					$size =  $rowratio["strSize"];
					//$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $poQty +( $row["sngConPc"] *($newExpercentage * $poQty / 100));
					//$qty = CalculateQty($qty);
					$qty = $row["dblTotalQty"];
					$qty=(($rowratio["matQty"]/$matTotal)*$qty);
					
					//get recut qty
					$recutQty=round((($rowratio["matQty"]/$matTotal)*$confirmRecutQty));
					if($recutQty>0)
						$recutQty =($recutQty<1?1:$recutQty);
					//end recut Qty
					
					$purchasedQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 0);
					$purchasedFreightQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 1);
					//Start 30-10-2010
					$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$buyerPONo,$item,$color,$size);
					$leftAlloQty = confirmLeftOverQty($styleNo,$buyerPONo,$item,$color,$size);
					//Start 30-10-2010
					
					//2012-01-17 get confirmed liability qty
					$liabilityQty = confirmLiabilityQty($styleNo,$buyerPONo,$item,$color,$size);
					//2012-01-17 get confirmed liability qty
					
					$balQty =  $qty +$recutQty - $purchasedQty - $bulkAlloQty - $leftAlloQty-$liabilityQty;
					$dblFreightBal =  $qty  - $purchasedFreightQty; 
					if ($freightCharge  <= 0)
						$dblFreightBal = 0;
						
					SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,getCharforID($charpos),$recutQty);					
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
					//$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $poQty +( $row["sngConPc"] *($newExpercentage * $poQty / 100));
					//$qty = CalculateQty($qty);
					$qty = $row["dblTotalQty"];
					$purchasedQty 			=  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 0);
					$purchasedFreightQty 	=  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 1);
					//Start 30-10-2010
					$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$buyerPONo,$item,$color,$size);
					$leftAlloQty = confirmLeftOverQty($styleNo,$buyerPONo,$item,$color,$size);
					//Start 30-10-2010
					
					//2012-01-17 get confirmed liability qty
					$liabilityQty = confirmLiabilityQty($styleNo,$buyerPONo,$item,$color,$size);
					//2012-01-17 get confirmed liability qty
					
					//get recut qty
					$recutQty = round($confirmRecutQty);
					if($recutQty>0)
						$recutQty =($recutQty<1?1:$recutQty);
					
					$balQty =  $qty + $recutQty - $purchasedQty - $bulkAlloQty - $leftAlloQty-$liabilityQty;
					$dblFreightBal =  $qty - $purchasedFreightQty; 
					if ($freightCharge  <= 0)
						$dblFreightBal = 0;
					
					SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,getCharforID($charpos),$recutQty);
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
		
			// Delete material ratios for color - N/A , size N/A
			//$sql = "delete from materialratio where intStyleId = '$styleID'  AND strMatDetailID = '$item'; ";
		  // $db->ExecuteQuery($sql);
	
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
				
				$sqlratio = "select strColor, sum(dblQty) as colorqty from styleratio where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' and (intStatus != '0' or intStatus IS NULL); group by strColor ;";
				$resultratio=$db->RunQuery($sqlratio);
				$charpos = 0;
				$previousColor = "";
				while($rowratio=mysql_fetch_array($resultratio))
				{
					$color = $rowratio["strColor"];
					$size =  "N/A";
					//$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $rowratio["colorqty"];	
					$qty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $rowratio["colorqty"] +( $row["sngConPc"] *($newExpercentage * $rowratio["colorqty"]/ 100));	
					
					//get recut qty
					$colorQty = $rowratio["colorqty"]/$currentOrderQty*$confirmRecutQty;
					$recutQty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $colorQty +( $row["sngConPc"] *($newExpercentage * $colorQty/ 100));
					if($recutQty>0)
						$recutQty =($recutQty<1?1:round($recutQty));
					
					//end get recut qty 
					
					$purchasedQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 0);
					$purchasedFreightQty =  getPurchasedQty($styleNo,$item,$buyerPONo,$color, $size, 1);
					
					//Start 30-10-2010
					$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$buyerPONo,$item,$color,$size);
					$leftAlloQty = confirmLeftOverQty($styleNo,$buyerPONo,$item,$color,$size);
					//Start 30-10-2010
					
					//2012-01-17 get confirmed liability qty
					$liabilityQty = confirmLiabilityQty($styleNo,$buyerPONo,$item,$color,$size);
					//2012-01-17 get confirmed liability qty
					
					$balQty =  $qty+$recutQty - $purchasedQty - $bulkAlloQty - $leftAlloQty-$liabilityQty;
					$dblFreightBal =  $qty  - $purchasedFreightQty; 
					if ($freightCharge  <= 0)
						$dblFreightBal = 0;
					SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,getCharforID($charpos),$recutQty);
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
			//$sql = "delete from materialratio where intStyleId = '$styleID'  AND strMatDetailID = '$item'; ";
		   //$db->ExecuteQuery($sql);
		   
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
				
				$sqlratio = "select strSize, sum(dblQty) as sizeqty from styleratio where intStyleId = '$styleNo' and strBuyerPONO = '$buyerPONo' group by strSize;";
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
					
					//Start 30-10-2010
					$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$buyerPONo,$item,$color,$size);
					$leftAlloQty = confirmLeftOverQty($styleNo,$buyerPONo,$item,$color,$size);
					//Start 30-10-2010
					
					//2012-01-17 get confirmed liability qty
					$liabilityQty = confirmLiabilityQty($styleNo,$buyerPONo,$item,$color,$size);
					//2012-01-17 get confirmed liability qty
					
					//get recut qty 
					$sizeQty = $rowratio["sizeqty"]/$currentOrderQty*$confirmRecutQty;	
					$recutQty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $sizeQty+( $row["sngConPc"] *($newExpercentage *$sizeQty / 100));	
					if($recutQty>0)
						$recutQty =($recutQty<1?1:round($recutQty));
					//end get recut qty 
					
					$balQty =  $qty + $recutQty - $purchasedQty - $bulkAlloQty - $leftAlloQty-$liabilityQty;
					$dblFreightBal =  $qty  - $purchasedFreightQty; 
					if ($freightCharge  <= 0)
						$dblFreightBal = 0;
					SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,getCharforID($charpos),$recutQty);
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
			//$sql = "delete from materialratio where intStyleId = '$styleID'  AND strMatDetailID = '$item'; ";
		   //$db->ExecuteQuery($sql);
		   
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
					
					//Start 30-10-2010
					$bulkAlloQty = confirmgetBulkAlloQty($styleNo,$buyerPONo,$item,$color,$size);
					$leftAlloQty = confirmLeftOverQty($styleNo,$buyerPONo,$item,$color,$size);
					//Start 30-10-2010
					
					//2012-01-17 get confirmed liability qty
					$liabilityQty = confirmLiabilityQty($styleNo,$buyerPONo,$item,$color,$size);
					//2012-01-17 get confirmed liability qty
					
					//get recut qty
					$ratioQty = $rowratio["dblQty"]/$currentOrderQty*$confirmRecutQty;
					$recutQty =  ($row["sngConPc"] + ($row["sngConPc"] * $row["sngWastage"] / 100)) * $ratioQty+( $row["sngConPc"] *($newExpercentage *$ratioQty / 100));	
					if($recutQty>0)
						$recutQty =($recutQty<1?1:round($recutQty));
					//end get recut qty
					$balQty =  $qty +$recutQty - $purchasedQty - $bulkAlloQty - $leftAlloQty-$liabilityQty;
					$dblFreightBal =  $qty  - $purchasedFreightQty; 
					if ($freightCharge  <= 0)
						$dblFreightBal = 0;
					SaveMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,getCharforID($charpos),$recutQty);
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
(SELECT strMatDetailID FROM specificationdetails WHERE  intStyleId = '$styleID' );";
	$db->ExecuteQuery($sql);
	
	 $contrastStyle = $styleID;
	include 'contrastprocess2.php';
	
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
	$balQty = round($balQty);
	$recutQty = round($recutQty);
	$sql="SELECT intSRNO FROM specification WHERE intStyleId='$styleNo';";
	
		  $result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{
				 
				$srNo=$row["intSRNO"];
			}
	$sql = "select intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO from materialratio where intStyleId = '$styleNo' and  strMatDetailID = '$item' and strColor = '$color' and strSize = '$size' and strBuyerPONO = '$buyerPONo';";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$sql = "update materialratio set dblQty = $qty, dblBalQty = $balQty, dblFreightBalQty = $dblFreightBal, dblRecutQty='$recutQty' where intStyleId = '$styleNo' and  strMatDetailID = '$item' and strColor = '$color' and strSize = '$size' and strBuyerPONO = '$buyerPONo'; ";

		$db->executeQuery($sql); 
		return true;
	}
	
	$matRatioID = $srNo . "-" . $item . "" . $charPos;
	//$buyerPONo = str_replace("Main Ratio","#Main Ratio#",$buyerPONo);
	$sql="insert into materialratio (intStyleId,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,dblFreightBalQty,materialRatioID,dblRecutQty) values ('$styleNo','$item','$color','$size','$buyerPONo',$qty,$balQty,$dblFreightBal,'$matRatioID',$recutQty);";

	$db->executeQuery($sql);
	return true;
}

function updateMaterialRatio($styleNo,$buyerPONo,$item,$color,$size,$qty,$balQty,$dblFreightBal,$charPos)
{
	global $db;
	global $newSCNO;
	$qty = round($qty);
	$balQty = round($balQty);
	$sql="SELECT intSRNO FROM specification WHERE intStyleId='$styleNo';";
	
		  $result=$db->RunQuery($sql);
			while($row=mysql_fetch_array($result))
			{
				 
				$srNo=$row["intSRNO"];
			}
	$sql = "select strStyleID,strMatDetailID,strColor,strSize,strBuyerPONO from materialratio where strStyleID = '$styleNo' and  strMatDetailID = '$item' and strColor = '$color' and strSize = '$size' and strBuyerPONO = '$buyerPONo';";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$sql = "update materialratio set  intStatus='1', dblQty = $qty, dblBalQty = $balQty, dblFreightBalQty = $dblFreightBal where strStyleID = '$styleNo' and  strMatDetailID = '$item' and strColor = '$color' and strSize = '$size' and strBuyerPONO = '$buyerPONo';";

		$db->executeQuery($sql); 
		return true;
	}
	
	$matRatioID = $srNo . "-" . $item . "" . $charPos;
	//$buyerPONo = str_replace("Main Ratio","#Main Ratio#",$buyerPONo);
	
	//$sql="insert into materialratio (strStyleID,strMatDetailID,strColor,strSize,strBuyerPONO,dblQty,dblBalQty,dblFreightBalQty,materialRatioID) values ('$styleNo','$item','$color','$size','$buyerPONo',$qty,$balQty,$dblFreightBal,'$matRatioID');";
		$sql = "update materialratio set materialRatioID = $matRatioID, intStatus='1'  where strStyleID = '$styleNo' and  strMatDetailID = '$item' and strColor = '$color' and strSize = '$size' and strBuyerPONO = '$buyerPONo';";

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
  
/*function saveSpecificationDetails($styleID,$intMatDetailID,$strUnit,$dblUnitPrice,$reaConPc,$reaWastage,"NONE","","",0,$dblReqQty,$dblTotalQty,$dblTotalValue,$dbltotalcostpc,$dblFreight,$intOriginNo,0,0,$status)
{
	if($intstatus == "" || $intstatus == '1' )
		{
			echo $status = 1;
		}
		else
		{
			echo $status = 0;
		}
global $db;
	echo $sql= "INSERT INTO specificationdetails (intStyleId,strMatDetailID,strUnit,dblUnitPrice,sngConPc,sngWastage,strPurchaseMode,strOrdType,strPlacement,intRatioType,dblReqQty,dblTotalQty,dblTotalValue,dblCostPC,dblfreight,intOriginNo,intMillId,intMainFabricStatus,intStatus) VALUES ('$strStyleID','$strMatDetailID','$strUnit',$dblUnitPrice,$sngConPc,$sngWastage,'$strPurchaseMode','$strOrdType','$strPlacement',$intRatioType,$dblReqQty,$dblTotalQty,$dblTotalValue,$dblCostPC,$dblfreight,$intOriginNo,0,0,$status);";
	return $db->executeQuery($sql);
}*/
  

function saveHistoryOrder($orderNo,$styleID,$companyID,$description,$buyerID,$qty,$Coordinator,$status,$customerRefNo,$smv,$date,$smvRate,$fob,$finance,$userID,$approvedBy,$appRemarks,$AppDate,$exPercentage,$finPercntage,$approvalNo,$revisedReason,$revisedDate,$revisedBy,$confirmedPrice,$conPriceCurrency,$commission,$efficiencyLevel,$costPerMinute,$dateSentForApprovals,$sentForApprovalsTo,$deliverTo,$freightCharges,$ECSCharge,$labourCost,$buyingOfficeId,$divisionId,$seasonId,$RPTMark,$subContractQty,$subContractSMV,$subContractRate,$subTransportCost,$subCM,$lineNos,$profit,$uPCharges,$UPChargeDescription,$fabFinance,$trimFinance,$newCM,$newSMV,$firstApprovedBy,$FirstAppDate)
  {
  
  	global $db;
  	$sql="Insert into history_orders(strOrderNo,intStyleId,intCompanyID,strDescription,intBuyerID,intQty".
  	",intCoordinator,intStatus,strCustomerRefNo,reaSMV,dtmDate,reaSMVRate,reaFOB,reaFinance,intUserID".",intApprovedBy,strAppRemarks,dtmAppDate,reaExPercentage,reaFinPercntage,intApprovalNo".  	",strRevisedReason,strRevisedDate,intRevisedBy,reaConfirmedPrice,strConPriceCurrency,reaCommission".
  ",reaEfficiencyLevel,reaCostPerMinute,dtmDateSentForApprovals,intSentForApprovalsTo,strDeliverTo".  	",reaFreightCharges,reaECSCharge,reaLabourCost,intBuyingOfficeId,intDivisionId,intSeasonId,strRPTMark". ",intSubContractQty,reaSubContractSMV,reaSubContractRate,reaSubTransportCost,reaSubCM,intLineNos".
  	",reaProfit,reaUPCharges,strUPChargeDescription,reaFabFinance,reaTrimFinance,reaNewCM,reaNewSMV".
  	",intFirstApprovedBy,dtmFirstAppDate)values('".$orderNo."','".$styleID."',".$companyID.",'".$description."',".$buyerID.",".$qty.",'".$Coordinator."',".$status.",'".$customerRefNo."',".$smv.",'".$date."',".$smvRate.",".$fob.",".$finance.",'".$userID."','".$approvedBy."','".$appRemarks."',null,".$exPercentage.",".$finPercntage.",".$approvalNo.",'".$revisedReason."',null,'".$revisedBy."',".$confirmedPrice.",'".$conPriceCurrency."',".$commission.",".$efficiencyLevel.",".$costPerMinute.",null,'".$sentForApprovalsTo."','".$deliverTo."',".$freightCharges.",".$ECSCharge.",".$labourCost.",".$buyingOfficeId.",".$divisionId.",".$seasonId.",'".$RPTMark."',".$subContractQty.",".$subContractSMV.",".$subContractRate.",".$subTransportCost.",".$subCM.",".$lineNos.",0,".$uPCharges.",'".$UPChargeDescription."',".$fabFinance.",".$trimFinance.",0,0,'".$firstApprovedBy."','".$FirstAppDate."');";
	

		 
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
	(intDeliveryId,
	intStyleId, 
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
	estimateddate,
	intUserId,
	dtmDate
	)
	
select * from deliveryschedule where intStyleId = '$strStyleID';";

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
			$sql="UPDATE styleratio SET dblQty='$roundMatQty' WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPO' AND strColor='$strColor' AND strSize='$size';";

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
			$sql="UPDATE styleratio SET dblExQty='$roundExces' WHERE intStyleId='$styleID' AND strBuyerPONO='$buyerPO' AND strColor='$strColor' AND strSize='$size';";

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
	$sql="DELETE materialratio WHERE intStyleId='$styleID' AND strMatDetailID='$MatID' AND strColor='$Color' AND strSize='$size';";

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
	$sql="UPDATE materialratio SET dblQty='$matQty', dblBalQty='$balaneQty' WHERE intStyleId='$styleID' AND strMatDetailID='$MatID' AND strColor='$Color' AND strSize='$size';";

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
 function GetStyleName($styleId)
{
	global $db;
	$sql="select strStyle from orders where intStyleId='$styleId'";	
	$result=$db->RunQuery($sql);
	$row= mysql_fetch_array($result);
	return $row["strStyle"];	
}
function CalculateQty($qty)
{
	if($qty<1)
		$qty = ceil($qty);
	else
		$qty = round($qty);
	
	return $qty;
}  
function getItemPurchasedQty($styleNo,$itemCode,$buyerPO,$color, $size, $Type)
{
	global $db;	

	$sql = "select sum(dblQty) as purchasedQty from purchaseorderdetails,purchaseorderheader where purchaseorderdetails.strStyleID = '$styleNo' AND purchaseorderdetails.intMatDetailID = $itemCode AND purchaseorderdetails.strBuyerPONO = '$buyerPO' AND purchaseorderdetails.strColor = '$color' AND purchaseorderdetails.strSize = '$size' AND purchaseorderdetails.intPOType = $Type  AND purchaseorderheader.intPONo = purchaseorderdetails.intPONo AND  purchaseorderheader.intStatus = 10 AND intPOType=$Type";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		if ($row["purchasedQty"] == "" || $row["purchasedQty"]  == NULL)
			return 0;
		else
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
function confirmLiabilityQty($styleID,$buyerPO,$matId,$color,$size)
{

global $db;
	$sqlLB = "SELECT COALESCE(sum(LCD.dblQty),0) as liabilityQty
						FROM commonstock_liabilitydetails LCD INNER JOIN commonstock_liabilityheader LCH ON
						LCH.intTransferNo = LCD.intTransferNo AND 
						LCH.intTransferYear = LCD.intTransferYear
						WHERE LCH.intToStyleId = '$styleID'  and LCH.strToBuyerPoNo= '$buyerPO' 
						and LCD.strColor = '$color' and LCD.strSize='$size' and 
						LCD.intMatDetailId = '$matId' and LCH.intStatus=1 ";	
						
			$resultLB = $db->RunQuery($sqlLB);	
			$rowLB = mysql_fetch_array($resultLB);
			$LBAlloqty = $rowLB["liabilityQty"];
			
				
		return $LBAlloqty;
}
function getConfirmRecutQty($styleID,$item)
{
	global $db;
	$sql = "select COALESCE(sum(odr.dblTotalQty),0) as confirmQty 
	from orders_recut orc inner join orderdetails_recut odr on 
orc.intRecutNo = odr.intRecutNo and orc.intRecutYear= odr.intRecutYear 
where orc.intStatus=3 and orc.intStyleId='$styleID' and odr.intMatDetailID='$item' ";
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["confirmQty"];
}
//-----------hem--------------------------
//function UpateMaterialRatioInPreorder($styleid_main,$orderQty){
//	
//	$StyleName = $styleid_main;
//	$newTotQty=$orderQty;
//	
//	 $SQL="SELECT sum(dblQty) as existingTotQty, strMatDetailID FROM materialratio WHERE materialratio.strStyleID =  '$StyleName' and materialratio.strBuyerPONO =  '#Main Ratio#' and intStatus='1' group by strBuyerPONO, strMatDetailID ";
//	global $db;
//	
//	$result=$db->RunQuery($SQL);
//	while($row1=mysql_fetch_array($result))
//	{
//		 $existingTotQty = $row1["existingTotQty"];
//		 $matID =  $row1["strMatDetailID"];
//		 //-----------------------------------------
//			$sqlW = "SELECT reaWastage,dblReqQty,dblTotalQty FROM orderdetails WHERE strStyleID = '$StyleName' AND intMatDetailID = '$matID'";
//			$resultW = $db->RunQuery($sqlW);
//			$rowW=mysql_fetch_array($resultW);
//			$wastage=$rowW["reaWastage"];
//		 //-----get wastage from order details------	
//		// $newQty=round($newTotQty+$newTotQty*$wastage/100);
//		$newQty=$rowW["dblTotalQty"];
//		 
///*			if($existingTotQty != $newQty)	
//
//			{
//*/			$sql2 = "SELECT strColor,strSize FROM materialratio WHERE strStyleID = '$StyleName' and materialratio.strBuyerPONO =  '#Main Ratio#' AND strMatDetailID = '$matID' and intStatus='1'";
//				 $result2 = $db->RunQuery($sql2);
//				while($row=mysql_fetch_array($result2)){
//					$color=$row["strColor"];
//					$size=$row["strSize"];
//					
//					 $sql4="select COALESCE(Sum(purchaseorderdetails.dblQty),0) as purchasedQty from purchaseorderdetails inner join purchaseorderheader on purchaseorderheader.intPONo = purchaseorderdetails.intPONo AND purchaseorderheader.intYear = purchaseorderdetails.intYear where strStyleID = '$StyleName' AND purchaseorderdetails.intMatDetailID = '$matID' AND purchaseorderdetails.intPOType=0 AND strColor = '$color' AND strSize = '$size' and purchaseorderdetails.strBuyerPONO =  '#Main Ratio#' and purchaseorderheader.intStatus = 10;";
//					$res4= $db->RunQuery($sql4);
//					$row4 = mysql_fetch_array($res4);
//					$poNonFreight=$row4["purchasedQty"];
//					if($poNonFreight==''){
//						$poNonFreight=0;
//					}
//		
//		//$buyerPO='#Main Ratio#';
//		//$poNonFreight=getPurchasedQty($StyleName,$matID,$buyerPO,$color, $size, 0);	
//		//$poFreight=getPurchasedQty($StyleName,$matID,$buyerPO,$color, $size, 1);
//	//	$balQty=round(($dblQty / $existingTotQty )* $newQty,2)-round($poNonFreight,2);
//		
//					 $sql3 = "UPDATE materialratio SET dblQty = ((dblQty / $existingTotQty )* $newQty) WHERE  strStyleID = '$StyleName'  and materialratio.strBuyerPONO =  '#Main Ratio#' AND strMatDetailID = '$matID' AND strColor = '$color' AND strSize = '$size'";
//					$db->ExecuteQuery($sql3);
//					
//					 $sql4 = "UPDATE materialratio SET dblBalQty = dblQty - ".round($poNonFreight,2) ." WHERE  strStyleID = '$StyleName'  and materialratio.strBuyerPONO =  '#Main Ratio#' AND strMatDetailID = '$matID' AND strColor = '$color' AND strSize = '$size'";
//					$db->ExecuteQuery($sql4);
//				 }
///*			}
//*/		
//	}
//
//	
//}
?>