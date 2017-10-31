<?php

/**
 * @Nalin Channa Jayakody
 * @copyright 2016
 * HelaClothing MIS Department
 *  
 */

class Orders{
    
    private $dbConnection;
	
    public function SetConnection($connection){
        $this->dbConnection = $connection;	
    }
    
    public function GetSCList(){
        
        $sql = "select specification.intStyleId, specification.intSRNO from specification inner join orders on specification.intStyleId = orders.intStyleId AND orders.intStatus = 11 order by intSRNO desc; ";
        
        $result = $this->dbConnection->RunQuery($sql);
		
	return $result;	
    }
    
    public function GetStyleList(){
        
        $sql = "SELECT * FROM orders where orders.intStatus = 11 ";
        
        $result = $this->dbConnection->RunQuery($sql);
		
	return $result;	
    }
    
   public function GetOrdersListByBuyer($prmBuyerId){
        
       
       $sql = "SELECT orders.intStyleId,orders.strStyle,strDescription, companies.strComCode, buyers.strName,intQty,dtmAppDate,intSRNO FROM orders INNER JOIN companies ON orders.intCompanyID = companies.intCompanyID INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID INNER JOIN specification ON orders.intStyleId = specification.intStyleId  WHERE orders.intStatus = 11 and buyers.intBuyerID = '$prmBuyerId' ORDER by intSRNO DESC";
       
       $result = $this->dbConnection->RunQuery($sql);
		
       return $result;
   }
}
?>
