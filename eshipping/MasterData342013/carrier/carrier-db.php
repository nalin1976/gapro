<?php
session_start();
include("../../Connector.php"); 	
$id=$_GET["id"];

if($id=='checkCarrierName')
{
	$carrierName=$_GET['carrierName'];
	$sql="SELECT strCarrierName FROM carrier WHERE strCarrierName='$carrierName';";
	$result=$db->RunQuery($sql);
		if(mysql_num_rows($result)>0)
			echo 1;
		else
			echo 0;
}
if ($id=='saveData')
{ 
	$carrierId  = $_GET['carrierId'];
	$carrierName=$_GET['carrierName'];
	$description=$_GET['description'];
	
	if($carrierId>0)
	{
		$sql="UPDATE carrier SET 
		  strCarrierName='$carrierName',
		  strDescription='$description'
		  WHERE intCarrierId=$carrierId";
	}
	else
	{
		$sql="INSERT INTO carrier(strCarrierName,strDescription)
		  VALUES('$carrierName','$description');";
	}
	$result=$db->RunQuery($sql);
	
	if($result)
		echo "Saved Successfully";
	else
		echo "Saving Failed";
}

if ($id=='loadData')
{ 
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML .= "<CarrierDetails>";
	$carrierId=$_GET["carrierId"];

	$sql="SELECT strCarrierName,strDescription FROM carrier
		  	WHERE intCarrierId=$carrierId;";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<CarrierName><![CDATA[" . $row["strCarrierName"]  . "]]></CarrierName>\n";
		$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";

	}
	
		$ResponseXML .= "</CarrierDetails>";
		echo $ResponseXML;
}

if($id=='deleteData')
{
	$carrierId=$_GET['carrierId'];
	$sql="DELETE FROM carrier WHERE intCarrierId=$carrierId;";
	$result=$db->RunQuery($sql);
	
	if($result)
		echo "Deleted Successfully";
	else
		echo "Can't Delete.Failed.";
}