<?php
session_start();
//include "../Connector.php";
include "mysqlconnect.php";
include "msssqlconnect.php";

$classMSSQLConnect = new ClassConnectMSSQL;
$db = new ClassConnectMYSQL;

class classNavision{
		
	#============================================================================================
	# Description - Based on the maximum order number in the nav_jobs table, get the order 
	#               numbers list(SC#) from specification table afterwards.	
	#============================================================================================
	function GetOrderListToTransfer(){
		
		global $db;	
		
		$strSQL = " SELECT specification.intSRNO FROM specification WHERE specification.intSRNO > (SELECT Max(nav_jobs.intJobNo) FROM nav_jobs) ".
		          " ORDER BY specification.intSRNO " ;
		
		$result = $db->RunQuery($strSQL);
		
		return $result;
	}	
	#============================================================================================
	
	#============================================================================================
	# Description - Insert orders list to the nav_jobs table
	#               	
	#============================================================================================
	function InsertOrders($prmOrderList){
		
		global $db;
		
		while($row=mysql_fetch_array($prmOrderList)){
			
			$_intOrderNo = 	$row['intSRNO'];
			
			$strSQL = " INSERT INTO nav_jobs(intJobNo, intStatus) VALUES('$_intOrderNo','1')";
			
			$db->RunQuery($strSQL);
			
		}
	}
	#============================================================================================
	
	#============================================================================================
	# Description - Get the orders which are status in 0 to transfer or update the Navision to as
	#               FINISH GOOD GARMENTS	
	#============================================================================================
	function GetOrdersListToUpdateAsFinishGoods(){
		
		global $db;
		
		$SQL = " SELECT * FROM nav_jobs WHERE intStatus = 0 ORDER BY intJobNo ";
		
		$result = $db->RunQuery($SQL);
		
		return $result;
		
	}
	#============================================================================================
	
	
	#============================================================================================
	# Description - Get the order details from GAPRO for each given order
	#               	
	#============================================================================================
	function GetOrderDetails($prmJobNo){
		
		global $db;
		
		/*$strSql = " SELECT orders.intStyleId, specification.intSRNO, orders.strStyle, buyerdivisions.strDivision, seasons.strSeason, orders.reaFOB, ".
				  "	       orders.reaSMV, orders.strDescription, orders.reaEfficiencyLevel, orders.reaECSCharge, orders.intQty, orders.reaFinance, ".
				  "        orders.reaECSCharge, orders.reaLabourCost, orders.dtmDate ". 
                  " FROM   specification Inner Join orders ON specification.intStyleId = orders.intStyleId Left Outer Join buyerdivisions ON ".
				  "        orders.intDivisionId = buyerdivisions.intDivisionId Left Outer Join seasons ON orders.intSeasonId = seasons.intSeasonId ".
				  " WHERE  specification.intSRNO = '$prmJobNo'";*/
				  
		$strSql = " SELECT orders.intStyleId, specification.intSRNO, orders.strStyle, buyerdivisions.strDivision, seasons.strSeason, orders.reaFOB, ".
				  "	       orders.reaSMV, orders.strDescription, orders.reaEfficiencyLevel, orders.reaECSCharge, orders.intQty, orders.reaFinance, ".
				  "        orders.reaECSCharge, orders.reaLabourCost, DATE_FORMAT(orders.dtmDate, '%m/%d/%Y') AS dtmDate, useraccounts.Name, " .
				  "        buyers.strName	 ". 
                  " FROM   specification Inner Join orders ON specification.intStyleId = orders.intStyleId Left Outer Join buyerdivisions ON ".
				  "        orders.intDivisionId = buyerdivisions.intDivisionId Left Outer Join seasons ON orders.intSeasonId = seasons.intSeasonId ".
				  "        Inner Join useraccounts ON orders.intCoordinator = useraccounts.intUserID ".
				  "        Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID ". 
				  " WHERE  specification.intSRNO = '$prmJobNo'";		  
				  
		$result = $db->RunQuery($strSql);
		
		return $result;
	}
	#============================================================================================
	
	#============================================================================================
	# Description - Get the raw materail cost of the order except Services & Other category
	#               	
	#============================================================================================
	function GetRawMaterialCost($prmStyleId){
	
		global $db;
		
		$strSql = " SELECT SUM(((orders.intQty * orderdetails.reaConPc)+(((orders.intQty * orderdetails.reaConPc) * orderdetails.reaWastage) / 100)) * orderdetails.dblUnitPrice) AS TotalValue ".
		          " FROM   orders Inner Join orderdetails ON orders.intStyleId = orderdetails.intStyleId Inner Join matitemlist ON ".
				  "        orderdetails.intMatDetailID = matitemlist.intItemSerial ".
                  " WHERE  orders.intStyleId =  '$prmStyleId'";// AND matitemlist.intMainCatID <>  '4' AND matitemlist.intMainCatID <>  '5'";
				  
		$result = $db->RunQuery($strSql);
		
		while($row=mysql_fetch_array($result)){
			
			return $row['TotalValue'];	
		}
	}
	
	#============================================================================================
	
	#============================================================================================
	# Description - Check if order exist in the Navision 'Item Transfer
	#               	
	#============================================================================================
	
	function IsJobExist($prmJobNo){
		
		global $classMSSQLConnect;
		
		$SQL = 'SELECT * FROM [dbHela].[dbo].[HELA CLOTHING (PVT) LTD$Item Transfer] WHERE [Item No_] = '."'".$prmJobNo."'";
		
		$result = $classMSSQLConnect->ExecuteQuery($SQL);
		
		if(mssql_num_rows($result)>0){return true;}else{return false;}		
	}
	#============================================================================================
	
	#============================================================================================
	# Description - Update Finish goods detaill is job already exist
	#               	
	#============================================================================================	
	function UpdateFinshGoods($prmFOB, $prmEstCost, $prmSMV, $prmCMPc, $prmLabor, $prmJobNo){
		
		global $classMSSQLConnect;
		
		$strSql = ' UPDATE [dbHela].[dbo].[HELA CLOTHING (PVT) LTD$Item Transfer] '.
		          ' SET EstimatedFOB = '.$prmFOB.', EstimatedCost = '.$prmEstCost.', EstimatedSMVPiece = '.$prmSMV.', EstimatedCMPiece = '.$prmCMPc.', '.
				  '     EstimatedLabourOHPiece = '.$prmLabor.
				  ' WHERE [Item No_] = '."'".$prmJobNo."'"  ;
		
		$result = $classMSSQLConnect->ExecuteQuery($strSql);	
		
		return $result;
	}
	#============================================================================================	
	
	#============================================================================================
	# Description - Insert Finish goods to the Navision
	#               	
	#============================================================================================	
	function InsertFinishGoods($prmJobNo, $prmStyleId, $prmDivision, $prmSeason, $prmFOB, $prmSMV, $prmEstCost, $prmCMPc, $prmLabor, $prmStyleDesc){
		
		global $classMSSQLConnect;
		
		$strSql = ' INSERT INTO [dbHela].[dbo].[HELA CLOTHING (PVT) LTD$Item Transfer] ([Item No_], StyleNo, BuyerDivision, GarmentType, Season, '.
		          '              EstimatedFOB, EstimatedCost, EstimatedSMVPiece, EstimatedCMPiece, EstimatedLabourOHPiece, InventoryPostingGroup, '.
                  '              Description, BaseUnitofMeasure, SalesUOM, PurchaseUOM, GenProdPostingGroup, Transfer) '.
				  ' VALUES     ('."'".$prmJobNo."', '".$prmStyleId."','".$prmDivision."','".$prmDivision."','".$prmSeason."',".$prmFOB.
				  "           ,".$prmEstCost.",".$prmSMV.",".$prmCMPc.",".$prmLabor.", 'FINGDGMT', '".$prmStyleDesc."', 'PCS','PCS','PCS','GOODGARM','N')";				
		
		$result = $classMSSQLConnect->ExecuteQuery($strSql);	
		
		return $result;
	
	}
	#============================================================================================
	
	#============================================================================================
	# Description - Update status in the nav_jobs table
	#               	
	#============================================================================================
	function UpdateNavJobStatus($prmJobNo){
		
		global $db;
		
		$strSQL = " UPDATE nav_jobs SET intStatus = '1' WHERE intJobNo = ".$prmJobNo;			
			
		$db->RunQuery($strSQL);
	}
	#============================================================================================
	
	#============================================================================================
	# Description - Check if order exist in the JOB table
	#               	
	#============================================================================================
	function IsOrderExistAsJob($prmJobNo){
		
		global $classMSSQLConnect;
		
		$SQL = ' SELECT JobNo FROM [dbHela].[dbo].[HELA CLOTHING (PVT) LTD$JobTransfer] '. 
               " WHERE JobNo = '".$prmJobNo."' AND Transfer = 'N'";
		
		$result = $classMSSQLConnect->ExecuteQuery($SQL);
		
		if(mssql_num_rows($result)>0){return true;}else{return false;}
		
	}
	#============================================================================================
	
	
	#============================================================================================
	# Description - Insert Jobs
	#               	
	#============================================================================================
	function InsertJob($prmJobNo, $prmStyleDescription, $prmOrderQty, $prmOrderDate, $prmStyle, $prmCost, $prmMerchandiser, $prmLastDeliDate, 
	                   $prmBuyer, $prmEff){
	
		global $classMSSQLConnect;
		
		$strSql = ' INSERT INTO [dbHela].[dbo].[HELA CLOTHING (PVT) LTD$JobTransfer] '.
		          '             (JobNo, Description, SearhDescription, QtyBudget, CreationDate, StyleNo, BudgetedCost, Merchandiser, Transfer, '.
				  '              EndingDate, Buyer, [Sewing Efficiency Budget]) '.
				  " VALUES  ('".$prmJobNo."', '".$prmStyleDescription."', '". strtoupper($prmStyleDescription)."',".$prmOrderQty.", '".$prmOrderDate."'".
				  "         ,'".$prmStyle."', ".$prmCost.", '".$prmMerchandiser."', 'N','".$prmLastDeliDate."', '".$prmBuyer."',".$prmEff.")";
				     	
		$result = $classMSSQLConnect->ExecuteQuery($strSql);	
		
		return $result;
		
		//return $strSql;
		
		
	}
	#============================================================================================
	
	#============================================================================================
	# Description - Get maximum (Last) delivery date
	#               	
	#============================================================================================
	function GetLastDeliveryDate($prmStyleId){
		
		global $db;
		
		$strSql = " SELECT DATE_FORMAT(Max(deliveryschedule.dtDateofDelivery),'%m/%d/%Y') AS LastDelDate FROM deliveryschedule " .
		          " WHERE deliveryschedule.intStyleId = '$prmStyleId' ";
				  
		$result = $db->RunQuery($strSql);
		
		while($row=mysql_fetch_array($result)){
		
			return $row['LastDelDate'];
			
		}
		
		
		
	}
	
	#============================================================================================
}



?>
