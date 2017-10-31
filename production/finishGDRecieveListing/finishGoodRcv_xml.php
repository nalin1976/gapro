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
	
	$sql = "SELECT 
	productionfinishedgoodsreceiveheader.intStyleNo, 
	orders.strStyle,
	orders.strOrderNo 
	FROM
	  productionfinishedgoodsreceiveheader  LEFT JOIN orders ON productionfinishedgoodsreceiveheader.intStyleNo = orders.intStyleId
	 ";
	  if($factoryID!="")
 	 $sql .=" WHERE productionfinishedgoodsreceiveheader.strTComCode = '".$factoryID."' ";
  
	  $sql .="group by productionfinishedgoodsreceiveheader.intStyleNo 
	  order by productionfinishedgoodsreceiveheader.intStyleNo ASC";

	  global $db;
	  $result = $db->RunQuery($sql);
	  $k=0;
		
	 $ResponseXML1 .= "<style>";
	 $ResponseXML1 .= "<![CDATA[";
	 $ResponseXML1 .="<option value = \"". "" . "\">" . "Select One" . "</option>" ;
		
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML1 .= "<option value=\"". $row["intStyleNo"] ."\">" . $row["strStyle"] ."</option>";
			
		$k++;
	 }
	$ResponseXML1 .= "]]>"."</style>";
	 
	 $ResponseXML = $ResponseXML.$ResponseXML1. "</Styles>";
	 echo $ResponseXML;	
}
//----------------------------------Load Grid ----------------------------------------------
if (strcmp($RequestType,"LoadGrid") == 0)
{
	$ResponseXML= "<Grid>";
	$factoryID = $_GET["factoryID"];
	$styleNo = $_GET["styleNo"];
	$cutNo = $_GET["cutNo"];
	$gpNO	=	$_GET['GPNo'];
	$dateFrom = $_GET["dateFrom"];
   if($dateFrom!=""){
	$AppDateFromArray		= explode('/',$dateFrom);
	$GPTransferInDateT;
	$dateFrom = $AppDateFromArray[2]."-".$AppDateFromArray[1]."-".$AppDateFromArray[0];
	}
	$dateTo = $_GET["dateTo"];
   if($dateTo!=""){
	$AppDateToArray		= explode('/',$dateTo);
	$GPTransferInDateT;
	$dateTo = $AppDateToArray[2]."-".$AppDateToArray[1]."-".$AppDateToArray[0];
	}

	
	 $sql = "SELECT 
	 productionfinishedgoodsreceiveheader.dblTransInNo, 
	 productionfinishedgoodsreceiveheader.intGPTYear, 
	 productionfinishedgoodsreceiveheader.dtmTransInDate, 
	 productionfinishedgoodsreceiveheader.dblTotQty 
	  FROM productionfinishedgoodsreceiveheader 
	  WHERE
  productionfinishedgoodsreceiveheader.strTComCode != '#'";
   if($factoryID!="")
  $sql .=" AND productionfinishedgoodsreceiveheader.strTComCode = '".$factoryID."'";
   if($styleNo!="")
  $sql .=" AND productionfinishedgoodsreceiveheader.intStyleNo = '".$styleNo."'";
   if($dateFrom!="")
  $sql .=" AND productionfinishedgoodsreceiveheader.dtmTransInDate >= '".$dateFrom."'";
   if($dateTo!="")
  $sql .=" AND productionfinishedgoodsreceiveheader.dtmTransInDate <= '".$dateTo."'";
   if($gpNO!=""){
	$GPNo=explode('/',$gpNO);
  	$sql.=" AND productionfinishedgoodsreceiveheader.dblGatePassNo =  '".$GPNo[1]."' AND productionfinishedgoodsreceiveheader.intGPYear =  '".$GPNo[0]."'";
	}
   
  $sql .="  ORDER BY productionfinishedgoodsreceiveheader.dblTransInNo DESC";
 
//echo $sql;
     global $db;
	  $result = $db->RunQuery($sql);
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<Serial><![CDATA[" . $row["dblTransInNo"]  . "]]></Serial>\n";
		$ResponseXML .= "<Year><![CDATA[" . $row["intGPTYear"]  . "]]></Year>\n";
		$ResponseXML .= "<date><![CDATA[" .  $row["dtmTransInDate"]  . "]]></date>\n";
		$ResponseXML .= "<TotQty><![CDATA[" . $row["dblTotQty"]  . "]]></TotQty>\n";
	 }
	 
	 $ResponseXML .= "</Grid>";
	 echo $ResponseXML;	
}

if(strcmp($RequestType,"loadStyleNo") ==0){
	
	$ResponseXML= "<Styles>";
	$po = $_GET["po"];
	$sql="SELECT DISTINCT orders.strStyle FROM productionfinishedgoodsreceiveheader
			INNER JOIN orders ON orders.intStyleId = productionfinishedgoodsreceiveheader.intStyleNo
			WHERE
			orders.intStyleId='$po';";
	 $result = $db->RunQuery($sql);
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<sNo><![CDATA[" . $row["strStyle"]  . "]]></sNo>\n";
	 }
	$ResponseXML .= "</Styles>";
	echo $ResponseXML;	
}
if(strcmp($RequestType,"loadPoNo") ==0){
	
	$ResponseXML= "<Styles>";
	$po = $_GET["po"];
	$sql="SELECT DISTINCT orders.intStyleId FROM productionfinishedgoodsreceiveheader
			INNER JOIN orders ON orders.intStyleId = productionfinishedgoodsreceiveheader.intStyleNo
			WHERE
			orders.strStyle='$po';";
	 $result = $db->RunQuery($sql);
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<sNo><![CDATA[" . $row["intStyleId"]  . "]]></sNo>\n";
	 }
	$ResponseXML .= "</Styles>";
	echo $ResponseXML;	
}

/*
$request=	$_GET['req'];
$toFac	=	$_GET['toFac'];
$gpNo	=	$_GET['gpNO'];
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($request=="loadGPNo")
{
	$sql_gpNo="SELECT pgh.intGPnumber
				FROM productiongpheader pgh
				WHERE -- pgh.intStatus='' AND 
				pgh.intTofactory='$toFac';";
				//echo $sql_gpNo;
	$res_gpNo=$db->RunQuery($sql_gpNo);
	$ResponseXML .= "<GatePassNo>";
	while($row=mysql_fetch_array($res_gpNo))
	{
		$ResponseXML .= "<gpNumber><![CDATA[" . $row["intGPnumber"] . "]]></gpNumber>\n";
	}
	$ResponseXML .= "</GatePassNo>";
	echo $ResponseXML;
	
}

if($request=="loadDet")
{
	$sql_loadDet="SELECT pgh.intGPnumber,o.strStyle,pgh.dtmDate,pgh.dblTotQty 
	FROM productiongpheader pgh
	INNER JOIN orders o ON o.intStyleId=pgh.intStyleId
	WHERE -- pgh.intStatus='' AND 
	pgh.intTofactory='$toFac'";
	
	if(!empty($gpNo)){
		$sql_loadDet .= " AND pgh.intGPnumber='$gpNo'";
	}
	$sql_loadDet .=";";
	
	//echo $sql_loadDet;
	
	$res_Det=$db->RunQuery($sql_loadDet);
	$ResponseXML .= "<Det>";
	while($row=mysql_fetch_array($res_Det))
	{
		$ResponseXML .= "<gpNumber><![CDATA[" . $row["intGPnumber"] . "]]></gpNumber>\n";
		$ResponseXML .= "<strStyle><![CDATA[" . $row["strStyle"] . "]]></strStyle>\n";
		$ResponseXML .= "<dtmDate><![CDATA[" . $row["dtmDate"] . "]]></dtmDate>\n";
		$ResponseXML .= "<dblTotQty><![CDATA[" . $row["dblTotQty"] . "]]></dblTotQty>\n";
	}
	$ResponseXML .= "</Det>";
	echo $ResponseXML;
	
	
	
}
*/

