<?php
include "../Connector.php";
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
				materialratio.intStyleId,
				materialratio.strBuyerPONO,
				materialratio.strMatDetailID,
				Sum(materialratio.dblQty) AS matQty,
				materialratio.intStatus,
				orders.intBuyerID,
				matitemlist.strItemDescription,
				matmaincategory.strDescription,
				matitemlist.strUnit,
				buyers.strName
				FROM
				materialratio
				INNER JOIN orders ON materialratio.intStyleId = orders.intStyleId
				INNER JOIN matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial
				INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
				INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID
				INNER JOIN specification ON materialratio.intStyleId = specification.intStyleId
				WHERE
				materialratio.intStatus = 1 AND
				materialratio.intStyleId = '$styleId'";

				if($bpo != 'Select One'){
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
				matmaincategory.intID ASC";
				
				
$result=$db->RunQuery($sql);
//echo $sql;
while($row=mysql_fetch_array($result))
{
	//if(trim($row["strBuyerPoNo"])=="#Main Ratio#")
	//	$buyerPoNo = "#Main Ratio#";
//	else 
		//$buyerPoNo = GetBuyerPoName($row["strBuyerPoNo"]);
	//	echo "bpo =".$row["strBuyerPoNo"];
	$poQty = GetPoDetails($styleId,$row["strBuyerPONO"],$row["strMatDetailID"]);
	$grnQty = GetGrnQty($styleId,$row["strBuyerPONO"],$row["strMatDetailID"]);
	
	
			
	$ResponseXML .= "<intSRNO><![CDATA[".$row["intSRNO"]."]]></intSRNO>\n";
	$ResponseXML .= "<strBuyerPONO><![CDATA[".$row["strBuyerPONO"]."]]></strBuyerPONO>\n";
	$ResponseXML .= "<strMatDetailID><![CDATA[".$row["strItemDescription"]."]]></strMatDetailID>\n";
	$ResponseXML .= "<matQty><![CDATA[".$row["matQty"]." ".$row["strUnit"]."]]></matQty>\n";
	$ResponseXML .= "<poQty><![CDATA[".$poQty." ".$row["strUnit"]."]]></poQty>\n";
	$ResponseXML .= "<grnQty><![CDATA[".$grnQty." ".$row["strUnit"]."]]></grnQty>\n";
	$ResponseXML .= "<styleId><![CDATA[".$row["intStyleId"]."]]></styleId>\n";
	$ResponseXML .= "<matId><![CDATA[".$row["strMatDetailID"]."]]></matId>\n";

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
?>