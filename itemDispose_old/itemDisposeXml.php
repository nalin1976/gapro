<?php 
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["req"];
$companyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];

if($RequestType=="getSubCat")
{
	$mainCat  = $_GET["mainCat"];
	
	$ResponseXML .="<LoadSubCat>\n";
	
	$SQL = "select intSubCatNo,StrCatName 
			from matsubcategory
			 where intCatNo='$mainCat' 
			  order by intSubCatNo ";
			  
	$result =$db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
			$ResponseXML .= "<SubCatId><![CDATA[" . $row["intSubCatNo"]  . "]]></SubCatId>\n";
			$ResponseXML .= "<SubCatName><![CDATA[" . $row["StrCatName"]  . "]]></SubCatName>\n";
	}
	
	$ResponseXML .="</LoadSubCat>";
	echo $ResponseXML;
}
if($RequestType=="loadSubStore")
{
	$mainStore=$_GET['mainStore'];
	$sql_sub="SELECT strSubID,strSubStoresName FROM substores WHERE strMainID='$mainStore';";
	$result=$db->RunQuery($sql_sub);
	//echo $sql_sub;
	$ResponseXML .="<LoadSubStores>\n";
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<strSubID><![CDATA[" . $row["strSubID"]  . "]]></strSubID>\n";
		$ResponseXML .="<strSubStoresName><![CDATA[" . $row["strSubStoresName"]  . "]]></strSubStoresName>\n";
	}
	$ResponseXML .="</LoadSubStores>\n";
	echo $ResponseXML;
}
if($RequestType=="loadListing")
{
	$docNo=$_GET['docNo'];
	$sql_listing="SELECT st.intDocumentNo,o.strStyle,sb.strBuyerPoName,mt.strItemDescription,st.dblQty 
				  FROM stocktransactions st
				  LEFT Join matitemlist AS mt ON st.intMatDetailId = mt.intItemSerial
				  INNER JOIN orders o ON o.intStyleId=st.intStyleId
				  LEFT JOIN style_buyerponos sb ON sb.strBuyerPONO=st.strBuyerPoNo AND sb.intStyleId=o.intStyleId
				  WHERE st.dblQty<0 AND st.intDocumentNo='$docNo' ORDER BY st.intDocumentNo ASC;";
	$result=$db->RunQuery($sql_listing);
	echo $sql_sub;
	$ResponseXML .="<DiposeListing>\n";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .="<DocumentNo><![CDATA[" . $row["intDocumentNo"]  . "]]></DocumentNo>\n";
		$ResponseXML .="<Style><![CDATA[" . $row["strStyle"]  . "]]></Style>\n";
		$ResponseXML .="<BuyerPoName><![CDATA[" . $row["strBuyerPoName"]  . "]]></BuyerPoName>\n";
		$ResponseXML .="<Description><![CDATA[" . $row["strItemDescription"]  . "]]></Description>\n";
		$ResponseXML .="<Qty><![CDATA[" . $row["dblQty"]  . "]]></Qty>\n";
	}
	$ResponseXML .="</DiposeListing>\n";
	echo $ResponseXML;
}
?>