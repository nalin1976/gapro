<?php 
session_start();
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];

if (strcmp($RequestType,"OrderList") == 0){
	
	$ResponseXML = "";
	$ResponseXML .= "<DELIVERYSCHEDULE>\n";
	
	$result = GetDeliveryOrderList();
	
	while($row=mysql_fetch_array($result)){
		
		$ResponseXML .= "<COSTINGDATE><![CDATA[" . date("Y-m-d",strtotime($row["dtmDate"])). "]]></COSTINGDATE>\n";
		$ResponseXML .= "<STYLEID><![CDATA[" .$row["strStyle"]. "]]></STYLEID>\n";
		$ResponseXML .= "<STYLECODE><![CDATA[" .$row["intStyleId"]. "]]></STYLECODE>\n";
		$ResponseXML .= "<SCNO><![CDATA[" .$row["intSRNO"]. "]]></SCNO>\n";
		$ResponseXML .= "<STYLEDESC><![CDATA[" .$row["strDescription"]. "]]></STYLEDESC>\n";
		$ResponseXML .= "<BUYER><![CDATA[" .$row["strName"]. "]]></BUYER>\n";
		$ResponseXML .= "<BUYERDIVISION><![CDATA[" .$row["strDivision"]. "]]></BUYERDIVISION>\n";
		$ResponseXML .= "<SEASON><![CDATA[" .$row["strSeason"]. "]]></SEASON>\n";
		$ResponseXML .= "<BUYINGOFFICE><![CDATA[" .$row["BuyingOffice"]. "]]></BUYINGOFFICE>\n";
		$ResponseXML .= "<SMV><![CDATA[" .$row["reaSMV"]. "]]></SMV>\n";
		$ResponseXML .= "<FOB><![CDATA[" .$row["reaFOB"]. "]]></FOB>\n";
		$ResponseXML .= "<EFF><![CDATA[" .$row["reaEfficiencyLevel"]. "]]></EFF>\n";
		$ResponseXML .= "<ORDERQTY><![CDATA[" .$row["intQty"]. "]]></ORDERQTY>\n";
		$ResponseXML .= "<USER><![CDATA[" .$row["Name"]. "]]></USER>\n";
		$ResponseXML .= "<BUYERPONO><![CDATA[" .$row["intBPO"]. "]]></BUYERPONO>\n";
		$ResponseXML .= "<BUYERPOQTY><![CDATA[" .$row["dblQty"]. "]]></BUYERPOQTY>\n";
		$ResponseXML .= "<DELDATE><![CDATA[". date("Y-m-d", strtotime($row["dtDateofDelivery"])). "]]></DELDATE>\n";
		$ResponseXML .= "<HANDODATE><![CDATA[". date("Y-m-d", strtotime($row["dtmHandOverDate"])). "]]></HANDODATE>\n";
		$ResponseXML .= "<UPCHARGE><![CDATA[" .$row["reaUPCharges"]. "]]></UPCHARGE>\n";
		$ResponseXML .= "<SUBQTY><![CDATA[" .$row["intSubContractQty"]. "]]></SUBQTY>\n";
		
		
	}
	
	 $ResponseXML .= "</DELIVERYSCHEDULE>";
	 echo $ResponseXML;
	
}elseif(strcmp($RequestType,"GetFabricCost") == 0){
	
	$_lngStyleCode = $_GET['StyleCode'];
	
	$ResponseXML = "";
	$ResponseXML .= "<FABRICCOST>\n";
	
	$result = GetFabricCost($_lngStyleCode);
	
	while($row=mysql_fetch_array($result)){
	
		$ResponseXML .= "<CONPERPC><![CDATA[".$row["reaConPc"]."]]></CONPERPC>\n";
		$ResponseXML .= "<WASTAGE><![CDATA[".$row["reaWastage"]."]]></WASTAGE>\n";
		$ResponseXML .= "<UNITPRICE><![CDATA[".$row["dblUnitPrice"]."]]></UNITPRICE>\n";
		$ResponseXML .= "<ORIGINTYPE><![CDATA[".$row["intOriginNo"]."]]></ORIGINTYPE>\n";		
		
	}
	
	$ResponseXML .= "</FABRICCOST>";
	echo $ResponseXML;
	
}elseif(strcmp($RequestType,"GetAccPackCost")==0){
	
	$_lngStyleCode = $_GET['StyleCode'];
	
	$ResponseXML = "";
	$ResponseXML .= "<ACCPACKCOST>\n";
	
	$result = GetAccePacking($_lngStyleCode);
	
	while($row=mysql_fetch_array($result)){
	
		$ResponseXML .= "<CONPERPC><![CDATA[".$row["reaConPc"]."]]></CONPERPC>\n";
		$ResponseXML .= "<WASTAGE><![CDATA[".$row["reaWastage"]."]]></WASTAGE>\n";
		$ResponseXML .= "<UNITPRICE><![CDATA[".$row["dblUnitPrice"]."]]></UNITPRICE>\n";
		$ResponseXML .= "<ORIGINTYPE><![CDATA[".$row["intOriginNo"]."]]></ORIGINTYPE>\n";		
		
	}
	
	$ResponseXML .= "</ACCPACKCOST>";
	echo $ResponseXML;	
	
}elseif(strcmp($RequestType,"GetServiceOthers")==0){
	
	$_lngStyleCode = $_GET['StyleCode'];
	
	$ResponseXML = "";
	$ResponseXML .= "<SEROTHERSCOST>\n";
	
	$result = GetServiceOtherCost($_lngStyleCode);
	
	while($row=mysql_fetch_array($result)){
	
		$ResponseXML .= "<CONPERPC><![CDATA[".$row["reaConPc"]."]]></CONPERPC>\n";
		$ResponseXML .= "<WASTAGE><![CDATA[".$row["reaWastage"]."]]></WASTAGE>\n";
		$ResponseXML .= "<UNITPRICE><![CDATA[".$row["dblUnitPrice"]."]]></UNITPRICE>\n";
		$ResponseXML .= "<ORIGINTYPE><![CDATA[".$row["intOriginNo"]."]]></ORIGINTYPE>\n";		
		
	}
	
	$ResponseXML .= "</SEROTHERSCOST>";
	echo $ResponseXML;	
	
}elseif(strcmp($RequestType, "ExRate")==0){
	
	$ResponseXML = "";
	$ResponseXML .= "<EXRATE>\n";
	
	$result = GetLKRExchangeValue();
	
	while($row=mysql_fetch_array($result)){
			
		$ResponseXML .= "<LKRRATE><![CDATA[".$row["dblRateq"]."]]></LKRRATE>\n";
	}
	
	$ResponseXML .= "</EXRATE>";
	echo $ResponseXML;	
	
}


function GetDeliveryOrderList(){
	
global $db;

$strSql = " SELECT orders.strStyle, orders.strDescription, orders.intQty, orders.reaSMV, orders.reaFOB, orders.reaEfficiencyLevel, specification.intSRNO, ".
          "        deliveryschedule.dblQty, deliveryschedule.intBPO, deliveryschedule.dtDateofDelivery, buyers.strName, useraccounts.Name, ".
		  "        deliveryschedule.dtmHandOverDate, orders.dtmDate, orders.intStyleId, buyerdivisions.strDivision, seasons.strSeason,  ".
		  "        buyerbuyingoffices.strName AS BuyingOffice, orders.reaUPCharges, orders.intSubContractQty".
          " FROM   deliveryschedule Inner Join orders ON deliveryschedule.intStyleId = orders.intStyleId Inner Join specification ON ". 
		  "        orders.intStyleId = specification.intStyleId Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID Inner Join useraccounts ON ".  
		  "        orders.intUserID = useraccounts.intUserID Left Join buyerdivisions ON buyers.intBuyerID = buyerdivisions.intBuyerID AND ".
		  "        orders.intDivisionId = buyerdivisions.intDivisionId Left Join seasons ON orders.intSeasonId = seasons.intSeasonId ".
		  "        Left Join buyerbuyingoffices ON buyers.intBuyerID = buyerbuyingoffices.intBuyerID AND orders.intBuyingOfficeId = ".
		  "        buyerbuyingoffices.intBuyingOfficeId ".
          " WHERE  deliveryschedule.dtmHandOverDate between '2013-10-01' AND '2013-10-15' ".
          " ORDER BY deliveryschedule.dtmHandOverDate ";
	
return $db->RunQuery($strSql);
	
}

function GetFabricCost($prmStyleCode){
	
global $db;

$strSql = " SELECT orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.dblUnitPrice, orderdetails.intstatus, orderdetails.intOriginNo ".
          " FROM   orderdetails Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial ".
          " WHERE  matitemlist.intMainCatID =  '1' AND orderdetails.intStyleId = '$prmStyleCode' AND (orderdetails.intstatus =  '1' OR orderdetails.intstatus IS NULL)";
		  
return $db->RunQuery($strSql);
		  
}

function GetAccePacking($prmStyleCode){
	
global $db;
	
$strSql = " SELECT orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.dblUnitPrice, orderdetails.intstatus, orderdetails.intOriginNo, ".
          "        matitemlist.intMainCatID ".
          " FROM   orderdetails Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial  ".
          " WHERE  (matitemlist.intMainCatID = '2' OR matitemlist.intMainCatID = '3') AND orderdetails.intStyleId = '$prmStyleCode' AND " .
		  "        (orderdetails.intstatus = '1' OR orderdetails.intstatus IS NULL)".
          " ORDER BY matitemlist.intMainCatID ";
	
return $db->RunQuery($strSql);	
}

function GetServiceOtherCost($prmStyleCode){
	
global $db;
	
$strSql = " SELECT orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.dblUnitPrice, orderdetails.intstatus, orderdetails.intOriginNo, ".
          "        matitemlist.intMainCatID ".
          " FROM   orderdetails Inner Join matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial  ".
          " WHERE  (matitemlist.intMainCatID = '4' OR matitemlist.intMainCatID = '5') AND orderdetails.intStyleId = '$prmStyleCode' AND " .
		  "        (orderdetails.intstatus = '1' OR orderdetails.intstatus IS NULL)".
          " ORDER BY matitemlist.intMainCatID ";
	
return $db->RunQuery($strSql);	
}

function GetLKRExchangeValue(){
	
global $db;
	
$strSql = " SELECT currencytypes.dblRateq ".
          " FROM   currencytypes ".
		  " WHERE  currencytypes.strCurrency = 'LKR'";
	
return $db->RunQuery($strSql);	
}
	


?>