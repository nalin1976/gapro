<?php

/**
 * @Nalin Channa Jayakody
 * @copyright 2015
 * HelaClothing MIS Department
 *  
 */

class DeliveryCutOff{
	
	private $dbConnection;
	
	public function SetConnection($connection){
		$this->dbConnection = $connection;	
	}
	
	public function GetBuyerPOList($BuyerCode, $CutOffDate){
		
		$filterDate	= date('Y-m-d', strtotime("+30 days", strtotime($CutOffDate)));
		
		//echo $filterDate;
		
		$sql = " SELECT specification.intSRNO, orders.strStyle, useraccounts.Name, buyers.strName, deliveryschedule.intBPO, ".
		       "        deliveryschedule.dtmCutOffDate, deliveryschedule.dtDateofDelivery, deliveryschedule.strShippingMode, ".
			   "        deliveryschedule.dblQty ".
               " FROM   specification Inner Join orders ON specification.intStyleId = orders.intStyleId Inner Join useraccounts ON ".
			   "        orders.intCoordinator = useraccounts.intUserID Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID ".
			   "        Inner Join deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId ".
               " WHERE  deliveryschedule.intDeliveryStatus =  '2' AND deliveryschedule.strShippingMode <>  '7' AND ";
			   
		if($BuyerCode != '-1')
        	$sql .= " deliveryschedule.dtmCutOffDate <= '$filterDate' AND buyers.intBuyerID = '$BuyerCode' " ;
		else
			$sql .= " deliveryschedule.dtmCutOffDate <= '$filterDate' ";
			
		//echo $sql;		
			   
		$result = $this->dbConnection->RunQuery($sql);
		
		return $result;		
	}
	
}


?>