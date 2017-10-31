<?php

/**
 * @Nalin Channa Jayakody
 * @copyright 2017
 * HelaClothing MIS Department
 *  
 */

class StockTransaction{
    
    private $dbConnection;
	
    public function SetConnection($connection){
            $this->dbConnection = $connection;	
    }
    
    public function SaveStockTransactionToHistory($prmStyelCode){
        
        try{
        
                        
            $sql = "INSERT INTO stocktransactions_history(intYear, strMainStoresID, strSubStores, strLocation, strBin, intStyleId, strBuyerPoNo, intDocumentNo, intDocumentYear, intMatDetailId, strColor, strSize, strType, strUnit, dblQty, dtmDate, intUser, intGrnNo, intGrnYear, strGRNType)  ".
                   " (SELECT intYear, strMainStoresID, strSubStores, strLocation, strBin, intStyleId, strBuyerPoNo, intDocumentNo, intDocumentYear, intMatDetailId, strColor, strSize, strType, strUnit, dblQty, dtmDate, intUser, intGrnNo, intGrnYear, strGRNType FROM stocktransactions WHERE stocktransactions.intStyleId = '$prmStyelCode'); ";

            $result = $this->dbConnection->ExecuteQuery($sql);
            
            if(!$result){
                throw new Exception("Error in saving stock transaction history");
            }else{
                
                return 1;
            }
        
        }catch(Exception $e){
            
            echo $e->getMessage();
        }
        
    }
    
    public function TranferStockBalanceToLeftOver($prmStyelCode){
        
        try{
            
            $sql = " insert into stocktransactions_leftover
(stocktransactions_leftover.lngTransactionNo,
stocktransactions_leftover.intYear,
stocktransactions_leftover.strMainStoresID,
stocktransactions_leftover.strSubStores,
stocktransactions_leftover.strLocation,
stocktransactions_leftover.strBin,
stocktransactions_leftover.intStyleId,
stocktransactions_leftover.strBuyerPoNo,
stocktransactions_leftover.intMatDetailId,
stocktransactions_leftover.strColor,
stocktransactions_leftover.strSize,
stocktransactions_leftover.strUnit,
stocktransactions_leftover.dblQty,
stocktransactions_leftover.dtmDate,
stocktransactions_leftover.intUser,
stocktransactions_leftover.strType,
stocktransactions_leftover.intGrnNo,
stocktransactions_leftover.intGrnYear,
stocktransactions_leftover.strGRNType)
SELECT
stocktransactions.lngTransactionNo,
stocktransactions.intYear,
stocktransactions.strMainStoresID,
stocktransactions.strSubStores,
stocktransactions.strLocation,
stocktransactions.strBin,
stocktransactions.intStyleId,
stocktransactions.strBuyerPoNo,
stocktransactions.intMatDetailId,
stocktransactions.strColor,
stocktransactions.strSize,
stocktransactions.strUnit,
round(Sum(stocktransactions.dblQty),2) AS Stock_Qty,
stocktransactions.dtmDate,
stocktransactions.intUser,
stocktransactions.strType,
stocktransactions.intGrnNo,
stocktransactions.intGrnYear,
stocktransactions.strGRNType
FROM
stocktransactions
WHERE
stocktransactions.intStyleId = '$prmStyelCode'
GROUP BY
stocktransactions.intMatDetailId,
stocktransactions.strColor,
stocktransactions.strSize
HAVING
Sum(stocktransactions.dblQty) >0
 ";
            
            $result = $this->dbConnection->ExecuteQuery($sql);
            
            if(!$result){
                throw new Exception("Error in get stock balance to left over");
            }else{
                return 1;
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        
    }
    
    public function RemoveStockTransactionFromLive($prmStyelCode){
        
        try{
            
            $sql = "DELETE FROM stocktransactions WHERE stocktransactions.intStyleId = '$prmStyelCode'";
            
            $resDelete = $this->dbConnection->ExecuteQuery($sql);
            
            if(!resDelete){
               throw new Exception("Error in deleting stocktransaction"); 
            }else{
                return 1;
            }            
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function GetStockHistory($prmStyelCode){
        
        try{
            $sql = "SELECT * FROM stocktransactions_history WHERE stocktransactions_history.intStyleId = '$prmStyelCode' ";
            
            $resStockHistory = $this->dbConnection->RunQuery($sql);
            
            if(!$resStockHistory){
                throw new Exception("Error selecting stocktransaction history");
            }else{
               return mysql_num_rows($resStockHistory);
            }
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
}

?>
