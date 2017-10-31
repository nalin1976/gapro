<?php
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

//$db =new DBManager();

$RequestType = $_GET["RequestType"];

if (strcmp($RequestType,"SaveEvent") == 0)
{
	
	$eventName = $_GET["EventName"];
	$result=CheckEvent($eventName);
	 
	 while($row = mysql_fetch_array($result))
  	 {
	 		$ResponseXML .= "<Result><![CDATA[False]]></Result>\n";
			echo $ResponseXML;	
			die();
	 }
	
	SaveEvent($eventName);
	
	$ResponseXML .= "<Result><![CDATA[True]]></Result>\n";
	echo $ResponseXML;	
}

function SaveEvent($eventName)
{
	global $db;
	$sql="insert into events(strDescription) values ('$eventName');";
	$db->executeQuery($sql);
}

function CheckEvent($eventName)
{
	global $db;
	$sql= "select * from events where strDescription = '$eventName';";
	return $db->RunQuery($sql);
}

?>