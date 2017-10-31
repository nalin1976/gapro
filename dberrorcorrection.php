<?php

// FABRIC
include "Connector.php"; 

$sql = " SELECT orderdetails.*, orders.intQty FROM orderdetails INNER JOIN matitemlist ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN matmaincategory INNER JOIN orders ON 
 orderdetails.intStyleId = orders.intStyleId
WHERE matitemlist.intMainCatID = '1'";

$result = $db->RunQuery($sql);		
	while($row = mysql_fetch_array($result))
	{
		$style = $row["intStyleId"];
		$matDetailID = $row["intMatDetailID"];
		$conpc = $row["reaConPc"];
		$unitprice = $row["dblUnitPrice"];
		$wastage = $row["reaWastage"];
		$odrQty =  $row["intQty"];
		$reqQty = round($conpc * $odrQty,4);
		
		$totalValue = round($odrQty * $unitprice,4);
		$costPC = round($conpc * $unitprice,4);

		$sql = "UPDATE specificationdetails SET dblReqQty = $reqQty,dblTotalQty = $reqQty,dblTotalValue=$totalValue,dblCostPC = $costPC WHERE
intStyleId = '$style' AND strMatDetailID = '$matDetailID'";
 		$db->RunQuery($sql);	
	}

?>

<?php


// NON FABRIC
include "Connector.php"; 

$sql = " SELECT orderdetails.*, orders.intQty, orders.reaExPercentage FROM orderdetails INNER JOIN matitemlist ON matitemlist.intItemSerial = orderdetails.intMatDetailID INNER JOIN matmaincategory INNER JOIN orders ON 
 orderdetails.intStyleId = orders.intStyleId
WHERE matitemlist.intMainCatID <> '1'";

$result = $db->RunQuery($sql);		
	while($row = mysql_fetch_array($result))
	{
		$style = $row["intStyleId"];
		$matDetailID = $row["intMatDetailID"];
		$conpc = $row["reaConPc"];
		$unitprice = $row["dblUnitPrice"];
		$wastage = $row["reaWastage"];
		$odrQty =  $row["intQty"];
		$expc =  $row["reaExPercentage"];
		$reqQty = round($conpc * $odrQty,4);
		$totQty = round((($conpc + ($conpc * $wastage / 100) ) * ($odrQty + ($odrQty * $expc / 100)) ),4);
		$totalValue = round($totQty * $unitprice,4);
		$costPC = round($totalValue / $totQty,4);

		$sql = "UPDATE orderdetails SET dblReqQty = $reqQty,dblTotalQty = $totQty,dblTotalValue=$totalValue,dbltotalcostpc = $costPC WHERE
intStyleId = '$style' AND intMatDetailID = '$matDetailID'";
 		$db->RunQuery($sql);	
	}

?>