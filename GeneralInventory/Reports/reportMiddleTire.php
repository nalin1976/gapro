<?php
session_start();
include "../../Connector.php";
ob_start();
header('Content-Type: text/xml'); 

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$userID=$_SESSION["UserID"];
$RequestType = $_GET["RequestType"];

 if (strcmp($RequestType,"getCategory") == 0)
{
	ob_get_clean();
	
	//$styleID = $_GET["styleID"];
	$materialNo =$_GET["materialNo"];
	$sql = "
SELECT DISTINCT genmatsubcategory.StrCatName,  genmatsubcategory.intSubCatNo FROM genmatitemlist INNER JOIN genmatsubcategory ON  genmatitemlist.intSubCatID= genmatsubcategory.intSubCatNo WHERE genmatitemlist.intItemSerial<>0 ";
	
	
	if ($materialNo!="")
	{
		$sql = $sql." and genmatitemlist.intMainCatID=$materialNo";
	}
	
	   $sql = $sql." ORDER BY genmatsubcategory.StrCatName";
	
	$result = $db->RunQuery($sql);
	echo "<option value=\"\"></option>";
	while ($row = mysql_fetch_array($result))
	{
		echo "<option value=\"" . $row["intSubCatNo"]  . "\">" . $row["StrCatName"]  . "</option>";
	}
}
else if (strcmp($RequestType,"getItemDetails") == 0)
{
	//$styleID = $_GET["styleID"];
	$materialNo =$_GET["materialNo"];
	$categoryNo=$_GET["categoryNo"]; 
	
	$sql = "SELECT DISTINCT genmatitemlist.intItemSerial,  genmatitemlist.strItemDescription FROM genmatitemlist WHERE genmatitemlist.intItemSerial<>0 ";
	
	
	if ($materialNo!="")
	{
		$sql = $sql." and genmatitemlist.intMainCatID=$materialNo ";
	}

	if ($categoryNo!="")
	{
		$sql = $sql." and genmatitemlist.intSubCatID=$categoryNo ";
	}
	$sql = $sql." ORDER BY genmatitemlist.strItemDescription ";
	
	$result = $db->RunQuery($sql);
	echo "<option value=\"\"></option>";
	while ($row = mysql_fetch_array($result))
	{
		echo "<option value=\"" . $row["intItemSerial"]  . "\">" . $row["strItemDescription"]  . "</option>";
	}	
}

?>