<?php

session_start();
//include "../Connector.php";

class CSVClass{
	
	
	function GetDetailsForOrder($prmStyleCode){
	
	global $db;
        
        # ========================================
        # Comment For - To get season for the query
        # Comment By - Nalin Jayakody
        # Comment On - 05/04/2017
        # =========================================
	
	/* $strSql = " SELECT 
		specification.intSRNO,
		orders.strStyle,
		orders.strDescription,
		orders.intQty,
		stylepartdetails.strPartName,
		orders.reaSMV,
		orders.reaEfficiencyLevel,
		stylepartdetails.dblsmv,
		productcategory.strCatName,
		orders.intStyleId,
		buyers.strName,
		orders.reaFOB,
		fr_orderstransfer.intTransferCount,
                orders.reaSMVRate,
                orders.reaLabourCost,
                orders.reaSMVRate,
                orders.reaCostPerMinute
		FROM	
		specification
		Inner Join orders ON specification.intStyleId = orders.intStyleId
		Inner Join stylepartdetails ON orders.intStyleId = stylepartdetails.intStyleId
		Left Join productcategory ON orders.productSubCategory = productcategory.intCatId
		Inner Join fr_orderstransfer ON orders.intStyleId = fr_orderstransfer.intStyleId
		Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
		WHERE fr_orderstransfer.booTransfer = '0' AND
		orders.intStyleId = ".$prmStyleCode;*/
	# =========================================
        
        $strSql = "SELECT 
		specification.intSRNO,
		orders.strStyle,
		orders.strDescription,
		orders.intQty,
		stylepartdetails.strPartName,
		orders.reaSMV,
		orders.reaEfficiencyLevel,
		stylepartdetails.dblsmv,
		productcategory.strCatName,
		orders.intStyleId,
		buyers.strName,
		orders.reaFOB,
		fr_orderstransfer.intTransferCount,
		orders.reaSMVRate,
		orders.reaLabourCost,
		orders.reaSMVRate,
		orders.reaCostPerMinute,
		seasons.strSeason,
                orders.dtPCD
		FROM	
		specification
		Inner Join orders ON specification.intStyleId = orders.intStyleId
		Inner Join stylepartdetails ON orders.intStyleId = stylepartdetails.intStyleId
		Left Join productcategory ON orders.productSubCategory = productcategory.intCatId
		Inner Join fr_orderstransfer ON orders.intStyleId = fr_orderstransfer.intStyleId
		Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
		Inner Join seasons on seasons.intSeasonId = orders.intSeasonId
		WHERE fr_orderstransfer.booTransfer = '0' AND
		orders.intStyleId = ".$prmStyleCode;
        
		$result = $db->RunQuery($strSql);
		
		return $result;
	}
	
	function GetDeliveryDetails($prmStyleId){
	
	global $db;
	
	#==============================================================================
	# Comment On  - 2015/09/17
	# Comment By  - Nalin Jayakody
	# Description - To get delivery schedule by estimated date order 
	#==============================================================================
            //$strSql = " SELECT * FROM deliveryschedule where intStyleId = '$prmStyleId' ";
	#==============================================================================
        
        #==============================================================================
	# Comment On  - 2016/06/28
	# Comment By  - Nalin Jayakody
	# Description - Get time table to the delivery list 
	#==============================================================================
            //$strSql = " SELECT * FROM deliveryschedule where intStyleId = '$prmStyleId' and strShippingMode <> '7' order by estimatedDate ";
	#==============================================================================
        
        #==============================================================================
        # Comment On  - 2017/05/04
	# Comment By  - Nalin Jayakody
	# Description - To add shipping mode to the list 
	#==============================================================================
            // $strSql = " SELECT deliveryschedule.*, events.strDescription  FROM deliveryschedule Left Join events ON deliveryschedule.intSerialNO = events.intEventID where intStyleId = '$prmStyleId' and strShippingMode <> '7' order by estimatedDate ";
	#==============================================================================
	
           $strSql = " SELECT deliveryschedule.*, events.strDescription AS EventName, shipmentmode.strDescription, companies.strName as Location
                       FROM deliveryschedule Left Join events ON deliveryschedule.intSerialNO = events.intEventID 
		            Inner Join shipmentmode ON shipmentmode.intShipmentModeId = deliveryschedule.strShippingMode
                            Left Join companies ON companies.intCompanyID = deliveryschedule.intManufacturingLocation                
                       WHERE intStyleId = '$prmStyleId' and strShippingMode <> '7' order by estimatedDate ";
        
        # =============================================================================
        # 		
	//echo $strSql;
	$result = $db->RunQuery($strSql);
	
	return $result;
	
	}
        
        function GetCustomersList(){
            
            global $db;
            
            $sql = " SELECT strName FROM buyers WHERE intStatus = 1 ORDER BY strName";
            
            $result = $db->RunQuery($sql);
            
            return $result;
            
            
        }
        
        
        function GetOrdersList(){
    
            global $db;

            /*$sql = " SELECT specification.intSRNO, orders.intStyleId
                     FROM specification INNER JOIN orders ON specification.intStyleId = orders.intStyleId
                          INNER JOIN fr_orderstransfer ON orders.intStyleId = fr_orderstransfer.intStyleId
                     WHERE fr_orderstransfer.booTransfer = '0' 
                     ORDER BY specification.intSRNO  ";*/
            
            $sql = " SELECT specification.intSRNO, orders.intStyleId
                    FROM specification INNER JOIN orders ON specification.intStyleId = orders.intStyleId
                    WHERE specification.intSRNO >= '18000'
                    ORDER BY specification.intSRNO ";

            $_rsOrdersList = $db->RunQuery($sql);

            return $_rsOrdersList;


        }
        
       	
}




?>