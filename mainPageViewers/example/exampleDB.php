<?php ///////////////////////////// Coding by Lahiru Ranagana 2013-04-04 /////////////////////////
session_start();
include "../../Connector.php";
$userid=$_SESSION["UserID"];
$RequestType = $_GET["RequestType"];

if(strcmp($RequestType,"loadGridDataExample") == 0)
{
	$name = $_GET["name"];
echo $name;
}

?>