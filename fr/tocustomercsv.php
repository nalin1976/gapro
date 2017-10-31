<?php

session_start();
//include "../Connector.php";
include "../autoconnect.php";
include "classCSV.php";

$classCSV  = new CSVClass();

$fCustomer ="CUSTOMER.CSV";

$_arrCustomerDetails = array();
$_arrCustomerHeader = array("C.CODE", "C.LATEOK");

# Open customer.csv
$output = fopen('php://memory', "w");

$arrCustomerForCSV[0] = $_arrCustomerHeader;
$arrPos = 1;
$rsCustomerList = $classCSV->GetCustomersList();

while($rowCustomers = mysql_fetch_array($rsCustomerList)){
    $_arrCustomerDetails[0] = $rowCustomers["strName"];
    $_arrCustomerDetails[1] = "";
    $arrCustomerForCSV[$arrPos] = $_arrCustomerDetails;
    
    $arrPos++;
    
}

//print_r($arrCustomerForCSV);

foreach($arrCustomerForCSV as $rowHeader){
	fputcsv($output, $rowHeader);	
}

# Close opened PRODUCTS.CSV file
//fclose($output);
fseek($output,0);
header('Content-Type: application/csv');
header('Content-Disposition: attachment;filename='.$fCustomer);
header('Cache-Control: max-age=0');

fpassthru($output);

?>
