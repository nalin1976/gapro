<?php 
require_once('../../Connector.php');

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType = $_GET["RequestType"];

//------------Load Style------------------------------------------------------------
if (strcmp($RequestType,"loadStyle") == 0)
{
	$ResponseXML= "<Styles>";
	$factoryID = $_GET["factoryID"];
	
	$sql = "SELECT productiongpheader.intStyleId,O.strStyle,O.strOrderNo FROM productiongpheader  inner join orders O ON productiongpheader.intStyleId = O.intStyleId ";
	if($factoryID!="")
		$sql .="WHERE productiongpheader.intTofactory = '".$factoryID."' ";
	
	$sql .="group by productiongpheader.intStyleId order by O.strOrderNo ASC";
	  global $db;
	  $result = $db->RunQuery($sql);
	  $k=0;
		
	 $ResponseXML1 .= "<style>";
	 $ResponseXML1 .= "<![CDATA[";
	 $ResponseXML1 .="<option value = \"". "" . "\">" . "Select One" . "</option>" ;
		
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML1 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strOrderNo"].' / '.$row["strStyle"] ."</option>";			
		$k++;
	 }
	$ResponseXML1 .= "]]>"."</style>";
	 
	 $ResponseXML = $ResponseXML.$ResponseXML1. "</Styles>";
	 echo $ResponseXML;	
}
//----------------------------------Load Grid ----------------------------------------------
if (strcmp($RequestType,"LoadGrid") == 0)
{
$ResponseXML	= "<Grid>";
$factoryID 		= $_GET["factoryID"];
$styleNo 		= $_GET["styleNo"];
$dateFrom 		= $_GET["dateFrom"];
if($dateFrom!="")
{
	$AppDateFromArray		= explode('/',$dateFrom);
	$GPTransferInDateT;
	$dateFrom = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
}
$dateTo = $_GET["dateTo"];
if($dateTo!="")
{
	$AppDateToArray		= explode('/',$dateTo);
	$GPTransferInDateT;
	$dateTo = $AppDateToArray[2]."-".$AppDateToArray[1]."-".$AppDateToArray[0];
}

$gpFrom 	= $_GET["gpFrom"];
$gpTo 		= $_GET["gpTo"];
	
	$sql = "SELECT O.strOrderNo,O.strStyle,PGH.intGPnumber,PGH.intYear,PGH.dtmDate,PGH.dblTotQty,PGH.intTofactory,C.strName FROM productiongpheader PGH join companies C on PGH.intTofactory=C.intCompanyID inner join orders O on O.intStyleId=PGH.intStyleId WHERE PGH.intTofactory != '#'";
	
if($factoryID!="")
	$sql .=" AND PGH.intTofactory = '".$factoryID."'";
if($styleNo!="")
	$sql .=" AND PGH.intStyleId = '".$styleNo."'";
if($dateFrom!="")
	$sql .=" AND PGH.dtmDate >= '".$dateFrom."'";
if($dateTo!="")
	$sql .=" AND PGH.dtmDate <= '".$dateTo."'";
if($gpFrom!="")
	$sql .=" AND PGH.intGPnumber >= '".$gpFrom."'";
if($gpTo!="")
	$sql .=" AND PGH.intGPnumber <= '".$gpTo."'";
  
  	$sql .="  ORDER BY PGH.intGPnumber DESC";
 
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<GPnumber><![CDATA[" . $row["intGPnumber"]  . "]]></GPnumber>\n";
		$ResponseXML .= "<GPYear><![CDATA[" . $row["intYear"]  . "]]></GPYear>\n";
		$ResponseXML .= "<dtmDate><![CDATA[" .  $row["dtmDate"]  . "]]></dtmDate>\n";
		$ResponseXML .= "<TotQty><![CDATA[" . $row["dblTotQty"]  . "]]></TotQty>\n";
		$ResponseXML .= "<Tofactory><![CDATA[" . $row["intTofactory"]  . "]]></Tofactory>\n";
		$ResponseXML .= "<Fromfactory><![CDATA[" . $row["strName"]  . "]]></Fromfactory>\n";
		$ResponseXML .= "<OrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></OrderNo>\n";
		$ResponseXML .= "<StyleNo><![CDATA[" . $row["strStyle"]  . "]]></StyleNo>\n";
	}	 
 $ResponseXML .= "</Grid>";
 echo $ResponseXML;	
}

if (strcmp($RequestType,"URLGetCurrentDate") == 0)
{
$ResponseXML  = "<XMLGetCurrentDate>";
	$ResponseXML .= "<CurrentDate><![CDATA[" . date('d/m/Y') . "]]></CurrentDate>\n";
$ResponseXML .= "</XMLGetCurrentDate>";
echo $ResponseXML;
}