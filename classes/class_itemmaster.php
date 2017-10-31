<?php


/**
 * @Nalin Channa Jayakody
 * @copyright 2017
 * HelaClothing MIS Department
 *  
 */

class ItemMaster{
    
    
    private $dbConnection;
	
    public function SetConnection($connection){
        $this->dbConnection = $connection;
    }
    
    public function GetFabricType(){
        
        $sql = " SELECT * FROM fabric_type ORDER BY Type_Code";
        
        $rs_fabrictype = $this->dbConnection->RunQuery($sql);
        
        return $rs_fabrictype;
    }
    
    public function GetFabricOperation(){
        
        $sql = "SELECT * FROM  fabric_operations ORDER BY Operation_Code";
        $rs_fab_op = $this->dbConnection->RunQuery($sql);
        
        return $rs_fab_op;
    }
    
    public function GetOrderQtyCode($prmOrderQty){
        
        $sql = " select * from fabric_wastage_qty WHERE '$prmOrderQty' BETWEEN Qty_From AND Qty_To ";
        $rsOrderQty = $this->dbConnection->RunQuery($sql);
        //echo $sql;
        return $rsOrderQty;
        
    }
    
    public function GetWastageWithFabricOperation($prmOrderQty){
        
        $sql = " SELECT fabric_operations.Operation_Code, fabric_operations.Operation_Name, fabric_wastage.Wastage
                 FROM fabric_operations INNER JOIN fabric_wastage ON fabric_operations.Operation_Code = fabric_wastage.Operation_Type
                 INNER JOIN fabric_wastage_qty ON fabric_wastage.Order_Qty_ID = fabric_wastage_qty.Order_Qty_ID
                 WHERE '$prmOrderQty' BETWEEN Qty_From AND Qty_To ";
        
        $rs_fab_op = $this->dbConnection->RunQuery($sql);
        
        return $rs_fab_op;
        
    }
    
    public function GetFabricTypeWastage($prmQtyId, $prmFabricType){
        
        $dbl_wastage = 0;
        
        $sql = " select * from fabric_type_wastage WHERE Order_Qty_ID = '$prmQtyId' AND Fabric_Type = '$prmFabricType' ";
        
        
        $rsItemWastage = $this->dbConnection->RunQuery($sql);
        
        while($rowWastage = mysql_fetch_array($rsItemWastage)){
            $dbl_wastage = $rowWastage["Wastage"];
        }
        
        //return $rsItemWastage;
        return $dbl_wastage;
    }
    
    public function GetFabricOpWastage($prmQtyId, $prmOpCode){   
        
        $dbl_wastage = 0;
        
        $sql = " select * from fabric_wastage WHERE Order_Qty_ID = '$prmQtyId' AND Operation_Type = '$prmOpCode' ";
        
        $rsItemWastage = $this->dbConnection->RunQuery($sql);
        
        while($rowWastage = mysql_fetch_array($rsItemWastage)){
            $dbl_wastage = $rowWastage["Wastage"];
        }
        
        //return $rsItemWastage;
        return $dbl_wastage;
    }
    
    
}


?>
