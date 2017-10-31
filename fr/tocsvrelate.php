<?php

session_start();
include "../Connector.php";
include "classCSV.php";

$classCSV  = new CSVClass();

# Get parameter values
//$_intMaxDeliveries = $_GET['nodeli'];
$_arrStyleCodes = $_GET['arrstyles'];


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

$_arrStyleCodesList = preg_split('/[,]/', $_arrStyleCodes);

# Get length of the style code array
$_intStyleCodeLength = count($_arrStyleCodesList);

$iRelatePos      = 1;

for($j=0;$j<$_intStyleCodeLength;$j++){
	
	$_arrRelateDeails = array();
	
	# Get the order details
	
	$_rsOrder = $classCSV->GetDetailsForOrder($_arrStyleCodesList[$j]);
	
	$iStyleCode = $_arrStyleCodesList[$j];
	
	$_intStylePartCount = mysql_num_rows($_rsOrder);
	
	if($_intStylePartCount>1){
		
		while($rowOrder = mysql_fetch_array($_rsOrder)){
			
			//Get the delivery details for the given style
			//$_rsDeliveries = GetDeliveryDetails($rowOrder['intStyleId']);
			$_rsDeliveries = $classCSV->GetDeliveryDetails($rowOrder['intStyleId']);
			
			$_intTransferCount = $rowOrder['intTransferCount'];
			
			while($rowDeliveries = mysql_fetch_array($_rsDeliveries)){
                            
                                # ============================================================
                                # Add On - 06/27/2016
                                # Add By - Nalin Jayakody
                                # Adding - Add estimated date to the order code instead of buyer po number for TBA Orders
                                # =============================================================
                                $strOrderCode = "";
                                
                                if($rowDeliveries['intBPO'] != $rowDeliveries['prvBPO']){
                                    
                                    # =============================================================================
                                    # Comment On - 07/21/2016
                                    # Comment By - Nalin Jayakody
                                    # Comment For - To add previous buyer po number for TBA orders instead of add estimated date
                                    # ==========================================================================================
                                    /* $hostOrder = "SC".$rowOrder['intSRNO'].'::'.$rowOrder["strPartName"].'::'.ConvertDateFormat("UK", $rowDeliveries['estimatedDate']); */
                                    # ==========================================================================================
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
			
						
			$_intTransferCount = $rowOrder['intTransferCount'];
			
			//Get the delivery details for the given style
			//$_rsDeliveries = GetDeliveryDetails($rowOrder['intStyleId']);
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



//print_r($_arrOrderForCSV);

$output = fopen('php://memory','w');

	
foreach($_arrRelateCSV as $rowOrders){
		
	fputcsv($output, $rowOrders);
}

fseek($output,0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment;filename='.$fRelate);
header('Cache-Control: max-age=0');
fpassthru($output);



function GetProduct($prmStyleId){
	
	global $db;
	
	$strSql = " SELECT strStylePrefix FROM fr_orderstransfer WHERE intStyleId = '$prmStyleId' ";
	
	$result = $db->RunQuery($strSql);
	
	while($rowProduct = mysql_fetch_array($result)){
		
		return $rowProduct['strStylePrefix'];	
	}
	
}

function SetOrderTransferStatus($prmStyleId){
	
	global $db;
	
	$strSql = " UPDATE fr_orderstransfer SET booTransfer = 1 WHERE intStyleId = '$prmStyleId'";
	
	$res = $db->RunQuery($strSql);
	
}

function ConvertDateFormat($FormatType, $DateValue){
	
	$FormattedDateValue='';
	$arrayDateValue = explode('-', $DateValue);
	
	switch($FormatType){
	
		case "UK":
			$FormattedDateValue = $arrayDateValue[2]."/".$arrayDateValue[1]."/".$arrayDateValue[0];
		break;	
		
	}
	
	return $FormattedDateValue;
}

function UpdateTransferCount($prmStyleCode){
	
	global $db;
	
	$sql = " select intTransferCount from fr_orderstransfer where intStyleId = '$prmStyleCode' ";	
	
	$res = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($res)){
		$_iTransferCount = $row['intTransferCount'];
	}
	
	$_iTransferCount = $_iTransferCount + 1;
	
	$sqlUpdate = " update fr_orderstransfer set intTransferCount = '$_iTransferCount ' where intStyleId = '$prmStyleCode' ";
	
	$res = $db->RunQuery($sqlUpdate);
	
}

?>