<?php

session_start();
include "../Connector.php";
include "classCSV.php";

$classCSV  = new CSVClass();

# Get parameter values
$_intMaxDeliveries = $_GET['nodeli'];
$_arrStyleCodes = $_GET['arrstyles'];

$fOrders = "ORDERS.CSV";

$_arrStyleCodesList = preg_split('/[,]/', $_arrStyleCodes);

# Get length of the style code array
$_intStyleCodeLength = count($_arrStyleCodesList);

# Create header section of the ORDERS.CSV	
# Add header details as a array to the array variable
$_arrOrderHeader = array("O.CODE","O.PROD","O.DESCRIP","O^DD:1","O^DR:1","O^DQ:1");

for($i=1;$i<$_intMaxDeliveries;$i++){
		
	$_in = (int)$i+1;
	$_strDQ = "O^DD:".$_in;	
	$_strDD = "O^DR:".$_in;
	$_strDR = "O^DQ:".$_in;
	
	$_iCount = count($_arrOrderHeader);		
	array_splice($_arrOrderHeader,$_iCount,0,$_strDQ);
	
	$_iCount = count($_arrOrderHeader);
	array_splice($_arrOrderHeader,$_iCount,0,$_strDD);
	
	$_iCount = count($_arrOrderHeader);
	array_splice($_arrOrderHeader,$_iCount,0,$_strDR);
}
	
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

$_iCount = count($_arrOrderHeader);
array_splice($_arrOrderHeader,$_iCount,0,"O.ORDER QTY");
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
		
			$_arrOrderDetails[0] = "SC".$rowOrder['intSRNO']." - ".$rowOrder["strPartName"];
			$_arrOrderDetails[1] = GetProduct($rowOrder['intStyleId'])." - ".$rowOrder["strPartName"]; # Get style id as a product
			$_arrOrderDetails[2] = $rowOrder['strDescription'];
			
			
			//Get the delivery details for the given style
			//$_rsDeliveries = GetDeliveryDetails($rowOrder['intStyleId']);
			$_rsDeliveries = $classCSV->GetDeliveryDetails($rowOrder['intStyleId']);
			$y = 3;
			
			while($rowDeliveries = mysql_fetch_array($_rsDeliveries)){
				
				$_arrOrderDetails[$y] = ConvertDateFormat("UK", $rowDeliveries['estimatedDate']);						
				$y++;					
				$_arrOrderDetails[$y] = $rowDeliveries['intBPO'];						
				$y++;
				$_arrOrderDetails[$y] = $rowDeliveries['dblQty'];						
				$y++;
			}	
			
			$_iDeliveryCount = mysql_num_rows($_rsDeliveries);
			
			$_iPostPos = (((int)$_intMaxDeliveries * 3)+1)-1;
			
			if($_iDeliveryCount != $_intMaxDeliveries){
			
				for($x=$y;$x<$_iPostPos;$x++){
					
					$_arrOrderDetails[$x] = "";
				}
			}
			
			$_intTransferCount = $rowOrder['intTransferCount']; 
			
			$_iPostPos = $y+1;
		
			$_arrOrderDetails[$_iPostPos] = $rowOrder['strName'];			
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = 0;
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = 0;			
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = $rowOrder['reaEfficiencyLevel'];		
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = $rowOrder['dblsmv'];			
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = $rowOrder['reaFOB'];
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = 0;
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = "";
			$_iPostPos ++;
			if($_intTransferCount == 0)
				$_arrOrderDetails[$_iPostPos] = $rowOrder['reaEfficiencyLevel'];
			else
				$_arrOrderDetails[$_iPostPos] = "";	
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = 0;
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = 0;
			
			$_arrOrderForCSV[$iArrayPossition] = $_arrOrderDetails;	
			$iArrayPossition++;
			
		}
			
	
	}else{
		
		while($rowOrder = mysql_fetch_array($_rsOrder)){
		
			$_arrOrderDetails[0] = "SC".$rowOrder['intSRNO'];
			$_arrOrderDetails[1] = GetProduct($rowOrder['intStyleId']); # Get style id as a product
			$_arrOrderDetails[2] = $rowOrder['strDescription'];
			
			
			//Get the delivery details for the given style
			//$_rsDeliveries = GetDeliveryDetails($rowOrder['intStyleId']);
			$_rsDeliveries = $classCSV->GetDeliveryDetails($rowOrder['intStyleId']);
			
			$y = 3;
			
			while($rowDeliveries = mysql_fetch_array($_rsDeliveries)){
				
				$_arrOrderDetails[$y] = ConvertDateFormat("UK", $rowDeliveries['estimatedDate']);						
				$y++;					
				$_arrOrderDetails[$y] = $rowDeliveries['intBPO'];						
				$y++;
				$_arrOrderDetails[$y] = $rowDeliveries['dblQty'];						
				$y++;
			}	
			
			$_iDeliveryCount = mysql_num_rows($_rsDeliveries);
			
			$_iPostPos = (((int)$_intMaxDeliveries * 3)+1)-1;
			
			if($_iDeliveryCount != $_intMaxDeliveries){
			
				for($x=$y;$x<$_iPostPos;$x++){
					
					$_arrOrderDetails[$x] = "";
				}
			
			
			}
			
			$_intTransferCount = $rowOrder['intTransferCount'];
			
			$_iPostPos = $y + 1;
		
			$_arrOrderDetails[$_iPostPos] = $rowOrder['strName'];			
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = 0;
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = 0;			
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = $rowOrder['reaEfficiencyLevel'];		
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = $rowOrder['dblsmv'];			
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = $rowOrder['reaFOB'];
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = 0;
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = "";
			$_iPostPos ++;
			if($_intTransferCount == 0)
				$_arrOrderDetails[$_iPostPos] = $rowOrder['reaEfficiencyLevel'];
			else
				$_arrOrderDetails[$_iPostPos] = "";	
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = 0;
			$_iPostPos ++;
			$_arrOrderDetails[$_iPostPos] = 0;
			
		}
		
		$_arrOrderForCSV[$iArrayPossition] = $_arrOrderDetails;	
		$iArrayPossition++;
		
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


function GetDetailsForOrder($prmStyleCode){
	
	global $db;
	
	$strSql = " SELECT
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
fr_orderstransfer.intTransferCount
FROM	
specification
Inner Join orders ON specification.intStyleId = orders.intStyleId
Inner Join stylepartdetails ON orders.intStyleId = stylepartdetails.intStyleId
Left Join productcategory ON orders.productSubCategory = productcategory.intCatId
Inner Join fr_orderstransfer ON orders.intStyleId = fr_orderstransfer.intStyleId
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
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
	
	$strSql = " SELECT * FROM deliveryschedule where intStyleId = '$prmStyleId' order by estimatedDate ";
	
	$result = $db->RunQuery($strSql);
	
	return $result;
	
}

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