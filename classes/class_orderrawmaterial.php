<?php

/**
 * @Nalin Channa Jayakody
 * @copyright 2016
 * HelaClothing MIS Department
 *  
 */

class OrdersRawMaetrial{
    
    private $dbConnection;
	
    public function SetConnection($connection){
        $this->dbConnection = $connection;	
    }
    
    public function GetFabricDetails($prmStyleId){
        
        $sql = " SELECT DISTINCT matitemlist.strItemDescription, materialratio.strColor, materialratio.dblQty, materialratio.dblYYConsumption
                 FROM specification INNER JOIN specificationdetails ON specification.intStyleId = specificationdetails.intStyleId
                                    INNER JOIN materialratio ON specificationdetails.strMatDetailID = materialratio.strMatDetailID AND specificationdetails.intStyleId = materialratio.intStyleId
                                    INNER JOIN matitemlist ON specificationdetails.strMatDetailID = matitemlist.intItemSerial
                 WHERE matitemlist.intMainCatID = 1 AND specification.intStyleId = '$prmStyleId' AND specificationdetails.intStatus = 1  AND materialratio.dblYYConsumption > 0 ";
        
        $result = $this->dbConnection->RunQuery($sql);
		
	return $result;	
    }
    
    public function GetAccosseries($prmStyleId){
       
       $sql = " SELECT DISTINCT matitemlist.strItemDescription
                FROM specification INNER JOIN specificationdetails ON specification.intStyleId = specificationdetails.intStyleId
                     INNER JOIN matitemlist ON specificationdetails.strMatDetailID = matitemlist.intItemSerial
                WHERE specification.intStyleId = '$prmStyleId' AND matitemlist.intMainCatID = 2 AND specificationdetails.intStatus = 1
                ORDER BY strItemDescription ";
       
       $result = $this->dbConnection->RunQuery($sql);
       
       return $result;
   }
   
   public function GetPacking($prmStyleId){
       
       $sql = " SELECT DISTINCT matitemlist.strItemDescription
                FROM specification INNER JOIN specificationdetails ON specification.intStyleId = specificationdetails.intStyleId
                     INNER JOIN matitemlist ON specificationdetails.strMatDetailID = matitemlist.intItemSerial
                WHERE specification.intStyleId = '$prmStyleId' AND matitemlist.intMainCatID = 3 AND specificationdetails.intStatus = 1
                ORDER BY strItemDescription ";
       
       $result = $this->dbConnection->RunQuery($sql);
       
       return $result;
   }
    
    
}



?>