<?php
session_start();
include "Connector.php";

header('Content-Type: text/xml'); 

$RequestType = $_GET["RequestType"];

if ($RequestType == "LoadBuyerPOColors")
{
	$styleID = $_GET["styleID"];
	$buyerPO = $_GET["buyerPO"];
	$sql = "SELECT DISTINCT strColor  FROM styleratio WHERE intStyleId = '$styleID' AND strBuyerPONO = '$buyerPO';";
	$result = $db->RunQuery($sql);
	echo "<option value=\"Select One\" selected=\"selected\">Select One</option>";
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>" ;					
	}
}
else if ($RequestType == "LoadBuyerPOColorQuantity")
{
	$styleID = $_GET["styleID"];
	$buyerPO = $_GET["buyerPO"];
	$color =  $_GET["color"];
	
	$sql = "SELECT ROUND(SUM(dblExQty)) AS colorquantity FROM styleratio WHERE intStyleId = '$styleID' AND strBuyerPONO = '$buyerPO' AND strColor = '$color'
GROUP BY strColor";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		echo $row["colorquantity"] ;					
	}
}
else if ($RequestType == "getStyleRatioColors")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	echo "<RequestDetails>\n";
	$styleID = $_GET["styleID"];
	$sql = "SELECT DISTINCT strColor  FROM styleratio WHERE intStyleId = '$styleID'";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["strColor"] ."\">" . $row["strColor"] ."</option>\n" ;					
	}
	echo "</RequestDetails>";
}
else if ($RequestType == "clearAvailableContrast")
{
	$styleID = $_GET["styleID"];
	$contrastItem = $_GET["contrastItem"];
	$buyerPO = $_GET["buyerPO"];
	$garmentcolor = $_GET["garmentcolor"];
	
	$sql = "DELETE FROM contrastitem WHERE intStyleId = '$styleID' AND strBuyerPONO = '$buyerPO' AND strMatDetailID = '$contrastItem' AND garmentColor = '$garmentcolor';";
	echo $db->ExecuteQuery($sql);	
}
else if ($RequestType == "SaveContastColor")
{
	$styleID = $_GET["styleID"];
	$contrastItem = $_GET["contrastItem"];
	$buyerPO = $_GET["buyerPO"];
	$garmentcolor = $_GET["garmentcolor"];
	$contrastcolor = $_GET["contrastcolor"];
	$contrastconsumption = $_GET["contrastconsumption"];
	
	$sql = "INSERT INTO contrastitem 
	(intStyleId, 
	strBuyerPONO, 
	strMatDetailID, 
	garmentColor, 
	contrastColor, 
	consumption
	)
	VALUES
	('$styleID', 
	'$buyerPO', 
	'$contrastItem', 
	'$garmentcolor', 
	'$contrastcolor', 
	'$contrastconsumption'
	);";
	echo $db->ExecuteQuery($sql);
}
else if ($RequestType == "loadSavedContrast")
{
	$styleID = $_GET["styleID"];
	$buyerPO = $_GET["buyerPO"];
	$color =  $_GET["color"];
	$contrastItem = $_GET["contrastItem"];
	$sql = "SELECT contrastColor, consumption FROM contrastitem WHERE intStyleId = '$styleID' AND strBuyerPONO = '$buyerPO' AND strMatDetailID = '$contrastItem' AND garmentColor = '$color'";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		echo "<tr class=\"backcolorWhite\"><td width=\"70%\" height=\"24\" class=\"normalfnt\">" . $row["contrastColor"] . "</td>
          	<td class=\"normalfnt\"><input type=\"text\" value=\"" . $row["consumption"] . "\" class=\"txtbox\" style=\"width:100px;\" onmousedown=\"DisableRightClickEvent();\" onmouseout=\"EnableRightClickEvent();\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"></td></tr>";					
	}
}
else if ($RequestType == "applyContrast")
{
	$contrastStyle = $_GET["styleID"];
	include 'contrastprocess.php';
}

?>