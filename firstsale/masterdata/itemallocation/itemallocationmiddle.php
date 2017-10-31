<?php
include "../../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$requestType = $_GET["RequestType"];

if($requestType=="LoadFormulas")
{
$ResponseXML = "<XMLLoadFormulas>";
$buyerId	 = $_GET["BuyerId"];
$subCatId	 = $_GET["SubCatId"];
$sql="select intUnitPriceFormulaId,intConPcFormulaId from firstsale_formulaallocation where intBuyerId=$buyerId and intSubCatId=$subCatId";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<UnitPriceFormulaId><![CDATA[" . $row["intUnitPriceFormulaId"]  . "]]></UnitPriceFormulaId>\n";
	$ResponseXML .= "<ConPcFormulaId><![CDATA[" . $row["intConPcFormulaId"]  . "]]></ConPcFormulaId>\n";
}
$ResponseXML .= "</XMLLoadFormulas>";
echo $ResponseXML;
}
?>