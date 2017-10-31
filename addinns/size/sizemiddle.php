<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];

if (strcmp($RequestType,"GetDivision") == 0)
{
	 $ResponseXML = "";
	 $buyerID=$_GET["CustID"];
	 $ResponseXML .= "<Divisions>\n";
	 //$result=getDivision($buyerID);
	 $SQL_BuyerDivision="SELECT intDivisionId,strDivision FROM buyerdivisions b where intStatus=1 and intBuyerID=".$buyerID.";";
	 $result_BuyerDivision = $db->RunQuery($SQL_BuyerDivision);
	 while($row = mysql_fetch_array($result_BuyerDivision))
  	 {
		 $ResponseXML .= "<DivisionID><![CDATA[" . $row["intDivisionId"]  . "]]></DivisionID>\n";
         $ResponseXML .= "<Division><![CDATA[" . $row["strDivision"]  . "]]></Division>\n";                
	 }
	 $ResponseXML .= "</Divisions>";
	 echo $ResponseXML;
	
}

if (strcmp($RequestType,"GetBuyerDivisionColors") == 0)
{
	 $ResponseXML = "";
	 $BuyerID = $_GET["BuyerID"];
	 $DivisionID = $_GET["DivisionID"];
	 $ResponseXML .= "<RequestDetails>\n";
	 //$result=getBuyerDivisionColors($BuyerID,$DivisionID);
	 $SQL_BuyerDivisionColor="select distinct strSize from sizes where intCustomerId = " . $BuyerID . " AND intDivisionID = " . $DivisionID . " AND intStatus = 1;";
	 $result_BuyerDivisionColor = $db->RunQuery($SQL_BuyerDivisionColor);
	 while($row = mysql_fetch_array($result_BuyerDivisionColor))
  	 {
		 $ResponseXML .= "<Color><![CDATA[" . $row["strSize"]  . "]]></Color>\n";
	 }
	 $ResponseXML .= "</RequestDetails>";
	 echo $ResponseXML;	
}



?>