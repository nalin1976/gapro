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
        
       
       $sql = "SELECT orders.intStyleId,orders.strStyle,strDescription, companies.strComCode, buyers.strName,intQty,dtmAppDate,intSRNO, buyers.buyerCode FROM orders INNER JOIN companies ON orders.intCompanyID = companies.intCompanyID INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID INNER JOIN specification ON orders.intStyleId = specification.intStyleId  WHERE orders.intStatus = 11 and buyers.intBuyerID = '$prmBuyerId' ORDER by intSRNO DESC";
       
       $result = $this->dbConnection->RunQuery($sql);
		
       return $result;
   }
   
   public function GetOrderHeaderDetails($prmStyleId){
       
       $sql = " SELECT specification.intSRNO, orders.strStyle, buyers.strName, orders.strDescription,
                       buyerdivisions.strDivision, buyerbuyingoffices.strName as BuyingOffice, buyers.buyerCode
                FROM specification INNER JOIN orders ON specification.intStyleId = orders.intStyleId
                     INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID INNER JOIN buyerdivisions ON orders.intDivisionId = buyerdivisions.intDivisionId AND orders.intBuyerID = buyerdivisions.intBuyerID
                     INNER JOIN buyerbuyingoffices ON orders.intBuyingOfficeId = buyerbuyingoffices.intBuyingOfficeId AND orders.intBuyerID = buyerbuyingoffices.intBuyerID
                WHERE specification.intStyleId = '$prmStyleId'";
       
       $result = $this->dbConnection->RunQuery($sql);
		
       return $result;
   }
   
   public function GetManufactureLocation($prmStyleId){
       
       $sql = " SELECT DISTINCT companies.strName
                FROM deliveryschedule INNER JOIN companies ON deliveryschedule.intManufacturingLocation = companies.intCompanyID
                WHERE deliveryschedule.intStyleId = '$prmStyleId'";
       
       $result = $this->dbConnection->RunQuery($sql);
		
       return $result;
       
   }
   
   public function GetRatioDetails($prmStyleId, $prmBPO, $prmRatioColor){
       
       $sql = " SELECT deliveryschedule.intBPO, deliveryschedule.estimatedDate, styleratio.strColor, styleratio.strSize, styleratio.dblQty
                FROM styleratio INNER JOIN deliveryschedule ON styleratio.intStyleId = deliveryschedule.intStyleId AND styleratio.strBuyerPONO = deliveryschedule.intBPO
                WHERE styleratio.intStyleId = '$prmStyleId' AND deliveryschedule.intBPO = '$prmBPO' AND styleratio.strColor = '$prmRatioColor' ";
       
       $result = $this->dbConnection->RunQuery($sql);
		
       return $result;
   }
   
   public function GetDeliveryDetails($prmStyleId){
       
       $sql = " SELECT DISTINCT
deliveryschedule.intBPO,
deliveryschedule.estimatedDate
FROM
deliveryschedule
INNER JOIN styleratio ON deliveryschedule.intStyleId = styleratio.intStyleId AND deliveryschedule.intBPO = styleratio.strBuyerPONO WHERE deliveryschedule.intStyleId = '$prmStyleId' ";
       
       $result = $this->dbConnection->RunQuery($sql);
		
       return $result;
       
   }
   
   public function SetOrderAsComplete($prmStyleId, $prmUserId){
       try{
           
           $sql = "UPDATE orders SET intStatus = 16,intOrderCompleteBy='$prmUserId',dtmDateCompleteOrder=now() WHERE intStyleId = '$prmStyleId'";
           //echo $sql;
           $result = $this->dbConnection->ExecuteQuery($sql);
           
           if(!$result){
               throw new Exception("Error in update order table");
           }else{
               return 1;
           }
           
       } catch (Exception $ex) {
           
           echo $ex->getMessage();
       }
       
       
       
   }
   
   
}
?>
