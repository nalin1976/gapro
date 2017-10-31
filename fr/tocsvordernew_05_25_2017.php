<?php

session_start();
include "../Connector.php";
include "classCSV.php";

$classCSV  = new CSVClass();

# Get parameter values
//$_intMaxDeliveries = $_GET['nodeli'];
$_arrStyleCodes = $_GET['arrstyles'];

$fOrders = "ORDERS.CSV";

$_arrStyleCodesList = preg_split('/[,]/', $_arrStyleCodes);

# Get length of the style code array
$_intStyleCodeLength = count($_arrStyleCodesList);

# Create header section of the ORDERS.CSV	
# Add header details as a array to the array variable
# 
//$_arrOrderHeader = array("O.CODE","O.PROD","O.DESCRIP","O^DD:1","O^DR:1","O^DQ:1");

$_arrOrderHeader = array("O.CODE","O.PROD","O.DESCRIP", "O.CUST", "O.TIME", "O.STATUS", "O^DD:1", "O.CONTRACT_QTY", "O^DQ:1", "O^DR:1");
	
/*$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.CUST"); #6 */

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.SPRICE"); #10

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.SCOST"); #11

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UDCosted Effi."); #11

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UDCosted SMV"); #12

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UDGMT FOB"); #13

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UDCM per SMV"); #14

/*$_iCount = count($_arrOrderHeader);
//array_splice($_arrOrderHeader,$_iCount,0,"O.TIME"); #13 */

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.EFFY"); #15

/*$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.Labour Cost"); #15

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.GMT CM"); #16

$_iCount = count($_arrOrderHeader);
//array_splice($_arrOrderHeader,$_iCount,0,"O.STATUS"); #17

$_iCount = count($_arrOrderHeader);
//array_splice($_arrOrderHeader,$_iCount,0,"O.CONTRACT_QTY"); #18

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UDCM per SMV"); #19*/

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.SALES_YEAR"); #16

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.SALES_SEASON"); #17

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.TRANS_OVERRIDE"); #18

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.FvCM per SMV"); #19

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.FvGMT CM"); #20

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UDLabour Cost"); #21

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UDGMT CM"); #22

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.EVBASE"); #23

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UdPLANNED FTY"); #24

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UdPO Number"); #25

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UdSC Number"); #26

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"END"); #27

# End of order.csv heading section

# Add order header details to the csv array
$_arrOrderForCSV[0] = $_arrOrderHeader;
$iArrayPossition = 1;


for($j=0;$j<$_intStyleCodeLength;$j++){
	
	$_arrOrderDetails = array();
        $_arrRelateDeails = array();
	
	# Get the order details
	//$_rsOrder = GetDetailsForOrder($_arrStyleCodesList[$j]);
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
                                
                                
                            
                                /*if(preg_match('/TBA/', $rowDeliveries['intBPO'])){
                                    
                                # =============================================================================
                                # Comment On - 07/21/2016
                                # Comment By - Nalin Jayakody
                                # Comment For - To add previous buyer po number for TBA orders instead of add estimated date
                                # ========================================================================================== 
                                     
                                //$strOrderCode = "SC".$rowOrder['intSRNO'].'::'.$rowOrder["strPartName"].'::'.ConvertDateFormat("UK", $rowDeliveries['estimatedDate']);
                                    $strOrderCode = "SC".$rowOrder['intSRNO'].'::'.$rowOrder["strPartName"].'::'.$rowDeliveries['prvBPO'];   
                                   
                                }else{
                                    $strOrderCode = "SC".$rowOrder['intSRNO'].'::'.$rowOrder["strPartName"].'::'.$rowDeliveries['intBPO'];
                                    
                                }*/
                                
                                $iDeliveryYear = substr($rowDeliveries['estimatedDate'],0,4);
                                
                                $strOrderCode = "SC".$rowOrder['intSRNO'].'::'.$rowOrder["strPartName"].'::'.$rowDeliveries['intBPO'];
				//$_arrOrderDetails[0] = "SC".$rowOrder['intSRNO']." - ".$rowOrder["strPartName"].'::'.$rowDeliveries['intBPO'];
                                
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
			
			$_intTransferCount = $rowOrder['intTransferCount'];
			
			//Get the delivery details for the given style
			//$_rsDeliveries = GetDeliveryDetails($rowOrder['intStyleId']);
			$_rsDeliveries = $classCSV->GetDeliveryDetails($rowOrder['intStyleId']);
			
			while($rowDeliveries = mysql_fetch_array($_rsDeliveries)){
                            
                                # ============================================================
                                # Add On - 06/27/2016
                                # Add By - Nalin Jayakody
                                # Adding - Add estimated date to the order code instead of buyer po number for TBA Orders
                                # =============================================================
                                $strOrderCode = "";
                                $iDeliveryYear = substr($rowDeliveries['estimatedDate'],0,4);
                                # =============================================================================
                                # Comment On - 07/21/2016
                                # Comment By - Nalin Jayakody
                                # Comment For - To add previous buyer po number for TBA orders instead of add estimated date
                                # ========================================================================================== 
                            
                                /*if(preg_match('/TBA/', $rowDeliveries['intBPO'])){
                                   //$strOrderCode = "SC".$rowOrder['intSRNO'].'::'.ConvertDateFormat("UK", $rowDeliveries['estimatedDate']);
                                  
                                }else{
                                   $strOrderCode = "SC".$rowOrder['intSRNO'].'::'.$rowDeliveries['intBPO'];
                                   
                                }*/
                                
                                # ==============================================================================================
                                $strOrderCode = "SC".$rowOrder['intSRNO'].'::'.$rowDeliveries['intBPO'];
		
			/*	//$_arrOrderDetails[0] = "SC".$rowOrder['intSRNO'].'::'.$rowDeliveries['intBPO'];
                                $_arrOrderDetails[0] = $strOrderCode;
				$_arrOrderDetails[1] = GetProduct($rowOrder['intStyleId']); # Get style id as a product
				$_arrOrderDetails[2] = $rowOrder['strDescription'];
				$_arrOrderDetails[3] = ConvertDateFormat("UK", $rowDeliveries['estimatedDate']);
				$_arrOrderDetails[4] = $rowDeliveries['intBPO'];
				$_arrOrderDetails[5] = $rowDeliveries['dblQty'];
				$_arrOrderDetails[6] = $rowOrder['strName'];
				$_arrOrderDetails[7] = 0;
				$_arrOrderDetails[8] = 0;
				$_arrOrderDetails[9] = $rowOrder['reaEfficiencyLevel'];
				$_arrOrderDetails[10] = $dblSMV;
				$_arrOrderDetails[11] = $rowOrder['reaFOB'];
				$_arrOrderDetails[12] = $dblSMV;
				$_arrOrderDetails[13] = 0;
				if($_intTransferCount == 0)
					$_arrOrderDetails[14] = $rowOrder['reaEfficiencyLevel'];
				else
					$_arrOrderDetails[14] = "";	
					
				$_arrOrderDetails[15] = 0;
				$_arrOrderDetails[16] = 0;
                                if(preg_match('/TBA/', $rowDeliveries['intBPO'])){                                  
                                   $_arrOrderDetails[17] = 'S';
                                }else{                                  
                                   $_arrOrderDetails[17] = 'F';
                                }
                                $_arrOrderDetails[18] = $rowDeliveries['dblQty'];
                                $_arrOrderDetails[19] = $rowOrder['reaSMVRate'];
                                $_arrOrderDetails[20] = $rowOrder['reaLabourCost'];
                                $_arrOrderDetails[21] = $rowOrder['reaCostPerMinute'];
				$_arrOrderDetails[22] = "END"; */
                                
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
	
	
	
	SetOrderTransferStatus($iStyleCode);
	
	UpdateTransferCount($iStyleCode);
}



//print_r($_arrOrderForCSV);

$output = fopen('php://memory','w');

	
foreach($_arrOrderForCSV as $rowOrders){
		
	fputcsv($output, $rowOrders);
}

fseek($output,0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment;filename='.$fOrders);
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