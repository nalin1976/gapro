<?php
session_start();
include "../Connector.php";
$compCode=$_SESSION["FactoryID"];

$RequestType = $_GET["RequestType"];

if($RequestType=="saveHeader")
{
 $serialNo = $_GET["serialNo"];
 $hiddenSupId = $_GET["hiddenSupId"];
 $hiddenFileName = $_GET["hiddenFileName"];
 
 $sql1 = "select intSerialNo from invoiceuploadheader where intSupplierId = '$hiddenSupId' AND strFileName='$hiddenFileName'"; 
 $result1			=	$db->RunQuery($sql1);
	 while($row1 = mysql_fetch_array($result1))
	 { 
	  $intSerialNo = $row1["intSerialNo"];
	  $sql2 = "delete from invoiceuploaddetails where intSerialNo = '$intSerialNo'";
	  $result2	= $db->RunQuery($sql2);
	  $sql3 = "delete from invoiceuploadheader where intSerialNo = '$intSerialNo'";
	  $result3	= $db->RunQuery($sql3);
	 }
 
    $sql = "insert into invoiceuploadheader(intSerialNo,intSupplierId,dtmDate,strFileName)values('$serialNo','$hiddenSupId',now(),'$hiddenFileName')";
 	$result = $db->ExecuteQuery($sql);
	if($result)
		echo '1';	
	else	
		echo 0;
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------

if($RequestType=="saveDetails")
{
 $serialNo = $_GET["serialNo"];
 $poNo = $_GET["poNo"];
 $date = $_GET["date"];
 $invoiceNo = $_GET["invoiceNo"];
 $amount = $_GET["amount"];
 
 echo $sql = "insert into invoiceuploaddetails (intSerialNo,intPoNo,strInvoiceNo,dtmInvoiceDate,dblAmount) values('$serialNo','$poNo','$invoiceNo','$date','$amount')";
 $result = $db->ExecuteQuery($sql);
}

?>