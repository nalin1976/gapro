<?php

/**
 * @Nalin Channa Jayakody
 * @copyright 2015
 * HelaClothing MIS Department
 *  
 */



class salesmonitoring{

	private $dbConnection;
	
	public function SetConnection($connection){
		$this->dbConnection = $connection;
	}

	public function getDeliveries($buyerid, $fromdate, $todate, $prmManuLocation){


		// ====================================================================================
		// Change delivery details from freeze table instead of delivery schedule table
		// ====================================================================================
		/* $sql = " SELECT orders.strStyle, specification.intSRNO, deliveryschedule.dtmHandOverDate, deliveryschedule.intBPO, 
						deliveryschedule.dblQty, orders.reaFOB, orders.intStyleId,
						(select companies.strName  from companies where companies.intCompanyID = deliveryschedule.intManufacturingLocation) as ProdLocation
				 FROM orders Inner Join specification ON orders.intStyleId = specification.intStyleId Inner Join deliveryschedule ON specification.intStyleId = deliveryschedule.intStyleId
				 WHERE  deliveryschedule.dtmHandOverDate between '$fromdate' and '$todate' and deliveryschedule.strShippingMode <> 7 "; */
		// ====================================================================================	

		$sql = " SELECT orders.strStyle, specification.intSRNO, freeze_schedule.dtmHandOverDate, freeze_schedule.intBPO,
                                freeze_schedule.dblQty, freeze_schedule.dblFOB, orders.intStyleId, buyers.strName,
                                (select companies.strName  from companies where companies.intCompanyID = freeze_schedule.intManufacturingLocation) as ProdLocation
                        FROM orders Inner Join specification ON orders.intStyleId = specification.intStyleId
                                Inner Join freeze_schedule ON specification.intStyleId = freeze_schedule.intStyleId Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
			WHERE  freeze_schedule.dtmHandOverDate between '$fromdate' and '$todate' and freeze_schedule.strShippingMode <> '7' ";	 


		if($buyerid != "-1"){
			$sql .= " and orders.intBuyerID =  '$buyerid'  ";
		}
                
                if($prmManuLocation != "-1"){
                    $sql .= " and freeze_schedule.intManufacturingLocation =  '$prmManuLocation'  ";    
                }
	             
	        $sql .=" order by  freeze_schedule.dtmHandOverDate, specification.intSRNO ";
                    
	    $resDeliveries = $this->dbConnection->RunQuery($sql);
	   
	    return $resDeliveries;         

	}

	public function GetSalesExist($prmStyleId, $prmBuyerPO){

	
		$sql = " SELECT accmgrconfirm, shipconfirm, planconfirm FROM salesconfirmation WHERE styleId = '$prmStyleId' AND bpoNo = '$prmBuyerPO'";

		$resSales = $this->dbConnection->RunQuery($sql);

		return $resSales;

	}

	public function getMonthWeekNo($hodDate){

		list($y, $m, $d) = explode('-', date('Y-m-d', strtotime($hodDate)));

		$w = 1;

		for($i=1;$i<=$d;++$i){

			if($i>1 && date('w', strtotime("$y-$m-$i")) == 0){
				++$w;
			}

		}

		return $w;
	}

	public function GetOrderAuthorizedUser($prmStyleCode, $prmBPONo){


		$sql = " SELECT useraccounts.Name, salesconfirmation.accmgrconfirmon
                 FROM useraccounts Inner Join salesconfirmation ON useraccounts.intUserID = salesconfirmation.accuserid
                 WHERE salesconfirmation.styleId =  '$prmStyleCode' AND salesconfirmation.bpoNo =  '$prmBPONo' ";

                 //echo $sql;
        $resConfirmUser = $this->dbConnection->RunQuery($sql);

        if(mysql_num_rows($resConfirmUser)<=0){

        	return "Not Authorised";
        }else{

        	$arrAuthorizedUser = mysql_fetch_row($resConfirmUser);

        	return $arrAuthorizedUser[0].'/'.$arrAuthorizedUser[1];
        }
	}


	public function GetOrderConfirmUser($prmStyleCode, $prmBPONo){


            $sql = " SELECT useraccounts.Name, salesconfirmation.shipconfirmon
                 FROM useraccounts Inner Join salesconfirmation ON useraccounts.intUserID = salesconfirmation.shipuserid
                 WHERE salesconfirmation.styleId =  '$prmStyleCode' AND salesconfirmation.bpoNo =  '$prmBPONo' ";

                 //echo $sql;
            $resConfirmUser = $this->dbConnection->RunQuery($sql);

            if(mysql_num_rows($resConfirmUser)<=0){

        	return "Not Confirmed";
            }else{

        	$arrAuthorizedUser = mysql_fetch_row($resConfirmUser);

        	return $arrAuthorizedUser[0].'/'.$arrAuthorizedUser[1];
            }
	}
        
        public function GetFactoryConfirmUser($prmStyleCode, $prmBPONo){

            $sql = " SELECT useraccounts.Name, salesconfirmation.planconfirm
                 FROM useraccounts Inner Join salesconfirmation ON useraccounts.intUserID = salesconfirmation.planuserid
                 WHERE salesconfirmation.styleId =  '$prmStyleCode' AND salesconfirmation.bpoNo =  '$prmBPONo' ";

                 //echo $sql;
            $resConfirmUser = $this->dbConnection->RunQuery($sql);

            if(mysql_num_rows($resConfirmUser)<=0){

        	return "Not Confirmed";
            }else{

        	$arrFactoryUser = mysql_fetch_row($resConfirmUser);

        	return $arrFactoryUser[0].'/'.$arrFactoryUser[1];
            }
	}

	public function GetShippedStatusFromD2D($prmSCNo, $prmBuyerPONo, $prmD2DConnt){
	
		
		$intShippedQty = 0;
		
		$sqlD2D = " SELECT distinct Sum(d2d_Pack_Export_Details.transferOutQty) AS Shipped_Qty 
					FROM   d2d_Pack_Export_Header Inner Join d2d_Pack_Export_Details ON d2d_Pack_Export_Header.aodNo = d2d_Pack_Export_Details.serial AND d2d_Pack_Export_Header.location = d2d_Pack_Export_Details.locationId AND d2d_Pack_Export_Header.scNumber = d2d_Pack_Export_Details.scNumber
					WHERE d2d_Pack_Export_Header.scNumber =  '$prmSCNo' AND d2d_Pack_Export_Header.bpo =  '$prmBuyerPONo' AND d2d_Pack_Export_Header.`status` =  'SEND'
					GROUP BY d2d_Pack_Export_Details.styleComponent ";
					
					// AND d2d_Pack_Export_Header.destination <>  '20'";	
		
		$resD2D	= $prmD2DConnt->RunQuery($sqlD2D);
					
		while($rowD2D = mysql_fetch_array($resD2D)){
			$intShippedQty = $rowD2D["Shipped_Qty"];
			
		}
		
		return $intShippedQty;
	
	}
        
        public function GetFinishGoodsQty($prmSCNo, $prmBuyerPONo, $prmD2DConnt){
           
            $intFinishQty = 0;
            
            $sqlD2D = " SELECT Sum(d2d_fineshedgood_point.transferOutQty) AS FinishGoodQty
                        FROM d2d_fineshedgood_point 
                        WHERE d2d_fineshedgood_point.scNumber =  '$prmSCNo' AND d2d_fineshedgood_point.bpo =  '$prmBuyerPONo'";
            
            $resD2D	= $prmD2DConnt->RunQuery($sqlD2D);
					
            while($rowD2D = mysql_fetch_array($resD2D)){
                
                $intFinishQty = $rowD2D["FinishGoodQty"];

            }

            return $intFinishQty;
            
        }

	public function GetApproveUser($prmUserID){

		$sql = " SELECT userpermission.intUserID, role.RoleName 
                 FROM role Inner Join userpermission ON role.RoleID = userpermission.RoleID
                 WHERE userpermission.intUserID =  '$prmUserID' AND role.RoleName =  'Approve Deliveries'";

        $resApproveUser = $this->dbConnection->RunQuery($sql);
        
        if(mysql_num_rows($resApproveUser) > 0)
        	return 1;
        else
        	return 0;        

	}

	public function GetConfirmUser($prmUserID){

            $sql = " SELECT userpermission.intUserID, role.RoleName 
             FROM role Inner Join userpermission ON role.RoleID = userpermission.RoleID
             WHERE userpermission.intUserID =  '$prmUserID' AND role.RoleName =  'Confirm Shipment of Deliveries'";

        $resConfirmUser = $this->dbConnection->RunQuery($sql);
        
        if(mysql_num_rows($resConfirmUser) > 0)
        	return 1;
        else
        	return 0;        

	}
        
        public function GetPlannerConfirmPermission($prmUserID){

            $sql = " SELECT userpermission.intUserID, role.RoleName 
             FROM role Inner Join userpermission ON role.RoleID = userpermission.RoleID
             WHERE userpermission.intUserID =  '$prmUserID' AND role.RoleName =  'Confirm By Planner'";

        $resConfirmUser = $this->dbConnection->RunQuery($sql);
        
        if(mysql_num_rows($resConfirmUser) > 0)
            return 1;
        else
            return 0;        

	}
        
        public function GetFrozenValue($prmFromDate, $prmToDate){
            
            $dblFrozenValue = 0;
            
            $sql = " SELECT sum(freeze_schedule.dblQty * freeze_schedule.dblFOB) as FrozenValue
                     FROM freeze_schedule Inner Join specification ON freeze_schedule.intStyleId = specification.intStyleId
                     WHERE freeze_schedule.dtmHandOverDate BETWEEN  '$prmFromDate' AND '$prmToDate' and freeze_schedule.strShippingMode <> '7'";
            
            $resFrozenValue = $this->dbConnection->RunQuery($sql);
            
            while($row = mysql_fetch_array($resFrozenValue)){
                $dblFrozenValue = $row["FrozenValue"];
            }
            
            return $dblFrozenValue;
        }
        
        public function GetFrozenValueBuyer($prmBuyerId, $prmFromDate, $prmToDate){
            
            $dblFrozenValue = 0;
            
            $sql = " SELECT sum(freeze_schedule.dblQty * freeze_schedule.dblFOB) as FrozenValue
                     FROM freeze_schedule Inner Join orders ON freeze_schedule.intStyleId = orders.intStyleId
                          Inner Join specification ON orders.intStyleId = specification.intStyleId
                     WHERE freeze_schedule.dtmHandOverDate BETWEEN  '$prmFromDate' AND '$prmToDate' AND
                    orders.intBuyerID =  '$prmBuyerId' and freeze_schedule.strShippingMode <> '7'";
            
            $resFrozenValue = $this->dbConnection->RunQuery($sql);
            
            while($row = mysql_fetch_array($resFrozenValue)){
                $dblFrozenValue = $row["FrozenValue"];
            }
            
            return $dblFrozenValue;
        }
        
        public function GetCompanies(){
            
            $sql = " SELECT * FROM companies WHERE intManufacturing = 1 ";
            
            $resCompanies = $this->dbConnection->RunQuery($sql);
            
            return $resCompanies;
        }
        
        public function GetRemarks($prmStyleCode, $prmBPONo){
            
            $sql = " SELECT salesconfirmation.strremarks
                     FROM salesconfirmation 
                     WHERE salesconfirmation.styleId =  '$prmStyleCode' AND salesconfirmation.bpoNo =  '$prmBPONo' ";

                 //echo $sql;
            $resRemarks = $this->dbConnection->RunQuery($sql);

            if(mysql_num_rows($resRemarks)<=0){

        	return "";
            }else{

        	$arrRemarks = mysql_fetch_row($resRemarks);

        	return $arrRemarks[0];
            }
            
        }
        
        
}

?>