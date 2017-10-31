<?php

session_start();
//include "../Connector.php";
include "../autoconnect.php";
include "classCSV.php";

$classCSV  = new CSVClass();

$fOrders = "ORDERS.CSV";
$_arrOrderHeader = array("O.CODE","O.PROD","O.DESCRIP", "O.CUST", "O.TIME", "O.STATUS", "O^DD:1", "O.CONTRACT_QTY", "O^DQ:1", "O^DR:1", "O.SPRICE", "O.SCOST", "O.UDCosted Effi.", "O.UDCosted SMV", "O.UDGMT FOB", "O.UDCM per SMV", "O.EFFY", "O.SALES_YEAR", "O.SALES_SEASON", "O.TRANS_OVERRIDE", "O.FvCM per SMV", "O.FvGMT CM", "O.UDLabour Cost", "O.UDGMT CM", "O.EVBASE", "O.UdPLANNED FTY", "O.UdPO Number", "O.UdSC Number", "END");

$_arrOrderForCSV[0] = $_arrOrderHeader;
$iArrayPossition = 1;

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
                
                $iDeliveryYear = substr($rowDeliveries['estimatedDate'],0,4);
                                
                $strOrderCode = "SC".$rowOrder['intSRNO'].'::'.$rowOrder["strPartName"].'::'.$rowDeliveries['intBPO'];
                
                $_arrOrderDetails[0] = $strOrderCode;
                $_arrOrderDetails[1] = GetProduct($rowOrder['intStyleId'])." - ".$rowOrder["strPartName"]; # Get style id as a product
                $_arrOrderDetails[2] = $rowOrder['strDescription'];
                $_arrOrderDetails[3] = $rowOrder['strName']; 
                $_arrOrderDetails[4] = $rowDeliveries['EventName'];
                if(preg_match('/TBA/', $rowDeliveries['intBPO'])){                                  
                   $_arrOrderDetails[5] = 'S';
                }else{                                  
                   $_arrOrderDetails[5] = 'F';
                }
                $_arrOrderDetails[6] = ConvertDateFormat("UK", $rowDeliveries['estimatedDate']);	
                $_arrOrderDetails[7] = $rowDeliveries['dblQty'];
                $_arrOrderDetails[8] = $rowDeliveries['dblQty'];
                $_arrOrderDetails[9] = $rowDeliveries['intBPO'];
                $_arrOrderDetails[10] = $rowOrder['reaFOB'];			
                $_arrOrderDetails[11] = 0;	
                $_arrOrderDetails[12] = $rowOrder['reaEfficiencyLevel'];

                $_arrOrderDetails[13] = $rowOrder['dblsmv'];
                $_arrOrderDetails[14] = $rowOrder['reaFOB'];

                $_arrOrderDetails[15] = $rowOrder['reaSMVRate'];
                $_arrOrderDetails[16] = 100; //$rowOrder['reaEfficiencyLevel']; 
                $_arrOrderDetails[17] = $iDeliveryYear;;
                $_arrOrderDetails[18] = $rowOrder["strSeason"];				
                $_arrOrderDetails[19] = $rowDeliveries["strDescription"]; 
                $_arrOrderDetails[20] = $rowOrder['reaSMVRate']; 
                $_arrOrderDetails[21] = $rowOrder['reaCostPerMinute'];
                $_arrOrderDetails[22] = $rowOrder['reaLabourCost'];  
                $_arrOrderDetails[23] = $rowOrder['reaCostPerMinute'];
                $_arrOrderDetails[24] = ConvertDateFormat("UK",$rowOrder['dtPCD']);
                $_arrOrderDetails[25] = $rowDeliveries['Location'];
                $_arrOrderDetails[26] = $rowDeliveries['intBPO'];
                $_arrOrderDetails[27] = $rowOrder['intSRNO'];                                
                $_arrOrderDetails[28] = "END";


                $_arrOrderForCSV[$iArrayPossition] = $_arrOrderDetails;	
                $iArrayPossition++;
                
                
            }
            
        }
    }else{
        
        
        while($rowOrder = mysql_fetch_array($_rsOrder)){
            
            $dblSMV = $rowOrder['dblsmv'];
			
            $_rsDeliveries = $classCSV->GetDeliveryDetails($rowOrder['intStyleId']);
            
            while($rowDeliveries = mysql_fetch_array($_rsDeliveries)){
                
                $strOrderCode = "";
                $iDeliveryYear = substr($rowDeliveries['estimatedDate'],0,4);
                
                $strOrderCode = "SC".$rowOrder['intSRNO'].'::'.$rowDeliveries['intBPO'];
                
                $_arrOrderDetails[0] = $strOrderCode;
                $_arrOrderDetails[1] = GetProduct($rowOrder['intStyleId']); # Get style id as a product
                $_arrOrderDetails[2] = $rowOrder['strDescription'];
                $_arrOrderDetails[3] = $rowOrder['strName']; 
                $_arrOrderDetails[4] = $rowDeliveries['EventName'];
                if(preg_match('/TBA/', $rowDeliveries['intBPO'])){                                  
                   $_arrOrderDetails[5] = 'S';
                }else{                                  
                   $_arrOrderDetails[5] = 'F';
                }
                $_arrOrderDetails[6] = ConvertDateFormat("UK", $rowDeliveries['estimatedDate']);	
                $_arrOrderDetails[7] = $rowDeliveries['dblQty'];
                $_arrOrderDetails[8] = $rowDeliveries['dblQty'];
                $_arrOrderDetails[9] = $rowDeliveries['intBPO'];
                $_arrOrderDetails[10] = $rowOrder['reaFOB'];			
                $_arrOrderDetails[11] = 0;	
                $_arrOrderDetails[12] = $rowOrder['reaEfficiencyLevel'];

                $_arrOrderDetails[13] = $rowOrder['dblsmv'];
                $_arrOrderDetails[14] = $rowOrder['reaFOB'];

                $_arrOrderDetails[15] = $rowOrder['reaSMVRate'];
                $_arrOrderDetails[16] = 100;//$rowOrder['reaEfficiencyLevel']; 
                $_arrOrderDetails[17] = $iDeliveryYear;;
                $_arrOrderDetails[18] = $rowOrder["strSeason"];				
                $_arrOrderDetails[19] = $rowDeliveries["strDescription"]; 
                $_arrOrderDetails[20] = $rowOrder['reaSMVRate']; 
                $_arrOrderDetails[21] = $rowOrder['reaCostPerMinute'];
                $_arrOrderDetails[22] = $rowOrder['reaLabourCost'];  
                $_arrOrderDetails[23] = $rowOrder['reaCostPerMinute']; 
                $_arrOrderDetails[24] = ConvertDateFormat("UK",$rowOrder['dtPCD']);
                $_arrOrderDetails[25] = $rowDeliveries['Location'];
                $_arrOrderDetails[26] = $rowDeliveries['intBPO'];
                $_arrOrderDetails[27] = $rowOrder['intSRNO'];                                
                $_arrOrderDetails[28] = "END";


                $_arrOrderForCSV[$iArrayPossition] = $_arrOrderDetails;	
                $iArrayPossition++;
                
            }
            
        }
        
    }
        
}

$output = fopen('php://memory','w');

	
foreach($_arrOrderForCSV as $rowOrders){
		
	fputcsv($output, $rowOrders);
}

fseek($output,0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment;filename='.$fOrders);
header('Cache-Control: max-age=0');
fpassthru($output);


#Function reagion
# ========================

function GetProduct($prmStyleId){
	
    global $db;

    $strSql = " SELECT strStylePrefix FROM fr_orderstransfer WHERE intStyleId = '$prmStyleId' ";

    $result = $db->RunQuery($strSql);

    while($rowProduct = mysql_fetch_array($result)){

            return $rowProduct['strStylePrefix'];	
    }
	
}

function ConvertDateFormat($FormatType, $DateValue){
	
    $FormattedDateValue='';
    $arrayDateValue = explode('-', $DateValue);

    switch($FormatType){

        case "UK":
            $FormattedDateValue = $arrayDateValue[2]."/".$arrayDateValue[1]."/".$arrayDateValue[0];
            if(($FormattedDateValue == '//') || ($FormattedDateValue == '00/00/0000')) {$FormattedDateValue = '';}

        break;	

    }

    return $FormattedDateValue;
}
