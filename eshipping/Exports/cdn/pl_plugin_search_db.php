<?php
session_start();
$backwardseperator = "../../";
include "$backwardseperator".''."Connector.php";
header('Content-Type: text/xml'); 	
$request=$_GET["request"];

if ($request=='load_pl_grid')
{
	
	$plno		=$_GET["plno"];
	$ponumber	=$_GET["ponumber"];
	$style		=$_GET["style"];
	$ISD		=$_GET["ISD"];
	$DO			=$_GET["DO"];
		
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$style=$_GET['style'];
	$str="select 	strPLNo, 
					strSailingDate, 
					strStyle, 
					strProductCode, 
					strMaterial, 
					strFabric, 
					strLable, 
					strColor, 
					strISDno, 
					strPrePackCode, 
					strSeason, 
					strDivision, 
					strCTNsvolume, 
					strWashCode, 
					strArticle, 
					strCBM, 
					strItemNo, 
					strItem, 
					strManufactOrderNo, 
					strManufactStyle, 
					strDO, 
					strSortingType, 
					strFactory, 
					strUnit
					 
					from 
					shipmentplheader
					where strPLNo!='' AND intCDNStatus=0 " ;
					
	if($plno!="")
		$str.=" and strPLNo='$plno'";
	if($ponumber!="")
		$str.=" and strStyle='$ponumber'";
	if($style!="")
		$str.=" and strProductCode='$style'";
	if($ISD!="")
		$str.=" and strISDno='$ISD'";
	if($DO!="")
		$str.=" and strDO='$DO'";
		
	$str.="order by strPLNo desc";
	$result=$db->RunQuery($str);
	$xml_string='<data>';
	while($row=mysql_fetch_array($result))
	{	
		
		$pldate		 =$row["strSailingDate"];
		$xml_string .= "<po><![CDATA[" . $row["strStyle"]  . "]]></po>\n";
		$xml_string .= "<ProductCode><![CDATA[" . $row["strProductCode"]   . "]]></ProductCode>\n";	
		$xml_string .= "<PLNo><![CDATA[" . $row["strPLNo"]   . "]]></PLNo>\n";	
		$xml_string .= "<ISDno><![CDATA[" . $row["strISDno"]   . "]]></ISDno>\n";	
		$xml_string .= "<DO><![CDATA[" . $row["strDO"]   . "]]></DO>\n";
		$xml_string .= "<pldate><![CDATA[" . $pldate   . "]]></pldate>\n";
		$xml_string .= "<Item><![CDATA[" . $row["strItem"]   . "]]></Item>\n";
		$xml_string .= "<Fabric><![CDATA[" . $row["strFabric"]   . "]]></Fabric>\n";		
	} 
	$xml_string.='</data>';
	echo $xml_string;
}

if ($request=='load_po_str')
{
	$buyerstr="select distinct strStyle from shipmentplheader intCDNStatus=0 order by strStyle";
		
			$buyerresults=$db->RunQuery($buyerstr);
			
			while($buyerrow=mysql_fetch_array($buyerresults))
			{
				$po_arr.=$buyerrow['strStyle']."|";
				 
			}
			echo $po_arr;
}
?>