<?php
include "../../Connector.php";
$xml = simplexml_load_file('../../config.xml');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
//$companyId  =$_SESSION["CompanyID"];
//$userId		= $_SESSION["UserID"];
if ($RequestType=="LoadDetailsToTable")
{
$AllowSubContractorToGatePass = $xml->styleInventory->AllowSubContractorToGatePass;


$MarsylkaStyleItemGatepass	= $xml->styleInventory->Gatepass->reportName;

$companyId 			= $_SESSION["FactoryID"];
$chkDate 			= $_GET["chkDate"];
$category 			= $_GET["category"];
$GPDateFrom 		= $_GET["GPDateFrom"];
$GPDateFromArray	= explode('/',$GPDateFrom);
$formatedFromDate	= $GPDateFromArray[2]."-".$GPDateFromArray[1]."-".$GPDateFromArray[0];
$GPDateTO 			= $_GET["GPDateTO"];
$GPDateTOArray		= explode('/',$GPDateTO);
$formatedToDate		= $GPDateTOArray[2]."-".$GPDateTOArray[1]."-".$GPDateTOArray[0];
$gatePassNoFrom 	= $_GET["gatePassNoFrom"];
$GPNOFromArray		= explode('/',$gatePassNoFrom);
$gatePassNoTo 		= $_GET["gatePassNoTo"];
$GPNOToArray		= explode('/',$gatePassNoTo);
$storesCategory		= $_GET["storesCategory"];
$destination 		= $_GET["destination"];

$booCheck	= true;	
	$ResponseXML .="<LoadDetailsToTable>\n";
	
	$SQL="SELECT DISTINCT GP.intGatePassNo AS gatePassNo,GP.intGPYear AS gatePassYear,strName,GP.dtmDate,GP.intStatus, ".
	"(select Name from useraccounts UA where UA.intUserID=GP.intUserId)as userName ".
		 "FROM gatepass AS GP ".
		 "Inner Join gatepassdetails AS GPD ON GP.intGatePassNo = GPD.intGatePassNo AND GP.intGPYear = GPD.intGPYear ";
if($storesCategory=="E"){
	$SQL .= " Inner Join subcontractors ON GP.strTo = subcontractors.strSubContractorID ";
}
elseif($storesCategory=="I"){
	$SQL .= "Inner Join mainstores ON GP.strTo = mainstores.strMainID ";
}
		 $SQL .= " WHERE GP.intGatePassNo !=0 and strCategory='$storesCategory'";
		
	if ($gatePassNoFrom!="")
	{
		$SQL .="AND GP.intGatePassNo >='$GPNOFromArray[1]' AND GP.intGPYear=$GPNOFromArray[0] ";
		$booCheck	= false;	
	}
	if ($gatePassNoTo!="")
	{
		$SQL .="AND GP.intGatePassNo <='$GPNOToArray[1]' AND GP.intGPYear=$GPNOToArray[0] ";
		$booCheck	= false;	
	}
	if ($chkDate=="true")
		{
			if ($formatedFromDate!="")
			{
				$SQL .="AND date(dtmDate) >='$formatedFromDate' ";
				$booCheck	= false;	
			}
			if ($formatedToDate!="")
			{
				$SQL .="AND date(dtmDate) <='$formatedToDate' ";
				$booCheck	= false;	
			}
		}
	if ($companyId!="")
	{
		$SQL .="AND GP.intCompany=$companyId ";
		$booCheck	= false;	
	}
	if ($category!="2")
	{
		$SQL .="AND GP.intStatus =$category ";		
	}
	if($destination !="")
		$SQL .="AND GP.strTo =$destination ";	
		
		$SQL .=" order by dtmDate desc ";
		
	if($booCheck)	
		$SQL .=" limit 0,20";

	$result = $db->RunQuery($SQL);
		while ($row=mysql_fetch_array($result))
			{
				$ResponseXML .="<GatePassNo><![CDATA[".$row["gatePassNo"]."]]></GatePassNo>\n";
				$ResponseXML .="<gatePassYear><![CDATA[".$row["gatePassYear"]."]]></gatePassYear>\n";
				$ResponseXML .="<Date><![CDATA[".$row["dtmDate"]."]]></Date>\n";
				$ResponseXML .="<DestinationName><![CDATA[".$row["strName"]."]]></DestinationName>\n";
				$ResponseXML .="<Status><![CDATA[".$row["intStatus"]."]]></Status>\n";
				$ResponseXML .="<UserName><![CDATA[".$row["userName"]."]]></UserName>\n";
				$ResponseXML .="<ReportName><![CDATA[".$MarsylkaStyleItemGatepass."]]></ReportName>\n";
				
			}
	
	$ResponseXML .="</LoadDetailsToTable> ";
	echo $ResponseXML;
}
if ($RequestType=="LoadGatePassNo")
{
	$category 		= $_GET["category"];
	$storesCategory	= $_GET["storesCategory"];
	
	$ResponseXML .="<LoadGatePassNo>\n";
	
	$SQL ="SELECT DISTINCT CONCAT(intGPYear , '/' , intGatePassNo) AS gatePassNo FROM gatepass ".
		  "WHERE strCategory='$storesCategory' ";
		  
	if ($category!="2")
	{
		$SQL .="AND intStatus ='$category' ";		
	}	  
	  	$SQL .="ORDER BY intGatePassNo,intGPYear ";
		  //echo $SQL; 
	$result=$db->RunQuery($SQL);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<gatePassNo><![CDATA[".$row["gatePassNo"]."]]></gatePassNo>\n";
		}
	$ResponseXML .="</LoadGatePassNo>";
	echo $ResponseXML;
}
?>