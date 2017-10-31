<?php
session_start();
include("../../Connector.php"); 	
$id=$_GET["id"];

if($id=='deleteRowData')
{
	$paymentId=$_GET['paymentId'];
	$sql="UPDATE paymentterm SET intStatus=0 WHERE intPaymentTermId=$paymentId ;";
	$result=$db->RunQuery($sql);
		if($result)
			echo 1;
		else
			echo 0;
}
if($id=='saveData')
{
	$termName=$_GET['termName'];
	$termDesc=$_GET['termDesc'];
	$termId=$_GET['termId'];
	
	if($termId==0)
	{
		$sql="INSERT INTO paymentterm (strPaymentTerm,strDescription,intStatus) VALUES('$termName','$termDesc',1);";
	}
	else
		$sql="UPDATE paymentterm SET strPaymentTerm='$termName',strDescription='$termDesc' WHERE intPaymentTermId=$termId;";
	$result=$db->RunQuery($sql);
	
	if($result)
		echo "Saved Successfully";
	else
		echo "Saving Failed";
}
if($id=='checkAvailbility')
{
	$termName=$_GET['termName'];
	$termId=$_GET['termId'];
	
	$sql="SELECT * FROM paymentterm WHERE intPaymentTermId!=$termId AND strPaymentTerm='$termName' AND intStatus=1;";
	$result=$db->RunQuery($sql);
	
	if(mysql_num_rows($result)>0)
		echo 1;
	else
		echo 0;

	
}
