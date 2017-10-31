<?php	
	session_start();
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	include "../Connector.php";
	$request	= $_GET["request"];
	$companyId	= $_SESSION["FactoryID"];
	
if($request=='loadBPO') 
{	
		$styleId	= $_GET["styleId"];
			$SQL="SELECT distinct M.strBuyerPONO FROM materialratio M where M.intStyleId='$styleId' order by  strBuyerPONO ASC";			
			$result =$db->RunQuery($SQL);
			$responseXml ="<BuyerPo>";
				while ($row=mysql_fetch_array($result))
				{	
					if($row["strBuyerPONO"]=="#Main Ratio#")
						$buyerPoName = $row["strBuyerPONO"];
					else
						$buyerPoName = GetBuyerPoName($row["strBuyerPONO"]);
						
					$responseXml .= "<BuyerPoName><![CDATA[" . $buyerPoName  . "]]></BuyerPoName>\n";
					$responseXml .= "<BuyerPONO><![CDATA[" . $row["strBuyerPONO"]  . "]]></BuyerPONO>\n";			
				}
			$responseXml.="</BuyerPo>";			
echo $responseXml;
}

if($request=='loadSubStores') 
{			$mainStore	= $_GET["mainStore"];
			$SQL="SELECT  substores.strSubID, substores.strSubStoresName  FROM `substores` 
			WHERE substores.strMainID ='$mainStore'";
				$result =$db->RunQuery($SQL);
			
			$responseXml="<data>";
			$responseXml.="<SubStore>";
				while ($row=mysql_fetch_array($result))
				{		
				$responseXml .= "<SubStoreName><![CDATA[" . $row["strSubStoresName"]  . "]]></SubStoreName>\n";
				$responseXml .= "<SubStoreId><![CDATA[" . $row["strSubID"]  . "]]></SubStoreId>\n";
				
				}
			$responseXml.="</SubStore>";
			$responseXml.="</data>";
echo $responseXml;
}


if($request=='loadLocatoion') 
{			$mainStore	= $_GET["mainStore"];
			$subStore	= $_GET["subStore"];
			$SQL="SELECT storeslocations.strLocID, storeslocations.strLocName FROM `storeslocations` 
				WHERE storeslocations.strMainID ='$mainStore' AND storeslocations.strSubID =  '$subStore' AND storeslocations.intStatus =  '1'";
				$result =$db->RunQuery($SQL);
			
			$responseXml="<data>";
			$responseXml.="<LocationData>";
				while ($row=mysql_fetch_array($result))
				{		
				$responseXml .= "<LocName><![CDATA[" . $row["strLocName"]  . "]]></LocName>\n";
				$responseXml .= "<LocID><![CDATA[" . $row["strLocID"]  . "]]></LocID>\n";
				
				}
			$responseXml.="</LocationData>";
			$responseXml.="</data>";
echo $responseXml;
}



if($request=='loadBin') 
{			$mainStore	= $_GET["mainStore"];
			$subStore	= $_GET["subStore"];
			$location	= $_GET["location"];
			$SQL="SELECT storesbins.strBinID, storesbins.strBinName FROM `storesbins` 
				WHERE storesbins.strMainID =  '$mainStore' AND storesbins.strSubID =  '$subStore' 
				AND storesbins.strLocID =  '$location' and intStatus='1' ";
				
				$result =$db->RunQuery($SQL);
			
			$responseXml="<data>";
			$responseXml.="<BinData>";
				while ($row=mysql_fetch_array($result))
				{		
				$responseXml .= "<BinName><![CDATA[" . $row["strBinName"]  . "]]></BinName>\n";
				$responseXml .= "<BinID><![CDATA[" . $row["strBinID"]  . "]]></BinID>\n";
				
				}
			$responseXml.="</BinData>";
			$responseXml.="</data>";
echo $responseXml;
}
if($request=='LoadSourceBinDetails')
{
$styleId		= $_GET["styleId"];
$buyerPoNo		= $_GET["buyerPoNo"];
$mainStore		= $_GET["mainStore"];

$ResponseXML  	= "<LoadSourceBinDetails>\n";

$sql="	SELECT SP.intSRNO,
			ST.intStyleId,
			O.strStyle,
			MIL.intItemSerial as itemCode,
			MIL.strItemDescription,
			ST.strColor,
			ST.strSize,
			ST.strUnit as unit,
			sum(ST.dblQty) as TotalQty
			FROM
			stocktransactions ST
			Inner Join matitemlist MIL ON MIL.intItemSerial = ST.intMatDetailId
			Inner Join specification SP ON SP.intStyleId= ST.intStyleId
			inner join orders O on O.intStyleId=ST.intStyleId
			WHERE
			ST.intStyleId =  '$styleId' AND
			ST.strBuyerPoNo =  '$buyerPoNo' AND
			ST.strMainStoresID =  '$mainStore'
			GROUP BY
			ST.intStyleId,
			ST.strBuyerPoNo,
			ST.intMatDetailId,
			ST.strColor,
			ST.strSize";
			//echo $sql;	 
	$result =$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
	$TotalQty	= $row["TotalQty"];
		if($TotalQty>0){
		$ResponseXML .= "<ScNo><![CDATA[" . $row["intSRNO"]  . "]]></ScNo>\n";
		$ResponseXML .= "<StyleName><![CDATA[" . $row["strStyle"]  . "]]></StyleName>\n";
		$ResponseXML .= "<styleNo><![CDATA[" . $row["intStyleId"]  . "]]></styleNo>\n";
		$ResponseXML .= "<matDetailId><![CDATA[" . $row["itemCode"]  . "]]></matDetailId>\n";
		$ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDescription>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<Size><![CDATA[" . $row["strSize"]  . "]]></Size>\n";
		$ResponseXML .= "<stockQty><![CDATA[" . $row["TotalQty"]  . "]]></stockQty>\n";
		$ResponseXML .= "<Units><![CDATA[" . $row["unit"]  . "]]></Units>\n";
		}
	}
$ResponseXML   .= "</LoadSourceBinDetails>";
echo $ResponseXML;
}
if($request=="validateBinAllocation")
{
$matDetailsId		= $_GET["matDetailsId"];
$destMainStoreId	= $_GET["destMainStoreId"];
$destSubStoreId		= $_GET["destSubStoreId"];
$destLocationId		= $_GET["destLocationId"];
$destBinId			= $_GET["destBinId"];

$ResponseXML  		= "<validateBinAllocation>\n";

$sql_1="select intSubCatID,StrCatName,intMainCatID from matitemlist MIL
inner join matsubcategory MSC on MSC.intSubCatNo=MIL.intSubCatID
 where intItemSerial='$matDetailsId'";	
$result_1=$db->RunQuery($sql_1);	
$row_1	= mysql_fetch_array($result_1);
	$matCatId =$row_1["intSubCatID"];
	$matCatName =$row_1["StrCatName"];
	$matMainCategoryId =$row_1["intMainCatID"];

$sql="select strMainID from storesbinallocation 
	where strMainID='$destMainStoreId'
	and strSubID='$destSubStoreId'
	and strLocID='$destLocationId'
	and strBinID='$destBinId'
	and intSubCatNo='$matCatId'";	
		
	$result =$db->RunQuery($sql);
	$rowCount = mysql_num_rows($result);
	//echo $rowCount;
	if($rowCount==0)
		$ResponseXML .= "<Validate><![CDATA[TRUE]]></Validate>\n";
	else		
		$ResponseXML .= "<Validate><![CDATA[FALSE]]></Validate>\n";
		
	$ResponseXML .= "<MatCatName><![CDATA[" . $matCatName . "]]></MatCatName>\n";
	$ResponseXML .= "<matMainCategoryId><![CDATA[" . $matMainCategoryId . "]]></matMainCategoryId>\n";	
$ResponseXML   .= "</validateBinAllocation>";
echo $ResponseXML;
}
elseif($request=="GetNo")
{		
    $No=0;
	$ResponseXML .="<LoadNo>\n";
	
		$Sql="select intCompanyID,dblSBinToBinTransNo from syscontrol where intCompanyID='$companyId'";
		 
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{						
					$No=$row["dblSBinToBinTransNo"];
					$NextNo=$No+1;
					$sqlUpdate="UPDATE syscontrol SET dblSBinToBinTransNo='$NextNo' WHERE intCompanyID='$companyId';";				
					$db->executeQuery($sqlUpdate);
					$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
					$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";					
				}
				
		}
		else
		{
			$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
		}	
	$ResponseXML .="</LoadNo>";
	echo $ResponseXML;
}
else if ($request=="SaveValidate")
{
	
	$no					= $_GET["no"];
	$year				= date("Y");			
	$validateCount 	= $_GET["validateCount"];	
	
	$ResponseXML ="<SaveValidate>\n";
	
		$SQL="SELECT COUNT(intDocumentNo) AS countIn FROM stocktransactions where intDocumentNo=$no AND intDocumentYear=$year and strType='BINTRIN'";	
	
	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$countIn=$row["countIn"];		
		 
			if($countIn==$validateCount)
			{
				$ResponseXML .= "<recCountBinInDetails><![CDATA[TRUE]]></recCountBinInDetails>\n";
			}
			else
			{
				$ResponseXML .= "<recCountBinInDetails><![CDATA[FALSE]]></recCountBinInDetails>\n";
			}
	}
	
	$SQL="SELECT COUNT(intDocumentNo) AS countOut FROM stocktransactions where intDocumentNo=$no AND intDocumentYear=$year and strType='BINTROUT'";	

	$result=$db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
		$countOut=$row["countOut"];		
		
			if($countOut==$validateCount)
			{
				$ResponseXML .= "<recCountBinOutDetails><![CDATA[TRUE]]></recCountBinOutDetails>\n";
			}
			else
			{
				$ResponseXML .= "<recCountBinOutDetails><![CDATA[FALSE]]></recCountBinOutDetails>\n";
			}
	}
	
	$ResponseXML .="</SaveValidate>";
	echo $ResponseXML;
}
function GetBuyerPoName($buyerPoId)
{
global $db;
$sql ="SELECT strBuyerPoName FROM style_buyerponos where strBuyerPONO='$buyerPoId'";
$result=$db->RunQuery($sql);
$row = mysql_fetch_array($result);
return $row["strBuyerPoName"];
}
?>