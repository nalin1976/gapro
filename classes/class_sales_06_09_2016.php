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

	public function getDeliveries($buyerid, $fromdate, $todate){


		$sql = " SELECT orders.strStyle, specification.intSRNO, deliveryschedule.dtmHandOverDate, deliveryschedule.intBPO, 
						deliveryschedule.dblQty, orders.reaFOB, orders.intStyleId,
						(select companies.strName  from companies where companies.intCompanyID = deliveryschedule.intManufacturingLocation) as ProdLocation
				 FROM orders Inner Join specification ON orders.intStyleId = specification.intStyleId Inner Join deliveryschedule ON specification.intStyleId = deliveryschedule.intStyleId
				 WHERE  deliveryschedule.dtmHandOverDate between '$fromdate' and '$todate' and deliveryschedule.strShippingMode <> 7 ";

		if($buyerid != "-1"){
			$sql .= " and orders.intBuyerID =  '$buyerid'  ";
		}			 
	             
	        $sql .=" order by  deliveryschedule.dtmHandOverDate ";

	    $resDeliveries = $this->dbConnection->RunQuery($sql);
	   
	    return $resDeliveries;         

	}

	public function GetSalesExist($prmStyleId, $prmBuyerPO){

	
		$sql = " SELECT accmgrconfirm, shipconfirm FROM salesconfirmation WHERE styleId = '$prmStyleId' AND bpoNo = '$prmBuyerPO'";

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
                 WHERE userpermission.intUserID =  '$prmUserID' AND role.RoleName =  'Confirm Shipment of Deliveries '";

        $resConfirmUser = $this->dbConnection->RunQuery($sql);
        
        if(mysql_num_rows($resConfirmUser) > 0)
        	return 1;
        else
        	return 0;        

	}
}

?>