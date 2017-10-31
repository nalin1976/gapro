<?php
session_start();
include("../../Connector.php"); 	
$id=$_GET["id"];

if($id=='checkContainerName')
{
	$containerName=$_GET['containerName'];
	$sql="SELECT strContainerName FROM container WHERE strContainerName='$containerName';";
	$result=$db->RunQuery($sql);
		if(mysql_num_rows($result)>0)
			echo 1;
		else
			echo 0;
}
if ($id=='saveData')
{ 
	$containerId  = $_GET['containerId'];
	$containerName=$_GET['containerName'];
	$description=$_GET['description'];
	$measurement=$_GET['measurement'];
	
	if($containerId>0)
	{
		$sql="UPDATE container SET 
		  strContainerName='$containerName',
		  strDescription='$description',
		  strMeasurement='$measurement'
		  WHERE intContainerId=$containerId";
	}
	else
	{
		$sql="INSERT INTO container(strContainerName,strDescription,strMeasurement)
		  VALUES('$containerName','$description','$measurement');";
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
	$ResponseXML .= "<ContainerDetails>";
	$containerId=$_GET["containerId"];

	$sql="SELECT strContainerName,strDescription,strMeasurement FROM container 
		  	WHERE intContainerId=$containerId;";
	$result=$db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<ContainerName><![CDATA[" . $row["strContainerName"]  . "]]></ContainerName>\n";
		$ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
		$ResponseXML .= "<Measurement><![CDATA[" . $row["strMeasurement"]  . "]]></Measurement>\n";

	}
	
		$ResponseXML .= "</ContainerDetails>";
		echo $ResponseXML;
}

if($id=='deleteData')
{
	$containerId=$_GET['containerId'];
	$sql="DELETE FROM container WHERE intContainerId=$containerId;";
	$result=$db->RunQuery($sql);
	
	if($result)
		echo "Deleted Successfully";
	else
		echo "Can't Delete.Failed.";
}