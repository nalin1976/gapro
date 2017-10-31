<?php


//You should declare the $contrastStyle variable befor you include this file. 
//And assign the relevant style number  to that variable
//Also session should be started. And should include any database connectivity class

$sql = "SELECT strMatDetailID,strBuyerPONO,strMatDetailID,garmentColor, SUM(consumption) AS contrastconsumption FROM contrastitem WHERE intStyleId = '$contrastStyle' GROUP BY  strMatDetailID,strBuyerPONO,strMatDetailID,garmentColor";
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	$contrastItem =  $row["strMatDetailID"] ;
	$contrastBPO =  $row["strBuyerPONO"] ;
	$garmentColor =  $row["garmentColor"] ;
	$contrastConsumption =  $row["contrastconsumption"] ;
	
	// Remove all unneccessary colors from material ratio
	$sql = "DELETE FROM materialratio WHERE  intStyleId = '$contrastStyle'  AND strMatDetailID = '$contrastItem' AND  strBuyerPONO = '$contrastBPO'   AND
strColor NOT IN (SELECT strColor FROM styleratio WHERE  intStyleId = '$contrastStyle'  AND strMatDetailID = '$contrastItem' AND  strBuyerPONO = '$contrastBPO'  )";
	$db->ExecuteQuery($sql);
	
	$itemPurchaseType = "";
	$itemConsumption = 0;
	$freight = 0;
	
	// Get item consumption and purchase type
	$sql = "SELECT sngConPc, strPurchaseMode, dblfreight, intSRNO FROM specificationdetails inner join specification 
	on specification.intStyleId = specificationdetails.intStyleId  WHERE specificationdetails.intStyleId = '$contrastStyle' AND specificationdetails.strMatDetailID = '$contrastItem'";;
	$resultspec = $db->RunQuery($sql);
	while($rowspec = mysql_fetch_array($resultspec))
	{
		$itemPurchaseType =  $rowspec["strPurchaseMode"] ;
		$itemConsumption =  $rowspec["sngConPc"] ;
		$freight =  $rowspec["dblfreight"] ;
	}
	// Update colors which was mentioned by the style ratio
	if ($itemPurchaseType == "COLOR")
	{
		$sql = "SELECT strColor, SUM(dblExQty) AS qty FROM styleratio WHERE intStyleId = '$contrastStyle' AND strColor = '$garmentColor'  GROUP BY strColor";
		$resultratio = $db->RunQuery($sql);
		while($rowratio = mysql_fetch_array($resultratio))
		{
			$freightQty = 0;
			if ($freight > 0)
				$freightQty = $newQty - getItemPurchasedQty($contrastStyle,$contrastItem,$contrastBPO,$contrastColor, 'N/A', 1);
			$newitemConsumption = $itemConsumption - $contrastConsumption;
			$qty = $rowratio["qty"] ;
			$newQty = round($qty * $newitemConsumption);
			$balQty = $newQty - getItemPurchasedQty($contrastStyle,$contrastItem,$contrastBPO,$contrastColor, 'N/A', 0) ;
			$sql = "UPDATE materialratio SET dblQty = '$newQty', dblBalQty = '$balQty' , dblFreightBalQty = '$freightQty' WHERE intStyleId = '$contrastStyle' AND strMatDetailID = '$contrastItem' AND strBuyerPONO = '$contrastBPO' AND strColor = '$garmentColor'  AND strSize ='N/A'";
			$db->ExecuteQuery($sql);
			
		}
	}	
	else if ($itemPurchaseType == "BOTH")
	{
		$sql = "SELECT strColor, strSize, SUM(dblExQty) AS qty FROM styleratio WHERE intStyleId = '$contrastStyle' AND strColor = '$garmentColor'  GROUP BY strColor, strSize";
		$resultratio = $db->RunQuery($sql);
		while($rowratio = mysql_fetch_array($resultratio))
		{
			$size = $rowratio["strSize"] ;
			$freightQty = 0;
			if ($freight > 0)
				$freightQty = $newQty - getItemPurchasedQty($contrastStyle,$contrastItem,$contrastBPO,$contrastColor, $size, 1);
			$newitemConsumption = $itemConsumption - $contrastConsumption;
			$qty = $rowratio["qty"] ;
			
			$newQty = round($qty * $newitemConsumption);
			$balQty = $newQty - getItemPurchasedQty($contrastStyle,$contrastItem,$contrastBPO,$contrastColor, $size, 0) ;
			$sql = "UPDATE materialratio SET dblQty = '$newQty', dblBalQty = '$balQty' , dblFreightBalQty = '$freightQty' WHERE intStyleId = '$contrastStyle' AND strMatDetailID = '$contrastItem' AND strBuyerPONO = '$contrastBPO' AND strColor = '$garmentColor'  AND strSize ='$size'";
			$db->ExecuteQuery($sql);
			
		}
	}
	
					
}

$sql = "SELECT strMatDetailID,strBuyerPONO,strMatDetailID,garmentColor , contrastColor , consumption FROM contrastitem WHERE intStyleId = '$contrastStyle' ";
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	$contrastItem =  $row["strMatDetailID"] ;
	$contrastBPO =  $row["strBuyerPONO"] ;
	$garmentColor =  $row["garmentColor"] ;
	$contrastColor = $row["contrastColor"] ;
	$contrastConsumption =  $row["consumption"] ;
	$SCNo = "";
	
	$itemPurchaseType = "";
	$itemConsumption = 0;
	$freight = 0;
	$sql = "SELECT sngConPc, strPurchaseMode, dblfreight, intSRNO FROM specificationdetails inner join specification 
	on specification.intStyleId = specificationdetails.intStyleId  WHERE specificationdetails.intStyleId = '$contrastStyle' AND specificationdetails.strMatDetailID = '$contrastItem'";;
	$resultspec = $db->RunQuery($sql);
	while($rowspec = mysql_fetch_array($resultspec))
	{
		$SCNo = $rowspec["intSRNO"] ;
		$itemPurchaseType =  $rowspec["strPurchaseMode"] ;
		$itemConsumption =  $rowspec["sngConPc"] ;
		$freight =  $rowspec["dblfreight"] ;
	}
	
	
	if ($itemPurchaseType == "COLOR")
	{
		$sql = "SELECT strColor, SUM(dblExQty) AS qty FROM styleratio WHERE intStyleId = '$contrastStyle' AND strColor = '$garmentColor'  GROUP BY strColor";
	
		$resultratio = $db->RunQuery($sql);
		while($rowratio = mysql_fetch_array($resultratio))
		{
			
			$newQty = round($rowratio["qty"] * $contrastConsumption) ;

			$freightQty = 0;
			if ($freight > 0)
			$freightQty = $newQty;
			$updated = false;
			$sql = "SELECT strSize,dblQty FROM materialratio WHERE intStyleId = '$contrastStyle' AND strMatDetailID = '$contrastItem' AND strBuyerPONO = '$contrastBPO' AND strColor = '$contrastColor'";

			
			$resultmatratio = $db->RunQuery($sql);
			while($rowmatratio = mysql_fetch_array($resultmatratio))
			{

				$size = $rowmatratio["strSize"];
				if ($freight > 0)
					$freightQty = $newQty - getItemPurchasedQty($contrastStyle,$contrastItem,$contrastBPO,$contrastColor, $size, 1) ;
				$sql = "UPDATE materialratio SET dblQty =( dblQty + $newQty), dblBalQty = dblQty - " . getItemPurchasedQty($contrastStyle,$contrastItem,$contrastBPO,$contrastColor, $size, 0) . ", dblFreightBalQty = $freightQty  WHERE intStyleId = '$contrastStyle' AND strMatDetailID = '$contrastItem' AND strBuyerPONO = '$contrastBPO' AND strColor = '$contrastColor'  AND strSize ='$size'";
			
				$updated = $db->ExecuteQuery($sql);
				break;
			}
			
			if (!$updated)
			{
	
				$sql = "INSERT INTO materialratio 
	(intStyleId, 
	strMatDetailID, 
	strColor, 
	strSize, 
	strBuyerPONO, 
	dblQty, 
	dblBalQty, 
	dblFreightBalQty, 
	materialRatioID
	)
	VALUES
	('$contrastStyle', 
	'$contrastItem', 
	'$contrastColor', 
	'N/A', 
	'$contrastBPO', 
	'$newQty', 
	'$newQty', 
	'$freightQty', 
	'$SCNo" . "-" . "$contrastItem-CN'
	);";
		$db->ExecuteQuery($sql);
			}
		}
	}
	
	else if ($itemPurchaseType == "BOTH")
	{

		$sql = "SELECT strSize, strColor, SUM(dblExQty) AS qty FROM styleratio WHERE intStyleId = '$contrastStyle' AND strColor = '$garmentColor'  GROUP BY strColor, strSize ";
		//echo $sql ;
		$resultratio = $db->RunQuery($sql);
		while($rowratio = mysql_fetch_array($resultratio))
		{
			$size = $rowratio["strSize"] ;
			$newQty = round($rowratio["qty"] * $contrastConsumption) ;

			$freightQty = 0;
			if ($freight > 0)
			$freightQty = $newQty;
			$updated = false;
			$sql = "SELECT strColor, strSize,dblQty FROM materialratio WHERE intStyleId = '$contrastStyle' AND strMatDetailID = '$contrastItem' AND strBuyerPONO = '$contrastBPO' AND strColor = '$contrastColor' AND strSize='$size' ";
			
			
			$resultmatratio = $db->RunQuery($sql);
			while($rowmatratio = mysql_fetch_array($resultmatratio))
			{

				if ($freight > 0)
					$freightQty = $newQty - getItemPurchasedQty($contrastStyle,$contrastItem,$contrastBPO,$contrastColor, $size, 1) ;
				$sql = "UPDATE materialratio SET dblQty =( dblQty + $newQty), dblBalQty = dblQty - " . getItemPurchasedQty($contrastStyle,$contrastItem,$contrastBPO,$contrastColor, $size, 0) . ", dblFreightBalQty = $freightQty  WHERE intStyleId = '$contrastStyle' AND strMatDetailID = '$contrastItem' AND strBuyerPONO = '$contrastBPO' AND strColor = '$contrastColor'  AND strSize ='$size'";
			
				$updated = $db->ExecuteQuery($sql);
				break;
			}
			
			if (!$updated)
			{
	
				$sql = "INSERT INTO materialratio 
	(intStyleId, 
	strMatDetailID, 
	strColor, 
	strSize, 
	strBuyerPONO, 
	dblQty, 
	dblBalQty, 
	dblFreightBalQty, 
	materialRatioID
	)
	VALUES
	('$contrastStyle', 
	'$contrastItem', 
	'$contrastColor', 
	'$size', 
	'$contrastBPO', 
	'$newQty', 
	'$newQty', 
	'$freightQty', 
	'$SCNo" . "-" . "$contrastItem-CN'
	);";
		$db->ExecuteQuery($sql);
			}
		}
	}
}

/*function getItemPurchasedQty($styleNo,$itemCode,$buyerPO,$color, $size, $Type)
{
	global $db;	

	$sql = "select sum(dblQty) as purchasedQty from purchaseorderdetails,purchaseorderheader where purchaseorderdetails.intStyleId = '$styleNo' AND purchaseorderdetails.intMatDetailID = $itemCode AND purchaseorderdetails.strBuyerPONO = '$buyerPO' AND purchaseorderdetails.strColor = '$color' AND purchaseorderdetails.strSize = '$size' AND purchaseorderdetails.intPOType = $Type  AND purchaseorderheader.intPONo = purchaseorderdetails.intPONo AND  purchaseorderheader.intStatus = 10 AND intPOType=$Type";
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		if ($row["purchasedQty"] == "" || $row["purchasedQty"]  == NULL)
			return 0;
			
		return $row["purchasedQty"];
	}
	
	return 0;
}
*/
?>