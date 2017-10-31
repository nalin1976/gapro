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
	wash_finishreceive.intStyleId, 
	orders.strStyle,
	orders.strOrderNo 
	FROM
	  wash_finishreceive LEFT JOIN orders ON wash_finishreceive.intStyleId = orders.intStyleId
	 ";
	  if($factoryID!="")
 	 $sql .=" WHERE orders.intCompanyID = '".$factoryID."' ";
  
	  $sql .="group by wash_finishreceive.intStyleId 
	  order by orders.strStyle ASC";

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
if (strcmp($RequestType,"LoadGrid") == 0)
{
	$ResponseXML= "<Grid>";
	$factoryID = $_GET["factoryID"];
	$styleNo = $_GET["styleNo"];
	$cutNo = $_GET["cutNo"];
	
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
	 wash_finishreceive.intWashFinRecNO, 
	 wash_finishreceive.intWashFinRecYear, 
	 wash_finishreceive.dtmReceiveDate, 
	 wash_finishreceive.dblQty 
	 
	  FROM wash_finishreceive 
	  JOIN orders ON wash_finishreceive.intStyleId=orders.intStyleId
	  WHERE
	  
  orders.intCompanyID != '#'";
   if($factoryID!="")
  $sql .=" AND orders.intCompanyID = '".$factoryID."'";
   if($styleNo!="")
  $sql .=" AND wash_finishreceive.intStyleId = '".$styleNo."'";
   if($dateFrom!="")
  $sql .=" AND wash_finishreceive.dtmReceiveDate >= '".$dateFrom."'";
   if($dateTo!="")
  $sql .=" AND wash_finishreceive.dtmReceiveDate <= '".$dateTo."'";
 
  $sql .="  ORDER BY wash_finishreceive.intWashFinRecNO DESC";
 
//echo $sql;
     global $db;
	  $result = $db->RunQuery($sql);
	 while($row = mysql_fetch_array($result))
	 {
		$ResponseXML .= "<Serial><![CDATA[" . $row["intWashFinRecNO"]  . "]]></Serial>\n";
		$ResponseXML .= "<Year><![CDATA[" . $row["intWashFinRecYear"]  . "]]></Year>\n";
		$ResponseXML .= "<date><![CDATA[" .  $row["dtmReceiveDate"]  . "]]></date>\n";
		$ResponseXML .= "<TotQty><![CDATA[" . $row["dblQty"]  . "]]></TotQty>\n";
	 }
	 
	 $ResponseXML .= "</Grid>";
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

