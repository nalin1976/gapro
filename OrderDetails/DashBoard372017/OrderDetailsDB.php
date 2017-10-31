<?php
include "../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="getScDetails")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$styleId = $_GET["styleId"];
$bpo = $_GET["bpo"];
$buyer = $_GET["buyer"];
$matCategory = $_GET["matCategory"];


$ResponseXML = "<XMLLoadDetails>\n";

				$sql="SELECT
				specification.intSRNO,
				orders.strStyle,
				buyers.strName as buyer,
				orders.intStyleId,
				deliveryschedule.intBPO,
				deliveryschedule.dblQty AS bpoQty,
				orders.strOrderColorCode,
				mainstores.strName as fty,
				deliveryschedule.estimatedDate AS xFacDate,
				deliveryschedule.dtmHandOverDate AS handOverDate,
				date(deliveryschedule.dtDateofDelivery) AS dateofDelivery,
				country.strCountry,
				orders.reaSMV,
				shipmentmode.strDescription,
				orders.reaFOB,
				companies.reaCMforPowiseCostingRpt,
				orders.intQty
				FROM
				orders
				INNER JOIN deliveryschedule ON orders.intStyleId = deliveryschedule.intStyleId
				INNER JOIN shipmentmode ON deliveryschedule.strShippingMode = shipmentmode.intShipmentModeId
				INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
				INNER JOIN specification ON orders.intStyleId = specification.intStyleId
				INNER JOIN mainstores ON deliveryschedule.intManufacturingLocation = mainstores.intCompanyId
				INNER JOIN country ON buyers.strCountry = country.intConID
				INNER JOIN companies ON deliveryschedule.intManufacturingLocation = companies.intCompanyID
				WHERE
				orders.intStyleId = 4503
				GROUP BY
				orders.intStyleId,
				deliveryschedule.intBPO
				";

/*				if($bpo != 'Select One'){
							$sql .= " AND materialratio.strBuyerPONO = '$bpo'";
				  }
				if($matCategory != 'Select One'){
							$sql .= " AND matmaincategory.intID = '$matCategory'";
							}
				
				
				$sql .=" GROUP BY
				materialratio.intStyleId,
				materialratio.strBuyerPONO,
				materialratio.strMatDetailID
				ORDER BY
				materialratio.intStyleId ASC,
				materialratio.strBuyerPONO ASC,
				materialratio.strMatDetailID ASC,
				matmaincategory.intID ASC";*/
				
				
$result=$db->RunQuery($sql);
//echo $sql;
while($row=mysql_fetch_array($result))
{

	//$poQty = GetPoDetails($styleId,$row["strBuyerPONO"],$row["strMatDetailID"]);
$sc = $row["intSRNO"];
$bpoQty = $row["bpoQty"];
$odrQty = $row["intQty"];
	
$_dblFabricCost = CalculateFabricCost($sc, $bpoQty, $odrQty,1);
$_dblSewCost    = CalculateFabricCost($sc, $bpoQty, $odrQty,2);
$_dblPacCost    = CalculateFabricCost($sc, $bpoQty, $odrQty,3);
$_dblSerCost    = CalculateFabricCost($sc, $bpoQty, $odrQty,4);

	$ResponseXML .= "<intSRNO><![CDATA[".$row["intSRNO"]."]]></intSRNO>\n";
	$ResponseXML .= "<styleName><![CDATA[".$row["strStyle"]."]]></styleName>\n";	
	$ResponseXML .= "<buyer><![CDATA[".$row["buyer"]."]]></buyer>\n";
	$ResponseXML .= "<intStyleId><![CDATA[".$row["intStyleId"]."]]></intStyleId>\n";
	$ResponseXML .= "<intBPO><![CDATA[".$row["intBPO"]."]]></intBPO>\n";
	$ResponseXML .= "<bpoQty><![CDATA[".$row["bpoQty"]."]]></bpoQty>\n";
	$ResponseXML .= "<odrColor><![CDATA[".$row["strOrderColorCode"]."]]></odrColor>\n";
	$ResponseXML .= "<fty><![CDATA[".$row["fty"]."]]></fty>\n";
	$ResponseXML .= "<xFacDate><![CDATA[".$row["xFacDate"]."]]></xFacDate>\n";
	$ResponseXML .= "<handOverDate><![CDATA[".$row["handOverDate"]."]]></handOverDate>\n";
	$ResponseXML .= "<dateofDelivery><![CDATA[".$row["dateofDelivery"]."]]></dateofDelivery>\n";
	$ResponseXML .= "<shpMode><![CDATA[".$row["strDescription"]."]]></shpMode>\n";
	$ResponseXML .= "<strCountry><![CDATA[".$row["strCountry"]."]]></strCountry>\n";
	$ResponseXML .= "<reaFOB><![CDATA[".$row["reaFOB"]."]]></reaFOB>\n";
	$ResponseXML .= "<smv><![CDATA[".$row["reaSMV"]."]]></smv>\n";
	$ResponseXML .= "<CM><![CDATA[".$row["reaCMforPowiseCostingRpt"]."]]></CM>\n";

}
$ResponseXML .= "</XMLLoadDetails>\n";
echo $ResponseXML;
}


else if($RequestType == "getBPo"){
	header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
 	$ResponseXML="";
	
    $stytleOrSc = $_GET["stytleOrSc"];
	$type = $_GET["type"];

	   $SQL = "SELECT
				deliveryschedule.intBPO,
				specification.intSRNO,
				orders.strStyle,
				specification.intStyleId
				FROM
				deliveryschedule
				INNER JOIN specification ON deliveryschedule.intStyleId = specification.intStyleId
				INNER JOIN orders ON deliveryschedule.intStyleId = orders.intStyleId";
				
				if($type == 'sc'){
				$SQL .= " WHERE specification.intStyleId ='$stytleOrSc'";
				}
				
				if($type == 'style'){
				$SQL .= " WHERE specification.intStyleId ='$stytleOrSc'";
				}
				" GROUP BY	deliveryschedule.intBPO	";
	
	//echo $SQL;
	$result = $db->RunQuery($SQL);
		$str .= "<option value=\""."Select One"."\" selected=\"selected\">Select One</option>";
		$str .= "<option value=\""."#Main Ratio#"."\" >#Main Ratio#</option>";
	while($row=mysql_fetch_array($result))
	{
		$str .=  "<option value=\"". $row["intBPO"] ."\">" . $row["intBPO"] ."</option>" ;
	}
	
	
	$ResponseXML.="<OrderNoList>";
	$ResponseXML.="<OrderNo><![CDATA[" .$str. "]]></OrderNo>\n";
	$ResponseXML.="</OrderNoList>";
	echo $ResponseXML;
}



//Start functions

function GetBuyerPoName($buyerPoId)
{
global $db;
$sql="select strBuyerPoName from style_buyerponos where strBuyerPONO='$buyerPoId'";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
return $row["strBuyerPoName"];
}

function GetPoDetails($styleId,$bpo,$matId)
{
global $db;

//echo "bpo = ".$bpo." mat = ".$matId;
$sql="SELECT
purchaseorderdetails.intPoNo,
purchaseorderdetails.intStyleId,
purchaseorderdetails.intMatDetailID,
Sum(purchaseorderdetails.dblQty) AS PoQty,
purchaseorderdetails.strBuyerPONO
FROM
purchaseorderdetails
WHERE
purchaseorderdetails.intStyleId = '$styleId' AND
purchaseorderdetails.strBuyerPONO = '$bpo' AND
purchaseorderdetails.intMatDetailID = '$matId' 
GROUP BY
purchaseorderdetails.intStyleId,
purchaseorderdetails.strBuyerPONO,
purchaseorderdetails.intMatDetailID";
$result=$db->RunQuery($sql);

//echo $sql;
$row=mysql_fetch_array($result);
return $row["PoQty"];
}


function GetGrnQty($styleId,$bpo,$matId)
{
global $db;

//echo "bpo = ".$bpo." mat = ".$matId;
$sql="SELECT
grndetails.intGrnNo,
grndetails.intStyleId,
grndetails.strBuyerPONO,
grndetails.intMatDetailID,
Sum(grndetails.dblQty) AS grnQty
FROM
grndetails
WHERE
grndetails.intStyleId = '$styleId' AND
grndetails.intMatDetailID = '$matId' AND
grndetails.strBuyerPONO = '$bpo'
GROUP BY
grndetails.intStyleId,
grndetails.strBuyerPONO,
grndetails.intMatDetailID";
$result=$db->RunQuery($sql);

//echo $sql;
$row=mysql_fetch_array($result);
return $row["grnQty"];
}


function GetGpToPrasaraQty($styleId,$bpo,$matId)
{
global $db;

//echo "bpo = ".$bpo." mat = ".$matId;
$sql="SELECT DISTINCT
GP.intGatePassNo AS gatePassNo,
GP.intGPYear AS gatePassYear,
mainstores.strName,
GP.dtmDate,
GP.intStatus,
GPD.intStyleId,
GPD.strBuyerPONO,
GPD.intMatDetailId,
Sum(GPD.dblQty) AS gpQty
FROM
	gatepass AS GP
INNER JOIN gatepassdetails AS GPD ON GP.intGatePassNo = GPD.intGatePassNo
AND GP.intGPYear = GPD.intGPYear
INNER JOIN mainstores ON GP.strTo = mainstores.strMainID
WHERE
GP.intGatePassNo != 0 AND
GP.strCategory = 'I' AND
GP.intCompany = 17 AND
GP.strTo = 24 AND
GPD.intStyleId = '$styleId' AND
GPD.strBuyerPONO = '$bpo' AND
GPD.intMatDetailId = '$matId'
GROUP BY
GPD.intStyleId,
GPD.strBuyerPONO,
GPD.intMatDetailId";
$result=$db->RunQuery($sql);

//echo $sql;
$row=mysql_fetch_array($result);
return $row["gpQty"];
}



function GetTransInCWH($styleId,$bpo,$matId)
{
global $db;

//echo "bpo = ".$bpo." mat = ".$matId;
$sql="SELECT
gategasstransferindetails.intStyleId,
gategasstransferindetails.strBuyerPONO,
gategasstransferindetails.intMatDetailId,
sum(gategasstransferindetails.dblQty) as transInQty
FROM
gategasstransferinheader
INNER JOIN gategasstransferindetails ON gategasstransferinheader.intTransferInNo = gategasstransferindetails.intTransferInNo AND gategasstransferinheader.intTINYear = gategasstransferindetails.intTINYear
INNER JOIN gatepass ON gategasstransferinheader.intGatePassNo = gatepass.intGatePassNo
AND gategasstransferinheader.intGPYear = gatepass.intGPYear
WHERE
gategasstransferinheader.intCompanyId = 17 AND gatepass.strTo = 21 AND
gategasstransferindetails.intStyleId = '$styleId' AND
gategasstransferindetails.strBuyerPONO = '$bpo' AND
gategasstransferindetails.intMatDetailId = '$matId'
GROUP BY
gategasstransferindetails.intStyleId,
gategasstransferindetails.strBuyerPONO,
gategasstransferindetails.intMatDetailId";
$result=$db->RunQuery($sql);

//echo $sql;
$row=mysql_fetch_array($result);
return $row["transInQty"];
}


function GetGpToFTY($styleId,$bpo,$matId)
{
global $db;

//echo "bpo = ".$bpo." mat = ".$matId;
$sql="SELECT DISTINCT
GP.intGatePassNo AS gatePassNo,
GP.intGPYear AS gatePassYear,
mainstores.strName,
GP.dtmDate,
GP.intStatus,
GPD.intStyleId,
GPD.strBuyerPONO,
GPD.intMatDetailId,
Sum(GPD.dblQty) AS gpFtyQty
FROM
	gatepass AS GP
INNER JOIN gatepassdetails AS GPD ON GP.intGatePassNo = GPD.intGatePassNo
AND GP.intGPYear = GPD.intGPYear
INNER JOIN mainstores ON GP.strTo = mainstores.strMainID
WHERE
GP.intGatePassNo != 0 AND
GP.strCategory = 'I' AND
GP.intCompany = 17 AND
GP.strTo <> 24 AND
GPD.intStyleId = '$styleId' AND
GPD.strBuyerPONO = '$bpo' AND
GPD.intMatDetailId = '$matId'
GROUP BY
GPD.intStyleId,
GPD.strBuyerPONO,
GPD.intMatDetailId";
$result=$db->RunQuery($sql);

//echo $sql;
$row=mysql_fetch_array($result);
return $row["gpFtyQty"];
}


function GetTransInFTY($styleId,$bpo,$matId)
{
global $db;

//echo "bpo = ".$bpo." mat = ".$matId;
$sql="SELECT
gategasstransferindetails.intStyleId,
gategasstransferindetails.strBuyerPONO,
gategasstransferindetails.intMatDetailId,
sum(gategasstransferindetails.dblQty) as transInFtyQty
FROM
gategasstransferinheader
INNER JOIN gategasstransferindetails ON gategasstransferinheader.intTransferInNo = gategasstransferindetails.intTransferInNo AND gategasstransferinheader.intTINYear = gategasstransferindetails.intTINYear
WHERE
gategasstransferinheader.intCompanyId not In (17,18) AND
gategasstransferindetails.intStyleId = '$styleId' AND
gategasstransferindetails.strBuyerPONO = '$bpo' AND
gategasstransferindetails.intMatDetailId = '$matId'
GROUP BY
gategasstransferindetails.intStyleId,
gategasstransferindetails.strBuyerPONO,
gategasstransferindetails.intMatDetailId";
$result=$db->RunQuery($sql);

//echo $sql;
$row=mysql_fetch_array($result);
return $row["transInFtyQty"];
}

function CalculateFabricCost($sc, $bpoQty, $qty_in_pcs,$mat_type){

$_dblTotalMatCost = 0;

	
	
	$sql_FabCost = "SELECT
	orderdetails.reaConPc as reaConPc,
	orderdetails.reaWastage as reaWastage,
	orderdetails.dblUnitPrice as dblUnitPrice,
	orderdetails.intstatus,
	orderdetails.intOriginNo,
	orderdetails.intStyleId,
	specification.intSRNO
	FROM
	orderdetails
	INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial
	INNER JOIN specification ON orderdetails.intStyleId = specification.intStyleId
	WHERE
	matitemlist.intMainCatID = '$mat_type' AND
	specification.intSRNO ='$sc' AND
	(orderdetails.intstatus = '1' OR
	orderdetails.intstatus IS NULL) ";
	
	$exec_FabCost = mysql_query($sql_FabCost);
		
	while($rowFabric = mysql_fetch_array($exec_FabCost)){
		
		$_dblConPerPc = $rowFabric['reaConPc'];
		
		$_dblWastage = $rowFabric['reaWastage'];
		$_dblUnitPrice = $rowFabric['dblUnitPrice'];
		$_intOriginType = $rowFabric['intOriginNo'];
		//$_dblReqQty =  $bpoQty * $_dblConPerPc; ->
		$_dblReqQty =  $qty_in_pcs * $_dblConPerPc;
		// ***************** qty_in_pcs = cdnQty
		
		//echo "qty_in_pcs = ".$qty_in_pcs ." _dblConPerPc = ".$_dblConPerPc."XX"; 
		
		$_dblWastageQty = ($_dblReqQty /100) * $_dblWastage;
		


		$_dblTotReqQty = ($_dblReqQty + $_dblWastageQty);
	

		$_dblTotalValue = ($_dblTotReqQty * $_dblUnitPrice);

		$_dblCostPerPc = ($_dblTotalValue / $qty_in_pcs); 




		$_dblTotalMatCost +=  ($_dblCostPerPc);


		
	}	
	return $_dblTotalMatCost;
	mysql_close($con_gapro);
}


?>