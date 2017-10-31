<?php
session_start();
include "../Connector.php";

$FactoryID = $_SESSION["FactoryID"];

$RequestType = $_GET["RequestType"];
$strPaymentType=$_GET["strPaymentType"];


if(strcmp($RequestType,"checkInvoiceNo")== 0)
{
$invNo       = $_GET['invNo'];
$cbosupplier = $_GET['cbosupplier'];
$year = date('Y');

$sql2 = "select * from invoiceheader where strInvoiceNo = '$invNo' AND strSupplierId = '$cbosupplier' AND strType = '$strPaymentType' AND year(dtmDate)='$year'";
$result2 =  $db->RunQuery($sql2);
if(mysql_num_rows($result2)){
 echo 0;
}else{
 echo 1;
}
}

?>