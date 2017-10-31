<?php
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$CompanyId=$_SESSION["FactoryID"];
$UserID=$_SESSION["UserID"];

if($RequestType=="LoadDetails")
{
	$newStyleId =$_GET["newStyleId"];
	$oldStyle =$_GET["oldStyle"];
	
	$ResponseXML .="<LoadMerchandiser>\n";
	
	$SQL ="select strMatDetailID,strItemDescription,strColor,strSize,strBuyerPONO,strUnit ".
 "from materialratio MR  ".
"inner join matitemlist MIL on MIL.intItemSerial=MR.strMatDetailID ".
"where intStyleId='$newStyleId' ".
"order by MIL.intMainCatID,MIL.strItemDescription,strColor,strSize;"; 
 
	$result=$db->RunQuery($SQL);	
	while ($row=mysql_fetch_array($result))
	{	
	/*	$sql_web="select strOldStyleID,dblQty from itemtransfertoweb ".
				"where strOldStyleID='$oldStyle' ".
				"and strBuyerPoNo='".$row["strBuyerPONO"]."' ".
				"and intMatDetailId = '".$row["strMatDetailID"]."' ".
				"and strColor = '".$row["strColor"]."' ".
				"and strSize ='".$row["strSize"]."';"; 
	
		$result_web=$db->RunQuery($sql_web);
		$webCount=mysql_num_rows($result_web);
		if($webCount==0){
			$ResponseXML .= "<Disabled><![CDATA[false]]></Disabled>\n";
		}
		else{
			$ResponseXML .= "<Disabled><![CDATA[true]]></Disabled>\n";
		}*/			
	
		$ResponseXML .="<ItemDescription><![CDATA[".$row["strItemDescription"]."]]></ItemDescription>\n";
		$ResponseXML .="<Color><![CDATA[".$row["strColor"]."]]></Color>\n";
		$ResponseXML .="<Size><![CDATA[".$row["strSize"]."]]></Size>\n";
		$ResponseXML .="<BuyerPONO><![CDATA[".$row["strBuyerPONO"]."]]></BuyerPONO>\n";
		$ResponseXML .="<Unit><![CDATA[".$row["strUnit"]."]]></Unit>\n";
		$ResponseXML .="<MatDetailID><![CDATA[".$row["strMatDetailID"]."]]></MatDetailID>\n";
	}
	$ResponseXML .="</LoadMerchandiser>";
	echo $ResponseXML;
}
elseif($RequestType=="LoadSubStores")
{
$mainStoreId	= $_GET["mainStoreId"];

	$sql="select strSubID,strSubStoresName from substores where strMainID='$mainStoreId' AND intStatus=1 ";	 
	 
	$result = $db->RunQuery($sql);
			echo "<option value =\"".""."\">".""."</option>";
		while($row=mysql_fetch_array($result))
		{	
			echo "<option value=\"".$row["strSubID"]."\">".$row["strSubStoresName"]."</option>";			
		}		

}
elseif($RequestType=="LoadLocation")
{
$mainStoreId	= $_GET["mainStoreId"];
$subStoreId		= $_GET["subStoreId"];

	$sql="select strLocID,strLocName from storeslocations where strMainID='$mainStoreId' AND strSubID='$subStoreId' AND intStatus=1 ";	 
	 
	$result = $db->RunQuery($sql);
			echo "<option value =\"".""."\">".""."</option>";
		while($row=mysql_fetch_array($result))
		{	
			echo "<option value=\"".$row["strLocID"]."\">".$row["strLocName"]."</option>";			
		}		

}
elseif($RequestType=="LoadBins")
{
$mainStoreId	= $_GET["mainStoreId"];
$subStoreId		= $_GET["subStoreId"];
$locationId		= $_GET["locationId"];

	$sql="select strBinID,strBinName from storesbins where strMainID='$mainStoreId' and strSubID='$subStoreId' and strLocID='$locationId' and intStatus=1";	 
	 
	$result = $db->RunQuery($sql);
			echo "<option value =\"".""."\">".""."</option>";
		while($row=mysql_fetch_array($result))
		{	
			echo "<option value=\"".$row["strBinID"]."\">".$row["strBinName"]."</option>";			
		}		

}
?>
