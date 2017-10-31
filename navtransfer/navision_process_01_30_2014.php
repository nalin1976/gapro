<?php

include 'NavisionClass.php';


$class_Navision = new classNavision;

$rs_OrderList = $class_Navision->GetOrderListToTransfer();

$class_Navision->InsertOrders($rs_OrderList);

$rsOrderListToUpdate = $class_Navision->GetOrdersListToUpdateAsFinishGoods();

//echo mysql_num_rows($rsOrderListToUpdate);

while($row=mysql_fetch_array($rsOrderListToUpdate)){
	
	$_intStyleId = -1;
	
	$_strStyleId = '';
	$_strDivision = '';
	$_strDescription = '';
	$_strSeason = '';
	
	$_dblFOB = 0;
	$_dblSMV = 0;
	$_dblEFF = 0;
	$_dblOrderQty = 0;
	$_dblLabourCost = 0;
	$_dblESC = 0;
	$_dblFinanceCost = 0;
	$_dblBudgetCost = 0;
	$_dblEstimatedCost = 0;
	
	
	
	$_intOrderNo = $row['intJobNo'];
	
	//Get the order infomation from given SC number
	$rs_OrderDetails = $class_Navision->GetOrderDetails($_intOrderNo);
	
	
	
	while($row_OrderDetails = mysql_fetch_array($rs_OrderDetails)){
		
		
		
		$_intStyleId = $row_OrderDetails['intStyleId'];
		
		$_strStyleId = $row_OrderDetails['strStyle'];
		
		
		$_strDivision = $row_OrderDetails['strDivision'];
		$_strSeason = $row_OrderDetails['strSeason'];
		$_strDescription = $row_OrderDetails['strDescription'];
		
		$_dblFOB = $row_OrderDetails['reaFOB'];	
		$_dblSMV = (float)$row_OrderDetails['reaSMV'];	
		$_dblEFF = (float)$row_OrderDetails['reaEfficiencyLevel'];	
		$_dblOrderQty = (float)$row_OrderDetails['intQty'];	
		$_dblESC = (float)$row_OrderDetails['reaECSCharge'];	
		$_dblFinanceCost = (float)$row_OrderDetails['reaFinance'];	
		$_dblLabourCost = (float)$row_OrderDetails['reaLabourCost'];	
		
		$_dtOrderDate = $row_OrderDetails['dtmDate'];	
		$_strUser = $row_OrderDetails['Name'];	
		$_strBuyerName = $row_OrderDetails['strName'];
		
		//$_dblLabourCost = (($_dblSMV / $_dblEFF) * 100) * 0.035;
		
		$_dblCMPc = $_dblEFF * $_dblSMV ;
		
		$_dblCorporateCost = $_dblSMV * 0.0234;
		
		
		
		$_dblRawMatCost = $class_Navision->GetRawMaterialCost($_intStyleId);
		
		$_dblBudgetCost = $_dblRawMatCost / $_dblOrderQty;   
		$_dblBudgetCost += $_dblFinanceCost + $_dblESC ;  
		
		$_dblEstimatedCost = $_dblBudgetCost + $_dblLabourCost + $_dblCorporateCost;		
		
		// Check if job exist in the navision [Item Transfer]
		$_IsJobExist = $class_Navision->IsJobExist($_intOrderNo);
						
		$_dtLastDelDate = $class_Navision->GetLastDeliveryDate($_intStyleId);
		
		//Get the number of style parts in the style from GAPRO
		$_intNoStyleParts = $class_Navision->GetNoOfStyleParts($_intStyleId);
		
		$_dblEstimatedCost = $_dblEstimatedCost / $_intNoStyleParts;
		
		if($_IsJobExist){
			
			//If order exist in the Navision as a finish goods then update the details
			$res_success = $class_Navision->UpdateFinshGoods($_dblFOB, $_dblEstimatedCost, $_dblSMV, $_dblCMPc, $_dblLabourCost, $_intOrderNo, $_intNoStyleParts);			
			
		}else{
			
			$res_success = $class_Navision->InsertFinishGoods($_intOrderNo, $_strStyleId, $_strDivision, $_strSeason, $_dblFOB, 
									                          $_dblSMV, $_dblEstimatedCost, $_dblCMPc, $_dblLabourCost, $_strDescription, $_intNoStyleParts);             	
			
		}
		
		$_IsOrderExistAsJob = $class_Navision->IsOrderExistAsJob($_intOrderNo);
		
		if(!$_IsOrderExistAsJob){
			
			$res_success = $class_Navision->InsertJob($_intOrderNo, $_strDescription, $_dblOrderQty, $_dtOrderDate, $_strStyleId, $_dblBudgetCost, 
								                      $_strUser, $_dtLastDelDate, $_strBuyerName, $_dblEFF);
											  
											   
			 
			
		}				
		
		if($res_success == 1){
			
			$class_Navision->UpdateNavJobStatus($_intOrderNo);	
			
			echo "Process Complete <br />";
		}else{
			echo $res_success ."<br />";
			echo "Error in processing";	
		}
		
	}
	
} // End the Finish GOODSTRANSFER





/*if(sqlsrv_num_rows($res) == false){
	echo "No";	
}*/
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>