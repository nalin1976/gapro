<?php

session_start();
include "../../Connector.php";
$request = $_GET["request"];
if($request=='getDivision')
{
	$buyer = $_GET["buyer"];
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

	$XMLString .= "<Data>";
	$XMLString .= "<DivisionData>";	
	$sql="select intBuyerID, 
	intDivisionId, 
	strDivision 		 
	from 
	buyerdivisions 
	where intBuyerID='$buyer';";
	$result = $db->RunQuery($sql);
	   
	while($row = mysql_fetch_array($result))
			{		
                        $XMLString .= "<DivisionId><![CDATA[" . $row["intDivisionId"]  . "]]></DivisionId>";
						$XMLString .= "<Division><![CDATA[" . $row["strDivision"]  . "]]></Division>\n";
						
			}
	$XMLString .= "</DivisionData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}

if($request=='editdb')
{
	$division = $_GET["division"];
	$buyer = $_GET["buyer"];
	$date=date("Y-m-d");
	$sql="insert into buyerdivisions 
						(intBuyerID, 
						strDivision, 
						dtmDate
						)
						values
						('$buyer', 
						'$division', 
						'$date');";
	$result = $db->RunQuery($sql);
	if($result)
	echo"Saved successfully.";
	else
	echo"Sorry! operation failed.".$sql;
}

?>