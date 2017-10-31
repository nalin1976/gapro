<?php 
require_once('../../Connector.php');
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$RequestType 	= $_GET["RequestType"];
$companyId		= $_SESSION["FactoryID"];
if (strcmp($RequestType,"loadStyle") == 0)
{
	$ResponseXML= "<Styles>";
	$factoryID = $_GET["factoryID"];
	
	$sql = "SELECT 
	productionfggpheader.intStyleId, 
	orders.strStyle,
	orders.strOrderNo 
	FROM
	  productionfggpheader  LEFT JOIN orders ON productionfggpheader.intStyleId = orders.intStyleId
	 ";
	  if($factoryID!="")
 	 $sql .=" WHERE productionfggpheader.strToFactory = '".$factoryID."' ";
  
	  $sql .="group by productionfggpheader.intStyleId 
	  order by productionfggpheader.intStyleId ASC";

	  global $db;
	  $result = $db->RunQuery($sql);
	  $k=0;
		
	 $ResponseXML1 .= "<style>";
	 $ResponseXML1 .= "<![CDATA[";
	 $ResponseXML1 .="<option value = \"". "" . "\">" . "Select One" . "</option>" ;
		
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML1 .= "<option value=\"". $row["intStyleId"] ."\">" . $row["strStyle"] ."</option>";
			
		$k++;
	 }
	$ResponseXML1 .= "]]>"."</style>";
	 
	 $ResponseXML = $ResponseXML.$ResponseXML1. "</Styles>";
	 echo $ResponseXML;	
}
//----------------------------------Load Grid ----------------------------------------------

if(strcmp($RequestType,"loadStyleNo") == 0){
	$ResponseXML= "<Styles>";
	$po = $_GET["po"];
	  $sql="SELECT DISTINCT
	  		O.strStyle
			FROM was_returntofactoryheader
			INNER JOIN orders as O ON was_returntofactoryheader.intStyleId = O.intStyleId
			WHERE
			O.intStyleId='$po';";

	 $result = $db->RunQuery($sql);
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<sNo><![CDATA[" . $row["strStyle"]  . "]]></sNo>\n";
	 }
	$ResponseXML .= "</Styles>";
	echo $ResponseXML;	
}
if(strcmp($RequestType,"loadPoNo") == 0){
	$ResponseXML= "<Styles>";
	$po = $_GET["po"];
	  $sql="SELECT DISTINCT
			was_returntofactoryheader.intStyleId
			FROM
			orders AS O
			INNER JOIN was_returntofactoryheader ON was_returntofactoryheader.intStyleId = O.intStyleId
			WHERE
			O.strStyle='$po';";
		//echo $sql;
	 $result = $db->RunQuery($sql);
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<sNo><![CDATA[" . $row["intStyleId"]  . "]]></sNo>\n";
	 }
	$ResponseXML .= "</Styles>";
	echo $ResponseXML;	
}


/*if (strcmp($RequestType,"LoadGrid") == 0)
{
$ResponseXML	= "<Grid>";
$factoryID 		= $_GET["factoryID"];
$styleNo 		= $_GET["styleNo"];
$cutNo 			= $_GET["cutNo"];

$dateFrom 		= $_GET["dateFrom"];
if($dateFrom!="")
{
	$AppDateFromArray	= explode('/',$dateFrom);
	$GPTransferInDateT;
	$dateFrom = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
}
$dateTo 		= $_GET["dateTo"];
if($dateTo!="")
{
	$AppDateToArray		= explode('/',$dateTo);
	$GPTransferInDateT;
	$dateTo = $AppDateToArray[2]."-".$AppDateToArray[1]."-".$AppDateToArray[0];
}

	$sql = "SELECT O.strOrderNo,O.strStyle,PFGH.intGPnumber,PFGH.intGPYear,PFGH.dtmGPDate,PFGH.dblTotQty,C.strName FROM productionfggpheader PFGH inner join orders O on O.intStyleId=PFGH.intStyleId inner join companies C on C.intCompanyID=PFGH.strToFactory WHERE PFGH.strFromFactory = '$companyId'";
if($factoryID!="")
 	 $sql .= " AND PFGH.strToFactory = '".$factoryID."'";
if($styleNo!="")
  	$sql .= " AND PFGH.intStyleId = '".$styleNo."'";
if($dateFrom!="")
 	 $sql .= " AND PFGH.dtmGPDate >= '".$dateFrom."'";
if($dateTo!="")
  	$sql .= " AND PFGH.dtmGPDate <= '".$dateTo."'";
 
  	$sql .= "  ORDER BY PFGH.intGPYear,PFGH.intGPnumber DESC";
	
	//echo $sql;
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$ResponseXML .= "<Serial><![CDATA[" . $row["intGPnumber"]  . "]]></Serial>\n";
		$ResponseXML .= "<Year><![CDATA[" . $row["intGPYear"]  . "]]></Year>\n";
		$ResponseXML .= "<date><![CDATA[" .  $row["dtmGPDate"]  . "]]></date>\n";
		$ResponseXML .= "<TotQty><![CDATA[" . $row["dblTotQty"]  . "]]></TotQty>\n";
		$ResponseXML .= "<OrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></OrderNo>\n";
		$ResponseXML .= "<StyleNo><![CDATA[" . $row["strStyle"]  . "]]></StyleNo>\n";
		$ResponseXML .= "<ToFactory><![CDATA[" . $row["strName"]  . "]]></ToFactory>\n";
	}	 
$ResponseXML .= "</Grid>";
echo $ResponseXML;	
}*/