<?php
session_start();
require_once('../../Connector.php');
include "../../production/production.php";	
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
$request=$_GET['req'];
$po=$_GET['poNo'];
$style=$_GET['style'];
$color=$_GET['color'];
$mill=$_GET['mill'];
$division=$_GET['division'];
$factory=$_GET['factory'];
$gpno=$_GET['gpno'];
$fbId=$_GET['fbId'];
$cutno=$_GET['cutno'];
$size=$_GET['size'];
$purpose=$_GET['purpose'];
$qty=$_GET['qty'];
$term=$_GET['term'];
$intCompanyId	= $_SESSION["FactoryID"];

$ResponseXml='';
if($request=="loadOutSideDet")
{
	$ResponseXml="<loadDet>";
	$resDet= loadDet($po);
	while($rowS=mysql_fetch_array($resDet))
	{
		$ResponseXml.="<Style><![CDATA[" .$rowS['strStyleNo']. "]]></Style>\n";
		$ResponseXml.="<Color><![CDATA[" .$rowS['strColor']. "]]></Color>\n";
		$ResponseXml.="<MillId><![CDATA[" .$rowS['strSupplierID']. "]]></MillId>\n";
		$ResponseXml.="<Mill><![CDATA[" .$rowS['strTitle']. "]]></Mill>\n";
		$ResponseXml.="<DivisionId><![CDATA[" .$rowS['intDivisionId']. "]]></DivisionId>\n";
		$ResponseXml.="<Division><![CDATA[" .$rowS['strDivision']. "]]></Division>\n";
		$ResponseXml.="<FactoryId><![CDATA[" .$rowS['intCompanyID']. "]]></FactoryId>\n";
		$ResponseXml.="<Factory><![CDATA[" .$rowS['strName']. "]]></Factory>\n";
		$ResponseXml.="<FabricId><![CDATA[" .$rowS['strFabricId']. "]]></FabricId>\n";
		$ResponseXml.="<Fabric><![CDATA[" .$rowS['intId']. "]]></Fabric>\n";
		$ResponseXml.="<Size><![CDATA[" .$rowS['strSize']. "]]></Size>\n";
		$ResponseXml.="<Qty><![CDATA[" .$rowS['dblWashQty']. "]]></Qty>\n";
	}	
	$ResponseXml.="</loadDet>";
	echo $ResponseXml;
}
if($request=="saveOutSideDet")
{
	$ResponseXml="<saveDet>";
		$ResponseXml.="<Result><![CDATA[" .saveDet($po,$gpno,$color,$division,$factory,$mill,$fbId,$cutno,$size,$purpose,$qty,$term,$style). "]]></Result>\n"; 
	$ResponseXml.="</saveDet>
	";
	echo $ResponseXml;
}
function loadDet($po){
		global $db;
		$sql_loadDet="SELECT
					was_outsidepo.strStyleNo,
					was_outsidepo.strStyleDes,
					was_outsidepo.strColor,
					was_outsidepo.strSize,
					was_outsidepo.dblWashQty,
					was_outsidewash_fabdetails.strFabricId,
					was_washtype.strWasType,
					was_washtype.intWasID,
					was_outside_companies.strName,
					was_outside_companies.intCompanyID,
					suppliers.strSupplierID,
					suppliers.strTitle,
					buyerdivisions.intDivisionId,
					buyerdivisions.strDivision,
					was_outsidewash_fabdetails.intId
					FROM
					was_outsidepo
					Inner Join was_outsidewash_fabdetails ON was_outsidewash_fabdetails.intId = was_outsidepo.intFabId
					Inner Join was_washtype ON was_outsidepo.intWashType = was_washtype.intWasID
					Inner Join was_outside_companies ON was_outside_companies.intCompanyID = was_outsidepo.intFactory
					Inner Join suppliers ON was_outsidepo.intMill = suppliers.strSupplierID
					Inner Join buyerdivisions ON was_outsidewash_fabdetails.intBuyer = buyerdivisions.intBuyerID AND was_outsidewash_fabdetails.intDivision = buyerdivisions.intDivisionId
					WHERE
					was_outsidepo.intId= '$po';";
					//echo $sql_loadDet;
	return $db->RunQuery($sql_loadDet);
}


function saveDet($po,$gpno,$color,$division,$factory,$mill,$fbId,$cutno,$size,$purpose,$qty,$term,$style){
global $db;
$sql="insert into 	was_oustside_issuedtowash(intPoNo,intGpNo,strColor,intDivision,intFacId,intMill,intFabId,intCutNo,strSize,strPurpose,dblQty,strTerm)
values('$po','$gpno','$color','$division','$factory','$mill','$fbId','$cutno','$size','$purpose','$qty','$term');";
$res=$db->RunQuery($sql);
	if($res==1)
	{
		return true;
	}
	else
	{
		return false;
	}
} 
?>