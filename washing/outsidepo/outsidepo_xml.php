<?php
session_start();
require_once('../../Connector.php');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$request=$_GET['request'];


if($request=="loadDetails")
{

	$ResponseXml='';
	$cboFabric=$_GET['cboFabric'];

	$ResponseXML .= "<RequestDetails>\n";
	$res=getDetail($cboFabric);
	while($row=mysql_fetch_array($res)){
		
		$ResponseXML .= "<Style><![CDATA[".($row["strStyle"])  . "]]></Style>\n";	
		$ResponseXML .= "<Division><![CDATA[".($row["strDivision"])  . "]]></Division>\n";
		$ResponseXML .= "<Divisionid><![CDATA[".($row["intDivision"])  . "]]></Divisionid>\n";
		$ResponseXML .= "<Color><![CDATA[".($row["strColor"])  . "]]></Color>\n";
		$ResponseXML .= "<Garment><![CDATA[".($row["strGarmentName"])  . "]]></Garment>\n";	
		$ResponseXML .= "<Garmentid><![CDATA[".($row["intGarment"])  . "]]></Garmentid>\n";
		$ResponseXML .= "<FabricDes><![CDATA[".($row["strFabricDsc"])  . "]]></FabricDes>\n";
		$ResponseXML .= "<FabricCon><![CDATA[".($row["strFabricContent"])  . "]]></FabricCon>\n";	
		$ResponseXML .= "<Mill><![CDATA[".($row["strTitle"])  . "]]></Mill>\n";
		$ResponseXML .= "<Millid><![CDATA[".($row["strMill"])  . "]]></Millid>\n";
		$ResponseXML .= "<WashType><![CDATA[".($row["strWasType"])  . "]]></WashType>\n";
		$ResponseXML .= "<WashTypeid><![CDATA[".($row["intWashType"])  . "]]></WashTypeid>\n";
		$ResponseXML .= "<Factory><![CDATA[".($row["strName"])  . "]]></Factory>\n";
		$ResponseXML .= "<Factoryid><![CDATA[".($row["intFactory"])  . "]]></Factoryid>\n";	
	
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
function getDetail($cboFabric){
	
	global $db;
$sql_loadDetails="SELECT DISTINCT
			was_outsidewash_fabdetails.strColor,
			was_outsidewash_fabdetails.strFabricDsc,
			was_outsidewash_fabdetails.strFabricId,
			was_outsidewash_fabdetails.strFabricContent,
			was_outsidewash_fabdetails.strStyle,
			was_outsidewash_fabdetails.intDivision,
			was_outsidewash_fabdetails.intFactory,
			was_outsidewash_fabdetails.intGarment,
			was_outsidewash_fabdetails.strMill,
			was_outsidewash_fabdetails.intWashType,
		
			was_washtype.strWasType,
			was_garmenttype.strGarmentName,
			was_outside_companies.strName,
			suppliers.strTitle,
			buyerdivisions.intDivisionId,
			buyerdivisions.strDivision,
			was_outsidewash_fabdetails.intStatus
			FROM
			was_outsidewash_fabdetails
			
			Inner Join was_washtype ON was_washtype.intWasID = was_outsidewash_fabdetails.intWashType
			Inner Join suppliers ON suppliers.strSupplierID = was_outsidewash_fabdetails.strMill
			Inner Join was_garmenttype ON was_outsidewash_fabdetails.intGarment = was_garmenttype.intGamtID
			Inner Join was_outside_companies ON was_outside_companies.intCompanyID = was_outsidewash_fabdetails.intFactory
			Inner Join buyerdivisions on buyerdivisions.intBuyerID=was_outsidewash_fabdetails.intBuyer AND 						buyerdivisions.intDivisionId=was_outsidewash_fabdetails.intDivision
WHERE  was_outsidewash_fabdetails.intId='$cboFabric';";
	return $db->RunQuery($sql_loadDetails);
}

if($request=="searchData")
{
$searchcmb	=$_GET['searchcmb'];

	$ResponseXML = "<RequestDetails>\n";
	
	$sql="SELECT DISTINCT
			was_outsidepo.intPONo,
			was_outsidewash_fabdetails.strFabricId,
			was_outsidepo.intFabId,
			was_outsidepo.strStyleNo,
			buyerdivisions.strDivision,
			was_outsidepo.intDivision,
			was_outsidepo.strColor,
			was_garmenttype.strGarmentName,
			was_outsidepo.intGarment,
			was_outsidepo.strSize,
			was_outsidepo.dblOrderQty,
			was_outsidepo.dblCutQty,
			was_outsidepo.dblWashQty,
			was_outsidepo.dtmDate,
			was_outsidepo.strStyleDes,
			was_outsidewash_fabdetails.strFabricDsc,
			was_outsidewash_fabdetails.strFabricContent,
			suppliers.strTitle,
			was_outsidepo.intMill,
			was_washtype.strWasType,
			was_outsidepo.intWashType,
			was_outside_companies.strName,
			was_outsidepo.intFactory,
			was_outsidepo.dblEx
			FROM
			was_outsidepo,
			was_outsidewash_fabdetails,
			was_outside_companies,
			buyerdivisions,
			suppliers,
			was_washtype,
			was_garmenttype
			where
			was_outsidepo.intFabId=was_outsidewash_fabdetails.intId and 
			was_outsidepo.intMill=suppliers.strSupplierID and
			was_outsidepo.intWashType=was_washtype.intWasID and
			was_outsidepo.intFactory=was_outside_companies.intCompanyID and
			was_outsidepo.intDivision=buyerdivisions.intDivisionId and
			was_outsidepo.intGarment=was_garmenttype.intGamtID and
			was_outsidepo.intId='$searchcmb';";
	
		$result=$db->RunQuery($sql) ;		
		while($row=mysql_fetch_array($result)){
		
		$ResponseXML .= "<PONo><![CDATA[".($row["intPONo"])  . "]]></PONo>\n";
		$ResponseXML .= "<FabID><![CDATA[".($row["strFabricId"])  . "]]></FabID>\n";
		$ResponseXML .= "<Fabrid><![CDATA[".($row["intFabId"])  . "]]></Fabrid>\n";
		$ResponseXML .= "<strStyleNo><![CDATA[".($row["strStyleNo"])  . "]]></strStyleNo>\n";	
		$ResponseXML .= "<Division><![CDATA[".($row["strDivision"])  . "]]></Division>\n";
		$ResponseXML .= "<Divisionid><![CDATA[".($row["intDivision"])  . "]]></Divisionid>\n";
		$ResponseXML .= "<Color><![CDATA[".($row["strColor"])  . "]]></Color>\n";
		$ResponseXML .= "<Garment><![CDATA[".($row["strGarmentName"])  . "]]></Garment>\n";	
		$ResponseXML .= "<Garmentid><![CDATA[".($row["intGarment"])  . "]]></Garmentid>\n";
		$ResponseXML .= "<Size><![CDATA[".($row["strSize"])  . "]]></Size>\n";
		$ResponseXML .= "<OrderQty><![CDATA[".($row["dblOrderQty"])  . "]]></OrderQty>\n";
		$ResponseXML .= "<CutQty><![CDATA[".($row["dblCutQty"])  . "]]></CutQty>\n";
		$ResponseXML .= "<WashQty><![CDATA[".($row["dblWashQty"])  . "]]></WashQty>\n";
		$ResponseXML .= "<Date><![CDATA[".($row["dtmDate"])  . "]]></Date>\n";
		$ResponseXML .= "<StyleName><![CDATA[".($row["strStyleDes"])  . "]]></StyleName>\n";
		$ResponseXML .= "<FabricDes><![CDATA[".($row["strFabricDsc"])  . "]]></FabricDes>\n";
		$ResponseXML .= "<FabricCon><![CDATA[".($row["strFabricContent"])  . "]]></FabricCon>\n";	
		$ResponseXML .= "<Mill><![CDATA[".($row["strTitle"])  . "]]></Mill>\n";
		$ResponseXML .= "<Millid><![CDATA[".($row["intMill"])  . "]]></Millid>\n";
		$ResponseXML .= "<WashType><![CDATA[".($row["strWasType"])  . "]]></WashType>\n";
		$ResponseXML .= "<WashTypeid><![CDATA[".($row["intWashType"])  . "]]></WashTypeid>\n";
		$ResponseXML .= "<Factory><![CDATA[".($row["strName"])  . "]]></Factory>\n";
		$ResponseXML .= "<Factoryid><![CDATA[".($row["intFactory"])  . "]]></Factoryid>\n";	
		$ResponseXML .= "<Ex><![CDATA[".($row["dblEx"])  . "]]></Ex>\n";	
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
?>