<?php
session_start();
include "../Connector.php";	

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$request = $_GET['request'];

if($request=="orderlist"){
	
	/*header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/
	
	$ResponseXML .= "<orderslist>";
	
    //$strsql = " SELECT * FROM specification ";
	$strsql = " SELECT
orders.intStyleId,
orders.strStyle,
specification.intSRNO
FROM
specification
Inner Join orders ON specification.intStyleId = orders.intStyleId
WHERE intStatus = 11 AND orders.intStyleId NOT IN ( SELECT intStyleId FROM fr_orderstransfer  )
ORDER BY intSRNO  ";
	 
	$result = $db->RunQuery($strsql);
	
	while($row=mysql_fetch_array($result)){
	
		$ResponseXML .= "<scno><![CDATA[" . $row["intSRNO"]. "]]></scno>\n";	
		$ResponseXML .= "<styleCode><![CDATA[" . $row["intStyleId"]. "]]></styleCode>\n";	
		$ResponseXML .= "<styleID><![CDATA[" . $row["strStyle"]. "]]></styleID>\n";	
		
	}
	$ResponseXML .= "</orderslist>";
	
	echo $ResponseXML;
}

if($request=="orderCount"){
	
	$_intOrderCnt = 0;
	
	$ResponseXML .= "<orderscount>";
		
    //$strsql = " SELECT count(intSRNO) as NoOfOrders FROM specification ";
	$strsql = " SELECT count(specification.intSRNO) as NoOfOrders
FROM
specification
Inner Join orders ON specification.intStyleId = orders.intStyleId
WHERE intStatus = 11 AND orders.intStyleId NOT IN ( SELECT intStyleId FROM fr_orderstransfer  )
ORDER BY intSRNO ";
	 
	$result = $db->RunQuery($strsql);
	
	while($row=mysql_fetch_array($result)){
			
		$_intOrderCnt = $row["NoOfOrders"];	
		
	}
	
	$ResponseXML .= "<NoOfOrders><![CDATA[" . $_intOrderCnt . "]]></NoOfOrders>\n";
	$ResponseXML .= "</orderscount>";
	
	echo $ResponseXML;
}

if($request=="insertOrder"){
		
	$_intStyleCode = $_GET['stylecode'];
	$_strStylePrefix = $_GET['stylePrefix'];
	
	$strsql = " INSERT INTO fr_orderstransfer(intStyleId, booTransfer, strStylePrefix) VALUES($_intStyleCode,0, '$_strStylePrefix') ";
	 
	#Insert orders 
	$result = $db->ExecuteQuery($strsql);
	
	#Check if style prefix exist
	$strSql = " SELECT * FROM fr_producttransferlist WHERE strStylePrefix = '".$_strStylePrefix."'";
	
	$resStylePrefix = $db->RunQuery($strSql);
	
	if(mysql_num_rows($resStylePrefix)<=0){
		
		$strSqlInsertPrefix = " INSERT INTO fr_producttransferlist(intStyleId, strStylePrefix, booTransfered)  VALUES ($_intStyleCode, '$_strStylePrefix', 0) ";
		
		$resInsertPrefix = $db->ExecuteQuery($strSqlInsertPrefix);
		
	}
	
	echo $strSqlInsertPrefix;
	
}

if($request=="getNoTrList"){
	
	/*header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/
	
	$ResponseXML .= "<TransferOrdersList>";
	
	$strsql = " SELECT specification.intSRNO, orders.strStyle, orders.intQty, orders.intStyleId, buyers.strName
FROM
orders
Inner Join specification ON specification.intStyleId = orders.intStyleId
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
Inner Join fr_orderstransfer ON orders.intStyleId = fr_orderstransfer.intStyleId
WHERE
fr_orderstransfer.booTransfer =  '0' 
ORDER BY
specification.intSRNO DESC";

        
# ==============================================
# Add On - 11/03/2016 
# Add By - Nalin Jayakody
# Add For - Exculde Intimates orders from Order List request by Lakmal in planning
# ==============================================  
        
# ==============================================
# Add On - 05/31/2016 
# Add By - Nalin Jayakody
# Add For - Get Intimates orders for Order List request by Sithum in planning
#  //AND orders.intCompanyID <> '15'
# ==============================================          
	$result = $db->RunQuery($strsql);
	
	while($row=mysql_fetch_array($result)){
		
		$ResponseXML .= "<scno><![CDATA[" . $row["intSRNO"]. "]]></scno>\n";
		$ResponseXML .= "<styleId><![CDATA[" . $row["strStyle"]. "]]></styleId>\n";
		$ResponseXML .= "<orderQty><![CDATA[" . $row["intQty"]. "]]></orderQty>\n";
		$ResponseXML .= "<styleCode><![CDATA[" . $row["intStyleId"]. "]]></styleCode>\n";
		$ResponseXML .= "<buyerName><![CDATA[" . $row["strName"]. "]]></buyerName>\n";		
	}	
	$ResponseXML .= "</TransferOrdersList>";	
	echo $ResponseXML;
}

if($request=="getMaxDeliveries"){
	
	/*header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/
	
	$ResponseXML .= "<DeliveryCount>";
	
	$_intStyleCode = $_GET['styleCode'];
	
$strSql = " SELECT
Count(deliveryschedule.intStyleId) AS StyleCount
FROM
deliveryschedule
WHERE
deliveryschedule.intStyleId = $_intStyleCode";

	$result = $db->RunQuery($strSql);
	
	while($row=mysql_fetch_array($result)){
		$ResponseXML .= "<NoOfDeliveries><![CDATA[".$row['StyleCount']."]]></NoOfDeliveries>\n";
	}
	
	$ResponseXML .= "</DeliveryCount>";
	
	echo $ResponseXML;

	
	
}

if($request=="createcsv"){
	
	# Get parameter values
	$_intMaxDeliveries = $_GET['nodeli'];
	$_arrStyleCodes = $_GET['arrstyles'];
	
	#Split style codes from parameter
	$_arrStyleCodesList = preg_split('/[,]/', $_arrStyleCodes);	
	
	# Create Header section of the PRODUCTS.CSV file
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=PRODUCTS.CSV");
	header("Pragma: no-cache");
	
	//$_arrHeader = array(array("P.CODE", "P^WC:100", "P^WC:200","P^WC:240","P^WC:250","P.TYPE","P.DESCRIP","P.UDCosted Effi.","P.UDCosted SMV","P^WC:10"));
	
	# Add header information as a array of the product.csv to the array variable
	$_arrHeader = array("P.CODE", "P^WC:100", "P^WC:200","P^WC:240","P^WC:250","P.TYPE","P.DESCRIP","P.UDCosted Effi.","P.UDCosted SMV","P^WC:10");
	
	# Open product.csv
	$output = fopen("PRODUCTS.CSV", "w");	
	
	
	# Create header section of the ORDERS.CSV	
	# Add header details as a array to the array variable
	$_arrOrderHeader = array("O.CODE","O.PROD","O.DESCRIP","O^DD:1","O^DR:1","O^DQ:1");
	
	
	for($i=1;$i<$_intMaxDeliveries-1;$i++){
		
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
	
	# End of order.csv headin section
	
	
	
	# Add order.csv header details of array to the main array variable
	$_arrOrderHeaderForCSV = array($_arrOrderHeader);	
	
	
	# Add product.csv header details array to the main array variable
	$_arrProductForCSV[0] = $_arrHeader;
	
	# Add order header details to the csv array
	$_arrOrderForCSV[0] = $_arrOrderHeader;
	
	# Get length of the style code array
	$_intStyleCodeLength = count($_arrStyleCodesList);
	
	
	$_arrProductDetails = array(); # Initialize product details array
	$_arrOrderDetails = array(); # Initialize order details array
	
	for($i=0;$i<$_intStyleCodeLength;$i++){
	 
	  # Get the product details for give style code
	  $_resProduct = GetDetailsForProduct($_arrStyleCodesList[$i]);
	  
	  $_intStylePartRowCount =  mysql_num_rows($_resProduct);
	  
	  if($_intStylePartRowCount>1){		  	  
		 
		  
	  }else{ # Only 1 style part consist for the order
		  
		   while($row = mysql_fetch_array($_resProduct)){			
				  
			  $_arrProductDetails[0] = $row["strStyle"];
			  $_arrProductDetails[1] = "1";
			  $_arrProductDetails[2] = "1";
			  $_arrProductDetails[3] = "1";
			  $_arrProductDetails[4] = "1";
			  $_arrProductDetails[5] = $row["strCatName"];
			  $_arrProductDetails[6] = $row["strDescription"];
			  $_arrProductDetails[7] = $row["reaEfficiencyLevel"];
			  $_arrProductDetails[8] = $row["dblsmv"];
			  $_arrProductDetails[9] = "1";
		  }
	  }
	  
	  $_arrProductForCSV [$i+1] = $_arrProductDetails;
	  
	  # update the transfer status of the product
	  SetProductTransferStatus($_arrStyleCodesList[$i]);
	  
	}
	
	# Create full PRODUCTS.CSV file
	foreach($_arrProductForCSV as $rowHeader){
		fputcsv($output, $rowHeader);	
	}
	
	# Close opened PRODUCTS.CSV file
	fclose($output);
	
	//print_r($_arrProductForCSV);
	
	for($j=0;$j<$_intStyleCodeLength;$j++){
		
		$_arrOrderDetails = array();
		
		# Get the order details
		$_rsOrder = GetDetailsForOrder($_arrStyleCodesList[$j]);
		
		$_intStylePartCount = mysql_num_rows($_rsOrder);
		
		if($_intStylePartRowCount>1){	
		
		}else{
			
			while($rowOrder = mysql_fetch_array($_rsOrder)){
			
				$_arrOrderDetails[0] = "SC".$rowOrder['intSRNO'];
				$_arrOrderDetails[1] = GetProduct($rowOrder['intStyleId']); # Get style id as a product
				$_arrOrderDetails[2] = $rowOrder['strDescription'];
				
				
				//Get the delivery details for the given style
				$_rsDeliveries = GetDeliveryDetails($rowOrder['intStyleId']);
				
				$y = 3;
				
				while($rowDeliveries = mysql_fetch_array($_rsDeliveries)){
					
					$_arrOrderDetails[$y] = $rowDeliveries['estimatedDate'];						
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
				$_arrOrderDetails[$_iPostPos] = "";
				$_iPostPos ++;
				$_arrOrderDetails[$_iPostPos] = 0;
				$_iPostPos ++;
				$_arrOrderDetails[$_iPostPos] = 0;
				
			}
			
		}	
		
		$_arrOrderForCSV[$j+1] = $_arrOrderDetails;	
	}
	
	# Open orders.csv file
	$_fileOrder = fopen("ORDERS.CSV", "w");
	
	foreach($_arrOrderForCSV as $rowOrders){
		
		fputcsv($_fileOrder, $rowOrders);
	}
	
	# Create order csv header section
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=ORDERS.CSV");
	header('Cache-Control: max-age=0');
	//header("Pragma: no-cache");
	
	echo $_fileOrder;
	//fclose($_fileOrder);
}

if($request=="getDeliveries"){
	
	$ResponseXML .= "<DeliverySchedule>";
	
	$_iStyleCode = $_GET["stylecode"];
	
	$strSql = " SELECT deliveryschedule.intBPO, deliveryschedule.dblQty, deliveryschedule.dtDateofDelivery, ".
	          "        deliveryschedule.estimatedDate, deliveryschedule.dtmHandOverDate ".
              " FROM   deliveryschedule ".
              " WHERE  deliveryschedule.intStyleId =  '$_iStyleCode'";
			  
	$result = $db->RunQuery($strSql);
	
	while($row=mysql_fetch_array($result)){
		$ResponseXML .= "<BuyerPONo><![CDATA[".$row['intBPO']."]]></BuyerPONo>\n";
		$ResponseXML .= "<BuyerPOQty><![CDATA[".$row['dblQty']."]]></BuyerPOQty>\n";
		$ResponseXML .= "<DeliveryDate><![CDATA[".$row['dtDateofDelivery']."]]></DeliveryDate>\n";
		$ResponseXML .= "<EstimateDate><![CDATA[".$row['estimatedDate']."]]></EstimateDate>\n";
		$ResponseXML .= "<HandOverDate><![CDATA[".$row['dtmHandOverDate']."]]></HandOverDate>\n";
	}
	
	$ResponseXML .= "</DeliverySchedule>";
	
	echo $ResponseXML;
}

if($request=="OrdersToRevise"){
	
	/*header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/
	
	$ResponseXML .= "<TransferOrdersList>";
	
	$strsql = " SELECT specification.intSRNO, orders.strStyle, orders.intQty, orders.intStyleId, buyers.strName
FROM
orders
Inner Join specification ON specification.intStyleId = orders.intStyleId
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
Inner Join fr_orderstransfer ON orders.intStyleId = fr_orderstransfer.intStyleId
WHERE
fr_orderstransfer.booTransfer =  '1'
ORDER BY
specification.intSRNO DESC";

	$result = $db->RunQuery($strsql);
	
	while($row=mysql_fetch_array($result)){
		
		$ResponseXML .= "<scno><![CDATA[" . $row["intSRNO"]. "]]></scno>\n";
		$ResponseXML .= "<styleId><![CDATA[" . $row["strStyle"]. "]]></styleId>\n";
		$ResponseXML .= "<orderQty><![CDATA[" . $row["intQty"]. "]]></orderQty>\n";
		$ResponseXML .= "<styleCode><![CDATA[" . $row["intStyleId"]. "]]></styleCode>\n";
		$ResponseXML .= "<buyerName><![CDATA[" . $row["strName"]. "]]></buyerName>\n";		
	}	
	$ResponseXML .= "</TransferOrdersList>";	
	echo $ResponseXML;
}

if($request=="ProductsToRevise"){
	
	/*header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/
	
	$ResponseXML .= "<TransferOrdersList>";
	
	$strsql = " SELECT specification.intSRNO, orders.strStyle, orders.intQty, orders.intStyleId, buyers.strName
FROM
orders
Inner Join specification ON specification.intStyleId = orders.intStyleId
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
Inner Join fr_producttransferlist ON orders.intStyleId = fr_producttransferlist.intStyleId
WHERE
fr_producttransferlist.booTransfered =  '1'
ORDER BY
specification.intSRNO DESC";

	$result = $db->RunQuery($strsql);
	
	while($row=mysql_fetch_array($result)){
		
		$ResponseXML .= "<scno><![CDATA[" . $row["intSRNO"]. "]]></scno>\n";
		$ResponseXML .= "<styleId><![CDATA[" . $row["strStyle"]. "]]></styleId>\n";
		$ResponseXML .= "<orderQty><![CDATA[" . $row["intQty"]. "]]></orderQty>\n";
		$ResponseXML .= "<styleCode><![CDATA[" . $row["intStyleId"]. "]]></styleCode>\n";
		$ResponseXML .= "<buyerName><![CDATA[" . $row["strName"]. "]]></buyerName>\n";		
	}	
	$ResponseXML .= "</TransferOrdersList>";	
	echo $ResponseXML;
}

if($request=="ReviseOrder"){
	
	$_intStyleCode = $_GET["Stylecode"];
	
	ReviseOrder($_intStyleCode);
	
		
}

if($request=="ReviseProduct"){
		
	$_intStyleCode = $_GET["Stylecode"];
	
	ReviseProduct($_intStyleCode);
	ReviseOrder($_intStyleCode);
}


function GetDetailsForProduct($prmStyleCode){
	
	global $db;
	
	$strSql = " SELECT
specification.intSRNO,
orders.strStyle,
orders.strDescription,
orders.intQty,
stylepartdetails.strPartName,
fr_producttransferlist.strStylePrefix,
orders.reaSMV,
orders.reaEfficiencyLevel,
stylepartdetails.dblsmv,
productcategory.strCatName
FROM
specification
Inner Join orders ON specification.intStyleId = orders.intStyleId
Inner Join stylepartdetails ON orders.intStyleId = stylepartdetails.intStyleId
Inner Join fr_producttransferlist ON stylepartdetails.intStyleId = fr_producttransferlist.intStyleId
Left Join productcategory ON orders.productSubCategory = productcategory.intCatId
WHERE
fr_producttransferlist.booTransfered =  '0' AND
orders.intStyleId = ".$prmStyleCode;

$result = $db->RunQuery($strSql);

return $result;

}

function SetProductTransferStatus($prmStyleCode){
	
	global $db;
	
	$strSql = " UPDATE fr_producttransferlist SET booTransfered = 1 WHERE intStyleId = ".$prmStyleCode;
	
	$db->ExecuteQuery($strSql);
}

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
orders.reaFOB
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

function GetProduct($prmStyleId){
	
	global $db;
	
	$strSql = " SELECT strStylePrefix FROM fr_producttransferlist WHERE intStyleId = '$prmStyleId' ";
	
	$result = $db->RunQuery($strSql);
	
	while($rowProduct = mysql_fetch_array($result)){
		
		return $rowProduct['strStylePrefix'];	
	}
	
}

function GetDeliveryDetails($prmStyleId){
	
	global $db;
	
	$strSql = " SELECT * FROM deliveryschedule where intStyleId = '$prmStyleId' ";
	
	$result = $db->RunQuery($strSql);
	
	return $result;
	
}

function ReviseOrder($prmStyleId){
	
	global $db;
	
	$strSql = " UPDATE fr_orderstransfer SET booTransfer = 0  where intStyleId = '$prmStyleId' ";
	
	$result = $db->ExecuteQuery($strSql);
	
}

function ReviseProduct($prmStyleId){
	
	global $db;
	
	$strSql = " UPDATE fr_producttransferlist SET booTransfered = 0 WHERE intStyleId = ".$prmStyleId;
	
	$result = $db->ExecuteQuery($strSql);
	
}

?>