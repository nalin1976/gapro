<?php

/**
 * @Nalin Channa Jayakody
 * @copyright 2015
 * HelaClothing MIS Department
 *  
 */

class Supplier{
	
    private $dbConnection;

    public function SetConnection($connection){
        $this->dbConnection = $connection;	
    }
    
    
    public function GetSupplierList(){
		
        $sql = " SELECT strSupplierID,strTitle FROM suppliers where intStatus='1' AND intApproved = '1' order by strTitle " ;

        $result = $this->dbConnection->RunQuery($sql);

        return $result;		
    }
    
    public function GetPaymentModes(){
		
        $sql = " SELECT strPayModeId,strDescription FROM popaymentmode p where intstatus='1' order by strDescription; " ;

        $result = $this->dbConnection->RunQuery($sql);

        return $result;		
    }
    
    public function GetPaymentTerms(){
		
        $sql = " SELECT strPayTermId,strDescription FROM popaymentterms where intStatus='1' order by strDescription; " ;

        $result = $this->dbConnection->RunQuery($sql);

        return $result;		
    }
    
    public function GetShipmentMode(){
		
        $sql = " SELECT strDescription,intShipmentModeId FROM shipmentmode s where intStatus='1' order by strDescription; " ;

        $result = $this->dbConnection->RunQuery($sql);

        return $result;		
    }
    
    public function GetShipmentTerm(){
		
        $sql = " SELECT strShipmentTerm,strShipmentTermId FROM shipmentterms s where intStatus='1' order by strShipmentTerm; " ;

        $result = $this->dbConnection->RunQuery($sql);

        return $result;		
    }
}    

?>
