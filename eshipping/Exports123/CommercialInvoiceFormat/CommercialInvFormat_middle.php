<?php
session_start();
require_once('../../Connector.php');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$request=$_GET['request'];

if($request=="loadDetails")
{
	$ResponseXml='';
	$cboview=$_GET['cboview'];

	$ResponseXML .= "<RequestDetails>\n";
	
	$sql="SELECT * FROM commercialinvformat WHERE intCommercialInvId='$cboview' ;";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<Commercial><![CDATA[".($row["strCommercialInv"])  . "]]></Commercial>\n";	
		$ResponseXML .= "<Buyer><![CDATA[".($row["intBuyer"])  . "]]></Buyer>\n";
		$ResponseXML .= "<Destination><![CDATA[".($row["intDestination"])  . "]]></Destination>\n";
		$ResponseXML .= "<Transport><![CDATA[".($row["intTrnsMode"])  . "]]></Transport>\n";
		$ResponseXML .= "<PTline1><![CDATA[".($row["strPtLine1"])  . "]]></PTline1>\n";	
		$ResponseXML .= "<PTline2><![CDATA[".($row["strPtLine2"])  . "]]></PTline2>\n";
		$ResponseXML .= "<PTline3><![CDATA[".($row["strPtLine3"])  . "]]></PTline3>\n";
		$ResponseXML .= "<PTnotify1><![CDATA[".($row["intNotify1"])  . "]]></PTnotify1>\n";	
		$ResponseXML .= "<PTnotify2><![CDATA[".($row["intNotify2"])  . "]]></PTnotify2>\n";
		$ResponseXML .= "<PTnotify3><![CDATA[".($row["intNotify3"])  . "]]></PTnotify3>\n";
		$ResponseXML .= "<Accountee><![CDATA[".($row["intAccountee"])  . "]]></Accountee>\n";
		$ResponseXML .= "<CSC><![CDATA[".($row["intCsc"])  . "]]></CSC>\n";
		$ResponseXML .= "<Deliveryto><![CDATA[".($row["intDeliveryTo"])  . "]]></Deliveryto>\n";
		$ResponseXML .= "<Incoterm><![CDATA[".($row["intIncoTerm"])  . "]]></Incoterm>\n";	
		
		$ResponseXML .= "<Authorise><![CDATA[".($row["intAuthorisedPerson"])  . "]]></Authorise>\n";
		$ResponseXML .= "<MMline1><![CDATA[".($row["strMMLine1"])  . "]]></MMline1>\n";	
		$ResponseXML .= "<MMline2><![CDATA[".($row["strMMLine2"])  . "]]></MMline2>\n";
		$ResponseXML .= "<MMline3><![CDATA[".($row["strMMLine3"])  . "]]></MMline3>\n";
		$ResponseXML .= "<MMline4><![CDATA[".($row["strMMLine4"])  . "]]></MMline4>\n";
		$ResponseXML .= "<MMline5><![CDATA[".($row["strMMLine5"])  . "]]></MMline5>\n";
		$ResponseXML .= "<MMline6><![CDATA[".($row["strMMLine6"])  . "]]></MMline6>\n";
		$ResponseXML .= "<MMline7><![CDATA[".($row["strMMLine7"])  . "]]></MMline7>\n";
		$ResponseXML .= "<SMline1><![CDATA[".($row["strSMLine1"])  . "]]></SMline1>\n";
		$ResponseXML .= "<SMline2><![CDATA[".($row["strSMLine2"])  . "]]></SMline2>\n";
		$ResponseXML .= "<SMline3><![CDATA[".($row["strSMLine3"])  . "]]></SMline3>\n";
		$ResponseXML .= "<SMline4><![CDATA[".($row["strSMLine4"])  . "]]></SMline4>\n";
		$ResponseXML .= "<SMline5><![CDATA[".($row["strSMLine5"])  . "]]></SMline5>\n";
		$ResponseXML .= "<SMline6><![CDATA[".($row["strSMLine6"])  . "]]></SMline6>\n";
		$ResponseXML .= "<SMline7><![CDATA[".($row["strSMLine7"])  . "]]></SMline7>\n";
		
		$ResponseXML .= "<strBuyerTitle><![CDATA[".($row["strBuyerTitle"])  . "]]></strBuyerTitle>\n";
		$ResponseXML .= "<strBrokerTitle><![CDATA[".($row["strBrokerTitle"])  . "]]></strBrokerTitle>\n";
		$ResponseXML .= "<strAccounteeTitle><![CDATA[".($row["strAccounteeTitle"])  . "]]></strAccounteeTitle>\n";
		$ResponseXML .= "<strNotify1Title><![CDATA[".($row["strNotify1Title"])  . "]]></strNotify1Title>\n";
		$ResponseXML .= "<strNotify2Title><![CDATA[".($row["strNotify2Title"])  . "]]></strNotify2Title>\n";
		$ResponseXML .= "<strCSCTitle><![CDATA[".($row["strCSCTitle"])  . "]]></strCSCTitle>\n";
		$ResponseXML .= "<strSoldTitle><![CDATA[".($row["strSoldTitle"])  . "]]></strSoldTitle>\n";
		$ResponseXML .= "<BuyerBank><![CDATA[".($row["strBuyerBank"])  . "]]></BuyerBank>\n";
		$ResponseXML .= "<IncoDesc><![CDATA[".($row["strIncoDesc"])  . "]]></IncoDesc>\n";
		$ResponseXML .= "<Forwader><![CDATA[".($row["strForwader"])  . "]]></Forwader>\n";
			
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}

if($request=="load_format_details")
{
	$ResponseXml='';
	$format_id=$_GET['format_id'];

	$ResponseXML .= "<RequestDetails>\n";
	
	$sql="SELECT * FROM commercialinvoicedocuments WHERE intFormatId='$format_id' ;";
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{		
		
		$ResponseXML .= "<DocumentId><![CDATA[".($row["intDocumentId"])  . "]]></DocumentId>\n";		
			
	}
	$ResponseXML .= "</RequestDetails>";
	echo $ResponseXML;
}
?>