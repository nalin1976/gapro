<?php


/**
 * @Nalin Channa Jayakody
 * @copyright 2015
 * HelaClothing MIS Department
 *  
 */

class MaterialCostInfo{
	
	private $dbConnection;
	
	public function SetConnection($connection){
		$this->dbConnection = $connection;
	}
	
	function CalculateRMCost($styleId, $deliQty){
		
		$sql = " SELECT orderdetails.dblUnitPrice, orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.dbltotalcostpc, ".
		       "        matitemlist.intMainCatID, orderdetails.intOriginNo ".
               " FROM orderdetails Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial ".
			   " WHERE orderdetails.intStyleId = '$styleId' AND (orderdetails.intstatus = '1' OR orderdetails.intstatus IS NULL)";
			   
		$rs_matinfor = $this->dbConnection->RunQuery($sql);
		
		$tot_mat_cost	= 0;
		
		$tot_finance	= 0;
		
		while($rowmatinfo = mysql_fetch_array($rs_matinfor)){
			
			//$mat_cost	= $rowmatinfo["dbltotalcostpc"] * $deliQty;

			$dblReqQty		= $rowmatinfo["reaConPc"] * $deliQty;
			$dblWastageQty	= (($dblReqQty / 100) * $rowmatinfo["reaWastage"]);
			$dblTotReqQty	= $dblReqQty + $dblWastageQty;
			$mat_cost       = $dblTotReqQty * $rowmatinfo["dblUnitPrice"];

			$mainCatId		= $rowmatinfo["intMainCatID"];
			$originType		= $rowmatinfo["intOriginNo"];
			
			$TransportCharge 	= 0;
			$ClearingCost	 	= 0;
			$InterestCharge		= 0;
			$ExportExpenses		= 0;
			
			switch($mainCatId){
				
				case "1":
					$TransportCharge	= $this->CalculateTransportCharge($originType, $mat_cost);
					$ClearingCost		= $this->CalculateClearingCost($originType, $mat_cost);
					$InterestCharge		= $this->CalculateInterestCharge($mat_cost);
					$ExportExpenses		= $this->CalculateExportExpences($mat_cost);
				break;
				
				case "2":
					$ClearingCost		= $this->CalculateClearingCost($originType, $mat_cost);
					$InterestCharge		= $this->CalculateInterestCharge($mat_cost);
					$ExportExpenses		= $this->CalculateExportExpences($mat_cost);
				break;
				
				case "3":
					$ClearingCost		= $this->CalculateClearingCost($originType, $mat_cost);
					$InterestCharge		= $this->CalculateInterestCharge($mat_cost);
					$ExportExpenses		= $this->CalculateExportExpences($mat_cost);
				break;
			}
			
			$_dblESCValue 	= 0;
			$_dblUpCharge	= 0;
						
			
			$tot_finance = $TransportCharge + $ClearingCost + $InterestCharge + $ExportExpenses; 
			
			$tot_mat_cost += $mat_cost + $tot_finance;
			
		}
		
		$rs_orderHeader = $this->GetOrderHeaderInformation($styleId);
			
		while($row_orders = mysql_fetch_array($rs_orderHeader)){
			
			$_dblESCValue	= 0;
			 
			#----------------------------------------------------------------------
			#========== ESC value calculation =====================================
			$_dblESCValue	= $row_orders["reaECSCharge"] * $deliQty;
			#======================================================================
			
			
			#----------------------------------------------------------------------
			#========== UPCharge calculation =====================================
			$_dblUpCharge	= $row_orders["reaUPCharges"] * $deliQty;
			#======================================================================
			
		}
		
		//$tot_mat_cost += $_dblESCValue - $_dblUpCharge;	
		$tot_mat_cost += $_dblESCValue + $_dblUpCharge;
		return $tot_mat_cost;
	}
	
	
	function GetStyleIdList($deliMonth, $deliYear, $deliStatus, $buyerId, $divisionId){
		
		
		$sql = " SELECT orders.intStyleId, deliveryschedule.dblQty, buyers.intBuyerID, buyerdivisions.intDivisionId ".
               " FROM deliveryschedule Inner Join orders ON deliveryschedule.intStyleId = orders.intStyleId ".
               "      Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID Left Join buyerdivisions ON orders.intBuyerID = ".
			   "      buyerdivisions.intBuyerID AND orders.intDivisionId = buyerdivisions.intDivisionId ".
               " WHERE month(deliveryschedule.dtmHandOverDate) = $deliMonth AND year(deliveryschedule.dtmHandOverDate) = $deliYear AND ".
			   "       deliveryschedule.strShippingMode <> '7' AND deliveryschedule.intDeliveryStatus = '$deliStatus' and orders.intBuyerID = $buyerId and ";
			   
		if(empty($divisionId)){
			$sql .= " orders.intDivisionId is null ";
		}else{
			$sql .= " orders.intDivisionId = $divisionId ";
		}
			
		$sql .= " ORDER BY Month(deliveryschedule.dtmHandOverDate), buyers.strName	 ";
		
		$rs_styleList = $this->dbConnection->RunQuery($sql);
		
		return $rs_styleList;
		
	}
	
	private function CalculateTransportCharge($prmOrignType, $prmFabricCost){	
	
		$_dblTransportCharge = 0;
		
		switch((int)$prmOrignType){
			
			case 3:		
			case 4:
				$_dblTransportCharge = ((float)$prmFabricCost/100)*1;
				break;
				
			default:
				$_dblTransportCharge = 0;
				break;
		}
		return $_dblTransportCharge;	
	
	}
	
	private function CalculateClearingCost($prmOrignType, $prmItemCost){

	$_dblClearingCost = 0;
	
	switch((int)$prmOrignType){
		
		case 1:		
		case 2:
		
			$resCurrency = $this->GetLKRExchangeValue();
			
			while($rowCurrency = mysql_fetch_array($resCurrency)){				
				$_dblExRate = $rowCurrency['dblRateq'];
			}
			
			//Get USD value of Rs.10000/=
			$_dblUSDValue = floatval(10000/$_dblExRate);
			
						
			//Get the rate of the clearing charge 		
			//$_dblClearingCost = ((float)$prmItemCost/100)*1;
			$_dblClearingCost = ((float)$prmItemCost/100)*1;	
			
			if($_dblUSDValue > $_dblClearingCost){
				$_dblClearingCost = $_dblUSDValue;	
			}
			
			break;
			
		default:
			$_dblClearingCost = 0;
			break;
	}
	return $_dblClearingCost;			
	
	}
	
	private function GetLKRExchangeValue(){
	
	
		$strSql = " SELECT currencytypes.dblRateq ".
				  " FROM   currencytypes ".
				  " WHERE  currencytypes.strCurrency = 'LKR'";
	
		return  $this->dbConnection->RunQuery($strSql);	
	}
	
	private function CalculateInterestCharge($prmItemCost){
	
		$_dblInterestCharges = ($prmItemCost/100)*2;
		
		return $_dblInterestCharges;
	
	
	}

	private function CalculateExportExpences($prmItemCost){
		
		$_dblExportExpences = ($prmItemCost/100)*1;
		
		return $_dblExportExpences;
	}
	
	private function GetOrderHeaderInformation($StyleId){
		
		$sql = " SELECT reaECSCharge, reaUPCharges FROM orders WHERE intStyleId = '$StyleId' ";
		
		$rs_HeaderInfo = $this->dbConnection->RunQuery($sql);
		
		return $rs_HeaderInfo;
		
		
	}

	
}

?>