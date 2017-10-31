<?php 
session_start();
require_once('../../Connector.php');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
$request=$_GET['req'];
$po=$_GET['po'];
$ResponseXml='';
if($request=="loadOutSideWashPriceDet")
{
	$ResponseXml="<loadDet>";
	$resDet= loadOutSideWashPriceData($po);
	while($rowS=mysql_fetch_array($resDet))
	{
		$ResponseXml.="<Style><![CDATA[" .$rowS['strStyleNo']. "]]></Style>\n";
		$ResponseXml.="<StyleDes><![CDATA[" .$rowS['strStyleDes']. "]]></StyleDes>\n";
		$ResponseXml.="<Color><![CDATA[" .$rowS['strColor']. "]]></Color>\n";
		$ResponseXml.="<Factory><![CDATA[" .$rowS['strName']. "]]></Factory>\n";
		$ResponseXml.="<Garment><![CDATA[" .$rowS['intGarment']. "]]></Garment>\n";
		$ResponseXml.="<FabricDsc><![CDATA[" .$rowS['strFabricDsc']. "]]></FabricDsc>\n";
		$ResponseXml.="<WashType><![CDATA[" .$rowS['intWashType']. "]]></WashType>\n";
	}	
	$ResponseXml.="</loadDet>";
	echo $ResponseXml;
}
function loadOutSideWashPriceData($po){
	global $db;
	$sql="SELECT
		was_outsidepo.strStyleNo,
		was_outsidepo.strStyleDes,
		was_outsidepo.intGarment,
		was_outsidepo.intWashType,
		was_outsidepo.intFactory,
		was_outsidepo.strColor,
		was_outsidepo.intFabId,
		was_outsidewash_fabdetails.strFabricId,
		was_outsidewash_fabdetails.strFabricDsc,
		was_outside_companies.strName
		FROM
		was_outsidepo
		Inner Join was_outsidewash_fabdetails ON was_outsidewash_fabdetails.intId = was_outsidepo.intFabId
		Inner Join was_outside_companies ON was_outsidepo.intFactory = was_outside_companies.intCompanyID
		WHERE
		was_outsidepo.intId = '$po';";
		return $db->RunQuery($sql);
}

?>
