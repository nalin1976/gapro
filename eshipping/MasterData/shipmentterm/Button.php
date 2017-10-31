<?php
session_start();
include("../../Connector.php"); 	
$id=$_GET["id"];

if($id=='deleteRowData')
{
	$shipmentId=$_GET['shipmentId'];
	$sql="UPDATE shipmentterms SET intStatus=0 WHERE intShipmentTermId=$shipmentId ;";
	$result=$db->RunQuery($sql);
		if($result)
			echo 1;
		else
			echo 0;
}
if($id=='saveData')
{
	$termName=$_GET['termName'];
	$termRemarks=$_GET['termRemarks'];
	$termId=$_GET['termId'];
	
	if($termId==0)
	{
		$sql="INSERT INTO shipmentterms (strShipmentTerm,strRemarks,intStatus) VALUES('$termName','$termRemarks',1);";
	}
	else
		$sql="UPDATE shipmentterms SET strShipmentTerm='$termName',strRemarks='$termRemarks' WHERE intShipmentTermId=$termId;";
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
	
	$sql="SELECT * FROM shipmentterms WHERE intShipmentTermId!=$termId AND strShipmentTerm='$termName' AND intStatus=1;";
	$result=$db->RunQuery($sql);
	
	if(mysql_num_rows($result)>0)
		echo 1;
	else
		echo 0;

	
}
