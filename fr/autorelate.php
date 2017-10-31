<?php
session_start();
//include "../Connector.php";
include "../autoconnect.php";
include "classCSV.php";

$classCSV  = new CSVClass();

# ===========================
# Initialize RELATE.CSV # 
# ===========================
$fRelate = "RELATE.CSV";
# ===========================
# Set header information to the 'RELATE' file
#============================
$_arrRelateHeader = array("O.HOST_ORDER", "O.CODE", "END");
# ============================
$_arrRelateCSV[0] = $_arrRelateHeader;
# 

$rsOrdersList = $classCSV->GetOrdersList();

while($rowOrdersList = mysql_fetch_array($rsOrdersList)){
    
    $styleCode = $rowOrdersList[1];
    
    $_rsOrder = $classCSV->GetDetailsForOrder($styleCode);
    
    $_intStylePartCount = mysql_num_rows($_rsOrder);
    
    if($_intStylePartCount>1){
    
        while($rowOrder = mysql_fetch_array($_rsOrder)){
            
            $_rsDeliveries = $classCSV->GetDeliveryDetails($rowOrder['intStyleId']);
            
            while($rowDeliveries = mysql_fetch_array($_rsDeliveries)){
                
                $strOrderCode = "";
                                
                if($rowDeliveries['intBPO'] != $rowDeliveries['prvBPO']){
                    
                    $hostOrder = "SC".$rowOrder['intSRNO'].'::'.$rowOrder["strPartName"].'::'.$rowDeliveries['prvBPO'];
                    $newOrder  = "SC".$rowOrder['intSRNO'].'::'.$rowOrder["strPartName"].'::'.$rowDeliveries['intBPO'];

                    $_arrRelateDeails[0] = $hostOrder;
                    $_arrRelateDeails[1] = $newOrder;
                    $_arrRelateDeails[2] = "END";

                    $_arrRelateCSV[$iRelatePos] = $_arrRelateDeails;
                    $iRelatePos++;
                    
                }
            }
        }
        
    }else{
        
        while($rowOrder = mysql_fetch_array($_rsOrder)){
            
            $_rsDeliveries = $classCSV->GetDeliveryDetails($rowOrder['intStyleId']);
            
            while($rowDeliveries = mysql_fetch_array($_rsDeliveries)){
                
                if($rowDeliveries['intBPO'] != $rowDeliveries['prvBPO']){
                                
                    //$hostOrder = "SC".$rowOrder['intSRNO'].'::'.ConvertDateFormat("UK", $rowDeliveries['estimatedDate']);  
                    $hostOrder = "SC".$rowOrder['intSRNO'].'::'.$rowDeliveries['prvBPO'];
                    $newOrder  = "SC".$rowOrder['intSRNO'].'::'.$rowDeliveries['intBPO'];


                    $_arrRelateDeails[0] = $hostOrder;
                    $_arrRelateDeails[1] = $newOrder;
                    $_arrRelateDeails[2] = "END";

                    $_arrRelateCSV[$iRelatePos] = $_arrRelateDeails;
                    $iRelatePos++;
                }
                
            }
            
        }
        
    }
}

$output = fopen('php://memory','w');

	
foreach($_arrRelateCSV as $rowOrders){
		
	fputcsv($output, $rowOrders);
}

fseek($output,0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment;filename='.$fRelate);
header('Cache-Control: max-age=0');
fpassthru($output);


# Function Reagion
# =================================





?>
