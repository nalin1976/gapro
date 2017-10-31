<?php
include "../Connector.php";
$xml = simplexml_load_file('../../config.xml');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];

if ($RequestType=="LoadDetails")
{

	$userName 		= $_GET["userName"];	
	
	$ResponseXML .="<LoadGatePassNo>\n";
	
$sql="SELECT *, ".
"(select strName from companies where usercontact.intCompanyID=companies.intCompanyID)AS CompName ".
 "FROM usercontact ".
 "where strUserName like '%$userName%' ".
 "ORDER BY intUserID";
 //echo $sql;
	$result=$db->RunQuery($sql);
	
		while ($row=mysql_fetch_array($result))
		{
			$ResponseXML .="<UserID><![CDATA[".$row["intUserID"]."]]></UserID>\n";
			$ResponseXML .="<UserName><![CDATA[".$row["strUserName"]."]]></UserName>\n";
			$ResponseXML .="<CompName><![CDATA[".$row["CompName"]."]]></CompName>\n";
			$ResponseXML .="<Departement><![CDATA[".$row["strDepartement"]."]]></Departement>\n";
			$ResponseXML .="<FactoryExtension><![CDATA[".$row["intFactoryExtension"]."]]></FactoryExtension>\n";
			$ResponseXML .="<UserExtension><![CDATA[".$row["intUserExtension"]."]]></UserExtension>\n";
			$ResponseXML .="<Remarks><![CDATA[".$row["strRemarks"]."]]></Remarks>\n";
		}
	$ResponseXML .="</LoadGatePassNo>";
	echo $ResponseXML;
}
else if ($RequestType=="SaveDetails")
{
	$userName 		= $_GET["userName"];
	$company 		= $_GET["company"];
	$department 		= $_GET["department"];
	$facExten 		= $_GET["facExten"];
	$userExten 		= $_GET["userExten"];
	$remarks 		= $_GET["remarks"];
	
$sql="INSERT INTO usercontact ". 
	"(strUserName, ".
	"intCompanyID, ".
	"strDepartement, ".
	"intFactoryExtension, ". 
	"intUserExtension, ".
	"strRemarks) ".
	"VALUES ".
	"('$userName', ". 
	"'$company', ".
	"'$department', ". 
	"'$facExten', ".
	"'$userExten', ".
	"'$remarks')";
	
	echo $sql;
	$result=$db->RunQuery($sql);
}
?>