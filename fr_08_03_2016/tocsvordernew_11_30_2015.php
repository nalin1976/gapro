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
$_arrOrderHeader = array("O.CODE","O.PROD","O.DESCRIP","O^DD:1","O^DR:1","O^DQ:1");
	
$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.CUST");

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.SPRICE");

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.SCOST");

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UDCosted Effi.");

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UDCosted SMV");

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UDGMT FOB");

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.UDCM per SMV");

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.TIME");

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.EFFY");

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.Labour Cost");

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.GMT CM");
# End of order.csv heading section

# Add order header details to the csv array
$_arrOrderForCSV[0] = $_arrOrderHeader;
$iArrayPossition = 1;

for($j=0;$j<$_intStyleCodeLength;$j++){
	
	$_arrOrderDetails = array();
	
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
		
				$_arrOrderDetails[0] = "SC".$rowOrder['intSRNO'].'::'.$rowDeliveries['intBPO'];" - ".$rowOrder["strPartName"];
				$_arrOrderDetails[1] = GetProduct($rowOrder['intStyleId'])." - ".$rowOrder["strPartName"]; # Get style id as a product
				$_arrOrderDetails[2] = $rowOrder['strDescription'];
				$_arrOrderDetails[3] = ConvertDateFormat("UK", $rowDeliveries['estimatedDate']);	
				$_arrOrderDetails[4] = $rowDeliveries['intBPO'];
				$_arrOrderDetails[5] = $rowDeliveries['dblQty'];
				$_arrOrderDetails[6] = $rowOrder['strName'];
				$_arrOrderDetails[7] = 0;
				$_arrOrderDetails[8] = 0;				
				$_arrOrderDetails[9] = $rowOrder['reaEfficiencyLevel'];	
				$_arrOrderDetails[10] = $rowOrder['dblsmv'];	
				$_arrOrderDetails[11] = $rowOrder['reaFOB'];
				$_arrOrderDetails[12] = 0; 
				$_arrOrderDetails[13] = "";
				if($_intTransferCount == 0)
					$_arrOrderDetails[14] = $rowOrder['reaEfficiencyLevel'];
				else
					$_arrOrderDetails[14] = "";	
				
				$_arrOrderDetails[15] = 0;				
				$_arrOrderDetails[16] = 0;
				
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
		
				$_arrOrderDetails[0] = "SC".$rowOrder['intSRNO'].'::'.$rowDeliveries['intBPO'];
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