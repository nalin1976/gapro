<?php

session_start();
include "../Connector.php";	

# Get parameter values
$_intMaxDeliveries = $_GET['nodeli'];
$_arrStyleCodes = $_GET['arrstyles'];

$fProduct ="PRODUCTS.CSV";

$_arrStyleCodesList = preg_split('/[,]/', $_arrStyleCodes);

# =============================================================
# Change On - 06/27/2016
# Chnage By - Nalin Jayakody
# Chnage For - To re-arrange the PRODUCT.CSV file request by FR
# ==============================================================
//$_arrHeader = array("P.CODE", "P^WC:100", "P^WC:200","P^WC:240","P^WC:250","P.TYPE","P.DESCRIP","P.UDCosted Effi.","P.UDCosted SMV","P^WC:10");
# ==============================================================

$_arrHeader = array("P.CODE","P.DESCRIP", "P.TYPE","P^WC:10", "P^WC:100", "P^WC:200","P^WC:240","P^WC:250", "P.UDCosted Effi.","P.UDCosted SMV", "END");
 
# Open product.csv
//$output = fopen($fProduct, "w");
$output = fopen('php://memory', "w");

# Add product.csv header details array to the main array variable
$_arrProductForCSV[0] = $_arrHeader;	
$iArrayPossition = 1;

# Get length of the style code array
$_intStyleCodeLength = count($_arrStyleCodesList);

$_arrProductDetails = array(); # Initialize product details array

for($i=0;$i<$_intStyleCodeLength;$i++){
 
  # Get the product details for give style code
  $_resProduct = GetDetailsForProduct($_arrStyleCodesList[$i]);
  
  $_intStylePartRowCount =  mysql_num_rows($_resProduct);
  
  if($_intStylePartRowCount>1){		  	  
  	
	 while($row = mysql_fetch_array($_resProduct)){			
			  
		  $_arrProductDetails[0] = $row["strStylePrefix"]." - ".$row["strPartName"];
                  $_arrProductDetails[1] = $row["strDescription"];
                  $_arrProductDetails[2] = $row["strCatName"];
                  $_arrProductDetails[3] = "1";
		  $_arrProductDetails[4] = "1";
		  $_arrProductDetails[5] = $row["dblsmv"];//"1";
		  $_arrProductDetails[6] = "1";
		  $_arrProductDetails[7] = "1";
		  $_arrProductDetails[8] = $row["reaEfficiencyLevel"];
		  $_arrProductDetails[9] = $row["dblsmv"];
                  //$_arrProductDetails[10] = $row["strStyle"];
		  $_arrProductDetails[10] = "END";
		  
		  $_arrProductForCSV [$iArrayPossition] = $_arrProductDetails;
		  $iArrayPossition++;
	  }
	  
  }else{ # Only 1 style part consist for the order
	  
	   while($row = mysql_fetch_array($_resProduct)){			
			  
		  $_arrProductDetails[0] = $row["strStylePrefix"];
                  $_arrProductDetails[1] = $row["strDescription"];
                  $_arrProductDetails[2] = $row["strCatName"];
                  $_arrProductDetails[3] = "1";
		  $_arrProductDetails[4] = "1";
                  $_arrProductDetails[5] = $row["dblsmv"];//"1";
		  $_arrProductDetails[6] = "1";
		  $_arrProductDetails[7] = "1";
		  $_arrProductDetails[8] = $row["reaEfficiencyLevel"];
		  $_arrProductDetails[9] = $row["dblsmv"];
		  //$_arrProductDetails[10] = $row["strStyle"];
                  $_arrProductDetails[10] = "END";
	  }
	  
	  $_arrProductForCSV [$iArrayPossition] = $_arrProductDetails;
	  $iArrayPossition++;
  }
  
  
  
  # update the transfer status of the product
  SetProductTransferStatus($_arrStyleCodesList[$i]);  
}




# Create full PRODUCTS.CSV file
foreach($_arrProductForCSV as $rowHeader){
	fputcsv($output, $rowHeader);	
}

# Close opened PRODUCTS.CSV file
//fclose($output);
fseek($output,0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment;filename='.$fProduct);
header('Cache-Control: max-age=0');

fpassthru($output);

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


?>