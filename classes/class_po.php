<?php

/**
 * @Nalin Channa Jayakody
 * @copyright 2017
 * HelaClothing MIS Department
 *  
 */

class PurchaseOrders{
    
    private $dbConnection;
	
    public function SetConnection($connection){
        $this->dbConnection = $connection;	
    }
    
    public function GetPOHeaderDetails($prmPOYear, $prmStyleCode, $prmSupplierCode, $prmPONo){
        
        $sqlPOHeader = " SELECT DISTINCT purchaseorderheader.intYear, purchaseorderheader.intPONo, DATE_FORMAT(purchaseorderheader.dtmDate, '%Y-%m-%d') AS dtmDate ,
                                DATE_FORMAT(purchaseorderheader.dtmDeliveryDate,'%Y-%m-%d') AS dtmDeliveryDate, DATE_FORMAT(purchaseorderheader.dtmETA, '%Y-%m-%d') AS dtmETA, useraccounts.`Name`, suppliers.strTitle,
                                companies.strComCode, suppliers.strSupplierID, purchaseorderheader.strPayTerm, purchaseorderheader.strPayMode,
                                purchaseorderheader.strShipmentMode, purchaseorderheader.strShipmentTerm, purchaseorderheader.intInvCompID,
                                purchaseorderheader.intDelToCompID, DATE_FORMAT(purchaseorderheader.dtmETD, '%Y-%m-%d') AS dtmETD
                         FROM purchaseorderheader INNER JOIN purchaseorderdetails ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear
                              INNER JOIN materialratio ON purchaseorderdetails.intStyleId = materialratio.intStyleId AND purchaseorderdetails.intMatDetailID = materialratio.strMatDetailID AND purchaseorderdetails.strColor = materialratio.strColor AND purchaseorderdetails.strSize = materialratio.strSize AND purchaseorderdetails.strBuyerPONO = materialratio.strBuyerPONO
                              INNER JOIN specificationdetails ON materialratio.intStyleId = specificationdetails.intStyleId AND materialratio.strMatDetailID = specificationdetails.strMatDetailID
                              INNER JOIN specification ON specificationdetails.intStyleId = specification.intStyleId INNER JOIN useraccounts ON purchaseorderheader.intUserID = useraccounts.intUserID
                              INNER JOIN suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID INNER JOIN companies ON purchaseorderheader.intDelToCompID = companies.intCompanyID
                              WHERE purchaseorderheader.intStatus = 10 AND purchaseorderheader.intYear = '$prmPOYear' ";
        
        if($prmStyleCode != -1){
            $sqlPOHeader .= " AND specification.intStyleId = '$prmStyleCode'";            
        }
        
        if($prmSupplierCode != -1){
            $sqlPOHeader .= " AND suppliers.strSupplierID = '$prmSupplierCode'"; 
        }
        
        if($prmPONo != ""){
            
            $sqlPOHeader .= " AND purchaseorderheader.intPONo like '%$prmPONo%' "; 
        }
       
        $sqlPOHeader .= " order by intPONo LIMIT 25";
        $result = $this->dbConnection->RunQuery($sqlPOHeader);
		
	return $result;	
        
    }
    
}
